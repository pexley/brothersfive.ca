<?php
// RM - this file is from Dan Bodor. It is what makes the Google Earth link on
// getperson.php work to create the file that Google Earth opens to fly to.

//code for making a KML file from long lat inputs m=world n=$place   lon=$lon   lat=$lat
	
$name = $_REQUEST['n'];
$lat = $_REQUEST['lat'];
$lon = $_REQUEST['lon'];
$zoom = $_REQUEST['z'];

//db mod for range calculation from zoom level
if ($zoom > 0)
	$range = pow(1.94,(20 - $zoom))*64*1.4;
else
	$range = 3000;

header('HTTP/1.1 200 OK');
header('Content-Type: application/keyhole');
header('Content-Disposition: inline; filename="'.$name.'.kml"');

$name = stripslashes($name);

// TRANSLATE LATIN FOREIGN LANGUAGE CHARACTERS INTO UNICODE HEX FOR GOOGLE EARTH
// tried to switch encoding in the XML code, but this didn't work for me and I switched it back
// CURRENTLY TAKES CARE OF CROATIAN AND GERMAN SPECIAL CHARACTERS - CAN ADD MORE FROM ONLINE CHARTS
// CAREFUL - SOME EDITING PROGRAMS INCLUDING FRONTPAGE MAY DAMAGE FOLLOWING CODE BY REMOVING THE FOREIGN CHARACTERS - DO NOT CLICK SAVE IF THESE HAVE BEEN REPLACED BY QUESTION MARKS - EDIT IN WORD OR NOTEPAD
	$name = ereg_replace("š","&#x0161;",$name);
	$name = ereg_replace("Š","&#x0160;",$name);	
	$name = ereg_replace("æ","&#x0107;",$name);	
	$name = ereg_replace("Æ","&#x0106;",$name);	
	$name = ereg_replace("ž","&#x017E;",$name);	
	$name = ereg_replace("Ž","&#x017D;",$name);	
	$name = ereg_replace("è","&#x010D;",$name);	
	$name = ereg_replace("È","&#x010C;",$name);	
	$name = ereg_replace("ð","&#x0111;",$name);	
	$name = ereg_replace("Ð","&#x0110;",$name);	
	$name = ereg_replace("ü","&#x00FC;",$name);	
	$name = ereg_replace("Ü","&#x00DC;",$name);	
	$name = ereg_replace("ö","&#x00F6;",$name);
	$name = ereg_replace("Ö","&#x00D6;",$name);	
	$name = ereg_replace("ä","&#x00E4;",$name);	
	$name = ereg_replace("Ä","&#x00C4;",$name);	
	$name = ereg_replace("ß","&#x00DF;",$name);

// note - In the KML CODE below, keep in mind that as tilt is increased, viewing distance is inadvertantly increased if range is constant

echo '<?xml version="1.0" encoding="UTF-8"?>'
?>
<kml xmlns="http://earth.google.com/kml/2.0">
<Placemark>
  <description> 
	    <![CDATA[This was found by lat/long data stored in your database.]]>	   	
    </description>
	<name><?php echo $name; ?></name>
  <LookAt>
    <longitude><?php echo $lon; ?></longitude>
    <latitude><?php echo $lat; ?></latitude>
    <range><?php echo $range; ?></range>
    <tilt>45</tilt>
    <heading>0</heading>
  </LookAt>
  <visibility>1</visibility>
<Point><coordinates><?php echo $lon.','.$lat; ?></coordinates></Point></Placemark></kml>
