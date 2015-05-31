<?php
include("begin.php");
@set_time_limit(0);
include($subroot . "pedconfig.php");
include($cms['tngpath'] . "genlib.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
$textpart = "pedigree";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
include($cms['tngpath'] . "checklogin.php");

$showmedia_url = getURL( "showmedia", 1 );
initMediaTypes();

function xmlPhoto( $persfamID, $living ) {
	global $rootpath, $photopath, $documentpath, $headstonepath, $historypath, $mediapath, $mediatypes_assoc;
	global $photosext, $tree, $medialinks_table, $media_table, $text, $showmedia_url;

	$query = "SELECT $media_table.mediaID, medialinkID, alwayson, thumbpath, mediatypeID, usecollfolder FROM ($media_table, $medialinks_table)
		WHERE personID = \"$persfamID\" AND $medialinks_table.gedcom = \"$tree\" AND $media_table.mediaID = $medialinks_table.mediaID AND defphoto = '1'";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );

	$photocheck = "";
	if($row[thumbpath]) {
		if( checkLivingLinks($row[mediaID], $row[alwayson] ) ) {
			$mediatypeID = $row[mediatypeID];
			$usefolder = $row[usecollfolder] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
			$photocheck = "$usefolder/$row[thumbpath]";
			$photoref = "$usefolder/" . str_replace("%2F","/",rawurlencode( $row[thumbpath] ));
			$photolink = "<photolink>" . xmlcharacters($showmedia_url . "mediaID=$row[mediaID]&amp;medialinkID=$row[medialinkID]") . "</photolink>\n";
		}
	}
	elseif($living) {
		$photoref = $photocheck = $tree ? "$photopath/$tree.$persfamID.$photosext" : "$photopath/$persfamID.$photosext";
		$photolink = "<photolink />\n";
	}

	if( $photocheck && file_exists( "$rootpath$photocheck" ) ) {
		$photo .= "<photosrc>$photoref</photosrc>\n";
		$photo .= $photolink;
	}
	if( !$photo ) {
		$photo .= "<photosrc>-1</photosrc>\n<photolink />\n";
	}

	return $photo;
}

