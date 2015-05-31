<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "timeline";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($subroot . "pedconfig.php" );

session_register('timeline');
session_register('timeline_chartwidth');
session_register('tng_message');
$timeline = $_SESSION[timeline];
$tng_message = $_SESSION[tng_message];
if( !is_array( $timeline ) ) $timeline = array();

$tlmonths[0] = "";
$tlmonths[1] = $dates[JAN];
$tlmonths[2] = $dates[FEB];
$tlmonths[3] = $dates[MAR];
$tlmonths[4] = $dates[APR];
$tlmonths[5] = $dates[MAY];
$tlmonths[6] = $dates[JUN];
$tlmonths[7] = $dates[JUL];
$tlmonths[8] = $dates[AUG];
$tlmonths[9] = $dates[SEP];
$tlmonths[10] = $dates[OCT];
$tlmonths[11] = $dates[NOV];
$tlmonths[12] = $dates[DEC];

$minwidth = 100;
$maxwidth = 1600;
$lineoffset = 44;  //starting column for vertical gray lines (pixels from left)
if( $chartwidth && is_numeric( $chartwidth ) ) {
	if( $chartwidth < $minwidth ) 
		$chartwidth = $minwidth;
	elseif( $chartwidth > $maxwidth ) 
		$chartwidth = $maxwidth;
}
elseif( $_SESSION[timeline_chartwidth] )
	$chartwidth = $_SESSION[timeline_chartwidth];
else
	$chartwidth = 500;  //chart width in pixels (from first to last gray line)
$checkboxcellwidth = 48;  //width of table cell holding "delete" checkboxes. If bars do not line up with gray lines, adjust this value up or down accordingly
$divisions = 5;  //number of chart segments

$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, disallowgedcreate, birthdate, altbirthdate, branch, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$primaryID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row[branch] ) ? 1 : 0;
	$row[allow_living] = !$row[living] || ( $allow_living && $rightbranch ) ? 1 : 0;
	$namestr = getName( $row );
	$logname = $nonames && $row[living] ? $text[living] : $namestr;
	$disallowgedcreate = $row[disallowgedcreate];
	mysql_free_result($result);
}

