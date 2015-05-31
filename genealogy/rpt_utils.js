function toggleSection(section,img,display) {
	if(display == 'on') {
		$(img).src = 'tng_collapse.gif';
		new Effect.Appear(section,{duration:.3});
	}
	else if(display == 'off') {
		$(img).src = 'tng_expand.gif';
		new Effect.Fade(section,{duration:.3});
	}
	else {
		$(img).src= $(img).src.indexOf('collapse') > 0 ? 'tng_expand.gif' : 'tng_collapse.gif';
		new Effect.toggle(section,'appear',{duration:.3});
	}
	return false;
}