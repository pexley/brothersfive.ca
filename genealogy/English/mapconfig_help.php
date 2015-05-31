<?php
include("../subroot.php");
include($subroot . "config.php");
include("../version.php");
	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD $tng_doctype //EN\">\n";
	echo "<!-- $tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright -->\n";
?><html>
<head>
	<title>Help: Map Settings</title>
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
			<a href="importconfig_help.php" class="lightlink">&laquo; Help: Import Settings</a> &nbsp; | &nbsp;
			<a href="users_help.php" class="lightlink">Help: Users &raquo;</a>
		</p>
		<span class="largeheader">Help: Map Settings</span>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow"><span class="normal">

		<span class="optionhead">Map Key</span>
		<p>You must get a map <strong>key</strong> from Google in order to use Google Maps on your site. You can obtain a key here:
		<a href="http://www.google.com/apis/maps/signup.html" target="_blank">http://www.google.com/apis/maps/signup.html</a>.
		After you receive your key, paste it into the <strong>Map Key</strong> field on the TNG Map Settings page. If later you decide not to use Google Maps,
		simply remove the key from this field and the maps and map-related fields will no longer display.</p>
		<p><strong>NOTE</strong>: If you obtain the key for your domain URL without the "www", the key will also work for subdomains.</p>

		<span class="optionhead">Map Type</span>
		<p>Choose which type of map will be displayed first: Normal, Satellite or Hybrid (a satellite image with streets laid out
		on top).</p>

		<span class="optionhead">Starting Latitude, Starting Longitude</span>
		<p>These coordinates determine where the default "center" of the map is for any place that does not yet have any assigned coordinates. The pin
		will start at that location.</p>

		<span class="optionhead">Default Zoom</span>
		<p>This number indicates how close up or far away new Google Maps in the Admin area should be displayed to begin with. Lower numbers mean that the
		view is farther away, while higher numbers mean the view is closer. Once the zoom is saved for a particular map, it will be saved with that map.</p>

		<span class="optionhead">Dimensions, Individual Page</span>
		<p>Enter the dimensions (width must be in pixels with "px" at the end, or as a percentage; height must be in pixels with "px" at the end) for the map
		displayed on each person's individual page.	For example, to make the map be 500 pixels high, set the <strong>Height</strong> to 500px. To make the map reach 80 percent
		of the way across the allotted area, set the <strong>Width</strong> to 80%.</p>

		<span class="optionhead">Dimensions, Headstones Pages</span>
		<p>Enter the dimensions for the maps displayed on all headstone-related pages (width must be in pixels with "px" at the end, or as a percentage;
		height must be in pixels with "px" at the end)</p>

		<span class="optionhead">Dimensions, Admin Pages</span>
		<p>Enter the dimensions for the maps displayed on all Admin pages (width must be in pixels with "px" at the end, or as a percentage; height
		must be in pixels with "px" at the end).</p>

		<span class="optionhead">Hide Admin Maps to Start</span>
		<p>To hide the maps on the Admin pages until the <span class="emphasis">Show/Hide</span> button is clicked, select <span class="choice">Yes</span> here. To
		have the maps displayed by default when the pages are displayed, select <span class="choice">No</span>.</p>

		<span class="optionhead">Consolidate Duplicate Pins</span>
		<p>If multiple events for an individual occurred at the same location, setting this option to <span class="emphasis">Yes</span> will prevent duplicate pins from being
		created for non-unique place names. Note: Setting this option to <span class="emphasis">No</span> will cause duplicate pins to obstruct each other.</p>

		<span class="optionhead">Place Levels Pins: Labels and Colors</span>
		<p>Each geocode location can be associated with one of six <strong>Place Levels</strong> (e.g., Location, Town/City, County/Shire, etc.). The labels for these
		levels can be found in the "alltext.php" file in each language folder, and you may override them in your "cust_text.php" file (also in each language folder).</p>

		<p>The pin colors are determined by values set in mapconfig.php. If you would like to change the pin colors, go to the TNG downloads page
		and download the full palette of 216 different pin colors, then open your mapconfig.php file in a text editor and enter the number of the
		new pin color next to the corresponding place level variable. Finally, upload the new pin image file(s) to the <span class="emphasis">googlemaps</span> folder on your site.</p>

		</span>
	</td>
</tr>

</table>
</body>
</html>
