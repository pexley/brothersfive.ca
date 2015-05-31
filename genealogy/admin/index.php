<?php
include("../subroot.php");
include($subroot . "config.php");
$tngconfig['maint'] = "";
include("adminlib.php");
$textpart = "index";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
if( $link )
	include("checklogin.php");
include("../version.php");

tng_adminheader( $admtext[mainmenu], "" );
?>
<!-- frames -->
<frameset rows="54,*,0" cols="150,*" framespacing="0" frameborder="0">
    <frame name="corner" src="corner.php" marginwidth="5" marginheight="2" leftmargin="5" rightmargin="5" topmargin="2" bottommargin="4" scrolling="no" frameborder="0">
    <frame name="rightbanner"src="rightbanner.php"  id="rightbanner" frameborder="0" scrolling="No" marginwidth="10" marginheight="5" leftmargin="10" rightmargin="0" topmargin="5" bottommargin="0">
    <frame name="leftbanner" src="leftbanner.php" marginwidth="10" marginheight="10" leftmargin="10" topmargin="10" rightmargin="5" scrolling="auto" frameborder="0">
    <frame name="main" src="main.php" marginwidth="5" marginheight="5" leftmargin="5" rightmargin="0" topmargin="5" bottommargin="0" scrolling="auto" frameborder="0">
</frameset>
</html>