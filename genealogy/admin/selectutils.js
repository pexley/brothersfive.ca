function AddtoDisplay(source, dest) {
	if( source.options[source.selectedIndex].selected ) {
		if(navigator.appName == "Netscape") {
			dest.options[dest.options.length] = new Option(source.options[source.selectedIndex].text,source.options[source.selectedIndex].value,false,false)
		}
		else if( navigator.appName == "Microsoft Internet Explorer") {
			var newElem = document.createElement("OPTION");
			newElem.text = source.options[source.selectedIndex].text;
			newElem.value = source.options[source.selectedIndex].value;
			dest.options.add(newElem);
		}
	}
}

function RemovefromDisplay(fieldlist) {
	if( fieldlist.options[fieldlist.selectedIndex].selected ) {
		if(navigator.appName == "Netscape") {
			fieldlist.options[fieldlist.selectedIndex] = null;
		}
		else if( navigator.appName == "Microsoft Internet Explorer") {
			fieldlist.options.remove(fieldlist.selectedIndex);
		}
	}
}

function Move(fieldlist, dir) {
	var tempval = fieldlist.options[fieldlist.selectedIndex].value;
	var temptxt = fieldlist.options[fieldlist.selectedIndex].text;

	if(dir) {
		fieldlist.options[fieldlist.selectedIndex].value = fieldlist.options[fieldlist.selectedIndex - 1].value;
		fieldlist.options[fieldlist.selectedIndex - 1].value = tempval;
		fieldlist.options[fieldlist.selectedIndex].text = fieldlist.options[fieldlist.selectedIndex - 1].text;
		fieldlist.options[fieldlist.selectedIndex - 1].text = temptxt;
		fieldlist.selectedIndex--;
	}
	else {
		fieldlist.options[fieldlist.selectedIndex].value = fieldlist.options[fieldlist.selectedIndex + 1].value;
		fieldlist.options[fieldlist.selectedIndex + 1].value = tempval;
		fieldlist.options[fieldlist.selectedIndex].text = fieldlist.options[fieldlist.selectedIndex + 1].text;
		fieldlist.options[fieldlist.selectedIndex + 1].text = temptxt;
		fieldlist.selectedIndex++;
	}
}

function TrimString(sInString) {
  sInString = sInString.replace( /^\s+/g, "" );// strip leading
  return sInString.replace( /\s+$/g, "" );// strip trailing
}

function getTree() {
	if(document.form1.tree1) {
		if( document.form1.tree1.options.length )
			return document.form1.tree1.options[document.form1.tree1.selectedIndex].value;
		else {
			alert(selecttree);
			return false;
		}
	}
	else
		return document.form1.tree.value;
}

function generateID(type,dest) {
	var tree = getTree();
	if(tree !== false) {
		var params = $H({type:type,tree:tree}).toQueryString();
		new Ajax.Request('generateID.php',{parameters:params,onSuccess:function(req){dest.value = req.responseText;}});
	}
}

function checkID(checkID,type,dest) {
	var tree = getTree();
	if(tree !== false) {
		var params = $H({checkID:checkID,type:type,tree:tree}).toQueryString();
		new Ajax.Request('checkID.php',{parameters:params,onSuccess:function(req){$(dest).innerHTML = req.responseText;}});
	}
}

function insertCell(row,index,classname,content) {
	var cell = row.insertCell(index);
	cell.className = classname;
	cell.innerHTML = content ? content : content + '&nbsp;';
	return cell;
}

