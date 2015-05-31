<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "people";
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

if( $assignedtree )
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
else
	$wherestr = "";
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$helplang = findhelp("people_help.php");

$revstar = checkReview("I");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader( $admtext['addnewperson'], $flags );
include_once("eventlib.php");
?>
<script type="text/javascript">
var persfamID = "";
var allow_cites = false;
var allow_notes = false;

function toggleAll(display) {
	toggleSection('names','plus0',display);
	toggleSection('events','plus1',display);
	return false;
}

<?php
if( !$assignedtree && !$assignedbranch )
	include("branchlibjs.php");
else {
	$query = "SELECT description FROM $branches_table WHERE gedcom = \"$assignedtree\" AND branch = \"$assignedbranch\" ORDER BY description";
	$branchresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$branch = mysql_fetch_assoc( $branchresult );
	$dispname = $branch[description];
	$swapbranches = "";	
}
?>

function validateForm( ) {
	var rval = true;

	document.form1.personID.value = TrimString( document.form1.personID.value );
	if( document.form1.personID.value.length == 0 ) {
		alert("<?php echo $admtext['enterpersonid']; ?>");
		rval = false;
	}
	return rval;
}
</script>
<script language="JavaScript" src="admin.js"></script>
</head>

<body background="../background.gif" onload="generateID('person',document.form1.personID);">

<?php
	$peopletabs[0] = array(1,"people.php",$admtext['search'],"findperson");
	$peopletabs[1] = array($allow_add,"newperson.php",$admtext[addnew],"addperson");
	$peopletabs[2] = array($allow_edit,"findreview.php?type=I",$admtext[review] . $revstar,"review");
	$peopletabs[3] = array($allow_edit && $allow_delete,"merge.php",$admtext[merge],"merge");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/people_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$menu = doMenu($peopletabs,"addperson",$innermenu);
	echo displayHeadline("$admtext[people] &gt;&gt; $admtext[addnewperson]","people_icon.gif",$menu,$message);
?>

<form action="addperson.php" method="post" style="margin:0px" name="form1" onSubmit="return validateForm();">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table class="normal">
	<tr><td valign="top" colspan="2"><span class="normal"><strong><?php echo $admtext['prefixpersonid']; ?></strong></span></td></tr>
	<tr>
		<td><span class="normal"><?php echo $admtext['tree']; ?>:</span></td>
		<td>
			<select name="tree1" onChange="<?php echo $swapbranches; ?> generateID('person',document.form1.personID);">
<?php
$firsttree = $assignedtree;
while( $row = mysql_fetch_assoc($result) ) {
	if(!$firsttree) $firsttree = $row[gedcom];
	echo "		<option value=\"$row[gedcom]\">$row[treename]</option>\n";
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
		<td><span class="normal"><?php echo $admtext[personid]; ?>:</span></td>
		<td>
			<input type="text" name="personID" size="10" onBlur="this.value=this.value.toUpperCase()">
			<input type="button" value="<?php echo $admtext['generate']; ?>" onClick="generateID('person',document.form1.personID);">
			<input type="submit" name="submit" value="<?php echo $admtext['lockid']; ?>" onClick="document.form1.newfamily[2].checked = true;">
			<input type="button" value="<?php echo $admtext['check']; ?>" onClick="checkID(document.form1.personID.value,'person','checkmsg');">
			<span id="checkmsg" class="normal"></span>
		</td>
	</tr>
</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus0",1,"names",$admtext['name'],""); ?>

	<div id="names">
	<table class="normal" style="margin-top:8px">
		<tr>
			<td><?php echo $admtext['firstgivennames']; ?></td>
<?php
	if( $lnprefixes )
		echo "<td>$admtext[lnprefix]</td>\n";
?>
			<td><?php echo $admtext['lastsurname']; ?></td>
		</tr>
		<tr>
			<td><input type="text" name="firstname" size="30"></td>
<?php
	if( $lnprefixes )
		echo "<td><input type=\"text\" name=\"lnprefix\" style=\"width:80px\"></td>\n";
?>
			<td><input type="text" name="lastname" size="30"></td>
		</tr>
	</table>
	<table class="normal" style="margin-top:8px">
		<tr>
			<td><?php echo $admtext['sex']; ?></td>
			<td><?php echo $admtext['nickname']; ?></td>
			<td><?php echo $admtext['title']; ?></td>
			<td><?php echo $admtext['prefix']; ?></td>
			<td><?php echo $admtext['suffix']; ?></td>
			<td><?php echo $admtext['nameorder']; ?></td>
		</tr>
		<tr>
			<td>
				<select name="sex">
					<option value="U"><?php echo $admtext['unknown']; ?></option>
					<option value="M"><?php echo $admtext['male']; ?></option>
					<option value="F"><?php echo $admtext['female']; ?></option>
				</select>
			</td>
			<td><input type="text" name="nickname" class="veryshortfield"></td>
			<td><input type="text" name="title" class="veryshortfield"></td>
			<td><input type="text" name="prefix" class="veryshortfield"></td>
			<td><input type="text" name="suffix" class="veryshortfield"></td>
			<td>
				<select name="pnameorder">
					<option value="0"><?php echo $admtext['default']; ?></option>
					<option value="1"><?php echo $admtext['western']; ?></option>
					<option value="2"><?php echo $admtext['oriental']; ?></option>
				</select>
			</td>
		</tr>
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
	echo showEventRow('birthdate','birthplace','BIRT');
	if(!$tngconfig['hidechr'])
		echo showEventRow('altbirthdate','altbirthplace','CHR');
	echo showEventRow('deathdate','deathplace','DEAT');
	echo showEventRow('burialdate','burialplace','BURI');
	if( $allow_lds ) {
		echo showEventRow('baptdate','baptplace','BAPL');
		echo showEventRow('endldate','endlplace','ENDL');
	}
?>
	</table>
	</div>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<p class="normal"><strong><?php echo $admtext['pevslater']; ?></strong></p>
	<input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
<?php
	if( !$lnprefixes )
		echo "<input type=\"hidden\" name=\"lnprefix\" value=\"\">";
?>
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
