<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "branches";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( !$allow_edit || $assignedbranch ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc($result);
mysql_free_result( $result );

$query = "SELECT description FROM $branches_table WHERE gedcom = \"$tree\" and branch = \"$branch\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$brow = mysql_fetch_assoc($result);
mysql_free_result( $result );

$query = "SELECT count(persfamID) as pcount FROM $branchlinks_table WHERE gedcom = \"$tree\" AND branch = \"$branch\"";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$prow = mysql_fetch_assoc($result);
$pcount = $prow[pcount];
mysql_free_result($result);

$helplang = findhelp("branches_help.php");

$flags[tabs] = $tngconfig['tabs'];
tng_adminheader( $admtext['labelbranches'], $flags );
?>
<script type="text/javascript" src="selectutils.js"></script>
<script type="text/javascript">
var tree = "<?php echo $tree; ?>";
function toggleClear(option) {
	new Effect.Fade("overwrite1",{duration:.3});
	new Effect.Fade("overwrite2",{duration:.3});
	new Effect.Appear("allpart",{duration:.3});
	$('labelsub').value = option ? '<?php echo $admtext['text_delete']; ?>' : '<?php echo $admtext['clearlabels']; ?>';
	$('form1').onsubmit = option ? confirmDelete : null;
}

function toggleAdd() {
	new Effect.Appear("overwrite1",{duration:.3});
	new Effect.Appear("overwrite2",{duration:.3});
	new Effect.Fade("allpart",{duration:.3});
	document.form1.set[1].checked = true;
	$('labelsub').value = '<?php echo $admtext['addlabels']; ?>';
	$('form1').onsubmit=null;
	togglePartial();
}

function confirmDelete() {
	return confirm('<?php echo $admtext['confbrdel']; ?>');
}

function toggleAll() {
	new Effect.Fade("startind1",{duration:.3});
	new Effect.Fade("startind2",{duration:.3});
	new Effect.Fade("startind3",{duration:.3});
	new Effect.Fade("numgens1",{duration:.3});
	new Effect.Fade("numgens2",{duration:.3});
	new Effect.Fade("numgens3",{duration:.3});
	new Effect.Fade("numgens4",{duration:.3});
	new Effect.Fade("numgens5",{duration:.3});
}

function togglePartial() {
	new Effect.Appear("startind1",{duration:.3});
	new Effect.Appear("startind2",{duration:.3});
	new Effect.Appear("startind3",{duration:.3});
	new Effect.Appear("numgens1",{duration:.3});
	new Effect.Appear("numgens2",{duration:.3});
	new Effect.Appear("numgens3",{duration:.3});
	new Effect.Appear("numgens4",{duration:.3});
	new Effect.Appear("numgens5",{duration:.3});
}

function validateForm() {
	var rval = true;
	
	if( document.form1.set[1].checked ) {
		if( document.form1.personID.value.length == 0 ) {
			alert("<?php echo $admtext['enterstartingind']; ?>");
			rval = false;
		}
		else if( isNaN( document.form1.agens.value ) || isNaN( document.form1.dgens.value ) ) {
			alert("<?php echo $admtext['gensnumeric']; ?>");
			rval = false;
		}
	}
	return rval;
}
</script>
</head>

<body background="../background.gif">

<?php
	$branchtabs[0] = array(1,"branches.php",$admtext['search'],"findbranch");
	$branchtabs[1] = array($allow_add,"newbranch.php",$admtext['addnew'],"addbranch");
	$branchtabs[2] = array($allow_edit,"#",$admtext['labelbranches'],"label");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/branches_help.php#labelbranch', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($branchtabs,"label",$innermenu);
	echo displayHeadline("$admtext[branches] &gt;&gt; $admtext[labelbranches]","branches_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="branchlabels.php" method="post" style="margin:0px" id="form1" name="form1" onSubmit="return validateForm();">
	<table border="0" cellpadding="1" class="normal">
		<tr>
			<td><strong><?php echo $admtext['tree']; ?>:</strong></td>
			<td><?php echo $row['treename']; ?><input type="hidden" name="tree" value="<?php echo $tree; ?>"></td>
		</tr>
		<tr>
			<td valign="top"><strong><?php echo $admtext['branch']; ?>:</strong></td>
			<td valign="top"><?php echo "$brow[description]<br />($admtext[people] + $admtext[families] = $pcount*)"; ?><input type="hidden" name="branch" value="<?php echo $branch; ?>"></td>
		</tr>
		<tr><td colspan="2"><br/><strong><?php echo $admtext['action']; ?>:</strong></td></tr>
		<tr>
			<td colspan="2">
				&nbsp;&nbsp;<input type="radio" name="branchaction" value="add" checked onClick="toggleAdd();"> <?php echo $admtext['addlabels']; ?>
				&nbsp;&nbsp;<input type="radio" name="branchaction" value="clear" onClick="toggleClear(0);"> <?php echo $admtext['clearlabels']; ?>
				&nbsp;&nbsp;<input type="radio" name="branchaction" value="delete" onClick="toggleClear(1);"> <?php echo $admtext['delpeople']; ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div id="allpart" style="display:none">
				&nbsp;&nbsp;<input type="radio" name="set" value="all" onClick="toggleAll();"> <?php echo $admtext['all']; ?>
				&nbsp;&nbsp;<input type="radio" name="set" value="partial" checked onClick="togglePartial();"> <?php echo $admtext['partial']; ?>
				</div>
			</td>
		</tr>
		<tr><td colspan="2"><div id="startind1"><br/><strong><?php echo $admtext['startingind']; ?>:</strong></div></td></tr>
		<tr>
			<td><div id="startind2">&nbsp;&nbsp;<?php echo $admtext['personid']; ?>: </div></td>
			<td><table id="startind3" class="normal"><tr><td><input type="text" name="personID" id="personID" size="10"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;</td>
				<td><a href="#" onclick="return openFindPersonForm('personID','','text');"><img src="tng_find.gif" style="vertical-align:middle" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>" <?php echo $dims; ?> class="smallicon"></a></td>
			</tr></table></td>
		</tr>
		<tr>
			<td colspan="2"><div id="numgens1"><br/><strong><?php echo $admtext['numgenerations']; ?>:</strong></div></td>
		</tr>
		<tr>
			<td><div id="numgens2">&nbsp;&nbsp;<?php echo $admtext['ancestors']; ?>: </div></td>
			<td><div id="numgens3"><input type="text" name="agens" size="3" maxlength="3" value="0"> &nbsp;&nbsp; <?php echo $admtext['descofanc']; ?>:
				<select name="dagens">
					<option value="0">0</option>
					<option value="1" selected="selected">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				</div></td>
		</tr>
		<tr>
			<td><div id="numgens4">&nbsp;&nbsp;<?php echo $admtext['descendants']; ?>: </div></td>
			<td><div id="numgens5"><input type="text" name="dgens" size="3" maxlength="3" value="0"> &nbsp;&nbsp; 
				<input type="checkbox" name="dospouses" checked="checked"> <?php echo $admtext['inclspouses']; ?></div></td>
		</tr>
		<tr>
			<td><div id="overwrite1"><br/><strong><?php echo $admtext['existlabels']; ?>:</strong></div></td>
			<td>
				<div id="overwrite2"><br/>
				<select name="overwrite">
					<option value="2" selected="selected"><?php echo $admtext['append']; ?></option>
					<option value="1"><?php echo $admtext['overwrite']; ?></option>
					<option value="0"><?php echo $admtext['leave']; ?></option>
				</select>
				</div>
			</td>
		</tr>
	</table>
	<br/><input type="submit" id="labelsub" value="<?php echo $admtext['addlabels']; ?>"> <input type="button" value="<?php echo $admtext['showpeople']; ?>" onclick="window.location.href='showbranch.php?tree=<?php echo $tree; ?>&branch=<?php echo $branch; ?>';">
	</form>
	<p class="normal">*<?php echo $admtext['branchdiscl']; ?></p>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
