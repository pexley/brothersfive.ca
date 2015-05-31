<?php
include("begin.php");
include($subroot . "pedconfig.php");
include($cms['tngpath'] . "genlib.php");
if(!$personID) die("no args");

$descendtext_url = getURL( "descendtext", 1 );
$register_url = getURL( "register", 1 );
if( $display == "textonly" || ( !$display && !$pedigree[defdesc] ) ) {
	header( "Location: $descendtext_url" . "personID=$personID&tree=$tree&generations=$generations");
}
elseif( $display == "register" || ( !$display && $pedigree[defdesc] == 1 ) ) {
	header( "Location: $register_url" . "personID=$personID&tree=$tree&generations=$generations");
}

$textpart = "pedigree";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );

if( !$display ) {
	if( $pedigree['defdesc'] == 2)
		$display = "standard";
	else
		$display = "compact";
}

function setTopMarker($level,$value,$debug) {
	global $topmarker;

	//echo "level=$level, old=" . $topmarker[$level] . ", new=$value ($debug)<br>";
	$topmarker[$level] = $value;
}

$getperson_url = getURL( "getperson", 1 );
$descend_url = getURL( "descend", 1 );
$pdfform_url = getURL( "pdfform", 1 );

$pedigree['cellpad'] = 5;
$topmarker = array();
$botmarker = array();
$spouses_for_next_gen = array();
$maxwidth = 0;
$maxheight = 0;
$starttop = array();
$needtop = array();
$numboxes = 0;

if (file_exists($cms['tngpath'] . "ArrowDown.gif")) {
	$downarrow = @GetImageSize($cms['tngpath'] . "ArrowDown.gif");
	$pedigree['downarroww'] = $downarrow[0];
	$pedigree['downarrowh'] = $downarrow[1];
	$pedigree['downarrow'] = "<img src=\"" . $cms['tngpath'] . "ArrowDown.gif\" border=\"0\" width=\"$pedigree[downarroww]\" height=\"$pedigree[downarrowh]\"  alt=\"\" />";
}
else
	$pedigree['downarrow'] = "";

if (file_exists($cms['tngpath'] . "ArrowRight.gif")) {
	$offpageimg = @GetImageSize($cms['tngpath'] . "ArrowRight.gif");
	$pedigree['offpagelink'] = "<img border=\"0\" src=\"" . $cms['tngpath'] . "ArrowRight.gif\" $offpageimg[3] alt=\"$text[popupnote3]\" />";
	$pedigree['offpageimgw'] = $offpageimg[0];
	$pedigree['offpageimgh'] = $offpageimg[1];
}
else
	$pedigree['offpagelink'] = "<b>&gt;</b>";

if (file_exists($cms['tngpath'] . "ArrowLeft.gif")) {
	$leftarrowimg = @GetImageSize($cms['tngpath'] . "ArrowLeft.gif");
	$pedigree['leftarrowimgw'] = $leftarrowimg[0];
	$pedigree['leftarrowimgh'] = $leftarrowimg[1];
	$pedigree['leftarrowlink'] = "<img border=\"0\" src=\"" . $cms['tngpath'] . "ArrowLeft.gif\" $leftarrowimg[3] align=\"left\" title=\"$text[popupnote3]\" alt=\"$text[popupnote3]\" />";
 	$pedigree['leftindent'] += $pedigree['leftarrowimgw'] + $pedigree['shadowoffset'] + 6;
}
else {
	$pedigree['leftarrowlink'] = "<b>&gt;</b>";
   	$pedigree['leftindent'] += 16 + $pedigree['shadowoffset'];
}


if( $display == "compact" ) {
	$pedigree['inclphotos'] = 0;
	$pedigree['usepopups'] = 0;
	$pedigree['boxHsep'] = 15;
	$pedigree['boxheight'] = 16;
	$pedigree['boxnamesize'] = 8;
	$pedigree['cellpad'] = 0;
	$pedigree['boxwidth'] -= 50;
	$pedigree['boxVsep'] = 5;
	$pedigree['shadowoffset'] = 1;
	$pedigree['spacer'] = "&nbsp;";
	$pedigree['gendalign'] = -2;
	$spouseoffset = 20;
	$pedigree['diff'] = $pedigree['boxheight'] + $pedigree['boxVsep'] + $pedigree['linewidth'];
	$clinkstyle = "3";
	$slinkstyle = "";
}
else {
	$pedigree['boxnamesize'] = 10;
	$pedigree['boxheight'] = $pedigree['puboxheight'];
	$pedigree['boxwidth'] = $pedigree['puboxwidth'];
	$pedigree['boxalign'] = $pedigree['puboxalign'];
	$pedigree['spacer'] = "";
	$pedigree['gendalign'] = -1;
	$spouseoffset = 40;
	$pedigree['diff'] = $pedigree['boxheight'] + $pedigree['boxVsep'] + $pedigree['linewidth'] + $pedigree['downarrowh'];
	$clinkstyle = "";
	$slinkstyle = "3";
}

