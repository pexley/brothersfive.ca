<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "eventtypes";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit ) {
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
if( !$display ) $display = $defdisplay;
$query = "UPDATE $eventtypes_table SET tag=\"$tag\",type=\"$type\",description=\"$description\",display=\"$display\",keep=\"$keep\",ordernum=\"$ordernum\" WHERE eventtypeID=\"$eventtypeID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[modifyeventtype]: $eventtypeID" );

$message = "$admtext[changestoevtype] $eventtypeID $admtext[succsaved].";
header( "Location: eventtypes.php?message=" . urlencode($message) );
?>
