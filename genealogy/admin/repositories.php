<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

session_register('tng_search_repos_post');
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_repos_post[search]", $searchstring, $exptime);
	setcookie("tng_search_repos_post[tree]", $tree, $exptime);
	setcookie("tng_search_repos_post[exactmatch]", $exactmatch, $exptime);
	setcookie("tng_search_repos_post[page]", 1, $exptime);
	setcookie("tng_search_repos_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_repos_post][search];
	if( !$tree )
		$tree = $_COOKIE[tng_search_repos_post][tree];
	if( !$exactmatch )
		$exactmatch = $_COOKIE[tng_search_repos_post][exactmatch];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_repos_post][page];
		$offset = $_COOKIE[tng_search_repos_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_repos_post[page]", $page, $exptime);
		setcookie("tng_search_repos_post[offset]", $offset, $exptime);
	}
}

if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

if( $assignedtree ) {
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
	$tree = $assignedtree;
}
else
	$wherestr = "";
$orgtree = $tree;
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

function addCriteria( $field, $value, $operator ) {
	$criteria = "";

	if( $operator == "=" ) {
		$criteria = " OR $field $operator \"$value\"";
	}
	else {
		$innercriteria = "";
		$terms = explode( ' ',  $value );
		foreach( $terms as $term ) {
			if( $innercriteria ) $innercriteria .= " AND ";
			$innercriteria .= "$field $operator \"%$term%\"";
		}
		if( $innercriteria ) $criteria = " OR ($innercriteria)";
	}

	return $criteria;
}

$showrepo_url = getURL( "showrepo", 1 );
if( $tree )
	$allwhere = "$repositories_table.gedcom = \"$tree\" AND $repositories_table.gedcom = $trees_table.gedcom";
else
	$allwhere = "$repositories_table.gedcom = $trees_table.gedcom";

if( $searchstring ) {
	$allwhere .= " AND (1=0 ";
	if( $exactmatch == "yes" ) {
		$frontmod = "=";
	}
	else {
		$frontmod = "LIKE";
	}

	$allwhere .= addCriteria( "repoID", $searchstring, $frontmod );
	$allwhere .= addCriteria( "reponame", $searchstring, $frontmod );
	$allwhere .= ")";
}

$query = "SELECT ID, repoID, reponame, $repositories_table.gedcom as gedcom, treename FROM ($repositories_table, $trees_table) WHERE $allwhere ORDER BY reponame, repoID LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(repoID) as rcount FROM ($repositories_table, $trees_table) WHERE $allwhere";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[rcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("repositories_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[repositories], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confdeleterepo']; ?>' ))
		deleteIt('repository',ID);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$repotabs[0] = array(1,"repositories.php",$admtext['search'],"findrepo");
	$repotabs[1] = array($allow_add,"newrepo.php",$admtext[addnew],"addrepo");
	$repotabs[2] = array($allow_edit && $allow_delete,"mergerepos.php",$admtext[merge],"merge");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/repositories_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($repotabs,"findrepo",$innermenu);
	echo displayHeadline("$admtext[repositories]","repos_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="repositories.php" style="margin:0px;" name="form1" id="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext[searchfor]; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>"></td>
			<td>
				<input type="submit" name="submit" value="<?php echo $admtext[search]; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext[reset]; ?>" onClick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0; document.form1.exactmatch.checked=false;" style="vertical-align:top">
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext[tree]; ?>: </span></td>
			<td>
				<select name="tree">
<?php
	if( !$assignedtree )
		echo "	<option value=\"\">$admtext[alltrees]</option>\n";
	$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
	while( $treerow = mysql_fetch_assoc($treeresult) ) {
		echo "	<option value=\"$treerow[gedcom]\"";
		if( $treerow[gedcom] == $tree ) echo " selected";
		echo ">$treerow[treename]</option>\n";
	}
	mysql_free_result($treeresult);
?>
				</select>
			</td>
			<td>
				<span class="normal">
				<input type="checkbox" name="exactmatch" value="yes"<?php if( $exactmatch == "yes" ) echo " checked"; ?>> <?php echo $admtext[exactmatch]; ?>
				</span>
			</td>
		</tr>
	</table>

	<input type="hidden" name="findrepo" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "repositories.php?searchstring=$searchstring&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="deleteselected.php" method="post" style="margin:0px" name="form2">
<?php
	if( $allow_delete ) {
?>
		<p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
		<input type="submit" name="xrepoaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
		</p>
<?php
	}
?>

	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></span></td>
<?php
	if($allow_delete) {
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></span></td>
<?php
	}
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['repoid']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['name']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</nobr></span></td>
		</tr>
<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editrepo.php?repoID=xxx&amp;tree=yyy\"><img src=\"tng_edit.gif\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/ ></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('zzz');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
		$actionstr .= "<a href=\"" . $showrepo_url . "repoID=xxx&amp;tree=yyy\" target=\"_blank\"><img src=\"tng_test.gif\" alt=\"$admtext[test]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result))
		{
			$newactionstr = ereg_replace( "xxx", $row['repoID'], $actionstr );
			$newactionstr = ereg_replace( "yyy", $row['gedcom'], $newactionstr );
			$newactionstr = ereg_replace( "zzz", $row['ID'], $newactionstr );
			echo "<tr id=\"row_$row[ID]\"><td class=\"lightback\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			echo "<td class=\"lightback\" align=\"center\"><input type=\"checkbox\" name=\"del$row[ID]\" value=\"1\"></td>";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[repoID]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[reponame]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\"><nobr>$row[treename]&nbsp;</nobr></span></td></tr>\n";
		}
?>
	</table>
<?php
		echo displayListLocation($offsetplus,$numrowsplus,$totrows);
		echo " &nbsp; $pagenav</p>";
	}
	else
		echo "</table>\n$admtext[norecords]";
  	mysql_free_result($result);
?>
	</form>

	<p style="vertical-align:middle">
	<img src="tng_edit.gif" alt="<?php echo $admtext['edit']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['edit']; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext['text_delete']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['text_delete']; ?> &nbsp;&nbsp;
	<img src="tng_test.gif" alt="<?php echo $admtext['test']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['test']; ?>
	</p>

	</div>
</td>
</tr>

</table>
</div>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>