function getEvents($person) {
	global $text, $ratio, $people_table, $families_table, $children_table, $allow_living, $getperson_url;
	
	$personID = $person[personID];
	$tree = $person[tree];
	$events = array();
	$eventstr = "";
	$leftoffset = 3;
	$maxleft = 0;
	$perswidth = 300;
	$eventwidth = 170;

	//born OR christened
	if( $person[birthdate] ) {
		$index = $person[birthdatetr];
		$events[$index][date] = displayDate($person[birthdate]);
		$events[$index][text] = "$text[born]:";
	}
	elseif( $person[altbirthdate] ) {
		$index = $person[altbirthdatetr];
		$events[$index][date] = displayDate($person[altbirthdate]);
		$events[$index][text] = "$text[christened]:";
	}
	$events[$index][year] = $person[birth];
	$events[$index][left] = $leftoffset;
	if( $events[$index][left] + $eventwidth > $maxleft ) $maxleft = $events[$index][left] + $eventwidth;
	
	//custom events
	
	//marriages
	//get person's gender
	if( $person[sex] == "M" ) {
		$self = "husband"; $spouse = "wife"; $spouseorder = "husborder";
	}
	elseif( $person[sex] == "F" ) {
		$self = "wife"; $spouse = "husband"; $spouseorder = "wifeorder";
	}
	else {
		$self = ""; $spouse = ""; $spouseorder = "";
	}
	//get and loop through all marriages (link to people table on opposite spouse) for this person based on gender
	if( $spouseorder )
		$query = "SELECT $spouse, familyID, living, branch, marrdate, marrdatetr, IF(marrdatetr !='0000-00-00',YEAR(marrdatetr),YEAR(marrdatetr)) as marriage FROM $families_table WHERE $families_table.$self = \"$person[personID]\" AND gedcom = \"$person[tree]\" ORDER BY $spouseorder";
	else
		$query = "SELECT husband, wife, familyID, living, branch, marrdate, marrdatetr, IF(marrdatetr !='0000-00-00',YEAR(marrdatetr),YEAR(marrdatetr)) as marriage FROM $families_table WHERE $families_table.husband = \"$personID\" AND gedcom = \"$tree\" UNION SELECT husband, wife, familyID, living, branch, marrdate, marrdatetr, IF(marrdatetr !='0000-00-00',YEAR(marrdatetr),YEAR(marrdatetr)) as marriage FROM $families_table WHERE $families_table.wife = \"$personID\" AND gedcom = \"$tree\"";
	$marriages= mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
	while ( $marriagerow =  mysql_fetch_assoc( $marriages ) ) {
		//do event for marriage date and person (observe living rights)
		if( !$spouseorder )
			$spouse = $marriagerow[husband] == $personID ? wife : husband;
		unset($spouserow);
		if( $marriagerow[$spouse] ) {
			$query = "SELECT personID, lastname, lnprefix, firstname, prefix, suffix, nameorder, living, branch FROM $people_table WHERE personID = \"$marriagerow[$spouse]\" AND gedcom = \"$person[tree]\"";
			$spouseresult= mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$spouserow =  mysql_fetch_assoc( $spouseresult );
			$spouserow[allow_living] = !$spouserow[living] || ( $allow_living && checkbranch( $spouserow[branch] ) ) ? 1 : 0;
			if( $spouserow[firstname] || $spouserow[lastname] ) {
				$spousename = getName( $spouserow );
				$spouselink = "<a href=\"$getperson_url" . "personID=$spouserow[personID]&amp;tree=$tree\">$spousename</a>";
			}
			mysql_free_result( $spouseresult );
		}
		else
			$spouselink = "";

		$rightfbranch = checkbranch( $marriagerow[branch] ) ? 1 : 0;
		$marriagerow[allow_living] = !$marriagerow[living] || ( $allow_living && $rightfbranch ) ? 1 : 0;
		if( $marriagerow[allow_living] ) {
			$index = $marriagerow[marrdatetr];
			$events[$index][date] = displayDate($marriagerow[marrdate]);
			$events[$index][text] = "$text[married] $spouselink:";
   			$events[$index][year] = $marriagerow[marriage];
			$events[$index][left] = intval( $ratio * ($marriagerow[marriage] - $person[birth])) + $leftoffset;
			if( $events[$index][left] + $perswidth > $maxleft ) $maxleft = $events[$index][left] + $perswidth;
		}
		//get all children (link to people) born to this marriage
		//loop through and make event for each
		$query = "SELECT $people_table.personID as pID, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, branch, birthdate, birthdatetr, altbirthdate, altbirthdatetr, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, ordernum FROM $people_table, $children_table WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = \"$marriagerow[familyID]\" AND $people_table.gedcom = \"$person[tree]\" AND $children_table.gedcom = \"$person[tree]\" ORDER BY ordernum";
		$children= mysql_query($query) or die ("$text[cannotexecutequery]: $query");

		while ( $child =  mysql_fetch_assoc( $children ) ) {
			$child[allow_living] = !$child[living] || ( $allow_living && checkbranch( $child[branch] ) ) ? 1 : 0;
			if( $child[allow_living] ) {
				if( $child[firstname] || $child[lastname] ) {
					$childname = getName( $child );
					$childlink = "<a href=\"$getperson_url" . "personID=$child[pID]&amp;tree=$person[tree]\">$childname</a>";
				}
				else
					$childlink = "";
				if( $child[birthdate] ) {
					$index = $child[birthdatetr] . sprintf("%2d",$child[ordernum]);
					$events[$index][date] = displayDate($child[birthdate]);
					$events[$index][text] = "$text[child] $childlink $text[birthabbr]";
				}
				elseif( $child[altbirthdate] ) {
					$index = $child[altbirthdatetr] . sprintf("%2d",$child[ordernum]);
					$events[$index][date] = displayDate($child[altbirthdate]);
					$events[$index][text] = "$text[child] $childlink $text[chrabbr]";
				}
   				$events[$index][year] = $child[birth];
				$events[$index][left] = intval( $ratio * ($child[birth] - $person[birth])) + $leftoffset;
				if( $events[$index][left] + $perswidth > $maxleft ) $maxleft = $events[$index][left] + $perswidth;
			}
		}
		mysql_free_result( $children );
	}
	mysql_free_result( $marriages );
	
	//died OR buried
	if( $person[deathdate] || $person[burialdate] ) {
		if( $person[deathdate] ) {
			$index = $person[deathdatetr];
			$events[$index][date] = displayDate($person[deathdate]);
			$events[$index][text] = "$text[died]:";
		}
		elseif( $person[burialdate] ) {
			$index = $person[burialdatetr];
			$events[$index][date] = displayDate($person[burialdate]);
			$events[$index][text] = "$text[buried]:";
		}
		$events[$index][year] = $person[death];
		$events[$index][left] = intval( $ratio * ($person[death] - $person[birth])) + $leftoffset;
		if( $events[$index][left] + $eventwidth > $maxleft ) $maxleft = $events[$index][left] + $eventwidth;
	}

	//loop through and format
	ksort( $events );
	foreach( $events as $event ) {
   		$eventstr .= "<div style=\"position:relative; top:0px; left:$event[left]px; width:$maxleft" . "px;\">\n";
		$eventstr .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"1\"><tr><td class=\"pboxpopup\"><span class=\"normal\">&gt; ";
		$eventstr .= "$event[year] - $event[text] $event[date] &nbsp;</span></td></tr></table></div>\n";
	}
	
	return $eventstr;
}

