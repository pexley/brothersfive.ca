<?php
include("begin.php");
include($subroot . "pedconfig.php");
include($cms['tngpath'] . "genlib.php");
if(!$personID) die("no args");
$textpart = "pedigree";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
@set_time_limit(0);
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );

$getperson_url = getURL( "getperson", 1 );
$searchform_noargs_url = getURL( "searchform", 0 );
$descend_url = getURL( "descend", 1 );
$gedform_url = getURL( "gedform", 1 );
$ahnentafel_url = getURL( "ahnentafel", 1 );
$pedigree_url = getURL( "pedigree", 1 );
$pedigreetext_url = getURL( "pedigreetext", 1 );
$extrastree_url = getURL( "extrastree", 1 );
$ultraped_url = getURL( "ultraped", 1 );
$pdfform_url = getURL( "pdfform", 1 );

function showBlank($pedborder) {
	echo "<TD NOWRAP $pedborder><span class=\"normal\">&nbsp;</span></td>\n";
	echo "<TD NOWRAP width=\"100%\"><span class=\"normal\">&nbsp;</span></td>\n</tr>\n";
	echo "<tr>\n<TD NOWRAP $pedborder><span class=\"normal\">&nbsp;</span></td>\n";
	echo "<TD NOWRAP><span class=\"normal\">&nbsp;</span></td>\n</tr>\n";
}

