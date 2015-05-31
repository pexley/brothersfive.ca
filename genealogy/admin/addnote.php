<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "notes";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_add || ( $assignedtree && $assignedtree != $tree ) ) {
	exit;
}

require("adminlog.php");

if($session_charset != "UTF-8")
	$note = utf8_decode($note);
$orgnote = preg_replace( "/$lineending/", " ", $note );
if (get_magic_quotes_gpc() == 0) {
	$note = addslashes($note);
}

$query = "INSERT INTO $xnotes_table (noteID, gedcom, note)  VALUES(\"\", \"$tree\", \"$note\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$xnoteID = mysql_insert_id();

if( !$private ) $private = "0";
$query = "INSERT INTO $notelinks_table (persfamID, gedcom, xnoteID, eventID, secret) VALUES (\"$persfamID\", \"$tree\", \"$xnoteID\", \"$eventID\", \"$private\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$ID = mysql_insert_id();

adminwritelog( "$admtext[addnewnote]: $tree/$persfamID/$xnoteID/$eventID" );

$orgnote = cleanIt($orgnote);
$truncated = truncateIt($orgnote,75);
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"id\":\"$ID\",\"perfamID\":\"$persfamID\",\"tree\":\"$tree\",\"eventID\":\"$eventID\",\"display\":\"$truncated\",\"allow_edit\":$allow_edit,\"allow_delete\":$allow_delete}";
?>