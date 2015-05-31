<?php
include("begin.php");
include($subroot . "pedconfig.php");
include($cms['tngpath'] . "genlib.php");
if(!$personID) die("no args");

$pedigreetext_url = getURL( "pedigreetext", 1 );
$ahnentafel_url = getURL( "ahnentafel", 1 );
if( $display == "textonly" || ( !$display && $pedigree[usepopups] == -1 ) ) {
	header( "Location: $pedigreetext_url" . "personID=$personID&tree=$tree&generations=$generations");
}
elseif( $display == "ahnentafel" || ( !$display && $pedigree[usepopups] == 3 ) ) {
	header( "Location: $ahnentafel_url" . "personID=$personID&tree=$tree&generations=$generations");
}

$textpart = "pedigree";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
@set_time_limit(0);
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php");
include($cms['tngpath'] . "browserinfo.php");

$pedigree_url = getURL( "pedigree", 1 );
$getperson_url = getURL( "getperson", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$extrastree_url = getURL( "extrastree", 1 );
$pdfform_url = getURL( "pdfform", 1 );

$flags['scripting'] = "";


$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row[branch] );
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$pedname = getName( $row );
	$logname = $nonames && $row[living] ? $text[living] : $pedname;
	$disallowgedcreate = $row[disallowgedcreate];
	mysql_free_result($result);
}

if( !$display ) {
	if( $pedigree[usepopups] == 1)
		$display = "standard";
	elseif( $pedigree[usepopups] == 0 )
		$display = "box";
	else
		$display = "compact";
}

if( $display == "standard" ) {
	$slinkstyle = "3";
	$blinkstyle = $clinkstyle = "";
}
elseif( $display == "box" ) {
	$slinkstyle = $clinkstyle = "";
	$blinkstyle = "3";
}
else {
	$slinkstyle = $blinkstyle = "";
	$clinkstyle = "3";
}

// subroutines used to single line of popup info box
// see if "popup info present" arrow is present
if (file_exists($cms[tngpath] . "ArrowDown.gif")) {
	$downarrow = @GetImageSize($cms[tngpath] . "ArrowDown.gif");
	$pedigree[downarroww] = $downarrow[0];
	$pedigree[downarrowh] = $downarrow[1];
	$pedigree[downarrow] = true;
}
else
	$pedigree[downarrow] = false;

// see if off-page connector arrow is present
if (file_exists($cms[tngpath] . "ArrowRight.gif")) {
	$offpageimg = @GetImageSize($cms[tngpath] . "ArrowRight.gif");
	$offpageimgw = $offpageimg[0];
	$offpageimgh = $offpageimg[1];
	$pedigree[offpagelink] = "<img border=\"0\" src=\"$cms[tngpath]" . "ArrowRight.gif\" $offpageimg[3] title=\"$text[popupnote2]\" alt=\"$text[popupnote2]\">";
}
else
	$pedigree[offpagelink] = "<b>&gt;</b>";

if (file_exists($cms[tngpath] . "ArrowLeft.gif")) {
	$leftarrowimg = @GetImageSize($cms[tngpath] . "ArrowLeft.gif");
	$leftarrowimgw = $leftarrowimg[0];
	$leftarrowimgh = $leftarrowimg[1];
	$pedigree[leftarrowlink] = "<img border=\"0\" src=\"$cms[tngpath]" . "ArrowLeft.gif\" $leftarrowimg[3] title=\"$text[popupnote2]\" alt=\"$text[popupnote2]\">";
}
else
	$pedigree[leftarrowlink] = "<b>&gt;</b>";

// see if chart link image is present
if (file_exists($cms[tngpath] . "Chart.gif")) {
	$chartlinkimg = @GetImageSize($cms[tngpath] . "Chart.gif");
	$pedigree[chartlink] = "<img src=\"$cms[tngpath]" . "Chart.gif\" border=\"0\" $chartlinkimg[3] title=\"$text[popupnote2]\" alt=\"$text[popupnote2]\">";
}
else
	$pedigree[chartlink] = "<span class=\"normal\"><b>P</b></span>";

if( $display == "standard" ) {
	$pedigree[boxheight] = $pedigree[puboxheight];
	$pedigree[boxwidth] = $pedigree[puboxwidth];
	$pedigree[boxalign] = $pedigree[puboxalign];
	$pedigree[boxheightshift] = $pedigree[puboxheightshift];
}

