<?php
include("begin.php");
$tngconfig['maint'] = "";
include($cms['tngpath'] . "genlib.php");
$textpart = "login";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "log.php" );

session_start();
//$_SESSION[destinationpage] = $HTTP_REFERER;

tng_header( $text[login], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_log2.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text[login]; ?></p><br clear="left"/>

<?php
	if( $message ) {
?>
	<font color="#FF0000"><span class="normal"><em><?php echo $text[$message]; ?></em>
	</span></font>
<?php
	}

$formstr = getFORM( "processlogin", "post", "form1", "" );
echo $formstr;
?>
<table>
<tr>
	<td><span class="normal"><?php echo $text[username]; ?>:</span></td>
	<td><input type="text" name="tngusername" size="20" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[password]; ?>:</span></td>
	<td><input type="password" name="tngpassword" size="20" /></td>
</tr>
<tr id="resetrow" style="display:none">
	<td><span class="normal"><?php echo $text[newpassword]; ?>:</span></td>
	<td><input type="password" name="newpassword" size="20" /></td>
</tr>
<tr>
	<td colspan="2">
		<span class="normal">
		<input type="checkbox" name="remember" value="1" /> <?php echo $text[rempass]; ?><br />
		<input type="checkbox" name="resetpass" value="1" onclick="if(this.checked) {document.getElementById('resetrow').style.display='';} else {document.getElementById('resetrow').style.display='none';}" /> <?php echo $text[resetpass]; ?>
		</span>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" value="<?php echo $text[login]; ?>" /></td>
</tr>
</table>
</form>
<br/><br/><br/>
<?php
$formstr = getFORM( "sendlogin", "POST", "form2", "" );
echo $formstr;
?>
<table width="400">
	<tr>
		<td colspan="2"><span class="normal"><?php echo $text[forgot1]; ?></span></td>
	</tr>
	<tr>
		<td><span class="normal"><?php echo $text[email]; ?>:</span></td>
		<td width="90%"><input type="text\" name="email"> <input type="submit" value="<?php echo $text[go]; ?>" /></td>
	</tr>
	<tr>
		<td colspan="2"><span class="normal"><br /><?php echo $text[forgot2]; ?></span></td>
	</tr>
	<tr>
		<td><span class="normal"><?php echo $text[username]; ?>:</span></td>
		<td width="90%"><input type="text" name="username" /> <input type="submit" value="<?php echo $text[go]; ?>" /></td>
	</tr>
</table>
<?php
if(!$tngconfig['disallowreg'])
	echo "<p>$text[nologin] <a href=\"newacctform.php\">$text[regnewacct]</a></p>";
?>
</form><br/>
<script type="text/javascript">
	document.form1.tngusername.focus();
</script>
<?php
tng_footer( "" );
?>
