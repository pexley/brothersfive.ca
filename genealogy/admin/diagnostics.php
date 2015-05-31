<?php
//This page written and contributed by Bert Deelman. Thanks, Bert!
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "logconfig.php");
include($subroot . "importconfig.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
include("checklogin.php");
include("../version.php");

$file_uploads = (bool) ini_get("file_uploads");
$safe_mode = (bool) ini_get("safe_mode");

error_reporting( E_ERROR | E_PARSE );	//	Disable error reporting for anything but critical errors

$helplang = findhelp("setup_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[diagnostics], $flags );
?>
</head>

<body background="../background.gif">

<?php
	$setuptabs[0] = array(1,"setup.php",$admtext['configuration'],"configuration");
	$setuptabs[1] = array(1,"diagnostics.php",$admtext['diagnostics'],"diagnostics");
	$setuptabs[2] = array(1,"setup.php?sub=tablecreation",$admtext['tablecreation'],"tablecreation");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/setup_help.php#diagnostics', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($setuptabs,"diagnostics",$innermenu);
	echo displayHeadline("$admtext[setup] &gt;&gt; $admtext[diagnostics]","setup_icon.gif",$menu,"");
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr>
  <td class="tngshadow databack" valign="top" colspan="2">
    <span class="normal"><em><?php echo $admtext['sysinfo']; ?></em>
  </td>
</tr>
<tr>
  <td class="tngshadow databack" valign="top"><span class="normal"><?php echo $admtext['phpver']; ?>:<br><em><?php echo $admtext['phpreq']; ?></em></span></td>
  <td class="tngshadow databack" valign="top"><span class="normal">
<?php 
	if (phpversion() >= '4.0.4') { 
    	echo "<img src=\"green.gif\" width=\"12\" height=\"12\">&nbsp;"; } 
    else { echo '&nbsp;<img src="red.gif" width="12" height="12">&nbsp;';	}		
       echo 'PHP '.phpversion(); ?><br />
       <a href="phpinfo.php"><?php echo $admtext[phpinf]; ?></a>
      </span></td>
  </tr>
<tr>
  <td class="tngshadow databack" valign="top"><span class="normal"><?php echo $admtext['gdlib']; ?>:<br><em><?php echo $admtext['gdreq']; ?></em></span></td>
  <td class="tngshadow databack" valign="top"><span class="normal">
<?php 
	if (extension_loaded('gd')) {
		if (ImageTypes() & IMG_GIF)
			echo "<img src=\"green.gif\" width=\"12\" height=\"12\">&nbsp;$admtext[available]";
		else 
			echo "<img src=\"orange.gif\" width=\"12\" height=\"12\">&nbsp;$admtext[availnogif]";
	} 
	else
		echo "<img src=\"red.gif\" width=\"12\" height=\"12\">&nbsp;$admtext[notinst]";
?>
	</span></td>
</tr>
<tr>
  <td class="tngshadow databack" valign="top"><span class="normal"><?php echo $admtext['safemode']; ?>:</span></td>
  <td class="tngshadow databack" valign="top"><span class="normal">
<?php 
  	if (!$safe_mode)
		echo "<img src=\"green.gif\" width=\"12\" height=\"12\">&nbsp;$admtext[off]";
	else 
		echo "<img src=\"orange.gif\" width=\"12\" height=\"12\">&nbsp;$admtext[on]";
?>
	</span></td>
</tr>
<tr>
  <td class="tngshadow databack" valign="top"><span class="normal"><?php echo $admtext['fileuploads']; ?>:<br><em><?php echo $admtext['fureq']; ?></em></span></td>
  <td class="tngshadow databack" valign="top"><span class="normal">
<?php 
	if ($file_uploads)
		echo "<img src=\"green.gif\" width=\"12\" height=\"12\">&nbsp;$admtext[perm]";
	else
		echo "<img src=\"red.gif\" width=\"12\" height=\"12\">&nbsp;$admtext[notperm]";
?>
	</span></td>
  </tr>
  <tr>
    <td class="tngshadow databack" valign="top"><span class="normal"><?php echo $admtext['sqlver']; ?>:<br><em><?php echo $admtext['sqlreq']; ?></em></span></td>
    <td class="tngshadow databack" valign="top"><span class="normal">
<?php
	$dbci = mysql_get_client_info();
	if ($dbci >= '3.23')
		echo "<img src=\"green.gif\" width=\"12\" height=\"12\">&nbsp;";
	else {
		if ($dbci >= '3.20.32')
			echo "<img src=\"orange.gif\" width=\"12\" height=\"12\">&nbsp;";
		else
			echo "<img src=\"red.gif\" width=\"12\" height=\"12\">&nbsp;";
	}
	echo 'MySQL '.mysql_get_client_info() . " $admtext[client]<br />";
	$dbsi = mysql_get_server_info();
	if ($dbsi >= '3.23')
		echo "<img src=\"green.gif\" width=\"12\" height=\"12\">&nbsp;";
	else {
		if ($dbsi >= '3.20.32')
			echo "<img src=\"orange.gif\" width=\"12\" height=\"12\">&nbsp;";
		else
			echo "<img src=\"red.gif\" width=\"12\" height=\"12\">&nbsp;";
	}
	echo 'MySQL '.mysql_get_server_info() . " $admtext[server]<br />";
?>
	</span></td>
  </tr>
  <tr>
    <td class="tngshadow databack" valign="top"><span class="normal"><?php echo $admtext['wsrvr']; ?>:</span></td>
    <td class="tngshadow databack" valign="top"><span class="normal">
<?php 
	echo "<img src=\"green.gif\" width=\"12\" height=\"12\">&nbsp;";
	echo $_SERVER["SERVER_SOFTWARE"];
?>
	</span></td>
  </tr>
  <tr>
    <td valign="top" class="tngshadow databack"><span class="normal"><?php echo $admtext['fperms']; ?>:<br><em><?php echo $admtext['fpreq']; ?></em></span></td>
    <td class="tngshadow databack"><span class="normal"><?php
			$myuserid = getmyuid();
			if (phpversion() >= '4.1.0') { $mygroupid = getmygid(); } else { $mygroupid = getmyuid(); }

			if (function_exists('posix_getuid')) {
				$posixmyuserid = posix_getuid();
				$posixuserinfo = posix_getpwuid ($posixmyuserid);
				$posixname = $posixuserinfo["name"];
				$posixmygroupid = $posixuserinfo["gid"];
				$posixgroupinfo = posix_getgrgid ($posixmygroupid);
				$posixgroup = $posixgroupinfo["name"];

				//if ($myuserid != $posixmyuserid) {
				//	echo '<img src="orange.gif" width="12" height="12">&nbsp;';
				//	echo "$admtext[scruser] $posixname; $admtext[phpuser] $myuserid. $admtext[usrprob]<br />";
				//}
			} else {
				$posixmyuserid = $myuserid;
				$posixname = get_current_user();
				$posixmygroupid = $mygroupid;
				$posixgroup = '';
			}

			if ($myuserid != $posixmyuserid) { $myuserid = $posixmyuserid; }
			if ($mygroupid != $posixmygroupid) { $mygroupid = $posixmygroupid; }

			$text  = '';
			$ftext = '';
			// check files
			if (!(fileReadWrite($myuserid,$mygroupid,$subroot . 'config.php')))
				$text = "<img src=\"red.gif\" width=\"12\" height=\"12\"> $admtext[rofile] config.php";
			$uselog = $cms[support] ? "../../../$logname" : "../$logname";
			if (!(fileReadWrite($myuserid,$mygroupid, $uselog )))
				$ftext = "<br/><img src=\"red.gif\" width=\"12\" height=\"12\"> $admtext[rofile] $admtext[publog] ($logname)";
			if (!(fileReadWrite($myuserid,$mygroupid,$adminlogfile))) { 
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"red.gif\" width=\"12\" height=\"12\"> $admtext[rofile] $admtext[admlog] ($adminlogfile)"; 
			}
			if (!(fileReadWrite($myuserid,$mygroupid,$subroot . 'importconfig.php'))) {
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"red.gif\" width=\"12\" height=\"12\"> $admtext[rofile] importconfig.php"; 
			} 
			if (!(fileReadWrite($myuserid,$mygroupid,$subroot . 'logconfig.php'))) { 
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"red.gif\" width=\"12\" height=\"12\"> $admtext[rofile] logconfig.php"; 
			} 
			if (!(fileReadWrite($myuserid,$mygroupid,$subroot . 'pedconfig.php'))) {
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"red.gif\" width=\"12\" height=\"12\"> $admtext[rofile] pedconfig.php";
			}
			if (!(fileReadWrite($myuserid,$mygroupid,$subroot . 'mapconfig.php'))) {
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"red.gif\" width=\"12\" height=\"12\"> $admtext[rofile] mapconfig.php";
			}

			// check folders
			if (!(dirExists($photopath))) {
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"red.gif\" width=\"12\" height=\"12\"> $admtext[folderdne] $photopath"; }
			else {
				if (!(dirReadWrite($myuserid,$mygroupid,$photopath))) { 
					if( $ftext ) $ftext .= '<br />';
					$ftext .= "<img src=\"orange.gif\" width=\"12\" height=\"12\"> $admtext[rofolder] $photopath ($rootpath$photopath)"; 
				}
			}
			if (!(dirExists($headstonepath))) {
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"red.gif\" width=\"12\" height=\"12\"> $admtext[folderdne] $headstonepath"; }
			else {
				if (!(dirReadWrite($myuserid,$mygroupid,$headstonepath))) { 
					if( $ftext ) $ftext .= '<br />';
					$ftext .= "<img src=\"orange.gif\" width=\"12\" height=\"12\"> $admtext[rofolder] $headstonepath ($rootpath$headstonepath)"; 
				}
			}
			if (!(dirExists($historypath))) {
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"orange.gif\" width=\"12\" height=\"12\"> $admtext[folderdne] $historypath ($rootpath$historypath)"; 
			}
			else {
				if (!(dirReadWrite($myuserid,$mygroupid,$historypath))) { 
					if( $ftext ) $ftext .= '<br />';
					$ftext .= "<img src=\"orange.gif\" width=\"12\" height=\"12\"> $admtext[rofolder] $historypath ($rootpath$historypath)"; 
				}
			}
			if (!(dirExists($backuppath))) {
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"orange.gif\" width=\"12\" height=\"12\"> $admtext[folderdne] $backuppath ($rootpath$backuppath)"; 
			}
			else {
				if (!(dirReadWrite($myuserid,$mygroupid,$backuppath))) { 
					if( $ftext ) $ftext .= '<br />';
					$ftext .= "<img src=\"orange.gif\" width=\"12\" height=\"12\"> $admtext[rofolder] $backuppath ($rootpath$backuppath)"; 
				}
			}
			if (!(dirExists($gedpath))) {
				if( $ftext ) $ftext .= '<br />';
				$ftext .= "<img src=\"orange.gif\" width=\"12\" height=\"12\"> $admtext[folderdne] $gedpath ($rootpath$gedpath)"; 
			}
			else {
				if (!(dirReadWrite($myuserid,$mygroupid,$gedpath))) { 
					if( $ftext ) $ftext .= '<br />';
					$ftext .= "<img src=\"orange.gif\" width=\"12\" height=\"12\"> $admtext[rofolder] $gedpath ($rootpath$gedpath)"; 
				}
			}
			if ($ftext == '')
				$ftext = "<img src=\"green.gif\" width=\"12\" height=\"12\"> $admtext[keyrw]";
			echo $ftext;

			if ($text == '') { 
				if( $ftext ) echo '<br />';
				echo "<img src=\"green.gif\" width=\"12\" height=\"12\"> $admtext[cfgrw]"; 
			}
			echo $text;
			?></span></td>
</tr>
<tr>
  <td colspan="2" class="tngshadow databack"><span class="normal">
    <img src="./green.gif" width="12" height="12">&nbsp;= <?php echo $admtext['acceptable']; ?><br />
    <img src="./orange.gif" width="12" height="12">&nbsp;= <?php echo $admtext['restricted']; ?><br />
    <img src="./red.gif" width="12" height="12">&nbsp;= <?php echo $admtext['needchngs']; ?><br />
    <br /><?php echo $admtext['yourbrowser'] . $_SERVER["HTTP_USER_AGENT"]; ?></span></td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
<?php
function fileReadWrite($myuserid,$mygroupid,$fileref)
{
	$rval = false;
	
	$userid = fileowner($fileref);
	$groupid = filegroup($fileref);
	$perms = readPerms(fileperms($fileref));

	if ($myuserid == $userid) {
		if (substr($perms,2,1) == 'w') {
			$rval = true;
		}
		elseif ($mygroupid == $groupid) {
			if (substr($perms,5,1) == 'w') {
				$rval = true;
			} elseif (substr($perms,8,1) == 'w') {
				$rval = true;
			}
		}
	} elseif ($mygroupid == $groupid) {
		if (substr($perms,5,1) == 'w') {
			$rval = true;
		}
	} elseif (substr($perms,8,1) == 'w') {
		$rval = true;
	}

	return $rval;
} // function fileReadWrite()

function dirExists($dirref)
{
	global $cms;
	
	$rval = false;
	$newdirref = $cms[support] ? '../../../' . $dirref : '../'.$dirref;

	if(is_dir($newdirref)) { $rval = true; }
	else { $rval = false; }
	return $rval;
}

function dirReadWrite($myuserid,$mygroupid,$dirref)
{
	global $cms;
	
	$rval = false;
	$newdirref = $cms[support] ? '../../../' . $dirref : '../'.$dirref;

	$userid = fileowner($newdirref);
	$groupid = filegroup($newdirref);
	$perms = readPerms(fileperms($newdirref));

	if ($myuserid == $userid) {
		if (substr($perms,2,1) == 'w') {
			$rval = true;
		}
		elseif ($mygroupid == $groupid) {
			if (substr($perms,5,1) == 'w') {
				$rval = true;
			} elseif (substr($perms,8,1) == 'w') {
				$rval = true;
			}
		}
	} elseif ($mygroupid == $groupid) {
		if (substr($perms,5,1) == 'w') {
			$rval = true;
		}
	} elseif (substr($perms,8,1) == 'w') {
		$rval = true;
	}

	return $rval;
} // function dirReadWrite()

function readPerms($in_Perms)
{
	$sP;

	if ($in_Perms & 0x1000) { $sP = 'p'; }	// FIFO pipe
	elseif ($in_Perms & 0x2000) { $sP = 'c'; }	// Character special
	elseif ($in_Perms & 0x4000) { $sP = 'd'; }	// Directory
	elseif ($in_Perms & 0x6000) { $sP = 'b'; }	// Block special
	elseif ($in_Perms & 0x8000) { $sP = '-'; }	// Regular
	elseif ($in_Perms & 0xA000) { $sP = 'l'; }	// Symbolic Link
	elseif ($in_Perms & 0xC000) { $sP = 's'; }	// Socket
	else { $sP = 'u'; }				// UNKNOWN

	// owner
	$sP .= (($in_Perms & 0x0100) ? 'r' : '-').(($in_Perms & 0x0080) ? 'w' : '-').(($in_Perms & 0x0040) ? (($in_Perms & 0x0800) ? 's' : 'x' ) : (($in_Perms & 0x0800) ? 'S' : '-'));
	// group
	$sP .= (($in_Perms & 0x0020) ? 'r' : '-').(($in_Perms & 0x0010) ? 'w' : '-').(($in_Perms & 0x0008) ? (($in_Perms & 0x0400) ? 's' : 'x' ) : (($in_Perms & 0x0400) ? 'S' : '-'));
	// world
	$sP .= (($in_Perms & 0x0004) ? 'r' : '-').(($in_Perms & 0x0002) ? 'w' : '-').(($in_Perms & 0x0001) ? (($in_Perms & 0x0200) ? 't' : 'x' ) : (($in_Perms & 0x0200) ? 'T' : '-'));
	return $sP;
} // function readPerms()
?>
