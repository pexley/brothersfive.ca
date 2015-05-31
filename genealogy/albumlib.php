<?php
function getAlbumPhoto($albumID,$albumname) {
	global $assignedtree, $allow_living_db, $rootpath, $media_table, $albumlinks_table, $people_table, $families_table, $citations_table, $text, $medialinks_table;
	global $mediatypes_assoc, $mediapath, $showalbum_url;

	$wherestr2 = $tree ? " AND $medialinks_table.gedcom = \"$tree\"" : "";

	$query2 = "SELECT thumbpath, usecollfolder, mediatypeID, $albumlinks_table.mediaID as mediaID, alwayson FROM ($media_table, $albumlinks_table)
		WHERE albumID = \"$albumID\" AND $media_table.mediaID = $albumlinks_table.mediaID AND defphoto=\"1\"";
	$result2 = mysql_query($query2) or die ("$text[cannotexecutequery]: $query2");
	$trow = mysql_fetch_assoc( $result2 );
	$mediaID = $trow['mediaID'];
	$tmediatypeID = $trow['mediatypeID'];
	$tusefolder = $trow['usecollfolder'] ? $mediatypes_assoc[$tmediatypeID] : $mediapath;
	mysql_free_result($result2);

	$imgsrc = "";
	if( $trow['thumbpath'] && file_exists( "$rootpath$tusefolder/$trow[thumbpath]" ) ) {
		$noneliving = 1;
		if(!$trow['alwayson'] && $livedefault != 2) {
			$query = "SELECT people.living as living, people.branch as branch, $families_table.branch as fbranch, $families_table.living as fliving, linktype, $medialinks_table.gedcom as gedcom
				FROM $medialinks_table
				LEFT JOIN $people_table AS people ON $medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom
				LEFT JOIN $families_table ON $medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom
				WHERE mediaID = \"$mediaID\"$wherestr2";
			$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			while( $prow = mysql_fetch_assoc( $presult ) )
			{
				if( $prow['fbranch'] != NULL ) $prow['branch'] = $prow['fbranch'];
				if( $prow['fliving'] != NULL ) $prow['living'] = $prow['fliving'];
				//if living still null, must be a source
				if( $prow['living'] == NULL && $prow['linktype'] == 'I') {
					$query = "SELECT count(personID) as ccount FROM $citations_table, $people_table
						WHERE $citations_table.sourceID = '$prow[personID]' AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
						AND living = '1'";
					$presult2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
					$prow2 = mysql_fetch_assoc( $presult2 );
					if( $prow2[ccount] ) $prow[living] = 1;
					mysql_free_result( $presult2 );
				}
				elseif( $prow['living'] == NULL && $prow['linktype'] == 'F') {
					$query = "SELECT count(familyID) as ccount FROM $citations_table, $families_table
						WHERE $citations_table.sourceID = '$prow[personID]' AND $citations_table.persfamID = $families_table.familyID AND $citations_table.gedcom = $families_table.gedcom
						AND living = '1'";
					$presult2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
					$prow2 = mysql_fetch_assoc( $presult2 );
					if( $prow2[ccount] ) $prow[living] = 1;
					mysql_free_result( $presult2 );
				}
				if( !$prow['living'] || ($allow_living_db && ( !$assignedtree || $assignedtree == $prow['gedcom'] ) && checkbranch( $prow['branch'] ) ) )
					$prow['allow_living'] = 1;
				else {
					$noneliving = 0;
					continue;
				}
			}
		}
		if( $noneliving ) {
			$size = @GetImageSize( "$rootpath$tusefolder/$trow[thumbpath]" );
			$imgsrc = "<a href=\"$showalbum_url" . "albumID=$albumID\"><img src=\"$tusefolder/" . str_replace("%2F","/",rawurlencode( $trow['thumbpath'] )) . "\" border=\"0\" $size[3] alt=\"$albumname\"></a>";
		}
	}
	return $imgsrc;
}
?>
