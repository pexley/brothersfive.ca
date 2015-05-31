<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "gedcom";
//include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$language/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
if($enttype)
	include($cms['tngpath'] . "checklogin.php");
include($subroot . "logconfig.php");

$valid_user_agent = isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"] != "";

$emailfield = $_SESSION['tng_email'];
eval("\$youremail = \$$emailfield;");
$_SESSION['tng_email'] = "";
session_unregister('tng_email');

$commentsfield = $_SESSION['tng_comments'];
eval("\$comments = \$$commentsfield;");
$_SESSION['tng_comments'] = "";
session_unregister('tng_comments');

$yournamefield = $_SESSION['tng_yourname'];
eval("\$yourname = \$$yournamefield;");
$_SESSION['tng_yourname'] = "";
session_unregister('tng_yourname');

$tngwebsite = $cms[support] ? "http://". $_SERVER['HTTP_HOST'] : $tngdomain;

if( eregi("\n[[:space:]]*(to|bcc|cc|boundary)[[:space:]]*[:|=].*@", $youremail) || eregi("[\r|\n][[:space:]]*(to|bcc|cc|boundary)[[:space:]]*[:|=].*@", $yourname) || !$valid_user_agent )
	die("sorry!");
if(eregi("\r", $youremail) || eregi("\n", $youremail) || eregi("\r", $yourname) || eregi("\n", $yourname) )
	die("sorry!");

$youremail = strtok( $youremail, ",; " );
if( !$youremail || !$comments || !$yourname ) die("sorry!");

if( $addr_exclude ) {
	$bad_addrs = explode(",", $addr_exclude);
	foreach( $bad_addrs as $bad_addr ) {
		if( $bad_addr ) {
			if( strstr( $youremail, trim($bad_addr) ) )
				die("sorry");
		}
	}
}

if( $msg_exclude ) {
	$bad_msgs = explode(",", $msg_exclude);
	foreach( $bad_msgs as $bad_msg ) {
		if( $bad_msg ) {
			if( strstr( $comments, trim($bad_msg) ) )
				die("sorry");
		}
	}
}

$suggest_url = getURL( "suggest", 1 );

if( $enttype == "I" ) {
	$typestr = "person";
	$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
		FROM $people_table, $trees_table WHERE personID = \"$ID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	$rightbranch = checkbranch( $row[branch] );
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$name = getName( $row ) . " ($ID)";
	$link = "$tngwebsite/" . getURL("getperson", 1) . "personID=$ID&tree=$tree";
	mysql_free_result($result);
}
elseif( $enttype == "F" ) {
	$typestr = "family";
	$query = "SELECT familyID, husband, wife, living, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"$ID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	$rightbranch = checkbranch( $row[branch] ) ? 1 : 0;
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$name = "$text[family]: " . getFamilyName( $row );
	$link = "$tngwebsite/" . getURL("familygroup", 1) . "familyID=$ID&tree=$tree";
	mysql_free_result($result);
}
elseif( $enttype == "S" ) {
	$query = "SELECT title FROM $sources_table WHERE sourceID = \"$ID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	$name = "$text[source]: $row[title] ($ID)";
	$link = "$tngwebsite/" . getURL("showsource", 1) . "sourceID=$ID&tree=$tree";
	mysql_free_result($result);
}
elseif( $enttype == "R" ) {
	$query = "SELECT reponame FROM $repositories_table WHERE repoID = \"$ID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	$name = "$text[repository]: $row[reponame] ($ID)";
	$link = "$tngwebsite/" . getURL("showrepo", 1) . "repoID=$ID&tree=$tree";
	mysql_free_result($result);
}
if( $enttype ) {
	$subject = "$text[proposed]: $name";
	$query = "SELECT treename FROM $trees_table WHERE gedcom=\"$tree\"";
	$treeresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$treerow = mysql_fetch_assoc( $treeresult );

	$body = "$text[proposed]: $name\n$text[tree]: $treerow[treename]\n$text[link]: $link\n\n$text[description]: " . stripslashes($comments) . "\n\n$yourname\n$youremail";

	$query = "SELECT email, owner FROM $trees_table WHERE gedcom=\"$tree\"";
	$treeresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$treerow = mysql_fetch_assoc( $treeresult );
	$sendemail = $treerow[email] ? $treerow[email] : $emailaddr;
	$owner = $treerow[owner] ? $treerow[owner] : ($sitename ? $sitename : $dbowner);
}
else {
	$subject = $text[comments2];
	$body = "$text[comments2]: " . stripslashes($comments) . "\n\n$yourname\n$youremail";

	$sendemail = $emailaddr;
	$owner = $sitename ? $sitename : $dbowner;
}
if($currentuser)
	$body .= "\n$text[user]: $currentuserdesc ($currentuser)";

if( $charset ) {
	$body = "<html>\n<head>\n<meta http-equiv=\"Content-type\" content=\"text/html; charset=$charset\">\n</head>\n<body>\n" . nl2br($body) . "</body>\n</html>\n";
	$headers = "MIME-Version: 1.0\nContent-type: text/html; charset=$charset\nFrom: $yourname <$youremail>\nReply-to: $youremail\nReturn-Path: $emailaddr";
}
else
	$headers = "From: $yourname <$youremail>\nReply-to: $youremail\nReturn-Path: $emailaddr";

$success = @mail( $sendemail, $subject, $body, $headers );
if( $success ) {
	$message = "mailsent";
	if( $mailme ) {
		if($charset)
			$headers = "MIME-Version: 1.0\nContent-type: text/html; charset=$charset\nFrom: $yourname <$youremail>\nReply-to: $youremail\nReturn-Path: $youremail";
		else
			$headers = "From: $yourname <$youremail>\nReply-to: $youremail\nReturn-Path: $youremail";
		@mail( $youremail, $subject, $body, $headers );
	}
}
else
	$message = "mailnotsent&sowner=$owner&ssendemail=$sendemail";
header( "Location: $suggest_url" . "enttype=$enttype&ID=$ID&tree=$tree&message=" . urlencode($message) );
?>