function displayIndividual( $key, $generation, $slot ) {
	global $tree, $generations, $marrdate, $marrplace, $pedmax, $people_table, $families_table, $children_table, $personID, $text, $allow_living;
	global $nonames, $cms, $getperson_url, $pedigree_url, $parentset;

	$nextslot = $slot * 2;
	$name = "";
	$row[birthdate] = "";
	$row[birthplace] = "";
	$row[altbirthdate] = "";
	$row[altbirthplace] = "";
	$row[deathdate] = "";
	$row[deathplace] = "";
	$row[burialdate] = "";
	$row[burialplace] = "";
	
	if( $key ) {
		$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, nameorder, living, branch, famc, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace FROM $people_table WHERE personID = \"$key\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( $result ) {
			$row = mysql_fetch_assoc( $result );
			$row[allow_living] = !$row[living] || ( $allow_living && checkbranch( $row[branch] ) ) ? 1 : 0;
			$name = getName( $row );
			mysql_free_result($result);
		}
	}

	if( $slot > 1 && $slot % 2 != 0 )
		echo "</tr>\n<tr>\n";
	
	$rowspan = pow( 2, $generations - $generation );
	if( $rowspan == 1 )
		$vertfill = 8;
	else
		$vertfill = ($rowspan - 1) * 53 + 1;
		
	if( $slot > 1 && $slot % 2 != 0 )
		echo "<td rowspan=\"$rowspan\" valign=\"top\">\n";
	elseif( $slot % 2 == 0 )
		echo "<td rowspan=\"$rowspan\" valign=\"bottom\">\n";
	else
		echo "<td rowspan=\"$rowspan\">\n";

	if( $slot > 1 && $slot % 2 != 0 ) {
		echo "<table border=0 cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
		echo "<td width=1><img src=\"$cms[tngpath]" . "black.gif\" height=\"$vertfill\" width=\"1\" vspace=\"0\" hspace=\"0\" border=\"0\"></td>\n";
		echo "<td width=\"100%\"></td>\n</tr>\n</table>\n";
	}
	else {
		echo "<table border=0 cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
		echo "<td colspan=\"2\" width=\"100%\"><img src=\"$cms[tngpath]" . "spacer.gif\" height=\"$vertfill\" width=\"1\" vspace=\"0\" hspace=\"0\" border=\"0\"></td>\n</tr>\n</table>\n";
	}

	echo "<table border=0 cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
	echo "<tr>\n";
	$pedborder = $slot % 2 && $slot != 1 ? "class=\"pedborderleft\"" : "";
	//if( $slot > 1 && $slot % 2 != 0 ) {
		//echo "<td><IMG SRC=\"$cms[tngpath]" . "black.gif\" HEIGHT=15 WIDTH=1 VSPACE=0 HSPACE=0 BORDER=0></td>\n";
	//}
    //else {
		//echo "<td><IMG SRC=\"$cms[tngpath]" . "spacer.gif\" WIDTH=1 HEIGHT=1 BORDER=0 HSPACE=0 VSPACE=0></td>\n";
	//}
	echo "<TD colspan=\"2\" $pedborder><span class=\"normal\">&nbsp;$slot. <a href=\"$getperson_url" . "personID=$key&amp;tree=$tree\">$name</a>&nbsp;</span></td>\n";

	//arrow goes here in own cell
	if( $nextslot >= $pedmax && $row[famc] )
		echo "<td><span class=\"normal\"><a href=\"$pedigree_url" . "personID=$key&amp;tree=$tree&amp;display=textonly\" title=\"$text[popupnote2]\">=&gt;</a></span></td>\n";

	echo "</tr>\n";
	echo "<tr>\n<TD colspan=\"2\"><IMG SRC=\"$cms[tngpath]" . "black.gif\" WIDTH=\"100%\" HEIGHT=1 VSPACE=0 HSPACE=0 BORDER=0></TD>\n</tr>\n";
	echo "<tr>\n";

	$pedborder = $slot % 2 ? "" : "class=\"pedborderleft\"";
	//if( $slot % 2 == 0 ) {
		//echo "<td rowspan=\"6\"><IMG SRC=\"$cms[tngpath]" . "black.gif\" HEIGHT=90 WIDTH=1 VSPACE=0 HSPACE=0 BORDER=0></td>\n";
	//}
	//else {
		//echo "<td rowspan=\"4\"><IMG SRC=\"$cms[tngpath]" . "spacer.gif\" WIDTH=1 HEIGHT=1 BORDER=0 HSPACE=0 VSPACE=0></td>\n";
	//}
	if( $row[allow_living] ) {
		if( $row[birthdate] || $row[altbirthdate] || $row[altbirthplace] || $row[deathdate] || $row[burialdate] || $row[burialplace] || ( $slot % 2 == 0 && ( $marrdate[$slot] || $marrplace[$slot] ) ) )
			$dataflag = 1;
		else
			$dataflag = 0;
		if( $row[altbirthdate] && !$row[birthdate] ) {
			echo "<TD valign=\"top\" $pedborder><span class=\"normal\">&nbsp;$text[capaltbirthabbr]:</span></td>\n";
			echo "<TD valign=\"top\"><span class=\"normal\">" . displayDate( $row[altbirthdate] ) . "&nbsp;</span></td>\n</tr>\n";
			echo "<tr>\n<TD valign=\"top\" $pedborder><span class=\"normal\">&nbsp;$text[capplaceabbr]:&nbsp;</span></td>\n";
			echo "<TD valign=\"top\"><span class=\"normal\">$row[altbirthplace]&nbsp;</span></td>\n</tr>\n";
		}
		elseif( $dataflag ) {
			echo "<TD valign=\"top\" $pedborder><span class=\"normal\">&nbsp;$text[capbirthabbr]:</span></td>\n";
			echo "<TD valign=\"top\"><span class=\"normal\">" . displayDate( $row[birthdate] ) . "&nbsp;</span></td></tr>\n";
			echo "<tr>\n<TD valign=\"top\" $pedborder><span class=\"normal\">&nbsp;$text[capplaceabbr]:&nbsp;</span></td>\n";
			echo "<TD valign=\"top\"><span class=\"normal\">$row[birthplace]&nbsp;</span></td>\n</tr>\n";
		}
		else
			showBlank("class=\"pedborderleft\"");
		if( $slot % 2 == 0 ) {
			if( $dataflag ) {
				echo "<tr>\n<TD valign=\"top\" class=\"pedborderleft\"><span class=\"normal\">&nbsp;$text[capmarrabbr]:</span></td>\n";
				echo "<TD valign=\"top\"><span class=\"normal\">" . displayDate( $marrdate[$slot] ) . "&nbsp;</span></td>\n</tr>\n";
				echo "<tr>\n<TD valign=\"top\" class=\"pedborderleft\"><span class=\"normal\">&nbsp;$text[capplaceabbr]:&nbsp;</span></td>\n";
				echo "<TD valign=\"top\"><span class=\"normal\">$marrplace[$slot]&nbsp;</span></td>\n</tr>\n";
			}
			else {
				echo "<tr>\n";
				showBlank($pedborder);
			}
		}
		if( $row[burialdate] && !$row[deathdate] ) {
			echo "<tr>\n<TD valign=\"top\" $pedborder><span class=\"normal\">&nbsp;$text[capburialabbr]:</span></td>\n";
			echo "<TD valign=\"top\"><span class=\"normal\">" . displayDate( $row[burialdate] ) . "&nbsp;</span></td>\n</tr>\n";
			echo "<tr>\n<TD valign=\"top\" $pedborder><span class=\"normal\">&nbsp;$text[capplaceabbr]:&nbsp;</span></td>\n";
			echo "<TD valign=\"top\"><span class=\"normal\">$row[burialplace]&nbsp;</span></td>\n</tr>\n</table>\n";
		}
		elseif( $dataflag ) {
			echo "<tr>\n<TD valign=\"top\" $pedborder><span class=\"normal\">&nbsp;$text[capdeathabbr]:</span></td>\n";
			echo "<TD valign=\"top\"><span class=\"normal\">" . displayDate( $row[deathdate] ) . "&nbsp;</span></td></tr>\n";
			echo "<tr>\n<TD valign=\"top\" $pedborder><span class=\"normal\">&nbsp;$text[capplaceabbr]:&nbsp;</span></td>\n";
			echo "<TD valign=\"top\"><span class=\"normal\">$row[deathplace]&nbsp;</span></td>\n</tr>\n</table>\n";
		}
		else {
			echo "<tr>\n";
			showBlank($pedborder);
			echo "</table>\n";
		}
	}
	else {
		echo "<tr>\n";
		showBlank($pedborder);
		if( $slot % 2 == 0 ) {
			echo "<tr>\n";
			showBlank($pedborder);
		}
		echo "<tr>\n";
		showBlank($pedborder);
		echo "</table>\n";
	}
	
	if( $slot % 2 == 0 ) {
		echo "<table border=0 cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
		echo "<td width=1><IMG SRC=\"$cms[tngpath]" . "black.gif\" HEIGHT=$vertfill WIDTH=1 VSPACE=0 HSPACE=0 BORDER=0></td>\n";
		echo "<td width=\"100%\"></td>\n</tr>\n</table>\n";
	}
	else {
		echo "<table border=0 cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n<tr>\n";
		echo "<td colspan=\"2\" width=\"100%\"><IMG SRC=\"$cms[tngpath]" . "spacer.gif\" HEIGHT=$vertfill WIDTH=1 VSPACE=0 HSPACE=0 BORDER=0></td>\n</tr>\n</table>\n";
	}
	echo "</td>\n";
	
	$generation++;
	if( $nextslot < $pedmax ) {
		$husband = "";
		$wife = "";
		$marrdate[ $nextslot ] = "";
		$marrplace[ $nextslot ] = "";

		if( $key ) {
			$parentfamID = "";
			$locparentset = $parentset;
			$parentscount = 0;
			$parentfamIDs = array();
			$query = "SELECT familyID FROM $children_table WHERE personID = \"$key\" AND gedcom = \"$tree\" ORDER BY parentorder";
			$parents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if ( $parents ) {
				$parentscount = mysql_num_rows( $parents );
				if ( $parentscount > 0 ) {
					if ( $locparentset > $parentscount )
						$locparentset = $parentscount;
					$i = 0;
					while ( $parentrow = mysql_fetch_assoc( $parents ) ) {
						$i++;
						if( $i == $locparentset )
							$parentfamID = $parentrow[familyID];
						$parentfamIDs[$i] = $parentrow[familyID];
					}
					if(!$parentfamID) $parentfamID = $row[famc];
				}
				mysql_free_result($parents);
			}

			$query = "SELECT husband, wife, marrdate, marrplace, living, branch FROM $families_table WHERE familyID = \"$parentfamID\" AND gedcom = \"$tree\"";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( $result2 ) {
				$newrow = mysql_fetch_assoc( $result2 );
				$husband = $newrow[husband];
				$wife = $newrow[wife];
				$newrow[allow_living] = !$newrow[living] || ( $allow_living && checkbranch( $newrow[branch] ) ) ? 1 : 0;
				if( $newrow[allow_living] ) {
					$marrdate[ $nextslot ] = $newrow[marrdate];
					$marrplace[ $nextslot ] = $newrow[marrplace];
				}
				else {
					$marrdate[ $nextslot ] = "";
					$marrplace[ $nextslot ] = "";
				}
				mysql_free_result($result2);
			}
		}
		displayIndividual( $husband, $generation, $nextslot );
		$nextslot++;
		displayIndividual( $wife, $generation, $nextslot );
	}
}

