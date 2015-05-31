<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "generateID";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

function getNewID( $type, $field, $table ) {
	global $tree, $admtext;
	include( "prefixes.php" );

	eval( "\$prefix = \$$type" . "prefix;" );
	eval( "\$suffix = \$$type" . "suffix;" );
	if( $prefix ) {
		$prefixlen = strlen( $prefix ) + 1;
		$query = "SELECT MAX(0+SUBSTRING($field" . "ID,$prefixlen)) as newID FROM $table WHERE gedcom = \"$tree\" AND $field" . "ID LIKE \"$prefix%\"";
	}
	else
		$query = "SELECT MAX(0+SUBSTRING_INDEX($field" . "ID,'$suffix',1)) as newID FROM $table WHERE gedcom = \"$tree\"";

	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$maxrow = mysql_fetch_array( $result );
	mysql_free_result($result);

	$newID = $prefix . str_pad( $maxrow[newID] + 1, strlen($maxrow[newID]) . $suffix, "0", STR_PAD_LEFT );

	return $newID;
}

switch( $type ) {
	case "person":
		$newID = getNewID( "person", "person", $people_table );
		break;
	case "family":
		$newID = getNewID( "family", "family", $families_table );
		break;
	case "source":
		$newID = getNewID( "source", "source", $sources_table );
		break;
	case "repo":
		$newID = getNewID( "repo", "repo", $repositories_table );
		break;
}
echo $newID;
?>
