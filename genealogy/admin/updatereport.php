<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "reports";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedtree || !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$reportname = addslashes($reportname);
	$reportdesc = addslashes($reportdesc);
	$criteria = addslashes($criteria);
	$sqlselect = addslashes($sqlselect);
}

$query = "UPDATE $reports_table SET reportname=\"$reportname\",reportdesc=\"$reportdesc\",rank=\"$rank\",active=\"$active\",display=\"$display\",criteria=\"$criteria\",orderby=\"$orderby\",sqlselect=\"$sqlselect\" WHERE reportID=\"$reportID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "<a href=\"editreport.php?reportID=$reportID\">$admtext[modifyreport]: $reportID</a>" );

$message = "$admtext[changestoreport] $reportID $admtext[succsaved].";
header( "Location: reports.php?message=" . urlencode($message) );
?>
