<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "secondary";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $assignedtree )
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
else
	$wherestr = "";
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$helplang = findhelp("second_help.php");

$flags[tabs] = $tngconfig['tabs'];
tng_adminheader( $admtext['secondary'], $flags );
?>
</head>

<body background="../background.gif">

<?php
	$datatabs[0] = array(1,"dataimport.php",$admtext[import],"import");
	$datatabs[1] = array($allow_ged,"export.php",$admtext[export],"export");
	$datatabs[2] = array(1,"secondmenu.php",$admtext[secondarymaint],"second");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/second_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($datatabs,"second",$innermenu);
	echo displayHeadline("$admtext[datamaint] &gt;&gt; $admtext[secondary]","data_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="secondary.php" method="post" name="form1" style="margin:0px">
	<span class="normal"><?php echo $admtext['tree'];?>: <select name="tree">
<?php
if( !$assignedtree )
	echo "	<option value=\"--all--\">$admtext[alltrees]</option>\n";
while( $row = mysql_fetch_assoc($result) ) {
	echo "	<option value=\"$row[gedcom]\">$row[treename]</option>\n";
}
?>
	</select><br/><br/></span>
	<!-- <input type="submit" name="secaction" value="<?php echo $admtext['creategendex']; ?>">  -->
	<input type="submit" name="secaction" value="<?php echo $admtext['tracklines']; ?>">
	<input type="submit" name="secaction" value="<?php echo $admtext['sortchildren']; ?>">
	<input type="submit" name="secaction" value="<?php echo $admtext['sortspouses']; ?>">
	<input type="submit" name="secaction" value="<?php echo $admtext['relabelbranches']; ?>">
	<input type="submit" name="secaction" value="<?php echo $admtext['creategendex']; ?>">
	</form>
	<p class="normal">&raquo; <a href="http://tngnetwork.lythgoes.net" target="_blank"><?php echo $admtext['tngnet']; ?></a></p>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