function getActionButtons(vars,type,notesflag,citesflag) {
	var celltext = "";
	var dims = "width=\"20\" height=\"20\" class=\"smallicon\"";
	var onstr = type == "Citation" ? "_on" : "";

	if(vars.allow_edit)
		celltext += "<a href=\"#\" onclick=\"return edit"+type+"('"+vars.id+"');\"><img src=\"tng_edit.gif\" title=\""+editmsg+"\" alt=\""+editmsg+"\" "+dims+"></a>";
	if(vars.allow_delete)
		celltext += "<a href=\"#\" onclick=\"return delete"+type+"('"+vars.id+"','"+vars.persfamID+"','"+vars.tree+"','"+vars.eventID+"');\"><img src=\"tng_delete.gif\" title=\""+delmsg+"\" alt=\""+delmsg+"\" "+dims+"></a>";
	if(vars.allow_cite)
		celltext += "<a href=\"#\" onclick=\"return showCitationsInside('"+vars.id+"','');\"><img src=\"tng_cite"+onstr+".gif\" title=\""+citemsg+"\" alt=\""+citemsg+"\" "+dims+" id=\"citesicon"+vars.id+"\" ></a>";
	if(notesflag)
		celltext += "<a href=\"#\" onclick=\"return showNotes('"+vars.id+"');\"><img src=\"tng_note.gif\" title=\""+notemsg+"\" alt=\""+notemsg+"\" "+dims+" id=\"notesicon"+vars.id+"\" ></a>";
	if(citesflag)
		celltext += "<a href=\"#\" onclick=\"return showCitations('"+vars.id+"');\"><img src=\"tng_cite.gif\" title=\""+citemsg+"\" alt=\""+citemsg+"\" "+dims+" id=\"citesicon"+vars.id+"\" ></a>";

	return celltext;
}

function addEvent(form) {
	if( form.eventtypeID.selectedIndex == 0 )
		alert(entereventtype);
	else if( form.eventdate.value.length == 0 && form.eventplace.value.length == 0 && form.info.value.length == 0 )
		alert(entereventinfo);
	else {
		var params = Form.serialize(form);
		new Ajax.Request('addevent.php',{
			parameters:params,
			onSuccess:function(req){
				var vars = eval('('+req.responseText+')');

				var eventtbl = $('custeventstbl');
				var newtr = eventtbl.insertRow(eventtbl.rows.length);
				newtr.id = "row_"+vars.id;
				insertCell(newtr,0,"lightback",getActionButtons(vars,'Event',allow_notes,allow_cites));
				insertCell(newtr,1,"lightback",vars.display);
				insertCell(newtr,2,"lightback",vars.eventdate);
				insertCell(newtr,3,"lightback",vars.eventplace);
				insertCell(newtr,4,"lightback",vars.info);

				eventtbl.style.display = '';
				tnglitbox.remove();
			}
		});
	}
	return false;
}

function updateEvent(form) {
	if( form.eventdate.value.length == 0 && form.eventplace.value.length == 0 && form.info.value.length == 0 )
		alert(entereventinfo);
	else {
		var eventID = form.eventID.value;
		var params = Form.serialize(form);
		new Ajax.Request('updateevent.php',{
			parameters:params,
			onSuccess:function(req){
				var vars = eval('('+req.responseText+')');
				var tds = $$('tr#row_'+eventID+' td');
				tds[1].innerHTML = vars.display;
				tds[2].innerHTML = vars.eventdate;
				tds[3].innerHTML = vars.eventplace;
				tds[4].innerHTML = vars.info;
				tnglitbox.remove();
				tds.each(function(item){new Effect.Highlight(item,{duration:2.0});})
			}
		});
	}
	return false;
}

function editEvent(eventID) {
	tnglitbox = new LITBox('editevent.php?eventID=' + eventID,{width:540,height:400});
	return false;
}

function newEvent(prefix,persfamID,tree) {
	tnglitbox = new LITBox('newevent.php?prefix='+prefix+'&persfamID='+persfamID+'&tree='+tree,{width:540,height:400});
	return false;
}

function deleteEvent(eventID) {
	if(confirm(confdeleteevent)) {
		var tds = $$('tr#row_'+eventID+' td');
		tds.each(function(item){
			new Effect.Highlight(item,{startcolor:'#ff9999'});
		})
		var params = $H({eventID:eventID}).toQueryString();
		new Ajax.Request('deleteevent.php',{parameters:params,onSuccess:function(req){new Effect.Fade('row_'+eventID,{duration:.2})}});
	}
	return false;
}

function showNotes( eventID ) {
	tnglitbox = new LITBox('notes.php?eventID=' + eventID + '&persfamID=' + persfamID + '&tree=' + tree,{width:600,height:450});
	return false;
}

function showCitations( eventID, newpersfamID ) {
	var useID = newpersfamID ? newpersfamID : persfamID;
	tnglitbox = new LITBox('citations.php?eventID=' + eventID + '&persfamID=' + useID + '&tree=' + tree,{width:600,height:450});
	return false;
}

