<?php
$nodate_all = "0000-00-00";
$eventctr_all = 1;

function getBirthInfo( $thisperson ) {
	global $text, $placesearch_url, $cms;

	$birthstring = "";
	$icon = "<img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\" />";
	if( $thisperson['birthdate'] ) {
		$birthstring .= ", &nbsp; $text[birthabbr] " . displayDate( $thisperson['birthdate'] );
		if( $thisperson['birthplace'] )
			$birthstring .= ", $thisperson[birthplace] <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=" . urlencode($thisperson['birthplace']) . "\" title=\"$text[findplaces]\">$icon</a>";
	}
	else if( $thisperson['altbirthdate'] ) {
		$birthstring .= ", &nbsp; $text[chrabbr] " . displayDate( $thisperson['altbirthdate'] );
		if( $thisperson['altbirthplace'] )
			$birthstring .= ", $thisperson[altbirthplace] <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=" . urlencode($thisperson['altbirthplace']) . "\" title=\"$text[findplaces]\">$icon</a>";
	}
	if( $thisperson['deathdate'] ) {
		$birthstring .= ", &nbsp; $text[deathabbr] " . displayDate( $thisperson['deathdate'] );
		if( $thisperson['deathplace'] )
			$birthstring .= ", $thisperson[deathplace] <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=" . urlencode($thisperson['deathplace']) . "\" title=\"$text[findplaces]\">$icon</a>";
	}
	else if( $thisperson['burialdate'] ) {
		$birthstring .= ", &nbsp; $text[burialabbr] " . displayDate( $thisperson['burialdate'] );
		if( $thisperson['burialplace'] )
			$birthstring .= ", $thisperson[burialplace] <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=" . urlencode($thisperson['burialplace']) . "\" title=\"$text[findplaces]\">$icon</a>";
	}
	return $birthstring;
}

function getCitations( $persfamID ) {
	global $sources_table, $text, $tree, $citations_table, $citations, $citationsctr, $citedisplay, $cms, $showsource_url;

	$citquery = "SELECT citationID, title, shorttitle, author, other, publisher, callnum, page, quay, citedate, citetext, $citations_table.note as note, $citations_table.sourceID, description, eventID
		FROM $citations_table LEFT JOIN $sources_table on $citations_table.sourceID = $sources_table.sourceID AND $sources_table.gedcom = $citations_table.gedcom
		WHERE persfamID = \"$persfamID\" AND $citations_table.gedcom = \"$tree\" ORDER BY citationID";
	$citresult = mysql_query($citquery) or die ("$text[cannotexecutequery]: $citquery");

	while( $citrow = mysql_fetch_assoc($citresult) ) {
		$source = $citrow[sourceID] ? "[<a href=\"$showsource_url" . "sourceID=$citrow[sourceID]&amp;tree=$tree\">$citrow[sourceID]</a>] " : "";
		$newstring = $source ? "" : $citrow[description];
		$key = $persfamID . "_" . $citrow[eventID];
		$citationsctr++;
		$citations[$key] .= $citations[$key] ? ",$citationsctr" : $citationsctr;

		if( $citrow[shorttitle] ) {
			if( $newstring ) $newstring .= ", ";
			$newstring .= $citrow[shorttitle];
		}
		else if( $citrow[title] ) {
			if( $newstring ) $newstring .= ", ";
			$newstring .= $citrow[title];
		}
		if( $citrow[author] ) {
			if( $newstring ) $newstring .= ", ";
			$newstring .= $citrow[author];
		}
		if( $citrow[publisher] ) {
			if( $newstring ) $newstring .= ", ";
			$newstring .= "($citrow[publisher])";
		}
		if( $citrow[callnum] ) {
			if( $newstring ) $newstring .= ", ";
			$newstring .= "$citrow[callnum].";
		}
		if( $citrow[other] ) {
			if( $newstring ) $newstring .= ", ";
			$newstring .= $citrow[other];
		}
		if( $citrow[page] ) {
			if( $newstring ) $newstring .= ", ";
			$newstring .= nl2br(insertLinks($citrow[page]));
		}
		if( $citrow[quay] != "" ) {
			if( $newstring ) $newstring .= " ";
			$newstring .= "($text[reliability]: $citrow[quay])";
		}
		if( $citrow[citedate] ) {
			if( $newstring ) $newstring .= ", ";
			$newstring .= $citrow[citedate];
		}
		if($newstring) $newstring .= ".";
		if( $citrow[citetext] ) {
			if( $newstring ) $newstring .= "<br/>\n";
			$newstring .= nl2br($citrow[citetext]);
		}
		if( $citrow[note] ) {
			if( $newstring ) $newstring .= "<br/>\n";
			$newstring .= nl2br($citrow[note]);
		}
		$citedisplay[$citationsctr] = "$source $newstring";
	}
	mysql_free_result($citresult);
}

