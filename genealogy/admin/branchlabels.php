<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "branches";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

require("adminlog.php");
require("deletelib.php");

if( $assignedbranch ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

@set_time_limit(0);
$husbgender = array();
$husbgender[self] = "husband";
$husbgender[spouse] = "wife";
$husbgender[spouseorder] = "husborder";
$wifegender = array();
$wifegender[self] = "wife";
$wifegender[spouse] = "husband";
$wifegender[spouseorder] = "wifeorder";

$query = "SELECT treename FROM $trees_table where gedcom = \"$tree\"";
$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc( $treeresult );
mysql_free_result( $treeresult );

$counter = $fcounter = 0;

function getGender( $personID ) {
	global $tree, $people_table, $husbgender, $wifegender, $admtext;

	$info = array();
	$query = "SELECT firstname, lastname, sex FROM $people_table WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	if( $result ) {
		$row = mysql_fetch_assoc($result);
		if ( $row[sex] == "M" ) 
			$info = $husbgender;
		else if ($row[sex] == "F" ) 
			$info = $wifegender;
		else {
			$info[spouse] = ""; $info[self] = ""; $info[spouseorder] = "";
		}
		$info[firstname] = $row[firstname];
		$info[lastname] = $row[lastname];
		mysql_free_result( $result );
	}
	return $info;
}

function clearBranch($table,$branch) {
	global $admtext, $tree;

	$query = "UPDATE $table SET branch=\"\" WHERE gedcom=\"$tree\" AND branch = \"$branch\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$counter = mysql_affected_rows();

	$query = "SELECT branch, ID FROM $table WHERE gedcom=\"$tree\" AND branch LIKE \"%$branch%\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while($row = mysql_fetch_assoc( $result )) {
		$oldbranch = trim( $row[branch] );

		$newbranch = "";
		$oldbranches = explode(",", $oldbranch );
		foreach( $oldbranches as $tempbranch ) {
			if( $tempbranch != $branch )
				$newbranch .= $newbranch ? ",$tempbranch" : $tempbranch;
		}
  		$query = "UPDATE $table SET branch=\"$newbranch\" WHERE ID=\"$row[ID]\"";
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$counter++;
	}
	mysql_free_result($result);

	return $counter;
}

function deleteBranch($table,$branch) {
	global $admtext, $tree, $people_table, $families_table, $children_table;

	$counter = 0;
	if($table == $people_table) {
		$query = "SELECT ID, personID, branch, sex FROM $table WHERE gedcom=\"$tree\" AND branch LIKE \"%$branch%\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		while($row = mysql_fetch_assoc($result)){
			$branches = explode(",", trim($row['branch']));
			if(in_array($branch,$branches)) {
				deletePersonPlus($row['personID'],$tree,$row['sex']);
				$query = "DELETE FROM $table WHERE ID=\"$row[ID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$counter++;
			}
		}
		mysql_free_result($result);
	}
	else {
		$query = "SELECT ID, familyID, branch FROM $table WHERE gedcom=\"$tree\" AND branch LIKE \"%$branch%\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		while($row = mysql_fetch_assoc($result)){
			$branches = explode(",", trim($row['branch']));
			if(in_array($branch,$branches)) {
				$familyID = $row['familyID'];
				$query = "DELETE FROM $children_table WHERE ID=\"$familyID\" AND gedcom = \"$tree\"";
				$result2 = @mysql_query($query);

				deleteEvents($familyID,$tree);
				deleteCitations($familyID,$tree);
				deleteNoteLinks($familyID,$tree);
				deleteBranchLinks($familyID,$tree);
				deleteMediaLinks($familyID,$tree);
				deleteAlbumLinks($familyID,$tree);

				$query = "DELETE FROM $table WHERE ID=\"$row[ID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$counter++;
			}
		}
		mysql_free_result($result);
	}

	return $counter;
}

