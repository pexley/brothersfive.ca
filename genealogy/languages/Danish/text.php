<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "S�g i alle kilder";
		$text['shorttitle'] = "Titel";
		$text['callnum'] = "Nummer";
		$text['author'] = "Forfatter";
		$text['publisher'] = "Udgiver";
		$text['other'] = "Andre informationer";
		$text['sourceid'] = "Kilde-ID";
		$text['moresrc'] = "Flere kilder";
		$text['repoid'] = "Arkiv-ID";
		$text['browseallrepos'] = "S�g i alle arkiver";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "New language";
		$text['changelanguage'] = "Change language";
		$text['languagesaved'] = "Language saved";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM begynder med";
		$text['producegedfrom'] = "Lav en GEDCOM fil fra";
		$text['numgens'] = "Antal generationer";
		$text['includelds'] = "Inkluder LDS information";
		$text['buildged'] = "Lav GEDCOM";
		$text['gedstartfrom'] = "GEDCOM begynder med";
		$text['nomaxgen'] = "Du skal angive antal generationer. Brug Tilbage-knap for at rette fejlen";
		$text['gedcreatedfrom'] = "GEDCOM oprettet fra";
		$text['gedcreatedfor'] = "GEDCOM oprettet for";

		$text['enteremail'] = "Skriv venligst en e-mail adresse.";
		$text['creategedfor'] = "Opret GEDCOM for";
		$text['email'] = "e-mail adresse";
		$text['suggestchange'] = "Foresl� en �ndring";
		$text['yourname'] = "Dit navn";
		$text['comments'] = "Bem�rkninger og kommentarer";
		$text['comments2'] = "Bem�rkninger";
		$text['submitsugg'] = "Send forslag";
		$text['proposed'] = "Foresl�et �ndring";
		$text['mailsent'] = "Tak. Din besked er sendt.";
		$text['mailnotsent'] = "Beklager, din besked kunne ikke leveres. Kontakt venligst xxx direkte p� yyy.";
		$text['mailme'] = "Send en kopi til denne adresse";
		//added in 5.0.5
		$text['entername'] = "Skriv venligst dit navn";
		$text['entercomments'] = "Skriv venligst dine kommentarer";
		$text['sendmsg'] = "Send meddelelse";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Billeder og historier for";
		$text['indinfofor'] = "Individuel info om";
		$text['reliability'] = "Kvalitet";
		$text['pp'] = "pp.";
		$text['age'] = "Alder";
		$text['agency'] = "Firma";
		$text['cause'] = "�rsag";
		$text['suggested'] = "Foresl�et";
		$text['closewindow'] = "Luk dette vindue";
		$text['thanks'] = "Tak";
		$text['received'] = "Dit forslag er videresendt.";
		//added in 6.0.0
		$text['association'] = "Tilknytning";
		//added in 7.0.0
		$text['indreport'] = "Individual Report";
		$text['indreportfor'] = "Individual Report for";
		$text['general'] = "General";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Sl�gtskabsberegner";
		$text['findrel'] = "Find sl�gtskab";
		$text['person1'] = "Person 1:";
		$text['person2'] = "Person 2:";
		$text['calculate'] = "Beregn";
		$text['select2inds'] = "V�lg to personer.";
		$text['findpersonid'] = "Find person-ID";
		$text['enternamepart'] = "skriv noget af for- og/eller efternavn";
		$text['pleasenamepart'] = "Skriv noget af for- eller efternavn.";
		$text['clicktoselect'] = "klik for at v�lge";
		$text['nobirthinfo'] = "Ingen f�dselsinformation";
		$text['relateto'] = "Sl�gtskab til";
		$text['sameperson'] = "De to personer er den samme.";
		$text['notrelated'] = "De to personer er ikke i sl�gt indenfor xxx generationer.";
		$text['findrelinstr'] = "For at vise sl�gtskabet mellem to personer, skal du bruge \\'Find\\'-knapperne nedenfor for at finde de aktuelle personer (eller behold de viste personer), derefter klikkes p� \\'Beregn\\'.";
		$text['gencheck'] = "Max. antal generationer,<br />der skal tjekkes";
		$text['sometimes'] = "(Sommetider kan man ved at tjekke et andet antal generationer f� et andet resultat.)";
		$text['findanother'] = "Find et andet sl�gtskab";
		//added in 6.0.0
		$text['brother'] = "bror til";
		$text['sister'] = "s�ster til";
		$text['sibling'] = "bror/s�ster";
		$text['uncle'] = "xxx onkel til";
		$text['aunt'] = "xxx tante til";
		$text['uncleaunt'] = "xxx onkel/tante til";
		$text['nephew'] = "xxx nev� til";
		$text['niece'] = "xxx niece til";
		$text['nephnc'] = "xxx nev�/niece til";
		$text['mcousin'] = "xxx f�tter/kusine til";
		$text['fcousin'] = "xxx f�tter/kusine til";
		$text['cousin'] = "xxx f�tter/kusine til";
		$text['removed'] = "gange forskudt";
		$text['rhusband'] = "�gtemand til ";
		$text['rwife'] = "hustru til ";
		$text['rspouse'] = "�gtef�lle til ";
		$text['son'] = "s�n af";
		$text['daughter'] = "datter af";
		$text['rchild'] = "barn af";
		$text['sil'] = "svigers�n til";
		$text['dil'] = "svigerdatter til";
		$text['sdil'] = "svigerdatter eller -s�n til";
		$text['gson'] = "xxx barnebarn af";
		$text['gdau'] = "xxx barnebarn af";
		$text['gsondau'] = "xxx barnebarn af";
		$text['great'] = "olde";
		$text['spouses'] = "er �gtef�ller";
		$text['is'] = "er";
		//changed in 6.0.0
		$text['changeto'] = "Skift til: (Indtast ID)";
		//added in 6.0.0
		$text['notvalid'] = "er ikke et gyldigt person-ID eller eksisterer ikke i denne database. Pr�v igen.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Familieskema for";
		$text['ldsords'] = "LDS ordinancer";
		$text['baptizedlds'] = "D�bt (LDS)";
		$text['endowedlds'] = "Begavet (LDS)";
		$text['sealedplds'] = "Beseglet F (LDS)";
		$text['sealedslds'] = "Beseglet � (LDS)";
		$text['otherspouse'] = "Andre partnere";
		//changed in 7.0.0
		$text['husband'] = "Mand";
		$text['wife'] = "Hustru";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "F";
		$text['capaltbirthabbr'] = "Dbt";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "B";
		$text['capplaceabbr'] = "S";
		$text['capmarrabbr'] = "G";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Tegn igen";
		$text['scrollnote'] = "NB: Du skal m�ske bladre ned for at se hele tr�et.";
		$text['unknownlit'] = "Ukendt";
		$text['popupnote1'] = " = Till�gsinformation";
		$text['popupnote2'] = " = Ny anetavle";
		$text['pedcompact'] = "Kompakt";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Kun tekst";
		$text['descendfor'] = "Efterkommere af";
		$text['maxof'] = "Maksimum";
		$text['gensatonce'] = "generationer vist samtidig.";
		$text['sonof'] = "s�n af";
		$text['daughterof'] = "datter af";
		$text['childof'] = "barn af";
		$text['stdformat'] = "Standardformat";

		$text['ahnentafel'] = "Anetavle";
		$text['addnewfam'] = "Tilf�j ny familie";
		$text['editfam'] = "Redig�r familie";
		$text['side'] = "Side";
		$text['familyof'] = "Familie til";
		$text['paternal'] = "Far";
		$text['maternal'] = "Mor";
		$text['gen1'] = "Selv";
		$text['gen2'] = "For�ldre";
		$text['gen3'] = "Bedstefor�ldre";
		$text['gen4'] = "Oldefor�ldre";
		$text['gen5'] = "Tipoldefor�ldre";
		$text['gen6'] = "Tiptip-oldefor�ldre";
		$text['gen7'] = "3xtip-oldefor�ldre";
		$text['gen8'] = "4xtip-oldefor�ldre";
		$text['gen9'] = "5xtip-oldefor�ldre";
		$text['gen10'] = "6xtip-oldefor�ldre";
		$text['gen11'] = "7xtip-oldefor�ldre";
		$text['gen12'] = "8xtip-oldefor�ldre";
		$text['graphdesc'] = "Efterkommere til dette punkt";
		$text['collapse'] = "Fold sammen";
		$text['expand'] = "Udvid";
		$text['pedbox'] = "Boks";
		//changed in 6.0.0
		$text['regformat'] = "Register";
		$text['extrasexpl'] = "Hvis der eksisterer billeder eller historier for de f�lgende personer, vil tilh�rende ikoner blive vist ved siden af navnene.";
		//added in 6.0.0
		$text['popupnote3'] = " = Ny tavle";
		$text['mediaavail'] = "Tilg�ngelige medier";
		//changed in 7.0.0
		$text['pedigreefor'] = "Aner for";
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
		$text['noreports'] = "Der er ingen rapporter.";
		$text['reportname'] = "Rapportnavn";
		$text['allreports'] = "Alle rapporter";
		$text['report'] = "Rapport";
		$text['error'] = "Fejl";
		$text['reportsyntax'] = "Syntaxen i rapports�ger";
		$text['wasincorrect'] = "var forkert, og rapporten kunne ikke laves. Kontakt systemadministratoren p�";
		$text['query'] = "S�g";
		$text['errormessage'] = "Fejlmelding";
		$text['equals'] = "lig med";
		$text['contains'] = "indeholder";
		$text['startswith'] = "begynder med";
		$text['endswith'] = "ender med";
		$text['soundexof'] = "soundex af";
		$text['metaphoneof'] = "metaphone af";
		$text['plusminus10'] = "+/- 10 �r fra";
		$text['lessthan'] = "f�r";
		$text['greaterthan'] = "efter";
		$text['lessthanequal'] = "Pr�cis eller f�r";
		$text['greaterthanequal'] = "Pr�cis eller efter";
		$text['equalto'] = "lig med";
		$text['tryagain'] = "Pr�v igen";
		$text['text_for'] = "for";
		$text['searchnames'] = "S�g efter navn";
		$text['joinwith'] = "kombiner med";
		$text['cap_and'] = "OG";
		$text['cap_or'] = "ELLER";
		$text['showspouse'] = "Vis partner(e)";
		$text['submitquery'] = "Begynd s�g";
		$text['birthplace'] = "F�dested";
		$text['deathplace'] = "D�d";
		$text['birthdatetr'] = "F�dt �r";
		$text['deathdatetr'] = "D�d �r";
		$text['plusminus2'] = "+/- 2 �r fra";
		$text['resetall'] = "Gendan alle v�rdier";

		$text['showdeath'] = "Vis d�ds-/begravelsesinformation";
		$text['altbirthplace'] = "D�bssted";
		$text['altbirthdatetr'] = "D�bs�r";
		$text['burialplace'] = "Begravelsessted";
		$text['burialdatetr'] = "Begravelses�r";
		$text['event'] = "Begivenhed(er)";
		$text['day'] = "Dag";
		$text['month'] = "M�ned";
		$text['keyword'] = "N�gleord (f.eks., \"Omkr.\")";
		$text['explain'] = "Skriv del af dato for at se sammenfaldende begivenheder. Lad feltet v�re tomt for at se sammenfald for alle.";
		$text['enterdate'] = "Skriv eller v�lg mindst �n af de f�lgende: Dag, M�ned, �r, N�gleord";
		$text['fullname'] = "Fuldt navn";
		$text['birthdate'] = "F�dselsdato";
		$text['altbirthdate'] = "D�bsdato";
		$text['marrdate'] = "Vielsesdato";
		$text['spouseid'] = "Partners ID";
		$text['spousename'] = "Partners navn";
		$text['deathdate'] = "D�dsdato";
		$text['burialdate'] = "Begravelsesdato";
		$text['changedate'] = "Sidst �ndret dato";
		$text['gedcom'] = "Tr�";
		$text['baptdate'] = "D�bsdato (LDS)";
		$text['baptplace'] = "D�bssted (LDS)";
		$text['endldate'] = "Begavelsesdato (LDS)";
		$text['endlplace'] = "Begavelsessted (LDS)";
		$text['ssealdate'] = "Beseglingsdato � (LDS)";
		$text['ssealplace'] = "Beseglingssted � (LDS)";
		$text['psealdate'] = "Beseglingsdato F (LDS)";
		$text['psealplace'] = "Beseglingssted F (LDS)";
		$text['marrplace'] = "Vielsessted";
		$text['spousesurname'] = "�gtef�lles efternavn";
		//changed in 6.0.0
		$text['spousemore'] = "Hvis du indtaster en v�rdi for �gtef�lles efternavn, skal du ogs� v�lge k�n.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 �r fra";
		$text['exists'] = "eksisterer";
		$text['dnexist'] = "eksisterer ikke";
		//added in 6.0.3
		$text['divdate'] = "Divorce Date";
		$text['divplace'] = "Divorce Place";
		//changed in 7.0.0
		$text['otherevents'] = "Andre begivenheder";
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
		$text['logfilefor'] = "Logfil for";
		$text['mostrecentactions'] = "Seneste aktiviteter";
		$text['autorefresh'] = "Automatisk opdatering (30 sekunder)";
		$text['refreshoff'] = "Sl� automatisk opdatering fra";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Kirkeg�rde og gravsten";
		$text['showallhsr'] = "Vis alle gravstensopf�relser";
		$text['in'] = "i";
		$text['showmap'] = "Vis kort";
		$text['headstonefor'] = "Gravsten for";
		$text['photoof'] = "Billeder af";
		$text['firstpage'] = "F�rste side";
		$text['lastpage'] = "Sidste side";
		$text['photoowner'] = "Ejer/Kilde";

		$text['nocemetery'] = "Ingen kirkeg�rd";
		$text['iptc005'] = "Titel";
		$text['iptc020'] = "Supp. kategorier";
		$text['iptc040'] = "S�rlige vejledninger";
		$text['iptc055'] = "Dannet dato";
		$text['iptc080'] = "Forfatter";
		$text['iptc085'] = "Forfatters stilling";
		$text['iptc090'] = "By";
		$text['iptc095'] = "Stat";
		$text['iptc101'] = "Land";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Overskrift";
		$text['iptc110'] = "Kilde";
		$text['iptc115'] = "Billedkilde";
		$text['iptc116'] = "Copyright bem�rkning";
		$text['iptc120'] = "Billedtekst";
		$text['iptc122'] = "Billedtekst forfatter";
		$text['mapof'] = "Kort over";
		$text['regphotos'] = "Beskrivelse";
		$text['gallery'] = "Kun thumbnails";
		$text['cemphotos'] = "Kirkeg�rdsbilleder";
		//changed in 6.0.0
		$text['photosize'] = "St�rrelse";
		//added in 6.0.0
        	$text['iptc010'] = "Prioritet";
		$text['filesize'] = "Filst�rrelse";
		$text['seeloc'] = "Se sted";
		$text['showall'] = "Vis alle";
		$text['editmedia'] = "Rediger medie";
		$text['viewitem'] = "Vis dette element";
		$text['editcem'] = "Rediger kirkeg�rd";
		$text['numitems'] = "# elementer";
		$text['allalbums'] = "Alle album";
		//added in 6.1.0
		$text['slidestart'] = "Start Slide Show";
		$text['slidestop'] = "Pause Slide Show";
		$text['slideresume'] = "Genoptag Slide Show";
		$text['slidesecs'] = "Sekunder for hver slide:";
		$text['minussecs'] = "minus 0.5 sekunder";
		$text['plussecs'] = "plus 0.5 sekunder";
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
		$text['surnamesstarting'] = "Vis efternavne, som begynder med";
		$text['showtop'] = "Vis mest brugte";
		$text['showallsurnames'] = "Vis alle efternavne";
		$text['sortedalpha'] = "sorteret alfabetisk";
		$text['byoccurrence'] = "sorteret efter hyppighed";
		$text['firstchars'] = "F�rste bogstav";
		$text['top'] = "Top";
		$text['mainsurnamepage'] = "Efternavne";
		$text['allsurnames'] = "Alle efternavne";
		$text['showmatchingsurnames'] = "Klik p� et efternavn for at se data.";
		$text['backtotop'] = "Tilbage til toppen";
		$text['beginswith'] = "Begynder med";
		$text['allbeginningwith'] = "Alle efternavne, der begynder med";
		$text['numoccurrences'] = "hyppigheden i parentes";
		$text['placesstarting'] = "Vis steder, der begynder med";
		$text['showmatchingplaces'] = "Klik p� et efternavn for at vise matchende poster.";
		$text['totalnames'] = "totalt antal navne";
		$text['showallplaces'] = "Vis alle steder";
		$text['totalplaces'] = "totalt antal steder";
		$text['mainplacepage'] = "Steders hovedside";
		$text['allplaces'] = "Alle steder";
		$text['placescont'] = "Vis alle steder, der indeholder";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(sidste xx dage)";
		$text['historiesdocs'] = "Historier & Dokumenter";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Billede";
		$text['history'] = "Historie/Dokument";
		//changed in 7.0.0
		$text['husbid'] = "Mands ID";
		$text['husbname'] = "Mands navn";
		$text['wifeid'] = "Kvindes ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Slet";
		$text['addperson'] = "Tilf�j person";
		$text['nobirth'] = "Den f�lgende person har ikke en gyldig f�dselsdato og kunne ikke tilf�jes";
		$text['noliving'] = "Den f�lgende person er m�rket som nulevende og kunne ikke tilf�jes, fordi du ikke er logget ind med korrekte rettigheder";
		$text['event'] = "Begivenhed(er)";
		$text['chartwidth'] = "Tavlebredde";
		//changed in 6.0.0
		$text['timelineinstr'] = "Tilf�j personer";
		//added in 6.0.0
		$text['togglelines'] = "Ombryd linjer";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "S�g i alle tr�er";
		$text['treename'] = "Navn p� tr�";
		$text['owner'] = "Ejer";
		$text['address'] = "Adresse";
		$text['city'] = "By";
		$text['state'] = "Stat";
		$text['zip'] = "Postnummer";
		$text['country'] = "Land";
		$text['email'] = "e-mail adresse";
		$text['phone'] = "Telefon";
		$text['username'] = "Brugernavn";
		$text['password'] = "Kodeord";
		$text['loginfailed'] = "Log ind fejlede";

		$text['regnewacct'] = "Registrer ny brugerkonto";
		$text['realname'] = "Dit rigtige navn";
		$text['phone'] = "Telefon";
		$text['email'] = "e-mail adresse";
		$text['address'] = "Adresse";
		$text['comments'] = "Bem�rkninger og kommentarer";
		$text['submit'] = "Udf�r";
		$text['leaveblank'] = "(tomt, hvis du vil have nyt tr�)";
		$text['required'] = "N�dvendige felter";
		$text['enterpassword'] = " Skriv venligst et kodeord.";
		$text['enterusername'] = "Skriv venligst et brugernavn.";
		$text['failure'] = "Brugernavnet, du skrev, er desv�rre allerede i brug. Brug Tilbage-knappen p� din browser for at komme tilbage til den forrige side, og v�lg et andet brugernavn.";
		$text['success'] = "Tak. Jeg har modtaget dig registrering. Jeg kontakter dig, n�r din konto er aktiveret.";
		$text['emailsubject'] = "Ny brugerans�gning";
		$text['emailmsg'] = "Du har modtaget en ny TNG brugerans�gning. Login p� dit TNG Admin omr�de og giv de n�dvendige rettigheder til den nye konto. Hvis du godkender ans�gningen, s� giv evt. ans�geren besked ved at svare p� denne mail.";
		//changed in 5.0.0
		$text['enteremail'] = "Skriv venligst en e-mail adresse.";
		$text['website'] = "Hjemmeside";
		$text['nologin'] = "Er du ikke oprettet som bruger?";
		$text['loginsent'] = "Log ind informationen er sendt";
		$text['loginnotsent'] = "Log ind informationen er ikke sendt";
		$text['enterrealname'] = "Skriv venligst dit rigtige navn.";
		$text['rempass'] = "Forbliv logget ind p� denne computer";
		$text['morestats'] = "Mere statistik";
		//added in 6.0.0
		$text['accmail'] = "<strong>OBS:</strong> For at kunne modtage mail fra hjemmesidens ejer vedr. din konto, bedes du sikre, at du ikke blokerer mails fra dette dom�ne.";
		$text['newpassword'] = "Nyt kodeord";
		$text['resetpass'] = "Gendan dit kodeord";
		//added in 6.1.0
		$text['nousers'] = "Denne form kan ikke bruges f�r mindst en bruger konto eksisterer. Hvis du er ejer af denne side skal du g� til Admin/Users og oprette en Administrator konto.";
		//added in 7.0.0
		$text['noregs'] = "We're sorry, but we are not accepting new user registrations at this time. Please <a href=\"suggest.php\">contact us</a> directly if you have comments or questions regarding anything on this site.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Antal";
		$text['totindividuals'] = "Antal personer i alt";
		$text['totmales'] = "Heraf antal hank�n";
		$text['totfemales'] = "Heraf antal hunk�n";
		$text['totunknown'] = "Ukendt k�n";
		$text['totliving'] = "Antal nulevende";
		$text['totfamilies'] = "Antal familier";
		$text['totuniquesn'] = "Antal unikke efternavne";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Antal kilder";
		$text['avglifespan'] = "Gennemsnitlig livsl�ngde";
		$text['earliestbirth'] = "Tidligste f�dsel";
		$text['longestlived'] = "L�ngstlevende person";
		$text['years'] = "�r";
		$text['days'] = "dage";
		$text['age'] = "Alder";
		$text['agedisclaimer'] = "Aldersrelaterede beregninger er baseret p� personer med angivne f�dsels- <EM>og</EM> d�dsdatoer.  Fordi der findes ukomplette datofelter(f.eks. en d�dsdato, der kun er skrevet som \"1945\" eller \"F�R 1860\"), kan disse beregninger ikke v�re 100% pr�cise.";
		$text['treedetail'] = "Mere information om dette tr�";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "S�g i alle notater";
		break;

	case "help":
		$text['menuhelp'] = "Menun�gle";
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
		$text['exists'] = "eksisterer";
		$text['loginfirst'] = "You must log in first.";
		$text['noop'] = "No operation was performed.";
		break;
}

