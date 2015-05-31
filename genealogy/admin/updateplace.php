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
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$place = addslashes($place);
	$placelevel = addslashes($placelevel);
	$latitude = addslashes($latitude);
	$longitude = addslashes($longitude);
	$zoom = addslashes($zoom);
	$notes = addslashes($notes);
	$orgplace = addslashes($orgplace);
}
if($latitude && $longitude && $placelevel && !$zoom)
	$zoom = 13;
if( !$zoom ) $zoom = 0;
if( !$placelevel ) $placelevel = 0;
$query = "UPDATE $places_table SET place=\"$place\",placelevel=\"$placelevel\",latitude=\"$latitude\",longitude=\"$longitude\",zoom=\"$zoom\",notes=\"$notes\" WHERE ID=\"$ID\"";
$result = @mysql_query($query);
if( !$result ) {
	$message = $admtext[duplicate];
	header( "Location: places.php?message=" . urlencode($message) );
	exit;
}

if( $propagate ) {
	//people
	$query = "UPDATE $people_table SET birthplace=\"$place\" WHERE birthplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "UPDATE $people_table SET altbirthplace=\"$place\" WHERE altbirthplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "UPDATE $people_table SET deathplace=\"$place\" WHERE deathplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "UPDATE $people_table SET burialplace=\"$place\" WHERE burialplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "UPDATE $people_table SET baptplace=\"$place\" WHERE baptplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "UPDATE $people_table SET endlplace=\"$place\" WHERE endlplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	//families
	$query = "UPDATE $families_table SET marrplace=\"$place\" WHERE marrplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "UPDATE $families_table SET divplace=\"$place\" WHERE divplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "UPDATE $families_table SET sealplace=\"$place\" WHERE sealplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	//events
	$query = "UPDATE $events_table SET eventplace=\"$place\" WHERE eventplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	//children
	$query = "UPDATE $children_table SET sealplace=\"$place\" WHERE sealplace=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	//media
	$query = "UPDATE $medialinks_table SET personID=\"$place\" WHERE personID=\"$orgplace\" AND gedcom=\"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}

adminwritelog( "<a href=\"editplace.php?ID=$ID\">$admtext[modifyplace]: $ID</a>" );

if( $newscreen == "return" )
	header( "Location: editplace.php?ID=$ID&tree=$tree" );
else {
	$message = "$admtext[changestoplace] $ID $admtext[succsaved].";
	header( "Location: places.php?message=" . urlencode($message) );
}
?>
