<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Bläddra i källor";
		$text['shorttitle'] = "Kort titel";
		$text['callnum'] = "Klassifikation";
		$text['author'] = "Författare";
		$text['publisher'] = "Förläggare";
		$text['other'] = "Annan information";
		$text['sourceid'] = "Källans ID";
		$text['moresrc'] = "Flera källor";
		$text['repoid'] = "Arkivets ID";
		$text['browseallrepos'] = "Sök alla arkiv";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nytt språk";
		$text['changelanguage'] = "Byt språk";
		$text['languagesaved'] = "Språket har sparats";
		//added in 7.0.0
		$text['sitemaint'] = "Underhåll av sajten pågår";
		$text['standby'] = "Denna sajt är tillfälligt nere pga uppdatering av databasen. Försök igen om några minuter. Om sajten är nere en längre tid, <a href=\"suggest.php\">kontakta sajtens ägare</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM startar från";
		$text['producegedfrom'] = "Skapa GEDCOM-fil från";
		$text['numgens'] = "Antal generationer";
		$text['includelds'] = "Inkludera LDS-information";
		$text['buildged'] = "Generera GEDCOM";
		$text['gedstartfrom'] = "GEDCOM startar från";
		$text['nomaxgen'] = "Du måste ange maximum antal generationer. Använd bakåtknappen för att återvända till föregående sida och korrigera felet";
		$text['gedcreatedfrom'] = "GEDCOM skapad från";
		$text['gedcreatedfor'] = "skapad för";

		$text['enteremail'] = "Skriv in en giltig e-postadress.";
		$text['creategedfor'] = "Skapa GEDCOM";
		$text['email'] = "E-postadress";
		$text['suggestchange'] = "Föreslå förändring";
		$text['yourname'] = "Ditt namn";
		$text['comments'] = "Anteckningar och kommentarer";
		$text['comments2'] = "Kommentarer";
		$text['submitsugg'] = "Skicka förslaget";
		$text['proposed'] = "Föreslagen förändring";
		$text['mailsent'] = "Tack. Ditt meddelande har skickats.";
		$text['mailnotsent'] = "Vi beklagar att ditt meddelande inte kunnat skickats. Kontakta xxx direkt på yyy.";
		$text['mailme'] = "Skicka en kopia till denna adress";
		//added in 5.0.5
		$text['entername'] = "Skriv in ditt namn";
		$text['entercomments'] = "Skriv in dina kommentarer";
		$text['sendmsg'] = "Sänd meddelandet";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Foton & text-dokument för";
		$text['indinfofor'] = "Individuell information för";
		$text['reliability'] = "Tillförlitlighet";
		$text['pp'] = "sid.";
		$text['age'] = "Ålder";
		$text['agency'] = "Firma";
		$text['cause'] = "Orsak";
		$text['suggested'] = "FÖreslagen";
		$text['closewindow'] = "Stäng detta fönster";
		$text['thanks'] = "Tack";
		$text['received'] = "Ditt förslag har skickats till sajtens administratör för behandling.";
		//added in 6.0.0
		$text['association'] = "Organisation";
		//added in 7.0.0
		$text['indreport'] = "Individrapport";
		$text['indreportfor'] = "Individrapport för";
		$text['general'] = "Allmänt";
		$text['labels'] = "Märken";
		$text['bkmkvis'] = "<strong>OBS:</strong> Dessa bokmärken syns bara på denna dator och i denna webläsare.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Släktskapsberäkning";
		$text['findrel'] = "Beräkna släktskap";
		$text['person1'] = "Person 1:";
		$text['person2'] = "Person 2:";
		$text['calculate'] = "Beräkna";
		$text['select2inds'] = "Välj två individer.";
		$text['findpersonid'] = "Sök person-ID";
		$text['enternamepart'] = "mata in del av för- och/eller efternamn";
		$text['pleasenamepart'] = "Mata in en del av ett för- eller efternamn.";
		$text['clicktoselect'] = "klicka för val";
		$text['nobirthinfo'] = "Ingen födelseinformation";
		$text['relateto'] = "Släktskap med";
		$text['sameperson'] = "De två individerna är en och samma person.";
		$text['notrelated'] = "De två individerna är inte besläktade inom de xxx närmaste generationerna.";
		$text['findrelinstr'] = "Skriv in ID för två individer, eller behåll de visade personerna, klicka sedan på 'Beräkna' för att visa deras släktskap.";
		$text['gencheck'] = "Max generationer<br />att kontrollera";
		$text['sometimes'] = "(Ibland får man olika resultat om man söker över olika antal generationer.)";
		$text['findanother'] = "Hitta ett annat släkskap";
		//added in 6.0.0
		$text['brother'] = "bror till";
		$text['sister'] = "syster till";
		$text['sibling'] = "syskon till";
		$text['uncle'] = "xxx far-/morbror till";
		$text['aunt'] = "xxx far-/moster till";
		$text['uncleaunt'] = "xxx far-/morbror eller far-/moster till";
		$text['nephew'] = "xxx bror-/systerson till";
		$text['niece'] = "xxx bror-/systerdotter till";
		$text['nephnc'] = "xxx bror-/syster-son/dotter till";
		$text['mcousin'] = "xxx kusin till";
		$text['fcousin'] = "xxx kusin till";
		$text['cousin'] = "xxx kusin till";
		$text['removed'] = "gånger borttagna";
		$text['rhusband'] = "make till ";
		$text['rwife'] = "maka till ";
		$text['rspouse'] = "make/make till ";
		$text['son'] = "son till";
		$text['daughter'] = "dotter till";
		$text['rchild'] = "barn till";
		$text['sil'] = "svärson till";
		$text['dil'] = "svärdotter till";
		$text['sdil'] = "svärson/-dotter till";
		$text['gson'] = "xxx son (eng. grandson) till";
		$text['gdau'] = "xxx dotter (eng. granddaughter) till";
		$text['gsondau'] = "xxx son/dotter (eng. grandson/granddaughter) till";
		$text['great'] = "far/mor (eng. great)";
		$text['spouses'] = "är makar";
		$text['is'] = "är";
		//changed in 6.0.0
		$text['changeto'] = "Ändra till:";
		//added in 6.0.0
		$text['notvalid'] = "är inte ett giltigt person-ID eller finns inte i denna databas. Försök igen!";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Familjeöversikt för";
		$text['ldsords'] = "LDS förrättningar";
		$text['baptizedlds'] = "Döpt (LDS)";
		$text['endowedlds'] = "Begåvad (LDS)";
		$text['sealedplds'] = "Beseglad F (LDS)";
		$text['sealedslds'] = "Beseglad M (LDS)";
		$text['otherspouse'] = "Annan make/maka";
		//changed in 7.0.0
		$text['husband'] = "Make";
		$text['wife'] = "Maka";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "F";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "B";
		$text['capplaceabbr'] = "P";
		$text['capmarrabbr'] = "V";
		$text['capspouseabbr'] = "M";
		$text['redraw'] = "Rita om med";
		$text['scrollnote'] = "OBS! Du måste kanske bläddra nedåt eller till höger för att se diagrammet.";
		$text['unknownlit'] = "Okänd";
		$text['popupnote1'] = " = Ytterligare information";
		$text['popupnote2'] = " = Ny antavla";
		$text['pedcompact'] = "Kompakt";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Endast text";
		$text['descendfor'] = "Ättlingar till";
		$text['maxof'] = "Maximum";
		$text['gensatonce'] = "generationer visas samtidigt.";
		$text['sonof'] = "son till";
		$text['daughterof'] = "dotter till";
		$text['childof'] = "barn till";
		$text['stdformat'] = "Standardformat";

		$text['ahnentafel'] = "Listad antavla";
		$text['addnewfam'] = "Lägg till familj";
		$text['editfam'] = "Redigera familj";
		$text['side'] = "-sidan";
		$text['familyof'] = "Släkt till";
		$text['paternal'] = "På fädernet";
		$text['maternal'] = "På mödernet";
		$text['gen1'] = "Själv";
		$text['gen2'] = "Föräldrar";
		$text['gen3'] = "Far/morföräldrar";
		$text['gen4'] = "4:e generationen";
		$text['gen5'] = "5:e generationen";
		$text['gen6'] = "6:e generationen";
		$text['gen7'] = "7:e generationen";
		$text['gen8'] = "8:e generationen";
		$text['gen9'] = "9:e generationen";
		$text['gen10'] = "10:e generationen";
		$text['gen11'] = "11:e generationen";
		$text['gen12'] = "12:e generationen";
		$text['graphdesc'] = "Grafiskt ättlingaverk till denna punkt";
		$text['collapse'] = "Komprimera";
		$text['expand'] = "Expandera";
		$text['pedbox'] = "Ruta";
		//changed in 6.0.0
		$text['regformat'] = "Registerformat";
		$text['extrasexpl'] = "Om foton eller dokument finns för följande personer visas motsvarande symboler intill namnen.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nytt diagram";
		$text['mediaavail'] = "Media finns";
		//changed in 7.0.0
		$text['pedigreefor'] = "Antavla för";
		//added in 7.0.0
		$text['pedigreech'] = "Antavla";
		$text['datesloc'] = "Datum och Platser";
		$text['borchr'] = "Födelse/Dop - Död/Begravning (två)";
		$text['nobd'] = "Inga födelse- eller dödsdatum";
		$text['bcdb'] = "Födelse/Dop/Död/Begravning (fyra)";
		$text['numsys'] = "Numreringssystem";
		$text['gennums'] = "Generationsnummer";
		$text['henrynums'] = "Henry-nummer";
		$text['abovnums'] = "d'Aboville-nummer";
		$text['devnums'] = "de Villiers-nummer";
		$text['dispopts'] = "Visa alternativ";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "Det finns inga rapporter.";
		$text['reportname'] = "Rapportnamn";
		$text['allreports'] = "Rapporter";
		$text['report'] = "Rapport";
		$text['error'] = "Fel";
		$text['reportsyntax'] = "Denna rapports sök-syntax";
		$text['wasincorrect'] = "var ej korrekt, och rapporten kunde därför inte skapas. Kontakta systemadministratören på";
		$text['query'] = "Sök";
		$text['errormessage'] = "Felmeddelande";
		$text['equals'] = "lika med";
		$text['contains'] = "innehåller";
		$text['startswith'] = "börjar med";
		$text['endswith'] = "slutar med";
		$text['soundexof'] = "soundex av";
		$text['metaphoneof'] = "metaphone av";
		$text['plusminus10'] = "±10 år från";
		$text['lessthan'] = "mindre än";
		$text['greaterthan'] = "större än";
		$text['lessthanequal'] = "mindre än eller lika med";
		$text['greaterthanequal'] = "större än eller lika med";
		$text['equalto'] = "lika med";
		$text['tryagain'] = "Försök igen";
		$text['text_for'] = "för";
		$text['searchnames'] = "Sök namn";
		$text['joinwith'] = "Sammanfoga med";
		$text['cap_and'] = "OCH";
		$text['cap_or'] = "ELLER";
		$text['showspouse'] = "Visa make/maka (visar flera om individen har mer än en make/maka)";
		$text['submitquery'] = "Sök";
		$text['birthplace'] = "Födelseort";
		$text['deathplace'] = "Dödsort";
		$text['birthdatetr'] = "Födelseår";
		$text['deathdatetr'] = "Dödsår";
		$text['plusminus2'] = "±2 år från";
		$text['resetall'] = "Återställ alla värden";

		$text['showdeath'] = "Visa information om död/begravning";
		$text['altbirthplace'] = "Dopplats";
		$text['altbirthdatetr'] = "Dopår";
		$text['burialplace'] = "Begravningsplats";
		$text['burialdatetr'] = "Begravningsår";
		$text['event'] = "Händelse(r)";
		$text['day'] = "Dag";
		$text['month'] = "Månad";
		$text['keyword'] = "Nyckelord (t ex \"CA\")";
		$text['explain'] = "Skriv in datumfält för att se motsvarande händelser. Lämna fältet tomt för att se alla händelser.";
		$text['enterdate'] = "Skriv in eller välj minst en av följande: Dag, Månad, År, Nyckelord";
		$text['fullname'] = "Fullständigt namn";
		$text['birthdate'] = "Födelsedatum";
		$text['altbirthdate'] = "Dopdatum";
		$text['marrdate'] = "Äktenskapsdatum";
		$text['spouseid'] = "Make/maka ID";
		$text['spousename'] = "Makes/makas namn";
		$text['deathdate'] = "Dödsdatum";
		$text['burialdate'] = "Begravningsdatum";
		$text['changedate'] = "Senast ändrad, datum";
		$text['gedcom'] = "Träd";
		$text['baptdate'] = "Dopdatum (LDS)";
		$text['baptplace'] = "Dopplats (LDS)";
		$text['endldate'] = "Begåvningsdatum (LDS)";
		$text['endlplace'] = "Begåvningsplats (LDS)";
		$text['ssealdate'] = "Beseglingsdatum S (LDS)";
		$text['ssealplace'] = "Beseglingsplats S (LDS)";
		$text['psealdate'] = "Beseglingsdateum P (LDS)";
		$text['psealplace'] = "Beseglingsplats P (LDS)";
		$text['marrplace'] = "Vigselort";
		$text['spousesurname'] = "Makes/makas efternamn";
		//changed in 6.0.0
		$text['spousemore'] = "Om du skriver in makes/makas efternamn, så måste du fylla i ytterligare minst ett fält.";
		//added in 6.0.0
		$text['plusminus5'] = "±5 år från";
		$text['exists'] = "finns";
		$text['dnexist'] = "finns inte";
		//added in 6.0.3
		$text['divdate'] = "Skilsmässodatum";
		$text['divplace'] = "Skilsmässoplats";
		//changed in 7.0.0
		$text['otherevents'] = "Andra händelser";
		//added in 7.0.0
		$text['numresults'] = "Resultat per sida";
		$text['mysphoto'] = "Gåtfulla foton";
		$text['mysperson'] = "Svårfångade personer";
		$text['joinor'] = "Alternativet 'Sammanfoga med ELLER' kan inte användas med makes/makas efternamn";
		//added in 7.0.1
		$text['tellus'] = "Berätta vad du vet";
		$text['moreinfo'] = "Mera information:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Logg-fil för";
		$text['mostrecentactions'] = "Senaste åtgärder";
		$text['autorefresh'] = "Auto-uppdatering (30 sekunder)";
		$text['refreshoff'] = "Stäng av Auto-uppdatering";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Gravplatser och -stenar";
		$text['showallhsr'] = "Visa alla gravstenar";
		$text['in'] = "i";
		$text['showmap'] = "Visa karta";
		$text['headstonefor'] = "Gravsten för";
		$text['photoof'] = "Foto av";
		$text['firstpage'] = "Första sidan";
		$text['lastpage'] = "Sista sidan";
		$text['photoowner'] = "Ägare/Källa";

		$text['nocemetery'] = "Ingen begravningsplats";
		$text['iptc005'] = "Titel";
		$text['iptc020'] = "Tilläggskategorier";
		$text['iptc040'] = "Specialinstruktioner";
		$text['iptc055'] = "Skapat";
		$text['iptc080'] = "Författare";
		$text['iptc085'] = "Författarens position";
		$text['iptc090'] = "Stad";
		$text['iptc095'] = "Stat";
		$text['iptc101'] = "Land";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Rubrik";
		$text['iptc110'] = "Källa";
		$text['iptc115'] = "Fotografiets källa";
		$text['iptc116'] = "Upphovsmannarätten";
		$text['iptc120'] = "Bildtext";
		$text['iptc122'] = "Biltextens författare";
		$text['mapof'] = "Karta över";
		$text['regphotos'] = "Beskrivande översikt";
		$text['gallery'] = "Endast frimärksbilder";
		$text['cemphotos'] = "Gravplatsfoton";
		//changed in 6.0.0
		$text['photosize'] = "Storlek";
		//added in 6.0.0
        	$text['iptc010'] = "Prioritet";
		$text['filesize'] = "Filstorlek";
		$text['seeloc'] = "Se Plats";
		$text['showall'] = "Visa alla";
		$text['editmedia'] = "Redigera Media";
		$text['viewitem'] = "Se denna post";
		$text['editcem'] = "Redigera Gravplats";
		$text['numitems'] = "# Poster";
		$text['allalbums'] = "Alla Album";
		//added in 6.1.0
		$text['slidestart'] = "Starta Bildspel";
		$text['slidestop'] = "Pausa Bildspel";
		$text['slideresume'] = "Återuppta Bildspel";
		$text['slidesecs'] = "Sekunder per bild:";
		$text['minussecs'] = "minus 0.5 sekunder";
		$text['plussecs'] = "plus 0.5 sekunder";
		//added in 7.0.0
		$text['nocountry'] = "Okänt land";
		$text['nostate'] = "Okänd stat";
		$text['nocounty'] = "Okänt län";
		$text['nocity'] = "Okänd stad";
		$text['nocemname'] = "Okänd begravningsplats";
		$text['plot'] = "Plotta";
		$text['location'] = "Plats";
		$text['editalbum'] = "Redigera Album";
		$text['mediamaptext'] = "<strong>OBS:</strong> Flytta muspekaren över bilden för att visa namn. Klicka för att se en sida för varje namn.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Visa efternamn som börjar med";
		$text['showtop'] = "Visa de första";
		$text['showallsurnames'] = "Visa alla efternamn";
		$text['sortedalpha'] = "sorterade alfabetiskt";
		$text['byoccurrence'] = "sorterade efter förekomst";
		$text['firstchars'] = "Första bokstav";
		$text['top'] = "De vanligaste";
		$text['mainsurnamepage'] = "Huvudsida för efternamn";
		$text['allsurnames'] = "Alla efternamn";
		$text['showmatchingsurnames'] = "Klicka på ett efternamn för att visa motsvarande poster.";
		$text['backtotop'] = "Tillbaka till början";
		$text['beginswith'] = "Börjar med";
		$text['allbeginningwith'] = "Alla efternamn som börjar med";
		$text['numoccurrences'] = "Antal förekomster inom parentes";
		$text['placesstarting'] = "Visa platser som börjar på";
		$text['showmatchingplaces'] = "Klicka på ett ortnamn för att visa mindre orter. Klicka på söksymbolen för att visa matchande personer.";
		$text['totalnames'] = "alla individer";
		$text['showallplaces'] = "Visa alla största platser";
		$text['totalplaces'] = "alla platser";
		$text['mainplacepage'] = "Huvudsida för platser";
		$text['allplaces'] = "Alla största platser";
		$text['placescont'] = "Visa alla platser som innehåller";
		//added in 7.0.0
		$text['top30'] = "Topp-30 efternamn";
		$text['top30places'] = "Topp-30 platser";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(senaste xx dagarna)";
		$text['historiesdocs'] = "Text-dokument";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Foto";
		$text['history'] = "Text-dokument";
		//changed in 7.0.0
		$text['husbid'] = "Makens ID";
		$text['husbname'] = "Makens namn";
		$text['wifeid'] = "Makans ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Stryk";
		$text['addperson'] = "Lägg till person";
		$text['nobirth'] = "Följande individ har inte korrekt födelsedatum och kunde inte läggas till";
		$text['noliving'] = "Följande individer är märkta såsom levande och kunde inte läggas till p.g.a. att du inte är inloggad med tillräckliga rättigheter";
		$text['event'] = "Händelse(r)";
		$text['chartwidth'] = "Diagrambredd";
		//changed in 6.0.0
		$text['timelineinstr'] = "Lägg till ytterligare upp till fyra individer genom att mata in deras ID:";
		//added in 6.0.0
		$text['togglelines'] = "Visa/dölj linjer";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Bläddra i träd";
		$text['treename'] = "Trädets namn";
		$text['owner'] = "Ägare";
		$text['address'] = "Adress";
		$text['city'] = "Ort";
		$text['state'] = "Län/Provins/Delstat";
		$text['zip'] = "Postnummer";
		$text['country'] = "Land";
		$text['email'] = "E-postadress";
		$text['phone'] = "Telefon";
		$text['username'] = "Användarnamn";
		$text['password'] = "Lösenord";
		$text['loginfailed'] = "Inloggningen misslyckades.";

		$text['regnewacct'] = "Registrera användarkonto";
		$text['realname'] = "Ditt verkliga namn";
		$text['phone'] = "Telefon";
		$text['email'] = "E-postadress";
		$text['address'] = "Adress";
		$text['comments'] = "Anteckningar och kommentarer";
		$text['submit'] = "Sänd bidrag";
		$text['leaveblank'] = "(lämna tomt om du önskar en ny trädstruktur)";
		$text['required'] = "Obligatoriska fält";
		$text['enterpassword'] = "skriv in ett lösenord.";
		$text['enterusername'] = "Skriv in ett användarnamn.";
		$text['failure'] = "Tyvärr är användarnamnet i bruk. Använd bakåt-knappen i din bläddrare och välj ett annat användarnamn.";
		$text['success'] = "Tack! Vi har emottagit din registrering. Vi kontaktar dig när kontot är aktivt eller om ytterligare information behövs.";
		$text['emailsubject'] = "Ny TNG användarregistrering";
		$text['emailmsg'] = "Du har fått en begäran om ett nytt TNG konto. Logga in på ditt TNG admin-område för att ge rätta befogengenheter för kontot. Om du godkänner registreringen, meddela personen i fråga genom att svara på denna e-post.";
		//changed in 5.0.0
		$text['enteremail'] = "Skriv in en giltig e-postadress.";
		$text['website'] = "Websajt";
		$text['nologin'] = "Har du ingen inlogging?";
		$text['loginsent'] = "Inloggningsinformationen har skickats";
		$text['loginnotsent'] = "Inloggningsinformationen har inte skickats";
		$text['enterrealname'] = "Skriv in ditt namn.";
		$text['rempass'] = "Förbli inloggad på denna dator";
		$text['morestats'] = "Mera statistik";
		//added in 6.0.0
		$text['accmail'] = "<strong>OBS:</strong> För att få e-post från administratören angående ditt konto, se till att du inte blockerar e-post från denna domän!";
		$text['newpassword'] = "Nytt lösenord";
		$text['resetpass'] = "Återställ ditt lösenord";
		//added in 6.1.0
		$text['nousers'] = "Detta formulär kan inte användas förrän minst en användarregistrering gjorts. Om Du äger denna sajt, gå till Admin/Användare och skapa Administrator-konto.";
		//added in 7.0.0
		$text['noregs'] = "Vi tar för tillfället inte emot nya användarregistreringar. <a href=\"suggest.php\">Kontakta oss</a> direkt om du har kommentarer eller frågor om något på denna sajt.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Kvantitet";
		$text['totindividuals'] = "Totalt antal individer";
		$text['totmales'] = "- varav manliga";
		$text['totfemales'] = "- varav kvinnliga";
		$text['totunknown'] = "- varav av okänt kön";
		$text['totliving'] = "- varav levande";
		$text['totfamilies'] = "Antal familjer";
		$text['totuniquesn'] = "Antal unika efternamn";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Totalt antal källor";
		$text['avglifespan'] = "Medellivslängd";
		$text['earliestbirth'] = "Tidigaste födsel";
		$text['longestlived'] = "Största livslängd";
		$text['years'] = "år";
		$text['days'] = "dagar";
		$text['age'] = "Ålder";
		$text['agedisclaimer'] = "Åldersberäkningarna baserar sig på individer med registrerade födelse- <EM>och</EM> dödsdatum. P.g.a att det kan finnas ofullständiga datumfält (t ex enbart \"1945\" eller \"BEF 1860\"), är dessa beräkingar inte helt tillförlitliga.";
		$text['treedetail'] = "Mera information om detta träd";
		//added in 6.0.0
		$text['total'] = "Totalt antal";
		break;

	case "notes":
		$text['browseallnotes'] = "Bläddra i alla Noteringar";
		break;

	case "help":
		$text['menuhelp'] = "Meny";
		break;

	case "install":
		$text['perms'] = "Alla rättigheter är definierade.";
		$text['noperms'] = "Rättigheter kunde inte definieras för följande filer:";
		$text['manual'] = "Ställ in dem manuellt!";
		$text['folder'] = "Mapp";
		$text['created'] = "har skapats";
		$text['nocreate'] = "kunde inte skapas. Skapa den manuellt!";
		$text['infosaved'] = "Informationen sparad, kopplingen verifierad!";
		$text['tablescr'] = "Tabellerna har skapats!";
		$text['notables'] = "Följande tabeller kunde inte skapas:";
		$text['nocomm'] = "TNG kommunicerar inte med databasen. Inga tabeller skapades.";
		$text['newdb'] = "Informationen sparad, kopplingen verifierad, ny databas skapad:";
		$text['noattach'] = "Informationen sparad. Koppling gjord och databas skapad, men TNG kan inte ansluta till den.";
		$text['nodb'] = "Informationen sparad. Koppling gjord, men databasen existerar inte och kunde inte skapas här. Verifiera att databasnamnet är korrekt eller använd din kontrollpanel för att skapa den.";
		$text['noconn'] = "Informationen sparad men kopplingen misslyckades. Ett eller flera av följande är fel:";
		$text['exists'] = "finns";
		$text['loginfirst'] = "Du måste först logga in.";
		$text['noop'] = "Ingen åtgärd har utförts.";
		break;
}

