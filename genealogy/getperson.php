<?php
include("begin.php");
include($subroot . "mapconfig.php");
$defermap = $tngconfig['istart'] ? 1 : 0;
include($cms['tngpath'] . "genlib.php");
if(!$personID) {header( "Location: thispagedoesnotexist.html" ); exit;}
$textpart = "getperson";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "personlib.php" );

$getperson_url = getURL( "getperson", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showsource_url = getURL( "showsource", 1 );
$showtree_url = getURL( "showtree", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$tentedit_url = getURL( "tentedit", 1 );
$showalbum_url = getURL("showalbum",1);
$pdfform_url = getURL( "pdfform", 1 );
$descend_url = getURL( "descend", 1 );

$citations = array();
$citedisplay = array();
$citestring = array();
$citationctr = 0;
$citedispctr = 0;
$firstsection = 1;
$firstsectionsave = "";
$tableid = "";
$cellnumber = 0;

if($tngprint) $tngconfig['istart'] = "";

$indnotes = getNotes( $personID, "I" );
getCitations( $personID );
$stdex = getStdExtras( $personID );

$query = "SELECT *, DATE_FORMAT(changedate,\"%d %b %Y\") as changedate, $people_table.gedcom as gedcom, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( !mysql_num_rows($result) ) {
	mysql_free_result($result);
	header( "Location: thispagedoesnotexist.html" );
	exit;
}

$row = mysql_fetch_assoc($result);
$rightbranch = checkbranch( $row[branch] ) ? 1 : 0;
$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
if( !$rightbranch ) {
	$tentative_edit = "";
	$allow_lds = "";
}
$namestr = getName( $row );
$nameformap = $namestr;

$logname = $nonames && $row[living] ? $text[living] : $namestr;
$disallowgedcreate = $row[disallowgedcreate];
$treestr = "<a href=\"$showtree_url" . "tree=$tree\">$row[treename]</a>";
if( $row[branch] ) {
	//explode on commas
	$branches = explode(",",$row[branch]);
	$count = 0;
	$branchstr = "";
	foreach($branches as $branch) {
		$count++;
		$brquery = "SELECT description FROM $branches_table WHERE branch = \"$branch\" and gedcom = \"$tree\"";
		$brresult = mysql_query($brquery) or die ("$text[cannotexecutequery]: $brquery");
		$brrow = mysql_fetch_assoc($brresult);
		$branchstr .= $brrow[description] ? $brrow[description] : $branch;
		if($count < count($branches))
			$branchstr .= ", ";
		mysql_free_result($brresult);
	}
	if( $branchstr )
		$treestr = $treestr . " | $branchstr";
}
mysql_free_result($result);

writelog( "<a href=\"$getperson_url" . "personID=$personID&amp;tree=$tree\">$text[indinfofor] $logname ($personID)</a>" );
preparebookmark( "<a href=\"$getperson_url" . "personID=$personID&amp;tree=$tree\">$text[indinfofor] $namestr ($personID)</a>" );

$flags['tabs'] = $tngconfig[tabs];
$flags['scripting'] = "<script type=\"text/javascript\">var tnglitbox;</script>\n";
if( $map[key] )
	$flags['scripting'] .= "<script src=\"http://maps.google.com/maps?file=api&amp;v=2$text[glang]$mcharsetstr&amp;key=$map[key]\" language=\"Javascript\" type=\"text/javascript\"></script>\n";
if($row['allow_living'])
	tng_header( "$namestr $text[birthabbr] $row[birthdate] $row[birthplace] $text[deathabbr] $row[deathdate] $row[deathplace]", $flags );
else
	tng_header($namestr, $flags);

$indmedia = getMedia($row,"I");

	$photostr = showSmallPhoto( $personID, $namestr, $row[allow_living], 0 );
	if( $row[allow_living] ) {
		$citekey = $personID . "_";
		$cite = reorderCitation( $citekey );
		$citekey = $personID . "_NAME";
		$cite2 .= reorderCitation( $citekey );
		if( $cite2 )
			$cite .= $cite ? ", $cite2" : $cite2;
		if( $cite )
			 $namestr .= "<sup><span class=\"normal\">[$cite]</span></sup>";
	}
	echo tng_DrawHeading( $photostr, $namestr, getYears( $row ) );
	echo tng_coreicons();
	
	$persontext = "";
	$persontext .= "<ul style=\"margin-left: 0px; padding-left: 0;\">\n";

	if( $tng_extras ) {
		$media = doMediaSection($personID,$indmedia);
		$persontext .= $media;
	}

	$persontext .= beginSection("info");
	$persontext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
	resetEvents();
	if($row[allow_living] ) {
		if( $row[title] )
			$persontext .= showEvent( array( "text"=>$text[title], "fact"=>$row[title], "event"=>"TITL", "entity"=>$personID, "type"=>"I" ) );
		if( $row[prefix] )
			$persontext .= showEvent( array( "text"=>$text[prefix], "fact"=>$row[prefix], "event"=>"NPFX", "entity"=>$personID, "type"=>"I" ) );
		if( $row[suffix] )
			$persontext .= showEvent( array( "text"=>$text[suffix], "fact"=>$row[suffix], "event"=>"NSFX", "entity"=>$personID, "type"=>"I" ) );
		if( $row[nickname] )
			$persontext .= showEvent( array( "text"=>$text[nickname], "fact"=>$row[nickname], "event"=>"NICK", "entity"=>$personID, "type"=>"I" ) );
		setEvent( array( "text"=>$text[born], "fact"=>$stdex[BIRT], "date"=>$row[birthdate], "place"=>$row[birthplace], "event"=>"BIRT", "entity"=>$personID, "type"=>"I" ), $row[birthdatetr] );
		setEvent( array( "text"=>$text[christened], "fact"=>$stdex[CHR], "date"=>$row[altbirthdate], "place"=>$row[altbirthplace], "event"=>"CHR", "entity"=>$personID, "type"=>"I" ), $row[altbirthdatetr] );
	}
	if ( $row[sex] == "M" ) { 
		$sex = $text[male]; $spouse = "wife"; $self = "husband"; $spouseorder = "husborder";
	}
	else if ($row[sex] == "F" ) { 
		$sex = $text[female]; $spouse = "husband"; $self = "wife"; $spouseorder = "wifeorder";
	}
	else { 
		$sex = $text[unknown];   $spouseorder = "";
	}
	setEvent( array( "text"=>$text[gender], "fact"=>$sex ), $nodate );
	
	if( $row[allow_living] ) {
		if( $allow_lds ) {
			setEvent( array( "text"=>$text[baptizedlds], "fact"=>$stdex[BAPL], "date"=>$row[baptdate], "place"=>$row[baptplace], "event"=>"BAPL", "entity"=>$personID, "type"=>"I" ), $row[baptdatetr] );
			setEvent( array( "text"=>$text[endowedlds], "fact"=>$stdex[ENDL], "date"=>$row[endldate], "place"=>$row[endlplace], "event"=>"ENDL", "entity"=>$personID, "type"=>"I" ), $row[endldatetr] );
		}

		doCustomEvents($personID,"I");

		setEvent( array( "text"=>$text[died], "fact"=>$stdex[DEAT], "date"=>$row[deathdate], "place"=>$row[deathplace], "event"=>"DEAT", "entity"=>$personID, "type"=>"I" ), $row[deathdatetr] );
		setEvent( array( "text"=>$text[buried], "fact"=>$stdex[BURI], "date"=>$row[burialdate], "place"=>$row[burialplace], "event"=>"BURI", "entity"=>$personID, "type"=>"I" ), $row[burialdatetr] );
	}

	ksort( $events );
	foreach( $events as $event )
		$persontext .= showEvent( $event );

	if( $row[allow_living] ) {
		$query = "SELECT passocID, relationship FROM $assoc_table WHERE gedcom = \"$tree\" AND personID = \"$personID\"";
		$assocresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		while($assoc = mysql_fetch_assoc( $assocresult ) ) {
			$persontext .= showEvent( array( "text"=>$text[association], "fact"=>formatAssoc($assoc) ) );
		}
		mysql_free_result( $assocresult );
	}

	$persontext .= showEvent( array( "text"=>$text[personid], "date"=>$personID, "place"=>$treestr, "np"=>1  ) );
	if( $row[changedate] || ( $allow_edit && $rightbranch ) ) {
		$row[changedate] = displayDate( $row[changedate], false );
		if( $allow_edit && $rightbranch ) {
			if( $row[changedate] ) $row[changedate] .= " | ";
			$row[changedate] .= "<a href=\"$cms[tngpath]" . "admin/editperson.php?personID=$personID&amp;tree=$tree&amp;cw=1\" target=\"_blank\">$text[edit]</a>";
		}
		$persontext .= showEvent( array( "text"=>$text[lastmodified], "fact"=>$row[changedate] ) );
	}
	$persontext .= showBreak();

	//do parents
	$query = "SELECT personID, familyID, sealdate, sealdatetr, sealplace, relationship FROM $children_table WHERE personID = \"$personID\" AND gedcom = \"$tree\" ORDER BY parentorder";
	$parents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
	if ( $parents && mysql_num_rows( $parents ) ) {
		while ( $parent = mysql_fetch_assoc( $parents ) )
		{
			resetEvents();
			getCitations( $personID . "::" . $parent[familyID] );
			$query = "SELECT personID, lastname, lnprefix, firstname, prefix, suffix, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, $people_table.living, $people_table.branch FROM $people_table, $families_table WHERE $people_table.personID = $families_table.husband AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
			$gotfather = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
		     if( $gotfather ) { 		
				$fathrow =  mysql_fetch_assoc( $gotfather );
				$birthinfo = getBirthInfo( $fathrow );
				$fathrow[allow_living] = !$fathrow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $fathrow[branch] ) ) ? 1 : 0;
				if( $fathrow[firstname] || $fathrow[lastname] ) {
					$fathname = getName( $fathrow );
					$fatherlink = "<a href=\"$getperson_url" . "personID=$fathrow[personID]&amp;tree=$tree\">$fathname</a>";
				}
				else
					$fatherlink = "";
				if( $fathrow[allow_living] ) $fatherlink .= $birthinfo;
				$persontext .= showEvent( array( "text"=>$text[father], "fact"=>$fatherlink ) );
				mysql_free_result( $gotfather );
			}

			$query = "SELECT personID, lastname, lnprefix, firstname, prefix, suffix, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, $people_table.living, $people_table.branch FROM $people_table, $families_table WHERE $people_table.personID = $families_table.wife AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
			$gotmother = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

			if( $gotmother ) {
				$mothrow =  mysql_fetch_assoc( $gotmother );
				$birthinfo = getBirthInfo( $mothrow );
				$mothrow[allow_living] = !$mothrow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $mothrow[branch] ) ) ? 1 : 0;
				if( $mothrow[firstname] || $mothrow[lastname] ) {
					$mothname = getName( $mothrow );
					$motherlink = "<a href=\"$getperson_url" . "personID=$mothrow[personID]&amp;tree=$tree\">$mothname</a>";
				}
				else
					$motherlink = "";
				if( $mothrow[allow_living] ) $motherlink .= $birthinfo;
				$persontext .= showEvent( array( "text"=>$text[mother], "fact"=>$motherlink ) );
				mysql_free_result( $gotmother );
			}

			if( $row[allow_living] && $parent[relationship] )
				$persontext .= showEvent( array( "text"=>$text['relationship2'], "fact"=>$parent['relationship'] ) );
			if( $row[allow_living] && $allow_lds && $tngconfig['pardata'] < 2 )
				setEvent( array( "text"=>$text[sealedplds], "date"=>$parent[sealdate], "place"=>$parent[sealplace], "event"=>"SLGC", "entity"=>"$personID::$parent[familyID]", "type"=>"C", "nomap"=>1), $parent[sealdatetr] );

			$query = "SELECT living, branch, marrdate, marrdatetr, marrplace, divdate, divdatetr, divplace, familyID FROM $families_table WHERE $families_table.familyID = \"$parent[familyID]\" AND $families_table.gedcom = \"$tree\"";
			$gotparents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$parentrow =  mysql_fetch_assoc( $gotparents );
   			mysql_free_result($gotparents);
			$parent[personID] = "";

			if($tngconfig['pardata'] < 2) {
				$rightfbranch = checkbranch( $parentrow[branch] ) ? 1 : 0;
				$parent[allow_living] = !$parentrow[living] || $livedefault == 2 || ( $allow_living && $rightfbranch ) ? 1 : 0;

				if($parent[allow_living]) {
					setEvent( array( "text"=>$text[married], "fact"=>$stdexf[MARR], "date"=>$parentrow[marrdate], "place"=>$parentrow[marrplace], "event"=>"MARR", "entity"=>$parentrow[familyID], "type"=>"F", "nomap"=>1 ), $parentrow[marrdatetr] );
					setEvent( array( "text"=>$text[divorced], "fact"=>$stdexf[DIV], "date"=>$parentrow[divdate], "place"=>$parentrow[divplace], "event"=>"DIV", "entity"=>$parentrow[familyID], "type"=>"F", "nomap"=>1 ), $parentrow[divdatetr] );

					if(!$tngconfig['pardata'])
						doCustomEvents($parent['familyID'],"F",1);
					ksort( $events );
					foreach( $events as $event )
						$persontext .= showEvent( $event );

					if(!$tngconfig['pardata']) {
						$fammedia = getMedia($parent,"F");
						foreach( $mediatypes as $mediatype ) {
							$mediatypeID = $mediatype[ID];
							$persontext .= writeMedia( $fammedia, $mediatypeID );
						}
					}
				}
			}

			$persontext .= showEvent( array( "text"=>$text[familyid], "date"=>$parent[familyID], "place"=>"<a href=\"$familygroup_url" . "familyID=$parent[familyID]&amp;tree=$tree\">$text[groupsheet]</a>", "np"=>1 ) );
			$persontext .= showBreak();
		}
		mysql_free_result($parents);
	}

	//do marriages
	if( $spouseorder )
		$query = "SELECT $spouse, familyID, living, branch, marrdate, marrdatetr, marrplace, marrtype, divdate, divdatetr, divplace, sealdate, sealdatetr, sealplace, DATE_FORMAT(changedate,\"%d %b %Y\") as changedate FROM $families_table WHERE $families_table.$self = \"$personID\" AND gedcom = \"$tree\" ORDER BY $spouseorder";
	else
		$query = "SELECT husband, wife, familyID, living, branch, marrdate, marrdatetr, marrplace, marrtype, divdate, divdatetr, divplace, sealdate, sealdatetr, sealplace, DATE_FORMAT(changedate,\"%d %b %Y\") as changedate FROM $families_table WHERE $families_table.husband = \"$personID\" AND gedcom = \"$tree\" UNION SELECT husband, wife, familyID, living, branch, marrdate, marrdatetr, marrplace, marrtype, divdate, divdatetr, divplace, sealdate, sealdatetr, sealplace, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") as changedate FROM $families_table WHERE $families_table.wife = \"$personID\" AND gedcom = \"$tree\"";
	$marriages= mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$marrtot = mysql_num_rows($marriages);
	if( !$marrtot ) {
		$query = "SELECT husband, wife, familyID, living, branch, marrdate, marrdatetr, marrplace, marrtype, divdate, divdatetr, divplace, sealdate, sealdatetr, sealplace, DATE_FORMAT(changedate,\"%d %b %Y\") as changedate FROM $families_table WHERE $families_table.husband = \"$personID\" AND gedcom = \"$tree\" UNION SELECT husband, wife, familyID, living, branch, marrdate, marrdatetr, marrplace, marrtype, divdate, divdatetr, divplace, sealdate, sealdatetr, sealplace, DATE_FORMAT(changedate,\"%d %b %Y\") as changedate FROM $families_table WHERE $families_table.wife = \"$personID\" AND gedcom = \"$tree\"";
		$marriages= mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$marrtot = mysql_num_rows($marriages);
		$spouseorder = 0;
	}
	$marrcount = 1;

	while ( $marriagerow =  mysql_fetch_assoc( $marriages ) )
	{
		$famnotes = getNotes( $marriagerow[familyID], "F" );
		getCitations( $marriagerow[familyID] );
		$stdexf = getStdExtras( $marriagerow[familyID] );
		if( $marriagerow[marrtype] ) {
			if( !is_array( $stdexf[MARR] ) ) $stdexf[MARR] = array();
			array_unshift( $stdexf[MARR], "$text[type]: $marriagerow[marrtype]" );
		}

		if( !$spouseorder )
			$spouse = $marriagerow[husband] == $personID ? wife : husband;
		unset($spouserow);
		unset($birthinfo);
		if( $marriagerow[$spouse] ) {
			$query = "SELECT personID, lastname, lnprefix, firstname, prefix, suffix, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, living, branch FROM $people_table WHERE personID = \"$marriagerow[$spouse]\" AND gedcom = \"$tree\"";
			$spouseresult= mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$spouserow =  mysql_fetch_assoc( $spouseresult );
			$birthinfo = getBirthInfo( $spouserow );
			$spouserow[allow_living] = !$spouserow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $spouserow[branch] ) ) ? 1 : 0;
			if( $spouserow[firstname] || $spouserow[lastname] ) {
				$spousename = getName( $spouserow );
				$spouselink = "<a href=\"$getperson_url" . "personID=$spouserow[personID]&amp;tree=$tree\">$spousename</a>";
			}
			if( $spouserow[allow_living] ) $spouselink .= $birthinfo;
		}
		else
			$spouselink = "";
		$marrstr = $marrtot > 1 ? " $marrcount" : "";
		if( $spouserow[allow_living] )
			$persontext .= showEvent( array( "text"=>"$text[family]$marrstr", "fact"=>$spouselink, "entity"=>$marriagerow[familyID], "type"=>"F" ) );
		else
			$persontext .= showEvent( array( "text"=>"$text[family]$marrstr", "fact"=>$spouselink ) );

		$rightfbranch = checkbranch( $marriagerow[branch] ) ? 1 : 0;
		$marriagerow[allow_living] = !$marriagerow[living] || $livedefault == 2 || ( $allow_living && $rightfbranch ) ? 1 : 0;
		$fammedia = getMedia($marriagerow,"F");
		if( $marriagerow[allow_living] ) {
			resetEvents();

			setEvent( array( "text"=>$text[married], "fact"=>$stdexf[MARR], "date"=>$marriagerow[marrdate], "place"=>$marriagerow[marrplace], "event"=>"MARR", "entity"=>$marriagerow[familyID], "type"=>"F" ), $marriagerow[marrdatetr] );
			setEvent( array( "text"=>$text[divorced], "fact"=>$stdexf[DIV], "date"=>$marriagerow[divdate], "place"=>$marriagerow[divplace], "event"=>"DIV", "entity"=>$marriagerow[familyID], "type"=>"F" ), $marriagerow[divdatetr] );

			if( $allow_lds ) {
				setEvent( array( "text"=>$text[sealedslds], "fact"=>$stdexf[SLGS], "date"=>$marriagerow[sealdate], "place"=>$marriagerow[sealplace], "event"=>"SLGS", "entity"=>$marriagerow[familyID], "type"=>"F" ), $marriagerow[sealdatetr] );
			}

			doCustomEvents($marriagerow['familyID'],"F");
			ksort( $events );
			foreach( $events as $event )
				$persontext .= showEvent( $event );

			$famnotes2 = "";
			if( !$notestogether )
				$famnotes2 = buildNotes( $famnotes, $marriagerow[familyID] );
			else
				$famnotes2 = buildGenNotes( $famnotes, $marriagerow[familyID], "--x-general-x--" );

			if( $famnotes2 ) {
				$persontext .= "<tr>\n";
				$persontext .= "<td valign=\"top\" class=\"fieldnameback\"><span class=\"fieldname\">$text[notes]&nbsp;</span></td>\n";
				$persontext .= "<td valign=\"top\" class=\"databack\" colspan=\"2\"><span class=\"normal\">$famnotes2</span></td>\n";
				$persontext .= "</tr>\n";
			}
		}
		$marrcount++;
	
		//do children
		$query = "SELECT $people_table.personID as pID, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, haskids, living, branch FROM $people_table, $children_table WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = \"$marriagerow[familyID]\" AND $people_table.gedcom = \"$tree\" AND $children_table.gedcom = \"$tree\" ORDER BY ordernum";
		$children= mysql_query($query) or die ("$text[cannotexecutequery]: $query");

		if( $children && mysql_num_rows( $children ) ) {
			$persontext .= "<tr>\n";
			$persontext .= "<td valign=\"top\" class=\"fieldnameback\"><span class=\"fieldname\">$text[children]&nbsp;</span></td>\n";
			$persontext .= "<td colspan=\"2\" valign=\"top\" class=\"databack\">\n";

			$kidcount = 1;
			$persontext .= "<table cellpadding = \"0\" cellspacing = \"0\">\n";
			while ( $child =  mysql_fetch_assoc( $children ) )
			{
				$ifkids = $child[haskids] ? "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree\" title=\"$text[descendants]\" style=\"text-decoration:none\"><strong>&gt;</strong></a>" : "&nbsp;";
				$birthinfo = getBirthInfo( $child );
				$child[allow_living] = !$child[living] || $livedefault == 2 || ( $allow_living && checkbranch( $child[branch] ) ) ? 1 : 0;
				if( $child[firstname] || $child[lastname] ) {
					$childname = getName( $child );
					$persontext .= "<tr><td valign=\"top\">$ifkids</td><td onmouseover=\"highlightChild(1,'$child[pID]');\" onmouseout=\"highlightChild(0,'$child[pID]');\" class=\"unhighlightedchild\" id=\"child$child[pID]\"><span class=\"normal\">$kidcount. <a href=\"$getperson_url" . "personID=$child[pID]&amp;tree=$tree\">$childname</a>";
					if( $child[allow_living] ) $persontext .= $birthinfo;
					$persontext .= "</span></td></tr>\n";
					$kidcount++;
				}
			}
			$persontext .= "</table>\n";
			$persontext .= "</td>\n";
			$persontext .= "</tr>\n";

			mysql_free_result( $children );
		}

		foreach( $mediatypes as $mediatype ) {
			$mediatypeID = $mediatype[ID];
			$persontext .= writeMedia( $fammedia, $mediatypeID );
		}

		if( $marriagerow[changedate] || ( $allow_edit && $rightfbranch ) ) {
			$marriagerow[changedate] = displayDate( $marriagerow[changedate] );
			if( $allow_edit && $rightfbranch ) {
				if( $marriagerow[changedate] ) $marriagerow[changedate] .= " | ";
				$marriagerow[changedate] .= "<a href=\"$cms[tngpath]" . "admin/editfamily.php?familyID=$marriagerow[familyID]&amp;tree=$tree&amp;cw=1\" target=\"_blank\">$text[edit]</a>";
			}
			$persontext .= showEvent( array( "text"=>$text[lastmodified], "fact"=>$marriagerow[changedate] ) );
		}
		$persontext .= showEvent( array( "text"=>$text[familyid], "date"=>$marriagerow[familyID], "place"=>"<a href=\"$familygroup_url" . "familyID=$marriagerow[familyID]&amp;tree=$tree\">$text[groupsheet]</a>", "np"=>1 ) );
		$persontext .= showBreak();
	}
	mysql_free_result($marriages);

	$persontext .= "</table>\n";
	$persontext .= endSection("info");

	if ( $map[key] && $locations2map ) {
		$persontext .= beginSection("eventmap");
		$persontext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
		$persontext .= "<tr valign=\"top\"><td class=\"fieldnameback indleftcol\" id=\"eventmap1\"><span class=\"fieldname\">$text[gmapevent]</span></td>\n";
		$persontext .= "<td class=\"databack\" width=\"65%\">\n";
		$persontext .= "<div id=\"map\" style=\"width: $map[indw]; height: $map[indh];\"></div>\n";
		$persontext .= "</td>\n";
		$persontext .= "<td class=\"databack\"><span class=\"normal\">$text[gevents]<br /></span><table cellpadding=\"4\">\n";

		asort($locations2map);
		reset($locations2map);
		$markerIcon = 0;
		$nonzeroplaces = 0;
		$usedplaces = array();
		$savedplaces = array();
		while( list($key, $val) = each($locations2map) ) {
		// RM these next lines are about getting different coloured pins for different levels of place
			$placelevel = $val[placelevel];
			$pinplacelevel = $val[pinplacelevel];
			if (!$placelevel)
				$placelevel = 0;
			else
				$nonzeroplaces++;
			if (!$pinplacelevel) $pinplacelevel = $pinplacelevel0;
			$lat = $val[lat];
			$long = $val[long];
			$zoom = $val[zoom] ? $val[zoom] : 10;
			$event = $val[event];
			$place = $val[place];
			$dateforremoteballoon = $dateforeventtable = displayDate($val[eventdate]);
			$dateforlocalballoon = htmlspecialchars(mysql_escape_string($dateforremoteballoon), ENT_QUOTES);
			$description = $val[description];
			if ($place) {
				$persontext .= "<tr valign=\"top\"><td class=\"databack\">";
				if( $lat && $long ) {
					if($map[showallpins] || !in_array($place,$usedplaces)) {
						$markerIcon++;
						$usedplaces[] = $place;
						$savedplaces[] = array("place"=>$place,"key"=>$key);
						$locations2map[$key][htmlcontent] = "<div class =\"normal\"  style=\"width:240px; margin-top:10px\"><strong>$val[fixedplace]</strong><br /><br />$event: $dateforlocalballoon</div>";
						$thismarker = $markerIcon;
					}
					else {
						$total = count($usedplaces);
						for($i = 0; $i < $total; $i++) {
							if($savedplaces[$i][place] == $place) {
								$thismarker = $i + 1;
								$thiskey = $savedplaces[$i][key];
                                $locations2map[$thiskey][htmlcontent] = str_replace("</div>","<br/>$event: $dateforlocalballoon</div>",$locations2map[$thiskey][htmlcontent]);
								break;
							}
						}
					}
					$codedplace = htmlspecialchars(stri_replace($banish, $banreplace, $place), ENT_QUOTES);
					$codedballoontext = htmlspecialchars(stri_replace($banish, $banreplace, "$place - $nameformap $event $description $dateforremoteballoon"), ENT_QUOTES);
					$persontext .= "<a href=\"http://maps.google.com/maps?f=q$text[glang]$mcharsetstr&amp;q=$lat,$long($codedballoontext)&amp;z=$zoom&amp;om=1&amp;iwloc=addr\" target= \"_blank\"><img src=\"$cms[tngpath]" . "googlemaps/numbered_marker.php?image=$pinplacelevel.png&amp;text=$thismarker&amp;name=pin$pinplacelevel" . "no$thismarker.png\" alt=\"$text[googlemaplink]\" border=\"0\" width= \"20\" height=\"34\" /></a>";
					$map[pins]++;
				}
				else
					$persontext .= "&nbsp;";
				$persontext .= "</td><td class=\"databack\"><span class=\"smaller\"><strong>$event</strong>";
				if($description) $persontext .= " - $description";
				$persontext .= " - $dateforeventtable - $place</span></td>\n";
				$persontext .= "<td class=\"databack\" valign=\"middle\"><a href=\"$cms[tngpath]" . "googlemaps/googleearthbylatlong.php?m=world&amp;n=$codedplace&amp;lon=$long&amp;lat=$lat&amp;z=$zoom\"><img src=\"$cms[tngpath]" . "googlemaps/earth.gif\" border=\"0\" alt=\"$text[googleearthlink]\" width=\"15\" height=\"15\" /></a></td></tr>\n";
			}
		}
		$persontext .= "</table>\n<table>";
		$persontext .= "<tr><td><span class=\"smaller\"><img src=\"$cms[tngpath]" . "googlemaps/white.gif\" alt=\"\" height=\"15\" width=\"9\" align=\"left\" hspace=\"5\" />&nbsp;= $text[googlemaplink]&nbsp;</span></td></tr>\n";
		$persontext .= "<tr><td><span class=\"smaller\"><img src=\"$cms[tngpath]" . "googlemaps/earth.gif\" border=\"0\" alt=\"\" width=\"15\" height=\"15\" align=\"left\" />&nbsp;= <a href=\"http://earth.google.com/download-earth.html\" target=\"_blank\">$text[googleearthlink]</a>&nbsp;</span></td></tr></table>\n";
		$persontext .= "</td>\n</tr>\n";
		if($nonzeroplaces) {
			$persontext .= "<tr valign=\"top\"><td class=\"fieldnameback\"><span class=\"fieldname\">$text[gmaplegend]</span></td>\n";
			$persontext .= "<td colspan=\"2\" class=\"databack\"><span class=\"smaller\">";
			for($i = 1; $i < 7; $i++ )
				$persontext .= "<img src=\"$cms[tngpath]" . "googlemaps/" . ${"pinplacelevel" .$i} . ".png\" alt=\"\" height=\"34\" width=\"20\" />=&nbsp;" . $admtext["level$i"] . "&nbsp;&nbsp;\n";
			$persontext .= "<img src=\"$cms[tngpath]" . "googlemaps/$pinplacelevel0.png\" alt=\"\" height=\"34\" width=\"20\" />=&nbsp;$admtext[level0]</span></td>\n";
			$persontext .= "</tr>\n";
		}
		$persontext .= "</table>\n";
		$persontext .= endSection("eventmap");
		$persontext .= "<br />";
	}

	if( !$tng_extras ) {
		$media = doMediaSection($personID,$indmedia);
		$persontext .= $media;
	}

	if( $row[allow_living] ) {
		if( !$notestogether )
			$notes = buildNotes( $indnotes, $personID );
		else
			$notes = buildGenNotes( $indnotes, $personID, "--x-general-x--,NAME" );

		if( $notes ) {
			$persontext .= beginSection("notes");
			$persontext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
			$persontext .= "<tr>\n";
			$persontext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\" id=\"notes1\"><span class=\"fieldname\">$text[notes]&nbsp;</span></td>\n";
			$persontext .= "<td valign=\"top\" class=\"databack\" colspan=\"2\">$notes</td>\n";
			$persontext .= "</tr>\n";
			$persontext .= showBreak();
			$persontext .= "</table>\n";
			$persontext .= endSection("notes");
		}
	}
	elseif( $row[living] ) { 
		$notes = 1;
		$persontext .= beginSection("notes");
		$persontext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
		$persontext .= "<tr>\n";
		$persontext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\" id=\"notes1\"><span class=\"fieldname\">$text[notes]&nbsp;</span></td>\n";
		$persontext .= "<td valign=\"top\" class=\"databack\" colspan=\"2\"><span class=\"normal\">$text[livingnote]</span></td>\n";
		$persontext .= "</tr>\n";
		$persontext .= showBreak();
		$persontext .= "</table>\n";
		$persontext .= endSection("notes");
	}
	
	if( $citedispctr ) {
		$persontext .= beginSection("citations");
		$persontext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
		$persontext .= "<tr>\n";
		$persontext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\" id=\"citations1\"><a name=\"sources\"><span class=\"fieldname\">$text[sources]&nbsp;</span></a></td>\n";
		$persontext .= "<td valign=\"top\" class=\"databack\" colspan=\"2\"><ol class=\"normal\" style=\"margin-left:16px;margin-top: 0px; margin-bottom: 0px; padding-left: 1.2em;\">";
		$citectr = 0;
		$count = count($citestring);
		foreach( $citestring as $cite ) {
			$persontext .= "<li class=\"normal\"><a name=\"cite" . ++$citectr . "\"></a>$cite<br />";
			if( $citectr < $count )
				$persontext .= "<br />";
			$persontext .= "</li>\n";
		}
		$persontext .= "</ol></td>\n";
		$persontext .= "</tr>\n";
		$persontext .= "</table>\n";
		$persontext .= endSection("citations");
	}
	$persontext .= "</ul>\n";

	$tng_alink = $tng_plink = $tng_mlink = $tng_glink = "lightlink";
	if( $media || $notes || $citedispctr || $map[key] ) {
		if( $tngconfig[istart] ) {
			if( $tng_extras )
				$tng_mlink = "lightlink3";
			else
				$tng_plink = "lightlink3";
		}
		else
			$tng_alink = "lightlink3";
		$innermenu = "<a href=\"#\" class=\"$tng_plink\" onclick=\"return infoToggle('info');\" id=\"tng_plink\">$text[persinfo]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
		if( $media )
			$innermenu .= "<a href=\"#\" class=\"$tng_mlink\" onclick=\"return infoToggle('media');\" id=\"tng_mlink\">$text[media]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
		if( $notes )
			$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('notes');\" id=\"tng_nlink\">$text[notes]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
		if( $citedispctr )
			$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('citations');\" id=\"tng_clink\">$text[sources]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
		if( $map[key] && $locations2map)
			$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('eventmap');\" id=\"tng_glink\">$text[gmapevent]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
		$innermenu .= "<a href=\"#\" class=\"$tng_alink\" onclick=\"return infoToggle('all');\" id=\"tng_alink\">$text[all]</a>\n";
	}
	else
		$innermenu = "<span class=\"lightlink3\" id=\"tng_plink\">$text[persinfo]</span>\n";
	$innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"#\" class=\"lightlink\" onclick=\"tnglitbox = new LITBox('$pdfform_url" . "pdftype=ind&amp;personID=$personID&amp;tree=$tree',{width:350,height:350});return false;\">PDF</a>\n";

	echo tng_menu( "I", "person", $personID, $innermenu );
