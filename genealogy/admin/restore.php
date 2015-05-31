<?php
@ini_set( 'memory_limit' , '80M' );
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

function restore( $table ) {
	global $rootpath, $backuppath, $largechunk, $admtext, $database_name, $link;

	$filename = "$rootpath$backuppath/$table.bak";
	if( !file_exists( $filename ) ) return $admtext['cannotopen'] . " $table.bak";
	$lines = file( $filename );
	
	$query = "DELETE FROM $table";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	$fieldnames = mysql_list_fields( $database_name, $table, $link );
	$columns = mysql_num_fields( $fieldnames );
	
	$fields = "";
	for ( $i = 0; $i < $columns; $i++ ) {
		if( $fields ) $fields .= ",";
	    $fields .= mysql_field_name($fieldnames, $i);
	}
	
	$counter = 0;
	$values = "";
	$saveline = "";
	$startquote = 0;
	$prevendquote = 0;
	
	foreach ( $lines as $line ) {
		$startquote = substr( $line, 0, 1 ) == "\"" ? 1: 0;
		if( $startquote && $prevendquote ) {
			if( $values ) $values .= ",";
			$values .= "($saveline)";
			
			$counter++;
			if( $counter == $largechunk ) {
				$query = "INSERT INTO $table ($fields) VALUES $values";
				$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$counter = 0;
				$values = "";
			}
			$saveline = "";
			$startquote = $prevendquote = 0;
		}
		$prevendquote = substr( rtrim( $line ), -1 ) == "\"" && substr( rtrim( $line ), -2 ) != "\\\"" ? 1: 0;
	
		$saveline .= $line;
	}
	
	if( $saveline ) {
		if( $values ) $values .= ",";
		$values .= "($saveline)";
			
		$query = "INSERT INTO $table ($fields) VALUES $values";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
	return "";
}

$largechunk = 100;
$ajaxmsg = $msg = "";

if( $table == "struct" ) {
	$filename = "$rootpath$backuppath/tng_tablestructure.bak";
	$lines = file( $filename );
	$query = "";
	foreach( $lines as $line ) {
		$query .= $line;
		if( substr( trim($line), -1 ) == ";" ) {
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			$query = "";
		}
	}

	$message = "$admtext[tablestruct] $admtext[succrestored].";
	adminwritelog( "$admtext[restore]: $admtext[tablestruct]" );
}
else {
	if( $table == "all" ) {
		$tablelist = array("$address_table", "$albums_table", "$albumlinks_table", "$album2entities_table", "$assoc_table", "$branches_table", "$branchlinks_table", "$cemeteries_table", "$people_table", "$families_table", "$children_table",
			"$languages_table", "$places_table", "$states_table", "$countries_table", "$sources_table", "$repositories_table", "$citations_table", "$reports_table",
			"$events_table", "$eventtypes_table", "$trees_table", "$notelinks_table", "$xnotes_table", "$users_table", "$tlevents_table", "$saveimport_table", "$temp_events_table", "$media_table", "$medialinks_table", "$mediatypes_table", "$mostwanted_table");
		$tablename = $admtext['alltables'];
		$message = "";
		foreach( $tablelist as $table ) {
			eval( "\$dothistable = \"\$$table\";" );
			if( $dothistable ) {
				$msg = restore( $table );
				if( $msg ) {
					$message = $message ? $message . "<br />" . $msg : $msg;
				}
			}
		}
		if(!$message) $message = "$tablename $admtext[succrestored].";
	}
	else {
		$tablelist = array("$table");
		$tablename = $table;
		$message = "$admtext[table] $tablename $admtext[succrestored].";
		$ajaxmsg = restore( $table );
		if(!$ajaxmsg)
			$ajaxmsg = "$tablename&" . $admtext['succrestored'];
	}
	adminwritelog( "$admtext[restore]: $tablename" );
}

if($ajaxmsg)
	echo $ajaxmsg;
else 
	header( "Location: backuprestore.php?message=" . urlencode($message) );
?>
