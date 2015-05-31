<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

require("datelib.php");
require("adminlog.php");

if($session_charset != "UTF-8") {
	$citepage = utf8_decode($citepage);
	$citetext = utf8_decode($citetext);
	$citenote = utf8_decode($citenote);
}

if (get_magic_quotes_gpc() == 0) {
	$citedate = addslashes($citedate);
	$citepage = addslashes($citepage);
	$citetext = addslashes($citetext);
	$citenote = addslashes($citenote);
}

$citedatetr = convertDate( $citedate );

$query = "INSERT INTO $citations_table (gedcom, persfamID, eventID, sourceID, page, quay, citedate, citedatetr, citetext, note, description)  VALUES(\"$tree\", \"$persfamID\", \"$eventID\", \"$sourceID\", \"$citepage\", \"$quay\", \"$citedate\", \"$citedatetr\", \"$citetext\", \"$citenote\",\"\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$citationID = mysql_insert_id();

adminwritelog( "$admtext[addnewcite]: $citationID/$tree/$persfamID/$eventID/$sourceID" );

$query = "SELECT title FROM $sources_table WHERE sourceID = \"$sourceID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc($result);

$citationsrc = "[$sourceID] $row[title]";
$citationsrc = cleanIt($citationsrc);
$truncated = truncateIt($citationsrc,75);
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"id\":\"$citationID\",\"perfamID\":\"$persfamID\",\"tree\":\"$tree\",\"eventID\":\"$eventID\",\"display\":\"$truncated\",\"allow_edit\":$allow_edit,\"allow_delete\":$allow_delete}";
?>