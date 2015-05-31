<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Deursoek Alle Bronne";
		$text['shorttitle'] = "Kort Titel";
		$text['callnum'] = "Kontak Nommer";
		$text['author'] = "Outeur";
		$text['publisher'] = "Uitgewer";
		$text['other'] = "Ander Inligting";
		$text['sourceid'] = "Bron ID";
		$text['moresrc'] = "Meer Bronne";
		$text['repoid'] = "Argief ID";
		$text['browseallrepos'] = "Deursoek alle Argiewe";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nuwe Taal";
		$text['changelanguage'] = "Verander Taal";
		$text['languagesaved'] = "Taal Gestoor";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM beginnende vanaf";
		$text['producegedfrom'] = "Skep'n GEDCOM lêer vanaf";
		$text['numgens'] = "Aantal generasies";
		$text['includelds'] = "Sluit LDS inligting in";
		$text['buildged'] = "Bou GEDCOM";
		$text['gedstartfrom'] = "GEDCOM beginnende vanaf";
		$text['nomaxgen'] = "Dui 'n maksimum aantal generasies aan. Gebruik [BACK] om terug te gaan na vorige bladsy om fout te herstel.";
		$text['gedcreatedfrom'] = "GEDCOM geskep vanaf";
		$text['gedcreatedfor'] = "geskep vir";

		$text['enteremail'] = "Sleutel asseblief 'n geldige e-pos adres in.";
		$text['creategedfor'] = "Skep GEDCOM";
		$text['email'] = "E-pos Adres";
		$text['suggestchange'] = "Stel 'n verandering voor";
		$text['yourname'] = "Jou Naam";
		$text['comments'] = "Notas of Opmerkings";
		$text['comments2'] = "Opmerkings";
		$text['submitsugg'] = "Stuur Voorstel";
		$text['proposed'] = "Voorgestelde verandering";
		$text['mailsent'] = "Dankie. Jou boodskap is gestuur.";
		$text['mailnotsent'] = "Jammer, jou boodskap kon nie gestuur word nie. Kontak asseblief vir xxx direk by yyy.";
		$text['mailme'] = "Stuur 'n kopie aan hierdie adres";
		//added in 5.0.5
		$text['entername'] = "Please enter your name";
		$text['entercomments'] = "Please enter your comments";
		$text['sendmsg'] = "Send Message";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Foto's en Geskiedenis vir";
		$text['indinfofor'] = "Persoonlike inligting vir";
		$text['reliability'] = "Betroubaarheid";
		$text['pp'] = "bl.";
		$text['age'] = "Ouderdom";
		$text['agency'] = "Agentskap";
		$text['cause'] = "Oorsaak";
		$text['suggested'] = "Voorgestelde";
		$text['closewindow'] = "Maak venster toe";
		$text['thanks'] = "Dankie";
		$text['received'] = "Jou voorstel is aangestuur na die webwerf administrateur vir oorweging.";
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
		$text['relcalc'] = "Verwantskap Berekening";
		$text['findrel'] = "Soek Verwantskap";
		$text['person1'] = "Persoon 1:";
		$text['person2'] = "Persoon 2:";
		$text['calculate'] = "Bereken";
		$text['select2inds'] = "Kies asseblief twee individue.";
		$text['findpersonid'] = "Soek Persoon ID";
		$text['enternamepart'] = "sleutel deel van voornaam en/of van in";
		$text['pleasenamepart'] = "Sleutel asseblief gedeelte van 'n voornaam of van in.";
		$text['clicktoselect'] = "kliek om te kies";
		$text['nobirthinfo'] = "Geen geboorte inligting";
		$text['relateto'] = "Verwantskap aan";
		$text['sameperson'] = "Die twee individue is dieselfde persoon.";
		$text['notrelated'] = "Die twee individue is nie verwant aan mekaar binne xxx generasies nie.";
		$text['findrelinstr'] = "Om die verwantskap tussen twee persone te wys, gebruik die 'Soek' knoppies langs elke individu om die persoon op te spoor (of hou persone soos vertoon), kliek dan op 'Bereken'.";
		$text['gencheck'] = "Maksimum generasies<br />om na te gaan";
		$text['sometimes'] = "(Soek oor verskillende aantal generasies, kan soms verskillende resultate oplewer.)";
		$text['findanother'] = "Soek 'n ander verwantskap";
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
		$text['changeto'] = "Verander na:";
		//added in 6.0.0
		$text['notvalid'] = "is not a valid Person ID number or does not exist in this database. Please try again.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Familiegroep-blad vir";
		$text['ldsords'] = "LDS Ordinansies";
		$text['baptizedlds'] = "Gedoop  (LDS)";
		$text['endowedlds'] = "Begiftig (LDS)";
		$text['sealedplds'] = "Verseël O (LDS)";
		$text['sealedslds'] = "Verseël G (LDS)";
		$text['otherspouse'] = "Ander Gade";
		//changed in 7.0.0
		$text['husband'] = "Man";
		$text['wife'] = "Vrou";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "*";
		$text['capaltbirthabbr'] = "&amp;asymp;";
		$text['capdeathabbr'] = "&amp;dagger;";
		$text['capburialabbr'] = "&amp;Omega;";
		$text['capplaceabbr'] = "P";
		$text['capmarrabbr'] = "x";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Herteken met";
		$text['scrollnote'] = "Notas: Mag dalk nodig wees om regs en af te beweeg vir volledige kaart.";
		$text['unknownlit'] = "Onbekend";
		$text['popupnote1'] = " = Addisionele inligting";
		$text['popupnote2'] = " = Nuwe stamboom";
		$text['pedcompact'] = "Kompak";
		$text['pedstandard'] = "Standaard";
		$text['pedtextonly'] = "Teks";
		$text['descendfor'] = "Nasgeslag van";
		$text['maxof'] = "Maksimum van";
		$text['gensatonce'] = "generasies vertoon op een tydstip.";
		$text['sonof'] = "seun van";
		$text['daughterof'] = "dogter van";
		$text['childof'] = "kind van";
		$text['stdformat'] = "Standaard Formaat";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "Voeg nuwe Familie by";
		$text['editfam'] = "Wysig Familie";
		$text['side'] = "Kant";
		$text['familyof'] = "Familie van";
		$text['paternal'] = "Vaderskant";
		$text['maternal'] = "Moederskant";
		$text['gen1'] = "Self";
		$text['gen2'] = "Ouers";
		$text['gen3'] = "Grootouers";
		$text['gen4'] = "Oorgrootouers";
		$text['gen5'] = "2de Generasie Oorgrootouers";
		$text['gen6'] = "3de Generasie Oorgrootouers";
		$text['gen7'] = "4de Generasie Oorgrootouers";
		$text['gen8'] = "5de Generasie Oorgrootouers";
		$text['gen9'] = "6de Generasie Oorgrootouers";
		$text['gen10'] = "7de Generasie Oorgrootouers";
		$text['gen11'] = "8ste Generasie Oorgrootouers";
		$text['gen12'] = "9de Generasie Oorgrootouers";
		$text['graphdesc'] = "Nageslag-kaart tot op die punt";
		$text['collapse'] = "Opvou";
		$text['expand'] = "Brei uit";
		$text['pedbox'] = "Blok";
		//changed in 6.0.0
		$text['regformat'] = "Register Formaat";
		$text['extrasexpl'] = "As foto's of geskiedenis vir die volgende individue bestaan, sal ooreenstemmende ikone vertoon word langs die name.";
		//added in 6.0.0
		$text['popupnote3'] = " = New chart";
		$text['mediaavail'] = "Media Available";
		//changed in 7.0.0
		$text['pedigreefor'] = "Stamboom vir";
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
		$text['noreports'] = "Geen verslae bestaan nie.";
		$text['reportname'] = "Veslag Naam";
		$text['allreports'] = "Alle Verslae";
		$text['report'] = "Verslag";
		$text['error'] = "Fout";
		$text['reportsyntax'] = "Die sintaks van die navraag vir die verslag";
		$text['wasincorrect'] = "was verkeerd, daarom kon die verslag nie saamgestel word nie.  Kontak asseblief die stelsel-administrateur by";
		$text['query'] = "Navraag";
		$text['errormessage'] = "Fout Boodskap";
		$text['equals'] = "gelyk aan";
		$text['contains'] = "bevat";
		$text['startswith'] = "begin met";
		$text['endswith'] = "eindig met";
		$text['soundexof'] = "soundex van";
		$text['metaphoneof'] = "metafoor vir";
		$text['plusminus10'] = "+/- 10 jaar vanaf";
		$text['lessthan'] = "minder as";
		$text['greaterthan'] = "groter as";
		$text['lessthanequal'] = "minder as of gelyk aan";
		$text['greaterthanequal'] = "meer as of gelyk aan";
		$text['equalto'] = "gelyk aan";
		$text['tryagain'] = "Probeer asseblief weer";
		$text['text_for'] = "vir";
		$text['searchnames'] = "Soek vir Name";
		$text['joinwith'] = "Verbind met";
		$text['cap_and'] = "EN";
		$text['cap_or'] = "OF";
		$text['showspouse'] = "Wys gade (sal duplikate wys as individue meer as een gade het)";
		$text['submitquery'] = "Stuur Navraag";
		$text['birthplace'] = "Geboorteplek";
		$text['deathplace'] = "Sterfplek";
		$text['birthdatetr'] = "Geboortejaar";
		$text['deathdatetr'] = "Sterfjaar";
		$text['plusminus2'] = "+/- 2 jare vanaf";
		$text['resetall'] = "Herstel alle waardes";

		$text['showdeath'] = "Wys sterf-/grafinligting";
		$text['altbirthplace'] = "Doopplek";
		$text['altbirthdatetr'] = "Doopjaar";
		$text['burialplace'] = "Begraafplaas";
		$text['burialdatetr'] = "Jaar van Begrafnis";
		$text['event'] = "Gebeurtenis(se)";
		$text['day'] = "Dag";
		$text['month'] = "Maand";
		$text['keyword'] = "Sleutelwoord (bv, \"±\")";
		$text['explain'] = "Sleutel datum in om verwante gebeurtenisse te sien. Los veld oop om alle verwante gebeure te sien.";
		$text['enterdate'] = "Kies asseblief ten minste een van die volgende: Dag, Maand, Jaar, Sleutelwoord";
		$text['fullname'] = "Volle Name";
		$text['birthdate'] = "Geboortedatum";
		$text['altbirthdate'] = "Doopdatum";
		$text['marrdate'] = "Huweliksdatum";
		$text['spouseid'] = "Gade ID";
		$text['spousename'] = "Naam van Gade";
		$text['deathdate'] = "Sterfdatum";
		$text['burialdate'] = "Datum van Begrafnis";
		$text['changedate'] = "Datum van laaste verandering";
		$text['gedcom'] = "Boom";
		$text['baptdate'] = "Datum van Doop(LDS)";
		$text['baptplace'] = "Plek van Doop (LDS)";
		$text['endldate'] = "Begiftigingsdatum (LDS)";
		$text['endlplace'] = "Plek van Begiftiging (LDS)";
		$text['ssealdate'] = "Datum Verseël G (LDS)";
		$text['ssealplace'] = "Plek Verseël G (LDS)";
		$text['psealdate'] = "Datum Verseël O (LDS)";
		$text['psealplace'] = "Plek Verseël O (LDS)";
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
		$text['otherevents'] = "Ander Gebeure";
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
		$text['logfilefor'] = "Log lêer vir";
		$text['mostrecentactions'] = "Mees onlangse Aksies";
		$text['autorefresh'] = "Auto Herlaai (30 sekondes)";
		$text['refreshoff'] = "Skakel Auto Herlaai Af";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Begraafplase en Grafstene";
		$text['showallhsr'] = "Wys alle Grafsteen-rekords";
		$text['in'] = "in";
		$text['showmap'] = "Wys Kaart";
		$text['headstonefor'] = "Grafsteen vir";
		$text['photoof'] = "Foto van";
		$text['firstpage'] = "Eerste Bladsy";
		$text['lastpage'] = "Laaste Bladsy";
		$text['photoowner'] = "Eienaar/Bron";

		$text['nocemetery'] = "Geen Begraafplaas";
		$text['iptc005'] = "Titel";
		$text['iptc020'] = "Aanvullende Kategorieë";
		$text['iptc040'] = "Spesiale Instruksies";
		$text['iptc055'] = "Datum Geskep";
		$text['iptc080'] = "Outeur";
		$text['iptc085'] = "Outeur se Adres";
		$text['iptc090'] = "Dorp";
		$text['iptc095'] = "Staat/Provinsie";
		$text['iptc101'] = "Land";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Grafskrif";
		$text['iptc110'] = "Bron";
		$text['iptc115'] = "Foto Bron";
		$text['iptc116'] = "Kopiereg Kennisgewing";
		$text['iptc120'] = "Opskrif";
		$text['iptc122'] = "Opskrif Skrywer";
		$text['mapof'] = "Kaart van";
		$text['regphotos'] = "Beskrywende Uitleg";
		$text['gallery'] = "Duimdrukke Alleen";
		$text['cemphotos'] = "Begraafplaas Foto's";
		//changed in 6.0.0
		$text['photosize'] = "Grootte";
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
		$text['surnamesstarting'] = "Wys vanne wat begin met";
		$text['showtop'] = "Wys Top";
		$text['showallsurnames'] = "Wys alle vanne";
		$text['sortedalpha'] = "alfabeties gesorteerd";
		$text['byoccurrence'] = "gesorteerd volgens voorkoms";
		$text['firstchars'] = "Eerste Karakters";
		$text['top'] = "Top";
		$text['mainsurnamepage'] = "Hoof VAN bladsy";
		$text['allsurnames'] = "Alle Vanne";
		$text['showmatchingsurnames'] = "Kliek op 'n van om verwante rekords te vertoon.";
		$text['backtotop'] = "Terug na top";
		$text['beginswith'] = "Begin met";
		$text['allbeginningwith'] = "Alle vanne wat begin met";
		$text['numoccurrences'] = "aantal verwante gevalle in hakies";
		$text['placesstarting'] = "Wys grootste liggings beginnende met";
		$text['showmatchingplaces'] = "Kliek op 'n plek om kleiner plekke te wys. Kliek op die 'Soek' ikoon om verwante individue te wys.";
		$text['totalnames'] = "totale individue";
		$text['showallplaces'] = "Wys alle groot plekke";
		$text['totalplaces'] = "totale plekke";
		$text['mainplacepage'] = "Hoof Plekke Bladsy";
		$text['allplaces'] = "Alle Groot Plekke";
		$text['placescont'] = "Wys alle plekke wat die volgende bevat";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(afgelope xx dae)";
		$text['historiesdocs'] = "Geskeidenis";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Foto";
		$text['history'] = "Geskiedenis/Dokument";
		//changed in 7.0.0
		$text['husbid'] = "Man ID";
		$text['husbname'] = "Man se Naam";
		$text['wifeid'] = "Vrou ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Verwyder";
		$text['addperson'] = "Voeg Persoon By";
		$text['nobirth'] = "Die volgende individu het nie 'n geldige geboortedatum nie en kon daarom nie bygevoeg word nie";
		$text['noliving'] = "Die volgende individue is gemerk as lewend en kon daarom nie bygevoeg word nie omdat jy nie met die nodige toestemming ingeteken is nie";
		$text['event'] = "Gebeurtenis(se)";
		$text['chartwidth'] = "Chart width";
		//changed in 6.0.0
		$text['timelineinstr'] = "Voeg tot vier individue by deur hul ID's in te sleutel:";
		//added in 6.0.0
		$text['togglelines'] = "Toggle Lines";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Deursoek Alle Bome";
		$text['treename'] = "Boom Naam";
		$text['owner'] = "Eienaar";
		$text['address'] = "Adres";
		$text['city'] = "Dorp";
		$text['state'] = "Staat/Provisie";
		$text['zip'] = "Zip/Poskode";
		$text['country'] = "Land";
		$text['email'] = "E-pos Adres";
		$text['phone'] = "Telefoon";
		$text['username'] = "Gebruikersnaam";
		$text['password'] = "Wagwoord";
		$text['loginfailed'] = "Inteken onsuksesvol.";

		$text['regnewacct'] = "Registreer vir Nuwe Gebruikersrekening";
		$text['realname'] = "Jou Regte Naam";
		$text['phone'] = "Telefoon";
		$text['email'] = "E-pos Adres";
		$text['address'] = "Adres";
		$text['comments'] = "Notas of Opmerkings";
		$text['submit'] = "Stuur";
		$text['leaveblank'] = "(los skoon as jy 'n nuwe boom verlang)";
		$text['required'] = "Verpligte Velde";
		$text['enterpassword'] = "Sleutel asseblief 'n wagwoord in.";
		$text['enterusername'] = "Sleutel asseblief 'n gebruikersnaam in.";
		$text['failure'] = "Ons is jammer, maar die gebruikersnaam wat jy ingesleutel het is reeds in gebruik. Gebruik asseblief die 'Back'-knoppie op jou webblaaier (IE ens.) om na die vorige bladsy terug te keer, en kies 'n ander gebruikersnaam.";
		$text['success'] = "Dankie. Ons het jou registrasie ontvang. Ons sal jou kontak wanneer jou rekening aktief is of as nog inligting benodig word.";
		$text['emailsubject'] = "Nuwe TNG gebruiker registrasie versoek";
		$text['emailmsg'] = "Jy het 'n nuwe versoek onvang vir 'n TNG gebruikersrekening. Teken asseblief aan by die TNG Administrasie area en gee die nodige toestemming aan die nuwe gebruikersrekening. As jy die registrasie goedkeur, stel asseblief die gebruiker in kennis deur terug te antwoord op hierdie boodskap";
		//changed in 5.0.0
		$text['enteremail'] = "Sleutel asseblief 'n geldige e-pos adres in.";
		$text['website'] = "Webwerf";
		$text['nologin'] = "Het jy nie inteken-inligting nie?";
		$text['loginsent'] = "Inteken-Inligting gestuur";
		$text['loginnotsent'] = "Inteken-inligting is nie gestuur nie";
		$text['enterrealname'] = "Tik asseblief jou regte naam in.";
		$text['rempass'] = "Bly ingeteken op hierdie rekenaar";
		$text['morestats'] = "Meer statistieke";
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
		$text['quantity'] = "Hoeveelheid";
		$text['totindividuals'] = "Totale Individue";
		$text['totmales'] = "Totale Mans";
		$text['totfemales'] = "Totale Vroue";
		$text['totunknown'] = "Totale Onbekende Geslag";
		$text['totliving'] = "Totale Lewendes";
		$text['totfamilies'] = "Totale Families";
		$text['totuniquesn'] = "Totale Unieke Vanne";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Totale Bronne";
		$text['avglifespan'] = "Gemiddelde Lewensduur";
		$text['earliestbirth'] = "Vroegste Geboorte";
		$text['longestlived'] = "Langste Geleef";
		$text['years'] = "jare";
		$text['days'] = "dae";
		$text['age'] = "Ouderdom";
		$text['agedisclaimer'] = "Ouderdomsverwante berekeninge is gebaseer op induvidue wie se geboorte- <EM>en</EM> sterf-datums genoteer is .  A.g.v. die bestaan van onvolledige datum velde(bv., 'n sterfte wat slegs gelys word as \"1945\" of \"< 1860\"), kan hierdie berekening nie 100% akuraat wees nie.";
		$text['treedetail'] = "Meer inligting oor hierdie boom";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Deursoek Alle Notas";
		break;

	case "help":
		$text['menuhelp'] = "Menu Sleutel";
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
$text['matches'] = "Resultate";
$text['description'] = "Beskrywing";
$text['notes'] = "Notas";
$text['status'] = "Status";
$text['newsearch'] = "Nuwe Soektog";
$text['pedigree'] = "Stamboom";
$text['birthabbr'] = "*";
$text['chrabbr'] = "&asymp;";
$text['seephoto'] = "Sien foto";
$text['andlocation'] = "& plek";
$text['accessedby'] = "toegang verkry deur";
$text['go'] = "Gaan";
$text['family'] = "Familie";
$text['children'] = "Kinders";
$text['tree'] = "Boom";
$text['alltrees'] = "Alle Bome";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "Duim";
$text['people'] = "Mense";
$text['title'] = "Titel";
$text['suffix'] = "Agtervoegsel";
$text['nickname'] = "Noemnaam";
$text['deathabbr'] = "†";
$text['lastmodified'] = "Laaste Opgedateer";
$text['married'] = "Getroud";
//$text['photos'] = "Photos";
$text['name'] = "Naam";
$text['lastfirst'] = "Van, Naam(e)";
$text['bornchr'] = "Gebore/Gedoop";
$text['individuals'] = "Individue";
$text['families'] = "Families";
$text['personid'] = "Persoons ID";
$text['sources'] = "Bronne";
$text['unknown'] = "Onbekend";
$text['father'] = "Vader";
$text['mother'] = "Moeder";
$text['born'] = "Geboorte";
$text['christened'] = "Gedoop";
$text['died'] = "Sterf";
$text['buried'] = "Begrawe";
$text['spouse'] = "Gade";
$text['parents'] = "Ouers";
$text['text'] = "Teks";
$text['language'] = "Taal";
$text['burialabbr'] = "&Omega;";
$text['descendchart'] = "Nageslag";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Individu";
$text['edit'] = "Wysig";
$text['date'] = "Datum";
$text['place'] = "Plek";
$text['login'] = "Teken in";
$text['logout'] = "Teken af";
$text['marrabbr'] = "x.";
$text['groupsheet'] = "Groepblad";
$text['text_and'] = "en";
$text['generation'] = "Generasie";
$text['filename'] = "lêernaam";
$text['id'] = "ID";
$text['search'] = "Soek";
$text['living'] = "Lewend";
$text['user'] = "Gebruiker";
$text['firstname'] = "Voornaam";
$text['lastname'] = "Van";
$text['searchresults'] = "Soek Resultate";
$text['diedburied'] = "Gesterf/Begrawe";
$text['homepage'] = "Tuisblad";
$text['find'] = "Soek...";
$text['relationship'] = "Verwantskap";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Tydlyn";
$text['yesabbr'] = "J";
$text['divorced'] = "Geskei";
$text['indlinked'] = "Geskakel aan";
$text['branch'] = "Tak";
$text['moreind'] = "Meer individue";
$text['morefam'] = "Meer families";
$text['livingdoc'] = "Ten minste een lewende individu word vermeld in hierdie dokument - Besonderhede weerhou.";
$text['source'] = "Bron";
$text['surnamelist'] = "Lys van Vanne";
$text['generations'] = "Generasies";
$text['refresh'] = "Herlaai";
$text['whatsnew'] = "Wat is Nuut";
$text['reports'] = "Verslae";
$text['placelist'] = "Lys van Plekke";
$text['baptizedlds'] = "Gedoop  (LDS)";
$text['endowedlds'] = "Begiftig (LDS)";
$text['sealedplds'] = "Verseël O (LDS)";
$text['sealedslds'] = "Verseël G (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Voorouers";
$text['descendants'] = "Nageslag";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Datum van Laaste GEDCOM Invoer";
$text['type'] = "Tipe";
$text['savechanges'] = "Stoor Veranderinge";
$text['familyid'] = "Familie ID";
$text['headstone'] = "Grafstene";
$text['historiesdocs'] = "Geskeidenis";
$text['livingnote'] = "Ten minste een lewende individu word vermeld in hierdie nota - Besonderhede weerhou.";
$text['anonymous'] = "anoniem";
$text['places'] = "Plekke";
$text['anniversaries'] = "Datums & Herdenkings";
$text['administration'] = "Administrasie";
$text['help'] = "Hulp";
//$text['documents'] = "Documents";
$text['year'] = "Jaar";
$text['all'] = "Almal";
$text['repository'] = "Argief";
$text['address'] = "Adres";
$text['suggest'] = "Stel Voor";
$text['editevent'] = "Stel 'n verandering voor vir hierdie gebeurtenis";
$text['findplaces'] = "Soek alle individue met gebeure by hierdie plek";
$text['morelinks'] = "Meer Skakels";
$text['faminfo'] = "Familie Inligting";
$text['persinfo'] = "Persoonlike Inligting";
$text['srcinfo'] = "Bron Inligting";
$text['fact'] = "Feit";
$text['goto'] = "Kies 'n bladsy";
$text['tngprint'] = "Print";
//changed in 6.0.0
$text['livingphoto'] = "Ten minste een lewende individu kom voor op hierdie foto - Besonderhede weerhou.";
$text['databasestatistics'] = "Databasis Statistieke";
//moved here in 6.0.0
$text['child'] = "Kind";
$text['repoinfo'] = "Argief Inligting";
$text['tng_reset'] = "Herstel";
$text['noresults'] = "Geen resultate gekry nie";
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
$text['cemetery'] = "Begraafplaas";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Event Map";
$text['gevents'] = "Event";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Link to Google Earth";
$text['googlemaplink'] = "Link to Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "Ongemerk";
$text['located'] = "Ligging";
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
$text['mnuheader'] = "Tuisblad";
$text['mnusearchfornames'] = "Soek vir Name";
$text['mnulastname'] = "Van";
$text['mnufirstname'] = "Voornaam";
$text['mnusearch'] = "Soek";
$text['mnureset'] = "Begin Oor";
$text['mnulogon'] = "Teken In";
$text['mnulogout'] = "Teken Af";
$text['mnufeatures'] = "Ander Kenmerke";
$text['mnuregister'] = "Registreer vir 'n Gebruikersrekening";
$text['mnuadvancedsearch'] = "Gevorderde Soek";
$text['mnulastnames'] = "Vanne";
$text['mnustatistics'] = "Statistieke";
$text['mnuphotos'] = "Foto's";
$text['mnuhistories'] = "Geskiedenis";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Begraafplase";
$text['mnutombstones'] = "Grafstene";
$text['mnureports'] = "Verslae";
$text['mnusources'] = "Bronne";
$text['mnuwhatsnew'] = "Wat is Nuut";
$text['mnushowlog'] = "Toegangslog";
$text['mnulanguage'] = "Verander Taal";
$text['mnuadmin'] = "Administrasie";
$text['welcome'] = "Welkom";
$text['contactus'] = "Kontak Ons";

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
