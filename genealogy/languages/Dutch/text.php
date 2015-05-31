<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Toon alle bronnen";
		$text['shorttitle'] = "Korte titel";
		$text['callnum'] = "Archiefnummer";
		$text['author'] = "Auteur";
		$text['publisher'] = "Uitgever";
		$text['other'] = "Andere informatie";
		$text['sourceid'] = "Bron-ID";
		$text['moresrc'] = "Meer bronnen";
		$text['repoid'] = "Vindplaats-ID";
		$text['browseallrepos'] = "Toon alle vindplaatsen";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nieuwe taal";
		$text['changelanguage'] = "Wijzig taal";
		$text['languagesaved'] = "Taal opgeslagen";
		//added in 7.0.0
		$text['sitemaint'] = "Website niet beschikbaar in verband met onderhoud";
		$text['standby'] = "De website is tijdelijk niet beschikbaar. Probeer het a.u.b. over een tijdje nogmaals. Indien de website voor langere tijd niet beschikbaar blijkt, neem dan contact op met de eigenaar van de website <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM start vanaf";
		$text['producegedfrom'] = "Maak een GEDCOM met zijn/haar";
		$text['numgens'] = "Aantal generaties";
		$text['includelds'] = "Inclusief HLD informatie";
		$text['buildged'] = "Maak GEDCOM";
		$text['gedstartfrom'] = "GEDCOM begint bij";
		$text['nomaxgen'] = "U moet het maximum aantal generaties aangeven. Gebruik uw browser om terug te gaan naar de vorige bladzijde en verbeter de fout";
		$text['gedcreatedfrom'] = "GEDCOM opgemaakt vanuit";
		$text['gedcreatedfor'] = "opgemaakt voor";

		$text['enteremail'] = "Vul aub een bestaand e-mail adres in.";
		$text['creategedfor'] = "Maak GEDCOM";
		$text['email'] = "E-mail adres";
		$text['suggestchange'] = "Suggestie / opmerking mbt ";
		$text['yourname'] = "Uw naam";
		$text['comments'] = "Commentaar";
		$text['comments2'] = "Commentaar";
		$text['submitsugg'] = "Verstuur suggestie / opmerking";
		$text['proposed'] = "Suggestie / opmerking mbt";
		$text['mailsent'] = "Bedankt, uw suggestie / opmerking is verstuurd.";
		$text['mailnotsent'] = "Helaas, uw bericht kon niet worden bezorgd. Neem aub rechtstreeks contact op met xxx via yyy.";
		$text['mailme'] = "Stuur een kopie van dit bericht naar dit e-mail adres";
		//added in 5.0.5
		$text['entername'] = "Vul aub uw naam in";
		$text['entercomments'] = "Vul aub uw opmerking / suggestie in";
		$text['sendmsg'] = "Verstuur boodschap";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Foto's en (levens)verhalen van";
		$text['indinfofor'] = "Persoonlijke informatie van";
		$text['reliability'] = "Betrouwbaarheid";
		$text['pp'] = "blz.";
		$text['age'] = "Leeftijd";
		$text['agency'] = "Instantie";
		$text['cause'] = "Oorzaak";
		$text['suggested'] = "Voorstel";
		$text['closewindow'] = "Sluit dit venster";
		$text['thanks'] = "Dank u wel";
		$text['received'] = "Uw voorgestelde wijziging is doorgestuurd naar de beheerder van de site ter beoordeling.";
		//added in 6.0.0
		$text['association'] = "Connectie";
		//added in 7.0.0
		$text['indreport'] = "Persoonlijk rapport";
		$text['indreportfor'] = "Persoonlijk rapport van";
		$text['general'] = "Algemeen";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Opm.:</strong> Deze bladwijzers zijn alleen op deze computer met deze browser zichtbaar.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Verwantschap berekenen";
		$text['findrel'] = "Zoek verwantschap";
		$text['person1'] = "Persoon 1:";
		$text['person2'] = "Persoon 2:";
		$text['calculate'] = "Berekenen";
		$text['select2inds'] = "Aub twee personen selecteren.";
		$text['findpersonid'] = "Zoek Persoon-ID";
		$text['enternamepart'] = "Vul een deel van de voor- en/of achternaam in";
		$text['pleasenamepart'] = "Aub een deel van de voor- en/of achternaam invullen.";
		$text['clicktoselect'] = "Klik om te selecteren";
		$text['nobirthinfo'] = "Geen geboorte gegevens";
		$text['relateto'] = "Verwantschap met";
		$text['sameperson'] = "De twee personen zijn één en dezelfde persoon.";
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
		$text['capbirthabbr'] = "G";
		$text['capaltbirthabbr'] = "D";
		$text['capdeathabbr'] = "O";
		$text['capburialabbr'] = "B";
		$text['capplaceabbr'] = "te";
		$text['capmarrabbr'] = "H";
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
		$text['pedigreech'] = "Kwartierstaat";
		$text['datesloc'] = "Datums en plaatsen";
		$text['borchr'] = "Geboorte/Afw - Overlijden/Begraven (twee)";
		$text['nobd'] = "Geen geboorte- of overlijdensdatums";
		$text['bcdb'] = "Geboorte/Afw/Overlijden/Begraven (vier)";
		$text['numsys'] = "Nummersysteem";
		$text['gennums'] = "Generatienummers";
		$text['henrynums'] = "Henry Nummers";
		$text['abovnums'] = "d'Aboville nummers";
		$text['devnums'] = "de Villiers Nummers";
		$text['dispopts'] = "Weergave opties";
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
		$text['numresults'] = "Resultaten per pagina";
		$text['mysphoto'] = "Mysterieuze foto's";
		$text['mysperson'] = "Onbekende personen";
		$text['joinor'] = "De 'Join with OR' optie kan niet gebruikt worden met Achternaam van partner";
		//added in 7.0.1
		$text['tellus'] = "Vertel ons wat je weet";
		$text['moreinfo'] = "Meer informatie:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Logbestand voor";
		$text['mostrecentactions'] = "Laatste acties";
		$text['autorefresh'] = "Schakel automatisch verversen AAN (30 seconden)";
		$text['refreshoff'] = "Schakel automatisch verversen UIT";
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
		$text['slidestart'] = "Start diashow";
		$text['slidestop'] = "Stop diashow";
		$text['slideresume'] = "Voortzetten diashow";
		$text['slidesecs'] = "Seconden per dia:";
		$text['minussecs'] = "min 0.5 seconden";
		$text['plussecs'] = "plus 0.5 seconden";
		//added in 7.0.0
		$text['nocountry'] = "Onbekend land";
		$text['nostate'] = "Onbekende provincie/staat";
		$text['nocounty'] = "Onbekende gemeente";
		$text['nocity'] = "Onbekende plaats";
		$text['nocemname'] = "Onbekende begraafplaatsnaam";
		$text['plot'] = "Vak";
		$text['location'] = "Plaats";
		$text['editalbum'] = "Wijzig Album";
		$text['mediamaptext'] = "<strong>Opm.:</strong> Beweeg uw muis over de afbeelding voor de namen. Klik om een pagina voor elke naam te krijgen.";
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
		$text['top30'] = "Achternaam Top 30";
		$text['top30places'] = "Top 30 grootste plaatsen";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(sinds de laatste xx dagen)";
		$text['historiesdocs'] = "(Levens)verhalen";
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
		$text['address'] = "Adres";
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
		$text['address'] = "Adres";
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
		$text['nousers'] = "Dit scherm kan pas gebruikt worden als minstens één gebruiker bekend is. Als u de eigenaar van deze site bent, ga dan naar Startpagina Beheerder > Gebruikers om een Administrator-account aan te maken.";
		//added in 7.0.0
		$text['noregs'] = "Sorry, maar momenteel accepteren we geen nieuwe gebruikers. Neem aub <a href=\"suggest.php\">via mail contact</a> met ons op indien u vragen en/of opmerkingen heeft met betrekking tot deze website.";
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
$text['nosurname'] = "[geen familienaam]";
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
$text['ancestors'] = "Voorouders";
$text['descendants'] = "Nakomelingen";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Datum van laatste GEDCOM import";
$text['type'] = "Type";
$text['savechanges'] = "Veranderingen opslaan";
$text['familyid'] = "Gezins-ID";
$text['headstone'] = "Grafstenen";
$text['historiesdocs'] = "(Levens)verhalen";
$text['livingnote'] = "Tenminste nog één levende persoon is verbonden aan deze aantekening - detailgegevens worden niet weergegeven.";
$text['anonymous'] = "anoniem";
$text['places'] = "Plaatsen";
$text['anniversaries'] = "Datums & Verjaardagen";
$text['administration'] = "Administratie";
$text['help'] = "Help";
//$text['documents'] = "Documents";
$text['year'] = "Jaar";
$text['all'] = "Alles";
$text['repository'] = "Vindplaats";
$text['address'] = "Adres";
$text['suggest'] = "Suggestie";
$text['editevent'] = "Wijzigingsvoorstel mbt deze gebeurtenis";
$text['findplaces'] = "Zoek alle personen met gebeurtenissen in deze plaats";
$text['morelinks'] = "Meer linken";
$text['faminfo'] = "Gezinsinformatie";
$text['persinfo'] = "Persoonlijke informatie";
$text['srcinfo'] = "Bron informatie";
$text['fact'] = "Feit";
$text['goto'] = "Selecteer een pagina";
$text['tngprint'] = "Print";
//changed in 6.0.0
$text['livingphoto'] = "Tenminste één, nog levende, persoon is verbonden aan dit item - detailgegevens worden niet weergegeven.";
$text['databasestatistics'] = "Statistieken";
//moved here in 6.0.0
$text['child'] = "Kind";
$text['repoinfo'] = "Vindplaats informatie";
$text['tng_reset'] = "Maak leeg";
$text['noresults'] = "Geen resultaten gevonden";
//added in 6.0.0
$text['allmedia'] = "Alle Media";
$text['repositories'] = "Vindplaatsen";
$text['albums'] = "Albums";
$text['cemeteries'] = "Begraafplaatsen";
$text['surnames'] = "Familienamen";
$text['dates'] = "Datums";
$text['link'] = "Link";
$text['media'] = "Media";
$text['gender'] = "Geslacht";
$text['latitude'] = "Latitude (Breedte)";
$text['longitude'] = "Longitude (Lengte)";
$text['bookmarks'] = "Bladwijzers";
$text['bookmark'] = "Voeg bladwijzer toe";
$text['mngbookmarks'] = "Ga naar de bladwijzers";
$text['bookmarked'] = "Bladwijzer toegevoegd";
$text['remove'] = "Verwijder";
$text['find_menu'] = "Zoek";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Begraafplaats";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Gebeurteniskaart";
$text['gevents'] = "Gebeurtenissen";
$text['glang'] = "&amp;hl=nl";
$text['googleearthlink'] = "Link naar Google Earth";
$text['googlemaplink'] = "Link naar Google Maps";
$text['gmaplegend'] = "Pin Legenda";
//moved here in 7.0.0
$text['unmarked'] = "Niet gemarkeerd";
$text['located'] = "Gelokaliseerd";
//added in 7.0.0
$text['albclicksee'] = "Klik hier om alle items in dit album te zien";
$text['notyetlocated'] = "Nog niet gelokaliseerd";
$text['cremated'] = "Gecremeerd";
$text['missing'] = "Vermist";
$text['page'] = "Pagina";
$text['pdfgen'] = "PDF-maker";
$text['blank'] = "Blanco formulier";
$text['none'] = "Geen";
$text['fonts'] = "Lettertypen";
$text['header'] = "Kop";
$text['data'] = "Gegevens";
$text['pgsetup'] = "Pagina-opmaak";
$text['pgsize'] = "Pagina-grootte";
$text['letter'] = "Letter";
$text['legal'] = "Legal";
$text['orient'] = "Oriëntatie";
$text['portrait'] = "Portret";
$text['landscape'] = "Landschap";
$text['tmargin'] = "Top-marge";
$text['bmargin'] = "Onder-marge";
$text['lmargin'] = "Linker Marge";
$text['rmargin'] = "Rechter Marge";
$text['createch'] = "Maak overzicht";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Gezocht";
$text['latupdates'] = "Laatste wijzigingen";
$text['featphoto'] = "Speciale foto";
$text['news'] = "Nieuws";
$text['ourhist'] = "Onze familiegeschiedenis";
$text['ourhistanc'] = "Onze familiegeschiedenis en voorouders";
$text['ourpages'] = "Genealogie-pagina's van onze familie";
$text['pwrdby'] = "Deze site wordt aangemaakt door";
$text['writby'] = "geschreven door";
$text['searchtngnet'] = "Zoek in TNG Network (GENDEX)";
$text['viewphotos'] = "Bekijk alle foto's";
$text['anon'] = "U bent momenteel anoniem";
$text['whichbranch'] = "Van welke tak bent u?";
$text['featarts'] = "Speciale artikelen";
$text['maintby'] = "Gegevens onderhouden door";
$text['createdon'] = "Aangemaakt op";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Startpagina";
$text['mnusearchfornames'] = "Zoeken naar namen";
$text['mnulastname'] = "Familienaam";
$text['mnufirstname'] = "Voorna(a)m(en)";
$text['mnusearch'] = "Zoek";
$text['mnureset'] = "Opnieuw";
$text['mnulogon'] = "Aanmelden";
$text['mnulogout'] = "Afmelden";
$text['mnufeatures'] = "Andere mogelijkheden";
$text['mnuregister'] = "Registreer uzelf";
$text['mnuadvancedsearch'] = "Geavanceerd zoeken";
$text['mnulastnames'] = "Familienamen";
$text['mnustatistics'] = "Statistieken";
$text['mnuphotos'] = "Foto's";
$text['mnuhistories'] = "(Levens)verhalen";
$text['mnumyancestors'] = "Foto's &amp; (Levens)verhalen mbt de voorouders van [Persoon]";
$text['mnucemeteries'] = "Begraafplaatsen";
$text['mnutombstones'] = "Grafstenen";
$text['mnureports'] = "Rapporten";
$text['mnusources'] = "Bronnen";
$text['mnuwhatsnew'] = "Wat is er nieuw";
$text['mnushowlog'] = "Laatste akties log";
$text['mnulanguage'] = "Verander van taal";
$text['mnuadmin'] = "Startpagina Beheerder";
$text['welcome'] = "Welkom";
$text['contactus'] = "Contact";

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
