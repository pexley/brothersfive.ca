<?php
function getSpouses( $personID, $sex ) {
	global $tree, $families_table, $people_table, $children_table, $text, $allow_living, $nonames, $livedefault;

	$spouses = array();
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
		$query = "SELECT $spouse, familyID, marrdate, marrplace, marrtype, living, branch FROM $families_table WHERE $families_table.$self = \"$personID\" AND gedcom = \"$tree\" ORDER BY $spouseorder";
	else
		$query = "SELECT husband, wife, familyID, marrdate, marrplace, marrtype, living, branch FROM $families_table WHERE $families_table.wife = \"$personID\" AND gedcom = \"$tree\" UNION SELECT husband, wife, familyID, marrdate, marrplace, marrtype, living, branch FROM $families_table WHERE $families_table.husband = \"$personID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$marrtot = mysql_num_rows($result);
	if( !$marrtot ) {
		$query = "SELECT husband, wife, familyID, marrdate, marrplace, marrtype, living, branch FROM $families_table WHERE $families_table.wife = \"$personID\" AND gedcom = \"$tree\" UNION SELECT husband, wife, familyID, marrdate, marrplace, marrtype, living, branch FROM $families_table WHERE $families_table.husband = \"$personID\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$self = $spouse = $spouseorder = "";
	}
	while( $row = mysql_fetch_assoc( $result ) ) {
		if( !$spouse )
			$spouse = $row[husband] == $personID ? "wife" : "husband";
		$query = "SELECT personID, firstname, lnprefix, lastname, suffix, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch FROM $people_table WHERE personID = \"$row[$spouse]\" AND gedcom = \"$tree\"";
		$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$spouserow =  mysql_fetch_assoc( $result2 );
		$spouserow[familyID] = $row[familyID];
		$spouserow[marrdate] = $row[marrdate];
		$spouserow[marrplace] = $row[marrplace];
		$spouserow[marrtype] = $row[marrtype];
		$spouserow[fliving] = $row[living];
		$spouserow[allow_living] = !$spouserow[fliving] || $livedefault == 2 || ( $allow_living && checkbranch( $row[branch] ) ) ? 1 : 0;
		$spouserow[name] = getName( $spouserow );
		array_push( $spouses, $spouserow );
	}
	mysql_free_result( $result );
	
	return $spouses;
}

function getSpouseParents( $personID, $sex) {
	global $tree, $families_table, $people_table, $children_table, $text, $allow_living, $nonames, $getperson_url, $livedefault;

	if( $sex == "M" ) {
		$childtext = $text[sonof];
	}
	else if( $sex == "F" ){
		$childtext = $text[daughterof];
	}
	else {
		$childtext = $text[childof];
	}

	$allparents = "";
	$query = "SELECT familyID FROM $children_table WHERE personID = \"$personID\" AND gedcom = \"$tree\" ORDER BY ordernum";
	$parents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
	if ( $parents && mysql_num_rows( $parents ) ) {
		while ( $parent = mysql_fetch_assoc( $parents ) )
		{
			$parentstr = "";
			$query = "SELECT personID, lastname, lnprefix, firstname, suffix, nameorder, $people_table.living, $people_table.branch FROM $people_table, $families_table WHERE $people_table.personID = $families_table.husband AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
			$gotfather = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
		     if( $gotfather ) { 		
				$fathrow =  mysql_fetch_assoc( $gotfather );
				if( $fathrow[firstname] || $fathrow[lastname] ) {
					$fathrow[allow_living] = !$fathrow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $fathrow[branch] ) ) ? 1 : 0;
					$fathname = getName( $fathrow );
					if( $fathrow[name] == $text[living] ) $fathrow[firstname] = $text[living];
					$parentstr .= "<a href=\"$getperson_url" . "personID=$fathrow[personID]&amp;tree=$tree\">$fathname</a>";
				}
				mysql_free_result( $gotfather );
			} 

			$query = "SELECT personID, lastname, lnprefix, firstname, suffix, nameorder, $people_table.living, $people_table.branch FROM $people_table, $families_table WHERE $people_table.personID = $families_table.wife AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
			$gotmother = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
			if( $gotmother ) { 
				$mothrow =  mysql_fetch_assoc( $gotmother );
				if( $mothrow[firstname] || $mothrow[lastname] ) {
					$mothrow[allow_living] = !$mothrow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $mothrow[branch] ) ) ? 1 : 0;
					$mothname = getName( $mothrow );
					if( $mothrow[name] == $text[living] ) $mothrow[firstname] = $text[living];
					if( $parentstr ) $parentstr .= " $text[text_and] ";
					$parentstr .= "<a href=\"$getperson_url" . "personID=$mothrow[personID]&amp;tree=$tree\">$mothname</a>";
				}
				mysql_free_result( $gotmother );
			} 
			if( $parentstr ) {
				$parentstr = "$childtext $parentstr";
				$allparents .= $allparents ? ", $parentstr" : $parentstr;
			}
		}
		mysql_free_result($parents);
	}
	if( $allparents ) $allparents = "($allparents)";
	
	return $allparents;
}

