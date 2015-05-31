<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;

session_start();
session_register('session_language');
session_register('session_charset');

$query = "SELECT display, folder, charset FROM $languages_table WHERE languageID = \"$newlanguage\"";
$result = mysql_query($query) or die ("Cannot execute query: $query"); //message is hardcoded because we haven't included the text file yet
$row = mysql_fetch_assoc($result);
mysql_free_result( $result );

$session_language = $_SESSION['session_language'] = $row['folder'];
$session_charset = $_SESSION['session_charset'] = $row['charset'];

$newroot = ereg_replace( "/", "", $rootpath );
$newroot = ereg_replace( " ", "", $newroot );
$newroot = ereg_replace( "\.", "", $newroot );
setcookie("tnglang_$newroot", $row['folder'], time()+31536000, "/");
setcookie("tngchar_$newroot", $row['charset'], time()+31536000, "/");

header( "Location: $homepage" );
?>
