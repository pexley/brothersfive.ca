<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include($subroot . "importconfig.php");

initMediaTypes();

if( $path == "gedcom" )
	$tngpath = $gedpath;
else
	$tngpath = $mediatypes_assoc[$path];
$pagetotal = 50;

if( !isset( $subdir ) ) $subdir = '';
$ImageFileTypes = array("GIF","JPG","PNG");

header("Content-type:text/html; charset=" . $session_charset);

frmFiles();

function frmFiles() {
	global $ImageFileTypes, $subdir, $admtext, $text, $page, $rootpath, $path, $tngpath, $pagetotal, $searchstring;

	$columns = 4;
?>

<div class="databack" style="margin:10px;border:0px" id="filepicker">
<p class="subhead"><strong><?php echo $admtext['selectfile']; ?></strong></p>

<span class="normal">&nbsp;<?php echo "<b>$admtext[folder]:</b> $tngpath/$subdir"; ?></span><br/>
<table cellpadding="2" cellspacing="1" border="0" width="95%">
<?php
	$nCurrentPage = $page ? $page : 0;

	$lRecCount = lCountFiles();
	$nPages = intval( ( $lRecCount - 0.5 ) / $pagetotal ) + 1;
	$lStartRec = $nCurrentPage * $pagetotal;

	frmFilesHdFt( $columns, $nCurrentPage, $nPages );
?>
   <tr class="fieldnameback">
      <td nowrap align="left"><span class="fieldname"><b><?php echo $admtext[action]; ?></b></span></td>
      <td nowrap><span class="fieldname"><b><?php echo $admtext[filename]; ?></b></span></td>
      <td nowrap align="center"><span class="fieldname"><b><?php echo $admtext[size]; ?></b></span></td>
      <td nowrap align="center"><span class="fieldname"><b><?php echo $admtext[dimensions]; ?></b></span></td>
   </tr>
<?php
	$nImageNr = 0;
	$nImageShowed = 0;

	$savedir = getcwd();
	chdir("$rootpath$tngpath/$subdir");
	if( $handle = @opendir('.') ) {
		$fentries = array();
		$dentries = array();
		while ($file = readdir( $handle )) {
			if( !$searchstring || strpos(strtoupper($file),strtoupper($searchstring)) === 0 ) {
				if(is_file($file))
					array_push( $fentries, $file );
				else
					array_push( $dentries, $file );
			}
		}
		natcasesort( $fentries );
		natcasesort( $dentries );
		$entries = array_merge($dentries,$fentries);
		foreach( $entries as $file ) {
			$filename = $file;
			if( is_file( $filename ) ) {
				$fileparts = pathinfo( $filename );
				$file_ext = strtoupper( $fileparts["extension"] );
				if( $nImageNr >= $lStartRec && $nImageShowed < $pagetotal ) {
?>
	<tr>
		<td align="left" valign="middle" class="lightback">
			<span class="normal"><a href="javascript:ReturnFile('<?php echo "$subdir$file"; ?>')"><?php echo $admtext[select]; ?></a> | <a href="javascript:ShowFile('<?php echo "../$tngpath/$subdir$file"; ?>')"><?php echo $admtext[show]; ?></a></span>
        </td>
		<td valign="top" class="lightback">
			<span class="normal"><?php echo $file; ?></span>
		</td>
		<td align="center" valign="top" class="lightback">
			<span class="normal"><?php echo display_size( filesize( $file ) ); ?></span>
		</td>
<?php
					if(in_array($file_ext,$ImageFileTypes))
						$size = @GetImageSize($filename);
					else
						$size = "";
					if( $size ) {
						$imagesize1 = $size["0"];
						$imagesize2 = $size["1"];
						$imagesize = "$imagesize1 x $imagesize2";
					}
					else
						$imagesize = "";
?>
		<td align="center" valign="top" class="lightback">
			<span class="normal"><?php echo $imagesize; ?>&nbsp;</span>
		</td>
	</tr>
<?php
					$nImageShowed++;
				}
				$nImageNr++;
			}
			elseif( is_dir( $filename ) ) {
				if( ( ( $subdir != '' ) && ( $filename != '.' ) ) || ( ( $subdir == '' ) && ( $filename != '.' ) && ( $filename != '..' ) ) ) {
					if( $nImageNr >= $lStartRec && $nImageShowed < $pagetotal ) {
						if( $filename != '..' ) 
							$newsubdir = $subdir . $filename . '/';
						else {
							$dirbreakdown = explode( '/', $subdir );
							array_pop( $dirbreakdown ); 
							array_pop( $dirbreakdown );
							$newsubdir = implode( '/', $dirbreakdown ) . '/';
							if( $newsubdir == '/' ) $newsubdir = '';
						} 
?>
	<tr>
		<td align="left" valign="middle" class="lightback">
			<span class="normal"><a href="#" onclick="return moreFilepicker('<?php echo "subdir=$newsubdir&amp;path=$path"; ?>');"><?php echo $admtext['open']; ?></a></span>
		</td>
		<td valign="top" class="lightback">
			<span class="normal"><?php echo "<b>$admtext[folder]:</b> $filename"; ?></span>
		</td>
		<td align="center" valign="middle" class="lightback">&nbsp;</td>
		<td align="center" valign="middle" class="lightback">&nbsp;</td>
	</tr>
<?php
						$nImageShowed++;
					}
					$nImageNr++;
				}
			}
		}
		closedir( $handle );
	}
	chdir($savedir);

	frmFilesHdFt( $columns, $nCurrentPage, $nPages );
?>
   </table>
</div>
<?php
} // function frmFiles()


