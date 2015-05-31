<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "reports";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$showreport_url = $cms[support] ? "../../../$cms[url]=showreport&amp;" : "../showreport.php?";

session_register('tng_search_reports');
session_register('tng_search_reports_post');
$tng_search_tlevents = $_SESSION[tng_search_reports] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_reports_post[search]", $searchstring, $exptime);
	setcookie("tng_search_reports_post[page]", 1, $exptime);
	setcookie("tng_search_reports_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_reports_post][search];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_reports_post][page];
		$offset = $_COOKIE[tng_search_reports_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_reports_post[page]", $page, $exptime);
		setcookie("tng_search_reports_post[offset]", $offset, $exptime);
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

$wherestr = $searchstring ? "WHERE reportname LIKE \"%$searchstring%\" OR reportdesc LIKE \"%$searchstring%\"" : "";
$query = "SELECT reportID, reportname, reportdesc, rank, active FROM $reports_table $wherestr ORDER BY rank, reportname, reportID LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(reportID) as rcount FROM $reports_table $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[rcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("reports_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[reports], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confreportdelete']; ?>' ))
		deleteIt('report',ID);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$reporttabs[0] = array(1,"reports.php",$admtext['search'],"findreport");
	$reporttabs[1] = array($allow_add,"newreport.php",$admtext['addnew'],"addreport");
	$reporttabs[2] = array(1,"whatsnewmsg.php",$admtext['whatsnew'],"whatsnew");
	$reporttabs[3] = array(1,"mostwantedlist.php",$admtext['mostwanted'],"mostwanted");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/reports_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($reporttabs,"findreport",$innermenu);
	echo displayHeadline("$admtext[reports]","reports_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="reports.php" style="margin:0px;" name="form1">
	<?php echo $admtext[searchfor]; ?>: <input type="text" name="searchstring" value="<?php echo $searchstring; ?>">
	<input type="hidden" name="findreport" value="1"><input type="hidden" name="newsearch" value="1">
	<input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
	<input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value='';" style="vertical-align:top">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "reports.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>

	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['rank']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['id']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo "$admtext[name], $admtext[description]"; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['active']; ?>?</b>&nbsp;</nobr></td>
		</tr>

<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editreport.php?reportID=xxx\"><img src=\"tng_edit.gif\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"></a>";
		$actionstr .= "<a href=\"$showreport_url" . "reportID=xxx&amp;test=1\" target=\"_blank\"><img src=\"tng_test.gif\" alt=\"$admtext[test]\" $dims class=\"smallicon\"></a>";

		while( $row = mysql_fetch_assoc($result)) {
			$active = $row['active'] ? $admtext['yes'] : $admtext['no'];
			$newactionstr = ereg_replace( "xxx", $row['reportID'], $actionstr );
			echo "<tr id=\"row_$row[reportID]\"><td class=\"lightback\" valign=\"top\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[rank]</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">&nbsp;$row[reportID]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\"><u>$row[reportname]</u><br />$row[reportdesc]</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$active</span></td></tr>\n";
		}
?>
	</table>
<?php
		echo displayListLocation($offsetplus,$numrowsplus,$totrows);
		echo " &nbsp; $pagenav</p>";
	}
	else
		echo $admtext[norecords];
  	mysql_free_result($result);
?>
	<p>
	<img src="tng_edit.gif" alt="<?php echo $admtext[edit]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[edit]; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext[text_delete]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[text_delete]; ?> &nbsp;&nbsp;
	<img src="tng_test.gif" alt="<?php echo $admtext[test]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[test]; ?>
	</p>

	</div>
</td>
</tr>

</table>
</div>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
