<?php
include("begin.php");
include($subroot . "pedconfig.php");
include($cms['tngpath'] . "genlib.php");

if($pdftype == "ped") {
	$dest = "rpt_pedigree";
	$genmax = !$pedigree['maxgen'] || $pedigree['maxgen'] > 6 ? 6 : $pedigree['maxgen'];
	$genmin = $genmax < 4 ? $genmax : 4;
	$allow_blank = 1;
	$hdrFontSizes = array(9, 10, 12, 14);
	$hdrFontDefault = 12;
	$rptFontSizes = array(8);
	$titleidx = 'pedigreefor';
	$textpart = "pedigree";
}
elseif($pdftype == "desc") {
	$dest = "rpt_descend";
	$genmin = 2;
	$genmax = 12;
	$allow_blank = 0;
	$hdrFontSizes = array(9, 10, 12, 14);
	$hdrFontDefault = 12;
	$rptFontSizes = array(9, 10, 12, 14);
	$rptFontDefault = 10;
	$titleidx = 'descendfor';
	$textpart = "pedigree";
}
else {
	$dest = "rpt_ind";
	$genmin = 0;	    // no generations option
	$genmax = 0;
	$allow_blank = 1;
	$hdrFontSizes = array(9, 10, 12, 14);
	$hdrFontDefault = 12;
	$lblFontSizes = array(9);
	$rptFontSizes = array(9, 10, 12, 14);
	$rptFontDefault = 10;
	$titleidx = 'indreportfor';
	$textpart = "getperson";
}

include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
$tngprint = 1;
include($cms['tngpath'] . "checklogin.php");


function doGenOptions($generations,$first,$last) {
	echo '<select name="genperpage">';
	for($i = $first; $i <= $last; $i++) {
		echo "<option value=\"$i\"";
		if($i == $generations) echo " selected=\"selected\"";
		echo ">$i</option>\n";
	}
	echo '</select>';
}

function doFontOptions($field, $default='helvetica') {
	global $font_list;

	echo "<select name=\"$field\">";
	$fonts = array_keys($font_list);
	sort($fonts);
	foreach($fonts as $font) {
	    echo "<option value=\"$font\"";
	    if ($font == $default)
		print " selected=\"selected\"";
	    echo ">$font_list[$font]</option>";
	}
	echo '</select>';
}

function doFontSizeOptions($field, $options, $default) {
    if (count($options) == 1) {
	echo "<span class=\"normal\">$options[0] pt</span>";
	echo "<input type=\"hidden\" name=\"$field\" value=\"$options[0]\" />";
    }
    else {
	echo "<select name=\"$field\">";
	foreach ($options as $size) {
	    echo "<option value=\"$size\"";
	    if ($default == $size)
		print " selected=\"selected\"";
	    echo ">$size</option>";
	}
	echo '</select>';
    }
}

$savetype = $pdftype;
// load the list of available fonts
$font_dir = $cms['tngpath'].'font';
if (is_dir($font_dir)) {
    if ($dh = opendir($font_dir)) {
	while (($fontfamily = readdir($dh)) !== false) {
	    if ($fontfamily == 'makefont')
		continue;
	    $charset_dir = '';
	    if ($session_charset == 'UTF-8')
		$charset_dir = '/utf8';
	    if (is_dir("$font_dir/$fontfamily$charset_dir") && is_file("$font_dir/$fontfamily$charset_dir/$fontfamily.php")) {
		include("$font_dir/$fontfamily$charset_dir/$fontfamily.php");
		$font_list[$fontfamily] = $name;
	    }
	}
    }
}
$pdftype = $savetype;

$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, branch FROM $people_table WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row[branch] );
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$pedname = getName( $row );
	mysql_free_result($result);
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="finddiv">
<span class="subhead"><strong><?php echo $text['pdfgen']; ?></strong></span><br/>

<br /><p class="subhead"><span class="normal" style="padding-bottom:3px"><?php echo $text[$titleidx]; ?></span><br /><?php echo "$pedname ($personID)"; ?></p>
<?php
if (count($font_list) == 0) {
    echo "ERROR: There are no fonts installed to support character set $session_charset.";
    return;
}
?>

<?php
	echo getFORM( $dest, "post", "pdfform", "pdfform" );
	// determine if we need to draw a generations option
	if($genmin > 0 || $genmax > 0) {
		if($generations < $genmin) $generations = $genmin;
		if($generations > $genmax) $generations = $genmax;
?>
<table id="genselect" cellpadding="0" class="normal">
    <tr>
	<td>
	    <span class="normal"><?php echo $text['generations']; ?>:</span>
	</td>
	<td>
	    <?php echo doGenOptions($generations,$genmin,$genmax); ?>
	</td>
    </tr>
</table>

<?php
	}

	// draw the blank form checkbox
	if($allow_blank) {
?>
<div style="padding:4px 0px" class="normal"><input type="checkbox" id="blankform" name="blankform" value="1" /> <?php echo $text['blank']; ?></div>
<?php
	}
?>

<input type="hidden" name="personID" value="<?php echo $personID; ?>" />
<input type="hidden" name="tree" value="<?php echo $tree; ?>" />

