function saveTentEdit(form) {
	$('tspinner').style.display = '';
	var params = Form.serialize(form);
	new Ajax.Request('savetentedit.php',{parameters:params,
		onSuccess:function(req){
			$('tentedit').style.display = 'none';
			$('finished').style.display = '';
		}
	});
	return false;
}