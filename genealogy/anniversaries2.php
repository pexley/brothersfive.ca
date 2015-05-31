<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
$textpart = "search";
include($cms[tngpath] . "getlang.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");

$anniversaries_url = getURL( "anniversaries", 1 );

header( "Location: " . "$anniversaries_url" . "tngevent=$tngevent&tngdaymonth=$tngdaymonth&tngmonth=$tngmonth&tngyear=$tngyear&tngkeywords=$tngkeywords&tngneedresults=$tngneedresults&offset=$offset&tree=$tree&page=$page" );
?>