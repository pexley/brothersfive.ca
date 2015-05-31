<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Navigheaza prin toate sursele";
		$text['shorttitle'] = "Titlu scurt";
		$text['callnum'] = "Numar telefon";
		$text['author'] = "Autor";
		$text['publisher'] = "Editor";
		$text['other'] = "Alte informatii";
		$text['sourceid'] = "ID Sursa";
		$text['moresrc'] = "Mai multe surse";
		$text['repoid'] = "ID depozit";
		$text['browseallrepos'] = "Navigheaza prin toate depozitele";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Adauga limba";
		$text['changelanguage'] = "Schimba Limba";
		$text['languagesaved'] = "Limba adaugata";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM incepe de la";
		$text['producegedfrom'] = "Creaza un fiser GEDCOM din";
		$text['numgens'] = "Numar de generatii";
		$text['includelds'] = "Informatii cuprins LDS ";
		$text['buildged'] = "Creeaza GEDCOM";
		$text['gedstartfrom'] = "GEDCOM incepe de la";
		$text['nomaxgen'] = "Trebuie sa indica-ti numarul maxim de generatii. Va rugam utiliza-ti butonul Inapoi pentru a revenii la pagina anterioara si a corecta eroarea";
		$text['gedcreatedfrom'] = "GEDCOM creeat de la";
		$text['gedcreatedfor'] = "creat pentru";

		$text['enteremail'] = "Va rugam sa introduceti o adresa de mail valida.";
		$text['creategedfor'] = "Creeaza GEDCOM";
		$text['email'] = "Adresa email";
		$text['suggestchange'] = "Sugereaza o schimbare";
		$text['yourname'] = "Numele dumneavoastra";
		$text['comments'] = "Note sau comentarii";
		$text['comments2'] = "Comentarii";
		$text['submitsugg'] = "Trimite sugestie";
		$text['proposed'] = "Propune schimbare";
		$text['mailsent'] = "Va multumim. Mesajul dumneavoastra a fost trimis.";
		$text['mailnotsent'] = "Ne pare rau, dar mesajul dumneavoastra nu poate fi livrat.Va rugam contactati xxx direct la yyy.";
		$text['mailme'] = "Trimit o copie la aceasta adresa";
		//added in 5.0.5
		$text['entername'] = "Va rugam introduceti numele dumneavoastra";
		$text['entercomments'] = "Va rugam introduceti comentariile dumneavoastra";
		$text['sendmsg'] = "Trimite mesaj";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Imagini si povestiri/istorioare pentru";
		$text['indinfofor'] = "Informatii personala pentru";
		$text['reliability'] = "Secutitate";
		$text['pp'] = "pag.";
		$text['age'] = "Varsta";
		$text['agency'] = "Agentie";
		$text['cause'] = "Motiv";
		$text['suggested'] = "Sugerat";
		$text['closewindow'] = "Inchide aceasta fereastra";
		$text['thanks'] = "Va multumim";
		$text['received'] = "Sugestia dumneavoastra a fost trimisa la administratorii site-ului pentru verificare.";
		//added in 6.0.0
		$text['association'] = "Asociere";
		//added in 7.0.0
		$text['indreport'] = "Individual Report";
		$text['indreportfor'] = "Individual Report for";
		$text['general'] = "General";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Calculator rudenie";
		$text['findrel'] = "Gaseste rudenie";
		$text['person1'] = "Persoana 1:";
		$text['person2'] = "Persoana 2:";
		$text['calculate'] = "Calculeaza";
		$text['select2inds'] = "Va rugam selectati doua persoane.";
		$text['findpersonid'] = "Gaseste ID persoana";
		$text['enternamepart'] = "introduceti partial prenumele si/sau numele familie";
		$text['pleasenamepart'] = "Va rugam introduceti o parte din prenume sau numele de familie.";
		$text['clicktoselect'] = "Apasa sa selectezi";
		$text['nobirthinfo'] = "Fara informatii nastere";
		$text['relateto'] = "Rudenie lui";
		$text['sameperson'] = "Doi indivizi sunt aceeasi persoana.";
		$text['notrelated'] = "Doua persoane nu sunt inrudita pana la xxx generatii.";
		$text['findrelinstr'] = "Afisare relatii intre doua persoane, utilizeaza 'gasire' butoaneele de mai jos la localizare indivizi (sau pastreaza persoana afisata), si apasati 'Calculare'.";
		$text['gencheck'] = "Maxim generatii <br />verificate";
		$text['sometimes'] = "(Uneori verificand dupa un numar diferit de generatii campurile rezultate pot fi diferite.)";
		$text['findanother'] = "Gaseste alta rudenie";
		//added in 6.0.0
		$text['brother'] = "fratele lui";
		$text['sister'] = "sora lui";
		$text['sibling'] = "sotul lui";
		$text['uncle'] = "unchi de gradul xxx al lui";
		$text['aunt'] = "matusa de gradul xxx al lui";
		$text['uncleaunt'] = "unchiul/matusa de gradul xxx al lui";
		$text['nephew'] = "nepotul de gradul xxx a lui";
		$text['niece'] = "nepoata de gradul xxx a lui";
		$text['nephnc'] = "nepotul/nepoata xxx lui";
		$text['mcousin'] = "varul de gradul xxx a lui";
		$text['fcousin'] = "vara de gradul xxx a lui";
		$text['cousin'] = "varul de gard xxx a lui";
		$text['removed'] = "timpuri sterse";
		$text['rhusband'] = "sotul lui ";
		$text['rwife'] = "sotia lui ";
		$text['rspouse'] = "soti lui ";
		$text['son'] = "fiul lui";
		$text['daughter'] = "sora lui";
		$text['rchild'] = "copii lui";
		$text['sil'] = "ginerele lui";
		$text['dil'] = "nora lui";
		$text['sdil'] = "ginere sau nora lui";
		$text['gson'] = "nepotul xxx lui";
		$text['gdau'] = "nepoata xxx lui";
		$text['gsondau'] = "nepotul/nepoata xxx lui";
		$text['great'] = "stra";
		$text['spouses'] = "sunt soti";
		$text['is'] = "este";
		//changed in 6.0.0
		$text['changeto'] = "Schimba la (introduceti ID-ul):";
		//added in 6.0.0
		$text['notvalid'] = "nu este ID persona valid sau nu exista in baza de date. Va rugam incercati din nou.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Schema grup familie pentru";
		$text['ldsords'] = "Ordine LDS";
		$text['baptizedlds'] = "Botez (LDS)";
		$text['endowedlds'] = "Endowed (LDS)";
		$text['sealedplds'] = "Casatorie P (LDS)";
		$text['sealedslds'] = "Casatorie S (LDS)";
		$text['otherspouse'] = "Alt sot(ie)";
		//changed in 7.0.0
		$text['husband'] = "Sot";
		$text['wife'] = "Sotie";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "N";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "I";
		$text['capplaceabbr'] = "L";
		$text['capmarrabbr'] = "C";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Reinoit cu";
		$text['scrollnote'] = "Note: Trebuie sa rasfoiti in jos sau in dreapta pentru a vedea grafic.";
		$text['unknownlit'] = "Necunoscut";
		$text['popupnote1'] = " = Informati suplimentare";
		$text['popupnote2'] = " = Arbore nou";
		$text['pedcompact'] = "Compact";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Text";
		$text['descendfor'] = "Urmasi lui";
		$text['maxof'] = "Maxim de";
		$text['gensatonce'] = "generatii afisate odata.";
		$text['sonof'] = "fiul lui";
		$text['daughterof'] = "fiica lui";
		$text['childof'] = "copilul lui";
		$text['stdformat'] = "Format standard";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "Adauga familie noua";
		$text['editfam'] = "Editeaza familie";
		$text['side'] = "parte";
		$text['familyof'] = "Familia lui";
		$text['paternal'] = "Din partea tatei";
		$text['maternal'] = "Din partea mamei";
		$text['gen1'] = "Proprie";
		$text['gen2'] = "Parinti";
		$text['gen3'] = "Bunici";
		$text['gen4'] = "Strabunici";
		$text['gen5'] = "Stra strabunici";
		$text['gen6'] = "Strabunici de gradul 3";
		$text['gen7'] = "Strabunici de gradul 4";
		$text['gen8'] = "Strabunici de gradul 5";
		$text['gen9'] = "Strabunici de gradul 6";
		$text['gen10'] = "Strabunici de gradul 7";
		$text['gen11'] = "Strabunici de gradul 8";
		$text['gen12'] = "Strabunici de gradul 9";
		$text['graphdesc'] = "Grafic urmasi din acest punct";
		$text['collapse'] = "Restrange";
		$text['expand'] = "Extinde";
		$text['pedbox'] = "Casuta";
		//changed in 6.0.0
		$text['regformat'] = "Inregistrare";
		$text['extrasexpl'] = "= Macar o imagine, povestire sau alt articol media exista pentru aceasta persoana.";
		//added in 6.0.0
		$text['popupnote3'] = " = Grafic nou";
		$text['mediaavail'] = "Media disponibil";
		//changed in 7.0.0
		$text['pedigreefor'] = "Arbore genealogic pentru";
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
		$text['noreports'] = "Nu exista rapoarte existente.";
		$text['reportname'] = "Nume raport";
		$text['allreports'] = "Toate rapoartele";
		$text['report'] = "Raport";
		$text['error'] = "Eroare";
		$text['reportsyntax'] = "Sintaxa intrebarii rulate cu acest raport";
		$text['wasincorrect'] = "a fost incorecta, si ca rezultat raportul nu poate fi rulat. Va rugam contactati administratorul sistemului la";
		$text['query'] = "Cauta";
		$text['errormessage'] = "Mesaj eroare";
		$text['equals'] = "egalitati";
		$text['contains'] = "continut";
		$text['startswith'] = "Incepe cu";
		$text['endswith'] = "sfarseste cu";
		$text['soundexof'] = "Efecte ";
		$text['metaphoneof'] = "sunet la";
		$text['plusminus10'] = "+/- 10 ani de la";
		$text['lessthan'] = "mai mic ca";
		$text['greaterthan'] = "mai mare ca";
		$text['lessthanequal'] = "mai mic sau egal cu";
		$text['greaterthanequal'] = "mai mare sau egal cu";
		$text['equalto'] = "egal cu";
		$text['tryagain'] = "Va rugam incercati din nou";
		$text['text_for'] = "pentru";
		$text['searchnames'] = "Cauta dupa Nume";
		$text['joinwith'] = "Alaturate cu";
		$text['cap_and'] = "SI";
		$text['cap_or'] = "SAU";
		$text['showspouse'] = "Afiseaza soti (va afisa duplicate daca persoana are mai mult de un sot)";
		$text['submitquery'] = "Trimite cerere";
		$text['birthplace'] = "Loc nastere";
		$text['deathplace'] = "Loc deces";
		$text['birthdatetr'] = "An nastere";
		$text['deathdatetr'] = "An deces";
		$text['plusminus2'] = "+/- 2 ani de la";
		$text['resetall'] = "Reseteaza toate valorile";

		$text['showdeath'] = "Afiseaza informatii deces/inmormantare";
		$text['altbirthplace'] = "Loc botez";
		$text['altbirthdatetr'] = "An botez";
		$text['burialplace'] = "Loc inmormantare";
		$text['burialdatetr'] = "An inmormantare";
		$text['event'] = "Eveniment(e)";
		$text['day'] = "zi";
		$text['month'] = "luna";
		$text['keyword'] = "Cuvant cheie (ie, \"Abt\")";
		$text['explain'] = "Introduceti datele componenente pentru a vedea evenimentele care corespund. Lasa acest camp necompletata pentru a vedea potriviri pentru toate.";
		$text['enterdate'] = "Va rugam introduceti sau selectati cel putin una dintre urmatoarele: zi, luna, an, cuvant cheie";
		$text['fullname'] = "Nume complet";
		$text['birthdate'] = "Data nastere";
		$text['altbirthdate'] = "Data botez";
		$text['marrdate'] = "Data casatorie";
		$text['spouseid'] = "ID sot";
		$text['spousename'] = "Nume sot/sotie";
		$text['deathdate'] = "Data deces";
		$text['burialdate'] = "Data inmormantare";
		$text['changedate'] = "Data ultimei modificari";
		$text['gedcom'] = "Arbore";
		$text['baptdate'] = "Data botez(LDS)";
		$text['baptplace'] = "Loc botez (LDS)";
		$text['endldate'] = "Data Endowment (LDS)";
		$text['endlplace'] = "Loc Endowment (LDS)";
		$text['ssealdate'] = "Data casatorie (LDS)";
		$text['ssealplace'] = "Loc casatorie (LDS)";
		$text['psealdate'] = "Data casatorie parinti (LDS)";
		$text['psealplace'] = "Loc casatorie pararinti (LDS)";
		$text['marrplace'] = "Loc casatorie";
		$text['spousesurname'] = "Nume familie sot";
		//changed in 6.0.0
		$text['spousemore'] = "Daca introduceti o valoare pentru nume familie sot/sotie, trebuie sa selectati gen.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 ani de la";
		$text['exists'] = "exista";
		$text['dnexist'] = "nu exista";
		//added in 6.0.3
		$text['divdate'] = "Data divort";
		$text['divplace'] = "Loc divort";
		//changed in 7.0.0
		$text['otherevents'] = "Alte evenimente";
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
		$text['logfilefor'] = "Fisier loc pentru";
		$text['mostrecentactions'] = "Actiunile cele mai recente";
		$text['autorefresh'] = "Reimprospatare automata (30 secunde)";
		$text['refreshoff'] = "Opreste reimprospatare automata";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cimitire si pietre funerare";
		$text['showallhsr'] = "Afiseaza toate inregistrarile pietre funerare";
		$text['in'] = "in";
		$text['showmap'] = "Afiseaya harta";
		$text['headstonefor'] = "Piatra funerara pentru";
		$text['photoof'] = "Imaginea lui";
		$text['firstpage'] = "Prima pagina";
		$text['lastpage'] = "Ultima pagina";
		$text['photoowner'] = "Proprietar/Sursa";

		$text['nocemetery'] = "Nici un cimitir";
		$text['iptc005'] = "Titlu";
		$text['iptc020'] = "Categorii Sup.";
		$text['iptc040'] = "Instructiuni speciale";
		$text['iptc055'] = "Data creari";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Functia autorului";
		$text['iptc090'] = "Oras";
		$text['iptc095'] = "Jutet/Stat";
		$text['iptc101'] = "Tara";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Titlu mare";
		$text['iptc110'] = "Sursa";
		$text['iptc115'] = "Sursa imagine";
		$text['iptc116'] = "Notite drepturi de autor";
		$text['iptc120'] = "Titlu articol";
		$text['iptc122'] = "Autor articol";
		$text['mapof'] = "Harta la";
		$text['regphotos'] = "Vezi descriere";
		$text['gallery'] = "Doar miniaturi";
		$text['cemphotos'] = "Imagini cimitir";
		//changed in 6.0.0
		$text['photosize'] = "Dimensiuni";
		//added in 6.0.0
        	$text['iptc010'] = "Prioritate";
		$text['filesize'] = "Dimensiune fisier";
		$text['seeloc'] = "Vezi locatie";
		$text['showall'] = "Afiseaza toate";
		$text['editmedia'] = "Editeaza media";
		$text['viewitem'] = "Vezi aceast articol";
		$text['editcem'] = "Editeaza cimitir";
		$text['numitems'] = "# articole";
		$text['allalbums'] = "Toate albumele";
		//added in 6.1.0
		$text['slidestart'] = "Ruleaza Slide Show";
		$text['slidestop'] = "Pauza Slide Show";
		$text['slideresume'] = "Reluati Slide Show";
		$text['slidesecs'] = "Secunde pentru fiecare slide:";
		$text['minussecs'] = "mai putin cu 0.5 secunde";
		$text['plussecs'] = "mai mult cu 0.5 secunde";
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
		$text['surnamesstarting'] = "Afiseaza numele de familie care incep cu";
		$text['showtop'] = "Afiseaza sus";
		$text['showallsurnames'] = "Afiseaza toate numele de familie";
		$text['sortedalpha'] = "sorteaza alfabetic";
		$text['byoccurrence'] = "ordoneaza la intimplare";
		$text['firstchars'] = "Primele caractere";
		$text['top'] = "Top";
		$text['mainsurnamepage'] = "Meniu pagina nume familie";
		$text['allsurnames'] = "Toate numele de familie";
		$text['showmatchingsurnames'] = "Apasa pe un nume de familie pentru a afisa inregistrari care corespund.";
		$text['backtotop'] = "Inapoi sus";
		$text['beginswith'] = "Incep cu";
		$text['allbeginningwith'] = "Toate numele de familie care incep cu";
		$text['numoccurrences'] = "Numarul total de localitati";
		$text['placesstarting'] = "Afiseaza pe larg localitati care incep cu";
		$text['showmatchingplaces'] = "Apasa pe loc pentru afisare localitati mici. Apasa pe icoana cautare pentru afisare persoanelor potrivite.";
		$text['totalnames'] = "Total persoane";
		$text['showallplaces'] = "Afiseaza toate localitati";
		$text['totalplaces'] = "Total localitati";
		$text['mainplacepage'] = "Pagina meniu locuri";
		$text['allplaces'] = "Toate localitatile pe larg";
		$text['placescont'] = "Afisare toate localitatile continute";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(ultimele xx zile)";
		$text['historiesdocs'] = "Povestioare";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Imagine";
		$text['history'] = "Povestioare/Documente";
		//changed in 7.0.0
		$text['husbid'] = "ID sot";
		$text['husbname'] = "Nume sot";
		$text['wifeid'] = "ID sotie";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Sterge";
		$text['addperson'] = "Adauga persoana";
		$text['nobirth'] = "Urmatoarea persoana nu are o data de nastere valida si nu poate fi adaugata";
		$text['noliving'] = "Urmatoarea persoana este marcata ca in viata si nu poate fi adaugata deoarece nu sunteti conectat cu permisiuni corespunzatoare";
		$text['event'] = "Eveniment(e)";
		$text['chartwidth'] = "Latime grafic";
		//changed in 6.0.0
		$text['timelineinstr'] = "Adauga persoana";
		//added in 6.0.0
		$text['togglelines'] = "Linii alternative";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Rasfoieste toti arborii";
		$text['treename'] = "Nume arbore";
		$text['owner'] = "Proprietar";
		$text['address'] = "Adresa";
		$text['city'] = "Oras";
		$text['state'] = "Jutet/stat";
		$text['zip'] = "Cod postal/zip";
		$text['country'] = "Tara";
		$text['email'] = "Adresa email";
		$text['phone'] = "Telefon";
		$text['username'] = "Nume utilizator";
		$text['password'] = "Parola";
		$text['loginfailed'] = "Conectare esuata.";

		$text['regnewacct'] = "Inregistrare un nou cont utilizator";
		$text['realname'] = "Numele dumneavoastra real";
		$text['phone'] = "Telefon";
		$text['email'] = "Adresa email";
		$text['address'] = "Adresa";
		$text['comments'] = "Note sau comentarii";
		$text['submit'] = "Trimite";
		$text['leaveblank'] = "(lasa necompletat daca soliciti un nou arbore)";
		$text['required'] = "Campuri obligatorii";
		$text['enterpassword'] = "Va rugam introduceti o parola.";
		$text['enterusername'] = "Va rugam introduceti un nume utilizator.";
		$text['failure'] = "Ne apare rau, dar numele de utilizator introdus de dumneavoastra este deja folosit. Va rugam folositi butonul inapoi al browser-ului pentru a reveni la pagina precedenta si alegeti alt nume utilizator.";
		$text['success'] = "Va multumim. Am receptionat inregistrarea dumneavoastra. Va vom contacta cand contul dumneavoastra este activat sau daca avem nevoie de informatii suplimentare.";
		$text['emailsubject'] = "Noua cerere cont utilizator in aborelui familiei dumneavoastra";
		$text['emailmsg'] = "Ati primit o noua cerere cont utilizator in arborele genealogic al familiei. Va rugam conectativa la interfata dumneavoastra de administrare TNG si asociati permisiunile proprii la acest cont nou. Daca aprobati aceasta cerere de inregistrare va rugam notificati solicitantul raspunzand la acest mesaj.";
		//changed in 5.0.0
		$text['enteremail'] = "Va rugam sa introduceti o adresa de mail valida.";
		$text['website'] = "Pagina web";
		$text['nologin'] = "Nu aveti un cont de utilizator?";
		$text['loginsent'] = "Informatii conectare trimise";
		$text['loginnotsent'] = "Informatiile conectare nu au fost trimise";
		$text['enterrealname'] = "Va rugam introduceti numele dumneavoastra real.";
		$text['rempass'] = "Raman conectat pe acest calculator";
		$text['morestats'] = "Mai multe statistici";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTA:</strong> Pentru a primi emailuri de la administratorul site-ului in ceea ce priveste contul dumneavoastra, va rugam asigurati-va ca nu blocati mesajele de la acest domeniu.";
		$text['newpassword'] = "Parola noua";
		$text['resetpass'] = "Reseteaza parola";
		//added in 6.1.0
		$text['nousers'] = "Acest formular nu poate fi utilizat pana cand cel putin o inregistrare utilizator exista. Daca sunteti administrator site, va rugam mergeti la Admin/utilizatori pentru a crea contul dumneavoastra de administrator.";
		//added in 7.0.0
		$text['noregs'] = "We're sorry, but we are not accepting new user registrations at this time. Please <a href=\"suggest.php\">contact us</a> directly if you have comments or questions regarding anything on this site.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Marime";
		$text['totindividuals'] = "Total persoane";
		$text['totmales'] = "Total barbati";
		$text['totfemales'] = "Total femei";
		$text['totunknown'] = "Total gen necunoscut";
		$text['totliving'] = "Total in viata";
		$text['totfamilies'] = "Total familii";
		$text['totuniquesn'] = "Toate nume familie unice";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Total Surse";
		$text['avglifespan'] = "Varsta mediu";
		$text['earliestbirth'] = "Nastere prematura";
		$text['longestlived'] = "Cel mai longeviv";
		$text['years'] = "ani";
		$text['days'] = "zile";
		$text['age'] = "Varsta";
		$text['agedisclaimer'] = "Calculare varstei relatate se bazeaza pe data de nastere <EM>si</EM> deces inregistrata.  Datorita existentei unor campuri incomplete(ex., o data deces listata doar ca  \"1945\" sau \"BEF 1860\"), calcularea acesteia nu poate fi realizata 100%.";
		$text['treedetail'] = "Mai multe informatii pe acest arbore";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Navigheaza toate notele";
		break;

	case "help":
		$text['menuhelp'] = "Meniu ajutor";
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
		$text['exists'] = "exista";
		$text['loginfirst'] = "You must log in first.";
		$text['noop'] = "No operation was performed.";
		break;
}

