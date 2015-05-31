<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
if(!is_numeric($mediaID)) {header( "Location: thispagedoesnotexist.html" ); exit;}
$textpart = "showphoto";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "functions.php" );
include($cms['tngpath'] . "personlib.php" );

//starting time between slides
$slidetime_display = "3.0";
//starting time in microseconds
$slidetime_micro = 3000;

$showmedia_url = getURL( "showmedia", 1 );
$showalbum_url = getURL( "showalbum", 1 );
$getperson_url = getURL( "getperson", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showsource_url = getURL( "showsource", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$browsemedia_url = getURL( "browsemedia", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$histories_url = getURL( "histories", 1 );

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
	header("location: $browsemedia_url");
	exit;
}
if( !mysql_num_rows($result) ) {
	mysql_free_result( $result );
	header( "Location: thispagedoesnotexist.html" );
}
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "showmedialib.php");

$mediaperpage = 1;
$max_showmedia_pages = 5;

$info = getMediaInfo($mediatypeID, $mediaID, $personID, $albumID, $albumlinkID, $eventID);
$ordernum = $info['ordernum'];
$mediaID = $info['mediaID'];
$medianotes = $info['medianotes'];
$mediadescription = $info['mediadescription'];
$page = $info['page'];
$result = $info['result'];
$imgrow = $info['imgrow'];
$numitems = mysql_num_rows($result);

if($personID && !$albumlinkID) {
	if( $linktype == "L" ) {
		$row['allow_living'] = 1;
		$rightbranch = 1;
	}
	else {
		if( $linktype == "F" )
			$query = "SELECT familyID, husband, wife, living, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"$personID\" AND gedcom = \"$tree\"";
		elseif( $linktype == "S" )
			$query = "SELECT title FROM $sources_table WHERE sourceID = \"$personID\" AND gedcom = \"$tree\"";
		elseif( $linktype == "R" )
			$query = "SELECT reponame FROM $repositories_table WHERE repoID = \"$personID\" AND gedcom = \"$tree\"";
		elseif( $linktype == "I" ) {
			$query = "SELECT lastname, firstname, prefix, suffix, title, lnprefix, living, branch, birthdate, altbirthdate, deathdate, burialdate, sex, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
				FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
		}
		$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( $result2 ) {
			$row = mysql_fetch_assoc($result2);
			if( $linktype == "S" || $linktype == "R" ) {
				$row['allow_living'] = 1;
				$rightbranch = 1;
			}
			else {
				$rightbranch = checkbranch( $row['branch'] ) ? 1 : 0;
				$row['allow_living'] = !$row['living'] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
				$disallowgedcreate = $row['disallowgedcreate'];
			}
			mysql_free_result($result2);
		}
	}
}

$livinginfo = findLiving($mediaID, $tree);
$noneliving = $livinginfo['noneliving'];
//$rightbranch = $livinginfo['rightbranch'];
$allrightbranch = $livinginfo['allrightbranch'];

if( $noneliving || !$nonames || $imgrow[alwayson] ) {
    $description = ereg_replace("\"", "&#34;",$mediadescription);
	$notes = nl2br(getXrefNotes($medianotes,$tree));
	$notes .= $info['gotmap'] ? "<p>" . $text['mediamaptext'] . "</p>" : "";
}
else
	$description = $notes = $text[living];
$logdesc = $nonames && !$noneliving && !$imgrow[alwayson] ? $text[living] : $description;

if( !$personID ) {
	writelog( "<a href=\"$showmedia_url" . "mediaID=$mediaID&amp;tnggallery=$tnggallery\">$text[mediaof] $logdesc ($mediaID)</a>" );
	preparebookmark( "<a href=\"$showmedia_url" . "mediaID=$mediaID&amp;tnggallery=$tnggallery\">$text[mediaof] $description ($mediaID)</a>" );
}
elseif( $albumlinkID ) {
	writelog( "<a href=\"$showmedia_url" . "mediaID=$mediaID&amp;albumlinkID=$albumlinkID&amp;tnggallery=$tnggallery\">$text[mediaof] $logdesc ($mediaID)</a>" );
	preparebookmark( "<a href=\"$showmedia_url" . "mediaID=$mediaID&amp;albumlinkID=$albumlinkID&amp;tnggallery=$tnggallery\">$text[mediaof] $description ($mediaID)</a>" );
}
else {
	writelog( "<a href=\"$showmedia_url" . "mediaID=$mediaID&amp;medialinkID=$medialinkID\">$text[mediaof] $logdesc ($mediaID)</a>" );
	preparebookmark( "<a href=\"$showmedia_url" . "mediaID=$mediaID&amp;medialinkID=$medialinkID\">$text[mediaof] $description ($mediaID)</a>" );
}

$flags[tabs] = $tngconfig[tabs];
$flags[scripting] = "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "net.js\"></script>\n";
if(!$tngprint) {
	$flags[scripting] .= "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "slideshow.js\"></script>\n";
	$flags[scripting] .= "<script type=\"text/javascript\">var showmediaxmlfile = '" . getURL("showmediaxml",1) . "';</script>\n";
}
tng_header( $description, $flags );

$usefolder = $imgrow[usecollfolder] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
$size = @GetImageSize( "$rootpath$usefolder/$imgrow[path]", $info );
$adjheight = $size[1] - 1;

if(!$tngconfig[ssdisabled] && !$tngprint && $numitems > 1) {
	$sscontrols = "<span id=\"slidemsg\" class=\"smaller\"><a href=\"#\" onclick=\"return start();\" id=\"slidetoggle\" class=\"lightlink\">$text[slidestart]</a> &nbsp;&nbsp; </span>\n";
	$sscontrols .= "<span id=\"sscontrols\" class=\"fieldname smaller\" style=\"display:none; margin:0px;padding:0px\">$text[slidesecs]\n";
	$sscontrols .= "<a href=\"#\" title=\"$text[minussecs]\" onclick=\"return changeSlideTime(-500)\"><img src='$cms[tngpath]tng_minus.gif' width='9' height='9' hspace='0' vspace='0' border='0' alt='$text[minussecs]' name='minus' /></a>\n";
	$sscontrols .= "<span id=\"sssecs\">$slidetime_display</span>\n";
	$sscontrols .= "<a href=\"#\" title=\"$text[plussecs]\" onclick=\"return changeSlideTime(500)\"><img src='$cms[tngpath]tng_plus.gif' width='9' height='9' hspace='0' vspace='0' border='0' alt='$text[plussecs]' name='plus' /></a>\n";
	$sscontrols .= "</span>";
}
else
	$sscontrols = "&nbsp;";

if( $personID ) {
	if( $linktype == "I" ) {
		$namestr = getName( $row );
		$years = getYears( $row );
		$type = "person";
	}
	elseif( $linktype == "F" ) {
		$namestr = "$text[family]: " . getFamilyName( $row );
		$years = $row[marrdate] && $row[allow_living] ? $text[marrabbr] . " " . displayDate( $row[marrdate] ) : "";
		$type = "family";
	}
	elseif( $linktype == "S" ) {
		$namestr = $row[title];
		$type = "source";
	}
	elseif( $linktype == "R" ) {
		$namestr = $row[reponame];
		$type = "repo";
	}
	else {
		$namestr = $personID;
		$type = "place";
	}
	$mediastr = showSmallPhoto( $personID, $namestr, $row[allow_living], 0 );
	echo tng_DrawHeading( $mediastr, $namestr, $years );
	echo tng_coreicons();

	echo tng_menu( $linktype, $type, $personID, $sscontrols );
}
else {
	if( $albumlinkID ) {
		$mediastr = "<img src=\"$cms[tngpath]tng_album.gif\" width=\"20\" height=\"20\" align=\"left\" alt=\"\" vspace=\"3\" />\n";
		echo tng_DrawHeading( $mediastr, $albumname, $albdesc );
	}
	else {
    	$titlemsg = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
		$icon = $mediatypes_icons[$mediatypeID];
		echo "<p class=\"header\"><img src=\"$cms[tngpath]$icon\" width=\"20\" height=\"20\" style=\"vertical-align:-2px\" />&nbsp;$titlemsg</p><br clear=\"left\"/>\n";
	}
	echo tng_coreicons();
	if(!$tngprint && !$tngconfig[ssdisabled])
		echo "<div class=\"fieldnameback\" style=\"padding: 0.2em 0em 0.2em .7em; border-right: 1px solid #777; border-bottom: 1px solid #777; height:15px; margin-right:5px; margin-bottom:10px;\">\n$sscontrols</div>\n";
	else
		echo "<br />\n";
}

if(!$tngprint && !$tngconfig[ssdisabled]) {
?>
<div id="slideshow" style="width:100%;">
	<div id="loadingdiv"><?php echo $text[loading]; ?></div>
	<div id="div1" class="slide" style="width:100%;">
<?php
}
echo "<p class=\"subhead\"><strong>$description</strong></p>\n";

if(!$tngprint) {
	$pagenav = getMediaNavigation($mediaID,$personID,$albumlinkID,$result);

	if( $page < $totalpages )
		$nextpage = $page + 1;
	else
		$nextpage = 1;
	$nextmediaID = get_media_id( $result, $nextpage - 1 );
	$nextmedialinkID = get_medialink_id( $result, $nextpage - 1 );
	$nextalbumlinkID = get_albumlink_id( $result, $nextpage - 1 );
}
mysql_free_result( $result );

echo "<p class=\"normal\">$pagenav</p>";
if( $notes ) echo "<p class=\"normal\">$notes</p>\n";
else
	echo "<br /><br />";

if( $noneliving || $imgrow[alwayson] ) {
	showMediaSource($imgrow);

	if( $mediatypeID == "headstones" && ($imgrow['status'] || $imgrow['plot']) ) {
		echo "<p class=\"normal\">";
		if($imgrow['status']) {
			$status = $imgrow['status'];
			if($status && $text[$status]) $imgrow['status'] = $text[$status];
			echo "<b>$text[status]:</b> $imgrow[status]";
		}
		if($imgrow['plot']) {
			if($imgrow['status']) echo ", ";
			echo "<b>$text[plot]:</b> $imgrow[plot]";
		}
		echo "</p>";
	}
	else
		echo "<br /><br />\n";

	$medialinktext = getMediaLinkText($mediaID, $ioffset);
	$albumlinktext = getAlbumLinkText($mediaID);
	echo showTable($imgrow,$medialinktext,$albumlinktext);

	//do cemetery name here for headstones
	//do map here for headstones
	if( $mediatypeID == "headstones" && $imgrow[cemeteryID])
		doCemPlusMap($imgrow,$tree);

	if(!$tngprint)
		echo "<p class=\"normal\">$pagenav</p><br/>\n";
}
else {
?>
<table border="1" cellspacing="0" cellpadding="5"><tr><td>
<img src="<?php echo $cms[tngpath]; ?>spacer.gif" alt="" width="<?php echo $size[0]; ?>" height="1" border="0" /><br/>
<img src="<?php echo $cms[tngpath]; ?>spacer.gif" alt="" width="1" height="<?php echo $adjheight; ?>" border="0" align="left" />
<strong><span class="normal"><?php echo $text[living]; ?></span></strong>
</td></tr></table>
<?php
}
if(!$tngprint && !$tngconfig[ssdisabled]) {
?>
	</div>
	<div id="div0" class="slide" style="display:none"></div>
</div>
<?php
	$flags['more'] = "<script type=\"text/javascript\">\nvar timeoutID;\nvar myslides;\nvar resumemsg='$text[slideresume]';\nvar startmsg='$text[slidestart]';\nvar stopmsg='$text[slidestop]';\n";
	$flags['more'] .= $tngconfig[ssrepeat] ? "\nrepeat = true;\n" : "\nrepeat = false;\n";
	$flags['more'] .= "\nfunction start() {myslides = new Slideshow('slideshow', $slidetime_micro, '$mediaID', '$nextmediaID', '$nextmedialinkID', '$nextalbumlinkID');\n";
	$flags['more'] .= "$('slidetoggle').onclick = function() {stopshow();return false;};\n";
	$flags['more'] .= "$('slidetoggle').innerHTML = \"$text[slidestop]\";\n";
	$flags['more'] .= "return false;}\n";
	$flags['more'] .= "\nfunction InitSlideShowHeight() { $('slideshow').style.height = $('div1').offsetHeight+'px';};\n\n";
	$flags['more'] .= "window.onload = InitSlideShowHeight;\n";
	$flags['more'] .= "InitSlideShowHeight();\n";
	$flags['more'] .= "</script>\n";
}
echo "<br/><br/>\n";

tng_footer( $flags );
?>