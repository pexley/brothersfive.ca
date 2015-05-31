<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$query = "SELECT * FROM $mediatypes_table WHERE mediatypeID = \"$mediatypeID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);

$helplang = findhelp("collections_help.php");

initMediaTypes();

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack normal" style="margin:10px;border:0px" id="editcollection">
<p class="subhead"><strong><?php echo $admtext['editcoll']; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/collections_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext[help]; ?></a></p>

<form action="updatecollection.php" method="post" name="collform" id="collform" onsubmit="return updateCollection(this);">
<table border="0" cellpadding="2" class="normal">
	<tr><td><?php echo $admtext['collid']; ?>:</td><td><?php echo $mediatypeID; ?></td></tr>
	<tr><td><?php echo $admtext['colldisplay']; ?>:</td><td><input type="text" name="display" size="30" value="<?php echo $row['display']; ?>"></td></tr>
	<tr><td><?php echo $admtext['collpath']; ?>:</td><td><input type="text" name="path" size="50" value="<?php echo $row['path']; ?>"></td></tr>
	<tr><td>&nbsp;</span></td><td><input type="button" value="<?php echo $admtext['makefolder']; ?>" onclick="if(document.collform.path.value){makeFolder('newcoll',document.collform.path.value);}"> <span id="msg_newcoll"></span></td></tr>
	<tr><td><?php echo $admtext['collicon']; ?>:</td><td><input type="text" name="icon" size="30" value="<?php echo $row['icon']; ?>"></td></tr>
	<tr><td><?php echo $admtext['displayorder']; ?>:</td><td><input type="text" name="ordernum" size="5" value="<?php echo $row['ordernum']; ?>"></td></tr>
	<tr><td><?php echo $admtext['colllike']; ?>:</td>
		<td>
			<span class="normal">
			<select name="liketype">
<?php
	foreach( $mediatypes as $mediatype ) {
		if(!$mediatype['type']) {
			$msgID = $mediatype[ID];
			echo "	<option value=\"$msgID\"";
			if( $msgID == $row['liketype'] ) echo " selected";
			echo ">" . $mediatype['display'] . "</option>\n";
		}
	}
?>
			</select>
			</span>
		</td>
	</tr>
</table>

<input type="hidden" name="collid" size="30" value="<?php echo $mediatypeID; ?>">
<input type="hidden" name="field" value="<?php echo $field; ?>">
<input type="hidden" name="selidx" value="<?php echo $selidx; ?>">
<input type="submit" value="<?php echo $admtext['save']; ?>">
<input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onclick="tnglitbox.remove();">
</form>
</div>
