<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$tree = $tree1;
if( !$allow_add || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

$repoID = ucfirst( $repoID );

if (get_magic_quotes_gpc() == 0) {
	$reponame = addslashes($reponame);
	$address1 = addslashes($address1);
	$address2 = addslashes($address2);
	$city = addslashes($city);
	$state = addslashes($state);
	$zip = addslashes($zip);
	$country = addslashes($country);
}

$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

if( $address1 || $address2 || $city || $state || $zip || $country ) {
	$query = "INSERT INTO $address_table (address1, address2, city, state, zip, country, gedcom)  VALUES(\"$address1\", \"$address2\", \"$city\", \"$state\", \"$zip\", \"$country\", \"$tree\")";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$addressID = mysql_insert_id();
}
else
	$addressID = "";

if( !$addressID ) $addressID = 0;
$query = "INSERT INTO $repositories_table (repoID,reponame,addressID,changedate,gedcom,changedby) VALUES (\"$repoID\",\"$reponame\",\"$addressID\",\"$newdate\",\"$tree1\",\"$currentuser\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "<a href=\"editrepo.php?repoID=$repoID&tree=$tree\">$admtext[addnewrepo]: $tree/$repoID</a>" );

header( "Location: editrepo.php?repoID=$repoID&tree=$tree" );
?>