$pedigree['baseR'] = hexdec( substr( $pedigree['boxcolor'], 1, 2 ) );
$pedigree['baseG'] = hexdec( substr( $pedigree['boxcolor'], 3, 2 ) );
$pedigree['baseB'] = hexdec( substr( $pedigree['boxcolor'], 5, 2 ) );
if( $pedigree['colorshift'] > 0 ) {
	$extreme = $pedigree['baseR'] < $pedigree['baseG'] ? $pedigree['baseR'] : $pedigree['baseG'];
	$extreme = $extreme < $pedigree['baseB'] ? $extreme : $pedigree['baseB'];
}
elseif( $pedigree['colorshift'] < 0 ) {
	$extreme = $pedigree['baseR'] > $pedigree['baseG'] ? $pedigree['baseR'] : $pedigree['baseG'];
	$extreme = $extreme > $pedigree[baseB] ? $extreme : $pedigree['baseB'];
}
$pedigree['colorshift'] = round( $pedigree['colorshift'] / 100 * $extreme / 5 );
//$pedigree[boxcolor] = getColor(1);

function getColor( $shifts ) {
	global $pedigree;

	$shiftval = $shifts * $pedigree[colorshift];
	$R = $pedigree['baseR'] + $shiftval;
	$G = $pedigree['baseG'] + $shiftval;
	$B = $pedigree['baseB'] + $shiftval;
	if ( $R > 255 ) $R = 255; if ( $R < 0 ) $R = 0;
	if ( $G > 255 ) $G = 255; if ( $G < 0 ) $G = 0;
	if ( $B > 255 ) $B = 255; if ( $B < 0 ) $B = 0;
	$R = str_pad( dechex($R), 2, "0", STR_PAD_LEFT );
	$G = str_pad( dechex($G), 2, "0", STR_PAD_LEFT );
	$B = str_pad( dechex($B), 2, "0", STR_PAD_LEFT );
	return "#$R$G$B";
}

function getParents($personID) {
	global $families_table, $children_table, $people_table, $tree, $text, $allow_living, $pedigree, $display, $descend_url, $generations, $livedefault;

	$parentinfo = "";
	$query = "SELECT husband, wife FROM $families_table, $children_table
		WHERE personID = \"$personID\" AND $children_table.gedcom = \"$tree\" AND $children_table.familyID = $families_table.familyID
		AND $children_table.gedcom = $families_table.gedcom";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	while( $parents = mysql_fetch_assoc( $result ) ) {
		if( $parents[husband] ) {
			$pquery = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, sex, living, branch
				FROM $people_table WHERE personID = \"$parents[husband]\" AND $people_table.gedcom = \"$tree\"";
			$presult = mysql_query($pquery) or die ("$text[cannotexecutequery]: $pquery");
			$husband = mysql_fetch_assoc( $presult );
			$husband['allow_living'] = !$husband[living] || $livedefault == 2 || ( $allow_living && checkbranch( $husband[branch] ) ) ? 1 : 0;
			$husband[name] = getName( $husband );

			$parentinfo .= "<tr><td valign=\"top\"><a href=\"$descend_url" . "personID=$parents[husband]&amp;tree=$tree&amp;generations=$generations&amp;display=$display\">$pedigree[leftarrowlink]<span class=\"normal\">$husband[name]</span></a> " . getGenderIcon("M", $pedigree[gendalign]) . "</td></tr>\n";
	  		mysql_free_result( $presult );
		}
		if( $parents[wife] ) {
			$pquery = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, sex, living, branch
				FROM $people_table WHERE personID = \"$parents[wife]\" AND $people_table.gedcom = \"$tree\"";
			$presult = mysql_query($pquery) or die ("$text[cannotexecutequery]: $pquery");
			$wife = mysql_fetch_assoc( $presult );
			$wife['allow_living'] = !$wife[living] || $livedefault == 2 || ( $allow_living && checkbranch( $wife[branch] ) ) ? 1 : 0;
			$wife[name] = getName( $wife );

			$parentinfo .= "<tr><td valign=\"top\"><a href=\"$descend_url" . "personID=$parents[wife]&amp;tree=$tree&amp;generations=$generations&amp;display=$display\">$pedigree[leftarrowlink]<span class=\"normal\">$wife[name]</span></a> " . getGenderIcon("F", $pedigree[gendalign]) . "</td></tr>\n";
	  		mysql_free_result( $presult );
		}
	}
	mysql_free_result( $result );

	return $parentinfo;
}

function getNewChart($personID) {
	global $tree, $generations, $cms, $text, $descend_url, $display;
	return $kidsflag ? "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations&amp;display=$display\"><img src=\"$cms[tngpath]" . "dchart.gif\" width=\"10\" height=\"9\" alt=\"$text[popupnote3]\" border=\"0\"/></a>" : "";
}

