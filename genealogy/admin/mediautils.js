var gsControlName = "";
function FilePicker( sControl, collection ) {
   gsControlName = sControl;

   var origsearch = document.getElementById(sControl + "_org");
   var lastsearch = document.getElementById(sControl + "_last");
   var searchstring = document.getElementById(sControl);
   var sendstring = searchstring.value;

   if( searchstring.value ) {
   	if( searchstring.value == origsearch.value || searchstring.value == lastsearch.value ) {
		sendstring = "";
		lastsearch.value = "";
	}
	else
		lastsearch.value = searchstring.value;
   }
	tnglitbox = new LITBox("filepicker.php?path=" + collection + "&searchstring=" + sendstring,{width:550,height:600});
}

function ReturnFile(sFileName) {
	var dest = eval("document.form1." + gsControlName);
	dest.value = sFileName;
	tnglitbox.remove();
}

function moreFilepicker(args) {
	new Ajax.Request('filepicker.php',{parameters:args,
		onSuccess:function(req) {
			tnglitbox.d4.innerHTML = req.responseText;
		}
	});
	return false;
}

function ShowFile(sFileName) {
   window.open(escape(sFileName), "File", "width=400,height=250,status=no,resizable=yes,scrollbars=yes");
}

function findItem(linknum,formname) {
	if(!formname) formname = "form1";
	var linktree = eval("document." + formname + ".tree" + linknum);
	var linktype = eval("document." + formname + ".linktype" + linknum);

	var value = linktype.options[linktype.selectedIndex].value;
	var newpage;

	switch(value) {
		case "I":
			newpage = "findpersonform.php";
			break;
		case "F":
			newpage = "findfamilyform.php";
			break;
		case "S":
			newpage = "findsourceform.php";
			break;
		case "R":
			newpage = "findrepoform.php";
			break;
		case "L":
			newpage = "findplaceform.php";
			break;
	}
	var tree=getTree(linktree); window.open(newpage + '?field=newlink' + linknum + '&tree=' + tree + '&formname=' + formname,'mediafind','width=300,height=400,status=no,resizable=no,scrollbars=yes');
}

function populatePath(source, dest) {
	var lastslash, temp;

	dest.value = "";
	temp = source.value.replace(/\\/g,"/");
	lastslash = temp.lastIndexOf("/") + 1;
	if( lastslash > 0)
		dest.value = source.value.slice(lastslash);
        else
                dest.value = source.value;

	//var imgmap = document.getElementById("imgmaprow");
	var lastperiod = source.value.lastIndexOf(".") + 1
	var ext = source.value.slice(lastperiod);
	ext = ext.toUpperCase();
	if( ext == "JPG" || ext == "GIF" || ext == "PNG" || ext == "JPEG" || ext == "GIFF" ) {
		//imgmap.style.display='';
		document.form1.thumbcreate[1].style.visibility = 'visible';
	}
	else {
		imgmap.style.display='none';
		document.form1.thumbcreate[0].checked = 'true';
		document.form1.thumbcreate[1].style.visibility = 'hidden';
		document.form1.newthumb.style.visibility='visible';
		document.form1.thumbselect.style.visibility='visible';
	}
}

function prepopulateThumb() {
	var path = document.form1.path;
	var lastslash = path.value.lastIndexOf("/") + 1;
	var lastperiod = path.value.lastIndexOf(".");
	var thumbpath = document.form1.thumbpath;

	thumbpath.value = "";
	if( lastslash )
		thumbpath.value = path.value.slice(0, lastslash);
	thumbpath.value = thumbpath.value + thumbprefix;
	if( lastperiod >= 0 )
		thumbpath.value = thumbpath.value + path.value.slice(lastslash,lastperiod) + thumbsuffix + path.value.slice(lastperiod);
	else
		thumbpath.value = thumbpath.value + path.value.slice(lastslash) + thumbsuffix;
}

function switchOnType(mtypeIndex) {
	var mediatypeID = like[mtypeIndex];
	if( mediatypeID == "photos" ) {
	}
	else {
	}
	if( mediatypeID == "histories" ) {
		new Effect.Appear('bodytextrow',{duration:.2});
		new Effect.Appear('usenlrow',{duration:.2});
	}
	else {
		new Effect.Fade('bodytextrow',{duration:.2});
		new Effect.Fade('usenlrow',{duration:.2});

	}
	if( mediatypeID == "headstones" ) {
		new Effect.Appear('maprow',{duration:.2});
		new Effect.Appear('linktocemrow',{duration:.2});
		new Effect.Appear('cemrow',{duration:.2});
		new Effect.Appear('hsplotrow',{duration:.2});
		new Effect.Appear('hsstatrow',{duration:.2});
	}
	else {
		new Effect.Fade('maprow',{duration:.2});
		new Effect.Fade('linktocemrow',{duration:.2});
		new Effect.Fade('cemrow',{duration:.2});
		new Effect.Fade('hsplotrow',{duration:.2});
		new Effect.Fade('hsstatrow',{duration:.2});
	}
	if( mediatypeID == "documents" ) {
	}
	else {
	}
	if( mediatypeID == "recordings" ) {
	}
	else {
	}
	if( mediatypeID == "videos" ) {
		new Effect.Appear('vidrow1',{duration:.2});
		new Effect.Appear('vidrow2',{duration:.2});
	}
	else {
		new Effect.Fade('vidrow1',{duration:.2});
		new Effect.Fade('vidrow2',{duration:.2});
	}
	if(mtypeIndex && stmediatypes.indexOf(mtypeIndex) == -1) {
		if(allow_edit) $('editmediatype').style.display = '';
		if(allow_delete) $('delmediatype').style.display = '';
	}
	else {
		$('editmediatype').style.display = 'none';
		$('delmediatype').style.display = 'none';
	}
}

