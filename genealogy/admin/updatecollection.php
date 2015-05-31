<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit ) {
	exit;
}

require("adminlog.php");

$display_org = stripslashes($display);
if (get_magic_quotes_gpc() == 0)
	$display = addslashes( $display );

$query = "UPDATE $mediatypes_table SET display=\"$display\", path=\"$path\", liketype=\"$liketype\", icon=\"$icon\", ordernum=\"$ordernum\" WHERE mediatypeID=\"$collid\"";
$result = @mysql_query($query);

if( mysql_affected_rows() ) {
	adminwritelog( "$admtext[editcoll]: $display_org" );	
	echo "1";
}
else
	echo "0";
?>
