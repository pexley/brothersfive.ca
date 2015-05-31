<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Pretraži sve izvore";
		$text['shorttitle'] = "Kratki naslov";
		$text['callnum'] = "Pozivni broj";
		$text['author'] = "Autor";
		$text['publisher'] = "Izdavač";
		$text['other'] = "Ostale informacije";
		$text['sourceid'] = "Source ID";
		$text['moresrc'] = "Još izvora";
		$text['repoid'] = "Repository ID";
		$text['browseallrepos'] = "Pretraži sve Repositories";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Novi jezik";
		$text['changelanguage'] = "Promijeni jezik";
		$text['languagesaved'] = "Jezik pohranjen";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM počinje od";
		$text['producegedfrom'] = "Proizvedi GEDCOM datoteku od";
		$text['numgens'] = "Broj generacija";
		$text['includelds'] = "Uključi LDS informaciju";
		$text['buildged'] = "Build GEDCOM";
		$text['gedstartfrom'] = "GEDCOM početna forma";
		$text['nomaxgen'] = "Morate naznačiti maksimalni broj generacija. Molim koristite tipku Natrag za povratak na prethodnu stranicu i ispravite pogrešku";
		$text['gedcreatedfrom'] = "GEDCOM kreirana forma";
		$text['gedcreatedfor'] = "kreirano za";

		$text['enteremail'] = "Molim unesite valjanu e-mail adresu.";
		$text['creategedfor'] = "Kreiraj GEDCOM";
		$text['email'] = "E-mail adresa";
		$text['suggestchange'] = "Predloži promjenu";
		$text['yourname'] = "Vaše ime";
		$text['comments'] = "Komentar";
		$text['comments2'] = "Komentar";
		$text['submitsugg'] = "Pošalji prijedlog";
		$text['proposed'] = "Predložena promjena";
		$text['mailsent'] = "Hvala. Vaša je poruka isporučena.";
		$text['mailnotsent'] = "Žao nam je, ali vaša poruka ne može biti isporučena. Molim kontaktirajte me direktno na mbralic@gmail.com.";
		$text['mailme'] = "Pošalji kopiju od ove adrese";
		//added in 5.0.5
		$text['entername'] = "Molim unesite vaše ime";
		$text['entercomments'] = "Molim unesite vaš komentar";
		$text['sendmsg'] = "Pošalji poruku";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotografije i povijest ";
		$text['indinfofor'] = "Osobna informacija za";
		$text['reliability'] = "Reliability";
		$text['pp'] = "pp.";
		$text['age'] = "starost";
		$text['agency'] = "Agencija";
		$text['cause'] = "Uzrok";
		$text['suggested'] = "Predloženo";
		$text['closewindow'] = "Zatvori ovaj prozor";
		$text['thanks'] = "Hvala";
		$text['received'] = "Vaša sugestija je prosljeđena administratoru web site-a na uvid.";
		//added in 6.0.0
		$text['association'] = "Asocijacija";
		//added in 7.0.0
		$text['indreport'] = "Individual Report";
		$text['indreportfor'] = "Individual Report for";
		$text['general'] = "General";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Kalkulator rodbinskih veza";
		$text['findrel'] = "Nađi rodbinsku vezu";
		$text['person1'] = "Osoba 1:";
		$text['person2'] = "Osoba 2:";
		$text['calculate'] = "Izračunaj";
		$text['select2inds'] = "Molim izaberite dvije osobe.";
		$text['findpersonid'] = "Nađi ID osobe";
		$text['enternamepart'] = "unesi dio imena i/ili prezimena";
		$text['pleasenamepart'] = "Molim unesite dio imena ili prezimena.";
		$text['clicktoselect'] = "klikni za izbor";
		$text['nobirthinfo'] = "Fali informacija o rođenju";
		$text['relateto'] = "Rodbinska veza";
		$text['sameperson'] = "Dvije osobe su jedna te ista osoba.";
		$text['notrelated'] = "Dvije osobe nisu u vezi sa xxx generacija.";
		$text['findrelinstr'] = "Za prikazati obiteljsku vezu između dvije osobe, koristi 'Find' tipku dolje da bi locirali osobe (ili nastavi prikazivati osobe), zatim klikni na 'Kalkuliraj'.";
		$text['gencheck'] = "Max generacija<br />za provjeru";
		$text['sometimes'] = "(Ponekad provjera medu različitim brojevima generacija daje različite rezultate.)";
		$text['findanother'] = "Nađi drugu rodbinsku vezu";
		//added in 6.0.0
		$text['brother'] = "brat od";
		$text['sister'] = "sestra od";
		$text['sibling'] = "potomak od";
		$text['uncle'] = "xxx je ujak od";
		$text['aunt'] = "xxx je tetka od";
		$text['uncleaunt'] = "xxx je ujak/tetka od";
		$text['nephew'] = "xxx je nećak od";
		$text['niece'] = "xxx je nećakinja od";
		$text['nephnc'] = "xxx je nećak/nećakinja od";
		$text['mcousin'] = "xxx je rođak od";
		$text['fcousin'] = "xxx je rođakinja od";
		$text['cousin'] = "xxx je rođak od";
		$text['removed'] = "times obrisan";
		$text['rhusband'] = "suprug od ";
		$text['rwife'] = "supruga od ";
		$text['rspouse'] = "supruga od ";
		$text['son'] = "sin od";
		$text['daughter'] = "kcerka od";
		$text['rchild'] = "dijete od";
		$text['sil'] = "zet od";
		$text['dil'] = "nevjesta od";
		$text['sdil'] = "zet ili nevjesta od";
		$text['gson'] = "xxx unuk od";
		$text['gdau'] = "xxx unuka od";
		$text['gsondau'] = "xxx unuk/unuka od";
		$text['great'] = "veći";
		$text['spouses'] = "su supruge";
		$text['is'] = "je";
		//changed in 6.0.0
		$text['changeto'] = "Promijeni u (unesi ID):";
		//added in 6.0.0
		$text['notvalid'] = "nije valjan broj osobnog ID-a ili ne postoji u ovoj bazi podataka. Molim pokušajte ponovo.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Obiteljska grupna lista za";
		$text['ldsords'] = "LDS Ordinances";
		$text['baptizedlds'] = "Kršten (LDS)";
		$text['endowedlds'] = "Endowed (LDS)";
		$text['sealedplds'] = "Sealed P (LDS)";
		$text['sealedslds'] = "Sealed S (LDS)";
		$text['otherspouse'] = "Ostale supruge/supruzi";
		//changed in 7.0.0
		$text['husband'] = "Suprug";
		$text['wife'] = "Supruga";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "B";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "B";
		$text['capplaceabbr'] = "P";
		$text['capmarrabbr'] = "M";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Redraw sa";
		$text['scrollnote'] = "Notes: Možete scroll dolje ili desno za vidjeti tablu.";
		$text['unknownlit'] = "Nepoznat";
		$text['popupnote1'] = " = Dodatna informacija";
		$text['popupnote2'] = " = Novo porijeklo";
		$text['pedcompact'] = "Kompakt";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Tekst";
		$text['descendfor'] = "Nasljednici za";
		$text['maxof'] = "Maksimum od";
		$text['gensatonce'] = "generacija prikazanih odjednom.";
		$text['sonof'] = "sin od";
		$text['daughterof'] = "kći od";
		$text['childof'] = "dijete od";
		$text['stdformat'] = "Standard Format";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "Dodaj novu obitelj";
		$text['editfam'] = "uredi obitelj";
		$text['side'] = "Strana";
		$text['familyof'] = "Obitelj od";
		$text['paternal'] = "Očev";
		$text['maternal'] = "Materinji";
		$text['gen1'] = "Vlastiti";
		$text['gen2'] = "Roditelji";
		$text['gen3'] = "Djedovi";
		$text['gen4'] = "Pradjedovi";
		$text['gen5'] = "Pra Pra djedovi";
		$text['gen6'] = "3. Pra djedovi";
		$text['gen7'] = "4. Pra djedovi";
		$text['gen8'] = "5. Pra djedovi";
		$text['gen9'] = "6. Pra djedovi";
		$text['gen10'] = "7. Pra djedovi";
		$text['gen11'] = "8. Pra djedovi";
		$text['gen12'] = "9. Pra djedovi";
		$text['graphdesc'] = "Tabla potomaka do ovog trenutka";
		$text['collapse'] = "Collapse";
		$text['expand'] = "Ekspandiraj";
		$text['pedbox'] = "Box";
		//changed in 6.0.0
		$text['regformat'] = "Register";
		$text['extrasexpl'] = "= Najmanje jedna fotografija, povijest ili neki drugi media item postoji o ovoj osobi.";
		//added in 6.0.0
		$text['popupnote3'] = " = Novi dijagram";
		$text['mediaavail'] = "Medija na raspolaganju";
		//changed in 7.0.0
		$text['pedigreefor'] = "Porijeklo za";
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
		$text['noreports'] = "Izvješce ne postoji.";
		$text['reportname'] = "Naziv izvješća";
		$text['allreports'] = "Sva izvješća";
		$text['report'] = "Izvješće";
		$text['error'] = "Error";
		$text['reportsyntax'] = "Sintaksa upita se pokreće zajedno s ovim izvješćem";
		$text['wasincorrect'] = "je pogrešno, i kao rezultat izvješće se ne može pokrenuti. Molim da kontaktirate administratora sustava";
		$text['query'] = "Upit";
		$text['errormessage'] = "Error poruka";
		$text['equals'] = "jednako";
		$text['contains'] = "sadrži";
		$text['startswith'] = "počinje sa";
		$text['endswith'] = "završava sa";
		$text['soundexof'] = "soundex of";
		$text['metaphoneof'] = "metaphone of";
		$text['plusminus10'] = "+/- 10 godina od";
		$text['lessthan'] = "menje nego";
		$text['greaterthan'] = "veće od";
		$text['lessthanequal'] = "manje ili jednako od";
		$text['greaterthanequal'] = "veće ili jednako za";
		$text['equalto'] = "jednako";
		$text['tryagain'] = "Molim pokušajte ponovo";
		$text['text_for'] = "for";
		$text['searchnames'] = "Traži imena";
		$text['joinwith'] = "Spoji sa";
		$text['cap_and'] = "I";
		$text['cap_or'] = "ILI";
		$text['showspouse'] = "Prikazana suprugu pokazat će se kao duplikat ako osoba ima više od jedne supruge)";
		$text['submitquery'] = "Pošalji upit";
		$text['birthplace'] = "Mjesto rođenja";
		$text['deathplace'] = "Mjesto smrti";
		$text['birthdatetr'] = "Godina rođenja";
		$text['deathdatetr'] = "Godina smrti";
		$text['plusminus2'] = "+/- 2 godine od";
		$text['resetall'] = "Resetiraj sve vrijednosti";

		$text['showdeath'] = "Prikaži smrt/informaciju o pogrebu";
		$text['altbirthplace'] = "Christening Place";
		$text['altbirthdatetr'] = "Christening Year";
		$text['burialplace'] = "Mjesto ukopa";
		$text['burialdatetr'] = "Godina ukopa";
		$text['event'] = "Događaj(i)";
		$text['day'] = "Dan";
		$text['month'] = "Mjesec";
		$text['keyword'] = "Ključna riječ (npr, \"Abt\")";
		$text['explain'] = "Unesi komponente datuma da bi vidio događaje koji se slažu. Ostavi prazno polje da bi vidjio sve događaje koji se slažu.";
		$text['enterdate'] = "Molim unesi ili odaberi najmanje jedan podatak: Dan, Mjesec, Godina, ključna riječ";
		$text['fullname'] = "Puno ime";
		$text['birthdate'] = "Datum rođenja";
		$text['altbirthdate'] = "Christening Date";
		$text['marrdate'] = "Datum vjenčanja";
		$text['spouseid'] = "Suprugin ID";
		$text['spousename'] = "Suprugino ime";
		$text['deathdate'] = "Datum smrti";
		$text['burialdate'] = "Datum ukopa";
		$text['changedate'] = "Datum zadnje modifikacije";
		$text['gedcom'] = "Stablo";
		$text['baptdate'] = "Datum krštenja (LDS)";
		$text['baptplace'] = "Mjeto krštenja (LDS)";
		$text['endldate'] = "Endowment Date (LDS)";
		$text['endlplace'] = "Endowment Place (LDS)";
		$text['ssealdate'] = "Seal Date S (LDS)";
		$text['ssealplace'] = "Seal Place S (LDS)";
		$text['psealdate'] = "Seal Date P (LDS)";
		$text['psealplace'] = "Seal Place P (LDS)";
		$text['marrplace'] = "Mjesto vjenčanja";
		$text['spousesurname'] = "Prezime supruge";
		//changed in 6.0.0
		$text['spousemore'] = "Ako unesete vrijednost supruginog prezimena, morate unijeti vrijednost u najmanje još jedno polje.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 godina od";
		$text['exists'] = "postoji";
		$text['dnexist'] = "ne postoji";
		//added in 6.0.3
		$text['divdate'] = "Divorce Date";
		$text['divplace'] = "Divorce Place";
		//changed in 7.0.0
		$text['otherevents'] = "Ostali događaji";
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
		$text['logfilefor'] = "Datoteka logova za";
		$text['mostrecentactions'] = "Posljednje aktivnosti";
		$text['autorefresh'] = "Automatsko osvježavanje (30 seconds)";
		$text['refreshoff'] = "Isključi automatsko osvježivanje";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Groblja i nadgrobni spomenici";
		$text['showallhsr'] = "Prikaži sve podatke o nadgrobnim spomenicima";
		$text['in'] = "u";
		$text['showmap'] = "Prikaži mapu";
		$text['headstonefor'] = "Nadgrobni spomenik za";
		$text['photoof'] = "Fotografija od";
		$text['firstpage'] = "Prva stranica";
		$text['lastpage'] = "Zadnja stranica";
		$text['photoowner'] = "Vlasnik/Izvor";

		$text['nocemetery'] = "Nema groblja";
		$text['iptc005'] = "Naslov";
		$text['iptc020'] = "Supp. Categories";
		$text['iptc040'] = "Specijalne instrukcije";
		$text['iptc055'] = "Datum kreiranja";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Autorova pozicija";
		$text['iptc090'] = "Grad";
		$text['iptc095'] = "State";
		$text['iptc101'] = "Država";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Naslov";
		$text['iptc110'] = "Izvor";
		$text['iptc115'] = "Photo Source";
		$text['iptc116'] = "Copyright Notice";
		$text['iptc120'] = "Caption";
		$text['iptc122'] = "Caption Writer";
		$text['mapof'] = "Karta od";
		$text['regphotos'] = "Deskriptivan pogled";
		$text['gallery'] = "Thumbnails Only";
		$text['cemphotos'] = "Fotografije groblja";
		//changed in 6.0.0
		$text['photosize'] = "Dimenzije";
		//added in 6.0.0
        	$text['iptc010'] = "Prioritet";
		$text['filesize'] = "Veličina datoteke";
		$text['seeloc'] = "Vidi lokaciju";
		$text['showall'] = "Prikaži sve";
		$text['editmedia'] = "Uredi Media";
		$text['viewitem'] = "Pogledaj ovaj item";
		$text['editcem'] = "Uredi groblja";
		$text['numitems'] = "# Items";
		$text['allalbums'] = "Svi albumi";
		//added in 6.1.0
		$text['slidestart'] = "Pokreni Slide Show";
		$text['slidestop'] = "Pauza Slide Show";
		$text['slideresume'] = "Nastavi Slide Show";
		$text['slidesecs'] = "Sekundi za svaki slajsd:";
		$text['minussecs'] = "minus 0.5 sekundi";
		$text['plussecs'] = "plus 0.5 sekundi";
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
		$text['surnamesstarting'] = "Prikaži prezimena koja počinju sa";
		$text['showtop'] = "Prikaži prvih";
		$text['showallsurnames'] = "Prikaži sva prezimena";
		$text['sortedalpha'] = "sortiraj abecedno";
		$text['byoccurrence'] = "sortiranih po pojavljivanju";
		$text['firstchars'] = "Prvi znakovi";
		$text['top'] = "Vrh";
		$text['mainsurnamepage'] = "Glavna stranica prezimena";
		$text['allsurnames'] = "Sva prezimena";
		$text['showmatchingsurnames'] = "Klikni na prezime za vidjeti polja koja se slažu.";
		$text['backtotop'] = "Nazad na vrh";
		$text['beginswith'] = "Počinje sa";
		$text['allbeginningwith'] = "Sva prezimena počinju sa";
		$text['numoccurrences'] = "broj pojavljivanja u zagradama";
		$text['placesstarting'] = "Prikaži najveći lokalitet koji počinje s";
		$text['showmatchingplaces'] = "Klikni na mjesto ako želiš prikazati manji lokalitet. Klikni na search ikonu ako želiš prikazati osobe koje se slažu.";
		$text['totalnames'] = "ukupno osoba";
		$text['showallplaces'] = "Prikaži sve najveće lokalitete";
		$text['totalplaces'] = "ukupno mjesta";
		$text['mainplacepage'] = "Stranica glavnih mjesta";
		$text['allplaces'] = "Svi najveći lokaliteti";
		$text['placescont'] = "Prikaži sva mjesta koja sadrže";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(prethodnih xx dana)";
		$text['historiesdocs'] = "Povijesti";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Photo";
		$text['history'] = "Povijest/Dokument";
		//changed in 7.0.0
		$text['husbid'] = "Suprugov ID";
		$text['husbname'] = "Suprugovo ime";
		$text['wifeid'] = "Suprugin ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Obriši";
		$text['addperson'] = "Dodaj osobu";
		$text['nobirth'] = "Ova osoba nema valjani datum rođenja i ne može biti dodana";
		$text['noliving'] = "Slijedeća osoba je označena kao živuća i ne može biti dodana zbog toga što nisi logiran s odgovarajućim ovlastima";
		$text['event'] = "Događaj(i)";
		$text['chartwidth'] = "Širina table";
		//changed in 6.0.0
		$text['timelineinstr'] = "Dodaj ljude";
		//added in 6.0.0
		$text['togglelines'] = "Dozvoli crte";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Pregledaj sva stabla";
		$text['treename'] = "Naziv stabla";
		$text['owner'] = "Vlasnik";
		$text['address'] = "Adrese";
		$text['city'] = "Grad";
		$text['state'] = "State/Province";
		$text['zip'] = "Poštanski kod";
		$text['country'] = "Zemlja";
		$text['email'] = "E-mail adresa";
		$text['phone'] = "Telefon";
		$text['username'] = "Username";
		$text['password'] = "Password";
		$text['loginfailed'] = "Login failed.";

		$text['regnewacct'] = "Registriraj se za novi korisnički account";
		$text['realname'] = "Vaše stvarno ime";
		$text['phone'] = "Telefon";
		$text['email'] = "E-mail adresa";
		$text['address'] = "Adrese";
		$text['comments'] = "Komentar";
		$text['submit'] = "Submit";
		$text['leaveblank'] = "(ostavi prazno ako zahtijevate novo stablo)";
		$text['required'] = "Potrebna polja";
		$text['enterpassword'] = "Molimo unesite zaporku.";
		$text['enterusername'] = "Molimo unesite korisničko ime.";
		$text['failure'] = "Žao nam je, ali vaše korisničko ime kojeg ste unijeli je već korišteno. Molimo koristite Back button na vašem browser-u za povratak na prethodnu stanicu te odaberi drugačije korisničko ime.";
		$text['success'] = "Hvala. Primili smo vašu registraciju. Kontaktirat ćemo vas kada aktiviramo vaš account ili ako su potrebne dodatne informacije.";
		$text['emailsubject'] = "Novi zahtjev za registracijom od strane TNG korisnika";
		$text['emailmsg'] = "Primili ste novi zahtjev za otvaranje TNG korisničkog account-a. Molimo da se logirate na vaš TNG Admin account i dodijelite odgovarajuće ovlasti novom account-u. Ako odobrite ovu registraciju, molim da obavjestite aplikanta na način da odgovorite na ovu poruku.";
		//changed in 5.0.0
		$text['enteremail'] = "Molim unesite valjanu e-mail adresu.";
		$text['website'] = "Web Site";
		$text['nologin'] = "Nemaš login?";
		$text['loginsent'] = "Login informacija poslata";
		$text['loginnotsent'] = "Login informacija nije poslata";
		$text['enterrealname'] = "Molimo unesite vaše realno ime.";
		$text['rempass'] = "Ostani logiran na ovom računalu";
		$text['morestats'] = "Još statistike";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTE:</strong> Molimo vas da ne blokirate mail s ove domene ako želite primati email-ove od sistem administratora u vezi vašeg account-a.";
		$text['newpassword'] = "Nova zaporka";
		$text['resetpass'] = "Resetiraj svoju zaporku";
		//added in 6.1.0
		$text['nousers'] = "Ova forma ne može biti korištena sve dok postoji najmanje jedan korisnik. Ako ste vlasnik site-a, molim vas da kreirate vaš Administrator account iz Admin/Users.";
		//added in 7.0.0
		$text['noregs'] = "We're sorry, but we are not accepting new user registrations at this time. Please <a href=\"suggest.php\">contact us</a> directly if you have comments or questions regarding anything on this site.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Količina";
		$text['totindividuals'] = "Ukupno osoba";
		$text['totmales'] = "Ukupno muškaraca";
		$text['totfemales'] = "Ukupno žena";
		$text['totunknown'] = "Ukupno nepoznatih spolova";
		$text['totliving'] = "Ukuno živućih";
		$text['totfamilies'] = "Ukupno obitelji";
		$text['totuniquesn'] = "Ukupno jedinstvenih prezimena";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Ukupno izvora";
		$text['avglifespan'] = "Prosječni životni vijek";
		$text['earliestbirth'] = "Najranije rođenje";
		$text['longestlived'] = "Najduže živio";
		$text['years'] = "godina";
		$text['days'] = "dana";
		$text['age'] = "starost";
		$text['agedisclaimer'] = "Izračun baziran na starosti je zasnovan na osobama sa upisanim datumima rođenja <EM>i</EM> smrti. Zbog nekompletiranih podataka u poljima za datum (npr., datum smrti je prikazan samo kao \"1945\" ili \"BEF 1860\"), ove kalkulacije ne mogu biti 100% točne.";
		$text['treedetail'] = "Više informacija o ovom stablu";
		//added in 6.0.0
		$text['total'] = "Ukupno";
		break;

	case "notes":
		$text['browseallnotes'] = "Pretraži sve zabilješke";
		break;

	case "help":
		$text['menuhelp'] = "Menu Key";
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
		$text['exists'] = "postoji";
		$text['loginfirst'] = "You must log in first.";
		$text['noop'] = "No operation was performed.";
		break;
}

