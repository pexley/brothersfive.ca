<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "sources";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "functions.php");
include($cms['tngpath'] . "log.php" );

$browsesources_url = getURL( "browsesources", 1 );
$showsource_url = getURL( "showsource", 1 );
$showtree_url = getURL( "showtree", 1 );

function doSourceSearch( $instance, $pagenav ) {
	global $text, $photosearch;

	$browsesources_noargs_url = getURL( "browsesources", 0 );
	
	$str = "<div class=\"normal\">\n";
	$str .= getFORM( "browsesources", "GET", "SourceSearch$instance", "" );
	$str .= "<input type=\"text\" name=\"sourcesearch\" value=\"$sourcesearch\" /> <input type=\"submit\" value=\"$text[search]\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$str .= $pagenav;
	if( $docsearch )
		$str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$browsesources_noargs_url\">$text[browseallsources]</a>";
	$str .= "</form></div>\n";
	
	return $str;
}

$max_browsesource_pages = 5;
if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

if( $tree ) {
	$wherestr = "WHERE $sources_table.gedcom = \"$tree\"";
	if( $sourcesearch ) $wherestr .= " AND (title LIKE \"%$sourcesearch%\" OR shorttitle LIKE \"%$sourcesearch%\" OR author LIKE \"%$sourcesearch%\")";
	$join = "INNER JOIN";
}
else {
	if( $sourcesearch ) 
		$wherestr = "WHERE title LIKE \"%$sourcesearch%\" OR shorttitle LIKE \"%$sourcesearch%\" OR author LIKE \"%$sourcesearch%\"";
	else
		$wherestr = "";
	$join = "LEFT JOIN";
}

$query = "SELECT sourceID, title, shorttitle, author, $sources_table.gedcom as gedcom, treename FROM $sources_table $join $trees_table on $sources_table.gedcom = $trees_table.gedcom $wherestr ORDER BY title LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );

if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	if( $tree )
		$query = "SELECT count(sourceID) as scount FROM $sources_table LEFT JOIN $trees_table on $sources_table.gedcom = $trees_table.gedcom $wherestr";
	else
		$query = "SELECT count(sourceID) as scount FROM $sources_table $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[scount];
}
else
	$totrows = $numrows;

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$browsesources_url" . "tree=$tree&amp;offset=$offset&amp;sourcesearch=$sourcesearch\">" . xmlcharacters("$text[sources]$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( $text[sources], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_src.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text['sources']; ?></p><br clear="left"/>
<?php 
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'browsesources', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1'));

if( $totrows )
	echo "<p><span class=\"normal\">$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows</span></p>";

$pagenav = get_browseitems_nav( $totrows, $browsesources_url . "sourcesearch=$sourcesearch&amp;offset", $maxsearchresults, $max_browsesource_pages );
if( $pagenav || $sourcesearch ) {
	echo doSourceSearch( 1, $pagenav );
	echo "<br />\n";
}
?>
<br />
<table cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td class="fieldnameback">&nbsp;</td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<strong><?php echo $text[sourceid]; ?></strong>&nbsp;</span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<strong><?php echo "$text[title], $text[author]"; ?></strong>&nbsp;</span></td>
		<?php if( $numtrees > 1 ) { ?><td class="fieldnameback"><span class="fieldname">&nbsp;<strong><?php echo $text[tree]; ?></strong>&nbsp;</span></td><?php } ?>
	</tr>
<?php
$i = $offsetplus;
while( $row = mysql_fetch_assoc( $result ) )
{
	$sourcetitle = $row['title'] ? $row['title'] : $row['shorttitle'];
	echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$i</span></td>\n";
	echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\"><a href=\"$showsource_url" . "sourceID=$row[sourceID]&amp;tree=$row[gedcom]\">$row[sourceID]</a>&nbsp;</span></td>";
	echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\"><a href=\"$showsource_url" . "sourceID=$row[sourceID]&amp;tree=$row[gedcom]\">$sourcetitle</a><br/>$row[author]&nbsp;</span></td>";
	if( $numtrees > 1 )
		echo "<td valign=\"top\" class=\"databack\" style=\"white-space:nowrap\"><span class=\"normal\"><a href=\"$showtree_url" . "tree=$row[gedcom]\">$row[treename]</a>&nbsp;</span></td>";
	echo "</tr>\n";
	$i++;
}
mysql_free_result($result);
?>
</table>
<br />
<?php
if( $pagenav || $sourcesearch )
	echo doSourceSearch( 2, $pagenav );

tng_footer( "" );
?>