function reorderCitation( $citekey ) {
	global $citedispctr, $citestring, $citations, $citedisplay;

	$newstring = "";
	$newcitearr = array();
	if( $citations[$citekey] ) {
		$citationlist = explode( ',', $citations[$citekey] );
		foreach( $citationlist as $citation ) {
			$newcite = "$citedisplay[$citation]";
			if( function_exists( 'array_search' ) )
				$newcitecnt = array_search( $newcite, $citestring );
			else
				$newcitecnt = 0;
			if( !$newcitecnt ) {
				$citedispctr++;
				$newcitecnt = $citedispctr;
				$arridx = count( $citestring ) + 1;
				$citestring[$arridx] = $newcite;
			}
			array_push( $newcitearr, $newcitecnt );
		}
		$citations[$citekey] = "";
	}
	$newcitearr = array_unique( $newcitearr );
	asort( $newcitearr );
	foreach( $newcitearr as $newcite ) {
		$newstring .= $newstring ? ", " : "";
		$newstring .= "<a href=\"#cite$newcite\" onclick=\"document.getElementById('citations').style.display = '';\">$newcite</a>";
	}
	return $newstring;
}

function getNotes( $persfamID, $flag ) {
	global $notelinks_table, $xnotes_table, $tree, $eventtypes_table, $events_table, $text, $eventswithnotes;

	$custnotes = array();
	$gennotes = array();
	$precustnotes = array();
	$postcustnotes = array();
	$finalnotesarray = array();

	if( $flag == "I" ) {
		$precusttitles = array( "BIRT"=>$text[born], "CHR"=>$text[christened], "NAME"=>$text[name], "TITL"=>$text[title], "NPFX"=>$text[prefix], "NSFX"=>$text[suffix], "NICK"=>$text[nickname], "BAPL"=>$text[baptizedlds], "ENDL"=>$text[endowedlds] );
		$postcusttitles = array( "DEAT"=>$text[died], "BURI"=>$text[buried], "SLGC"=>$text[sealedplds] );
	}
	elseif( $flag == "F" ) {
		$precusttitles = array( "MARR"=>$text[married], "SLGS"=>$text[sealedslds], "DIV"=>$text[divorced] );
		$postcusttitles = array();
	}
	else {
		$precusttitles = array( "ABBR"=>$text[shorttitle], "CALN"=>$text[callnum], "AUTH"=>$text[author], "PUBL"=>$text[publisher], "TITL"=>$text[title] );
		$postcusttitles = array();
	}

	$query = "SELECT display, $xnotes_table.note as note, $notelinks_table.eventID as eventID, $notelinks_table.xnoteID as xnoteID, $notelinks_table.ID as ID, noteID FROM $notelinks_table
		LEFT JOIN  $xnotes_table on $notelinks_table.xnoteID = $xnotes_table.ID AND $notelinks_table.gedcom = $xnotes_table.gedcom
		LEFT JOIN $events_table ON $notelinks_table.eventID = $events_table.eventID
		LEFT JOIN $eventtypes_table on $eventtypes_table.eventtypeID = $events_table.eventtypeID
		WHERE $notelinks_table.persfamID=\"$persfamID\" AND $notelinks_table.gedcom=\"$tree\" AND secret!=\"1\"
		ORDER BY ordernum, tag, eventdatetr, $notelinks_table.ID";
	$notelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

	$currevent = "";
	$currsig = "";
	$type = 0;
	while( $note = mysql_fetch_assoc( $notelinks ) ) {
		if( $note['noteID'] )
			getCitations( $note['noteID'] );
		//else
			//getCitations( $note['ID'] );
		if( !$note['eventID'] ) $note['eventID'] = "--x-general-x--";
		$signature = $note['eventID'] . "_" . $note['xnoteID'];
		if( $signature != $currsig ) {
			$currsig = $signature;
			$currevent = $note['eventID'];
			$currtitle = "";
		}
		if( !$currtitle ) {
			if( $note[display] ) {
				$currtitle = getEventDisplay( $note[display] );
				$key = "$currsig";
				$custnotes[$key] = array( "title"=>$currtitle, "text"=>"");
				$type = 2;
			}
			else {
				if( $postcusttitles[$currevent] ) {
					$currtitle = $postcusttitles[$currevent];
					$postcustnotes[$currsig] = array( "title"=>$postcusttitles[$currevent], "text"=>"");
					$type = 3;
				}
				else {
					$currtitle = $precusttitles[$currevent] ? $precusttitles[$currevent] : " ";
					if( substr($note[eventID],0,15) == "--x-general-x--" ) {
						$gennotes[$currsig] = array( "title"=>$precusttitles[$currevent], "text"=>"");
						$type = 0;
					}
					else {
						$precustnotes[$currsig] = array( "title"=>$precusttitles[$currevent], "text"=>"");
						$type = 1;
					}
				}
			}
		}
		switch( $type ) {
			case 0:
				if( $gennotes[$currsig][text] ) $gennotes[$currsig][text] .= "</li>\n";
				$gennotes[$currsig][text] .= "<li>" . nl2br($note[note]);
				$gennotes[$currsig][cite] .= "N$note[ID]";
				$gennotes[$currsig][xnote] .= $note[noteID];
				break;
			case 1:
				if( $precustnotes[$currsig][text] ) $precustnotes[$currsig][text] .= "</li>\n";
				$precustnotes[$currsig][text] .= "<li>" . nl2br($note[note]);
				$precustnotes[$currsig][cite] .= "N$note[ID]";
				$precustnotes[$currsig][xnote] .= $note[noteID];
				break;
			case 2:
				if( $custnotes[$key][text] ) $custnotes[$key][text] .= "</li>\n";
				$custnotes[$key][text] .= "<li>" . nl2br($note[note]);
				$custnotes[$key][cite] .= "N$note[ID]";
				$custnotes[$key][xnote] .= $note[noteID];
				break;
			case 3:
				if( $postcustnotes[$currsig][text] ) $postcustnotes[$currsig][text] .= "</li>\n";
				$postcustnotes[$currsig][text] .= "<li>" . nl2br($note[note]);
				$postcustnotes[$currsig][cite] .= "N$note[ID]";
				$postcustnotes[$currsig][xnote] .= $note[noteID];
				break;
		}
	}
	$finalnotesarray = array_merge( $gennotes, $precustnotes, $custnotes, $postcustnotes );	
	mysql_free_result($notelinks);

	return $finalnotesarray;
}

