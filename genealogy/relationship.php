<?php
include("begin.php");
include($subroot . "pedconfig.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "relate";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php");
include($cms['tngpath'] . "browserinfo.php");

$relate_url = getURL( "relateform", 1 );
$relationship_url = getURL( "relationship", 1 );

$spouseflag = 0;
$highest = 0;
$lowest = 0;

function switchGender($gender) {
	return $gender == "M" ? "F" : ($gender == "F" ? "M" : $gender);
}

function getRelMsg($spouseflag, $namestr, $gender1, $namestr2, $gender2, $messages ) {
	global $text;

	if( $spouseflag ) {
		$spousemsg = $gender1 == "M" ? $text[rhusband] : ($gender1 == "F" ? $text[rwife] : $text[rspouse]);
		$gender1 = switchGender($gender1);
	}
	if( $gender1 == "M" )
		$reldesc = $messages[0];
	elseif( $gender1 = "F" )
		$reldesc = $messages[1];
	else
		$reldesc = $messages[2];
	return "$namestr $text[is] $spousemsg $reldesc $namestr2";
}

if( $generations > $pedigree[maxupgen])
	$generations = $pedigree[maxupgen];
if( $secondpersonID ) {
	$secondpersonID = strtoupper( $secondpersonID );
	session_register('relatepersonID');
	session_register('relatetreeID');
	$relatepersonID = $_SESSION[relatepersonID] = $secondpersonID;
	$relatetreeID = $_SESSION[relatetreeID] = $tree;
}
else
	$secondpersonID = $savedpersonID;
	
if( $altprimarypersonID )
	$primarypersonID = strtoupper( $altprimarypersonID );

$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, branch, disallowgedcreate, birthdatetr, altbirthdatetr, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$primarypersonID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( mysql_num_rows($result) ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row[branch] );
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$namestr = getName( $row );
	$logname = $nonames && $row[living] ? $text[living] : $namestr;
	$disallowgedcreate = $row[disallowgedcreate];
	$gender1 = $row[sex];
}
else
	$error = $primarypersonID;
mysql_free_result($result);

$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, branch, birthdatetr, altbirthdatetr FROM $people_table WHERE personID = \"$secondpersonID\" AND gedcom = \"$tree\"";
$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( mysql_num_rows($result2) ) {
	$row2 = mysql_fetch_assoc( $result2 );
	$row2[allow_living] = !$row2[living] || $livedefault == 2 || ( $allow_living && checkbranch( $row2[branch] ) ) ? 1 : 0;
	$namestr2 = getName( $row2 );
	$logname2 = $nonames && $row2[living] ? $text[living] : $namestr2;
	$gender2 = $row2[sex];
}
else
	$error = $secondpersonID;
mysql_free_result($result2);

writelog( "<a href=\"$relationship_url" . "altprimarypersonID=$primarypersonID&amp;tree=$tree&amp;secondpersonID=$secondpersonID\">$text[relcalc]: $logname ($primarypersonID) =&gt;$logname2 ($secondpersonID)</a>" );
preparebookmark( "<a href=\"$relationship_url" . "altprimarypersonID=$primarypersonID&amp;tree=$tree&amp;secondpersonID=$secondpersonID\">$text[relcalc]: $namestr ($primarypersonID) =&gt;$namestr2 ($secondpersonID)</a>" );

$getperson_url = getURL( "getperson", 1 );
$pedigree[url] = getURL( "pedigree", 1 );
$pedigree[cellpad] = 5;
$offsetV = -1;
$firstone = 1;
$maxupgen = $generations ? $generations : $pedigree[maxupgen];

if ($pedigree[inclphotos] && (trim($photopath) == "" || trim($photosext) == "" )) $pedigree[inclphotos] = false;
if (file_exists($cms[tngpath] . "Chart.gif")) {
	$chartlinkimg = @GetImageSize($cms[tngpath] . "Chart.gif");
	$pedigree[chartlink] = "<img src=\"$cms[tngpath]" . "Chart.gif\" border=\"0\" $chartlinkimg[3] title=\"$text[popupnote2]\">";
}
else
	$pedigree[chartlink] = "<span class=\"normal\"><b>P</b></span>";
$pedigree[phototree] = $tree;
if( $tree ) $pedigree[phototree] .= ".";

if( $pedigree[usepopups] )
	$pedigree[display] = "compact";
else
	$pedigree[display] = "standard";
	
