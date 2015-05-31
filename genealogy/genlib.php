<?php
if($_GET['cms'] || $_POST['cms']) die("Sorry!");
include_once($cms['tngpath'] . "browserinfo.php");
include_once($cms['tngpath'] . "globallib.php");
@include_once($cms['tngpath'] . "mediatypes.php");
@include_once($cms['tngpath'] . "tngfiletypes.php");
checkMaintenanceMode(0);
if($map[key])
	include_once($cms['tngpath'] . "googlemaps/googlemaplib.php");
@include($cms['tngpath'] . "tngrobots.php");

$htmldocs = array("HTML","PHP","HTM");
$http_user_agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
$newbrowser = ereg("msie", $http_user_agent) && ereg("mac", $http_user_agent) ? 0 : 1;
$gotlastpage = false;

if( $cms[support] == "phpnuke" ) {
	if( $multilingual == "1" ) {
		$newlanguage = strtoupper(substr($currentlang,0,1)) . substr($currentlang, 1); ;
		session_start();
		session_register('session_language');
		$session_language = $_SESSION[session_language] = $newlanguage;
	}
}
elseif( $cms[support] == "postnuke" ) {
}

if($requirelogin && $treerestrict && $_SESSION['assignedtree']) {
	if(!$tree)
		$tree = $_SESSION['assignedtree'];
	elseif($tree != $_SESSION['assignedtree']) {
		header("Location:$homepage");
		exit;
	}
}
$orgtree = $tree;
if( !$tree && $defaulttree ) {
	$tree = $defaulttree;
}
elseif( $tree == "-x--all--x-" )
	$tree = "";


function tng_header( $title, $flags ) {
	global $custommeta, $customheader, $cms, $session_charset, $tngprint, $sitename, $site_desc, $tngconfig;
	include($cms['tngpath'] . "version.php");
	global $text, $map, $browser;

	initMediaTypes();

	//echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\">\n\n";
	//echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n\n";
	echo $tngconfig['doctype'] ? $tngconfig['doctype'] . "\n\n" : "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n\n";
	if( !$cms[support] )
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n";
	else
		echo $cms[credits];
	$siteprefix = $sitename ? ": $sitename" : "";
	echo "<title>$title$siteprefix</title>\n";
	$title = ereg_replace("\"", "",$title);
	echo "<meta name=\"Keywords\" content=\"$title\" />\n";
	echo "<meta name=\"Description\" content=\"$title$siteprefix\" />\n";
	if( $session_charset )
		echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=$session_charset\" />\n";
	if( isset( $flags[norobots] ) )
		echo $flags[norobots];
	if( isset( $flags[autorefresh] ) && $flags[autorefresh] == 1 )
		echo "<meta http-equiv=\"refresh\" content=\"30\" />\n";
	if( isset( $flags[scripting] ) )
		echo $flags[scripting];
	if( $tngconfig[menu] < 2 && !$tngprint ) {
		if( !$tngconfig[menu] ) {
			echo "<style type=\"text/css\">#mnav li:hover #third, #mnav li.sfhover #third {right: 0px;}</style>\n";
			$leftside = "var leftside = 0;";
		}
		else
			$leftside = "var leftside = 1;";
		if($browser == "IE6")
			echo "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "tngmenuhover.js\"></script>\n";
	}
	else $leftside = "";
	echo "<script type=\"text/javascript\">\n$leftside" . "var tnglitbox;\nvar closeimg = \"" . $cms['tngpath'] . "tng_close.gif\";\n</script>\n";
	echo "<script type=\"text/javascript\">var smallimage_url = '" . getURL("smallimage",1) . "';\nvar cmstngpath='$cms[tngpath]';\nvar loadingmsg = '$text[loading]';</script>\n";
	echo "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "net.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "prototype.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "scriptaculous.js\"></script>\n";
	echo "<style type=\"text/css\">.media-prev {background: transparent url(" . $cms['tngpath'] . "media-prevbg.png) no-repeat 0 0;}</style>\n";
	if( isset( $flags['tabs'] ) )
		echo "<link href=\"$cms[tngpath]" . "$flags[tabs]\" rel=\"stylesheet\" type=\"text/css\" />\n";
	@include( $custommeta );
	if( $tngprint )
		echo "<link href=\"$cms[tngpath]" . "tngprint.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
	echo "<!-- $tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright -->\n";
	if( !$cms[support] ) {
		echo "</head>\n";
		if( !$tngprint && !$flags[noheader] )
			include( $customheader );
		elseif(!$flags['nobody'])
			echo "<body>\n";
	}
	if( !$flags[noicons] )
		echo tng_icons( 1 );

	if($tngconfig['maint'])
		echo "<span class=\"fieldnameback yellow\" style=\"padding:3px\"><strong>$text[mainton]</strong></span><br /><br />\n";
}

function tng_footer( $flags ) {
	global $customfooter, $cms, $tngprint, $map, $text;

	if( !$tngprint )
		include( $customfooter );
	if( isset( $flags[more] ) )
		echo $flags[more];
	echo "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "litbox.js\"></script>\n";
	if($map[key]) {
		if($map[pins])
			tng_map_pins();
		echo "<script type=\"text/javascript\" src=\"$cms[tngpath]" . "googlemaps/pieng.js\"></script>\n";
	}

	if(!$cms[support]) include($cms['tngpath'] . "end.php" );
}

