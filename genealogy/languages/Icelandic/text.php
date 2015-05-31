<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Skoða allar heimildir";
		$text['shorttitle'] = "Stuttur titill";
		$text['callnum'] = "Símanúmer";
		$text['author'] = "Höfundur";
		$text['publisher'] = "Útgefandi";
		$text['other'] = "Aðrar upplýsingar";
		$text['sourceid'] = "Heimilda ID";
		$text['moresrc'] = "Fleiri Heimildir";
		$text['repoid'] = "greftrunarstaður ID";
		$text['browseallrepos'] = "Skoða alla greftrunarstaði";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nýtt tungumál";
		$text['changelanguage'] = "Breyta tungumáli";
		$text['languagesaved'] = "Tungumál vistað";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM byrjar frá";
		$text['producegedfrom'] = "útbúa GEDCOM skrá frá";
		$text['numgens'] = "fjöldi kynslóða";
		$text['includelds'] = "hafa LDS upplýsingar með";
		$text['buildged'] = "Byggja GEDCOM";
		$text['gedstartfrom'] = "GEDCOM byrjar frá";
		$text['nomaxgen'] = "Þú verður að skilgreina fjölda kynslóða. Vinsamlegast notið back takkan til að fara til baka";
		$text['gedcreatedfrom'] = "GEDCOM skapað af";
		$text['gedcreatedfor'] = "Skapað fyrir";

		$text['enteremail'] = "Vinsamlegast sláðu inn tölvupóstfang.";
		$text['creategedfor'] = "útbúa GEDCOM fyrir";
		$text['email'] = "Tölvupóstfang";
		$text['suggestchange'] = "Stinga uppá breytingu";
		$text['yourname'] = "Nafnið þitt";
		$text['comments'] = "Skilaboð eða athugasemdir";
		$text['comments2'] = "Athugasemdir";
		$text['submitsugg'] = "Senda inn uppástungu";
		$text['proposed'] = "Breyting";
		$text['mailsent'] = "Takk fyrir. Skilaboð þín hafa verið send.";
		$text['mailnotsent'] = "Því miður komust skilaboðin ekki til. Vinsamlegast hafðu samband við xxx beint yyy.";
		$text['mailme'] = "Senda afrit á þetta netfang";
		//added in 5.0.5
		$text['entername'] = "Vinsamlegast sláðu inn nafnið þitt";
		$text['entercomments'] = "Vinsamlegast sláðu inn athugasemdir";
		$text['sendmsg'] = "Senda skilaboð";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Ljósmyndir og saga fyrir";
		$text['indinfofor'] = "Einstaklings upplýsingar fyrir";
		$text['reliability'] = "Áreiðanleiki";
		$text['pp'] = "bls.";
		$text['age'] = "Aldur";
		$text['agency'] = "Samtök";
		$text['cause'] = "Ástæða";
		$text['suggested'] = "Uppástunga";
		$text['closewindow'] = "Loka þessum glugga";
		$text['thanks'] = "Takk fyrir";
		$text['received'] = "Uppástungu hefur verið komið áleiðis til vefstjóra til skoðunar.";
		//added in 6.0.0
		$text['association'] = "Tenging";
		//added in 7.0.0
		$text['indreport'] = "Individual Report";
		$text['indreportfor'] = "Individual Report for";
		$text['general'] = "General";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Skyldleika reiknir";
		$text['findrel'] = "Rekja saman";
		$text['person1'] = "Einstaklingur 1:";
		$text['person2'] = "Einstaklingur 2:";
		$text['calculate'] = "Reikna";
		$text['select2inds'] = "Veldu 2 einstaklinga.";
		$text['findpersonid'] = "Finna einstaklings númer";
		$text['enternamepart'] = "Sláður inn hluta fyrra nafns/eða seinna nafns";
		$text['pleasenamepart'] = "Vinsamlegast sláðu inn hluta nafns.";
		$text['clicktoselect'] = "Smelltu hér til að velja";
		$text['nobirthinfo'] = "Engar upllýsingar um fæðingardag";
		$text['relateto'] = "Skyldleiki til";
		$text['sameperson'] = "þetta er sama manneskjan hvað ertu að spá ?.";
		$text['notrelated'] = "þessir 2 einstaklingar eru ekki skyldir innan xxx kynslóða.";
		$text['findrelinstr'] = "sláðu inn einstaklingsnúmer, eða láttu fólkið sjást, smelltu svo á reikna að finna skyldleika þeirra (up to xxx generations).";
		$text['gencheck'] = "Hámarks fjöldi kynslóða<br />til að ath";
		$text['sometimes'] = "(Stundum þegar athugað er yfir mismunandi fjölda kynslóða kemur önnur niðurstaða.)";
		$text['findanother'] = "Finna annan skyldleika";
		//added in 6.0.0
		$text['brother'] = "bróðir";
		$text['sister'] = "systir";
		$text['sibling'] = "systkyni";
		$text['uncle'] = "xxx frændi";
		$text['aunt'] = "xxx frænka";
		$text['uncleaunt'] = "xxx frændur/frænkur";
		$text['nephew'] = "xxx frændi";
		$text['niece'] = "xxx frænka";
		$text['nephnc'] = "xxx frændur/frænkur";
		$text['mcousin'] = "xxx frændi";
		$text['fcousin'] = "xxx frændi";
		$text['cousin'] = "xxx frændi";
		$text['removed'] = "oft fjarlæður";
		$text['rhusband'] = "eiginmaður ";
		$text['rwife'] = "eiginkona ";
		$text['rspouse'] = "maki ";
		$text['son'] = "sonur";
		$text['daughter'] = "dóttir";
		$text['rchild'] = "barn";
		$text['sil'] = "Tengdarsonur";
		$text['dil'] = "Tengdardóttir";
		$text['sdil'] = "Tenddar sonur eða dóttir";
		$text['gson'] = "Barnabarn";
		$text['gdau'] = "xxx barnabarn";
		$text['gsondau'] = "xxx barnabarn";
		$text['great'] = "langa";
		$text['spouses'] = "eru makar";
		$text['is'] = "er";
		//changed in 6.0.0
		$text['changeto'] = "Breyta í:";
		//added in 6.0.0
		$text['notvalid'] = "er ekki gilt einstaklings id eða er ekki til i gagnagrunni, vinsamlegast reynið aftur.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Fjölskyldu blað fyrir";
		$text['ldsords'] = "LDS Ordinances";
		$text['baptizedlds'] = "Skírður (LDS)";
		$text['endowedlds'] = "Fermdur (LDS)";
		$text['sealedplds'] = "Sealed P (LDS)";
		$text['sealedslds'] = "Sealed S (LDS)";
		$text['otherspouse'] = "Annar/ur maki";
		//changed in 7.0.0
		$text['husband'] = "Eiginmaður";
		$text['wife'] = "Eiginkona";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "F";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "G";
		$text['capplaceabbr'] = "S";
		$text['capmarrabbr'] = "G";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Enduraða með";
		$text['scrollnote'] = "Ath: Þú þarft kannski að skruna niður eða til hægri til að sjá.";
		$text['unknownlit'] = "óskráð";
		$text['popupnote1'] = " = Auka upplýsingar";
		$text['popupnote2'] = " = Nýtt niðjatal";
		$text['pedcompact'] = "Þjappað";
		$text['pedstandard'] = "Staðlað";
		$text['pedtextonly'] = "Aðeins texta";
		$text['descendfor'] = "Afkomendur";
		$text['maxof'] = "Hámark af";
		$text['gensatonce'] = "kynslóðir birtar í einu.";
		$text['sonof'] = "Sonur";
		$text['daughterof'] = "Dóttir";
		$text['childof'] = "barn";
		$text['stdformat'] = "Staðlað snið";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "Bæta við fjölskyldu";
		$text['editfam'] = "Breyta fjölskyldu";
		$text['side'] = "Hlið";
		$text['familyof'] = "Fjölskylda";
		$text['paternal'] = "Paternal";
		$text['maternal'] = "Maternal";
		$text['gen1'] = "Sjálf/ur";
		$text['gen2'] = "Foreldrar";
		$text['gen3'] = "Ömmur og afar";
		$text['gen4'] = "Langömmur og afar";
		$text['gen5'] = "Í annan ættlið";
		$text['gen6'] = "Í þriðja ættlið";
		$text['gen7'] = "Í fjórða ættlið";
		$text['gen8'] = "Í fimmta ættlið";
		$text['gen9'] = "Í sjötta ættlið";
		$text['gen10'] = "Í Sjöunda ættlið";
		$text['gen11'] = "Í áttunda Ættlið";
		$text['gen12'] = "Í níunda ættlið";
		$text['graphdesc'] = "Grafískt nyðjatal að þessum punkti";
		$text['collapse'] = "Fella";
		$text['expand'] = " útlista nánar ";
		$text['pedbox'] = "Kassi";
		//changed in 6.0.0
		$text['regformat'] = "skráningar snið";
		$text['extrasexpl'] = "Ef að ljósmyndir eða sögur eru til um viðkomandi einstakling, koma viðeigandi myndir næst við nöfnin.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nýtt ";
		$text['mediaavail'] = "Margmiðlun tiltæk";
		//changed in 7.0.0
		$text['pedigreefor'] = "Niðjatal fyrir";
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
		$text['noreports'] = "Engar skýrslur til.";
		$text['reportname'] = "Nafn skýrslu";
		$text['allreports'] = "Allar skýrslur";
		$text['report'] = "Skýrslur";
		$text['error'] = "Villa";
		$text['reportsyntax'] = "Eitthvað við þessa fyrirspurn";
		$text['wasincorrect'] = "var rangt, og gátum við ekki séð skýrsluna. vinsemlagast hafið samband við vefstjóra á";
		$text['query'] = "Fyrirspurn";
		$text['errormessage'] = "Villu boð";
		$text['equals'] = "Samanstendur af";
		$text['contains'] = "inniheldur";
		$text['startswith'] = "Byrjar á";
		$text['endswith'] = "endar á";
		$text['soundexof'] = "soundex of";
		$text['metaphoneof'] = "metaphone of";
		$text['plusminus10'] = "+/- 10 árum frá";
		$text['lessthan'] = "minna en";
		$text['greaterthan'] = "meira en";
		$text['lessthanequal'] = "minna en eða jafnt og";
		$text['greaterthanequal'] = "meira en eða jafnt og";
		$text['equalto'] = "Jafnt og";
		$text['tryagain'] = "Vinsamlegast reyndu aftur";
		$text['text_for'] = "fyrir";
		$text['searchnames'] = "Leita að nöfnum";
		$text['joinwith'] = "Sameina með";
		$text['cap_and'] = "og";
		$text['cap_or'] = "eða";
		$text['showspouse'] = "Sýna maka (Sýnir alla ef fleirri en einn)";
		$text['submitquery'] = "Sækja skýrslu";
		$text['birthplace'] = "Fæðingarstaður";
		$text['deathplace'] = "Dánarstaður";
		$text['birthdatetr'] = "Fæðingarár";
		$text['deathdatetr'] = "Dánarár";
		$text['plusminus2'] = "+/- 2 ár frá";
		$text['resetall'] = "Hreinsa öll gildi";

		$text['showdeath'] = "Sýna dánar/grafar upplýsingar";
		$text['altbirthplace'] = "Skírnar staður";
		$text['altbirthdatetr'] = "Skírnar ár";
		$text['burialplace'] = "Staðsetning grafreits";
		$text['burialdatetr'] = "Grefturnarár";
		$text['event'] = "Viðburðir";
		$text['day'] = "Dagur";
		$text['month'] = "Mánuður";
		$text['keyword'] = "Lykil orð (t.d, \"Abt\")";
		$text['explain'] = "Sláðu inn dagsetningu til að sjá viðburði þann þaag, skyldu eftir autt til að sjá allt.";
		$text['enterdate'] = "Vinsamlegast sláðu inn eða veldu að minnsta kosti eitt af eftirfarandi: Dagur, Mánuður, Ár, Lykil orð";
		$text['fullname'] = "Fullt nafn";
		$text['birthdate'] = "Fæðingar dagsetning";
		$text['altbirthdate'] = "Skýrnar dagsetning";
		$text['marrdate'] = "Giftingar dagsetning";
		$text['spouseid'] = "maka ID";
		$text['spousename'] = "Nafn Maka";
		$text['deathdate'] = "Dags látin";
		$text['burialdate'] = "Dagsetning greftrunar";
		$text['changedate'] = "Síðast breytt dagsetning";
		$text['gedcom'] = "Tré";
		$text['baptdate'] = "Fermdur dags (LDS)";
		$text['baptplace'] = "Fermingar staður (LDS)";
		$text['endldate'] = "Endowment Date (LDS)";
		$text['endlplace'] = "Endowment Place (LDS)";
		$text['ssealdate'] = "Seal Date S (LDS)";
		$text['ssealplace'] = "Seal Place S (LDS)";
		$text['psealdate'] = "Seal Date P (LDS)";
		$text['psealplace'] = "Seal Place P (LDS)";
		$text['marrplace'] = "Staðsetning brúðkaups";
		$text['spousesurname'] = "Föðurnafn maka";
		//changed in 6.0.0
		$text['spousemore'] = "Ef þú slærð in föðurnafn maka verður þú að minnsta kosti að slá inn í einn annan reit hjá honum.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 ár frá";
		$text['exists'] = "þegar til";
		$text['dnexist'] = "ekki til";
		//added in 6.0.3
		$text['divdate'] = "Dagsetning skilnaðar";
		$text['divplace'] = "Staðsetning skilnaðar";
		//changed in 7.0.0
		$text['otherevents'] = "Aðrir viðburðir";
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
		$text['logfilefor'] = "loggar fyrir";
		$text['mostrecentactions'] = "Nýlegustu aðgerðir";
		$text['autorefresh'] = "Sjálfvirk endurnýjun á  (30 sekúndu fresti)";
		$text['refreshoff'] = "Sökkva á sjálfvirk endurnýjun";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Kirkjugarðar og legsteinar";
		$text['showallhsr'] = "Sýna yfirlit yfir allat";
		$text['in'] = "inn";
		$text['showmap'] = "Sýna kort";
		$text['headstonefor'] = "legsteinn fyrir";
		$text['photoof'] = "Ljósmynd af";
		$text['firstpage'] = "Fyrsta síða";
		$text['lastpage'] = "Síðasta síða";
		$text['photoowner'] = "eigandi/Spretta";

		$text['nocemetery'] = "engin grafreytur";
		$text['iptc005'] = "Titill";
		$text['iptc020'] = "stuðn. Flokkar";
		$text['iptc040'] = "Sérstakar leiðbeningar";
		$text['iptc055'] = "Skapað dags";
		$text['iptc080'] = "Höfundur";
		$text['iptc085'] = "Staðsetning höfundar";
		$text['iptc090'] = "Borg";
		$text['iptc095'] = "Ríki";
		$text['iptc101'] = "Land";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Fyrirsögn";
		$text['iptc110'] = "spretta";
		$text['iptc115'] = "Ljósmyndaspretta";
		$text['iptc116'] = "Höfundarréttur";
		$text['iptc120'] = "Mynd af";
		$text['iptc122'] = "mynda gerð af";
		$text['mapof'] = "kort af";
		$text['regphotos'] = "Lýsandi viðmót";
		$text['gallery'] = "Sjá bara þumalmyndir";
		$text['cemphotos'] = "Myndir af kirkjugörðum";
		//changed in 6.0.0
		$text['photosize'] = "Stærð";
		//added in 6.0.0
        	$text['iptc010'] = "Priority";
		$text['filesize'] = "skráarstærð";
		$text['seeloc'] = "sjá staðsetningu";
		$text['showall'] = "Sýna allr";
		$text['editmedia'] = "Breyta margmiðlun";
		$text['viewitem'] = "Skoða þennan hlut";
		$text['editcem'] = "Breyta grafreit";
		$text['numitems'] = "# Hlutir";
		$text['allalbums'] = "Öll albúm";
		//added in 6.1.0
		$text['slidestart'] = "Hefja myndasýningu";
		$text['slidestop'] = "Stoppa myndasýningu";
		$text['slideresume'] = "Setja myndasýningu af stað";
		$text['slidesecs'] = "sekúndur fyrir hverja mynd:";
		$text['minussecs'] = "mínus 0.5 sekúndur";
		$text['plussecs'] = "plús 0.5 sekúndur";
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
		$text['surnamesstarting'] = "Sýna föðurnöfn sem byrja á";
		$text['showtop'] = "Sýna efsta";
		$text['showallsurnames'] = "Sýna öll föðurnöfn";
		$text['sortedalpha'] = "Í stafrófsröð";
		$text['byoccurrence'] = "eftir fjölda";
		$text['firstchars'] = "Fyrstu stafina";
		$text['top'] = "Efst";
		$text['mainsurnamepage'] = "Aðal föðurnafna síðan";
		$text['allsurnames'] = "Öll föðurnöfn";
		$text['showmatchingsurnames'] = "Smelltu á föðurnafn til að sjá fleirri.";
		$text['backtotop'] = "Aftur efst";
		$text['beginswith'] = "Byrjar á";
		$text['allbeginningwith'] = "Öll sem byrja á";
		$text['numoccurrences'] = "fjöldi í foreldrartölu";
		$text['placesstarting'] = "Sýna staði sem byrja á";
		$text['showmatchingplaces'] = "smelltu á nafn til að skoða.";
		$text['totalnames'] = "heildar nöfn";
		$text['showallplaces'] = "Sýna stærstu staðina";
		$text['totalplaces'] = "samtals staðir";
		$text['mainplacepage'] = "Aðal staðir síða";
		$text['allplaces'] = "Öll stærstu umhverfin";
		$text['placescont'] = "Sýna alla staði sem innihalda";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(Sýðust xx daga)";
		$text['historiesdocs'] = "Saga &<br>Skjöl";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Ljósmynd";
		$text['history'] = "Saga/Skal";
		//changed in 7.0.0
		$text['husbid'] = "Eiginmanns ID";
		$text['husbname'] = "Eiginmanns Nafn";
		$text['wifeid'] = "Eiginkonu ID";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Eyða";
		$text['addperson'] = "Bæta persónu við";
		$text['nobirth'] = "Þessi einstaklingur hefur ekki gildan fæðingardag og var því ekki hægt að bæta honum við";
		$text['noliving'] = "Þessi einstaklingur er merktur á lífi og var því ekki hægt að bæta honum við því þú ert ekki mé réttindi til þess";
		$text['event'] = "Viðburðir";
		$text['chartwidth'] = "Graf breydd";
		//changed in 6.0.0
		$text['timelineinstr'] = "bættu allt að fjórum fleirri einstaklingum með því að slá inn einstaklingsnúmerið þeirra hér fyrir neðan:";
		//added in 6.0.0
		$text['togglelines'] = "Kveikja á línum";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Skoða öll tré";
		$text['treename'] = "Nafn trés";
		$text['owner'] = "Eigandi";
		$text['address'] = "Heimilisfang";
		$text['city'] = "Borg";
		$text['state'] = "Sýsla";
		$text['zip'] = "Póstnúmer";
		$text['country'] = "Land";
		$text['email'] = "Tölvupóstfang";
		$text['phone'] = "Sími";
		$text['username'] = "Notendanafn";
		$text['password'] = "Lykilorð";
		$text['loginfailed'] = "Innskráning mistókst.";

		$text['regnewacct'] = "Skráðu þig svo þú fáir notenda aðgang";
		$text['realname'] = "Nafnið þitt";
		$text['phone'] = "Sími";
		$text['email'] = "Tölvupóstfang";
		$text['address'] = "Heimilisfang";
		$text['comments'] = "Skilaboð eða athugasemdir";
		$text['submit'] = "Senda";
		$text['leaveblank'] = "(hafðu autt ef óskað er eftir nýju treei)";
		$text['required'] = "Verður að fylla út í reiti merkta þessu";
		$text['enterpassword'] = "Sláðu inn lykilorð.";
		$text['enterusername'] = "Sláðu inn notendanafn.";
		$text['failure'] = "Því miður er notendanafnið sem þú valdir uptekið. vinsamlegat notaðu back takkan til að velja þér nýtt notendanafn.";
		$text['success'] = "Takk fyrir. Skráningin þín hefur verið móttekin. þú verður látin vita þegar aðgangur þinn er orðin virkur eða meiri upplýsingar vantar.";
		$text['emailsubject'] = "Nýr aðgangur á nyðjatalsíðuna hefur verið óskað";
		$text['emailmsg'] = "Það hefur borist þér póstur um aðgang að nyðjatals síðunni. vinsamlegast skráðu þig inn á kerfis hluta síðunar og gefðu notenda réttindi til að taka þátt í að viðhalda síðunni. Ef þú notandi er í lagi vinsamlegast láttu hann vita með því að svara póstinum hanns.";
		//changed in 5.0.0
		$text['enteremail'] = "Vinsamlegast sláðu inn tölvupóstfang.";
		$text['website'] = "Vefsíða";
		$text['nologin'] = "Átti ekki notendanafn?";
		$text['loginsent'] = "Upplýsingar sendar";
		$text['loginnotsent'] = "Aðgangs upplýsingar ekki sendar";
		$text['enterrealname'] = "Sláðu inn nafnið þitt.";
		$text['rempass'] = "Vera alltaf skráður á þessari tölvu";
		$text['morestats'] = "Meiri tölfræði";
		//added in 6.0.0
		$text['accmail'] = "<strong>ATH:</strong> Til að fá póst frá Vefstjóra varðandi aðganginn þinn vertu viss um að það ´se ekki verið að útiloka póst frá þessu léni.";
		$text['newpassword'] = "Nýtt lykilorð";
		$text['resetpass'] = "Breyta lykilorði";
		//added in 6.1.0
		$text['nousers'] = "This form cannot be used until at least one user record exists. If you are the site owner, please go to Admin/Users to create your Administrator account.";
		//added in 7.0.0
		$text['noregs'] = "We're sorry, but we are not accepting new user registrations at this time. Please <a href=\"suggest.php\">contact us</a> directly if you have comments or questions regarding anything on this site.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Fjöldi";
		$text['totindividuals'] = "Samtals einstaklingar";
		$text['totmales'] = "Samtals karlmenn";
		$text['totfemales'] = "Samtals kvenmenn";
		$text['totunknown'] = "Samtals óþekkt kyn";
		$text['totliving'] = "Samtals lifandi";
		$text['totfamilies'] = "Samtals fjölskyldur";
		$text['totuniquesn'] = "Samtals Fjöldi Föðurnafna";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Samtals heimildir";
		$text['avglifespan'] = "Meðal lífstími";
		$text['earliestbirth'] = "Yngsta fæðinginn";
		$text['longestlived'] = "Elsti aldurinn";
		$text['years'] = "ár";
		$text['days'] = "dagar";
		$text['age'] = "Aldur";
		$text['agedisclaimer'] = "Aldurs-tengdir útreikningar eru byggðir á einstaklingum með skráðar dagsetningar vegna fjölda óskráðra dagsetninga er þetta ekki allveg 100 prósent nákvæmt.";
		$text['treedetail'] = "Meiri upplýsingar um þetta tré";
		//added in 6.0.0
		$text['total'] = "Samtals";
		break;

	case "notes":
		$text['browseallnotes'] = "Flétta í öllum athugasemdum";
		break;

	case "help":
		$text['menuhelp'] = "Valmynd";
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
		$text['exists'] = "þegar til";
		$text['loginfirst'] = "You must log in first.";
		$text['noop'] = "No operation was performed.";
		break;
}

