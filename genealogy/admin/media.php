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

session_register('tng_search_media_post');
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	$searchstring = stripslashes($searchstring);
	setcookie("tng_search_media_post[search]", $searchstring, $exptime);
	setcookie("tng_search_media_post[mediatypeID]", $mediatypeID, $exptime);
	setcookie("tng_search_media_post[fileext]", $fileext, $exptime);
	setcookie("tng_search_media_post[unlinked]", $unlinked, $exptime);
	setcookie("tng_search_media_post[hsstat]", $hsstat, $exptime);
	setcookie("tng_search_media_post[cemeteryID]", $cemeteryID, $exptime);
	setcookie("tng_search_media_post[tree]", $tree, $exptime);
	setcookie("tng_search_media_post[page]", 1, $exptime);
	setcookie("tng_search_media_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = stripslashes($_COOKIE[tng_search_media_post][search]);
	if( !$mediatypeID )
		$mediatypeID = $_COOKIE[tng_search_media_post][mediatypeID];
	if( !$fileext )
		$fileext = $_COOKIE[tng_search_media_post][fileext];
	if( !$unlinked )
		$unlinked = $_COOKIE[tng_search_media_post][unlinked];
	if( !$hsstat )
		$hsstat = $_COOKIE[tng_search_media_post][hsstat];
	if( !$cemeteryID )
		$cemeteryID = $_COOKIE[tng_search_media_post][cemeteryID];
	if( !$tree )
		$tree = $_COOKIE[tng_search_media_post][tree];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_media_post][page];
		$offset = $_COOKIE[tng_search_media_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_media_post[page]", $page, $exptime);
		setcookie("tng_search_media_post[offset]", $offset, $exptime);
	}
}

if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

if( $assignedtree ) {
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
	$wherestr2 = " AND $medialinks_table.gedcom = \"$assignedtree\"";
	//$tree = $assignedtree;
}
else {
	$wherestr = "";
	if($tree) $wherestr2 = " AND $medialinks_table.gedcom = \"$tree\"";
}

$orgtree = $tree;
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$showmedia_url = getURL( "showmedia", 1 );

$originalstring = ereg_replace("\"", "&#34;",$searchstring);
$searchstring = addslashes($searchstring);
$wherestr = $searchstring ? "($media_table.mediaID LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR path LIKE \"%$searchstring%\" OR notes LIKE \"%$searchstring%\" OR bodytext LIKE \"%$searchstring%\")" : "";
if( $assignedtree )
	$wherestr .= $wherestr ? " AND ($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\")" : "($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\")";
elseif( $tree )
	$wherestr .= $wherestr ? " AND $media_table.gedcom = \"$tree\"" : "$media_table.gedcom = \"$tree\"";
if( $mediatypeID )
	$wherestr .= $wherestr ? " AND mediatypeID = \"$mediatypeID\"" : "mediatypeID = \"$mediatypeID\"";
if( $fileext )
	$wherestr .= $wherestr ? " AND form = \"$fileext\"" : "form = \"$fileext\"";
if( $hsstat != "all" ) {
	if($hsstat)
		$wherestr .= $wherestr ? " AND status = \"$hsstat\"" : "status = \"$hsstat\"";
	else
		$wherestr .= $wherestr ? " AND (status = \"$hsstat\" OR status IS NULL)" : "(status = \"$hsstat\" OR status IS NULL)";
}
if( $cemeteryID )
	$wherestr .= $wherestr ? " AND cemeteryID = \"$cemeteryID\"" : "cemeteryID = \"$cemeteryID\"";
if( $unlinked ) {
	$join = "LEFT JOIN $medialinks_table on $media_table.mediaID = $medialinks_table.mediaID";
	$medialinkID = "medialinkID,";
	$wherestr .= $wherestr ? " AND medialinkID is NULL" : "medialinkID is NULL";
}
if( $wherestr ) $wherestr = "WHERE $wherestr";

$query = "SELECT $media_table.mediaID as mediaID, $medialinkID description, notes, thumbpath, mediatypeID, usecollfolder, latitude, longitude, zoom FROM $media_table $join $wherestr ORDER BY description LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count($media_table.mediaID) as mcount FROM $media_table $join $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[mcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("media_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[media], $flags );

