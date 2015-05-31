<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "mapconfig.php");
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
$showmedia_url = getURL( "showmedia", 1 );

session_register('tng_search_media');

$query = "SELECT *, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") as changedate FROM $media_table WHERE mediaID = \"$mediaID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$row['description'] = ereg_replace("\"", "&#34;",$row['description']);
$row['notes'] = ereg_replace("\"", "&#34;",$row['notes']);
$row['datetaken'] = ereg_replace("\"", "&#34;",$row['datetaken']);
$row['placetaken'] = ereg_replace("\"", "&#34;",$row['placetaken']);
$row['owner'] = ereg_replace("\"", "&#34;",$row['owner']);
$row['map'] = ereg_replace("\"", "&#34;",$row['map']);
$row['map'] = ereg_replace(">", "&gt;",$row['map']);
$row['map'] = ereg_replace("<", "&lt;",$row['map']);
$row['bodytext'] = ereg_replace("\"", "&#34;",$row['bodytext']);
$row['bodytext'] = ereg_replace(">", "&gt;",$row['bodytext']);
$row['bodytext'] = ereg_replace("<", "&lt;",$row['bodytext']);
if($row['abspath']) $row['path'] = ereg_replace("&", "&amp;",$row['path']);
mysql_free_result($result);

$mediatypeID = $row['mediatypeID'];
$path = stripslashes($path);
$thumbpath = stripslashes($thumbpath);
if( $row['form'] )
	$form = strtoupper($row['form']);
else {
	preg_match( "/\.(.+)$/", $row['path'], $matches );
	$form = strtoupper($matches[1]);
}

