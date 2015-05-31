<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

function getfiletime( $filename ) {
	global $fileflag;
	
	$filemodtime = "";
	if( $fileflag ) {
		$filemod = filemtime( $filename );
		$filemodtime = date("F j, Y h:i:s A", $filemod); 
	}
	return $filemodtime;
}

function getfilesize( $filename ) {
	global $fileflag;
	
	$filesize = "";
	if( $fileflag ) {
		$filesize = ceil( filesize( $filename )/1000 ) . " Kb";
	}
	return $filesize;
}

function doRow( $table_name, $display_name ) {
	global $admtext, $rootpath, $backuppath, $fileflag;
	
	echo "<tr>\n";
	echo "<td class=\"lightback\"><span class=\"normal\"><nobr><a href=\"#\" onclick=\"return startOptimize('$table_name');\"><img src=\"tng_optimize.gif\" title=\"$admtext[optimize]\" alt=\"$admtext[optimize]\"  $dims class=\"smallicon\"></a>";
	echo "<a href=\"#\" onclick=\"return startBackup('$table_name');\"><img src=\"tng_save.gif\" title=\"$admtext[backup]\" alt=\"$admtext[backup]\" $dims class=\"smallicon\"></a>";
	$fileflag = $table_name && file_exists("$rootpath$backuppath/$table_name.bak");
	echo "<a href=\"#\" onClick=\"if( confirm('$admtext[surerestore]') ) {startRestore('$table_name') ;} return false;\"><img src=\"tng_restore.gif\" id=\"rst_$table_name\"title=\"$admtext[restore]\" alt=\"$admtext[restore]\"  $dims class=\"smallicon\"";
	if(!$fileflag) echo " style=\"visibility:hidden\"";
	echo "></a>";
	echo "</nobr></span></td>";
	echo "<td class=\"lightback normal\" align=\"center\"><input type=\"checkbox\" class=\"tablechecks\" name=\"$table_name\" value=\"1\" style=\"margin: 0; padding: 0;\"></nobr></td>\n";
	echo "<td class=\"lightback normal\">$display_name &nbsp;</td>\n";
	echo "<td class=\"lightback normal\"><span id=\"time_$table_name\">" . getfiletime( "$rootpath$backuppath/$table_name.bak" ) . "</span>&nbsp;</td>\n";
	echo "<td class=\"lightback normal\" align=\"right\"><span id=\"size_$table_name\">" . getfilesize("$rootpath$backuppath/$table_name.bak") . "</span>&nbsp;</td>\n";
	echo "<td class=\"lightback normal\"><span id=\"msg_$table_name\"></span>&nbsp;</td>\n";
	echo "</tr>\n";
}

$helplang = findhelp("backuprestore_help.php");

if( !$sub ) $sub = "tables";
$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[backuprestore], $flags );
?>
<SCRIPT language="JavaScript" type="text/javascript">
function toggleAll(flag) {
	for( var i = 0; i < document.form1.elements.length; i++ ) {
		if( document.form1.elements[i].type == "checkbox" ) {
			if( flag )
				document.form1.elements[i].checked = true;
			else
				document.form1.elements[i].checked = false;
		}
	}
}

function startUtility(sel) {
	if(sel.selectedIndex < 1) return false;
	var checks = $$('.tablechecks');
	var totalchecked = 0;
	for(var i=0; i<checks.length; i++) {
		if(checks[i].checked) {
			totalchecked = 1;
			break;
		}
	}
	if(totalchecked) {
		var selval = sel.options[sel.selectedIndex].value;
		var form = document.form1;
		switch(selval) {
			case "backupall":
				form.action='backup.php';
				form.submit();
				break;
			case "optimizeall":
				form.action='optimize.php';
				form.submit();
				break;
			case "restoreall":
				if(confirm('<?php echo $admtext['surerestore']; ?>')) {
					form.action='restore.php';
					form.submit();
				}
				break;
			case "delete":
				if(confirm('<?php echo $admtext['suredelbk']; ?>')) {
					form.table.value='del';
					form.action='backup.php?table=del';
					form.submit();
				}
				break;
		}
	}
	else {
		alert('<?php echo $admtext['seltable']; ?>');
		sel.selectedIndex = 0;
	}
	return false;
}

