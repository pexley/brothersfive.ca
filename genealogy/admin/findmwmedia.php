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
	<span class="subhead"><strong><?php echo $admtext['addmedia']; ?></strong></span><br/>
	<form name="find2" style="margin:0px" onsubmit="getNewMwMedia(this,1); return false;">
	<table class="normal">
		<tr>
			<td><?php echo $admtext['searchfor']; ?>: </td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>" id="searchstring"></td>
			<td>
				<input type="submit" name="searchbutton" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<span id="spinner1" style="display:none"><img src="../spinner.gif" width="18" height="18" /></span>
			</td>
		</tr>
	</table>
	<input type="hidden" name="mediatypeID" value="<?php echo $mediatypeID; ?>" />
	<input type="hidden" name="tree" value="<?php echo $tree; ?>" />
	</form>
	<div id="newmedia" style="width:620px;height:430px;overflow:auto"></div><br />

</div>
