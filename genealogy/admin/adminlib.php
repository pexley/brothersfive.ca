<?php
if(file_exists($subroot . "customconfig.php")) { include_once($subroot . "customconfig.php"); }
include_once("../globallib.php");
@include_once("../mediatypes.php");
@include_once("../tngfiletypes.php");
checkMaintenanceMode(1);
if($map[key])
	include_once("../googlemaps/googlemaplib.php");

$newbrowser = ereg("msie", $http_user_agent) && ereg("mac", $http_user_agent) ? 0 : 1;
$filepickerdims = "width=550,height=600";
$dims = "width=\"20\" height=\"20\"";

function tng_adminheader( $title, $flags ) {
	global $tng_title, $tng_version, $tng_date, $tng_copyright, $session_charset, $sitename, $dates;
	
	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n\n";
	echo "<!-- $tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright -->\n";
	echo "<html>\n<head>\n";
	$usesitename = $sitename ? $sitename . ": " : "";
	echo "<title>$usesitename" . "TNG Admin ($title)</title>\n";
	
	if( $session_charset )
		echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\">\n";
	if( $flags[tabs] )
		echo "<link href=\"../$flags[tabs]\" rel=\"stylesheet\" type=\"text/css\">\n";
	include( "adminmeta.php" );
	echo "<script type=\"text/javascript\">\n";
	echo "function toggleAll(flag) {\n";
	echo "for( var i = 0; i < document.form2.elements.length; i++ ) {\n";
	echo "if( document.form2.elements[i].type == \"checkbox\" ) {\n";
	echo "if( flag )\n";
	echo "document.form2.elements[i].checked = true;\n";
	echo "else\n";
	echo "document.form2.elements[i].checked = false;\n";
	echo "}\n}\n}\n";
	//echo "var MONTH_NAMES=new Array('$dates[JANUARY]','$dates[FEBRUARY]','$dates[MARCH]','$dates[APRIL]','$dates[MAY]','$dates[JUNE]','$dates[JULY]','$dates[AUGUST]','$dates[SEPTEMBER]','$dates[OCTOBER]','$dates[NOVEMBER]','$dates[DECEMBER]','$dates[JAN]','$dates[FEB]','$dates[MAR]','$dates[APR]','$dates[MAY]','$dates[JUN]','$dates[JUL]','$dates[AUG]','$dates[SEP]','$dates[OCT]','$dates[NOV]','$dates[DEC]');\n";
	echo "var closeimg = \"../tng_close.gif\";";
	echo "</script>\n";
	echo "<script type=\"text/javascript\" src=\"../prototype.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"../scriptaculous.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"../litbox.js\"></script>\n";
	initMediaTypes();
}

function getNewNumericID( $type, $field, $table ) {
	global $tree, $admtext;
	include( "prefixes.php" );

	eval( "\$prefix = \$$type" . "prefix;" );
	eval( "\$suffix = \$$type" . "suffix;" );
	if( $prefix ) {
		$prefixlen = strlen( $prefix ) + 1;
		$query = "SELECT MAX(0+SUBSTRING($field" . "ID,$prefixlen)) as newID FROM $table WHERE gedcom = \"$tree\" AND $field" . "ID LIKE \"$prefix%\"";
	}
	else
		$query = "SELECT MAX(0+SUBSTRING_INDEX($field" . "ID,'$suffix',1)) as newID FROM $table WHERE gedcom = \"$tree\"";

	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$maxrow = mysql_fetch_array( $result );
	mysql_free_result($result);

	$newID = $maxrow[newID] + 1;

	return $newID;
}

function getURL( $destination, $args ) {
	global $cms;

	if( $cms[support] )
		$url = $args ? "../../../$cms[url]=$destination&amp;" : "../../$cms[url]=$destination";
	else
		$url = $args ? "../$destination" . ".php?" : "../$destination" . ".php";

	return $url;
}

function initials( $name ) {
	$newname = "";
	$token = strtok( $name, " " );
	do{
		if( substr( $token, 0, 1 ) != "(" )  //In case there is a name in brackets, in which case ignore
			$newname .= substr( $token, 0, 1 ) . ".";
		$token = strtok(" ");
	}
	while( $token != "" );
	
	return ereg_replace("\"", "&#34;",$newname);
}

function getFamilyName( $row ) {
	global $admtext, $people_table;

	$hquery = "SELECT lnprefix, lastname, living, branch FROM $people_table WHERE personID = \"$row[husband]\" AND gedcom = \"$row[gedcom]\"";
	$hresult = mysql_query($hquery) or die ("$admtext[cannotexecutequery]: $hquery");
	$hrow = mysql_fetch_assoc( $hresult );
	$husbname = trim( "$hrow[lnprefix] $hrow[lastname]" );
	mysql_free_result( $hresult );

	$wquery = "SELECT lnprefix, lastname, living, branch FROM $people_table WHERE personID = \"$row[wife]\" AND gedcom = \"$row[gedcom]\"";
	$wresult = mysql_query($wquery) or die ("$admtext[cannotexecutequery]: $wquery");
	$wrow = mysql_fetch_assoc( $wresult );
	$wifename = trim( "$wrow[lnprefix] $wrow[lastname]" );
	mysql_free_result( $wresult );

	return "$husbname/$wifename ($row[familyID])";
}

