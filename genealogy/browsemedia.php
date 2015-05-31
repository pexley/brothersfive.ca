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

$browsemedia_url = getURL( "browsemedia", 1 );
$getperson_url = getURL( "getperson", 1 );
$showmedia_url = getURL( "showmedia", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showsource_url = getURL( "showsource", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$showmap_url = getURL( "showmap", 1 );

$orgmediatypeID = $mediatypeID;
initMediaTypes();

if( $orgmediatypeID ) {
	$wherestr = "WHERE mediatypeID = \"$mediatypeID\"";
	$titlestr = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
	if( $orgmediatypeID == "headstones" ) {
		$hsfields = ", $media_table.cemeteryID, cemname, city";
		$hsjoin = "LEFT JOIN $cemeteries_table ON $media_table.cemeteryID = $cemeteries_table.cemeteryID";
	}
	else
		$hsfields = $hsjoin = "";
}
else {
	$wherestr = "WHERE 1 = 1";
	$titlestr = $text['allmedia'];
}

if( $tnggallery ) {
	if( !$tngconfig[thumbcols] ) $tngconfig[thumbcols] = 10;
	$maxsearchresults *= 2;
	$wherestr .= " AND thumbpath != \"\"";
	$gallerymsg = "<a href=\"$browsemedia_url" . "tree=$tree&amp;mediatypeID=$orgmediatypeID&amp;mediasearch=$mediasearch\">$text[regphotos]</a>";
}
else 
	$gallerymsg = "<a href=\"$browsemedia_url" . "tnggallery=1&amp;tree=$tree&amp;mediatypeID=$orgmediatypeID&amp;mediasearch=$mediasearch\">$text[gallery]</a>";

$_SESSION[tng_mediasearch] = $mediasearch;
$_SESSION[tng_gallery] = $tnggallery;
$_SESSION[tng_mediatree] = $tree;

function doMediaSearch( $instance, $pagenav ) {
	global $text, $mediasearch, $orgmediatypeID, $browsemedia_url, $tree, $tnggallery;

	$str = getFORM( "browsemedia", "get", "MediaSearch$instance", "" );
	$str .= "<input type=\"text\" name=\"mediasearch\" value=\"$mediasearch\" /> <input type=\"submit\" value=\"$text[search]\" /> <input type=\"button\" value=\"$text[tng_reset]\" onclick=\"window.location.href='$browsemedia_url" . "mediatypeID=$orgmediatypeID&amp;tree=$tree&amp;tnggallery=$tnggallery';\" />&nbsp;&nbsp;&nbsp;";
	$str .= "<input type=\"hidden\" name=\"mediatypeID\" value=\"$orgmediatypeID\" />\n";
	$str .= $pagenav;
	$str .= "<input type=\"hidden\" name=\"tree\" value=\"$tree\" />\n";
	$str .= "<input type=\"hidden\" name=\"tnggallery\" value=\"$tnggallery\" />\n";
	$str .= "</form>\n";

	return $str;
}

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

if( $tree ) {
	$wherestr .= " AND ($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\")";
	$wherestr2 = " AND $medialinks_table.gedcom = \"$tree\"";
}
else
	$wherestr2 = "";

if( $mediasearch )
	$wherestr .= " AND ($media_table.description LIKE \"%$mediasearch%\" OR $media_table.notes LIKE \"%$mediasearch%\")";

$query = "SELECT DISTINCT $media_table.mediaID, $media_table.description, $media_table.notes, path, thumbpath, alwayson, usecollfolder, form, mediatypeID, status, plot, newwindow, abspath, $media_table.gedcom $hsfields FROM $media_table";
$query .= " $hsjoin $wherestr ORDER BY description LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numrows = mysql_num_rows( $result );

if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	if( $tree ) {
		$query = "SELECT count(DISTINCT $media_table.mediaID) as mcount FROM $media_table";
		$query .= " $hsjoin $wherestr";
	}
	else
		$query = "SELECT count($media_table.mediaID) as mcount FROM $media_table $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	mysql_free_result($result2);
	$totrows = $row[mcount];
}
else
	$totrows = $numrows;

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " $text[tree]: $tree" : "";
$treestr = trim("$mediasearch $treestr");
$treestr = $treestr ? " ($treestr)" : "";
$logstring = "<a href=\"$browsemedia_url" . "tree=$tree&amp;offset=$offset&amp;mediasearch=$mediasearch&amp;mediatypeID=$mediatypeID\">$titlestr$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( $titlestr, $flags );
$icon = $orgmediatypeID ? $mediatypes_icons[$mediatypeID] : "tng_media.gif";
?>

<p class="header"><img src="<?php echo "$cms[tngpath]$icon"; ?>" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $titlestr; ?><br clear="all" /></p>
<?php
echo tng_coreicons();

$hiddenfields[0] = array('name' => 'mediatypeID', 'value' => $orgmediatypeID);
$hiddenfields[1] = array('name' => 'tnggallery', 'value' => $tnggallery);
echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'browsemedia', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields));

