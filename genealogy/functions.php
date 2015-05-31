<?php
function get_media_id( $result, $offset ){
    if( !mysql_data_seek($result, $offset ) )
		return(0);
	$row = mysql_fetch_assoc( $result );

	return $row[mediaID];
}

function get_medialink_id( $result, $offset ){
    if( !mysql_data_seek($result, $offset ) )
		return(0);
	$row = mysql_fetch_assoc( $result );

	return $row[medialinkID];
}

function get_albumlink_id( $result, $offset ){
    if( !mysql_data_seek($result, $offset ) )
		return(0);
	$row = mysql_fetch_assoc( $result );

	return $row[albumlinkID];
}

function get_media_offsets( $result, $mediaID ) {
	mysql_data_seek ($result, 0);
	$found = 0;
	for( $i = 0; $i < mysql_num_rows($result); $i++ ) {
    	$row = mysql_fetch_assoc( $result );
        if( $row[mediaID] == $mediaID ) {
			$found = 1;
        	break;
        }
    }
	if(!$found && $i) $i--;
	$nexttolast = mysql_num_rows( $result ) - 1;
	$prev = $i ? $i - 1 : $nexttolast;
	$next = $i < $nexttolast ? $i + 1 : 0;
	
    return array( $i, $prev, $next, $nexttolast );
}

function get_showmedia_nav( $result, $address, $perpage, $pagenavpages ) {
	global $page, $totalpages, $text, $all;

	$total = mysql_num_rows($result);

	if( !$page ) $page = 1;
	if( $total <= $perpage )
		return "";

	$totalpages = ceil($total/$perpage);
	if ($page > $totalpages ) $page = $totalpages;
	$allstr = $all ? "&amp;all=1" : "";

	if( $page > 1 ) {
		$prevpage = $page - 1;
		$mediaID = get_media_id( $result, $prevpage - 1 );
		$medialinkID = get_medialink_id( $result, $prevpage - 1 );
		$albumlinkID = get_albumlink_id( $result, $prevpage - 1 );
		$prevlink = " <a href=\"$address&amp;mediaID=$mediaID&amp;medialinkID=$medialinkID&amp;albumlinkID=$albumlinkID$allstr" . "&amp;page=$prevpage\" class=\"snlink\" onclick=\"return jump('$mediaID','$medialinkID','$albumlinkID')\" title=\"$text[text_prev]\">&laquo;" . $text[text_prev] . "</a> ";
	}
	if( $page < $totalpages ) {
		$nextpage = $page + 1;
		$mediaID = get_media_id( $result, $nextpage - 1 );
		$medialinkID = get_medialink_id( $result, $nextpage - 1 );
		$albumlinkID = get_albumlink_id( $result, $nextpage - 1 );
		$nextlink = "<a href=\"$address&amp;mediaID=$mediaID&amp;medialinkID=$medialinkID&amp;albumlinkID=$albumlinkID$allstr" . "&amp;page=$nextpage\" class=\"snlink\" onclick=\"return jumpnext('$mediaID','$medialinkID','$albumlinkID')\" title=\"$text[text_next]\">" . $text[text_next] . "&raquo;</a>";
	}
	while( $curpage++ < $totalpages ) {
		$mediaID = get_media_id( $result, $curpage - 1 );
		$medialinkID = get_medialink_id( $result, $curpage - 1 );
		$albumlinkID = get_albumlink_id( $result, $curpage - 1 );
		if( ( $curpage <= $page-$pagenavpages || $curpage >= $page+$pagenavpages ) && $pagenavpages!=0 ) {
			if( $curpage == 1 ) {
				$mediaID = get_media_id( $result, $curpage - 1 );
				$medialinkID = get_medialink_id( $result, $curpage - 1 );
				$albumlinkID = get_albumlink_id( $result, $curpage - 1 );
				$firstlink = " <a href=\"$address&amp;mediaID=$mediaID&amp;medialinkID=$medialinkID&amp;albumlinkID=$albumlinkID$allstr" . "&amp;page=$curpage\" class=\"snlink\" onclick=\"return jump('$mediaID','$medialinkID','$albumlinkID')\" title=\"$text[firstpage]\">&laquo;1</a> ... ";
			}
		    if( $curpage == $totalpages )
				$lastlink = "... <a href=\"$address&amp;mediaID=$mediaID&amp;medialinkID=$medialinkID&amp;albumlinkID=$albumlinkID$allstr" . "&amp;page=$curpage\" class=\"snlink\" onclick=\"return jump('$mediaID','$medialinkID','$albumlinkID')\" title=\"$text[lastpage]\">$totalpages&raquo;</a>";
		}
		else {
			if ($curpage==$page)
				$pagenav .= " <span class=\"snlink snlinkact\">$curpage</span> ";
			else
				$pagenav .= " <a href=\"$address&amp;mediaID=$mediaID&amp;medialinkID=$medialinkID&amp;albumlinkID=$albumlinkID$allstr" . "&amp;page=$curpage\" class=\"snlink\" onclick=\"return jump('$mediaID','$medialinkID','$albumlinkID')\">$curpage</a> ";
		}
	}
	$pagenav = "<span class=\"normal\">$prevlink $firstlink $pagenav $lastlink $nextlink</span>";

	return $pagenav;
}

