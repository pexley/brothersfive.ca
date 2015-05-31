<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "login";
include($cms['tngpath'] . "$language/text.php");
$deftext = $text;
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($subroot . "logconfig.php");

$valid_user_agent = isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"] != "";

$emailfield = $_SESSION['tng_email'];
if(!$emailfield) {
	header("location:newacctform.php");
	exit;
}
eval("\$email = \$$emailfield;");
$_SESSION['tng_email'] = "";
session_unregister('tng_email');

if( eregi("\n[[:space:]]*(to|bcc|cc|boundary)[[:space:]]*[:|=].*@", $email) || !$valid_user_agent )
	die("sorry!");
if(eregi("\r", $email) || eregi("\n", $email) )
	die("sorry!");
if( eregi("\n[[:space:]]*(to|bcc|cc|boundary)[[:space:]]*[:|=].*@", $username) || !$valid_user_agent )
	die("sorry!");
if(eregi("\r", $email) || eregi("\n", $username) )
	die("sorry!");

$realname = strtok( $realname, ",;" );
if( strpos($email,",") !== false || strpos($email,";") !== false || !$email) die("sorry!");

if( $addr_exclude ) {
	$bad_addrs = explode(",", $addr_exclude);
	foreach( $bad_addrs as $bad_addr ) {
		if( $bad_addr ) {
			if( strstr( $email, trim($bad_addr) ) )
				die("sorry");
		}
	}
}

if( $msg_exclude ) {
	$bad_msgs = explode(",", $msg_exclude);
	foreach( $bad_msgs as $bad_msg ) {
		if( $bad_msg ) {
			if( strstr( $username, trim($bad_msg) ) || strstr( $password, trim($bad_msg) ) || strstr( $realname, trim($bad_msg) ) || strstr( $notes, trim($bad_msg) ) )
				die("sorry");
		}
	}
}

if (get_magic_quotes_gpc() == 0) {
	$username = addslashes($username);
	$password = addslashes($password);
	$gedcom = addslashes($gedcom);
	$realname = addslashes($realname);
	$phone = addslashes($phone);
	$email = addslashes($email);
	$website = addslashes($website);
	$address = addslashes($address);
	$city = addslashes($city);
	$state = addslashes($state);
	$zip = addslashes($zip);
	$country = addslashes($country);
	$notes = addslashes($notes);
}
$username = trim( $username );
$password = trim( $password );
$realname = trim( $realname );
$email = trim( $email );
$today = date( "Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

if( $username && $password && $realname && $email && $fingerprint == "realperson" ) {
	$query = "INSERT IGNORE INTO $users_table (description,username,password,realname,phone,email,website,address,city,state,zip,country,notes,gedcom,allow_living,dt_registered) VALUES (\"$realname\",\"$username\",\"$password\",\"$realname\",\"$phone\",\"$email\",\"$website\",\"$address\",\"$city\",\"$state\",\"$zip\",\"$country\",\"$notes\",\"$gedcom\",-1,\"$today\")";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$success = mysql_affected_rows( $link );
}
else
	$success = 0;

tng_header( $text[regnewacct], $flags );

echo "<p class=\"header\">$text[regnewacct]</span></p><br />\n";
echo tng_coreicons();
echo "<span class=\"normal\">\n";
if( $success ) {
	echo "<p>$text[success]</p>";
	if( $emailaddr ) {
		if( $session_charset ) {
			$message = "<html>\n<head>\n<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\">\n</head>\n<body>\n<p>$deftext[username]: $username</p>\n\n<p>" . nl2br($deftext[emailmsg]) . "</p><p>$text[administration]: <a href=\"$tngdomain/admin\">$tngdomain/admin</a></p></body>\n</html>\n";
			$headers = "MIME-Version: 1.0\nContent-type: text/html; charset=$session_charset\nFrom: $email\nReply-to: $email\nReturn-Path: $emailaddr";
		}
		else {
			$message = "$deftext[username]: $username\n\n$deftext[emailmsg]\n\n$text[administration]: $tngdomain/admin";
			$headers = "From: $realname <$email>\nReply-to: $email\nReturn-Path: $emailaddr";
		}
		@mail( $emailaddr, $deftext[emailsubject], $message, $headers );
	}
}
else
	echo "<p>$text[failure]</p>";
echo "</span>";

tng_footer( "" );
?>