$timeline_url = getURL( "timeline", 1 );
writelog( "<a href=\"$timeline_url" . "primaryID=$primaryID&amp;tree=$tree\">$text[timeline] ($logname)</a>" );
preparebookmark( "<a href=\"$timeline_url" . "primaryID=$primaryID&amp;tree=$tree\">$text[timeline] ($namestr)</a>" );

$flags['tabs'] = $tngconfig['tabs'];
$flags['scripting'] = "
<style type=\"text/css\">
.vertlines {
    position: absolute;
    font-size: 0px;
    top: 33px;
    width: 1px;
    z-index: 0;
}
</style>";
tng_header( $text[timeline], $flags );

$photostr = showSmallPhoto( $primaryID, $namestr, $row[allow_living], 0 );
echo tng_DrawHeading( $photostr, $namestr, getYears( $row ) );
echo tng_coreicons();

echo getFORM( "timeline", "post", "form1", "form1" );

$innermenu = "$text[chartwidth]: &nbsp;";
$innermenu .= "<input type=\"text\" name=\"newwidth\" style=\"font-size:9px\" value=\"$chartwidth\" maxlength=\"4\" size=\"4\"> &nbsp;&nbsp; ";
$innermenu .= "<a href=\"#\" class=\"lightlink\" onClick=\"document.form1.submit();\">$text[refresh]</a>\n";

echo tng_menu( "I", "timeline", $primaryID, $innermenu );

$findpersonform_url = getURL( "findpersonform", 1 );
$getperson_url = getURL( "getperson", 1 );

$keeparray = array();
$earliest = date('Y');
$latest = 0;
foreach( $timeline as $timeentry ) {
	parse_str( $timeentry );
	$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, nameorder, living, branch, sex,
		IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, 
		IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death,
		birthdate, birthdatetr, altbirthdate, altbirthdatetr, deathdate, deathdatetr, burialdate, burialdatetr 
		FROM $people_table WHERE personID = \"$timeperson\" AND gedcom = \"$timetree\"";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $result2 ) {
		$row2 = mysql_fetch_assoc( $result2 );
		$newtimeentry = array();
		$newtimeentry[personID] = $timeperson;
		$newtimeentry[tree] = $timetree;
		$displaydeath = $row2[death] ? $row2[death] : "";
		$rightbranch = !$assignedbranch || $assignedbranch == $row2[branch] ? 1 : 0;
		$row2[allow_living] = !$row2[living] || ( $allow_living && $rightbranch ) ? 1 : 0;
		$namestr2 = getName( $row2 );
		$namestr2 .= " ($row2[birth] - $displaydeath)";
		
		$newtimeentry[birth] = $row2[birth];
		$newtimeentry[death] = $row2[death] ? $row2[death] : $row2[birth] + 100;
		if( $newtimeentry[death] > date('Y') ) $newtimeentry[death] = date('Y');
		$newtimeentry[lifespan] = $newtimeentry[death] - $newtimeentry[birth];
		$newtimeentry[birthdate] = $row2[birthdate];
		$newtimeentry[birthdatetr] = $row2[birthdatetr];
		$newtimeentry[altbirthdate] = $row2[altbirthdate];
		$newtimeentry[altbirthdatetr] = $row2[altbirthdatetr];
		$newtimeentry[deathdate] = $row2[deathdate];
		$newtimeentry[deathdatetr] = $row2[deathdatetr];
		$newtimeentry[burialdate] = $row2[burialdate];
		$newtimeentry[burialdatetr] = $row2[burialdatetr];
		
		if( $newtimeentry[birth] < $earliest ) 
			$earliest = $newtimeentry[birth];
		if( $newtimeentry[death] > $latest )
			$latest = $newtimeentry[death];
		$newtimeentry[name] = "<a href=\"$getperson_url" . "personID=$timeperson&amp;tree=$timetree\">$namestr2</a>";
		array_push( $keeparray, $newtimeentry );
		mysql_free_result($result2);
	}
}
if( !$latest && !count( $timeline ) ) $latest = $earliest;
$totalspan = $latest - $earliest;
$ratio = $totalspan ? $chartwidth / $totalspan : 0;
$spanheight = 30 + count( $keeparray ) * 29;
?>
<span class="subhead"><strong><?php echo $text[timeline]; ?></strong></span><br/><br/>

