<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if(!isset($tree)) $tree = "";
$query = "SELECT $eventtypes_table.eventtypeID, tag, display FROM $events_table
	LEFT JOIN  $eventtypes_table on $eventtypes_table.eventtypeID = $events_table.eventtypeID 
	WHERE eventID=\"$eventID\"";
$eventtypes = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$eventtype = mysql_fetch_assoc( $eventtypes );

if( $eventtype['display'] ) {
	$dispvalues = explode( "|", $eventtype['display'] );
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
		$eventtypedesc = $eventtype['display'];
}
elseif( $eventtype[tag] )
	$eventtypedesc = $eventtype['tag'];
elseif( $eventID ) {
	$eventtypedesc = $admtext[$eventID] ? $admtext[$eventID] : $admtext['notes'];
}
else
	$eventtypedesc = $admtext['general'];
mysql_free_result($eventtypes);

$helplang = findhelp("citations_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="citations">
<p class="subhead"><strong><?php echo "$admtext[citations]: $eventtypedesc"; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/citations_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext[help]; ?></a></p>
<form name="citeform">
<?php
	$xnotestr = $noteID ? " OR persfamID = \"$noteID\"" : "";
	$query = "SELECT citationID, $citations_table.sourceID as sourceID, description, title, shorttitle
		FROM $citations_table LEFT JOIN $sources_table on $citations_table.sourceID = $sources_table.sourceID AND $sources_table.gedcom = $citations_table.gedcom
		WHERE $citations_table.gedcom = \"$tree\" AND ((persfamID = \"$persfamID\" AND eventID = \"$eventID\")$xnotestr) ORDER BY citationID";
	$citresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$citationcount = mysql_num_rows( $citresult );
?>
		<table id="citationstbl" width="95%" class="normal" cellpadding="3" cellspacing="1" border="0"<?php if(!$citationcount) echo " style=\"display:none\""; ?>>
		<tbody id="citationstblbody">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname" width="85%"><nobr>&nbsp;<b><?php echo $admtext['title']; ?></b>&nbsp;</nobr></td>
		</tr>
<?php
	if( $citresult && $citationcount ) {
		while ( $citation = mysql_fetch_assoc( $citresult ) ) {
			$sourcetitle = $citation['title'] ? $citation['title'] : $citation['shorttitle'];
			$citationsrc = $citation[sourceID] ? "[$citation[sourceID]] $sourcetitle" : $citation[description];
			$citationsrc = cleanIt($citationsrc);
			$truncated = truncateIt($citationsrc,75);
			$actionstr = $allow_edit ? "<a href=\"#\" onclick=\"return editCitation($citation[citationID]);\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>" : "";
			$actionstr .= $allow_delete ? "<a href=\"#\" onClick=\"return deleteCitation($citation[citationID],'$persfamID','$tree','$eventID');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>" : "";
			echo "<tr id=\"row_$citation[citationID]\"><td class=\"lightback\">$actionstr</td><td class=\"lightback\">$truncated</td></tr>\n";
		}
		mysql_free_result($citresult);
	}
?>
		</tbody>
		</table>
	<br/>
<?php if( $allow_add ) { ?>
	<input type="button" value="  <?php echo $admtext['addnew']; ?>  " onClick="document.citeform2.reset();gotoSection('citations','addcitation');">&nbsp;
<?php } ?>
	<input type="button" value="  <?php echo $admtext['finish']; ?>  " onClick="if(subpage){gotoSection('citationslist','notelist');}else{tnglitbox.remove();}">
</form>
</div>

<div class="databack" style="margin:10px;border:0px;display:none;" id="addcitation">
<p class="subhead"><strong><?php echo $admtext['addnewcite']; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/citations_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext[help]; ?></a></p>

<form action="" name="citeform2" onSubmit="return addCitation(this);">
<table border="0" cellpadding="2">
	<tr><td valign="top"><span class="normal"><?php echo $admtext['source']; ?>:</span></td>
		<td>
			<span class="normal">
			<select name="sourceID">
				<option value=""></option>
<?php
	$query = "SELECT sourceID, title, shorttitle FROM $sources_table WHERE gedcom = \"$tree\" ORDER BY title, shorttitle, sourceID";
	$srcresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	while ( $source = mysql_fetch_assoc( $srcresult ) ) {
		$sourcetitle = $source['title'] ? $source['title'] : $source['shorttitle'];
		echo "<option value=\"$source[sourceID]\">" . substr($sourcetitle,0,54) . " - $source[sourceID]</option>\n";
	}
	mysql_free_result($srcresult);
?>
			</select>
			</span>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['page']; ?>:</span></td><td><input type="text" name="citepage" size="60"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['reliability']; ?>:</span></td>
		<td>
			<select name="quay">
				<option value=""></option>
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
			</select> <span class="normal">(<?php echo $admtext['relyexplain']; ?>)</span>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['citedate']; ?>:</span></td><td><input type="text" name="citedate" size="60" onBlur="checkDate(this);"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['actualtext']; ?>:</span></td><td><textarea cols="50" rows="5" name="citetext"></textarea></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['notes']; ?>:</span></td><td><textarea cols="50" rows="5" name="citenote"></textarea></td></tr>
</tr>
</table><br/>
<input type="hidden" name="persfamID" value="<?php echo $persfamID; ?>">
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
<input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
<input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onClick="gotoSection('addcitation','citations');">
</form>
</div>

<div class="databack" style="margin:10px;border:0px;display:none;" id="editcitation">
</div>