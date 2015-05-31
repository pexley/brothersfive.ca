<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "people";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$query = "SELECT passocID, relationship, gedcom FROM $assoc_table WHERE assocID = \"$assocID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row[relationship] = ereg_replace("\"", "&#34;",$row[relationship]);

$helplang = findhelp("assoc_help.php");
$dims = "width=\"18\" height=\"18\" border=\"0\" vspace=\"0\" hspace=\"2\"";

header("Content-type:text/html; charset=" . $session_charset);
?>

<p class="subhead"><strong><?php echo $admtext['modifyassoc']; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/assoc_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext['help']; ?></a></p>

<form action="" name="findassocform1" onSubmit="return updateAssociation(this);">
<table width="100%" border="0" cellpadding="2" class="normal">
	<tr><td valign="top"><?php echo $admtext[personid]; ?>:</td>
		<td valign="top"><input type="text" name="passocID" value="<?php echo $row['passocID']; ?>"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
		<a href="#" onclick="return openFindPersonForm('passocID');"><img src="tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?>></a></td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['relationship']; ?>:</span></td><td><input type="text" name="relationship" size="60" value="<?php echo $row[relationship]; ?>"></td></tr>
</table>
<input type="hidden" name="assocID" value="<?php echo $assocID; ?>">
<input type="hidden" name="tree" value="<?php echo $row[gedcom]; ?>">
<input type="submit" name="submit" value="<?php echo $admtext[save]; ?>">
</form>