function getName( $row ) {
	global $nameorder;
	
	$locnameorder = $row['nameorder'] ? $row['nameorder'] : ($nameorder ? $nameorder : 1);
	$lastname = trim( $row['lnprefix']." ".$row['lastname'] );
	$firstname = trim( $row['prefix']." ".$row['firstname'] );
	if( $locnameorder == 1 )
		$namestr = trim("$firstname $lastname");
	else
		$namestr = trim("$lastname $firstname");
	if( $row['suffix'] ) $namestr .= ", $row[suffix]";

	return ereg_replace("\"", "&#34;",$namestr);
}

function getNameRev( $row ) {
	global $nameorder;

	$locnameorder = $row['nameorder'] ? $row['nameorder'] : ($nameorder ? $nameorder : 1);
	$lastname = trim( $row['lnprefix']." ".$row['lastname'] );
	$firstname = trim( $row['prefix']." ".$row['firstname'] );
	if( $locnameorder == 1 ) {
		$namestr = $lastname;
		if($firstname) {
			if($lastname) $namestr .= ", ";
			$namestr .= $firstname;
		}
		if($row['suffix']) $namestr .= " ".$row['suffix'];
	}
	else {
		$namestr = trim( "$lastname $firstname" );
		if( $row['suffix'] ) $namestr .= ", $row[suffix]";
	}

	return ereg_replace("\"", "&#34;",$namestr);
}

function findhelp( $helpfile ) {
	global $mylanguage, $language;
	
	if( file_exists("../$mylanguage/$helpfile") )
		$helplang = $mylanguage;
	elseif( $language == "English" || file_exists("../$language/$helpfile") )
		$helplang = $language;
	else
		$helplang = "English";
		
	return $helplang;
}

function doMenu($tabs,$currtab,$innermenu=0) {
	global $newbrowser, $text;

	$tabctr = 0;
	$menu = "<div style=\"width:100%;\">\n";
	$menu .= "<div>\n";
  	$menu .= $newbrowser ? "<ul id=\"tngnav\">\n" : "<div id=\"tabs\">\n";

	if( is_array($tabs) ) {
		foreach($tabs as $tab) {
			if( $tab[0] )
				$menu .= doMenuItem( $tabctr++, $tab[1], "", $tab[2], $currtab, $tab[3] );
		}
	}
	$menu .= $newbrowser ? "</ul>\n" : "</div>\n";
	$menu .= "</div>\n";
	$menu .= "<div class=\"fieldnameback fieldname smaller\" style=\"margin:0px 2px 2px 2px;clear:both; padding: .2em 0px .3em .7em; border-right: 1px solid #777; border-bottom: 1px solid #777;\">\n";
	$menu .= $innermenu ? $innermenu : "&nbsp;";
	$menu .= "</div>\n";
	$menu .= "</div>\n";

	return $menu;
}

function checkReview($type) {
	global $people_table, $families_table, $temp_events_table, $assignedbranch, $assignedtree, $admtext;

	if( $type == "I" ) {
		$revwhere = "$people_table.personID = $temp_events_table.personID AND $people_table.gedcom = $temp_events_table.gedcom AND (type = \"I\" OR type = \"C\")";
		$table = $people_table;
	}
	else {
		$revwhere = "$families_table.familyID = $temp_events_table.familyID AND $families_table.gedcom = $temp_events_table.gedcom AND type = \"F\"";
		$table = $families_table;
	}
	if( $assignedtree )
		$revwhere .= " AND $temp_events_table.gedcom = \"$tree\"";
	if( $assignedbranch )
		$revwhere .= " AND branch LIKE \"%$assignedbranch%\"";
	$revquery = "SELECT count(tempID) as tcount FROM ($table, $temp_events_table) WHERE $revwhere";
	$revresult = mysql_query($revquery) or die ("$admtext[cannotexecutequery]: $revquery");
	$revrow = mysql_fetch_assoc($revresult);
	mysql_free_result( $revresult );

	return $revrow[tcount] ? " *" : "";
}

