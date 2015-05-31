<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

initMediaTypes();

function get_album_nav( $total, $address, $perpage, $pagenavpages ) {
	global $page, $totalpages, $tree, $text, $orgtree, $albumID;

	if( !$page ) $page = 1;
	if( !$perpage ) $perpage = 50;

	if( $total <= $perpage )
		return "";

	$totalpages = ceil( $total / $perpage );
	if ( $page > $totalpages ) $page = $totalpages;

	if( $page > 1 ) {
		$prevpage = $page-1;
		$navoffset = ( ( $prevpage * $perpage ) - $perpage );
		$prevlink = " <a href=\"#\" onclick=\"return getMoreMedia('$address=$navoffset&amp;tree=$orgtree&amp;page=$prevpage&amp;albumID=$albumID');\" title=\"$text[text_prev]\">&laquo;$text[text_prev]</a> ";
	}
	if ($page<$totalpages) {
		$nextpage = $page+1;
		$navoffset = (($nextpage * $perpage) - $perpage);
		$nextlink = "<a href=\"#\" onclick=\"return getMoreMedia('$address=$navoffset&amp;tree=$orgtree&amp;page=$nextpage&amp;albumID=$albumID');\" title=\"$text[text_next]\">$text[text_next]&raquo;</a>";
	}
	while( $curpage++ < $totalpages ) {
   	$navoffset = ( ($curpage - 1 ) * $perpage );
		if( ( $curpage <= $page - $pagenavpages || $curpage >= $page + $pagenavpages ) && $pagenavpages ) {
			if( $curpage == 1 )
				$firstlink = " <a href=\"#\" onclick=\"return getMoreMedia('$address=$navoffset&amp;tree=$orgtree&amp;page=$curpage&amp;albumID=$albumID');\" title=\"$text[firstpage]\">&laquo;1</a> ... ";
		    if( $curpage == $totalpages )
				$lastlink = "... <a href=\"#\" onclick=\"return getMoreMedia('$address=$navoffset&amp;tree=$orgtree&amp;page=$curpage&amp;albumID=$albumID');\" title=\"$text[lastpage]\">$totalpages&raquo;</a>";
		}
		else {
			if( $curpage == $page )
				$pagenav .= " [$curpage] ";
			else
				$pagenav .= " <a href=\"#\" onclick=\"return getMoreMedia('$address=$navoffset&amp;tree=$orgtree&amp;page=$curpage&amp;albumID=$albumID');\">$curpage</a> ";
		}
	}
	$pagenav = "<span class=\"normal\">$prevlink $firstlink $pagenav $lastlink $nextlink</span>";

	return $pagenav;
}

$wherestr = $searchstring ? "($media_table.mediaID LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR path LIKE \"%$searchstring%\" OR notes LIKE \"%$searchstring%\" OR owner LIKE \"%$searchstring%\" OR bodytext LIKE \"%$searchstring%\")" : "";
if( $searchtree )
	$wherestr .= $wherestr ? " AND (gedcom = \"\" OR gedcom = \"$searchtree\")" : "(gedcom = \"\" OR gedcom = \"$searchtree\")";
if( $mediatypeID )
	$wherestr .= $wherestr ? " AND mediatypeID = \"$mediatypeID\"" : "mediatypeID = \"$mediatypeID\"";
if( $fileext )
	$wherestr .= $wherestr ? " AND form = \"$fileext\"" : "form = \"$fileext\"";
if( $hsstat )
	$wherestr .= $wherestr ? " AND status = \"$hsstat\"" : "status = \"$hsstat\"";
if( $cemeteryID )
	$wherestr .= $wherestr ? " AND cemeteryID = \"$cemeteryID\"" : "cemeteryID = \"$cemeteryID\"";
if( $wherestr ) $wherestr = "WHERE $wherestr";

