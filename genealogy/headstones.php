<?php
include("begin.php");
include($subroot . "mapconfig.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "headstones";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "functions.php");

$showmap_url = getURL( "showmap", 1 );
$getperson_url = getURL( "getperson", 1 );
$showmedia_url = getURL( "showmedia", 1 );
$showsource_url = getURL( "showsource", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$headstones_url = getURL( "headstones", 1 );
if(!$thumbmaxw) $thumbmaxw = 80;

if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

if( $cemeteryID )
	$subquery = "WHERE cemeteryID = '$cemeteryID'";
else {
	if( $country )
		$subquery = "WHERE country = '$country' ";
	else
		$subquery = "";
	if( $state )
		$subquery .= "AND state = '$state' ";
	if( $county )
		$subquery .= "AND county = '$county'";
	if( $city )
		$subquery .= "AND city = '$city'";
}

if( $subquery ) {
	$query = "SELECT * FROM $cemeteries_table $subquery ORDER BY country, state, county, cemname";
	$cemresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
}
else
	$cemresult = "";

if(!$cemeteryID && $cemresult && mysql_num_rows($cemresult) == 1) {
	$cemetery = mysql_fetch_assoc( $cemresult );
	mysql_free_result($cemresult);
	header("Location:$showmap_url" . "cemeteryID=$cemetery[cemeteryID]&amp;tree=$tree");
	exit;
}

$country = stripslashes($country);
$state = stripslashes($state);
$county = stripslashes($county);
$city = stripslashes($city);
$location = $city;
if( $location && $county ) $location .= ", $county"; else $location = $county;
if( $location && $state ) $location .= ", $state"; else $location = $state;
if( $location && $country ) $location .= ", $country"; else $location = $country;

$titlestr = $text[cemeteriesheadstones];
if( $location ) $titlestr .= " $text[in] $location";
$logstring = "<a href=\"$headstones_url" . "country=$country&amp;state=$state&amp;county=$county&amp;tree=$tree\">$titlestr</a>";
writelog($logstring);
preparebookmark($logstring);

if( $map[key] )
	$flags[scripting] = "<script src=\"http://maps.google.com/maps?file=api&amp;v=2$text[glang]$mcharsetstr&amp;key=$map[key]\" language=\"Javascript\" type=\"text/javascript\"></script>\n";
tng_header( $text[cemeteriesheadstones], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_hs.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text[cemeteriesheadstones];  if( $location ) echo " $text[in] $location"; ?><br clear="all" /></p>
<?php
echo tng_coreicons();

$hiddenfields[] = array('name' => 'country', 'value' => $country);
$hiddenfields[] = array('name' => 'state', 'value' => $state);
$hiddenfields[] = array('name' => 'county', 'value' => $county);
echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'headstones', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields));


if($tree) {
	$wherestr = " AND ($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\")";
	$wherestr2 = " AND $medialinks_table.gedcom = \"$tree\"";
}
else
	$wherestr = $wherestr2 = "";

$body = "";
$body .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" width=\"100%\">\n";
$cemcount = 0;
while( !$subquery || $cemetery = mysql_fetch_assoc( $cemresult ) )
{
	$thiscem = $subquery ? $cemetery[cemeteryID] : "";
	$query = "SELECT DISTINCT $media_table.mediaID, description, notes, path, thumbpath, status, plot, showmap, usecollfolder, form, mediatypeID, abspath, newwindow
		FROM $media_table LEFT JOIN $medialinks_table on $media_table.mediaID = $medialinks_table.mediaID
		WHERE mediatypeID = \"headstones\" AND cemeteryID = \"$thiscem\" $wherestr ORDER BY description LIMIT $newoffset" . $maxsearchresults;
	if( !$subquery ) {
		$cemetery = array();
		$cemetery[cemname] = $text[nocemetery];
		$subquery = "done";
	}
	$hsresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

	$numrows = mysql_num_rows( $hsresult );
	if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
		$query = "SELECT count(DISTINCT $media_table.mediaID) as hscount FROM $media_table LEFT JOIN $medialinks_table on $media_table.mediaID = $medialinks_table.mediaID WHERE mediatypeID = \"headstones\" AND cemeteryID = \"$thiscem\" $wherestr";
		$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$row = mysql_fetch_assoc( $result2 );
		$totrows = $row[hscount];
	}
	else
		$totrows = $numrows;

	$body .= "<tr><td colspan='6'><span class=\"subhead\"><strong>";
	if( $cemcount )
		$body .= "<br /><br />\n";
	$location = "<a href=\"$showmap_url" . "cemeteryID=$cemetery[cemeteryID]&amp;tree=$tree\">$cemetery[cemname]";
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
	$location .= "</a>";

	if( $map[key] ) {
		$lat = $cemetery[latitude];
		$long = $cemetery[longitude];
		$zoom = $cemetery[zoom] ? $cemetery[zoom] : 10;
		$pinplacelevel = $pinplacelevel2;

		// if we have one, add it
		if($lat && $long) {
	 		$cemeteryplace = "$cemetery[city], $cemetery[county], $cemetery[state], $cemetery[country]";
	 		$localballooncemeteryname = htmlspecialchars($cemetery[cemname], ENT_QUOTES);
	 		$localballooncemeteryplace = htmlspecialchars($cemeteryplace, ENT_QUOTES);
	 		$remoteballoontext = htmlspecialchars(str_replace($banish, $banreplace, "$cemetery[cemname], $cemeteryplace"), ENT_QUOTES);
//RM - added placelevel here to pass a set value of 2 over to the map
// this allows for a future update where individual headstones can have
// a place level of 1 meaning the exact location. Then a map could be provided
// that allows a pin to draw for each headstone within a cemetery.
			$locations2map[$l2mCount]= array("zoom"=>$zoom,"lat"=>$lat,"long"=>$long,"pinplacelevel"=>$pinplacelevel,"place"=>$cemeteryplace,"htmlcontent"=>"<div class =\"normal\"  style=\"width:240px\"><a href=\"$showmap_url" . "cemeteryID=$cemetery[cemeteryID]\">$localballooncemeteryname</a><br />$localballooncemeteryplace</div>");
			$l2mCount++;
	// put a pin on the line
			$body .= "<a href=\"http://maps.google.com/maps?f=q$text[glang]$mcharsetstr&amp;q=$lat,$long($remoteballoontext)&amp;z=$zoom&amp;om=1&amp;iwloc=addr\" target=\"_blank\"><img src=\"$cms[tngpath]" . "googlemaps/numbered_marker.php?image=$pinplacelevel2.png&amp;text=$l2mCount&amp;name=pin$pinplacelevel2" . "no$l2mCount.png\" alt=\"\" border=\"0\"></a>";
			$map[pins]++;
		}
	}

	$body .= $location;
	$body .= "</strong></span>";
	$pagenav = get_browseitems_nav( $totrows, $headstones_url . "cemeteryID=$cemetery[cemeteryID]&amp;tree=$tree&amp;offset", $maxsearchresults, 5 );
	$body .= " &nbsp; $pagenav";
	$body .= "</td></tr>\n";
	$body .= "<tr><td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[thumb]</b></span></td>";
	$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[description]</b></span></td>";
	$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[status]</b></span></td>";
	$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[location]</b></span></td>";
	$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[name] ($text[diedburied])</b></span></td></tr>";

	while( $hs = mysql_fetch_assoc( $hsresult ) ) {
		$mediatypeID = $hs['mediatypeID'];
		$usefolder = $hs['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;

		$status = $hs['status'];
		if($status && $text[$status]) $hs['status'] = $text[$status];

		$query = "SELECT medialinkID, $medialinks_table.personID as personID, people.personID as personID2, familyID, people.living as living, people.branch as branch,
			$families_table.branch as fbranch, $families_table.living as fliving, husband, wife, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname,
			people.prefix as prefix, people.suffix as suffix, nameorder, $medialinks_table.gedcom as gedcom, treename, $sources_table.title, $sources_table.sourceID, $repositories_table.repoID,reponame, deathdate, burialdate, linktype
			FROM ($medialinks_table, $trees_table)
			LEFT JOIN $people_table AS people ON ($medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom)
			LEFT JOIN $families_table ON ($medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom)
			LEFT JOIN $sources_table ON ($medialinks_table.personID = $sources_table.sourceID AND $medialinks_table.gedcom = $sources_table.gedcom)
			LEFT JOIN $repositories_table ON ($medialinks_table.personID = $repositories_table.repoID AND $medialinks_table.gedcom = $repositories_table.gedcom)
			WHERE mediaID = \"$hs[mediaID]\" AND $medialinks_table.gedcom = $trees_table.gedcom $wherestr2 ORDER BY lastname, lnprefix, firstname, $medialinks_table.personID";

		$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$hslinktext = "";
		while( $prow = mysql_fetch_assoc( $presult ) ) {
			$prow[allow_living] = 1;
			$hstext = "";
			if( $prow[personID2] != NULL ) {
				$hslinktext .= "<a href=\"$getperson_url" . "personID=$prow[personID2]&amp;tree=$prow[gedcom]\">";
				$hslinktext .= getName( $prow );
				$deathdate = $prow[deathdate] ? $prow[deathdate] : $prow[burialdate];
				if( $prow[deathdate] ) $abbrev = $text[deathabbr];
				elseif( $prow[burialdate] ) $abbrev = $text[burialabbr];
				$hstext = $deathdate ? " ($abbrev " . displayDate( $deathdate ) . ")" : "";
			}
			elseif( $prow[familyID] != NULL ) {
				$hslinktext .= "<a href=\"$familygroup_url" . "familyID=$prow[familyID]&amp;tree=$prow[gedcom]\">$text[family]: " . getFamilyName( $prow );
			}
			elseif( $prow[sourceID] != NULL ) {
				$sourcetext = $prow[title] ? "$text[source]: $prow[title]" : "$text[source]: $prow[sourceID]";
				$hslinktext .= "<a href=\"$showsource_url" . "sourceID=$prow[sourceID]&amp;tree=$prow[gedcom]\">$sourcetext";
			}
			elseif( $prow[repoID] != NULL ) {
				$repotext = $prow[reponame] ? "$text[repository]: $prow[reponame]" : "$text[repository]: $prow[repoID]";
				$hslinktext .= "<a href=\"$showrepo_url" . "repoID=$prow[repoID]&amp;tree=$prow[gedcom]\">$repotext";
			}
			else
				$hslinktext .= "<a href=\"$placesearch_url" . "psearch=$prow[personID]&amp;tree=$prow[gedcom]\">$prow[personID]";
			$hslinktext .= "</a>$hstext\n<br />\n";
		}
		mysql_free_result( $presult );

		$description = $hs[description];
		$notes = $hs[notes];

		$body .= "<tr><td valign=\"top\" class=\"databack\">";
		$hs[mediatypeID] = "headstones";
		$imgsrc = getSmallPhoto($hs);
      		$href = getMediaHREF($hs,0);

		if($imgsrc) {
			$body .= "<div class=\"media-img\"><div class=\"media-prev\" id=\"prev$hs[mediaID]\" style=\"display:none\"></div></div>\n";
			$body .= "<a href=\"$href\"";
			if( function_exists( imageJpeg ) && isPhoto($hs) )
				$body .= " onmouseover=\"showPreview('$hs[mediaID]','" . urlencode("$usefolder/$hs[path]") . "');\" onmouseout=\"closePreview('$hs[mediaID]');\" onclick=\"closePreview('$hs[mediaID]');\"";
			$body .= ">$imgsrc</a>\n";
		}
		else {
			$body .= "&nbsp;";
		}

		$body .= "</td>\n";

		$body .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\"><a href=\"$href\">$hs[description]</a><br />$hs[notes]&nbsp;</span></td>\n";
		$body .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$hs[status]&nbsp;</span></td>\n";
		$body .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$hs[plot]";
		if( $hs[latitude] || $hs[longitude] ) {
			if($hs['plot']) $body .= "<br />";
			$body .= "$text[latitude]: $hs[latitude], $text[longitude]: $hs[longitude]";
		}
		$body .= "&nbsp;</span></td>\n";
		$body .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$hslinktext&nbsp;</span></td>\n";
		$body .= "</tr>\n";
	}
	$body .= "<tr><td colspan='6'>$pagenav</td></tr>";
	$cemcount++;

	if( $subquery == "done" ) break;
}
$body .= "</table><br />\n";

if($map[key] && $map[pins])
	echo "<div id=\"map\" style=\"width: $map[hstw]; height: $map[hsth];margin-bottom:20px;\"></div>\n";
echo $body;
if($cemresult) mysql_free_result($cemresult);

tng_footer( "" );
?>