function getVitalDates( $row ) {
	global $text;
	
	$vitalinfo = "";
	
	if( $row[allow_living] ) {
		if( $row[birthdate] || $row[birthplace] ) {
			$vitalinfo .= " $text[birthabbr] " . displayDate( $row[birthdate] );
			if( $row[birthdate] && $row[birthplace] )
				$vitalinfo .= ", ";
			$vitalinfo .= $row[birthplace];
		}
		if( $row[altbirthdate] || $row[altbirthplace] ){
			if( $vitalinfo ) $vitalinfo .= ";";
			$vitalinfo .= " $text[chrabbr] " . displayDate( $row[altbirthdate] );
			if( $row[altbirthdate] && $row[altbirthplace] )
				$vitalinfo .= ", ";
			$vitalinfo .= $row[altbirthplace];
		}

		if( $row[deathdate] || $row[deathplace] ) {
			if( $vitalinfo ) $vitalinfo .= ";";
			$vitalinfo .= " $text[deathabbr] " . displayDate( $row[deathdate] );
			if( $row[deathdate] && $row[deathplace] )
				$vitalinfo .= ", ";
			$vitalinfo .= $row[deathplace];
		}
		if( $row[burialdate] || $row[burialplace] ){
			if( $vitalinfo ) $vitalinfo .= ";";
			$vitalinfo .= " $text[burialabbr] " . displayDate( $row[burialdate] );
			if( $row[burialdate] && $row[burialplace] )
				$vitalinfo .= ", ";
			$vitalinfo .= $row[burialplace];
		}
	}
	if( $vitalinfo ) $vitalinfo .= ".";
	return $vitalinfo;
}

function getSpouseDates( $row ) {
	global $text;
	
	$spouseinfo = "";
	
	if( $row[allow_living] ) {
		if( $row[marrdate] || $row[marrplace] || $row[marrtype] ) {
			$spouseinfo .= " " . displayDate( $row[marrdate] );
			if( $row[marrtype] ) $spouseinfo .= " ($row[marrtype])";
			if( ( $row[marrdate] || $row[marrtype] ) && $row[marrplace] )
				$spouseinfo .= ", ";
			$spouseinfo .= $row[marrplace];
		}
	}
	if( $spouseinfo ) $spouseinfo .= ".";
	return $spouseinfo;
}

