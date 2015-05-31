<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Bl�ddra i k�llor";
		$text['shorttitle'] = "Kort titel";
		$text['callnum'] = "Klassifikation";
		$text['author'] = "F�rfattare";
		$text['publisher'] = "F�rl�ggare";
		$text['other'] = "Annan information";
		$text['sourceid'] = "K�llans ID";
		$text['moresrc'] = "Flera k�llor";
		$text['repoid'] = "Arkivets ID";
		$text['browseallrepos'] = "S�k alla arkiv";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nytt spr�k";
		$text['changelanguage'] = "Byt spr�k";
		$text['languagesaved'] = "Spr�ket har sparats";
		//added in 7.0.0
		$text['sitemaint'] = "Underh�ll av sajten p�g�r";
		$text['standby'] = "Denna sajt �r tillf�lligt nere pga uppdatering av databasen. F�rs�k igen om n�gra minuter. Om sajten �r nere en l�ngre tid, <a href=\"suggest.php\">kontakta sajtens �gare</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM startar fr�n";
		$text['producegedfrom'] = "Skapa GEDCOM-fil fr�n";
		$text['numgens'] = "Antal generationer";
		$text['includelds'] = "Inkludera LDS-information";
		$text['buildged'] = "Generera GEDCOM";
		$text['gedstartfrom'] = "GEDCOM startar fr�n";
		$text['nomaxgen'] = "Du m�ste ange maximum antal generationer. Anv�nd bak�tknappen f�r att �terv�nda till f�reg�ende sida och korrigera felet";
		$text['gedcreatedfrom'] = "GEDCOM skapad fr�n";
		$text['gedcreatedfor'] = "skapad f�r";

		$text['enteremail'] = "Skriv in en giltig e-postadress.";
		$text['creategedfor'] = "Skapa GEDCOM";
		$text['email'] = "E-postadress";
		$text['suggestchange'] = "F�resl� f�r�ndring";
		$text['yourname'] = "Ditt namn";
		$text['comments'] = "Anteckningar och kommentarer";
		$text['comments2'] = "Kommentarer";
		$text['submitsugg'] = "Skicka f�rslaget";
		$text['proposed'] = "F�reslagen f�r�ndring";
		$text['mailsent'] = "Tack. Ditt meddelande har skickats.";
		$text['mailnotsent'] = "Vi beklagar att ditt meddelande inte kunnat skickats. Kontakta xxx direkt p� yyy.";
		$text['mailme'] = "Skicka en kopia till denna adress";
		//added in 5.0.5
		$text['entername'] = "Skriv in ditt namn";
		$text['entercomments'] = "Skriv in dina kommentarer";
		$text['sendmsg'] = "S�nd meddelandet";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Foton & text-dokument f�r";
		$text['indinfofor'] = "Individuell information f�r";
		$text['reliability'] = "Tillf�rlitlighet";
		$text['pp'] = "sid.";
		$text['age'] = "�lder";
		$text['agency'] = "Firma";
		$text['cause'] = "Orsak";
		$text['suggested'] = "F�reslagen";
		$text['closewindow'] = "St�ng detta f�nster";
		$text['thanks'] = "Tack";
		$text['received'] = "Ditt f�rslag har skickats till sajtens administrat�r f�r behandling.";
		//added in 6.0.0
		$text['association'] = "Organisation";
		//added in 7.0.0
		$text['indreport'] = "Individrapport";
		$text['indreportfor'] = "Individrapport f�r";
		$text['general'] = "Allm�nt";
		$text['labels'] = "M�rken";
		$text['bkmkvis'] = "<strong>OBS:</strong> Dessa bokm�rken syns bara p� denna dator och i denna webl�sare.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Sl�ktskapsber�kning";
		$text['findrel'] = "Ber�kna sl�ktskap";
		$text['person1'] = "Person 1:";
		$text['person2'] = "Person 2:";
		$text['calculate'] = "Ber�kna";
		$text['select2inds'] = "V�lj tv� individer.";
		$text['findpersonid'] = "S�k person-ID";
		$text['enternamepart'] = "mata in del av f�r- och/eller efternamn";
		$text['pleasenamepart'] = "Mata in en del av ett f�r- eller efternamn.";
		$text['clicktoselect'] = "klicka f�r val";
		$text['nobirthinfo'] = "Ingen f�delseinformation";
		$text['relateto'] = "Sl�ktskap med";
		$text['sameperson'] = "De tv� individerna �r en och samma person.";
		$text['notrelated'] = "De tv� individerna �r inte besl�ktade inom de xxx n�rmaste generationerna.";
		$text['findrelinstr'] = "Skriv in ID f�r tv� individer, eller beh�ll de visade personerna, klicka sedan p� 'Ber�kna' f�r att visa deras sl�ktskap.";
		$text['gencheck'] = "Max generationer<br />att kontrollera";
		$text['sometimes'] = "(Ibland f�r man olika resultat om man s�ker �ver olika antal generationer.)";
		$text['findanother'] = "Hitta ett annat sl�kskap";
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
		$text['removed'] = "g�nger borttagna";
		$text['rhusband'] = "make till ";
		$text['rwife'] = "maka till ";
		$text['rspouse'] = "make/make till ";
		$text['son'] = "son till";
		$text['daughter'] = "dotter till";
		$text['rchild'] = "barn till";
		$text['sil'] = "sv�rson till";
		$text['dil'] = "sv�rdotter till";
		$text['sdil'] = "sv�rson/-dotter till";
		$text['gson'] = "xxx son (eng. grandson) till";
		$text['gdau'] = "xxx dotter (eng. granddaughter) till";
		$text['gsondau'] = "xxx son/dotter (eng. grandson/granddaughter) till";
		$text['great'] = "far/mor (eng. great)";
		$text['spouses'] = "�r makar";
		$text['is'] = "�r";
		//changed in 6.0.0
		$text['changeto'] = "�ndra till:";
		//added in 6.0.0
		$text['notvalid'] = "�r inte ett giltigt person-ID eller finns inte i denna databas. F�rs�k igen!";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Familje�versikt f�r";
		$text['ldsords'] = "LDS f�rr�ttningar";
		$text['baptizedlds'] = "D�pt (LDS)";
		$text['endowedlds'] = "Beg�vad (LDS)";
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
		$text['scrollnote'] = "OBS! Du m�ste kanske bl�ddra ned�t eller till h�ger f�r att se diagrammet.";
		$text['unknownlit'] = "Ok�nd";
		$text['popupnote1'] = " = Ytterligare information";
		$text['popupnote2'] = " = Ny antavla";
		$text['pedcompact'] = "Kompakt";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Endast text";
		$text['descendfor'] = "�ttlingar till";
		$text['maxof'] = "Maximum";
		$text['gensatonce'] = "generationer visas samtidigt.";
		$text['sonof'] = "son till";
		$text['daughterof'] = "dotter till";
		$text['childof'] = "barn till";
		$text['stdformat'] = "Standardformat";

		$text['ahnentafel'] = "Listad antavla";
		$text['addnewfam'] = "L�gg till familj";
		$text['editfam'] = "Redigera familj";
		$text['side'] = "-sidan";
		$text['familyof'] = "Sl�kt till";
		$text['paternal'] = "P� f�dernet";
		$text['maternal'] = "P� m�dernet";
		$text['gen1'] = "Sj�lv";
		$text['gen2'] = "F�r�ldrar";
		$text['gen3'] = "Far/morf�r�ldrar";
		$text['gen4'] = "4:e generationen";
		$text['gen5'] = "5:e generationen";
		$text['gen6'] = "6:e generationen";
		$text['gen7'] = "7:e generationen";
		$text['gen8'] = "8:e generationen";
		$text['gen9'] = "9:e generationen";
		$text['gen10'] = "10:e generationen";
		$text['gen11'] = "11:e generationen";
		$text['gen12'] = "12:e generationen";
		$text['graphdesc'] = "Grafiskt �ttlingaverk till denna punkt";
		$text['collapse'] = "Komprimera";
		$text['expand'] = "Expandera";
		$text['pedbox'] = "Ruta";
		//changed in 6.0.0
		$text['regformat'] = "Registerformat";
		$text['extrasexpl'] = "Om foton eller dokument finns f�r f�ljande personer visas motsvarande symboler intill namnen.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nytt diagram";
		$text['mediaavail'] = "Media finns";
		//changed in 7.0.0
		$text['pedigreefor'] = "Antavla f�r";
		//added in 7.0.0
		$text['pedigreech'] = "Antavla";
		$text['datesloc'] = "Datum och Platser";
		$text['borchr'] = "F�delse/Dop - D�d/Begravning (tv�)";
		$text['nobd'] = "Inga f�delse- eller d�dsdatum";
		$text['bcdb'] = "F�delse/Dop/D�d/Begravning (fyra)";
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
		$text['reportsyntax'] = "Denna rapports s�k-syntax";
		$text['wasincorrect'] = "var ej korrekt, och rapporten kunde d�rf�r inte skapas. Kontakta systemadministrat�ren p�";
		$text['query'] = "S�k";
		$text['errormessage'] = "Felmeddelande";
		$text['equals'] = "lika med";
		$text['contains'] = "inneh�ller";
		$text['startswith'] = "b�rjar med";
		$text['endswith'] = "slutar med";
		$text['soundexof'] = "soundex av";
		$text['metaphoneof'] = "metaphone av";
		$text['plusminus10'] = "�10 �r fr�n";
		$text['lessthan'] = "mindre �n";
		$text['greaterthan'] = "st�rre �n";
		$text['lessthanequal'] = "mindre �n eller lika med";
		$text['greaterthanequal'] = "st�rre �n eller lika med";
		$text['equalto'] = "lika med";
		$text['tryagain'] = "F�rs�k igen";
		$text['text_for'] = "f�r";
		$text['searchnames'] = "S�k namn";
		$text['joinwith'] = "Sammanfoga med";
		$text['cap_and'] = "OCH";
		$text['cap_or'] = "ELLER";
		$text['showspouse'] = "Visa make/maka (visar flera om individen har mer �n en make/maka)";
		$text['submitquery'] = "S�k";
		$text['birthplace'] = "F�delseort";
		$text['deathplace'] = "D�dsort";
		$text['birthdatetr'] = "F�delse�r";
		$text['deathdatetr'] = "D�ds�r";
		$text['plusminus2'] = "�2 �r fr�n";
		$text['resetall'] = "�terst�ll alla v�rden";

		$text['showdeath'] = "Visa information om d�d/begravning";
		$text['altbirthplace'] = "Dopplats";
		$text['altbirthdatetr'] = "Dop�r";
		$text['burialplace'] = "Begravningsplats";
		$text['burialdatetr'] = "Begravnings�r";
		$text['event'] = "H�ndelse(r)";
		$text['day'] = "Dag";
		$text['month'] = "M�nad";
		$text['keyword'] = "Nyckelord (t ex \"CA\")";
		$text['explain'] = "Skriv in datumf�lt f�r att se motsvarande h�ndelser. L�mna f�ltet tomt f�r att se alla h�ndelser.";
		$text['enterdate'] = "Skriv in eller v�lj minst en av f�ljande: Dag, M�nad, �r, Nyckelord";
		$text['fullname'] = "Fullst�ndigt namn";
		$text['birthdate'] = "F�delsedatum";
		$text['altbirthdate'] = "Dopdatum";
		$text['marrdate'] = "�ktenskapsdatum";
		$text['spouseid'] = "Make/maka ID";
		$text['spousename'] = "Makes/makas namn";
		$text['deathdate'] = "D�dsdatum";
		$text['burialdate'] = "Begravningsdatum";
		$text['changedate'] = "Senast �ndrad, datum";
		$text['gedcom'] = "Tr�d";
		$text['baptdate'] = "Dopdatum (LDS)";
		$text['baptplace'] = "Dopplats (LDS)";
		$text['endldate'] = "Beg�vningsdatum (LDS)";
		$text['endlplace'] = "Beg�vningsplats (LDS)";
		$text['ssealdate'] = "Beseglingsdatum S (LDS)";
		$text['ssealplace'] = "Beseglingsplats S (LDS)";
		$text['psealdate'] = "Beseglingsdateum P (LDS)";
		$text['psealplace'] = "Beseglingsplats P (LDS)";
		$text['marrplace'] = "Vigselort";
		$text['spousesurname'] = "Makes/makas efternamn";
		//changed in 6.0.0
		$text['spousemore'] = "Om du skriver in makes/makas efternamn, s� m�ste du fylla i ytterligare minst ett f�lt.";
		//added in 6.0.0
		$text['plusminus5'] = "�5 �r fr�n";
		$text['exists'] = "finns";
		$text['dnexist'] = "finns inte";
		//added in 6.0.3
		$text['divdate'] = "Skilsm�ssodatum";
		$text['divplace'] = "Skilsm�ssoplats";
		//changed in 7.0.0
		$text['otherevents'] = "Andra h�ndelser";
		//added in 7.0.0
		$text['numresults'] = "Resultat per sida";
		$text['mysphoto'] = "G�tfulla foton";
		$text['mysperson'] = "Sv�rf�ngade personer";
		$text['joinor'] = "Alternativet 'Sammanfoga med ELLER' kan inte anv�ndas med makes/makas efternamn";
		//added in 7.0.1
		$text['tellus'] = "Ber�tta vad du vet";
		$text['moreinfo'] = "Mera information:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Logg-fil f�r";
		$text['mostrecentactions'] = "Senaste �tg�rder";
		$text['autorefresh'] = "Auto-uppdatering (30 sekunder)";
		$text['refreshoff'] = "St�ng av Auto-uppdatering";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Gravplatser och -stenar";
		$text['showallhsr'] = "Visa alla gravstenar";
		$text['in'] = "i";
		$text['showmap'] = "Visa karta";
		$text['headstonefor'] = "Gravsten f�r";
		$text['photoof'] = "Foto av";
		$text['firstpage'] = "F�rsta sidan";
		$text['lastpage'] = "Sista sidan";
		$text['photoowner'] = "�gare/K�lla";

		$text['nocemetery'] = "Ingen begravningsplats";
		$text['iptc005'] = "Titel";
		$text['iptc020'] = "Till�ggskategorier";
		$text['iptc040'] = "Specialinstruktioner";
		$text['iptc055'] = "Skapat";
		$text['iptc080'] = "F�rfattare";
		$text['iptc085'] = "F�rfattarens position";
		$text['iptc090'] = "Stad";
		$text['iptc095'] = "Stat";
		$text['iptc101'] = "Land";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Rubrik";
		$text['iptc110'] = "K�lla";
		$text['iptc115'] = "Fotografiets k�lla";
		$text['iptc116'] = "Upphovsmannar�tten";
		$text['iptc120'] = "Bildtext";
		$text['iptc122'] = "Biltextens f�rfattare";
		$text['mapof'] = "Karta �ver";
		$text['regphotos'] = "Beskrivande �versikt";
		$text['gallery'] = "Endast frim�rksbilder";
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
		$text['slideresume'] = "�teruppta Bildspel";
		$text['slidesecs'] = "Sekunder per bild:";
		$text['minussecs'] = "minus 0.5 sekunder";
		$text['plussecs'] = "plus 0.5 sekunder";
		//added in 7.0.0
		$text['nocountry'] = "Ok�nt land";
		$text['nostate'] = "Ok�nd stat";
		$text['nocounty'] = "Ok�nt l�n";
		$text['nocity'] = "Ok�nd stad";
		$text['nocemname'] = "Ok�nd begravningsplats";
		$text['plot'] = "Plotta";
		$text['location'] = "Plats";
		$text['editalbum'] = "Redigera Album";
		$text['mediamaptext'] = "<strong>OBS:</strong> Flytta muspekaren �ver bilden f�r att visa namn. Klicka f�r att se en sida f�r varje namn.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Visa efternamn som b�rjar med";
		$text['showtop'] = "Visa de f�rsta";
		$text['showallsurnames'] = "Visa alla efternamn";
		$text['sortedalpha'] = "sorterade alfabetiskt";
		$text['byoccurrence'] = "sorterade efter f�rekomst";
		$text['firstchars'] = "F�rsta bokstav";
		$text['top'] = "De vanligaste";
		$text['mainsurnamepage'] = "Huvudsida f�r efternamn";
		$text['allsurnames'] = "Alla efternamn";
		$text['showmatchingsurnames'] = "Klicka p� ett efternamn f�r att visa motsvarande poster.";
		$text['backtotop'] = "Tillbaka till b�rjan";
		$text['beginswith'] = "B�rjar med";
		$text['allbeginningwith'] = "Alla efternamn som b�rjar med";
		$text['numoccurrences'] = "Antal f�rekomster inom parentes";
		$text['placesstarting'] = "Visa platser som b�rjar p�";
		$text['showmatchingplaces'] = "Klicka p� ett ortnamn f�r att visa mindre orter. Klicka p� s�ksymbolen f�r att visa matchande personer.";
		$text['totalnames'] = "alla individer";
		$text['showallplaces'] = "Visa alla st�rsta platser";
		$text['totalplaces'] = "alla platser";
		$text['mainplacepage'] = "Huvudsida f�r platser";
		$text['allplaces'] = "Alla st�rsta platser";
		$text['placescont'] = "Visa alla platser som inneh�ller";
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
		$text['addperson'] = "L�gg till person";
		$text['nobirth'] = "F�ljande individ har inte korrekt f�delsedatum och kunde inte l�ggas till";
		$text['noliving'] = "F�ljande individer �r m�rkta s�som levande och kunde inte l�ggas till p.g.a. att du inte �r inloggad med tillr�ckliga r�ttigheter";
		$text['event'] = "H�ndelse(r)";
		$text['chartwidth'] = "Diagrambredd";
		//changed in 6.0.0
		$text['timelineinstr'] = "L�gg till ytterligare upp till fyra individer genom att mata in deras ID:";
		//added in 6.0.0
		$text['togglelines'] = "Visa/d�lj linjer";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Bl�ddra i tr�d";
		$text['treename'] = "Tr�dets namn";
		$text['owner'] = "�gare";
		$text['address'] = "Adress";
		$text['city'] = "Ort";
		$text['state'] = "L�n/Provins/Delstat";
		$text['zip'] = "Postnummer";
		$text['country'] = "Land";
		$text['email'] = "E-postadress";
		$text['phone'] = "Telefon";
		$text['username'] = "Anv�ndarnamn";
		$text['password'] = "L�senord";
		$text['loginfailed'] = "Inloggningen misslyckades.";

		$text['regnewacct'] = "Registrera anv�ndarkonto";
		$text['realname'] = "Ditt verkliga namn";
		$text['phone'] = "Telefon";
		$text['email'] = "E-postadress";
		$text['address'] = "Adress";
		$text['comments'] = "Anteckningar och kommentarer";
		$text['submit'] = "S�nd bidrag";
		$text['leaveblank'] = "(l�mna tomt om du �nskar en ny tr�dstruktur)";
		$text['required'] = "Obligatoriska f�lt";
		$text['enterpassword'] = "skriv in ett l�senord.";
		$text['enterusername'] = "Skriv in ett anv�ndarnamn.";
		$text['failure'] = "Tyv�rr �r anv�ndarnamnet i bruk. Anv�nd bak�t-knappen i din bl�ddrare och v�lj ett annat anv�ndarnamn.";
		$text['success'] = "Tack! Vi har emottagit din registrering. Vi kontaktar dig n�r kontot �r aktivt eller om ytterligare information beh�vs.";
		$text['emailsubject'] = "Ny TNG anv�ndarregistrering";
		$text['emailmsg'] = "Du har f�tt en beg�ran om ett nytt TNG konto. Logga in p� ditt TNG admin-omr�de f�r att ge r�tta befogengenheter f�r kontot. Om du godk�nner registreringen, meddela personen i fr�ga genom att svara p� denna e-post.";
		//changed in 5.0.0
		$text['enteremail'] = "Skriv in en giltig e-postadress.";
		$text['website'] = "Websajt";
		$text['nologin'] = "Har du ingen inlogging?";
		$text['loginsent'] = "Inloggningsinformationen har skickats";
		$text['loginnotsent'] = "Inloggningsinformationen har inte skickats";
		$text['enterrealname'] = "Skriv in ditt namn.";
		$text['rempass'] = "F�rbli inloggad p� denna dator";
		$text['morestats'] = "Mera statistik";
		//added in 6.0.0
		$text['accmail'] = "<strong>OBS:</strong> F�r att f� e-post fr�n administrat�ren ang�ende ditt konto, se till att du inte blockerar e-post fr�n denna dom�n!";
		$text['newpassword'] = "Nytt l�senord";
		$text['resetpass'] = "�terst�ll ditt l�senord";
		//added in 6.1.0
		$text['nousers'] = "Detta formul�r kan inte anv�ndas f�rr�n minst en anv�ndarregistrering gjorts. Om Du �ger denna sajt, g� till Admin/Anv�ndare och skapa Administrator-konto.";
		//added in 7.0.0
		$text['noregs'] = "Vi tar f�r tillf�llet inte emot nya anv�ndarregistreringar. <a href=\"suggest.php\">Kontakta oss</a> direkt om du har kommentarer eller fr�gor om n�got p� denna sajt.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Kvantitet";
		$text['totindividuals'] = "Totalt antal individer";
		$text['totmales'] = "- varav manliga";
		$text['totfemales'] = "- varav kvinnliga";
		$text['totunknown'] = "- varav av ok�nt k�n";
		$text['totliving'] = "- varav levande";
		$text['totfamilies'] = "Antal familjer";
		$text['totuniquesn'] = "Antal unika efternamn";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Totalt antal k�llor";
		$text['avglifespan'] = "Medellivsl�ngd";
		$text['earliestbirth'] = "Tidigaste f�dsel";
		$text['longestlived'] = "St�rsta livsl�ngd";
		$text['years'] = "�r";
		$text['days'] = "dagar";
		$text['age'] = "�lder";
		$text['agedisclaimer'] = "�ldersber�kningarna baserar sig p� individer med registrerade f�delse- <EM>och</EM> d�dsdatum. P.g.a att det kan finnas ofullst�ndiga datumf�lt (t ex enbart \"1945\" eller \"BEF 1860\"), �r dessa ber�kingar inte helt tillf�rlitliga.";
		$text['treedetail'] = "Mera information om detta tr�d";
		//added in 6.0.0
		$text['total'] = "Totalt antal";
		break;

	case "notes":
		$text['browseallnotes'] = "Bl�ddra i alla Noteringar";
		break;

	case "help":
		$text['menuhelp'] = "Meny";
		break;

	case "install":
		$text['perms'] = "Alla r�ttigheter �r definierade.";
		$text['noperms'] = "R�ttigheter kunde inte definieras f�r f�ljande filer:";
		$text['manual'] = "St�ll in dem manuellt!";
		$text['folder'] = "Mapp";
		$text['created'] = "har skapats";
		$text['nocreate'] = "kunde inte skapas. Skapa den manuellt!";
		$text['infosaved'] = "Informationen sparad, kopplingen verifierad!";
		$text['tablescr'] = "Tabellerna har skapats!";
		$text['notables'] = "F�ljande tabeller kunde inte skapas:";
		$text['nocomm'] = "TNG kommunicerar inte med databasen. Inga tabeller skapades.";
		$text['newdb'] = "Informationen sparad, kopplingen verifierad, ny databas skapad:";
		$text['noattach'] = "Informationen sparad. Koppling gjord och databas skapad, men TNG kan inte ansluta till den.";
		$text['nodb'] = "Informationen sparad. Koppling gjord, men databasen existerar inte och kunde inte skapas h�r. Verifiera att databasnamnet �r korrekt eller anv�nd din kontrollpanel f�r att skapa den.";
		$text['noconn'] = "Informationen sparad men kopplingen misslyckades. Ett eller flera av f�ljande �r fel:";
		$text['exists'] = "finns";
		$text['loginfirst'] = "Du m�ste f�rst logga in.";
		$text['noop'] = "Ingen �tg�rd har utf�rts.";
		break;
}

