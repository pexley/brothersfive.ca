<?php
@ini_set( 'memory_limit' , '80M' );
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "trees";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

include($subroot . "importconfig.php");
require("adminlog.php");
include( "prefixes.php" );

$citations = array();

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[gedexport], $flags );

foreach( $mediatypes as $mediatype ) {
	$msgID = $mediatype[ID];
	eval("\$exppath[$msgID] = \$exp_path_$msgID;");
	if( $exppath[$msgID] ) {
		if (get_magic_quotes_gpc() )
			$exppath[$msgID] = stripslashes( $exppath[$msgID] );
		if(strpos( $exppath[$msgID], "/") !== false)
			$expdir[$msgID] = 1;
		elseif(strpos( $exppath[$msgID], "\\") !== false)
			$expdir[$msgID] = -1;
		else
			$expdir[$msgID] = 0;
		//1 = do forward slashes, -1 = backslashes
		if( substr( $exppath[$msgID], -1 ) != "/" && substr( $exppath[$msgID], -1 ) != "\\" )
			$exppath[$msgID] .= "/";
	}
}
?>
</head>

<body background="../background.gif">

<?php
	$datatabs[0] = array(1,"dataimport.php",$admtext[import],"import");
	$datatabs[1] = array(1,"export.php",$admtext[export],"export");
	$datatabs[2] = array(1,"secondmenu.php",$admtext[secondarymaint],"second");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/data_help.php#export', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($datatabs,"export",$innermenu);
	echo displayHeadline("$admtext[datamaint] &gt;&gt; $admtext[gedexport]","data_icon.gif",$menu,$message);
?>

<div class="lightback" style="padding:2px">
<div class="databack normal" style="padding:5px">