function xmlPerson( $currperson, $backperson, $generation ) {
	global $tree, $text, $allow_living, $pedigree, $parentset, $children_table, $families_table, $people_table;
	global $generations, $display, $livedefault;

	$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, nameorder, living, branch, famc, sex, birthdate, birthplace, altbirthdate, altbirthplace, deathdate, deathplace, burialdate, burialplace FROM $people_table WHERE personID = \"$currperson\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	mysql_free_result($result);
	
	echo "<person>\n";
	echo "<persInfo>\n";
	echo "<personID>$currperson</personID>\n";
	echo "<tree>$tree</tree>\n";
	echo "<backpersonID>$backperson</backpersonID>\n";
	echo "<gender>$row[sex]</gender>\n";
	//look up info
	$rightbranch = checkbranch( $row[branch] ) ? 1 : 0;
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$nameinfo = xmlcharacters( getName( $row ) );
	echo "<nm>$nameinfo</nm>\n";

	$parentfamID = "";
	$locparentset = $parentset;
	$parentscount = 0;
	$parentfamIDs = array();
	$query = "SELECT familyID FROM $children_table WHERE personID = \"$currperson\" AND gedcom = \"$tree\" ORDER BY parentorder";
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

	if( $parentfamID )
	   	echo "<parentfam>$parentfamID</parentfam>\n";
	else
	   	echo "<parentfam>-1</parentfam>\n";
	if( $display == "standard" && $pedigree[inclphotos] )
		echo xmlPhoto( $currperson, $row[allow_living] );
	else
		echo "<photosrc>-1</photosrc>\n<photolink />\n";

	if( $row[allow_living] ) {
		$dataflag = $row[birthdate] || $row[altbirthdate] || $row[altbirthplace] || $row[deathdate] || $row[burialdate] || $row[burialplace] ? 1 : 0;

		// get birthdate info
		if ( $row[altbirthdate] && !$row[birthdate] ) {
			$bd = $row[altbirthdate]; 
			$bp = $row[altbirthplace];
			$birthabbr = "capaltbirthabbr";
		}
	  	elseif( $dataflag ) {
			$bd = $row[birthdate];
			$bp = $row[birthplace];
			$birthabbr = "capbirthabbr";
		}
		else
			$bd = $bp = $birthabbr = "";
	
		// get death/burial date info   
		if( $row[burialdate] && !$row[deathdate] ) {
			$dd = $row[burialdate]; 
			$dp = $row[burialplace];
			$deathabbr = "capburialabbr";
		}
		elseif( $dataflag ) {
			$dd = $row[deathdate] ;
			$dp = $row[deathplace];
			$deathabbr = "capdeathabbr";
		}
		else
			$dd = $dp = $deathabbr = "";
	}
	else
		$bd = $bp = $birthabbr = $dd = $dp = $deathabbr = $md = $mp = $marrabbr = "";
	echo "<babbr>" . $text[$birthabbr] . "</babbr>\n";
	echo "<bdate>" . xmlcharacters(displayDate($bd)) . "</bdate>\n";
	echo "<bplace>" . xmlcharacters( $bp ) . "</bplace>\n";
	echo "<dabbr>" . $text[$deathabbr] . "</dabbr>\n";
	echo "<ddate>" . xmlcharacters(displayDate($dd)) . "</ddate>\n";
	echo "<dplace>" . xmlcharacters( $dp ) . "</dplace>\n";

	echo "</persInfo>\n";
		
	if ($parentscount > 1) {
		for ( $i = 1; $i <= $parentscount ; $i++ ) {
			echo "<parents>\n";
			$parentinfo = getParentInfo($parentfamIDs[$i]);
			echo "<pfam>" . $parentfamIDs[$i] . "</pfam>\n";
			echo "<fID>$parentinfo[fathID]</fID>\n";
			echo "<fNm>" . xmlcharacters($parentinfo[fathname]) . "</fNm>\n";
			echo "<mID>$parentinfo[mothID]</mID>\n";
			echo "<mNm>" . xmlcharacters($parentinfo[mothname]) . "</mNm>\n";
			echo "</parents>\n";
		}
	}

	//do spouses
	$spiceNames = array(); $spiceIDs = array();
	$spicekidcount = array();
	$spousecount = 1;
	
	if( $row[sex] ) { 
		if ( $row[sex] == "M" ) { 
	  		$spouse = "wife"; $self = "husband"; $spouseorder = "husborder"; 
		}
		elseif( $row[sex] == "F" ) { 
			$spouse = "husband"; $self = "wife"; $spouseorder = "wifeorder"; 
		}
		else
			$spouseorder = "";
	}
	if( $spouseorder ) { 
		$query = "SELECT $spouse, familyID FROM $families_table WHERE $families_table.$self = \"$currperson\" AND $families_table.gedcom = \"$tree\" ORDER BY $spouseorder";
		$spouses = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		while ( $spouserow =  mysql_fetch_assoc( $spouses ) ) {
			echo "<spFam>\n";
			if( $spouserow[$spouse] ) {
				$query = "SELECT lastname, lnprefix, firstname, prefix, suffix, title, nameorder, living, branch, sex FROM $people_table WHERE personID = \"$spouserow[$spouse]\" AND gedcom = \"$tree\"";
				$spouseIDresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				$spouseIDrow =  mysql_fetch_assoc( $spouseIDresult );
				$spouseIDrow[allow_living] = !$spouseIDrow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $spouseIDrow[branch] ) ) ? 1 : 0;
				echo "<spInfo>\n";
				echo "<spID>$spouserow[$spouse]</spID>\n";
				echo "<spNm>" . xmlcharacters( getName( $spouseIDrow ) ) . "</spNm>\n";
				echo "<spFamID>$spouserow[familyID]</spFamID>\n";
				echo "</spInfo>\n";
				mysql_free_result($spouseIDresult);
			}
				
			if ($pedigree[popupkids]) {
				$query = "SELECT $people_table.personID as pID, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, branch FROM $people_table, $children_table WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = \"$spouserow[familyID]\" AND $people_table.gedcom = \"$tree\" AND $children_table.gedcom = \"$tree\" ORDER BY ordernum";
				$children = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				if( $children && mysql_num_rows( $children ) ) {
					while ( $child =  mysql_fetch_assoc( $children ) ) {
						echo "<child>\n";
						$child[allow_living] = !$child[living] || $livedefault == 2 || ( $allow_living && checkbranch( $child[branch] ) ) ? 1 : 0;
						echo "<chID>$child[pID]</chID>\n";
						echo "<chNm>" . xmlcharacters( getName( $child ) ) . "</chNm>\n";
						echo "</child>\n";
					}
				}
				mysql_free_result($children);
			}
			echo "</spFam>\n";
		}
		mysql_free_result($spouses);
	}
	
	echo "</person>\n";

	$generation++;
	if( $generation <= $generations )
		if( $parentfamID ) xmlFamily( $parentfamID, $currperson, $generation );
}