function getNotes( $persfamID, $flag ) {
	global $notelinks_table, $xnotes_table, $tree, $eventtypes_table, $events_table, $text, $eventswithnotes;
	
	$custnotes = array();
	$gennotes = array();
	$precustnotes = array();
	$postcustnotes = array();
	$finalnotesarray = array();
	
	if( $flag == "I" ) {
		$precusttitles = array( "BIRT"=>$text[born], "CHR"=>$text[christened], "NAME"=>$text[name], "TITL"=>$text[title], "NSFX"=>$text[suffix], "NICK"=>$text[nickname], "BAPL"=>$text[baptizedlds], "ENDL"=>$text[endowedlds] );
		$postcusttitles = array( "DEAT"=>$text[died], "BURI"=>$text[buried], "SLGC"=>$text[sealedplds] );
	}
	elseif( $flag == "F" ) {
		$precusttitles = array( "MARR"=>$text[married], "SLGS"=>$text[sealedslds], "DIV"=>$text[divorced] );
		$postcusttitles = array();
	}
	else {
		$precusttitles = array( "ABBR"=>$text[shorttitle], "CALN"=>$text[callnum], "AUTH"=>$text[author], "PUBL"=>$text[publisher], "TITL"=>$text[title] );
		$postcusttitles = array();
	}
		
	$query = "SELECT display, $xnotes_table.note as note, $notelinks_table.eventID as eventID FROM $notelinks_table 
		LEFT JOIN  $xnotes_table on $notelinks_table.xnoteID = $xnotes_table.ID AND $notelinks_table.gedcom = $xnotes_table.gedcom 
		LEFT JOIN $events_table ON $notelinks_table.eventID = $events_table.eventID 
		LEFT JOIN $eventtypes_table on $eventtypes_table.eventtypeID = $events_table.eventtypeID 
		WHERE $notelinks_table.persfamID=\"$persfamID\" AND $notelinks_table.gedcom=\"$tree\" AND secret!=\"1\" 
		ORDER BY ordernum, tag, description, eventdatetr, info, $events_table.eventID";
	$notelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

	$currevent = "";
	$type = 0;
	while( $note = mysql_fetch_assoc( $notelinks ) ) {
		if( !$note[eventID] ) $note[eventID] = "--x-general-x--";
		if( $note[eventID] != $currevent ) {
			$currevent = $note[eventID];
			$currtitle = "";
		}
		if( !$currtitle ) {
			if( $note[display] ) {
				$currtitle = getEventDisplay( $note[display] );
				$key = "cust$currevent";
				$custnotes[$key] = array( "title"=>$currtitle, "text"=>"");
				$type = 2;
			}
			else {
				if( $postcusttitles[$currevent] ) {
					$currtitle = $postcusttitles[$currevent];
					$postcustnotes[$currevent] = array( "title"=>$postcusttitles[$currevent], "text"=>"");
					$type = 3;
				}
				else {
					$currtitle = $precusttitles[$currevent] ? $precusttitles[$currevent] : " ";
					if( $note[eventID] == "--x-general-x--" ) {
						$gennotes[$currevent] = array( "title"=>$precusttitles[$currevent], "text"=>"");
						$type = 0;
					}
					else {
						$precustnotes[$currevent] = array( "title"=>$precusttitles[$currevent], "text"=>"");
						$type = 1;
					}
				}
			}
		}
		switch( $type ) {
			case 0:
				if( $gennotes[$currevent][text] ) $gennotes[$currevent][text] .= "<br/><br/>";
				$gennotes[$currevent][text] .= nl2br($note[note]) . "\n";
				break;
			case 1:
				if( $precustnotes[$currevent][text] ) $precustnotes[$currevent][text] .= "<br/><br/>";
				$precustnotes[$currevent][text] .= nl2br($note[note]) . "\n";
				break;
			case 2:
				if( $custnotes[$key][text] ) $custnotes[$key][text] .= "<br/><br/>";
				$custnotes[$key][text] .= nl2br($note[note]) . "\n";
				break;
			case 3:
				if( $postcustnotes[$currevent][text] ) $postcustnotes[$currevent][text] .= "<br/><br/>";
				$postcustnotes[$currevent][text] .= nl2br($note[note]) . "\n";
				break;
		}
	}
	$finalnotesarray = array_merge( $gennotes, $precustnotes, $custnotes, $postcustnotes );	
	mysql_free_result($notelinks);
	
	return $finalnotesarray;
}

function buildNotes( $notearray ) {
	global $text;
	
	$notes = "";
	foreach( $notearray as $key => $note ) {
		if( $notes )
			$notes .= "<br/><br/>\n";
		if( $note[title] )
			$notes .= "$note[title]:<br/>\n";
		$notes .= $note[text] . "\n";
	}
	return $notes;
}
?>