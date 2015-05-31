<?php
include("../subroot.php");
include($subroot . "config.php");
$tngconfig['maint'] = "";
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
$maintenance_mode = true;
include("checklogin.php");
include("../version.php");

tng_adminheader( $admtext['maintmode'], '' );
?>
</head>

<body background="../background.gif">
<div align="center">
<table width="100%" border="0" cellpadding="10" class="lightback">
<tr class="fieldnameback">
	<td>
		<span class="whiteheader"><font size="5"><?php echo $admtext['maintmode']; ?></font></span>
	</td>
</tr>
<tr class="databack">
<td>
	<p class="normal"><?php echo $admtext['maintexp']; ?>
	</p><br /><br />
</td>
</tr>

</table>
</div>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
