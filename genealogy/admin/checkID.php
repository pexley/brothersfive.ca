<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "checkID";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

require( "prefixes.php" );

if( $type == "person" ) {
	$query = "SELECT personID FROM $people_table WHERE personID = \"$checkID\" AND gedcom = \"$tree\"";
	$prefix = $personprefix;
	$suffix = $personsuffix;
}
else if( $type == "family" ) {
	$query = "SELECT familyID FROM $families_table WHERE familyID = \"$checkID\" AND gedcom = \"$tree\"";
	$prefix = $familyprefix;
	$suffix = $familysuffix;
}
else if( $type == "source" ) {
	$query = "SELECT sourceID FROM $sources_table WHERE sourceID = \"$checkID\" AND gedcom = \"$tree\"";
	$prefix = $sourceprefix;
	$suffix = $sourcesuffix;
}
else if( $type == "repo" ) {
	$query = "SELECT repoID FROM $repositories_table WHERE repoID = \"$checkID\" AND gedcom = \"$tree\"";
	$prefix = $repoprefix;
	$suffix = $reposuffix;
}

$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$prefixlen = strlen( $prefix );
$suffixlen = strlen( $suffix ) * -1;

if( $result && mysql_num_rows( $result ) ) {
	echo "<span style=\"color:red\">ID $checkID $admtext[idinuse]</span>";
}
else if( ( $prefix && ( substr( $checkID, 0, $prefixlen ) != $prefix || !is_numeric( substr( $checkID, $prefixlen ) ) ) ) ||
	( $suffix && ( substr( $checkID, $suffixlen ) != $suffix || !is_numeric( substr( $checkID, 0, $suffixlen ) ) ) ) ) {
	echo "<span style=\"color:red\">$checkID $admtext[idnotvalid] $prefix</span>";
}
else {
	echo "<span style=\"color:green\">ID $checkID $admtext[idok]</span>";
}
mysql_free_result($result);
?>
