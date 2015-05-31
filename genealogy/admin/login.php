<?php
include("../subroot.php");
include($subroot . "config.php");
$tngconfig['maint'] = "";
include("adminlib.php");
$textpart = "login";
include("../getlang.php");
include("../$mylanguage/admintext.php");

if($_SESSION['logged_in'] && $allow_admin) {
	header("Location:index.php");
	$reset = 1;
}
if( $email ) {
	$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
	$sendmail = 0;

	//if username is there too, then look up based on username and get password
	if( $username ) {
		$newpassword = generatePassword(0);
		$query = "UPDATE $users_table SET password = \"" . md5($newpassword) . "\" WHERE email = \"$email\" AND username = \"$username\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$success = mysql_affected_rows( $link );

		if( $success ) {
			$sendmail = 1;
			if( $session_charset )
				$content = "<p>$text[newpass]: $newpassword</p>";
			else
				$content = "$text[newpass]: $newpassword";
			$message = $text['pwdsent'];
		}
		else
			$message = $text['loginnotsent3'];
	}
	else {
		$query = "SELECT username FROM $users_table WHERE email = \"$email\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$row = mysql_fetch_assoc( $result );
		mysql_free_result($result);

		if( $row[username] ) {
			$sendmail = 1;
			if( $session_charset )
				$content = "<p>$text[logininfo]:</p>\n\n<p>$admtext[username]: $row[username]</p>";
			else
				$content = "$text[logininfo]:\n\n$admtext[username]: $row[username]";
			$message = $text[usersent];
		}
		else
			$message = $text[loginnotsent2];
	}

	if( $sendmail ) {
		if( $session_charset ) {
			$mailmessage = "<html>\n<head>\n<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\">\n</head>\n<body>\n$content</body>\n</html>\n";
			$headers = "MIME-Version: 1.0\nContent-type: text/html; charset=$session_charset\nFrom: $emailaddr\nReply-to: $emailaddr";
		}
		else {
			$mailmessage = $content;
			$headers = "From: $dbowner <$emailaddr>\nReply-to: $emailaddr";
		}
		@mail( $email, $text[logininfo], $mailmessage, $headers );
	}
}

if( $cms[support] )
	$home_url = "../../../$homepage";
else
	$home_url = "../$homepage";

$newroot = ereg_replace( "/", "", $rootpath );
$newroot = ereg_replace( " ", "", $newroot );
$newroot = ereg_replace( "\.", "", $newroot );
$loggedin = "tngloggedin_$newroot";

if( !$_SESSION['logged_in'] && $_COOKIE[$loggedin] && !$reset) {
//if(1) {
	session_start();
	session_unset();
	session_destroy();
	setcookie("tngloggedin_$newroot", ""); 
	tng_adminheader( $admtext[login], "" );
?>	
</head>
<body class="databack" style="margin:10px;border:0px">
<p><?php echo $admtext['sessexp']; ?> <a href="login.php?reset=1" target="_top"><?php echo $admtext['logagain']; ?></a></p>
</body>
<?php
}
else {
	tng_adminheader( $admtext['login'], "" );
?>
</head>

<?php

if($reset) {
	$_COOKIE[$loggedin]="";
}
?>
<body background="../background.gif">
<table width="100%" border="0" cellpadding="10" bgcolor="#FFFFFF">
<tr class="fieldnameback">
	<td>
		<span class="whiteheader"><font size="6"><?php echo $admtext['login'] . ": " . $admtext['administration']; ?></font></span>
	</td>
</tr>
<?php
	if( $message ) {
?>
<tr>
<td>
	<font color="#FF0000"><span class="normal"><em><?php echo stripslashes(urldecode($message)); ?></em>
	</span></font>
</td>
</tr>
<?php
	}
?>
<tr class="databack">
<td class="tngshadow">
	<table>
		<tr>
			<td valign="top">
				<form action="processlogin.php" name="form1" method="POST" style="margin:0px">
				<table>
				<tr>
					<td><span class="normal"><?php echo $admtext['username']; ?>:</span></td>
					<td><input type="text" name="tngusername" size="20"></td>
				</tr>
				<tr>
					<td><span class="normal"><?php echo $admtext['password']; ?>:</span></td>
					<td><input type="password" name="tngpassword" size="20"></td>
				</tr>
				<tr>
					<td colspan="2"><span class="normal"><input type="checkbox" name="remember" value="1"> <?php echo $admtext['rempass']; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" value="<?php echo $admtext['login']; ?>"></td>
				</tr>
				</table>
				<p class="normal"><a href="<?php echo $home_url; ?>"><img src="../tng_home.gif" border="0" align="left" width="16" height="15" /><?php echo $admtext['publichome']; ?></a></p>
				</form>
			</td>
			<td width="50">&nbsp;&nbsp;&nbsp;</td>
			<td valign="top">
				<form action="login.php" name="form2" method="POST" style="margin:0px">
				<table width="400">
					<tr>
						<td colspan="2"><span class="normal"><?php echo $text['forgot1']; ?></span></td>
					</tr>
					<tr>
						<td nowrap><span class="normal"><?php echo $admtext['email']; ?>:</span></td>
						<td width="90%"><input type="text\" name="email"> <input type="submit" value="<?php echo $admtext['go']; ?>"></td>
					</tr>
					<tr>
						<td colspan="2"><span class="normal"><br /><?php echo $text['forgot2']; ?></span></td>
					</tr>
					<tr>
						<td nowrap><span class="normal"><?php echo $admtext['username']; ?>:</span></td>
						<td width="90%"><input type="text" name="username"> <input type="submit" value="<?php echo $admtext['go']; ?>"></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>
</div>
<SCRIPT language="JavaScript" type="text/javascript">
	document.form1.tngusername.focus();
</script>
</body>
<?php
}
?>
</html>
