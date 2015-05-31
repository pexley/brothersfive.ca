<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Sko�a allar heimildir";
		$text['shorttitle'] = "Stuttur titill";
		$text['callnum'] = "S�man�mer";
		$text['author'] = "H�fundur";
		$text['publisher'] = "�tgefandi";
		$text['other'] = "A�rar uppl�singar";
		$text['sourceid'] = "Heimilda ID";
		$text['moresrc'] = "Fleiri Heimildir";
		$text['repoid'] = "greftrunarsta�ur ID";
		$text['browseallrepos'] = "Sko�a alla greftrunarsta�i";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "N�tt tungum�l";
		$text['changelanguage'] = "Breyta tungum�li";
		$text['languagesaved'] = "Tungum�l vista�";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM byrjar fr�";
		$text['producegedfrom'] = "�tb�a GEDCOM skr� fr�";
		$text['numgens'] = "fj�ldi kynsl��a";
		$text['includelds'] = "hafa LDS uppl�singar me�";
		$text['buildged'] = "Byggja GEDCOM";
		$text['gedstartfrom'] = "GEDCOM byrjar fr�";
		$text['nomaxgen'] = "�� ver�ur a� skilgreina fj�lda kynsl��a. Vinsamlegast noti� back takkan til a� fara til baka";
		$text['gedcreatedfrom'] = "GEDCOM skapa� af";
		$text['gedcreatedfor'] = "Skapa� fyrir";

		$text['enteremail'] = "Vinsamlegast sl��u inn t�lvup�stfang.";
		$text['creategedfor'] = "�tb�a GEDCOM fyrir";
		$text['email'] = "T�lvup�stfang";
		$text['suggestchange'] = "Stinga upp� breytingu";
		$text['yourname'] = "Nafni� �itt";
		$text['comments'] = "Skilabo� e�a athugasemdir";
		$text['comments2'] = "Athugasemdir";
		$text['submitsugg'] = "Senda inn upp�stungu";
		$text['proposed'] = "Breyting";
		$text['mailsent'] = "Takk fyrir. Skilabo� ��n hafa veri� send.";
		$text['mailnotsent'] = "�v� mi�ur komust skilabo�in ekki til. Vinsamlegast haf�u samband vi� xxx beint yyy.";
		$text['mailme'] = "Senda afrit � �etta netfang";
		//added in 5.0.5
		$text['entername'] = "Vinsamlegast sl��u inn nafni� �itt";
		$text['entercomments'] = "Vinsamlegast sl��u inn athugasemdir";
		$text['sendmsg'] = "Senda skilabo�";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Lj�smyndir og saga fyrir";
		$text['indinfofor'] = "Einstaklings uppl�singar fyrir";
		$text['reliability'] = "�rei�anleiki";
		$text['pp'] = "bls.";
		$text['age'] = "Aldur";
		$text['agency'] = "Samt�k";
		$text['cause'] = "�st��a";
		$text['suggested'] = "Upp�stunga";
		$text['closewindow'] = "Loka �essum glugga";
		$text['thanks'] = "Takk fyrir";
		$text['received'] = "Upp�stungu hefur veri� komi� �lei�is til vefstj�ra til sko�unar.";
		//added in 6.0.0
		$text['association'] = "Tenging";
		//added in 7.0.0
		$text['indreport'] = "Individual Report";
		$text['indreportfor'] = "Individual Report for";
		$text['general'] = "General";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Skyldleika reiknir";
		$text['findrel'] = "Rekja saman";
		$text['person1'] = "Einstaklingur 1:";
		$text['person2'] = "Einstaklingur 2:";
		$text['calculate'] = "Reikna";
		$text['select2inds'] = "Veldu 2 einstaklinga.";
		$text['findpersonid'] = "Finna einstaklings n�mer";
		$text['enternamepart'] = "Sl��ur inn hluta fyrra nafns/e�a seinna nafns";
		$text['pleasenamepart'] = "Vinsamlegast sl��u inn hluta nafns.";
		$text['clicktoselect'] = "Smelltu h�r til a� velja";
		$text['nobirthinfo'] = "Engar upll�singar um f��ingardag";
		$text['relateto'] = "Skyldleiki til";
		$text['sameperson'] = "�etta er sama manneskjan hva� ertu a� sp� ?.";
		$text['notrelated'] = "�essir 2 einstaklingar eru ekki skyldir innan xxx kynsl��a.";
		$text['findrelinstr'] = "sl��u inn einstaklingsn�mer, e�a l�ttu f�lki� sj�st, smelltu svo � reikna a� finna skyldleika �eirra (up to xxx generations).";
		$text['gencheck'] = "H�marks fj�ldi kynsl��a<br />til a� ath";
		$text['sometimes'] = "(Stundum �egar athuga� er yfir mismunandi fj�lda kynsl��a kemur �nnur ni�ursta�a.)";
		$text['findanother'] = "Finna annan skyldleika";
		//added in 6.0.0
		$text['brother'] = "br��ir";
		$text['sister'] = "systir";
		$text['sibling'] = "systkyni";
		$text['uncle'] = "xxx fr�ndi";
		$text['aunt'] = "xxx fr�nka";
		$text['uncleaunt'] = "xxx fr�ndur/fr�nkur";
		$text['nephew'] = "xxx fr�ndi";
		$text['niece'] = "xxx fr�nka";
		$text['nephnc'] = "xxx fr�ndur/fr�nkur";
		$text['mcousin'] = "xxx fr�ndi";
		$text['fcousin'] = "xxx fr�ndi";
		$text['cousin'] = "xxx fr�ndi";
		$text['removed'] = "oft fjarl��ur";
		$text['rhusband'] = "eiginma�ur ";
		$text['rwife'] = "eiginkona ";
		$text['rspouse'] = "maki ";
		$text['son'] = "sonur";
		$text['daughter'] = "d�ttir";
		$text['rchild'] = "barn";
		$text['sil'] = "Tengdarsonur";
		$text['dil'] = "Tengdard�ttir";
		$text['sdil'] = "Tenddar sonur e�a d�ttir";
		$text['gson'] = "Barnabarn";
		$text['gdau'] = "xxx barnabarn";
		$text['gsondau'] = "xxx barnabarn";
		$text['great'] = "langa";
		$text['spouses'] = "eru makar";
		$text['is'] = "er";
		//changed in 6.0.0
		$text['changeto'] = "Breyta �:";
		//added in 6.0.0
		$text['notvalid'] = "er ekki gilt einstaklings id e�a er ekki til i gagnagrunni, vinsamlegast reyni� aftur.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Fj�lskyldu bla� fyrir";
		$text['ldsords'] = "LDS Ordinances";
		$text['baptizedlds'] = "Sk�r�ur (LDS)";
		$text['endowedlds'] = "Fermdur (LDS)";
		$text['sealedplds'] = "Sealed P (LDS)";
		$text['sealedslds'] = "Sealed S (LDS)";
		$text['otherspouse'] = "Annar/ur maki";
		//changed in 7.0.0
		$text['husband'] = "Eiginma�ur";
		$text['wife'] = "Eiginkona";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "F";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "G";
		$text['capplaceabbr'] = "S";
		$text['capmarrabbr'] = "G";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Endura�a me�";
		$text['scrollnote'] = "Ath: �� �arft kannski a� skruna ni�ur e�a til h�gri til a� sj�.";
		$text['unknownlit'] = "�skr��";
		$text['popupnote1'] = " = Auka uppl�singar";
		$text['popupnote2'] = " = N�tt ni�jatal";
		$text['pedcompact'] = "�jappa�";
		$text['pedstandard'] = "Sta�la�";
		$text['pedtextonly'] = "A�eins texta";
		$text['descendfor'] = "Afkomendur";
		$text['maxof'] = "H�mark af";
		$text['gensatonce'] = "kynsl��ir birtar � einu.";
		$text['sonof'] = "Sonur";
		$text['daughterof'] = "D�ttir";
		$text['childof'] = "barn";
		$text['stdformat'] = "Sta�la� sni�";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "B�ta vi� fj�lskyldu";
		$text['editfam'] = "Breyta fj�lskyldu";
		$text['side'] = "Hli�";
		$text['familyof'] = "Fj�lskylda";
		$text['paternal'] = "Paternal";
		$text['maternal'] = "Maternal";
		$text['gen1'] = "Sj�lf/ur";
		$text['gen2'] = "Foreldrar";
		$text['gen3'] = "�mmur og afar";
		$text['gen4'] = "Lang�mmur og afar";
		$text['gen5'] = "� annan �ttli�";
		$text['gen6'] = "� �ri�ja �ttli�";
		$text['gen7'] = "� fj�r�a �ttli�";
		$text['gen8'] = "� fimmta �ttli�";
		$text['gen9'] = "� sj�tta �ttli�";
		$text['gen10'] = "� Sj�unda �ttli�";
		$text['gen11'] = "� �ttunda �ttli�";
		$text['gen12'] = "� n�unda �ttli�";
		$text['graphdesc'] = "Graf�skt ny�jatal a� �essum punkti";
		$text['collapse'] = "Fella";
		$text['expand'] = " �tlista n�nar ";
		$text['pedbox'] = "Kassi";
		//changed in 6.0.0
		$text['regformat'] = "skr�ningar sni�";
		$text['extrasexpl'] = "Ef a� lj�smyndir e�a s�gur eru til um vi�komandi einstakling, koma vi�eigandi myndir n�st vi� n�fnin.";
		//added in 6.0.0
		$text['popupnote3'] = " = N�tt ";
		$text['mediaavail'] = "Margmi�lun tilt�k";
		//changed in 7.0.0
		$text['pedigreefor'] = "Ni�jatal fyrir";
		//added in 7.0.0
		$text['pedigreech'] = "Pedigree Chart";
		$text['datesloc'] = "Dates and Locations";
		$text['borchr'] = "Birth/Alt - Death/Burial (two)";
		$text['nobd'] = "No Birth or Death Dates";
		$text['bcdb'] = "Birth/Alt/Death/Burial (four)";
		$text['numsys'] = "Numbering System";
		$text['gennums'] = "Generation Numbers";
		$text['henrynums'] = "Henry Numbers";
		$text['abovnums'] = "d'Aboville Numbers";
		$text['devnums'] = "de Villiers Numbers";
		$text['dispopts'] = "Display Options";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "Engar sk�rslur til.";
		$text['reportname'] = "Nafn sk�rslu";
		$text['allreports'] = "Allar sk�rslur";
		$text['report'] = "Sk�rslur";
		$text['error'] = "Villa";
		$text['reportsyntax'] = "Eitthva� vi� �essa fyrirspurn";
		$text['wasincorrect'] = "var rangt, og g�tum vi� ekki s�� sk�rsluna. vinsemlagast hafi� samband vi� vefstj�ra �";
		$text['query'] = "Fyrirspurn";
		$text['errormessage'] = "Villu bo�";
		$text['equals'] = "Samanstendur af";
		$text['contains'] = "inniheldur";
		$text['startswith'] = "Byrjar �";
		$text['endswith'] = "endar �";
		$text['soundexof'] = "soundex of";
		$text['metaphoneof'] = "metaphone of";
		$text['plusminus10'] = "+/- 10 �rum fr�";
		$text['lessthan'] = "minna en";
		$text['greaterthan'] = "meira en";
		$text['lessthanequal'] = "minna en e�a jafnt og";
		$text['greaterthanequal'] = "meira en e�a jafnt og";
		$text['equalto'] = "Jafnt og";
		$text['tryagain'] = "Vinsamlegast reyndu aftur";
		$text['text_for'] = "fyrir";
		$text['searchnames'] = "Leita a� n�fnum";
		$text['joinwith'] = "Sameina me�";
		$text['cap_and'] = "og";
		$text['cap_or'] = "e�a";
		$text['showspouse'] = "S�na maka (S�nir alla ef fleirri en einn)";
		$text['submitquery'] = "S�kja sk�rslu";
		$text['birthplace'] = "F��ingarsta�ur";
		$text['deathplace'] = "D�narsta�ur";
		$text['birthdatetr'] = "F��ingar�r";
		$text['deathdatetr'] = "D�nar�r";
		$text['plusminus2'] = "+/- 2 �r fr�";
		$text['resetall'] = "Hreinsa �ll gildi";

		$text['showdeath'] = "S�na d�nar/grafar uppl�singar";
		$text['altbirthplace'] = "Sk�rnar sta�ur";
		$text['altbirthdatetr'] = "Sk�rnar �r";
		$text['burialplace'] = "Sta�setning grafreits";
		$text['burialdatetr'] = "Grefturnar�r";
		$text['event'] = "Vi�bur�ir";
		$text['day'] = "Dagur";
		$text['month'] = "M�nu�ur";
		$text['keyword'] = "Lykil or� (t.d, \"Abt\")";
		$text['explain'] = "Sl��u inn dagsetningu til a� sj� vi�bur�i �ann �aag, skyldu eftir autt til a� sj� allt.";
		$text['enterdate'] = "Vinsamlegast sl��u inn e�a veldu a� minnsta kosti eitt af eftirfarandi: Dagur, M�nu�ur, �r, Lykil or�";
		$text['fullname'] = "Fullt nafn";
		$text['birthdate'] = "F��ingar dagsetning";
		$text['altbirthdate'] = "Sk�rnar dagsetning";
		$text['marrdate'] = "Giftingar dagsetning";
		$text['spouseid'] = "maka ID";
		$text['spousename'] = "Nafn Maka";
		$text['deathdate'] = "Dags l�tin";
		$text['burialdate'] = "Dagsetning greftrunar";
		$text['changedate'] = "S��ast breytt dagsetning";
		$text['gedcom'] = "Tr�";
		$text['baptdate'] = "Fermdur dags (LDS)";
		$text['baptplace'] = "Fermingar sta�ur (LDS)";
		$text['endldate'] = "Endowment Date (LDS)";
		$text['endlplace'] = "Endowment Place (LDS)";
		$text['ssealdate'] = "Seal Date S (LDS)";
		$text['ssealplace'] = "Seal Place S (LDS)";
		$text['psealdate'] = "Seal Date P (LDS)";
		$text['psealplace'] = "Seal Place P (LDS)";
		$text['marrplace'] = "Sta�setning br��kaups";
		$text['spousesurname'] = "F��urnafn maka";
		//changed in 6.0.0
		$text['spousemore'] = "Ef �� sl�r� in f��urnafn maka ver�ur �� a� minnsta kosti a� sl� inn � einn annan reit hj� honum.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 �r fr�";
		$text['exists'] = "�egar til";
		$text['dnexist'] = "ekki til";
		//added in 6.0.3
		$text['divdate'] = "Dagsetning skilna�ar";
		$text['divplace'] = "Sta�setning skilna�ar";
		//changed in 7.0.0
		$text['otherevents'] = "A�rir vi�bur�ir";
		//added in 7.0.0
		$text['numresults'] = "Results per page";
		$text['mysphoto'] = "Mystery Photos";
		$text['mysperson'] = "Elusive People";
		$text['joinor'] = "The 'Join with OR' option cannot be used with Spouse's Last Name";
		//added in 7.0.1
		$text['tellus'] = "Tell us what you know";
		$text['moreinfo'] = "More Information:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "loggar fyrir";
		$text['mostrecentactions'] = "N�legustu a�ger�ir";
		$text['autorefresh'] = "Sj�lfvirk endurn�jun �  (30 sek�ndu fresti)";
		$text['refreshoff'] = "S�kkva � sj�lfvirk endurn�jun";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Kirkjugar�ar og legsteinar";
		$text['showallhsr'] = "S�na yfirlit yfir allat";
		$text['in'] = "inn";
		$text['showmap'] = "S�na kort";
		$text['headstonefor'] = "legsteinn fyrir";
		$text['photoof'] = "Lj�smynd af";
		$text['firstpage'] = "Fyrsta s��a";
		$text['lastpage'] = "S��asta s��a";
		$text['photoowner'] = "eigandi/Spretta";

		$text['nocemetery'] = "engin grafreytur";
		$text['iptc005'] = "Titill";
		$text['iptc020'] = "stu�n. Flokkar";
		$text['iptc040'] = "S�rstakar lei�beningar";
		$text['iptc055'] = "Skapa� dags";
		$text['iptc080'] = "H�fundur";
		$text['iptc085'] = "Sta�setning h�fundar";
		$text['iptc090'] = "Borg";
		$text['iptc095'] = "R�ki";
		$text['iptc101'] = "Land";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Fyrirs�gn";
		$text['iptc110'] = "spretta";
		$text['iptc115'] = "Lj�smyndaspretta";
		$text['iptc116'] = "H�fundarr�ttur";
		$text['iptc120'] = "Mynd af";
		$text['iptc122'] = "mynda ger� af";
		$text['mapof'] = "kort af";
		$text['regphotos'] = "L�sandi vi�m�t";
		$text['gallery'] = "Sj� bara �umalmyndir";
		$text['cemphotos'] = "Myndir af kirkjug�r�um";
		//changed in 6.0.0
		$text['photosize'] = "St�r�";
		//added in 6.0.0
        	$text['iptc010'] = "Priority";
		$text['filesize'] = "skr�arst�r�";
		$text['seeloc'] = "sj� sta�setningu";
		$text['showall'] = "S�na allr";
		$text['editmedia'] = "Breyta margmi�lun";
		$text['viewitem'] = "Sko�a �ennan hlut";
		$text['editcem'] = "Breyta grafreit";
		$text['numitems'] = "# Hlutir";
		$text['allalbums'] = "�ll alb�m";
		//added in 6.1.0
		$text['slidestart'] = "Hefja myndas�ningu";
		$text['slidestop'] = "Stoppa myndas�ningu";
		$text['slideresume'] = "Setja myndas�ningu af sta�";
		$text['slidesecs'] = "sek�ndur fyrir hverja mynd:";
		$text['minussecs'] = "m�nus 0.5 sek�ndur";
		$text['plussecs'] = "pl�s 0.5 sek�ndur";
		//added in 7.0.0
		$text['nocountry'] = "Unknown country";
		$text['nostate'] = "Unknown state";
		$text['nocounty'] = "Unknown county";
		$text['nocity'] = "Unknown city";
		$text['nocemname'] = "Unknown cemetery name";
		$text['plot'] = "Plot";
		$text['location'] = "Location";
		$text['editalbum'] = "Edit Album";
		$text['mediamaptext'] = "<strong>Note:</strong> Move your mouse pointer over the image to show names. Click to see a page for each name.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "S�na f��urn�fn sem byrja �";
		$text['showtop'] = "S�na efsta";
		$text['showallsurnames'] = "S�na �ll f��urn�fn";
		$text['sortedalpha'] = "� stafr�fsr��";
		$text['byoccurrence'] = "eftir fj�lda";
		$text['firstchars'] = "Fyrstu stafina";
		$text['top'] = "Efst";
		$text['mainsurnamepage'] = "A�al f��urnafna s��an";
		$text['allsurnames'] = "�ll f��urn�fn";
		$text['showmatchingsurnames'] = "Smelltu � f��urnafn til a� sj� fleirri.";
		$text['backtotop'] = "Aftur efst";
		$text['beginswith'] = "Byrjar �";
		$text['allbeginningwith'] = "�ll sem byrja �";
		$text['numoccurrences'] = "fj�ldi � foreldrart�lu";
		$text['placesstarting'] = "S�na sta�i sem byrja �";
		$text['showmatchingplaces'] = "smelltu � nafn til a� sko�a.";
		$text['totalnames'] = "heildar n�fn";
		$text['showallplaces'] = "S�na st�rstu sta�ina";
		$text['totalplaces'] = "samtals sta�ir";
		$text['mainplacepage'] = "A�al sta�ir s��a";
		$text['allplaces'] = "�ll st�rstu umhverfin";
		$text['placescont'] = "S�na alla sta�i sem innihalda";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(S��ust xx daga)";
		$text['historiesdocs'] = "Saga &<br>Skj�l";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Lj�smynd";
		$text['history'] = "Saga/Skal";
		//changed in 7.0.0
		$text['husbid'] = "Eiginmanns ID";
		$text['husbname'] = "Eiginmanns Nafn";
		$text['wifeid'] = "Eiginkonu ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Ey�a";
		$text['addperson'] = "B�ta pers�nu vi�";
		$text['nobirth'] = "�essi einstaklingur hefur ekki gildan f��ingardag og var �v� ekki h�gt a� b�ta honum vi�";
		$text['noliving'] = "�essi einstaklingur er merktur � l�fi og var �v� ekki h�gt a� b�ta honum vi� �v� �� ert ekki m� r�ttindi til �ess";
		$text['event'] = "Vi�bur�ir";
		$text['chartwidth'] = "Graf breydd";
		//changed in 6.0.0
		$text['timelineinstr'] = "b�ttu allt a� fj�rum fleirri einstaklingum me� �v� a� sl� inn einstaklingsn�meri� �eirra h�r fyrir ne�an:";
		//added in 6.0.0
		$text['togglelines'] = "Kveikja � l�num";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Sko�a �ll tr�";
		$text['treename'] = "Nafn tr�s";
		$text['owner'] = "Eigandi";
		$text['address'] = "Heimilisfang";
		$text['city'] = "Borg";
		$text['state'] = "S�sla";
		$text['zip'] = "P�stn�mer";
		$text['country'] = "Land";
		$text['email'] = "T�lvup�stfang";
		$text['phone'] = "S�mi";
		$text['username'] = "Notendanafn";
		$text['password'] = "Lykilor�";
		$text['loginfailed'] = "Innskr�ning mist�kst.";

		$text['regnewacct'] = "Skr��u �ig svo �� f�ir notenda a�gang";
		$text['realname'] = "Nafni� �itt";
		$text['phone'] = "S�mi";
		$text['email'] = "T�lvup�stfang";
		$text['address'] = "Heimilisfang";
		$text['comments'] = "Skilabo� e�a athugasemdir";
		$text['submit'] = "Senda";
		$text['leaveblank'] = "(haf�u autt ef �ska� er eftir n�ju treei)";
		$text['required'] = "Ver�ur a� fylla �t � reiti merkta �essu";
		$text['enterpassword'] = "Sl��u inn lykilor�.";
		$text['enterusername'] = "Sl��u inn notendanafn.";
		$text['failure'] = "�v� mi�ur er notendanafni� sem �� valdir upteki�. vinsamlegat nota�u back takkan til a� velja ��r n�tt notendanafn.";
		$text['success'] = "Takk fyrir. Skr�ningin ��n hefur veri� m�ttekin. �� ver�ur l�tin vita �egar a�gangur �inn er or�in virkur e�a meiri uppl�singar vantar.";
		$text['emailsubject'] = "N�r a�gangur � ny�jatals��una hefur veri� �ska�";
		$text['emailmsg'] = "�a� hefur borist ��r p�stur um a�gang a� ny�jatals s��unni. vinsamlegast skr��u �ig inn � kerfis hluta s��unar og gef�u notenda r�ttindi til a� taka ��tt � a� vi�halda s��unni. Ef �� notandi er � lagi vinsamlegast l�ttu hann vita me� �v� a� svara p�stinum hanns.";
		//changed in 5.0.0
		$text['enteremail'] = "Vinsamlegast sl��u inn t�lvup�stfang.";
		$text['website'] = "Vefs��a";
		$text['nologin'] = "�tti ekki notendanafn?";
		$text['loginsent'] = "Uppl�singar sendar";
		$text['loginnotsent'] = "A�gangs uppl�singar ekki sendar";
		$text['enterrealname'] = "Sl��u inn nafni� �itt.";
		$text['rempass'] = "Vera alltaf skr��ur � �essari t�lvu";
		$text['morestats'] = "Meiri t�lfr��i";
		//added in 6.0.0
		$text['accmail'] = "<strong>ATH:</strong> Til a� f� p�st fr� Vefstj�ra var�andi a�ganginn �inn vertu viss um a� �a� �se ekki veri� a� �tiloka p�st fr� �essu l�ni.";
		$text['newpassword'] = "N�tt lykilor�";
		$text['resetpass'] = "Breyta lykilor�i";
		//added in 6.1.0
		$text['nousers'] = "This form cannot be used until at least one user record exists. If you are the site owner, please go to Admin/Users to create your Administrator account.";
		//added in 7.0.0
		$text['noregs'] = "We're sorry, but we are not accepting new user registrations at this time. Please <a href=\"suggest.php\">contact us</a> directly if you have comments or questions regarding anything on this site.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Fj�ldi";
		$text['totindividuals'] = "Samtals einstaklingar";
		$text['totmales'] = "Samtals karlmenn";
		$text['totfemales'] = "Samtals kvenmenn";
		$text['totunknown'] = "Samtals ��ekkt kyn";
		$text['totliving'] = "Samtals lifandi";
		$text['totfamilies'] = "Samtals fj�lskyldur";
		$text['totuniquesn'] = "Samtals Fj�ldi F��urnafna";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Samtals heimildir";
		$text['avglifespan'] = "Me�al l�fst�mi";
		$text['earliestbirth'] = "Yngsta f��inginn";
		$text['longestlived'] = "Elsti aldurinn";
		$text['years'] = "�r";
		$text['days'] = "dagar";
		$text['age'] = "Aldur";
		$text['agedisclaimer'] = "Aldurs-tengdir �treikningar eru bygg�ir � einstaklingum me� skr��ar dagsetningar vegna fj�lda �skr��ra dagsetninga er �etta ekki allveg 100 pr�sent n�kv�mt.";
		$text['treedetail'] = "Meiri uppl�singar um �etta tr�";
		//added in 6.0.0
		$text['total'] = "Samtals";
		break;

	case "notes":
		$text['browseallnotes'] = "Fl�tta � �llum athugasemdum";
		break;

	case "help":
		$text['menuhelp'] = "Valmynd";
		break;

	case "install":
		$text['perms'] = "Permissions have all been set.";
		$text['noperms'] = "Permissions could not be set for these files:";
		$text['manual'] = "Please set them manually.";
		$text['folder'] = "Folder";
		$text['created'] = "has been created";
		$text['nocreate'] = "could not be created. Please create it manually.";
		$text['infosaved'] = "Information saved, connection verified!";
		$text['tablescr'] = "The tables have been created!";
		$text['notables'] = "The following tables could not be created:";
		$text['nocomm'] = "TNG is not communicating with your database. No tables were created.";
		$text['newdb'] = "Information saved, connection verified, new database created:";
		$text['noattach'] = "Information saved. Connection made and database created, but TNG cannot attach to it.";
		$text['nodb'] = "Information saved. Connection made, but database does not exist and could not be created here. Please verify that the database name is correct, or use your control panel to create it.";
		$text['noconn'] = "Information saved but connection failed. One or more of the following is incorrect:";
		$text['exists'] = "�egar til";
		$text['loginfirst'] = "You must log in first.";
		$text['noop'] = "No operation was performed.";
		break;
}

