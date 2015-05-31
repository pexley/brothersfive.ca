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

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$helplang = findhelp("trees_help.php");

if($beforeimport) {
	header("Content-type:text/html; charset=" . $session_charset);
?>
<div class="databack" style="margin:10px;border:0px" id="newtree">
<p class="subhead"><strong><?php echo $admtext['addnewtree']; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/trees_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext['help']; ?></a></p>
<?php	
}
else {
	$flags[tabs] = $tngconfig[tabs];
	tng_adminheader( $admtext[addnewtree], $flags );
?>
<script type="text/javascript">
function validateTreeForm(form) {
	var rval = true;
	if( form.gedcom.value.length == 0 ) {
		alert('<?php echo $admtext['entertreeid']; ?>');
		rval = false;
	}
	else if( !alphaNumericCheck(form.gedcom.value) ) {
		alert('<?php echo $admtext['alphanum']; ?>');
		rval = false;
	}
	else if( form.treename.value.length == 0 ) {
		alert('<?php echo $admtext['entertreename']; ?>');
		rval = false;
	}
	return rval;
}

function alphaNumericCheck(string){
	var regex=/^[0-9A-Za-z_-]+$/; //^[a-zA-z]+$/
	return regex.test(string);
}
</script>
</head>

<body background="../background.gif">

<?php
	$allow_add_tree = $assignedtree ? 0 : $allow_add;
	$treetabs[0] = array(1,"trees.php",$admtext['search'],"findtree");
	$treetabs[1] = array($allow_add_tree,"newtree.php",$admtext[addnew],"addtree");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/trees_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($treetabs,"addtree",$innermenu);
	echo displayHeadline("$admtext[trees] &gt;&gt; $admtext[addnewtree]","trees_icon.gif",$menu,"");
}
?>

<table<?php if(!$beforeimport) echo " width=\"100%\""; ?> border="0" cellpadding="10" cellspacing="2"<?php if(!$beforeimport) echo " class=\"lightback\""; ?>>
<tr class="databack">
<td<?php if(!$beforeimport) echo " class=\"tngshadow\""; ?>>
	<form action="addtree.php" method="post" style="margin:0px" name="treeform" onsubmit="entertreeid='<?php echo $admtext['entertreeid']; ?>'; entertreename='<?php echo $admtext['entertreename']; ?>'; return validateTreeForm(this);">
	<table class="normal">
		<tr><td><?php echo $admtext['treeid']; ?>:</td><td><input type="text" name="gedcom" size="20" maxlength="20"></td></tr>
		<tr><td><?php echo $admtext['treename']; ?>:</td><td><input type="text" name="treename" size="50" value="<?php echo $treename; ?>"></td></tr>
		<tr><td valign="top"><?php echo $admtext['description']; ?>:</td><td><textarea cols="40" rows="3" name="description"><?php echo $description; ?></textarea></td></tr>
		<tr><td><?php echo $admtext['owner']; ?>:</td><td><input type="text" name="owner" size="50" value="<?php echo $owner; ?>"></td></tr>
		<tr><td><?php echo $admtext['email']; ?>:</td><td><input type="text" name="email" size="50" value="<?php echo $email; ?>"></td></tr>
		<tr><td><?php echo $admtext['address']; ?>:</td><td><input type="text" name="address" size="50" value="<?php echo $address; ?>"></td></tr>
		<tr><td><?php echo $admtext['city']; ?>:</td><td><input type="text" name="city" size="50" value="<?php echo $city; ?>"></td></tr>
		<tr><td><?php echo $admtext['stateprov']; ?>:</td><td><input type="text" name="state" size="50" value="<?php echo $state; ?>"></td></tr>
		<tr><td><?php echo $admtext['zip']; ?>:</td><td><input type="text" name="zip" size="50" value="<?php echo $zip; ?>"></td></tr>
		<tr><td><?php echo $admtext['cap_country']; ?>:</td><td><input type="text" name="country" size="50" value="<?php echo $country; ?>"></td></tr>
		<tr><td><?php echo $admtext['phone']; ?>:</td><td><input type="text" name="phone" size="50" value="<?php echo $phone; ?>"></td></tr>
	</table>
	<span class="normal">
	<input type="checkbox" name="private" value="1"<?php if( $private ) echo " checked"; ?>> <?php echo $admtext[text_private]; ?><br/>
	<input type="checkbox" name="disallowgedcreate" value="1"<?php if( $disallowgedcreate ) echo " checked"; ?>> <?php echo $admtext['gedcomextraction']; ?>
	<br/><br/></span>
	<input type="hidden" name="beforeimport" value="<?php echo $beforeimport; ?>">
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>"> <span id="treemsg" class="normal" style="color:green"></span>
	</form>
</td>
</tr>

</table>
<?php 
if($beforeimport)
	echo "</div>";
else {
	echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; 
?>
</body>
</html>
<?php
}
?>
