<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "reports";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "functions.php");
include($cms['tngpath'] . "log.php" );

function processfield( $field ) {
	global $need_families, $cejoins, $evfields, $people_table, $events_table, $familyfields_nonss;

	if( in_array( $field, $familyfields_nonss ) ) {
		$newfield = "if(sex='M',families1." . $field . ",families2." . $field . ")";
		$need_families = 1;
	}
	elseif( substr($field,0,2) == "ss" ) {
		$newfield = "if(sex='M',families1." . substr($field,1) . ",families2." . substr($field,1) . ")";
		$need_families = 1;
	}
	elseif( substr($field,0,2) == "ce" ) {
		$eventtypeID = substr( $field,6 );
		$subtype = substr( $field,3,2 );
		$newfield = "e$eventtypeID.$evfields[$subtype]";
		if( !isset( $cejoins[$eventtypeID] ) )
			$cejoins[$eventtypeID] = "LEFT JOIN $events_table e$eventtypeID ON $people_table.personID = e$eventtypeID.persfamID AND $people_table.gedcom = e$eventtypeID.gedcom AND e$eventtypeID.eventtypeID = \"$eventtypeID\"";
	}
	else
		$newfield = $field;
	return $newfield;
}

$showreport_url = getURL( "showreport", 1 );
$showtree_url = getURL( "showtree", 1 );
$getperson_url = getURL( "getperson", 1 );
$placesearch_url = getURL( "placesearch", 1 );

$ldsfields = array("baptdate","baptplace","endldate","endlplace","ssealdate","ssealplace","psealdate","psealplace");

$max_browsesearch_pages = 5;
if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$newoffset = "";
	$offsetplus = 1;
	$page = 1;
}
	
$query = "SELECT * FROM $reports_table WHERE reportID = $reportID";
if(!$test) $query .= " and active > 0";
$testurl = $test ? "&amp;test=$test" : "";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$rrow = mysql_fetch_assoc( $result );
mysql_free_result($result);

