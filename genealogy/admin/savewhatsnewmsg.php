<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "reports";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedtree ) {
	echo $admtext['norights'];
}
else {
	$whatsnewmsg = stripslashes($whatsnewmsg);
	if($session_charset != "UTF-8")
		$whatsnewmsg = utf8_decode($whatsnewmsg);

	$file = "$rootpath/whatsnew.txt";
	//write to file
	$fp = @fopen( $file, "w" );
	if( !$fp ) { die ( $admtext['cannotopen'] . " $file" ); }
	
	flock( $fp, LOCK_EX );
	fwrite( $fp, $whatsnewmsg );
	flock( $fp, LOCK_UN );
	fclose( $fp );
	echo $admtext['msgsaved'];
}
?>