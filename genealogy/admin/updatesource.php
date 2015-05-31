<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

require("adminlog.php");

if (get_magic_quotes_gpc() == 0) {
	$shorttitle = addslashes($shorttitle);
	$title = addslashes($title);
	$author = addslashes($author);
	$callnum = addslashes($callnum);
	$publisher = addslashes($publisher);
	$actualtext = addslashes($actualtext);
}
$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );

$query = "UPDATE $sources_table SET shorttitle=\"$shorttitle\",title=\"$title\",author=\"$author\",callnum=\"$callnum\",publisher=\"$publisher\",repoID=\"$repoID\",actualtext=\"$actualtext\",changedate=\"$newdate\",changedby=\"$currentuser\" WHERE sourceID=\"$sourceID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( "<a href=\"editsource.php?sourceID=$sourceID&amp;tree=$tree\">$admtext[modifysource]: $tree/$sourceID</a>" );

if( $newscreen == "return" )
	header( "Location: editsource.php?sourceID=$sourceID&tree=$tree" );
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
	$message = "$admtext[changestosource] $sourceID $admtext[succsaved].";
	header( "Location: sources.php?message=" . urlencode($message) );
}
?>
