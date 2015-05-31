<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
$textpart = "getperson";
include($cms[tngpath] . "getlang.php");
include($cms[tngpath] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");

if($session_charset != "UTF-8") {
	$newplace = utf8_decode($newplace);
	$newinfo = utf8_decode($newinfo);
	$usernote = utf8_decode($usernote);
}
$postdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );
$query = "INSERT INTO $temp_events_table (type,gedcom,personID,familyID,eventID,eventdate,eventplace,info,note,user,postdate) VALUES (\"$type\",\"$tree\",\"$personID\",\"$familyID\",\"$eventID\",\"$newdate\",\"$newplace\",\"$newinfo\",\"$usernote\",\"$currentuser\",\"$postdate\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

echo 1;
?>
