<?php
include("begin.php");
require($subroot . "logconfig.php");
include($cms['tngpath'] . "genlib.php");
include($cms['tngpath'] . "getlang.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

header("Content-type:text/html; charset=" . $session_charset);
$lines = file( $logfile );
foreach ( $lines as $line ) {
	echo "$line<br/>\n";
}
?>
