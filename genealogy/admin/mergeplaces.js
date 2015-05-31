function validateForm1() {
	var rval = true;
	if( document.form1.place.value.length == 0 ) {
		alert(enterplace);
		rval = false;
	}
	return rval;
}

function validateForm2(form) {
	var rval = false;

	blankMsg();
	for( var i = 0; i < form.keep.length; i++ ) {
		if( form.keep[i].checked ) {
			rval = true;
			break;
		}
	}
	if( !rval )
		alert(enterkeep);
	if(rval) {
		var tree = document.form1.tree.options[document.form1.tree.selectedIndex].value;
		var checks = $$('input.mc');
		var mergelist = new Array();
		checks.each(function(item){
			if(item.checked && item.value != form.keep[i].value)
				mergelist.push(item.value);
		});
		var keep = form.keep[i].value;
		$('placespin').style.display = '';
		var params = $H({places:mergelist.join(','),keep:keep,tree:tree}).toQueryString();
		new Ajax.Request('mergeplacesajax.php',{
			parameters:params,
			onSuccess:function(req){
				mergelist.each(function(item){
					new Effect.Fade('row_'+item,{duration:.3});
				});
				$('placespin').style.display = 'none';
				$('successmsg1').innerHTML = successmsg;
				$('successmsg2').innerHTML = successmsg;
				var lastone = eval('form.mc'+keep);
				lastone.checked = false;
			}
		});
	}

	return false;
}

var delcolor = '#ff9999';
var keepcolor = '#99ff99';
var neutcolor = '#ffffff';
var lastradio;

function blankMsg() {
	$('successmsg1').innerHTML = '';
	$('successmsg2').innerHTML = '';
}

function handleCheck(id) {
	var check = eval('document.form2.mc'+id+'.checked');
	var newcolor = check ? delcolor : '';

	blankMsg();
	var tds = $$('tr#row_'+id+' td');
	var currRadioChecked = $('r'+id).checked;
	if(!currRadioChecked) {
		tds.each(function(item){
			item.style.backgroundColor = newcolor;
		});
	}
}

function handleRadio(id) {
	var newcolor, tds, currID;

	blankMsg();
	var trs = $$('tr.mergerows');
	trs.each(function(row){
		newcolor = "";
		currID = parseInt(row.id.substr(4));
		if(id == currID)
			newcolor = keepcolor;
		else {
			currCheck = eval('document.form2.mc'+currID+'.checked');
			if(currCheck)
				newcolor = delcolor;
			else {
				if(currID == lastradio)
					newcolor = neutcolor;
			}
		}
		if(newcolor) {
			tds = $$('tr#'+row.id+' td');
			tds.each(function(item){
				item.style.backgroundColor = newcolor;
			})
		}
	})
	lastradio = id;
}
