<?php
//set trim_it to a non-zero value to use this feature
$trim_it = 0;
//for individuals:
$trimsize[I] = 0;
//for families:
$trimsize[F] = 0;
//for sources:
$trimsize[S] = 0;

function getLine ( ) {
	global $fp, $lineending, $saveimport, $savestate;
	
	$lineinfo = "";
	if( $line = ltrim( @fgets($fp, 1024 ) ) ) {
		if( $saveimport) $savestate[len] = strlen($line);
		$patterns = array(  "/®®.*¯¯/", "/®®.*/", "/.*¯¯/", "/@@/" );
		$replacements = array( "", "", "", "@");
		$line = preg_replace( $patterns, $replacements, $line );
		
		preg_match( "/^(\d+)\s+(\S+) ?(.*)$/", $line, $matches );
		
		$lineinfo[level] = trim($matches[1]);
		$lineinfo[tag] = trim($matches[2]);
		$lineinfo[rest] = trim($matches[3], $lineending );
		//echo "$line: -$lineinfo[level]- -$lineinfo[tag]- -$lineinfo[rest]-<br/>\n";
	}
	if( !$lineinfo[tag] && !@feof( $fp ) ) $lineinfo = getLine();

	return $lineinfo;
}

function adjustID( $ID, $offset ) {
	global $trim_it, $trimsize;

	if( $offset || $trim_it ) {
		//find first numeric in ID
		preg_match( "/^(\D*)(\d*)(\D*)/", $ID, $matches );
		$prefix = $matches[1];
		$numericpart = $matches[2];
		$postfix = $matches[3];
		//add offset, make right length + add prefix
		$thistrim = $trimsize[$prefix] ? $trimsize[$prefix] : strlen( $numericpart );
		$newID = $prefix . str_pad( $numericpart + $offset, $thistrim, "0", STR_PAD_LEFT ) . $postfix;
	}
	else
		$newID = $ID;

	return $newID;
}

function getMoreInfo( $persfamID, $prevlevel, $prevtag, $prevtype ) {
	global $lineinfo, $tree, $admtext, $savestate, $address_table, $prefix;
	
	$moreinfo = array();

	if($prevtag == "ALIA" || $prevtag == "AKA" || $prevtag == "NAME")
		$moreinfo[FACT] = addslashes(removeDelims($lineinfo[rest]));
	else
		$moreinfo[FACT] = addslashes($lineinfo[rest]);
	if( $lineinfo[tag] == "ADDR" ) {
		$address = handleAddress($lineinfo[level], 0);
		$moreinfo[extra] = 1;
	}
	elseif($prevtag == "EVEN")
		$lineinfo[level]++;
	else
		$moreinfo[FACT] .= getContinued();

	$moreinfo[TYPE] = "";
	$moreinfo[parent] = "";
	$prevlevel++;
	$citecnt = 0;
	$notecnt = 0;
	$mminfo = array();
	$mmcount = 0;

	while( $lineinfo[level] >= $prevlevel ) {
		if( $lineinfo[level] == $prevlevel ) {
			$tag = $lineinfo[tag];
			switch( $tag ) {
				case "STAT":
				case "DATE":
					$moreinfo[DATE] = addslashes( $lineinfo[rest] );
					$moreinfo[DATETR] = convertDate( $moreinfo[DATE] );
					$lineinfo = getLine();
					break;
				case "_AKA":
				case "_ALIA":
					$tag = "ALIA";
				case "ALIA":
				case "NPFX":
				case "TYPE":
				case "TEMP":
				case "NSFX":
				case "NICK":
				case "TITL":
				case "SPFX":
					$moreinfo[$tag] = addslashes( $lineinfo[rest] );
					$lineinfo = getLine();
					break;
				case "AGE":
				case "AGNC":
				case "CAUS":
					$moreinfo[$tag] = addslashes( $lineinfo[rest] );
					$moreinfo[extra] = 1;
					$lineinfo = getLine();
					break;
				case "ADDR":
					$address = handleAddress($lineinfo[level], 1);
					$moreinfo[extra] = 1;
					break;
				case "ADR1": case "ADR2": case "CITY": case "STAE": case "POST": case "CTRY": case "WWW": case "PHON": case "EMAIL":
					$address[$tag] = addslashes( $lineinfo[rest] ) . getContinued();
					break;
				case "PLAC":
					$moreinfo[$tag] = addslashes( $lineinfo[rest] );
					savePlace( $moreinfo[$tag] );
					$lineinfo = getLine();
					break;
				case "FAMC":
					preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
					$moreinfo[$tag] = adjustID( $matches[1], $savestate[foffset] );
					$lineinfo = getLine();
					break;
				//case "TEXT":
				case "NOTE":
					//$notecount++;
					if( !$notecnt ) $moreinfo[NOTES] = array();
					$notecnt++;

					$moreinfo[NOTES][$notecnt] = array();
					preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
					if( $matches[1] ) {
						$moreinfo[NOTES][$notecnt][XNOTE] = adjustID( $matches[1], $savestate[noffset] );
						$lineinfo = getLine();
					}
					else {
						$moreinfo[NOTES][$notecnt][NOTE] = addslashes($lineinfo[rest]);
						$moreinfo[NOTES][$notecnt][XNOTE] = "";
						$moreinfo[NOTES][$notecnt][NOTE] .= getContinued();
					}
					$moreinfo[NOTES][$notecnt][TAG] = $prevtag;
					$ncitecount = 0;
					while( $lineinfo[level] >= $prevlevel + 1 && $lineinfo[tag] == "SOUR" ) {
						$ncitecount++;
						$moreinfo[NOTES][$notecnt][SOUR][$ncitecount] = handleSource( $persfamID, $prevlevel + 1 );
					}
					break;
				case "SOUR":
					if( !$citecnt ) $moreinfo[SOUR] = array();
					$citecnt++;
					$moreinfo[SOUR][$citecnt] = handleSource( $persfamID, $prevlevel );
					break;
				case "IMAGE":
				case "OBJE":
					if( $savestate[media] ) {
						preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
						$mmcount++;
						$mminfo[$mmcount] = getMoreMMInfo( $lineinfo[level], $mmcount );
						$mminfo[$mmcount][OBJE] = $matches[1] ? $matches[1] : $mminfo[$mmcount][FILE];
						$mminfo[$mmcount][linktype] = $prefix;
					}
					else
						$lineinfo = getLine();
					break;
				default:
					//if( $moreinfo[FACT] ) $moreinfo[FACT] .= ", ";
					//$moreinfo[FACT] .= addslashes( removeDelims( $lineinfo[rest] ) );
					$lineinfo = getLine();
					break;
			}
		}
		else
			$lineinfo = getLine();
	}

	if( $mmcount ) {
		$moreinfo[MEDIA] = $mminfo;
	}
	if( is_array( $address ) ) {
		$query = "INSERT INTO $address_table (gedcom, address1, address2, city, state, zip, country, www, email, phone) VALUES(\"$tree\", \"$address[ADR1]\", \"$address[ADR2]\", \"$address[CITY]\", \"$address[STAE]\", \"$address[POST]\",  \"$address[CTRY]\", \"$address[WWW]\", \"$address[EMAIL]\", \"$address[PHON]\")";
		$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		$moreinfo[ADDR] = mysql_insert_id();
		if( $moreinfo[FACT] == $address[ADR1] ) $moreinfo[FACT] = "";
	}
	return $moreinfo;
}

