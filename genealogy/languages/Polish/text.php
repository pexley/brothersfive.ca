<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Przegl±daj wszystkie ¼ród³a";
		$text['shorttitle'] = "Krótki tytu³";
		$text['callnum'] = "Nr wywo³ania";
		$text['author'] = "Autor";
		$text['publisher'] = "Publikuj±cy";
		$text['other'] = "Inne informacje";
		$text['sourceid'] = "ID ¼ród³a";
		$text['moresrc'] = "Wiêcej ¼róde³";
		$text['repoid'] = "ID repozytorium";
		$text['browseallrepos'] = "Przegl±daj wszystkie repozytoria";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nowy jêzyk";
		$text['changelanguage'] = "Zmiana jêzyka";
		$text['languagesaved'] = "Zapisz jêzyk";
		//added in 7.0.0
		$text['sitemaint'] = "Strona jest w trakcie aktualizacji";
		$text['standby'] = "Z powodu aktualizacji bazy danych strona jest chwilowo niedostêpna. Proszê spróbowaæ za jaki¶ czas ponownie. Je¶li strona pozostanie przez d³u¿szy czas niedostêpna, prosimy zwróciæ siê do administratora <a href=\"suggest.php\"></a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM zaczynaj od";
		$text['producegedfrom'] = "Twórz plik gedcom z";
		$text['numgens'] = "Liczba generacji";
		$text['includelds'] = "£±cznie z informacjami LDS";
		$text['buildged'] = "Buduj GEDCOM";
		$text['gedstartfrom'] = "Zaczynaj GEDCOM od";
		$text['nomaxgen'] = "Musisz wskazaæ maksymaln± liczbê generacji. Proszê powróæ i popraw ten b³±d";
		$text['gedcreatedfrom'] = "Twórz GEDCOM z";
		$text['gedcreatedfor'] = "buduj dla";

		$text['enteremail'] = "Proszê, podaj poprawny adres e-mail.";
		$text['creategedfor'] = "Twórz GEDCOM";
		$text['email'] = "Adres e-mail";
		$text['suggestchange'] = "Proponowane zmiany";
		$text['yourname'] = "Twoje nazwisko";
		$text['comments'] = "Uwagi i komentarze";
		$text['comments2'] = "Komentarze";
		$text['submitsugg'] = "Dodaj sugestiê";
		$text['proposed'] = "Propozycja zmian";
		$text['mailsent'] = "Dziekujemy, list wys³any.";
		$text['mailnotsent'] = "Przepraszamy, Twój list nie móg³ byc wys³any. Please contact xxx directly at yyy.";
		$text['mailme'] = "Wy¶lij kopiê na ten adres";
		//added in 5.0.5
		$text['entername'] = "Podaj swoje imiê";
		$text['entercomments'] = "Wpisz swoje uwagi";
		$text['sendmsg'] = "Wy¶lij";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Zdjêcia i historie dla";
		$text['indinfofor'] = "Informacja indywidualna dla";
		$text['reliability'] = "Pewno¶æ";
		$text['pp'] = "skr.";
		$text['age'] = "Wiek";
		$text['agency'] = "Urz±d";
		$text['cause'] = "Przyczyna";
		$text['suggested'] = "Sugerowane";
		$text['closewindow'] = "Zamknij to okno";
		$text['thanks'] = "Dziêkujemy";
		$text['received'] = "Twoja sugestia zostanie dostarczona do administratora tej strony.";
		//added in 6.0.0
		$text['association'] = "Zwi±zek";
		//added in 7.0.0
		$text['indreport'] = "Raport indywidualny";
		$text['indreportfor'] = "Raport indywidualny dla";
		$text['general'] = "Ogólny";
		$text['labels'] = "Etykiety";
		$text['bkmkvis'] = "<strong>Uwaga:</strong> Te zak³adki bêd± widoczne tylko na tym komputerze i tylko w tej wyszukiwarce internetowej.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Kalkulator pokrewieñstwa";
		$text['findrel'] = "Znajd¼ pokrewieñstwo";
		$text['person1'] = "Osoba 1:";
		$text['person2'] = "Osoba 2:";
		$text['calculate'] = "Oblicz";
		$text['select2inds'] = "Wybierz dwie osoby.";
		$text['findpersonid'] = "¿majd¼ ID osoby";
		$text['enternamepart'] = "Podaj czê¶æ imienia i/lub nazwiska";
		$text['pleasenamepart'] = "Podaj czê¶æ imienia lub nazwiska.";
		$text['clicktoselect'] = "Kliknij, aby wybraæ";
		$text['nobirthinfo'] = "Brak informacji o urodzeniu";
		$text['relateto'] = "Pokrewnieñstwo z";
		$text['sameperson'] = "Ta sama osoba wystêpuje dwa razy.";
		$text['notrelated'] = "Te dwie osoby nie s± spokrewnione w obrêbie xxx pokoleñ.";
		$text['findrelinstr'] = "Dla ustalenia pokrewieñstwa dwóch osób naci¶nij 'Szukaj' aby zlokalizowaæ istniej±ce osoby a nastêpnie kliknij na 'Oblicz'.";
		$text['gencheck'] = "Maksymalna liczba pokoleñ<br />do sprawdzenia";
		$text['sometimes'] = "(Czasami sprawdzenie innej liczby pokoleñ daje inny resultat.)";
		$text['findanother'] = "Szukaj innego pokrewieñstwa";
		//added in 6.0.0
		$text['brother'] = "brat";
		$text['sister'] = "siostra";
		$text['sibling'] = "rodzeñstwo";
		$text['uncle'] = "xxx wuj";
		$text['aunt'] = "txxx ciotka";
		$text['uncleaunt'] = "xxx wuj/ciotka";
		$text['nephew'] = "xxx bratanek/siostrzeniec";
		$text['niece'] = "xxx bratanica/siostrzenica";
		$text['nephnc'] = "xxx bratanek,siostrzeniec/bratanica,siostrzenica";
		$text['mcousin'] = "xxx kuzyn";
		$text['fcousin'] = "txxx kuzynka";
		$text['cousin'] = "xxx kuzyn/kuzynka";
		$text['removed'] = "times removed";
		$text['rhusband'] = "m±¿ ";
		$text['rwife'] = "¿ona ";
		$text['rspouse'] = "partner ";
		$text['son'] = "syn";
		$text['daughter'] = "córka";
		$text['rchild'] = "dziecko";
		$text['sil'] = "ziêæ";
		$text['dil'] = "synowa";
		$text['sdil'] = "ziêæ lub synowa";
		$text['gson'] = "xxx wnuk";
		$text['gdau'] = "xxx wnuczka";
		$text['gsondau'] = "xxx wnuk/wnuczka";
		$text['great'] = "pra";
		$text['spouses'] = "s± ma³¿eñstwem";
		$text['is'] = "jest";
		//changed in 6.0.0
		$text['changeto'] = "Zmieñ na (podaj ID):";
		//added in 6.0.0
		$text['notvalid'] = "jest to albo niewa¿ny ID osoby,albo nie ma go w bazie danych. Spróbuj jeszcze raz.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Arkusz rodzninny dla";
		$text['ldsords'] = "LDS Ordinances";
		$text['baptizedlds'] = "Baptized (LDS)";
		$text['endowedlds'] = "Endowed (LDS)";
		$text['sealedplds'] = "Sealed P (LDS)";
		$text['sealedslds'] = "Sealed S (LDS)";
		$text['otherspouse'] = "Inny wspó³ma³¿onek";
		//changed in 7.0.0
		$text['husband'] = "M±¿";
		$text['wife'] = "¯ona";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "ur.";
		$text['capaltbirthabbr'] = "w";
		$text['capdeathabbr'] = "zm.";
		$text['capburialabbr'] = "pog.";
		$text['capplaceabbr'] = "w";
		$text['capmarrabbr'] = "¶l.";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Ponownie narysuj z";
		$text['scrollnote'] = "Uwaga: Byæ mo¿e musisz przewin±æ w prawo lub w dó³ aby wszystko zobaczyæ.";
		$text['unknownlit'] = "Nieznany";
		$text['popupnote1'] = " = Dodatkowe informacje";
		$text['popupnote2'] = " = Nowy rodowód";
		$text['pedcompact'] = "Kompaktowe";
		$text['pedstandard'] = "Standartowe";
		$text['pedtextonly'] = "Tekst";
		$text['descendfor'] = "Potomkowie od";
		$text['maxof'] = "Najwiêcej z";
		$text['gensatonce'] = "Poka¿ generacje jednocze¶nie.";
		$text['sonof'] = "syn";
		$text['daughterof'] = "córka";
		$text['childof'] = "dziecko";
		$text['stdformat'] = "Format standardowy";

		$text['ahnentafel'] = "Drzewo";
		$text['addnewfam'] = "Dodaj now± rodzinê";
		$text['editfam'] = "Edycja rodziny";
		$text['side'] = "strona";
		$text['familyof'] = "Rodzina";
		$text['paternal'] = "Partnerski";
		$text['maternal'] = "Matczyny";
		$text['gen1'] = "Probant";
		$text['gen2'] = "Rodzice";
		$text['gen3'] = "Dziadkowie";
		$text['gen4'] = "Pradziadkowie";
		$text['gen5'] = "Prapradziadkowie";
		$text['gen6'] = "Praprapradziadkowie";
		$text['gen7'] = "Prapraprapradziadkowie";
		$text['gen8'] = "Praprapraprapradziadkowie";
		$text['gen9'] = "Prapraprapraprapradziadkowie";
		$text['gen10'] = "Praprapraprapraprapradziadkowie";
		$text['gen11'] = "Prapraprapraprapraprapradziadkowie";
		$text['gen12'] = "Praprapraprapraprapraprapradziadkowie";
		$text['graphdesc'] = "Diagram potomków do tego miejsca";
		$text['collapse'] = "Sk³adanie";
		$text['expand'] = "Rozszerzanie";
		$text['pedbox'] = "Boks";
		//changed in 6.0.0
		$text['regformat'] = "Rejestr";
		$text['extrasexpl'] = "= Dla tej osoby istnieje ju¿ przynajmniej jedno zdjêcie,historia lub inne medium.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nowy diagram";
		$text['mediaavail'] = "S± media";
		//changed in 7.0.0
		$text['pedigreefor'] = "Rodowód dla";
		//added in 7.0.0
		$text['pedigreech'] = "Drzewo genealogiczne";
		$text['datesloc'] = "Daty i miejsca";
		$text['borchr'] = "narodziny/chrzciny - zgon/pogrzeb (dwa)";
		$text['nobd'] = "Brak danych dotycz±cych narodzin lub zgonu";
		$text['bcdb'] = "narodziny/chrzciny/zgon/pogrzeb (cztery)";
		$text['numsys'] = "System numerowania";
		$text['gennums'] = "Numery generacji";
		$text['henrynums'] = "Numerowanie w.g Henry'ego";
		$text['abovnums'] = "Numerowanie w.g d'Aboville";
		$text['devnums'] = "Numerowanie w.g de Villiers";
		$text['dispopts'] = "Opcje widoku";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "Raporty nie istniej±.";
		$text['reportname'] = "Nazwa raportu";
		$text['allreports'] = "Wszystkie raporty";
		$text['report'] = "Raport";
		$text['error'] = "B³±d";
		$text['reportsyntax'] = "Sk³adnia pytania do tego raportu";
		$text['wasincorrect'] = "by³ b³êdny i dlatego raport nie móg³ zostaæ utworzony. Skontaktuj siê z administratorem";
		$text['query'] = "Zapytanie";
		$text['errormessage'] = "B³±d";
		$text['equals'] = "jest równy";
		$text['contains'] = "zawiera";
		$text['startswith'] = "zaczyna siê od";
		$text['endswith'] = "koñczy siê na";
		$text['soundexof'] = "soundex of";
		$text['metaphoneof'] = "metaphone of";
		$text['plusminus10'] = "+/- 10 lat od";
		$text['lessthan'] = "mniejszy od";
		$text['greaterthan'] = "wiêcej ni¿";
		$text['lessthanequal'] = "Mniejszy lub równy z";
		$text['greaterthanequal'] = "Wiêkszy lub równy z";
		$text['equalto'] = "równy";
		$text['tryagain'] = "Spróbuj ponownie pisz±c nazwisko du¿ymi literami";
		$text['text_for'] = "dla";
		$text['searchnames'] = "Szukaj";
		$text['joinwith'] = "Po³±cz z";
		$text['cap_and'] = "ORAZ";
		$text['cap_or'] = "LUB";
		$text['showspouse'] = "Poka¿ wspó³ma³¿onka (pokazuje duplikaty je¶li osoba ma wiêcej ni¿ jednego partnera)";
		$text['submitquery'] = "Zatwierdzenie pytania";
		$text['birthplace'] = "Miejsce urodzenia";
		$text['deathplace'] = "Miejsce zgonu";
		$text['birthdatetr'] = "Rok urodzenia";
		$text['deathdatetr'] = "Rok zgonu";
		$text['plusminus2'] = "+/- 2 lata od";
		$text['resetall'] = "Usuñ wpisy";

		$text['showdeath'] = "Poka¿ informacje o zgonie i pogrzebie";
		$text['altbirthplace'] = "Miejsce chrztu";
		$text['altbirthdatetr'] = "Rok chrztu";
		$text['burialplace'] = "Miejsce pogrzebu";
		$text['burialdatetr'] = "Rok pogrzebu";
		$text['event'] = "Wydarznie(a)";
		$text['day'] = "Dzieñ";
		$text['month'] = "Miesi±c";
		$text['keyword'] = "S³owo kluczowe (ie, \"Abt\")";
		$text['explain'] = "Podaj sk³adniki daty aby zobaczyæ zgodno¶ci wydarzeñ. Pozostaw pole wolne aby zobaczyæ wszystkie zgodno¶ci.";
		$text['enterdate'] = "Podaj lub wybierz ostatni z podanych: dzieñ, miesi±c, rok, s³owo kluczowe";
		$text['fullname'] = "Imie i nazwisko";
		$text['birthdate'] = "Data urodzenia";
		$text['altbirthdate'] = "Data chrztu";
		$text['marrdate'] = "Data ¶lubu";
		$text['spouseid'] = "ID wspó³ma³¿onka";
		$text['spousename'] = "Imiê wspó³ma³¿onka";
		$text['deathdate'] = "Data zgonu";
		$text['burialdate'] = "Data pogrzebu";
		$text['changedate'] = "Data ostatniej modyfikacji";
		$text['gedcom'] = "Drzewo";
		$text['baptdate'] = "Baptism Date (LDS)";
		$text['baptplace'] = "Baptism Place (LDS)";
		$text['endldate'] = "Endowment Date (LDS)";
		$text['endlplace'] = "Endowment Place (LDS)";
		$text['ssealdate'] = "Seal Date S (LDS)";
		$text['ssealplace'] = "Seal Place S (LDS)";
		$text['psealdate'] = "Seal Date P (LDS)";
		$text['psealplace'] = "Seal Place P (LDS)";
		$text['marrplace'] = "Miejsce ¶lubu";
		$text['spousesurname'] = "Nazwisko wspó³ma³¿onka";
		//changed in 6.0.0
		$text['spousemore'] = "Je¿eli podasz nazwisko wspó³ma³¿onka, to musisz podaæ równie¿ p³eæ.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 lat od";
		$text['exists'] = "istnieje";
		$text['dnexist'] = "nie istnieje";
		//added in 6.0.3
		$text['divdate'] = "Data separacji";
		$text['divplace'] = "Miejsce separacji";
		//changed in 7.0.0
		$text['otherevents'] = "Inne wydarzenia";
		//added in 7.0.0
		$text['numresults'] = "Wyniki dla strony";
		$text['mysphoto'] = "Zagadkowe zdjêcia";
		$text['mysperson'] = "Zagadkowe osoby";
		$text['joinor'] = "Opcja 'Do³±cz w LUB' nie mo¿e byæ u¿yta przy nazwiskach wspóma³¿onków";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Logi dla";
		$text['mostrecentactions'] = "Ostatnio wykonywanych czynno¶ci";
		$text['autorefresh'] = "Autood¶wie¿anie (30 sekund)";
		$text['refreshoff'] = "Wy³±cz autood¶wie¿anie";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cmentarze i nagrobki";
		$text['showallhsr'] = "Poka¿ wszystkie nagrobki";
		$text['in'] = "w";
		$text['showmap'] = "Poka¿ mapê";
		$text['headstonefor'] = "Nagrobek dla";
		$text['photoof'] = "Zdjêcie";
		$text['firstpage'] = "Pierwsza strona";
		$text['lastpage'] = "Ostatnia strona";
		$text['photoowner'] = "U¿ytkownik/¼ród³o";

		$text['nocemetery'] = "Brak cmentarza";
		$text['iptc005'] = "Tytu³";
		$text['iptc020'] = "Dodatkowe kategorie";
		$text['iptc040'] = "Specjalne instrukcje";
		$text['iptc055'] = "Data utworzenia";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Pozycja autora";
		$text['iptc090'] = "Miasto";
		$text['iptc095'] = "Województwo.";
		$text['iptc101'] = "Kraj";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Artyku³";
		$text['iptc110'] = "¬ród³o";
		$text['iptc115'] = "¬ród³o zdjêcia";
		$text['iptc116'] = "Prawa autorskie";
		$text['iptc120'] = "Tytu³";
		$text['iptc122'] = "Autor tytu³u";
		$text['mapof'] = "Mapa";
		$text['regphotos'] = "Poka¿ z opisami";
		$text['gallery'] = "Tylko miniatury";
		$text['cemphotos'] = "Zdjêcia cmentarza";
		//changed in 6.0.0
		$text['photosize'] = "Wymiary";
		//added in 6.0.0
        	$text['iptc010'] = "Priorytet";
		$text['filesize'] = "Rozmiar pliku";
		$text['seeloc'] = "Zobacz lokalizacjê";
		$text['showall'] = "Poka¿ wszystko";
		$text['editmedia'] = "Edytuj media";
		$text['viewitem'] = "Widok tej pozycji";
		$text['editcem'] = "Edytuj cmentarz";
		$text['numitems'] = "# pozycje";
		$text['allalbums'] = "Wszystkie albumy";
		//added in 6.1.0
		$text['slidestart'] = "Start przegl±du slajdów";
		$text['slidestop'] = "Pauza przegl±du slajdów";
		$text['slideresume'] = "Zakoñcz przegl±d slajdów";
		$text['slidesecs'] = "Sekundy dla ka¿dego slajdu:";
		$text['minussecs'] = "minus 0.5 sekundy";
		$text['plussecs'] = "plus 0.5 sekundy";
		//added in 7.0.0
		$text['nocountry'] = "Nieznany kraj";
		$text['nostate'] = "Nieznane województwo (stan))";
		$text['nocounty'] = "Nieznana prowincja";
		$text['nocity'] = "Nieznane miasto";
		$text['nocemname'] = "Nieznana nazwa cmentarza";
		$text['plot'] = "Sektor";
		$text['location'] = "Miejscowo¶æ";
		$text['editalbum'] = "Edycja albumu";
		$text['mediamaptext'] = "<strong>Uwaga:</strong> Podczas przesuwania strza³ki myszy po zdjêciu bêd± siê pokazywaæ nazwiska. Klikaj±c na wybrane otrzymasz bardziej szczegó³owe informacje.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Poka¿ nazwiska na literê";
		$text['showtop'] = "Poka¿ g³ówny";
		$text['showallsurnames'] = "Poka¿ wszystkie nazwiska";
		$text['sortedalpha'] = "sortuj alfabetycznie";
		$text['byoccurrence'] = "wystêpuj±cych trafieñ";
		$text['firstchars'] = "Pierwsze litery";
		$text['top'] = "G³ówny";
		$text['mainsurnamepage'] = "Strona g³ówna nazwisk";
		$text['allsurnames'] = "Wszystkie nazwiska";
		$text['showmatchingsurnames'] = "Kliknij na nazwisko, aby zobaczyæ wszystkie dane.";
		$text['backtotop'] = "Wróæ do g³ównych";
		$text['beginswith'] = "Rozpoczyna siê na";
		$text['allbeginningwith'] = "Wszystkie nazwiska zaczynaj±ce siê na";
		$text['numoccurrences'] = "ilo¶æ wystêpuj±cych w nawiasie";
		$text['placesstarting'] = "Zaczynaj od najwiêkszych miejsc";
		$text['showmatchingplaces'] = "Kliknij na jedna ze znalezionych pozycji, aby ograniczyæ pole wyszukiwañ. Kliknij na ikonê lupki, aby zobaczyæ szczegó³y.";
		$text['totalnames'] = "wszystkie osoby";
		$text['showallplaces'] = "Poka¿ wszystkie miejsca";
		$text['totalplaces'] = "Wszystkie miejsca";
		$text['mainplacepage'] = "Strona g³ówna miejsc";
		$text['allplaces'] = "Wszystkie najwiêksze miejsca";
		$text['placescont'] = "Poka¿ wszystkie miejsca";
		//added in 7.0.0
		$text['top30'] = "30 najczê¶ciej wystêpuj±cyh nazwisk";
		$text['top30places'] = "30 najwiêkszych lokalizacji";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(ostatnie xx dni)";
		$text['historiesdocs'] = "Historie";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Zdjêcie";
		$text['history'] = "Historia/Dokument";
		//changed in 7.0.0
		$text['husbid'] = "ID mê¿a";
		$text['husbname'] = "Imiê mê¿a";
		$text['wifeid'] = "ID ¿ony";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Usuñ";
		$text['addperson'] = "Dodaj osobê";
		$text['nobirth'] = "Ta osoba nie mo¿e zostaæ dodana poniewa¿ brakuje jej aktualnej daty urodzin";
		$text['noliving'] = "Ta osoba jest zaznaczona jako ¿yj±ca i nie mo¿e zostaæ dodana, poniewa¿ nie jeste¶ do tego uprawniony/a";
		$text['event'] = "Wydarznie(a)";
		$text['chartwidth'] = "Szeroko¶æ diagramu";
		//changed in 6.0.0
		$text['timelineinstr'] = "Dodaj osobê";
		//added in 6.0.0
		$text['togglelines'] = "Rysuj linie";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Przegl±daj wszystkie drzewa";
		$text['treename'] = "Nazwa drzewa";
		$text['owner'] = "W³a¶ciciel";
		$text['address'] = "Adres";
		$text['city'] = "Miasto";
		$text['state'] = "Województwo.";
		$text['zip'] = "Numer kodu poczt.";
		$text['country'] = "Kraj";
		$text['email'] = "Adres e-mail";
		$text['phone'] = "Telefon";
		$text['username'] = "Nazwa u¿ytkownika";
		$text['password'] = "Has³o";
		$text['loginfailed'] = "Z³y login.";

		$text['regnewacct'] = "Rejestracja na istniej±ce drzewo";
		$text['realname'] = "Twoje prawdziwe nazwisko i imiê";
		$text['phone'] = "Telefon";
		$text['email'] = "Adres e-mail";
		$text['address'] = "Adres";
		$text['comments'] = "Uwagi i komentarze";
		$text['submit'] = "Zapisz";
		$text['leaveblank'] = "(pozostaw puste je¶li chodzi o nowe drzewo)";
		$text['required'] = "Pole obowi±zkowe.Osoby,które nie podadz± nazwiska ani nazwy drzewa, nie bêd± rejestrowane.<br>O rodzaju uprawnieñ nowego u¿ytkownika decyduje w³a¶ciciel drzewa. Do chwili jego decyzji nowy u¿ytkownik nie ma ¿adnych uprawnieñ.";
		$text['enterpassword'] = "Podaj has³o.";
		$text['enterusername'] = "Podaj nazwê u¿ytkownika.";
		$text['failure'] = "Przepraszamy. Ta nazwa drzewa jest zajêta albo nie podano Tree ID, gdzie trzeba podaæ krótk± nazwê drzewa, jedno s³owo, bez spacji. Prosimy powróciæ do rejestracji i wybraæ now± nazwê.";
		$text['success'] = "Dziêkujemy. Twoje dane zosta³y zarejestrowane. Skontaktujemy siê z Tob± po aktywacji Twojego konta lub je¶li bêdziemy potrzebowali dalszych informacji.";
		$text['emailsubject'] = "W TNG zarejestrowa³ siê nowy u¿ytkownik";
		$text['emailmsg'] = "Otrzyma³e¶ wniosek o za³o¿enie konta dla nowego u¿ytkownika TNG. Zaloguj siê na konto administratora i nadaj mu odpowiednie uprawnienia. Je¶li zatwierdzisz tê rejestracjê nale¿y powiadomiæ wnioskodawcê odpowiadaj±c na tê wiadomo¶æ.";
		//changed in 5.0.0
		$text['enteremail'] = "Proszê, podaj poprawny adres e-mail.";
		$text['website'] = "Strona www";
		$text['nologin'] = "Nie masz loginu?";
		$text['loginsent'] = "Informacja zosta³a wys³ana";
		$text['loginnotsent'] = "Informacja nie zosta³a wys³ana";
		$text['enterrealname'] = "Podaj prawdziwe nazwisko i imiê.";
		$text['rempass'] = "Pozostañ zalogowany";
		$text['morestats'] = "Wiêcej statystyk";
		//added in 6.0.0
		$text['accmail'] = "<strong>UWAGA:</strong> Aby otrzymaæ pocztê od administratora dotycz±c± Twego konta sprawd¼, czy ta domena nie jest przez Ciebie blokowana <br>(czy wiadomo¶æ nie zostanie potraktowana jako spam).";
		$text['newpassword'] = "Nowe has³o";
		$text['resetpass'] = "Zmieñ has³o";
		//added in 6.1.0
		$text['nousers'] = "Ta forma nie mo¿e zostaæ u¿yta do co najmniej jednego istniej±cego zapisu u¿ytkownika. Je¶li ty jeste¶ w³a¶cicielem strony, przejd¼ do Administracja / U¿ytkownicy, by utworzyæ Twoje konto administratora.";
		//added in 7.0.0
		$text['noregs'] = "Niestety aktualnie nie przyjmujemy rejestracji nowych u¿ytkowników. W przypadku pytañ lub uwag dotycz±cych tej strony prosimy o <a href=\"suggest.php\">kontakt</a>.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Ilo¶æ";
		$text['totindividuals'] = "Wszystkie osoby";
		$text['totmales'] = "Wszyscy mê¿czy¼ni";
		$text['totfemales'] = "Wszystkie kobiety";
		$text['totunknown'] = "Wszyscy nieznanej p³ci";
		$text['totliving'] = "Wszyscy ¿yj±cy";
		$text['totfamilies'] = "Wszystkie rodziny";
		$text['totuniquesn'] = "Wszystkie unikalne nazwiska";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Wszystkie ¼ród³a";
		$text['avglifespan'] = "¦rednia d³ugo¶æ ¿ycia";
		$text['earliestbirth'] = "Najwcze¶niej urodzony/a";
		$text['longestlived'] = "Najstarsi zmarli";
		$text['years'] = "lat";
		$text['days'] = "dni";
		$text['age'] = "Wiek";
		$text['agedisclaimer'] = "Obliczenia bazuj±ce na wieku odnosz± siê do osób z podan± dat± urodzenia <EM><B>oraz</B></EM> ¶mierci.  Przy niepe³nych datach(np., data urodzenia podana jako \"1945\" lub \"JAN 1860\"), obliczenia mog± byæ nieprecyzyjne.";
		$text['treedetail'] = "Wiêcej informacji o tym drzewie";
		//added in 6.0.0
		$text['total'] = "Wszystkie";
		break;

	case "notes":
		$text['browseallnotes'] = "Przeszukaj wszystkie notatki";
		break;

	case "help":
		$text['menuhelp'] = "Klucz menu";
		break;

	case "install":
		$text['perms'] = "Uprawnienia zosta³y nadane.";
		$text['noperms'] = "Tym plikom nie mog± zostaæ nadane uprawnienia:";
		$text['manual'] = "Proszê ustawiæ je rêcznie.";
		$text['folder'] = "Folder";
		$text['created'] = "zosta³y utworzone";
		$text['nocreate'] = "nie mo¿na utworzyæ. Proszê utworzyæ go rêcznie.";
		$text['infosaved'] = "Informacje zapisane, po³±czenie sprawdzone!";
		$text['tablescr'] = "Tabele zosta³y utworzone!";
		$text['notables'] = "Nastêpuj±ce tabele nie mog³y zostaæ utworzone:";
		$text['nocomm'] = "TNG nie mo¿e skomunikowaæ siê z baz± danych. Tabele nie zosta³y utworzone.";
		$text['newdb'] = "Informacje zapisane, sprawdzone po³±czenie, nowa baza danych utworzona:";
		$text['noattach'] = "Informacje zapisane. Po³±czenia wykonane i uaktualniona baza danych, ale TNG nie mo¿e do niej do³±czyæ.";
		$text['nodb'] = "Informacje zapisane. Po³±czenie wykonane, ale baza danych nie istnieje i nie mo¿e zostaæ utworzona. Proszê sprawdziæ, czy nazwa bazy danych jest poprawna, lub u¿yæ panelu sterowania, aby j± utworzyæ.";
		$text['noconn'] = "Informacje zapisane, ale po³±czenie nie powiod³o siê. Jeden lub wiêcej z nastêpuj±cych jest nieprawid³owy:";
		$text['exists'] = "istnieje";
		$text['loginfirst'] = "Musisz siê najpierw zalogowaæ.";
		$text['noop'] = "¯adna operacja nie zosta³a wykonana.";
		break;
}

