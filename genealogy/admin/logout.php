<?php
include("../subroot.php");
include($subroot . "config.php");
session_start();
session_unset();
session_destroy();
$newroot = ereg_replace( "/", "", $rootpath );
$newroot = ereg_replace( " ", "", $newroot );
$newroot = ereg_replace( "\.", "", $newroot );
setcookie("tnguser_$newroot", "", time()-3600, "/");
setcookie("tngpass_$newroot", "", time()-3600, "/"); 
header( "Location: login.php?reset=1" );
?>
