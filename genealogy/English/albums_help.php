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
	<title>Help: Albums Page</title>
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
			<a href="collections_help.php" class="lightlink">&laquo; Help: Collections</a> &nbsp; | &nbsp;
			<a href="cemeteries_help.php" class="lightlink">Help: Cemeteries &raquo;</a>
		</p>
		<span class="largeheader">Help: Albums</span>
		<p class="smaller menu">
			<a href="#search" class="lightlink">Search</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Add New</a> &nbsp; | &nbsp;
			<a href="#edit" class="lightlink">Edit Existing</a> &nbsp; | &nbsp;
			<a href="#delete" class="lightlink">Delete</a> &nbsp; | &nbsp;
			<a href="#sort" class="lightlink">Sort</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="search"><p class="subheadbold">Search</p></a>
        <p>Locate existing media by searching for all or part of the <strong>Album Name, Description</strong> or
		<strong>Keywords</strong>. Searching with no value in the search box will find all albums in your database.</p>

		<p>Your search criteria for this page will be remembered until you click the <strong>Reset</strong> button, which restores all default values and searches again.</p>

		<span class="optionhead">Actions</span>
		<p>The Action buttons next to each Album allow you to edit, delete or preview that Album.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="add"><p class="subheadbold">Adding New Albums</p></a>
		<p>An <strong>Album</strong> in TNG is a grouping of media. An Album can include any number of media, and any particular media item can belong to multiple albums.
		Like individual media, Albums can be linked to people, families, sources, repositories or places.</p>

		<p>To add a new Album, click on the <strong>Add New</strong> tab, then fill out the form. Some information, including the media to include and
		links to people, families and other entities, can be added after saving the record. Take note of the following:</p>

		<p><span class="optionhead">Album Name</span><br />
		The name of your album.</p>

		<p><span class="optionhead">Description</span><br />
		A short description of the album or the items contained in it.</p>

		<p><span class="optionhead">Keywords</span><br />
		Any number of keywords outside the Album Name or Description that can be used to locate this album when searching.</p>

		<p><span class="optionhead">Required fields:</span> Album Name is he only required field, but it is in your best interest to fill in the other fields as well.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="edit"><p class="subheadbold">Editing Existing Albums</p></a>
		<p>To make changes to an existing Album, use the <a href="#search">Search</a> tab to locate the Album, then click on the Edit icon next to that Album.
		Take note of the following items that are not on the "Add New Album" page:</p>

		<span class="optionhead">Album Media</span>
		<p>To add media to an album, click on the "Add Media" button, then use the form in the resulting popup to select media from the items currently in
		your database. To do that, select a Collection and/or a Tree (both optional), then enter part of the media name or description in the "Search for" field
		and click the "Search" button. When you locate an item that you'd like to add to the Album, click on the "Add" link to the left of the item row. That
		item will be added and the popup will remain. Repeat this step to locate and add more media, or click on the "Close Window" link to return to the Edit Album page.</p>

		<p>To remove media from an album, move your mouse pointer over the item. A "Remove" link will be revealed. Click that link to remove the item. After the
		confirmation, the item will fade away.</p>

		<p>To choose one thumbnail to be the <strong>Default Photo</strong> for the current Album, move your mouse pointer over the item. A "Make Default" link will be revealed.
		Click that link to designate the thumbnail for that item as the Album's Default Photo. To select a different Default Photo, repeat the process with a different
		item in the list. To remove the Default Photo designation altogether, click on the "Remove default photo" link at the top of the page.</p>

		<p>To reorder the media within the Album, click on the "Drag" area for any item and hold the mouse button down while moving the mouse pointer to the desired location
		within the list. When the item has reached the selected point, release the mouse button ("drag and drop"). Changes are automatically saved at that point.</p>

		<span class="optionhead">Album Links</span>
		<p>You can link this Album to people, families, sources, repositories or places. For each link, first select the Tree associated with the link entity.
		Next, select the Link Type (Person, Family, Source, Repository or Place), and finally, enter the ID number or name (Places only) of the link entity. After
		all the information has been entered, click on the "Add" button.</p>

		<p>If you don't know the ID number or exact Place Name, click the magnifying glass icon to search for it. A popup window will appear to let you do the searching.
		When you find the desired entity description, click the "Add" link at the left. You may click "Add" for multiple entities. When you are finished creating
		links, click on the "Close Window" link.</p>

		<p>NOTE: All changes relating to Album Media and Album Links are saved immediately and do not require you to click the "Save" button at the bottom of the screen.
		Changes in the "Album Information" section do require you to click "Save".</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="delete"><p class="subheadbold">Deleting Albums</p></a>
		<p>To delete an Album, use the <a href="#search">Search</a> tab to locate the Album, then click on the Delete icon next to that Albumm. The row will
		change color and then vanish as the item is deleted.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="sort"><p class="subheadbold">Sorting Albums</p></a>
		<p>By default, Albums linked to a Person, Family, Source, Repository or Place are sorted by the order in which they were linked to that entity. To change that
		order, you must indicate a new order on the Album/Sort tab.</p>

		<span class="optionhead">Tree, Link Type, Collection:</span>
		<p>Select the Tree associated with the entity for which you would like to sort Albums. Next, select a Link Type (Person, Family, Source, Repository or Place) and
		the Collection you would like to sort.</p>

		<span class="optionhead">ID:</span>
		<p>Enter the ID number or name (Places only) of the entity. If you don't know the ID number or exact place name, click the magnifying glass icon to search for it.
		When you find the desired entity, click on the "Select" link next to that entity. The popup will close and the selected ID will appear in the ID field.</p>

		<span class="optionhead">Sorting Procedure</span>
		<p>After selecting or entering an ID, click on the "Continue" button to display all Albums for the selected entity and Collection in their current order.
		To reorder the Albums, click on the "Drag" area for any item and hold the mouse button down while moving the mouse pointer to the desired location
		within the list. When the item has reached the selected point, release the mouse button ("drag and drop"). Changes are automatically saved at that point.</p>

	</td>
</tr>

</table>
</body>
</html>