function getSmallPhoto( $medialink ) {
	global $rootpath, $photopath, $documentpath, $headstonepath, $historypath, $mediapath, $mediatypes_assoc, $thumbmaxw, $thumbmaxh, $cms;

	$mediatypeID = $medialink[mediatypeID];
	$usefolder = $medialink[usecollfolder] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
	//determine $usefolder based on mediatypeID and usecollfolder

	if( $medialink[thumbpath] != "" && file_exists("$rootpath$usefolder/$medialink[thumbpath]")) {
		$photoinfo = @GetImageSize( "$rootpath$usefolder/$medialink[thumbpath]" );
		if( $photoinfo[0] <= $thumbmaxw && $photoinfo[1] <= $thumbmaxh ) {
			$photohtouse = $photoinfo[1];
			$photowtouse = $photoinfo[0];
		}
		else {
			if( $photoinfo[0] > $photoinfo[1] ) {
				$photowtouse = $thumbmaxw;
				$photohtouse = intval( $thumbmaxw * $photoinfo[1] / $photoinfo[0] ) ;
			}
			else {
				$photohtouse = $thumbmaxh;
				$photowtouse = intval( $thumbmaxh * $photoinfo[0] / $photoinfo[1] ) ;
			}
		}
		$imgsrc = "<img src=\"$usefolder/" . str_replace("%2F","/",rawurlencode( $medialink[thumbpath] )) . "\" border=\"0\" width=\"$photowtouse\" height=\"$photohtouse\" alt=\"" . str_replace("\"","","$medialink[description]") . "\" title=\"" . str_replace("\"","","$medialink[description]") . "\" />";
	}
	else
		$imgsrc = "";

	return $imgsrc;
}

function tng_DrawHeading($photostr, $namestr, $years) {
	if( $photostr )
		$outputstr = "<table cellpadding=\"0\" cellspacing=\"0\"><tr>\n<td valign=\"top\">$photostr</td><td>&nbsp;</td>\n<td valign=\"top\"><span class=\"header\">$namestr</span><br/><span class=\"normal\">$years</span></td></tr></table>\n";
	else
		$outputstr = "<span class=\"header\">$namestr</span><br /><span class=\"normal\">$years</span><br />\n";
	$outputstr .= "<br clear=\"all\" />\n";
	return $outputstr;
}

function getGenderIcon($gender, $valign) {
	global $text, $cms;

	$icon = "";
	if($gender) {
		if($gender == "M") $genderstr = "male";
		elseif($gender == "F") $genderstr = "female";
		if($genderstr)
			$icon = "<img src=\"$cms[tngpath]tng_$genderstr.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"" . $text[$genderstr] . "\" style=\"vertical-align: " . $valign . "px;\"/>&nbsp;";
	}
	return $icon;
}

function getName( $row ) {
	global $nonames, $nameorder, $text;

	$locnameorder = $row[nameorder] ? $row[nameorder] : ($nameorder ? $nameorder : 1);
	$lastname = trim( $row['lnprefix']." ".$row['lastname'] );
	$title = $row['title'] && ($row['title'] == $row['prefix']) ? $row['title'] : trim($row['title'] . " " . $row['prefix']);
	if( $row['allow_living'] || !$nonames ) {
		$firstname = trim( $title." ".$row['firstname'] );
		if( $locnameorder == 1 )
			$namestr = trim("$firstname $lastname");
		else
			$namestr = trim("$lastname $firstname");
		if( $row[suffix] ) $namestr .= ", $row[suffix]";
	}
	elseif( $nonames == 2 ) {
		if( $locnameorder == 1 )
			$namestr = trim( $title . " " . initials( $row[firstname] ) . " " . $lastname );
		else
			$namestr = trim( $lastname . " " . $title . " " . initials( $row[firstname] ) );
		if( $row[suffix] ) $namestr .= ", $row[suffix]";
	}
	else
		$namestr = $text[living];

	return $namestr;
}

function getNameRev( $row ) {
	global $nonames, $nameorder, $text;

	$locnameorder = $row[nameorder] ? $row[nameorder] : ($nameorder ? $nameorder : 1);
	$lastname = trim( $row['lnprefix']." ".$row['lastname'] );
	$title = $row['title'] && ($row['title'] == $row['prefix']) ? $row['title'] : trim($row['title'] . " " . $row['prefix']);
	if( $row[allow_living] || !$nonames ) {
		$firstname = trim( $title . " " .$row['firstname'] );
		if( $locnameorder == 1 ) {
			$namestr = $lastname;
			if($firstname) {
				if($lastname) $namestr .= ", ";
				$namestr .= $firstname;
			}
			if($row['suffix']) $namestr .= " ".$row['suffix'];
		}
		else {
			$namestr = trim( "$lastname $firstname" );
			if( $row['suffix'] ) $namestr .= ", $row[suffix]";
		}
	}
	elseif( $nonames == 2 ) {
		if( $locnameorder == 1 )
			$namestr = trim( "$lastname, " . $title . " " . initials( $row[firstname] ) . " $row[suffix]" );
		else {
			$namestr = trim( "$lastname " . $title . " " . initials( $row[firstname] ) );
			if( $row[suffix] ) $namestr .= ", $row[suffix]";
		}
	}
	else
		$namestr = $text[living];

	return $namestr;
}

