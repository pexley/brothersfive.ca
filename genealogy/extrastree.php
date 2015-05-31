<?php
include("begin.php");
include($subroot . "pedconfig.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "pedigree";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );

$getperson_url = getURL( "getperson", 1 );
$ahnentafel_url = getURL( "ahnentafel", 1 );
$pedigree_url = getURL( "pedigree", 1 );
$pedigreetext_url = getURL( "pedigreetext", 1 );
$extrastree_url = getURL( "extrastree", 1 );
$pdfform_url = getURL( "pdfform", 1 );

if( !$generations ) $generations = 12;

function displayIndividual( $key, $generation, $slot, $column ) {
	global $columns, $tree, $generations, $pedmax, $people_table, $families_table, $personID, $text, $media_table, $medialinks_table, $col1fam, $col2fam;
	global $allow_living, $cms, $getperson_url, $showall, $livedefault, $children_table, $parentset;

	$nextslot = $slot * 2;
	$name = "";
	
	if( $key ) {
		$query = "SELECT firstname, lnprefix, lastname, lnprefix, prefix, suffix, nameorder, living, famc, IF(birthdate!='',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birthyear, IF(deathdate!='',YEAR(deathdatetr),YEAR(burialdatetr)) as deathyear FROM $people_table WHERE personID = \"$key\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( $result ) {
			$row = mysql_fetch_assoc( $result );
			$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && checkbranch( $row[branch] ) ) ? 1 : 0;
			$lastname = trim($row[lnprefix] . " " . $row[lastname]);

			if( $generation == 2 ) {
				if( $slot == 2 )
					$col1fam = $lastname ? $lastname : $text[paternal];
				else
					$col2fam = $lastname ? $lastname : $text[maternal];
			}
			
			if( $row[allow_living] ) {
				$mediaquery = "SELECT count($medialinks_table.medialinkID) as mediacount FROM ($medialinks_table, $media_table) WHERE $medialinks_table.mediaID = $media_table.mediaID AND personID = \"$key\" AND $medialinks_table.gedcom = \"$tree\"";
				$mediaresult = mysql_query($mediaquery) or die ("$text[cannotexecutequery]: $mediaquery");
				if( $mediaresult ) {
					$mediarow = mysql_fetch_assoc( $mediaresult );
					mysql_free_result( $mediaresult );
				}
				else
					$mediarow[mediacount] = 0;

				if( $mediarow[mediacount] || $showall ) {
					if( !isset($columns[$column][$generation]) ) {
						$gentext = "gen$generation";
						$columns[$column][$generation] = "<span class=\"normal\">$text[$gentext]<br/></span>\n<ul>\n";
					}
					$birthyear = $row[birthyear] ? $row[birthyear] : "?";
					$deathyear = $row[deathyear] ? $row[deathyear] : "?";
					$namestr = getNameRev( $row );
					$columns[$column][$generation] .= "<li><span class=\"normal\"><a href=\"$getperson_url" . "tng_extras=1&amp;personID=$key&amp;tree=$tree\">$namestr</a> ($birthyear - $deathyear)";
					if( $mediarow[mediacount] )
						$columns[$column][$generation] .= " <a href=\"$getperson_url" . "tng_extras=1&amp;personID=$key&amp;tree=$tree\" title=\"$text[mediaavail]\"><img src=\"$cms[tngpath]" . "photo.gif\" width=\"14\" height=\"12\" border=\"0\" alt=\"$text[mediaavail]\" /></a>";
					$columns[$column][$generation] .= "</span></li>\n";
				}
			}
			mysql_free_result($result);
		}
	}

	$generation++;
	if( $nextslot < $pedmax ) {
		$husband = "";
		$wife = "";

		if( $key ) {
			$parentfamID = "";
			$locparentset = $parentset;
			$parentscount = 0;
			$parentfamIDs = array();
			$query = "SELECT familyID FROM $children_table WHERE personID = \"$key\" AND gedcom = \"$tree\" ORDER BY parentorder";
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
			$query = "SELECT husband, wife FROM $families_table WHERE familyID = \"$parentfamID\" AND gedcom = \"$tree\"";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( $result2 ) {
				$newrow = mysql_fetch_assoc( $result2 );
				$husband = $newrow[husband];
				$wife = $newrow[wife];
				mysql_free_result($result2);
			}
		}
		if( !$column ) {
			$leftcolumn = 1;
			$rightcolumn = 2;
		}
		else
			$leftcolumn = $rightcolumn = $column;
		displayIndividual( $husband, $generation, $nextslot, $leftcolumn );
		$nextslot++;
		displayIndividual( $wife, $generation, $nextslot, $rightcolumn );
	}
}

