<?php
function display_size( $file_size ) {
	if( $file_size >= 1073741824 )
		$file_size = round( $file_size / 1073741824 * 100 ) / 100 ."g";
    elseif( $file_size >= 1048576 )
		$file_size = round( $file_size / 1048576 * 100 ) / 100 ."m";
    elseif( $file_size >= 1024 )
		$file_size = round( $file_size / 1024 * 100) / 100 ."k";
    else
		$file_size = $file_size." bytes";

	return $file_size;
} // function display_size()

function output_iptc_data( $info ) {
	global $text;

	$outputtext = "";
	if( is_array( $info ) ) {
		$iptc = iptcparse( $info["APP13"] );
		if( is_array( $iptc ) ) {
			foreach( array_keys( $iptc ) as $key ) {
				$count = count ( $iptc[$key] );
				for ( $i=0; $i <$count; $i++) {
					$newkey = substr( $key, 2 );
					if( $newkey != "000" ) {
						$newkey = "iptc" . $newkey;
						$keytext = $text[$newkey] ? $text[$newkey] : $key;
						$outputtext .= showEvent( array( "text"=>$keytext, "fact"=>$iptc[$key][$i] ) );
					}
				}
			}
		}
	}
	return $outputtext;
}

function getMediaInfo($mediatypeID, $mediaID, $personID, $albumID, $albumlinkID, $eventID) {
	global $wherestr, $requirelogin, $treerestrict, $assignedtree, $tnggallery, $mediasearch, $text, $tree, $all, $showall, $ordernum;
	global $media_table, $medialinks_table, $albumlinks_table;

	$info = array();

	$wherestr3 = $requirelogin && $treerestrict && $assignedtree ? " AND ($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\")" : "";
	if( $albumlinkID ) {
		if( $tnggallery )
			$wherestr = " AND thumbpath != \"\"";
		$query = "SELECT $media_table.mediaID, albumlinkID, ordernum, path, map, description, notes, width, height, datetaken, placetaken, owner, alwayson, abspath, usecollfolder, status, plot, cemeteryID, showmap, bodytext, form, newwindow, usenl, latitude, longitude
			FROM ($albumlinks_table, $media_table)
		 	WHERE albumID = \"$albumID\" AND $albumlinks_table.mediaID = $media_table.mediaID $wherestr $wherestr3
			ORDER BY ordernum, description";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$offsets = get_media_offsets( $result, $mediaID );
		$info['page'] = $offsets[0] + 1;
		mysql_data_seek ( $result, $offsets[0] );

		$imgrow = mysql_fetch_assoc($result);
		$info['mediaID'] = $imgrow[mediaID];
		$info['ordernum'] = $imgrow[ordernum];
		$info['mediadescription'] = $imgrow[description];
		$info['medianotes'] = $imgrow[notes];
	}
	elseif( !$personID ) {
		$mediasearch = $_SESSION[tng_mediasearch];
		$tnggallery = $_SESSION[tng_gallery];
		if( (!$requirelogin || !$treerestrict || !$assignedtree) && $_SESSION[tng_mediatree] )
			$tree = $_SESSION[tng_mediatree];

		if( $all ) {
			$wherestr = "WHERE 1=1";
			$showall = "";
		}
		else {
			$wherestr = "WHERE mediatypeID = '$mediatypeID'";
			$showall = "mediatypeID=$mediatypeID&amp;";
		}
		//if( $tree ) {
			//$wherestr .= " AND $medialinks_table.gedcom = \"$tree\"";
			//$join = "INNER JOIN";
		//}
		//else
			$join = "LEFT JOIN";
		if( $mediasearch )
			$wherestr .= " AND ($media_table.description LIKE \"%$mediasearch%\" OR $media_table.notes LIKE \"%$mediasearch%\")";
		if( $tnggallery )
			$wherestr .= " AND thumbpath != \"\"";

		$query = "SELECT DISTINCT $media_table.mediaID, path, map, description, notes, width, height, datetaken, placetaken, owner, alwayson, abspath, usecollfolder, status, plot, cemeteryID, showmap, bodytext, form, newwindow, usenl, latitude, longitude FROM $media_table";
		$query .= " $wherestr $wherestr3 ORDER BY description";

		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$offsets = get_media_offsets( $result, $mediaID );
		$info['page'] = $offsets[0] + 1;
		mysql_data_seek ( $result, $offsets[0] );

		$imgrow = mysql_fetch_assoc($result);
		$info['mediadescription'] = $imgrow[description];
		$info['medianotes'] = $imgrow[notes];
		$info['mediaID'] = $mediaID;
		$info['ordernum'] = $ordernum;
	}
	else {
		$query = "SELECT medialinkID, path, map, description, notes, altdescription, altnotes, width, height, datetaken, placetaken, owner, ordernum, alwayson, abspath, $media_table.mediaID as mediaID, usecollfolder, status, plot, cemeteryID, showmap, bodytext, form, newwindow, usenl, latitude, longitude
			FROM ($media_table, $medialinks_table)
			WHERE personID = \"$personID\" AND $medialinks_table.gedcom = \"$tree\" AND mediatypeID = \"$mediatypeID\" AND eventID = \"$eventID\" AND $media_table.mediaID = $medialinks_table.mediaID $wherestr3
			ORDER by ordernum";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$offsets = get_media_offsets( $result, $mediaID );
		$info['page'] = $offsets[0] + 1;
		if( $result ) mysql_data_seek ( $result, $offsets[0] );

		$imgrow = mysql_fetch_assoc($result);
		$info['mediaID'] = $imgrow[mediaID];
		$info['ordernum'] = $imgrow[ordernum];
		$info['mediadescription'] = $imgrow[altdescription] ? $imgrow[altdescription] : $imgrow[description];
		$info['medianotes'] = $imgrow[altnotes] ? $imgrow[altnotes] : $imgrow[notes];
	}
	$info['gotmap'] = $imgrow['map'] ? 1 : 0;
	$info['result'] = $result;
	$info['imgrow'] = $imgrow;

	return $info;
}