//common
$text['matches'] = "Passar";
$text['description'] = "L�sing";
$text['notes'] = "Athugasemdir";
$text['status'] = "Sta�a";
$text['newsearch'] = "N� leit";
$text['pedigree'] = "Ni�jatal";
$text['birthabbr'] = "f.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Sj� mynd";
$text['andlocation'] = "& sta�setning";
$text['accessedby'] = "Sko�a� af";
$text['go'] = "Fara af sta�";
$text['family'] = "Fj�lskylda";
$text['children'] = "B�rn";
$text['tree'] = "Tr�";
$text['alltrees'] = "�ll tr�";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "�umalmynd";
$text['people'] = "F�lk";
$text['title'] = "Titill";
$text['suffix'] = "Fornafn";
$text['nickname'] = "Kalla�ur/k�llu�";
$text['deathabbr'] = "L.";
$text['lastmodified'] = "S��ast Breytt";
$text['married'] = "Gift/ur";
//$text['photos'] = "Photos";
$text['name'] = "Nafn";
$text['lastfirst'] = "F��urnafn, Sk�rnanafn(s)";
$text['bornchr'] = "F�ddur/Sk�r�/ur";
$text['individuals'] = "Einstaklingar";
$text['families'] = "Fj�lskyldur";
$text['personid'] = "Pers�nu ID";
$text['sources'] = "Heimildir";
$text['unknown'] = "�sk�r�/ur";
$text['father'] = "Fa�ir";
$text['mother'] = "M��ir";
$text['born'] = "F�dd/ur";
$text['christened'] = "Sk�r�/ur";
$text['died'] = "L�tinn";
$text['buried'] = "Grafin";
$text['spouse'] = "Maki";
$text['parents'] = "Foreldrar";
$text['text'] = "Texti";
$text['language'] = "Tungum�l";
$text['burialabbr'] = "graf.";
$text['descendchart'] = "Afkomendur";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Einstaklingur";
$text['edit'] = "Breyta";
$text['date'] = "Dags";
$text['place'] = "Sta�ur";
$text['login'] = "Innskr�ning";
$text['logout'] = "Skr� sig �t";
$text['marrabbr'] = "G.";
$text['groupsheet'] = "H�p Skr�";
$text['text_and'] = "og";
$text['generation'] = "Kynsl��";
$text['filename'] = "Skr�arnafn";
$text['id'] = "ID";
$text['search'] = "Leita";
$text['living'] = "Lifandi";
$text['user'] = "Notandi";
$text['firstname'] = "Nafn";
$text['lastname'] = "F��urnafn";
$text['searchresults'] = "Leitarni�urst��ur";
$text['diedburied'] = "l�tin/Grefin";
$text['homepage'] = "A�als��a";
$text['find'] = "Finna...";
$text['relationship'] = "Skyldleiki";
$text['relationship2'] = "Relationship";
$text['timeline'] = "T�mal�na";
$text['yesabbr'] = "J";
$text['divorced'] = "Skilin";
$text['indlinked'] = "Tengist vi�";
$text['branch'] = "Grein";
$text['moreind'] = "Fleirri einstaklingar";
$text['morefam'] = "Fleirri fj�lskyldur";
$text['livingdoc'] = "A� minnsta kosti einn einstaklingur � �essu skjali er lifandi - uppl�singar ekki gefnar upp..";
$text['source'] = "Heimildir";
$text['surnamelist'] = "F��urnafna listi";
$text['generations'] = "Kynsl��ir";
$text['refresh'] = "Endurhla�a";
$text['whatsnew'] = "N�tt";
$text['reports'] = "Sk�rslur";
$text['placelist'] = "Sta�a listi";
$text['baptizedlds'] = "Sk�r�ur (LDS)";
$text['endowedlds'] = "Fermdur (LDS)";
$text['sealedplds'] = "Sealed P (LDS)";
$text['sealedslds'] = "Sealed S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "forfe�ur";
$text['descendants'] = "afkomendur";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "dags s��ast GEDCOM innflutt";
$text['type'] = "t�pa";
$text['savechanges'] = "Breytingar vista�ar";
$text['familyid'] = "Fj�lskyldu ID";
$text['headstone'] = "Legsteinn(ar)";
$text['historiesdocs'] = "Saga &<br>Skj�l";
$text['livingnote'] = "Lifandi einstaklingur - N�nari uppl�singar faldar";
$text['anonymous'] = "�nefndur";
$text['places'] = "Sta�ir";
$text['anniversaries'] = "Dagsetningar og merkisatbur�ir";
$text['administration'] = "Vefstj�rn";
$text['help'] = "Hj�lp";
//$text['documents'] = "Documents";
$text['year'] = "�r";
$text['all'] = "All";
$text['repository'] = "Greftrunarsta�ur";
$text['address'] = "Heimilisfang";
$text['suggest'] = "Suggest";
$text['editevent'] = "Suggest a change for this event";
$text['findplaces'] = "Find all individuals with events at this location";
$text['morelinks'] = "More Links";
$text['faminfo'] = "Family Information";
$text['persinfo'] = "Personal Information";
$text['srcinfo'] = "Source Information";
$text['fact'] = "Sta�reind";
$text['goto'] = "Velja s��u";
$text['tngprint'] = "Prenta";
//changed in 6.0.0
$text['livingphoto'] = "A� minnstakosti einn einstaklingur � �essari mynd er lifandi - uppl�singar um mynd ekki gefnar upp.";
$text['databasestatistics'] = "T�lfr��i gagnagrunns";
//moved here in 6.0.0
$text['child'] = "Barn";
$text['repoinfo'] = "Uppl�singur um greftrunarsta�i";
$text['tng_reset'] = "Hreinsa";
$text['noresults'] = "engar ni�urst��ur fundust";
//added in 6.0.0
$text['allmedia'] = "�ll margmi�lun";
$text['repositories'] = "Repositories";
$text['albums'] = "Alb�m";
$text['cemeteries'] = "Grafreitir";
$text['surnames'] = "Eftirn�fn";
$text['dates'] = "Dagsetningar";
$text['link'] = "Tengill";
$text['media'] = "Margmi�lun";
$text['gender'] = "Kyn";
$text['latitude'] = "Breiddargr��a";
$text['longitude'] = "Lengdargr��a";
$text['bookmarks'] = "B�kamerki";
$text['bookmark'] = "B�ta vi� b�kamerki";
$text['mngbookmarks'] = "Fara � b�karmerki";
$text['bookmarked'] = "B�kamerki b�tt vi�";
$text['remove'] = "Fjarl�gja";
$text['find_menu'] = "Finna";
$text['info'] = "Uppl";
//moved here in 6.0.3
$text['cemetery'] = "Kirkjugar�ur";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Vi�bur�a kort";
$text['gevents'] = "Vi�bur�ir";
$text['glang'] = "&amp;hl=is";
$text['googleearthlink'] = "Linkur � Google Earth";
$text['googlemaplink'] = "Linkur til Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "�merkt";
$text['located'] = "Sta�setning";
//added in 7.0.0
$text['albclicksee'] = "Smelltu til a� sj� alla hluti � �essu alb�mi";
$text['notyetlocated'] = "ekki fundinn enn";
$text['cremated'] = "Brenndur";
$text['missing'] = "Sakna�";
$text['page'] = "S��a";
$text['pdfgen'] = "PDF Generator";
$text['blank'] = "T�mt kort";
$text['none'] = "Ekkert";
$text['fonts'] = "Letur";
$text['header'] = "Haus";
$text['data'] = "Uppl�singar";
$text['pgsetup'] = "S��u uppsetning";
$text['pgsize'] = "S��u St�r�";
$text['letter'] = "Br�f";
$text['legal'] = "L�glegt";
$text['orient'] = "Sn�ningur";
$text['portrait'] = "Portrait";
$text['landscape'] = "Landscape";
$text['tmargin'] = "Efri sp�ss�a";
$text['bmargin'] = "Ne�ri Sp�ss�a";
$text['lmargin'] = "Vinstri sp�ss�a";
$text['rmargin'] = "H�gri sp�ss�a";
$text['createch'] = "B�a til kort";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Vantar mest";
$text['latupdates'] = "S��ustu uppf�rslur";
$text['featphoto'] = "Myndir af handah�fi";
$text['news'] = "Fr�ttir";
$text['ourhist'] = "Fj�lskyldu saga okkar";
$text['ourhistanc'] = "Fj�lskyldusaga okkar og afkomendur";
$text['ourpages'] = "Fj�lskyldu ny�jatal";
$text['pwrdby'] = "�essi s��a er �nnu� af";
$text['writby'] = "Skrifu� af";
$text['searchtngnet'] = "Leita � TNG S��unum (GENDEX)";
$text['viewphotos'] = "Sko�a allar myndir";
$text['anon'] = "�� ert ekki skr��ur undir nafni";
$text['whichbranch'] = "Hva�a grein kemur �� fr�?";
$text['featarts'] = "Grein af hand�fi";
$text['maintby'] = "Umsj�n s��u";
$text['createdon'] = "B�inn til af";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Vefs��a";
$text['mnusearchfornames'] = "Leita eftir nafni";
$text['mnulastname'] = "F��urnafn";
$text['mnufirstname'] = "Sk�rnarnafn";
$text['mnusearch'] = "Leita";
$text['mnureset'] = "Byrja upp � n�tt";
$text['mnulogon'] = "Innskr�";
$text['mnulogout'] = "�tskr�";
$text['mnufeatures'] = "A�rir kostir";
$text['mnuregister'] = "Skr�ning fyrir notenda a�gang";
$text['mnuadvancedsearch'] = "N�nari leit";
$text['mnulastnames'] = "F��urn�fn";
$text['mnustatistics'] = "T�lfr��i";
$text['mnuphotos'] = "Myndir";
$text['mnuhistories'] = "S�gur";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Grafreitir";
$text['mnutombstones'] = "Legsteinar";
$text['mnureports'] = "Sk�rslur";
$text['mnusources'] = "Heimildir";
$text['mnuwhatsnew'] = "Hva� er n�tt";
$text['mnushowlog'] = "Loggar";
$text['mnulanguage'] = "Breyta tungum�li";
$text['mnuadmin'] = "Vefstj�rn";
$text['welcome'] = "Velkominn";
$text['contactus'] = "Haf�u samband vi� okkur";

global $rootpath;
@include_once("captcha_text.php");
if($rootpath) {
	$thislanguage = $mylanguage ? $mylanguage : $language;
	if($cms[support])
		include_once("$rootpath$cms[tngpath]$thislanguage/alltext.php");
	else
		include_once("$rootpath$thislanguage/alltext.php");
}
else
	include_once("alltext.php");
?>
