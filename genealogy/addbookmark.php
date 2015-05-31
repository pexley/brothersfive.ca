<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "getperson";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

$bookmarks_url = getURL("bookmarks", 0);

$newroot = ereg_replace( "/", "", $rootpath );
$newroot = ereg_replace( " ", "", $newroot );
$newroot = ereg_replace( "\.", "", $newroot );
$ref = "tngbookmarks_$newroot";

$bookmarks = explode("|", $_COOKIE[$ref]);
$bookmarkstr = $_SESSION['tnglastpage'];
foreach( $bookmarks as $bookmark ) {
	if( $bookmark && stripslashes($bookmark) != stripslashes($_SESSION['tnglastpage']) )
		$bookmarkstr .= "|" . $bookmark;
}

setcookie($ref, stripslashes($bookmarkstr), time()+31536000, "/");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="bkmkdiv">
<span class="subhead"><img src="<?php echo $cms[tngpath]; ?>tng_bmk.gif" width="20" height="20" align="left" alt="" vspace="0" />&nbsp;<strong><?php echo $text[bookmarked]; ?></strong></span><br/><br/>
<?php
//$bookmarks = explode(";", $_COOKIE[$ref]);
//foreach( $bookmarks as $bookmark ) {
//	echo "$bookmark<br>\n";
//}
?>
<form style="margin:0px">
<input type="button" onclick="tnglitbox.remove();return false;" value="<?php echo $text['closewindow']; ?>" />
<input type="button" onclick="window.location.href='<?php echo $bookmarks_url ?>';" value="<?php echo $text['mngbookmarks']; ?>" />
</form>

</div>