function doBox($level,$person,$spouseflag,$kidsflag) {
	global $pedigree, $topmarker, $botmarker, $spouseoffset, $maxwidth, $maxheight, $personID, $tree, $getperson_url;
	global $generations, $display, $descend_url, $text, $cms, $numboxes;

	if( !$topmarker[$level] )
		setTopMarker($level,0,"initialize, 183");
	$top = $topmarker[$level];
	if( $top > $maxheight ) $maxheight = $top;
	$topmarker[$level] += $pedigree[diff];
	$left = $pedigree[leftindent] + ($pedigree[boxwidth] + $pedigree[boxHsep] + $spouseoffset) * ($level - 1);
	if( $spouseflag ) {
		$left += $spouseoffset;
		$bgcolor = getColor(3);
	}
	else {
		$botmarker[$level] = $top;
		$bgcolor = getColor(1);
	}
	if( $left > $maxwidth ) $maxwidth = $left;

	$boxstr = "";
	if( $person[personID] == $personID ) {
		$parentinfo = getParents($personID);
		if( $parentinfo ) {
			//do the arrow
			$adjleft = $left - ($pedigree[leftarrowimgw] + $pedigree['shadowoffset'] + 6);
			$boxstr .= "<div id=\"leftarrow\" style=\"position:absolute; top:" . ( $top + intval( ($pedigree['boxheight'] - $pedigree[offpageimgh]) / 2) + 1 ) . "px; left:$adjleft" . "px;z-index:5;\">\n";
			$boxstr .= "<a href=\"javascript:goBack();\">$pedigree[leftarrowlink]</a></div>\n";
			//set top
			$boxstr .= "<div id=\"popupleft\" style=\"position:absolute; visibility:hidden; background-color:$pedigree[popupcolor]; top:" . ( $top + intval( ($pedigree['boxheight'] - $pedigree[offpageimgh]) / 2) + 1 ) . "px; left:$adjleft" . "px;z-index:8\" onmouseover=\"cancelTimer('left')\" onmouseout=\"setTimer('left')\">\n";
			$boxstr .= "<table style=\"border: 1px solid $pedigree[bordercolor];\" cellpadding=\"1\" cellspacing=\"0\"><tr><td><table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";
			$boxstr .= "<tr><td><span class=\"normal\"><b>$text[parents]</b></span></td></tr>\n$parentinfo\n</table></td></tr></table></div>\n";
		}
	}

	$boxstr .= "<div style=\"position:absolute; background-color:$bgcolor; top:" . ($top-$pedigree[borderwidth]) . "px; left:" . ($left-$pedigree[borderwidth]) . "px; height:" . $pedigree['boxheight'] . "px; width:$pedigree[boxwidth]" . "px; z-index:5; border:$pedigree[borderwidth]px solid $pedigree[bordercolor];overflow:hidden\">\n";
    $boxstr .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"$pedigree[boxalign]\"><tr>";

    // implant a picture (maybe)
    if ( $pedigree['inclphotos'] && $pedigree['usepopups']) {
		$photohtouse = $pedigree['boxheight'] - ( $pedigree['cellpad'] * 2 ); // take cellpadding into account
		$photoinfo = showSmallPhoto( $person['personID'], $person['name'], $person['allow_living'], $photohtouse );
		if( $photoinfo )
			$boxstr .= "<td align=\"left\" style=\"padding:$pedigree[cellpad]px\">$photoinfo</td>";
	}
	//echo "name=$person[name], top=$top<br>\n";

    // name info
	if( $person[name] )
	   	$boxstr .= "<td align=\"$pedigree[boxalign]\" class=\"pboxname\" style=\"height:" . $pedigree['boxheight'] . "px;\"><span style=\"font-size:$pedigree[boxnamesize]" . "pt;\">$pedigree[spacer]<a href=\"$getperson_url" . "personID=$person[personID]&amp;tree=$tree" . "\">$person[name]</a> " . getGenderIcon($person[sex], $pedigree[gendalign]) . getNewChart($person['personID']) . "</span></td></tr></table></div>\n";
	else
	   	$boxstr .= "<td align=\"$pedigree[boxalign]\" class=\"pboxname\" style=\"height:" . $pedigree['boxheight'] . "px\"><span style=\"font-size:$pedigree[boxnamesize]" . "pt;\">$pedigree[spacer]$text[unknownlit]</span></td></tr></table></div>\n";
	//$boxstr .= "<div class=\"border\" style=\"top:" . ($top-$pedigree['borderwidth']) . "px;left:" . ($left-$pedigree['borderwidth']) . "px;height:" . ($pedigree['boxheight']+(2*$pedigree['borderwidth'])) . "px;width:" . ($pedigree[boxwidth]+(2*$pedigree['borderwidth'])) . "px;z-index:4\"></div>\n";
	$boxstr .= "<div class=\"shadow\" style=\"top:" . ($top-$pedigree['borderwidth']+$pedigree['shadowoffset']) . "px;left:" . ($left-$pedigree['borderwidth']+$pedigree['shadowoffset']) . "px;height:" . ($pedigree['boxheight']+(2*$pedigree['borderwidth'])) . "px;width:" . ($pedigree[boxwidth]+(2*$pedigree['borderwidth'])) . "px;z-index:1\"></div>\n";

	if( $display != "compact" && $pedigree[usepopups] ) {
   		$vitalinfo = getVitalDates( $person );
		if( $vitalinfo ) {
			$numboxes++;
	   		$boxstr .= "<div style=\"top:" . ($top + $pedigree['boxheight'] + $pedigree['borderwidth'] + $pedigree['shadowoffset'] + 1) . "px;left:" . ($left + intval(($pedigree[boxwidth] - $pedigree[downarroww])/2) - 1) . "px;z-index:7;cursor:pointer\">";
			$boxstr .= "<a href=\"#\" onmouse$pedigree[event]=\"showPopup($numboxes,$top," . $pedigree['boxheight'] . ")\">" . $pedigree['downarrow'] . "</a></div>";

			$boxstr .= "<div id=\"popup$numboxes\" style=\"position:absolute; visibility:hidden; background-color:$pedigree[popupcolor]; left:" . ($left - $pedigree['borderwidth'] + round($pedigree['shadowoffset']/2)) . "px;z-index:8\" onmouseover=\"cancelTimer($numboxes)\" onmouseout=\"setTimer($numboxes)\">\n";
			$boxstr .= "<table style=\"border: 1px solid $pedigree[bordercolor];\" cellpadding=\"1\" cellspacing=\"0\"><tr><td><table border=\"0\" cellspacing=\"0\" cellpadding=\"1\">\n";
			$boxstr .= "$vitalinfo\n</table></td></tr></table></div>\n";
		}
	}

	if( !$spouseflag && $person[personID] != $personID ) {
		$boxstr .= "<div class=\"border\" style=\"top:" . ($top + intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2)) . "px;left:" . ($left - intval($pedigree[boxHsep]/2)) . "px;height:" . $pedigree['linewidth'] . "px;width:" . (intval($pedigree[boxHsep]/2) + 2) . "px;z-index:3;overflow:hidden\"></div>\n";
		$boxstr .= "<div class=\"shadow\" style=\"top:" . ($top + intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2) + $pedigree['shadowoffset'] + 1) . "px;left:" . (($left - intval($pedigree[boxHsep]/2)) + $pedigree['shadowoffset'] + 1) . "px;height:" . $pedigree['linewidth'] . "px;width:" . (intval($pedigree[boxHsep]/2) + 2) . "px;z-index:1;overflow:hidden\"></div>\n";
	}
	if( $spouseflag ) {
		$boxstr .= "<div class=\"border\" style=\"top:" . ($top + intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2)) . "px;left:" . ($left - intval($spouseoffset/2)) . "px;height:" . $pedigree['linewidth'] . "px;width:" . (intval($spouseoffset/2) + 2) . "px;z-index:3;overflow:hidden\"></div>\n";
		$boxstr .= "<div class=\"shadow\" style=\"top:" . ($top + intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2) + $pedigree['shadowoffset'] + 1) . "px;left:" . (($left - intval($spouseoffset/2)) + $pedigree['shadowoffset'] + 1) . "px;height:" . $pedigree['linewidth'] . "px;width:" . (intval($spouseoffset/2) + 2) . "px;z-index:1;overflow:hidden\"></div>\n";
		if( $kidsflag ) {
			if( $level < $generations ) {
		   		$boxstr .= "<div class=\"border\" style=\"top:" . ($top + intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2)) . "px;left:" . ($left + $pedigree[boxwidth]) . "px;height:" . $pedigree['linewidth'] . "px;width:" . (intval($pedigree[boxHsep]/2) + 1) . "px;z-index:3;overflow:hidden\"></div>\n";
   				$boxstr .= "<div class=\"shadow\" style=\"top:" . ($top + intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2) + $pedigree['shadowoffset'] + 1) . "px;left:" . ($left + $pedigree[boxwidth] + $pedigree['shadowoffset'] + 1) . "px;height:" . $pedigree['linewidth'] . "px;width:" . (intval($pedigree[boxHsep]/2) + 1) . "px;z-index:1;overflow:hidden\"></div>\n";
			}
			else {
				$boxstr .= "<div style=\"top:" . ( $top + intval( ($pedigree['boxheight'] - $pedigree['offpageimgh']) / 2) + 1 ) . "px;left:" . ($left + $pedigree['boxwidth'] + $pedigree['borderwidth'] + $pedigree['shadowoffset'] + 3 ) . "px;z-index:5\">\n";
				$nextperson = $person['personID'] ? $person['personID'] : $spouseflag;
				$boxstr .= "<a href=\"$descend_url" . "personID=$nextperson&amp;tree=$tree&amp;generations=$generations&amp;display=$display\" title=\"$text[popupnote2]\">$pedigree[offpagelink]</a></div>\n";
			}
		}
	}

	return $boxstr;
}

