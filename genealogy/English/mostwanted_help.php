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
			<a href="reports_help.php" class="lightlink">&laquo; Help: Reports</a> &nbsp; | &nbsp;
			<a href="languages_help.php" class="lightlink">Help: Languages &raquo;</a>
		</p>
		<span class="largeheader">Help: Most Wanted</span>
		<p class="smaller menu">
			<a href="#add" class="lightlink">Add New</a> &nbsp; | &nbsp;
			<a href="#edit" class="lightlink">Edit Existing</a> &nbsp; | &nbsp;
			<a href="#sort" class="lightlink">Sort</a> &nbsp; | &nbsp;
			<a href="#delete" class="lightlink">Delete</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="add"><p class="subheadbold">Adding New Entries</p></a>
		<p>The <strong>Most Wanted</strong> feature allows you to make a list of critical people or photos you may be having trouble researching.
		The list is divided into two categories, <strong>Elusive People</strong> and <strong>Mystery Photos</strong>. To add a new entry to one of these
		categories, click on the "Add New" button under the appropriate heading, then fill out the form. Take note of the following:</p>

		<span class="optionhead">Title</span>
		<p>Give your entry a title, which may actually be a question. For example, <em>Who is this person?</em> or <em>Who is John Carlisle's father?</em></p>

		<span class="optionhead">Description</span>
		<p>Give your entry a short description as well. This could consist of any current evidence you've gathered, any brick walls you've run into,
		or some specific piece of information you're looking for.</p>

		<span class="optionhead">Tree</span>
		<p>If desired, you can associate this entry with a Tree (optional).</p>

		<span class="optionhead">Person</span>
		<p>If this entry is closely associated with a person, enter the Person ID or click on the magnifying glass icon to look it up. When you find the desired
		individual, click on the "Select" link to return to the Most Wanted form with the selected ID.</p>

		<span class="optionhead">Select Photo</span>
		<p>If this entry is closely associated with a photo, click on the "Select Photo" button to search for that photo from among the Photo records
		already in your database. When you find the desired Photo, click on the "Select" link to return to the Most Wanted form with the selected ID.</p>

		<p>When you are finished, click the "Save" button to return to the list. Your new entry will be added to the bottom of the category where you added it.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="edit"><p class="subheadbold">Editing Existing Entries</p></a>
		<p>To edit an existing entry, hold your mouse pointer over the entry to be edited. Links for "Edit" and "Delete" should appear for that entry. Click
		the "Edit" link to bring up the form where you can make your changes. All the fields are the same as the ones described above under "Adding New Entries".</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="sort"><p class="subheadbold">Sorting Entries</p></a>
		<p>To change the order of the Most Wanted entries you've created, just drag and drop them to the desired location (click on the "Drag" area, then hold the mouse down
		as you move your pointer to the desired location, then release the mouse button). </p>

		<p><strong>NOTE:</strong> You <strong>can</strong> drag and drop entries from one list to the other (e.g., drag an entry from "Elusive People" to "Mystery Photos").</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="delete"><p class="subheadbold">Deleting Existing Entries</p></a>
		<p>To delete an existing entry, hold your mouse pointer over the entry to be deleted. Links for "Edit" and "Delete" should appear for that entry. Click
		the "Delete" link to remove the entry (you will be asked to confirm your deletion before it is made final).</p>

	</td>
</tr>

</table>
</body>
</html>
