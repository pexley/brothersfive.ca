<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "gedcom";
include($cms['tngpath'] . "getlang.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "version.php");

$gedcom_url = getURL( "gedcom", 1 );

@set_time_limit(0);
$allsources = array();
$allrepos = array();
$xnotes = array();
$citations = array();

$query = "SELECT disallowgedcreate, email FROM $trees_table WHERE gedcom = \"$tree\"";
$treeresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc($treeresult);
if( $treerow[disallowgedcreate] && !$allow_ged ) exit;
mysql_free_result( $treeresult );

function getAncestor ( $person, $generation ) {
	global $tree, $maxgcgen, $indarray, $people_table, $text;

	$query = "SELECT personID, famc FROM $people_table WHERE personID = \"$person\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $result ) {
		$ind = mysql_fetch_assoc( $result );
		//do individual, but only do spouse if this is the first generation (all others covered as children of succeeding generations)
		if( $generation == 1 ) {
			$indarray[$ind[personID]] = writeIndividual( $ind[personID] );
			getDescendant( $ind[personID], 0 );
		}
		else {
			$indarray[$ind[personID]] = writeIndividual( $ind[personID] );
		}
		if( $ind[famc] && ( $generation < $maxgcgen ) ) {
			getFamily( $person, $ind[famc], $generation + 1 );
		}
		mysql_free_result( $result );
	}
}

function getCitations( $persfamID ) {
	global $citations_table, $text, $tree;

	$citations = array();
	$citquery = "SELECT citationID, page, quay, citedate, citetext, note, sourceID, description, eventID FROM $citations_table WHERE persfamID = \"$persfamID\" AND gedcom = \"$tree\" ORDER BY eventID";
	$citresult = mysql_query($citquery) or die ("$text[cannotexecutequery]: $query");

	$lasteventID = "";
	while( $cite = mysql_fetch_assoc( $citresult ) ) {
		if( $cite[eventID] != $lasteventID ) {
			$citectr = 1;
			$lasteventID = $cite[eventID];
		}
		else
			$citectr++;
		$eventID = $lasteventID ? $lasteventID : "NAME";
		$citations[$eventID][$citectr] = array( "page" => $cite[page], "quay" => $cite[quay], "citedate" => $cite[citedate], "citetext" => $cite[citetext], "note" => $cite[note], "sourceID" => $cite[sourceID], "description" => $cite[description] );
	}	
	return $citations;
}

function writeCitation( $citelist, $level ) {
	global $allsources, $lineending;
	
	$levelplus1 = $level + 1;
	$citestr = "";
	
	$citecount = count( $citelist );
	if( $citecount ) {
		foreach( $citelist as $cite ) {
			if( $cite[sourceID] ) {
				array_push( $allsources, $cite[sourceID] );
				$citestr .= "$level SOUR @$cite[sourceID]@$lineending";
				if( $cite[citedate] || $cite[citetext] ) {
					$levelplus2 = $level + 2;
					$citestr .= "$levelplus1 DATA$lineending";
					if( $cite[citedate] )
						$citestr .= "$levelplus2 DATE $cite[citedate]$lineending";
					if( $cite[citetext] )
						$citestr .= doNote( $levelplus2, "TEXT", $cite[citetext] );
				}
			}
			else {
				$citestr = "$level SOUR $cite[description]$lineending";
				if( $cite[citetext] )
					$citestr .= doNote( $levelplus1, "TEXT", $cite[citetext] );
			}
			if( $cite['page'] ) $citestr .= "$levelplus1 PAGE $cite[page]$lineending";
			if( $cite['quay'] && $cite['quay'] != "0" ) $citestr .= "$levelplus1 QUAY $cite[quay]$lineending";
			if( $cite['note'] ) $citestr .= doNote( $levelplus1, "NOTE", $cite[note] );
		}
	}
	
	return $citestr;
}

function getFact( $row, $level ) {
	global $tree, $address_table, $text, $lineending;
	
	$fact = "";
	if( $row[age] ) $fact .= "$level AGE $row[age]$lineending";
	if( $row[agency] ) $fact .= "$level AGNC $row[agency]$lineending";
	if( $row[cause] ) $fact .= "$level CAUS $row[cause]$lineending";
	if( $row[addressID] ) {
		$query = "SELECT address1, address2, city, state, zip, country, phone, www, email FROM $address_table WHERE addressID = \"$row[addressID]\" AND gedcom = \"$tree\"";
		$addrresults = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$addr = mysql_fetch_assoc( $addrresults );
		if( $row[tag] != "ADDR" ) {
   			$fact .= "$level ADDR$lineending";
			$level++;
		}
		if( $addr['address1'] ) $fact .= "$level ADR1 $addr[address1]$lineending";
		if( $addr['address2'] ) $fact .= "$level ADR2 $addr[address2]$lineending";
		if( $addr['city'] ) $fact .= "$level CITY $addr[city]$lineending";
		if( $addr['state'] ) $fact .= "$level STAE $addr[state]$lineending";
		if( $addr['zip'] ) $fact .= "$level POST $addr[zip]$lineending";
		if( $addr['country'] ) $fact .= "$level CTRY $addr[country]$lineending";
		if( $addr['phone'] ) $fact .= "$level CTRY $addr[country]$lineending";
		if( $addr['email'] ) $fact .= "$level CTRY $addr[country]$lineending";
		if( $addr['www'] ) $fact .= "$level CTRY $addr[country]$lineending";
	}
	return $fact;
}