if( $display == "compact" ) {
	$pedigree[usepopups_real] = 0;
	$pedigree[boxHsep] = 7;
	$pedigree[boxheight] = 16;
	$pedigree[boxheightshift] = 0;
	$pedigree[boxnamesize] = 8;
	$pedigree[namesizeshift] = 0;
	$pedigree[cellpad] = 0;
	$pedigree[boxwidth] -= 50;
	$pedigree[boxVsep] = 5;
	$pedigree[shadowoffset] = 1;
	$namepad = "&nbsp;";
}
else {
	$pedigree[boxnamesize] = 10;
	$pedigree[usepopups_real] = 1;
	$pedigree[cellpad] = 5;
	if( $pedigree[boxheight] < 21 ) $pedigree[boxheight]  = 21;
	if( $pedigree[boxheightshift] > 0  )  $pedigree[boxheightshift] = -1 * $pedigree[boxheightshift];
	if( $pedigree[boxHsep] < 7  ) $pedigree[boxHsep] = 7 ;
	if( $pedigree[boxVsep] < 3 + $pedigree[shadowoffset] + (2*$pedigree[borderwidth]) + ($pedigree[downarrow] ? $pedigree[downarrowh] : 15) ) $pedigree[boxVsep] = 3 + $pedigree[shadowoffset] + (2*$pedigree[borderwidth]) + ($pedigree[downarrow] ? $pedigree[downarrowh] : 15) ;
	$namepad = "";
}

// MOST OF THIS COULD BE HANDLED WITH JAVASCRIPT VALIDATION IN editpedconfig.php
// set boundary values if needed    
if( $pedigree[leftindent] < 0  ) $pedigree[leftindent]  = 0 ;
if( $pedigree[boxwidth] < 21 ) $pedigree[boxwidth]   = 21;
if( $pedigree[borderwidth] < 1  ) $pedigree[borderwidth] = 1 ;
if( $pedigree[linewidth] < 1  ) $pedigree[linewidth] = 1 ;

// negative numbers ok for $pedigree[shadowoffset], $pedigree[colorshift], $fontshift)
// some values should be odd numbers ...    
if ($pedigree[boxwidth]  % 2 == 0) $pedigree[boxwidth]++;
if ($pedigree[boxheight] % 2 == 0) $pedigree[boxheight]++;
if ($pedigree[boxHsep]   % 2 == 0) $pedigree[boxHsep]++;
if ($pedigree[boxVsep]   % 2 == 0) $pedigree[boxVsep]++;
// and some even ...
if ($pedigree[boxheightshift] % 2 != 0) $pedigree[boxheightshift]++;

// if we are going to include photos, do we have what we need?
if ($pedigree[inclphotos] && (trim($photopath) == "" || trim($photosext) == "" )) $pedigree[inclphotos] = false;

// let's not shrink a box into nothingness
// boxheight must support at least 16 generations and not shrink below 16 pixels
if ($pedigree[boxheightshift] && ( $pedigree[boxheight] < -16 * $pedigree[boxheightshift] + 16 ) ) { $pedigree[boxheight] = -16 * $pedigree[boxheightshift] + 16 ; }

// how many generations to show?
if( !$pedigree[maxgen] ) $pedigree[maxgen] = 6;
if( $generations > $pedigree[maxgen] )
    $generations = intval($pedigree[maxgen]);
elseif( !$generations )
    $generations = $pedigree[initpedgens] >= 2 ? intval($pedigree[initpedgens]) : 2;
else
	$generations = intval( $generations );
$pedmax = pow( 2, $generations );

// alternate parent display?
$parentset = $parentset ? intval($parentset) : 0;
    
// how much vertical real estate will we need?
$pedigree[maxheight] = pow( 2, ( $generations - 1 ) ) * ( ( $pedigree[boxheight] + ( $pedigree[boxheightshift] * ( $generations - 1 ) ) ) + $pedigree[boxVsep] );

// how much horizontal real estate will we need?
$pedigree[maxwidth] = $generations * ( $pedigree[boxwidth] + $pedigree[boxHsep] );

$key = $personID;
$pedigree[baseR] = hexdec( substr( $pedigree[boxcolor], 1, 2 ) );
$pedigree[baseG] = hexdec( substr( $pedigree[boxcolor], 3, 2 ) );
$pedigree[baseB] = hexdec( substr( $pedigree[boxcolor], 5, 2 ) );