function buildNotes( $notearray, $entity ) {
	$notes = "";
	$lasttitle = "---";
	foreach( $notearray as $key => $note ) {
		if( $note[title] != $lasttitle ) {
			if( $notes )
				$notes .= "</ul>\n<br/>\n";
			if( $note[title] )
				$notes .= "<a name=\"$key\"><span class=\"normal\">$note[title]:</span></a><br/>\n";
		}
		$cite = reorderCitation( $entity . "_" . $note[cite] );
		if( $note[xnote] ) {
			$cite2 = reorderCitation( $note[xnote] . "_" );
			$cite = $cite && $cite2 ? $cite . "," . $cite2 : $cite . $cite2;
		}
		if( $cite ) $cite = " [$cite]";
		if( $note[title] != $lasttitle ) {
   			$notes .= "<ul class=\"normal\">\n";
			$lasttitle = $note[title];
		}
		$notes .= $note[text] . "$cite</li>\n";
	}
	if( $notes )
		$notes .= "</ul>\n";
	return insertLinks($notes);
}

function buildGenNotes( $notearray, $entity, $eventlist ) {
	$notes = "";
	$lasttitle = "---";
	if( is_array( $notearray ) ) {
		$events = explode(",",$eventlist);
		$eventctr = 0;
		foreach( $events as $event ) {
			$eventlen = strlen( $event );
			foreach( $notearray as $key => $note ) {
				if( substr($key,0,$eventlen) == $event ) {
					if( $note[title] != $lasttitle && $eventctr ) {
						if( $notes )
							$notes .= "</ul>\n<br/>\n";
						if( $note[title] )
							$notes .= "<a name=\"$key\"><span class=\"normal\">$note[title]:</span></a><br/>\n";
					}
					$cite = reorderCitation( $entity . "_" . $note[cite] );
					if( $note[xnote] ) {
						$cite2 = reorderCitation( $note[xnote] . "_" );
						$cite = $cite && $cite2 ? $cite . "," . $cite2 : $cite . $cite2;
					}
					if( $cite ) $cite = " [$cite]";
					if( $note[title] != $lasttitle ) {
			   			$notes .= "<ul class=\"normal\">\n";
						$lasttitle = $note[title];
					}
					$notes .= $note[text] . "$cite</li>\n";
				}
			}
			$eventctr++;
		}
		if( $notes )
			$notes .= "</ul>\n";
	}
	return insertLinks($notes);
}

function checkXnote( $fact ) {
	global $xnotes_table, $tree;

	$newfact = array();
	preg_match( "/^@(\S+)@/", $fact, $matches );
	if( $matches[1] ) {
		$query = "SELECT note, ID from $xnotes_table WHERE noteID = \"$matches[1]\" AND gedcom=\"$tree\"";
		$xnoteres = @mysql_query( $query );
		if( $xnoteres ) {
			$xnote = mysql_fetch_assoc( $xnoteres );
			$newfact[0] = trim( $xnote[note] );
			$newfact[1] = $matches[1];
			getCitations( $matches[1] );
		}
		mysql_free_result($xnoteres);
	}
	else
		$newfact[0] = $fact;
	return $newfact;
}

function strpos_array($notes, $needle){
  while (($pos = strpos($haystack, $needle, $pos)) !== FALSE)
  	$array[] = $pos++;
  return $array;
}

function resetEvents() {
	global $eventctr, $events, $nodate;

	$events = array();
	$nodate = "0000-00-00";
	$eventctr = 1;
}

function setEvent( $data, $datetr ) {
	global $eventctr, $events, $nodate, $map, $eventctr_all, $nodate_all;

	//make a copy of datetr
	$datetr_all = $datetr;
	if( $datetr_all == "0000-00-00" )
		$datetr_all = $nodate_all;
	elseif( $datetr_all > $nodate_all )
		$nodate_all = $datetr_all;
	$index_all = $datetr_all . sprintf( "%03d", $eventctr_all );
	$eventctr_all++;

	if( $datetr == "0000-00-00" )
		$datetr = $nodate;
	elseif( $datetr > $nodate )
		$nodate = $datetr;
	$index = $datetr . sprintf( "%03d", $eventctr );
	$events[$index] = $data;
	$eventctr++;

	if( $map['key'] && $data['place'] && !$data['nomap'] ) {
		global $locations2map, $l2mCount, $places_table, $tree, $pinplacelevel0, $pinplacelevel1, $pinplacelevel2, $pinplacelevel3, $pinplacelevel4, $pinplacelevel5, $pinplacelevel6;

		$safeplace = mysql_escape_string($data[place]);
		$query = "SELECT place,placelevel,latitude,longitude,zoom
			FROM $places_table WHERE gedcom ='$tree' AND $places_table.place = '$safeplace' and (latitude is not null and latitude != '') and (longitude is not null and longitude != '')";
		$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

		$numrows = mysql_num_rows( $custevents );
		if($numrows) {
			$fixedplace = htmlspecialchars($safeplace, ENT_QUOTES);
			$custevent = mysql_fetch_assoc( $custevents );
			$info = $data[fact];
			$pinplacelevel = $custevent[placelevel] ? ${"pinplacelevel" . $custevent[placelevel]} : $pinplacelevel0;
			//using $index above will ensure that this array gets sorted in the same order as the events on the page
			$locations2map[$l2mCount] = array($index_all,"placelevel"=>$custevent[placelevel],"pinplacelevel"=>$pinplacelevel,"event"=>$data[text],"htmlcontent"=>"","lat"=>$custevent[latitude],"long"=>$custevent[longitude],"zoom"=>$custevent[zoom],"place"=>$custevent[place],"eventdate"=>$data[date],"description"=>$info[0],"fixedplace"=>$fixedplace);
			$l2mCount++;
		}
		mysql_free_result($custevents);
	}
}

