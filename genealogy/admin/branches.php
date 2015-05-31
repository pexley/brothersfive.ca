<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "branches";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $assignedbranch ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

session_register('tng_search_branches');
session_register('tng_search_branches_post');
$tng_search_branches = $_SESSION[tng_search_branches] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_branches_post[search]", $searchstring, $exptime);
	setcookie("tng_search_branches_post[tree]", $tree, $exptime);
	setcookie("tng_search_branches_post[page]", 1, $exptime);
	setcookie("tng_search_branches_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_branches_post][search];
	if( !$tree )
		$tree = $_COOKIE[tng_search_branches_post][tree];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_branches_post][page];
		$offset = $_COOKIE[tng_search_branches_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_branches_post[page]", $page, $exptime);
		setcookie("tng_search_branches_post[offset]", $offset, $exptime);
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

$wherestr = $searchstring ? "WHERE (branch LIKE \"%$searchstring%\" OR $branches_table.description LIKE \"%$searchstring%\")" : "";
if( $tree )
	$wherestr .= $wherestr ? " AND $branches_table.gedcom = \"$tree\"" : "WHERE $branches_table.gedcom = \"$tree\"";
$query = "SELECT $branches_table.gedcom as gedcom, branch, $branches_table.description as description, treename FROM $branches_table LEFT JOIN $trees_table ON $trees_table.gedcom = $branches_table.gedcom $wherestr ORDER BY $branches_table.description LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(branch) as bcount FROM $branches_table LEFT JOIN $trees_table ON $trees_table.gedcom = $branches_table.gedcom $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[bcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("branches_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[branches], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID,tree) {
	if(confirm('<?php echo $admtext['confbranchdelete']; ?>' ))
		deleteIt('branch',ID,tree);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$branchtabs[0] = array(1,"branches.php",$admtext['search'],"findbranch");
	$branchtabs[1] = array($allow_add,"newbranch.php",$admtext[addnew],"addbranch");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/branches_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($branchtabs,"findbranch",$innermenu);
	echo displayHeadline("$admtext[branches]","branches_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="branches.php" style="margin:0px;" name="form1" id="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext[searchfor]; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>"></td>
			<td>
				<input type="submit" name="submit" value="<?php echo $admtext[search]; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext[reset]; ?>" onClick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0;" style="vertical-align:top">
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext[tree]; ?>: </span></td>
			<td colspan="2">
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
		</tr>
	</table>

	<input type="hidden" name="findbranch" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "branches.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="deleteselected.php" method="post" style="margin:0px" name="form2">
<?php
	if( $allow_delete ) {
?>
		<p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
  		<input type="submit" name="xbranchaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
		</p>
<?php
	}
?>
	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
<?php
	if($allow_delete) {
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></span></td>
<?php
	}
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['id']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['description']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['people'] . '+' . $admtext['families']; ?></b>&nbsp;</nobr></td>
		</tr>

<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editbranch.php?branch=xxx&amp;tree=yyy\"><img src=\"tng_edit.gif\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete ) {
			if( !$assignedtree )
				$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx','yyy');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
		}
		if( $allow_edit )
			$actionstr .= "<a href=\"branchmenu.php?branch=xxx&amp;tree=yyy\"><img src=\"tng_branch.gif\" alt=\"$admtext[labelbranches]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result)) {
			$newactionstr = ereg_replace( "xxx", $row['branch'], $actionstr );
			$newactionstr = ereg_replace( "yyy", $row['gedcom'], $newactionstr );
			echo "<tr id=\"row_$row[branch]\"><td class=\"lightback\" nowrap><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			if($allow_delete)
				echo "<td class=\"lightback\" align=\"center\"><input type=\"checkbox\" name=\"del$row[branch]&$row[gedcom]\" value=\"1\"></td>";
			echo "<td class=\"lightback\" nowrap><span class=\"normal\">&nbsp;$row[branch]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[description]</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[treename]&nbsp;</span></td>\n";
			$query = "SELECT count(persfamID) as pcount FROM $branchlinks_table WHERE gedcom = \"$row[gedcom]\" AND branch = \"$row[branch]\"";
			$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$prow = mysql_fetch_assoc($presult);
			$pcount = $prow[pcount];
			mysql_free_result($presult);
			echo "<td class=\"lightback\" style=\"text-align:right\"><span class=\"normal\">$pcount&nbsp;</span></td>\n";
			echo "</tr>\n";
		}
		mysql_free_result($result);
?>
	</table>
<?php
		echo displayListLocation($offsetplus,$numrowsplus,$totrows);
		echo " &nbsp; $pagenav</p>";
	}
	else
		echo $admtext[notrees];
?>

	<p>
	<img src="tng_edit.gif" alt="<?php echo $admtext[edit]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[edit]; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext[text_delete]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[text_delete]; ?> &nbsp;&nbsp;
	<img src="tng_branch.gif" alt="<?php echo $admtext[labelbranches]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[labelbranches]; ?>
	</p>

	</div>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
