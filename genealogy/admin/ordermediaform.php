<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

if( $assignedtree ) {
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
	$tree = $assignedtree;
}
else
	$wherestr = "";
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("media_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[sortmedia], $flags );
?>
<script type="text/javascript" src="../net.js"></script>
<script type="text/javascript" src="mediafind.js"></script>
<script type="text/javascript">
var findopen;
var album = '';
var media = '';
var type = "media";
//var formname = "find";
var findform = "find";
var resheremsg = '<span class="normal">' + "<?php echo $text['reshere']; ?>" + '</span>';;

function validateForm( ) {
	var rval = true;

	if( document.find.newlink1.value.length == 0 ) {
		alert("<?php echo $admtext[enterid]; ?>");
		rval = false;
	}
	return rval;
}

function getTree(treeobj) {
	if( treeobj.options.length ) 
		return treeobj.options[treeobj.selectedIndex].value;
	else {
		alert("<?php echo $admtext[selecttree]; ?>");
		return false;
	}
}

var gsControlName = "";
</script>
</head>

<body background="../background.gif">

<?php
	$mediatabs[0] = array(1,"media.php",$admtext['search'],"findmedia");
	$mediatabs[1] = array($allow_add,"newmedia.php",$admtext[addnew],"addmedia");
	$mediatabs[2] = array($allow_edit,"ordermediaform.php",$admtext[text_sort],"sortmedia");
	$mediatabs[3] = array($allow_edit && !$assignedtree,"thumbnails.php",$admtext[thumbnails],"thumbs");
	$mediatabs[4] = array($allow_add,"photoimport.php",$admtext['import'],"import");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/media_help.php#sort', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($mediatabs,"sortmedia",$innermenu);
	echo displayHeadline("$admtext[media] &gt;&gt; $admtext[text_sort]","photos_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="ordermedia.php" method="get" name="find" onsubmit="return validateForm();">
	<span class="subhead"><strong><?php echo $admtext[sortmediaind]; ?></strong></span><br/><br/>
	<table cellspacing="2">
		<tr>
			<td class="normal"><?php echo $admtext['tree']; ?></td>
			<td class="normal"><?php echo $admtext['linktype']; ?></td>
			<td class="normal"><?php echo $admtext['mediatype']; ?></td>
			<td class="normal" colspan="3"><?php echo $admtext['id']; ?></td>
		</tr>
		<tr>
			<td valign="top">
				<select name="tree1">
<?php
	$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
	while( $treerow = mysql_fetch_assoc($treeresult) ) {
		echo "	<option value=\"$treerow[gedcom]\"";
		if( $treerow[gedcom] == $tree ) echo " selected";
		echo ">$treerow[treename]</option>\n";
	}
	mysql_free_result($treeresult);
?>
				</select>
			</td>
			<td valign="top">
				<select name="linktype1" onchange="toggleEventLink(this.selectedIndex);">
					<option value="I"><?php echo $admtext['person']; ?></option>
					<option value="F"><?php echo $admtext['family']; ?></option>
					<option value="S"><?php echo $admtext['source']; ?></option>
					<option value="R"><?php echo $admtext['repository']; ?></option>
					<option value="L"><?php echo $admtext['place']; ?></option>
				</select>
			</td>
			<td valign="top">
				<select name="mediatypeID">
<?php
	foreach( $mediatypes as $mediatype ) {
		$msgID = $mediatype[ID];
		echo "	<option value=\"$msgID\"";
		if( $msgID == $mediatypeID ) echo " selected";
		echo ">" . $mediatype['display'] . "</option>\n";
	}
?>
				</select>
			</td>
			<td><input type="text" name="newlink1" id="newlink1" value="<?php echo $personID; ?>" onblur="toggleEventRow(document.find.eventlink1.checked);"></td>
			<td class="normal"><input type="submit" value="<?php echo $admtext['text_continue']; ?>"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp; </td>
			<td><a href="#" onclick="return openMediaFind(document.find);"><img src="tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?> class="smallicon"></a></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td colspan="2">
				<span id="eventlink1" class="normal"><input type="checkbox" name="eventlink1" value="1" onclick="return toggleEventRow(this.checked);" /> <?php echo $admtext[eventlink]; ?></span><br />
				<select name="event1" id="eventrow1" style="display:none">
					<option value=""></option>
				</select>
			</td>
			<td class="normal" valign="top">&nbsp;</td>
		</tr>
	</table>

	</form>

</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
