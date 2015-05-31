<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "families";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

if( $child )
	$newperson = $child;
else if( $husband )
	$newperson = $husband;
else if( $wife )
	$newperson = $wife;
else
	$newperson = "";
	
if( $newperson ) {
	$query = "SELECT personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, branch FROM $people_table WHERE personID = \"$newperson\" AND gedcom = \"$tree\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$newpersonrow = mysql_fetch_assoc( $result );
	mysql_free_result($result);
}
	
if( $husband )
	$husbstr = getName( $newpersonrow ) . " - $husband";
else if( $wife )
	$wifestr = getName( $newpersonrow ) . " - $wife";
if(!isset($husbstr)) $husbstr = $admtext['clickfind'];
if(!isset($wifestr)) $wifestr = $admtext['clickfind'];

if( $assignedtree )
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
else
	$wherestr = "";
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$helplang = findhelp("families_help.php");

$revstar = checkReview("F");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader( $admtext['addnewfamily'], $flags );
include_once("eventlib.php");
?>
<SCRIPT language="JavaScript" type="text/javascript">
var persfamID = "";
var allow_cites = false;
var allow_notes = false;

function toggleAll(display) {
	toggleSection('spouses','plus0',display);
	toggleSection('events','plus1',display);
	return false;
}

<?php
if( !$assignedtree && !$assignedbranch )
	include("branchlibjs.php");
else
	$swapbranches = "";	
?>
function validateFamily(form) {
	var rval = true;

	form.familyID.value = TrimString( form.familyID.value );
	if( form.familyID.value.length == 0 ) {
		alert("<?php echo $admtext[enterfamilyid]; ?>");
		return false;
	}
	return true;
}

function EditSpouse(field) {
	var tree=getTree();
	if( field.value.length )
		window.open('editperson.php?personID=' + field.value + '&tree=' + tree + '&cw=1','editspouse');
}

function RemoveSpouse( spouse, spousedisplay ) {
	spouse.value = "";
	spousedisplay.value = "<?php echo $admtext['clickfind']; ?>";
}

var nplitbox;
var activeidbox = null;
var activenamebox = null;
function openCreatePersonForm(idfield,namefield,type,gender) {
	activeidbox = idfield;
	activenamebox = namefield;
	nplitbox = new LITBox('newperson2.php?tree=' + document.form1.tree1.options[document.form1.tree1.selectedIndex].value + '&type='+type + '&familyID=' + persfamID + '&gender=' + gender,{width:620,height:550});
	generateID('person',document.npform.personID);
	$('firstname').focus();
	return false;
}

function saveNewPerson(form) {
	form.personID.value = TrimString( form.personID.value );
	var personID = form.personID.value;
	if( personID.length == 0 ) {
		alert("<?php echo $admtext['enterpersonid']; ?>");
	}
	else {
		var params = Form.serialize(form);
		new Ajax.Request('addperson2.php',{parameters:params,
			onSuccess:function(req){
				nplitbox.remove();
				var vars = eval('('+req.responseText+')');
				$(activenamebox).value = vars.name + ' - ' + vars.id;
				new Effect.Highlight(activenamebox,{duration:.4});
				$(activeidbox).value = vars.id;
			}
		});
	}
	return false
}
</script>
<script language="JavaScript" src="admin.js"></script>
</head>

<body background="../background.gif" onload="generateID('family',document.form1.familyID);">

<?php
	$familytabs[0] = array(1,"families.php",$admtext['search'],"findfamily");
	$familytabs[1] = array($allow_add,"newfamily.php",$admtext[addnew],"addfamily");
	$familytabs[2] = array($allow_edit,"findreview.php?type=F",$admtext[review] . $revstar,"review");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/families_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$menu = doMenu($familytabs,"addfamily",$innermenu);
	echo displayHeadline("$admtext[families] &gt;&gt; $admtext[addnewfamily]","families_icon.gif",$menu,$message);
?>

<form action="addfamily.php" method="post" name="form1" onSubmit="return validateFamily(this);" style="margin:0px">
<input type="hidden" name="link_personID" value="<?php echo $child; ?>">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table class="normal">
	<tr><td valign="top" colspan="2"><span class="normal"><strong><?php echo $admtext['prefixfamilyid']; ?></strong></span></td></tr>
	<tr>
		<td><span class="normal"><?php echo $admtext['tree']; ?>:</span></td>
		<td>
			<select name="tree1" onChange="<?php echo $swapbranches; ?> generateID('family',document.form1.familyID);">
<?php
while( $row = mysql_fetch_assoc($result) ) {
	echo "		<option value=\"$row[gedcom]\"";
	if( $tree == $row[gedcom] ) echo " selected";
	echo ">$row[treename]</option>\n";
}
?>
			</select> 
		</td>
	</tr>
	<tr>
		<td><span class="normal"><?php echo $admtext['branch']; ?>:</span></td>
		<td style="height:2em">
