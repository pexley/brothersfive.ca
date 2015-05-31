<?php
// PDF Descendancy Report
// Author:  Bret Rumsey
// Thanks to J. Kraber for his original implementation of this report.
//
include("begin.php");
include($cms['tngpath'] . "genlib.php");
include($cms['tngpath'] . "getlang.php");
$textpart = "pedigree";
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
$tngprint = 1;
include($cms['tngpath'] . "checklogin.php");

$query = "SELECT title, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, burialplace, birthplace, altbirthplace, deathplace, sex, living, branch
	FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
    $row = mysql_fetch_assoc( $result );
    $rightbranch = checkbranch( $row[branch] );
    $row[allow_living] = !$row[living] || ( $allow_living && $rightbranch ) ? 1 : 0;
    $namestr = getName( $row );
}

$infoDescend[0][gen] = 1;
$infoDescend[0][name] = $namestr;
$infoDescend[0][vitals] = getVitalDates($row);
$infoDescend[0][children] = -1;
if ($numbering == 0) {
    $infoDescend[0][number] = '';
} 
else if ($numbering == 4) {
    $infoDescend[0][number] = 'a';
}
else {
    $infoDescend[0][number] = '1';
}

// build the descendants
if ($genperpage > 1) {
    getIndividual($personID, $row[sex], 2, $personID, $infoDescend[0][number]);
}
$personcount = count($infoDescend);

// Specify Page layout and chart structure
$dxgen = 0.25;	// distance between each generation number (e.g. from 1. to 2. above)
$dxtabln = 0.08; // distance from Name to vertical line (e.g. from Patriarch to | above)
$dy = 0.15077;	// line height (note: try to have line height so a specific number of whole lines fits on page
$dyerror = 0.0001;  // error term is included in page break for rounding error
$hangind = 0.25;    // how much to indent lines when more than one is needed
$lenhorline = $dxgen - $dxtabln;  // length of horizontal lines

// start the report
define('FPDF_FONTPATH','font/');
require($cms[tngpath] . 'tngpdf.php');
$pdf = new TNGPDF($orient, 'in', $pagesize);

// load the fonts we will be using
$pdf->AddFont($hdrFont);
$pdf->AddFont($hdrFont, 'B');
$pdf->AddFont($rptFont);

$paperdim = $pdf->GetPageSize();

// set the document title
$title = $text['descendfor'] . ' '.$infoDescend[0][name];

// set margins
$pdf->SetTopMargin($topmrg);
$pdf->SetLeftMargin($lftmrg);
$pdf->SetRightMargin($rtmrg);
$pdf->SetAutoPageBreak(0, $botmrg); // set page break to manual (this is for drawing lines from page to page)

$pdf->AddPage();
$pdf->SetTitle($title);
$pdf->SetAuthor($dbowner);

// print Header
printHeader();

// start looping through each individual on chart
for ($i = 0; $i < $personcount; $i++) {

    // calculate the x and y of our current individual
    $x = $lftmrg + ($infoDescend[$i][gen] - 1) * $dxgen;
    $y = $pdf->GetY();

    // check if at end of page
    if ($y > $paperdim[h] - $botmrg - $dy + $dyerror) {

	// continue lines at the bottom of the page
	for ($j = 1; $j <= $genperpage; $j++) {
	    if ($genchld[$j] > 0) {
		$xln = $lftmrg + ($j - 1) * $dxgen + $dxtabln;
		$pdf->Line($xln, $y, $xln, $geny[$j] + $dy);

		// reset the y position to be the top of the page
		$geny[$j] = $topmrg;
	    }
	}

	// create new page
	$pdf->AddPage();
	$y = printHeader();
	$pdf->SetY($y);
    }

    // print main individual info
    if ($infoDescend[$i][children] == -1) {
	$namestring = $infoDescend[$i][name].' '.$infoDescend[$i][vitals];
	$pdf->SetX($x);
	$sep = '-';
	if ($numbering == 0) { $sep = ''; }
    	$pdf->MultiCell(0, $dy, $infoDescend[$i][number].$sep.$namestring, 0, 'L', 0, $x+$hangind);

    // print spouse info
    } else {
	$namestring = '+'.$infoDescend[$i][name].' '.$infoDescend[$i][vitals];
    	$pdf->SetX($x);
	$geny[$infoDescend[$i][gen]] = $pdf->GetY();
    	$pdf->MultiCell(0, $dy, $namestring, 0, 'L', 0, $x+$hangind);
	$genchld[$infoDescend[$i][gen]] = $infoDescend[$i][children];
    }

    // draw chart lines
    if ($infoDescend[$i][children] == -1) {
	// child -- horizonatal line
	if ($i <> 0) {
	    $genchld[$infoDescend[$i][gen]-1] -= 1;
	    $pdf->Line($x - $lenhorline, $y + $dy / 2, $x, $y + $dy / 2);
	    $pdf->Line($x - $lenhorline, $y + $dy / 2, $x - $lenhorline, $geny[$infoDescend[$i][gen]-1] + $dy);
	}
    }
}