$pedigree[baseR] = hexdec( substr( $pedigree[boxcolor], 1, 2 ) );
$pedigree[baseG] = hexdec( substr( $pedigree[boxcolor], 3, 2 ) );
$pedigree[baseB] = hexdec( substr( $pedigree[boxcolor], 5, 2 ) );

if( $pedigree[colorshift] > 0 ) {
	$extreme = $pedigree[baseR] < $pedigree[baseG] ? $pedigree[baseR] : $pedigree[baseG];
	$extreme = $extreme < $pedigree[baseB] ? $extreme : $pedigree[baseB];
}
elseif( $pedigree[colorshift] < 0 ) {
	$extreme = $pedigree[baseR] > $pedigree[baseG] ? $pedigree[baseR] : $pedigree[baseG];
	$extreme = $extreme > $pedigree[baseB] ? $extreme : $pedigree[baseB];
}
$pedigree[colorshift] = round( $pedigree[colorshift] / 100 * $extreme / 4 );

$downarray = array();
$uparray = array();

function drawCouple( $couple, $topflag, $linedown ) {
	global $pedigree, $offsetV, $offsetH, $firstone;

	$drawpersonID = $couple[person];
	$offsetH = $topflag ? $pedigree[leftindent] + $pedigree[puboxwidth] + $pedigree[boxHsep] : $pedigree[leftindent];
	if( $drawpersonID ) {
		drawBox( $drawpersonID, 0, $topflag );
		if( $firstone ) {
			//short line below box of first couple
			if( $linedown ) {
				echo "<div style=\"position:absolute;background-color:$pedigree[bordercolor]; font-size:0px;top:" . ($offsetV + $pedigree[puboxheight] - intval($pedigree[linewidth]/2)). "px;left:" . ($offsetH + intval($pedigree[puboxwidth]/2)) . "px;height:" . (2 * $pedigree[boxVsep]) . "px;width:$pedigree[linewidth]px;z-index:3\"></div>\n";
				echo "<div style=\"position:absolute;background-color:$pedigree[shadowcolor]; font-size:0px;top:" . ($offsetV + $pedigree[puboxheight] - intval($pedigree[linewidth]/2) + $pedigree[shadowoffset] + 1) . "px;left:" . ($offsetH + intval($pedigree[puboxwidth]/2) + $pedigree[shadowoffset] + 1) . "px;height:" . (2 * $pedigree[boxVsep]) . "px;width:$pedigree[linewidth]px;z-index:1\"></div>\n";
			}
			$firstone = 0;
		}
		else {
			//line coming up from top of other boxes
			echo "<div style=\"position:absolute;background-color:$pedigree[bordercolor]; font-size:0px;top:" . ($offsetV - (2 * $pedigree[boxVsep]) - intval($pedigree[linewidth]/2)). "px;left:" . ($offsetH + intval($pedigree[puboxwidth]/2)) . "px;height:" . (2 * $pedigree[boxVsep]) . "px;width:$pedigree[linewidth]px;z-index:3\"></div>\n";
			echo "<div style=\"position:absolute;background-color:$pedigree[shadowcolor]; font-size:0px;top:" . ($offsetV - (2 * $pedigree[boxVsep]) - intval($pedigree[linewidth]/2) + $pedigree[shadowoffset] + 1) . "px;left:" . ($offsetH + intval($pedigree[puboxwidth]/2) + $pedigree[shadowoffset] + 1) . "px;height:" . (2 * $pedigree[boxVsep]) . "px;width:$pedigree[linewidth]px;z-index:1\"></div>\n";
		}
	}
	$spouseID = $couple[spouse];
	if( $spouseID ) {
		echo "<div style=\"position:absolute;background-color:$pedigree[bordercolor]; top:" . ($offsetV + intval($pedigree[puboxheight]/2) - intval($pedigree[linewidth]/2)) . "px;left:" . ($offsetH + $pedigree[puboxwidth]) . "px;height:$pedigree[linewidth]px;width:" . (intval($pedigree[boxHsep]/2) + 1) . "px;z-index:3;overflow:hidden;\"></div>\n";
		echo "<div style=\"position:absolute;background-color:$pedigree[shadowcolor]; top:" . ($offsetV + intval($pedigree[puboxheight]/2) - intval($pedigree[linewidth]/2) + $pedigree[shadowoffset] + 1) . "px;left:" . ($offsetH + $pedigree[puboxwidth] + $pedigree[shadowoffset] + 1) . "px;height:$pedigree[linewidth]px;width:" . (intval($pedigree[boxHsep]/2) + 1) . "px;z-index:1;overflow:hidden;\"></div>\n";
		$offsetH = $offsetH + $pedigree[puboxwidth] + intval($pedigree[boxHsep]/2);
		drawBox( $spouseID, 1, $topflag );
	}
	if( $topflag ) {
		//long connecting line
		echo "<div style=\"position:absolute;background-color:$pedigree[bordercolor]; top:" . ($offsetV + $pedigree[puboxheight] + (2 * $pedigree[boxVsep]) - intval($pedigree[linewidth]/2)) . "px;left:" . ($pedigree[leftindent] + intval($pedigree[puboxwidth]/2)) . "px;height:$pedigree[linewidth]px;width:" . ((2 * $pedigree[puboxwidth]) + $pedigree[boxHsep] + $pedigree[leftindent] + 1) . "px;z-index:3;overflow:hidden;\"></div>\n";
		echo "<div style=\"position:absolute;background-color:$pedigree[shadowcolor]; top:" . ($offsetV + $pedigree[puboxheight] + (2 * $pedigree[boxVsep]) - intval($pedigree[linewidth]/2) + $pedigree[shadowoffset] + 1) . "px;left:" . ($pedigree[leftindent] + intval($pedigree[puboxwidth]/2) + $pedigree[shadowoffset] + 1) . "px;height:$pedigree[linewidth]px;width:" . ((2 * $pedigree[puboxwidth]) + $pedigree[boxHsep] + $pedigree[leftindent] + 1) . "px;z-index:1;overflow:hidden;\"></div>\n";
		$offsetV += (2 * $pedigree[boxVsep]);
	}
}

