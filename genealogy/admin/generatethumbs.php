<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
@set_time_limit(0);

require("adminlog.php");

if( !$allow_add ) {
	echo $admtext['norights'];
	exit;
}

header("Content-type:text/html; charset=" . $session_charset);

initMediaTypes();

$thumbquality = 80;
$maxsizeallowed = 1000; //KB
if( function_exists( imageJpeg ) )
	include( "imageutils.php" );

$query = "SELECT mediaID, path, thumbpath, mediatypeID, usecollfolder, form FROM $media_table where path != \"\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$count = 0;
$conflicts = 0;
$conflictstr = "";
$updated = 0;
$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

while( $row = mysql_fetch_assoc( $result ) ) {
	$needsupdate = 0;
	$newthumbpath = "";
	$mediatypeID = $row[mediatypeID];
	$usefolder = $row[usecollfolder] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
	if( !$row[form] ) {
		$path = $row[thumbpath] ? $row[thumbpath] : $row[path];
		preg_match( "/\.(.+)$/", $path, $matches );
		$ext = strtoupper($matches[1]);
	}
	else
		$ext = $row[form];

	if( $row[thumbpath] && !$repath ) {
		if( (!$regenerate && file_exists( "$rootpath$usefolder/$row[thumbpath]" )) || !in_array($ext,$imagetypes) )
			$newthumbpath = "";
		else
			$newthumbpath = "$rootpath$usefolder/$row[thumbpath]";
	}
	elseif( $row[path] && in_array($ext,$imagetypes) ) {
		//insert prefix in path directly before file name
		$thumbparts = pathinfo( $row[path] );
		$thumbpath = $thumbparts['dirname'];
		if( $thumbpath == "." ) $thumbpath = "";
		if( $thumbpath ) $thumbpath .= "/";
		$lastperiod = strrpos( $thumbparts['basename'], "." );
		$base = substr( $thumbparts['basename'], 0, $lastperiod );
		$thumbpath .= $thumbprefix . $base . $thumbsuffix . "." . $thumbparts['extension'];
		$newthumbpath = "$rootpath$usefolder/$thumbpath";
		if( file_exists( $newthumbpath ) )
			$newthumbpath = "";
		$needsupdate = 1;
	}
	if( $newthumbpath ) {
		$path = "$rootpath$usefolder/$row[path]";
		if( file_exists( "$rootpath$usefolder/$row[path]" ) ) {
			if( ceil( filesize( $path )/1000 ) > $maxsizeallowed ) {
				$needsupdate = 0;
				$conflicts++;
				$conflictstr .= $row['path'] . " " . $admtext['thumbsize'] . "<br />\n";  //file is too big
			}
			else {
				if( function_exists( imageJpeg ) && image_createThumb( $path, $newthumbpath, $thumbmaxw, $thumbmaxh, $thumbquality ) ) {
			        $destInfo  = pathinfo( $newthumbpath );
			        if( strtoupper( $destInfo['extension'] ) == "GIF") {
			            $thumbpath = substr_replace( $thumbpath, 'jpg', -3 );
			            $newthumbpath = substr_replace( $newthumbpath, 'jpg', -3 );
					}
					@chmod( $newthumbpath, 0644 );
					$count++;
				}
				else {
					$needsupdate = 0;
					$conflicts++;
					$conflictstr .= $newthumbpath . " " . $admtext['thumbinv'] . "<br />\n";  //thumb couldn't be created
				}
			}
		}
		else {
			$needsupdate = 0;
			$conflicts++;
			$conflictstr .= $row['path'] . " " . $admtext['thumblost'] . "<br />\n";  //original doesn't exist
		}
	}
	if( $needsupdate ) {
		$query = "UPDATE $media_table SET thumbpath=\"$thumbpath\",changedate=\"$newdate\" WHERE mediaID=\"$row[mediaID]\"";
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$updated++;
	}
}
mysql_free_result($result);

adminwritelog( "$admtext[genthumbs]: $admtext[thumbsgenerated]: $count; $admtext[recsupdated]: $updated; $admtext[thumbconflicts]: $conflicts" );

echo "<p><strong>$admtext[thumbsgenerated]:</strong> $count<br /><strong>$admtext[recsupdated]:</strong> $updated</p>";
if( $conflicts )
	echo "<p><strong>" . $admtext['thumbconflicts'] . ":</strong> $conflicts</p><p>$conflictstr</p>";
?>
