<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "review";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

$query = "SELECT *, DATE_FORMAT(postdate,\"%d %b %Y %H:%i:%s\") as postdate FROM $temp_events_table WHERE tempID = \"$tempID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$tree = $row[gedcom];
$personID = $row[personID];
$familyID = $row[familyID];
$eventID = $row[eventID];

//look up person or family
if( $row[type] == "I" || $row[type] == "C" ) {
	session_register('tng_search_preview');
	$tng_search_preview = $_SESSION[tng_search_preview];
	$reviewmsg = $admtext[reviewpeople];
	$getperson_url = getURL( "getperson", 1 );
	
	$query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, branch FROM $people_table WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$prow = mysql_fetch_assoc( $result );
	mysql_free_result($result);

	$persfamID = $personID;
	$name = getName( $prow );
	$checkbranch = checkbranch( $prow[branch] );
	$teststr = "  | <a href=\"$getperson_url" . "personID=$personID&amp;tree=$tree\" target=\"_blank\">$admtext[test]</a>";
	$editstr = "  | <a href=\"editperson.php?personID=$personID&amp;tree=$tree\" target=\"_blank\">$admtext[edit]</a>";
}
elseif( $row[type] == "F" ) {
	$familygroup_url = getURL( "familygroup", 1 );

	$query = "SELECT husband, wife FROM $families_table WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$frow = mysql_fetch_assoc( $result );
	$hname = $wname = "";
	if( $frow[husband] ) {
		$query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, branch FROM $people_table WHERE personID = \"$frow[husband]\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$prow = mysql_fetch_assoc( $result );
		mysql_free_result($result);
		$hname = getName( $prow );
	}
	if( $frow[wife] ) {
		$query = "SELECT firstname, lastname, lnprefix, nameorder, prefix, suffix, branch FROM $people_table WHERE personID = \"$frow[wife]\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$prow = mysql_fetch_assoc( $result );
		mysql_free_result($result);
		$wname = getName( $prow );
	}

	$persfamID = $familyID;
	$plus = $hname && $wname ? " + " : "";
	$name = "$familyID $hname$plus$wname";

	$checkbranch = 1;
	$teststr = "  | <a href=\"$familygroup_url" . "familyID=$familyID&amp;tree=$tree\" target=\"_blank\">$admtext[test]</a>";
	$editstr = "  | <a href=\"editfamily.php?familyID=$familyID&amp;tree=$tree\" target=\"_blank\">$admtext[edit]</a>";
}

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) || !$checkbranch ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

