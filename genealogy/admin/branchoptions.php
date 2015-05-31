<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "branches";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

$query = "SELECT branch, description FROM $branches_table WHERE gedcom=\"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$numrows = mysql_num_rows($result);

if(!$numrows)
	echo "0";
else {
	echo "<option value=\"\"></option>\n";
	while($row = mysql_fetch_assoc( $result )) {
		echo "<option value=\"$row[branch]\">$row[description]</option>\n";
	}
}
mysql_free_result($result);
?>