if( $pedigree[colorshift] > 0 ) {
	$extreme = $pedigree[baseR] < $pedigree[baseG] ? $pedigree[baseR] : $pedigree[baseG];
	$extreme = $extreme < $pedigree[baseB] ? $extreme : $pedigree[baseB];
}
elseif( $pedigree[colorshift] < 0 ) {
	$extreme = $pedigree[baseR] > $pedigree[baseG] ? $pedigree[baseR] : $pedigree[baseG];
	$extreme = $extreme > $pedigree[baseB] ? $extreme : $pedigree[baseB];
}
$pedigree[colorshift] = round( $pedigree[colorshift] / 100 * $extreme / ($generations + 1) );
$pedigree[phototree] = $tree;
if( $tree ) $pedigree[phototree] .= ".";

$pedigree[bullet] = "&bull;";
if( !$pedigree[hideempty] ) $pedigree[hideempty] = 0;

function getColor( $shifts ) {
	global $pedigree;

	$shiftval = $shifts * $pedigree[colorshift];
	$R = $pedigree[baseR] + $shiftval;
	$G = $pedigree[baseG] + $shiftval;
	$B = $pedigree[baseB] + $shiftval;
	if ( $R > 255 ) $R = 255; if ( $R < 0 ) $R = 0;
	if ( $G > 255 ) $G = 255; if ( $G < 0 ) $G = 0;
	if ( $B > 255 ) $B = 255; if ( $B < 0 ) $B = 0;
	$R = str_pad( dechex($R), 2, "0", STR_PAD_LEFT );
	$G = str_pad( dechex($G), 2, "0", STR_PAD_LEFT );
	$B = str_pad( dechex($B), 2, "0", STR_PAD_LEFT );
	return "#$R$G$B";
}

