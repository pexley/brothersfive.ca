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

$showrepo_url = getURL( "showrepo", 1 );

$repoID = ucfirst( $repoID );

$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc( $result );
mysql_free_result($result);

$query = "SELECT reponame, changedby, $repositories_table.addressID, address1, address2, city, state, zip, country, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") as changedate FROM $repositories_table LEFT JOIN $address_table on $repositories_table.addressID = $address_table.addressID WHERE repoID = \"$repoID\" AND $repositories_table.gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row[reponame] = ereg_replace("\"", "&#34;",$row[reponame]);

$row['allow_living'] = 1;

$query = "SELECT DISTINCT eventID as eventID FROM $notelinks_table WHERE persfamID=\"$repoID\" AND gedcom =\"$tree\"";
$notelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$gotnotes = array();
while( $note = mysql_fetch_assoc( $notelinks ) ) {
	if( !$note[eventID] ) $note[eventID] = "general";
	$gotnotes[$note[eventID]] = "*";
}

$helplang = findhelp("repositories_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[modifyrepo], $flags );
$photo = showSmallPhoto( $repoID, $row['reponame'], 1, 0, true );
include_once("eventlib.php");
?>
<script type="text/javascript">
var persfamID = "<?php echo $repoID; ?>";
var allow_cites = false;
var allow_notes = true;
</script>
</head>

<body background="../background.gif">

<?php
	$repotabs[0] = array(1,"repositories.php",$admtext['search'],"findrepo");
	$repotabs[1] = array($allow_add,"newrepo.php",$admtext[addnew],"addrepo");
	$repotabs[2] = array($allow_edit && $allow_delete,"mergerepos.php",$admtext['merge'],"merge");
	$repotabs[3] = array($allow_edit,"editrepo.php?repoID=$repoID&tree=$tree",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/repositories_help.php#repoedit', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"$showrepo_url" . "repoID=$repoID&amp;tree=$tree\" target=\"_blank\" class=\"lightlink\">$admtext[test]</a>";
	if( $allow_add && ( !$assignedtree || $assignedtree == $tree ) )
		$innermenu .= " &nbsp;|&nbsp; <a href=\"newmedia.php?personID=$repoID&amp;tree=$tree&amp;linktype=R\" class=\"lightlink\">$admtext[addmedia]</a>";
	$menu = doMenu($repotabs,"edit",$innermenu);
	echo displayHeadline("$admtext[repositories] &gt;&gt; $admtext[modifyrepo]","repos_icon.gif",$menu,$message);
?>

<form action="updaterepo.php" method="post" name="form1" style="margin:0px">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table cellpadding="0" cellspacing="0" class="normal">
		<tr>
			<td valign="top"><div id="thumbholder" style="margin-right:5px;<?php if(!$photo) echo "display:none"; ?>"><?php echo $photo; ?></div></td>
			<td>
				<span style="font-size:21px"><?php echo "$row[reponame] ($repoID)</span>"; ?>
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
	<tr><td valign="top"><span class="normal"><?php echo $admtext['tree']; ?>:</span></td><td><span class="normal"><?php echo $treerow[treename]; ?></span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['name']; ?>:</span></td><td><span class="normal"><input type="text" name="reponame" size="40" value="<?php echo "$row[reponame]"; ?>"> (<?php echo $admtext[required]; ?>)</span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['address1']; ?>:</span></td><td><input type="text" name="address1" size="50" value="<?php echo $row[address1]; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['address2']; ?>:</span></td><td><input type="text" name="address2" size="50" value="<?php echo $row[address2]; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['city']; ?>:</span></td><td><input type="text" name="city" size="50" value="<?php echo $row[city]; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['stateprov']; ?>:</span></td><td><input type="text" name="state" size="50" value="<?php echo $row[state]; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['zip']; ?>:</span></td><td><input type="text" name="zip" size="20" value="<?php echo $row[zip]; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['countryaddr']; ?>:</span></td><td><input type="text" name="country" size="50" value="<?php echo $row[country]; ?>"></td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['otherevents']; ?>:</span></td>
		<td>
<?php
	echo "<input type=\"button\" value=\"  " . $admtext['addnew'] . "  \" onClick=\"newEvent('R','$repoID','$tree');\">&nbsp;\n";
?>
   		</td>
	</tr>
	</table>
<?php
		showCustEvents($repoID);
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
	<input type="hidden" name="addressID" value="<?php echo $row[addressID]; ?>">
	<input type="hidden" name="repoID" value="<?php echo "$repoID"; ?>">
	<input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
	<input type="submit" name="submit2" accesskey="s" value="<?php echo $admtext['save']; ?>">
</td>
</tr>

</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
