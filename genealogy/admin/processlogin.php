<?php
include("../subroot.php");
include($subroot . "config.php");
$tngconfig['maint'] = "";
include("adminlib.php");
$textpart = "login";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;

if( $encrypted )
	$query = "SELECT * FROM $users_table WHERE username = \"$tngusername\" AND password=\"$tngpassword\"";
else
	$query = "SELECT * FROM $users_table WHERE username = \"$tngusername\" AND password=\"" . md5( $tngpassword ) . "\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$found = mysql_num_rows( $result );
if( $found == 1 ) {
	$row = mysql_fetch_assoc( $result );
	if( $encrypted )
		$check = strcmp( $tngpassword, $row[password] ) || ( $row[allow_living] == -1 );
	else
		$check = strcmp( md5($tngpassword), $row[password] ) || ( $row[allow_living] == -1 );
}
if( $found == 1 && !$check ) {
	$allow_admin = $row[allow_edit] || $row[allow_add] || $row[allow_delete] ? 1 : 0;
	$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );
	$query = "UPDATE $users_table SET lastlogin=\"$newdate\" WHERE userID=\"$row[userID]\"";
	$uresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}
else
	$allow_admin = 0;

if( $allow_admin ) {
	$newroot = ereg_replace( "/", "", $rootpath );
	$newroot = ereg_replace( " ", "", $newroot );
	$newroot = ereg_replace( "\.", "", $newroot );
	if( $remember ) {
		setcookie("tnguser_$newroot", $tngusername, time()+31536000, "/");
		setcookie("tngpass_$newroot", $row[password], time()+31536000, "/"); 
	}
	session_register('logged_in');
	session_register('allow_admin_db');
	session_register('allow_edit_db');
	session_register('allow_add_db');
	session_register('tentative_edit_db');
	session_register('allow_delete_db');
	session_register('allow_living_db');
	session_register('allow_ged_db');
	session_register('allow_lds_db');
	session_register('assignedtree');
	session_register('assignedbranch');
	session_register('currentuser');
	session_register('currentuserdesc');
	session_register('session_rp');
	$logged_in = $_SESSION[logged_in] = 1;
	$allow_edit_db = $_SESSION[allow_edit_db] = $row[allow_edit];
	$allow_add_db = $_SESSION[allow_add_db] = $row[allow_add];
	$tentative_edit_db = $_SESSION[tentative_edit_db] = $row[tentative_edit];
	$allow_delete_db = $_SESSION[allow_delete_db] = $row[allow_delete];
	if( $allow_edit_db || $allow_add_db || $allow_delete_db )
		$allow_admin_db = $_SESSION[allow_admin_db] = 1;
	else
		$allow_admin_db = $_SESSION[allow_admin_db] = 0;
	if( !$livedefault ) //depends on permissions
		$allow_living_db = $_SESSION[allow_living_db] = $row[allow_living];
	elseif( $livedefault == 2 ) //always do living
		$allow_living_db = $_SESSION[allow_living_db] = 1;
	else //never do living
		$allow_living_db = $_SESSION[allow_living_db] = 0;
	$allow_ged_db = $_SESSION[allow_ged_db] = $row[allow_ged];
	if( !$ldsdefault ) //always do lds
		$allow_lds_db = $_SESSION[allow_lds_db] = 1;
	elseif( $ldsdefault == 2 )  //depends on permissions
		$allow_lds_db = $_SESSION[allow_lds_db] = $row[allow_lds];
	else  //never do lds
		$allow_lds_db = $_SESSION[allow_lds_db] = 0;
	$assignedtree = $_SESSION[assignedtree] = $row[gedcom];
	$assignedbranch = $_SESSION[assignedbranch] = $row[branch];
	$currentuser = $_SESSION[currentuser] = $row[username];
	$currentuserdesc = $_SESSION[currentuserdesc] = $row[description];
	$session_rp = $_SESSION[session_rp] = $rootpath;
	
	setcookie("tngloggedin_$newroot", "1"); 

	if( $_SESSION[destinationpage] )
		header( "Location: " . $_SESSION[destinationpage] );
	else
		header( "Location: index.php" );
}
else {
	$message = $admtext[loginfailed];
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}
mysql_free_result($result);
?>