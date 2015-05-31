<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Toutes les sources";
		$text['shorttitle'] = "Titre court";
		$text['callnum'] = "Num�ro d'archive";
		$text['author'] = "Auteur";
		$text['publisher'] = "Editeur";
		$text['other'] = "Autre information";
		$text['sourceid'] = "Source ID";
		$text['moresrc'] = "Autres sources";
		$text['repoid'] = "ID du Lieu de d�p�t";
		$text['browseallrepos'] = "Chercher les lieux de d�p�t";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nouvelle langue";
		$text['changelanguage'] = "Changer la Langue";
		$text['languagesaved'] = "Langue enregistr�e";
		//added in 7.0.0
		$text['sitemaint'] = "Entretien du site Web en cours";
		$text['standby'] = "Notre site Web est temporairement hors service pendant que nous mettons � jour notre base de donn�es. Veuillez essayer de nouveau dans quelques minutes. Si notre site Web demeure inaccessible pour une p�riode prolong�e, veuillez <a href=\"suggest.php\">contacter le propri�taire du site Web </a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM d�marre de";
		$text['producegedfrom'] = "Produire un fichier GEDCOM depuis";
		$text['numgens'] = "Nombre de g�n�rations";
		$text['includelds'] = "Inclure information LDS";
		$text['buildged'] = "Contruire GEDCOM";
		$text['gedstartfrom'] = "GEDCOM commence �";
		$text['nomaxgen'] = "Vous devez sp�cifier un nombre maximum de g�n�rations. Veuillez cliquer sur le bouton 'Pr�c�dent' et corriger l'erreur";
		$text['gedcreatedfrom'] = "GEDCOM cr�� depuis";
		$text['gedcreatedfor'] = "cr�� pour";

		$text['enteremail'] = "Veuillez introduire une adresse e-mail valable.";
		$text['creategedfor'] = "Creer un fichier GEDCOM";
		$text['email'] = "Adresse �lectronique";
		$text['suggestchange'] = "Sugg�rez une modification";
		$text['yourname'] = "Votre nom";
		$text['comments'] = "Notes ou Commentaires";
		$text['comments2'] = "Commentaires";
		$text['submitsugg'] = "Soumettez une suggestion";
		$text['proposed'] = "Changement Propos�";
		$text['mailsent'] = "Merci. Votre message a �t� envoy�.";
		$text['mailnotsent'] = "D�sol�, mais votre message n'a pu �tre envoy�. Veuillez directement contacter xxx � yyy";
		$text['mailme'] = "Envoyez une copie � cette addresse";
		//added in 5.0.5
		$text['entername'] = "Merci d'inscrire votre nom";
		$text['entercomments'] = "Merci d'inscrire vos commentaires";
		$text['sendmsg'] = "Envoyer le message";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Photos et historique de";
		$text['indinfofor'] = "Info personnelle concernant";
		$text['reliability'] = "Fiabilit�";
		$text['pp'] = "pp.";
		$text['age'] = "�ge";
		$text['agency'] = "Agence";
		$text['cause'] = "Cause";
		$text['suggested'] = "Sugg�r�";
		$text['closewindow'] = "Fermez cette fen�tre";
		$text['thanks'] = "Merci";
		$text['received'] = "Le changement que vous avez propos� sera inclus apr�s v�rification par l'administrateur du site.";
		//added in 6.0.0
		$text['association'] = "Association";
		//added in 7.0.0
		$text['indreport'] = "Rapport individuel";
		$text['indreportfor'] = "Rapport individuel pour";
		$text['general'] = "G�n�ralit�s";
		$text['labels'] = "�tiquettes";
		$text['bkmkvis'] = "<strong>Note:</strong> Ces signets sont seulement visibles sur cet ordinateur et avec ce navigateur.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Calculateur de liens de parent�";
		$text['findrel'] = "Recherche de liens de parent�";
		$text['person1'] = "Personne 1:";
		$text['person2'] = "Personne 2:";
		$text['calculate'] = "Calcul";
		$text['select2inds'] = "Veuillez s�lectionner deux individus.";
		$text['findpersonid'] = "Trouvez l'ID de la personne";
		$text['enternamepart'] = "Introduire le pr�nom ou le nom de famille ";
		$text['pleasenamepart'] = "Veuillez introduire le pr�nom ou le nom de famille.";
		$text['clicktoselect'] = "Cliquez pour s�lectionner";
		$text['nobirthinfo'] = "Pas de donn�es de naissance";
		$text['relateto'] = "Liens de parent� avec";
		$text['sameperson'] = "Les deux individus sont identiques";
		$text['notrelated'] = "Les deux individus n'ont pas de liens de parent� sur xxx g�n�rations.";
		$text['findrelinstr'] = "Pour afficher les liens de parent� entre deux personnes, utilisez le bouton 'Recherche' ci-dessous pour trouver les individus (ou conservez les individus affich�s), ensuite cliquez sur 'Calculer'.";
		$text['gencheck'] = "G�n�rations max <br />� v�rifier";
		$text['sometimes'] = "(Parfois le fait de v�rifier un autre nombre de g�n�rations donne un r�sultat diff�rent)";
		$text['findanother'] = "Trouver un autre lien";
		//added in 6.0.0
		$text['brother'] = "le fr�re de";
		$text['sister'] = "la soeur de";
		$text['sibling'] = "le fr�re ou la soeur de";
		$text['uncle'] = "le xxx oncle de";
		$text['aunt'] = "la xxx tante de";
		$text['uncleaunt'] = "le xxx oncle/tante de";
		$text['nephew'] = "le xxx neveu de";
		$text['niece'] = "la xxx ni�ce de";
		$text['nephnc'] = "le xxx neveu/ni�ce de";
		$text['mcousin'] = "le xxx cousin de";
		$text['fcousin'] = "la xxx cousine de";
		$text['cousin'] = "le xxx cousin de";
		$text['removed'] = "g�n�rations de diff�rence (\"times removed\")";
		$text['rhusband'] = "l'�poux de ";
		$text['rwife'] = "l'�pouse de ";
		$text['rspouse'] = "le conjoint de ";
		$text['son'] = "le fils de";
		$text['daughter'] = "la fille de";
		$text['rchild'] = "l'enfant de";
		$text['sil'] = "le gendre de";
		$text['dil'] = "la bru de";
		$text['sdil'] = "le gendre ou la bru de";
		$text['gson'] = "le xxx petit-fils de";
		$text['gdau'] = "la xxx petite-fille de";
		$text['gsondau'] = "le xxx petit-fils/petite-fille de";
		$text['great'] = "grand";
		$text['spouses'] = "sont conjoints";
		$text['is'] = "est";
		//changed in 6.0.0
		$text['changeto'] = "Changez en:";
		//added in 6.0.0
		$text['notvalid'] = "n'est pas un ID valide ou n'existe pas dans cette base de donn�es.  Veuillez essayer de nouveau.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Page de la";
		$text['ldsords'] = "Ordonnances LDS";
		$text['baptizedlds'] = "Baptis� (LDS)";
		$text['endowedlds'] = "Dot� (LDS)";
		$text['sealedplds'] = "Dot� parents (LDS)";
		$text['sealedslds'] = "Conjoint(e) dot�(e) (LDS)";
		$text['otherspouse'] = "Autre conjoint(e)";
		//changed in 7.0.0
		$text['husband'] = "Mari";
		$text['wife'] = "Femme";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "N";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "D";
		$text['capburialabbr'] = "S";
		$text['capplaceabbr'] = "L";
		$text['capmarrabbr'] = "M";
		$text['redraw'] = "Redessiner avec";
		$text['scrollnote'] = "Notes: Utilisez les barres de d�filement pour voir tout l'arbre.";
		$text['unknownlit'] = "Inconnu";
		$text['popupnote1'] = " = Information suppl�mentaire";
		$text['popupnote2'] = " = Nouvel arbre";
		$text['pedcompact'] = "Compacte";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Texte seul";
		$text['descendfor'] = "Descendance de";
		$text['maxof'] = "Maximum de";
		$text['gensatonce'] = "g�n�rations affich�es en m�me temps";
		$text['sonof'] = "fils de";
		$text['daughterof'] = "fille de";
		$text['childof'] = "enfant de";
		$text['stdformat'] = "Format standard";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "Ajouter une nouvelle famille";
		$text['editfam'] = "Editer la famille";
		$text['side'] = "(Ascendants)";
		$text['familyof'] = "Famille de";
		$text['paternal'] = "Paternel";
		$text['maternal'] = "Maternel";
		$text['gen1'] = "Soi-m�me";
		$text['gen2'] = "Parents";
		$text['gen3'] = "Grand-parents (A�euls)";
		$text['gen4'] = "Bisa�euls ";
		$text['gen5'] = "Trisa�euls";
		$text['gen6'] = "Quatri�mes a�euls";
		$text['gen7'] = "Cinqui�mes a�euls";
		$text['gen8'] = "Sixi�mes a�euls";
		$text['gen9'] = "Septi�mes a�euls";
		$text['gen10'] = "Huiti�mes a�euls";
		$text['gen11'] = "Neuvi�mes a�euls";
		$text['gen12'] = "Dixi�mes a�euls";
		$text['graphdesc'] = "Tableau de descendance jusqu'� ce point";
		$text['collapse'] = "R�duire";
		$text['expand'] = "D�velopper";
		$text['pedbox'] = "Bo�te";
		//changed in 6.0.0
		$text['regformat'] = "Format registre";
		$text['extrasexpl'] = "Si des photos ou des histoires existent pour les individus suivants, les ic�nes correspondantes seront affich�es � c�t� des noms.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nouveau tableau";
		$text['mediaavail'] = "M�dia disponible";
		//changed in 7.0.0
		$text['pedigreefor'] = "Arbre de";
		//added in 7.0.0
		$text['pedigreech'] = "Diagramme d'anc�tres";
		$text['datesloc'] = "Dates et lieux";
		$text['borchr'] = "Naissance/Alt - Mort/Enterrement (deux)";
		$text['nobd'] = "Aucune date de naissance ou de mort";
		$text['bcdb'] = "Naissance/Alt/Mort/Enterrement (quatre)";
		$text['numsys'] = "Syst�me de num�ration";
		$text['gennums'] = "Nombres de g�n�rations";
		$text['henrynums'] = "Num�rotation Henry";
		$text['abovnums'] = "Num�rotation d'Aboville";
		$text['devnums'] = "Num�rotation de Villiers";
		$text['dispopts'] = "Options d'affichage";
		break;

	//search.php, searchform.php
	//merged with reports and showreport in 5.0.0
	case "search":
	case "reports":
		$text['noreports'] = "Aucun rapport.";
		$text['reportname'] = "Nom du rapport";
		$text['allreports'] = "Tous les rapports";
		$text['report'] = "Rapport";
		$text['error'] = "Erreur";
		$text['reportsyntax'] = "La syntaxe de cette requ�te";
		$text['wasincorrect'] = "est incorrecte, et le rapport n'a pu �tre lanc�. Merci de contacter votre administrateur syst�me �";
		$text['query'] = "Requ�te";
		$text['errormessage'] = "Message d'erreur";
		$text['equals'] = "�gal";
		$text['contains'] = "contient";
		$text['startswith'] = "commence par";
		$text['endswith'] = "se termine par";
		$text['soundexof'] = "soundex de";
		$text['metaphoneof'] = "m�taphone de";
		$text['plusminus10'] = "+/- 10 ann�es de";
		$text['lessthan'] = "inf. �";
		$text['greaterthan'] = "sup. �";
		$text['lessthanequal'] = "inf. ou �gale �";
		$text['greaterthanequal'] = "sup. ou �gale �";
		$text['equalto'] = "�gale �";
		$text['tryagain'] = "Veuillez r�essayer";
		$text['text_for'] = "pour";
		$text['searchnames'] = "Recherche";
		$text['joinwith'] = "Lien";
		$text['cap_and'] = "ET";
		$text['cap_or'] = "OU";
		$text['showspouse'] = "Afficher Conjoint(e) (affichera des doublons si une personne a plus d'un(e) conjoint(e))";
		$text['submitquery'] = "Rechercher";
		$text['birthplace'] = "Lieu de naissance";
		$text['deathplace'] = "Lieu de d�c�s";
		$text['birthdatetr'] = "Ann�e de naissance";
		$text['deathdatetr'] = "Ann�e de d�c�s";
		$text['plusminus2'] = "+/- 2 ans de";
		$text['resetall'] = "R�initialiser toutes les valeurs";

		$text['showdeath'] = "Montrer les informations de d�c�s/s�pulture";
		$text['altbirthplace'] = "Lieu de bapt�me";
		$text['altbirthdatetr'] = "Ann�e de bapt�me";
		$text['burialplace'] = "Lieu de la s�pulture";
		$text['burialdatetr'] = "Ann�e de la s�pulture";
		$text['event'] = "Ev�nement(s)";
		$text['day'] = "Jour";
		$text['month'] = "Mois";
		$text['keyword'] = "Mot clef (par exemple, \"Vers\")";
		$text['explain'] = "Introduire les dates pour voir les �v�nements correspondants. Laisser un champ vide pour voir toutes les correspondances.";
		$text['enterdate'] = "Veuillez introduire ou s�lectionner au moins un des �l�ments suivants: Jour, Mois, Ann�e, Mot Cl�:";
		$text['fullname'] = "Nom entier";
		$text['birthdate'] = "Date de naissance";
		$text['altbirthdate'] = "Date de bapt�me";
		$text['marrdate'] = "Date de Mariage";
		$text['spouseid'] = "ID de l'�pouse";
		$text['spousename'] = "Nom de l'�pouse";
		$text['deathdate'] = "Date de d�c�s";
		$text['burialdate'] = "Date de la s�pulture";
		$text['changedate'] = "Date de la derni�re modification";
		$text['gedcom'] = "Arbre";
		$text['baptdate'] = "Date de bapt�me (SDJ)";
		$text['baptplace'] = "Lieu de bapt�me (SDJ)";
		$text['endldate'] = "Date de confirmation (SDJ)";
		$text['endlplace'] = "Lieu de confirmation (SDJ)";
		$text['ssealdate'] = "Date du sceau S (SDJ)";
		$text['ssealplace'] = "Lieu du sceau  S (SDJ)";
		$text['psealdate'] = "Date du sceau  (SDJ)";
		$text['psealplace'] = "Lieu du Sceau P (SDJ)";
		$text['marrplace'] = "Lieu du mariage";
		$text['spousesurname'] = "Nom de famille de l'�pouse";
		//changed in 6.0.0
		$text['spousemore'] = "Si vous entrez une valeur pour le nom de famille de l'�pouse, vous devez entrer au moins une autre valeur.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 ans de";
		$text['exists'] = "existe";
		$text['dnexist'] = "n'existe pas";
		//added in 6.0.3
		$text['divdate'] = "Date du divorce";
		$text['divplace'] = "Lieu du divorce";
		//changed in 7.0.0
		$text['otherevents'] = "Autres �v�nements";
		//added in 7.0.0
		$text['numresults'] = "R�sultats par page";
		$text['mysphoto'] = "Photos myst�res";
		$text['mysperson'] = "Qui sont ces personnes ?";
		$text['joinor'] = "L'option 'Lien avec OU' ne peut pas �tre employ�e avec le nom de famille du conjoint";
		//added in 7.0.1
		$text['tellus'] = "Dites-nous ce que vous savez";
		$text['moreinfo'] = "Plus d'informations:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Fichier Registre pour";
		$text['mostrecentactions'] = "Derni�res actions";
		$text['autorefresh'] = "Rafra�chissement automatique (30 secondes)";
		$text['refreshoff'] = "Supprimer le rafra�chissement automatique";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cimeti�res et Pierres tombales";
		$text['showallhsr'] = "Afficher tous les enregistrements de pierres tombales";
		$text['in'] = "en";
		$text['showmap'] = "Afficher la carte";
		$text['headstonefor'] = "Tombe de";
		$text['photoof'] = "Photo de";
		$text['firstpage'] = "Premi�re page";
		$text['lastpage'] = "Derni�re page";
		$text['photoowner'] = "Source du propri�taire";

		$text['nocemetery'] = "Pas de cimeti�re";
		$text['iptc005'] = "Titre";
		$text['iptc020'] = "Cat�gories suppl�mentaires";
		$text['iptc040'] = "Instructions Sp�ciales";
		$text['iptc055'] = "Date de Cr�ation";
		$text['iptc080'] = "Auteur";
		$text['iptc085'] = "Position de l'auteur";
		$text['iptc090'] = "Ville";
		$text['iptc095'] = "Etat";
		$text['iptc101'] = "Pays";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Titre";
		$text['iptc110'] = "Source";
		$text['iptc115'] = "Source de la photo";
		$text['iptc116'] = "Notice de droit d'auteur";
		$text['iptc120'] = "Sous-titre";
		$text['iptc122'] = "Auteur du sous-titre";
		$text['mapof'] = "Carte de";
		$text['regphotos'] = "Vue Descriptive";
		$text['gallery'] = "Uniquement les vignettes";
		$text['cemphotos'] = "Photos de Cimeti�res";
		//changed in 6.0.0
		$text['photosize'] = "Taille";
		//added in 6.0.0
        	$text['iptc010'] = "Priorit�";
		$text['filesize'] = "Taille du fichier";
		$text['seeloc'] = "Voir lieu";
		$text['showall'] = "Afficher tout";
		$text['editmedia'] = "Edite le m�dia";
		$text['viewitem'] = "Voir cet item";
		$text['editcem'] = "Edite le cimeti�re";
		$text['numitems'] = "# Items";
		$text['allalbums'] = "tous les albums";
		//added in 6.1.0
		$text['slidestart'] = "D�marrer le diaporama";
		$text['slidestop'] = "Arr�ter le diaporama";
		$text['slideresume'] = "Reprendre le diaporama";
		$text['slidesecs'] = "Secondes pour chaque diapositive:";
		$text['minussecs'] = "moins 0,5 seconde";
		$text['plussecs'] = "plus 0,5 seconde";
		//added in 7.0.0
		$text['nocountry'] = "Pays inconnu";
		$text['nostate'] = "�tat inconnu";
		$text['nocounty'] = "Comt� inconnu";
		$text['nocity'] = "Ville inconnue";
		$text['nocemname'] = "Nom du cimeti�re inconnu";
		$text['plot'] = "Lot";
		$text['location'] = "Lieu";
		$text['editalbum'] = "�ditez l'album";
		$text['mediamaptext'] = "<strong>Notez:</strong> D�placez votre pointeur de souris au-dessus de l'image pour exposer les noms. Cliquez sur pour voir une page pour chaque nom.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Afficher les Patronymes commen�ant par";
		$text['showtop'] = "Afficher le haut";
		$text['showallsurnames'] = "Afficher tous les Patronymes";
		$text['sortedalpha'] = "tri alphab�tique";
		$text['byoccurrence'] = "class�s par occurrence";
		$text['firstchars'] = "Premiers cararact�res";
		$text['top'] = "Haut de page";
		$text['mainsurnamepage'] = "Patronymes";
		$text['allsurnames'] = "Tous les Patronymes";
		$text['showmatchingsurnames'] = "Cliquez sur un patronyme pour afficher les r�sultats.";
		$text['backtotop'] = "Retour en haut de la page";
		$text['beginswith'] = "Commen�ant par";
		$text['allbeginningwith'] = "Tous les patronymes commen�ant par";
		$text['numoccurrences'] = "nombre de r�sultats entre parenth�ses";
		$text['placesstarting'] = "Show largest localities starting with";
		$text['showmatchingplaces'] = "Cliquez sur un nom pour voir les enregistrements li�s.";
		$text['totalnames'] = "total des individus";
		$text['showallplaces'] = "Montrer les plus grandes localit�s";
		$text['totalplaces'] = "total des lieux";
		$text['mainplacepage'] = "Page des lieux principaux";
		$text['allplaces'] = "Toutes les plus grandes Localit�s";
		$text['placescont'] = "Montrer tous les lieux qui contiennent";
		//added in 7.0.0
		$text['top30'] = "Les 30 principaux noms de famille";
		$text['top30places'] = "Les 30 plus grandes localit�s";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(xx derniers jours)";
		$text['historiesdocs'] = "Histoires";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Photo";
		$text['history'] = "Histoire/Document";
		//changed in 7.0.0
		$text['husbid'] = "ID Epoux";
		$text['husbname'] = "Nom de l'�poux";
		$text['wifeid'] = "ID Epouse";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Supprimer";
		$text['addperson'] = "Ajouter Individu";
		$text['nobirth'] = "L'individu suivant n'a pas de date de naissance valide et n'a donc pas �t� ajout�";
		$text['noliving'] = "L'individu suivant est enregistr� comme �tant en vie et n'est pas affich� parce que vous n'�tes pas connect� avec les autorisations n�cessaires";
		$text['event'] = "Ev�nement(s)";
		$text['chartwidth'] = "Largeur du graphique";
		//changed in 6.0.0
		$text['timelineinstr'] = "Ajouter des individus (saisir leur ID)";
		//added in 6.0.0
		$text['togglelines'] = "Lignes verticales";
		break;

	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Tous les arbres";
		$text['treename'] = "Nom de l'arbre";
		$text['owner'] = "Propri�taire";
		$text['address'] = "Adresse";
		$text['city'] = "Ville";
		$text['state'] = "Province";
		$text['zip'] = "Code Postal";
		$text['country'] = "Pays";
		$text['email'] = "Adresse �lectronique";
		$text['phone'] = "T�l�phone";
		$text['username'] = "Nom d'utilisateur";
		$text['password'] = "Mot de passe";
		$text['loginfailed'] = "Erreur de connexion.";

		$text['regnewacct'] = "Enregistrement de nouveau compte utilisateur";
		$text['realname'] = "Votre nom r�el";
		$text['phone'] = "T�l�phone";
		$text['email'] = "Adresse �lectronique";
		$text['address'] = "Adresse";
		$text['comments'] = "Notes ou Commentaires";
		$text['submit'] = "Soumettre";
		$text['leaveblank'] = "(laisser en blanc si vous d�sirez un nouvel arbre)";
		$text['required'] = "Champs requis";
		$text['enterpassword'] = "Introduisez un mot de passe.";
		$text['enterusername'] = "Introduisez un nom d'utilisateur.";
		$text['failure'] = "Votre nom d'utilisateur est d�j� pris. Veuillez utiliser le bouton retour de votre navigateur pour revenir � la page pr�c�dente et s�lectionner un autre nom d'utisateur.";
		$text['success'] = "Merci. Nous avons re�u votre enregistrement. Nous vous contacterons quand votre compte sera activ� ou si nous avons besoin de plus d'informations.";
		$text['emailsubject'] = "Demande d'enregistrement de nouvel utisateur TNG";
		$text['emailmsg'] = "Vous avez re�u une nouvelle demande de compte utilisateur TNG. Veuillez vous connecter � la section administration  de TNG et accorder les autorisations appropri�es � ce nouveau compte. Si vous approuvez cet enregistrement, veuillez en informer le demandeur en r�pondant � ce message.";
		//changed in 5.0.0
		$text['enteremail'] = "Veuillez introduire une adresse e-mail valable.";
		$text['website'] = "Site Web";
		$text['nologin'] = "Vous n'avez pas de profil de connexion?";
		$text['loginsent'] = "Vos donn�es de connexion ont �t� envoy�es";
		$text['loginnotsent'] = "Vos donn�es de connexion n'ont pas �t� envoy�es";
		$text['enterrealname'] = "Veuillez entrer votre v�ritable nom.";
		$text['rempass'] = "Restez connect� sur cet ordinateur";
		$text['morestats'] = "Statistiques additionnelles";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTE:</strong> Afin de pouvoir recevoir des courriels de l'administrateur du site concernant votre compte, veuillez vous assurer de ne pas bloquer les courriels provenant de ce domaine.";
		$text['newpassword'] = "Nouveau mot de passe";
		$text['resetpass'] = "Changer de mot de passe";
		//added in 6.1.0
		$text['nousers'] = "Ce formulaire ne peut �tre utilis� s'il n'existe au moins un enregistrement d'utilisateur. Si vous �tes le propri�taire du site, allez sur Admin/Users pour cr�er votre compte d'Administrateur.";
		//added in 7.0.0
		$text['noregs'] = "D�sol�s, mais nous n'acceptons pas de nouveaux enregistrements d'utilisateurs pour le moment. Veuillez  <a href=\"suggest.php\">nous contacter</a> directement si vous avez des commentaires ou des questions concernant n'importe quoi sur ce site Web.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Quantit�";
		$text['totindividuals'] = "Individus";
		$text['totmales'] = "Hommes";
		$text['totfemales'] = "Femmes";
		$text['totunknown'] = "Individus de sexe inconnu";
		$text['totliving'] = "Individus en vie";
		$text['totfamilies'] = "Familles";
		$text['totuniquesn'] = "Noms de famille distincts";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Sources";
		$text['avglifespan'] = "Dur�e de vie moyenne";
		$text['earliestbirth'] = "Naissance la plus ancienne";
		$text['longestlived'] = "Vie la plus longue";
		$text['years'] = "ann�es";
		$text['days'] = "jours";
		$text['age'] = "�ge";
		$text['agedisclaimer'] = "Les calculs li�s � l'�ge sont bas�s sur les individus avec une date de naissance connue <EM> et</EM> une date de d�c�s.  A cause de l'existence de donn�es incompl�tes(p.e. une date de d�c�s enregistr�e comme \"1945\" ou \"AVT 1860\"), ces calculs ne sont pas pr�cis � 100%.";
		$text['treedetail'] = "Plus d'information sur cet arbre";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Montrer toutes les notes";
		break;

	case "help":
		$text['menuhelp'] = "Cl� du Menu";
		break;

 	case "install":
		$text['perms'] = "Les permissions ont �t� d�finies.";
		$text['noperms'] = "Les permissions n'ont pas �t� d�finies pour ces fichiers:";
		$text['manual'] = "Veuillez les d�finir manuellement.";
		$text['folder'] = "Le dossier";
		$text['created'] = "a �t� cr��";
		$text['nocreate'] = "n'a pas �t� cr��. Please create it manually.";
		$text['infosaved'] = "Information sauv�e, connexion v�rifi�e!";
		$text['tablescr'] = "Les tables ont �t� cr��es!";
		$text['notables'] = "Les tables suivantes n'ont pas �t� cr��es:";
		$text['nocomm'] = "TNG ne communique pas avec votre base de donn�es. Aucune table n'a �t� cr��e.";
		$text['newdb'] = "Information sauv�e, connexion v�rifi�e, la nouvelle base de donn�es a �t� cr��e:";
		$text['noattach'] = "Information sauv�e. Connexion �tablie et base de donn�es cr��e, mais TNG ne peut pas s'y rattacher.";
		$text['nodb'] = "Information sauv�e. Connexion �tablie, mais la base de donn�es n'existe pas et n'a pu �tre cr��e ici. Veuillez v�rifier que le nom de la base de donn�es est correct, ou employez votre panneau de commande pour la cr�er.";
		$text['noconn'] = "Information sauv�e mais la connexion n'a pas �t� �tablie. Un ou plusieurs des param�tres suivants est incorrect:";
		$text['exists'] = "est d�j� cr��.";
		$text['loginfirst'] = "Vous devez d'abord ouvrir une session.";
		$text['noop'] = "Aucune op�ration n'a �t� effectu�e.";
		break;
}