function getStdExtras( $persfamID, $level ) {
	global $tree, $events_table, $text;
	
	$stdex = array();
	$query = "SELECT age, agency, cause, addressID, parenttag FROM $events_table WHERE persfamID = \"$persfamID\" AND gedcom = \"$tree\" AND parenttag != \"\" ORDER BY parenttag";
	$stdextras = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	while ( $stdextra = mysql_fetch_assoc( $stdextras ) ) {
		$stdex[$stdextra[parenttag]] = getFact( $stdextra, $level );
	}
	return $stdex;
}

function doEvent( $custevent, $level ) {
	global $lineending;
	
	$info = "$level $custevent[tag]";
	$nextlevel = $level + 1;
	if( $custevent[info] ) {
		//$custevent[info] = trim($custevent[info]);
		$data = split ( $lineending, $custevent[info] );
		if( count( $data ) > 1 ) {
			$nextdata = trim(array_shift( $data ));
			if( $nextdata )
				$info .= " $nextdata$lineending";
			foreach ( $data as $line )
				$info .= "$nextlevel CONT $line$lineending";
		}
		else
			$info .= " $custevent[info]$lineending";
	}
	else
		$info .= $lineending;
	if( $custevent[description] ) $info .= "2 TYPE $custevent[description]$lineending";
	if( $custevent[eventdate] )  $info .= "2 DATE $custevent[eventdate]$lineending";
	if( $custevent[eventplace] )  $info .= "2 PLAC $custevent[eventplace]$lineending";

	return $info;
}

function getNotes( $id ) {
	global $notelinks_table, $xnotes_table, $tree, $eventtypes_table, $text, $xnotes;
	
	$query = "SELECT $notelinks_table.ID as ID, $xnotes_table.note as note, $xnotes_table.noteID as noteID, $notelinks_table.eventID FROM $notelinks_table, $xnotes_table WHERE $notelinks_table.xnoteID = $xnotes_table.ID AND $notelinks_table.gedcom = $xnotes_table.gedcom AND $notelinks_table.persfamID=\"$id\" AND $notelinks_table.gedcom =\"$tree\" ORDER BY eventID";
	$notelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$notearray = array();
	while( $notelink = mysql_fetch_assoc( $notelinks ) ) {
		$eventid = $notelink[eventID] ? $notelink[eventID] : "-x--general--x-";
		$newnote = $notelink[noteID] ? "@$notelink[noteID]@" : $notelink[note];
		if( !is_array( $notearray[$eventid] ) ) $notearray[$eventid] = array();
		//array_push( $notearray[$eventid], $newnote );
		$innerarray = array();
		$innerarray[text] = $newnote;
		$innerarray[id] = "N" . $notelink[ID];
		array_unshift( $notearray[$eventid], $innerarray );

		if( $notelink[noteID] && !in_array( $notelink[noteID], $xnotes ) )
			array_push( $xnotes, $notelink[noteID] );
	}
	mysql_free_result( $notelinks );
	
	return $notearray;
}

function doNote( $level, $label, $notetxt ) {
	global $lineending;

	$noteinfo = "";
	$noteconc = "";
	$notes = split ( $lineending, $notetxt );
	//$note = trim( array_shift( $notes ) );
	if($level) {
		$note = array_shift( $notes );
		$notelen = strlen( $note );
		if( $notelen > 245 ) {
			$orgnote = $note;
			$offset = 245;
			while( substr( $orgnote, $offset, 1 ) == " " || substr( $orgnote, $offset - 1, 1 ) == " " )
				$offset--;
			$note = substr( $note, 0, $offset );
			$newlevel = $level + 1;
			while( $offset < $notelen ) {
				$endnext = 245;
				while( substr( $orgnote, $offset + $endnext, 1 ) == " " || substr( $orgnote, $offset + $endnext - 1, 1 ) == " " )
					$endnext--;
				$nextpart = trim(substr( $orgnote, $offset, $endnext ),$lineending);
				$noteconc .= "$newlevel CONC $nextpart$lineending";
				$offset += $endnext;
			}
		}
		$noteinfo .= "$level $label $note$lineending";
		$noteinfo .= $noteconc;
	}
	$level++;
	foreach ( $notes as $note ) {
		//$note = trim($note);
		$noteconc = "";
		$notelen = strlen( $note );
		if( $notelen > 245 ) {
			$orgnote = $note;
			$offset = 245;
			while( substr( $orgnote, $offset, 1 ) == " " || substr( $orgnote, $offset - 1, 1 ) == " " )
				$offset--;
			$note = substr( $note, 0, $offset );
			while( $offset < $notelen ) {
				$endnext = 245;
				while( substr( $orgnote, $offset + $endnext, 1 ) == " " || substr( $orgnote, $offset + $endnext - 1, 1 ) == " " )
					$endnext--;
   				$nextpart = trim(substr( $orgnote, $offset, $endnext ),$lineending);
				$noteconc .= "$level CONC $nextpart$lineending";
				$offset += $endnext;
			}
		}
		$noteinfo .= "$level CONT $note$lineending";
		$noteinfo .= $noteconc;
	}
	return $noteinfo;
}

