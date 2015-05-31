<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "relate";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
$tree = $findtree;
include($cms['tngpath'] . "checklogin.php");

if($session_charset != "UTF-8") {
	$myfirstname = utf8_decode($myfirstname);
	$mylastname = utf8_decode($mylastname);
}

$allwhere = "gedcom = \"$findtree\"";
if( $myfirstname ) {
	if (get_magic_quotes_gpc() == 0)
		$myfirstname = addslashes( $myfirstname );
	$allwhere .= " AND firstname LIKE \"%$myfirstname%\"";
}
if( $mylastname ) {
	if (get_magic_quotes_gpc() == 0)
		$mylastname = addslashes( $mylastname );
	$allwhere .= " AND trim(concat_ws(' ',lnprefix,lastname)) LIKE \"%$mylastname%\"";
}
if( $noliving )
	$allwhere .= " AND living != '1'";
if( $datesreq )
	$allwhere .= " AND (birthdatetr != '' OR altbirthdatetr !='')";
$query = "SELECT personID, lnprefix, lastname, firstname, prefix, suffix, nameorder, birthdate, altbirthdate, deathdate, burialdate, living, branch FROM $people_table WHERE $allwhere ORDER BY lastname, firstname LIMIT 250";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="findpersonresdiv">
<table border="0" cellpadding="0">
<tr>
	<td valign="top">
		<span class="subhead"><strong><?php echo $text['searchresults']; ?></strong></span><br/>
		<span class="normal">(<?php echo $text['clicktoselect']; ?>)</span><br/>
	</td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td>
		<form action=""><input type="button" value="<?php echo $text['find']; ?>" onclick="reopenFindForm()"></form>
	</td>
</tr>
</table><br/>
<table border="0" cellspacing="0" cellpadding="2">
<?php
$findperson_url = getURL( "findperson", 0 );
if( !mysql_num_rows($result) ) {
	echo "<tr><td valign=\"top\" colspan=\"2\"><span class=\"normal\">$text[noresults]</span></td></tr>\n";
}
else {
	while( $row = mysql_fetch_assoc($result))
	{
		$row[allow_living] = !$row[living] || $livedefault == 2 || ( $allow_living && checkbranch( $row[branch] ) ) ? 1 : 0;
		if( $row[allow_living] || !$nonames ) {
			if( $row[allow_living] ) {
				if ( $row[birthdate] )
					$birthdate = "$text[birthabbr] " . displayDate( $row[birthdate] );
				else if ( $row[altbirthdate] )
					$birthdate = "$text[chrabbr] " . displayDate( $row[altbirthdate] );
				else
					$birthdate = "";
				if ( $row[deathdate] )
					$deathdate = "$text[deathabbr] " . displayDate( $row[deathdate] );
				else if ( $row[burialdate] )
					$deathdate = "$text[burialabbr] " . displayDate( $row[burialdate] );
				else
					$deathdate = "";
				if( !$birthdate && !$deathdate ) $birthdate = $text[nobirthinfo];
			}
			else {
				$birthdate = $text[living];
				$deathdate = "";
			}
			$rowcount++;

			if( $nameplusid || $textchange )
				$namestr = addslashes( ereg_replace('"',"&#34;",getName( $row ) . " ($birthdate) - $row[personID]"));
			else
				$namestr = "";
			$displayname = getNameRev( $row );
			echo "<tr><td valign=\"top\"><span class=\"normal\"><a href=\"$findperson_url\" onclick=\"return returnName('$row[personID]','$namestr','$field','$textchange');\">$row[personID]</a></span></td><td><span class=\"normal\"><a href=\"$findperson_url\" onclick=\"return returnName('$row[personID]','$namestr','$field','$textchange');\">$displayname</a><br/>$birthdate $deathdate</span></td></tr>\n";
		}
	}
}
mysql_free_result($result);
?>
</table>
</div>
