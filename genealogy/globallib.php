<?php
@ini_set( "session.bug_compat_warn", "0" );
session_start();
session_register('session_language');
session_register('session_charset');
$session_language = $_SESSION[session_language];
$session_charset = $_SESSION[session_charset];
session_register('assignedtree');

@set_time_limit(0);
$register_globals = (bool) ini_get('register_globals');
//set binary to "binary" for more sensitive searches
$binary = "";
$maxnoteprev = 350;
$notrunc = 0; //don't truncate if link doesn't go to showmedia

if($_GET['cms'] || $_POST['cms']) die("Sorry!");

if( !$register_globals ) {
	if( $_SERVER && is_array( $_SERVER ) ) {
		foreach( $_SERVER as $key=>$value ) {
			${$key} = $value;
		}
	}
	if( $_ENV && is_array( $_ENV ) ) {
		foreach( $_ENV as $key=>$value ) {
			${$key} = $value;
		}
	}
	if( $_FILES && is_array( $_FILES ) ) {
		foreach( $_FILES as $key=>$value ) {
			${$key} = $value[tmp_name];
		}
	}
}
if( $_GET && is_array( $_GET ) ) {
	foreach( $_GET as $key=>$value ) {
		if($key == 'lang' || $key == 'mylanguage') die("sorry!");
		${$key} = $value;
	}
}
if( $_POST && is_array( $_POST ) ) {
	foreach( $_POST as $key=>$value ) {
		if($key == 'lang' || $key == 'mylanguage') die("sorry!");
		${$key} = $value;
	}
}
if( $offset && !is_numeric($offset) ) die ("invalid offset");

function tng_db_connect($dbhost,$dbname,$dbusername,$dbpassword) {
	global $textpart, $session_charset;
	$link = @mysql_connect($dbhost, $dbusername, $dbpassword);
	if ($session_charset == 'UTF-8')
	  	@mysql_query("SET NAMES 'utf8'");
	if( $link && mysql_select_db($dbname))
		return $link;
	else if( $textpart != "setup" && $textpart != "index" ) {
		echo "Error: TNG is not communicating with your database. Please check your database settings and try again.";
		exit;
	}
	return( FALSE );
}

function getEventDisplay( $displaystr ) {
	global $mylanguage;
	
	$dispvalues = explode( "|", $displaystr );
	$numvalues = count( $dispvalues );
	if( $numvalues > 1 ) {
		$displayval = "";
		for( $i = 0; $i < $numvalues; $i += 2 ) {
			$lang = $dispvalues[$i]; 
			if( $mylanguage == $lang ) {
				$displayval = $dispvalues[$i+1];
				break;
			}
		}
	}
	else
		$displayval = $displaystr;
		
	return $displayval;
}

function checkbranch( $branch ) {
	global $assignedbranch;

	return ( !$assignedbranch || ( FALSE !== ( $pos = strpos( $branch, $assignedbranch, 0 ) ) ) ) ? 1 : 0;
}

function getScriptName() {
	global $_SERVER;

	return $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'];
}

function get_browseitems_nav( $total, $address, $perpage, $pagenavpages ) {
	global $page, $totalpages, $tree, $text, $orgtree;

	if( !$page ) $page = 1;
	if( !$perpage ) $perpage = 50;

	if( $total <= $perpage )
		return "";

	$totalpages = ceil( $total / $perpage );
	if ( $page > $totalpages ) $page = $totalpages;

	if( $page > 1 ) {
		$prevpage = $page-1;
		$navoffset = ( ( $prevpage * $perpage ) - $perpage );
		$prevlink = " <a href=\"$address=$navoffset&amp;tree=$orgtree&amp;page=$prevpage\" class=\"snlink\" title=\"$text[text_prev]\">&laquo;$text[text_prev]</a> ";
	}
	if ($page<$totalpages) {
		$nextpage = $page+1;
		$navoffset = (($nextpage * $perpage) - $perpage);
		$nextlink = "<a href=\"$address=$navoffset&amp;tree=$orgtree&amp;page=$nextpage\" class=\"snlink\" title=\"$text[text_next]\">$text[text_next]&raquo;</a>";
	}
	while( $curpage++ < $totalpages ) {
   	$navoffset = ( ($curpage - 1 ) * $perpage );
		if( ( $curpage <= $page - $pagenavpages || $curpage >= $page + $pagenavpages ) && $pagenavpages ) {
			if( $curpage == 1 )
				$firstlink = " <a href=\"$address=$navoffset&amp;tree=$orgtree&amp;page=$curpage\" class=\"snlink\" title=\"$text[firstpage]\">&laquo;1</a> ... ";
		    if( $curpage == $totalpages )
				$lastlink = "... <a href=\"$address=$navoffset&amp;tree=$orgtree&amp;page=$curpage\" class=\"snlink\" title=\"$text[lastpage]\">$totalpages&raquo;</a>";
		}
		else {
			if( $curpage == $page )
				$pagenav .= " <span class=\"snlink snlinkact\">$curpage</span> ";
			else
				$pagenav .= " <a href=\"$address=$navoffset&amp;tree=$orgtree&amp;page=$curpage\" class=\"snlink\">$curpage</a> ";
		}
	}
	$pagenav = "<span class=\"normal\">$prevlink $firstlink $pagenav $lastlink $nextlink</span>";
	
	return $pagenav;
}