//function drawBox( $drawpersonID, $spouseflag, $topflag ) {
//}
function drawBox( $drawpersonID, $spouseflag, $topflag ) {
	global $pedigree, $offsetV, $offsetH, $rootpath, $photopath, $tree, $photosext, $allow_living, $getperson_url, $nonames, $pedigree;
	global $text, $people_table, $personID1, $primarypersonID, $livedefault;

	if( $spouseflag && !$topflag )
		$boxcolortouse = getColor(1);
	else
		$boxcolortouse = getColor(0);

	$namefontsztouse = $pedigree[boxnamesize] - 2;
	$pedigree[begnamefont] = "<span style=\"font-size:$namefontsztouse"."pt\">";
	$pedigree[endfont] = "</span>";

	$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, branch, famc, sex, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace FROM $people_table WHERE personID = \"$drawpersonID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $result ) {
		$row = mysql_fetch_assoc( $result );
		$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && checkbranch( $row[branch] ) ) ? 1 : 0;
		$nameinfo_org = getName( $row );
		if( $drawpersonID == $personID1 || $drawpersonID == $primarypersonID )
			$nameinfo = "<strong>$nameinfo_org</strong>";
		else
			$nameinfo = $nameinfo_org;
		$pedigree[namelink] = "<a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$tree\">$nameinfo</a>";
	
		$newoffset = $spouseflag ? $offsetV : $offsetV + $pedigree[puboxheight] + 2 * $pedigree[boxVsep];
		$offsetV = $offsetV == -1 ? 0 : $newoffset;
		//$offsetV = 200;
		echo "<div style=\"position:absolute; background-color:$boxcolortouse; top:$offsetV" . "px; left:$offsetH" . "px; height:$pedigree[puboxheight]" . "px; width:$pedigree[puboxwidth]" . "px; z-index:5; overflow:hidden;\">\n";
		$tableheight = $pedigree[puboxheight];
	    echo "<table border=\"0\" cellpadding=\"$pedigree[cellpad]\" cellspacing=\"0\" align=\"$pedigree[puboxalign]\"><tr>";
		
	    // implant a picture (maybe)
		if( $pedigree[inclphotos] ) {
			$photohtouse = $pedigree[puboxheight] - ( $pedigree[cellpad] * 2 ); // take cellpadding into account
			$photostr = showSmallPhoto( $row[personID], $nameinfo_org, $row[allow_living], $photohtouse );
			if( $photostr )
				echo "<td align=left valign=top>$photostr</td>";
		}
			
	    // name info
	    echo "<td align=\"$pedigree[puboxalign]\" class=\"pboxname\" style=\"height:$tableheight\">$pedigree[begnamefont]" . $pedigree[namelink] . $pedigree[endfont];
		if( $row[famc] && $pedigree[popupchartlinks])
			echo " <a href=\"$pedigree[url]" . "personID=$row[personID]&amp;tree=$tree&amp;display=$pedigree[display]\">$pedigree[chartlink]</a>";
	
		echo "</td></tr></table></div>\n";
		//end box
		
		echo "<div style=\"position:absolute; background-color:$pedigree[bordercolor]; top:" . ($offsetV-$pedigree[borderwidth]) . "px;left:" . ($offsetH-$pedigree[borderwidth]) . "px;height:" . ($pedigree[puboxheight]+(2*$pedigree[borderwidth])) . "px;width:" . ($pedigree[puboxwidth]+(2*$pedigree[borderwidth])) . "px;z-index:4\"></div>\n";
		echo "<div style=\"position:absolute; background-color:$pedigree[shadowcolor]; top:" . ($offsetV-$pedigree[borderwidth]+$pedigree[shadowoffset]) . "px;left:" . ($offsetH-$pedigree[borderwidth]+$pedigree[shadowoffset]) . "px;height:" . ($pedigree[puboxheight]+(2*$pedigree[borderwidth])) . "px;width:" . ($pedigree[puboxwidth]+(2*$pedigree[borderwidth])) . "px;z-index:1\"></div>\n";
		//keep track of total chart height
		mysql_free_result($result);
	}
}

