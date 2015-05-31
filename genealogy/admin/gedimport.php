<?php
@ini_set( "magic_quotes_runtime", "0" );
@ini_set( "auto_detect_line_endings", "1" );
@ini_set( 'memory_limit' , '80M' );
$umfs = substr(ini_get("upload_max_filesize"),0,-1);
if($umfs < 10) @ini_set( "upload_max_filesize", "10M" );

include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "gedimport";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( !$allow_add || !$allow_add || !$allow_edit || $assignedbranch ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

include($subroot . "importconfig.php");
require( "datelib.php" );
require( "gedimport_trees.php" );
require( "gedimport_families.php" );
require( "gedimport_sources.php" );
require( "gedimport_people.php" );
require( "gedimport_misc.php" );
require("adminlog.php");
$today = date( "Y-m-d H:i:s" );

global $prefix, $medialinks, $eventlinks;
$medialinks = array();

function getMediaLinksToSave() {
	global $admtext, $events_table, $tree, $eventlinks, $medialinks_table, $events_table;

	$medialinks = array();
	$query = "SELECT medialinkID, mediaID, $medialinks_table.eventID, persfamID, eventtypeID, eventdate, eventplace, info
		FROM ($medialinks_table,$events_table)
		WHERE $medialinks_table.gedcom = \"$tree\" AND $medialinks_table.eventID != \"\" AND $medialinks_table.eventID = $events_table.eventID";
	$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while($row = mysql_fetch_assoc($result)) {
		$key = $row['persfamID'] . "::" . $row['eventtypeID'] . "::" . $row['eventdate'] . "::" . substr($row['eventplace'],0,40) . "::" . substr($row['info'],0,40);
		$key = ereg_replace("[^A-Za-z0-9:]","",$key);
		$value = $row['medialinkID'];
		$medialinks[$key][] = $value;
		$eventlinks[$value] = $row['eventID'];
	}
	return $medialinks;
}

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[datamaint], $flags );
?>
</head>

<body background="../background.gif">

<?php
	$datatabs[0] = array(1,"dataimport.php",$admtext['import'],"import");
	$datatabs[1] = array(1,"export.php",$admtext['export'],"export");
	$datatabs[2] = array(1,"secondmenu.php",$admtext['secondarymaint'],"second");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/data_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($datatabs,"import",$innermenu);
	echo displayHeadline("$admtext[datamaint] &gt;&gt; $admtext[gedimport]","data_icon.gif",$menu,$message);
?>
<div class="lightback" style="padding:2px">
<div class="databack normal" style="padding:5px">

<?php 
$stdevents = array("BIRT","SEX","DEAT","BURI","MARR","SLGS","SLGC","NICK","NSFX","TITL","BAPL","ENDL","CHAN","CALN","AUTH","PUBL","ABBR","TEXT" );
$pciteevents = array("NAME","BIRT","CHR","DEAT","BURI","BAPL","ENDL","SLGC");
$fciteevents = array("MARR","DIV","SLGS");

