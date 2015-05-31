<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit  || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$reponame = addslashes($reponame);
	$address1 = addslashes($address1);
	$address2 = addslashes($address2);
	$city = addslashes($city);
	$state = addslashes($state);
	$zip = addslashes($zip);
	$country = addslashes($country);
}

$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

if( $addressID ) {
	$query = "UPDATE $address_table SET address1=\"$address1\", address2=\"$address2\", city=\"$city\", state=\"$state\", zip=\"$zip\", country=\"$country\" WHERE addressID = \"$addressID\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
}
elseif( $address1 || $address2 || $city || $state || $zip || $country || $phone || $email || $www ) {
	$query = "INSERT INTO $address_table (address1, address2, city, state, zip, country, gedcom, phone, email, www)  VALUES(\"$address1\", \"$address2\", \"$city\", \"$state\", \"$zip\", \"$country\", \"$tree\", \"$phone\", \"$email\", \"$www\")";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$addressID = mysql_insert_id();
}

$query = "UPDATE $repositories_table SET reponame=\"$reponame\",addressID=\"$addressID\",changedate=\"$newdate\",changedby=\"$currentuser\" WHERE repoID=\"$repoID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
adminwritelog( "<a href=\"editrepo.php?repoID=$repoID&tree=$tree\">$admtext[modifyrepo]: $tree/$repoID</a>" );

if( $newscreen == "return" )
	header( "Location: editrepo.php?repoID=$repoID&tree=$tree" );
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
	$message = "$admtext[changestorepo] $repoID $admtext[succsaved].";
	header( "Location: repositories.php?message=" . urlencode($message) );
}
?>
