<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");

if(!$safety) {
	header( "Location: login.php" );
	exit;
}

$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
if( $link ) {
	include("checklogin.php");

	if( $assignedtree || !$allow_edit ) {
		$message = "$admtext[norights]";
		header( "Location: login.php?message=" . urlencode($message) );
		exit;
	}
}
if (get_magic_quotes_gpc() == 0)
	$doctype = addslashes($doctype);

require("adminlog.php");

$fp = @fopen( $subroot . "config.php", "w",1 );
if( !$fp ) { die ( "$admtext[cannotopen] config.php" ); }

flock( $fp, LOCK_EX );

fwrite( $fp, "<?php\n" );
fwrite( $fp, "\$database_host = \"$new_database_host\";\n" );
fwrite( $fp, "\$database_name = \"$new_database_name\";\n" );
fwrite( $fp, "\$database_username = \"$new_database_username\";\n" );
fwrite( $fp, "\$database_password = \"$new_database_password\";\n" );
fwrite( $fp, "\$tngconfig[maint] = \"$maint\";\n" );
fwrite( $fp, "\n" );
fwrite( $fp, "\$people_table = \"$people_table\";\n" );
fwrite( $fp, "\$families_table = \"$families_table\";\n" );
fwrite( $fp, "\$children_table = \"$children_table\";\n" );
fwrite( $fp, "\$albums_table = \"$albums_table\";\n" );
fwrite( $fp, "\$album2entities_table = \"$album2entities_table\";\n" );
fwrite( $fp, "\$albumlinks_table = \"$albumlinks_table\";\n" );
fwrite( $fp, "\$media_table = \"$media_table\";\n" );
fwrite( $fp, "\$medialinks_table = \"$medialinks_table\";\n" );
fwrite( $fp, "\$mediatypes_table = \"$mediatypes_table\";\n" );
fwrite( $fp, "\$address_table = \"$address_table\";\n" );
fwrite( $fp, "\$languages_table = \"$languages_table\";\n" );
fwrite( $fp, "\$cemeteries_table = \"$cemeteries_table\";\n" );

//These next 6 tables are obsolete in v6, but are kept here in case anyone is still using them
fwrite( $fp, "\$headstones_table = \"$headstones_table\";\n" );
fwrite( $fp, "\$hslinks_table = \"$hslinks_table\";\n" );
fwrite( $fp, "\$photos_table = \"$photos_table\";\n" );
fwrite( $fp, "\$photolinks_table = \"$photolinks_table\";\n" );
fwrite( $fp, "\$histories_table = \"$histories_table\";\n" );
fwrite( $fp, "\$doclinks_table = \"$doclinks_table\";\n" );

