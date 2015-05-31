<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "review";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $type == "I" ) {
	session_register('tng_search_preview');
	session_register('tng_search_preview_post');
	$tng_search_preview = $_SESSION[tng_search_preview] = 1;
	if( $newsearch ) {
		$_SESSION[tng_search_preview_post][tree] = $tree;
		$_SESSION[tng_search_preview_post][user] = $reviewuser;
		$_SESSION[tng_search_preview_post][page] = 1;
		$_SESSION[tng_search_preview_post][offset] = 0;
	}
	else {
		if( !$tree )
			$tree = $_SESSION[tng_search_preview_post][tree];
		if( !$reviewuser )
			$reviewuser = $_SESSION[tng_search_preview_post][user];
		if( !isset($offset) ) {
			$page = $_SESSION[tng_search_preview_post][page];
			$offset = $_SESSION[tng_search_preview_post][offset];
		}
		else {
			$_SESSION[tng_search_preview_post][page] = $page;
			$_SESSION[tng_search_preview_post][offset] = $offset;
		}
	}
	$helplang = findhelp("people_help.php");
}
else { //$type == F
	session_register('tng_search_freview');
	session_register('tng_search_freview_post');
	$tng_search_preview = $_SESSION[tng_search_preview] = 1;
	if( $newsearch ) {
		$_SESSION[tng_search_freview_post][tree] = $tree;
		$_SESSION[tng_search_freview_post][user] = $reviewuser;
		$_SESSION[tng_search_freview_post][page] = 1;
		$_SESSION[tng_search_freview_post][offset] = 0;
	}
	else {
		if( !$tree )
			$tree = $_SESSION[tng_search_freview_post][tree];
		if( !$reviewuser )
			$reviewuser = $_SESSION[tng_search_freview_post][user];
		if( !isset($offset) ) {
			$page = $_SESSION[tng_search_freview_post][page];
			$offset = $_SESSION[tng_search_freview_post][offset];
		}
		else {
			$_SESSION[tng_search_freview_post][page] = $page;
			$_SESSION[tng_search_freview_post][offset] = $offset;
		}
	}
	$helplang = findhelp("families_help.php");
}
$orgtree = $tree;


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
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$allwhere = "$temp_events_table.gedcom = $trees_table.gedcom";
if( $tree )
	$allwhere .= " AND $temp_events_table.gedcom = \"$tree\"";

if( $assignedbranch )
	$allwhere .= " AND branch LIKE \"%$assignedbranch%\"";
if( $reviewuser != "" )
	$allwhere .= " AND user = \"$reviewuser\"";