function doMultSpouse( $prispouse1, $otherspouse, $prispouse2 ) {
	global $pedigree, $offsetV, $firstone;
	
	echo "<div style=\"position:absolute;background-color:$pedigree[bordercolor]; top:" . ($offsetV - intval($pedigree[linewidth]/2)) . "px;left:" . ($pedigree[leftindent] + intval($pedigree[puboxwidth]/2)) . "px;height:$pedigree[linewidth]px;width:" . ((2 * $pedigree[puboxwidth]) + $pedigree[boxHsep] + $pedigree[leftindent] + 1) . "px;z-index:3;overflow:hidden;\"></div>\n";
	echo "<div style=\"position:absolute;background-color:$pedigree[shadowcolor]; top:" . ($offsetV - intval($pedigree[linewidth]/2) + $pedigree[shadowoffset] + 1) . "px;left:" . ($pedigree[leftindent] + intval($pedigree[puboxwidth]/2) + $pedigree[shadowoffset] + 1) . "px;height:$pedigree[linewidth]px;width:" . ((2 * $pedigree[puboxwidth]) + $pedigree[boxHsep] + $pedigree[leftindent] + 1) . "px;z-index:1;overflow:hidden;\"></div>\n";
	$offsetV -= $pedigree[puboxheight];
	
	$couple[person] = $prispouse1;
	$couple[spouse] = $otherspouse;
	$firstone = 0;
	drawCouple( $couple, 0, 0);
	$saveindent = $pedigree[leftindent];
	$pedigree[leftindent] += (2 * $pedigree[puboxwidth]) + $pedigree[boxHsep] + $pedigree[leftindent];
	$couple[person] = $prispouse1;
	$couple[spouse] = $prispouse2;
	$offsetV -= $pedigree[puboxheight] + 2 * $pedigree[boxVsep];
	drawCouple( $couple, 0, 0);
	$pedigree[leftindent] = $saveindent;
}

