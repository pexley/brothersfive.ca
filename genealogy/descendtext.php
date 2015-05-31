<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
if(!$personID) die("no args");
$textpart = "pedigree";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($subroot . "pedconfig.php");

$getperson_url = getURL( "getperson", 1 );
$descend_url = getURL( "descend", 1 );
$descendtext_url = getURL( "descendtext", 1 );
$desctracker_url = getURL( "desctracker", 1 );
$register_url = getURL( "register", 1 );
$pdfform_url = getURL( "pdfform", 1 );

$divctr = 1;
if( $pedigree[stdesc] ) {
	$display = "none";
	$excolimg = "tng_plus";
}
else {
	$display = "block";
	$excolimg = "tng_minus";
}

function getIndividual( $key, $sex, $level, $trail ) {
	global $tree, $generations, $families_table, $people_table, $children_table, $text, $allow_living, $nonames, $cms, $getperson_url;
	global $desctracker_url, $divctr, $display, $excolimg, $livedefault, $descendtext_url;

	$rval = "";
	if( $sex == "M" ) {
		$self = "husband";
		$spouse = "wife";
		$spouseorder = "husborder";
	}
	else if( $sex == "F" ){
		$self = "wife";
		$spouse = "husband";
		$spouseorder = "wifeorder";
	}
	else {
		$self = $spouse = $spouseorder = "";
	}

	if( $spouse )
		$query = "SELECT $spouse, familyID FROM $families_table WHERE $families_table.$self = \"$key\" AND gedcom = \"$tree\" ORDER BY $spouseorder";
	elseif( $key )
		$query = "SELECT husband, wife, familyID FROM $families_table WHERE $families_table.wife = \"$key\" AND gedcom = \"$tree\" UNION SELECT husband, wife, familyID FROM $families_table WHERE $families_table.husband = \"$key\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$marrtot = mysql_num_rows($result);
	if( !$marrtot && $key) {
		$query = "SELECT husband, wife, familyID FROM $families_table WHERE $families_table.wife = \"$key\" AND gedcom = \"$tree\" UNION SELECT husband, wife, familyID FROM $families_table WHERE $families_table.husband = \"$key\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$self = $spouse = $spouseorder = "";
	}

	if( $result ) {
		while( $row = mysql_fetch_assoc( $result ) ) {
			$spouserow = array();
			$spousestr = "";
			if( !$spouse )
				$spouse = $row[husband] == $key ? "wife" : "husband";
			if( $row[$spouse] ) {
				$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, living, branch FROM $people_table WHERE personID = \"$row[$spouse]\" AND gedcom = \"$tree\"";
				$spouseresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				if( $spouseresult ) {
					$spouserow = mysql_fetch_assoc( $spouseresult );
					$spouserow[allow_living] = !$spouserow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $spouserow[branch] ) ) ? 1 : 0;
					$spousename = getName( $spouserow );
					$vitalinfo = getVitalDates( $spouserow );
					$spousestr = "&nbsp;<a href=\"$getperson_url" . "personID=$spouserow[personID]&amp;tree=$tree\">$spousename</a>&nbsp; $vitalinfo<br/>";
				}
			}

			$query = "SELECT $children_table.personID as cpersonID, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, sex, living, branch FROM ($children_table, $people_table) WHERE familyID = \"$row[familyID]\" AND $children_table.personID = $people_table.personID AND $children_table.gedcom = \"$tree\" AND $people_table.gedcom = \"$tree\" ORDER BY ordernum";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$numkids = mysql_num_rows( $result2 );
			if( $numkids ) {
				$divname = "fc$divctr";
				$divctr++;
				$rval .= str_repeat( "  ", ($level - 1) * 8 - 4 ) . "<li><img src='$cms[tngpath]" . "$excolimg.gif' width='9' height='9' hspace='0' vspace='0' border='0' alt='' name='plusminus$divname' onclick=\"return toggleDescSection('$divname');\" style=\"cursor:pointer\" /> $spousestr";
				$rval .= str_repeat( "  ", ($level - 1) * 8 - 2 ) . "<ul id=\"$divname\" class=\"normal\" style=\"display:$display;\">\n";

				while( $crow = mysql_fetch_assoc( $result2 ) ) {
					$newtrail = "$trail,$row[familyID],$crow[cpersonID]";
					$crow[allow_living] = !$crow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $crow[branch] ) ) ? 1 : 0;
					$cname = getName( $crow );
					$vitalinfo = getVitalDates( $crow );
					$rval .= str_repeat( "  ", ($level - 1) * 8 ) . "<li>$level &nbsp;<a href=\"$getperson_url" . "personID=$crow[cpersonID]&amp;tree=$tree\">$cname</a>&nbsp;<a href=\"$desctracker_url" . "trail=$newtrail&amp;tree=$tree\" title=\"$text[graphdesc]\"><img src=\"$cms[tngpath]" . "dchart.gif\" width=\"10\" height=\"9\" alt=\"$text[graphdesc]\" border=\"0\"/></a> $vitalinfo\n";
					if( $level < $generations ) {
						$ind = getIndividual( $crow[cpersonID], $crow[sex], $level + 1, $newtrail );
						if($ind) {
							$rval .= str_repeat( "  ", ($level - 1) * 8 + 2 ) . "<ul class=\"normal\">\n$ind";
							$rval .= str_repeat( "  ", ($level - 1) * 8 + 2 ) . "</ul>\n";
						}
					}
					else {
						//do union to check for children where person is either husband or wife
						$query = "SELECT familyID FROM $families_table WHERE wife = \"$crow[cpersonID]\" AND gedcom = \"$tree\" UNION SELECT familyID FROM $families_table WHERE husband = \"$crow[cpersonID]\" AND gedcom = \"$tree\"";
						//echo "<br>$query<br>";
						$nxtfams = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
						$nxtkids = 0;
						while($nxtfam = mysql_fetch_assoc($nxtfams)) {
							$query = "SELECT count(ID) as ccount FROM $children_table WHERE familyID = \"$nxtfam[familyID]\" AND gedcom = \"$tree\"";
							//echo "$query<br>kids=$nxtrow[ccount], tot=$nxtkids<br>";
							$result3 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
							$nxtrow = mysql_fetch_assoc($result3);
							$nxtkids += $nxtrow['ccount'];
							mysql_free_result($result3);
						}
						if($nxtkids) {
							//chart continues
							$rval .= "[<a href=\"$descendtext_url" . "personID=$crow[cpersonID]&amp;tree=$tree\" title=\"$text[popupnote3]\"> =&gt;</a>]";
						}
					}
					$rval .= str_repeat( "  ", ($level - 1) * 8 ) . "</li>\n";
				}
				if( $numkids ) {
					$rval .= str_repeat( "  ", ($level - 1) * 8 - 2 ) . "</ul> <!-- end $divname -->\n";
					$rval .= str_repeat( "  ", ($level - 1) * 8 - 4 ) . "</li>\n";
				}
			}
			elseif( $spousestr )
				$rval .= str_repeat( "  ", ($level - 1) * 8 - 4 ) . "<li>+ $spousestr</li>\n";
			mysql_free_result( $result2 );
		}
	}
	mysql_free_result( $result );
	return $rval;
}

