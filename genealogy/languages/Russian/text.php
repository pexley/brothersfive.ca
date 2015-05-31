<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "покажи все источники";
		$text['shorttitle'] = "сокращённый тител";
		$text['callnum'] = "архивный номер";
		$text['author'] = "автор";
		$text['publisher'] = "издатель";
		$text['other'] = "другая информация";
		$text['sourceid'] = "источник";
		$text['moresrc'] = "больше источников";
		$text['repoid'] = "найденное место";
		$text['browseallrepos'] = "показать все найденные места";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "новый язык";
		$text['changelanguage'] = "изменить язык";
		$text['languagesaved'] = "сохранить язык";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM начать с ";
		$text['producegedfrom'] = "сделать GEDCOM с ним/ней";
		$text['numgens'] = "число генераций";
		$text['includelds'] = "включая HLD информацию";
		$text['buildged'] = "сделать GEDCOM";
		$text['gedstartfrom'] = "GEDCOM начинается у";
		$text['nomaxgen'] = "U moet het maximum aantal generaties aangeven. Gebruik uw browser om terug te gaan naar de vorige bladzijde en verbeter de fout";
		$text['gedcreatedfrom'] = "GEDCOM сделан с";
		$text['gedcreatedfor'] = "сделан для";

		$text['enteremail'] = "Vul aub een bestaand e-mail adres in.";
		$text['creategedfor'] = "сделай GEDCOM";
		$text['email'] = "E-mail adres";
		$text['suggestchange'] = "примечания/замечания ";
		$text['yourname'] = "Ваше имя";
		$text['comments'] = "Commentaar";
		$text['comments2'] = "комментарий";
		$text['submitsugg'] = "отослать замечания";
		$text['proposed'] = "примечания/замечания";
		$text['mailsent'] = "замечания отосланы.";
		$text['mailnotsent'] = "к сожалению Ваше сообщение не возможно доставить.Свяжитесь с ххх с помощью ууу.";
		$text['mailme'] = "Вышли копию вашего сообщения на этот е майл адрес";
		//added in 5.0.5
		$text['entername'] = "заполните Ваше имя";
		$text['entercomments'] = "заполните ваши замечания";
		$text['sendmsg'] = "отослать сообщение";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "фото и жизненные рассказы";
		$text['indinfofor'] = "персональная информация";
		$text['reliability'] = "надёжность";
		$text['pp'] = "страница.";
		$text['age'] = "Leeftijd";
		$text['agency'] = "инстанция";
		$text['cause'] = "причина";
		$text['suggested'] = "предложение";
		$text['closewindow'] = "закрыть эту сноску";
		$text['thanks'] = "спасибо";
		$text['received'] = "Твоё редложение об изменении переслано администратору для оценки.";
		//added in 6.0.0
		$text['association'] = "связь";
		//added in 7.0.0
		$text['indreport'] = "Individual Report";
		$text['indreportfor'] = "Individual Report for";
		$text['general'] = "General";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "просчитать родство";
		$text['findrel'] = "искать родство";
		$text['person1'] = "лицо 1:";
		$text['person2'] = "лицо 2:";
		$text['calculate'] = "просчитать";
		$text['select2inds'] = "Отберите два человека.";
		$text['findpersonid'] = "ищи персональное идентичность";
		$text['enternamepart'] = "заполни частично имя, фамилию";
		$text['pleasenamepart'] = "Aub een deel van de voor- en/of achternaam invullen.";
		$text['clicktoselect'] = "нажми для селекции";
		$text['nobirthinfo'] = "нет сведений о рождении";
		$text['relateto'] = "родство с";
		$text['sameperson'] = "два человека это одна и та же персона.";
		$text['notrelated'] = "De twee personen zijn niet verwant aan elkaar binnen xxx generaties.";
		$text['findrelinstr'] = "Vul de ID's van twee personen in, of laat de gegevens van de weergegeven perso(o)n(en) staan. Klik daarna op 'Berekenen' om de eventuele verwantschap grafisch weer te geven.";
		$text['gencheck'] = "Max. aantal te<br />controleren generaties";
		$text['sometimes'] = "(NB Het is goed mogelijk dat een andere keuze van het max. aantal te controleren generaties, een ander resultaat oplevert.)";
		$text['findanother'] = "Terug: Zoek een nieuwe verwantschap";
		//added in 6.0.0
		$text['brother'] = "de broer van";
		$text['sister'] = "de zus van";
		$text['sibling'] = "de broer/zus van";
		$text['uncle'] = "de xxx oom van";
		$text['aunt'] = "de xxx tante van";
		$text['uncleaunt'] = "de xxx oom/tante van";
		$text['nephew'] = "de xxx neef van";
		$text['niece'] = "de xxx nicht van";
		$text['nephnc'] = "de xxx neef/nicht van";
		$text['mcousin'] = "de xxx neef van";
		$text['fcousin'] = "de xxx nicht van";
		$text['cousin'] = "de xxx neef/nicht van";
		$text['removed'] = "maal verwijderd";
		$text['rhusband'] = "de echtgenoot van ";
		$text['rwife'] = "de echtgenote van ";
		$text['rspouse'] = "de echtgeno(o)t(e) van ";
		$text['son'] = "de zoon van";
		$text['daughter'] = "de dochter van";
		$text['rchild'] = "het kind van";
		$text['sil'] = "de schoonzoon van";
		$text['dil'] = "de schoondochter van";
		$text['sdil'] = "de schoonzoon/dochter van";
		$text['gson'] = "de xxx kleinzoon van";
		$text['gdau'] = "de xxx kleindochter van";
		$text['gsondau'] = "de xxx kleinzoon/dochter van";
		$text['great'] = "groot";
		$text['spouses'] = "zijn echtelieden";
		$text['is'] = "is";
		//changed in 6.0.0
		$text['changeto'] = "Wijzig in (Persoon-ID):";
		//added in 6.0.0
		$text['notvalid'] = "is geen geldig Persoon-ID (Ixxx) of is niet gevonden in het bestand. Probeer het aub nog een keer.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Gezinsblad van";
		$text['ldsords'] = "HLD verordeningen";
		$text['baptizedlds'] = "Gedoopt (HLD)";
		$text['endowedlds'] = "Begiftigd (HLD)";
		$text['sealedplds'] = "Verzegeld ouders (HLD)";
		$text['sealedslds'] = "Verzegeld partner (HLD)";
		$text['otherspouse'] = "Andere partner";
		//changed in 7.0.0
		$text['husband'] = "Echtgenoot";
		$text['wife'] = "Echtgenote";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "Geb";
		$text['capaltbirthabbr'] = "Doop";
		$text['capdeathabbr'] = "Ovl";
		$text['capburialabbr'] = "Begr";
		$text['capplaceabbr'] = "te";
		$text['capmarrabbr'] = "Geh";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Opnieuw tekenen met";
		$text['scrollnote'] = "Opm.: Scroll eventueel naar beneden of naar rechts om alles te kunnen zien.";
		$text['unknownlit'] = "Onbekend";
		$text['popupnote1'] = " = Extra informatie";
		$text['popupnote2'] = " = Start nieuw voorouder-overzicht vanaf deze persoon";
		$text['pedcompact'] = "Compact";
		$text['pedstandard'] = "Standaard";
		$text['pedtextonly'] = "Alleen tekst";
		$text['descendfor'] = "Nakomelingen van";
		$text['maxof'] = "Maximum";
		$text['gensatonce'] = "generaties tegelijk tonen.";
		$text['sonof'] = "zoon van";
		$text['daughterof'] = "dochter van";
		$text['childof'] = "kind van";
		$text['stdformat'] = "Standaard-formaat";

		$text['ahnentafel'] = "(Uitgebreide)kwartierstaat";
		$text['addnewfam'] = "Toevoegen nieuw gezin";
		$text['editfam'] = "Wijzig gezin";
		$text['side'] = "kant";
		$text['familyof'] = "Familie van";
		$text['paternal'] = "vaders kant";
		$text['maternal'] = "moeders kant";
		$text['gen1'] = "zelf";
		$text['gen2'] = "ouders";
		$text['gen3'] = "grootouders";
		$text['gen4'] = "overgrootouders";
		$text['gen5'] = "betovergrootouders";
		$text['gen6'] = "oudouders";
		$text['gen7'] = "oudgrootouders";
		$text['gen8'] = "oudovergrootouders";
		$text['gen9'] = "oudbetovergrootouders";
		$text['gen10'] = "stam-ouders";
		$text['gen11'] = "stam-grootouders";
		$text['gen12'] = "stam-overgrootouders";
		$text['graphdesc'] = "Nakomelingen tot dit punt grafisch weergegeven";
		$text['collapse'] = "Samenvouwen";
		$text['expand'] = "Uitvouwen";
		$text['pedbox'] = "Box";
		//changed in 6.0.0
		$text['regformat'] = "Register";
		$text['extrasexpl'] = "= Er is zeker één foto, (levens)verhaal of ander medium bekend van deze persoon.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nieuw overzicht";
		$text['mediaavail'] = "Beschikbare media";
		//changed in 7.0.0
		$text['pedigreefor'] = "Stamboom van";
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
		$text['noreports'] = "Er bestaat geen actief rapport.";
		$text['reportname'] = "Rapportnaam";
		$text['allreports'] = "Alle rapporten";
		$text['report'] = "Rapport";
		$text['error'] = "Fout";
		$text['reportsyntax'] = "De syntax van de zoekvraag voor dit rapport";
		$text['wasincorrect'] = "is ongeldig, daarom kan het rapport niet worden gemaakt. Neem contact op met de beheerder via";
		$text['query'] = "Zoekvraag";
		$text['errormessage'] = "Foutmelding";
		$text['equals'] = "is gelijk aan";
		$text['contains'] = "bevat";
		$text['startswith'] = "begint met";
		$text['endswith'] = "eindigt op";
		$text['soundexof'] = "soundex van";
		$text['metaphoneof'] = "metaphone van";
		$text['plusminus10'] = "+/- 10 jaar vanaf";
		$text['lessthan'] = "minder dan";
		$text['greaterthan'] = "groter dan";
		$text['lessthanequal'] = "minder dan of gelijk aan";
		$text['greaterthanequal'] = "groter dan of gelijk aan";
		$text['equalto'] = "gelijk aan";
		$text['tryagain'] = "Probeer het nog eens";
		$text['text_for'] = "voor";
		$text['searchnames'] = "Zoeken naar naam";
		$text['joinwith'] = "Bovenstaande<br />onderling<br />verbinden met";
		$text['cap_and'] = "EN";
		$text['cap_or'] = "OF";
		$text['showspouse'] = "Laat partner zien (laat dubbelen zien indien van de persoon meerdere partners bekend zijn)";
		$text['submitquery'] = "Zoek op";
		$text['birthplace'] = "Geboorteplaats";
		$text['deathplace'] = "Overlijdensplaats";
		$text['birthdatetr'] = "Geboortejaar";
		$text['deathdatetr'] = "Overlijdensjaar";
		$text['plusminus2'] = "+/- 2 jaar vanaf";
		$text['resetall'] = "Alle waarden terugzetten";

		$text['showdeath'] = "Laat overleden/begraven informatie zien";
		$text['altbirthplace'] = "Doopplaats";
		$text['altbirthdatetr'] = "Doopjaar";
		$text['burialplace'] = "Begraafplaats";
		$text['burialdatetr'] = "Begraafjaar";
		$text['event'] = "Gebeurtenis(sen)";
		$text['day'] = "Dag";
		$text['month'] = "Maand";
		$text['keyword'] = "Sleutelwoord (bv, 'Circa')";
		$text['explain'] = "Vul datum-gedeelten in om gebeurtenissen met gelijke datum-gedeelten te zien. Laat een veld leeg om alles te zien.";
		$text['enterdate'] = "Vul aub op zijn minst één van de volgende velden in: dag, maand, jaar, sleutelwoord";
		$text['fullname'] = "Volledige naam";
		$text['birthdate'] = "Geboortedatum";
		$text['altbirthdate'] = "Doopdatum";
		$text['marrdate'] = "Trouwdatum";
		$text['spouseid'] = "Partner-ID";
		$text['spousename'] = "Naam partner";
		$text['deathdate'] = "Overlijdensdatum";
		$text['burialdate'] = "Begraafdatum";
		$text['changedate'] = "Datum laatste wijziging";
		$text['gedcom'] = "Stamboom";
		$text['baptdate'] = "Doopdatum (HLD)";
		$text['baptplace'] = "Doopplaats (HLD)";
		$text['endldate'] = "Begiftigingsdatum (HLD)";
		$text['endlplace'] = "Begiftigingsplaats (HLD)";
		$text['ssealdate'] = "Verzegelingsdatum P (HLD)";
		$text['ssealplace'] = "Verzegelingsplaats P (HLD)";
		$text['psealdate'] = "Verzegelingsdatum O (HLD)";
		$text['psealplace'] = "Verzegelingsplaats O (HLD)";
		$text['marrplace'] = "Huwelijksplaats";
		$text['spousesurname'] = "Achternaam van partner";
		//changed in 6.0.0
		$text['spousemore'] = "Indien 'Achternaam van partner' wordt ingevuld, moet ook 'Geslacht' ingevuld worden!";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 jaar vanaf";
		$text['exists'] = "is ingevuld";
		$text['dnexist'] = "is niet ingevuld";
		//added in 6.0.3
		$text['divdate'] = "Datum echtscheiding";
		$text['divplace'] = "Plaats echtscheiding";
		//changed in 7.0.0
		$text['otherevents'] = "Andere gebeurtenissen";
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
		$text['logfilefor'] = "Logbestand voor";
		$text['mostrecentactions'] = "Laatste acties";
		$text['autorefresh'] = "Automatisch verversen AAN (30 seconden)";
		$text['refreshoff'] = "Automatisch verversen UIT";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Begraafplaatsen en grafstenen";
		$text['showallhsr'] = "Toon alle grafstenen in:";
		$text['in'] = "in";
		$text['showmap'] = "Bekijk plattegrond";
		$text['headstonefor'] = "Grafsteen van";
		$text['photoof'] = "Foto van";
		$text['firstpage'] = "Eerste bladzijde";
		$text['lastpage'] = "Laatste bladzijde";
		$text['photoowner'] = "Eigenaar/Bron";

		$text['nocemetery'] = "Geen begraafplaats";
		$text['iptc005'] = "Titel";
		$text['iptc020'] = "Aanvullende categorieën";
		$text['iptc040'] = "Speciale instructies";
		$text['iptc055'] = "Aanmaakdatum";
		$text['iptc080'] = "Auteur";
		$text['iptc085'] = "Positie van de auteur";
		$text['iptc090'] = "Plaats";
		$text['iptc095'] = "Staat";
		$text['iptc101'] = "Land";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Koptekst";
		$text['iptc110'] = "Bron";
		$text['iptc115'] = "Bron van de foto";
		$text['iptc116'] = "Copyright";
		$text['iptc120'] = "Tekst";
		$text['iptc122'] = "Geschreven door";
		$text['mapof'] = "Kaart van";
		$text['regphotos'] = "Beschrijvend overzicht";
		$text['gallery'] = "Klikplaatjes-overzicht";
		$text['cemphotos'] = "Foto's van begraafplaats";
		//changed in 6.0.0
		$text['photosize'] = "Dimensies";
		//added in 6.0.0
        	$text['iptc010'] = "Prioriteit";
		$text['filesize'] = "Bestandgrootte";
		$text['seeloc'] = "Zie Plaats";
		$text['showall'] = "Allemaal zien";
		$text['editmedia'] = "Wijzig Media";
		$text['viewitem'] = "Bekijk dit item";
		$text['editcem'] = "Wijzig begraafplaats";
		$text['numitems'] = "# items";
		$text['allalbums'] = "Alle albums";
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
		$text['surnamesstarting'] = "Toon familienamen beginnend met";
		$text['showtop'] = "Toon top";
		$text['showallsurnames'] = "Toon alle familienamen";
		$text['sortedalpha'] = "alfabetisch gesorteerd";
		$text['byoccurrence'] = "Op aantal treffers gerangschikt";
		$text['firstchars'] = "Eerste letter";
		$text['top'] = "Top";
		$text['mainsurnamepage'] = "Hoofd-familienaam pagina";
		$text['allsurnames'] = "Alle familienamen";
		$text['showmatchingsurnames'] = "Klik op een familienaam om de bijbehorende namen te tonen.";
		$text['backtotop'] = "Terug naar boven";
		$text['beginswith'] = "Begint met";
		$text['allbeginningwith'] = "Alle familienamen beginnend met";
		$text['numoccurrences'] = "aantal resultaten tussen haakjes";
		$text['placesstarting'] = "Toon de meest gebruikte plaatsen beginnend met";
		$text['showmatchingplaces'] = "Klik op een plaatsnaam om een verdere onderverdeling van die betreffende plaats te zien. Klik op het zoek-pictogram om bijbehorende personen weer te geven.";
		$text['totalnames'] = "totaal aantal personen";
		$text['showallplaces'] = "Alle meest gebruikte plaatsen";
		$text['totalplaces'] = "totaal aantal plaatsen";
		$text['mainplacepage'] = "Hoofd-plaatsnamen pagina";
		$text['allplaces'] = "Alle meest gebruikte plaatsen";
		$text['placescont'] = "Laat alle plaatsen zien met";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(sinds de laatste xx dagen)";
		$text['historiesdocs'] = "рассказы о жизни";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Foto";
		$text['history'] = "(Levens)verhaal/Document";
		//changed in 7.0.0
		$text['husbid'] = "Echtgenoot-ID";
		$text['husbname'] = "Naam echtgenoot";
		$text['wifeid'] = "Echtgenote-ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Verwijderen";
		$text['addperson'] = "Persoon toevoegen";
		$text['nobirth'] = "De volgende persoon heeft geen geldige geboortedatum en kan daarom niet toegevoegd worden";
		$text['noliving'] = "De volgende persoon is gemarkeerd als levend en kon niet toegevoegd worden omdat u daarvoor geen rechten heeft";
		$text['event'] = "Gebeurtenis(sen)";
		$text['chartwidth'] = "Tijdlijn-breedte";
		//changed in 6.0.0
		$text['timelineinstr'] = "Personen toevoegen";
		//added in 6.0.0
		$text['togglelines'] = "Regels omwisselen";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Toon alle stambomen";
		$text['treename'] = "Stamboomnaam";
		$text['owner'] = "Eigenaar";
		$text['address'] = "адрес";
		$text['city'] = "Woonplaats";
		$text['state'] = "Provincie";
		$text['zip'] = "Postcode";
		$text['country'] = "Land";
		$text['email'] = "E-mail adres";
		$text['phone'] = "Telefoon";
		$text['username'] = "Gebruikersnaam";
		$text['password'] = "Wachtwoord";
		$text['loginfailed'] = "Fout bij het aanmelden.";

		$text['regnewacct'] = "Registreer als nieuwe gebruiker";
		$text['realname'] = "Uw echte naam";
		$text['phone'] = "Telefoon";
		$text['email'] = "E-mail adres";
		$text['address'] = "адрес";
		$text['comments'] = "Commentaar";
		$text['submit'] = "Verzenden";
		$text['leaveblank'] = "(laat leeg als u een nieuwe stamboom aanvraagt)";
		$text['required'] = " Verplichte velden";
		$text['enterpassword'] = "Vul een wachtwoord in.";
		$text['enterusername'] = "Vul een gebruikersnaam in.";
		$text['failure'] = "Helaas is deze gebruikersnaam al in gebruik. Ga mbv de Vorige-knop naar de vorige pagina en kies een andere gebruikersnaam.";
		$text['success'] = "Dank u. De gegevens zijn verzonden. U krijgt een bericht als uw registratie is geactiveerd of als meer informatie noodzakelijk is.";
		$text['emailsubject'] = "Nieuwe TNG Gebruiker";
		$text['emailmsg'] = "U heeft een aanvraag van een nieuwe gebruiker. Wilt u deze activeren door in het TNG Administratie scherm deze gebruiker de vereiste toegang te geven en de nieuwe gebruiker daarvan op de hoogte te stellen?";
		//changed in 5.0.0
		$text['enteremail'] = "Vul aub een bestaand e-mail adres in.";
		$text['website'] = "Webpagina";
		$text['nologin'] = "Nog niet geregistreerd? Klik op: ";
		$text['loginsent'] = "Aanmeld-informatie verstuurd";
		$text['loginnotsent'] = "De aanmeld-informatie is niet verstuurd";
		$text['enterrealname'] = "Vul aub uw echte naam in.";
		$text['rempass'] = "Blijf aangemeld op deze computer";
		$text['morestats'] = "Meer statistieken";
		//added in 6.0.0
		$text['accmail'] = "<strong>Opmerking:</strong> Om e-mail, mbt uw registratie, te kunnen ontvangen van de website-beheerder dient u er voor te zorgen dat er van dit domein geen mail wordt geblokkeerd.";
		$text['newpassword'] = "Nieuw wachtwoord";
		$text['resetpass'] = "Verander uw wachtwoord";
		//added in 6.1.0
		$text['nousers'] = "This form cannot be used until at least one user record exists. If you are the site owner, please go to Admin/Users to create your Administrator account.";
		//added in 7.0.0
		$text['noregs'] = "We're sorry, but we are not accepting new user registrations at this time. Please <a href=\"suggest.php\">contact us</a> directly if you have comments or questions regarding anything on this site.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Totalen";
		$text['totindividuals'] = "Aantal personen";
		$text['totmales'] = "Aantal mannen";
		$text['totfemales'] = "Aantal vrouwen";
		$text['totunknown'] = "Aantal personen met onbekend geslacht";
		$text['totliving'] = "Aantal levenden";
		$text['totfamilies'] = "Aantal gezinnen";
		$text['totuniquesn'] = "Aantal unieke achternamen";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Aantal bronnen";
		$text['avglifespan'] = "Gemiddelde levensduur";
		$text['earliestbirth'] = "Vroegste geboorte";
		$text['longestlived'] = "Langst levende";
		$text['years'] = "jaren";
		$text['days'] = "dagen";
		$text['age'] = "Leeftijd";
		$text['agedisclaimer'] = "Leeftijd-berekeningen zijn gebaseerd op personen met een geboorte- <strong>en</strong> overlijdensdatum. Als deze niet volledig zijn (bv één van de datums is onvolledig, bv alleen het jaar '1945' of zonder dag 'mei 1755') dan zijn deze berekeningen niet 100% nauwkeurig. Datums met 'vóór', 'na', 'circa', 'tussen' en 'berekend' worden niet meegerekend.";
		$text['treedetail'] = "Meer informatie mbt deze stamboom";
		//added in 6.0.0
		$text['total'] = "Totaal";
		break;

	case "notes":
		$text['browseallnotes'] = "Bekijk alle aantekeningen";
		break;

	case "help":
		$text['menuhelp'] = "Pictogrammen overzicht";
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
		$text['exists'] = "is ingevuld";
		$text['loginfirst'] = "You must log in first.";
		$text['noop'] = "No operation was performed.";
		break;
}

