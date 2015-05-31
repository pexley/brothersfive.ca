<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "families";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

session_register('tng_search_families_post');
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_families_post[search]", $searchstring, $exptime);
	setcookie("tng_search_families_post[tree]", $tree, $exptime);
	setcookie("tng_search_families_post[exactmatch]", $exactmatch, $exptime);
	setcookie("tng_search_families_post[spousename]", $spousename, $exptime);
	setcookie("tng_search_families_post[page]", 1, $exptime);
	setcookie("tng_search_families_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_families_post][search];
	if( !$tree )
		$tree = $_COOKIE[tng_search_families_post][tree];
	if( !$exactmatch )
		$exactmatch = $_COOKIE[tng_search_families_post][exactmatch];
	if( !$spousename ) {
		$spousename = $_COOKIE[tng_search_families_post][spousename];
		if( !$spousename ) $spousename = "husband";
	}
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_families_post][page];
		$offset = $_COOKIE[tng_search_families_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_families_post[page]", $page, $exptime);
		setcookie("tng_search_families_post[offset]", $offset, $exptime);
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

$familygroup_url = getURL( "familygroup", 1 );
$allwhere = "$families_table.gedcom = $trees_table.gedcom";
$allwhere2 = "";

if( $searchstring ) {
	$allwhere .= " AND (1=0 ";
	if( $exactmatch == "yes" ) {
		$frontmod = "=";
	}
	else {
		$frontmod = "LIKE";
	}

	$allwhere .= addCriteria( "familyID", $searchstring, $frontmod );
	$allwhere .= addCriteria( "husband", $searchstring, $frontmod );
	$allwhere .= addCriteria( "wife", $searchstring, $frontmod );

	if( $spousename == "husband" )
		$allwhere .= addCriteria( "CONCAT_WS(' ',firstname,lastname)", $searchstring, $frontmod );
	elseif( $spousename == "wife" )
		$allwhere .= addCriteria( "CONCAT_WS(' ',firstname,lastname)", $searchstring, $frontmod );
	$allwhere .= ")";
}
if( $spousename == "husband" )
	$allwhere2 .= "AND $people_table.personID = husband ";
elseif( $spousename == "wife" )
	$allwhere2 .= "AND $people_table.personID = wife ";

if( $allwhere2 ) {
	$allwhere2 .= "AND $people_table.gedcom = $trees_table.gedcom";
	$allwhere .= " $allwhere2";
	if( $tree ) {
		$allwhere .= " AND $people_table.gedcom = \"$tree\"";
	}
	else {
		$allwhere .= " AND $people_table.gedcom = $families_table.gedcom";
	}
	if( $assignedbranch )
		$allwhere .= " AND $families_table.branch LIKE \"%$assignedbranch%\"";
	$people_join = ", $people_table";
	$otherfields = ", firstname, lnprefix, lastname, prefix, suffix, nameorder";
}
else {
	$people_join = "";
	$otherfields = "";
}
if( $tree )
	$allwhere .= " AND $families_table.gedcom = \"$tree\"";

$query = "SELECT $families_table.ID as ID, familyID, husband, wife, marrdate, $families_table.gedcom as gedcom, treename $otherfields FROM ($families_table, $trees_table $people_join) WHERE $allwhere ORDER BY familyID LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count($families_table.ID) as fcount FROM ($families_table, $trees_table $people_join) WHERE $allwhere";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[fcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("families_help.php");

$revstar = checkReview("F");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[families], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confdeletefam']; ?>' ))
		deleteIt('family',ID);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$familytabs[0] = array(1,"families.php",$admtext['search'],"findfamily");
	$familytabs[1] = array($allow_add,"newfamily.php",$admtext[addnew],"addfamily");
	$familytabs[2] = array($allow_edit,"findreview.php?type=F",$admtext[review] . $revstar,"review");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/families_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($familytabs,"findfamily",$innermenu);
	echo displayHeadline("$admtext[families]","families_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="families.php" style="margin:0px;" name="form1" id="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext[searchfor]; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>"></td>
			<td>
				<input type="submit" name="submit" value="<?php echo $admtext[search]; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext[reset]; ?>" onClick="document.form1.searchstring.value=''; document.form1.spousename.selectedIndex=0; document.form1.tree.selectedIndex=0; document.form1.exactmatch.checked=false;" style="vertical-align:top">
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
				<select name="spousename">
					<option value="husband"<?php if( $spousename == "husband") echo " selected"; ?>><?php echo $admtext[husbname]; ?></option>
					<option value="wife"<?php if( $spousename == "wife") echo " selected"; ?>><?php echo $admtext[wifename]; ?></option>
					<option value="none"<?php if( $spousename == "none") echo " selected"; ?>><?php echo $admtext[noname]; ?></option>
             </select>
				<input type="checkbox" name="exactmatch" value="yes"<?php if( $exactmatch == "yes" ) echo " checked"; ?>> <?php echo $admtext[exactmatch]; ?>
				</span>
			</td>
		</tr>
	</table>

	<input type="hidden" name="findfamily" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "families.php?searchstring=$searchstring&amp;spousename=$spousename&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="deleteselected.php" method="post" name="form2">
<?php
	if( $allow_delete ) {
?>
		<p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
		<input type="submit" name="xfamaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext[confdeleterecs]; ?>');">
		</p>
<?php
	}
?>

	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[action]; ?></b>&nbsp;</nobr></span></td>
<?php
	if($allow_delete) {
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[select]; ?></b>&nbsp;</nobr></span></td>
<?php
	}
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[id]; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[husbid]; ?></b>&nbsp;</nobr></span></td>
<?php
	if( $spousename == "husband" )
		echo "<td class=\"fieldnameback\"><span class=\"fieldname\"><nobr>&nbsp;<b>$admtext[husbname]</b>&nbsp;</nobr></span></td>\n";
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[wifeid]; ?></b>&nbsp;</nobr></span></td>
<?php
	if( $spousename == "wife" )
		echo "<td class=\"fieldnameback\"><span class=\"fieldname\"><nobr>&nbsp;<b>$admtext[wifename]</b>&nbsp;</nobr></span></td>\n";
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[marrdate]; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[tree]; ?></b>&nbsp;</nobr></span></td>
		</tr>

<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editfamily.php?familyID=xxx&amp;tree=yyy\"><img src=\"tng_edit.gif\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('zzz');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
		$actionstr .= "<a href=\"" . $familygroup_url . "familyID=xxx&amp;tree=yyy\" target=\"_blank\"><img src=\"tng_test.gif\" alt=\"$admtext[test]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result))
		{
			$newactionstr = ereg_replace( "xxx", $row['familyID'], $actionstr );
			$newactionstr = ereg_replace( "yyy", $row['gedcom'], $newactionstr );
			$newactionstr = ereg_replace( "zzz", $row['ID'], $newactionstr );
			echo "<tr id=\"row_$row[ID]\"><td class=\"lightback\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			if($allow_delete)
				echo "<td class=\"lightback\" align=\"center\"><input type=\"checkbox\" name=\"del$row[ID]\" value=\"1\"></td>";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$row[familyID]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$row[husband]&nbsp;</span></td>\n";
			if( $spousename == "husband" )
				echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;" . getName( $row ) . "&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$row[wife]&nbsp;</span></td>\n";
			if( $spousename == "wife" )
				echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;" . getName( $row ) . "&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$row[marrdate]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$row[treename]&nbsp;</span></td></tr>\n";
		}
?>
	</table><br/>
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
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