//check ancestors of person1 to see if you find person2
function checkpersonup( $checkpersonID, $spouseID, $gensup ) {
	global $text, $tree, $targetID, $children_table, $families_table, $uparray, $maxupgen, $highest, $gens;
	
	$gens[match] = 0;
	$gens[down] = 0;
	$couple[person] = $checkpersonID;
	$couple[spouse] = $spouseID;
	array_push($uparray, $couple);

	if( $gensup > $highest ) $highest = $gensup;

	//echo "up: person=$checkpersonID, spouse=$spouseID, up=$gensup<br/>\n";
    //get all families in which this person is a child -- for each family
	$query = "SELECT familyID FROM $children_table WHERE personID = \"$checkpersonID\" AND gedcom = \"$tree\" ORDER BY ordernum";
	$familyresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	while( $familyrow = mysql_fetch_assoc( $familyresult ) ) {
        //get children in family -- for each child in family 
		$query = "SELECT husband, wife FROM $families_table WHERE familyID = \"$familyrow[familyID]\" AND gedcom = \"$tree\"";
		$parentsresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

		$query = "SELECT personID FROM $children_table WHERE familyID = \"$familyrow[familyID]\" AND personID != \"$checkpersonID\" AND gedcom = \"$tree\" ORDER BY ordernum";
		$childresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		while( $childrow = mysql_fetch_assoc( $childresult ) ) {
            $gens = checkpersondown( $childrow[personID], 0, $gensup );
			if( $gens[match] ) {
				$gens[up] = $gensup;
				if( $parentsresult ) {
					$parentrow = mysql_fetch_assoc( $parentsresult );
					$couple[person] = $parentrow[husband] ? $parentrow[husband] : $parentrow[wife];
					$couple[spouse] = $parentrow[husband] ? $parentrow[wife] : "";
					//echo "setting parents<br>\n";
					drawCouple( $couple, 1, 1);
					$gens[parents] = 1;
				}
				return $gens;
			}
		}
		mysql_free_result( $childresult );
		
		if( $parentsresult ) {
			$parentrow = mysql_fetch_assoc( $parentsresult );

			//if we're here then we didn't find the person among the husband & wife's children
			//now we need to check children of other spouses of each parent
			//find all families where the husband is the same but the wife is different
			if( $parentrow[husband] ) {
				$query = "SELECT familyID, wife FROM $families_table WHERE husband = \"$parentrow[husband]\" AND wife != \"$parentrow[wife]\" AND gedcom = \"$tree\"";
				$osresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				while( $osrow = mysql_fetch_assoc( $osresult ) ) {
					$query = "SELECT personID FROM $children_table WHERE familyID = \"$osrow[familyID]\" AND gedcom = \"$tree\" ORDER BY ordernum";
					$childresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
					while( $childrow = mysql_fetch_assoc( $childresult ) ) {
			            $gens = checkpersondown( $childrow[personID], 0, $gensup );
						if( $gens[match] ) {
							$gens[up] = $gensup;
	
							doMultSpouse( $parentrow[husband], $osrow[wife], $parentrow[wife] );
							//echo "setting parents2<br>\n";
							$gens[parents] = 1;
							
							return $gens;
						}
					}
					mysql_free_result( $childresult );
				}
				mysql_free_result( $osresult );
			}
			
			//find all families where the wife is the same but the husband is different
			if( $parentrow[wife] ) {
				$query = "SELECT familyID, husband FROM $families_table WHERE husband != \"$parentrow[husband]\" AND wife = \"$parentrow[wife]\" AND gedcom = \"$tree\"";
				$osresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				while( $osrow = mysql_fetch_assoc( $osresult ) ) {
					$query = "SELECT personID FROM $children_table WHERE familyID = \"$osrow[familyID]\" AND gedcom = \"$tree\" ORDER BY ordernum";
					$childresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
					while( $childrow = mysql_fetch_assoc( $childresult ) ) {
			            $gens = checkpersondown( $childrow[personID], 0, $gensup );
						if( $gens[match] ) {
							$gens[up] = $gensup;

							doMultSpouse( $parentrow[wife], $osrow[husband], $parentrow[husband] );
							//echo "setting parents3<br>\n";
							$gens[parents] = 1;
	
							return $gens;
						}
					}
					mysql_free_result( $childresult );
				}
				mysql_free_result( $osresult );
			}
				
			//if found, then draw original parents on left, other parents to right with line connecting the common spouse

			if( !$gens[match] && $parentrow[husband] && ($gensup < $maxupgen) )
		        $gens = checkpersonup( $parentrow[husband], $parentrow[wife], $gensup + 1);
			if( !$gens[match] && $parentrow[wife] && ($gensup < $maxupgen) )
		        $gens = checkpersonup( $parentrow[wife], $parentrow[husband], $gensup + 1);
			
			if( $gens[match] ) {
				return $gens;
			}
			mysql_free_result( $parentsresult );
		}
	}
	mysql_free_result( $familyresult );
	
	array_pop($uparray);
	$gens[up] = 0;
	return $gens;
}