//read first line into $line
@set_time_limit(0);
$fp = false;
if( $remotefile && $remotefile != "none" ) {
	$fp = @fopen($remotefile,"r");
	if( $fp === false ) { die ( "$admtext[cannotopen] $remotefile. $admtext[umps]" ); }
	echo "<strong>$remotefile $admtext[opened]</strong><br/>\n";
	$savestate[filename] = $remotefile;
}
else if( $database ) {
	$localfile = $gedpath == "admin" || $gedpath == "" ? $database : "$rootpath$gedpath/$database";
	$fp = @fopen($localfile,"r");
	if( $fp === false ) { die ( "$admtext[cannotopen] $database" ); }
	echo "<strong>$database $admtext[opened]</strong><br/>\n";
	$savestate[filename] = $localfile;
}
if( $savestate[filename] ) {
	$tree = $tree1; //selected
	$query = "UPDATE $trees_table SET lastimportdate=\"$today\" WHERE gedcom=\"$tree\"";
	$result = @mysql_query( $query ) or die ("$admtext[cannotexecutequery]: $query");
		
	if( $del == "append" ) {
		//calculate offsets
		if( $offsetchoice == "auto" ) {
			$savestate['ioffset'] = getNewNumericID( "person", "person", $people_table );
			$savestate['foffset'] = getNewNumericID( "family", "family", $families_table );
			$savestate['soffset'] = getNewNumericID( "source", "source", $sources_table );
			$savestate['noffset'] = getNewNumericID( "note", "note", $xnotes_table );
			$savestate['roffset'] = getNewNumericID( "repo", "repo", $repositories_table );
		}		
		else
			$savestate[ioffset] = $savestate[foffset] = $savestate[soffset] = $savestate[noffset] = $savestate[roffset] = $useroffset;
		$savestate[del] = "match";
	}
	else {
		$savestate[del] = $del;
		$savestate[ioffset] = $savestate[foffset] = $savestate[soffset] = $savestate[noffset] = $savestate[roffset] = 0;
		//get all medialinks+events where eventID is not blank
		if($del != "no") {
			$medialinks = getMediaLinksToSave();
			$num_medialinks = count($medialinks);
		}
		if( $del == "yes" )
			ClearData( $tree );
	}

	$savestate['icount'] = 0;
	$savestate['fcount'] = 0;
	$savestate['scount'] = 0;
	$savestate['mcount'] = 0;
	$savestate['ncount'] = 0;
	$savestate['offset'] = 0;
	$savestate['ucaselast'] = $ucaselast ? 1 : 0;
	$savestate['norecalc'] = $norecalc ? 1 : 0;
	$savestate['neweronly'] = $neweronly ? 1 : 0;
	$savestate['media'] = $importmedia ? 1 : 0;
	$savestate['latlong'] = $importlatlong ? 1 : 0;
	$savestate['branch'] = $branch1;
	$mll = $savestate['media'] * 10 + $savestate['latlong'];

	if( $saveimport ) {	
		$query = "DELETE from $saveimport_table";
		$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		
		$sql = "INSERT INTO $saveimport_table (filename, icount, ioffset, fcount, foffset, scount, soffset, mcount, ncount, noffset, roffset, offset, delvar, ucaselast, norecalc, neweronly, media, gedcom, branch)  VALUES(\"$savestate[filename]\", 0, \"$savestate[ioffset]\", 0, \"$savestate[foffset]\", 0, \"$savestate[soffset]\", 0, 0, \"$savestate[noffset]\", \"$savestate[roffset]\", 0, \"$del\", $savestate[ucaselast], $savestate[norecalc], $savestate[neweronly], $mll, \"$tree\", \"$branch\")";
		$result = @mysql_query( $sql ) or die ("$admtext[cannotexecutequery]: $sql");
	}
}
else if ( $saveimport ){
	$checksql = "SELECT filename, icount, ioffset, fcount, foffset, scount, soffset, mcount, ncount, noffset, offset, ucaselast, norecalc, neweronly, media, branch, delvar from $saveimport_table WHERE gedcom = \"$tree\"";
	$result = @mysql_query( $checksql ) or die ("$admtext[cannotexecutequery]: $checksql");
	$found = mysql_num_rows( $result );
	if( $found ) {
		$row = mysql_fetch_assoc($result);
		$savestate['icount'] = $row['icount'];
		$savestate['fcount'] = $row['fcount'];
		$savestate['scount'] = $row['scount'];
		$savestate['mcount'] = $row['mcount'];
		$savestate['ncount'] = $row['ncount'];
		$savestate['ioffset'] = $row['ioffset'];
		$savestate['foffset'] = $row['foffset'];
		$savestate['soffset'] = $row['soffset'];
		$savestate['noffset'] = $row['noffset'];
		$savestate['roffset'] = $row['roffset'];
		$savestate['filename'] = $row['filename'];
		$savestate['offset'] = $row['offset'];
		$savestate['del'] = $row['delvar'];
		$savestate['ucaselast'] = $row['ucaselast'];
		$savestate['norecalc'] = $row['norecalc'];
		$savestate['neweronly'] = $row['neweronly'];
		$savestate['media'] = ($row['media'] > 9) ? 1 : 0;
		$savestate['latlong'] = $row['media'] % 2;
		$savestate['branch'] = $row['branch'];
		if( $savestate['del'] == "yes" )
			$savestate['del'] = "match";
		$fp = fopen($savestate['filename'],"r") or die ("$admtext[cannotopen] $savestate[filename] $admtext[toresume]");
		if( $fp === false ) { die ( "$admtext[cannotopen] $savestate[filename] $admtext[toresume]" ); }
		fseek( $fp, $savestate['offset'] );
		echo "<strong>$savestate[filename] $admtext[openedtoresume]</strong><br/>\n";

		if($del != "no") {
			$medialinks = getMediaLinksToSave();
			$num_medialinks = count($medialinks);
		}
	}
	else die($admtext[notresumed]);
}
$savestate[livingstr] = $savestate[norecalc] ? "" : ", living";
if( !$tngimpcfg[maxlivingage] ) $tngimpcfg[maxlivingage] = 110;
?>
<p class="normal"><strong><?php echo $admtext['importinggedcom']; ?></strong></p>
<?php
if( $saveimport && (!$remotefile || $remotefile == "none") ) {
	echo "<p>$admtext[ifimportfails] <a href=\"gedimport.php?tree=$tree\">$admtext[resume]</a>.</p>\n";
}

