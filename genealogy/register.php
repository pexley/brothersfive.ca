<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
if(!$personID) die("no args");
$textpart = "pedigree";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "reglib.php" );
include($subroot . "pedconfig.php");

$getperson_url = getURL( "getperson", 1 );
$register_url = getURL( "register", 1 );
$descend_url = getURL( "descend", 1 );
$descendtext_url = getURL( "descendtext", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$desctracker_url = getURL( "desctracker", 1 );
$pdfform_url = getURL( "pdfform", 1 );

$generation = 1;
$personcount = 1;

$currgen = array();
$nextgen = array();

$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, title, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = !$assignedbranch || $assignedbranch == $row[branch] ? 1 : 0;
	$row[allow_living] = !$row[living] || ( $allow_living && $rightbranch ) ? 1 : 0;
	$row[name] = getName( $row );
	$logname = $nonames && $row[living] ? $text[living] : $row[name];
	$row[genlist] = "";
	$row[trail] = $personID;
	$row[number] = 1;
	$row[spouses] = getSpouses( $personID, $row[sex] );
	$disallowgedcreate = $row[disallowgedcreate];
	array_push( $currgen, $row );
}

writelog( "<a href=\"$register_url" . "personID=$personID&amp;tree=$tree\">$text[descendfor] $logname ($personID)</a>" );
preparebookmark( "<a href=\"$register_url" . "personID=$personID&amp;tree=$tree\">$text[descendfor] $row[name] ($personID)</a>" );

$flags[tabs] = $tngconfig[tabs];
$flags['scripting'] = "<script type=\"text/javascript\">var tnglitbox;</script>\n";
tng_header( $row[name], $flags );

	$photostr = showSmallPhoto( $personID, $row[name], $row[allow_living], 0 );
	echo tng_DrawHeading( $photostr, $row[name], getYears( $row ) );
	echo tng_coreicons();

	if( !$pedigree[maxdesc] ) $pedigree[maxdesc] = 12;
	if( !$pedigree[maxdesc] ) $pedigree[maxdesc] = 8;
	if( !$generations )
	    $generations = $pedigree[initdescgens] > 8 ? 8 : $pedigree[initdescgens];
	else if( $generations > $pedigree[maxdesc] )
		$generations = $pedigree[maxdesc];
	else
		$generations = intval( $generations );

	$innermenu = "$text[generations]: &nbsp;";
	$innermenu .= "<select name=\"generations\" style=\"font-size:9px\" onChange=\"window.location.href='$register_url" . "personID=$personID&amp;tree=$tree&amp;generations=' + this.options[this.selectedIndex].value\">\n";
    for( $i = 1; $i <= $pedigree[maxdesc]; $i++ ) {
        $innermenu .= "<option value=\"$i\"";
        if( $i == $generations ) $innermenu .= " selected";
        $innermenu .= ">$i</option>\n";
    }
	$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
$innermenu .= "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=standard&amp;generations=$generations\" class=\"lightlink\">$text[pedstandard]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=compact&amp;generations=$generations\" class=\"lightlink\">$text[pedcompact]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$descendtext_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink\">$text[pedtextonly]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$register_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink3\">$text[regformat]</a>\n";
if($generations <= 12)
	$innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"#\" class=\"lightlink\" onclick=\"tnglitbox = new LITBox('$pdfform_url" . "pdftype=desc&personID=$personID&tree=$tree&generations=$generations',{width:350,height:350});return false;\">PDF</a>\n";

	echo getFORM( "register", "GET", "form1", "form1" );
	echo tng_menu( "I", "descend", $personID, $innermenu );
	echo "</form>\n";