function showMore( eventID ) {
	tnglitbox = new LITBox('editmore.php?eventID=' + eventID + '&persfamID=' + persfamID + '&tree=' + tree,{width:600,height:480});
	return false;
}

function showAssociations() {
	tnglitbox = new LITBox('associations.php?personID=' + persfamID + '&tree=' + tree,{width:600,height:200});
	return false;
}

function gotoSection(start,end) {
	new Effect.toggle(start,'appear',{duration:.2,afterFinish:function(){new Effect.toggle(end,'appear',{duration:.2});}});
}

function addNote(form) {
	if( form.note.value.length == 0 )
		alert(enternote);
	else {
		var params = Form.serialize(form);
		new Ajax.Request('addnote.php',{
			parameters:params,
			onSuccess:function(req){
				var vars = eval('('+req.responseText+')');
				vars.allow_cite = 1;

				var notestbl = $('notestbl');
				var newtr = notestbl.insertRow(notestbl.rows.length);
				newtr.id = "row_"+vars.id;
				insertCell(newtr,0,"lightback",getActionButtons(vars,'Note'));
				insertCell(newtr,1,"lightback",vars.display)

				notestbl.style.display = '';
				gotoSection('addnote','notelist');
				$('notesicon'+form.eventID.value).src = 'tng_note_on.gif';
			}
		});
	}
	return false;
}

function editNote(noteID) {
	var params = $H({noteID:noteID}).toQueryString();
	new Ajax.Request('editnote.php',{parameters:params,
		onSuccess:function(req){
			$('editnote').innerHTML = req.responseText;
			gotoSection('notelist','editnote');
		}
	});
	return false;
}

function updateNote(form) {
	if( form.note.value.length == 0 )
		alert(enternote);
	else {
		var noteID = form.ID.value;
		var params = Form.serialize(form);
		new Ajax.Request('updatenote.php',{
			parameters:params,
			onSuccess:function(req){
				var vars = eval('('+req.responseText+')');
				var tds = $$('tr#row_'+noteID+' td');
				tds[1].innerHTML = vars.display;
				gotoSection('editnote','notelist');
				tds.each(function(item){new Effect.Highlight(item,{duration:2.5});})
			}
		});
	}
	return false;
}

function deleteNote(noteID,personID,tree,eventID) {
	if(confirm(confdeletenote)) {
		var tds = $$('tr#row_'+noteID+' td');
		tds.each(function(item){
			new Effect.Highlight(item,{startcolor:'#ff9999'});
		})
		var params = $H({noteID:noteID,personID:personID,tree:tree,eventID:eventID}).toQueryString();
		new Ajax.Request('deletenote.php',{parameters:params,
			onSuccess:function(req){
				new Effect.Fade('row_'+noteID,{duration:.2});
				if(req.responseText == '0')
					$('notesicon'+eventID).src = 'tng_note.gif';
			}
		});
	}
	return false;
}

var subpage = false;
function showCitationsInside(eventID, noteID) {
	subpage = true;
	var xnote = noteID != "" ? noteID : "";
	var params = $H({eventID:eventID,persfamID:persfamID,noteID:xnote,tree:tree}).toQueryString();
	new Ajax.Request('citations.php',{parameters:params,
		onSuccess:function(req){
			$('citationslist').innerHTML = req.responseText;
			gotoSection('notelist','citationslist');
		}
	});
	return false;
}

function addCitation(form) {
	if( form.sourceID.selectedIndex == 0 )
		alert(selectsource);
	else {
		var params = Form.serialize(form);
		new Ajax.Request('addcitation.php',{
			parameters:params,
			onSuccess:function(req){
				var vars = eval('('+req.responseText+')');

				var citationstbl = $('citationstbl');
				var newtr = citationstbl.insertRow(citationstbl.rows.length);
				newtr.id = "row_"+vars.id;
				insertCell(newtr,0,"lightback",getActionButtons(vars,'Citation'));
				insertCell(newtr,1,"lightback",vars.display)

				citationstbl.style.display = '';
				gotoSection('addcitation','citations');
				var iconid = form.eventID.value == 'SLGC' ? form.persfamID.value : '';
				$('citesicon'+form.eventID.value + iconid).src = 'tng_cite_on.gif';
			}
		});
	}
	return false;
}

