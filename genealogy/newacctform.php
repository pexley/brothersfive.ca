<?php
include("begin.php");
if($cms['events']){include('cmsevents.php'); cms_register();}
include($cms['tngpath'] . "genlib.php");
$textpart = "login";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;

$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$numtrees = mysql_num_rows( $treeresult );

$query = "SELECT count(userID) as ucount FROM $users_table";
$userresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $userresult );
$ucount = $row[ucount];
mysql_free_result($userresult);

$_SESSION['tng_email'] = generatePassword(1);

tng_header( $text[regnewacct], $flags );
?>
<script type="text/javascript">
function validateForm( ) {
	var rval = true;
	if( document.form1.username.value.length == 0 ) {
		alert("<?php echo $text[enterusername]; ?>");
		rval = false;
	}
	else if( document.form1.password.value.length == 0 ) {
		alert("<?php echo $text[enterpassword]; ?>");
		rval = false;
	}
	else if( document.form1.realname.value.length == 0 ) {
		alert("<?php echo $text[enterrealname]; ?>");
		rval = false;
	}
	else if( document.form1.<?php echo $_SESSION['tng_email']; ?>.value.length == 0 || document.form1.<?php echo $_SESSION['tng_email']; ?>.value.indexOf(".") < 1 || document.form1.<?php echo $_SESSION['tng_email']; ?>.value.indexOf("@") <= 0 ) {
		alert("<?php echo $text[enteremail]; ?>");
		document.form1.<?php echo $_SESSION['tng_email']; ?>.value = "";
		rval = false;
	}
	return rval;
}	
</script>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_log2.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text['regnewacct']; ?></p><br clear="left"/>
<?php 
echo tng_coreicons();

@include($cms['tngpath'] . "TNG_captcha.php");

if(!$tngconfig['disallowreg']) {
	echo "<p class=\"normal\"><strong>*$text[required]</strong></p>\n";
?>
<table border="0" cellpadding="0" cellspacing="2">
<tr>
<td>
<?php
	$formstr = getFORM( "addnewacct", "post", "form1", "" );
	echo $formstr;
?>
	<table>
		<tr><td valign="top"><span class="normal"><?php echo $text[username]; ?>*:</span></td><td><span class="normal"><input type="text" name="username" size="20" maxlength="20" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[password]; ?>*:</span></td><td><span class="normal"><input type="password" name="password" size="20" maxlength="20" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[realname]; ?>*:</span></td><td><span class="normal"><input type="text" name="realname" size="50" maxlength="50" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[phone]; ?>:</span></td><td><span class="normal"><input type="text" name="phone" size="30" maxlength="30" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[email]; ?>*:</span></td><td><span class="normal"><input type="text" name="<?php echo $_SESSION['tng_email']; ?>" size="50" maxlength="100" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[website]; ?>:</span></td><td><span class="normal"><input type="text" name="website" size="50" maxlength="100" value="http://" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[address]; ?>:</span></td><td><span class="normal"><input type="text" name="address" size="50" maxlength="100" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[city]; ?>:</span></td><td><span class="normal"><input type="text" name="city" size="50" maxlength="64" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[state]; ?>:</span></td><td><span class="normal"><input type="text" name="state" size="50" maxlength="64" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[zip]; ?>:</span></td><td><span class="normal"><input type="text" name="zip" size="20" maxlength="10" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[country]; ?>:</span></td><td><span class="normal"><input type="text" name="country" size="50" maxlength="64" /></span></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $text[comments]; ?>:</span></td><td><span class="normal"><textarea cols="50" rows="4" name="notes"></textarea></span></td></tr>
<?php
	if( $numtrees ) {
?>
		<tr><td valign="top">
		<span class="normal"><?php echo $text[tree]; ?>:</span></td><td><span class="normal">
			<select name="gedcom">
				<option value=""></option>
<?php
		while( $treerow = mysql_fetch_assoc($treeresult) ) {
			echo "	<option value=\"$treerow[gedcom]\">$treerow[treename]</option>\n";
		}
?>
			</select> <?php echo $text[leaveblank]; ?></span>
			</td>
		</tr>
<?php
	}
?>
	</table>
	<p class="normal"><?php echo $text[accmail]; ?></p>
	<br/>
	<input type="hidden" name="fingerprint" value="realperson">
	<input type="submit" name="submit" value="<?php echo $text[submit]; ?>" onclick="<?php if($ucount) echo "return validateForm();"; else echo "alert('$text[nousers]');return false;"; ?>" /></form><br/>
</td>
</tr>

</table>
<?php
}
else
	echo "<p class=\"normal\">$text[noregs]</p>\n";

tng_footer( "" );
?>
