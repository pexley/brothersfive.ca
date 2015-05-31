<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "events";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_add ) {
	$message = "$admtext[norights]";
	exit;
}

require("datelib.php");
require("adminlog.php");

$personID = ucfirst( $personID );

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
	$phone = utf8_decode($phone);
	$email = utf8_decode($email);
	$www = utf8_decode($www);
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

$query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,zoom) VALUES (\"$tree\",\"$eventplace\",\"0\",\"0\")";
$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");

if( $address1 || $address2 || $city || $state || $zip || $country || $phone || $email || $www ) {
	$query = "INSERT INTO $address_table (address1, address2, city, state, zip, country, gedcom, phone, email, www)  VALUES(\"$address1\", \"$address2\", \"$city\", \"$state\", \"$zip\", \"$country\", \"$tree\", \"$phone\", \"$email\", \"$www\")";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$addressID = mysql_insert_id();
}
else
	$addressID = "";

$query = "INSERT INTO $events_table (eventtypeID, persfamID, eventdate, eventdatetr, eventplace, age, agency, cause, addressID, info, gedcom, parenttag)  VALUES(\"$eventtypeID\", \"$persfamID\", \"$eventdate\", \"$eventdatetr\", \"$eventplace\", \"$age\", \"$agency\", \"$cause\", \"$addressID\", \"$info\", \"$tree\", \"\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$eventID = mysql_insert_id();

adminwritelog( "$admtext[addnewevent]: $eventtypeID/$tree/$persfamID" );

$query = "SELECT display FROM $eventtypes_table WHERE eventtypeID = \"$eventtypeID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc($result);

$display = htmlspecialchars(getEventDisplay( $row[display] ), ENT_QUOTES);

$info = ereg_replace("\r"," ",$info);
$info = htmlspecialchars(ereg_replace("\n"," ",$info), ENT_QUOTES);
$truncated = substr($info,0,90);
$info = strlen($info) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $info;

//echo "{'eventID':'$eventID','display':'$display','eventdate':'$eventdate','eventplace':'$eventplace','info':'$info','allow_edit':'$allow_edit','allow_delete':'$allow_delete','editmsg':'$admtext[edit]','delmsg':'$admtext[text_delete]'}";
header("Content-type:text/html; charset=" . $session_charset);
if($eventID)
	echo "{\"id\":\"$eventID\",\"display\":\"$display\",\"eventdate\":\"$eventdate\",\"eventplace\":\"$eventplace\",\"info\":\"" . stripslashes($info) . "\",\"allow_edit\":$allow_edit,\"allow_delete\":$allow_delete}";
else
	echo "{\"id\":0}";
?>