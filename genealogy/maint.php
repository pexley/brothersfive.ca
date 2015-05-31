<?php
include("begin.php");
$tngconfig['maint'] = "";
include($cms['tngpath'] . "genlib.php");
$textpart = "language";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
$maintenance_mode = true;
include($cms['tngpath'] . "checklogin.php");

tng_header( $text['sitemaint'], $flags );
?>

<p class="header"><?php echo $text['sitemaint']; ?><br clear="all" /></p>

<?php 
echo tng_coreicons();

echo "<p class=\"normal\">" . $text['standby'] . "</p><br /><br />";

tng_footer( "" );
?>