//check descendants of person1 to see if you find person2
function checkpersondown( $checkpersonID, $gensdown, $gensup ) {
	global $text, $tree, $targetID, $families_table, $people_table, $children_table, $downarray, $primarypersonID, $secondpersonID, $maxupgen, $spouseflag;
	global $msg, $lowest, $highest, $gens, $otherID;

	$gens[match] = 0;
	//$gens[up] = 0;
	if( $gensdown > $lowest ) $lowest = $gensdown;

	//echo "down: person=$checkpersonID, down=$gensdown, up = $gensup<br/>\n";
    //check person
	if( $checkpersonID != $targetID ) {
		//get sex of each individual
		$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, living, famc, sex, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace FROM $people_table WHERE personID = \"$checkpersonID\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( $result ) {
			$row = mysql_fetch_assoc($result);
			if ( $row[sex] == "M" ) {
				$spouse = "wife"; $self = "husband"; $spouseorder = "husborder";
			}
			else if ($row[sex] == "F" ) {
				$spouse = "husband"; $self = "wife"; $spouseorder = "wifeorder";
			}
			else
				$spouseorder = "";
			if( $spouseorder ) {
				//get spouses -- for each spouse
				$query = "SELECT $spouse, familyID FROM $families_table WHERE $self = \"$checkpersonID\" AND gedcom = \"$tree\" ORDER BY $spouseorder";
				$spouseresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

				while( $spouserow = mysql_fetch_assoc( $spouseresult ) ) {
			        //check spouse
					if( $spouserow[$spouse] != $targetID ) {
				        //get children -- for each child
						if( $gensdown < $maxupgen ) {
							$query = "SELECT personID FROM $children_table WHERE familyID = \"$spouserow[familyID]\" AND gedcom = \"$tree\" ORDER BY ordernum";
							$childresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
							while( $childrow = mysql_fetch_assoc( $childresult ) ) {
					            $gens = checkpersondown( $childrow[personID], $gensdown + 1, $gensup );
								if( $gens[match] )
									break;
							}
							mysql_free_result( $childresult );
						}
					}
					else {
						$gens[down] = $gensdown;
						$gens[match] = 1;
						//echo "got match 1, spouse=" . $spouserow[$spouse] . ", lowest=$lowest, sec=$secondpersonID<br>\n";
						$spouseflag = 1;
						if( !$gens[down] && !$gensup && $spouserow[$spouse] == $targetID && $checkpersonID == $otherID ) {
						//if( !$gens[down] && !$gensup && !$lowest ) {
							$couple[spouse] = $checkpersonID;
							$couple[person] = $spouserow[$spouse];
							$gens[spouses] = 1;
							//echo "setting spouse, $lowest<br>\n";
							drawCouple( $couple, 0, 0 );
							//echo "drew couple<br>\n";
						}
					}
					if( $gens[match] )
						break;
				}
				mysql_free_result( $spouseresult );
			}
			if( $gens[match] ) {
				$couple[person] = $checkpersonID;
				$couple[spouse] = $spouserow[$spouse];
				array_push($downarray, $couple);
			}
			mysql_free_result($result);
		}
	}
	else {
		$gens[down] = $gensdown;
		//echo "got match 2<br>\n";
		$gens[match] = 1;
		$couple[person] = $checkpersonID;
		$couple[spouse] = "";
		array_push($downarray, $couple);
	}

	return $gens;
}

function getColor( $shifts ) {
	global $pedigree;
	
	$shiftval = $shifts * $pedigree[colorshift];
	$R = $pedigree[baseR] + $shiftval;
	$G = $pedigree[baseG] + $shiftval;
	$B = $pedigree[baseB] + $shiftval;
	if ( $R > 255 ) $R = 255; if ( $R < 0 ) $R = 0;
	if ( $G > 255 ) $G = 255; if ( $G < 0 ) $G = 0;
	if ( $B > 255 ) $B = 255; if ( $B < 0 ) $B = 0;
	$R = str_pad( dechex($R), 2, "0", STR_PAD_LEFT );
	$G = str_pad( dechex($G), 2, "0", STR_PAD_LEFT ); 
	$B = str_pad( dechex($B), 2, "0", STR_PAD_LEFT );
	return "#$R$G$B";
}

$flags[tabs] = $tngconfig[tabs];
tng_header( $text[relcalc], $flags );

	$photostr = showSmallPhoto( $primarypersonID, $namestr, $row[allow_living], 0 );
	echo tng_DrawHeading( $photostr, $namestr, getYears( $row ) );
	echo tng_coreicons();

	$innermenu = "$text[generations]: &nbsp;";
	$innermenu .= "<select name=\"generations\" style=\"font-size:9px\">\n";
    for( $i = 1; $i <= $pedigree[maxupgen]; $i++ ) {
        $innermenu .= "<option value=\"$i\"";
        if( $i == $generations ) $innermenu .= " selected";
        $innermenu .= ">$i</option>\n";
    }
	$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
	$innermenu .= "<a href=\"#\" class=\"lightlink\" onClick=\"document.form1.submit();\">$text[refresh]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$relate_url" . "primaryID=$primarypersonID&amp;tree=$tree\" class=\"lightlink\">$text[findanother]</a>\n";
	
	echo getFORM( "relationship2", "get", "form1", "form1" );
	echo tng_menu( "I", "relate", $primarypersonID, $innermenu );
	echo "<input type=\"hidden\" name=\"primarypersonID\" value=\"$primarypersonID\">\n";
	echo "<input type=\"hidden\" name=\"savedpersonID\" value=\"$secondpersonID\">\n";
	echo "<input type=\"hidden\" name=\"tree\" value=\"$tree\">\n";
	echo "</form>\n";
