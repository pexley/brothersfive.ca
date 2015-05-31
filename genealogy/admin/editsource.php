<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$showsource_url = getURL( "showsource", 1 );

$sourceID = ucfirst( $sourceID );

$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc( $result );
mysql_free_result($result);

$query = "SELECT *, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") as changedate FROM $sources_table WHERE sourceID = \"$sourceID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row['shorttitle'] = ereg_replace("\"", "&#34;",$row[shorttitle]);
$row['title'] = ereg_replace("\"", "&#34;",$row[title]);
$row['author'] = ereg_replace("\"", "&#34;",$row[author]);
$row['callnum'] = ereg_replace("\"", "&#34;",$row[callnum]);
$row['publisher'] = ereg_replace("\"", "&#34;",$row[publisher]);
$row['actualtext'] = ereg_replace("\"", "&#34;",$row[actualtext]);

$sourcename = $row['title'] ? $row['title'] : $row['shorttitle'];
$row['allow_living'] = 1;

$query = "SELECT DISTINCT eventID as eventID FROM $notelinks_table WHERE persfamID=\"$sourceID\" AND gedcom =\"$tree\"";
$notelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$gotnotes = array();
while( $note = mysql_fetch_assoc( $notelinks ) ) {
	if( !$note[eventID] ) $note[eventID] = "general";
	$gotnotes[$note[eventID]] = "*";
}

$helplang = findhelp("sources_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[modifysource], $flags );
$photo = showSmallPhoto( $sourceID, $sourcename, 1, 0, true );
include_once("eventlib.php");
?>
<script type="text/javascript">
var persfamID = "<?php echo $sourceID; ?>";
var allow_cites = false;
var allow_notes = true;
</script>
<script language="JavaScript" src="selectutils.js"></script>
</head>

<body background="../background.gif">

<?php
	$sourcetabs[0] = array(1,"sources.php",$admtext['search'],"findsource");
	$sourcetabs[1] = array($allow_add,"newsource.php",$admtext[addnew],"addsource");
	$sourcetabs[2] = array($allow_edit && $allow_delete,"mergesources.php",$admtext['merge'],"merge");
	$sourcetabs[3] = array($allow_edit,"editsource.php?sourceID=$sourceID&tree=$tree",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/sources_help.php#edit', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"$showsource_url" . "repoID=$sourceID&amp;tree=$tree\" target=\"_blank\" class=\"lightlink\">$admtext[test]</a>";
	if( $allow_add && ( !$assignedtree || $assignedtree == $tree ) )
		$innermenu .= " &nbsp;|&nbsp; <a href=\"newmedia.php?personID=$sourceID&amp;tree=$tree&amp;linktype=S\" class=\"lightlink\">$admtext[addmedia]</a>";
	$menu = doMenu($sourcetabs,"edit",$innermenu);
	echo displayHeadline("$admtext[sources] &gt;&gt; $admtext[modifysource]","sources_icon.gif",$menu,$message);
?>

<form action="updatesource.php" method="post" name="form1" style="margin:0px">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table cellpadding="0" cellspacing="0" class="normal">
		<tr>
			<td valign="top"><div id="thumbholder" style="margin-right:5px;<?php if(!$photo) echo "display:none"; ?>"><?php echo $photo; ?></div></td>
			<td>
				<span style="font-size:21px"><?php echo "$sourcename ($sourceID)</span>"; ?>
				<div style="margin-top:12px;margin-bottom:12px" class="smallest">
<?php
				$notesicon = $gotnotes['general'] ? "tng_note_on.gif" : "tng_note.gif";
				echo "<a href=\"#\" onclick=\"document.form1.submit();\"><img src=\"tng_save.gif\" title=\"$admtext[save]\" alt=\"$admtext[save]\" $dims class=\"smallicon\" style=\"vertical-align:middle;\"/></a> <a href=\"#\" onclick=\"document.form1.submit();\">$admtext[save]</a> &nbsp;&nbsp;\n";
				echo "<a href=\"#\" onclick=\"return showNotes('');\"><img src=\"$notesicon\" title=\"$admtext[notes]\" alt=\"$admtext[notes]\" $dims id=\"notesicon\" class=\"smallicon\" style=\"vertical-align:middle;\"/></a> <a href=\"#\" onclick=\"return showNotes('');\">$admtext[notes]</a> &nbsp;&nbsp;\n";
?>
				</div>
				<span class="smallest"><?php echo $admtext['lastmodified'] . ": $row[changedate] ($row[changedby])"; ?></span>
			</td>
		</tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['tree']; ?>:</span></td><td><span class="normal"><?php echo $treerow['treename']; ?></span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['shorttitle']; ?>:</span></td><td><span class="normal"><input type="text" name="shorttitle" size="40" value="<?php echo $row[shorttitle]; ?>"> (<?php echo $admtext['required']; ?>)</span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['longtitle']; ?>:</span></td><td><input type="text" name="title" size="50" value="<?php echo $row['title']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['author']; ?>:</span></td><td><input type="text" name="author" size="40" value="<?php echo $row['author']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['callnumber']; ?>:</span></td><td><input type="text" name="callnum" size="20" value="<?php echo $row['callnum']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['publisher']; ?>:</span></td><td><input type="text" name="publisher" size="40" value="<?php echo $row['publisher']; ?>"></td></tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['repository']; ?>:</span></td>
		<td>
			<select name="repoID">
				<option value=""></option>
<?php
$query = "SELECT repoID, reponame, gedcom FROM $repositories_table WHERE gedcom = \"$tree\" ORDER BY reponame";
$reporesult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
while( $reporow = mysql_fetch_assoc($reporesult) ) {
	echo "		<option value=\"$reporow[repoID]\"";
	if( $reporow[repoID] == $row[repoID] ) echo " selected";
	if( !$assignedtree && $numtrees > 1 )
		echo ">$reporow[reponame] ($admtext[tree]: $reporow[gedcom])</option>\n";
	else
		echo ">$reporow[reponame]</option>\n";
}
mysql_free_result( $reporesult );
?>
			</div>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['actualtext']; ?>:</span></td><td><textarea cols="50" rows="5" name="actualtext"><?php echo $row['actualtext']; ?></textarea></td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['otherevents']; ?>:</span></td>
		<td>
<?php
	echo "<input type=\"button\" value=\"  " . $admtext['addnew'] . "  \" onClick=\"newEvent('S','$sourceID','$tree');\">&nbsp;\n";
?>
   		</td>
	</tr>
	</table>
<?php
		showCustEvents($sourceID);
?>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<p class="normal">
<?php
	echo "$admtext[onsave]:<br/>";
	echo "<input type=\"radio\" name=\"newscreen\" value=\"return\"> $admtext[savereturn]<br/>\n";
	if( $cw )
		echo "<input type=\"radio\" name=\"newscreen\" value=\"close\" checked> $text[closewindow]\n";
	else
		echo "<input type=\"radio\" name=\"newscreen\" value=\"none\" checked> $admtext[saveback]\n";
?>
	</p>
	<input type="hidden" name="tree" value="<?php echo $tree; ?>">
	<input type="hidden" name="sourceID" value="<?php echo "$sourceID"; ?>">
	<input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
	<input type="submit" name="submit2" accesskey="s" value="<?php echo $admtext[save]; ?>">
</td>
</tr>

</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
