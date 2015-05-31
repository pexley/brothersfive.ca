<?php
include("begin.php");
include($subroot . "pedconfig.php");
include($cms['tngpath'] . "genlib.php");
if(!$personID) die("no args");
$textpart = "pedigree";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "reglib.php" );

$getperson_url = getURL( "getperson", 1 );
$descend_url = getURL( "descend", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$ahnentafel_url = getURL( "ahnentafel", 1 );
$pedigree_url = getURL( "pedigree", 1 );
$pedigreetext_url = getURL( "pedigreetext", 1 );
$extrastree_url = getURL( "extrastree", 1 );
$pdfform_url = getURL( "pdfform", 1 );

$generation = 1;
$personcount = 1;

$currgen = array();
$nextgen = array();
$numbers = array();
$lastgen = array();
$lastlastgen = array();

$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, famc, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row[branch] );
	$row['allow_living'] = !$row[living] || ( $allow_living && $rightbranch ) ? 1 : 0;
	$row['name'] = getName( $row );
	//if( $row[name] == $text[living] ) $row[firstname] = $text[living];
	$firstfirstname = getFirstNameOnly( $row );

	$logname = $nonames && $row[living] ? $text[living] : $row[name];
	$row['genlist'] = "";
	$row['number'] = 1;
	$row['spouses'] = getSpouses( $personID, $row[sex] );
	$disallowgedcreate = $row[disallowgedcreate];
	$lastlastgen[$personID] = 1;
}

writelog( "<a href=\"$ahnentafel_url" . "personID=$personID&amp;tree=$tree\">" . xmlcharacters("$text[ahnentafel]: $logname ($personID)") . "</a>" );
preparebookmark( "<a href=\"$ahnentafel_url" . "personID=$personID&amp;tree=$tree\">" . xmlcharacters("$text[ahnentafel]: " . $row['name'] . " ($personID)") . "</a>" );

$flags['tabs'] = $tngconfig[tabs];
$flags['scripting'] = "<script type=\"text/javascript\">var tnglitbox;</script>\n";
tng_header( $row[name], $flags );

	$photostr = showSmallPhoto( $personID, $row[name], $row[allow_living], 0 );
	echo tng_DrawHeading( $photostr, $row[name], getYears( $row ) );
	echo tng_coreicons();

	if( !$pedigree[maxgen] ) $pedigree[maxgen] = 6;
	if( $generations > $pedigree[maxgen] ) 
	    $generations = $pedigree[maxgen];
	else if( !$generations ) 
	    $generations = $pedigree[maxgen] < 4 ? $pedigree[maxgen] : 4;

	$innermenu = "$text[generations]: &nbsp;";
	$innermenu .= "<select name=\"generations\" style=\"font-size:9px\" onChange=\"window.location.href='$ahnentafel_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=' + this.options[this.selectedIndex].value\">\n";
    for( $i = 1; $i <= $pedigree[maxgen]; $i++ ) {
        $innermenu .= "<option value=\"$i\"";
        if( $i == $generations ) $innermenu .= " selected";
        $innermenu .= ">$i</option>\n";
    }
	$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
	$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=standard&amp;generations=$generations\" class=\"lightlink\" id=\"stdpedlnk\">$text[pedstandard]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=compact&amp;generations=$generations\" class=\"lightlink\" id=\"compedlnk\">$text[pedcompact]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=box&amp;generations=$generations\" class=\"lightlink\" id=\"boxpedlnk\">$text[pedbox]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$pedigreetext_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink\">$text[pedtextonly]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$ahnentafel_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink3\">$text[ahnentafel]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$extrastree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;showall=1&amp;generations=$generations\" class=\"lightlink\">$text[media]</a>\n";
	if($generations <= 6)
		$innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"#\" class=\"lightlink\" onclick=\"tnglitbox = new LITBox('$pdfform_url" . "pdftype=ped&personID=$personID&tree=$tree&generations=$generations',{width:350,height:350});return false;\">PDF</a>\n";

	echo getFORM( "pedigree", "", "form1", "form1" );
	echo tng_menu( "I", "pedigree", $personID, $innermenu );
	echo "</form>\n";
