<?php
include("begin.php");
//session_cache_limiter('public');
include($cms['tngpath'] . "genlib.php");
$textpart = "search";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "functions.php");

$getperson_url = getURL( "getperson", 1 );
$showtree_url = getURL( "showtree", 1 );
$pedigree_url = getURL( "pedigree", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$anniversaries_url = getURL( "anniversaries", 1 );
$anniversaries2_url = getURL( "anniversaries2", 1 );

@set_time_limit(0);

if( !$tngneedresults ) {
	//get today's date
	$tngdaymonth = date("d", time() + ( 3600 * $time_offset ) );
	$tngmonth = date("m", time() + ( 3600 * $time_offset ) );
	$tngneedresults = 1;
}

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$anniversaries_url" . "tngevent=$tngevent&amp;tngdaymonth=$tngdaymonth&amp;tngmonth=$tngmonth&amp;tngyear=$tngyear&amp;tngkeywords=$tngkeywords&amp;tngneedresults=$tngneedresults&amp;offset=$offset&amp;tree=$tree&amp;page=$page\">" . xmlcharacters("$text[anniversaries] $treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

//compute $allwhere from submitted criteria

tng_header( $text['anniversaries'], $flags );
?>
<script type="text/javascript">
function resetForm() {
	var myform = document.form1;

	myform.tngevent.selectedIndex = 0;
	myform.tngdaymonth.value = "";
	myform.tngmonth.selectedIndex = 0;
	myform.tngyear.value = "";
	myform.tngkeywords.value = "";
}

function validateForm( form ) {
	var rval = true;

	if( form.tngdaymonth.selectedIndex == 0 && form.tngmonth.selectedIndex == 0 && form.tngyear.value.length == 0 && form.tngkeywords.value.length == 0 ) {
		alert("<?php echo $text[enterdate]; ?>");
		rval = false;
	}
	return rval;
}
</script>
<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_date.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text['anniversaries']; ?></p><br clear="left"/>
<?php
	echo tng_coreicons();

$js = "\" onsubmit=\"return validateForm(this);";
echo getFORM( "anniversaries2", "GET", "form1", "form1$js" );

echo treeDropdown(array('startform' => false, 'endform' => false));
?>
<p class="normal"><?php echo $text[explain]; ?></p>
<table>
	<tr>
		<td><span class="normal"><?php echo $text[event]; ?>:</span></td>
		<td><span class="normal"><?php echo $text[day]; ?>:</span></td>
		<td><span class="normal"><?php echo $text[month]; ?>:</span></td>
		<td><span class="normal"><?php echo $text[year]; ?>:</span></td>
		<td><span class="normal"><?php echo $text[keyword]; ?>:</span></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<select name="tngevent">
<?php
			echo "<option value=\"\">&nbsp;</option>\n";
			echo "<option value=\"birth\"";
			if( $tngevent == "birth" ) echo " selected=\"selected\"";
			echo ">$text[born]</option>\n";
			
			echo "<option value=\"altbirth\"";
			if( $tngevent == "altbirth" ) echo " selected=\"selected\"";
			echo ">$text[christened]</option>\n";
			
			echo "<option value=\"death\"";
			if( $tngevent == "death" ) echo " selected=\"selected\"";
			echo ">$text[died]</option>\n";
			
			echo "<option value=\"burial\"";
			if( $tngevent == "burial" ) echo " selected=\"selected\"";
			echo ">$text[buried]</option>\n";
				
			echo "<option value=\"marr\"";
			if( $tngevent == "marr" ) echo " selected=\"selected\"";
			echo ">$text[married]</option>\n";
				
			echo "<option value=\"div\"";
			if( $tngevent == "div" ) echo " selected=\"selected\"";
			echo ">$text[divorced]</option>\n";
				
			if( $allow_lds ) {			
				echo "<option value=\"bapt\"";
				if( $tngevent == "bapt" ) echo " selected=\"selected\"";
				echo ">$text[baptizedlds]</option>\n";
				
				echo "<option value=\"endl\"";
				if( $tngevent == "endl" ) echo " selected=\"selected\"";
				echo ">$text[endowedlds]</option>\n";
	
				echo "<option value=\"seal\"";
				if( $tngevent == "seal" ) echo " selected=\"selected\"";
				echo ">$text[sealedslds]</option>\n";
			}
			
			//loop through custom event types where keep=1, not a standard event
			$query = "SELECT eventtypeID, tag, display FROM $eventtypes_table 
				WHERE keep=\"1\" AND type=\"I\" ORDER BY display";
			$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
			$dontdo = array("ADDR","BIRT","CHR","DEAT","BURI","NAME","NICK","TITL","NSFX","DIV","MARR");
			while( $row = mysql_fetch_assoc( $result ) ) {
				if( !in_array( $row[tag], $dontdo ) ) {
					echo "<option value=\"$row[eventtypeID]\"";
					if( $tngevent == "$row[eventtypeID]" ) echo " selected=\"selected\"";
					echo ">" . getEventDisplay( $row[display] ) . "</option>\n";
				}
			} 
			mysql_free_result($result);
?>
			</select>
		</td>
		<td>
			<select name="tngdaymonth">
				<option value="">&nbsp;</option>
<?php
	for( $i = 1; $i <= 31; $i++ ) {
		echo "<option value=\"$i\"";
		if( $i == $tngdaymonth ) echo " selected=\"selected\"";
		echo ">$i</option>\n";
	}
	$tngkeywordsclean = ereg_replace("\"", "&#34;",stripslashes($tngkeywords));
?>
			</select>
		</td>
		<td>
			<select name="tngmonth">
				<option value="">&nbsp;</option>
				<option value="1"<?php if( $tngmonth == 1 ) echo " selected=\"selected\""; ?>><?php echo $dates[JANUARY]; ?></option>
				<option value="2"<?php if( $tngmonth == 2 ) echo " selected=\"selected\""; ?>><?php echo $dates[FEBRUARY]; ?></option>
				<option value="3"<?php if( $tngmonth == 3 ) echo " selected=\"selected\""; ?>><?php echo $dates[MARCH]; ?></option>
				<option value="4"<?php if( $tngmonth == 4 ) echo " selected=\"selected\""; ?>><?php echo $dates[APRIL]; ?></option>
				<option value="5"<?php if( $tngmonth == 5 ) echo " selected=\"selected\""; ?>><?php echo $dates[MAY]; ?></option>
				<option value="6"<?php if( $tngmonth == 6 ) echo " selected=\"selected\""; ?>><?php echo $dates[JUNE]; ?></option>
				<option value="7"<?php if( $tngmonth == 7 ) echo " selected=\"selected\""; ?>><?php echo $dates[JULY]; ?></option>
				<option value="8"<?php if( $tngmonth == 8 ) echo " selected=\"selected\""; ?>><?php echo $dates[AUGUST]; ?></option>
				<option value="9"<?php if( $tngmonth == 9 ) echo " selected=\"selected\""; ?>><?php echo $dates[SEPTEMBER]; ?></option>
				<option value="10"<?php if( $tngmonth == 10 ) echo " selected=\"selected\""; ?>><?php echo $dates[OCTOBER]; ?></option>
				<option value="11"<?php if( $tngmonth == 11 ) echo " selected=\"selected\""; ?>><?php echo $dates[NOVEMBER]; ?></option>
				<option value="12"<?php if( $tngmonth == 12 ) echo " selected=\"selected\""; ?>><?php echo $dates[DECEMBER]; ?></option>
			</select>
		</td>
		<td><input type="text" name="tngyear" size="6" maxlength="4" value="<?php echo $tngyear; ?>" /></td>
		<td><input type="text" name="tngkeywords" size="20" value="<?php echo stripslashes($tngkeywordsclean); ?>" /></td>
		<td><input type="hidden" name="tngneedresults" value="1" /><input type="submit" value="<?php echo $text[search]; ?>" /> <input type="button" value="<?php echo $text[tng_reset]; ?>" onclick="resetForm();" /></td>
	</tr>
</table>
</form>

<?php
if( $tngneedresults ) {
	$successcount = 0;
	if( $tngevent )
		$tngevents = array($tngevent);
	else {
		$tngevents = array("birth","altbirth","death","burial","marr","div");
		if($allow_lds) {
			$ldsevents = array("seal", "endl", "bapt");
			$tngevents = array_merge($tngevents, $ldsevents);
		}
		$query = "SELECT tag, eventtypeID FROM $eventtypes_table 
			WHERE keep=\"1\" AND type=\"I\" ORDER BY display";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$dontdo = array("ADDR","BIRT","CHR","DEAT","BURI","NAME","NICK","TITL","NSFX");
		while( $row = mysql_fetch_assoc( $result ) ) {
			if( !in_array( $row[tag], $dontdo ) )
				array_push( $tngevents, $row[eventtypeID] );
		} 
		mysql_free_result($result);
	}
	foreach( $tngevents as $tngevent ) {
		$allwhere = "";
		
		$eventsjoin = "";
		$needfamilies = "";
		$tngsaveevent = $tngevent;
		switch( $tngevent ) {
			case "birth":
				$datetxt = $text[born];
				break;
			case "altbirth":
				$datetxt = $text[christened];
				break;
			case "death":
				$datetxt = $text[died];
				break;
			case "burial":
				$datetxt = $text[buried];
				break;
			case "marr":
				$datetxt = $text[married];
				$needfamilies = 1;
				break;
			case "div":
				$datetxt = $text[divorced];
				$needfamilies = 1;
				break;
			case "seal":
				$datetxt = $text[sealedslds];
				$needfamilies = 1;
				break;
			case "endl":
				$datetxt = $text[endowedlds];
				break;
			case "bapt":
				$datetxt = $text[baptizedlds];
				break;
			default:
				//look up display
				$query = "SELECT display FROM $eventtypes_table 
					WHERE eventtypeID=\"$tngevent\" ORDER BY display";
				$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$event = mysql_fetch_assoc( $evresult );
				$datetxt = getEventDisplay( $event[display] );
				mysql_free_result( $evresult );
				
				$eventsjoin = ", $events_table";
				$allwhere .= " AND $people_table.personID = $events_table.persfamID AND $people_table.gedcom = $events_table.gedcom AND eventtypeID = \"$tngevent\"";
				$tngevent = "event";
				break;
		}
		if( $needfamilies ) {
			//$familiesjoin = ", $families_table";
			//$allwhere .= " AND ($people_table.personID = $families_table.husband OR $people_table.personID = $families_table.wife)";
			$familiesjoin = " LEFT JOIN $families_table AS families1 ON ($people_table.gedcom = families1.gedcom AND $people_table.personID = families1.husband )  LEFT JOIN $families_table AS families2 ON ($people_table.gedcom = families2.gedcom AND $people_table.personID = families2.wife )";  // added IDF Apr 03

			$datefield1 = "families1." . $tngevent . "date";
			$datefieldtr1 = "families1." . $tngevent . "datetr";
			$place1 = "families1." . $tngevent . "place";
			
			$datefield2 = "families2." . $tngevent . "date";
			$datefieldtr2 = "families2." . $tngevent . "datetr";
			$place2 = "families2." . $tngevent . "place";
			
			$datefield = "$datefield1 as date1, $datefield2 as date2";
			$datefieldtr = "IF($datefieldtr1,$datefieldtr1,$datefieldtr2)";
			$place = "$place1 as place1, $place2 as place2";

			if( $tngdaymonth ) {
				$allwhere .= " AND (DAYOFMONTH($datefieldtr1) = '$tngdaymonth' OR DAYOFMONTH($datefieldtr2) = '$tngdaymonth')";
			}
			if( $tngmonth ) {
				$allwhere .= " AND (MONTH($datefieldtr1) = '$tngmonth' OR MONTH($datefieldtr2) = '$tngmonth')";
			}
			if( $tngyear ) {
				$allwhere .= " AND (YEAR($datefieldtr1) = '$tngyear' OR YEAR($datefieldtr2) = '$tngyear')";
			}
			if( $tngkeywords ) {
				if (get_magic_quotes_gpc() == 0)
					$tngkeywords = addslashes($tngkeywords);
				$allwhere .= " AND ($datefield1 LIKE '%$tngkeywords%' OR $datefield2 LIKE '%$tngkeywords%')";
			}
		}
		else {
			$familiesjoin = "";
			$datefield = $tngevent . "date";
			$datefieldtr = $tngevent . "datetr";
			$place = $tngevent . "place";

			if( $tngdaymonth ) {
				$allwhere .= " AND DAYOFMONTH($datefieldtr) = '$tngdaymonth'";
			}
			if( $tngmonth ) {
				$allwhere .= " AND MONTH($datefieldtr) = '$tngmonth'";
			}
			if( $tngyear ) {
				$allwhere .= " AND YEAR($datefieldtr) = '$tngyear'";
			}
			if( $tngkeywords ) {
				$allwhere .= " AND $datefield LIKE '%$tngkeywords%'";
			}
		}
		
		if( $tree ) {
			if( $urlstring )
				$urlstring .= "&amp;";
			$urlstring .= "tree=$tree";
			
			if( $allwhere ) $allwhere = " AND (1=1 $allwhere)";
			$allwhere .= " AND $people_table.gedcom=\"$tree\"";
		}
		
		if( $livedefault < 2 && ( !$allow_living_db || $assignedtree ) ) {
			if( $allow_living_db ) {
				if( $assignedbranch )
					$allwhere .= " AND ($people_table.living != 1 OR ($people_table.gedcom = \"$assignedtree\" AND $people_table.branch LIKE \"%$assignedbranch%\") )";
				else
					$allwhere .= " AND ($people_table.living != 1 OR $people_table.gedcom = \"$assignedtree\")";
			}
			else
				$allwhere .= " AND $people_table.living != 1";
		}
		
		$max_browsesearch_pages = 5;
		if( $offset ) {
			$offsetplus = $offset + 1;
			$newoffset = "$offset, ";
		}
		else {
			$offsetplus = 1;
			$newoffset = "";
			$page = 1;
		}
		
		//if one event was selected, just do that one
		//if no event was selected, do them each in turn
		
		$query = "SELECT distinct $people_table.ID, $people_table.personID, lastname, lnprefix, firstname, $people_table.living, $people_table.branch, prefix, suffix, nameorder, $place, $datefield, $people_table.gedcom, treename 
			FROM ($people_table, $trees_table $eventsjoin) $familiesjoin
			WHERE $people_table.gedcom = $trees_table.gedcom $allwhere 
			ORDER BY $datefieldtr, lastname, firstname LIMIT $newoffset" . $maxsearchresults;
		//echo "debug: $query<br>\n";
		$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$numrows = mysql_num_rows( $result );
		
		if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
			$query = "SELECT count(personID) as pcount 
				FROM ($people_table, $trees_table $eventsjoin) $familiesjoin
				WHERE $people_table.gedcom = $trees_table.gedcom $allwhere";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$countrow = mysql_fetch_assoc($result2);
			$totrows = $countrow[pcount];
		}
		else
			$totrows = $numrows;
		
		if ( $numrows ) {
			echo "<p><span class=\"subhead\"><strong>$datetxt</strong></span></p>";
			$numrowsplus = $numrows + $offset;
			$successcount++;
			
			echo "<p>$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows</p>";
			
			$pagenav = get_browseitems_nav( $totrows, "$anniversaries2_url" . "$urlstring&amp;tngevent=$tngsaveevent&amp;tngdaymonth=$tngdaymonth&amp;tngmonth=$tngmonth&amp;tngyear=$tngyear&amp;tngkeywords=$tngkeywords&amp;tngneedresults=1&amp;offset", $maxsearchresults, $max_browsesearch_pages );
			echo "<p>$pagenav</p>";
?>
	
	<table cellpadding="3" cellspacing="1" border="0" width="100%">
		<tr>
			<td class="fieldnameback"><span class="fieldname">&nbsp;</span></td>
			<td class="fieldnameback"><span class="fieldname" style="white-space:nowrap">&nbsp;<b><?php echo $text[lastfirst]; ?></b>&nbsp;</span></td>
			<td class="fieldnameback" colspan="2"><span class="fieldname">&nbsp;<b><?php echo $datetxt; ?></b>&nbsp;</span></td>
			<td class="fieldnameback"><span class="fieldname" style="white-space:nowrap">&nbsp;<b><?php echo $text[personid]; ?></b>&nbsp;</span></td>
			<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text[tree]; ?></b>&nbsp;</span></td>
		</tr>
		
<?php
			$i = $offsetplus;
			$chartlinkimg = @GetImageSize($cms[tngpath] . "Chart.gif");
			$chartlink = "<img src=\"$cms[tngpath]" . "Chart.gif\" border=\"0\" alt=\"\" $chartlinkimg[3]>";
			while( $row = mysql_fetch_assoc($result))
			{
				if( !$row[living] || $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $row[gedcom]) && checkbranch( $row[branch] ) ) ) {
					$row[allow_living] = 1;
					if( $needfamilies ) {
						$place = $row[place1] ? $row[place1] : $row[place2];
						$placetxt = $place ? "$place <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=" . urlencode( $place ) . "\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\"></a>" : "";
						$dateval = $row[date1] ? $row[date1] : $row[date2];
					}
					else {
						$placetxt = $row[$place] ? "$row[$place] <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=" . urlencode( $row[$place] ) . "\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\"></a>" : "";
						$dateval = $row[$datefield];
					}
				}
				else
					$dateval = $placetxt = $prefix = $suffix = $title = $nickname = $birthdate = $birthplace = $deathdate = $deathplace = $livingOK = "";
				echo "<tr>";
				$name = getNameRev( $row );
	
				echo "<td class=\"databack\"><span class=\"normal\">$i</span></td>\n";
				$i++;
				echo "<td class=\"databack\"><span class=\"normal\"><a href=\"$pedigree_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$chartlink</a> <a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$name</a>&nbsp;</span></td>";
				echo "<td class=\"databack\"><span class=\"normal\">&nbsp;" . displayDate($dateval) . "</span></td><td class=\"databack\"><span class=\"normal\">$placetxt&nbsp;</span></td>";
				echo "<td class=\"databack\"><span class=\"normal\">$row[personID] </span></td>";
				echo "<td class=\"databack\"><span class=\"normal\"><a href=\"$showtree_url" . "tree=$row[gedcom]\">$row[treename]</a>&nbsp;</span></td>";
				echo "</tr>\n";
			}
			mysql_free_result($result);
?>
	
	</table>
	
<?php
			echo "<p>$pagenav</p><br />";
		}
	}
	if( !$successcount )
		echo "<p>$text[noresults].</p>";
} //end of $tng_needresults
tng_footer( "" );
?>