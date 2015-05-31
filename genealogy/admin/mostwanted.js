function startMostWanted() {
	Sortable.create('orderpersondivs',{dropOnEmpty:true,tag:'div',containment:['orderpersondivs','orderphotodivs'],onUpdate:updatePersonOrder});
	Sortable.create('orderphotodivs',{dropOnEmpty:true,tag:'div',containment:['orderpersondivs','orderphotodivs'],onUpdate:updatePhotoOrder});
}

function updatePersonOrder(id) {
	updateMostWantedOrder(id,'person');
}

function updatePhotoOrder(id) {
	updateMostWantedOrder(id,'photo');
}

function updateMostWantedOrder(id,mwtype) {
	var links = Sortable.sequence(id);
	var linklist = new Array();

	for(var i=0; i<links.length; i++) {
		linklist[i] = links[i];
	}

	var params = $H({sequence:linklist.join(','),mwtype:mwtype,action:'mworder'}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params});
}

function openMostWanted(mwtype,ID) {
	mwlitbox = new LITBox('editmostwanted.php?mwtype='+mwtype+'&ID='+ID,{width:645,height:440});
	return false;
}

function openMostWantedMediaFind(tree) {
	tnglitbox = new LITBox('findmwmedia.php?mediatypeID=photos&tree='+tree,{width:640,height:540});
	return false;
}

function updateMostWanted(form) {
	if( form.title.value.length == 0)
		alert(entertitle);
	else if(form.description.value.length == 0)
		alert(enterdesc);
	else {
		var params = Form.serialize(form);
		new Ajax.Request('updatemostwanted.php',{
			parameters:params,
			onSuccess:function(req){
				var vars = eval('('+req.responseText+')');
				if(form.ID.value) {
					//if it's old, just update existing row and highlight
					$('title_'+vars.ID).innerHTML = vars.title;
					$('desc_'+vars.ID).innerHTML = vars.description;
					//update thumbnail if necessary
					if(vars.thumbpath) {
						$('img_'+vars.ID).src = vars.thumbpath;
						$('img_'+vars.ID).style.width = vars.width +'px';
						$('img_'+vars.ID).style.height = vars.height +'px';
					}
				}
				else {
					//if it's new, then insert row at bottom
					var newcontent = '<div class="sortrow" id="order' + vars.mwtype + 'divs_' + vars.ID + '" style="clear:both" onmouseover="showEditDelete(\'' + vars.ID + '\');" onmouseout="hideEditDelete(\'' + vars.ID + '\');">\n';
					newcontent += '<table width="100%" cellpadding="5" cellspacing="1"><tr id="row_' + vars.ID + '">\n';
					newcontent += '<td class="dragarea normal">\n';
					newcontent += '<img src="ArrowUp.gif" alt=""><br/>' + drag + '<br/><img src="ArrowDown.gif" alt="">\n';
					newcontent += '</td>\n';
					newcontent += '<td class="lightback" style="width:' + thumbwidth + 'px;text-align:center;">\n';
					if(vars.thumbpath)
						newcontent += '<img src="' + vars.thumbpath + '" border="0" width="' + vars.width + '" height="' + vars.height + '" id="img_' + vars.ID + '" alt="' + vars.description + '" />\n';
					else
						newcontent += "&nbsp;";

					newcontent += '</td>\n';
					newcontent += '<td class="lightback normal">\n';
					if(vars.edit)
				   		newcontent += '<a href="#" onclick="return openMostWanted(\'' + vars.mwtype + '\',\'' + vars.ID + '\');" id="title_' + vars.ID + '">' + vars.title + '</a>\n';
					else
				   		newcontent += '<u id="title_' + vars.ID + '">' + vars.title + '</u>\n';
					newcontent += '<br /><span id="desc_' + vars.ID + '">' + vars.description + '</span><br />\n';
					newcontent += '<div id="del_' + vars.ID + '" class="smaller" style="color:gray;visibility:hidden">\n';
					if(vars.edit) {
				   		newcontent += '<a href="#" onclick="return openMostWanted(\'' + vars.mwtype + '\',\'' + vars.ID + '\');">' + edittext + '</a>\n';
						if(vars.del)
							newcontent += ' | ';
					}
					if(vars.del)
						newcontent += '<a href="#" onclick="return removeFromMostWanted(\'' + vars.mwtype + '\',\'' + vars.ID + '\');">' + deltext + '</a>\n';
					newcontent += '</div>\n</td>\n</tr></table>\n</div>\n';
					$('order'+vars.mwtype+'divs').innerHTML += newcontent;
					if(vars.mwtype == 'person')
						Sortable.create('orderpersondivs',{tag:'div',containment:['orderpersondivs','orderphotodivs'],dropOnEmpty:true,onUpdate:updatePersonOrder});
					else
						Sortable.create('orderphotodivs',{tag:'div',containment:['orderpersondivs','orderphotodivs'],dropOnEmpty:true,onUpdate:updatePhotoOrder});
				}

				var tds = $$('tr#row_'+vars.ID+' td');
				mwlitbox.remove();
				tds.each(function(item){new Effect.Highlight(item,{duration:2.0});})
			}
		});
	}
	return false;
}

function removeFromMostWanted(type,id) {
	if(confirm(confremmw)) {
		var params = $H({id:id,action:'remmostwanted'}).toQueryString();
		new Ajax.Request('updateorder.php',{
			parameters:params,
			onSuccess:function(){
				new Effect.Fade('order'+type+'divs_' + id,{duration:.4,
					afterFinish:function(){
						Element.remove('order'+type+'divs_' + id);
						if(type == 'person')
							Sortable.create('orderpersondivs',{tag:'div',containment:['orderpersondivs','orderphotodivs'],dropOnEmpty:true,onUpdate:updatePersonOrder});
						else
							Sortable.create('orderphotodivs',{tag:'div',containment:['orderpersondivs','orderphotodivs'],dropOnEmpty:true,onUpdate:updatePhotoOrder});
					}
				});
			}
		});
	}
	return false;
}

function showEditDelete(id) {
	if($('del_'+id))
		$('del_'+id).style.visibility='visible';
}

function hideEditDelete(id) {
	if($('del_'+id))
		$('del_'+id).style.visibility='hidden';
}

function getNewMwMedia(form) {
	var hsstring;
	var searchstring = form.searchstring.value;

	doSpinner(1);
	$('newmedia').innerHTML = '';
	var searchtree = form.tree.value;
	var mediatypeID = form.mediatypeID.value;

	var strParams = "searchstring=" + searchstring + "&searchtree=" + searchtree + "&mediatypeID=" + mediatypeID;
	new Ajax.Request('add2albumxml.php',{parameters:strParams,onSuccess:showMedia});
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

function doSpinner(id) {
	lastspinner = $('spinner'+id);
	$('spinner'+id).style.display = 'inline';
}

function selectMedia(mediaID) {
	document.editmostwanted.mediaID.value = mediaID;
	$('mwthumb').innerHTML = "&nbsp;";
	$('mwdetails').innerHTML = loading;

	new Ajax.Request('getphotodetails.php',{
		parameters:'mediaID='+mediaID,
		onSuccess:function(req){
			$('mwphoto').innerHTML = req.responseText;
		}
	});

	tnglitbox.remove();
	return false;
}
