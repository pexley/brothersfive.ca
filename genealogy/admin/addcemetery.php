<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "cemeteries";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if( $newfile && $newfile != "none" ) {
	if( substr( $maplink, 0, 1 ) == "/" ) 
		$maplink = substr( $maplink, 1 );
	$newpath = "$rootpath$headstonepath/$maplink";
		
	if( @move_uploaded_file($newfile, $newpath) ) 
		@chmod( $newpath, 0644 );
	else {
		$message = "$admtext[mapnotcopied] $newpath $admtext[improperpermissions].";
		header( "Location: cemeteries.php?message=" . urlencode($message) );
		exit;
	}
}

if (get_magic_quotes_gpc() == 0) {
	$cemname = addslashes($cemname);
	$city = addslashes($city);
	$county = addslashes($county);
	$state = addslashes($state);
	$country = addslashes($country);
	$latitude = addslashes($latitude);
	$longitude = addslashes($longitude);
	$zoom = addslashes($zoom);
	$notes = addslashes($notes);
}
if($latitude && $longitude && !$zoom)
	$zoom = 13;
if( !$zoom ) $zoom = 0;
$query = "INSERT INTO $cemeteries_table (cemname,maplink,city,county,state,country,latitude,longitude,zoom,notes) VALUES (\"$cemname\",\"$maplink\",\"$city\",\"$county\",\"$state\",\"$country\",\"$latitude\",\"$longitude\",\"$zoom\",\"$notes\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$cemeteryID = mysql_insert_id();

adminwritelog( "<a href=\"editcemetery.php?cemeteryID=$cemeteryID\">$admtext[addnewcemetery]: $cemeteryID - $cemname</a>" );

$message = "$admtext[cemetery] $cemeteryID $admtext[succadded].";
header( "Location: cemeteries.php?message=" . urlencode($message) );
?>
