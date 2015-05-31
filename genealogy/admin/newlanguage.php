<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "language";
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

$helplang = findhelp("languages_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewlanguage], $flags );
?>
<script type="text/javascript" src="admin.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;
	if( document.form1.display.value.length == 0 ) {
		alert("<?php echo $admtext[enterlangdisplay]; ?>");
		rval = false;
	}
	else if( document.form1.folder.value.length == 0 ) {
		alert("<?php echo $admtext[enterlangfolder]; ?>");
		rval = false;
	}
	return rval;
}	
</script>
</head>

<body background="../background.gif">

<?php
	$langtabs[0] = array(1,"languages.php",$admtext['search'],"findlang");
	$langtabs[1] = array($allow_add,"newlanguage.php",$admtext[addnew],"addlanguage");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/languages_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($langtabs,"addlanguage",$innermenu);
	echo displayHeadline("$admtext[languages] &gt;&gt; $admtext[addnewlanguage]","languages_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="addlanguage.php" method="post" style="margin:0px;" name="form1" onSubmit="return validateForm();">
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[langdisplay]; ?>:</span></td><td><input type="text" name="display" size="50"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[langfolder]; ?>:</span></td><td><span class="normal"><input type="text" name="folder" size="50"></span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[charset]; ?>:</span></td><td><span class="normal"><input type="text" name="langcharset" size="30"></span></td></tr>
	</table><br/>
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext[save]; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
