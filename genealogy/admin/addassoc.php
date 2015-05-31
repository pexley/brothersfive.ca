<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

require("adminlog.php");

if($session_charset != "UTF-8")
	$relationship = utf8_decode($relationship);
if (get_magic_quotes_gpc() == 0) {
	$relationship = addslashes($relationship);
}

$query = "INSERT INTO $assoc_table (gedcom, personID, passocID, relationship)  VALUES(\"$tree\", \"$personID\", \"$passocID\", \"$relationship\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$assocID = mysql_insert_id();

if($revassoc) {
	$query = "INSERT INTO $assoc_table (gedcom, personID, passocID, relationship)  VALUES(\"$tree\", \"$passocID\", \"$personID\", \"$relationship\")";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}

adminwritelog( "$admtext[addnewassoc]: $assocID/$tree/$personID::$passocID ($relationship)" );

//get name
$query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix FROM $people_table
	WHERE personID=\"$passocID\" AND gedcom=\"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$namestr = cleanIt(getName($row) . " ($passocID): " . stripslashes($relationship));
$namestr = truncateIt($namestr,75);
mysql_free_result($result);
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"id\":\"$assocID\",\"display\":\"$namestr\",\"allow_edit\":$allow_edit,\"allow_delete\":$allow_delete}";
?>