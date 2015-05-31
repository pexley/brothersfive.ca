<?php
// PDF Individual Report
// Author: Bret Rumsey
// Thanks to J. Kraber for his original implementation of this report.
//
include("begin.php");
include($cms['tngpath'] . "genlib.php");
include($cms['tngpath'] . "getlang.php");
$textpart = "getperson";
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
$tngprint = 1;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "personlib.php");

define('FPDF_FONTPATH', 'font/');
require($cms[tngpath] . 'tngpdf.php');

// define formatting defaults
$lineheight = 0.25;	// height of each row on the page
$textindent = 0.03;

// nothing to set here, just calculations
$linehalf = $lineheight / 2;

$pdf = new TNGPDF($orient, 'in', $pagesize);

// load fonts
$pdf->AddFont($hdrFont, 'B');
$pdf->AddFont($lblFont);
$pdf->AddFont($lblFont, 'B');
$pdf->AddFont($rptFont);
$pdf->AddFont($rptFont, 'B');

// compute the label width based on the longest string that will be displayed
$labelwidth = getMaxStringWidth(array($text['name'], $text['born'], $text['christened'], $text['died'], $text['buried'], $text['spouse'], $text['married']), $lblFont, 'B', $lblFontSize, ':');
if ($allow_lds) 
    $labelwidth = getMaxStringWidth(array($text['baptizedlds'], $text['endowedlds'], $text['sealedslds']), $lblFont, 'B', $lblFontSize, ':', $labelwidth);
$labelwidth += ($textindent * 4);

// set margins
$pdf->SetTopMargin($topmrg);
$pdf->SetLeftMargin($lftmrg);
$pdf->SetRightMargin($rtmrg);
$pdf->SetAutoPageBreak(1,$botmrg); // this sets the bottom margin for us

// PDF settings
$pdf->SetAuthor($dbowner);

// let's get started
$pdf->AddPage();
$paperdim = $pdf->GetPageSize();

// create a blank form if that's what they asked for
if ($blankform == 1) {
    // print Header
    $title = $text['indreport'];
    $pdf->SetTitle($title);

    // print the header and find out where we are on the page ($y)
    $y = printHeader();

    nameLine($text['name'], '', $text['gender'], '', $y, 'B');
    doubleLine($text['born'], '', $text['place'], '', $y);
    doubleLine($text['christened'], '', $text['place'], '', $y);
    doubleLine($text['died'], '', $text['place'], '', $y);
    doubleLine($text['buried'], '', $text['place'], '', $y);
    if ($allow_lds) {
	doubleLine($text['baptizedlds'], '', $text['place'], '', $y);
	doubleLine($text['endowedlds'], '', $text['place'], '', $y);
    }
    singleLine($text['spouse'], '', 'B');
    doubleLine($text['married'], '', $text['place'], '', $y);
    if ($allow_lds) {
	doubleLine($text['sealedslds'], '', $text['place'], '', $y);
    }
    childLine(1, '', $y);
    childLine(2, '', $y);
    childLine(3, '', $y);
    childLine(4, '', $y);
    childLine(5, '', $y);
    $pdf->SetFont($lblFont, 'B', $lblFontSize);
    $pdf->Rect($lftmrg, $y, $paperdim[w] - $lftmrg - $rtmrg, $lineheight);
    $pdf->SetXY($lftmrg + $textindent, $y + ($lineheight / 2));
    $pdf->Cell(0, 0, $text['general'] . ":", 0, 0, 'L');
    $y += $lineheight;
    $pdf->Rect($lftmrg, $y, $paperdim[w] - $lftmrg - $rtmrg, $paperdim[h] - $y - $botmrg);
}

