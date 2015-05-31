<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "getperson";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

$deletebookmark_url = getURL( "deletebookmark", 1 );

$newroot = ereg_replace( "/", "", $rootpath );
$newroot = ereg_replace( " ", "", $newroot );
$newroot = ereg_replace( "\.", "", $newroot );
$ref = "tngbookmarks_$newroot";

tng_header( $text[bookmarks], $flags );
?>
 <!-- DED added alt='' & changed span to div in next line-->
<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_bmk.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text['bookmarks']; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

echo "<p class=\"normal\">" . $text['bkmkvis'] . "</p>";

echo "<ul class=\"normal\">\n";
if (isset($_COOKIE[$ref])) {
    $bcount=0;
    $bookmarks = explode("|", $_COOKIE[$ref]);
    foreach( $bookmarks as $bookmark ) {
    	if(trim($bookmark)) {
	    	echo "<li>" . stripslashes($bookmark) . " | <a href=\"$deletebookmark_url" . "idx=$bcount\">$text[remove]</a></li>\n";
		    $bcount++;
	    }
    }
} else {
    echo "<li>0 $text[bookmarks]</li>";
}
echo "</ul><br />\n";
tng_footer( "" );
?>
