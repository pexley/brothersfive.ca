<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$helplang = findhelp("backuprestore_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[backuprestore], $flags );
?>
</head>

<body background="../background.gif">

<?php
	$utiltabs[0] = array(1,"backuprestore.php?sub=tables",$admtext['backuprestoretables'],"tables");
	$utiltabs[1] = array(1,"backuprestore.php?sub=structure",$admtext['backupstruct'],"structure");
	$utiltabs[2] = array(1,"renumbermenu.php",$admtext['renumber'],"renumber");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/backuprestore_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($utiltabs,"renumber",$innermenu);
	$headline = "$admtext[backuprestore] &gt;&gt; $admtext[renumber]";
	echo displayHeadline($headline,"backuprestore_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<p class="normal"><?php echo $admtext['reseqwarn']; ?></p>
	<form action="renumber.php" method="post" name="form1" style="margin:0px">
	<table class="normal">
		<tr>
			<td><?php echo $admtext['tree'];?>:</td>
			<td>
				<select name="tree">
<?php
while( $row = mysql_fetch_assoc($result) ) {
	echo "	<option value=\"$row[gedcom]\">$row[treename]</option>\n";
}
?>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['idtype'];?>:</td>
			<td>
				<select name="type">
					<option value="person"><?php echo $admtext['people'];?></option>
					<option value="family"><?php echo $admtext['families'];?></option>
					<option value="source"><?php echo $admtext['sources'];?></option>
					<option value="repo"><?php echo $admtext['repositories'];?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $admtext['mindigits'];?>*:</td>
			<td>
				<select name="digits">
<?php
	for($i = 1; $i <= 20; $i++ )
		echo "<option value=\"$i\">$i</option>\n";
?>
				</select>
			</td>
		</tr>
		<!--<tr>
			<td><?php echo $admtext['useroffset'];?>*:</td>
			<td><input type="text" name="start" value="1" /></td>
		</tr>-->
	</table><br />
	<input type="hidden" name="start" value="1" />
	<input type="submit" value="<?php echo $admtext['renumber']; ?>"<?php if(!$tngconfig['maint']) echo " disabled"; ?>>
<?php
	if(!$tngconfig['maint'])
		echo "<span class=\"normal\">$admtext[needmaint]</span>";
?>
	<br /><br />
<?php echo "<p class=\"normal\">*$admtext[niprefix]</p>\n"; ?>
	</form>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
