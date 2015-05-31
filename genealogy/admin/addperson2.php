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

if( !$allow_add || ( $assignedtree && $assignedtree != $tree ) ) {
	exit;
}

//header("Content-type:text/html; charset=" . $session_charset);
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

if($session_charset != "UTF-8") {
	$firstname = utf8_decode($firstname);
	$lnprefix = utf8_decode($lnprefix);
	$lastname = utf8_decode($lastname);
	$nickname = utf8_decode($nickname);
	$prefix = utf8_decode($prefix);
	$suffix = utf8_decode($suffix);
	$title = utf8_decode($title);
	$birthplace = utf8_decode($birthplace);
	$altbirthplace = utf8_decode($altbirthplace);
	$deathplace = utf8_decode($deathplace);
	$burialplace = utf8_decode($burialplace);
	$baptplace = utf8_decode($baptplace);
	$endlplace = utf8_decode($endlplace);
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
	echo "error:$admtext[person] $personID $admtext[idexists]";
}
else {
	$places = array();
	if( !in_array( $birthplace, $places ) ) array_push( $places, $birthplace );
	if( !in_array( $altbirthplace, $places ) ) array_push( $places, $altbirthplace );
	if( !in_array( $deathplace, $places ) ) array_push( $places, $deathplace );
	if( !in_array( $burialplace, $places ) ) array_push( $places, $burialplace );
	if( !in_array( $baptplace, $places ) ) array_push( $places, $baptplace );
	if( !in_array( $endlplace, $places ) ) array_push( $places, $endlplace );
	foreach( $places as $place ) {
		$query = "INSERT IGNORE INTO $places_table (gedcom, place) VALUES(\"$tree\",\"$place\")";
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
	//$firstname = preg_replace('/%([0-9a-f]{2})/ie', 'chr(hexdec($1))', (string) $firstname);
	if($type != "child") $familyID = "";
	$query = "INSERT INTO $people_table (personID,firstname,lnprefix,lastname,nickname,prefix,suffix,title,nameorder,living,birthdate,birthdatetr,birthplace,sex,altbirthdate,altbirthdatetr,altbirthplace,deathdate,deathdatetr,deathplace,burialdate,burialdatetr,burialplace,baptdate,baptdatetr,baptplace,endldate,endldatetr,endlplace,changedate,gedcom,branch,changedby,famc,metaphone)
		VALUES(\"$personID\",\"$firstname\",\"$lnprefix\",\"$lastname\",\"$nickname\",\"$prefix\",\"$suffix\",\"$title\",\"0\",\"$living\",\"$birthdate\",\"$birthdatetr\",\"$birthplace\",\"$sex\",\"$altbirthdate\",\"$altbirthdatetr\",\"$altbirthplace\",\"$deathdate\",\"$deathdatetr\",\"$deathplace\",\"$burialdate\",\"$burialdatetr\",\"$burialplace\",\"$baptdate\",\"$baptdatetr\",\"$baptplace\",\"$endldate\",\"$endldatetr\",\"$endlplace\",\"$newdate\",\"$tree\",\"$allbranches\",\"$currentuser\",\"$familyID\",\"\")";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$ID = mysql_insert_id();

	$query = "SELECT personID, lastname, firstname, lnprefix, birthdate, altbirthdate, prefix, suffix, nameorder FROM $people_table WHERE ID=\"$ID\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);

	if($type == "child") {
		if($familyID) {
 			$query = "SELECT personID FROM $children_table WHERE familyID=\"$familyID\" AND gedcom=\"$tree\"";
			$result = @mysql_query($query);
			$order = mysql_num_rows($result);
			mysql_free_result($result);

   			$query = "INSERT INTO $children_table (familyID,personID,ordernum,gedcom,relationship,haskids,parentorder,sealdate,sealdatetr,sealplace) VALUES (\"$familyID\",\"$personID\",$order,\"$tree\",\"\",0,0,\"\",\"0000-00-00\",\"\")";
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
		}

		if ( $row['birthdate'] ) {
			$birthdate = "$admtext[birthabbr] $row[birthdate]";
		}
		else if ( $row['altbirthdate'] ) {
			$birthdate = "$admtext[chrabbr] $row[altbirthdate]";
		}
		else {
			$birthdate = "";
		}

		$rval = "<div class=\"sortrow\" id=\"child_$personID\" style=\"width:500px;clear:both;display:none\"";
		$rval .= " onmouseover=\"$('unlinkc_$personID').style.visibility='visible';\" onmouseout=\"$('unlinkc_$personID').style.visibility='hidden';\">\n";
		$rval .= "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr>\n";
		$rval .= "<td class=\"dragarea normal\">";
   		$rval .= "<img src=\"ArrowUp.gif\" alt=\"\"><br/>" . $admtext['drag'] . "<br/><img src=\"ArrowDown.gif\" alt=\"\">\n";
		$rval .= "</td>\n";
		$rval .= "<td class=\"lightback normal\" style=\"line-height:1.6em;\">\n";

		$rval .= "<div id=\"unlinkc_$personID\" class=\"smaller\" style=\"float:right;visibility:hidden\"><a href=\"#\" onclick=\"return unlinkChild('$personID','child_unlink');\">$admtext[remove]</a> &nbsp; | &nbsp; <a href=\"#\" onclick=\"return unlinkChild('$personID','child_delete');\">$admtext[text_delete]</a></div>";
		$rval .= "<a href=\"#\" onclick=\"EditChild('$personID');\">" . getName($row) . "</a> - $personID<br />$birthdate</div>\n</td>\n</tr>\n</table>\n</div>\n";
		echo $rval;
	}
	elseif( $type == "spouse") {
		$name = $session_charset == "UTF-8" ? getName($row) : utf8_encode(getName($row));
		echo "{\"id\":\"$row[personID]\",\"name\":\"" . $name . "\"}";
	}
	else {
	}
	adminwritelog( "<a href=\"editperson.php?personID=$personID&amp;tree=$tree\">$admtext[addnewperson]: $tree/$personID</a>" );
}
?>