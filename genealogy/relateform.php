<?php
include("begin.php");
include($subroot . "pedconfig.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "relate";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

session_register('relatepersonID');
session_register('relatetreeID');
$relatepersonID = $_SESSION[relatepersonID];
$relatetreeID = $_SESSION[relatetreeID];

$query = "SELECT firstname, lastname, lnprefix, prefix, suffix, sex, nameorder, living, branch, disallowgedcreate, birthdate, altbirthdate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) as birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) as death
	FROM $people_table, $trees_table WHERE personID = \"$primaryID\" AND $people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$row = mysql_fetch_assoc( $result );
	$rightbranch = checkbranch( $row[branch] );
	$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	if( $row[allow_living] || !$nonames ) {
		if( $row[allow_living] ) {
			$birthdate = displayDate( $row[birthdate] ? $row[birthdate] : $row[altbirthdate] );
			$namestrplus =  " ($birthdate) - $primaryID";
		}
		else
			$namestrplus =  " - $primaryID";
	}
	else
		$namestrplus =  " - $primaryID";
	$namestr = getName( $row );
	$disallowgedcreate = $row[disallowgedcreate];
	mysql_free_result($result);
}

$flags[tabs] = $tngconfig[tabs];
tng_header( $text[relcalc], $flags );

$photostr = showSmallPhoto( $primaryID, $namestr, $row[allow_living], 0 );
echo tng_DrawHeading( $photostr, $namestr, getYears( $row ) );
echo tng_coreicons();

$innermenu = "&nbsp; \n";

echo tng_menu( "I", "relate", $primaryID, $innermenu );

$namestr .= $namestrplus;

$findpersonform_url = getURL( "findpersonform", 1 );
echo getFORM( "relationship", "get", "form1", "form1" );

$maxupgen = $pedigree[maxupgen] ? $pedigree[maxupgen] : 15;
$newstr = ereg_replace( "xxx", $maxupgen, $text[findrelinstr] );
?>
<script type="text/javascript">
function returnName(personID,namestring,field,textchange) {
	$(field).value = personID;
	$(textchange).innerHTML = namestring;
	tnglitbox.remove();

	return false;
}
</script>
<span class="subhead"><strong><?php echo $text[findrel]; ?></strong></span><br/>
<p><span class="normal"><?php echo $newstr; ?></span></p>
<table>
	<tr>
		<td valign="top"><span class="normal"><?php echo $text[gencheck]; ?>:</span></td>
		<td valign="bottom"><span class="normal">
			<select name="generations">
<?php 	
	$dogens = $dogens ? $dogens : $pedigree[maxupgen];
    for( $i = 1; $i <= $pedigree[maxupgen]; $i++ ) {
        echo "<option value=\"$i\"";
        if( $i == $dogens ) echo " selected";
        echo ">$i</option>\n";
    }
?>
			</select> <?php echo $text[sometimes]; ?></span>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td><span class="normal"><strong><?php echo $text[person1]; ?> </strong></span></td>
		<td><div id="name1" class="normal"><?php echo $namestr; ?></div></td>
	</tr>
	<tr>
		<td><span class="normal"><?php echo $text[changeto]; ?> </span></td>
		<td><span class="normal">
			<input type="text" name="altprimarypersonID" id="altprimarypersonID" size="10">  <input type="button" name="find1" value="<?php echo $text[find]; ?>" onclick="tnglitbox = new LITBox('<?php echo $findpersonform_url . "findtree=$tree"; ?>&amp;textchange=name1&amp;publicfield=altprimarypersonID&amp;type=text',{width:400,height:450});">
		</span>
		</td>
	</tr><tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td><span class="normal"><strong><?php echo $text[person2]; ?> </strong></span></td>
		<td>
<?php
	if( $relatepersonID && $relatetreeID == $tree ) {
		$query = "SELECT firstname, lastname, lnprefix, prefix, suffix, nameorder, living, branch, birthdate, altbirthdate FROM $people_table WHERE personID = \"$relatepersonID\" AND gedcom = \"$tree\"";
		$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		if( $result2 ) {
			$row2 = mysql_fetch_assoc( $result2 );
			$row2[allow_living] = !$row2[living] || $livedefault == 2 || ( $allow_living && checkbranch( $row2[branch] ) ) ? 1 : 0;
			if( $row2[allow_living] ) {
				$birthdate = $row2[birthdate] ? $row2[birthdate] : $row2[altbirthdate];
				$birthdate = " ($birthdate)";
			}
			else
				$birthdate = "";
			$namestr2 = getName( $row2 ) . "$birthdate - $relatepersonID";
			mysql_free_result($result2);
		}
	}
	echo "<div id=\"name2\" class=\"normal\">$namestr2</div><input type=\"hidden\" name=\"savedpersonID\" value=\"$relatepersonID\"></td></tr>\n";
	echo "<tr><td><span class=\"normal\">$text[changeto] </span></td><td><span class=\"normal\">";
?>
		<input type="text" name="secondpersonID" id="secondpersonID" size="10">  <input type="button" name="find2" value="<?php echo $text[find]; ?>" onclick="tnglitbox = new LITBox('<?php echo $findpersonform_url . "findtree=$tree"; ?>&amp;textchange=name2&amp;publicfield=secondpersonID&amp;type=text',{width:400,height:450});">
		</span>
		</td>
	</tr>
</table>
<br/>
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<input type="hidden" name="primarypersonID" id="primarypersonID" value="<?php echo $primaryID; ?>">
<input type="submit" value="<?php echo $text[calculate]; ?>" <?php if( !$relatepersonID ) echo "onClick=\"if( form1.secondpersonID.value.length == 0 ) {alert('$text[select2inds]'); return false;}\""; ?>>
<br/><br/>
</form>
<?php
	tng_footer( "" );
?>
