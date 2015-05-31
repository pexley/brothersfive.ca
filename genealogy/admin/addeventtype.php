<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "eventtypes";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$type = addslashes($type);
	$tag2 = addslashes($tag2);
	$defdisplay = addslashes($defdisplay);
}

if( $tag2 )
	$tag = $tag2;
else
	$tag = $tag1;
if(!$ordernum) $ordernum = 0;
if( !$display ) $display = $defdisplay;
$query = "INSERT INTO $eventtypes_table (tag,description,display,type,keep,ordernum) VALUES (\"$tag\",\"$description\",\"$display\",\"$type\",\"$keep\",\"$ordernum\")";
$result = mysql_query($query) or die ("Cannot execute query $query");
$eventtypeID = mysql_insert_id();

adminwritelog( "$admtext[addnewevtype]: $tag $type - $display" );

$message = "$admtext[eventtype] $eventtypeID $admtext[succadded].";
header( "Location: eventtypes.php?message=" . urlencode($message) );
?>
