<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
if(!$sourceID) {header( "Location: thispagedoesnotexist.html" ); exit;}
$textpart = "sources";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "personlib.php" );

$showsource_url = getURL( "showsource", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$getperson_url = getURL( "getperson", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$showalbum_url = getURL("showalbum",1);

$firstsection = 1;
$firstsectionsave = "";
$tableid = "";
$cellnumber = 0;

$query = "SELECT sourceID, title, shorttitle, author, publisher, actualtext, reponame, $sources_table.repoID as repoID, callnum, other FROM $sources_table LEFT JOIN $repositories_table on $sources_table.repoID = $repositories_table.repoID AND $sources_table.gedcom = $repositories_table.gedcom WHERE $sources_table.sourceID = \"$sourceID\" AND $sources_table.gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$srcrow = mysql_fetch_assoc($result);
if( !mysql_num_rows($result) ) {
	mysql_free_result($result);
	header( "Location: thispagedoesnotexist.html" );
	exit;
}
mysql_free_result($result);

$query = "SELECT count(personID) as ccount FROM $citations_table, $people_table
	WHERE $citations_table.sourceID = '$sourceID' AND $citations_table.gedcom = \"$tree\" AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
	AND living = '1'";
$sresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$srow = mysql_fetch_assoc( $sresult );
$srcrow[living] = $srow[ccount] ? 1 : 0;

if( !$srcrow[living] || $livedefault == 2 ||  ( !$livedefault && $allow_living_db && ( !$assignedtree || $assignedtree == $srcrow[gedcom] ) ) )
	$srcrow[allow_living] = 1;
else
	$srcrow[allow_living] = 0;
$rightbranch = 1;
mysql_free_result( $sresult );

$srcnotes = getNotes( $sourceID, "S" );
getCitations( $sourceID );

$logstring = "<a href=\"$showsource_url" . "sourceID=$sourceID&amp;tree=$tree\">" . xmlcharacters("$text[source] $srcrow[title] ($sourceID)") . "</a>";
writelog($logstring);
preparebookmark($logstring);

$flags[tabs] = $tngconfig[tabs];
$headtext = $srcrow[sourceID] ? "$srcrow[title] ($srcrow[sourceID])" : $srcrow[title];
tng_header( $headtext, $flags );

$srcmedia = getMedia( $srcrow, "S" );
$photostr = showSmallPhoto( $sourceID, $srcrow[title], $srcrow[allow_living], 0 );
echo tng_DrawHeading( $photostr, $headtext, "" );
echo tng_coreicons();

$sourcetext = "";
$sourcetext .= "<ul style=\"margin-left: 0px; padding-left: 0;\">\n";
$sourcetext .= beginSection("info");
$sourcetext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
if( $srcrow[title] )
	$sourcetext .= showEvent( array( "text"=>$text[title], "fact"=>$srcrow[title] ) );
if( $srcrow[shorttitle] )
	$sourcetext .= showEvent( array( "text"=>$text[shorttitle], "fact"=>$srcrow[shorttitle] ) );
//if( $srcrow[type] ) $sourcetext .= showEvent( array( "text"=>$text[type], "fact"=>$srcrow[type] ) );
if( $srcrow[author] )
	$sourcetext .= showEvent( array( "text"=>$text[author], "fact"=>$srcrow[author] ) );
if( $srcrow[publisher] )
	$sourcetext .= showEvent( array( "text"=>$text[publisher], "fact"=>$srcrow[publisher] ) );
if( $srcrow[callnum] )
	$sourcetext .= showEvent( array( "text"=>$text[callnum], "fact"=>$srcrow[callnum] ) );
if( $srcrow[reponame] )
	$sourcetext .= showEvent( array( "text"=>$text[repository], "fact"=>"<a href=\"$showrepo_url" . "repoID=$srcrow[repoID]&amp;tree=$tree\">$srcrow[reponame]</a>" ) );
if( $srcrow[other] )
	$sourcetext .= showEvent( array( "text"=>$text[other], "fact"=>$srcrow[other] ) );

//do custom events
resetEvents();
doCustomEvents($sourceID,"S");

ksort( $events );
foreach( $events as $event )
	$sourcetext .= showEvent( $event );
if( $allow_admin && $allow_edit )
	$sourcetext .= showEvent( array( "text"=>$text[sourceid], "date"=>$sourceID, "place"=>"<a href=\"$cms[tngpath]" . "admin/editsource.php?sourceID=$sourceID&amp;tree=$tree&amp;cw=1\" target=\"_blank\">$text[edit]</a>", "np"=>1  ) );
else
	$sourcetext .= showEvent( array( "text"=>$text[sourceid], "date"=>$sourceID  ) );

if( $srcrow[actualtext] ) {
	if( !$srcrow[allow_living] ) $srcrow[actualtext] = $text[livingdoc];
	$sourcetext .= showEvent( array( "text"=>$text[text], "fact"=>$srcrow[actualtext] ) );
}

if( $ioffset ) {
	$ioffsetstr = "$ioffset, ";
	$newioffset = $ioffset + 1;
}
else {
	$ioffsetstr = "";
	$newioffset = "";
}
if( $foffset ) {
	$foffsetstr = "$foffset, ";
	$newfoffset = $foffset + 1;
}
else {
	$foffsetstr = "";
	$newfoffset = "";
}

$query = "SELECT DISTINCT $citations_table.persfamID, $citations_table.gedcom, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, branch FROM $citations_table, $people_table WHERE $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom AND $citations_table.gedcom = \"$tree\" AND $citations_table.sourceID = '$sourceID' ORDER BY lastname, firstname LIMIT $ioffsetstr" . ($maxsearchresults + 1);
$sresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numrows = mysql_num_rows( $sresult );
$sourcelinktext = "";
$noneliving = 1;
while( $srow = mysql_fetch_assoc( $sresult ) ) {
	if( $sourcelinktext ) $sourcelinktext .= "\n";
	if( !$srow[living] || $livedefault == 2 || ( !$livedefault && $allow_living_db && ( !$assignedtree || $assignedtree == $srow[gedcom] ) ) )
		$srow[allow_living] = 1;
	else {
		$noneliving = 0;
		$srow[allow_living] = 0;
	}
	$sourcelinktext .= "<a href=\"$getperson_url" . "personID=$srow[persfamID]&amp;tree=$srow[gedcom]\">";
	$sourcelinktext .= getName( $srow );
	$sourcelinktext .= "</a>";
}
if( $numrows > $maxsearchresults ) 
	$sourcelinktext .= "\n[<a href=\"$showsource_url" . "sourceID=$sourceID&amp;tree=$tree&amp;foffset=$foffset&amp;ioffset=" . ($newioffset + $maxsearchresults) . "\">$text[moreind]</a>]";
mysql_free_result( $sresult );

$query = "SELECT DISTINCT $citations_table.persfamID, $citations_table.gedcom, familyID, husband, wife, living, branch FROM $citations_table, $families_table WHERE $citations_table.persfamID = $families_table.familyID AND $citations_table.gedcom = $families_table.gedcom AND $citations_table.gedcom = \"$tree\" AND $citations_table.sourceID = '$sourceID' ORDER BY familyID LIMIT $foffsetstr" . ($maxsearchresults + 1);
$sresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numrows = mysql_num_rows( $sresult );
$noneliving = 1;
while( $srow = mysql_fetch_assoc( $sresult ) ) {
	if( $sourcelinktext ) $sourcelinktext .= "\n";
	if( !$srow[living] || $livedefault == 2 || ( !$livedefault && $allow_living_db && ( !$assignedtree || $assignedtree == $srow[gedcom] ) ) )
		$srow[allow_living] = 1;
	else {
		$noneliving = 0;
		$srow[allow_living] = 0;
	}
	$sourcelinktext .= "<a href=\"$familygroup_url" . "familyID=$srow[familyID]&amp;tree=$srow[gedcom]\">$text[family]: " . getFamilyName( $srow ) . "</a>";
}
if( $numrows >= $maxsearchresults ) 
	$sourcelinktext .= "\n[<a href=\"$showsource_url" . "sourceID=$sourceID&amp;tree=$tree&amp;ioffset=$ioffset&amp;foffset=" . ($newfoffset + $maxsearchresults) . "\">$text[morefam]</a>]";
mysql_free_result( $sresult );

if( $sourcelinktext )
	$sourcetext .= showEvent( array( "text"=>$text[indlinked], "fact"=>$sourcelinktext ) );

$sourcetext .= showBreak();
$sourcetext .= "</table>\n";
$sourcetext .= endSection("info");

$media = doMediaSection($sourceID,$srcmedia);
$sourcetext .= $media;

$notes = buildNotes( $srcnotes, "" );
if( $notes ) { 
	$sourcetext .= beginSection("notes");
	$sourcetext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
	$sourcetext .= "<tr>\n";
	$sourcetext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\" id=\"notes1\"><span class=\"fieldname\">&nbsp;$text[notes]&nbsp;</span></td>\n";
	$sourcetext .= "<td valign=\"top\" class=\"databack\" colspan=\"2\"><span class=\"normal\">$notes</span></td>\n";
	$sourcetext .= "</tr>\n";
	$sourcetext .= "</table>\n";
	$sourcetext .= endSection("notes");
}
$sourcetext .= "</ul>\n";

$tng_alink = $tng_plink = "lightlink";
if( $notes || $media ) {
	if( $tngconfig[istart] )
		$tng_plink = "lightlink3";
	else
		$tng_alink = "lightlink3";
	$innermenu = "<a href=\"#\" class=\"$tng_plink\" onclick=\"return infoToggle('info');\" id=\"tng_plink\">$text[srcinfo]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	if( $media )
		$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('media');\" id=\"tng_mlink\">$text[media]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	if( $notes )
		$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('notes');\" id=\"tng_nlink\">$text[notes]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"#\" class=\"$tng_alink\" onclick=\"return infoToggle('all');\" id=\"tng_alink\">$text[all]</a>\n";
}
else
	$innermenu = "<span class=\"lightlink3\" id=\"tng_plink\">$text[srcinfo]</span>\n";

echo tng_menu( "S", "source", $sourceID, $innermenu );
?>	
<script type="text/javascript">
function innerToggle(part,subpart,subpartlink) {
	if( part == subpart )
		turnOn(subpart,subpartlink);
	else
		turnOff(subpart,subpartlink);
}

function turnOn(subpart,subpartlink) {
	document.getElementById(subpartlink).className = 'lightlink3';
	document.getElementById(subpart).style.display = "";
}

function turnOff(subpart,subpartlink) {
	document.getElementById(subpartlink).className = 'lightlink';
	document.getElementById(subpart).style.display = "none";
}

function infoToggle(part) {
	if( part == "all" ) {
		document.getElementById("info").style.display = "";
<?php
	if( $media ) {
		echo "document.getElementById(\"media\").style.display = \"\";\n";
		echo "document.getElementById(\"tng_mlink\").className = 'lightlink';\n";
	}
	if( $notes ) {
		echo "document.getElementById(\"notes\").style.display = \"\";\n";
		echo "document.getElementById(\"tng_nlink\").className = 'lightlink';\n";
	}
?>
		document.getElementById("tng_alink").className = 'lightlink3';
		document.getElementById("tng_plink").className = 'lightlink';
	}
	else {	
		innerToggle(part,"info","tng_plink");
<?php
	if( $media )
		echo "innerToggle(part,\"media\",\"tng_mlink\");\n";
	if( $notes )
		echo "innerToggle(part,\"notes\",\"tng_nlink\");\n";
?>
		document.getElementById("tng_alink").className = 'lightlink';
	}
	return false;
}
</script>

<?php
	echo $sourcetext;
?>
<br />

<?php
$flags[more] = "\n<script language=\"JavaScript\" type=\"text/javascript\">\n
var blocks = $$('td.indleftcol');
var elementcw = $('info1') ? $('info1').clientWidth : $('$firstsectionsave" . "1').clientWidth;
var elementcwadj = elementcw - 8;
blocks.each(function(item) {
	$(item).width = elementcwadj;
});\n";
	
$flags[more] .= "</script>";
tng_footer( $flags );
?>