function toggleMediaURL() {
	var abspath = document.getElementById("abspathrow");
	var path = document.getElementById("pathrow");
	var img = document.getElementById("imgrow");
	var imgmap = document.getElementById("imgmaprow");

	if(document.form1.abspath.checked) {
		abspath.style.display = '';
		path.style.display = 'none';
		img.style.display = 'none';
		if(imgmap) imgmap.style.display='none';
		if(document.form1.thumbcreate) {
			document.form1.thumbcreate[0].checked = 'true';
			document.form1.thumbcreate[1].style.visibility = 'hidden';
		}
		document.form1.newthumb.style.visibility='visible';
		document.form1.thumbselect.style.visibility='visible';
	}
	else {
		abspath.style.display = 'none';
		path.style.display = '';
		img.style.display = '';
		if(imgmap) imgmap.style.display='';
		if(document.form1.thumbcreate)
			document.form1.thumbcreate[1].style.visibility = 'visible';
	}
}

var firstclick = true;
var x1, y1, x2, y2, radius;
var Coordinate_X_InImage;
var Coordinate_Y_InImage;
Coordinate_X_InImage = Coordinate_Y_InImage = 0;

function imageClick(photoID) {
	var shapeobj = document.form1.shape;
    var tree = document.form1.maptree.options[document.form1.maptree.selectedIndex].value;
	var shape;

	//GetCoordinatesInImage();

	if( shapeobj[0].checked )
		shape = shapeobj[0].value;
	else
		shape = shapeobj[1].value;

    if( firstclick ) {
		x1 = Coordinate_X_InImage;
	    y1 = Coordinate_Y_InImage;
		firstclick = false;
	}
	else {
		if( shape == "circle" ) {
			x2 = "";
			y2 = "";
		    radius = Math.ceil(Math.sqrt( Math.pow(Coordinate_X_InImage - x1, 2) + Math.pow(Coordinate_Y_InImage - y1, 2)));
		}
		else {
			x2 = Coordinate_X_InImage;
		    y2 = Coordinate_Y_InImage;
			radius = "";
		}
		activebox = 'imagemap';
		seclitbox = new LITBox('findpersonform.php?tree=' + tree + '&type=map',{width:400,height:450});
		firstclick = true;
    }
}

function init(){
	if(document.addEventListener) {
		$('pic').addEventListener("mousedown",GetCoordinatesInImage, false);
	}else if(window.event && document.getElementById) {
		$('pic').onmousedown = GetCoordinatesInImage;
	}
}

function GetCoordinatesInImage(evt){
	if(window.event && !window.opera && typeof event.offsetX == "number") {
		// IE 5+
		Coordinate_X_InImage = event.offsetX;
		Coordinate_Y_InImage = event.offsetY;
	} else if(document.addEventListener && evt && typeof evt.pageX == "number"){
		// Mozilla-based browsers
		var Element = evt.target;
		var CalculatedTotalOffsetLeft, CalculatedTotalOffsetTop;
		CalculatedTotalOffsetLeft = CalculatedTotalOffsetTop = 0;
		while (Element.offsetParent) {
			CalculatedTotalOffsetLeft += Element.offsetLeft ;
			CalculatedTotalOffsetTop += Element.offsetTop ;
			Element = Element.offsetParent ;
		}
		Coordinate_X_InImage = evt.pageX - CalculatedTotalOffsetLeft ;
		Coordinate_Y_InImage = evt.pageY - CalculatedTotalOffsetTop ;
	}
}

function getTree(treeobj) {
	if( treeobj.options.length )
		return treeobj.options[treeobj.selectedIndex].value;
	else {
		alert(selectmsg);
		return false;
	}
}

function generateThumbs(form) {
	$('thumbresults').innerHTML = "";
	$('thumbresults').style.display = 'none';
	var regenerate = form.regenerate.checked ? 1 : "";
	$('thumbspin').style.display = '';
	var params = $H({regenerate:regenerate}).toQueryString();
	new Ajax.Request('generatethumbs.php',{parameters:params,onSuccess:reportThumbs});
	return false;
}

function reportThumbs(req) {
	$('thumbresults').innerHTML = req.responseText;
	new Effect.Appear('thumbresults',{duration:.4});
	$('thumbspin').style.display = 'none';
}

