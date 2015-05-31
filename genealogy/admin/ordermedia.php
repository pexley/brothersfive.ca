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

$sortstr = ereg_replace( "xxx", $text[$mediatypeID], $admtext[sortmedia] );

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
if( $assignedbranch )
	$branchstr = " AND branch LIKE \"%$assignedbranch%\"";
else
	$branchstr = "";

adminwritelog( "<a href=\"ordermedia.php?personID=$personID&amp;tree=$tree\">$sortstr: $tree/$personID</a>" );

$photo = "";

$query = "SELECT alwayson, thumbpath, $media_table.mediaID as mediaID, usecollfolder, mediatypeID, medialinkID FROM ($media_table, $medialinks_table)
	WHERE personID = \"$personID\" AND $medialinks_table.gedcom = \"$tree\" AND $media_table.mediaID = $medialinks_table.mediaID AND defphoto = '1'";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) $row = mysql_fetch_assoc( $result );
$thismediatypeID = $row[mediatypeID];
mysql_free_result($result);

$query = "SELECT * FROM ($medialinks_table, $media_table) WHERE $medialinks_table.personID=\"$personID\" AND $medialinks_table.gedcom = \"$tree\" $branchstr AND $media_table.mediaID = $medialinks_table.mediaID AND eventID = \"$eventID\" AND mediatypeID = \"$mediatypeID\" ORDER BY ordernum";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );

if ( !$numrows ) {
	$message = $admtext[noresults];
	header( "Location: ordermediaform.php?personID=$personID&message=" . urlencode($message) );
	exit;
}

$helplang = findhelp("media_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $sortstr, $flags );

$usefolder = $row[usecollfolder] ? $mediatypes_assoc[$thismediatypeID] : $mediapath;

if( substr( $usefolder, 0, 1 ) != "/" )
	$relativepath = $cms[support] ? "../../../" : "../";
else
	$relativepath = "";

if( $row[thumbpath] )
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
}
?>
<SCRIPT language="JavaScript" type="text/javascript">
var entity = "<?php echo $personID; ?>";
var tree = "<?php echo $tree; ?>";
var album = "";
</script>
<script language="JavaScript" src="orderphotos.js"></script>
<script language="JavaScript" src="admin.js"></script>
</head>

<body background="../background.gif" onLoad="startMediaSort()">

<?php
	$mediatabs[0] = array(1,"media.php",$admtext['search'],"findmedia");
	$mediatabs[1] = array($allow_add,"newmedia.php",$admtext[addnew],"addmedia");
	$mediatabs[2] = array($allow_edit,"ordermediaform.php",$admtext[text_sort],"sortmedia");
	$mediatabs[3] = array($allow_edit && !$assignedtree,"thumbnails.php",$admtext[thumbnails],"thumbs");
	$mediatabs[4] = array($allow_add,"photoimport.php",$admtext['import'],"import");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/media_help.php#sortfor', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($mediatabs,"sortmedia",$innermenu);
	echo displayHeadline("$admtext[media] &gt;&gt; $admtext[text_sort]","photos_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<span class="subhead"><?php echo "<div id=\"thumbholder\" style=\"float:left\">$photo</div><strong>$sortstr<br/>$namestr</strong>"; ?></span><br/><br clear="left">
	<?php
		echo "<p class=\"smaller\" id=\"removedefault\"";
		if(!$photo) echo " style=\"display:none\"";
		echo "><a href=\"#\" onclick=\"return removeDefault();\">$admtext[removedef]</a></p>\n";
	?>
	<table id="ordertbl" width="100%" cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback" style="width:55px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[text_sort]; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" style="width:<?php echo ($thumbmaxw+10); ?>px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[thumb]; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[description]; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" style="width:154px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext[datetaken]; ?></b>&nbsp;</nobr></span></td>
		</tr>
	</table>

<form style="margin:0px" name="form1">
<div id="orderdivs">
<?php
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $row = mysql_fetch_assoc( $result ) )
	{
		$usefolder = $row[usecollfolder] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
		$truncated = substr($row[notes],0,90);
		$truncated = strlen($row[notes]) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $row[notes];
		echo "<div class=\"sortrow\" id=\"orderdivs_$row[medialinkID]\" style=\"clear:both\" onmouseover=\"$('md_$row[medialinkID]').style.visibility='visible';\" onmouseout=\"$('md_$row[medialinkID]').style.visibility='hidden';\">";
		echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr>\n";
		echo "<td class=\"dragarea normal\">";
   		echo "<img src=\"ArrowUp.gif\" alt=\"\"><br/>" . $admtext['drag'] . "<br/><img src=\"ArrowDown.gif\" alt=\"\">\n";
		echo "</td>\n";
		echo "<td class=\"lightback\" style=\"width:" . ($thumbmaxw+6) . "px;text-align:center;\">";
		if( $row[thumbpath] && file_exists( "$rootpath$usefolder/$row[thumbpath]" ) ) {
			$size = @GetImageSize( "$rootpath$usefolder/$row[thumbpath]" );
			echo "<a href=\"editmedia.php?mediaID=$row[mediaID]\"><img src=\"$relativepath$usefolder/" . str_replace("%2F","/",rawurlencode( $row[thumbpath] )) . "\" border=\"0\" $size[3] alt=\"$row[description]\"></a>";
		}
		echo "</td>\n";
		$checked = $row['defphoto'] ? " checked" : "";
		echo "<td class=\"lightback normal\"><a href=\"editmedia.php?mediaID=$row[mediaID]\">$row[description]</a><br/>$truncated<br/>\n";
		echo "<span id=\"md_$row[medialinkID]\" class=\"smaller\" style=\"color:gray;visibility:hidden\">\n";
		echo "<input type=\"radio\" name=\"rthumbs\" value=\"r$row[mediaID]\"$checked onclick=\"makeDefault(this);\">$admtext[makedefault]\n";
		echo " &nbsp;|&nbsp; ";
		echo "<a href=\"#\" onclick=\"return removeFromSort('media','$row[medialinkID]');\">$admtext[remove]</a>";
		echo "</span>&nbsp;</td>\n";
		echo "<td class=\"lightback normal\" style=\"width:150px;\">$row[datetaken]&nbsp;</td>\n";
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
