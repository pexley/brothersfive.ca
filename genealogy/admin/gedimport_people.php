<?php
$orgprefixes = explode( ",", $specpfx );
$prefixcount = 0;
foreach( $orgprefixes as $prefix ) {
	$newprefix = preg_replace( "/'/", "' ", stripslashes( $prefix ) );
	$newprefix = preg_replace( "/  /", " ", $newprefix );
	$newprefixes[$prefixcount] = trim(strtoupper($newprefix));
	$prefixcount++;
}

function getIndividualRecord( $personID, $prevlevel ) {
	global $link, $people_table, $children_table, $events_table, $families_table, $tree, $admtext, $citations_table, $assoc_table, $pciteevents;
	global $savestate, $lineinfo, $custeventlist, $notelinks_table, $stdnotes, $notecount, $lineending, $allevents;
	global $today, $lnprefixes, $lnpfxnum, $specpfx, $currentuser, $newprefixes, $orgprefixes, $tngimpcfg, $pciteevents, $prefix;

	$personID = adjustID( $personID, $savestate[ioffset] );

	$prefix = "I";
	$info = ""; 
	$prifamily = "";
	$changedate = "";
	$info[BIRT] = array();
	$info[DEAT] = array();
	$info[BURI] = array();
	$info[BAPL] = array();
	$info[ENDL] = array();
	$info[NAME] = array();
	$info[SLGC] = array();
	$spouses = array();
	$events = array();
	$stdnotes = array();
	$mminfo = array();
	$cite = array();
	$notecount = 0;
	$mmcount = 0;
	$custeventctr = 0;
	$spousecount = 0;
	$citecount = 0;
	$parentorder = 1;
	$prevlevel++;
	$assocarr = array();
	$living = 0;

	static $arrayLower = array('á','à','ä','é','è','ó','ò','ö','ú','ù','ü');
	static $arrayUpper = array('Á','À','Ä','É','È','Ó','Ò','Ö','Ú','Ù','Ü');

	$lineinfo = getLine( );
	while( $lineinfo[tag] && $lineinfo[level] >= $prevlevel ) {
		if( $lineinfo[level] == $prevlevel ) {
			$tag = $lineinfo[tag];
			switch( $tag ) {
				case "NAME":
					preg_match( "/(.*)\s*\/(.*)\/\s*(.*)/", $lineinfo[rest], $matches );
					if( $info[GIVN] || $info[SURN] ) {
						$newname = "";
						for( $i = 1; $i <= 3; $i++ ) {
							if( $matches[$i] ) {
								if( $newname ) $newname .= " ";
								$newname .= addslashes( $matches[$i] );
							}
						}
						if( !$newname ) $newname = addslashes($lineinfo[rest]);
						$custeventctr++;
						$events[$custeventctr] = array();
						$events[$custeventctr][TAG] = "NAME";
						$thisevent = $prefix . "_NAME_";
						//make sure it's a keeper before continuing by checking against type_tag_desc list
						if( in_array( $thisevent, $custeventlist ) ) {
							$events[$custeventctr][INFO] = getMoreInfo( $personID, $lineinfo[level], $tag, "" );
							$events[$custeventctr][INFO][FACT] = $newname;
						}
						else
							$lineinfo = getLine();
					}
					else {
						$info[SURN] = addslashes($matches[2]);
						if( $savestate[ucaselast] ) {
							$info[SURN] = strtoupper( $info[SURN] );
							for( $i=0; $i < count( $arrayLower ); $i++ ) {
								$info[SURN] = str_replace( $arrayLower[$i], $arrayUpper[$i], $info[SURN] );
							}
						}
						if( $matches[1] ) {
							$info[GIVN] = addslashes($matches[1]);
							if( $matches[3] ) {
								$info[NSFX] = $matches[3];
								if( substr( $info[NSFX], 0, 1 ) == "," ) $info[NSFX] = substr( $info[NSFX], 1 );
								$info[NSFX] = addslashes(trim( $info[NSFX] ));
							}
						}
						elseif( $matches[3] )
							$info[GIVN] = addslashes($matches[3]);
						elseif( !$matches[2] )
							$info[GIVN] = addslashes( $lineinfo[rest] );

						$info[NAME] = getMoreInfo( $personID, $lineinfo[level], $tag, "" );
						if( isset( $info[NAME][NOTES] ) ) dumpnotes( $info[NAME][NOTES] );
						if( $info[NAME][NICK] ) {
							if( $info[NICK] ) $info[NICK] .= ", ";
							$info[NICK] .= removeDelims( $info[NAME][NICK] );
						}
						if( $info[NAME][NPFX] )
							$info[NPFX] = $info[NAME][NPFX];
						if( $info[NAME][NSFX] )
							$info[NSFX] = $info[NAME][NSFX];
						if( $info[NAME][TITL] )
							$info[TITL] = $info[NAME][TITL];
						//this may be just a quickie fix for ALIA
						if( $info[NAME][ALIA] ) {
							$custeventctr++;
							$events[$custeventctr] = array();
							$events[$custeventctr][TAG] = "ALIA";
							$thisevent = $prefix . "_ALIA_";
							//make sure it's a keeper before continuing by checking against type_tag_desc list
							if( in_array( $thisevent, $custeventlist ) ) {
								$events[$custeventctr][INFO] = array();
								$events[$custeventctr][INFO][FACT] = $info[NAME][ALIA];
							}
						}
					}
					break;
				case "NPFX":
				case "NSFX":
				case "TITL":
				case "SEX":
					if( isset( $info[$tag][more] ) ) {
						$custeventctr++;
						$events[$custeventctr] = array();
						$events[$custeventctr][TAG] = $tag;
						$thisevent = $prefix . "_" . $tag . "_";
						$events[$custeventctr][INFO] = addslashes( $lineinfo[rest] );
					}
					else
						$info[$tag] = addslashes( $lineinfo[rest] );
					$lineinfo = getLine();
					break;
				case "NICK":
					if( $info[NICK] ) $info[NICK] .= ", ";
					$info[NICK] .= addslashes( removeDelims( $lineinfo[rest] ) );
					$lineinfo = getLine();
					break;
				case "CHR":
				case "BIRT":
				case "DEAT":
				case "BURI":
				case "BAPL":
				case "ENDL":
					if( isset( $info[$tag][more] ) ) {
						$custeventctr++;
						$events[$custeventctr] = array();
						$events[$custeventctr][TAG] = $tag;
						$thisevent = $prefix . "_" . $tag . "_";
						//make sure it's a keeper before continuing by checking against type_tag_desc list
						//if( in_array( $thisevent, $custeventlist ) )
						//do it anyway
						$events[$custeventctr][INFO] = getMoreInfo( $personID, $lineinfo[level], $tag, "" );
						//else
						//	$lineinfo = getLine();
					}
					else {
						$info[$tag] = getMoreInfo( $personID, $lineinfo[level], $tag, "" );
						if($tag == "BIRT" && $info[BIRT][TYPE] == "stillborn")
							$info[BIRT][NOTES][] = array("NOTE"=>"stillborn");
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
								$events[$custeventctr][INFO][MEDIA] = "";
							}
						}
						$info[$tag][more] = 1;
					}
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
				case "FAMC":
					preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
					$famc = adjustID( $matches[1], $savestate[foffset] );
					if( !$prifamily )
						$prifamily = $famc;
					$lineinfo = getLine();
					$relationship = $lineinfo[tag] == "PEDI" ? $lineinfo[rest] : "";
					$query = "INSERT IGNORE INTO $children_table (gedcom, familyID, personID, relationship, parentorder) VALUES( \"$tree\", \"$famc\", \"$personID\", \"$relationship\", \"$parentorder\" )";
					$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
					$success = mysql_affected_rows( $link );
					if( $success ) $parentorder++;
					if( $relationship ) {
						if( !$success ) {
							$query = "UPDATE $children_table SET relationship = \"$relationship\" WHERE gedcom = \"$tree\" AND familyID = \"$famc\" AND personID = \"$personID\"";
							$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
						}
						$lineinfo = getLine();
					}
					if( $savestate[del] != "no" ) {
						if( !$info[SLGC][DATETR] ) $info[SLGC][DATETR] = "0000-00-00";
						$query = "INSERT IGNORE INTO $children_table (gedcom, familyID, personID, sealdate, sealdatetr, sealplace ) VALUES( \"$tree\", \"" . $famc . "\", \"$personID\", \"" . $info[SLGC][DATE] . "\", \"" . $info[SLGC][DATETR] . "\", \"$slgcplace\" )";
						$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
						$success = mysql_affected_rows( $link );
						if( !$success && ( $info[SLGC][DATE] || $slgplace || $info[SLGC][SOUR] ) ) {
							$query = "UPDATE $children_table SET sealdate=\"" . $info[SLGC][DATE] . "\", sealdatetr=\"" . $info[SLGC][DATETR] . "\", sealplace=\"$slgcplace\" WHERE personID = \"$personID\" AND familyID = \"" . $famc . "\" AND gedcom = \"$tree\"";
							$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
						}
						if( isset( $info[SLGC][SOUR] ) ) {
							$query = "DELETE from $citations_table WHERE persfamID = \"$personID" . "::" . $info[SLGC][FAMC] . "\" AND gedcom = \"$tree\"";
							$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
							processCitations( $personID . "::" . $famc, "SLGC", $info[SLGC][SOUR] );
						}
					}
					break;
				case "ASSO":
					preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
					$thisassoc = array();
					$thisassoc['asso'] = adjustID( $matches[1], $savestate[ioffset] );
					do{
						$lineinfo = getLine();
						if( $lineinfo[tag] == "RELA" ) $thisassoc['rela'] = $lineinfo[rest];
					} while( $lineinfo[level] > $prevlevel );
					array_push($assocarr,$thisassoc);
					break;
				case "SLGC":
					$info[SLGC] = getMoreInfo( $personID, $lineinfo[level], "SLGC", "" );
					if( isset( $info[SLGC][NOTES] ) ) dumpnotes( $info[SLGC][NOTES] );

					if( $savestate[del] != "no" ) {
						$slgcplace = trim( $info[SLGC][TEMP] . " " . $info[SLGC][PLAC] );
						if( $info[SLGC][FAMC] ) {
   							if( !$info[SLGC][DATETR] ) $info[SLGC][DATETR] = "0000-00-00";
							$query = "INSERT IGNORE INTO $children_table (gedcom, familyID, personID, sealdate, sealdatetr, sealplace ) VALUES( \"$tree\", \"" . $info[SLGC][FAMC] . "\", \"$personID\", \"" . $info[SLGC][DATE] . "\", \"" . $info[SLGC][DATETR] . "\", \"$slgcplace\" )";
							$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
							$success = mysql_affected_rows( $link );
						}
						else
							$success = 0;
						if( !$success && ( $info[SLGC][DATE] || $slgplace || $info[SLGC][SOUR] ) ) {
							$query = "UPDATE $children_table SET sealdate=\"" . $info[SLGC][DATE] . "\", sealdatetr=\"" . $info[SLGC][DATETR] . "\", sealplace=\"$slgcplace\" WHERE personID = \"$personID\" AND familyID = \"" . $info[SLGC][FAMC] . "\" AND gedcom = \"$tree\"";
							$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
						}
						if( isset( $info[SLGC][SOUR] ) ) {
							$query = "DELETE from $citations_table WHERE persfamID = \"$personID" . "::" . $info[SLGC][FAMC] . "\" AND gedcom = \"$tree\"";
							$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
							processCitations( $personID . "::" . $info[SLGC][FAMC], "SLGC", $info[SLGC][SOUR] );
						}
					}
					break;
				case "FAMS":
					preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
					$spousecount++;
					$spouses[$spousecount] = adjustID( $matches[1], $savestate[foffset] );
					$lineinfo = getLine();
					break;
				case "IMAGE":
				case "OBJE":
					if( $savestate[media] ) {
						preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
						$mmcount++;
						$mminfo[$mmcount] = getMoreMMInfo( $lineinfo[level], $mmcount );
						$mminfo[$mmcount][OBJE] = $matches[1] ? $matches[1] : $mminfo[$mmcount][FILE];
						$mminfo[$mmcount][linktype] = "I";
					}
					else
						$lineinfo = getLine();
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
					while( $lineinfo[level] >= $prevlevel + 1 && $lineinfo[tag] == "SOUR" ) {
						$ncitecount++;
						$stdnotes[$notecount][SOUR][$ncitecount] = handleSource( $personID, $prevlevel + 1 );
					}
					break;
				case "SOUR":
					$citecount++;
					$cite[$citecount] = handleSource( $personID, $prevlevel, $prevtag, $prevtype );
					break;
				case "_LIVING":
				case "_ALIV":
				case "_FLAG":
					$living = ($lineinfo['rest'] == "Y" || $lineinfo['rest'] == "J" || $lineinfo['rest'] == "LIVING") ? 1 : 0;
					$lineinfo = getLine();
					break;
				case "_PRIVATE":
					$living = 1;
					$lineinfo = getLine();
					break;
				case "_FLGS":
					$lineinfo = getLine();
					if($lineinfo['tag'] == "__LIVING") {
						$living = $lineinfo['rest'] == "Living" ? "1" : 0;
						$lineinfo = getLine();
					}
					break;
				default:
					//custom event -- should be 1 TAG
					$custeventctr++;
					$events[$custeventctr] = handleCustomEvent($personID,$prefix,$tag);
					break;
			}
		}
		else
			$lineinfo = getLine();
	}
	//do TEMP + PLAC
	$meta = metaphone( $info[SURN] );
	$baplplace = trim( $info[BAPL][TEMP] . " " . $info[BAPL][PLAC] );
	$endlplace = trim( $info[ENDL][TEMP] . " " . $info[ENDL][PLAC] );
	$slgcplace = trim( $info[SLGC][TEMP] . " " . $info[SLGC][PLAC] );
	if( $info[TITL] && $info[TITL] == $info[NSFX] )
		$info[TITL] = "";
	
	//determine if living
	if( !$living && !$info[DEAT][more] && !$info[BURI][more] && $info[BIRT][TYPE] != "stillborn") {
		if( $info[BIRT][DATE] || $info[CHR][DATE]) {
			$birthyear = $info[BIRT][DATE] ? $info[BIRT][DATETR] : $info[CHR][DATETR];
			$birthyear = strtok($birthyear,"-");
			if( date( "Y" ) - $birthyear < $tngimpcfg[maxlivingage] ) $living = 1;
		}
		elseif( $tngimpcfg[livingreqbirth] ) $living = 1;
	}
	if( !$savestate[norecalc] )
		$livingstrupd = ", living=\"$living\"";
	else
		$livingstrupd = "";

	//process surname prefix if necessary
	//if( $info[NAME][SPFX] && $lnprefixes) {
		//$info[lnprefix] = $info[NAME][SPFX];
		//$gotit = 1;
	//}
	//else {
		$gotit = 0;
		if( $info[SURN] && $lnprefixes ) {
			$lastname = preg_replace( "/'/", "' ", stripslashes( $info[SURN] ) );
			$lastname = preg_replace( "/  /", " ", $lastname );
			if( $specpfx ) {
				$fullprefix = strtoupper($lastname);
				$lastspace = strrpos( $fullprefix, " " );
				$fullsurname = "";
				while( !$gotit && $lastspace ) {
					$fullsurname = substr( $lastname, $lastspace + 1 );
					$fullprefix = substr( $fullprefix, 0, $lastspace );
					if( in_array( $fullprefix, $newprefixes ) ) {
						$gotit = 1;
						$count = 0;
						foreach( $newprefixes as $newprefix ) {
							if( $fullprefix == $newprefix ) {
								$fullprefix = $orgprefixes[$count];
								break;
							}
							else
								$count++;
						}
					}
					else
						$lastspace = strrpos( $fullprefix, " " );
				}
			}
			if( !$gotit && $lnpfxnum ) {
				$pfxcount = 0;
				$parts = explode( " ", $lastname );
				$numparts = count( $parts );
				if( $numparts >= 2 ) {
					$fullprefix = $fullsurname = "";
					foreach( $parts as $part ) {
						if( !$gotit ) {
							$fullprefix .= $fullprefix ? " $part" : $part;
							$pfxcount++;
							if( $numparts == $pfxcount + 1 || $lnpfxnum == $pfxcount ) {
								$gotit = 1;
							}
						}
						else
							$fullsurname .= $fullsurname ? " $part" : $part;
					}
				}
			}
		}
	//}
	if( $gotit ) {
		$info[lnprefix] = addslashes( $fullprefix );
		$info[SURN] = addslashes( trim( $fullsurname ) );
	}
	else
		$info[lnprefix] = "";
		
	$inschangedt = $changedate ? $changedate : ($tngimpcfg[chdate] ? "" : $today);
	if( !$info[BIRT][DATETR] ) $info[BIRT][DATETR] = "0000-00-00";
	if( !$info[CHR][DATETR] ) $info[CHR][DATETR] = "0000-00-00";
	if( !$info[DEAT][DATETR] ) $info[DEAT][DATETR] = "0000-00-00";
	if( !$info[BURI][DATETR] ) $info[BURI][DATETR] = "0000-00-00";
	if( !$info[BAPL][DATETR] ) $info[BAPL][DATETR] = "0000-00-00";
	if( !$info[ENDL][DATETR] ) $info[ENDL][DATETR] = "0000-00-00";
	$query = "INSERT IGNORE INTO $people_table (personID, lastname, lnprefix, firstname, living, sex, birthdate, birthdatetr, birthplace, altbirthdate, altbirthdatetr, altbirthplace, deathdate, deathdatetr, deathplace, burialdate, burialdatetr, burialplace, nickname, title, prefix, suffix, baptdate, baptdatetr, baptplace, endldate, endldatetr, endlplace, changedate, famc, metaphone, gedcom, branch, changedby)  VALUES(\"$personID\", \"$info[SURN]\", \"$info[lnprefix]\", \"$info[GIVN]\", \"$living\", \"$info[SEX]\", \"" . $info[BIRT][DATE] . "\", \"" . $info[BIRT][DATETR] . "\", \"" . $info[BIRT][PLAC] . "\", \"" . $info[CHR][DATE] . "\", \"" . $info[CHR][DATETR] . "\", \"" . $info[CHR][PLAC] . "\", \"" . $info[DEAT][DATE] . "\", \"" . $info[DEAT][DATETR] . "\", \"" . $info[DEAT][PLAC] . "\", \"" . $info[BURI][DATE] . "\", \"" . $info[BURI][DATETR] . "\", \"" . $info[BURI][PLAC] . "\", \"$info[NICK]\", \"$info[TITL]\", \"$info[NPFX]\", \"$info[NSFX]\", \"" . $info[BAPL][DATE] . "\", \"" . $info[BAPL][DATETR] . "\", \"$baplplace\", \"" . $info[ENDL][DATE] . "\", \"" . $info[ENDL][DATETR] . "\", \"$endlplace\", \"$inschangedt\", \"$prifamily\", \"$meta\", \"$tree\", \"$savestate[branch]\", \"$currentuser\" )";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
	$success = mysql_affected_rows( $link );
	if( !$success && $savestate[del] != "no" ) {
		if( $savestate[neweronly] && $inschangedt ) {
			$query = "SELECT changedate FROM $people_table WHERE personID=\"$personID\" AND gedcom = \"$tree\"";
			$result = @mysql_query( $query );
			$indrow = mysql_fetch_assoc( $result );
			$goahead = $inschangedt  > $indrow[changedate] ? 1 : 0;
			if( $result ) mysql_free_result( $result );
		}
		else
			$goahead = 1;
		if( $goahead ) {
			$chdatestr = $inschangedt ? ", changedate=\"$inschangedt\"" : "";
			$branchstr = $savestate['branch'] ? ", branch=\"$savestate[branch]\"" : "";
			$query = "UPDATE $people_table SET firstname=\"$info[GIVN]\", lnprefix=\"$info[lnprefix]\", lastname=\"$info[SURN]\"" . $livingstrupd . ", nickname=\"$info[NICK]\", prefix=\"$info[NPFX]\", suffix=\"$info[NSFX]\", title=\"$info[TITL]\", birthdate=\"" . $info[BIRT][DATE] . "\", birthdatetr=\"" . $info[BIRT][DATETR] . "\", birthplace=\"" . $info[BIRT][PLAC] . "\", sex=\"$info[SEX]\", altbirthdate=\"" . $info[CHR][DATE] . "\", altbirthdatetr=\"" . $info[CHR][DATETR] . "\", altbirthplace=\"" . $info[CHR][PLAC] . "\", deathdate=\"" . $info[DEAT][DATE] . "\", deathdatetr=\"" . $info[DEAT][DATETR] . "\", deathplace=\"" . $info[DEAT][PLAC] . "\", burialdate=\"" . $info[BURI][DATE] . "\", burialdatetr=\"" . $info[BURI][DATETR] . "\", burialplace=\"" . $info[BURI][PLAC] . "\", baptdate=\"" . $info[BAPL][DATE] . "\", baptdatetr=\"" . $info[BAPL][DATETR] . "\", baptplace=\"$baplplace\", endldate=\"" . $info[ENDL][DATE] . "\", endldatetr=\"" . $info[ENDL][DATETR] . "\", endlplace=\"$endlplace\", changedby=\"$currentuser\" $chdatestr$branchstr";
			if( $prifamily ) $query .= ", famc=\"$prifamily\"";
			$query .= ", metaphone=\"$meta\" WHERE personID=\"$personID\" AND gedcom = \"$tree\"";
			$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
			$success = 1;
	
			if( $savestate[del] == "match" ) {
				//delete all custom events & notelinks for this person because we didn't before
				deleteLinksOnMatch( $personID );
			}
		}
	}
	if( $success ) {
		if( $custeventctr )
			saveCustEvents( $prefix, $personID, $events, $custeventctr );
		if( $notecount ) {
			for( $notectr = 1; $notectr <= $notecount; $notectr++ )
				saveNote( $personID, $stdnotes[$notectr][TAG], $stdnotes[$notectr] );
		}

		//do associations
		if( count($assocarr) ) {
			foreach($assocarr as $assoc) {
				$query = "INSERT INTO $assoc_table (gedcom, personID, passocID, relationship) VALUES( \"$tree\", \"$personID\", \"$assoc[asso]\", \"$assoc[rela]\" )";
				$result = mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
			}
		}

		//do citations
		if( isset( $cite ) )
			processCitations( $personID, "", $cite );
		foreach( $pciteevents as $citeevent ) {
			if( isset( $info[$citeevent][SOUR] ) )
				processCitations( $personID, $citeevent, $info[$citeevent][SOUR] );
		}

		if( $spousecount ) {
			for( $spousectr = 1; $spousectr <= $spousecount; $spousectr++ ) {
				$familyID = $spouses[$spousectr];
				if( !$living || $savestate[norecalc] )
					$famlivingstr = "";
				else
					$famlivingstr = "living = \"1\"";
				if( $info[SEX] == "M" ) {
					$uspousestr = "husband = \"$personID\", husborder = \"$spousectr\"";
					$query = "INSERT IGNORE INTO $families_table (familyID, husborder, living, gedcom, changedby) VALUES(\"$familyID\", \"$spousectr\", \"$living\", \"$tree\", \"$currentuser\" )";
				}
				elseif( $info[SEX] == "F" ) {
					$uspousestr = "wife = \"$personID\", wifeorder = \"$spousectr\"";
					$query = "INSERT IGNORE INTO $families_table (familyID, wifeorder, living, gedcom, changedby) VALUES(\"$familyID\", \"$spousectr\", \"$living\", \"$tree\", \"$currentuser\" )";
				}
				else {
					$uspousestr = "";
					$query = "INSERT IGNORE INTO $families_table (familyID, gedcom, changedby) VALUES(\"$familyID\", \"$tree\", \"$currentuser\" )";
				}
				$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
				$success = mysql_affected_rows( $link );
				if( !$success && ($uspousestr || $famlivingstr ) && $savestate[del] != "no" ) {
					if( $uspousestr && $famlivingstr ) $famlivingstr .= ",";
					$query= "UPDATE $families_table SET $famlivingstr $uspousestr, changedby=\"$currentuser\" WHERE familyID=\"$familyID\" AND gedcom = \"$tree\"";
					$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
				}
			}
		}
		if( $mmcount )
			processMedia( $mmcount, $mminfo, $personID, "" );

		//do event-based media
		foreach( $pciteevents as $stdevtype ) {
			if( is_array($info[$stdevtype]['MEDIA']) ) {
				$eminfo = $info[$stdevtype]['MEDIA'];
				$emcount = count($eminfo);
				processMedia( $emcount, $eminfo, $personID, $stdevtype );
			}
		}

		incrCounter( $prefix );
	}
}
?>
