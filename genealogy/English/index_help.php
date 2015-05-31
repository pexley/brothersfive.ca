<?php
include("../subroot.php");
include($subroot . "config.php");
include("../version.php");
echo $tngconfig['doctype'] ? $tngconfig['doctype'] . "\n\n" : "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n\n";
echo "<!-- $tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright -->\n";
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title>Help: Administration</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
			<a href="backuprestore_help.php" class="lightlink">&laquo; Help: Utilities</a> &nbsp; | &nbsp;
			<a href="people_help.php" class="lightlink">Help: People &raquo;</a>
		</p>
		<span class="largeheader">Help: Getting Started</span>
		<p class="smaller menu">
			<a href="#gettingstarted" class="lightlink">Getting Started</a> &nbsp; | &nbsp;
			<a href="#notes" class="lightlink">Notes</a> &nbsp; | &nbsp;
			<a href="#otherresources" class="lightlink">Other Resources</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">
		<a name="gettingstarted"><p class="subheadbold">Getting Started:</p></a>
		<p>Not sure what to do first? Here are the basics:</p>
		<ol>
				<li><p><strong>Carefully follow the installation instructions in the <a href="../readme.html" target="_blank">readme.html</a> file.</strong> All of the essential configuration
					can be done directly from that page, but you can also enter all the needed values from <strong>Setup</strong> here on the main Admin menu.</p></li>
				<li><p><strong>Create at least one Tree.</strong> Unless you've got more than one independent GEDCOM file, you probably need only one tree.</p></li>
				<li><p><strong>Create at least one User.</strong> The first user created must be an Administrator (must have all rights and NOT be associated with any Tree).</p></li>
				<li><p><strong>Import your data or begin entering it manually</strong>. If you're entering it by hand, it doesn't matter what you enter first.
					Some like to enter people first and then link them into families, while others like to start with families and build the tree up
					that way.</p></li>
				<li><p><strong>Look at the Secondary Processes</strong> (under Import/Export) and perform any of those that you think necessary (see the Help
					there for more information).</p></li>
				<li><p><strong>Media.</strong> Once your data has been entered or imported, you can start linking in photos, histories and other media. Have fun!</p></li>
				<li><p><strong>Everything else.</strong> You'll also want to explore the other sections of the Admin menu. Additional help can be found on
					each page.</p></li>
		</ol>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="notes"><p class="subheadbold">Notes:</p></a>
		<ol>
				<li><p>If you notice some options are missing from the Administration menu, it is likely that you are not logged in with full permissions, or that you are assigned to a particular tree.
				To make changes to user permissions, log out and log in as an administrator, or edit your database directly using phpMyAdmin or a similar tool.</p></li>
				<li><p>The link to Public Home in the top frame will take you to your home page and will fill your browser window. The Public Home link in the left frame will open your home
				page in the right, main frame, allowing you to navigate around your site and return to the Admin section at any time by clicking on another link in the left frame.</p></li>
		</ol>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="otherresources"><p class="subheadbold">Other Resources:</p></a>
		<ol>
			<li><p>Updates mailing list: <a href="mailto:tngusers@lythgoes.net">tngusers@lythgoes.net</a>. To subscribe, send a message to
				<a href="mailto:tngusers-subscribe@lythgoes.net">tngusers-subscribe@lythgoes.net</a>. This list is used exclusively to inform users of
				software updates and related issues. </p></li>
			<li><p>Users mailing list: <a href="mailto:tngusers2@lythgoes.net">tngusers2@lythgoes.net</a>. To subscribe, send a message to
				  <a href="mailto:tngusers2-subscribe@lythgoes.net">tngusers2-subscribe@lythgoes.net</a>. This list may be used for all discussion among TNG users. </p></li>
			<li><p>Users forum: <a href="http://tngforum.us" target="_blank">http://tngforum.us</a>.</p></li>
			<li><p>PHP Reference: <a href="http://www.php.net" target="_blank">http://www.php.net</a>.</p></li>
			<li><p>MySQL Reference: <a href="http://www.mysql.com" target="_blank">http://www.mysql.com</a>.</p></li>
			<li><p>HTML Reference: <a href="http://www.htmlhelp.com" target="_blank">http://www.htmlhelp.com</a>.</p></li>
			<li><p>Contact the author directly: <a href="mailto:darrin@lythgoes.net">darrin@lythgoes.net</a>.</p></li>
			</ol>
	</td>
</tr>

</table>
</body>
</html>
