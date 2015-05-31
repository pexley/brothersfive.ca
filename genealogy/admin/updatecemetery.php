<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "cemeteries";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if( $newfile && $newfile != "none" ) {
	if( substr( $maplink, 0, 1 ) == "/" ) 
		$maplink = substr( $maplink, 1 );
	$newpath = "$rootpath$headstonepath/$maplink";
		
	if( @move_uploaded_file($newfile, $newpath) ) 
		@chmod( $newpath, 0644 );
	else {
		$message = "$admtext[mapnotcopied] $newpath $adm[improperpermissions].";
		header( "Location: cemeteries.php?message=" . urlencode($message) );
		exit;
	}
}

if (get_magic_quotes_gpc() == 0) {
	$cemname = addslashes($cemname);
	$city = addslashes($city);
	$county = addslashes($county);
	$state = addslashes($state);
	$country = addslashes($country);
	$latitude = addslashes($latitude);
	$longitude = addslashes($longitude);
	$zoom = addslashes($zoom);
	$notes = addslashes($notes);
}
if($latitude && $longitude && !$zoom)
	$zoom = 13;
if( !$zoom ) $zoom = 0;
$query = "UPDATE $cemeteries_table SET cemname=\"$cemname\",maplink=\"$maplink\",city=\"$city\",county=\"$county\",state=\"$state\",country=\"$country\",latitude=\"$latitude\",longitude=\"$longitude\",zoom=\"$zoom\",notes=\"$notes\" WHERE cemeteryID=\"$cemeteryID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "<a href=\"editcemetery.php?cemeteryID=$cemeteryID\">$admtext[modifycemetery]: $cemeteryID</a>" );

if( $newscreen == "return" )
	header( "Location: editcemetery.php?cemeteryID=$cemeteryID" );
else if( $newscreen == "close" ) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<body>
<SCRIPT language="JavaScript" type="text/javascript">
	window.close();
</script>
</body>
</html>
<?php
}
else {
	$message = "$admtext[changestocem] $cemeteryID $admtext[succsaved].";
	header( "Location: cemeteries.php?message=" . urlencode($message) );
}
?>
