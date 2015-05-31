<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "familygroup";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "personlib.php" );

$familygroup_url = getURL( "familygroup", 1 );
$getperson_url = getURL( "getperson", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$showsource_url = getURL( "showsource", 1 );
$tentedit_url = getURL( "tentedit", 1 );
$showalbum_url = getURL("showalbum",1);

$firstsection = 0;
$tableid = "";
$cellnumber = 0;
$notestogether = 0; //so they always show at the bottom
$allow_lds_this = "";

$citations = array();
$citedisplay = array();
$citestring = array();
$citedispctr = 0;

$totcols = $allow_lds ? 6 : 3;
$factcols = $totcols - 1;

function showFact( $text, $fact ) {
	global $factcols;
	$facttext = "<tr>\n";
	$facttext .= "<td valign=\"top\" class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;" . $text . "&nbsp;</span></td>\n";
	$facttext .= "<td valign=\"top\" colspan=\"$factcols\" class=\"databack\"><span class=\"normal\">$fact&nbsp;</span></td>\n";
	$facttext .= "</tr>\n";
	
	return $facttext;
}

function showDatePlace( $event ) {
	global $allow_lds_this, $cellnumber, $placesearch_url, $text, $cms, $tentative_edit, $tentedit_url, $tree, $familyID;
	
	$dptext = "";
	if( !$cellnumber ) {
		$cellid = " id=\"info1\"";
		$cellnumber++;
	}
	else
		$cellid = "";

	$dcitestr = $pcitestr = "";
   	if( $event[date] || $event[place] ) {
		$citekey = $familyID . "_" . $event[event];
		$cite = reorderCitation( $citekey );
		if( $cite ) {
			 $dcitestr = $event[date] ? "<span class=\"normal\">[$cite]</span>" : "";
			 $pcitestr = $event[place] ? "<span class=\"normal\">[$cite]</span>" : "";
		}
	}

	$dptext .= "<tr>\n";
	$editicon = $tentative_edit ? "<img src=\"$cms[tngpath]tng_edit.gif\" width=\"16\" height=\"15\" border=\"0\" alt=\"$text[editevent]\" align=\"absmiddle\" onclick=\"tnglitbox = new LITBox('$tentedit_url" . "tree=$tree&amp;persfamID=$event[ID]&amp;type=$event[type]&amp;event=$event[event]&amp;title=$event[text]',{width:500,height:500});\" style=\"cursor:pointer\" />" : "";
	$dptext .= "<td valign=\"top\" class=\"fieldnameback\" style=\"white-space:nowrap\"$cellid><span class=\"fieldname\">&nbsp;" . $event[text] . "&nbsp;$editicon</span></td>\n";
	$dptext .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\" style=\"white-space:nowrap\">" . displayDate( $event[date] ) . "$dcitestr&nbsp;</span></td>\n";
	$dptext .= "<td valign=\"top\" class=\"databack\"";
	if( $allow_lds_this && $event[ldstext] )
		$dptext .= " width=\"50%\"";
	else
		$dptext .= " width=\"80%\"";
	$dptext .= "><span class=\"normal\">$event[place]$pcitestr&nbsp;";
	if( $event[place] )
		$dptext .= "<a href=\"$placesearch_url" . "tree=$tree&amp;psearch=" . urlencode($event[place]) . "\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\"></a>";
	$dptext .= "</span></td>\n";
	if( $allow_lds_this && $event[ldstext]) {
		if( $event[type2] ) {
			$event[type] = $event[type2];
			$event[ID] = $event[ID2];
		}
		$editicon = $tentative_edit && $event[eventlds] ? "<img src=\"$cms[tngpath]tng_edit.gif\" width=\"16\" height=\"15\" border=\"0\" alt=\"$text[editevent]\" align=\"absmiddle\" onclick=\"tnglitbox = new LITBox('$tentedit_url" . "tree=$tree&amp;persfamID=$event[ID]&amp;type=$event[type]&amp;event=$event[eventlds]&amp;title=$event[ldstext]',{width:500,height:500});\" style=\"cursor:pointer\" />" : "";
		$dptext .= "<td valign=\"top\" class=\"fieldnameback\" style=\"white-space:nowrap\"><span class=\"fieldname\">&nbsp;" . $event[ldstext] . "&nbsp;$editicon</span></td>\n";
		$dptext .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\"><nobr>" . displayDate( $event[ldsdate] ) . "&nbsp;</nobr></span></td>\n";
		$dptext .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\"><nobr>$event[ldsplace]&nbsp;";
		if( $event[ldsplace] && $event[ldsplace] != $text[place] )
			$dptext .= "<a href=\"$placesearch_url" . "tree=$tree&amp;psearch=" . urlencode($event[ldsplace]) . "\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\"></a>";
		$dptext .= "</nobr></span></td>\n";
	}
	$dptext .= "</tr>\n";
	
	return $dptext;
}

function displayIndividual( $ind, $label, $familyID, $showmarriage ) {
	global $tree, $text, $photopath, $photosext, $allow_living, $firstsection, $children_table, $livedefault, $totcols;
	global $allow_lds, $allow_lds_this, $allow_edit, $families_table, $people_table, $nonames, $cms, $getperson_url, $familygroup_url, $personID;

	$indtext = "";
	$rightbranch = checkbranch( $ind[branch] ) ? 1 : 0;
	$allow_lds_this = $rightbranch ? $allow_lds : 0;
	$ind[allow_living] = !$ind[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$haskids = $ind[haskids] ? "X" : "&nbsp;";
	$restriction = $familyID ? "AND familyID != \"$familyID\"" : "";
	if( $ind[sex] == "M" ) $sex = $text[male];
	else if( $ind[sex] == "F" ) $sex = $text[female];
	else $sex = $text[unknown];
	$namestr = getName( $ind );
	$personID = $ind[personID];

	//adjust for same-sex relationships
	if( $ind[sex] == "M" && $label == $text[wife] )
		$label = $text[husband];
	elseif( $ind[sex] == "F" && $label == $text[husband] )
		$label = $text[wife];

	//show photo & name
	$indtext .= "<tr><td colspan=\"$totcols\"><br />";
	$indtext .= showSmallPhoto( $ind[personID], $namestr, $ind[allow_living], 0 );
	$indtext .= "<span class=\"normal\">$label | $sex</span><br/><span class=\"subhead\"><b>";
	if( $ind[haskids] ) 
		$indtext .= "> ";
	$indtext .= "<a href=\"$getperson_url" . "personID=$ind[personID]&amp;tree=$tree\">$namestr</a></b>";
	
	if( $allow_edit && $rightbranch )
		$indtext .= " | <a href=\"$cms[tngpath]" . "admin/editperson.php?personID=$ind[personID]&amp;tree=$tree&amp;cw=1\" target=\"_blank\">$text[edit]</a>";
	$indtext .= "<br/></span>\n";
	$indtext .= "</td></tr>\n";

	$event = array();
	$event = "";

	$event[text] = $text[born];
	$event[event] = "BIRT";
	$event[type] = "I";
	$event[ID] = $personID;
	if( $ind[allow_living] ) {
		$event[date] = $ind[birthdate];
		$event[place] = $ind[birthplace];
		if( $allow_lds_this ) {
			$event[ldstext] = $text[ldsords];
			$event[ldsdate] = $text[date];
			$event[ldsplace] = $text[place];
		}
	}
	$indtext .= showDatePlace( $event );

	$event = "";
	$event[event] = "CHR";
	$event[type] = "I";
	$event[ID] = $personID;
	if( $ind[allow_living] ) {
		$event[date] = $ind[altbirthdate];
		$event[place] = $ind[altbirthplace];
		if( $allow_lds_this ) {
			$event[eventlds] = "BAPL";
			$event[ldsdate] = $ind[baptdate];
			$event[ldsplace] = $ind[baptplace];
			$event[ldstext] = $text[baptizedlds];
		}
	}
	if( (isset( $event[date]) && $event[date]) || (isset( $event[place]) && $event[place]) || isset($event[ldsdate]) || isset($event[ldsplace]) ) {
		$event[text] = $text[christened];
		$indtext .= showDatePlace( $event );
	}
	
	$event = "";
	$event[text] = $text[died];
	$event[event] = "DEAT";
	$event[type] = "I";
	$event[ID] = $personID;
	if( $ind[allow_living] ) {
		$event[date] = $ind[deathdate];
		$event[place] = $ind[deathplace];
		if( $allow_lds_this ) {
			$event[eventlds] = "ENDL";
			$event[ldstext] = $text[endowedlds];
			$event[ldsdate] = $ind[endldate];
			$event[ldsplace] = $ind[endlplace];
		}
	}
	$indtext .= showDatePlace( $event );
	
	$event = "";
	$event[text] = $text[buried];
	$event[event] = "BURI";
	$event[type] = "I";
	$event[ID] = $personID;
	if( $ind[allow_living] ) {
		$event[date] = $ind[burialdate];
		$event[place] = $ind[burialplace];
		if( $allow_lds_this ) {
			if( $familyID ) {
				$query = "SELECT sealdate, sealplace FROM $children_table WHERE familyID = \"$ind[famc]\" AND gedcom = \"$tree\" AND personID = \"$ind[personID]\"";
				$cresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				$sealinfo = mysql_fetch_assoc( $cresult );
				$ind[sealdate] = $sealinfo[sealdate];
				$ind[sealplace] = $sealinfo[sealplace];
				mysql_free_result( $cresult );
			}
			$event[type2] = "C";
			$event[ID2] = "$personID::$ind[famc]";
			$event[eventlds] = "SLGC";
			$event[ldstext] = $text[sealedplds];
			$event[ldsdate] = $ind[sealdate];
			$event[ldsplace] = $ind[sealplace];
		}
	}
	$indtext .= showDatePlace( $event );
	
	//show marriage & sealing if $showmarriage
	if( $familyID ) {
		if( $showmarriage ) {
			$query = "SELECT marrdate, marrplace, divdate, divplace, sealdate, sealplace, living, branch FROM $families_table WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
			$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$fam = mysql_fetch_assoc($result);
			$fam[allow_living] = !$fam[living] || $livedefault == 2 || ( $allow_living && checkbranch( $fam[branch] ) ) ? 1 : 0;
			mysql_free_result($result);
			
			$event = "";
			$eventd = "";
			$event[text] = $text[married];
			$event[event] = "MARR";
			$event[type] = "F";
			$event[ID] = $familyID;
			if( $fam[allow_living] ) {
				$event[date] = $fam[marrdate];
				$event[place] = $fam[marrplace];
				if( $allow_lds_this ) {
					$event[eventlds] = "SLGS";
					$event[ldstext] = $text[sealedslds];
					$event[ldsdate] = $fam[sealdate];
					$event[ldsplace] = $fam[sealplace];
				}
				$eventd[event] = "DIV";
				$eventd[text] = $text[divorced];
				$eventd[date] = $fam[divdate];
				$eventd[place] = $fam[divplace];
			}
			$indtext .= showDatePlace( $event );
			if( $eventd[date] || $eventd[place] )
				$indtext .= showDatePlace( $eventd );
		}
		$spousetext = $text[otherspouse];
	}
	else
		$spousetext = $text[spouse];

	//show other spouses
	if( $ind[sex] == "M" ) 
		$query = "SELECT familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, $families_table.living as living, $families_table.branch as branch, $people_table.living as iliving, marrdate, marrplace, sealdate, sealplace FROM $families_table LEFT JOIN $people_table on $families_table.wife = $people_table.personID AND $families_table.gedcom = $people_table.gedcom WHERE husband = \"$ind[personID]\" AND $people_table.gedcom = \"$tree\" $restriction ORDER BY husborder";
	else if( $ind[sex] = "F" )
		$query = "SELECT familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, $families_table.living as living, $families_table.branch as branch, $people_table.living as iliving, marrdate, marrplace, sealdate, sealplace FROM $families_table LEFT JOIN $people_table on $families_table.husband = $people_table.personID AND $families_table.gedcom = $people_table.gedcom WHERE wife = \"$ind[personID]\" AND $people_table.gedcom = \"$tree\" $restriction ORDER BY wifeorder";
	else
		$query = "SELECT familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, $families_table.living as living, $families_table.branch as branch, $people_table.living as iliving, marrdate, marrplace, sealdate, sealplace FROM $families_table LEFT JOIN $people_table on ($families_table.husband = $people_table.personID OR $families_table.wife = $people_table.personID) AND $families_table.gedcom = $people_table.gedcom WHERE (wife = \"$ind[personID]\" && husband = \"$ind[personID]\") AND $people_table.gedcom = \"$tree\"";
	$spresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
	while( $fam = mysql_fetch_assoc($spresult) ) {
		$fam[allow_living] = !$fam[living] || $livedefault == 2 || ( $allow_living && checkbranch( $fam[branch] ) ) ? 1 : 0;
		$spousename = getName( $fam );
		$spouselink = $spousename ? "<a href=\"$getperson_url" . "personID=$fam[personID]&amp;tree=$tree\">$spousename</a> | " : "";
		$spouselink .= "<a href=\"$familygroup_url" . "familyID=$fam[familyID]&amp;tree=$tree\">$fam[familyID]</a>";
		$indtext .= showFact( $spousetext, $spouselink );
		
		$event = "";
		$event[text] = $text[married];
		$event[event] = "MARR";
		$event[type] = "F";
		$event[ID] = $fam[familyID];
		if( $fam[allow_living] ) {
			$event[date] = $fam[marrdate];
			$event[place] = $fam[marrplace];
			if( $allow_lds_this ) {
				$event[eventlds] = "SLGS";
				$event[ldstext] = $text[sealedslds];
				$event[ldsdate] = $fam[sealdate];
				$event[ldsplace] = $fam[sealplace];
			}
		}
		$indtext .= showDatePlace( $event );
	}

	//show parents (for hus&wif)
	if( $familyID ) {
		$query = "SELECT familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, $people_table.living, $people_table.branch FROM $families_table, $people_table WHERE $families_table.familyID = \"$ind[famc]\" AND $families_table.gedcom = \"$tree\" AND $people_table.personID = $families_table.husband AND $people_table.gedcom = \"$tree\"";
		$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$parent = mysql_fetch_assoc($presult);
		$parent[allow_living] = !$parent[living] || $livedefault == 2 || ( $allow_living && checkbranch( $parent[branch] ) ) ? 1 : 0;
		$fathername = getName( $parent );
		mysql_free_result($presult);
		$fatherlink = $fathername ? "<a href=\"$getperson_url" . "personID=$parent[personID]&amp;tree=$tree\">$fathername</a> | " : "";
		$fatherlink .= $fathername ? "<a href=\"$familygroup_url" . "familyID=$parent[familyID]&amp;tree=$tree\">$parent[familyID] $text[groupsheet]</a>" : "";
		$indtext .= showFact( $text[father], $fatherlink );
		
		$query = "SELECT familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, $people_table.living, $people_table.branch FROM $families_table, $people_table WHERE $families_table.familyID = \"$ind[famc]\" AND $families_table.gedcom = \"$tree\" AND $people_table.personID = $families_table.wife AND $people_table.gedcom = \"$tree\"";
		$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$parent = mysql_fetch_assoc($presult);
		$parent[allow_living] = !$parent[living] || $livedefault == 2 || ( $allow_living && checkbranch( $parent[branch] ) ) ? 1 : 0;
		$mothername = getName( $parent );
		mysql_free_result($presult);
		$motherlink = $mothername ? "<a href=\"$getperson_url" . "personID=$parent[personID]&amp;tree=$tree\">$mothername</a> | " : "";
		$motherlink .= $mothername ? "<a href=\"$familygroup_url" . "familyID=$parent[familyID]&amp;tree=$tree\">$parent[familyID] $text[groupsheet]</a>" : "";
		$indtext .= showFact( $text[mother], $motherlink );
	}

	return $indtext;
}

//get family
$query = "SELECT familyID, husband, wife, living, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$famrow = mysql_fetch_assoc($result);
mysql_free_result($result);

$rightbranch = checkbranch( $famrow[branch] ) ? 1 : 0;
$famrow[allow_living] = !$famrow[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
$famname = getFamilyName( $famrow );
$namestr = "$text[family]: " . $famname;

$logstring = "<a href=\"$familygroup_url" . "familyID=$familyID&amp;tree=$tree\">$text[familygroupfor] $famname</a>";
writelog($logstring);
preparebookmark($logstring);

$famnotes = getNotes( $familyID, "F" );

$flags['tabs'] = $tngconfig['tabs'];

   	if( $famrow[allow_living] ) {
		getCitations( $familyID );
		$citekey = $familyID . "_";
		$cite = reorderCitation( $citekey );
		if( $cite )
			 $namestr .= "<span class=\"normal\">[$cite]</span>";
	}

	if($famrow['allow_living'])
		tng_header( "$text[familygroupfor] $famname $years ", $flags );
	else
		tng_header( "$text[familygroupfor] $famname", $flags );
	$photostr = showSmallPhoto( $familyID, $famname, $famrow[allow_living], 0 );
	$years = $famrow[marrdate] && $famrow[allow_living] ? $text[marrabbr] . " " . displayDate( $famrow[marrdate] ) : "";
	echo tng_DrawHeading( $photostr, $namestr, $years );
	echo tng_coreicons();

	$famtext = "";
	$personID = $famrow[husband] ? $famrow[husband] : $famrow[wife];
	$fammedia = getMedia( $famrow, "F" );

	$famtext .= "<ul style=\"margin-left: 0px; padding-left: 0;\">\n";
	$famtext .= beginSection("info");
	$famtext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
	$famtext .= "<tr><td height=\"3\" colspan=\"$totcols\"><span class=\"subhead\"><b>$text[parents]</b></span></td></tr>\n";

	//get husband & spouses
	if( $famrow['husband'] ) {
		$query = "SELECT * FROM $people_table WHERE personID = \"$famrow[husband]\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$husbrow = mysql_fetch_assoc($result);
		$label = $husbrow['sex'] != "F" ? $text['husband'] : $text['wife'];
		$famtext .= displayIndividual($husbrow, $label, $familyID, 1);
		mysql_free_result($result);
	}

	//get wife & spouses
	if( $famrow['wife'] ) {
		$query = "SELECT * FROM $people_table WHERE personID = \"$famrow[wife]\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$wiferow = mysql_fetch_assoc($result);
		$label = $husbrow['sex'] != "M" ? $text['wife'] : $text['husband'];
		$famtext .= displayIndividual($wiferow, $label, $familyID, 0);
		mysql_free_result($result);
	}

	//for each child
	$query = "SELECT $people_table.personID as personID, branch, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, famc, sex, birthdate, birthplace, altbirthdate, altbirthplace, haskids, deathdate, deathplace, burialdate, burialplace, baptdate, baptplace, endldate, endlplace, sealdate, sealplace FROM $people_table, $children_table WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = \"$famrow[familyID]\" AND $people_table.gedcom = \"$tree\" AND $children_table.gedcom = \"$tree\" ORDER BY ordernum";
	$children= mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
	
	if( $children && mysql_num_rows( $children ) ) {
		//put a break here, title "Children"
		$famtext .= showBreak();
		$famtext .= "<tr><td height=\"3\" colspan=\"$totcols\"><span class=\"subhead\"><b>$text[children]</b></span></td></tr>\n";
	
		$childcount = 0;
		while( $childrow = mysql_fetch_assoc($children) ) {
			$childcount++;
			$famtext .= displayIndividual($childrow, "$text[child] $childcount", "", 1);
		}
	}
	mysql_free_result($children);
	
	//put a break here, title "Sources"
	$famtext .= showBreak();
	$famtext .= "</table>\n";
	$famtext .= endSection("info");

	$firstsection = 1;
	$firstsectionsave = "";

	$media = doMediaSection($familyID,$fammedia);
	$famtext .= $media;

	if( $famrow[allow_living] ) {
		$notes = buildNotes( $famnotes, $familyID );

		if( $notes ) {
			$famtext .= beginSection("notes");
			$famtext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
			$famtext .= "<tr>\n";
			$famtext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\" id=\"notes1\"><span class=\"fieldname\">$text[notes]&nbsp;</span></td>\n";
			$famtext .= "<td valign=\"top\" class=\"databack\" colspan=\"2\">$notes</td>\n";
			$famtext .= "</tr>\n";
			$famtext .= showBreak();
			$famtext .= "</table>\n";
			$famtext .= endSection("notes");
		}
		if( $citedispctr ) {
			$famtext .= beginSection("citations");
			$famtext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
			$famtext .= "<tr>\n";
			$famtext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\" name=\"citations1\" id=\"citations1\"><a name=\"sources\"><span class=\"fieldname\">$text[sources]&nbsp;</span></td>\n";
			$famtext .= "<td valign=\"top\" class=\"databack\" colspan=\"2\"><ol class=\"normal\" style=\"margin-left:16px;margin-top: 0px; margin-bottom: 0px; padding-left: 1.2em;\">";
			$citectr = 0;
			$count = count($citestring);
			foreach( $citestring as $cite ) {
				$famtext .= "<li class=\"normal\"><a name=\"cite" . ++$citectr . "\"></a><span style=\"position:relative;left:-4px\">$cite<br />";
				if( $citectr < $count )
					$famtext .= "<br />";
				$famtext .= "</span></li>\n";
			}
			$famtext .= "</ol></td>\n";
			$famtext .= "</tr>\n";
			$famtext .= "</table>\n";
			$famtext .= endSection("citations");
		}
	}
	elseif( $famrow[living] ) {
		$famtext .= beginSection("notes");
		$famtext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
		$famtext .= "<tr>\n";
		$famtext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\" id=\"notes1\"><span class=\"fieldname\">$text[notes]&nbsp;</span></td>\n";
		$famtext .= "<td valign=\"top\" class=\"databack\" colspan=\"2\"><span class=\"normal\">$text[livingnote]</span></td>\n";
		$famtext .= "</tr>\n";
		$famtext .= showBreak();
		$famtext .= "</table>\n";
		$famtext .= endSection("notes");
		$notes = true;
	}
	$famtext .= "</ul>\n";

	$tng_alink = $tng_plink = $tng_mlink = "lightlink";
	if( $media || $notes ) {
		if( $tngconfig[istart] )
			$tng_plink = "lightlink3";
		else
			$tng_alink = "lightlink3";
		$innermenu = "<a href=\"#\" class=\"$tng_plink\" onclick=\"return infoToggle('info');\" id=\"tng_plink\">$text[faminfo]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
		if( $media )
			$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('media');\" id=\"tng_mlink\">$text[media]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
		if( $notes )
			$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('notes');\" id=\"tng_nlink\">$text[notes]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
		if( $citedispctr )
			$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('citations');\" id=\"tng_clink\">$text[sources]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
		$innermenu .= "<a href=\"#\" class=\"$tng_alink\" onclick=\"return infoToggle('all');\" id=\"tng_alink\">$text[all]</a>\n";
	}
	else
		$innermenu = "<span class=\"lightlink3\" id=\"tng_plink\">$text[faminfo]</span>\n";

	echo tng_menu( "F", "family", $familyID, $innermenu );
?>
<script type="text/javascript">
function innerToggle(part,subpart,subpartlink) {
	if( part == subpart )
		turnOn(subpart,subpartlink);
	else
		turnOff(subpart,subpartlink);
}

function turnOn(subpart,subpartlink) {
	$(subpartlink).className = 'lightlink3';
	$(subpart).style.display = "";
}

function turnOff(subpart,subpartlink) {
	$(subpartlink).className = 'lightlink';
	$(subpart).style.display = "none";
}

function infoToggle(part) {
	if( part == "all" ) {
		$("info").style.display = "";
<?php
	if( $media ) {
		echo "\$(\"media\").style.display = \"\";\n";
		echo "\$(\"tng_mlink\").className = 'lightlink';\n";
	}
	if( $notes ) {
		echo "\$(\"notes\").style.display = \"\";\n";
		echo "\$(\"tng_nlink\").className = 'lightlink';\n";
	}
	if( $citedispctr ) {
		echo "\$(\"citations\").style.display = \"\";\n";
		echo "\$(\"tng_clink\").className = 'lightlink';\n";
	}
?>
		$("tng_alink").className = 'lightlink3';
		$("tng_plink").className = 'lightlink';
	}
	else {	
		innerToggle(part,"info","tng_plink");
<?php
	if( $media )
		echo "innerToggle(part,\"media\",\"tng_mlink\");\n";
	if( $notes )
		echo "innerToggle(part,\"notes\",\"tng_nlink\");\n";
	if( $citedispctr )
		echo "innerToggle(part,\"citations\",\"tng_clink\");\n";
?>
		$("tng_alink").className = 'lightlink';
	}
	return false;
}
</script>

<?php
	echo $famtext;
?>	
<br/>

<?php
$flags['more'] = "";
if( $firstsectionsave ) {
	$flags['more'] .= "\n<script language=\"JavaScript\" type=\"text/javascript\">\n
	var blocks = $$('td.indleftcol');
	var elementcw = $('info1') ? $('info1').clientWidth : $('$firstsectionsave" . "1').clientWidth;
	var elementcwadj = elementcw - 8;
	blocks.each(function(item) {
		$(item).width = elementcwadj;
	});\n";

	$flags['more'] .= "</script>";
}
if($tentative_edit)
	$flags['more'] .= "<script type=\"text/javascript\" src=\"$cms[tngpath]tentedit.js\"></script>\n";
tng_footer( $flags );
?>