if( $rrow[sqlselect] ) {
	$rrow[sqlselect] = ereg_replace("\r\n"," ",$rrow[sqlselect]);
	$rrow[sqlselect] = ereg_replace("\r"," ",$rrow[sqlselect]);
	$rrow[sqlselect] = ereg_replace("\n"," ",$rrow[sqlselect]);
	if( strtoupper( substr( $rrow[sqlselect],0,7 ) ) == "SELECT " ) {
		$sqlselect = substr( $rrow[sqlselect],7 );
		$query = $rrow[sqlselect];
	}
	else {
		$sqlselect = $rrow[sqlselect];
		$query = "SELECT $rrow[sqlselect]";
	}
	$fromat = strpos( strtoupper( $sqlselect ), " FROM " );
	$sqlselect = substr( $sqlselect, 0, $fromat );
	
	$displayfields = explode( "," , $sqlselect );
	$newds = array();
	$newdsctr = 0;
	for( $i = 0; $i < count( $displayfields ); $i++ ) {
		$displaymsg = "";
		$tempmsg = $displayfields[$i];
		do {
			$numopen = substr_count($tempmsg,"(");
			$numclosed = substr_count($tempmsg,")");
			if( $numopen != $numclosed && $i < (count( $displayfields ) - 1) ) {
				$i++;
				$tempmsg = $tempmsg . "," . $displayfields[$i];
			}
		} while( $numopen != $numclosed );

		$gotas = strpos( strtoupper($displayfields[$i]), " AS " );
		$gotas = strpos( strtoupper($tempmsg), " AS " );
		if( $gotas )
			$tempmsg = substr( $tempmsg,$gotas+4 );
		else {
			$gotperiod = strpos( $tempmsg, "." );
			if( $gotperiod )
				$tempmsg = substr( $tempmsg,$gotperiod+1 );
		}
		$dfield = $tempmsg = trim( $tempmsg );
		if( $dfield == "personID" ) {
			$dfield = "personid";
			$gotpersonid = true;
		}
		else
			$gotpersonid = false;
		if( !$displaymsg ) $displaymsg = $text[$dfield];
		if( !$displaymsg ) $displaymsg = $text[strtolower($dfield)];
		if( !$displaymsg ) $displaymsg = $dfield;
		$displaytext .= "<td class=\"fieldnameback\"><span class=\"fieldname\"><strong>$displaymsg</strong></span></td>\n";

		$newds[$newdsctr] = $tempmsg;
		$newdsctr++;
	}
	$newds[$newdsctr] = "";
	$displayfields = $newds;
	$query = str_replace(";", "", $rrow[sqlselect] );
}
else {
	if( $tree ) {
		$peopletreestr = "$people_table.gedcom = \"$tree\"";
		//$familytreestr = "if(sex='M',families1.gedcom = \"$tree\",families2.gedcom = \"$tree\")";
		$childrentreestr = "$children_table.gedcom = \"$tree\"";
	}
	else {
		$peopletreestr = "";
		//$familytreestr = "";
		$childrentreestr = "";
	}
	$treestr = $peopletreestr;
	$trees_join = "";
	
	$need_families = 0;
	$need_children = 0;
	
	$subtypes = array();
	$evfields[dt] = "eventdate";
	$evfields[tr] = "eventdatetr";
	$evfields[pl] = "eventplace";
	$evfields[fa] = "info";
	
	$subtypes[dt] = $text[date];
	$subtypes[pl] = $text[place];
	$subtypes[fa] = $text[fact];

	$displaytext = "";
	$truedates = array("birthdatetr","altbirthdatetr","deathdatetr","burialdatetr","baptdatetr","endldatetr","ssealdatetr","psealdatetr","marrdatetr","changedate");
	$familyfields = array("marrdate","marrdatetr","marrplace","divdate","divdatetr","divplace","ssealdate","ssealdatetr","ssealplace");
	$familyfields_nonss = array("marrdate","marrdatetr","marrplace","divdate","divdatetr","divplace");
	$cejoins = array();

	$displaystr = "$people_table.living, lnprefix, prefix, suffix, $people_table.branch";
	$displayfields = explode( $lineending, $rrow[display] );
	$dtreestr = "";
	for( $i = 0; $i < count( $displayfields ) - 1; $i++ ) {
		$dfield = $displayfields[$i];
		$tngprefix = substr( $dfield,0,2 );
		$displaymsg = "";
		
		if( $dfield != "personID" && ( $allow_lds_db || !in_array( $dfield, $ldsfields ) ) ) {
			if( $displaystr ) $displaystr .= ",";
			if( in_array( $dfield, $familyfields_nonss ) ) {
				if( $dfield == "marrdatetr" || $dfield == "divdatetr" || $dfield == "ssealdatetr" )
					$displayfields[$i] = "if(sex='M',DATE_FORMAT(families1." . $dfield . ",'%d %b %Y'),DATE_FORMAT(families2." . $dfield . ",'%d %b %Y'))";
				else
					$displayfields[$i] = "if(sex='M',families1." . $dfield . ",families2." . $dfield . ")";
				$need_families = 1;
			}
			if( $tngprefix == "ss" ) {
				$need_families = 1;
				$displayfields[$i] = "if(sex='M',families1." . substr($dfield,1) . ",families2." . substr($dfield,1) . ")";
			}
			if( $tngprefix == "ps" ) {
				$displayfields[$i] = "$children_table." . substr($dfield,1);
				$need_children = 1;
			}
			if( substr( $dfield, 0, 6 ) == "spouse" ) {
				$need_families = 1;
				$displaystr .= "(if(sex='M',families1.wife,families2.husband)) as spouse";
			}
			elseif( in_array( $dfield, $truedates ) )
				$displaystr .= "DATE_FORMAT($people_table.$dfield,'%d %b %Y') as $dfield" . "_disp";
			elseif( $dfield == "gedcom" ) {
				$trees_join = ", $trees_table";
				if( !$dtreestr ) $dtreestr = " $people_table.gedcom = $trees_table.gedcom";
				$displaystr .= "treename";
				$displayfields[$i] = "treename";
			}
			elseif( $tngprefix == "ce" ) {
				$eventtypeID = substr( $dfield,6 );
				$query = "SELECT display FROM $eventtypes_table WHERE eventtypeID=\"$eventtypeID\"";
				$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$evrow = mysql_fetch_assoc( $evresult );
				mysql_free_result( $evresult );
	
				$subtype = substr( $dfield,3,2 );
				$displaymsg = getEventDisplay( $evrow[display] ) . ": " . $subtypes[$subtype];

				$displaystr .= "e$eventtypeID.$evfields[$subtype] as $evfields[$subtype]$eventtypeID";
				$displayfields[$i] = "$evfields[$subtype]$eventtypeID";
				if( !isset( $cejoins[$eventtypeID] ) )
					$cejoins[$eventtypeID] = "LEFT JOIN $events_table e$eventtypeID ON $people_table.personID = e$eventtypeID.persfamID AND $people_table.gedcom = e$eventtypeID.gedcom AND e$eventtypeID.eventtypeID = \"$eventtypeID\"";
			}
			elseif( $dfield == "lastfirst" )
				$displaystr .= "lastname, firstname";
			elseif( $dfield == "fullname" )
				$displaystr .= "firstname, lastname";
			else
				$displaystr .= $displayfields[$i];
		}
		if( !$displaymsg ) $displaymsg = $text[$dfield];
		if( !$displaymsg ) $displaymsg = $text[strtolower($dfield)];
		$displaytext .= "<td class=\"fieldnameback\"><span class=\"fieldname\"><strong>$displaymsg</strong></span></td>\n";
	}
	if( $dtreestr ) {
		if( $treestr ) $treestr .= " AND";
		$treestr .= $dtreestr;
	}
	$displaystr .= ", $people_table.personID, $people_table.gedcom, nameorder";
	
	$needliving = 0;
	$criteriastr = "";
	$criteriafields = explode( $lineending, $rrow[criteria] );
	for( $i = 0; $i < count( $criteriafields ) - 1; $i++ ) {
		$table = "";
		if( $criteriastr ) $criteriastr .= " ";
		if( in_array( $criteriafields[$i], $familyfields ) )
			$need_families = 1;
	
		if( $criteriafields[$i] == "currmonth" )
			$criteriafields[$i] = "\"" . strtoupper( date( "M" ) ) . "\"";
		else if( $criteriafields[$i] == "currmonthnum" )
			$criteriafields[$i] = "\"" . date( "m" ) . "\"";
		else if( $criteriafields[$i] == "curryear" )
			$criteriafields[$i] = "\"" . date( "Y" ) . "\"";
		else if( $criteriafields[$i] == "currday" )
			$criteriafields[$i] = "\"" . date( "d" ) . "\"";
		else if( $criteriafields[$i] == "personID" )
			$criteriafields[$i] = "$people_table.personID";
		else if( $criteriafields[$i] == "today" ) {
			$criteriafields[$i] = "NOW()";
			$truedate = 1;
		}
		else if( in_array($criteriafields[$i],$truedates) ) {
			$truedate = 1;
		}
			
		switch( $criteriafields[$i] ) {
			case "dayonly":
			case "monthonly":
			case "yearonly":
			case "to_days":
				$criteriastr .= "";
				break;
			case "contains":
			case "starts with":
			case "ends with":
				$criteriastr .= "LIKE";
				break;
			case "living":
				$criteriastr .= "$people_table.living = 1";
				$needliving = 1;
				break;
			case "dead":
				$criteriastr .= "$people_table.living != 1";
				$needliving = 1;
				break;
			default:
				if( in_array( $criteriafields[$i], $familyfields_nonss ) ) {
					$newcriteria = "if(sex='M',families1." . $criteriafields[$i] . ",families2." . $criteriafields[$i] . ")";
					$need_families = 1;
				}
				else {
					if( substr( $criteriafields[$i],0,2 ) == "ce" ) {
						$eventtypeID = substr( $criteriafields[$i],6 );
						$subtype = substr( $criteriafields[$i],3,2 );
						$newcriteria = "e$eventtypeID.$evfields[$subtype]";
						if( !isset( $cejoins[$eventtypeID] ) )
							$cejoins[$eventtypeID] = "LEFT JOIN $events_table e$eventtypeID ON $people_table.personID = e$eventtypeID.persfamID AND $people_table.gedcom = e$eventtypeID.gedcom AND e$eventtypeID.eventtypeID = \"$eventtypeID\"";
					}
					else {
						$newcriteria = $criteriafields[$i];
						if( $newcriteria == "changedate" )
							$newcriteria = "$people_table." . $newcriteria;
					}
				}
	
				switch( $criteriafields[$i-1] ) {
					case "dayonly":
						if( $truedate )
							$criteriastr .= "DAYOFMONTH($newcriteria)";
						else
							$criteriastr .= "LPAD(SUBSTRING_INDEX($newcriteria, ' ', 1),2,'0')";
						break;
					case "monthonly":
						if( $truedate )
							$criteriastr .= "MONTH($newcriteria)";
						else
							$criteriastr .= "substring(SUBSTRING_INDEX($newcriteria, ' ', -2),1,3)";
						break;
					case "yearonly":
						if( $truedate )
							$criteriastr .= "YEAR($newcriteria)";
						else
							$criteriastr .= "LPAD(SUBSTRING_INDEX($newcriteria, ' ', -1),4,'0')";
						break;
					case "to_days":
						if( $truedate )
							$criteriastr .= "TO_DAYS($newcriteria)";
						else
							$criteriastr .= "LPAD(SUBSTRING_INDEX($newcriteria, ' ', -1),4,'0')";
						break;
					case "contains":
						if( substr( $criteriafields[$i], 0, 1 ) == "\"" )
							$newcriteria = substr( $criteriafields[$i], 1, -1 );
						$criteriastr .= "\"%" . $newcriteria . "%\"";
						break;
					case "starts with":
						if( substr( $criteriafields[$i], 0, 1 ) == "\"" )
							$newcriteria = substr( $criteriafields[$i], 1, -1 );
						$criteriastr .= "\"" . $newcriteria . "%\"";
						break;
					case "ends with":
						if( substr( $criteriafields[$i], 0, 1 ) == "\"" )
							$newcriteria = substr( $criteriafields[$i], 1, -1 );
						$criteriastr .= "\"%" . $newcriteria . "\"";
						break;
					default:
						if( substr($criteriafields[$i],0,2) == "ps" ) {
							$criteriastr .= "$children_table." . substr($criteriafields[$i],1);
							$need_children = 1;
						}
						else if( substr($criteriafields[$i],0,2) == "ss" ) {
							$criteriastr .= "if(sex='M',families1." . substr($criteriafields[$i],1) . ",families2." . substr($criteriafields[$i],1) . ")";
							$need_families = 1;
						}
						else if( $criteriafields[$i] == "gedcom" )
							$criteriastr .= "$people_table.$newcriteria";
						else
							$criteriastr .= $newcriteria;
						break;
				}
				break;
		}
	}
	if( $livedefault < 2 && ( !$allow_living_db || $assignedtree ) && !$needliving ) {
		if( $criteriastr ) $criteriastr = "($criteriastr) AND ";
		if( $allow_living_db ) {  //must have an assigned tree or we wouldn't be here
			if( $assignedbranch )
				$criteriastr .= "($people_table.living != 1 OR ($people_table.gedcom = \"$assignedtree\" AND $people_table.branch LIKE \"%$assignedbranch%\") )";
			else
				$criteriastr .= "($people_table.living != 1 OR $people_table.gedcom = \"$assignedtree\")";
		}
		else
			$criteriastr .= "$people_table.living != 1";
	}
	if( $criteriastr )
		$criteriastr = "WHERE ($criteriastr)";
	
	$orderbystr = "";
	$orderbyfields = explode( $lineending, $rrow[orderby] );
	for( $i = 0; $i < count( $orderbyfields ) - 1; $i++ ) {
		if( $orderbystr ) {
			if( $orderbyfields[$i] == "desc" )
				$orderbystr .= " ";
			else
				$orderbystr .= ",";
		}
		$tngprefix = "";
		if( $orderbyfields[$i] == "dayonly" ) {
			$i++;
			$newfield = processfield( $orderbyfields[$i] );
			if( in_array($orderbyfields[$i],$truedates) )
				$newfield = "DAYOFMONTH($newfield)";
			else
				$newfield = "LPAD(SUBSTRING_INDEX($newfield, ' ', 1),2,'0')";
			$displaystr .= ", $newfield as dayonly$orderbyfields[$i]";
			$orderbystr .= "dayonly$orderbyfields[$i]";
		}
		else if( $orderbyfields[$i] == "monthonly" ) {
			$i++;
			$newfield = processfield( $orderbyfields[$i] );
			if( in_array($orderbyfields[$i],$truedates) )
				$newfield = "MONTH($newfield)";
			else
				$newfield = "SUBSTRING_INDEX($newfield, ' ', 2)";
			$displaystr .= ", $newfield as monthonly$orderbyfields[$i]";
			$orderbystr .= "monthonly$orderbyfields[$i]";
		}
		else if( $orderbyfields[$i] == "yearonly" ) {
			$i++;
			$newfield = processfield( $orderbyfields[$i] );
			if( in_array($orderfields[$i],$truedates) )
				$newfield = "YEAR($newfield)";
			else
				$newfield = "LPAD(SUBSTRING_INDEX($newfield, ' ', -1),4,'0')";
			$displaystr .= ", $newfield as yearonly$orderbyfields[$i]";
			$orderbystr .= "yearonly$orderbyfields[$i]";
		}
		else if( $orderbyfields[$i] == "personID" )
			$orderbystr .= "$people_table.personID";
		else if( substr($orderbyfields[$i],0,2) == "ps" ) {
			$orderbystr .= "$children_table." . substr($orderbyfields[$i],1);
			$need_children = 1;
		}
		else
			$orderbystr .= processfield( $orderbyfields[$i] );
	}
	if( $orderbystr )
		$orderbystr = "ORDER BY $orderbystr";
	
	if( $need_families ) {
		$families_join = "LEFT JOIN $families_table AS families1 ON ($people_table.gedcom = families1.gedcom AND $people_table.personID = families1.husband ) LEFT JOIN $families_table AS families2 ON ($people_table.gedcom = families2.gedcom AND $people_table.personID = families2.wife ) ";
		//$families_join = "LEFT JOIN $families_table ON ($people_table.personID = $families_table.husband OR $people_table.personID = $families_table.wife) AND $people_table.gedcom = $families_table.gedcom";
		//if( $familytreestr ) $treestr .= " AND $familytreestr";
	}
	else
		$families_join = "";
	if( $need_children ) {
		$children_join = "LEFT JOIN $children_table ON $people_table.personID = $children_table.personID AND $people_table.gedcom = $children_table.gedcom";
		if( $childrentreestr ) $treestr .= " AND $childrentreestr";
	}
	else
		$children_join = "";
	
	if( $treestr )
		$treestr = $criteriastr ? "AND $treestr" : "WHERE $treestr";
		
	$cejoin = "";
	foreach( $cejoins as $join )
		$cejoin .= " $join";
	
	$query = "SELECT $displaystr FROM ($people_table $trees_join) $families_join $children_join $cejoin $criteriastr $treestr $orderbystr";
}
//echo $query . " LIMIT $newoffset" . $maxsearchresults;
$result = @mysql_query($query . " LIMIT $newoffset" . $maxsearchresults );