function doIndividual($person,$level) {
	global $people_table, $families_table, $tree, $allow_living, $generations, $children_table, $text, $pedigree;
	global $topmarker, $botmarker, $vslots, $vendspouses, $spouseoffset, $needtop, $starttop, $livedefault, $spouses_for_next_gen;

	//look up person
	$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch
		FROM $people_table WHERE personID = \"$person\" AND $people_table.gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $result ) {
		$row = mysql_fetch_assoc( $result );
		$row['allow_living'] = !$row[living] || $livedefault == 2 || ( $allow_living && checkbranch( $row['branch'] ) ) ? 1 : 0;
		$row['name'] = getName( $row );
	}
	mysql_free_result( $result );

	//get gender-related info
	if( $row['sex'] == "M" ) {
		$self = "husband";
		$spouse = "wife";
		$spouseorder = "husborder";
	}
	else if( $row['sex'] == "F" ){
		$self = "wife";
		$spouse = "husband";
		$spouseorder = "wifeorder";
	}
	else {
		$self = $spouse = $spouseorder = "";
	}

	//look up spouse-families
	if( $spouse )
		$query = "SELECT $spouse, familyID FROM $families_table WHERE $families_table.$self = \"$person\" AND gedcom = \"$tree\" ORDER BY $spouseorder";
	else
		$query = "SELECT husband, wife, familyID FROM $families_table WHERE $families_table.wife = \"$person\" AND gedcom = \"$tree\" UNION SELECT husband, wife, familyID FROM $families_table WHERE $families_table.husband = \"$person\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$marrtot = mysql_num_rows($result);
	if( !$marrtot ) {
		$query = "SELECT husband, wife, familyID FROM $families_table WHERE $families_table.wife = \"$person\" AND gedcom = \"$tree\" UNION SELECT husband, wife, familyID FROM $families_table WHERE $families_table.husband = \"$person\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$self = $spouse = $spouseorder = "";
	}

	//for each family
	$needperson = 1;
	$spousecount = 0;
   	while( $famrow = mysql_fetch_assoc( $result ) ) {
		//get starting offset
		//do box for main spouse (if not already done)
		$spousecount++;
		$originaltop = $topmarker[$level];
		//if( $vslots[$famrow[familyID]] > 2 )
			//$topmarker[$level] += 100 + intval(($pedigree[diff]) * ($vslots[$famrow[familyID]] - $vendspouses[$famrow[familyID]] - 1) / 2);
   		//echo "fam=$famrow[familyID], ve=" .$vendspouses[$famrow[familyID]] . ", vs= " . $vslots[$famrow[familyID]] . "<br />\n";

		//get children

		$query = "SELECT $children_table.personID as personID FROM $children_table WHERE familyID = \"$famrow[familyID]\" AND $children_table.gedcom = \"$tree\" ORDER BY ordernum";
		$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$numkids = mysql_num_rows( $result2 );
		if( $level < $generations ) {
			//if( $famrow[$spouse] )

			if( $numkids ) {
				$needtop[$level + 1] = 1;
				$childleft = $pedigree['leftindent'] + ($pedigree['boxwidth'] + $pedigree['boxHsep'] + $spouseoffset) * $level;
				while( $crow = mysql_fetch_assoc( $result2 ) ) {
					//recurse on each child (next level)
					doIndividual( $crow['personID'], $level + 1 );
				}
				if( $numkids > 1 )
					$vheight = $botmarker[$level+1] - $starttop[$level+1];
				elseif( $needperson ) {
					$vheight = $pedigree['diff'] + 1;
				}
				else
					$vheight = 0;
				if( $numkids == 1 && $spousecount < 2 && !$spouses_for_next_gen[$level+1]) {
					//$topmarker[$level + 1] += $pedigree[diff];
					for( $i = $level + 1; $i <= $generations; $i++ )
						setTopMarker($i,$topmarker[$i] + $pedigree['diff'],"lowering previous gens, 348");
				}

				if( $vheight ) {
					echo "<div class=\"border\" style=\"font-size:0;top:" . ($starttop[$level+1] + intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2)). "px;left:" . ($childleft - intval($pedigree[boxHsep]/2)) . "px;height:" . $vheight . "px;width:" . $pedigree['linewidth'] . "px;z-index:3\"></div>\n";
					echo "<div class=\"shadow\" style=\"font-size:0;top:" . ($starttop[$level+1] + intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2) + $pedigree['shadowoffset'] + 1) . "px;left:" . ($childleft - intval($pedigree[boxHsep]/2) + $pedigree['shadowoffset'] + 1) . "px;height:" . $vheight . "px;width:" . $pedigree['linewidth'] . "px;z-index:1\"></div>\n";
				}
	   			mysql_free_result( $result2 );
				setTopMarker($level,$starttop[$level+1] + intval($vheight / 2),"increasing, half of box height, 356");
			}
		}

		if( $needperson ) {
			//set "top"
			//take number of "vslots" for this family
			if( $numkids && $level < $generations )
				setTopMarker($level,$topmarker[$level] - intval(($pedigree[diff])/2),"decreasing, moving down to center,365");
			if( $needtop[$level] ) {
				$starttop[$level] = $topmarker[$level];
				$needtop[$level] = 0;
			}
			$thistop = $topmarker[$level];
			echo doBox($level,$row,0,0);
			$needperson = 0;
		}
		//echo "familyID = $famrow[familyID], vs=" . $vslots[$famrow[familyID]] . ", ve=" . $vendspouses[$famrow[familyID]] . "<br>";

		//get spouse data (if exists)
		$spouserow = array();
		if( !$spouse )
			$spouse = $famrow['husband'] == $person ? "wife" : "husband";
		if( $famrow[$spouse] ) {
			$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch FROM $people_table WHERE personID = \"$famrow[$spouse]\" AND gedcom = \"$tree\"";
			$spouseresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$spouserow = mysql_fetch_assoc( $spouseresult );
			$spouserow['allow_living'] = !$spouserow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $spouserow['branch'] ) ) ? 1 : 0;
			$spouserow['name'] = getName( $spouserow );
		}
		else
			$spouserow = array();

		//do box for other spouse
		//lines down from primary spouse
		$vheight = $topmarker[$level] - $thistop - intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2);
		$childleft = $pedigree[leftindent] + ($pedigree[boxwidth] + $pedigree[boxHsep] + $spouseoffset) * ($level - 1);
		echo "<div class=\"border\" style=\"font-size:0;top:" . ($thistop + $pedigree['boxheight']) . "px;left:" . ($childleft + intval($spouseoffset/2)) . "px;height:" . $vheight . "px;width:" . $pedigree['linewidth'] . "px;z-index:3\"></div>\n";
		echo "<div class=\"shadow\" style=\"font-size:0;top:" . ($thistop + $pedigree['boxheight'] + $pedigree['shadowoffset'] + 1) . "px;left:" . ($childleft + intval($spouseoffset/2) + $pedigree['shadowoffset'] + 1) . "px;height:" . $vheight . "px;width:" . $pedigree['linewidth'] . "px;z-index:1\"></div>\n";
		$thistop = $topmarker[$level] - intval($pedigree['boxheight']/2) - intval($pedigree['linewidth']/2);
	   	echo doBox($level,$spouserow,$person,$numkids);

		if( $numkids && $level < $generations ) {
			$vkey = $famrow['familyID'] . "-$level";
			setTopMarker($level,$originaltop + ($vslots[$vkey] * $pedigree['diff']),"raising, diff=$pedigree[diff], slots=" . $vslots[$vkey] . ", key=$vkey, 401");
		}
		else {
			for( $i = $level + 1; $i <= $generations; $i++ )
				setTopMarker($i,$topmarker[$level],"lowering previous gens, no kids, 405");
		}
	}
	$spouses_for_next_gen[$level] = $spousecount;
	//if no family, get starting offset and do box for person and return
	if( $needperson ) {
		//set top differently
		if( $needtop[$level] ) {
			$starttop[$level] = $topmarker[$level];
			$needtop[$level] = 0;
		}
		echo doBox($level,$row,0,0);
		for( $i = $level + 1; $i <= $generations; $i++ )
			setTopMarker($i,$topmarker[$level],"lowering all previous gens, 418");
	}
	mysql_free_result( $result );
}

