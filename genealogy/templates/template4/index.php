<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

$flags['noicons'] = true;
$flags['noheader'] = true;
$flags['nobody'] = true;
tng_header( $text['ourpages'], $flags );
?>
<body>

<div align="center">
<table class="indexpage">
<tr><td colspan="4" class="line"></td></tr>
<tr>
	<td class="menuback">
		<a href="searchform.php"><img src="<?php echo $cms['tngpath']; ?>search4.gif" alt="<?php echo $text['mnusearchfornames']; ?>" class="searchimg" /></a>
		<form action="search.php" method="get">
		<table class="menuback">
			<tr><td><span class="fieldname"><?php echo $text['mnulastname']; ?>: <br /><input type="text" name="mylastname" class="searchbox" size="14" /></span></td></tr>
			<tr><td><span class="fieldname"><?php echo $text['mnufirstname']; ?>:<br /><input type="text" name="myfirstname" class="searchbox" size="14" /></span></td></tr>
			<tr><td><input type="hidden" name="mybool" value="AND" /><input type="submit" name="search" value="<?php echo $text['mnusearchfornames']; ?>" class="small" /></td></tr>
		</table>
		</form>
		<table class="menuback">
			<tr><td>
			<div class="fieldname">
				<ul>
				<li><a href="searchform.php" class="lightlink"><?php echo $text['mnuadvancedsearch']; ?></a></li>
				<li><a href="surnames.php" class="lightlink"><?php echo $text['mnulastnames']; ?></a><br /><br /></li>
<?php
	if( $currentuser ) {
		echo "<li><a href=\"logout.php\" class=\"lightlink\">$text[mnulogout]</a></li>\n";
	}
	else {
		echo "<li><a href=\"login.php\" class=\"lightlink\">$text[mnulogon]</a></li>\n";
	}
	echo "<li><a href=\"whatsnew.php\" class=\"lightlink\">$text[mnuwhatsnew]</a></li>\n";
	echo "<li><a href=\"mostwanted.php\" class=\"lightlink\">$text[mostwanted]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=photos\" class=\"lightlink\">$text[mnuphotos]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=histories\" class=\"lightlink\">$text[mnuhistories]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=documents\" class=\"lightlink\">$text[documents]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=videos\" class=\"lightlink\">$text[videos]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=recordings\" class=\"lightlink\">$text[recordings]</a></li>\n";
	echo "<li><a href=\"browsealbums.php\" class=\"lightlink\">$text[albums]</a></li>\n";
	echo "<li><a href=\"browsemedia.php\" class=\"lightlink\">$text[allmedia]</a></li>\n";
	echo "<li><a href=\"cemeteries.php\" class=\"lightlink\">$text[mnucemeteries]</a></li>\n";
	echo "<li><a href=\"browsemedia.php?mediatypeID=headstones\" class=\"lightlink\">$text[mnutombstones]</a></li>\n";
	echo "<li><a href=\"places.php\" class=\"lightlink\">$text[places]</a></li>\n";
	echo "<li><a href=\"browsenotes.php\" class=\"lightlink\">$text[notes]</a></li>\n";
	echo "<li><a href=\"anniversaries.php\" class=\"lightlink\">$text[anniversaries]</a></li>\n";
	echo "<li><a href=\"reports.php\" class=\"lightlink\">$text[mnureports]</a></li>\n";
	echo "<li><a href=\"browsesources.php\" class=\"lightlink\">$text[mnusources]</a></li>\n";
	echo "<li><a href=\"browserepos.php\" class=\"lightlink\">$text[repositories]</a></li>\n";
	echo "<li><a href=\"browsetrees.php\" class=\"lightlink\">$text[mnustatistics]</a></li>\n";
	echo "<li><a href=\"changelanguage.php\" class=\"lightlink\">$text[mnulanguage]</a></li>\n";
	if( $allow_admin ) {
		echo "<li><a href=\"showlog.php\" class=\"lightlink\">$text[mnushowlog]</a></li>\n";
		echo "<li><a href=\"admin/index.php\" class=\"lightlink\">$text[mnuadmin]</a></li>\n";
	}
	echo "<li><a href=\"bookmarks.php\" class=\"lightlink\">$text[bookmarks]</a></li>\n";
	echo "<li><a href=\"suggest.php\" class=\"lightlink\">$text[contactus]</a></li>\n";
	echo "<li><a href=\"newacctform.php\" class=\"lightlink\">$text[mnuregister]</a></li>\n";