function handleCustomEvent($id,$prefix,$tag) {
	global $lineinfo, $custeventlist, $allevents;

	$event = array();
	$event[TAG] = $tag;
	$needmore = 1;
	$savelevel = $lineinfo[level];
	if( $tag == "EVEN" ) {
		$fact = addslashes($lineinfo[rest] . getContinued());
		$needfact = 1;
		//next one must be TYPE
		//$lineinfo = getLine();
		if($lineinfo['tag'] == "TYPE") {
			$event[TYPE] = trim(addslashes( $lineinfo['rest'] ));
		}
		else
			$event[TYPE] = $fact;
		$lineinfo = getLine();
		if($lineinfo['level'] <= $savelevel)
			$needmore = 0;
		else
			$lineinfo['level']--;
	}
	else {
		$fact = "";
		$needfact = 0;
	}
	$thisevent = strtoupper($prefix . "_" . $tag . "_" . $event[TYPE]);
	//make sure it's a keeper before continuing by checking against type_tag_desc list
	if( $allevents || in_array( $thisevent, $custeventlist ) ) {
		if($needmore)
			$event[INFO] = getMoreInfo( $id, $lineinfo[level], $tag, $event[TYPE] );
		if( $needfact ) $event[INFO][FACT] = $fact;
	}
	elseif($needmore)
		$lineinfo = getLine();

	return $event;
}

function handleAddress($prevlevel, $flag) {
	global $lineinfo;

	$address = array();
	$address[ADR1] = addslashes( $lineinfo[rest] );
	$gotaddr = $address[ADR1] ? 1 : 0;
	$prevlevel++;

	$notdone = 1;
	$addr[0] = "ADR1";
	$addr[1] = "CITY";
	$addr[2] = "STAE";
	$addr[3] = "POST";
	$addr[4] = "CTRY";
	$counter = 0;

	while( $notdone ) {
		$lineinfo = getLine( );
		if ( $lineinfo[tag] == "CONC" ) {
			$addrtag = $addr[$counter];
			$address[$addrtag] .= addslashes($lineinfo[rest]);
		}
		elseif ( $lineinfo[tag] == "CONT" ) {
			if( $counter < 4 ) $counter++;
			$addrtag = $addr[$counter];
			$address[$addrtag] .= addslashes( "$lineinfo[rest]" );
		}
		else
			$notdone = 0;
	}
	if( $flag ) {
		while( $lineinfo[level] >= $prevlevel ) {
			if( $lineinfo[level] == $prevlevel ) {
				$tag = $lineinfo[tag];
				switch( $tag ) {
					case "ADR1": case "ADR2": case "CITY": case "STAE": case "POST": case "CTRY": case "WWW": case "PHON": case "EMAIL":
						$address[$tag] = addslashes( $lineinfo[rest] ) . getContinued();
						if($address[$tag]) $gotaddr = 1;
						break;
					default:
						$lineinfo = getLine();
						break;
				}
			}
			else
				$lineinfo = getLine();
		}
	}
	return $gotaddr ? $address : null;
}