function getData( $key, $sex, $level ) {
	global $tree, $generations, $families_table, $people_table, $children_table, $text;
	global $vslots, $vendspouses;

	if( $sex == "M" ) {
		$self = "husband";
		$spouseorder = "husborder";
	}
	elseif( $sex == "F") {
		$self = "wife";
		$spouseorder = "wifeorder";
	}
	else
		$self = $spouseorder = "";

	$gotafamily = 0;
	$stats = array();
	$stats['slots'] = 0;
	$stats['fams'] = 0;
	$stats['es'] = 0; //end spouses

	if($self)
		$query = "SELECT familyID FROM $families_table WHERE $families_table.$self = \"$key\" AND gedcom = \"$tree\" ORDER BY $spouseorder";
	else
		$query = "SELECT familyID FROM $families_table WHERE ($families_table.husband = \"$key\" OR $families_table.wife = \"$key\") AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
   	$stats[fams] = mysql_num_rows( $result );
	if( $result ) {
		while( $row = mysql_fetch_assoc( $result ) ) {
			$famslots = 0;
			$fam_es = 0;
			if( !$gotafamily) {
				$spouseslots = 2; //for both spouses, even if only one exists
				$gotafamily = 1;
			}
			else
				$spouseslots = 1; //for this spouse only; primary individual not included
			$endspouseslots = 1;

			$query = "SELECT $children_table.personID as personID, sex FROM $children_table, $people_table WHERE familyID = \"$row[familyID]\" AND $children_table.personID = $people_table.personID AND $children_table.gedcom = \"$tree\" AND $people_table.gedcom = \"$tree\" ORDER BY ordernum";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$numkids = mysql_num_rows( $result2 );
			if( $numkids ) {
				while( $crow = mysql_fetch_assoc( $result2 ) ) {
					if( $level < $generations ) {
						$kidstats = getData( $crow['personID'], $crow['sex'], $level + 1 );
						$famslots += $kidstats['slots'];
					}
				}
   				$fam_es += $kidstats['es'];
			}

			mysql_free_result( $result2 );
			$famslots = $famslots > $spouseslots ? $famslots : $spouseslots;

			$fam_es = $fam_es > $endspouseslots ? $fam_es : $endspouseslots;
			$stats['slots'] += $famslots;
			$vkey = $row['familyID'] . "-$level";
			$vslots[$vkey] = $famslots;
			//echo "key=$vkey, slots=" . $vslots[$vkey] . "<br>";
			$stats['es'] = $fam_es;
			$vendspouses[$vkey] = $stats[es];
			//echo "fam=$row[familyID], stats = $stats[es], fames=$fames, es=$endspouseslots, slots=$famslots <br>";
		}
	}
	mysql_free_result( $result );
	if( !$stats['slots'] ) {
		$stats['slots'] = 1;
		$vkey = $key . "-$level";
		$vslots[$vkey] = 1;
		//echo "key=$vkey, slots=" . $vslots[$vkey] . "<br>";
		$stats['es'] = 0; //do I need this?
		$vendspouses[$vkey] = 0;
	}

	return $stats;
}

