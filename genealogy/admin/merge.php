<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "people";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

require("adminlog.php");

if( !$allow_edit || !$allow_delete ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$deleteblankfamilies = 1;

if( $assignedtree )
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
else
	$wherestr = "";
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

if( $assignedbranch )
	$branchstr = " AND branch LIKE \"%$assignedbranch%\"";
else
	$branchstr = "";

function doRow( $field, $textmsg, $boxname ) {
	global $p1row, $p2row, $admtext, $allow_lds;
	
	if( $field == "living" )  {
		$p1field = $p1row[$field] ? "Yes" : "No";
		$p2field = $p2row[$field] ? "Yes" : "No";
	}
	else {
		$p1field = $p1row[$field];
		$p2field = $p2row[$field];
	}

	if( $p1field || $p2field ) {
		echo "<tr>\n";
		echo "<td valign=\"top\" width=\"15%\" class=\"fieldnameback\" nowrap><span class=\"fieldname\"><strong>$admtext[$textmsg]:</strong></span></td>";
		echo "<td valign=\"top\" width=\"31%\" class=\"lightback\"><span class=\"normal\">$p1field&nbsp;</span></td>";
		if( is_array( $p2row ) ) {
			echo "<td width=\"10\">&nbsp;&nbsp;</td>";
			echo "<td valign=\"top\" width=\"15%\" class=\"fieldnameback\" nowrap><span class=\"fieldname\"><strong>$admtext[$textmsg]:</strong></span></td>";
			echo "<td valign=\"top\" width=\"5\" class=\"lightback\"><span class=\"normal\">";
			//if it's a spouse and they're equal, do a hidden field for p1 & p2 and don't do the checkbox
			if( $textmsg == "spouse" ) {
				if( $p1field && $p2field )
					echo "<input type=\"hidden\" name=\"xx$boxname\" value=\"$field\">";
				elseif( $p2field )
					echo "<input type=\"hidden\" name=\"yy$boxname\" value=\"$field\">";
			}
			if( $boxname ) {
				if( $p2field || $textmsg != "spouse" ) {
					echo "<input type=\"checkbox\" name=\"$boxname\" value=\"$field\"";
					if( $p2row[$field] && !$p1row[$field] ) echo " checked";
					echo ">";
				}
				elseif( $textmsg == "spouse" )
					echo "<input type=\"checkbox\" name=\"zz$boxname\" value=\"$field\">";
			}
			else
				echo "&nbsp;";
			echo "</span></td>";
			if(!$p2field) $p2field = "<span style=\"color:red\">&laquo; " . $admtext['chkdel'] . "</span>";
			echo "<td valign=\"top\" width=\"31%\" class=\"lightback\"><span class=\"normal\">$p2field&nbsp;</span></td>";
		}
		else {
			echo "<td width=\"10\">&nbsp;&nbsp;</td>";
			echo "<td valign=\"top\" width=\"15%\" class=\"fieldnameback\" nowrap><span class=\"fieldname\"><strong>$admtext[$textmsg]:</strong></span></td>";
			echo "<td valign=\"top\" width=\"5\" class=\"lightback\"><span class=\"normal\">&nbsp;</span></td>";
			echo "<td valign=\"top\" width=\"31%\" class=\"lightback\"><span class=\"normal\">&nbsp;</span></td>";
		}
		echo "</tr>\n";
	}
}

function getEvent( $event ) {
	global $mylanguage;
	
	$dispvalues = explode( "|", $event[display] );
	$numvalues = count( $dispvalues );
	if( $numvalues > 1 ) {
		$displayval = "";
		for( $i = 0; $i < $numvalues; $i += 2 ) {
			$lang = $dispvalues[$i];
			if( $mylanguage == $lang ) {
				$displayval = $dispvalues[$i+1];
				break;
			}
		}
	}
	else
		$displayval = $event[display];
		
	$eventstr = "<strong>$displayval</strong>: ";
	$eventstr2 = $event[eventdate];
	if( $eventstr2 && $event[eventplace] )
		$eventstr2 .= ", ";
	$eventstr2 .= $event[eventplace];
	if( $eventstr2 && $event[info] )
		$eventstr2 .= ". ";
	$eventstr2 .= "$event[info]<br/>\n";
	$eventstr .= $eventstr2;
	
	return $eventstr;
}

function getSpouse( $marriage, $spouse ) {
	global $people_table, $admtext, $tree, $allow_lds;
	
	$spousestr = "";
	if( $marriage[$spouse] ) {
		$query = "SELECT personID, lastname, firstname, prefix, suffix, nameorder FROM $people_table WHERE personID = \"$marriage[$spouse]\" AND gedcom = \"$tree\"";
		$gotspouse= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$spouserow =  mysql_fetch_assoc( $gotspouse );
		$spousestr .= getName( $spouserow ) . " - $spouserow[personID] ($marriage[familyID])<br/>\n";
		mysql_free_result( $gotspouse );
	}
	else
		$spousestr = "($marriage[familyID])<br/>\n";
	if( $marriage[marrdate] || $marriage[marrplace] ) {
		$spousestr .= "<strong>$admtext[MARR]</strong>: $marriage[marrdate]";
		if( $marriage[marrdate] && $marriage[marrplace] ) $spousestr .= ", ";
		$spousestr .= "$marriage[marrplace]<br/>\n";
	}
	if( $allow_lds ) {
		if( $marriage[sealdate] || $marriage[sealplace] ) {
			$spousestr .= "<strong>$admtext[SLGS]:</strong> $marriage[sealdate]";
			if( $marriage[sealdate] && $marriage[sealplace] ) $spousestr .= ", ";
			$spousestr .= "$marriage[sealplace]<br/>\n";
		}
	}

	return $spousestr;
}

function getParents( $parent ) {
	global $people_table, $families_table, $admtext, $tree, $allow_lds;
	
	$parentstr = "";
	$query = "SELECT personID, lastname, firstname, prefix, suffix, nameorder FROM $people_table, $families_table WHERE $people_table.personID = $families_table.husband AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
	$gotfather = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

     if( $gotfather ) { 		
		$fathrow =  mysql_fetch_assoc( $gotfather );
		$parentstr .= getName( $fathrow ) . " - $fathrow[personID]<br/>\n";
		mysql_free_result( $gotfather );
	} 
	
	$query = "SELECT personID, lastname, firstname, prefix, suffix, nameorder FROM $people_table, $families_table WHERE $people_table.personID = $families_table.wife AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
	$gotmother = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	if( $gotmother ) { 
		$mothrow =  mysql_fetch_assoc( $gotmother );
		$parentstr .= getName( $mothrow ) . " - $mothrow[personID]<br/>\n";
		mysql_free_result( $gotmother );
	} 
	if( $allow_lds ) {
		if( $parent[sealdate] || $parent[sealplace] ) {
			$parentstr .= "<strong>$admtext[SLGC]:</strong> $parent[sealdate]";
			if( $parent[sealdate] && $parent[sealplace] ) $parentstr .= ", ";
			$parentstr .= "$parent[sealplace]<br/>\n";
		}
	}
	
	return $parentstr;
}

function addCriteria( $row ) {
	global $cfirstname, $clastname, $cbirthdate, $cbirthplace, $cdeathdate, $cdeathplace, $cignoreblanks, $csoundex;
	
	$criteria = "";
	$bsx = $csoundex ? "SOUNDEX(" : "";
	$esx = $csoundex ? ")" : "";
	if( $cfirstname == "yes" ) {
		$criteria .= " AND $bsx" . "firstname" . "$esx = $bsx\"" . addslashes( $row[firstname] ) . "\"$esx";
		$criteria .= $cignoreblanks == "yes" ? " AND firstname != \"\"" : "";
	}
	if( $clastname == "yes" ) {
		$criteria .= " AND $bsx" . "lastname" . "$esx = $bsx\"" . addslashes( $row[lastname] ) . "\"$esx";
		$criteria .= $cignoreblanks == "yes" ? " AND lastname != \"\"" : "";
	}
	if( $cbirthdate == "yes" ) {
		$criteria .= " AND birthdate = \"" . addslashes( $row[birthdate] ) . "\"";
		$criteria .= $cignoreblanks == "yes" ? " AND birthdate != \"\"" : "";
	}
	if( $cbirthplace == "yes" ) {
		$criteria .= " AND birthplace = \"" . addslashes( $row[birthplace] ) . "\"";
		$criteria .= $cignoreblanks == "yes" ? " AND birthplace = \"\"" : "";
	}
	if( $cdeathdate == "yes" ) {
		$criteria .= " AND deathdate = \"" . addslashes( $row[deathdate] ) . "\"";
		$criteria .= $cignoreblanks == "yes" ? " AND deathdate != \"\"" : "";
	}
	if( $cdeathplace == "yes" ) {
		$criteria .= " AND deathplace = \"" . addslashes( $row[deathplace] ) . "\"";
		$criteria .= $cignoreblanks == "yes" ? " AND deathplace = \"\"" : "";
	}
	
	return $criteria;
}

function doNotesCitations( $persfam1, $persfam2, $varname ) {
	global $ccombinenotes, $admtext, $notelinks_table, $citations_table, $tree;
	
	if( $varname ) {
		if( $varname == "general" )
			$varname = "";
		$wherestr = "AND eventID = \"$varname\"";
	}
	else $wherestr = "";
	
	if( $ccombinenotes != "yes" ) {
		$query = "DELETE from $notelinks_table WHERE persfamID = \"$persfam1\" AND gedcom = \"$tree\" $wherestr";
		$noteresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		$query = "DELETE from $citations_table WHERE persfamID = \"$persfam1\" AND gedcom = \"$tree\" $wherestr";
		$citeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
	$query = "UPDATE $notelinks_table set persfamID = \"$persfam1\" WHERE persfamID = \"$persfam2\" AND gedcom = \"$tree\" $wherestr";
	$noteresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "UPDATE $citations_table set persfamID = \"$persfam1\" WHERE persfamID = \"$persfam2\" AND gedcom = \"$tree\" $wherestr";
	$citeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}

$p1row = $p2row = "";
if( $personID1 ) {
	$query = "SELECT *, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") as changedate FROM $people_table WHERE personID = \"$personID1\" and gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	if( $result && mysql_num_rows( $result ) ) {
		$p1row = mysql_fetch_assoc( $result );
		mysql_free_result($result);
	}
	else
		$personID1 = $personID2 = "";
}

