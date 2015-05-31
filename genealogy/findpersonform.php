<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "relate";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="finddiv">
<span class="subhead"><strong><?php echo $text['findpersonid']; ?></strong></span><br/>

<span class="normal">(<?php echo $text[enternamepart]; ?>)</span><br/>
<?php
$findperson_url = getURL( "findperson", 1 );
echo getFORM( "findperson", "post", "findform1\" onsubmit=\"return openFind(this,'$findperson_url');\"", "findform1" );
?>
<input type="hidden" name="findtree" value="<?php echo $findtree; ?>">
<?php if( $formname == "" ) $formname = "form1"; ?>
<input type="hidden" name="formname" value="<?php echo $formname; ?>">
<input type="hidden" name="noliving" value="<?php echo $noliving; ?>">
<input type="hidden" name="datesreq" value="<?php echo $datesreq; ?>">
<?php if( $publicfield == "" ) $publicfield = "personID"; ?>
<input type="hidden" name="field" value="<?php echo $publicfield; ?>">
<?php if( $type == "" ) $type = "text"; ?>
<input type="hidden" name="type" value="<?php echo $type; ?>">
<?php
	if( $nameplusid ) echo "<input type=\"hidden\" name=\"nameplusid\" value=\"$nameplusid\">";
	if( $textchange ) echo "<input type=\"hidden\" name=\"textchange\" value=\"$textchange\">";
?>
<table border="0" cellspacing="0" cellpadding="2">
			<tr><td><span class="normal"><?php echo $text[lastname]; ?>: </span></td><td><input type="text" name="mylastname"></td></tr>
			<tr><td><span class="normal"><?php echo $text[firstname]; ?>: </span></td><td><input type="text" name="myfirstname"></td></tr>
</table><br/>
<input type="submit" value="<?php echo $text[search]; ?>"> <img src="<?php echo $cms['tngpath']; ?>spinner.gif" id="findspin" width="16" height="16" style="display:none">
</form>

</div>

<div class="databack" style="display:none;border:0px" id="findresults">
</div>
