<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "secondary";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

require("adminlog.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[secondarymaint], $flags );
?>
</head>

<body background="../background.gif">

<?php
	$datatabs[0] = array(1,"dataimport.php",$admtext[import],"import");
	$datatabs[1] = array(1,"export.php",$admtext[export],"export");
	$datatabs[2] = array(1,"secondmenu.php",$admtext[secondarymaint],"second");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/second_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($datatabs,"second",$innermenu);
	echo displayHeadline("$admtext[datamaint] &gt;&gt; $admtext[secondarymaint] &gt;&gt; $secaction","data_icon.gif",$menu,$message);
?>

<div class="lightback" style="padding:2px">
<div class="databack normal" style="padding:5px">

<?php
@set_time_limit(0);
$wherestr = "";
if( $secaction == $admtext[sortchildren] ) {
	echo "<p>" . $admtext['sortingchildren'] . "</p>";
	echo "$admtext[families]:<br/>\n";
	$fcount = 0;
	if( $tree != "--all--" ) {
		$wherestr = "WHERE $families_table.gedcom = \"$tree\"";
		$wherestr2 = "AND $children_table.gedcom = \"$tree\"";
	}
	$query = "SELECT familyID, gedcom FROM $families_table $wherestr";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $family = mysql_fetch_assoc( $result ) ) {
		$query = "SELECT $children_table.ID as ID, IF(birthdatetr !='0000-00-00',birthdatetr,altbirthdatetr) as birth FROM $children_table, $people_table 
			WHERE $children_table.familyID = \"$family[familyID]\" AND $people_table.personID = $children_table.personID AND $people_table.gedcom = $children_table.gedcom $wherestr2
			ORDER BY birth, ordernum";
		$fresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$order = 0;
		while( $child = mysql_fetch_assoc( $fresult ) ) {
			$order++;
			$query = "UPDATE $children_table SET ordernum=\"$order\" WHERE ID=\"$child[ID]\"";
			$cresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
		$fcount++;
		if( $fcount % 100 == 0 ) {
			echo "<strong>$fcount</strong> ";
		}
		mysql_free_result( $fresult );
	}
	mysql_free_result( $result );
	echo "<br/><br/>$admtext[finishedsort]<br/>";
}
elseif( $secaction == $admtext[sortspouses] ) {

	echo "<p>" . $admtext['sortingspouses'] . "</p>";
	echo "$admtext[people]:<br/>\n";
	$fcount = 0;
	if( $tree != "--all--" ) {
		$wherestr = " AND $families_table.gedcom = \"$tree\"";
	}
	//first do husbands
	$query = "SELECT personID, $families_table.gedcom as gedcom FROM $families_table, $people_table WHERE $people_table.personID = $families_table.husband AND $people_table.gedcom = $families_table.gedcom $wherestr";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $husband = mysql_fetch_assoc( $result ) ) {
		$query = "SELECT ID FROM $families_table 
			WHERE husband = \"$husband[personID]\" AND gedcom = \"$husband[gedcom]\"
			ORDER BY marrdatetr, husborder";
		$fresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$order = 0;
		while( $spouse = mysql_fetch_assoc( $fresult ) ) {
			$order++;
			$query = "UPDATE $families_table SET husborder=\"$order\" WHERE ID=\"$spouse[ID]\"";
			$cresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
		$fcount++;
		if( $fcount % 100 == 0 ) {
			echo "<strong>$fcount</strong> ";
		}
		mysql_free_result( $fresult );
	}
	mysql_free_result( $result );
	
	//now do wives
	$query = "SELECT personID, $families_table.gedcom as gedcom FROM $families_table, $people_table WHERE $people_table.personID = $families_table.wife AND $people_table.gedcom = $families_table.gedcom $wherestr";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $wife = mysql_fetch_assoc( $result ) ) {
		$query = "SELECT ID FROM $families_table 
			WHERE wife = \"$wife[personID]\" AND gedcom = \"$wife[gedcom]\"
			ORDER BY marrdatetr, wifeorder";
		$fresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$order = 0;
		while( $spouse = mysql_fetch_assoc( $fresult ) ) {
			$order++;
			$query = "UPDATE $families_table SET wifeorder=\"$order\" WHERE ID=\"$spouse[ID]\"";
			$cresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
		$fcount++;
		if( $fcount % 100 == 0 ) {
			echo "<strong>$fcount</strong> ";
		}
		mysql_free_result( $fresult );
	}
	mysql_free_result( $result );
	echo "<br/><br/>$admtext[finishedsort]<br/>";
}
elseif( $secaction == $admtext['creategendex'] ) {
	//create gendex file
	function getVitals ($person) {
		if( $person['birthdate'] ) {
			$info = "$person[birthdate]|$person[birthplace]|";
		}
		else {
			$info = "$person[altbirthdate]|$person[altbirthplace]|";
		}
		if( $person['deathdate'] ) {
			$info .= "$person[deathdate]|$person[deathplace]|";
		}
		else {
			$info .= "$person[burialdate]|$person[burialplace]|";
		}
		return $info;
	}
	echo "<p>" . $admtext['creatinggendex'] . "</p>";
	if( $tree == "--all--" ) {
		$gendexout = "$rootpath$gendexfile/gendex.txt";
		$gendexURL = "$tngdomain/$gendexfile/gendex.txt";
	}
	else {
		$wherestr = "WHERE gedcom = \"$tree\"";
		$gendexout = $tree ? "$rootpath$gendexfile/$tree.txt" : "$rootpath$gendexfile/blanktree.txt";
		$gendexURL = $tree ? "$tngdomain/$gendexfile/$tree.txt" : "$tngdomain/$gendexfile/blanktree.txt";
	}
	$query = "SELECT personID, firstname, lnprefix, lastname, living, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, gedcom FROM $people_table $wherestr ORDER BY lastname, firstname";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	if( $result ) {
		//open file (overwrite any contents)
		$fp2 = @fopen( $gendexout, "w" );
		if( !$fp2 ) { die ( "$admtext[cannotopen] $gendexout" ); }

		flock( $fp2, LOCK_EX );
		$tcount = 0;
		while( $person = mysql_fetch_assoc( $result ) ) {
			if( !$person[living] || $nonames != 1 ) {
				$uclast = strtoupper( trim( "$person[lnprefix] $person[lastname]" ) );
				$person[lastname] = $uclast;
				$info = $person[living] ? "||||" : getVitals( $person );
				if( $person[living] && $nonames == 2 )
					$line = "$person[personID]&tree=$person[gedcom]|$uclast|" . initials( $person[firstname] ) . " /$uclast/|$info\n";
				else
					$line = "$person[personID]&tree=$person[gedcom]|$uclast|$person[firstname] /$uclast/|$info\n";
				fwrite( $fp2, "$line" );

				$tcount++;
				if( $tcount % 100 == 0 ) {
					echo "<strong>$tcount</strong> ";
				}
			}
		}
		flock( $fp2, LOCK_UN );
		fclose( $fp2 );
	}
	mysql_free_result( $result );
?>
	<br><br>
<?php
	echo "<p class=\"normal\">" . $admtext['finishedgendex'] . "<br />\n";
	echo $admtext['filename'] . ": $gendexURL</p>\n";

	echo "<p class=\"normal\">&raquo; <a href=\"http://tngnetwork.lythgoes.net\" target=\"_blank\">" . $admtext['tngnet'] . "</a></p>\n";
}
elseif( $secaction == $admtext['tracklines'] ) {
	echo "<p class=\"normal\">" . $admtext['trackinglines'] . "</p>";
	echo "$admtext[families]:<br/>\n";

	$query = "UPDATE $children_table SET haskids = 0";
	if( $tree != "--all--" )
		$query .= " WHERE gedcom = \"$tree\"";
	$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$fcount = 0;
	if( $tree != "--all--" )
		$wherestr = "AND $families_table.gedcom = \"$tree\"";
	$query = "SELECT distinct ($families_table.familyID), husband, wife, $families_table.gedcom as gedcom FROM ($children_table, $families_table) WHERE $families_table.familyID = $children_table.familyID AND $families_table.gedcom = $children_table.gedcom $wherestr";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $family = mysql_fetch_assoc( $result ) ) {
		if( $family[husband] != "" ) {
			$query = "UPDATE $children_table SET haskids = 1 WHERE personID = \"$family[husband]\" AND gedcom = \"$family[gedcom]\"";
			$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
		if( $family[wife] != "" ) {
			$query = "UPDATE $children_table SET haskids = 1 WHERE personID = \"$family[wife]\" AND gedcom = \"$family[gedcom]\"";
			$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
		$fcount++;
		if( $fcount % 100 == 0 ) {
			echo "<strong>$fcount</strong> ";
		}
	}
	mysql_free_result( $result );
	echo "<br/><br/>$admtext[finishedtracking]<br/>";
}
elseif( $secaction == $admtext['relabelbranches'] ) {
	echo "<p>" . $admtext['relabeling'] . "</p>";
	if( $tree != "--all--" )
		$wherestr = "WHERE gedcom = \"$tree\"";
	$query = "SELECT branch, persfamID, gedcom FROM $branchlinks_table $wherestr";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $branch = mysql_fetch_assoc( $result ) ) {
		$success = 0;
		if( substr( $branch[persfamID], 0, 1 ) != "F" ) {
			$query = "SELECT branch FROM $people_table WHERE personID = \"$branch[persfamID]\" AND gedcom = \"$branch[gedcom]\"";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( mysql_num_rows( $result2 ) ) {
				$row = mysql_fetch_assoc( $result2 );
				$oldbranches = explode( ",", $row[branch] );
				if( $row[branch] ) {
					if( in_array( $branch[branch], $oldbranches ) )
						$label = $row[branch];
					else
						$label = "$row[branch],$branch[branch]";
				}
				else
					$label = $branch[branch];
				$query = "UPDATE $people_table SET branch = \"$label\" WHERE personID = \"$branch[persfamID]\" AND gedcom = \"$branch[gedcom]\"";
				$result3 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				$success = 1;
			}
			mysql_free_result( $result2 );
		}
		if( !$success ) {
			$query = "SELECT branch FROM $families_table WHERE familyID = \"$branch[persfamID]\" AND gedcom = \"$branch[gedcom]\"";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( mysql_num_rows( $result2 ) ) {
				$row = mysql_fetch_assoc( $result2 );
				$oldbranches = explode( ",", $row[branch] );
				if( $row[branch] ) {
					if( in_array( $branch[branch], $oldbranches ) )
						$label = $row[branch];
					else
						$label = "$row[branch],$branch[branch]";
				}
				else
					$label = $branch[branch];
				$query = "UPDATE $families_table SET branch = \"$label\" WHERE familyID = \"$branch[persfamID]\" AND gedcom = \"$branch[gedcom]\"";
				$result3 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				$success = 1;
			}
			mysql_free_result( $result2 );
		}
		if( $success ) {
			$fcount++;
			if( $fcount % 100 == 0 ) {
				echo "<strong>$fcount</strong> ";
			}
		}
	}
	mysql_free_result( $result );
}

adminwritelog( "$admtext[secondary]: $secaction" );
?>

<p class="normal">&raquo; <a href="secondmenu.php"><?php echo $admtext['backtosecondary']; ?></a></p>

</div></div>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