function getContinued( ) {
	global $lineinfo;
	
	$continued = "";
	$notdone = 1;
	
	while( $notdone ) {
		$lineinfo = getLine( );
		if ( $lineinfo[tag] == "CONC" ) { $continued .= addslashes($lineinfo[rest]); }
		elseif ( $lineinfo[tag] == "CONT" ) { 
			//if( $continued ) $lineinfo[rest] = "\n$lineinfo[rest]";
			$continued .= addslashes( "\n$lineinfo[rest]" ); 
		}
		else 
			$notdone = 0;
	}
	return $continued;
}

function deleteLinksOnMatch( $entityID ) {
	global $tree, $events_table, $notelinks_table, $citations_table, $xnotes_table, $admtext, $address_table, $medialinks_table, $assoc_table;
	
	$query = "SELECT addressID from $events_table WHERE persfamID = \"$entityID\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $row = mysql_fetch_assoc( $result ) ) {
		$query = "DELETE from $address_table WHERE addressID = \"$row[addressID]\"";
		$result2 = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
	mysql_free_result( $result );

	$query = "DELETE from $events_table WHERE gedcom = \"$tree\" AND persfamID = \"$entityID\"";
	$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DELETE from $assoc_table WHERE personID = \"$entityID\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	//we won't be able to match media links for custom events, since the custom event IDs will be renumbered, so delete the media links and start again
	//$query = "DELETE from $medialinks_table WHERE gedcom = \"$tree\" AND personID = \"$entityID\" AND eventID != '' AND eventID REGEXP ('[0-9]')";
	//$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "SELECT xnoteID from $notelinks_table WHERE persfamID = \"$entityID\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $row = mysql_fetch_assoc( $result ) ) {
		$query = "DELETE from $xnotes_table WHERE ID = \"$row[xnoteID]\"";
		$result2 = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
	mysql_free_result( $result );
	$query = "DELETE from $notelinks_table WHERE persfamID = \"$entityID\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "DELETE from $citations_table WHERE persfamID = \"$entityID\" AND gedcom = \"$tree\"";
	$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}

function getPlaceRecord($place, $prevlevel) {
	global $savestate, $tree, $admtext, $lineinfo, $places_table, $link;

	$note = "";
	$map = array();
	$map['long'] = "";
	$map['lati'] = "";
	$mminfo = array();
	$mmcount = 0;
	$prevlevel++;

	$lineinfo = getLine( );
	while( $lineinfo['tag'] && $lineinfo['level'] >= $prevlevel ) {
		if( $lineinfo['level'] == $prevlevel ) {
			$tag = $lineinfo['tag'];
			switch( $tag ) {
				case "PLAC":
					$place = addslashes($lineinfo['rest']);
					$info = getPlaceRecord( "", $lineinfo['level'] );
					if($info['NOTE']) $note .= $info['NOTE'];
					if($info['MAP']) $map = $info['MAP'];
					if($info['media']) {
						$mminfo = array_merge($mminfo,$info['media']);
						$mmcount = count($mminfo);
					}
					break;
				case "NOTE":
					$note .= addslashes($lineinfo[rest]);
					$note .= getContinued();
					break;
				case "MAP":
					$map = getMapCoords( $lineinfo['level']);
					break;
				case "OBJE":
					if( $savestate['media'] ) {
						preg_match( "/^@(\S+)@/", $lineinfo['rest'], $matches );
						$mmcount++;
						$mminfo[$mmcount] = getMoreMMInfo( $lineinfo['level'], $mmcount );
						$mminfo[$mmcount]['OBJE'] = $matches[1] ? $matches[1] : $mminfo[$mmcount][FILE];
						$mminfo[$mmcount]['linktype'] = "L";
					}
					else
						$lineinfo = getLine();
					break;
				default:
					$lineinfo = getLine();
					break;
			}
		}
		else
			$lineinfo = getLine();
	}

	if($place) {
		$query = "INSERT IGNORE INTO $places_table (place,gedcom,longitude,latitude,zoom,placelevel,notes) VALUES(\"$place\", \"$tree\", \"$map[long]\", \"$map[lati]\", 0, 0, \"$note\" )";
		$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		$success = mysql_affected_rows( $link );
		if( !$success && $savestate[del] != "no" && (($savestate['latlong'] && ($map['long'] || $map['lati'])) || $note)) {
			$query = "UPDATE $places_table SET ";
			$query1 = "";
			if($savestate['latlong'] && ($map['long'] || $map['lati']))
				$query1 .= "longitude=\"$map[long]\", latitude=\"$map[lati]\"";
			if($note) {
				if($query1) $query1 .= ", ";
				$query1 .= "notes=\"$note\"";
			}
			$query = $query . $query1 . " WHERE place=\"$place\"";
			$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
			$success = 1;
		}
		if( $mmcount )
			processMedia( $mmcount, $mminfo, $place, "" );
	}
	else {
		$info = array();
		$info['MAP'] = $map;
		$info['NOTE'] = $note;
		$info['media'] = $mminfo;
		return $info;
	}
}

function getMapCoords($prevlevel) {
	global $lineinfo;

	$map = array();
	$map['long'] = "";
	$map['lati'] = "";
	$prevlevel++;

	$lineinfo = getLine( );
	while( $lineinfo['tag'] && $lineinfo['level'] >= $prevlevel ) {
		if( $lineinfo['level'] == $prevlevel ) {
			$tag = $lineinfo['tag'];
			switch( $tag ) {
				case "LATI":
					$lati = ereg_replace("N","",$lineinfo['rest']);
					$map['lati'] = ereg_replace("S","-",$lati);
					$lineinfo = getLine();
					break;
				case "LONG":
					$long = ereg_replace("E","",$lineinfo['rest']);
					$map['long'] = ereg_replace("W","-",$long);
					$lineinfo = getLine();
					break;
				default:
					$lineinfo = getLine();
					break;
			}
		}
		else
			$lineinfo = getLine();
	}

	return $map;
}

