<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack" style="margin:10px;border:0px" id="finddiv">
	<span class="subhead"><strong><?php echo $admtext['addlinks']; ?></strong></span><br/>
	<form name="find2" id="find2" style="margin-top:0px" onsubmit="return getPotentialLinks('<?php echo $linktype; ?>');">
<?php
	if($linktype == "I") {
?>
	<table cellspacing="2" id="findformI">
		<tr><td colspan="2" class="normal"><br /><strong><?php echo $admtext['findpersonid']; ?></strong> <span class="smaller">(<?php echo $admtext['enterinamepart']; ?>)</span></td></tr>
		<tr>
			<td class="normal"><?php echo $admtext['lastname']; ?></td>
			<td class="normal"><?php echo $admtext['firstname']; ?></td>
		</tr>
		<tr>
			<td><input type="text" name="mylastname" id="mylastname"></td>
			<td>
				<input type="text" name="myfirstname" id="myfirstname">
				<input type="submit" name="searchbutton" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<span id="spinnerfind" style="display:none"><img src="../spinner.gif" width="18" height="18" /></span>
			</td>
		</tr>
	</table>
<?php
	}
	elseif($linktype == "F") {
?>
	<table cellspacing="2" id="findformF">
		<tr><td colspan="2" class="normal"><br /><strong><?php echo $admtext['findfamilyid']; ?></strong> <span class="smaller">(<?php echo $admtext['enterfnamepart']; ?>)</span></td></tr>
		<tr>
			<td class="normal"><?php echo $admtext['husbname']; ?></td>
			<td class="normal"><?php echo $admtext['wifename']; ?></td>
		</tr>
		<tr>
			<td><input type="text" name="myhusbname" id="myhusbname"></td>
			<td>
				<input type="text" name="mywifename" id="mywifename">
				<input type="submit" name="searchbutton" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<span id="spinnerfind" style="display:none"><img src="../spinner.gif" width="18" height="18" /></span>
			</td>
		</tr>
	</table>
<?php
	}
	elseif($linktype == "S") {
?>
	<table cellspacing="2" id="findformS">
		<tr><td colspan="2" class="normal"><br /><strong><?php echo $admtext['findsourceid']; ?></strong> <span class="smaller">(<?php echo $admtext['entersourcepart']; ?>)</span></td></tr>
		<tr><td class="normal"><?php echo $admtext['title']; ?></td></tr>
		<tr>
			<td>
				<input type="text" name="mysourcetitle" id="mysourcetitle">
				<input type="submit" name="searchbutton" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<span id="spinnerfind" style="display:none"><img src="../spinner.gif" width="18" height="18" /></span>
			</td>
		</tr>
	</table>
<?php
	}
	elseif($linktype == "R") {
?>
	<table cellspacing="2" id="findformR">
		<tr><td colspan="2" class="normal"><br /><strong><?php echo $admtext['findrepoid']; ?></strong> <span class="smaller">(<?php echo $admtext['enterrepopart']; ?>)</span></td></tr>
		<tr><td class="normal"><?php echo $admtext['title']; ?></td></tr>
		<tr>
			<td>
				<input type="text" name="myrepotitle" id="myrepotitle">
				<input type="submit" name="searchbutton" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<span id="spinnerfind" style="display:none"><img src="../spinner.gif" width="18" height="18" /></span>
			</td>
		</tr>
	</table>
<?php
	}
	elseif($linktype == "L") {
?>
	<table cellspacing="2" id="findformL">
		<tr><td colspan="2" class="normal"><br /><strong><?php echo $admtext['findplace']; ?></strong> <span class="smaller">(<?php echo $admtext['enterplacepart']; ?>)</span></td></tr>
		<tr><td class="normal"><?php echo $admtext['place']; ?></td></tr>
		<tr>
			<td>
				<input type="text" name="myplace" id="myplace">
				<input type="submit" name="searchbutton" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<span id="spinnerfind" style="display:none"><img src="../spinner.gif" width="18" height="18" /></span>
			</td>
		</tr>
	</table>
<?php
	}
?>
	</form>
	<div id="newlines" style="width:605px;height:390px;overflow:auto"></div><br />
</div>