// write the document out
$pdf->Output();

// END PDF REPORT

function getIndividual($key, $sex, $level, $trail, $num) {
    global $j, $infoDescend, $numbering;
    global $tree, $genperpage, $text, $allow_living, $nonames, $cms;
    global $families_table, $people_table, $children_table, $trees_table;
    global $numgen;

    if (is_null($j)) {
	$j = 1;
    }

    if( $sex == 'M' ) {
	$self = 'husband';
	$spouse = 'wife';
	$spouseorder = 'husborder';
    } else {
	$self = 'wife';
	$spouse = 'husband';
	$spouseorder = 'wifeorder';
    }

    $query = "SELECT $spouse, familyID FROM $families_table WHERE $families_table.$self = \"$key\" AND gedcom = \"$tree\" ORDER BY $spouseorder";
    $result = mysql_query($query) or die("$text[cannotexecutequery]: $query");
    if ($result) {
	while ($row = mysql_fetch_assoc($result)) {
	    $spousestr = '';
	    if ($row[$spouse]) {
		$query = "SELECT title, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, burialplace, birthplace, altbirthplace, deathplace, living, branch FROM $people_table WHERE personID = \"$row[$spouse]\" AND gedcom = \"$tree\"";
		$spouseresult = mysql_query($query) or die("$text[cannotexecutequery]: $query");
		if ($spouseresult) {
		    $spouserow = mysql_fetch_assoc( $spouseresult );
		    $spouserow[allow_living] = !$spouserow[living] || ( $allow_living && checkbranch( $spouserow[branch] ) ) ? 1 : 0;
		    $spousename = getName($spouserow);
		    $vitalinfo = getVitalDates($spouserow);
		    $spousestr = "&nbsp; $spousename &nbsp; $vitalinfo";
		    $infoDescend[$j][name] = $spousename;
		}
	    }
	    else {
		$infoDescend[$j][name] = $text['unknown'];
	    }
	    $infoDescend[$j][gen] = $level-1;
	    if ($numbering == 0) {
		$infoDescend[$j][number] = '';
	    } else if ($numbering == 1) {
		$infoDescend[$j][number] = $level-1;
	    } else if ($numbering == 2) {
		$henrynum = $num;
		if ($henrynum == 10) {
		    $henrynum = 'X';
		}
		else if ($henrynum > 10) {
		    $henrynum = chr($henrynum+55);
		}
		$infoDescend[$j][number] = $henrynum;
	    } else if ($numbering == 3) {
		$infoDescend[$j][number] = $num;
	    } else if ($numbering == 4) {
		$infoDescend[$j][number] = $num;
	    }
	    $infoDescend[$j][vitals] = $vitalinfo;

	    $query = "SELECT $children_table.personID as cpersonID, title, firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, burialplace, birthplace, altbirthplace, deathplace, sex, living, branch FROM ($children_table, $people_table) WHERE familyID = \"$row[familyID]\" AND $children_table.personID = $people_table.personID AND $children_table.gedcom = \"$tree\" AND $people_table.gedcom = \"$tree\" ORDER BY ordernum";
	    $result2 = mysql_query($query) or die("$text[cannotexecutequery]: $query");
	    $numkids = mysql_num_rows($result2);
	    if ($numkids) {
		// Note: need to also determine index of last child for the purpose of drawing a veritical line
		$k = $j; // remember index of spouse to later save index of last child 
		$j++;
		$n = 1; // child number
		while( $crow = mysql_fetch_assoc( $result2 ) ) {
		    $newtrail = "$trail,$row[familyID],$crow[cpersonID]";
		    $crow[allow_living] = !$crow[living] || ( $allow_living && checkbranch( $crow[branch] ) ) ? 1 : 0;
		    $childname = getName($crow);
		    $vitalinfo = getVitalDates($crow);
		    $infoDescend[$j][gen] = $level;
		    if ($numbering == 0) {
			$infoDescend[$j][number] = '';
		    } else if ($numbering == 1) {
			$infoDescend[$j][number] = $level;
		    } else if ($numbering == 2) {
			$henrynum = $num;
			if ($henrynum == 10) {
			    $henrynum = 'X';
			}
			else if ($henrynum > 10) {
			    $henrynum = chr($henrynum+55);
			}
			$infoDescend[$j][number] = "${henrynum}${n}";
		    } else if ($numbering == 3) {
			$infoDescend[$j][number] = "${num}.${n}";
		    } else if ($numbering == 4) {
			$infoDescend[$j][number] = "${num}.".chr(96+$level).${n};
		    }
		    $infoDescend[$j][name] = $childname;
		    $infoDescend[$j][vitals] = $vitalinfo;
		    $infoDescend[$j][children] = -1;
		    $infoDescend[$j][prnt] = $k;
		    if ($n == $numkids) {
			$lastchildindex = $j;
		    } else {
			$n++;
		    }
		    $j++;

		    // keep track of highest number of generations for report (using $level on gives generation of last person)
		    if ($numgen < $level) {
			$numgen = $level;
		    }
		    if ($level < $genperpage) {
			getIndividual($crow[cpersonID], $crow[sex], $level+1, $newtrail, $infoDescend[$j-1][number]);
		    }	
		}
		$infoDescend[$k][children] = $numkids;
	    } else {
		$infoDescend[$j][children] = 0;
		$j++;
	    }
	    mysql_free_result($result2);
	}
    }
    // if there is no spouse listed, it's unknown
    else {
	$infoDescend[$j][name] = $text['unknown'];
    }
    mysql_free_result($result);
}

