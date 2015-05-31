<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if( $table == "all" ) {
	$tablelist = array("$cemeteries_table", "$people_table", "$families_table", "$children_table", "$languages_table", "$places_table", "$states_table",
		"$countries_table", "$sources_table", "$citations_table", "$reports_table", "$events_table", "$eventtypes_table", "$trees_table", "$notelinks_table",
		"$xnotes_table", "$users_table", "$tlevents_table", "$saveimport_table", "$temp_events_table", "$branches_table", "$branchlinks_table",
		"$address_table", "$albums_table", "$albumlinks_table", "$album2entities_table", "$assoc_table", "$media_table", "$medialinks_table", "$mediatypes_table");
	$tablename = $admtext[alltables];
	$message = "$tablename $admtext[succoptimized].";
}
else {
	$tablelist = array("$table");
	$tablename = $table;
	$message = "$admtext[table] $tablename $admtext[succoptimized].";
}

foreach( $tablelist as $thistable ) {
	$query = "OPTIMIZE TABLE $thistable";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}

adminwritelog( "$admtext[optimize]: $tablename" );
if($table == "all")
	header( "Location: backuprestore.php?message=" . urlencode($message) );
else
	echo $table . "&" . $admtext['succoptimized'];
?>
