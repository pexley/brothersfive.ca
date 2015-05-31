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

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$query = "SELECT * FROM $branches_table WHERE gedcom = \"$tree\" AND branch = \"$branch\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$row[description] = ereg_replace("\"", "&#34;",$row[description]);
mysql_free_result($result);

$query = "SELECT treename FROM $trees_table where gedcom = \"$tree\"";
$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc( $treeresult );
mysql_free_result( $treeresult );

$helplang = findhelp("branches_help.php");

$flags[tabs] = $tngconfig['tabs'];
tng_adminheader( $admtext['modifytree'], $flags );
?>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;
	if( document.form1.description.value.length == 0 ) {
		alert("<?php echo $admtext['enterbranchdesc']; ?>");
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
	$branchtabs[2] = array($allow_edit,"#",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/branches_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($branchtabs,"edit",$innermenu);
	echo displayHeadline("$admtext[branches] &gt;&gt; $admtext[modifybranch]","branches_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="updatebranch.php" method="post" style="margin:0px" name="form1" onSubmit="return validateForm();">
	<table class="normal">
		<tr><td valign="top"><?php echo $admtext['tree']; ?>:</td><td><?php echo $treerow['treename']; ?></td></tr>
		<tr><td valign="top"><?php echo $admtext['branchid']; ?>:</td><td><?php echo $branch; ?></td></tr>
		<tr><td valign="top"><?php echo $admtext['description']; ?>:</td><td><input type="text" name="description" size="60" value="<?php echo $row['description']; ?>"></td></tr>
	</table>
	<span class="normal">
	<br/></span>
	<input type="hidden" name="tree" value="<?php echo $tree; ?>">
	<input type="hidden" name="branch" value="<?php echo $branch; ?>">
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
