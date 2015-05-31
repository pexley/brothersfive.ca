<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Tutte le Fonte";
		$text['shorttitle'] = "Titolo Breve";
		$text['callnum'] = "Numero d'archivio";
		$text['author'] = "Autore";
		$text['publisher'] = "Editore";
		$text['other'] = "Altro Informazione";
		$text['sourceid'] = "Fonte ID";
		$text['moresrc'] = "Altri Fonti";
		$text['repoid'] = "ID del Luogo di deposito";
		$text['browseallrepos'] = "Cercare i Luoghi di deposito";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Lingua Nuova ";
		$text['changelanguage'] = "Cambiare la Lingua";
		$text['languagesaved'] = "Lingua Registrata";
		//added in 7.0.0
		$text['sitemaint'] = "Manutenzione del luogo in progresso.";
		$text['standby'] = "Il luogo è temporaneamente non disponibile mentre aggiorniamo la nostra base di dati. Provi prego ancora in alcuni minuti. Se il luogo rimane giù per un periodo esteso, metta in <a href=\"suggest.php\">contatto con prego il proprietario del luogo</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM prende avvio di";
		$text['producegedfrom'] = "Produrre un archivio GEDCOM da";
		$text['numgens'] = "Numero di Generazioni";
		$text['includelds'] = "Includere informazione LDS";
		$text['buildged'] = "Costruire GEDCOM";
		$text['gedstartfrom'] = "GEDCOM inizia da";
		$text['nomaxgen'] = "Dovete precisare un numero massimo di generazioni. Premere sul bottone 'precedente' e correggere l'errore ";
		$text['gedcreatedfrom'] = "GEDCOM creato da";
		$text['gedcreatedfor'] = "Creato per";

		$text['enteremail'] = "Volete introdurre un indirizzo posta elettronica valida.";
		$text['creategedfor'] = "Creare un archivio GEDCOM";
		$text['email'] = "Indirizzo elettronico";
		$text['suggestchange'] = "Suggerite una modifica";
		$text['yourname'] = "Il vostro Nome";
		$text['comments'] = "Note o commenti";
		$text['comments2'] = "Commenti";
		$text['submitsugg'] = "Presentate una Proposta";
		$text['proposed'] = "Cambiamento Proposto";
		$text['mailsent'] = "Grazie. Il vostro messaggio è stato inviato.";
		$text['mailnotsent'] = "Spiacente, ma il vostro messaggio non ha potuto essere inviato. Volete direttamente contattare xxx a yyy ";
		$text['mailme'] = "Inviate una copia a questo indirizzo";
		//added in 5.0.5
		$text['entername'] = "Iscrivete il vostro nome";
		$text['entercomments'] = "Iscrivete i vostri commenti";
		$text['sendmsg'] = "Inviate un Messaggio";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Fotografie e Cronistoria di";
		$text['indinfofor'] = "Info. personale che riguarda";
		$text['reliability'] = "Affidabilità";
		$text['pp'] = "pp.";
		$text['age'] = "Età";
		$text['agency'] = "Agenzia";
		$text['cause'] = "Causa";
		$text['suggested'] = "Suggerito";
		$text['closewindow'] = "Chiudete questa finestra";
		$text['thanks'] = "Grazie";
		$text['received'] = "Il cambiamento che avete proposto sarà incluso dopo verifica dall'amministratore della località.";
		//added in 6.0.0
		$text['association'] = "Associazione";
		//added in 7.0.0
		$text['indreport'] = "Rapporto specifico";
		$text['indreportfor'] = "Rapporto specifico per";
		$text['general'] = "Generalità";
		$text['labels'] = "Etichette";
		$text['bkmkvis'] = "<strong>Nota:</strong> Questi segnalibri sono soltanto visibili su questo calcolatore ed in questo browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Elaboratore di Relazione";
		$text['findrel'] = "Ricerca di Relazione";
		$text['person1'] = "Persona 1:";
		$text['person2'] = "Persona 2:";
		$text['calculate'] = "Calcolo";
		$text['select2inds'] = "Volete scegliere due individui.";
		$text['findpersonid'] = "Trovate ID della persona";
		$text['enternamepart'] = "Introdurre il nome o il nome di famiglia";
		$text['pleasenamepart'] = "Volete introdurre il nome o il nome di famiglia.";
		$text['clicktoselect'] = "Premete per scegliere";
		$text['nobirthinfo'] = "Non dati di nascita";
		$text['relateto'] = "Relazione a";
		$text['sameperson'] = "I due individui sono identici";
		$text['notrelated'] = "I due individui non sono legati su xxx generazioni.";
		$text['findrelinstr'] = "Per pubblicare la relazione tra due persone, utilizza il bottone 'ricerca 'sotto per trovare gli individui (o conservate gli individui pubblicati), in seguito premete 'su calcolare'.";
		$text['gencheck'] = "Generazioni max da verificare";
		$text['sometimes'] = "(a volte il fatto di verificare un altro numero di generazioni dà un risultato diverso)";
		$text['findanother'] = "Trovare un altro legame";
		//added in 6.0.0
		$text['brother'] = "il fratello di";
		$text['sister'] = "la sorella di";
		$text['sibling'] = "fratello/sorella di";
		$text['uncle'] = "il xxx zio di";
		$text['aunt'] = "la xxx zia di";
		$text['uncleaunt'] = "il xxx zio/la zia di";
		$text['nephew'] = "il xxx nipote di";
		$text['niece'] = "la xxx nipote di";
		$text['nephnc'] = "i xxx nipote di";
		$text['mcousin'] = "il xxx cugino di";
		$text['fcousin'] = "la xxx cugina di";
		$text['cousin'] = "il xxx cugino(a) di";
		$text['removed'] = "di Secondo";
		$text['rhusband'] = "il Marito di ";
		$text['rwife'] = "la Moglje di ";
		$text['rspouse'] = "il Sposo(a) di ";
		$text['son'] = "il Figlio di";
		$text['daughter'] = "la Figlia di";
		$text['rchild'] = "il Bambino(a) di";
		$text['sil'] = "il Genero di";
		$text['dil'] = "la Nuora di";
		$text['sdil'] = "il Genero o la Nuora di";
		$text['gson'] = "il xxx Nipote di";
		$text['gdau'] = "la xxx Nipote di";
		$text['gsondau'] = "i xxx Nipote di";
		$text['great'] = "bis";
		$text['spouses'] = "sono Coniuge";
		$text['is'] = "è";
		//changed in 6.0.0
		$text['changeto'] = "Cambiate in:";
		//added in 6.0.0
		$text['notvalid'] = "Il Persona ID non è valido o non esiste in questo database. Riprovate di nuovo.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Pagina di";
		$text['ldsords'] = "Ordinanze LDS";
		$text['baptizedlds'] = "Battezzato (LDS)";
		$text['endowedlds'] = "Dotato (LDS)";
		$text['sealedplds'] = "Dotato genitori (LDS)";
		$text['sealedslds'] = "Coniuge dotato (LDS)";
		$text['otherspouse'] = "Altro Coniuge";
		//changed in 7.0.0
		$text['husband'] = "Marito";
		$text['wife'] = "Moglie";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "N";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "E";
		$text['capplaceabbr'] = "L";
		$text['capmarrabbr'] = "M";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Ridefinire con";
		$text['scrollnote'] = "Nota: Utilizzate gli ascensori per vedere tutto l'albero.";
		$text['unknownlit'] = "Sconosciuto";
		$text['popupnote1'] = "Informazione ulteriore";
		$text['popupnote2'] = "Nuovo albero";
		$text['pedcompact'] = "Compatto";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Testo solo";
		$text['descendfor'] = "Discesa di";
		$text['maxof'] = "Massimo di";
		$text['gensatonce'] = "Generazioni pubblicate allo stesso tempo";
		$text['sonof'] = "Figlio di";
		$text['daughterof'] = "Figlia di";
		$text['childof'] = "Bambino di";
		$text['stdformat'] = "formato stendardo";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "Aggiungere una nuova famiglia";
		$text['editfam'] = "Pubblicare la famiglia";
		$text['side'] = "(ascendenti)";
		$text['familyof'] = "Famiglia di";
		$text['paternal'] = "Paterno";
		$text['maternal'] = "Materno";
		$text['gen1'] = "sé";
		$text['gen2'] = "Genitori";
		$text['gen3'] = "Grande-genitore (nonni)";
		$text['gen4'] = "Secondi nonni";
		$text['gen5'] = "Terzi nonni";
		$text['gen6'] = "quarti nonni";
		$text['gen7'] = "quinti nonni";
		$text['gen8'] = "sesti nonni";
		$text['gen9'] = "settimi nonni";
		$text['gen10'] = "ottavi nonni";
		$text['gen11'] = "noni nonni";
		$text['gen12'] = "decimi nonni";
		$text['graphdesc'] = "Tabella di discesa fino a questo punto";
		$text['collapse'] = "Ridurre";
		$text['expand'] = "Sviluppare";
		$text['pedbox'] = "Scatola";
		//changed in 6.0.0
		$text['regformat'] = "formato registro";
		$text['extrasexpl'] = "Se fotografie o storie esistono per gli individui seguenti, le icone corrispondenti saranno pubblicate accanto ai nomi.";
		//added in 6.0.0
		$text['popupnote3'] = " = Carta Nouva";
		$text['mediaavail'] = "Mezzi Disponibile";
		//changed in 7.0.0
		$text['pedigreefor'] = "Albero di";
		//added in 7.0.0
		$text['pedigreech'] = "Tabella di razza";
		$text['datesloc'] = "Date e posizioni";
		$text['borchr'] = "Nascita/Alt - morte/sepoltura (due)";
		$text['nobd'] = "Nessun date di morte o di nascita";
		$text['bcdb'] = "Nascita/Alt/Morte/Sepoltura (quattro)";
		$text['numsys'] = "Sistema di numerazione";
		$text['gennums'] = "Numeri di generazione";
		$text['henrynums'] = "Numeri del Henry";
		$text['abovnums'] = "Numeri di d'Aboville";
		$text['devnums'] = "Numeri di de Villiers";
		$text['dispopts'] = "Opzioni dell'esposizione";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "Nulla Rapporto.";
		$text['reportname'] = "Nome del Rapporto";
		$text['allreports'] = "Tutte gli Rapporti";
		$text['report'] = "Rapporto";
		$text['error'] = "Errore";
		$text['reportsyntax'] = "la sintassi di questa richiesta";
		$text['wasincorrect'] = "è sbagliata, e il rapporto non ha potuto essere lanciata. Grazie di contattare il vostro amministratore sistema a ";
		$text['query'] = "Richiesta";
		$text['errormessage'] = "Messaggio d'errore";
		$text['equals'] = "uguale";
		$text['contains'] = "contiene";
		$text['startswith'] = "comincia con";
		$text['endswith'] = "si conclude";
		$text['soundexof'] = "soundex di";
		$text['metaphoneof'] = "metafono di";
		$text['plusminus10'] = "+/- 10 anni di";
		$text['lessthan'] = "inferiore a ";
		$text['greaterthan'] = "superiore a ";
		$text['lessthanequal'] = "inferiore o uguaglia a ";
		$text['greaterthanequal'] = "superiore o uguaglia a ";
		$text['equalto'] = "uguale a";
		$text['tryagain'] = "Volete provare di nuovo";
		$text['text_for'] = "per";
		$text['searchnames'] = "Ricerca";
		$text['joinwith'] = "legame";
		$text['cap_and'] = "E";
		$text['cap_or'] = "O";
		$text['showspouse'] = "pubblicare coniuge (pubblicherà doppi se una persona ha più di uno coniuge)";
		$text['submitquery'] = "Ricercare";
		$text['birthplace'] = "Luogo di nascita";
		$text['deathplace'] = "Luogo di decessi";
		$text['birthdatetr'] = "Anno di nascita";
		$text['deathdatetr'] = "Anno di decessi";
		$text['plusminus2'] = "+/- 2 anni";
		$text['resetall'] = "Reinizializzare tutti i valori";

		$text['showdeath'] = "Mostrare le informazioni di decessi/sepoltura";
		$text['altbirthplace'] = "Luogo di Baptesimo";
		$text['altbirthdatetr'] = "Anno di Baptesimo";
		$text['burialplace'] = "Luogo della Sepoltura";
		$text['burialdatetr'] = "Anno della Sepoltura";
		$text['event'] = "Evento(i)";
		$text['day'] = "Giorno";
		$text['month'] = "Mese";
		$text['keyword'] = "Parola chiave (ad esempio, \"Verso\")";
		$text['explain'] = "Introdurre le date per vedere gli eventi corrispondenti. Lasciare un campo vuoto per vedere tutte le corrispondenze.";
		$text['enterdate'] = "Volete introdurre o scegliere almeno uno degli elementi seguenti: Giorno, mese, anno, parola chiave: ";
		$text['fullname'] = "Nome intero";
		$text['birthdate'] = "Data di nascita";
		$text['altbirthdate'] = "Data di baptesimo";
		$text['marrdate'] = "Data delle nozze";
		$text['spouseid'] = "ID del coniuge";
		$text['spousename'] = "Nome del coniuge";
		$text['deathdate'] = "Data di decessi";
		$text['burialdate'] = "Data della sepoltura";
		$text['changedate'] = "Data dell'ultima modifica";
		$text['gedcom'] = "Albero";
		$text['baptdate'] = "Data di baptesimo (SDJ)";
		$text['baptplace'] = "Luogo di baptesimo (SDJ)";
		$text['endldate'] = "Data di conferma (SDJ)";
		$text['endlplace'] = "Luogo di conferma (SDJ)";
		$text['ssealdate'] = "Data del sigillo S (SDJ)";
		$text['ssealplace'] = "Luogo del sigillo S (SDJ)";
		$text['psealdate'] = "Data del sigillo (SDJ)";
		$text['psealplace'] = "Luogo del sigillo P (SDJ)";
		$text['marrplace'] = "Luogo di Nozze";
		$text['spousesurname'] = "Nome di famiglia del coniuge";
		//changed in 6.0.0
		$text['spousemore'] = "se entrate un valore per il nome di famiglia del coniuge, dovete entrare almeno un'altro valore.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 anni da";
		$text['exists'] = "Esiste";
		$text['dnexist'] = "Non Esiste";
		//added in 6.0.3
		$text['divdate'] = "Data di divorzio";
		$text['divplace'] = "Posto di divorzio";
		//changed in 7.0.0
		$text['otherevents'] = "Altri Eventi";
		//added in 7.0.0
		$text['numresults'] = "Risultati per pagina";
		$text['mysphoto'] = "Foto di mistero";
		$text['mysperson'] = "Gente evasiva";
		$text['joinor'] = "Il ' Unisca con OR' l'opzione non può essere usata con il cognome del sposo/a";
		//added in 7.0.1
		$text['tellus'] = "Tell us what you know";
		$text['moreinfo'] = "More Information:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Archivio registro per";
		$text['mostrecentactions'] = "ultime azioni";
		$text['autorefresh'] = "Rinfreschi automatico (30 secondi)";
		$text['refreshoff'] = "Eliminare il rinfreschi automatico";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cimiteri e Pietri Tombale";
		$text['showallhsr'] = "Mostrare tutte le registrazioni delle tombe";
		$text['in'] = "in3";
		$text['showmap'] = "Mostrare la carta";
		$text['headstonefor'] = "Pietra Tombale di";
		$text['photoof'] = "Fotografia di";
		$text['firstpage'] = "Prima pagina";
		$text['lastpage'] = "Ultima pagina";
		$text['photoowner'] = "Fonte del proprietario";

		$text['nocemetery'] = "Non un cimitero";
		$text['iptc005'] = "Titolo";
		$text['iptc020'] = "Categorie supplementari";
		$text['iptc040'] = "Istruzioni speciali";
		$text['iptc055'] = "Data di creazione";
		$text['iptc080'] = "Autore";
		$text['iptc085'] = "Posizione dell'autore";
		$text['iptc090'] = "Città";
		$text['iptc095'] = "Stato";
		$text['iptc101'] = "Paese";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Titolo";
		$text['iptc110'] = "Fonte";
		$text['iptc115'] = "Fonte della fotografia";
		$text['iptc116'] = "Nota di diritto d'autore";
		$text['iptc120'] = "Sottotitolo";
		$text['iptc122'] = "Autore del sottotitolo";
		$text['mapof'] = "Carta di";
		$text['regphotos'] = "Vista descrittiva";
		$text['gallery'] = "Soltanto le etichette";
		$text['cemphotos'] = "Fotografie di cimiteri";
		//changed in 6.0.0
		$text['photosize'] = "Dimensione";
		//added in 6.0.0
        	$text['iptc010'] = "Priorita";
		$text['filesize'] = "Grandezza di File";
		$text['seeloc'] = "Vedeste Posizione";
		$text['showall'] = "Mostrare tutto";
		$text['editmedia'] = "Curare Media";
		$text['viewitem'] = "Vedere Questo Dettaglio";
		$text['editcem'] = "Curacre Cimiterio";
		$text['numitems'] = "# Dettaglio";
		$text['allalbums'] = "Tutti l'album";
		//added in 6.1.0
		$text['slidestart'] = "Inizi La Proiezione di diapositive";
		$text['slidestop'] = "Pausa La Proiezione di diapositive";
		$text['slideresume'] = "Riassunto La Proiezione di diapositive";
		$text['slidesecs'] = "Secondi per ogni scorrevole :";
		$text['minussecs'] = "di meno 0.5 secondi";
		$text['plussecs'] = "più 0.5 secondi";
		//added in 7.0.0
		$text['nocountry'] = "Paese sconosciuto";
		$text['nostate'] = "Stato sconosciuto";
		$text['nocounty'] = "Paese sconosciuto";
		$text['nocity'] = "Città sconosciuta";
		$text['nocemname'] = "Nome sconosciuto del cimitero";
		$text['plot'] = "Plot";
		$text['location'] = "Posizione";
		$text['editalbum'] = "Pubblichi l'album";
		$text['mediamaptext'] = "<strong>Nota:</strong> Sposti il vostro puntatore del mouse sopra l'immagine verso i nomi di esposizione. Scatti per vedere una pagina per ogni nome.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Pubblicare i cognome che cominciano con";
		$text['showtop'] = "Mostrare la cima";
		$text['showallsurnames'] = "Pubblicare tutti i Cognome";
		$text['sortedalpha'] = "Selezione alfabetica";
		$text['byoccurrence'] = "Classificati da verificarsi";
		$text['firstchars'] = "Primi caratteri";
		$text['top'] = "Testa di Pagina";
		$text['mainsurnamepage'] = "Cognome";
		$text['allsurnames'] = "Tutti i Cognome";
		$text['showmatchingsurnames'] = "Premete su uno Cognomo per pubblicare i risultati.";
		$text['backtotop'] = "Rirtorno in testa della pagina";
		$text['beginswith'] = "Cominciando con";
		$text['allbeginningwith'] = "Tutti i Cognomo che cominciano con";
		$text['numoccurrences'] = "Numero di risultati tra parentesi";
		$text['placesstarting'] = "Mostrare i luoghi più grande cominciano con";
		$text['showmatchingplaces'] = "Premete su un nome per vedere le registrazioni legate.";
		$text['totalnames'] = "Totale degli individui";
		$text['showallplaces'] = "Mostrare i più grande luoghi";
		$text['totalplaces'] = "Totale dei luoghi";
		$text['mainplacepage'] = "Pagina dei luoghi principali";
		$text['allplaces'] = "Tutte le più grandi località";
		$text['placescont'] = "Mostrare tutti i luoghi che contengono";
		//added in 7.0.0
		$text['top30'] = "Cognomi del principale 30";
		$text['top30places'] = "Più grandi località del principale 30";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(ultimi xx giorni)";
		$text['historiesdocs'] = "Storie";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Foto";
		$text['history'] = "Storia/documento";
		//changed in 7.0.0
		$text['husbid'] = "ID Coniuge";
		$text['husbname'] = "Nome del Coniuge";
		$text['wifeid'] = "ID Coniuge";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Eliminare";
		$text['addperson'] = "Aggiungere individuo";
		$text['nobirth'] = "L'individuo seguente non ha date di nascita valida e non è stato dunque aggiunto";
		$text['noliving'] = "L'individuo seguente è registrato poiché essendo in vita e non è pubblicato perché non siete collegati con le autorizzazioni necessarie";
		$text['event'] = "Evento(i)";
		$text['chartwidth'] = "Larghezza del grafico";
		//changed in 6.0.0
		$text['timelineinstr'] = "Aggiungete fino a quattro individui che entrano nel loro IDs qui di seguito:";
		//added in 6.0.0
		$text['togglelines'] = "Ginocchiera Linee";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Tutti gli alberi";
		$text['treename'] = "Nome dell'albero";
		$text['owner'] = "Proprietario";
		$text['address'] = "Indirizzo";
		$text['city'] = "Città";
		$text['state'] = "Provincia";
		$text['zip'] = "Codice Postale";
		$text['country'] = "Paese";
		$text['email'] = "Indirizzo elettronico";
		$text['phone'] = "Telefono";
		$text['username'] = "Nome d'utente";
		$text['password'] = "Parola d'ordine";
		$text['loginfailed'] = "Errore di collegamento.";

		$text['regnewacct'] = "Registrazione nuovamente conta utente";
		$text['realname'] = "il vostro nome vero";
		$text['phone'] = "Telefono";
		$text['email'] = "Indirizzo elettronico";
		$text['address'] = "Indirizzo";
		$text['comments'] = "Note o commenti";
		$text['submit'] = "Sottoporre";
		$text['leaveblank'] = "(lasciare in vuoto se desiderate un nuovo albero)";
		$text['required'] = "Campi necessari";
		$text['enterpassword'] = "Introdurte una parola d'ordine.";
		$text['enterusername'] = "Introdurte un nome d'utente.";
		$text['failure'] = "Il vostro nome d'utente è già preso. Volete utilizzare il bottone ritorno del vostro navigatore per ritornare alla pagina precedente e scegliere un altro nome di utente.";
		$text['success'] = "Grazie. Abbiamo ricevuto la vostra registrazione. Li contatteremo quando il vostro conto sarà attivato o se abbiamo bisogno di più informazioni.";
		$text['emailsubject'] = "Domanda di registrazione di nuovo utisateur TNG";
		$text['emailmsg'] = "Avete ricevuto una nuova domanda di conto utilizzatore TNG. Volete collegare alla sezione amministrazione di TNG ed accordare le autorizzazioni adeguate a questo nuovo conto. Se approvate questa registrazione, volete informare il richiedente rispondendo questo a message.";
		//changed in 5.0.0
		$text['enteremail'] = "Volete introdurre un indirizzo posta elettronica valida.";
		$text['website'] = "Sito web";
		$text['nologin'] = "Non avete profilo di collegamento?";
		$text['loginsent'] = "I vostri dati di collegamento sono stati inviati";
		$text['loginnotsent'] = "I vostri dati di collegamento non sono stati inviati";
		$text['enterrealname'] = "volete entrare il vostro vero nome.";
		$text['rempass'] = "Restate collegati su quest'elaboratore";
		$text['morestats'] = "Statistiche addizionali";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTE:</strong> In order to receive mail from the site administrator regarding your account, please make sure that you are not blocking mail from this domain.";
		$text['newpassword'] = "Nuovo Parola d'ordine";
		$text['resetpass'] = "Rimettere a posto il vostro Parola d'ordine";
		//added in 6.1.0
		$text['nousers'] = "Questa forma non può essere usata fino a che almeno un utente record non esista. Se siete il proprietario del luogo, vada prego agli utenti di Admin / generare il vostro cliente del coordinatore.";
		//added in 7.0.0
		$text['noregs'] = "Siamo spiacenti, ma non stiamo accettando i nuovi registri di utente attualmente. Seli metta in <a href=\"suggest.php\">contatto</a> con prego direttamente se avete le osservazioni o domande per quanto riguarda qualche cosa su questo luogo.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Quantità";
		$text['totindividuals'] = "Numero totale di individui";
		$text['totmales'] = "Totale uomini";
		$text['totfemales'] = "Totale donne";
		$text['totunknown'] = "Totale sesso sconosciuto";
		$text['totliving'] = "Totale individui in vita";
		$text['totfamilies'] = "Totale famiglie";
		$text['totuniquesn'] = "Totale nomi di famiglia unici";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Totale fonti";
		$text['avglifespan'] = "Durata di vita media";
		$text['earliestbirth'] = "Nascita più vecchia";
		$text['longestlived'] = "Vita più lunga";
		$text['years'] = "Anni";
		$text['days'] = "Giorni";
		$text['age'] = "Età";
		$text['agedisclaimer'] = "i calcoli legati all'età sono basati sugli individui con una data di nascita conosciuta ed una data di decessi. A causa dell'esistenza di dati incomplete(p.e. una data di decessi registrata come \"1945 \" o \"avt 1860 \"), questi calcoli non sono precisi al 100%.";
		$text['treedetail'] = "Più informazione su quest'albero";
		//added in 6.0.0
		$text['total'] = "Totale";
		break;

	case "notes":
		$text['browseallnotes'] = "Mostrare tutte le note";
		break;

	case "help":
		$text['menuhelp'] = "Chiave del frammento";
		break;

	case "install":
		$text['perms'] = "I permessi tutti sono stati fissati.";
		$text['noperms'] = "I permessi non hanno potuto essere fissati per queste lime:";
		$text['manual'] = "Prego regolato loro manualmente.";
		$text['folder'] = "Dispositivo di piegatura";
		$text['created'] = "è stato generato";
		$text['nocreate'] = "non ha potuto essere generato. Generilo prego manualmente.";
		$text['infosaved'] = "Le informazioni conservate, il collegamento hanno verificato!";
		$text['tablescr'] = "Le tabelle sono state generate!";
		$text['notables'] = "Le seguenti tabelle non hanno potuto essere generate:";
		$text['nocomm'] = "TNG non sta comunicando con la vostra base di dati. Nessuna tabella è stata generata.";
		$text['newdb'] = "Le informazioni conservate, il collegamento verificato, nuova base di dati hanno generato:";
		$text['noattach'] = "Le informazioni hanno risparmiato. Il collegamento fatto e la base di dati generata, ma TNG non possono attaccare ad esso.";
		$text['nodb'] = "Le informazioni hanno risparmiato. Il collegamento fatto, ma la base di dati non esiste e non potrebbe essere generata qui. Verifichi prego che il nome di base di dati sia corretto, o usi il vostro quadro di controllo per generarlo.";
		$text['noconn'] = "Le informazioni conservate ma il collegamento sono venuto a mancare. Uno o piÃ¹ di quanto segue sono errati:";
		$text['exists'] = "Esiste";
		$text['loginfirst'] = "Dovete entrare in primo luogo.";
		$text['noop'] = "Nessun funzionamento è stato realizzato.";
		break;
}

