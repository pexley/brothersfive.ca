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

session_register('tng_search_places');
$tng_search_places = $_SESSION[tng_search_places];

$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc( $result );
mysql_free_result($result);


$query = "SELECT * FROM $places_table WHERE ID = \"$ID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$orgplace = $row[place];
$row[place] = ereg_replace("\"", "&#34;",$row[place]);

$helplang = findhelp("places_help.php");
$placesearch_url = getURL( "placesearch", 1 );

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[modifyplace], $flags );

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
	$placetabs[3] = array($allow_edit,"#",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/places_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"$placesearch_url" . "psearch=" . urlencode($orgplace) . "\" target=\"_blank\" class=\"lightlink\">$admtext[test]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"newmedia.php?personID=$row[place]&amp;tree=$tree&amp;linktype=L\" class=\"lightlink\">$admtext[addmedia]</a>";
	$menu = doMenu($placetabs,"edit",$innermenu);
	echo displayHeadline("$admtext[places] &gt;&gt; $admtext[modifyplace]","places_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="updateplace.php" style="margin:0px" method="post" name="form1" id="form1" onSubmit="return validateForm();">
	<table width="100%">
	<tr><td valign="top"><span class="normal"><?php echo $admtext['tree']; ?>:</span></td><td><span class="normal"><?php echo $treerow['treename']; ?></span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['place']; ?>:</span></td><td><input type="text" value="<?php echo $row['place']; ?>" name="place" size="50"></td></tr>
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
	<tr><td valign="top"><span class="normal"><?php echo $admtext['latitude']; ?>:</span></td><td><input type="text" name="latitude" value="<?php echo $row['latitude']; ?>" size="20" id="latbox"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['longitude']; ?>:</span></td><td><input type="text" name="longitude" value="<?php echo $row['longitude']; ?>" size="20" id="lonbox"></td></tr>
<?php
	if( $map[key] ) {
?>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['zoom']; ?>:</span></td>
		<td>
			<input type="text" name="zoom" value="<?php echo $row['zoom']; ?>" size="20" id="zoombox">
		</td>
	</tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['placelevel']; ?>:</span></td>
		<td>
			<select name="placelevel">
				<option value=""></option>
<?php
				for($i = 1; $i < 7; $i++) {
					echo "<option value=\"$i\"";
					if($i == $row[placelevel]) echo " selected";
					echo ">" . $admtext['level' . $i] . "</option>\n";
				}
?>
			</select>
		</td>
	</tr>
<?php
	}
?>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['notes']; ?>:</span></td><td><textarea wrap cols="50" rows="5" name="notes"><?php echo $row['notes']; ?></textarea></td></tr>
<?php
	if( !$assignedbranch ) {
?>
	<tr><td valign="top" colspan="2"><span class="normal"><input type="checkbox" name="propagate" value="1" checked> <?php echo $admtext['propagate']; ?>:</span></td></tr>
<?php
	}
?>
	<tr><td valign="top" colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
		<span class="normal">
<?php
	echo "$admtext[onsave]:<br/>";
	echo "<input type=\"radio\" name=\"newscreen\" value=\"return\"> $admtext[savereturn]<br/>\n";
?>
		</span>
		</td>
	</tr>
	</table><br/>&nbsp;
	<input type="hidden" name="ID" value="<?php echo "$ID"; ?>">
	<input type="hidden" name="tree" value="<?php echo "$tree"; ?>">
	<input type="hidden" name="orgplace" value="<?php echo "$row[place]"; ?>">
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext[save]; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