//common
$text['matches'] = "R�sultats";
$text['description'] = "Description";
$text['notes'] = "Notes";
$text['status'] = "Statut";
$text['newsearch'] = "Nouvelle Recherche";
$text['pedigree'] = "Arbre";
$text['birthabbr'] = "n.";
$text['chrabbr'] = "b.";
$text['seephoto'] = "Voir photo";
$text['andlocation'] = "et lieu";
$text['accessedby'] = "consult� par";
$text['go'] = " OK ";
$text['family'] = "Famille";
$text['children'] = "Enfants";
$text['tree'] = "Arbre";
$text['alltrees'] = "Tous les arbres";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "Vignette";
$text['people'] = "Personnes";
$text['title'] = "Titre";
$text['suffix'] = "Suffixe";
$text['nickname'] = "Surnom";
$text['deathabbr'] = "d.";
$text['lastmodified'] = "Derni�re modif.";
$text['married'] = "Mariage";
//$text['photos'] = "Photos";
$text['name'] = "Nom";
$text['lastfirst'] = "Nom, Nom donn�(s)";
$text['bornchr'] = "N�/Baptis�";
$text['individuals'] = "Personnes";
$text['families'] = "Familles";
$text['personid'] = "ID personne";
$text['sources'] = "Sources";
$text['unknown'] = "Inconnu";
$text['father'] = "P�re";
$text['mother'] = "M�re";
$text['born'] = "Naissance";
$text['christened'] = "Bapt�me";
$text['died'] = "D�c�s";
$text['buried'] = "S�pulture";
$text['spouse'] = "Conjoint(e)";
$text['parents'] = "Parents";
$text['text'] = "Texte";
$text['language'] = "Langue";
$text['burialabbr'] = "s.";
$text['descendchart'] = "Descendants";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Personnes";
$text['edit'] = "Editer";
$text['date'] = "Date";
$text['place'] = "Lieu";
$text['login'] = "Se connecter";
$text['logout'] = "Se d�connecter";
$text['marrabbr'] = "m.";
$text['groupsheet'] = "Feuille familiale";
$text['text_and'] = "et";
$text['generation'] = "G�n�ration";
$text['filename'] = "Nom de fichier";
$text['id'] = "ID";
$text['search'] = "Chercher";
$text['living'] = "En vie";
$text['user'] = "Utilisateur";
$text['firstname'] = "Pr�nom";
$text['lastname'] = "Nom";
$text['searchresults'] = "R�sultats de la recherche";
$text['diedburied'] = "D�c�d�/S�pulture";
$text['homepage'] = "Page d'accueil";
$text['find'] = "Rechercher...";
$text['relationship'] = "Parent�";
$text['relationship2'] = "Relationship"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Ligne du temps";
$text['yesabbr'] = "Y";
$text['divorced'] = "Divorc�";
$text['indlinked'] = "Li� �";
$text['branch'] = "Branche";
$text['moreind'] = "Plus d'individus";
$text['morefam'] = "Plus de familles";
$text['livingdoc'] = "Au moins un individu vivant est li� � ce document - Details cach�s.";
$text['source'] = "Source";
$text['surnamelist'] = "Liste des Patronymes";
$text['generations'] = "G�n�rations";
$text['refresh'] = "Rafra�chir";
$text['whatsnew'] = "Quoi de neuf ?";
$text['reports'] = "Rapports";
$text['placelist'] = "Liste de Lieux";
$text['baptizedlds'] = "Baptis� (LDS)";
$text['endowedlds'] = "Dot� (LDS)";
$text['sealedplds'] = "Dot� parents (LDS)";
$text['sealedslds'] = "Conjoint(e) dot�(e) (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Anc�tres";
$text['descendants'] = "Descendants";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Date de la derni�re importation GEDCOM";
$text['type'] = "Type";
$text['savechanges'] = "Enregistrer les modifications";
$text['familyid'] = "ID Famille";
$text['headstone'] = "Pierres Tombales";
$text['historiesdocs'] = "Histoires";
$text['livingnote'] = "Au moins une personne vivante est li�e � cette note - Les d�tails ne sont donc pas publi�s.";
$text['anonymous'] = "anonyme";
$text['places'] = "Lieux";
$text['anniversaries'] = "Dates & Anniversaires";
$text['administration'] = "Administration";
$text['help'] = "Aide";
//$text['documents'] = "Documents";
$text['year'] = "Ann�e";
$text['all'] = "Tous";
$text['repository'] = "D�p�t";
$text['address'] = "Adresse";
$text['suggest'] = "Suggestion";
$text['editevent'] = "Sugg�rez une modification pour cet �v�nement";
$text['findplaces'] = "Trouvez tous les individus avec un �v�nement dans ce lieu";
$text['morelinks'] = "Plus de liens";
$text['faminfo'] = "Information sur la Famille";
$text['persinfo'] = "Information Personelle";
$text['srcinfo'] = "Infos sur la source";
$text['fact'] = "Fait";
$text['goto'] = "Selectionnez une page";
$text['tngprint'] = "Imprimer";
//changed in 6.0.0
$text['livingphoto'] = "Au moins un individu vivant est li� � cette photo - Details cach�s.";
$text['databasestatistics'] = "Statistiques";
//moved here in 6.0.0
$text['child'] = "Enfant";
$text['repoinfo'] = "Infos lieu de d�p�t";
$text['tng_reset'] = "Effacer";
$text['noresults'] = "Aucun r�sultat";
//added in 6.0.0
$text['allmedia'] = "Tous les m�dias";
$text['repositories'] = "D�p�ts";
$text['albums'] = "Albums";
$text['cemeteries'] = "Cimeti�res";
$text['surnames'] = "Noms de famille";
$text['dates'] = "Dates";
$text['link'] = "Lien";
$text['media'] = "M�dias";
$text['gender'] = "Sexe";
$text['latitude'] = "Latitude";
$text['longitude'] = "Longitude";
$text['bookmarks'] = "Signets";
$text['bookmark'] = "Ajouter un signet";
$text['mngbookmarks'] = "Afficher les signets";
$text['bookmarked'] = "Signet ajout�";
$text['remove'] = "Effacer";
$text['find_menu'] = "Chercher";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Cimeti�res";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Carte d'�v�nements";
$text['gevents'] = "�v�nements";
$text['glang'] = "&hl=fr";
$text['googleearthlink'] = "Lien Google Earth";
$text['googlemaplink'] = "Lien Google Map";
$text['gmaplegend'] = "L�gende des cartes";
//moved here in 7.0.0
$text['unmarked'] = "non marqu�e(s)";
$text['located'] = "Situ�e(s)";
//added in 7.0.0
$text['albclicksee'] = "Cliquez pour voir tous les items dans cet album";
$text['notyetlocated'] = "Pas encore trouv�";
$text['cremated'] = "Incin�r�";
$text['missing'] = "Manquant";
$text['page'] = "Page";
$text['pdfgen'] = "G�n�rateur de PDF";
$text['blank'] = "Diagramme vide";
$text['none'] = "Aucun";
$text['fonts'] = "Fontes";
$text['header'] = "En-t�te";
$text['data'] = "Donn�es";
$text['pgsetup'] = "Mise en page";
$text['pgsize'] = "Dimensions de la page";
$text['letter'] = "Lettre"; //as in page size
$text['legal'] = "L�gal"; //as in page size
$text['orient'] = "Orientation"; //for a page
$text['portrait'] = "Portrait";
$text['landscape'] = "Paysage";
$text['tmargin'] = "Marge sup�rieure";
$text['bmargin'] = "Marge inf�rieure";
$text['lmargin'] = "Marge de gauche";
$text['rmargin'] = "Marge de droite";
$text['createch'] = "Cr�ez le diagramme";
$text['prefix'] = "Pr�fixe";
$text['mostwanted'] = "Les plus recherch�s";
$text['latupdates'] = "Les derni�res mises � jour";
$text['featphoto'] = "Photo s�lectionn�e";
$text['news'] = "Nouvelles";
$text['ourhist'] = "Histoire de notre famille";
$text['ourhistanc'] = "Histoire et g�n�alogie de notre famille";
$text['ourpages'] = "Page de la g�n�alogie de notre famille";
$text['pwrdby'] = "Ce site est r�alis� gr�ce au logiciel";
$text['writby'] = "�crit par";
$text['searchtngnet'] = "Recherche dans le TNG Network (GENDEX)";
$text['viewphotos'] = "Regardez toutes les photos";
$text['anon'] = "Vous �tes actuellement anonyme";
$text['whichbranch'] = "De quelle branche �tes-vous ?";
$text['featarts'] = "Articles s�lectionn�es";
$text['maintby'] = "G�r� par";
$text['createdon'] = "Cr�� le";


