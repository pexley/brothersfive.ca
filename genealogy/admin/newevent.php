<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "events";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

$helplang = findhelp("events_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px">
<p class="subhead"><strong><?php echo $admtext[addnewevent]; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/events_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext[help]; ?></a></p>
<?php
	if( $message ) {
?>
	<font color="#FF0000"><span class="normal"><em><?php echo urldecode($message); ?></em>
	</span></font>
<?php
	}
?>
<form action="" method="post" name="form1" onSubmit="return addEvent(this);" style="margin:0px">
<table border="0" cellpadding="2" class="normal">
	<tr><td valign="top"><span class="normal"><?php echo $admtext[eventtype]; ?>:</span></td>
		<td>
			<span class="normal">
			<select name="eventtypeID">
				<option value=""></option>
<?php
	$query = "SELECT * FROM $eventtypes_table WHERE type = \"$prefix\" ORDER BY tag";
	$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	while ( $eventtype = mysql_fetch_assoc( $evresult ) ) {
		$display = getEventDisplay( $eventtype[display] );
		$option = "$eventtype[tag] - $display";
		$optionlen = strlen($option);
		$option = substr("$eventtype[tag] - $display",0,40);
		if($optionlen > strlen($option))
			$option .= "&hellip;";
		echo "<option value=\"$eventtype[eventtypeID]\">$option</option>\n";
	}
	mysql_free_result($evresult);
?>
			</select>
			</span>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['eventdate']; ?>:</span></td><td><input type="text" name="eventdate" onBlur="checkDate(this);"> <span class="normal"><?php echo $admtext[dateformat]; ?>:</span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['eventplace']; ?>:</span></td><td valign="top"><input type="text" name="eventplace" id="eventplace" size="40"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
		<a href="#" onclick="return openFindPlaceForm('eventplace');"><img src="tng_find.gif" style="vertical-align:bottom;padding-bottom:2px;" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?> class="smallicon"/></a></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['detail']; ?>:</span></td><td><textarea name="info" rows="4" cols="40"></textarea></td></tr>
</table>
<?php echo displayToggle("plus9",0,"more",$admtext['more'],""); ?>
<br />
<div id="more" style="display:none">
<table border="0" cellpadding="2" class="normal">
	<tr><td valign="top"><span class="normal"><?php echo $admtext['age']; ?>:</span></td><td><input type="text" name="age" size="12" maxlength="12"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['agency']; ?>:</span></td><td><input type="text" name="agency" size="40"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['cause']; ?>:</span></td><td><input type="text" name="cause" size="40"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['address1']; ?>:</span></td><td><input type="text" name="address1" size="40"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['address2']; ?>:</span></td><td><input type="text" name="address2" size="40"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['city']; ?>:</span></td><td><input type="text" name="city" size="40"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['stateprov']; ?>:</span></td><td><input type="text" name="state" size="40"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['zip']; ?>:</span></td><td><input type="text" name="zip" size="20"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['countryaddr']; ?>:</span></td><td><input type="text" name="country" size="40"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['phone']; ?>:</span></td><td><input type="text" name="phone" size="30"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['email']; ?>:</span></td><td><input type="text" name="email" size="50"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['website']; ?>:</span></td><td><input type="text" name="www" size="50"></td></tr>
</table>
<br />
</div>
<input type="hidden" name="persfamID" value="<?php echo $persfamID; ?>">
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
<input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onclick="tnglitbox.remove();">
</form>
<br />
</div>
