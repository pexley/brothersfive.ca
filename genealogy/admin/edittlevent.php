<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "timeline";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

session_register('tng_search_tlevents');
$tng_search_tlevents = $_SESSION[tng_search_tlevents];

$query = "SELECT * FROM $tlevents_table WHERE tleventID = \"$tleventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row['evdetail'] = ereg_replace("\"", "&#34;",$row['evdetail']);

$helplang = findhelp("tlevents_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader( $admtext['modifytlevent'], $flags );
?>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;
	if( document.form1.evyear.value.length == 0 ) {
		alert("<?php echo $admtext[enterevyear]; ?>");
		rval = false;
	}
	else if( document.form1.evdetail.value.length == 0 ) {
		alert("<?php echo $admtext[enterevdetail]; ?>");
		rval = false;
	}
	return rval;
}	
</script>
</head>

<body background="../background.gif">

<?php
	$timelinetabs[0] = array(1,"timelineevents.php",$admtext['search'],"findtlevent");
	$timelinetabs[1] = array($allow_add,"newtlevent.php",$admtext['addnew'],"addtlevent");
	$timelinetabs[2] = array($allow_edit,"#",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/tlevents_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($timelinetabs,"edit",$innermenu);
	echo displayHeadline("$admtext[tlevents] &gt;&gt; $admtext[modifytlevent]","tlevents_icon.gif",$menu,"");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="updatetlevent.php" method="post" name="form1" id="form1" onSubmit="return validateForm();">
	<table>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['eventdate']; ?>:</span></td>
		<td>
			<select name="evday">
				<option value=""></option>
<?php
	for( $i = 1; $i <= 31; $i++ ) {
		echo "<option value=\"$i\"";
		if( $row[evday] == $i ) echo " selected";
		echo ">$i</option>\n";
	}
?>
			</select>
			<select name="evmonth">
				<option value=""></option>
				<option value="1"<?php if( $row['evmonth'] == 1 ) echo " selected"; ?>><?php echo $dates['JAN']; ?></option>
				<option value="2"<?php if( $row['evmonth'] == 2 ) echo " selected"; ?>><?php echo $dates['FEB']; ?></option>
				<option value="3"<?php if( $row['evmonth'] == 3 ) echo " selected"; ?>><?php echo $dates['MAR']; ?></option>
				<option value="4"<?php if( $row['evmonth'] == 4 ) echo " selected"; ?>><?php echo $dates['APR']; ?></option>
				<option value="5"<?php if( $row['evmonth'] == 5 ) echo " selected"; ?>><?php echo $dates['MAY']; ?></option>
				<option value="6"<?php if( $row['evmonth'] == 6 ) echo " selected"; ?>><?php echo $dates['JUN']; ?></option>
				<option value="7"<?php if( $row['evmonth'] == 7 ) echo " selected"; ?>><?php echo $dates['JUL']; ?></option>
				<option value="8"<?php if( $row['evmonth'] == 8 ) echo " selected"; ?>><?php echo $dates['AUG']; ?></option>
				<option value="9"<?php if( $row['evmonth'] == 9 ) echo " selected"; ?>><?php echo $dates['SEP']; ?></option>
				<option value="10"<?php if( $row['evmonth'] == 10 ) echo " selected"; ?>><?php echo $dates['OCT']; ?></option>
				<option value="11"<?php if( $row['evmonth'] == 11 ) echo " selected"; ?>><?php echo $dates['NOV']; ?></option>
				<option value="12"<?php if( $row['evmonth'] == 12 ) echo " selected"; ?>><?php echo $dates['DEC']; ?></option>
			</select>
			<input type="text" name="evyear" size="4" value="<?php echo "$row[evyear]"; ?>"> <span class="normal"><?php echo $admtext['yrreq']; ?></span>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['evdetail']; ?>:</span></td><td colspan="2"><textarea cols="50" rows="3" name="evdetail"><?php echo "$row[evdetail]"; ?></textarea></td></tr>
	<tr>
		<td colspan="2">
		<span class="normal">
<?php
	echo "$admtext[onsave]:<br/>";
	echo "<input type=\"radio\" name=\"newscreen\" value=\"return\"> $admtext[savereturn]<br/>\n";
	if( $tng_search_tlevents ) {
		echo "<input type=\"radio\" name=\"newscreen\" value=\"none\" checked> $admtext[saveback]\n";
	}
?>
		</span>
		</td>
	</tr>
	</table><br/>&nbsp;
	<input type="hidden" name="tleventID" value="<?php echo "$tleventID"; ?>"><input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