?>
<span class="subhead"><strong><?php echo "$text[relateto] $namestr2"; ?></strong></span><br/><br/>
<?php
	echo "<div align=\"left\" style=\"position:relative;\">";
	//echo "down=$gens[down], up=$gens[up]<br>";

	if( !$error ) {
		//first target should be person with later birthdate
		$birthdate1 = $row[birthdatetr] ? $row[birthdatetr] : $row[altbirthdatetr];
		$birthdate2 = $row2[birthdatetr] ? $row2[birthdatetr] : $row2[altbirthdatetr];

		if( $birthdate1 < $birthdate2 ) {
			//switch if necessary
			$temp = $secondpersonID;
			$secondpersonID = $primarypersonID;
			$primarypersonID = $temp;
			$namestr3 = $namestr2;
			$namestr2 = $namestr;
			$namestr = $namestr3;
			$gender3 = $gender2;
			$gender2 = $gender1;
			$gender1 = $gender3;
		}

		$gensdown = 0;
		$gensup = 0;
		$personID1 = $secondpersonID;

		$targetID = $primarypersonID;
		$otherID = $secondpersonID;
		$gens = checkpersondown( $secondpersonID, $gensdown, $gensup );
		//echo "down=$gens[down], up=$gens[up]<br>";
		if( !$gens[match] ) {
			$targetID = $secondpersonID;
			$otherID = $primarypersonID;
			$gens = checkpersondown( $primarypersonID, $gensdown, $gensup );
			if( $gens[match] ) {
				//echo "switching!<br>\n";
				$up = $gens[up];
				$gens[up] = $gens[down];
				$gens[down] = $up;

			}
			else {
				$targetID = $primarypersonID;
				$otherID = $secondpersonID;
				//echo "checking up<br>\n";
			    $gens = checkpersonup( $secondpersonID, "", $gensup );
				if( !$gens[match] ) {
					//echo "switching<br>\n";
					$targetID = $secondpersonID;
					$otherID = $primarypersonID;
				    $gens = checkpersonup( $primarypersonID, "", $gensup );
					$namestr3 = $namestr2;
					$namestr2 = $namestr;
					$namestr = $namestr3;
					$gender3 = $gender2;
					$gender2 = $gender1;
					$gender1 = $gender3;
				}
			}
		}
	}
	//echo "down=$gens[down], up=$gens[up], sp=$gens[spouses], par=$gens[parents]<br>";

	$getoffsetV = $offsetV;
	if( $error )
		echo "<p>$error $text[notvalid]</p>\n";
	elseif( !$gens[match] ) {
		$newstr = ereg_replace( "xxx", $generations, $text[notrelated] );
		echo "<p>$newstr</p>\n";
	}
	elseif( !$gens[up] && !$gens[down] && !$gens[spouses] && !$gens[parents] ) {
		echo "<p>$text[sameperson]</p>\n";
		$gens[match] = 0;
	}
	elseif( !$gens[spouses] ) {
		while( $nextcouple = array_pop( $downarray ) )
			drawCouple( $nextcouple, 0, 1 );
		$offsetV = $getoffsetV;
		$saveindent = $pedigree[leftindent];
		$pedigree[leftindent] += (2 * $pedigree[puboxwidth]) + $pedigree[boxHsep] + $pedigree[leftindent];
		while( $nextcouple = array_pop( $uparray ) )
			drawCouple( $nextcouple, 0, 1 );
	}
	if( $gens[up] || $gens[down] || $gens[spouses] || $gens[parents] ) {
		$maxwidth = $pedigree[borderwidth] + $pedigree[puboxwidth] + $pedigree[boxHsep] + $saveindent;
		$maxwidth = $gens[up] ? 2 * $maxwidth : $maxwidth;
		$maxheight = $pedigree[borderwidth] + $pedigree[puboxheight] + (2 * $pedigree[boxVsep]);
		$maxheight = $gens[down] > $gens[up] ? ($gens[down] + 1) * $maxheight : ($gens[up] + 1) * $maxheight;
		if( $gens[parents] ) $maxheight += $pedigree[borderwidth] + $pedigree[puboxheight] + (3 * $pedigree[boxVsep]);
?>
<table border="0" cellspacing="0" cellpadding="0" width="<?php echo $maxwidth; ?>" height="<?php echo $maxheight; ?>">
<tr><td></td></tr></table>
<?php
	}
	//need indicator for spouse of relative
	//echo "down=$gens[down], up=$gens[up]";
	if( $gens[match] ) {
		$spousemsg = "";
		if( $gens[spouses] )
			$relmsg = "$namestr $text[text_and] $namestr2 $text[spouses]";
		else {
			if( $gens[parents] ) {  //(tree is split at the top)
				//cousins or siblings or aunt/uncle
				if( !$gens[down] && !$gens[up] )
					$relmsg = getRelMsg($spouseflag, $namestr, $gender1, $namestr2, $gender2, array($text[brother],$text[sister],$text[sibling]) );
				elseif( !$gens[down] ) {
					$greats = $gens[up] - 1;
					$greatmsg = $greats ? $text[great] : "";
					$greatmsg = $greats > 1 ? "$greats x $greatmsg" : $greatmsg;
					$relmsg = getRelMsg($spouseflag, $namestr, $gender1, $namestr2, $gender2, array($text[uncle],$text[aunt],$text[uncleaunt]) );
					$relmsg = ereg_replace( "xxx", $greatmsg, $relmsg );
				}
				elseif( !$gens[up] ) {
					$greats = $gens[down] - 1;
					$greatmsg = $greats ? $text[great] : "";
					$greatmsg = $greats > 1 ? "$greats x $greatmsg" : $greatmsg;
					$relmsg = getRelMsg($spouseflag, $namestr, $gender1, $namestr2, $gender2, array($text[nephew],$text[niece],$text[nephnc]) );
					$relmsg = ereg_replace( "xxx", $greatmsg, $relmsg );
				}
				else {
					//they're cousins
					$cousins = $gens[down] <= $gens[up] ? $gens[down] : $gens[up];
					//get sex of person1 to determine male cousin or female cousin (for languages with gender)
					$cousinmsg = $cousins > 1 ? "$cousins x" : "";
					$relmsg = getRelMsg($spouseflag, $namestr, $gender1, $namestr2, $gender2, array($text[mcousin],$text[fcousin],$text[cousin]) );
					$relmsg = ereg_replace( "xxx", $cousinmsg, $relmsg );
					$removed = abs( $gens[down] - $gens[up] );
					if( $removed ) $relmsg .= " $removed $text[removed]";
				}
			}
			else {
				//direct relationship
				if( $gens[down] == 1 || $gens[up] == 1) {
					//son/daughter (get sex of person ?)
					$thisgender = $gens[down] == 1 ? $gender1 : $gender2;
					if( $gens[up] == 1 ) {
						$tempname = $namestr;
						$namestr = $namestr2;
						$namestr2 = $tempname;
					}
					if( $spouseflag )
						$reldesc = $thisgender == "M" ? $text[sil] : ($thisgender == "F" ? $text[dil] : $text[sdil]);
					else {
						if( $thisgender == "M" )
							$reldesc = $text[son];
						elseif( $thisgender = "F" )
							$reldesc = $text[daughter];
						else
							$reldesc = $text[child];
					}
					$relmsg = "$namestr $text[is] $reldesc $namestr2";
				}
				else {
					//great grandson/great granddaughter
					if( $gens[up] ) {
						$tempname = $namestr;
						$namestr = $namestr2;
						$namestr2 = $tempname;
						$greats = $gens[up] - 2;
						$gender3 = $gender2;
						$gender2 = $gender1;
						$gender1 = $gender3;
					}
					else
						$greats = $gens[down] - 2;
					$greatmsg = $greats ? $text[great] : "";
					$greatmsg = $greats > 1 ? "$greats x $greatmsg" : $greatmsg;
					$relmsg = getRelMsg($spouseflag, $namestr, $gender1, $namestr2, $gender2, array($text[gson],$text[gdau],$text[gsondau]) );
					$relmsg = ereg_replace( "xxx", $greatmsg, $relmsg );
				}
			}
		}
		echo $relmsg;
	}
	echo "</div>\n";
	tng_footer( $flags );
?>
