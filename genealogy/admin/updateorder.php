<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

initMediaTypes();

function reorderMedia( $query, $plink ) {
	global $admtext, $medialinks_table, $media_table, $type, $album2entities_table;

	$ptree = $plink['gedcom'];
	$eventID = $plink['eventID'];
	$result3 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $personrow = mysql_fetch_assoc( $result3 ) ) {
		$counter = 1;
		if($type == "media") {
			$query = "SELECT medialinkID FROM ($medialinks_table, $media_table) WHERE personID = \"$personrow[personID]\" AND $medialinks_table.gedcom = \"$ptree\" AND $media_table.mediaID = $medialinks_table.mediaID AND eventID = \"$eventID\" AND mediatypeID = \"$plink[mediatypeID]\" ORDER BY ordernum";
			$result4 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			while( $medialinkrow = mysql_fetch_assoc( $result4 ) ) {
				$query = "UPDATE $medialinks_table SET ordernum = \"$counter\" WHERE medialinkID = \"$medialinkrow[medialinkID]\"";
				$result5 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$counter++;
			}
			mysql_free_result( $result4 );
		}
		else {
			//do for albums
			$query = "SELECT alinkID FROM $album2entities_table WHERE entityID = \"$personrow[personID]\" AND gedcom = \"$ptree\" ORDER BY ordernum";
			$result4 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			while( $albumlinkrow = mysql_fetch_assoc( $result4 ) ) {
				$query = "UPDATE $album2entities_table SET ordernum = \"$counter\" WHERE alinkID = \"$albumlinkrow[alinkID]\"";
				$result5 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$counter++;
			}
			mysql_free_result( $result4 );
		}
	}
	mysql_free_result( $result3 );
}

