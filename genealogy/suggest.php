<?php
include("begin.php");
$tngconfig['maint'] = "";
if($cms['events']){include('cmsevents.php'); cms_contact();}
include($cms['tngpath'] . "genlib.php");
$textpart = "gedcom";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
if($enttype)
	include($cms['tngpath'] . "checklogin.php");
else
	$currentuser = $_SESSION[currentuser];

$_SESSION['tng_email'] = generatePassword(1);
$_SESSION['tng_comments'] = generatePassword(1);
$_SESSION['tng_yourname'] = generatePassword(1);

$flags[scripting] = "<script type=\"text/javascript\">
function validateForm() {
	if( document.suggest." . $_SESSION['tng_yourname'] . ".value == \"\" ) {
		alert(\"$text[entername]\");
		return false;
	}
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/;
	var address = document.suggest." . $_SESSION['tng_email'] . ".value;
	if(address.length == 0 || reg.test(address) == false){
		alert(\"$text[enteremail]\");
		return false;
	}
	if( document.suggest." . $_SESSION['tng_comments'] . ".value == \"\" ) {
		alert(\"$text[entercomments]\");
		return false;
	}
	return true;
}
</script>\n";

if( $enttype == "I" ) {
	$typestr = "person";
	$query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death 
		FROM $people_table, $trees_table WHERE personID = \"$ID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	if( $result ) {
		$row = mysql_fetch_assoc($result);
		$rightbranch = checkbranch( $row[branch] );
		$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
		$disallowgedcreate = $row[disallowgedcreate];
		$name = getName( $row ) .  " ($ID)";
		mysql_free_result($result);
	}

	$years = getYears( $row );
}
elseif( $enttype == "F" ) {
	$typestr = "family";
	$query = "SELECT familyID, husband, wife, living, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"$ID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);

	$rightbranch = checkbranch( $row[branch] ) ? 1 : 0;
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$name = "$text[family]: " . getFamilyName( $row );
	
	$years = "";
}
elseif( $enttype == "S" ) {
	$query = "SELECT title FROM $sources_table WHERE sourceID = \"$ID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	
	$query = "SELECT count(personID) as ccount FROM $citations_table, $people_table 
		WHERE $citations_table.sourceID = '$ID' AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
		AND living = '1'";
	$sresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$srow = mysql_fetch_assoc( $sresult );
	$row[living] = $srow[ccount] ? 1 : 0;
	
	if( !$row[living] || $livedefault == 2 || ( !$livedefault && $allow_living_db && ( !$assignedtree || $assignedtree == $row[gedcom] ) ) )
		$row[allow_living] = 1;
	else
		$row[allow_living] = 0;
	mysql_free_result( $sresult );
	
	$name = "$text[source]: $row[title] ($ID)";
	$years = "";
}
elseif( $enttype == "R" ) {
	$query = "SELECT reponame FROM $repositories_table WHERE repoID = \"$ID\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	
	$row[living] = 0;
	$row[allow_living] = 1;
	
	$name = "$text[repository]: $row[reponame] ($ID)";
}
if( $enttype ) {
	$flags[tabs] = $tngconfig[tabs];
	$headline = "$text[suggestchange]: $name";
	$comments = $text[comments];
	tng_header( $headline, $flags );
	
	$photostr = showSmallPhoto( $ID, $name, $row[allow_living], 0 );
	echo tng_DrawHeading( $photostr, $name, $years );
	echo tng_coreicons();
	$innermenu = "&nbsp; \n";
	echo tng_menu( $enttype, "suggest", $ID, $innermenu );
	$buttontext = $text[submitsugg];
}
else {
	$headline = $text[contactus];
	$comments = $text[comments2];
	tng_header( $headline, $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_contact.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $headline; ?></p><br clear="left"/>
<?php
	echo tng_coreicons();
	$buttontext = $text['sendmsg'];
}

if( $message ) {
	$newmessage = $text[$message];
	if( $message == "mailnotsent" ) {
		$newmessage = ereg_replace( "xxx", $sowner, $newmessage );
		$newmessage = ereg_replace( "yyy", $ssendemail, $newmessage );
	}
	echo "<p class=\"normal\"><strong><font color=\"red\">$newmessage</font></strong></p>\n";
}

if( $enttype )
	echo "<span class=\"subhead\"><b>$headline</b></span><br /><br />\n";
?>

<?php
@include($cms['tngpath'] . "TNG_captcha.php");

$formstr = getFORM( "tngsendmail", "post\" onsubmit=\"return validateForm();", "suggest", "suggest" );
echo $formstr;
?>
<input type="hidden" name="<?php echo $typestr; ?>ID" value="<?php echo $ID; ?>" />
<input type="hidden" name="tree" value="<?php echo $tree; ?>" />
<table border="0" cellspacing="1" cellpadding="4" width="100%">
<tr><td class="fieldnameback" width="20%"><span class="fieldname"><?php echo $text[yourname]; ?>:&nbsp; </span></td><td class="databack" width="80%"><input type="text" name="<?php echo $_SESSION['tng_yourname']; ?>" /></td></tr>
<tr><td class="fieldnameback"><span class="fieldname"><?php echo $text[email]; ?>:&nbsp; </span></td><td class="databack"><span class="normal"><input type="text" name="<?php echo $_SESSION['tng_email']; ?>" /> &nbsp; <input type="checkbox" name="mailme" value="1" /><?php echo $text[mailme]; ?></span></td></tr>
<tr>
	<td class="fieldnameback" valign="top"><span class="fieldname"><?php echo $comments; ?>:&nbsp; </span></td>
	<td class="databack">
		<textarea cols="60" rows="10" name="<?php echo $_SESSION['tng_comments']; ?>"></textarea>
	</td>
</tr>
<tr><td>&nbsp;</td><td><span class="normal"><input type="submit" value="<?php echo $buttontext; ?>" /></span></td></tr>
</table>
<input type="hidden" name="enttype" value="<?php echo $enttype; ?>" />
<input type="hidden" name="ID" value="<?php echo $ID; ?>" />
<input type="hidden" name="tree" value="<?php echo $tree; ?>" />
</form>
<br />
<?php
	tng_footer( "" );
?>