//common
$text['matches'] = "Risultati";
$text['description'] = "Descrizione";
$text['notes'] = "Note";
$text['status'] = "Statuto";
$text['newsearch'] = "Nuova ricerca";
$text['pedigree'] = "Albero";
$text['birthabbr'] = "n.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Vedere fotografia";
$text['andlocation'] = "& luogo";
$text['accessedby'] = "consultato da";
$text['go'] = "OK";
$text['family'] = "Famiglia";
$text['children'] = "Figlie";
$text['tree'] = "Albero";
$text['alltrees'] = "Tutti gli alberi";
$text['nosurname'] = "[nessun cognome]";
$text['thumb'] = "Etichetta";
$text['people'] = "Persone";
$text['title'] = "Titolo";
$text['suffix'] = "Suffisso";
$text['nickname'] = "Soprannome";
$text['deathabbr'] = "dec.";
$text['lastmodified'] = "Ultimo modif.";
$text['married'] = "Sposato";
//$text['photos'] = "Photos";
$text['name'] = "Nome";
$text['lastfirst'] = "Nome, nome dato(i)";
$text['bornchr'] = "Nato/battezzato";
$text['individuals'] = "Persone";
$text['families'] = "Famiglie";
$text['personid'] = "ID persona";
$text['sources'] = "Fonti";
$text['unknown'] = "Sconosciuto";
$text['father'] = "Padre";
$text['mother'] = "Madre";
$text['born'] = "Nato(a)";
$text['christened'] = "Battezzato(a)";
$text['died'] = "Morto(a)";
$text['buried'] = "Sepolto(a)";
$text['spouse'] = "Coniuge";
$text['parents'] = "Genitori";
$text['text'] = "Testo";
$text['language'] = "Lingua";
$text['burialabbr'] = "Sep.";
$text['descendchart'] = "Discendenti";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Persone";
$text['edit'] = "Pubblicare";
$text['date'] = "Data";
$text['place'] = "Luogo";
$text['login'] = "Collegarsi";
$text['logout'] = "Staccarsi";
$text['marrabbr'] = "Mar.";
$text['groupsheet'] = "Strato familiare";
$text['text_and'] = "e";
$text['generation'] = "Generazione";
$text['filename'] = "Nome d'archivio";
$text['id'] = "ID";
$text['search'] = "Cercare";
$text['living'] = "In vita";
$text['user'] = "Utilizzatore";
$text['firstname'] = "Primo nome";
$text['lastname'] = "Cognome";
$text['searchresults'] = "Risultati della ricerca";
$text['diedburied'] = "Deceduto/inumato";
$text['homepage'] = "Pagina d'accoglienza";
$text['find'] = "Ricercare...";
$text['relationship'] = "Relazione";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Linea del tempo";
$text['yesabbr'] = "Si";
$text['divorced'] = "Divorziato";
$text['indlinked'] = "Legato a";
$text['branch'] = "Ramo";
$text['moreind'] = "Più individui";
$text['morefam'] = "Più famiglie";
$text['livingdoc'] = "almeno un individuo vivo è legato a questo documento - Dettagli nascosti.";
$text['source'] = "Fonte";
$text['surnamelist'] = "Lista dei cognome";
$text['generations'] = "Generazioni";
$text['refresh'] = "Rinfrescare";
$text['whatsnew'] = "Che di nuovo?";
$text['reports'] = "Ripporti";
$text['placelist'] = "Lista di luoghi";
$text['baptizedlds'] = "Battezzato (LDS)";
$text['endowedlds'] = "Dotato (LDS)";
$text['sealedplds'] = "Dotato genitori (LDS)";
$text['sealedslds'] = "Coniuge dotato (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Antenati";
$text['descendants'] = "Discendenti";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Data dell'ultima importazione GEDCOM";
$text['type'] = "Tipo";
$text['savechanges'] = "Registrare le modifiche";
$text['familyid'] = "ID famiglia";
$text['headstone'] = "Lapidi";
$text['historiesdocs'] = "Storie";
$text['livingnote'] = "Almeno una persona viva è legata a questa nota - i dettagli non sono dunque pubblicati.";
$text['anonymous'] = "Anonimo";
$text['places'] = "Luoghi";
$text['anniversaries'] = "Data e Anniversario";
$text['administration'] = "Amministrazione";
$text['help'] = "Aiuto";
//$text['documents'] = "Documents";
$text['year'] = "Anno";
$text['all'] = "Tutti";
$text['repository'] = "Deposito";
$text['address'] = "Indirizzo";
$text['suggest'] = "Proposta";
$text['editevent'] = "Suggerite una modifica per quest'evento";
$text['findplaces'] = "Trovate tutti gli individui con un evento in questo luogo";
$text['morelinks'] = "Più legami";
$text['faminfo'] = "Informazione sulla famiglia";
$text['persinfo'] = "Informazione Personelle";
$text['srcinfo'] = "Info. sulla fonte";
$text['fact'] = "Fatto";
$text['goto'] = "Scegliete una pagina";
$text['tngprint'] = "Stampare";
//changed in 6.0.0
$text['livingphoto'] = "Almeno un individuo vivo è legato a questa fotografia - Dettagli nascosti.";
$text['databasestatistics'] = "Statistiche della base di dati";
//moved here in 6.0.0
$text['child'] = "Bambino";
$text['repoinfo'] = "Info. luogo di deposito";
$text['tng_reset'] = "Rimettere a zero";
$text['noresults'] = "Nulla risultato";
//added in 6.0.0
$text['allmedia'] = "Tutti Media";
$text['repositories'] = "Deposito";
$text['albums'] = "Album";
$text['cemeteries'] = "Cimiteri";
$text['surnames'] = "Cognome";
$text['dates'] = "Data";
$text['link'] = "Collegare";
$text['media'] = "Media";
$text['gender'] = "Genere";
$text['latitude'] = "Latitudine";
$text['longitude'] = "Longitudine";
$text['bookmarks'] = "Bookmark";
$text['bookmark'] = "Aggiungi Bookmark";
$text['mngbookmarks'] = "Andare a Bookmarks";
$text['bookmarked'] = "Bookmark Aggiungiato";
$text['remove'] = "Togliere";
$text['find_menu'] = "Trovare";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Cimiteri";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Mappa Evento ";
$text['gevents'] = "Evento";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Collegamento a Google Earth";
$text['googlemaplink'] = "Collegamento a Google Maps";
$text['gmaplegend'] = "Perno Leggenda";
//moved here in 7.0.0
$text['unmarked'] = "Non segnata (s)";
$text['located'] = "Situato(i)";
//added in 7.0.0
$text['albclicksee'] = "Scatti per vedere tutti gli articoli in questo album";
$text['notyetlocated'] = "Non ancora individuato";
$text['cremated'] = "Cremato";
$text['missing'] = "Perso";
$text['page'] = "Pagina";
$text['pdfgen'] = "Generatore del PDF";
$text['blank'] = "Tabella in bianco";
$text['none'] = "Nulla";
$text['fonts'] = "Fonti";
$text['header'] = "Intestazione";
$text['data'] = "Dati";
$text['pgsetup'] = "Messa a punto di pagina";
$text['pgsize'] = "Formato di pagina";
$text['letter'] = "Lettera";
$text['legal'] = "Legale";
$text['orient'] = "Orientamento";
$text['portrait'] = "Ritratto";
$text['landscape'] = "Paesaggio";
$text['tmargin'] = "Margine superiore";
$text['bmargin'] = "Margine inferiore";
$text['lmargin'] = "Margine di sinistra";
$text['rmargin'] = "Margine di destra";
$text['createch'] = "Generi la tabella";
$text['prefix'] = "Prefisso";
$text['mostwanted'] = "La maggior parte hanno voluto";
$text['latupdates'] = "Aggiornamenti ultimi";
$text['featphoto'] = "Foto descritta";
$text['news'] = "Notizie";
$text['ourhist'] = "La nostra storia di famiglia";
$text['ourhistanc'] = "Nostre storia di famiglia ed ascendenza";
$text['ourpages'] = "Le nostre pagine di genealogia della famiglia";
$text['pwrdby'] = "Questo luogo alimentato da";
$text['writby'] = "scritto da";
$text['searchtngnet'] = "Rete di ricerca TNG (GENDEX)";
$text['viewphotos'] = "Osservi tutte le foto";
$text['anon'] = "Siete attualmente anonimo";
$text['whichbranch'] = "Quale ramo siete?";
$text['featarts'] = "Articoli speciali";
$text['maintby'] = "Effettuato da";
$text['createdon'] = "Generato sopra";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Pagina d'Accoglienza";
$text['mnusearchfornames'] = "Cercare nomi";
$text['mnulastname'] = "Cognome";
$text['mnufirstname'] = "Primo nome";
$text['mnusearch'] = "Cercare";
$text['mnureset'] = "Ricominciare";
$text['mnulogon'] = "Collegarsi";
$text['mnulogout'] = "Staccarsi";
$text['mnufeatures'] = "Altre funzioni";
$text['mnuregister'] = "Chiedere un conto utilizzatore";
$text['mnuadvancedsearch'] = "Ricerca Avanzata";
$text['mnulastnames'] = "Cognome";
$text['mnustatistics'] = "Statistici";
$text['mnuphotos'] = "Fotografie";
$text['mnuhistories'] = "Storie";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Cimiteri";
$text['mnutombstones'] = "Lapidi";
$text['mnureports'] = "Rapporti";
$text['mnusources'] = "Fonti";
$text['mnuwhatsnew'] = "Che di nuovo?";
$text['mnushowlog'] = "Giornale d'Accesso";
$text['mnulanguage'] = "Cambiare lingua";
$text['mnuadmin'] = "Amministrazione";
$text['welcome'] = "Benvenuti";
$text['contactus'] = "Contattiamo";

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
