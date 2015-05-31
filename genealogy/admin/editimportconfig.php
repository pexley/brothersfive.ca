<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "importconfig.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);

if( $link ) {
	include("checklogin.php");
	include("../version.php");

	if( $assignedtree || !$allow_edit ) {
		$message = "$admtext[norights]";
		header( "Location: login.php?message=" . urlencode($message) );
		exit;
	}
	
	$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
	$result = @mysql_query($query);
}
else
	$result = false;

if( !$tngimpcfg[maxlivingage] ) $tngimpcfg[maxlivingage] = "110";

//for upgrading to 6
if( $localphotopathdisplay && !$locimppath[photos] ) $locimppath[photos] = $localphotopathdisplay;
if( $localdocpathdisplay && !$locimppath[histories] ) $locimppath[histories] = $localdocpathdisplay;

$helplang = findhelp("importconfig_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[modifyimportsettings], $flags );
?>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$setuptabs[0] = array(1,"setup.php",$admtext['configuration'],"configuration");
	$setuptabs[1] = array(1,"diagnostics.php",$admtext['diagnostics'],"diagnostics");
	$setuptabs[2] = array(1,"setup.php?sub=tablecreation",$admtext['tablecreation'],"tablecreation");
	$setuptabs[3] = array(1,"#",$admtext['importconfigsettings'],"import");
	$innermenu .= "<a href=\"javascript:newwindow=window.open('../$helplang/importconfig_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($setuptabs,"import",$innermenu);
	echo displayHeadline("$admtext[setup] &gt;&gt; $admtext[configuration] &gt;&gt; $admtext[importconfigsettings]","setup_icon.gif",$menu,"");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="updateimportconfig.php" method="post" name="form1" style="margin:0px">
	<table>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['gedpath']; ?>:</span></td><td valign="top"><input type="text" value="<?php echo $gedpath; ?>" name="gedpath" size="50">
			<input type="button" value="<?php echo $admtext['makefolder']; ?>" onclick="makeFolder('gedcom',document.form1.gedpath.value);"> <span id="msg_gedcom"></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['saveimportstate']; ?>:</span></td><td valign="top"><span class="normal"><input type="checkbox" name="saveimport" value="yes" <?php if( $saveimport ) { echo "checked"; } ?>> <?php echo $admtext[allowresume]; ?></span></td></tr>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext['defimpopt']; ?>:</span></td>
			<td valign="top"><span class="normal">
				<select name="defimpopt">
					<option value="1"<?php if( $tngimpcfg['defimpopt'] == 1 ) echo " selected"; ?>><?php echo $admtext['allcurrentdata']; ?></option>
					<option value="0"<?php if( !$tngimpcfg['defimpopt'] ) echo " selected"; ?>><?php echo $admtext['matchingonly']; ?></option>
					<option value="2"<?php if( $tngimpcfg['defimpopt'] == 2 ) echo " selected"; ?>><?php echo $admtext['donotreplace']; ?></option>
					<option value="3"<?php if( $tngimpcfg['defimpopt'] == 3 ) echo " selected"; ?>><?php echo $admtext['appendall']; ?></option>
				</select>
				</span>
			</td>
		</tr>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext['blankchangedt']; ?>:</span></td>
			<td valign="top"><span class="normal">
				<select name="blankchangedt">
					<option value="0"<?php if( !$tngimpcfg['chdate'] ) echo " selected"; ?>><?php echo $admtext['usetoday']; ?></option>
					<option value="1"<?php if( $tngimpcfg['chdate'] ) echo " selected"; ?>><?php echo $admtext['useblank']; ?></option>
				</select>
				</span>
			</td>
		</tr>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext[nobirthdate]; ?>:</span></td>
			<td valign="top"><span class="normal">
				<select name="livingreqbirth">
					<option value="0"<?php if( !$tngimpcfg['livingreqbirth'] ) echo " selected"; ?>><?php echo $admtext['persdead']; ?></option>
					<option value="1"<?php if( $tngimpcfg['livingreqbirth'] ) echo " selected"; ?>><?php echo $admtext['persliving']; ?></option>
				</select>
				</span>
			</td>
		</tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['nodeathdate']; ?>:</span></td><td valign="top"><input type="text" value="<?php echo $tngimpcfg['maxlivingage']; ?>" name="maxlivingage" size="5"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['embeddedmedia']; ?>:</span></td><td valign="top"><span class="normal"><input type="checkbox" name="assignnames" value="yes" <?php if( $assignnames ) { echo "checked"; } ?>> <?php echo $admtext['assignnames']; ?></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['localphotopath']; ?>*:</span></td><td valign="top"><input type="text" value="<?php echo $locimppath['photos']; ?>" name="localphotopathdisplay" class="verylongfield"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['localdocpath']; ?>*:</span></td><td valign="top"><input type="text" value="<?php echo $locimppath['histories']; ?>" name="localhistorypathdisplay" class="verylongfield"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['localdocumentpath']; ?>*:</span></td><td valign="top"><input type="text" value="<?php echo $locimppath['documents']; ?>" name="localdocumentpathdisplay" class="verylongfield"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['localhspath']; ?>*:</span></td><td valign="top"><input type="text" value="<?php echo $locimppath['headstones']; ?>" name="localhspathdisplay" class="verylongfield"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['localotherpath']; ?>*:</span></td><td valign="top"><input type="text" value="<?php echo $locimppath['other']; ?>" name="localotherpathdisplay" class="verylongfield"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['nopathmatch']; ?>:</span></td><td colspan="4"><span class="normal"><input type="radio" name="wholepath" value="1" <?php if( $wholepath ) { echo "checked"; } ?>> <?php echo $admtext['wholepath']; ?> <input type="radio" name="wholepath" value="0" <?php if( !$wholepath ) { echo "checked"; } ?>> <?php echo $admtext['justname']; ?></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['privnote']; ?>:</span></td><td valign="top"><input type="text" value="<?php echo $tngimpcfg['privnote']; ?>" name="privnote" size="5"></td></tr>
	</table><br/>&nbsp;
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>">
	</form>
	<p><span class="normal">*<?php echo $admtext['commas']; ?></span></p>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
