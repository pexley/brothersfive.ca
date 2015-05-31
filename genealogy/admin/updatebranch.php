<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "branches";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$description = addslashes($description);
}
$query = "UPDATE $branches_table SET description=\"$description\" WHERE gedcom=\"$tree\" AND branch = \"$branch\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[modifybranch]: $branch" );

$message = "$admtext[changestobranch] $description $admtext[succsaved].";
header( "Location: branches.php?message=" . urlencode($message) );
?>
