<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "login";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

require($subroot . "logconfig.php");

if( $adminmaxloglines )
	$loglines = $adminmaxloglines;
else 
	$loglines = "";

tng_adminheader( $admtext[adminlogfile], "" );
?>
</head>

<body background="../background.gif">
<div align="center">
<table width="100%" border="0" cellpadding="10" class="lightback">
<tr class="fieldnameback">
	<td>
		<span class="whiteheader"><font size="5"><?php echo "$loglines $admtext[mostrecentactions]"; ?></font></span>
	</td>
</tr>
<tr class="databack">
<td>
<span class="normal">
<?php
	$lines = file( $adminlogfile );
	
	foreach ( $lines as $line ) {
		echo "$line<br/>\n";
	}
?>
</span>
</td>
</tr>

</table>
</div>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