function lCountFiles() {
	global $ImageFileTypes, $subdir, $rootpath, $tngpath, $searchstring;
   
	$nFileCount = 0;
	$savedir = getcwd();
	chdir( "$rootpath$tngpath/$subdir" );
	if( $handle = @opendir('.') ) {
		while( $file = readdir( $handle ) ) {
			if( !$searchstring || strpos($file,$searchstring) === 0 ){
				$filename = $file;
				if( is_file( $filename ) ) {
					$fileparts = pathinfo( $filename );
					$file_ext = strtoupper( $fileparts["extension"] );
					$nFileCount++;
				}
				elseif( is_dir( $filename ) )
					if( ( $subdir != '' ) || ( $filename != '..' ) ) $nFileCount++;
			}
		}
		closedir( $handle );
	}
	chdir( $savedir );
	
	return $nFileCount;
} // function lCountFiles()

?>

<?php

function frmFilesHdFt( $colspan, $nCurrentPage, $nPages ) {
	global $subdir, $admtext, $path;
?>
	<tr>
		<td colspan="<?php echo $colspan; ?>" align="left">
			<table height="100%" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td align="right" class="databack">
						<span class="normal">
						<a href="#" onclick="return moreFilepicker('<?php echo "subdir=$subdir&amp;path=$path&amp;page=0"; ?>');"><img src="first_button.gif" border="0" width="15" height="15"></a>
<?php
	if ($nCurrentPage != 0) { 
?>
						<a href="#" onclick="return moreFilepicker('<?php echo "subdir=$subdir&path=$path&amp;page=" .  ($nCurrentPage - 1); ?>');"><img src="prev_button.gif" border="0" width="15" height="15"></a>
<?php
	} 
	$nCPage = $nCurrentPage + 1;
	echo "&nbsp;$admtext[page] $nCPage $admtext[of] $nPages &nbsp;";
	if( $nCurrentPage + 1 != $nPages ) { 
?>
						<a href="#" onclick="return moreFilepicker('<?php echo "subdir=$subdir&path=$path&amp;page=" . ($nCurrentPage + 1); ?>');"><img src="next_button.gif" border="0" width="15" height="15"></a>
<?php
	}
?>
						<a href="#" onclick="return moreFilepicker('<?php echo "subdir=$subdir&path=$path&amp;page=" . ($nPages - 1); ?>');"><img src="last_button.gif" border="0" width="15" height="15"></a>
						</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?php
} // function frmFilesHdFt()

function display_size( $file_size ) {
	if( $file_size >= 1073741824 )
		$file_size = round( $file_size / 1073741824 * 100 ) / 100 ."g";
    elseif( $file_size >= 1048576 ) 
		$file_size = round( $file_size / 1048576 * 100 ) / 100 ."m";
    elseif( $file_size >= 1024 ) 
		$file_size = round( $file_size / 1024 * 100) / 100 ."k";
    else
		$file_size = $file_size." bytes";
		
	return $file_size;
} // function display_size()
?>