function showBox( $generation, $slot ) {
	global $pedigree, $generations, $pedmax, $pedoptions, $boxes, $flags, $offpageimgh, $offpageimgw, $cms, $browser;

	// set pointer to next father/mother pair
	$nextslot = $slot * 2;

	// compute box height to use
	// -  first box height is defined by config parm [$pedigree[boxheight]].
	// -  boxes of each subsequent generation shrunk according to config parm [$pedigree[boxheightshift]] (which may be zero, in which case all boxes will be the same height).
	// -  some minimums and defaults are enforced so that we don't get into trouble shrinking the heights to negative numbers (which would be a bad thing).
	$boxheighttouse = $pedigree[boxheight] + ( $pedigree[boxheightshift] * ( $generation - 1) );

	// will we have any popup info?
	$popupinfo = false;

	// compute horizontal box offset
	// -  first box horizontal offset is defined by config parm [$pedigree[leftindent]].
	// -  boxes for each subsequent generation are offset horizontally according to config parms [$pedigree[boxwidth] and [$pedigree[boxHsep]]. The latter value has a minimum setting enforced in the earlier idiot checks so that we don't get negative offsets and so there's at least *some* room for connectors.
	$offsetH = $pedigree[leftindent] + ( $generation - 1 ) * ( $pedigree[boxwidth] + $pedigree[boxHsep] ) ;

	// compute vertical separation
	// -  the vertical separation between boxes of each generation are different because the box height for each generation may be different, and the boxes need to line up according to father/mother pair of the subsequent generation
	// -  we can back into the vertical separation because we can know, for the *last* generation to be displayed, the box size (computed above) and the vertical separation of those boxes (via config parm [$sepV]). This allows us to  calculate the height of the space to be used for the *last* generation
	//    display (computed as $pedigree[maxheight]). Given this, and the height of *this*  generation's boxes, we can do the following math to derive the amount of space that must exist between *this* generation's boxes to result in their being properly aligned vis-a-vis the *next* generation's boxes
	$sepV = intval ( $pedigree[maxheight] - ( pow( 2, ( $generation - 1 ) ) * $boxheighttouse ) ) / pow( 2, ( $generation - 1 ) ) ;

	// compute vertical offset for first box per generation
	// -  now we need to calculate the 'base" offset vertically for *this* generation's first (or, top) box.  We computed the separation required above so support proper alignment. This calulation is also necessary to obtain proper vertical alignment
	$offsetV = ( $pedigree[maxheight] - $pedigree[boxVsep] - ( pow( 2, ( $generation - 1 ) ) * ( $boxheighttouse + $sepV ) - $sepV ) ) / 2;

	// finally, compute the offset for the box we're to build
	// -  finally, we need to figure out where the specific box for *this* generation needs to be placed. This math isn't so bad, since it's a linear equaltion based upon slot # ($slot), initial offset ($offsetV), box height ($boxheighttouse), and vertical separation ($sepV).
	$offsetV = intval ( $pedigree[borderwidth] + ( $slot - pow( 2, ( $generation - 1 ) ) ) * ( $boxheighttouse + $sepV ) + $offsetV ) ;

	// compute box color
	// -  if the config parm [$pedigree[colorshift]] is anything other than zero this math will reduce each primary color value (red,green,blue),  respectively, but the color shift value
	// -  if $pedigree[colorshift] = 0, all this code spits out the same value as  defined by the config parm [$pedigree[boxcolor]]
	// -  otherwise the color will "shift" up or down (closer to white or closer to black)
	$boxcolortouse = getColor( $generation - 1 );

	// compute font sizes
	// -  this will adjust font size values for subsequent generation box data
	// -  note that the shift can be different for the names portion and for the dates portion.  (Dates portion is either displayed in the box or in the popup box, depending upon the config parm [$pedigree[usepopups]].)
	// -  while decimal values are allowed for the config parms [$pedigree[namesizeshift]] and [$pedigree[datessizeshift]], rounding is done here so that only integer values will be used in the HTML strings. This means that some side-by-side generations' boxes will have the same font sizes.
	// -  Notwithstanding, the font sizes are never permitted to be less than 6 points
	$namefontsztouse    = intval( $pedigree[boxnamesize]   + ($generation - 1) * $pedigree[namesizeshift] );
	$datesfontsztouse   = intval( $pedigree[boxdatessize]  + ($generation - 1) * $pedigree[datessizeshift] );
	$popupinfosizetouse = intval( $pedigree[popupinfosize] + ($generation - 1) * $pedigree[popupinfosizeshift] );
	if ($namefontsztouse    < 7) $namefontsztouse    = 7;
	if ($datesfontsztouse   < 7) $datesfontsztouse   = 7;
	if ($popupinfosizetouse < 7) $popupinfosizetouse = 7;

	//... include trace (maybe)
	$boxes .= "\n<!-- box for slot $slot -->\n";
	if( $slot == 1 ) {
		$flags['scripting'] .=  "#leftarrow { position:absolute; visibility:hidden; top:" . ( $offsetV + intval( ($boxheighttouse - $offpageimgh) / 2) + 1 ) . "px; left:$offsetH" . "px;z-index:5; }\n";
		$boxes .= "<div id=\"leftarrow\">\n";
		$boxes .= "</div>\n";

		$boxes .= "<div class=\"popup\" id=\"popupleft\" style=\" top:" . ( $offsetV + intval( ($boxheighttouse - $offpageimgh) / 2) + 1 ) . "px; left:" . ($offsetH - $pedigree[borderwidth] + round($pedigree[shadowoffset]/2)) . "px;\" onmouseover=\"cancelTimer('left')\" onmouseout=\"setTimer('left')\">\n";
		$boxes .= "</div>\n";

		$pedigree[leftindent] += $offpageimgw + $pedigree[shadowoffset] + 3;
		$offsetH += $offpageimgw + $pedigree[shadowoffset] + 3;
		$flags['scripting'] .= "#popleft { font-size:$popupinfosizetouse" . "pt; }\n";
		$flags['scripting'] .= "#popabbrleft { font-size:$popupinfosizetouse" . "pt; }\n";
	}
	if($browser == "IE6")
		$flags['scripting'] .= "#img$slot { height:" . ($boxheighttouse - ( $pedigree[cellpad] * 2 )) . "px; }\n";
	else {
		$maxside = $boxheighttouse - ( $pedigree['cellpad'] * 2 );
   		$flags['scripting'] .= "#img$slot {max-width:" . $maxside . "px; max-height:" . $maxside . "px;}\n";
	}

	//start box
	$boxes .= "<div id=\"box$slot\" class=\"box\" style=\"background-color:$boxcolortouse; top:" . ($offsetV-$pedigree[borderwidth]) . "px; left:" . ($offsetH-$pedigree[borderwidth]) . "px; height:$boxheighttouse" . "px; width:$pedigree[boxwidth]" . "px; z-index:5; border:$pedigree[borderwidth]px solid $pedigree[bordercolor];overflow:hidden;\"></div>\n";
	//end box

	// build the pop-up information box
	$boxes .= "\n<!-- popup for $name -->\n\n";

	// lay a down arrow below the box to indicate a drop-down has data
	$boxes .= "<div class=\"downarrow\" id=\"downarrow$slot\" style=\"top:" . ($offsetV + $boxheighttouse + $pedigree[borderwidth] + $pedigree[shadowoffset] + 1) . "px;left:" . ($offsetH + intval(($pedigree[boxwidth] - $pedigree[downarroww])/2) - 1) . "px;\">\n";

	$boxes .= "<a href=\"#\" onmouse$pedigree[event]=\"showPopup($slot, $offsetV,$boxheighttouse)\"><img src=\"$cms[tngpath]" . "ArrowDown.gif\" border=\"0\" width=\"$pedigree[downarroww]\" height=\"$pedigree[downarrowh]\"  alt=\"\"></a></div>\n";

	if( $pedigree[usepopups_real] ) {
		//start the block
		$boxes .= "<div class=\"popup\" id=\"popup$slot\" style=\"left:" . ($offsetH - $pedigree[borderwidth] + round($pedigree[shadowoffset]/2)) . "px;\" onmouseover=\"cancelTimer($slot)\" onmouseout=\"setTimer($slot)\">\n";

		//end popup
		$boxes .= "</div>\n";
	}

	$boxes .= "\n<!-- box outline and shadow for slot $slot -->\n";

	//line & shadow
	//$boxes .= "<div class=\"border\" id=\"border$slot" . "_1\" style=\"top:" . ($offsetV-$pedigree[borderwidth]) . "px; left:" . ($offsetH-$pedigree[borderwidth]) . "px; height:" . ($boxheighttouse+(2*$pedigree[borderwidth])) . "px; width:" . ($pedigree[boxwidth]+(2*$pedigree[borderwidth])) . "px; z-index:4;\"></div>\n";
	$boxes .= "<div class=\"shadow\" id=\"shadow$slot" . "_1\" style=\"top:" . ($offsetV-$pedigree[borderwidth]+$pedigree[shadowoffset]) . "px; left:" . ($offsetH-$pedigree[borderwidth]+$pedigree[shadowoffset]) . "px; height:" . ($boxheighttouse+(2*$pedigree[borderwidth])) . "px; width:" . ($pedigree[boxwidth]+(2*$pedigree[borderwidth])) . "px;\"></div>\n";

	// build left horizontal lines & shadows (except for first generation)
	if ($generation != 1) {
		$boxes .= "<div class=\"border\" id=\"border$slot" . "_2\" style=\"top:" . ($offsetV + intval($boxheighttouse/2) - intval($pedigree[linewidth]/2)) . "px; left:" . ($offsetH - intval($pedigree[boxHsep]/2)) . "px; height:$pedigree[linewidth]" . "px; width:" . (intval($pedigree[boxHsep]/2) + 2) . "px;\"></div>\n";
		$boxes .= "<div class=\"shadow\" id=\"shadow$slot" . "_2\" style=\"top:" . ($offsetV + intval($boxheighttouse/2) - intval($pedigree[linewidth]/2) + $pedigree[shadowoffset] + 1) . "px;left:" . (($offsetH - intval($pedigree[boxHsep]/2)) + $pedigree[shadowoffset] + 1) . "px; height:$pedigree[linewidth]" . "px; width:" . (intval($pedigree[boxHsep]/2) + 2) . "px;\"></div>\n";
	}

	// build right horizontal line & shadow (except for last generation)
	if ($generation != $generations) {
		$boxes .= "<div class=\"border\" id=\"border$slot" . "_3\" style=\"top:" . ($offsetV + intval($boxheighttouse/2) - intval($pedigree[linewidth]/2)) . "px; left:" . ($offsetH + $pedigree[boxwidth]) . "px; height:$pedigree[linewidth]" . "px; width:" . (intval($pedigree[boxHsep]/2) + 1) . "px;\"></div>\n";
		$boxes .= "<div class=\"shadow\" id=\"shadow$slot" . "_3\" style=\"top:" . ($offsetV + intval($boxheighttouse/2) - intval($pedigree[linewidth]/2) + $pedigree[shadowoffset] + 1) . "px; left:" . ($offsetH + $pedigree[boxwidth] + $pedigree[shadowoffset] + 1) . "px; height:$pedigree[linewidth]" . "px; width:" . (intval($pedigree[boxHsep]/2) + 1) . "px;\"></div>\n";
	}

	// build vertical line & shadow
	if ($generation != 1) {
		if( $slot % 2 ==0 ) {  //father
			$boxes .= "<div class=\"border\" id=\"border$slot" . "_4\" style=\"top:" . ($offsetV + intval($boxheighttouse/2) - intval($pedigree[linewidth]/2)). "px; left:" . ($offsetH - intval($pedigree[boxHsep]/2)) . "px; height:" . intval(1+($sepV + $boxheighttouse)/2) . "px; width:$pedigree[linewidth]" . "px;\"></div>\n";
			$boxes .= "<div class=\"shadow\" id=\"shadow$slot" . "_4\" style=\"top:" . ($offsetV + intval($boxheighttouse/2) - intval($pedigree[linewidth]/2) + $pedigree[shadowoffset] + 1) . "px; left:" . ($offsetH - intval($pedigree[boxHsep]/2) + $pedigree[shadowoffset] + 1) . "px; height:" . intval(1+($sepV + $boxheighttouse)/2) . "px; width:$pedigree[linewidth]" . "px;\"></div>\n";
		}
		else { //mother
			$boxes .= "<div class=\"border\" id=\"border$slot" . "_5\" style=\"top:" . ($offsetV - intval($pedigree[linewidth]/2) - intval($sepV/2)). "px; left:" . ($offsetH - intval($pedigree[boxHsep]/2)) . "px; height:" . intval(($sepV + $boxheighttouse)/2) . "px; width:$pedigree[linewidth]" . "px;\"></div>\n";
			$boxes .= "<div class=\"shadow\" id=\"shadow$slot" . "_5\" style=\"top:" . ($offsetV - intval($pedigree[linewidth]/2) - intval($sepV/2) + $pedigree[shadowoffset] + 1) . "px; left:" . ($offsetH - intval($pedigree[boxHsep]/2) + $pedigree[shadowoffset] + 1) . "px; height:" . intval(($sepV + $boxheighttouse)/2) . "px; width:$pedigree[linewidth]" . "px;\"></div>\n";
		}
	}

	// see if we should include off-page connector
	if ( ( $nextslot >= $pedmax ) ) {
		$boxes .= "<div class=\"offpagearrow\" id=\"offpage$slot\" style=\"top:" . ( $offsetV + intval( ($boxheighttouse - $offpageimgh) / 2) + 1 ) . "px; left:" . ($offsetH + $pedigree[boxwidth] + $pedigree[borderwidth] + $pedigree[shadowoffset] + 3 ) . "px;\"><a href=\"javascript:getNewFamilies(";
		$boxes .= $slot < ( pow( 2, $generations - 1 ) * 3 / 2 ) ? "topparams,1,'M'" : "botparams,1,'F'";
		$boxes .= ");\">$pedigree[offpagelink]</a></div>\n";
	}

	// do the look-ahead

	$generation++;
	if( $nextslot < $pedmax ) {
		showBox( $generation, $nextslot );
		$nextslot++;
		showBox( $generation, $nextslot );
	}
}

