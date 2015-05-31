<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "findplace";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit ) {
	exit;
}

require("adminlog.php");

$dquery = "DELETE FROM $places_table WHERE gedcom = \"$tree\" AND (";
$addtoquery = "";
$mergelist = explode(',',$places);

foreach( $mergelist as $val ) {
	if( $addtoquery ) $addtoquery .= " OR ";
	$addtoquery .= "ID=\"$val\"";

	$query = "SELECT place FROM $places_table WHERE ID = \"$val\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	mysql_free_result($result);
	$oldplace = addslashes($row[place]);

	$query = "SELECT place FROM $places_table WHERE ID = \"$keep\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	mysql_free_result($result);
	$newplace = addslashes($row[place]);

	if( $oldplace ) {
		$query = "UPDATE $people_table SET birthplace=\"$newplace\" WHERE birthplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$query = "UPDATE $people_table SET altbirthplace=\"$newplace\" WHERE altbirthplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$query = "UPDATE $people_table SET deathplace=\"$newplace\" WHERE deathplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$query = "UPDATE $people_table SET burialplace=\"$newplace\" WHERE burialplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$query = "UPDATE $people_table SET baptplace=\"$newplace\" WHERE baptplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$query = "UPDATE $people_table SET endlplace=\"$newplace\" WHERE endlplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		//families
		$query = "UPDATE $families_table SET marrplace=\"$newplace\" WHERE marrplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$query = "UPDATE $families_table SET divplace=\"$newplace\" WHERE divplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$query = "UPDATE $families_table SET sealplace=\"$newplace\" WHERE sealplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		//events
		$query = "UPDATE $events_table SET eventplace=\"$newplace\" WHERE eventplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		//children
		$query = "UPDATE $children_table SET sealplace=\"$newplace\" WHERE sealplace=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		//media (this is quick & dirty. would be better to cycle through each link and try the update, then delete the old if the update is not successful,
		//since that would indicate a key collision and the old record would remain, but it shouldn't come up very often and it wouldn't be critical in any case)
		$query = "UPDATE $medialinks_table SET personID=\"$newplace\" WHERE personID=\"$oldplace\" AND gedcom=\"$tree\"";
		$result = @mysql_query($query);
	}
}
if( $addtoquery ) {
	$dquery .= $addtoquery . ")";
	$result = mysql_query($dquery) or die ("$admtext[cannotexecutequery]: $dquery");

	adminwritelog( "$admtext[mergeplaces]: $newplace" );

	$message = "$admtext[pmsucc]: $newplace.";
}
echo "1";
?>
