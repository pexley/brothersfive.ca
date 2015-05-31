<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
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
initMediaTypes();

function reorderMedia( $query, $plink, $mediatypeID ) {
	global $admtext, $medialinks_table, $media_table;

	$ptree = $plink[gedcom];
	$eventID = $plink[eventID];
	$result3 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $personrow = mysql_fetch_assoc( $result3 ) ) {
		$query = "SELECT medialinkID FROM ($medialinks_table, $media_table) WHERE personID = \"$personrow[personID]\" AND $medialinks_table.gedcom = \"$ptree\" AND $media_table.mediaID = $medialinks_table.mediaID AND eventID = \"$eventID\" AND mediatypeID = \"$mediatypeID\" ORDER BY ordernum";
		$result4 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		$counter = 1;
		while( $medialinkrow = mysql_fetch_assoc( $result4 ) ) {
			$query = "UPDATE $medialinks_table SET ordernum = \"$counter\" WHERE medialinkID = \"$medialinkrow[medialinkID]\"";
			$result5 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			$counter++;
		}
		mysql_free_result( $result4 );
	}
	mysql_free_result( $result3 );
}

$thumbquality = 80;
if( function_exists( imageJpeg ) )
	include( "imageutils.php" );

$usefolder = $usecollfolder ? $mediatypes_assoc[$mediatypeID] : $mediapath;

if( substr( $thumbpath, 0, 1 ) == "/" )
	$thumbpath = substr( $thumbpath, 1 );
$newthumbpath = "$rootpath$usefolder/$thumbpath";

if (get_magic_quotes_gpc() == 0) {
	$description = addslashes($description);
	$notes = addslashes($notes);
	$datetaken = addslashes($datetaken);
	$placetaken = addslashes($placetaken);
	$owner = addslashes($owner);
	$imagemap = addslashes($imagemap);
	$bodytext = addslashes($bodytext);
	$latitude = addslashes($latitude);
	$longitude = addslashes($longitude);
	$zoom = addslashes($zoom);
	$width = addslashes($width);
	$height = addslashes($height);
	$plot = addslashes($plot);
}
if($latitude && $longitude && !$zoom)
	$zoom = 13;
$fileparts = pathinfo( $path );
$form = strtoupper( $fileparts["extension"] );
$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

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

if( $usecollfolder && $mediatypeID != $mediatypeID_org ) {
	$oldmediapath = $mediatypes_assoc[$mediatypeID_org];
	$newmediapath = $mediatypes_assoc[$mediatypeID];
	if( $path_org ) {
		$oldpath = "$rootpath$oldmediapath/$path_org";
		$newpath = "$rootpath$newmediapath/$path";
		if( file_exists( $oldpath ) )
			@rename($oldpath, $newpath);
	}

	if( $thumbpath_org ) {
		$oldthumbpath = "$rootpath$oldmediapath/$thumbpath_org";
		$newthumbpath = "$rootpath$newmediapath/$thumbpath";
		if( file_exists( $oldthumbpath ) )
			@rename($oldthumbpath, $newthumbpath);
	}
}

$mediakey = $path != $path_org ? "$usefolder/$path" : $mediakey_org;
if(!$mediakey) $mediakey = time();
$query = "UPDATE $media_table SET path=\"$path\",thumbpath=\"$thumbpath\",description=\"$description\",notes=\"$notes\",width=\"$width\",height=\"$height\",datetaken=\"$datetaken\",placetaken=\"$placetaken\",owner=\"$owner\",changedate=\"$newdate\",changedby=\"$currentuser\",form=\"$form\",alwayson=\"$alwayson\",mediatypeID=\"$mediatypeID\",map=\"$imagemap\",abspath=\"$abspath\",gedcom=\"$tree\",status=\"$status\",cemeteryID=\"$cemeteryID\",plot=\"$plot\",showmap=\"$showmap\",linktocem=\"$linktocem\",latitude=\"$latitude\",longitude=\"$longitude\",zoom=\"$zoom\",bodytext=\"$bodytext\",usenl=\"$usenl\",newwindow=\"$newwindow\",usecollfolder=\"$usecollfolder\",mediakey=\"$mediakey\"  WHERE mediaID=\"$mediaID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

if( substr( $path, 0, 1 ) == "/" )
	$path = substr( $path, 1 );
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

if( $mediatypeID != $mediatypeID_org ) {
	$query = "SELECT personID, $medialinks_table.gedcom, eventID FROM ($medialinks_table, $media_table) WHERE $medialinks_table.mediaID = \"$mediaID\" AND $medialinks_table.mediaID = $media_table.mediaID";
	$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	if( $result2 ) {
		while( $plink = mysql_fetch_assoc( $result2 ) ) {
			$query = "SELECT personID from $people_table WHERE personID = \"$plink[personID]\" AND gedcom = \"$plink[gedcom]\"";
			reorderMedia( $query, $plink, $mediatypeID_org );
			reorderMedia( $query, $plink, $mediatypeID );

			$query = "SELECT familyID as personID from $families_table WHERE familyID = \"$plink[personID]\" AND gedcom = \"$plink[gedcom]\"";
			reorderMedia( $query, $plink, $mediatypeID_org );
			reorderMedia( $query, $plink, $mediatypeID );

			$query = "SELECT sourceID as personID from $sources_table WHERE sourceID = \"$plink[personID]\" AND gedcom = \"$plink[gedcom]\"";
			reorderMedia( $query, $plink, $mediatypeID_org );
			reorderMedia( $query, $plink, $mediatypeID );

			$query = "SELECT repoID as personID from $repositories_table WHERE repoID = \"$plink[personID]\" AND gedcom = \"$plink[gedcom]\"";
			reorderMedia( $query, $plink, $mediatypeID_org );
			reorderMedia( $query, $plink, $mediatypeID );
		}
		mysql_free_result($result2);
	}
}

adminwritelog( "<a href=\"editmedia.php?mediaID=$mediaID\">$admtext[modifymedia]: $mediaID</a>" );

if( $newmedia == "return" )
	header( "Location: editmedia.php?mediaID=$mediaID&cw=$cw" );
else if( $newmedia == "close" ) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<body>
<script type="text/javascript">
	window.close();
</script>
</body>
</html>
<?php
}
else  {
	$message = "$admtext[changestoitem] $mediaID $admtext[succsaved].";
	header( "Location: media.php?message=" . urlencode($message) );
}
?>