function deleteNote($noteID, $flag) {
	global $notelinks_table, $xnotes_table, $admtext;

	$query = "SELECT xnoteID FROM $notelinks_table WHERE ID=\"$noteID\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$nrow = mysql_fetch_assoc( $result );
	mysql_free_result( $result );
	
	$query = "SELECT count(ID) as xcount FROM $xnotes_table WHERE ID=\"$nrow[xnoteID]\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$xrow = mysql_fetch_assoc( $result );
	mysql_free_result( $result );
	
	if( $xrow[xcount] == 1 ) {
		$query = "DELETE FROM $xnotes_table WHERE ID=\"$nrow[xnoteID]\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
	if( $flag ) {
		$query = "DELETE FROM $notelinks_table WHERE ID=\"$noteID\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
}

function displayToggle($id,$state,$target,$headline,$subhead) {
	global $admtext;

	$rval = "<span class=\"subhead\"><a href=\"#\" onclick=\"return toggleSection('$target','$id');\" class=\"togglehead\" style=\"color:black\"><img src=\"../" . ($state ? "tng_collapse.gif" : "tng_expand.gif") . "\" title=\"$admtext[toggle]\" title=\"$admtext[toggle]\" alt=\"$admtext[toggle]\" width=\"15\" height=\"15\" border=\"0\" id=\"$id\">";
	$rval .= "<strong style=\"margin-left:5px\">$headline</strong></a></span><br />\n";
	if($subhead)
		$rval .= "<span class=\"normal\" style=\"margin-left:18px\"><i>$subhead</i></span><br />\n";

	return $rval;
}

function displayHeadline($headline,$icon,$menu,$message) {
	$rval = "<div class=\"lightback\">\n<div style=\"padding:5px\">\n";
	$rval .= "<img src=\"$icon\" width=\"40\" height=\"40\" border=\"1\" align=\"left\" title=\"$headline\" alt=\"$headline\" style=\"margin-right:10px\"><span class=\"subhead\" style=\"font-size:21px;\">$headline</span></div><br />\n";
	if( $message )
		$rval .= "<p class=\"normal\" style=\"color:#FF0000\">&nbsp;<em>" . urldecode($message) . "</em></p>\n";
	else
		$rval .= "<br />\n";
	$rval .= "$menu\n</div>\n";
	
	return $rval;
}

function displayListLocation($start,$pagetotal,$grandtotal) {
	global $admtext, $text;

	$rval = "<p>$admtext[matches]: $start $text[to] <span class=\"pagetotal\">$pagetotal</span> $text[of] <span class=\"restotal\">$grandtotal</span>";

	return $rval;
}

function getGenderIcon($gender, $valign) {
	global $text;

	$icon = "";
	if($gender) {
		if($gender == "M") $genderstr = "male";
		elseif($gender == "F") $genderstr = "female";
		if($genderstr)
			$icon = "<img src=\"../tng_$genderstr.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"" . $text[$genderstr] . "\" style=\"vertical-align: " . $valign . "px;\"/>&nbsp;";
	}
	return $icon;
}

function showEventRow($datefield,$placefield,$label) {
	global $admtext, $tree, $gotmore, $gotnotes, $gotcites, $row, $dims, $noclass;

	$notesicon = $gotnotes[$label] ? "tng_note_on.gif" : "tng_note.gif";
	$citesicon = $gotcites[$label] ? "tng_cite_on.gif" : "tng_cite.gif";
	$moreicon = $gotmore[$label] ? "tng_more_on.gif" : "tng_more.gif";

	$short = $noclass ? " style=\"width:120px\"" : " class=\"shortfield\"";
	$long = $noclass ? " style=\"width:270px\"" : " class=\"longfield\"";
	$tr = "<tr>\n";
	$tr .= "<td style=\"white-space:nowrap;\">" . $admtext[$label] . ":</td>\n";
	$tr .= "<td><input type=\"text\" value=\"" . $row[$datefield] . "\" name=\"$datefield\" onblur=\"checkDate(this);\" maxlength=\"50\"$short></td>\n";
	$tr .= "<td><input type=\"text\" value=\"" . $row[$placefield] . "\" name=\"$placefield\" id=\"$placefield\"$long></td>\n";
	$tr .= "<td><a href=\"#\" onclick=\"return openFindPlaceForm('$placefield');\"><img src=\"tng_find.gif\" title=\"$admtext[find]\" alt=\"$admtext[find]\" $dims class=\"smallicon\"/></a></td>\n";
	if(isset($gotmore))
		$tr .= "<td><a href=\"#\" onclick=\"return showMore('$label');\"><img src=\"$moreicon\" title=\"$admtext[more]\" alt=\"$admtext[more]\" $dims id=\"moreicon$label\" class=\"smallicon\"/></a></td>\n";
	if(isset($gotnotes))
		$tr .= "<td><a href=\"#\" onclick=\"return showNotes('$label');\"><img src=\"$notesicon\" title=\"$admtext[notes]\" alt=\"$admtext[notes]\" $dims id=\"notesicon$label\" class=\"smallicon\"/></a></td>\n";
	if(isset($gotcites))
		$tr .= "<td><a href=\"#\" onclick=\"return showCitations('$label');\"><img src=\"$citesicon\" title=\"$admtext[sources]\" alt=\"$admtext[sources]\" $dims id=\"citesicon$label\" class=\"smallicon\"/></a></td>\n";
	$tr .= "</tr>\n";
	return $tr;
}

function cleanID($id){
	return ereg_replace('[^a-z0-9_-]','',strtolower($id));
}
?>