if( isset($offset) && $offset != 0 ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offset = 0;
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

$query = "SELECT $media_table.mediaID as mediaID, $medialinkID description, notes, thumbpath, mediatypeID, usecollfolder, datetaken FROM $media_table $join $wherestr ORDER BY description LIMIT $newoffset" . $maxsearchresults;
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

if($albumID) {
	$query2 = "SELECT mediaID FROM $albumlinks_table WHERE albumID = \"$albumID\"";
	$result2 = mysql_query($query2) or die ("$text[cannotexecutequery]: $query2");
	$alreadygot = array();
	while( $row2 = mysql_fetch_assoc($result2))
		$alreadygot[] = $row2['mediaID'];
	mysql_free_result($result2);
}
else
	$alreadygot[] = array();

header("Content-type:text/html; charset=" . $session_charset);

$numrowsplus = $numrows + $offset;
if( !$numrowsplus ) $offsetplus = 0;
echo "<p class=\"normal\">$admtext[matches]: $offsetplus $text[to] $numrowsplus $text[of] $totrows";
$pagenav = get_album_nav( $totrows, "searchstring=$searchstring&amp;mediatypeID=$mediatypeID&amp;hsstat=$hsstat&amp;cemeteryID=$cemeteryID&amp;offset", $maxsearchresults, 5 );
echo " &nbsp; $pagenav</p>";
?>
	<table cellpadding="3" cellspacing="1" border="0" width="595">
		<tr>
			<td class="fieldnameback" width="50"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['thumb']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['description']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['date']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['mediatype']; ?></b>&nbsp;</nobr></span></td>
		</tr>
<?php
	if( substr( $photopath, 0, 1 ) != "/" )
		$relativepath = $cms[support] ? "../../../" : "../";
	else
		$relativepath = "";

	while( $row = mysql_fetch_assoc($result))
	{
		$mtypeID = $row['mediatypeID'];
		$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mtypeID] : $mediapath;
		echo "<tr id=\"addrow_$row[mediaID]\"><td class=\"lightback\" align=\"center\">";
		echo "<div id=\"add_$row[mediaID]\" class=\"normal\"";
		$gotit = in_array($row['mediaID'],$alreadygot);
		if($gotit)
			echo " style=\"display:none\"";
		if($albumID)
			echo "><a href=\"#\" onclick=\"return addToAlbum('$row[mediaID]');\">" . $admtext['add'] . "</a></div>";
		else
			echo "><a href=\"#\" onclick=\"return selectMedia('$row[mediaID]');\">" . $admtext['select'] . "</a></div>";
		echo "<div id=\"added_$row[mediaID]\"";
		if(!$gotit)
			echo " style=\"display:none\">";
		else
			echo "><img src=\"tng_test.gif\" alt=\"\" $dims class=\"smallicon\">";
		echo "</div>";
		echo "&nbsp;</td>";
		echo "<td valign=\"top\" class=\"lightback\" style=\"text-align:center\" id=\"thumbcell_$row[mediaID]\">";
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
			echo "<a href=\"editmedia.php?mediaID=$row[mediaID]\" target=\"_blank\"><img border=0 src=\"$relativepath$usefolder/" . str_replace("%2F","/",rawurlencode( $row[thumbpath] )) . "\" width=\"$photowtouse\" height=\"$photohtouse\"></a>\n";
		}
		else
			echo "&nbsp;";
		echo "</td>\n";
		$truncated = substr($row[notes],0,90);
		$truncated = strlen($row[notes]) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $row[notes];
		echo "<td class=\"lightback normal\" valign=\"top\" id=\"desc_$row[mediaID]\"><a href=\"editmedia.php?mediaID=$row[mediaID]\">$row[description]</a><br/>$truncated &nbsp;</td>";
		echo "<td class=\"lightback normal\" style=\"width:100px;\" valign=\"top\" id=\"date_$row[mediaID]\">$row[datetaken]&nbsp;</td>\n";
		echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\" id=\"mtype_$row[mediaID]\">" . $text[$mtypeID] . "&nbsp;</span></td>\n";
		echo "</tr>\n";
	}
?>
	</table>
<?php
	echo "<p class=\"normal\">$admtext[matches]: $offsetplus $text[to] $numrowsplus $text[of] $totrows";
	echo " &nbsp; $pagenav</p>";
?>