function xmlFamily( $famc, $backperson, $generation) {
	global $pedigree, $generations, $pedmax, $people_table, $families_table, $allow_add;
	global $tree, $allow_living, $text, $livedefault;
	
	$query = "SELECT husband, wife, marrdate, marrplace, living, branch FROM $families_table WHERE familyID = \"$famc\" AND gedcom = \"$tree\"";
	$famresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $famresult ) {
		$famrow = mysql_fetch_assoc( $famresult );
		echo "<fam>\n";
		echo "<famID>$famc</famID>\n";
		echo "<husband>$famrow[husband]</husband>\n";
		echo "<wife>$famrow[wife]</wife>\n";
		$famrow[allow_living] = !$famrow[living] || $livedefault == 2 || ( $allow_living && checkbranch( $famrow[branch] ) ) ? 1 : 0;
		if( $famrow[allow_living] ) {
			$marrdate = displayDate( $famrow[marrdate] );
			$marrplace = xmlcharacters( $famrow[marrplace] );
			if( $famrow[marrdate] || $famrow[marrplace] )
				$marrabbr = $text[capmarrabbr];
			else
				$marrabbr = "";
		}
		else
			$marrdate = $marrplace = $marrabbr = "";
		echo "<mdate>" . xmlcharacters($marrdate) . "</mdate>\n";
		echo "<mplace>" . xmlcharacters($marrplace) . "</mplace>\n";
		echo "<mabbr>$marrabbr</mabbr>\n";

		echo "</fam>\n";
		if( $famrow[husband] ) 
			xmlPerson($famrow[husband],$backperson,$generation);
		if( $famrow[wife] )
			xmlPerson($famrow[wife],$backperson,$generation);
		
		mysql_free_result($famresult);
	}
}

// subroutine to get father/mother ids and names
function getParentInfo( $famid ) {
 	global $people_table, $families_table, $tree, $text, $nonames, $allow_living, $livedefault;

 	$parentarray = array();
	$query = "SELECT personID, lastname, lnprefix, firstname, prefix, suffix, nameorder, $people_table.living, $people_table.branch FROM $people_table, $families_table WHERE $people_table.personID = $families_table.husband AND $families_table.familyID = \"$famid\" AND $families_table.gedcom = \"$tree\" AND $people_table.gedcom = \"$tree\"";
	$parentresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $parentresult ) {
		$row =  mysql_fetch_assoc( $parentresult );
		$parentarray[fathID] = $row[personID];
		$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && checkbranch( $row[branch] ) ) ? 1 : 0;
		$parentarray[fathname] = xmlcharacters( getName( $row ) );
		mysql_free_result( $parentresult );
	}

	$query = "SELECT personID, lastname, firstname, prefix, suffix, nameorder, $people_table.living, $people_table.branch FROM $people_table, $families_table WHERE $people_table.personID = $families_table.wife AND $families_table.familyID = \"$famid\" AND $families_table.gedcom = \"$tree\" AND $people_table.gedcom = \"$tree\"";
	$parentresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $parentresult ) { 		
		$row =  mysql_fetch_assoc( $parentresult );
		$parentarray[mothID] = $row[personID];
		$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && checkbranch( $row[branch] ) ) ? 1 : 0;
		$parentarray[mothname] = xmlcharacters( getName( $row ) );
		mysql_free_result( $parentresult );
	}
	return $parentarray;
}

// how many generations to show?
if( !$pedigree[maxgen] ) $pedigree[maxgen] = 6;
if( $generations > $pedigree[maxgen] )
    $generations = $pedigree[maxgen];
else if( !$generations ) 
    $generations = $pedigree[maxgen] < 4 ? $pedigree[maxgen] : 4;
else
	$generations = intval( $generations );

// alternate parent display?
$parentset = $parentset ? intval($parentset) : 0;

$pedigree[phototree] = $tree;
if( $tree ) $pedigree[phototree] .= ".";

header('Content-Type: application/xml');
echo "<?xml version=\"1.0\"";
if($session_charset)
	echo " encoding=\"$session_charset\"";
echo "?>\n";
echo "<pedigree>\n";

$generation = 1;
$newfam = 1;
$backperson = "";
if( $personID ) {
	xmlPerson($personID,$backperson,$generation);
}
else {
	eval("\$backpers = \$backpers$newfam;");
	eval("\$famc = \$famc$newfam;");
	while( $famc ) {
		xmlFamily($famc,$backpers,$generation);
		$newfam++;
		eval("\$backpers = \$backpers$newfam;");
		eval("\$famc = \$famc$newfam;");
	}
}
echo "</pedigree>";
?>