<?php
function getCitations( $persfamID ) {
	global $citations_table, $admtext, $tree;

	$citations = array();
	$citquery = "SELECT citationID, page, quay, citedate, citetext, note, sourceID, description, eventID FROM $citations_table WHERE persfamID = \"$persfamID\" AND gedcom = \"$tree\" ORDER BY eventID";
	$citresult = mysql_query($citquery) or die ("$admtext[cannotexecutequery]: $query");
	
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
	global $lineending;
	
	$levelplus1 = $level + 1;
	$citestr = "";
	
	$citecount = count( $citelist );
	if( $citecount ) {
		foreach( $citelist as $cite ) {
			if( $cite[sourceID] ) {
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
	global $tree, $address_table, $admtext, $lineending;

	$fact = "";
	if( $row[age] ) $fact .= "$level AGE $row[age]$lineending";
	if( $row[agency] ) $fact .= "$level AGNC $row[agency]$lineending";
	if( $row[cause] ) $fact .= "$level CAUS $row[cause]$lineending";
	if( $row[addressID] ) {
		$query = "SELECT address1, address2, city, state, zip, country, phone, email, www FROM $address_table WHERE addressID = \"$row[addressID]\" AND gedcom = \"$tree\"";
		$addrresults = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
	global $tree, $events_table, $admtext;
	
	$stdex = array();
	$query = "SELECT age, agency, cause, addressID, parenttag FROM $events_table WHERE persfamID = \"$persfamID\" AND gedcom = \"$tree\" AND parenttag != \"\" ORDER BY parenttag";
	$stdextras = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
	global $notelinks_table, $xnotes_table, $tree, $eventtypes_table, $admtext;
	
	$query = "SELECT $notelinks_table.ID as ID, $xnotes_table.note as note, $xnotes_table.noteID as noteID, $notelinks_table.eventID FROM $notelinks_table, $xnotes_table WHERE $notelinks_table.xnoteID = $xnotes_table.ID AND $notelinks_table.gedcom = $xnotes_table.gedcom AND $notelinks_table.persfamID=\"$id\" AND $notelinks_table.gedcom =\"$tree\" ORDER BY eventID";
	$notelinks = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
			while( substr( $orgnote, $offset, 1 ) == " " || substr( $orgnote, $offset - 1, 1 ) == " " ) {
				$offset--;
			}
			$note = substr( $note, 0, $offset );
			$newlevel = $level + 1;
			while( $offset < $notelen ) {
				$endnext = 245;
				while( substr( $orgnote, $offset + $endnext, 1 ) == " " || substr( $orgnote, $offset + $endnext - 1, 1 ) == " " ) {
					$endnext--;
				}
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
			while( substr( $orgnote, $offset, 1 ) == " " || substr( $orgnote, $offset - 1, 1 ) == " " ) {
				$offset--;
			}
			$note = substr( $note, 0, $offset );
			while( $offset < $notelen ) {
				$endnext = 245;
				while( substr( $orgnote, $offset + $endnext, 1 ) == " " || substr( $orgnote, $offset + $endnext - 1, 1 ) == " ")
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
	elseif( $notes )
		$noteinfo .= doNote( $level, $label, $notes );
	return $noteinfo;
}

function doXNotes( ) {
	global $xnotes_table, $tree, $admtext, $savestate, $lineending, $citations, $noteprefix;
	
	$xnotestr = "";
	$prefixlen = strlen( $noteprefix ) + 1;

	$query = "SELECT note, noteID, (0+SUBSTRING(noteID,$prefixlen)) as num FROM $xnotes_table WHERE gedcom =\"$tree\" AND noteID != \"\" $savestate[wherestr] ORDER BY num";
	$xnotearray = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $xnotetxt = mysql_fetch_assoc( $xnotearray ) ) {
		$xnotestr .= "0 @$xnotetxt[noteID]@ NOTE$lineending";

		$xnotestr .= doNote( 0, "NOTE", $xnotetxt['note'] );
		$citations = getCitations( $xnotetxt['noteID'] );
		$xnotestr .= writeCitation( $citations['NAME'], $level + 2 );

		//$notes = split ( chr(10), $xnotetxt[note] );
		//foreach ( $notes as $note )
			//$xnotestr .= "1 CONT $note$lineending";

		$savestate[ncount]++;
		if( $saveimport ) {
			$savestate[offset] = ftell($fp);
			$query = "UPDATE $saveimport_table SET offset=$savestate[offset], lasttype=$savestate[lasttype], lastid=\"$xnotetxt[noteID]\", ncount=\"$savestate[ncount]\" WHERE gedcom = \"$tree\"";
			$saveresult = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		}
		if( $savestate[ncount] % 10 == 0 ) {
			echo "<strong>N$savestate[ncount]</strong> ";
		}
	}
	mysql_free_result( $xnotearray );

	return $xnotestr;
}

function getMediaLinks( $id ) {
	global $tree, $admtext, $exportmedia, $media_table, $medialinks_table;
	global $expdir, $exppath, $lineending;

	$allmedia = array();
	if( $exportmedia ) {
		$query = "SELECT notes, altnotes, description, altdescription, path, mediatypeID, eventID, form, abspath FROM ($media_table, $medialinks_table) WHERE $medialinks_table.gedcom =\"$tree\" AND $medialinks_table.personID=\"$id\" AND $media_table.mediaID = $medialinks_table.mediaID ORDER BY eventID, ordernum";
		$media = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		while( $prow = mysql_fetch_assoc( $media ) ) {
			$eventID = $prow[eventID] ? $prow[eventID] : "-x--general--x-";
			if($prow['abspath']) {
				preg_match( "/\.(.+)$/", $prow['path'], $matches );
				$prow['form'] = $matches[1];
			}
			else {
				$mediatypeID = $prow['mediatypeID'];
				$thisexppath = $exppath[$mediatypeID];
				$thisexpdir = $expdir[$mediatypeID];
				//$linktxt .= "1 OBJE$lineending";
				if( !$prow['form'] ) {
					preg_match( "/\.(.+)$/", $prow['path'], $matches );
					$prow['form'] = $matches[1];
				}

				//strip $prow[path] down to just the file name
				//$filename = basename( $prow[path] );
				if(!$thisexpdir && strpos( $prow['path'], "/" )) $thisexpdir = 1;
				$prow['path'] = $thisexpdir == 1 ? str_replace("\\","/","$thisexppath$prow[path]") : str_replace("/","\\","$thisexppath$prow[path]");
			}
			$prow['title'] = $prow['altdescription'] ? $prow['altdescription'] : $prow['description'];

			$prow['notes'] = $prow['altnotes'] ? $prow['altnotes'] : $prow['notes'];
			if( !is_array($allmedia[$eventID]) )
				$allmedia[$eventID] = array();
			array_push($allmedia[$eventID],$prow);
		}
		mysql_free_result( $media );
	}

	return $allmedia;
}

function writeMediaLinks( $media_array, $level ) {
	global $lineending;
	
	$linktxt = "";
	$newlevel = $level + 1;
	foreach( $media_array as $media ) {
		if($media['form']) {
			$linktxt .= "$level OBJE$lineending";
			$linktxt .= "$newlevel FORM $media[form]$lineending";
			$linktxt .= "$newlevel FILE $media[path]$lineending";
			$linktxt .= "$newlevel TITL $media[title]$lineending";
			$type = strtoupper($media[mediatypeID]);
			if(substr($type,-1) == "S")
				$type = substr($type,0,-1);
			if($type == "HISTORIE") $type = "HISTORY";
			$linktxt .= "$newlevel _TYPE $type$lineending";
			$linktxt .= writeNote( $newlevel, "NOTE", $media['notes'] );
		}
	}
	return $linktxt;
}

function appendParents( $child ) {
	global $allow_lds, $allow_living, $livedefault, $lineending;
	
	$info = "1 FAMC @$child[familyID]@$lineending";
	if( !$child[living] || $livedefault == 2 || ( $allow_living && checkbranch( $child['branch'] ) ) ) {
		if( $child[relationship] ) $info .= "2 PEDI $child[relationship]$lineending";
		if( $allow_lds ) {
			if( $child['sealdate'] || $child['sealplace'] ) {
				$childnotes = getNotes( $child['personID'] );
				$citations = getCitations( $child['personID'] . $child['familyID'] );
	
				$info .= "1 SLGC$lineending";
				$info .= "2 FAMC @$child[familyID]@$lineending";
				if( $child['sealdate'] ) { $info .= "2 DATE $child[sealdate]$lineending"; }
				if( $child['sealplace'] ) {
					$tok = strtok ($child['sealplace']," ");
					if( strlen( $tok ) == 5 ) {
						$info .= "2 TEMP $tok$lineending"; 
						$tok = strtok( " " );
						if( $tok )
							$info .= "2 PLAC $tok$lineending"; 
					}
					else
						$info .= "2 PLAC $child[sealplace]$lineending";
				}
				if( $childnotes['SLGC'] )
					$info .= writeNote( 2, "NOTE", $childnotes['SLGC'] );
				if( $citations['SLGC'] ) {
					$info .= writeCitation( $citations['SLGC'], 2 );
				}
			}
		}
	}
	
	return $info;
}

function getEligibility( $ind ) {
	$rval = 0;

   	$birthdate = $ind[birthdatetr] != "0000-00-00" ? $ind[birthdatetr] : $ind[altbirthdatetr];
	$birthplace = $ind[birthplace] ? $ind[birthplace] : $ind[altbirthplace];
	if($birthplace && $birthdate > "1500-00-00") {
   		$deathdate = $ind[deathdatetr] != "0000-00-00" ? $ind[deathdatetr] : $ind[burialdatetr];
		if($deathdate != "0000-00-00") {
		   	$deathinfo = split("-",$deathdate);
			$deathyeardiff = date("Y") - $deathinfo[0];
			if( $deathyeardiff > 1 || ($deathyeardiff && (date("m") > $deathinfo[1] || (date("m") == $deathinfo[1] && date("d") > $deathinfo[2]))))
				$rval = 1;
		}
		else {
   			$birthinfo = split("-",$birthdate);
   			$birthyeardiff = date("Y") - $birthinfo[0];
			if( $birthyeardiff > 110 || ($birthyeardiff == 110 && (date("m") > $birthinfo[1] || (date("m") == $birthinfo[1] && date("d") > $birthinfo[2]))))
				$rval = 1;
		}
	}

	return $rval;
}

function doNotesAndMedia( $notes, $media, $tag, $level ) {
	$rval = "";
	if( $notes[$tag] )
		$rval .= writeNote( $level, "NOTE", $notes[$tag] );
	if( $media[$tag] )
		$rval .= writeMediaLinks( $media[$tag], $level );

	return $rval;
}

function writeIndividual( $ind ) {
	global $tree, $people_table, $events_table, $eventtypes_table, $admtext, $allow_lds, $lnprefixes, $assoc_table;
	global $nonames, $children_table, $families_table, $citations, $allow_living, $templeready, $savestate, $fp, $livedefault, $lineending;

	$ind[allow_living] = !$ind[living] || $livedefault == 2 || ( $allow_living && checkbranch( $ind[branch] ) ) ? 1 : 0;
	$doit = !$templeready;

	if( !$doit && ((!$ind[baptdate] && !$ind[baptplace]) || (!$ind[endldate] && !$ind[endlplace])))
		$doit = 1;

	//check eligibility
	if( $doit && $templeready ) {
		$doit = getEligibility( $ind );
	}

	$spousedata = "";
	if( $ind[sex] == "M" )
		$query = "SELECT familyID, sealdate, sealplace, marrplace, marrdatetr FROM $families_table WHERE husband = \"$ind[personID]\" AND gedcom = \"$tree\" ORDER BY wifeorder";
	else if( $ind[sex] == "F" )
		$query = "SELECT familyID, sealdate, sealplace, marrplace, marrdatetr FROM $families_table WHERE wife = \"$ind[personID]\" AND gedcom = \"$tree\" ORDER BY husborder";
	if( $query ) {
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		while( $spouse = mysql_fetch_assoc( $result2 ) ) {
			$spousedata .= "1 FAMS @$spouse[familyID]@$lineending";
			if( !$doit && !$spouse[sealdate] && !$spouse[sealplace] && $spouse[marrplace] && $spouse[marrdatetr] > "1500-00-00" )
				$doit = 1;
			//if $doit still false, loop through children to see if sealing needs to be done for any of them
			if( !$doit ) {
				$query = "SELECT personID, sealdate, sealplace from $children_table WHERE gedcom = \"$tree\" AND familyID = \"$spouse[familyID]\"";
				$children = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				if( $children ) {
					while( !$doit && $child = mysql_fetch_assoc( $children ) ) {
						if( !$child[sealdate] && !$child[sealplace] ) {
							//make sure child is eligible
							$query = "SELECT birthdate, birthdatetr, birthplace, altbirthdate, altbirthdatetr, altbirthplace, deathdatetr, burialdatetr from $people_table WHERE gedcom = \"$tree\" AND personID = \"$child[personID]\"";
							$childresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
							$childind = mysql_fetch_assoc( $childresult );
							$doit = getEligibility( $childind );
   							mysql_free_result( $childresult );
						}
					}
					mysql_free_result( $children );
				}
			}
		}
		mysql_free_result( $result2 );
	}

	$childdata = "";
	$query = "SELECT * from $children_table WHERE gedcom = \"$tree\" AND personID = \"$ind[personID]\" ORDER BY parentorder";
	$children = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	if( $children ) {
		while( $child = mysql_fetch_assoc( $children ) ) {
			$childdata .= appendParents( $child );
			if( !$doit && !$child[sealdate] && !$child[sealplace] )
			   $doit = 1;
		}
		mysql_free_result( $children );
	}

	if( $doit ) {
		if( $ind[allow_living] ) {
			$indnotes = getNotes( $ind[personID] );
			$indmedia = getMediaLinks( $ind[personID] );
		}
		else {
			$indnotes = array();
			$indmedia = array();
		}

		$citations = getCitations( $ind[personID] );
		$extras = getStdExtras( $ind[personID], 2 );

		$info = "0 @$ind[personID]@ INDI$lineending";
		if( $ind[allow_living] || !$nonames ) {
   			$info .= "1 NAME $ind[firstname] /" . trim( "$ind[lnprefix] $ind[lastname]" ) . "/";
			$info .= $ind[suffix] ? " $ind[suffix]$lineending" : $lineending;
   			if( $ind[firstname] ) $info .= "2 GIVN $ind[firstname]$lineending";
			if( $lnprefixes && $ind[lnprefix] ) $info .= "2 SPFX $ind[lnprefix]$lineending";
			if( $ind[lastname] ) $info .= "2 SURN $ind[lastname]$lineending";

			$info .= doNotesAndMedia($indnotes, $indmedia, "NAME", 2 );
			//if( $indnotes[NAME] )
			//	$info .= writeNote( 2, "NOTE", $indnotes[NAME] );
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
				$info .= "2 NICK $ind[nickname]\n";
				if( $indnotes[NICK] )
					$info .= writeNote( 3, "NOTE", $indnotes[NICK] );
			}
			if( $ind[title] ) {
				$info .= "1 TITL $ind[title]$lineending";
				if( $indnotes[TITL] )
					$info .= writeNote( 2, "NOTE", $indnotes[TITL] );
			}
			$info .= "1 SEX $ind[sex]$lineending";
			if($ind['living'])
				$info .= "1 _LIVING Y$lineending";
			if( $citations[NAME] )
				$info .= writeCitation( $citations[NAME], 1 );
		}
		elseif( $nonames == 2 )
			$info .= "1 NAME " . initials( $ind[firstname] ) . " /" . trim( "$ind[lnprefix] $ind[lastname]" ) . "/$lineending";
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
				$info .= doNotesAndMedia($indnotes, $indmedia, "BIRT", 2 );
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
				$info .= doNotesAndMedia($indnotes, $indmedia, "CHR", 2 );
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
			$info .= doNotesAndMedia($indnotes, $indmedia, "DEAT", 2 );
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
			$info .= doNotesAndMedia($indnotes, $indmedia, "BURI", 2 );
			if( $citations[BURI] )
				$info .= writeCitation( $citations[BURI], 2 );
			$info .= $extras[BURI];
		}
		$info .= $parentdata;

		if( $ind[allow_living] ) {
			$query = "SELECT tag, description, eventdate, eventplace, age, agency, cause, addressID, info, eventID FROM $events_table, $eventtypes_table WHERE persfamID = \"$ind[personID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND parenttag = \"\" AND gedcom = \"$tree\" AND keep = \"1\" ORDER BY eventdate, ordernum, tag";
			$custevents = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			while ( $custevent = mysql_fetch_assoc( $custevents ) ) {
				$info .= doEvent( $custevent, 1 );
				$eventID = $custevent[eventID];
				$info .= doNotesAndMedia($indnotes, $indmedia, $eventID, 2 );
				if( $citations[$eventID] )
					$info .= writeCitation( $citations[$eventID], 2 );
				$info .= getFact( $custevent, 2 );
			}

			if( $allow_lds ) {
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
					$info .= doNotesAndMedia($indnotes, $indmedia, "BAPL", 2 );
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
					$info .= doNotesAndMedia($indnotes, $indmedia, "ENDL", 2 );
					if( $citations[ENDL] )
						$info .= writeCitation( $citations[ENDL], 2 );
					$info .= $extras[ENDL];
				}
			}
			//do associations
			$query = "SELECT passocID, relationship FROM $assoc_table WHERE gedcom = \"$tree\" AND personID = \"$ind[personID]\"";
			$assocresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			while($assoc = mysql_fetch_assoc( $assocresult ) ) {
				$info .= "1 ASSO @$assoc[passocID]@$lineending";
				if( $assoc[relationship] ) $info .= "2 RELA $assoc[relationship]$lineending";
			}

			if( $indnotes['-x--general--x-'] )
				$info .= writeNote( 1, "NOTE", $indnotes['-x--general--x-'] );

			if( $indmedia['-x--general--x-'] )
				$info .= writeMediaLinks( $indmedia['-x--general--x-'], 1 );
		}
		$info .= $childdata;
		$info .= $spousedata;

		fwrite( $fp, $info );
		$savestate[icount]++;
		if( $savestate[icount] % 10 == 0 ) {
			echo "<strong>I$savestate[icount]</strong> ";
		}
	}
	return $info;
}

function writeFamily( $family ) {
	global $tree, $events_table, $eventtypes_table, $admtext, $allow_living, $allow_lds, $citations, $savestate, $children_table, $templeready, $fp, $lineending;

	$familyID = $family[familyID];
	$doit = !$templeready;

	if( !$doit && !$family[sealdate] && !$family[sealplace] && $family[marrplace] && $family[marrdatetr] > "1500-00-00")
		$doit = 1;

	$childdata = "";
	$query = "SELECT personID, sealdate, sealplace FROM $children_table WHERE familyID = \"$familyID\" AND personID != \"\" AND gedcom = \"$tree\" ORDER BY ordernum";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	if( $result ) {
		while( $child = mysql_fetch_assoc( $result ) ) {
			$childdata .= "1 CHIL @$child[personID]@$lineending";
			if( !$doit && !$child[sealdate] && !$child[sealplace] )
				$doit = 1;
		}
	}
	mysql_free_result( $result );

	if( $doit ) {
		$info = "0 @$familyID@ FAM$lineending";
		if( $family[status] ) { $info .= "1 _STAT $family[status]$lineending"; }
		if( $family[husband] )
			$info .= "1 HUSB @$family[husband]@$lineending";
		if( $family[wife] )
			$info .= "1 WIFE @$family[wife]@$lineending";

		//look up husband, look up wife, get living

		if( !$family[living] || $livedefault == 2 || ( $allow_living && checkbranch( $family[branch] ) ) ) {
			$famnotes = getNotes( $familyID );
			$citations = getCitations( $familyID );
			$fammedia = getMediaLinks( $familyID );
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
				$info .= doNotesAndMedia($famnotes, $fammedia, "MARR", 2 );
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
				$info .= doNotesAndMedia($famnotes, $fammedia, "DIV", 2 );
				if( $citations[DIV] )
					$info .= writeCitation( $citations[DIV], 2 );
				$info .= $extras[DIV];
			}

			$query = "SELECT tag, description, eventdate, eventplace, age, agency, cause, addressID, info, eventID FROM $events_table, $eventtypes_table WHERE persfamID = \"$familyID\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND parenttag = \"\" AND gedcom = \"$tree\" AND keep = \"1\" ORDER BY eventdate, ordernum, tag";
			$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			while ( $custevent = mysql_fetch_assoc( $custevents ) ) {
				$info .= doEvent( $custevent, 1 );
				$eventID = $custevent[eventID];
				$info .= doNotesAndMedia($famnotes, $fammedia, $eventID, 2 );
				if( $citations[$eventID] )
					$info .= writeCitation( $citations[$eventID], 2 );
				$info .= getFact( $custevent, 2 );
			}

			if( $allow_lds ) {
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
					$info .= doNotesAndMedia($famnotes, $fammedia, "SLGS", 2 );
					if( $citations[SLGS] )
						$info .= writeCitation( $citations[SLGS], 2 );
					$info .= $extras[SLGS];
				}
			}
			if( $citations[NAME] )
				$info .= writeCitation( $citations[NAME], 1 );

			if( $famnotes['-x--general--x-'] )
				$info .= writeNote( 1, "NOTE", $famnotes['-x--general--x-'] );

			if( $fammedia['-x--general--x-'] )
				$info .= writeMediaLinks( $fammedia['-x--general--x-'], 1 );
		}
		$info .= $childdata;

		fwrite( $fp, $info );
		$savestate[fcount]++;
		if( $savestate[fcount] % 10 == 0 ) {
			echo "<strong>F$savestate[fcount]</strong> ";
		}
	}
	return $info;
}

