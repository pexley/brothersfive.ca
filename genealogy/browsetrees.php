<?php
// The following page was created by Roger L. Smith (roger@ERC.MsState.Edu), 
// copyright July 2003. Used by permission.
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "stats";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );

$search_url = getURL( "search", 1 );
$surnames_oneletter_url = getURL( "surnames-oneletter", 1 );
$surnames_all_url = getURL( "surnames-all", 1 );
$getperson_url = getURL( "getperson", 1 );
$showtree_url = getURL( "showtree", 1 );
$browsetrees_url = getURL( "browsetrees", 1 );

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$browsetrees_url" . "tree=$tree\">" . xmlcharacters("$text[databasestatistics]$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( $text[databasestatistics], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_stats.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text['databasestatistics']; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'browsetrees', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1'));
?>
<br />
<table cellpadding="3" cellspacing="1" border="0" width="500">
	<TR>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<strong><?php echo $text[description]; ?></strong>&nbsp;</span></td>
		<td class="fieldnameback" width="30%"><span class="fieldname">&nbsp;<strong><?php echo $text[quantity]; ?></strong>&nbsp;</span></td>
	</tr>
<?php
$query = "SELECT lastimportdate, treename, secret FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$treerow = mysql_fetch_array( $result, MYSQL_ASSOC );
$lastimportdate = $treerow[lastimportdate];

if( $tree ) {
    $wherestr = "WHERE gedcom = \"$tree\"";
    $wherestr2 = "AND gedcom= \"$tree\"";
}
else {
    $wherestr = "";
    $wherestr2 = "";
}

$query = "SELECT count(id) as pcount FROM $people_table $wherestr";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$totalpeople = $row[pcount];
mysql_free_result($result);

$query = "SELECT count(id) as fcount FROM $families_table $wherestr";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$totalfamilies = $row[fcount];
mysql_free_result($result);

$query = "SELECT ucase( lastname) as lastname, count( ucase( lastname ) ) as lncount 
    FROM $people_table 
    WHERE ucase(lastname) 
    LIKE \"$urlfirstchar%\" $wherestr2 
    GROUP BY lastname ORDER by lastname";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$uniquesurnames = mysql_num_rows($result);
mysql_free_result($result);

$totalmedia = array();
foreach( $mediatypes as $mediatype ) {
	$mediatypeID = $mediatype[ID];
	if( $tree ) {
		$query = "SELECT count(distinct mediaID) as mcount FROM $media_table
	    WHERE mediatypeID = \"$mediatypeID\" $wherestr2";
	}
	else
		$query = "SELECT count(mediaID) as mcount FROM $media_table WHERE mediatypeID = \"$mediatypeID\"";
	$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	$totalmedia[$mediatypeID] = $row[mcount];
	mysql_free_result($result);
}

$query = "SELECT count(id) as scount FROM $sources_table $wherestr";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$totalsources = $row[scount];
mysql_free_result($result);

$query = "SELECT count(id) as pcount FROM $people_table WHERE sex = 'M' $wherestr2";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$males = $row[pcount];
mysql_free_result($result);

$query = "SELECT count(id) as pcount FROM $people_table WHERE sex = 'F' $wherestr2";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$females = $row[pcount];
mysql_free_result($result);

$query = "SELECT count(id) as pcount FROM $people_table WHERE sex != 'F' AND sex != 'M' $wherestr2";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$unknownsex = $row[pcount];
mysql_free_result($result);

$query = "SELECT count(id) as pcount FROM $people_table WHERE living != 0 $wherestr2";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
$numliving = $row[pcount];
mysql_free_result($result);

$query = "SELECT personID,firstname, lnprefix, lastname,birthdate,gedcom 
    FROM $people_table 
    WHERE birthdatetr != '0000-00-00' $wherestr2 
    ORDER BY birthdatetr LIMIT 1";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$firstbirth = mysql_fetch_array($result);
$firstbirthpersonid = $firstbirth[personID];
$firstbirthfirstname = $firstbirth[firstname];
$firstbirthlnprefix = $firstbirth[lnprefix];
$firstbirthlastname = $firstbirth[lastname];
$firstbirthdate = $firstbirth[birthdate];
$firstbirthgedcom = $firstbirth[gedcom];
mysql_free_result($result);

$query = "SELECT YEAR( deathdatetr ) - YEAR( birthdatetr ) 
	AS yearsold, DAYOFYEAR( deathdatetr ) - DAYOFYEAR( birthdatetr ) AS daysold,
	IF(DAYOFYEAR(deathdatetr) and DAYOFYEAR(birthdatetr),TO_DAYS(deathdatetr) - TO_DAYS(birthdatetr),(YEAR(deathdatetr) - YEAR(birthdatetr)) * 365) as totaldays
    FROM $people_table
    WHERE birthdatetr != '0000-00-00' AND deathdatetr != '0000-00-00'
		AND birthdate not like 'AFT%' AND deathdate not like 'AFT%'
		AND birthdate not like 'BEF%' AND deathdate not like 'BEF%'
		AND birthdate not like 'ABT%' AND deathdate not like 'ABT%'
		AND birthdate not like 'BET%' AND deathdate not like 'BET%'
		AND birthdate not like 'CAL%' AND deathdate not like 'CAL%'
		$wherestr2
    ORDER BY totaldays DESC";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numpeople = mysql_num_rows($result);
$avgyears = 0;
$avgdays = 0;
$totyears = 0;
$totdays = 0;

while( $line = mysql_fetch_array($result, MYSQL_ASSOC) )
{
	$yearsold = $line[yearsold];
	$daysold = $line[daysold];

	if( $daysold < 0 ) {
		if ($yearsold > 0) {
			$yearsold--;
			$daysold = 365 + $daysold;
		}
	}
	$totyears += $yearsold;
	$totdays += $daysold;
}
$avgyears = $numpeople ? $totyears / $numpeople : 0;

// convert the remainder from $avgyears to days
$avgdays = ($avgyears - floor($avgyears)) * 365;  

// add the number of averge days calculated from $totdays
$avgdays += $numpeople ? $totdays / $numpeople : 0;                 

// if $avgdays is more than a year, we've got to adjust things! 
if ($avgdays > 365) {
    // add the number of additional years $avgdaysgives us
	$avgyears += floor($avgdays/365);  

    //change $avgdays to days left after removing multiple 
    //years' worth of days.
	$avgdays = $avgdays - (floor($avgdays/365) * 365); 
}
$avgyears = floor($avgyears);
$avgdays = floor($avgdays);

mysql_free_result($result);

$percentmales = $totalpeople ? round(100 * $males / $totalpeople, 2) : 0;
$percentfemales = $totalpeople ? round(100 * $females / $totalpeople, 2) : 0;
$percentunknownsex = $totalpeople ? round(100 * $unknownsex / $totalpeople, 2) : 0;

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[totindividuals]</span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$totalpeople &nbsp;</span></td></tr>\n";

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[totmales]</span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$males ($percentmales%) &nbsp;</span></td></tr>\n";

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[totfemales]</span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$females ($percentfemales%) &nbsp;</span></td></tr>\n";

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[totunknown]</span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$unknownsex ($percentunknownsex%) &nbsp;</span></td></tr>\n";

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[totliving]</span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$numliving &nbsp;</span></td></tr>\n";

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[totfamilies]</span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$totalfamilies &nbsp;</span></td></tr>\n";

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[totuniquesn]</span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$uniquesurnames&nbsp;</span></td></tr>\n";

foreach( $mediatypes as $mediatype ) {
	$mediatypeID = $mediatype[ID];
	$titlestr = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
	echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[total] $titlestr</span></td>\n";
	echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">" . $totalmedia[$mediatypeID] . "&nbsp;</span></td></tr>\n";
}

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[totsources]</span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$totalsources&nbsp;</span></td></tr>\n";

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[avglifespan]<SUP><FONT size=1>1</FONT></SUP></span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">$avgyears $text[years], $avgdays $text[days]&nbsp;</span></td></tr>\n";

echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[earliestbirth] (<A HREF=\"$getperson_url" . "personID=$firstbirthpersonid&amp;tree=$firstbirthgedcom\">$firstbirthfirstname $firstbirthlnprefix $firstbirthlastname</A>)&nbsp;</span></td>\n";
echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">" . displayDate( $firstbirthdate ) . "&nbsp;</span></td></tr>\n";

if( $treerow[treename] && $lastimportdate ) {
	echo "<tr><td valign=\"top\" class=\"databack\"><span class=\"normal\">$text[lastimportdate]</span></td>\n";

	$importtime = strtotime($lastimportdate);
	if(substr($lastimport,11,8) != "00:00:00")
		$importtime += ($time_offset * 3600);
	$importdate = strftime("%d %b %Y %H:%M:%S",$importtime);

	echo "<td valign=\"top\" class=\"databack\"><span class=\"normal\">" . displayDate( $importdate ) . "</span></td></tr>\n";
}
?>
</TABLE>
<BR />
<table width="500" cellpadding="3" cellspacing="1" border="0">
	<TR>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<strong><?php echo $text[longestlived]; ?></strong><SUP><FONT size=1>1</FONT></SUP>&nbsp;</span></td>
		<td class="fieldnameback" width="30%"><span class="fieldname">&nbsp;<strong><?php echo $text[age]; ?></strong>&nbsp;</span></td>
	</tr>
<?php
$query = "SELECT personID,firstname, lnprefix, lastname, gedcom, YEAR( deathdatetr ) - YEAR( birthdatetr )
	AS yearsold, DAYOFYEAR( deathdatetr ) - DAYOFYEAR( birthdatetr ) AS daysold,
	IF(DAYOFYEAR(deathdatetr) and DAYOFYEAR(birthdatetr),TO_DAYS(deathdatetr) - TO_DAYS(birthdatetr),(YEAR(deathdatetr) - YEAR(birthdatetr)) * 365) as totaldays
    FROM $people_table
    WHERE birthdatetr != '0000-00-00' AND deathdatetr != '0000-00-00' $wherestr2
		AND birthdate not like 'AFT%' AND deathdate not like 'AFT%'
		AND birthdate not like 'BEF%' AND deathdate not like 'BEF%'
		AND birthdate not like 'ABT%' AND deathdate not like 'ABT%'
		AND birthdate not like 'BET%' AND deathdate not like 'BET%'
		AND birthdate not like 'CAL%' AND deathdate not like 'CAL%'
    ORDER BY totaldays DESC LIMIT 10";
$result =  mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numpeople = mysql_num_rows($result);

while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
{
	$personid = $line[personID];
	$firstname = $line[firstname];
	$lnprefix = $line[lnprefix];
	$lastname = $line[lastname];
	$yearsold = $line[yearsold];
	$daysold = $line[daysold];
    $gedcom = $line[gedcom];

	if( $daysold < 0 ) {
		if ($yearsold > 0) {
			$yearsold--;
			$daysold = 365 + $daysold;
		}
	}
	echo "<TR><TD valign=\"top\" class=\"databack\"><span class=\"normal\"><A HREF=\"$getperson_url" . "personID=$personid&amp;tree=$gedcom\">$firstname $lnprefix $lastname</a></span></TD>\n";
	echo "<TD valign=\"top\" class=\"databack\"><span class=\"normal\">";
	if( $yearsold )
		echo "$yearsold $text[years] ";
	if( $daysold )
		echo "$daysold $text[days]";
	echo "&nbsp;</span></TD></TR>\n";
}
echo "</table>\n";

echo "<br/><br/>\n";
echo "<table WIDTH=\"60%\" cellpadding=3 cellspacing=1 border=0>\n";
echo "<TR><td  valign=\"top\" class=\"fieldnameback\"><span class=\"fieldname\"><SUP><FONT size=1>1</FONT></SUP>&nbsp;</span></TD>";
echo "<td class=\"databack\"><span class=\"normal\">$text[agedisclaimer]</span></td></TR>";
echo "</table>\n";
mysql_free_result($result);

if( $tree && !$treerow[secret] ) {
	echo "<br/>\n";
	echo "<span class=\"normal\"><a href=\"$showtree_url" . "tree=$tree\">$text[treedetail]</a></span>\n";
	echo "<br/>\n";
}

echo "<br/>\n";
tng_footer( "" );
?>
