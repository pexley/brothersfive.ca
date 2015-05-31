<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "people";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

require("adminlog.php");

$query = "DELETE FROM $assoc_table WHERE assocID=\"$assocID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "SELECT count(assocID) as acount FROM $assoc_table WHERE gedcom=\"$tree\" AND personID=\"$personID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc($result);
mysql_free_result($result);

adminwritelog( "$admtext[deleted]: $admtext[association] $assocID" );

echo $row[acount];
?>