function doSources( ) {
	global $tree, $sources_table, $events_table, $eventtypes_table, $admtext, $savestate, $lineending, $sourceprefix;
	
	$sourcestr = "";
	$prefixlen = strlen( $sourceprefix ) + 1;

	$srcquery = "SELECT *, (0+SUBSTRING(sourceID,$prefixlen)) as num FROM $sources_table WHERE gedcom = \"$tree\" $savestate[wherestr] ORDER BY num";
	$srcresult = mysql_query($srcquery) or die ("$admtext[cannotexecutequery]: $query");
	while( $source = mysql_fetch_assoc( $srcresult ) ) {
		$srcnotes = getNotes( $source[sourceID] );
		$srcmedia = getMediaLinks( $source[sourceID] );

		$sourcestr .= "0 @$source[sourceID]@ SOUR$lineending";
		if( $source[callnum] ) { $sourcestr .= "1 CALN $source[callnum]$lineending"; }
		if( $source[title] ) { $sourcestr .= "1 TITL $source[title]$lineending"; }
		if( $source[shorttitle] ) { $sourcestr .= "1 ABBR $source[shorttitle]$lineending"; }
		if( $source[author] ) { $sourcestr .= "1 AUTH $source[author]$lineending"; }
		if( $source[publisher] ) { $sourcestr .= "1 PUBL $source[publisher]$lineending"; }
		if( $source[repoID] ) { $sourcestr .= "1 REPO @$source[repoID]@$lineending"; }

		$query = "SELECT tag, description, eventdate, eventplace, info FROM $events_table, $eventtypes_table WHERE persfamID = \"$source[sourceID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND type = \"S\" AND gedcom = \"$tree\" AND keep = \"1\" ORDER BY ordernum";
		$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		while ( $custevent = mysql_fetch_assoc( $custevents ) ) {
			$sourcestr .= doEvent( $custevent, 1 );
			$eventID = $custevent[eventID];
			$sourcestr .= doNotesAndMedia($srcnotes, $srcmedia, $eventID, 2 );
		}
		mysql_free_result( $custevents );

		if( $source[actualtext] ) {
			$sourcestr .= writeNote( 1, "TEXT", $source[actualtext] );
		if( $srcnotes['-x--general--x-'] )
			$sourcestr .= writeNote( 1, "NOTE", $srcnotes['-x--general--x-'] );
		}

		if( $srcmedia['-x--general--x-'] )
			$sourcestr .= writeMediaLinks( $srcmedia['-x--general--x-'], 1 );

		$savestate[scount]++;
		if( $saveimport ) {
			$savestate[offset] = ftell($fp);
			$query = "UPDATE $saveimport_table SET offset=$savestate[offset], lasttype=$savestate[lasttype], lastid=\"$source[sourceID]\", scount=\"$savestate[scount]\" WHERE gedcom = \"$tree\"";
			$saveresult = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		}
		if( $savestate[scount] % 10 == 0 ) {
			echo "<strong>S$savestate[scount]</strong> ";
		}
	}
	mysql_free_result( $srcresult );

	return $sourcestr;
}

