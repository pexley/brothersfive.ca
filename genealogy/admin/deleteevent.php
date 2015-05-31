<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "events";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_delete ) {
	exit;
}

require("adminlog.php");

$query = "SELECT addressID FROM $events_table WHERE eventID=\"$eventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result( $result );

$query = "DELETE FROM $address_table WHERE addressID=\"$row[addressID]\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DELETE FROM $events_table WHERE eventID=\"$eventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DELETE FROM $citations_table WHERE eventID=\"$eventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "SELECT xnoteID FROM $notelinks_table WHERE eventID=\"$eventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result( $result );

$query = "SELECT count(ID) as xcount FROM $notelinks_table WHERE xnoteID=\"$row[xnoteID]\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result( $result );
if( $row[xcount] == 1 ) {
	$query = "DELETE FROM $xnotes_table WHERE ID=\"$row[xnoteID]\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}

$query = "DELETE FROM $notelinks_table WHERE eventID=\"$eventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[deleted]: $admtext[event] $eventID" );
echo 1;
?>