?>
<div align="left">
<?php
//do self
echo "<span class=\"subhead\"><strong>$text[generation]: 1</strong></span><br/>\n";
echo "<ol style=\"margin:0px;padding:10px,0px,10px,65px\" class=\"normal\">\n";
echo "<li value=\"$personcount\"><a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$tree\">$row[name]</a>";
echo getVitalDates( $row );
if( $row[allow_living] && $pedigree[regnotes] ) {
	$notes = buildNotes(getNotes( $row[personID], "I" ));
	if( $notes ) {
		echo "<br/><br/>$text[notes]:<br/>";
		echo "<blockquote style=\"margin:0 15px 0px 15px\">\n$notes</blockquote>\n";
	}
}
else
	$notes = "";
echo "<br/>\n";
if(!$notes) echo "<br/>\n";

//do spouse
while( $spouserow = array_shift( $row[spouses] ) ) {

	echo "$firstfirstname $text[marrabbr] <a href=\"$getperson_url" . "personID=$spouserow[personID]&amp;tree=$tree\">$spouserow[name]</a>";
	echo getSpouseDates( $spouserow );
	$spouseinfo = getVitalDates( $spouserow );
	if( $spouseinfo ) {
		$spfirstfirstname = getFirstNameOnly( $spouserow );
		echo " $spfirstfirstname $spparents $spouseinfo";
	}
	echo " [<a href=\"$familygroup_url" . "familyID=$spouserow[familyID]&amp;tree=$tree\">$text[groupsheet]</a>]<br/>\n";

	if($pedigree[regnotes]) {
		$fam_allow_living = !$spouserow[living] || ( $allow_living && checkbranch( $spouserow[branch] ) ) ? 1 : 0;
		if($fam_allow_living) {
			$notes = buildNotes(getNotes( $spouserow[familyID], "F" ));
			if( $notes ) {
				echo "<br/>$text[notes]:<br/>";
				echo "<blockquote style=\"margin:0 15px 0px 15px\">\n$notes</blockquote>\n";
			}
		}
	}

	$query = "SELECT $children_table.personID as personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch FROM $children_table, $people_table WHERE familyID = \"$spouserow[familyID]\" AND $children_table.personID = $people_table.personID AND $children_table.gedcom = \"$tree\" AND $people_table.gedcom = \"$tree\" ORDER BY ordernum";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $result2 && mysql_num_rows( $result2 ) ) {
		echo "<br/>$text[children]:<br/><ol style=\"margin:0px;padding:10px 0px 10px 65px\">\n";
		while( $childrow = mysql_fetch_assoc( $result2 ) ) {
			$childrow[genlist] = $newlist;
			$childrow[allow_living] = !$childrow[living] || ( $allow_living && checkbranch( $childrow[branch] ) ) ? 1 : 0;
			$childrow[name] = getName( $childrow );
			if( $childrow[name] == $text[living] ) $childrow[firstname] = $text[living];

			echo "<li type=\"i\"><a href=\"$getperson_url" . "personID=$childrow[personID]&amp;tree=$tree\">$childrow[name]</a>";
			echo getVitalDates( $childrow );
			echo "</li>\n";
		}
		echo "</ol>\n";
		mysql_free_result( $result2 );
	}
	echo "<br/>\n";
}
echo "</li>\n</ol>\n";

//push famc (family of parents) to nextgen
$parentfamID = "";
$locparentset = $parentset;
$parentscount = 0;
$parentfamIDs = array();
$query = "SELECT familyID FROM $children_table WHERE personID = \"$personID\" AND gedcom = \"$tree\" ORDER BY parentorder";
$parents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if ( $parents ) {
	$parentscount = mysql_num_rows( $parents );
	if ( $parentscount > 0 ) {
		if ( $locparentset > $parentscount )
			$locparentset = $parentscount;
		$i = 0;
		while ( $parentrow = mysql_fetch_assoc( $parents ) ) {
			$i++;
			if( $i == $locparentset )
				$parentfamID = $parentrow[familyID];
			$parentfamIDs[$i] = $parentrow[familyID];
		}
		if(!$parentfamID) $parentfamID = $row[famc];
	}
	mysql_free_result($parents);
}