//common
$text['matches'] = "Treffers";
$text['description'] = "Beschrijving";
$text['notes'] = "Aantekeningen";
$text['status'] = "Status";
$text['newsearch'] = "Nieuwe zoekopdracht";
$text['pedigree'] = "Stamboom";
$text['birthabbr'] = "geb.";
$text['chrabbr'] = "ged.";
$text['seephoto'] = "Zie foto";
$text['andlocation'] = "& plaats";
$text['accessedby'] = "bezocht door";
$text['go'] = "OK";
$text['family'] = "Gezin";
$text['children'] = "Kinderen";
$text['tree'] = "Stamboom";
$text['alltrees'] = "Alle stambomen";
$text['nosurname'] = "[geen achternaam]";
$text['thumb'] = "Klikplaatje";
$text['people'] = "Personen";
$text['title'] = "Titel";
$text['suffix'] = "Achtervoegsel";
$text['nickname'] = "Roepnaam";
$text['deathabbr'] = "ovl.";
$text['lastmodified'] = "Laatst gewijzigd op";
$text['married'] = "Getrouwd";
//$text['photos'] = "Photos";
$text['name'] = "Naam";
$text['lastfirst'] = "Familienaam, Voorna(a)m(en)";
$text['bornchr'] = "Geboren / Gedoopt";
$text['individuals'] = "Personen";
$text['families'] = "Gezinnen";
$text['personid'] = "Persoon-ID";
$text['sources'] = "Bronnen";
$text['unknown'] = "Onbekend";
$text['father'] = "Vader";
$text['mother'] = "Moeder";
$text['born'] = "Geboren";
$text['christened'] = "Gedoopt";
$text['died'] = "Overleden";
$text['buried'] = "Begraven";
$text['spouse'] = "Partner";
$text['parents'] = "Ouders";
$text['text'] = "Tekst";
$text['language'] = "Taal";
$text['burialabbr'] = "begr.";
$text['descendchart'] = "Nakomelingen";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Persoon";
$text['edit'] = "Wijzig";
$text['date'] = "Datum";
$text['place'] = "Plaats";
$text['login'] = "Aanmelden";
$text['logout'] = "Afmelden";
$text['marrabbr'] = "getr.";
$text['groupsheet'] = "Gezinsblad";
$text['text_and'] = "en";
$text['generation'] = "Generatie";
$text['filename'] = "Bestandsnaam";
$text['id'] = "ID";
$text['search'] = "Zoek";
$text['living'] = "Levend";
$text['user'] = "Gebruiker";
$text['firstname'] = "Voornaam";
$text['lastname'] = "Familienaam";
$text['searchresults'] = "Zoekresultaten";
$text['diedburied'] = "Overleden / Begraven";
$text['homepage'] = "Startpagina";
$text['find'] = "Zoeken...";
$text['relationship'] = "Verwantschap";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Tijdlijn";
$text['yesabbr'] = "J";
$text['divorced'] = "Gescheiden";
$text['indlinked'] = "Verbonden met";
$text['branch'] = "Tak";
$text['moreind'] = "Meer personen";
$text['morefam'] = "Meer gezinnen";
$text['livingdoc'] = "Tenminste nog één levende persoon is verbonden aan dit document - detailgegevens worden niet weergegeven.";
$text['source'] = "Bron";
$text['surnamelist'] = "Familienamenlijst";
$text['generations'] = "Generaties";
$text['refresh'] = "Verversen";
$text['whatsnew'] = "Wat is er nieuw";
$text['reports'] = "Rapporten";
$text['placelist'] = "Plaatsen overzicht";
$text['baptizedlds'] = "Gedoopt (HLD)";
$text['endowedlds'] = "Begiftigd (HLD)";
$text['sealedplds'] = "Verzegeld ouders (HLD)";
$text['sealedslds'] = "Verzegeld partner (HLD)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "прородители";
$text['descendants'] = "дети";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "дата последнего GEDCOM импорта";
$text['type'] = "тип";
$text['savechanges'] = "изменения запомнить";
$text['familyid'] = "семья идентификация";
$text['headstone'] = "памятники";
$text['historiesdocs'] = "рассказы о жизни";
$text['livingnote'] = "по меньшей мере один ещё живущий связан с этим файлот, данные  не будут выданы.";
$text['anonymous'] = "анонимно";
$text['places'] = "места";
$text['anniversaries'] = "дата & дни рождения";
$text['administration'] = "файл руководителя";
$text['help'] = "помощь";
//$text['documents'] = "Documents";
$text['year'] = "год";
$text['all'] = "всё";
$text['repository'] = "место поиска";
$text['address'] = "адрес";
$text['suggest'] = "замечания";
$text['editevent'] = "Wijzigingsvoorstel mbt deze gebeurtenis";
$text['findplaces'] = "Zoek alle personen met gebeurtenissen in deze plaats";
$text['morelinks'] = "больше сносок";
$text['faminfo'] = "информация о семье";
$text['persinfo'] = "Persoonlijke informatie";
$text['srcinfo'] = "источник информации";
$text['fact'] = "факт";
$text['goto'] = "выбери страницу";
$text['tngprint'] = "печать";
//changed in 6.0.0
$text['livingphoto'] = "по меньшей мере один ещё живущий связан с этим файлом, данные  не будут выданы.";
$text['databasestatistics'] = "база статистик";
//moved here in 6.0.0
$text['child'] = "ребёнок";
$text['repoinfo'] = "место информации";
$text['tng_reset'] = "очистить";
$text['noresults'] = "результат не найден";
//added in 6.0.0
$text['allmedia'] = "все передатчики";
$text['repositories'] = "все передатчики";
$text['albums'] = "альбомы";
$text['cemeteries'] = "кладбища";
$text['surnames'] = "фамилии";
$text['dates'] = "даты";
$text['link'] = "сноска";
$text['media'] = "передатчик";
$text['gender'] = "пол";
$text['latitude'] = "ширина";
$text['longitude'] = "длина";
$text['bookmarks'] = "указатель страниц";
$text['bookmark'] = "добавить страницу";
$text['mngbookmarks'] = "идти на указатель страниц";
$text['bookmarked'] = "добавить страницу";
$text['remove'] = "удали";
$text['find_menu'] = "поиск";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Begraafplaats";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Event Map";
$text['gevents'] = "Event";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Link to Google Earth";
$text['googlemaplink'] = "Link to Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "Niet gemarkeerd";
$text['located'] = "Gelokaliseerd";
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
$text['mnuheader'] = "главная страница";
$text['mnusearchfornames'] = "поиск по имени";
$text['mnulastname'] = "фамилия";
$text['mnufirstname'] = "имя,отчество";
$text['mnusearch'] = "поиск";
$text['mnureset'] = "снова";
$text['mnulogon'] = "присутствие";
$text['mnulogout'] = "выйти";
$text['mnufeatures'] = "другие возможности";
$text['mnuregister'] = "зарегистрироваться";
$text['mnuadvancedsearch'] = "расширенный поиск";
$text['mnulastnames'] = "фамилии";
$text['mnustatistics'] = "статистика";
$text['mnuphotos'] = "фотографии";
$text['mnuhistories'] = "жизненные истории";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "кладбища";
$text['mnutombstones'] = "памятники";
$text['mnureports'] = "отчёты";
$text['mnusources'] = "источники";
$text['mnuwhatsnew'] = "что нового";
$text['mnushowlog'] = "последние действия ";
$text['mnulanguage'] = "измени язык";
$text['mnuadmin'] = "главная страница";
$text['welcome'] = "приветствуем";
$text['contactus'] = "контакт";

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
