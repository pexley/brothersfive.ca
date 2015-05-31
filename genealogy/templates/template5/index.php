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

//Change the text in quotes below to reflect the title of your site

tng_header( "Our Family History and Ancestry", $flags );
?>

<body>
<div align="center">
<table class="maintable">
  <tr>
    <td class="row" colspan="4"></td>
  </tr>
  <tr>
    <td class="imagesection">
		</td>
    <td class="spacercol">
		</td>
    <td class="content" colspan="2">

		<table border="0" cellpadding="5" cellspacing="0" width="100%" class="innertable">
      		<tr>
        		<td colspan="2" class="indexheader" >

<!--EDIT PAGE TITLE TEXT BELOW HERE.  EDITS ABOVE THIS LINE WILL AFFECT THE PAGE DESIGN STRUCTURE-->

	Our Family History and Ancestry

<!--EDIT PAGE TITLE TEXT ABOVE HERE.  EDITS BELOW THIS LINE WILL AFFECT THE PAGE DESIGN STRUCTURE-->

      				
			  	</td>
		 	</tr>
      		<tr>
        		<td colspan="2" class="boxback">

<!--EDIT MENU LINKS BELOW HERE.  EDITS ABOVE THIS LINE WILL AFFECT THE PAGE DESIGN STRUCTURE-->

				    <a href="whatsnew.php" class="lightlink2"><?php echo $text['mnuwhatsnew']; ?></a>
                    | <a href="browsemedia.php?mediatypeID=photos" class="lightlink2"><?php echo $text['mnuphotos']; ?></a>
                    | <a href="browsemedia.php?mediatypeID=histories" class="lightlink2"><?php echo $text['mnuhistories']; ?></a>
                    | <a href="browsemedia.php?mediatypeID=documents" class="lightlink2"><?php echo $text['documents']; ?></a>
                    | <a href="browsemedia.php?mediatypeID=videos" class="lightlink2"><?php echo $text['videos']; ?></a>
                    | <a href="browsemedia.php?mediatypeID=recordings" class="lightlink2"><?php echo $text['recordings']; ?></a>
                    | <a href="browsealbums.php" class="lightlink2"><?php echo $text['albums']; ?></a>
                    | <a href="browsemedia.php" class="lightlink2"><?php echo $text['allmedia']; ?></a><br />

<!-- SECOND LINE OF LINKS-->

                    <a href="mostwanted.php" class="lightlink2"><?php echo $text['mostwanted']; ?></a>
                    | <a href="reports.php" class="lightlink2"><?php echo $text['mnureports']; ?></a>
                    | <a href="cemeteries.php" class="lightlink2"><?php echo $text['mnucemeteries']; ?></a>
		            | <a href="browsemedia.php?mediatypeID=headstones" class="lightlink2"><?php echo $text['mnutombstones']; ?></a>
		            | <a href="anniversaries.php" class="lightlink2"><?php echo $text['anniversaries']; ?></a>
		            | <a href="places.php" class="lightlink2"><?php echo $text['places']; ?></a><br />

<!-- THIRD LINE OF LINKS-->

		            <a href="browsenotes.php" class="lightlink2"><?php echo $text['notes']; ?></a>
		            | <a href="browsesources.php" class="lightlink2"><?php echo $text['mnusources']; ?></a>
		            | <a href="browserepos.php" class="lightlink2"><?php echo $text['repositories']; ?></a>
	           		| <a href="browsetrees.php" class="lightlink2"><?php echo $text['mnustatistics']; ?></a>
	           		| <a href="bookmarks.php" class="lightlink2"><?php echo $text['bookmarks']; ?></a>
		            | <a href="suggest.php" class="lightlink2"><?php echo $text['contactus']; ?></a>
<?php
	if( $allow_admin ) {
		echo "| <a href=\"showlog.php\" class=\"lightlink2\">$text[mnushowlog]</a>\n";
		echo "| <a href=\"admin/index.php\" class=\"lightlink2\">$text[mnuadmin]</a>\n";
	}
