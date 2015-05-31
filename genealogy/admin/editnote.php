<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "notes";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

$query = "SELECT $xnotes_table.note as note, $xnotes_table.ID as xID, secret, $notelinks_table.gedcom as gedcom, persfamID, eventID FROM $notelinks_table,  $xnotes_table 
	WHERE $notelinks_table.xnoteID = $xnotes_table.ID AND $notelinks_table.gedcom = $xnotes_table.gedcom AND $notelinks_table.ID = \"$noteID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);

$row['note'] = ereg_replace("\"", "&#34;",$row['note']);

$helplang = findhelp("notes_help.php");
header("Content-type:text/html; charset=" . $session_charset);
?>
<p class="subhead"><strong><?php echo $admtext['modifynote']; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/notes_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext['help']; ?></a></p>

<form action="" name="form3" onSubmit="return updateNote(this);">
<table border="0" cellpadding="2" class="normal">
	<tr><td valign="top"><?php echo $admtext['note']; ?>:</td>
	<td><textarea wrap cols="60" rows="18" name="note"><?php echo $row['note']; ?></textarea></td></tr>
	<tr><td>&nbsp;</td>
	<td>
<?php
	echo "<input type=\"checkbox\" name=\"private\" value=\"1\"";
	 if( $row['secret'] ) echo " checked";
	 echo "> $admtext[text_private]";
?>
	</td></tr>
</tr>
</table><br/>
<input type="hidden" name="xID" value="<?php echo $row['xID']; ?>">
<input type="hidden" name="ID" value="<?php echo $noteID; ?>">
<input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
<input type="hidden" name="persfamID" value="<?php echo $row['persfamID']; ?>">
<input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>">
<input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
<input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onClick="gotoSection('editnote','notelist');">
</form>
