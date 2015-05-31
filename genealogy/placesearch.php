<?php
include("begin.php");
//session_cache_limiter('public');
include($subroot . "mapconfig.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "search";
if( !$psearch ) exit;
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "personlib.php" );

$searchform_url = getURL( "searchform", 1 );
$search_url = getURL( "search", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$getperson_url = getURL( "getperson", 1 );
$showtree_url = getURL( "showtree", 1 );
$pedigree_url = getURL( "pedigree", 1 );
$showmedia_url = getURL( "showmedia", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showsource_url = getURL( "showsource", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$showalbum_url = getURL("showalbum",1);

@set_time_limit(0);

if (get_magic_quotes_gpc() == 0) {
	$psearchns = $psearch;
	$psearch = addslashes($psearch);
}
else
	$psearchns = stripslashes($psearch);
$querystring = $psearchns;
$cutoffstr = "personID = \"$psearch\"";
$whatsnew = 0;

function processEvents($prefix, $stdevents, $displaymsgs) {
	global $eventtypes_table, $text, $tree, $livedefault, $allow_living_db, $assignedtree, $people_table, $families_table, $trees_table, $offset, $page, $psearch, $maxsearchresults;
	global $placesearch_url, $psearchns, $urlstring, $cms, $familygroup_url, $pedigree_url, $getperson_url, $events_table;

	$successcount = 0;
	$allwhere = "";
	if($prefix == "I") {
		$table = $people_table;
		$peoplejoin1 = $peoplejoin2 = "";
		$idfield = "personID";
		$idtext = "personid";
		$namefield = "lastfirst";
	}
	elseif($prefix == "F") {
		$table = $families_table;
		$peoplejoin1 = " LEFT JOIN $people_table as p1 ON $families_table.gedcom = p1.gedcom AND p1.personID = $families_table.husband";
		$peoplejoin2 = " LEFT JOIN $people_table as p2 ON $families_table.gedcom = p2.gedcom AND p2.personID = $families_table.wife";
		$idfield = "familyID";
		$idtext = "familyid";
		$namefield = "family";
	}

	if( $tree ) {
		$allwhere .= " AND $table.gedcom=\"$tree\"";
	}

	if( $livedefault < 2 && ( !$allow_living_db || $assignedtree ) ) {
		if( $allow_living_db ) {
			if( $assignedbranch )
				$allwhere .= " AND ($table.living != 1 OR ($table.gedcom = \"$assignedtree\" AND $table.branch LIKE \"%$assignedbranch%\") )";
			else
				$allwhere .= " AND ($table.living != 1 OR $table.gedcom = \"$assignedtree\")";
		}
		else
			$allwhere .= " AND $table.living != 1";
	}

	$max_browsesearch_pages = 5;
	if( $offset ) {
		$offsetplus = $offset + 1;
		$newoffset = "$offset, ";
	}
	else {
		$offsetplus = 1;
		$newoffset = "";
		$page = 1;
	}

	$tngevents = $stdevents;
	$custevents = array();
	$query = "SELECT tag, eventtypeID, display FROM $eventtypes_table
		WHERE keep=\"1\" AND type=\"$prefix\" ORDER BY display";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	while( $row = mysql_fetch_assoc( $result ) ) {
		$eventtypeID = $row['eventtypeID'];
		array_push( $tngevents, $eventtypeID );
		array_push( $custevents, $eventtypeID );
		$displaymsgs[$eventtypeID] = getEventDisplay($row['display']);
	}
	mysql_free_result($result);

	foreach( $tngevents as $tngevent ) {
		$eventsjoin = "";
		$allwhere2 = "";
		$placetxt = $displaymsgs[$tngevent];

		if(in_array($tngevent,$custevents)) {
			$eventsjoin = ", $events_table";
			$allwhere2 .= " AND $table.$idfield = $events_table.persfamID AND $table.gedcom = $events_table.gedcom AND eventtypeID = \"$tngevent\"";
			$tngevent = "event";
		}

		$datefield = $tngevent . "date";
		$datefieldtr = $tngevent . "datetr";
		$place = $tngevent . "place";
		$allwhere2 .= " AND $place = '$psearch'";

		if($prefix == "F") {
			$query = "SELECT $families_table.ID, $families_table.familyID, $families_table.living, $families_table.branch, p1.lastname as p1lastname, p2.lastname as p2lastname, $place, $datefield, $families_table.gedcom, treename
				FROM ($families_table, $trees_table $eventsjoin) $peoplejoin1 $peoplejoin2
				WHERE $families_table.gedcom = $trees_table.gedcom $allwhere $allwhere2
				ORDER BY $datefieldtr LIMIT $newoffset" . $maxsearchresults;

		}
		elseif($prefix == "I") {
			$query = "SELECT $people_table.ID, $people_table.personID, lastname, lnprefix, firstname, $people_table.living, $people_table.branch, prefix, suffix, nameorder, $place, $datefield, $people_table.gedcom, treename
				FROM ($people_table, $trees_table $eventsjoin)
				WHERE $people_table.gedcom = $trees_table.gedcom $allwhere $allwhere2
				ORDER BY lastname, firstname, $datefieldtr, lastname, firstname LIMIT $newoffset" . $maxsearchresults;
		}

		//echo $query . "<br><br>";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$numrows = mysql_num_rows( $result );

		//if results, do again w/o pagination to get total
		if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
			$query = "SELECT count($idfield) as rcount
				FROM ($table, $trees_table $eventsjoin)
				WHERE $table.gedcom = $trees_table.gedcom $allwhere $allwhere2";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$countrow = mysql_fetch_assoc($result2);
			$totrows = $countrow['rcount'];
		}
		else
			$totrows = $numrows;

		if ( $numrows ) {
			echo "<p><span class=\"subhead\"><strong>" . $placetxt . "</strong></span></p>";
			$numrowsplus = $numrows + $offset;
			$successcount++;

			echo "<p>$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows</p>";

			$pagenav = get_browseitems_nav( $totrows, "$placesearch_url" . "$urlstring&amp;psearch=" . urlencode($psearchns) . "&amp;offset", $maxsearchresults, $max_browsesearch_pages );
			echo "<p>$pagenav</p>";
?>

	<table cellpadding="3" cellspacing="1" border="0" width="100%">
		<tr>
			<td class="fieldnameback"><span class="fieldname">&nbsp;</span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $text[$namefield]; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" colspan="2"><span class="fieldname">&nbsp;<b><?php echo $placetxt; ?></b>&nbsp;</span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $text[$idtext]; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text['tree']; ?></b>&nbsp;</span></td>
		</tr>

<?php
			$i = $offsetplus;
			$chartlinkimg = @GetImageSize($cms[tngpath] . "Chart.gif");
			$chartlink = "<img src=\"$cms[tngpath]" . "Chart.gif\" border=\"0\" $chartlinkimg[3]>";
			while( $row = mysql_fetch_assoc($result))
			{
				if( !$row[living] || $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $row[gedcom]) && checkbranch( $row[branch] ) ) ) {
					$row[allow_living] = 1;
					$placetxt = $row[$place] ? "$row[$place]" : "";
					$dateval = $row[$datefield];
				}
				else
					$dateval = $placetxt = $livingOK = "";
				echo "<tr>";

				echo "<td class=\"databack\"><span class=\"normal\">$i</span></td>\n";
				$i++;
				echo "<td class=\"databack\"><span class=\"normal\">";
				if($prefix == "F") {
					echo "<a href=\"$familygroup_url" . "familyID=$row[familyID]&amp;tree=$row[gedcom]\">$row[p1lastname] / $row[p2lastname]</a>";
				}
				elseif($prefix == "I") {
					$name = getNameRev( $row );
					echo "<a href=\"$pedigree_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$chartlink</a> <a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$name</a>";
				}
				echo "&nbsp;</span></td>";
				echo "<td class=\"databack\"><span class=\"normal\">&nbsp;" . displayDate($dateval) . "</span></td><td class=\"databack\"><span class=\"normal\">$placetxt&nbsp;</span></td>";
				echo "<td class=\"databack\"><span class=\"normal\">$row[$idfield] </span></td>";
				echo "<td class=\"databack\"><span class=\"normal\"><a href=\"$showtree_url" . "tree=$row[gedcom]\">$row[treename]</a>&nbsp;</span></td>";
				echo "</tr>\n";
			}
			mysql_free_result($result);
?>

	</table><br/>

<?php
			echo "<p>$pagenav</p><br />";
		}
	}
	return $successcount;
}

