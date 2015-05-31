<?php global $text, $cms; ?>
<body>
<table width="100%" cellspacing="0" cellpadding="5" class="tableborder">
	<tr>
		<td class="t3hdr">
<?php
	//the "img" line below includes the small picture of the town at the top left
?>
			<img src="<?php echo $cms['tngpath']; ?>headerphoto.jpg" alt="" class="headerphoto" width="186" height="110" />
		</td>
		<td class="topmenu">
			<img src="<?php echo $cms['tngpath']; ?>headertitle.gif" alt="" class="menutitle"  />
<?php
	//if you prefer text instead of the banner image that says "Our Family Genealogy Pages", remove the "headertitle.gif" line above (the whole line)
	//and remove the <!-- comment marks --> from the lines below, then edit the "Our Family Genealogy Pages" text to have it say what you want
?>
<!--
	<em style="font-size:48px; font-family:Verdana,Arial,sans-serif; color:#39692A;">

	Our Family History

	</em><br />
-->
			<br />
			<a href="<?php echo $cms['tngpath']; ?>index.php" class="topmenu"><?php echo $text['homepage']; ?></a> |
			<a href="<?php echo $cms['tngpath']; ?>whatsnew.php" class="topmenu"><?php echo $text['mnuwhatsnew']; ?></a> |
			<a href="<?php echo $cms['tngpath']; ?>browsemedia.php?mediatypeID=photos" class="topmenu"><?php echo $text['mnuphotos']; ?></a> |
			<a href="<?php echo $cms['tngpath']; ?>browsemedia.php?mediatypeID=histories" class="topmenu" ><?php echo $text['mnuhistories']; ?></a> |
			<a href="<?php echo $cms['tngpath']; ?>browsesources.php" class="topmenu"><?php echo $text['mnusources']; ?></a> |
			<a href="<?php echo $cms['tngpath']; ?>reports.php" class="topmenu"><?php echo $text['mnureports']; ?></a> |
			<a href="<?php echo $cms['tngpath']; ?>cemeteries.php" class="topmenu"><?php echo $text['mnucemeteries']; ?></a> |
			<a href="<?php echo $cms['tngpath']; ?>browsemedia.php?mediatypeID=headstones" class="topmenu"><?php echo $text['mnutombstones']; ?></a> |
			<a href="<?php echo $cms['tngpath']; ?>browsetrees.php" class="topmenu"><?php echo $text['mnustatistics']; ?></a> |
			<a href="<?php echo $cms['tngpath']; ?>surnames.php" class="topmenu"><?php echo $text['mnulastnames']; ?></a>
		</td>
	</tr>
</table>
<!-- end of topmenu.php for template 3 -->
