<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "places";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
@set_time_limit(0);
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );

$placesearch_url = getURL( "placesearch", 1 );
$places_all_url = getURL( "places-all", 1 );
$places_url = getURL( "places", 1 );
$places_oneletter_url = getURL( "places-oneletter", 1 );

$decodedfirstchar = $firstchar ? stripslashes(urldecode($firstchar)) : stripslashes($psearch);

$wherestr = "";
$offsetorg = $offset;
$offset = $offset ? $offset + 1 : 1;

if( $firstchar )
	$wherestr .= "trim(substring_index(place,',',-$offset)) LIKE \"$firstchar%\"";
if( $psearch ) {
	if( $wherestr ) $wherestr .= " AND ";
	$psearchslashed = get_magic_quotes_gpc() == 0 ? addslashes($psearch) : $psearch;
	$wherestr .= $offsetorg ? "trim(substring_index(place,',',-$offsetorg)) = \"$psearchslashed\"" : "place LIKE \"%$psearch%\"";
}
if( $tree ) {
	if( $wherestr ) $wherestr .= " AND ";
	$wherestr .= " gedcom = \"$tree\"";
	$wherestr2 = " AND gedcom = \"$tree\"";
}
else
	$wherestr2 = "";
if( $wherestr ) $wherestr = "WHERE $wherestr";

//if doing a locality search, link directly to placesearch
if( $stretch ) {
	$query = "SELECT distinct place as myplace, place as wholeplace, count( distinct place ) as placecount, gedcom FROM $places_table $wherestr GROUP BY myplace ORDER by myplace";
	$places_oneletter_url = getURL( "placesearch", 1 );
}
else {
	$query = "SELECT distinct trim(substring_index(place,',',-$offset)) as myplace, trim(place) as wholeplace, count(distinct place) as placecount, gedcom FROM $places_table $wherestr GROUP BY myplace ORDER by myplace";
	$places_oneletter_url = getURL( "places-oneletter", 1 );
}

$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( mysql_num_rows( $result ) == 1 ) {
	$row = mysql_fetch_assoc( $result );
	if( $row[myplace] == $psearch )
        header("Location: ". getURL( "placesearch", 1 )."tree=$tree&psearch=$psearch&oper=eq");
	else
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
}

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$places_oneletter_url" . "firstchar=$firstchar&amp;psearch=$psearch&amp;tree=$tree\">$text[placelist]: $decodedfirstchar$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

$displaychar = $decodedfirstchar ? $decodedfirstchar : $text[all];
tng_header( "$text[placelist]: $displaychar", $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_place.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo "$text[placelist]: $displaychar"; ?><br clear="all" /></p>
<?php
echo tng_coreicons();

$hiddenfields[] = array('name' => 'firstchar', 'value' => $firstchar);
$hiddenfields[] = array('name' => 'psearch', 'value' => $psearch);
$hiddenfields[] = array('name' => 'offset', 'value' => $offsetorg);
echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'places-oneletter', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields));

echo "<ul class=\"normal\">\n";

//Top 100 area
echo "<li>\n";
echo getFORM( "places100", "get", "", "" );
echo "$text[showtop] <input type=\"text\" name=\"topnum\" value=\"100\" size=\"4\" maxlength=\"4\" />\n";
echo "$text[byoccurrence] <input type=\"hidden\" name=\"tree\" value=\"$tree\" />\n";
echo "<input type=\"submit\" value=\"$text[go]\" />\n";
echo "</form></li>\n";

//Show All area
echo "<li><a href=\"$places_all_url" . "tree=$tree\">$text[showallplaces]</a> ($text[sortedalpha])</li>\n";

//Main places link
echo "<li><a href=\"$places_url" . "tree=$tree\">$text[mainplacepage]</a></li>";

//any place search form
echo "<li>\n";
echo getFORM( "places-oneletter", "get", "", "" );
echo "$text[placescont]: <input type=\"text\" name=\"psearch\" />\n";
echo "<input type=\"hidden\" name=\"tree\" value=\"$tree\" />\n";
echo "<input type=\"hidden\" name=\"stretch\" value=\"1\" />\n";
echo "<input type=\"submit\" name=\"pgo\" value=\"$text[go]\" />\n";
echo "</form></li>\n";

echo "</ul>\n";

echo "<p class=\"normal\">$text[placelist]: $decodedfirstchar, $text[sortedalpha] ($text[numoccurrences]):<br/></p>";
?>

<p class="normal"><b><?php echo $text[showmatchingplaces]; ?></b></p>

<table border="0" cellspacing="0" cellpadding="0">
	<tr><td valign="top"><span class="normal">
<?php
if( $result ) {
	$snnum = 1;
	$num_in_col = 20;
	$numrows = mysql_num_rows($result);
	$numcols = floor($numrows / $num_in_col);
	if( $numcols > 3 ) {
		$numcols = 3;
		$num_in_col = ceil($numrows / 3 );
	}
	
	$num_in_col_ctr = 0;
	while( $place = mysql_fetch_assoc( $result ) ) {
		$place2 = urlencode( $place[myplace] );
		if( $place2 ) {
			$commaOnEnd = false;
			$poffset = $stretch ? "" : "offset=$offset&amp;";
			if(substr($place[wholeplace],0,1) == ',' && trim(substr($place[wholeplace],1)) == $place[myplace]) {
				$place3 = addslashes($place[wholeplace]);
				$commaOnEnd = true;
				$place2 = urlencode($place[wholeplace]);
				$placetitle = $place[wholeplace];
			}
			else {
				$place3 = addslashes($place[myplace]);
				$placetitle = $place[myplace];
			}

			$query = "SELECT count(distinct place) as placecount FROM $places_table WHERE place = \"$place3\" $wherestr2";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$countrow = mysql_fetch_assoc($result2);
			$specificcount = $countrow[placecount];
			mysql_free_result($result2);

			$searchlink = $specificcount ? " <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=$place2\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\"></a>" : "";
			if( $place[placecount] > 1 || ($place[myplace] != $place[wholeplace] && !$commaOnEnd) ) {
				$name = "<a href=\"$places_oneletter_url" . $poffset;
				if($tree) $name .= "tree=$place[gedcom]&amp;";
				$name .= "psearch=$place2\">" . str_replace(array("<",">"), array("&lt;","&gt;"), $place[myplace]) . "</a>";
				echo "$snnum. $name ($place[placecount])$searchlink<br/>\n";
			}
			else
				echo "$snnum. $placetitle$searchlink<br/>\n";
			$snnum++;
			$num_in_col_ctr++;
			if( $num_in_col_ctr == $num_in_col ) {
				echo "</span></td>\n<td>&nbsp;&nbsp;</td>\n<td valign=\"top\"><span class=\"normal\">";
				$num_in_col_ctr = 0;
			}
		}
	}
	mysql_free_result($result);
}
?>
	</span></td></tr>
</table>
<br/>
<?php
tng_footer( "" );
?>
