<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "reports";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit && !$allow_add ) {
	exit;
}

require("adminlog.php");

if($session_charset != "UTF-8") {
	$title = utf8_decode($title);
	$description = utf8_decode($description);
}

if(get_magic_quotes_gpc() == 0) {
	$title = addslashes($title);
	$description = addslashes($description);
}
$cleaned = cleanIt($description);
$truncated = substr($cleaned,0,90);
$truncated = strlen($cleaned) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $cleaned;
$cleantitle = cleanIt($title);
if($mediaID == "") $mediaID = 0;

if( $ID ) {
	$query = "UPDATE $mostwanted_table SET title=\"$title\", description=\"$description\", personID=\"$personID\", mediaID=\"$mediaID\", gedcom=\"$mwtree\" WHERE ID=\"$ID\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}
else {
	//get new ordernum
	$query2 = "SELECT max(ordernum) as maxordernum FROM $mostwanted_table WHERE mwtype = \"$mwtype\"";
	$result2 = mysql_query($query2) or die ("$text[cannotexecutequery]: $query2");
	$row2 = mysql_fetch_assoc($result2);
	$ordernum = $row2['maxordernum'] + 1;
	mysql_free_result($result2);

	$query = "INSERT INTO $mostwanted_table (title,description,personID,mediaID,gedcom,mwtype,ordernum) VALUES (\"$title\",\"$description\",\"$personID\",\"$mediaID\",\"$mwtree\",\"$mwtype\",$ordernum)";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$ID = mysql_insert_id();
}

//get thumbnail path
$thumbpath = $size = "";
if($mediaID && $mediaID != $orgmediaID) {
	initMediaTypes();
	$query = "SELECT * FROM $media_table WHERE mediaID = \"$mediaID\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	$mediatypeID = $row['mediatypeID'];
	$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
	if( substr( $usefolder, 0, 1 ) != "/" )
		$relativepath = $cms['support'] ? "../../../" : "../";
	else
		$relativepath = "";

	if( $row['thumbpath'] && file_exists( "$rootpath$usefolder/$row[thumbpath]" ) ) {
		$size = @GetImageSize( "$rootpath$usefolder/$row[thumbpath]" );
		$thumbpath = "$relativepath$usefolder/" . str_replace("%2F","/",rawurlencode( $row['thumbpath'] ));
	}
	mysql_free_result($result);
}

adminwritelog( "$admtext[mostwanted]: $title" );

header("Content-type:text/html; charset=" . $session_charset);
echo "{'ID':'$ID','title':'$cleantitle','description':'$truncated','mwtype':'$mwtype','mediaID':'$mediaID','thumbpath':'$thumbpath','width':'$size[0]','height':'$size[1]','edit':'$allow_edit','del':'$allow_delete'}";
?>