<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
$textpart = "gedcom";
include($cms[tngpath] . "getlang.php");
include($cms[tngpath] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");

$query = "SELECT firstname, lnprefix, lastname, suffix, sex, nameorder, living, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death 
	FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc($result);
	$rightbranch = checkbranch( $row[branch] );
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$disallowgedcreate = $row[disallowgedcreate];
	$name = getName( $row );
	mysql_free_result($result);
}
if( $disallowgedcreate && !$allow_ged ) exit;

$flags[tabs] = $tngconfig[tabs];
$flags[scripting] = "<script language=\"JavaScript\" type=\"text/javascript\">
function validateForm() {
	if( document.gedform.email.value == \"\" ) {
		alert('$text[enteremail]');
		return false;
	}
	else return true;
}
</script>\n";

tng_header( "$text[creategedfor]: $text[gedstartfrom] $name", $flags );
?>

<?php
	$photostr = showSmallPhoto( $personID, $name, $row[allow_living], 0 );
	echo tng_DrawHeading( $photostr, $name, getYears( $row ) );
	echo tng_coreicons();

	$innermenu = "&nbsp; \n";
	
	echo tng_menu( "I", "gedcom", $personID, $innermenu );

	echo "<span class=\"subhead\"><b>$text[creategedfor]</b></span><br /><br />\n";

	if( $currentuser )
		$formstr = getFORM( "gedcom", "GET", "gedform", "" );
	else
		$formstr = getFORM( "gedcom", "GET\" onSubmit=\"return validateForm();", "gedform", "" );
	echo $formstr;
?>
<INPUT TYPE="HIDDEN" NAME="personID" VALUE="<?php echo $personID; ?>">
<INPUT TYPE="HIDDEN" NAME="tree" VALUE="<?php echo $tree; ?>">
<table border="0" cellspacing="1" cellpadding="4" width="100%">
<tr><td class="fieldnameback" width="30%"><span class="fieldname"><?php echo $text[gedstartfrom]; ?>:&nbsp; </span></td><td class="databack" width="70%"><span class="normal"><?php echo $name; ?></span></td></tr>
<?php
	if( !$currentuser ) {
?>
<tr><td class="fieldnameback"><span class="fieldname"><?php echo $text[email]; ?>:&nbsp; </span></td><td class="databack"><span class="normal"><INPUT TYPE="TEXT" NAME="email" SIZE="20"></span></td></tr>
<?php
	}
?>
<tr><td class="fieldnameback"><span class="fieldname"><?php echo $text[producegedfrom]; ?>:&nbsp; </span></td><td class="databack"><span class="normal"><SELECT NAME="type"><OPTION value="<?php echo $text[ancestors]; ?>" selected><?php echo $text[ancestors]; ?></option><OPTION value="<?php echo $text[descendants]; ?>"><?php echo $text[descendants]; ?></option></SELECT></span></td></tr>
<tr><td class="fieldnameback"><span class="fieldname"><?php echo $text[numgens]; ?>:&nbsp; </span></td><td class="databack"><span class="normal">
<select name="maxgcgen">
<?php
	if( $maxgedcom < 1 ) $maxgedcom = 1;
	for( $i = 1; $i <= $maxgedcom; $i++ )
		echo "<option value=\"$i\">$i</option>\n";
?>
</select>
</span></td></tr>
<?php if( $allow_lds ) { ?>
<tr><td class="fieldnameback">&nbsp;</td><td class="databack"><span class="normal"><input type="checkbox" name="lds" value="yes"> <?php echo $text[includelds]; ?></span></td></tr>
<?php } ?>
<tr><td>&nbsp;</td><td><span class="normal"><INPUT TYPE="submit" VALUE="<?php echo $text[buildged]; ?>"></span></td></tr>
</table>
<?php
	if( $currentuser )
		echo "<input type=\"hidden\" name=\"email\" value=\"$currentuserdesc\">";
?>
</form>
<?php
	tng_footer( "" );
?>