//get custom event types
$query = "SELECT eventtypeID, tag, description, keep, type, display FROM $eventtypes_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$custeventlist = array();
while( $row = mysql_fetch_assoc($result)) {
	$eventtype = strtoupper($row[type] . "_" . $row[tag] . "_" . $row[description]);
	$custevents[$eventtype][keep] = $row[keep];
	$custevents[$eventtype][display] = $row[display];
	$custevents[$eventtype][eventtypeID] = $row[eventtypeID];
	if( $row[keep] && !in_array( $eventtype, $custeventlist ) ) {
		array_push( $custeventlist, $eventtype );  //used to be $row[tag]
	}
}
mysql_free_result($result);

$stdnotes = array();
$notecount = 0;

if($fp === false)
	echo "Import failed. Your file is larger than the maximum size allowed by your server to be uploaded via a PHP web form. Have your host increase the value of \"upload_max_filesize\" (in php.ini), or upload your file to the \"gedcom\" folder and import it directly from there instead.";
else {
	$lineinfo = getLine( );
	while( $lineinfo[tag] ) {
		if( $lineinfo[level] == 0 ) {
			preg_match( "/^@(\S+)@/", $lineinfo[tag], $matches );
			$id = $matches[1];
			switch ( trim($lineinfo[rest]) ) {
				case "FAM":
					getFamilyRecord( $id, 0 );
					break;
				case "INDI":
					getIndividualRecord( $id, 0 );
					break;
				case "SOUR":
					getSourceRecord( $id, 0 );
					break;
				case "REPO":
					getRepoRecord( $id, 0 );
					break;
				case "NOTE":
					getNoteRecord( $id, 0 );
					break;
				case "OBJE":
					if( $savestate[media] ) {
						$mminfo = array();
						getMultimediaRecord( $id, 0 );
					}
					else
						$lineinfo = getLine( );
					break;
				default:
					if( strtok( $lineinfo[rest], " " ) == "NOTE" )
						getNoteRecord( $id, 0 );
					elseif($lineinfo['tag'] == "_PLAC" || $lineinfo['tag'] == "_PLAC_DEFN" || $lineinfo['tag'] == "PLAC")
						getPlaceRecord( $lineinfo[rest], 0 );
					else
						$lineinfo = getLine( );
					break;
			}
		}
		else
			$lineinfo = getLine();
	}
	@fclose( $fp );

	//blank out remaining event-based media links
	//foreach($medialinks as $medialinkarr) {
		//foreach($medialinkarr as $medialinkID) {
			//$query = "UPDATE $medialinks_table SET eventID = \"\" WHERE medialinkID = \"$medialinkID\"";
			//$result = @mysql_query($query);
			//if(!mysql_affected_rows()) {
				//$query = "DELETE FROM $medialinks_table WHERE medialinkID = \"$medialinkID\"";
				//$result = @mysql_query($query);
			//}
		//}
	//}
	//delete remaining holdover events (used for media link preservation)
	//$query = "DELETE from $events_table WHERE gedcom = \"$tree\" AND persfamID = \"XXX\"";
	//$result = @mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	if( $saveimport ) {
		$sql = "DELETE from $saveimport_table WHERE gedcom = \"$tree\"";
		$result = @mysql_query($sql) or die ("$admtext[cannotexecutequery]: $query");
	}
	?>
	<span class="normal">
	<br/><br/>
	<?php
	$treemsg = $tree ? ", $admtext[tree]: $tree/" : "";
	adminwritelog( "$admtext[gedimport]: $admtext[filename]:$savestate[filename]$treemsg; $savestate[icount] $admtext[people], $savestate[fcount] $admtext[families], $savestate[scount] $admtext[sources], $savestate[ncount] $admtext[notes]" );
	echo "$admtext[finishedimporting]<br/>$savestate[icount] $admtext[people], $savestate[fcount] $admtext[families], $savestate[scount] $admtext[sources], $savestate[ncount] $admtext[notes]";
}
?>
<br/>
</span>

<?php 
echo "<p><a href=\"secondary.php?secaction=$admtext[tracklines]&tree=$tree\">$admtext[tracklines]</a></p>";
echo "<p><a href=\"dataimport.php\">$admtext[backtodataimport]</a></p>\n";
echo "</div></div>\n";
echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; 
?>
</body>
</html>
