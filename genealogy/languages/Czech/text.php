<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Prohl�dnout v�echny prameny informac�";
		$text['shorttitle'] = "Kr�tk� n�zev";
		$text['callnum'] = "Archivn� ��slo";
		$text['author'] = "Autor";
		$text['publisher'] = "Vydavatel";
		$text['other'] = "Dal�� informace";
		$text['sourceid'] = "��slo pramenu";
		$text['moresrc'] = "Dal�� prameny";
		$text['repoid'] = "��slo depozit��e";
		$text['browseallrepos'] = "Prohl�dnout v�echny depozit��e";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nov� jazyk";
		$text['changelanguage'] = "Zm�nit jazyk";
		$text['languagesaved'] = "Jazyk ulo�en";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM za��naj�c� od";
		$text['producegedfrom'] = "Vytvo�it GEDCOM soubor pro";
		$text['numgens'] = "Po�et generac�";
		$text['includelds'] = "V�etn� LDS informac�";
		$text['buildged'] = "Vytvo� GEDCOM";
		$text['gedstartfrom'] = "GEDCOM za��naj�c� od";
		$text['nomaxgen'] = "Mus�te zadat maxim�ln� po�et generac�. Pou�ijte tla��tko Zp�t k n�vratu na p�edchoz� str�nku a chybu opravte.";
		$text['gedcreatedfrom'] = "GEDCOM vytvo�en od";
		$text['gedcreatedfor'] = "vytvo�en pro";

		$text['enteremail'] = "Zadejte pros�m platnou emailovou adresu.";
		$text['creategedfor'] = "Vytvo�it GEDCOM";
		$text['email'] = "E-mail";
		$text['suggestchange'] = "Navrhnout zm�nu";
		$text['yourname'] = "Va�e jm�no";
		$text['comments'] = "Pozn�mky";
		$text['comments2'] = "Koment��";
		$text['submitsugg'] = "Poslat n�vrh";
		$text['proposed'] = "Navrhovan� zm�na";
		$text['mailsent'] = "D�kujeme. Va�e zpr�va byla odesl�na.";
		$text['mailnotsent'] = "Bohu�el, va�e zpr�va nemohla b�t doru�ena. Kontaktujte pros�m xxx p��mo na yyy.";
		$text['mailme'] = "Zaslat kopii na tuto adresu";
		//added in 5.0.5
		$text['entername'] = "Please enter your name";
		$text['entercomments'] = "Please enter your comments";
		$text['sendmsg'] = "Send Message";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotografie a historie pro";
		$text['indinfofor'] = "Osobn� informace pro";
		$text['reliability'] = "V�rohodnost";
		$text['pp'] = "str.";
		$text['age'] = "V�k";
		$text['agency'] = "Agentura (Agency)";
		$text['cause'] = "P���ina";
		$text['suggested'] = "Navr�en�";
		$text['closewindow'] = "Zav��t okno";
		$text['thanks'] = "D�kujeme";
		$text['received'] = "V� n�vrh byl zasl�n administr�torovi t�chto str�nek k posouzen�.";
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
		$text['relcalc'] = "Ur�en� p��buzensk�ho vztahu";
		$text['findrel'] = "Ur�en� p��buzensk�ho vztahu";
		$text['person1'] = "Osoba 1:";
		$text['person2'] = "Osoba 2:";
		$text['calculate'] = "Ur�it vztah";
		$text['select2inds'] = "Zvolte dv� osoby.";
		$text['findpersonid'] = "Nal�zt ID osoby";
		$text['enternamepart'] = "zadejte ��st jm�na nebo p��jmen�";
		$text['pleasenamepart'] = "Zadejte pros�m ��st jm�na nebo p��jmen�.";
		$text['clicktoselect'] = "kliknut�m vyberte osobu";
		$text['nobirthinfo'] = "Chyb� informace o narozen�";
		$text['relateto'] = "P��buzensk� vztah k: ";
		$text['sameperson'] = "Tito dva lid� jsou stejn� osoba";
		$text['notrelated'] = "Tyto dv� osoby nemaj� ��dn� p��buzensk� vztah v xxx generac�ch";
		$text['findrelinstr'] = "Ke zobrazen� p��buzensk�ho vstahu mezi dv�ma osobami, klikn�te nejd��ve na 'Naj�t' abyste na�li p��slu�n� osoby (nebo zanechte osoby kter� jsou zobrazen�), potom klikn�te na 'Kalkulovat'.";
		$text['gencheck'] = "Maximum generac�<br />, kter� budou prohl�dnuty";
		$text['sometimes'] = "(Pou�it� jin�ho po�tu generac� m��e m�t n�kdy jin� v�vsledek.)";
		$text['findanother'] = "Zjistit jin� p��buzensk� vstah";
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
		$text['changeto'] = "Zm�nit na:";
		//added in 6.0.0
		$text['notvalid'] = "is not a valid Person ID number or does not exist in this database. Please try again.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Rodinn� seznam pro";
		$text['ldsords'] = "LDS Ordinances";
		$text['baptizedlds'] = "Pok�t�n (LDS)";
		$text['endowedlds'] = "Endowed (LDS)";
		$text['sealedplds'] = "Sealed P (LDS)";
		$text['sealedslds'] = "Sealed S (LDS)";
		$text['otherspouse'] = "Dal�� man�el/ka";
		//changed in 7.0.0
		$text['husband'] = "Man�el";
		$text['wife'] = "Man�elka";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "Nar.";
		$text['capaltbirthabbr'] = "Nar.";
		$text['capdeathabbr'] = "Zem�.";
		$text['capburialabbr'] = "Poh�.";
		$text['capplaceabbr'] = "v";
		$text['capmarrabbr'] = "Svat.";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Zobrazit s";
		$text['scrollnote'] = "Pozn.: Pokud je t�eba, pou�ijte ke zobrazen� cel�ho obr�zku li�ty.";
		$text['unknownlit'] = "Nezn�m�";
		$text['popupnote1'] = " = Dal�� informace";
		$text['popupnote2'] = " = Nov� rodokmen";
		$text['pedcompact'] = "Kompaktn�";
		$text['pedstandard'] = "Standardn�";
		$text['pedtextonly'] = "Pouze text";
		$text['descendfor'] = "Potomci pro";
		$text['maxof'] = "Nejv�ce";
		$text['gensatonce'] = "generac� zobrazen�ch najednou.";
		$text['sonof'] = "syn";
		$text['daughterof'] = "dcera";
		$text['childof'] = "d�t�";
		$text['stdformat'] = "Standardn� form�t";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "P�idat novou rodinu";
		$text['editfam'] = "Upravit rodinu";
		$text['side'] = "Str�nka";
		$text['familyof'] = "Rodina";
		$text['paternal'] = "Otcovsk�";
		$text['maternal'] = "Mate�sk�";
		$text['gen1'] = "Vlastn�";
		$text['gen2'] = "Rodi�e";
		$text['gen3'] = "Prarodi�e";
		$text['gen4'] = "Pra-prarodi�e";
		$text['gen5'] = "Druz� pra-prarodi�e";
		$text['gen6'] = "T�et� pra-prarodi�e";
		$text['gen7'] = "�tvrt� pra-prarodi�e";
		$text['gen8'] = "P�t� pra-prarodi�e";
		$text['gen9'] = "�est� pra-prarodi�e";
		$text['gen10'] = "Sedm� pra-prarodi�e";
		$text['gen11'] = "Osm� pra-prarodi�e";
		$text['gen12'] = "Dev�t� pra-prarodi�e";
		$text['graphdesc'] = "Graf potomk� a� do tohoto m�sta";
		$text['collapse'] = "Sbalit";
		$text['expand'] = "Rozbalit";
		$text['pedbox'] = "R�me�ek";
		//changed in 6.0.0
		$text['regformat'] = "Registrov� form�t";
		$text['extrasexpl'] = "Pokud existuj� fotografie nebo historie pro n�sleduj�c� osoby, p��slu�n� ikony budou zobrazeny vedle jmen.";
		//added in 6.0.0
		$text['popupnote3'] = " = New chart";
		$text['mediaavail'] = "Media Available";
		//changed in 7.0.0
		$text['pedigreefor'] = "Rodokmen-V�vod pro";
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
		$text['noreports'] = "��dn� v�pis neexistuje.";
		$text['reportname'] = "N�zev v�pisu";
		$text['allreports'] = "V�echny v�pisy";
		$text['report'] = "V�pis";
		$text['error'] = "Chyba";
		$text['reportsyntax'] = "Syntaxe dotazu pro tento v�pis";
		$text['wasincorrect'] = "byla chybn� a v�pis nemohl b�t vytvo�en. Kontaktujte pros�m administr�tora syst�mu na";
		$text['query'] = "Dotaz";
		$text['errormessage'] = "Chybov� hl�en�";
		$text['equals'] = "je";
		$text['contains'] = "obsahuje";
		$text['startswith'] = "za��n� s";
		$text['endswith'] = "kon�� s";
		$text['soundexof'] = "soundex";
		$text['metaphoneof'] = "metaphone of";
		$text['plusminus10'] = "+/- 10 rok� od";
		$text['lessthan'] = "m�n� ne�";
		$text['greaterthan'] = "v�ce ne�";
		$text['lessthanequal'] = "m�n� nebo rovno";
		$text['greaterthanequal'] = "v�ce nebo rovno";
		$text['equalto'] = "rovno";
		$text['tryagain'] = "Zkusit znovu";
		$text['text_for'] = "pro";
		$text['searchnames'] = "Hled�n� jmen";
		$text['joinwith'] = "Logika hled�n�";
		$text['cap_and'] = "A";
		$text['cap_or'] = "NEBO";
		$text['showspouse'] = "Zobrazit man�ela/ku (zobraz� v�ce z�znam� pokud m�la doty�n� osoba v�ce man�el�/ek)";
		$text['submitquery'] = "Prov�st dotaz";
		$text['birthplace'] = "M�sto narozen�";
		$text['deathplace'] = "M�sto �mrt�";
		$text['birthdatetr'] = "Rok narozen�";
		$text['deathdatetr'] = "Rok �mrt�";
		$text['plusminus2'] = "+/- 2 roky od";
		$text['resetall'] = "Nastavit hodnoty formul��e na p�vodn�";

		$text['showdeath'] = "Zobrazit informace o �mrt�/poh�bu";
		$text['altbirthplace'] = "M�sto k�tu";
		$text['altbirthdatetr'] = "Rok k�tu";
		$text['burialplace'] = "M�sto poh�bu";
		$text['burialdatetr'] = "Rok poh�bu";
		$text['event'] = "Ud�lost(i)";
		$text['day'] = "Den";
		$text['month'] = "M�s�c";
		$text['keyword'] = "Kl��ov� slovo (nap�. \"Abt\")";
		$text['explain'] = "Zadejte datum pro zobrazen� odpov�daj�c�ch ud�lost�. Zanechte pole pr�zdn� pro zobrazen� v�ech ud�lost�.";
		$text['enterdate'] = "Zadejte nebo zvolte alespo� jedno z n�sleduj�c�ch: Den, M�s�c, Rok, Kl��ov� slovo";
		$text['fullname'] = "Cel� jm�no";
		$text['birthdate'] = "Datum narozen�";
		$text['altbirthdate'] = "Datum k�tu";
		$text['marrdate'] = "Datum svatby";
		$text['spouseid'] = "ID man�ela/ky";
		$text['spousename'] = "Jm�no man�ela/ky";
		$text['deathdate'] = "Datum �mrt�";
		$text['burialdate'] = "Datum poh�bu";
		$text['changedate'] = "Datum posledn� zm�ny";
		$text['gedcom'] = "Rodokmen (Tree)";
		$text['baptdate'] = "LDS datum k�tu";
		$text['baptplace'] = "LDS m�sto k�tu";
		$text['endldate'] = "LDS datum zasl�ben�";
		$text['endlplace'] = "LDS m�sto zasl�ben�";
		$text['ssealdate'] = "LDS Man�elsk� slou�en�/datum";
		$text['ssealplace'] = "LDS Man�elsk� slou�en�/m�sto";
		$text['psealdate'] = "LDS Slou�en� s rodi�i/datum";
		$text['psealplace'] = "LDS Slou�en� s rodi�i/m�sto";
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
		$text['otherevents'] = "Jin� ud�losti";
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
		$text['logfilefor'] = "Soubor z�znam� pro";
		$text['mostrecentactions'] = "Ned�vn� aktivita";
		$text['autorefresh'] = "Automatick� zobrazen� (po 30 vte�in�ch)";
		$text['refreshoff'] = "Vypnout automatick� zobrazen�";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "H�bitovy a n�hrobky";
		$text['showallhsr'] = "Zobrazit v�echny z�znamy n�hrobk�";
		$text['in'] = "v";
		$text['showmap'] = "Uk�zat mapu";
		$text['headstonefor'] = "N�hrobek pro";
		$text['photoof'] = "Fotografie";
		$text['firstpage'] = "Prvn� str�nka";
		$text['lastpage'] = "Posledn� str�nka";
		$text['photoowner'] = "Majitel/Pramen";

		$text['nocemetery'] = "H�bitov nen� uveden";
		$text['iptc005'] = "N�zev";
		$text['iptc020'] = "Podporovan� kategorie";
		$text['iptc040'] = "Zvl�tn� instrukce";
		$text['iptc055'] = "Datum vytvo�en�";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Autorova funkce";
		$text['iptc090'] = "M�sto/Obec";
		$text['iptc095'] = "St�t";
		$text['iptc101'] = "Zem�";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Nadpis";
		$text['iptc110'] = "Pramen";
		$text['iptc115'] = "Zdroj fotografie";
		$text['iptc116'] = "Ve�ker� pr�va vyhrazena";
		$text['iptc120'] = "Popis";
		$text['iptc122'] = "Popis vytvo�il";
		$text['mapof'] = "Mapa";
		$text['regphotos'] = "Zobrazen� s popisem";
		$text['gallery'] = "Poze n�hledy";
		$text['cemphotos'] = "Obr�zky h�bitov�";
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
		$text['surnamesstarting'] = "Zobrazit p��jmen� za��naj�c� na";
		$text['showtop'] = "Zobrazit prvn�ch";
		$text['showallsurnames'] = "Zobrazit v�echna p��jmen�";
		$text['sortedalpha'] = "se�azen� podle abecedy";
		$text['byoccurrence'] = "se�azen� podle �etnosti";
		$text['firstchars'] = "Za��te�n� p�smena";
		$text['top'] = "Za��tek";
		$text['mainsurnamepage'] = "Hlavn� str�nka p��jmen�";
		$text['allsurnames'] = "V�echna p��jmen�";
		$text['showmatchingsurnames'] = "Kliknut�m na p��jmen� zobrazte p��slu�n� z�znamy.";
		$text['backtotop'] = "Zp�t na za��tek";
		$text['beginswith'] = "Za��n� na";
		$text['allbeginningwith'] = "V�echna p��jmen� za��naj�c� na";
		$text['numoccurrences'] = "po�et v�skyt� v z�vork�ch";
		$text['placesstarting'] = "Show largest localities starting with";
		$text['showmatchingplaces'] = "Kliknut�m na p��jmen� zobrazte odpov�daj�c� z�znamy.";
		$text['totalnames'] = "celkem osob";
		$text['showallplaces'] = "Zobrazit nejv�t�� m�sta";
		$text['totalplaces'] = "celkem m�st";
		$text['mainplacepage'] = "Hlavn� str�nka m�st";
		$text['allplaces'] = "V�echna nejv�t�� m�sta";
		$text['placescont'] = "Zobrazit v�echna m�sta obsahuj�c�";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(minul�ch xx dnech)";
		$text['historiesdocs'] = "Historie";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Fotografie";
		$text['history'] = "Historie/dokument";
		//changed in 7.0.0
		$text['husbid'] = "ID man�ela";
		$text['husbname'] = "Jm�no man�ela";
		$text['wifeid'] = "ID man�elky";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Vymazat";
		$text['addperson'] = "P�idat osobu";
		$text['nobirth'] = "N�sleduj�c� osoba nem� platn� datum narozen� a proto nebyla p�id�na";
		$text['noliving'] = "Nasleduj�c� osoba je�t� �ije a nebyla p�id�na proto�e nem�te pat�i�n� povolen�";
		$text['event'] = "Ud�lost(i)";
		$text['chartwidth'] = "Chart width";
		//changed in 6.0.0
		$text['timelineinstr'] = "P�idejte a� �ty�i dal�� osoby zad�n�m jejich ID:";
		//added in 6.0.0
		$text['togglelines'] = "Toggle Lines";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Prohl�dnout v�echny rodokmeny";
		$text['treename'] = "N�zev rodokmenu";
		$text['owner'] = "Majitel";
		$text['address'] = "Adresa";
		$text['city'] = "Obec";
		$text['state'] = "St�t/Kraj";
		$text['zip'] = "PS�";
		$text['country'] = "Zem�";
		$text['email'] = "E-mail";
		$text['phone'] = "Telefon";
		$text['username'] = "U�ivatelsk� jm�no";
		$text['password'] = "Heslo";
		$text['loginfailed'] = "Chyba p�ihl�en�.";

		$text['regnewacct'] = "Registrace pro nov� ��et";
		$text['realname'] = "Va�e jm�no a p��jmen�";
		$text['phone'] = "Telefon";
		$text['email'] = "E-mail";
		$text['address'] = "Adresa";
		$text['comments'] = "Pozn�mky";
		$text['submit'] = "Odeslat";
		$text['leaveblank'] = "(zanechte toto pole pr�zdn� pokud ��d�te o nov� rodokmen)";
		$text['required'] = "Tyto �daje je nutn� vyplnit";
		$text['enterpassword'] = "Zadejte heslo.";
		$text['enterusername'] = "Zadejte u�ivatelsk� jm�no.";
		$text['failure'] = "Zadan� u�ivatelsk� jm�no je ji� vyhrazen�. Stisknut�m tla��tka zp�t se vra�te na p�edchoz� str�nku a zvolte si j�n� u�ivatelsk� jm�no";
		$text['success'] = "Va�e registrace prob�hla �sp�n�. Administr�tor syst�mu v�s bude informovat kdy bude v� ��et aktivov�n nebo pokud budou pot�eba dal�� informace.";
		$text['emailsubject'] = "��dost o novou registraci";
		$text['emailmsg'] = "Byla pod�na nov� ��dost o nov� u�ivatelsk� ��et.  P�ihla�te se do TNG Administrace a upravte pat�i�n� povolen� pro tento nov� ��et.  O schv�len� nebo zam�tnut� registrace informujte �adatele odpov�zen�m na tuto email.";
		//changed in 5.0.0
		$text['enteremail'] = "Zadejte pros�m platnou emailovou adresu.";
		$text['website'] = "Internetov� str�nky";
		$text['nologin'] = "Nem�te p�ihla�ovac� informace?";
		$text['loginsent'] = "Informace byly odesl�ny";
		$text['loginnotsent'] = "P�ihla�ovac� informace nebyly odesl�ny";
		$text['enterrealname'] = "Zadejte pros�m sv� skute�n� jm�no.";
		$text['rempass'] = "Z�sta�te p�ipojeni na tento po��ta�";
		$text['morestats'] = "Dal�� statistika";
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
		$text['quantity'] = "Po�et";
		$text['totindividuals'] = "Celkem osob";
		$text['totmales'] = "Celkem mu��";
		$text['totfemales'] = "Celkem �en";
		$text['totunknown'] = "Celkem neur�en�ho pohlav�";
		$text['totliving'] = "Celkem �ij�c�ch";
		$text['totfamilies'] = "Celkem rodin";
		$text['totuniquesn'] = "Celkem r�zn�ch p��jmen�";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Celkem pramen�";
		$text['avglifespan'] = "Pr�m�rn� d�lka �ivota";
		$text['earliestbirth'] = "Nejd��ve narozen�";
		$text['longestlived'] = "Osoby, kter� se do�ily nejvy���ho v�ku";
		$text['years'] = "rok�";
		$text['days'] = "dn�";
		$text['age'] = "V�k";
		$text['agedisclaimer'] = "V�po�ty spojen� s v�kem se zakl�daj� na �daj�ch osob s udan�m datem narozen� <EM>a</EM> �mrt�.  Pokud jsou n�kter� data ne�pln� (nap�., �mrt� zaznamen�no pouze jako rok \"1945\" nebo \"BEF 1860\"), v�kov� v�po�ty nebudou 100% p�esn�.";
		$text['treedetail'] = "Dal�� informace o tomto rodokmenu";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Prohl�dnout v�echny pozn�mky";
		break;

	case "help":
		$text['menuhelp'] = "N�pov�da nab�dky";
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
$text['matches'] = "Z�znamy";
$text['description'] = "Popis";
$text['notes'] = "Pozn�mky";
$text['status'] = "Stav";
$text['newsearch'] = "Nov� hled�n�";
$text['pedigree'] = "V�vod";
$text['birthabbr'] = "nar.";
$text['chrabbr'] = "k�.";
$text['seephoto'] = "Prohl�dnout fotografii";
$text['andlocation'] = "& m�sto";
$text['accessedby'] = "z�znam prohl�el";
$text['go'] = "Jdi";
$text['family'] = "Rodina";
$text['children'] = "D�ti";
$text['tree'] = "Rodokmen";
$text['alltrees'] = "V�echny rodokmeny";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "N�hled";
$text['people'] = "Lid�";
$text['title'] = "Titul";
$text['suffix'] = "Sufix";
$text['nickname'] = "P�ezd�vka";
$text['deathabbr'] = "zem�.";
$text['lastmodified'] = "Posledn� zm�na";
$text['married'] = "�enat�/vdan�";
//$text['photos'] = "Photos";
$text['name'] = "Jm�no";
$text['lastfirst'] = "P��jmen�, jm�no";
$text['bornchr'] = "Datum a m�sto narozen�";
$text['individuals'] = "Osoby";
$text['families'] = "Rodiny";
$text['personid'] = "ID osoby";
$text['sources'] = "Prameny";
$text['unknown'] = "Nezn�m�";
$text['father'] = "Otec";
$text['mother'] = "Matka";
$text['born'] = "Narozen�";
$text['christened'] = "Pok�t�n";
$text['died'] = "�mrt�";
$text['buried'] = "Poh�eb";
$text['spouse'] = "Man�el/ka";
$text['parents'] = "Rodi�e";
$text['text'] = "Text";
$text['language'] = "Jazyk";
$text['burialabbr'] = "poh�.";
$text['descendchart'] = "Rozrod";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Osoba";
$text['edit'] = "Upravit";
$text['date'] = "Datum";
$text['place'] = "M�sto";
$text['login'] = "P�ihl�sit";
$text['logout'] = "Odhl�sit";
$text['marrabbr'] = "m.";
$text['groupsheet'] = "Seznam skupiny/rodiny";
$text['text_and'] = "a";
$text['generation'] = "Generace";
$text['filename'] = "N�zev souboru";
$text['id'] = "ID";
$text['search'] = "Hledat";
$text['living'] = "�ij�c�";
$text['user'] = "U�ivatel";
$text['firstname'] = "Jm�no";
$text['lastname'] = "P��jmen�";
$text['searchresults'] = "V�sledky hled�n�";
$text['diedburied'] = "Zem�el/poh�ben";
$text['homepage'] = "Hlavn� str�nka";
$text['find'] = "Naj�t(osobu)";
$text['relationship'] = "P��buzensk� vztah";
$text['relationship2'] = "Relationship";
$text['timeline'] = "�asov� linie";
$text['yesabbr'] = "A";
$text['divorced'] = "Rozveden�/�";
$text['indlinked'] = "Odkaz na";
$text['branch'] = "V�tev";
$text['moreind'] = "Dal�� osoby";
$text['morefam'] = "Dal�� rodiny";
$text['livingdoc'] = "Alespo� jedna �ij�c� osoba m� odkaz na tento dokument - podrobnosti nezve�ejn�ny.";
$text['source'] = "Pramen";
$text['surnamelist'] = "Seznam p��jmen�";
$text['generations'] = "Po�et generac�";
$text['refresh'] = "Obnovit";
$text['whatsnew'] = "Co je nov�ho";
$text['reports'] = "V�pisy";
$text['placelist'] = "Seznam m�st";
$text['baptizedlds'] = "Pok�t�n (LDS)";
$text['endowedlds'] = "Endowed (LDS)";
$text['sealedplds'] = "Sealed P (LDS)";
$text['sealedslds'] = "Sealed S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "p�edci";
$text['descendants'] = "potomci";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Datum posledn�ho GEDCOM importu";
$text['type'] = "Druh";
$text['savechanges'] = "Ulo�it zm�ny";
$text['familyid'] = "ID rodiny";
$text['headstone'] = "N�hrobky";
$text['historiesdocs'] = "Historie";
$text['livingnote'] = "Alespo� jedna �ij�c� osoba m� odkaz na tuto pozn�mku - podrobnosti nezve�ejn�ny.";
$text['anonymous'] = "anonymn�";
$text['places'] = "M�sta";
$text['anniversaries'] = "Datumy a v�ro��";
$text['administration'] = "Administrace";
$text['help'] = "N�pov�da";
//$text['documents'] = "Documents";
$text['year'] = "Rok";
$text['all'] = "V�echny";
$text['repository'] = "Depozit��";
$text['address'] = "Adresa";
$text['suggest'] = "Navrhnout";
$text['editevent'] = "Navrhnout zm�nu pro tuto ud�lost";
$text['findplaces'] = "Naj�t v�echny osoby s u�lostmi v tomto m�st�";
$text['morelinks'] = "V�ce odkaz�";
$text['faminfo'] = "Informace o rodin�";
$text['persinfo'] = "Osobn� informace";
$text['srcinfo'] = "Informace o pramenu";
$text['fact'] = "Fakt";
$text['goto'] = "Zvolte str�nku";
$text['tngprint'] = "Print";
//changed in 6.0.0
$text['livingphoto'] = "Alespo� jedna �ij�c� osoba m� odkaz na tuto fotografii - podrobnosti nezve�ejn�ny.";
$text['databasestatistics'] = "Statistika datab�ze";
//moved here in 6.0.0
$text['child'] = "D�t�";
$text['repoinfo'] = "Informace o depozit��i";
$text['tng_reset'] = "P�vodn� nastaven� (Reset)";
$text['noresults'] = "��dn� v�sledky nebyly nalezeny";
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
$text['cemetery'] = "H�bitov";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Event Map";
$text['gevents'] = "Event";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Link to Google Earth";
$text['googlemaplink'] = "Link to Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "Neozna�en�";
$text['located'] = "Nach�zej�c� se";
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
$text['mnuheader'] = "Hlavn� str�nka";
$text['mnusearchfornames'] = "Hledat jm�na";
$text['mnulastname'] = "P��jmen�";
$text['mnufirstname'] = "Jm�no";
$text['mnusearch'] = "Hledat";
$text['mnureset'] = "Za��t znavu";
$text['mnulogon'] = "P�ihl�sit";
$text['mnulogout'] = "Odhl�sit";
$text['mnufeatures'] = "Dal�� mo�nosti";
$text['mnuregister'] = "Registrace pro nov� ��et";
$text['mnuadvancedsearch'] = "Roz���en� hled�n�";
$text['mnulastnames'] = "P��jmen�";
$text['mnustatistics'] = "Statistika";
$text['mnuphotos'] = "Fotografie";
$text['mnuhistories'] = "Historie a p�semnosti";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "H�bitovy";
$text['mnutombstones'] = "N�hrobky";
$text['mnureports'] = "V�pisy";
$text['mnusources'] = "Zdroje";
$text['mnuwhatsnew'] = "Co je nov�ho";
$text['mnushowlog'] = "Z�znam p��stup�";
$text['mnulanguage'] = "Zm�nit jazyk";
$text['mnuadmin'] = "Administrace";
$text['welcome'] = "V�tejte";
$text['contactus'] = "Napi�te n�m";

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