$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row[branch] ) ? 1 : 0;
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$pedname = getName( $row );
	$logname = $nonames && $row[living] ? $text[living] : $pedname;
	$disallowgedcreate = $row[disallowgedcreate];
	mysql_free_result($result);
}

$columns = array();

$pedmax = pow( 2, intval($generations) );
$key = $personID;

writelog( "<a href=\"$extrastree_url" . "personID=$personID&amp;tree=$tree\">$text[familyof] $logname ($personID)</a>" );
preparebookmark( "<a href=\"$extrastree_url" . "personID=$personID&amp;tree=$tree\">$text[familyof] $pedname ($personID)</a>" );

$flags[tabs] = $tngconfig[tabs];
$flags['scripting'] = "<script type=\"text/javascript\">var tnglitbox;</script>\n";
tng_header( "$text[media]: $text[familyof] $pedname", $flags );
?>

<?php 
$photostr = showSmallPhoto( $personID, $pedname, $row[allow_living], 0 );
echo tng_DrawHeading( $photostr, $pedname, getYears( $row ) );
echo tng_coreicons();

$innermenu = "$text[generations]: &nbsp;";
if( $generations > $pedigree[maxgen] ) $generations = $pedigree[maxgen];
$innermenu .= "<select name=\"generations\" style=\"font-size:9px\" onchange=\"window.location.href='$extrastree_url" . "personID=$personID&amp;tree=$tree&amp;showall=$showall&amp;generations=' + this.options[this.selectedIndex].value\">\n";
   for( $i = 1; $i <= $pedigree[maxgen]; $i++ ) {
       $innermenu .= "<option value=\"$i\"";
       if( $i == $generations ) $innermenu .= " selected=\"selected\"";
       $innermenu .= ">$i</option>\n";
   }
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=standard&amp;generations=$generations\" class=\"lightlink\" id=\"stdpedlnk\">$text[pedstandard]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=compact&amp;generations=$generations\" class=\"lightlink\" id=\"compedlnk\">$text[pedcompact]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$pedigree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=box&amp;generations=$generations\" class=\"lightlink\" id=\"boxpedlnk\">$text[pedbox]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$pedigreetext_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink\">$text[pedtextonly]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$ahnentafel_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink\">$text[ahnentafel]</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$extrastree_url" . "personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;showall=1&amp;generations=$generations\" class=\"lightlink3\">$text[media]</a>\n";
if($generations <= 6)
	$innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"#\" class=\"lightlink\" onclick=\"tnglitbox = new LITBox('$pdfform_url" . "pdftype=ped&personID=$personID&tree=$tree&generations=$generations',{width:350,height:350});return false;\">PDF</a>\n";

echo getFORM( "pedigree", "", "form1", "form1" );
echo tng_menu( "I", "pedigree", $personID, $innermenu );
echo "</form>\n";

echo "<p class=\"subhead\"><strong>$text[media]: $text[familyof] $pedname</strong></p>";

if( $showall )
	echo "<p><img src=\"$cms[tngpath]" . "photo.gif\" width=\"14\" height=\"12\" border=\"0\" alt=\"$text[mediaavail]\" /> $text[extrasexpl]</p>";
$slot = 1;
displayIndividual( $personID, 1, $slot, 0 );

//echo $columns[0][1];
?>
<table border="0" cellspacing="0" cellpadding="0">
<tr>
	<td valign="top">
		<p class="subhead"><strong><?php echo "$col1fam $text[side]"; ?></strong></p>
<?php
	for( $nextgen = 2; $nextgen <= $generations; $nextgen++ ) {
		if( $columns[1][$nextgen] ) {
			echo $columns[1][$nextgen];
			echo "</ul>\n<br/>\n";
		}
	}
?>
	</td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td valign="top">
		<p class="subhead"><strong><?php echo "$col2fam $text[side]"; ?></strong></p>
<?php
	for( $nextgen = 2; $nextgen <= $generations; $nextgen++ ) {
		if( $columns[2][$nextgen] ) {
			echo $columns[2][$nextgen];
			echo "</ul>\n<br/>\n";
		}
	}
?>
	</td>
</tr>
</table>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>litbox.js"></script>
<script type="text/javascript" src="<?php echo $cms[tngpath]; ?>rpt_utils.js"></script>

<?php
tng_footer( "" );
?>
