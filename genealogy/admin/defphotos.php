<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

require("adminlog.php");

if( !$allow_edit ) {
	echo $admtext['norights'];
	exit;
}

$query = "SELECT DISTINCT personID FROM $medialinks_table WHERE gedcom='$tree'";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$defsdone = 0;
while( $distinctplink = mysql_fetch_assoc($result) ) {
	//must have a thumbnail
	$query2 = "SELECT medialinkID FROM ($medialinks_table, $media_table) WHERE $medialinks_table.mediaID = $media_table.mediaID AND $medialinks_table.gedcom='$tree' AND personID = '$distinctplink[personID]' AND thumbpath != \"\" and mediatypeID = 'photos' ORDER BY ordernum";
	$result2 = mysql_query($query2) or die ("$admtext[cannotexecutequery]: $query2");

	$defsexist = 0;
	if( !$overwritedefs ) {
		$query3 = "SELECT count(medialinkID) as pcount FROM $medialinks_table WHERE gedcom='$tree' AND personID = '$distinctplink[personID]' AND defphoto = '1'";
		$result3 = mysql_query($query3) or die ("$admtext[cannotexecutequery]: $query3");
		$pcountrow = mysql_fetch_assoc($result3);
		if( $pcountrow[pcount] )
			$defsexist = 1;
		else {
			$oldstylephoto = $tree ? "$rootpath$photopath/$tree.$distinctplink[personID].$photosext" : "$rootpath$photopath/$distinctplink[personID].$photosext";
			if( file_exists( $oldstylephoto ) )
				$defsexist = 1;
		}
		mysql_free_result( $result3 );
	}
	if( $overwritedefs || !$defsexist ) {
		$count = 0;
		while( $ulink = mysql_fetch_assoc($result2) ) {
			if( !$count ) {
				$query4 = "UPDATE $medialinks_table SET defphoto = '1' WHERE medialinkID='$ulink[medialinkID]'";
				$result4 = mysql_query($query4) or die ("$admtext[cannotexecutequery]: $query4");
			}
			else {
				$query4 = "UPDATE $medialinks_table SET defphoto = '0' WHERE medialinkID='$ulink[medialinkID]'";
				$result4 = mysql_query($query4) or die ("$admtext[cannotexecutequery]: $query4");
			}
			$count++;
			$defsdone++;
		}
	}
}
mysql_free_result( $result );

adminwritelog( "$admtext[assigndefs]: $admtext[defsassigned]: $defsdone;" );

echo "<p><strong>$admtext[defsassigned]:</strong> $defsdone</p>";
?>
