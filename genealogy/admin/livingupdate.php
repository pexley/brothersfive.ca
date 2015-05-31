<?php
include("../config.php");
include("adminlib.php");
require("datelib.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
@set_time_limit(0);

tng_adminheader( "Living Update", "" );
?>

<body>
<h2>Living Update</h2>

The following people are alive:<br/>
<?
$query = "SELECT personID, birthdate, birthdatetr, deathdate, deathplace, burialdate, burialplace, gedcom, firstname, lastname FROM $people_table";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
while( $row = mysql_fetch_assoc($result))
{
	if( !$row[deathdate] && !$row[deathplace] && !$row[burialdate] && !$row[burialplace] && $row[birthdate] ) {
		$birthyear = strtok($row[birthdatetr],"-");
		if( date( "Y" ) - $birthyear < 110 ) {
			//living
			echo "$row[firstname] $row[lastname]<br/>\n";
			$query = "UPDATE $people_table SET living=\"1\" WHERE personID=\"$row[personID]\" AND gedcom=\"$row[gedcom]\"";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

			$query = "UPDATE $families_table SET living=\"1\" WHERE (husband=\"$row[personID]\" OR wife=\"$row[personID]\") AND gedcom=\"$row[gedcom]\"";
			$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		}
	}
}
?>
<br/><br/>
All living individuals have now been flagged.
