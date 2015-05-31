<?php
//jmj map mod
	$locations2map = array();
	$l2mCount = 0;
	$map[pins] = 0;

// these two lines used to remove or replace characters that cause problems
// with opening new Google maps
	$banish = array("(", ")", "#", "&", " from ", " to ", " van ", " naar ", " von ", " bis ", " da ", " a ", " de ", " à ", " vers ");
	$banreplace = array("[", "]", "", "and", " from%A0", " to%A0", " van%A0", " naar%A0", " von%A0", " bis%A0", " da%A0", " a%A0", " de%A0", "à%A0", "vers%A0");
	$mcharsetstr = "&amp;oe=$session_charset";

	//if place is unique, create HTML, put in array
	//if not,

// RM - this file written by Jerry is responsible for the maps that appear
// on public pages - it does the pin locating and map scaling to get all
// the pins onto the map. It's been modified some from what Jerry first wrote
function tng_map_pins() {
	global $locations2map,$l2mCount,$pinplacelevel0,$cms;
	global $map, $defermap;

	echo "<script type=\"text/javascript\">\n";
    echo "//<![CDATA[\n";
    echo "var baseIcon = new GIcon();\n";
    echo "baseIcon.shadow = \"$cms[tngpath]googlemaps/shadow50.png\";\n";
    echo "baseIcon.iconSize = new GSize(20, 34);\n";
    echo "baseIcon.shadowSize = new GSize(37, 34);\n";
    echo "baseIcon.iconAnchor = new GPoint(9, 34);\n";
    echo "baseIcon.infoWindowAnchor = new GPoint(9, 2);\n";
    echo "baseIcon.infoShadowAnchor = new GPoint(18, 25);\n";

// Creates a marker at the given point with the given label and popup infoWindow
	echo "var iconCounter=1;\n";
    echo "      function createMarker(point,html,pinplacelevel,markerIcon) {\n";
    echo "  var icon = new GIcon(baseIcon);\n";
    //echo "  icon.image = \"googlemaps/numbered_marker.php?image=\"+pinplacelevel+\".png&text=\"+markerIcon+\"&amp;name=Pin\"+pinplacelevel+\" . \"+markerIcon+\".png\";\n";
    echo "  icon.image = \"$cms[tngpath]googlemaps/numbered_marker.php?image=\"+pinplacelevel+\".png&text=\"+markerIcon+\"&name=pin\"+pinplacelevel+\" . no . \"+markerIcon+\".png\";\n";
	echo "  var marker = new GMarker(point, icon);\n";
    echo "        GEvent.addListener(marker, \"click\", function() {\n";
    echo "          marker.openInfoWindowHtml(html);\n";
    echo "        });\n";
    echo "        return marker;\n";
    echo "      }\n";
// The ShowTheMap
	echo "function ShowTheMap() ";
	echo "{\n";
	echo "if('undefined' == typeof zoomlevel) {zoomlevel = 0;}";
	if ( $map[key] != "" ) {
		echo "if (GBrowserIsCompatible()) {\n";
		echo "  var map = new GMap2(document.getElementById(\"map\"));\n";
		echo "   map.addControl(new GLargeMapControl());\n";
		echo "   map.addControl(new GScaleControl());\n";
		echo "   map.addControl(new GMapTypeControl());\n";
// set bogus default values, way out of range
		$minLat = 500;
		$maxLat = -500;
		$minLong = 500;
		$maxLong = -500;

// loop through places, figuring out center and if there are any to plot at all
		reset($locations2map);
		while (list($key, $val) = each($locations2map))
			{
		$lat=$val[lat];
		$long=$val[long];
		$zoom=$val[zoom];
		$pinplacelevel=$val[pinplacelevel];
			if ($lat != "" and $long !="") {
				if ($lat < $minLat) $minLat=$lat;
				if ($long < $minLong) $minLong=$long;
				if ($lat > $maxLat) $maxLat=$lat;
				if ($long > $maxLong) $maxLong=$long;
				}
			}
		$centLat=$minLat+(($maxLat-$minLat)/2);
		$centLong=$minLong+((abs($minLong)-abs($maxLong))/2);

// If still at default, hide the map
		if ($minLat == 500 ) {
			echo "var div = document.getElementById(\"map\");\n";
			echo "div.style.display = \"none\";\n";
		}
		echo "   map.setCenter(new GLatLng($centLat,$centLong), 10, $map[type]);\n";
		
// step through the places, drawing markers where needed
	echo "   var bounds = new GLatLngBounds();\n";
//	$maxZoom=15;
		reset($locations2map);
		$markerIcon=0;
		$usedplaces = array();
		while (list($key, $val) = each($locations2map)) {
			$lat = $val[lat];
			$long = $val[long];
			$htmlcontent = $val[htmlcontent];
			//$htmlcontent=str_replace("'", "''", $val[htmlcontent]);
			//$placelevel=$val[placelevel];
			$pinplacelevel=$val[pinplacelevel];
			if(!$pinplacelevel) $pinplacelevel = $pinplacelevel0;
			$zoom = $val[zoom] ? $val[zoom] : 10;
			$uniqueplace = $val[place] . $lat . $long;
			if($lat != "" && $long != "" && ($map[showallpins] || !in_array($uniqueplace,$usedplaces))) {
	// create marker
				$usedplaces[] = $uniqueplace;
				echo "   var point = new GLatLng($lat,$long);\n";
				$markerIcon++;
				echo "   var marker = createMarker(point,'$htmlcontent','$pinplacelevel','$markerIcon');\n";
				echo "   map.addOverlay(marker);\n";
	// change bounds to fit this one, too
				echo "   bounds.extend(point);\n";
				echo "map.setZoom(map.getBoundsZoomLevel(bounds));\n";
	   		}
			if ($zoom < $maxZoom) $maxZoom = $zoom;
		}

// recenter in new bounds windows
		echo "   var clat = (bounds.getNorthEast().lat() + bounds.getSouthWest().lat()) /2;\n";
		echo "   var clng = (bounds.getNorthEast().lng() + bounds.getSouthWest().lng()) /2;\n";
		echo "   map.setCenter(new GLatLng(clat,clng));\n";
		echo "   map.setCenter(bounds.getCenter());\n";
		echo " map.setZoom(map.getZoom() - 1);\n";
		echo " if (map.getZoom() > '$zoom') {map.setZoom($zoom);}\n";
		echo "}\n";
		echo "else {\n";
		echo "alert(\"Browser not compatible with Google Mapping Function.\");\n";
		echo "}\n";
		}
	else {
		echo "alert(\"No Google Map Site API Key Defined\");\n";
		}
	echo "maploaded = true;\n";
	echo "}\n";
	echo "//]]>\n";
	echo "</script>\n";

	echo "<script type=\"text/javascript\">\n";
	echo "var maploaded = false;\n";
	echo "function displayMap() {\n";
	echo "  if ($(\"map\")) {\n";
	echo "  ShowTheMap(); \n";
	echo "  }\n";
	echo "}\n";
	if(!isset($defermap) || !$defermap)
		echo "window.onload=displayMap;";
	echo "window.onunload=GUnload;";
	echo "</script>\n";
}

function stri_replace($find,$replace,$string) {
	if(!is_array($find)) $find = array($find);
	if(!is_array($replace)) {
    	if(!is_array($find)) $replace = array($replace);
		else {
			// this will duplicate the string into an array the size of $find
			$c = count($find);
			$rString = $replace;
			unset($replace);
			for ($i = 0; $i < $c; $i++) {
				$replace[$i] = $rString;
			}
		}
	}
	foreach($find as $fKey => $fItem) {
		$between = explode(strtolower($fItem),strtolower($string));
		$pos = 0;
		foreach($between as $bKey => $bItem) {
			$between[$bKey] = substr($string,$pos,strlen($bItem));
			$pos += strlen($bItem) + strlen($fItem);
		}
		$string = implode($replace[$fKey],$between);
	}
	return($string);
}
?>