if( !$tngprint ) $tngprint = 0;
$flags['scripting'] .= "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "net.js\"></script>\n";
$flags['scripting'] .= "<script type=\"text/javascript\">\n";
$flags['scripting'] .= "var lastpopup = '';\n";
$flags['scripting'] .= "var tree = '$tree';\n";
$flags['scripting'] .= "var tnglitbox;\n";
$flags['scripting'] .= "var getperson_url = '$getperson_url';\n";
$flags['scripting'] .= "var pedigree_url = '$pedigree_url';\n";
$flags['scripting'] .= "var pedigreetext_url = '$pedigreetext_url';\n";
$flags['scripting'] .= "var extrastree_url = '$extrastree_url';\n";
$flags['scripting'] .= "var ahnentafel_url = '$ahnentafel_url';\n";
$flags['scripting'] .= "var familygroup_url = '$familygroup_url';\n";
$flags['scripting'] .= "var slotceiling = $pedmax;\n";
$flags['scripting'] .= "var slotceiling_minus1 = " . ( pow( 2, $generations - 1 ) ) . ";\n";
$flags['scripting'] .= "var display = '$display';\n";
$flags['scripting'] .= "var pedcellpad = $pedigree[cellpad];\n";
$flags['scripting'] .= "var pedboxalign = '$pedigree[boxalign]';\n";
$flags['scripting'] .= "var usepopups = $pedigree[usepopups_real];\n";
$flags['scripting'] .= "var popupchartlinks = $pedigree[popupchartlinks];\n";
$flags['scripting'] .= "var popupkids = $pedigree[popupkids];\n";
$flags['scripting'] .= "var popupspouses = $pedigree[popupspouses];\n";
$flags['scripting'] .= "var popuptimer = $pedigree[popuptimer];\n";
$flags['scripting'] .= "var pedborderwidth = $pedigree[borderwidth];\n";
$flags['scripting'] .= "var pedbordercolor = '$pedigree[bordercolor]';\n";
$flags['scripting'] .= "var pedbullet = '$pedigree[bullet]';\n";
$flags['scripting'] .= "var emptycolor = '$pedigree[emptycolor]';\n";
$flags['scripting'] .= "var hideempty = $pedigree[hideempty];\n";
$flags['scripting'] .= "var leftarrowimg = '$pedigree[leftarrowlink]';\n";
$flags['scripting'] .= "var namepad = '$namepad';\n";
$flags['scripting'] .= "var allow_add = $allow_add;\n";
$flags['scripting'] .= "var cmstngpath = '$cms[tngpath]';\n";
$flags['scripting'] .= "var chartlink = '$pedigree[chartlink]';\n";
$flags['scripting'] .= "var personID = '$personID';\n";
$flags['scripting'] .= "var parentset = $parentset;\n";
$flags['scripting'] .= "var generations = $generations;\n";
$flags['scripting'] .= "var tngprint = $tngprint;\n";