function setPersonLabel( $personID ) {
	global $tree, $people_table, $branch, $admtext, $branchlinks_table, $overwrite, $branchaction;
	
	//echo "personID=$personID, tree=$tree, branch=$branch<br>\n";
	if( $personID ) {
		if($branchaction == "delete") {
			$query = "SELECT sex FROM $people_table WHERE personID=\"$personID\" AND gedcom = \"$tree\"";
			$result = @mysql_query($query);
			$row = mysql_fetch_assoc($result);
			mysql_free_result($result);

			$query = "DELETE FROM $people_table WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			//also delete children, events, medialinks, citations, notes, other family references
			deletePersonPlus($personID,$tree,$row['sex']);
			doICounter();
		}
		else{
			if( $branch && ($overwrite != 1 || $branchaction == "clear") ) { //append or leave
				//appending, so get current value first
				$query = "SELECT branch FROM $people_table WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
				$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$row = mysql_fetch_assoc( $result );
				$oldbranch = trim( $row[branch] );
				if( $oldbranch && ($overwrite == 2 || $branchaction == "clear")) {
					$oldbranches = explode(",", $oldbranch );
					if($overwrite == 2) {
						if( !in_array( $branch, $oldbranches ) )
							$newbranch = "$oldbranch,$branch";
						else
							$newbranch = $oldbranch;
					}
					else { //clearing this branch
						foreach( $oldbranches as $tempbranch ) {
							if( $tempbranch != $branch )
								$newbranch .= $newbranch ? ",$tempbranch" : $tempbranch;
						}
					}
				}
				else
					$newbranch = $branch;
				mysql_free_result( $result );
			}
			else {
				$newbranch = $branch;
				$oldbranch = "";
			}

			if( $overwrite || !$oldbranch ) {
				$query = "UPDATE $people_table SET branch = \"$newbranch\" WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
				$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				doICounter();
			}
		}

		if($branchaction == "clear" || $branchaction == "delete") {
			$query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$personID\" AND gedcom = \"$tree\" AND branch = \"$branch\"";
			$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
		else {
			if( $overwrite == 1 || !$branch ) {
				$query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$personID\" AND gedcom = \"$tree\"";
				$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			}
			if( $branch ) {
				$query = "INSERT IGNORE INTO $branchlinks_table (branch,gedcom,persfamID) VALUES(\"$branch\",\"$tree\",\"$personID\")";
				$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			}
		}
	}
}

function doICounter() {
	global $counter;
		
	$counter++;
	if( $counter % 10 == 0 ) {
		echo "<strong>I$counter</strong> ";
	}
}

function doFCounter() {
	global $fcounter;
		
	$fcounter++;
	if( $fcounter % 10 == 0 ) {
		echo "<strong>F$fcounter</strong> ";
	}
}

function setFamilyLabel( $personID, $gender ) {
	global $tree, $families_table, $branch, $admtext, $overwrite, $branchlinks_table, $fcounter, $branchaction;

	//echo "personID=$personID, tree=$tree, branch=$branch<br>\n";
	if( $gender[self] ) {
		$query = "SELECT branch, familyID FROM $families_table WHERE $gender[self] = \"$personID\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		while($row = mysql_fetch_assoc( $result )) {
			$oldbranch = trim( $row[branch] );
			if($branchaction == "delete") {
				$query = "DELETE FROM $families_table WHERE familyID = \"$row[familyID]\" AND gedcom = \"$tree\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

				//also delete children, events, medialinks, citations, notes
				$query = "DELETE FROM $children_table WHERE ID=\"$familyID\" AND gedcom = \"$tree\"";
				$result2 = @mysql_query($query);

				deleteEvents($familyID,$tree);
				deleteCitations($familyID,$tree);
				deleteNoteLinks($familyID,$tree);
				deleteBranchLinks($familyID,$tree);
				deleteMediaLinks($familyID,$tree);
				deleteAlbumLinks($familyID,$tree);
				doFCounter();
			}
			else {
				if( $branch && $oldbranch && ($overwrite == 2 || $branchaction == "clear")) {
					$oldbranches = explode(",", $oldbranch );
					if($overwrite == 2) {
						if( !in_array( $branch, $oldbranches ) )
							$newbranch = "$oldbranch,$branch";
						else
							$newbranch = $oldbranch;
					}
					else { //clearing this branch
						foreach( $oldbranches as $tempbranch ) {
							if( $tempbranch != $branch )
								$newbranch .= $newbranch ? ",$tempbranch" : $tempbranch;
						}
					}
				}
				else
					$newbranch = $branch;

				if( $overwrite || !$oldbranch ) {
					$query = "UPDATE $families_table SET branch = \"$newbranch\" WHERE familyID = \"$row[familyID]\" AND gedcom = \"$tree\"";
					$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
					doFCounter();
				}
			}

			if($branchaction == "clear" || $branchaction == "delete") {
				$query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$row[familyID]\" AND gedcom = \"$tree\" AND branch = \"$branch\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			}
			else {
				if( $overwrite == 1 || !$branch ) {
					$query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$row[familyID]\" AND gedcom = \"$tree\"";
					$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				}
				if( $branch ) {
					$query = "INSERT IGNORE INTO $branchlinks_table (branch,gedcom,persfamID) VALUES(\"$branch\",\"$tree\",\"$row[familyID]\")";
					$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				}
			}
		}
		mysql_free_result($result);
	}
}

function setSpousesLabel( $personID, $gender ) {
	global $tree, $families_table, $branch, $admtext;

	setFamilyLabel( $personID, $gender );
	if( $gender[self] ) {
		$query = "SELECT $gender[spouse], familyID FROM $families_table WHERE $gender[self] = \"$personID\" AND gedcom = \"$tree\" ORDER BY $gender[spouseorder]";
		$spouseresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		while( $spouserow = mysql_fetch_assoc( $spouseresult ) )
			setPersonLabel( $spouserow[$gender[spouse]] );
	}
}

function doAncestors( $personID, $gender, $gen ) {
	global $dagens, $tree, $agens, $children_table, $families_table, $branch, $husbgender, $wifegender, $admtext, $dospouses;

	setPersonLabel( $personID );
	setFamilyLabel( $personID, $gender );
	if($dospouses) setSpousesLabel( $personID, $gender );

	if( $gen <= $agens ) {
		$query = "SELECT $children_table.familyID as familyID, husband, wife FROM ($children_table, $families_table) WHERE $children_table.familyID = $families_table.familyID AND personID = \"$personID\" AND $children_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
		$familyresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
		while( $familyrow = mysql_fetch_assoc( $familyresult ) ) {
			if( $dagens ) {
				$query = "SELECT personID FROM $children_table WHERE familyID = \"$familyrow[familyID]\" AND gedcom = \"$tree\"";
				$childresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				while( $childrow = mysql_fetch_assoc( $childresult ) ) {
					$newgender = getGender( $childrow[personID] );
					setPersonLabel( $childrow[personID] );
					setFamilyLabel( $childrow[personID], $newgender );
					if($dospouses) setSpousesLabel( $childrow[personID], $newgender );
					doDescendants( $childrow[personID], $newgender, 1, $dagens );
				}
			}
			if( $familyrow[husband]  )
				doAncestors( $familyrow[husband], $husbgender, $gen + 1 );
			if( $familyrow[wife] )
				doAncestors( $familyrow[wife], $wifegender, $gen + 1 );
		}
	}
}

function doDescendants( $personID, $gender, $gen, $maxgen ) {
	global $tree, $dgens, $people_table, $families_table, $children_table, $admtext, $dospouses;

	if( $gender['spouseorder'] )
		$query = "SELECT familyID FROM $families_table WHERE $gender[self] = \"$personID\" AND gedcom = \"$tree\" ORDER BY $gender[spouseorder]";
	else
		$query = "SELECT familyID FROM $families_table WHERE gedcom = \"$tree\" AND (husband = \"$personID\" OR wife = \"$personID\")";
	$spouseresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	while( $spouserow = mysql_fetch_assoc( $spouseresult ) ) {
		//setPersonLabel( $spouserow[$gender[spouse]] );
		$query = "SELECT personID FROM $children_table WHERE familyID = \"$spouserow[familyID]\" AND gedcom = \"$tree\" ORDER BY ordernum";
		$childresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		while( $childrow = mysql_fetch_assoc( $childresult ) ) {
			$newgender = getGender( $childrow[personID] );
			setPersonLabel( $childrow[personID] );
			setFamilyLabel( $childrow[personID], $newgender );
			if($dospouses) setSpousesLabel( $childrow[personID], $newgender );
			if( $gen < $maxgen )
				doDescendants( $childrow[personID], $newgender, $gen + 1, $maxgen );
		}
		mysql_free_result( $childresult );
	}
	mysql_free_result( $spouseresult );
}

$flags[tabs] = $tngconfig['tabs'];
tng_adminheader( $admtext['labelbranches'], $flags );
?>
</head>

<body background="../background.gif">

<?php
	$branchtabs[0] = array(1,"branches.php",$admtext['search'],"findbranch");
	$branchtabs[1] = array($allow_add,"newbranch.php",$admtext[addnew],"addbranch");
	$branchtabs[2] = array($allow_edit,"#",$admtext['labelbranches'],"label");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/branches_help.php#labelbranch', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($branchtabs,"label",$innermenu);
	echo displayHeadline("$admtext[branches] &gt;&gt; $admtext[labelbranches]","branches_icon.gif",$menu,$message);
?>
<div class="lightback" style="padding:2px">
<div class="databack normal" style="padding:5px">

<?php
	if( $branchaction == "clear" ) {
		$branchtitle = $admtext['clearingbranch'];
		//$branchclause = $set == "all" ? "" : " AND branch = \"$branch\"";
		//$branch = "";
		$overwrite = 1;
	}
	elseif($branchaction == "delete") {
		$branchtitle = "DELETING BRANCH";
		$overwrite = 0;
	}
	else {
		$branchtitle = $admtext['addingbranch'];
		$branchclause = $overwrite ? "" : " AND branch = \"\"";
	}
	echo "<p><strong>$branchtitle</strong></p>";

	if( $set == "all" ) {
		//all only works for deleting
		if($branchaction == "clear") {
			$counter = clearBranch($people_table,$branch);
			$fcounter = clearBranch($families_table,$branch);
		}
		else {   //deleting
			$counter = deleteBranch($people_table,$branch);
			$fcounter = deleteBranch($families_table,$branch);
		}

		$query = "DELETE FROM $branchlinks_table WHERE gedcom = \"$tree\" AND branch = \"$branch\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	}
	else {
		$gender = getGender( $personID );
		if( $agens > 0 )
			doAncestors( $personID, $gender, 1 ); 
		else {
			setPersonLabel( $personID );
			setFamilyLabel( $personID, $gender );
			if($dospouses) setSpousesLabel( $personID, $gender );
		}
		if( $dagens > $dgens ) $dgens = $dagens;
		if( $dgens > 0 )
			doDescendants( $personID, $gender, 1, $dgens );
	}
	if( $counter || $fcounter ) echo "<br/><br/>";
	echo "<span class=\"normal\">$admtext[totalaffected]: $counter $admtext[people], $fcounter $admtext[families].</span>";

	adminwritelog( "$admtext[labelbranches]: $tree/$branch ($branchaction/$set)" );
?>

<p class="normal"><a href="branchmenu.php?tree=<?php echo "$tree&amp;branch=$branch"; ?>"><?php echo $admtext['labelmore']; ?></a></p>

</div></div>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
