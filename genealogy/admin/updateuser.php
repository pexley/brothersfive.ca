<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "users";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

require("adminlog.php");

if( $assignedtree || !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

if (get_magic_quotes_gpc() == 0) {
	$description = addslashes($description);
	$username = addslashes($username);
	$gedcom = addslashes($gedcom);
	$branches = addslashes($branch);
	$realname = addslashes($realname);
	$phone = addslashes($phone);
	$email = addslashes($email);
	$address = addslashes($address);
	$notes = addslashes($notes);
	$website = addslashes($website);
	$city = addslashes($city);
	$state = addslashes($state);
	$zip = addslashes($zip);
	$country = addslashes($country);
}

if( ($password != $orgpwd) || $newuser) {
	$password = md5($password);
}

if( !$form_allow_add ) $form_allow_add = 0;
if( !$form_allow_delete ) $form_allow_delete = 0;
if( $form_allow_edit == 1 ) {
	$form_tentative_edit = 0;
}
elseif( $form_allow_edit == 2 ) {
	$form_tentative_edit = 1;
	$form_allow_edit = 0;
}
else{
	$form_tentative_edit = 0;
	$form_allow_edit = 0;
}
if( !$form_allow_ged ) $form_allow_ged = 0;
if( !$form_allow_living ) $form_allow_living = 0;
if( !$form_allow_lds ) $form_allow_lds = 0;
if( !$no_email ) $no_email = 0;
$today = date( "Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

$query = "UPDATE $users_table SET description=\"$description\",username=\"$username\",password=\"$password\",realname=\"$realname\",phone=\"$phone\",email=\"$email\",website=\"$website\",address=\"$address\",city=\"$city\",state=\"$state\",zip=\"$zip\",country=\"$country\",notes=\"$notes\",gedcom=\"$gedcom\",allow_edit=\"$form_allow_edit\",allow_add=\"$form_allow_add\",tentative_edit=\"$form_tentative_edit\",allow_delete=\"$form_allow_delete\",allow_lds=\"$form_allow_lds\",allow_living=\"$form_allow_living\",allow_ged=\"$form_allow_ged\",branch=\"$branch\",dt_activated=\"$today\",no_email=\"$no_email\" WHERE userID=\"$userID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

if( $notify && $email ) {
	$owner = $sitename ? $sitename : $dbowner;
	if( $session_charset ) {
		$welcome = "<html>\n<head>\n<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\">\n</head>\n<body>\n" . nl2br($welcome) . "</body>\n</html>\n";
		$headers = "MIME-Version: 1.0\nContent-type: text/html; charset=$session_charset\nFrom: $owner <$emailaddr>\nReply-to: $emailaddr\nReturn-Path: $emailaddr";
	}
	else
		$headers = "From: $owner <$emailaddr>\nReply-to: $emailaddr\nReturn-Path: $emailaddr";

	@mail( $email, $admtext[activated], $welcome, $headers );
}
	
adminwritelog( "<a href=\"edituser.php?userID=$userID\">$admtext[modifyuser]: $userID</a>" );

$message = "$admtext[changestouser] $userID $admtext[succsaved].";
if( $newuser )
	header( "Location: reviewusers.php?message=" . urlencode($message) );
else
	header( "Location: users.php?message=" . urlencode($message) );
?>
