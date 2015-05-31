<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "people";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

require("adminlog.php");
require("datelib.php");

$tree = $tree1;
if( !$allow_add || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$personID = ucfirst( $personID );

if (get_magic_quotes_gpc() == 0) {
	$firstname = addslashes($firstname);
	$lnprefix = addslashes($lnprefix);
	$lastname = addslashes($lastname);
	$nickname = addslashes($nickname);
	$prefix = addslashes($prefix);
	$suffix = addslashes($suffix);
	$title = addslashes($title);
	$birthplace = addslashes($birthplace);
	$altbirthplace = addslashes($altbirthplace);
	$deathplace = addslashes($deathplace);
	$burialplace = addslashes($burialplace);
	$baptplace = addslashes($baptplace);
	$endlplace = addslashes($endlplace);
}

$birthdatetr = convertDate( $birthdate );
$altbirthdatetr = convertDate( $altbirthdate );
$deathdatetr = convertDate( $deathdate );
$burialdatetr = convertDate( $burialdate );
$baptdatetr = convertDate( $baptdate );
$endldatetr = convertDate( $endldate );

$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

$query = "SELECT personID FROM $people_table WHERE personID = \"$personID\" and gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

if( $result && mysql_num_rows( $result ) ) {
	$message = "$admtext[person] $personID $admtext[idexists]";
	header( "Location: people.php?message=" . urlencode($message) );
	exit;
}

$places = array();
if( !in_array( $birthplace, $places ) ) array_push( $places, $birthplace );
if( !in_array( $altbirthplace, $places ) ) array_push( $places, $altbirthplace );
if( !in_array( $deathplace, $places ) ) array_push( $places, $deathplace );
if( !in_array( $burialplace, $places ) ) array_push( $places, $burialplace );
if( !in_array( $baptplace, $places ) ) array_push( $places, $baptplace );
if( !in_array( $endlplace, $places ) ) array_push( $places, $endlplace );
foreach( $places as $place ) {
	$query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,zoom) VALUES (\"$tree\",\"$place\",\"0\",\"0\")";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
}

if( is_array( $branch ) ) {
	foreach( $branch as $b ) {
		if( $b ) $allbranches = $allbranches ? "$allbranches,$b" : $b;
	}
}
else
	$allbranches = $branch;
if( !$living ) $living = 0;
$query = "INSERT INTO $people_table (personID,firstname,lnprefix,lastname,nickname,prefix,suffix,title,nameorder,living,birthdate,birthdatetr,birthplace,sex,altbirthdate,altbirthdatetr,altbirthplace,deathdate,deathdatetr,deathplace,burialdate,burialdatetr,burialplace,baptdate,baptdatetr,baptplace,endldate,endldatetr,endlplace,changedate,gedcom,branch,changedby,famc,metaphone) VALUES(\"$personID\",\"$firstname\",\"$lnprefix\",\"$lastname\",\"$nickname\",\"$prefix\",\"$suffix\",\"$title\",\"$pnameorder\",\"$living\",\"$birthdate\",\"$birthdatetr\",\"$birthplace\",\"$sex\",\"$altbirthdate\",\"$altbirthdatetr\",\"$altbirthplace\",\"$deathdate\",\"$deathdatetr\",\"$deathplace\",\"$burialdate\",\"$burialdatetr\",\"$burialplace\",\"$baptdate\",\"$baptdatetr\",\"$baptplace\",\"$endldate\",\"$endldatetr\",\"$endlplace\",\"$newdate\",\"$tree\",\"$allbranches\",\"$currentuser\",\"\",\"\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "<a href=\"editperson.php?personID=$personID&amp;tree=$tree\">$admtext[addnewperson]: $tree/$personID</a>" );

header( "Location: editperson.php?personID=$personID&tree=$tree" );
?>
