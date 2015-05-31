<?php
//NOTES: "ID" is also the ID in alltext.php that holds the text to be displayed (ie, $text[photo] = "Photo"). It will exist in each language file.
//"Folder" is the location where files of this type are generally held.

global $photopath, $documentpath, $historypath, $headstonepath, $mediapath;
$mediatypes = array();
$mediatypes_assoc = array();
$mediatypes_icons = array();
$mediatypes_display = array();
$mctr = 0;

function setMediaType($newtype) {
	global $mediatypes, $mediatypes_assoc, $mediatypes_icons, $mediatypes_display, $mctr, $text;

	$ID = $newtype['mediatypeID'];

	$mediatypes[$mctr] = array();
	$mediatypes[$mctr][ID] = $ID;
	$mediatypes[$mctr]['folder'] = $newtype['path'];
	$mediatypes[$mctr]['icon'] = $newtype['icon'];
	$mediatypes[$mctr]['liketype'] = $newtype['liketype'];
	$mediatypes[$mctr]['display'] = $text[$ID] ? $text[$ID] : $newtype['display'];
	$mediatypes[$mctr]['type'] = $newtype['type'];
	$mediatypes_assoc[$ID] = $newtype['path'];
	$mediatypes_icons[$ID] = $newtype['icon'];
	$mediatypes_display[$ID] = $newtype['display'];
	$mctr++;
}

//To change display order of these groups, simply move the corresponding lines below up or down.

function initMediaTypes() {
	global $photopath, $documentpath, $headstonepath, $historypath, $mediapath, $mediatypes_table, $mediatypes;

	if(count($mediatypes)) return;

	//photos
	setMediaType(array("mediatypeID"=>"photos","path"=>$photopath,"icon"=>"tng_photo.gif","liketype"=>"photos","type"=>0));

	//documents
	setMediaType(array("mediatypeID"=>"documents","path"=>$documentpath,"icon"=>"tng_doc.gif","liketype"=>"documents","type"=>0));

	//headstones
	setMediaType(array("mediatypeID"=>"headstones","path"=>$headstonepath,"icon"=>"tng_hs.gif","liketype"=>"headstones","type"=>0));

	//histories
	setMediaType(array("mediatypeID"=>"histories","path"=>$historypath,"icon"=>"tng_hist.gif","liketype"=>"histories","type"=>0));

	//recordings
	setMediaType(array("mediatypeID"=>"recordings","path"=>$mediapath,"icon"=>"tng_rec.gif","liketype"=>"recordings","type"=>0));

	//video
	setMediaType(array("mediatypeID"=>"videos","path"=>$mediapath,"icon"=>"tng_video.gif","liketype"=>"videos","type"=>0));

	$query = "SELECT * FROM $mediatypes_table ORDER BY ordernum, display";
	$result = @mysql_query($query);

	if($result) {
		while($row = mysql_fetch_assoc($result)) {
			$row['type'] = 1;
			setMediaType($row);
		}
	}
}
?>
