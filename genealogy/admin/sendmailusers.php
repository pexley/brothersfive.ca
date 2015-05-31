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

if( $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}
if( $gedcom ) {
	$wherestr = " AND gedcom=\"$gedcom\"";
	if( $branch )
		$wherestr .= " AND branch=\"$branch\"";
}

$recipientquery = "SELECT realname, email FROM $users_table WHERE allow_living != \"-1\" AND email != \"\" AND (no_email is NULL or no_email != \"1\") $wherestr";
$result = mysql_query($recipientquery) or die ("$admtext[cannotexecutequery]: $recipientquery");
$numrows = mysql_num_rows( $result );

if ( !$numrows ) {
	$message = $admtext[nousers];
	header( "Location: users.php?message=" . urlencode($message) );
}
else {
	$subject = stripslashes($subject);

	if( $session_charset ) {
		$body = "<html>\n<head>\n<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\">\n</head>\n<body>\n" . nl2br(stripslashes($messagetext)) . "</body>\n</html>\n";
		$headers = "MIME-Version: 1.0\nContent-type: text/html; charset=$session_charset\nFrom: $emailaddr\nReply-to: $emailaddr\nReturn-Path: $emailaddr";
	}
	else	{
		$owner = $sitename ? $sitename : $dbowner;
		$headers = "From: $owner <$emailaddr>\nReply-to: $emailaddr\nReturn-Path: $emailaddr";
		$body = stripslashes($messagetext);
	}

	while( $row = mysql_fetch_assoc($result)) {
		$recipient = $row[email];
		mail( $recipient, $subject, $body, $headers );
	}

	adminwritelog( "$admtext[sentmailmessage]" );
	$message = "$admtext[succmail].";
}

mysql_free_result($result);

header( "Location: mailusers.php?message=" . urlencode($message) );
?>
