<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "timeline";
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
	$evdetail = addslashes($evdetail);
}
if( !$evday ) $evday = "NULL";
if( !$evmonth ) $evmonth = "NULL";
$query = "UPDATE $tlevents_table SET evday=$evday, evmonth=$evmonth, evyear=\"$evyear\",evdetail=\"$evdetail\" WHERE tleventID=\"$tleventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[modifytlevent]: $tleventID" );

if( $newscreen == "return" )
	header( "Location: edittlevent.php?tleventID=$tleventID" );
else {
	$message = "$admtext[changestotlevent] $tleventID $admtext[succsaved].";
	header( "Location: timelineevents.php?message=" . urlencode($message) );
}
?>
