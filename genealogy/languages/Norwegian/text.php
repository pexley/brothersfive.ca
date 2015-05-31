<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Søk i alle kilder";
		$text['shorttitle'] = "Tittel";
		$text['callnum'] = "Call Number";
		$text['author'] = "Forfatter";
		$text['publisher'] = "Utgiver";
		$text['other'] = "Andre informasjoner";
		$text['sourceid'] = "Kilde ID";
		$text['moresrc'] = "Flere kilder";
		$text['repoid'] = "Oppbevaringssted ID";
		$text['browseallrepos'] = "Søk alle oppbevaringssted";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nytt språk";
		$text['changelanguage'] = "Bytt språk";
		$text['languagesaved'] = "Språk lagret";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM starter fra";
		$text['producegedfrom'] = "Lag en GEDCOM fil fra";
		$text['numgens'] = "Antall generasjoner";
		$text['includelds'] = "Inkluder LDS informajon";
		$text['buildged'] = "Lag GEDCOM";
		$text['gedstartfrom'] = "GEDCOM starter fra";
		$text['nomaxgen'] = "Du må angi antall generasjoner. Bruk Back-knappen for å rette opp feilen";
		$text['gedcreatedfrom'] = "GEDCOM laget fra";
		$text['gedcreatedfor'] = "laget for";
		$text['enteremail'] = "Skriv inn en gyldig epost-adresse.";
		$text['creategedfor'] = "Lag GEDCOM";
		$text['email'] = "Epost-adresse";
		$text['suggestchange'] = "Foreslå en forandring";
		$text['yourname'] = "Ditt navn";
		$text['comments'] = "Kommentarer";
		$text['comments2'] = "Kommentarer";
		$text['submitsugg'] = "Send forslag";
		$text['proposed'] = "Foreslått endring";
		$text['mailsent'] = "Takk. Din beskjed er sendt.";
		$text['mailnotsent'] = "Vi beklager, men beskjeden kunne ikke bli levert. Vennligst kontakt xxx direkte på yyy.";
		$text['mailme'] = "Send en kopi til denne adressen";
		//added in 5.0.5
		$text['entername'] = "Skriv inn ditt navn";
		$text['entercomments'] = "Skriv dine kommentarer";
		$text['sendmsg'] = "Send Message";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Bilder og historier";
		$text['indinfofor'] = "Individell info om";
		$text['reliability'] = "Troverdighet";
		$text['pp'] = "pp.";
		$text['age'] = "Alder";
		$text['agency'] = "Firma";
		$text['cause'] = "Årsak";
		$text['suggested'] = "Foreslått";
		$text['closewindow'] = "Lukk vinduet";
		$text['thanks'] = "Takk";
		$text['received'] = "Ditt forslag er sendt til Admin for vurdering.";
		//added in 6.0.0
		$text['association'] = "Assosiasjon";
		//added in 7.0.0
		$text['indreport'] = "Individual Report";
		$text['indreportfor'] = "Individual Report for";
		$text['general'] = "General";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Beregning av slektskap";
		$text['findrel'] = "Finn slektskap";
		$text['person1'] = "Person 1:";
		$text['person2'] = "Person 2:";
		$text['calculate'] = "Beregn";
		$text['select2inds'] = "Vennligst velg to personer.";
		$text['findpersonid'] = "Finn personID";
		$text['enternamepart'] = "angi del av fornavn og/eller etternavn";
		$text['pleasenamepart'] = "Anngi en del av fornavn eller etternavn.";
		$text['clicktoselect'] = "klikk for å velge";
		$text['nobirthinfo'] = "Ingen informasjon om fødsel";
		$text['relateto'] = "Slektskap til";
		$text['sameperson'] = "De to personene er samme person.";
		$text['notrelated'] = "De to personene er ikke i slektskap innen xxx generasjoner.";
		$text['findrelinstr'] = "For å vise slektskap mellom to personer, bruk \\'Finn\\'-knappene nedenfor til å angi  to personer (eller behold viste personer, hvis relevante), klikk deretter på \\'Beregn\\'.";
		$text['gencheck'] = "Maks antall generasjoner<br />å sjekke";
		$text['sometimes'] = "(Noen ganger kan en ved å sjekke et annet antall generasjoner, få et annet resultat.)";
		$text['findanother'] = "Finn andre slektskap";
		//added in 6.0.0
		$text['brother'] = "bror til";
		$text['sister'] = "søster til";
		$text['sibling'] = "søsken til";
		$text['uncle'] = "xxx onkel til";
		$text['aunt'] = "xxx tante til";
		$text['uncleaunt'] = "xxx onkel/tante til";
		$text['nephew'] = "xxx nevø til";
		$text['niece'] = "xxx niese til";
		$text['nephnc'] = "xxx nevø/niese til";
		$text['mcousin'] = "xxx kusine til";
		$text['fcousin'] = "xxx kusine til";
		$text['cousin'] = "xxx kusine til";
		$text['removed'] = "ganger forskjøvet";
		$text['rhusband'] = "ektemann til ";
		$text['rwife'] = "kone til ";
		$text['rspouse'] = "ektefelle til ";
		$text['son'] = "sønn til";
		$text['daughter'] = "datter til";
		$text['rchild'] = "barn til";
		$text['sil'] = "svigersønn til";
		$text['dil'] = "svigerdatter til";
		$text['sdil'] = "svigersønn eller svigerdatter til";
		$text['gson'] = "xxx barnebarn til";
		$text['gdau'] = "xxx barnebarn til";
		$text['gsondau'] = "xxx barnebarn til";
		$text['great'] = "great";
		$text['spouses'] = "er ektefeller";
		$text['is'] = "er";
		//changed in 6.0.0
		$text['changeto'] = "Bytt til:";
		//added in 6.0.0
		$text['notvalid'] = "er ikke et gyldig ID-nummer i denne databasen. Forsøk igjen.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Familieskjema for";
		$text['ldsords'] = "LDS Ordinasjon";
		$text['baptizedlds'] = "Døpt (LDS)";
		$text['endowedlds'] = "Velsignet (LDS)";
		$text['sealedplds'] = "Bekreftet P (LDS)";
		$text['sealedslds'] = "Bekreftet S (LDS)";
		$text['otherspouse'] = "Andre ektefeller";
		//changed in 7.0.0
		$text['husband'] = "Mann";
		$text['wife'] = "Hustru";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "F";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "G";
		$text['capplaceabbr'] = "P";
		$text['capmarrabbr'] = "G";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Tegn på nytt med";
		$text['scrollnote'] = "NB: Du må kanskje bla ned for å se hele treet.";
		$text['unknownlit'] = "Ukjent";
		$text['popupnote1'] = " = Tilleggsinformasjon";
		$text['popupnote2'] = " = Nytt anetre";
		$text['pedcompact'] = "Kompakt";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Bare Tekst";
		$text['descendfor'] = "Etterkommere av";
		$text['maxof'] = "Maksimum";
		$text['gensatonce'] = "generasjoner vist samtidig.";
		$text['sonof'] = "sønn av";
		$text['daughterof'] = "datter av";
		$text['childof'] = "barn av";
		$text['stdformat'] = "Standard Format";

		$text['ahnentafel'] = "Generasjonsliste";
		$text['addnewfam'] = "Legg til ny familie";
		$text['editfam'] = "Rediger familie";
		$text['side'] = "Side";
		$text['familyof'] = "Familie til";
		$text['paternal'] = "Far";
		$text['maternal'] = "Mor";
		$text['gen1'] = "Selv";
		$text['gen2'] = "Foreldre";
		$text['gen3'] = "Besteforeldre";
		$text['gen4'] = "Oldeforeldre";
		$text['gen5'] = "Tippoldeforeldre";
		$text['gen6'] = "Tipptipp-oldeforeldre";
		$text['gen7'] = "3.tipp-oldeforeldre";
		$text['gen8'] = "4.tipp-oldeforeldre";
		$text['gen9'] = "5.tipp-oldeforeldre";
		$text['gen10'] = "6.tipp-oldeforeldre";
		$text['gen11'] = "7.tipp-oldeforeldre";
		$text['gen12'] = "8.tipp-oldeforeldre";
		$text['graphdesc'] = "Etterslektstre til dette punkt";
		$text['collapse'] = "Kollaps";
		$text['expand'] = "Ekspander";
		$text['pedbox'] = "Boks";
		//changed in 6.0.0
		$text['regformat'] = "Generasjon Format";
		$text['extrasexpl'] = "Dersom bilder eller historier finnes for denne personen, vil et ikon vises sammen med navnet.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nytt skjema";
		$text['mediaavail'] = "Tilgjengelig media";
		//changed in 7.0.0
		$text['pedigreefor'] = "Anetre for";
		//added in 7.0.0
		$text['pedigreech'] = "Anetre";
		$text['datesloc'] = "Datoer og steder";
		$text['borchr'] = "Fødsel/Alt - Død/Gravlagt (to)";
		$text['nobd'] = "Ingen datoer for fødsel eller død";
		$text['bcdb'] = "Fødsel/Alt/Død/Gravlagt (fire)";
		$text['numsys'] = "Nummer-system";
		$text['gennums'] = "Generation Nummer";
		$text['henrynums'] = "Henry Nummer";
		$text['abovnums'] = "d'Aboville Nummer";
		$text['devnums'] = "de Villiers Nummer";
		$text['dispopts'] = "Visning";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "Det er ingen rapporter.";
		$text['reportname'] = "Rapport-navn";
		$text['allreports'] = "Alle rapporter";
		$text['report'] = "Rapport";
		$text['error'] = "Feil";
		$text['reportsyntax'] = "Syntaksen for spørringen til denne rapporten";
		$text['wasincorrect'] = "var feil, og spørringen kunne derfor ikke bli kjørt. Vennligst kontakt system administrator på";
		$text['query'] = "Spørring";
		$text['errormessage'] = "Feilmelding";
		$text['equals'] = "lik";
		$text['contains'] = "inneholder";
		$text['startswith'] = "starter med";
		$text['endswith'] = "slutter med";
		$text['soundexof'] = "soundex av";
		$text['metaphoneof'] = "metaphone av";
		$text['plusminus10'] = "+/- 10 år";
		$text['lessthan'] = "mindre enn";
		$text['greaterthan'] = "større enn";
		$text['lessthanequal'] = "mindre enn eller lik";
		$text['greaterthanequal'] = "større enn eller lik";
		$text['equalto'] = "lik";
		$text['tryagain'] = "Vennligst forsøk igjen";
		$text['text_for'] = "for";
		$text['searchnames'] = "Søk etter navn";
		$text['joinwith'] = "kombiner med";
		$text['cap_and'] = "AND";
		$text['cap_or'] = "OR";
		$text['showspouse'] = "Vis ektefelle (r)";
		$text['submitquery'] = "Start søk";
		$text['birthplace'] = "Fødested";
		$text['deathplace'] = "Død (sted)";
		$text['birthdatetr'] = "Født år";
		$text['deathdatetr'] = "Død år";
		$text['plusminus2'] = "+/- 2 år";
		$text['resetall'] = "Tøm alle felt";

		$text['showdeath'] = "Vis informasjon om død/begravelse,";
		$text['altbirthplace'] = "Født sted";
		$text['altbirthdatetr'] = "Døpt sted";
		$text['burialplace'] = "Gravlagt sted";
		$text['burialdatetr'] = "Gravlagt år";
		$text['event'] = "Hendelse(r)";
		$text['day'] = "Dag";
		$text['month'] = "Måned";
		$text['keyword'] = "Nøkkelord (f.eks., \"Abt\")";
		$text['explain'] = "Skriv del av dato for å finne samenfallende hendelser. La feltet være tomt for å se treff på alle.";
		$text['enterdate'] = "Skriv inn eller velg minst ett av følgende: dag, måned, år, nøkkelord";
		$text['fullname'] = "Fullt navn";
		$text['birthdate'] = "Født dato";
		$text['altbirthdate'] = "Døpt dato";
		$text['marrdate'] = "Gift dato";
		$text['spouseid'] = "Ektefelle\\'s ID";
		$text['spousename'] = "Ektefelle\\'s navn";
		$text['deathdate'] = "Død dato";
		$text['burialdate'] = "Gravlagt dato";
		$text['changedate'] = "Sist endret dato";
		$text['gedcom'] = "Tre";
		$text['baptdate'] = "Dåp dato (LDS)";
		$text['baptplace'] = "Dåp sted (LDS)";
		$text['endldate'] = "Velsignelse dato (LDS)";
		$text['endlplace'] = "Velsignelse sted (LDS)";
		$text['ssealdate'] = "Bekreftet dato S (LDS)";
		$text['ssealplace'] = "Bekreftet sted S (LDS)";
		$text['psealdate'] = "Bekreftet dato P (LDS)";
		$text['psealplace'] = "Bekreftet sted P (LDS)";
		$text['marrplace'] = "Gift sted";
		$text['spousesurname'] = "Ektefelle\\'s etternavn";
		//changed in 6.0.0
		$text['spousemore'] = "Dersom du skriver inn \\'Ektefelle\\'s etternavn\\'e, må du i tillegg fylle inn minst ett felt til.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 år fra";
		$text['exists'] = "eksisterer";
		$text['dnexist'] = "eksisterer ikke";
		//added in 6.0.3
		$text['divdate'] = "Skilt Dato";
		$text['divplace'] = "Skilt Sted";
		//changed in 7.0.0
		$text['otherevents'] = "Andre hendelser";
		//added in 7.0.0
		$text['numresults'] = "Resultat per side";
		$text['mysphoto'] = "Ukjente Photo";
		$text['mysperson'] = "Ikke identifisert";
		$text['joinor'] = "Valget 'slå sammen med OR' kan ikke brukes med ektefelle's etternavn";
		//added in 7.0.1
		$text['tellus'] = "Tell us what you know";
		$text['moreinfo'] = "More Information:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Logg for";
		$text['mostrecentactions'] = "Siste hendelser";
		$text['autorefresh'] = "Automatisk oppdatering (30 sekunder)";
		$text['refreshoff'] = "Slå av automatisk oppdatering";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Kirkegårder og gravstener";
		$text['showallhsr'] = "Vis alle gravstener";
		$text['in'] = "i";
		$text['showmap'] = "Vis kart";
		$text['headstonefor'] = "Gravsten til";
		$text['photoof'] = "Bilde av";
		$text['firstpage'] = "Første side";
		$text['lastpage'] = "Siste side";
		$text['photoowner'] = "Foto/kilde";

		$text['nocemetery'] = "Ingen kirkegårder";
		$text['iptc005'] = "Tittel";
		$text['iptc020'] = "Supp. kategorier";
		$text['iptc040'] = "Spesielle instrukser";
		$text['iptc055'] = "Lagret dato";
		$text['iptc080'] = "Forfatter";
		$text['iptc085'] = "Forfatter\\'s stilling";
		$text['iptc090'] = "By";
		$text['iptc095'] = "Stat/Fylke";
		$text['iptc101'] = "Land";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Overskrift";
		$text['iptc110'] = "Kilde";
		$text['iptc115'] = "Bilde kilde";
		$text['iptc116'] = "Copyright";
		$text['iptc120'] = "Bildetekst";
		$text['iptc122'] = "Bildetekst skrevet av";
		$text['mapof'] = "Kart over";
		$text['regphotos'] = "Beskrivelse";
		$text['gallery'] = "Kun \\'frimerkebilder\\'";
		$text['cemphotos'] = "Kirkegård bilder";
		//changed in 6.0.0
		$text['photosize'] = "Størrelse";
		//added in 6.0.0
        	$text['iptc010'] = "Prioritet";
		$text['filesize'] = "Fil-størrelse";
		$text['seeloc'] = "Se lokasjon";
		$text['showall'] = "Vis alle";
		$text['editmedia'] = "Rediger media";
		$text['viewitem'] = "Se på dette";
		$text['editcem'] = "Rediger kirkegård";
		$text['numitems'] = "# enheter";
		$text['allalbums'] = "Alle album";
		//added in 6.1.0
		$text['slidestart'] = "Start Slide Show";
		$text['slidestop'] = "Pause Slide Show";
		$text['slideresume'] = "Fortsett Slide Show";
		$text['slidesecs'] = "Sekunder for hvert bilde:";
		$text['minussecs'] = "minus 0.5 sekunder";
		$text['plussecs'] = "pluss 0.5 sekunder";
		//added in 7.0.0
		$text['nocountry'] = "Ukjent land";
		$text['nostate'] = "Ukjent stat";
		$text['nocounty'] = "Ukjent fylke";
		$text['nocity'] = "Ukjent by";
		$text['nocemname'] = "Ukjent kirkegård";
		$text['plot'] = "Felt";
		$text['location'] = "Lokasjon";
		$text['editalbum'] = "Rediger Album";
		$text['mediamaptext'] = "<strong>Note:</strong> Beveg muspekeren over bildet for å vise navnet. Klikk for å vise en side for hvert navn.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Vis etternavn som starter med";
		$text['showtop'] = "Vis toppen";
		$text['showallsurnames'] = "Vis alle Etternavn";
		$text['sortedalpha'] = "sortert alfabetisk";
		$text['byoccurrence'] = "sortert etter frekvens";
		$text['firstchars'] = "Første bokstav";
		$text['top'] = "Topp";
		$text['mainsurnamepage'] = "Etternavn-side";
		$text['allsurnames'] = "Alle Etternavn";
		$text['showmatchingsurnames'] = "Klikk på et Etternavn for å se data.";
		$text['backtotop'] = "Tilbake til toppen";
		$text['beginswith'] = "Begynner med";
		$text['allbeginningwith'] = "Alle etternavn som begynner med";
		$text['numoccurrences'] = "frekvensen i parantes";
		$text['placesstarting'] = "Vis største område som starter med";
		$text['showmatchingplaces'] = "Klikk på et sted for å vise et snevrere område. Klikk på søke-ikonet for å vise korresponderende personer.";
		$text['totalnames'] = "totalt antall personer";
		$text['showallplaces'] = "Vis alle steder av størst geografisk omfang";
		$text['totalplaces'] = "totalt antall steder";
		$text['mainplacepage'] = "Steder\\'s hovedside";
		$text['allplaces'] = "Alle steder av størst geografisk omfang";
		$text['placescont'] = "Vis alle steder som inneholder";
		//added in 7.0.0
		$text['top30'] = "Topp 30 etternavn";
		$text['top30places'] = "Topp 30 største lokaliteter";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(siste xx dagene)";
		$text['historiesdocs'] = "Historier";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Bilder";
		$text['history'] = "Historie/Dokument";
		//changed in 7.0.0
		$text['husbid'] = "Ektemann\\'s ID";
		$text['husbname'] = "Ektemann\\'s Navn";
		$text['wifeid'] = "Hustru ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Slett";
		$text['addperson'] = "Legg til person";
		$text['nobirth'] = "Følgende person har ikke gyldig fødselsdato og kan derfor ikke oppdateres";
		$text['noliving'] = "Følgende person er merket som levende og kan ikke oppdateres fordi du ikke er logget inn med nødvendige tillatelser";
		$text['event'] = "Hendelse(r)";
		$text['chartwidth'] = "Skjema-bredde";
		//changed in 6.0.0
		$text['timelineinstr'] = "Legg til inntil fire personer ved å legge inn deres ID i feltene under:";
		//added in 6.0.0
		$text['togglelines'] = "Bytt mellom linjene";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Søk i alle trær";
		$text['treename'] = "Navn på tre";
		$text['owner'] = "Eier";
		$text['address'] = "Adresse";
		$text['city'] = "By";
		$text['state'] = "Stat/Fylke";
		$text['zip'] = "Postnummer";
		$text['country'] = "Land";
		$text['email'] = "Epost-adresse";
		$text['phone'] = "Telefon";
		$text['username'] = "Brukernavn";
		$text['password'] = "Passord";
		$text['loginfailed'] = "Feil ved pålogging.";

		$text['regnewacct'] = "Registrer ny bruker";
		$text['realname'] = "Fullt navn";
		$text['phone'] = "Telefon";
		$text['email'] = "Epost-adresse";
		$text['address'] = "Adresse";
		$text['comments'] = "Kommentarer";
		$text['submit'] = "Send";
		$text['leaveblank'] = "(la være åpent hvis du ønsker et nytt tre)";
		$text['required'] = "Obligatoriske felt";
		$text['enterpassword'] = "Angi et passord.";
		$text['enterusername'] = "Angi brukernavn.";
		$text['failure'] = "Beklager, men brukernavnet du oppgav er allerede i bruk. Bruk tilbake-tasten og velg et annet brukernavn.";
		$text['success'] = "Tusen takk. Vi har mottatt din registrering. Vi tar kontakt når din konto er aktivert eller hvis vi trenger mer informasjon.";
		$text['emailsubject'] = "Forespørsel om ny TNG brukerkonto";
		$text['emailmsg'] = "Du har mottatt en forespørsel om en ny TNG brukerkonto. Logg inn i TNG Adminstrasjonsområde og tildel nødvendige tillatelser for den nye brukeren. Dersom du godkjenner denne registreringen må du gi beskjed til søker ved å svare på denne meldingen.";
		$text['enteremail'] = "Skriv inn en gyldig epost-adresse.";
		$text['website'] = "Hjemmeside";
		$text['nologin'] = "Har ikke brukernavn ?";
		$text['loginsent'] = "Dine påloggings-info er sendt";
		$text['loginnotsent'] = "Dine påloggings-info er ikke sendt";
		$text['enterrealname'] = "Skriv ditt navn.";
		$text['rempass'] = "Fortsett å være innlogget";
		$text['morestats'] = "Mere statistikk";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTE:</strong> For å kunne motta epost fra Administrator, må du påse at du ikke blokkerer epost fra dette domenet.";
		$text['newpassword'] = "Nytt passord";
		$text['resetpass'] = "Tilbakestill passordet ditt";
		//added in 6.1.0
		$text['nousers'] = "Dette skjema kan ikke brukes før minst en brukerkonto er opprettet. Dersom du har admin-rettigheter, gå til Admin/Brukere for å opprette din Administrator-konto.";
		//added in 7.0.0
		$text['noregs'] = "Beklager, men vi tar ikke imot flere brukere for øyeblikket. Vennligst <a href=\"suggest.php\">ta kontakt</a> direkte hvis du har noen kommentarer.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Kvantitet";
		$text['totindividuals'] = "Antall personer";
		$text['totmales'] = "Antall menn";
		$text['totfemales'] = "Antall kvinner";
		$text['totunknown'] = "Antall ukjent kjønn";
		$text['totliving'] = "Antall levende";
		$text['totfamilies'] = "Antall familier";
		$text['totuniquesn'] = "Antall unike etternavn";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Antall kilder";
		$text['avglifespan'] = "Gjennomsnittlig levetid";
		$text['earliestbirth'] = "Tidligste fødselsdag";
		$text['longestlived'] = "Lengstlevende";
		$text['years'] = "år";
		$text['days'] = "dager";
		$text['age'] = "Alder";
		$text['agedisclaimer'] = "Aldersrelaterte beregninger er basert på personer registrert med fødselsdato <EM>og</EM> dato for død.  Grunnet felter med ukomplette datoer (f.eks, dødsdato skrevet som \"1945\" eller \"BEF 1860\"), kan disse beregningene ikke være 100% nøyaktige.";
		$text['treedetail'] = "Mere informasjon om dette slektstreet";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Søk i alle notater";
		break;

	case "help":
		$text['menuhelp'] = "Meny nøkkel";
		break;

	case "install":
		$text['perms'] = "Alle rettigheter er satt.";
		$text['noperms'] = "Rettigheter kunne ikke bli satt for disse filene:";
		$text['manual'] = "Vennligst sett de manuelt.";
		$text['folder'] = "Mappe";
		$text['created'] = "har blitt opprettet";
		$text['nocreate'] = "kunne ikke opprettes. Vennligst opprett manuelt.";
		$text['infosaved'] = "Informasjon lagret, forbindelse bekreftet!";
		$text['tablescr'] = "Tabellene har blitt opprettet!";
		$text['notables'] = "Følgende tabeller kunne ikke bli opprettet:";
		$text['nocomm'] = "TNG har ikke kontakt med databasen. Ingen tabeller ble opprettet.";
		$text['newdb'] = "Informasjon lagret, forbindelse bekreftet, ny database opprettet:";
		$text['noattach'] = "Informasjon lagret. Ny database opprettet, men TNG kan ikke kople seg til.";
		$text['nodb'] = "Informasjon lagret. Koplet til, men databasen finnes ikke og kan ikke bli opprettet. Vennligst bekreft at navnet på databasen er korrekt, eller bruk 'cpanel'for å opprette den.";
		$text['noconn'] = "Informasjon lagret men forbindelsen sviktet. En eller flere av følgende er feil:";
		$text['exists'] = "eksisterer";
		$text['loginfirst'] = "Du må først logge på.";
		$text['noop'] = "Ingen ting ble gjort.";
		break;
}