function doRepositories( ) {
	global $tree, $repositories_table, $events_table, $eventtypes_table, $admtext, $savestate, $lineending, $repoprefix;

	$repostr = "";
	$prefixlen = strlen( $repoprefix ) + 1;

	$repoquery = "SELECT *, (0+SUBSTRING(repoID,$prefixlen)) as num FROM $repositories_table WHERE gedcom = \"$tree\" $savestate[wherestr] ORDER BY num";
	$reporesult = mysql_query($repoquery) or die ("$admtext[cannotexecutequery]: $query");

	while( $repo = mysql_fetch_assoc( $reporesult ) ) {
		$reponotes = getNotes( $repo[repoID] );
		$repomedia = getMediaLinks( $repo[repoID] );

		$repostr .= "0 @$repo[repoID]@ REPO$lineending";
		if( $repo[reponame] ) { $repostr .= "1 NAME $repo[reponame]$lineending"; }
		if( $repo[addressID] ) { $repostr .= getFact( $repo, 1 ); }

		$query = "SELECT tag, description, eventdate, eventplace, info FROM $events_table, $eventtypes_table WHERE persfamID = \"$repo[repoID]\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND type = \"R\" AND gedcom = \"$tree\" AND keep = \"1\" ORDER BY ordernum";
		$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		while ( $custevent = mysql_fetch_assoc( $custevents ) ) {
			$repostr .= doEvent( $custevent, 1 );
		}
		mysql_free_result( $custevents );

		if( $reponotes['-x--general--x-'] )
			$repostr .= writeNote( 1, "NOTE", $reponotes['-x--general--x-'] );

		if( $repomedia['-x--general--x-'] )
			$repostr .= writeMediaLinks( $repomedia['-x--general--x-'], 1 );

		$savestate[rcount]++;
		if( $saveimport ) {
			$savestate[offset] = ftell($fp);
			$query = "UPDATE $saveimport_table SET offset=$savestate[offset], lasttype=$savestate[lasttype], lastid=\"$repo[repoID]\", rcount=\"$savestate[rcount]\" WHERE gedcom = \"$tree\"";
			$saveresult = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		}
		if( $savestate[rcount] % 10 == 0 ) {
			echo "<strong>R$savestate[rcount]</strong> ";
		}
	}
	mysql_free_result( $reporesult );
	
	return $repostr;
}

