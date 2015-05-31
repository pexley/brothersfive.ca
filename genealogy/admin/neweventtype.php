<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "eventtypes";
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

$helplang = findhelp("eventtypes_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewevtype], $flags );
?>
<SCRIPT language="JavaScript" type="text/javascript" src="eventtypes.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;
	var display = "";

<?php
	$query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
	$langresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	if( mysql_num_rows( $langresult ) ) {
		$displayrows = "";
		while( $langrow = mysql_fetch_assoc($langresult)) {
			$lang = $langrow[folder];
			$display = "$admtext[display] ($langrow[display])";
			$displayname = "display$lang";
			$displayrows .= "<tr><td valign=\"top\"><span class=\"normal\">$display</span></td><td><input type=\"text\" name=\"$displayname\" size=\"40\" value=\"\" onFocus=\"if(this.value == '') this.value = document.form1.defdisplay.value;\"></td></tr>\n";
			echo "if( document.form1.$displayname.value ) display = display + \"$lang\" + \"|\" + document.form1.$displayname.value + \"|\";\n";
		}
	}
	else
		$displayrows = "";
?>
	if( document.form1.tag2.value.length == 0 && document.form1.tag1.value.length == 0 ) {
		alert("<?php echo $admtext[selectentertag]; ?>");
		rval = false;
	}
	else if( ( document.form1.tag2.value == "EVEN" || ( document.form1.tag2.value == "" && document.form1.tag1.value == "EVEN" ) ) && document.form1.description.value.length == 0 ) {
		alert("<?php echo $admtext[entertypedesc]; ?>");
		rval = false;
	}
	else if( display == "" && document.form1.defdisplay.value == "" ) {
		alert("<?php echo $admtext[enterdisplay]; ?>");
		rval = false;
	}
	else
		document.form1.display.value = display;

	return rval;
}

<?php
$messages = array('EVEN','ADOP','ADDR','ALIA','ANCI','BARM','BASM','CAST','CENS','CHRA','CONF','CREM','DESI','DSCR','EDUC','EMIG','FCOM','GRAD','IDNO','IMMI','LANG','NATI','NATU','NCHI','NMR','OCCU','ORDI','ORDN','PHON','PROB','PROP','REFN','RELI','RESI','RESN','RETI','RFN','RIN','SSN','WILL','ANUL','DIV','DIVF','ENGA','MARB','MARC','MARR','MARL');
foreach($messages as $msg) {
	echo "messages['$msg'] = '" . $admtext[$msg] . "';\n";
}
?>
</script>
<script language="JavaScript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$evtabs[0] = array(1,"eventtypes.php",$admtext['search'],"findevent");
	$evtabs[1] = array($allow_add,"neweventtype.php",$admtext[addnew],"addevent");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/eventtypes_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($evtabs,"addevent",$innermenu);
	echo displayHeadline("$admtext[customeventtypes] &gt;&gt; $admtext[addnewevtype]","customeventtypes_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="addeventtype.php" method="post" name="form1" onSubmit="return validateForm();">
	<table>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext[assocwith]; ?>:</span></td>
		<td>
			<select name="type" onChange="populateTags(this.options[this.selectedIndex].value,'');">
				<option value="I"><?php echo $admtext['individual']; ?></option>
				<option value="F"><?php echo $admtext['family']; ?></option>
				<option value="S"><?php echo $admtext['source']; ?></option>
				<option value="R"><?php echo $admtext['repository']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['selecttag']; ?>:</span></td>
		<td>
			<select name="tag1" onChange="if(this.options[this.selectedIndex].value == 'EVEN') {toggleTdesc(1);} else {toggleTdesc(0);}">
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<span class="normal">&nbsp; <?php echo $admtext['orenter']; ?>:</span>
		</td>
		<td>
			<span class="normal"><input type="text" name="tag2" size="10" onBlur="if(this.value == 'EVEN') {toggleTdesc(1);} else {toggleTdesc(0);}"> (<?php echo $admtext['ifbothdata']; ?>)</span>
		</td>
	</tr>
	<tr id="tdesc"><td valign="top"><span class="normal"><?php echo $admtext['typedescription']; ?>*:</span></td><td><input type="text" name="description" size="40"></td></tr>
	<tr id="displaytr"><td valign="top"><span class="normal"><?php echo $admtext['display']; ?>:</span></td><td><input type="text" name="defdisplay" size="40"></td></tr>
<?php
	if( $displayrows ) {
?>	
	<tr><td valign="top" colspan="2">
	<br/><hr align="left" width="400" size="1">
	<?php echo displayToggle("plus0",0,"otherlangs",$admtext['othlangs'],''); ?>
	<table style="display:none" id="otherlangs">
		<tr><td valign="top" colspan="2"><span class="normal"><br /><b><?php echo $admtext['allnone']; ?></b><br /><br /></span></td></tr>
<?php
	echo $displayrows;
?>
	</table>
	<hr align="left" width="400" size="1"><br/>
	</td></tr>
<?php
	}
?>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['displayorder']; ?>:</span></td><td><input type="text" name="ordernum" size="4" value="0"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['evdata']; ?>:</span></td><td><span class="normal"><input type="radio" name="keep" value="1" checked> <?php echo $admtext[accept]; ?> <br/><input type="radio" name="keep" value="0"> <?php echo $admtext[ignore]; ?></span></td><td></td></tr>
	</table><br/>
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>">
	</form>
	<p class="normal">*<?php echo $admtext['typerequired']; ?></p>
</td>
</tr>

</table>
</div>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
<SCRIPT language="JavaScript" type="text/javascript">
	populateTags("I","");
</script>
</html>
