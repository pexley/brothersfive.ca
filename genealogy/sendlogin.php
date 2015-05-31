<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "login";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;

//look up email
$email = trim( $email );

$valid_user_agent = isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"] != "";

if( eregi("\n[[:space:]]*(to|bcc|cc|boundary)[[:space:]]*[:|=].*@", $email) || !$valid_user_agent )
	die("sorry!");
if(eregi("\r", $email) || eregi("\n", $email) )
	die("sorry!");

$email = strtok( $email, ",; " );

if( $email ) {
	$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
	$sendmail = 0;

	//if username is there too, then look up based on username and get password
	if( $username ) {
		$newpassword = generatePassword(0);
		$query = "UPDATE $users_table SET password = \"" . md5($newpassword) . "\" WHERE email = \"$email\" AND username = \"$username\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$success = mysql_affected_rows( $link );

		if( $success ) {
			$sendmail = 1;
			if( $session_charset )
				$content = "<p>$text[newpass]: $newpassword</p>";
			else
				$content = "$text[newpass]: $newpassword";
			$message = $text[pwdsent];
			$headermessage = $text[loginsent];
		}
		else {
			$message = $text[loginnotsent3];
			$headermessage = $text[loginnotsent];
		}
	}
	else {
		$query = "SELECT username FROM $users_table WHERE email = \"$email\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$row = mysql_fetch_assoc( $result );
		mysql_free_result($result);

		if( $row[username] ) {
			$sendmail = 1;
			if( $session_charset )
				$content = "<p>$text[logininfo]:</p>\n\n<p>$text[username]: $row[username]</p>";
			else
				$content = "$text[logininfo]:\n\n$text[username]: $row[username]";
			$message = $text[usersent];
			$headermessage = $text[loginsent];
		}
		else {
			$message = $text[loginnotsent2];
			$headermessage = $text[loginnotsent];
		}
	}

	if( $sendmail ) {
		if( $session_charset ) {
			$mailmessage = "<html>\n<head>\n<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\">\n</head>\n<body>\n$content</body>\n</html>\n";
			$headers = "MIME-Version: 1.0\nContent-type: text/html; charset=$session_charset\nFrom: $emailaddr\nReply-to: $emailaddr";
		}
		else {
			$mailmessage = $content;
			$owner = $sitename ? $sitename : $dbowner;
			$headers = "From: $owner <$emailaddr>\nReply-to: $emailaddr";
		}
		@mail( $email, $text[logininfo], $mailmessage, $headers );
	}
}

tng_header( $headermessage, $flags );
echo "<p class=\"header\">$headermessage</span></p>\n";
echo tng_coreicons();
echo "<span class=\"normal\">\n";
echo "<p>$message</p>";
echo "</span>";

tng_footer( "" );
?>