@set_time_limit(0);
if( !$mergeaction ) {
	$cfirstname = "yes";
	$clastname = "yes";
}
if( $mergeaction == $admtext[nextmatch] || $mergeaction ==$admtext[nextdup] ) {
	if( $mergeaction == $admtext[nextmatch] ) {
		$wherestr2 = $personID2 ? " AND personID > \"$personID2\"" : "";
		$wherestr2 .= $personID1 ? " AND personID > \"$personID1\"" : "";

		$wherestr = $personID1 ? "AND personID > \"$personID1\"" : "";
		$largechunk = 1000;
		$nextchunk = -1;
		$numrows = 0;
		$still_looking = 1;
		$personID2 = "";
		
		do {
			$nextone = $nextchunk + 1;
			$nextchunk += $largechunk;
	
			$query = "SELECT * FROM $people_table WHERE gedcom = \"$tree\" $branchstr $wherestr ORDER BY personID, lastname, firstname LIMIT $nextone, $largechunk";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			$numrows = mysql_num_rows( $result );
			if( $result && $numrows ) {
				while( $still_looking && $row = mysql_fetch_assoc( $result ) ) {
					//echo "compare $row[firstname] $row[lastname]<br/>\n";
					$wherestr2 = addCriteria( $row );

					$query = "SELECT * FROM $people_table WHERE personID > \"$row[personID]\" AND gedcom = \"$tree\" $branchstr $wherestr2 ORDER BY personID, lastname, firstname LIMIT 1";
					//echo "q2: $query<br/>\n";
					$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
					if( $result2 && mysql_num_rows( $result2 ) ) {
						//set personID1, personID2
						$p1row = $row;
						$personID1 = $p1row[personID];
						$p2row = mysql_fetch_assoc( $result2 );
						//echo "found $p2row[firstname] $p2row[lastname]<br/>\n";
						$personID2 = $p2row[personID];
						mysql_free_result( $result2 );
						$still_looking = 0;
					}
				}
				mysql_free_result( $result );
			}
		} while ( $numrows && $still_looking );
		if( !$personID2 ) $personID1 = $p1row = "";
	}
	else {
		//search with personID1 for next duplicate
		$wherestr2 = $personID2 ? " AND personID > \"$personID2\"" : "";
		$wherestr2 .= addCriteria( $p1row );

		$query = "SELECT * FROM $people_table WHERE personID != \"$p1row[personID]\" AND gedcom = \"$tree\" $branchstr $wherestr2 ORDER BY personID, lastname, firstname LIMIT 1";
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		if( $result2 && mysql_num_rows( $result2 ) ) {
			$p2row = mysql_fetch_assoc( $result2 );
			$personID2 = $p2row[personID];
			mysql_free_result( $result2 );
		}
		else
			$personID2 = "";
	}
}
elseif( $personID2 ) {
	$query = "SELECT *, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") as changedate FROM $people_table WHERE personID = \"$personID2\" AND gedcom = \"$tree\"";
	$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	if( $result2 && mysql_num_rows( $result2 ) && $personID1 != $personID2 ) {
		$p2row = mysql_fetch_assoc( $result2 );
		$personID2 = $p2row[personID];
		mysql_free_result($result2);
	}
	else {
		$mergeaction = $admtext[comprefresh];
		$personID2 = "";
	}
}
if( $mergeaction == $admtext[merge] ) {
	$updatestr = "";
	$prifamily = 0;

	if ( $p1row[sex] == "M" ) { $p1spouse = "wife"; $p1self = "husband"; $p1spouseorder = "husborder";	}
	elseif( $p1row[sex] == "F" ) { 	$p1spouse = "husband"; $p1self = "wife"; $p1spouseorder = "wifeorder";	}
	else {	$p1spouse = ""; $p1self = ""; $p1spouseorder = "";	}

	foreach( $_POST as $key=>$value ) {
		$prefix = substr( $key, 0, 2 );
		switch( $prefix ) {
			case "p2":
				$varname = substr( $key, 2 );
				$p1row[$varname] = $p2row[$varname];
				$updatestr .= ", $varname = \"$p1row[$varname]\" ";
				if(strpos($varname,"date")) {
					$truevar = $varname . "tr";
					$p1row[$truevar] = $p2row[$truevar];
					$updatestr .= ", $truevar = \"$p1row[$truevar]\" ";
				}
				elseif( $varname == "firstname" || $varname == "lastname" )
					$varname = "NAME";
				doNotesCitations( $personID1, $personID2, $varname );
				break;
			case "ev":
				if(strpos($key,"::")) {
					$halves = explode("::",substr($key,5));
					$varname = substr(strstr($halves[1], "_"),1);
					$query = "DELETE from $events_table WHERE persfamID = \"$personID1\" AND gedcom = \"$tree\" and eventID = \"$varname\"";
					$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
					$varname = $halves[0] != "event" ? substr(strstr($halves[0], "_"),1) : "";
				}
				else {
					$varname = substr(strstr($key, "_"),1);
				}
				if($varname) {
					$query = "SELECT eventID FROM $events_table WHERE persfamID = \"$personID2\" AND  gedcom = \"$tree\" and eventID = \"$varname\"";
					$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
					while( $evrow = mysql_fetch_assoc( $evresult ) )
						doNotesCitations( $personID1, $personID2, $evrow[eventID] );
					mysql_free_result( $evresult );

					$query = "UPDATE $events_table set persfamID = \"$personID1\" WHERE persfamID = \"$personID2\" AND gedcom = \"$tree\" AND eventID = \"$varname\"";
					$evresult = @mysql_query($query);
				}
				break;
			case "pa":
				$varname = substr( $key, 7 );
				$query = "DELETE from $children_table WHERE personID = \"$personID1\" AND gedcom = \"$tree\" and familyID = \"$varname\"";
				$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

				//if not selected, delete child record for person 2

				$query = "UPDATE $children_table set personID = \"$personID1\" WHERE personID = \"$personID2\" AND gedcom = \"$tree\" AND familyID = \"$varname\"";
				$evresult = @mysql_query($query);
				if( !$prifamily ) {
					$updatestr .= ", famc = \"$varname\" ";
					$prifamily = 1;
				}
				break;
			case "xx":
				$samespouse = substr( $key, 2 );
				//remove family on right, but move children to left
				if( !$_POST[$samespouse] && $p1self ) {
					$varname = substr( $key, 8 );

					//delete family on right (important to do deleting first)
					$query = "DELETE from $families_table WHERE familyID = \"$varname\" AND gedcom = \"$tree\"";
					$famresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

					$query = "DELETE FROM $medialinks_table WHERE personID = \"$varname\" AND gedcom = \"$tree\"";
					$mediaresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

					//get families where left person is the husband/wife and right SPOUSE is the wife/husband
					$query = "SELECT familyID FROM $families_table WHERE gedcom = \"$tree\" AND $p1self = \"$personID1\" AND $p1spouse = \"" . substr($value, 6) . "\"";
					$sp1result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
					$sp1row =  mysql_fetch_assoc( $sp1result );
					mysql_free_result($sp1result);

					//update all people records where FAMC = the deleted family, set FAMC = family on left
					$query = "UPDATE $people_table set famc = \"$sp1row[familyID]\" WHERE famc = \"$varname\" AND gedcom = \"$tree\"";
					$paresult = @mysql_query($query);

					//move kids from right family to left
					$query = "UPDATE $children_table set familyID = \"$sp1row[familyID]\" WHERE familyID = \"$varname\" AND gedcom = \"$tree\"";
					$chilresult = @mysql_query($query);
					if( !$chilresult ) {
						$query = "DELETE FROM $children_table WHERE familyID = \"$varname\" AND gedcom = \"$tree\"";
						$chilresult = @mysql_query($query);
					}

					if( $ccombinenotes && $varname)
						doNotesCitations( $sp1row[familyID], $varname, "" );

					$query = "UPDATE $events_table set persfamID = \"$sp1row[familyID]\" WHERE persfamID = \"$varname\" AND gedcom = \"$tree\"";
					$evresult = @mysql_query($query);
				}
				break;
			case "yy":
				$samespouse = substr( $key, 2 );
				//basically, we're keeping the right family, but we're removing the right person as a spouse. Corresponding box was not checked, so it's not merging left.
				if( !$_POST[$samespouse] && $p1self ) {
					$varname = substr( $key, 8 );

					$query = "UPDATE $families_table set $p1self = \"\", $p1spouseorder = \"\" WHERE familyID = \"$varname\" AND gedcom = \"$tree\"";
					$chilresult = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				}
				break;
			case "zz":
   				$varname = substr( $key, 8 );

				//remove left person from family.
				$query = "UPDATE $families_table set $p1self = \"\", $p1spouseorder = \"\" WHERE familyID = \"$varname\" AND gedcom = \"$tree\"";
				$chilresult = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				break;
			case "sp":
				$xx = "xx$key";
				if( $p1self ) {
					if( $_POST[$xx] ) {
						$varname = substr( $key, 6 );

						//same spouse, box checked, so we're removing LEFT family, moving kids over to left family
						//get families where left person is the husband/wife and right SPOUSE is the wife/husband
						$query = "SELECT familyID, $p1spouseorder FROM $families_table WHERE gedcom = \"$tree\" AND $p1self = \"$personID1\" AND $p1spouse = \"" . substr($value, 6) . "\"";
						$sp1result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
						$sp1row =  mysql_fetch_assoc( $sp1result );
						mysql_free_result($sp1result);

						$query = "UPDATE $families_table set $p1self = \"$personID1\", $p1spouseorder = \"$sp1row[$p1spouseorder]\" WHERE familyID = \"$varname\" AND gedcom = \"$tree\"";
						$chilresult = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

						//delete family on LEFT
						$query = "DELETE from $families_table WHERE familyID = \"$sp1row[familyID]\" AND gedcom = \"$tree\"";
						$famresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

						$query = "DELETE FROM $medialinks_table WHERE personID = \"$sp1row[familyID]\" AND gedcom = \"$tree\"";
						$mediaresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

						//update all people records where FAMC = the deleted family, set FAMC = family on right
						$query = "UPDATE $people_table set famc = \"$varname\" WHERE famc = \"$sp1row[familyID]\" AND gedcom = \"$tree\"";
						$paresult = @mysql_query($query);

						//move all children from family1 to family2
						$query = "UPDATE $children_table set familyID = \"$varname\" WHERE familyID = \"$sp1row[familyID]\" AND gedcom = \"$tree\"";
						$chilresult = @mysql_query($query);
						if( !$chilresult ) {
							$query = "DELETE FROM $children_table WHERE familyID = \"$sp1row[familyID]\" AND gedcom = \"$tree\"";
							$chilresult = @mysql_query($query);
						}

						if( $ccombinenotes && $sp1row[familyID])
							doNotesCitations( $varname, $sp1row[familyID], "" );

						$query = "UPDATE $events_table set persfamID = \"$sp1row[familyID]\" WHERE persfamID = \"$varname\" AND gedcom = \"$tree\"";
						$evresult = @mysql_query($query);
					}
					else {
						//this means spouses are different, the box has been checked, so they want to keep the right spouse + family
						$varname = substr( $key, 6 );

						//get families where right person is married to right spouse
						$query = "SELECT familyID FROM $families_table WHERE gedcom = \"$tree\" AND $p1self = \"$personID2\" AND $p1spouse = \"$varname\"";
						$sp1result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
						$sp1row =  mysql_fetch_assoc( $sp1result );
						mysql_free_result($sp1result);

						//get spouse order for left person, add one
						$query = "SELECT $p1spouseorder FROM $families_table WHERE gedcom = \"$tree\" AND $p1self = \"$personID1\" ORDER BY $p1spouseorder DESC";
						$spresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
						$sprow =  mysql_fetch_assoc( $spresult );
						mysql_free_result($spresult);
						$sporder = $sprow[$p1spouseorder] + 1;

						//update those families to have left person married to right spouse, change spouse order
						$query = "UPDATE $families_table set $p1self = \"$personID1\", $p1spouseorder = \"$sporder\" WHERE familyID = \"$varname\" AND gedcom = \"$tree\"";
						$chilresult = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
					}
				}
				break;
		}
	}
	if( $ccombinenotes ) {
		doNotesCitations( $personID1, $personID2, "general" );

		//convert all remaining notes and citations
		$query = "UPDATE $notelinks_table set persfamID = \"$personID1\" WHERE persfamID = \"$personID2\" AND gedcom = \"$tree\"";
		$noteresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
		$query = "UPDATE $citations_table set persfamID = \"$personID1\" WHERE persfamID = \"$personID2\" AND gedcom = \"$tree\"";
		$citeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
	if( $updatestr ) {
		$updatestr = substr( $updatestr, 2 );
		$query = "UPDATE $people_table set $updatestr WHERE personID = \"$personID1\" AND gedcom = \"$tree\"";
		$combresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}

	$query = "DELETE from $people_table WHERE personID = \"$personID2\" AND gedcom = \"$tree\"";
	$combresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	//delete remaining notes, citations & events for person 2
	$query = "DELETE from $events_table WHERE persfamID = \"$personID2\" AND gedcom = \"$tree\"";
	$combresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	$query = "DELETE from $notelinks_table WHERE persfamID = \"$personID2\" AND gedcom = \"$tree\"";
	$combresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	$query = "DELETE from $citations_table WHERE persfamID = \"$personID2\" AND gedcom = \"$tree\"";
	$combresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	//update families: remove person2 as spouse from all families
	if( $p1self ) {
		$query = "UPDATE $families_table set $p1self = \"\", $p1spouseorder = \"0\" WHERE $p1self = \"$personID2\" AND gedcom = \"$tree\"";
		$chilresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
	
	//remove person2 from children table
	$query = "DELETE FROM $children_table WHERE personID = \"$personID2\" AND gedcom = \"$tree\"";
	$chilresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	//construct name for default photo 2
	$defaultphoto2 = $tree ? "$rootpath$photopath/$tree.$personID2.$photosext" : "$rootpath$photopath/$personID2.$photosext";
	if( $ccombineextras ) {
		$query = "UPDATE $medialinks_table set personID = \"$personID1\", defphoto = \"\" WHERE personID = \"$personID2\" AND gedcom = \"$tree\"";
		$mediaresult = @mysql_query($query);

		//construct name for default photo 1
		if( file_exists( $defaultphoto2 ) ) {
			$defaultphoto1 = $tree ? "$rootpath$photopath/$tree.$personID1.$photosext" : "$rootpath$photopath/$personID1.$photosext";
			if( !file_exists( $defaultphoto1 ) )
				rename( $defaultphoto2, $defaultphoto1 );
			//else
				//unlink( $defaultphoto2 );
		}
	}
	else {
		$query = "DELETE FROM $medialinks_table WHERE personID = \"$personID2\" AND gedcom = \"$tree\"";
		$mediaresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		//if( file_exists( $defaultphoto2 ) )
			//unlink( $defaultphoto2 );
	}
	$personID2 = "";
	$p2row = "";

	//clean up: remove all families with husband blank and wife blank
	//remove all children from those families
	if( $deleteblankfamilies ) {
		$query = "SELECT familyID FROM $families_table WHERE gedcom = \"$tree\" AND husband = \"\" AND wife = \"\"";
		$blankfams = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		while( $blankrow = mysql_fetch_assoc( $blankfams ) ) {
			$query = "DELETE FROM $children_table WHERE familyID = \"$blankrow[familyID]\" AND gedcom = \"$tree\"";
			$chilresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
		mysql_free_result( $blankfams );
		$query = "DELETE FROM $families_table WHERE gedcom = \"$tree\" AND husband = \"\" AND wife = \"\"";
		$famresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
	adminwritelog( "$admtext[merge]: $tree/$personID2 => $personID1" );
}

$helplang = findhelp("people_help.php");

$revstar = checkReview("I");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[merge], $flags );
?>
<script type="text/javascript" src="selectutils.js"></script>
<script type="text/javascript">
var tree = "<?php echo $tree; ?>";
function validateForm( ) {
	var rval = true;
	
	if( document.form1.personID1.value == '' || document.form1.personID2.value == '' || document.form1.personID1.value == document.form1.personID2.value )
		rval = false;
	else
		rval = confirm( '<?php echo $admtext[confirmmerge]; ?>' );

	return rval;
}

function getTree(treefield) {
	if( treefield.options.length ) 
		return treefield.options[treefield.selectedIndex].value;
	else {
		alert("<?php echo $admtext[selecttree]; ?>");
		return false;
	}
}

function switchpeople() {
	var formname = document.form1;
	
	if( formname.personID1.value && formname.personID2.value ) {
		var temp = formname.personID1.value;
		
		formname.personID1.value = formname.personID2.value;
		formname.personID2.value = temp;
		
		return true;
	}
	else
		return false;

}
</script>
</head>

<body background="../background.gif">

<?php
	$peopletabs[0] = array(1,"people.php",$admtext['search'],"findperson");
	$peopletabs[1] = array($allow_add,"newperson.php",$admtext[addnew],"addperson");
	$peopletabs[2] = array($allow_edit,"findreview.php?type=I",$admtext[review] . $revstar,"review");
	$peopletabs[3] = array($allow_edit && $allow_delete,"merge.php",$admtext[merge],"merge");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/people_help.php#merge', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($peopletabs,"merge",$innermenu);
	echo displayHeadline("$admtext[people] &gt;&gt; $admtext[merge]","people_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<span class="subhead"><strong><?php echo $admtext['findmatches']; ?></strong</span><br/><br/>
	<div class="normal"><em><?php echo $admtext['choosemerge']; ?></em><br/><br/>
	<form action="merge.php" method="post" name="form1" id="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext['tree']; ?>:</span></td>
			<td>
				<select name="tree">
<?php
$trees = "";
while( $treerow = mysql_fetch_assoc($treeresult) ) {
	$trees .= "			<option value=\"$treerow[gedcom]\"";
	if( $treerow[gedcom] == $tree ) $trees .= " selected";
	$trees .= ">$treerow[treename]</option>\n";
}
echo $trees;
?>
				</select>	
			</td>
		</tr>
		<tr><td></td></tr>
	</table><br/>
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext['personid']; ?> 1: <input type="text" name="personID1" id="personID1" size="10" value="<?php echo $personID1; ?>"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;</span></td>
			<td><a href="#" onclick="return openFindPersonForm('personID1','','text',document.form1.tree.options[document.form1.tree.selectedIndex].value);"><img src="tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?> class="smallicon"></a></td>
			<td width="80">&nbsp;</td>
			<td><span class="normal"><?php echo $admtext['personid']; ?> 2: <input type="text" name="personID2" id="personID2" size="10" value="<?php echo $personID2; ?>"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;</span></td>
			<td><a href="#" onclick="return openFindPersonForm('personID2','','text',document.form1.tree.options[document.form1.tree.selectedIndex].value);"><img src="tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?> class="smallicon"></a></td>
		</tr>
	</table><br/>
	<table>
		<tr>
			<td colspan="5"><span class="normal"><strong><?php echo $admtext[matchthese]; ?></strong></span></td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td colspan="3"><span class="normal"><strong><?php echo $admtext[otheroptions]; ?></strong></span></td>
		</tr>
		<tr>			
			<td>
				<span class="normal">
				<input type="checkbox" name="cfirstname" value="yes"<?php if( $cfirstname ) echo " checked"; ?>> <?php echo $admtext[firstname]; ?><br/>
				<input type="checkbox" name="clastname" value="yes"<?php if( $clastname ) echo " checked"; ?>> <?php echo $admtext[lastname]; ?>
				</span>
			</td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td>
				<span class="normal">
				<input type="checkbox" name="cbirthdate" value="yes"<?php if( $cbirthdate == "yes" ) echo " checked"; ?>> <?php echo $admtext[birthdate]; ?><br/>
				<input type="checkbox" name="cbirthplace" value="yes"<?php if( $cbirthplace == "yes" ) echo " checked"; ?>> <?php echo $admtext[birthplace]; ?>
				</span>
			</td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td>
				<span class="normal">
				<input type="checkbox" name="cdeathdate" value="yes"<?php if( $cdeathdate == "yes" ) echo " checked"; ?>> <?php echo $admtext[deathdate]; ?><br/>
				<input type="checkbox" name="cdeathplace" value="yes"<?php if( $cdeathplace == "yes" ) echo " checked"; ?>> <?php echo $admtext[deathplace]; ?>
				</span>
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td>
				<span class="normal">
				<input type="checkbox" name="cignoreblanks" value="yes"<?php if( $cignoreblanks == "yes" ) echo " checked"; ?>> <?php echo $admtext[ignoreblanks]; ?><br/>
				<input type="checkbox" name="csoundex" value="yes"<?php if( $csoundex == "yes" ) echo " checked"; ?>> <?php echo $admtext[usesoundex]; ?>*
				</span>
			</td>
			<td>&nbsp;&nbsp;&nbsp;</td>
			<td>
				<span class="normal">
				<input type="checkbox" name="ccombinenotes" value="yes"<?php if( $ccombinenotes == "yes" ) echo " checked"; ?>> <?php echo $admtext[combinenotes]; ?><br/>
				<input type="checkbox" name="ccombineextras" value="yes"<?php if( $ccombineextras == "yes" ) echo " checked"; ?>> <?php echo $admtext[combineextras]; ?>
				</span>
			</td>
		</tr>
	</table><br/>
	<input type="submit" value="<?php echo $admtext[nextmatch]; ?>" name="mergeaction">
	<input type="submit" value="<?php echo $admtext[nextdup]; ?>" name="mergeaction">
	<input type="submit" value="<?php echo $admtext[comprefresh]; ?>" name="mergeaction">
	<input type="submit" value="<?php echo $admtext[mswitch]; ?>" name="mergeaction" onClick="document.form1.mergeaction.value='<?php echo $admtext[comprefresh]; ?>'; return switchpeople();">
	<input type="submit" value="<?php echo $admtext[merge]; ?>" name="mergeaction" onClick="return validateForm();">
	<br/><br/>
	<table cellpadding="3" cellspacing="1" border="0"  width="100%">
<?php
	if( is_array( $p1row ) ) {
		$parentsets = array();
		$spouses = array();
		$eventlist = array();
		echo "<tr>\n";
		echo "<td colspan=\"3\"><input type=\"button\" value=\"$admtext[edit]\" onClick=\"window.open('editperson.php?personID=$p1row[personID]&amp;tree=$tree&amp;cw=1','edit')\"></td>\n";
		if( is_array( $p2row ) ) {
			echo "<td colspan=\"3\"><input type=\"button\" value=\"$admtext[edit]\" onClick=\"window.open('editperson.php?personID=$p2row[personID]&amp;tree=$tree&amp;cw=1','edit')\"></td>\n";

			$query = "SELECT display, eventdate, eventplace, info, $events_table.eventtypeID as eventtypeID, $events_table.eventID as eventID FROM $events_table, $eventtypes_table WHERE persfamID = \"$p2row[personID]\" AND gedcom = \"$tree\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID ORDER BY ordernum";
			$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			$eventcount = mysql_num_rows( $evresult );
		
			if( $evresult && $eventcount ) {
				while ( $event = mysql_fetch_assoc( $evresult ) ) {
					$ekey = strtoupper("$event[eventtypeID]_$event[eventdate]_$event[eventplace]_" . substr($event[info],0,100));
					$ename = "event$ekey";
					$p2row[$ename] .= getEvent( $event );
					$eventlist[$ekey] = "$event[eventtypeID]_$event[eventID]";
				}
				mysql_free_result($evresult);
			}

			$query = "SELECT personID, familyID, sealdate, sealplace FROM $children_table WHERE personID = \"$p2row[personID]\" AND gedcom = \"$tree\"";
			$parents2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			if( $parents2 && mysql_num_rows( $parents2 ) ) {
				while ( $parent = mysql_fetch_assoc( $parents2 ) ) {
					$pname = "parents$parent[familyID]";
					$p2row[$pname] = getParents( $parent );
					if( !in_array( $parent[familyID], $parentsets ) )
						array_push( $parentsets, $parent[familyID] );
				}
			}

			if( $p2row[sex] ) { 
				if ( $p2row[sex] == "M" ) { 
					$p2spouse = "wife"; $p2self = "husband"; $p2spouseorder = "husborder";
				}
				elseif( $p2row[sex] == "F" ) { 
					$p2spouse = "husband"; $p2self = "wife"; $p2spouseorder = "wifeorder";
				}
				else {
					$p2spouse = ""; $p2self = ""; $p2spouseorder = "";
				}
				
				if( $p2self ) {
					$query = "SELECT $p2spouse, familyID, marrdate, marrplace, sealdate, sealplace FROM $families_table WHERE $families_table.$p2self = \"$p2row[personID]\" AND gedcom = \"$tree\" ORDER BY $p2spouseorder";
					$marriages2= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
					while ( $marriage = mysql_fetch_assoc( $marriages2 ) ) {
						$mname = "spouse$marriage[$p2spouse]";
						$p2row[$mname] = getSpouse( $marriage, $p2spouse );
						if( !in_array( $marriage[$p2spouse], $spouses ) ) {
							array_push( $spouses, $marriage[$p2spouse] );
		   					$marriages[$marriage[$p2spouse]] = $marriage[familyID];
						}
					}
				}
			}
		}
		echo "</tr>\n";
		doRow( "personID", "personid", "" );
		doRow( "firstname", "firstgivennames", "p2firstname" );
		doRow( "lastname", "lastsurname", "p2lastname" );
		doRow( "nickname", "nickname", "p2nickname" );
		doRow( "prefix", "prefix", "p2prefix" );
		doRow( "suffix", "suffix", "p2suffix" );
		doRow( "title", "title", "p2title" );
		doRow( "living", "living", "p2living" );
		doRow( "birthdate", "birthdate", "p2birthdate" );
		doRow( "birthplace", "birthplace", "p2birthplace" );
		doRow( "sex", "sex", "p2sex" );
		doRow( "altbirthdate", "chrdate", "p2altbirthdate" );
		doRow( "altbirthplace", "chrplace", "p2altbirthplace" );
		doRow( "deathdate", "deathdate", "p2deathdate" );
		doRow( "deathplace", "deathplace", "p2deathplace" );
		doRow( "burialdate", "burialdate", "p2burialdate" );
		doRow( "burialplace", "burialplace", "p2burialplace" );
		if( $allow_lds ) {
			doRow( "baptdate", "bapldate", "p2baptdate" );
			doRow( "baptplace", "baplplace", "p2baptplace" );
			doRow( "endldate", "endldate", "p2endldate" );
			doRow( "endlplace", "endlplace", "p2endlplace" );
		}
		$query = "SELECT display, eventdate, eventplace, info, $events_table.eventtypeID as eventtypeID, $events_table.eventID as eventID FROM $events_table, $eventtypes_table WHERE persfamID = \"$p1row[personID]\" AND gedcom = \"$tree\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID ORDER BY ordernum";
		$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$eventcount = mysql_num_rows( $evresult );
		
		if( $evresult && $eventcount ) {
			while ( $event = mysql_fetch_assoc( $evresult ) ) {
				$ekey = strtoupper("$event[eventtypeID]_$event[eventdate]_$event[eventplace]_" . substr($event[info],0,100));
				$ename = "event$ekey";
				$p1row[$ename] .= getEvent( $event );
				if($eventlist[$ekey])
					$eventlist[$ekey] .= "::" . "$event[eventtypeID]_$event[eventID]";
				else
					$eventlist[$ekey] = "::" . "$event[eventtypeID]_$event[eventID]";
			}
			mysql_free_result($evresult);
		}
		
		foreach( $eventlist as $key => $event ) {
		//need to pass the eventtype + eventID as the key, perhaps as double key separated by ::
		//key may only need to be "event" + sequence number
			$ename = "event$key";
			$inputname = "event$event";
			//echo "key:$key<br>event=$event<br>";
			doRow( $ename, "otherevents", $inputname );
		}

		$query = "SELECT personID, familyID, sealdate, sealplace FROM $children_table WHERE personID = \"$p1row[personID]\" AND gedcom = \"$tree\"";
		$parents1 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		if( $parents1 && mysql_num_rows( $parents1 ) ) {
			while ( $parent = mysql_fetch_assoc( $parents1 ) ) {
				$pname = "parents$parent[familyID]";
				$p1row[$pname] = getParents( $parent );
				if( !in_array( $parent[familyID], $parentsets ) )
					array_push( $parentsets, $parent[familyID] );
			}
		}

		foreach( $parentsets as $parentset ) {
			$pname = "parents$parentset";
			$inputname = "parents$parentset";
			doRow( $pname, "parents", $inputname );
		}

		if( $p1row[sex] ) { 
			if ( $p1row[sex] == "M" ) { 
				$p1spouse = "wife"; $p1self = "husband"; $p1spouseorder = "husborder";
			}
			elseif( $p1row[sex] == "F" ) { 
				$p1spouse = "husband"; $p1self = "wife"; $p1spouseorder = "wifeorder";
			}
			else {
				$p1spouse = ""; $p1self = ""; $p1spouseorder = "";
			}
			
			if( $p1self ) {
				$query = "SELECT $p1spouse, familyID, marrdate, marrplace, sealdate, sealplace FROM $families_table WHERE $families_table.$p1self = \"$p1row[personID]\" AND gedcom = \"$tree\" ORDER BY $p1spouseorder";
				$marriages1= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		
				while ( $marriage = mysql_fetch_assoc( $marriages1 ) ) {
					$mname = "spouse$marriage[$p1spouse]";
					$p1row[$mname] = getSpouse( $marriage, $p1spouse );
					if( !in_array( $marriage[$p1spouse], $spouses ) ) {
						array_push( $spouses, $marriage[$p1spouse] );
						$marriages[$marriage[$p1spouse]] = $marriage[familyID];
					}
				}
			}
		}

		foreach( $spouses as $nextspouse ) {
			$mname = "spouse$nextspouse";
			$inputname = "spouse$marriages[$nextspouse]";
			doRow( $mname, "spouse", $inputname );
		}
	}
	else echo "<tr><td><span class=\"normal\">$admtext[nomatches]</span></td></tr>";
?>
	</table><br/>
<?php
if( $personID1 || $personID2 ) {
?>	
	<input type="submit" value="<?php echo $admtext[nextmatch]; ?>" name="mergeaction">
	<input type="submit" value="<?php echo $admtext[nextdup]; ?>" name="mergeaction">
	<input type="submit" value="<?php echo $admtext[comprefresh]; ?>" name="mergeaction">
	<input type="submit" value="<?php echo $admtext[mswitch]; ?>" name="mergeaction" onClick="document.form1.mergeaction.value='<?php echo $admtext[comprefresh]; ?>'; return switchpeople();">
	<input type="submit" value="<?php echo $admtext[merge]; ?>" name="mergeaction" onClick="return validateForm();">
<?php
}
?>	
	</form><br/>
	<span style="font-size: 8pt;">*<?php echo $admtext[sdxdisclaimer]; ?></span>
	</div>
	</td>
</tr>

</table>
</div>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