<?php 
	if( $tng_message ) {
		echo "<p><span class=\"normal\"><strong>$tng_message</strong></span></p>";
		$tng_message = $_SESSION[tng_message] = "";
	}
	echo "<div align=\"left\" style=\"position:relative;\">";

	$year = $earliest;
	$displayyear = $year;
	for( $i = $lineoffset; $i <= ($lineoffset+$chartwidth); $i+=($chartwidth/$divisions) ) {
		$iadj = $i - 12;
		echo "<div style=\"position:absolute;top:15px;left:$iadj" . "px;height:17px;width:40px;z-index:0\"><span class=\"normal\">$displayyear</span></div>\n";
        echo "<div class=\"vertlines\" style=\"background-color:#cccccc; left:$i" . "px;height:$spanheight" . "px\"></div>\n";
		$year += $totalspan * .2;
		$displayyear = intval( $year + .5  );
	}
	
	$linklevel = 0;
	$highestll = 0;
	$linkoffset = 35;
	$lastyo = -6;
	
	//get all events that fall in time period
	//loop through and use year as index in array
	//append if duplicate years
	$tlquery = "SELECT evday, evmonth, evyear, evdetail FROM $tlevents_table WHERE evyear BETWEEN \"$earliest\" AND \"$latest\" ORDER BY evyear, evmonth, evday";
	$tlresult = mysql_query($tlquery) or die ("$text[cannotexecutequery]: $tlquery");
	$tlevents = array();
	$tlevents2 = array();
	while( $tlrow = mysql_fetch_assoc($tlresult)) {
		$evyear = $tlrow[evyear];
		if($tlrow[evday] == "0") $tlrow[evday] = "";
		$daymonth = trim("$tlrow[evday] " . $tlmonths[$tlrow[evmonth]]);
		$tlevents[$evyear] = $tlevents[$evyear] ? $tlevents[$evyear] . "\n- $tlrow[evday] " . $tlmonths[$tlrow[evmonth]] . " $tlrow[evyear] " . ereg_replace("\"", "&#34;",$tlrow[evdetail]) : "- $tlrow[evday] " . $tlmonths[$tlrow[evmonth]] . " $tlrow[evyear] " . ereg_replace("\"", "&#34;",$tlrow[evdetail]);
		$newstring = $daymonth ? "<li>$tlrow[evday] " . $tlmonths[$tlrow[evmonth]] . ": $tlrow[evdetail]</li>" : "<li>$tlrow[evdetail]</li>";
		$tlevents2[$evyear] = $tlevents2[$evyear] ? $tlevents2[$evyear] . "\n$newstring" : $newstring;
	}
	mysql_free_result( $tlresult );

	$counter = 0;	
	foreach( $tlevents as $key=>$value ) {
		$yearoffset = $lineoffset + ($key - $earliest) * $ratio;
		if( $lastyo + 5 >= $yearoffset ) {
			if( $linklevel == 1 ) {
				$linklevel = 2;
				$linkoffset = 35;
				$highestll = 2;
			}
			else {
				$linklevel = 1;
				$linkoffset = 50;
			}
		}
		else {
			$linklevel = 0;
			$linkoffset = 35;
		}
		$lastyo = $yearoffset;
		$linkpos = $linkoffset + $spanheight;
		$eadj = $yearoffset - 3;
		$counter++;
		echo "<div class=\"vertlines\" style=\"background-color:#dddddd; left:$yearoffset" . "px; height:$spanheight". "px\"></div>\n";
		echo "<div style=\"position:absolute;top:$linkpos" . "px;left:$eadj" . "px;height:17px;width:12px;z-index:0\"><span class=\"normal\" style=\"font-size:7pt\"><a href=\"#events\" title=\"$key\n$value\">$counter</a></span></div>\n";
	}
	
	$enddiv = "</div>";

	echo "<span class=\"normal\"><br/><br/>\n";
	if( count( $timeline ) > 1 ) 
		echo $text[text_delete];
	else
		echo "&nbsp;";
	echo "</span>\n";

	$top = 20;
	$numlines = 0;
	foreach( $keeparray as $timeentry ) {
		$numlines++;
		$top += 30;
		$spanleft = $lineoffset + intval($ratio * ( $timeentry[birth] - $earliest ));
		$spanwidth = intval($ratio * $timeentry[lifespan]);
		echo "<div id=\"cb$numlines\" style=\"visibility:visible; position:absolute;top:$top" . "px;height:25px; left:0" . "px;width:$spanwidth" . "px;z-index:3;\">\n";
		if( $timeentry[personID] == $primaryID && $timeentry[tree] == $tree )
			echo "&nbsp;";
		else
			echo "<input type=\"checkbox\" name=\"$timeentry[tree]_$timeentry[personID]\" value=\"1\">\n";
		echo "</div>\n";

		echo "<div id=\"bar$numlines\" style=\"visibility:visible; position:absolute;top:$top" . "px;left:$spanleft" . "px;width:$spanwidth" . "px;z-index:3;\" onmouse$pedigree[event]=\"showPopup($numlines);\" onmouseout=\"setTimer($numlines)\">\n";
		echo "<table cellspacing=\"0\" cellpadding=\"0\"><tr><td nowrap><span class=\"normal\">$timeentry[name]</span></td></tr><tr><td><div class=\"fieldnameback\" style=\"font-size:0;height:10px;width:$spanwidth" . "px;z-index:3\"></div></td></tr></table>\n";
		echo "</div>\n";

		echo "<div id=\"popup$numlines\" style=\"position:absolute; visibility:hidden; background-color:$pedigree[popupcolor]; top:" . ($top + 25) . "px; left:" . ($spanleft - 5) . "px;z-index:8\" onmouseover=\"cancelTimer($numlines)\" onmouseout=\"setTimer($numlines)\">\n";
		echo "<table style=\"border: 1px solid $pedigree[bordercolor];\" cellpadding=\"1\" cellspacing=\"0\"><tr><td>\n";

		$eventinfo = getEvents($timeentry);
		echo "$eventinfo</td></tr></table></div>\n";
	}
	if( $highestll == 1) echo "<br/><br/>"; 
	elseif( $highestll == 2 ) echo "<br/><br/><br/>";
	echo "<table width=\"" . ($chartwidth + $lineoffset + 20) . "\" style=\"height:$top" . "px\"><tr><td>&nbsp;</td></tr></table>";
