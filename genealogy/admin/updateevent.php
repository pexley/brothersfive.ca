<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "events";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit ) {
	exit;
}

require("datelib.php");
require("adminlog.php");

if($session_charset != "UTF-8") {
	$eventplace = utf8_decode($eventplace);
	$info = utf8_decode($info);
	$age = utf8_decode($age);
	$agency = utf8_decode($agency);
	$cause = utf8_decode($cause);
	$address1 = utf8_decode($address1);
	$address2 = utf8_decode($address2);
	$city = utf8_decode($city);
	$state = utf8_decode($state);
	$zip = utf8_decode($zip);
	$country = utf8_decode($country);
}

if (get_magic_quotes_gpc() == 0) {
	$eventdate = addslashes($eventdate);
	$eventplace = addslashes($eventplace);
	$info = addslashes($info);
	$age = addslashes($age);
	$agency = addslashes($agency);
	$cause = addslashes($cause);
	$address1 = addslashes($address1);
	$address2 = addslashes($address2);
	$city = addslashes($city);
	$state = addslashes($state);
	$zip = addslashes($zip);
	$country = addslashes($country);
	$phone = addslashes($phone);
	$email = addslashes($email);
	$www = addslashes($www);
}

$eventdatetr = convertDate( $eventdate );

if( $addressID ) {
	if( $address1 || $address2 || $city || $state || $zip || $country || $phone || $email || $www )
		$query = "UPDATE $address_table SET address1=\"$address1\", address2=\"$address2\", city=\"$city\", state=\"$state\", zip=\"$zip\", country=\"$country\", gedcom=\"$tree\", phone=\"$phone\", email=\"$email\", www=\"$www\" WHERE addressID = \"$addressID\"";
	else {
		$query = "DELETE FROM $address_table WHERE addressID = \"$addressID\"";
		$addressID = "";
	}
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}
elseif( $address1 || $address2 || $city || $state || $zip || $country || $phone || $email || $www ) {
	$query = "INSERT INTO $address_table (address1, address2, city, state, zip, country, gedcom, phone, email, www)  VALUES(\"$address1\", \"$address2\", \"$city\", \"$state\", \"$zip\", \"$country\", \"$tree\", \"$phone\", \"$email\", \"$www\")";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$addressID = mysql_insert_id();
}

$query = "UPDATE $events_table SET eventdate=\"$eventdate\", eventdatetr=\"$eventdatetr\", eventplace=\"$eventplace\", age=\"$age\", agency=\"$agency\", cause=\"$cause\", addressID=\"$addressID\", info=\"$info\" WHERE eventID=\"$eventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,zoom) VALUES (\"$tree\",\"$eventplace\",\"0\",\"0\")";
$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$admtext[modifyevent]: $eventID" );

$query = "SELECT display FROM $eventtypes_table, $events_table WHERE $eventtypes_table.eventtypeID = $events_table.eventtypeID AND eventID = \"$eventID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc($result);

$display = getEventDisplay( $row[display] );

$info = ereg_replace("\r"," ",$info);
$info = htmlspecialchars(ereg_replace("\n"," ",$info), ENT_QUOTES);
$truncated = substr($info,0,90);
$info = strlen($info) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $info;

//echo "{'eventID':'$eventID','display':'$display','eventdate':'$eventdate','eventplace':'$eventplace','info':'$info','allow_edit':'$allow_edit','allow_delete':'$allow_delete','editmsg':'$admtext[edit]','delmsg':'$admtext[text_delete]'}";
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"display\":\"$display\",\"eventdate\":\"$eventdate\",\"eventplace\":\"" . stripslashes($eventplace) . "\",\"info\":\"" . stripslashes($info) . "\"}";
?>