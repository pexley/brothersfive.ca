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

$helplang = findhelp("sources_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewsource], $flags );
?>
<script language="JavaScript" src="selectutils.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;

	document.form1.sourceID.value = TrimString( document.form1.sourceID.value );
	if( document.form1.sourceID.value.length == 0 ) {
		alert("<?php echo $admtext[entersourceid]; ?>");
		return false;
	}
	return rval;
}	

var selecttree = "<?php echo $admtext['selecttree']; ?>";
</script>
</head>

<body background="../background.gif" onload="generateID('source',document.form1.sourceID);">

<?php
	$sourcetabs[0] = array(1,"sources.php",$admtext['search'],"findsource");
	$sourcetabs[1] = array($allow_add,"newsource.php",$admtext[addnew],"addsource");
	$sourcetabs[2] = array($allow_edit && $allow_delete,"mergesources.php",$admtext[merge],"merge");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/sources_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($sourcetabs,"addsource",$innermenu);
	echo displayHeadline("$admtext[sources] &gt;&gt; $admtext[addnewsource]","sources_icon.gif",$menu,$message);
?>

<form action="addsource.php" method="post" style="margin:0px" name="form1" onSubmit="return validateForm();">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table>
	<tr><td valign="top" colspan="2"><span class="normal"><strong><?php echo $admtext[prefixsourceid]; ?></strong></span></td></tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext[tree]; ?>:</span></td>
		<td>
			<select name="tree1" onChange="generateID('source',document.form1.sourceID);">
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
		<td valign="top"><span class="normal"><?php echo $admtext[sourceid]; ?>:</span></td>
		<td>
			<input type="text" name="sourceID" size="10" onBlur="this.value=this.value.toUpperCase()">
			<input type="button" value="<?php echo $admtext['generate']; ?>" onClick="generateID('source',document.form1.sourceID);">
			<input type="submit" name="submit" value="<?php echo $admtext['lockid']; ?>" onClick="document.form1.newscreen[0].checked = true;">
			<input type="button" value="<?php echo $admtext['check']; ?>" onClick="checkID(document.form1.sourceID.value,'source','checkmsg');">
			<span id="checkmsg" class="normal"></span>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[shorttitle]; ?>:</span></td><td><span class="normal"><input type="text" name="shorttitle" size="40"> (<?php echo $admtext[required]; ?>)</span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[longtitle]; ?>:</span></td><td><input type="text" name="title" size="50"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[author]; ?>:</span></td><td><input type="text" name="author" size="40"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[callnumber]; ?>:</span></td><td><input type="text" name="callnum" size="20"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[publisher]; ?>:</span></td><td><input type="text" name="publisher" size="40"></td></tr>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext[repository]; ?>:</span></td>
		<td>
			<select name="repoID">
				<option value=""></option>
<?php
$query = "SELECT repoID, reponame, gedcom FROM $repositories_table $wherestr ORDER BY reponame";
$reporesult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
while( $reporow = mysql_fetch_assoc($reporesult) ) {
	if( !$assignedtree && $numtrees > 1 )
		echo "		<option value=\"$reporow[repoID]\">$reporow[reponame] ($admtext[tree]: $reporow[gedcom])</option>\n";
	else
		echo "		<option value=\"$reporow[repoID]\">$reporow[reponame]</option>\n";
}
mysql_free_result( $reporesult );
?>			
			</select>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[actualtext]; ?>:</span></td><td><textarea cols="50" rows="5" name="actualtext"></textarea></td></tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<p class="normal"><strong><?php echo $admtext['sevslater']; ?></strong></p>
	<input type="submit" name="save" accesskey="s" value="<?php echo $admtext['savecont']; ?>">
</td>
</tr>
</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
