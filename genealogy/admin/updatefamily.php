<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "families";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

require("adminlog.php");
require("datelib.php");

$query = "SELECT branch FROM $families_table WHERE familyID = \"$familyID\" and gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) || !checkbranch( $row[branch] ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

if (get_magic_quotes_gpc() == 0) {
	$marrplace = addslashes($marrplace);
	$divplace = addslashes($divplace);
	$sealplace = addslashes($sealplace);
	$marrtype = addslashes($marrtype);
}

$marrdatetr = convertDate( $marrdate );
$divdatetr = convertDate( $divdate );
$sealdatetr = convertDate( $sealdate );

//get living from husband, wife
if( $husband ) {
	$spquery = "SELECT living FROM $people_table WHERE personID = \"$husband\" AND gedcom = \"$tree\"";
	$spouselive = mysql_query($spquery) or die ("$admtext[cannotexecutequery]: $spquery");
	$spouserow =  mysql_fetch_assoc( $spouselive );
	$husbliving = $spouserow[living];
}
else
	$husbliving = 0;

if( $wife ) {
	$spquery = "SELECT living FROM $people_table WHERE personID = \"$wife\" AND gedcom = \"$tree\"";
	$spouselive = mysql_query($spquery) or die ("$admtext[cannotexecutequery]: $spquery");
	$spouserow =  mysql_fetch_assoc( $spouselive );
	$wifeliving = $spouserow[living];
}
else
	$wifeliving = 0;
$familyliving = $living ? $living : 0;
//$familyliving = ($husbliving || $wifeliving) ? 1 : 0;

$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

if( is_array( $branch ) ) {
	foreach( $branch as $b ) {
		if( $b )
			$allbranches = $allbranches ? "$allbranches,$b" : $b;
	}
}
else {
	$allbranches = $branch;
	$branch = array($branch);
}

if( $allbranches != $orgbranch ) {
	$oldbranches = explode(",", $orgbranch );
	foreach( $oldbranches as $b ) {
		if( $b && !in_array( $b, $branch ) ) {
			$query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$familyID\" AND gedcom = \"$tree\" AND branch = \"$b\"";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
	}
	foreach( $branch as $b ) {
		if( $b && !in_array( $b, $oldbranches ) ) {
			$query = "INSERT IGNORE INTO $branchlinks_table (branch,gedcom,persfamID) VALUES(\"$b\",\"$tree\",\"$familyID\")";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
	}
}

$places = array();
if( !in_array( $marrplace, $places ) ) array_push( $places, $marrplace );
if( !in_array( $divplace, $places ) ) array_push( $places, $divplace );
if( !in_array( $sealplace, $places ) ) array_push( $places, $sealplace );
foreach( $places as $place ) {
	$query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,zoom) VALUES (\"$tree\",\"$place\",\"0\",\"0\")";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
}

$query = "UPDATE $families_table SET husband=\"$husband\",wife=\"$wife\",living=\"$familyliving\",marrdate=\"$marrdate\",marrdatetr=\"$marrdatetr\",marrplace=\"$marrplace\",marrtype=\"$marrtype\",divdate=\"$divdate\",divdatetr=\"$divdatetr\",divplace=\"$divplace\",sealdate=\"$sealdate\",sealdatetr=\"$sealdatetr\",sealplace=\"$sealplace\",changedate=\"$newdate\",branch=\"$allbranches\",changedby=\"$currentuser\" WHERE familyID=\"$familyID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "<a href=\"editfamily.php?familyID=$familyID&tree=$tree&cw=$cw\">$admtext[modifyfamily]: $tree/$familyID</a>" );

if( $newfamily == "return" )
	header( "Location: editfamily.php?familyID=$familyID&tree=$tree&cw=$cw" );
else if( $newfamily == "repeat" )
	header( "Location: findfamily.php?time=" . microtime() );
else if( $newfamily == "close" ) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<body>
<SCRIPT language="JavaScript" type="text/javascript">
	window.close();
</script>
</body>
</html>
<?php
}
else {
	$message = "$admtext[changestofamily] $familyID $admtext[succsaved].";
	header( "Location: families.php?message=" . urlencode($message) );
}
?>