function findLiving($mediaID, $tree) {
	global $tree, $text, $medialinks_table, $people_table, $families_table, $citations_table, $livedefault, $allow_living_db, $assignedtree;

	$info = array();
	//select all medialinks for this mediaID, joined with people
	//loop through looking for living
	//if any are living, don't show media
	$query = "SELECT $medialinks_table.medialinkID, $medialinks_table.personID as personID, $medialinks_table.gedcom as gedcom, linktype, people.living as living, people.branch as branch, $families_table.branch as fbranch, $families_table.living as fliving
		FROM $medialinks_table
		LEFT JOIN $people_table AS people ON $medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom
		LEFT JOIN $families_table ON $medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom
		WHERE $medialinks_table.mediaID = \"$mediaID\"";
	if($tree) {
		$query .= " AND ($medialinks_table.gedcom = \"$tree\" || $medialinks_table.gedcom = \"\")";
		$wherestr2 = " AND $medialinks_table.gedcom = \"$tree\"";
	}
	else
		$wherestr2 = "";
	$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$noneliving = 1;
	$rightbranch = $livedefault == 2 ? 1 : 0;
	$allrightbranch = 1;
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
		if( $livedefault != 2 ) {
			if( $prow[living] ) {
				if( $livedefault == 1 || !$allow_living_db || ($assignedtree && $assignedtree != $prow[gedcom]) || !checkbranch( $prow[branch] ) )
					$noneliving = 0;
			}
			if( $prow[personID] == $personID && checkbranch( $prow[branch] ) )
				$rightbranch = 1;
			if( !checkbranch( $prow[branch] ) )
				$allrightbranch = 0;
		}
	}
	mysql_free_result( $presult );

	$info['noneliving'] = $noneliving;
	$info['rightbranch'] = $rightbranch;
	$info['allrightbranch'] = $allrightbranch;

	return $info;
}