if( is_numeric($eventID) ) {
	//custom event type
	$datefield = "eventdate";
	$placefield = "eventplace";
	$factfield = "info";

	$query = "SELECT eventdate, eventplace, info FROM $events_table WHERE eventID = \"$eventID\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$evrow = mysql_fetch_assoc($result);
	mysql_free_result( $result );

	$query = "SELECT display, tag FROM $eventtypes_table, $events_table WHERE eventID = $eventID AND $eventtypes_table.eventtypeID = $events_table.eventtypeID";
	$evresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$evtrow = mysql_fetch_assoc( $evresult );
	
	if( $evtrow[display] ) {
		$dispvalues = explode( "|", $evtrow[display] );
		$numvalues = count( $dispvalues );
		if( $numvalues > 1 ) {
			$displayval = "";
			for( $i = 0; $i < $numvalues; $i += 2 ) {
				$lang = $dispvalues[$i]; 
				if( $mylanguage == $lang ) {
					$displayval = $dispvalues[$i+1];
					break;
				}
			}
		}
		else
			$displayval = $row[display];
	}
	elseif( $evtrow[tag] )
		$displayval = $eventtype[tag];
	else {
		$displayval = $admtext[$eventID];
	}
}
else {
	//standard, do switch
	$needfamilies = 0;
	$needchildren = 0;
	switch( $eventID ) {
		case "TITL":
			$factfield = "title";
			break;
		case "NPFX":
			$factfield = "prefix";
			break;
		case "NSFX":
			$factfield = "suffix";
			break;
		case "NICK":
			$factfield = "nickname";
			break;
		case "BIRT":
			$datefield = "birthdate";
			$placefield = "birthplace";
			break;
		case "CHR":
			$datefield = "altbirthdate";
			$placefield = "altbirthplace";
			break;
		case "BAPL":
			$datefield = "baptdate";
			$placefield = "baptplace";
			break;
		case "ENDL":
			$datefield = "endldate";
			$placefield = "endlplace";
			break;
		case "DEAT":
			$datefield = "deathdate";
			$placefield = "deathplace";
			break;
		case "BURI":
			$datefield = "burialdate";
			$placefield = "burialplace";
			break;
		case "MARR":
			$datefield = "marrdate";
			$placefield = "marrplace";
			$factfield = "marrtype";
			$needfamilies = 1;
			break;
		case "DIV":
			$datefield = "divdate";
			$placefield = "divplace";
			$needfamilies = 1;
			break;
		case "SLGS":
			$datefield = "sealdate";
			$placefield = "sealplace";
			$needfamilies = 1;
			break;
		case "SLGC":
			$datefield = "sealdate";
			$placefield = "sealplace";
			$needchildren = 1;
			break;
	}

	$fieldstr = $datefield;
	if( $placefield ) $fieldstr .= $fieldstr ? ", $placefield" : $placefield;
	if( $factfield ) $fieldstr .= $fieldstr ? ", $factfield" : $factfield;

	if( $needfamilies )
		$query = "SELECT $fieldstr FROM $families_table WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
	elseif( $needchildren ) {
		$query = "SELECT $fieldstr FROM $children_table WHERE familyID = \"$familyID\" AND personID = \"$personID\" AND gedcom = \"$tree\"";
	}
	else
		$query = "SELECT $fieldstr FROM $people_table WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$evrow = mysql_fetch_assoc($result);
	mysql_free_result( $result );

	$query = "SELECT count(eventID) as evcount FROM $events_table WHERE persfamID=\"$persfamID\" AND gedcom =\"$tree\" AND eventID =\"$eventID\"";
	$morelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$more = mysql_fetch_assoc( $morelinks );
	$gotmore = $more[evcount] ? "*" : "";
	mysql_free_result( $morelinks );

	$displayval = $admtext[$eventID];
}

$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc( $result );
mysql_free_result($result);

$query = "SELECT count(ID) as notecount FROM $notelinks_table WHERE persfamID=\"$persfamID\" AND gedcom =\"$tree\" AND eventID =\"$eventID\"";
$notelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$note = mysql_fetch_assoc( $notelinks );
$gotnotes = $note[notecount] ? "*" : "";
mysql_free_result( $notelinks );

$citequery = "SELECT count(citationID) as citecount FROM $citations_table WHERE persfamID=\"$persfamID\" AND gedcom =\"$tree\" AND eventID = \"$eventID\"";
$citeresult = mysql_query($citequery) or die ("$text[cannotexecutequery]: $citequery");
$cite = mysql_fetch_assoc( $citeresult );
$gotcites = $cite[citecount] ? "*" : "";
mysql_free_result( $citeresult );