function writeNote( $level, $label, $notes ) {
	global $citations;

	$noteinfo = "";
	if( is_array( $notes ) ) {
		foreach( $notes as $notearray ) {
			$noteinfo .= doNote( $level, $label, $notearray[text] );
		 	$id = $notearray[id];
		 	$noteinfo .= writeCitation( $citations[$id], $level + 1 );
		}
	}
	return $noteinfo;
}

function doXNotes( ) {
	global $xnotes_table, $tree, $text, $xnotes, $lineending;
	
	if( $xnotes ) {
		$xnoteinfo = "";
		foreach ( $xnotes as $xnote ) {
			$query = "SELECT note FROM $xnotes_table WHERE gedcom =\"$tree\" AND noteID = \"$xnote\" ORDER BY noteID";
			$xnotearray = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$xnotetxt = mysql_fetch_assoc( $xnotearray );
			echo "0 @$xnote@ NOTE$lineending";
			echo doNote(0,"NOTE",$xnotetxt[note]); 
			
			//$notes = split ( chr(10), $xnotetxt[note] );
			//foreach ( $notes as $note ) {
				//echo "1 CONT $note$lineending";
			//}
			mysql_free_result( $xnotearray );
		}
	}
}

function getFamily ( $person, $parents, $generation ) {
	global $tree, $famarray, $indarray, $families_table, $children_table, $people_table, $text, $lineending;
	
	$query = "SELECT * FROM $families_table WHERE familyID = \"$parents\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $result ) {
		$family = mysql_fetch_assoc( $result );
		mysql_free_result( $result );

		$famarray[$parents] = writeFamily( $family );

		if( $family[husband] ) {
			getAncestor( $family[husband], $generation );
			$query = "SELECT * FROM $families_table WHERE husband = \"$family[husband]\" AND gedcom = \"$tree\"";
			$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( $result ) {
				while( $spouse = mysql_fetch_assoc( $result ) ) {
					if( $spouse[wife] != $family[wife] ) {
						$indarray[$spouse[wife]] = writeIndividual( $spouse[wife] );
						$indarray[$spouse[wife]] .= "1 FAMS @$spouse[familyID]@$lineending";
						$famarray[$spouse[familyID]] = writeFamily( $spouse );
					}
					$indarray[$family[husband]] .= "1 FAMS @$spouse[familyID]@$lineending";
				}
				mysql_free_result( $result );
			}
		}
		
		if( $family[wife] ) {
			getAncestor( $family[wife], $generation );
			$query = "SELECT * FROM $families_table WHERE wife = \"$family[wife]\" AND gedcom = \"$tree\"";
			$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( $result ) {
				while( $spouse = mysql_fetch_assoc( $result ) ) {
					if( $spouse[husband] != $family[husband] ) {
						$indarray[$spouse[husband]] = writeIndividual( $spouse[husband] );
						$indarray[$spouse[husband]] .= "1 FAMS @$spouse[familyID]@$lineending";
						$famarray[$spouse[familyID]] = writeFamily( $spouse );
					}
					$indarray[$family[wife]] .= "1 FAMS @$spouse[familyID]@$lineending";
				}
				mysql_free_result( $result );
			}
		}
		if( $generation > 1 ) {
			$query = "SELECT familyID, $children_table.personID as personID, sealdate, sealplace, relationship, living, branch FROM $children_table, $people_table WHERE familyID = \"$parents\" AND $children_table.gedcom = \"$tree\" AND $children_table.personID = $people_table.personID AND $children_table.gedcom = $people_table.gedcom ORDER BY ordernum";
			$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( $result ) {
				while( $child = mysql_fetch_assoc( $result ) ) {
					if( $child[personID] != $person ) {
						$indarray[$child[personID]] = writeIndividual( $child[personID] );
						getDescendant( $child[personID], 0 );
					}
					$indarray[$child[personID]] .= appendParents( $child );
					$famarray[$parents] .= "1 CHIL @$child[personID]@$lineending";
				}
				mysql_free_result( $result );
			}
		}
	}
}