function getVitalDates($row) {
    global $getPlace, $text;

	if($getPlace == 2) return;
    $vitalinfo = "";
    if ($row['allow_living']) {
		if($row['birthdate']) {
		    $vitalinfo .= $text['birthabbr'] . ' '.displayDate($row['birthdate']).', ';
		    if ($row['birthplace']) {
				$vitalinfo .= $row['birthplace'].', ';
		    }
		}
		if((!$row['birthdate'] || $getPlace == 3) && $row['altbirthdate']) {
			$vitalinfo .= $text['chrabbr'] . ' '.displayDate($row['altbirthdate']).', ';
			if ($row['altbirthplace']) {
			    $vitalinfo .= $row['altbirthplace'].', ';
			}
		}

		if ($row['deathdate']) {
		    $vitalinfo .= $text['deathabbr'] . ' '.displayDate($row['deathdate']).', ';
		    if ($row['deathplace']) {
			$vitalinfo .= $row['deathplace'].', ';
		    }
		}
		if((!$row['deathdate'] || $getPlace == 3) && $row['burialdate'] ) {
			$vitalinfo .= $text['burialabbr'] . ' '.displayDate($row['burialdate']).', ';
			if ($row['burialplace']) {
			    $vitalinfo .= $row['burialplace'];
			}
		}
   }

    // get rid of trailing commas
    if (strlen($vitalinfo) > 2) {
		$vitalinfo = substr_replace($vitalinfo, '', -2, 2);
    }
    return $vitalinfo;
}

function printHeader() {
    global $pdf, $rptFont, $rptFontSize, $hdrFont, $hdrFontSize, $title;

    $pdf->SetFont($hdrFont, 'B', $hdrFontSize);
    $thisy = $pdf->GetFontSize();
    $pdf->Cell(0, $thisy, $title, 0, 2, 'L');
    $pdf->SetY($pdf->GetY());
    $pdf->SetFont($rptFont,'',$rptFontSize);
    return ($pdf->GetY() + 0.02);
}

?>