function assignDefaults(form) {
	$('defresults').innerHTML = "";
	$('defresults').style.display = 'none';
	var overwrite = form.overwritedefs.checked ? 1 : "";
	var tree = form.tree.options[form.tree.selectedIndex].value;
	$('defspin').style.display = '';
	var params = $H({overwritedefs:overwrite,tree:tree}).toQueryString();
	new Ajax.Request('defphotos.php',{parameters:params,onSuccess:reportDefaults});
	return false;
}

function reportDefaults(req) {
	$('defresults').innerHTML = req.responseText;
	new Effect.Appear('defresults',{duration:.4});
	$('defspin').style.display = 'none';
}

function attemptDelete(entity, entityname) {
	if( entity.options[entity.selectedIndex].value.length == 0 ) {
		alert(nothingtodelete);
	}
	else if( confirm(confdeleteentity + entityname + '?' )) {
		var params = 'entity=' + entityname + '&delitem=' + encodeURIComponent(entity.options[entity.selectedIndex].value);
		new Ajax.Request('deleteentity.php',{
			parameters:params,
			onSuccess:function(req){
				RemovefromDisplay(entity);
				entity.selectedIndex = 0;
			}
		})
	} 
}

function addEntity(form) {
	if( form.newitem.value.length == 0 )
		alert(pleaseenter + ' ' + form.entity.value);
	else {
		var params = Form.serialize(form);
		new Ajax.Request('addentity.php',{parameters:params,
			onSuccess:function(req){
				$('entitymsg').innerHTML = req.responseText;
				var entity = form.entity.value == 'state' ? document.form1.state : document.form1.country;
				var i = entity.options.length;
				if(navigator.appName == "Netscape") {
					entity.options[i] = new Option(form.newitem.value,form.newitem.value,false,false)
				}
				else if( navigator.appName == "Microsoft Internet Explorer") {
					entity.add(document.createElement("OPTION"));
					entity.options[i].text=form.newitem.value;
					entity.options[i].value=form.newitem.value;
				}
				entity.selectedIndex = i;
				form.newitem.value = '';
			}
		});
	}
	return false;
}

function addCollection(form) {
	if(form.collid.value == "")
		alert(entercollid);
	else if(form.display.value == "")
		alert(entercolldisplay);
	else if(form.path.value == "")
		alert(entercollpath);
	else if(form.icon.value == "")
		alert(entercollicon);
	else {
		$('cerrormsg').style.display = 'none';
		var params = Form.serialize(form);
		new Ajax.Request('addcollection.php',{parameters:params,
			onSuccess:function(req){
				if(req.responseText != "0") {
					var field = document.form1.mediatypeID;
					var i = field.options.length;
					if(navigator.appName == "Netscape") {
						field.options[i] = new Option(form.display.value,req.responseText,false,false)
					}
					else if( navigator.appName == "Microsoft Internet Explorer") {
						field.add(document.createElement("OPTION"));
						field.options[i].text=form.display.value;
						field.options[i].value=req.responseText;
					}
					field.selectedIndex = i;
					if(allow_edit) $('editmediatype').style.display = '';
					if(allow_delete) $('delmediatype').style.display = '';
					if(!manage) {
						var likeidx = form.liketype.options[form.liketype.selectedIndex].value;
						like[form.collid.value] = likeidx;
						switchOnType(form.collid.value);
					}
					tnglitbox.remove();
				}
				else
					$('cerrormsg').style.display = '';
			}
		});
	}
	return false;
}

function editMediatype(field){
	var mediatypeID = field.options[field.selectedIndex].value;
	var fieldname = field.name;
	tnglitbox = new LITBox('editcollection.php?field='+fieldname+'&mediatypeID='+mediatypeID+'&selidx='+field.selectedIndex,{width:600,height:300});	
}

function updateCollection(form) {
	if(form.display.value == "")
		alert(entercolldisplay);
	else if(form.path.value == "")
		alert(entercollpath);
	else if(form.icon.value == "")
		alert(entercollicon);
	else {
		var params = Form.serialize(form);
		new Ajax.Request('updatecollection.php',{parameters:params,
			onSuccess:function(req){
				var field = eval('document.form1.'+form.field.value);
				field.options[form.selidx.value].text = form.display.value;
				tnglitbox.remove();
				if(!manage) {
					var likeidx = form.liketype.options[form.liketype.selectedIndex].value;
					like[form.collid.value] = likeidx;
					switchOnType(form.collid.value);
				}
			}
		});
	}
	return false;
}

function confirmDeleteMediatype(mediatypeID){
	if(confirm(confmtdelete)) {
		var params = "t=mediatype&id="+mediatypeID.options[mediatypeID.selectedIndex].value;
		new Ajax.Request('deleteajax.php',{parameters:params,
			onSuccess:function(req){
				if(navigator.appName == "Netscape")
					mediatypeID.options[mediatypeID.selectedIndex] = null;
				else if( navigator.appName == "Microsoft Internet Explorer")
					mediatypeID.options.remove(mediatypeID.selectedIndex);
				mediatypeID.selectedIndex = 0;
				toggleHeadstoneCriteria('');
			}
		});
	}
}