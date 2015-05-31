<?php
include("begin.php");
if($cms['events']){include('cmsevents.php'); cms_whatsnew();}
include($cms['tngpath'] . "genlib.php");
$textpart = "reports";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "functions.php" );

$getperson_url = getURL( "getperson", 1 );
$showmedia_url = getURL( "showmedia", 1 );
$mostwanted_url = getURL( "mostwanted", 0 );

$logstring = "<a href=\"$mostwanted_url\">" . xmlcharacters($text['mostwanted']) . "</a>";
writelog($logstring);
preparebookmark($logstring);

$wherestr = $tree ? " AND $mostwanted_table.gedcom = \"$tree\"" : "";
$suggest_url = getURL( "suggest", 1 );
$getperson_url = getURL( "getperson", 1 );

function showDivs($type) {
	global $wherestr, $text, $people_table, $media_table, $mostwanted_table, $mediatypes_assoc, $mediapath, $cms, $rootpath, $suggest_url, $getperson_url, $thumbmaxw, $livedefault, $allow_living;

	$mediatext = "<table style=\"border:1px solid silver; margin:5px; width:100%\" cellpadding=\"8\" cellspacing=\"4\">\n";

	$query = "SELECT DISTINCT $mostwanted_table.ID as mwID, mwtype, thumbpath, abspath, form, usecollfolder, mediatypeID, path, $media_table.description as mtitle,
		$mostwanted_table.personID, $mostwanted_table.gedcom, $mostwanted_table.mediaID, $mostwanted_table.description as mwdesc, $mostwanted_table.title as mwtitle,
		lastname, firstname, lnprefix, suffix, prefix, $people_table.title as title, living, nameorder, branch
		FROM $mostwanted_table
		LEFT JOIN $media_table ON $mostwanted_table.mediaID = $media_table.mediaID
		LEFT JOIN $people_table ON $mostwanted_table.personID = $people_table.personID AND $mostwanted_table.gedcom = $people_table.gedcom
		WHERE mwtype = \"$type\"$wherestr ORDER BY ordernum";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

	while( $row = mysql_fetch_assoc( $result ) ) {
		$mediatypeID = $row['mediatypeID'];
		$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
		$imgsrc = $row['mediaID'] ? getSmallPhoto($row) : "";

		$mediatext .= "<tr><td class=\"databack normal\">\n";
		$href = getMediaHREF($row,0);
		if($imgsrc) {
			$mediatext .= "<div style=\"float:left; margin-right:15px; margin-bottom:5px;\">\n<div class=\"media-img\"><div class=\"media-prev\" id=\"prev$row[mediaID]\" style=\"display:none;left:$thumbmaxw" . "px\"></div></div>\n";
			$mediatext .= "<a href=\"$href\"";
			if( function_exists( imageJpeg ) && isPhoto($row))
				$mediatext .= " onmouseover=\"showPreview('$row[mediaID]','" . urlencode("$usefolder/$row[path]") . "');\" onmouseout=\"closePreview('$row[mediaID]');\" onclick=\"closePreview('$row[mediaID]');\"";
			$mediatext .= ">$imgsrc</a>\n";
			$mediatext .= "</div>\n";
		}
		$mediatext .= "<span><strong>$row[mwtitle]</strong></span><br /><br />";
		$mediatext .= "<div style=\"margin:0px;\">$row[mwdesc]</div>";

		$mediatext .= "<div style=\"margin-top:10px; color:gray\">\n";
		if($type == "person") {
			if($row['personID']) {
				$mediatext .= "<a href=\"$suggest_url" . "enttype=I&amp;ID=$row[personID]&amp;tree=$row[gedcom]\">" . $text['tellus'] . "</a>";
				$rightbranch = checkbranch( $row['branch'] ) ? 1 : 0;
				$row['allow_living'] = !$row['living'] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
				$name = getName($row);
				$mediatext .= " &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; " . $text['moreinfo'] . " <a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$name</a>";
			}
			else
				$mediatext .= "<a href=\"$suggest_url\">" . $text['tellus'] . "</a>";
		}
		if($type == "photo" && $row['mediaID']) {
			$mediatext .= "<a href=\"$suggest_url\">" . $text['tellus'] . "</a>";
			$mediatext .= " &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; " . $text['moreinfo'] . " <a href=\"$href\">$row[mtitle]</a> &nbsp;&nbsp;&nbsp;";
		}
		$mediatext .= "</div>\n";
		$mediatext .= "</td></tr>\n";
	}
	$numrows = mysql_num_rows($result);
	mysql_free_result($result);

	$mediatext .= "</table>\n";

	return $mediatext;
}

$flags = "";
tng_header( $text['mostwanted'], $flags );
?>

<p class="header"><img src="<?php echo $cms['tngpath']; ?>tng_mw.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text['mostwanted']; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'mostwanted', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1'));

echo "<p class=\"subhead\">&nbsp;<strong>" . $text['mysperson'] . "</strong></p>\n";
echo showDivs("person");

echo "<br /><br /><p class=\"subhead\">&nbsp;<strong>" . $text['mysphoto'] . "</strong></p>\n";
echo showDivs("photo");

tng_footer( "" );
?>
