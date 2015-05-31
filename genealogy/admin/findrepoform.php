<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="findrepodiv">
<span class="subhead"><strong><?php echo $admtext['findrepoid']; ?></strong></span><br/>
<span class="normal">(<?php echo $admtext['enterrepopart']; ?>)</span><br/>

<form action="findrepo.php" method="post" name="findrepoform1" id="findrepoform1" onsubmit="return openFindRepo(this);">
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<?php if( $formname == "" ) $formname = "form1"; ?>
<input type="hidden" name="formname" value="<?php echo $formname; ?>">
<?php if( $field == "" ) $field = "personID"; ?>
<input type="hidden" name="field" value="<?php echo $field; ?>">
<table border="0" cellspacing="0" cellpadding="2">
	<tr>
	   	<td><span class="normal"><?php echo $admtext['title']; ?>: </span></td>
		<td><input type="text" name="mytitle"></td>
		<td><input type="submit" value="<?php echo $admtext['search']; ?>"></td>
	</tr>
</table>
</form>

</div>

<div class="databack" style="display:none;border:0px" id="findreporesults">
</div>