function savePlace( $place ) {
	global $tree, $places_table, $admtext;

	$query = "INSERT IGNORE INTO $places_table (gedcom, place, zoom, placelevel) VALUES(\"$tree\",\"$place\",0,0)";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
}

function incrCounter( $prefix ) {
	global $savestate, $saveimport, $saveimport_table, $tree, $admtext, $fp;
	
	switch( $prefix ) {
		case "F":
			$savestate[fcount]++;
			$counter = $savestate[fcount];
			break;
		case "I":
			$savestate[icount]++;
			$counter = $savestate[icount];
			break;
		case "S":
			$savestate[scount]++;
			$counter = $savestate[scount];
			break;
		case "M":
			$savestate[mcount]++;
			$counter = $savestate[mcount];
			break;
		case "N":
			$savestate[ncount]++;
			$counter = $savestate[ncount];
			break;
	}
	if( $counter % 10 == 0 ) {
		echo "<strong>$prefix$counter</strong> ";
	}
	if( $saveimport ) {
		$offset = ftell( $fp ) - $savestate[len]; 
		$query = "UPDATE $saveimport_table SET icount = $savestate[icount], fcount = $savestate[fcount], scount = $savestate[scount], ncount = $savestate[ncount], offset = $offset WHERE gedcom = \"$tree\"";
		$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
	}
}

//media
function adjustMediaFileName( $mm ) {
	global $assignnames, $wholepath, $imagetypes;
	
	if( $mm['path'] && $assignnames ) {
		$newname = $mm['path'];
	}
	else {
		$newname = $mm['FILE'];
		if( $newname ) {
			$found = 0;
			$pathlist = getLocalPathList($mm['mediatypeID']);
			if( $pathlist )	{
				$paths = explode(",", $pathlist);
				foreach( $paths as $path ) {
					if( substr_count( $newname, $path ) ) {
						$newname = substr( $newname, strlen( $path ) );
						$found = 1;
						break;
					}
				}
			}
			$newname = str_replace( "\\", "/", $newname );
			if( !$found && !$wholepath )
				$newname = basename( $newname );
			elseif( substr( $newname, 0, 1 ) == "/" )
				$newname = substr( $newname, 1 );
		}
	}

	return $newname;
}

function getLocalPathList($mediatypeID) {
	global $locimppath;

	switch( $mediatypeID ) {
		case "photos":
			$locpath = $locimppath['photos'];
			break;
		case "histories":
			$locpath = $locimppath['histories'];
			break;
		case "documents":
       		$locpath = $locimppath['documents'];
			break;
		default:
			$locpath = $locimppath['other'];
			break;
	}

	return $locpath;
}

function getMoreMMInfo( $prevlevel, $mmcount ) {
	global $lineinfo, $tree, $admtext;

	$moreinfo = array();
	$prevlevel++;
	$moreinfo['FORM'] = "";
	
	$lineinfo = getLine();
	while( $lineinfo[level] >= $prevlevel ) {
		$tag = $lineinfo[tag];
		switch( $tag ) {
			case "FILE":
				$moreinfo['FILE'] = $lineinfo[rest];
				$lineinfo = getLine();
				break;
			case "TITL":
				$moreinfo[$tag] = addslashes( $lineinfo[rest] );
				$lineinfo = getLine();
				break;
			case "FORM":
				$moreinfo[$tag] = addslashes( strtoupper( $lineinfo[rest] ) );
				$lineinfo = getLine();
				break;
			case "NOTE":
				$moreinfo['NOTE'] = addslashes( $lineinfo[rest] );
				$moreinfo['NOTE'] .= getContinued();
				break;
			case "CHAN":
				$lineinfo = getLine();
				$moreinfo['CHAN'] = addslashes( $lineinfo[rest] );
				if( $moreinfo['CHAN'] ) {
					$moreinfo['CHAN'] = date( "Y-m-d H:i:s", strtotime( $moreinfo['CHAN'] ) );
					$lineinfo = getLine();
				}
				break;
			case "_TYPE":
			case "TYPE":
				$moreinfo['mediatypeID'] = getMediaCollection2( $lineinfo[rest] );
				$lineinfo = getLine();
				break;
			default:
				$lineinfo = getLine();
				break;
		}
	}
	if( !$moreinfo['FORM'] && $moreinfo['FILE'] ) {
		$lastperiod = strrpos($moreinfo['FILE'],".");
		if($lastperiod)
			$moreinfo['FORM'] = strtoupper(substr($moreinfo['FILE'],$lastperiod + 1));
	}
	if($moreinfo['FORM'] && !isset($moreinfo['mediatypeID']))
		$moreinfo['mediatypeID'] = getMediaCollection( $moreinfo['FORM'] );
	$moreinfo['FILE'] = adjustMediaFileName( $moreinfo );
	
	return $moreinfo;
}

