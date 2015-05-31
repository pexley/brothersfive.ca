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

require("adminlog.php");

//mediatypeID and linktype should be passed in
$personID = ucfirst( $newlink1 );
$linktype = $linktype1;
$eventID = $event1;
$tree = $tree1;

$sortstr = ereg_replace( "xxx", $admtext['albums'], $admtext['sortmedia'] );

switch( $linktype ) {
	case "I":
		$query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, branch FROM $people_table WHERE personID=\"$personID\" AND gedcom = \"$tree\"";
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$person = mysql_fetch_assoc( $result2 );
		$namestr = "$personID: " . getName( $person );
		mysql_free_result($result2);
		break;
	case "F":
		$query = "SELECT branch FROM $families_table WHERE familyID=\"$personID\" AND gedcom = \"$tree\"";
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$person = mysql_fetch_assoc( $result2 );
		$namestr = "$admtext[family]: $personID";
		mysql_free_result($result2);
		break;
	case "S":
		$query = "SELECT title FROM $sources_table WHERE sourceID=\"$personID\" AND gedcom = \"$tree\"";
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$person = mysql_fetch_assoc( $result2 );
		$namestr = "$admtext[source]: $personID";
		if( $person[title] ) $namestr .= ", $person[title]";
		$person[branch] = "";
		mysql_free_result($result2);
		break;
	case "R":
		$query = "SELECT reponame FROM $repositories_table WHERE repoID=\"$personID\" AND gedcom = \"$tree\"";
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$person = mysql_fetch_assoc( $result2 );
		$namestr = "$admtext[repository]: $personID";
		if( $person[reponame] ) $namestr .= ", $person[reponame]";
		$person[branch] = "";
		mysql_free_result($result2);
		break;
	case "L":
		$namestr = $personID;
		$person[branch] = "";
		break;
}

if( !checkbranch( $person[branch] ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

adminwritelog( "<a href=\"ordermedia.php?personID=$personID&amp;tree=$tree\">$sortstr: $action</a>" );

$photofound = 0;
$photo = "";

$query = "SELECT alwayson, thumbpath, $media_table.mediaID as mediaID, usecollfolder, mediatypeID, medialinkID FROM ($media_table, $medialinks_table)
	WHERE personID = \"$personID\" AND $medialinks_table.gedcom = \"$tree\" AND $media_table.mediaID = $medialinks_table.mediaID AND defphoto = '1'";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) $row = mysql_fetch_assoc( $result );
$thismediatypeID = $row['mediatypeID'];
$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$thismediatypeID] : $mediapath;
mysql_free_result($result);

$relativepath = substr( $usefolder, 0, 1 ) != "/" ? $cms['support'] ? "../../../" : "../" : "";

if( $row['thumbpath'] )
	$photoref = "$usefolder/$row[thumbpath]";
else {
	$photoref = $tree ? "$usefolder/$tree.$personID.$photosext" : "$photopath/$personID.$photosext";
}

if( file_exists( "$rootpath$photoref" ) ) {
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
	$photofound = 1;
}

$query = "SELECT * FROM ($album2entities_table, $albums_table) WHERE $album2entities_table.entityID=\"$personID\" AND $album2entities_table.gedcom = \"$tree\" AND $albums_table.albumID = $album2entities_table.albumID ORDER BY ordernum";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );

if ( !$numrows ) {
	$message = $admtext[noresults];
	header( "Location: orderalbumform.php?personID=$personID&message=" . urlencode($message) );
	exit;
}

$helplang = findhelp("media_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $sortstr, $flags );

?>
<SCRIPT language="JavaScript" type="text/javascript">
var entity = "<?php echo $personID; ?>";
var album = "<?php echo $albumID; ?>";
var tree = "<?php echo $tree; ?>";
</script>
<script language="JavaScript" src="albums.js"></script>
<script language="JavaScript" src="orderphotos.js"></script>
</head>

<body background="../background.gif" onLoad="startAlbumSort()">

<?php
	$albumtabs[0] = array(1,"albums.php",$admtext['search'],"findalbum");
	$albumtabs[1] = array($allow_add,"newalbum.php",$admtext[addnew],"addalbum");
	$albumtabs[2] = array($allow_edit,"orderalbumform.php",$admtext[text_sort],"sortalbums");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/albums_help.php#sortfor', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($albumtabs,"sortalbums",$innermenu);
	echo displayHeadline("$admtext[albums] &gt;&gt; $admtext[text_sort]","albums_icon.gif",$menu,"");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<span class="subhead"><?php echo "<div id=\"thumbholder\" style=\"float:left\">$photo</div><strong>$sortstr<br/>$namestr</strong>"; ?></span><br/><br clear="left">
	<br/>
	<table id="ordertbl" width="100%" cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback" style="width:55px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[text_sort]; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" style="width:<?php echo ($thumbmaxw+10); ?>px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[thumb]; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[description]; ?></b>&nbsp;</nobr></span></td>
		</tr>
	</table>

<form style="margin:0px" name="form1">
<div id="orderdivs">
<?php
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $row = mysql_fetch_assoc( $result ) )
	{
		$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
		$truncated = substr($row['description'],0,90);
		$truncated = strlen($row['description']) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $row['description'];
		echo "<div class=\"sortrow\" id=\"orderdivs_$row[alinkID]\" style=\"clear:both\" onmouseover=\"$('md_$row[albumID]').style.visibility='visible';\" onmouseout=\"$('md_$row[albumID]').style.visibility='hidden';\">";
		echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr>\n";
		echo "<td class=\"dragarea normal\">";
   		echo "<img src=\"ArrowUp.gif\" alt=\"\"><br/>" . $admtext['drag'] . "<br/><img src=\"ArrowDown.gif\" alt=\"\">\n";
		echo "</td>\n";
		echo "<td class=\"lightback\" style=\"width:" . ($thumbmaxw+6) . "px;text-align:center;\">";

		$query2 = "SELECT thumbpath, usecollfolder, mediatypeID FROM ($albumlinks_table, $media_table) WHERE albumID=\"$row[albumID]\" AND defphoto = \"1\" AND $albumlinks_table.mediaID = $media_table.mediaID";
		$result2 = mysql_query($query2) or die ("$admtext[cannotexecutequery]: $query2");
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
		$checked = $row['defphoto'] ? " checked" : "";
		echo "<td class=\"lightback normal\"><a href=\"editalbum.php?albumID=$row[albumID]\">$row[albumname]</a><br/>$truncated<br/>";
		echo "<span id=\"md_$row[albumID]\" class=\"smaller\" style=\"visibility:hidden\"><a href=\"#\" onclick=\"return removeFromSort('album','$row[alinkID]');\">$admtext[remove]</a></span></td>\n";
		echo "</tr></table>";
		echo "</div>\n";
	}
	mysql_free_result($result);
?>
</div>
</form>

</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