function getVitalDates( $row ) {
	global $text;

	$vitalinfo = "";

	if( $row['allow_living'] ) {
		if( $row['birthdate'] || $row['altbirthdate'] || $row['altbirthplace'] || $row['deathdate'] || $row['burialdate'] || $row['burialplace'] )
			$dataflag = 1;
		else
			$dataflag = 0;

		// get birthdate info
		if ( $row['altbirthdate'] && !$row['birthdate'] ) {
			$bd = $row['altbirthdate'];
			$bp = $row['altbirthplace'];
			$birthabbr = "$text[capaltbirthabbr]:";
		}
	  	elseif( $dataflag ) {
			$bd = $row['birthdate'];
			$bp = $row['birthplace'];
			$birthabbr = "$text[capbirthabbr]:";
		}
		else {
			$bd = "";
			$bp = "";
			$birthabbr = "";
		}

		// get death/burial date info
		if( $row['burialdate'] && !$row['deathdate'] ) {
			$dd = $row['burialdate'];
			$dp = $row['burialplace'];
			$deathabbr = "$text[capburialabbr]:";
		}
		elseif( $dataflag ) {
			$dd = $row['deathdate'] ;
			$dp = $row['deathplace'];
			$deathabbr = "$text[capdeathabbr]:";
		}
		else {
			$dd = "";
			$dp = "";
			$deathabbr = "";
		}
	}
	else {
		$bd = $bp = $birthabbr = $dd = $dp = $deathabbr = $md = $mp = $marrabbr = "";
	}
	if( $bd ) {
		$vitalinfo .= "<tr>\n<td class=pboxpopup align=right valign=top><span class=\"normal\">$birthabbr</span></td>\n";
		$vitalinfo .= "<td class=pboxpopup valign=top><span class=\"normal\">" . displayDate( $bd ) . "</span></td></tr>\n";
		$birthabbr = "&nbsp;";
	}
	if( $bp ) {
		$vitalinfo .= "<tr>\n<td class=pboxpopup align=right valign=top><span class=\"normal\">$birthabbr</span></td>\n";
		$vitalinfo .= "<td class=pboxpopup valign=top><span class=\"normal\">$bp</span></td></tr>\n";
	}
	if( $dd ) {
		$vitalinfo .= "<tr>\n<td class=pboxpopup align=right valign=top><span class=\"normal\">$deathabbr</span></td>\n";
		$vitalinfo .= "<td class=pboxpopup valign=top><span class=\"normal\">" . displayDate( $dd ) . "</span></td></tr>\n";
		$deathabbr = "&nbsp;";
	}
	if( $dp ) {
		$vitalinfo .= "<tr>\n<td class=pboxpopup align=right valign=top><span class=\"normal\">$deathabbr</span></td>\n";
		$vitalinfo .= "<td class=pboxpopup valign=top><span class=\"normal\">$dp</span></td></tr>\n";
	}
	return $vitalinfo;
}

