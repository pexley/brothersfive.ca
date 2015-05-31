<?php
include("begin.php");
if($cms['events']){include('cmsevents.php'); cms_whatsnew();}
include($cms['tngpath'] . "genlib.php");
$textpart = "whatsnew";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "functions.php" );

$getperson_url = getURL( "getperson", 1 );
$showmedia_url = getURL( "showmedia", 1 );
$familygroup_url = getURL( "familygroup", 1 );
$showsource_url = getURL( "showsource", 1 );
$showrepo_url = getURL( "showrepo", 1 );
$whatsnew_url = getURL( "whatsnew", 1 );
$pedigree_url = getURL( "pedigree", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$showtree_url = getURL( "showtree", 1 );
$showmap_url = getURL( "showmap", 1 );

$_SESSION[tng_mediatree] = $tree;
$_SESSION[tng_mediasearch] = "";

$text[pastxdays] = ereg_replace( "xx", "$change_cutoff", $text[pastxdays] );
$whatsnew = 1;

$logstring = "<a href=\"$whatsnew_url\">" . xmlcharacters("$text[whatsnew] $text[pastxdays]") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( "$text[whatsnew] $text[pastxdays]", $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_new.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo "$text[whatsnew] $text[pastxdays]"; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'whatsnew', 'method' => 'GET', 'name' => 'form1', 'id' => 'form1', 'lastimport' => true));

$header1 = "<table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\">\n";
$header1 .= "<tr>\n";
$header1 .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[thumb]</strong>&nbsp;</span></td>\n";
$header1 .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[description]</strong>&nbsp;</span></td>\n";
$hsheader = "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[cemetery]</strong>&nbsp;</span></td>\n";
$hsheader .= "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[status]</strong>&nbsp;</span></td>\n";
$header2 = "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>$text[indlinked]</strong>&nbsp;</span></td>\n";
$header2 .= "<td class=\"fieldnameback\" width=\"130\"><span class=\"fieldname\">&nbsp;<b>$text[lastmodified]</b>&nbsp;</span></td>\n";
$header2 .= "</tr>\n";
$footer = "</table>\n<br />\n";

if( $tree ) {
	$wherestr = "AND ($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\")";
	$wherestr2 = " AND $medialinks_table.gedcom = \"$tree\"";
}
else
	$wherestr = $wherestr2 = "";

if( !$change_cutoff ) $change_cutoff = 0;
if( !$change_limit ) $change_limit = 10;
$cutoffstr = "TO_DAYS(NOW()) - TO_DAYS(changedate) <= $change_cutoff";

//check for custom message
$file = "$rootpath/whatsnew.txt";
if( file_exists($file) ) {
	$contents = file($file);
	foreach( $contents as $line ) {
		if( trim($line) )
			echo "<p class=\"normal\">$line</p>";
	}
}

foreach( $mediatypes as $mediatype ) {
	$mediatypeID = $mediatype[ID];
	$header = $mediatypeID == "headstones" ? $header1 . $hsheader . $header2 : $header1 . $header2;
	echo doMedia( $mediatypeID );
}

if( $tree )
	$wherestr = "AND $people_table.gedcom = \"$tree\"";

//select from people where date later than cutoff, order by changedate descending, limit = 10
$query = "SELECT $people_table.personID, lastname, lnprefix, firstname, birthdate, prefix, suffix, nameorder, living, branch, DATE_FORMAT(changedate,'%d %b %Y') as changedatef, LPAD(SUBSTRING_INDEX(birthdate, ' ', -1),4,'0') as birthyear, birthplace, altbirthdate, LPAD(SUBSTRING_INDEX(altbirthdate, ' ', -1),4,'0') as altbirthyear, altbirthplace, $people_table.gedcom as gedcom, treename
	FROM $people_table, $trees_table WHERE $cutoffstr AND $people_table.gedcom = $trees_table.gedcom $wherestr
	ORDER BY changedate DESC, lastname, firstname, birthyear, altbirthyear LIMIT $change_limit";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if(mysql_num_rows( $result )) {
?>
<br /><span class="subhead"><b><?php echo $text['individuals']; ?></b></span><br />
<table cellpadding="3" cellspacing="1" border="0" width="100%">
	<tr>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text['id']; ?></b>&nbsp;</span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text['lastfirst']; ?></b>&nbsp;</span></td>
		<td class="fieldnameback" colspan="2"><span class="fieldname">&nbsp;<b><?php echo ($tngconfig['hidechr'] ? $text['born'] : $text['bornchr']); ?></b>&nbsp;</span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text['tree']; ?></b>&nbsp;</span></td>
		<td class="fieldnameback" width="130"><span class="fieldname">&nbsp;<b><?php echo $text['lastmodified']; ?></b>&nbsp;</span></td>
	</tr>
	
