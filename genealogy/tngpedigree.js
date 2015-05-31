for( var h = 1; h < slotceiling; h++ ) {
	eval( 'var timer' + h + '=false' );
}
var timerleft = false;

function showPopup( slot, tall, high ){
// hide any other currently visible popups
	if( lastpopup ) {
		cancelTimer(lastpopup);
		hidePopup(lastpopup);
	}
	lastpopup = slot;

// show current
	var ref = document.all ? document.all["popup" + slot] : document.getElementById ? document.getElementById("popup" + slot) : null;

	ref.innerHTML = getPopup(slot);
	if ( ref ) {ref = ref.style;}

	if ( ref.visibility != "show" && ref.visibility != "visible" ) {
		ref.top = ( tall + high ) < 0 ? 0 : ( tall + high + pedborderwidth ) + 'px';
		ref.zIndex = 8;
    	ref.visibility = "visible";
	}
}

function showBackPopup() {
	if( lastpopup ) {
		cancelTimer(lastpopup);
		hidePopup(lastpopup);
	}
	lastpopup = '';
	
	var ref = document.getElementById("popupleft");
	ref.innerHTML = getBackPopup();
	if ( ref ) {ref = ref.style;}

	if ( ref.visibility != "show" && ref.visibility != "visible" ) {
		ref.zIndex = 8;
    	ref.visibility = "visible";
	}
}

function setTimer(slot) {
	eval( "timer" + slot + "=setTimeout(\"hidePopup('" + slot + "')\",popuptimer);");
}

function cancelTimer(slot) {
	eval( "clearTimeout(timer" + slot + ");" );
	eval( "timer" + slot + "=false;" );
}

function hidePopup(slot) {
  var ref = document.all ? document.all["popup" + slot] : document.getElementById ? document.getElementById("popup" + slot) : null ;
  if (ref) { ref.style.visibility = "hidden"; }
  eval("timer" + slot + "=false;");
}