//common
$text['matches'] = "Träffar";
$text['description'] = "Beskrivning";
$text['notes'] = "Noteringar";
$text['status'] = "Status";
$text['newsearch'] = "Ny sökning";
$text['pedigree'] = "Antavla";
$text['birthabbr'] = "f.";
$text['chrabbr'] = "dp.";
$text['seephoto'] = "Se foto";
$text['andlocation'] = "& placering";
$text['accessedby'] = "läst av";
$text['go'] = "Visa";
$text['family'] = "Familj";
$text['children'] = "Barn";
$text['tree'] = "Träd";
$text['alltrees'] = "Alla träd";
$text['nosurname'] = "[Inget efternamn]";
$text['thumb'] = "Frimärke";
$text['people'] = "Människor";
$text['title'] = "Titel";
$text['suffix'] = "Suffix";
$text['nickname'] = "Smeknamn";
$text['deathabbr'] = "d.";
$text['lastmodified'] = "Senast ändrad";
$text['married'] = "Gift";
//$text['photos'] = "Photos";
$text['name'] = "Namn";
$text['lastfirst'] = "Efternamn, förnamn";
$text['bornchr'] = "Född/Döpt";
$text['individuals'] = "Individer";
$text['families'] = "Familjer";
$text['personid'] = "Person-ID";
$text['sources'] = "Källor";
$text['unknown'] = "Okänd";
$text['father'] = "Far";
$text['mother'] = "Mor";
$text['born'] = "Född";
$text['christened'] = "Döpt";
$text['died'] = "Död";
$text['buried'] = "Begraven";
$text['spouse'] = "Make/Maka";
$text['parents'] = "Föräldrar";
$text['text'] = "Text";
$text['language'] = "Språk";
$text['burialabbr'] = "bg.";
$text['descendchart'] = "Ättlingar";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Individ";
$text['edit'] = "Redigera";
$text['date'] = "Datum";
$text['place'] = "Plats";
$text['login'] = "Logga in";
$text['logout'] = "Logga ut";
$text['marrabbr'] = "v.";
$text['groupsheet'] = "Familjeöversikt";
$text['text_and'] = "och";
$text['generation'] = "Generation";
$text['filename'] = "Filnamn";
$text['id'] = "ID";
$text['search'] = "Sök";
$text['living'] = "Levande";
$text['user'] = "Användare";
$text['firstname'] = "Förnamn";
$text['lastname'] = "Efternamn";
$text['searchresults'] = "Sökresultat";
$text['diedburied'] = "Död/Begraven";
$text['homepage'] = "Hem";
$text['find'] = "Sök...";
$text['relationship'] = "Släktskap";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Tidslinje";
$text['yesabbr'] = "J";
$text['divorced'] = "Skilda";
$text['indlinked'] = "Länkad till";
$text['branch'] = "Gren";
$text['moreind'] = "Flera individer";
$text['morefam'] = "Flera familjer";
$text['livingdoc'] = "Minst en levande person är länkad till detta foto-dokument - Detaljinformation visas inte.";
$text['source'] = "Källa";
$text['surnamelist'] = "Efternamnslista";
$text['generations'] = "Generationer";
$text['refresh'] = "Uppdatera";
$text['whatsnew'] = "Nyheter";
$text['reports'] = "Rapporter";
$text['placelist'] = "Platslista";
$text['baptizedlds'] = "Döpt (LDS)";
$text['endowedlds'] = "Begåvad (LDS)";
$text['sealedplds'] = "Beseglad F (LDS)";
$text['sealedslds'] = "Beseglad M (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Anor";
$text['descendants'] = "Ättlingar";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Senaste GEDCOM import";
$text['type'] = "Typ";
$text['savechanges'] = "Spara ändringar";
$text['familyid'] = "Familjens ID";
$text['headstone'] = "Gravsten";
$text['historiesdocs'] = "Text-dokument";
$text['livingnote'] = "Minst en levande person är länkad till denna notering - Detaljer visas inte.";
$text['anonymous'] = "anonym";
$text['places'] = "Platser";
$text['anniversaries'] = "Datum & Bemärkelsedagar";
$text['administration'] = "Administration";
$text['help'] = "Hjälp";
//$text['documents'] = "Documents";
$text['year'] = "År";
$text['all'] = "Alla";
$text['repository'] = "Arkiv";
$text['address'] = "Adress";
$text['suggest'] = "Föreslå";
$text['editevent'] = "Föreslå ändring av denna händelse";
$text['findplaces'] = "Hitta alla personer med händelser på denna plats";
$text['morelinks'] = "Flera länkar";
$text['faminfo'] = "Familjeinformation";
$text['persinfo'] = "Personlig information";
$text['srcinfo'] = "Information om källan";
$text['fact'] = "Fakta";
$text['goto'] = "Välj en sida";
$text['tngprint'] = "Skriv ut";
//changed in 6.0.0
$text['livingphoto'] = "Minst en levande person är länkad till denna bild - Detaljinformation visas inte.";
$text['databasestatistics'] = "Databasstatistik";
//moved here in 6.0.0
$text['child'] = "Barn";
$text['repoinfo'] = "Arkivinformation";
$text['tng_reset'] = "Återställ";
$text['noresults'] = "Inget resultat";
//added in 6.0.0
$text['allmedia'] = "Alla Media";
$text['repositories'] = "Arkiv";
$text['albums'] = "Album";
$text['cemeteries'] = "Gravplatser";
$text['surnames'] = "Efternamn";
$text['dates'] = "Datum";
$text['link'] = "Länk";
$text['media'] = "Media";
$text['gender'] = "Kön";
$text['latitude'] = "Latitud";
$text['longitude'] = "Longitud";
$text['bookmarks'] = "Bokmärken";
$text['bookmark'] = "Lägg till Bokmärke";
$text['mngbookmarks'] = "Gå till Bokmärken";
$text['bookmarked'] = "Bokmärke tillagt";
$text['remove'] = "Ta bort";
$text['find_menu'] = "Hitta";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Gravplats";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Händelse-karta";
$text['gevents'] = "Händelse";
$text['glang'] = "&amp;hl=sv";
$text['googleearthlink'] = "Länk till Google Earth";
$text['googlemaplink'] = "Länk till Google Maps";
$text['gmaplegend'] = "Teckenförklaring, märken";
//moved here in 7.0.0
$text['unmarked'] = "Omarkerad";
$text['located'] = "Lokaliserad";
//added in 7.0.0
$text['albclicksee'] = "Klicka för att se alla poster i detta album.";
$text['notyetlocated'] = "Ej lokaliserad ännu";
$text['cremated'] = "Kremerad";
$text['missing'] = "Saknad";
$text['page'] = "Sida";
$text['pdfgen'] = "PDF-Generator";
$text['blank'] = "Blankt diagram";
$text['none'] = "Ingen";
$text['fonts'] = "Fonter";
$text['header'] = "Rubrik";
$text['data'] = "Data";
$text['pgsetup'] = "Sidinställningar";
$text['pgsize'] = "Sidstorlek";
$text['letter'] = "Letter";
$text['legal'] = "Legal";
$text['orient'] = "Orientering";
$text['portrait'] = "Stående";
$text['landscape'] = "Liggande";
$text['tmargin'] = "Toppmarginal";
$text['bmargin'] = "Bottenarginal";
$text['lmargin'] = "Vänstermarginal";
$text['rmargin'] = "Högermarginal";
$text['createch'] = "Skapa diagram";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Mest Eftersökt";
$text['latupdates'] = "Senaste uppdateringar";
$text['featphoto'] = "Vinjettfoto"; //???
$text['news'] = "Nyheter";
$text['ourhist'] = "Vår familjehistoria";
$text['ourhistanc'] = "Vår familjehistoria och anor";
$text['ourpages'] = "Vår familjs släktsida";
$text['pwrdby'] = "Denna sajt är byggd med";
$text['writby'] = "skapad av";
$text['searchtngnet'] = "Sök TNG Network (GENDEX)";
$text['viewphotos'] = "Se alla foton";
$text['anon'] = "Du är för närvarande anonym";
$text['whichbranch'] = "Vilken gren kommer du ifrån?";
$text['featarts'] = "Vinjettartikel";  //???
$text['maintby'] = "Underhålls av";
$text['createdon'] = "Skapad den";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Hemsida";
$text['mnusearchfornames'] = "Sök namn";
$text['mnulastname'] = "Efternamn";
$text['mnufirstname'] = "Förnamn";
$text['mnusearch'] = "Sök";
$text['mnureset'] = "Starta om";
$text['mnulogon'] = "Logga in";
$text['mnulogout'] = "Logga ut";
$text['mnufeatures'] = "Andra funktioner";
$text['mnuregister'] = "Ansök om användarkonto";
$text['mnuadvancedsearch'] = "Avancerad sökning";
$text['mnulastnames'] = "Efternamn";
$text['mnustatistics'] = "Statistik";
$text['mnuphotos'] = "Foton";
$text['mnuhistories'] = "Text-dokument";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Gravplatser";
$text['mnutombstones'] = "Gravstenar";
$text['mnureports'] = "Rapporter";
$text['mnusources'] = "Källor";
$text['mnuwhatsnew'] = "Nyheter";
$text['mnushowlog'] = "Gå till Logg";
$text['mnulanguage'] = "Byt språk";
$text['mnuadmin'] = "Administration";
$text['welcome'] = "Välkommen";
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
