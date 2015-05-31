<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "findplace";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $del ) {
	$query = "DELETE FROM $places_table WHERE ID=\"$del\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}

if($session_charset != "UTF-8")
	$myplace = utf8_decode($myplace);

$allwhere = $tree ? "gedcom = \"$tree\"" : "1=1";
if( $myplace )
	$allwhere .= " AND place LIKE \"%$myplace%\"";
$query = "SELECT ID, place FROM $places_table WHERE $allwhere ORDER BY place LIMIT 250";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="findplaceresdiv">
<table border="0" cellpadding="0">
<tr>
	<td valign="top">
		<span class="subhead"><strong><?php echo $admtext[searchresults]; ?></strong></span><br/>
		<span class="normal">(<?php echo $admtext[clicktoselect]; ?>)</span><br>
	</td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td>
		<form action=""><input type="button" value="<?php echo $admtext['find']; ?>" onclick="reopenFindForm();"></form>
	</td>
</tr>
</table><br>
<table border="0" cellspacing="0" cellpadding="2">
<?php
while( $row = mysql_fetch_assoc($result)) {
	echo "<tr><td valign=\"top\"><span class=\"normal\">";
	$row[place] = ereg_replace("'","&#39;", $row[place] );
	echo "<a href=\"findplace.php\" onClick='return returnValue(\"" . addslashes($row[place]) . "\");'>$row[place]</a></span></td></tr>\n";
}
mysql_free_result($result);
?>
</table>
</div>