$standardtypes = array();
foreach( $mediatypes as $mediatype ) {
	if(!$mediatype['type'])
		$standardtypes[] = "\"" . $mediatype['ID'] . "\"";
}
$sttypestr = implode(",",$standardtypes);
?>
<script type="text/javascript" src="mediautils.js"></script>
<script type="text/javascript">
var tnglitbox;
var entercollid = "<?php echo $admtext['entercollid']; ?>";
var entercolldisplay = "<?php echo $admtext['entercolldisplay']; ?>";
var entercollipath = "<?php echo $admtext['entercollpath']; ?>";
var entercollicon = "<?php echo $admtext['entercollicon']; ?>";
var confmtdelete = "<?php echo $admtext['confmtdelete']; ?>";
var stmediatypes = new Array(<?php echo $sttypestr; ?>);
var manage = 1;
var allow_edit = <?php echo ($allow_edit ? "1" : "0"); ?>;
var allow_delete = <?php echo ($allow_delete ? "1" : "0"); ?>;

function toggleHeadstoneCriteria(mediatypeID) {
	var hsstatus = document.getElementById('hsstatrow');
	var cemrow = document.getElementById('cemrow');
	if( mediatypeID == 'headstones' ) {
		cemrow.style.display='';
		hsstatus.style.display='';
	}
	else {
		cemrow.style.display='none';
		document.form1.cemeteryID.selectedIndex = 0;
		hsstatus.style.display='none';
		document.form1.hsstat.selectedIndex = 0;
		if(mediatypeID && stmediatypes.indexOf(mediatypeID) == -1) {
			if(allow_edit) $('editmediatype').style.display = '';
			if(allow_delete) $('delmediatype').style.display = '';
		}
		else {
			$('editmediatype').style.display = 'none';
			$('delmediatype').style.display = 'none';
		}
	}
	return false;
}

function resetForm() {
	document.form1.searchstring.value='';
	document.form1.tree.selectedIndex=0;
	document.form1.mediatypeID.selectedIndex=0;
	document.form1.fileext.value = '';
	document.form1.unlinked.checked = false;
	document.form1.hsstat.selectedIndex=0;
	document.form1.cemeteryID.selectedIndex=0;
}