function getMediaCollection($form) {
	global $imagetypes, $historytypes, $documenttypes, $videotypes, $recordingtypes;

	if( in_array( $form, $historytypes ) )
		$mediatypeID = "histories";
	elseif( in_array( $form, $documenttypes ) )
		$mediatypeID = "documents";
	elseif( in_array( $form, $videotypes ) )
		$mediatypeID = "videos";
	elseif( in_array( $form, $recordingtypes ) )
		$mediatypeID = "recordings";
	else
		$mediatypeID = "photos";

	return $mediatypeID;
}

function getMediaCollection2($type) {
	$newtype = substr(strtolower($type),0,5);
	$mediatypeID = "";
	switch($newtype) {
		case "photo":
			if(strtolower($type) == "photo document")
				$mediatypeID = "documents";
			else
				$mediatypeID = "photos";
			break;
		case "histo":
		case "biogr":
			$mediatypeID = "histories";
			break;
		case "docum":
			$mediatypeID = "documents";
			break;
		case "video":
			$mediatypeID = "videos";
			break;
		case "heads":
			$mediatypeID = "headstones";
			break;
		default:
			$mediatypeID = strtolower($type);
			break;
	}

	return $mediatypeID;
}

function getMediaFolder($mediatypeID) {
	global $rootpath, $mediapath, $photopath, $documentpath, $historypath;

	switch( $mediatypeID ) {
		case "photos":
			$mmpath = "$rootpath$photopath";
			break;
		case "histories":
			$mmpath = "$rootpath$historypath";
			break;
		case "documents":
       		$mmpath = "$rootpath$documentpath";
			break;
		default:
			$mmpath = "$rootpath$mediapath";
			break;
	}

	return $mmpath;
}

function processMedia( $mmcount, $mminfo, $persfamID, $eventID ) {
	global $admtext, $medialinks_table, $tree, $media_table, $link, $savestate;

	for( $mmctr = 1; $mmctr <= $mmcount; $mmctr++ ) {
		$mm = $mminfo[$mmctr];
		//insert ignore into media
		if(!$mm[TITL]) $mm[TITL] = $mm[FILE];
		$query = "INSERT IGNORE INTO $media_table (gedcom, mediatypeID, mediakey, path, description, notes, form, usecollfolder, changedate) VALUES(\"$tree\", \"$mm[mediatypeID]\", \"$mm[OBJE]\", \"$mm[FILE]\", \"$mm[TITL]\", \"$mm[NOTE]\", \"$mm[FORM]\", \"1\", \"$mm[CHAN]\")";
		$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");

		$success = mysql_affected_rows( $link );
		if( $success )
			$mediaID = mysql_insert_id();
		else {
			//update if necessary
			$query = "SELECT mediaID FROM $media_table WHERE gedcom = \"$tree\" AND mediakey = \"$mm[OBJE]\"";
			$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
			$row = mysql_fetch_assoc( $result );
			$mediaID = $row['mediaID'];
			mysql_free_result($result);
			if( $savestate[del] != "no" ) {
				if( $mm['FILE'] || $mm['TITL'] || $mm['NOTE'] ) {
					$changedatestr = $mm['CHAN'] ? ", changedate=\"$mm[CHAN]\"" : "";
					//$query = "UPDATE $media_table SET path=\"$mm[FILE]\", description=\"$mm[TITL]\", notes=\"$mm[NOTE]\", form=\"$mm[FORM]\"$changedatestr WHERE gedcom = \"$tree\" AND mediakey = \"$mm[OBJE]\"";
					$descstr = $mm[TITL] ? ", description=\"$mm[TITL]\"" : "";
					$notestr = $mm[NOTE] ? ", notes=\"$mm[NOTE]\"" : "";
					$query = "UPDATE $media_table SET path=\"$mm[FILE]\"$descstr$notestr, form=\"$mm[FORM]\"$changedatestr WHERE gedcom = \"$tree\" AND mediakey = \"$mm[OBJE]\"";
				}
				elseif( $mm['CHAN'] )
					$query = "UPDATE $media_table SET changedate=\"$mm[CHAN]\" WHERE gedcom = \"$tree\" AND mediakey = \"$mm[OBJE]\"";
				$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
			}
		}
		//get ordernum according to collection/mediatypeID
		$query = "SELECT count(medialinkID) as count from ($medialinks_table, $media_table) WHERE $media_table.mediaID = $medialinks_table.mediaID AND $medialinks_table.gedcom = \"$tree\" AND personID = \"$persfamID\" AND mediatypeID = \"$mm[mediatypeID]\"";
		$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		$row = mysql_fetch_assoc( $result );
		$orderctr = $row[count] ? $row[count] + 1 : 1;
		mysql_free_result($result);

		//insert ignore or update medialink
		$query = "INSERT IGNORE INTO $medialinks_table (personID, mediaID, linktype, altdescription, altnotes, ordernum, gedcom, eventID)  VALUES(\"$persfamID\", \"$mediaID\", \"$mm[linktype]\", \"$mm[TITL]\", \"$mm[NOTE]\", \"$orderctr\", \"$tree\", \"$eventID\")";
		$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		$psuccess = mysql_affected_rows( $link );
		if( !$psuccess && $savestate[del] != "no" ) {
			$query = "UPDATE $medialinks_table SET altdescription=\"$mm[TITL]\", altnotes=\"$mm[NOTE]\" WHERE gedcom=\"$tree\" AND personID=\"$persfamID\" AND mediaID=\"$mediaID\" and eventID=\"$eventID\"";
			$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		}
	}
}

