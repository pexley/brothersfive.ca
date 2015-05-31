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

session_register('tng_search_album');
$tng_search_places = $_SESSION[tng_search_album];

$query = "SELECT * FROM $albums_table WHERE albumID = \"$albumID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row['description'] = ereg_replace("\"", "&#34;",$row['description']);
$row['keywords'] = ereg_replace("\"", "&#34;",$row['keywords']);

$query2 = "SELECT albumlinkID, thumbpath, $media_table.mediaID as mediaID, usecollfolder, mediatypeID, notes, description, datetaken, placetaken, defphoto FROM ($media_table, $albumlinks_table)
	WHERE albumID = \"$albumID\" AND $media_table.mediaID = $albumlinks_table.mediaID order by ordernum, description";
$result2 = mysql_query($query2) or die ("$text[cannotexecutequery]: $query2");
$numrows = mysql_num_rows( $result2 );

$query3 = "SELECT alinkID, entityID, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.suffix as suffix, people.nameorder as nameorder, ate.gedcom, treename,
	familyID, people.personID as personID, wifepeople.personID as wpersonID, wifepeople.firstname as wfirstname, wifepeople.lnprefix as wlnprefix, wifepeople.lastname as wlastname, wifepeople.prefix as wprefix, wifepeople.suffix as wsuffix, wifepeople.nameorder as wnameorder,
	husbpeople.personID as hpersonID, husbpeople.firstname as hfirstname, husbpeople.lnprefix as hlnprefix, husbpeople.lastname as hlastname, husbpeople.prefix as hprefix, husbpeople.suffix as hsuffix, husbpeople.nameorder as hnameorder,
	sourceID, sources.title, repositories.repoID as repoID, reponame, linktype
	FROM ($album2entities_table as ate, $trees_table)
	LEFT JOIN $people_table AS people ON ate.entityID = people.personID AND ate.gedcom = people.gedcom
	LEFT JOIN $families_table ON ate.entityID = $families_table.familyID AND ate.gedcom = $families_table.gedcom
	LEFT JOIN $sources_table AS sources ON ate.entityID = sources.sourceID AND ate.gedcom = sources.gedcom
	LEFT JOIN $repositories_table AS repositories ON ate.entityID = repositories.repoID AND ate.gedcom = repositories.gedcom
	LEFT JOIN $people_table AS husbpeople ON $families_table.husband = husbpeople.personID AND $families_table.gedcom = husbpeople.gedcom
	LEFT JOIN $people_table AS wifepeople ON $families_table.wife = wifepeople.personID AND $families_table.gedcom = wifepeople.gedcom
	WHERE albumID = \"$albumID\" AND ate.gedcom = $trees_table.gedcom";
$result3 = mysql_query($query3) or die ("$admtext[cannotexecutequery]: $query3");
$numlinks = mysql_num_rows( $result3 );

if(!$thumbmaxw) $thumbmaxw = 50;

if( $assignedtree ) {
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
	$tree = $assignedtree;
}
else
	$wherestr = "";
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("albums_help.php");

$flags[tabs] = $tngconfig['tabs'];
tng_adminheader( $admtext['modifyalbum'], $flags );

$photo = "";

$query = "SELECT alwayson, thumbpath, $media_table.mediaID as mediaID, usecollfolder, mediatypeID, albumlinkID FROM ($media_table, $albumlinks_table)
	WHERE albumID = \"$albumID\" AND $media_table.mediaID = $albumlinks_table.mediaID AND defphoto = '1'";
$defresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $defresult ) $drow = mysql_fetch_assoc( $defresult );
$thismediatypeID = $drow[mediatypeID];
$usefolder = $drow[usecollfolder] ? $mediatypes_assoc[$thismediatypeID] : $mediapath;
mysql_free_result($defresult);

if( substr( $usefolder, 0, 1 ) != "/" )
	$relativepath = $cms[support] ? "../../../" : "../";
else
	$relativepath = "";

$photoref = "$usefolder/$drow[thumbpath]";

