<?php global $text; ?>
<body class="bodytopmenu">

<table border="0" cellspacing="0" cellpadding="0" class="page" width="100%">
	<tr>
		<td>&nbsp;</td>
		<td valign="top">

<?php
	//the "img" line below includes the small picture of the girl at the top left
?>
			<img src="<?php echo $cms['tngpath']; ?>headerphoto.jpg" alt="" class="headerimg" width="70" height="99" />

		</td>
		<td align="center" valign="top">
			<table cellspacing="0" cellpadding="0">
				<tr><td align="center"><a href="index.php">
				<img src="<?php echo $cms['tngpath']; ?>headertitle.gif" alt="<?php echo $text['ourpages']; ?>" width="312" height="78" class="noimgborder" />
<?php
	//if you prefer text instead of the banner image that says "Our Family Genealogy Pages", remove the "headertitle.gif" line above (the whole line)
	//and remove the <!-- comment marks --> from the lines below, then edit the "Our Family Genealogy Pages" text to have it say what you want
?>
<!--
	<em style="text-decoration:none;font-size:30px; font-family:Verdana,Arial,sans-serif; color:#FFE9A9;">

	Our Family<br />Genealogy Pages

	</em>
-->
				</a></td></tr>
				<tr>
					<td align="center" valign="bottom">
						<span class="topmenu">
						<br />
						<a href="<?php echo $cms['tngpath']; ?>index.php" class="topmenu"><?php echo $text['mnuheader']; ?></a>
						&nbsp;|&nbsp;
						<a href="<?php echo $cms['tngpath']; ?>whatsnew.php" class="topmenu"><?php echo $text['mnuwhatsnew']; ?></a>
						&nbsp;|&nbsp;
						<a href="<?php echo $cms['tngpath']; ?>browsemedia.php?mediatypeID=photos" class="topmenu"><?php echo $text['mnuphotos']; ?></a>
						&nbsp;|&nbsp;
						<a href="<?php echo $cms['tngpath']; ?>browsemedia.php?mediatypeID=histories" class="topmenu"><?php echo $text['mnuhistories']; ?></a>
						&nbsp;|&nbsp;
						<a href="<?php echo $cms['tngpath']; ?>browsemedia.php?mediatypeID=headstones" class="topmenu"><?php echo $text['mnutombstones']; ?></a>
						&nbsp;|&nbsp;
						<a href="<?php echo $cms['tngpath']; ?>reports.php" class="topmenu"><?php echo $text['mnureports']; ?></a>
						&nbsp;|&nbsp;
						<a href="<?php echo $cms['tngpath']; ?>surnames.php" class="topmenu"><?php echo $text['mnulastnames']; ?></a>
						</span>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" align="right">
			<form action="search.php" method="get" id="topsearch" style="margin:0px">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<td class="topmenu">
						<img src="<?php echo $cms['tngpath']; ?>search-header.gif" alt="" class="menusearch" /><br />
						<?php echo $text['firstname']; ?>:<br /><input type="text" name="myfirstname" class="searchbox" size="10" /><br />
						<img src="<?php echo $cms['tngpath']; ?>spacer.gif" alt="" width="100%" height="3" /><br />
						<?php echo $text['lastname']; ?>: <br /><input type="text" name="mylastname" size="10" class="searchbox" /><br />
						<input type="hidden" name="mybool" value="AND" />
					</td>
					<td><br /><br /><input type="image" name="imgsubmit" src="<?php echo $cms['tngpath']; ?>button-header.jpg" class="menusubmit" /></td>
				</tr>
			</table>
		</form>
		</td>
	</tr>
	<tr><td colspan="4" class="tabletopedge"></td></tr>

	<tr><td colspan="4" class="tablebkground">
			<table cellspacing="0" cellpadding="10" width="100%">
				<tr>
					<td>
						  <div class="normal">  
<!-- end topmenu.php for template 2 -->
