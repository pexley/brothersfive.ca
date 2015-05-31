<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "events";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$query = "SELECT display, $events_table.eventtypeID as eventtypeID, eventdate, eventplace, age, agency, cause, $events_table.gedcom as gedcom, $events_table.addressID, address1, address2, city, state, zip, country, info, phone, email, www FROM ($events_table, $eventtypes_table) LEFT JOIN $address_table on $events_table.addressID = $address_table.addressID WHERE eventID = \"$eventID\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row[eventplace] = ereg_replace("\"", "&#34;",$row[eventplace]);
$row[info] = ereg_replace("\"", "&#34;",$row[info]);
$row[age] = ereg_replace("\"", "&#34;",$row[age]);
$row[agency] = ereg_replace("\"", "&#34;",$row[agency]);
$row[cause] = ereg_replace("\"", "&#34;",$row[cause]);
$row[address1] = ereg_replace("\"", "&#34;",$row[address1]);
$row[address1] = ereg_replace("\"", "&#34;",$row[address1]);
$row[city] = ereg_replace("\"", "&#34;",$row[city]);
$row[state] = ereg_replace("\"", "&#34;",$row[state]);
$row[zip] = ereg_replace("\"", "&#34;",$row[zip]);
$row[country] = ereg_replace("\"", "&#34;",$row[country]);

$display = getEventDisplay( $row[display] );

$helplang = findhelp("events_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px">
<p class="subhead"><strong><?php echo $admtext[modifyevent]; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/events_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext[help]; ?></a></p>
<form action="" method="post" name="form1" onSubmit="return updateEvent(this);" style="margin:0px;">
<table border="0" cellpadding="2" class="normal">
	<tr><td valign="top"><span class="normal"><?php echo $admtext['eventtype']; ?>:</span></td>
		<td>
			<span class="normal"><?php echo "$row[tag] $display"; ?>
			</span>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['eventdate']; ?>:</span></td><td><input type="text" name="eventdate" value="<?php echo $row['eventdate']; ?>" onBlur="checkDate(this);"> <span class="normal"><?php echo $admtext[dateformat]; ?>:</span></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['eventplace']; ?>:</span></td><td valign="top"><input type="text" name="eventplace" id="eventplace" size="40" value="<?php echo $row['eventplace']; ?>"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
		<a href="#" onclick="return openFindPlaceForm('eventplace');"><img src="tng_find.gif" style="vertical-align:-3px" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?> class="smallicon"/></a></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['detail']; ?>:</span></td><td><textarea name="info" rows="4" cols="40"><?php echo $row['info']; ?></textarea></td></tr>
</table>
<?php echo displayToggle("plus9",0,"more",$admtext['more'],""); ?>
<br />
<div id="more" style="display:none">
<table border="0" cellpadding="2" class="normal">
	<tr><td valign="top"><span class="normal"><?php echo $admtext['age']; ?>:</span></td><td><input type="text" name="age" size="12" maxlength="12" value="<?php echo $row['age']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['agency']; ?>:</span></td><td><input type="text" name="agency" size="40" value="<?php echo $row['agency']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['cause']; ?>:</span></td><td><input type="text" name="cause" size="40" value="<?php echo $row['cause']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['address1']; ?>:</span></td><td><input type="text" name="address1" size="40" value="<?php echo $row['address1']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['address2']; ?>:</span></td><td><input type="text" name="address2" size="40" value="<?php echo $row['address2']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['city']; ?>:</span></td><td><input type="text" name="city" size="40" value="<?php echo $row['city']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['stateprov']; ?>:</span></td><td><input type="text" name="state" size="40" value="<?php echo $row['state']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['zip']; ?>:</span></td><td><input type="text" name="zip" size="20" value="<?php echo $row['zip']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['countryaddr']; ?>:</span></td><td><input type="text" name="country" size="40" value="<?php echo $row['country']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['phone']; ?>:</span></td><td><input type="text" name="phone" size="30" value="<?php echo $row['phone']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['email']; ?>:</span></td><td><input type="text" name="email" size="50" value="<?php echo $row['email']; ?>"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['website']; ?>:</span></td><td><input type="text" name="www" size="50" value="<?php echo $row['www']; ?>"></td></tr>
</table>
<br />
</div>
<input type="hidden" name="addressID" value="<?php echo $row['addressID']; ?>">
<input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
<input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
<input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
<input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onclick="tnglitbox.remove();">
</form>
<br />
</div>