if( $drow['thumbpath'] && file_exists( "$rootpath$photoref" ) ) {
	$photoinfo = @getimagesize( "$rootpath$photoref" );
	if( $photoinfo[1] <= $thumbmaxh ) {
		$photohtouse = $photoinfo[1];
		$photowtouse = $photoinfo[0];
	}
	else {
		$photohtouse = $thumbmaxh;
		$photowtouse = intval( $thumbmaxh * $photoinfo[0] / $photoinfo[1] ) ;
	}
	$photo = "<img src=\"$relativepath" . str_replace("%2F","/",rawurlencode( $photoref )) . "?" . time() . "\" border=\"1\" alt=\"\" width=\"$photowtouse\" height=\"$photohtouse\" align=\"left\" style=\"margin-right:10px\">";
}
?>
<script type="text/javascript" src="mediafind.js"></script>
<script type="text/javascript" src="selectutils.js"></script>
<script type="text/javascript">
<!--
var tnglitbox;
var album = "<?php echo $albumID; ?>";
var entity = "";
var tree = "";
var type = "album";
var thumbmaxw = parseInt("<?php echo $thumbmaxw; ?>");
var dragmsg = "<?php echo $admtext['drag']; ?>";
var remove_text = "<?php echo $admtext['remove']; ?>";
var mediacount = <?php echo $numrows; ?>;
var linkcount = <?php echo $numlinks; ?>;
var selectmsg = "<?php echo $admtext['selecttree']; ?>";
var linkmsg = "<?php echo $admtext['enterid']; ?>";
var duplinkmsg = "<?php echo $admtext['duplinkmsg']; ?>";
var invlinkmsg = "<?php echo $admtext['invlinkmsg']; ?>";
var mkdefaultmsg = "<?php echo $admtext['makedefault']; ?>";
var searchmsg = "<?php echo $admtext['entersearchvalue']; ?>";
var confdellink = "<?php echo $admtext['confdellink']; ?>";
var confremmedia = "<?php echo $admtext['confremmedia']; ?>";
var findopen;

function toggleAll(display) {
	toggleSection('details','plus0',display);
	toggleSection('addmedia','plus1',display);
	toggleSection('albumlinks','plus2',display);
	return false;
}
-->
</script>
<script language="JavaScript" src="albums.js"></script>
<script language="JavaScript" src="admin.js"></script>
</head>

<body background="../background.gif" onLoad="startAlbums()">

