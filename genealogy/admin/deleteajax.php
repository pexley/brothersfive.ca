<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_delete ) exit;

require("adminlog.php");
require("deletelib.php");

function getID($fields,$table,$id) {
	$query = "SELECT $fields FROM $table WHERE ID = \"$id\"";
	$result = @mysql_query($query);
	$row = mysql_fetch_assoc( $result );
	mysql_free_result( $result );
	return $row;
}

$logmsg = "";

switch($t) {
	case "album":
		$query = "DELETE FROM $albums_table WHERE albumID=\"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE FROM $albumlinks_table WHERE albumID=\"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE FROM $album2entities_table WHERE albumID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[deleted]: $admtext[album] $id";
		break;
	case "language":
		$query = "DELETE FROM $languages_table WHERE languageID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[deleted]: $admtext[language] $id";
		break;
	case "media":
		require("medialib.php");

		resortMedia($id);
		//removeImages($id);

		$query = "DELETE FROM $media_table WHERE mediaID=\"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE FROM $albumlinks_table WHERE mediaID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg =  "$admtext[deleted]: $admtext[media] $id";
		break;
	case "tevent":
		$query = "DELETE FROM $temp_events_table WHERE tempID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[tentdata] $id $admtext[succdeleted]";
		break;	
	case "tlevent":
		$query = "DELETE FROM $tlevents_table WHERE tleventID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[tlevent] $id $admtext[succdeleted]";
		break;
	case "person":
		$row = getID("personID, gedcom, branch, sex",$people_table,$id);
		$personID = $row['personID'];
		$tree = $row['gedcom'];

		if( ( $assignedtree && $assignedtree != $tree ) || !checkbranch( $row['branch'] ) )  exit;

		$query = "DELETE FROM $people_table WHERE ID=\"$id\"";
		$result = @mysql_query($query);

		deletePersonPlus($personID,$tree,$row['sex']);

		$logmsg = "$admtext[deleted]: $admtext[person] $tree/$personID";
		break;
	case "family":
		$row = getID("familyID, branch, gedcom",$families_table,$id);
		$familyID = $row['familyID'];
		$tree = $row['gedcom'];

		if( ( $assignedtree && $assignedtree != $tree ) || !checkbranch( $row['branch'] ) )  exit;

		$query = "DELETE FROM $families_table WHERE ID=\"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE FROM $children_table WHERE familyID=\"$familyID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);

		updateHasKidsFamily($familyID);

		deleteEvents($familyID,$tree);
		deleteCitations($familyID,$tree);
		deleteNoteLinks($familyID,$tree);
		deleteBranchLinks($familyID,$tree);
		deleteMediaLinks($familyID,$tree);
		deleteAlbumLinks($familyID,$tree);

		$logmsg = "$admtext[deleted]: $admtext[family] $tree/$familyID";
		break;
	case "source":
		if( $assignedtree && $assignedtree != $tree )  exit;

		$row = getID("sourceID, gedcom",$sources_table,$id);
		$sourceID = $row['sourceID'];
		$tree = $row['gedcom'];

		$query = "DELETE FROM $sources_table WHERE ID=\"$id\"";
		$result = @mysql_query($query);

		deleteEvents($sourceID,$tree);
		deleteCitations($sourceID,$tree);
		deleteNoteLinks($sourceID,$tree);
		deleteMediaLinks($sourceID,$tree);
		deleteAlbumLinks($sourceID,$tree);

		$logmsg = "$admtext[deleted]: $admtext[source] $sourceID";
		break;
	case "repository":
		if( $assignedtree && $assignedtree != $tree )  exit;

		$row = getID("repoID, gedcom",$repositories_table,$id);
		$repoID = $row['repoID'];
		$tree = $row['gedcom'];

		$query = "SELECT addressID FROM $repositories_table WHERE repoID=\"$repoID\"";
		$result = @mysql_query($query);
		$row = mysql_fetch_assoc( $result );
		mysql_free_result($result);

		$query = "DELETE FROM $address_table WHERE addressID=\"$row[addressID]\"";
		$result = @mysql_query($query);

		$query = "DELETE FROM $repositories_table WHERE ID=\"$id\"";
		$result = @mysql_query($query);

		$query = "UPDATE $sources_table SET repoID = \"\" WHERE repoID=\"$repoID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);

		deleteEvents($repoID,$tree);
		deleteNoteLinks($repoID,$tree);
		deleteMediaLinks($repoID,$tree);
		deleteAlbumLinks($repoID,$tree);

		$logmsg = "$admtext[deleted]: $admtext[person] $tree/$personID";
		break;
	case "place":
		if( $assignedtree && $assignedtree != $tree )  exit;

		$row = getID("place, gedcom",$places_table,$id);
		$place = $row['place'];
		$tree = $row['gedcom'];

		$query = "DELETE FROM $places_table WHERE ID=\"$id\"";
		$result = @mysql_query($query);

		deleteMediaLinks($place,$tree);
		deleteAlbumLinks($place,$tree);

		$logmsg = "$admtext[deleted]: $admtext[place] $tree/$place";
		break;
	case "cemetery":
		$query = "SELECT maplink FROM $cemeteries_table WHERE cemeteryID = \"$id\"";
		$result = @mysql_query($query);
		$row = mysql_fetch_assoc( $result );
		mysql_free_result($result);
		//if( $row['maplink'] && file_exists( "$rootpath$headstonepath/$row[maplink]" ) )
			//unlink( "$rootpath$headstonepath/$row[maplink]" );

		$query = "DELETE FROM $cemeteries_table WHERE cemeteryID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[deleted]: $admtext[cemetery] $id";
		break;
	case "user":
		$query = "DELETE FROM $users_table WHERE userID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[deleted]: $admtext[user] $id";
		break;
	case "branch":
		$branch = $id;
		require("branchlib.php");

		$logmsg = "$admtext[deleted]: $admtext[branch] $id";
		break;
	case "eventtype":
		$query = "DELETE FROM $eventtypes_table WHERE eventtypeID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[deleted]: $admtext[eventtype] $id";
		break;
	case "report":
		$query = "DELETE FROM $reports_table WHERE reportID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[deleted]: $admtext[report] $id";
		break;
	case "entity":
		$newname = addslashes( $delitem );
		if( $entity == "state" )
			$query = "DELETE FROM $states_table WHERE state = \"$newname\"";
		elseif( $entity == "country" )
			$query = "DELETE FROM $countries_table WHERE country = \"$newname\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[deleted]: $entity: $delitem";
		break;
	case "tree":
		$query = "DELETE from $people_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $families_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $children_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $sources_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $repositories_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $events_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $notelinks_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $xnotes_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $citations_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $places_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		if( $id ) {
			$query = "SELECT mediaID from $media_table WHERE gedcom = \"$id\"";
			$result = @mysql_query($query);
			while($row = mysql_fetch_assoc($result)) {
				$delquery = "DELETE FROM $albumlinks_table WHERE mediaID=\"$row[mediaID]\"";
				$delresult = @mysql_query($delquery);
			}
			mysql_free_result($result);

			$query = "DELETE from $media_table WHERE gedcom = \"$id\"";
			$result = @mysql_query($query);

			$query = "DELETE from $medialinks_table WHERE gedcom = \"$id\"";
			$result = @mysql_query($query);
		}

		$query = "DELETE FROM $trees_table WHERE gedcom=\"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $branches_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "DELETE from $branchlinks_table WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$query = "UPDATE $users_table SET allow_living=\"-1\" WHERE gedcom = \"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[tree] $id $admtext[succdeleted].";
		break;
	case "child_unlink":
    	$query = "DELETE FROM $children_table WHERE familyID=\"$familyID\" AND personID=\"$personID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);

		$query = "UPDATE $people_table SET famc=\"\" WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);

		updateHasKidsFamily($familyID);

		$logmsg = "$admtext[chunlinked]: $personID/$familyID ($tree).";
		break;
	case "child_delete":
		$query = "SELECT sex FROM $people_table WHERE personID=\"$personID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);

		$query = "DELETE FROM $people_table WHERE personID=\"$personID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);

		deletePersonPlus($personID,$tree,$row['sex']);

		$logmsg = "$admtext[chdeleted]: $personID/$familyID ($tree).";
		break;
	case "mediatype":
		$query = "DELETE FROM $mediatypes_table WHERE mediatypeID=\"$id\"";
		$result = @mysql_query($query);

		$logmsg = "$admtext[mtdeleted]: $id.";
		break;
}
if($logmsg)
	adminwritelog( $logmsg );
echo $id;
?>