if( $type == "I" ) {
	$allwhere .= " AND $people_table.personID = $temp_events_table.personID AND $people_table.gedcom = $temp_events_table.gedcom AND (type = \"I\" OR type = \"C\")";
	$query = "SELECT tempID, $temp_events_table.personID as personID, lastname, firstname, lnprefix, prefix, suffix, nameorder, treename, eventID, DATE_FORMAT(postdate,\"%d %b %Y %H:%i:%s\") as postdate
		FROM $people_table, $trees_table, $temp_events_table WHERE $allwhere ORDER BY postdate DESC";
	$returnpage = "people.php";
	$totquery = "SELECT count(tempID) as tcount FROM $people_table, $trees_table, $temp_events_table WHERE $allwhere";
}
elseif( $type == "F" ) {
	$allwhere .= " AND $families_table.familyID = $temp_events_table.familyID AND $families_table.gedcom = $temp_events_table.gedcom AND type = \"F\"";
	$query = "SELECT tempID, $temp_events_table.familyID as familyID, $families_table.gedcom as gedcom, husband, wife, treename, eventID, DATE_FORMAT(postdate,\"%d %b %Y %H:%i:%s\") as postdate
		FROM $families_table, $trees_table, $temp_events_table WHERE $allwhere ORDER BY postdate DESC";
	$returnpage = "families.php";
	$totquery = "SELECT count(tempID) as tcount FROM $people_table, $trees_table, $temp_events_table WHERE $allwhere";
}
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $totquery");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$result2 = mysql_query($totquery) or die ("$text[cannotexecutequery]: $totquery");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[pcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader( $admtext['review'], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confdeleteevent']; ?>' ))
		deleteIt('tevent',ID);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	if( $type == "I" ) {
		$icon = "people_icon.gif";
		$hmsg = $admtext['people'];
		$peopletabs[0] = array(1,"people.php",$admtext['search'],"findperson");
		$peopletabs[1] = array($allow_add,"newperson.php",$admtext[addnew],"addperson");
		$peopletabs[2] = array($allow_edit,"findreview.php?type=I",$admtext[review],"review");
		$peopletabs[3] = array($allow_edit && $allow_delete,"merge.php",$admtext[merge],"merge");
	}
	else {
		$icon = "families_icon.gif";
		$hmsg = $admtext['families'];
		$peopletabs[0] = array(1,"families.php",$admtext['search'],"findperson");
		$peopletabs[1] = array($allow_add,"newfamily.php",$admtext[addnew],"addfamily");
		$peopletabs[2] = array($allow_edit,"findreview.php?type=F",$admtext[review],"review");
	}

	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/people_help.php#review', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($peopletabs,"review",$innermenu);
	echo displayHeadline("$hmsg &gt;&gt; $admtext[review]",$icon,$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<span class="subhead"><strong><?php echo $admtext['selectevaction']; ?></strong></span>
	<div class="normal">
	<form action="findreview.php" style="margin:0px;" name="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext[user];?>:</span></td>
			<td>
				<select name="reviewuser">
<?php
echo "	<option value=\"\">$admtext[allusers]</option>\n";
$query = "SELECT username, description FROM $users_table ORDER BY description";
$userresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
while( $userrow = mysql_fetch_assoc($userresult) ) {
	echo "	<option value=\"$userrow[username]\"";
	if( $userrow[username] == $reviewuser ) echo " selected";
	echo ">$userrow[description]</option>\n";
}
mysql_free_result($userresult);
?>
				</select>
			</td>
			<td>&nbsp;</td>
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
				<input type="submit" name="submit" value="<?php echo $admtext[search]; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext[reset]; ?>" onClick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0; document.form1.living.checked=false; document.form1.exactmatch.checked=false;" style="vertical-align:top">
			</td>
		</tr>
	</table>
	<input type="hidden" name="type" value="<?php echo $type; ?>">
	<input type="hidden" name="newsearch" value="1">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo "<p>$admtext[matches]: $offsetplus $text[to] $numrowsplus $text[of] $totrows";
	$pagenav = get_browseitems_nav( $totrows, "findreview.php?type=$type&amp;reviewuser=$reviewuser&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['id']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['name']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['event']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['postdate']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</nobr></td>
		</tr>
	
<?php
$actionstr = "<a href=\"review.php?tempID=xxx\"><img src=\"tng_edit.gif\" alt=\"$admtext[review]\" $dims class=\"smallicon\"/></a>";
if( $allow_delete )
	$actionstr .= "<a href=\"#\" onclick=\"return confirmDelete('xxx');\"><img src=\"tng_delete.gif\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";

while( $row = mysql_fetch_assoc($result))
{
	if( is_numeric( $row[eventID] ) ) {
		$query = "SELECT display, $eventtypes_table.eventtypeID as eventtypeID, tag FROM $eventtypes_table, $events_table WHERE eventID = $row[eventID] AND $eventtypes_table.eventtypeID = $events_table.eventtypeID";
		$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$evrow = mysql_fetch_assoc( $evresult );
		
		if( $evrow[display] ) {
			$dispvalues = explode( "|", $evrow[display] );
			$numvalues = count( $dispvalues );
			if( $numvalues > 1 ) {
				$displayval = "";
				for( $i = 0; $i < $numvalues; $i += 2 ) {
					$lang = $dispvalues[$i]; 
					if( $mylanguage == $lang ) {
						$displayval = $dispvalues[$i+1];
						break;
					}
				}
			}
			else
				$displayval = $row[display];
		}
		elseif( $evrow[tag] )
			$displayval = $eventtype[tag];
		else {
			$displayval = $admtext[$eventID];
		}
	}
	else {
		$eventID = $row[eventID];
		$displayval = $admtext[$eventID];
	}
	if( $type == "I" ) {
		$name = getName( $row );
		$persfamID = $row[personID];
	}
	elseif( $type == "F" ) {
		$hname = $wname = "";
		if( $row[husband] ) {
			$query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, branch FROM $people_table WHERE personID = \"$row[husband]\" AND gedcom = \"$row[gedcom]\"";
			$hresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			$prow = mysql_fetch_assoc( $hresult );
			mysql_free_result($hresult);
			$hname = getName( $prow );
		}
		if( $row[wife] ) {
			$query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, branch FROM $people_table WHERE personID = \"$row[wife]\" AND gedcom = \"$row[gedcom]\"";
			$wresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			$prow = mysql_fetch_assoc( $wresult );
			mysql_free_result($wresult);
			$wname = getName( $prow );
		}
		$plus = $hname && $wname ? " + " : "";
		$name = "$hname$plus$wname";
		$persfamID = $row[familyID];
	}
	$newactionstr = ereg_replace( "xxx", $row[tempID], $actionstr );
	echo "<tr id=\"row_$row[tempID]\"><td class=\"lightback\" valign=\"top\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
	echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">&nbsp;$persfamID&nbsp;</span></td>\n";
	echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">&nbsp;$name&nbsp;</span></td>\n";
	echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">&nbsp;$displayval&nbsp;</span></td>\n";
	echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">&nbsp;$row[postdate]&nbsp;</span></td>\n";
	echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">&nbsp;$row[treename]&nbsp;</span></td></tr>\n";
}
mysql_free_result($result);

?>
	</table>
<?php
	echo "<p>$admtext[matches]: $offsetplus $text[to] $numrowsplus $text[of] $totrows";
	echo " &nbsp; $pagenav</p>";
?>
	<p>
	<img src="tng_edit.gif" alt="<?php echo $admtext[review]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[review]; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext[text_delete]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[text_delete]; ?>
	</p>
	</div>
</td>
</tr>

</table>
<br />

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>