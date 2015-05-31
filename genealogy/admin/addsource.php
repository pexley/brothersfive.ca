<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$tree = $tree1;
if( !$allow_add || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

$sourceID = ucfirst( $sourceID );

if (get_magic_quotes_gpc() == 0) {
	$shorttitle = addslashes($shorttitle);
	$title = addslashes($title);
	$author = addslashes($author);
	$callnum = addslashes($callnum);
	$publisher = addslashes($publisher);
	$actualtext = addslashes($actualtext);
}

$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

if( !$repoID ) $repoID = 0;
$query = "INSERT INTO $sources_table (sourceID,shorttitle,title,author,callnum,publisher,repoID,actualtext,changedate,gedcom,changedby,type,other,comments) VALUES (\"$sourceID\",\"$shorttitle\",\"$title\",\"$author\",\"$callnum\",\"$publisher\",\"$repoID\",\"$actualtext\",\"$newdate\",\"$tree1\",\"$currentuser\",\"\",\"\",\"\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "<a href=\"editsource.php?sourceID=$sourceID&amp;tree=$tree\">$admtext[addnewsource]: $tree/$sourceID</a>" );

header( "Location: editsource.php?sourceID=$sourceID&tree=$tree" );
?>
