<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_add ) {
	exit;
}

require("adminlog.php");

$display_org = stripslashes($display);
if (get_magic_quotes_gpc() == 0)
	$display = addslashes( $display );

$collid = cleanID($collid);
$query = "INSERT IGNORE INTO $mediatypes_table (mediatypeID,display,path,liketype,icon,ordernum) VALUES (\"$collid\",\"$display\",\"$path\",\"$liketype\",\"$icon\",\"$ordernum\")";
$result = @mysql_query($query);

if( mysql_affected_rows()>0 ) {
	adminwritelog( "$admtext[addnewcoll]: $display_org" );
	echo $collid;
}
else
	echo "0";
?>