$level = 1;
$key = $personID;

$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, sex, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$key\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row['branch'] );
	$row['allow_living'] = !$row['living'] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$row['name'] = getName( $row );
	$logname = $nonames && $row['living'] ? $text[living] : $row['name'];
	$disallowgedcreate = $row['disallowgedcreate'];
}

writelog( "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=$display\">" . xmlcharacters("$text[descendfor] $logname ($personID)") . "</a>" );
preparebookmark( "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=$display\">$text[descendfor] " . $row['name'] . " ($personID)</a>" );

$flags[tabs] = $tngconfig[tabs];
$flags[scripting] = "<style type=\"text/css\">
#outerdiv div {
	position: absolute;
}

.desc {
	margin: 0 0 10px 0;
}

.spouse {
	width: 100%;
}

.shadow {
	background-color: $pedigree[shadowcolor];
}

.border {
	background-color: $pedigree[bordercolor];
}
</style>\n";
$flags['scripting'] .= "<script type=\"text/javascript\">var tnglitbox;</script>\n";
tng_header( "$text[descendfor] $row[name]", $flags );

$photostr = showSmallPhoto( $personID, $row[name], $row['allow_living'], 0 );
echo tng_DrawHeading( $photostr, $row[name], getYears( $row ) );
echo tng_coreicons();

