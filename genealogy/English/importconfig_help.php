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
	<title>Help: Import Settings</title>
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
			<a href="logconfig_help.php" class="lightlink">&laquo; Help: Log Settings</a> &nbsp; | &nbsp;
			<a href="mapconfig_help.php" class="lightlink">Help: Map Settings &raquo;</a>
		</p>
		<span class="largeheader">Help: Import Settings</span>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">
		<span class="optionhead">GEDCOM Folder (Import/Export</span>
		<p>The name of the folder from which TNG will import GEDCOM files, and the location where TNG will store exported GEDCOM files.</p>

		<span class="optionhead">Save Import State</span>
		<p>If your data import or export fails to complete for any reason, select this option and rerun the import/export. If it fails again, click on the link to resume and the import/export will continue where it left
		off. For imports, this option only works if your GEDCOM file is already in your GEDCOM folder (it does not work with files uploaded and imported directly from the Data Import screen).</p>

		<span class="optionhead">If Change Date is blank</span>
		<p>If your individual, family or source records do not have an associated Change Date to indicate when they were
		last modified, TNG will assign a value based on this option. Choose to use today's date instead, or to leave
		the field blank. If left blank, the field will not overwrite an existing Change Date.</p>

		<span class="optionhead">If no birth date, assume</span>
		<p>TNG flags all incoming individual records as living or not. If the individual has no death or burial date or place,
		this flag is set based on the time elapsed from the person's birth. If no birth date exists for this person,
		TNG can interpret that in different ways. Choose to have such people flagged as deceased or living.</p>

		<span class="optionhead">If no death date, assume deceased if older than</span>
		<p>If no death or burial date or place exists for an individual, the living flag is calculated from the time
		elapsed from the individual's birth date. Individuals younger than the age indicated here are considered living.
		By default, the maximum age to be considered living is 110 years.</p>

		<span class="optionhead">Embedded Media</span>
		<p>If you check the box for "Allow TNG to assign names to embedded media", TNG will ignore the path and file names associated with your embedded media and will
		assign a new file name based on the convention tree ID + media ID + media extension. The file will then be placed in the Photos folder (as defined in the General Settings).
		You might want to select this option if you have imported embedded media in the past, since TNG used this convention by default prior to version 3.4.0. If you have TNG-assigned
		names for previously imported media and now import the name media without selecting this option, you will have duplicate files.</p>

		<span class="optionhead">Local Photo Path(s)</span>
		<p>Enter the base path or paths (separate multiple entries with commas) where photos are located on your home computer. It should correspond to the TNG Photos folder
		on your web site. In other words, if the photos on your computer are located in "C:\MyGenealogy\MyPhotos", that is what you should enter here. If some of your photo links
		refer to that location in relative terms (ie, just "MyPhotos"), include the relative path as a multiple entry. If some of your photos
		reside in subfolders of this location and you want to preserve that structure on your web site, do not include the subfolders in this path. If you want all photos to go
		into the same location (the TNG Photos folder), leave this field blank and check "Import file name only" for the last option on this page.</p>

		<span class="optionhead">Local History Path(s)</span>
		<p>Enter the base path or paths (separate multiple entries with commas) where histories are located on your home computer. It should correspond to the TNG Histories folder
		on your web site. In other words, if the histories on your computer are located in "C:\MyGenealogy\MyHistories", that is what you should enter here. If some of your history links
		refer to that location in relative terms (ie, just "MyHistories"), include the relative path as a multiple entry. If some of your histories
		reside in subfolders of this location and you want to preserve that structure on your web site, do not include the subfolders in this path. If you want all histories to go
		into the same location (the TNG Histories folder), leave this field blank and check "Import file name only" for the last option on this page.</p>

		<span class="optionhead">Local Documents Path(s)</span>
		<p>Enter the base path or paths (separate multiple entries with commas) where documents are located on your home computer. It should correspond to the TNG Documents folder
		on your web site. In other words, if the documents on your computer are located in "C:\MyGenealogy\MyDocuments", that is what you should enter here. If some of your document links
		refer to that location in relative terms (ie, just "MyDocuments"), include the relative path as a multiple entry. If some of your documents
		reside in subfolders of this location and you want to preserve that structure on your web site, do not include the subfolders in this path. If you want all histories to go
		into the same location (the TNG Documents folder), leave this field blank and check "Import file name only" for the last option on this page.</p>

		<span class="optionhead">Local Path(s) for Other Media</span>
		<p>Enter the base path or paths (separate multiple entries with commas) where other media (ie, videos or recordings) are located on your home computer. It should correspond to the TNG Multimedia folder
		on your web site. In other words, if the videos or recordings on your computer are located in "C:\MyGenealogy\MyMultimedia", that is what you should enter here. If some of your multimedia links
		refer to that location in relative terms (ie, just "MyMultimedia"), include the relative path as a multiple entry. If some of your videos or recordings
		reside in subfolders of this location and you want to preserve that structure on your web site, do not include the subfolders in this path. If you want all videos/recordings to go
		into the same location (the TNG Multimedia folder), leave this field blank and check "Import file name only" for the last option on this page.</p>

		<span class="optionhead">If no local path match</span>
		<p>If a photo or history is imported and the file path does not originate from one of the local paths indicated above, TNG can either import the entire path "as is" (recommended if
		all your paths are relative and you want your local folder structure to match your TNG photo/history folder structure), or it can strip the path information import the file name only
		(recommended if you do not intend to put your media in subfolders of the TNG Photos or TNG Histories folders).</p>

		<span class="optionhead">Prefix for private notes</span>
		<p>If you would like some of your notes to be labeled as "private" on import and not be displayed in the public areas, TNG can do that if all
		notes fitting that description start with the same character. Characters commonly used for this purpose are the tilde (~) or the exclamation
		point (!). Enter the character you are using for that purpose here prior to importing your GEDCOM file, and the "private" labels will
		automatically be attached.</p>

	</td>
</tr>

</table>
</body>
</html>
