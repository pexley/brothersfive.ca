<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "reports";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

$mostwanted_url = getURL( "mostwanted", 0 );
$helplang = findhelp("mostwanted_help.php");

function showDiv($type) {
	global $thumbmaxw, $admtext, $mostwanted_table, $media_table, $people_table, $mediatypes_assoc, $mediapath, $cms, $allow_add, $allow_delete, $allow_edit, $rootpath;

	if($allow_add) {
		echo "<form action=\"\" style=\"margin:0px;padding-bottom:5px\" method=\"post\" name=\"form$type\" id=\"form$type\">\n";
		echo "<input type=\"button\" value=\"" . $admtext['addnew'] . "\" onclick=\"return openMostWanted('$type','');\">\n";
		echo "</form>\n";
	}

	echo "<div id=\"order$type" . "divs\">\n";
	echo "<table id=\"order$type" . "tbl\" width=\"100%\" cellpadding=\"3\" cellspacing=\"1\" border=\"0\">\n";
	echo "<tr>\n";
	echo "<td class=\"fieldnameback\" style=\"width:55px\"><span class=\"fieldname\"><nobr>&nbsp;<b>" . $admtext['text_sort'] . "</b>&nbsp;</nobr></span></td>\n";
	echo "<td class=\"fieldnameback\" style=\"width:" . ($thumbmaxw+10) . "px\"><span class=\"fieldname\"><nobr>&nbsp;<b>" . $admtext['thumb'] . "</b>&nbsp;</nobr></span></td>\n";
	echo "<td class=\"fieldnameback\"><span class=\"fieldname\"><nobr>&nbsp;<b>" . $admtext['description'] . "</b>&nbsp;</nobr></span></td>\n";
	echo "</tr>\n";
	echo "</table>\n";


	$query = "SELECT DISTINCT $mostwanted_table.ID as mwID, mwtype, thumbpath, usecollfolder, mediatypeID, $media_table.description as mtitle, $mostwanted_table.description as mwdesc, $mostwanted_table.title as title FROM $mostwanted_table
		LEFT JOIN $media_table ON $mostwanted_table.mediaID = $media_table.mediaID
		LEFT JOIN $people_table ON $mostwanted_table.personID = $people_table.personID AND $mostwanted_table.gedcom = $people_table.gedcom
		WHERE mwtype = \"$type\" ORDER BY ordernum";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	//echo $query;

	while( $lrow = mysql_fetch_assoc( $result ) )
	{
		$lmediatypeID = $lrow['mediatypeID'];
		$usefolder = $lrow['usecollfolder'] ? $mediatypes_assoc[$lmediatypeID] : $mediapath;
		if( substr( $usefolder, 0, 1 ) != "/" )
			$relativepath = $cms['support'] ? "../../../" : "../";
		else
			$relativepath = "";

		$truncated = substr($lrow['mwdesc'],0,90);
		$truncated = strlen($lrow['mwdesc']) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $lrow['mwdesc'];
		echo "<div class=\"sortrow\" id=\"order$lrow[mwtype]" . "divs_$lrow[mwID]\" style=\"clear:both\" onmouseover=\"showEditDelete('$lrow[mwID]');\" onmouseout=\"hideEditDelete('$lrow[mwID]');\">";
		echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr id=\"row_$lrow[mwID]\">\n";
		echo "<td class=\"dragarea normal\">";
   		echo "<img src=\"ArrowUp.gif\" alt=\"\"><br/>" . $admtext['drag'] . "<br/><img src=\"ArrowDown.gif\" alt=\"\">\n";
		echo "</td>\n";
		echo "<td class=\"lightback\" style=\"width:" . ($thumbmaxw+6) . "px;text-align:center;\">";
		if( $lrow[thumbpath] && file_exists( "$rootpath$usefolder/$lrow[thumbpath]" ) ) {
			$size = @GetImageSize( "$rootpath$usefolder/$lrow[thumbpath]" );
			echo "<img src=\"$relativepath$usefolder/" . str_replace("%2F","/",rawurlencode( $lrow['thumbpath'] )) . "\" border=\"0\" $size[3] id=\"img_$lrow[mwID]\" alt=\"$lrow[mtitle]\" />";
		}
		else {
			echo "&nbsp;";
		}
		echo "</td>\n";
		echo "<td class=\"lightback normal\">";
		if($allow_edit)
			echo "<a href=\"#\" onclick=\"return openMostWanted('$lrow[mwtype]','$lrow[mwID]');\" id=\"title_$lrow[mwID]\">$lrow[title]</a>";
		else
			echo "<u id=\"title_$lrow[mwID]\">$lrow[title]</u>";
		echo "<br /><span id=\"desc_$lrow[mwID]\">$truncated</span><br />";
		echo "<div id=\"del_$lrow[mwID]\" class=\"smaller\" style=\"color:gray;visibility:hidden\">";
		if($allow_edit) {
			echo "<a href=\"#\" onclick=\"return openMostWanted('$lrow[mwtype]','$lrow[mwID]');\">$admtext[edit]</a>";
			if($allow_delete) echo " | ";
		}
		if($allow_delete) {
			echo "<a href=\"#\" onclick=\"return removeFromMostWanted('$lrow[mwtype]','$lrow[mwID]');\">$admtext[text_delete]</a>";
		}
		echo "</div>";
		echo "</td>\n";
		echo "</tr></table>";
		echo "</div>\n";
	}
	$numrows = mysql_num_rows($result);
	mysql_free_result($result);
	echo "</div>\n";
}

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader( $admtext['mostwanted'], $flags );
?>
<script type="text/javascript" src="mostwanted.js"></script>
<script type="text/javascript" src="admin.js"></script>
<script type="text/javascript" src="selectutils.js"></script>
<script type="text/javascript">
var mwlitbox;
var tnglitbox;
var entertitle = "<?php echo $admtext['entertitle']; ?>";
var enterdesc = "<?php echo $admtext['enterdesc']; ?>";
var drag = "<?php echo $admtext['drag']; ?>";
var thumbwidth = <?php echo ($thumbmaxw+6); ?>;
var edittext = "<?php echo $admtext['edit']; ?>";
var deltext = "<?php echo $admtext['text_delete']; ?>";
var confremmw = "<?php echo $admtext['confremmw']; ?>";
var loading = "<?php echo $text['loading']; ?>";
var tree = "<?php echo $assignedtree; ?>";
</script>
</head>

<body background="../background.gif" onLoad="startMostWanted()">

<?php
	$reporttabs[0] = array(1,"reports.php",$admtext['search'],"findreport");
	$reporttabs[1] = array($allow_add,"newreport.php",$admtext['addnew'],"addreport");
	$reporttabs[2] = array(1,"whatsnewmsg.php",$admtext['whatsnew'],"whatsnew");
	$reporttabs[3] = array(1,"mostwantedlist.php",$admtext['mostwanted'],"mostwanted");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/mostwanted_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"$mostwanted_url\" target=\"_blank\" class=\"lightlink\">$admtext[test]</a>";
	$menu = doMenu($reporttabs,"mostwanted",$innermenu);
	echo displayHeadline("$admtext[reports] &gt;&gt; $admtext[mostwanted]","reports_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
<?php
	echo displayToggle("plus0",1,"personarea",$admtext['mysperson'],"");
	echo "<div id=\"personarea\">\n<br/>\n";
	showDiv('person');
	echo "<br /></div>\n";

	echo "<br />\n";

	echo displayToggle("plus1",1,"photoarea",$admtext['mysphoto'],"");
	echo "<div id=\"photoarea\">\n<br/>\n";
	showDiv('photo');
	echo "</div>\n";
?>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