$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row[branch] );
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$pedname = getName( $row );
	$logname = $nonames && $row[living] ? $text[living] : $pedname;
	$disallowgedcreate = $row[disallowgedcreate];
	mysql_free_result($result);
}

if( !$pedigree[maxgen] ) $pedigree[maxgen] = 6;
if( $generations > $pedigree[maxgen] ) 
    $generations = $pedigree[maxgen];
else if( !$generations ) 
    $generations = $pedigree[maxgen] < 4 ? $pedigree[maxgen] : 4;

$pedmax = pow( 2, intval($generations) );
$key = $personID;

$gentext = xmlcharacters($text[generations]);
writelog( "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations&amp;display=textonly\">" . xmlcharacters("$text[pedigreefor] $logname ($personID)") . "</a> $generations " . $gentext );
preparebookmark( "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations&amp;display=textonly\">" . xmlcharacters("$text[pedigreefor] $pedname ($personID)") . "</a> $generations " . $gentext );

$flags[tabs] = $tngconfig[tabs];
$flags[scripting] = "<style>
.pedborderleft {
	border-left: solid 1.2px black;
	}
</style>";
$flags['scripting'] .= "<script type=\"text/javascript\">var tnglitbox;</script>\n";

tng_header( "$text[pedigreefor] $pedname", $flags );
?>

