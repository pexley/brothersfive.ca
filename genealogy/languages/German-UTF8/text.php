<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Alle Quellen anzeigen";
		$text['shorttitle'] = "Kurztitel";
		$text['callnum'] = "Signatur";
		$text['author'] = "Autor";
		$text['publisher'] = "Veröffentlicht durch";
		$text['other'] = "Zusätzliche Angaben";
		$text['sourceid'] = "Quellen-Kennung";
		$text['moresrc'] = "Weitere Quellen";
		$text['repoid'] = "Aufbewahrungs-Kennung";
		$text['browseallrepos'] = "Alle Aufbewahrungsorte durchblättern";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Neue Sprache";
		$text['changelanguage'] = "Sprache ändern";
		$text['languagesaved'] = "Sprache gespeichert";
		//added in 7.0.0
		$text['sitemaint'] = "Momentan werden auf dieser Website Wartungsarbeiten durchgeführt";
		$text['standby'] = "Diese Website ist zeitweilig nicht verfügbar, da eine Datenbank-Aktualisierung läuft. Bitte versuchen Sie es in einigen Minuten nochmals. Falls diese Website für längere Zeit nicht verfügbar bleibt, so <a href=\"suggest.php\">wenden Sie sich bitte an den Administrator</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM-Datei startet bei";
		$text['producegedfrom'] = "GEDCOM-Datei erzeugen ab";
		$text['numgens'] = "Anzahl Generationen";
		$text['includelds'] = "einschließlich LDS-Angaben";
		$text['buildged'] = "Erzeuge GEDCOM-Datei";
		$text['gedstartfrom'] = "GEDCOM-Datei beginnt mit";
		$text['nomaxgen'] = "Sie müssen die maximale Zahl der Generationen angeben. Bitte mit 'Zurück' zur vorangehenden Seite und den Fehler beheben";
		$text['gedcreatedfrom'] = "GEDCOM-Datei erstellt ab";
		$text['gedcreatedfor'] = "Erstellt für";

		$text['enteremail'] = "Bitte eine gültige E-Mail-Adresse eingeben.";
		$text['creategedfor'] = "GEDCOM-Datei erzeugen";
		$text['email'] = "E-Mail";
		$text['suggestchange'] = "Änderungsvorschlag für";
		$text['yourname'] = "Ihr Name";
		$text['comments'] = "Notiz oder Kommentar";
		$text['comments2'] = "Ihre Mitteilung";
		$text['submitsugg'] = "Absenden";
		$text['proposed'] = "Vorgeschlagene Änderung";
		$text['mailsent'] = "Ihre Mitteilung wurde abgeschickt. Vielen Dank.";
		$text['mailnotsent'] = "Ihre Mitteilung konnte nicht gesendet werden. Bitte wenden Sie sich an xxx (E-Mail: yyy).";
		$text['mailme'] = "Kopie an diese Adresse senden";
		//added in 5.0.5
		$text['entername'] = "Bitte geben Sie Ihren Namen ein";
		$text['entercomments'] = "Bitte geben Sie Ihre Mitteilung ein";
		$text['sendmsg'] = "Nachricht absenden";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotos und Texte von";
		$text['indinfofor'] = "Individuelle Angaben über";
		$text['reliability'] = "Verläßlichkeit";
		$text['pp'] = "S.";
		$text['age'] = "Alter";
		$text['agency'] = "Stelle";
		$text['cause'] = "Ursache";
		$text['suggested'] = "Vorgeschlagene Änderung";
		$text['closewindow'] = "Fenster schließen";
		$text['thanks'] = "Vielen Dank";
		$text['received'] = "Ihre Anmerkung wurde zur Überprüfung an den Verwalter dieser Website gesendet.";
		//added in 6.0.0
		$text['association'] = "Verbindung";
		//added in 7.0.0
		$text['indreport'] = "Personen-Datenblatt";
		$text['indreportfor'] = "Personen-Datenblatt für";
		$text['general'] = "Allgemein";
		$text['labels'] = "Beschriftungen";
		$text['bkmkvis'] = "<strong>Hinweis:</strong> Diese Lesezeichen sind nur auf diesem Rechner und nur mit diesem Browser sichtbar.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Verwandtschaftsrechner";
		$text['findrel'] = "Verwandschaftsbeziehung darstellen";
		$text['person1'] = "Person 1:";
		$text['person2'] = "Person 2:";
		$text['calculate'] = "Berechnen";
		$text['select2inds'] = "Bitte zwei Personen wählen.";
		$text['findpersonid'] = "Suche Personen-Kennung";
		$text['enternamepart'] = "Tragen Sie einen Teil des Vor- oder Nachnamens ein";
		$text['pleasenamepart'] = "Bitte tragen Sie einen Teil des Vor- oder Nachnamens ein.";
		$text['clicktoselect'] = "Klicken Sie einen Eintrag an, um ihn auszuwählen";
		$text['nobirthinfo'] = "Keine Geburts-Angaben";
		$text['relateto'] = "Verwandtschaftsbeziehung mit";
		$text['sameperson'] = "Die zwei Personen sind identisch.";
		$text['notrelated'] = "Die zwei Personen sind nicht innerhalb von xxx Generationen verwandt.";
		$text['findrelinstr'] = "Personen-Kennungen eingeben (oder angezeigte belassen), dann auf 'Berechnen' klicken, um die Verwandtschaftsbeziehung darzustellen.";
		$text['gencheck'] = "Maximale Anzahl der<br />zu berücksichtigenden Generationen";
		$text['sometimes'] = " (Eine unterschiedliche Anzahl der zu berücksichtigenden Generationen kann manchmal zu unterschiedlichen Ergebnissen führen.)";
		$text['findanother'] = "Eine andere Verwandtschaftsbeziehung suchen";
		//added in 6.0.0
		$text['brother'] = "der Bruder von";
		$text['sister'] = "die Schwester von";
		$text['sibling'] = "der Bruder/die Schwester von";
		$text['uncle'] = "der xxx Onkel von";
		$text['aunt'] = "die xxx Tante von";
		$text['uncleaunt'] = "der xxx Onkel/die xxx Tante von";
		$text['nephew'] = "der xxx Neffe von";
		$text['niece'] = "die xxx Nichte von";
		$text['nephnc'] = "der xxx Neffe/die xxx Nichte von";
		$text['mcousin'] = "der xxx Cousin (Vetter) von";
		$text['fcousin'] = "die xxx Cousine (Base) von";
		$text['cousin'] = "der xxx Cousin (Vetter)/die xxx Cousine (Base) von";
		$text['removed'] = "fach entfernt";
		$text['rhusband'] = "der Ehemann von ";
		$text['rwife'] = "die Ehefrau von ";
		$text['rspouse'] = "der Ehemann/die Ehefrau von ";
		$text['son'] = "der Sohn von";
		$text['daughter'] = "die Tochter von";
		$text['rchild'] = "das Kind von";
		$text['sil'] = "der Schwiegersohn von";
		$text['dil'] = "die Schwiegertochter von";
		$text['sdil'] = "der Schwiegersohn/die Schwiegertochter von";
		$text['gson'] = "der xxx Enkel von";
		$text['gdau'] = "die xxx Enkelin von";
		$text['gsondau'] = "der xxx Enkel/die xxx Enkelin von";
		$text['great'] = "Groß-";
		$text['spouses'] = "sind Ehepartner";
		$text['is'] = "ist";
		//changed in 6.0.0
		$text['changeto'] = "Ändere zu:";
		//added in 6.0.0
		$text['notvalid'] = "ist keine gültige Personen-Kennung oder existiert nicht in dieser Datenbank. Bitte nochmals versuchen.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Familienblatt von";
		$text['ldsords'] = "LDS Anordnungen";
		$text['baptizedlds'] = "Getauft (LDS)";
		$text['endowedlds'] = "Begabung (LDS)";
		$text['sealedplds'] = "Siegelung an die Eltern (LDS)";
		$text['sealedslds'] = "Siegelung an den Ehepartner (LDS)";
		$text['otherspouse'] = "Andere Ehepartner";
		//changed in 7.0.0
		$text['husband'] = "Vater";
		$text['wife'] = "Mutter";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "geb.";
		$text['capaltbirthabbr'] = "in";
		$text['capdeathabbr'] = "gest.";
		$text['capburialabbr'] = "begr.";
		$text['capplaceabbr'] = "in";
		$text['capmarrabbr'] = "verh.";
		$text['capspouseabbr'] = "Gatt.";
		$text['redraw'] = "Neu zeichnen mit";
		$text['scrollnote'] = "Hinweis: Evtl. müssen Sie nach unten oder nach rechts scrollen, um alles zu sehen können.";
		$text['unknownlit'] = "Unbekannt";
		$text['popupnote1'] = " = Zusatz-Angaben";
		$text['popupnote2'] = " = neuen Stammbaum zeigen";
		$text['pedcompact'] = "Kompakt";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Nur Text";
		$text['descendfor'] = "Nachkommen von";
		$text['maxof'] = "Maximum";
		$text['gensatonce'] = "Generationen gleichzeitig anzeigen.";
		$text['sonof'] = "Sohn von";
		$text['daughterof'] = "Tochter von";
		$text['childof'] = "Kind von";
		$text['stdformat'] = "Standardformat";

		$text['ahnentafel'] = "Ahnenliste";
		$text['addnewfam'] = "Neue Familie anlegen";
		$text['editfam'] = "Familie bearbeiten";
		$text['side'] = "-Seite";
		$text['familyof'] = "Familie von";
		$text['paternal'] = "Väterlicherseits";
		$text['maternal'] = "Mütterlichseits";
		$text['gen1'] = "Selbst";
		$text['gen2'] = "Eltern";
		$text['gen3'] = "Großeltern (4)";
		$text['gen4'] = "Urgroßeltern (8)";
		$text['gen5'] = "Alteltern (16)";
		$text['gen6'] = "Altgroßeltern (32)";
		$text['gen7'] = "Alturgroßeltern (64)";
		$text['gen8'] = "Obereltern (128)";
		$text['gen9'] = "Obergroßeltern (256)";
		$text['gen10'] = "Oberurgroßeltern (512)";
		$text['gen11'] = "Stammeltern (1024)";
		$text['gen12'] = "Stammgroßeltern (2048)";
		$text['graphdesc'] = "Graphische Anzeige der Nachkommen";
		$text['collapse'] = "Darstellung reduzieren";
		$text['expand'] = "Darstellung erweitern";
		$text['pedbox'] = "Rahmen";
		//changed in 6.0.0
		$text['regformat'] = "Registerformat";
		$text['extrasexpl'] = "Falls für die folgenden Personen Fotos oder Texte vorhanden sind, werden die entsprechenden Vorschaubilder bei den Namen angezeigt.";
		//added in 6.0.0
		$text['popupnote3'] = " = Neues Diagramm";
		$text['mediaavail'] = "Medien verfügbar";
		//changed in 7.0.0
		$text['pedigreefor'] = "Ahnentafel für";
		//added in 7.0.0
		$text['pedigreech'] = "Ahnentafel";
		$text['datesloc'] = "Daten und Orte";
		$text['borchr'] = "Geburt/Taufe - Tod/Beerdigung (zwei)";
		$text['nobd'] = "Keine Angaben zu Geburt oder Tod";
		$text['bcdb'] = "Geburt/Taufe/Tod/Beerdigung (vier)";
		$text['numsys'] = "Numerierungs-System";
		$text['gennums'] = "Generations-Nummern";
		$text['henrynums'] = "Numerierung nach Henry";
		$text['abovnums'] = "Numerierung nach d'Aboville";
		$text['devnums'] = "Numerierung nach de Villiers";
		$text['dispopts'] = "Anzeige-Optionen";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "Es sind keine Auswertungen vorhanden.";
		$text['reportname'] = "Name der Auswertung";
		$text['allreports'] = "Alle Auswertungen";
		$text['report'] = "Auswertung";
		$text['error'] = "Fehler";
		$text['reportsyntax'] = "Die Syntax der Suchabfrage für diese Auswertung";
		$text['wasincorrect'] = "ist ungültig, deswegen kann die Auswertung nicht erstellt werden. Benachrichtigen Sie den Systemverantwortlichen";
		$text['query'] = "Suchabfrage";
		$text['errormessage'] = "Fehlermeldung";
		$text['equals'] = "ist gleich";
		$text['contains'] = "enthält";
		$text['startswith'] = "beginnt mit";
		$text['endswith'] = "endet auf";
		$text['soundexof'] = "soundex von";
		$text['metaphoneof'] = "metafon von";
		$text['plusminus10'] = "+/- 10 Jahre von";
		$text['lessthan'] = "kleiner als";
		$text['greaterthan'] = "größer als";
		$text['lessthanequal'] = "kleiner oder gleich";
		$text['greaterthanequal'] = "größer oder gleich";
		$text['equalto'] = "ist gleich";
		$text['tryagain'] = "Bitte erneut versuchen";
		$text['text_for'] = "für";
		$text['searchnames'] = "Suche nach Namen";
		$text['joinwith'] = "Verknüpfen mit";
		$text['cap_and'] = "UND";
		$text['cap_or'] = "ODER";
		$text['showspouse'] = "Zeige Partner. Dubletten werden gezeigt, wenn eine Person mehrere Partner hat";
		$text['submitquery'] = "Suche";
		$text['birthplace'] = "Geburtsort";
		$text['deathplace'] = "Sterbeort";
		$text['birthdatetr'] = "Geburtsjahr";
		$text['deathdatetr'] = "Sterbejahr";
		$text['plusminus2'] = "+/- 2 Jahre von";
		$text['resetall'] = "Alle Werte zurücksetzen";

		$text['showdeath'] = "Zeige Todestag/Beerdigungsangaben";
		$text['altbirthplace'] = "Ort der Taufe";
		$text['altbirthdatetr'] = "Jahr der Taufe";
		$text['burialplace'] = "Ort der Beerdigung";
		$text['burialdatetr'] = "Jahr der Beerdigung";
		$text['event'] = "Ereignis(se)";
		$text['day'] = "Tag";
		$text['month'] = "Monat";
		$text['keyword'] = "Suchwort (z.B. \"ABT\", \"BEF\", \"AFT\")";
		$text['explain'] = "Datum oder Datumsteile eingeben, um passende Ereignisse zu erhalten. Oder Feld leerlassen, um alle Ereignisse zu erhalten.";
		$text['enterdate'] = "Bitte mindestens eines der folgenden eingeben oder auswählen: Tag, Monat, Jahr, Suchwort";
		$text['fullname'] = "Vollständiger Name";
		$text['birthdate'] = "Geburtsdatum";
		$text['altbirthdate'] = "Taufdatum";
		$text['marrdate'] = "Heiratsdatum";
		$text['spouseid'] = "Partner-Kennung";
		$text['spousename'] = "Partner-Name";
		$text['deathdate'] = "Sterbedatum";
		$text['burialdate'] = "Beerdigungsdatum";
		$text['changedate'] = "Datum der letzten Änderung";
		$text['gedcom'] = "Stammbaum";
		$text['baptdate'] = "Datum der Taufe (LDS)";
		$text['baptplace'] = "Ort der Taufe (LDS)";
		$text['endldate'] = "Datum der Begabung (LDS)";
		$text['endlplace'] = "Ort der Begabung (LDS)";
		$text['ssealdate'] = "Datum der Siegelung an den Ehepartner (LDS)";
		$text['ssealplace'] = "Ort der Siegelung an den Ehepartner (LDS)";
		$text['psealdate'] = "Datum der Siegelung an die Eltern (LDS)";
		$text['psealplace'] = "Ort der Siegelung an die Eltern (LDS)";
		$text['marrplace'] = "Heiratsort";
		$text['spousesurname'] = "Nachname des Partners";
		//changed in 6.0.0
		$text['spousemore'] = "Wenn Sie einen Wert für den Partner-Nachnamen eingeben, müssen Sie in mindestens einem weiteren Feld eine Eingabe machen.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 Jahre von";
		$text['exists'] = "ist vorhanden";
		$text['dnexist'] = "ist nicht vorhanden";
		//added in 6.0.3
		$text['divdate'] = "Scheidungsdatum";
		$text['divplace'] = "Scheidungsort";
		//changed in 7.0.0
		$text['otherevents'] = "Weitere Suchkriterien";
		//added in 7.0.0
		$text['numresults'] = "Ergebnisse pro Seite";
		$text['mysphoto'] = "Fotos mit unbekannten Personen";
		$text['mysperson'] = "Personen mit fehlenden Angaben";
		$text['joinor'] = "Die Option 'Verknüpfen mit ODER' kann nicht mit dem Nachnamen des Ehepartners verwendet werden";
		//added in 7.0.1
		$text['tellus'] = "Teilen Sie uns mit, was Sie wissen";
		$text['moreinfo'] = "Weitere Informationen:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Protokolldatei für";
		$text['mostrecentactions'] = "letzte Aktionen";
		$text['autorefresh'] = "automatische Aktualisierung einschalten (alle 30 Sekunden)";
		$text['refreshoff'] = "automatische Aktualisierung abschalten";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Friedhöfe und Grabsteine";
		$text['showallhsr'] = "Zeige alle Grabsteine";
		$text['in'] = "in";
		$text['showmap'] = "Karte anzeigen";
		$text['headstonefor'] = "Grabstein von";
		$text['photoof'] = "Foto von";
		$text['firstpage'] = "Erste Seite";
		$text['lastpage'] = "Letzte Seite";
		$text['photoowner'] = "Besitzer/Quelle";

		$text['nocemetery'] = "Kein Friedhof";
		$text['iptc005'] = "Titel";
		$text['iptc020'] = "Zusätzliche Kategorien";
		$text['iptc040'] = "Spezielle Anweisungen";
		$text['iptc055'] = "Gestaltungsdatum";
		$text['iptc080'] = "Autor";
		$text['iptc085'] = "Position des Autors";
		$text['iptc090'] = "Stadt";
		$text['iptc095'] = "Staat";
		$text['iptc101'] = "Land";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Schlagzeile";
		$text['iptc110'] = "Quelle";
		$text['iptc115'] = "Quelle des Fotos";
		$text['iptc116'] = "Copyright-Notiz";
		$text['iptc120'] = "Bildtext";
		$text['iptc122'] = "Bildtext Autor";
		$text['mapof'] = "Karte von";
		$text['regphotos'] = "Übersicht mit Kurzbeschreibungen";
		$text['gallery'] = "Übersicht mit Vorschaubildern";
		$text['cemphotos'] = "Friedhofs-Fotos";
		//changed in 6.0.0
		$text['photosize'] = "Größe";
		//added in 6.0.0
        	$text['iptc010'] = "Priorität";
		$text['filesize'] = "Dateigröße";
		$text['seeloc'] = "Siehe Ort";
		$text['showall'] = "Alles Anzeigen";
		$text['editmedia'] = "Medium bearbeiten";
		$text['viewitem'] = "Dieses Element ansehen";
		$text['editcem'] = "Friedhof bearbeiten";
		$text['numitems'] = "Elemente";
		$text['allalbums'] = "Alle Alben";
		//added in 6.1.0
		$text['slidestart'] = "Diaschau beginnen";
		$text['slidestop'] = "Diaschau beenden";
		$text['slideresume'] = "Diaschau fortsetzen";
		$text['slidesecs'] = "Sekunden für jedes Bild:";
		$text['minussecs'] = "minus 0,5 Sekunden";
		$text['plussecs'] = "plus 0,5 Sekunden";
		//added in 7.0.0
		$text['nocountry'] = "Unbekanntes Land";
		$text['nostate'] = "Unbekannter/s (Bundes-)Staat/Land";
		$text['nocounty'] = "Unbekannte Provinz";
		$text['nocity'] = "Unbekannter Ort";
		$text['nocemname'] = "Unbekannter Friedhofs-Name";
		$text['plot'] = "(Grab-)Standort";
		$text['location'] = "Ort";
		$text['editalbum'] = "Album bearbeiten";
		$text['mediamaptext'] = "<strong>Hinweis:</strong> Wenn Sie Ihren Mauszeiger über das Bild bewegen, werden Namen angezeigt. Klicken Sie diese an, um weitere Informationen zu erhalten.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Nachnamen anzeigen, die mit ... anfangen";
		$text['showtop'] = "Zeige die ersten";
		$text['showallsurnames'] = "Zeige alle Nachnamen";
		$text['sortedalpha'] = "alphabetisch sortiert";
		$text['byoccurrence'] = "Einträge sortiert nach ihrer Häufigkeit";
		$text['firstchars'] = "Erster Buchstabe";
		$text['top'] = "Top";
		$text['mainsurnamepage'] = "Übersichtsseite Nachnamen";
		$text['allsurnames'] = "Alle Nachnamen";
		$text['showmatchingsurnames'] = "Nachnamen anklicken, um weitere Angaben zu erhalten";
		$text['backtotop'] = "Zurück nach oben";
		$text['beginswith'] = "Beginnt mit";
		$text['allbeginningwith'] = "Alle Nachnamen beginnend mit";
		$text['numoccurrences'] = "Anzahl der Datensätze wird in Klammern angezeigt";
		$text['placesstarting'] = "Zeige größte Ortschaften beginnend mit";
		$text['showmatchingplaces'] = "Klicken Sie auf einen Eintrag, um die untergeordneten Ebenen anzuzeigen. Klicken Sie auf das 'Suchen'-Icon, um die Nachnamen zu diesem Ort zu zeigen.";
		$text['totalnames'] = "Anzahl der Personen";
		$text['showallplaces'] = "Zeige alle obersten Orts-Ebenen";
		$text['totalplaces'] = "Anzahl der Orte";
		$text['mainplacepage'] = "Zurück zur Orts-Hauptseite";
		$text['allplaces'] = "Alle obersten Orts-Ebenen";
		$text['placescont'] = "Zeige alle Orte, die ... enthalten";
		//added in 7.0.0
		$text['top30'] = "Die 30 häufigsten Nachnamen";
		$text['top30places'] = "Die 30 bedeutendsten Orte";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(aus den letzten xx Tagen)";
		$text['historiesdocs'] = "Texte";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Foto";
		$text['history'] = "Text/Dokument";
		//changed in 7.0.0
		$text['husbid'] = "Vater-Kennung";
		$text['husbname'] = "Name des Vaters";
		$text['wifeid'] = "Mutter-Kennung";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Löschen";
		$text['addperson'] = "Person hinzufügen";
		$text['nobirth'] = "Die folgende Person hat kein gültiges Geburtsdatum und konnte daher nicht hinzugefügt werden";
		$text['noliving'] = "Die folgende Person ist als 'lebend' deklariert und konnte nicht hinzugefügt werden, da Sie nicht mit den entsprechenden Berechtigungen angemeldet sind";
		$text['event'] = "Ereignis(se)";
		$text['chartwidth'] = "Breite der Graphik";
		//changed in 6.0.0
		$text['timelineinstr'] = "Weitere Kennungen eintragen";
		//added in 6.0.0
		$text['togglelines'] = "Linien ein-/ausschalten";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Zeige alle Stammbäume";
		$text['treename'] = "Stammbaumname";
		$text['owner'] = "Besitzer";
		$text['address'] = "Adresse";
		$text['city'] = "Ort";
		$text['state'] = "(Bundes-)Staat/-Land";
		$text['zip'] = "Postleitzahl";
		$text['country'] = "Land";
		$text['email'] = "E-Mail";
		$text['phone'] = "Telefon";
		$text['username'] = "Benutzerkennung";
		$text['password'] = "Paßwort";
		$text['loginfailed'] = "Anmeldung fehlgeschlagen.";

		$text['regnewacct'] = "Neue Benutzerkennung beantragen";
		$text['realname'] = "Ihre realer Name";
		$text['phone'] = "Telefon";
		$text['email'] = "E-Mail";
		$text['address'] = "Adresse";
		$text['comments'] = "Notiz oder Kommentar";
		$text['submit'] = "Eintragen";
		$text['leaveblank'] = "(Leer lassen, wenn Sie einen neuen Baum beginnen)";
		$text['required'] = "Erforderliche Angaben";
		$text['enterpassword'] = "Bitte Paßwort eingeben.";
		$text['enterusername'] = "Bitte eine Benutzerkennung eingeben.";
		$text['failure'] = "Diese Benutzerkennung wird bereits verwendet. Bitte zur vorgehenden Seite zurück gehen und eine andere Benutzerkennung wählen.";
		$text['success'] = "Vielen Dank. Wir haben Ihre Registrierung empfangen. Wir werden Kontakt mit Ihnen aufnehmen, wenn Ihre Benutzerkennung freigeschaltet worden ist oder wenn wir weitere Angaben benötigen.";
		$text['emailsubject'] = "Registrierungsanfrage: Neuer TNG-Benutzer";
		$text['emailmsg'] = "Sie haben eine Registrierungsanfrage für einen neuen TNG-Benutzer erhalten. Bitte besuchen Sie Ihren TNG-Verwaltungsbereich und stellen Sie die Zugriffsrechte ein. Wenn Sie der Registrierung zustimmen, unterrichten Sie den Antragsteller, indem Sie auf diese E-Mail antworten.";
		//changed in 5.0.0
		$text['enteremail'] = "Bitte eine gültige E-Mail-Adresse eingeben.";
		$text['website'] = "Website (WWW-Adresse)";
		$text['nologin'] = "Sie haben keine Anmeldedaten?";
		$text['loginsent'] = "Anmeldedaten wurden versandt";
		$text['loginnotsent'] = "Anmeldedaten wurden nicht versandt";
		$text['enterrealname'] = "Bitte geben Sie Ihren wirklichen Namen ein.";
		$text['rempass'] = "Auf diesem Rechner angemeldet bleiben";
		$text['morestats'] = "Weitere Statistiken";
		//added in 6.0.0
		$text['accmail'] = "<strong>HINWEIS:</strong> Um vom Verwalter dieser Website E-Mails, betreffend Ihre Benutzerkennung, empfangen zu können, stellen Sie bitte sicher, daß E-Mails aus dieser Domain bei Ihnen nicht gesperrt werden.";
		$text['newpassword'] = "Neues Paßwort";
		$text['resetpass'] = "Ihr Paßwort zurücksetzen";
		//added in 6.1.0
		$text['nousers'] = "Dieses Formular kann nicht verwendet werden, solange nicht mindestens ein Benutzer-Datensatz existiert. Wenn Sie der Eigentümer dieser Website sind, dann rufen Sie Verwaltung/Benutzer auf und legen Sie Ihre Administrator-Kennung an.";
		//added in 7.0.0
		$text['noregs'] = "Bedauerlicherweise werden momentan keine neuen Benutzer-Registrierungen akzeptiert. Bitte <a href=\"suggest.php\">kontaktieren</a> Sie uns, wenn Sie Anmerkungen oder Fragen zu dieser Website haben.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Anzahl";
		$text['totindividuals'] = "Personen";
		$text['totmales'] = "Männliche Personen";
		$text['totfemales'] = "Weibliche Personen";
		$text['totunknown'] = "Personen mit unbekanntem Geschlecht";
		$text['totliving'] = "Lebende Personen";
		$text['totfamilies'] = "Familien";
		$text['totuniquesn'] = "Eindeutige Nachnamen";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Quellen";
		$text['avglifespan'] = "Durchschnittliche Lebensspanne";
		$text['earliestbirth'] = "Früheste Geburt";
		$text['longestlived'] = "Älteste Personen";
		$text['years'] = "Jahre";
		$text['days'] = "Tage";
		$text['age'] = "Alter";
		$text['agedisclaimer'] = "Altersbasierte Berechnungen sind bezogen auf Personen mit eingetragenem Geburtstag <EM>und</EM> Sterbedatum. Durch unvollständige Datumsfelder (z.B. Geburtstag nur eingetragen als \"1945\" oder \"BEF 1860\") können diese Berechnungen nicht immer 100 % korrekt sein.";
		$text['treedetail'] = "Weitere Angaben zu diesem Zweig";
		//added in 6.0.0
		$text['total'] = "Anzahl";
		break;

	case "notes":
		$text['browseallnotes'] = "Alle Notizen durchblättern";
		break;

	case "help":
		$text['menuhelp'] = "Bedeutung der Menü-Icons";
		break;

	case "install":
		$text['perms'] = "Alle Berechtigungen wurden eingerichtet.";
		$text['noperms'] = "Die Berechtigungen für die folgenden Dateien konnten nicht eingerichtet werden:";
		$text['manual'] = "Bitte richten Sie sie von Hand ein.";
		$text['folder'] = "Verzeichnis";
		$text['created'] = "wurde angelegt";
		$text['nocreate'] = "konnte nicht angelegt werden. Bitte von Hand anlegen.";
		$text['infosaved'] = "Information wurde gespeichert, Datenbank-Verbindung wurde überprüft!";
		$text['tablescr'] = "Die Tabellen wurden angelegt!";
		$text['notables'] = "Die folgenden Tabellen konnten nicht angelegt werden:";
		$text['nocomm'] = "TNG kann nicht auf Ihre Datenbank zugreifen. Es wurden keine Tabellen angelegt.";
		$text['newdb'] = "Information wurde gespeichert, Datenbank-Verbindung wurde überprüft, neue Datenbank wurde angelegt:";
		$text['noattach'] = "Information wurde gespeichert. Datenbank-Verbindung wurde hergestellt und Datenbank wurde angelegt, aber TNG kann nicht darauf zugreifen.";
		$text['nodb'] = "Information wurde gespeichert. Verbindung wurde hergestellt, aber die Datenbank ist nicht vorhanden und konnte auch nicht angelegt werden. Bitte überprüfen Sie, ob der angegebene Datenbankname korrekt ist, oder verwenden Sie Ihr Verwaltungsprogramm, um sie anzulegen.";
		$text['noconn'] = "Information wurde gespeichert, aber die Verbindung zur Datenbank ist fehlgeschlagen. Einer oder mehrere der folgenden Punkte sind nicht korrekt:";
		$text['exists'] = "ist vorhanden";
		$text['loginfirst'] = "Sie müssen sich zuerst anmelden.";
		$text['noop'] = "Es wurde keine Datenbank-Operation ausgeführt.";
		break;
}

