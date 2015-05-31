<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "timeline";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

session_register('tng_search_tlevents');
session_register('tng_search_tlevents_post');
$tng_search_tlevents = $_SESSION[tng_search_tlevents] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_tlevents_post[search]", $searchstring, $exptime);
	setcookie("tng_search_tlevents_post[page]", 1, $exptime);
	setcookie("tng_search_tlevents_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_tlevents_post][search];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_tlevents_post][page];
		$offset = $_COOKIE[tng_search_tlevents_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_tlevents_post[page]", $page, $exptime);
		setcookie("tng_search_tlevents_post[offset]", $offset, $exptime);
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

$wherestr = $searchstring ? "WHERE evyear LIKE \"%$searchstring%\" OR evdetail LIKE \"%$searchstring%\"" : "";
$query = "SELECT tleventID, evyear, evdetail FROM $tlevents_table $wherestr ORDER BY evyear, tleventID LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(tleventID) as tlcount FROM $tlevents_table $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[tlcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("tlevents_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[tlevents], $flags );
?>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$timelinetabs[0] = array(1,"timelineevents.php",$admtext['search'],"findtimeline");
	$timelinetabs[1] = array($allow_add,"newtlevent.php",$admtext[addnew],"addtlevent");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/tlevents_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($timelinetabs,"findtimeline",$innermenu);
	echo displayHeadline("$admtext[tlevents]","tlevents_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">
	<form action="timelineevents.php" style="margin:0px;" name="form1">
	<?php echo $admtext['searchfor']; ?>: <input type="text" name="searchstring" value="<?php echo $searchstring; ?>">
	<input type="hidden" name="findtlevent" value="1"><input type="hidden" name="newsearch" value="1">
	<input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
	<input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value='';" style="vertical-align:top"></form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "timelineevents.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="deleteselected.php" method="post" style="margin:0px;" name="form2">
<?php
	if( $allow_delete ) {
?>
		<p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
  		<input type="submit" name="xtimeaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
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
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['evyear']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['evdetail']; ?></b>&nbsp;</nobr></td>
		</tr>
<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"edittlevent.php?tleventID=xxx\"><img src=\"tng_edit.gif\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"if(confirm('$admtext[confdeletetlevent]' )){deleteIt('tlevent',xxx);} return false;\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";

		while( $rowcount < $numrows && $row = mysql_fetch_assoc($result))
		{
			$newactionstr = ereg_replace( "xxx", $row[tleventID], $actionstr );
			echo "<tr id=\"row_$row[tleventID]\"><td class=\"lightback\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			if($allow_delete)
				echo "<td class=\"lightback\" align=\"center\"><input type=\"checkbox\" name=\"del$row[tleventID]\" value=\"1\"></td>";
			echo "<td class=\"lightback\" align=\"center\"><span class=\"normal\">$row[evyear]&nbsp;</span></td><td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[evdetail]&nbsp;</span></td></tr>\n";
		}
?>
	</table>
<?php
		echo displayListLocation($offsetplus,$numrowsplus,$totrows);
		echo " &nbsp; $pagenav</p>";
	}
	else
		echo $admtext['norecords'];
  	mysql_free_result($result);
?>
	</form>

	<p style="vertical-align:middle">
	<img src="tng_edit.gif" alt="<?php echo $admtext['edit']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['edit']; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext['text_delete']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['text_delete']; ?> &nbsp;&nbsp;
	</p>

	</div>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
