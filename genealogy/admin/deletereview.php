<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "review";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

session_register('tng_search_preview');
$tng_search_preview = $_SESSION[tng_search_preview];

require("adminlog.php");

$query = "SELECT type FROM $temp_events_table WHERE tempID=\"$tempID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);

$query = "DELETE FROM $temp_events_table WHERE tempID=\"$tempID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[deleted]: $admtext[tentdata] $tempID" );

$message = "$admtext[tentdata] $tempID $admtext[succdeleted].";

header( "Location: findreview.php?type=$row[type]&message=" . urlencode($message) . "&time=" . microtime() );
?>
