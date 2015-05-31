function deleteIt(type,id,tree) {
	var tds = $$('tr#row_'+id+' td');
	tds.each(function(item){
		new Effect.Highlight(item,{startcolor:'#ff9999',duration:2.0});
	})
	var params = $H({t:type,id:id,tree:tree}).toQueryString();
	new Ajax.Request('deleteajax.php',{parameters:params,onSuccess:finishDeleteIt});
	return false;
}

function finishDeleteIt(req) {
	var entity = req.responseText;
	
	if($('row_'+entity)) {
		new Effect.Fade('row_'+entity,{duration:.4});
		var allTotals = document.getElementsByClassName('restotal');
		for(var i=0; i<allTotals.length; i++) {
			$(allTotals[i]).innerHTML = parseInt($(allTotals[i]).innerHTML) - 1;
		}
		var allPageTotals = document.getElementsByClassName('pagetotal');
		for(var i=0; i<allPageTotals.length; i++) {
			$(allPageTotals[i]).innerHTML = parseInt($(allPageTotals[i]).innerHTML) - 1;
		}
	}	
}

function toggleSection(section,img,display) {
	if(display == 'on') {
		$(img).src = '../tng_collapse.gif';
		var doit = true;
		if(section == "modifyexisting") {
			var agent = navigator.userAgent.toLowerCase();
			if(agent.indexOf('safari')!=-1) doit = false;
		}
		if(doit)
			new Effect.Appear(section,{duration:.3});
		else
			$(section).style.display = '';
	}
	else if(display == 'off') {
		$(img).src = '../tng_expand.gif';
		new Effect.Fade(section,{duration:.3});
	}
	else {
		$(img).src= $(img).src.indexOf('collapse') > 0 ? '../tng_expand.gif' : '../tng_collapse.gif';
		var doit = true;
		if(section == "addmedia") {
			var agent = navigator.userAgent.toLowerCase();
			if(agent.indexOf('safari')!=-1 && agent.indexOf('version/3') == -1) doit = false;
		}
		if(doit)
			new Effect.toggle(section,'appear',{duration:.3});
		else
			$(section).style.display = $(section).style.display == 'none' ? '' : 'none';
	}
	return false;
}

function makeFolder(folder,name) {
	$('msg_'+folder).innerHTML = '<img src="../spinner.gif" width="16" height="16">';
	var params = $H({folder:name}).toQueryString();
	new Ajax.Request('makefolder.php',{parameters:params,
		onSuccess:function(req){
			$('msg_'+folder).innerHTML = req.responseText;
			new Effect.Highlight('msg_'+folder);
		}
	});

	return false;
}

function makeDefault(photo) {
	var params = $H({media:photo.value.substr(1),entity:entity,tree:tree,album:album,action:'setdef'}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params,onSuccess:finishDefault});
}

function finishDefault(req) {
	$('removedefault').style.display = '';
	if(req.responseText != "1") {
		$('thumbholder').innerHTML = req.responseText;
		new Effect.Appear('thumbholder',{duration:.4});
		$('removedefault').style.visibility = 'visible';
	}
}

function removeDefault() {
	$('removedefault').style.display = 'none';
	new Effect.Fade('thumbholder',{duration:.4,afterFinish:function(){$('thumbholder').innerHTML='';}});
	for (var i=0; i<document.form1.rthumbs.length; i++)  {
		if (document.form1.rthumbs[i].checked)
			document.form1.rthumbs[i].checked = '';
	}
	var params = $H({entity:entity,tree:tree,album:album,action:'deldef'}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params});
	return false;
}
