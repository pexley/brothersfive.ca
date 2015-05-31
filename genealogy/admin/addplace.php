<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "findplace";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_add ) {
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
}
if($latitude && $longitude && $placelevel && !$zoom)
	$zoom = 13;
if( !$zoom ) $zoom = 0;
if( !$placelevel ) $placelevel = 0;
$query = "INSERT INTO $places_table (gedcom,place,placelevel,latitude,longitude,zoom,notes) VALUES (\"$tree\",\"$place\",\"$placelevel\",\"$latitude\",\"$longitude\",\"$zoom\",\"$notes\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$placeID = mysql_insert_id();

adminwritelog( "<a href=\"editplace.php?ID=$placeID\">$admtext[addnewplace]: $placeID - " . stripslashes($place) . "</a>" );

$message = "$admtext[place] " . stripslashes($place) . " $admtext[succadded].";
header( "Location: places.php?message=" . urlencode($message) );
?>
