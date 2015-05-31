<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
$textpart = "getperson";
include($cms[tngpath] . "getlang.php");
include($cms[tngpath] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");

$factfield = $datefield = $placefield = "";

if( $type == "I" || $type == "C" ) {
	if( $type == "I" ) {
		$personID = $persfamID;
		$familyID = "";
	}
	else { //type C
		$ids = explode( "::", $persfamID );
		$personID = $ids[0];
		$familyID = $ids[1];
	}
	$query = "SELECT firstname, lastname, lnprefix, suffix, nameorder, living, branch
		FROM $people_table WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$namerow = mysql_fetch_assoc($result);
	$rightbranch = checkbranch( $namerow[branch] ) ? 1 : 0;
	$namerow[allow_living] = !$namerow[living] || ( $allow_living && $rightbranch ) ? 1 : 0;
	$name = getName( $namerow );
	mysql_free_result( $result );
}
elseif( $type == "F" ) {
	$personID = "";
	$familyID = $persfamID;

	$query = "SELECT husband, wife, living, branch FROM $families_table WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$frow = mysql_fetch_assoc( $result );
	$hname = $wname = "";
	if( $frow[husband] ) {
		$query = "SELECT firstname, lastname, lnprefix, nameorder, suffix, living, branch FROM $people_table WHERE personID = \"$frow[husband]\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$prow = mysql_fetch_assoc( $result );
		mysql_free_result($result);
		$prow[allow_living] = !$prow[living] || ( $allow_living && $rightbranch ) ? 1 : 0;
		$hname = getName( $prow );
	}
	if( $frow[wife] ) {
		$query = "SELECT firstname, lastname, lnprefix, nameorder, suffix, living, branch FROM $people_table WHERE personID = \"$frow[wife]\" AND gedcom = \"$tree\"";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$prow = mysql_fetch_assoc( $result );
		mysql_free_result($result);
     	$prow[allow_living] = !$prow[living] || ( $allow_living && $rightbranch ) ? 1 : 0;
		$wname = getName( $prow );
	}

	$persfamID = $familyID;
	$plus = $hname && $wname ? " + " : "";
	$name = "$text[family] $familyID<br />$hname$plus$wname";
}

if( is_numeric($event) ) {
	//custom event type
	$datefield = "eventdate";
	$placefield = "eventplace";
	$factfield = "info";

	$query = "SELECT eventdate, eventplace, info FROM $events_table WHERE eventID = \"$event\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	mysql_free_result( $result );
}
else {
	//standard, do switch
	$needfamilies = 0;
	$needchildren = 0;
	switch( $event ) {
		case "TITL":
			$factfield = "title";
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
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	mysql_free_result( $result );
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="tentedit">
<p class="subhead"><strong><?php echo $text['editevent']; ?></strong></p>

<p class="header"><?php echo "$name: $title"; ?></p>
<?php
echo getFORM( "", "post", "form1\" onsubmit=\"return saveTentEdit(this);", "form1" );
?>
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<input type="hidden" name="personID" value="<?php echo $personID; ?>">
<input type="hidden" name="familyID" value="<?php echo $familyID; ?>">
<input type="hidden" name="eventID" value="<?php echo $event; ?>">
<input type="hidden" name="type" value="<?php echo $type; ?>">
<table border="0" cellspacing="0" cellpadding="2">
<?php
	if( $datefield ) {
		echo "<tr><td valign=\"top\"><span class=\"normal\">$text[date]: </span></td><td valign=\"top\"><span class=\"normal\">$row[$datefield]</span></td></tr>\n";
		echo "<tr><td valign=\"top\"><span class=\"normal\">$text[suggested]: </span></td><td valign=\"top\"><input type=\"text\" name=\"newdate\" value=\"$row[$datefield]\"></td></tr>\n";
		echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
	}
	if( $placefield ) {
		$row[$placefield] = ereg_replace("\"", "&#34;",$row[$placefield]);
        if($session_charset != "UTF-8")
			$row[$placefield] = utf8_encode($row[$placefield]);
		echo "<tr><td valign=\"top\"><span class=\"normal\">$text[place]: </span></td><td valign=\"top\"><span class=\"normal\">$row[$placefield]</span></td></tr>\n";
		echo "<tr><td valign=\"top\"><span class=\"normal\">$text[suggested]: </span></td><td valign=\"top\"><input type=\"text\" name=\"newplace\" size=\"40\" value=\"$row[$placefield]\"></td></tr>\n";
		echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
	}
	if( $factfield ) {
		$row[$factfield] = ereg_replace("\"", "&#34;",$row[$factfield]);
        if($session_charset != "UTF-8")
			$row[$factfield] = utf8_encode($row[$factfield]);
		$factmsg = $event == "MARR" ? $text[type] : $text[fact];
		echo "<tr><td valign=\"top\"><span class=\"normal\">$factmsg: </span></td><td valign=\"top\"><span class=\"normal\">$row[$factfield]</span></td></tr>\n";
		echo "<tr><td valign=\"top\"><span class=\"normal\">$text[suggested]: </span></td><td valign=\"top\">";
		if($event == "MARR")
			echo "<input type=\"text\" name=\"newinfo\" size=\"40\" value=\"$row[$factfield]\">";
		else
			echo "<textarea cols=\"40\" rows=\"3\" name=\"newinfo\">$row[$factfield]</textarea>";
		echo "</td></tr>\n";
		echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
	}
?>
		<tr><td valign="top"><span class="normal"><?php echo $text['notes']; ?>: </span></td><td valign="top"><textarea cols="40" rows="3" name="usernote"></textarea></td></tr>
</table><br/>
<input type="submit" value="<?php echo $text['savechanges']; ?>"> <span id="tspinner" style="display:none"><img src="<?php echo $cms['tngpath']; ?>spinner.gif" width="18" height="18" /></span>
</form>

</div>

<div class="databack" style="margin:10px;border:0px;display:none" id="finished">
<p class="header"><?php echo $text['thanks']; ?></p>
<p class="normal"><?php echo $text['received']; ?><br /><br />
<a href="#" onclick="tnglitbox.remove();"><?php echo $text['closewindow']; ?></a></p>
</div>
