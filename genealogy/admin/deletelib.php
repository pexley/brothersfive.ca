<?php
function deleteNoteLinks($id,$tree) {
	global $notelinks_table;
	
	$query = "SELECT ID FROM $notelinks_table WHERE persfamID=\"$id\"";
	$nresult = @mysql_query($query);
	
	while( $nrow = mysql_fetch_assoc( $nresult ) )
	deleteNote($nrow[ID], 0);
	mysql_free_result( $nresult );
	
	$query = "DELETE FROM $notelinks_table WHERE persfamID=\"$id\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query);
}

function deleteBranchLinks($id,$tree) {
	global $branchlinks_table;
	
	$query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$id\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query);
}

function deleteMediaLinks($id,$tree) {
	global $medialinks_table;
	
	$query = "DELETE FROM $medialinks_table WHERE personID = \"$id\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query);
}

function deleteAlbumLinks($id,$tree) {
	global $album2entities_table;
	
	$query = "DELETE FROM $album2entities_table WHERE entityID = \"$id\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query);
}

function deleteEvents($id,$tree) {
	global $events_table;
	
	$query = "DELETE FROM $events_table WHERE persfamID=\"$id\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query);
}

function deleteCitations($id,$tree) {
	global $citations_table;
	
	$query = "DELETE FROM $citations_table WHERE persfamID=\"$id\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query);
}

function deletePersonPlus($personID,$tree,$gender) {
	global $children_table, $families_table;
	
	$query = "DELETE FROM $children_table WHERE personID=\"$personID\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query);

	deleteEvents($personID,$tree);
	deleteCitations($personID,$tree);
	deleteNoteLinks($personID,$tree);
	deleteBranchLinks($personID,$tree);
	
	if( $gender == "M" ) {
		$query = "SELECT familyID FROM $families_table WHERE husband = \"$personID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);
		while($frow = mysql_fetch_assoc($result))
			updateHasKidsFamily($frow['familyID']);
		mysql_free_result($result);

		$query = "UPDATE $families_table SET husband=\"\", husborder=\"\" WHERE husband=\"$personID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);
	}
	else if( $gender == "F" ) {
		$query = "SELECT familyID FROM $families_table WHERE wife = \"$personID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);
		while($frow = mysql_fetch_assoc($result))
			updateHasKidsFamily($frow['familyID']);
		mysql_free_result($result);

		$query = "UPDATE $families_table SET wife=\"\", wifeorder=\"\" WHERE wife=\"$personID\" AND gedcom = \"$tree\"";
		$result = @mysql_query($query);
	}
	
	deleteMediaLinks($personID,$tree);
	deleteAlbumLinks($personID,$tree);
}

function updateHasKids($spouseID,$spousestr) {
	global $families_table, $children_table, $tree;

	$query = "SELECT familyID FROM $families_table WHERE $spousestr = \"$spouseID\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query);
	$numkids = 0;
	while(!$numkids && $row = mysql_fetch_assoc( $result )) {
		$query = "SELECT count(ID) as ccount FROM $children_table WHERE familyID = \"$row[familyID]\" AND gedcom=\"$tree\"";
		$result2 = @mysql_query($query);
		$crow = mysql_fetch_assoc( $result2 );
		$numkids = $crow['ccount'];
		mysql_free_result($result2);
	}
	mysql_free_result( $result );
	if(!$numkids) {
		$query = "UPDATE $children_table SET haskids=\"0\" WHERE personID=\"$spouseID\" AND gedcom=\"$tree\"";
		$result = @mysql_query($query);
	}
}

function updateHasKidsFamily($familyID){
	global $families_table, $tree;

	$query = "SELECT husband, wife FROM $families_table WHERE familyID=\"$familyID\" AND gedcom=\"$tree\"";
	$result = @mysql_query($query);
	$famrow = mysql_fetch_assoc($result);
	mysql_free_result($result);
	if($famrow['husband'])
		updateHasKids($famrow['husband'],'husband');
	if($famrow['wife'])
		updateHasKids($famrow['wife'],'wife');
}
?>