//common
$text['matches'] = "Matches";
$text['description'] = "Opis";
$text['notes'] = "Zabilješke";
$text['status'] = "Status";
$text['newsearch'] = "Novo pretraživanje";
$text['pedigree'] = "Porijeklo";
$text['birthabbr'] = "b.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Vidi fotografiju";
$text['andlocation'] = "&amp; lokacija";
$text['accessedby'] = "pristupao";
$text['go'] = "Idi";
$text['family'] = "Obitelj";
$text['children'] = "Djeca";
$text['tree'] = "Stablo";
$text['alltrees'] = "Sva stabla";
$text['nosurname'] = "[nema prezimena]";
$text['thumb'] = "Thumb";
$text['people'] = "Ljudi";
$text['title'] = "Naslov";
$text['suffix'] = "Sufiks";
$text['nickname'] = "Nadimak";
$text['deathabbr'] = "d.";
$text['lastmodified'] = "Zadnji koji je modificiran";
$text['married'] = "Oženjen";
//$text['photos'] = "Photos";
$text['name'] = "Ime";
$text['lastfirst'] = "Prezime, Ime(na)";
$text['bornchr'] = "Roden/Kršten";
$text['individuals'] = "Osoba";
$text['families'] = "Obitelji";
$text['personid'] = "ID osobe";
$text['sources'] = "Izvori";
$text['unknown'] = "Nepoznat";
$text['father'] = "Otac";
$text['mother'] = "Majka";
$text['born'] = "Rođen";
$text['christened'] = "Kršten";
$text['died'] = "Umro";
$text['buried'] = "Ukopan";
$text['spouse'] = "Supruga";
$text['parents'] = "Roditelji";
$text['text'] = "Tekst";
$text['language'] = "Jezik";
$text['burialabbr'] = "ukop.";
$text['descendchart'] = "Potomci";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Osoba";
$text['edit'] = "Uredi";
$text['date'] = "Datum";
$text['place'] = "Mjesto";
$text['login'] = "Login";
$text['logout'] = "Logout";
$text['marrabbr'] = "m.";
$text['groupsheet'] = "Group Sheet";
$text['text_and'] = "i";
$text['generation'] = "Generacija";
$text['filename'] = "Ime datoteke";
$text['id'] = "ID";
$text['search'] = "Traži";
$text['living'] = "Živuća";
$text['user'] = "Korisnik";
$text['firstname'] = "Ime";
$text['lastname'] = "Prezime";
$text['searchresults'] = "Pretraži rezultate";
$text['diedburied'] = "Umro/Ukopan";
$text['homepage'] = "Home";
$text['find'] = "Nađi...";
$text['relationship'] = "Veza";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Vremenska linija";
$text['yesabbr'] = "D";
$text['divorced'] = "Razveden";
$text['indlinked'] = "Vezan za";
$text['branch'] = "Branch";
$text['moreind'] = "Više osoba";
$text['morefam'] = "Više obitelji";
$text['livingdoc'] = "Najmanje jedna živuća osoba je vezana za ovaj dokument - Detalji zadržani.";
$text['source'] = "Izvor";
$text['surnamelist'] = "Lista prezimena";
$text['generations'] = "Generacije";
$text['refresh'] = "Osvježi";
$text['whatsnew'] = "Što je novo dodano";
$text['reports'] = "Izvješća";
$text['placelist'] = "Lista mjesta";
$text['baptizedlds'] = "Kršten (LDS)";
$text['endowedlds'] = "Endowed (LDS)";
$text['sealedplds'] = "Sealed P (LDS)";
$text['sealedslds'] = "Sealed S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Pretci";
$text['descendants'] = "Djeca";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Date of Last GEDCOM Import";
$text['type'] = "Tip";
$text['savechanges'] = "Pohrani promjene";
$text['familyid'] = "ID obitelji";
$text['headstone'] = "Nadgrobni spomenici";
$text['historiesdocs'] = "Povijesti";
$text['livingnote'] = "Najmanje jedna živuća osoba je vezana za ovaj zapis - Detalji zadržani.";
$text['anonymous'] = "anoniman";
$text['places'] = "Mjesta";
$text['anniversaries'] = "Datumi & Obljetnice";
$text['administration'] = "Administracija";
$text['help'] = "Pomoć";
//$text['documents'] = "Documents";
$text['year'] = "Godina";
$text['all'] = "Svi";
$text['repository'] = "Repository";
$text['address'] = "Adrese";
$text['suggest'] = "Sugestija";
$text['editevent'] = "Predloži promjenu za ovaj dogadaj";
$text['findplaces'] = "Pronađi sve osobe koji imaju događaje na ovoj lokaciji";
$text['morelinks'] = "Više linkova";
$text['faminfo'] = "Obiteljska informacija";
$text['persinfo'] = "Osobna informacija";
$text['srcinfo'] = "Izvor informacija";
$text['fact'] = "Činjenice";
$text['goto'] = "Selektiraj stranicu";
$text['tngprint'] = "Print";
//changed in 6.0.0
$text['livingphoto'] = "Najmanje jedna živuća osoba je vezana za ovaj item - detalji pridržani.";
$text['databasestatistics'] = "Statistike";
//moved here in 6.0.0
$text['child'] = "Dijete";
$text['repoinfo'] = "Repository Information";
$text['tng_reset'] = "Reset";
$text['noresults'] = "Rezultati nisu nađeni";
//added in 6.0.0
$text['allmedia'] = "All Media";
$text['repositories'] = "Repositories";
$text['albums'] = "Albumi";
$text['cemeteries'] = "Groblja";
$text['surnames'] = "Prezimena";
$text['dates'] = "Datumi";
$text['link'] = "Linkovi";
$text['media'] = "Media";
$text['gender'] = "Spol";
$text['latitude'] = "Latitude";
$text['longitude'] = "Longitude";
$text['bookmarks'] = "Bookmarks";
$text['bookmark'] = "Doadaj Bookmark";
$text['mngbookmarks'] = "Idi na Bookmarks";
$text['bookmarked'] = "Bookmark dodan";
$text['remove'] = "Obriši";
$text['find_menu'] = "Nađi";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Groblja";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Karta događaja";
$text['gevents'] = "Događaj";
$text['glang'] = "&amp;hl=hr";
$text['googleearthlink'] = "Link na Google Earth";
$text['googlemaplink'] = "Link na Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "Nije označeno";
$text['located'] = "Locirano";
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
$text['mnusearchfornames'] = "Search";
$text['mnulastname'] = "Prezime";
$text['mnufirstname'] = "Ime";
$text['mnusearch'] = "Search";
$text['mnureset'] = "Počni ispočetka";
$text['mnulogon'] = "Login";
$text['mnulogout'] = "Logout";
$text['mnufeatures'] = "Ostale opcije";
$text['mnuregister'] = "Registriraj se za korisnicki account";
$text['mnuadvancedsearch'] = "Napredno pretraživanje";
$text['mnulastnames'] = "Prezimena";
$text['mnustatistics'] = "Statistika";
$text['mnuphotos'] = "Fotografije";
$text['mnuhistories'] = "Povijest";
$text['mnumyancestors'] = "Fotografije &amp; Povijest predaka od [Person]";
$text['mnucemeteries'] = "Groblja";
$text['mnutombstones'] = "Nadgobni spomenici";
$text['mnureports'] = "Izvješca";
$text['mnusources'] = "Sources";
$text['mnuwhatsnew'] = "Što je novog";
$text['mnushowlog'] = "Zapis pristupa";
$text['mnulanguage'] = "Promijeni jezik";
$text['mnuadmin'] = "Administracija";
$text['welcome'] = "Dobrodošli";
$text['contactus'] = "Kontaktirajete nas";

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
