<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "pedconfig.php");
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
}

$helplang = findhelp("pedconfig_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[modifypedsettings], $flags );
?>
<script language="JavaScript" src="PopupWindow.js"></script>
<script language="JavaScript" src="AnchorPosition.js"></script>
<script language="JavaScript" src="ColorPicker2.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
var cp = new ColorPicker('window');

function toggleAll(display) {
	toggleSection('ped','plus0',display);
	toggleSection('desc','plus1',display);
	toggleSection('rel','plus2',display);
	toggleSection('peddesc','plus3',display);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$setuptabs[0] = array(1,"setup.php",$admtext['configuration'],"configuration");
	$setuptabs[1] = array(1,"diagnostics.php",$admtext['diagnostics'],"diagnostics");
	$setuptabs[2] = array(1,"setup.php?sub=tablecreation",$admtext['tablecreation'],"tablecreation");
	$setuptabs[3] = array(1,"#",$admtext['pedconfigsettings'],"ped");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/pedconfig_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$menu = doMenu($setuptabs,"ped",$innermenu);
	echo displayHeadline("$admtext[setup] &gt;&gt; $admtext[configuration] &gt;&gt; $admtext[pedconfigsettings]","setup_icon.gif",$menu,"");
?>

<form action="updatepedconfig.php" method="post" name="form1" style="margin:0px">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus0",0,"ped",$admtext['pedchart'],""); ?>

	<div id="ped" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext[usepopups]; ?>:</span></td>
			<td>
				<select name="usepopups">
					<option value="1"<?php if( $pedigree[usepopups] == 1 ) echo " selected"; ?>><?php echo $admtext[pedstandard]; ?></option>
					<option value="0"<?php if( !$pedigree[usepopups] ) echo " selected"; ?>><?php echo $admtext[pedbox]; ?></option>
					<option value="-1"<?php if($pedigree[usepopups] == -1 ) echo " selected"; ?>><?php echo $admtext[pedtextonly]; ?></option>
					<option value="2"<?php if($pedigree[usepopups] == 2 ) echo " selected"; ?>><?php echo $admtext[pedcompact]; ?></option>
					<option value="3"<?php if($pedigree[usepopups] == 3 ) echo " selected"; ?>><?php echo $admtext[ahnentafel]; ?></option>
				</select>
			</td>
		</tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[maxpedgens]; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[maxgen]"; ?>" name="maxgen" size="5"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[initgens]; ?>:</span></td><td colspan="4"><input type="text" value="<?php echo $pedigree[initpedgens]; ?>" name="initpedgens" size="5"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[popupspouses]; ?>:</span></td><td><span class="normal"><input type="radio" name="popupspouses" value="1" <?php if( $pedigree[popupspouses] ) { echo "checked"; } ?>> <?php echo $admtext[yes]; ?> <input type="radio" name="popupspouses" value="0" <?php if( !$pedigree[popupspouses] ) { echo "checked"; } ?>> <?php echo $admtext[no]; ?></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[popupkids]; ?>:</span></td><td><span class="normal"><input type="radio" name="popupkids" value="1" <?php if( $pedigree[popupkids]) { echo "checked"; } ?>> <?php echo $admtext[yes]; ?> <input type="radio" name="popupkids" value="0" <?php if( !$pedigree[popupkids] ) { echo "checked"; } ?>> <?php echo $admtext[no]; ?></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[popupchartlinks]; ?>:</span></td><td><span class="normal"><input type="radio" name="popupchartlinks" value="1" <?php if( $pedigree[popupchartlinks] ) { echo "checked"; } ?>> <?php echo $admtext[yes]; ?> <input type="radio" name="popupchartlinks" value="0" <?php if( !$pedigree[popupchartlinks] ) { echo "checked"; } ?>> <?php echo $admtext[no]; ?></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[hideempty]; ?>:</span></td><td><span class="normal"><input type="radio" name="hideempty" value="1" <?php if( $pedigree[hideempty] ) { echo "checked"; } ?>> <?php echo $admtext[yes]; ?> <input type="radio" name="hideempty" value="0" <?php if( !$pedigree[hideempty] ) { echo "checked"; } ?>> <?php echo $admtext[no]; ?></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[boxwidth]; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[boxwidth]"; ?>" name="boxwidth" size="10"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[boxheight]; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[boxheight]"; ?>" name="boxheight" size="10"></td></tr>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext[boxalign]; ?>:</span></td>
			<td>
				<select name="boxalign">
					<option value="center"<?php if( $pedigree[boxalign] == "center" ) echo " selected"; ?>><?php echo $admtext[center]; ?></option>
					<option value="left"<?php if( $pedigree[boxalign] == "left" ) echo " selected"; ?>><?php echo $admtext[left]; ?></option>
					<option value="right"<?php if( $pedigree[boxalign] == "right" ) echo " selected"; ?>><?php echo $admtext[right]; ?></option>
				</select>
			</td>
		</tr>
   		<tr><td valign="top"><span class="normal"><?php echo $admtext[boxheightshift]; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[boxheightshift]"; ?>" name="boxheightshift" size="10"></td></tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus1",0,"desc",$admtext['descchart'],""); ?>

	<div id="desc" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext[usepopups]; ?>:</span></td>
			<td>
				<select name="defdesc">
					<option value="2"<?php if( $pedigree[defdesc] == 2 ) echo " selected"; ?>><?php echo $admtext[stdformat]; ?></option>
					<option value="0"<?php if( !$pedigree[defdesc] ) echo " selected"; ?>><?php echo $admtext[pedtextonly]; ?></option>
					<option value="3"<?php if($pedigree[defdesc] == 3 ) echo " selected"; ?>><?php echo $admtext[pedcompact]; ?></option>
					<option value="1"<?php if( $pedigree[defdesc] == 1 ) echo " selected"; ?>><?php echo $admtext[regformat]; ?></option>
				</select>
			</td>
		</tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[maxpedgens]; ?>:</span></td><td colspan="4"><input type="text" value="<?php echo $pedigree[maxdesc]; ?>" name="maxdesc" size="5"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[initgens]; ?>:</span></td><td colspan="4"><input type="text" value="<?php echo $pedigree[initdescgens]; ?>" name="initdescgens" size="5"></td></tr>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext[stdesc]; ?>:</span></td>
			<td>
				<select name="stdesc">
					<option value="0"<?php if( !$pedigree[stdesc] ) echo " selected"; ?>><?php echo $admtext[stexpand]; ?></option>
					<option value="1"<?php if( $pedigree[stdesc] == 1 ) echo " selected"; ?>><?php echo $admtext[stcollapse]; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext[regnotes]; ?>:</span></td>
			<td>
				<select name="regnotes">
					<option value="0"<?php if( !$pedigree[regnotes] ) echo " selected"; ?>><?php echo $admtext[no]; ?></option>
					<option value="1"<?php if( $pedigree[regnotes] ) echo " selected"; ?>><?php echo $admtext[yes]; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext[regnosp]; ?>:</span></td>
			<td>
				<select name="regnosp">
					<option value="0"<?php if( !$pedigree[regnosp] ) echo " selected"; ?>><?php echo $admtext[chshow]; ?></option>
					<option value="1"<?php if( $pedigree[regnosp] ) echo " selected"; ?>><?php echo $admtext[chifsp]; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus2",0,"rel",$admtext['relchart'],""); ?>

	<div id="rel" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext[maxpedgens]; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[maxupgen]"; ?>" name="maxupgen" size="5"></td></tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus3",0,"peddesc",$admtext['pedanddesc'],""); ?>

	<div id="peddesc" style="display:none">
	<table>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td valign="top">
				<table>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['leftindent']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[leftindent]"; ?>" name="leftindent" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['boxnamesize']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[boxnamesize]"; ?>" name="boxnamesize" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['boxdatessize']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[boxdatessize]"; ?>" name="boxdatessize" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['boxcolor']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[boxcolor]"; ?>" name="boxcolor" id="boxcolor" size="8"> <A HREF="#" onClick="cp.select(document.form1.boxcolor,'pick1');return false;" NAME="pick1" ID="pick1"><img src="tng_colorpicker.gif" alt="" width="19" height="17" border="0"></A></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['colorshift']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[colorshift]"; ?>" name="colorshift" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['emptycolor']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[emptycolor]"; ?>" name="emptycolor" id="emptycolor" size="8"> <A HREF="#" onClick="cp.select(document.form1.emptycolor,'pick2');return false;" NAME="pick2" ID="pick2"><img src="tng_colorpicker.gif" alt="" width="19" height="17" border="0"></A></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['bordercolor']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[bordercolor]"; ?>" name="bordercolor" id="bordercolor" size="8"> <A HREF="#" onClick="cp.select(document.form1.bordercolor,'pick3');return false;" NAME="pick3" ID="pick3"><img src="tng_colorpicker.gif" alt="" width="19" height="17" border="0"></A></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['shadowcolor']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[shadowcolor]"; ?>" name="shadowcolor" id="shadowcolor" size="8"> <A HREF="#" onClick="cp.select(document.form1.shadowcolor,'pick4');return false;" NAME="pick4" ID="pick4"><img src="tng_colorpicker.gif" alt="" width="19" height="17" border="0"></A></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['shadowoffset']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[shadowoffset]"; ?>" name="shadowoffset" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['boxHsep']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[boxHsep]"; ?>" name="boxHsep" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['boxVsep']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[boxVsep]"; ?>" name="boxVsep" size="10"></td></tr>
		        </table>
			</td>
			<td width="20">&nbsp;</td>
			<td valign="top">
				<table>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['linewidth']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[linewidth]"; ?>" name="linewidth" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['borderwidth']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[borderwidth]"; ?>" name="borderwidth" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['popupcolor']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[popupcolor]"; ?>" name="popupcolor" id="popupcolor" size="8"> <A HREF="#" onClick="cp.select(document.form1.popupcolor,'pick5');return false;" NAME="pick5" ID="pick5"><img src="tng_colorpicker.gif" alt="" width="19" height="17" border="0"></A></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['popupinfosize']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[popupinfosize]"; ?>" name="popupinfosize" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['popuptimer']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[popuptimer]"; ?>" name="popuptimer" size="10"></td></tr>
					<tr>
						<td valign="top"><span class="normal"><?php echo $admtext['pedevent']; ?>:</span></td>
						<td>
							<select name="pedevent">
								<option value="down"<?php if( $pedigree['event'] == "down" ) echo " selected"; ?>><?php echo $admtext['mousedown']; ?></option>
								<option value="over"<?php if( $pedigree['event'] == "over" ) echo " selected"; ?>><?php echo $admtext['mouseover']; ?></option>
							</select>
						</td>
					</tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['puboxwidth']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[puboxwidth]"; ?>" name="puboxwidth" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['puboxheight']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[puboxheight]"; ?>" name="puboxheight" size="10"></td></tr>
					<tr>
						<td valign="top"><span class="normal"><?php echo $admtext['puboxalign']; ?>:</span></td>
						<td>
							<select name="puboxalign">
								<option value="center"<?php if( $pedigree['puboxalign'] == "center" ) echo " selected"; ?>><?php echo $admtext[center]; ?></option>
								<option value="left"<?php if( $pedigree['puboxalign'] == "left" ) echo " selected"; ?>><?php echo $admtext[left]; ?></option>
								<option value="right"<?php if( $pedigree['puboxalign'] == "right" ) echo " selected"; ?>><?php echo $admtext[right]; ?></option>
							</select>
						</td>
					</tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['puboxheightshift']; ?>:</span></td><td><input type="text" value="<?php echo "$pedigree[puboxheightshift]"; ?>" name="puboxheightshift" size="10"></td></tr>
					<tr><td valign="top"><span class="normal"><?php echo $admtext['inclphotos']; ?>:</span></td><td><span class="normal"><input type="radio" name="inclphotos" value="1" <?php if( $pedigree[popupchartlinks] ) { echo "checked"; } ?>> <?php echo $admtext[yes]; ?> <input type="radio" name="inclphotos" value="0" <?php if( !$pedigree[inclphotos] ) { echo "checked"; } ?>> <?php echo $admtext[no]; ?></span></td></tr>
		        </table>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
</td>
</tr>

</table>
</form>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