?>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>getperson.js"></script>
<script type="text/javascript">
function infoToggle(part) {
	if( part == "all" ) {
		document.getElementById("info").style.display = "";
<?php
	if( $media ) {
		echo "document.getElementById(\"media\").style.display = \"\";\n";
		echo "document.getElementById(\"tng_mlink\").className = 'lightlink';\n";
	}
	if( $notes ) {
		echo "document.getElementById(\"notes\").style.display = \"\";\n";
		echo "document.getElementById(\"tng_nlink\").className = 'lightlink';\n";
	}
	if( $citedispctr ) {
		echo "document.getElementById(\"citations\").style.display = \"\";\n";
		echo "document.getElementById(\"tng_clink\").className = 'lightlink';\n";
	}
	if( $map[key] && $locations2map) {
		echo "document.getElementById(\"eventmap\").style.display = \"\";\n";
		echo "document.getElementById(\"tng_glink\").className = 'lightlink';\n";
	}
?>
		document.getElementById("tng_alink").className = 'lightlink3';
		document.getElementById("tng_plink").className = 'lightlink';
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
	if( $map[key] && $locations2map) {
		echo "innerToggle(part,\"eventmap\",\"tng_glink\");\n";
	}
?>
		document.getElementById("tng_alink").className = 'lightlink';
	}
<?php
	if( $map[key] && $locations2map && $tngconfig[istart]) {
		echo "if((part==\"eventmap\" || part==\"all\") && !maploaded) {\n";
		echo "ShowTheMap();\n}\n";
	}
?>
	return false;
}
</script>

<?php
	echo $persontext;
?>
<br/>

<?php
$flags['more'] = "\n<script language=\"JavaScript\" type=\"text/javascript\">
var blocks = $$('td.indleftcol');
var elementcw = $('info1') ? $('info1').clientWidth : $('$firstsectionsave" . "1').clientWidth;
var elementcwadj = elementcw - 8;
blocks.each(function(item) {
	$(item).width = elementcwadj;
});\n";
if( $map['key'] && $locations2map ) {
	if($tngconfig['istart'])
		$flags['more'] .= "window.onload = function() {document.getElementById('eventmap').style.display = 'none';};\n";
}

$flags['more'] .= "</script>\n";
$flags['more'] .= "<script type=\"text/javascript\" src=\"$cms[tngpath]rpt_utils.js\"></script>\n";
if($tentative_edit)
	$flags['more'] .= "<script type=\"text/javascript\" src=\"$cms[tngpath]tentedit.js\"></script>\n";
tng_footer( $flags );
?>
