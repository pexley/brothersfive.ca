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

if( $assignedtree || !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

if (get_magic_quotes_gpc() == 0) {
	$description = addslashes($description);
	$username = addslashes($username);
	$gedcom = addslashes($gedcom);
	$branch = addslashes($branch);
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
$orgpwd = $password;
$password = md5($password);
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

$query = "INSERT IGNORE INTO $users_table (description,username,password,realname,phone,email,website,address,city,state,zip,country,notes,gedcom,allow_edit,allow_add,tentative_edit,allow_delete,allow_lds,allow_living,allow_ged,branch,dt_activated,no_email) VALUES (\"$description\",\"$username\",\"$password\",\"$realname\",\"$phone\",\"$email\",\"$website\",\"$address\",\"$city\",\"$state\",\"$zip\",\"$country\",\"$notes\",\"$gedcom\",\"$form_allow_edit\",\"$form_allow_add\",\"$form_tentative_edit\",\"$form_allow_delete\",\"$form_allow_lds\",\"$form_allow_living\",\"$form_allow_ged\",\"$branch\",\"$today\",\"$no_email\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

if( $notify && $email ) {
	if( $session_charset ) {
		$welcome = "<html>\n<head>\n<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\">\n</head>\n<body>\n" . nl2br($welcome) . "</body>\n</html>\n";
		$headers = "MIME-Version: 1.0\nContent-type: text/html; charset=$session_charset\nFrom: $emailaddr\nReply-to: $emailaddr";
	}
	else {
		$owner = $sitename ? $sitename : $dbowner;
		$headers = "From: $owner <$emailaddr>\nReply-to: $emailaddr";
	}

	@mail( $email, $admtext[activated], $welcome, $headers );
}

if( mysql_affected_rows() ) {
	$userID = mysql_insert_id();
	adminwritelog( "<a href=\"edituser.php?userID=$userID\">$admtext[addnewuser]: $username</a>" );
	$message = "$admtext[user] $username $admtext[succadded].";
}
else
	$message = "$admtext[userfailed].";
header( "Location: users.php?message=" . urlencode($message) );
?>