//common
$text['matches'] = "Passar";
$text['description'] = "Lýsing";
$text['notes'] = "Athugasemdir";
$text['status'] = "Staða";
$text['newsearch'] = "Ný leit";
$text['pedigree'] = "Niðjatal";
$text['birthabbr'] = "f.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Sjá mynd";
$text['andlocation'] = "& staðsetning";
$text['accessedby'] = "Skoðað af";
$text['go'] = "Fara af stað";
$text['family'] = "Fjölskylda";
$text['children'] = "Börn";
$text['tree'] = "Tré";
$text['alltrees'] = "Öll tré";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "Þumalmynd";
$text['people'] = "Fólk";
$text['title'] = "Titill";
$text['suffix'] = "Fornafn";
$text['nickname'] = "Kallaður/kölluð";
$text['deathabbr'] = "L.";
$text['lastmodified'] = "Síðast Breytt";
$text['married'] = "Gift/ur";
//$text['photos'] = "Photos";
$text['name'] = "Nafn";
$text['lastfirst'] = "Föðurnafn, Skírnanafn(s)";
$text['bornchr'] = "Fæddur/Skírð/ur";
$text['individuals'] = "Einstaklingar";
$text['families'] = "Fjölskyldur";
$text['personid'] = "Persónu ID";
$text['sources'] = "Heimildir";
$text['unknown'] = "óskýrð/ur";
$text['father'] = "Faðir";
$text['mother'] = "Móðir";
$text['born'] = "Fædd/ur";
$text['christened'] = "Skýrð/ur";
$text['died'] = "Látinn";
$text['buried'] = "Grafin";
$text['spouse'] = "Maki";
$text['parents'] = "Foreldrar";
$text['text'] = "Texti";
$text['language'] = "Tungumál";
$text['burialabbr'] = "graf.";
$text['descendchart'] = "Afkomendur";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Einstaklingur";
$text['edit'] = "Breyta";
$text['date'] = "Dags";
$text['place'] = "Staður";
$text['login'] = "Innskráning";
$text['logout'] = "Skrá sig út";
$text['marrabbr'] = "G.";
$text['groupsheet'] = "Hóp Skrá";
$text['text_and'] = "og";
$text['generation'] = "Kynslóð";
$text['filename'] = "Skráarnafn";
$text['id'] = "ID";
$text['search'] = "Leita";
$text['living'] = "Lifandi";
$text['user'] = "Notandi";
$text['firstname'] = "Nafn";
$text['lastname'] = "Föðurnafn";
$text['searchresults'] = "Leitarniðurstöður";
$text['diedburied'] = "látin/Grefin";
$text['homepage'] = "Aðalsíða";
$text['find'] = "Finna...";
$text['relationship'] = "Skyldleiki";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Tímalína";
$text['yesabbr'] = "J";
$text['divorced'] = "Skilin";
$text['indlinked'] = "Tengist við";
$text['branch'] = "Grein";
$text['moreind'] = "Fleirri einstaklingar";
$text['morefam'] = "Fleirri fjölskyldur";
$text['livingdoc'] = "Að minnsta kosti einn einstaklingur á þessu skjali er lifandi - upplýsingar ekki gefnar upp..";
$text['source'] = "Heimildir";
$text['surnamelist'] = "Föðurnafna listi";
$text['generations'] = "Kynslóðir";
$text['refresh'] = "Endurhlaða";
$text['whatsnew'] = "Nýtt";
$text['reports'] = "Skýrslur";
$text['placelist'] = "Staða listi";
$text['baptizedlds'] = "Skírður (LDS)";
$text['endowedlds'] = "Fermdur (LDS)";
$text['sealedplds'] = "Sealed P (LDS)";
$text['sealedslds'] = "Sealed S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "forfeður";
$text['descendants'] = "afkomendur";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "dags síðast GEDCOM innflutt";
$text['type'] = "týpa";
$text['savechanges'] = "Breytingar vistaðar";
$text['familyid'] = "Fjölskyldu ID";
$text['headstone'] = "Legsteinn(ar)";
$text['historiesdocs'] = "Saga &<br>Skjöl";
$text['livingnote'] = "Lifandi einstaklingur - Nánari upplýsingar faldar";
$text['anonymous'] = "ónefndur";
$text['places'] = "Staðir";
$text['anniversaries'] = "Dagsetningar og merkisatburðir";
$text['administration'] = "Vefstjórn";
$text['help'] = "Hjálp";
//$text['documents'] = "Documents";
$text['year'] = "Ár";
$text['all'] = "All";
$text['repository'] = "Greftrunarstaður";
$text['address'] = "Heimilisfang";
$text['suggest'] = "Suggest";
$text['editevent'] = "Suggest a change for this event";
$text['findplaces'] = "Find all individuals with events at this location";
$text['morelinks'] = "More Links";
$text['faminfo'] = "Family Information";
$text['persinfo'] = "Personal Information";
$text['srcinfo'] = "Source Information";
$text['fact'] = "Staðreind";
$text['goto'] = "Velja síðu";
$text['tngprint'] = "Prenta";
//changed in 6.0.0
$text['livingphoto'] = "Að minnstakosti einn einstaklingur á þessari mynd er lifandi - upplýsingar um mynd ekki gefnar upp.";
$text['databasestatistics'] = "Tölfræði gagnagrunns";
//moved here in 6.0.0
$text['child'] = "Barn";
$text['repoinfo'] = "Upplýsingur um greftrunarstaði";
$text['tng_reset'] = "Hreinsa";
$text['noresults'] = "engar niðurstöður fundust";
//added in 6.0.0
$text['allmedia'] = "Öll margmiðlun";
$text['repositories'] = "Repositories";
$text['albums'] = "Albúm";
$text['cemeteries'] = "Grafreitir";
$text['surnames'] = "Eftirnöfn";
$text['dates'] = "Dagsetningar";
$text['link'] = "Tengill";
$text['media'] = "Margmiðlun";
$text['gender'] = "Kyn";
$text['latitude'] = "Breiddargráða";
$text['longitude'] = "Lengdargráða";
$text['bookmarks'] = "Bókamerki";
$text['bookmark'] = "Bæta við bókamerki";
$text['mngbookmarks'] = "Fara á bókarmerki";
$text['bookmarked'] = "Bókamerki bætt við";
$text['remove'] = "Fjarlægja";
$text['find_menu'] = "Finna";
$text['info'] = "Uppl";
//moved here in 6.0.3
$text['cemetery'] = "Kirkjugarður";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Viðburða kort";
$text['gevents'] = "Viðburðir";
$text['glang'] = "&amp;hl=is";
$text['googleearthlink'] = "Linkur á Google Earth";
$text['googlemaplink'] = "Linkur til Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "Ómerkt";
$text['located'] = "Staðsetning";
//added in 7.0.0
$text['albclicksee'] = "Smelltu til að sjá alla hluti í þessu albúmi";
$text['notyetlocated'] = "ekki fundinn enn";
$text['cremated'] = "Brenndur";
$text['missing'] = "Saknað";
$text['page'] = "Síða";
$text['pdfgen'] = "PDF Generator";
$text['blank'] = "Tómt kort";
$text['none'] = "Ekkert";
$text['fonts'] = "Letur";
$text['header'] = "Haus";
$text['data'] = "Upplýsingar";
$text['pgsetup'] = "Síðu uppsetning";
$text['pgsize'] = "Síðu Stærð";
$text['letter'] = "Bréf";
$text['legal'] = "Löglegt";
$text['orient'] = "Snúningur";
$text['portrait'] = "Portrait";
$text['landscape'] = "Landscape";
$text['tmargin'] = "Efri spássía";
$text['bmargin'] = "Neðri Spássía";
$text['lmargin'] = "Vinstri spássía";
$text['rmargin'] = "Hægri spássía";
$text['createch'] = "Búa til kort";
$text['prefix'] = "Prefix";
$text['mostwanted'] = "Vantar mest";
$text['latupdates'] = "Síðustu uppfærslur";
$text['featphoto'] = "Myndir af handahófi";
$text['news'] = "Fréttir";
$text['ourhist'] = "Fjölskyldu saga okkar";
$text['ourhistanc'] = "Fjölskyldusaga okkar og afkomendur";
$text['ourpages'] = "Fjölskyldu nyðjatal";
$text['pwrdby'] = "þessi síða er önnuð af";
$text['writby'] = "Skrifuð af";
$text['searchtngnet'] = "Leita á TNG Síðunum (GENDEX)";
$text['viewphotos'] = "Skoða allar myndir";
$text['anon'] = "Þú ert ekki skráður undir nafni";
$text['whichbranch'] = "Hvaða grein kemur þú frá?";
$text['featarts'] = "Grein af handófi";
$text['maintby'] = "Umsjón síðu";
$text['createdon'] = "Búinn til af";

