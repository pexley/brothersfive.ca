<?php
include("../config.php");
include("adminlib.php");
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
@set_time_limit(0);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>TNG 4.0.0 Surname Unconverter</title>
	<link href="../genstyle.css" rel="stylesheet">
</head>

<body>
<h2>TNG 4.0.0 Surname Unconverter</h2>
<?php
$query = "SELECT personID, gedcom, lnprefix, lastname FROM $people_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
while( $row = mysql_fetch_assoc( $result ) ) {
	if( $row[lnprefix] ) {
		$lastname = preg_replace( "/' /", "'", trim( stripslashes( $row[lnprefix] . " " . $row[lastname] ) ) );
		echo "<br/>Converting: $row[lnprefix] + $row[lastname] => $lastname";
		$query = "UPDATE $people_table SET lastname=\"$lastname\", lnprefix=\"\" WHERE personID=\"$row[personID]\" AND gedcom=\"$row[gedcom]\"";
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
}
mysql_free_result($result);
?>
<br/><br/>All existing surnames with prefixes (according to your definitions) have successfully been unconverted.
</body>
</html>