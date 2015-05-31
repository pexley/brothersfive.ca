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
tng_header( $text['ourpages'], $flags );
?>

<body class="bodyindex">

<script type="text/javascript">
pedigreeoff = new Image(162,24);
pedigreeoff.src = "pedigreeoff.gif";
pedigreeon = new Image(162,24);
pedigreeon.src = "pedigreeon.gif";

photosoff = new Image(193,24);
photosoff.src = "photosoff.gif";
photoson = new Image(193,24);
photoson.src = "photoson.gif";

function swap(x, y)
{
	document.images[x].src=eval(y+'.src');
}
</script>

<div class="center">
<table cellspacing="0" cellpadding="2" class="indexpage">
	<tr>
		<td valign="top">
			<table cellspacing="0" cellpadding="0" class="databack">
				<tr>
					<td valign="top">
						<img src="<?php echo $cms['tngpath']; ?>homeheader.gif" alt="" width="443" height="114" class="noimgborder" />
<?php
	//if you prefer text instead of the banner image that says "Our Family Genealogy Pages", remove the "homeheader.gif" line above (the whole line)
	//and remove the <!-- comment marks --> from the lines below, then edit the "Our Family Genealogy Pages" text to have it say what you want
?>
<!--
	<div style="padding:10px">
	<em style="font-size:48px; font-family:Verdana,Arial,sans-serif; color:#676037; line-height:52px;">

	Our Family<br />Genealogy Pages

	</em>
	</div>
-->
						<br /><br /><br />

	<!-- PEDIGREE LINK: In the following line, substitute the personID and tree ID of the person where you want the pedigree to start.
		For example, if you want it to point to person I123 in the "smith" tree, change the link to: "pedigree.php?personID=I123&tree=smith" -->

						&nbsp;&nbsp;&nbsp;<a href="pedigree.php?personID=I1&amp;tree=T0001" onmouseover="swap('pedigree','pedigreeon');" onmouseout="swap('pedigree','pedigreeoff');"><img
						src="<?php echo $cms['tngpath']; ?>pedigreeoff.gif" alt="" id="pedigree" width="162" height="24" class="noimgborder" /></a>

	<!-- PHOTOS & HISTORIES LINK: In the following line, substitute the personID and tree ID of the person where you want the chart to start.
		For example, if you want it to point to person I123 in the "smith" tree, change the link to: "extrastree.php?personID=I123&tree=smith" -->

						<a href="extrastree.php?personID=I1&amp;tree=T0001" onmouseover="swap('photos','photoson');" onmouseout="swap('photos','photosoff');"><img
						src="<?php echo $cms['tngpath']; ?>photosoff.gif" alt="" id="photos" width="193" height="24" class="noimgborder" /></a>

						<br /><br />
						<table cellspacing="4" cellpadding="0">
							<tr>
								<td rowspan="6">&nbsp;&nbsp;&nbsp;</td>
								<td valign="top">
<?php
									if( $currentuser ) {
										echo "<a href=\"logout.php\" class=\"sidelink\">" . strtoupper($text['mnulogout']) . "</a>\n";
									}
									else {
										echo "<a href=\"login.php\" class=\"sidelink\">" . strtoupper($text['mnulogon']) . "</a>\n";
									}
?>
								</td><td>&nbsp;&nbsp;</td>
								<td valign="top"><a href="whatsnew.php" class="sidelink"><?php echo $text['mnuwhatsnew']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="browsetrees.php" class="sidelink"><?php echo $text['mnustatistics']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="anniversaries.php" class="sidelink"><?php echo $text['anniversaries']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
							</tr>
							<tr>
								<td valign="top"><a href="browsemedia.php?mediatypeID=photos" class="sidelink"><?php echo $text['mnuphotos']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="browsemedia.php?mediatypeID=histories" class="sidelink"><?php echo $text['mnuhistories']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="cemeteries.php" class="sidelink"><?php echo $text['mnucemeteries']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="places.php" class="sidelink"><?php echo $text['places']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
							</tr>
							<tr>
								<td valign="top"><a href="browsemedia.php?mediatypeID=documents" class="sidelink"><?php echo $text['documents']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="browsemedia.php" class="sidelink"><?php echo $text['allmedia']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="browsemedia.php?mediatypeID=headstones" class="sidelink"><?php echo $text['mnutombstones']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="browsealbums.php" class="sidelink"><?php echo $text['albums']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
							</tr>
							<tr>
								<td valign="top"><a href="reports.php" class="sidelink"><?php echo $text['mnureports']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="browsesources.php" class="sidelink"><?php echo $text['mnusources']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="bookmarks.php" class="sidelink"><?php echo $text['bookmarks']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="suggest.php" class="sidelink"><?php echo $text['contactus']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
							</tr>
							<tr>
								<td valign="top"><a href="mostwanted.php" class="sidelink"><?php echo $text['mostwanted']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="browserepos.php" class="sidelink"><?php echo $text['repositories']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="showlog.php" class="sidelink"><?php if( $allow_admin ) echo $text['mnushowlog']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top"><a href="admin/index.php" class="sidelink"><?php if( $allow_admin ) echo $text['mnuadmin']; ?></a>&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td>
							</tr>
							<tr>
								<td valign="top" colspan="4"><a href="newacctform.php" class="sidelink"><?php echo $text['mnuregister']; ?></a></td><td>&nbsp;&nbsp;&nbsp;</td>
							</tr>
						</table><br />

						<form action="search.php" method="get" id="form1">
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;&nbsp;&nbsp;</td>
								<td valign="top" align="center">
									<img src="<?php echo $cms['tngpath']; ?>search.jpg" alt="Search" class="indexsearch" /><br />
									<table cellspacing="6" cellpadding="0">
										<tr><td align="center"><a href="searchform.php" class="sidelink"><?php echo $text['mnuadvancedsearch']; ?></a></td></tr>
										<tr><td align="center"><a href="surnames.php" class="sidelink"><?php echo $text['mnulastnames']; ?></a></td></tr>
									</table>
								</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>
									<span class="small"><?php echo $text['firstname']; ?>:<br />
									<input type="text" name="myfirstname" size="14" class="searchbox" /><br />
									<img src="<?php echo $cms['tngpath']; ?>spacer.gif" alt="" width="1" height="4" class="noimgborder" /><br /><?php echo $text['lastname']; ?>:<br />
									<input type="text" name="mylastname" class="searchbox" /><br />
									<input type="hidden" name="mybool" value="AND" />
									</span>
								</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td><input type="image" name="imgsubmit" src="<?php echo $cms['tngpath']; ?>button.jpg" class="indexsubmit" alt="" /></td>
							</tr>
						</table>
					  </form>
						
					</td>
					<td valign="top">
<?php
	//the "img" line below includes the large picture of the girl on the right side of the page
?>
						<img src="<?php echo $cms['tngpath']; ?>mainphoto.jpg" alt="" width="327" height="460" class="noimgborder" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div class="footer">
<p><a href="changelanguage.php" class="footer"><?php echo $text['mnulanguage']; ?></a></p>

<p>
<?php echo $text['pwrdby']; ?> <a href="http://lythgoes.net/genealogy/software.php" class="footer">The Next Generation of Genealogy Sitebuilding</a> &copy;, <?php echo $text['writby']; ?> Darrin Lythgoe 2001-<?php echo date('Y') ; ?>.
</p>
</div> <!-- end footer div -->
</div> <!-- end of center div -->
<script type="text/javascript">
	document.forms.form1.myfirstname.focus();
</script>

</body>
</html>