function getSurnameOnly( $row ) {
	global $nonames, $text;

	if( $row[allow_living] || $nonames != 1 )
		$namestr = trim( "$row[lnprefix] $row[lastname]" );
	else
		$namestr = $text[living];

	return $namestr;
}

function getFirstNameOnly( $row ) {
	global $nonames, $text;

	if( $row[allow_living] || !$nonames )
		$namestr = strtok( $row[firstname], " " );
	elseif( $nonames == 2 )
		$namestr = initials( $row[firstname] );
	else
		$namestr = $text[living];

	return $namestr;
}

function getFamilyName( $row ) {
	global $text, $people_table, $allow_living, $livedefault;

	$hquery = "SELECT lnprefix, lastname, living, branch FROM $people_table WHERE personID = \"$row[husband]\" AND gedcom = \"$row[gedcom]\"";
	$hresult = mysql_query($hquery) or die ("$text[cannotexecutequery]: $hquery");
	$hrow = mysql_fetch_assoc( $hresult );
	$rightbranch = checkbranch( $hrow[branch] ) ? 1 : 0;
	$hrow[allow_living] = !$hrow[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$husbname = getSurnameOnly( $hrow );
	mysql_free_result( $hresult );

	$wquery = "SELECT lnprefix, lastname, living, branch FROM $people_table WHERE personID = \"$row[wife]\" AND gedcom = \"$row[gedcom]\"";
	$wresult = mysql_query($wquery) or die ("$text[cannotexecutequery]: $wquery");
	$wrow = mysql_fetch_assoc( $wresult );
	$rightbranch = checkbranch( $wrow[branch] ) ? 1 : 0;
	$wrow[allow_living] = !$wrow[living] || $livedefault == 2 || ( $allow_living && $rightbranch ) ? 1 : 0;
	$wifename = getSurnameOnly( $wrow );
	mysql_free_result( $wresult );

	return "$husbname/$wifename ($row[familyID])";
}

function tng_menu( $enttype, $currpage, $entityID, $innermenu ) {
	global $tree, $text, $disallowgedcreate, $target, $allow_admin, $allow_edit, $currentuser;
	global $rightbranch, $cms, $allow_ged, $emailaddr, $newbrowser, $tngprint;

	if( !$tngprint ) {
		$menu = "<div style=\"width:100%;overflow:hidden\">\n";
		$menu .= $newbrowser ? "<ul id=\"tngnav\">\n" : "<div id=\"tabs\">\n";
		if( $enttype == "I" ) {
			$getperson_url = getURL( "getperson", 1 );
			$pedigree_url = getURL( "pedigree", 1 );
			$descend_url = getURL( "descend", 1 );
			$gedform_url = getURL( "gedform", 1 );
			$relateform_url = getURL( "relateform", 1 );
			$timeline_url = getURL( "timeline", 1 );

			$menu .= doMenuItem( 0, "$getperson_url" . "personID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_ind.gif", $text[indinfo], $currpage, "person" );
			$menu .= doMenuItem( 1, "$pedigree_url" . "personID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_ped.gif", $text[ancestors], $currpage, "pedigree" );
			$menu .= doMenuItem( 2, "$descend_url" . "personID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_desc.gif", $text[descendants], $currpage, "descend" );
			$menu .= doMenuItem( 3, "$relateform_url" . "primaryID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_rel.gif", $text[relationship], $currpage, "relate" );
			$menu .= doMenuItem( 4, "$timeline_url" . "primaryID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_time.gif", $text[timeline], $currpage, "timeline" );
			if( !$disallowgedcreate || $allow_ged ) {
				$menu .= doMenuItem( 5, "$gedform_url" . "personID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_ged.gif", $text[extractgedcom], $currpage, "gedcom" );
				$nexttab = "6";
			}
			else
				$nexttab = "5";
			$editstr = "editperson.php?person";
		}
		elseif( $enttype == "F" ) {
			$familygroup_url = getURL( "familygroup", 1 );

			$menu .= doMenuItem( 0, "$familygroup_url" . "familyID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_rel.gif", $text[family], $currpage, "family" );
			$editstr = "editfamily.php?family";
			$nexttab = "1";
		}
		elseif( $enttype == "S" ) {
			$showsource_url = getURL( "showsource", 1 );

			$menu .= doMenuItem( 0, "$showsource_url" . "sourceID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_ind.gif", $text[source], $currpage, "source" );
			$editstr = "editsource.php?source";
			$nexttab = "1";
		}
		elseif( $enttype == "R" ) {
			$showrepo_url = getURL( "showrepo", 1 );

			$menu .= doMenuItem( 0, "$showrepo_url" . "repoID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_ind.gif", $text[repository], $currpage, "repo" );
			$editstr = "editrepo.php?repo";
			$nexttab = "1";
		}
		if( $currentuser && $allow_admin && $allow_edit && $rightbranch ) {
			$menu .= doMenuItem( $nexttab, "$cms[tngpath]" . "admin/$editstr" . "ID=$entityID&amp;tree=$tree&amp;cw=1\" target=\"_blank", "$cms[tngpath]tng_edit.gif", $text[edit], $currpage, "" );
		}
		elseif( $emailaddr ) {
			$suggest_url = getURL( "suggest", 1 );
			$menu .= doMenuItem( $nexttab, "$suggest_url" . "enttype=$enttype&amp;ID=$entityID&amp;tree=$tree", "$cms[tngpath]tng_edit.gif", $text[suggest], $currpage, "suggest" );
		}
		$menu .= $newbrowser ? "</ul>\n" : "</div>\n";
		$menu .= "</div>\n";
		$menu .= "<div class=\"fieldnameback fieldname smaller\" style=\"margin:0px 1px 0px 1px;clear:both; padding: 0.3em 0em 0.3em .7em; border-right: 1px solid #777; border-bottom: 1px solid #777;\">\n";
		$menu .= $innermenu;
		$menu .= "</div><br/>\n";
	}
	else $menu = "";

	return $menu;
}

function tng_coreicons( ) {
	global $currentuser, $currentuserdesc, $cms, $text, $homepage, $target, $tngprint, $tngconfig, $gotlastpage;

	if( !$tngprint ) {
		$logout_url = getURL( "logout", 1 );
		$login_url = getURL( "login", 0 );
		$homepage_url   = getURL( $homepage, 0, "");
		$searchform_url = getURL( "searchform", 0 );
		$print_url = str_replace("&","&amp;",getScriptName());
		$print_url = str_replace("%27","\%27",$print_url);
		//I have a feeling we'll need this:
		//$print_url = str_replace("&amp;amp;","&amp;",$print_url);
		$addbookmark_url = getURL( "addbookmark", 0 );
		if(ereg("\?",$print_url))
			$print_url .= "&amp;tngprint=1";
		else
			$print_url .= "?tngprint=1";

		$coremenu = "";
		if( !$tngconfig[showhome] )
			$coremenu .= "<a href=\"$homepage_url\" target=\"$target\" title=\"$text[homepage]\" style=\"text-decoration:none\"><img src=\"$cms[tngpath]tng_home.gif\" width=\"16\" height=\"15\" border=\"0\" class=\"tngmenuicon\" alt=\"$text[homepage]\"/>$text[homepage]</a>&nbsp;&nbsp;&nbsp;\n";
    		if( !$tngconfig[showsearch] )
			$coremenu .= "<a href=\"$searchform_url\" title=\"$text[search]\" style=\"text-decoration:none\"><img src=\"$cms[tngpath]tng_search.gif\" width=\"16\" height=\"15\" border=\"0\" class=\"tngmenuicon\" alt=\"$text[search]\"/>$text[search]</a>&nbsp;&nbsp;&nbsp;\n";
		if( !$tngconfig[showprint] )
			$coremenu .= "<a href=\"javascript:newwindow=window.open('$print_url','tngprint','width=850,height=600,status=no,resizable=yes,scrollbars=yes'); newwindow.focus();\" onmouseover=\"window.status='$text[tngprint]';return true\" onmouseout=\"window.status='';return true\" title=\"$text[tngprint]\" style=\"text-decoration:none\"><img src=\"$cms[tngpath]tng_print.gif\" width=\"16\" height=\"15\" border=\"0\" class=\"tngmenuicon\" vspace=\"0\" hspace=\"1\" alt=\"$text[tngprint]\"/>$text[tngprint]</a>&nbsp;&nbsp;&nbsp;\n";
		if( !$tngconfig[showlogin] ) {
			if( $currentuser ) {
				if( !$cms[cloaklogin] || $cms[cloaklogin] == "both" )
					$coremenu .= "<a href=\"$logout_url" . "session=" . session_name() . "\" target=\"$target\" title=\"$text[logout] - $text[user]: $currentuserdesc\" style=\"text-decoration:none\"><img src=\"$cms[tngpath]tng_log.gif\" width=\"16\" height=\"15\" border=\"0\" class=\"tngmenuicon\" alt=\"$text[logout] - $text[user]: $currentuserdesc\"/>$text[logout]</a>&nbsp;&nbsp;&nbsp;\n";
			}
			else {
				if( !$cms[cloaklogin] || $cms[cloaklogin] == "both" )
					$coremenu .= "<a href=\"$login_url\" title=\"$text[login] - $text[user]: $text[anonymous]\" style=\"text-decoration:none\"><img src=\"$cms[tngpath]tng_log.gif\" width=\"16\" height=\"15\" border=\"0\" class=\"tngmenuicon\" alt=\"$text[login] - $text[user]: $text[anonymous]\"/>$text[login]</a>&nbsp;&nbsp;&nbsp;\n";
			}
		}
		if( !$tngconfig['showbmarks'] && $gotlastpage )
			$coremenu .= "<a href=\"#\" onclick=\"tnglitbox = new LITBox('$addbookmark_url',{width:350,height:100}); return false\" onmouseover=\"window.status='$text[bookmark]';\" onmouseout=\"window.status='';\" title=\"$text[addfavs]\" style=\"text-decoration:none\"><img src=\"$cms[tngpath]tng_bmk2.gif\" width=\"16\" height=\"15\" border=\"0\" class=\"tngmenuicon\" vspace=\"0\" hspace=\"1\" alt=\"$text[bookmark]\"/>$text[bookmark]</a>\n";
		$menu = $coremenu ? "<p class=\"smaller\" style=\"margin-top:0px\">\n$coremenu\n</p>\n" : "";
	}
	else $menu = "";

	return $menu;
}

function tng_icons( $instance ) {
	global $text, $allow_admin_db, $chooselang, $languages_table, $mylanguage, $tngconfig, $cms, $tngprint, $mediatypes;

	$menu = "";
	if( $tngprint ) {
		$menu .= "<table align=\"right\"><tr><td><b><a href=\"javascript:{document.getElementById('printlink').style.visibility='hidden'; window.print();}\" style=\"text-decoration:underline\" id=\"printlink\">&gt;&gt; $text[tngprint] &lt;&lt;</a></b></td></tr></table>\n";
	}
	elseif( $tngconfig[menu] < 2 || $chooselang ) {
		$surnames_url = getURL( "surnames", 0 );
		$anniversaries_url = getURL( "anniversaries", 0 );
		$places_url = getURL( "places", 0 );
		$searchform_url = getURL( "searchform", 0 );
		$cemeteries_url = getURL( "cemeteries", 0 );
		$bookmarks_url = getURL( "bookmarks", 0 );

		$browsemedia_url = getURL( "browsemedia", 1 );
		$browsemedia_noargs_url = getURL( "browsemedia", 0 );
		$browsealbums_url = getURL( "browsealbums", 0 );

		$browsesources_url = getURL( "browsesources", 0 );
		$browsenotes_url = getURL( "browsenotes", 0 );
		$browserepos_url = getURL( "browserepos", 0 );
		$whatsnew_url = getURL( "whatsnew", 0 );
		$mostwanted_url = getURL( "mostwanted", 0 );
		$reports_url = getURL( "reports", 0 );
		$stats_url = getURL( "browsetrees", 0 );
		$suggest_url = getURL( "suggest", 0 );
		$admin_url  = $cms['adminurl'] ? $cms['adminurl'] : $cms['tngpath']."admin/index.php";

		if( !$tngconfig[menu] ) {
			$iconalign = " float:right;";
		}
		else {
			$iconalign = " float:left";
			$instance = "x$instance"; //to prevent the language box from disappearing when it's inline with the menu
		}
		if( $tngconfig[menu] < 2 ) {
			$menu .= "<ul id=\"mnav\" style=\"position:relative; z-index:97;$iconalign\">\n";

			$menu .= "<li class=\"drop\"><a href=\"#\"><img src=\"$cms[tngpath]" . "ArrowDown.gif\" width=\"25\" height=\"8\" vspace=\"4\" border=\"0\" align=\"left\" alt=\"\" />$text[find_menu]</a>\n";
			$menu .= "<ul id=\"first\">\n";
			$menu .= "<li><a href=\"$surnames_url\"><img src=\"$cms[tngpath]tng_names.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[surnames]</a></li>\n";
			$menu .= "<li><a href=\"$bookmarks_url\"><img src=\"$cms[tngpath]tng_bmk.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[bookmarks]</a></li>\n";
			$menu .= "<li><a href=\"$places_url\"><img src=\"$cms[tngpath]tng_place.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[places]</a></li>\n";
			$menu .= "<li><a href=\"$anniversaries_url\"><img src=\"$cms[tngpath]tng_date.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[dates]</a></li>\n";
			$menu .= "<li><a href=\"$cemeteries_url\"><img src=\"$cms[tngpath]tng_hs.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[cemeteries]</a></li>\n";
			$menu .= "<li><a href=\"$searchform_url\"><img src=\"$cms[tngpath]tng_search2.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[search]</a></li>\n";
			$menu .= "</ul>\n";
			$menu .= "</li>\n";

			$menu .= "<li class=\"drop\"><a href=\"#\"><img src=\"$cms[tngpath]" . "ArrowDown.gif\" width=\"25\" height=\"8\" vspace=\"4\" border=\"0\" align=\"left\" alt=\"\" />$text[media]</a>\n";
			$menu .= "<ul id=\"second\">\n";
			foreach( $mediatypes as $mediatype ) {
				$msgID = $mediatype[ID];
				$menu .= "<li><a href=\"$browsemedia_url" . "mediatypeID=$msgID\"><img src=\"$cms[tngpath]$mediatype[icon]\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />" . $mediatype['display'] . "</a></li>\n";
			}
			$menu .= "<li><a href=\"$browsealbums_url\"><img src=\"$cms[tngpath]tng_album.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[albums]</a></li>\n";
			$menu .= "<li><a href=\"$browsemedia_noargs_url\"><img src=\"$cms[tngpath]tng_media.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[allmedia]</a></li>\n";
			$menu .= "</ul>\n";
			$menu .= "</li>\n";

			$menu .= "<li class=\"drop\"><a href=\"#\"><img src=\"$cms[tngpath]" . "ArrowDown.gif\" width=\"25\" height=\"8\" vspace=\"4\" border=\"0\" align=\"left\" alt=\"\" />$text[info]</a>\n";
			$menu .= "<ul id=\"third\">\n";
			$menu .= "<li><a href=\"$whatsnew_url\"><img src=\"$cms[tngpath]tng_new.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[whatsnew]</a></li>\n";
			$menu .= "<li><a href=\"$mostwanted_url\"><img src=\"$cms[tngpath]tng_mw.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[mostwanted]</a></li>\n";
			$menu .= "<li><a href=\"$reports_url\"><img src=\"$cms[tngpath]tng_rpt.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[reports]</a></li>\n";
			$menu .= "<li><a href=\"$stats_url\"><img src=\"$cms[tngpath]tng_stats.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[databasestatistics]</a></li>\n";
			$menu .= "<li><a href=\"$browsenotes_url\"><img src=\"$cms[tngpath]tng_note.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[notes]</a></li>\n";
			$menu .= "<li><a href=\"$browsesources_url\"><img src=\"$cms[tngpath]tng_src.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[sources]</a></li>\n";
			$menu .= "<li><a href=\"$browserepos_url\"><img src=\"$cms[tngpath]tng_repo.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[repositories]</a></li>\n";
			if( $allow_admin_db )
				$menu .= "<li><a href=\"$admin_url\"><img src=\"$cms[tngpath]tng_admin.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[administration]</a></li>\n";
			$menu .= "<li><a href=\"$suggest_url\"><img src=\"$cms[tngpath]tng_contact.gif\" width=\"20\" height=\"20\" border=\"0\" hspace=\"4\" style=\"vertical-align:middle\" align=\"left\" alt=\"\" />$text[contactus]</a></li>\n";
			$menu .= "</ul>\n";
			$menu .= "</li>\n";
		}

		if( $chooselang ) {
			$query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
			$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			$numlangs = mysql_num_rows( $result );
			if( $numlangs ) {
				if( $tngconfig[menu] < 2 ) {
					if( !$tngconfig[menu] ) {
						$menu .= "</ul>\n";
						$menu .= "<div style=\"padding-top:2px; padding-right:4px;clear:both;$iconalign\">\n";
					}
					else {
						$menu .= "<li style=\"border:0px;\">";
					}
				}
				else
					$menu .= "<div style=\"padding-top:2px; padding-right:4px;clear:both;float:right\">\n";

				$menu .= getFORM( "savelanguage2", "get", "tngmenu$instance", "" );
				$menu .= "<select name=\"newlanguage$instance\" id=\"newlanguage$instance\" style=\"font-size: 10px;\" onchange=\"document.tngmenu$instance.submit();\">";

				while( $row = mysql_fetch_assoc($result)) {
					$menu .= "<option value=\"$row[languageID]\"";
					if( $row[folder] == $mylanguage )
						$menu .= " selected=\"selected\"";
					$menu .= ">$row[display]</option>\n";
				}
				$menu .= "</select>\n";
				$menu .= "<input type=\"hidden\" name=\"instance\" value=\"$instance\" /></form>\n";
				if( $tngconfig[menu] == 1 )
						$menu .= "</li>\n</ul>\n";
				else
						$menu .= "</div>\n";
			}
			else
				$menu .= "</ul>\n";
			mysql_free_result($result);
		}
		else
			$menu .= "</ul>\n";

		if( $tngconfig[menu] == 1 )
			$menu .= "<br /><br />\n";
	}
			
	return $menu;
}

function getURL( $destination, $args, $ext=".php") {
        global $cms;

	if( $cms[support] )
		$url = $args ? "$cms[url]=$destination&" : "$cms[url]=$destination";
	else
		$url = $args ? $cms[tngpath] . $destination . $ext . "?" : $cms[tngpath] . $destination . $ext;

	return $url;
}

function getFORM( $action, $method, $name, $id ) {
	global $cms;

	if( !$cms['support'] )
		$url = $cms['tngpath'] . $action . ".php";
    elseif ($cms['support']=="joomla")
		$url = "index.php";
	else
		$url = "modules.php";

	$formstr = "<form style=\"margin:0px\" action=\"$url\"";
	if( $method )
		$formstr .= " method=\"$method\"";
	if( $name )
		$formstr .= " name=\"$name\"";
	if( $id )
		$formstr .= " id=\"$id\"";

	$formstr .= ">\n";

	if( $cms['support'] ) {
		if ($cms[support]=="joomla") {
			$formstr .="<input type=\"hidden\" name=\"option\" value= \"com_tngbridge\" />\n";
			$formstr .="<input type=\"hidden\" name=\"Itemid\" value=\"39\" /> \n";
			$formstr .="<input type=\"hidden\" name=\"url\" value=\"$action\" /> \n";
		}
		else {
			$formstr .= "<input type=\"hidden\" name=\"op\" value=\"modload\" />\n";
			$formstr .= "<input type=\"hidden\" name=\"name\" value=\"$cms[module]\" />\n";
			$formstr .= "<input type=\"hidden\" name=\"file\" value=\"$action\" />\n";
		}
	}

	return $formstr;
}

function initials( $name ) {
	$newname = "";
	$token = strtok( $name, " " );
	do{
		if( substr( $token, 0, 1 ) != "(" )  //In case there is a name in brackets, in which case ignore
			$newname .= substr( $token, 0, 1 ) . ".";
		$token = strtok(" ");
	}
	while( $token != "" );

	return $newname;
}

function checkLivingLinks($itemID, $itemAlwaysOn=false ) {
	global $assignedtree, $assignedbranch, $people_table, $text, $medialinks_table, $sources_table, $citations_table, $families_table, $livedefault, $allow_living_db;

	if ( $livedefault ==2 || $itemAlwaysOn )  // Cases where item can be seen no matter what
		return true;

	if (!$allow_living_db) {
		// Viewer can not see media of Living individuals regardless of tree/branch,
		// So need to check all links to this media for living individuals (don't narrow the search.)
		$criteria  = "";
		$fcriteria = "";
	}
	else {
		// Viewer can see some media of Living individuals, now figure if there are some the viewer should not see
		if( !$assignedtree ) {
			return true;  // No other trees (and thus Branches) to check, so the viewer can see any media
		}
		else {
			// Should not be able to see Living individuals in other Trees, so narrow search to those other Trees
			$criteria   = "$people_table.gedcom   != \"$assignedtree\"";
			$fcriteria  = "$families_table.gedcom != \"$assignedtree\"";

			if ($assignedbranch ) { // Note: must have a Tree selected to have a Branch
				// Should not be able to see Living individuals in other Branches either, so need to check for those too.
				$bcriteria = " OR !(branch LIKE \"%$assignedbranch%\")";
				$criteria  .= $bcriteria;
				$fcriteria .= $bcriteria;
			}
			$criteria  = "AND ($criteria)"  ;
			$fcriteria = "AND ($fcriteria)" ;
		}
	}

	// Now find Living individuals linked to the media that fit the criteria set above.
	$query = "SELECT count($medialinks_table.personID) as pcount
		FROM ($medialinks_table, $people_table)
		WHERE $medialinks_table.personID = $people_table.personID
			AND $medialinks_table.gedcom = $people_table.gedcom
			AND $medialinks_table.mediaID = '$itemID'
			AND living = 1 $criteria";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	mysql_free_result( $result );
	if( $row[pcount] )
		return false;  // found at least one

	$query = "SELECT count($medialinks_table.personID) as pcount
		FROM ($medialinks_table, $families_table)
		WHERE $medialinks_table.personID = $families_table.familyID
			AND $medialinks_table.gedcom = $families_table.gedcom
			AND $medialinks_table.mediaID = '$itemID'
			AND living = 1 $fcriteria";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
	mysql_free_result( $result );
	if( $row[pcount] )
		return false;  // found at least one

	/*
 	$query = "SELECT count($medialinks_table.personID) as pcount
		FROM ($medialinks_table, $sources_table, $citations_table, $people_table)
		WHERE $medialinks_table.personID = $sources_table.sourceID
			AND $medialinks_table.gedcom = $sources_table.gedcom
			AND $medialinks_table.gedcom = $citations_table.gedcom
			AND $medialinks_table.gedcom = $people_table.gedcom
			AND $sources_table.sourceID = $citations_table.sourceID
			AND $citations_table.persfamID = $people_table.personID
			AND $medialinks_table.mediaID = '$itemID'
			AND living = 1 AND ($criteria)";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
   	mysql_free_result( $result );
	if( $row[pcount] )
		return false;

 	$query = "SELECT count($medialinks_table.personID) as pcount
		FROM ($medialinks_table, $sources_table, $citations_table, $families_table)
		WHERE $medialinks_table.personID = $sources_table.sourceID
			AND $medialinks_table.gedcom = $sources_table.gedcom
			AND $medialinks_table.gedcom = $citations_table.gedcom
			AND $medialinks_table.gedcom = $families_table.gedcom
			AND $sources_table.sourceID = $citations_table.sourceID
			AND $citations_table.persfamID = $families_table.familyID
			AND $medialinks_table.mediaID = '$itemID'
			AND living = 1 AND ($fcriteria)";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );
   	mysql_free_result( $result );
	if( $row[pcount] )
		return false;
	*/

    // so we made it here ok, so there must not be any Living individulals linked to this media
    return true;
}

function treeDropdown($forminfo) {
	global $text, $requirelogin, $assignedtree, $trees_table, $time_offset, $treerestrict;

	$ret = "";
	if(!$requirelogin || !$treerestrict || !$assignedtree) {
		$lid = $forminfo['lastimport'] ? ", lastimportdate" : "";
		$query = "SELECT gedcom, treename$lid FROM $trees_table ORDER BY treename";
		$treeresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$numtrees = mysql_num_rows($treeresult);

		if( $numtrees > 1 ) {
			if($forminfo['startform'])
				$ret .= getFORM( $forminfo['action'], $forminfo['method'], $forminfo['name'], $forminfo['id'] );
			$ret .= "<span class=\"normal\">$text[tree]: </span>";
			$ret .= treeSelect($treeresult);
			if(is_array($forminfo['hidden'])) {
				foreach($forminfo['hidden'] as $hidden)
					$ret .= "<input type=\"hidden\" name=\"" . $hidden['name'] . "\" value=\"" . $hidden['value'] . "\" />\n";
			}
			$ret .= "<input type=\"submit\" value=\"$text[go]\" />\n";
			if($forminfo['endform'])
				$ret .= "</form><br/>\n";
		}
		elseif( $forminfo['lastimport']) {
			$row = mysql_fetch_assoc( $treeresult );
			$lastimport = $row[lastimportdate];

			if( $lastimport ) {
				$importtime = strtotime($lastimport);
				if(substr($lastimport,11,8) != "00:00:00")
					$importtime += ($time_offset * 3600);
				$importdate = strftime("%d %b %Y %H:%M:%S",$importtime);
				echo "<p class=\"normal\">$text[lastimportdate]: " . displayDate($importdate) . "</p>";
			}
		}
		mysql_free_result($treeresult);
	}
	return $ret;
}

function treeSelect($treeresult) {
	global $text, $tree;

	$ret = "<select name=\"tree\" id=\"treeselect\">\n";
	$ret .= "<option value=\"-x--all--x-\" ";
	if( !$tree ) $ret .= "selected=\"selected\"";
	$ret .= ">$text[alltrees]</option>\n";

	while( $row = mysql_fetch_assoc($treeresult) ) {
		$ret .= "<option value=\"$row[gedcom]\"";
		if( $tree && $row[gedcom] == $tree ) $ret .= " selected=\"selected\"";
		$ret .= ">$row[treename]</option>\n";
	}
	$ret .= "</select>\n";
	return $ret;
}

function getMediaHREF($row,$mlflag) {
	global $mediatypes_assoc, $mediapath, $htmldocs, $imagetypes, $videotypes, $recordingtypes, $notrunc;

	$histories_url = getURL( "histories", 1 );
	$showmedia_url = getURL( "showmedia", 1 );

	$uselink = "";

    if( $row[form] )
		$form = strtoupper($row[form]);
	else {
		preg_match( "/\.(.+)$/", $row[path], $matches );
		$form = strtoupper($matches[1]);
	}
	$thismediatype = $row[mediatypeID];
	$usefolder = $row[usecollfolder] ? $mediatypes_assoc[$thismediatype] : $mediapath;


	if( !$row[abspath] && (in_array($form,$imagetypes) || in_array($form,$videotypes) || in_array($form,$recordingtypes) || !$form) ) {
		$uselink = $showmedia_url . "mediaID=$row[mediaID]";
		if( $mlflag == 1 )
			$uselink .= "&amp;medialinkID=$row[medialinkID]";
		elseif( $mlflag == 2 )
			$uselink .= "&amp;albumlinkID=$row[albumlinkID]";
		$uselink .= $row['all'] ? "&amp;all=1" : "";
	}
	else {
		$notrunc = 1;
		if($row[abspath])
			$uselink = $row[path];
		elseif( in_array( $form, $htmldocs ) && $cms[support] )
			$uselink = $histories_url . "inc=$row[path]";
		else {
			$url = rawurlencode( $row[path] );
			$url = str_replace("%2F","/",$url);
			$url = str_replace("%3F","?",$url);
			$url = str_replace("%23","#",$url);
			$url = str_replace("%26","&",$url);
			$url = str_replace("%3D","=",$url);
			$uselink = "$usefolder/$url";
		}
	}
	if($row[newwindow])
		$uselink .= "\" target=\"_blank";

	return $uselink;
}

function insertLinks($notes) {
	$pos = 0;
	while (($pos = strpos($notes, "http", $pos)) !== FALSE) {
		if( $pos ) $prevchar = substr( $notes, $pos - 1, 1 );
		if( $pos == 0 || $prevchar != "\"" )
	    	$notepos[] = $pos++;
		else
			$pos++;
	}
	$posidx = count($notepos);
	while( $posidx > 0 ) {
		$actual = $posidx - 1;
		$pos = $notepos[$actual];
		$firstpart = substr($notes,0,$pos);
		$rest = substr($notes,$pos);
		$linkstr = strtok($rest," ,<\n");
		if( substr( $linkstr, -1 ) == "." ) $linkstr = substr( $linkstr, 0, -1 );
		$lastpart = substr($notes,$pos + strlen($linkstr));
		$notes = $firstpart . "<a href=\"$linkstr\">$linkstr</a>" . $lastpart;
		$posidx--;
	}

	return $notes;
}

function isPhoto($row) {
	global $imagetypes;

	if($row['path'] && !$row['abspath'] && in_array($row['form'],$imagetypes))
		return true;
	else
		return false;
}
?>
