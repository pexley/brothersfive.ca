<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "entities";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_delete ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

$newname = get_magic_quotes_gpc() == 0 ? addslashes( $delitem ) : $delitem;
if( $entity == "state" ) {
	$query = "DELETE FROM $states_table WHERE state = \"$newname\"";
}
elseif( $entity == "country" ) {
	$query = "DELETE FROM $countries_table WHERE country = \"$newname\"";
}
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[deleted]: $entity: $newname" );
echo "1";
?>
 