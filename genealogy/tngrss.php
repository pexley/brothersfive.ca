<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
$textpart = "whatsnew";
//include($cms[tngpath] . "getlang.php");
@ini_set( "session.bug_compat_warn", "0" );
if( $lang ) {
	$mylanguage = $lang;
	$langstr = "&amp;lang=$lang";
}
else {
	$mylanguage = $language;
	$langstr = "";
}
include($cms[tngpath] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "version.php");

$getperson_url = getURL( "getperson", 1 );
$showmedia_url = getURL( "showmedia", 1 );
$familygroup_url = getURL( "familygroup", 1 );

$date = date("r");

function doMedia( $mediatypeID ) {
	global $tngdomain, $langstr;

	global $media_table, $medialinks_table, $change_limit, $cutoffstr, $text, $families_table, $sources_table, $repositories_table, $citations_table, $nonames;
	global $people_table, $familygroup_url, $showsource_url, $showrepo_url, $placesearch_url, $showmedia_url, $trees_table, $allow_living_db, $assignedtree;
	global $rootpath, $photopath, $documentpath, $headstonepath, $historypath, $mediapath, $header, $footer, $cemeteries_table;
	global $getperson_url, $livedefault, $whatsnew, $wherestr2, $showmap_url, $thumbmaxw, $events_table, $eventtypes_table;

	if( $mediatypeID == "headstones" ) {
		$hsfields = ", $media_table.cemeteryID, cemname";
		$hsjoin = "LEFT JOIN $cemeteries_table ON $media_table.cemeteryID = $cemeteries_table.cemeteryID";
	}
	else
		$hsfields = $hsjoin = "";

	$query = "SELECT distinct $media_table.mediaID as mediaID, description, $media_table.notes, thumbpath, path, form, mediatypeID, $media_table.gedcom as gedcom, alwayson, usecollfolder, DATE_FORMAT(changedate,'%d %b %Y') as changedatef, status, abspath, newwindow $hsfields
		FROM $media_table $hsjoin";
	$query .= " WHERE $cutoffstr $wherestr AND mediatypeID = \"$mediatypeID\" ORDER BY changedate DESC, description LIMIT $change_limit";
	$mediaresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

	while( $row = mysql_fetch_assoc( $mediaresult ) ) {
		$query = "SELECT medialinkID, $medialinks_table.personID as personID, $medialinks_table.eventID, people.personID as personID2, familyID, people.living as living, people.branch as branch,
			$families_table.branch as fbranch, $families_table.living as fliving, husband, wife, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname,
			people.suffix as suffix, nameorder, $medialinks_table.gedcom as gedcom, treename, $sources_table.title, $sources_table.sourceID, $repositories_table.repoID,reponame, deathdate, burialdate, linktype
			FROM ($medialinks_table, $trees_table)
			LEFT JOIN $people_table AS people ON ($medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom)
			LEFT JOIN $families_table ON ($medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom)
			LEFT JOIN $sources_table ON ($medialinks_table.personID = $sources_table.sourceID AND $medialinks_table.gedcom = $sources_table.gedcom)
			LEFT JOIN $repositories_table ON ($medialinks_table.personID = $repositories_table.repoID AND $medialinks_table.gedcom = $repositories_table.gedcom)
			WHERE mediaID = \"$row[mediaID]\" AND $medialinks_table.gedcom = $trees_table.gedcom$wherestr2 ORDER BY lastname, lnprefix, firstname, $medialinks_table.personID";
		$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$noneliving = 1;
		$hstext = "";
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
			if( $prow[living] && $livedefault != 2 )
				$noneliving = 0;
			if( $prow[personID2] != NULL ) {
				$medialink = $getperson_url . "personID=$prow[personID2]&amp;tree=$prow[gedcom]";
				$mediatext = getName( $prow );
				if( $mediatypeID == "headstones" ) {
					$deathdate = $prow[deathdate] ? $prow[deathdate] : $prow[burialdate];
					if( $prow[deathdate] ) $abbrev = $text[deathabbr];
					elseif( $prow[burialdate] ) $abbrev = $text[burialabbr];
					$hstext = $deathdate ? " ($abbrev " . displayDate( $deathdate ) . ")" : "";
				}
			}
			elseif( $prow[familyID] != NULL ) {
				$medialink = $familygroup_url . "familyID=$prow[familyID]&amp;tree=$prow[gedcom]";
				$mediatext = "$text[family]: " . getFamilyName( $prow );
			}
			elseif( $prow[sourceID] != NULL ) {
				$mediatext = $prow[title] ? "$text[source]: $prow[title]" : "$text[source]: $prow[sourceID]";
				$medialink = $showsource_url . "sourceID=$prow[sourceID]&amp;tree=$prow[gedcom]";
			}
			elseif( $prow[repoID] != NULL ) {
				$mediatext = $prow[reponame] ? "$text[repository]: $prow[reponame]" : "$text[repository]: $prow[repoID]";
				$medialink = $showrepo_url . "repoID=$prow[repoID]&amp;tree=$prow[gedcom]";
			}
			else {
				$medialink = $placesearch_url . "psearch=$prow[personID]&amp;tree=$prow[gedcom]";
				$mediatext = $prow[personID];
			}
			if($prow[eventID]) {
				$query = "SELECT description from $events_table, $eventtypes_table WHERE eventID = \"$prow[eventID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID";
				$eresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				$erow = mysql_fetch_assoc($eresult);
				$event = $erow[description] ? $erow[description] : $prow[eventID];
				mysql_free_result($eresult);
				$mediatext .= " ($event)";
			}
		}
		mysql_free_result( $presult );

		$href = getMediaHREF($row,0);
		if( $noneliving || !$nonames || $row[alwayson] ) {
			$description = $row[description];
			$notes = $row[notes];
			$notes = nl2br( getXrefNotes($row[notes],$row[gedcom]) );
			if( !$noneliving && !$row[alwayson] ) $notes .= " ($text[livingphoto])";
		}
		else {
			$description = $text[living];
			$notes = "($text[livingphoto])";
		}

		if( $row[status] ) $notes = "$text[status]: $row[status]. $notes";

		echo "\n<item>\n";
		echo "<title>" . xmlcharacters($text[$mediatypeID] . ": " . htmlspecialchars($description,ENT_NOQUOTES)) . "</title>\n";
		echo "<link>" . ($row['abspath'] ? "" : "$tngdomain/") . "$href$langstr</link>\n";

		if( $mediatypeID == "headstones" ) {
			$deathdate = $row[deathdate] ? $row[deathdate] : $row[burialdate];
			echo "<description>" . xmlcharacters($hstext . " " . htmlspecialchars($notes,ENT_NOQUOTES) ) . "</description>\n";
			echo "<category>$text[tree]: $trow[treename]</category>\n";
		}
		else {
			echo "<description>" . xmlcharacters(htmlspecialchars($notes,ENT_NOQUOTES)) . "</description>\n";
			echo "<category></category>\n";
		}
		echo "<pubDate>" . displayDate( $row[changedatef] ) . " 12:00:01 GMT</pubDate>\n";
		echo "</item>\n";
	}
	mysql_free_result($mediaresult);
}

