<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "trees";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedtree || !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

$gedcom = ereg_replace(" ", "", $gedcom);
$treenamedisp = stripslashes($treename);
if (get_magic_quotes_gpc() == 0) {
	$treename = addslashes($treename);
	$description = addslashes($description);
	$owner = addslashes($owner);
	$email = addslashes($email);
	$address = addslashes($address);
	$city = addslashes($city);
	$state = addslashes($state);
	$country = addslashes($country);
	$zip = addslashes($zip);
	$phone = addslashes($phone);
}
$query = "INSERT IGNORE INTO $trees_table (gedcom,treename,description,owner,email,address,city,state,country,zip,phone,secret,disallowgedcreate) VALUES (\"$gedcom\",\"$treename\",\"$description\",\"$owner\",\"$email\",\"$address\",\"$city\",\"$state\",\"$country\",\"$zip\",\"$phone\",\"$private\",\"$disallowgedcreate\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$success = mysql_affected_rows( );
if( $success ) {
	adminwritelog( "<a href=\"edittree.php?tree=$gedcom\">$admtext[addnewtree]: $gedcom/$treename</a>" );

	$message = "$admtext[tree] $treenamedisp $admtext[succadded].";
	if( $beforeimport == "yes" )
		echo "1";
	else
		header( "Location: trees.php?message=" . urlencode($message) );
}
else {
	$message = "$admtext[treeexists]";
	if($beforeimport)
		echo $message;
	else
		header( "Location: newtree.php?message=" . urlencode($message) . "&treename=$treename&description=$description&owner=$owner&email=$email&address=$address&city=$city&state=$state&country=$country&zip=$zip&phone=$phone&private=$private&disallowgedcreate=$disallowgedcreate" );
}
?>