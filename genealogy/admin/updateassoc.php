<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "people";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

require("datelib.php");

if( !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

$orgrelationship = $relationship;
if($session_charset != "UTF-8")
	$relationship = utf8_decode($relationship);
if (get_magic_quotes_gpc() == 0) {
	$relationship = addslashes($relationship);
}

$query = "UPDATE $assoc_table SET passocID=\"$passocID\", relationship=\"$relationship\" WHERE assocID=\"$assocID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[modifycite]: $citationID/$sourceID" );

//get name
$query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix FROM $people_table
	WHERE personID=\"$passocID\" AND gedcom=\"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$name = $session_charset != "UTF-8" ? utf8_encode(getName($row)) : getName($row);
$namestr = cleanIt($name . " ($passocID): " . $orgrelationship);
$namestr = truncateIt($namestr,75);
mysql_free_result($result);
echo "{\"display\":\"$namestr\"}";
?>