function getMediaNavigation($mediaID,$personID,$albumlinkID,$result) {
	global $allow_admin, $allow_edit, $allrightbranch, $albumname, $albumID, $offset, $tnggallery;
	global $tree, $page, $maxsearchresults, $linktype, $cms, $showall, $tnggallery, $text;
	global $showalbum_url, $browsemedia_url, $familygroup_url, $showsource_url, $showrepo_url, $placesearch_url, $showmedia_url;

	$mediaperpage = 1;
	$max_showmedia_pages = 5;
	$pagenum = ceil($page/$maxsearchresults);

	if( $allow_admin && $allow_edit && $allrightbranch )
		$pagenav = "&raquo; <a href=\"$cms[tngpath]" . "admin/editmedia.php?mediaID=$mediaID&amp;cw=1\" target=\"_blank\">$text[editmedia]</a> &nbsp;&nbsp;&nbsp;";

	if( $albumlinkID ) {
		$offset = floor( $page / $maxsearchresults ) * $maxsearchresults;
		$pagenav .= "&raquo; <a href=\"$showalbum_url" . "albumID=$albumID&amp;offset=$offset&amp;page=$pagenum&amp;tnggallery=$tnggallery\">$albumname</a>  &nbsp;&nbsp;&nbsp;";
	}
	elseif( !$personID ) {
		$offset = floor( $page / $maxsearchresults ) * $maxsearchresults;
		$pagenav .= "&raquo; <a href=\"$browsemedia_url" . $showall . "offset=$offset&amp;page=$pagenum&amp;tnggallery=$tnggallery\">$text[showall]</a>  &nbsp;&nbsp;&nbsp;";
	}
	else {
		if( $linktype == "F" ) {
			$pagenav .= "&raquo; <a href=\"$familygroup_url" . "familyID=$personID&amp;tree=$tree\">$text[groupsheet]</a>  &nbsp;&nbsp;&nbsp;";
		}
		elseif( $linktype == "S" ) {
			$pagenav .= "&raquo; <a href=\"$showsource_url" . "sourceID=$personID&amp;tree=$tree\">$text[source]</a>  &nbsp;&nbsp;&nbsp;";
		}
		elseif( $linktype == "R" ) {
			$pagenav .= "&raquo; <a href=\"$showrepo_url" . "repoID=$personID&amp;tree=$tree\">$text[repository]</a>  &nbsp;&nbsp;&nbsp;";
		}
		elseif( $linktype == "L" ) {
			$pagenav .= "&raquo; <a href=\"$placesearch_url" . "psearch=$personID&amp;tree=$tree\">$text[place]</a>  &nbsp;&nbsp;&nbsp;";
		}
	}

	$pagenav .= get_showmedia_nav( $result, $showmedia_url, $mediaperpage, $max_showmedia_pages );

	return $pagenav;
}

function getAlbumLinkText($mediaID) {
	global $text, $albums_table, $albumlinks_table, $showalbum_url;

	$albumlinktext = "";
	//get all albumlink records for this mediaID, joined with album tables
	$query = "SELECT $albums_table.albumID, albumname FROM ($albumlinks_table, $albums_table) WHERE mediaID = \"$mediaID\" AND $albumlinks_table.albumID = $albums_table.albumID";
   	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	while( $row = mysql_fetch_assoc( $result ) ) {
		if($albumlinktext) $albumlinktext .= "\n";
		$albumlinktext .= "<a href=\"$showalbum_url" . "albumID=$row[albumID]\">" . $row['albumname'] . "</a>";
	}
	mysql_free_result($result);

	return $albumlinktext;
}