$showreport_url = getURL( "showreport", 1 );
$treelogstr = $tree ? " ($text[tree]: $tree)" : "";
if($rrow[active]) {
	$logstring = "<a href=\"$showreport_url" . "reportID=$reportID&amp;tree=$tree\">" . xmlcharacters("$text[report]: $rrow[reportname]$treelogstr") . "</a>";
	writelog($logstring);
	preparebookmark($logstring);
}

tng_header( $rrow[reportname], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_rpt.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo "$text[report]: $rrow[reportname]"; ?><br />
<span class="normal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "$text[description]: " . nl2br($rrow[reportdesc]); ?></span></p><br clear="left"/>

<?php
if( $test )
	echo "<p class=\"normal\"><strong>SQL:</strong> $query</p>\n";
echo tng_coreicons();

if(!$rrow[sqlselect]) {
	$hiddenfields[] = array('name' => 'reportID', 'value' => $reportID);
	echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'showreport', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields));
}

if( !$result ) {
?>

<p class="normal"><?php echo "<b>$text[error]:</b> $text[reportsyntax] (ID: $rrow[reportID]) $text[wasincorrect] "; ?>
<?php echo "<a href=\"mailto:$emailaddr\">$emailaddr</a>"; ?>.</p>
<p><?php echo "$text[query]: $query <br/>$text[errormessage]:"; ?>
<?php echo mysql_error(); ?></p>

<?php
}
else {
	$numrows = mysql_num_rows( $result );
	if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
		if( $rrow[sqlselect] ) {
			if( $gotpersonid )
				$query = "SELECT count( $people_table.personID ) as rcount $fromat";
			else {
				$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
				$totrows = mysql_num_rows( $result2 );
				$query = "";
			}
		}
		else
			$query = "SELECT count($people_table.personID) as rcount FROM ($people_table $trees_join) $families_join $children_join $cejoin $criteriastr $treestr";
		if( $query ) {
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$countrow = mysql_fetch_assoc($result2);
			$totrows = $countrow[rcount];
		}
	}
	else
		$totrows = $numrows;
	
	$numrowsplus = $numrows + $offset;
	if( $totrows )
		echo "<p>$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows</p>";

	$pagenav = get_browseitems_nav( $totrows, "$showreport_url" . "reportID=$reportID$testurl&amp;offset", $maxsearchresults, $max_browsesearch_pages );
	echo "<p>$pagenav</p>\n";