//common
$text['matches'] = "Match";
$text['description'] = "Beskrivelse";
$text['notes'] = "Notater";
$text['status'] = "Status";
$text['newsearch'] = "Ny s�gning";
$text['pedigree'] = "Anetavle";
$text['birthabbr'] = "f.";
$text['chrabbr'] = "dbt.";
$text['seephoto'] = "Se billede";
$text['andlocation'] = "& lokation";
$text['accessedby'] = "udf�rt af";
$text['go'] = "Udf�r";
$text['family'] = "Familie";
$text['children'] = "B�rn";
$text['tree'] = "Tr�";
$text['alltrees'] = "Alle tr�er";
$text['nosurname'] = "[intet efternavn]";
$text['thumb'] = "Ikon";
$text['people'] = "Personer";
$text['title'] = "Titel";
$text['suffix'] = "Suffiks";
$text['nickname'] = "Kaldenavn";
$text['deathabbr'] = "d.";
$text['lastmodified'] = "Sidst �ndret";
$text['married'] = "Gift";
//$text['photos'] = "Photos";
$text['name'] = "Navn";
$text['lastfirst'] = "Efternavn, Fornavn";
$text['bornchr'] = "F�dt/D�bt";
$text['individuals'] = "Personer";
$text['families'] = "Familier";
$text['personid'] = "Person-ID";
$text['sources'] = "Kilder";
$text['unknown'] = "Ukendt";
$text['father'] = "Far";
$text['mother'] = "Mor";
$text['born'] = "F�dt";
$text['christened'] = "D�bt";
$text['died'] = "D�d";
$text['buried'] = "Begravet";
$text['spouse'] = "Partner";
$text['parents'] = "For�ldre";
$text['text'] = "Tekst";
$text['language'] = "Sprog";
$text['burialabbr'] = "begr.";
$text['descendchart'] = "Efterkommere";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Egne data";
$text['edit'] = "Rediger";
$text['date'] = "Dato";
$text['place'] = "Sted";
$text['login'] = "Log ind";
$text['logout'] = "Log ud";
$text['marrabbr'] = "g.";
$text['groupsheet'] = "Gruppeskema";
$text['text_and'] = "og";
$text['generation'] = "Generation";
$text['filename'] = "Filnavn";
$text['id'] = "ID";
$text['search'] = "S�g";
$text['living'] = "Nulevende";
$text['user'] = "Bruger";
$text['firstname'] = "Fornavn";
$text['lastname'] = "Efternavn";
$text['searchresults'] = "S�geresultat";
$text['diedburied'] = "D�d/Begravet";
$text['homepage'] = "Forside";
$text['find'] = "Find...";
$text['relationship'] = "Sl�gtskab";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Tidslinje";
$text['yesabbr'] = "Ja";
$text['divorced'] = "Skilt";
$text['indlinked'] = "Knyttet til";
$text['branch'] = "Gren";
$text['moreind'] = "Flere personer";
$text['morefam'] = "Flere familier";
$text['livingdoc'] = "Mindst en nulevende person er knyttet til dette dokument - Detaljer udelades.";
$text['source'] = "Kilde";
$text['surnamelist'] = "Efternavneliste";
$text['generations'] = "Generationer";
$text['refresh'] = "Opdater";
$text['whatsnew'] = "Hvad er nyt?";
$text['reports'] = "Rapporter";
$text['placelist'] = "Stedfortegnelse";
$text['baptizedlds'] = "D�bt (LDS)";
$text['endowedlds'] = "Begavet (LDS)";
$text['sealedplds'] = "Beseglet F (LDS)";
$text['sealedslds'] = "Beseglet � (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Aner";
$text['descendants'] = "Efterkommere";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Dato for sidste GEDCOM import";
$text['type'] = "Type";
$text['savechanges'] = "Gem �ndringer";
$text['familyid'] = "Familie-ID";
$text['headstone'] = "Gravsten";
$text['historiesdocs'] = "Historier & Dokumenter";
$text['livingnote'] = "Personlig information - Detaljer udeladt";
$text['anonymous'] = "Anonym";
$text['places'] = "Steder";
$text['anniversaries'] = "Datoer & �rsdage";
$text['administration'] = "Administration";
$text['help'] = "Hj�lp";
//$text['documents'] = "Documents";
$text['year'] = "�r";
$text['all'] = "Alle";
$text['repository'] = "Arkiv";
$text['address'] = "Adresse";
$text['suggest'] = "Foresl�";
$text['editevent'] = "Foresl� en �ndring til denne begivenhed";
$text['findplaces'] = "Find alle personer med begivenheder p� dette sted";
$text['morelinks'] = "Flere links";
$text['faminfo'] = "Familieinformation";
$text['persinfo'] = "Personlig information";
$text['srcinfo'] = "Kildeinformation";
$text['fact'] = "Fakta";
$text['goto'] = "V�lg en side";
$text['tngprint'] = "Udskriv";
//changed in 6.0.0
$text['livingphoto'] = "Mindst en nulevende person er knyttet til dette element - Detaljer udelades.";
$text['databasestatistics'] = "Databasestatistik";
//moved here in 6.0.0
$text['child'] = "Barn";
$text['repoinfo'] = "Information om arkiv";
$text['tng_reset'] = "Gendan";
$text['noresults'] = "Ingen fundet";
//added in 6.0.0
$text['allmedia'] = "Alle media";
$text['repositories'] = "Arkiver";
$text['albums'] = "Album";
$text['cemeteries'] = "Kirkeg�rde";
$text['surnames'] = "Efternavne";
$text['dates'] = "Datoer";
$text['link'] = "Link";
$text['media'] = "Medie";
$text['gender'] = "K�n";
$text['latitude'] = "Breddegrad";
$text['longitude'] = "L�ngdegrad";
$text['bookmarks'] = "Bogm�rker";
$text['bookmark'] = "Tilf�j bogm�rke";
$text['mngbookmarks'] = "G� til bogm�rke";
$text['bookmarked'] = "Bogm�rke tilf�jet";
$text['remove'] = "Fjern";
$text['find_menu'] = "Find";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Kirkeg�rd";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Begivenhed Kort";
$text['gevents'] = "Begivenhed";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Link to Google Earth";
$text['googlemaplink'] = "Link to Google Maps";
$text['gmaplegend'] = "Pin forklaring";
//moved here in 7.0.0
$text['unmarked'] = "Um�rket";
$text['located'] = "Lokaliseret";
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
$text['mnuheader'] = "Forside";
$text['mnusearchfornames'] = "S�g";
$text['mnulastname'] = "Efternavn";
$text['mnufirstname'] = "Fornavn";
$text['mnusearch'] = "S�g";
$text['mnureset'] = "Begynd forfra";
$text['mnulogon'] = "Log ind";
$text['mnulogout'] = "Log ud";
$text['mnufeatures'] = "Andre muligheder";
$text['mnuregister'] = "Registrer for at f� en brugerkonto";
$text['mnuadvancedsearch'] = "Avanceret s�gning";
$text['mnulastnames'] = "Efternavne";
$text['mnustatistics'] = "Statistikker";
$text['mnuphotos'] = "Billeder";
$text['mnuhistories'] = "Historier";
$text['mnumyancestors'] = "Billeder af &amp; historier om forf�dre af Michael S�rvin";
$text['mnucemeteries'] = "Kirkeg�rde";
$text['mnutombstones'] = "Gravsten";
$text['mnureports'] = "Rapporter";
$text['mnusources'] = "Kilder";
$text['mnuwhatsnew'] = "Hvad er nyt";
$text['mnushowlog'] = "Adgangslog";
$text['mnulanguage'] = "Change Language";
$text['mnuadmin'] = "Administration";
$text['welcome'] = "Velkommen";
$text['contactus'] = "Kontakt mig";

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
