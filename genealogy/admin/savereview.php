<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "review";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");
require("datelib.php");

if (get_magic_quotes_gpc() == 0) {
	$eventdate = addslashes($newdate);
	$eventplace = addslashes($newplace);
	$info = addslashes($newinfo);
}
else {
	$eventdate = $newdate;
	$eventplace = $newplace;
	$info = $newinfo;
}	

$query = "SELECT * FROM $temp_events_table WHERE tempID = \"$tempID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$tree = $row[gedcom];
$personID = $row[personID];
$familyID = $row[familyID];
$eventID = $row[eventID];

$persfamID = $personID ? $admtext['person'] . " " . $personID : $admtext['family'] . " " . $familyID;

$changedate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );
$eventdatetr = convertDate( $eventdate );
//don't forget to save date

if( $choice == $admtext[savedel] ) {
	if( is_numeric( $eventID ) ) {
		$query = "UPDATE $events_table SET eventdate=\"$eventdate\", eventdatetr=\"$eventdatetr\", eventplace=\"$eventplace\", info=\"$info\" WHERE eventID=\"$eventID\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		if( $row[type] == "F" )
			$query = "UPDATE $families_table SET changedate = \"$changedate\" WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
		else
			$query = "UPDATE $people_table SET changedate = \"$changedate\" WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
	else {
		$needfamilies = 0;
		$needchildren = 0;
		switch( $eventID ) {
			case "TITL":
				$factfield = "title = \"$info\"";
				break;
			case "NPFX":
				$factfield = "prefix = \"$info\"";
				break;
			case "NSFX":
				$factfield = "suffix = \"$info\"";
				break;
			case "NICK":
				$factfield = "nickname = \"$info\"";
				break;
			case "BIRT":
				$datefield = "birthdate = \"$eventdate\", birthdatetr = \"$eventdatetr\"";
				$placefield = "birthplace = \"$eventplace\"";
				break;
			case "CHR":
				$datefield = "altbirthdate = \"$eventdate\", altbirthdatetr = \"$eventdatetr\"";
				$placefield = "altbirthplace = \"$eventplace\"";
				break;
			case "BAPL":
				$datefield = "baptdate = \"$eventdate\", baptdatetr = \"$eventdatetr\"";
				$placefield = "baptplace = \"$eventplace\"";
				break;
			case "ENDL":
				$datefield = "endldate = \"$eventdate\", endldatetr = \"$eventdatetr\"";
				$placefield = "endlplace = \"$eventplace\"";
				break;
			case "DEAT":
				$datefield = "deathdate = \"$eventdate\", deathdatetr = \"$eventdatetr\"";
				$placefield = "deathplace = \"$eventplace\"";
				break;
			case "BURI":
				$datefield = "burialdate = \"$eventdate\", burialdatetr = \"$eventdatetr\"";
				$placefield = "burialplace = \"$eventplace\"";
				break;
			case "MARR":
				$datefield = "marrdate = \"$eventdate\", marrdatetr = \"$eventdatetr\"";
				$placefield = "marrplace = \"$eventplace\"";
				$factfield = "marrtype = \"$info\"";
				$needfamilies = 1;
				break;
			case "DIV":
				$datefield = "divdate = \"$eventdate\", divdatetr = \"$eventdatetr\"";
				$placefield = "divplace = \"$eventplace\"";
				$needfamilies = 1;
				break;
			case "SLGS":
				$datefield = "sealdate = \"$eventdate\", sealdatetr = \"$eventdatetr\"";
				$placefield = "sealplace = \"$eventplace\"";
				$needfamilies = 1;
				break;
			case "SLGC":
				$datefield = "sealdate = \"$eventdate\", sealdatetr = \"$eventdatetr\"";
				$placefield = "sealplace = \"$eventplace\"";
				$needchildren = 1;
				break;
		}
		$fieldstr = $needchildren ? "" : "changedate = \"$changedate\"";
		if( $datefield ) $fieldstr .= $fieldstr ? ", $datefield" : $datefield;
		if( $placefield ) $fieldstr .= $fieldstr ? ", $placefield" : $placefield;
		if( $factfield ) $fieldstr .= $fieldstr ? ", $factfield" : $factfield;
		
		if( $needfamilies )
			$query = "UPDATE $families_table SET $fieldstr WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
		elseif( $needchildren ) {
			$query = "UPDATE $people_table SET changedate = \"$changedate\" WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			$query = "UPDATE $children_table SET $fieldstr WHERE familyID = \"$familyID\" AND personID = \"$personID\" AND gedcom = \"$tree\"";
		}
		else
			$query = "UPDATE $people_table SET $fieldstr WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
		
	if( $eventplace ) {
		$query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,zoom) VALUES (\"$tree\",\"$eventplace\",\"0\",\"0\")";
		$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
	}

	$succmsg = $admtext['tentadd'];
}
if( $choice != $admtext['postpone'] ) {
	$query = "DELETE FROM $temp_events_table WHERE tempID=\"$tempID\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	if( $choice == $admtext['igndel'] )
		$succmsg = $admtext['tentdel'];
}
else {
	$succmsg = "";
	$message = "";
}

if( $succmsg ) {
	if( $row['type'] == "F" )
		adminwritelog( "<a href=\"editfamily.php?familyID=$family&tree=$tree\">$admtext[reviewfamily]: $tree/$row[persfamID]</a>" );
	else
		adminwritelog( "<a href=\"editperson.php?personID=$personID&tree=$tree\">$admtext[reviewperson]: $tree/$row[persfamID]</a>" );
	$message = $admtext['tentdata'] . " $persfamID $succmsg.";
}

header( "Location: findreview.php?type=$type&message=" . urlencode($message) );
?>
