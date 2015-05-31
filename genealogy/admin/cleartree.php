<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "trees";
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

include("treelib.php");

$message = "$admtext[tree] $gedcom $admtext[succcleared].";

adminwritelog( "$admtext[deleted]: $admtext[tree] $tree" );

header( "Location: trees.php?message=" . urlencode($message) );
?>
