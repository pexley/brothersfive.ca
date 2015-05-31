<?php
$tngconfig = "";
include("subroot.php");
include($tngconfig['subroot'] . "config.php");
$color = substr( $_GET["rgbcolor"], 0, 1 ) == "#" ? substr( $_GET["rgbcolor"], 1 ) : $_GET["rgbcolor"];
$red = hexdec(substr( $color, 0, 2 ));
$green = hexdec(substr( $color, 2, 2 ));
$blue = hexdec(substr( $color, 4, 2 ));
$im = imageCreateFromPng( "tngtab.png" );
$rgb = ImageColorAt($im, 100, 10);
imagecolorset ( $im, $rgb, $red, $green, $blue);

if( $_GET["choice"] == "Display new tab" ) {
	header("Content-type: image/png");
	imagepng( $im );
}
else {
	$filename = $_GET["filename"];
	imagepng( $im, "$rootpath$photopath/$filename" );
	header("Content-type: text/html");
	echo "<h1>New TNG Tab Color</h1>\n";
	echo "<p>Your new tab has been saved at $rootpath$photopath/$filename.</p>\n";
	echo "<p>Please copy it to $rootpath$filename.</p>";
	echo "<p>Use the Back button on your browser to return to the previous page and create your other tab.</p>";
}
?>