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
	<title>Help: Citations</title>
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
			<a href="notes_help.php" class="lightlink">&laquo; Help: Notes</a> &nbsp; | &nbsp;
			<a href="events_help.php" class="lightlink">Help: Events &raquo;</a>
		</p>
		<span class="largeheader">Help: Citations</span>
		<p class="smaller menu">
			<a href="#what" class="lightlink">What are they?</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Add/Edit/Delete</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="what"><p class="subheadbold">What are Citations?</p></a>

		<p>A <strong>Citation</strong> is a reference to a Source record, made with the intent of proving the veracity of some piece of information. The Source usually
		describes in general where the information was found (e.g., a book or a census), while the Citation usually contains more specific information (e.g., on which page).
		The same Source record can be cited multiple times for different people, families, notes and events.</p>


	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="add"><p class="subheadbold">Adding/Editing/Deleting Citations</p></a>

		<p>To add, edit or delete citations, click on the Citations icon at the top of the screen or next to any note or event (if citations already exist,
		a green dot will be present on the icon). When the icon is clicked, a small popup will appear showing
		all citations existing for the active entity or event.</p>

		<p>To add a new citation, click on the "Add New" button and fill out the form. </p>

		<p>To edit or delete an existing note, click on the appropriate icon next to that note.</p>

		<p>While adding or editing a note, please take note of the following:</p>

		<span class="optionhead">Source</span>
		<p>Select an existing source to be cited. If the source you wanted to cite does not appear in the dropdown, either it has not yet been created or it
		exists only in a different tree. First go to Admin/Sources and create the source in the proper tree, then return to the citations list and select the source.</p>
		
        <!--<span class="optionhead">Description</span>
		<p>If your desktop genealogy program does not assign ID numbers to your sources, your citation will have a Description instead. You will not see
		the Description field for a new citation.</p>-->

		<span class="optionhead">Page</span>
		<p>Enter the page of the selected source relevant to this event (optional).</p>
		
		<span class="optionhead">Reliability</span>
		<p>Select a number (0-3) indicating how reliable the source is (optional). Higher numbers indicate greater reliability.</p>
		
		<span class="optionhead">Citation Date</span>
		<p>The date associated with this citation (optional).</p>
		
		<span class="optionhead">Actual Text</span>
		<p>An short excerpt of the source material (optional).</p>

		<span class="optionhead">Notes</span>
		<p>Any helpful comments you may have concerning this source (optional).</p>

	</td>
</tr>

</table>
</body>
</html>