function startBackup(table) {
	var params = $H({table:table}).toQueryString();
	$('msg_'+table).innerHTML = '<img src="../spinner.gif" width="16" height="16">';
	new Ajax.Request('backup.php',{parameters:params,onSuccess:finishBackup});
	return false;
}

function finishBackup(req) {
	var pairs = req.responseText.split('&');
	var table = pairs[0];
	var timestamp = pairs[1];
	var size = pairs[2];
	var message = pairs[3];
	$('msg_'+table).innerHTML = message;
	new Effect.Highlight('msg_'+table);
	$('time_'+table).innerHTML = timestamp;
	new Effect.Highlight('time_'+table);
	$('size_'+table).innerHTML = size;
	new Effect.Highlight('size_'+table);
	$('rst_'+table).style.visibility = 'visible';
}

function startOptimize(table) {
	var params = $H({table:table}).toQueryString();
	$('msg_'+table).innerHTML = '<img src="../spinner.gif" width="16" height="16">';
	new Ajax.Request('optimize.php',{parameters:params,onSuccess:finishOptimize});
	return false;
}

function finishOptimize(req) {
	var pairs = req.responseText.split('&');
	var table = pairs[0];
	var message = pairs[1];
	$('msg_'+table).innerHTML = message;
	new Effect.Highlight('msg_'+table);
}

function startRestore(table) {
	var params = $H({table:table}).toQueryString();
	$('msg_'+table).innerHTML = '<img src="../spinner.gif" width="16" height="16">';
	new Ajax.Request('restore.php',{parameters:params,onSuccess:finishRestore});
	return false;
}

function finishRestore(req) {
	var pairs = req.responseText.split('&');
	var table = pairs[0];
	var message = pairs[1];
	$('msg_'+table).innerHTML = message;
	new Effect.Highlight('msg_'+table);
}
</script>
</head>

<body background="../background.gif">

