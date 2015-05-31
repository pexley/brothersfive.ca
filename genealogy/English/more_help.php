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
	<title>Help: Events</title>
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
			<a href="events_help.php" class="lightlink">&laquo; Help: Events</a> &nbsp; | &nbsp;
			<a href="media_help.php" class="lightlink">Help: Media &raquo;</a>
		</p>
		<span class="largeheader">Help: More</span>
		<p class="smaller menu">
			<a href="#more" class="lightlink">More Information</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="more"><p class="subheadbold">More Information</p></a>
		<p>This screen allows you to enter additional information related to TNG's standard event types. When one or more of these fields are filled in,
		the More icon (plus sign) will have a green dot in the corner. Fields on the More Information screen include:</p>

        <p><span class="optionhead">Age</span>: The age of the individual at the time of the event.</p>

        <p><span class="optionhead">Agency</span>: The institution or individual having authority and/or responsibility at the time of the event.</p>

        <p><span class="optionhead">Cause</span>: The cause of the event (most often used with Death).</p>

        <p><span class="optionhead">Address 1/Address 2/City/State/Province/Zip/Postal Code/Country/Phone/E-mail/Web Site</span>: The address and other contact information
		associated with the event.</p>

        <p><span class="optionhead">Required fields:</span>
		None of the information here is required.</p>
	</td>
</tr>

</table>
</body>
</html>
