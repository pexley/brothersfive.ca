<?php
//Change these vars to affect max width & height of your photo. Aspect ratio will be maintained. Leaving
//these values blank will cause your photo to be displayed actual size.
$maxwidth = "175";
$maxheight = "175";

$showmedia_url = getURL( "showmedia", 1);

$query = "SELECT DISTINCT $media_table.mediaID, $media_table.description, path, alwayson, usecollfolder, mediatypeID FROM $media_table WHERE mediatypeID = \"photos\" ORDER BY RAND()"; 
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
while( $imgrow = mysql_fetch_assoc( $result ) ) {

    // if the picture is alwayson or we are allowing living to be displayed, we don't need to bother
    // with any further checking
    if ($imgrow[alwayson] || $allow_living_db ) {
	break;

    // otherwise, let's check for living
    } else {

	// this query will return rows of personIDs on the photo that are living
	$query = "SELECT $medialinks_table.personID FROM $medialinks_table JOIN $people_table on $medialinks_table.personID = $people_table.personID WHERE $medialinks_table.mediaID = $imgrow[mediaID] AND $people_table.living = \"1\"";
	$presult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$rows = mysql_num_rows( $presult );
	mysql_free_result( $presult );

	// if no rows are returned, there are no living on the photo, so let's display it
	if ($rows == 0) {
	    break;
	}
    }
}
mysql_free_result( $result );

$usefolder = $imgrow[usecollfolder] ? $photopath : $mediapath;
$photoinfo = @GetImageSize( "$rootpath$usefolder/$imgrow[path]" );
$photowtouse = $photoinfo[0];
$photohtouse = $photoinfo[1];

//these lines do the resizing
if( $maxheight && $photohtouse > $maxheight ) {
    $photowtouse = intval( $maxheight * $photowtouse / $photohtouse );
    $photohtouse = $maxheight;
}
if( $maxwidth && $photowtouse > $maxwidth ) {
    $photohtouse = intval( $maxwidth * $photohtouse / $photowtouse );
    $photowtouse = $maxwidth;
}

//these lines restrict the table width so the caption will not be wider than the photo
if( $maxwidth ) $width = "width=\"$maxwidth\"";
if( $maxheight ) $height = "height=\"$maxheight\"";

echo "<table>\n";
echo "<tr><td align=\"center\"><a href=\"$showmedia_url" . "mediaID=$imgrow[mediaID]\"><img src=\"$usefolder/" . str_replace("%2F","/",rawurlencode( $imgrow[path] )) . "\" border=\"1\" width=\"$photowtouse\" height=\"$photohtouse\" alt=\"$imgrow[description]\"></a></td></tr>\n";
echo "<tr><td align=\"center\"><span class=\"normal\"><a href=\"$showmedia_url" . "mediaID=$imgrow[mediaID]\">$imgrow[description]</a></span></td></tr>";
echo "</table>";
?>
