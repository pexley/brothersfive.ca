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

$query = "SELECT userID, description, username, gedcom, branch, allow_edit, allow_add, allow_delete, allow_living, allow_lds, allow_ged, realname, email, DATE_FORMAT(dt_registered,\"%d %b %Y %H:%i:%s\") as dt_registered FROM $users_table WHERE allow_living = \"-1\"ORDER BY description";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );

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
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/users_help.php#addreg', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($usertabs,"review",$innermenu);
	echo displayHeadline("$admtext[users] &gt;&gt; $admtext[review]","users_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">
	<em><?php echo $admtext['editnewusers']; ?></em><br/><br/>
<?php
	echo "<p>$admtext[matches]: <span class=\"restotal\">$numrows</span></p>";
?>
	<form action="deleteselected.php" method="post" style="margin:0px" name="form2">
<?php
	if( $allow_delete ) {
?>
		<p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
  		<input type="submit" name="xruseraction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext[confdeleterecs]; ?>');">
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
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['username']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['description']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['realname'] . " / " . $admtext['email']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['dtregistered']; ?></b>&nbsp;</nobr></td>
		</tr>
	
<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"edituser.php?newuser=1&amp;userID=xxx\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" width=\"20\" height=\"20\" class=\"smallicon\"></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" width=\"20\" height=\"20\" class=\"smallicon\"></a>";

		while( $row = mysql_fetch_assoc($result)) {
			$newactionstr = ereg_replace( "xxx", $row[userID], $actionstr );
			echo "<tr id=\"row_$row[userID]\"><td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			if($allow_delete)
				echo "<td class=\"lightback\" valign=\"top\" align=\"center\"><input type=\"checkbox\" name=\"del$row[userID]\" value=\"1\"></td>";
			echo "<td class=\"lightback\" valign=\"top\" nowrap><span class=\"normal\">$row[username]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[description]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[realname]";
			if($row['realname'] && $row['email']) echo "<br />";
			echo "<a href=\"mailto:" . $row['email'] . "\">" . $row['email'] . "</a>&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[dt_registered]&nbsp;</span></td>\n";
		}
?>
	</table>
<?php
		echo "<p>$admtext[matches]: <span class=\"restotal\">$numrows</span></p>";
	}
	else
		echo $admtext[norecords];
  	mysql_free_result($result);
?>
	</form>

	<p style="vertical-align:middle">
	<img src="tng_edit.gif" alt="<?php echo $admtext['edit']; ?>" width="20" height="20" class="smallicon" align="middle"> = <?php echo $admtext['edit']; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext['text_delete']; ?>" width="20" height="20" class="smallicon" align="middle"> = <?php echo $admtext['text_delete']; ?> &nbsp;&nbsp;
	</p>

	</div>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