function doMenuItem( $index, $link, $image, $label, $page, $thispage ) {
	global $newbrowser;

	if( $page == $thispage ) {
		$divclass = " class=\"divhere\"";
		$class = " class=\"here\"";
	}
	$imagetext = $image ? "<img src=\"$image\" width=\"16\" height=\"15\" border=\"0\" alt=\"\" class=\"tngmenuicon\"/>" : "";
	if( $newbrowser )
		return "<li><a id=\"a$index\" href=\"$link\"$class>$imagetext$label</a></li>\n";
	else
		return "<div id=\"a$index\"$divclass><a href=\"$link\"$class>$imagetext$label</a></div>\n";
}

function displayDate( $date ) {
	global $dates;

	$newdate = "";
	$dateparts = explode( " ", $date );
	foreach( $dateparts as $datepart ) {
		if( !is_numeric( $datepart ) ) {
			$datepartu = strtoupper( $datepart );
			if( isset( $dates[$datepartu] ) )
				$datepart = $dates[$datepartu];
			elseif( $datepartu == "AND" )
				$datepart = $dates[TEXT_AND];
		}
		$newdate .= $newdate ? " $datepart" : $datepart;
	}

	return $newdate;
}

function xmlcharacters($string) {
	global $session_charset;

	$ucharset = strtoupper($session_charset);
	$enc = function_exists(mb_detect_encoding) ? @mb_detect_encoding($string) : "";
	if($enc && strtoupper($enc) == "UTF-8" && $ucharset == "UTF-8")
		return str_replace("&", "&#038;", @mb_convert_encoding($string, 'UTF-8', $enc));
	elseif($ucharset == "ISO-8859-1") {
		$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
		foreach ($trans as $k=>$v)
		    $trans[$k]= "&#".ord($k).";";
        $trans[chr(38)] = '&';  // don't translate the & when it is part of &xxx;
        // now translate & into &#38, but only when it is not part of &xxx or &#xxxx;
        return preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,5};)/","&#38;" , strtr($string, $trans));
	}
	else
		return str_replace("&", "&#38;", $string);
}

function generatePassword($flag) {
  $password = "";
  $possible = $flag ? "bcdfghjkmnpqrstvwxyz" : "0123456789bcdfghjkmnpqrstvwxyz";
  $length = 8;

  $i = 0;
  while( $i < $length ) {
    $char = substr( $possible, mt_rand( 0, strlen( $possible ) - 1 ), 1 );
    if( !strstr( $password, $char ) ) {
      $password .= $char;
      $i++;
    }
  }

  return $password;
}

function getXrefNotes($noteref, $tree="") {
	global $xnotes_table;

	preg_match( "/^@(\S+)@/", $noteref, $matches );
	if( $matches[1] ) {
		$query = "SELECT note from $xnotes_table WHERE noteID = \"$matches[1]\" AND gedcom=\"$tree\"";
		$xnoteres = @mysql_query( $query );
		if( $xnoteres ) {
			$xnote = mysql_fetch_assoc( $xnoteres );
			$note = trim( $xnote[note] );
		}
		mysql_free_result($xnoteres);
	}
	else
		$note = $noteref;
	return $note;
}