function editCitation(citationID) {
	var params = $H({citationID:citationID}).toQueryString();
	new Ajax.Request('editcitation.php',{parameters:params,
		onSuccess:function(req){
			$('editcitation').innerHTML = req.responseText;
			gotoSection('citations','editcitation');
		}
	});
	return false;
}

function updateCitation(form) {
	var citationID = form.citationID.value;
	var params = Form.serialize(form);
	new Ajax.Request('updatecitation.php',{
		parameters:params,
		onSuccess:function(req){
			var vars = eval('('+req.responseText+')');
			var tds = $$('tr#row_'+citationID+' td');
			tds[1].innerHTML = vars.display;
			gotoSection('editcitation','citations');
			tds.each(function(item){new Effect.Highlight(item,{duration:2.5});})
		}
	});
	return false;
}

function deleteCitation(citationID,personID,tree,eventID) {
	if(confirm(confdeletecite)) {
		var tds = $$('tr#row_'+citationID+' td');
		tds.each(function(item){new Effect.Highlight(item,{startcolor:'#ff9999'});})
		var params = $H({citationID:citationID,personID:personID,tree:tree,eventID:eventID}).toQueryString();
		new Ajax.Request('deletecitation.php',{parameters:params,
			onSuccess:function(req){
				new Effect.Fade('row_'+citationID,{duration:.2});
				if(req.responseText == '0')
					$('citesicon'+eventID).src = 'tng_cite.gif';
			}
		});
	}
	return false;
}

function addAssociation(form) {
	if( form.passocID.value == "" )
		alert(enterpassoc);
	else if(form.relationship.value == "")
		alert(enterrela);
	else {
		var params = Form.serialize(form);
		new Ajax.Request('addassoc.php',{
			parameters:params,
			onSuccess:function(req){
				var vars = eval('('+req.responseText+')');

				var associationstbl = $('associationstbl');
				var newtr = associationstbl.insertRow(associationstbl.rows.length);
				newtr.id = "row_"+vars.id;
				insertCell(newtr,0,"lightback",getActionButtons(vars,'Association'));
				insertCell(newtr,1,"lightback",vars.display)

				associationstbl.style.display = '';
				gotoSection('addassociation','associations');
				$('associcon').src = 'tng_assoc_on.gif';
			}
		});
	}
	return false;
}

function editAssociation(assocID) {
	var params = $H({assocID:assocID}).toQueryString();
	new Ajax.Request('editassoc.php',{parameters:params,
		onSuccess:function(req){
			$('editassociation').innerHTML = req.responseText;
			gotoSection('associations','editassociation');
		}
	});
	return false;
}

function updateAssociation(form) {
	var assocID = form.assocID.value;
	var params = Form.serialize(form);
	new Ajax.Request('updateassoc.php',{
		parameters:params,
		onSuccess:function(req){
			var vars = eval('('+req.responseText+')');
			var tds = $$('tr#row_'+assocID+' td');
			tds[1].innerHTML = vars.display;
			gotoSection('editassociation','associations');
			tds.each(function(item){new Effect.Highlight(item,{duration:2.5});})
		}
	});
	return false;
}

function deleteAssociation(assocID,personID,tree) {
	if(confirm(confdeleteassoc)) {
		var tds = $$('tr#row_'+assocID+' td');
		tds.each(function(item){new Effect.Highlight(item,{startcolor:'#ff9999'});})
		var params = $H({assocID:assocID,personID:personID,tree:tree}).toQueryString();
		new Ajax.Request('deleteassoc.php',{parameters:params,
			onSuccess:function(req){
				new Effect.Fade('row_'+assocID,{duration:.2});
				if(req.responseText == '0')
					$('associcon').src = 'tng_assoc.gif';
			}
		});
	}
	return false;
}

function updateMore(form) {
	var params = Form.serialize(form);
	new Ajax.Request('updatemore.php',{
		parameters:params,
		onSuccess:function(req){
			//if something saved, put an asterisk in the "More" button
			if(req.responseText == "1")
				$('moreicon'+form.eventtypeID.value).src = 'tng_more_on.gif';
			else
				$('moreicon'+form.eventtypeID.value).src = 'tng_more.gif';
			tnglitbox.remove();
		}
	});
	return false;
}