header('Content-type: application/xml');
echo "<?xml version=\"1.0\"";
if($charset)
	echo " encoding=\"$charset\"";
echo "?>\n";
echo "<rss version=\"0.92\">\n";
echo "<channel>\n";
echo "<copyright>$tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright</copyright>\n";
echo "<lastBuildDate>$date</lastBuildDate>\n";

//you will need to define $site_desc and $sitename in your customconfig.php file
//as of 6.0, these will come from config.php, but anything defined in customconfig.php will take precedence
echo "<description>$site_desc</description>\n";
echo "<title>$sitename</title>\n";

echo "<link>$tngdomain</link>\n";
echo "<managingEditor>$emailaddr</managingEditor>\n";
echo "<webMaster>$emailaddr</webMaster>\n";

//you will need to define $rsslang in your customconfig.php file before you can use this
//echo "<language>$rsslang</language>\n";

$query = "SELECT * FROM $cemeteries_table ORDER BY country, state, county, city, cemname";
$cemresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

$text[pastxdays] = ereg_replace( "xx", "$change_cutoff", $text[pastxdays] );

if( !$change_cutoff ) $change_cutoff = 0;
if( !$change_limit ) $change_limit = 10;
$cutoffstr = "TO_DAYS(NOW()) - TO_DAYS(changedate) <= $change_cutoff";

foreach( $mediatypes as $mediatype ) {
	$mediatypeID = $mediatype[ID];
	echo doMedia( $mediatypeID );
}

