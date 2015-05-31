<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
if(!$repoID) {header( "Location: thispagedoesnotexist.html" ); exit;}
$textpart = "sources";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "personlib.php" );

$showrepo_url = getURL( "showrepo", 1 );
$showsource_url = getURL( "showsource", 1 );
$getperson_url = getURL( "getperson", 1 );
$showalbum_url = getURL("showalbum",1);

$firstsection = 1;
$firstsectionsave = "";
$tableid = "";
$cellnumber = 0;

$query = "SELECT * FROM $repositories_table WHERE repoID = \"$repoID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$reporow = mysql_fetch_assoc($result);
if( !mysql_num_rows($result) ) {
	mysql_free_result($result);
	header( "Location: thispagedoesnotexist.html" );
	exit;
}
mysql_free_result($result);

$reporow[living] = 0;
$reporow[allow_living] = 1;

$reponotes = getNotes( $repoID, "R" );

$logstring = "<a href=\"$showrepo_url" . "repoID=$repoID&amp;tree=$tree\">$text[repo] $reporow[reponame] ($repoID)</a>";
writelog($logstring);
preparebookmark($logstring);

$flags[tabs] = $tngconfig[tabs];
tng_header( "$reporow[reponame] ($reporow[repoID])", $flags );

$repomedia = getMedia( $reporow, "R" );
$photostr = showSmallPhoto( $repoID, $reporow[reponame], $reporow[allow_living], 0 );
echo tng_DrawHeading( $photostr, "$reporow[reponame] ($reporow[repoID])", "" );
echo tng_coreicons();

$repotext = "";
$repotext .= "<ul style=\"margin-left: 0px; padding-left: 0;\">\n";
$repotext .= beginSection("info");
$repotext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
if( $reporow[reponame] )
	$repotext .= showEvent( array( "text"=>$text[name], "fact"=>$reporow[reponame] ) );
if( $reporow[addressID] ) {
	$address = "";
	$query = "SELECT address1, address2, city, state, zip, country FROM $address_table WHERE addressID = \"$reporow[addressID]\" AND gedcom = \"$tree\"";
	$addrresults = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$addr = mysql_fetch_assoc( $addrresults );
	if( $addr[address1] ) $address .= $address ? "<br />$addr[address1]" : $addr[address1];
	if( $addr[address2] ) $address .= $address ?"<br />$addr[address2]" : $addr[address2];
	if( $addr[city] ) $address .= $address ? "<br />$addr[city]" : $addr[city];
	if( $addr[state] ) {
		if( $addr[city] ) 
			$address .= ", $addr[state]";
		else
			$address .= $address ? "<br />$addr[state]" : $addr[state];
	}
	if( $addr[zip] ) {
		if( $addr[city] || $addr[state] )
			$address .= " $addr[zip]";
		else
			$address .= $address ? "<br />$addr[zip]" : $addr[zip];
	}
	if( $addr[country] ) $address .= $address ? "<br />$addr[country]" : $addr[country];
	$repotext .= showEvent( array( "text"=>$text[address], "fact"=>$address ) );
}

//do custom events
resetEvents();
doCustomEvents($repoID,"R");

ksort( $events );
foreach( $events as $event )
	$repotext .= showEvent( $event );
if( $allow_admin && $allow_edit )
	$repotext .= showEvent( array( "text"=>$text[repoid], "date"=>$repoID, "place"=>"<a href=\"$cms[tngpath]" . "admin/editrepo.php?repoID=$repoID&amp;tree=$tree&amp;cw=1\" target=\"_blank\">$text[edit]</a>", "np"=>1  ) );
else
	$repotext .= showEvent( array( "text"=>$text[repoid], "date"=>$repoID  ) );

if( $soffset ) {
	$soffsetstr = "$soffset, ";
	$newsoffset = $soffset + 1;
}
else {
	$soffsetstr = "";
	$newsoffset = "";
}

$query = "SELECT sourceID, title FROM $sources_table WHERE gedcom = \"$tree\" AND repoID = '$repoID' ORDER BY title LIMIT $soffsetstr" . ($maxsearchresults + 1);
$sresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numrows = mysql_num_rows( $sresult );
$repolinktext = "";
while( $srow = mysql_fetch_assoc( $sresult ) ) {
	if( $repolinktext ) $repolinktext .= "\n";
	$repolinktext .= "<a href=\"$showsource_url" . "sourceID=$srow[sourceID]&amp;tree=$tree\">$srow[title]</a>";
}
if( $numrows >= $maxsearchresults ) 
	$repolinktext .= "\n[<a href=\"$showrepo_url" . "repoID=$repoID&amp;tree=$tree&amp;foffset=$foffset&amp;soffset=" . ($newsoffset + $maxsearchresults) . "\">$text[moresrc]</a>]";
mysql_free_result( $sresult );

if( $repolinktext )
	$repotext .= showEvent( array( "text"=>$text[indlinked], "fact"=>$repolinktext ) );

$repotext .= showBreak();
$repotext .= "</table>\n";
$repotext .= endSection("info");

$media = doMediaSection($repoID,$repomedia);
$repotext .= $media;

$notes = buildNotes( $reponotes, "" );
if( $notes ) { 
	$repotext .= beginSection("notes");
	$repotext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
	$repotext .= "<tr>\n";
	$repotext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\" id=\"notes1\"><span class=\"fieldname\">&nbsp;$text[notes]&nbsp;</span></td>\n";
	$repotext .= "<td valign=\"top\" class=\"databack\" colspan=\"2\"><span class=\"normal\">$notes</span></td>\n";
	$repotext .= "</tr>\n";
	$repotext .= "</table>\n";
	$repotext .= endSection("notes");
}
$repotext .= "</ul>\n";

$tng_alink = $tng_plink = "lightlink";
if( $notes ) {
	if( $tngconfig[istart] )
		$tng_plink = "lightlink3";
	else
		$tng_alink = "lightlink3";
	$innermenu = "<a href=\"#\" class=\"$tng_plink\" onclick=\"return infoToggle('info');\" id=\"tng_plink\">$text[repoinfo]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	if( $media )
		$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('media');\" id=\"tng_mlink\">$text[media]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	if( $notes )
		$innermenu .= "<a href=\"#\" class=\"lightlink\" onclick=\"return infoToggle('notes');\" id=\"tng_nlink\">$text[notes]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"#\" class=\"$tng_alink\" onclick=\"return infoToggle('all');\" id=\"tng_alink\">$text[all]</a>\n";
}
else
	$innermenu = "<span class=\"lightlink3\" id=\"tng_plink\">$text[repoinfo]</span>\n";

$rightbranch = 1;
echo tng_menu( "R", "repo", $repoID, $innermenu );
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
	echo $repotext;
?>
<br />

<?php
$flags[more] = "\n<script language=\"JavaScript\" type=\"text/javascript\">
var blocks = $$('td.indleftcol');
var elementcw = $('info1') ? $('info1').clientWidth : $('$firstsectionsave" . "1').clientWidth;
var elementcwadj = elementcw - 8;
blocks.each(function(item) {
	$(item).width = elementcwadj;
});\n";
	
$flags[more] .= "</script>";
tng_footer( $flags );
?>