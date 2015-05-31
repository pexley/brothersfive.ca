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
$places_oneletter_url = getURL( "places-oneletter", 1 );
$places_all_url = getURL( "places-all", 1 );
$places_url = getURL( "places", 1 );

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$places_url" . "tree=$tree\">$text[placelist]$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( $text[placelist], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_place.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text[placelist]; ?><br clear="all" /></p>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'places', 'method' => 'get', 'name' => 'form1', 'id' => 'form1'));

echo "<ul  class=\"normal\">\n";

//Top 100 area
echo "<li>\n";
echo getFORM( "places100", "get", "", "" );
echo "$text[showtop] <input type=\"text\" name=\"topnum\" value=\"100\" size=\"4\" maxlength=\"4\" />\n";
echo "$text[byoccurrence] <input type=\"hidden\" name=\"tree\" value=\"$tree\" />\n";
echo "<input type=\"submit\" value=\"$text[go]\" />\n";
echo "</form></li>\n";

//Show All area
echo "<li><a href=\"$places_all_url" . "tree=$tree\">$text[showallplaces]</a> ($text[sortedalpha])</li>\n";

//any place search form
echo "<li>\n";
echo getFORM( "places-oneletter", "get", "", "" );
echo "$text[placescont]: <input type=\"text\" name=\"psearch\" />\n";
echo "<input type=\"hidden\" name=\"tree\" value=\"$tree\" />\n";
echo "<input type=\"hidden\" name=\"stretch\" value=\"1\" />\n";
echo "<input type=\"submit\" name=\"pgo\" value=\"$text[go]\" />\n";
echo "</form></li>\n";

echo "</ul>\n";

$linkstr = "";
$linkstr2col1 = "";
$linkstr2col2 = "";
$linkstr3col1 = "";
$linkstr3col2 = "";

$offsetorg = $offset;
$offset = $offset ? $offset + 1 : 1;
if( $tree )
	$wherestr = "AND gedcom = \"$tree\"";
else 
	$wherestr = "";

$query = "SELECT distinct ucase(left(trim(substring_index(place,',',-$offset)),1)) as firstchar FROM $places_table WHERE trim(substring_index(place,',',-$offset)) != \"\" $wherestr GROUP BY firstchar ORDER by firstchar";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$initialchar = 1;
	
	while( $place = mysql_fetch_assoc( $result ) ) {
		if( $initialchar != 1 ) { 
			$linkstr .= "&nbsp;";
		}
		if( $place[firstchar] != "" ) {
			$urlfirstchar = urlencode($place[firstchar]);
			$linkstr .= "<a href=\"$places_oneletter_url" . "firstchar=$urlfirstchar&amp;tree=$tree&amp;offset=$offsetorg&amp;psearch=$psearch\" class=\"snlink\" title=\"$text[placesstarting]: $place[firstchar]\">$place[firstchar]</a>";
		}
		$initialchar++;
	}
	mysql_free_result($result);
}

$query = "SELECT distinct ucase(left(trim(substring_index(place,',',-$offset)),1)) as firstchar, count(ucase(left(trim(substring_index(place,',',-$offset)),1))) as placecount FROM $places_table WHERE trim(substring_index(place,',',-$offset)) != \"\" $wherestr GROUP BY firstchar ORDER by placecount DESC";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$namectr = 1;
	$col = -1;
	$total = mysql_num_rows($result);
	while( $place = mysql_fetch_assoc( $result ) ) {
		if( $place[firstchar] != "" ) {
			if(($namectr -1) % 8 == 0) {
				$col++;
			}
			if( $namectr < mysql_num_rows($result)/2 ) {
				$urlfirstchar = urlencode($place[firstchar]);
				$linkstr2col[$col] .= "<p style=\"padding:2px;margin:10px;\"><a href=\"$places_oneletter_url" . "firstchar=$urlfirstchar&amp;tree=$tree&amp;offset=$offsetorg&amp;psearch=$psearch\" class=\"snlink\" title=\"$text[placesstarting]: $place[firstchar]\">$place[firstchar]</a> ($place[placecount])</p>\n";
			}
			else {
				$urlfirstchar = urlencode($place[firstchar]);
				$linkstr2col[$col] .= "<p style=\"padding:2px;margin:10px;\"><a href=\"$places_oneletter_url" . "firstchar=$urlfirstchar&amp;tree=$tree&amp;offset=$offsetorg&amp;psearch=$psearch\" class=\"snlink\" title=\"$text[placesstarting]: $place[firstchar]\">$place[firstchar]</a> ($place[placecount])</p>\n";
			}
			$namectr++;
		}
	}
	mysql_free_result($result);
}

$query = "SELECT distinct trim(substring_index(place,',',-$offset)) as myplace, count(distinct place) as placecount FROM $places_table WHERE trim(substring_index(place,',',-$offset)) != \"\" $wherestr GROUP BY myplace ORDER by placecount DESC LIMIT 30";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$count = 1;
	$col = -1;
	while( $place = mysql_fetch_assoc( $result ) ) {
		$place2 = urlencode($place[myplace]);
		if( $place2 != "" ) {
			$query = "SELECT count(distinct place) as placecount FROM $places_table WHERE place = \"$place[myplace]\" $wherestr";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$countrow = mysql_fetch_assoc($result2);
			$specificcount = $countrow[placecount];
			mysql_free_result($result2);

			$searchlink = $specificcount ? " <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=$place2\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"\" width=\"9\" height=\"9\"></a>" : "";
			$name = $place[placecount] > 1 || !$specificcount ? "<a href=\"$places_oneletter_url" . "offset=$offset&amp;tree=$tree&amp;psearch=$place2\">" . str_replace(array("<",">"), array("&lt;","&gt;"), $place[myplace]) . "</a> ($place[placecount])" : $place[myplace];
			if(($count - 1) % 10 == 0)
				$col++;
			$linkstr3col[$col] .= "<tr><td class=\"fieldnameback fieldname\" align=\"right\">$count.</td><td class=\"databack\">$name$searchlink</td></tr>\n";
			$count++;
		}
	}
	mysql_free_result($result);
}

//show the letter/character links
echo "<br /><ul class=\"normal\"><li>$text[placesstarting]:\n<p>$linkstr</p></li></ul><br/>\n";
?>

<table class="normal">
	<tr>
		<td colspan="4">
			<ul><li><?php echo "$text[firstchars]<br/>$text[byoccurrence] ($text[totalplaces]):"; ?>&nbsp;&nbsp;&nbsp;&nbsp;</li></ul>
		</td>
		<td>&nbsp;&nbsp;</td>
		<td colspan="2">
			<ul><li><?php echo "$text[top30places] ($text[totalplaces]):"; ?></li></ul>
		</td>
	</tr>
	<tr>
<?php
	for($i=0;$i<4;$i++){
?>
		<td valign="top" style="min-width:65px" class="normal">
<?php
	echo $linkstr2col[$i];
?>
		</td>
<?php
	}
?>
		<td>&nbsp;&nbsp;</td>
<?php
	for($i=0;$i<3;$i++){
?>
		<td valign="top">
			<table class="normal" cellpadding="4" cellspacing="1">
<?php
	echo $linkstr3col[$i];
?>
			</table>
		</td>
<?php
	}
?>
	</tr>
</table>
<br/>
<?php
tng_footer( "" );
?>
