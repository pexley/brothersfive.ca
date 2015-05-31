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
	<title>Help: Log Settings</title>
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
			<a href="pedconfig_help.php" class="lightlink">&laquo; Help: Chart Settings</a> &nbsp; | &nbsp;
			<a href="importconfig_help.php" class="lightlink">Help: Import Settings &raquo;</a>
		</p>
		<span class="largeheader">Help: Log Settings</span>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">
		<span class="optionhead">Log File Name</span>
		<p>The Log File Name is the file where visitor actions are recorded. You shouldn't have to change this from "genlog.txt".</p>

		<span class="optionhead">Max Log Lines</span>
		<p>Max Log Lines indicates how many actions should be
		retained at any one time. If this number gets too high, you may experience a performance hit.</p>

		<span class="optionhead">Exclude Host Names</span>
		<p>Before making any log entry, TNG will check this list. If the host of the visitor responsible for the potential log entry
		is on the list, no log entry will be made. Host names should be separated by commas (no spaces) and can consist of entire
		host names, IP addresses, or portions of either. For example, "googlebot" will block "crawler4.googlebot.com".</p>

		<span class="optionhead">Exclude User Names</span>
		<p>Before making any log entry, TNG will check this list as well. If the logged-in user
		is on the list, no log entry will be made. User names should be separated by commas (no spaces).</p>

		<span class="optionhead">Log File Name (Admin)</span>
		<p>The log file where actions in the Admin area are recorded. You shouldn't have to change this from "genlog.txt".</p>

		<span class="optionhead">Max Log Lines (Admin)</span>
		<p>Indicates how many actions should be retained at any one time in the Admin log file. If this number gets too high, you may experience a performance hit.</p>

		<span class="optionhead">Block Suggestions or New User Registrations</span></p>

		<span class="optionhead">Address contains</span>
		<p>Block any incoming suggestion or new user registration where the e-mail address of the sender contains any of the entered words or word segments.
		Separate multiple words with commas.</p>

		<span class="optionhead">Message contains</span>
		<p>Block any incoming suggestion or new user registration where the message body contains any of the entered words or word segments.
		Separate multiple words with commas.</p>
	</td>
</tr>

</table>
</body>
</html>
