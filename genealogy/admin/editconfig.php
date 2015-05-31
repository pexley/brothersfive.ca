<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);

if( $link ) {
	include("checklogin.php");
	include("../version.php");

	if( $assignedtree || !$allow_edit ) {
		$message = $admtext[norights];
		header( "Location: login.php?message=" . urlencode($message) );
		exit;
	}

	$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
	$result = @mysql_query($query);
}
else
	$result = false;

if( !$rootpath ) {
	$rootpath = dirname(__FILE__);
	$rootpath = preg_replace( "/admin$/", "", $rootpath );
	if (eregi("WIN",PHP_OS)) {
	    $rootpath = str_replace("\\","/",$rootpath);
	}
}

if( !$tngconfig[maxdesc] ) $tngconfig[maxdesc] = $maxdesc;
$tngconfig['doctype'] = ereg_replace("\"", "&#34;",$tngconfig['doctype']);

$helplang = findhelp("config_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader( $admtext['modifysettings'], $flags );
?>
<script type="text/javascript">
function toggleAll(display) {
	toggleSection('db','plus0',display);
	toggleSection('tables','plus1',display);
	toggleSection('folders','plus2',display);
	toggleSection('site','plus3',display);
	toggleSection('media','plus4',display);
	toggleSection('lang','plus5',display);
	toggleSection('priv','plus6',display);
	toggleSection('names','plus7',display);
	toggleSection('cemeteries','plus8',display);
	toggleSection('misc','plus9',display);
	return false;
}

function flipTreeRestrict(requirelogin) {
	if(parseInt(requirelogin)) {
		document.getElementById('treerestrict').style.display = '';
		document.getElementById('trdisabled').style.display = 'none';
	}
	else {
		document.getElementById('treerestrict').style.display = 'none';
		document.getElementById('trdisabled').style.display = '';
	}
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$setuptabs[0] = array(1,"setup.php",$admtext['configuration'],"configuration");
	$setuptabs[1] = array(1,"diagnostics.php",$admtext['diagnostics'],"diagnostics");
	$setuptabs[2] = array(1,"setup.php?sub=tablecreation",$admtext['tablecreation'],"tablecreation");
	$setuptabs[3] = array(1,"#",$admtext['configsettings'],"gen");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/config_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$menu = doMenu($setuptabs,"gen",$innermenu);
	echo displayHeadline("$admtext[setup] &gt;&gt; $admtext[configuration] &gt;&gt; $admtext[configsettings]","setup_icon.gif",$menu,"");
?>

<form action="updateconfig.php" method="post" name="form1" style="margin:0px">

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus0",0,"db",$admtext['dbsection'],""); ?>

	<div id="db" style="display:none">
	<table border="0">
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td><span class="normal"><?php echo $admtext['dbhost']; ?>:</span></td><td><input type="text" value="<?php echo $database_host; ?>" name="new_database_host" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['dbname']; ?>:</span></td><td><input type="text" value="<?php echo $database_name; ?>" name="new_database_name" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['dbusername']; ?>:</span></td><td><input type="text" value="<?php echo $database_username; ?>" name="new_database_username" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['dbpassword']; ?>:</span></td><td><input type="text" value="<?php echo $database_password; ?>" name="new_database_password" size="20"></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['maintmode']; ?>:</span></td>
			<td><span class="normal">
				<select name="maint">
					<option value="0"<?php if( !$tngconfig['maint'] ) echo " selected=\"selected\""; ?>><?php echo $admtext[off]; ?></option>
					<option value="1"<?php if( $tngconfig['maint'] ) echo " selected=\"selected\""; ?>><?php echo $admtext[on]; ?></option>
				</select>
				</span>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus1",0,"tables",$admtext['tablesection'],""); ?>

	<div id="tables" style="display:none">
	<table border="0" cellspacing="0" cellpadding="0">
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td>
				<table>
					<tr><td><span class="normal"><?php echo $admtext['people']; ?>:</span></td><td><input type="text" value="<?php echo $people_table; ?>" name="people_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['families']; ?>:</span></td><td><input type="text" value="<?php echo $families_table; ?>" name="families_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['children']; ?>:</span></td><td><input type="text" value="<?php echo $children_table; ?>" name="children_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['albums']; ?>:</span></td><td><input type="text" value="<?php echo $albums_table; ?>" name="albums_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['album2entitiestable']; ?>:</span></td><td><input type="text" value="<?php echo $album2entities_table; ?>" name="album2entities_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['albumlinkstable']; ?>:</span></td><td><input type="text" value="<?php echo $albumlinks_table; ?>" name="albumlinks_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['media']; ?>:</span></td><td><input type="text" value="<?php echo $media_table; ?>" name="media_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['medialinkstable']; ?>:</span></td><td><input type="text" value="<?php echo $medialinks_table; ?>" name="medialinks_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['mediatypes']; ?>:</span></td><td><input type="text" value="<?php echo $mediatypes_table; ?>" name="mediatypes_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['addresstable']; ?>:</span></td><td><input type="text" value="<?php echo $address_table; ?>" name="address_table" size="20"></td></tr>
			 		<tr><td><span class="normal"><?php echo $admtext['languages']; ?>:</span></td><td><input type="text" value="<?php echo $languages_table; ?>" name="languages_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['places']; ?>:</span></td><td><input type="text" value="<?php echo $places_table; ?>" name="places_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['cemeteries']; ?>:</span></td><td><input type="text" value="<?php echo $cemeteries_table; ?>" name="cemeteries_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['statestable']; ?>:</span></td><td><input type="text" value="<?php echo $states_table; ?>" name="states_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['countriestable']; ?>:</span></td><td><input type="text" value="<?php echo $countries_table; ?>" name="countries_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['users']; ?>:</span></td><td><input type="text" value="<?php echo $users_table; ?>" name="users_table" size="20"></td></tr>
				</table>
			</td>
			<td>&nbsp;</td>
			<td>
				<table>
					<tr><td><span class="normal"><?php echo $admtext['sources']; ?>:</span></td><td><input type="text" value="<?php echo $sources_table; ?>" name="sources_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['citations']; ?>:</span></td><td><input type="text" value="<?php echo $citations_table; ?>" name="citations_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['repositories']; ?>:</span></td><td><input type="text" value="<?php echo $repositories_table; ?>" name="repositories_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['events']; ?>:</span></td><td><input type="text" value="<?php echo $events_table; ?>" name="events_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['eventtypes']; ?>:</span></td><td><input type="text" value="<?php echo $eventtypes_table; ?>" name="eventtypes_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['reports']; ?>:</span></td><td><input type="text" value="<?php echo $reports_table; ?>" name="reports_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['trees']; ?>:</span></td><td><input type="text" value="<?php echo $trees_table; ?>" name="trees_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['notes']; ?>:</span></td><td><input type="text" value="<?php echo $xnotes_table; ?>" name="xnotes_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['notelinkstable']; ?>:</span></td><td><input type="text" value="<?php echo $notelinks_table; ?>" name="notelinks_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['saveimporttable']; ?>:</span></td><td><input type="text" value="<?php echo $saveimport_table; ?>" name="saveimport_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['branches']; ?>:</span></td><td><input type="text" value="<?php echo $branches_table; ?>" name="branches_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['brlinkstable']; ?>:</span></td><td><input type="text" value="<?php echo $branchlinks_table; ?>" name="branchlinks_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['tleventstable']; ?>:</span></td><td><input type="text" value="<?php echo $tlevents_table; ?>" name="tlevents_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['temptable']; ?>:</span></td><td><input type="text" value="<?php echo $temp_events_table; ?>" name="temp_events_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['associations']; ?>:</span></td><td><input type="text" value="<?php echo $assoc_table; ?>" name="assoc_table" size="20"></td></tr>
					<tr><td><span class="normal"><?php echo $admtext['mostwanted']; ?>:</span></td><td><input type="text" value="<?php echo $mostwanted_table; ?>" name="mostwanted_table" size="20"></td></tr>
				</table>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus2",0,"folders",$admtext['foldersection'],""); ?>

	<div id="folders" style="display:none">
	<table class="normal">
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td style="white-space:nowrap"><?php echo $admtext['rootpath']; ?>:</td><td><input type="text" value="<?php echo $rootpath; ?>" name="newrootpath" class="verylongfield"></td></tr>
		<tr><td style="white-space:nowrap"><?php echo $admtext['subroot']; ?>*:</td><td><input type="text" value="<?php echo $tngconfig['subroot']; ?>" name="newsubroot" class="verylongfield"></td>
		<tr><td>&nbsp;</td><td>*<?php echo $admtext['srexpl']; ?></td>

		<tr><td style="white-space:nowrap"><?php echo $admtext['photopath']; ?>:</td><td><input type="text" value="<?php echo $photopath; ?>" name="photopath" class="verylongfield">
			<input type="button" value="<?php echo $admtext['makefolder']; ?>" onclick="makeFolder('photos',document.form1.photopath.value);"> <span id="msg_photos"></span></td></tr>
		<tr><td style="white-space:nowrap"><?php echo $admtext['documentpath']; ?>:</td><td><input type="text" value="<?php echo $documentpath; ?>" name="documentpath" class="verylongfield">
			<input type="button" value="<?php echo $admtext['makefolder']; ?>" onClick="makeFolder('documents',document.form1.documentpath.value);"> <span id="msg_documents"></span></td></tr>
		<tr><td style="white-space:nowrap"><?php echo $admtext['historypath']; ?>:</td><td><input type="text" value="<?php echo $historypath; ?>" name="historypath" class="verylongfield">
			<input type="button" value="<?php echo $admtext['makefolder']; ?>" onClick="makeFolder('histories',document.form1.historypath.value);"> <span id="msg_histories"></span></td></tr>
		<tr><td style="white-space:nowrap"><?php echo $admtext['headstonepath']; ?>:</td><td><input type="text" value="<?php echo $headstonepath; ?>" name="headstonepath" class="verylongfield">
			<input type="button" value="<?php echo $admtext['makefolder']; ?>" onClick="makeFolder('headstones',document.form1.headstonepath.value);"> <span id="msg_headstones"></span></td></tr>
		<tr><td style="white-space:nowrap"><?php echo $admtext['mediapath']; ?>:</td><td><input type="text" value="<?php echo $mediapath; ?>" name="mediapath" class="verylongfield">
			<input type="button" value="<?php echo $admtext['makefolder']; ?>" onClick="makeFolder('media',document.form1.mediapath.value);"> <span id="msg_media"></span></td></tr>
		<tr><td style="white-space:nowrap"><?php echo $admtext['gendex']; ?>:</td><td><input type="text" value="<?php echo $gendexfile; ?>" name="gendexfile" class="verylongfield">
			<input type="button" value="<?php echo $admtext['makefolder']; ?>" onClick="makeFolder('gendex',document.form1.gendexfile.value);"> <span id="msg_gendex"></span></td></tr>
		<tr><td style="white-space:nowrap"><?php echo $admtext['backuppath']; ?>:</td><td><input type="text" value="<?php echo $backuppath; ?>" name="backuppath" class="verylongfield">
			<input type="button" value="<?php echo $admtext['makefolder']; ?>" onClick="makeFolder('backups',document.form1.backuppath.value);"> <span id="msg_backups"></span></td></tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus3",0,"site",$admtext['sitesection'],""); ?>

	<div id="site" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td><span class="normal"><?php echo $admtext['homepage']; ?>:</span></td><td><input type="text" value="<?php echo $homepage; ?>" name="homepage" size="40"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['tngdomain']; ?>:</span></td><td><input type="text" value="<?php echo $tngdomain; ?>" name="tngdomain" size="40"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['sitename']; ?>:</span></td><td><input type="text" value="<?php echo $sitename; ?>" name="sitename" size="40"></td></tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['site_desc']; ?>:</span></td><td><textarea name="site_desc" rows="2" cols="60"><?php echo $site_desc; ?></textarea></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['doctype']; ?>:</span></td><td><input type="text" value="<?php echo $tngconfig['doctype']; ?>" name="doctype" size="70"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['emailaddress']; ?>:</span></td><td><input type="text" value="<?php echo $emailaddr; ?>" name="emailaddr" size="40"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['siteowner']; ?>:</span></td><td><input type="text" value="<?php echo $dbowner; ?>" name="dbowner" size="40"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['targetframe']; ?>:</span></td><td><input type="text" value="<?php echo $target; ?>" name="target" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['customheader']; ?>:</span></td><td><input type="text" value="<?php echo $customheader; ?>" name="customheader" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['customfooter']; ?>:</span></td><td><input type="text" value="<?php echo $customfooter; ?>" name="customfooter" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['custommeta']; ?>:</span></td><td><input type="text" value="<?php echo $custommeta; ?>" name="custommeta" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['tabstyle']; ?>:</span></td><td><input type="text" value="<?php echo $tngconfig['tabs']; ?>" name="tng_tabs" size="20"></td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['iconloc']; ?>:</span></td>
			<td>
				<select name="tng_menu">
					<option value="0"<?php if( !$tngconfig['menu'] ) echo " selected"; ?>><?php echo $admtext['topright']; ?></option>
					<option value="1"<?php if( $tngconfig['menu'] == 1 ) echo " selected"; ?>><?php echo $admtext['topleft']; ?></option>
					<option value="2"<?php if( $tngconfig['menu'] == 2 ) echo " selected"; ?>><?php echo $admtext['nodisplay']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['showhome']; ?>:</span></td>
			<td>
				<select name="showhome">
					<option value="0"<?php if( !$tngconfig['showhome'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['showhome'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['showsearch']; ?>:</span></td>
			<td>
				<select name="showsearch">
					<option value="0"<?php if( !$tngconfig['showsearch'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['showsearch'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['showlogin']; ?>:</span></td>
			<td>
				<select name="showlogin">
					<option value="0"<?php if( !$tngconfig['showlogin'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['showlogin'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['showprint']; ?>:</span></td>
			<td>
				<select name="showprint">
					<option value="0"<?php if( !$tngconfig['showprint'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['showprint'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['showbmarks']; ?>:</span></td>
			<td>
				<select name="showbmarks">
					<option value="0"<?php if( !$tngconfig['showbmarks'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['showbmarks'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['hidechr']; ?>:</span></td>
			<td>
				<select name="hidechr">
					<option value="0"<?php if( !$tngconfig['hidechr'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['hidechr'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td><span class="normal"><?php echo $admtext['defaulttree']; ?>:</span></td><td>
			<select name="defaulttree">
				<option value=""></option>
<?php
if( $link && $result ) {
	while( $row = mysql_fetch_assoc($result) ) {
		echo "	<option value=\"$row[gedcom]\"";
		if( $defaulttree == $row['gedcom'] ) echo " selected";
		echo ">$row[treename]</option>\n";
	}
}
else
	echo "	<option value=\"$defaulttree\" selected>$defaulttree</option>\n";
?>
			</select> 
		</td></tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus4",0,"media",$admtext['media'],""); ?>

	<div id="media" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['photosext']; ?>:</span></td>
			<td>
				<select name="photosext">
					<option value="jpg"<?php if( $photosext == "jpg" ) echo " selected"; ?>>.jpg</option>
					<option value="gif"<?php if( $photosext == "gif" ) echo " selected"; ?>>.gif</option>
					<option value="png"<?php if( $photosext == "png" ) echo " selected"; ?>>.png</option>
					<option value="bmp"<?php if( $photosext == "bmp" ) echo " selected"; ?>>.bmp</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['showextended']; ?>:</span></td>
			<td>
				<select name="showextended">
					<option value="1"<?php if( $showextended ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$showextended ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td><span class="normal"><?php echo $admtext['imgmaxh']; ?>:</span></td><td><input type="text" value="<?php echo $tngconfig['imgmaxh']; ?>" name="imgmaxh" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['imgmaxw']; ?>:</span></td><td><input type="text" value="<?php echo $tngconfig['imgmaxw']; ?>" name="imgmaxw" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['thumbprefix']; ?>:</span></td><td><input type="text" value="<?php echo $thumbprefix; ?>" name="thumbprefix" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['thumbsuffix']; ?>:</span></td><td><input type="text" value="<?php echo $thumbsuffix; ?>" name="thumbsuffix" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['thumbmaxh']; ?>:</span></td><td><input type="text" value="<?php echo $thumbmaxh; ?>" name="thumbmaxh" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['thumbmaxw']; ?>:</span></td><td><input type="text" value="<?php echo $thumbmaxw; ?>" name="thumbmaxw" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['thumbcols']; ?>:</span></td><td><input type="text" value="<?php echo $tngconfig['thumbcols']; ?>" name="tng_thumbcols" size="20"></td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['ssenabled']; ?>:</span></td>
			<td>
				<select name="tng_ssdisabled">
					<option value="0"<?php if( !$tngconfig['ssdisabled'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['ssdisabled'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['ssrepeat']; ?>:</span></td>
			<td>
				<select name="tng_ssrepeat">
					<option value="1"<?php if( $tngconfig['ssrepeat'] ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$tngconfig['ssrepeat'] ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus5",0,"lang",$admtext['language'],""); ?>

	<div id="lang" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td><span class="normal"><?php echo $admtext['language']; ?>:</span></td><td><input type="text" value="<?php echo $language; ?>" name="language" size="20"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['charset']; ?>:</span></td><td><input type="text" value="<?php echo $charset; ?>" name="charset" size="20"></td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['chooselang']; ?>:</span></td>
			<td>
				<select name="chooselang">
					<option value="1"<?php if( $chooselang ) echo " selected"; ?>><?php echo $admtext['allow']; ?></option>
					<option value="0"<?php if( !$chooselang ) echo " selected"; ?>><?php echo $admtext['disallow']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus6",0,"priv",$admtext['privsection'],""); ?>

	<div id="priv" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['requirelogin']; ?>:</span></td>
			<td>
				<select name="requirelogin" onchange="flipTreeRestrict(this.options[this.selectedIndex].value);">
					<option value="1"<?php if( $requirelogin ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="0"<?php if( !$requirelogin ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['treerestrict']; ?>: &nbsp;&nbsp;</span></td>
			<td><span id="trdisabled" class="normal"<?php if( $requirelogin ) echo " style=\"display:none\""; ?>><?php echo $admtext['reqloginset']; ?></span>
				<select name="treerestrict" id="treerestrict"<?php if( !$requirelogin ) echo " style=\"display:none\""; ?>>
					<option value="0"<?php if( !$treerestrict ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $treerestrict ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['ldsdefault']; ?>:</span></td>
			<td>
				<select name="ldsdefault">
					<option value="0"<?php if( !$ldsdefault ) echo " selected"; ?>><?php echo $admtext['ldson']; ?></option>
					<option value="1"<?php if( $ldsdefault == 1 ) echo " selected"; ?>><?php echo $admtext['ldsoff']; ?></option>
					<option value="2"<?php if( $ldsdefault == 2 ) echo " selected"; ?>><?php echo $admtext['ldspermit']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['livedefault']; ?>:</span></td>
			<td>
				<select name="livedefault">
					<option value="2"<?php if( $livedefault == 2 ) echo " selected"; ?>><?php echo $admtext['ldson']; ?></option>
					<option value="1"<?php if( $livedefault == 1 ) echo " selected"; ?>><?php echo $admtext['ldsoff']; ?></option>
					<option value="0"<?php if( !$livedefault ) echo " selected"; ?>><?php echo $admtext['ldspermit']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['shownames']; ?>:</span></td>
			<td>
				<select name="nonames">
					<option value="0"<?php if( !$nonames ) echo " selected"; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $nonames == 1 ) echo " selected"; ?>><?php echo $admtext['no']; ?></option>
					<option value="2"<?php if( $nonames == 2 ) echo " selected"; ?>><?php echo $admtext['initials']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus7",0,"names",$admtext['namesection'],""); ?>

	<div id="names" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['nameorder']; ?>:</span></td>
			<td>
				<select name="nameorder">
					<option value=""></option>
					<option value="1"<?php if( $nameorder == 1 ) echo " selected"; ?>><?php echo $admtext['western']; ?></option>
					<option value="2"<?php if( $nameorder == 2 ) echo " selected"; ?>><?php echo $admtext['oriental']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['lnprefixes']; ?>:</span></td>
			<td>
				<select name="lnprefixes">
					<option value="0"<?php if( !$lnprefixes ) echo " selected"; ?>><?php echo $admtext['lntogether']; ?></option>
					<option value="1"<?php if( $lnprefixes ) echo " selected"; ?>><?php echo $admtext['lnapart']; ?></option>
				</select>
			</td>
		</tr>
		<tr><td colspan="2"><span class="normal"><?php echo $admtext['detectpfx']; ?>:</span></td></tr>
		<tr>
			<td><span class="normal">&nbsp;&nbsp;<?php echo $admtext['lnpfxnum']; ?>:</span></td>
			<td><span class="normal"><input type="text" value="<?php echo $lnpfxnum; ?>" name="lnpfxnum" size="5"></span></td>
		</tr>
		<tr>
			<td><span class="normal">&nbsp;&nbsp;<?php echo $admtext['specpfx']; ?>*:</span></td>
			<td><span class="normal"><input type="text" value="<?php echo stripslashes($specpfx); ?>" name="specpfx" size="50"> </span></td>
		</tr>
		<tr><td colspan="2"><span class="normal">*<?php echo $admtext['commas']; ?></span></td></tr>
	</table>
	</div>

</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus8",0,"cemeteries",$admtext['cemeteries'],""); ?>

	<div id="cemeteries" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td><span class="normal"><?php echo $admtext['cemrows']; ?>:</span></td><td colspan="4"><input type="text" value="<?php echo $tngconfig['cemrows']; ?>" name="cemrows" size="5"></td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['cemblanks']; ?>:</span></td>
			<td>
				<select name="cemblanks">
					<option value="0"<?php if( !$tngconfig['cemblanks'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
					<option value="1"<?php if( $tngconfig['cemblanks'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>
</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<?php echo displayToggle("plus9",0,"misc",$admtext['miscsection'],""); ?>

	<div id="misc" style="display:none">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td><span class="normal"><?php echo $admtext['maxsearchresults']; ?>:</span></td><td colspan="4"><input type="text" value="<?php echo $maxsearchresults; ?>" name="maxsearchresults" size="5"></td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['indstart']; ?>:</span></td>
			<td colspan="4">
				<select name="tng_istart">
					<option value="0"<?php if( !$tngconfig['istart'] ) echo " selected"; ?>><?php echo $admtext['allinfo']; ?></option>
					<option value="1"<?php if( $tngconfig['istart'] ) echo " selected"; ?>><?php echo $admtext['persinfo']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['shownotes']; ?>:</span></td>
			<td colspan="4">
				<select name="notestogether">
					<option value="0"<?php if( !$notestogether ) echo " selected"; ?>><?php echo $admtext['notesapart']; ?></option>
					<option value="1"<?php if( $notestogether ) echo " selected"; ?>><?php echo $admtext['notestogether']; ?></option>
				</select>
			</td>
		</tr>

		<tr><td><span class="normal"><?php echo $admtext['time_offset']; ?>:</span></td><td colspan="4"><input type="text" value="<?php echo $time_offset; ?>" name="time_offset" size="5"> <span class="normal"> <?php echo $admtext['servertime'] . " <strong>" . date("D h:i a") . "</strong> "; $new_U=date("U")+$time_offset*3600; echo $admtext['sitetime'] . " <strong>" . date("D h:i a", $new_U) . "</strong>"; ?></span></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['maxgedcom']; ?>:</span></td><td colspan="4"><input type="text" value="<?php echo $maxgedcom; ?>" name="maxgedcom" size="5"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['change_cutoff']; ?>:</span></td><td colspan="4"><input type="text" value="<?php echo $change_cutoff; ?>" name="change_cutoff" size="5"></td></tr>
		<tr><td><span class="normal"><?php echo $admtext['change_limit']; ?>:</span></td><td colspan="4"><input type="text" value="<?php echo $change_limit; ?>" name="change_limit" size="5"></td></tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['datefmt']; ?>:</span></td>
			<td colspan="4">
				<select name="prefereuro">
					<option value="false"<?php if( $tngconfig['preferEuro'] == "false" ) echo " selected"; ?>><?php echo $admtext['monthfirst']; ?></option>
					<option value="true"<?php if( $tngconfig['preferEuro'] == "true" ) echo " selected"; ?>><?php echo $admtext['dayfirst']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['allowreg']; ?>:</span></td>
			<td>
				<select name="disallowreg">
					<option value="0"<?php if( !$tngconfig['disallowreg'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['yes']; ?></option>
					<option value="1"<?php if( $tngconfig['disallowreg'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['no']; ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext['pardata']; ?>:</span></td>
			<td>
				<select name="pardata">
					<option value="0"<?php if( !$tngconfig['pardata'] ) echo " selected=\"selected\""; ?>><?php echo $admtext['palldata']; ?></option>
					<option value="1"<?php if( $tngconfig['pardata'] == 1 ) echo " selected=\"selected\""; ?>><?php echo $admtext['pstdonly']; ?></option>
					<option value="2"<?php if( $tngconfig['pardata'] == 2 ) echo " selected=\"selected\""; ?>><?php echo $admtext['pnoevents']; ?></option>
				</select>
			</td>
		</tr>
	</table>
	</div>
</td>
</tr>

<tr class="databack tngshadow">
<td class="tngshadow">
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>">

	<input type="hidden" name="cmssupport" value="<?php echo $cms['support']; ?>">
	<input type="hidden" name="cmsurl" value="<?php echo $cms['url']; ?>">
	<input type="hidden" name="cmstngpath" value="<?php echo $cms['tngpath']; ?>">
	<input type="hidden" name="cmsmodule" value="<?php echo $cms['module']; ?>">
	<input type="hidden" name="cmscloaklogin" value="<?php echo $cms['cloaklogin']; ?>">
	<input type="hidden" name="cmscredits" value="<?php echo $cms['credits']; ?>">
	<input type="hidden" name="adminurl" value="<?php echo $cms['adminurl']; ?>">

	<input type="hidden" value="1" name="safety">
	<input type="hidden" value="<?php echo $photos_table; ?>" name="photos_table">
	<input type="hidden" value="<?php echo $histories_table; ?>" name="histories_table">
	<input type="hidden" value="<?php echo $headstones_table; ?>" name="headstones_table">
	<input type="hidden" value="<?php echo $photolinks_table; ?>" name="photolinks_table">
	<input type="hidden" value="<?php echo $doclinks_table; ?>" name="doclinks_table">
	<input type="hidden" value="<?php echo $hslinks_table; ?>" name="hslinks_table">
</td>
</tr>

</table>
</form>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
