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
	<title>Help: Languages Page</title>
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
			<a href="mostwanted_help.php" class="lightlink">&laquo; Help: Most Wanted</a> &nbsp; | &nbsp;
			<a href="backuprestore_help.php" class="lightlink">Help: Utilities &raquo;</a>
		</p>
		<span class="largeheader">Help: Languages</span>
		<p class="smaller menu">
			<a href="#search" class="lightlink">Search</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Add or Edit</a> &nbsp; | &nbsp;
			<a href="#delete" class="lightlink">Delete</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="search"><p class="subheadbold">Search</p></a>
        <p>Locate existing Languages by searching for all or part of the <strong>Display Name</strong> or <strong>Folder Name</strong>.
		Searching with no value in the search box will find all Languages in your database.</p>

		<p>Your search criteria for this page will be remembered until you click the <strong>Reset</strong> button, which restores all default values and searches again.</p>

		<span class="optionhead">Actions</span>
		<p>The Action buttons next to each language allow you to edit or delete that language.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="add"><p class="subheadbold">Add New / Edit Existing Languages</p></a>
		<p>The TNG display messages have been translated into several different languages. To allow visitors to your site to view the site in any language besides
		your default language, you must create language records here for each language you support, <strong>including</strong> your default language. For example,
		if your default language is English and you want to support French as well, you must create language records in Admin/Languages for both English and French.
		For each language you support, you must also create a separate folder on your site (see more details below).</p>

		<p>To add a new Language, click on the <strong>Add New</strong> tab, then fill out the form.
		Take note of the following:</p>

		<span class="optionhead">Name for this language as it will be displayed for visitors</span>
		<p>Enter the name of the language as it will be shown to visitors in the languages options box. It is recommended that you enter this name in the language it
		represents so that visitors can more easily identify it. For example, use "Norsk" instead of "Norwegian".</p>

		<span class="optionhead">Folder where language files will be stored</span>
		<p>The physical folder where the text messages for this language will reside. This folder must be located under your main TNG folder. You must create
		this folder. Be sure to match the case exactly. For example, "Norsk" does not match "norsk".</p>

		<span class="optionhead">Character set</span>
		<p>The character set used for this language. If left blank, ISO-8859-1 will be used.</p>

		<span class="optionhead">Required fields:</span> You must enter a language display name, as well as the name of the folder where the text and help files for this language will be stored.</p>

		<p><strong>IMPORTANT:</strong> If you plan to allow dynamic language switching, <strong>you must set up your default language</strong> (from Setup/General Settings) as a language on this page.
		If you do not, you will not be able to switch back to your default language after switching to another one.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Top</a></p>
		<a name="delete"><p class="subheadbold">Deleting Languages</p></a>
		<p>To delete a Language, use the <a href="#search">Search</a> tab to locate the Language, then click on the Delete icon next to that Language record. The row will
		change color and then vanish as the Language is deleted. <strong>Note</strong>: The associated folder on your site will not be deleted.</p>

	</td>
</tr>

</table>
</body>
</html>
