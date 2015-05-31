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

$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc($result);
mysql_free_result( $result );

$query = "SELECT description FROM $branches_table WHERE gedcom = \"$tree\" and branch = \"$branch\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$brow = mysql_fetch_assoc($result);
mysql_free_result( $result );

$query = "SELECT personID, firstname, lastname, lnprefix, prefix, suffix, branch, gedcom, nameorder FROM $people_table WHERE gedcom = \"$tree\" and branch LIKE \"%$branch%\" ORDER BY lastname, firstname";
$brresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$helplang = findhelp("branches_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[labelbranches], $flags );
?>
</head>

<body background="../background.gif">

<?php
	$branchtabs[0] = array(1,"branches.php",$admtext['search'],"findbranch");
	$branchtabs[1] = array($allow_add,"newbranch.php",$admtext[addnew],"addbranch");
	$branchtabs[2] = array($allow_edit,"#",$admtext['labelbranches'],"label");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/branches_help.php#labelbranch', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($branchtabs,"label",$innermenu);
	echo displayHeadline("$admtext[branches] &gt;&gt; $admtext[labelbranches]","branches_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table border="0" cellpadding="1">
		<tr>
			<td><span class="normal"><strong><?php echo $admtext['tree']; ?>:</strong></span></td>
			<td><span class="normal"><?php echo $row['treename']; ?></span></td>
		</tr>
		<tr>
			<td><span class="normal"><strong><?php echo $admtext['branch']; ?>:</strong></span></td>
			<td><span class="normal"><?php echo $brow['description']; ?></span></td>
		</tr>
		<tr>
			<td colspan="2">
			<span class="normal"><br/>
<?php
	echo "<p><a href=\"branchmenu.php?tree=$tree&amp;branch=$branch\">$admtext[addlabels]</a></p>\n";
	while( $row = mysql_fetch_assoc($brresult)) {
		echo "<a href=\"editperson.php?personID=$row[personID]&amp;tree=$row[gedcom]\">" . getNameRev( $row ) . " ($row[personID])</a><br />\n";
	}
	mysql_free_result( $brresult );
?>				
			</span>
			</td>
		</tr>
	</table>
	<br/>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