fwrite( $fp, "\$states_table = \"$states_table\";\n" );
fwrite( $fp, "\$countries_table = \"$countries_table\";\n" );
fwrite( $fp, "\$places_table = \"$places_table\";\n" );
fwrite( $fp, "\$sources_table = \"$sources_table\";\n" );
fwrite( $fp, "\$repositories_table = \"$repositories_table\";\n" );
fwrite( $fp, "\$citations_table = \"$citations_table\";\n" );
fwrite( $fp, "\$events_table = \"$events_table\";\n" );
fwrite( $fp, "\$eventtypes_table = \"$eventtypes_table\";\n" );
fwrite( $fp, "\$reports_table = \"$reports_table\";\n" );
fwrite( $fp, "\$trees_table = \"$trees_table\";\n" );
fwrite( $fp, "\$notelinks_table = \"$notelinks_table\";\n" );
fwrite( $fp, "\$xnotes_table = \"$xnotes_table\";\n" );
fwrite( $fp, "\$saveimport_table = \"$saveimport_table\";\n" );
fwrite( $fp, "\$users_table = \"$users_table\";\n" );
fwrite( $fp, "\$temp_events_table = \"$temp_events_table\";\n" );
fwrite( $fp, "\$tlevents_table = \"$tlevents_table\";\n" );
fwrite( $fp, "\$branches_table = \"$branches_table\";\n" );
fwrite( $fp, "\$branchlinks_table = \"$branchlinks_table\";\n" );
fwrite( $fp, "\$assoc_table = \"$assoc_table\";\n" );
fwrite( $fp, "\$mostwanted_table = \"$mostwanted_table\";\n" );
fwrite( $fp, "\n" );
fwrite( $fp, "\$rootpath = \"$newrootpath\";\n" );
fwrite( $fp, "\$homepage = \"$homepage\";\n" );
fwrite( $fp, "\$tngdomain = \"$tngdomain\";\n" );
fwrite( $fp, "\$sitename = \"" . stripslashes($sitename) . "\";\n" );
fwrite( $fp, "\$site_desc = \"" . stripslashes($site_desc) . "\";\n" );
fwrite( $fp, "\$tngconfig[doctype] = \"$doctype\";\n" );
if( !$target ) $target = "_self";
fwrite( $fp, "\$target = \"$target\";\n" );
fwrite( $fp, "\$language = \"$language\";\n" );
fwrite( $fp, "\$charset = \"$charset\";\n" );
fwrite( $fp, "\$maxsearchresults = \"$maxsearchresults\";\n" );
fwrite( $fp, "\$lineending = \"\\r\\n\";\n" );
fwrite( $fp, "\$gendexfile = \"$gendexfile\";\n" );
fwrite( $fp, "\$mediapath = \"$mediapath\";\n" );
fwrite( $fp, "\$headstonepath = \"$headstonepath\";\n" );
fwrite( $fp, "\$historypath = \"$historypath\";\n" );
fwrite( $fp, "\$backuppath = \"$backuppath\";\n" );
fwrite( $fp, "\$documentpath = \"$documentpath\";\n" );
fwrite( $fp, "\$photopath = \"$photopath\";\n" );
fwrite( $fp, "\$photosext = \"$photosext\";\n" );
fwrite( $fp, "\$showextended = \"$showextended\";\n" );
fwrite( $fp, "\$tngconfig[imgmaxh] = \"$imgmaxh\";\n" );
fwrite( $fp, "\$tngconfig[imgmaxw] = \"$imgmaxw\";\n" );
fwrite( $fp, "\$thumbprefix = \"$thumbprefix\";\n" );
fwrite( $fp, "\$thumbsuffix = \"$thumbsuffix\";\n" );
fwrite( $fp, "\$thumbmaxh = \"$thumbmaxh\";\n" );
fwrite( $fp, "\$thumbmaxw = \"$thumbmaxw\";\n" );
fwrite( $fp, "\$tngconfig[thumbcols] = \"$tng_thumbcols\";\n" );
fwrite( $fp, "\$tngconfig[ssdisabled] = \"$tng_ssdisabled\";\n" );
fwrite( $fp, "\$tngconfig[ssrepeat] = \"$tng_ssrepeat\";\n" );
fwrite( $fp, "\$customheader = \"$customheader\";\n" );
fwrite( $fp, "\$customfooter = \"$customfooter\";\n" );
fwrite( $fp, "\$custommeta = \"$custommeta\";\n" );
fwrite( $fp, "\$tngconfig[tabs] = \"$tng_tabs\";\n" );
fwrite( $fp, "\$tngconfig[menu] = \"$tng_menu\";\n" );
fwrite( $fp, "\$tngconfig[istart] = \"$tng_istart\";\n" );
fwrite( $fp, "\$tngconfig[showhome] = \"$showhome\";\n" );
fwrite( $fp, "\$tngconfig[showsearch] = \"$showsearch\";\n" );
fwrite( $fp, "\$tngconfig[showlogin] = \"$showlogin\";\n" );
fwrite( $fp, "\$tngconfig[showprint] = \"$showprint\";\n" );
fwrite( $fp, "\$tngconfig[showbmarks] = \"$showbmarks\";\n" );
fwrite( $fp, "\$tngconfig[hidechr] = \"$hidechr\";\n" );

