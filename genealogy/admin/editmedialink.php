<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$query = "SELECT eventID, altdescription, altnotes, treename, defphoto, linktype, personID, $medialinks_table.gedcom
	FROM ($medialinks_table, $trees_table)
	WHERE medialinkID = \"$linkID\" AND $medialinks_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$meventID = $row['eventID'];

function doEvent($eventID, $displayval, $info) {
	global $meventID;
	return "<option value=\"$eventID\"" . ($eventID == $meventID ? " selected" : "") . ">$displayval" . ($info ? ": $info" : "") . "</option>\n";
}

$options = "<option value=\"\">$text[none]</option>";
if( $row['linktype'] == "I" ) {
	//standard people events
	$list = array("NAME","BIRT","CHR","DEAT","BURI");
	foreach( $list as $eventtype )
		$options .= doEvent($eventtype,$admtext[$eventtype],'');
	if($allow_lds) {
		$ldslist = array("BAPL","ENDL","SLGC");
		foreach( $ldslist as $eventtype )
			$options .= doEvent($eventtype,$admtext[$eventtype],'');
	}
}
elseif( $row['linktype'] == "F" ) {
	//standard family events
	$list = array("MARR","DIV");
	foreach( $list as $eventtype )
		$options .= doEvent($eventtype,$admtext[$eventtype],'');
	if($allow_lds) {
		$ldslist = array("SLGS");
		foreach( $ldslist as $eventtype )
			$options .= doEvent($eventtype,$admtext[$eventtype],'');
	}
}

//now call up custom events linked to passed in entity
$query = "SELECT display, eventdate, eventplace, info, eventID FROM $events_table, $eventtypes_table WHERE persfamID = \"$row[personID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND gedcom = \"$row[gedcom]\" AND keep = \"1\" AND parenttag = \"\" ORDER BY ordernum, tag, description, eventdatetr, info, eventID";
$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
while ( $custevent = mysql_fetch_assoc( $custevents ) )	{
	$displayval = getEventDisplay( $custevent[display] );
	$info = "";
	if( $custevent[eventdate] )
		$info = displayDate($custevent[eventdate]);
	elseif( $custevent[eventplace] )
		$info = truncateIt($custevent[eventplace],20);
	elseif( $custevent[info] )
		$info = truncateIt($custevent[info],20);
	$options .= doEvent($custevent[eventID],$displayval,$info);
}
mysql_free_result( $custevents );

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px">
<p class="subhead"><strong><?php echo $admtext['editmedialink']; ?></strong></p>
<form action="" method="post" name="editlinkform" id="editlinkform" onSubmit="return updateMedia2EntityLink(this);" style="margin:0px;">
<table border="0" cellpadding="2" class="normal">
	<tr><td valign="top"><span class="normal"><?php echo $admtext['event']; ?>:</span></td>
		<td>
			<select name="eventID" id="eventID">
				<?php echo $options; ?>
			</select>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['alttitle']; ?>:</span></td><td><textarea name="altdescription" rows="3" cols="40"><?php echo $row['altdescription']; ?></textarea></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['altdesc']; ?>:</span></td><td><textarea name="altnotes" rows="4" cols="40"><?php echo $row['altnotes']; ?></textarea></td></tr>
	<tr><td valign="top" colspan="2"><span class="normal"><input type="checkbox" name="defphoto" value="1"<?php if($row['defphoto']) echo " checked"; ?>> <?php echo $admtext['makedefault']; ?>*</span></td></tr>
</table><br/>
<input type="hidden" name="medialinkID" value="<?php echo $linkID; ?>">
<input type="hidden" name="personID" value="<?php echo $row['personID']; ?>">
<input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
<input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
<input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onclick="tnglitbox.remove();">
<p class="normal">
<?php
	echo "*$admtext[defphotonote]\n";
?>
</p>
</form>
</div>
