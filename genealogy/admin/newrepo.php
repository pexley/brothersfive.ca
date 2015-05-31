<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
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

$helplang = findhelp("repositories_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewrepo], $flags );
?>
<script language="JavaScript" src="selectutils.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;

	document.form1.repoID.value = TrimString( document.form1.repoID.value );
	if( document.form1.repoID.value.length == 0 ) {
		alert("<?php echo $admtext[enterrepoid]; ?>");
		return false;
	}
	else if( document.form1.reponame.value.length == 0 ) {
		alert("<?php echo $admtext[enterreponame]; ?>");
		return false;
	}
	return rval;
}	

var selecttree = "<?php echo $admtext['selecttree']; ?>";
</script>
</head>

<body background="../background.gif" onload="generateID('repo',document.form1.repoID);">

<?php
	$repotabs[0] = array(1,"repositories.php",$admtext['search'],"findrepo");
	$repotabs[1] = array($allow_add,"newrepo.php",$admtext['addnew'],"addrepo");
	$repotabs[2] = array($allow_edit && $allow_delete,"mergerepos.php",$admtext[merge],"merge");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/repositories_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($repotabs,"addrepo",$innermenu);
	echo displayHeadline("$admtext[repositories] &gt;&gt; $admtext[addnewrepo]","repos_icon.gif",$menu,$message);
?>

<form action="addrepo.php" method="post" style="margin:0px" name="form1" onSubmit="return validateForm();">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table>
	<tr><td valign="top" colspan="2"><span class="normal"><strong><?php echo $admtext[prefixrepoid]; ?></strong></span></td></tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext[tree]; ?>:</span></td>
		<td>
			<select name="tree1" onChange="generateID('repo',document.form1.repoID);">
<?php
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$numtrees = mysql_num_rows($result);
while( $row = mysql_fetch_assoc($result) ) {
	echo "		<option value=\"$row[gedcom]\">$row[treename]</option>\n";
}
mysql_free_result( $result );
?>
			</select> 
		</td>
	</tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext[repoid]; ?>:</span></td>
		<td>
			<input type="text" name="repoID" size="10" onBlur="this.value=this.value.toUpperCase()">
			<input type="button" value="<?php echo $admtext['generate']; ?>" onClick="generateID('repo',document.form1.repoID);">
			<input type="submit" name="submit" value="<?php echo $admtext['lockid']; ?>" onClick="document.form1.newscreen[0].checked = true;">
			<input type="button" value="<?php echo $admtext['check']; ?>" onClick="checkID(document.form1.repoID.value,'repo','checkmsg');">
			<span id="checkmsg" class="normal"></span>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[name]; ?>:</span></td><td><span class="normal"><input type="text" name="reponame" size="40"> (<?php echo $admtext[required]; ?>)</span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[address1]; ?>:</span></td><td><input type="text" name="address1" size="50"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[address2]; ?>:</span></td><td><input type="text" name="address2" size="50"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[city]; ?>:</span></td><td><input type="text" name="city" size="50"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[stateprov]; ?>:</span></td><td><input type="text" name="state" size="50"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[zip]; ?>:</span></td><td><input type="text" name="zip" size="20"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[countryaddr]; ?>:</span></td><td><input type="text" name="country" size="50"></td></tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<p class="normal"><strong><?php echo $admtext['revslater']; ?></strong></p>
	<input type="submit" name="save" accesskey="s" value="<?php echo $admtext['savecont']; ?>">
</td>
</tr>
</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
