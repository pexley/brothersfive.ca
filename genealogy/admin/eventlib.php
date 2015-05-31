<?php
function showCustEvents($id) {
	global $tree, $admtext, $events_table, $eventtypes_table, $allow_edit, $allow_delete, $gotnotes, $gotcites, $dims, $mylanguage;

	echo "<div id=\"custevents\" style=\"margin-bottom:5px\">\n";

	$query = "SELECT display, eventdate, eventplace, info, $events_table.eventID as eventID FROM $events_table, $eventtypes_table WHERE persfamID = \"$id\" AND gedcom = \"$tree\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID ORDER BY eventdatetr, ordernum";
	$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$eventcount = mysql_num_rows( $evresult );

	echo "<table id=\"custeventstbl\" class=\"normal\" cellpadding=\"3\" cellspacing=\"1\" border=\"0\"";
	if(!$eventcount) echo " style=\"display:none\"";
	echo ">";
	echo "<tbody id=\"custeventstblbody\">\n";
	echo "<tr>\n";
	echo "<td class=\"fieldnameback fieldname\" width=\"42\"><nobr>&nbsp;<b>" . $admtext['action'] . "</b>&nbsp;</nobr></td>\n";
	echo "<td class=\"fieldnameback fieldname\"><nobr>&nbsp;<b>" . $admtext['event'] . "</b>&nbsp;</nobr></td>\n";
	echo "<td class=\"fieldnameback fieldname\"><nobr>&nbsp;<b>" . $admtext['eventdate'] . "</b>&nbsp;&nbsp;&nbsp;</nobr></td>\n";
	echo "<td class=\"fieldnameback fieldname\"><nobr>&nbsp;<b>" . $admtext['eventplace'] . "</b>&nbsp;</nobr></td>\n";
	echo "<td class=\"fieldnameback fieldname\"><nobr>&nbsp;<b>" . $admtext['detail'] . "</b>&nbsp;</nobr></td>\n";
	echo "</tr>\n";

	if( $evresult && $eventcount ) {
		while ( $event = mysql_fetch_assoc( $evresult ) ) {
			$dispvalues = explode( "|", $event[display] );
			$numvalues = count( $dispvalues );
			if( $numvalues > 1 ) {
				$displayval = "";
				for( $i = 0; $i < $numvalues; $i += 2 ) {
					$lang = $dispvalues[$i];
					if( $mylanguage == $lang ) {
						$displayval = $dispvalues[$i+1];
						break;
					}
				}
			}
			else
				$displayval = $event[display];
			$info = cleanIt($event[info]);
			$truncated = substr($info,0,90);
			$info = strlen($info) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $info;

			$actionstr = $allow_edit ? "<a href=\"#\" onclick=\"return editEvent($event[eventID]);\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>" : "";
			$actionstr .= $allow_delete ? "<a href=\"#\" onclick=\"return deleteEvent('$event[eventID]');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>" : "&nbsp;";
			if(isset($gotnotes)) {
				$notesicon = $gotnotes[$event['eventID']] ? "tng_note_on.gif" : "tng_note.gif";
				$actionstr .= "<a href=\"#\" onclick=\"return showNotes('$event[eventID]');\"><img src=\"$notesicon\" title=\"$admtext[notes]\" alt=\"$admtext[notes]\" $dims id=\"notesicon$event[eventID]\" class=\"smallicon\"/></a>";
			}
			if(isset($gotcites)) {
				$citesicon = $gotcites[$event['eventID']] ? "tng_cite_on.gif" : "tng_cite.gif";
				$actionstr .= "<a href=\"#\" onclick=\"return showCitations('$event[eventID]');\"><img src=\"$citesicon\" title=\"$admtext[sources]\" alt=\"$admtext[sources]\" $dims id=\"citesicon$event[eventID]\" class=\"smallicon\"/></a>";
			}
			echo "<tr id=\"row_$event[eventID]\"><td class=\"lightback\">$actionstr</td><td class=\"lightback\">$displayval</td><td class=\"lightback\">$event[eventdate]&nbsp;</td><td class=\"lightback\">$event[eventplace]&nbsp;</td><td class=\"lightback\">$info&nbsp;</td></tr>\n";
		}
		mysql_free_result($evresult);
	}

	echo "</tbody>\n";
	echo "</table>\n";
	echo "</div>\n";
}
?>
<script type="text/javascript" src="selectutils.js"></script>
<script type="text/javascript" src="datevalidation.js"></script>
<script type="text/javascript">
var tnglitbox;
var preferEuro = <?php echo ($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
var tree = "<?php echo $tree; ?>";
var entereventtype = "<?php echo $admtext['entereventtype']; ?>";
var entereventinfo = "<?php echo $admtext['entereventinfo']; ?>";
var confdeleteevent = "<?php echo $admtext['confdeleteevent']; ?>";

var enternote = "<?php echo $admtext['enternote']; ?>";
var confdeletenote = "<?php echo $admtext['confdeletenote']; ?>";

var selectsource = "<?php echo $admtext['selectsource']; ?>";
var confdeletecite = "<?php echo $admtext['confdeletecite']; ?>";

var enterpassoc = "<?php echo $admtext['enterpassoc']; ?>";
var enterrela = "<?php echo $admtext['enterrela']; ?>";
var confdeleteassoc = "<?php echo $admtext['confdeleteassoc']; ?>";

var editmsg = "<?php echo $admtext['edit']; ?>";
var delmsg = "<?php echo $admtext['text_delete']; ?>";
var notemsg = "<?php echo $admtext['notes']; ?>";
var citemsg = "<?php echo $admtext['sources']; ?>";
</script>
