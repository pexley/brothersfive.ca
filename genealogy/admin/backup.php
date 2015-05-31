<?php
@ini_set( 'memory_limit' , '80M' );
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
$orgtable = $table;

function backup( $table ) {
	global $rootpath, $backuppath, $largechunk, $admtext;

	$filename = "$rootpath$backuppath/$table.bak";
	if( file_exists( $filename ) ) unlink( $filename );
	$fp = @fopen( $filename, "w" );
	if($fp) {
		flock( $fp, LOCK_EX );
		$nextchunk = -1;
		$numrows = 0;
	
		do {
			$nextone = $nextchunk + 1;
			$nextchunk += $largechunk;
			$query = "SELECT * FROM $table LIMIT $nextone, $largechunk";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			if( $result ) {
				$numrows = mysql_num_rows( $result );
				while( $row = mysql_fetch_array( $result, MYSQL_NUM ) ) {
					$line = "";
					for( $i = 0; $i < sizeof( $row ); $i++ ) {
						if( $line ) $line .= ",";
						$element = addslashes( $row[$i] );
						$line .= "\"$element\"";
					}
					$line .= "\n";
					fwrite( $fp, "$line" );
				}
				mysql_free_result( $result );
			}
		} while ( $numrows );
	
		flock( $fp, LOCK_UN );
		fclose( $fp );
		@chmod( $filename, 0664 );
		return "";
	}
	else
		return "$admtext[cannotopen] $filename";
}

function delbackup( $table ) {
	global $rootpath, $backuppath;

	$filename = "$rootpath$backuppath/$table.bak";
	if( file_exists( $filename ) ) unlink( $filename );
}

function getfiletime( $filename ) {
	global $fileflag;
	
	$filemodtime = "";
	if( $fileflag ) {
		$filemod = filemtime( $filename );
		$filemodtime = date("F j, Y h:i:s A", $filemod); 
	}
	return $filemodtime;
}

function getfilesize( $filename ) {
	global $fileflag;
	
	$filesize = "";
	if( $fileflag ) {
		$filesize = ceil( filesize( $filename )/1000 ) . " Kb";
	}
	return $filesize;
}

@set_time_limit(0);
$largechunk = 10000;
$tablelist = array("$address_table", "$albums_table", "$albumlinks_table", "$album2entities_table", "$assoc_table", "$branches_table", "$branchlinks_table", "$cemeteries_table", "$people_table", "$families_table", "$children_table",
	"$languages_table", "$places_table", "$states_table", "$countries_table", "$sources_table", "$repositories_table", "$citations_table", "$reports_table",
	"$events_table", "$eventtypes_table", "$trees_table", "$notelinks_table", "$xnotes_table", "$users_table", "$tlevents_table", "$saveimport_table", "$temp_events_table",
	"$media_table", "$medialinks_table", "$mediatypes_table", "$mostwanted_table");
$ajaxmsg = $msg = "";

if( $table == "struct" ) {
	$filename = "$rootpath$backuppath/tng_tablestructure.bak";
	if( file_exists( $filename ) ) unlink( $filename );
	$fp = @fopen( $filename, "w" );
	if( !$fp ) { die ( "$admtext[cannotopen] $filename" ); }
	flock( $fp, LOCK_EX );

	foreach( $tablelist as $table ) {
		fwrite( $fp, "DROP TABLE IF EXISTS $table;\n" );
		$query = "SHOW CREATE TABLE $table";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$row = mysql_fetch_array( $result, MYSQL_NUM );
		fwrite( $fp, "$row[1];\n" );
	}

	flock( $fp, LOCK_UN );
	fclose( $fp );
	@chmod( $filename, 0664 );

	$message = "$admtext[tablestruct] $admtext[succbackedup].";
	adminwritelog( "$admtext[backup]: $admtext[tablestruct]" );
}
elseif( $table == "del" ) {
	$tablename = $admtext[alltables];
	$message = "$tablename $admtext[succdel].";

	foreach( $tablelist as $table ) {
		eval( "\$dothistable = \"\$$table\";" );
		if( $dothistable )
			delbackup( $table );
	}
}
else {
	if( $table == "all" ) {
		$tablename = $admtext[alltables];
		$message = "$tablename $admtext[succbackedup].";

		foreach( $tablelist as $table ) {
			eval( "\$dothistable = \"\$$table\";" );
			if( $dothistable ) {
				$msg = backup( $table );
				if( $msg ) {
					$message = $msg;
					break;
				}
			}
		}
	}
	else {
		$tablelist = array("$table");
		$tablename = $table;
		$ajaxmsg = backup( $table );
		if(!$ajaxmsg) {
			$fileflag = $tablename && file_exists("$rootpath$backuppath/$tablename.bak");
			$timestamp = getfiletime( "$rootpath$backuppath/$tablename.bak" );
			$size = getfilesize("$rootpath$backuppath/$tablename.bak");
			$ajaxmsg = "$tablename&$timestamp&$size&" . $admtext['succbackedup'];
		}
	}
	adminwritelog( "$admtext[backup]: $tablename" );
}

if($ajaxmsg)
	echo $ajaxmsg;
else {
	$sub = ($orgtable == "struct") ? "sub=structure&" : "";
	header( "Location: backuprestore.php?$sub" . "message=" . urlencode($message) );
}
?>
