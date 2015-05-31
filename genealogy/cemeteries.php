<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "headstones";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath']  . "checklogin.php");
include($cms['tngpath'] . "log.php" );

$browsemedia_url = getURL( "browsemedia", 1 );
$headstones_url = getURL( "headstones", 1 );
$showmap_url = getURL( "showmap", 1 );
$cemeteries_url = getURL( "cemeteries", 1 );

$query = "SELECT * FROM $cemeteries_table ORDER BY country, state, county, city, cemname";
$cemresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numcems = $tngconfig['cemrows'] ? $tngconfig['cemrows'] : max(floor(mysql_num_rows($cemresult)/2),10);

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$wherestr = ($tree) ? "AND $medialinks_table.gedcom = \"$tree\"" : "";

$query = "SELECT $medialinks_table.personID as personID FROM $medialinks_table, $media_table WHERE $media_table.mediaID = $medialinks_table.mediaID AND mediatypeID=\"headstones\" AND cemeteryID = \"\" $wherestr";
$hsresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numhs = mysql_num_rows( $hsresult );
mysql_free_result($hsresult);

$logstring = "<a href=\"$cemeteries_url" . "tree=$tree\">$text[cemeteriesheadstones]$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

$flags[scripting] = "<style type=\"text/css\">
#header {
	margin: 0 0 10px 0;
}

#wrapper {
    font-size: 12px;
  	text-align: left;
	margin: 10px auto;
	padding: 0px;
	border:0;
	width: 100%;
}

#col0, #col1, #col2 {
	float: left;
	width: 30%;
	margin:5px;
	height:100%;
}

#col1, #col2 {
	border-left:1px solid black;
	padding-left:10px;
}

.cemcountry {
	padding:5px;
}
</style>\n";

tng_header( $text[cemeteriesheadstones], $flags );
?>

<script type="text/javascript">
function toggleSection(key) {

	var section = document.getElementById(key);
	if( section.style.display == 'none' ) {
		new Effect.Appear(key,{duration:.2});

		swap("plusminus" + key,"minus");
	}
	else {
		new Effect.Fade(key,{duration:.2});
		swap("plusminus" + key,"plus");
	}
	return false;
}

plus = new Image;
plus.src = "<?php echo $cms[tngpath] ?>tng_expand.gif";
minus = new Image;
minus.src = "<?php echo $cms[tngpath] ?>tng_collapse.gif";

function swap(x, y) {
	document.images[x].src=eval(y+'.src');
}
</script>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_hs.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text[cemeteriesheadstones]; ?><br clear="all" /></p>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'cemeteries', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1'));

define ("DUMMYPLACE", "@@@@@@"); // sincerely hope there's not a place called this anywhere in the world
define ("NUMCOLS",2);           //set as number of columns-1
define ("DEFAULT_COLUMN_LENGTH", $numcems);
$numrows = mysql_num_rows( $cemresult );
$colsize =  ($numrows > 200) ? (int)ceil($numrows/4) : DEFAULT_COLUMN_LENGTH;
$lastcountry = DUMMYPLACE;
$divctr = $linectr = $colctr = $i = 0;

echo "<div id=\"wrapper\">\n";
echo "<div id=\"header\">\n<ul>\n<li>\n<a href=\"$browsemedia_url" . "mediatypeID=headstones\">$text[showallhsr]</a>\n</li>\n</ul>\n</div>\n";
echo "<div id=\"container\">\n";
echo "<div id=\"col$colctr\">\n";