<?php
	$utiltabs[0] = array(1,"backuprestore.php?sub=tables",$admtext[backuprestoretables],"tables");
	$utiltabs[1] = array(1,"backuprestore.php?sub=structure",$admtext[backupstruct],"structure");
	$utiltabs[2] = array(1,"renumbermenu.php",$admtext['renumber'],"renumber");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/backuprestore_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($utiltabs,$sub,$innermenu);
	$headline = $sub == "tables" ? "$admtext[backuprestore] &gt;&gt; $admtext[backuprestoretables]" : "$admtext[backuprestore] &gt;&gt; $admtext[backupstruct]";
	echo displayHeadline($headline,"backuprestore_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
<?php
	if( $sub == "tables" ) {
?>
	<span class="normal"><i><?php echo $admtext['brinstructions']; ?></i></span><br/>

	<div class="normal">
	<form action="" name="form1" id="form1" onsubmit="return startUtility(document.form1.withsel);">
	<p>
	<input type="hidden" name="table" value="all">
	<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onclick="toggleAll(1);">
	<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onclick="toggleAll(0);">&nbsp;&nbsp;
	<?php echo $admtext['wsel']; ?>
	<select name="withsel">
		<option value=""></option>
		<option value="backupall"><?php echo $admtext['backup']; ?></option>
		<option value="optimizeall"><?php echo $admtext['optimize']; ?></option>
		<option value="restoreall"><?php echo $admtext['restore']; ?></option>
		<option value="delete"><?php echo $admtext['text_delete']; ?></option>
	</select>
	<input type="submit" name="go" value="<?php echo $admtext['go']; ?>">
	</p>

	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['table']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['lastbackup']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['backupfilesize']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname" style="width:200px"><nobr>&nbsp;<b><?php echo $admtext['msg']; ?></b>&nbsp;</nobr></td>
		</tr>
<?php
	doRow( $address_table, $admtext['addresstable'] );
	doRow( $albums_table, $admtext['albums'] );
	doRow( $album2entities_table, $admtext['album2entitiestable'] );
	doRow( $albumlinks_table, $admtext['albumlinkstable'] );
	doRow( $assoc_table, $admtext['associations'] );
	doRow( $branches_table, $admtext['branches'] );
	doRow( $branchlinks_table, $admtext['brlinkstable'] );
	doRow( $cemeteries_table, $admtext['cemeteries'] );
	doRow( $children_table, $admtext['children'] );
	doRow( $countries_table, $admtext['countriestable'] );
	doRow( $places_table, $admtext['places'] );
	doRow( $events_table, $admtext['events'] );
	doRow( $eventtypes_table, $admtext['eventtypes'] );
	doRow( $families_table, $admtext['families'] );
	doRow( $languages_table, $admtext['languages'] );
	doRow( $media_table, $admtext['mediatable'] );
	doRow( $medialinks_table, $admtext['medialinkstable'] );
	doRow( $mediatypes_table, $admtext['mediatypes'] );
	doRow( $mostwanted_table, $admtext['mostwanted'] );
	doRow( $notelinks_table, $admtext['notelinkstable'] );
	doRow( $xnotes_table, $admtext['notes'] );
	doRow( $people_table, $admtext['people'] );
	doRow( $reports_table, $admtext['reports'] );
	doRow( $sources_table, $admtext['sources'] );
	doRow( $repositories_table, $admtext['repositories'] );
	doRow( $citations_table, $admtext['citations'] );
	doRow( $saveimport_table, $admtext['saveimporttable'] );
	doRow( $states_table, $admtext['statestable'] );
	doRow( $temp_events_table, $admtext['temptable'] );
	doRow( $tlevents_table, $admtext['tleventstable'] );
	doRow( $trees_table, $admtext['trees'] );
	doRow( $users_table, $admtext['users'] );
?>
	</table>
	</form>
	<p>
	<img src="tng_optimize.gif" alt="<?php echo $admtext['optimize']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['optimize']; ?> &nbsp;&nbsp;
	<img src="tng_save.gif" alt="<?php echo $admtext['backup']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['backup']; ?> &nbsp;&nbsp;
	<img src="tng_restore.gif" alt="<?php echo $admtext['restore']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['restore']; ?>
	</p>

	</div>

<?php
	}
	elseif( $sub == "structure" ) {
?>
	<span class="normal"><i><?php echo $admtext['brinstructions2']; ?></i></span><br/><br/>

	<div class="normal">
	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['lastbackup']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['backupfilesize']; ?></b>&nbsp;</nobr></span></td>
		</tr>
		<tr>
			<td class="lightback"><span class="normal"><nobr><a href="backup.php?table=struct"><img src="tng_save.gif" title="<?php echo $admtext['backup']; ?>" alt="<?php echo $admtext[backup]; ?>" <?php echo $dims; ?> class="smallicon"></a>
<?php
	if( file_exists("$rootpath$backuppath/tng_tablestructure.bak") ) {
		$fileflag = 1;
?>
		<a href="restore.php?table=struct" onClick="return confirm('<?php echo $admtext['surerestorets']; ?>');"><img src="tng_restore.gif" title="<?php echo $admtext['restore']; ?>" alt="<?php echo $admtext[restore]; ?>" <?php echo $dims; ?> class="smallicon"></a>
<?php
	}
	else
		$fileflag = 0;
?>
				</nobr></span>
			</td>
<?php
	if( $fileflag ) {
		echo "<td class=\"lightback\"><span class=\"normal\"><nobr>&nbsp;" . getfiletime( "$rootpath$backuppath/tng_tablestructure.bak" ) . "&nbsp;</nobr></span></td>\n";
		echo "<td class=\"lightback\" align=\"right\"><span class=\"normal\"><nobr>&nbsp;" . getfilesize("$rootpath$backuppath/tng_tablestructure.bak") . "&nbsp;</nobr></span></td>\n";
	}
	else {
		echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;</span></td>\n";
		echo "<td class=\"lightback\" align=\"right\"><span class=\"normal\">&nbsp;</span></td>\n";
	}
?>
		</tr>
	</table>

	</div>
<?php
	}
?>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