?>
<div align="left">
<?php
while( count( $currgen ) && $generation <= $generations ) {
	echo "<span class=\"subhead\"><strong>$text[generation]: $generation</strong></span><br/>\n";
	echo "<ol class=\"normal\">\n";
	while( $row = array_shift( $currgen ) ) {
		echo "<li value=\"$row[number]\"><a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$tree\">$row[name]</a>";
		if( $row[genlist] )
			echo " <a href=\"$desctracker_url" . "trail=$row[trail]&amp;tree=$tree\" title=\"$text[graphdesc]\"><img src=\"$cms[tngpath]" . "dchart.gif\" width=\"10\" height=\"9\" alt=\"$text[graphdesc]\" border=\"0\"/></a> ($row[genlist])";
		echo getVitalDates( $row );
		if( $row[allow_living] && $pedigree[regnotes] ) {
			$notes = buildNotes(getNotes( $row[personID], "I" ));
			if( $notes ) {
				echo "<br/><br/>$text[notes]:<br/>";
				echo "<blockquote style=\"margin:0 15px 0px 15px\">\n$notes</blockquote>\n";
			}
		}
		echo "<br/>\n";
		
		$fname = $row[firstname];
		$firstfirstname = getFirstNameOnly( $row );
		$newlist = "$row[number].$firstfirstname<sup>$generation</sup>";
		if( $row[genlist] ) $newlist .= ", $row[genlist]";
		while( $spouserow = array_shift( $row[spouses] ) ) {
			echo "$firstfirstname $text[marrabbr] <a href=\"$getperson_url" . "personID=$spouserow[personID]&amp;tree=$tree\">$spouserow[name]</a>";
			echo getSpouseDates( $spouserow );
			$spouseinfo = getVitalDates( $spouserow );
			$spparents = $spouserow['personID'] ? getSpouseParents( $spouserow['personID'], $spouserow['sex'] ) : $text['unknown'];
			if( $spouseinfo ) {
				$spname = getName( $spouserow );
				$spfirstfirstname = getFirstNameOnly( $spouserow, " " );
				echo " $spfirstfirstname $spparents $spouseinfo";
			}
			else
				echo " $spparents";
			echo " [<a href=\"$familygroup_url" . "familyID=$spouserow[familyID]&amp;tree=$tree\">$text[groupsheet]</a>]<br/>\n";

			$query = "SELECT $children_table.personID as personID, firstname, lnprefix, lastname, prefix, suffix, title, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch FROM $children_table, $people_table WHERE familyID = \"$spouserow[familyID]\" AND $children_table.personID = $people_table.personID AND $children_table.gedcom = \"$tree\" AND $people_table.gedcom = \"$tree\" ORDER BY ordernum";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( $result2 && mysql_num_rows( $result2 ) ) {
				echo "<br/>$text[children]:<br/>\n<ol>\n";
				while( $childrow = mysql_fetch_assoc( $result2 ) ) {
					$childID = $childrow[personID];
					if( $nextgen[$childID] ) {
						$displaycount = $nextgen[$childID][number];
						$name = $nextgen[$childID][name];
						$vitaldates = getVitalDates( $nextgen[$childID] );
					}
					else {
						$personcount++;
						$displaycount = $personcount;
						$childrow[spouses] = getSpouses( $childID, $childrow[sex] );
						$childrow[genlist] = $newlist;
						$childrow[trail] = "$row[trail],$spouserow[familyID],$childID";
						$childrow[number] = $personcount;
						$childrow[allow_living] = !$childrow[living] || ( $allow_living && ( !$assignedbranch || $assignedbranch == $childrow[branch] ) ) ? 1 : 0;
						$childrow[name] = $name = getName( $childrow );
						$vitaldates = getVitalDates( $childrow );
						if( $childrow[spouses] || !$pedigree[regnosp] )
							$nextgen[$childID] = $childrow;
					}
					echo "<li type=\"i\">$displaycount. <a href=\"$getperson_url" . "personID=$childID&amp;tree=$tree\">$name</a> &nbsp;<a href=\"$desctracker_url" . "trail=$childrow[trail]&amp;tree=$tree\"><img src=\"$cms[tngpath]" . "dchart.gif\" width=\"10\" height=\"9\" alt=\"$text[graphdesc]\" border=\"0\"/></a> $vitaldates</li>\n";
				}
				echo "</ol>\n";
				mysql_free_result( $result2 );
			}
			echo "<br/>\n";
		}
		echo "</li>\n";
	}
	$currgen = $nextgen;
	unset( $nextgen );
	$nextgen = array();
	$generation++;
	echo "</ol>\n<br/>\n";
}
?>
</ol>
</div>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>litbox.js"></script>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>rpt_utils.js"></script>
<?php
	tng_footer( "" );
?>
