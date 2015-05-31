<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "L�hdeaineistot";
		$text['shorttitle'] = "Lyhyt nimike";
		$text['callnum'] = "Paikkamerkki";
		$text['author'] = "Kirjoittaja";
		$text['publisher'] = "Julkaisija";
		$text['other'] = "Muut tiedot";
		$text['sourceid'] = "L�hteen ID-numero";
		$text['moresrc'] = "Lis�� l�hteit�";
		$text['repoid'] = "Tietovaraston ID-numero";
		$text['browseallrepos'] = "Selaa kaikki tietovarastot";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Uusi kieli";
		$text['changelanguage'] = "Vaihda kielt�";
		$text['languagesaved'] = "Kieli vaihdettu";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM alkaen t�st�";
		$text['producegedfrom'] = "Sis�llyt� tiedostoon";
		$text['numgens'] = "Sukupolvien lukum��r�";
		$text['includelds'] = "Sis�llyt� LDS-tiedot";
		$text['buildged'] = "Luo GEDCOM";
		$text['gedstartfrom'] = "GEDCOM alkaen";
		$text['nomaxgen'] = "Sukupolvien enimm�ism��r�tieto puuttuu. K�yt� selaimen takaisin-painiketta palataksesi edelliselle sivulle ja t�yt� kentt�.";
		$text['gedcreatedfrom'] = "GEDCOM luotu alkaen";
		$text['gedcreatedfor'] = "k�ytt�j�lle";

		$text['enteremail'] = "Anna oikean muotoinen s�hk�postiosoite";
		$text['creategedfor'] = "Luo GEDCOM-tiedosto";
		$text['email'] = "S�hk�posti";
		$text['suggestchange'] = "Ehdota muutospyynt��";
		$text['yourname'] = "Nimesi";
		$text['comments'] = "Kommentit";
		$text['comments2'] = "Kommentit";
		$text['submitsugg'] = "L�het� muutospyynt�";
		$text['proposed'] = "Ehdotettu muutospyynt�";
		$text['mailsent'] = "Kiitos, viestisi on l�hetetty.";
		$text['mailnotsent'] = "Virhe. Pahoittelemme, mutta viesti�si ei voitu toimittaa. Ota yhteys henkil��n xxx osoitteessa yyy.";
		$text['mailme'] = "L�het� kopio t�h�n osoitteeseen.";
		//added in 5.0.5
		$text['entername'] = "Please enter your name";
		$text['entercomments'] = "Please enter your comments";
		$text['sendmsg'] = "Send Message";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Kuvat ja historiat";
		$text['indinfofor'] = "Henkil�tiedot:";
		$text['reliability'] = "Luotettavuus";
		$text['pp'] = "s.";
		$text['age'] = "Ik�";
		$text['agency'] = "Toimisto";
		$text['cause'] = "Syy";
		$text['suggested'] = "Ehdotettu";
		$text['closewindow'] = "Sulje ikkuna";
		$text['thanks'] = "Kiitos";
		$text['received'] = "L�hett�m�si muutospyynt� on vastaanotettu ja l�hetetty sivuston yll�pidolle.";
		//added in 6.0.0
		$text['association'] = "Association";
		//added in 7.0.0
		$text['indreport'] = "Individual Report";
		$text['indreportfor'] = "Individual Report for";
		$text['general'] = "General";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Sukulaisuuslaskuri";
		$text['findrel'] = "Etsi sukulaisuussuhdetta";
		$text['person1'] = "Henkil� 1:";
		$text['person2'] = "Henkil� 2:";
		$text['calculate'] = "Tee haku";
		$text['select2inds'] = "Ole hyv� ja valitse kaksi henkil��.";
		$text['findpersonid'] = "Etsi henkil�n ID";
		$text['enternamepart'] = "anna osa etu- ja/tai sukunimest�";
		$text['pleasenamepart'] = "Ole hyv� ja anna osa etu- ja/tai sukunimest�.";
		$text['clicktoselect'] = "valitse henkil� klikkaamalla linkki�";
		$text['nobirthinfo'] = "Ei syntym�tietoja";
		$text['relateto'] = "Sukulaisuussuhde henkil��n";
		$text['sameperson'] = "Valitsit molempiin kenttiin saman henkil�n!";
		$text['notrelated'] = "Henkil�ille ei l�ydy sukulaisuussuhdetta xxx sukupolven ajalta.";
		$text['findrelinstr'] = "Sukulaisuussuhteen selvitt�miseksi, anna kahden henkil�n ID-numerot, tai pid� henkil�t n�kyvill�. Klikkaa sitten �Selvit� selvitt��ksesi heid�n sukulaisuussuhteensa.";
		$text['gencheck'] = "Selvitett�vien<br />sukulaisuussuhteiden maksimim��r�";
		$text['sometimes'] = "(Sukupolvien eri m��r� voi joskus antaa eri tuloksen.)";
		$text['findanother'] = "Selvit� lis�� sukulaisuussuhteita.";
		//added in 6.0.0
		$text['brother'] = "the brother of";
		$text['sister'] = "the sister of";
		$text['sibling'] = "the sibling of";
		$text['uncle'] = "the xxx uncle of";
		$text['aunt'] = "the xxx aunt of";
		$text['uncleaunt'] = "the xxx uncle/aunt of";
		$text['nephew'] = "the xxx nephew of";
		$text['niece'] = "the xxx niece of";
		$text['nephnc'] = "the xxx newphew/niece of";
		$text['mcousin'] = "the xxx cousin of";
		$text['fcousin'] = "the xxx cousin of";
		$text['cousin'] = "the xxx cousin of";
		$text['removed'] = "times removed";
		$text['rhusband'] = "the husband of ";
		$text['rwife'] = "the wife of ";
		$text['rspouse'] = "the spouse of ";
		$text['son'] = "the son of";
		$text['daughter'] = "the daughter of";
		$text['rchild'] = "the child of";
		$text['sil'] = "the son-in-law of";
		$text['dil'] = "the daughter-in-law of";
		$text['sdil'] = "the son- or daughter-in-law of";
		$text['gson'] = "the xxx grandson of";
		$text['gdau'] = "the xxx granddaughter of";
		$text['gsondau'] = "the xxx grandson/granddaughter of";
		$text['great'] = "great";
		$text['spouses'] = "are spouses";
		$text['is'] = "is";
		//changed in 6.0.0
		$text['changeto'] = "Vaihda henkil�ksi:";
		//added in 6.0.0
		$text['notvalid'] = "is not a valid Person ID number or does not exist in this database. Please try again.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Perhetaulukko:";
		$text['ldsords'] = "LDS-tiedot";
		$text['baptizedlds'] = "Kastettu (LDS)";
		$text['endowedlds'] = "Lahja (LDS)";
		$text['sealedplds'] = "Sinet�ity P (LDS)";
		$text['sealedslds'] = "Sinet�ity S (LDS)";
		$text['otherspouse'] = "Toinen puoliso";
		//changed in 7.0.0
		$text['husband'] = "Aviomies";
		$text['wife'] = "Vaimo";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "s";
		$text['capaltbirthabbr'] = "(s)";
		$text['capdeathabbr'] = "k";
		$text['capburialabbr'] = "haud.";
		$text['capplaceabbr'] = "paikka";
		$text['capmarrabbr'] = "vih.";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "P�ivit�";
		$text['scrollnote'] = "Huomioi: Voit joutua vieritt�m��n sivua alas tai oikealle n�hd�ksesi koko kaavion.";
		$text['unknownlit'] = "Tuntematon";
		$text['popupnote1'] = " = Lis�tietoja";
		$text['popupnote2'] = " = Uusi sukupuu t�st� henkil�st� alkaen";
		$text['pedcompact'] = "Tiivis";
		$text['pedstandard'] = "Vakio";
		$text['pedtextonly'] = "Tekstimuoto";
		$text['descendfor'] = "J�lkel�iset:";
		$text['maxof'] = "N�ytet��n enint��n";
		$text['gensatonce'] = "sukupolvea kerrallaan, ";
		$text['sonof'] = "vanhemmat";
		$text['daughterof'] = "vanhemmat";
		$text['childof'] = "vanhemmat";
		$text['stdformat'] = "Vakiomuoto";

		$text['ahnentafel'] = "Esipolvitaulu";
		$text['addnewfam'] = "Add New Family";
		$text['editfam'] = "Edit Family";
		$text['side'] = "Side";
		$text['familyof'] = "Sukutiedot henkil�lle";
		$text['paternal'] = "Is�n suku";
		$text['maternal'] = "�idin suku";
		$text['gen1'] = "Henkil� itse";
		$text['gen2'] = "Vanhemmat";
		$text['gen3'] = "Isovanhemmat";
		$text['gen4'] = "Isovanhempien vanhemmat";
		$text['gen5'] = "Isovanhempien isovanhemmat";
		$text['gen6'] = "6. sukupolvi";
		$text['gen7'] = "7. sukupolvi";
		$text['gen8'] = "8. sukupolvi";
		$text['gen9'] = "9. sukupolvi";
		$text['gen10'] = "10. sukupolvi";
		$text['gen11'] = "11. sukupolvi";
		$text['gen12'] = "12. sukupolvi";
		$text['graphdesc'] = "J�lkipolvikartta t�h�n asti";
		$text['collapse'] = "Supista";
		$text['expand'] = "Laajenna";
		$text['pedbox'] = "Lokero";
		//changed in 6.0.0
		$text['regformat'] = "Rekisterimuoto";
		$text['extrasexpl'] = "Mik�li seuraavilla henkil�ill� on valokuvia tai el�m�kertoja, niiden kuvakkeet n�kyv�t nimen vieress�.";
		//added in 6.0.0
		$text['popupnote3'] = " = New chart";
		$text['mediaavail'] = "Media Available";
		//changed in 7.0.0
		$text['pedigreefor'] = "Sukutaulu:";
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
		$text['noreports'] = "Ei raportteja.";
		$text['reportname'] = "Raportin nimi";
		$text['allreports'] = "Raportit";
		$text['report'] = "Raportti";
		$text['error'] = "Virhe";
		$text['reportsyntax'] = "Raportin";
		$text['wasincorrect'] = "syntaksi oli virheellinen, mink� takia sit� ei voitu koostaa. Ota yhteys palvelun yll�pitoon:";
		$text['query'] = "Haku";
		$text['errormessage'] = "Virhe";
		$text['equals'] = "on";
		$text['contains'] = "sis�lt��";
		$text['startswith'] = "alkaa";
		$text['endswith'] = "loppuu";
		$text['soundexof'] = "soundex-haku";
		$text['metaphoneof'] = "metaphone-haku";
		$text['plusminus10'] = "+/- 10 vuotta alkaen";
		$text['lessthan'] = "v�hemm�n kuin";
		$text['greaterthan'] = "enemm�n kuin";
		$text['lessthanequal'] = "v�hemm�n tai yht� kuin";
		$text['greaterthanequal'] = "enemm�n tai yht� kuin";
		$text['equalto'] = "yht� kuin";
		$text['tryagain'] = "Yrit� uudelleen";
		$text['text_for'] = "haulle";
		$text['searchnames'] = "Henkil�haku";
		$text['joinwith'] = "Hakuoperaatio";
		$text['cap_and'] = "JA";
		$text['cap_or'] = "TAI";
		$text['showspouse'] = "N�yt� puolisot (mik�li useampi avioliitto)";
		$text['submitquery'] = "Etsi";
		$text['birthplace'] = "Syntym�paikka";
		$text['deathplace'] = "Kuolinpaikka";
		$text['birthdatetr'] = "Syntym�vuosi";
		$text['deathdatetr'] = "Kuolinvuosi";
		$text['plusminus2'] = "+/- 2 vuotta alkaen";
		$text['resetall'] = "Tyhjenn� kent�t";

		$text['showdeath'] = "N�yt� kuolin- ja hautatiedot";
		$text['altbirthplace'] = "Risti�ispaikka";
		$text['altbirthdatetr'] = "Risti�isvuosi";
		$text['burialplace'] = "Hautauspaikka";
		$text['burialdatetr'] = "Hautausvuosi";
		$text['event'] = "Tapahtuma(t)";
		$text['day'] = "P�iv�";
		$text['month'] = "Kuukausi";
		$text['keyword'] = "Avainsana";
		$text['explain'] = "Anna p�iv�m��r�t n�hd�ksesi tapahtumat, tai j�t� kent�t tyhjiksi n�hd�ksesi kaikki.";
		$text['enterdate'] = "Sy�t� ainakin yksi seuraavista avainsanoista: p�iv�, kuukausi, vuosi";
		$text['fullname'] = "Koko nimi";
		$text['birthdate'] = "Synnyinpaikka";
		$text['altbirthdate'] = "Risti�ispaikka";
		$text['marrdate'] = "H��p�iv�";
		$text['spouseid'] = "Puolison ID-numero";
		$text['spousename'] = "Puolison nimi";
		$text['deathdate'] = "Kuolinp�iv�";
		$text['burialdate'] = "Hautauspaikka";
		$text['changedate'] = "Viimeisimm�n muutoksen pvm";
		$text['gedcom'] = "Sukupuu";
		$text['baptdate'] = "Kastep�iv� (mormoni)";
		$text['baptplace'] = "Kastepaikka (mormoni)";
		$text['endldate'] = "Temppelipyhitysp�iv� (mormoni)";
		$text['endlplace'] = "Temppelipyhityspaikka (mormoni)";
		$text['ssealdate'] = "Puolison sinet�imisp�iv� (mormoni)";
		$text['ssealplace'] = "Puolison sinet�imispaikka (mormoni)";
		$text['psealdate'] = "Vanhempien sinet�imisp�iv� (mormoni)";
		$text['psealplace'] = "Vanhempien sinet�imispaikka (mormoni)";
		$text['marrplace'] = "Marriage Place";
		$text['spousesurname'] = "Spouse's Last Name";
		//changed in 6.0.0
		$text['spousemore'] = "If you enter a value for Spouse's Last Name, you must enter a value for at least one other field.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 years from";
		$text['exists'] = "exists";
		$text['dnexist'] = "does not exist";
		//added in 6.0.3
		$text['divdate'] = "Divorce Date";
		$text['divplace'] = "Divorce Place";
		//changed in 7.0.0
		$text['otherevents'] = "Muut tapahtumat";
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
		$text['logfilefor'] = "Tapahtumat:";
		$text['mostrecentactions'] = "viimeisint� tapahtumaa";
		$text['autorefresh'] = "P�ivit� sivu 30 sek. v�lein";
		$text['refreshoff'] = "Ei sivun autom. p�ivityst�";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Hautausmaat ja hautakivet";
		$text['showallhsr'] = "N�yt� kaikki hautakivitiedot";
		$text['in'] = "sijainnissa";
		$text['showmap'] = "N�yt� kartta";
		$text['headstonefor'] = "Hautakivi:";
		$text['photoof'] = "Valokuva:";
		$text['firstpage'] = "Ensimm�inen sivu";
		$text['lastpage'] = "Viimeinen sivu";
		$text['photoowner'] = "Omistaja/L�hde";

		$text['nocemetery'] = "Ei hautausmaata";
		$text['iptc005'] = "Otsikko";
		$text['iptc020'] = "Lis�kategoriat";
		$text['iptc040'] = "Erityisohjeet";
		$text['iptc055'] = "Luontip�iv�";
		$text['iptc080'] = "Kuvaaja";
		$text['iptc085'] = "Kuvaajan asema";
		$text['iptc090'] = "Kaupunki";
		$text['iptc095'] = "Osavaltio";
		$text['iptc101'] = "Maa";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Otsikko";
		$text['iptc110'] = "L�hde";
		$text['iptc115'] = "Valokuvan l�hde";
		$text['iptc116'] = "Tekij�noikeustiedot";
		$text['iptc120'] = "Kuvateksti";
		$text['iptc122'] = "Kuvatekstin kirjoittaja";
		$text['mapof'] = "Kartta:";
		$text['regphotos'] = "Selitysten mukaan";
		$text['gallery'] = "Vain pikkukuvat";
		$text['cemphotos'] = "Hautausmaan kuvat";
		//changed in 6.0.0
		$text['photosize'] = "Kuvan koko";
		//added in 6.0.0
        	$text['iptc010'] = "Priority";
		$text['filesize'] = "File Size";
		$text['seeloc'] = "See Location";
		$text['showall'] = "Show All";
		$text['editmedia'] = "Edit Media";
		$text['viewitem'] = "View this item";
		$text['editcem'] = "Edit Cemetery";
		$text['numitems'] = "# Items";
		$text['allalbums'] = "All Albums";
		//added in 6.1.0
		$text['slidestart'] = "Start Slide Show";
		$text['slidestop'] = "Pause Slide Show";
		$text['slideresume'] = "Resume Slide Show";
		$text['slidesecs'] = "Seconds for each slide:";
		$text['minussecs'] = "minus 0.5 seconds";
		$text['plussecs'] = "plus 0.5 seconds";
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
		$text['surnamesstarting'] = "N�yt� sukunimet jotka alkavat kirjaimella";
		$text['showtop'] = "Listaa";
		$text['showallsurnames'] = "N�yt� kaikki sukunimet";
		$text['sortedalpha'] = "aakkosj�rjestyksess�";
		$text['byoccurrence'] = "yleisint� sukunime�";
		$text['firstchars'] = "Alkukirjaimet";
		$text['top'] = "Yleisimm�t";
		$text['mainsurnamepage'] = "Sukunimien p��sivu";
		$text['allsurnames'] = "Kaikki sukunimet";
		$text['showmatchingsurnames'] = "Valitse sukunimi listataksesi henkil�t";
		$text['backtotop'] = "Sivun alkuun";
		$text['beginswith'] = "Alkukirjain";
		$text['allbeginningwith'] = "Sukunimet jotka alkavat kirjaimella";
		$text['numoccurrences'] = "lukum��r� suluissa";
		$text['placesstarting'] = "Show places starting with";
		$text['showmatchingplaces'] = "Click on a surname to show matching records.";
		$text['totalnames'] = "henkil�iden kokonaism��r�";
		$text['showallplaces'] = "N�yt� suurimmat paikallisryhm�t";
		$text['totalplaces'] = "paikkojen m��r�";
		$text['mainplacepage'] = "Paikkojen p��sivu";
		$text['allplaces'] = "Kaikki suurimmat paikallisryhm�t";
		$text['placescont'] = "N�yt� kaikki paikat, joissa esiintyy";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(xx p�iv�n ajalta)";
		$text['historiesdocs'] = "El�m�kerrat";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Valokuva";
		$text['history'] = "Historia/Dokumentti";
		//changed in 7.0.0
		$text['husbid'] = "Miehen ID";
		$text['husbname'] = "Miehen nimi";
		$text['wifeid'] = "Vaimon ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Poista";
		$text['addperson'] = "Lis�� henkil�";
		$text['nobirth'] = "Henkil�st� ei ole syntym�tietoja joten h�nt� ei voida lis�t�.";
		$text['noliving'] = "Elossa olevien henkil�iden lis��minen on sallittu vain kirjautuneille k�ytt�jille.";
		$text['event'] = "Tapahtuma(t)";
		$text['chartwidth'] = "Chart width";
		//changed in 6.0.0
		$text['timelineinstr'] = "Lis�� korkeintaan nelj� henkil�� sy�tt�m�ll� heid�n ID-numeronsa tai k�ytt�m�ll� nimihakua:";
		//added in 6.0.0
		$text['togglelines'] = "Toggle Lines";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Sukupuut";
		$text['treename'] = "Puun nimi";
		$text['owner'] = "Omistaja";
		$text['address'] = "Osoite";
		$text['city'] = "Paikkakunta";
		$text['state'] = "L��ni";
		$text['zip'] = "Postinumero";
		$text['country'] = "Maa";
		$text['email'] = "S�hk�posti";
		$text['phone'] = "Puhelinnumero";
		$text['username'] = "K�ytt�j�tunnus";
		$text['password'] = "Salasana";
		$text['loginfailed'] = "Virhe sis��nkirjautumisessa";

		$text['regnewacct'] = "Rekister�idy k�ytt�j�ksi";
		$text['realname'] = "Koko nimi";
		$text['phone'] = "Puhelinnumero";
		$text['email'] = "S�hk�posti";
		$text['address'] = "Osoite";
		$text['comments'] = "Kommentit";
		$text['submit'] = "L�het�";
		$text['leaveblank'] = "(j�t� tyhj�ksi jos haluat rekister�id� uuden sukupuun)";
		$text['required'] = "Pakolliset kent�t";
		$text['enterpassword'] = "Ole hyv� ja t�yt� salasanakentt�.";
		$text['enterusername'] = "Ole hyv� ja t�yt� k�ytt�j�tunnuskentt�.";
		$text['failure'] = "Valitsemasi k�ytt�j�tunnus on jo k�yt�ss�. Palaa edelliselle sivulle ja valitse toinen k�ytt�j�tunnus.";
		$text['success'] = "Kiitos rekister�itymisest�si. Ilmoitamme sinulle kun tunnuksesi on aktivoitu.";
		$text['emailsubject'] = "TNG-rekister�itymispyynt�";
		$text['emailmsg'] = "Sinulle on saapunut uusi TNG-rekister�itymispyynt�. Kirjaudu sis��n TNG:n hallintaliittym��n ja anna uudelle k�ytt�j�lle sopivat k�ytt�oikeudet. Jos hyv�ksyt rekister�itymisen, ole hyv� ja vastaa t�h�n viestiin ilmoittaaksesi asiasta k�ytt�j�lle.";
		//changed in 5.0.0
		$text['enteremail'] = "Anna oikean muotoinen s�hk�postiosoite";
		$text['website'] = "Kotisivu";
		$text['nologin'] = "Puuttuuko sinulta tunnukset?";
		$text['loginsent'] = "Tunnustiedot l�hetetty";
		$text['loginnotsent'] = "Tunnustietoja ei l�htetetty";
		$text['enterrealname'] = "Anna oikea nimesi.";
		$text['rempass'] = "Pysy sis��nkirjautuneen� t�ll� tietokoneella";
		$text['morestats'] = "Lis�� tilastoja";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTE:</strong> In order to receive mail from the site administrator regarding your account, please make sure that you are not blocking mail from this domain.";
		$text['newpassword'] = "New Password";
		$text['resetpass'] = "Reset your password";
		//added in 6.1.0
		$text['nousers'] = "This form cannot be used until at least one user record exists. If you are the site owner, please go to Admin/Users to create your Administrator account.";
		//added in 7.0.0
		$text['noregs'] = "We're sorry, but we are not accepting new user registrations at this time. Please <a href=\"suggest.php\">contact us</a> directly if you have comments or questions regarding anything on this site.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Arvo";
		$text['totindividuals'] = "Henkil�it�";
		$text['totmales'] = "Miehi�";
		$text['totfemales'] = "Naisia";
		$text['totunknown'] = "Sukupuoli tuntematon";
		$text['totliving'] = "Elossa";
		$text['totfamilies'] = "Perheit�";
		$text['totuniquesn'] = "Sukunimi�";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "L�hteit�";
		$text['avglifespan'] = "Keskim��r�inen elinik�";
		$text['earliestbirth'] = "Aikaisin syntym�vuosi";
		$text['longestlived'] = "Pitk�ik�isimm�t henkil�t";
		$text['years'] = "vuotta";
		$text['days'] = "p�iv��";
		$text['age'] = "Ik�";
		$text['agedisclaimer'] = "Ik��n liittyv�t laskelmat perustuvat henkil�ihin joista on tiedossa sek� synnyin- ett� kuolinaika. Puutteellisten aikatietojen (esim. syntym� kirjattu vain \"1945\" tai \"ennen 1860\") takia laskelmat eiv�t ole t�ysin tarkkoja.";
		$text['treedetail'] = "Sukupuun lis�tiedot";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Selaa kaikki muistiinpanot";
		break;

	case "help":
		$text['menuhelp'] = "Menuavain";
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
		$text['exists'] = "exists";
		$text['loginfirst'] = "You must log in first.";
		$text['noop'] = "No operation was performed.";
		break;
}

