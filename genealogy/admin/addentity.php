<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "entities";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_add ) {
	$message = "$admtext[norights]";
	echo $message;
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) 
	$newname = addslashes( $newitem );
else
	$newname = $newitem;
if( $entity == "state" ) {
	$query = "INSERT INTO $states_table (state) VALUES (\"$newname\")";
}
elseif( $entity == "country" ) {
	$query = "INSERT INTO $countries_table (country) VALUES (\"$newname\")";
}
$result = mysql_query($query);

$newname = stripslashes($newname);
adminwritelog( "$admtext[enternew] $entity: $newname" );

if( $result == false )
	echo "$newitem $admtext[alreadyexists]";
else
	echo "$newitem $admtext[added]";
?>