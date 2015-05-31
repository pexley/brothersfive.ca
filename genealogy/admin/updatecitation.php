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

if( !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if($session_charset != "UTF-8") {
	$citepage = utf8_decode($citepage);
	$citetext = utf8_decode($citetext);
	$citenote = utf8_decode($citenote);
}

if (get_magic_quotes_gpc() == 0) {
	$description = addslashes($description);
	$citedate = addslashes($citedate);
	$citepage = addslashes($citepage);
	$citetext = addslashes($citetext);
	$citenote = addslashes($citenote);
}

$citedatetr = convertDate( $citedate );

$query = "UPDATE $citations_table SET sourceID=\"$sourceID\", description=\"$description\", page=\"$citepage\", quay=\"$quay\", citedate=\"$citedate\", citedatetr=\"$citedatetr\", citetext=\"$citetext\", note=\"$citenote\" WHERE citationID=\"$citationID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[modifycite]: $citationID/$sourceID" );

//if sourceID, get title
if( $sourceID ) {
	$query = "SELECT title FROM $sources_table WHERE sourceID = \"$sourceID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	$citationsrc = "[$sourceID] " . addslashes($row[title]);
}
else
	$citationsrc = "$description";

$citationsrc = cleanIt($citationsrc);
$truncated = truncateIt($citationsrc,75);
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"display\":\"$truncated\"}";
?>