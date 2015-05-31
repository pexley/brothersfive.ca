<?php
include("../subroot.php");
include($subroot . "config.php");
$tngconfig['maint'] = "";
include("adminlib.php");
$textpart = "index";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
if( $link )
	include("checklogin.php");

$genmsg = "";
if( $allow_add ) $genmsg .= "$admtext[add] | ";
$genmsg .= "$admtext[find2] | ";
if( $allow_edit ) $genmsg .= "$admtext[edit] | ";
if( $allow_delete ) $genmsg .= "$admtext[text_delete] | ";
$sourcesmsg = $peoplemsg = $familiesmsg = $treesmsg = $cemeteriesmsg = $timelinemsg = $placesmsg = $genmsg;
$genmsg .= "$admtext[text_sort] | ";
$photosmsg = $historiesmsg = $headstonesmsg = $genmsg;
if( $allow_edit ) {
	$peoplemsg .= "$admtext[review] | ";
	$familiesmsg .= "$admtext[review] | ";
}
if( $allow_edit && $allow_delete ) {
	$peoplemsg .= "$admtext[merge] | ";
	$placesmsg .= "$admtext[merge] | ";
	$sourcesmsg .= "$admtext[merge] | ";
}
$treesmsg = substr( $treesmsg, 0, -3 );
$peoplemsg = substr( $peoplemsg, 0, -3 );
$familiesmsg = substr( $familiesmsg, 0, -3 );
$sourcesmsg = substr( $sourcesmsg, 0, -3 );
$cemeteriesmsg = substr( $cemeteriesmsg, 0, -3 );
$placesmsg = substr( $placesmsg, 0, -3 );
$photosmsg = substr( $photosmsg, 0, -3 );
$historiesmsg = substr( $historiesmsg, 0, -3 );
$headstonesmsg = substr( $headstonesmsg, 0, -3 );
$timelinemsg = substr( $timelinemsg, 0, -3 );

tng_adminheader( $admtext[administration], "" );
?>
</head>

<body background="../background.gif">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" width="50%" style="min-width:320px">
			<table border="0" cellpadding="5" cellspacing="5" width="100%">
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="people.php" class="lightlink2"><img src="people_icon.gif" alt="<?php echo $admtext[people]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[people]; ?></strong></span><br/>
						<span class="smaller"><?php echo $peoplemsg; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="families.php" class="lightlink2"><img src="families_icon.gif" alt="<?php echo $admtext[families]; ?>" width="40" height="40" hspace="5" border="1" align="left" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[families]; ?></strong></span><br/>
						<span class="smaller"><?php echo $familiesmsg; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="sources.php" class="lightlink2"><img src="sources_icon.gif" alt="<?php echo $admtext[sources]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[sources]; ?></strong></span><br/>
						<span class="smaller"><?php echo $sourcesmsg; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="repositories.php" class="lightlink2"><img src="repos_icon.gif" alt="<?php echo $admtext[repositories]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[repositories]; ?></strong></span><br/>
						<span class="smaller"><?php echo $sourcesmsg; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="media.php" class="lightlink2"><img src="photos_icon.gif" alt="<?php echo $admtext[media]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[media]; ?></strong></span><br/>
						<span class="smaller"><?php echo $photosmsg; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="albums.php" class="lightlink2"><img src="albums_icon.gif" alt="<?php echo $admtext[albums]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[albums]; ?></strong></span><br/>
						<span class="smaller"><?php echo $photosmsg; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="cemeteries.php" class="lightlink2"><img src="cemeteries_icon.gif" alt="<?php echo $admtext[cemeteries]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[cemeteries]; ?></strong></span><br/>
						<span class="smaller"><?php echo $cemeteriesmsg; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="places.php" class="lightlink2"><img src="places_icon.gif" alt="<?php echo $admtext[places]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[places]; ?></strong></span><br/>
						<span class="smaller"><?php echo $placesmsg; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="timelineevents.php" class="lightlink2"><img src="tlevents_icon.gif" alt="<?php echo $admtext[tlevents]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[tlevents]; ?></strong></span><br/>
						<span class="smaller"><?php echo $timelinemsg; ?></span></a>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" width="50%" style="min-width:320px">
			<table border="0" cellpadding="5" cellspacing="5" width="100%">
<?php
	if( !$link || ($allow_edit && $allow_add && $allow_delete && !$assignedbranch ) ) { 
?>			
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="dataimport.php" class="lightlink2"><img src="data_icon.gif" alt="<?php echo $admtext[datamaint]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[datamaint]; ?></strong></span><br/>
						<span class="smaller"><?php echo $admtext[importgedcom2]; ?></span></a>
					</td>
				</tr>
<?php
	} 
	if( !$assignedtree ) { 
?>			
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="setup.php" class="lightlink2"><img src="setup_icon.gif" alt="<?php echo $admtext[setup]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[setup]; ?></strong></span><br/>
						<span class="smaller"><?php echo $admtext[setupitems]; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="users.php" class="lightlink2"><img src="users_icon.gif" alt="<?php echo $admtext[users]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[users]; ?></strong></span><br/>
						<span class="smaller"><?php echo $admtext[usersitems]; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="trees.php" class="lightlink2"><img src="trees_icon.gif" alt="<?php echo $admtext[trees]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[trees]; ?></strong></span><br/>
						<span class="smaller"><?php echo $treesmsg; ?></span></a>
					</td>
				</tr>
<?php
	if( !$assignedbranch ) {
?>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="branches.php" class="lightlink2"><img src="branches_icon.gif" alt="<?php echo $admtext[branches]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[branches]; ?></strong></span><br/>
						<span class="smaller"><?php echo $treesmsg; ?></span></a>
					</td>
				</tr>
<?php
	}
?>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="eventtypes.php" class="lightlink2"><img src="customeventtypes_icon.gif" alt="<?php echo $admtext[customeventtypes]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[customeventtypes]; ?></strong></span><br/>
						<span class="smaller"><?php echo $admtext[custeventitems]; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="reports.php" class="lightlink2"><img src="reports_icon.gif" alt="<?php echo $admtext[reports]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[reports]; ?></strong></span><br/>
						<span class="smaller"><?php echo $admtext[reportsitems]; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';">
						<a href="languages.php" class="lightlink2"><img src="languages_icon.gif" alt="<?php echo $admtext[languages]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[languages]; ?></strong></span><br/>
						<span class="smaller"><?php echo $admtext[langitems]; ?></span></a>
					</td>
				</tr>
				<tr>
					<td class="fieldnameback" nowrap onMouseover="this.className='mouseoverback';" onMouseout="this.className='fieldnameback';" nowrap>
						<a href="backuprestore.php" class="lightlink2"><img src="backuprestore_icon.gif" alt="<?php echo $admtext[backuprestore]; ?>" width="40" height="40" border="1" align="left" hspace="5" style="border-color: black;">
						<span class="whitesubhead"><strong><?php echo $admtext[backuprestore]; ?></strong></span><br/>
						<span class="smaller"><?php echo $admtext[backupitems]; ?></span></a>
					</td>
				</tr>
<?php
	}
?>
			</table>
		</td>
	</tr>
</table>
</body>
</html>