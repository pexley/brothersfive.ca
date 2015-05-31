<?php
include("begin.php");
include($subroot . "mapconfig.php");
include($cms['tngpath'] . "genlib.php");
//if(!$cemeteryID) {header( "Location: thispagedoesnotexist.html" ); exit;}
$textpart = "headstones";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "functions.php");

$showmap_url = getURL( "showmap", 1 );
$showmedia_url = getURL( "showmedia", 1 );
$getperson_url = getURL( "getperson", 1 );
$showsource_url = getURL( "showsource", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$placesearch_url = getURL( "placesearch", 1 );
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

if($cemeteryID) {
	$query = "SELECT cemname, city, county, state, country, maplink, notes, latitude, longitude, zoom FROM $cemeteries_table WHERE cemeteryID = \"$cemeteryID\"";
	$cemresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$cemetery = mysql_fetch_assoc($cemresult);
	mysql_free_result($cemresult);

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
}
else
	$location = $text['nocemetery'];

$logstring = "<a href=\"$showmap_url" . "cemeteryID=$cemeteryID&amp;tree=$tree\">$location</a>";
writelog($logstring);
preparebookmark($logstring);

$size = @GetImageSize( "$rootpath$headstonepath/$cemetery[maplink]" );

if( $map[key] )
	$flags[scripting] = "<script src=\"http://maps.google.com/maps?file=api&amp;v=2$text[glang]$mcharsetstr&amp;key=$map[key]\" language=\"Javascript\" type=\"text/javascript\"></script>\n";
tng_header( $location, $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_hs.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $location; ?><br clear="all" /></p>
<?php
echo tng_coreicons();

$hiddenfields[] = array('name' => 'cemetery', 'value' => $cemeteryID);
echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'showmap', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields));

if($cemeteryID) {
	if( $allow_admin && $allow_edit )
		echo "<p><a href=\"$cms[tngpath]" . "admin/editcemetery.php?cemeteryID=$cemeteryID&cw=1\" target=\"_blank\">$text[editcem]</a></p>\n";

	if( $cemetery[notes] )
		echo "<p><strong>$text[notes]:</strong> " . nl2br(insertLinks($cemetery[notes])) . "</p>";

	if( !$map[key] && ($cemetery[latitude] || $cemetery[longitude]) )
		echo "<p><strong>$text[latitude]:</strong> $cemetery[latitude], <strong>$text[longitude]:</strong> $cemetery[longitude]</p>";

	if( $cemetery[maplink] )
		echo "<img src=\"$headstonepath/$cemetery[maplink]\" border=\"0\" $size[3] alt=\"$cemetery[cemname]\"><br/><br/>\n";

	$body = "";
	$cemcoords = false;
	if( $map[key] ) {
		$lat = $cemetery[latitude];
		$long = $cemetery[longitude];
		$zoom = $cemetery[zoom] ? $cemetery[zoom] : 10;
		if( !$zoom ) $zoom = 10;
		//RM - set placeleve = 2 to provide this value to the map for all cemeteries
		$pinplacelevel = $pinplacelevel2;

		// if we have one, add it
		if($lat && $long) {
		 	$cemeteryplace = "$cemetery[city], $cemetery[county], $cemetery[state], $cemetery[country]";
		 	$localballooncemeteryname = htmlspecialchars($cemetery[cemname], ENT_QUOTES);
		 	$localballooncemeteryplace = htmlspecialchars($cemeteryplace, ENT_QUOTES);
		 	$remoteballoontext = htmlspecialchars(str_replace($banish, $banreplace, "$cemetery[cemname], $cemeteryplace"), ENT_QUOTES);
			$locations2map[$l2mCount] = array("zoom"=>$zoom,"lat"=>$lat,"long"=>$long,"pinplacelevel"=>$pinplacelevel,"htmlcontent"=>"<div class =\"normal\"  style=\"width:240px\">$localballooncemeteryname<br />$localballooncemeteryplace</div>");
			$cemcoords = true;
			$body .= "<div style=\"padding-bottom:15px\"><a href=\"http://maps.google.com/maps?f=q$text[glang]$mcharsetstr&amp;q=$lat,$long($codedcemname, $codedcemcity, $codedcemcounty, $codedcemstate, $codedcemcountry)&amp;z=$zoom&amp;om=1&amp;iwloc=addr\" target=\"_blank\"><img src=\"$cms[tngpath]" . "googlemaps/numbered_marker.php?image=$pinplacelevel2.png&amp;text=1&amp;name=pin$pinplacelevel" . "no1.png\" alt=\"\" border=\"0\"></a>";
			$map[pins]++;
	        $body .= "<span><strong>$text[latitude]:</strong> $lat, <strong>$text[longitude]:</strong> $long</span></div>";
		}
	}
	$typeclause = "";
}
else
	$typeclause = " AND mediatypeID = \"headstones\"";

