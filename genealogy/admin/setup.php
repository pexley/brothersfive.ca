<?php
include("../subroot.php");
if(!file_exists($subroot . "config.php"))
	$subroot = $_GET['sr'];
include($subroot . "config.php");
include("adminlib.php");
if($subroot != $_GET['sr'])
	$subroot = $_GET['sr'];
$textpart = "setup";
include("../getlang.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
if( $link ) {
	include("checklogin.php");
	if( $assignedtree ) {
		$message = "You do not have rights to view this page";  //this message cannot be translated dynamically because language file is not loaded yet.
		header( "Location: login.php?message=" . urlencode($message) );
		exit;
	}
}
include("../$mylanguage/admintext.php");
include("../version.php");

$error_reporting = ((int) ini_get('error_reporting')) & E_NOTICE;

$helplang = findhelp("setup_help.php");

if( !$sub ) $sub = "configuration";
$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[setup], $flags );
?>
</head>

<body background="../background.gif">

<?php
	$setuptabs[0] = array(1,"setup.php",$admtext[configuration],"configuration");
	$setuptabs[1] = array(1,"diagnostics.php",$admtext[diagnostics],"diagnostics");
	$setuptabs[2] = array(1,"setup.php?sub=tablecreation",$admtext[tablecreation],"tablecreation");
	$internallink = $sub == "configuration" ? "config" : "tables";
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/setup_help.php#$internallink', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($setuptabs,$sub,$innermenu);
	echo displayHeadline("$admtext[setup] &gt;&gt; " . $admtext[$sub],"setup_icon.gif",$menu,"");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
<?php
	if( $sub == "configuration" ) {
?>
	<span class="normal"><i><?php echo $admtext['entersysvars']; ?></i></span><br/><br/>
	<form action="">
		<input type="button" value="<?php echo $admtext['configsettings']; ?>" onClick="window.location.href = 'editconfig.php';">&nbsp;
		<input type="button" value="<?php echo $admtext['pedconfigsettings']; ?>" onClick="window.location.href = 'editpedconfig.php';">&nbsp;
		<input type="button" value="<?php echo $admtext['logconfigsettings']; ?>" onClick="window.location.href = 'editlogconfig.php';">&nbsp;
		<input type="button" value="<?php echo $admtext['importconfigsettings']; ?>" onClick="window.location.href = 'editimportconfig.php';">&nbsp;
		<input type="button" value="<?php echo $admtext['mapconfigsettings']; ?>" onClick="window.location.href = 'editmapconfig.php';">
	</form>
	<p class="normal"><em><?php echo $admtext[custvars]; ?></em></p>
<?php
	}
	elseif( $sub == "tablecreation" ) {
?>
	<span class="normal"><i><?php echo $admtext['createdbtables']; ?></i></span><br/>

	<p class="normal"><em><?php echo $admtext['tcwarning']; ?></em></p>
	<form action=""><input type="button" value="<?php echo $admtext[createtables]; ?>" onClick="if( confirm( '<?php echo $admtext[conftabledelete]; ?>' ) ) window.location.href = 'tablecreate.php';"></form>
<?php
	}
?>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
