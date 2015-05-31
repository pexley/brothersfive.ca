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

if( !$allow_add ) {
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
$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
$treenum = 0;
while( $treerow = mysql_fetch_assoc($treeresult) ) {
	$treenum++;
	$trees[$treenum] = $treerow[gedcom];
	$treename[$treenum] = $treerow[treename];
}
mysql_free_result($treeresult);

$helplang = findhelp("media_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewmedia], $flags );

$lastcoll = isset($_COOKIE['lastcoll']) ? $_COOKIE['lastcoll'] : "";
$standardtypes = array();
$moptions = "";
$likearray = "var like = new Array();\n";
foreach( $mediatypes as $mediatype ) {
	if(!$mediatype['type'])
		$standardtypes[] = "\"" . $mediatype['ID'] . "\"";
	$msgID = $mediatype['ID'];
	$moptions .= "	<option value=\"$msgID\"";
	if($lastcoll == $msgID) $moptions .= " selected";
	$moptions .= ">" . $mediatype['display'] . "</option>\n";
	$likearray .= "like['$msgID'] = '$mediatype[liketype]';\n";
}
$sttypestr = implode(",",$standardtypes);
?>
</head>

<body background="../background.gif">

<?php
	$mediatabs[0] = array(1,"media.php",$admtext['search'],"findmedia");
	$mediatabs[1] = array($allow_add,"newmedia.php",$admtext[addnew],"addmedia");
	$mediatabs[2] = array($allow_edit,"ordermediaform.php",$admtext[text_sort],"sortmedia");
	$mediatabs[3] = array($allow_edit && !$assignedtree,"thumbnails.php",$admtext[thumbnails],"thumbs");
	$mediatabs[4] = array($allow_add,"photoimport.php",$admtext['import'],"import");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/media_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a> ";
	$innermenu .= "&nbsp;|&nbsp;<a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$menu = doMenu($mediatabs,"addmedia",$innermenu);
	echo displayHeadline("$admtext[media] &gt;&gt; $admtext[addnewmedia]","photos_icon.gif",$menu,"");
?>

<form action="addmedia.php" method="post" name="form1" style="margin:0px" ENCTYPE="multipart/form-data" onSubmit="return validateForm();">
<input type="hidden" name="link_personID" value="<?php echo $personID; ?>">
<input type="hidden" name="link_tree" value="<?php echo $tree; ?>">
<input type="hidden" name="link_linktype" value="<?php echo $linktype; ?>">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus0",1,"mediafile",$admtext['imagefile'],$admtext['uplsel']); ?>

	<div id="mediafile">
	<br/>
	<table>
	<tr>
		<td><span class="normal"><?php echo $admtext['mediatype']; ?>:</span></td>
		<td>
			<select name="mediatypeID" onChange="switchOnType(this.options[this.selectedIndex].value)">
<?php
			echo $moptions;
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
	<tr><td valign="top" colspan="2"><input type="checkbox" name="abspath" value="1" onClick="toggleMediaURL();"><span class="normal"> <?php echo $admtext['abspath']; ?></span></td></tr>
	<tr><td colspan="2"><span class="normal"><strong><br/><?php echo $admtext['imagefile']; ?></strong></span></td></tr>
	<tr id="imgrow"><td><span class="normal"><?php echo $admtext['imagefiletoupload']; ?>*:</span></td><td><input type="file" name="newfile" size="60" onchange="populatePath(document.form1.newfile,document.form1.path);"></td></tr>
	<tr id="pathrow">
		<td><span class="normal"><?php echo $admtext['pathwithinphotos']; ?>**:</span></td>
		<td><input type="text" name="path" id="path" size="60"><input type="hidden" id="path_org"><input type="hidden" id="path_last"> <input type="button" value="<?php echo "$admtext[select]..."; ?>" name="photoselect" onclick="javascript:FilePicker('path',document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value,'<?php echo $filepickerdims; ?>');"></td>
	</tr>
	<tr id="abspathrow" style="display:none"><td valign="top"><span class="normal"><?php echo $admtext['mediaurl']; ?>:</span></td><td><input type="text" name="mediaurl" size="60"></td></tr>

<!-- history section -->
	<tr id="bodytextrow"><td valign="top"><span class="normal"><?php echo $admtext['bodytext']; ?>:</span></td><td valign="top"><textarea wrap cols="60" rows="10" name="bodytext"></textarea></td></tr>
	<tr id="usenlrow"><td>&nbsp;</td><td valign="top"><span class="normal"><input type="checkbox" name="usenl" value="1"> <?php echo $admtext['usenl']; ?></span><p class="smaller"><?php echo $admtext['histlimit']; ?></p></td></tr>

<?php
	if( function_exists( "imageJpeg" ) ) {
?>
	<tr>
		<td valign="top"><span class="normal"><strong><br/><?php echo $admtext['thumbnailfile']; ?></strong></span></td>
		<td valign="top"><span class="normal"><br/>
			<input type="radio" name="thumbcreate" value="specify" checked onClick="document.form1.newthumb.style.visibility='visible'; document.form1.thumbselect.style.visibility='visible';"> <?php echo $admtext[specifyimg]; ?> &nbsp;
			<input type="radio" name="thumbcreate" value="auto" onClick="document.form1.newthumb.style.visibility='hidden'; document.form1.thumbselect.style.visibility='hidden'; prepopulateThumb(); document.form1.abspath.checked=false;"> <?php echo $admtext[autoimg]; ?></span></td>
	</tr>
<?php
	}
	else {
?>
	<tr><td colspan="2"><strong><span class="normal"><br/><?php echo $admtext['thumbnailfile']; ?></strong></span></td></tr>
<?php
	}
?>
	<tr><td><span class="normal"><?php echo $admtext['imagefiletoupload']; ?>*:</span></td><td><input type="file" name="newthumb" size="60" onChange="populatePath(document.form1.newthumb,document.form1.thumbpath);"></td></tr>
	<tr>
		<td><span class="normal"><?php echo $admtext['pathwithinphotos']; ?>**:</span></td>
		<td><input type="text" name="thumbpath" id="thumbpath" size="60"><input type="hidden" id="thumbpath_org"><input type="hidden" id="thumbpath_last"> <input type="button" value="<?php echo "$admtext[select]..."; ?>" name="thumbselect" OnClick="javascript:FilePicker('thumbpath',document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value,'<?php echo $filepickerdims; ?>');"></td>
	</tr>
	<tr>
		<td valign="top"><span class="normal"><strong><br/><?php echo $admtext['put_in']; ?></strong></span></td>
		<td valign="top"><span class="normal"><br/>
			<input type="radio" name="usecollfolder" value="0"> <?php echo $admtext['usemedia']; ?> &nbsp;
			<input type="radio" name="usecollfolder" value="1" checked> <?php echo $admtext['usecollect']; ?></span>
		</td>
	</tr>
	<tr id="vidrow1"><td valign="top"><span class="normal"><?php echo $admtext['width']; ?>:</span></td><td><input type="text" name="width" size="40"></td></tr>
	<tr id="vidrow2"><td valign="top"><span class="normal"><?php echo $admtext['height']; ?>:</span></td><td><input type="text" name="height" size="40"><span class="normal"> (<?php echo $admtext[controller]; ?>)</span></td></tr>
	</table>
	<p class="smaller">
<?php
	echo "*$admtext[leaveblankphoto]<br/>\n";
	echo "**$admtext[requiredphoto]<br/>\n";
	echo "***$admtext[defphotonote]\n";
?>
	</p>
	</div>
</td>
</tr>

<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus1",1,"details",$admtext['newmediainfo'],$admtext['minfosubt']); ?>

	<div id="details">
	<br/>
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['title']; ?>:</span></td><td><textarea wrap cols="70" rows="3" name="description"></textarea></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['description']; ?>:</span></td><td><textarea wrap cols="70" rows="5" name="notes"></textarea></td></tr>
	<tr><td><span class="normal"><?php echo $admtext['photoowner']; ?>:</span></td><td><input type="text" name="owner" size="40"></td></tr>
	<tr><td><span class="normal"><?php echo $admtext['datetaken']; ?>:</span></td><td><input type="text" name="datetaken" size="40"></td></tr>
	<tr>
		<td><span class="normal"><?php echo $admtext[tree]; ?>: </span></td>
		<td>

<?php
	echo "<select name=\"tree\">";
	echo "	<option value=\"\">$admtext[alltrees]</option>\n";
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

<!-- headstone section -->
	<tr id="cemrow">
		<td><span class="normal"><?php echo $admtext[cemetery]; ?>: </span></td>
		<td>
		<select name="cemeteryID">
			<option selected></option>
<?php
$query = "SELECT cemname, cemeteryID, city, county, state, country FROM $cemeteries_table ORDER BY country, state, county, city, cemname";
$cemresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
while( $cemrow = mysql_fetch_assoc($cemresult) ) {
	$cemetery = "$cemrow[country], $cemrow[state], $cemrow[county], $cemrow[city], $cemrow[cemname]";
	echo "		<option value=\"$cemrow[cemeteryID]\">$cemetery</option>\n";
}
?>
		</select>
		</td>
	</tr>
	<tr id="hsplotrow"><td><span class="normal"><?php echo $admtext['plot']; ?>:</span></td><td><input type="text" name="plot" size="40"></td></tr>
	<tr id="hsstatrow">
		<td><span class="normal"><?php echo $admtext['status']; ?>:</span></td>
		<td>
			<select name="status">
				<option value="">&nbsp;</option>
				<option value="notyetlocated"><?php echo $admtext[notyetlocated]; ?></option>
				<option value="located"><?php echo $admtext[located]; ?></option>
				<option value="unmarked"><?php echo $admtext[unmarked]; ?></option>
				<option value="missing"><?php echo $admtext[missing]; ?></option>
				<option value="cremated"><?php echo $admtext[cremated]; ?></option>
			</select>
		</td>
	</tr>

	<tr><td valign="top" colspan="2"><input type="checkbox" name="alwayson" value="1"><span class="normal"> <?php echo $admtext[alwayson]; ?></span></td></tr>

<!-- history section -->
	<tr id="newwinrow"><td valign="top" colspan="2"><span class="normal"><input type="checkbox" name="newwindow" value="1"> <?php echo $admtext[newwin]; ?></span></td></tr>

<!-- headstone section -->
	<tr id="linktocemrow"><td colspan="2" valign="top"><input type="checkbox" name="linktocem" value="1"><span class="normal"> <?php echo $admtext[linktocem]; ?></span></td></tr>
	<tr id="maprow"><td colspan="2" valign="top"><input type="checkbox" name="showmap" value="1"><span class="normal"> <?php echo $admtext[showmap]; ?></span></td></tr>

	</table>
	</div>
</td>
</tr>

<tr class="databack">
<td class="tngshadow">
	<p class="normal"><strong><?php echo $admtext['medlater']; ?></strong></p>
	<input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
	<input type="hidden" name="numlinks" value="1"><input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['savecont']; ?>">
</td>
</tr>

</table>
</form>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
<script type="text/javascript">
var tree = "<?php echo $tree; ?>";
var tnglitbox;
var trees = new Array();
var treename = new Array();
var selectmsg = "<?php echo $admtext[selecttree]; ?>";
<?php
	for($i = 1; $i <= $treenum; $i++ ) {
		echo "trees[$i] = \"$trees[$i]\";\n";
		echo "treename[$i] = \"$treename[$i]\";\n";
	}
	echo "var thumbprefix = \"$thumbprefix\";\n";
	echo "var thumbsuffix = \"$thumbsuffix\";\n";
	echo "var treemsg = \"$admtext[tree]\";\n";
	echo "var personmsg = \"$admtext[person]\";\n";
	echo "var idmsg = \"$admtext[id]\";";
	echo "var familymsg = \"$admtext[family]\";\n";
	echo "var sourcemsg = \"$admtext[source]\";\n";
	echo "var repositorymsg = \"$admtext[repository]\";\n";
	echo "var placemsg = \"$admtext[place]\";\n";
	echo "var findmsg = \"$admtext[find]\";\n";
	echo "var altdescmsg = \"$admtext[alttitle]\";\n";
	echo "var altnotesmsg = \"$admtext[altdesc]\";\n";
	echo "var makedefaultmsg = \"$admtext[makedefault]\";\n";
	echo "var eventlinkmsg = \"$admtext[eventlink]\";\n";
	echo "var eventmsg = \"$admtext[event]\";\n";
	echo "var manage = 0;\n";
	echo $likearray;
?>
var linkcount = 1;
var entercollid = "<?php echo $admtext['entercollid']; ?>";
var entercolldisplay = "<?php echo $admtext['entercolldisplay']; ?>";
var entercollipath = "<?php echo $admtext['entercollpath']; ?>";
var entercollicon = "<?php echo $admtext['entercollicon']; ?>";
var confmtdelete = "<?php echo $admtext['confmtdelete']; ?>";
var stmediatypes = new Array(<?php echo $sttypestr; ?>);
var allow_edit = <?php echo ($allow_edit ? "1" : "0"); ?>;
var allow_delete = <?php echo ($allow_delete ? "1" : "0"); ?>;

function validateForm( ) {
	var rval = true;

	var frm = document.form1;
	if(frm.path.value.length == 0 && frm.mediaurl.value.length == 0 && frm.bodytext.value.length == 0 && frm.mediatypeID.options[frm.mediatypeID.selectedIndex].value != "headstones" ) {
		alert("<?php echo $admtext[enterphotopath]; ?>");
		rval = false;
	}
	else if( frm.thumbpath.value.length == 0 && frm.thumbcreate[1].checked == true ) {
		alert("<?php echo $admtext[enterthumbpath]; ?>");
		rval = false;
	}
	else if( frm.thumbpath.value.length > 0 && frm.path.value == frm.thumbpath.value ) {
		alert("<?php echo $admtext[samepaths]; ?>");
		rval = false;
	}
	else {
		frm.path.value = frm.path.value.replace(/\\/g,"/");
		frm.thumbpath.value = frm.thumbpath.value.replace(/\\/g,"/");
	}
	return rval;
}

var gsControlName = "";

function toggleAll(display) {
	toggleSection('mediafile','plus0',display);
	toggleSection('details','plus1',display);
	return false;
}
</script>
<script type="text/javascript" src="../net.js"></script>
<script type="text/javascript" src="mediautils.js"></script>
<script type="text/javascript" src="admin.js"></script>
<script type="text/javascript">
	switchOnType(document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value);
</script>
</body>
</html>
