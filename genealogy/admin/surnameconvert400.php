<?php
include("../config.php");
include("adminlib.php");
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
@set_time_limit(0);
ini_set( "magic_quotes_runtime", "0" );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>TNG 4.0.0 Surname Converter</title>
	<link href="../genstyle.css" rel="stylesheet">
</head>

<body>
<h2>TNG 4.0.0 Surname Converter</h2>
<?php
$query = "SELECT personID, gedcom, lnprefix, lastname FROM $people_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$orgprefixes = explode( ",", $specpfx );
$prefixcount = 0;
foreach( $orgprefixes as $prefix ) {
	$newprefix = preg_replace( "/'/", "' ", stripslashes( $prefix ) );
	$newprefix = preg_replace( "/  /", " ", $newprefix );
	$newprefixes[$prefixcount] = $newprefix;
	$prefixcount++;
}
while( $row = mysql_fetch_assoc( $result ) ) {
	$lastname = trim( $row[lnprefix] . " " . preg_replace( "/'/", "' ", stripslashes( $row[lastname] ) ) );
	$lastname = preg_replace( "/  /", " ", $lastname );
	$gotit = 0;
	if( $specpfx ) {
		$fullprefix = $lastname;
		$lastspace = strrpos( $fullprefix, " " );
		$fullsurname = "";
		while( !$gotit && $lastspace ) {
			$fullsurname = substr( $lastname, $lastspace + 1 );
			$fullprefix = substr( $fullprefix, 0, $lastspace );
			if( in_array( $fullprefix, $newprefixes ) ) {
				$gotit = 1;
				$count = 0;
				foreach( $newprefixes as $newprefix ) {
					if( $fullprefix == $newprefix ) {
						$fullprefix = $orgprefixes[$count];
						break;
					}
					else
						$count++;
				}
			}
			else
				$lastspace = strrpos( $fullprefix, " " );
		}
	}
	if( !$gotit && $lnpfxnum ) {
		$pfxcount = 0;
		$parts = explode( " ", $lastname );
		$numparts = count( $parts );
		if( $numparts >= 2 ) {
			$fullprefix = $fullsurname = "";
			foreach( $parts as $part ) {
				if( !$gotit ) {
					$fullprefix .= $fullprefix ? " $part" : $part;
					$pfxcount++;
					if( $numparts == $pfxcount + 1 || $lnpfxnum == $pfxcount ) {
						$gotit = 1;
					}
				}
				else
					$fullsurname .= $fullsurname ? " $part" : $part;
			}
		}
	}
	if( $gotit && $fullprefix ) {
		$fullsurname = trim( $fullsurname );
		echo "<br/>Converting: $fullprefix $fullsurname => $fullprefix + $fullsurname";
		$query = "UPDATE $people_table SET lastname=\"" . addslashes($fullsurname) . "\", lnprefix=\"" . addslashes( $fullprefix ) . "\" WHERE personID=\"$row[personID]\" AND gedcom=\"$row[gedcom]\"";
		$result2 = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	}
}
mysql_free_result($result);
?>
<br/><br/>All existing surnames with prefixes (according to your definitions) have successfully been converted.
</body>
</html>