//don't allow default tree here
$tree = $orgtree;
$tngconfig['istart'] = 0;

if($tree) {
	$urlstring = "&amp;tree=$tree";
	$wherestr2 = " AND $places_table.gedcom = \"$tree\" ";

	$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
	$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$treerow = mysql_fetch_assoc($treeresult);
	mysql_free_result($treeresult);

	$querystring .= " $text[and] tree $text[equals] $treerow[treename] ";
}
else {
	$urlstring = $wherestr2 = "";
}

$logstring = "<a href=\"$placesearch_url" . "psearch=$psearchns$urlstring\">$text[searchresults] $querystring</a>";
writelog($logstring);
preparebookmark($logstring);

if( $map[key] )
	$flags[scripting] = "<script src=\"http://maps.google.com/maps?file=api&amp;v=2$text[glang]$mcharsetstr&amp;key=$map[key]\" language=\"Javascript\" type=\"text/javascript\"></script>\n";
tng_header( $psearchns, $flags );

$placemedia = getMedia( $psearch, "L" );
$photostr = showSmallPhoto( $psearch, $psearch, 1, 0 );

echo tng_DrawHeading( $photostr, $psearchns, "" );
echo tng_coreicons();

//show the notes and media for each tree (if none specified)

//first do media
$pquery = "SELECT placelevel,latitude,longitude,zoom,notes,$places_table.gedcom,treename FROM $places_table LEFT JOIN $trees_table on $places_table.gedcom = $trees_table.gedcom WHERE place = \"$psearch\"$wherestr2";
$presult = mysql_query($pquery) or die ("$admtext[cannotexecutequery]: $pquery");