var branchtimer;
function showBranchEdit(branchdiv) {
	new Effect.toggle(branchdiv,'blind',{duration:.2});
	return false;
}

function updateBranchList(branchselect,branchdiv,branchlistdiv) {
	var branches = $(branchselect).options;
	var branchlist = "";
	var gotnone = false;
	for(var i=0;i<branches.length;i++) {
		if(branches[i].selected) {
			if(i==0) gotnone = true;
			if(branchlist) {
				if(i>0 && gotnone) {
					branchlist = "";
					branches[0].selected = false;
				}
				else
					branchlist += ", ";
			}
			branchlist += branches[i].text;
		}
	}
	$(branchlistdiv).innerHTML = branchlist;
	showBranchEdit(branchdiv);
}

function quitBranchEdit(branchdiv) {
	branchtimer = setTimeout("showBranchEdit('"+branchdiv+"')",3000);
}

function closeBranchEdit(branchselect,branchdiv,branchlistdiv) {
	branchtimer = setTimeout("updateBranchList('"+branchselect+"','"+branchdiv+"','"+branchlistdiv+"')",500);
}

var activebox;
var seclitbox;
function openFindPlaceForm(field) {
	activebox = field;
	var value = $(field).value;
	seclitbox = new LITBox('findplaceform.php?tree=' + tree + '&place=' + encodeURIComponent(value),{width:400,height:450});
	if(value)
		openFind(document.findform1,'findplace.php');
	else
		document.findform1.myplace.focus();
	return false;
}

function openFindPersonForm(field,nameplusid,type,newtree) {
	var value = null;
	if(newtree) tree = newtree;
	activebox = field;
	if(field && !nameplusid)
		value = $(field).value;
	var nameplus = nameplusid ? nameplusid : '';
	seclitbox = new LITBox('findpersonform.php?tree=' + tree + '&nameplusid=' + nameplusid + '&type='+type,{width:400,height:450});
	var startfield = $('findpersonID') ? 'findpersonID' : 'mylastname';
	$(startfield).focus();
	return false;
}

function returnValue(value) {
	$(activebox).value = value;
	seclitbox.remove();
	return false;
}

function returnName(id,value,type,nameplusid) {
	seclitbox.remove();
	if( type == "text" ) {
		$(activebox).value = id;
		if( nameplusid != "" ) {
			$(nameplusid).value = value;
			new Effect.Highlight(nameplusid,{duration:.4});
		}
	}
	else if( type == "map" ) {
		//use x1,y1,x2,y2,radius to construct shape and add to image map area (activebox?)
		var area;
		//if( $cms[support] )
			//$getperson_url = "$cms[url]=getperson&amp;";
		//else
			//$getperson_url = $cms[tngpath] . "getperson.php?";
		var getperson_url = 'getperson.php?';
		var maptree = document.form1.maptree.options[document.form1.maptree.selectedIndex].value;
		if( document.form1.shape[0].checked ) //circle
			area = '<area shape=\"circle\" coords=\"'+x1+','+y1+','+radius+'\" href=\"'+getperson_url+'personID=' + id + '&amp;tree='+maptree+'\" alt=\"' + value + '\" title=\"' + value + '\">\n';
		else
			area = '<area coords=\"'+x1+','+y1+','+x2+','+y2+'\" href=\"'+getperson_url+'personID=' + id + '&amp;tree='+maptree+'\" alt=\"' + value + '\" title=\"' + value + '\">\n';
		$(activebox).value += area;
	}
	else if( type == "select" ) {
		childcount += 1;
		var params = $H({personID:id,display:value,familyID:persfamID,tree:tree,order:childcount,action:'addchild'}).toQueryString();
		new Ajax.Request('updateorder.php',{
			parameters:params,
			onSuccess:function(req){
				$('childrenlist').innerHTML += req.responseText;
				new Effect.Appear('child_'+id,{duration:.4});
				$('childcount').innerHTML = childcount;
				Sortable.create('childrenlist',{tag:'div',onUpdate:updateChildrenOrder});
			}
		});
	}
	return false;
}
