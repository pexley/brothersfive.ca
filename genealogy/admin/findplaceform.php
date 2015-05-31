<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "findplace";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if($session_charset != "UTF-8")
	$place = utf8_decode($place);

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="finddiv">
<span class="subhead"><strong><?php echo $admtext['findplace']; ?></strong></span><br/>
<span class="normal">(<?php echo $admtext['enterplacepart']; ?>)</span><br/>
<form action="" name="findform1" id="findform1" onsubmit="return openFind(this,'findplace.php');">
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<?php if( $formname == "" ) $formname = "form1"; ?>
<input type="hidden" name="formname" value="<?php echo $formname; ?>">
<?php if( $field == "" ) $field = "personID"; ?>
<input type="hidden" name="field" value="<?php echo $field; ?>">
<table border="0" cellspacing="0" cellpadding="2">
	<tr>
	   	<td><span class="normal"><?php echo $admtext['place']; ?>: </span></td>
		<td><input type="text" name="myplace" value="<?php echo $place; ?>"></td>
		<td><input type="submit" value="<?php echo $admtext['search']; ?>"> <img src="../spinner.gif" id="findspin" width="16" height="16" style="display:none"></td>
	</tr>
</table>
</form>

</div>

<div class="databack" style="display:none;border:0px" id="findresults">
</div>