function showEvent( $data ) {
	global $citations, $notestogether, $text, $tree, $entity, $tentedit_url;
	global $tableid, $cellnumber, $cms, $placesearch_url, $tentative_edit;
	global $indnotes, $famnotes, $srcnotes, $reponotes, $indmedia, $fammedia, $srcmedia, $repomedia;

	switch( $data[type] ) {
		case "I":
			$notearray = $indnotes;
			$media = $indmedia;
			break;
		case "F":
			$notearray = $famnotes;
			$media = $fammedia;
			break;
		case "S":
			$notearray = $srcnotes;
			$media = $srcmedia;
			break;
		case "R":
			$notearray = $reponotes;
			$media = $repomedia;
			break;
	}
	$dateplace = $data[date] || $data[place] ? 1 : 0;
   	$notes = $notestogether && $data[event] ? buildGenNotes($notearray, $data[entity], $data[event]) : "";
	$rows = $dateplace;
	if( $tableid && !$cellnumber && ( $dateplace || $data[fact] || $notes ) ) {
		$cellid = " id=\"$tableid" . "1\"";
		$cellnumber++;
	}
	else
		$cellid = "";

	if( $data[fact] )
		$rows += is_array( $data[fact] ) ? count( $data[fact] ) : 1;
	$output = "";
	$cite = $data[entity] ? reorderCitation( $data[entity] . "_" . $data[event] ) : "";

	if( $dateplace ) {
		if( $data[date] ) {
			$output .= "<td valign=\"top\" class=\"databack\" style=\"white-space:nowrap\"";
			if( !$data[place] )
				$output .= " colspan='2'";
			$output .= "><span class=\"normal\">" . displayDate( $data[date] );
			if( !$data[place] && $cite ) {
				$output .= "&nbsp; [$cite]";
				$cite = "";
			}
			$output .= "&nbsp;</span></td>\n";
		}
		if( $data[place] ) {
			$output .= "<td valign=\"top\" width=\"80%\" class=\"databack\"";
			if( $cite ) $cite = "&nbsp; [$cite]";
			if( !$data[date] )
				$output .= " colspan='2'";
			$output .= "><span class=\"normal\">$data[place]";
			if( !isset($data[np]) )
				$output .= " <a href=\"$placesearch_url" . "psearch=" . urlencode($data[place]) . "\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\" /></a>$cite&nbsp;</span></td>\n";
			else
				$output .= "</span></td>\n";
			$cite = "";
		}
		$output .= "</tr>\n";
	}
	elseif( !$data[fact] && $cite ) {
		$data[fact] = $text[yesabbr];
		$rows++;
	}
	if( $data[fact] ) {
		$cite .= $data[xnote] ? reorderCitation( $data[xnote] . "_" ) : "";
		if( is_array( $data[fact] ) ) {
			for( $i = 0; $i < count( $data[fact] ); $i++ ) {
				if( $output ) $output .= "<tr>\n";
				if( $cite ) $cite = "&nbsp; [$cite]";
				$output .= "<td valign=\"top\" colspan=\"2\" width=\"90%\" class=\"databack\"><span class=\"normal\">" . nl2br( insertLinks($data[fact][$i]) ) . "$cite&nbsp;</span></td></tr>\n";
				$cite = "";
			}
		}
		else {
			if( $output ) $output .= "<tr>\n";
			if( strpos( $data[fact], "http" ) === FALSE && strpos( $data[fact], "www" ) === FALSE ) {
				preg_match( "/(.*)\s*\/(.*)\/$/", $data[fact], $matches );
				$count = count( $matches );
				if( $count ) {
					$newfact = "";
					for( $i = 1; $i <= $count; $i++ ) {
						if( $newfact ) $newfact .= " ";
						$newfact .= addslashes( $matches[$i] );
					}
					$data[fact] = $newfact;
				}
			}
			if( $cite ) $cite = "&nbsp; [$cite]";
			$output .= "<td valign=\"top\" colspan=\"2\" width=\"90%\" class=\"databack\"><span class=\"normal\">" . nl2br( insertLinks($data[fact]) ) . "$cite&nbsp;</span></td></tr>\n";
		$cite = "";
		}
	}
	if( $notestogether ) {
		if( $notes ) {
			$rows++;
			if( $output ) $output .= "<tr>\n";
			$output .= "<td valign=\"top\" colspan=\"2\" class=\"databack\"><span class=\"normal\">$notes</span></td>\n";
			$output .= "</tr>\n";
		}
	}
	$event = $data[event];
	if( isset($media[$event]) ) {
		$mediaoutput = "";
		$thumbcount = 0;
		foreach( $media[$event] as $item ) {
			$rows++;
			if( $output ) $mediaoutput .= "<tr>\n";
			if( $item[imgsrc] ) {
				$mediaoutput .= "<td valign=\"top\" class=\"databack\" align=\"center\">$item[imgsrc]</td>\n";
				$thumbcount++;
			}
			else
				$mediaoutput .= "<td valign=\"top\" class=\"databack\">&nbsp;</td>";
			$mediaoutput .= "<td valign=\"top\" class=\"databack\" width=\"80%\"><span class=\"normal\">$item[description]<br />" . nl2br($item[notes]) . "</span></td>\n";
			$mediaoutput .= "</tr>\n";
		}
		if( !$thumbcount )
			$mediaoutput = ereg_replace( "<td valign=\"top\" class=\"databack\">&nbsp;</td><td valign=\"top\" class=\"databack\" width=\"80%\">", "<td valign=\"top\" class=\"databack\" colspan=\"2\">", $mediaoutput );
		$output .= $mediaoutput;
	}
	if( $output ) {
		$editicon = $tentative_edit && $data[event] ? "<img src=\"$cms[tngpath]tng_edit.gif\" width=\"16\" height=\"15\" border=\"0\" alt=\"$text[editevent]\" align=\"absmiddle\" onclick=\"tnglitbox = new LITBox('$tentedit_url" . "tree=$tree&amp;persfamID=$data[entity]&amp;type=$data[type]&amp;event=$data[event]&amp;title=$data[text]',{width:500,height:500});\" style=\"cursor:pointer\" />" : "";
		$class = $cellid ? " indleftcol" : "";
		$rowspan = $rows > 1 ? " rowspan=\"$rows\"" : "";
		$preoutput = "<tr>\n<td valign=\"top\" class=\"fieldnameback$class\" style=\"white-space:nowrap\" $rowspan$cellid><span class=\"fieldname\">$data[text]&nbsp;$editicon</span></td>\n";
		$final = $preoutput . $output;
	}
	else
		$final = "";

	return $final;
}