<?php
	// options specific to certain report types
	if($pdftype == "desc") {
?>
<div class="subhead" style="padding:4px 0px"><a href="#" onClick="return toggleSection('dispopts','dispicon','');" style="text-decoration:none;color:black"><img src="tng_expand.gif" width="15" height="15" border="0" id="dispicon"/> <?php echo $text['dispopts']; ?></a></div>
<div style="display:none" id="dispopts">
<table id="display" cellpadding="3" class="normal">
    <tr>
	<td>
	    <span class="normal"><?php echo $text['datesloc']; ?>:&nbsp;</span>
	</td>
	<td>
	    <select name="getPlace">
	    <option value="1" selected="selected"><?php echo $text['borchr']; ?></option>
            <option value="2"><?php echo $text['nobd']; ?></option>
            <option value="3"><?php echo $text['bcdb']; ?></option>
	    </select>
	</td>
    </tr>
	<td>
	    <span class="normal"><?php echo $text['numsys']; ?>:&nbsp;</span>
	</td>
	<td>
	    <select name="numbering">
	    <option value="0"><?php echo $text['none']; ?></option>
	    <option value="1" selected="selected"><?php echo $text['gennums']; ?></option>
            <option value="2"><?php echo $text['henrynums']; ?></option>
            <option value="3"><?php echo $text['abovnums']; ?></option>
            <option value="4"><?php echo $text['devnums']; ?></option>
	    </select>
	</td>
    <tr>
</table>
<br />
</div>
<?php
	}
?>

<!-- Font section -->
<div class="subhead" style="padding:4px 0px"><a href="#" onClick="return toggleSection('font','fonticon','');" style="text-decoration:none;color:black"><img src="tng_expand.gif" width="15" height="15" border="0" id="fonticon"> <?php echo $text['fonts']; ?></a></div>
<div style="display:none" id="font">
<table cellpadding="3" class="normal">
<?php
    // header fonts
    if (count($hdrFontSizes) > 0) {
?>
    <tr>
	<td>
	    <span class="normal"><?php echo $text['header']; ?>:&nbsp;</span>
	</td>
	<td>
	    <?php doFontOptions('hdrFont'); ?>
	</td>
	<td>
	    <?php doFontSizeOptions('hdrFontSize', $hdrFontSizes, $hdrFontDefault); ?>
	</td>
    </tr>
<?php
    }
    
    // label fonts
    if (count($lblFontSizes) > 0) {
?>
    <tr>
	<td>
	    <span class="normal"><?php echo $text['labels']; ?>:&nbsp;</span>
	</td>
	<td>
	    <?php doFontOptions('lblFont'); ?>
	</td>
	<td>
	    <?php doFontSizeOptions('lblFontSize', $lblFontSizes, $lblFontDefault); ?>
	</td>
    </tr>
<?php
    }

    // data fonts
    if (count($rptFontSizes) > 0) {
?>
    <tr>
	<td>
	    <span class="normal"><?php echo $text['data']; ?>:&nbsp;</span>
	</td>
	<td>
	    <?php doFontOptions('rptFont'); ?>
	</td>
	<td>
	    <?php doFontSizeOptions('rptFontSize', $rptFontSizes, $rptFontDefault); ?>
	</td>
    </tr>
<?php
	}
?>
</table>
<br />
</div>

<!-- Page setup section -->
<div class="subhead" style="padding:4px 0px"><a href="#" onClick="return toggleSection('pgsetup','pgicon','');" style="text-decoration:none;color:black"><img src="tng_expand.gif" width="15" height="15" border="0" id="pgicon"> <?php echo $text['pgsetup']; ?></a></div>
<div style="display:none" id="pgsetup">
<table cellpadding="3" class="normal">
    <tr>
	<td>
	    <span class="normal"><?php echo $text['pgsize']; ?>:&nbsp;</span>
	</td>
	<td>
	    <select name="pagesize">
	    <option value="a3">A3</option>
	    <option value="a4">A4</option>
	    <option value="a5">A5</option>
	    <option value="letter" selected="selected"><?php echo $text['letter']; ?></option>
            <option value="legal"><?php echo $text['legal']; ?></option>
	    </select>
	</td>
    </tr>
    <tr>
	<td>
	    <span class="normal"><?php echo $text['orient']; ?>:&nbsp;</span>
	</td>
	<td>
	    <select name="orient">
	    <option value=p selected><?php echo $text['portrait']; ?></option>
            <option value=l><?php echo $text['landscape']; ?></option>
	    </select>
	</td>
    </tr>
    <tr>
	<td>
	    <span class="normal"><?php echo $text['tmargin']; ?>:&nbsp;</span>
	</td>
	<td>
	    <input type="text" value="0.5" name="topmrg" size="5" />
	</td>
    </tr>
    <tr>
	<td>
	    <span class="normal"><?php echo $text['bmargin']; ?>:&nbsp;</span>
	</td>
	<td>
	    <input type="text" value="0.5" name="botmrg" size="5" />
	</td>
    </tr>
    <tr>
	<td>
	    <span class="normal"><?php echo $text['lmargin']; ?>:&nbsp;</span>
	</td>
	<td>
	    <input type="text" value="0.5" name="lftmrg" size="5" />
	</td>
    </tr>
    <tr>
	<td>
	    <span class="normal"><?php echo $text['rmargin']; ?>:&nbsp;</span>
	</td>
	<td>
	    <input type="text" value="0.5" name="rtmrg" size="5" />
	</td>
    </tr>
</table>
</div>
<br />
<input type="submit" onclick="this.form.target='_blank'" value="<?php echo $text['createch']; ?>" />

</form>


</div>
