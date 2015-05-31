<?php

// PLEASE NOTE: This page only contains the content of your main page.  If you are trying to make changes
//    to the header, you will need to edit topmenu.php.  If you want to edit the footer, edit footer.php

include("begin.php");
include($cms['tngpath'] . "genlib.php");
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

echo tng_header($text['mnuheader'], '');
?>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
	<td class="section">
	<img src="<?php echo $cms['tngpath']; ?>header_welcome.gif" width="200" height="50" alt="" /><br />
	<span class="normal">

<!-- ADD YOUR WELCOME TEXT BELOW -->

This is where you can welcome the user to your site.<br />

<!-- ADD YOUR WELCOME TEXT ABOVE -->

	<br />
	<br />
	</span>
	<img src="<?php echo $cms['tngpath']; ?>header_search.gif" width="200" height="50" alt="" /><br />
	<span class="normal">

<!-- ADD TEXT ABOUT SEARCHING BELOW -->

To search the genealogy database, enter a name below. You will find many families!</span>

<!-- ADD TEXT ABOUT SEARCHING ABOVE -->

	 <br /><br />
	 <form id="form1" method="post" action="<?php echo $cms['tngpath']; ?>search.php">
	    <div><input type="hidden" value="AND" name="mybool" />
	    <table width="297" border="0" cellspacing="0" cellpadding="0">
	    <tr>
		<td >First name: </td>
		<td class="searchbox"><input name="myfirstname" type="text" id="myfirstname" /></td>
          
	    </tr>
	    <tr>
		<td class="normal">Last name: </td>
		<td class="searchbox"><input name="mylastname" type="text" id="mylastname" /></td>
		<td rowspan="2" ><input type="image" name="imageField" src="<?php echo $cms['tngpath']; ?>searchbutton.gif"/></td>
	    </tr>
	    </table>
	</div></form>    <!-- <div added for strict KCR -->
	    <p class="center">[<a href="<?php echo $cms['tngpath']; ?>surnames.php"><?php echo $text['mnulastnames']; ?></a>] [<a href="<?php echo $cms['tngpath']; ?>searchform.php"><?php echo $text['mnuadvancedsearch']; ?></a>]<br />
	    [<a href="http://tngnetwork.lythgoes.net/index.php"><?php echo $text['searchtngnet']; ?></a> ] </p>
	</td>
	<td class="section">

<!-- RANDOM PHOTO CODE STARTS HERE -->
<!-- If you don't want to have a random photo displayed, just remove this section down to 'RANDOM PHOTO CODE ENDS HERE' -->

	<img src="<?php echo $cms['tngpath']; ?>header_featphoto.gif" width="200" height="50" alt="" /><br />
<!--	<center> ** removed since there is not a good way to center images -->
	<?php
	    include("randomphoto.php"); // moved to userscripts directory KCR
	?>
	<p class="center">[<a href="browsemedia.php?mediatypeID=photos"><?php echo $text['viewphotos']; ?></a>]</p>
<!--	</center> ** removed since there is not a good way to center images -->

<!-- RANDOM PHOTO CODE ENDS HERE -->

      <p class="normal"><img src="<?php echo $cms['tngpath']; ?>header_famhist.gif" width="200" height="50" alt="" /><br/>

<!-- ADD TEXT ABOUT FAMILY HISTORIES BELOW -->

      You can use this section to link to some of your more interesting family histories.  Note the icons <img src="<?php echo $cms['tngpath']; ?>photo.gif" width="14" height="12" alt="" /> for photos and <img src="<?php echo $cms['tngpath']; ?>doc.gif" width="11" height="13" alt="" /> for histories when they are available for an individual.</p>

<!-- ADD TEXT ABOUT FAMILY HISTORIES ABOVE -->

      <table width="250" border="0" cellspacing="0" cellpadding="0">
	<tr>

<!-- CHANGE 'His side' AND 'Her size' TO THE TWO BRANCHES YOU WILL LIST HISTORIES FOR BELOW -->

	    <td class="emphasis">His side</td>
	    <td class="emphasis">Her side</td>

<!-- CHANGE 'His side' AND 'Her size' TO THE TWO BRANCHES YOU WILL LIST HISTORIES FOR ABOVE -->

	</tr>
	<tr class="row5">
	    <td colspan="2"></td>
	</tr>

<!-- EDIT LINKS TO PARTICULAR INDIVIDUAL HISTORIES YOU WANT TO LINK TO BELOW -->
<!-- CHANGE tree=yourtreeid to match your tree ID -->
        <tr>
            <td><p class="normal"><a href="<?php echo $cms['tngpath']; ?>extrastree.php?personID=I1&amp;tree=T0001&amp;showall=1">Individual 1</a></p></td>
            <td><p class="normal"><a href="<?php echo $cms['tngpath']; ?>extrastree.php?personID=I2&amp;tree=T0001&amp;showall=1">Individual 2</a></p> </td>
        </tr>

<!-- EDIT LINKS TO PARTICULAR INDIVIDUAL HISTORIES YOU WANT TO LINK TO ABOVE -->

<!-- YOU CAN ADD NEW ROWS BY COPYING THE LINES BETWEEN <TR> AND </TR>.  TO CREATE AN EMPTY SPACE JUST PUT &nbsp; BETWEEN <TD> AND </TD>.  FOR EXAMPLE... -->

        <tr>
            <td><p class="normal"><a href="extrastree.php?personID=I3&amp;tree=T0001&amp;showall=1" >Individual 3</a></p> </td>
            <td>&nbsp;</td>
        </tr>

<!-- END OF EXAMPLE -->

      </table>
      <p>&nbsp;</p></td>
      <td class="section">
	<p class="normal"><img src="<?php echo $cms['tngpath']; ?>header_mostwanted.gif" width="200" height="50" alt="" /><br />

<!-- ADD TEXT ABOUT 'MOST WANTED' INDIVIDUALS BELOW -->

	Use this section to display information about individuals you are actively researching.</p>

<!-- ADD TEXT ABOUT 'MOST WANTED' INDIVIDUALS ABOVE -->

	<p class="center">[<a href="<?php echo $cms['tngpath']; ?>mostwanted.php"><?php echo $text['mostwanted']; ?></a>] </p> <!-- moved to userscripts directory KCR -->
	<p class="normal"><img src="<?php echo $cms['tngpath']; ?>header_resources.gif" width="200" height="50" alt="" /><br/>

<!-- ADD TEXT ABOUT RESOURCES BELOW -->

List resources here that you would like to share with others.</p>

<!-- ADD TEXT ABOUT RESOURCES ABOVE -->

	<span class="normal">

<!-- ADD LINKS TO YOUR FAVORITE RESOURCES BELOW.  I'VE ADDED A FEW EXAMPLES TO GET YOU STARTED. -->

	<a href="http://www.ancestry.com" target="_blank">Ancestry.com</a><br />
	<a href="http://www.footnote.com" target="_blank">Footnote.com</a><br />
	<a href="http://lythgoes.net/genealogy/software.php" target="_blank">TNG Software</a>

<!-- ADD LINKS TO YOUR FAVORITE RESOURCES ABOVE. -->

	</span>
    </td>
  </tr>
</table>

<?php
echo tng_footer('');
?>
