<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "families";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

header("Content-type:text/html; charset=" . $session_charset);
?>
</head>

<body class="databack" style="border-right: 0px; border-bottom: 0px;" onLoad="document.form1.myhusbname.focus()";>
<span class="subhead"><strong><?php echo $admtext[findfamilyid]; ?></strong></span><br/>
<span class="normal">(<?php echo $admtext[enternamepart]; ?>)</span><br/>
<form action="findfamily2.php" method="post" name="form1" id="form1" onSubmit='if( form1.myhusbname.value.length == 0 && form1.mywifename.value.length == 0 ) {alert("<?php echo $admtext[pleasenamepart]; ?>"); return false;}'>
<input type="hidden" name="tree" value="<?php echo $tree; ?>">
<?php if( $formname == "" ) $formname = "form1"; ?>
<input type="hidden" name="formname" value="<?php echo $formname; ?>">
<?php if( $field == "" ) $field = "personID"; ?>
<input type="hidden" name="field" value="<?php echo $field; ?>">
<table border="0" cellspacing="0" cellpadding="2">
			<tr><td><span class="normal"><?php echo $admtext[husbname]; ?>: </span></td><td><input type="text" name="myhusbname"></td></tr>
			<tr><td><span class="normal"><?php echo $admtext[wifename]; ?>: </span></td><td><input type="text" name="mywifename"></td></tr>
</table><br/>
<div align="center"><input type="submit" value="<?php echo $admtext[search]; ?>">
</div><br/>
</form>

</body>
</html>
