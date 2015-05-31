<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Izvori informacija";
		$text['shorttitle'] = "Kratak naslov";
		$text['callnum'] = "4Call Number";
		$text['author'] = "AUTOR";
		$text['publisher'] = "6Publisher";
		$text['other'] = "Ostale informacije";
		$text['sourceid'] = "IZVOR ID";
		$text['moresrc'] = "Drugi izvori";
		$text['repoid'] = "11Repository ID";
		$text['browseallrepos'] = "12Browse All Repositories";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Novi jezik";
		$text['changelanguage'] = "Promena jezika";
		$text['languagesaved'] = "Aktiviraj odabrani jezik";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM počinje od";
		$text['producegedfrom'] = "Napravi GEDCOM fajl u kome se nalaze";
		$text['numgens'] = "Broj generacija";
		$text['includelds'] = "Uključi LDS informacije";
		$text['buildged'] = "Napravi GEDCOM";
		$text['gedstartfrom'] = "GEDCOM startuje od";
		$text['nomaxgen'] = "Morate da odredite maksimalan broj generacija. Vratite se na prethodnu stranu, koristeći dugme za nazad i ispravite grešku.";
		$text['gedcreatedfrom'] = "GEDCOM napravljen od";
		$text['gedcreatedfor'] = "napravljen za";

		$text['enteremail'] = "Milomo vas upišite važeću E-mail adresu";
		$text['creategedfor'] = "Kreiranje GEDCOM fajlova";
		$text['email'] = "Vaša E-mail adresa";
		$text['suggestchange'] = "Predlog za izmenu ili dopunu podataka";
		$text['yourname'] = "Vaše ime i prezime";
		$text['comments'] = "Komentar";
		$text['comments2'] = "Vaš komentar";
		$text['submitsugg'] = "Pošalji primedbu";
		$text['proposed'] = "Predložena izmena";
		$text['mailsent'] = "Hvala vam. Vaša poruka je poslata.";
		$text['mailnotsent'] = "Žao nam je, ali vaša poruka nemože biti isporučena.";
		$text['mailme'] = "Pošalji kopiju i na ovu adresu";
		//added in 5.0.5
		$text['entername'] = "Zaboravili ste da upišete vaše ime.";
		$text['entercomments'] = "Zaboravili ste da upišite vaš komentar";
		$text['sendmsg'] = "Send Message";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotografije i tekstovi - ";
		$text['indinfofor'] = "Lične informacije - ";
		$text['reliability'] = "Verodostojnost";
		$text['pp'] = "42pp.";
		$text['age'] = "GODINA I DANA";
		$text['agency'] = "Kumstvo";
		$text['cause'] = "Uzrok";
		$text['suggested'] = "Predloženo";
		$text['closewindow'] = "Zatvori prozor";
		$text['thanks'] = "Hvala";
		$text['received'] = "Vaša primedba je prosleđena administratoru.";
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
		$text['relcalc'] = "Izračunavanje stepena srodstva";
		$text['findrel'] = "STEPEN SRODSTVA";
		$text['person1'] = "Osoba 1:";
		$text['person2'] = "Osoba 2:";
		$text['calculate'] = "IZRAČUNAJ";
		$text['select2inds'] = "Odaberite dve osobe.";
		$text['findpersonid'] = "Pronađi lični ID";
		$text['enternamepart'] = "Upišite deo imena i / ili prezimena";
		$text['pleasenamepart'] = "Upišite deo imena ili prezimena.";
		$text['clicktoselect'] = "Kliknite mišem i odaberite";
		$text['nobirthinfo'] = "Nema informacija o rođenju";
		$text['relateto'] = "Srodstvo sa osobom po imenu -";
		$text['sameperson'] = "Ista ososba je odabrana dva puta.";
		$text['notrelated'] = "Ove dve ososbe nisu u srodstvu unazad xxx generacija.";
		$text['findrelinstr'] = "Da bi ste videli stepen srodstva između dve osobe, koristite dugme \\'TRAŽI\\' za pronalaženje osoba (ili zadržite već upisanu osobu), zatim pritisnite dugme \\'IZRAČUNAJ\\'.";
		$text['gencheck'] = "Broj generacija<br />za proveru";
		$text['sometimes'] = "(Ponekad provera za različit broj generacija daje različit rezultat.)";
		$text['findanother'] = "SRODSTVO SA DRUGOM OSOBOM";
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
		$text['changeto'] = "Promeni u:";
		//added in 6.0.0
		$text['notvalid'] = "is not a valid Person ID number or does not exist in this database. Please try again.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Porodični list za - ";
		$text['ldsords'] = "70LDS Ordinances";
		$text['baptizedlds'] = "441Baptized (LDS)";
		$text['endowedlds'] = "442Endowed (LDS)";
		$text['sealedplds'] = "443Sealed P (LDS)";
		$text['sealedslds'] = "444Sealed S (LDS)";
		$text['otherspouse'] = "DRUGI BRAKOVI";
		//changed in 7.0.0
		$text['husband'] = "Suprug";
		$text['wife'] = "Supruga";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "Rođ.";
		$text['capaltbirthabbr'] = "82A";
		$text['capdeathabbr'] = "Smr.";
		$text['capburialabbr'] = "Sah.";
		$text['capplaceabbr'] = "85P";
		$text['capmarrabbr'] = "Ven.";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "87Redraw with";
		$text['scrollnote'] = "Ako ne vidite ceo dijagram pomerite sliku dole ili desno.";
		$text['unknownlit'] = "Nema podataka";
		$text['popupnote1'] = "= Dodatne informacije";
		$text['popupnote2'] = "= Novi dijagram";
		$text['pedcompact'] = "ZBIJENO";
		$text['pedstandard'] = "STANDARDNO";
		$text['pedtextonly'] = "TEKST";
		$text['descendfor'] = "Potomci";
		$text['maxof'] = "Maksimalno";
		$text['gensatonce'] = "generacija prikazanih odjednom.";
		$text['sonof'] = "sin - roditelji";
		$text['daughterof'] = "kći - roditelji";
		$text['childof'] = "dete - roditelji";
		$text['stdformat'] = "STANDARDNO";

		$text['ahnentafel'] = "PO GENERACIJAMA";
		$text['addnewfam'] = "Dodaj novu porodicu";
		$text['editfam'] = "Obradi porodicu";
		$text['side'] = "- krilo";
		$text['familyof'] = "svih predaka koji vode do osobe sa imenom";
		$text['paternal'] = "Očevo";
		$text['maternal'] = "Majčino";
		$text['gen1'] = "Odabrana osoba";
		$text['gen2'] = "Roditelj";
		$text['gen3'] = "Deda i baba";
		$text['gen4'] = "Pradede i prababe";
		$text['gen5'] = "Čukundede i čukunbabe";
		$text['gen6'] = "Navrdede i navrbabe";
		$text['gen7'] = "Kurđeli i kurđele";
		$text['gen8'] = "Askurđeli i askurđele";
		$text['gen9'] = "Kurđupi i kurđupe";
		$text['gen10'] = "Kurlebala i kurlebale";
		$text['gen11'] = "Sukurdoli i sukurdole";
		$text['gen12'] = "Sudepači i sudepače";
		$text['graphdesc'] = "Grafik do te tačke";
		$text['collapse'] = "Skupi";
		$text['expand'] = "Otvori";
		$text['pedbox'] = "KARTICE";
		//changed in 6.0.0
		$text['regformat'] = "PO GENERACIJAMA";
		$text['extrasexpl'] = "Ako postoje fotografije ili neka druga dokumenta za neku od osoba, odgovarajuća ikonicaće se pojaviti pored tog imena.";
		//added in 6.0.0
		$text['popupnote3'] = " = New chart";
		$text['mediaavail'] = "Media Available";
		//changed in 7.0.0
		$text['pedigreefor'] = "Pretci - ";
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
		$text['noreports'] = "Ne postoji nijedan izveštaj.";
		$text['reportname'] = "Ime izveštaja";
		$text['allreports'] = "Svi izveštaji";
		$text['report'] = "Izveštaj";
		$text['error'] = "Greška";
		$text['reportsyntax'] = "Sintaksa upita koji radi uz izveštaj";
		$text['wasincorrect'] = "je pogrešna, i kao rezultat izveštaj nemože biti pokazan. Kontaktirajte system administratora : vladeta@batocanin.com";
		$text['query'] = "Upit";
		$text['errormessage'] = "Greška";
		$text['equals'] = "nalik na";
		$text['contains'] = "sadrži";
		$text['startswith'] = "počinje sa";
		$text['endswith'] = "završava se sa";
		$text['soundexof'] = "zvuči kao";
		$text['metaphoneof'] = "metafora od";
		$text['plusminus10'] = "+/- 10 godina od";
		$text['lessthan'] = "manje od";
		$text['greaterthan'] = "više od";
		$text['lessthanequal'] = "manje ili jedanko";
		$text['greaterthanequal'] = "veće ili jednako";
		$text['equalto'] = "jednako";
		$text['tryagain'] = "Pokušajte ponovo";
		$text['text_for'] = "za traženi pojam";
		$text['searchnames'] = "Potraži prezime";
		$text['joinwith'] = "Odnos parametara";
		$text['cap_and'] = "I";
		$text['cap_or'] = "ILI";
		$text['showspouse'] = "Pokaži bračne partnere (ime se po";
		$text['submitquery'] = "Vaš upit";
		$text['birthplace'] = "Mesto rođenja";
		$text['deathplace'] = "Mesto smrti";
		$text['birthdatetr'] = "Godina rođenja";
		$text['deathdatetr'] = "Godina smrti";
		$text['plusminus2'] = "+/- 2 godine od";
		$text['resetall'] = "Resetuj sve vrednosti";

		$text['showdeath'] = "Pokaži informacije o smrti/sahrani";
		$text['altbirthplace'] = "Mesto krštenja";
		$text['altbirthdatetr'] = "Godina krštenja";
		$text['burialplace'] = "Mesto sahrant";
		$text['burialdatetr'] = "Godina sahrane";
		$text['event'] = "Događaj(i)";
		$text['day'] = "Dan";
		$text['month'] = "Mesec";
		$text['keyword'] = "Ključ (ie, \"Abt\")";
		$text['explain'] = "Unesite podatke o datumu da bi ste videli događaje koji odgovaraju zadatom kriterijumu. Ili ostavite prazno da bi ste videli sve odabrane događaje.";
		$text['enterdate'] = "Upišite ili odaberite minimum jednu od ovih informacijs: dan, mesec, godina, ključna reč";
		$text['fullname'] = "Puno ime i prezime";
		$text['birthdate'] = "Datum rođenja";
		$text['altbirthdate'] = "Datum krštenja";
		$text['marrdate'] = "Datum sklapanja braka";
		$text['spouseid'] = "Bračni drug - ID";
		$text['spousename'] = "Ime bračnog druga";
		$text['deathdate'] = "Datum smrti";
		$text['burialdate'] = "Datum sahrane";
		$text['changedate'] = "Datum zadnje promene";
		$text['gedcom'] = "Porodično stablo";
		$text['baptdate'] = "191Baptism Date (LDS)";
		$text['baptplace'] = "192Baptism Place (LDS)";
		$text['endldate'] = "193Endowment Date (LDS)";
		$text['endlplace'] = "194Endowment Place (LDS)";
		$text['ssealdate'] = "195Seal Date S (LDS)";
		$text['ssealplace'] = "196Seal Place S (LDS)";
		$text['psealdate'] = "197Seal Date P (LDS)";
		$text['psealplace'] = "198Seal Place P (LDS)";
		$text['marrplace'] = "Mesto sklapanja braka";
		$text['spousesurname'] = "Prezime bračnog druga";
		//changed in 6.0.0
		$text['spousemore'] = "203If you enter a value for Spouse\\'s Last Name, you must enter a value for at least one other field.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 years from";
		$text['exists'] = "exists";
		$text['dnexist'] = "does not exist";
		//added in 6.0.3
		$text['divdate'] = "Divorce Date";
		$text['divplace'] = "Divorce Place";
		//changed in 7.0.0
		$text['otherevents'] = "Drugi događaji";
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
		$text['logfilefor'] = "Evidencija za";
		$text['mostrecentactions'] = "poslednjih izvršenih upita.";
		$text['autorefresh'] = "Startuj automatsko obnavljanje svakih 30 sekundi";
		$text['refreshoff'] = "Zaustavi automatsko obnavljanje";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Groblja i nadgrobni spomenici";
		$text['showallhsr'] = "Pokaži sve zapise o spomenicima";
		$text['in'] = "-";
		$text['showmap'] = "Pokaži plan";
		$text['headstonefor'] = "Spomenik za";
		$text['photoof'] = "Fotografija - ";
		$text['firstpage'] = "Prva strana";
		$text['lastpage'] = "Poslednja strana";
		$text['photoowner'] = "AUTOR/IZVOR";

		$text['nocemetery'] = "Nema groblja";
		$text['iptc005'] = "225Naslov";
		$text['iptc020'] = "226Supp. Categories";
		$text['iptc040'] = "227Special Instructions";
		$text['iptc055'] = "228Creation Date";
		$text['iptc080'] = "229Autor";
		$text['iptc085'] = "230Author\\'s Position";
		$text['iptc090'] = "231City";
		$text['iptc095'] = "232State";
		$text['iptc101'] = "233Country";
		$text['iptc103'] = "234OTR";
		$text['iptc105'] = "235Headline";
		$text['iptc110'] = "236Source";
		$text['iptc115'] = "237Photo Source";
		$text['iptc116'] = "238Copyright Notice";
		$text['iptc120'] = "239Caption";
		$text['iptc122'] = "240Caption Writer";
		$text['mapof'] = "241Map of";
		$text['regphotos'] = "Lista sa detaljima";
		$text['gallery'] = "Samo sličice";
		$text['cemphotos'] = "Fotografija groblja";
		//changed in 6.0.0
		$text['photosize'] = "VELIČINA";
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
		$text['surnamesstarting'] = "Prikaz prezimena koja počinju na";
		$text['showtop'] = "Pokaži prvih";
		$text['showallsurnames'] = "Prikaz svih prezimena";
		$text['sortedalpha'] = "po abecedi";
		$text['byoccurrence'] = "po učestalosti";
		$text['firstchars'] = "Početna slova";
		$text['top'] = "Top";
		$text['mainsurnamepage'] = "Početna strana sa prezimenima";
		$text['allsurnames'] = "Sva prezimena";
		$text['showmatchingsurnames'] = "Kliknite na prezime da vidite osobe sa tim prezimenom";
		$text['backtotop'] = "Na početak";
		$text['beginswith'] = "koja počinju sa";
		$text['allbeginningwith'] = "Prezimana koja počinju sa";
		$text['numoccurrences'] = "broj osoba";
		$text['placesstarting'] = "Pokaži mesta čije ime počinje sa";
		$text['showmatchingplaces'] = "Kliknite na ime mesta da vidite manje lokalitete. Kliknite na lupu ako želite da vidite koje sve povezan sa tom lokacijom.";
		$text['totalnames'] = "ukupno osoba";
		$text['showallplaces'] = "Pokaži sva veća mesta";
		$text['totalplaces'] = "ukupno mesta";
		$text['mainplacepage'] = "Pokaži početnu listu mesta";
		$text['allplaces'] = "Sva veća mesta";
		$text['placescont'] = "Pokaži sva mesta koja u imenu sadrže";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(u zadnjih xx dana)";
		$text['historiesdocs'] = "TEKSTOVI";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Fotografije";
		$text['history'] = "278History/Document";
		//changed in 7.0.0
		$text['husbid'] = "SUPRUG ID";
		$text['husbname'] = "IME I PREZIME SUPRUGA";
		$text['wifeid'] = "SUPRUGA ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Obriši";
		$text['addperson'] = "Dodaj novu osobu";
		$text['nobirth'] = "Odabrana osoba nema korektan datum rođenja i nemože biti dodata.";
		$text['noliving'] = "Odabrana osoba je markirana kao živa i ne može biti dodata jer vi nemate dovoljno prava";
		$text['event'] = "Događaj(i)";
		$text['chartwidth'] = "ŠIRINA DIJAGRAMA";
		//changed in 6.0.0
		$text['timelineinstr'] = "Dodaj nove osobe unoseći njihov ID u donja polja:";
		//added in 6.0.0
		$text['togglelines'] = "Toggle Lines";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Pretraživanje svih porodičnih stabala";
		$text['treename'] = "Porodično stablo";
		$text['owner'] = "Vlasnik";
		$text['address'] = "Adresa";
		$text['city'] = "Mesto";
		$text['state'] = "Oblast";
		$text['zip'] = "Poštanski broj";
		$text['country'] = "Država";
		$text['email'] = "Vaša E-mail adresa";
		$text['phone'] = "Telefon";
		$text['username'] = "Korisničko ime";
		$text['password'] = "Lozinka";
		$text['loginfailed'] = "Prijavljivanje nije uspelo.";

		$text['regnewacct'] = "Registrovanje novog korisničkog konta";
		$text['realname'] = "Vaše pravo ime";
		$text['phone'] = "Telefon";
		$text['email'] = "Vaša E-mail adresa";
		$text['address'] = "Adresa";
		$text['comments'] = "Komentar";
		$text['submit'] = "Pošalji";
		$text['leaveblank'] = "(ostavite prazno ako želite novo porodično stablo)";
		$text['required'] = "Polja koja morate obavezno popuniti";
		$text['enterpassword'] = "Molimo vas upišite lozinku";
		$text['enterusername'] = "Molimo vas upišite korisničko ime";
		$text['failure'] = "Žao nam je, ali korisničko ime koje ste odabrali je već u upotrebi. Vratite se na prethodnu stranu koristeći dugme za nazad i odaberite neko drugo korisničko ime.";
		$text['success'] = "Hvala. Dobili smo vaš zahtev za registraciju. Dobićete mail čim vaša registracija bude aktivirana ili u skučaju da su potrebne dodatne informacije.";
		$text['emailsubject'] = "Zahtev za registraciju novog korisnika";
		$text['emailmsg'] = "You have received a new request for a TNG user account. Please log into your TNG Admin area and assign proper permissions to this new account. If you approve of this registration, please notify the applicant by replying to this message.";
		//changed in 5.0.0
		$text['enteremail'] = "Milomo vas upišite važeću E-mail adresu";
		$text['website'] = "Web sajt";
		$text['nologin'] = "Niste registrovani?";
		$text['loginsent'] = "319Login information sent";
		$text['loginnotsent'] = "Tražene informacije nisu poslate.";
		$text['enterrealname'] = "Milomo vas upišite vaše pravo ime i prezime";
		$text['rempass'] = "Aktiviraj stalnu prijavu na ovom kompjuteru";
		$text['morestats'] = "Potpuna statistika";
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
		$text['quantity'] = "VELIČINA";
		$text['totindividuals'] = "Ukupno ososba";
		$text['totmales'] = "Ukupno osoba muškog pola";
		$text['totfemales'] = "Ukupno osoba ženskog pola";
		$text['totunknown'] = "Ukupno osoba nepoznatog pola";
		$text['totliving'] = "Ukupno živih";
		$text['totfamilies'] = "Ukupno porodica";
		$text['totuniquesn'] = "Ukupno jedinstvenih prezimena";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Ukupno izvora";
		$text['avglifespan'] = "Prosečan životni vek";
		$text['earliestbirth'] = "Najranije rođenje";
		$text['longestlived'] = "NAJDUŽE ŽIVELI";
		$text['years'] = "god.";
		$text['days'] = "dana";
		$text['age'] = "GODINA I DANA";
		$text['agedisclaimer'] = "Izračunavanje godina je bazirano na podacima rođenja i smrti. Budući da postoje nepotpuni podaci kao što su pre 1869 ili oko 1863 ili iza 1780 ova izračunavanje ne mogu biti 100% tačna.";
		$text['treedetail'] = "345More information on this tree";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Lista svih beleški";
		break;

	case "help":
		$text['menuhelp'] = "IZBOR";
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
$text['matches'] = "Lista pronađenih, od";
$text['description'] = "OPIS";
$text['notes'] = "BELEŠKE";
$text['status'] = "354Status";
$text['newsearch'] = "Nova pretraga";
$text['pedigree'] = "Pretci";
$text['birthabbr'] = "rođ.";
$text['chrabbr'] = "krš.";
$text['seephoto'] = "Vidi fotografiju";
$text['andlocation'] = "360&amp; location";
$text['accessedby'] = "pristup sa ";
$text['go'] = "Traži";
$text['family'] = "BRAK";
$text['children'] = "DECA";
$text['tree'] = "Porodično stablo";
$text['alltrees'] = "Sva porodična stabla";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "DETALJ";
$text['people'] = "POVEZANO SA";
$text['title'] = "NASLOV";
$text['suffix'] = "373Suffix";
$text['nickname'] = "NADIMAK";
$text['deathabbr'] = "smr.";
$text['lastmodified'] = "PROMENA";
$text['married'] = "VENČANJE";
//$text['photos'] = "Photos";
$text['name'] = "PREZIME I IME";
$text['lastfirst'] = "PREZIME, IME";
$text['bornchr'] = "ROĐENJE ILI KRŠTENJE";
$text['individuals'] = "Osobe";
$text['families'] = "Porodice";
$text['personid'] = "LIČNI ID";
$text['sources'] = "IZVORI";
$text['unknown'] = "Nepoznat";
$text['father'] = "OTAC";
$text['mother'] = "MAJKA";
$text['born'] = "ROĐENJE";
$text['christened'] = "KRŠTENJE";
$text['died'] = "SMRT";
$text['buried'] = "SAHRANA";
$text['spouse'] = "BRAK";
$text['parents'] = "RODITELJI";
$text['text'] = "TEKST";
$text['language'] = "Jezik";
$text['burialabbr'] = "sah.";
$text['descendchart'] = "Opadajući";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "ODABRANA OSOBA";
$text['edit'] = "IZMENE";
$text['date'] = "Datum";
$text['place'] = "Mesto";
$text['login'] = "Prijavljivanje";
$text['logout'] = "ODJAVA";
$text['marrabbr'] = "ven.";
$text['groupsheet'] = "Porodični list";
$text['text_and'] = "i";
$text['generation'] = "Generacija";
$text['filename'] = "IME FAJLA";
$text['id'] = "ID";
$text['search'] = "TRAŽI";
$text['living'] = "415Living";
$text['user'] = "Korisnik";
$text['firstname'] = "Ime";
$text['lastname'] = "Prezime";
$text['searchresults'] = "Rezultat pretrage";
$text['diedburied'] = "SMRT / SAHRANA";
$text['homepage'] = "POČETNA STRANA";
$text['find'] = "TRAŽI";
$text['relationship'] = "SRODSTVO";
$text['relationship2'] = "Relationship";
$text['timeline'] = "VREMEPLOV";
$text['yesabbr'] = "425Y";
$text['divorced'] = "RAZVOD";
$text['indlinked'] = "POVEZANO SA";
$text['branch'] = "428Branch";
$text['moreind'] = "429More individuals";
$text['morefam'] = "430More families";
$text['livingdoc'] = "432At least one living individual is linked to this document - Details withheld.";
$text['source'] = "IZVOR";
$text['surnamelist'] = "Prezimena";
$text['generations'] = "BROJ GENERACIJA";
$text['refresh'] = "PONOVI";
$text['whatsnew'] = "Šta ima novo";
$text['reports'] = "Izveštaji";
$text['placelist'] = "Lista svih mesta koja u svome imenu sadrže";
$text['baptizedlds'] = "441Baptized (LDS)";
$text['endowedlds'] = "442Endowed (LDS)";
$text['sealedplds'] = "443Sealed P (LDS)";
$text['sealedslds'] = "444Sealed S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "PRETCI";
$text['descendants'] = "POTOMCI";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Datum poslednjeg prijema GEDCOM podataka";
$text['type'] = "450Type";
$text['savechanges'] = "Zapiši promene";
$text['familyid'] = "PORODIČNI ID";
$text['headstone'] = "SPOMENIK";
$text['historiesdocs'] = "TEKSTOVI";
$text['livingnote'] = "455At least one living individual is linked to this note - Details withheld.";
$text['anonymous'] = "456anonymous";
$text['places'] = "Mesta";
$text['anniversaries'] = "Datumi i godišnjice";
$text['administration'] = "Administracija";
$text['help'] = "POMOĆ";
//$text['documents'] = "Documents";
$text['year'] = "Godina";
$text['all'] = "SVE";
$text['repository'] = "464Repository";
$text['address'] = "Adresa";
$text['suggest'] = "PRIMEDBA";
$text['editevent'] = "467Suggest a change for this event";
$text['findplaces'] = "468Find all individuals with events at this location";
$text['morelinks'] = "469More Links";
$text['faminfo'] = "PORODIČNE INFORMACIJE";
$text['persinfo'] = "LIČNE INFORMACIJE";
$text['srcinfo'] = "DETALJI I VEZE";
$text['fact'] = "473Fact";
$text['goto'] = "Odaberi stranu";
$text['tngprint'] = "ŠTAMPAJ";
//changed in 6.0.0
$text['livingphoto'] = "431At least one living individual is linked to this photo - Details withheld.";
$text['databasestatistics'] = "Statistika baze podataka";
//moved here in 6.0.0
$text['child'] = "Dete";
$text['repoinfo'] = "9Repository Information";
$text['tng_reset'] = "BRIŠI";
$text['noresults'] = "Za zadati kriterijum nije pronađen ni jedan događaj.";
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
$text['cemetery'] = "GROBLJE";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Event Map";
$text['gevents'] = "Event";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Link to Google Earth";
$text['googlemaplink'] = "Link to Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "212Unmarked";
$text['located'] = "Lokalizovan";
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
$text['mnuheader'] = "Početna strana";
$text['mnusearchfornames'] = "Potraži ososbu";
$text['mnulastname'] = "Prezime";
$text['mnufirstname'] = "Ime";
$text['mnusearch'] = "Traži";
$text['mnureset'] = "481Start Over";
$text['mnulogon'] = "Prijavljivanje";
$text['mnulogout'] = "Odjavljivanje";
$text['mnufeatures'] = "Vaš izbor";
$text['mnuregister'] = "Registrujte se kao korisnik";
$text['mnuadvancedsearch'] = "Detaljnija pretraga";
$text['mnulastnames'] = "Prezimena";
$text['mnustatistics'] = "Statistika";
$text['mnuphotos'] = "Fotografije";
$text['mnuhistories'] = "Tekstovi";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Groblja";
$text['mnutombstones'] = "Nadgrobni spomenici";
$text['mnureports'] = "Izveštaji";
$text['mnusources'] = "Izvori";
$text['mnuwhatsnew'] = "Šta ima novo";
$text['mnushowlog'] = "Lista pristupa";
$text['mnulanguage'] = "Promena jezika";
$text['mnuadmin'] = "Administracija";
$text['welcome'] = "Dobro došli";
$text['contactus'] = "Kontakt";

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