function appendParents( $child ) {
	global $lds, $allow_lds, $allow_living, $livedefault, $lineending;
	
	$info = "1 FAMC @$child[familyID]@$lineending";
	if( !$child[living] || $livedefault == 2 || ( $allow_living && checkbranch( $child[branch] ) ) ) {
		if( $child[relationship] ) $info .= "2 PEDI $child[relationship]$lineending"; 
		if( $allow_lds && $lds == "yes" ) { 
			if( $child[sealdate] || $child[sealplace] ) {
				$childnotes = getNotes( $child[personID] );
				$citations = getCitations( $child[personID] . $child[familyID] );
	
				$info .= "1 SLGC$lineending";
				$info .= "2 FAMC @$child[familyID]@$lineending";
				if( $child[sealdate] ) { $info .= "2 DATE $child[sealdate]$lineending"; }
				if( $child[sealplace] ) { 
					$tok = strtok ($child[sealplace]," ");
					if( strlen( $tok ) == 5 ) {
						$info .= "2 TEMP $tok$lineending"; 
						$tok = strtok( " " );
						if( $tok )
							$info .= "2 PLAC $tok$lineending"; 
					}
					else
						$info .= "2 PLAC $child[sealplace]$lineending"; 
				}
				if( $childnotes[SLGC] )
					$info .= writeNote( 2, "NOTE", $childnotes[SLGC] );
				if( $citations[SLGC] ) { 
					$info .= writeCitation( $citations[SLGC], 2 );
				}
			}
		}
	}
	
	return $info;
}

