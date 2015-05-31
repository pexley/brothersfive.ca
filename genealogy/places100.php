<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "places";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );

$placesearch_url = getURL( "placesearch", 1 );
$places_all_url = getURL( "places-all", 1 );
$places_url = getURL( "places", 1 );
$places_oneletter_url = getURL( "places-oneletter", 1 );
$places100_url = getURL( "places100", 1 );

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$places100_url" . "topnum=$topnum&amp;tree=$tree\">" . xmlcharacters("$text[placelist] &mdash; $text[top] $topnum$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( "$text[placelist] &mdash; $text[top] $topnum", $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_place.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?echo "$text[placelist]: $text[top] $topnum"; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'places100', 'method' => 'get', 'name' => 'form1', 'id' => 'form1'));

echo "<ul class=\"normal\">\n";

//Top 100 area
echo "<li>\n";
echo getFORM( "places100", "get", "", "" );
echo "$text[showtop] <input type=\"text\" name=\"topnum\" value=\"$topnum\" size=\"4\" maxlength=\"4\" />\n";
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
?>

<p><b><?php echo $text[showmatchingplaces]; ?></b></p>

<table border="0" cellspacing="0" cellpadding="0">
	<tr><td valign="top"><span class="normal">
<?php
if( $tree )
	$wherestr = " AND gedcom = \"$tree\"";
else 
	$wherestr = "";
if( $psearch )
	$wherestr .= " AND trim(substring_index(place,',',-$offset)) = \"$psearch\"";
	
$offsetorg = $offset;
$offset = $offset ? $offset + 1 : 1;
$offsetplus = $offset + 1;

$topnum = $topnum ? $topnum : 100;
$query = "SELECT distinct trim(substring_index(place,',',-$offset)) as myplace, count(distinct place) as placecount FROM $places_table WHERE trim(substring_index(place,',',-$offset)) != \"\" $wherestr GROUP BY myplace ORDER by placecount DESC, myplace LIMIT $topnum";

$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$topnum = mysql_num_rows($result);
if( $result ) {
	$counter = 1;
	$num_in_col = 20;
	$numcols = floor($topnum / $num_in_col);
	if( $numcols > 3 ) {
		$numcols = 3;
		$num_in_col = ceil($topnum / 4 );
	}
	
	$num_in_col_ctr = 0;
	$noplace = urlencode($text[noplace]);
	while( $place = mysql_fetch_assoc( $result ) ) {
		$place2 = urlencode( $place[myplace] );

		$query = "SELECT count(distinct place) as placecount FROM $places_table WHERE place = \"" . addslashes($place[myplace]) . "\" $wherestr";
		$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$countrow = mysql_fetch_assoc($result2);
		$specificcount = $countrow[placecount];
		mysql_free_result($result2);

		$searchlink = $specificcount ? " <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=$place2\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"\" width=\"9\" height=\"9\"></a>" : "";
		if( $place[placecount] > 1 || !$specificcount) {
			$name = "<a href=\"$places_oneletter_url" . "offset=$offset&amp;tree=$tree&amp;psearch=$place2\">$place[myplace]</a>";
			echo "$counter. $name ($place[placecount]) $searchlink<br/>\n";
		}
		else
			echo "$counter. $place[myplace] $searchlink<br/>\n";
		$counter++;
		$num_in_col_ctr++;
		if( $num_in_col_ctr == $num_in_col ) {
			echo "</span></td>\n<td>&nbsp;&nbsp;</td>\n<td valign=\"top\"><span class=\"normal\">";
			$num_in_col_ctr = 0;
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
