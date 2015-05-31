<?php
	$query = "DELETE from $people_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $families_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $children_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $sources_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $repositories_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $events_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $notelinks_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $xnotes_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $citations_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $places_table WHERE gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	if( $tree ) {
		$query = "SELECT mediaID from $media_table WHERE gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		while($row = mysql_fetch_assoc($result)) {
			$delquery = "DELETE FROM $albumlinks_table WHERE mediaID=\"$row[mediaID]\"";
			$delresult = mysql_query($delquery) or die ("$admtext[cannotexecutequery]: $delquery");
		}
		mysql_free_result($result);

		$query = "DELETE from $media_table WHERE gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		$query = "DELETE from $medialinks_table WHERE gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}

	$query = "UPDATE $people_table SET branch=\"\" WHERE gedcom=\"$tree\" AND branch = \"$branch\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "UPDATE $families_table SET branch=\"\" WHERE gedcom=\"$tree\" AND branch = \"$branch\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $branchlinks_table WHERE branch = \"$branch\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
?>