$helplang = findhelp("people_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[review], $flags );
include_once("eventlib.php");
?>
<script type="text/javascript">
var persfamID = "<?php echo $personID; ?>";
</script>
</head>

<body background="../background.gif">

<?php
	if( $row[type] == "I" ) {
		$icon = "people_icon.gif";
		$hmsg = $admtext['people'];
		$peopletabs[0] = array(1,"people.php",$admtext['search'],"findperson");
		$peopletabs[1] = array($allow_add,"newperson.php",$admtext['addnew'],"addperson");
		$peopletabs[2] = array($allow_edit,"findreview.php?type=I",$admtext['review'],"review");
		$peopletabs[3] = array($allow_edit && $allow_delete,"merge.php",$admtext['merge'],"merge");
	}
	else {
		$icon = "families_icon.gif";
		$hmsg = $admtext['families'];
		$peopletabs[0] = array(1,"families.php",$admtext['search'],"findperson");
		$peopletabs[1] = array($allow_add,"newfamily.php",$admtext['addnew'],"addfamily");
		$peopletabs[2] = array($allow_edit,"findreview.php?type=F",$admtext['review'],"review");
	}
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/people_help.php#review', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($peopletabs,"review",$innermenu);
	echo displayHeadline("$hmsg &gt;&gt; $admtext[review]",$icon,$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<span class="subhead"><strong><?php echo "$persfamID: $name</strong> $teststr $editstr"; ?></span><br/><br/>
	<div class="normal">

	<form action="savereview.php" method="post" style="margin:0px;" name="form1">
	<table>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[tree]; ?>:</span></td><td><span class="normal"><?php echo $treerow[treename]; ?></span></td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td valign="top"><span class="subhead"><strong><?php echo $admtext[event]; ?></strong>:</span></td><td><span class="subhead"><strong><?php echo $displayval; ?></strong></span></td></tr>
<?php
	if( $datefield ) {
		echo "<tr><td valign=\"top\"><span class=\"normal\">$admtext[eventdate]: </span></td><td valign=\"top\"><span class=\"normal\">$evrow[$datefield]</span></td></tr>\n";
		echo "<tr><td valign=\"top\"><span class=\"normal\"><strong>$admtext[suggested]:</strong> </span></td><td valign=\"top\"><input type=\"text\" name=\"newdate\" value=\"$row[eventdate]\" onblur=\"checkDate(this);\"></td></tr>\n";
	}
	if( $placefield ) {
		$row[eventplace] = ereg_replace("\"", "&#34;",$row[eventplace]);
		echo "<tr><td valign=\"top\"><span class=\"normal\">$admtext[eventplace]: </span></td><td valign=\"top\"><span class=\"normal\">$evrow[$placefield]</span></td></tr>\n";
		echo "<tr><td valign=\"top\"><span class=\"normal\"><strong>$admtext[suggested]:</strong> </span></td><td valign=\"top\"><input type=\"text\" name=\"newplace\" size=\"40\" value=\"$row[eventplace]\"></td></tr>\n";
	}
	if( $factfield ) {
		$row[info] = ereg_replace("\"", "&#34;",$row[info]);
		echo "<tr><td valign=\"top\"><span class=\"normal\">$admtext[detail]: </span></td><td valign=\"top\"><span class=\"normal\">$row[$factfield]</span></td></tr>\n";
		echo "<tr><td valign=\"top\"><span class=\"normal\"><strong>$admtext[suggested]:</strong> </span></td><td valign=\"top\"><textarea cols=\"40\" rows=\"3\" name=\"newinfo\">$row[info]</textarea></td></tr>\n";
	}
	$row[note] = ereg_replace("\"", "&#34;",$row[note]);
?>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[usernotes]; ?>: </span></td><td valign="top"><textarea cols="40" rows="3" name="usernote"><?php echo $row[note]; ?></textarea></td></tr>
	<tr>
		<td>&nbsp;</td>
		<td>
<?php
	$notesicon = $gotnotes ? "tng_note_on.gif" : "tng_note.gif";
	$citesicon = $gotcites ? "tng_cite_on.gif" : "tng_cite.gif";
	$moreicon = $gotmore ? "tng_more_on.gif" : "tng_more.gif";
	if( !is_numeric( $eventID ) )
		echo "<a href=\"#\" onclick=\"return showMore('$eventID');\"><img src=\"$moreicon\" title=\"$admtext[more]\" alt=\"$admtext[more]\" $dims class=\"smallicon\"/></a>\n";
	echo "<a href=\"#\" onclick=\"return showNotes('$eventID');\"><img src=\"$notesicon\" title=\"$admtext[notes]\" alt=\"$admtext[notes]\" $dims class=\"smallicon\"/></a>\n";
	echo "<a href=\"#\" onclick=\"return showCitations('$eventID');\"><img src=\"$citesicon\" title=\"$admtext[sources]\" alt=\"$admtext[sources]\" $dims class=\"smallicon\"/></a>\n";
?>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext[postdate]; ?>:</span></td><td><span class="normal"><?php echo "$row[postdate] ($row[user])"; ?></span></td></tr>
	</table><br/>
	<input type="hidden" name="tempID" value="<?php echo $tempID; ?>">
	<input type="hidden" name="type" value="<?php echo $row[type]; ?>">
	<input type="hidden" name="tree" value="<?php echo $tree; ?>">
	<input type="hidden" name="choice" value="<?php echo $admtext[savedel]; ?>">
	<input type="submit" value="<?php echo $admtext[savedel]; ?>">
	<input type="submit" value="<?php echo $admtext[postpone]; ?>" onClick="document.form1.choice.value='<?php echo $admtext[postpone]; ?>';">
	<input type="submit" value="<?php echo $admtext[igndel]; ?>" onClick="document.form1.choice.value='<?php echo $admtext[igndel]; ?>';">
	<br/>
	</form>
	</div>
</td>
</tr>

</table>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