function getMediaLinkText($mediaID, $ioffset) {
	global $text, $medialinks_table, $people_table, $families_table, $sources_table, $repositories_table, $events_table, $eventtypes_table, $wherestr2, $maxsearchresults;
	global $livedefault, $allow_living_db, $assignedtree, $showmedia_url, $showrepo_url, $showsource_url, $getperson_url, $familygroup_url, $placesearch_url;

	if( $ioffset ) {
		$ioffsetstr = "$ioffset, ";
		$newioffset = $ioffset + 1;
	}
	else {
		$ioffsetstr = "";
		$newioffset = "";
	}
	$query = "SELECT $medialinks_table.medialinkID, $medialinks_table.personID as personID, people.living as living, people.branch as branch, $medialinks_table.eventID, $families_table.branch as fbranch, $families_table.living as fliving, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.prefix as prefix, people.suffix as suffix, people.nameorder, altdescription, altnotes, $medialinks_table.gedcom,
		familyID, people.personID as personID2, wifepeople.personID as wpersonID, wifepeople.firstname as wfirstname, wifepeople.lnprefix as wlnprefix, wifepeople.lastname as wlastname,
		wifepeople.prefix as wprefix, wifepeople.suffix as wsuffix, husbpeople.personID as hpersonID, husbpeople.firstname as hfirstname, husbpeople.lnprefix as hlnprefix, husbpeople.lastname as hlastname,
		husbpeople.prefix as hprefix, husbpeople.suffix as hsuffix, $sources_table.title, $sources_table.sourceID, $repositories_table.repoID, reponame
		FROM $medialinks_table
		LEFT JOIN $people_table AS people ON $medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom
		LEFT JOIN $families_table ON $medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom
		LEFT JOIN $people_table AS husbpeople ON $families_table.husband = husbpeople.personID AND $families_table.gedcom = husbpeople.gedcom
		LEFT JOIN $people_table AS wifepeople ON $families_table.wife = wifepeople.personID AND $families_table.gedcom = wifepeople.gedcom
		LEFT JOIN $sources_table ON $medialinks_table.personID = $sources_table.sourceID AND $medialinks_table.gedcom = $sources_table.gedcom
		LEFT JOIN $repositories_table ON ($medialinks_table.personID = $repositories_table.repoID AND $medialinks_table.gedcom = $repositories_table.gedcom)
		WHERE mediaID = \"$mediaID\"$wherestr2 ORDER BY people.lastname, people.lnprefix, people.firstname, hlastname, hlnprefix, hfirstname  LIMIT $ioffsetstr" . ($maxsearchresults + 1);
	$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$numrows = mysql_num_rows( $presult );
	$medialinktext = "";
	$noneliving = 1;
	$count = 0;
	while( $count < $maxsearchresults && $prow = mysql_fetch_assoc( $presult ) )
	{
		if( $prow[fbranch] != NULL ) $prow[branch] = $prow[fbranch];
		if( $prow[fliving] != NULL ) $prow[living] = $prow[fliving];
		if( $medialinktext ) $medialinktext .= "\n";
		if( !$prow[living] || $livedefault == 2 || ( !$livedefault && $allow_living_db && ( !$assignedtree || $assignedtree == $prow[gedcom] ) && checkbranch( $prow[branch] ) ) )
			$prow[allow_living] = 1;
		else {
			$noneliving = 0;
			$prow[allow_living] = 0;
		}
		if( $prow[personID2] != NULL ) {
			$medialinktext .= "<a href=\"$getperson_url" . "personID=$prow[personID2]&amp;tree=$prow[gedcom]\">";
			$medialinktext .= getName( $prow ) . "</a>";
		}
		elseif( $prow[sourceID] != NULL ) {
			$sourcetext = $prow[title] ? $prow[title] : "$text[source]: $prow[sourceID]";
			$medialinktext .= "<a href=\"$showsource_url" . "sourceID=$prow[sourceID]&amp;tree=$prow[gedcom]\">" . $sourcetext . "</a>";
		}
		elseif( $prow[repoID] != NULL ) {
			$repotext = $prow[reponame] ? $prow[reponame] : "$text[repository]: $prow[repoID]";
			$medialinktext .= "<a href=\"$showrepo_url" . "repoID=$prow[repoID]&amp;tree=$prow[gedcom]\">" . $repotext . "</a>";
		}
		elseif( $prow[familyID] != NULL ) {
			$familyname = trim("$prow[hlnprefix] $prow[hlastname]") . "/" . trim("$prow[wlnprefix] $prow[wlastname]") . " ($prow[familyID])";
			$medialinktext .= "<a href=\"$familygroup_url" . "familyID=$prow[familyID]&amp;tree=$prow[gedcom]\">$text[family]: $familyname</a>";
		}
		else
			$medialinktext .= "<a href=\"$placesearch_url" . "psearch=$prow[personID]&amp;tree=$prow[gedcom]\">" . $prow[personID] . "</a>";
		if($prow[eventID]) {
			$query = "SELECT description from $events_table, $eventtypes_table WHERE eventID = \"$prow[eventID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID";
			$eresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");;
			$erow = mysql_fetch_assoc($eresult);
			$event = $erow[description] ? $erow[description] : $prow[eventID];
			mysql_free_result($eresult);
			$medialinktext .= " ($event)";
		}
		$count++;
	}
	mysql_free_result( $presult );
	if( $numrows > $maxsearchresults )
		$medialinktext .= "\n[<a href=\"$showmedia_url" . "mediaID=$mediaID&amp;ioffset=" . ($newioffset + $maxsearchresults) . "\">$text[morelinks]</a>]";

	return $medialinktext;
}