<?php
	$query = "SELECT branch, description FROM $branches_table WHERE gedcom = \"$firsttree\" ORDER BY description";
	$branchresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$numbranches = mysql_num_rows($branchresult);
	$branchlist = explode(",", $row[branch] );

	$descriptions = array();
	$options = "";
	while( $branchrow = mysql_fetch_assoc($branchresult) ) {
		$options .= "	<option value=\"$branchrow[branch]\">$branchrow[description]</option>\n";
	}
	echo "<span id=\"branchlist\"></span>";
	if( !$assignedbranch ) {
		if($numbranches > 8)
			$select = "$admtext[scrollbranch]<br/>";
		$select .= "<select name=\"branch[]\" id=\"branch\" multiple size=\"8\">\n";
		$select .= "	<option value=\"\"";
		if( $row[branch] == "" ) $select .= " selected";
		$select .= ">$admtext[nobranch]</option>\n";

		$select .= "$options</select>\n";
		echo " &nbsp;<span style=\"white-space:nowrap\">(<a href=\"#\" onclick=\"showBranchEdit('branchedit'); quitBranchEdit('branchedit'); return false;\"><img src=\"../ArrowDown.gif\" border=\"0\" style=\"margin-left:-4px;margin-right:-2px\">" . $admtext['edit'] . "</a> )</span><br />";
?>
		<div id="branchedit" class="lightback" style="position:absolute;display:none;padding:5px;" onmouseover="clearTimeout(branchtimer);" onmouseout="closeBranchEdit('branch','branchedit','branchlist');">
<?php
		echo $select;
		echo "</div>\n";
	}
	else
		echo "<input type=\"hidden\" name=\"branch\" value=\"$assignedbranch\">";
?>
		</td>
	</tr>
	<tr>
		<td><span class="normal"><?php echo $admtext['familyid']; ?>:</span></td>
		<td>
			<input type="text" name="familyID" value="<?php echo $newID; ?>" size="10" onBlur="this.value=this.value.toUpperCase()"> 
			<input type="button" value="<?php echo $admtext['generate']; ?>" onClick="generateID('family',document.form1.familyID);">
			<input type="button" name="lock" value="<?php echo $admtext['lockid']; ?>" onClick="document.form1.newfamily[0].checked = true; if( gatherChildren() ) {document.form1.submit();}">
			<input type="button" value="<?php echo $admtext['check']; ?>" onClick="checkID(document.form1.familyID.value,'family','checkmsg');">
			<span id="checkmsg" class="normal"></span>
		</td>
	</tr>
</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus0",1,"spouses",$admtext['spouses'],""); ?>

	<div id="spouses">
	<table class="normal" style="margin-top:8px">
	<tr><td><span class="normal"><?php echo $admtext['husband']; ?>:</span></td><td><input type="text" readonly="readonly" name="husbnameplusid" id="husbnameplusid" size="40" value="<?php echo "$husbstr"; ?>">
		<input type="hidden" name="husband" id="husband" value="<?php echo $husband; ?>">
		<input type="button" value="<?php echo $admtext['find']; ?>" onclick="return openFindPersonForm('husband','husbnameplusid','text',document.form1.tree1.options[document.form1.tree1.selectedIndex].value);">
		<input type="button" value="<?php echo $admtext['create']; ?>" onclick="return openCreatePersonForm('husband','husbnameplusid','spouse','M');">
		<input type="button" value="  <?php echo $admtext['edit']; ?>  " onclick="EditSpouse(document.form1.husband);">
		<input type="button" value="<?php echo $admtext['remove']; ?>" onclick="RemoveSpouse(document.form1.husband,document.form1.husbnameplusid);">
	</td></tr>
	<tr><td><span class="normal"><?php echo $admtext['wife']; ?>:</span></td><td><input type="text" readonly readonly="readonly" name="wifenameplusid" id="wifenameplusid" size="40" value="<?php echo "$wifestr"; ?>">
		<input type="hidden" name="wife" id="wife" value="<?php echo $wife; ?>">
		<input type="button" value="<?php echo $admtext['find']; ?>" onclick="return openFindPersonForm('wife','wifenameplusid','text',document.form1.tree1.options[document.form1.tree1.selectedIndex].value);">
		<input type="button" value="<?php echo $admtext['create']; ?>" onclick="return openCreatePersonForm('wife','wifenameplusid','spouse','F');">
		<input type="button" value="  <?php echo $admtext['edit']; ?>  " onclick="EditSpouse(document.form1.wife);">
		<input type="button" value="<?php echo $admtext['remove']; ?>" onclick="RemoveSpouse(document.form1.wife,document.form1.wifenameplusid);">
	</td></tr>
	</table>

	<table class="normal" style="margin-top:12px">
		<tr>
			<td><input type="checkbox" name="living" value="1" checked="checked"> <?php echo $admtext['living']; ?></td>
		</tr>
	</table>
	</div>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus1",1,"events",$admtext['events'],""); ?>

	<div id="events">
	<p class="normal" style="margin-top:8px"><?php echo $admtext['datenote']; ?></p>
	<table class="normal">
		<tr><td>&nbsp;</td><td><?php echo $admtext['date']; ?></td><td><?php echo $admtext['place']; ?></td><td colspan="4">&nbsp;</td></tr>
<?php
	echo showEventRow('marrdate','marrplace','MARR');
?>
		<tr>
			<td><?php echo $admtext['marriagetype']; ?>:</td>
			<td colspan="6"><input type="text" value="" name="marrtype" style="width:494px" maxlength="50"></td>
		</tr>
<?php
	if( $allow_lds )
		echo showEventRow('sealdate','sealplace','SLGS');
	echo showEventRow('divdate','divplace','DIV');
?>
	</table>

	</div>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<p class="normal"><strong><?php echo $admtext['fevslater']; ?></strong></p>
	<input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
	<input type="submit" name="save" accesskey="s" value="<?php echo $admtext['savecont']; ?>">
</td>
</tr>

</table>
</form>

<SCRIPT language="JavaScript" type="text/javascript">
<?php
	echo $swapbranches;
?>
</script>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>