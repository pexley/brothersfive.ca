<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "branches";
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

if( $assignedtree ) {
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
	$tree = $assignedtree;
}
else
	$wherestr = "";
$orgtree = $tree;
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("branches_help.php");

$flags[tabs] = $tngconfig['tabs'];
tng_adminheader( $admtext['addnewbranch'], $flags );
?>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;
	if( document.form1.branch.value.length == 0 ) {
		alert("<?php echo $admtext['enterbranchid']; ?>");
		rval = false;
	}
	else if( document.form1.description.value.length == 0 ) {
		alert("<?php echo $admtext['entertreedesc']; ?>");
		rval = false;
	}
	return rval;
}	
</script>
</head>

<body background="../background.gif">

<?php
	$branchtabs[0] = array(1,"branches.php",$admtext['search'],"findbranch");
	$branchtabs[1] = array($allow_add,"newbranch.php",$admtext['addnew'],"addbranch");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/branches_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($branchtabs,"addbranch",$innermenu);
	echo displayHeadline("$admtext[branches] &gt;&gt; $admtext[modifybranch]","branches_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="addbranch.php" method="post" style="margin:0px;" name="form1" onsubmit="return validateForm();">
	<table class="normal">
		<tr>
			<td><?php echo $admtext['tree']; ?>: </td>
			<td>
				<select name="tree">
<?php
	$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
	while( $treerow = mysql_fetch_assoc($treeresult) )
		echo "	<option value=\"$treerow[gedcom]\">$treerow[treename]</option>\n";
	mysql_free_result($treeresult);
?>
				</select>
			</td>
		</tr>
		<tr><td valign="top"><?php echo $admtext['branchid']; ?>:</td><td><input type="text" name="branch" size="20" maxlength="20"/></td></tr>
		<tr><td valign="top"><?php echo $admtext['description']; ?>:</td><td><input type="text" name="description" size="60"></td></tr>
	</table>
	<br/></span>
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>