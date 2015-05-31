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
			<a href="citations_help.php" class="lightlink">&laquo; Help: Citations</a> &nbsp; | &nbsp;
			<a href="more_help.php" class="lightlink">Help: More &raquo;</a>
		</p>
		<span class="largeheader">Help: Events</span>
		<p class="smaller menu">
			<a href="#what" class="lightlink">Standard vs. Custom</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Add New</a> &nbsp; | &nbsp;
			<a href="#edit" class="lightlink">Edit Existing</a> &nbsp; | &nbsp;
			<a href="#del" class="lightlink">Delete</a> &nbsp; | &nbsp;
			<a href="#citations" class="lightlink">Citations</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="what"><p class="subheadbold">Standard vs. Custom Events</p></a>
		The more common events, such as Birth, Death, Marriage and a few others, are entered on the main People, Families, Sources and Repositories pages
		and are stored in their respective database tables.	TNG documentation refers to those events as "Standard" events. All other events are called "Custom" events
		and are managed in the <strong>Other Events</strong> sections of the People, Families, Sources and Repositories pages. Those events are stored in a separate
		Events table. This Help topic refers to the management of those <em>Custom</em> events.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="add"><p class="subheadbold">Adding Events</p></a>

		<p>To add a new event, click on the "Add New" button in the Other Events section, then fill out the form. When events already exist, they will
		be displayed in a table in the Other Events section. For an explanation on the available fields, see the next section below.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="edit"><p class="subheadbold">Editing Events</p></a>

		<p>To edit an existing event, click on the Edit icon next to that event in the Other Events section (to edit the data for a "standard" event
		like Birth or Death, simply change the text).</p>

		<p>While adding or editing a note, please take note of the following:</p>

		<span class="optionhead">Event Type</span>
		<p>Select the type of event (you cannot change the event type for an existing event). If the Event Type you want is not in the Event Type selection box,
		first go to Admin/Custom Event Types and set up that Event Type, then return to this screen to select it.</p>

        <span class="optionhead">Event Date</span>
		<p>The actual or approximated date associated with the event.</p>

        <span class="optionhead">Event Place</span>
		<p>The place where the event occurred. Enter the place name or click the Find icon (the magnifying glass) to locate the event as you entered it previously.</p>

        <span class="optionhead">Detail</span>
		<p>Any additional explanation of the event, if necessary. If no date or place is associated with the event, the Detail field should contain some defining information.</p>

        <span class="optionhead">More</span><br />
		<p>More less commonly used information can be added for each event by clicking on the "More" heading or the arrow next to it. Doing so will cause these fields
		to appear. The fields can be hidden by again clicking on the heading or arrow. Hiding the fields does not remove any information entered there. Those fields include:</p>

        <p><span class="optionhead">Age</span>: The age of the individual at the time of the event.</p>

        <p><span class="optionhead">Agency</span>: The institution or individual having authority and/or responsibility at the time of the event.</p>

        <p><span class="optionhead">Cause</span>: The cause of the event (most often used with Death).</p>

        <p><span class="optionhead">Address 1/Address 2/City/State/Province/Zip/Postal Code/Country/Phone/E-mail/Web Site</span>: The address and other contact information associated with the event.</p>

        <span class="optionhead">Required fields:</span>
		<p>You must choose an Event Type, and you must enter something in at least one of the following fields: <strong>Event Date</strong>, <strong>Event Place</strong>,
		or <strong>Detail</strong>. All other information is optional.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="del"><p class="subheadbold">Deleting Events</p></a>

		<p>To edit an existing event, click on the Edit icon next to that event in the Other Events section (to edit the data for a "standard" event
		like Birth or Death, simply change the text). The event will be deleted, regardless of whether the surrounding page is saved.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="citations"><p class="subheadbold">Citations</p>
		To add or edit source citations for an event, first save the event, then click the Citations icon next to that event record in the current list of events
		For more information on citations, please see <a href="citations_help.php">Help: Citations</a>.</p>

	</td>
</tr>

</table>
</body>
</html>