function showBreak( ) {
	return "<tr><td height=\"3\" colspan=\"3\"><font size=\"1\">&nbsp;</font></td></tr>\n";
}

function doCustomEvents($entityID,$type,$nomap = 0) {
	global $events_table, $eventtypes_table, $text, $tree;

	$query = "SELECT display, eventdate, eventdatetr, eventplace, age, agency, cause, addressID, info, tag, description, eventID FROM ($events_table, $eventtypes_table) WHERE persfamID = \"$entityID\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND gedcom = \"$tree\" AND keep = \"1\" AND parenttag = \"\" ORDER BY ordernum, tag, description, eventdatetr, info, eventID";
	$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	while ( $custevent = mysql_fetch_assoc( $custevents ) )	{
		$displayval = getEventDisplay( $custevent[display] );
		$eventID = $custevent[eventID];
		$key = "cust$eventID";
		$fact = array();
		if( $custevent[info] ) {
			$fact = checkXnote( $custevent[info] );
			if( $fact[1] ) {
				$xnote = $fact[1];
				array_pop( $fact );
			}
		}
		$extras = getFact( $custevent );
		$fact = ( count( $fact ) && $fact[0] != "" ) ? array_merge( $fact, $extras ) : $extras;
		setEvent( array( "text"=>$displayval, "date"=>$custevent[eventdate], "place"=>$custevent[eventplace], "fact"=>$fact, "xnote"=>$xnote, "event"=>$eventID, "entity"=>$entityID, "type"=>$type, "nomap"=> $nomap ), $custevent[eventdatetr] );
	}
	mysql_free_result( $custevents );
}

function doAlbums($entity) {
	global $tableid, $cellnumber, $tree, $text, $nonames, $livedefault, $albums_table, $album2entities_table, $albumlinks_table, $showalbum_url, $thumbmaxw;

	$albumtext = "";

	$cellid = $tableid && !$cellnumber ? " id=\"$tableid" . "1\"" : "";
	
	$query = "SELECT $albums_table.albumID, albumname, description FROM ($albums_table,$album2entities_table) WHERE entityID=\"$entity\" AND $album2entities_table.albumID=$albums_table.albumID ORDER BY albumname";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$totalalbums = mysql_num_rows($result);

	if($totalalbums) {
		$albumtext .= "<tr>\n";
		$albumtext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\"$cellid rowspan=\"$totalalbums\"><span class=\"fieldname\">$text[albums]</span></td>\n";

		$cellnumber++;
		$thumbcount = 0;
		$albumcount = 0;

		while( $row = mysql_fetch_assoc( $result ) ) {
			//putting this count in the albums table would make this faster
			$query = "SELECT count($albumlinks_table.albumlinkID) as acount FROM $albumlinks_table WHERE albumID = \"$row[albumID]\"";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$arow = mysql_fetch_assoc( $result2 );
			mysql_free_result($result2);

			if( $albumcount ) $albumtext .= "<tr>";
			$imgsrc = getAlbumPhoto($row['albumID'],$row['albumname']);
			if($imgsrc) {
				$albumtext .= "<td valign=\"top\" class=\"databack\" align=\"center\" style=\"width:$thumbmaxw" . "px\">$imgsrc</td><td valign=\"top\" class=\"databack\">";
				$thumbcount++;
			}
			else
				$albumtext .= "<td valign=\"top\" class=\"databack\">&nbsp;</td><td valign=\"top\" class=\"databack\">";
			$albumtext .= "<span class=\"normal\"><a href=\"$showalbum_url" . "albumID=$row[albumID]\">$row[albumname]</a> ($arow[acount])<br />$row[description]<br/>$notes&nbsp;</span></td>\n";

			$albumtext .= "</tr>\n";
			$albumcount++;
		}
		if( !$thumbcount )
			$albumtext = ereg_replace( "<td valign=\"top\" class=\"databack\">&nbsp;</td><td valign=\"top\" class=\"databack\">", "<td valign=\"top\" class=\"databack\" colspan=\"2\">", $albumtext );
	}

	return $albumtext;
}

