<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "mapconfig.php");
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

$helplang = findhelp("mapconfig_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[modifymapsettings], $flags );
?>
<script type="text/javascript">
function validateWidth(width) {
	if(width.indexOf('%') >= 0)
		return Math.min(parseInt(width),100) + '%';
	else
		return parseInt(width) + 'px';
}

function validateHeight(height) {
	return parseInt(height) + 'px';
}

function validateLatLong(coord) {
	var keep = "1234567890.-";     // Characters stripped out
	var i;
	var returnString = "";
	for (i = 0; i < coord.length; i++) {  // Search through string and append to unfiltered values to returnString.
		var c = coord.charAt(i);
		if(keep.indexOf(c) != -1)
			returnString += c;
		else
			break;
	}
	return returnString
}
</script>
</head>

<body background="../background.gif">

<?php
	$setuptabs[0] = array(1,"setup.php",$admtext['configuration'],"configuration");
	$setuptabs[1] = array(1,"diagnostics.php",$admtext['diagnostics'],"diagnostics");
	$setuptabs[2] = array(1,"setup.php?sub=tablecreation",$admtext['tablecreation'],"tablecreation");
	$setuptabs[3] = array(1,"#",$admtext['mapconfigsettings'],"map");
	$innermenu .= "<a href=\"javascript:newwindow=window.open('../$helplang/mapconfig_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($setuptabs,"map",$innermenu);
	echo displayHeadline("$admtext[setup] &gt;&gt; $admtext[configuration] &gt;&gt; $admtext[mapconfigsettings]","setup_icon.gif",$menu,"");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="updatemapconfig.php" method="post" name="form1">
	<table>
		<tr><td><span class="normal"><?php echo "$admtext[mapkey]"; ?>:</span></td><td><input type="text" value="<?php echo $map[key]; ?>" name="mapkey" size="80"></td></tr>
		<tr>
			<td><span class="normal"><?php echo "$admtext[maptype]"; ?>:</span></td>
			<td>
				<select name="maptype">
					<option value="G_NORMAL_MAP"<?php if( $map[type] == "G_NORMAL_MAP" ) echo " selected"; ?>><?php echo $admtext[mapnormal]; ?></option>
					<option value="G_HYBRID_MAP"<?php if( $map[type] == "G_HYBRID_MAP" ) echo " selected"; ?>><?php echo $admtext[maphybrid]; ?></option>
					<option value="G_SATELLITE_MAP"<?php if( $map[type] == "G_SATELLITE_MAP" ) echo " selected"; ?>><?php echo $admtext[mapsatellite]; ?></option>
				</select>
			</td>
		</tr>
		<tr><td><span class="normal"><?php echo $admtext['mapstlat']; ?>:</span></td><td><input type="text" value="<?php echo $map['stlat']; ?>" name="mapstlat" onblur="this.value = validateLatLong(this.value)"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['mapstlong']; ?>:</span></td><td><input type="text" value="<?php echo $map['stlong']; ?>" name="mapstlong" onblur="this.value = validateLatLong(this.value)"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['mapstzm']; ?>:</span></td>
			<td>
				<select name="mapstzoom">
				<?php
					for($i = 0; $i <= 17; $i++) {
						echo "<option value=\"$i\"";
						if( $map['stzoom'] == $i ) echo " selected";
						echo ">$i</option>\n";
					}
				?>
				</select>
			</td>
		</tr>

		<tr><td valign="top" colspan="2"><span class="normal"><br /><?php echo "$admtext[mapdimsind]"; ?>:</span></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['mapwidth']; ?>:</span></td><td><input type="text" value="<?php echo $map['indw']; ?>" name="mapindw" onblur="this.value = validateWidth(this.value)"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['mapheight']; ?>:</span></td><td><input type="text" value="<?php echo $map['indh']; ?>" name="mapindh" onblur="this.value = validateHeight(this.value)"></td></tr>

		<tr><td valign="top" colspan="2"><span class="normal"><br /><?php echo "$admtext[mapdimshst]"; ?>:</span></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['mapwidth']; ?>:</span></td><td><input type="text" value="<?php echo $map['hstw']; ?>" name="maphstw" onblur="this.value = validateWidth(this.value)"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['mapheight']; ?>:</span></td><td><input type="text" value="<?php echo $map['hsth']; ?>" name="maphsth" onblur="this.value = validateHeight(this.value)"></td></tr>

		<tr><td valign="top" colspan="2"><span class="normal"><br /><?php echo "$admtext[mapdimsadm]"; ?>:</span></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['mapwidth']; ?>:</span></td><td><input type="text" value="<?php echo $map['admw']; ?>" name="mapadmw" onblur="this.value = validateWidth(this.value)"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['mapheight']; ?>:</span></td><td><input type="text" value="<?php echo $map['admh']; ?>" name="mapadmh" onblur="this.value = validateHeight(this.value)"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['startoff']; ?>:</span></td>
			<td>
				<select name="startoff">
					<option value="1"<?php if( $map[startoff] ) echo " selected"; ?>><?php echo $admtext[yes]; ?></option>
					<option value="0"<?php if( !$map[startoff] ) echo " selected"; ?>><?php echo $admtext[no]; ?></option>
				</select>
			</td>
		</tr>

		<tr><td valign="top" colspan="2"><br /></td></tr>
		<tr><td><span class="normal"><?php echo "$admtext[conslpins]"; ?>:</span></td>
			<td>
				<select name="showallpins">
					<option value="0"<?php if( !$map[showallpins] ) echo " selected"; ?>><?php echo $admtext[yes]; ?></option>
					<option value="1"<?php if( $map[showallpins] ) echo " selected"; ?>><?php echo $admtext[no]; ?></option>
				</select>
			</td>
		</tr>
	</table><br/>
	<input type="hidden" name="pinplacelevel0" value="<?php echo $pinplacelevel0; ?>">
	<input type="hidden" name="pinplacelevel1" value="<?php echo $pinplacelevel1; ?>">
	<input type="hidden" name="pinplacelevel2" value="<?php echo $pinplacelevel2; ?>">
	<input type="hidden" name="pinplacelevel3" value="<?php echo $pinplacelevel3; ?>">
	<input type="hidden" name="pinplacelevel4" value="<?php echo $pinplacelevel4; ?>">
	<input type="hidden" name="pinplacelevel5" value="<?php echo $pinplacelevel5; ?>">
	<input type="hidden" name="pinplacelevel6" value="<?php echo $pinplacelevel6; ?>">
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext[save]; ?>">
	</form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
