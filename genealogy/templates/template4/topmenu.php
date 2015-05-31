<?php global $text, $currentuser, $currentuserdesc, $allow_admin; ?>
<body>

<div align="center">
<table class="page">
<tr><td colspan="4" class="line"></td></tr>
<tr>
	<td class="menuback">
		<a href="searchform.php"><img src="<?php echo $cms['tngpath']; ?>search4.gif" alt="<?php echo $text['mnusearchfornames']; ?>" class="searchimg" /></a>
		<form action="<?php echo $cms['tngpath']; ?>search.php" method="post">
		<table class="menuback">
			<tr><td><span class="fieldname"><?php echo $text['mnulastname']; ?>: <br /><input type="text" name="mylastname" class="searchbox" size="14" /></span></td></tr>
			<tr><td><span class="fieldname"><?php echo $text['mnufirstname']; ?>:<br /><input type="text" name="myfirstname" class="searchbox" size="14" /></span></td></tr>
			<tr><td><input type="hidden" name="mybool" value="AND" /><input type="submit" name="search" value="<?php echo $text['mnusearchfornames']; ?>" class="small" /></td></tr>
		</table>
		</form>
		<table class="menuback">
			<tr>
			<td>
			<div class="fieldname">
				<ul>
				<li><a href="<?php echo "$cms[tngpath]" ?>searchform.php" class="lightlink"><?php echo $text['mnuadvancedsearch']; ?></a></li>
				<li><a href="<?php echo "$cms[tngpath]" ?>surnames.php" class="lightlink"><?php echo $text['mnulastnames']; ?></a></li>
				</ul>
<?php
	if( $currentuser ) {
	    echo "<p><span class=\"emphasisyellow\">&nbsp;&nbsp;$text[welcome], $currentuserdesc.</span></p>\n";
		echo "<ul>\n<li><a href=\"$cms[tngpath]logout.php\" class=\"lightlink\">$text[mnulogout]</a></li>\n";
	}
	else {
		echo "<ul>\n<li><a href=\"$cms[tngpath]login.php\" class=\"lightlink\">$text[mnulogon]</a></li>\n";
	}
	echo "<li><a href=\"$cms[tngpath]whatsnew.php\" class=\"lightlink\">$text[mnuwhatsnew]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]mostwanted.php\" class=\"lightlink\">$text[mostwanted]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsemedia.php?mediatypeID=photos\" class=\"lightlink\">$text[mnuphotos]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsemedia.php?mediatypeID=histories\" class=\"lightlink\">$text[mnuhistories]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsemedia.php?mediatypeID=documents\" class=\"lightlink\">$text[documents]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsemedia.php?mediatypeID=videos\" class=\"lightlink\">$text[videos]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsemedia.php?mediatypeID=recordings\" class=\"lightlink\">$text[recordings]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsealbums.php\" class=\"lightlink\">$text[albums]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsemedia.php\" class=\"lightlink\">$text[allmedia]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]cemeteries.php\" class=\"lightlink\">$text[mnucemeteries]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsemedia.php?mediatypeID=headstones\" class=\"lightlink\">$text[mnutombstones]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]places.php\" class=\"lightlink\">$text[places]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsenotes.php\" class=\"lightlink\">$text[notes]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]anniversaries.php\" class=\"lightlink\">$text[anniversaries]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]reports.php\" class=\"lightlink\">$text[mnureports]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsesources.php\" class=\"lightlink\">$text[mnusources]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browserepos.php\" class=\"lightlink\">$text[repositories]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]browsetrees.php\" class=\"lightlink\">$text[mnustatistics]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]changelanguage.php\" class=\"lightlink\">$text[mnulanguage]</a></li>\n";
	if( $allow_admin ) {
		echo "<li><a href=\"$cms[tngpath]showlog.php\" class=\"lightlink\">$text[mnushowlog]</a></li>\n";
		echo "<li><a href=\"$cms[tngpath]admin/index.php\" class=\"lightlink\">$text[mnuadmin]</a></li>\n";
	}
	echo "<li><a href=\"$cms[tngpath]bookmarks.php\" class=\"lightlink\">$text[bookmarks]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]suggest.php\" class=\"lightlink\">$text[contactus]</a></li>\n";
	echo "<li><a href=\"$cms[tngpath]newacctform.php\" class=\"lightlink\">$text[mnuregister]</a></li>\n";
?>
				</ul>
				</div>
			</td></tr>						
		</table>
	</td>
	<td class="spacercol">&nbsp;&nbsp;&nbsp;</td>
	<td class="content">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td>
					<img src="<?php echo $cms[tngpath]; ?>title.gif" alt="<?php echo $text['ourpages']; ?>" class="banner" width="468" height="100" />
<?php
	//if you prefer text instead of the banner image that says "Our Family Genealogy Pages", remove the "title.gif" line above (the whole line)
	//and remove the <!-- comment marks --> from the lines below, then edit the "Our Family Genealogy Pages" text to have it say what you want
?>
<!--
	<em style="font-family:Verdana,Arial,sans-serif;">

	<span style="color:#990000; font-size:30px; line-height:30px;  font-weight:bold">   Our Family   </span><br />
	<span style="color:#999966; font-size:48px; font-weight:bold">&nbsp;   Genealogy Pages   </span>

	</em>
-->

				</td>
<?php
	//the "img" tag below includes the small picture of the girl at the top right
?>
				<td><img src="<?php echo $cms['tngpath']; ?>smallphoto.jpg" alt="" class="smallphoto" width="71" height="100" /></td>
			</tr>
			<tr><td colspan="4" class="line"></td></tr>
			<tr>
				<td colspan="2">
						<div class="normal"><br />
<!-- topmenu for template 4 -->
