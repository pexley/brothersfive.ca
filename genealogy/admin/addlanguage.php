<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "language";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedtree || !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$display = addslashes($display);
	$folder = addslashes($folder);
}
$query = "INSERT INTO $languages_table (display,folder,charset) VALUES (\"$display\",\"$folder\",\"$langcharset\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$languageID = mysql_insert_id();

adminwritelog( "<a href=\"editlanguage.php?languageID=$languageID\">$admtext[addnewlanguage]: $display/$folder</a>" );

$message = "$admtext[language] $display $admtext[succadded].";
header( "Location: languages.php?message=" . urlencode($message) );
?>
