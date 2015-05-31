<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
$textpart = "search";
include($cms[tngpath] . "getlang.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");

$relationship_url = getURL( "relationship", 1 );

header( "Location: " . "$relationship_url" . $QUERY_STRING );
?>