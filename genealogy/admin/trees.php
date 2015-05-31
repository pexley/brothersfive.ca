<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "trees";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

session_register('tng_search_trees');
session_register('tng_search_trees_post');
$tng_search_trees = $_SESSION[tng_search_trees] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_trees_post[search]", $searchstring, $exptime);
	setcookie("tng_search_trees_post[page]", 1, $exptime);
	setcookie("tng_search_trees_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_trees_post][search];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_trees_post][page];
		$offset = $_COOKIE[tng_search_trees_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_trees_post[page]", $page, $exptime);
		setcookie("tng_search_trees_post[offset]", $offset, $exptime);
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

$wherestr = $searchstring ? "WHERE (gedcom LIKE \"%$searchstring%\" OR treename LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR owner LIKE \"%$searchstring%\")" : "";
if( $assignedtree ) {
	$wherestr .= $wherestr ? " AND gedcom = \"$assignedtree\"" : "WHERE gedcom = \"$assignedtree\"";
}

$query = "SELECT gedcom, treename, description, owner, DATE_FORMAT(lastimportdate,\"%d %b %Y %H:%i:%s\") as lastimportdate FROM $trees_table $wherestr ORDER BY treename LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(gedcom) as tcount FROM $trees_table $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[tcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("trees_help.php");

$flags[tabs] = $tngconfig['tabs'];
tng_adminheader( $admtext['trees'], $flags );
?>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$allow_add_tree = $assignedtree ? 0 : $allow_add;
	$treetabs[0] = array(1,"trees.php",$admtext['search'],"findtree");
	$treetabs[1] = array($allow_add_tree,"newtree.php",$admtext[addnew],"addtree");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/trees_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($treetabs,"findtree",$innermenu);
	echo displayHeadline("$admtext[trees]","trees_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="trees.php" style="margin:0px;" name="form1">
	<?php echo $admtext['searchfor']; ?>: <input type="text" name="searchstring" value="<?php echo $searchstring; ?>">
	<input type="hidden" name="findtree" value="1"><input type="hidden" name="newsearch" value="1">
	<input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
	<input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value='';" style="vertical-align:top"></form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "trees.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['id']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['treename']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['description']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['owner']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['lastimport']; ?></b>&nbsp;</nobr></td>
		</tr>
	
<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit && !$assignedbranch )
			$actionstr .= "<a href=\"edittree.php?tree=xxx\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete && !$assignedbranch ) {
			if( !$assignedtree )
				$actionstr .= "<a href=\"#\" onClick=\"if(confirm('$admtext[conftreedelete]' )){deleteIt('tree','xxx');} return false;\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
			$actionstr .= "<a href=\"cleartree.php?tree=xxx\" onClick=\"return confirm('$admtext[conftreeclear]' );\"><img src=\"tng_clear.gif\" title=\"$admtext[clear]\" alt=\"$admtext[clear]\" $dims class=\"smallicon\"/></a>";
		}

		while( $row = mysql_fetch_assoc($result)) {
			$newactionstr = ereg_replace( "xxx", $row['gedcom'], $actionstr );
			echo "<tr id=\"row_$row[gedcom]\"><td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			echo "<td class=\"lightback\" nowrap><span class=\"normal\">&nbsp;$row[gedcom]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[treename]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[description]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" nowrap><span class=\"normal\">$row[owner]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" nowrap><span class=\"normal\">$row[lastimportdate]&nbsp;</span></td></tr>\n";
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
	<p style="vertical-align:middle">
	<img src="tng_edit.gif" alt="<?php echo $admtext['edit']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['edit']; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext['text_delete']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['text_delete']; ?> &nbsp;&nbsp;
	<img src="tng_clear.gif" alt="<?php echo $admtext['clear']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['clear']; ?> &nbsp;&nbsp;
	</p>

	</div>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