function writeIndividual( $person ) {
	global $tree, $lds, $people_table, $events_table, $eventtypes_table, $text, $allow_living, $allow_lds, $nonames, $citations, $lnprefixes, $livedefault, $assoc_table, $lineending;
	
	$query = "SELECT lastname, lnprefix, firstname, sex, title, prefix, suffix, nameorder, nickname, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace, baptdate, baptplace, endldate, endlplace, famc, living, branch FROM $people_table WHERE personID = \"$person\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $result ) {
		$ind = mysql_fetch_assoc( $result );
		$ind[allow_living] = !$ind[living] || $livedefault == 2 || ( $allow_living && checkbranch( $ind[branch] ) ) ? 1 : 0;
		if( $ind[allow_living] )
			$indnotes = getNotes( $person );
		else
			$indnotes = array();
		
		$citations = getCitations( $person );
		$extras = getStdExtras( $person, 2 );
		
		$info = "0 @$person@ INDI$lineending";
		if( $ind[allow_living] || !$nonames ) {
   			$info .= "1 NAME $ind[firstname] /" . trim( "$ind[lnprefix] $ind[lastname]" ) . "/";
			$info .= $ind[suffix] ? " $ind[suffix]$lineending" : $lineending;
   			if( $ind[firstname] ) $info .= "2 GIVN $ind[firstname]$lineending";
			if( $lnprefixes && $ind[lnprefix] ) $info .= "2 SPFX $ind[lnprefix]$lineending";
			if( $ind[lastname] ) $info .= "2 SURN $ind[lastname]$lineending";

			if( $indnotes[NAME] )
				$info .= writeNote( 2, "NOTE", $indnotes[NAME] );
			if( $ind[prefix] ) {
				$info .= "2 NPFX $ind[prefix]$lineending";
				if( $indnotes[NPFX] )
					$info .= writeNote( 3, "NOTE", $indnotes[NPFX] );
			}
			if( $ind[suffix] ) {
				$info .= "2 NSFX $ind[suffix]$lineending";
				if( $indnotes[NSFX] )
					$info .= writeNote( 3, "NOTE", $indnotes[NSFX] );
			}
			if( $ind[nickname] ) {
				$info .= "2 NICK $ind[nickname]$lineending";
				if( $indnotes[NICK] )
					$info .= writeNote( 3, "NOTE", $indnotes[NICK] );
			}
			if( $ind[title] ) {
				$info .= "1 TITL $ind[title]$lineending";
				if( $indnotes[TITL] )
					$info .= writeNote( 2, "NOTE", $indnotes[TITL] );
			}
			$info .= "1 SEX $ind[sex]$lineending";
			if( $citations[NAME] )
				$info .= writeCitation( $citations[NAME], 1 );
		}
		elseif( $nonames == 2 )
			$info .= "1 NAME " . initials( $ind[firstname] ) . " /" . trim("$ind[lnprefix] $ind[lastname]") . "/$lineending";
		else
			$info .= "1 NAME $text[living] //$lineending";

		if( $ind[allow_living] ) {
			if( $ind[birthdate] || $ind[birthplace] || $indnotes[BIRT] || $citations[BIRT] || $extras[BIRT] ) {
				if( $ind[birthdate] == "Y" || (!$ind[birthdate] && !$ind[birthplace]))
					$info .= "1 BIRT Y$lineending";
				else {
					$info .= "1 BIRT$lineending";
					if( $ind[birthdate] ) { $info .= "2 DATE $ind[birthdate]$lineending"; }
					if( $ind[birthplace] ) { $info .= "2 PLAC $ind[birthplace]$lineending"; }
				}
				if( $indnotes[BIRT] )
					$info .= writeNote( 2, "NOTE", $indnotes[BIRT] );
				if( $citations[BIRT] )
					$info .= writeCitation( $citations[BIRT], 2 );
				$info .= $extras[BIRT];
			}
			if( $ind[altbirthdate] || $ind[altbirthplace] || $indnotes[CHR] || $citations[CHR] || $extras[CHR] ) {
				if( $ind[altbirthdate] == "Y" || (!$ind[altbirthdate] && !$ind[altbirthplace]))
					$info .= "1 CHR Y$lineending";
				else {
					$info .= "1 CHR$lineending";
					if( $ind[altbirthdate] ) { $info .= "2 DATE $ind[altbirthdate]$lineending"; }
					if( $ind[altbirthplace] ) { $info .= "2 PLAC $ind[altbirthplace]$lineending"; }
				}
				if( $indnotes[CHR] )
					$info .= writeNote( 2, "NOTE", $indnotes[CHR] );
				if( $citations[CHR] )
					$info .= writeCitation( $citations[CHR], 2 );
				$info .= $extras[CHR];
			}
		}
		if( $ind[deathdate] || $ind[deathplace] || $indnotes[DEAT] || $citations[DEAT] || $extras[DEAT] ) {
			if( $ind[deathdate] == "Y" || (!$ind[deathdate] && !$ind[deathplace]))
				$info .= "1 DEAT Y$lineending";
			else {
				$info .= "1 DEAT$lineending";
				if( $ind[deathdate] ) { $info .= "2 DATE $ind[deathdate]$lineending"; }
				if( $ind[deathplace] ) { $info .= "2 PLAC $ind[deathplace]$lineending"; }
			}
			if( $indnotes[DEAT] )
				$info .= writeNote( 2, "NOTE", $indnotes[DEAT] );
			if( $citations[DEAT] )
				$info .= writeCitation( $citations[DEAT], 2 );
			$info .= $extras[DEAT];
		}
		if( $ind[burialdate] || $ind[burialplace] || $indnotes[BURI] || $citations[BURI] || $extras[BURI] ) {
			if( $ind[burialdate] == "Y" || (!$ind[burialdate] && !$ind[burialplace]))
				$info .= "1 BURI Y$lineending";
			else {
				$info .= "1 BURI$lineending";
				if( $ind[burialdate] ) { $info .= "2 DATE $ind[burialdate]$lineending"; }
				if( $ind[burialplace] ) { $info .= "2 PLAC $ind[burialplace]$lineending"; }
			}
			if( $indnotes[BURI] )
				$info .= writeNote( 2, "NOTE", $indnotes[BURI] );
			if( $citations[BURI] )
				$info .= writeCitation( $citations[BURI], 2 );
			$info .= $extras[BURI];
		}

		if( $ind[allow_living] ) {
			$query = "SELECT tag, description, eventdate, eventplace, age, agency, cause, addressID, info, eventID FROM $events_table, $eventtypes_table WHERE persfamID = \"$person\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND parenttag = \"\" AND gedcom = \"$tree\" AND keep = \"1\" ORDER BY ordernum";
			$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			while ( $custevent = mysql_fetch_assoc( $custevents ) ) {
				$info .= doEvent( $custevent, 1 );
				$eventID = $custevent[eventID];
				if( $indnotes[$eventID] )
					$info .= writeNote( 2, "NOTE", $indnotes[$eventID] );
				if( $citations[$eventID] )
					$info .= writeCitation( $citations[$eventID], 2 );
				$info .= getFact( $custevent, 2 );
			}
			
			if( $allow_lds && $lds == "yes" ) {
				if( $ind[baptdate] || $ind[baptplace] ) {
					$info .= "1 BAPL$lineending";
					if( $ind[baptdate] ) { $info .= "2 DATE $ind[baptdate]$lineending"; }
					if( $ind[baptplace] ) {
						$tok = strtok ($ind[baptplace]," ");
						if( strlen( $tok ) == 5 ) {
							$info .= "2 TEMP $tok$lineending"; 
							$tok = strtok( " " );
							if( $tok )
								$info .= "2 PLAC $tok$lineending"; 
						}
						else
							$info .= "2 PLAC $ind[baptplace]$lineending"; 
					}
					if( $indnotes[BAPL] )
						$info .= writeNote( 2, "NOTE", $indnotes[BAPL] );
					if( $citations[BAPL] )
						$info .= writeCitation( $citations[BAPL], 2 );
					$info .= $extras[BAPL];
				}
				if( $ind[endldate] || $ind[endlplace] ) {
					$info .= "1 ENDL$lineending";
					if( $ind[endldate] ) { $info .= "2 DATE $ind[endldate]$lineending"; }
					if( $ind[endlplace] ) { 
						$tok = strtok ($ind[endlplace]," ");
						if( strlen( $tok ) == 5 ) {
							$info .= "2 TEMP $tok$lineending"; 
							$tok = strtok( " " );
							if( $tok )
								$info .= "2 PLAC $tok$lineending"; 
						}
						else
							$info .= "2 PLAC $ind[endlplace]$lineending"; 
					}
					if( $indnotes[ENDL] )
						$info .= writeNote( 2, "NOTE", $indnotes[ENDL] );
					if( $citations[ENDL] )
						$info .= writeCitation( $citations[ENDL], 2 );
					$info .= $extras[ENDL];
				}
			}
			//do associations
			$query = "SELECT passocID, relationship FROM $assoc_table WHERE gedcom = \"$tree\" AND personID = \"$person\"";
			$assocresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			while($assoc = mysql_fetch_assoc( $assocresult ) ) {
				$info .= "1 ASSO @$assoc[passocID]@$lineending";
				if( $assoc[relationship] ) $info .= "2 RELA $assoc[relationship]$lineending";
			}

			if( $indnotes['-x--general--x-'] )
				$info .= writeNote( 1, "NOTE", $indnotes['-x--general--x-'] );
		}
		mysql_free_result( $result );
	}
	return $info;
}