<?php
	$chartlinkimg = @GetImageSize($cms[tngpath] . "Chart.gif");
	$chartlink = "<img src=\"$cms[tngpath]" . "Chart.gif\" border=\"0\" alt=\"\" $chartlinkimg[3] />";
	while( $row = mysql_fetch_assoc($result))
	{
		$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $row[gedcom]) && checkbranch( $row[branch] ) ) ? 1 : 0;
		$namestr = getNameRev( $row );
		if( $row[allow_living] ) {
			if ( $row[birthdate] ) {
				$birthdate = "$text[birthabbr] " . displayDate( $row[birthdate] );
				$birthplace = $row[birthplace];
			}
			else if ( $row[altbirthdate] ) {
				$birthdate = "$text[chrabbr] " . displayDate( $row[altbirthdate] );
				$birthplace = $row[altbirthplace];
			}
			else {
				$birthdate = "";
				$birthplace = "";
			}
		}
		else
			$birthdate = $birthplace = "";
		if( $birthplace )
			$birthplace .= " <a href=\"$placesearch_url" . "tree=$row[gedcom]&amp;psearch=" . urlencode($birthplace) . "\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"\" width=\"9\" height=\"9\" /></a>";

		echo "<tr><td class=\"databack\"><span class=\"normal\"><a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$row[personID]</a>&nbsp;</span></td>";
		echo "<td class=\"databack\"><span class=\"normal\"><a href=\"$pedigree_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$chartlink</a> <a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$namestr</a>&nbsp;</span></td>\n";
		echo "<td class=\"databack\" style=\"white-space:nowrap\"><span class=\"normal\">$birthdate&nbsp;</span></td><td class=\"databack\"><span class=\"normal\">&nbsp;$birthplace&nbsp;</span></td>";
		echo "<td class=\"databack\"><span class=\"normal\"><a href=\"$showtree_url" . "tree=$row[gedcom]\">$row[treename]</a>&nbsp;</span></td>";
		echo "<td class=\"databack\"><span class=\"normal\">" . displayDate( $row[changedatef] ) . "&nbsp;</span></td></tr>\n";
	}
	mysql_free_result($result);
?>
</table>
<br /><br />
<?php
}

//select husband, wife from families where date later than cutoff, order by changedate descending, limit = 10
if( $tree )
	$allwhere = "AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\" AND $trees_table.gedcom = \"$tree\"";
else
	$allwhere = " AND $people_table.gedcom = $families_table.gedcom AND $people_table.gedcom = $trees_table.gedcom";

$query = "SELECT familyID, husband, wife, marrdate, $families_table.gedcom as gedcom, firstname, lnprefix, lastname, prefix, suffix, nameorder, $families_table.living as fliving, $people_table.living as living, $families_table.gedcom as gedcom, DATE_FORMAT($families_table.changedate,'%d %b %Y') as changedatef, treename
	FROM $families_table, $people_table, $trees_table WHERE TO_DAYS(NOW()) - TO_DAYS($families_table.changedate) <= $change_cutoff AND $people_table.personID = husband $allwhere
	ORDER BY $families_table.changedate DESC, lastname LIMIT $change_limit";
$famresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if(mysql_num_rows( $famresult )) {
?>
<span class="subhead"><b><?php echo $text[families]; ?></b></span><br />
<table cellpadding="3" cellspacing="1" border="0" width="100%">
	<tr>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text[id]; ?></b>&nbsp;</span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text[husbid]; ?></b>&nbsp;</span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text[husbname]; ?></b>&nbsp;</span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text[wifeid]; ?></b>&nbsp;</span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text[married]; ?></b>&nbsp;</span></td>
		<td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $text[tree]; ?></b>&nbsp;</span></td>
		<td class="fieldnameback" width="130"><span class="fieldname">&nbsp;<b><?php echo $text[lastmodified]; ?></b>&nbsp;</span></td>
	</tr>
	
<?php
	while( $row = mysql_fetch_assoc($famresult))
	{
		$query = "SELECT living, branch FROM $people_table WHERE $people_table.personID = \"$row[wife]\"";
		$wiferesult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$wiferow = mysql_fetch_assoc($wiferesult);
		$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $row[gedcom]) && checkbranch( $row[branch] ) ) ? 1 : 0;
		//look up wife
		echo "<tr><td class=\"databack\" valign=\"top\"><span class=\"normal\">&nbsp;<a href=\"$familygroup_url" . "familyID=$row[familyID]&amp;tree=$row[gedcom]\">$row[familyID]</a>&nbsp;</span></td><td class=\"databack\" valign=\"top\"><span class=\"normal\">&nbsp;<a href=\"$getperson_url" . "personID=$row[husband]&amp;tree=$row[gedcom]\">$row[husband]</a>&nbsp;</span></td>\n";
		echo "<td class=\"databack\" valign=\"top\"><span class=\"normal\"><a href=\"$getperson_url" . "personID=$row[husband]&amp;tree=$row[gedcom]\">";
		echo getName( $row );
		echo "</a>&nbsp;</span></td>\n";
		echo "<td class=\"databack\" valign=\"top\"><span class=\"normal\"><a href=\"$getperson_url" . "personID=$row[wife]&amp;tree=$row[gedcom]\">$row[wife]</a>&nbsp;</span></td>\n";
		echo "<td class=\"databack\" valign=\"top\"><span class=\"normal\">";
		if( !$row[fliving] || $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $row[gedcom]) && checkbranch( $row[branch] ) ) )
			echo displayDate( $row[marrdate] );
		echo "&nbsp;</span></td>\n";
		echo "<td class=\"databack\"><span class=\"normal\"><a href=\"$showtree_url" . "tree=$row[gedcom]\">$row[treename]</a>&nbsp;</span></td>";
		echo "<td class=\"databack\" valign=\"top\"><span class=\"normal\">" . displayDate( $row[changedatef] ) . "&nbsp;</span></td></tr>\n";
	}
	mysql_free_result($famresult);
?>
</table>
<br /><br />
<?php
}
tng_footer( "" );
?>