function showMediaSource($imgrow) {
	global $text, $usefolder, $size, $imagetypes, $htmldocs, $histories_url, $cms, $tngconfig, $videotypes, $recordingtypes, $description;

	$imgrow[form] = strtoupper($imgrow[form]);
	if( $imgrow[map] ) {
		echo "<map name=\"tngmap_$imgrow[mediaID]\">$imgrow[map]</map>\n";
		$mapstr = " usemap=\"#tngmap_$imgrow[mediaID]\"";
	}
	else
		$mapstr = "";
	if( $imgrow[abspath] )
		$mediasrc = $imgrow[path];
	else {
		if( in_array( $imgrow[form], $htmldocs ) && $cms[support] )
			$mediasrc = $histories_url . "inc=$imgrow[path]";
		else
			$mediasrc = "$usefolder/" . str_replace("%2F","/",rawurlencode( $imgrow[path] ));
	}

	$targettext = $imgrow[newwindow] ? " target=\"_blank\"" : "";
	if( $imgrow[bodytext] ) {
		echo "<span class=\"normal\">" . ($imgrow[usenl] ? nl2br($imgrow[bodytext]) : $imgrow[bodytext]) . "</span>";
	}
	elseif( $imgrow[path] ) {
		if( $imgrow[abspath] ) {
			if( $imgrow[newwindow] )
				echo "<form style=\"margin:0px\"><input type=\"button\" value=\"$text[viewitem]...\" onClick=\"window.open('$mediasrc');\"/></form>\n";
			else
				echo "<form style=\"margin:0px\"><input type=\"button\" value=\"$text[viewitem]...\" onClick=\"window.location.href='$mediasrc';\"/></form>\n";
		}
		else {
			if( !$imgrow[form] ) {
				preg_match( "/\.(.+)$/", $imgrow[path], $matches );
				$imgrow[form] = $matches[1];
			}
			if( in_array($imgrow[form],$imagetypes) ) {
				$width = $size[0];
				$height = $size[1];
				if( $width && $height ) {
					if( $tngconfig[imgmaxw] && ($width > $tngconfig[imgmaxw]) ) {
						$width = $tngconfig[imgmaxw];
						$height = intval( $width * $size[1] / $size[0] ) ;
					}
					if( $tngconfig[imgmaxh] && ($height > $tngconfig[imgmaxh]) ) {
						$height = $tngconfig[imgmaxh];
						$width = intval( $height * $size[0] / $size[1] ) ;
					}
				}
				if( $width ) $widthstr = "width=\"$width\"";
				if( $height ) $heightstr = "height=\"$height\"";
				echo "<img src=\"$mediasrc\" border=\"0\" $widthstr $heightstr $mapstr alt=\"$description\" />\n";
			}
			elseif( in_array($imgrow[form],$videotypes) || in_array($imgrow[form],$recordingtypes) ) {
				$widthstr = $imgrow[width] ? " width=\"$imgrow[width]\"" : "";
				$heightstr = $imgrow[height] ? " height=\"$imgrow[height]\"" : "";
				echo "<embed src=\"$mediasrc\"$widthstr$heightstr>\n";
			}
			else {
				if( $imgrow[newwindow] )
					echo "<form style=\"margin:0px\"><input type=\"button\" value=\"$text[viewitem]...\" onClick=\"window.open('$mediasrc');\"/></form>\n";
				else
					echo "<form style=\"margin:0px\"><input type=\"button\" value=\"$text[viewitem]...\" onClick=\"window.location.href='$mediasrc';\"/></form>\n";
			}
		}
	}
}

function showTable($imgrow, $medialinktext, $albumlinktext) {
	global $text, $rootpath, $usefolder, $showextended, $imagetypes, $size, $info;

	$tabletext = "";
	$filename = basename( $imgrow[path] );
	$tabletext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\">\n";

	if( $imgrow[owner] )
		$tabletext .= showEvent( array( "text"=>$text[photoowner], "fact"=>$imgrow[owner]) );
	if( $imgrow[datetaken] )
		$tabletext .= showEvent( array( "text"=>$text[date], "date"=>$imgrow[datetaken] ) );
	if( $imgrow[placetaken] )
		$tabletext .= showEvent( array( "text"=>$text[place], "fact"=>$imgrow[placetaken] ) );
	if( $imgrow[latitude] )
		$tabletext .= showEvent( array( "text"=>$text[latitude], "fact"=>$imgrow[latitude] ) );
	if( $imgrow[longitude] )
		$tabletext .= showEvent( array( "text"=>$text[longitude], "fact"=>$imgrow[longitude] ) );

	if( $showextended ) {
		$tabletext .= showEvent( array( "text"=>$text[filename], "fact"=>$filename ) );
		$filesize = $imgrow[path] && file_exists("$rootpath$usefolder/$imgrow[path]") ? display_size(filesize("$rootpath$usefolder/$imgrow[path]")) : "";
		$tabletext .= showEvent( array( "text"=>$text[filesize], "fact"=>$filesize ) );
		if( in_array($imgrow[form],$imagetypes) )
			$tabletext .= showEvent( array( "text"=>$text[photosize], "fact"=>"$size[0] x $size[1]" ) );
		$tabletext .= output_iptc_data( $info );
	}

	if( $medialinktext )
		$tabletext .= showEvent( array( "text"=>$text['indlinked'], "fact"=>$medialinktext ) );
	if( $albumlinktext )
		$tabletext .= showEvent( array( "text"=>$text['albums'], "fact"=>$albumlinktext ) );
	$tabletext .= "</table>\n";

	return $tabletext;
}

