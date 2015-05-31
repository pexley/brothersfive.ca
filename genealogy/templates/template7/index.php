<?php
include("begin.php");
include_once("genlib.php");
include($cms[tngpath] . "getlang.php");
include($cms[tngpath] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms[tngpath] . "checklogin.php");

$flags['noicons'] = true;
$flags['noheader'] = true;
$flags['nobody'] = true;

//default header ($text['ourpages']) is "Our Family Genealogy Pages"
tng_header( $text['ourpages'], $flags );
?>
<body>

<div class="center">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="headertitle">
			<tr class="row">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
 							<td class="logo"><img src ="<?php echo $cms['tngpath'] ; ?>logo.jpg" alt="Our Family History" /></td>
<?php
	//if you prefer text instead of the banner image that says "Our Family History", remove the "logo.gif" line above (the whole line)
	//and remove the <!-- comment marks --> from the lines below, then edit the "Our Family Genealogy Pages" text to have it say what you want
?>
<!--
<td class="logo" style="padding:10px;background:url(logoedge.gif) no-repeat right #DCD5B9;" width="400">
	<em style="font-family:Verdana,Arial,sans-serif;font-size:30px;line-height:30px;">

	Our Family<br />History

	</em>
</td>
-->
							<td class="news"><span class="emphasis"><?php echo $text['news'] ; ?>:</span> This section can be used for brief news announcements</td>
						</tr>
					</table>
			<form action="search.php" method="get" style="margin:0px">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">			<tr class="bar">
						<td class="fieldnameback"><span class="fieldname"><?php echo $text['mnulastname']; ?>: <input type="text" name="mylastname" size="18" /> <?php echo $text['mnufirstname']; ?>: <input type="text" name="myfirstname" size="14" />
				<input type="hidden" name="mybool" value="AND" /><input type="hidden" name="offset" value="0" /><input type="submit" name="search" value="<?php echo $text['mnusearch']; ?>" />
				
					
					</span>
				</td>
			</tr>
		</table>
			</form>
				</td>
			</tr>
			</table>
		
		<table border="0" cellspacing="0" cellpadding="0" class="page" width="100%">
			<tr>
				<td class="section">
					
						<table width="193" border="0" cellspacing="0" cellpadding="0" >
							<tr>
								<td class="tableheader"></td>
								<td class="fieldname">
								<?php
	if( $currentuser ) {
		echo "<a href=\"logout.php\" class=\"lightlink\">$text[mnulogout]</a><br />\n";
	}
	else {
		echo "<a href=\"login.php\" class=\"lightlink\">$text[mnulogon]</a><br />\n";
	}
	echo "<a href=\"searchform.php\" class=\"lightlink\">$text[mnuadvancedsearch]</a><br />\n";
	echo "<a href=\"surnames.php\" class=\"lightlink\">$text[mnulastnames]</a><br />\n";
	echo "<a href=\"whatsnew.php\" class=\"lightlink\">$text[mnuwhatsnew]</a><br />\n";
	echo "<a href=\"mostwanted.php\" class=\"lightlink\">$text[mostwanted]</a><br />\n";
	echo "<a href=\"browsemedia.php?mediatypeID=photos\" class=\"lightlink\">$text[mnuphotos]</a><br />\n";
	echo "<a href=\"browsemedia.php?mediatypeID=histories\" class=\"lightlink\">$text[mnuhistories]</a><br />\n";
	echo "<a href=\"browsemedia.php?mediatypeID=documents\" class=\"lightlink\">$text[documents]</a><br />\n";
	echo "<a href=\"browsemedia.php?mediatypeID=videos\" class=\"lightlink\">$text[videos]</a><br />\n";
	echo "<a href=\"browsemedia.php?mediatypeID=recordings\" class=\"lightlink\">$text[recordings]</a><br />\n";
	echo "<a href=\"browsealbums.php\" class=\"lightlink\">$text[albums]</a><br />\n";
	echo "<a href=\"browsemedia.php\" class=\"lightlink\">$text[allmedia]</a><br />\n";
	echo "<a href=\"cemeteries.php\" class=\"lightlink\">$text[mnucemeteries]</a><br />\n";
	echo "<a href=\"browsemedia.php?mediatypeID=headstones\" class=\"lightlink\">$text[mnutombstones]</a><br />\n";
	echo "<a href=\"places.php\" class=\"lightlink\">$text[places]</a><br />\n";
	echo "<a href=\"browsenotes.php\" class=\"lightlink\">$text[notes]</a><br />\n";
	echo "<a href=\"anniversaries.php\" class=\"lightlink\">$text[anniversaries]</a><br />\n";
	echo "<a href=\"reports.php\" class=\"lightlink\">$text[mnureports]</a><br />\n";
	echo "<a href=\"browsesources.php\" class=\"lightlink\">$text[mnusources]</a><br />\n";
	echo "<a href=\"browserepos.php\" class=\"lightlink\">$text[repositories]</a><br />\n";
	echo "<a href=\"browsetrees.php\" class=\"lightlink\">$text[mnustatistics]</a><br />\n";
	echo "<a href=\"changelanguage.php\" class=\"lightlink\">$text[mnulanguage]</a><br />\n";
	if( $allow_admin ) {
		echo "<a href=\"showlog.php\" class=\"lightlink\">$text[mnushowlog]</a><br />\n";
		echo "<a href=\"admin/index.php\" class=\"lightlink\">$text[mnuadmin]</a><br />\n";
	}
	echo "<a href=\"bookmarks.php\" class=\"lightlink\">$text[bookmarks]</a><br />\n";
	echo "<a href=\"suggest.php\" class=\"lightlink\">$text[contactus]</a><br />\n";
	echo "<a href=\"newacctform.php\" class=\"lightlink\">$text[mnuregister]</a><br />\n";
