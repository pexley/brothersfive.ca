<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");
initMediaTypes();

$exptime = time()+3600*24*365;
setcookie("lastcoll", $mediatypeID, $exptime);

$thumbquality = 80;
if( function_exists( imageJpeg ) )
	include( "imageutils.php" );

$path = stripslashes($path);
$thumbpath = stripslashes($thumbpath);
if( substr( $path, 0, 1 ) == "/" )
	$path = substr( $path, 1 );

$usefolder = $usecollfolder ? $mediatypes_assoc[$mediatypeID] : $mediapath;
$newpath = "$rootpath$usefolder/$path";

if( $newfile && $newfile != "none" ) {
	if( @move_uploaded_file($newfile, $newpath) )
		@chmod( $newpath, 0644 );
	else {
	//improper permissions or folder doesn't exist (root path may be wrong)
		$message = "$admtext[notcopied] $newpath $admtext[improperpermissions].";
		header( "Location: media.php?message=" . urlencode($message) );
		exit;
	}
}

if( substr( $thumbpath, 0, 1 ) == "/" )
	$thumbpath = substr( $thumbpath, 1 );
$newthumbpath = "$rootpath$usefolder/$thumbpath";

if( function_exists( imageJpeg ) && $thumbcreate == "auto" ) {
	if( image_createThumb( $newpath, $newthumbpath, $thumbmaxw, $thumbmaxh, $thumbquality ) ) {
        $destInfo  = pathInfo( $newthumbpath ); 
        if( strtoupper( $destInfo['extension'] ) == "GIF") {
            $thumbpath = substr_replace( $thumbpath, 'jpg', -3 ); 
            $newthumbpath = substr_replace( $newthumbpath, 'jpg', -3 ); 
		}
		@chmod( $newthumbpath, 0644 );
	}
	else {
	//could not create thumbnail (size or type problem) or permissions (root path may be wrong)
		$message = "$admtext[thumbnailnotcopied] $newthumbpath $admtext[improper2].";
		header( "Location: media.php?message=" . urlencode($message) );
		exit;
	}
}
else {
	if( $newthumb && $newthumb != "none" ) {
		if( @move_uploaded_file($newthumb, $newthumbpath) ) 
			@chmod( $newthumbpath, 0644 );
		else {
		//improper permissions or folder doesn't exist (root path may be wrong)
			$message = "$admtext[thumbnailnotcopied] $newthumbpath $admtext[improperpermissions].";
			header( "Location: media.php?message=" . urlencode($message) );
			exit;
		}
	}
}

if (get_magic_quotes_gpc() == 0) {
	$description = addslashes($description);
	$notes = addslashes($notes);
	$datetaken = addslashes($datetaken);
	$owner = addslashes($owner);
	$status = addslashes($status);
	$bodytext = addslashes($bodytext);
	$width = addslashes($width);
	$height = addslashes($height);
	$plot = addslashes($plot);
}
if($latitude && $longitude && !$zoom)
	$zoom = 13;
if( $abspath )
	$path = $mediaurl;
else
	$abspath = 0;
if( !$showmap ) $showmap = "0";
if( !$usenl ) $usenl = 0;
if( !$alwayson ) $alwayson = 0;
if( !$newwindow ) $newwindow = 0;
if( !$usecollfolder ) $usecollfolder = 0;
if( !$width ) $width = 0;
if( !$height ) $height = 0;
if( !$cemeteryID ) $cemeteryID = 0;
if( !$linktocem ) $linktocem = 0;
if( !$zoom ) $zoom = 0;

$fileparts = pathinfo( $path );
$form = strtoupper( $fileparts["extension"] );
$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );
$mediakey = $path ? "$usefolder/$path" : time();
$query = "INSERT IGNORE INTO $media_table (mediatypeID,mediakey,gedcom,path,thumbpath,description,notes,width,height,datetaken,placetaken,owner,changedate,changedby,form,alwayson,map,abspath,status,cemeteryID,plot,showmap,linktocem,latitude,longitude,zoom,bodytext,usenl,newwindow,usecollfolder)
		VALUES (\"$mediatypeID\",\"$mediakey\",\"$tree\",\"$path\",\"$thumbpath\",\"$description\",\"$notes\",\"$width\",\"$height\",\"$datetaken\",\"$placetaken\",\"$owner\",\"$newdate\",\"$currentuser\",\"$form\",\"$alwayson\",\"$imagemap\",\"$abspath\",\"$status\",\"$cemeteryID\",\"$plot\",\"$showmap\",\"$linktocem\",\"$latitude\",\"$longitude\",\"$zoom\",\"$bodytext\",\"$usenl\",\"$newwindow\",\"$usecollfolder\")";
$result = @mysql_query($query);
$success = mysql_affected_rows($link);
if( $result && $success) {
	$mediaID = mysql_insert_id();

	if($link_personID) {
		$query = "SELECT count(medialinkID) as count FROM $medialinks_table WHERE personID = \"$link_personID\" AND gedcom = \"$link_tree\"";
		$result = @mysql_query($query);
		if( $result ) {
			$row = mysql_fetch_assoc($result);
			$newrow = $row['count'] + 1;
			mysql_free_result($result);
		}
		else
			$newrow = 1;

		$query = "INSERT IGNORE INTO $medialinks_table (personID,mediaID,ordernum,gedcom,linktype,eventID) VALUES (\"$link_personID\",\"$mediaID\",\"$newrow\",\"$link_tree\",\"$link_linktype\",\"\")";			
		$result = @mysql_query($query);
	}
	adminwritelog( "<a href=\"editmedia.php?mediaID=$mediaID\">$admtext[addnewmedia]: $mediaID</a>" );

	header( "Location: editmedia.php?mediaID=$mediaID&newmedia=1" );
}
else {
	$message = "$admtext[photonotadded].";
	header( "Location: media.php?message=" . urlencode($message) );
}
?>