//common
$text['matches'] = "Wyniki";
$text['description'] = "Opis";
$text['notes'] = "Notatki";
$text['status'] = "Status";
$text['newsearch'] = "Nowe szukanie";
$text['pedigree'] = "Rodowód";
$text['birthabbr'] = "ur.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Zobacz zdjêcie";
$text['andlocation'] = "&amp; po³o¿enie";
$text['accessedby'] = "udostêpnione przez";
$text['go'] = "Dalej";
$text['family'] = "Rodzina";
$text['children'] = "Dzieci";
$text['tree'] = "Drzewo";
$text['alltrees'] = "Wszystkie drzewa";
$text['nosurname'] = "[bez nazwiska]";
$text['thumb'] = "Miniatura";
$text['people'] = "Ludzie";
$text['title'] = "Tytu³";
$text['suffix'] = "Przyrostek";
$text['nickname'] = "Przydomek";
$text['deathabbr'] = "zm.";
$text['lastmodified'] = "Ostatnia modyfikacja";
$text['married'] = "Ma³¿eñstwo";
//$text['photos'] = "Photos";
$text['name'] = "Nazwa";
$text['lastfirst'] = "Nazwisko, imiê";
$text['bornchr'] = "Data i miejsce urodzenia";
$text['individuals'] = "Osoby";
$text['families'] = "Rodziny";
$text['personid'] = "ID osoby";
$text['sources'] = "¬ród³a";
$text['unknown'] = "Nieznane";
$text['father'] = "Ojciec";
$text['mother'] = "Matka";
$text['born'] = "Urodzenie";
$text['christened'] = "Chrzest";
$text['died'] = "Zgon";
$text['buried'] = "Pogrzeb";
$text['spouse'] = "Ma³¿onek/ka";
$text['parents'] = "Rodzice";
$text['text'] = "Tekst";
$text['language'] = "Jêzyk";
$text['burialabbr'] = "Pog.";
$text['descendchart'] = "Linia potomków";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Osoba";
$text['edit'] = "Edycja";
$text['date'] = "Data";
$text['place'] = "Miejsce";
$text['login'] = "Zaloguj";
$text['logout'] = "Wyloguj";
$text['marrabbr'] = "ma³¿.";
$text['groupsheet'] = "Arkusz rodzinny";
$text['text_and'] = "oraz";
$text['generation'] = "Pokolenie";
$text['filename'] = "Nazwa pliku";
$text['id'] = "ID";
$text['search'] = "Szukaj";
$text['living'] = "¯yj±cy";
$text['user'] = "U¿ytkownik";
$text['firstname'] = "Imiê";
$text['lastname'] = "Nazwisko";
$text['searchresults'] = "Szukaj w wynikach";
$text['diedburied'] = "Zmar³";
$text['homepage'] = "Pocz±tek";
$text['find'] = "Znajd¼...";
$text['relationship'] = "Pokrewieñstwo";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Linia czasu";
$text['yesabbr'] = "R";
$text['divorced'] = "Rozwiedziony/a";
$text['indlinked'] = "Link do";
$text['branch'] = "Ga³±¼";
$text['moreind'] = "Wiêcej osób";
$text['morefam'] = "Wiêcej rodzin";
$text['livingdoc'] = "Przynajmniej jedna ¿yj±ca osoba jest zwi±zana z tym dokumentem - detale ukryte.";
$text['source'] = "¬ród³o";
$text['surnamelist'] = "Lista nazwisk";
$text['generations'] = "Pokolenia";
$text['refresh'] = "Od¶wie¿";
$text['whatsnew'] = "Co nowego";
$text['reports'] = "Raporty";
$text['placelist'] = "Lista miejsc";
$text['baptizedlds'] = "Baptized (LDS)";
$text['endowedlds'] = "Endowed (LDS)";
$text['sealedplds'] = "Sealed P (LDS)";
$text['sealedslds'] = "Sealed S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Przodkowie";
$text['descendants'] = "Potomkowie";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Data ostatniego importu GEDCOM-u";
$text['type'] = "Typ";
$text['savechanges'] = "Zapisz zmiany";
$text['familyid'] = "ID rodziny";
$text['headstone'] = "Nagrobki";
$text['historiesdocs'] = "Historie";
$text['livingnote'] = "Przynajmniej jedna ¿yj±ca osoba jest zwi±zana z t± notatk± - detale ukryte.";
$text['anonymous'] = "anonimowy";
$text['places'] = "Miejsca";
$text['anniversaries'] = "Daty i rocznice";
$text['administration'] = "Administracja";
$text['help'] = "Pomoc";
//$text['documents'] = "Documents";
$text['year'] = "rok";
$text['all'] = "Wszystko";
$text['repository'] = "Repozytorium";
$text['address'] = "Adres";
$text['suggest'] = "Sugestie";
$text['editevent'] = "Sugestia zmiany dla tego wydarzenia";
$text['findplaces'] = "Wyszukaj wszystkie osoby powi±zane z t± lokalizacj±";
$text['morelinks'] = "Wiêcej ³±czy";
$text['faminfo'] = "Informacja o rodzinie";
$text['persinfo'] = "Info o osobie";
$text['srcinfo'] = "Informacje o ¼ródle";
$text['fact'] = "Zdarzenie";
$text['goto'] = "Wybierz stronê";
$text['tngprint'] = "Drukuj";
//changed in 6.0.0
$text['livingphoto'] = "Przynajmniej jedna ¿yj±ca osoba jest zwi±zana z t± pozycj± - detale ukryte.";
$text['databasestatistics'] = "Statystyki";
//moved here in 6.0.0
$text['child'] = "Dziecko";
$text['repoinfo'] = "Informacja o repozytoriach";
$text['tng_reset'] = "Cofnij";
$text['noresults'] = "Brak rezultatów";
//added in 6.0.0
$text['allmedia'] = "Wszystkie media";
$text['repositories'] = "Repozytoria";
$text['albums'] = "Albumy";
$text['cemeteries'] = "Cmentarze";
$text['surnames'] = "Nazwiska";
$text['dates'] = "Daty";
$text['link'] = "Link";
$text['media'] = "Media";
$text['gender'] = "P³eæ";
$text['latitude'] = "Szeroko¶æ";
$text['longitude'] = "D³ugo¶æ";
$text['bookmarks'] = "Zak³adki";
$text['bookmark'] = "Dodaj zak³adki";
$text['mngbookmarks'] = "Id¼ do zak³adek";
$text['bookmarked'] = "Zak³adka dodana";
$text['remove'] = "Usuñ";
$text['find_menu'] = "Znajd¼";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Cmentarz";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Mapa wydarzenia";
$text['gevents'] = "Wydarzenie";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "£±cze do Google Earth";
$text['googlemaplink'] = "£±cze do Google Maps";
$text['gmaplegend'] = "Legenda szpilek";
//moved here in 7.0.0
$text['unmarked'] = "Nieoznakowany";
$text['located'] = "Zlokalizowany";
//added in 7.0.0
$text['albclicksee'] = "Kliknij aby pokazaæ wszystkie elementy tego albumu";
$text['notyetlocated'] = "Jeszcze nie zlokalizowany";
$text['cremated'] = "Skremowany";
$text['missing'] = "Zaginiony";
$text['page'] = "Strona";
$text['pdfgen'] = "Generator PDF";
$text['blank'] = "Pusty diagram";
$text['none'] = "Brak";
$text['fonts'] = "Czcionki";
$text['header'] = "Nag³ówek";
$text['data'] = "Data";
$text['pgsetup'] = "Ustawienia strony";
$text['pgsize'] = "Wielko¶æ strony";
$text['letter'] = "Pismo";
$text['legal'] = "Legal";
$text['orient'] = "Ukierunkowanie";
$text['portrait'] = "Format pionowy";
$text['landscape'] = "Format poziomy";
$text['tmargin'] = "Górna krawêd¼";
$text['bmargin'] = "Dolna krawêd¼";
$text['lmargin'] = "Lewa krawêd¼";
$text['rmargin'] = "Prawa krawêd¼";
$text['createch'] = "Tworzenie diagramu";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Niewyja¶nione zagadki";
$text['latupdates'] = "Ostatnia aktualizacja";
$text['featphoto'] = "Przedstawione zdjêcie";
$text['news'] = "Nowo¶ci";
$text['ourhist'] = "Historia naszej rodziny";
$text['ourhistanc'] = "Historia i genealogia naszej rodziny";
$text['ourpages'] = "Strona genealogiczna naszej rodziny";
$text['pwrdby'] = "This site powered by";
$text['writby'] = "written by";
$text['searchtngnet'] = "Szukaj w TNG Network (GENDEX)";
$text['viewphotos'] = "Zobacz wszystkie zdjêcia";
$text['anon'] = "Jeste¶ w tej chwili anonimowy";
$text['whichbranch'] = "Do której ga³êzi nale¿ysz?";
$text['featarts'] = "Przedstawione artyku³y";
$text['maintby'] = "Zarz±dzane przez";
$text['createdon'] = "Utworzono dnia";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Strona domowa";
$text['mnusearchfornames'] = "Szukaj";
$text['mnulastname'] = "Nazwisko";
$text['mnufirstname'] = "Imiê";
$text['mnusearch'] = "Szukaj";
$text['mnureset'] = "Zacznij ponownie";
$text['mnulogon'] = "Zaloguj";
$text['mnulogout'] = "Wyloguj";
$text['mnufeatures'] = "Inne opcje";
$text['mnuregister'] = "Rejestracja nowego konta";
$text['mnuadvancedsearch'] = "Szukanie zaawansowane";
$text['mnulastnames'] = "Nazwiska";
$text['mnustatistics'] = "Statystyka";
$text['mnuphotos'] = "Zdjêcia";
$text['mnuhistories'] = "Historie";
$text['mnumyancestors'] = "Zdjêcia &amp; Historie przodków [osoba]";
$text['mnucemeteries'] = "Cmentarze";
$text['mnutombstones'] = "Nagrobki";
$text['mnureports'] = "Raporty";
$text['mnusources'] = "¬ród³a";
$text['mnuwhatsnew'] = "Co nowego";
$text['mnushowlog'] = "Ostatnio wykonywane czynno¶ci";
$text['mnulanguage'] = "Zmiana jêzyka";
$text['mnuadmin'] = "Administracja";
$text['welcome'] = "Witamy";
$text['contactus'] = "Kontakt z Administracj±";

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