// create a filled in form
else {
    $query = "SELECT firstname, lnprefix, lastname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, burialplace, birthplace, altbirthplace, deathplace, sex, living, branch
	FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
    $result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
    if ($result) {
	$row = mysql_fetch_assoc( $result );
	$row[allow_living] = !$row[living] || ( $allow_living && checkbranch($row[branch])) ? 1 : 0;
	$namestr = getName($row);
    }

    $title = $text['indreportfor'] . " $namestr";
    $pdf->SetTitle($title);

    $y = printHeader();
    nameLine($text['name'], $namestr, $text['gender'], $row['sex'], $y, 'B');

    // birth
    if ($row[allow_living]) 
	doubleLine($text['born'], displayDate($row[birthdate]), $text['place'], $row[birthplace], $y);
    else 
	doubleLine($text['born'], '', $text['place'], '', $y);

    // christening
    if ($row[allow_living])
	doubleLine($text['christened'], displayDate($row[altbirthdate]), $text['place'], $row[altbirthplace], $y);
    else 
	doubleLine($text['christened'], '', $text['place'], '', $y);

    // death
    if ($row[allow_living]) 
	doubleLine($text['died'], displayDate($row[deathdate]), $text['place'], $row[deathplace], $y);
    else
	doubleLine($text['died'], '', $text['place'], '', $y);

    // buried
    if ($row[allow_living])
	doubleLine($text['buried'], displayDate($row[burialdate]), $text['place'], $row[burialplace], $y);
    else
	doubleLine($text['buried'], '', $text['place'], '', $y);

    if ($allow_lds) {
	if ($row[allow_living]) {
	    doubleLine($text['baptizedlds'], displayDate($row[baptdate]), $text['place'], $row[baptplace], $y);
	    doubleLine($text['endowedlds'], displayDate($row[endldate]), $text['place'], $row[endlplace], $y);
	}
	else {
	    doubleLine($text['baptizedlds'], '', $text['place'], '', $y);
	    doubleLine($text['endowedlds'], '', $text['place'], '', $y);
	}
    }

    if ($row[allow_living]) {
	$query = "SELECT display, eventdate, eventplace, info FROM ($events_table, $eventtypes_table) WHERE persfamID = \"$personID\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID AND gedcom = \"$tree\" AND keep = \"1\" AND parenttag = \"\" ORDER BY ordernum, tag, description, eventdatetr, info, eventID";
	$custevents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	while ( $custevent = mysql_fetch_assoc( $custevents ) )	{
	    $displayval = getEventDisplay( $custevent[display] );
	    $fact = array();
	    if( $custevent[info] ) {
		$fact = checkXnote( $custevent[info] );
		if( $fact[1] ) {
		    $xnote = $fact[1];
		    array_pop( $fact );
		}
	    }
	    if($custevent['eventdate'] || $custevent['eventplace']) {
		doubleLine($displayval, displayDate($custevent['eventdate']), $text['place'], $custevent['eventplace'], $y);
	    }
	}
	mysql_free_result( $custevents );
    }

    // do parents
    $query = "SELECT personID, familyID, sealdate, sealplace, relationship FROM $children_table WHERE personID = \"$personID\" AND gedcom = \"$tree\" ORDER BY parentorder";
    $parents = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
    if ($parents && mysql_num_rows($parents)) {
	while ($parent = mysql_fetch_assoc($parents)) {
	    $query = "SELECT personID, lastname, lnprefix, firstname, prefix, suffix, nameorder, YEAR(birthdatetr) as birthyear, YEAR(deathdatetr) as deathyear, $people_table.living, $people_table.branch FROM $people_table, $families_table WHERE $people_table.personID = $families_table.husband AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
	    $gotfather = mysql_query($query) or die ("$text[cannotexecutequery]: $query");	
	    if ($gotfather) {
		$fathrow = mysql_fetch_assoc($gotfather);
		$fathrow[allow_living] = !$fathrow[living] || ($allow_living && checkbranch($fathrow[branch])) ? 1 : 0;
		if ($fathrow[firstname] || $fathrow[lastname]) {
		    $fathname = getName($fathrow);
		}
		$fathtext = generateYears($fathrow);
		singleLine($text['father'], "$fathname $fathtext");
	    }
	    else {
		singleLine($text['father'], '');
	    }

	    $query = "SELECT personID, lastname, lnprefix, firstname, prefix, suffix, nameorder, YEAR(birthdatetr) as birthyear, YEAR(deathdatetr) as deathyear, $people_table.living, $people_table.branch FROM $people_table, $families_table WHERE $people_table.personID = $families_table.wife AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
	    $gotmother = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	    if( $gotmother ) {
		$mothrow =  mysql_fetch_assoc( $gotmother );
		$mothrow[allow_living] = !$mothrow[living] || ($allow_living && checkbranch($mothrow[branch])) ? 1 : 0;
		if ($mothrow[firstname] || $mothrow[lastname]) {
		    $mothname = getName($mothrow);
		}
		$mothtext = generateYears($mothrow);
		singleLine($text['mother'], "$mothname $mothtext");
	    }
	    else {
		singleLine($text['mother'], '');
	    }
	    if ($allow_lds) {
		if ($row[allow_living]) {
		    doubleLine($text['sealedplds'], displayDate($parent[sealdate]), $text['place'], $row[sealplace], $y);
		}
		else {
		    doubleLine($text['sealedplds'], '', $text['place'], '', $y);
		}
	    }
	}
    }

    // print two empty fields
    else {
	singleLine($text['father'], '');
	singleLine($text['mother'], '');
    }

    if ($row['sex'] == 'M') {
	$spouse = 'wife';
	$spouseorder = 'husborder';
    }
    else if ($row['sex'] == 'F') {
	$spouse = 'husband';
	$spouseorder = 'wifeorder';
    }
    else {
	$spouseorder = '';
    }
    if ($spouseorder) 
	$query = "SELECT $spouse, familyID, living, branch, marrdate, marrdatetr, YEAR(marrdatetr) as marryear, MONTH(marrdatetr) as marrmonth, DAYOFMONTH(marrdatetr) as marrday, marrplace, sealdate, sealplace FROM $families_table WHERE ($families_table.husband = \"$personID\" OR $families_table.wife = \"$personID\") AND gedcom = \"$tree\" ORDER BY $spouseorder";
    else
	$query = "SELECT husband, wife, familyID, living, marrdate, marrdatetr, YEAR(marrdatetr) as marryear, MONTH(marrdatetr) as marrmonth, DAYOFMONTH(marrdatetr) as marrday, marrplace, sealdate, sealplace FROM $families_table WHERE ($families_table.husband = \"$personID\" OR $families_table.wife = \"$personID\") AND gedcom = \"$tree\"";
    $marriages = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
    while ($marriagerow = mysql_fetch_assoc($marriages)) {
	if (!$spouseorder)
	    $spouse = $marriagerow[husband] == $personID ? wife : husband;
	if ($marriagerow[$spouse]) {
	    $query = "SELECT firstname, lastname, lnprefix, birthdate, living, deathdate FROM $people_table WHERE personID = \"$marriagerow[$spouse]\" AND gedcom=\"$tree\"";
	    $spouseresult = mysql_query($query) or die("$text[cannotexecutequery]: $query");
	    $spouserow = mysql_fetch_assoc($spouseresult);
	    $spouserow[allow_living] = !$spouserow[living] || ($allow_living && checkbranch($spouserow[branch])) ? 1 : 0;
	    $namestr = getName($spouserow);
	    $spousetext = generateDates($spouserow);
	    singleLine($text['spouse'], "$namestr $spousetext", 'B');
	}
	if ($row[allow_living]) {
	    doubleLine($text['married'], displayDate($marriagerow[marrdate]), $text['place'], $marriagerow[marrplace], $y);
	}
	else {
	    doubleLine($text['married'], '', $text['place'], '', $y);
	}
	if ($allow_lds) {
	    if ($row[allow_living]) {
		doubleLine($text['sealedslds'], displayDate($marriagerow[sealdate]), $text['place'], $marriagerow[sealplace], $y);
	    } else {
		doubleLine($text['sealedslds'], '', $text['place'], '', $y);
	    }
	}

	// get the children from this marriage
	$query = "SELECT $people_table.personID as pID, firstname, lastname, lnprefix, YEAR(birthdatetr) as birthyear, birthdate, YEAR(deathdatetr) as deathyear, living FROM $people_table, $children_table WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = \"$marriagerow[familyID]\" AND $people_table.gedcom = \"$tree\" AND $children_table.gedcom = \"$tree\" ORDER by ordernum";
	$children = mysql_query($query) or die("$text[cannotexecutequery]: $query");
	if ($children && mysql_num_rows($children)) {
	    $childcnt = 1;
	    while ($child = mysql_fetch_assoc($children)) {
		$child[allow_living] = !$child[living] || ( $allow_living && checkbranch($child[branch])) ? 1 : 0;
		$namestr = getName($child);
		$childtext = generateYears($child);
		childLine($childcnt, "$namestr $childtext", $y);
		$childcnt++;
	    }
	}
    }

    // notes and such
    // draw the box to contain the notes
    $pdf->Rect($lftmrg, $y, $paperdim[w] - $lftmrg - $rtmrg, $lineheight);
    $pdf->SetFont($lblFont, 'B', $lblFontSize);
    $pdf->SetXY($lftmrg + $textindent, $y + ($lineheight / 2));
    $pdf->Cell(0, 0, $text['general'], 0, 0, 'L');
    $y += $lineheight;
    $pdf->Rect($lftmrg, $y, $paperdim[w] - $lftmrg - $rtmrg, $paperdim[h] - $y - $botmrg);

    if ($row[allow_living]) {
	$indnotes = getNotes($personID, 'I');
	$notes = '';
	$lasttitle = '---';
	foreach ($indnotes as $key => $note) {
	    if ($note[title] != $lasttitle) {
		if ($notes)
		    $notes .= "\n";
		if ($note[title])
		    $notes .= $note[title]."\n";
	    }
	    $notes .= $note[text];
	}
    }
    $notes = preg_replace("/<li>/", '', $notes);
    $notes = preg_replace("/<br\s*\/?>/", "", $notes);

    $pdf->SetFont($noteFont,'',$noteFontSize);
    $pdf->SetXY($lftmrg + $textindent, $y + ($lineheight / 2));

    $pdf->SetTopMargin($topmrg + ($pdf->GetFontSize() / 3));
    $pdf->MultiCell(0, 0.125, $notes, 0, 'L', 0, 0);

    // multicell will continue onto the next page... 
    // if that happens, we need to draw a box around the page for consistency
    // TODO: what happens if you have more than 1 additional page of notes?
    if($pdf->page > 1) {
	$y = $topmrg;
	$pdf->Rect($lftmrg, $y, $paperdim[w] - $lftmrg - $rtmrg, $paperdim[h] - $y - $botmrg);
    }
}

