<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "users";
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

session_register('tng_search_users');
session_register('tng_search_users_post');
$tng_search_users = $_SESSION[tng_search_users] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_users_post[search]", $searchstring, $exptime);
	setcookie("tng_search_users_post[adminonly]", $adminonly, $exptime);
	setcookie("tng_search_users_post[page]", 1, $exptime);
	setcookie("tng_search_users_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_users_post][search];
	if( !$adminonly )
		$adminonly = $_COOKIE[tng_search_users_post][adminonly];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_users_post][page];
		$offset = $_COOKIE[tng_search_users_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_users_post[page]", $page, $exptime);
		setcookie("tng_search_users_post[offset]", $offset, $exptime);
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

$wherestr = $searchstring ? " AND (username LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR realname LIKE \"%$searchstring%\" OR email LIKE \"%$searchstring%\")" : "";
$wherestr .= $adminonly ? " AND (allow_add = \"1\" OR allow_edit = \"1\" OR allow_delete = \"1\") AND gedcom = \"\"" : "";
$query = "SELECT userID, description, username, gedcom, branch, allow_edit, allow_add, allow_delete, allow_living, allow_lds, allow_ged, realname, email, DATE_FORMAT(lastlogin,\"%d %b %Y %H:%i:%s\") as lastlogin FROM $users_table WHERE allow_living != \"-1\" $wherestr ORDER BY description LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(userID) as ucount FROM $users_table WHERE allow_living != \"-1\" $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[ucount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$revquery = "SELECT count(userID) as ucount FROM $users_table WHERE allow_living = \"-1\"";
$revresult = mysql_query($revquery) or die ("$text[cannotexecutequery]: $revquery");
$revrow = mysql_fetch_assoc( $revresult );
$revstar = $revrow[ucount] ? " *" : "";
mysql_free_result($revresult);

$helplang = findhelp("users_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[users], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confuserdelete']; ?>' ))
		deleteIt('user',ID);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$usertabs[0] = array(1,"users.php",$admtext['search'],"finduser");
	$usertabs[1] = array($allow_add,"newuser.php",$admtext[addnew],"adduser");
	$usertabs[2] = array($allow_edit,"reviewusers.php",$admtext[review] . $revstar,"review");
	$usertabs[3] = array(1,"mailusers.php",$admtext[email],"mail");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/users_help.php#existing', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($usertabs,"finduser",$innermenu);
	echo displayHeadline("$admtext[users]","users_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="users.php" style="margin:0px;" name="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>"></td>
			<td>
				<input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value=''; document.form1.adminonly.checked=false;" style="vertical-align:top">
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">
				<span class="normal">
				<input type="checkbox" name="adminonly" value="yes"<?php if( $adminonly == "yes" ) echo " checked"; ?>> <?php echo $admtext[adminonly]; ?>
				</span>
			</td>
		</tr>
	</table>

	<input type="hidden" name="finduser" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "users.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="deleteselected.php" method="post" style="margin:0px" name="form2">
<?php
	if( $allow_delete ) {
?>
		<p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
  		<input type="submit" name="xuseraction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
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
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['username']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['description']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['realname'] . " / " . $admtext['email']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['admin']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['branch']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['edit']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['add']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['text_delete']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['living']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['gedcom']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['lds']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['lastlogin']; ?></b>&nbsp;</nobr></td>
		</tr>
	
<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"edituser.php?userID=xxx\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result)) {
			$form_allow_admin = $row['gedcom'] || ( !$row['allow_edit'] && !$row['allow_add'] && !$row['allow_delete'] ) ? "" : $admtext['yes'];
			$form_allow_edit = $row['allow_edit'] ? $admtext['yes'] : "";
			$form_allow_add = $row['allow_add'] ? $admtext['yes'] : "";
			$form_allow_delete = $row['allow_delete'] ? $admtext['yes'] : "";
			$form_allow_lds = $row['allow_lds'] ? $admtext['yes'] : "";
			$form_allow_living = $row['allow_living'] > 0 ? $admtext['yes'] : "";
			$form_allow_ged = $row['allow_ged'] ? $admtext['yes'] : "";
			$newactionstr = ereg_replace( "xxx", $row['userID'], $actionstr );
			echo "<tr id=\"row_$row[userID]\"><td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			if($allow_delete)
				echo "<td class=\"lightback\" valign=\"top\" align=\"center\"><input type=\"checkbox\" name=\"del$row[userID]\" value=\"1\"></td>";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">$row[username]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[description]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[realname]";
			if($row['realname'] && $row['email']) echo "<br />";
			echo "<a href=\"mailto:" . $row['email'] . "\">" . $row['email'] . "</a>&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">&nbsp;$form_allow_admin&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">&nbsp;$row[gedcom]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">&nbsp;$row[branch]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">&nbsp;$form_allow_edit&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">&nbsp;$form_allow_add&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">&nbsp;$form_allow_delete&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">&nbsp;$form_allow_living&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">&nbsp;$form_allow_ged&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">&nbsp;$form_allow_lds&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[lastlogin]&nbsp;</span></td>\n";
			echo "</tr>\n";
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
	</form>

	<p>
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
