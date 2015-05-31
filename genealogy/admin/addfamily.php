<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "families";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$tree = $tree1;
if( !$allow_add || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");
require("datelib.php");

$familyID = ucfirst( $familyID );

if (get_magic_quotes_gpc() == 0) {
	$marrplace = addslashes($marrplace);
	$divplace = addslashes($divplace);
	$sealplace = addslashes($sealplace);
	$marrtype = addslashes($marrtype);
}

$marrdatetr = convertDate( $marrdate );
$divdatetr = convertDate( $divdate );
$sealdatetr = convertDate( $sealdate );

$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

$query = "SELECT familyID FROM $families_table WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

if( $result && mysql_num_rows( $result ) ) {
	$message = "$admtext[family] $familyID $admtext[idexists]";
	header( "Location: families.php?message=$message" );
	exit;
}

$places = array();
if( !in_array( $marrplace, $places ) ) array_push( $places, $marrplace );
if( !in_array( $divplace, $places ) ) array_push( $places, $divplace );
if( !in_array( $sealplace, $places ) ) array_push( $places, $sealplace );
foreach( $places as $place ) {
	$query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,zoom) VALUES (\"$tree\",\"$place\",\"0\",\"0\")";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
}

//get living from husband, wife
if( $husband ) {
	$spquery = "SELECT living FROM $people_table WHERE personID = \"$husband\" AND gedcom = \"$tree\"";
	$spouselive = mysql_query($spquery) or die ("$admtext[cannotexecutequery]: $spquery");
	$spouserow =  mysql_fetch_assoc( $spouselive );
	$husbliving = $spouserow[living];

	$query = "SELECT husborder FROM $families_table WHERE gedcom = \"$tree\" AND husband = \"$husband\" ORDER BY husborder DESC";
	$husbresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$husbrow =  mysql_fetch_assoc( $husbresult );
	mysql_free_result($husbresult);

	$husborder = $husbrow[husborder] + 1;
}
else {
	$husbliving = 0;
	$husborder = 0;
}

if( $wife ) {
	$spquery = "SELECT living FROM $people_table WHERE personID = \"$wife\" AND gedcom = \"$tree\"";
	$spouselive = mysql_query($spquery) or die ("$admtext[cannotexecutequery]: $spquery");
	$spouserow =  mysql_fetch_assoc( $spouselive );
	$wifeliving = $spouserow[living];

	$query = "SELECT wifeorder FROM $families_table WHERE gedcom = \"$tree\" AND wife = \"$wife\" ORDER BY wifeorder DESC";
	$wiferesult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$wiferow =  mysql_fetch_assoc( $wiferesult );
	mysql_free_result($wiferesult);

	$wifeorder = $wiferow[wifeorder] + 1;
}
else {
	$wifeliving = 0;
	$wifeorder = 0;
}
$familyliving = ($living || $husbliving || $wifeliving) ? 1 : 0;

if( is_array( $branch ) ) {
	foreach( $branch as $b ) {
		if( $b ) $allbranches = $allbranches ? "$allbranches,$b" : $b;
	}
}
else
	$allbranches = $branch;
$query = "INSERT INTO $families_table (familyID,husband,husborder,wife,wifeorder,living,marrdate,marrdatetr,marrplace,marrtype,divdate,divdatetr,divplace,sealdate,sealdatetr,sealplace,changedate,gedcom,branch,changedby,status) VALUES(\"$familyID\",\"$husband\",\"$husborder\",\"$wife\",\"$wifeorder\",\"$familyliving\",\"$marrdate\",\"$marrdatetr\",\"$marrplace\",\"$marrtype\",\"$divdate\",\"$divdatetr\",\"$divplace\",\"$sealdate\",\"$sealdatetr\",\"$sealplace\",\"$newdate\",\"$tree\",\"$allbranches\",\"$currentuser\",\"\")";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

if($link_personID) {
	$query = "INSERT INTO $children_table (familyID,personID,ordernum,gedcom,relationship,haskids,parentorder,sealdate,sealdatetr,sealplace) VALUES (\"$familyID\",\"$link_personID\",1,\"$tree\",\"\",0,0,\"\",\"0000-00-00\",\"\")";
	$result = @mysql_query($query);

   	$query = "SELECT husband,wife FROM $families_table WHERE familyID=\"$familyID\" AND gedcom=\"$tree\"";
	$result = @mysql_query($query);
	$famrow = mysql_fetch_assoc($result);
	if($famrow['husband']) {
		$query = "UPDATE $children_table SET haskids=\"1\" WHERE personID = \"$famrow[husband]\" AND gedcom = \"$tree\"";
		$result2 = @mysql_query($query);
	}
	if($famrow['wife']) {
		$query = "UPDATE $children_table SET haskids=\"1\" WHERE personID = \"$famrow[wife]\" AND gedcom = \"$tree\"";
		$result2 = @mysql_query($query);
	}
	mysql_free_result($result);

	$query = "UPDATE $people_table SET famc=\"$familyID\" WHERE personID = \"$link_personID\" AND gedcom = \"$tree\" and famc = \"\"";
	$result = @mysql_query($query);
}


adminwritelog( "<a href=\"editfamily.php?familyID=$familyID&amp;tree=$tree\">$admtext[addnewfamily]: $tree/$familyID</a>" );

header( "Location: editfamily.php?familyID=$familyID&tree=$tree&cw=$cw" );
?>
