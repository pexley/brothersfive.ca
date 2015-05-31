<?php
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

function resortMedia($mediaID) {
	global $media_table, $medialinks_table, $people_table, $families_table, $sources_table, $repositories_table, $admtext;
	
	$query = "SELECT $media_table.mediaID as mediaID, personID, $medialinks_table.gedcom as gedcom, mediatypeID FROM $medialinks_table, $media_table WHERE $medialinks_table.mediaID = \"$mediaID\" AND $medialinks_table.mediaID = $media_table.mediaID";
	$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	if( $result2 ) {
		while( $plink = mysql_fetch_assoc( $result2 ) )
		{
			$query = "DELETE FROM $medialinks_table WHERE mediaID = $plink[mediaID]";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			
			$query = "SELECT personID from $people_table WHERE personID = \"$plink[personID]\" AND gedcom = \"$plink[gedcom]\"";
			reorderMedia( $query, $plink, $plink[mediatypeID] );
	
			$query = "SELECT familyID as personID from $families_table WHERE familyID = \"$plink[personID]\" AND gedcom = \"$plink[gedcom]\"";
			reorderMedia( $query, $plink, $plink[mediatypeID] );
	
			$query = "SELECT sourceID as personID from $sources_table WHERE sourceID = \"$plink[personID]\" AND gedcom = \"$plink[gedcom]\"";
			reorderMedia( $query, $plink, $plink[mediatypeID] );
	
			$query = "SELECT repoID as personID from $repositories_table WHERE repoID = \"$plink[personID]\" AND gedcom = \"$plink[gedcom]\"";
			reorderMedia( $query, $plink, $plink[mediatypeID] );
		}
		mysql_free_result( $result2 );
	}
}

function removeImages($mediaID) {
	global $media_table, $rootpath, $admtext, $mediatypes_assoc;
	
	$query = "SELECT path, thumbpath, usecollfolder, mediatypeID FROM $media_table WHERE mediaID = \"$mediaID\"";
	$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$mediatypeID = $row['mediatypeID'];
	$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;

	//now look for any records with path still the same. if none, go ahead and delete.
	$query = "SELECT count(mediaID) as mcount FROM $media_table WHERE path = \"$row[path]\"";
	$result3 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$row3 = mysql_fetch_assoc( $result3 );
	mysql_free_result( $result3 );
	
	if( $row[path] && !$row3[mcount] && file_exists( "$rootpath$usefolder/$row[path]" ) )
		unlink( "$rootpath$usefolder/$row[path]" );
	
	//now look for any records with thumbpath still the same. if none, go ahead and delete.
	$query = "SELECT count(mediaID) as mcount FROM $media_table WHERE thumbpath = \"$row[thumbpath]\"";
	$result3 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$row3 = mysql_fetch_assoc( $result3 );
	mysql_free_result( $result3 );
	
	if( $row['thumbpath'] && !$row3['mcount'] && file_exists( "$rootpath$usefolder/$row[thumbpath]" ) )
		unlink( "$rootpath$usefolder/$row[thumbpath]" );
}
?>