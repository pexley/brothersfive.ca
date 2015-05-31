<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "users";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $assignedtree || !$allow_edit ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$query = "SELECT *, DATE_FORMAT(lastlogin,\"%d %b %Y %H:%i:%s\") as lastlogin, DATE_FORMAT(dt_registered,\"%d %b %Y %H:%i:%s\") as dt_registered_fmt, DATE_FORMAT(dt_activated,\"%d %b %Y %H:%i:%s\") as dt_activated FROM $users_table WHERE userID = \"$userID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row[description] = ereg_replace("\"", "&#34;",$row[description]);
$row[realname] = ereg_replace("\"", "&#34;",$row[realname]);
$row[phone] = ereg_replace("\"", "&#34;",$row[phone]);
$row[email] = ereg_replace("\"", "&#34;",$row[email]);
$row[website] = ereg_replace("\"", "&#34;",$row[website]);
$row[address] = ereg_replace("\"", "&#34;",$row[address]);
$row[city] = ereg_replace("\"", "&#34;",$row[city]);
$row[state] = ereg_replace("\"", "&#34;",$row[state]);
$row[country] = ereg_replace("\"", "&#34;",$row[country]);
$row[notes] = ereg_replace("\"", "&#34;",$row[notes]);

$revquery = "SELECT count(userID) as ucount FROM $users_table WHERE allow_living = \"-1\"";
$revresult = mysql_query($revquery) or die ("$text[cannotexecutequery]: $revquery");
$revrow = mysql_fetch_assoc( $revresult );
$revstar = $revrow[ucount] ? " *" : "";
mysql_free_result($revresult);

