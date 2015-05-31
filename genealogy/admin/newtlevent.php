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

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$helplang = findhelp("tlevents_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewtlevent], $flags );
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
	$timelinetabs[0] = array(1,"timelineevents.php",$admtext['search'],"findtimeline");
	$timelinetabs[1] = array($allow_add,"newtlevent.php",$admtext['addnew'],"addtlevent");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/tlevents_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($timelinetabs,"addtlevent",$innermenu);
	echo displayHeadline("$admtext[tlevents] &gt;&gt; $admtext[addnewtlevent]","tlevents_icon.gif",$menu,"");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="addtlevent.php" method="post" name="form1" style="margin:0px;" onSubmit="return validateForm();">
	<table>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['eventdate']; ?>:</span></td>
		<td>
			<select name="evday">
				<option value=""></option>
<?php
	for( $i = 1; $i <= 31; $i++ ) {
		echo "<option value=\"$i\">$i</option>\n";
	}
?>
			</select>
			<select name="evmonth">
				<option value=""></option>
				<option value="1"><?php echo $dates['JAN']; ?></option>
				<option value="2"><?php echo $dates['FEB']; ?></option>
				<option value="3"><?php echo $dates['MAR']; ?></option>
				<option value="4"><?php echo $dates['APR']; ?></option>
				<option value="5"><?php echo $dates['MAY']; ?></option>
				<option value="6"><?php echo $dates['JUN']; ?></option>
				<option value="7"><?php echo $dates['JUL']; ?></option>
				<option value="8"><?php echo $dates['AUG']; ?></option>
				<option value="9"><?php echo $dates['SEP']; ?></option>
				<option value="10"><?php echo $dates['OCT']; ?></option>
				<option value="11"><?php echo $dates['NOV']; ?></option>
				<option value="12"><?php echo $dates['DEC']; ?></option>
			</select>
			<input type="text" name="evyear" size="4"> <span class="normal"><?php echo $admtext['yrreq']; ?></span>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['evdetail']; ?>:</span></td><td><textarea cols="50" rows="3" name="evdetail"></textarea></td></tr>
	</table><br/>&nbsp;
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
