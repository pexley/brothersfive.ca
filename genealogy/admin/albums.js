function startAlbums() {
	Sortable.create('orderdivs',{tag:'div',onUpdate:updateAlbumMediaOrder});
	//crossPlatAddListener($('searchstring'), "keydown", keyHandlerMedia);
	//startListening();
}

function startAlbumSort() {
	Sortable.create('orderdivs',{tag:'div',onUpdate:updateAlbumOrder});
}

function updateAlbumOrder(id) {
	var albumlinks = Sortable.sequence(id);
	var albumlinklist = new Array();

	for(var i=0; i<albumlinks.length; i++) {
		albumlinklist[i] = albumlinks[i];
	}

	var params = $H({sequence:albumlinklist.join(','),action:'alborder'}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params});
}

function updateAlbumMediaOrder(id) {
	var links = Sortable.sequence(id);
	var linklist = new Array();

	for(var i=0; i<links.length; i++) {
		linklist[i] = links[i];
	}

	var params = $H({sequence:linklist.join(','),album:album,action:'order'}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params});
}

function validateForm( ) {
	var rval = true;
	if( document.form1.albumname.value.length == 0 ) {
		alert("<?php echo $admtext[enteralbumname]; ?>");
		rval = false;
	}
	return rval;
}

function toggleHeadstoneCriteria(form,mediatypeID) {
	var hsstatus = $('hsstatrow');
	var cemrow = $('cemrow');
	if( mediatypeID == 'headstones' ) {
		$('newmedia').style.height='380px';
		cemrow.style.display='';
		hsstatus.style.display='';
	}
	else {
		$('newmedia').style.height='430px';
		cemrow.style.display='none';
		form.cemeteryID.selectedIndex = 0;
		hsstatus.style.display='none';
		form.hsstat.selectedIndex = 0;
	}
	return false;
}

function getNewMedia(form,flag) {
	var hsstring;
	var searchstring = form.searchstring.value;
	if(searchstring) {
		doSpinner(1);
		$('newmedia').innerHTML = '';
		var searchtree = form.searchtree.options[form.searchtree.selectedIndex].value;
		var mediatypeID = form.mediatypeID.options[form.mediatypeID.selectedIndex].value;

		if( mediatypeID == "headstones") {
			var hsstat = form.hsstat.options[form.hsstat.selectedIndex].value;
			var cemeteryID = form.cemeteryID.options[form.cemeteryID.selectedIndex].value;
			hsstring = "&hsstat=" + hsstat + "&cemeteryID=" + cemeteryID;
		}
		else
			hsstring = "";

		var strParams = "albumID=" + album + "&searchstring=" + searchstring + "&searchtree=" + searchtree + "&mediatypeID=" + mediatypeID + hsstring;
		new Ajax.Request('add2albumxml.php',{parameters:strParams,onSuccess:showMedia});
	}
	else if(flag)
		alert(searchmsg);
}

function getMoreMedia(url) {
	new Ajax.Request('add2albumxml.php',{parameters:url,onSuccess:showMedia});
	return false;
}

function showMedia(req) {
	var newrows = req.responseText;

	$('newmedia').innerHTML = newrows;
	$('spinner1').style.display = 'none';
}

function addToAlbum(media) {
	var params = $H({media:media,album:album,action:'add'}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params,onSuccess:finishAddToAlbum});
	return false;
}

function finishAddToAlbum(req) {
	var newrow;
	
	var pairs = req.responseText.split('&');
	var media = parseInt(pairs[0]);
	var albumlink = parseInt(pairs[1]);

	newrow = '<table width="100%" cellpadding="5" cellspacing="1"><tr>\n';
	newrow += '<td class="dragarea normal">';
	newrow += '<img src="ArrowUp.gif" alt=""><br/>' + dragmsg + '<br/><img src="ArrowDown.gif" alt="">\n';
	newrow += '</td>\n';
	newrow += '<td class="lightback" style="width:' + (thumbmaxw+6) + 'px;text-align:center;">' + $('thumbcell_'+media).innerHTML +  '</td>\n';
	newrow += '<td class="lightback normal">' + $('desc_'+media).innerHTML;
	newrow += '<div id="del_' + albumlink + '" class="smaller" style="color:gray;visibility:hidden">';
	if($('thumbcell_'+media).innerHTML != "&nbsp;") {
		newrow += '<input type="radio" name="rthumbs" value="r' + media + '" onclick="makeDefault(this);">' + mkdefaultmsg;
		newrow += ' &nbsp;|&nbsp; ';
	}
	newrow += '<a href="#" onclick="return removeFromAlbum(\'' + media + '\',\'' + albumlink + '\');">' + remove_text + '</a></div></td>\n';
	newrow += '<td class="lightback normal" style="width:150px;" valign="top">' + $('date_'+media).innerHTML + '</td>';
	newrow += '<td class="lightback normal" style="width:100px;" valign="top">' + $('mtype_'+media).innerHTML + '</td>\n';
	newrow += '</tr></table>';

	$('add_'+media).style.display = 'none';
	if($('added_'+media).innerHTML == "")
		$('added_'+media).innerHTML = '<img src="tng_test.gif" alt="" width="20" height="20" class="smallicon">';
	new Effect.Appear('added_'+media,{duration:.4});

	var div = document.createElement("div");
	div.id = "orderdivs_"+albumlink;
	div.className = "sortrow";
	div.style.clear = "both";
	div.style.position = "relative";
	div.onmouseover = function(){$('del_' + albumlink).style.visibility='visible';};
	div.onmouseout = function(){$('del_' + albumlink).style.visibility='hidden';};
	div.innerHTML = newrow;
	$('orderdivs').appendChild(div);

	mediacount = mediacount + 1;
	$('mediacount').innerHTML = mediacount;
	$('nomedia').style.display='none';
	Sortable.create('orderdivs',{tag:'div',onUpdate:updateAlbumMediaOrder});
}

function removeFromAlbum(media,albumlink) {
	if(confirm(confremmedia)) {
		var params = $H({media:media,albumlink:albumlink,action:'remalb'}).toQueryString();
		new Ajax.Request('updateorder.php',{parameters:params,onSuccess:finishRemoveFromAlbum});
	}
	return false;
}

function finishRemoveFromAlbum(req) {
	var pairs = req.responseText.split('&');
	var media = parseInt(pairs[0]);
	var albumlink = parseInt(pairs[1]);
	new Effect.Fade('orderdivs_' + albumlink,{duration:.4,afterFinish:function(){Element.remove('orderdivs_' + albumlink);}});
	if($('added_'+media)) {
		$('added_'+media).style.display = 'none';
		new Effect.Appear('add_'+media,{duration:.4});
	}
	mediacount = mediacount - 1;
	$('mediacount').innerHTML = mediacount;
}

function openAlbumMediaFind() {
	tnglitbox = new LITBox('findalbummedia.php',{width:640,height:540});
	return false;
}