function setFirstPerson(newperson) {
	if(newperson != firstperson) {
		firstperson = newperson;
		if( !tngprint ) {
			$("stdpedlnk").href = pedigree_url + 'personID=' + newperson + '&tree=' + tree + '&parentset=' + parentset + '&display=standard&generations=' + generations;
			$("compedlnk").href = pedigree_url + 'personID=' + newperson + '&tree=' + tree + '&parentset=' + parentset + '&display=compact&generations=' + generations;
			$("boxpedlnk").href = pedigree_url + 'personID=' + newperson + '&tree=' + tree + '&parentset=' + parentset + '&display=box&generations=' + generations;
			$("textlnk").href = pedigreetext_url + 'personID=' + newperson + '&tree=' + tree + '&parentset=' + parentset + '&generations=' + generations;
			$("ahnlnk").href = ahnentafel_url + 'personID=' + newperson + '&tree=' + tree + '&parentset=' + parentset + '&generations=' + generations;
			$("extralnk").href = extrastree_url + 'personID=' + newperson + '&tree=' + tree + '&parentset=' + parentset + '&showall=1&generations=' + generations;
		}
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

function getTextNodesByNum(node) {
	var textNodes = new Array();
	var counter = 0;

	for(var i = 0; i < node.childNodes.length; i++ ) {
		if( node.childNodes[i].nodeType == "1" ) {
			textNodes[counter] = node.childNodes[i];
			counter++;
		}
	}
	return textNodes;
}

function getNodeValue(node) {
	var rval = "";
	if(node.firstChild) rval = node.firstChild.nodeValue;
	return rval;
}

function fetchData(famParams,newgens) {
   	var loading = document.getElementById("loading");
	loading.style.visibility = "visible";

	var strParams = "generations=" + newgens + "&tree=" + tree + '&display=' + display + famParams;
 	var loader1 = new net.ContentLoader(pedxmlfile,FillChart,null,"POST",strParams);
}

function getNewChart(personID,newgens,newparentset) {
	setFirstPerson(personID);
	fetchData('&personID=' + personID + '&parentset=' + newparentset, newgens );
}

function getNewFamilies(famParams,newgens,gender) {
	//set first person
	var nextfamily = people[firstperson].famc;
	if( gender == "F" )
		setFirstPerson(families[nextfamily].wife);
	else
		setFirstPerson(families[nextfamily].husband);

	if( famParams )
		fetchData(famParams,newgens);
	else
		DisplayChart();
}

function goBack(backperson) {
	setFirstPerson( backperson );
	DisplayChart();
}

function FillChart() {
	var xmlDoc = this.req.responseXML.documentElement;
	var xPeople = xmlDoc.getElementsByTagName('person');
	for(i=0; i < xPeople.length; i++) {
		var nextperson = new Person(xPeople[i]);
		people[nextperson.personID] = nextperson;
	}
	var xFamilies = xmlDoc.getElementsByTagName('fam');
	for(i=0; i < xFamilies.length; i++){
		var fam = getTextNodes(xFamilies[i]);
		var famID = fam['famID'].firstChild.nodeValue;
		var family = new Object;
		family.famID = famID;
		family.mdate = getNodeValue(fam['mdate']);
		family.mplace = getNodeValue(fam['mplace']);
		family.mabbr = getNodeValue(fam['mabbr']);
		family.husband = getNodeValue(fam['husband']);
		family.wife = getNodeValue(fam['wife']);
		families[famID] = family;
	}
   	var loading = document.getElementById("loading");
	DisplayChart();
	loading.style.visibility = "hidden";
}

function Person(nodes) {
	if( nodes ) {
		var persnodes = getTextNodesByNum(nodes);
		var pers = getTextNodes(persnodes[0]);
		this.personID = pers['personID'].firstChild.nodeValue;

		this.spfams = new Array();
		this.parents = new Array();

   		var parentctr = 0, spousectr = 0;
		for(var i = 1; i < persnodes.length; i++ ) {
			if( persnodes[i].nodeName == "spFam" )
				this.spfams[spousectr++] = new SpouseFam(persnodes[i]);
			else
				this.parents[parentctr++] = new Parents(persnodes[i]);
		}

		this.tree = getNodeValue(pers['tree']);
		this.backperson = getNodeValue(pers['backpersonID']);
		this.name = getNodeValue(pers['nm']);
		this.gender = getNodeValue(pers['gender']);
		this.famc = getNodeValue(pers['parentfam']);
		this.photosrc = getNodeValue(pers['photosrc']);
		this.photolink = getNodeValue(pers['photolink']);
		this.bdate = getNodeValue(pers['bdate']);
		this.bplace = getNodeValue(pers['bplace']);
		this.babbr = getNodeValue(pers['babbr']);
		this.ddate = getNodeValue(pers['ddate']);
		this.dplace = getNodeValue(pers['dplace']);
		this.dabbr = getNodeValue(pers['dabbr']);
	}
	else {
		this.personID = 0;
		this.famc = -1;
		this.tree = -1;
	}

	return this;
}

function SpouseFam(nodes) {
	var spfam = getTextNodesByNum(nodes);
	if( spfam.length && spfam[0].nodeName == "spInfo" ) {
		var spouse = getTextNodes(spfam[0]);
		this.spname = getNodeValue(spouse['spNm']);
		this.spID = getNodeValue(spouse['spID']);
		this.spFamID = getNodeValue(spouse['spFamID']);
		var nextnode = 1;
	}
	else {
		this.spname = '';
		this.spID = -1;
		var nextnode = 0;
	}
	if( spfam.length ) {
		this.children = new Array();
		var childctr = 0;
		for( var i = nextnode; i < spfam.length; i++ ) {
			this.children[childctr] = new Child(spfam[i]);
			childctr++;
		}
	}
	return this;
}

function Child(nodes) {
	var chinfo = getTextNodes(nodes);
	this.childID = getNodeValue(chinfo['chID']);
	this.name = getNodeValue(chinfo['chNm']);
	return this;
}

function Parents(nodes) {
	var parinfo = getTextNodes(nodes);
	this.famID = getNodeValue(parinfo['pfam']);
	this.fatherID = getNodeValue(parinfo['fID']);
	this.fathername = getNodeValue(parinfo['fNm']);
	this.motherID = getNodeValue(parinfo['mID']);
	this.mothername = getNodeValue(parinfo['mNm']);
	return this;
}

function DisplayChart() {
	toplinks = "";
	botlinks = "";
	endslotctr = 0;
	endslots = new Array();

	var slot = 1;
	FillSlot(slot,firstperson,0);

	var offpage;
	var leftarrow = document.getElementById('leftarrow');
	if(people[firstperson].backperson) {
		leftarrow.innerHTML = '<a href="javascript:goBack(' + "'" + people[firstperson].backperson + "'" + ');">' + leftarrowimg + '</a>';
		leftarrow.style.visibility = "visible";
	}
	else {
		var gotkids = 0;
		var activeperson = people[firstperson];
		if( activeperson.spfams.length ) {
			for( var i = 0; i < activeperson.spfams.length; i++ ) {
				if( activeperson.spfams[i].children && activeperson.spfams[i].children.length ) {
					gotkids = 1;
					break;
				}
			}
		}
		if( gotkids ) {
			leftarrow.innerHTML = '<a href="javascript:showBackPopup();">' + leftarrowimg + '</a>';
			leftarrow.style.visibility = "visible";
		}
		else {
			leftarrow.innerHTML = '';
			leftarrow.style.visibility = "hidden";
		}
	}

	topparams = getParams( toplinks );
	botparams = getParams( botlinks );

	for( var i = 0; i < endslots.length; i++ ) {
		offpage = document.getElementById('offpage'+endslots[i]);
		offpage.style.visibility = "visible";
	}
}

function FillSlot(slot,currperson,lastperson) {
	var currentBox = document.getElementById('box'+slot);
	var content;
	var slotperson, husband, wife;

	if( people[currperson] )
		slotperson = people[currperson];
	else {
		slotperson = new Object;
		slotperson.famc = -1;
		slotperson.personID = 0;
	}
	slots[slot] = slotperson;
   	var dnarrow = document.getElementById('downarrow'+slot);
   	var popup = document.getElementById('popup'+slot);
	var popupcontent = "";
	var shadow, border;

	if( slotperson.personID ) {
		//save primary marriage
		if( lastperson )
			slotperson.famID = people[lastperson].famc;
		else
			slotperson.famID = "";
		if( hideempty ) {
			currentBox.style.visibility = 'visible';
			toggleLines(slot,slotperson.famc,'visible');
		}
		if( slotperson.photosrc && slotperson.photosrc != "-1" ) {
			if( slotperson.photolink )
				content = '<a href="' + slotperson.photolink + '"><img src="' + slotperson.photosrc + '" id="img' + slot + '" border="0"></a>';
			else
				content = '<img src="' + slotperson.photosrc + '" id="img' + slot + '" border="0">';
			content = '<td align="left" valign="top">' + content + '</td>';
		}
		else
			content = "";
		content += '<td class="pboxname" id="td' + slot + '" colspan="2">' + namepad + '<a href="' + getperson_url + 'personID=' + slotperson.personID + '&amp;tree=' + slotperson.tree + '">' + slotperson.name + '</a>';

		//put small pedigree link in every box except for primary individual
		if( popupchartlinks && slotperson.famc != -1 && slotperson.personID != personID)
			content += ' <a href="' + pedigree_url + 'personID=' + slotperson.personID + '&amp;tree=' + tree + '&amp;display=' + display + '&amp;generations=' + generations + '">' + chartlink + '</a>';
		if( display == "box" ) {
			var bmd = doBMD(slot,slotperson);
			if( bmd ) content += '<table border="0" cellpadding="0" cellspacing="0">' + bmd + '</table>';
		}
		content += '</td>';
		currentBox.style.backgroundColor = currentBox.oldcolor;

		if( usepopups ) {
			if( slotperson.spfams.length || slotperson.bdate || slotperson.bplace || slotperson.ddate || slotperson.dplace || slotperson.parents.length ) {
				dnarrow.style.visibility = "visible";
				popup.innerHTML = popupcontent;
			}
			else
				dnarrow.style.visibility = "hidden";
		}
	}
	//no person
	else {
		if( hideempty ) {
			content = '';
			currentBox.style.visibility = "hidden";
			toggleLines(slot,0,'hidden');
		}
		else {
			if( allow_add && lastperson ) {
				if( people[lastperson].famc != -1 )
					content = '<td class="pboxname" id="td' + slot + '" align="' + pedboxalign + '">' + namepad + '<a href="' + cmstngpath + 'admin/editfamily.php?familyID=' + people[lastperson].famc + '&amp;tree=' + tree + '&amp;cw=1" target="_blank">' + txt_editfam + '</a></td>';
				else
					content = '<td class="pboxname" id="td' + slot + '" align="' + pedboxalign + '">' + namepad + '<a href="' + cmstngpath + 'admin/newfamily.php?child=' + lastperson + '&amp;tree=' + tree + '" target="_blank">' + txt_addfam + '</a></td>';
	 		}
			else
				content = '<td class="pboxname" id="td' + slot + '" align="' + pedboxalign + '">' + namepad + unknown + '</td>';
			currentBox.style.backgroundColor = emptycolor;
		}
		if( usepopups ) {
			dnarrow.style.visibility = "hidden";
			popup.innerHTML = "";
		}
	}
	if( content )
		currentBox.innerHTML = '<table border="0" style="height:100%;" cellpadding="' + pedcellpad + '" cellspacing="0" align="' + pedboxalign + '"><tr>' + content + '</tr></table>';
	else
		currentBox.innerHTML = "";

	var	nextslot = slot * 2;
	if( slotperson.famc != -1 && families[slotperson.famc] ) {
		husband = families[slotperson.famc].husband;
		wife = families[slotperson.famc].wife;
	}
	else {
		husband = 0;
		wife = 0;
	}
	if( nextslot < slotceiling ) {
		FillSlot(nextslot,husband,slotperson.personID);
		nextslot++;
		FillSlot(nextslot,wife,slotperson.personID);
	}
	else if( slotperson.famc != "-1" ) {
		if( slot < (slotceiling_minus1 * 3 / 2) )
			toplinks = addToList(toplinks,slotperson.personID);
		else
			botlinks = addToList(botlinks,slotperson.personID);
		endslots[endslotctr] = slot;
		endslotctr++;
	}
	else {
		offpage = document.getElementById('offpage'+slot);
		offpage.style.visibility = "hidden";
	}
}

function toggleLines(slot,nextperson,visibility) {
	var newvis;

	for( var i = 1; i <= 5; i++ ) {
		shadow = document.getElementById('shadow'+slot+'_'+i);
		border = document.getElementById('border'+slot+'_'+i);
		if( i == 3 && nextperson == -1 )
			newvis = "hidden";
		else
			newvis = visibility;
		if( shadow )
			shadow.style.visibility = newvis;
		if( border )
			border.style.visibility = newvis;
	}
}

function addToList(linklist,backperson) {
	if( linklist.indexOf(backperson) < 0 ) {
		if( linklist ) linklist += ",";
		linklist += backperson;
	}
	return linklist;
}

function getParams( personstr ) {
	var params = "", currperson, nextfamily;

	if( personstr ) {
		var pers = personstr.split(",")
		for( var i = 0; i < pers.length; i++ ) {
			currperson = pers[i];
			nextfamily = people[currperson].famc;
			if( !families[nextfamily] ) {
				ctr = i + 1;
				params += "&backpers" + ctr + "=" + currperson + "&famc" + ctr + "=" + people[currperson].famc;
			}
		}
	}

	return params;
}

function doRow(slot,slotabbr,slotevent1,slotevent2) {
	var rstr = "";
	slotabbr += ":";
	if( slotevent1 )
		rstr += '<tr><td class="normal pboxpopup" align="right" valign="top" id="popabbr' + slot + '">' + slotabbr + '</td><td class="normal pboxpopup" valign="top" colspan="3" id="pop' + slot + '">' + slotevent1 + '</td></tr>';
	if( slotevent2 ) {
		if( slotevent1 ) slotabbr = '&nbsp;';
		rstr += '<tr><td class="normal pboxpopup" align="right" valign="top" id="popabbr' + slot + '">' + slotabbr + '</td><td class="normal pboxpopup" valign="top" colspan="3" id="pop' + slot + '">' + slotevent2 + '</td></tr>';
	}

	return rstr;
}

function getBackPerson(nxtpersonID) {
	hidePopup('left');
	getNewChart(nxtpersonID, generations, 0);
}

function getBackPopup() {
	var popupcontent = "", spouselink, count, kidlink;

	var slotperson = slots[1];

	if( slotperson.spfams.length ) {
		for( var i = 0; i < slotperson.spfams.length; i++ ) {
			var fam = slotperson.spfams[i];
			count = i + 1;

			//do each spouse
			if( fam.spID && fam.spID != -1)
				spouselink = fam.spname;
			else
				spouselink = unknown;

		    popupcontent += '<tr><td class="normal pboxpopup" valign="top" nowrap id="popabbrleft"><b>' + count + '</b></td>';
			popupcontent += '<td class="normal pboxpopup" valign="top" nowrap colspan="2" id="popleft">' + spouselink + '</td></tr>';

			if( popupkids && fam.children.length ) {
   				popupcontent += '<tr><td class="normal pboxpopup" align="right" valign="top" id="popabbrleft">&nbsp;</td><td class="normal pboxpopup" valign="top" colspan="3" id="popleft"><B>' + txt_children + ':</B></td></tr>\n';
				for( var j = 0; j < fam.children.length; j++ ) {
					var spchild = fam.children[j];

					kidlink = '<a href="javascript:getBackPerson(' + "'" + spchild.childID + "'" + ')">';
				    popupcontent += '<tr><td class="normal pboxpopup" valign="top" nowrap id="popabbrleft">' + kidlink + '<img src="ArrowLeft.gif" width="10" height="16" border="0"></a></td>';
					popupcontent += '<td class="normal pboxpopup" valign="top" nowrap id="popleft">' + kidlink + spchild.name + '</a></td></tr>';
				}
			}
		}
	}

	if( popupcontent )
	 	popupcontent = '<table style="border: 1px solid ' + pedbordercolor + '" cellpadding="1" cellspacing="0"><tr><td><table border="0" cellspacing="0" cellpadding="1">' + popupcontent + '</table></td></tr></table>\n';
		
	return popupcontent;
}

function doBMD(slot,slotperson) {
	var famID = slotperson.famID;
	var content = '';

	content += doRow(slot,slotperson.babbr,slotperson.bdate,slotperson.bplace);
	if( famID )
		content += doRow(slot,families[famID].mabbr,families[famID].mdate,families[famID].mplace);
	content += doRow(slot,slotperson.dabbr,slotperson.ddate,slotperson.dplace);
	
	return content;
}

function getPopup(slot) {
	var popupcontent = "", spouselink, sppedlink, count, kidlink, kidpedlink, parpedlink, parentlink;

	var slotperson = slots[slot];

	if( display == "standard" )
		popupcontent += doBMD(slot,slotperson);

	if( slotperson.parents.length ) {
   		popupcontent += '<tr><td class="normal pboxpopup" valign="top" colspan="4" id="pop' + slot + '"><B>' + txt_parents + ':</B></td></tr>\n';
		for( var i = 0; i < slotperson.parents.length; i++ ) {
			var par = slotperson.parents[i];
			count = i + 1;
			parentlink = '';

			if( par.fatherID )
				parentlink += '<a href="' + getperson_url + 'personID=' + par.fatherID + '&amp;tree=' + tree + '">' + par.fathername + '</a>';
			if( par.motherID ) {
				if( parentlink ) parentlink += ", ";
				parentlink += '<a href="' + getperson_url + 'personID=' + par.motherID + '&amp;tree=' + tree + '">' + par.mothername + '</a>';
			}
			if( par.famID != slotperson.famc )
				parpedlink = '<a href="' + pedigree_url + 'personID=' + slotperson.personID + '&amp;tree=' + tree + '&amp;parentset=' + count + '&amp;display=' + display + '&amp;generations=' + generations + '">' + chartlink + '</a>';
			else
				parpedlink = '';
		    popupcontent += '<tr><td class="normal pboxpopup" valign="top" nowrap id="popabbr' + slot + '"><b>' + count + '</b></td>';
			popupcontent += '<td class="normal pboxpopup" valign="top" nowrap colspan="2" id="pop' + slot + '">' + parentlink + '</td>';
			popupcontent += '<td class="normal pboxpopup" valign="top" align="right" nowrap>&nbsp;' + parpedlink + '</td></tr>';
		}
	}

	if( popupspouses && slotperson.spfams.length ) {
		for( var i = 0; i < slotperson.spfams.length; i++ ) {
			var fam = slotperson.spfams[i];
			count = i + 1;

			popupcontent += '<tr><td class="normal pboxpopup" valign="top" colspan="4" id="pop' + slot + '"><B>' + txt_family + ':</B> [<a href=\"' + familygroup_url + 'familyID=' + fam.spFamID + '&amp;tree=' + tree + '">' + txt_groupsheet + '</a>]</td></tr>';
			//do each spouse
			sppedlink = '';
			if( fam.spID && fam.spID != -1) {
				spouselink = '<a href="' + getperson_url + 'personID=' + fam.spID + '&amp;tree=' + tree + '">' + fam.spname + '</a>';
				if( popupchartlinks )				
					sppedlink = '<a href="' + pedigree_url + 'personID=' + fam.spID + '&amp;tree=' + tree + '&amp;display=' + display + '&amp;generations=' + generations + '">' + chartlink + '</a>';
			}
			else
				spouselink = unknown;

		    popupcontent += '<tr><td class="normal pboxpopup" valign="top" nowrap id="popabbr' + slot + '"><b>' + count + '</b></td>';
			popupcontent += '<td class="normal pboxpopup" valign="top" nowrap colspan="2" id="pop' + slot + '">' + spouselink + '</td>';
			popupcontent += '<td class="normal pboxpopup" valign="top" align="right" nowrap>&nbsp;' + sppedlink + '</td></tr>';

			if( popupkids && fam.children && fam.children.length ) {
   				popupcontent += '<tr><td class="normal pboxpopup" align="right" valign="top" id="popabbr' + slot + '">&nbsp;</td><td class="normal pboxpopup" valign="top" colspan="3" id="pop' + slot + '"><B>' + txt_children + ':</B></td></tr>\n';
				for( var j = 0; j < fam.children.length; j++ ) {
					var spchild = fam.children[j];

					kidlink = '<a href="' + getperson_url + 'personID=' + spchild.childID + '&amp;tree=' + tree + '">' + spchild.name + '</a>';
					if( popupchartlinks )
						kidpedlink = '<a href="' + pedigree_url + 'personID=' + spchild.childID + '&amp;tree=' + tree + '&amp;display=' + display + '&amp;generations=' + generations + '">' + chartlink + '</a>';
					else
						kidpedlink = '';
				    popupcontent += '<tr><td class="normal pboxpopup" valign="top" nowrap id="popabbr' + slot + '">&nbsp;</td>';
					popupcontent += '<td class="normal pboxpopup" valign="top" nowrap id="pop' + slot + '">' + pedbullet + '</td>';
					popupcontent += '<td class="normal pboxpopup" valign="top" nowrap id="pop' + slot + '">' + kidlink + '</td>';
					popupcontent += '<td class="normal pboxpopup" valign="top" align="right" nowrap id="pop' + slot + '">' + kidpedlink + '</td></tr>';
				}
			}
		}
	}

	if( popupcontent )
	 	popupcontent = '<table style="border: 1px solid ' + pedbordercolor + '" cellpadding="1" cellspacing="0"><tr><td><table border="0" cellspacing="0" cellpadding="1">' + popupcontent + '</table></td></tr></table>\n';

	return popupcontent;
}
