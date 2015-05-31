<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "timeline";
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
	$evdetail = addslashes($evdetail);
}
if( !$evday ) $evday = "NULL";
if( !$evmonth ) $evmonth = "NULL";
$query = "INSERT INTO $tlevents_table (evday,evmonth,evyear,evdetail) VALUES ($evday,$evmonth,\"$evyear\",\"$evdetail\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$tleventID = mysql_insert_id();

adminwritelog( "$admtext[addnewtlevent]: $tleventID - $evdetail" );

$message = "$admtext[tlevent] $tleventID $admtext[succadded].";
header( "Location: timelineevents.php?message=" . urlencode($message) );
?>