<?php 
	$photostr = showSmallPhoto( $personID, $pedname, $row[allow_living], 0 );
	echo tng_DrawHeading( $photostr, $pedname, getYears( $row ) );
	echo tng_coreicons();

	$innermenu = "$text[generations]: &nbsp;";
	$innermenu .= "<select name=\"generations\" style=\"font-size:9px\" onChange=\"window.location.href='$pedigreetext_url" . "personID=$personID&tree=$tree&parentset=$parentset&display=$display&generations=' + this.options[this.selectedIndex].value\">\n";
    for( $i = 1; $i <= $pedigree[maxgen]; $i++ ) {
        $innermenu .= "<option value=\"$i\"";
        if( $i == $generations ) $innermenu .= " selected";
        $innermenu .= ">$i</option>\n";
    }
	$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
	$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=standard&amp;generations=$generations\" class=\"lightlink\" id=\"stdpedlnk\">$text[pedstandard]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=compact&amp;generations=$generations\" class=\"lightlink\" id=\"compedlnk\">$text[pedcompact]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=box&amp;generations=$generations\" class=\"lightlink\" id=\"boxpedlnk\">$text[pedbox]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$pedigreetext_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink3\">$text[pedtextonly]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$ahnentafel_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink\">$text[ahnentafel]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$extrastree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;showall=1&amp;generations=$generations\" class=\"lightlink\">$text[media]</a>\n";
	if($generations <= 6)
		$innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"#\" class=\"lightlink\" onclick=\"tnglitbox = new LITBox('$pdfform_url" . "pdftype=ped&personID=$personID&tree=$tree&generations=$generations',{width:350,height:350});return false;\">PDF</a>\n";

	echo getFORM( "pedigree", "", "form1", "form1" );
	echo tng_menu( "I", "pedigree", $personID, $innermenu );
	echo "</form>\n";
?>
<table border=0 cellspacing="0" cellpadding="0" width="100%">
<tr>
<?php
$slot = 1;
displayIndividual( $personID, 1, $slot );
?>
</tr>
</table>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>litbox.js"></script>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>rpt_utils.js"></script>
<?php
	tng_footer( "" ); 
?>
