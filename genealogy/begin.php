<?php
$cms = array();
if(isset($cms['support']) || isset($cms['tngpath']) || isset($_GET['lang']) || isset($_GET['mylanguage']) || isset($_GET['language']) || isset($_GET['session_language'])) die("Sorry!");
$tngconfig = "";
include("subroot.php");
include($tngconfig['subroot'] . "config.php");
$subroot = $tngconfig['subroot'] ? $tngconfig['subroot'] : $cms['tngpath'];
?>