?>

<table cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td class="fieldnameback"><span class="fieldname">#</span></td>
<?php
	//Column headings print here
	echo $displaytext;
?>
	</tr>
<?php
	$rowcount = $offset;
	while( $row = mysql_fetch_assoc($result)) {
		$rowcount++;
		$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $row[gedcom] ) && checkbranch( $row[branch] ) ) ? 1 : 0;
		echo "<tr>\n";
		echo "<td class=\"databack\"><span class=\"normal\">$rowcount</span></td>\n";
		for( $i = 0; $i < count( $displayfields ) - 1; $i++ ) {
			$thisfield = $displayfields[$i];
			if( $thisfield == "lastfirst" )
				$data = "<a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">" . getNameRev( $row ) . "</a>";
			else if( $thisfield == "fullname" )
				$data = "<a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">" . getName( $row ) . "</a>";
			else if( strtoupper(substr($thisfield,-8)) == strtoupper("personID") )
				$data = "<a href=\"$getperson_url" . "personID=$row[$thisfield]&amp;tree=$row[gedcom]\">$row[$thisfield]</a>";
			else if( $thisfield == "treename" )
				$data = "<a href=\"$showtree_url" . "tree=$row[gedcom]\">$row[treename]</a>";
			else if( substr( $thisfield, 0, 6 ) == "spouse" ) {
				$spouseID = $row[spouse];
				if( $thisfield == "spousename" ) {
					$query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, gedcom, living, branch FROM $people_table WHERE personID = \"$spouseID\" AND gedcom = \"$row[gedcom]\"";
					$spresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
					if( $spresult ) {
						$sprow = mysql_fetch_assoc($spresult);
						$sprow[allow_living] = !$sprow[living] || $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $sprow[gedcom] ) && checkbranch( $sprow[branch] ) ) ? 1 : 0;
						$data = "<a href=\"$getperson_url" . "personID=$spouseID&amp;tree=$sprow[gedcom]\">" . getName( $sprow ) . "</a>";
						mysql_free_result($spresult);
					}
					else
						$data = "";
				}
				else
					$data = "<a href=\"$getperson_url" . "personID=$spouseID&amp;tree=$sprow[gedcom]\">$spouseID</a>";
			}
			else if( $row[allow_living] && ( !in_array( $thisfield, $ldsfields ) || ( $allow_lds_db && (!$assignedtree || $assignedtree == $row[gedcom] ) && checkbranch( $row[branch] ) ) ) ) {
				if( strpos( $thisfield, "date" ) ) {
					$tempdate = $row[$thisfield];
					if($tempdate)
						$rawdate = $tempdate;
					else {
						$datedisp = $thisfield . "_disp";
						$rawdate = $row[$datedisp];
					}
					$data = displayDate( $rawdate );
				}
				else {
					$data = nl2br( $row[$thisfield] );
					if( strpos( $thisfield, "place" ) && $data )
						$data .=  " <a href=\"$placesearch_url" . "tree=$tree&amp;psearch=" . urlencode($data) . "\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"\" width=\"9\" height=\"9\" /></a>";
				}
			}
			else
				$data = "&nbsp;";
			echo "<td class=\"databack\"><span class=\"normal\">$data&nbsp;</span></td>\n";
		}
		echo "</tr>\n";
	}
	mysql_free_result($result);
?>
</table>
<br/><br/>
<?php
	echo $pagenav;
	echo "<br /><br />\n";
}

tng_footer( "" );
?>
