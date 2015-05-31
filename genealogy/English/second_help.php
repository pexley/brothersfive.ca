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
	<title>Help: Secondary Processes</title>
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
			<a href="data_help.php" class="lightlink">&laquo; Help: Import / Export</a> &nbsp; | &nbsp;
			<a href="setup_help.php" class="lightlink">Help: Setup &raquo;</a>
		</p>
		<span class="largeheader">Help: Secondary Processes</span>
		<p class="smaller menu">
			<a href="#what" class="lightlink">What are they?</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="what"><p class="subheadbold">What are Secondary Processes?</p></a>
		<p>Secondary Processes are operations you may want to perform on your data directly following an import. To perform one of these operations,
		you must first select whether it should apply to "All Trees" or
		only one tree in particular. If only one tree, select that tree here. Operations you can perform include:</p>
		
		<span class="optionhead">Track Lines</span>
		<p>Once you have imported your data, click here to trace through the selected tree and mark all individuals with children. This will allow visitors
		to your site to more easily find your primary lines of descent.</p>
		
		<span class="optionhead">Sort Children</span>
		<p>Click here to sort the children in each family of the selected tree according to birth date. This will supersede any previous sorting done in
		other parts of TNG or in your desktop application.</p>
		
		<span class="optionhead">Sort Spouses</span>
		<p>Click here to sort spouses for each person of the selected tree according to marriage date. This will supersede any previous sorting done in
		other parts of TNG or in your desktop application.</p>

		<span class="optionhead">Relabel Branches</span>
		<p>Re-importing your GEDCOM with the <span class="emphasis">Replace All Data</span> option will cause any previously existing branch labels to be
		removed. Click this button to restore those labels (IDs must match those from your previous data).</p>

		<span class="optionhead">Create GENDEX</span>
		<p>Click here to create an indexable file in GENDEX format. You determine the folder name (where the file will be stored) in the General Settings.
		If you selected "All Trees", this file will be named "gendex.txt". If you selected a tree, the name of your GENDEX file will be the TreeID (not the Tree Name),
		plus .txt for an extension. To have the file indexed by GENDEX, visit
		<a href="http://tngnetwork.lythgoes.net" target="_blank">http://tngnetwork.lythgoes.net</a> for further instructions.</p>

		<span class="optionhead">Post your GENDEX file on the TNG Network</span>
		<p>To have the file indexed by GENDEX, visit the <a href="http://tngnetwork.lythgoes.net" target="_blank">TNG Network</a> and click on "Register your site".
		You will be asked to create an account, after which you will be able to import your GENDEX file. Any time you want to update your listings on the TNG Network,
		you will need to recreate and re-import your GENDEX file.</p>
	</td>
</tr>
</table>
</body>
</html>
