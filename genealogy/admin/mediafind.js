function getPotentialLinks(linktype) {
	var searchstring = "";
	var form = document.find2;

	switch(linktype) {
		case "I":
			var lastname = form.mylastname.value;
			var firstname = form.myfirstname.value;
			searchstring = "&lastname=" + lastname + "&firstname=" + firstname;
			break;
		case "F":
			var husbname = form.myhusbname.value;
			var wifename = form.mywifename.value;
			searchstring = "&husbname=" + husbname + "&wifename=" + wifename;
			break;
		case "S":
			var title = form.mysourcetitle.value;
			searchstring = "&title=" + title;
			break;
		case "R":
			var title = form.myrepotitle.value;
			searchstring = "&title=" + title;
			break;
		case "L":
			var place = form.myplace.value;
			searchstring = "&place=" + place;
			break;
	}
	if(searchstring) {
		doSpinner('find');

		var typestr = type == "album" ? "albumID="+album : "mediaID="+media;
		var strParams = typestr + searchstring + "&tree=" + tree + "&linktype=" + linktype;
		new Ajax.Request('medialinksxml.php',{parameters:strParams,onSuccess:showPotentialLinks});
	}
	return false;
}

function showPotentialLinks(req) {
	var newrows = req.responseText;

	$('newlines').innerHTML = newrows;
	lastspinner.style.display = 'none';
}

function doSpinner(id) {
	lastspinner = $('spinner'+id);
	$('spinner'+id).style.display = 'inline';
}

function openMediaFind(form) {
	var linktype = form.linktype1.options[form.linktype1.selectedIndex].value;
	tree = form.tree1.options[form.tree1.selectedIndex].value;
	tnglitbox = new LITBox('findform.php?linktype='+linktype+'&tree='+tree,{width:645,height:540});
	return false;
}

function toggleEventLink(index) {
	var eventlink = document.find.eventlink1;
	var event = document.find.event1;
	var newlink = document.find.newlink1;

	//blank out & deselect Event box
	if(event) {
		event.selectedIndex = 0;
		event.options.length = 0;
	}
	//blank out ID box
	if(index >= 0)
		newlink.value = "";

	//hide/reveal checkbox
	if( index > 3 )
		eventlink.style.display = 'none';
	else if( index >= 0 )
		eventlink.style.display = '';

	//hide event row and uncheck box
	if(!findform) findform = "form1";
	if(event) {
		toggleEventRow(0);
		var check = document.find.eventlink1;
		check.checked = false;
	}
}

function toggleEventRow(check,entrynum) {
	var eventrow = $('eventrow1');
	if( check ) {
		var entity = document.find.newlink1;
		if( !entity.value ) return false;
		eventrow.style.display = '';
		var tree = document.find.tree1;
		var linktype = document.find.linktype1;
		fetchData(linktype.options[linktype.selectedIndex].value,entity.value,tree.options[tree.selectedIndex].value,entrynum);
	}
	else
		eventrow.style.display = 'none';
	return true;
}

function fetchData(linktype,persfamID,tree,count) {
	var strParams = "persfamID=" + persfamID + "&tree=" + tree + "&linktype=" + linktype + "&count=" + count;
 	var loader1 = new net.ContentLoader('mediaeventxml.php',fillList,null,"POST",strParams);
}

function createOption(olist,ovalue,otext) {
	if(navigator.appName == "Netscape") {
		olist.options[olist.options.length] = new Option(otext,ovalue,false,false)
	}
	else if( navigator.appName == "Microsoft Internet Explorer") {
		var newElem = document.createElement("OPTION");
		newElem.text = otext;
		newElem.value = ovalue;
		olist.options.add(newElem);
	}
}

function fillList() {
	var xmlDoc = this.req.responseXML.documentElement;
	var xCount = xmlDoc.getElementsByTagName('targetlist');
	var countnode = getTextNodes(xCount[0]);
	var count = countnode['target'].firstChild.nodeValue;

	var xEvent = xmlDoc.getElementsByTagName('event');
	var evnodes, eventID, displayval, info, displaystr, dest;

	//know which list to fill! (dest)
	dest = document.find.event1;

	//blank out list
	dest.options.length = 0;
	createOption(dest,'','');

	for(i=0; i < xEvent.length; i++) {
		evnodes = getTextNodes(xEvent[i]);
		eventID = evnodes['eventID'].firstChild.nodeValue;
		displayval = evnodes['display'].firstChild.nodeValue;
		info = evnodes['info'].firstChild.nodeValue;
		if( info != "-1" )
			displaystr = displayval + ": " + info;
		else
			displaystr = displayval;

		//fill list
		createOption(dest,eventID,displaystr);
	}
}

function getTextNodes(node) {
	var textNodes = new Array();

	for(var i = 0; i < node.childNodes.length; i++ ) {
		if( node.childNodes[i].nodeType == "1" ) {
			textNodes[node.childNodes[i].nodeName] = node.childNodes[i];
		}
	}
	return textNodes;
}

function selectEntity(field,entity) {
	field.value = entity;
	field.focus();
	tnglitbox.remove();
	//document.find.submit();
}

function deleteMedia2EntityLink(linkID) {
	if(confirm(confdellink)) {
		var tds = $$('tr#alink_'+linkID+' td');
		tds.each(function(item){
			new Effect.Highlight(item,{startcolor:'#ff9999',duration:2.0});
		})
		var params = $H({linkID:linkID,type:type,action:'dellink'}).toQueryString();
		new Ajax.Request('updateorder.php',{
			parameters:params,
			onSuccess:function(req){
				var pairs = req.responseText.split('&');
				var link = parseInt(pairs[0]);
				var entityID = pairs[1];
				new Effect.Fade('alink_'+link,{duration:.4});
				if($('linked_'+entityID)) {
					$('linked_'+entityID).style.display = 'none';
					new Effect.Appear('link_'+entityID,{duration:.4});
				}
				linkcount = linkcount - 1;
				$('linkcount').innerHTML = linkcount;
			}
		});
	}
	return false;
}

