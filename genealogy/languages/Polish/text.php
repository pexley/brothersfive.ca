<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Przegl�daj wszystkie �r�d�a";
		$text['shorttitle'] = "Kr�tki tytu�";
		$text['callnum'] = "Nr wywo�ania";
		$text['author'] = "Autor";
		$text['publisher'] = "Publikuj�cy";
		$text['other'] = "Inne informacje";
		$text['sourceid'] = "ID �r�d�a";
		$text['moresrc'] = "Wi�cej �r�de�";
		$text['repoid'] = "ID repozytorium";
		$text['browseallrepos'] = "Przegl�daj wszystkie repozytoria";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nowy j�zyk";
		$text['changelanguage'] = "Zmiana j�zyka";
		$text['languagesaved'] = "Zapisz j�zyk";
		//added in 7.0.0
		$text['sitemaint'] = "Strona jest w trakcie aktualizacji";
		$text['standby'] = "Z powodu aktualizacji bazy danych strona jest chwilowo niedost�pna. Prosz� spr�bowa� za jaki� czas ponownie. Je�li strona pozostanie przez d�u�szy czas niedost�pna, prosimy zwr�ci� si� do administratora <a href=\"suggest.php\"></a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM zaczynaj od";
		$text['producegedfrom'] = "Tw�rz plik gedcom z";
		$text['numgens'] = "Liczba generacji";
		$text['includelds'] = "��cznie z informacjami LDS";
		$text['buildged'] = "Buduj GEDCOM";
		$text['gedstartfrom'] = "Zaczynaj GEDCOM od";
		$text['nomaxgen'] = "Musisz wskaza� maksymaln� liczb� generacji. Prosz� powr�� i popraw ten b��d";
		$text['gedcreatedfrom'] = "Tw�rz GEDCOM z";
		$text['gedcreatedfor'] = "buduj dla";

		$text['enteremail'] = "Prosz�, podaj poprawny adres e-mail.";
		$text['creategedfor'] = "Tw�rz GEDCOM";
		$text['email'] = "Adres e-mail";
		$text['suggestchange'] = "Proponowane zmiany";
		$text['yourname'] = "Twoje nazwisko";
		$text['comments'] = "Uwagi i komentarze";
		$text['comments2'] = "Komentarze";
		$text['submitsugg'] = "Dodaj sugesti�";
		$text['proposed'] = "Propozycja zmian";
		$text['mailsent'] = "Dziekujemy, list wys�any.";
		$text['mailnotsent'] = "Przepraszamy, Tw�j list nie m�g� byc wys�any. Please contact xxx directly at yyy.";
		$text['mailme'] = "Wy�lij kopi� na ten adres";
		//added in 5.0.5
		$text['entername'] = "Podaj swoje imi�";
		$text['entercomments'] = "Wpisz swoje uwagi";
		$text['sendmsg'] = "Wy�lij";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Zdj�cia i historie dla";
		$text['indinfofor'] = "Informacja indywidualna dla";
		$text['reliability'] = "Pewno��";
		$text['pp'] = "skr.";
		$text['age'] = "Wiek";
		$text['agency'] = "Urz�d";
		$text['cause'] = "Przyczyna";
		$text['suggested'] = "Sugerowane";
		$text['closewindow'] = "Zamknij to okno";
		$text['thanks'] = "Dzi�kujemy";
		$text['received'] = "Twoja sugestia zostanie dostarczona do administratora tej strony.";
		//added in 6.0.0
		$text['association'] = "Zwi�zek";
		//added in 7.0.0
		$text['indreport'] = "Raport indywidualny";
		$text['indreportfor'] = "Raport indywidualny dla";
		$text['general'] = "Og�lny";
		$text['labels'] = "Etykiety";
		$text['bkmkvis'] = "<strong>Uwaga:</strong> Te zak�adki b�d� widoczne tylko na tym komputerze i tylko w tej wyszukiwarce internetowej.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Kalkulator pokrewie�stwa";
		$text['findrel'] = "Znajd� pokrewie�stwo";
		$text['person1'] = "Osoba 1:";
		$text['person2'] = "Osoba 2:";
		$text['calculate'] = "Oblicz";
		$text['select2inds'] = "Wybierz dwie osoby.";
		$text['findpersonid'] = "�majd� ID osoby";
		$text['enternamepart'] = "Podaj cz�� imienia i/lub nazwiska";
		$text['pleasenamepart'] = "Podaj cz�� imienia lub nazwiska.";
		$text['clicktoselect'] = "Kliknij, aby wybra�";
		$text['nobirthinfo'] = "Brak informacji o urodzeniu";
		$text['relateto'] = "Pokrewnie�stwo z";
		$text['sameperson'] = "Ta sama osoba wyst�puje dwa razy.";
		$text['notrelated'] = "Te dwie osoby nie s� spokrewnione w obr�bie xxx pokole�.";
		$text['findrelinstr'] = "Dla ustalenia pokrewie�stwa dw�ch os�b naci�nij 'Szukaj' aby zlokalizowa� istniej�ce osoby a nast�pnie kliknij na 'Oblicz'.";
		$text['gencheck'] = "Maksymalna liczba pokole�<br />do sprawdzenia";
		$text['sometimes'] = "(Czasami sprawdzenie innej liczby pokole� daje inny resultat.)";
		$text['findanother'] = "Szukaj innego pokrewie�stwa";
		//added in 6.0.0
		$text['brother'] = "brat";
		$text['sister'] = "siostra";
		$text['sibling'] = "rodze�stwo";
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
		$text['rhusband'] = "m�� ";
		$text['rwife'] = "�ona ";
		$text['rspouse'] = "partner ";
		$text['son'] = "syn";
		$text['daughter'] = "c�rka";
		$text['rchild'] = "dziecko";
		$text['sil'] = "zi��";
		$text['dil'] = "synowa";
		$text['sdil'] = "zi�� lub synowa";
		$text['gson'] = "xxx wnuk";
		$text['gdau'] = "xxx wnuczka";
		$text['gsondau'] = "xxx wnuk/wnuczka";
		$text['great'] = "pra";
		$text['spouses'] = "s� ma��e�stwem";
		$text['is'] = "jest";
		//changed in 6.0.0
		$text['changeto'] = "Zmie� na (podaj ID):";
		//added in 6.0.0
		$text['notvalid'] = "jest to albo niewa�ny ID osoby,albo nie ma go w bazie danych. Spr�buj jeszcze raz.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Arkusz rodzninny dla";
		$text['ldsords'] = "LDS Ordinances";
		$text['baptizedlds'] = "Baptized (LDS)";
		$text['endowedlds'] = "Endowed (LDS)";
		$text['sealedplds'] = "Sealed P (LDS)";
		$text['sealedslds'] = "Sealed S (LDS)";
		$text['otherspouse'] = "Inny wsp�ma��onek";
		//changed in 7.0.0
		$text['husband'] = "M��";
		$text['wife'] = "�ona";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "ur.";
		$text['capaltbirthabbr'] = "w";
		$text['capdeathabbr'] = "zm.";
		$text['capburialabbr'] = "pog.";
		$text['capplaceabbr'] = "w";
		$text['capmarrabbr'] = "�l.";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Ponownie narysuj z";
		$text['scrollnote'] = "Uwaga: By� mo�e musisz przewin�� w prawo lub w d� aby wszystko zobaczy�.";
		$text['unknownlit'] = "Nieznany";
		$text['popupnote1'] = " = Dodatkowe informacje";
		$text['popupnote2'] = " = Nowy rodow�d";
		$text['pedcompact'] = "Kompaktowe";
		$text['pedstandard'] = "Standartowe";
		$text['pedtextonly'] = "Tekst";
		$text['descendfor'] = "Potomkowie od";
		$text['maxof'] = "Najwi�cej z";
		$text['gensatonce'] = "Poka� generacje jednocze�nie.";
		$text['sonof'] = "syn";
		$text['daughterof'] = "c�rka";
		$text['childof'] = "dziecko";
		$text['stdformat'] = "Format standardowy";

		$text['ahnentafel'] = "Drzewo";
		$text['addnewfam'] = "Dodaj now� rodzin�";
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
		$text['graphdesc'] = "Diagram potomk�w do tego miejsca";
		$text['collapse'] = "Sk�adanie";
		$text['expand'] = "Rozszerzanie";
		$text['pedbox'] = "Boks";
		//changed in 6.0.0
		$text['regformat'] = "Rejestr";
		$text['extrasexpl'] = "= Dla tej osoby istnieje ju� przynajmniej jedno zdj�cie,historia lub inne medium.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nowy diagram";
		$text['mediaavail'] = "S� media";
		//changed in 7.0.0
		$text['pedigreefor'] = "Rodow�d dla";
		//added in 7.0.0
		$text['pedigreech'] = "Drzewo genealogiczne";
		$text['datesloc'] = "Daty i miejsca";
		$text['borchr'] = "narodziny/chrzciny - zgon/pogrzeb (dwa)";
		$text['nobd'] = "Brak danych dotycz�cych narodzin lub zgonu";
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
		$text['noreports'] = "Raporty nie istniej�.";
		$text['reportname'] = "Nazwa raportu";
		$text['allreports'] = "Wszystkie raporty";
		$text['report'] = "Raport";
		$text['error'] = "B��d";
		$text['reportsyntax'] = "Sk�adnia pytania do tego raportu";
		$text['wasincorrect'] = "by� b��dny i dlatego raport nie m�g� zosta� utworzony. Skontaktuj si� z administratorem";
		$text['query'] = "Zapytanie";
		$text['errormessage'] = "B��d";
		$text['equals'] = "jest r�wny";
		$text['contains'] = "zawiera";
		$text['startswith'] = "zaczyna si� od";
		$text['endswith'] = "ko�czy si� na";
		$text['soundexof'] = "soundex of";
		$text['metaphoneof'] = "metaphone of";
		$text['plusminus10'] = "+/- 10 lat od";
		$text['lessthan'] = "mniejszy od";
		$text['greaterthan'] = "wi�cej ni�";
		$text['lessthanequal'] = "Mniejszy lub r�wny z";
		$text['greaterthanequal'] = "Wi�kszy lub r�wny z";
		$text['equalto'] = "r�wny";
		$text['tryagain'] = "Spr�buj ponownie pisz�c nazwisko du�ymi literami";
		$text['text_for'] = "dla";
		$text['searchnames'] = "Szukaj";
		$text['joinwith'] = "Po��cz z";
		$text['cap_and'] = "ORAZ";
		$text['cap_or'] = "LUB";
		$text['showspouse'] = "Poka� wsp�ma��onka (pokazuje duplikaty je�li osoba ma wi�cej ni� jednego partnera)";
		$text['submitquery'] = "Zatwierdzenie pytania";
		$text['birthplace'] = "Miejsce urodzenia";
		$text['deathplace'] = "Miejsce zgonu";
		$text['birthdatetr'] = "Rok urodzenia";
		$text['deathdatetr'] = "Rok zgonu";
		$text['plusminus2'] = "+/- 2 lata od";
		$text['resetall'] = "Usu� wpisy";

		$text['showdeath'] = "Poka� informacje o zgonie i pogrzebie";
		$text['altbirthplace'] = "Miejsce chrztu";
		$text['altbirthdatetr'] = "Rok chrztu";
		$text['burialplace'] = "Miejsce pogrzebu";
		$text['burialdatetr'] = "Rok pogrzebu";
		$text['event'] = "Wydarznie(a)";
		$text['day'] = "Dzie�";
		$text['month'] = "Miesi�c";
		$text['keyword'] = "S�owo kluczowe (ie, \"Abt\")";
		$text['explain'] = "Podaj sk�adniki daty aby zobaczy� zgodno�ci wydarze�. Pozostaw pole wolne aby zobaczy� wszystkie zgodno�ci.";
		$text['enterdate'] = "Podaj lub wybierz ostatni z podanych: dzie�, miesi�c, rok, s�owo kluczowe";
		$text['fullname'] = "Imie i nazwisko";
		$text['birthdate'] = "Data urodzenia";
		$text['altbirthdate'] = "Data chrztu";
		$text['marrdate'] = "Data �lubu";
		$text['spouseid'] = "ID wsp�ma��onka";
		$text['spousename'] = "Imi� wsp�ma��onka";
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
		$text['marrplace'] = "Miejsce �lubu";
		$text['spousesurname'] = "Nazwisko wsp�ma��onka";
		//changed in 6.0.0
		$text['spousemore'] = "Je�eli podasz nazwisko wsp�ma��onka, to musisz poda� r�wnie� p�e�.";
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
		$text['mysphoto'] = "Zagadkowe zdj�cia";
		$text['mysperson'] = "Zagadkowe osoby";
		$text['joinor'] = "Opcja 'Do��cz w LUB' nie mo�e by� u�yta przy nazwiskach wsp�ma��onk�w";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Logi dla";
		$text['mostrecentactions'] = "Ostatnio wykonywanych czynno�ci";
		$text['autorefresh'] = "Autood�wie�anie (30 sekund)";
		$text['refreshoff'] = "Wy��cz autood�wie�anie";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cmentarze i nagrobki";
		$text['showallhsr'] = "Poka� wszystkie nagrobki";
		$text['in'] = "w";
		$text['showmap'] = "Poka� map�";
		$text['headstonefor'] = "Nagrobek dla";
		$text['photoof'] = "Zdj�cie";
		$text['firstpage'] = "Pierwsza strona";
		$text['lastpage'] = "Ostatnia strona";
		$text['photoowner'] = "U�ytkownik/�r�d�o";

		$text['nocemetery'] = "Brak cmentarza";
		$text['iptc005'] = "Tytu�";
		$text['iptc020'] = "Dodatkowe kategorie";
		$text['iptc040'] = "Specjalne instrukcje";
		$text['iptc055'] = "Data utworzenia";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Pozycja autora";
		$text['iptc090'] = "Miasto";
		$text['iptc095'] = "Wojew�dztwo.";
		$text['iptc101'] = "Kraj";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Artyku�";
		$text['iptc110'] = "�r�d�o";
		$text['iptc115'] = "�r�d�o zdj�cia";
		$text['iptc116'] = "Prawa autorskie";
		$text['iptc120'] = "Tytu�";
		$text['iptc122'] = "Autor tytu�u";
		$text['mapof'] = "Mapa";
		$text['regphotos'] = "Poka� z opisami";
		$text['gallery'] = "Tylko miniatury";
		$text['cemphotos'] = "Zdj�cia cmentarza";
		//changed in 6.0.0
		$text['photosize'] = "Wymiary";
		//added in 6.0.0
        	$text['iptc010'] = "Priorytet";
		$text['filesize'] = "Rozmiar pliku";
		$text['seeloc'] = "Zobacz lokalizacj�";
		$text['showall'] = "Poka� wszystko";
		$text['editmedia'] = "Edytuj media";
		$text['viewitem'] = "Widok tej pozycji";
		$text['editcem'] = "Edytuj cmentarz";
		$text['numitems'] = "# pozycje";
		$text['allalbums'] = "Wszystkie albumy";
		//added in 6.1.0
		$text['slidestart'] = "Start przegl�du slajd�w";
		$text['slidestop'] = "Pauza przegl�du slajd�w";
		$text['slideresume'] = "Zako�cz przegl�d slajd�w";
		$text['slidesecs'] = "Sekundy dla ka�dego slajdu:";
		$text['minussecs'] = "minus 0.5 sekundy";
		$text['plussecs'] = "plus 0.5 sekundy";
		//added in 7.0.0
		$text['nocountry'] = "Nieznany kraj";
		$text['nostate'] = "Nieznane wojew�dztwo (stan))";
		$text['nocounty'] = "Nieznana prowincja";
		$text['nocity'] = "Nieznane miasto";
		$text['nocemname'] = "Nieznana nazwa cmentarza";
		$text['plot'] = "Sektor";
		$text['location'] = "Miejscowo��";
		$text['editalbum'] = "Edycja albumu";
		$text['mediamaptext'] = "<strong>Uwaga:</strong> Podczas przesuwania strza�ki myszy po zdj�ciu b�d� si� pokazywa� nazwiska. Klikaj�c na wybrane otrzymasz bardziej szczeg�owe informacje.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Poka� nazwiska na liter�";
		$text['showtop'] = "Poka� g��wny";
		$text['showallsurnames'] = "Poka� wszystkie nazwiska";
		$text['sortedalpha'] = "sortuj alfabetycznie";
		$text['byoccurrence'] = "wyst�puj�cych trafie�";
		$text['firstchars'] = "Pierwsze litery";
		$text['top'] = "G��wny";
		$text['mainsurnamepage'] = "Strona g��wna nazwisk";
		$text['allsurnames'] = "Wszystkie nazwiska";
		$text['showmatchingsurnames'] = "Kliknij na nazwisko, aby zobaczy� wszystkie dane.";
		$text['backtotop'] = "Wr�� do g��wnych";
		$text['beginswith'] = "Rozpoczyna si� na";
		$text['allbeginningwith'] = "Wszystkie nazwiska zaczynaj�ce si� na";
		$text['numoccurrences'] = "ilo�� wyst�puj�cych w nawiasie";
		$text['placesstarting'] = "Zaczynaj od najwi�kszych miejsc";
		$text['showmatchingplaces'] = "Kliknij na jedna ze znalezionych pozycji, aby ograniczy� pole wyszukiwa�. Kliknij na ikon� lupki, aby zobaczy� szczeg�y.";
		$text['totalnames'] = "wszystkie osoby";
		$text['showallplaces'] = "Poka� wszystkie miejsca";
		$text['totalplaces'] = "Wszystkie miejsca";
		$text['mainplacepage'] = "Strona g��wna miejsc";
		$text['allplaces'] = "Wszystkie najwi�ksze miejsca";
		$text['placescont'] = "Poka� wszystkie miejsca";
		//added in 7.0.0
		$text['top30'] = "30 najcz�ciej wyst�puj�cyh nazwisk";
		$text['top30places'] = "30 najwi�kszych lokalizacji";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(ostatnie xx dni)";
		$text['historiesdocs'] = "Historie";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Zdj�cie";
		$text['history'] = "Historia/Dokument";
		//changed in 7.0.0
		$text['husbid'] = "ID m�a";
		$text['husbname'] = "Imi� m�a";
		$text['wifeid'] = "ID �ony";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Usu�";
		$text['addperson'] = "Dodaj osob�";
		$text['nobirth'] = "Ta osoba nie mo�e zosta� dodana poniewa� brakuje jej aktualnej daty urodzin";
		$text['noliving'] = "Ta osoba jest zaznaczona jako �yj�ca i nie mo�e zosta� dodana, poniewa� nie jeste� do tego uprawniony/a";
		$text['event'] = "Wydarznie(a)";
		$text['chartwidth'] = "Szeroko�� diagramu";
		//changed in 6.0.0
		$text['timelineinstr'] = "Dodaj osob�";
		//added in 6.0.0
		$text['togglelines'] = "Rysuj linie";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Przegl�daj wszystkie drzewa";
		$text['treename'] = "Nazwa drzewa";
		$text['owner'] = "W�a�ciciel";
		$text['address'] = "Adres";
		$text['city'] = "Miasto";
		$text['state'] = "Wojew�dztwo.";
		$text['zip'] = "Numer kodu poczt.";
		$text['country'] = "Kraj";
		$text['email'] = "Adres e-mail";
		$text['phone'] = "Telefon";
		$text['username'] = "Nazwa u�ytkownika";
		$text['password'] = "Has�o";
		$text['loginfailed'] = "Z�y login.";

		$text['regnewacct'] = "Rejestracja na istniej�ce drzewo";
		$text['realname'] = "Twoje prawdziwe nazwisko i imi�";
		$text['phone'] = "Telefon";
		$text['email'] = "Adres e-mail";
		$text['address'] = "Adres";
		$text['comments'] = "Uwagi i komentarze";
		$text['submit'] = "Zapisz";
		$text['leaveblank'] = "(pozostaw puste je�li chodzi o nowe drzewo)";
		$text['required'] = "Pole obowi�zkowe.Osoby,kt�re nie podadz� nazwiska ani nazwy drzewa, nie b�d� rejestrowane.<br>O rodzaju uprawnie� nowego u�ytkownika decyduje w�a�ciciel drzewa. Do chwili jego decyzji nowy u�ytkownik nie ma �adnych uprawnie�.";
		$text['enterpassword'] = "Podaj has�o.";
		$text['enterusername'] = "Podaj nazw� u�ytkownika.";
		$text['failure'] = "Przepraszamy. Ta nazwa drzewa jest zaj�ta albo nie podano Tree ID, gdzie trzeba poda� kr�tk� nazw� drzewa, jedno s�owo, bez spacji. Prosimy powr�ci� do rejestracji i wybra� now� nazw�.";
		$text['success'] = "Dzi�kujemy. Twoje dane zosta�y zarejestrowane. Skontaktujemy si� z Tob� po aktywacji Twojego konta lub je�li b�dziemy potrzebowali dalszych informacji.";
		$text['emailsubject'] = "W TNG zarejestrowa� si� nowy u�ytkownik";
		$text['emailmsg'] = "Otrzyma�e� wniosek o za�o�enie konta dla nowego u�ytkownika TNG. Zaloguj si� na konto administratora i nadaj mu odpowiednie uprawnienia. Je�li zatwierdzisz t� rejestracj� nale�y powiadomi� wnioskodawc� odpowiadaj�c na t� wiadomo��.";
		//changed in 5.0.0
		$text['enteremail'] = "Prosz�, podaj poprawny adres e-mail.";
		$text['website'] = "Strona www";
		$text['nologin'] = "Nie masz loginu?";
		$text['loginsent'] = "Informacja zosta�a wys�ana";
		$text['loginnotsent'] = "Informacja nie zosta�a wys�ana";
		$text['enterrealname'] = "Podaj prawdziwe nazwisko i imi�.";
		$text['rempass'] = "Pozosta� zalogowany";
		$text['morestats'] = "Wi�cej statystyk";
		//added in 6.0.0
		$text['accmail'] = "<strong>UWAGA:</strong> Aby otrzyma� poczt� od administratora dotycz�c� Twego konta sprawd�, czy ta domena nie jest przez Ciebie blokowana <br>(czy wiadomo�� nie zostanie potraktowana jako spam).";
		$text['newpassword'] = "Nowe has�o";
		$text['resetpass'] = "Zmie� has�o";
		//added in 6.1.0
		$text['nousers'] = "Ta forma nie mo�e zosta� u�yta do co najmniej jednego istniej�cego zapisu u�ytkownika. Je�li ty jeste� w�a�cicielem strony, przejd� do Administracja / U�ytkownicy, by utworzy� Twoje konto administratora.";
		//added in 7.0.0
		$text['noregs'] = "Niestety aktualnie nie przyjmujemy rejestracji nowych u�ytkownik�w. W przypadku pyta� lub uwag dotycz�cych tej strony prosimy o <a href=\"suggest.php\">kontakt</a>.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Ilo��";
		$text['totindividuals'] = "Wszystkie osoby";
		$text['totmales'] = "Wszyscy m�czy�ni";
		$text['totfemales'] = "Wszystkie kobiety";
		$text['totunknown'] = "Wszyscy nieznanej p�ci";
		$text['totliving'] = "Wszyscy �yj�cy";
		$text['totfamilies'] = "Wszystkie rodziny";
		$text['totuniquesn'] = "Wszystkie unikalne nazwiska";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Wszystkie �r�d�a";
		$text['avglifespan'] = "�rednia d�ugo�� �ycia";
		$text['earliestbirth'] = "Najwcze�niej urodzony/a";
		$text['longestlived'] = "Najstarsi zmarli";
		$text['years'] = "lat";
		$text['days'] = "dni";
		$text['age'] = "Wiek";
		$text['agedisclaimer'] = "Obliczenia bazuj�ce na wieku odnosz� si� do os�b z podan� dat� urodzenia <EM><B>oraz</B></EM> �mierci.  Przy niepe�nych datach(np., data urodzenia podana jako \"1945\" lub \"JAN 1860\"), obliczenia mog� by� nieprecyzyjne.";
		$text['treedetail'] = "Wi�cej informacji o tym drzewie";
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
		$text['perms'] = "Uprawnienia zosta�y nadane.";
		$text['noperms'] = "Tym plikom nie mog� zosta� nadane uprawnienia:";
		$text['manual'] = "Prosz� ustawi� je r�cznie.";
		$text['folder'] = "Folder";
		$text['created'] = "zosta�y utworzone";
		$text['nocreate'] = "nie mo�na utworzy�. Prosz� utworzy� go r�cznie.";
		$text['infosaved'] = "Informacje zapisane, po��czenie sprawdzone!";
		$text['tablescr'] = "Tabele zosta�y utworzone!";
		$text['notables'] = "Nast�puj�ce tabele nie mog�y zosta� utworzone:";
		$text['nocomm'] = "TNG nie mo�e skomunikowa� si� z baz� danych. Tabele nie zosta�y utworzone.";
		$text['newdb'] = "Informacje zapisane, sprawdzone po��czenie, nowa baza danych utworzona:";
		$text['noattach'] = "Informacje zapisane. Po��czenia wykonane i uaktualniona baza danych, ale TNG nie mo�e do niej do��czy�.";
		$text['nodb'] = "Informacje zapisane. Po��czenie wykonane, ale baza danych nie istnieje i nie mo�e zosta� utworzona. Prosz� sprawdzi�, czy nazwa bazy danych jest poprawna, lub u�y� panelu sterowania, aby j� utworzy�.";
		$text['noconn'] = "Informacje zapisane, ale po��czenie nie powiod�o si�. Jeden lub wi�cej z nast�puj�cych jest nieprawid�owy:";
		$text['exists'] = "istnieje";
		$text['loginfirst'] = "Musisz si� najpierw zalogowa�.";
		$text['noop'] = "�adna operacja nie zosta�a wykonana.";
		break;
}

