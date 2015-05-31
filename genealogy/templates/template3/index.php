<?php
include("begin.php");
include($cms[tngpath] . "genlib.php");
include($cms[tngpath] . "getlang.php");
include($cms[tngpath] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");

$flags['noicons'] = true;
$flags['noheader'] = true;
$flags['nobody'] = true;
tng_header( $text['mnuheader'], $flags );
?>

<body class="homebody">
<div class="center">
<table border="0" cellspacing="0" cellpadding="5" class="indexpage">
	<tr>
		<td>
			<img src="<?php echo "$cms[tngpath]"; ?>title.gif" alt="" class="titleimg" width="630" height="93" />
<?php
	//if you prefer text instead of the banner image that says "Our Family Genealogy Pages", remove the "title.gif" line above (the whole line)
	//and remove the <!-- comment marks --> from the lines below, then edit the "Our Family History" text to have it say what you want
?>
<!--
	<div style="padding:10px">
	<em style="font-size:68px; font-family:Verdana,Arial,sans-serif; color:#39692A;">

	Our Family History

	</em>
	</div>
-->
			<table>
				<tr>
					<td valign="top">
<?php
	//the "img" line below includes the large picture of the old town in the middle
?>
						<img src="<?php echo "$cms[tngpath]"; ?>mainstreet.jpg" alt="" class="mainimg" width="530" height="303" />
					</td>
					<td>&nbsp;&nbsp;</td>
					<td valign="top"><br /><br />
						<h2 class="header"><?php echo $text['mnusearchfornames']; ?></h2>
						<!-- Do not change the form action or field names! -->
						<form action="search.php" method="get" id="form1">
						<table border="0" cellspacing="5" cellpadding="0">
							<tr><td><span class="normal"><?php echo $text['mnulastname']; ?>: </span><br /><input type="text" name="mylastname" size="14" /></td></tr>
							<tr><td><span class="normal"><?php echo $text['mnufirstname']; ?>:</span><br /><input type="text" name="myfirstname" size="14" /></td></tr>
							<tr><td><input type="hidden" name="mybool" value="AND" /><input type="hidden" name="offset" value="0" /><input type="submit" name="search" value="<?php echo $text['mnusearchfornames']; ?>" /></td></tr>
						</table>
						</form>
						<div class="subheader">
						<ul>
						<li><a href="searchform.php"><?php echo $text['mnuadvancedsearch']; ?></a></li>
						<li><a href="surnames.php"><?php echo $text['mnulastnames']; ?></a></li>
						</ul>
<?php
	if( $currentuser ) {
		echo "<p><strong>$text[welcome], $currentuserdesc.</strong></p>\n";
	}
?>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div class="mainmenu">
			<br />
			<a href="whatsnew.php"><?php echo $text['mnuwhatsnew']; ?></a> &nbsp;|&nbsp; 
			<a href="browsemedia.php?mediatypeID=photos"><?php echo $text['mnuphotos']; ?></a> &nbsp;|&nbsp;
			<a href="browsemedia.php?mediatypeID=histories"><?php echo $text['mnuhistories']; ?></a> &nbsp;|&nbsp;
			<a href="browsemedia.php?mediatypeID=documents"><?php echo $text['documents']; ?></a> &nbsp;|&nbsp;
			<a href="browsemedia.php?mediatypeID=videos"><?php echo $text['videos']; ?></a> &nbsp;|&nbsp;
			<a href="browsemedia.php?mediatypeID=recordings"><?php echo $text['recordings']; ?></a> &nbsp;|&nbsp;
			<a href="browsealbums.php"><?php echo $text['albums']; ?></a> &nbsp;|&nbsp;
			<a href="browsemedia.php"><?php echo $text['allmedia']; ?></a>

			<br />
			<a href="mostwanted.php"><?php echo $text['mostwanted']; ?></a> &nbsp;|&nbsp;
			<a href="cemeteries.php"><?php echo $text['mnucemeteries']; ?></a> &nbsp;|&nbsp;
			<a href="browsemedia.php?mediatypeID=headstones"><?php echo $text['mnutombstones']; ?></a> &nbsp;|&nbsp;
			<a href="places.php"><?php echo $text['places']; ?></a> &nbsp;|&nbsp;
			<a href="anniversaries.php"><?php echo $text['anniversaries']; ?></a>

			<br />
			<a href="browsesources.php"><?php echo $text['mnusources']; ?></a> &nbsp;|&nbsp;
			<a href="browserepos.php"><?php echo $text['repositories']; ?></a> &nbsp;|&nbsp;
			<a href="reports.php"><?php echo $text['mnureports']; ?></a> &nbsp;|&nbsp;
			<a href="browsenotes.php"><?php echo $text['notes']; ?></a> &nbsp;|&nbsp;
			<a href="bookmarks.php"><?php echo $text['bookmarks']; ?></a> &nbsp;|&nbsp;
			<a href="browsetrees.php"><?php echo $text['mnustatistics']; ?></a>
			<br />
<?php
	if( $currentuser ) {
		echo "<a href=\"logout.php\">$text[mnulogout]</a> &nbsp;|&nbsp;\n";
	}
	else {
		echo "<a href=\"login.php\">$text[mnulogon]</a> &nbsp;|&nbsp;\n";
	}
?>
			<a href="changelanguage.php"><?php echo $text['mnulanguage']; ?></a> &nbsp;|&nbsp;
			<a href="showlog.php"><?php echo $text['mnushowlog']; ?></a> &nbsp;|&nbsp;
<?php
	if( $allow_admin )
		echo "<a href=\"admin/index.php\">$text[mnuadmin]</a> &nbsp;|&nbsp;\n";
?>
			<a href="newacctform.php"><?php echo $text['mnuregister']; ?></a> &nbsp;|&nbsp;
			<a href="suggest.php"><?php echo $text['contactus']; ?></a>
</div>
	<div class="footer" style="text-align: center">
<br />

<p>
	<?php echo $text['pwrdby']; ?> <a href="http://lythgoes.net/genealogy/software.php" class="footer">The Next Generation of Genealogy Sitebuilding</a> &copy;, <?php echo $text['writby']; ?> Darrin Lythgoe 2001-<?php echo date('Y') ; ?>.
</p>
	</div> <!-- end footer div -->
</div> <!-- end center div -->
<script type="text/javascript">
	document.forms.form1.mylastname.focus();
</script>

</body>
</html>