?>

<br/><br/>
<input type="button" name="lines" value="<?php echo $text[togglelines]; ?>" onclick="toggleLines();" />
<input type="button" name="addmore" value="<?php echo $text[timelineinstr]; ?>" onclick="toggleAddMore();" />
<input type="submit" value="<?php echo $text[refresh]; ?>">
<div id="addmorediv" style="display:none;">
<?php
	echo "<span class=\"normal\"><br/><br/>";
	$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
	$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$numrows = mysql_num_rows( $treeresult );
	$noliving = $allow_living && $rightbranch ? 0 : 1;
	$newtime = time();
	for( $x = 2; $x < 6; $x++ ) {
		echo "$text[addperson]: "; 
		if( $numrows > 1 ) {
			echo "<select name=\"nexttree$x\">\n";
			while( $treerow = mysql_fetch_assoc($treeresult) ) {
				echo "	<option value=\"$treerow[gedcom]\"";
				if( $treerow[gedcom] == $tree ) echo " selected";
				echo ">$treerow[treename]</option>\n";
			}
			echo "</select>\n";
			$treestr = "' + document.form1.nexttree$x.options[document.form1.nexttree$x.selectedIndex].value + '";
		}
		else {
			echo "<input type=\"hidden\" name=\"nexttree$x\" value=\"$tree\">";
			$treestr = "$tree";
		}
		echo "<input type=\"text\" name=\"nextpersonID$x\" id=\"nextpersonID$x\" size=\"10\">  <input type=\"button\" name=\"find$x\" id=\"find$x\" value=\"$text[find]\" onclick=\"tnglitbox = new LITBox('$findpersonform_url" . "noliving=$noliving&amp;type=text&amp;datesreq=1&amp;findtree=$treestr&amp;publicfield=nextpersonID$x',{width:400,height:450});\"><br/>\n";
		if( $x < 5 )
			$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
?>
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<input type="hidden" name="primaryID" value="<?php echo $primaryID; ?>">
<br/>
</span>
</div>
<br/>
</div>
</form><br/>
<?php
	if( $counter ) {
?>
<a name="events" id="events"></a>
<table cellpadding="3" cellspacing="1" border="0" width="100%">
	<tr>
		<td class="fieldnameback" width="20">&nbsp;</td>
		<td class="fieldnameback" width="50"><span class="fieldname"><strong>&nbsp;<?php echo $text[year]; ?></strong></span></td>
		<td class="fieldnameback"><span class="fieldname"><strong>&nbsp;<?php echo $text[event]; ?></strong></span></td>
	</tr>
<?php
		$counter = 0;
		foreach( $tlevents2 as $key=>$value ) {
			$counter++;
			echo "<tr>\n";
			echo "<td class=\"databack\" valign=\"top\" align=\"right\"><span class=\"normal\">$counter&nbsp;</span></td>";
			echo "<td class=\"databack\" valign=\"top\"><span class=\"normal\">$key&nbsp;</span></td>";
			echo "<td class=\"databack\" valign=\"top\"><ul class=\"normal\">$value</ul></td>";
			echo "</tr>\n";
		}
?>
</table><br/>
<?php
	}
?>
<script language="JavaScript" type="text/javascript">
var lastpopup = "";
var tnglitbox;
for( var h = 1; h <= <?php echo $numlines; ?>; h++ ) {
	eval( 'var timer' + h + '=false' );
}

function setTimer(slot) {
	eval( "timer" + slot + "=setTimeout(\"hidePopup('" + slot + "')\",<?php echo $pedigree[popuptimer]; ?>);");
}

function cancelTimer(slot) {
	eval( "clearTimeout(timer" + slot + ");" );
	eval( "timer" + slot + "=false;" );
}

function hidePopup(slot) {
	var ref = document.all ? document.all["popup" + slot] : document.getElementById ? document.getElementById("popup" + slot) : null ;
	if (ref) { ref.style.visibility = "hidden"; }
	eval("timer" + slot + "=false;");
}

function changecss(theClass,element,value) {
//documentation for this script at http://www.shawnolson.net/a/503/
 var cssRules;
 if (document.all) {
  cssRules = 'rules';
 }
 else if (document.getElementById) {
  cssRules = 'cssRules';
 }
 for (var S = 0; S < document.styleSheets.length; S++){
  for (var R = 0; R < document.styleSheets[S][cssRules].length; R++) {
   if (document.styleSheets[S][cssRules][R].selectorText == theClass) {
    document.styleSheets[S][cssRules][R].style[element] = value;
   }
  }
 }	
}

function showPopup(slot) {
// hide any other currently visible popups
	if( lastpopup ) {
		cancelTimer(lastpopup);
		hidePopup(lastpopup);
	}
	lastpopup = slot;

// show current
	var ref = document.all ? document.all["popup" + slot] : document.getElementById ? document.getElementById("popup" + slot) : null;

	//ref.innerHTML = getPopup(slot);
	if ( ref ) {ref = ref.style;}

	if ( ref.visibility != "show" && ref.visibility != "visible" ) {
		ref.zIndex = 8;
    	ref.visibility = "visible";
	}
}

function toggleAddMore(val) {
	new Effect.toggle('addmorediv','appear',{duration:.2})
}

var lines = 1;
function toggleLines() {
	if(lines ) {
		changecss('.vertlines','visibility','hidden');
		lines = 0;
	}
	else {
		changecss('.vertlines','visibility','visible');
		lines = 1;
	}
}
</script>
<script type="text/javascript">
function returnName(personID,namestring,field,textchange) {
	$(field).value = personID;
	tnglitbox.remove();

	return false;
}
</script>

<?php
	//$flags[more] = "$enddiv\n";
	tng_footer( $flags );
?>
