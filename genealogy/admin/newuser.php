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

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$query = "SELECT count(userID) as ucount FROM $users_table";
$result = @mysql_query($query);
if( $result )
	$row = mysql_fetch_assoc($result);
else
	$row['ucount'] = 0;

$revquery = "SELECT count(userID) as ucount FROM $users_table WHERE allow_living = \"-1\"";
$revresult = mysql_query($revquery) or die ("$text[cannotexecutequery]: $revquery");
$revrow = mysql_fetch_assoc( $revresult );
$revstar = $revrow[ucount] ? " *" : "";
mysql_free_result($revresult);

$helplang = findhelp("users_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[addnewuser], $flags );
?>
<script language="JavaScript" src="selectutils.js"></script>
<SCRIPT language="JavaScript" type="text/javascript">
<?php
	include("branchlibjs.php");
?>

function validateForm( ) {
	var rval = true;
	if( document.form1.description.value.length == 0 ) {
		alert("<?php echo $admtext[enteruserdesc]; ?>");
		rval = false;
	}
	else if( document.form1.username.value.length == 0 ) {
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
		swapBranches('none');
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

var orgrealname = "xxx";
var orgusername = "yyy";
var orgpassword = "zzz";

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
	$usertabs[1] = array($allow_add,"newuser.php",$admtext['addnew'],"adduser");
	$usertabs[2] = array($allow_edit,"reviewusers.php",$admtext['review'] . $revstar,"review");
	$usertabs[3] = array(1,"mailusers.php",$admtext['email'],"mail");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/users_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($usertabs,"adduser",$innermenu);
	echo displayHeadline("$admtext[users] &gt;&gt; $admtext[addnewuser]","users_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="adduser.php" method="post" style="margin:0px" name="form1" onSubmit="return validateForm();">
	<table class="normal">
		<tr><td><?php echo $admtext['description']; ?>:</td><td><input type="text" name="description" size="50" maxlength="50"></td></tr>
		<tr><td><?php echo $admtext['username']; ?>:</td><td><input type="text" name="username" size="20" maxlength="100"></td></tr>
		<tr><td><?php echo $admtext['password']; ?>:</td><td><input type="password" name="password" size="20" maxlength="100"></td></tr>
		<tr><td><?php echo $admtext['realname']; ?>:</td><td><input type="text" name="realname" size="50" maxlength="50"></td></tr>
		<tr><td><?php echo $admtext['phone']; ?>:</td><td><input type="text" name="phone" size="30" maxlength="30"></td></tr>
		<tr><td><?php echo $admtext['email']; ?>:</td><td><input type="text" name="email" size="50" maxlength="100"></td></tr>
		<tr><td>&nbsp;</td><td><input type="checkbox" name="no_email" value="1"> <?php echo $admtext['no_email']; ?></td></tr>
		<tr><td><?php echo $admtext['website']; ?>:</td><td><input type="text" name="website" size="50" maxlength="128" value="http://"></td></tr>
		<tr><td><?php echo $admtext['address']; ?>:</td><td><input type="text" name="address" size="50" maxlength="100"></td></tr>
		<tr><td><?php echo $admtext['city']; ?>:</td><td><input type="text" name="city" size="50" maxlength="64"></td></tr>
		<tr><td><?php echo $admtext['stateprov']; ?>:</td><td><input type="text" name="state" size="50" maxlength="64"></td></tr>
		<tr><td><?php echo $admtext['zip']; ?>:</td><td><input type="text" name="zip" size="20" maxlength="10"></td></tr>
		<tr><td><?php echo $admtext['cap_country']; ?>:</td><td><input type="text" name="country" size="50" maxlength="64"></td></tr>
		<tr><td><?php echo $admtext['notes']; ?>:</td><td><textarea cols="50" rows="4" name="notes"></textarea></td></tr>
	</table>
	<div class="normal">
<?php
	echo "<br/><strong>$admtext[rights]</strong><br/>\n";
?>
	<input type="checkbox" name="form_allow_add" value="1"<?php if( !$row['ucount'] ) echo " checked"; ?>> <?php echo $admtext[allow_add]; ?><br/>
	<input type="radio" name="form_allow_edit" value="1"<?php if( !$row['ucount'] ) echo " checked"; ?>> <?php echo $admtext[allow_edit]; ?><br/>
<?php
	if( $row['ucount'] ) {
?>
	<input type="radio" name="form_allow_edit" value="2"> <?php echo $admtext[tentative_edit]; ?><br/>
	<input type="radio" name="form_allow_edit" value="0"<?php if( $row['ucount'] ) echo " checked"; ?>> <?php echo $admtext[no_edit]; ?><br/>
<?php
	}
?>
	<input type="checkbox" name="form_allow_delete" value="1"<?php if( !$row['ucount'] ) echo " checked"; ?>> <?php echo $admtext['allow_delete']; ?><br/>
	<input type="checkbox" name="form_allow_living" value="1"<?php if( !$row['ucount'] ) echo " checked"; ?>> <?php echo $admtext['allow_living']; ?><br/>
	<input type="checkbox" name="form_allow_ged" value="1"<?php if( !$row['ucount'] ) echo " checked"; ?>> <?php echo $admtext['allow_ged']; ?><br/>
	<input type="checkbox" name="form_allow_lds" value="1"<?php if( !$row['ucount'] ) echo " checked"; ?>> <?php echo $admtext['allow_lds']; ?><br/>
<?php
	if( $row['ucount'] ) {
		echo "<br/><strong>$admtext[accesslimits]</strong><br/>\n";
?>
	<input type="radio" name="administrator" value="1" onClick="grantAdmin('hidden');"> <?php echo $admtext['allow_admin']; ?><br/>
	<input type="radio" name="administrator" value="0" checked="checked" onClick="grantAdmin('visible');"> <?php echo $admtext['limitedrights']; ?><br/>
	<div id="restrictions"><table>
		<tr><td valign="top">
		<span class="normal"><?php echo $admtext['tree']; ?>*:</span></td><td><span class="normal">
			<select name="gedcom" onChange="var tree=getTree(); if( !tree ) tree = 'none'; <?php echo $swapbranches; ?>">
				<option value=""></option>
<?php
		$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
		$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		while( $treerow = mysql_fetch_assoc($treeresult) ) {
			echo "	<option value=\"$treerow[gedcom]\">$treerow[treename]</option>\n";
		}
?>
			</select> </span>
			</td>
		</tr>
		<tr><td valign="top"><span class="normal"><?php echo $admtext['branch']; ?>**:</span></td><td><span class="normal">
<?php
	$query = "SELECT branch, gedcom, description FROM $branches_table WHERE gedcom = \"$row[gedcom]\" ORDER BY description";
	$branchresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
	echo "<select name=\"branch\" id=\"branch\">\n";
	echo "	<option value=\"\" selected>$admtext[nobranch]</option>\n";
	if( $assignedtree ) {
		while( $branch = mysql_fetch_assoc( $branchresult ) ) {
			echo  "	<option value=\"$branch[branch]\">$branch[description]</option>\n";
		}
	}
	echo "</select>\n";
?>
		</span></td></tr>
	</table></div>
<?php
	}
	else
		echo "<b>$text[firstuser]</b><input type=\"hidden\" name=\"gedcom\" value=\"\"><input type=\"hidden\" name=\"branch\" value=\"\">";
?>
	<br/>
	<input type="checkbox" name="notify" value="1" onClick="replaceText();"> <?php echo $admtext['notify']; ?><br/>
	<textarea name="welcome" rows="5" cols="50" style="display:none"><?php echo "$admtext[hello] xxx,\r\n\r\n$admtext[activated] $admtext[infois]:\r\n\r\n$admtext[username]: yyy\r\n$admtext[password]: zzz\r\n\r\n$dbowner\r\n$tngdomain"; ?></textarea><br/><br/>
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>"></form><br/>
	<p>
<?php
	echo "*$admtext[treemsg]<br/>\n";
	echo "**$admtext[branchmsg]<br/>\n";
?>
	</p>
	</div>
</td>
</tr>

</table>

<?php
	if( $row['ucount'] ) {
?>
<SCRIPT language="JavaScript" type="text/javascript">
	var tree=getTree();
	if( tree ) {
<?php
	echo $swapbranches;
?>
	}
</script>
<?php
}

echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>