$flags['scripting'] .= "var unknown = '$text[unknownlit]';\n";
$flags['scripting'] .= "var txt_parents = '$text[parents]';\n";
$flags['scripting'] .= "var txt_children = '$text[children]';\n";
$flags['scripting'] .= "var txt_family = '$text[family]';\n";
$flags['scripting'] .= "var txt_addfam = '$text[addnewfam]';\n";
$flags['scripting'] .= "var txt_editfam = '$text[editfam]';\n";
$flags['scripting'] .= "var txt_groupsheet = '$text[groupsheet]';\n";

$flags['scripting'] .= "var families = new Array(), people = new Array(); endslots = new Array(), slots = new Array();\n";
$flags['scripting'] .= "var endslotctr;\n";
$flags['scripting'] .= "var firstperson = '', topparams = '', botparams = '', toplinks = '', botlinks = '';\n";
$flags['scripting'] .= "var pedxmlfile = '" . getURL("pedxml",1) . "';\n";
$flags['scripting'] .= "</script>\n";
$flags['scripting'] .= "<script src=\"$cms[tngpath]" . "tngpedigree.js\" type=\"text/javascript\"></script>\n";

$flags['scripting'] .= "<style type=\"text/css\">\n";
$flags['scripting'] .= ".box { position:absolute; }\n";
$flags['scripting'] .= ".border { position:absolute; background-color:$pedigree[bordercolor]; z-index:3; overflow:hidden}\n";
$flags['scripting'] .= ".shadow { position:absolute; background-color:$pedigree[shadowcolor]; z-index:1; overflow:hidden}\n";
$flags['scripting'] .= ".offpagearrow { position:absolute; visibility:hidden; z-index:5;}\n";
$flags['scripting'] .= ".downarrow { position:absolute; z-index:7; cursor:pointer; visibility:hidden }\n";
$flags['scripting'] .= ".popup { position:absolute; visibility:hidden; background-color:$pedigree[popupcolor]; z-index:8 }\n";
$flags['scripting'] .= ".pboxname { font-size:$pedigree[boxnamesize]pt; text-align:$pedigree[boxalign]; }\n";
$slot = 1;
$boxes = "";
showBox( 1, $slot );
$flags['scripting'] .= "</style>\n";