function getVitalDates( $row ) {
	global $text;
	
	$vitalinfo = "";
	
	if( $row[allow_living] ) {
		if( $row[birthdate] ) {
			$vitalinfo = "$text[birthabbr] " . displayDate( $row[birthdate] ) . " ";
		}
		else if( $row[altbirthdate] ){
			$vitalinfo = "$text[chrabbr] " . displayDate( $row[altbirthdate] ) . " ";
		}
		else {
			$vitalinfo .= " ";
		}
		if( $row[deathdate] ) {
			$vitalinfo .= "$text[deathabbr] " . displayDate( $row[deathdate] );
		}
		else if( $row[burialdate] ){
			$vitalinfo .= "$text[burialabbr] " . displayDate( $row[burialdate] );
		}
		else {
			$vitalinfo .= " ";
		}
	}
	return $vitalinfo;
}

$level = 1;
$key = $personID;

$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, sex, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$key\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row[branch] );
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$namestr = getName( $row );
	$logname = $nonames && $row[living] ? $text[living] : $namestr;
	$disallowgedcreate = $row[disallowgedcreate];
}

writelog( "<a href=\"$descendtext_url" . "personID=$personID&amp;tree=$tree\">$text[descendfor] $logname ($personID)</a>" );
preparebookmark( "<a href=\"$descendtext_url" . "personID=$personID&amp;tree=$tree\">$text[descendfor] $namestr ($personID)</a>" );

