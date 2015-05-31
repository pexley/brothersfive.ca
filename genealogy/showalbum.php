<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "showphoto";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "functions.php");
include($cms['tngpath'] . "log.php" );

require_once("albumlib.php");

$showalbum_url = getURL( "showalbum", 1 );
$getperson_url = getURL( "getperson", 1 );
$showmedia_url = getURL( "showmedia", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showsource_url = getURL( "showsource", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$showalbum_url = getURL("showalbum",1);
if(!$thumbmaxw) $thumbmaxw = 80;

if( $tnggallery ) {
	if( !$tngconfig[thumbcols] ) $tngconfig[thumbcols] = 10;
	$maxsearchresults *= 2;
	$wherestr .= " AND thumbpath != \"\"";
	$gallerymsg = "<a href=\"$showalbum_url" . "albumID=$albumID\">&raquo; $text[regphotos]</a>";
}
else
	$gallerymsg = "&raquo; <a href=\"$showalbum_url" . "albumID=$albumID&amp;tnggallery=1\">$text[gallery]</a>";

$_SESSION[tng_gallery] = $tnggallery;

$max_browsemedia_pages = 5;
if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

$query = "SELECT albumname, description FROM $albums_table WHERE albumID = \"$albumID\"";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$albumname = $row[albumname];
$description = $row[description];
mysql_free_result( $result );

if( $tree ) {
	$wherestr = " AND ($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\")";
	$wherestr2 = " AND $medialinks_table.gedcom = \"$tree\"";
}
else
	$wherestr = $wherestr2 = "";

$query = "SELECT DISTINCT $media_table.mediaID, albumlinkID, $media_table.description, $media_table.notes, thumbpath, alwayson, usecollfolder, mediatypeID, path, form, abspath, newwindow
	FROM ($albumlinks_table, $media_table) LEFT JOIN $medialinks_table
	ON $media_table.mediaID = $medialinks_table.mediaID
	WHERE albumID = \"$albumID\" AND $albumlinks_table.mediaID = $media_table.mediaID $wherestr
	ORDER BY $albumlinks_table.ordernum, description LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numrows = mysql_num_rows( $result );

if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(distinct $media_table.mediaID) as mcount FROM ($albumlinks_table, $media_table) LEFT JOIN $medialinks_table
		ON $media_table.mediaID = $medialinks_table.mediaID WHERE albumID = \"$albumID\" AND $albumlinks_table.mediaID = $media_table.mediaID $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	mysql_free_result($result2);
	$totrows = $row[mcount];
}
else
	$totrows = $numrows;

$numrowsplus = $numrows + $offset;

$logstring = "<a href=\"$showalbum_url" . "albumID=$albumID\">$albumname</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( "$text[albums]: $albumname", $flags );

$imgsrc = getAlbumPhoto($albumID,$albumname);
if(!$imgsrc) {
?>
<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_album.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $albumname; ?><br /><span class="normal">&nbsp;&nbsp;&nbsp;<?php echo $description; ?></span></p><br clear="left"/>
<?php
}
else {
	echo tng_DrawHeading( $imgsrc, $albumname, $description );
}

echo tng_coreicons();

if( $totrows )
	echo "<p class=\"normal\">$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows &nbsp;&nbsp;&nbsp; $gallerymsg &nbsp;&nbsp;&nbsp; ";

echo $allow_admin && $allow_edit ? "&raquo; <a href=\"$cms[tngpath]" . "admin/editalbum.php?albumID=$albumID&amp;cw=1\" target=\"_blank\">$text[editalbum]</a> &nbsp;&nbsp;&nbsp;" : "";
$pagenav = get_browseitems_nav( $totrows, $showalbum_url . "albumID=$albumID&amp;tnggallery=$tnggallery&amp;offset", $maxsearchresults, $max_browsemedia_pages );
echo $pagenav;
echo "</p>\n";
?>
<table cellpadding="3" cellspacing="1" border="0">
<?php
if( $tnggallery ) {
	$firstrow = 1;
}
else {
	$header .= "<tr><td class=\"fieldnameback\">&nbsp;</td>\n";
	$header .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[thumb]</strong>&nbsp;</span></td>\n";
	$header .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[description]</strong>&nbsp;</span></td>\n";
	$header .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[indlinked]</strong>&nbsp;</span></td>\n";
	$header .= "</tr>\n";
}

$i = $offsetplus;
$maxplus = $maxsearchresults + 1;
$mediatext = "";
$thumbcount = 0;
while( $row = mysql_fetch_assoc( $result ) ) {
	$mediatypeID = $row['mediatypeID'];
	$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
	$query = "SELECT $medialinks_table.mediaID, $medialinks_table.personID as personID, people.personID as personID2, people.living as living, people.branch as branch, $families_table.branch as fbranch,
		$families_table.living as fliving, familyID, husband, wife, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.prefix as prefix, people.suffix as suffix, nameorder,
		$medialinks_table.gedcom, $sources_table.title, $sources_table.sourceID, $repositories_table.repoID, reponame, deathdate, burialdate, linktype
		FROM $medialinks_table
		LEFT JOIN $people_table AS people ON $medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom
		LEFT JOIN $families_table ON $medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom
		LEFT JOIN $sources_table ON $medialinks_table.personID = $sources_table.sourceID AND $medialinks_table.gedcom = $sources_table.gedcom
		LEFT JOIN $repositories_table ON ($medialinks_table.personID = $repositories_table.repoID AND $medialinks_table.gedcom = $repositories_table.gedcom)
		WHERE mediaID = \"$row[mediaID]\" $wherestr2 ORDER BY lastname, lnprefix, firstname, personID LIMIT $maxplus";
	$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$numrows = mysql_num_rows( $presult );
	$medialinktext = "";
	$noneliving = 1;
	$count = 0;
	while( $prow = mysql_fetch_assoc( $presult ) )
	{
		if( $prow[fbranch] != NULL ) $prow[branch] = $prow[fbranch];
		if( $prow[fliving] != NULL ) $prow[living] = $prow[fliving];
		//if living still null, must be a source
		if( $prow[living] == NULL && $prow[linktype] == "I" ) {
			$query = "SELECT count(personID) as ccount FROM $citations_table, $people_table
				WHERE $citations_table.sourceID = '$prow[personID]' AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
				AND living = '1'";
			$presult2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$prow2 = mysql_fetch_assoc( $presult2 );
			if( $prow2[ccount] ) $prow[living] = 1;
			mysql_free_result( $presult2 );
		}
		if( $prow[living] == NULL && $prow[linktype] == "F" ) {
			$query = "SELECT count(familyID) as ccount FROM $citations_table, $families_table
				WHERE $citations_table.sourceID = '$prow[personID]' AND $citations_table.persfamID = $families_table.familyID AND $citations_table.gedcom = $families_table.gedcom
				AND living = '1'";
			$presult2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$prow2 = mysql_fetch_assoc( $presult2 );
			if( $prow2[ccount] ) $prow[living] = 1;
			mysql_free_result( $presult2 );
		}
		if( !$prow[living] || $livedefault == 2 || ( !$livedefault && $allow_living_db && ( !$assignedtree || $assignedtree == $prow[gedcom] ) && checkbranch( $prow[branch] ) ) )
			$prow[allow_living] = 1;
		else {
			$noneliving = 0;
			$prow[allow_living] = 0;
		}
		if( !$tnggallery ) {
			$hstext = "";
			if( $prow[personID2] != NULL ) {
				$medialinktext .= "<li><a href=\"$getperson_url" . "personID=$prow[personID2]&amp;tree=$prow[gedcom]\">";
				$medialinktext .= getName( $prow );
				if( $mediatypeID == "headstones" ) {
					$deathdate = $prow[deathdate] ? $prow[deathdate] : $prow[burialdate];
					if( $prow[deathdate] ) $abbrev = $text[deathabbr];
					elseif( $prow[burialdate] ) $abbrev = $text[burialabbr];
					$hstext = $deathdate ? " ($abbrev " . displayDate( $deathdate ) . ")" : "";
				}
			}
			elseif( $prow[sourceID] != NULL ) {
				$sourcetext = $prow[title] ? $prow[title] : "$text[source]: $prow[sourceID]";
				$medialinktext .= "<li><a href=\"$showsource_url" . "sourceID=$prow[sourceID]&amp;tree=$prow[gedcom]\">$sourcetext";
			}
			elseif( $prow[repoID] != NULL ) {
				$repotext = $prow[reponame] ? $prow[reponame] : "$text[repository]: $prow[repoID]";
				$medialinktext .= "<li><a href=\"$showrepo_url" . "repoID=$prow[repoID]&amp;tree=$prow[gedcom]\">$repotext";
			}
			elseif( $prow[familyID] != NULL )
				$medialinktext .= "<li><a href=\"$familygroup_url" . "familyID=$prow[personID]&amp;tree=$prow[gedcom]\">$text[family]: " . getFamilyName( $prow );
			else
				$medialinktext .= "<li><a href=\"$placesearch_url" . "psearch=$prow[personID]&amp;tree=$prow[gedcom]\">$prow[personID]";
			$medialinktext .= "</a>$hstext\n</li>\n";
		}
		$count++;
	}
	mysql_free_result( $presult );
	if($medialinktext) $medialinktext = "<ul>$medialinktext</ul>\n";

	if( $numrows == $maxplus )
		$medialinktext .= "\n[<a href=\"$showmedia_url" . "mediaID=$row[mediaID]&amp;albumID=$albumID&amp;ioffset=$maxsearchresults\">$text[morelinks]</a>]";

	$href = getMediaHREF($row,2);
	//$href = $showmedia_url . "mediaID=$row[mediaID]&amp;albumlinkID=$row[albumlinkID]";
	if( $noneliving || !$nonames || $row[alwayson] ) {
		$description = $noneliving || $row[alwayson] ? "<a href=\"$href\">$row[description]</a>" : $row[description];
		$notes = nl2br( truncateIt(getXrefNotes($row[notes]),$maxnoteprev) );
		if( !$noneliving && !$row[alwayson] ) $notes .= "<br />($text[livingphoto])";
	}
	else
		$description = $notes = $text[living];
	if( $row[status] ) $notes = "$text[status]: $row[status]. $notes";

	if( $noneliving || $row[alwayson] ) {
		$imgsrc = getSmallPhoto($row);
	}
	else
		$imgsrc = "";

	if( $tnggallery ) {
		if( $imgsrc ) {
			if( $firstrow ) {
				$firstrow = 0;
				$mediatext .= "<tr>";
			}
			else if( ($i - 1 ) % $tngconfig[thumbcols] == 0 ) {
				$mediatext .= "</tr>\n<tr>";
			}
			$mediatext .= "<td valign=\"top\" style=\"padding:10px\" align=\"center\"><a href=\"$href\">$imgsrc</a></td>\n";
			$i++;
		}
	}
	else {
		$mediatext .= "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$i</span></td>";
		if($imgsrc) {
			$mediatext .= "<td valign=\"top\" class=\"databack\" align=\"center\">";
			$mediatext .= "<div class=\"media-img\"><div class=\"media-prev\" id=\"prev$row[mediaID]\" style=\"display:none\"></div></div>\n";
			$mediatext .= "<a href=\"$href\"";
			if( function_exists( imageJpeg ) && isPhoto($row) )
				$mediatext .= " onmouseover=\"showPreview('$row[mediaID]','" . urlencode("$usefolder/$row[path]") . "');\" onmouseout=\"closePreview('$row[mediaID]');\" onclick=\"closePreview('$row[mediaID]');\"";
			$mediatext .= ">$imgsrc</a></td><td valign=\"top\" class=\"databack\">";
			$thumbcount++;
		}
		else
			$mediatext .= "<td valign=\"top\" class=\"databack\" align=\"center\">&nbsp;</td><td valign=\"top\" class=\"databack\">";

		$mediatext .= "<span class=\"normal\">$description<br/>$notes&nbsp;</span></td>";
		$mediatext .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\">\n";
		$mediatext .= $medialinktext;
		$mediatext .= "&nbsp;</span></td></tr>\n";
		$i++;
	}
}
mysql_free_result($result);
if( $tnggallery ) {
	if( !$firstrow ) $mediatext .= "</tr>\n";
}
else {
	if( !$thumbcount ) {
		$header = ereg_replace( "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[thumb]</strong>&nbsp;</span></td>", "", $header );
		$mediatext = ereg_replace( "<td valign=\"top\" class=\"databack\" align=\"center\">&nbsp;</td><td valign=\"top\" class=\"databack\">", "<td valign=\"top\" class=\"databack\">", $mediatext );
	}
	$mediatext = $header . $mediatext;
}

//print out the whole shootin' match right here, eh
echo $mediatext;
?>
</table><br/>
<?php
if( $pagenav ) {
	echo $pagenav;
	echo "<br />";
}
tng_footer( "" );
?>