$rval = 1;
switch($action) {
	case "order":
		$links = explode(",",$sequence);
		$count = count($links);
		if($album) {
			for($i = 0; $i < $count; $i++) {
				$order = $i+1;
				$query = "UPDATE $albumlinks_table SET ordernum=\"$order\" WHERE albumlinkID=\"" . $links[$i] . "\"";
				$result = @mysql_query($query);
			}
		}
		else {
			for($i = 0; $i < $count; $i++) {
				$order = $i+1;
				$query = "UPDATE $medialinks_table SET ordernum=\"$order\" WHERE medialinkID=\"" . $links[$i] . "\"";
				$result = @mysql_query($query);
			}
		}
		break;
	case "alborder":
		$alinks = explode(",",$sequence);
		$count = count($alinks);
		for($i = 0; $i < $count; $i++) {
			$order = $i+1;
			$query = "UPDATE $album2entities_table SET ordernum=\"$order\" WHERE alinkID = \"" . $alinks[$i] . "\"";
			$result = @mysql_query($query);
		}
		break;
	case "mworder":
		$links = explode(",",$sequence);
		$count = count($links);
		for($i = 0; $i < $count; $i++) {
			$order = $i+1;
			$query = "UPDATE $mostwanted_table SET ordernum=\"$order\", mwtype=\"$mwtype\" WHERE ID = \"" . $links[$i] . "\"";
			$result = @mysql_query($query);
		}
		break;
	case "childorder":
		$clinks = explode(",",$sequence);
		$count = count($clinks);
		for($i = 0; $i < $count; $i++) {
			$order = $i+1;
			$query = "UPDATE $children_table SET ordernum=\"$order\" WHERE familyID = \"$familyID\" AND personID = \"$clinks[$i]\" AND gedcom = \"$tree\"";
			$result2 = @mysql_query($query);
		}
		break;
	case "parentorder":
		$plinks = explode(",",$sequence);
		$count = count($plinks);
		for($i = 0; $i < $count; $i++) {
			$order = $i+1;
			$query = "UPDATE $children_table SET parentorder=\"$order\" WHERE familyID = \"$plinks[$i]\" AND personID = \"$personID\" AND gedcom = \"$tree\"";
			$result2 = @mysql_query($query);
		}
		break;
	case "spouseorder":
		$slinks = explode(",",$sequence);
		$count = count($slinks);
		for($i = 0; $i < $count; $i++) {
			$order = $i+1;
			$query = "UPDATE $families_table SET $spouseorder=\"$order\" WHERE familyID = \"$slinks[$i]\" AND gedcom = \"$tree\"";
			$result2 = @mysql_query($query);
		}
		break;
	case "spouseunlink":
		$query = "SELECT husband, wife FROM $families_table WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
		$marriage = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$marriagerow = mysql_fetch_assoc( $marriage );

		if( $personID == $marriagerow['husband'] ) {
			//$spquery = "SELECT living FROM $people_table WHERE personID = \"$marriagerow[wife]\" AND gedcom = \"$tree\"";
			$delspousestr = "husband = \"\"";
		}
		else if( $personID == $marriagerow['wife'] ) {
			//$spquery = "SELECT living FROM $people_table WHERE personID = \"$marriagerow[husband]\" AND gedcom = \"$tree\"";
			$delspousestr = "wife = \"\"";
		}
		else {
			$spquery = "";
			$delspousestr = "";
		}
		//if( $spquery ) {
			//$spouselive = @mysql_query($spquery) or die ("$admtext[cannotexecutequery]: $spquery");
			//$spouserow =  mysql_fetch_assoc( $spouselive );
			//$spouseliving = $spouserow[living];
		//}
		//else
			//$spouseliving = 0;
		//$familyliving = ($living || $spouseliving) ? 1 : 0;
		if($delspousestr) {
			$query = "UPDATE $families_table SET $delspousestr WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
			$spouseresult= @mysql_query($query);
		}
		break;
	case "parentunlink":
		$query = "DELETE FROM $children_table WHERE familyID = \"$familyID\" AND personID = \"$personID\" AND gedcom = \"$tree\"";
		$result2 = @mysql_query($query);
		break;
	case "addchild":
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

		$query = "UPDATE $people_table SET famc=\"$familyID\" WHERE personID = \"$personID\" AND gedcom = \"$tree\" and famc = \"\"";
		$result = @mysql_query($query);

		$rval = "<div class=\"sortrow\" id=\"child_$personID\" style=\"width:500px;clear:both;display:none\"";
		$rval .= " onmouseover=\"$('unlinkc_$personID').style.visibility='visible';\" onmouseout=\"$('unlinkc_$personID').style.visibility='hidden';\">\n";
		$rval .= "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr>\n";
		$rval .= "<td class=\"dragarea normal\">";
   		$rval .= "<img src=\"ArrowUp.gif\" alt=\"\"><br/>" . $admtext['drag'] . "<br/><img src=\"ArrowDown.gif\" alt=\"\">\n";
		$rval .= "</td>\n";
		$rval .= "<td class=\"lightback normal\" style=\"line-height:1.6em;\">\n";

		$rval .= "<div id=\"unlinkc_$personID\" class=\"smaller\" style=\"float:right;visibility:hidden\"><a href=\"#\" onclick=\"return unlinkChild('$personID','child_unlink');\">$admtext[remove]</a> &nbsp; | &nbsp; <a href=\"#\" onclick=\"return unlinkChild('$personID','child_delete');\">$admtext[text_delete]</a></div>";
		$display = str_replace("|","</a>",$display);
		$rval .= "<a href=\"#\" onclick=\"EditChild('$personID');\">$display</div>\n</td>\n</tr>\n</table>\n</div>\n";
		break;
	case "setdef":
		if($album) {
			$query = "UPDATE $albumlinks_table SET defphoto = '' WHERE defphoto = '1' AND albumID = '$album'";
			$result = @mysql_query($query);

			$query = "UPDATE $albumlinks_table SET defphoto = '1' WHERE albumID = '$album' AND mediaID = '$media'";
			$result = @mysql_query($query);
		}
		else {
			$query = "UPDATE $medialinks_table SET defphoto = '' WHERE defphoto = '1' AND personID = '$entity' AND gedcom = '$tree'";
			$result = @mysql_query($query);

			$query = "UPDATE $medialinks_table SET defphoto = '1' WHERE personID = '$entity' AND gedcom = '$tree' AND mediaID = '$media'";
			$result = @mysql_query($query);
		}

		$query = "SELECT thumbpath, usecollfolder, mediatypeID FROM $media_table
			WHERE mediaID = \"$media\"";
		$result = @mysql_query($query);
		if( $result ) $row = mysql_fetch_assoc( $result );
		$thismediatypeID = $row[mediatypeID];
		$usefolder = $row[usecollfolder] ? $mediatypes_assoc[$thismediatypeID] : $mediapath;
		mysql_free_result($result);
		
		if( substr( $usefolder, 0, 1 ) != "/" )
			$relativepath = $cms[support] ? "../../../" : "../";
		else
			$relativepath = "";
		
		if( $row[thumbpath] )
			$photoref = "$usefolder/$row[thumbpath]";
		else
			$photoref = $tree ? "$usefolder/$tree.$entity.$photosext" : "$photopath/$entity.$photosext";
		
		if( file_exists( "$rootpath$photoref" ) ) {
			$photoinfo = @getimagesize( "$rootpath$photoref" );
			if( $photoinfo[1] <= $thumbmaxh ) {
				$photohtouse = $photoinfo[1];
				$photowtouse = $photoinfo[0];
			}
			else {
				$photohtouse = $thumbmaxh;
				$photowtouse = intval( $thumbmaxh * $photoinfo[0] / $photoinfo[1] ) ;
			}
			$rval = "<img src=\"$relativepath" . str_replace("%2F","/",rawurlencode( $photoref )) . "?" . time() . "\" border=\"1\" alt=\"\" width=\"$photowtouse\" height=\"$photohtouse\" align=\"left\" style=\"margin-right:10px\">";
		}
		break;
	case "deldef":
		//look for old style default, delete if exists
		if($album) {
			$query = "SELECT thumbpath, usecollfolder, mediatypeID, albumlinkID FROM ($media_table, $albumlinks_table)
				WHERE albumID = \"$album\" AND $media_table.mediaID = $albumlinks_table.mediaID AND defphoto = '1'";
		}
		else {
			$query = "SELECT thumbpath, usecollfolder, mediatypeID, medialinkID FROM ($media_table, $medialinks_table)
				WHERE personID = \"$entity\" AND $medialinks_table.gedcom = \"$tree\" AND $media_table.mediaID = $medialinks_table.mediaID AND defphoto = '1'";
		}
		$result = @mysql_query($query);
		if( $result ) $row = mysql_fetch_assoc( $result );
		
		$thismediatypeID = $row['mediatypeID'];
		$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$thismediatypeID] : $mediapath;
		@mysql_free_result($result);
	
		//$photoref = $tree ? "$usefolder/$tree.$entity.$photosext" : "$photopath/$entity.$photosext";
		//if( file_exists( "$rootpath$photoref" ) ) {
			//@unlink( "$rootpath$photoref" );
		//}
		
		if($album)
			$query = "UPDATE $albumlinks_table SET defphoto = '' WHERE albumlinkID = '$row[albumlinkID]'";
		else
			$query = "UPDATE $medialinks_table SET defphoto = '' WHERE medialinkID = '$row[medialinkID]'";
		$result = @mysql_query($query);
		break;
	case "remalb":
		$query = "DELETE FROM $albumlinks_table WHERE albumlinkID=\"$albumlink\"";
		$result = @mysql_query($query);
		$rval = $media . "&" . $albumlink;
		break;
	case "remmostwanted":
		$query = "DELETE FROM $mostwanted_table WHERE ID=\"$id\"";
		$result = @mysql_query($query);
		$rval = $id;
		break;
	case "remsort":
		if($type == "album") {
			$query = "DELETE FROM $album2entities_table WHERE alinkID=\"$link\"";
			$result = @mysql_query($query);
		}
		elseif($type == "media") {
			$query = "DELETE FROM $medialinks_table WHERE medialinkID=\"$link\"";
			$result = @mysql_query($query);
		}
		$rval = $link;
		break;
	case "add":
		//add photo to album at end
		$query2 = "SELECT max(ordernum) as maxordernum FROM $albumlinks_table WHERE albumID = \"$album\" GROUP BY albumID";
		$result2 = mysql_query($query2) or die ("$text[cannotexecutequery]: $query2");
		$row2 = mysql_fetch_assoc($result2);
		$count = $row2['maxordernum'] + 1;
		mysql_free_result($result2);

		if($count == 1)
			$query = "INSERT INTO $albumlinks_table (albumID,mediaID,ordernum,defphoto) VALUES (\"$album\", \"$media\", \"$count\", \"1\")";
		else
			$query = "INSERT INTO $albumlinks_table (albumID,mediaID,ordernum,defphoto) VALUES (\"$album\", \"$media\", \"$count\",\"0\")";
		$result = @mysql_query($query);
		$albumlinkID = mysql_insert_id();
		$rval = $media . "&" . $albumlinkID;
		break;
	case "dellink":
		if($type == "album")
			$query = "SELECT entityID, gedcom FROM $album2entities_table WHERE alinkID=\"$linkID\"";
		else
			$query = "SELECT personID as entityID, $medialinks_table.gedcom as gedcom, eventID, mediatypeID FROM ($medialinks_table, $media_table) WHERE medialinkID=\"$linkID\" and $medialinks_table.mediaID = $media_table.mediaID";
		$result = @mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$entityID = $row['entityID'];
		$tree = $row['gedcom'];
		mysql_free_result($result);

		if($type == "album")
			$query = "DELETE FROM $album2entities_table WHERE alinkID=\"$linkID\"";
		else
			$query = "DELETE FROM $medialinks_table WHERE medialinkID=\"$linkID\"";
		$result = @mysql_query($query);

		$query2 = "SELECT personID from $people_table WHERE personID = \"$entityID\" AND gedcom = \"$tree\"";
		reorderMedia( $query2, $row );

		$query2 = "SELECT familyID as personID from $families_table WHERE familyID = \"$entityID\" AND gedcom = \"$tree\"";
		reorderMedia( $query2, $row );

		$query2 = "SELECT sourceID as personID from $sources_table WHERE sourceID = \"$entityID\" AND gedcom = \"$tree\"";
		reorderMedia( $query2, $row );

		$query2 = "SELECT repoID as personID from $repositories_table WHERE repoID = \"$entityID\" AND gedcom = \"$tree\"";
		reorderMedia( $query2, $row );

		$rval = $linkID . "&" . $entityID;
		break;
	case "updatelink":
		//check if thumb exists before making default? We used to do that
		if(get_magic_quotes_gpc() == 0) {
			$altdescription = addslashes($altdescription);
			$altnotes = addslashes($altnotes);
		}
		$query = "UPDATE $medialinks_table SET defphoto = '$defphoto', altdescription = '$altdescription', altnotes = '$altnotes', eventID = '$eventID' WHERE medialinkID = $medialinkID";
		$result = @mysql_query($query);

		if($defphoto) {
			$query = "UPDATE $medialinks_table SET defphoto = '' WHERE personID = '$personID' AND gedcom = '$tree' AND medialinkID != $medialinkID";
			$result = @mysql_query($query);
		}
		break;
	case "addlink":
		$entityID = addslashes(urldecode($entityID));
		if($type == "album")
			$query = "SELECT count(alinkID) as count FROM $album2entities_table WHERE entityID = \"$entityID\" AND gedcom = \"$tree\"";
		else
			$query = "SELECT count(medialinkID) as count FROM $medialinks_table WHERE personID = \"$entityID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);
		if( $result ) {
			$row = mysql_fetch_assoc($result);
			$newrow = $row[count] + 1;
			mysql_free_result($result);
		}
		else
			$newrow = 1;

		switch($linktype) {
			case "I":
				$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, title, living, nameorder FROM $people_table WHERE gedcom = \"$tree\" AND personID = \"$entityID\"";
				$result = @mysql_query($query);
				$row = mysql_fetch_assoc($result);
				$name = getName($row);
				break;
			case "F":
				$joinonwife = "LEFT JOIN $people_table AS wifepeople ON $families_table.wife = wifepeople.personID AND $families_table.gedcom = wifepeople.gedcom";
				$joinonhusb = "LEFT JOIN $people_table AS husbpeople ON $families_table.husband = husbpeople.personID AND $families_table.gedcom = husbpeople.gedcom";
				$query = "SELECT wifepeople.personID as wpersonID, wifepeople.firstname as wfirstname, wifepeople.lnprefix as wlnprefix, wifepeople.lastname as wlastname, wifepeople.prefix as wprefix, wifepeople.suffix as wsuffix, wifepeople.nameorder as wnameorder,
					husbpeople.personID as hpersonID, husbpeople.firstname as hfirstname, husbpeople.lnprefix as hlnprefix, husbpeople.lastname as hlastname, husbpeople.prefix as hprefix, husbpeople.suffix as hsuffix, husbpeople.nameorder as hnameorder
					FROM $families_table $joinonwife $joinonhusb WHERE $families_table.gedcom = \"$tree\" AND familyID = \"$entityID\"";
				$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$row = mysql_fetch_assoc($result);
				$name = "";
				if( $row['hpersonID'] ) {
					$person['firstname'] = $row['hfirstname'];
					$person['lnprefix'] = $row['hlnprefix'];
					$person['lastname'] = $row['hlastname'];
					$person['prefix'] = $row['hprefix'];
					$person['suffix'] = $row['hsuffix'];
					$person['nameorder'] = $row['hnameorder'];
					$name .= getName( $person );
				}
				$name .= ", ";
				if( $row['wpersonID'] ) {
					$person['firstname'] = $row['wfirstname'];
					$person['lnprefix'] = $row['wlnprefix'];
					$person['lastname'] = $row['wlastname'];
					$person['prefix'] = $row['wprefix'];
					$person['suffix'] = $row['wsuffix'];
					$person['nameorder'] = $row['wnameorder'];
					$name .= getName( $person );
				}
				break;
			case "S":
				$query = "SELECT title FROM $sources_table WHERE gedcom = \"$tree\" AND sourceID = \"$entityID\"";
				$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$row = mysql_fetch_assoc($result);
				$name = $row['title'];
				$truncated = substr($row['title'],0,90);
				$name = strlen($row['title']) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $row['title'];
				break;
			case "R":
				$query = "SELECT reponame FROM $repositories_table WHERE gedcom = \"$tree\" AND repoID = \"$entityID\"";
				$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$row = mysql_fetch_assoc($result);
				$name = $row['reponame'];
				$truncated = substr($row['reponame'],0,90);
				$name = strlen($row['reponame']) > 90 ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $row['reponame'];
				break;
			case "L":
				$query = "SELECT place FROM $places_table WHERE gedcom = \"$tree\" AND place = \"$entityID\"";
				$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$name = $entityID;
				break;
		}
		if($result) {
			$numrows = mysql_num_rows($result);
			mysql_free_result($result);
		}
		else
			$numrows = 0;

		if($numrows) {
			if($type == "album")
				$query = "INSERT IGNORE INTO $album2entities_table (entityID,albumID,ordernum,gedcom,linktype) VALUES (\"$entityID\",\"$albumID\",\"$newrow\",\"$tree\",\"$linktype\")";
			else
				$query = "INSERT IGNORE INTO $medialinks_table (personID,mediaID,ordernum,gedcom,linktype,eventID) VALUES (\"$entityID\",\"$mediaID\",\"$newrow\",\"$tree\",\"$linktype\",\"\")";
				
			$result = @mysql_query($query);
			$success = mysql_affected_rows();
			if($success) {
				$linkID = mysql_insert_id();
				$rval = $linkID . "|" . utf8_encode(stripslashes($name));
			}
			else
				$rval = 1;  //duplicate
		}
		else
			$rval = 2;  //invalid
		break;
}

echo $rval;
?>