function getYears( $row ) {
	global $dates;

	$years = getGenderIcon( $row['sex'], -1 );
	if( $row['allow_living'] ) {
		$displaydeath = $row['death'] ? $row['death'] : displayDate($row['deathdate']);
		$displaydeath = $displaydeath != "Y" ? $displaydeath : $dates['Y'];
		$displaybirth = $row['birth'] ? $row['birth'] : displayDate($row['birthdate']);
		if( $displaybirth || $displaydeath )
			$years .= "$displaybirth - $displaydeath";
	}

	return $years;
}

function showSmallPhoto( $persfamID, $alttext, $living, $height, $adm=false ) {
	global $rootpath, $photopath, $documentpath, $headstonepath, $historypath, $mediapath, $mediatypes_assoc;
	global $photosext, $tree, $medialinks_table, $media_table, $text, $cms, $admtext;

	$photo = "";
	$photocheck = "";
	$pathprefix = $adm ? "../" : "";

	$query = "SELECT $media_table.mediaID, medialinkID, alwayson, thumbpath, mediatypeID, usecollfolder FROM ($media_table, $medialinks_table)
		WHERE personID = \"$persfamID\" AND $medialinks_table.gedcom = \"$tree\" AND $media_table.mediaID = $medialinks_table.mediaID AND defphoto = '1'";
	$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result );

	if($row[thumbpath]) {
		if( $adm || checkLivingLinks($row['mediaID'], $row['alwayson'] ) ) {
			$mediatypeID = $row['mediatypeID'];
			$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
			$photocheck = "$usefolder/$row[thumbpath]";
			$photoref = "$usefolder/" . str_replace("%2F","/",rawurlencode( $row['thumbpath'] ));
			if($adm)
				$prefix = "<a href=\"editmedia.php?mediaID=$row[mediaID]\">";
			else {
				$showmedia_url = getURL( "showmedia", 1 );
				$prefix = "<a href=\"$showmedia_url" . "mediaID=$row[mediaID]&amp;medialinkID=$row[medialinkID]\">";
			}
			$suffix = "</a>";
		}
	}
	elseif($living) {
		$photoref = $photocheck = $tree ? "$photopath/$tree.$persfamID.$photosext" : "$photopath/$persfamID.$photosext";
		$prefix = $suffix = "";
	}

	if( $photocheck && file_exists( "$rootpath$photocheck" ) ) {
		$border = $height ? 0 : 1;
		$align = $height ? "" : "align=\"left\"";
		$photoinfo = @GetImageSize( "$rootpath$photocheck" );
		$photohtouse = $height ? $height : 100;
		if( $photoinfo[1] <= $photohtouse ) {
			$photohtouse = $photoinfo[1];
			$photowtouse = $photoinfo[0];
		}
		else
			$photowtouse = intval( $photohtouse * $photoinfo[0] / $photoinfo[1] ) ;
		$photo = "$prefix<img src=\"$pathprefix$photoref\" border=\"$border\" alt=\"$alttext\" width=\"$photowtouse\" height=\"$photohtouse\" $align style=\"border-color:#000000;margin-right:6px\"/>$suffix";
	}
	mysql_free_result( $result );

	return $photo;
}

function checkMaintenanceMode($area){
	global $tngconfig;

	if($tngconfig['maint'] && (!$_SESSION['allow_admin_db'] || $_SESSION['assignedtree']) && strpos($_SERVER['SCRIPT_NAME'],"/index.") === FALSE) {
		$maint_url = $area ? "adminmaint.php" : getURL("maint",0);
		header("Location:$maint_url");
		exit;
	}
}

function cleanIt($string) {
	$string = htmlspecialchars(ereg_replace("\n"," ",$string), ENT_QUOTES);
	$string = ereg_replace("\"", "&#34;",$string);
	$string = ereg_replace("<", "&lt;",$string);
	$string = ereg_replace(">", "&gt;",$string);

	return $string;
}

function truncateIt($string,$length) {
	global $notrunc;

	$truncated = substr(strip_tags($string),0,$length);
	$truncated = !$notrunc && strlen($string) > $length ? substr($truncated,0,strrpos($truncated,' ')) . '&hellip;' : $string;

	return $truncated;
}
?>
