<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "mapconfig.php");
include("adminlib.php");
$textpart = "findplace";
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

if( $assignedtree )
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
else
	$wherestr = "";
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$helplang = findhelp("places_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewplace], $flags );

if( $map[key] )
	echo "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=$map[key]\" language=\"Javascript\" type=\"text/javascript\"></script>\n";
?>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;
	if( document.form1.place.value.length == 0 ) {
		alert("<?php echo $admtext[enterplace]; ?>");
		rval = false;
	}
	return rval;
}	
</script>
<?php
	if($map[key])
		include "../googlemaps/googlemaplib2.php";
?>
</head>

<body<?php if($map['key']) { if(!$map['startoff']) echo " onload=\"divbox('mapcontainer');\""; echo " onunload=\"GUnload();\""; } ?> background="../background.gif">

<?php
	$placetabs[0] = array(1,"places.php",$admtext['search'],"findplace");
	$placetabs[1] = array($allow_add,"newplace.php",$admtext['addnew'],"addplace");
	$placetabs[2] = array($allow_edit && $allow_delete,"mergeplaces.php",$admtext['merge'],"merge");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/places_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($placetabs,"addplace",$innermenu);
	echo displayHeadline("$admtext[places] &gt;&gt; $admtext[addnewplace]","places_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="addplace.php" method="post" style="margin:0px" name="form1" onSubmit="return validateForm();">
	<table width="100%">
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['tree']; ?>:</span></td>
		<td width="90%">
			<select name="tree">
<?php
while( $row = mysql_fetch_assoc($result) ) {
	echo "		<option value=\"$row[gedcom]\">$row[treename]</option>\n";
}
?>
			</select>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['place']; ?>:</span></td><td><input type="text" name="place" size="50"></td></tr>
<?php
	if( $map[key] ) {
?>
	<tr>
		<td colspan="2">
		<div style="padding:10px">
<?php
// draw the map here
		include "../googlemaps/googlemapdrawthemap.php";
?>
		</div>
		</td>
	</tr>
<?php
	}
?>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['latitude']; ?>:</span></td><td><input type="text" name="latitude" size="20" id="latbox"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['longitude']; ?>:</span></td><td><input type="text" name="longitude" size="20" id="lonbox"></td></tr>
<?php
	if( $map[key] ) {
?>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['zoom']; ?>:</span></td>
		<td>
			<input type="text" name="zoom" size="20" id="zoombox">
		</td>
	</tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['placelevel']; ?>:</span></td>
		<td>
			<select name="placelevel">
				<option value=""></option>
<?php
				for($i = 1; $i < 7; $i++) {
					echo "<option value=\"$i\">" . $admtext['level' . $i] . "</option>\n";
				}
?>
			</select>
		</td>
	</tr>
<?php
	}
?>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['notes']; ?>:</span></td><td><textarea wrap cols="50" rows="5" name="notes"></textarea></td></tr>
	</table><br/>&nbsp;
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