function doMedia( $mediatypeID ) {
	global $media_table, $medialinks_table, $change_limit, $cutoffstr, $wherestr, $text, $families_table, $sources_table, $repositories_table, $citations_table, $nonames;
	global $people_table, $familygroup_url, $showsource_url, $showrepo_url, $placesearch_url, $showmedia_url, $trees_table, $allow_living_db, $assignedtree;
	global $rootpath, $photopath, $documentpath, $headstonepath, $historypath, $mediapath, $header, $footer, $cemeteries_table, $mediatypes_assoc, $mediatypes_display;
	global $getperson_url, $livedefault, $whatsnew, $wherestr2, $showmap_url, $thumbmaxw, $events_table, $eventtypes_table, $altstr, $maxnoteprev;

	if( $mediatypeID == "headstones" ) {
		$hsfields = ", $media_table.cemeteryID, cemname, city";
		$hsjoin = "LEFT JOIN $cemeteries_table ON $media_table.cemeteryID = $cemeteries_table.cemeteryID";
	}
	else
		$hsfields = $hsjoin = "";

	$query = "SELECT distinct $media_table.mediaID as mediaID, description $altstr, $media_table.notes, thumbpath, path, form, mediatypeID, $media_table.gedcom as gedcom, alwayson, usecollfolder, DATE_FORMAT(changedate,'%d %b %Y') as changedatef, status, plot, abspath, newwindow $hsfields
		FROM $media_table $hsjoin";
	if( $wherestr )
		$query .= " LEFT JOIN $medialinks_table on $media_table.mediaID = $medialinks_table.mediaID";
	$query .= " WHERE $cutoffstr $wherestr AND mediatypeID = \"$mediatypeID\" ORDER BY ";
	if(strpos($_SERVER['SCRIPT_NAME'],"placesearch") !== FALSE)
		$query .= "ordernum";
	else
		$query .= "changedate DESC, description";
	$query .= " LIMIT $change_limit";
	$mediaresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

	$titlemsg = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
	$mediaheader = "<br /><span class=\"subhead\"><b>$titlemsg</b></span><br />\n" . $header;

	$mediatext = "";
	$thumbcount = 0;

	while( $row = mysql_fetch_assoc( $mediaresult ) ) {
		$mediatypeID = $row['mediatypeID'];
		$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;

		$status = $row['status'];
		if($status && $text[$status]) $row['status'] = $text[$status];

		$query = "SELECT medialinkID, $medialinks_table.personID as personID, $medialinks_table.eventID, people.personID as personID2, familyID, people.living as living, people.branch as branch,
			$families_table.branch as fbranch, $families_table.living as fliving, husband, wife, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname,
			people.prefix as prefix, people.suffix as suffix, nameorder, $medialinks_table.gedcom as gedcom, treename, $sources_table.title, $sources_table.sourceID, $repositories_table.repoID,reponame, deathdate, burialdate, linktype
			FROM ($medialinks_table, $trees_table)
			LEFT JOIN $people_table AS people ON ($medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom)
			LEFT JOIN $families_table ON ($medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom)
			LEFT JOIN $sources_table ON ($medialinks_table.personID = $sources_table.sourceID AND $medialinks_table.gedcom = $sources_table.gedcom)
			LEFT JOIN $repositories_table ON ($medialinks_table.personID = $repositories_table.repoID AND $medialinks_table.gedcom = $repositories_table.gedcom)
			WHERE mediaID = \"$row[mediaID]\" AND $medialinks_table.gedcom = $trees_table.gedcom$wherestr2 ORDER BY lastname, lnprefix, firstname, $medialinks_table.personID";
		$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$noneliving = 1;
		$medialinktext = "";
		while( $prow = mysql_fetch_assoc( $presult ) ) {
			if( $prow[fbranch] != NULL ) $prow[branch] = $prow[fbranch];
			if( $prow[fliving] != NULL ) $prow[living] = $prow[fliving];
			if( $prow[living] == NULL && $prow[linktype] == 'I') {
				$query = "SELECT count(personID) as ccount FROM $citations_table, $people_table
					WHERE $citations_table.sourceID = '$prow[personID]' AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
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
			elseif( $prow[familyID] != NULL ) {
				$medialinktext .= "<li><a href=\"$familygroup_url" . "familyID=$prow[familyID]&amp;tree=$prow[gedcom]\">$text[family]: " . getFamilyName( $prow );
			}
			elseif( $prow[sourceID] != NULL ) {
				$sourcetext = $prow[title] ? "$text[source]: $prow[title]" : "$text[source]: $prow[sourceID]";
				$medialinktext .= "<li><a href=\"$showsource_url" . "sourceID=$prow[sourceID]&amp;tree=$prow[gedcom]\">$sourcetext";
			}
			elseif( $prow[repoID] != NULL ) {
				$repotext = $prow[reponame] ? "$text[repository]: $prow[reponame]" : "$text[repository]: $prow[repoID]";
				$medialinktext .= "<li><a href=\"$showrepo_url" . "repoID=$prow[repoID]&amp;tree=$prow[gedcom]\">$repotext";
			}
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
		mysql_free_result( $presult );
		if($medialinktext) $medialinktext = "<ul>$medialinktext</ul>\n";

		$href = getMediaHREF($row,0);
		//$href = $showmedia_url . "mediaID=$row[mediaID]";
		if( $noneliving || !$nonames || $row[alwayson] ) {
			$description = $wherestr && $row[altdescription] ? $row[altdescription] : $row[description];
			$notes = $wherestr && $row[altnotes] ? $row[altnotes] : $row[notes];
			$description = $noneliving || $row[alwayson] ? "<a href=\"$href\">$description</a>" : $description;
			$notes = nl2br( truncateIt(getXrefNotes($row[notes],$row[gedcom]),$maxnoteprev) );
			if( !$noneliving && !$row[alwayson] ) $notes .= "<br />($text[livingphoto])";
		}
		else {
			$description = $text[living];
			$notes = "($text[livingphoto])";
		}
		//if( $row[status] ) $notes = "$text[status]: $row[status]. $notes";

		$mediatext .= "<tr>";
		$row[mediatypeID] = $mediatypeID;
		$imgsrc = ( $noneliving || $row[alwayson] ) ? getSmallPhoto($row) : "";
		if($imgsrc) {
			$mediatext .= "<td valign=\"top\" class=\"databack\" align=\"center\" style=\"width:$thumbmaxw" . "px\">";
			$mediatext .= "<div class=\"media-img\"><div class=\"media-prev\" id=\"prev$row[mediaID]\" style=\"display:none\"></div></div>\n";
			$mediatext .= "<a href=\"$href\"";
			if( function_exists( imageJpeg ) && isPhoto($row))
				$mediatext .= " onmouseover=\"showPreview('$row[mediaID]','" . urlencode("$usefolder/$row[path]") . "');\" onmouseout=\"closePreview('$row[mediaID]');\" onclick=\"closePreview('$row[mediaID]');\"";
			$mediatext .= ">$imgsrc</a></td><td valign=\"top\" class=\"databack\">";
			$thumbcount++;
		}
		else
			$mediatext .= "<td valign=\"top\" class=\"databack\" align=\"center\">&nbsp;</td><td valign=\"top\" class=\"databack\">";

		$mediatext .= "<span class=\"normal\">$description<br />$notes&nbsp;</span></td>";
		if($mediatypeID == "headstones") {
			if(!$row['cemname']) $row['cemname'] = $row['city'];
			$mediatext .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\"><a href=\"$showmap_url" . "cemeteryID=$row[cemeteryID]\">$row[cemname]</a>";
			if($row['plot']) $mediatext .= "<br />";
			$mediatext .= "$row[plot]&nbsp;</span></td>";
			$mediatext .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$row[status]&nbsp;</span></td>";
			$mediatext .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\">\n";
		}
		else
			$mediatext .= "<td valign=\"top\" class=\"databack\" width=\"175\"><span class=\"normal\">\n";
		$mediatext .= $medialinktext;
		$mediatext .= "&nbsp;</span></td>\n";
		if( $whatsnew )
			$mediatext .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\">" . displayDate( $row[changedatef] ) . "&nbsp;</span></td></tr>\n";
		//ereg if no thumbs
	}
	if( !$thumbcount ) {
		$mediaheader = ereg_replace( "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[thumb]</strong>&nbsp;</span></td>", "", $mediaheader );
		$mediatext = ereg_replace( "<td valign=\"top\" class=\"databack\" align=\"center\">&nbsp;</td><td valign=\"top\" class=\"databack\">", "<td valign=\"top\" class=\"databack\">", $mediatext );
	}
	mysql_free_result($mediaresult);
	$media = $mediatext ? $mediaheader . $mediatext . $footer : "";

	return $media;
}
?>