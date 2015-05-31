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

$query = "SELECT branch FROM $people_table WHERE personID = \"$personID\" and gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) || !checkbranch( $row[branch] ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

if (get_magic_quotes_gpc() == 0) {
	$firstname = addslashes($firstname);
	$lastname = addslashes($lastname);
	$lnprefix = addslashes($lnprefix);
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

if( is_array( $branch ) ) {
	foreach( $branch as $b ) {
		if( $b ) $allbranches = $allbranches ? "$allbranches,$b" : $b;
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
			$query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$personID\" AND gedcom = \"$tree\" AND branch = \"$b\"";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
	}
	foreach( $branch as $b ) {
		if( $b && !in_array( $b, $oldbranches ) ) {
			$query = "INSERT IGNORE INTO $branchlinks_table (branch,gedcom,persfamID) VALUES(\"$b\",\"$tree\",\"$personID\")";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
	}
}

$places = array();
if( trim($birthplace) && !in_array( $birthplace, $places ) ) array_push( $places, $birthplace );
if( trim($altbirthplace) && !in_array( $altbirthplace, $places ) ) array_push( $places, $altbirthplace );
if( trim($deathplace) && !in_array( $deathplace, $places ) ) array_push( $places, $deathplace );
if( trim($burialplace) && !in_array( $burialplace, $places ) ) array_push( $places, $burialplace );
if( trim($baptplace) && !in_array( $baptplace, $places ) ) array_push( $places, $baptplace );
if( trim($endlplace) && !in_array( $endlplace, $places ) ) array_push( $places, $endlplace );
foreach( $places as $place ) {
	$query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,zoom) VALUES (\"$tree\",\"$place\",\"0\",\"0\")";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
}

$query = "SELECT familyID FROM $children_table WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
$parents = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$famc = "";
if( $parents && mysql_num_rows( $parents ) ) {
	while ( $parent = mysql_fetch_assoc( $parents ) ) {
		eval( "\$sealpdate = \$sealpdate$parent[familyID];" );
		eval( "\$sealpplace = \$sealpplace$parent[familyID];" );
		$sealplace = addslashes( $sealplace );
		eval( "\$sealpdatetr = convertdate( \$sealpdate$parent[familyID] );" );
		eval( "\$relationship = \$relationship$parent[familyID];" );
		$query = "UPDATE $children_table SET sealdate=\"$sealpdate\", sealdatetr=\"$sealpdatetr\", sealplace=\"$sealpplace\", relationship=\"$relationship\" WHERE familyID = \"$parent[familyID]\" AND personID = \"$personID\" AND gedcom = \"$tree\"";
		$result2 = @mysql_query($query);
		if( !$famc )
			$famc = $parent['familyID'];
	}
	mysql_free_result($parents);
}

$famcstr = $famc ? ", famc = \"$famc\"" : "";
if( !$living ) $living = 0;
$query = "UPDATE $people_table SET firstname=\"$firstname\", lnprefix=\"$lnprefix\", lastname=\"$lastname\", nickname=\"$nickname\", prefix=\"$prefix\", suffix=\"$suffix\", title=\"$title\", nameorder=\"$pnameorder\", living=\"$living\", birthdate=\"$birthdate\", birthdatetr=\"$birthdatetr\", birthplace=\"$birthplace\", sex=\"$sex\", altbirthdate=\"$altbirthdate\", altbirthdatetr=\"$altbirthdatetr\", altbirthplace=\"$altbirthplace\", deathdate=\"$deathdate\", deathdatetr=\"$deathdatetr\", deathplace=\"$deathplace\", burialdate=\"$burialdate\", burialdatetr=\"$burialdatetr\", burialplace=\"$burialplace\", baptdate=\"$baptdate\", baptdatetr=\"$baptdatetr\", baptplace=\"$baptplace\", endldate=\"$endldate\", endldatetr=\"$endldatetr\", endlplace=\"$endlplace\", changedate=\"$newdate\",branch=\"$allbranches\",changedby=\"$currentuser\" $famcstr WHERE personID=\"$personID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

if( $sex == "M" ) {
	$self = "husband"; $spouseorder = "husborder";
}
else if ($sex == "F" ) {
	$self = "wife"; $spouseorder = "wifeorder";
}
else {
	$self = ""; $spouseorder = "";
}
	
if( $self )
	 $query = "SELECT familyID, husband, wife FROM $families_table WHERE $families_table.$self = \"$personID\" AND gedcom = \"$tree\" ORDER BY $spouseorder";
else
	$query = "SELECT familyID, husband, wife FROM $families_table WHERE ($families_table.husband = \"$personID\" OR $families_table.wife = \"$personID\") AND gedcom = \"$tree\"";
$marriages= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

if ( $marriages && mysql_num_rows( $marriages ) ) {
	while ( $marriagerow =  mysql_fetch_assoc( $marriages ) ) {
		if( $personID == $marriagerow[husband] ) {
			$spquery = "SELECT living FROM $people_table WHERE personID = \"$marriagerow[wife]\" AND gedcom = \"$tree\"";
		}
		else if( $personID == $marriagerow[wife] ) {
			$spquery = "SELECT living FROM $people_table WHERE personID = \"$marriagerow[husband]\" AND gedcom = \"$tree\"";
		}
		else
			$spquery = "";
		if( $spquery ) {
			$spouselive = mysql_query($spquery) or die ("$admtext[cannotexecutequery]: $spquery");
			$spouserow =  mysql_fetch_assoc( $spouselive );
			$spouseliving = $spouserow[living];
		}
		else
			$spouseliving = 0;
		$familyliving = ($living || $spouseliving) ? 1 : 0;
		$query = "UPDATE $families_table SET living = \"$familyliving\", branch = \"$allbranches\" WHERE familyID = \"$marriagerow[familyID]\" AND gedcom = \"$tree\"";
		$spouseresult= @mysql_query($query);
	}
}

adminwritelog( "<a href=\"editperson.php?personID=$personID&tree=$tree\">$admtext[modifyperson]: $tree/$personID</a>" );

if( $newfamily == "none" ) {
	$message = "$admtext[changestoperson] $personID $admtext[succsaved].";
	header( "Location: people.php?message=" . urlencode($message) );
}
else if( $newfamily == "return" )
	header( "Location: editperson.php?personID=$personID&tree=$tree&cw=$cw" );
else if( $newfamily == "child" )
	header( "Location: newfamily.php?child=$personID&tree=$tree&cw=$cw" );
else if( $newfamily == "repeat" )
	header( "Location: findperson2.php?time=" . microtime() );
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
else
	header( "Location: newfamily.php?$self=$personID&tree=$tree&cw=$cw" );
?>