?>
				</ul><br/>
				</div>
			</td></tr>
		</table>							
	</td>
	<td class="spacercol">&nbsp;&nbsp;&nbsp;</td>
	<td class="content">
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="3">
<?php
	//the "img" line below includes the small picture of the girl at the top right
?>
					<img src="<?php echo $cms['tngpath']; ?>smallphoto.jpg" alt="" class="smallphoto" width="71" height="100" />
					<img src="<?php echo $cms['tngpath']; ?>title.gif" alt="<?php echo $text['ourpages']; ?>" class="banner" width="468" height="100" />
<?php
	//if you prefer text instead of the banner image that says "Our Family Genealogy Pages", remove the "headertitle.gif" line above (the whole line)
	//and remove the <!-- comment marks --> from the lines below, then edit the "Our Family Genealogy Pages" text to have it say what you want
?>
<!--
	<em style="font-family:Verdana,Arial,sans-serif;"><br />

	<span style="color:#990000; font-size:30px; line-height:30px;  font-weight:bold">   Our Family   </span><br />
	<span style="color:#999966; font-size:48px; font-weight:bold">&nbsp;   Genealogy Pages   </span>

	</em>
-->
				</td>
			</tr>
			<tr>
				<td class="section"><br />
					<img src="<?php echo $cms['tngpath']; ?>bigphoto.jpg" alt="" class="bigphoto" width="300" height="172" /><br />
					<span class="smaller">
					&nbsp;&nbsp;<i>Mt. Pleasant, Utah, about 1915</i><br />
					</span>
					<div class="normal">
					<h3>Main Feature</h3>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat 
					volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. 
					Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros 
					et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit a</p>
					</div>
				</td>
				<td class="spacercol">&nbsp;&nbsp;&nbsp;</td>
				<td class="section"><br />
					<table border="0" cellspacing="0" cellpadding="0">
						<tr><td valign="top"><span class="normal"><b><?php echo strtoupper($text['featarts']); ?></b></span></td></tr>
						<tr><td valign="top" class="line"></td></tr>
						<tr><td valign="top"><span class="smallest">&nbsp;</span></td></tr>
						<tr><td valign="top">
							<div class="normal">
							<p><a href="histories/feature1.php"><img src="<?php echo $cms['tngpath']; ?>featurethumb1.gif" alt="feature 1" class="featureimg" /></a>
							<a href="histories/feature1.php"><span class="emphasis">Feature Story 1.</span></a> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.<br /><br />

							<a href="histories/feature2.php"><img src="<?php echo $cms['tngpath']; ?>featurethumb2.gif" alt="feature 2" class="featureimg" /></a>
							<a href="histories/feature2.php"><span class="emphasis">Feature Story 2.</span></a> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.<br /><br />

							<a href="histories/feature3.php"><img src="<?php echo $cms['tngpath']; ?>featurethumb3.gif" alt="feature 3" class="featureimg" /></a>
							<a href="histories/feature3.php"><span class="emphasis">Feature Story 3.</span></a> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.<br /><br />

							<a href="histories/feature4.php"><img src="<?php echo $cms['tngpath']; ?>featurethumb1.gif" alt="feature 4" class="featureimg" /></a>
							<a href="histories/feature4.php"><span class="emphasis">Feature Story 4.</span></a> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.<br /><br /></p>
							</div>
						</td></tr>
						<tr><td valign="top"><span class="normal">&nbsp;</span></td></tr>
						<tr><td valign="top"><span class="normal"><b><?php echo strtoupper($text['contactus']); ?></b></span></td></tr>
						<tr><td valign="top" class="line"></td></tr>
						<tr><td valign="top"><span class="smallest">&nbsp;</span></td></tr>
						<tr><td valign="top">
							<div class="normal">
							<p><img src="<?php echo $cms['tngpath']; ?>email.gif" alt="email image" class="emailimg" />If you have any questions or comments about the information on this site, please
							<span class="emphasis"><a href="suggest.php">contact us</a></span>. We look forward to hearing from you.</p><br />
							</div>
						</td></tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
	<td class="spacercol">&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr><td colspan="4" class="line"></td></tr>
</table><br/>
	<div class="footer">
		<?php echo $text['pwrdby']; ?> <a href="http://lythgoes.net/genealogy/software.php" class="footer">The Next Generation of Genealogy Sitebuilding</a> &copy;, <?php echo $text['writby']; ?> Darrin Lythgoe 2001-<?php echo date('Y') ; ?>.
	</div> <!-- end of footer div -->
</div> <!-- end of center div -->

</body>
</html>
