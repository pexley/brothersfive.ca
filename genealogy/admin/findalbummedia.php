<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( $assignedtree ) {
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
	$tree = $assignedtree;
}
else
	$wherestr = "";
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
initMediaTypes();
header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="finddiv">
	<span class="subhead"><strong><?php echo $admtext['addmedia']; ?></strong><br/>
	<form name="find2" style="margin:0px" onsubmit="getNewMedia(this,1); return false;">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext['mediatype']; ?>: </span></td>
			<td><span class="normal"><?php echo $admtext['tree']; ?>: </span></td>
			<td colspan="2"><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
		</tr>
		<tr>
			<td>
				<select name="mediatypeID" onChange="toggleHeadstoneCriteria(document.find2,this.options[this.selectedIndex].value); getNewMedia(document.find2,0);">
					<option value=""><?php echo $admtext['all']; ?></option>
<?php
	foreach( $mediatypes as $mediatype ) {
		$msgID = $mediatype[ID];
		echo "	<option value=\"$msgID\">" . $mediatype['display'] . "</option>\n";
	}
?>
				</select>
			</td>
			<td>
				<select name="searchtree" onchange="getNewMedia(document.find2,0)">
<?php
  		if( !$assignedtree )
  			echo "	<option value=\"\">$admtext[alltrees]</option>\n";
  		$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
  		while( $treerow = mysql_fetch_assoc($treeresult) ) {
   			echo "	<option value=\"$treerow[gedcom]\"";
   			if( $treerow[gedcom] == $tree ) echo " selected";
   			echo ">$treerow[treename]</option>\n";
   		}
		mysql_free_result($treeresult);
?>
				</select>
			</td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>" id="searchstring">
			</td>
			<td>
				<input type="submit" name="searchbutton" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<span id="spinner1" style="display:none"><img src="../spinner.gif" width="18" height="18" /></span>
			</td>
		</tr>
	</table>
	<table>
		<tr id="hsstatrow" style="display:none">
			<td><span class="normal"><?php echo $admtext['status']; ?>: </span></td>
			<td><span class="normal"><?php echo $admtext['cemetery']; ?>: </span></td>
		</tr>
		<tr id="cemrow" style="display:none">
			<td>
				<select name="hsstat" onchange="getNewMedia(document.find2,0)">
					<option value="">&nbsp;</option>
					<option value="<?php echo $admtext['notyetlocated']; ?>"><?php echo $admtext['notyetlocated']; ?></option>
					<option value="<?php echo $admtext['located']; ?>"><?php echo $admtext['located']; ?></option>
					<option value="<?php echo $admtext['unmarked']; ?>"><?php echo $admtext['unmarked']; ?></option>
					<option value="<?php echo $admtext['missing']; ?>"><?php echo $admtext['missing']; ?></option>
					<option value="<?php echo $admtext['cremated']; ?>"><?php echo $admtext['cremated']; ?></option>
				</select>
			</td>
			<td>
			<select name="cemeteryID" onchange="getNewMedia(document.find2,0)" style="width:380px">
				<option selected></option>
<?php
$query = "SELECT cemname, cemeteryID, city, county, state, country FROM $cemeteries_table ORDER BY country, state, county, city, cemname";
$cemresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
while( $cemrow = mysql_fetch_assoc($cemresult) ) {
	$cemetery = "$cemrow[country], $cemrow[state], $cemrow[county], $cemrow[city], $cemrow[cemname]";
	echo "		<option value=\"$cemrow[cemeteryID]\"";
	if( $cemeteryID == $cemrow[cemeteryID] ) echo " selected";
	echo ">$cemetery</option>\n";
}
?>
			</select>
			</td>
		</tr>
	</table>

	</form>
	<div id="newmedia" style="width:620px;height:430px;overflow:auto"></div><br />

</div>
