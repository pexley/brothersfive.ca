<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Prohlédnout v¹echny prameny informací";
		$text['shorttitle'] = "Krátký název";
		$text['callnum'] = "Archivní èíslo";
		$text['author'] = "Autor";
		$text['publisher'] = "Vydavatel";
		$text['other'] = "Dal¹í informace";
		$text['sourceid'] = "Èíslo pramenu";
		$text['moresrc'] = "Dal¹í prameny";
		$text['repoid'] = "Èíslo depozitáøe";
		$text['browseallrepos'] = "Prohlédnout v¹echny depozitáøe";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nový jazyk";
		$text['changelanguage'] = "Zmìnit jazyk";
		$text['languagesaved'] = "Jazyk ulo¾en";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM zaèínající od";
		$text['producegedfrom'] = "Vytvoøit GEDCOM soubor pro";
		$text['numgens'] = "Poèet generací";
		$text['includelds'] = "Vèetnì LDS informací";
		$text['buildged'] = "Vytvoø GEDCOM";
		$text['gedstartfrom'] = "GEDCOM zaèínající od";
		$text['nomaxgen'] = "Musíte zadat maximální poèet generací. Pou¾ijte tlaèítko Zpìt k návratu na pøedchozí stránku a chybu opravte.";
		$text['gedcreatedfrom'] = "GEDCOM vytvoøen od";
		$text['gedcreatedfor'] = "vytvoøen pro";

		$text['enteremail'] = "Zadejte prosím platnou emailovou adresu.";
		$text['creategedfor'] = "Vytvoøit GEDCOM";
		$text['email'] = "E-mail";
		$text['suggestchange'] = "Navrhnout zmìnu";
		$text['yourname'] = "Va¹e jméno";
		$text['comments'] = "Poznámky";
		$text['comments2'] = "Komentáø";
		$text['submitsugg'] = "Poslat návrh";
		$text['proposed'] = "Navrhovaná zmìna";
		$text['mailsent'] = "Dìkujeme. Va¹e zpráva byla odeslána.";
		$text['mailnotsent'] = "Bohu¾el, va¹e zpráva nemohla být doruèena. Kontaktujte prosím xxx pøímo na yyy.";
		$text['mailme'] = "Zaslat kopii na tuto adresu";
		//added in 5.0.5
		$text['entername'] = "Please enter your name";
		$text['entercomments'] = "Please enter your comments";
		$text['sendmsg'] = "Send Message";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotografie a historie pro";
		$text['indinfofor'] = "Osobní informace pro";
		$text['reliability'] = "Vìrohodnost";
		$text['pp'] = "str.";
		$text['age'] = "Vìk";
		$text['agency'] = "Agentura (Agency)";
		$text['cause'] = "Pøíèina";
		$text['suggested'] = "Navr¾ené";
		$text['closewindow'] = "Zavøít okno";
		$text['thanks'] = "Dìkujeme";
		$text['received'] = "Vá¹ návrh byl zaslán administrátorovi tìchto stránek k posouzení.";
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
		$text['relcalc'] = "Urèení pøíbuzenského vztahu";
		$text['findrel'] = "Urèení pøíbuzenského vztahu";
		$text['person1'] = "Osoba 1:";
		$text['person2'] = "Osoba 2:";
		$text['calculate'] = "Urèit vztah";
		$text['select2inds'] = "Zvolte dvì osoby.";
		$text['findpersonid'] = "Nalézt ID osoby";
		$text['enternamepart'] = "zadejte èást jména nebo pøíjmení";
		$text['pleasenamepart'] = "Zadejte prosím èást jména nebo pøíjmení.";
		$text['clicktoselect'] = "kliknutím vyberte osobu";
		$text['nobirthinfo'] = "Chybí informace o narození";
		$text['relateto'] = "Pøíbuzenský vztah k: ";
		$text['sameperson'] = "Tito dva lidé jsou stejná osoba";
		$text['notrelated'] = "Tyto dvì osoby nemají ¾ádný pøíbuzenský vztah v xxx generacích";
		$text['findrelinstr'] = "Ke zobrazení pøíbuzenského vstahu mezi dvìma osobami, kliknìte nejdøíve na 'Najít' abyste na¹li pøíslu¹né osoby (nebo zanechte osoby které jsou zobrazené), potom kliknìte na 'Kalkulovat'.";
		$text['gencheck'] = "Maximum generací<br />, které budou prohlédnuty";
		$text['sometimes'] = "(Pou¾ití jiného poètu generací mù¾e mít nìkdy jiný vývsledek.)";
		$text['findanother'] = "Zjistit jiný pøíbuzenský vstah";
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
		$text['changeto'] = "Zmìnit na:";
		//added in 6.0.0
		$text['notvalid'] = "is not a valid Person ID number or does not exist in this database. Please try again.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Rodinný seznam pro";
		$text['ldsords'] = "LDS Ordinances";
		$text['baptizedlds'] = "Pokøtìn (LDS)";
		$text['endowedlds'] = "Endowed (LDS)";
		$text['sealedplds'] = "Sealed P (LDS)";
		$text['sealedslds'] = "Sealed S (LDS)";
		$text['otherspouse'] = "Dal¹í man¾el/ka";
		//changed in 7.0.0
		$text['husband'] = "Man¾el";
		$text['wife'] = "Man¾elka";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "Nar.";
		$text['capaltbirthabbr'] = "Nar.";
		$text['capdeathabbr'] = "Zemø.";
		$text['capburialabbr'] = "Pohø.";
		$text['capplaceabbr'] = "v";
		$text['capmarrabbr'] = "Svat.";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Zobrazit s";
		$text['scrollnote'] = "Pozn.: Pokud je tøeba, pou¾ijte ke zobrazení celého obrázku li¹ty.";
		$text['unknownlit'] = "Neznámý";
		$text['popupnote1'] = " = Dal¹í informace";
		$text['popupnote2'] = " = Nový rodokmen";
		$text['pedcompact'] = "Kompaktní";
		$text['pedstandard'] = "Standardní";
		$text['pedtextonly'] = "Pouze text";
		$text['descendfor'] = "Potomci pro";
		$text['maxof'] = "Nejvíce";
		$text['gensatonce'] = "generací zobrazených najednou.";
		$text['sonof'] = "syn";
		$text['daughterof'] = "dcera";
		$text['childof'] = "dítì";
		$text['stdformat'] = "Standardní formát";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "Pøidat novou rodinu";
		$text['editfam'] = "Upravit rodinu";
		$text['side'] = "Stránka";
		$text['familyof'] = "Rodina";
		$text['paternal'] = "Otcovský";
		$text['maternal'] = "Mateøský";
		$text['gen1'] = "Vlastní";
		$text['gen2'] = "Rodièe";
		$text['gen3'] = "Prarodièe";
		$text['gen4'] = "Pra-prarodièe";
		$text['gen5'] = "Druzí pra-prarodièe";
		$text['gen6'] = "Tøetí pra-prarodièe";
		$text['gen7'] = "Ètvrtí pra-prarodièe";
		$text['gen8'] = "Pátí pra-prarodièe";
		$text['gen9'] = "©estí pra-prarodièe";
		$text['gen10'] = "Sedmí pra-prarodièe";
		$text['gen11'] = "Osmí pra-prarodièe";
		$text['gen12'] = "Devátí pra-prarodièe";
		$text['graphdesc'] = "Graf potomkù a¾ do tohoto místa";
		$text['collapse'] = "Sbalit";
		$text['expand'] = "Rozbalit";
		$text['pedbox'] = "Rámeèek";
		//changed in 6.0.0
		$text['regformat'] = "Registrový formát";
		$text['extrasexpl'] = "Pokud existují fotografie nebo historie pro následující osoby, pøíslu¹né ikony budou zobrazeny vedle jmen.";
		//added in 6.0.0
		$text['popupnote3'] = " = New chart";
		$text['mediaavail'] = "Media Available";
		//changed in 7.0.0
		$text['pedigreefor'] = "Rodokmen-Vývod pro";
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
		$text['noreports'] = "®ádný výpis neexistuje.";
		$text['reportname'] = "Název výpisu";
		$text['allreports'] = "V¹echny výpisy";
		$text['report'] = "Výpis";
		$text['error'] = "Chyba";
		$text['reportsyntax'] = "Syntaxe dotazu pro tento výpis";
		$text['wasincorrect'] = "byla chybná a výpis nemohl být vytvoøen. Kontaktujte prosím administrátora systému na";
		$text['query'] = "Dotaz";
		$text['errormessage'] = "Chybové hlá¹ení";
		$text['equals'] = "je";
		$text['contains'] = "obsahuje";
		$text['startswith'] = "zaèíná s";
		$text['endswith'] = "konèí s";
		$text['soundexof'] = "soundex";
		$text['metaphoneof'] = "metaphone of";
		$text['plusminus10'] = "+/- 10 rokù od";
		$text['lessthan'] = "ménì ne¾";
		$text['greaterthan'] = "více ne¾";
		$text['lessthanequal'] = "ménì nebo rovno";
		$text['greaterthanequal'] = "více nebo rovno";
		$text['equalto'] = "rovno";
		$text['tryagain'] = "Zkusit znovu";
		$text['text_for'] = "pro";
		$text['searchnames'] = "Hledání jmen";
		$text['joinwith'] = "Logika hledání";
		$text['cap_and'] = "A";
		$text['cap_or'] = "NEBO";
		$text['showspouse'] = "Zobrazit man¾ela/ku (zobrazí více záznamù pokud mìla dotyèná osoba více man¾elù/ek)";
		$text['submitquery'] = "Provést dotaz";
		$text['birthplace'] = "Místo narození";
		$text['deathplace'] = "Místo úmrtí";
		$text['birthdatetr'] = "Rok narození";
		$text['deathdatetr'] = "Rok úmrtí";
		$text['plusminus2'] = "+/- 2 roky od";
		$text['resetall'] = "Nastavit hodnoty formuláøe na pùvodní";

		$text['showdeath'] = "Zobrazit informace o úmrtí/pohøbu";
		$text['altbirthplace'] = "Místo køtu";
		$text['altbirthdatetr'] = "Rok køtu";
		$text['burialplace'] = "Místo pohøbu";
		$text['burialdatetr'] = "Rok pohøbu";
		$text['event'] = "Událost(i)";
		$text['day'] = "Den";
		$text['month'] = "Mìsíc";
		$text['keyword'] = "Klíèové slovo (napø. \"Abt\")";
		$text['explain'] = "Zadejte datum pro zobrazení odpovídajících událostí. Zanechte pole prázdné pro zobrazení v¹ech událostí.";
		$text['enterdate'] = "Zadejte nebo zvolte alespoò jedno z následujících: Den, Mìsíc, Rok, Klíèové slovo";
		$text['fullname'] = "Celé jméno";
		$text['birthdate'] = "Datum narození";
		$text['altbirthdate'] = "Datum køtu";
		$text['marrdate'] = "Datum svatby";
		$text['spouseid'] = "ID man¾ela/ky";
		$text['spousename'] = "Jméno man¾ela/ky";
		$text['deathdate'] = "Datum úmrtí";
		$text['burialdate'] = "Datum pohøbu";
		$text['changedate'] = "Datum poslední zmìny";
		$text['gedcom'] = "Rodokmen (Tree)";
		$text['baptdate'] = "LDS datum køtu";
		$text['baptplace'] = "LDS místo køtu";
		$text['endldate'] = "LDS datum zaslíbení";
		$text['endlplace'] = "LDS místo zaslíbení";
		$text['ssealdate'] = "LDS Man¾elské slouèení/datum";
		$text['ssealplace'] = "LDS Man¾elské slouèení/místo";
		$text['psealdate'] = "LDS Slouèení s rodièi/datum";
		$text['psealplace'] = "LDS Slouèení s rodièi/místo";
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
		$text['otherevents'] = "Jiné události";
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
		$text['logfilefor'] = "Soubor záznamù pro";
		$text['mostrecentactions'] = "Nedávná aktivita";
		$text['autorefresh'] = "Automatické zobrazení (po 30 vteøinách)";
		$text['refreshoff'] = "Vypnout automatické zobrazení";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Høbitovy a náhrobky";
		$text['showallhsr'] = "Zobrazit v¹echny záznamy náhrobkù";
		$text['in'] = "v";
		$text['showmap'] = "Ukázat mapu";
		$text['headstonefor'] = "Náhrobek pro";
		$text['photoof'] = "Fotografie";
		$text['firstpage'] = "První stránka";
		$text['lastpage'] = "Poslední stránka";
		$text['photoowner'] = "Majitel/Pramen";

		$text['nocemetery'] = "Høbitov není uveden";
		$text['iptc005'] = "Název";
		$text['iptc020'] = "Podporované kategorie";
		$text['iptc040'] = "Zvlá¹tní instrukce";
		$text['iptc055'] = "Datum vytvoøení";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Autorova funkce";
		$text['iptc090'] = "Mìsto/Obec";
		$text['iptc095'] = "Stát";
		$text['iptc101'] = "Zemì";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Nadpis";
		$text['iptc110'] = "Pramen";
		$text['iptc115'] = "Zdroj fotografie";
		$text['iptc116'] = "Ve¹kerá práva vyhrazena";
		$text['iptc120'] = "Popis";
		$text['iptc122'] = "Popis vytvoøil";
		$text['mapof'] = "Mapa";
		$text['regphotos'] = "Zobrazení s popisem";
		$text['gallery'] = "Poze náhledy";
		$text['cemphotos'] = "Obrázky høbitovù";
		//changed in 6.0.0
		$text['photosize'] = "Velikost";
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
		$text['surnamesstarting'] = "Zobrazit pøíjmení zaèínající na";
		$text['showtop'] = "Zobrazit prvních";
		$text['showallsurnames'] = "Zobrazit v¹echna pøíjmení";
		$text['sortedalpha'] = "seøazená podle abecedy";
		$text['byoccurrence'] = "seøazená podle èetnosti";
		$text['firstchars'] = "Zaèáteèní písmena";
		$text['top'] = "Zaèátek";
		$text['mainsurnamepage'] = "Hlavní stránka pøíjmení";
		$text['allsurnames'] = "V¹echna pøíjmení";
		$text['showmatchingsurnames'] = "Kliknutím na pøíjmení zobrazte pøíslu¹né záznamy.";
		$text['backtotop'] = "Zpìt na zaèátek";
		$text['beginswith'] = "Zaèíná na";
		$text['allbeginningwith'] = "V¹echna pøíjmení zaèínající na";
		$text['numoccurrences'] = "poèet výskytù v závorkách";
		$text['placesstarting'] = "Show largest localities starting with";
		$text['showmatchingplaces'] = "Kliknutím na pøíjmení zobrazte odpovídající záznamy.";
		$text['totalnames'] = "celkem osob";
		$text['showallplaces'] = "Zobrazit nejvìt¹í místa";
		$text['totalplaces'] = "celkem míst";
		$text['mainplacepage'] = "Hlavní stránka míst";
		$text['allplaces'] = "V¹echna nejvìt¹í místa";
		$text['placescont'] = "Zobrazit v¹echna místa obsahující";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(minulých xx dnech)";
		$text['historiesdocs'] = "Historie";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Fotografie";
		$text['history'] = "Historie/dokument";
		//changed in 7.0.0
		$text['husbid'] = "ID man¾ela";
		$text['husbname'] = "Jméno man¾ela";
		$text['wifeid'] = "ID man¾elky";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Vymazat";
		$text['addperson'] = "Pøidat osobu";
		$text['nobirth'] = "Následující osoba nemá platné datum narození a proto nebyla pøidána";
		$text['noliving'] = "Nasledující osoba je¹tì ¾ije a nebyla pøidána proto¾e nemáte patøièné povolení";
		$text['event'] = "Událost(i)";
		$text['chartwidth'] = "Chart width";
		//changed in 6.0.0
		$text['timelineinstr'] = "Pøidejte a¾ ètyøi dal¹í osoby zadáním jejich ID:";
		//added in 6.0.0
		$text['togglelines'] = "Toggle Lines";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Prohlédnout v¹echny rodokmeny";
		$text['treename'] = "Název rodokmenu";
		$text['owner'] = "Majitel";
		$text['address'] = "Adresa";
		$text['city'] = "Obec";
		$text['state'] = "Stát/Kraj";
		$text['zip'] = "PSÈ";
		$text['country'] = "Zemì";
		$text['email'] = "E-mail";
		$text['phone'] = "Telefon";
		$text['username'] = "U¾ivatelské jméno";
		$text['password'] = "Heslo";
		$text['loginfailed'] = "Chyba pøihlá¹ení.";

		$text['regnewacct'] = "Registrace pro nový úèet";
		$text['realname'] = "Va¹e jméno a pøíjmení";
		$text['phone'] = "Telefon";
		$text['email'] = "E-mail";
		$text['address'] = "Adresa";
		$text['comments'] = "Poznámky";
		$text['submit'] = "Odeslat";
		$text['leaveblank'] = "(zanechte toto pole prázdné pokud ¾ádáte o nový rodokmen)";
		$text['required'] = "Tyto údaje je nutné vyplnit";
		$text['enterpassword'] = "Zadejte heslo.";
		$text['enterusername'] = "Zadejte u¾ivatelské jméno.";
		$text['failure'] = "Zadané u¾ivatelské jméno je ji¾ vyhrazené. Stisknutím tlaèítka zpìt se vra»te na pøedchozí stránku a zvolte si jíné u¾ivatelské jméno";
		$text['success'] = "Va¹e registrace probìhla úspì¹nì. Administrátor systému vás bude informovat kdy bude vá¹ úèet aktivován nebo pokud budou potøeba dal¹í informace.";
		$text['emailsubject'] = "®ádost o novou registraci";
		$text['emailmsg'] = "Byla podána nová ¾ádost o nový u¾ivatelský úèet.  Pøihla¹te se do TNG Administrace a upravte patøièná povolení pro tento nový úèet.  O schválení nebo zamítnutí registrace informujte ¾adatele odpovìzením na tuto email.";
		//changed in 5.0.0
		$text['enteremail'] = "Zadejte prosím platnou emailovou adresu.";
		$text['website'] = "Internetové stránky";
		$text['nologin'] = "Nemáte pøihla¹ovací informace?";
		$text['loginsent'] = "Informace byly odeslány";
		$text['loginnotsent'] = "Pøihla¹ovací informace nebyly odeslány";
		$text['enterrealname'] = "Zadejte prosím své skuteèné jméno.";
		$text['rempass'] = "Zùstaòte pøipojeni na tento poèítaè";
		$text['morestats'] = "Dal¹í statistika";
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
		$text['quantity'] = "Poèet";
		$text['totindividuals'] = "Celkem osob";
		$text['totmales'] = "Celkem mu¾ù";
		$text['totfemales'] = "Celkem ¾en";
		$text['totunknown'] = "Celkem neurèeného pohlaví";
		$text['totliving'] = "Celkem ¾ijících";
		$text['totfamilies'] = "Celkem rodin";
		$text['totuniquesn'] = "Celkem rùzných pøíjmení";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Celkem pramenù";
		$text['avglifespan'] = "Prùmìrná délka ¾ivota";
		$text['earliestbirth'] = "Nejdøíve narozený";
		$text['longestlived'] = "Osoby, které se do¾ily nejvy¹¹ího vìku";
		$text['years'] = "rokù";
		$text['days'] = "dní";
		$text['age'] = "Vìk";
		$text['agedisclaimer'] = "Výpoèty spojené s vìkem se zakládají na údajích osob s udaným datem narození <EM>a</EM> úmrtí.  Pokud jsou nìkterá data neúplná (napø., úmrtí zaznamenáno pouze jako rok \"1945\" nebo \"BEF 1860\"), vìkové výpoèty nebudou 100% pøesné.";
		$text['treedetail'] = "Dal¹í informace o tomto rodokmenu";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Prohlédnout v¹echny poznámky";
		break;

	case "help":
		$text['menuhelp'] = "Nápovìda nabídky";
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
$text['matches'] = "Záznamy";
$text['description'] = "Popis";
$text['notes'] = "Poznámky";
$text['status'] = "Stav";
$text['newsearch'] = "Nové hledání";
$text['pedigree'] = "Vývod";
$text['birthabbr'] = "nar.";
$text['chrabbr'] = "kø.";
$text['seephoto'] = "Prohlédnout fotografii";
$text['andlocation'] = "& místo";
$text['accessedby'] = "záznam prohlí¾el";
$text['go'] = "Jdi";
$text['family'] = "Rodina";
$text['children'] = "Dìti";
$text['tree'] = "Rodokmen";
$text['alltrees'] = "V¹echny rodokmeny";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "Náhled";
$text['people'] = "Lidé";
$text['title'] = "Titul";
$text['suffix'] = "Sufix";
$text['nickname'] = "Pøezdívka";
$text['deathabbr'] = "zemø.";
$text['lastmodified'] = "Poslední zmìna";
$text['married'] = "®enatý/vdaná";
//$text['photos'] = "Photos";
$text['name'] = "Jméno";
$text['lastfirst'] = "Pøíjmení, jméno";
$text['bornchr'] = "Datum a místo narození";
$text['individuals'] = "Osoby";
$text['families'] = "Rodiny";
$text['personid'] = "ID osoby";
$text['sources'] = "Prameny";
$text['unknown'] = "Neznámé";
$text['father'] = "Otec";
$text['mother'] = "Matka";
$text['born'] = "Narození";
$text['christened'] = "Pokøtìn";
$text['died'] = "Úmrtí";
$text['buried'] = "Pohøeb";
$text['spouse'] = "Man¾el/ka";
$text['parents'] = "Rodièe";
$text['text'] = "Text";
$text['language'] = "Jazyk";
$text['burialabbr'] = "pohø.";
$text['descendchart'] = "Rozrod";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Osoba";
$text['edit'] = "Upravit";
$text['date'] = "Datum";
$text['place'] = "Místo";
$text['login'] = "Pøihlásit";
$text['logout'] = "Odhlásit";
$text['marrabbr'] = "m.";
$text['groupsheet'] = "Seznam skupiny/rodiny";
$text['text_and'] = "a";
$text['generation'] = "Generace";
$text['filename'] = "Název souboru";
$text['id'] = "ID";
$text['search'] = "Hledat";
$text['living'] = "®ijící";
$text['user'] = "U¾ivatel";
$text['firstname'] = "Jméno";
$text['lastname'] = "Pøíjmení";
$text['searchresults'] = "Výsledky hledání";
$text['diedburied'] = "Zemøel/pohøben";
$text['homepage'] = "Hlavní stránka";
$text['find'] = "Najít(osobu)";
$text['relationship'] = "Pøíbuzenský vztah";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Èasová linie";
$text['yesabbr'] = "A";
$text['divorced'] = "Rozvedený/á";
$text['indlinked'] = "Odkaz na";
$text['branch'] = "Vìtev";
$text['moreind'] = "Dal¹í osoby";
$text['morefam'] = "Dal¹í rodiny";
$text['livingdoc'] = "Alespoò jedna ¾ijící osoba má odkaz na tento dokument - podrobnosti nezveøejnìny.";
$text['source'] = "Pramen";
$text['surnamelist'] = "Seznam pøíjmení";
$text['generations'] = "Poèet generací";
$text['refresh'] = "Obnovit";
$text['whatsnew'] = "Co je nového";
$text['reports'] = "Výpisy";
$text['placelist'] = "Seznam míst";
$text['baptizedlds'] = "Pokøtìn (LDS)";
$text['endowedlds'] = "Endowed (LDS)";
$text['sealedplds'] = "Sealed P (LDS)";
$text['sealedslds'] = "Sealed S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "pøedci";
$text['descendants'] = "potomci";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Datum posledního GEDCOM importu";
$text['type'] = "Druh";
$text['savechanges'] = "Ulo¾it zmìny";
$text['familyid'] = "ID rodiny";
$text['headstone'] = "Náhrobky";
$text['historiesdocs'] = "Historie";
$text['livingnote'] = "Alespoò jedna ¾ijící osoba má odkaz na tuto poznámku - podrobnosti nezveøejnìny.";
$text['anonymous'] = "anonymní";
$text['places'] = "Místa";
$text['anniversaries'] = "Datumy a výroèí";
$text['administration'] = "Administrace";
$text['help'] = "Nápovìda";
//$text['documents'] = "Documents";
$text['year'] = "Rok";
$text['all'] = "V¹echny";
$text['repository'] = "Depozitáø";
$text['address'] = "Adresa";
$text['suggest'] = "Navrhnout";
$text['editevent'] = "Navrhnout zmìnu pro tuto událost";
$text['findplaces'] = "Najít v¹echny osoby s uálostmi v tomto místì";
$text['morelinks'] = "Více odkazù";
$text['faminfo'] = "Informace o rodinì";
$text['persinfo'] = "Osobní informace";
$text['srcinfo'] = "Informace o pramenu";
$text['fact'] = "Fakt";
$text['goto'] = "Zvolte stránku";
$text['tngprint'] = "Print";
//changed in 6.0.0
$text['livingphoto'] = "Alespoò jedna ¾ijící osoba má odkaz na tuto fotografii - podrobnosti nezveøejnìny.";
$text['databasestatistics'] = "Statistika databáze";
//moved here in 6.0.0
$text['child'] = "Dítì";
$text['repoinfo'] = "Informace o depozitáøi";
$text['tng_reset'] = "Pùvodní nastavení (Reset)";
$text['noresults'] = "®ádné výsledky nebyly nalezeny";
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
$text['cemetery'] = "Høbitov";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Event Map";
$text['gevents'] = "Event";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Link to Google Earth";
$text['googlemaplink'] = "Link to Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "Neoznaèené";
$text['located'] = "Nacházející se";
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
$text['mnuheader'] = "Hlavní stránka";
$text['mnusearchfornames'] = "Hledat jména";
$text['mnulastname'] = "Pøíjmení";
$text['mnufirstname'] = "Jméno";
$text['mnusearch'] = "Hledat";
$text['mnureset'] = "Zaèít znavu";
$text['mnulogon'] = "Pøihlásit";
$text['mnulogout'] = "Odhlásit";
$text['mnufeatures'] = "Dal¹í mo¾nosti";
$text['mnuregister'] = "Registrace pro nový úèet";
$text['mnuadvancedsearch'] = "Roz¹íøené hledání";
$text['mnulastnames'] = "Pøíjmení";
$text['mnustatistics'] = "Statistika";
$text['mnuphotos'] = "Fotografie";
$text['mnuhistories'] = "Historie a písemnosti";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Høbitovy";
$text['mnutombstones'] = "Náhrobky";
$text['mnureports'] = "Výpisy";
$text['mnusources'] = "Zdroje";
$text['mnuwhatsnew'] = "Co je nového";
$text['mnushowlog'] = "Záznam pøístupù";
$text['mnulanguage'] = "Zmìnit jazyk";
$text['mnuadmin'] = "Administrace";
$text['welcome'] = "Vítejte";
$text['contactus'] = "Napi¹te nám";

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
