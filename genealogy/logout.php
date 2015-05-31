<?php
include("begin.php");
if($cms['events']){include('cmsevents.php'); cms_logout();}
session_start();
$session_language = $_SESSION[session_language];
$session_charset = $_SESSION[session_charset];
session_unset();
session_destroy();
$newroot = ereg_replace( "/", "", $rootpath );
$newroot = ereg_replace( " ", "", $newroot );
$newroot = ereg_replace( "\.", "", $newroot );
setcookie("tnguser_$newroot", "", time()-31536000, "/");
setcookie("tngpass_$newroot", "", time()-31536000, "/");

session_start();
session_register('session_language');
session_register('session_charset');
$_SESSION[session_language] = $session_language;
$_SESSION[session_charset] = $session_charset;
if( $requirelogin || !isset($_SERVER["HTTP_REFERER"]))
	header("Location: $homepage");
else
	header( "Location: " . $_SERVER["HTTP_REFERER"] );
?>