//common
$text['matches'] = "Tulokset";
$text['description'] = "Kuvaus";
$text['notes'] = "Muistiinpanot";
$text['status'] = "Tila";
$text['newsearch'] = "Haku";
$text['pedigree'] = "Sukutaulu";
$text['birthabbr'] = "s.";
$text['chrabbr'] = "kas.";
$text['seephoto'] = "Kts. valokuva";
$text['andlocation'] = "& sijainti";
$text['accessedby'] = "- k�vij�:";
$text['go'] = "Ok";
$text['family'] = "Perhe";
$text['children'] = "Lapset";
$text['tree'] = "Sukupuu";
$text['alltrees'] = "Sukupuut";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "Kuvake";
$text['people'] = "Henkil�t";
$text['title'] = "Nimike";
$text['suffix'] = "Loppuliite";
$text['nickname'] = "Kutsumanimi";
$text['deathabbr'] = "k.";
$text['lastmodified'] = "Viimeksi muutettu";
$text['married'] = "Vihitty";
//$text['photos'] = "Photos";
$text['name'] = "Nimi";
$text['lastfirst'] = "Sukunimi, Etunimet";
$text['bornchr'] = "Syntynyt/Kastettu";
$text['individuals'] = "Henkil�t";
$text['families'] = "Perheet";
$text['personid'] = "Henkil�n ID";
$text['sources'] = "L�hteet";
$text['unknown'] = "Tuntematon";
$text['father'] = "Is�";
$text['mother'] = "�iti";
$text['born'] = "Syntynyt";
$text['christened'] = "Kastettu";
$text['died'] = "Kuollut";
$text['buried'] = "Haudattu";
$text['spouse'] = "Puoliso";
$text['parents'] = "Vanhemmat";
$text['text'] = "Teksti";
$text['language'] = "Kieli";
$text['burialabbr'] = "haud.";
$text['descendchart'] = "J�lkel�iset";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Henkil�n tiedot";
$text['edit'] = "Muokkaa";
$text['date'] = "P�iv�ys";
$text['place'] = "Paikka";
$text['login'] = "Sis��nkirjautuminen";
$text['logout'] = "Kirjaudu ulos";
$text['marrabbr'] = "vih.";
$text['groupsheet'] = "Perhetaulukko";
$text['text_and'] = "ja";
$text['generation'] = "Sukupolvi";
$text['filename'] = "Tiedoston nimi";
$text['id'] = "ID";
$text['search'] = "Etsi";
$text['living'] = "Elossa";
$text['user'] = "K�ytt�j�";
$text['firstname'] = "Etunimi";
$text['lastname'] = "Sukunimi";
$text['searchresults'] = "Haun tulokset";
$text['diedburied'] = "Kuollut/Haudattu";
$text['homepage'] = "Etusivu";
$text['find'] = "Etsi...";
$text['relationship'] = "Sukulaisuus";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Aikajana";
$text['yesabbr'] = "K";
$text['divorced'] = "Eronnut";
$text['indlinked'] = "Liitetyt henkil�t";
$text['branch'] = "Haara";
$text['moreind'] = "More individuals";
$text['morefam'] = "More families";
$text['livingdoc'] = "Dokumenttiin liittyy ainakin yksi elossa oleva henkil� - Yksityiskohtia ei n�ytet�.";
$text['source'] = "L�hde";
$text['surnamelist'] = "Sukunimet";
$text['generations'] = "Sukupolvia";
$text['refresh'] = "P�ivit�";
$text['whatsnew'] = "Uusimmat tiedot";
$text['reports'] = "Raportit";
$text['placelist'] = "Place List";
$text['baptizedlds'] = "Kastettu (LDS)";
$text['endowedlds'] = "Lahja (LDS)";
$text['sealedplds'] = "Sinet�ity P (LDS)";
$text['sealedslds'] = "Sinet�ity S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "esi-is�t";
$text['descendants'] = "j�lkel�iset";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Viimeisin GEDCOM-tiedoston tuonti";
$text['type'] = "Tyyppi";
$text['savechanges'] = "Tallenna muutokset";
$text['familyid'] = "Perheen ID";
$text['headstone'] = "Hautakivet";
$text['historiesdocs'] = "El�m�kerrat";
$text['livingnote'] = "Ainakin yksi el�v� henkil� on linkitetty t�h�n muistiinpanoon � Yksityiskohtaisia tietoja ei n�ytet�.";
$text['anonymous'] = "nimet�n";
$text['places'] = "Paikat";
$text['anniversaries'] = "Juhlap�iv�t";
$text['administration'] = "Hallinta";
$text['help'] = "Apua";
//$text['documents'] = "Documents";
$text['year'] = "Vuosi";
$text['all'] = "Kaikki";
$text['repository'] = "Tietovarasto";
$text['address'] = "Osoite";
$text['suggest'] = "Pyynt�";
$text['editevent'] = "Tee muutospyynt� t�h�n tapahtumaan";
$text['findplaces'] = "Etsi kaikki henkil�t, joilla on merkitty tapahtuma t�ll� paikalla";
$text['morelinks'] = "Lis�� linkkej�";
$text['faminfo'] = "Perheen tiedot";
$text['persinfo'] = "Omat tiedot";
$text['srcinfo'] = "L�hteen tiedot";
$text['fact'] = "Fakta";
$text['goto'] = "Valitse sivu";
$text['tngprint'] = "Print";
//changed in 6.0.0
$text['livingphoto'] = "Kuvaan liittyy ainakin yksi elossa oleva henkil� - Yksityiskohtia ei n�ytet�.";
$text['databasestatistics'] = "Tilastotietoa tietokannasta";
//moved here in 6.0.0
$text['child'] = "Lapsi";
$text['repoinfo'] = "Tietovaraston tiedot";
$text['tng_reset'] = "Nollaa";
$text['noresults'] = "Hakua vastaavia henkil�it� ei l�ytynyt";
//added in 6.0.0
$text['allmedia'] = "All Media";
$text['repositories'] = "Repositories";
$text['albums'] = "Albums";
$text['cemeteries'] = "Cemeteries";
$text['surnames'] = "Surnames";
$text['dates'] = "Dates";
$text['link'] = "Link";
$text['media'] = "Media";
$text['gender'] = "Gender";
$text['latitude'] = "Latitude";
$text['longitude'] = "Longitude";
$text['bookmarks'] = "Bookmarks";
$text['bookmark'] = "Add Bookmark";
$text['mngbookmarks'] = "Go to Bookmarks";
$text['bookmarked'] = "Bookmark Added";
$text['remove'] = "Remove";
$text['find_menu'] = "Find";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Hautausmaa";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Event Map";
$text['gevents'] = "Event";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Link to Google Earth";
$text['googlemaplink'] = "Link to Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "Merkitsem�t�n";
$text['located'] = "Sijainti";
//added in 7.0.0
$text['albclicksee'] = "Click to see all the items in this album";
$text['notyetlocated'] = "Not yet located";
$text['cremated'] = "Cremated";
$text['missing'] = "Missing";
$text['page'] = "Page";
$text['pdfgen'] = "PDF Generator";
$text['blank'] = "Blank Chart";
$text['none'] = "None";
$text['fonts'] = "Fonts";
$text['header'] = "Header";
$text['data'] = "Data";
$text['pgsetup'] = "Page Setup";
$text['pgsize'] = "Page Size";
$text['letter'] = "Letter";
$text['legal'] = "Legal";
$text['orient'] = "Orientation";
$text['portrait'] = "Portrait";
$text['landscape'] = "Landscape";
$text['tmargin'] = "Top Margin";
$text['bmargin'] = "Bottom Margin";
$text['lmargin'] = "Left Margin";
$text['rmargin'] = "Right Margin";
$text['createch'] = "Create Chart";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Most Wanted";
$text['latupdates'] = "Latest Updates";
$text['featphoto'] = "Featured Photo";
$text['news'] = "News";
$text['ourhist'] = "Our Family History";
$text['ourhistanc'] = "Our Family History and Ancestry";
$text['ourpages'] = "Our Family Genealogy Pages";
$text['pwrdby'] = "This site powered by";
$text['writby'] = "written by";
$text['searchtngnet'] = "Search TNG Network (GENDEX)";
$text['viewphotos'] = "View all photos";
$text['anon'] = "You are currently anonymous";
$text['whichbranch'] = "Which branch are you from?";
$text['featarts'] = "Feature Articles";
$text['maintby'] = "Maintained by";
$text['createdon'] = "Created on";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Kotisivu";
$text['mnusearchfornames'] = "Etsi nimi�";
$text['mnulastname'] = "Sukunimi";
$text['mnufirstname'] = "Etunimi";
$text['mnusearch'] = "Etsi";
$text['mnureset'] = "Aloita alusta";
$text['mnulogon'] = "Kirjaudu sis��n";
$text['mnulogout'] = "Kirjaudu ulos";
$text['mnufeatures'] = "Muut ominaisuudet";
$text['mnuregister'] = "Hae k�ytt�j�tunnusta";
$text['mnuadvancedsearch'] = "Tarkennettu haku";
$text['mnulastnames'] = "Sukunimet";
$text['mnustatistics'] = "Tilastot";
$text['mnuphotos'] = "Valokuvat";
$text['mnuhistories'] = "El�m�kerrat";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Hautausmaat";
$text['mnutombstones'] = "Hautakivet";
$text['mnureports'] = "Raportit";
$text['mnusources'] = "L�hteet";
$text['mnuwhatsnew'] = "Uusimmat";
$text['mnushowlog'] = "Lokitiedot";
$text['mnulanguage'] = "Vaihda kielt�";
$text['mnuadmin'] = "Hallinta";
$text['welcome'] = "Tervetuloa";
$text['contactus'] = "Ota yhteytt�";

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
