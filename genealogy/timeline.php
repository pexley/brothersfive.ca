<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
$textpart = "timeline";
include($cms[tngpath] . "getlang.php");
include($cms[tngpath] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");

session_register('timeline');
session_register('timeline_chartwidth');
session_register('tng_message');
$timeline = $_SESSION[timeline];
if( !is_array( $timeline ) ) $timeline = array();

$tng_message = $_SESSION[tng_message] = "";
if( $newwidth )
	$_SESSION[timeline_chartwidth] = $newwidth;

if( $primaryID ) {
	$newentry = "timeperson=$primaryID" . "&timetree=$tree";
	if( !in_array( $newentry, $timeline ) ) {
		array_push( $timeline, $newentry );
		$_SESSION[timeline] = $timeline;
	}
}
for( $i = 2; $i < 6; $i++ ) {
	$nextpersonID = "nextpersonID$i";
	$nexttree = "nexttree$i";
	if( $$nextpersonID != "" ) {
		$newentry2 = "timeperson=" . strtoupper($$nextpersonID) . "&timetree=" . $$nexttree;
		if( !in_array( $newentry2, $timeline ) ) {
			array_push( $timeline, $newentry2 );
			$_SESSION[timeline] = $timeline;
		}
	}
}

$finalarray = array();
foreach( $timeline as $timeentry ) {
	parse_str( $timeentry );
	$todelete = $timetree . "_" . $timeperson;
	if( $$todelete != "1" ) {
		$query = "SELECT personID, firstname, lnprefix, lastname, suffix, nameorder, living, branch, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, gedcom FROM $people_table WHERE personID = \"$timeperson\" AND gedcom = \"$timetree\"";
		$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( $result2 ) {
			$row2 = mysql_fetch_assoc( $result2 );
			$rightbranch = checkbranch( $row2[branch] ) ? 1 : 0;
			$hasrights = $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $row2[gedcom]) && $rightbranch ) ? 1 : 0;
			$row2[allow_living] = !$row2[living] || $hasrights;
			if( $row2[living] && !$hasrights )
				$tng_message .= "$text[noliving]: " . getName( $row2 ) . " ($timeperson)<br/>\n";
			elseif( !$row2[birth] )
				$tng_message .= "$text[nobirth]: " . getName( $row2 ) . " ($timeperson)<br/>\n";
			else
				array_push( $finalarray, $timeentry );
			mysql_free_result($result2);
		}
	}
}
$timeline = $_SESSION[timeline] = $finalarray;
$_SESSION[tng_message] = $tng_message;

$timeline2_url = getURL( "timeline2", 1 );
header( "Location: $timeline2_url" . "primaryID=$primaryID&tree=$tree&chartwidth=$newwidth" );
?>