function confirmDelete(mediaID) {
	if(confirm('<?php echo $admtext['confdeletemedia']; ?>' )){
		deleteIt('media',mediaID);
	}
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$mediatabs[0] = array(1,"media.php",$admtext['search'],"findmedia");
	$mediatabs[1] = array($allow_add,"newmedia.php",$admtext['addnew'],"addmedia");
	$mediatabs[2] = array($allow_edit,"ordermediaform.php",$admtext['text_sort'],"sortmedia");
	$mediatabs[3] = array($allow_edit && !$assignedtree,"thumbnails.php",$admtext['thumbnails'],"thumbs");
	$mediatabs[4] = array($allow_add,"photoimport.php",$admtext['import'],"import");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/media_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($mediatabs,"findmedia",$innermenu);
	echo displayHeadline("$admtext[media]","photos_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="media.php" style="margin:0px;" name="form1" id="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext[searchfor]; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo $originalstring; ?>">
				<input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="resetForm();" style="vertical-align:top">
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext[tree]; ?>: </span></td>
			<td>
				<select name="tree">
<?php
	if(!$assignedtree)
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
				<span class="normal">&nbsp;&nbsp;<?php echo $admtext[fileext]; ?>: <input type="text" name="fileext" value="<?php echo $fileext; ?>" size="3">
				&nbsp;&nbsp;<input type="checkbox" name="unlinked" value="1"<?php if( $unlinked ) echo " checked"; ?> /> <?php echo $admtext['unlinked']; ?>
				</span>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['mediatype']; ?>: </span></td>
			<td>
				<select name="mediatypeID" onchange="toggleHeadstoneCriteria(this.options[this.selectedIndex].value)">

<?php
	if( !$assignedtree )
		echo "<option value=\"\">$admtext[all]</option>\n";
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
		<tr id="hsstatrow">
			<td><span class="normal"><?php echo $admtext[status]; ?>: </span></td>
			<td>
				<select name="hsstat">
					<option value="all"<?php if( $hsstat == "all" ) echo " selected"; ?>>&nbsp;</option>
					<option value=""<?php if( !$hsstat ) echo " selected"; ?>><?php echo $admtext['nostatus']; ?></option>
					<option<?php if( $hsstat == $admtext[notyetlocated] ) echo " selected"; ?>><?php echo $admtext['notyetlocated']; ?></option>
					<option<?php if( $hsstat == $admtext[located] ) echo " selected"; ?>><?php echo $admtext['located']; ?></option>
					<option<?php if( $hsstat == $admtext[unmarked] ) echo " selected"; ?>><?php echo $admtext['unmarked']; ?></option>
					<option<?php if( $hsstat == $admtext[missing] ) echo " selected"; ?>><?php echo $admtext['missing']; ?></option>
					<option<?php if( $hsstat == $admtext[cremated] ) echo " selected"; ?>><?php echo $admtext['cremated']; ?></option>
				</select>
			</td>
		</tr>
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
	if( $cemeteryID == $cemrow[cemeteryID] ) echo " selected";
	echo ">$cemetery</option>\n";
}
?>
			</select>
			</td>
		</tr>
	</table>

	<input type="hidden" name="findmedia" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />
<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "media.php?searchstring=$searchstring&amp;mediatypeID=$mediatypeID&amp;fileext=$fileext&amp;hsstat=$hsstat&amp;cemeteryID=$cemeteryID&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="updateselectedmedia.php" method="post" style="margin:0px" name="form2">
	<p style="white-space:nowrap">
	<input type="button" name="selectall" value="<?php echo $admtext[selectall]; ?>" onClick="toggleAll(1);">
	<input type="button" name="clearall" value="<?php echo $admtext[clearall]; ?>" onClick="toggleAll(0);">&nbsp;&nbsp;
<?php
	if( $allow_delete ) {
?>
	<input type="submit" name="xphaction" value="<?php echo $admtext[deleteselected]; ?>" onClick="return confirm('<?php echo $admtext[confdeleterecs]; ?>');">&nbsp;&nbsp;
<?php
	}
	if( $allow_edit ) {
?>
	<input type="submit" name="xphaction" value="<?php echo $admtext[convto]; ?>">
	<select name="newmediatype" style="vertical-align:top">
<?php
		foreach( $mediatypes as $mediatype ) {
			$msgID = $mediatype[ID];
			if( $msgID != $mediatypeID )
				echo "	<option value=\"$msgID\">" . $mediatype['display'] . "</option>\n";
		}
		echo "</select>&nbsp;&nbsp;\n";

		$albumquery = "SELECT albumID, albumname FROM $albums_table ORDER BY albumname";
		$albumresult = mysql_query($albumquery) or die ("$admtext[cannotexecutequery]: $albumquery");
		$numalbums = mysql_num_rows($albumresult);
		if($numalbums) {
			echo "<input type=\"submit\" name=\"xphaction\" value=\"$admtext[addtoalbum]\">\n";
			echo "<select name=\"albumID\" style=\"vertical-align:top\">\n";
			while( $albumrow = mysql_fetch_assoc($albumresult) )
				echo "	<option value=\"$albumrow[albumID]\">$albumrow[albumname]</option>\n";
			echo "</select>\n";
		}
		mysql_free_result($albumresult);
	}
?>
	</p>
	
	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[action]; ?></b>&nbsp;</nobr></td>
<?php
	if($allow_delete) {
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[select]; ?></b>&nbsp;</nobr></td>
<?php
	}
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[thumb]; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo "$admtext[title], $admtext[description]"; ?></b>&nbsp;</nobr></td>
<?php
	if($map[key]) {
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[googleplace]; ?></b>&nbsp;</nobr></td>
<?php
	}
	if(!$mediatypeID) {
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[mediatype]; ?></b>&nbsp;</nobr></td>
<?php
	}
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[linkedto]; ?></b>&nbsp;</nobr></td>
		</tr>
<?php
	if( substr( $photopath, 0, 1 ) != "/" )
		$relativepath = $cms[support] ? "../../../" : "../";
	else
		$relativepath = "";

	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editmedia.php?mediaID=xxx\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
		$actionstr .= "<a href=\"" . $showmedia_url . "mediaID=xxx\" target=\"_blank\"><img src=\"tng_test.gif\" title=\"$admtext[test]\" alt=\"$admtext[test]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result))
		{
			$mtypeID = $row[mediatypeID];
			$usefolder = $row[usecollfolder] ? $mediatypes_assoc[$mtypeID] : $mediapath;
			$newactionstr = ereg_replace( "xxx", $row[mediaID], $actionstr );
			echo "<tr id=\"row_$row[mediaID]\"><td class=\"lightback\" valign=\"top\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" align=\"center\"><input type=\"checkbox\" name=\"ph$row[mediaID]\" value=\"1\"></td>";
			echo "<td valign=\"top\" class=\"lightback\" align=\"center\">";
			if( $row[thumbpath] && file_exists("$rootpath$usefolder/$row[thumbpath]")) {
				$photoinfo = @GetImageSize( "$rootpath$usefolder/$row[thumbpath]" );
				if( $photoinfo[1] < 50 ) {
					$photohtouse = $photoinfo[1];
					$photowtouse = $photoinfo[0];
				}
				else {
					$photohtouse = 50;
					$photowtouse = intval( 50 * $photoinfo[0] / $photoinfo[1] ) ;
				}
				echo "<span class=\"normal\">";
				echo "<img border=0 src=\"$relativepath$usefolder/" . str_replace("%2F","/",rawurlencode( $row[thumbpath] )) . "\" width=\"$photowtouse\" height=\"$photohtouse\"></span>\n";
			}
			else
				echo "&nbsp;";
			echo "</td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\"><u>$row[description]</u><br />" . truncateIt(getXrefNotes($row[notes]),$maxnoteprev) . "</span></td>\n";
			if($map[key]) {
				echo "<td nowrap class=\"lightback\" valign=\"top\"><span class=\"normal\">";
				$geo = "";
				if($row[latitude]) $geo .= "$admtext[latitude]: " . number_format($row[latitude],3);
				if($row[longitude]) {
					if($geo) $geo .= "<br />";
					$geo .= "$admtext[longitude]: " . number_format($row[longitude],3);
				}
				if($row[zoom]) {
					if($geo) $geo .= "<br />";
					$geo .= "$admtext[zoom]: $row[zoom]";
				}
				echo "$geo&nbsp;</span></td>\n";
			}
			if( !$mediatypeID ) {
				$label = $text[$mtypeID] ? $text[$mtypeID] : $mediatypes_display[$mtypeID];
				echo "<td nowrap class=\"lightback normal\" valign=\"top\">" . $label . "&nbsp;</td>\n";
			}

			$query = "SELECT people.personID as personID2, familyID, husband, wife, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.prefix as prefix, people.suffix as suffix, nameorder,
				$medialinks_table.personID as personID, $sources_table.title, $sources_table.sourceID, $repositories_table.repoID, reponame, linktype, $families_table.gedcom as gedcom
				FROM $medialinks_table
				LEFT JOIN $people_table AS people ON $medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom
				LEFT JOIN $families_table ON $medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom
				LEFT JOIN $sources_table ON $medialinks_table.personID = $sources_table.sourceID AND $medialinks_table.gedcom = $sources_table.gedcom
				LEFT JOIN $repositories_table ON ($medialinks_table.personID = $repositories_table.repoID AND $medialinks_table.gedcom = $repositories_table.gedcom)
				WHERE mediaID = \"$row[mediaID]\"$wherestr2 ORDER BY lastname, lnprefix, firstname, personID LIMIT 10";
			$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$medialinktext = "";
			while( $prow = mysql_fetch_assoc( $presult ) ){
				if( $prow[personID2] != NULL ) {
					$medialinktext .= "<li>" . getName( $prow ) . " ($prow[personID2])</li>\n";
				}
				elseif( $prow[sourceID] != NULL ) {
					$sourcetext = $prow[title] ? "$admtext[source]: $prow[title]" : "$admtext[source]: $prow[sourceID]";
					$medialinktext .= "<li>$sourcetext ($prow[sourceID])</li>\n";
				}
				elseif( $prow[repoID] != NULL ) {
					$repotext = $prow[reponame] ? "$admtext[repository]: $prow[reponame]" : "$admtext[repository]: $prow[repoID]";
					$medialinktext .= "<li>$repotext ($prow[repoID])</li>\n";
				}
				elseif( $prow[familyID] != NULL )
					$medialinktext .= "<li>$admtext[family]: " . getFamilyName( $prow ) . "</li>\n";
				else
					$medialinktext .= "<li>$prow[personID]</li>";
				
			}
			if(!$medialinktext) $medialinktext = "&nbsp;";
			echo "<td nowrap class=\"lightback normal\" valign=\"top\">$medialinktext</td>\n";

			echo "</tr>\n";
		}
?>
	</table>
<?php
		echo displayListLocation($offsetplus,$numrowsplus,$totrows);
		echo " &nbsp; $pagenav</p>";
	}
	else
		echo "</table>\n$admtext[norecords]";
  	mysql_free_result($result);
?>
	</form>

	<p style="vertical-align:middle">
	<img src="tng_edit.gif" alt="<?php echo $admtext[edit]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['edit']; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext[text_delete]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['text_delete']; ?> &nbsp;&nbsp;
	<img src="tng_test.gif" alt="<?php echo $admtext[test]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['test']; ?>
	</p>

	</div>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
<script language="javascript" type="text/javascript">
	toggleHeadstoneCriteria('<?php echo $mediatypeID; ?>');
</script>
</html>
