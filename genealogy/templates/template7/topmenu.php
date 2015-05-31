<?php global $text, $currentuser, $allow_admin; ?>
<body>

<div class="center">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="headertitle">
			<tr class="row">
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="logo"><img src ="<?php echo $cms['tngpath']; ?>logo.jpg" alt="" /></td>
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
			<form action="<?php echo $cms['tngpath']; ?>search.php" method="get" style="margin:0px">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">			<tr class="bar">
						<td class="fieldnameback"><span class="fieldname">&nbsp;&nbsp;&nbsp;<?php echo $text['mnulastname']; ?>: <input type="text" name="mylastname" size="18" />&nbsp; <?php echo $text['mnufirstname']; ?>: <input type="text" name="myfirstname" size="14" />
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
					
				<table width="193" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="tableheader"></td>
						<td class="fieldname">
						<?php
	if( $currentuser ) {
		echo "<a href=\"$cms[tngpath]logout.php\" class=\"lightlink\">$text[mnulogout]</a><br />\n";
	}
	else {
		echo "<a href=\"$cms[tngpath]login.php\" class=\"lightlink\">$text[mnulogon]</a><br />\n";
	}
	echo "<a href=\"$cms[tngpath]searchform.php\" class=\"lightlink\">$text[mnuadvancedsearch]</a><br />\n";
	echo "<a href=\"$cms[tngpath]surnames.php\" class=\"lightlink\">$text[mnulastnames]</a><br />\n";
	echo "<a href=\"$cms[tngpath]whatsnew.php\" class=\"lightlink\">$text[mnuwhatsnew]</a><br />\n";
	echo "<a href=\"$cms[tngpath]mostwanted.php\" class=\"lightlink\">$text[mostwanted]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsemedia.php?mediatypeID=photos\" class=\"lightlink\">$text[mnuphotos]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsemedia.php?mediatypeID=histories\" class=\"lightlink\">$text[mnuhistories]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsemedia.php?mediatypeID=documents\" class=\"lightlink\">$text[documents]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsemedia.php?mediatypeID=videos\" class=\"lightlink\">$text[videos]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsemedia.php?mediatypeID=recordings\" class=\"lightlink\">$text[recordings]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsealbums.php\" class=\"lightlink\">$text[albums]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsemedia.php\" class=\"lightlink\">$text[allmedia]</a><br />\n";
	echo "<a href=\"$cms[tngpath]cemeteries.php\" class=\"lightlink\">$text[mnucemeteries]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsemedia.php?mediatypeID=headstones\" class=\"lightlink\">$text[mnutombstones]</a><br />\n";
	echo "<a href=\"$cms[tngpath]places.php\" class=\"lightlink\">$text[places]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsenotes.php\" class=\"lightlink\">$text[notes]</a><br />\n";
	echo "<a href=\"$cms[tngpath]anniversaries.php\" class=\"lightlink\">$text[anniversaries]</a><br />\n";
	echo "<a href=\"$cms[tngpath]reports.php\" class=\"lightlink\">$text[mnureports]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsesources.php\" class=\"lightlink\">$text[mnusources]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browserepos.php\" class=\"lightlink\">$text[repositories]</a><br />\n";
	echo "<a href=\"$cms[tngpath]browsetrees.php\" class=\"lightlink\">$text[mnustatistics]</a><br />\n";
	echo "<a href=\"$cms[tngpath]changelanguage.php\" class=\"lightlink\">$text[mnulanguage]</a><br />\n";
	if( $allow_admin ) {
		echo "<a href=\"$cms[tngpath]showlog.php\" class=\"lightlink\">$text[mnushowlog]</a><br />\n";
		echo "<a href=\"$cms[tngpath]admin/index.php\" class=\"lightlink\">$text[mnuadmin]</a><br />\n";
	}
	echo "<a href=\"$cms[tngpath]bookmarks.php\" class=\"lightlink\">$text[bookmarks]</a><br />\n";
	echo "<a href=\"$cms[tngpath]suggest.php\" class=\"lightlink\">$text[contactus]</a><br />\n";
	echo "<a href=\"$cms[tngpath]newacctform.php\" class=\"lightlink\">$text[mnuregister]</a><br />\n";
?></td>
							</tr>
						
					</table>
				</td>
				<td valign="top">
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td colspan="2"><div class="normal"><br />
<!-- end of topmenu.php for template 7 -->