?>
<p class="normal"><strong><?php echo $admtext[exporting]; ?></strong></p>
<?php
if( $saveimport )
	echo "<p>$admtext[ifexportfails] <a href=\"gedcom2.php?tree=$tree&amp;resume=1\">$admtext[resume]</a>.</p>$lineending";

@set_time_limit(0);
$xnotes = array();

$largechunk = 1000;
$filename = "$rootpath$gedpath/$tree.ged";
$found = 0;

//if saving is enabled and URL flag is set, check the db table to see if a record exists
if( $saveimport ) {
	if( $resume ) {
		$checksql = "SELECT filename, offset, lasttype, lastid, icount, fcount, scount, ncount, rcount from $saveimport_table WHERE gedcom = \"$tree\"";
		$result = @mysql_query( $checksql ) or die ("$admtext[cannotexecutequery]: $checksql");
		$found = mysql_num_rows( $result );
		if( $found ) {
			$row = mysql_fetch_assoc($result);
			$filename = $row[filename];
			$savestate[offset] = $row[offset];
			$savestate[icount] = $row[icount];
			$savestate[fcount] = $row[fcount];
			$savestate[scount] = $row[scount];
			$savestate[ncount] = $row[ncount];
			$savestate[rcount] = $row[rcount];
			//retrieve entity type (I = 1, F = 2, S = 3, X = 4, R = 5)
			$savestate[lasttype] = $row[lasttype];
			switch( $savestate[lasttype] ) {
				case 1:
					$savestate[wherestr] = " AND personID > \"$row[lastid]\"";
					break;
				case 2:
					$savestate[wherestr] = " AND familyID > \"$row[lastid]\"";
					break;
				case 3:
					$savestate[wherestr] = " AND sourceID > \"$row[lastid]\"";
					break;
				case 4:
					$savestate[wherestr] = " AND noteID > \"$row[lastid]\"";
					break;
				case 5:
					$savestate[wherestr] = " AND repoID > \"$row[lastid]\"";
					break;
			}
		}
		mysql_free_result($result);
	}
	else {
		$query = "DELETE from $saveimport_table WHERE gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		$sql = "INSERT INTO $saveimport_table (filename, offset, gedcom)  VALUES(\"$filename\", 0, \"$tree\")";
		$result = @mysql_query( $sql ) or die ("$admtext[cannotexecutequery]: $sql");
	}
}
if( $found ) {
	$fp = @fopen( $filename, "r+" );
	fseek( $fp, $savestate[offset] );
}
else {
	if( file_exists( $filename ) ) unlink( $filename );
	$fp = @fopen( $filename, "w" );
	$savestate[lasttype] = 1;
	$savestate[icount] = 0;
	$savestate[fcount] = 0;
	$savestate[scount] = 0;
	$savestate[ncount] = 0;
	$savestate[rcount] = 0;
}
if( !$fp ) { die ( "$admtext[cannotopen] $filename" ); }
flock( $fp, LOCK_EX );

//if saving is enabled, write out new information after each person/family/source/repo

$numrows = 0;

$maxgcgen = 999;

if( !$found ) {
	$query = "SELECT email FROM $trees_table WHERE gedcom = \"$tree\"";
	$treeresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$treerow = mysql_fetch_assoc($treeresult);
	mysql_free_result( $treeresult );

	$owneremail = $treerow['email'] ? $treerow['email'] : $emailaddr;

	$firstpart = "0 HEAD$lineending"
	. "1 SOUR The Next Generation of Genealogy Sitebuilding$lineending"
	. "2 VERS $tng_version$lineending"
	. "2 NAME The Next Generation of Genealogy Sitebuilding (R)$lineending"
	. "2 CORP Next Generation Software, LLC$lineending"
	. "3 ADDR Sandy, UT$lineending"
	. "1 FILE $tree.ged$lineending"
	. "1 GEDC$lineending"
	. "2 VERS 5.5$lineending"
	. "2 FORM LINEAGE-LINKED$lineending"
	. "1 CHAR " . ($session_charset == "UTF-8" ? "UTF-8" : "ANSI" ) . $lineending
	. "1 SUBM @SUB1@$lineending"
	. "0 @SUB1@ SUBM$lineending"
	. "1 NAME $dbowner$lineending"
	. "1 _EMAIL $owneremail$lineending";
	if( $templeready ) $firstpart .= "1 DEST TempleReady$lineending";

	fwrite( $fp, "$firstpart" );
}

$prefixlen = strlen( $personprefix ) + 1;

if( $savestate[lasttype] < 2 ) {
	$nextchunk = -1;
	do {
		$nextone = $nextchunk + 1;
		$nextchunk += $largechunk;
		$query = "SELECT personID, (0+SUBSTRING(personID,$prefixlen)) as num, lastname, lnprefix, firstname, sex, title, prefix, suffix, nickname, birthdate, birthdatetr, birthplace, altbirthdate, altbirthdatetr, altbirthplace, deathdate, deathdatetr, deathplace, burialdate, burialdatetr, burialplace, baptdate, baptplace, endldate, endlplace, famc, living, branch FROM $people_table
			WHERE gedcom = \"$tree\" $savestate[wherestr] ORDER BY num LIMIT $nextone, $largechunk";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( $result ) {
			$numrows = mysql_num_rows( $result );
			while( $ind = mysql_fetch_assoc( $result ) ) {
				if( $ind[personID] ) {
					writeIndividual( $ind );
					if( $saveimport ) {
						$savestate[offset] = ftell($fp);
						$query = "UPDATE $saveimport_table SET offset=$savestate[offset], lasttype=$savestate[lasttype], lastid=\"$ind[personID]\", icount=\"$savestate[icount]\" WHERE gedcom = \"$tree\"";
						$saveresult = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
					}
				}
			}
			mysql_free_result( $result );
		}
	} while ( $numrows );
	$savestate[lasttype] = 2;
	$savestate[wherestr] = "";
}

$prefixlen = strlen( $familyprefix ) + 1;

if( $savestate[lasttype] < 3 ) {
	$nextchunk = -1;
	do {
		$nextone = $nextchunk + 1;
		$nextchunk += $largechunk;
		$query = "SELECT *, (0+SUBSTRING(familyID,$prefixlen)) as num FROM $families_table WHERE gedcom = \"$tree\" $savestate[wherestr] ORDER BY num LIMIT $nextone, $largechunk";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( $result ) {
			$numrows = mysql_num_rows( $result );
			while( $fam = mysql_fetch_assoc( $result ) ) {
				if( $fam[familyID] ) {
					$famarray[$fam[familyID]] = writeFamily( $fam );
					if( $saveimport ) {
						$savestate[offset] = ftell($fp);
						$query = "UPDATE $saveimport_table SET offset=$savestate[offset], lasttype=$savestate[lasttype], lastid=\"$fam[familyID]\", fcount=\"$savestate[fcount]\" WHERE gedcom = \"$tree\"";
						$saveresult = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
					}
				}
			}
			mysql_free_result( $result );
		}
	} while ( $numrows );
	$savestate[lasttype] = 3;
	$savestate[wherestr] = "";
}

if( $savestate[lasttype] < 4 ) {
	fwrite( $fp, doSources() );
	$savestate[lasttype] = 4;
	$savestate[wherestr] = "";
}
if( $savestate[lasttype] < 5 ) {
	fwrite( $fp, doXNotes() );
	$savestate[lasttype] = 5;
	$savestate[wherestr] = "";
}
if( $savestate[lasttype] < 6 ) {
	fwrite( $fp, doRepositories() );
	$savestate[lasttype] = 6;
	$savestate[wherestr] = "";
}

fwrite( $fp, "0 TRLR" );

flock( $fp, LOCK_UN );
fclose( $fp );
@chmod( $filename, 0644 );

if( $saveimport ) {
	$sql = "DELETE from $saveimport_table WHERE gedcom = \"$tree\"";
	$result = @mysql_query($sql) or die ("$admtext[cannotexecutequery]: $query");
}
?>

<p class="normal">
<?php
	adminwritelog( "$admtext[export]: $tree" );
	echo "$admtext[finishedexporting] <br/>$savestate[icount] $admtext[people], $savestate[fcount] $admtext[families], $savestate[scount] $admtext[sources], $savestate[rcount] $admtext[repositories], $savestate[ncount] $admtext[notes]"; 
	if( substr( $gedpath, 0, 1 ) != "/" )
		$relativepath = $cms[support] ? "../../../" : "../";
	else
		$relativepath = "";
?>
</p>

<p class="normal"><a href="<?php echo "$relativepath$gedpath/$tree" . ".ged" ?>"><?php echo $admtext[downloadged]; ?></a></p>

</div></div>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>