// print it out
$pdf->Output();

// generateDates
function generateDates($ind) {
    if ($ind[allow_living]) {
	if ($ind[birthdate] == '') { $bdate = '    '; } else { $bdate = displayDate($ind[birthdate]); }
	if ($ind[deathdate] == '') { $ddate = '    '; } else { $ddate = displayDate($ind[deathdate]); }
	$result = "(${bdate} - $ddate)";
    } else {
	$result = '';
    }
    return $result;
}

// generateYears
function generateYears($ind) {
    if ($ind[allow_living]) {
	if ($ind[birthyear] == 0) { $byear = '     '; } else { $byear = $ind[birthyear]; }
	if ($ind[deathyear] == 0) { $dyear = '     '; } else { $dyear = $ind[deathyear]; }
	// todo need to print out differently if we have text in the date field (like bef, bet, aft. etc).
	$result = "(${byear}-$dyear)";
    }
    else {
	$result = '';
    }
    return $result;
}

// childLine
function childLine($childnum, $data) {
    global $textindent, $pdf, $paperdim, $lftmrg, $rtmrg, $botmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFont, $lblFontSize, $text;
    global $y, $linehalf, $labelwidth;

    $pdf->Rect($lftmrg, $y, $paperdim[w] - $lftmrg - $rtmrg, $lineheight);
    $pdf->SetFont($lblFont, 'B', $lblFontSize);
    if ($childnum == 1) {
	$pdf->SetXY($lftmrg + $textindent, $y + $linehalf);
	$pdf->Cell(0, 0, $text['children'] . ":", 0, 0, 'L');
    }
    $pdf->SetXY($labelwidth + $lftmrg - $textindent - 0.1, $y + $linehalf);
    $pdf->Cell(0.1, 0, "$childnum", 0, 0, 'R');
    $pdf->Line($labelwidth + $lftmrg, $y, $labelwidth + $lftmrg, $y + $lineheight);
    $pdf->SetFont($rptFont, 'B', $rptFontSize);
    $pdf->SetXY($labelwidth + $textindent + $lftmrg, $y + $linehalf);
    $pdf->Cell(0, 0, $data, 0, 0, 'L');

    $y += $lineheight; 
    if ($y + $lineheight > $paperdim[h] - $botmrg) { 
	$pdf->AddPage(); 
	$y = printHeader(); 
    }
}

