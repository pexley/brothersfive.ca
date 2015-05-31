<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "findplace";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if($place) {
	$query = "SELECT ID, place, longitude, latitude, gedcom FROM $places_table
		WHERE gedcom = \"$tree\" AND place LIKE \"%$place%\"
		ORDER BY place, gedcom, ID";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$numrows = mysql_num_rows( $result );
	if( !$numrows )
		$message = $admtext[noresults];
}
else
	$numrows = 0;

$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("places_help.php");

$flags[tabs] = $tngconfig['tabs'];
tng_adminheader( $admtext['mergeplaces'], $flags );
?>
<script type="text/javascript" src="mergeplaces.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
var enterplace = "<?php echo $admtext['enterplace']; ?>";
var enterkeep = "<?php echo $admtext['enterkeep']; ?>";
var successmsg = "<?php echo $admtext['pmsucc']; ?>";
</script>
</head>

<body background="../background.gif">

<?php
	$placetabs[0] = array(1,"places.php",$admtext['search'],"findplace");
	$placetabs[1] = array($allow_add,"newplace.php",$admtext['addnew'],"addplace");
	$placetabs[2] = array($allow_edit && $allow_delete,"mergeplaces.php",$admtext['merge'],"merge");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/places_help.php#merge2', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($placetabs,"merge",$innermenu);
	echo displayHeadline("$admtext[places] &gt;&gt; $admtext[mergeplaces]","places_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<span class="subhead"><strong>1. <?php echo $admtext['findmerge']; ?></strong></span><br/><br/>

	<form action="mergeplaces.php" method="post" style="margin:0px;" name="form1" onSubmit="return validateForm1();">
	<table>
	<tr>
		<td><span class="normal"><?php echo $admtext['tree']; ?>:</span></td>
		<td>
			<select name="tree">
<?php
	$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
	while( $treerow = mysql_fetch_assoc($treeresult) ) {
   		echo "		<option value=\"$treerow[gedcom]\"";
		if( $treerow['gedcom'] == $tree ) echo " selected";
		echo ">$treerow[treename]</option>\n";
	}
	mysql_free_result($treeresult);
?>
			</select>
		</td>
	</tr>
	<tr><td><span class="normal"><?php echo $admtext['searchfor']; ?>:</span></td><td><input type="text" name="place" size="50" value="<?php echo $place; ?>"></td></tr>
	</table><br/>
	<input type="submit" name="submit" value="<?php echo $admtext['text_continue']; ?>">
	</form>
<?php
	if($place && $numrows) {
?>
	<br /><br />

	<p class="subhead"><strong>2. <?php echo $admtext['selectplacemerge']; ?></strong></p>

	<form action="" method="post" onSubmit="return validateForm2(this);" name="form2" style="margin:0px">
    <p><input type="submit" value="<?php echo $admtext[mergeplaces]; ?>"> <img src="../spinner.gif" id="placespin" width="16" height="16" style="display:none">
	<span id="successmsg1" class="normal" style="color:green"></span></p>
	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback" valign="bottom" align="center"><span class="fieldname"><b><?php echo $admtext['mcol1']; ?></b></span></td>
			<td class="fieldnameback" valign="bottom" align="center"><span class="fieldname"><b><?php echo $admtext['mcol2']; ?></b></span></td>
			<td class="fieldnameback" valign="bottom"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['place']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" valign="bottom" align="center"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['latitude']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback" valign="bottom" align="center"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['longitude']; ?></b>&nbsp;</nobr></span></td>
		</tr>

<?php
		while( $row = mysql_fetch_assoc($result))
		{
			echo "<tr class=\"mergerows\" id=\"row_$row[ID]\">\n";
			echo "<td class=\"lightback\" valign=\"top\" align=\"center\"><span class=\"normal\"><input type=\"checkbox\" class=\"mc\" name=\"mc$row[ID]\" onclick=\"handleCheck($row[ID]);\" value=\"$row[ID]\"></span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\" align=\"center\"><span class=\"normal\"><input type=\"radio\" name=\"keep\" id=\"r$row[ID]\" onclick=\"handleRadio($row[ID]);\" value=\"$row[ID]\"></span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[place]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[latitude]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[longitude]&nbsp;</span></td>\n";
			echo "</tr>\n";
		}
		mysql_free_result($result);
?>
	</table><br/>
	<input type="submit" value="<?php echo $admtext[mergeplaces]; ?>">
	<span id="successmsg2" class="normal" style="color:green"></span>
	</form>
<?php
	}
?>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
