<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "entities";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack normal" style="margin:10px;border:0px" id="newentity">
<p class="subhead"><strong><?php echo "$admtext[enternew] $admtext[$entity]"; ?></strong></p>

<form action="addentity.php" method="post" name="entityform" id="entityform" onsubmit="return addEntity(this);">
<input type="hidden" name="entity" value="<?php echo "$entity"; ?>">
&nbsp;<input type="text" name="newitem"> <input type="submit" value="<?php echo $admtext['add']; ?>">
<br/>
<div class="normal" id="entitymsg" style="color:green"></div>
</form>
</div>