// singleLine
function singleLine($label, $data, $datastyle = '') {
    global $textindent, $pdf, $paperdim, $lftmrg, $rtmrg, $botmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFont, $lblFontSize;
    global $y, $linehalf, $labelwidth;

    $pdf->Rect($lftmrg, $y, $paperdim[w] - $lftmrg - $rtmrg, $lineheight);
    $pdf->SetFont($lblFont, 'B', $lblFontSize);
    $pdf->SetXY($lftmrg + $textindent, $y + $linehalf);
    $pdf->Cell(0, 0, $label . ":", 0, 0, 'L');
    $pdf->Line($labelwidth+$lftmrg, $y, $labelwidth+$lftmrg, $y + $lineheight);
    $pdf->SetFont($rptFont, $datastyle, $rptFontSize);
    $pdf->SetXY($labelwidth+$textindent+$lftmrg, $y + $linehalf);
    $pdf->CellFit(0, 0, $data, 0, 0, 'L', 0, '', 1, 0);

    $y += $lineheight; 
    if ($y + $lineheight > $paperdim[h] - $botmrg) { 
	$pdf->AddPage(); 
	$y = printHeader(); 
    }
}

// nameLine
function nameLine($label1, $data1, $label2, $data2) {
    global $textindent, $pdf, $paperdim, $lftmrg, $rtmrg, $botmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFont, $lblFontSize;
    global $y, $linehalf, $labelwidth;

    $line2loc = $paperdim[w] * 0.8;
    $pdf->SetFont($lblFont, 'B', $lblFontSize);
    $box2w = $pdf->GetStringWidth($label2.':') + ($textindent * 4);

    $pdf->Rect($lftmrg, $y, $paperdim[w] - $lftmrg - $rtmrg, $lineheight);
    $pdf->SetXY($lftmrg + $textindent, $y + $linehalf);
    $pdf->Cell(0, 0, $label1 . ":", 0, 0, 'L');
    $pdf->Line($labelwidth+$lftmrg, $y, $labelwidth+$lftmrg, $y + $lineheight);
    $pdf->SetFont($rptFont, 'B', $rptFontSize);
    $pdf->SetXY($labelwidth + $textindent+$lftmrg, $y + $linehalf);
    $pdf->CellFit(0, 0, $data1, 0, 0, 'L', 0, '', 1, 0);
    $pdf->Line($line2loc, $y, $line2loc, $y + $lineheight);
    $pdf->Line($line2loc + $box2w, $y, $line2loc + $box2w, $y + $lineheight);
    $pdf->SetXY($line2loc + $textindent, $y + $linehalf);
    $pdf->SetFont($lblFont, 'B', $lblFontSize);
    $pdf->Cell(0, 0, $label2 . ":", 0, 0, 'L');
    $pdf->SetXY($line2loc + $textindent + $box2w, $y + $linehalf);
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $pdf->CellFit(0, 0, $data2, 0, 0, 'L', 0, '', 1, 0);

    $y += $lineheight; 
    if ($y + $lineheight > $paperdim[h] - $botmrg) { 
	$pdf->AddPage(); 
	$y = printHeader(); 
    }
}

