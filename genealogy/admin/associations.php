<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "people";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix FROM $people_table
	WHERE personID=\"$personID\" AND gedcom=\"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$namestr = getName($row);
mysql_free_result($result);

$helplang = findhelp("assoc_help.php");
$dims = "width=\"20\" height=\"20\" border=\"0\" vspace=\"0\" hspace=\"2\"";

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="associations">
<p class="subhead"><strong><?php echo "$admtext[associations]: $namestr"; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/assoc_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext['help']; ?></a></p>
<form name="assocform">
<?php
	$query = "SELECT assocID, passocID, relationship, firstname, lastname, lnprefix, nameorder, prefix, suffix FROM $assoc_table LEFT JOIN $people_table ON
		$assoc_table.passocID=$people_table.personID AND $assoc_table.gedcom=$people_table.gedcom WHERE $assoc_table.personID=\"$personID\" AND $assoc_table.gedcom=\"$tree\"";
	$assocresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$assoccount = mysql_num_rows( $assocresult );
?>
		<table id="associationstbl" width="95%" class="normal" cellpadding="3" cellspacing="1" border="0"<?php if(!$assoccount) echo " style=\"display:none\""; ?>>
		<tbody id="associationstblbody">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname" width="85%"><nobr>&nbsp;<b><?php echo $admtext['description']; ?></b>&nbsp;</nobr></td>
		</tr>
<?php
	if( $assocresult && $assoccount ) {
		while ( $assoc = mysql_fetch_assoc( $assocresult ) ) {
			$assocname = getName($assoc) . "($assoc[passocID]): " . $assoc['relationship'];
			$assocname = cleanIt($assocname);
			$truncated = truncateIt($assocname,75);
			$actionstr = $allow_edit ? "<a href=\"#\" onclick=\"return editAssociation($assoc[assocID]);\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims></a>" : "";
			$actionstr .= $allow_delete ? "<a href=\"#\" onclick=\"return deleteAssociation($assoc[assocID],'$personID','$tree');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims></a>" : "";
			echo "<tr id=\"row_$assoc[assocID]\"><td class=\"lightback\">$actionstr</td><td class=\"lightback\">$truncated</td></tr>\n";
		}
		mysql_free_result($assocresult);
	}
?>
		</tbody>
		</table>
	<br/>
<?php if( $allow_add ) { ?>
	<input type="button" value="  <?php echo $admtext['addnew']; ?>  " onClick="document.newassocform1.reset();gotoSection('associations','addassociation');">&nbsp;
<?php } ?>
	<input type="button" value="  <?php echo $admtext['finish']; ?>  " onClick="tnglitbox.remove();">
</form>
</div>

<div class="databack" style="margin:10px;border:0px;display:none;" id="addassociation">
<p class="subhead"><strong><?php echo $admtext['addnewassoc']; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/assoc_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext['help']; ?></a></p>

<form action="" name="newassocform1" onSubmit="return addAssociation(this);">
<table width="100%" border="0" cellpadding="2" class="normal">
	<tr><td valign="top"><?php echo $admtext['personid']; ?>:</td>
		<td valign="top"><input type="text" name="passocID" id="passocID"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
		<a href="#" onclick="return openFindPersonForm('passocID','','text');"><img src="tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?>></a></td>
	</tr>
	<tr><td valign="top"><?php echo $admtext['relationship']; ?>:</td><td><input type="text" name="relationship" size="60"></td></tr>
	<tr><td colspan="2"><input type="checkbox" name="revassoc" value="1"> <?php echo $admtext['revassoc']; ?>:</td></tr>
</tr>
</table>
<input type="hidden" name="personID" value="<?php echo $personID; ?>">
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
<input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onClick="gotoSection('addassociation','associations');">
</form>
<br />
</div>

<div class="databack" style="margin:10px;border:0px;display:none;" id="editassociation">
</div>