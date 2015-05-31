<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "notes";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$query = "SELECT $eventtypes_table.eventtypeID, tag, display FROM $events_table 
	LEFT JOIN  $eventtypes_table on $eventtypes_table.eventtypeID = $events_table.eventtypeID 
	WHERE eventID=\"$eventID\"";
$eventtypes = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$eventtype = mysql_fetch_assoc( $eventtypes );

if( $eventtype[display] ) {
	$dispvalues = explode( "|", $eventtype[display] );
	$numvalues = count( $dispvalues );
	if( $numvalues > 1 ) {
		$displayval = "";
		for( $i = 0; $i < $numvalues; $i += 2 ) {
			$lang = $dispvalues[$i]; 
			if( $mylanguage == $lang ) {
				$eventtypedesc = $dispvalues[$i+1];
				break;
			}
		}
	}
	else
		$eventtypedesc = $eventtype[display];
}
elseif( $eventtype[tag] )
	$eventtypedesc = $eventtype[tag];
elseif( $eventID ) {
	$eventtypedesc = $admtext[$eventID];
}
else
	$eventtypedesc = $admtext[general];
mysql_free_result($eventtypes);

$helplang = findhelp("notes_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="notelist">
<p class="subhead"><strong><?php echo "$admtext[notes]: $eventtypedesc"; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/notes_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext['help']; ?></a></p>
<form name="form1">
	<div id="notes">
<?php
	$query = "SELECT $notelinks_table.ID as ID, $xnotes_table.note as note, noteID FROM ($notelinks_table, $xnotes_table)
		WHERE $notelinks_table.xnoteID = $xnotes_table.ID AND $notelinks_table.gedcom = $xnotes_table.gedcom
			AND persfamID=\"$persfamID\" AND $notelinks_table.gedcom =\"$tree\" AND eventID = \"$eventID\" ORDER BY ID";
	$notelinks = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$notecount = mysql_num_rows( $notelinks );
?>
		<table id="notestbl" width="95%" class="normal" cellpadding="3" cellspacing="1" border="0"<?php if(!$notecount) echo " style=\"display:none\""; ?>>
		<tbody id="notestblbody">
		<tr>
			<td class="fieldnameback fieldname"><b><?php echo $admtext['action']; ?></b></td>
			<td class="fieldnameback fieldname" width="85%"><b><?php echo $admtext['note']; ?></b></td>
		</tr>
<?php
	if( $notelinks && $notecount ) {

		while ( $note = mysql_fetch_assoc( $notelinks ) ) {
			$citquery = "SELECT citationID FROM $citations_table WHERE gedcom = \"$tree\" AND ";
			if($note['noteID'])
				$citquery .= "((persfamID = \"$persfamID\" AND eventID = \"N$note[ID]\") OR persfamID = \"$note[noteID]\")";
			else
				$citquery .= "persfamID = \"$persfamID\" AND eventID = \"N$note[ID]\"";
			$citresult = mysql_query($citquery) or die ("$text[cannotexecutequery]: $citquery");
			$citesicon = mysql_num_rows($citresult) ? "tng_cite_on.gif" : "tng_cite.gif";
			mysql_free_result($citresult);

			$note[note] = cleanIt($note[note]);
			$truncated = truncateIt($note[note],75);
			$actionstr = $allow_edit ? "<a href=\"#\" onclick=\"return editNote($note[ID]);\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>" : "";
			$actionstr .= $allow_delete ? "<a href=\"#\" onClick=\"return deleteNote($note[ID],'$persfamID','$tree','$eventID');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>" : "";
			$actionstr .= "<a href=\"#\" onClick=\"return showCitationsInside('N$note[ID]','$note[noteID]');\"><img src=\"$citesicon\" title=\"$admtext[sources]\" alt=\"$admtext[sources]\" $dims id=\"citesicon$note[ID]\" class=\"smallicon\"/></a>";
			echo "<tr id=\"row_$note[ID]\"><td class=\"lightback\">$actionstr</td><td class=\"lightback\">$truncated</td></tr>\n";
		}
		mysql_free_result($notelinks);
	}
?>
		</tbody>
		</table>
	</div>
	<br/>
<?php if( $allow_add ) { ?>
	<input type="button" value="  <?php echo $admtext['addnew']; ?>  " onClick="document.form2.reset();gotoSection('notelist','addnote');">&nbsp;
<?php } ?>
	<input type="button" value="  <?php echo $admtext['finish']; ?>  " onClick="tnglitbox.remove();">
</form>
</div>

<div class="databack" style="margin:10px;border:0px;display:none;" id="addnote">
<p class="subhead"><strong><?php echo $admtext['addnewnote']; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/notes_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext[help]; ?></a></p>

<form action="" name="form2" onSubmit="return addNote(this);">
<table border="0" cellpadding="2" class="normal">
	<tr><td valign="top"><?php echo $admtext['note']; ?>:</td>
	<td><textarea wrap cols="60" rows="18" name="note"></textarea></td></tr>
	<tr><td>&nbsp;</td><td><input type="checkbox" name="private" value="1"> <?php echo $admtext['text_private']; ?></td></tr>
</tr>
</table><br/>
<input type="hidden" name="persfamID" value="<?php echo $persfamID; ?>">
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
<input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
<input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onClick="gotoSection('addnote','notelist');">
</form>
</div>

<div class="databack" style="margin:10px;border:0px;display:none;" id="editnote">
</div>

<div style="display:none;" id="citationslist">
</div>