?></td>
							</tr>
						
					</table>
				</td>
				<td valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td colspan="2"></td>
							</tr>
							<tr>
	<td class="spacercol">&nbsp;&nbsp;&nbsp;</td>
	<td valign="top">
		<table border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="3" class="main">
					
				</td>
			</tr>
			<tr>
				<td class="maincontent"><br />
					<img src="<?php echo $cms['tngpath']; ?>bigphoto.jpg" alt="" class="bigphoto" /><br />
					<span class="smaller">
					&nbsp;&nbsp;<i>Mt. Pleasant, Utah, about 1915</i><br />
					</span>
					<div class="normal">
					<h3 class="emphasis">Main Feature</h3>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat 
					volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. 
					Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros 
					et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit a</p>
					
					</div> <!-- end of normal div -->
				</td>
				<td class="middlecol">&nbsp;&nbsp;&nbsp;</td>
				<td class="rightcontent"><br />
					<table width="200" border="0" cellspacing="0" cellpadding="0">
						<tr>
													<td valign="top"><span class="emphasis"><?php echo $text['latupdates']; ?></span></td>
												</tr>
		<tr>
				<td colspan="4" class="line"></td>		</tr>
												<tr><td><span class="smallest">&nbsp;</span></td></tr>
												<tr><td valign="top">
							<div class="normal">
					<?php
					$tngquery = "SELECT lastname, firstname, changedate, personID, gedcom, living, lnprefix, title, suffix, prefix FROM $people_table ORDER BY changedate DESC LIMIT 10";
					$resulttng = mysql_query( $tngquery ) or die( "$text[cannotexecutequery]: $tngquery" );

					$found = mysql_num_rows( $resulttng );
					while( $dbrow = mysql_fetch_assoc( $resulttng ) ) {
						$lastadd .= "<a href=\"getperson.php?personID=$dbrow[personID]&amp;tree=$dbrow[gedcom]\">";
						$rightbranch = checkbranch( $dbrow[branch] ) ? 1 : 0;
						$dbrow[allow_living] = !$dbrow[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
						$lastadd .= getNameRev($dbrow);
						$lastadd .= "</a><br />\n";
					}
					mysql_free_result($resulttng);
					echo $lastadd
					?>
							
							</div> <!-- end of normal div -->
						</td></tr>
												<tr><td valign="top"><span class="normal">&nbsp;</span></td></tr>
						<tr><td valign="top"><span class="emphasis"><?php echo $text['featphoto']; ?></span></td></tr>
						<tr>
							<td colspan="4" class="line"></td>
							</tr>
						<tr><td><span class="smallest">&nbsp;</span></td></tr>
						<tr><td valign="top">
							<div class="normal">

	<?php
	    include("randomphoto.php"); // randomphoto code removed and replaced with include from userscripts directory Ken Roy
	?>
							
							</div>
						</td></tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
	<td class="spacerol">&nbsp;&nbsp;</td>
</tr>
</table>
	</td>
	</tr>
	</table>

	<hr />
	<div class="footer">
		<?php echo $text['pwrdby']; ?> <a href="http://lythgoes.net/genealogy/software.php" class="footer">The Next Generation of Genealogy Sitebuilding</a> &copy;, <?php echo $text['writby']; ?> Darrin Lythgoe 2001-<?php echo date('Y') ; ?>.
	</div> <!-- end of footer div -->
</div> <!-- end of center div -->

</body>
</html>
