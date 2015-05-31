<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "branches";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedbranch || !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$branch = addslashes($branch);
	$description = addslashes($description);
}
$query = "INSERT INTO $branches_table (gedcom,branch,description) VALUES (\"$tree\",\"$branch\",\"$description\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$success = mysql_affected_rows( );

adminwritelog( "$admtext[addnewbranch]: $gedcom/$description" );

$message = "$admtext[branch] $description $admtext[succadded].";
header( "Location: branches.php?message=" . urlencode($message) );
?>
