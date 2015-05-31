<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "eventtypes";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedtree || !$allow_edit || !$allow_delete ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

$query = "";
if( $cetaction == $admtext[ignoreselected] )
	$query = "UPDATE $eventtypes_table SET keep=\"0\" WHERE 1=0";
else if( $cetaction == $admtext[acceptselected] )
	$query = "UPDATE $eventtypes_table SET keep=\"1\" WHERE 1=0";
else if( $cetaction == $admtext[deleteselected] )
	$query = "DELETE FROM $eventtypes_table WHERE 1=0";

if( $query ) {
	foreach( array_keys($_POST) as $key ) {
		if( substr( $key, 0, 2 ) == "et" )
			$query .= " OR eventtypeID=\"" . substr( $key, 2 ) . "\"";
	}
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}

adminwritelog( "$admtext[modifyeventtype]: $admtext[all]" );

$message = "$admtext[changestoallevtypes] $admtext[succsaved].";
header( "Location: eventtypes.php?message=" . urlencode($message) );
?>
