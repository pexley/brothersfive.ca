<?php
include("../subroot.php");
include($subroot . "config.php");
include("../version.php");
echo $tngconfig['doctype'] ? $tngconfig['doctype'] . "\n\n" : "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n\n";
echo "<!-- $tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright -->\n";
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Help: Setup Page</title>
<?php 
	include("../admin/adminmeta.php");
?>
<style>
p {margin-top: 0px;}
p.menu {
	margin-top:8px;
	margin-bottom:0px;
	color:#FFFFFF;
}
</style>
</head>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
<tr class="fieldnameback">
	<td class="tngshadow">
		<p style="float:right; text-align:right" class="smaller menu">
			<a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
			<a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br />
			<a href="second_help.php" class="lightlink">&laquo; Help: Secondary Processes</a> &nbsp; | &nbsp;
			<a href="config_help.php" class="lightlink">Help: General Settings &raquo;</a>
		</p>
		<span class="largeheader">Help: Setup</span>
		<p class="smaller menu">
			<a href="#config" class="lightlink">Configuration</a> &nbsp; | &nbsp;
			<a href="#diag" class="lightlink">Diagnostics</a> &nbsp; | &nbsp;
			<a href="#tables" class="lightlink">Table Creation</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="config"><p class="subheadbold">Configuration</p></a>
		<p>This page contains access points to various categories of TNG settings. Edit the settings in each category to reflect your web site's file layout, your
		MySQL database,	and other configurable options. Change other settings to affect the display of your various pages.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="diag"><p class="subheadbold">Diagnostics</p></a>

		<span class="optionhead">Run Diagnostics</span>
		<p>This page shows information about your web server setup, including warnings about settings that may interfere with TNG's performance.</p>

		<span class="optionhead">PHP Info Screen</span>
	   	<p>This page shows information about your PHP installation. The display of this information is a function of PHP, not TNG. The page is divided into blocks
		that describe separate areas of the configuration. If you are not able to connect to the MySQL database, check this page and look for a "mysql" block. If
		you do not see it, that means that PHP is not yet communicating with MySQL. That indicates a problem with the PHP setup, not with TNG.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="diag"><p class="subheadbold">Table Creation</p></a>

		<span class="optionhead">Create Tables</span>
		<p>Click on this button <strong>ONLY</strong> when setting up your site for the first time, as this will create the database tables needed to
		hold your data. <strong>Note: If the tables already exist, any and all previous data will be lost!</strong> You may want to perform this operation anyway
		if your data has been corrupted and you can be restored from backups after recreating the tables.</p>

	</td>
</tr>

</table>
</body>
</html>
