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
include("../version.php");

if( $cms['support'] )
	$home_url = "../../../$homepage";
else
	$home_url = "../$homepage";

tng_adminheader( $admtext['administration'], "" );
?>
</head>

<body class="sideback">

<table border="0" cellspacing="0" cellpadding="4">
	<tr><td><span class="normal"><strong><a href="main.php" target="main" class="lightlink"><?php echo $admtext['administration']; ?></a></strong></span></td></tr>
	<tr><td><span class="normal"><a href="people.php" target="main" class="lightlink"><?php echo $admtext['people']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="families.php" target="main" class="lightlink"><?php echo $admtext['families']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="sources.php" target="main" class="lightlink"><?php echo $admtext['sources']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="repositories.php" target="main" class="lightlink"><?php echo $admtext['repositories']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="media.php" target="main" class="lightlink"><?php echo $admtext['media']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="albums.php" target="main" class="lightlink"><?php echo $admtext['albums']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="cemeteries.php" target="main" class="lightlink"><?php echo $admtext['cemeteries']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="places.php" target="main" class="lightlink"><?php echo $admtext['places']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="timelineevents.php" target="main" class="lightlink"><?php echo $admtext['tlevents']; ?></a></span></td></tr>
<?php
	if( !$link || ($allow_edit && $allow_add && $allow_delete && !$assignedbranch ) ) {
?>
	<tr><td><span class="normal"><a href="dataimport.php" target="main" class="lightlink"><?php echo $admtext['datamaint']; ?></a></span></td></tr>
<?php
	}
	if( !$assignedtree ) {
?>
	<tr><td><span class="normal"><a href="setup.php" target="main" class="lightlink"><?php echo $admtext['setup']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="users.php" target="main" class="lightlink"><?php echo $admtext['users']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="trees.php" target="main" class="lightlink"><?php echo $admtext['trees']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="branches.php" target="main" class="lightlink"><?php echo $admtext['branches']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="eventtypes.php" target="main" class="lightlink"><?php echo $admtext['customeventtypes']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="reports.php" target="main" class="lightlink"><?php echo $admtext['reports']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="languages.php" target="main" class="lightlink"><?php echo $admtext['languages']; ?></a></span></td></tr>
	<tr><td><span class="normal"><a href="backuprestore.php" target="main" class="lightlink"><?php echo $admtext['backuprestore']; ?></a></span></td></tr>
<?php
	}
?>
	<tr><td><span class="whiteheader"><span class="normal"><strong><a href="<?php echo $home_url; ?>" target="main" class="lightlink"><?php echo $admtext['publichome'] . "</strong><br /><span class=\"smaller\">" . $admtext['inframe']; ?></span><br /></a></span></span></td></tr>
</table>
</body>
</html>