<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
if( $link ) {
	include("checklogin.php");
	if( $assignedtree ) {
		$message = "$admtext[norights]";
		header( "Location: login.php?message=" . urlencode($message) );
		exit;
	}
}

echo phpinfo();
?>