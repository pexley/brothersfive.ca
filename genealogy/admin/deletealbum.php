<?php
include("../config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_delete ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

$query = "DELETE FROM $albums_table WHERE albumID=\"$albumID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DELETE FROM $albumlinks_table WHERE albumID=\"$albumID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[deleted]: $admtext[album] $albumID" );

$message = "$admtext[album] $albumID $admtext[succdeleted].";
header( "Location: albums.php?message=" . urlencode($message) );
?>