?>

<!--EDIT MENU LINKS ABOVE HERE.  EDITS BELOW THIS LINE WILL AFFECT THE PAGE DESIGN STRUCTURE-->
					
				</td>
      </tr>
      <tr>
        <td class="leftcontent" rowspan="2">
              <div class="header">

<!--Welcome message-->

              <?php echo $text['welcome']; ?>!

<!--EDIT PARAGRAPH HEADER TEXT ABOVE HERE.  EDITS BELOW THIS LINE WILL AFFECT THE PAGE DESIGN STRUCTURE-->

              </div>
              <div class="normal">

<!--EDIT PARAGRAPH TEXT BELOW HERE.-->

              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed 
              diam nonummy nibh euismod tincidunt ut laoreet dolore magna 
              aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud 
              exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea 
              commodo consequat. Duis autem vel eum iriure dolor in hendrerit in 
              vulputate velit esse molestie consequat, vel illum dolore eu 
              feugiat nulla facilisis at vero eros et accumsan et iusto odio 
              dignissim qui blandit praesent luptatum zzril delenit a.</p>
              <p>If you have any questions or comments about the information on
              this site, <a href="suggest.php">please contact us</a>.
              We look forward to hearing from you.</p>
	  		  <ul>
			  	<?php
					if(!$tngconfig['disallowreg'])
						echo "<li><a href=\"newacctform.php\">$text[mnuregister]</a></li>\n";
					if( $currentuser ) {
						echo "<li><a href=\"logout.php\">$text[mnulogout]</a></li>\n";
					}
					else {
						echo "<li><a href=\"login.php\">$text[mnulogon]</a></li>\n";
					}
					if($chooselang)
						echo "<li><a href=\"changelanguage.php\">$text[mnulanguage]</a></li>\n";
				?>
			  </ul>
			  </div>

<!--EDIT PARAGRAPH TEXT ABOVE HERE.  EDITS BELOW THIS LINE WILL AFFECT THE PAGE DESIGN STRUCTURE-->

        </td>
        <td class="rightcontent">
<?php
	//the "img" tag below includes the medium picture of the couple on the right. Size is width=160px, height=121px
?>
              <img src="<?php echo $cms['tngpath']; ?>mediumphoto.jpg" alt="" class="indexphoto" width="160" height="121" /><br /><br />
              <span class="right" style="margin-right:8px"><?php echo $text['whichbranch']; ?></span></td>
      </tr>
      <tr>
        <td  class="rightcontent">
			<form action="search.php" method="get">
				<table class="indexbox">
					<tr>
						<td class="padding"><span class="boxback"><?php echo $text['mnulastname']; ?>:<br />
							<input type="text" name="mylastname" class="searchbox" size="14" /></span></td></tr>

							<tr><td class="padding"><span class="boxback"><?php echo $text['mnufirstname']; ?>:<br />
							<input type="text" name="myfirstname" class="searchbox" size="14" /></span>
						</td>
					</tr>
					<tr>
						<td class="padding"><span class="normal"><input type="hidden" name="mybool" value="AND" />
						<input type="submit" name="search" value="<?php echo $text['mnusearchfornames']; ?>" class="small" /><br /><br />
						<?php
							echo "<a href=\"surnames.php\" class=\"lightlink2\">$text[mnulastnames]</a><br />\n";
							echo "<a href=\"searchform.php\" class=\"lightlink2\">$text[mnuadvancedsearch]</a>\n";
						?></span>
						</td>	
					</tr>
				</table>
			</form>
		</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="row12"></td>
  </tr>
</table>
<br />
<div class="footer small">
		<?php echo $text['pwrdby']; ?> <a href="http://lythgoes.net/genealogy/software.php" class="footer">The Next Generation of Genealogy Sitebuilding</a> &copy;, <?php echo $text['writby']; ?> Darrin Lythgoe 2001-<?php echo date('Y') ; ?>.
</div> <!-- end of footer div -->
</div> <!-- end of center div -->
</body>

</html>