function getCodedMedia( ) {
	global $lineinfo;
	
	$continued = "";
	$notdone = 1;
	
	while( $notdone ) {
		$lineinfo = getLine( );
		//echo "$lineinfo[level] $lineinfo[tag] $lineinfo[rest]<br/>\n";
		if ( $lineinfo[tag] == "CONT" || $lineinfo[tag] == "CONC" ) 
			$continued .= $lineinfo[rest];
		else 
			$notdone = 0;
	}
	return $continued;
}

function mmd( $nextchar ) {
	global $decodearr;
	
	if( ord( $nextchar ) <= 57 ) 
		$offset = 46;
	elseif( ord( $nextchar ) <= 90 )
		$offset = 53;
	elseif( ord( $nextchar ) <= 122 )
		$offset = 59;
	else
		$offset = 0;
		
	if( $offset )
		$rval = str_pad(decbin(ord( $nextchar ) - $offset),6,"0",STR_PAD_LEFT);
	else
		$rval = "";

	return $rval;
}

function getMultimediaRecord( $objectID, $prevlevel ) {
	global $link, $tree, $admtext, $savestate, $lineinfo, $media_table;
	global $mminfo, $today, $tngimpcfg, $mediapath, $thumbprefix, $thumbsuffix;

	$prefix = "M";
	$info = ""; 
	$changedate = "";
	$prevlevel++;
	$continued = 0;
	$gotfile = 0;
	$mmpath = "";
	
	$mminfo[ID] = $objectID;
	//echo "doing $objectID<br>\n";
	$lineinfo = getLine( );
	while( $lineinfo[tag] && $lineinfo[level] >= $prevlevel ) {
		if( $lineinfo[level] == $prevlevel ) {
			$tag = $lineinfo[tag];
			switch( $tag ) {
				case "BLOB":
					if( !isset( $mminfo[$objectID] ) ) {
						$mminfo[path] = "$tree.$mminfo[ID].$mminfo[FORM]";
						$mmpath = getMediaFolder($mminfo[mediatypeID]) . "/$mminfo[path]";
						$mminfo[$objectID] = fopen( $mmpath, "wb" );
						flock( $mminfo[$objectID], 2 );
						$gotfile = 1;
					}
					$mminfo[ID] = $mminfo[saved];
					$encodedstr = getCodedMedia();
					$chars = preg_split('//', $encodedstr, -1, PREG_SPLIT_NO_EMPTY);
					$end = count( $chars );
					$ptr = 0;
					while( $ptr < $end ) {
						$newstr= mmd($chars[$ptr]) . mmd($chars[$ptr+1]) . mmd($chars[$ptr+2]) . mmd($chars[$ptr+3]);
						$packed = pack( "c*", bindec(substr($newstr,16,8)), bindec(substr($newstr,8,8)), bindec(substr( $newstr,0,8)) );
						fwrite( $mminfo[$objectID], $packed );
						$ptr += 4;
					}
					break;
				case "OBJE":
					//continue a previous one
					$continued = 1;
					//echo "continuing $objectID<br>";
					$mminfo[saved] = $objectID;
					preg_match( "/^@(\S+)@/", $lineinfo[rest], $matches );
					$index = $matches[1];
					$mminfo[$index] = $mminfo[$objectID];
					$lineinfo = getLine();
					break;
				case "FILE":
				case "_FILE":
					$mminfo['FILE'] = $lineinfo[rest];
					if( !$mminfo[mediatypeID] ) {
						$lastperiod = strrpos($moreinfo['FILE'],".");
						if($lastperiod) {
							$mminfo['FORM'] = strtoupper(substr($mminfo['FILE'],$lastperiod + 1));
							$mminfo['mediatypeID'] = getMediaCollection($mminfo['FORM']);
						}
					}
					$lineinfo = getLine();
					break;
				case "TITL":
					$mminfo['TITL'] = addslashes( $lineinfo[rest] );
					$lineinfo = getLine();
					break;
				case "FORM":
					$mminfo['FORM'] = addslashes( strtoupper( $lineinfo[rest] ) );
					if( !$mminfo[mediatypeID] ) $mminfo[mediatypeID] = getMediaCollection($mminfo['FORM']);
					$lineinfo = getLine();
					break;
				case "NOTE":
					$mminfo['NOTE'] = addslashes( $lineinfo[rest] );
					$mminfo['NOTE'] .= getContinued();
					break;
				case "CHAN":
					$lineinfo = getLine();
					$changedate = addslashes( $lineinfo[rest] );
					if( $changedate ) {
						$changedate = date( "Y-m-d H:i:s", strtotime( $changedate ) );
						$lineinfo = getLine();
					}
					break;
				default:
					$lineinfo = getLine();
					break;
			}
		}
		else
			$lineinfo = getLine();
	}
	if( !$continued ) {
		if( $gotfile ) {
			flock( $mminfo[$objectID], 3 );
			fclose( $mminfo[$objectID] );
		}

		$inschangedt = $changedate ? $changedate : ($tngimpcfg[chdate] ? "" : $today);
		if( $savestate[del] != "no" ) {
			$mminfo['FILE'] = adjustMediaFileName( $mminfo );
			if( $mminfo['FILE'] != $mminfo[path] ) {
				if( $mminfo['FILE'] && $mminfo[path] ) {
					$mmpath = getMediaFolder($mminfo[mediatypeID]);
					rename( $mmpath . "/$mminfo[path]", $mmpath . "/$mminfo[FILE]" );
				}
			}

			$thumbpath = ($thumbprefix || $thumbsuffix) ? "$thumbprefix$mminfo[path]" . $thumbsuffix : $mminfo[path];
			if( !$mminfo['mediatypeID'] ) $mminfo['mediatype'] = "photos";
			$mminfo[ucf] = ($mmpath && $mmpath == $mediapath) ? 0 : 1;

			//get the mediatypeID, hs & history items, mediakey--should it always be the file?
			if(!$mminfo[TITL]) $mminfo[TITL] = $mminfo[FILE];
			$query = "INSERT IGNORE INTO $media_table (gedcom, mediakey, path, thumbpath, description, notes, form, mediatypeID, usecollfolder, changedate) VALUES(\"$tree\", \"$mminfo[ID]\", \"$mminfo[FILE]\", \"$thumbpath\", \"$mminfo[TITL]\", \"$mminfo[NOTE]\", \"$mminfo[FORM]\", \"$mminfo[mediatypeID]\", \"$mminfo[ucf]\", \"$changedate\")";
			$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");

			$success = mysql_affected_rows( $link );
			if( !$success ) {
				//$thumbstr = $thumbprefix ? "thumbpath=\"$thumbprefix$mminfo[path]" . $thumbsuffix . "\", " : "";
				$query = "UPDATE $media_table SET path=\"$mminfo[FILE]\", description=\"$mminfo[TITL]\", notes=\"$mminfo[NOTE]\", form=\"$mminfo[FORM]\", changedate=\"$changedate\" WHERE gedcom = \"$tree\" AND mediakey = \"$mminfo[ID]\"";
				$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
			}
		}

		unset( $mminfo );
		incrCounter( $prefix );
	}
}