//common
$text['matches'] = "Treff";
$text['description'] = "Beskrivelse";
$text['notes'] = "Notater";
$text['status'] = "Status";
$text['newsearch'] = "Nytt Søk";
$text['pedigree'] = "Anetre";
$text['birthabbr'] = "f.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Se bilde";
$text['andlocation'] = "& lokasjon";
$text['accessedby'] = "utført av";
$text['go'] = "Utfør";
$text['family'] = "Familie";
$text['children'] = "Barn";
$text['tree'] = "Tre";
$text['alltrees'] = "Alle Trær";
$text['nosurname'] = "[mangler etternavn]";
$text['thumb'] = "Ikon";
$text['people'] = "Personer";
$text['title'] = "Tittel";
$text['suffix'] = "Suffiks";
$text['nickname'] = "Kallenavn";
$text['deathabbr'] = "d.";
$text['lastmodified'] = "Sist endret";
$text['married'] = "Gift";
//$text['photos'] = "Photos";
$text['name'] = "Navn";
$text['lastfirst'] = "Etternavn, Fornavn";
$text['bornchr'] = "Født/Døpt";
$text['individuals'] = "Personer";
$text['families'] = "Familier";
$text['personid'] = "Person ID";
$text['sources'] = "Kilder";
$text['unknown'] = "Ukjent";
$text['father'] = "Far";
$text['mother'] = "Mor";
$text['born'] = "Født";
$text['christened'] = "Døpt";
$text['died'] = "Død";
$text['buried'] = "Gravlagt";
$text['spouse'] = "Ektefelle";
$text['parents'] = "Foreldre";
$text['text'] = "Tekst";
$text['language'] = "Språk";
$text['burialabbr'] = "gravl.";
$text['descendchart'] = "Etterkommere";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Egne data";
$text['edit'] = "Rediger";
$text['date'] = "Dato";
$text['place'] = "Sted";
$text['login'] = "Logg inn";
$text['logout'] = "Logg ut";
$text['marrabbr'] = "g.";
$text['groupsheet'] = "Gruppe-skjema";
$text['text_and'] = "og";
$text['generation'] = "Generasjon";
$text['filename'] = "Fil-navn";
$text['id'] = "ID";
$text['search'] = "Søk";
$text['living'] = "Lever";
$text['user'] = "Bruker";
$text['firstname'] = "Fornavn";
$text['lastname'] = "Etternavn";
$text['searchresults'] = "Søkeresultat";
$text['diedburied'] = "Død/Gravlagt";
$text['homepage'] = "Startside";
$text['find'] = "Finn...";
$text['relationship'] = "Slektskap";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Tidslinje";
$text['yesabbr'] = "J";
$text['divorced'] = "Skilt";
$text['indlinked'] = "Koblet til";
$text['branch'] = "Slektsgren";
$text['moreind'] = "Flere personer";
$text['morefam'] = "Flere familier";
$text['livingdoc'] = "Minst en levende person er knyttet til dette dokumentet - Detaljer ikke tilgjengelig.";
$text['source'] = "Kilde";
$text['surnamelist'] = "Etternavn-liste";
$text['generations'] = "Generasjoner";
$text['refresh'] = "Oppdater";
$text['whatsnew'] = "Hva skjer ?";
$text['reports'] = "Rapporter";
$text['placelist'] = "Steds-liste";
$text['baptizedlds'] = "Døpt (LDS)";
$text['endowedlds'] = "Velsignet (LDS)";
$text['sealedplds'] = "Bekreftet P (LDS)";
$text['sealedslds'] = "Bekreftet S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Aner";
$text['descendants'] = "Etterkommere";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Dato for siste GEDCOM-import";
$text['type'] = "Skriv";
$text['savechanges'] = "Lagre endringer";
$text['familyid'] = "Famile ID";
$text['headstone'] = "Gravsten";
$text['historiesdocs'] = "Historier";
$text['livingnote'] = "Minst en levende person er koplet til denne notaten - detaljer blir ikke vist.";
$text['anonymous'] = "anonymt";
$text['places'] = "Steder";
$text['anniversaries'] = "Datoer & jubileer";
$text['administration'] = "Administrasjon";
$text['help'] = "Hjelp";
//$text['documents'] = "Documents";
$text['year'] = "År";
$text['all'] = "Alle";
$text['repository'] = "Oppbevaringssted";
$text['address'] = "Adresse";
$text['suggest'] = "Foreslå";
$text['editevent'] = "Foreslå en endring av denne hendelsen";
$text['findplaces'] = "Finn alle personer med hendelser på dette stedet";
$text['morelinks'] = "Flere koplinger";
$text['faminfo'] = "Familie informasjon";
$text['persinfo'] = "Personlig informasjon";
$text['srcinfo'] = "Kilde informasjon";
$text['fact'] = "Fakta";
$text['goto'] = "Velg en side";
$text['tngprint'] = "Skriv ut";
//changed in 6.0.0
$text['livingphoto'] = "Minst en levende person er knyttet til dette bildet - Detaljer ikke tilgjengelig.";
$text['databasestatistics'] = "Database-statistikk";
//moved here in 6.0.0
$text['child'] = "Barn";
$text['repoinfo'] = "Informasjon om oppbevaringssted";
$text['tng_reset'] = "Tømm";
$text['noresults'] = "Ingen funnet";
//added in 6.0.0
$text['allmedia'] = "All Media";
$text['repositories'] = "Oppbevaringssteder";
$text['albums'] = "Album";
$text['cemeteries'] = "Kirkegårder";
$text['surnames'] = "Etternavn";
$text['dates'] = "Datoer";
$text['link'] = "Kopling";
$text['media'] = "Media";
$text['gender'] = "Kjønn";
$text['latitude'] = "Breddegrad";
$text['longitude'] = "Lengdegrad";
$text['bookmarks'] = "Bokmerke";
$text['bookmark'] = "Legg til bokmerke";
$text['mngbookmarks'] = "Gå til bokmerke";
$text['bookmarked'] = "Bokmerke lagt til";
$text['remove'] = "Fjern";
$text['find_menu'] = "Finn";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Kirkegård";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Hendelse kart";
$text['gevents'] = "Hendelse";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Link til Google Earth";
$text['googlemaplink'] = "Link til Google Maps";
$text['gmaplegend'] = "Pin Notat";
//moved here in 7.0.0
$text['unmarked'] = "Umerket";
$text['located'] = "Lokalisert";
//added in 7.0.0
$text['albclicksee'] = "Klikk for å se alt i dette album";
$text['notyetlocated'] = "Ikke lokalisert";
$text['cremated'] = "Kremert";
$text['missing'] = "Savnet";
$text['page'] = "Side";
$text['pdfgen'] = "PDF Generator";
$text['blank'] = "Tom oversikt";
$text['none'] = "Ingen";
$text['fonts'] = "Font";
$text['header'] = "Overskrift";
$text['data'] = "Data";
$text['pgsetup'] = "Sideoppsett";
$text['pgsize'] = "Side størrelse";
$text['letter'] = "Letter";
$text['legal'] = "Legal";
$text['orient'] = "Orientering";
$text['portrait'] = "Portrett";
$text['landscape'] = "Landskap";
$text['tmargin'] = "Topmarg";
$text['bmargin'] = "Bunnmarg";
$text['lmargin'] = "Venstre marg";
$text['rmargin'] = "Høyre marg";
$text['createch'] = "Lag oversikt";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "'Wanted'";
$text['latupdates'] = "Siste oppdatering";
$text['featphoto'] = "Siste bilde";
$text['news'] = "Nyheter";
$text['ourhist'] = "Vår historie";
$text['ourhistanc'] = "Vår historie og aner";
$text['ourpages'] = "Våre slektssider";
$text['pwrdby'] = "This site powered by";
$text['writby'] = "skrevet av";
$text['searchtngnet'] = "Søk TNG-nettet (GENDEX)";
$text['viewphotos'] = "Se alle bilder";
$text['anon'] = "Du er fremdeles anonym";
$text['whichbranch'] = "Hvilken gren tilhører du?";
$text['featarts'] = "Artiklene";
$text['maintby'] = "Redigert av";
$text['createdon'] = "Skrevet den";
 //for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Startside";
$text['mnusearchfornames'] = "Søk";
$text['mnulastname'] = "Etternavn";
$text['mnufirstname'] = "Fornavn";
$text['mnusearch'] = "Søk";
$text['mnureset'] = "Start på nytt";
$text['mnulogon'] = "Logg inn";
$text['mnulogout'] = "Logg ut";
$text['mnufeatures'] = "Flere muligheter";
$text['mnuregister'] = "Be om brukerkonto";
$text['mnuadvancedsearch'] = "Avansert søk";
$text['mnulastnames'] = "Etternavn";
$text['mnustatistics'] = "Statistikk";
$text['mnuphotos'] = "Bilder";
$text['mnuhistories'] = "Historier";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Kirkegårder";
$text['mnutombstones'] = "Gravstener";
$text['mnureports'] = "Rapporter";
$text['mnusources'] = "Kilder";
$text['mnuwhatsnew'] = "Hva er nytt ?";
$text['mnushowlog'] = "Søkelogg";
$text['mnulanguage'] = "Change Language";
$text['mnuadmin'] = "Admin";
$text['welcome'] = "Velkommen";
$text['contactus'] = "Ta kontakt";

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