function writeFamily( $family ) {
	global $tree, $lds, $events_table, $eventtypes_table, $text, $allow_living, $allow_lds, $citations, $livedefault, $lineending;

	$familyID = $family[familyID];
	$family['allow_living'] = !$family['living'] || $livedefault == 2 || ( $allow_living && checkbranch( $family['branch'] ) ) ? 1 : 0;

	$info = "0 @$familyID@ FAM$lineending";
	if( $family[status] ) { $info .= "1 _STAT $family[status]$lineending"; }
	if( $family[husband] )
		$info .= "1 HUSB @$family[husband]@$lineending";
	if( $family[wife] )
		$info .= "1 WIFE @$family[wife]@$lineending";

	//look up husband, look up wife, get living

	if( $family['allow_living'] ) {
		$famnotes = getNotes( $familyID );
		$citations = getCitations( $familyID );
		$extras = getStdExtras( $familyID, 2 );
		if( $family[marrdate] || $family[marrplace] || $famnotes[MARR] || $citations[MARR] || $extras[MARR] || $family['marrtype'] ) {
			if( $family[marrdate] == "Y" || (!$family[marrdate] && !$family[marrplace]))
				$info .= "1 MARR Y$lineending";
			else {
				$info .= "1 MARR$lineending";
				if( $family[marrdate] ) { $info .= "2 DATE $family[marrdate]$lineending"; }
				if( $family[marrplace] ) { $info .= "2 PLAC $family[marrplace]$lineending"; }
			}
			if($family['marrtype']) $info .= "2 TYPE " . $family['marrtype'] . $lineending;
			if( $famnotes[MARR] )
				$info .= writeNote( 2, "NOTE", $famnotes[MARR] );
			if( $citations[MARR] )
				$info .= writeCitation( $citations[MARR], 2 );
			$info .= $extras[MARR];
		}
		if( $family[divdate] || $family[divplace] || $famnotes[DIV] || $citations[DIV] || $extras[DIV] ) {
			if( $family[divdate] == "Y" || (!$family[divdate] && !$family[divplace]))
				$info .= "1 DIV Y$lineending";
			else {
				$info .= "1 DIV$lineending";
				if( $family[divdate] ) { $info .= "2 DATE $family[divdate]$lineending"; }
				if( $family[divplace] ) { $info .= "2 PLAC $family[divplace]$lineending"; }
			}
			if( $famnotes[DIV] )
				$info .= writeNote( 2, "NOTE", $famnotes[DIV] );
			if( $citations[DIV] )
				$info .= writeCitation( $citations[DIV], 2 );
			$info .= $extras[DIV];
		}

		$query = "SELECT tag, description, eventdate, eventplace, age, agency, cause, addressID, info, eventID FROM $events_table, $eventtypes_table WHERE persfamID = \"$familyID\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND parenttag = \"\" AND gedcom = \"$tree\" AND keep = \"1\" ORDER BY ordernum";
		$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		while ( $custevent = mysql_fetch_assoc( $custevents ) ) {
			$info .= doEvent( $custevent, 1 );
			$eventID = $custevent[eventID];
			if( $famnotes[$eventID] )
				$info .= writeNote( 2, "NOTE", $famnotes[$eventID] );
			if( $citations[$eventID] )
				$info .= writeCitation( $citations[$eventID], 2 );
			$info .= getFact( $custevent, 2 );
		}
			
		if( $allow_lds && $lds == "yes" ) {
			if( $family[sealdate] || $family[sealplace] ) {
				$info .= "1 SLGS$lineending";
				if( $family[sealdate] ) { $info .= "2 DATE $family[sealdate]$lineending"; }
				if( $family[sealplace] ) { 
					$tok = strtok ($family[sealplace]," ");
					if( strlen( $tok ) == 5 ) {
						$info .= "2 TEMP $tok$lineending"; 
						$tok = strtok( " " );
						if( $tok )
							$info .= "2 PLAC $tok$lineending"; 
					}
					else
						$info .= "2 PLAC $fam[sealplace]$lineending"; 
				}
				if( $famnotes[SLGS] )
					$info .= writeNote( 2, "NOTE", $famnotes[SLGS] );
				if( $citations[SLGS] )
					$info .= writeCitation( $citations[SLGS], 2 );
				$info .= $extras[SLGS];
			}
		}
		if( $citations[NAME] )
			$info .= writeCitation( $citations[NAME], 1 );

		if( $famnotes['-x--general--x-'] )
			$info .= writeNote( 1, "NOTE", $famnotes['-x--general--x-'] );
	}

	return $info;
}

function processEntities ( $entarray ) {
	if( is_array( $entarray ) ) {
		foreach( $entarray as $thisent ) {
			echo $thisent;
		}
	}
}