function editMedia2EntityLink(linkID) {
	tnglitbox = new LITBox('editmedialink.php?linkID='+linkID,{width:500,height:380});
	return false;
}

function updateMedia2EntityLink(form) {
	var params = Form.serialize(form) + "&action=updatelink";
	new Ajax.Request('updateorder.php',{
		parameters:params,
		onSuccess:function(req){
			var thisform = document.editlinkform;
			var eventID = form.eventID;
			var medialinkID = form.medialinkID.value;
			$('event_'+medialinkID).innerHTML = (eventID.selectedIndex ? eventID.options[eventID.selectedIndex].text : '&nbsp;');
			$('alt_'+medialinkID).innerHTML = (form.altdescription.value || form.altnotes.value) ? yesmsg : '&nbsp;';
			$('def_'+medialinkID).innerHTML = form.defphoto.checked ? yesmsg : '&nbsp;';
			tnglitbox.remove();
			new Effect.Highlight('event_'+medialinkID,{duration:1.4});
			new Effect.Highlight('alt_'+medialinkID,{duration:1.4});
			new Effect.Highlight('def_'+medialinkID,{duration:1.4});
		}
	});
	return false;
}

function addMedia2EntityLink(form, newEntityID, num) {
	if(newEntityID) {
		var entityID = newEntityID;
		//form.newlink1.value = decodeURIComponent(entityID).replace(/\+/g,' ');
	}
	else
		var entityID = form.newlink1.value;
	if(!entityID)
		alert(linkmsg);
	else {
		var tree = form.tree1.options[form.tree1.selectedIndex].value;
		var linktype = form.linktype1.options[form.linktype1.selectedIndex].value;
		var params = $H({tree:tree,linktype:linktype,entityID:entityID,type:type,action:'addlink'}).toQueryString();
		params += type == "album" ? "&albumID="+album : "&mediaID="+media;
		new Ajax.Request('updateorder.php',{
			parameters:params,
			onSuccess:function(req){
				if(req.responseText == "1") {
					$('alink_error').innerHTML = duplinkmsg;
					new Effect.Appear('alink_error');
				}
				else if(req.responseText == "2") {
					$('alink_error').innerHTML = invlinkmsg;
					new Effect.Appear('alink_error');
				}
				else {
					$('alink_error').innerHTML = '';
					new Effect.Fade('alink_error');
			
					var vars = req.responseText.split('|');
					var linkID = parseInt(vars[0]);
					var name = decodeURIComponent(vars[1]);
			
					var linkID = parseInt(req.responseText);
					var newrow;
					if(linktype == "L") entityID = "";
					//var entityID = linktype != "L" ? form.newlink1.value : "";
					var displayID = entityID ? ' (' + entityID + ')' : "";
					var dims = "width=\"20\" height=\"20\" class=\"smallicon\"";
					var treename = form.tree1.options[form.tree1.selectedIndex].text;
					var linktext = form.linktype1.options[form.linktype1.selectedIndex].text;
			
					linkcount = linkcount + 1;
					$('linkcount').innerHTML = linkcount;

					var linktable = $('linktable');
					var newtr = linktable.insertRow(linktable.rows.length);
					newtr.id = 'alink_' + linkID;
					newtr.setAttribute('style','display:none');

					var actionbuttons = '<a href="#" title="' + remove_text + '" onclick="return deleteMedia2EntityLink(' + linkID + ');"><img src="tng_delete.gif" alt="' + remove_text + '" ' + dims + ' class="smallicon"/></a>';
					if(type == "media")
						actionbuttons = '<a href="#" title="' + edit_text + '" onclick="return editMedia2EntityLink(' + linkID + ');"><img src="tng_edit.gif" alt="' + edit_text + '" ' + dims + ' class="smallicon"/></a>'+actionbuttons;
					var td0 = insertCell(newtr,0,"lightback normal",actionbuttons);
					td0.setAttribute('align','center');
					insertCell(newtr,1,"lightback normal",linktext);
					insertCell(newtr,2,"lightback normal",name + displayID);
					insertCell(newtr,3,"lightback normal",treename + '&nbsp;');

					if(type == "media") {
						var td4 = insertCell(newtr,4,"lightback normal",'&nbsp;')
						td4.id = 'event_'+linkID;
						var td5 = insertCell(newtr,5,"lightback normal",'&nbsp;')
						td5.id = 'alt_'+linkID;
						var td6 = insertCell(newtr,6,"lightback normal",'&nbsp;')
						td6.id = 'def_'+linkID;
					}

					new Effect.Appear('alink_'+linkID,{duration:.4,
						afterFinish:function(){
							$$('tr#alink_'+linkID+' td').each(function(item){
								new Effect.Highlight(item,{duration:1.2});
							});
						}
					});

					//strip slashes and apostrophes
					if(linktype == "L") entityID = num;
					if($('link_'+entityID)) {
						$('link_'+entityID).style.display = 'none';
						new Effect.Appear('linked_'+entityID,{duration:.4});
					}
					$('nolinks').style.display='none';
				}
			}
		});
	}
	return false;
}

function newlinkEnter(form,field,e) {
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if(keycode == 13)
	    	return addMedia2EntityLink(form);
	else
		return true;
}