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

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$helplang = findhelp("albums_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewalbum], $flags );
?>
<SCRIPT album="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;
	if( document.form1.albumname.value.length == 0 ) {
		alert("<?php echo $admtext[enteralbumname]; ?>");
		rval = false;
	}
	return rval;
}	
</script>
<script language="JavaScript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$albumtabs[0] = array(1,"albums.php",$admtext['search'],"findalbum");
	$albumtabs[1] = array($allow_add,"newalbum.php",$admtext[addnew],"addalbum");
	$albumtabs[2] = array($allow_edit,"orderalbumform.php",$admtext[text_sort],"sortalbums");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/albums_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($albumtabs,"addalbum", $innermenu);
	echo displayHeadline("$admtext[albums] &gt;&gt; $admtext[addnewalbum]","albums_icon.gif",$menu,$message);
?>

<form action="addalbum.php" method="post" style="margin:0px" name="form1" onSubmit="return validateForm();">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus0",1,"details",$admtext['existingalbuminfo'],$admtext['infosubt']); ?>

	<div id="details" style="margin-top:12px">
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['albumname']; ?>:</span></td><td><input type="text" name="albumname" size="50"></td></tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['description']; ?>:</span></td>
		<td><textarea cols="60" rows="3" name="description"></textarea></td>
	</tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['keywords']; ?>:</span></td>
		<td><textarea cols="60" rows="3" name="keywords"></textarea></td>
	</tr>
	</table>
	</div>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<p class="normal"><strong><?php echo $admtext['alblater']; ?></strong></p>
	<input type="submit" name="saveit" accesskey="a" value="<?php echo $admtext['savecont']; ?>">
</td>
</tr>
</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