if( !$pedigree['maxdesc'] ) $pedigree['maxdesc'] = 12;
if( !$generations )
    $generations = $pedigree['initdescgens'] > 8 ? 8 : $pedigree['initdescgens'];
if(!$generations) $generations = 6;
if( $generations > $pedigree['maxdesc'] )
	$generations = $pedigree['maxdesc'];
else
	$generations = intval( $generations );

for( $i = 0; $i < $generations; $i++ )
	setTopMarker($i,0,"initializing");

$innermenu = "$text[generations]: &nbsp;";
$innermenu .= "<select name=\"generations\" style=\"font-size:9px\" onchange=\"window.location.href='$descend_url" . "personID=$personID&tree=$tree&display=$display&generations=' + this.options[this.selectedIndex].value\">\n";
   for( $i = 1; $i <= $pedigree['maxdesc']; $i++ ) {
       $innermenu .= "<option value=\"$i\"";
       if( $i == $generations ) $innermenu .= " selected=\"selected\"";
       $innermenu .= ">$i</option>\n";
   }
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
$innermenu .= "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=standard&amp;generations=$generations\" class=\"lightlink$slinkstyle\">$text[pedstandard]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=compact&amp;generations=$generations\" class=\"lightlink$clinkstyle\">$text[pedcompact]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$descendtext_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink\">$text[pedtextonly]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$register_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink\">$text[regformat]</a>\n";
if($generations <= 12)
	$innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"#\" class=\"lightlink\" onclick=\"tnglitbox = new LITBox('$pdfform_url" . "pdftype=desc&personID=$personID&tree=$tree&generations=$generations',{width:350,height:350});return false;\">PDF</a>\n";

echo getFORM( "descend", "get", "form1", "form1" );
echo tng_menu( "I", "descend", $personID, $innermenu );
echo "</form>\n";
?>
<p><span class="normal">
(<?php echo $text[scrollnote];
	if ( $pedigree[usepopups_real] ) {
		echo ( $pedigree['downarrow'] ? " <img src=\"" . $cms['tngpath'] . "ArrowDown.gif\" width=\"$pedigree[downarroww]\" height=\"$pedigree[downarrowh]\" alt=\"\" />" : " <a href=\"#\"><span class=\"normal\"><B>V</B></span></a>" ) . $text[popupnote1];
	}
?>)
</span></p>
<div align="left" id="outerdiv" style="position:relative;">
<?php
getData($key,$row[sex],1);
doIndividual( $personID, 1 );

$maxheight += $pedigree['boxheight'] + $pedigree['borderwidth'] + $pedigree['downarroww'];
$maxwidth += $pedigree['boxwidth'] + $pedigree['borderwidth'] + (2 * $pedigee['offpageimgw']) + 6 + $pedigree['leftindent'];
?>
</div>
<table border="0" cellspacing="0" cellpadding="0" width="<?php echo $maxwidth; ?>" style="height: <?php echo $maxheight; ?>px;">
<tr><td></td></tr></table>
<script type="text/javascript">
var timerleft = false;

function goBack() {
	var popupleft = document.getElementById("popupleft");
	popupleft.style.visibility = 'visible';
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
</script>
<?php
if( $display != "compact" && $pedigree['usepopups']) {
?>
<script type="text/javascript">
var lastpopup = "";
for( var h = 1; h <= <?php echo $numboxes; ?>; h++ ) {
	eval( 'var timer' + h + '=false' );
}
function showPopup( slot, tall, high ){
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
		ref.top = ( tall + high ) < 0 ? 0 : ( tall + high + <?php echo $pedigree['borderwidth']; ?> ) + 'px';
		ref.zIndex = 8;
    	ref.visibility = "visible";
	}
}
</script>
<?php
}
?>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>litbox.js"></script>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>rpt_utils.js"></script>
<?php
tng_footer( "" );
?>