//common
$text['matches'] = "Afiseaza de la ";
$text['description'] = "Descriere";
$text['notes'] = "Note";
$text['status'] = "Status";
$text['newsearch'] = "Cautare noua";
$text['pedigree'] = "Arbore genealogic";
$text['birthabbr'] = "b.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Veti imagini";
$text['andlocation'] = "&amp; localitate";
$text['accessedby'] = "accesat de";
$text['go'] = "Mergi";
$text['family'] = "Familie";
$text['children'] = "Copii";
$text['tree'] = "Arbore";
$text['alltrees'] = "Toti arborii";
$text['nosurname'] = "[fara nume familie]";
$text['thumb'] = "Mini";
$text['people'] = "Persoane";
$text['title'] = "Titlu";
$text['suffix'] = "Sufix";
$text['nickname'] = "Pseudonim/porecla";
$text['deathabbr'] = "d.";
$text['lastmodified'] = "Ultima modificare";
$text['married'] = "Casatorit";
//$text['photos'] = "Photos";
$text['name'] = "Nume";
$text['lastfirst'] = "Nume familie, Prenume";
$text['bornchr'] = "Nascut/Botezat";
$text['individuals'] = "Persoane";
$text['families'] = "Familii";
$text['personid'] = "ID Persoana";
$text['sources'] = "Sursa";
$text['unknown'] = "Necunoscut";
$text['father'] = "Tata";
$text['mother'] = "Mama";
$text['born'] = "Nastere";
$text['christened'] = "Botez";
$text['died'] = "Deces";
$text['buried'] = "Inmormantare";
$text['spouse'] = "Sot";
$text['parents'] = "Parinti";
$text['text'] = "Text";
$text['language'] = "Limba";
$text['burialabbr'] = "urm.";
$text['descendchart'] = "Urmas";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Persoana";
$text['edit'] = "Editeaza";
$text['date'] = "Data";
$text['place'] = "Locatie";
$text['login'] = "Conectare";
$text['logout'] = "Deconectare";
$text['marrabbr'] = "m.";
$text['groupsheet'] = "Schita grup";
$text['text_and'] = "si";
$text['generation'] = "Generatii";
$text['filename'] = "Nume fisier";
$text['id'] = "ID";
$text['search'] = "Cauta";
$text['living'] = "In viata";
$text['user'] = "Utilizator";
$text['firstname'] = "Prenume";
$text['lastname'] = "Nume familie";
$text['searchresults'] = "Rezultate cautare";
$text['diedburied'] = "Deces/Inmormantare";
$text['homepage'] = "Prima pagina";
$text['find'] = "Gasit...";
$text['relationship'] = "Rudenie";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Program";
$text['yesabbr'] = "Da";
$text['divorced'] = "Divortat";
$text['indlinked'] = "Conectat la";
$text['branch'] = "Ramura";
$text['moreind'] = "Mai multe persoane";
$text['morefam'] = "Mai multe familii";
$text['livingdoc'] = "Cel putin o persoana in viata este conectata la acest document - Detalii .";
$text['source'] = "Sursa";
$text['surnamelist'] = "Lista nume familie";
$text['generations'] = "Generatii";
$text['refresh'] = "Reinprospatare";
$text['whatsnew'] = "Noutati";
$text['reports'] = "Repoarte";
$text['placelist'] = "Lista localitati";
$text['baptizedlds'] = "Botez (LDS)";
$text['endowedlds'] = "Endowed (LDS)";
$text['sealedplds'] = "Casatorie P (LDS)";
$text['sealedslds'] = "Casatorie S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Stramosi";
$text['descendants'] = "Urmasi";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Data ultimului import GEDCOM";
$text['type'] = "Tip";
$text['savechanges'] = "Salveaza Schimbari";
$text['familyid'] = "ID Familie";
$text['headstone'] = "Pietre funerare";
$text['historiesdocs'] = "Povestioare";
$text['livingnote'] = "Cel putin o persoana in viata conectata la aceasta nota - Detalii.";
$text['anonymous'] = "anonim";
$text['places'] = "Locatii";
$text['anniversaries'] = "Date si aniversari";
$text['administration'] = "Administrare";
$text['help'] = "Ajutor";
//$text['documents'] = "Documents";
$text['year'] = "An";
$text['all'] = "Toate";
$text['repository'] = "Depozite";
$text['address'] = "Adresa";
$text['suggest'] = "Sugereaza";
$text['editevent'] = "Sugereaza o schimbare la acest eveniment";
$text['findplaces'] = "Gaseste toate persoanele cu evenimente la aceasta locatie";
$text['morelinks'] = "Mai multe legaturi";
$text['faminfo'] = "Informatii familie";
$text['persinfo'] = "Informatii persoana";
$text['srcinfo'] = "Informatii sursa";
$text['fact'] = "Fact";
$text['goto'] = "Selecteaza o pagine";
$text['tngprint'] = "Tipareste";
//changed in 6.0.0
$text['livingphoto'] = "Cel putin o persoana in viata conectata la acest articol- Detalii.";
$text['databasestatistics'] = "Statistici";
//moved here in 6.0.0
$text['child'] = "Copil";
$text['repoinfo'] = "Informatii depozit";
$text['tng_reset'] = "Reseteaza";
$text['noresults'] = "Nici un rezultat gasit";
//added in 6.0.0
$text['allmedia'] = "Toate media";
$text['repositories'] = "Depozite";
$text['albums'] = "Albume";
$text['cemeteries'] = "Cimitire";
$text['surnames'] = "Nume familii";
$text['dates'] = "Date";
$text['link'] = "Legatura";
$text['media'] = "Media";
$text['gender'] = "Gen";
$text['latitude'] = "Latitudine";
$text['longitude'] = "Longitudine";
$text['bookmarks'] = "Semne de carte";
$text['bookmark'] = "Adauga semn de carte";
$text['mngbookmarks'] = "Dute la semne de carte";
$text['bookmarked'] = "Semn de carte adaugat";
$text['remove'] = "Sterge";
$text['find_menu'] = "Gaseste";
$text['info'] = "Informatie";
//moved here in 6.0.3
$text['cemetery'] = "Cimitir";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Harta eveniment";
$text['gevents'] = "Eveniment";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Legatura la  Google Earth";
$text['googlemaplink'] = "legatura la Google Maps";
$text['gmaplegend'] = "Legenda punct";
//moved here in 7.0.0
$text['unmarked'] = "Ne marcat";
$text['located'] = "Localizat";
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
$text['mnuheader'] = "Home Page";
$text['mnusearchfornames'] = "Cauta";
$text['mnulastname'] = "Nume familie";
$text['mnufirstname'] = "Prenume";
$text['mnusearch'] = "Cauta";
$text['mnureset'] = "Start";
$text['mnulogon'] = "Conectare";
$text['mnulogout'] = "Deconectare";
$text['mnufeatures'] = "Alte articole";
$text['mnuregister'] = "Inregistrare pentru cont utilizator";
$text['mnuadvancedsearch'] = "Cautare avansata";
$text['mnulastnames'] = "Nume familie";
$text['mnustatistics'] = "Statistici";
$text['mnuphotos'] = "Imagini";
$text['mnuhistories'] = "Povestioare";
$text['mnumyancestors'] = "Imagini &amp; povestioare pentru stramosii lui [Person]";
$text['mnucemeteries'] = "Cimitire";
$text['mnutombstones'] = "Pietre funerare";
$text['mnureports'] = "Repoarte";
$text['mnusources'] = "Surse";
$text['mnuwhatsnew'] = "Noutati";
$text['mnushowlog'] = "Log acces";
$text['mnulanguage'] = "Schimba limba";
$text['mnuadmin'] = "Administrare";
$text['welcome'] = "Bine ai venit";
$text['contactus'] = "Contacteaza-ne";

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