function doMediaSection($entity,$medialist) {
	global $mediatypes, $cellnumber;

	$media = $mediatext = "";
	$tableid = "media";
	$cellnumber = 0;
	foreach( $mediatypes as $mediatype ) {
		$mediatypeID = $mediatype['ID'];
		$newmedia = writeMedia( $medialist, $mediatypeID );
		if( $newmedia ) {
			$media .= $newmedia;
			$media .= showBreak();
		}
	}
	$albums = doAlbums($entity);
	if($albums) {
		$media .= $albums;
		$media .= "<tr><td height=\"3\" colspan=\"3\"><font size=\"1\">&nbsp;</font></td></tr>";
	}
	if( $media ) {
		$mediatext .= beginSection("media");
		$mediatext .= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" width=\"100%\">\n";
		$mediatext .= $media;
		$mediatext .= "</table>\n";
		$mediatext .= endSection("media");
	}
	return $mediatext;
}

function getMedia( $entity, $linktype ) {
	global $medialinks_table, $media_table, $tree, $text, $nonames;
	global $livedefault, $mediapath, $mediatypes_assoc, $maxnoteprev;

	$showmedia_url = getURL("showmedia",1);

	$media = array();
	//if mediatypeID, do it in media type sections, otherwise, do it all together
	switch( $linktype ) {
		case "I":
			$personID = $entity[personID];
			$always = $entity[allow_living] ? "" : "AND alwayson = \"1\"";
			break;
		case "F":
			$personID = $entity[familyID];
			$always = $entity[allow_living] ? "" : "AND alwayson = \"1\"";
			break;
		case "S":
			$personID = $entity[sourceID];
			$always = "";
			break;
		case "R":
			$personID = $entity[repoID];
			$always = "";
			break;
		case "L":
			$personID = $entity;
			$always = "";
			break;
	}

	$query = "SELECT medialinkID, description, notes, altdescription, altnotes, usecollfolder, mediatypeID, personID, $medialinks_table.mediaID as mediaID, thumbpath, status, eventID, alwayson, path, form, abspath, newwindow
		FROM ($medialinks_table, $media_table)
		WHERE $medialinks_table.personID=\"$personID\"
		AND $media_table.mediaID = $medialinks_table.mediaID";
	if( $tree )
		$query .= " AND $medialinks_table.gedcom = \"$tree\"";
	$query .= " $always	ORDER BY eventID, mediatypeID, ordernum";
	$medialinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

	while( $medialink = mysql_fetch_assoc( $medialinks ) ) {
		$href = $imgsrc = "";
		$thismedia = array();
		$eventID = $medialink[eventID] ? $medialink[eventID] : "-x--general--x-";
		$mediatypeID = $medialink[mediatypeID];
		$usefolder = $medialink['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
		$denied = !checkLivingLinks($medialink[mediaID], $medialink[alwayson]);
		if( $denied && $nonames ) {
			$thismedia[description] = $text[livingphoto];
			$thismedia[notes] = "";
		}
		else {
			$thismedia[description] = $medialink[altdescription] ? $medialink[altdescription] : $medialink[description];
			$thismedia[notes] = truncateIt(getXrefNotes(($medialink[altnotes] ? $medialink[altnotes] : $medialink[notes]),$tree),$maxnoteprev);
			if( $denied )
				$thismedia[notes] .= " ($text[livingphoto])";
			else {
				$thismedia[href] = getMediaHREF($medialink,1);
				$thismedia[description] = "<a href=\"$thismedia[href]\">$thismedia[description]</a>";
				$thismedia[imgsrc] = getSmallPhoto($medialink);
				if( $thismedia['imgsrc'] ) {
					$imgsrc = $thismedia['imgsrc'];
					$thismedia['imgsrc'] = "<div class=\"media-img\"><div class=\"media-prev\" id=\"prev$medialink[mediaID]_$personID\" style=\"display:none\"></div></div>\n";
					$thismedia['imgsrc'] .= "<a href=\"$thismedia[href]\"";
					if( function_exists( imageJpeg ) && isPhoto($medialink) )
						$thismedia['imgsrc'] .= " onmouseover=\"showPreview('$medialink[mediaID]','" . urlencode("$usefolder/$medialink[path]") . "','$personID');\" onmouseout=\"closePreview('$medialink[mediaID]','$personID');\" onclick=\"closePreview('$medialink[mediaID]','$personID');\"";
					$thismedia['imgsrc'] .= ">$imgsrc</a>";
				}
			}

			$status = $medialink[status];
			if( $medialink[status] ) $thismedia[notes] = "$text[status]: " . $text[$status] . ". $thismedia[notes]";
		}
		if( $medialink[eventID] ) {
			if( !isset($media[$eventID]) )
				$media[$eventID] = array();
			array_push($media[$eventID],$thismedia);
		}
		else {
			if( !isset($media[$eventID][$mediatypeID]) )
				$media[$eventID][$mediatypeID] = array();
			array_push($media[$eventID][$mediatypeID],$thismedia);
		}
	}
	mysql_free_result($medialinks);

	return $media;
}

function writeMedia( $media_array, $mediatypeID ) {
	global $tableid, $cellnumber, $text, $thumbmaxw, $mediatypes_display;

	$mediatext = "";
	$media = $media_array['-x--general--x-'][$mediatypeID];

	$cellid = $tableid && !$cellnumber ? " id=\"$tableid" . "1\"" : "";

	if( is_array( $media ) ) {
		$totalmedia = count($media);
		$mediacount = 0;

		if( $totalmedia ) {
			$titlemsg = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
			$mediatext .= "<tr>\n";
			$mediatext .= "<td valign=\"top\" class=\"fieldnameback indleftcol\"$cellid rowspan=\"$totalmedia\"><span class=\"fieldname\">$titlemsg</span></td>\n";

			$cellnumber++;
			$thumbcount = 0;

			foreach( $media as $item ) {
				if( $mediacount ) $mediatext .= "<tr>";
				if($item[imgsrc]) {
					$mediatext .= "<td valign=\"top\" class=\"databack\" align=\"center\" style=\"width:$thumbmaxw" . "px\">$item[imgsrc]</td><td valign=\"top\" class=\"databack\">";
					$thumbcount++;
				}
				else
					$mediatext .= "<td valign=\"top\" class=\"databack\">&nbsp;</td><td valign=\"top\" class=\"databack\">";
				$mediatext .= "<span class=\"normal\">$item[description]<br/>" . nl2br( $item[notes] ) . "</span></td></tr>\n";
				$mediacount++;
			}
			if( !$thumbcount )
				$mediatext = ereg_replace( "<td valign=\"top\" class=\"databack\">&nbsp;</td><td valign=\"top\" class=\"databack\">", "<td valign=\"top\" class=\"databack\" colspan=\"2\">", $mediatext );
		}
	}

	return $mediatext;
}

function getAlbumPhoto($albumID,$albumname) {
	global $assignedtree, $allow_living_db, $rootpath, $media_table, $albumlinks_table, $people_table, $families_table, $citations_table, $text, $medialinks_table;
	global $mediatypes_assoc, $mediapath, $showalbum_url;

	$wherestr2 = $tree ? " AND $medialinks_table.gedcom = \"$tree\"" : "";

	$query2 = "SELECT path, thumbpath, usecollfolder, mediatypeID, $albumlinks_table.mediaID as mediaID, alwayson FROM ($media_table, $albumlinks_table)
		WHERE albumID = \"$albumID\" AND $media_table.mediaID = $albumlinks_table.mediaID AND defphoto=\"1\"";
	$result2 = mysql_query($query2) or die ("$text[cannotexecutequery]: $query2");
	$trow = mysql_fetch_assoc( $result2 );
	$mediaID = $trow['mediaID'];
	$tmediatypeID = $trow['mediatypeID'];
	$tusefolder = $trow['usecollfolder'] ? $mediatypes_assoc[$tmediatypeID] : $mediapath;
	mysql_free_result($result2);

	$imgsrc = "";
	if( $trow['thumbpath'] && file_exists( "$rootpath$tusefolder/$trow[thumbpath]" ) ) {
		$noneliving = 1;
		if(!$trow['alwayson'] && $livedefault != 2) {
			$query = "SELECT people.living as living, people.branch as branch, $families_table.branch as fbranch, $families_table.living as fliving, linktype, $medialinks_table.gedcom as gedcom
				FROM $medialinks_table
				LEFT JOIN $people_table AS people ON $medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom
				LEFT JOIN $families_table ON $medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom
				WHERE mediaID = \"$mediaID\"$wherestr2";
			$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			while( $prow = mysql_fetch_assoc( $presult ) )
			{
				if( $prow['fbranch'] != NULL ) $prow['branch'] = $prow['fbranch'];
				if( $prow['fliving'] != NULL ) $prow['living'] = $prow['fliving'];
				//if living still null, must be a source
				if( $prow['living'] == NULL && $prow['linktype'] == 'I') {
					$query = "SELECT count(personID) as ccount FROM $citations_table, $people_table
						WHERE $citations_table.sourceID = '$prow[personID]' AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
						AND living = '1'";
					$presult2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
					$prow2 = mysql_fetch_assoc( $presult2 );
					if( $prow2[ccount] ) $prow[living] = 1;
					mysql_free_result( $presult2 );
				}
				elseif( $prow['living'] == NULL && $prow['linktype'] == 'F') {
					$query = "SELECT count(familyID) as ccount FROM $citations_table, $families_table
						WHERE $citations_table.sourceID = '$prow[personID]' AND $citations_table.persfamID = $families_table.familyID AND $citations_table.gedcom = $families_table.gedcom
						AND living = '1'";
					$presult2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
					$prow2 = mysql_fetch_assoc( $presult2 );
					if( $prow2[ccount] ) $prow[living] = 1;
					mysql_free_result( $presult2 );
				}
				if( !$prow['living'] || ($allow_living_db && ( !$assignedtree || $assignedtree == $prow['gedcom'] ) && checkbranch( $prow['branch'] ) ) )
					$prow['allow_living'] = 1;
				else {
					$noneliving = 0;
					continue;
				}
			}
		}
		if( $noneliving ) {
			$size = @GetImageSize( "$rootpath$tusefolder/$trow[thumbpath]" );
			$imgsrc = "<div class=\"media-img\"><div class=\"media-prev\" id=\"prev$albumID\" style=\"display:none\"></div></div>\n";
			$imgsrc .= "<a href=\"$showalbum_url" . "albumID=$albumID\" title=\"$text[albclicksee]\"";
			if(function_exists( imageJpeg ))
				$imgsrc .= " onmouseover=\"showPreview('$albumID','" . urlencode("$tusefolder/$trow[path]") . "','');\" onmouseout=\"closePreview('$albumID','');\" onclick=\"closePreview('$albumID','');\"";
			$imgsrc .= "><img src=\"$tusefolder/" . str_replace("%2F","/",rawurlencode( $trow['thumbpath'] )) . "\" border=\"0\" $size[3] alt=\"$albumname\" /></a>";
		}
	}
	return $imgsrc;
}

function getFact( $row ) {
	global $tree, $address_table, $text;

	$fact = array();
	$i = 0;
	if( $row[age] ) $fact[$i++] = "$text[age]: $row[age]";
	if( $row[agency] ) $fact[$i++] = "$text[agency]: $row[agency]";
	if( $row[cause] ) $fact[$i++] = "$text[cause]: $row[cause]";
	if( $row[addressID] ) {
		$fact[$i] = "$text[address]:";
		$query = "SELECT address1, address2, city, state, zip, country, www, email, phone FROM $address_table WHERE addressID = \"$row[addressID]\"";
		$addrresults = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$addr = mysql_fetch_assoc( $addrresults );
		if( $addr[address1] ) $fact[$i] .= "<br />$addr[address1]";
		if( $addr[address2] ) $fact[$i] .= "<br />$addr[address2]";
		if( $addr[city] ) $fact[$i] .= "<br />$addr[city]";
		if( $addr[state] ) {
			if( $addr[city] ) 
				$fact[$i] .= ", $addr[state]";
			else
				$fact[$i] .= "<br />$addr[state]";
		}
		if( $addr[zip] ) {
			if( $addr[city] || $addr[state] )
				$fact[$i] .= " $addr[zip]";
			else
				$fact[$i] .= "<br />$addr[zip]";
		}
		if( $addr['country'] ) $fact[$i] .= "<br />$addr[country]";
		if( $addr['phone'] ) $fact[$i] .= "<br />$addr[phone]";
		if( $addr['email'] ) $fact[$i] .= "<br /><a href=\"mailto:$addr[email]\">$addr[email]</a>";
		if( $addr['www'] ) {
			$link = strpos($addr['www'],"http") === 0 ? "http://" . $addr['www'] : $addr['www'];
			$fact[$i] .= "<br /><a href=\"$link\">$addr[www]</a>";
		}
	}
	return $fact;
}

function getStdExtras( $persfamID ) {
	global $tree, $events_table, $text;
	
	$stdex = array();
	$query = "SELECT age, agency, cause, addressID, parenttag FROM $events_table WHERE persfamID = \"$persfamID\" AND gedcom = \"$tree\" AND parenttag != \"\" ORDER BY parenttag";
	$stdextras = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	while ( $stdextra = mysql_fetch_assoc( $stdextras ) ) {
		$stdex[$stdextra[parenttag]] = getFact( $stdextra );
	}
	return $stdex;
}

function formatAssoc( $assoc ) {
	global $allow_living, $livedefault, $text, $tree, $people_table, $getperson_url;

	$assocstr = $namestr = "";

	$query = "SELECT firstname, lastname, lnprefix, prefix, suffix, nameorder, living, branch
		FROM $people_table WHERE personID = \"$assoc[passocID]\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

	$row = mysql_fetch_assoc($result);
	$rightbranch = checkbranch( $row['branch'] ) ? 1 : 0;
	$row['allow_living'] = !$row['living'] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$assocstr = getName( $row );
	mysql_free_result( $result );

	if( !$assocstr ) $assocstr = $assoc['passocID'];
	$assocstr = "<a href=\"$getperson_url" . "personID=$assoc[passocID]&amp;tree=$tree\">$assocstr</a>";
	$assocstr .= $assoc[relationship] ? " ($text[relationship2]: $assoc[relationship])" : "";

	return $assocstr;
}

function beginSection( $section ) {
	global $tableid, $cellnumber, $firstsection, $firstsectionsave, $tngconfig;

	$sectext = "";
	$tableid = $section;
	$cellnumber = 0;
	if( $firstsection ) {
		$firstsection = 0;
		$firstsectionsave = $section;
	}
	$sectext .= "<li id=\"$section\" style=\"list-style-type: none; ";
	if( $tngconfig[istart] && $section != "info" )
		$sectext .= "display:none;";
	$sectext .= "\">\n";
	
	return $sectext;
}

function endSection( $section ) {
	return "</li> <!-- end $section -->\n";
}
?>
