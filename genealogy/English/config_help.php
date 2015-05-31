
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
	<title>Help: General Settings</title>
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
			<a href="setup_help.php" class="lightlink">&laquo; Help: Setup</a> &nbsp; | &nbsp;
			<a href="pedconfig_help.php" class="lightlink">Help: Chart Settings &raquo;</a>
		</p>
		<span class="largeheader">Help: General Settings</span>
		<p class="smaller menu">
			<a href="#data" class="lightlink">Database</a> &nbsp; | &nbsp;
			<a href="#table" class="lightlink">Tables</a> &nbsp; | &nbsp;
			<a href="#path" class="lightlink">Paths+Folders</a> &nbsp; | &nbsp;
			<a href="#site" class="lightlink">Site</a> &nbsp; | &nbsp;
			<a href="#media" class="lightlink">Media</a> &nbsp; | &nbsp;
			<a href="#lang" class="lightlink">Language</a> &nbsp; | &nbsp;
			<a href="#priv" class="lightlink">Privacy</a> &nbsp; | &nbsp;
			<a href="#name" class="lightlink">Names</a> &nbsp; | &nbsp;
			<a href="#cem" class="lightlink">Cemeteries</a> &nbsp; | &nbsp;
			<a href="#misc" class="lightlink">Miscellaneous</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="data"><p class="subheadbold">Database</p></a>

		<span class="optionhead">Database Host, Name, User Name, Password</span>
		<p>This is the information TNG and PHP will use to connect to your database. These fields must be filled in before your database 
		can be accessed. <strong>Note</strong>: The user name and password mentioned here may be different from
		your regular web site login. If, after entering this information, you continue to see an error message that TNG is not communicating
		with your database, then you know at least one of these values is incorrect. If you don't know the correct information, ask your web 
		hosting provider. The host name may also require a port number or a socket path (i.e., "localhost:3306" or "localhost:/path/to/socket"). 
		Case is important, so be mindful to type in everything exactly as it was given
		to you. If you are acting as your own webmaster, be sure you have created a database
		and added a user to it (the user must have ALL rights).</p>

		<span class="optionhead">Maintenance Mode</span>
		<p>When TNG is in Maintenance Mode, the data cannot be accessed from the public side of your site. Instead, visitors will see a 
		polite message telling them that you are performing maintenance on the site and they should try again later. You might wish to
		put your site in Maintenance Mode while you are re-importing your data. If you are resequencing your IDs, Maintenance Mode is
		required.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="table"><p class="subheadbold">Table Names</p></a>

		<span class="optionhead">Table Names</span>
		<p>You shouldn't have to change any of the default names unless you already have one or more tables with one or more of these 
		names. Always make sure all table names are filled in and that all names are unique.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="path"><p class="subheadbold">Paths and Folders</p></a>

		<span class="optionhead">Root Path</span>
		<p>This is the system path to the folder or directory where your TNG files are located. It is not a web address.
		You must include a trailing slash. When you first open this page, your Root Path should be correct. Do not change it unless you are an advanced user
		or have been instructed to do so.</p>

		<span class="optionhead">Config Path</span>
		<p>If you would like to put your TNG configuration files in a more secure location outside of the "web root" directory (so they aren't
		accessible from the web), enter that path here. It <strong>must</strong> end with a trailing slash (/). It will likely be the first part of the Root Path.
		For example, if your Root Path is "/home/www/username/public_html/genealogy/", then you might choose "/home/www/username/" as your Config Path.</p>

		<p><strong>IMPORTANT:</strong> Use of this field is
		completely optional and will not affect the operation of your site one way or the other. You should only enter something here
		if you are very familiar with your web site's directory structure. If you do enter a path here, you <strong>must move the following files 
		to the Config Path immediately after saving</strong> and make them writeable (664 or 666 permissions): config.php, customconfig.php, importconfig.php,
		logconfig.php, mapconfig.php, pedconfig.php. If you don't, nothing on the site will be operational. If you make a mistake and your site stops working,
		you will need to manually edit your subroot.php file in order to correct the $tngconfig['subroot'] path (setting it back to blank will return your system
		to the way it was before).</p>

		<span class="optionhead">Photo / Document / History / Headstone / Multimedia / GENDEX / Backup Folders</span>
		<p>Please enter folder or directory names for these respective entities. All should have global read+write+execute permissions (755 or 775, although some systems will require 777).
		The Multimedia folder is intended as a "catch all" for any media items that don't fit cleanly into the other categories (e.g., videos and
		audio recordings). These folders can be created from this screen by clicking on the "Make Folder" buttons.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="site"><p class="subheadbold">Site Design and Definition</p></a>

		<span class="optionhead">Home Page</span>
		<p>All TNG menus include a link to the "Home Page". Enter the address for this link here. By default this is the index.php page in the folder with your other
		TNG files. It must be a relative link ("index.php" or "../otherhomepage.html"), not an absolute link ("http://yoursite.com").</p>

		<span class="optionhead">Genealogy URL</span>
		<p>The web address for your genealogy folder (i.e., "http://mysite.com/genealogy").</p>

		<span class="optionhead">Site Name</span>
		<p>If you enter something here, it will be included in the HTML "Title" tag on every page and will show up at the top of your
		browser window.</p>

		<span class="optionhead">Site Description</span>
		<p>A short description of your site for use on the RSS feed page.</p>

		<span class="optionhead">Doctype Declaration</span>
		<p>This string is placed at the top of every page in the public area to give the user's browser the information it needs
		to render the page correctly. Validation tests run against the pages will use this information to determine what problems
		may exist. If you leave this blank, the default XHTML Transitional doctype will be used.</p>

		<span class="optionhead">E-mail Address</span>
		<p>Your e-mail address. When visitors request a new user account, an e-mail message will be sent to this address.</p>

		<span class="optionhead">Site Owner</span>
		<p>Your name, or your business name. This name will appear on outgoing e-mail messages originating from TNG.</p>

		<span class="optionhead">Target Frame</span>
		<p>If your site uses frames, use this field to indicate in which frame the TNG pages should display. If you are not using frames, 
		leave this as "_self".</p>

		<span class="optionhead">Custom Header / Footer / Meta</span>
		<p>File names for the page fragments to be used as your TNG page header, footer and HEAD section ("meta"). Files with the default names are supplied.
		To use PHP coding in these files, they must be renamed to have .php extensions.</p>

		<span class="optionhead">Tab Style Sheet</span>
		<p>The file that dictates the style of tabs displayed on many of the public pages. The default style (tngtabs1.css) features slanted tabs, but
		an alternate style with "squarish" tabs (tngtabs2.css) also comes with TNG. To view tabs with this style, enter "tngtabs2.css"
		in this field and click "Save" at the bottom of the page, then look up any individual in the public area. The default style (tngtabs1.css) makes use of two images, "tngtab.png" (inactive
		tabs) and "tngtabactive.png" (active tabs). To change the color of these images, you may use any image editor, or click on the link at the end of this paragraph. On the next page,
		enter <strong>decimal</strong> values for the red, green and blue components of the desired new color, then click Submit. You will then see a new image, which you can save on your site as either
		tngtab.gif or tngtabactive.png. <a href="http://lythgoes.net/genealogy/switchcolor.php">http://lythgoes.net/genealogy/switchcolor.php</a></p>

		<span class="optionhead">Menu Location</span>
		<p>The TNG menu may be located on the top left of every page, just above the individual's name or other page heading, or on the top right of every page, directly across from
		the name or other page heading. The dynamic language selection dropdown will be located in the same section of the screen.</p>

		<span class="optionhead">Show Home / Search / Login/Logout / Print / Add Bookmark Links</span>
		<p>These menu options are normally located at the top right of every page, just under the page heading and above the row of tabs.
		Each of these options can be turned on or off using these controls.</p>

		<span class="optionhead">Hide Christening Labels</span>
		<p>This option allows you to hide all mention of the "Christening" event.</p>

		<span class="optionhead">Default Tree</span>
		<p>When more than one tree exists, all pages where a selection is possible (including the search utility
		on your home page) will default to "All Trees". If you instead want to point this to one tree in particular,
		select that tree here. Whenever a user enters a URL without a tree ID (or with a blank tree ID), the request
		will be rerouted to this tree. <strong>NOTE</strong>: If you have only one tree, it is better to leave this field blank.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="media"><p class="subheadbold">Media</p></a>

		<span class="optionhead">Photos Extension</span>
		<p>The file extension assigned to all small pedigree-style photos. Other photos need not have this extension. The .jpg extension is recommended for most photos.</p>

		<span class="optionhead">Show Extended Photo Info</span>
		<p>If this option is checked, any available extended information will be displayed for each photo. This includes the physical file name, the dimensions in pixels, and any
		existing IPTC data.</p>

		<span class="optionhead">Image Max Height and Width</span>
		<p>When these values are set (pixels), images larger than these dimensions will be scaled down (using HTML) when displayed in the public area.</p>

		<span class="optionhead">Thumbnail Max Width</span>
		<p>When TNG automatically creates a thumbnail image, the image will be no wider than this (pixels).</p>

		<span class="optionhead">Thumbnails Prefix</span>
		<p>When generating thumbnails automatically, TNG will prepend this value to the original image file name to create the thumbnail file name. If the file name of the original includes path
		information, the prefix will be included directly before the file name. This prefix can include a folder name (ie, "thumbnails/"). If you
		will be using a folder name as part of the prefix, be sure that this folder exists and has the same permissions as the main Photos folder.</p>

		<span class="optionhead">Thumbnails Suffix</span>
		<p>When generating thumbnails automatically, TNG will append this value to the original image file name to create the thumbnail file name.</p>

		<span class="optionhead">Thumbnail Max Height</span>
		<p>When TNG automatically creates a thumbnail image, the image will be no taller than this (pixels).</p>

		<span class="optionhead">Thumbnail Max Width</span>
		<p>When TNG automatically creates a thumbnail image, the image will be no wider than this (pixels).</p>

		<span class="optionhead">Columns in Thumbnail View</span>
		<p>When browsing all photos in thumbnail view, this many thumbnails will be displayed in a single row. If more
		exist, additional rows will be displayed up to the "Maximum Search Result" number of rows.</p>

		<span class="optionhead">Enable Slide Show</span>
		<p>Allows a set of photos to be shown automatically in succession from the public area when the "Start Slideshow" link is clicked. Setting
		this option to 'No' hides the link and disables the feature.</p>

		<span class="optionhead">Slide Show Auto Repeat</span>
		<p>Setting this option to 'Yes' allows the slide show to run continuously.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="lang"><p class="subheadbold">Language</p></a>

		<span class="optionhead">Language</span>
		<p>Your default language folder (i.e., 'English'). You may have more than one language available to visitors, but this language will always display first.</p>

		<span class="optionhead">Character Set</span>
		<p>The character set for your default language. If this is left blank, the browser's default character set will be used. The character set for English and other languages using the 26-character
		Roman alphabet is ISO-8859-1.</p>

		<span class="optionhead">Dynamic Language Change</span>
		<p>If you have set up more than one language and want users to be able to select a different language "on the fly",
		select <em>Allow</em>.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="priv"><p class="subheadbold">Privacy</p></a>

		<span class="optionhead">Require Login</span>
		<p>Normally anyone can view your public pages, with a login to see data for living individuals being optional. If, however,
		you want to require everyone to log in before they can see anything beyond the home page, check this box.</p>

		<span class="optionhead">Restrict access to assigned tree</span>
		<p>If Require Login is set to 'Yes', then setting this option to 'Yes' will cause users to only see information associated with their
		assigned trees. All other individuals, families, sources, etc. will be hidden.</p>

		<span class="optionhead">Show LDS Data</span>
		<p>To always show LDS data (where available), select <em>Always</em> (this was the default before). To turn off all LDS
		information and the ability to manually enter LDS data, select <em>Never</em>. To make this switch dependent on
		user permissions, select <i>Depending on user rights</i>. In this case, only logged-in users who have rights
		to see LDS data will see it. It will be hidden from all others.</p>

		<span class="optionhead">Show Living Data</span>
		<p>To always show living data (dates and places for living individuals), select <i>Always</i>. To turn off all living
		information, select <i>Never</i>. To make the display of living data dependent on
		user permissions, select <i>Depending on user rights</i>. In this case, only logged-in users who have rights
		to see living data will see it. It will be hidden from all others.</p>

		<span class="optionhead">Show Names for Living</span>
		<p>To hide the names of individuals marked as Living (no death or burial information, plus a birthdate less than 110 years ago), select <em>No</em>. Names of living
		individuals will be replaced with the word "Living". To show the surname and first initial(s) of living individuals, select <em>Abbreviate first name</em>. To
		always show all names for everyone, select <em>Yes</em>.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="name"><p class="subheadbold">Names</p></a>

		<span class="optionhead">Name Order</span>
		<p>Dictates how names will be displayed in most cases (some lists always display the surname first). Choose to display the first name first (Western) or the surname first (Oriental).
		If nothing is selected, names will be displayed "first name first".</p>

		<span class="optionhead">Surname Prefixes</span>
		<p>Governs how surname prefixes (i.e., "de" or "van") are treated. By default, anything imported in the GEDCOM surname field is part of the surname, and this dictates how
		surnames are sorted ("de Kalb" comes before "van Buren"). You can elect to keep surname prefixes as part of the surname, or you can choose to treat them
		as separate entities (thus, "van Buren" would then sort before "de Kalb"). Existing surnames will not be affected unless manually edited or converted with surnameconvert400.php.</p>

		<span class="optionhead">Prefix Detection on Import</span>
		<p>If you have elected to treat surname prefixes as separate entities, this section will provide rules to help the import routine decide what is a prefix. Prefixes are defined as
		portions of the name separated by spaces, but you can choose how many prefixes from each name will be part of TNG's prefix. In other words, if you indicate that
		the "Num. prefixes each (max)" is 1, then only the "van" from "van der Merwe" would be moved to the prefix field. On the other hand, if you set this value to 2 or higher, "van der"
		would be the prefix. You may also indicate one or more specific prefixes that should always be treated as full prefixes. In other words, if you set this value to "van der", then
		"van der" will always be considered a valid prefix, regardless of how high or low you set the previous value. Separate multiple values with commas. To recognize a
		prefix offset by an apostrophe, include the apostrophe in this list. For example: "van,vander,van der,d',a',de,das".</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="cem"><p class="subheadbold">Cemeteries</p></a>

		<span class="optionhead">Max lines per column (approx.)</span>
		<p>If you have a lot of cemeteries defined, this number will tell TNG to split the list and create another column when the
		number is reached.</p>

		<span class="optionhead">Suppress "Unknown" categories</span>
		<p>If you define a cemetery with a missing locality (e.g., no state or no county), TNG will normally create a heading labeled
		"Unknown" to accommodate the empty fields. Choosing this option will cause TNG to leave the "Unknown" headings off.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="misc"><p class="subheadbold">Miscellaneous</p></a>

		<span class="optionhead">Max Search Results</span>
		<p>This limits the number of results that can be displayed for any public search query. This should be a relatively small, manageable number in order to maximize
		efficiency and enhance the user experience.</p>

		<span class="optionhead">Individuals Start With</span>
		<p>This indicates which information will be initially viewable when an individual record is displayed. If you
		select "Personal Information Only", then other categories such as Notes, Citations or Photos and Histories will
		be hidden until they or "All" are explicitly selected by the user.</p>

		<span class="optionhead">Show Notes</span>
		<p>Allows you to choose whether event-specific notes are displayed in the usual Notes section at the bottom of the page, or adjacent to the corresponding event.</p>

		<span class="optionhead">Server time offset (hours)</span>
		<p>If your server is in a different time zone than you are, enter the difference in hours here. If your time is behind the server time, enter a negative number.</p>

		<span class="optionhead">Max Generations, GEDCOM download</span>
		<p>The number of maximum number generations that can be exported in a publicly requested GEDCOM file.</p>

		<span class="optionhead">What's New Days</span>
		<p>The number of days to keep new items on the "What's New" page.</p>

		<span class="optionhead">What's New Limit</span>
		<p>The maximum number of items in each category to display on the "What's New" page.</p>

		<span class="optionhead">Numeric Date Preference</span>
		<p>If you enter a numeric date (e.g., 04/09/2008), this option determines whether to interpret the entry as Month/Day/Year (9 Apr 2008)
		or Day/Month/Year (4 Sep 2008).</p>

		<span class="optionhead">Allow new user registrations</span>
		<p>Allows you to turn off the option for visitors to request a user account on your site.</p>

	</td>
</tr>

</table>
</body>
</html>
