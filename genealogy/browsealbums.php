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
include($cms['tngpath'] . "personlib.php" );

$browsealbums_url = getURL( "browsealbums", 1 );
$browsealbums_noargs_url = getURL( "browsealbums", 0 );
$showalbum_url = getURL( "showalbum", 1 );
$getperson_url = getURL( "getperson", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showsource_url = getURL( "showsource", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$placesearch_url = getURL( "placesearch", 1 );

function doMediaSearch( $instance, $pagenav ) {
	global $text, $mediasearch, $browsealbums_noargs_url;

	$str = getFORM( "browsealbums", "GET", "MediaSearch$instance", "" );
	$str .= "<input type=\"text\" name=\"mediasearch\" value=\"$mediasearch\" /> <input type=\"submit\" value=\"$text[search]\" /> <input type=\"button\" value=\"$text[tng_reset]\" onclick=\"window.location.href='$browsealbums_noargs_url';\" />&nbsp;&nbsp;&nbsp;";
	$str .= $pagenav;
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

if( $tree )
	$wherestr2 = " AND $album2entities_table.gedcom = \"$tree\"";
else
	$wherestr2 = "";

if( $mediasearch )
	$wherestr = "WHERE ($albums_table.albumname LIKE \"%$mediasearch%\" OR $albums_table.description LIKE \"%$mediasearch%\" OR $albums_table.keywords LIKE \"%$mediasearch%\")";
else
	$wherestr = "";

$query = "SELECT albumID, albumname, description FROM $albums_table $wherestr ORDER BY albumname LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numrows = mysql_num_rows( $result );

if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count($albums_table.albumID) as acount FROM $albums_table";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	mysql_free_result($result2);
	$totrows = $row[acount];
}
else
	$totrows = $numrows;

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " $text[tree]: $tree" : "";
$treestr = trim("$mediasearch $treestr");
$treestr = $treestr ? " ($treestr)" : "";

$logstring = "<a href=\"$browsealbums_url" . "tree=$tree&amp;offset=$offset&amp;mediasearch=$mediasearch\">$text[allalbums]$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( $text[albums], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_album.gif"; width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text[albums]; ?><br clear="all" /></p>
<?php
echo tng_coreicons();

if( $totrows )
	echo "<p class=\"normal\">$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows</p>";

$pagenav = get_browseitems_nav( $totrows, $browsealbums_url . "mediasearch=$mediasearch&amp;offset", $maxsearchresults, $max_browsemedia_pages );
echo doMediaSearch( 1, $pagenav );
echo "<br />\n";
?>
<table cellpadding="3" cellspacing="1" border="0">
<?php
$albumtext = $header = "";
$header .= "<tr><td class=\"fieldnameback\">&nbsp;</td>\n";
$header .= "<td class=\"fieldnameback fieldname\">&nbsp;<strong>$text[thumb]</strong>&nbsp;</td>\n";
$header .= "<td class=\"fieldnameback fieldname\">&nbsp;<strong>$text[description]</strong>&nbsp;</td>\n";
$header .= "<td class=\"fieldnameback fieldname\">&nbsp;<strong>$text[numitems]</strong>&nbsp;</td>\n";
$header .= "<td class=\"fieldnameback fieldname\">&nbsp;<strong>$text[indlinked]</strong>&nbsp;</td>\n";
$header .= "</tr>\n";

$i = $offsetplus;
$maxplus = $maxsearchresults + 1;
$thumbcount = 0;
while( $row = mysql_fetch_assoc( $result ) ) {
	$query2 = "SELECT count($albumlinks_table.albumlinkID) as acount FROM $albumlinks_table WHERE albumID = \"$row[albumID]\"";
	$result2 = mysql_query($query2) or die ("$text[cannotexecutequery]: $query2");
	$arow = mysql_fetch_assoc( $result2 );
	mysql_free_result($result2);

	$query = "SELECT $album2entities_table.entityID as personID, people.personID as personID2, people.living as living, people.branch as branch, $families_table.branch as fbranch,
		$families_table.living as fliving, familyID, husband, wife, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.prefix as prefix, people.suffix as suffix, nameorder,
		$album2entities_table.gedcom, $sources_table.title, $sources_table.sourceID, $repositories_table.repoID, reponame, deathdate, burialdate, linktype
		FROM $album2entities_table
		LEFT JOIN $people_table AS people ON $album2entities_table.entityID = people.personID AND $album2entities_table.gedcom = people.gedcom
		LEFT JOIN $families_table ON $album2entities_table.entityID = $families_table.familyID AND $album2entities_table.gedcom = $families_table.gedcom
		LEFT JOIN $sources_table ON $album2entities_table.entityID = $sources_table.sourceID AND $album2entities_table.gedcom = $sources_table.gedcom
		LEFT JOIN $repositories_table ON ($album2entities_table.entityID = $repositories_table.repoID AND $album2entities_table.gedcom = $repositories_table.gedcom)
		WHERE albumID = \"$row[albumID]\"$wherestr2 ORDER BY lastname, lnprefix, firstname, personID LIMIT $maxplus";
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

		if( $prow[personID2] != NULL ) {
			$medialinktext .= "<li><a href=\"$getperson_url" . "personID=$prow[personID2]&amp;tree=$prow[gedcom]\">";
			$medialinktext .= getName( $prow ) . "</a></li>\n";
		}
		elseif( $prow[sourceID] != NULL ) {
			$sourcetext = $prow[title] ? "$text[source]: $prow[title]" : "$text[source]: $prow[sourceID]";
			$medialinktext .= "<li><a href=\"$showsource_url" . "sourceID=$prow[personID]&amp;tree=$prow[gedcom]\">$sourcetext</a></li>\n";
		}
		elseif( $prow[repoID] != NULL ) {
			$repotext = $prow[reponame] ? "$text[repository]: $prow[reponame]" : "$text[repository]: $prow[repoID]";
			$medialinktext .= "<li><a href=\"$showrepo_url" . "repoID=$prow[personID]&amp;tree=$prow[gedcom]\">$repotext</a></li>\n";
		}
		elseif( $prow[familyID] != NULL )
			$medialinktext .= "<li><a href=\"$familygroup_url" . "familyID=$prow[personID]&amp;tree=$prow[gedcom]\">$text[family]: " . getFamilyName( $prow ) . "</a></li>\n";
		else
			$medialinktext .= "<li><a href=\"$placesearch_url" . "psearch=$prow[personID]&amp;tree=$prow[gedcom]\">$prow[personID]</a></li>\n";
		$count++;
	}
	if($medialinktext) $medialinktext = "<ul>$medialinktext</ul>\n";
	mysql_free_result( $presult );


	$albumtext .= "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$i</span></td>";

	$imgsrc = getAlbumPhoto($row['albumID'],$row['albumname']);
	if($imgsrc) {
		$albumtext .= "<td valign=\"top\" class=\"databack\" align=\"center\">$imgsrc</td>";
		$thumbcount++;
	}
	else
		$albumtext .= "<td valign=\"top\" class=\"databack\" align=\"center\">&nbsp;</td>";

	$albumtext .= "<td class=\"databack\" valign=\"top\"><span class=\"normal\"><a href=\"$showalbum_url" . "albumID=$row[albumID]\">$row[albumname]</a><br />$row[description]<br/>$notes&nbsp;</span></td>\n";
	$albumtext .= "<td class=\"databack\" valign=\"top\" align=\"center\"><span class=\"normal\">$arow[acount]&nbsp;</span></td>\n";
	$albumtext .= "<td valign=\"top\" class=\"databack\" width=\"200\"><span class=\"normal\">\n$medialinktext&nbsp;</span></td>\n";
	$albumtext .= "</tr>\n";
	$i++;
}
mysql_free_result($result);

if( !$thumbcount ) {
	$header = ereg_replace( "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[thumb]</strong>&nbsp;</span></td>", "", $header );
	$albumtext = ereg_replace( "<td valign=\"top\" class=\"databack\" align=\"center\">&nbsp;</td><td valign=\"top\" class=\"databack\">", "<td valign=\"top\" class=\"databack\">", $albumtext );
}
echo $header . $albumtext;
?>
</table><br/>
<?php
if( $pagenav || $mediasearch ) {
	echo doMediaSearch( 2, $pagenav );
	echo "<br />";
}
tng_footer( "" );
?>