$altstr = ", altdescription, altnotes";
$mapdrawn = false;
while( $prow = mysql_fetch_assoc( $presult ) ) {
	if( $prow[notes] || $prow[latitude] || $prow[longitude] ) {
		if( ($prow[latitude] || $prow[longitude]) && $map[key] && !$mapdrawn ) {
			echo "<br /><div id=\"map\" style=\"width: $map[hstw]; height: $map[hsth]; margin-bottom:20px;\"></div>\n";
			$usedplaces = array();
			$mapdrawn = true;
		}
		echo "<br /><span><strong>$text[tree]:</strong> $prow[treename]</span><br />\n";
		if( $prow[notes] )
			echo "<span><strong>$text[notes]:</strong> " . nl2br($prow[notes]) . "</span><br />";

		if( $map[key] ) {
			$lat = $prow[latitude];
			$long = $prow[longitude];
			$zoom = $prow[zoom] ? $prow[zoom] : 10;
			$placelevel = $prow[placelevel] ? $prow[placelevel] : "0";
			$pinplacelevel = ${"pinplacelevel" . $placelevel};
			$placeleveltext = $placelevel != "0" ? $admtext[level.$placelevel] . "&nbsp;:&nbsp;" : "";
			$codedplace = htmlspecialchars(str_replace($banish, $banreplace, $psearchns), ENT_QUOTES);
			if($lat && $long) {
               			$uniqueplace = $psearch . $lat . $long;
				if($map[showallpins] || !in_array($uniqueplace,$usedplaces)) {
					$usedplaces[] = $uniqueplace;
					$locations2map[$l2mCount]= array("pinplacelevel"=>$pinplacelevel,"lat"=>$lat,"long"=>$long,"zoom"=>$zoom,"htmlcontent"=>"<div class =\"normal\"  style=\"width:240px\">$placeleveltext<br />$codedplace</div>");
					$l2mCount++;
				}
			}

			echo "<a href=\"http://maps.google.com/maps?f=q$text[glang]$mcharsetstr&amp;q=$lat,$long($codedplace)&amp;z=12&amp;om=1&amp;iwloc=addr\" target=\"_blank\"><img src=\"$cms[tngpath]" . "googlemaps/numbered_marker.php?image=$pinplacelevel.png&amp;text=$l2mCount&amp;name=pin$pinplacelevel" . "no$l2mCount.png\" alt=\"\" border=\"0\" /></a><strong>$placeleveltext</strong><span class=\"normal\"><strong>$text[latitude]:</strong> $prow[latitude], <strong>$text[longitude]:</strong> $prow[longitude]</span><br /><br />";
			$map[pins]++;
		}
		elseif( $prow[latitude] || $prow[longitude] )
			echo "<span><strong>$text[latitude]:</strong> $prow[latitude], <strong>$text[longitude]:</strong> $prow[longitude]</span><br /><br />";
	}
}
mysql_free_result($presult);

$media = doMediaSection($psearch,$placemedia);
if($media) {
	echo "<p><span class=\"subhead\"><strong>$text[media]</strong></span></p>";
	echo "<ul style=\"margin-left: 0px; padding-left: 0;\">\n$media</ul>";
}

$successcount = 0;

//then loop over events like anniversaries
$stdevents = array("birth","altbirth","death","burial");
$displaymsgs = array("birth" => $text['born'],"altbirth"=> $text['christened'],"death"=> $text['died'],"burial"=> $text['buried']);
//$dontdo = array("ADDR","BIRT","CHR","DEAT","BURI","NAME","NICK","TITL","NSFX");
if($allow_lds) {
	array_push($stdevents,"endl", "bapt");
	$displaymsgs['endl'] = $text['endowedlds'];
	$displaymsgs['bapt'] = $text['baptizedlds'];
}
$successcount += processEvents("I",$stdevents,$displaymsgs);

$stdevents = array("marr","div");
$displaymsgs = array("marr" => $text['married'],"div"=> $text['divorced']);
if($allow_lds) {
	array_push($stdevents,"seal");
	$displaymsgs['seal'] = $text['sealedslds'];
}
$successcount += processEvents("F",$stdevents,$displaymsgs);

if( !$successcount )
	echo "<p>$text[noresults].</p>";

tng_footer( "" );
?>