$helplang = findhelp("users_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[modifyuser], $flags );
?>
<script type="text/javascript" src="selectutils.js"></script>
<script type="text/javascript">
<?php
	include("branchlibjs.php");
?>

function validateForm( ) {
	var rval = true;
	if( document.form1.username.value.length == 0 ) {
		alert("<?php echo $admtext[enterusername]; ?>");
		rval = false;
	}
	else if( document.form1.password.value.length == 0 ) {
		alert("<?php echo $admtext[enterpassword]; ?>");
		rval = false;
	}
	return rval;
}	

function grantAdmin(status) {
	var ref = document.all ? document.all["restrictions"] : document.getElementById ? document.getElementById("restrictions") : null ;
	if( status == 'hidden') {
		document.form1.gedcom.selectedIndex = 0;
		document.form1.branch.selectedIndex = 0;
	}
	if (ref) { ref.style.visibility = status; }
}

function getTree() {
	if( document.form1.gedcom.options.length ) 
		return document.form1.gedcom.options[document.form1.gedcom.selectedIndex].value;
	else {
		alert("<?php echo $admtext[selecttree]; ?>");
		return false;
	}
}

var orgrealname = "<?php echo $row[realname]; ?>";
var orgusername = "<?php echo $row[username]; ?>";
var orgpassword = "<?php echo $row[password]; ?>";

function replaceText() {
	if(document.form1.notify.checked ) {
		var welcome = document.form1.welcome;
		var realname = new RegExp(orgrealname);
		var username = new RegExp(orgusername);
		var password = new RegExp(orgpassword);

		orgrealname = document.form1.realname.value;
		orgusername = document.form1.username.value;
		orgpassword = document.form1.password.value;

		welcome.value = welcome.value.replace(realname,orgrealname);
		welcome.value = welcome.value.replace(username,orgusername);
		welcome.value = welcome.value.replace(password,orgpassword);
		document.form1.welcome.style.display = '';
	}
	else
		document.form1.welcome.style.display = 'none';
}
</script>
</head>

<body background="../background.gif">

<?php
	$usertabs[0] = array(1,"users.php",$admtext['search'],"finduser");
	$usertabs[1] = array($allow_add,"newuser.php",$admtext[addnew],"adduser");
	$usertabs[2] = array($allow_edit,"reviewusers.php",$admtext[review] . $revstar,"review");
	$usertabs[3] = array(1,"mailusers.php",$admtext['email'],"mail");
	$usertabs[4] = array(1,"#",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/users_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($usertabs,"edit",$innermenu);
	echo displayHeadline("$admtext[users] &gt;&gt; $admtext[modifyuser]","users_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="updateuser.php" method="post" name="form1" onSubmit="return validateForm();">
	<table class="normal">
		<tr><td><?php echo $admtext['description']; ?>:</td><td><input type="text" name="description" size="50" maxlength="50" value="<?php echo $row[description]; ?>"></td></tr>
		<tr><td><?php echo $admtext['username']; ?>:</td><td><input type="text" name="username" size="20" maxlength="100" value="<?php echo $row[username]; ?>"></td></tr>
		<tr><td><?php echo $admtext['password']; ?>:</td><td><input type="password" name="password" size="20" maxlength="100" value="<?php echo $row[password]; ?>"></td></tr>
		<tr><td><?php echo $admtext['realname']; ?>:</td><td><input type="text" name="realname" size="50" maxlength="50" value="<?php echo $row[realname]; ?>"></td></tr>
		<tr><td><?php echo $admtext['phone']; ?>:</td><td><input type="text" name="phone" size="30" maxlength="30" value="<?php echo $row[phone]; ?>"></td></tr>
		<tr><td><?php echo $admtext['email']; ?>:</td><td><input type="text" name="email" size="50" maxlength="100" value="<?php echo $row[email]; ?>"></td></tr>
		<tr><td>&nbsp;</td><td><span class="normal"><input type="checkbox" name="no_email" value="1"<?php if( $row['no_email'] ) echo " checked"; ?>> <?php echo $admtext['no_email']; ?></td></tr>
		<tr><td><?php echo $admtext['website']; ?>:</td><td><input type="text" name="website" size="50" maxlength="128" value="<?php echo $row[website]; ?>"></td></tr>
		<tr><td><?php echo $admtext['address']; ?>:</td><td><input type="text" name="address" size="50" maxlength="100" value="<?php echo $row[address]; ?>"></td></tr>
		<tr><td><?php echo $admtext['city']; ?>:</td><td><input type="text" name="city" size="50" maxlength="64" value="<?php echo $row[city]; ?>"></td></tr>
		<tr><td><?php echo $admtext['stateprov']; ?>:</td><td><input type="text" name="state" size="50" maxlength="64" value="<?php echo $row[state]; ?>"></td></tr>
		<tr><td><?php echo $admtext['zip']; ?>:</td><td><input type="text" name="zip" size="20" maxlength="10" value="<?php echo $row[zip]; ?>"></td></tr>
		<tr><td><?php echo $admtext['cap_country']; ?>:</td><td><input type="text" name="country" size="50" maxlength="64" value="<?php echo $row[country]; ?>"></td></tr>
		<tr><td><?php echo $admtext['notes']; ?>:</td><td><textarea cols="50" rows="4" name="notes"><?php echo $row[notes]; ?></textarea></td></tr>
<?php
	if( $row[dt_registered] ) {
?>
		<tr><td><?php echo $admtext['dtregistered']; ?>:</span></td><td><span class="normal"><?php echo $row['dt_registered_fmt']; ?></span></td></tr>
<?php
	}
?>
		<tr><td><?php echo $admtext['dtactivated']; ?>:</td><td><?php echo $row['dt_activated']; ?></td></tr>
		<tr><td><?php echo $admtext['lastlogin']; ?>:</td><td><?php echo $row['lastlogin']; ?></td></tr>
	</table>
	<span class="normal">
<?php
	echo "<br/><strong>$admtext[rights]</strong><br/>\n";
?>
	<input type="checkbox" name="form_allow_add" value="1"<?php if( $row['allow_add'] ) echo " checked"; ?>> <?php echo $admtext['allow_add']; ?><br/>
	<input type="radio" name="form_allow_edit" value="1"<?php if( $row['allow_edit'] ) echo " checked"; ?>> <?php echo $admtext['allow_edit']; ?><br/>
	<input type="radio" name="form_allow_edit" value="2"<?php if( $row['tentative_edit'] ) echo " checked"; ?>> <?php echo $admtext['tentative_edit']; ?><br/>
	<input type="radio" name="form_allow_edit" value="0"<?php if( !$row['allow_edit'] && !$row['tentative_edit'] ) echo " checked"; ?>> <?php echo $admtext['no_edit']; ?><br/>
	<input type="checkbox" name="form_allow_delete" value="1"<?php if( $row['allow_delete'] ) echo " checked"; ?>> <?php echo $admtext['allow_delete']; ?><br/>
	<input type="checkbox" name="form_allow_living" value="1"<?php if( $row['allow_living'] > 0 ) echo " checked"; ?>> <?php echo $admtext['allow_living']; ?><br/>
	<input type="checkbox" name="form_allow_ged" value="1"<?php if( $row['allow_ged'] ) echo " checked"; ?>> <?php echo $admtext['allow_ged']; ?><br/>
	<input type="checkbox" name="form_allow_lds" value="1"<?php if( $row['allow_lds'] ) echo " checked"; ?>> <?php echo $admtext['allow_lds']; ?><br/>
	<br/>
<?php
	echo "<strong>$admtext[accesslimits]</strong><br/>\n";
	$adminaccess = $row[gedcom] || $row[branch] ? 0 : 1;
?>
	<input type="radio" name="administrator" value="1" <?php if( $adminaccess) echo "checked"; ?> onClick="grantAdmin('hidden');"> <?php echo $admtext['allow_admin']; ?><br/>
	<input type="radio" name="administrator" value="0" <?php if( !$adminaccess) echo "checked"; ?> onClick="grantAdmin('visible');"> <?php echo $admtext['limitedrights']; ?><br/>
	<div id="restrictions" <?php if( $adminaccess) echo "style='visibility: hidden;'"; ?>><table>
		<tr><td valign="top">
		<span class="normal"><?php echo $admtext['tree']; ?>*:</span></td><td><span class="normal">
			<select name="gedcom" onChange="var tree=getTree(); if( !tree ) tree = 'none'; <?php echo $swapbranches; ?>">
				<option value=""></option>
<?php
	$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
	$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	while( $treerow = mysql_fetch_assoc($treeresult) ) {
		echo "	<option value=\"$treerow[gedcom]\"";
		if( $row[gedcom] == $treerow['gedcom'] ) echo " selected";
		echo ">$treerow[treename]</option>\n";
	}
?>
			</select></span>
			</td>
		</tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['branch']; ?>**:</span></td><td><span class="normal">
<?php
	$query = "SELECT branch, gedcom, description FROM $branches_table WHERE gedcom = \"$row[gedcom]\" ORDER BY description";
	$branchresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	echo "<select name=\"branch\" id=\"branch\" size=\"$selectnum\">\n";
	echo "	<option value=\"\">$admtext[nobranch]</option>\n";
	if( $row[gedcom] ) {
		while( $branch = mysql_fetch_assoc( $branchresult ) ) {
			echo  "	<option value=\"$branch[branch]\"";
			if( $row[branch] == $branch[branch] ) echo " selected";
			echo ">$branch[description]</option>\n";
		}
	}
	echo "</select>\n";
?>
		</span></td></tr>
	</table></div>
	<br/>
<?php
	if( $row[allow_living] == -1 ) { //account is inactive
		echo "<input type=\"checkbox\" name=\"notify\" value=\"1\" checked onClick=\"replaceText();\"> $admtext[notify]<br/>\n";
		$owner = $sitename ? $sitename : $dbowner;
		echo "<textarea name=\"welcome\" rows=\"5\" cols=\"50\">$admtext[hello] $row[realname],\r\n\r\n$admtext[activated] $admtext[infois]:\r\n\r\n$admtext[username]: $row[username]\r\n$admtext[password]: $row[password]\r\n\r\n$owner\r\n$tngdomain</textarea><br/><br/>\n";
	}
	else
		echo "<input type=\"hidden\" name=\"notify\" value=\"0\">\n";
?>
	<input type="hidden" name="userID" value="<?php echo "$userID"; ?>">
	<input type="hidden" name="newuser" value="<?php echo "$newuser"; ?>">
	<input type="hidden" name="orgpwd" value="<?php echo $row['password']; ?>">
	<input type="submit" name="submit" value="<?php echo $admtext['savechanges']; ?>"></form>
	<p style="font-size: 8pt;">
<?php 
	echo "*$admtext[treemsg]<br/>\n";
	echo "**$admtext[branchmsg]<br/>\n";
?>
	</p>
	</span>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>