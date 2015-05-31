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
	<title>Help: Notes Pages</title>
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
			<a href="assoc_help.php" class="lightlink">&laquo; Help: Associations</a> &nbsp; | &nbsp;
			<a href="citations_help.php" class="lightlink">Help: Citations &raquo;</a>
		</p>
		<span class="largeheader">Help: Notes</span>
		<p class="smaller menu">
			<a href="#add" class="lightlink">Add/Edit/Delete</a> &nbsp; | &nbsp;
			<a href="#cite" class="lightlink">Citations</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="add"><p class="subheadbold">Adding/Editing/Deleting Notes</p></a>

		<p>To add, edit or delete notes for a person, family, source, repository or event, click on the Notes icon at the top of the screen or next to any event (if notes already exist,
		a green dot will be present on the icon). When the icon is clicked, a small popup will appear showing
		all notes existing for the active entity or event.</p>

		<p>To add a new note, click on the "Add New" button and fill out the form. </p>

		<p>To edit or delete an existing note, click on the appropriate icon next to that note.</p>

		<p>While adding or editing a note, please take note of the following:</p>

		<span class="optionhead">Note</span>
		<p>Enter your note or make your changes in the large <strong>Note</strong> field and click the "Save" button. Notes are saved at that point, even if other
		information for the active entity is not. You may enter HTML code in the field. PHP and Javascript code will not work.</p>

		<span class="optionhead">Private</span>
		<p>Check this box to prevent the note from being displayed in the public area.</p>


	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="cite"><p class="subheadbold">Adding Source Citations for Notes</p></a>
		<p>To add or edit source citations for a note, first save the note, then click the Citations icon next to that note record in the current list of notes
		For more information on citations, please see <a href="citations_help.php">Help: Citations</a>.</p>

	</td>
</tr>

</table>
</body>
</html>