echo "<p class=\"normal\">";
if( $totrows )
	echo "$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows &nbsp;&nbsp;&nbsp; ";
echo "$gallerymsg</p>";

$pagenav = get_browseitems_nav( $totrows, $browsemedia_url . "mediasearch=$mediasearch&amp;tnggallery=$tnggallery&amp;mediatypeID=$orgmediatypeID&amp;offset", $maxsearchresults, $max_browsemedia_pages );
echo doMediaSearch( 1, $pagenav );
echo "<br />\n";
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
	if( $mediatypeID == "headstones" ) {
		$header .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[cemetery]</strong>&nbsp;</span></td>\n";
		$header .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[status]</strong>&nbsp;</span></td>\n";
	}
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

	$status = $row['status'];
	if($status && $text[$status]) $row['status'] = $text[$status];

	$query = "SELECT $medialinks_table.mediaID, $medialinks_table.personID as personID, people.personID as personID2, people.living as living, people.branch as branch, $medialinks_table.eventID, $families_table.branch as fbranch,
		$families_table.living as fliving, familyID, husband, wife, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.prefix as prefix, people.suffix as suffix, nameorder,
		$medialinks_table.gedcom, $sources_table.title, $sources_table.sourceID, $repositories_table.repoID, reponame, deathdate, burialdate, linktype
		FROM $medialinks_table
		LEFT JOIN $people_table AS people ON $medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom
		LEFT JOIN $families_table ON $medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom
		LEFT JOIN $sources_table ON $medialinks_table.personID = $sources_table.sourceID AND $medialinks_table.gedcom = $sources_table.gedcom
		LEFT JOIN $repositories_table ON ($medialinks_table.personID = $repositories_table.repoID AND $medialinks_table.gedcom = $repositories_table.gedcom)
		WHERE mediaID = \"$row[mediaID]\"$wherestr2 ORDER BY lastname, lnprefix, firstname, personID LIMIT $maxplus";
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
		if( $prow[living] == NULL && $prow[linktype] == 'I') {
			$query = "SELECT count(personID) as ccount FROM $citations_table, $people_table
				WHERE $citations_table.sourceID = '$prow[personID]' AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
				AND living = '1'";
			$presult2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$prow2 = mysql_fetch_assoc( $presult2 );
			if( $prow2[ccount] ) $prow[living] = 1;
			mysql_free_result( $presult2 );
		}
		if( $prow[living] == NULL && $prow[linktype] == 'F') {
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
				if( $orgmediatypeID == "headstones" ) {
					$deathdate = $prow[deathdate] ? $prow[deathdate] : $prow[burialdate];
					if( $prow[deathdate] ) $abbrev = $text[deathabbr];
					elseif( $prow[burialdate] ) $abbrev = $text[burialabbr];
					$hstext = $deathdate ? " ($abbrev " . displayDate( $deathdate ) . ")" : "";
				}
			}
			elseif( $prow[sourceID] != NULL ) {
				$sourcetext = $prow[title] ? "$text[source]: $prow[title]" : "$text[source]: $prow[sourceID]";
				$medialinktext .= "<li><a href=\"$showsource_url" . "sourceID=$prow[personID]&amp;tree=$prow[gedcom]\">$sourcetext\n";
			}
			elseif( $prow[repoID] != NULL ) {
				$repotext = $prow[reponame] ? "$text[repository]: $prow[reponame]" : "$text[repository]: $prow[repoID]";
				$medialinktext .= "<li><a href=\"$showrepo_url" . "repoID=$prow[personID]&amp;tree=$prow[gedcom]\">$repotext";
			}
			elseif( $prow[familyID] != NULL )
				$medialinktext .= "<li><a href=\"$familygroup_url" . "familyID=$prow[personID]&amp;tree=$prow[gedcom]\">$text[family]: " . getFamilyName( $prow );
			else
				$medialinktext .= "<li><a href=\"$placesearch_url" . "psearch=$prow[personID]&amp;tree=$prow[gedcom]\">$prow[personID]";
			if($prow[eventID]) {
				$query = "SELECT description from $events_table, $eventtypes_table WHERE eventID = \"$prow[eventID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID";
				$eresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				$erow = mysql_fetch_assoc($eresult);
				$event = $erow[description] ? $erow[description] : $prow[eventID];
				mysql_free_result($eresult);
				$medialinktext .= " ($event)";
			}
			$medialinktext .= "</a>$hstext\n</li>\n";
		}
		$count++;
	}
	//if extension is in "showdirect" then link = folder (depends on usecollfolder) + / + path
	//else showmedia
	mysql_free_result( $presult );
	if($medialinktext) $medialinktext = "<ul>$medialinktext</ul>\n";

	$row['all'] = $orgmediatypeID ? 0 : 1;
	$uselink = getMediaHREF($row,0);

	if( $numrows == $maxplus )
		$medialinktext .= "\n[<a href=\"$showmedia_url" . "mediaID=$row[mediaID]&amp;ioffset=$maxsearchresults\">$text[morelinks]</a>]";

	if( $noneliving || $row['alwayson'] ) {
		$imgsrc = getSmallPhoto($row);
		$href = $uselink;
	}
	elseif( $tnggallery ) {
		$imgsrc = "<img src=\"$cms[tngpath]" . "spacer.gif\" alt=\"$text[livingphoto]\" width=\"40\" height=\"50\" border=\"1\" />";
		$href = "";
	}
	else {
		$imgsrc = "";
		$href = $uselink;
	}

	if( $noneliving || !$nonames || $row[alwayson] ) {
		$description = $noneliving || $row[alwayson] ? "<a href=\"$href\">$row[description]</a>" : $row[description];
		$notes = nl2br( truncateIt(getXrefNotes($row[notes],$row[gedcom]),$maxnoteprev) );
		if( !$noneliving && !$row[alwayson] ) $notes .= "<br />($text[livingphoto])";
	}
	else {
		$description = $text[living];
		$notes = "($text[livingphoto])";
	}
	if( $row[status] && ($orgmediatypeID != "headstones") ) $notes = "$text[status]: $row[status]. $notes";

	if( $tnggallery ) {
		if( $imgsrc ) {
			if( $firstrow ) {
				$firstrow = 0;
				$mediatext .= "<tr>";
			}
			else if( ($i - 1 ) % $tngconfig[thumbcols] == 0 ) {
				$mediatext .= "</tr>\n<tr>";
			}
			$mediatext .= "<td valign=\"top\" style=\"padding:10px\" align=\"center\">";
			$mediatext .= $href ? "<a href=\"$href\">$imgsrc</a></td>\n" : "$imgsrc</td>\n";
			$i++;
		}
	}
	else {
		$mediatext .= "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$i</span></td>";
		if($imgsrc) {
			$mediatext .= "<td valign=\"top\" class=\"databack\" align=\"center\">";
			$mediatext .= "<div class=\"media-img\" id=\"mi$row[mediaID]\"><div class=\"media-prev\" id=\"prev$row[mediaID]\" style=\"display:none\"></div></div>\n";
			$mediatext .= "<a href=\"$href\"";
			if( function_exists( imageJpeg ) && isPhoto($row))
				$mediatext .= " onmouseover=\"showPreview('$row[mediaID]','" . urlencode("$usefolder/$row[path]") . "');\" onmouseout=\"closePreview('$row[mediaID]');\" onclick=\"closePreview('$row[mediaID]');\"";
			$mediatext .= ">$imgsrc</a></td><td valign=\"top\" class=\"databack\">";
			$thumbcount++;
		}
		else
			$mediatext .= "<td valign=\"top\" class=\"databack\" align=\"center\">&nbsp;</td><td valign=\"top\" class=\"databack\">";

		$mediatext .= "<span class=\"normal\">$description<br/>$notes&nbsp;</span></td>";
		if($orgmediatypeID == "headstones") {
			if(!$row['cemname']) $row['cemname'] = $row['city'];
			$plotstr = $row['plot'] ? "<br />" . $row['plot'] : "";
			$mediatext .= "<td valign=\"top\" class=\"databack\" style=\"white-space:nowrap\"><span class=\"normal\"><a href=\"$showmap_url" . "cemeteryID=$row[cemeteryID]\">$row[cemname]</a>$plotstr&nbsp;</span></td>";
			$mediatext .= "<td valign=\"top\" class=\"databack\" style=\"white-space:nowrap\"><span class=\"normal\">$row[status]&nbsp;</span></td>";
			$mediatext .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\">\n";
		}
		else
			$mediatext .= "<td valign=\"top\" class=\"databack\" width=\"175\"><span class=\"normal\">\n";
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
if( $pagenav || $mediasearch ) {
	echo doMediaSearch( 2, $pagenav );
	echo "<br />";
}
tng_footer( "" );
?>