//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Vefsíða";
$text['mnusearchfornames'] = "Leita eftir nafni";
$text['mnulastname'] = "Föðurnafn";
$text['mnufirstname'] = "Skírnarnafn";
$text['mnusearch'] = "Leita";
$text['mnureset'] = "Byrja upp á nýtt";
$text['mnulogon'] = "Innskrá";
$text['mnulogout'] = "Útskrá";
$text['mnufeatures'] = "Aðrir kostir";
$text['mnuregister'] = "Skráning fyrir notenda aðgang";
$text['mnuadvancedsearch'] = "Nánari leit";
$text['mnulastnames'] = "Föðurnöfn";
$text['mnustatistics'] = "Tölfræði";
$text['mnuphotos'] = "Myndir";
$text['mnuhistories'] = "Sögur";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Grafreitir";
$text['mnutombstones'] = "Legsteinar";
$text['mnureports'] = "Skýrslur";
$text['mnusources'] = "Heimildir";
$text['mnuwhatsnew'] = "Hvað er nýtt";
$text['mnushowlog'] = "Loggar";
$text['mnulanguage'] = "Breyta tungumáli";
$text['mnuadmin'] = "Vefstjórn";
$text['welcome'] = "Velkominn";
$text['contactus'] = "Hafðu samband við okkur";

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
