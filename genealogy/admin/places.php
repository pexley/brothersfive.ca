<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "mapconfig.php");
include("adminlib.php");
$textpart = "findplace";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

$orgtree = $tree;
session_register('tng_search_places');
session_register('tng_search_places_post');
$tng_search_people = $_SESSION[tng_search_people] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_places_post[search]", $searchstring, $exptime);
	setcookie("tng_search_places_post[tree]", $tree, $exptime);
	setcookie("tng_search_places_post[exactmatch]", $exactmatch, $exptime);
	setcookie("tng_search_places_post[page]", 1, $exptime);
	setcookie("tng_search_places_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_places_post][search];
	if( !$tree )
		$tree = $_COOKIE[tng_search_places_post][tree];
	if( !$exactmatch )
		$exactmatch = $_COOKIE[tng_search_places_post][exactmatch];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_places_post][page];
		$offset = $_COOKIE[tng_search_places_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_places_post[page]", $page, $exptime);
		setcookie("tng_search_places_post[offset]", $offset, $exptime);
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
	$tree = $assignedtree;
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
}
else
	$wherestr = "";
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

function addCriteria( $field, $value, $operator ) {
	$criteria = "";

	if( $operator == "=" )
		$criteria = " AND $field $operator \"$value\"";
	else
		$criteria = " AND $field $operator \"%$value%\"";

	return $criteria;
}

if( $exactmatch == "yes" ) {
	$frontmod = "=";
}
else {
	$frontmod = "LIKE";
}

$placesearch_url = getURL( "placesearch", 1 );
if( $tree )
	$allwhere = "$places_table.gedcom = \"$tree\" AND $places_table.gedcom = $trees_table.gedcom ";
else
	$allwhere = "$places_table.gedcom = $trees_table.gedcom ";

$allwhere .= addCriteria( "place", $searchstring, $frontmod );

$query = "SELECT ID, place, placelevel, longitude, latitude, zoom, $places_table.gedcom as gedcom, treename FROM $places_table, $trees_table WHERE $allwhere ORDER BY place, $places_table.gedcom, ID LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(ID) as pcount FROM $places_table, $trees_table WHERE $allwhere";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[pcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("places_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[places], $flags );
?>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;
	if( document.form1.searchstring.value.length == 0 ) {
		alert("<?php echo $admtext[entersearchvalue]; ?>");
		rval = false;
	}
	return rval;
}

function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confdeleteplace']; ?>' ))
		deleteIt('place',ID);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$placetabs[0] = array(1,"places.php",$admtext['search'],"findplace");
	$placetabs[1] = array($allow_add,"newplace.php",$admtext['addnew'],"addplace");
	$placetabs[2] = array($allow_edit && $allow_delete,"mergeplaces.php",$admtext[merge],"merge");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/places_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($placetabs,"findplace",$innermenu);
	echo displayHeadline("$admtext[places]","places_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="places.php" style="margin:0px;" name="form1" id="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo stripslashes($searchstring); ?>"></td>
			<td>
				<input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0; document.form1.exactmatch.checked=false;" style="vertical-align:top">
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
				<input type="checkbox" name="exactmatch" value="yes"<?php if( $exactmatch == "yes" ) echo " checked"; ?>> <?php echo $admtext['exactmatch']; ?>
				</span>
			</td>
		</tr>
	</table>

	<input type="hidden" name="findplace" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "places.php?searchstring=$searchstring&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="deleteselected.php" method="post" style="margin:0px" name="form2">
<?php
	if( $allow_delete ) {
?>
		<p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
  		<input type="submit" name="xplacaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
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
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></td>
<?php
	}
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['place']; ?></b>&nbsp;</nobr></td>
<?php
	if($map[key]) {
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['placelevel']; ?></b>&nbsp;</nobr></td>
<?php
	}
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['latitude']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['longitude']; ?></b>&nbsp;</nobr></td>
<?php
	if($map[key]) {
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['zoom']; ?></b>&nbsp;</nobr></td>
<?php
	}
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</nobr></td>
		</tr>
<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editplace.php?ID=xxx&amp;tree=yyy\"><img src=\"tng_edit.gif\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
		$actionstr .= "<a href=\"" . $placesearch_url . "psearch=zzz\" target=\"_blank\"><img src=\"tng_test.gif\" title=\"$admtext[test]\" alt=\"$admtext[test]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result))
		{
			$newactionstr = ereg_replace( "xxx", $row[ID], $actionstr );
			$newactionstr = ereg_replace( "yyy", $row[gedcom], $newactionstr );
			$newactionstr = ereg_replace( "zzz", urlencode($row[place]), $newactionstr );
			echo "<tr id=\"row_$row[ID]\"><td class=\"lightback\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			if($allow_delete)
				echo "<td class=\"lightback\" align=\"center\"><input type=\"checkbox\" name=\"del$row[ID]\" value=\"1\"></td>";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[place]&nbsp;</span></td>\n";
			if($map[key])
				echo "<td class=\"lightback\"><span class=\"normal\">$row[placelevel]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[latitude]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[longitude]&nbsp;</span></td>\n";
			if($map[key])
				echo "<td class=\"lightback\"><span class=\"normal\">$row[zoom]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">$row[treename]&nbsp;</span></td></tr>\n";
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

	<p>
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
