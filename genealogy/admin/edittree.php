<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "trees";
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

$query = "SELECT * FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);

$query = "SELECT count(personID) as pcount FROM $people_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$prow = mysql_fetch_assoc($result);
$pcount = number_format($prow['pcount']);
mysql_free_result($result);

$query = "SELECT count(familyID) as fcount FROM $families_table WHERE gedcom = \"$row[gedcom]\"";
$famresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$famrow = mysql_fetch_assoc($famresult);
$fcount = number_format($famrow['fcount']);
mysql_free_result($famresult);

$query = "SELECT count(sourceID) as scount FROM $sources_table WHERE gedcom = \"$row[gedcom]\"";
$srcresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$srcrow = mysql_fetch_assoc($srcresult);
$scount = number_format($srcrow['scount']);
mysql_free_result($srcresult);

$query = "SELECT count(repoID) as rcount FROM $repositories_table WHERE gedcom = \"$row[gedcom]\"";
$reporesult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$reporow = mysql_fetch_assoc($reporesult);
$rcount = number_format($reporow['rcount']);
mysql_free_result($reporesult);

$query = "SELECT count(noteID) as ncount FROM $xnotes_table WHERE gedcom = \"$row[gedcom]\"";
$nresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$nrow = mysql_fetch_assoc($nresult);
$ncount = number_format($nrow['ncount']);
mysql_free_result($nresult);

$helplang = findhelp("trees_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[modifytree], $flags );
?>
<SCRIPT language="JavaScript" type="text/javascript">
function validateForm( ) {
	var rval = true;
	if( document.form1.treename.value.length == 0 ) {
		alert("<?php echo $admtext[entertreename]; ?>");
		rval = false;
	}
	return rval;
}	
</script>
</head>

<body background="../background.gif">

<?php
	$allow_add_tree = $assignedtree ? 0 : $allow_add;
	$treetabs[0] = array(1,"trees.php",$admtext['search'],"findtree");
	$treetabs[1] = array($allow_add_tree,"newtree.php",$admtext['addnew'],"addtree");
	$treetabs[2] = array($allow_edit,"#",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/trees_help.php#edit', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($treetabs,"edit",$innermenu);
	echo displayHeadline("$admtext[trees] &gt;&gt; $admtext[modifytree]","trees_icon.gif",$menu,"");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="updatetree.php" method="post" name="form1" onSubmit="return validateForm();">
	<table class="normal">
		<tr>
			<td valign="top"><?php echo $admtext[treeid]; ?>:</td><td><?php echo "$tree"; ?></td>
			<td width="30" rowspan="11">&nbsp;&nbsp;&nbsp;</td>
			<td rowspan="11" valign="top">
				<table class="normal">
					<?php
						echo "<tr><td>$admtext[people]: </td><td>&nbsp;</td><td align=\"right\">$pcount</td></tr>\n";
						echo "<tr><td>$admtext[families]: </td><td>&nbsp;</td><td align=\"right\">$fcount</td></tr>\n";
						echo "<tr><td>$admtext[sources]: </td><td>&nbsp;</td><td align=\"right\">$scount</td></tr>\n";
						echo "<tr><td>$admtext[repositories]: </td><td>&nbsp;</td><td align=\"right\">$rcount</td></tr>\n";
						echo "<tr><td>$admtext[notes]: </td><td>&nbsp;</td><td align=\"right\">$ncount</td></tr>\n";
					?>
				</table>
			</td>
		</tr>
		<tr><td><?php echo $admtext['treename']; ?>:</td><td><input type="text" name="treename" size="50" value="<?php echo $row['treename']; ?>"></td></tr>
		<tr><td valign="top"><?php echo $admtext['description']; ?>:</td><td><textarea cols="40" rows="3" name="description"><?php echo $row['description']; ?></textarea></td></tr>
		<tr><td><?php echo $admtext['owner']; ?>:</td><td><input type="text" name="owner" size="50" value="<?php echo $row['owner']; ?>"></td></tr>
		<tr><td><?php echo $admtext['email']; ?>:</td><td><input type="text" name="email" size="50" value="<?php echo $row['email']; ?>"></td></tr>
		<tr><td><?php echo $admtext['address']; ?>:</td><td><input type="text" name="address" size="50" value="<?php echo $row['address']; ?>"></td></tr>
		<tr><td><?php echo $admtext['city']; ?>:</td><td><input type="text" name="city" size="50" value="<?php echo $row['city']; ?>"></td></tr>
		<tr><td><?php echo $admtext['stateprov']; ?>:</td><td><input type="text" name="state" size="50" value="<?php echo $row['state']; ?>"></td></tr>
		<tr><td><?php echo $admtext['zip']; ?>:</td><td><input type="text" name="zip" size="50" value="<?php echo $row['zip']; ?>"></td></tr>
		<tr><td><?php echo $admtext['cap_country']; ?>:</td><td><input type="text" name="country" size="50" value="<?php echo $row['country']; ?>"></td></tr>
		<tr><td><?php echo $admtext['phone']; ?>:</td><td><input type="text" name="phone" size="50" value="<?php echo $row['phone']; ?>"></td></tr>
	</table>
	<span class="normal">
	<input type="checkbox" name="private" value="1"<?php if( $row['secret'] ) echo " checked"; ?>> <?php echo $admtext['text_private']; ?><br/>
	<input type="checkbox" name="disallowgedcreate" value="1"<?php if( $row['disallowgedcreate'] ) echo " checked"; ?>> <?php echo $admtext['gedcomextraction']; ?>
	<br/><br/></span>
	<input type="hidden" name="tree" value="<?php echo "$tree"; ?>"><input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>"></form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
