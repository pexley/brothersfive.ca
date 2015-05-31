<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "people";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if($session_charset != "UTF-8") {
	$myfirstname = utf8_decode($myfirstname);
	$mylastname = utf8_decode($mylastname);
}

$allwhere = "gedcom = \"$tree\"";
if( $personID )
	$allwhere .= " AND personID = \"$personID\"";
if( $myfirstname )
	$allwhere .= " AND firstname LIKE \"%" . trim($myfirstname) . "%\"";
if( $mylastname ) {
	if( $lnprefixes )
		$allwhere .= " AND CONCAT_WS(' ',lnprefix,lastname) LIKE \"%" . trim($mylastname) . "%\"";
	else
		$allwhere .= " AND lastname LIKE \"%" . trim($mylastname) . "%\"";
}
//if( $field == "husband" )
//	$allwhere .= " AND sex = \"M\"";
//else if( $field == "wife" )
//	$allwhere .= " AND sex = \"F\"";
$query = "SELECT personID, lastname, firstname, lnprefix, birthdate, altbirthdate, deathdate, burialdate, prefix, suffix, nameorder FROM $people_table WHERE $allwhere ORDER BY lastname, lnprefix, firstname LIMIT 250";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="findpersonresdiv">
<table border="0" cellpadding="0">
<tr>
	<td>
		<p class="subhead"><strong><?php echo $admtext['searchresults']; ?></strong></p>
		<span class="normal">(<?php echo $admtext['clicktoselect']; ?>)</span><br/>
	</td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td valign="top">
		<form action="" style="margin:0px"><input type="button" value="<?php echo $admtext['find']; ?>" onclick="reopenFindForm()"></form>
	</td>
</tr>
</table><br/>
<table border="0" cellspacing="0" cellpadding="2">
<?php
while( $row = mysql_fetch_assoc($result))
{
	if ( $row['birthdate'] ) {
		$birthdate = "$admtext[birthabbr] $row[birthdate]";
	}
	else if ( $row['altbirthdate'] ) {
		$birthdate = "$admtext[chrabbr] $row[altbirthdate]";
	}
	else {
		$birthdate = "";
	}
	if ( $row['deathdate'] ) {
		$deathdate = "$admtext[deathabbr] $row[deathdate]";
	}
	else if ( $row['burialdate'] ) {
		$deathdate = "$admtext[burialabbr] $row[burial]";
	}
	else {
		$deathdate = "";
	}
	if( !$birthdate && $deathdate )
		$birthdate = $admtext['nobirthinfo'];
	$name = getName( $row );
	if($type == "select")
		$namestr = addslashes($name) . "| - $row[personID]<br />$birthdate";
	elseif( $nameplusid == 1)
		$namestr = addslashes( "$name");
	elseif( $nameplusid )
		$namestr = addslashes( "$name - $row[personID]");
	else
		$namestr = addslashes( "$name");
	$jsnamestr = ereg_replace("&#34;","&lsquo;",$namestr);
	echo "<tr><td valign=\"top\"><span class=\"normal\"><a href=\"#\" onClick=\"return returnName('$row[personID]','$jsnamestr','$type','$nameplusid');\">$row[personID]</a></span></td><td><span class=\"normal\"><a href=\"#\" onClick=\"return returnName('$row[personID]','$jsnamestr','$type','$nameplusid');\">$name</a><br/>$birthdate $deathdate</span></td></tr>\n";
}
mysql_free_result($result);
?>
</table>
</div>
