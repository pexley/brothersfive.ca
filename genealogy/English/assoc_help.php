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
	<title>Help: Associations</title>
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
			<a href="repositories_help.php" class="lightlink">&laquo; Help: Repositories</a> &nbsp; | &nbsp;
			<a href="notes_help.php" class="lightlink">Help: Notes &raquo;</a>
		</p>
		<span class="largeheader">Help: Associations</span>
		<p class="smaller menu">
			<a href="#what" class="lightlink">What are they?</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Add/Edit/Delete</a>
		</p>
	</td>
</tr>

<tr class="databack">
	<td class="tngshadow">
		<a name="what"><p class="subheadbold">What are Associations?</p></a>

		<p>An <strong>Association</strong> is a record of a relationship between two people in your database
		that may not be obvious from the regular tree structure of your genealogy. In fact, two people who
		are linked in an Association may not be related at all.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="add"><p class="subheadbold">Adding/Editing/Deleting Associations</p></a>

		<p>To add, edit or delete associations for an individual, look up person in Admin/People and edit
		the individual record, then click on the Associations icon at the top of the screen (if associations already exist,
		a green dot will be present on the icon). When the icon is clicked, a small popup will appear showing
		all associations existing for the active individual.</p>

		<p>To add a new association, click on the "Add New" button and fill out the form. </p>

		<p>To edit or delete an existing association, click on the appropriate icon next to that association.</p>

		<p>While adding or editing an association, take note of the following:</p>

		<span class="optionhead">Person ID</span>
		<p>Enter the ID of the person to be associated with the active individual, or click the Find icon to search for the ID.</p>

		<span class="optionhead">Relationship</span>
		<p>Enter the nature of the association between the two individuals. For example, <em>Godfather</em>, <em>Mentor</em> or <em>Witness</em>.</p>

		<p>When you are done adding, editing or deleting associations for this individual, click the "Finish" button to close the window.</p>

	</td>
</tr>

</table>
</body>
</html>
