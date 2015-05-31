<?php
//Remove the following two lines before deploying copies of this file to the "histories" folder.
echo "Please remove this line and the \"exit\" line that follows before deploying this file to the \"histories\" folder.";
exit;

//Replace all the "include" lines in your pre-5.x histories with the following lines (up to the next comment)
include( "../begin.php");   //Nuke users must include "../../../begin.php" here
if( !$cms['support'] )
	$cms['tngpath'] = "../";
include($cms['tngpath'] ."genlib.php");
include($cms['tngpath'] ."getlang.php");
include($cms['tngpath'] ."$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] ."checklogin.php");
include($cms['tngpath'] . "log.php" );
//end of new include lines

$logstring = "<a href=\"/path_to_your_history_folder/this_file_name\">Your Title Here</a>";
writelog($logstring);
preparebookmark($logstring);

//Note: histories created this way may function differently that other histories when placed in an "album". If that is annoying to you, consider creating
//your history by pasting the text into Admin/Media/Body Text instead.

// Remove the comments (leading slashes) on the next line if you don't want the TNG menu icons to show on your history page.
//$flags[noicons] = true;
tng_header( "Your Title Here", $flags ); 
?>

Your history goes here (do not include a BODY tag). IMPORTANT: In order for links on this page to work, you must edit your custom header, footer and
meta files (see General Settings for their specific names) and make sure all file and internal link references are *absolute* and not relative. 
In other words, the default meta.html file contains a relative link to the style sheet "genstyle.css". To make it absolute, prefix that with the path
from your root folder (i.e., "/genealogy/genstyle.css").

<?php tng_footer( "" ); ?>
