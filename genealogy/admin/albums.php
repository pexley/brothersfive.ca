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
session_register('tng_search_album_post');
$tng_search_album = $_SESSION[tng_search_album] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_album_post[search]", $searchstring, $exptime);
	setcookie("tng_search_album_post[tree]", $tree, $exptime);
	setcookie("tng_search_album_post[page]", 1, $exptime);
	setcookie("tng_search_album_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_album_post][search];
	if( !$tree )
		$tree = $_COOKIE[tng_search_album_post][tree];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_album_post][page];
		$offset = $_COOKIE[tng_search_album_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_album_post[page]", $page, $exptime);
		setcookie("tng_search_album_post[offset]", $offset, $exptime);
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
	$tree = $assignedtree;
}

$showalbum_url = getURL( "showalbum", 1 );

$wherestr = $searchstring ? "WHERE albumname LIKE \"$searchstring%\" OR description LIKE \"$searchstring%\" OR keywords LIKE \"$searchstring%\"" : "";

if( $assignedtree )
	$wherestr2 = " AND $album2entities_table.gedcom = \"$assignedtree\"";
elseif($tree) 
	$wherestr2 = " AND $album2entities_table.gedcom = \"$tree\"";
else
	$wherestr2 = "";

$query = "SELECT * FROM $albums_table $wherestr ORDER BY albumname LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(albumID) as acount FROM $albums_table WHERE $allwhere";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[acount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("albums_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[albums], $flags );
?>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$albumtabs[0] = array(1,"albums.php",$admtext['search'],"findalbum");
	$albumtabs[1] = array($allow_add,"newalbum.php",$admtext[addnew],"addalbum");
	$albumtabs[2] = array($allow_edit,"orderalbumform.php",$admtext[text_sort],"sortalbums");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/albums_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($albumtabs,"findalbum",$innermenu);
	echo displayHeadline("$admtext[albums]","albums_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="albums.php" style="margin:0px;" name="form1" id="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext[searchfor]; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>"></td>
			<td>
				<input type="submit" name="submit" value="<?php echo $admtext[search]; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext[reset]; ?>" onClick="document.form1.searchstring.value='';" style="vertical-align:top">
			</td>
		</tr>
	</table>

	<input type="hidden" name="findalbum" value="1"><input type="hidden" name="newsearch" value="1">
	</form>

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "albums.php?searchstring=$searchstring&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>

	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['thumb']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['albumname'] . ", " . $admtext['description']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['albmedia']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['linkedto']; ?></b>&nbsp;</nobr></td>
		</tr>
<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editalbum.php?albumID=xxx\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"if(confirm('$admtext[confdeletealbum]' )){deleteIt('album',xxx);} return false;\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
		$actionstr .= "<a href=\"" . $showalbum_url . "albumID=xxx\" target=\"_blank\"><img src=\"tng_test.gif\" title=\"$admtext[test]\" alt=\"$admtext[test]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result))
		{
			$newactionstr = ereg_replace( "xxx", $row[albumID], $actionstr );
			echo "<tr id=\"row_$row[albumID]\"><td class=\"lightback normal\" valign=\"top\"><nobr>$newactionstr</nobr></td>\n";
			echo "<td class=\"lightback normal\" style=\"width:" . ($thumbmaxw+6) . "px;text-align:center;vertical-align:top\">";

			$query2 = "SELECT thumbpath, usecollfolder, mediatypeID FROM ($media_table, $albumlinks_table)
				WHERE albumID = \"$row[albumID]\" AND $media_table.mediaID = $albumlinks_table.mediaID AND defphoto=\"1\"";
			$result2 = mysql_query($query2) or die ("$text[cannotexecutequery]: $query2");
			$trow = mysql_fetch_assoc( $result2 );
			$tmediatypeID = $trow['mediatypeID'];
			$tusefolder = $trow['usecollfolder'] ? $mediatypes_assoc[$tmediatypeID] : $mediapath;
			$trelativepath = substr( $tusefolder, 0, 1 ) != "/" ? $cms['support'] ? "../../../" : "../" : "";
			mysql_free_result($result2);

			if( $trow[thumbpath] && file_exists( "$rootpath$tusefolder/$trow[thumbpath]" ) ) {
				$size = @GetImageSize( "$rootpath$tusefolder/$trow[thumbpath]" );
				echo "<a href=\"editalbum.php?albumID=$row[albumID]\"><img src=\"$trelativepath$tusefolder/" . str_replace("%2F","/",rawurlencode( $trow[thumbpath] )) . "\" border=\"0\" $size[3] alt=\"$row[albumname]\"></a>";
			}
			else
				echo "&nbsp;";
			echo "</td>\n";

            		$query = "SELECT count(albumlinkID) as acount FROM $albumlinks_table WHERE albumID = \"$row[albumID]\"";
			$cresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			$crow = mysql_fetch_assoc( $cresult );
			$acount = $crow['acount'];
			mysql_free_result($cresult);


			echo "<td nowrap class=\"lightback normal\" valign=\"top\"><u>$row[albumname]</u><br />$row[description]&nbsp;</td>\n";
			echo "<td nowrap class=\"lightback normal\" valign=\"top\" align=\"center\">$acount&nbsp;</td>\n";

			$query = "SELECT people.personID as personID2, familyID, husband, wife, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.prefix as prefix, people.suffix as suffix, nameorder,
				$album2entities_table.entityID as personID, $sources_table.title, $sources_table.sourceID, $repositories_table.repoID, reponame
				FROM $album2entities_table
				LEFT JOIN $people_table AS people ON $album2entities_table.entityID = people.personID AND $album2entities_table.gedcom = people.gedcom
				LEFT JOIN $families_table ON $album2entities_table.entityID = $families_table.familyID AND $album2entities_table.gedcom = $families_table.gedcom
				LEFT JOIN $sources_table ON $album2entities_table.entityID = $sources_table.sourceID AND $album2entities_table.gedcom = $sources_table.gedcom
				LEFT JOIN $repositories_table ON ($album2entities_table.entityID = $repositories_table.repoID AND $album2entities_table.gedcom = $repositories_table.gedcom)
				WHERE albumID = \"$row[albumID]\"$wherestr2 ORDER BY lastname, lnprefix, firstname, personID LIMIT 10";
			$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$alinktext = "";
			while( $prow = mysql_fetch_assoc( $presult ) ){
				if( $prow[personID2] != NULL ) {
					$alinktext .= "<li>" . getName( $prow ) . " ($prow[personID2])</li>\n";
				}
				elseif( $prow[sourceID] != NULL ) {
					$sourcetext = $prow[title] ? "$admtext[source]: $prow[title]" : "$admtext[source]: $prow[sourceID]";
					$alinktext .= "<li>$sourcetext ($prow[sourceID])</li>\n";
				}
				elseif( $prow[repoID] != NULL ) {
					$repotext = $prow[reponame] ? "$admtext[repository]: $prow[reponame]" : "$admtext[repository]: $prow[repoID]";
					$alinktext .= "<li>$repotext ($prow[repoID])</li>\n";
				}
				elseif( $prow[familyID] != NULL )
					$alinktext .= "<li>$admtext[family]: " . getFamilyName( $prow ) . "</li>\n";
				else
					$alinktext .= "<li>$prow[personID]</li>";
				
			}
			if(!$alinktext) $alinktext = "&nbsp;";
			echo "<td nowrap class=\"lightback normal\" valign=\"top\">$alinktext</td>\n";
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

	<p>
	<img src="tng_edit.gif" alt="<?php echo $admtext['edit']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['edit']; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext['text_delete']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['text_delete']; ?> &nbsp;&nbsp;
	<img src="tng_test.gif" alt="<?php echo $admtext['test']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['test']; ?>
	</p>

	</div>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