function getDescendant( $person, $generation ) {
	global $tree, $maxgcgen, $famarray, $indarray, $families_table, $children_table, $people_table, $text, $lineending;
	
	$query = "SELECT * FROM $families_table WHERE husband = \"$person\" AND gedcom = \"$tree\" UNION SELECT * FROM $families_table WHERE wife = \"$person\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $result ) {
		while( $family = mysql_fetch_assoc( $result ) ) {
			if( $family[husband] == $person ) {
				$self = "husband";
				$spouse = "wife";
			}
			else {
				$self = "wife";
				$spouse = "husband";
			}
			$famarray[$family[familyID]] = writeFamily( $family );
			$indarray[$family[$spouse]] = writeIndividual( $family[$spouse] );
			$indarray[$family[$spouse]] .= "1 FAMS @$family[familyID]@$lineending";
			$indarray[$person] .= "1 FAMS @$family[familyID]@$lineending";
			
			if( $generation > 0 ) {
				$query = "SELECT $children_table.personID as personID, familyID, relationship, living, branch FROM $children_table, $people_table WHERE familyID = \"$family[familyID]\" AND $children_table.personID = $people_table.personID AND $children_table.gedcom = \"$tree\" AND $people_table.gedcom = \"$tree\" ORDER BY ordernum";
				$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				if( $result2 ) {
					while( $child = mysql_fetch_assoc( $result2 ) ) {
						$indarray[$child[personID]] = writeIndividual( $child[personID] );
						$indarray[$child[personID]] .= appendParents( $child );
						$famarray[$family[familyID]] .= "1 CHIL @$child[personID]@$lineending";
						if( $generation < $maxgcgen ) {
							getDescendant( $child[personID], $generation + 1 );
						}
					}
				}
				mysql_free_result( $result2 );
			}
		}
	}
	mysql_free_result( $result );
}

function doSources( ) {
	global $tree, $sources_table, $events_table, $eventtypes_table, $allsources, $text, $allrepos, $lineending;
	
	$newsources = array_unique( $allsources );
	if( $newsources ) {
		foreach( $newsources as $nextsource ) {
			$srcquery = "SELECT * FROM $sources_table WHERE sourceID = \"$nextsource\" AND gedcom = \"$tree\"";
			$srcresult = mysql_query($srcquery) or die ("$text[cannotexecutequery]: $query");
			if( $srcresult ) {
				$source = mysql_fetch_assoc( $srcresult );
				echo "0 @$source[sourceID]@ SOUR$lineending"; 
				if( $source[callnum] ) { echo "1 CALN $source[callnum]$lineending"; }
				if( $source[title] ) { echo "1 TITL $source[title]$lineending"; }
				if( $source[shorttitle] ) { echo "1 ABBR $source[shorttitle]$lineending"; }
				if( $source[author] ) { echo "1 AUTH $source[author]$lineending"; }
				if( $source[publisher] ) { echo "1 PUBL $source[publisher]$lineending"; }
				if( $source[repoID] ) {
					echo "1 REPO @$source[repoID]@$lineending";
					array_push( $allrepos, $source[repoID] );
				}

				$query = "SELECT tag, description, eventdate, eventplace, info FROM $events_table, $eventtypes_table WHERE persfamID = \"$source[sourceID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND type = \"S\" AND gedcom = \"$tree\" AND keep = \"1\" ORDER BY ordernum";
				$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				while ( $custevent = mysql_fetch_assoc( $custevents ) ) {
					echo doEvent( $custevent, 1 );
				}

				$srcnotes = getNotes( $nextsource );
				if( $srcnotes['-x--general--x-'] )
					echo doNote( 1, "NOTE", $srcnotes['-x--general--x-'] );
				if( $source[actualtext] ) {
					$srcnote = doNote( 1, "TEXT", $source[actualtext] );
					echo $srcnote;
				}
				mysql_free_result( $srcresult );
			}
		}
	}
}

function doRepositories( ) {
	global $tree, $repositories_table, $events_table, $eventtypes_table, $admtext, $savestate, $allrepos, $lineending;

	$newrepos = array_unique( $allrepos );
	if( $newrepos ) {
		foreach( $newrepos as $nextrepo ) {
			$repoquery = "SELECT * FROM $repositories_table WHERE repoID = \"$nextrepo\" AND gedcom = \"$tree\"";
			$reporesult = mysql_query($repoquery) or die ("$admtext[cannotexecutequery]: $query");
			if( $reporesult ) {
				$repo = mysql_fetch_assoc( $reporesult );
				echo "0 @$repo[repoID]@ REPO$lineending";
				if( $repo[reponame] ) { echo "1 NAME $repo[reponame]$lineending"; }
				if( $repo[addressID] ) { echo getFact( $repo, 1 ); }

				$query = "SELECT tag, description, eventdate, eventplace, info FROM $events_table, $eventtypes_table WHERE persfamID = \"$repo[repoID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND type = \"R\" AND gedcom = \"$tree\" AND keep = \"1\" ORDER BY ordernum";
				$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				while ( $custevent = mysql_fetch_assoc( $custevents ) ) {
					echo doEvent( $custevent, 1 );
				}

				$reponotes = getNotes( $repo[repoID] );
				if( $reponotes['-x--general--x-'] )
					echo writeNote( 1, "NOTE", $reponotes['-x--general--x-'] );
				mysql_free_result( $reporesult );
			}
		}
	}
}

