<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "mapconfig.php");
include("adminlib.php");
$textpart = "cemeteries";
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

$query = "SELECT state FROM $states_table";
$stateresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "SELECT country FROM $countries_table";
$countryresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$helplang = findhelp("cemeteries_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewcemetery], $flags );

if( $map[key] )
	echo "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=$map[key]\" language=\"Javascript\" type=\"text/javascript\"></script>\n";
?>
<script type="text/javascript" src="selectutils.js"></script>
<SCRIPT type="text/javascript" src="mediautils.js"></script>
<SCRIPT type="text/javascript">
var nothingtodelete = '<?php echo $admtext['nothingtodelete']; ?>';
var confdeleteentity = '<?php echo $admtext['confdeleteentity']; ?>';
var pleaseenter = '<?php echo $admtext['pleaseenter']; ?>';
var tnglitbox;

function validateForm( ) {
	var rval = true;
	if( document.form1.country.value.length == 0 ) {
		alert("<?php echo $admtext[entercountry]; ?>");
		rval = false;
	}
	else if( document.form1.newfile.value.length > 0 && document.form1.maplink.value.length == 0 ) {
		alert("<?php echo $admtext[entermapfile]; ?>");
		rval = false;
	}
	else
		document.form1.maplink.value = document.form1.maplink.value.replace(/\\/g,"/");
	return rval;
}	

function populatePath(source, dest) {
	var lastslash, temp;
	
	dest.value = "";
	temp = source.value.replace(/\\/g,"/");
	lastslash = temp.lastIndexOf("/") + 1;
	if( lastslash )
		dest.value = source.value.slice(lastslash);
}
</script>
<?php
	if($map[key])
		include "../googlemaps/googlemaplib2.php";
?>
</head>

<body<?php if($map['key']) { if(!$map['startoff']) echo " onload=\"divbox('mapcontainer');\""; echo " onunload=\"GUnload();\""; } ?> background="../background.gif">

<?php
	$cemtabs[0] = array(1,"cemeteries.php",$admtext['search'],"findcem");
	$cemtabs[1] = array($allow_add,"newcemetery.php",$admtext['addnew'],"addcemetery");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/cemeteries_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($cemtabs,"addcemetery",$innermenu);
	echo displayHeadline("$admtext[cemeteries] &gt;&gt; $admtext[addnewcemetery]","cemeteries_icon.gif",$menu,$message);
?>

<form action="addcemetery.php" method="post" style="margin:0px;" name="form1" ENCTYPE="multipart/form-data" onSubmit="return validateForm();">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['cemeteryname']; ?>:</span></td><td width="80%"><input type="text" name="cemname" size="40"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['maptoupload']; ?>*:</span></td><td><input type="file" name="newfile" size="60" onChange="populatePath(document.form1.newfile,document.form1.maplink);"></td></tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['mapfilenamefolder']; ?>**:</span></td>
		<td><input type="text" name="maplink" id="maplink" size="60"><input type="hidden" id="maplink_org"><input type="hidden" id="maplink_last"> <input type="button" value="<?php echo "$admtext[select]..."; ?>" OnClick="javascript:FilePicker('maplink','headstones');"></td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['city']; ?>:</span></td><td><input type="text" name="city" size="20"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['countyparish']; ?>:</span></td><td><input type="text" name="county" size="20"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['stateprovince']; ?>:</span></td>
		<td>
			<select name="state">
				<option></option>
<?php
while( $staterow = mysql_fetch_assoc($stateresult) ) {
	echo "	<option value=\"$staterow[state]\">$staterow[state]</option>\n";
}
?>
			</select> 
			<input type="button" name="addnewstate" value="<?php echo $admtext['addnew']; ?>" onclick="tnglitbox = new LITBox('newentity.php?entity=state',{width:350,height:120});">
			<input type="button" name="deletestate" value="<?php echo $admtext['deleteselected']; ?>" onclick="attemptDelete(document.form1.state,'state');">
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['cap_country']; ?>:</span></td>
		<td>
			<select name="country">
				<option></option>
<?php
while( $countryrow = mysql_fetch_assoc($countryresult) ) {
	echo "	<option value=\"$countryrow[country]\">$countryrow[country]</option>\n";
}
?>
			</select> 
			<input type="button" name="addnewcountry" value="<?php echo $admtext['addnew']; ?>" onclick="tnglitbox = new LITBox('newentity.php?entity=country',{width:350,height:120});">
			<input type="button" name="deletecountry" value="<?php echo $admtext['deleteselected']; ?>" onclick="attemptDelete(document.form1.country,'country');">
		</td>
	</tr>
<?php
	if( $map['key'] ) {
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
	if( $map['key'] ) {
?>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['zoom']; ?>:</span></td><td><input type="text" name="zoom" size="20" id="zoombox"></td></tr>
<?php
	}
?>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['notes']; ?>:</span></td><td><textarea wrap cols="60" rows="8" name="notes"></textarea></td></tr>
	</table><br/>&nbsp;
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>">
	<p class="normal">*<?php echo $admtext['ifmapuploaded']; ?><br/>
	**<?php echo $admtext['requiredmap']; ?></p>
</td>
</tr>
</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
