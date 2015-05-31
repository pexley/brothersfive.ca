<?php
include("../subroot.php");
include($subroot . "config.php");
$maint = $tngconfig['maint'];
$tngconfig['maint'] = "";
include("adminlib.php");
$textpart = "index";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
if( $link )
	include("checklogin.php");
include("../version.php");

$helplang = findhelp("index_help.php");

tng_adminheader( $admtext[administration], "" );

if( $cms[support] )
	$home_url = "../../../$homepage";
else
	$home_url = "../$homepage";
?>
</head>

<body class="sideback"><form action="savelanguage_admin.php" target="_parent" name="language">
<table cellspacing="0" cellpadding="1" width="100%">
	<tr><td colspan="2"><span class="whiteheader"><span class="subhead"><strong><?php echo "$tng_title, v.$tng_version"; ?></strong></span></span></td></tr>
	<tr>
		<td>
			<span class="whiteheader normal">
			<a href="index.php" target="_parent" class="lightlink"><?php echo $admtext['adminhome']; ?></a>
			&nbsp;|&nbsp; <a href="<?php echo $home_url; ?>" target="_parent" class="lightlink"><?php echo $admtext['publichome']; ?></a>
			&nbsp;|&nbsp; <a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/index_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();" class="lightlink"><?php echo $admtext['getstart']; ?></a>
<?php
	if( $allow_admin )
		echo "&nbsp;|&nbsp; <a href=\"adminshowlog.php\" class=\"lightlink\" target=\"main\">$admtext[showlog]</a>\n";
	if($maint)
		echo "&nbsp;|&nbsp; <strong><span class=\"yellow\">$text[mainton]</span></strong>\n";
?>
			&nbsp;|&nbsp; <a href="logout.php" class="lightlink" target="_parent"><?php echo $admtext[logout]; ?></a>
			</span>
		</td>
		<td align="right">
<?php
	if( $link && $chooselang ) {
		$query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
		$result = @mysql_query($query);
		
		if( $result && mysql_num_rows( $result ) ) {
			echo " &nbsp;<select name=\"newlanguage\" style=\"font-size: 10px;\" onChange=\"document.language.submit();\">\n";

			while( $row = mysql_fetch_assoc($result)) {
				echo "<option value=\"$row[languageID]\"";
				if( $row[folder] == $mylanguage )
					echo " selected";
				echo ">$row[display]</option>\n";
			}
			echo "</select>\n";
			mysql_free_result($result);
		}
	}
?>
		</td>
	</tr>
</table>
</form>
</body>
</html>
