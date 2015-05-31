<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "branches";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedbranch || !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$albumname = addslashes($albumname);
	$description = addslashes($description);
	$keywords = addslashes($keywords);
}
$query = "INSERT INTO $albums_table (albumname,description,keywords) VALUES (\"$albumname\",\"$description\",\"$keywords\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$albumID = mysql_insert_id();

adminwritelog( "$admtext[addnewalbum]: $albumname" );

header( "Location: editalbum.php?albumID=$albumID" );
?>
