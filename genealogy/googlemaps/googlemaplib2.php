<?php
if ( empty($row[latitude]) ) {
	$startzoom = $map[stzoom];
	$startlat = $map[stlat];
	$startlong = $map[stlong];
}
else {
	if ( empty($row[zoom]) )
		$startzoom = 13;
	else
		$startzoom = $row[zoom];
	$startlat = $row[latitude];
	$startlong = $row[longitude];
}
if($startzoom == "") $startzoom = 0;

if ( empty($row[placelevel]) ) {
	$placelevel = 1;
}
$mcharsetstr = "&amp;oe=$session_charset";
?>

<script type="text/javascript">
//<![CDATA[
var startlat = '<?php echo $startlat; ?>';
var startlong = '<?php echo $startlong; ?>';
var startzoom = parseInt(<?php echo $startzoom; ?>);
//var placelevel = <?php echo $placelevel; ?>;
var point = new GLatLng(startlat, startlong);
var TypeOfMap = <?php echo $map[type]; ?>;

var map = null;
var geocoder = null;
var maploaded = false;

function loadmap() {
	if(GBrowserIsCompatible()) {
		map = new GMap2(document.getElementById("map"));
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		map.addControl(new GScaleControl());
		map.setCenter(point, startzoom, TypeOfMap);
		map.addOverlay(new GMarker(point));
		geocoder = new GClientGeocoder();

		GEvent.addListener(map, "click", function(overlay, point){
			map.clearOverlays();
			if (point) {
				map.addOverlay(new GMarker(point));
				map.panTo(point);
			}
		});

		GEvent.addListener(map, 'click', function(overlay, point) {
			document.getElementById("latbox").value=point.lat();
		    document.getElementById("lonbox").value=point.lng();
			document.getElementById("zoombox").value=map.getZoom();
		});

		GEvent.addListener(map, 'zoomend', getNewZoomLevel);

		maploaded = true;
	}
}

function keyHandlerEnter(field,e) {
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if(keycode == 13) {
	    	showAddress(document.form1.address.value);
    		return false;
	}
	else
		return true;
}

var notfound="<?php echo $admtext[notfound] ?>";

function getNewZoomLevel() {
	document.getElementById("zoombox").value=map.getZoom();
}

function showAddress(address) {
	if (geocoder) {
		geocoder.getLatLng(
			address,
			function(point) {
				if (!point) {
					alert(address + notfound);
				} else {
					map.setCenter(point, 13);
					var marker = new GMarker(point);
					map.clearOverlays();
					map.addOverlay(marker);
					document.getElementById("latbox").value=point.lat();
					document.getElementById("lonbox").value=point.lng();
					//if(document.getElementById("placebox"))
						//document.getElementById("placebox").value=address;
				}
			}
		);
	}
}

function divbox(box_id) {
	new Effect.toggle(box_id,'appear',{duration:.3,afterFinish:function(){if(!maploaded) loadmap();}});
	return false;
}
//]]>
</script>
