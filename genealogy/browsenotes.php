<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "notes";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "functions.php");
include($cms['tngpath'] . "log.php" );

$browsenotes_url = getURL( "browsenotes", 1 );
$showsource_url = getURL( "showsource", 1 );
$getperson_url = getURL( "getperson", 1 );
$familygroup_url = getURL( "familygroup", 1 );

function doNoteSearch( $instance, $pagenav ) {
	global $text, $notesearch, $tree;

	$browsenotes_noargs_url = getURL( "browsenotes", 0 );
	
	$str = "<div class=\"normal\">\n";
	$str .= getFORM( "browsenotes", "GET", "notesearch$instance", "" );
	$str .= "<input type=\"text\" name=\"notesearch\" value=\"$notesearch\" /> <input type=\"submit\" value=\"$text[search]\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$str .= $pagenav;
	if( $notesearch )
		$str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$browsenotes_noargs_url\">$text[browseallnotes]</a>";
	$str .= "<input type=\"hidden\" name=\"tree\" value=\"$tree\" />\n";
	$str .= "</form></div>\n";
	
	return $str;
}

$max_browsenote_pages = 5;
if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

$wherestr = "WHERE $xnotes_table.ID = $notelinks_table.xnoteID AND $notelinks_table.secret != \"1\"";
if( $tree ) {
	$wherestr .= " AND $xnotes_table.gedcom = \"$tree\"";
}
if( $notesearch ) {
	$notesearch2 = addslashes($notesearch);
	$wherestr .= " AND (match(note) against( \"$notesearch2\" in boolean mode) OR lastname LIKE \"%$notesearch2%\" OR firstname LIKE \"%$notesearch2%\" OR familyID LIKE \"%$notesearch2%\" OR $sources_table.title LIKE \"%$notesearch2%\" OR reponame LIKE \"%$notesearch2%\")";
}

$query = "SELECT $xnotes_table.ID as ID, note, $xnotes_table.gedcom as gedcom
	FROM ($xnotes_table, $notelinks_table)
	LEFT JOIN $families_table ON $notelinks_table.persfamID = $families_table.familyID AND $notelinks_table.gedcom = $families_table.gedcom
	LEFT JOIN $sources_table ON $notelinks_table.persfamID = $sources_table.sourceID AND $notelinks_table.gedcom = $sources_table.gedcom
	LEFT JOIN $repositories_table ON $notelinks_table.persfamID = $repositories_table.repoID AND $notelinks_table.gedcom = $repositories_table.gedcom
	LEFT JOIN $people_table ON $notelinks_table.persfamID = $people_table.personID AND $notelinks_table.gedcom = $people_table.gedcom
	$wherestr ORDER BY reponame, $sources_table.title, lastname, lnprefix, firstname, note LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );

if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	if( $tree )
		$query = "SELECT count($xnotes_table.ID) as scount FROM ($xnotes_table, $notelinks_table)
			LEFT JOIN $trees_table on $xnotes_table.gedcom = $trees_table.gedcom
			LEFT JOIN $families_table ON $notelinks_table.persfamID = $families_table.familyID AND $notelinks_table.gedcom = $families_table.gedcom
			LEFT JOIN $sources_table ON $notelinks_table.persfamID = $sources_table.sourceID AND $notelinks_table.gedcom = $sources_table.gedcom
			LEFT JOIN $repositories_table ON $notelinks_table.persfamID = $repositories_table.repoID AND $notelinks_table.gedcom = $repositories_table.gedcom
			LEFT JOIN $people_table ON $notelinks_table.persfamID = $people_table.personID AND $notelinks_table.gedcom = $people_table.gedcom
			$wherestr";
	else
		$query = "SELECT count($xnotes_table.ID) as scount FROM ($xnotes_table, $notelinks_table)
			LEFT JOIN $families_table ON $notelinks_table.persfamID = $families_table.familyID AND $notelinks_table.gedcom = $families_table.gedcom
			LEFT JOIN $sources_table ON $notelinks_table.persfamID = $sources_table.sourceID AND $notelinks_table.gedcom = $sources_table.gedcom
			LEFT JOIN $repositories_table ON $notelinks_table.persfamID = $repositories_table.repoID AND $notelinks_table.gedcom = $repositories_table.gedcom
			LEFT JOIN $people_table ON $notelinks_table.persfamID = $people_table.personID AND $notelinks_table.gedcom = $people_table.gedcom
			$wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[scount];
}
else
	$totrows = $numrows;

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$browsenotes_url" . "tree=$tree&amp;offset=$offset&amp;notesearch=$notesearch\">" . xmlcharacters("$text[notes]$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( $text[notes], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_note.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text['notes']; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'browsenotes', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1'));

if( $totrows )
	echo "<p class=\"normal\">$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows</p>";

$pagenav = get_browseitems_nav( $totrows, $browsenotes_url . "notesearch=$notesearch&amp;offset", $maxsearchresults, $max_browsenote_pages );
echo doNoteSearch( 1, $pagenav );
echo "<br />\n";
?>
<table cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td class="fieldnameback">&nbsp;</td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<strong><?php echo $text[notes]; ?></strong>&nbsp;</span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<strong><?php echo $text[indlinked]; ?></strong>&nbsp;</span></td>
	</tr>
<?php
$i = $offsetplus;
while( $row = mysql_fetch_assoc( $result ) )
{
	$query = "SELECT $notelinks_table.ID, $notelinks_table.persfamID as personID, people.personID as personID2, people.living as living, people.branch as branch, $families_table.branch as fbranch,
		$families_table.living as fliving, familyID, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.prefix as prefix, people.suffix as suffix, nameorder, 
		$notelinks_table.gedcom, $sources_table.title, $sources_table.sourceID
		FROM $notelinks_table
		LEFT JOIN $people_table AS people ON $notelinks_table.persfamID = people.personID AND $notelinks_table.gedcom = people.gedcom
		LEFT JOIN $families_table ON $notelinks_table.persfamID = $families_table.familyID AND $notelinks_table.gedcom = $families_table.gedcom
		LEFT JOIN $sources_table ON $notelinks_table.persfamID = $sources_table.sourceID AND $notelinks_table.gedcom = $sources_table.gedcom
		WHERE $notelinks_table.xnoteID = \"$row[ID]\" ORDER BY lastname, lnprefix, firstname, personID";
	$nresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$notelinktext = "";
	$noneliving = 1;
	$query2=$query;
	while( $nrow = mysql_fetch_assoc( $nresult ) )
	{
		if( $nrow[fbranch] != NULL ) $nrow[branch] = $nrow[fbranch];
		if( $nrow[fliving] != NULL ) $nrow[living] = $nrow[fliving];
		//if living still null, must be a source
		if( $nrow[living] == NULL ) {
			$query = "SELECT count(personID) as ccount FROM $citations_table, $people_table 
				WHERE $citations_table.sourceID = '$nrow[personID]' AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
				AND living = '1'";
			$nresult2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$nrow2 = mysql_fetch_assoc( $nresult2 );
			if( $nrow2[ccount] ) $nrow[living] = 1;
			mysql_free_result( $nresult2 );
		}
		if( !$nrow[living] || $livedefault == 2 || ( !$livedefault && $allow_living_db && ( !$assignedtree || $assignedtree == $nrow[gedcom] ) && checkbranch( $nrow[branch] ) ) )
			$nrow[allow_living] = 1;
		else {
			$noneliving = 0;
			$nrow[allow_living] = 0;
		}
		if( $nrow[personID2] != NULL ) {
			$notelinktext .= "<a href=\"$getperson_url" . "personID=$nrow[personID]&amp;tree=$nrow[gedcom]\">";
			$notelinktext .= getName( $nrow ) . "</a>\n<br/>\n";
		}
		elseif( $nrow[sourceID] != NULL ) {
			$sourcetext = $nrow[title] ? $nrow[title] : $nrow[sourceID];
			$notelinktext .= "<a href=\"$showsource_url" . "sourceID=$nrow[sourceID]&amp;tree=$nrow[gedcom]\">$text[source]: $sourcetext</a>\n<br/>\n";
		}
		elseif( $nrow[familyID] != NULL )
			$notelinktext .= "<a href=\"$familygroup_url" . "familyID=$nrow[personID]&amp;tree=$nrow[gedcom]\">$text[family]: $nrow[personID]</a>\n<br/>\n";
	}
	mysql_free_result( $nresult );

	echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$i</span></td>\n";
	echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">";
	if( $noneliving ) 
		echo nl2br($row[note]);
	else
		echo $text[livingnote];
	echo "&nbsp;</span></td>";
	echo "<td valign=\"top\" class=\"databack\" width=\"175\"><span class=\"normal\">$notelinktext&nbsp;</span></td></tr>\n";
	$i++;
}
mysql_free_result($result);
?>
</table><br />
<?php
if( $pagenav || $notesearch ) {
	echo doNoteSearch( 2, $pagenav );
	echo "<br />";
}
tng_footer( "" );
?>
