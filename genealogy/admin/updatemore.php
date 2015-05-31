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

require("adminlog.php");

$rval = 0;

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

if( $addressID ) {
	if( $address1 || $address2 || $city || $state || $zip || $country || $phone || $email || $www ) {
		$query = "UPDATE $address_table SET address1=\"$address1\", address2=\"$address2\", city=\"$city\", state=\"$state\", zip=\"$zip\", country=\"$country\", phone=\"$phone\", email=\"$email\", www=\"$www\" WHERE addressID = \"$addressID\"";
		$rval = 1;
	}
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
	$rval = 1;
}

if( $eventID ) {
	//if nothing, then delete the event
	if( $age || $agency || $cause || $addressID || $info ) {
		$query = "UPDATE $events_table SET age=\"$age\", agency=\"$agency\", cause=\"$cause\", addressID=\"$addressID\", info=\"$info\" WHERE eventID=\"$eventID\"";
		$rval = 1;
	}
	else
		$query = "DELETE FROM $events_table WHERE eventID=\"$eventID\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	adminwritelog( "$admtext[modifyevent]: $eventID" );
}
else {
	$query = "INSERT INTO $events_table (eventtypeID, persfamID, age, agency, cause, addressID, info, gedcom, parenttag, eventdate, eventdatetr, eventplace)  VALUES(0, \"$persfamID\", \"$age\", \"$agency\", \"$cause\", \"$addressID\", \"$info\", \"$tree\", \"$eventtypeID\", \"\", \"0000-00-00\", \"\")";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	adminwritelog( "$admtext[addnewevent]: $eventtypeID/$tree/$persfamID" );
	$rval = 1;
}
echo $rval;
?>