//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Page d'accueil";
$text['mnusearchfornames'] = "Recherche";
$text['mnulastname'] = "Nom de famille";
$text['mnufirstname'] = "Pr�nom";
$text['mnusearch'] = "Chercher";
$text['mnureset'] = "Recommencer";
$text['mnulogon'] = "Se connecter";
$text['mnulogout'] = "Se d�connecter";
$text['mnufeatures'] = "Autres fonctions";
$text['mnuregister'] = "Demander un compte utilisateur";
$text['mnuadvancedsearch'] = "Recherche avanc�e";
$text['mnulastnames'] = "Noms de famille";
$text['mnustatistics'] = "Statistiques";
$text['mnuphotos'] = "Photos";
$text['mnuhistories'] = "Histoires";
$text['mnumyancestors'] = "Photos & Histoires Anc�tres de [Personne]";
$text['mnucemeteries'] = "Cimeti�res";
$text['mnutombstones'] = "Pierre tombales";
$text['mnureports'] = "Rapports";
$text['mnusources'] = "Sources";
$text['mnuwhatsnew'] = "Quoi de neuf?";
$text['mnushowlog'] = "Journal d'acc�s";
$text['mnulanguage'] = "Changer de langue";
$text['mnuadmin'] = "Administration";
$text['welcome'] = "Bienvenue";
$text['contactus'] = "Contactez-nous";
//added in 7.0.0
$text['mnumostwanted'] = "Les plus recherch�s";

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
