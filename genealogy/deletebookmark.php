<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
$textpart = "getperson";
include($cms[tngpath] . "getlang.php");
include($cms[tngpath] . "$mylanguage/text.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");

$newroot = ereg_replace( "/", "", $rootpath );
$newroot = ereg_replace( " ", "", $newroot );
$newroot = ereg_replace( "\.", "", $newroot );
$ref = "tngbookmarks_$newroot";
$bookmarks = $_COOKIE[$ref];
$found = 0;

$bookmarks = explode("|", $_COOKIE[$ref]);
$bookmarkstr = "";
$bcount = 0;
foreach( $bookmarks as $bookmark ) {
	if(trim($bookmark) ) {
		if( $idx != $bcount )
			$bookmarkstr = $bookmarkstr ? $bookmarkstr . "|" . $bookmark : $bookmark;
		$bcount++;
	}
}

//echo $bookmarkstr; exit;
setcookie($ref, stripslashes($bookmarkstr), time()+31536000, "/");
//setcookie($ref, "", time()+31536000, "/");

$bookmarks_url = getURL( "bookmarks", 0 );
header( "Location: $bookmarks_url" );
?>

