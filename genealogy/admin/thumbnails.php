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

if( !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$helplang = findhelp("media_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[sortmedia], $flags );
?>
<script type="text/javascript" src="admin.js"></script>
<script language="JavaScript" type="text/javascript" src="mediautils.js"></script>
<script type="text/javascript">
function toggleAll(display) {
	toggleSection('thumbs','plus1',display);
	toggleSection('defaults','plus2',display);
	return false;
}
</script>
</head>

<body background="../background.gif">

<?php
	$mediatabs[0] = array(1,"media.php",$admtext['search'],"findmedia");
	$mediatabs[1] = array($allow_add,"newmedia.php",$admtext[addnew],"addmedia");
	$mediatabs[2] = array($allow_edit,"ordermediaform.php",$admtext[text_sort],"sortmedia");
	$mediatabs[3] = array($allow_edit && !$assignedtree,"thumbnails.php",$admtext[thumbnails],"thumbs");
	$mediatabs[4] = array($allow_add,"photoimport.php",$admtext['import'],"import");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/media_help.php#thumbs', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$menu = doMenu($mediatabs,"thumbs",$innermenu);
	echo displayHeadline("$admtext[media] &gt;&gt; $admtext[thumbnails]","photos_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<?php
if( !$assignedtree ) {
	if( function_exists( imageJpeg ) ) {
?>
<tr class="databack">
<td class="tngshadow normal">
	<?php echo displayToggle("plus1",1,"thumbs",$admtext['genthumbs'],$admtext['genthumbsdesc']); ?>

	<div id="thumbs">
	<br/>
	<form action="generatethumbs.php" style="margin:0px" method="post" onsubmit="return generateThumbs(this);">
	<input type="checkbox" name="regenerate" value="1"> <?php echo $admtext['regenerate']; ?><br/>
	<input type="checkbox" name="repath" value="1"> <?php echo $admtext['repath']; ?><br/><br/>
	<input type="submit" name="submit" value="<?php echo $admtext['generate']; ?>"> <img src="../spinner.gif" id="thumbspin" width="16" height="16" style="display:none">
	</span>
	</form>

	<div id="thumbresults" style="display:none">
	</div>

	</div>
</td>
</tr>
<?php
	}
?>

<tr class="databack">
<td class="tngshadow normal">
	<?php echo displayToggle("plus2",1,"defaults",$admtext['assigndefs'],$admtext['assigndefsdesc']); ?>

	<div id="defaults">
	<br/>
	<form action="defphotos.php" style="margin:0px" method="post" onsubmit="return assignDefaults(this);">
	<input type="checkbox" name="overwritedefs" value="1"> <?php echo $admtext['overwritedefs']; ?><br/><br/>
	<?php echo $admtext['tree'];?>: <select name="tree">
<?php
	$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $row = mysql_fetch_assoc($result) ) {
		echo "	<option value=\"$row[gedcom]\">$row[treename]</option>\n";
	}
?>
	</select><br/><br/>
	<input type="submit" name="submit" value="<?php echo $admtext['assign']; ?>"> <img src="../spinner.gif" id="defspin" width="16" height="16" style="display:none">
	</span>
	</form>

	<div id="defresults" style="display:none">
	</div>

	</div>
</td>
</tr>
<?php
}
?>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
