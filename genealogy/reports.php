<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "reports";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );

$showreport_url = getURL( "showreport", 1 );
$reports_url = getURL( "reports", 0 );

$query = "SELECT reportname, reportdesc, reportID FROM $reports_table WHERE active = 1 ORDER BY rank, reportname";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numrows = mysql_num_rows( $result );

$logstring = "<a href=\"$reports_url\">" . xmlcharacters($text[reports]) . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( $text[reports], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_rpt.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text[reports]; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

if ( !$numrows ) {
	echo $text[noreports];
}
else {
?>
<table cellpadding="3" cellspacing="1" border="0" width="100%">
	<tr>
		<td class="fieldnameback"><span class="fieldname">&nbsp;</span></td>
		<td class="fieldnameback" width="35%"><span class="fieldname">&nbsp;<b><?php echo $text[reportname]; ?></b>&nbsp;</span></td>
		<td class="fieldnameback" width="65%"><span class="fieldname">&nbsp;<b><?php echo $text[description]; ?></b>&nbsp;</span></td>
	</tr>

<?php
$count = 1;
while( $row = mysql_fetch_assoc($result)) {
	echo "<tr><td class=\"databack\"><span class=\"normal\">$count.</span></td><td class=\"databack\"><span class=\"normal\">&nbsp;<a href=\"$showreport_url" . "reportID=$row[reportID]\">$row[reportname]</a>&nbsp;</span></td><td class=\"databack\"><span class=\"normal\">&nbsp;$row[reportdesc]&nbsp;</span></td></tr>\n";
	$count++;
}
mysql_free_result($result);
?>
</table>

<?php 
}

tng_footer( "" );
?>