//sources
function processCitations( $persfamID, $eventID, $citearray ) {
	if(is_array($citearray)) {
		foreach( $citearray as $cite )
			saveCitation( $persfamID, $eventID, $cite );
	}
}

function saveCitation( $persfamID, $eventID, $cite ) {
	global $citations_table, $admtext, $tree;
	
	if( !$cite[DATETR] ) $cite[DATETR] = "0000-00-00";
	$query = "INSERT INTO $citations_table (persfamID, gedcom, eventID, sourceID, description, citedate, citedatetr, citetext, page, quay, note ) VALUES(\"$persfamID\", \"$tree\", \"$eventID\", \"$cite[sourceID]\", \"$cite[desc]\", \"$cite[DATE]\", \"$cite[DATETR]\", \"$cite[TEXT]\", \"$cite[PAGE]\", \"$cite[QUAY]\", \"$cite[NOTE]\" )";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
}

//notes
function processNotes( $persfamID, $eventID, $notearray ) {
	if(is_array($notearray)) {
		foreach( $notearray as $note )
			saveNote( $persfamID, $eventID, $note );
	}
}

function saveNote( $persfamID, $eventID, $note ) {
	global $notelinks_table, $xnotes_table, $admtext, $tree, $link, $tngimpcfg;
	
	$found = 0;
	if( $note[XNOTE] ) {
		$query = "SELECT ID FROM $xnotes_table WHERE noteID = \"$note[XNOTE]\" AND gedcom = \"$tree\"";
		$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		$row = mysql_fetch_assoc( $result );
		if( mysql_num_rows( $result ) ) {
			$xnoteID = $row[ID];
			$found = 1;
		}
		mysql_free_result( $result );
	}
	if( !$found ) {
		$query = "INSERT INTO $xnotes_table (noteID, gedcom, note)  VALUES(\"$note[XNOTE]\", \"$tree\", \"$note[NOTE]\")";
		$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		$xnoteID = mysql_insert_id();
	}

	$privlen = strlen($tngimpcfg[privnote]);
	$secret = ($privlen && substr($note[NOTE],0,$privlen) == $tngimpcfg[privnote]) ? 1 : 0;
	$query = "INSERT IGNORE INTO $notelinks_table (persfamID, gedcom, eventID, xnoteID, secret) VALUES(\"$persfamID\", \"$tree\", \"$eventID\", \"$xnoteID\", \"$secret\" )";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
	$ID = mysql_insert_id( );
	
	if( isset( $note[SOUR] ) )
		processCitations( $persfamID, "N$ID", $note[SOUR] );
}

function getNoteRecord( $noteID, $prevlevel ) {
	global $link, $tree, $admtext, $savestate, $lineinfo, $xnotes_table, $citations_table;

	$noteID = adjustID( $noteID, $savestate[noffset] );

	$prefix = "N";
	$info = "";
	$prevlevel++;
	
	preg_match( "/^NOTE ?(.*)$/", $lineinfo[rest], $matches );
	if( $matches[1] )
		$note = addslashes( $matches[1] );
	else
		$note = "";
	$lineinfo = getLine( );
	if( $lineinfo[level] && ( $lineinfo[tag] == "NOTE" || $lineinfo[tag] == "CONT" || $lineinfo[tag] == "CONC" ) ) {
		if( $note && $lineinfo[tag] != "CONC" )
			$note .= "\n";
		$note .= addslashes( $lineinfo[rest] ); 
		$note .= getContinued();
	}
	$notectr = 0;
	while( $lineinfo[level] >= $prevlevel && $lineinfo[tag] == "SOUR" ) {
		$notectr++;
		$notesource[$notectr] = handleSource( $noteID, $prevlevel + 1 );
	}

	$query = "SELECT ID FROM $xnotes_table WHERE noteID = \"$noteID\" AND gedcom = \"$tree\"";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	if( mysql_num_rows( $result ) && $savestate[del] != "no" ) {
		$query = "UPDATE $xnotes_table SET note=\"$note\" WHERE noteID=\"$noteID\" AND gedcom = \"$tree\"";
		$xresult = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
	}
	else {
		$query = "INSERT INTO $xnotes_table (noteID, gedcom, note)  VALUES(\"$noteID\", \"$tree\", \"$note\")";
		$xresult = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
	}
	if( $notectr ) {
		if( $savestate[del] == "match" ) {
			$query = "DELETE from $citations_table WHERE persfamID = \"$noteID\" and gedcom = \"$tree\"";
			$result2 = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		}
		processCitations( $noteID, "", $notesource );
	}
	mysql_free_result($result);

	incrCounter( $prefix );
}