function doCemPlusMap($imgrow, $tree) {
	global $cemeteries_table, $media_table, $text, $rootpath, $headstonepath, $mediatypes_assoc, $mediapath, $showmedia_url;

	$showmap_url = getURL( "showmap", 1 );
	$query = "SELECT cemname, city, county, state, country, maplink, notes FROM $cemeteries_table WHERE cemeteryID = \"$imgrow[cemeteryID]\"";
	$cemresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$cemetery = mysql_fetch_assoc($cemresult);
	mysql_free_result($cemresult);

	echo "<p><span class=\"subhead\">\n";
	$location = $cemetery[cemname];
	if( $cemetery[city] ) {
		if( $location ) $location .= ", ";
		$location .= "$cemetery[city]";
	}
	if( $cemetery[county] ) {
		if( $location ) $location .= ", ";
		$location .= "$cemetery[county]";
	}
	if( $cemetery[state] ) {
		if( $location ) $location .= ", ";
		$location .= "$cemetery[state]";
	}
	if( $cemetery[country] ) {
		if( $location ) $location .= ", ";
		$location .= "$cemetery[country]";
	}
	echo "<a href=\"$showmap_url" . "cemeteryID=$imgrow[cemeteryID]&amp;tree=$tree\">$location</a>";
	echo "</span></p>\n";
	if( $cemetery[notes] )
		echo "<p><strong>$text[notes]:</strong> " . nl2br($cemetery[notes]) . "</p>";

	if( $imgrow[showmap] ) {
		if( $cemetery[maplink] && file_exists( "$rootpath$headstonepath/$cemetery[maplink]" ) ) {
			$mapsize = @GetImageSize( "$rootpath$headstonepath/$cemetery[maplink]" );
			echo "<img src=\"$headstonepath/$cemetery[maplink]\" border=\"0\" $mapsize[3] alt=\"$cemetery[cemname]\" /><br/><br/>\n";
		}

		$query = "SELECT mediaID, mediatypeID, path, thumbpath, description, notes, usecollfolder, abspath, newwindow FROM $media_table WHERE cemeteryID = \"$imgrow[cemeteryID]\" AND linktocem = \"1\" ORDER BY mediatypeID, description";
		$hsresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( mysql_num_rows( $hsresult ) ) {
			$i = 1;
			echo "<span class=\"subhead\"><b>$text[cemphotos]</b></span><br /><br />";

			echo "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\">\n";
			echo "<tr><td class=\"fieldnameback\">&nbsp;</td>\n";
			echo "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[thumb]</strong>&nbsp;</span></td>\n";
			echo "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[description]</strong>&nbsp;</span></td>\n";

			while( $hs = mysql_fetch_assoc( $hsresult ) ) {
				$description = $hs[description];
				$notes = nl2br($hs[notes]);
				$hsmediatypeID = $hs[mediatypeID];
				$usehsfolder = $hs[usecollfolder] ? $mediatypes_assoc[$hsmediatypeID] : $mediapath;

				$imgsrc = getSmallPhoto($hs);
				if( $hs[abspath] )
					$href = $hs[path];
				else
					$href = "$showmedia_url" . "mediaID=$hs[mediaID]";

				$targettext = $hs[newwindow] ? " target=\"_blank\"" : "";
				echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$i</span></td>";
				echo "<td valign=\"top\" class=\"databack\">";
				echo $imgsrc ? "<a href=\"$href\"$targettext>$imgsrc</a>" : "&nbsp;";
				echo "</td>\n";
				echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">";
				echo "<a href=\"$href\">$description</a><br/>$notes&nbsp;</span></td></tr>\n";
				$i++;
			}
			echo "</table><br />\n";
		}
		mysql_free_result( $hsresult );
	}
}
?>
