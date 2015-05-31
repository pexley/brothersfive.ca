<?php
include("begin.php");
if($cms['events']){include('cmsevents.php'); cms_logs();}
require($subroot . "logconfig.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "showlog";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

if( $maxloglines )
	$loglines = $maxloglines;
else 
	$loglines = "";

$showlog_url = getURL( "showlog", 1 );
$logxml_url  = getURL("logxml",0);

//$flags[autorefresh] = $autorefresh;
if( $autorefresh )
	$flags['scripting'] = "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "net.js\"></script>\n";
$owner = $sitename ? $sitename : $dbowner;
tng_header( "$text[logfilefor] $owner", $flags );
?>

<span class="header"><?php echo "$loglines $text[mostrecentactions]"; ?></span><br clear="all" />
<?php
echo tng_coreicons();

if( $autorefresh )
	echo "<p class=\"normal\"><a href=\"$showlog_url" . "autorefresh=0\">$text[refreshoff]</a></p>\n";
else
	echo "<p class=\"normal\"><a href=\"$showlog_url" . "autorefresh=1\">$text[autorefresh]</a></p>\n";
?>

<div align="left" class="normal" id="content">
<?php
if( !$autorefresh) {
	$lines = file( $logfile );
	foreach ( $lines as $line ) {
		echo "$line<br/>\n";
	}
}
?>
</div>

<?php
if( $autorefresh ) {
?>
<script type="text/javascript">
function refreshPage() {
 	var loader1 = new net.ContentLoader('<?php echo $logxml_url ?>',FillPage,null,"POST",'');
	var timer = setTimeout("refreshPage()",30000);
}

function FillPage() {
   	var content = document.getElementById("content");
	content.innerHTML = this.req.responseText;
}

refreshPage();
</script>
<?php
}
tng_footer( "" );
?>