array_push( $currgen, $parentfamID );
$generation++;
$personcount = 1;
$numbers[$parentfamID] = 1;

//loop through nextgen
//while there's one to pop and we're less than maxgen
while( count( $currgen ) && $generation <= $generations ) {
	echo "<span class=\"subhead\"><strong>$text[generation]: $generation</strong></span><br/>\n";
	echo "<ol style=\"margin:0px;padding:10px 0px 10px 65px\" class=\"normal\">\n";
	while( $nextfamily = array_shift( $currgen ) ) {
		$query = "SELECT husband, wife, marrdate, marrplace, living, branch FROM $families_table WHERE familyID = \"$nextfamily\" AND gedcom = \"$tree\"";
		$parents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( $parents ) {
			$parentrow = mysql_fetch_assoc( $parents );
			if( $parentrow[husband] ) {
				$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, famc, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch FROM $people_table WHERE personID = \"$parentrow[husband]\" AND gedcom = \"$tree\"";
				$gotfather = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	
			     if( $gotfather ) { 		
					$fathrow =  mysql_fetch_assoc( $gotfather );
					if( $fathrow[firstname] || $fathrow[lastname] ) {
						$personcount = $numbers[$nextfamily] * 2;
						$lastgen[$fathrow[personID]] = $personcount;
						$fathrow[allow_living] = !$fathrow[living] || ( $allow_living && checkbranch( $fathrow[branch] ) ) ? 1 : 0;
						$fathrow[name] = getName( $fathrow );
						if( $fathrow[name] == $text[living] ) $fathrow[firstname] = $text[living];

						echo "<li value=\"$personcount\"><a href=\"$getperson_url" . "personID=$fathrow[personID]&amp;tree=$tree\">$fathrow[name]</a>";
						echo getVitalDates( $fathrow );
						if( $fathrow[allow_living] && $pedigree[regnotes] ) {
							$notes = buildNotes(getNotes( $fathrow[personID], "I" ));
							if( $notes ) {
								echo "<br/><br/>$text[notes]:<br/>";
								echo "<blockquote style=\"margin:0 15px 0px 15px\">\n$notes</blockquote>\n";
							}
						}
						else $notes = "";
						if( !$notes ) echo "<br/>\n";
						echo "</li>\n";
						if( $fathrow[famc] ) {
							if( !in_array( $fathrow[famc], $nextgen ) )
								array_push( $nextgen, $fathrow[famc] );
							if(!$numbers[$fathrow[famc]])
								$numbers[$fathrow[famc]] = $personcount;
						}
					}
					mysql_free_result( $gotfather );
				} 
			}

			if( $parentrow[wife] ) {
				$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, famc, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch FROM $people_table WHERE personID = \"$parentrow[wife]\" AND gedcom = \"$tree\"";
				$gotmother = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

				if( $gotmother ) { 
					$mothrow =  mysql_fetch_assoc( $gotmother );
					if( $mothrow[firstname] || $mothrow[lastname] ) {
						$personcount = $numbers[$nextfamily] * 2 + 1;
						$lastgen[$mothrow[personID]] = $personcount;
						$mothrow[allow_living] = !$mothrow[living] || ( $allow_living && checkbranch( $mothrow[branch] ) ) ? 1 : 0;
						$mothrow[name] = getName( $mothrow );
						if( $mothrow[name] == $text[living] ) $mothrow[firstname] = $text[living];

						if( $parentrow[husband] ) {
							$firstfirstname = getFirstNameOnly( $fathrow );
							echo "<br/>$firstfirstname $text[marrabbr] <a href=\"$getperson_url" . "personID=$parentrow[wife]&amp;tree=$tree\">$mothrow[name]</a>";
							$parentrow[allow_living] = $mothrow[allow_living];
							echo getSpouseDates( $parentrow );					
							$spouseinfo = getVitalDates( $mothrow );
							if( $spouseinfo ) {
								$spfirstfirstname = getFirstNameOnly( $mothrow );
								$spparents = getSpouseParents( $mothrow[personID], $mothrow[sex] );
								echo " $spfirstfirstname $spparents $spouseinfo";
							}
							echo " [<a href=\"$familygroup_url" . "familyID=$nextfamily&amp;tree=$tree\">$text[groupsheet]</a>]<br/><br/>\n</li>\n";
						}

						echo "<li value=\"$personcount\"><a href=\"$getperson_url" . "personID=$mothrow[personID]&amp;tree=$tree\">$mothrow[name]</a>";
						echo getVitalDates( $mothrow );
						if( $mothrow[allow_living] && $pedigree[regnotes] ) {
							$notes = buildNotes(getNotes( $mothrow[personID], "I" ));
							if( $notes ) {
								echo "<br/><br/>$text[notes]:<br/>";
								echo "<blockquote style=\"margin:0 15px 0px 15px\">\n$notes</blockquote>\n";
							}
						}
						else $notes = "";
						if( !$notes ) echo "<br/>\n";
						//echo "</li>\n";
						if( $mothrow[famc] ) {
							if( !in_array( $mothrow[famc], $nextgen ) )
   								array_push( $nextgen, $mothrow[famc] );
							if(!$numbers[$mothrow[famc]])
								$numbers[$mothrow[famc]] = $personcount;
						}
					}
					mysql_free_result( $gotmother );
				}
				if($pedigree[regnotes]) {
					$fam_allow_living = !$parentrow[living] || ( $allow_living && checkbranch( $parentrow[branch] ) ) ? 1 : 0;
					if($fam_allow_living) {
						$notes = buildNotes(getNotes( $nextfamily, "F" ));
						if( $notes ) {
							echo "<br/>$text[notes]:<br/>";
							echo "<blockquote style=\"margin:0 15px 0px 15px\">\n$notes</blockquote>\n";
						}
					}
				}
			}

			//get children
			$query = "SELECT $children_table.personID as personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, sex, living, branch FROM $children_table, $people_table WHERE familyID = \"$nextfamily\" AND $children_table.personID = $people_table.personID AND $children_table.gedcom = \"$tree\" AND $people_table.gedcom = \"$tree\" ORDER BY ordernum";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( $result2 && mysql_num_rows( $result2 ) ) {
				echo "<br/>$text[children]:<br/>\n<ol style=\"margin:0px;padding:10px 0px 10px 65px\">\n";
				while( $childrow = mysql_fetch_assoc( $result2 ) ) {
					$childrow[allow_living] = !$childrow[living] || ( $allow_living && checkbranch( $childrow[branch] ) ) ? 1 : 0;
					$childrow[name] = getName( $childrow );
					//if( $childrow[name] == $text[living] ) $childrow[firstname] = $text[living];
		
					echo "<li type=\"i\">";
					if( $lastlastgen[$childrow[personID]] ) {
						echo $lastlastgen[$childrow[personID]] . ". ";
					}
					echo "<a href=\"$getperson_url" . "personID=$childrow[personID]&amp;tree=$tree\">$childrow[name]</a>";
					echo getVitalDates( $childrow );
					echo "</li>\n";
				}
				echo "</ol>\n";
				mysql_free_result( $result2 );
			}
			echo "</li>\n";
		}
	}
	
	$currgen = $nextgen;
	$lastlastgen = $lastgen;
	unset( $nextgen );
	unset( $lastgen );
	$nextgen = array();
	$lastgen = array();
	$generation++;
	echo "</ol>\n<br/>\n";
}
?>
</div>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>litbox.js"></script>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>rpt_utils.js"></script>
<?php
	tng_footer( "" );
?>