$cemetery = mysql_fetch_assoc( $cemresult );
$orphan = false;
while( $i < $numrows ) {
	if( $cemetery[country] == $lastcountry ) {
		if($cemetery[state] == $laststate) {
			if($cemetery[county] == $lastcounty ) {
				$lastcity = DUMMYPLACE;
				$cityctr = 0;
				while ( ( $i < $numrows ) && ( $cemetery[county] == $lastcounty) && ( $cemetery[state] == $laststate) && ( $cemetery[country] == $lastcountry) ) { // display all cemeteries in the current county
					if($cemetery[city] != $lastcity) {
						//end last city if $lastcity != dummy
						if($lastcity != DUMMYPLACE)
							echo "</div>\n";

						//start a new city
						$lastcity = $cemetery[city];
						$divctr++;
						$divname = "city$divctr";
						if($cemetery[city] || !$tngconfig['cemblanks']) {
			                	$txt = $cemetery['city'] ? htmlspecialchars($cemetery['city']) : $text['nocity'];
							echo "<div style=\"padding:3px\"><img src='$cms[tngpath]" . "tng_expand.gif' width='15' height='15' hspace='4' vspace='0' border='0' alt='' name='plusminus$divname' onclick=\"return toggleSection('$divname');\" style=\"cursor:pointer\" align=\"left\" />\n<a href=\"$headstones_url" . "country=" . urlencode($cemetery[country]) . "&amp;state=" . urlencode($cemetery[state]) . "&amp;county=" . urlencode($cemetery[county]). "&amp;city=" . urlencode($cemetery[city]) . "&amp;tree=$tree\">$txt</a></div>\n";
							echo "<div id=\"$divname\" style=\"display:none; padding-left:16px\">\n";
						}
						else
							echo "<div id=\"$divname\">\n";
					}
					$txt = $cemetery['cemname'] ? $cemetery['cemname'] : $text['nocemname'];
					$txt= htmlspecialchars($txt);
	   				echo "- <a href=\"$showmap_url" . "cemeteryID=$cemetery[cemeteryID]&amp;tree=$tree\">$txt</a><br/>\n";
					$cemetery = mysql_fetch_assoc( $cemresult );
					$i++;
				}
				if($lastcity != DUMMYPLACE)
					echo "</div>\n";
				echo "</div>\n";					// displayed all cemeteries in the county

			}
			else {							    // display the county
				//if($lastcounty != DUMMYPLACE)
					//echo "</div>\n";
				$divname = "county$divctr";
				$divctr++;
				$lastcounty = $cemetery[county];
				$linectr++;
				if($cemetery[county] || !$tngconfig['cemblanks']) {
	                	$txt = $cemetery['county'] ? htmlspecialchars($cemetery['county']) : $text['nocounty'];
					echo "<div style=\"padding:3px\"><img src='$cms[tngpath]" . "tng_expand.gif' width='15' height='15' hspace='4' vspace='0' border='0' alt='' name='plusminus$divname' onclick=\"return toggleSection('$divname');\" style=\"cursor:pointer\" align=\"left\" />\n<a href=\"$headstones_url" . "country=" . urlencode($cemetery[country]) . "&amp;state=" . urlencode($cemetery[state]) . "&amp;county=" . urlencode($cemetery[county]). "&amp;tree=$tree\">$txt</a></div>\n";
					echo "<div id=\"$divname\" style=\"display:none; padding-left:16px\">\n";
				}
				else
					echo "<div id=\"$divname\">\n";
			}
		} else {								// display the State
			if ( ( $colctr < NUMCOLS ) && ( $linectr > $colsize ) && !$orphan ) {	// end of a column
				$linectr = 0;
				$colctr++;
				echo "</div>\n<div id=\"col$colctr\">\n<em>($cemetery[country] cont.)</em>\n";
			}
			$orphan = false;

			$laststate = $cemetery[state];
			$lastcounty = DUMMYPLACE;
			$linectr+=2;        //Add extra line to allow for the <br/> at the end
			$txt = $cemetery['state'] ? htmlspecialchars($cemetery['state']) : $text['nostate'];
			if($cemetery[state] || !$tngconfig['cemblanks'])
				echo "<br/><strong><a href=\"$headstones_url" . "country=" . urlencode($cemetery[country]) . "&amp;state=" . urlencode($cemetery[state]) . "&amp;tree=$tree\">$txt</a></strong><br/>\n";
			else
				echo "<br/>\n";
		}
		} else {									// display the Country
	  		if ( ( $colctr < NUMCOLS ) && ( $linectr > $colsize ) ) {	// end of a column
				$linectr = 0;
				$colctr++;
				echo "</div>\n<div id=\"col$colctr\">\n";
        	}
		$lastcountry = $cemetery[country];
        	$laststate = DUMMYPLACE;
        	$lastcounty = DUMMYPLACE;
		if ( $linectr ) echo "<br/>";
		$linectr+=2;     //Add extra line to allow for the <br/> at the end
        	$txt = $cemetery['country'] ? htmlspecialchars($cemetery['country']) : $text['nocountry'];
		echo "<div class=\"databack cemcountry\"><font size=\"4\"><strong><a href=\"$headstones_url" . "country=" . urlencode($cemetery[country]) . "&amp;tree=$tree\">$txt</a></strong></font></div>\n";
		$orphan = true;
	}
}
mysql_free_result( $cemresult );

if ( $numhs )
    echo "<br/><div class=\"databack cemcountry\"><font size=\"4\"><strong><a href=\"$headstones_url" . "&amp;tree=$tree\">$text[nocemetery]</a></strong></font></div>\n";

echo "</div>\n";    //colx
echo "</div>\n";    //container
echo "</div>\n<br clear=\"all\"/>";    //wrapper

tng_footer( "" );

?>