$flags[tabs] = $tngconfig[tabs];
$flags['scripting'] = "<script type=\"text/javascript\">var tnglitbox;</script>\n";
tng_header( "$text[descendfor] $namestr", $flags );
?>
<script type="text/javascript">
function toggleDescSection(key) {

	var section = document.getElementById(key);
	if( section.style.display == 'none' ) {
		section.style.display = '';

		swap("plusminus" + key,"minus");
	}
	else {
		section.style.display = 'none';
		swap("plusminus" + key,"plus");
	}
	return false;
}

function toggleAll(disp) {
	var i = 1;
	
	while (document.getElementById("fc"+i) != null) {
		document.getElementById("fc"+i).style.display = disp;
		if( disp == '' ) 
			swap("plusminusfc" + i,"minus");
		else
			swap("plusminusfc" + i,"plus");
		i++;
	}
	return false;
}

plus = new Image;
plus.src = "<?php echo $cms[tngpath] ?>tng_plus.gif";
minus = new Image;
minus.src = "<?php echo $cms[tngpath] ?>tng_minus.gif";

function swap(x, y) {
	document.images[x].src=eval(y+'.src');
}
</script>

<?php 
	$photostr = showSmallPhoto( $personID, $namestr, $row[allow_living], 0 );
	echo tng_DrawHeading( $photostr, $namestr, getYears( $row ) );
	echo tng_coreicons();

	if( !$pedigree[maxdesc] ) $pedigree[maxdesc] = 12;
	if( !$generations )
	    $generations = $pedigree[initdescgens] > 8 ? 8 : $pedigree[initdescgens];
	else if( $generations > $pedigree[maxdesc] )
		$generations = $pedigree[maxdesc];
	else
		$generations = intval( $generations );

	$innermenu = "$text[generations]: &nbsp;";
	$innermenu .= "<select name=\"generations\" style=\"font-size:9px\" onchange=\"window.location.href='$descendtext_url" . "personID=$personID&amp;tree=$tree&amp;display=$display&amp;generations=' + this.options[this.selectedIndex].value\">\n";
    for( $i = 1; $i <= $pedigree[maxdesc]; $i++ ) {
        $innermenu .= "<option value=\"$i\"";
        if( $i == $generations ) $innermenu .= " selected=\"selected\"";
        $innermenu .= ">$i</option>\n";
    }
	$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
	$innermenu .= "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=standard&amp;generations=$generations\" class=\"lightlink\">$text[pedstandard]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=compact&amp;generations=$generations\" class=\"lightlink\">$text[pedcompact]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$descendtext_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink3\">$text[pedtextonly]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$register_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink\">$text[regformat]</a>\n";
	if($generations <= 12)
		$innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"#\" class=\"lightlink\" onclick=\"tnglitbox = new LITBox('$pdfform_url" . "pdftype=desc&personID=$personID&tree=$tree&generations=$generations',{width:350,height:350});return false;\">PDF</a>\n";

	echo getFORM( "descend", "get", "form1", "form1" );
	echo tng_menu( "I", "descend", $personID, $innermenu );
	echo "</form>\n";
?>
<div class="normal">
<p>(<?php echo "<img src=\"$cms[tngpath]" . "dchart.gif\" width=\"10\" height=\"9\" alt=\"\" border=\"0\"/> = $text[graphdesc], <img src=\"$cms[tngpath]" . "tng_plus.gif\" width=\"9\" height=\"9\" alt=\"\" border=\"0\"/> = $text[expand], <img src=\"$cms[tngpath]" . "tng_minus.gif\" width=\"9\" height=\"9\" alt=\"\" border=\"0\"/> = $text[collapse]"; ?>)</p>

<p><a href="#" onclick="return toggleAll('');"><?php echo $text[expandall]; ?></a> | <a href="#" onclick="return toggleAll('none');"><?php echo $text[collapseall]; ?></a></p>

<div id="descendantchart" align="left">
<?php
$vitalinfo = getVitalDates( $row );
echo "<ul class=\"first\">\n";
echo "  <li>$level &nbsp;<a href=\"$getperson_url" . "personID=$personID&amp;tree=$tree\">$namestr</a>&nbsp; $vitalinfo\n";

if( $generations > 1 ) {
	$ind = getIndividual( $key, $row[sex], $level + 1, $personID );
	if($ind) {
		echo "<ul class=\"normal\">$ind\n";
		echo "</ul>\n";
	}
}
?>
  </li> 
</ul>
</div>
<br />
</div>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>litbox.js"></script>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>rpt_utils.js"></script>
<?php
tng_footer( "" );
?>
