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

if( $assignedtree )
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
else
	$wherestr = "";
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("data_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext['phimport'], $flags );

$standardtypes = array();
foreach( $mediatypes as $mediatype ) {
	if(!$mediatype['type'])
		$standardtypes[] = "\"" . $mediatype['ID'] . "\"";
}
$sttypestr = implode(",",$standardtypes);
?>
</head>

<body background="../background.gif">

<?php
	$mediatabs[0] = array(1,"media.php",$admtext['search'],"findmedia");
	$mediatabs[1] = array($allow_add,"newmedia.php",$admtext['addnew'],"addmedia");
	$mediatabs[2] = array($allow_edit,"ordermediaform.php",$admtext['text_sort'],"sortmedia");
	$mediatabs[3] = array($allow_edit && !$assignedtree,"thumbnails.php",$admtext['thumbnails'],"thumbs");
	$mediatabs[4] = array($allow_add,"photoimport.php",$admtext[import],"import");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/media_help.php#import', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($mediatabs,"import",$innermenu);
	echo displayHeadline("$admtext[media] &gt;&gt; $admtext[import]","photos_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="photoimporter.php" method="post" name="form1" style="margin:0px">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext['mediatype']; ?>:</span></td>
			<td>
				<select name="mediatypeID" onChange="switchOnType(this.options[this.selectedIndex].value)">
<?php
	foreach( $mediatypes as $mediatype ) {
		$msgID = $mediatype['ID'];
		echo "	<option value=\"$msgID\">" . $mediatype['display'] . "</option>\n";
	}
?>
				</select>
<?php
	if($allow_add) {
?>
			<input type="button" name="addnewmediatype" value="<?php echo $admtext['addnewcoll']; ?>" style="vertical-align:top" onclick="tnglitbox = new LITBox('newcollection.php?field=mediatypeID',{width:600,height:330});">
<?php
	}
?>
				<input type="button" name="editmediatype" id="editmediatype" value="<?php echo $admtext['edit']; ?>" style="vertical-align:top;display:none" onclick="editMediatype(document.form1.mediatypeID);">
				<input type="button" name="delmediatype" id="delmediatype" value="<?php echo $admtext['text_delete']; ?>" style="vertical-align:top;display:none" onclick="confirmDeleteMediatype(document.form1.mediatypeID);">
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext[tree]; ?>*: </span></td>
			<td>
				<select name="tree">
					<option value=""></option>
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
		</tr>
	</table>
	<p class="normal">*Optional. Leave blank to allow photos to be visible in all trees.</p>
	<input type="submit" name="submit" value="<?php echo $admtext['import']; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
<script type="text/javascript" src="mediautils.js"></script>
<script type="text/javascript">
var tree = "<?php echo $tree; ?>";
var tnglitbox;
var entercollid = "<?php echo $admtext['entercollid']; ?>";
var entercolldisplay = "<?php echo $admtext['entercolldisplay']; ?>";
var entercollipath = "<?php echo $admtext['entercollpath']; ?>";
var entercollicon = "<?php echo $admtext['entercollicon']; ?>";
var confmtdelete = "<?php echo $admtext['confmtdelete']; ?>";
var stmediatypes = new Array(<?php echo $sttypestr; ?>);
var allow_edit = <?php echo ($allow_edit ? "1" : "0"); ?>;
var allow_delete = <?php echo ($allow_delete ? "1" : "0"); ?>;
</script>
</body>
</html>
