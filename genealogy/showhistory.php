<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
include($cms[tngpath] . "getlang.php");
include($cms[tngpath] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");
include($cms[tngpath] . "log.php" );
include($cms[tngpath] . "functions.php" );
include($cms[tngpath] . "personlib.php" );

$getperson_url = getURL( "getperson", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showsource_url = getURL( "showsource", 1 );
$browsedocs_url = getURL( "browsedocs", 1 );
$showhistory_url = getURL( "showhistory", 1 );

if( $familyID )
	$personID = $familyID;
elseif( $sourceID )
	$personID = $sourceID;

if( !$personID ) {
	$query = "SELECT description, bodytext, notes, alwayson, usenl FROM $histories_table WHERE docID = \"$docID\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	$docdescription = $row[description];
	$docnotes = $row[notes];
}
else {
	$query = "SELECT description, altdescription, bodytext, notes, altnotes, alwayson, usenl, $histories_table.docID as docID
	FROM $histories_table, $doclinks_table
	WHERE personID = \"$personID\" AND $doclinks_table.gedcom = \"$tree\" AND ordernum = \"$ordernum\" AND $histories_table.docID = $doclinks_table.docID ORDER by ordernum";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	$docID = $row[docID];
	$docdescription = $row[altdescription] ? $row[altdescription] : $row[description];
	$docnotes = $row[altnotes] ? $row[altnotes] : $row[notes];
}

//write to log
$query = "SELECT $doclinks_table.ID, $doclinks_table.personID as personID, $doclinks_table.gedcom as gedcom, people.living as living, people.branch as branch, $families_table.branch as fbranch, $families_table.living as fliving
	FROM $doclinks_table
	LEFT JOIN $people_table AS people ON $doclinks_table.personID = people.personID AND $doclinks_table.gedcom = people.gedcom
	LEFT JOIN $families_table ON $doclinks_table.personID = $families_table.familyID AND $doclinks_table.gedcom = $families_table.gedcom
	WHERE $doclinks_table.docID = \"$docID\"";
$dresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$noneliving = 1;
$rightbranch = $livedefault == 2 ? 1 : 0;
$allrightbranch = 1;
while( $drow = mysql_fetch_assoc( $dresult ) )
{
	if( $drow[fbranch] != NULL ) $drow[branch] = $drow[fbranch];
	if( $drow[fliving] != NULL ) $drow[living] = $drow[fliving];
	if( $drow[living] == NULL ) {
		$query = "SELECT count(personID) as ccount FROM $citations_table, $people_table 
			WHERE $citations_table.sourceID = '$drow[personID]' AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
			AND living = '1'";
		$dresult2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$drow2 = mysql_fetch_assoc( $dresult2 );
		if( $drow2[ccount] ) $drow[living] = 1;
		mysql_free_result( $dresult2 );
	}
	if( $livedefault != 2 ) {
		if( $drow[living] ) {
			if( !$allow_living_db || $livedefault == 1 || ($assignedtree && $assignedtree != $drow[gedcom]) || !checkbranch( $drow[branch] ) )
				$noneliving = 0;
		}
		if( $drow[personID] == $personID && checkbranch( $drow[branch] ) )
			$rightbranch = 1;
		if( !checkbranch( $drow[branch] ) )
			$allrightbranch = 0;
	}
}
mysql_free_result( $dresult );

if( $noneliving || !$nonames || $row[alwayson] ) {
       $description = $docdescription;
	   $notes = $docnotes;
       $bodytext = $row[usenl] ? nl2br($row[bodytext]) : $row[bodytext];
}
else {
       $description = $bodytext = $text[living];
	   $notes = "";
}
$logdesc = $nonames && !$noneliving && !$row[alwayson] ? $text[living] : $description;

if( !$personID )
	writelog( "<a href=\"$showhistory_url" . "docID=$docID\">$text[docof] $logdesc ($docID)</a>" );
else {
	if( $familyID )
		writelog( "<a href=\"$showhistory_url" . "familyID=$personID&amp;tree=$tree&amp;ordernum=$ordernum\">$text[historyof] $logdesc ($row[docID])</a>" );
	elseif( $sourceID )
		writelog( "<a href=\"$showhistory_url" . "sourceID=$personID&amp;tree=$tree&amp;ordernum=$ordernum\">$text[historyof] $logdesc ($row[docID])</a>" );
	else
		writelog( "<a href=\"$showhistory_url" . "personID=$personID&amp;tree=$tree&amp;ordernum=$ordernum\">$text[historyof] $logdesc ($row[docID])</a>" );
}


tng_header( $row[description], $flags ); 

echo "<p class=\"header\">$description</p><p>$notes</p><br />\n\n";
echo tng_coreicons();

echo $bodytext;

if( $ioffset ) {
	$ioffsetstr = "$ioffset, ";
	$newioffset = $ioffset + 1;
}
else {
	$ioffsetstr = "";
	$newioffset = "";
}
$query = "SELECT $doclinks_table.ID, $doclinks_table.personID as personID, people.living as living, people.branch as branch, $families_table.branch as fbranch, $families_table.living as fliving, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.suffix as suffix, people.nameorder, altdescription, altnotes, $doclinks_table.gedcom,
	familyID, people.personID as personID2, wifepeople.personID as wpersonID, wifepeople.firstname as wfirstname, wifepeople.lnprefix as wlnprefix, wifepeople.lastname as wlastname,
	wifepeople.suffix as wsuffix, husbpeople.personID as hpersonID, husbpeople.firstname as hfirstname, husbpeople.lnprefix as hlnprefix, husbpeople.lastname as hlastname,
	husbpeople.suffix as hsuffix, $sources_table.title, $sources_table.sourceID
	FROM $doclinks_table
	LEFT JOIN $people_table AS people ON $doclinks_table.personID = people.personID AND $doclinks_table.gedcom = people.gedcom
	LEFT JOIN $families_table ON $doclinks_table.personID = $families_table.familyID AND $doclinks_table.gedcom = $families_table.gedcom
	LEFT JOIN $people_table AS husbpeople ON $families_table.husband = husbpeople.personID AND $families_table.gedcom = husbpeople.gedcom
	LEFT JOIN $people_table AS wifepeople ON $families_table.wife = wifepeople.personID AND $families_table.gedcom = wifepeople.gedcom
	LEFT JOIN $sources_table ON $doclinks_table.personID = $sources_table.sourceID AND $doclinks_table.gedcom = $sources_table.gedcom
	WHERE docID = \"$docID\" ORDER BY people.lastname, people.lnprefix, people.firstname, hlastname, hlnprefix, hfirstname  LIMIT $ioffsetstr" . ($maxsearchresults + 1);
$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numrows = mysql_num_rows( $presult );
$doclinktext = "";
$noneliving = 1;
$count = 0;
while( $count < $maxsearchresults && $prow = mysql_fetch_assoc( $presult ) )
{
	if( $prow[fbranch] != NULL ) $prow[branch] = $prow[fbranch];
	if( $prow[fliving] != NULL ) $prow[living] = $prow[fliving];
	if( $doclinktext ) $doclinktext .= "\n";
	if( !$prow[living] || $livedefault == 2 || ( !$livedefault && $allow_living_db && ( !$assignedtree || $assignedtree == $prow[gedcom] ) && checkbranch( $prow[branch] ) ) )
		$prow[allow_living] = 1;
	else {
		$noneliving = 0;
		$prow[allow_living] = 0;
	}
	if( $prow[personID2] != NULL ) {
		$doclinktext .= "<a href=\"$getperson_url" . "personID=$prow[personID2]&amp;tree=$prow[gedcom]\">";
		$doclinktext .= getName( $prow ) . "</a>";
	}
	elseif( $prow[sourceID] != NULL ) {
		$sourcetext = $prow[title] ? $prow[title] : $prow[sourceID];
		$doclinktext .= "<a href=\"$showsource_url" . "sourceID=$prow[sourceID]&amp;tree=$prow[gedcom]\">$text[source]: $sourcetext</a>";
	}
	elseif( $prow[familyID] != NULL ) {
		$familyname = trim("$prow[hlnprefix] $prow[hlastname]") . "/" . trim("$prow[wlnprefix] $prow[wlastname]") . " ($prow[familyID])";
		$doclinktext .= "<a href=\"$familygroup_url" . "familyID=$prow[familyID]&amp;tree=$prow[gedcom]\">$text[family]: $familyname</a>";
	}
	$count++;
}
mysql_free_result( $presult );
if( $numrows > $maxsearchresults )
	$doclinktext .= "\n[<a href=\"$showhistory_url" . $addon . "docID=$docID&amp;ioffset=" . ($newioffset + $maxsearchresults) . "\">$text[morelinks]</a>]";

$filename = basename( $imgrow[path] );
echo "<p class=\"normal\">$pagenav</p>\n";
echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\">\n";

if( $showextended ) {
	echo showEvent( array( "text"=>$text[filename], "fact"=>$filename ) );
	//echo showEvent( array( "text"=>$text[photosize], "fact"=>"$size[0] x $size[1]" ) );
}

if( $doclinktext )
	echo showEvent( array( "text"=>$text[indlinked], "fact"=>$doclinktext ) );
echo "</table>\n";

tng_footer( "" ); 
?>