$gentext = xmlcharacters($text[generations]);
writelog( "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations&amp;display=$display\">" . xmlcharacters("$text[pedigreefor] $logname ($personID)") . "</a> $generations " . $gentext );
preparebookmark( "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations&amp;display=$display\">" . xmlcharacters("$text[pedigreefor] $pedname ($personID)") . "</a> $generations " . $gentext );

$flags[tabs] = $tngconfig[tabs];
tng_header( "$text[pedigreefor] $pedname", $flags );

	$photostr = showSmallPhoto( $personID, $pedname, $row[allow_living], 0 );
	echo tng_DrawHeading( $photostr, $pedname, getYears( $row ) );
	echo tng_coreicons();

	$innermenu = "$text[generations]: &nbsp;";
	$innermenu .= "<select name=\"generations\" style=\"font-size:9px\" onChange=\"window.location.href='$pedigree_url" . "personID=' + firstperson + '&amp;tree=$tree&amp;parentset=$parentset&amp;display=$display&amp;generations=' + this.options[this.selectedIndex].value\">\n";
    for( $i = 2; $i <= $pedigree[maxgen]; $i++ ) {
        $innermenu .= "<option value=\"$i\"";
        if( $i == $generations ) $innermenu .= " selected";
        $innermenu .= ">$i</option>\n";
    }
	$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
	$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=standard&amp;generations=$generations\" class=\"lightlink$slinkstyle\" id=\"stdpedlnk\">$text[pedstandard]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=compact&amp;generations=$generations\" class=\"lightlink$clinkstyle\" id=\"compedlnk\">$text[pedcompact]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=box&amp;generations=$generations\" class=\"lightlink$blinkstyle\" id=\"boxpedlnk\">$text[pedbox]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$pedigreetext_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink\" id=\"textlnk\">$text[pedtextonly]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$ahnentafel_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink\" id=\"ahnlnk\">$text[ahnentafel]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
	$innermenu .= "<a href=\"$extrastree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;showall=1&amp;generations=$generations\" class=\"lightlink\" id=\"extralnk\">$text[media]</a>\n";
	if($generations <= 6)
		$innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"#\" class=\"lightlink\" onclick=\"tnglitbox = new LITBox('$pdfform_url" . "pdftype=ped&personID=' + firstperson + '&tree=$tree&generations=$generations',{width:350,height:350});return false;\">PDF</a>\n";

	echo getFORM( "pedigree", "", "form1", "form1" );
	echo tng_menu( "I", "pedigree", $personID, $innermenu );
	echo "</form>\n";

	if( !$tngprint ) {
		echo "<span class=\"normal\">($text[scrollnote]"; 
		if ( $pedigree[usepopups_real] ) {
			echo ( $pedigree[downarrow] ? " <img src=\"$cms[tngpath]" . "ArrowDown.gif\" width=\"$pedigree[downarroww]\" height=\"$pedigree[downarrowh]\" alt=\"\">" : " <a href=\"#\"><span class=\"normal\"><B>V</B></span></a>" ) . $text[popupnote1];
			if ( $pedigree[popupchartlinks] ) 
				echo "&nbsp;&nbsp;$pedigree[chartlink] &nbsp; $text[popupnote2]"; 
		}
		echo ")</span>";
	}
?>
<div id="loading" style="position:relative; width=200px; visibility:visible; z-index=9; margin:0px"><br /><span class="normal"><b><?php echo $text[loading]; ?></b></span></div>
<div align="left" style="position:relative;" id="outer">
<?php
echo $boxes;
?>

<table border="0" cellspacing="0" cellpadding="0" width="<?php echo ($pedigree[borderwidth] + ($pedigree[maxwidth] - $pedigree[boxHsep]) + $pedigree[shadowoffset] + $pedigree[leftindent] + $offpageimgw + 3); ?>" style="height: <?php echo (20 + $pedigree[borderwidth] + ($pedigree[maxheight] - $pedigree[boxVsep]) + $pedigree[shadowoffset]); ?>px;">
<tr><td></td></tr></table>

</div>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>litbox.js"></script>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>rpt_utils.js"></script>
<script type="text/javascript">
for( var c = 1; c < slotceiling; c++ ) {
	var slot = document.getElementById('box'+c);
	slot.oldcolor = slot.style.backgroundColor;
}
getNewChart(personID,generations,parentset);
</script>
<?php
	//$flags[more] = "</div>\n";
	tng_footer( $flags );
?>