//common
$text['matches'] = "Treffer";
$text['description'] = "Beschreibung";
$text['notes'] = "Notizen";
$text['status'] = "Status";
$text['newsearch'] = "Neue Suche";
$text['pedigree'] = "Stammbaum";
$text['birthabbr'] = "geb.";
$text['chrabbr'] = "get.";
$text['seephoto'] = "Siehe Foto";
$text['andlocation'] = "& Ort";
$text['accessedby'] = "besucht durch";
$text['go'] = "Los!";
$text['family'] = "Familie";
$text['children'] = "Kinder";
$text['tree'] = "Stammbaum";
$text['alltrees'] = "Alle Stammbäume";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "Vorschaubild";
$text['people'] = "Personen";
$text['title'] = "Titel";
$text['suffix'] = "Suffix";
$text['nickname'] = "Beiname/Spitzname";
$text['deathabbr'] = "gest.";
$text['lastmodified'] = "Zuletzt bearbeitet am";
$text['married'] = "Verheiratet";
//$text['photos'] = "Photos";
$text['name'] = "Name";
$text['lastfirst'] = "Nachname, Taufnamen";
$text['bornchr'] = "Geboren/Getauft";
$text['individuals'] = "Personen";
$text['families'] = "Familien";
$text['personid'] = "Personen-Kennung";
$text['sources'] = "Quellen";
$text['unknown'] = "unbekannt";
$text['father'] = "Vater";
$text['mother'] = "Mutter";
$text['born'] = "Geboren";
$text['christened'] = "Getauft";
$text['died'] = "Gestorben";
$text['buried'] = "Beerdigt";
$text['spouse'] = "Ehepartner";
$text['parents'] = "Eltern";
$text['text'] = "Text";
$text['language'] = "Sprache";
$text['burialabbr'] = "begr.";
$text['descendchart'] = "Nachkommen";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Person";
$text['edit'] = "Bearbeiten";
$text['date'] = "Datum";
$text['place'] = "Ort";
$text['login'] = "Anmelden";
$text['logout'] = "Abmelden";
$text['marrabbr'] = "Verh.";
$text['groupsheet'] = "Familienblatt";
$text['text_and'] = "und";
$text['generation'] = "Generation";
$text['filename'] = "Dateiname";
$text['id'] = "Kennung";
$text['search'] = "Suche";
$text['living'] = "Lebend";
$text['user'] = "Benutzer";
$text['firstname'] = "Vorname";
$text['lastname'] = "Nachname";
$text['searchresults'] = "Suchergebnisse";
$text['diedburied'] = "Verstorben/begraben";
$text['homepage'] = "Startseite";
$text['find'] = "Suchen...";
$text['relationship'] = "Verwandschaft";
$text['relationship2'] = "Beziehung";
$text['timeline'] = "Zeitstrahl";
$text['yesabbr'] = "J";
$text['divorced'] = "Geschieden";
$text['indlinked'] = "Verknüpft mit";
$text['branch'] = "Zweig";
$text['moreind'] = "Weitere Personen...";
$text['morefam'] = "Weitere Familien...";
$text['livingdoc'] = "Mindestens eine lebende Person ist mit diesem Text verknüpft - Details werden aus Datenschutzgründen nicht angezeigt.";
$text['source'] = "Quelle";
$text['surnamelist'] = "Liste der Nachnamen";
$text['generations'] = "Generationen";
$text['refresh'] = "Aktualisieren";
$text['whatsnew'] = "Aktuelles";
$text['reports'] = "Auswertungen";
$text['placelist'] = "Ortsliste";
$text['baptizedlds'] = "Getauft (LDS)";
$text['endowedlds'] = "Begabung (LDS)";
$text['sealedplds'] = "Siegelung an die Eltern (LDS)";
$text['sealedslds'] = "Siegelung an den Ehepartner (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Vorfahren";
$text['descendants'] = "Nachkommen";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Datum des letzten GEDCOM-Imports";
$text['type'] = "Typ";
$text['savechanges'] = "Speichern";
$text['familyid'] = "Familien-Kennung";
$text['headstone'] = "Grabsteine";
$text['historiesdocs'] = "Texte";
$text['livingnote'] = "Mit dieser Bemerkung ist mindestens eine lebende Person verknüpft - Details werden aus Datenschutzgründen nicht angezeigt.";
$text['anonymous'] = "anonym";
$text['places'] = "Orte";
$text['anniversaries'] = "Daten & Jahrestage";
$text['administration'] = "Verwaltung";
$text['help'] = "Hilfe";
//$text['documents'] = "Documents";
$text['year'] = "Jahr";
$text['all'] = "Alles";
$text['repository'] = "Aufbewahrungsort";
$text['address'] = "Adresse";
$text['suggest'] = "Anmerkung";
$text['editevent'] = "Änderungsvorschlag für dieses Ereignis";
$text['findplaces'] = "Suche alle Personen mit Ereignissen an diesem Ort";
$text['morelinks'] = "Weitere Verknüpfungen";
$text['faminfo'] = "Angaben zur Familie";
$text['persinfo'] = "Angaben zur Person";
$text['srcinfo'] = "Angaben zur Quelle";
$text['fact'] = "Merkmal";
$text['goto'] = "Eine Seite auswählen";
$text['tngprint'] = "Drucken";
//changed in 6.0.0
$text['livingphoto'] = "Mindestens eine lebende Person ist mit diesem Foto verknüpft - Details werden aus Datenschutzgründen nicht angezeigt.";
$text['databasestatistics'] = "Datenbankstatistiken";
//moved here in 6.0.0
$text['child'] = "Kind";
$text['repoinfo'] = "Angaben zum Aufbewahrungsort";
$text['tng_reset'] = "Zurücksetzen";
$text['noresults'] = "Keine Suchergebnisse";
//added in 6.0.0
$text['allmedia'] = "Alle Medien";
$text['repositories'] = "Aufbewahrungsorte";
$text['albums'] = "Alben";
$text['cemeteries'] = "Friedhöfe";
$text['surnames'] = "Nachnamen";
$text['dates'] = "Datumsangaben";
$text['link'] = "Querverweis";
$text['media'] = "Medien";
$text['gender'] = "Geschlecht";
$text['latitude'] = "Geographische Breite";
$text['longitude'] = "Geographische Länge";
$text['bookmarks'] = "Lesezeichen";
$text['bookmark'] = "Lesezeichen hinzufügen";
$text['mngbookmarks'] = "Zu den Lesezeichen gehen";
$text['bookmarked'] = "Lesezeichen hinzugefügt";
$text['remove'] = "Entfernen";
$text['find_menu'] = "Suchen";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Friedhof";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Ereignis-Karte";
$text['gevents'] = "Ereignis";
$text['glang'] = "&amp;hl=de";
$text['googleearthlink'] = "Link zu Google Earth";
$text['googlemaplink'] = "Link zu Google Maps";
$text['gmaplegend'] = "Pin-Bedeutungen";
//moved here in 7.0.0
$text['unmarked'] = "Nicht markiert";
$text['located'] = "Gefunden";
//added in 7.0.0
$text['albclicksee'] = "Anklicken, um alle Elemente in diesem Album anzuzeigen";
$text['notyetlocated'] = "Noch nicht lokaliert";
$text['cremated'] = "eingeäschert";
$text['missing'] = "fehlend";
$text['page'] = "Seite";
$text['pdfgen'] = "PDF-Datei erzeugen";
$text['blank'] = "ohne Daten-Inhalte";
$text['none'] = "Keine";
$text['fonts'] = "Fonts";
$text['header'] = "Überschrift";
$text['data'] = "Daten";
$text['pgsetup'] = "Seiten-Einstellungen";
$text['pgsize'] = "Seitengröße";
$text['letter'] = "Letter";
$text['legal'] = "Legal";
$text['orient'] = "Ausrichtung";
$text['portrait'] = "Hochformat";
$text['landscape'] = "Querformat";
$text['tmargin'] = "Oberer Rand";
$text['bmargin'] = "Unterer Rand";
$text['lmargin'] = "Linker Rand";
$text['rmargin'] = "Rechter Rand";
$text['createch'] = "PDF-Datei erzeugen";
$text['prefix'] = "Präfix";
$text['mostwanted'] = "Gesuchte Angaben";
$text['latupdates'] = "Letzte Aktualisierungen";
$text['featphoto'] = "Aufmacher-Foto";
$text['news'] = "Aktuelles";
$text['ourhist'] = "Die Geschichte unserer Familie";
$text['ourhistanc'] = "Die Geschichte und Genealogie unserer Familie";
$text['ourpages'] = "Die Seiten zu unserer Familien-Genealogie";
$text['pwrdby'] = "Diese Website läuft mit";
$text['writby'] = "programmiert von";
$text['searchtngnet'] = "Suche im TNG-Network (GENDEX)";
$text['viewphotos'] = "Alle Fotos ansehen";
$text['anon'] = "Sie sind momentan nicht angemeldet (anonymer Benutzer)";
$text['whichbranch'] = "Zu welchem Zweig gehören Sie?";
$text['featarts'] = "Aufmacher-Artikel";
$text['maintby'] = "betrieben von";
$text['createdon'] = "Erzeugt am";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Startseite";
$text['mnusearchfornames'] = "Suche nach Namen";
$text['mnulastname'] = "Nachname";
$text['mnufirstname'] = "Vorname";
$text['mnusearch'] = "Suchen";
$text['mnureset'] = "Zurücksetzen";
$text['mnulogon'] = "Anmelden";
$text['mnulogout'] = "Abmelden";
$text['mnufeatures'] = "Weitere Funktionen";
$text['mnuregister'] = "Benutzerkennung beantragen";
$text['mnuadvancedsearch'] = "Erweiterte Suche";
$text['mnulastnames'] = "Nachnamen";
$text['mnustatistics'] = "Statistik";
$text['mnuphotos'] = "Fotos";
$text['mnuhistories'] = "Texte";
$text['mnumyancestors'] = "Fotos &amp; Texte für Vorfahren von [Person]";
$text['mnucemeteries'] = "Friedhöfe";
$text['mnutombstones'] = "Grabsteine";
$text['mnureports'] = "Auswertungen";
$text['mnusources'] = "Quellen";
$text['mnuwhatsnew'] = "Aktuelles";
$text['mnushowlog'] = "Protokoll der Zugriffe";
$text['mnulanguage'] = "Sprache ändern";
$text['mnuadmin'] = "Verwaltung";
$text['welcome'] = "Willkommen";
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
