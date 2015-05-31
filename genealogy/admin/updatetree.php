<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "trees";
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

$treenamedisp = stripslashes($treename);
if (get_magic_quotes_gpc() == 0) {
	$treename = addslashes($treename);
	$description = addslashes($description);
	$owner = addslashes($owner);
	$email = addslashes($email);
	$address = addslashes($address);
	$city = addslashes($city);
	$state = addslashes($state);
	$country = addslashes($country);
	$zip = addslashes($zip);
	$phone = addslashes($phone);
}
if( !$disallowgedcreate ) $disallowgedcreate = 0;
if( !$private ) $private = 0;
$query = "UPDATE $trees_table SET treename=\"$treename\",description=\"$description\",owner=\"$owner\",email=\"$email\",address=\"$address\",city=\"$city\",state=\"$state\",country=\"$country\",zip=\"$zip\",phone=\"$phone\",secret=\"$private\",disallowgedcreate=\"$disallowgedcreate\" WHERE gedcom=\"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "<a href=\"edittree.php?tree=$tree\">$admtext[modifytree]: $tree</a>" );

$message = "$admtext[changestotree] $treenamedisp $admtext[succsaved].";
header( "Location: trees.php?message=" . urlencode($message) );
?>