$query = "SELECT mediaID, thumbpath, description, notes, usecollfolder, mediatypeID, path, form from $media_table WHERE cemeteryID = \"$cemeteryID\"$typeclause AND linktocem = \"1\"";
$hsresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( mysql_num_rows( $hsresult ) ) {
	$i = 1;
	$body .= "<span class=\"subhead\"><b>$text[cemphotos]</b></span><br /><br />";

	$body .= "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\">\n";
	$body .= "<tr><td class=\"fieldnameback\">&nbsp;</td>\n";
	$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[thumb]</strong>&nbsp;</span></td>\n";
	$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[description]</strong>&nbsp;</span></td>\n";

	while( $hs = mysql_fetch_assoc( $hsresult ) ) {
		$mediatypeID = $hs['mediatypeID'];
		$usefolder = $hs['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
		$description = $hs[description];
		$notes = nl2br($hs[notes]);

		$imgsrc = getSmallPhoto($hs);

		$body .= "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$i</span></td>";
		$body .= "<td valign=\"top\" class=\"databack\">";
		if($imgsrc) {
			$body .= "<div class=\"media-img\"><div class=\"media-prev\" id=\"prev$hs[mediaID]\" style=\"display:none\"></div></div>\n";
			$body .= "<a href=\"$showmedia_url" . "mediaID=$hs[mediaID]\"";
			if( function_exists( imageJpeg ) )
				$body .= " onmouseover=\"showPreview('$hs[mediaID]','" . urlencode("$usefolder/$hs[path]") . "');\" onmouseout=\"closePreview('$hs[mediaID]');\" onclick=\"closePreview('$hs[mediaID]');\"";
			$body .= ">$imgsrc</a>\n";
		}
		else {
			$body .= "&nbsp;";
		}

		$body .= "</td>\n";
		$body .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\">";
		$body .= "<a href=\"$showmedia_url" . "mediaID=$hs[mediaID]\">$description</a><br/>$notes&nbsp;</span></td></tr>\n";
		$i++;
	}
	$body .= "</table><br />\n";
}
mysql_free_result( $hsresult );

$body .= "<span class=\"subhead\"><b>$text[headstone]</b></span><br /><br />\n";

if($tree) {
	$wherestr = " AND ($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\")";
	$wherestr2 = " AND $medialinks_table.gedcom = \"$tree\"";
}
else
	$wherestr = $wherestr2 = "";

$query = "SELECT DISTINCT $media_table.mediaID, description, notes, path, thumbpath, status, plot, showmap, usecollfolder, mediatypeID, latitude, longitude, form, abspath, newwindow
	FROM $media_table LEFT JOIN $medialinks_table on $media_table.mediaID = $medialinks_table.mediaID
	WHERE cemeteryID = \"$cemeteryID\"$typeclause $wherestr AND linktocem != \"1\" ORDER BY description LIMIT $newoffset" . $maxsearchresults;
$hsresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $hsresult );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(DISTINCT $media_table.mediaID) as hscount FROM $media_table LEFT JOIN $medialinks_table on $media_table.mediaID = $medialinks_table.mediaID WHERE cemeteryID = \"$cemeteryID\"$typeclause $wherestr AND linktocem != \"1\"";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[hscount];
}
else
	$totrows = $numrows;

$pagenav = get_browseitems_nav( $totrows, $showmap_url . "cemeteryID=$cemeteryID&amp;tree=$tree&amp;offset", $maxsearchresults, 5 );
if( $pagenav ) $body .= "<p>$pagenav</p>";

$body .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" width=\"100%\">\n";
$body .= "<tr><td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[thumb]</b></span></td>";
$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[description]</b></span></td>";
$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[status]</b></span></td>";
$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[location]</b></span></td>";
$body .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>$text[name] ($text[diedburied])</b></span></td></tr>";

while( $hs = mysql_fetch_assoc( $hsresult ) )
{
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
	while( $prow = mysql_fetch_assoc( $presult ) )
	{
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
	$notes = nl2br( $hs[notes] );

	$body .= "<tr><td valign=\"top\" class=\"databack\" align=\"center\" style=\"width:$thumbmaxw" . "px\">";
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

	$body .= "<td valign=\"top\" class=\"databack\"><span class=\"normal\"><a href=\"$href\">$hs[description]</a><br />$notes&nbsp;</span></td>\n";
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
$body .= "</table><br />\n";
if( $pagenav ) $body .= "<p>$pagenav</p>";

if($map[key] && $map[pins])
	echo "<div id=\"map\" style=\"width: $map[hstw]; height: $map[hsth];margin-bottom:20px;\"></div>\n";
echo $body;

tng_footer( "" );
?>
