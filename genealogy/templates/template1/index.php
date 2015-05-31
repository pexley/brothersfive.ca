<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

$flags['noicons'] = true;
$flags['noheader'] = true;
tng_header( $text['ourhist'], $flags );
?>
<body>

<br>
<div align="center">
<table class="indexpage">
	<tr>
		<td colspan="3">
			<img src="<?php echo $cms['tngpath']; ?>home-photo.jpg" alt="" width="200" height="150" border="0" align="left"/>
			<img src="<?php echo $cms['tngpath']; ?>home-title.gif" alt="" width="395" height="159" hspace="10" border="0" />

<?php
	//if you prefer text instead of the banner image that says "Our Family History", remove the "home-title.gif" line above (the whole line)
	//and remove the <!-- comment marks --> from the lines below, then edit the "Our Family History" text to have it say what you want (keep the
	//"<br />" tag if you want a line break.
?>

<!--
	<em style="font-size:72px; font-family:Verdana,Arial,sans-serif; color:#000099; line-height:72px">

	Our Family<br />History

	</em>
-->

			<br /><br />
		</td>
	</tr>
<?php
	if( $currentuser ) {
		echo "<tr><td colspan='3'><p><strong>$text[welcome], $currentuserdesc.</strong></p></td></tr>\n";
	}
?>	<tr>
		<td valign="top" class="normal">
			<h2><?php echo $text['mnusearchfornames']; ?></h2>
			<!-- Do not change the form action or field names! -->
			<form action="search.php" method="GET">
			<table border="0" cellspacing="5" cellpadding="0">
				<tr><td><span class="normal"><?php echo $text['mnulastname']; ?>: </span><br><input type="text" name="mylastname" size="14" /></td></tr>
				<tr><td><span class="normal"><?php echo $text['mnufirstname']; ?>:</span><br><input type="text" name="myfirstname" size="14" /></td></tr>
				<tr><td><input type="hidden" name="mybool" value="AND" /><input type="submit" name="search" value="<?php echo $text['mnusearch']; ?>" /> <input type="reset" value="<?php echo $text[mnureset]; ?>" /></td></tr>
			</table>
			</form>
		</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td valign="top" class="normal">
			<h2><?php echo $text['mnufeatures']; ?></h2>
			<table style="font-size:12pt">
				<tr>
					<td valign="top">
						<ul>
<?php
	if( $currentuser ) {
		echo "<li><a href=\"logout.php\">$text[mnulogout]</a></li>\n";
	}
	else {
		echo "<li><a href=\"login.php\">$text[mnulogon]</a></li>\n";
	}
	echo "<li><a href=\"newacctform.php\">$text[mnuregister]</a></li>\n";
	echo "<li><a href=\"searchform.php\">$text[mnuadvancedsearch]</a></li>\n";
	echo "<li><a href=\"surnames.php\">$text[mnulastnames]</a></li>\n";
	echo "<li><a href=\"bookmarks.php\">$text[bookmarks]</a></li>\n";
	echo "<li><a href=\"browsetrees.php\">$text[mnustatistics]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=photos\">$text[mnuphotos]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=histories\">$text[mnuhistories]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=documents\">$text[documents]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=videos\">$text[videos]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=recordings\">$text[recordings]</a></li>\n";
	echo "<li><a href=\"browsealbums.php\">$text[albums]</a></li>\n";
	echo "<li><a href=\"browsemedia.php\">$text[allmedia]</a></li>\n";
?>
						</ul>
					</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td valign="top">
						<ul>
<?php
	echo "<li><a href=\"cemeteries.php\">$text[mnucemeteries]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=headstones\">$text[mnutombstones]</a></li>\n";
	echo "<li><a href=\"places.php\">$text[places]</a></li>\n";
	echo "<li><a href=\"browsenotes.php\">$text[notes]</a></li>\n";
	echo "<li><a href=\"anniversaries.php\">$text[anniversaries]</a></li>\n";
	echo "<li><a href=\"reports.php\">$text[mnureports]</a></li>\n";
	echo "<li><a href=\"browsesources.php\">$text[mnusources]</a></li>\n";
	echo "<li><a href=\"browserepos.php\">$text[repositories]</a></li>\n";
	echo "<li><a href=\"whatsnew.php\">$text[mnuwhatsnew]</a></li>\n";
	echo "<li><a href=\"mostwanted.php\">$text[mostwanted]</a></li>\n";
	echo "<li><a href=\"changelanguage.php\">$text[mnulanguage]</a></li>\n";
	if( $allow_admin ) {
		echo "<li><a href=\"showlog.php\">$text[mnushowlog]</a></li>\n";
		echo "<li><a href=\"admin/index.php\">$text[mnuadmin]</a></li>\n";
	}
	echo "<li><a href=\"suggest.php\">$text[contactus]</a></li>\n";
?>
						</ul>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<hr size="1" />
<div>
<?php echo $text['pwrdby']; ?> <a href="http://lythgoes.net/genealogy/software.php" class="footer">The Next Generation of Genealogy Sitebuilding</a> &copy;, <?php echo $text['writby']; ?> Darrin Lythgoe 2001-<?php echo date('Y') ; ?>.
</div>

</div>

</body>
</html>
