// form startup
function startMediaSort() {
	Sortable.create('orderdivs',{tag:'div',onUpdate:updateMediaOrder});
}

function startListening() {
	crossPlatAddListener($('mylastname'), "keydown", keyHandlerPerson);
	crossPlatAddListener($('myfirstname'), "keydown", keyHandlerPerson);
	crossPlatAddListener($('myhusbname'), "keydown", keyHandlerFamily);
	crossPlatAddListener($('mywifename'), "keydown", keyHandlerFamily);
	crossPlatAddListener($('mysourcetitle'), "keydown", keyHandlerSource);
	crossPlatAddListener($('myrepotitle'), "keydown", keyHandlerRepo);
	crossPlatAddListener($('myplace'), "keydown", keyHandlerPlace);
}

function updateMediaOrder(id) {
	var links = Sortable.sequence(id);
	var linklist = new Array();

	for(var i=0; i<links.length; i++) {
		linklist[i] = links[i];
	}

	var params = $H({sequence:linklist.join(','),album:album,action:'order'}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params});
}

function removeFromSort(type,link) {
	var params = $H({type:type,link:link,action:'remsort'}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params,onSuccess:finishRemoveFromSort});
	return false;
}

function finishRemoveFromSort(req) {
	item = parseInt(req.responseText);
	new Effect.Fade('orderdivs_' + item,{duration:.4,afterFinish:function(){Element.remove('orderdivs_' + item);}});
}

function openFind(linktype) {
	var linktypes = new Array('I','F','S','R','L');

	linktypes.each(
		function(thistype) {
			if(thistype != linktype && $('findform'+thistype).style.display != 'none')
				$('findform'+thistype).style.display = 'none';
		}
	);
	if($('findform'+linktype).style.display == 'none')
		new Effect.Appear('findform'+linktype,{duration:.4});
}

function switchLinktypes(select) {
	if(findopen) {
		openFind(select.options[select.selectedIndex].value);
		$('newlines').innerHTML=resheremsg;
		Form.getElements('find2').each(function(formEl) {if(formEl.type == "text") formEl.value = "";});
	}
}

function resetFindFields(section,fields) {
	$('newlines').innerHTML='';
	var field;
	for(var i=0; i<fields.length; i++) {
		field = eval("document.find2."+fields[i]);
		field.value = '';
	}
	new Effect.Fade(section,{duration:.2});
}
