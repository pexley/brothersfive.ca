<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");

function getID($fields,$table,$id) {
	$query = "SELECT $fields FROM $table WHERE ID = \"$id\"";
	$result = @mysql_query($query);
	$row = mysql_fetch_assoc( $result );
	mysql_free_result( $result );
	return $row;
}

if( $xsrcaction ) {
	$query = "DELETE FROM $sources_table WHERE 1=0";
	$modmsg = "modifysource";
	$id = "ID";
	$location = "sources.php";
}
elseif( $xrepoaction ) {
	$query = "DELETE FROM $repositories_table WHERE 1=0";
	$modmsg = "modifyrepo";
	$id = "ID";
	$location = "repositories.php";
}
elseif( $xperaction ) {
	$query = "DELETE FROM $people_table WHERE 1=0";
	$modmsg = "modifyperson";
	$id = "ID";
	$location = "people.php";
}
elseif( $xfamaction ) {
	$query = "DELETE FROM $families_table WHERE 1=0";
	$modmsg = "modifyfamily";
	$id = "ID";
	$location = "families.php";
}
elseif( $xplacaction ) {
	$query = "DELETE FROM $places_table WHERE 1=0";
	$modmsg = "modifyplace";
	$id = "ID";
	$location = "places.php";
}
elseif( $xtimeaction ) {
	$query = "DELETE FROM $tlevents_table WHERE 1=0";
	$modmsg = "modifytlevent";
	$id = "tleventID";
	$location = "timelineevents.php";
}
elseif( $xuseraction ) {
	$query = "DELETE FROM $users_table WHERE 1=0";
	$modmsg = "modifyuser";
	$id = "userID";
	$location = "users.php";
}
elseif( $xbranchaction ) {
	$query = "DELETE FROM $branches_table WHERE 1=0";
	$modmsg = "modifybranch";
	$id = "branch";
	$location = "branches.php";
}
elseif( $xruseraction ) {
	$query = "DELETE FROM $users_table WHERE 1=0";
	$modmsg = "modifyuser";
	$id = "userID";
	$location = "reviewusers.php";
}
elseif( $xcemaction ) {
	$query = "DELETE FROM $cemeteries_table WHERE 1=0";
	$modmsg = "modifycemetery";
	$id = "cemeteryID";
	$location = "cemeteries.php";
}

include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_delete ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");
require("deletelib.php");

$modifymsg = $admtext[$modmsg];
$count = 0;
foreach( array_keys($_POST) as $key ) {
	if( substr( $key, 0, 3 ) == "del" ) {
		$count++;
		$query .= " OR $id =\"" . substr( $key, 3 ) . "\"";

		$itemID = "";
		$tree = "";
		$thisid = substr( $key, 3 );
		if( $xperaction ) {
			$row = getID("personID, gedcom, branch, sex",$people_table,$thisid);
			$personID = $row['personID'];
			$tree = $row['gedcom'];

			deletePersonPlus($personID,$tree,$row['sex']);
		}
		elseif( $xfamaction ) {
			$row = getID("familyID, branch, gedcom",$families_table,$thisid);
			$familyID = $row['familyID'];
			$tree = $row['gedcom'];

			$query = "DELETE FROM $children_table WHERE familyID=\"$familyID\" AND gedcom = \"$tree\"";
			$result = @mysql_query($query);

			updateHasKidsFamily($familyID);

			deleteEvents($familyID,$tree);
			deleteCitations($familyID,$tree);
			deleteNoteLinks($familyID,$tree);
			deleteBranchLinks($familyID,$tree);
			deleteMediaLinks($familyID,$tree);
			deleteAlbumLinks($familyID,$tree);
		}
		elseif( $xsrcaction ) {
			$row = getID("sourceID, gedcom",$sources_table,$thisid);
			$sourceID = $row['sourceID'];
			$tree = $row['gedcom'];

			deleteEvents($sourceID,$tree);
			deleteCitations($sourceID,$tree);
			deleteNoteLinks($sourceID,$tree);
			deleteMediaLinks($sourceID,$tree);
			deleteAlbumLinks($sourceID,$tree);
		}
		elseif( $xrepoaction ) {
			$row = getID("repoID, gedcom",$repositories_table,$thisid);
			$repoID = $row['repoID'];
			$tree = $row['gedcom'];

			$query = "SELECT addressID FROM $repositories_table WHERE repoID=\"$repoID\"";
			$result = @mysql_query($query);
			$row = mysql_fetch_assoc( $result );
			mysql_free_result($result);

			$query = "DELETE FROM $address_table WHERE addressID=\"$row[addressID]\"";
			$result = @mysql_query($query);

			$query = "UPDATE $sources_table SET repoID = \"\" WHERE repoID=\"$repoID\" AND gedcom = \"$tree\"";
			$result = @mysql_query($query);

			deleteEvents($repoID,$tree);
			deleteNoteLinks($repoID,$tree);
			deleteMediaLinks($repoID,$tree);
			deleteAlbumLinks($repoID,$tree);
		}
		elseif( $xplacaction ) {
			$row = getID("place, gedcom",$places_table,$thisid);
			$place = $row['place'];
			$tree = $row['gedcom'];

			deleteMediaLinks($place,$tree);
			deleteAlbumLinks($place,$tree);
		}
		elseif( $xtimeaction ) {
			$query3 = "DELETE FROM $tlevents_table WHERE tleventID = \"" . substr( $key, 3 ) . "\"";
			$result3 = mysql_query($query3) or die ("$admtext[cannotexecutequery]: $query3");
		}
		elseif( $xuseraction || $xruseraction ) {
			$query3 = "DELETE FROM $users_table WHERE userID = \"" . substr( $key, 3 ) . "\"";
			$result3 = mysql_query($query3) or die ("$admtext[cannotexecutequery]: $query3");
		}
		elseif( $xbranchaction ) {
			$args = explode('&',substr( $key, 3 ));
			$branch = $args[0];
			$tree = $args[1];
			require("branchlib.php");
		}
		elseif( $xcemaction ) {
			$query3 = "SELECT maplink FROM $cemeteries_table WHERE cemeteryID = \"" . substr( $key, 3 ) . "\"";
			$result3 = @mysql_query($query3);
			$crow = mysql_fetch_assoc( $result3 );
			mysql_free_result($result3);
			//if( $crow['maplink'] && file_exists( "$rootpath$headstonepath/$crow[maplink]" ) )
				//unlink( "$rootpath$headstonepath/$crow[maplink]" );
		}
	}
}
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "$modifymsg: $admtext[all]" );

if( $count )
	$message = "$admtext[changestoallitems] $admtext[succsaved].";
else
	$message = $admtext[nochanges];
header( "Location: $location" . "?message=" . urlencode($message) );
?>