// doubleLine
function doubleLine($label1, $data1, $label2, $data2) {
    global $textindent, $pdf, $paperdim, $lftmrg, $rtmrg, $botmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFont, $lblFontSize;
    global $y, $linehalf, $labelwidth;

    $line2loc = 3.0+$lftmrg;
    $pdf->SetFont($lblFont, 'B', $lblFontSize);
    $box2w = $pdf->GetStringWidth($label2.':') + ($textindent * 4);

    $pdf->Rect($lftmrg, $y, $paperdim[w] - $lftmrg - $rtmrg, $lineheight);
    $pdf->SetXY($lftmrg + $textindent, $y + $linehalf);
    $pdf->CellFit($labelwidth, 0, $label1 . ":", 0, 0, 'L', 0, '', 1, 0);
    $pdf->Line($labelwidth + $lftmrg, $y, $labelwidth + $lftmrg, $y + $lineheight);
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $pdf->SetXY($labelwidth + $lftmrg + $textindent, $y + $linehalf);
    $pdf->CellFit(0, 0, $data1, 0, 0, 'L', 0, '', 1, 0);

    $pdf->Line($line2loc, $y, $line2loc, $y + $lineheight);
    $pdf->Line($line2loc + $box2w, $y, $line2loc + $box2w, $y + $lineheight);
    $pdf->SetXY($line2loc + $textindent, $y + $linehalf);
    $pdf->SetFont($lblFont, 'B', $lblFontSize);
    $pdf->Cell(0, 0, $label2 . ":", 0, 0, 'L');
    $pdf->SetXY($line2loc + $textindent + $box2w, $y + $linehalf);
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $pdf->CellFit(0, 0, $data2, 0, 0, 'L', 0, '', 1, 0);

    $y += $lineheight; 
    if ($y + $lineheight > $paperdim[h] - $botmrg) { 
	$pdf->AddPage(); 
	$y = printHeader(); 
    }
}

function printHeader() {
    global $pdf, $hdrFont, $hdrFontSize, $title;

    $pdf->SetFont($hdrFont, 'B', $hdrFontSize);
    $thisy = $pdf->GetFontSize();
    $pdf->Cell(0, $thisy, $title, 0, 2, 'L');
    return ($pdf->GetY() + 0.02);
}

function getMaxStringWidth($strings, $font, $style, $size, $append='', $oldmax=0) {
    global $pdf;

    $max = $oldmax;
    $pdf->SetFont($font, $style, $size);
    foreach($strings as $string) {
	$width = $pdf->GetStringWidth($string.$append);
	if ($width > $max)
	    $max = $width;
    }
    return $max;
}

?>