//common
$text['matches'] = "Tr�ffar";
$text['description'] = "Beskrivning";
$text['notes'] = "Noteringar";
$text['status'] = "Status";
$text['newsearch'] = "Ny s�kning";
$text['pedigree'] = "Antavla";
$text['birthabbr'] = "f.";
$text['chrabbr'] = "dp.";
$text['seephoto'] = "Se foto";
$text['andlocation'] = "& placering";
$text['accessedby'] = "l�st av";
$text['go'] = "Visa";
$text['family'] = "Familj";
$text['children'] = "Barn";
$text['tree'] = "Tr�d";
$text['alltrees'] = "Alla tr�d";
$text['nosurname'] = "[Inget efternamn]";
$text['thumb'] = "Frim�rke";
$text['people'] = "M�nniskor";
$text['title'] = "Titel";
$text['suffix'] = "Suffix";
$text['nickname'] = "Smeknamn";
$text['deathabbr'] = "d.";
$text['lastmodified'] = "Senast �ndrad";
$text['married'] = "Gift";
//$text['photos'] = "Photos";
$text['name'] = "Namn";
$text['lastfirst'] = "Efternamn, f�rnamn";
$text['bornchr'] = "F�dd/D�pt";
$text['individuals'] = "Individer";
$text['families'] = "Familjer";
$text['personid'] = "Person-ID";
$text['sources'] = "K�llor";
$text['unknown'] = "Ok�nd";
$text['father'] = "Far";
$text['mother'] = "Mor";
$text['born'] = "F�dd";
$text['christened'] = "D�pt";
$text['died'] = "D�d";
$text['buried'] = "Begraven";
$text['spouse'] = "Make/Maka";
$text['parents'] = "F�r�ldrar";
$text['text'] = "Text";
$text['language'] = "Spr�k";
$text['burialabbr'] = "bg.";
$text['descendchart'] = "�ttlingar";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Individ";
$text['edit'] = "Redigera";
$text['date'] = "Datum";
$text['place'] = "Plats";
$text['login'] = "Logga in";
$text['logout'] = "Logga ut";
$text['marrabbr'] = "v.";
$text['groupsheet'] = "Familje�versikt";
$text['text_and'] = "och";
$text['generation'] = "Generation";
$text['filename'] = "Filnamn";
$text['id'] = "ID";
$text['search'] = "S�k";
$text['living'] = "Levande";
$text['user'] = "Anv�ndare";
$text['firstname'] = "F�rnamn";
$text['lastname'] = "Efternamn";
$text['searchresults'] = "S�kresultat";
$text['diedburied'] = "D�d/Begraven";
$text['homepage'] = "Hem";
$text['find'] = "S�k...";
$text['relationship'] = "Sl�ktskap";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Tidslinje";
$text['yesabbr'] = "J";
$text['divorced'] = "Skilda";
$text['indlinked'] = "L�nkad till";
$text['branch'] = "Gren";
$text['moreind'] = "Flera individer";
$text['morefam'] = "Flera familjer";
$text['livingdoc'] = "Minst en levande person �r l�nkad till detta foto-dokument - Detaljinformation visas inte.";
$text['source'] = "K�lla";
$text['surnamelist'] = "Efternamnslista";
$text['generations'] = "Generationer";
$text['refresh'] = "Uppdatera";
$text['whatsnew'] = "Nyheter";
$text['reports'] = "Rapporter";
$text['placelist'] = "Platslista";
$text['baptizedlds'] = "D�pt (LDS)";
$text['endowedlds'] = "Beg�vad (LDS)";
$text['sealedplds'] = "Beseglad F (LDS)";
$text['sealedslds'] = "Beseglad M (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Anor";
$text['descendants'] = "�ttlingar";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Senaste GEDCOM import";
$text['type'] = "Typ";
$text['savechanges'] = "Spara �ndringar";
$text['familyid'] = "Familjens ID";
$text['headstone'] = "Gravsten";
$text['historiesdocs'] = "Text-dokument";
$text['livingnote'] = "Minst en levande person �r l�nkad till denna notering - Detaljer visas inte.";
$text['anonymous'] = "anonym";
$text['places'] = "Platser";
$text['anniversaries'] = "Datum & Bem�rkelsedagar";
$text['administration'] = "Administration";
$text['help'] = "Hj�lp";
//$text['documents'] = "Documents";
$text['year'] = "�r";
$text['all'] = "Alla";
$text['repository'] = "Arkiv";
$text['address'] = "Adress";
$text['suggest'] = "F�resl�";
$text['editevent'] = "F�resl� �ndring av denna h�ndelse";
$text['findplaces'] = "Hitta alla personer med h�ndelser p� denna plats";
$text['morelinks'] = "Flera l�nkar";
$text['faminfo'] = "Familjeinformation";
$text['persinfo'] = "Personlig information";
$text['srcinfo'] = "Information om k�llan";
$text['fact'] = "Fakta";
$text['goto'] = "V�lj en sida";
$text['tngprint'] = "Skriv ut";
//changed in 6.0.0
$text['livingphoto'] = "Minst en levande person �r l�nkad till denna bild - Detaljinformation visas inte.";
$text['databasestatistics'] = "Databasstatistik";
//moved here in 6.0.0
$text['child'] = "Barn";
$text['repoinfo'] = "Arkivinformation";
$text['tng_reset'] = "�terst�ll";
$text['noresults'] = "Inget resultat";
//added in 6.0.0
$text['allmedia'] = "Alla Media";
$text['repositories'] = "Arkiv";
$text['albums'] = "Album";
$text['cemeteries'] = "Gravplatser";
$text['surnames'] = "Efternamn";
$text['dates'] = "Datum";
$text['link'] = "L�nk";
$text['media'] = "Media";
$text['gender'] = "K�n";
$text['latitude'] = "Latitud";
$text['longitude'] = "Longitud";
$text['bookmarks'] = "Bokm�rken";
$text['bookmark'] = "L�gg till Bokm�rke";
$text['mngbookmarks'] = "G� till Bokm�rken";
$text['bookmarked'] = "Bokm�rke tillagt";
$text['remove'] = "Ta bort";
$text['find_menu'] = "Hitta";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Gravplats";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "H�ndelse-karta";
$text['gevents'] = "H�ndelse";
$text['glang'] = "&amp;hl=sv";
$text['googleearthlink'] = "L�nk till Google Earth";
$text['googlemaplink'] = "L�nk till Google Maps";
$text['gmaplegend'] = "Teckenf�rklaring, m�rken";
//moved here in 7.0.0
$text['unmarked'] = "Omarkerad";
$text['located'] = "Lokaliserad";
//added in 7.0.0
$text['albclicksee'] = "Klicka f�r att se alla poster i detta album.";
$text['notyetlocated'] = "Ej lokaliserad �nnu";
$text['cremated'] = "Kremerad";
$text['missing'] = "Saknad";
$text['page'] = "Sida";
$text['pdfgen'] = "PDF-Generator";
$text['blank'] = "Blankt diagram";
$text['none'] = "Ingen";
$text['fonts'] = "Fonter";
$text['header'] = "Rubrik";
$text['data'] = "Data";
$text['pgsetup'] = "Sidinst�llningar";
$text['pgsize'] = "Sidstorlek";
$text['letter'] = "Letter";
$text['legal'] = "Legal";
$text['orient'] = "Orientering";
$text['portrait'] = "St�ende";
$text['landscape'] = "Liggande";
$text['tmargin'] = "Toppmarginal";
$text['bmargin'] = "Bottenarginal";
$text['lmargin'] = "V�nstermarginal";
$text['rmargin'] = "H�germarginal";
$text['createch'] = "Skapa diagram";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Mest Efters�kt";
$text['latupdates'] = "Senaste uppdateringar";
$text['featphoto'] = "Vinjettfoto"; //???
$text['news'] = "Nyheter";
$text['ourhist'] = "V�r familjehistoria";
$text['ourhistanc'] = "V�r familjehistoria och anor";
$text['ourpages'] = "V�r familjs sl�ktsida";
$text['pwrdby'] = "Denna sajt �r byggd med";
$text['writby'] = "skapad av";
$text['searchtngnet'] = "S�k TNG Network (GENDEX)";
$text['viewphotos'] = "Se alla foton";
$text['anon'] = "Du �r f�r n�rvarande anonym";
$text['whichbranch'] = "Vilken gren kommer du ifr�n?";
$text['featarts'] = "Vinjettartikel";  //???
$text['maintby'] = "Underh�lls av";
$text['createdon'] = "Skapad den";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Hemsida";
$text['mnusearchfornames'] = "S�k namn";
$text['mnulastname'] = "Efternamn";
$text['mnufirstname'] = "F�rnamn";
$text['mnusearch'] = "S�k";
$text['mnureset'] = "Starta om";
$text['mnulogon'] = "Logga in";
$text['mnulogout'] = "Logga ut";
$text['mnufeatures'] = "Andra funktioner";
$text['mnuregister'] = "Ans�k om anv�ndarkonto";
$text['mnuadvancedsearch'] = "Avancerad s�kning";
$text['mnulastnames'] = "Efternamn";
$text['mnustatistics'] = "Statistik";
$text['mnuphotos'] = "Foton";
$text['mnuhistories'] = "Text-dokument";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Gravplatser";
$text['mnutombstones'] = "Gravstenar";
$text['mnureports'] = "Rapporter";
$text['mnusources'] = "K�llor";
$text['mnuwhatsnew'] = "Nyheter";
$text['mnushowlog'] = "G� till Logg";
$text['mnulanguage'] = "Byt spr�k";
$text['mnuadmin'] = "Administration";
$text['welcome'] = "V�lkommen";
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
