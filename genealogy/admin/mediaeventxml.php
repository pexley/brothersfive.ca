<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

function doEvent($eventID, $displayval, $info) {
	echo "<event>\n";
	echo "<eventID>$eventID</eventID>\n";
	echo "<display>" . xmlcharacters($displayval) . "</display>\n";
	if( $info )
		echo "<info>" . xmlcharacters("($info)") . "</info>\n";
	else
		echo "<info>-1</info>\n";
	echo "</event>\n";
}

header('Content-Type: application/xml');
echo "<?xml version=\"1.0\"";
if($session_charset)
	echo " encoding=\"$session_charset\"";
echo "?>\n";
echo "<eventlist>\n";

//write out the number for the list to be filled
echo "<targetlist>\n";
echo "<target>$count</target>\n";
echo "</targetlist>\n";

if( $linktype == "I" ) {
	//standard people events
	$list = array("NAME","BIRT","CHR","DEAT","BURI");
	foreach( $list as $eventtype )
		doEvent($eventtype,$admtext[$eventtype],"");
	if($allow_lds) {
		$ldslist = array("BAPL","ENDL","SLGC");
		foreach( $ldslist as $eventtype )
			doEvent($eventtype,$admtext[$eventtype],"");
	}
}
elseif( $linktype == "F" ) {
	//standard family events
	$list = array("MARR","DIV");
	foreach( $list as $eventtype )
		doEvent($eventtype,$admtext[$eventtype],"");
	if($allow_lds) {
		$ldslist = array("SLGS");
		foreach( $ldslist as $eventtype )
			doEvent($eventtype,$admtext[$eventtype],"");
	}
}

//now call up custom events linked to passed in entity
$query = "SELECT display, eventdate, eventplace, info, eventID FROM $events_table, $eventtypes_table WHERE persfamID = \"$persfamID\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND gedcom = \"$tree\" AND keep = \"1\" AND parenttag = \"\" ORDER BY ordernum, tag, description, eventdatetr, info, eventID";
$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
while ( $custevent = mysql_fetch_assoc( $custevents ) )	{
	$displayval = getEventDisplay( $custevent[display] );
	if( $custevent[eventdate] )
		$info = displayDate($custevent[eventdate]);
	elseif( $custevent[eventplace] )
		$info = $custevent[eventplace];
	elseif( $custevent[info] )
		$info = substr($custevent[info],0,20) . "...";
	doEvent($custevent[eventID],$displayval,$info);
}
mysql_free_result( $custevents );

echo "</eventlist>";
?>
