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

$query = "DELETE FROM $citations_table WHERE citationID=\"$citationID\"";
$result = @mysql_query($query);

$query = "SELECT count(citationID) as ccount FROM $citations_table WHERE gedcom=\"$tree\" AND persfamID=\"$personID\" AND eventID=\"$eventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc($result);
mysql_free_result($result);

adminwritelog( "$admtext[deleted]: $admtext[citation] $citationID" );

echo $row['ccount'];
?>
