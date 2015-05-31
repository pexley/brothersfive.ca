<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "language";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$display = addslashes($display);
	$folder = addslashes($folder);
}
$query = "UPDATE $languages_table SET display=\"$display\",folder=\"$folder\",charset=\"$langcharset\" WHERE languageID=\"$languageID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "<a href=\"editlanguage.php?languageID=$languageID\">$admtext[modifylanguage]: $languageID</a>" );

$message = "$admtext[changestolanguage] $languageID $admtext[succsaved].";
header( "Location: languages.php?message=" . urlencode($message) );
?>
