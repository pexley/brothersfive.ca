<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "reports";
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
	$reportname = addslashes($reportname);
	$reportdesc = addslashes($reportdesc);
	$criteria = addslashes($criteria);
	$sqlselect = addslashes($sqlselect);
}

$query = "INSERT INTO $reports_table (reportname, reportdesc, rank, active, display, criteria, orderby, sqlselect) VALUES (\"$reportname\",\"$reportdesc\",\"$rank\",\"$active\",\"$display\",\"$criteria\",\"$orderby\",\"$sqlselect\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$reportID = mysql_insert_id();

adminwritelog( "<a href=\"editreport.php?reportID=$reportID\">$admtext[addnewreport]: $reportID/$reportname</a>" );

$message = "$admtext[report] $reportID $admtext[succadded].";
header( "Location: reports.php?message=" . urlencode($message) );
?>
