<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "importconfig.php");
include("adminlib.php");
$textpart = "trees";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $assignedtree )
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
else
	$wherestr = "";
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("data_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[gedexport], $flags );
?>
<SCRIPT language="JavaScript" type="text/javascript">
function toggleStuff( ) {
	if( document.form1.exportmedia.checked == true )
		new Effect.Appear('exprows',{duration:.4});
	else
		new Effect.Fade('exprows',{duration:.4});
}
</script>
</head>

<body background="../background.gif">

<?php
	$datatabs[0] = array(1,"dataimport.php",$admtext[import],"import");
	$datatabs[1] = array($allow_ged,"export.php",$admtext[export],"export");
	$datatabs[2] = array(1,"secondmenu.php",$admtext[secondarymaint],"second");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/data_help.php#export', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($datatabs,"export",$innermenu);
	echo displayHeadline("$admtext[datamaint] &gt;&gt; $admtext[gedexport]","data_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="gedcom2.php" method="post" name="form1" style="margin:0px">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext[tree]; ?>: </span></td>
			<td>
				<select name="tree">
<?php
	$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
	while( $treerow = mysql_fetch_assoc($treeresult) ) {
		echo "	<option value=\"$treerow[gedcom]\"";
		if( $treerow[gedcom] == $tree ) echo " selected";
		echo ">$treerow[treename]</option>\n";
	}
	mysql_free_result($treeresult);
?>
				</select>
			</td>
		</tr>
<?php
	if($allow_lds)
		echo "<tr><td valign=\"top\" colspan=\"2\"><span class=\"normal\"><input type=\"checkbox\" name=\"templeready\" value=\"1\">TempleReady</span></td></tr>\n";
?>
		<tr><td valign="top" colspan="2"><span class="normal"><input type="checkbox" name="exportmedia" value="1" onClick="toggleStuff();"><?php echo $admtext[exportmedia]; ?></span></td></tr>
	</table>
	<table style="display:none" id="exprows">
		<tr><td colspan="2"><span class="normal"><br /><?php echo $admtext[exppaths]; ?>:</span></td></tr>
<?php
	foreach( $mediatypes as $mediatype ) {
		$msgID = $mediatype[ID];
		switch($msgID) {
			case "photos":
				$value = strtok($locimppath['photos'],",");
				break;
			case "histories":
				$value = strtok($locimppath['histories'],",");
				break;
			case "documents":
				$value = strtok($locimppath['documents'],",");
				break;
			case "headstones":
				$value = strtok($locimppath['headstones'],",");
				break;
			default:
				$value = strtok($locimppath['other'],",");
				break;
		}
		echo "<tr><td><span class=\"normal\">" . $mediatype['display'] . ":</span></td><td><input type=\"text\" value=\"$value\"name=\"exp_path_$msgID\" class=\"verylongfield\"></td></tr>\n";
	}
?>
	</table><br/>
	<input type="submit" name="submit" value="<?php echo $admtext['export']; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