if( !$row['abspath'] ) {
	if( substr( $photopath, 0, 1 ) != "/" )
		$relativepath = $cms[support] ? "../../../" : "../";
	else
		$relativepath = "";
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

$query = "SELECT $medialinks_table.medialinkID as mlinkID, $medialinks_table.personID as personID, eventID, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.prefix as prefix, people.suffix as suffix, people.nameorder as nameorder, altdescription, altnotes, $medialinks_table.gedcom as gedcom, treename,
	familyID, people.personID as personID2, wifepeople.personID as wpersonID, wifepeople.firstname as wfirstname, wifepeople.lnprefix as wlnprefix, wifepeople.lastname as wlastname, wifepeople.prefix as wprefix, wifepeople.suffix as wsuffix, wifepeople.nameorder as wnameorder,
	husbpeople.personID as hpersonID, husbpeople.firstname as hfirstname, husbpeople.lnprefix as hlnprefix, husbpeople.lastname as hlastname, husbpeople.prefix as hprefix, husbpeople.suffix as hsuffix, husbpeople.nameorder as hnameorder,
	sourceID, sources.title, repositories.repoID as repoID, reponame, defphoto, linktype
	FROM ($medialinks_table, $trees_table)
	LEFT JOIN $people_table AS people ON $medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom
	LEFT JOIN $families_table ON $medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom
	LEFT JOIN $sources_table AS sources ON $medialinks_table.personID = sources.sourceID AND $medialinks_table.gedcom = sources.gedcom
	LEFT JOIN $repositories_table AS repositories ON $medialinks_table.personID = repositories.repoID AND $medialinks_table.gedcom = repositories.gedcom
	LEFT JOIN $people_table AS husbpeople ON $families_table.husband = husbpeople.personID AND $families_table.gedcom = husbpeople.gedcom
	LEFT JOIN $people_table AS wifepeople ON $families_table.wife = wifepeople.personID AND $families_table.gedcom = wifepeople.gedcom
	WHERE mediaID = \"$mediaID\" AND $medialinks_table.gedcom = $trees_table.gedcom ORDER BY $medialinks_table.personID";
$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$numlinks = mysql_num_rows( $result2 );

$helplang = findhelp("media_help.php");

$flags[tabs] = $tngconfig['tabs'];
tng_adminheader( $admtext['modifymedia'], $flags );

$standardtypes = array();
$moptions = "";
$likearray = "var like = new Array();\n";
foreach( $mediatypes as $mediatype ) {
	if(!$mediatype['type'])
		$standardtypes[] = "\"" . $mediatype['ID'] . "\"";
	$msgID = $mediatype['ID'];
	$moptions .= "	<option value=\"$msgID\"";
	if($msgID == $mediatypeID) $moptions .= " selected";
	$moptions .= ">" . $mediatype['display'] . "</option>\n";
	$likearray .= "like['$msgID'] = '$mediatype[liketype]';\n";
}
$sttypestr = implode(",",$standardtypes);

$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
if( $row['thumbpath'] && file_exists("$rootpath$usefolder/$row[thumbpath]")) {
	if( substr( $row['thumbpath'], 0, 1 ) != "/" )
		$relativethumbpath = $cms[support] ? "../../../" : "../";
	else
		$relativethumbpath = "";

	$photoinfo = @GetImageSize( "$rootpath$usefolder/$row[thumbpath]" );
	if( $photoinfo[1] < 50 ) {
		$photohtouse = $photoinfo[1];
		$photowtouse = $photoinfo[0];
	}
	else {
		$photohtouse = 50;
		$photowtouse = intval( 50 * $photoinfo[0] / $photoinfo[1] ) ;
	}
	$photo = "<img border=0 src=\"$relativethumbpath$usefolder/" . str_replace("%2F","/",rawurlencode( $row['thumbpath'] )) . "\" width=\"$photowtouse\" height=\"$photohtouse\" style=\"border-color:#000000;margin-right:6px\"></span>\n";
}
else
	$photo = "";


if($row[path] && ($form == "JPG" || $form == "JPEG" || $form == "GIF" || $form == "PNG" ) ) {
	$size = @GetImageSize( "$rootpath$usefolder/$row[path]" );
	$isphoto = TRUE;
}
else {
	$size = "";
	$isphoto = FALSE;
}

if( $map[key] )
	echo "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=$map[key]\" language=\"Javascript\" type=\"text/javascript\"></script>\n";
?>
<?php
	$onload = $onunload = "";
	if($isphoto && !$row[abspath])
		$onload = "init();";
	$placeopen = 0;
	if($map['key']) {
		include "../googlemaps/googlemaplib2.php";
		if(!$map['startoff']) {
			$onload .= "divbox('mapcontainer');";
			$placeopen = 1;
		}
		$onunload = "onunload=\"GUnload();\"";
	}
	if($onload) $onload = "onload=\"$onload\"";
?>
</head>

<body <?php echo "$onload $onunload"; ?> background="../background.gif">

<?php
	$mediatabs[0] = array(1,"media.php",$admtext['search'],"findmedia");
	$mediatabs[1] = array($allow_add,"newmedia.php",$admtext['addnew'],"addmedia");
	$mediatabs[2] = array($allow_edit,"ordermediaform.php",$admtext['text_sort'],"sortmedia");
	$mediatabs[3] = array($allow_edit && !$assignedtree,"thumbnails.php",$admtext['thumbnails'],"thumbs");
	$mediatabs[4] = array($allow_add,"photoimport.php",$admtext['import'],"import");
	$mediatabs[5] = array($allow_edit,"#",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/media_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a> ";
	$innermenu .= "&nbsp;|&nbsp;<a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"$showmedia_url" . "mediaID=$mediaID\" target=\"_blank\" class=\"lightlink\">$admtext[test]</a>";
	$menu = doMenu($mediatabs,"edit",$innermenu);
	echo displayHeadline("$admtext[media] &gt;&gt; $admtext[existingmediainfo]","photos_icon.gif",$menu,"");
?>

<form action="updatemedia.php" method="post" name="form1" id="form1" ENCTYPE="multipart/form-data" onSubmit="return validateForm();" style="margin:0px">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table cellpadding="0" cellspacing="0" class="normal">
		<tr>
			<td valign="top"><div id="thumbholder" style="margin-right:5px;<?php if(!$photo) echo "display:none"; ?>"><?php echo $photo; ?></div></td>
			<td>
				<span style="font-size:21px"><?php echo $row['description']; ?></span><br/>
				<?php echo $row['notes']; ?>
				<p class="smallest"><?php echo $admtext['lastmodified'] . ": $row[changedate]" . ($row['changedby'] ? " ($row[changedby])" : ""); ?></p>
			</td>
		</tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus0",0,"mediafile",$admtext['imagefile'],$admtext['uplsel']); ?>

	<div id="mediafile" style="display:none">
	<br/>
	<table>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext[mediatype]; ?>:</span></td>
		<td>
			<select name="mediatypeID" onChange="switchOnType(this.options[this.selectedIndex].value)">
<?php
	foreach( $mediatypes as $mediatype ) {
		$msgID = $mediatype[ID];
		echo "	<option value=\"$msgID\"";
		if( $msgID == $mediatypeID ) echo " selected";
		echo ">" . $mediatype['display'] . "</option>\n";
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
	<tr><td valign="top" colspan="2"><input type="checkbox" name="abspath" value="1"<?php if( $row[abspath] ) echo " checked"; ?> onClick="toggleMediaURL();"><span class="normal"> <?php echo $admtext['abspath']; ?></span></td></tr>
	<tr><td colspan="2"><span class="normal"><strong><br/><?php echo $admtext['imagefile']; ?></strong></span></td></tr>
	<tr id="imgrow"><td><span class="normal"><?php echo $admtext['imagefiletoupload']; ?>*:</span></td><td><input type="file" name="newfile" size="60" onChange="populatePath(document.form1.newfile,document.form1.path);"></td></tr>
	<tr id="pathrow">
		<td><span class="normal"><?php echo $admtext['pathwithinphotos']; ?>**:</span></td>
		<td><input type="text" value="<?php if( !$row['abspath'] ) echo "$row[path]"; ?>" name="path" id="path" size="60"><input type="hidden" value="<?php if( !$row['abspath'] ) echo "$row[path]"; ?>" id="path_org" name="path_org"><input type="hidden" id="path_last" name="path_last"> <input type="button" value="<?php echo "$admtext[select]..."; ?>" name="photoselect" OnClick="javascript:FilePicker('path',document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value);"></td>
	</tr>
	<tr id="abspathrow" style="display:none"><td><span class="normal"><?php echo $admtext[mediaurl]; ?>:</span></td><td><input type="text" value="<?php if( $row['abspath'] ) echo "$row[path]"; ?>" name="mediaurl" size="60"></td></tr>

<!-- history section -->
	<tr id="bodytextrow"><td valign="top"><span class="normal"><?php echo $admtext['bodytext']; ?>:</span></td><td><textarea wrap cols="60" rows="10" name="bodytext"><?php echo "$row[bodytext]"; ?></textarea></td></tr>
	<tr id="usenlrow"><td>&nbsp;</td><td valign="top"><span class="normal"><input type="checkbox" name="usenl" value="1"<?php if( $row['usenl'] ) echo " checked"; ?>> <?php echo $admtext['usenl']; ?></span><p class="smaller"><?php echo $admtext['histlimit']; ?></p></td></tr>

<?php
	if( function_exists( "imageJpeg" ) ) {
?>
	<tr>
		<td valign="top"><span class="normal"><strong><br/><?php echo $admtext['thumbnailfile']; ?></strong></span></td>
		<td valign="top"><span class="normal"><br/>
			<input type="radio" name="thumbcreate" value="specify" checked="checked" onClick="document.form1.newthumb.style.visibility='visible'; document.form1.thumbselect.style.visibility='visible';"> <?php echo $admtext[specifyimg]; ?> &nbsp;
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
		<td><input type="text" value="<?php echo "$row[thumbpath]"; ?>" name="thumbpath" id="thumbpath" size="60"><input type="hidden" value="<?php if( !$row['abspath'] ) echo "$row[thumbpath]"; ?>" id="thumbpath_org" name="thumbpath_org"><input type="hidden" id="thumbpath_last" name="thumbpath_last"> <input type="button" value="<?php echo "$admtext[select]..."; ?>" name="thumbselect" OnClick="javascript:FilePicker('thumbpath',document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value,'<?php echo $filepickerdims; ?>');"></td>
	</tr>
	<tr>
		<td valign="top"><span class="normal"><strong><br/><?php echo $admtext['put_in']; ?></strong></span></td>
		<td valign="top"><span class="normal"><br/>
			<input type="radio" name="usecollfolder" value="0"<?php if( !$row['usecollfolder'] ) echo " checked"; ?>> <?php echo $admtext['usemedia']; ?> &nbsp;
			<input type="radio" name="usecollfolder" value="1"<?php if( $row['usecollfolder'] ) echo " checked"; ?>> <?php echo $admtext['usecollect']; ?></span>
		</td>
	</tr>
	<tr id="vidrow1"><td><span class="normal"><?php echo $admtext['width']; ?>:</span></td><td><input type="text" name="width" value="<?php echo $row['width']; ?>" size="40"></td></tr>
	<tr id="vidrow2"><td><span class="normal"><?php echo $admtext['height']; ?>:</span></td><td><input type="text" name="height" value="<?php echo $row['height']; ?>" size="40"><span class="normal"> (<?php echo $admtext['controller']; ?>)</span></td></tr>
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
	<?php echo displayToggle("plus1",$numlinks,"details",$admtext['newmediainfo'],$admtext['minfosubt']); ?>

	<div id="details"<?php if(!$numlinks) echo " style=\"display:none\""; ?>>
	<br/>
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['title']; ?>:</span></td><td><textarea wrap cols="70" rows="3" name="description"><?php echo $row['description']; ?></textarea></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['description']; ?>:</span></td><td><textarea wrap cols="70" rows="5" name="notes"><?php echo $row['notes']; ?></textarea></td></tr>
	<tr><td><span class="normal"><?php echo $admtext['photoowner']; ?>:</span></td><td><input type="text" name="owner" value="<?php echo $row['owner']; ?>" size="40"></td></tr>
	<tr><td><span class="normal"><?php echo $admtext['datetaken']; ?>:</span></td><td><input type="text" name="datetaken" value="<?php echo $row['datetaken']; ?>" size="40"></td></tr>
	<tr>
		<td><span class="normal"><?php echo $admtext['tree']; ?>: </span></td>
		<td>
<?php
	if( $assignedtree ) {
		echo "<span class=\"normal\">";
		if( $row[gedcom] ) {
			$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
			$treerow = mysql_fetch_assoc($treeresult);
			echo $treerow[treename];
			mysql_free_result($treeresult);
		}
		else
			echo $admtext[alltrees];
		echo "<input type=\"hidden\" name=\"tree\" value=\"$row[gedcom]\"></span>";
	}
	else {
		echo "<select name=\"tree\">";
		echo "	<option value=\"\">$admtext[alltrees]</option>\n";
		if( $row[gedcom] ) $tree = $row[gedcom];

		$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
		while( $treerow = mysql_fetch_assoc($treeresult) ) {
			echo "	<option value=\"$treerow[gedcom]\"";
			if( $treerow[gedcom] == $row[gedcom] ) echo " selected";
			echo ">$treerow[treename]</option>\n";
		}
		mysql_free_result($treeresult);
	}
?>
			</select>
		</td>
	</tr>

<!-- headstone section -->
	<tr id="cemrow">
		<td><span class="normal"><?php echo $admtext['cemetery']; ?>: </span></td>
		<td>
		<select name="cemeteryID">
			<option selected></option>
<?php
$query = "SELECT cemname, cemeteryID, city, county, state, country FROM $cemeteries_table ORDER BY country, state, county, city, cemname";
$cemresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
while( $cemrow = mysql_fetch_assoc($cemresult) ) {
	$cemetery = "$cemrow[country], $cemrow[state], $cemrow[county], $cemrow[city], $cemrow[cemname]";
	echo "		<option value=\"$cemrow[cemeteryID]\"";
	if( $row[cemeteryID] == $cemrow[cemeteryID] ) echo " selected";
	echo ">$cemetery</option>\n";
}
?>
		</select>
		</td>
	</tr>
	<tr id="hsplotrow"><td valign="top"><span class="normal"><?php echo $admtext['plot']; ?>:</span></td><td><input type="text" name="plot" size="40" value="<?php echo $row['plot']; ?>"></td></tr>
	<tr id="hsstatrow">
		<td><span class="normal"><?php echo $admtext['status']; ?>:</span></td>
		<td>
			<select name="status">
				<option value="">&nbsp;</option>
				<option value="notyetlocated"<?php if( $row['status'] == 'notyetlocated' ) echo " selected"; ?>><?php echo $admtext['notyetlocated']; ?></option>
				<option value="located"<?php if( $row['status'] == 'located' ) echo " selected"; ?>><?php echo $admtext['located']; ?></option>
				<option value="unmarked"<?php if( $row['status'] == 'unmarked' ) echo " selected"; ?>><?php echo $admtext['unmarked']; ?></option>
				<option value="missing"<?php if( $row['status'] == 'missing' ) echo " selected"; ?>><?php echo $admtext['missing']; ?></option>
				<option value="cremated"<?php if( $row['status'] == 'cremated' ) echo " selected"; ?>><?php echo $admtext['cremated']; ?></option>
			</select>
		</td>
	</tr>

	<tr><td valign="top" colspan="2"><input type="checkbox" name="alwayson" value="1"<?php if( $row['alwayson'] ) echo " checked"; ?>><span class="normal"> <?php echo $admtext['alwayson']; ?></span></td></tr>

<!-- history section -->
	<tr id="newwinrow"><td valign="top" colspan="2"><span class="normal"><input type="checkbox" name="newwindow" value="1"<?php if( $row['newwindow'] ) echo " checked"; ?>> <?php echo $admtext['newwin']; ?></span></td></tr>

<!-- headstone section -->
	<tr id="linktocemrow"><td colspan="2" valign="top"><input type="checkbox" name="linktocem" value="1"<?php if( $row['linktocem'] ) echo " checked"; ?>><span class="normal"> <?php echo $admtext['linktocem']; ?></span></td></tr>
	<tr id="maprow"><td colspan="2" valign="top"><input type="checkbox" name="showmap" value="1"<?php if( $row['showmap'] ) echo " checked"; ?>><span class="normal"> <?php echo $admtext['showmap']; ?></span></td></tr>
	</table>
	</div>
</td>
</tr>

<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus2",1,"links",$admtext['medialinks'] . " (<span id=\"linkcount\">$numlinks</span>)",$admtext['linkssubt']); ?>

	<div id="links" style="margin:0px;padding-top:12px">
	<table cellspacing="2">
		<tr>
			<td class="normal"><?php echo $admtext['tree']; ?></td>
			<td class="normal"><?php echo $admtext['linktype']; ?></td>
			<td class="normal" colspan="2"><?php echo $admtext['id']; ?></td>
		</tr>
		<tr>
			<td>
				<select name="tree1">
<?php
				for( $j = 1; $j <= $treenum; $j++ )
					echo "	<option value=\"$trees[$j]\">$treename[$j]</option>\n";
?>
				</select>
			</td>
			<td>
				<select name="linktype1">
					<option value="I"><?php echo $admtext['person']; ?></option>
					<option value="F"><?php echo $admtext['family']; ?></option>
					<option value="S"><?php echo $admtext['source']; ?></option>
					<option value="R"><?php echo $admtext['repository']; ?></option>
					<option value="L"><?php echo $admtext['place']; ?></option>
				</select>
			</td>
			<td><input type="text" name="newlink1" id="newlink1" value="" onkeypress="return newlinkEnter(findform,this,event);"></td>
			<!--<td class="normal"><input type="submit" value="<?php echo $admtext['add']; ?>"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
			<input type="button" value="<?php echo $admtext[find]; ?>" name="find1" onClick="findopen=true;openFind(document.find.linktype1.options[document.find.linktype1.selectedIndex].value);$('newlines').innerHTML=resheremsg;"></td>-->
			<td class="normal"><input type="button" value="<?php echo $admtext['add']; ?>" onclick="return addMedia2EntityLink(findform);"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;</td>
			<td><a href="#" onclick="return openMediaFind(findform);"><img src="tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?> class="smallicon"></a></td>
		</tr>
	</table>
	<div id="alink_error" style="display:none;color:red;font-weight:bold" class="normal"></div>

	<p class="normal">&nbsp;<strong><?php echo $admtext['existlinks']; ?>:</strong> <?php echo $admtext['eloptions']; ?></p>
	<table cellpadding="3" cellspacing="1" id="linktable">
	<tbody>
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['linktype']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['name'] . ", " . $admtext['id']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['event']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['alttd']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['defphoto']; ?></b>&nbsp;</nobr></td>
		</tr>
<?php
	if( $result2 ) {
		$oldlinks = 0;
		while( $plink = mysql_fetch_assoc( $result2 ) )
		{
			$oldlinks++;
			if( $plink['personID2'] != NULL ) {
				$type = "person";
				$id = " (" . $plink['personID'] . ")";
				$name = getName( $plink );
			}
			elseif( $plink[familyID] != NULL ) {
				$type = "family";
				$husb['firstname'] = $plink['hfirstname'];
				$husb['lnprefix'] = $plink['hlnprefix'];
				$husb['lastname'] = $plink['hlastname'];
				$husb['prefix'] = $plink['hprefix'];
				$husb['suffix'] = $plink['hsuffix'];
				$husb['nameorder'] = $plink['hnameorder'];
				$wife['firstname'] = $plink['wfirstname'];
				$wife['lnprefix'] = $plink['wlnprefix'];
				$wife['lastname'] = $plink['wlastname'];
				$wife['prefix'] = $plink['wprefix'];
				$wife['suffix'] = $plink['wsuffix'];
				$wife['nameorder'] = $plink['wnameorder'];
				$name = getName( $husb );
				$wifename = getName( $wife );
				if( $wifename ) {
					if( $name ) $name .= ", ";
					$name .= $wifename;
				}
				$id = " (" . $plink['familyID'] . ")";
			}
			elseif( $plink['sourceID'] != NULL ) {
				$type = "source";
				$id = " (" . $plink['sourceID'] . ")";
				$name = substr($plink['title'],0,25);
			}
			elseif( $plink['repoID'] != NULL ) {
				$type = "repository";
				$id = " (" . $plink['repoID'] . ")";
				$name = substr($plink['reponame'],0,25);
			}
			else { //place
				$type = "place";
				$id = "";
				$name = $plink['personID'];
			}

			$defphototext = $plink['defphoto'] ? $admtext['yes'] : "&nbsp;";
			$alttext = $plink['altdescription'] || $plink['altnotes'] ? $admtext['yes'] : "&nbsp;";
			$eventID = $plink['eventID'];
			$eventstr = $admtext[$eventID] ? $admtext[$eventID] : "";
			if($eventID && !$eventstr) {
				$query = "SELECT display, eventdate, eventplace, info FROM $events_table, $eventtypes_table WHERE eventID = \"$plink[eventID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID";
				$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				$custevent = mysql_fetch_assoc( $custevents );
				$displayval = getEventDisplay( $custevent['display'] );
				$info = "";
				if( $custevent['eventdate'] )
					$info = displayDate($custevent['eventdate']);
				elseif( $custevent['eventplace'] )
					$info = truncateIt($custevent['eventplace'],20);
				elseif( $custevent['info'] )
					$info = truncateIt($custevent['info'],20);
				$eventstr = "$displayval: $info";
			}

			echo "<tr id=\"alink_$plink[mlinkID]\"><td class=\"lightback\" align=\"center\">";
			echo "<a href=\"#\" title=\"$admtext[edit]\" onclick=\"return editMedia2EntityLink($plink[mlinkID]);\"><img src=\"tng_edit.gif\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"></a>";
			echo "<a href=\"#\" title=\"$admtext[removelink]\" onclick=\"return deleteMedia2EntityLink($plink[mlinkID]);\"><img src=\"tng_delete.gif\" alt=\"$admtext[removelink]\" $dims class=\"smallicon\"></a>";
			echo "</td>\n";
			echo "<td class=\"lightback normal\">" . $admtext[$type] . "</td><td class=\"lightback normal\">$name$id&nbsp;</td><td class=\"lightback normal\">$plink[treename]</td><td class=\"lightback normal\" id=\"event_$plink[mlinkID]\">$eventstr&nbsp;</td>";
			echo "<td class=\"lightback normal\" align=\"center\" id=\"alt_$plink[mlinkID]\">$alttext</td><td class=\"lightback normal\" align=\"center\" id=\"def_$plink[mlinkID]\">$defphototext</td></tr>\n";
		}
		mysql_free_result($result2);
	}
?>

	</tbody>
	</table>
	<div id="nolinks" class="normal" style="margin-left:3px">
<?php
	if(!$oldlinks) echo $admtext['nolinks'];
?>
	</div>
	</div>
</td>
</tr>

<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus3",$placeopen,"placeinfo",$admtext['placetaken'],""); ?>

	<div id="placeinfo"<?php if(!$placeopen) echo " style=\"display:none\""; ?>>
	<table style="margin-top:12px">
	<tr><td><span class="normal"><?php echo $admtext['placetaken']; ?>:</span></td><td><input type="text" name="placetaken" value="<?php echo $row['placetaken']; ?>" size="40"></td></tr>
<?php
	if( $map[key] ) {
?>
	<tr>
		<td colspan="2">
		<div style="padding:10px">
<?php
// draw the map here
		include "../googlemaps/googlemapdrawthemap.php";
?>
		</div>
		</td>
	</tr>
<?php
	}
?>
	<tr><td><span class="normal"><?php echo $admtext['latitude']; ?>:</span></td><td><input type="text" name="latitude" value="<?php echo $row['latitude']; ?>" size="20" id="latbox"></td></tr>
	<tr><td><span class="normal"><?php echo $admtext['longitude']; ?>:</span></td><td><input type="text" name="longitude" value="<?php echo $row['longitude']; ?>" size="20" id="lonbox"></td></tr>
<?php
	if( $map['key'] ) {
?>
	<tr><td><span class="normal"><?php echo $admtext['zoom']; ?>:</span></td><td><input type="text" name="zoom" value="<?php echo $row['zoom']; ?>" size="20" id="zoombox"></td></tr>
<?php
	}
?>
	</table>
	</div>
</td>
</tr>

<?php
	if( $isphoto && !$row['abspath'] ) {
?>
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus4",0,"imagemapdiv",$admtext['imgmap'],$admtext['mapinstr2']); ?>

	<div id="imagemapdiv" class="normal" style="display:none">
	<br />
	<p><?php echo $admtext['mapinstr3']; ?></p>

	<table border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td><span class="normal"><?php echo $admtext['tree']; ?>:</span></td>
			<td>
				<select name="maptree">
	<?php
				for( $j = 1; $j <= $treenum; $j++ )
					echo "	<option value=\"$trees[$j]\">$treename[$j]</option>\n";
	?>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext[shape]; ?>:</span></td>
			<td>
				<span class="normal">
				<input type="radio" name="shape" value="circle" checked="checked" onclick="setPicInstructions('circle');" /> <?php echo $admtext['circle']; ?> &nbsp;&nbsp;
				<input type="radio" name="shape" value="rect" onclick="setPicInstructions('rect');" /> <?php echo $admtext['rect']; ?>
				</span>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<span class="normal">
				<?php echo "<strong>$admtext[forcircles]:</strong><br />$admtext[circleinstr]<br /><br /><strong>$admtext[forrects]:</strong><br />$admtext[rectinstr]";?>
				</span>
			</td>
		</tr>
	</table><br/>
	<?php
		$width = $size[0];
		$height = $size[1];
		if( $width && $height ) {
			if( $tngconfig[imgmaxw] && ($width > $tngconfig[imgmaxw]) ) {
				$width = $tngconfig[imgmaxw];
				$height = intval( $width * $size[1] / $size[0] ) ;
			}
			if( $tngconfig[imgmaxh] && ($height > $tngconfig[imgmaxh]) ) {
				$height = $tngconfig[imgmaxh];
				$width = intval( $height * $size[0] / $size[1] ) ;
			}
		}
		$widthstr = "width=\"$width\"";
		$heightstr = "height=\"$height\"";
		echo "$admtext[imgdim]: $width $admtext[pixw] x $height $admtext[pixh]";
	?>
	<br/>
	</span>
	<img id="pic" src="<?php echo "$relativepath$usefolder/" . str_replace("%2F","/",rawurlencode( $row[path] )); ?>" border="0" <?php echo "$widthstr $heightstr"; ?> alt="<?php echo $admtext[circleinstr]; ?>" onClick="imageClick('<?php echo $mediaID; ?>');" style="cursor:crosshair">
	<p class="normal"><?php echo $admtext['imgmap']; ?>:
	<br/><textarea cols="80" rows="4" name="imagemap" id="imagemap"><?php echo $row['map']; ?></textarea></p>

	</div>
</td>
</tr>
<?php
	} //end abspath condition
?>

<tr class="databack">
<td class="tngshadow">
	<p class="normal">
<?php
	echo "$admtext[onsave]:<br/>";
	echo "<input type=\"radio\" name=\"newmedia\" value=\"return\"> $admtext[savereturn]<br/>\n";
	if( $cw )
		echo "<input type=\"radio\" name=\"newmedia\" value=\"close\" checked> $text[closewindow]\n";
	else
		echo "<input type=\"radio\" name=\"newmedia\" value=\"none\" checked> $admtext[saveback]\n";
?>
   </p>

	<input type="hidden" name="mediatypeID_org" value="<?php echo "$mediatypeID"; ?>">
	<input type="hidden" name="mediaID" value="<?php echo "$mediaID"; ?>">
	<input type="hidden" name="mediakey_org" value="<?php echo "$row[mediakey]"; ?>">
	<input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>">
</td>
</tr>
</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
<script type="text/javascript">
var tree = "";
var type = "media";
var treename = new Array();
var seclitbox, tnglitbox;
<?php
	echo "var media = \"$mediaID\";\n";
	echo "var thumbprefix = \"$thumbprefix\";\n";
	echo "var thumbsuffix = \"$thumbsuffix\";\n";
	echo "var treemsg = \"$admtext[tree]\";\n";
	echo "var personmsg = \"$admtext[person]\";\n";
	echo "var idmsg = \"$admtext[id]\";\n";
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
	echo "var confdellink = \"$admtext[confdellink]\";\n";
	echo "var remove_text = \"$admtext[removelink]\";\n";
	echo "var edit_text = \"$admtext[edit]\";\n";
	echo "var yesmsg = \"$admtext[yes]\";\n";
	echo "var linkcount = $numlinks;\n";
	echo "var manage = 0;\n";
	echo $likearray;
?>
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
	if( frm.path.value.length == 0 && frm.mediaurl.value.length == 0 && frm.bodytext.value.length == 0 && frm.mediatypeID.options[frm.mediatypeID.selectedIndex].value != "headstones" ) {
		alert("<?php echo $admtext['enterphotopath']; ?>");
		rval = false;
	}
	else if( frm.thumbpath.value.length == 0 && frm.thumbcreate[1].checked == true ) {
		alert("<?php echo $admtext['enterthumbpath']; ?>");
		rval = false;
	}
	else if( frm.thumbpath.value.length > 0 && frm.path.value == frm.thumbpath.value ) {
		alert("<?php echo $admtext['samepaths']; ?>");
		rval = false;
	}
	else {
		frm.path.value = frm.path.value.replace(/\\/g,"/");
		frm.thumbpath.value = frm.thumbpath.value.replace(/\\/g,"/");
	}
	return rval;
}

function setPicInstructions(msg) {
	var pic = document.getElementById('pic');
	if(msg == "circle") {
		pic.alt="<?php echo $admtext['circleinstr']; ?>";
		pic.title="<?php echo $admtext['circleinstr']; ?>";
	}
	else if(msg == "rect") {
		pic.alt="<?php echo $admtext['rectinstr']; ?>";
		pic.title="<?php echo $admtext['rectinstr']; ?>";
	}
}

function toggleAll(display) {
	toggleSection('mediafile','plus0',display);
	toggleSection('details','plus1',display);
	toggleSection('links','plus2',display);
	toggleSection('placeinfo','plus3',display);
	if($('imagemapdiv'))
		toggleSection('imagemapdiv','plus4',display);
	return false;
}
</script>
<script type="text/javascript" src="mediautils.js"></script>
<script type="text/javascript" src="mediafind.js"></script>
<script type="text/javascript" src="selectutils.js"></script>
<script type="text/javascript" src="admin.js"></script>
<script type="text/javascript">
	switchOnType(document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value);
	toggleMediaURL();
	var findform = document.form1;
</script>
</body>
</html>
