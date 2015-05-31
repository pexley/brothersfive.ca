<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
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

if (get_magic_quotes_gpc() == 0) {
	$albumname = addslashes($albumname);
	$description = addslashes($description);
	$keywords = addslashes($keywords);
}
$query = "UPDATE $albums_table SET albumname=\"$albumname\",description=\"$description\",keywords=\"$keywords\" WHERE albumID=\"$albumID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

//cycle through all ph fields
//delete if requested
adminwritelog( "$admtext[modifyalbum]: $albumID" );

if( $newscreen == "return" )
	header( "Location: editalbum.php?albumID=$albumID" );
else if( $newscreen == "close" ) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<body>
<script type="text/javascript">
	window.close();
</script>
</body>
</html>
<?php
}
else {
	$message = "$admtext[changestoalbum] $albumID $admtext[succsaved].";
	header( "Location: albums.php?message=" . urlencode($message) );
}
?>
