<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "reports";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$file = "$rootpath/whatsnew.txt";

$contents = @file($file);

$whatsnew_url = getURL( "whatsnew", 0 );
$helplang = findhelp("reports_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader( $admtext['whatsnew'], $flags );
?>
<script type="text/javascript">
function submitForm(form) {
	var params = Form.serialize(form);
	$('savedmsg').innerHTML = "";
	new Ajax.Request('savewhatsnewmsg.php',{parameters:params,
		onSuccess:function(req){
			$('savedmsg').innerHTML = req.responseText;
			new Effect.Appear('savedmsg',{duration:.2});
		}
	}); 
	return false;
}
</script>
</head>

<body background="../background.gif">

<?php
	$reporttabs[0] = array(1,"reports.php",$admtext['search'],"findreport");
	$reporttabs[1] = array($allow_add,"newreport.php",$admtext['addnew'],"addreport");
	$reporttabs[2] = array(1,"whatsnewmsg.php",$admtext['whatsnew'],"whatsnew");
	$reporttabs[3] = array(1,"mostwantedlist.php",$admtext['mostwanted'],"mostwanted");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/reports_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"$whatsnew_url\" target=\"_blank\" class=\"lightlink\">$admtext[test]</a>";
	$menu = doMenu($reporttabs,"whatsnew",$innermenu);
	echo displayHeadline("$admtext[reports] &gt;&gt; $admtext[whatsnew]","reports_icon.gif",$menu,"");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<form action="whatsnewmsg.php" method="post" style="margin:0px" name="form1" onsubmit="return submitForm(this);">
	<p class="subhead"><strong><?php echo $admtext[wnmsg]; ?>:</strong></p>
	<textarea cols="50" rows="10" name="whatsnewmsg"><?php foreach( $contents as $line ) {echo $line;} ?></textarea><br /><br />
	<input type="submit" name="submit" accesskey="s" value="<?php echo $admtext['save']; ?>"> &nbsp;&nbsp; <span class="normal" id="savedmsg" style="color:green;display:none">Saved</span>
	</form>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>