function dumpnotes( $notearray ) {
	global $stdnotes, $notecount;

	foreach( $notearray as $note ) {
		$notecount++;
		$stdnotes[$notecount] = $note;
	}
}

//custom events
function saveCustEvents( $prefix, $persfamID, $events, $totevents ) {
	global $events_table, $eventtypes_table, $custevents, $admtext, $tree, $medialinks, $num_medialinks, $eventlinks, $medialinks_table, $allevents, $savestate;

	for( $eventnum = 1; $eventnum <= $totevents; $eventnum++ ) {
		$event = $events[$eventnum][TAG];
		$eventptr = $events[$eventnum][INFO];
		$description = $events[$eventnum][TYPE];
		if( $event == "EVEN" ) {
			$wherestr =  "AND description = \"$description\"";
		}
		else 
			$wherestr = "";
		if( $description ) 
			$display = $description;
		else {
			$display = $admtext[$event];
			if( !$display ) $display = $event;
		}
		$eventinfo = $eventptr[FACT];
		$eventtype = strtoupper($prefix . "_" . $event . "_" . $description);

		if( !$custevents[$eventtype] ) {
			//if not in	custevents array, add to eventtypes_table with keep=ignore
			$keep = $allevents ? 1 : 0;
			$query = "INSERT IGNORE INTO $eventtypes_table (tag, description, display, keep, type)  VALUES(\"$event\", \"$description\", \"$display\", $keep, \"$prefix\")";
			$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
			$custevents[$eventtype][eventtypeID] = mysql_insert_id();
		}
		
		//save the event
		if( isset($custevents[$eventtype]) && $custevents[$eventtype][keep] ) {
			$eventtypeID = $custevents[$eventtype][eventtypeID];
			//always insert, never update in this case
   			if( !$eventptr[DATETR] ) $eventptr[DATETR] = "0000-00-00";

			preg_match( "/^@(\S+)@/", $eventinfo, $matches );
			if($matches[1]) $eventinfo = "@" . adjustId($matches[1],$savestate['noffset']) . "@";
			$query = "INSERT INTO $events_table (eventtypeID, persfamID, eventdate, eventdatetr, eventplace, age, agency, cause, addressID, parenttag, info, gedcom)  VALUES(\"$eventtypeID\", \"$persfamID\", \"" . $eventptr[DATE] . "\", \"" . $eventptr[DATETR] . "\", \"" . $eventptr[PLAC] . "\", \"" . $eventptr[AGE] . "\", \"" . $eventptr[AGNC] . "\", \"" . $eventptr[CAUS] . "\", \"" . $eventptr[ADDR] . "\",  \"" . $eventptr[parent] . "\", \"$eventinfo\", \"$tree\")";
			$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
			$eventID = mysql_insert_id();

			if($num_medialinks) {
				$key = $persfamID . "::" . $eventtypeID . "::" . $eventptr[DATE] . "::" . substr($eventptr[PLAC],0,40) . "::" . substr($eventinfo,0,40);
				$key = ereg_replace("[^A-Za-z0-9:]","",$key);
				if(isset($medialinks[$key])) {
					foreach($medialinks[$key] as $medialinkID) {
						//remove xxx event record
						//$value = $eventlinks[$medialinkID];
						//$query = "DELETE FROM $events_table WHERE eventID = \"$value\"";
						//$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");

						//put new eventID in old medialink records for this event
						$query = "UPDATE $medialinks_table SET eventID = \"$eventID\" WHERE medialinkID = \"$medialinkID\"";
						$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
					}
					unset($medialinks[$key]);
				}
			}
				
			if( isset( $eventptr[SOUR] ) ) 
				processCitations( $persfamID, $eventID, $eventptr[SOUR] );
			if( isset( $eventptr[NOTES] ) ) 
				processNotes( $persfamID, $eventID, $eventptr[NOTES] );
		}
		//save media, if any
		if( is_array($eventptr[MEDIA]) ) {
			$mminfo = $eventptr[MEDIA];
			foreach( $mminfo as $m )
				$m[linktype] = $prefix;
			processMedia( count($mminfo), $mminfo, $persfamID, $eventID );
		}
	}
}

function removeDelims( $fact ) {
	preg_match( "/(.*)\s*\/(.*)\/\s*(.*)/", $fact, $matches );
	if( count( $matches ) && substr($fact,0,1) != '<' && substr($fact,0,4) != "http")
		$fact = trim( $matches[1] . " " . $matches[2] . " " . $matches[3] );
	
	return $fact;
}
?>
