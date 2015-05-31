<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

include( "prefixes.php" );

if( !$allow_edit || $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

//can only start if in maintenance mode

$helplang = findhelp("backuprestore_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[backuprestore], $flags );
?>
</head>

<body background="../background.gif">

<?php
	$utiltabs[0] = array(1,"backuprestore.php?sub=tables",$admtext['backuprestoretables'],"tables");
	$utiltabs[1] = array(1,"backuprestore.php?sub=structure",$admtext['backupstruct'],"structure");
	$utiltabs[2] = array(1,"renumbermenu.php",$admtext['renumber'],"renumber");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/backuprestore_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($utiltabs,"renumber",$innermenu);
	$headline = "$admtext[backuprestore] &gt;&gt; $admtext[renumber]";
	echo displayHeadline($headline,"backuprestore_icon.gif",$menu,$message);
?>
<div class="lightback" style="padding:2px">
<div class="databack normal" style="padding:5px">

<?php
$nextnum = isset($start) ? $start : 1;
if(!isset($digits)) $digits = 0;
if(!isset($type)) $type = "person";
$count = 0;

eval( "\$prefix = \$$type" . "prefix;" );
eval( "\$suffix = \$$type" . "suffix;" );

//choose to do people, families, sources or repos
if($type == "person") {
	$table = $people_table;
	$id = "personID";
}
elseif($type == "family") {
	$table = $families_table;
	$id = "familyID";
}
elseif($type == "source") {
	$table = $sources_table;
	$id = "sourceID";
}
elseif($type == "repo") {
	$table = $repositories_table;
	$id = "repoID";
}

//get all people after start number, sorted on ID (not including prefix)
if( $prefix ) {
	$prefixlen = strlen( $prefix ) + 1;
	
	$query = "SELECT ID, $id, (0+SUBSTRING($id,$prefixlen)) as num FROM $table WHERE gedcom = \"$tree\" AND (0+SUBSTRING($id,$prefixlen)) >= $nextnum ORDER BY num";
}
else
	$query = "SELECT ID, $id, (0+SUBSTRING_INDEX($id,'$suffix',1)) as num FROM $table WHERE gedcom = \"$tree\" AND (0+SUBSTRING_INDEX($id,'$suffix',1)) >= $nextnum ORDER BY num";

$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

while($row = mysql_fetch_assoc($result)) {
	if($row['num'] < $nextnum)
		break;
	if($row['num'] >= $nextnum) {
		$newID = $digits ? ($prefix . str_pad( $nextnum, $digits, "0", STR_PAD_LEFT ) . $suffix) : ($prefix . $nextnum . $suffix);

		$query = "SELECT ID from $table WHERE gedcom=\"$tree\" AND $id=\"$newID\"";
		$result1 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		if(!mysql_num_rows($result1)) {
			//if(mysql_num_rows($result1)) die ("Problem: destination ID ($newID) already exists. Operation aborted.");

			//change ID in people to match next #
			$query = "UPDATE $table SET $id=\"$newID\" WHERE ID=\"$row[ID]\"";
			$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			if($type == "person") {
				$query = "UPDATE $families_table SET husband=\"$newID\" WHERE gedcom=\"$tree\" AND husband=\"$row[personID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

				$query = "UPDATE $families_table SET wife=\"$newID\" WHERE gedcom=\"$tree\" AND wife=\"$row[personID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

				$query = "UPDATE $children_table SET personID=\"$newID\" WHERE gedcom=\"$tree\" AND personID=\"$row[personID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

				$query = "UPDATE $assoc_table SET personID=\"$newID\" WHERE gedcom=\"$tree\" AND personID=\"$row[personID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

				$query = "UPDATE $temp_events_table SET personID=\"$newID\" WHERE gedcom=\"$tree\" AND personID=\"$row[personID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

				$query = "UPDATE $mostwanted_table SET personID=\"$newID\" WHERE gedcom=\"$tree\" AND personID=\"$row[personID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			}

			if($type == "family") {
				$query = "UPDATE $children_table SET familyID=\"$newID\" WHERE gedcom=\"$tree\" AND familyID=\"$row[familyID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

				$query = "UPDATE $people_table SET famc=\"$newID\" WHERE famc=\"$row[familyID]\" AND gedcom = \"$tree\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

				$query = "UPDATE $temp_events_table SET familyID=\"$newID\" WHERE gedcom=\"$tree\" AND familyID=\"$row[familyID]\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			}

			$query = "UPDATE $events_table SET persfamID=\"$newID\" WHERE gedcom=\"$tree\" AND persfamID=\"" . $row[$id] . "\"";
			$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			$query = "UPDATE $medialinks_table SET personID=\"$newID\" WHERE gedcom=\"$tree\" AND personID=\"" . $row[$id] . "\"";
			$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			if($type == "person" || $type == "family") {
				$query = "UPDATE $branchlinks_table SET persfamID=\"$newID\" WHERE gedcom=\"$tree\" AND persfamID=\"" . $row[$id] . "\"";
				$result2 = @mysql_query($query);
				$success = mysql_affected_rows();
				if(!$success) {
					$query = "DELETE FROM $branchlinks_table WHERE gedcom=\"$tree\" AND persfamID=\"" . $row[$id] . "\"";
					$result2 = @mysql_query($query);
				}
			}

			$query = "UPDATE $album2entities_table SET entityID=\"$newID\" WHERE gedcom=\"$tree\" AND entityID=\"" . $row[$id] . "\"";
			$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			if($type == "source") {
				$query = "UPDATE $citations_table SET sourceID=\"$newID\" WHERE gedcom=\"$tree\" AND sourceID=\"" . $row[$id] . "\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			}
			else {
				$query = "UPDATE $citations_table SET persfamID=\"$newID\" WHERE gedcom=\"$tree\" AND persfamID=\"" . $row[$id] . "\"";
				$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			}

			$query = "UPDATE $notelinks_table SET persfamID=\"$newID\" WHERE gedcom=\"$tree\" AND persfamID=\"" . $row[$id] . "\"";
			$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			//echo "$row[personID] -&gt; $newID<br>";
			$count++;
			if( $count % 10 == 0 ) {
				echo "<strong>$count</strong> ";
			}
		}
		mysql_free_result($result1);
	}
	$nextnum++;
}
mysql_free_result($result);

echo "<p class=\"normal\">$admtext[finreseq]: $count $admtext[recsreseq]</p>\n";
echo "</div></div>\n";
echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>";
?>
</body>
</html>
