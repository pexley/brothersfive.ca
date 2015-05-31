<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "photos";
include("../getlang.php");
include("../$mylanguage/admintext.php");
include($subroot . "importconfig.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( !$allow_add ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

function importFrom($path,$needsubdirs) {
	global $rootpath, $media_table, $mediatypeID, $tree, $time_offset;
	$subdirs = array();

	@chdir("$rootpath$path") or die("Unable to open $rootpath$path. Please check your Root Path (General Settings).");
	if( $handle = @opendir('.') ) {
		while ($filename = readdir( $handle )) {
			if( is_file( $filename ) ) {
				echo "Inserting $path/$filename ... ";
				//insert ignore into database
				$fileparts = pathinfo( $filename );
				$form = strtoupper( $fileparts["extension"] );
				$newdate = date ("Y-m-d H:i:s", time() + ( 3600 * $time_offset ) );
				$query = "INSERT IGNORE INTO $media_table (mediatypeID,mediakey,gedcom,path,thumbpath,description,notes,width,height,datetaken,placetaken,owner,changedate,form,alwayson,map,abspath,status,cemeteryID,showmap,linktocem,latitude,longitude,zoom,bodytext,usenl,newwindow,usecollfolder)
					VALUES (\"$mediatypeID\",\"$path/$filename\",\"$tree\",\"$filename\",\"\",\"$filename\",\"\",\"\",\"\",\"\",\"\",\"\",\"$newdate\",\"$form\",\"0\",\"\",\"0\",\"\",\"\",\"0\",\"0\",\"\",\"\",\"0\",\"\",\"0\",\"0\",\"1\")";
				$result = @mysql_query($query);
				$success = @mysql_affected_rows($link);
				//$success = 1;
				if($success)
					echo "success<br/>\n";
				else
					echo "<strong>failed (duplicate)</strong><br/>\n";
			}
			elseif($needsubdirs && is_dir($filename) && $filename != '..' && $filename != '.')
				array_push($subdirs,$filename);
		}
		closedir( $handle );
	}
	
	return $subdirs;
}

$helplang = findhelp("data_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader( $admtext['phimport'], $flags );

$tngpath = $mediatypes_assoc[$mediatypeID];
?>
</head>

<body background="../background.gif">

<?php
	$mediatabs[0] = array(1,"media.php",$admtext['search'],"findmedia");
	$mediatabs[1] = array($allow_add,"newmedia.php",$admtext['addnew'],"addmedia");
	$mediatabs[2] = array($allow_edit,"ordermediaform.php",$admtext['text_sort'],"sortmedia");
	$mediatabs[3] = array($allow_edit && !$assignedtree,"thumbnails.php",$admtext['thumbnails'],"thumbs");
	$mediatabs[4] = array($allow_add,"photoimport.php",$admtext[import],"import");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/media_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($mediatabs,"import",$innermenu);
	echo displayHeadline("$admtext[media] &gt;&gt; $admtext[import]","photos_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow normal">
<?php
	$subdirs = importFrom($tngpath,1);
	foreach($subdirs as $subdir) {
		chdir("$rootpath$tngpath/$subdir");
		importFrom("$tngpath/$subdir",0);
	}
?>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>

</body>
</html>
