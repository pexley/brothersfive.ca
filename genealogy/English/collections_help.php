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
	<title>Help: Collections</title>
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
			<a href="media_help.php" class="lightlink">&laquo; Help: Media</a> &nbsp; | &nbsp;
			<a href="albums_help.php" class="lightlink">Help: Albums &raquo;</a>
		</p>
		<span class="largeheader">Help: Collections</span>
		<p class="smaller menu">
			<a href="#what" class="lightlink">What are they?</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Add/Edit/Delete</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="what"><p class="subheadbold">What are Collections?</p></a>

		<p>A <strong>Collection</strong> in TNG refers to a type of media. TNG's standard collections are Photos, Documents, Headstones, Histories, Videos and Recordings,
		but TNG also allows you to create your own collections. A collection is not restricted to a single file type. For example, .jpg images can be part of any collection,
		not just Photos or Documents, and the Photos collection does not have to contain only image files.</p>


	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="add"><p class="subheadbold">Adding Collections</p></a>

		<p>To add a new collection, click on the "Add Collection" button wherever it is visible (for example, on the Media, Add Media and Edit Media screens).
		When the small popup appears, fill out the form. Take note of the following:</p>

		<span class="optionhead">Collection ID</span>
		<p>A very short string of characters to be an identifier for this collection. It should not contain spaces or any characters that are not alphanumeric,
		and ideally it should be 10 characters or less. For example, if you were creating a collection for military records, you might put "military" in this field.
		This value will not be displayed anywhere, so what you name it doesn't really matter, just as long as it is unique.</p>

		<span class="optionhead">Display Title</span>
		<p>This is the name that will be displayed wherever collections are listed, and whenever items of this collection are shown. The Display Title can be slightly
		longer than the Collection ID, but it should still be relatively short. Using the same example, you might put "Military Records" in this field.
		By default, the name you pick will be used in all languages. If you support multiple languages and want your Display Title to be translated into the languages
		you support, you will need to create an entry in the "cust_text.php" file in each language folder. The key of the $text message should be the collection ID,
		and the value is the Display Title. In this example, your entry would look like this:</p>

		<pre>$text['military'] = "Military Records";</pre>

		<p>Duplicate that line in the cust_text.php file for each language you support, translating only the "Military Records" portion. The key or ID ("military") should
		not be translated.</p>

		<span class="optionhead">Folder Name</span>
		<p>The name of the physical folder or directory on your web site where items in this collection will be stored. It should be relatively short, with no spaces
		and only alphanumeric characters (e.g., "military"). After entering a value, you can click on the "Make Folder" button to try and create it. You should
		see a message indicating whether the creation was successful or not. If your server did not allow the operation, you will have to use an FTP program or
		an online file manager to create the folder. It should be created in the same parent folder as the "photos", "documents", "histories" and other collection folder.
		Make sure the actual name matches the name you put here exactly ("Military" does not match "military").</p>

		<span class="optionhead">Icon File</span>
		<p>You must create your own icon, or use one of the existing ones, and enter the name of the icon file here. The icon file should be located in the main TNG folder,
		along with the other standard media icons (like "tng_photo.gif" or "tng_doc.gif").</p>

		<span class="optionhead">Display Order</span>
		<p>Enter a whole number here to indicate the order in which your custom Collection types will be displayed in the public dropdown menus. Lower numbers appear first.</p>

		<span class="optionhead">Same setup as</span>
		<p>You may have noticed that the Add Media and Edit Media screens change slightly depending on which Collection you choose. This "same setup as" field allows you
		to indicate which of the standard Collection types your new Collection should resemble most, with regard to the layout of those screens.</p>

		<p class="subheadbold">Editing/Deleting Collections</p></a>

		<p>To edit an existing custom Collection (the standard ones cannot be edited, except in the General Settings), select that Collection from the dropdown list and
		click on the Edit button. The fields will be as described above.</p>

		<p>To delete an existing custom Collection, select that Collection from the dropdown list and click on the Delete button. Neither the physical folder you created,
		nor any of the items in it, should be deleted.</p>

	</td>
</tr>

</table>
</body>
</html>