//common
$text['matches'] = "Wyniki";
$text['description'] = "Opis";
$text['notes'] = "Notatki";
$text['status'] = "Status";
$text['newsearch'] = "Nowe szukanie";
$text['pedigree'] = "Rodow�d";
$text['birthabbr'] = "ur.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Zobacz zdj�cie";
$text['andlocation'] = "&amp; po�o�enie";
$text['accessedby'] = "udost�pnione przez";
$text['go'] = "Dalej";
$text['family'] = "Rodzina";
$text['children'] = "Dzieci";
$text['tree'] = "Drzewo";
$text['alltrees'] = "Wszystkie drzewa";
$text['nosurname'] = "[bez nazwiska]";
$text['thumb'] = "Miniatura";
$text['people'] = "Ludzie";
$text['title'] = "Tytu�";
$text['suffix'] = "Przyrostek";
$text['nickname'] = "Przydomek";
$text['deathabbr'] = "zm.";
$text['lastmodified'] = "Ostatnia modyfikacja";
$text['married'] = "Ma��e�stwo";
//$text['photos'] = "Photos";
$text['name'] = "Nazwa";
$text['lastfirst'] = "Nazwisko, imi�";
$text['bornchr'] = "Data i miejsce urodzenia";
$text['individuals'] = "Osoby";
$text['families'] = "Rodziny";
$text['personid'] = "ID osoby";
$text['sources'] = "�r�d�a";
$text['unknown'] = "Nieznane";
$text['father'] = "Ojciec";
$text['mother'] = "Matka";
$text['born'] = "Urodzenie";
$text['christened'] = "Chrzest";
$text['died'] = "Zgon";
$text['buried'] = "Pogrzeb";
$text['spouse'] = "Ma��onek/ka";
$text['parents'] = "Rodzice";
$text['text'] = "Tekst";
$text['language'] = "J�zyk";
$text['burialabbr'] = "Pog.";
$text['descendchart'] = "Linia potomk�w";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Osoba";
$text['edit'] = "Edycja";
$text['date'] = "Data";
$text['place'] = "Miejsce";
$text['login'] = "Zaloguj";
$text['logout'] = "Wyloguj";
$text['marrabbr'] = "ma��.";
$text['groupsheet'] = "Arkusz rodzinny";
$text['text_and'] = "oraz";
$text['generation'] = "Pokolenie";
$text['filename'] = "Nazwa pliku";
$text['id'] = "ID";
$text['search'] = "Szukaj";
$text['living'] = "�yj�cy";
$text['user'] = "U�ytkownik";
$text['firstname'] = "Imi�";
$text['lastname'] = "Nazwisko";
$text['searchresults'] = "Szukaj w wynikach";
$text['diedburied'] = "Zmar�";
$text['homepage'] = "Pocz�tek";
$text['find'] = "Znajd�...";
$text['relationship'] = "Pokrewie�stwo";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Linia czasu";
$text['yesabbr'] = "R";
$text['divorced'] = "Rozwiedziony/a";
$text['indlinked'] = "Link do";
$text['branch'] = "Ga���";
$text['moreind'] = "Wi�cej os�b";
$text['morefam'] = "Wi�cej rodzin";
$text['livingdoc'] = "Przynajmniej jedna �yj�ca osoba jest zwi�zana z tym dokumentem - detale ukryte.";
$text['source'] = "�r�d�o";
$text['surnamelist'] = "Lista nazwisk";
$text['generations'] = "Pokolenia";
$text['refresh'] = "Od�wie�";
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
$text['livingnote'] = "Przynajmniej jedna �yj�ca osoba jest zwi�zana z t� notatk� - detale ukryte.";
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
$text['findplaces'] = "Wyszukaj wszystkie osoby powi�zane z t� lokalizacj�";
$text['morelinks'] = "Wi�cej ��czy";
$text['faminfo'] = "Informacja o rodzinie";
$text['persinfo'] = "Info o osobie";
$text['srcinfo'] = "Informacje o �r�dle";
$text['fact'] = "Zdarzenie";
$text['goto'] = "Wybierz stron�";
$text['tngprint'] = "Drukuj";
//changed in 6.0.0
$text['livingphoto'] = "Przynajmniej jedna �yj�ca osoba jest zwi�zana z t� pozycj� - detale ukryte.";
$text['databasestatistics'] = "Statystyki";
//moved here in 6.0.0
$text['child'] = "Dziecko";
$text['repoinfo'] = "Informacja o repozytoriach";
$text['tng_reset'] = "Cofnij";
$text['noresults'] = "Brak rezultat�w";
//added in 6.0.0
$text['allmedia'] = "Wszystkie media";
$text['repositories'] = "Repozytoria";
$text['albums'] = "Albumy";
$text['cemeteries'] = "Cmentarze";
$text['surnames'] = "Nazwiska";
$text['dates'] = "Daty";
$text['link'] = "Link";
$text['media'] = "Media";
$text['gender'] = "P�e�";
$text['latitude'] = "Szeroko��";
$text['longitude'] = "D�ugo��";
$text['bookmarks'] = "Zak�adki";
$text['bookmark'] = "Dodaj zak�adki";
$text['mngbookmarks'] = "Id� do zak�adek";
$text['bookmarked'] = "Zak�adka dodana";
$text['remove'] = "Usu�";
$text['find_menu'] = "Znajd�";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Cmentarz";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Mapa wydarzenia";
$text['gevents'] = "Wydarzenie";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "��cze do Google Earth";
$text['googlemaplink'] = "��cze do Google Maps";
$text['gmaplegend'] = "Legenda szpilek";
//moved here in 7.0.0
$text['unmarked'] = "Nieoznakowany";
$text['located'] = "Zlokalizowany";
//added in 7.0.0
$text['albclicksee'] = "Kliknij aby pokaza� wszystkie elementy tego albumu";
$text['notyetlocated'] = "Jeszcze nie zlokalizowany";
$text['cremated'] = "Skremowany";
$text['missing'] = "Zaginiony";
$text['page'] = "Strona";
$text['pdfgen'] = "Generator PDF";
$text['blank'] = "Pusty diagram";
$text['none'] = "Brak";
$text['fonts'] = "Czcionki";
$text['header'] = "Nag��wek";
$text['data'] = "Data";
$text['pgsetup'] = "Ustawienia strony";
$text['pgsize'] = "Wielko�� strony";
$text['letter'] = "Pismo";
$text['legal'] = "Legal";
$text['orient'] = "Ukierunkowanie";
$text['portrait'] = "Format pionowy";
$text['landscape'] = "Format poziomy";
$text['tmargin'] = "G�rna kraw�d�";
$text['bmargin'] = "Dolna kraw�d�";
$text['lmargin'] = "Lewa kraw�d�";
$text['rmargin'] = "Prawa kraw�d�";
$text['createch'] = "Tworzenie diagramu";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Niewyja�nione zagadki";
$text['latupdates'] = "Ostatnia aktualizacja";
$text['featphoto'] = "Przedstawione zdj�cie";
$text['news'] = "Nowo�ci";
$text['ourhist'] = "Historia naszej rodziny";
$text['ourhistanc'] = "Historia i genealogia naszej rodziny";
$text['ourpages'] = "Strona genealogiczna naszej rodziny";
$text['pwrdby'] = "This site powered by";
$text['writby'] = "written by";
$text['searchtngnet'] = "Szukaj w TNG Network (GENDEX)";
$text['viewphotos'] = "Zobacz wszystkie zdj�cia";
$text['anon'] = "Jeste� w tej chwili anonimowy";
$text['whichbranch'] = "Do kt�rej ga��zi nale�ysz?";
$text['featarts'] = "Przedstawione artyku�y";
$text['maintby'] = "Zarz�dzane przez";
$text['createdon'] = "Utworzono dnia";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Strona domowa";
$text['mnusearchfornames'] = "Szukaj";
$text['mnulastname'] = "Nazwisko";
$text['mnufirstname'] = "Imi�";
$text['mnusearch'] = "Szukaj";
$text['mnureset'] = "Zacznij ponownie";
$text['mnulogon'] = "Zaloguj";
$text['mnulogout'] = "Wyloguj";
$text['mnufeatures'] = "Inne opcje";
$text['mnuregister'] = "Rejestracja nowego konta";
$text['mnuadvancedsearch'] = "Szukanie zaawansowane";
$text['mnulastnames'] = "Nazwiska";
$text['mnustatistics'] = "Statystyka";
$text['mnuphotos'] = "Zdj�cia";
$text['mnuhistories'] = "Historie";
$text['mnumyancestors'] = "Zdj�cia &amp; Historie przodk�w [osoba]";
$text['mnucemeteries'] = "Cmentarze";
$text['mnutombstones'] = "Nagrobki";
$text['mnureports'] = "Raporty";
$text['mnusources'] = "�r�d�a";
$text['mnuwhatsnew'] = "Co nowego";
$text['mnushowlog'] = "Ostatnio wykonywane czynno�ci";
$text['mnulanguage'] = "Zmiana j�zyka";
$text['mnuadmin'] = "Administracja";
$text['welcome'] = "Witamy";
$text['contactus'] = "Kontakt z Administracj�";

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