fwrite( $fp, "\$emailaddr = \"$emailaddr\";\n" );
fwrite( $fp, "\$dbowner = \"$dbowner\";\n" );
fwrite( $fp, "\$time_offset = \"$time_offset\";\n" );
fwrite( $fp, "\$requirelogin = \"$requirelogin\";\n" );
fwrite( $fp, "\$treerestrict = \"$treerestrict\";\n" );
fwrite( $fp, "\$livedefault = \"$livedefault\";\n" );
fwrite( $fp, "\$ldsdefault = \"$ldsdefault\";\n" );
fwrite( $fp, "\$chooselang = \"$chooselang\";\n" );
fwrite( $fp, "\$nonames = \"$nonames\";\n" );
fwrite( $fp, "\$notestogether = \"$notestogether\";\n" );
fwrite( $fp, "\$nameorder = \"$nameorder\";\n" );
fwrite( $fp, "\$lnprefixes = \"$lnprefixes\";\n" );
fwrite( $fp, "\$lnpfxnum = \"$lnpfxnum\";\n" );
fwrite( $fp, "\$specpfx = \"" . stripslashes( $specpfx ) . "\";\n" );
fwrite( $fp, "\$photosext = \"$photosext\";\n" );

fwrite( $fp, "\$tngconfig[cemrows] = \"$cemrows\";\n" );
fwrite( $fp, "\$tngconfig[cemblanks] = \"$cemblanks\";\n" );

fwrite( $fp, "\$maxgedcom = \"$maxgedcom\";\n" );
fwrite( $fp, "\$change_cutoff = \"$change_cutoff\";\n" );
fwrite( $fp, "\$change_limit = \"$change_limit\";\n" );
fwrite( $fp, "\$tngconfig[preferEuro] = \"$prefereuro\";\n" );
fwrite( $fp, "\$tngconfig[disallowreg] = \"$disallowreg\";\n" );
fwrite( $fp, "\$tngconfig[pardata] = \"$pardata\";\n" );
fwrite( $fp, "\$defaulttree = \"$defaulttree\";\n" );
fwrite( $fp, "\n" );
fwrite( $fp, "if(!isset(\$cms[auto])) {\n" );
fwrite( $fp, "\$cms[support] = \"$cmssupport\";\n" );
fwrite( $fp, "\$cms[url] = \"$cmsurl\";\n" );
fwrite( $fp, "\$cms[tngpath] = \"$cmstngpath\";\n" );
fwrite( $fp, "\$cms[module] = \"$cmsmodule\";\n" );
fwrite( $fp, "\$cms[cloaklogin] = \"$cmscloaklogin\";\n" );
fwrite( $fp, "\$cms[credits] = \"$cmscredits\";\n" );
fwrite( $fp, "\$cms[adminurl] = \"$adminurl\";\n" );
fwrite( $fp, "}\n" );
fwrite( $fp, "\n" );
fwrite( $fp, "@include(\$subroot . \"customconfig.php\");\n" );
fwrite( $fp, "?>\n" );

flock( $fp, LOCK_UN );
fclose( $fp );

$fp = @fopen( "../subroot.php", "w",1 );
if( $fp ) {
	flock( $fp, LOCK_EX );
	fwrite( $fp, "<?php\n" );
	fwrite( $fp, "@ini_set('error_reporting','2039');\n" );
	fwrite( $fp, "\$tngconfig[subroot] = \"$newsubroot\";\n" );
	fwrite( $fp, "\$subroot = \$tngconfig[subroot] ? \$tngconfig[subroot] : \"../\";\n" );
	fwrite( $fp, "?>\n" );
	flock( $fp, LOCK_UN );
	fclose( $fp );
}
adminwritelog( $admtext['modifysettings'] );

$oldsubroot = $newsubroot != $subroot ? "?sr=$subroot" : "";
header( "Location: setup.php$oldsubroot" );
?>
