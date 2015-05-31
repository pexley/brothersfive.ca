<?php
function getFamilyRecord( $familyID, $prevlevel ) {
	global $link, $families_table, $children_table, $events_table, $tree, $admtext, $stdevents, $citations_table, $fciteevents, $prefix, $allevents;
	global $savestate, $lineinfo, $custeventlist, $notelinks_table, $stdnotes, $notecount, $custevents, $lineending, $today, $currentuser, $tngimpcfg;

	$familyID = adjustID( $familyID, $savestate[foffset] );
	
	$prefix = "F";
	$info = ""; 
	$changedate = "";
	$info[MARR] = array();
	$info[SLGS] = array();
	$events = array();
	$stdnotes = array();
	$notecount = 0;
	$childorder = 1;
	$custeventctr = 0;
	$cite = array();
	$mminfo = array();
	$mmcount = 0;
	$prevlevel++;
	$citecount = 0;
	
	$lineinfo = getLine( );
	while( $lineinfo[tag] && $lineinfo[level] >= $prevlevel ) {
		if( $lineinfo[level] == $prevlevel ) {
			$tag = $lineinfo[tag];
			switch( $tag ) {
				case "HUSB":
				case "WIFE":
					preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
					$info[$tag] = adjustID( $matches[1], $savestate[ioffset] );
					$lineinfo = getLine( );
					break;
				case "MARR":
				case "DIV":
				case "SLGS":
					if( isset( $info[$tag][more] ) ) {
						$custeventctr++;
						$events[$custeventctr] = array();
						$events[$custeventctr][TAG] = $tag;
						$thisevent = $prefix . "_" . $tag . "_";
						//make sure it's a keeper before continuing by checking against type_tag_desc list
						if( in_array( $thisevent, $custeventlist ) )
							$events[$custeventctr][INFO] = getMoreInfo( $familyID, $lineinfo[level], $tag, "" );
						else
							$lineinfo = getLine();
					}
					else {
						$info[$tag] = getMoreInfo( $familyID, $lineinfo[level], $tag, "" );
						if( isset( $info[$tag][NOTES] ) ) dumpnotes( $info[$tag][NOTES] );
						if( $info[$tag][FACT] && !isset( $info[$tag][DATE] ) && !isset( $info[$tag][PLAC] ) ) $info[$tag][DATE] = $info[$tag][FACT];
						if( $info[$tag][extra] ) {
							$info[$tag][parent] = $tag;
							$custeventctr++;
							$events[$custeventctr] = array();
							$events[$custeventctr][TAG] = $tag;
							$thisevent = $prefix . "_" . $tag . "_";
							//make sure it's a keeper before continuing by checking against type_tag_desc list
							if( in_array( $thisevent, $custeventlist ) ) {
								$events[$custeventctr][INFO] = $info[$tag];
								$events[$custeventctr][INFO][NOTES] = "";
								$events[$custeventctr][INFO][SOUR] = "";
							}
						}
						$info[$tag][more] = 1;
					}
					break;
					break;
				case "CHAN":
					$lineinfo = getLine();
					$changedate = addslashes( $lineinfo[rest] );
					if( $changedate ) {
						$lineinfo = getLine();
						if( $lineinfo[tag] == "TIME" ) {
							$changedate .= " " . ereg_replace("\.",":",$lineinfo[rest]);
							$lineinfo = getLine();
						}
						$changedate = date( "Y-m-d H:i:s", strtotime( $changedate ) );
					}
					break;
				case "CHIL":
					preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
					$child = adjustID( $matches[1], $savestate[ioffset] );
					//use these lines instead for importing gedcom files from ancestry.com, as they contain no FAMS or FAMC data
					//global $people_table;
					//$query = "UPDATE $people_table SET famc=\"$familyID\" where personID = \"$child\" AND gedcom = \"$tree\"";
					//$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
					//$query = "INSERT IGNORE INTO $children_table (gedcom, familyID, personID, relationship, parentorder, ordernum) VALUES( \"$tree\", \"$familyID\", \"$child\", \"\", \"\", $childorder )";
					//$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
					$query = "UPDATE $children_table SET ordernum=$childorder WHERE personID = \"$child\" AND familyID = \"$familyID\" AND gedcom = \"$tree\"";
					$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
					$childorder++;
					$lineinfo = getLine( );
					break;
				case "NOTE":
					$notecount++;
					$stdnotes[$notecount][TAG] = "";
					preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
					if( $matches[1] ) {
						$stdnotes[$notecount][XNOTE] = adjustID( $matches[1], $savestate[noffset] );
						$stdnotes[$notecount][NOTE] = "";
						$lineinfo = getLine();
					}
					else {
						$stdnotes[$notecount][XNOTE] = "";
						$stdnotes[$notecount][NOTE] .= addslashes($lineinfo[rest]);
						$stdnotes[$notecount][NOTE] .= getContinued();
					}
					$ncitecount = 0;
					while( $lineinfo[level] >= $prevlevel && $lineinfo[tag] == "SOUR" ) {
						$ncitecount++;
						$stdnotes[$notecount][SOUR][$ncitecount] = handleSource( $familyID, $prevlevel + 1 );
					}
					break;
				case "OBJE":
					if( $savestate[media] ) {
						preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
						$mmcount++;
						$mminfo[$mmcount] = getMoreMMInfo( $lineinfo[level], $mmcount );
						$mminfo[$mmcount][OBJE] = $matches[1] ? $matches[1] : $mminfo[$mmcount][FILE];
						$mminfo[$mmcount][linktype] = "F";
					}
					else
						$lineinfo = getLine();
					break;
				case "SOUR":
					$citecount++;
					$cite[$citecount] = handleSource( $familyID, $prevlevel, $prevtag, $prevtype );
					break;
				default:
					//custom event -- should be 1 TAG
					$custeventctr++;
					$events[$custeventctr] = handleCustomEvent($familyID,$prefix,$tag);
					break;
			}
		}
		else
			$lineinfo = getLine();
	}
	//do TEMP + PLAC
	$slgsplace = trim( $info[SLGS][TEMP] . " " . $info[SLGS][PLAC] );

	$inschangedt = $changedate ? $changedate : ($tngimpcfg[chdate] ? "" : $today);
	if( !$info[MARR][DATETR] ) $info[MARR][DATETR] = "0000-00-00";
	if( !$info[DIV][DATETR] ) $info[DIV][DATETR] = "0000-00-00";
	if( !$info[SLGS][DATETR] ) $info[SLGS][DATETR] = "0000-00-00";
	$query = "INSERT IGNORE INTO $families_table (familyID, marrdate, marrdatetr, marrplace, marrtype, divdate, divdatetr, divplace, husband, wife, sealdate, sealdatetr, sealplace, changedate, gedcom, branch, changedby ) VALUES(\"$familyID\", \"" . $info[MARR][DATE] . "\", \"" . $info[MARR][DATETR] . "\", \"" . $info[MARR][PLAC] . "\", \"" . $info[MARR][TYPE] . "\", \"" . $info[DIV][DATE] . "\", \"" . $info[DIV][DATETR] . "\", \"" . $info[DIV][PLAC] . "\", \"" . $info[HUSB] . "\", \"" . $info[WIFE] . "\", \"" . $info[SLGS][DATE] . "\", \"" . $info[SLGS][DATETR] . "\", \"$slgsplace\", \"$inschangedt\", \"$tree\", \"$savestate[branch]\", \"$currentuser\" )";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
	$success = mysql_affected_rows( $link );
	if( !$success && $savestate[del] != "no" ) {
		if( $savestate[neweronly] && $inschangedt ) {
			$query = "SELECT changedate FROM $families_table WHERE familyID=\"$familyID\" AND gedcom = \"$tree\"";
			$result = @mysql_query( $query );
			$famrow = mysql_fetch_assoc( $result );
			$goahead = $inschangedt  > $famrow[changedate] ? 1 : 0;
			if( $result ) mysql_free_result( $result );
		}
		else
			$goahead = 1;
		if( $goahead ) {
			$chdatestr = $changedate ? ", changedate=\"$changedate\"" : "";
			$branchstr = $savestate['branch'] ? ", branch=\"$savestate[branch]\"" : "";
			$query = "UPDATE $families_table SET marrdate=\"" . $info[MARR][DATE] . "\", marrdatetr=\"" . $info[MARR][DATETR] . "\", marrplace=\"" . $info[MARR][PLAC] . "\", marrtype=\"" . $info[MARR][TYPE] . "\", divdate=\"" . $info[DIV][DATE] . "\", divdatetr=\"" . $info[DIV][DATETR] . "\", divplace=\"" . $info[DIV][PLAC] . "\", husband=\"" . $info[HUSB] . "\", wife=\"" . $info[WIFE] . "\", sealdate=\"" . $info[SLGS][DATE] . "\", sealdatetr=\"" . $info[SLGS][DATETR] . "\", sealplace=\"$slgsplace\", changedby=\"$currentuser\" $chdatestr$branchstr WHERE familyID=\"$familyID\" AND gedcom = \"$tree\"";
			$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
			$success = 1;
	
			if( $savestate[del] == "match" ) {
				//delete all custom events for this family because we didn't before
				deleteLinksOnMatch( $familyID );
			}
		}
	}
	if( $success ) {
		if( $custeventctr )
			saveCustEvents( $prefix, $familyID, $events, $custeventctr );

		if( isset( $cite ) )
			processCitations( $familyID, "", $cite );
		foreach( $fciteevents as $citeevent ) {
			if( isset( $info[$citeevent][SOUR] ) )
				processCitations( $familyID, $citeevent, $info[$citeevent][SOUR] );
		}

		if( $notecount ) {
			for( $notectr = 1; $notectr <= $notecount; $notectr++ )
				saveNote( $familyID, $stdnotes[$notectr][TAG], $stdnotes[$notectr] );
		}

		if( $mmcount )
			processMedia( $mmcount, $mminfo, $familyID, "" );

		//do event-based media
		foreach( $fciteevents as $stdevtype ) {
			if( is_array($info[$stdevtype]['MEDIA']) ) {
				$eminfo = $info[$stdevtype]['MEDIA'];
				$emcount = count($eminfo);
				processMedia( $emcount, $eminfo, $familyID, $stdevtype );
			}
		}

		incrCounter( $prefix );
	}
}
?>
