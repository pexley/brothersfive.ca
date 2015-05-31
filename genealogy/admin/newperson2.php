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

$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc( $result );
mysql_free_result($result);

if( $father ) {
	$query = "SELECT lnprefix, lastname, branch FROM $people_table WHERE gedcom=\"$tree\" AND personID=\"$father\"";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	mysql_free_result( $result );
}
else
	$row[lastname] = $row[lnprefix] = "";

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="newperson">
<span class="subhead"><strong><?php echo $admtext['addnewperson']; ?></strong></span><br/>

<form action="" method="post" name="npform" onsubmit="return saveNewPerson(this);" style="margin-top:10px">
<table border="0" cellpadding="2" class="normal">
	<tr><td valign="top" colspan="2"><strong><?php echo $admtext['prefixpersonid']; ?></strong></td></tr>
	<tr>
		<td><span class="normal"><?php echo $admtext[personid]; ?>:</span></td>
		<td>
			<input type="text" name="personID" size="10" onBlur="this.value=this.value.toUpperCase()">
			<input type="button" value="<?php echo $admtext['generate']; ?>" onClick="generateID('person',document.npform.personID);">
			<input type="button" value="<?php echo $admtext['check']; ?>" onClick="checkID(document.npform.personID.value,'person','checkmsg');">
			<span id="checkmsg" class="normal"></span>
		</td>
	</tr>
</table>
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
		<td><input type="text" name="firstname" id="firstname" size="30"></td>
<?php
	if( $lnprefixes )
		echo "<td><input type=\"text\" name=\"lnprefix\" style=\"width:80px\" value=\"" . $row['lnprefix'] . "\"></td>\n";
?>
		<td><input type="text" name="lastname" size="30" value="<?php echo $row['lastname']; ?>"></td>
	</tr>
</table>
<table class="normal" style="margin-top:8px">
	<tr>
		<td><?php echo $admtext['sex']; ?></td>
		<td><?php echo $admtext['nickname']; ?></td>
		<td><?php echo $admtext['title']; ?></td>
		<td><?php echo $admtext['prefix']; ?></td>
		<td><?php echo $admtext['suffix']; ?></td>
	</tr>
	<tr>
		<td>
			<select name="sex">
				<option value="U"><?php echo $admtext['unknown']; ?></option>
				<option value="M"<?php if($gender == 'M') echo " selected"; ?>><?php echo $admtext['male']; ?></option>
				<option value="F"<?php if($gender == 'F') echo " selected"; ?>><?php echo $admtext['female']; ?></option>
			</select>
		</td>
		<td><input type="text" name="nickname" class="veryshortfield"></td>
		<td><input type="text" name="title" class="veryshortfield"></td>
		<td><input type="text" name="prefix" class="veryshortfield"></td>
		<td><input type="text" name="suffix" class="veryshortfield"></td>
	</tr>
</table>

<table class="normal" style="margin-top:12px">
	<tr>
		<td><input type="checkbox" name="living" value="1"<?php if( $row['living'] ) echo " checked"; ?>> <?php echo $admtext['living']; ?></td>
		<td style="padding-left:20px;padding-top:5px"><?php echo $admtext['tree'] . ": " . $treerow['treename']; ?></td>
		<td style="padding-left:20px;padding-top:5px"><?php echo $admtext['branch'] . ": "; ?>
<?php
	$query = "SELECT branch, description FROM $branches_table WHERE gedcom = \"$tree\" ORDER BY description";
	$branchresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$numbranches = mysql_num_rows($branchresult);
	$branchlist = explode(",", $row[branch] );

	$descriptions = array();
	$options = "";
	while( $branchrow = mysql_fetch_assoc($branchresult) ) {
		$options .= "	<option value=\"$branchrow[branch]\">$branchrow[description]</option>\n";
	}
	echo "<span id=\"branchlist2\"></span>";
	if( !$assignedbranch ) {
		if($numbranches > 8)
			$select = "$admtext[scrollbranch]<br/>";
		$select .= "<select name=\"branch[]\" id=\"branch2\" multiple size=\"8\">\n";
		$select .= "	<option value=\"\"";
		if( $row[branch] == "" ) $select .= " selected";
		$select .= ">$admtext[nobranch]</option>\n";

		$select .= "$options</select>\n";
		echo " &nbsp;<span style=\"white-space:nowrap\">(<a href=\"#\" onclick=\"showBranchEdit('branchedit2'); quitBranchEdit('branchedit2'); return false;\"><img src=\"../ArrowDown.gif\" border=\"0\" style=\"margin-left:-4px;margin-right:-2px\">" . $admtext['edit'] . "</a> )</span><br />";
?>
		<div id="branchedit2" class="lightback" style="position:absolute;display:none;padding:5px;" onmouseover="clearTimeout(branchtimer);" onmouseout="closeBranchEdit('branch2','branchedit2','branchlist2');">
<?php
		echo $select;
		echo "</div>\n";
	}
	else
		echo "<input type=\"hidden\" name=\"branch\" value=\"$assignedbranch\">";
?>
		</td>
	</tr>
</table>

<p class="normal" style="margin-top:8px;margin-bottom:8px"><?php echo $admtext['datenote']; ?></p>
<table class="normal">
	<tr><td>&nbsp;</td><td><?php echo $admtext['date']; ?></td><td><?php echo $admtext['place']; ?></td><td colspan="4">&nbsp;</td></tr>
<?php
	$noclass = true;
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

<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<input type="hidden" name="familyID" value="<?php echo $familyID; ?>">
<?php if( $type == "" ) $type = "text"; ?>
<input type="hidden" name="type" value="<?php echo $type; ?>">
<?php 
	if( !$lnprefixes ) echo "<input type=\"hidden\" name=\"lnprefix\" value=\"\">";
?>
<p class="normal" style="margin-top:15px;margin-left:4px"><input type="submit" name="submit" value="<?php echo $admtext['save']; ?>"> &nbsp; <strong><?php echo $admtext['pevslater2']; ?></strong></p>
</form>