//select from people where date later than cutoff, order by changedate descending, limit = 10
	$query = "SELECT $people_table.personID, lastname, lnprefix, firstname, birthdate, suffix, nameorder, living, branch, DATE_FORMAT(changedate,'%a, %d %b %Y') as changedatef, LPAD(SUBSTRING_INDEX(birthdate, ' ', -1),4,'0') as birthyear, birthplace, altbirthdate, LPAD(SUBSTRING_INDEX(altbirthdate, ' ', -1),4,'0') as altbirthyear, altbirthplace, $people_table.gedcom as gedcom FROM $people_table WHERE TO_DAYS(NOW()) - TO_DAYS(changedate) <= $change_cutoff ORDER BY changedate DESC, lastname, firstname, birthyear, altbirthyear LIMIT $change_limit";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$numrows = mysql_num_rows( $result );
	if( $numrows ) {
		while( $row = mysql_fetch_assoc($result))
		{
			if( !$row[living] ) {
				$row[allow_living] = 1;
				if ( $row[birthdate] ) {
					$birthdate = "$text[birthabbr] " . displayDate( $row[birthdate] );
					$birthplace = $row[birthplace];
				}
				else if ( $row[altbirthdate] ) {
					$birthdate = "$text[chrabbr] " . displayDate( $row[altbirthdate] );
					$birthplace = $row[altbirthplace];
				}
				else {
					$birthdate = "";
					$birthplace = "";
				}
			}
			else {
				$row[allow_living] = 0;
				$birthdate = $birthplace = "";
			}
			$namestr = getName( $row );

			$query = "SELECT gedcom, treename FROM $trees_table WHERE gedcom = \"$row[gedcom]\"";
			$treeresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$treerow = mysql_fetch_assoc( $treeresult );
			
			echo "\n<item>\n";
			echo "<title>" . xmlcharacters("$text[indinfo]: $namestr ($row[personID])") . "</title>\n";
			echo "<link>$tngdomain/$getperson_url" . "personID=$row[personID]&amp;tree=$row[gedcom]$langstr</link>\n";
			if( $birthdate || $birthplace )
				echo "<description>" . xmlcharacters("$birthdate, $birthplace") . "</description>\n";
			else
				echo "<description>" . xmlcharacters("$text[birthabbr]") . "</description>\n";
			echo "<category>$text[tree]: $treerow[treename]</category>\n";
			echo "<pubDate>" . displayDate( $row[changedatef] ) . " 12:00:01 GMT</pubDate>\n";
			echo "</item>\n";
		}
		mysql_free_result($result);
	}

//select husband, wife from families where date later than cutoff, order by changedate descending, limit = 10
	$allwhere = " AND $people_table.gedcom = $families_table.gedcom";

	$query = "SELECT familyID, husband, wife, marrdate, marrplace, $families_table.gedcom as gedcom, firstname, lnprefix, lastname, suffix, nameorder, $families_table.branch as fbranch, $people_table.branch as branch, $families_table.living as fliving, $people_table.living as living, DATE_FORMAT($families_table.changedate,'%a, %d %b %Y') as changedatef FROM $families_table, $people_table WHERE TO_DAYS(NOW()) - TO_DAYS($families_table.changedate) <= $change_cutoff AND $people_table.personID = husband $allwhere ORDER BY $families_table.changedate DESC, lastname LIMIT $change_limit";
	$famresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$numrows = mysql_num_rows( $famresult );
	if( $numrows ) {
		while( $row = mysql_fetch_assoc($famresult))
		{
			$row[allow_living] = !$row[living] ? 1 : 0;

			$query = "SELECT gedcom, treename FROM $trees_table WHERE gedcom = \"$row[gedcom]\"";
			$treeresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$treerow = mysql_fetch_assoc( $treeresult );

			echo "\n<item>\n";
			echo "<title>" . xmlcharacters("$text[family]: $row[familyID] (" . getName( $row ) . ")") . "</title>\n";
			echo "<link>$tngdomain/$familygroup_url" . "familyID=$row[familyID]&amp;tree=$row[gedcom]$langstr</link>\n";
			echo "<description>";
			if( !$row[fliving] ) {
				echo displayDate( $row[marrdate] );
				echo ", " . xmlcharacters($row[marrplace]);
			}
			echo "</description>\n";
			echo "<category>$text[tree]: $treerow[treename]</category>\n";
			echo "<pubDate>" . displayDate( $row[changedatef] ) . " 12:00:01 GMT</pubDate>\n";
			echo "</item>\n";
		}
		mysql_free_result($famresult);
	}

	echo "</channel></rss>\n";
?>
