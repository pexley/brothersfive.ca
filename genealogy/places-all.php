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

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$places_all_url" . "tree=$tree\">$text[allplaces]$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( "$text[placelist] &mdash; $text[allplaces]", $flags );
?>
<a name="top"></a>
<p class="header"><img src="<?php echo $cms['tngpath']; ?>tng_place.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo "$text[placelist]: $text[allplaces]"; ?><br clear="all" /></p>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'places-all', 'method' => 'get', 'name' => 'form1', 'id' => 'form1'));
echo "<ul class=\"normal\">\n";

//Top 100 area
echo "<li>\n";
echo getFORM( "places100", "get", "", "" );
echo "$text[showtop] <input type=\"text\" name=\"topnum\" value=\"100\" size=\"4\" maxlength=\"4\" />\n";
echo "$text[byoccurrence] <input type=\"hidden\" name=\"tree\" value=\"$tree\" />\n";
echo "<input type=\"submit\" value=\"$text[go]\" />\n";
echo "</form></li>\n";

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

$offset = 1;
if( $tree ) {
	$wherestr = "WHERE gedcom = \"$tree\"";
	$wherestr2 = "AND gedcom = \"$tree\"";
}
else {
	$wherestr = "";
	$wherestr2 = "";
}
	
$linkstr = "";
$query = "SELECT distinct ucase(left(trim(substring_index(place,',',-$offset)),1)) as firstchar FROM $places_table $wherestr GROUP BY firstchar ORDER by firstchar";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$initialchar = 1;
	
	while( $place = mysql_fetch_assoc( $result ) ) {
		if( $initialchar != 1 ) {
			$linkstr .= "&nbsp;";
		}
		if( $place[firstchar] != "" ) {
			$linkstr .= "<a href=\"#char$initialchar\" class=\"snlink\">$place[firstchar]</a>";
			$firstchars[$initialchar] = $place['firstchar'];
			$initialchar++;
		}
	}
	mysql_free_result($result);
}

//show the letter/character links
echo "<ul class=\"normal\"><li>$text[placesstarting]:\n<p>$linkstr</p></li></ul>\n";
?>

<p class="normal"><b><?php echo $text['showmatchingplaces']; ?></b></p>

<?php
for( $scount = 1; $scount < $initialchar; $scount++ ) {
	$urlfirstchar = addslashes($firstchars[$scount]);
	if( $urlfirstchar ) {
		echo "<A name=\"char$scount\">\n";
?>
<span class="header"><?php echo $firstchars[$scount]; ?></span></a>
<table border="0" cellspacing="0" cellpadding="0">
	<tr><td valign="top"><span class="normal">
<?php
		$query = "SELECT trim(substring_index(place,',',-$offset)) as myplace, count(distinct place) as placecount FROM $places_table WHERE trim(substring_index(place,',',-$offset)) LIKE \"$urlfirstchar%\" $wherestr2 GROUP BY myplace ORDER by myplace";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
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
				$place2 = urlencode( $place['myplace'] );
				$commaOnEnd = false;
				$poffset = $stretch ? "" : "offset=$offset&amp;";
				if(substr($place['wholeplace'],0,1) == ',' && trim(substr($place[wholeplace],1)) == $place['myplace']) {
					$place3 = addslashes($place['wholeplace']);
					$commaOnEnd = true;
					$place2 = urlencode($place['wholeplace']);
					$placetitle = $place['wholeplace'];
				}
				else {
					$place3 = addslashes($place['myplace']);
					$placetitle = $place['myplace'];
				}

				$query = "SELECT count(distinct place) as placecount FROM $places_table WHERE place = \"$place3\" $wherestr2";
				$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				$countrow = mysql_fetch_assoc($result2);
				$specificcount = $countrow['placecount'];
				mysql_free_result($result2);

				$searchlink = $specificcount ? " <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=$place2\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\" /></a>" : "";
				if( $place['placecount'] > 1 || ($place['myplace'] != $place['wholeplace'] && !$commaOnEnd) ) {
					$name = "<a href=\"$places_oneletter_url" . $poffset;
					if($tree) $name .= "tree=$place[gedcom]&amp;";
					$name .= "psearch=$place2\">" . str_replace(array("<",">"), array("&lt;","&gt;"), $place['myplace']) . "</a>";
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
			mysql_free_result($result);
		}
?>
	</span></td></tr>
</table><br/><p class="normal"><a href="#top"><?php echo $text['backtotop']; ?></a></p><br/>
<?php
	}
}
tng_footer( "" );
?>