<?php
	$albumtabs[0] = array(1,"albums.php",$admtext['search'],"findalbum");
	$albumtabs[1] = array($allow_add,"newalbum.php",$admtext['addnew'],"addalbum");
	$albumtabs[2] = array($allow_edit,"orderalbumform.php",$admtext['text_sort'],"sortalbums");
	$albumtabs[3] = array($allow_edit,"#",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/albums_help.php#edit', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$menu = doMenu($albumtabs,"edit",$innermenu);
	echo displayHeadline("$admtext[albums] &gt;&gt; $admtext[modifyalbum]","albums_icon.gif",$menu,"");
?>

<form action="updatealbum.php" style="margin:0px" method="post" name="form1" id="form1" onSubmit="return validateForm();">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div><div id="thumbholder" style="float:left;<?php if(!$photo) echo "display:none"; ?>"><?php echo $photo; ?></div><span style="font-size:21px"><?php echo $row['albumname'] . ": </span><br/>" . $row['description']; ?></div>
	<?php
		echo "<a href=\"#\" onclick=\"return removeDefault();\" class=\"smaller\" id=\"removedefault\"";
		if(!$photo) echo " style=\"visibility:hidden\"";
		echo ">$admtext[removedef]</a>\n";
	?>
</td>
</tr>

<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus0",0,"details",$admtext['existingalbuminfo'],$admtext['infosubt']); ?>

	<div id="details" style="display:none">
	<br/>
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['albumname']; ?>:</span></td><td><input type="text" name="albumname" size="50" value="<?php echo $row['albumname']; ?>"></td></tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['description']; ?>:</span></td>
		<td><textarea cols="60" rows="3" name="description"><?php echo $row['description']; ?></textarea></td>
	</tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['keywords']; ?>:</span></td>
		<td><textarea cols="60" rows="3" name="keywords"><?php echo $row['keywords']; ?></textarea></td>
	</tr>
	</table>
	</div>
</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus1",1,"addmedia",$admtext['albmedia'] . " (<span id=\"mediacount\">$numrows</span>)",$admtext['mediasubt']); ?>

	<div id="addmedia">
	<p class="normal" style="padding-top:12px">
		<input type="button" value="<?php echo $admtext['addmedia']; ?>" onclick="return openAlbumMediaFind();"> <?php echo $admtext['selmedia'] . " (<a href=\"newmedia.php\" target=\"_blank\">" . $admtext['uploadfirst'] . "</a>)"; ?>
	</p>

	<p class="normal">&nbsp;<strong><?php echo $admtext['inclmedia']; ?>:</strong> <?php echo $admtext['emoptions']; ?></p>
	<table id="ordertbl" width="100%" cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback" style="width:55px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['text_sort']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" style="width:<?php echo ($thumbmaxw+10); ?>px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['thumb']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['description']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" style="width:154px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['date']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" style="width:104px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['mediatype']; ?></b>&nbsp;</nobr></span></td>
		</tr>
	</table>

	<div id="orderdivs">
<?php
	while( $lrow = mysql_fetch_assoc( $result2 ) )
	{
		$lmediatypeID = $lrow['mediatypeID'];
		$usefolder = $lrow['usecollfolder'] ? $mediatypes_assoc[$lmediatypeID] : $mediapath;
		if( substr( $usefolder, 0, 1 ) != "/" )
			$relativepath = $cms['support'] ? "../../../" : "../";
		else
			$relativepath = "";

		$truncated = substr($lrow[notes],0,90);
		$truncated = strlen($lrow[notes]) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $lrow[notes];
		echo "<div class=\"sortrow\" id=\"orderdivs_$lrow[albumlinkID]\" style=\"clear:both\" onmouseover=\"$('del_$lrow[albumlinkID]').style.visibility='visible';\" onmouseout=\"$('del_$lrow[albumlinkID]').style.visibility='hidden';\">";
		echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr>\n";
		echo "<td class=\"dragarea normal\">";
   		echo "<img src=\"ArrowUp.gif\" alt=\"\"><br/>" . $admtext['drag'] . "<br/><img src=\"ArrowDown.gif\" alt=\"\">\n";
		echo "</td>\n";
		echo "<td class=\"lightback\" style=\"width:" . ($thumbmaxw+6) . "px;text-align:center;\">";
		if( $lrow[thumbpath] && file_exists( "$rootpath$usefolder/$lrow[thumbpath]" ) ) {
			$size = @GetImageSize( "$rootpath$usefolder/$lrow[thumbpath]" );
			echo "<a href=\"editmedia.php?mediaID=$lrow[mediaID]\"><img src=\"$relativepath$usefolder/" . str_replace("%2F","/",rawurlencode( $lrow[thumbpath] )) . "\" border=\"0\" $size[3] alt=\"$lrow[description]\"></a>";
			$foundthumb = true;
		}
		else {
			echo "&nbsp;";
			$foundthumb = false;
		}
		echo "</td>\n";
		$checked = $lrow['defphoto'] ? " checked" : "";
		echo "<td class=\"lightback normal\"><a href=\"editmedia.php?mediaID=$lrow[mediaID]\">$lrow[description]</a><br/>$truncated<br/>";
		echo "<div id=\"del_$lrow[albumlinkID]\" class=\"smaller\" style=\"color:gray;visibility:hidden\">";
		if($foundthumb) {
			echo "<input type=\"radio\" name=\"rthumbs\" value=\"r$lrow[mediaID]\"$checked onclick=\"makeDefault(this);\">$admtext[makedefault]";
			echo " &nbsp;|&nbsp; ";
		}
		echo "<a href=\"#\" onclick=\"return removeFromAlbum('$lrow[mediaID]','$lrow[albumlinkID]');\">$admtext[remove]</a>";
		echo "</div></td>\n";
		echo "<td class=\"lightback normal\" style=\"width:150px;\" valign=\"top\">$lrow[datetaken]&nbsp;</td>\n";
		echo "<td class=\"lightback normal\" style=\"width:100px;\" valign=\"top\">" . $text[$lmediatypeID] . "&nbsp;</td>\n";
		echo "</tr></table>";
		echo "</div>\n";
	}
	$numrows = mysql_num_rows($result2);
	mysql_free_result($result2);
?>
	</div>
	<div id="nomedia" class="normal" style="margin-left:3px">
<?php
	if(!$numrows) echo $admtext['nomedia'];
?>
	</div>
</td>
</tr>

<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus2",1,"albumlinks",$admtext['albumlinks'] . " (<span id=\"linkcount\">$numlinks</span>)",$admtext['linkssubt']); ?>

	<div id="albumlinks">
	<table cellspacing="2" style="padding-top:12px">
		<tr>
			<td class="normal"><?php echo $admtext['tree']; ?></td>
			<td class="normal"><?php echo $admtext['linktype']; ?></td>
			<td class="normal" colspan="2"><?php echo $admtext['id']; ?></td>
		</tr>
		<tr>
			<td>
				<select name="tree1">
<?php
	$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
	while( $treerow = mysql_fetch_assoc($treeresult) ) {
		echo "	<option value=\"$treerow[gedcom]\">$treerow[treename]</option>\n";
	}
	mysql_free_result($treeresult);
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
			<td><input type="text" name="newlink1" id="newlink1" value="" onkeypress="return newlinkEnter(document.form1,this,event);"></td>
			<!--<td class="normal"><input type="submit" value="<?php echo $admtext['add']; ?>"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
			<input type="button" value="<?php echo $admtext[find]; ?>" name="find1" onClick="findopen=true;openFind(document.find.linktype1.options[document.find.linktype1.selectedIndex].value);$('newlines').innerHTML=resheremsg;"></td>-->
			<td class="normal"><input type="button" value="<?php echo $admtext['add']; ?>" onclick="return addMedia2EntityLink(document.form1);"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;</td>
			<td><a href="#" onclick="return openMediaFind(document.form1);"><img src="tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?> class="smallicon"></a></td>
		</tr>
	</table>
	<div id="alink_error" style="display:none;color:red;font-weight:bold" class="normal"></div>

	<p class="normal">&nbsp;<strong><?php echo $admtext['existlinks']; ?>:</strong> <?php echo $admtext['eloptions']; ?></p>
	<table cellpadding="3" cellspacing="1">
	<tbody id="linktable">
		<tr>
			<td class="fieldnameback" style="width:25px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" style="width:80px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['linktype']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['name'] . ", " . $admtext['id']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" style="width:100px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</nobr></span></td>
		</tr>
<?php
	$oldlinks = 0;
	if( $result3 ) {
		while( $plink = mysql_fetch_assoc( $result3 ) )
		{
			$oldlinks++;
			if( $plink[personID] != NULL ) {
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
			elseif( $plink[sourceID] != NULL ) {
				$type = "source";
				$id = " (" . $plink['sourceID'] . ")";
				$name = substr($plink[title],0,25);
			}
			elseif( $plink[repoID] != NULL ) {
				$type = "repository";
				$id = " (" . $plink['repoID'] . ")";
				$name = substr($plink[reponame],0,25);
			}
			else { //place
				$type = "place";
				$id = "";
				$name = $plink['entityID'];
			}
			echo "<tr id=\"alink_$plink[alinkID]\"><td class=\"lightback\" align=\"center\"><a href=\"#\" title=\"$admtext[removelink]\" onclick=\"return deleteMedia2EntityLink($plink[alinkID]);\"><img src=\"tng_delete.gif\" alt=\"$admtext[removelink]\" $dims class=\"smallicon\"></a></td>\n";
			echo "<td class=\"lightback  normal\">" . $admtext[$type] . "</td><td class=\"lightback  normal\">$name$id&nbsp;</td><td class=\"lightback  normal\">$plink[treename]</td></tr>\n";
		}
		mysql_free_result($result3);
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

	<input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
	<input type="hidden" name="albumID" value="<?php echo "$albumID"; ?>">
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>">
</td>
</tr>
</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
<script type="text/javascript">
	var findform = document.form1;
</script>
</body>
</html>
