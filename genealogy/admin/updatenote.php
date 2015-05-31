<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "notes";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit ) {
	exit;
}

require("adminlog.php");

if($session_charset != "UTF-8")
	$note = utf8_decode($note);
$orgnote = preg_replace( "/$lineending/", " ", $note );
if (get_magic_quotes_gpc() == 0) {
	$note = addslashes($note);
}

$setnote = "secret=\"$private\"";

if( $xID ) {
	$query = "UPDATE $xnotes_table SET note=\"$note\" WHERE ID=\"$xID\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}

if( !$private ) $private = "0";
$query = "UPDATE $notelinks_table SET secret=\"$private\" WHERE ID=\"$ID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$nextpos = $position+1;

adminwritelog( "$admtext[modifynote]: $tree/$persfamID/$ID/$eventID" );

$orgnote = cleanIt($orgnote);
$truncated = truncateIt($orgnote,75);
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"display\":\"$truncated\"}";
?>