if( $maxgcgen > 0 || $type == "all" ) {
	if( $maxgcgen > 999 ) {
		$maxgcgen = 999;
	}

	$query = "SELECT firstname, lnprefix, lastname, suffix, living, branch FROM $people_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("Cannot execute query: $query");
	if( $result ) {
		$row = mysql_fetch_assoc($result);
		$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && checkbranch( $row[branch] ) ) ? 1 : 0;
		$namestr = getName( $row );
		$filenamestr = ereg_replace( "'", "", $namestr );
		$filenamestr = ereg_replace( "\"", "", $filenamestr );
		$filenamestr = ereg_replace( "[\]", "", $filenamestr );
		$filenamestr = ereg_replace( " ", "", $filenamestr );
		$filenamestr = ereg_replace( ",", "", $filenamestr );

		mysql_free_result($result);
	}
	header("Content-type: application/ged"); 
	header("Content-Disposition: attachment; filename=$filenamestr.ged\n\n");

	include($cms['tngpath'] . "$mylanguage/text.php");
	$logname = $nonames && $row[living] ? $text[living] : $namestr;
	writelog( xmlcharacters("$text[gedcreatedfrom] $logname ($personID), $maxgcgen $text[generations] ($type) $text[gedcreatedfor] $email.") );
	preparebookmark( xmlcharacters("$text[gedcreatedfrom] $namestr ($personID), $maxgcgen $text[generations] ($type) $text[gedcreatedfor] $email.") );

	$owneremail = $treerow['email'] ? $treerow['email'] : $emailaddr;

	$firstpart = "0 HEAD$lineending"
	. "1 SOUR The Next Generation of Genealogy Sitebuilding$lineending"
	. "2 VERS $tng_version$lineending"
	. "2 NAME The Next Generation of Genealogy Sitebuilding (R)$lineending"
	. "2 CORP Next Generation Software, LLC$lineending"
	. "3 ADDR Sandy, UT$lineending"
	. "1 FILE $namestr.ged$lineending"
	. "1 GEDC$lineending"
	. "2 VERS 5.5$lineending"
	. "2 FORM LINEAGE-LINKED$lineending"
	. "1 CHAR " . ($session_charset == "UTF-8" ? "UTF-8" : "ANSI" ) . $lineending
	. "1 SUBM @SUB1@$lineending"
	. "0 @SUB1@ SUBM$lineending"
	. "1 NAME $dbowner$lineending"
	. "1 _EMAIL $owneremail$lineending"
	. "1 DEST Gedcom55$lineending";
	
	echo $firstpart;

	$generation = 1;
	
	if( $type == $text[ancestors] ) {
		getAncestor( $personID, $generation );
	}
	else if( $type == $text[descendants] ) {
		$indarray[$personID] = writeIndividual( $personID );
		getDescendant( $personID, $generation );
	}
	else if( $type == "all" ) {
		$query = "SELECT personID, sex FROM $people_table WHERE gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		while( $ind = mysql_fetch_assoc( $result ) ) {
			$indarray[$ind[personID]] = writeIndividual( $ind[personID] );
			$query = "";
			if( $ind[sex] == "M" )
				$query = "SELECT familyID FROM $families_table WHERE husband = \"$ind[personID]\" AND gedcom = \"$tree\" ORDER BY wifeorder";
			else if( $ind[sex] == "F" )
				$query = "SELECT familyID FROM $families_table WHERE wife = \"$ind[personID]\" AND gedcom = \"$tree\" ORDER BY husborder";
			if( $query ) {
				$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				while( $spouse = mysql_fetch_assoc( $result2 ) )
					$indarray[$ind[personID]] .= "1 FAMS @$spouse[familyID]@$lineending";
				mysql_free_result( $result2 );
			}
			echo $indarray[$ind[personID]];
		}
		mysql_free_result( $result );
		
		$query = "SELECT * FROM $families_table WHERE gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		while( $fam = mysql_fetch_assoc( $result ) ) {
			$famarray[$fam[familyID]] = writeFamily( $fam );
			
			$query = "SELECT personID as personID FROM $children_table WHERE familyID = \"$fam[familyID]\" AND gedcom = \"$tree\" ORDER BY ordernum";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( $result2 ) {
				while( $child = mysql_fetch_assoc( $result2 ) )
					$famarray[$fam[familyID]] .= "1 CHIL @$child[personID]@$lineending";
			}
			mysql_free_result( $result2 );
			echo $famarray[$fam[familyID]];
		}
		mysql_free_result( $result );
	}
	else {
		echo "error - no type.\n";
	}
	if( $type != "all" ) {
		processEntities( $indarray );
		processEntities( $famarray );
	}
	
	doSources();
	doXNotes();
	doRepositories();
	
	echo "0 TRLR";
}
else {
	tng_header( "Error", "" );
	echo "<h1>Error</h1>\n<p>maxgen = $maxgcgen. $text[nomaxgen]</p>\n";
	echo tng_menu( "", "", "", 1 );
	tng_footer( "" );
}
?>
