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

$browserepos_url = getURL( "browserepos", 1 );
$showrepo_url = getURL( "showrepo", 1 );

function doRepoSearch( $instance, $pagenav ) {
	global $text, $photosearch, $tree;

	$browserepos_noargs_url = getURL( "browserepos", 0 );

	$str = "<span class=\"normal\">\n";
	$str .= getFORM( "browserepos", "GET", "RepoSearch$instance", "" );
	$str .= "<input type=\"text\" name=\"reposearch\" value=\"$reposearch\" /> <input type=\"submit\" value=\"$text[search]\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$str .= $pagenav;
	if( $docsearch )
		$str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$browserepos_noargs_url\">$text[browseallrepos]</a>";
	$str .= "<input type=\"hidden\" name=\"tree\" value=\"$tree\" />\n";
	$str .= "</form></span>\n";
	
	return $str;
}

$max_browserepo_pages = 5;
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
	$wherestr = "WHERE $repositories_table.gedcom = \"$tree\"";
	if( $reposearch ) $wherestr .= " AND (reponame LIKE \"%$reposearch%\" OR author LIKE \"%$reposearch%\")";
	$join = "INNER JOIN";
}
else {
	if( $reposearch )
		$wherestr = "WHERE reponame LIKE \"%$reposearch%\"";
	else
		$wherestr = "";
	$join = "LEFT JOIN";
}

$query = "SELECT repoID, reponame, $repositories_table.gedcom as gedcom, treename FROM $repositories_table $join $trees_table on $repositories_table.gedcom = $trees_table.gedcom $wherestr ORDER BY reponame LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );

if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	if( $tree )
		$query = "SELECT count(repoID) as scount FROM $repositories_table LEFT JOIN $trees_table on $repositories_table.gedcom = $trees_table.gedcom $wherestr";
	else
		$query = "SELECT count(repoID) as scount FROM $repositories_table $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[scount];
}
else
	$totrows = $numrows;

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$browserepos_url" . "tree=$tree&amp;offset=$offset&amp;reposearch=$reposearch\">" . xmlcharacters("$text[repositories]$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( $text[repositories], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_repo.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text['repositories']; ?></p><br clear="left"/>
<?php 
echo tng_coreicons();

echo "<div class=\"normal\">\n";

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'browserepos', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1'));

if( $totrows )
	echo "<p><span class=\"normal\">$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows</span></p>";

$pagenav = get_browseitems_nav( $totrows, $browserepos_url . "reposearch=$reposearch&amp;offset", $maxsearchresults, $max_browserepo_pages );
if( $pagenav || $reposearch ) {
	echo doRepoSearch( 1, $pagenav );
	echo "<br />\n";
}
?>

<table cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td class="fieldnameback">&nbsp;</td>
		<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<strong><?php echo $text[repoid]; ?></strong>&nbsp;</nobr></span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<strong><?php echo $text[name]; ?></strong>&nbsp;</nobr></span></td>
		<?php if( $numtrees > 1 ) { ?><td class="fieldnameback"><span class="fieldname">&nbsp;<strong><?php echo $text[tree]; ?></strong>&nbsp;</span></td><?php } ?>
	</tr>
<?php
$i = $offsetplus;
while( $row = mysql_fetch_assoc( $result ) )
{
	echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$i</span></td>\n";
	echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\"><a href=\"$showrepo_url" . "repoID=$row[repoID]&amp;tree=$row[gedcom]\">$row[repoID]</a>&nbsp;</span></td>";
	echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\"><a href=\"$showrepo_url" . "repoID=$row[repoID]&amp;tree=$row[gedcom]\">$row[reponame]</a>&nbsp;</span></td>";
	if( $numtrees > 1 )
		echo "<td valign=\"top\" class=\"databack\" style=\"white-space:nowrap\"><span class=\"normal\">$row[treename]&nbsp;</span></td>";
	echo "</tr>\n";
	$i++;
}
mysql_free_result($result);
?>
</table>
<br />
</div>
<?php
if( $pagenav || $reposearch )
	echo doRepoSearch( 2, $pagenav );

tng_footer( "" );
?>
