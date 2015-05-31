<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "showphoto";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "functions.php" );
include($cms['tngpath'] . "personlib.php" );

$showmedia_url = getURL( "showmedia", 1 );
$getperson_url = getURL( "getperson", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showsource_url = getURL( "showsource", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$browsemedia_url = getURL( "browsemedia", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$histories_url = getURL( "histories", 1 );

initMediaTypes();

if($medialinkID) {
	//look up media & medialinks joined
	//get info for linked person/family/source/repo
	$query = "SELECT mediatypeID, personID, linktype, $medialinks_table.gedcom as gedcom, eventID, ordernum FROM ($media_table, $medialinks_table) WHERE medialinkID = \"$medialinkID\" AND $media_table.mediaID = $medialinks_table.mediaID";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	$personID = $row[personID];
	if(!$requirelogin || !$treerestrict || !$assignedtree) $tree = $row[gedcom];
	$ordernum = $row[ordernum];
	$mediatypeID = $row[mediatypeID];
	$linktype = $row[linktype];
	if( $linktype == "P" ) $linktype = "I";
	$eventID = $row[eventID];
}
else {
	if( $albumlinkID ) {
		$query = "SELECT albumname, description, ordernum, $albums_table.albumID as albumID FROM ($albums_table, $albumlinks_table)
			WHERE albumlinkID = \"$albumlinkID\" AND $albumlinks_table.albumID = $albums_table.albumID";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$row = mysql_fetch_assoc( $result );
		$ordernum = $row[ordernum];
		$albumID = $row[albumID];
		$albumname = $row[albumname];
		$albdesc = $row[description];
		mysql_free_result( $result );
		$showalbum_url = getURL( "showalbum", 1 );
	}
	$query = "SELECT mediatypeID, gedcom FROM $media_table WHERE mediaID = \"$mediaID\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	$mediatypeID = $row[mediatypeID];
	if(!$requirelogin || !$treerestrict || !$assignedtree) $tree = $row[gedcom];
}
//redirect if we're not supposed to be here
if($requirelogin && $treerestrict && $assignedtree && $row[gedcom] && $row[gedcom] != $assignedtree) {
	exit;
}
if( !mysql_num_rows($result) ) {
	mysql_free_result( $result );
	header( "Location: thispagedoesnotexist.html" );
}
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "showmedialib.php");

$info = getMediaInfo($mediatypeID, $mediaID, $personID, $albumID, $albumlinkID, $eventID);
$ordernum = $info['ordernum'];
$mediaID = $info['mediaID'];
$medianotes = $info['medianotes'];
$mediadescription = xmlcharacters($info['mediadescription']);
$page = $info['page'];
$result = $info['result'];
$imgrow = $info['imgrow'];

$livinginfo = findLiving($mediaID, $tree);
$noneliving = $livinginfo['noneliving'];
$rightbranch = $livinginfo['rightbranch'];
$allrightbranch = $livinginfo['allrightbranch'];

if( $noneliving || !$nonames || $imgrow[alwayson] ) {
    $description = $mediadescription;
	$notes = nl2br(xmlcharacters(getXrefNotes($medianotes,$tree)));
	$notes .= $info['gotmap'] ? "<p>" . $text['mediamaptext'] . "</p>" : "";
}
else
	$description = $notes = $text[living];
$logdesc = $nonames && !$noneliving && !$imgrow[alwayson] ? $text[living] : $description;

$usefolder = $imgrow[usecollfolder] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
$size = @GetImageSize( "$rootpath$usefolder/$imgrow[path]", $info );
$adjheight = $size[1] - 1;

$pagenav = getMediaNavigation($mediaID,$personID,$albumlinkID,$result);

if( $page < $totalpages )
	$nextpage = $page + 1;
else
	$nextpage = 1;
$nextmediaID = get_media_id( $result, $nextpage - 1 );
$nextmedialinkID = get_medialink_id( $result, $nextpage - 1 );
$nextalbumlinkID = get_albumlink_id( $result, $nextpage - 1 );
header("Content-type:text/html; charset=" . $session_charset);
echo "mediaID=$nextmediaID&medialinkID=$nextmedialinkID&albumlinkID=$nextalbumlinkID";

mysql_free_result( $result );

echo "<p class=\"subhead\"><strong>$description</strong></p>\n";
echo "<p class=\"normal\">$pagenav</p>";
if( $notes ) echo "<p class=\"normal\">$notes</p>\n";
else
	echo "<br /><br />";

if( $noneliving || $imgrow[alwayson] ) {
	showMediaSource($imgrow);

	if( $imgrow[status] && $mediatypeID == "headstones" )
		echo "<p><b>$text[status]:</b> $imgrow[status]</p>";
	else
		echo "<br /><br />\n";

	$medialinktext = getMediaLinkText($mediaID, $ioffset);
	$albumlinktext = getAlbumLinkText($mediaID);
	echo showTable($imgrow,$medialinktext,$albumlinktext);

	//do cemetery name here for headstones
	//do map here for headstones
	if( $mediatypeID == "headstones" )
		doCemPlusMap($imgrow,$tree);

	if(!$tngprint)
		echo "<p class=\"normal\">$pagenav</p><br/>\n";
}
else {
?>
<table border="1" cellspacing="0" cellpadding="5"><tr><td>
<img src="<?php echo $cms[tngpath]; ?>spacer.gif" alt="" width="<?php echo $size[0]; ?>" height="1" border="0"><br/>
<img src="<?php echo $cms[tngpath]; ?>spacer.gif" alt="" width="1" height="<?php echo $adjheight; ?>" border="0" align="left">
<strong><span class="normal"><?php echo $text[living]; ?></span></strong>
</td></tr></table>
<?php
}
?>
