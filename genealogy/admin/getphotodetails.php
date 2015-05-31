<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "reports";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$query = "SELECT thumbpath,	usecollfolder, description, notes, mediatypeID FROM $media_table WHERE mediaID = \"$mediaID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);

header("Content-type:text/html; charset=" . $session_charset);
?>

<table width="95%" cellpadding="5" cellspacing="1" style="padding-top:6px">
	<tr>
		<td class="lightback" id="mwthumb" style="width:<?php echo ($thumbmaxw+6); ?>px;height:<?php echo ($thumbmaxh+6); ?>px;text-align:center;">
<?php
		initMediaTypes();
		$lmediatypeID = $row['mediatypeID'];
		$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$lmediatypeID] : $mediapath;
		if( substr( $usefolder, 0, 1 ) != "/" )
			$relativepath = $cms['support'] ? "../../../" : "../";
		else
			$relativepath = "";
		if( $row['thumbpath'] && file_exists( "$rootpath$usefolder/$row[thumbpath]" ) ) {
			$photoinfo = @GetImageSize( "$rootpath$usefolder/$row[thumbpath]" );
			if( $photoinfo[1] < 50 ) {
				$photohtouse = $photoinfo[1];
				$photowtouse = $photoinfo[0];
			}
			else {
				$photohtouse = 50;
				$photowtouse = intval( 50 * $photoinfo[0] / $photoinfo[1] ) ;
			}
			echo "<img src=\"$relativepath$usefolder/" . str_replace("%2F","/",rawurlencode( $row['thumbpath'] )) . "\" border=\"0\" width=\"$photowtouse\" height=\"$photohtouse\" id=\"img_$ID\" alt=\"$row[mtitle]\" />";
		}
		else {
			echo "&nbsp;";
		}
		$row['notes'] = xmlcharacters($row['notes']);
		$truncated = substr($row['notes'],0,90);
		$truncated = strlen($row['notes']) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $row['notes'];
?>
		</td>
		<td class="lightback normal" id="mwdetails"><?php echo "<u>" . xmlcharacters($row['description']) . "</u><br />" . $truncated; ?>&nbsp;</td>
	</tr>
</table>
