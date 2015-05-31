<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Toutes les sources";
		$text['shorttitle'] = "Titre court";
		$text['callnum'] = "Numéro d'archive";
		$text['author'] = "Auteur";
		$text['publisher'] = "Editeur";
		$text['other'] = "Autre information";
		$text['sourceid'] = "Source ID";
		$text['moresrc'] = "Autres sources";
		$text['repoid'] = "ID du Lieu de dépôt";
		$text['browseallrepos'] = "Chercher les lieux de dépôt";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Nouvelle langue";
		$text['changelanguage'] = "Changer la Langue";
		$text['languagesaved'] = "Langue enregistrée";
		//added in 7.0.0
		$text['sitemaint'] = "Entretien du site Web en cours";
		$text['standby'] = "Notre site Web est temporairement hors service pendant que nous mettons à jour notre base de données. Veuillez essayer de nouveau dans quelques minutes. Si notre site Web demeure inaccessible pour une période prolongée, veuillez <a href=\"suggest.php\">contacter le propriétaire du site Web </a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "GEDCOM démarre de";
		$text['producegedfrom'] = "Produire un fichier GEDCOM depuis";
		$text['numgens'] = "Nombre de générations";
		$text['includelds'] = "Inclure information LDS";
		$text['buildged'] = "Contruire GEDCOM";
		$text['gedstartfrom'] = "GEDCOM commence à";
		$text['nomaxgen'] = "Vous devez spécifier un nombre maximum de générations. Veuillez cliquer sur le bouton 'Précédent' et corriger l'erreur";
		$text['gedcreatedfrom'] = "GEDCOM créé depuis";
		$text['gedcreatedfor'] = "créé pour";

		$text['enteremail'] = "Veuillez introduire une adresse e-mail valable.";
		$text['creategedfor'] = "Creer un fichier GEDCOM";
		$text['email'] = "Adresse électronique";
		$text['suggestchange'] = "Suggérez une modification";
		$text['yourname'] = "Votre nom";
		$text['comments'] = "Notes ou Commentaires";
		$text['comments2'] = "Commentaires";
		$text['submitsugg'] = "Soumettez une suggestion";
		$text['proposed'] = "Changement Proposé";
		$text['mailsent'] = "Merci. Votre message a été envoyé.";
		$text['mailnotsent'] = "Désolé, mais votre message n'a pu être envoyé. Veuillez directement contacter xxx à yyy";
		$text['mailme'] = "Envoyez une copie à cette addresse";
		//added in 5.0.5
		$text['entername'] = "Merci d'inscrire votre nom";
		$text['entercomments'] = "Merci d'inscrire vos commentaires";
		$text['sendmsg'] = "Envoyer le message";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Photos et historique de";
		$text['indinfofor'] = "Info personnelle concernant";
		$text['reliability'] = "Fiabilité";
		$text['pp'] = "pp.";
		$text['age'] = "âge";
		$text['agency'] = "Agence";
		$text['cause'] = "Cause";
		$text['suggested'] = "Suggéré";
		$text['closewindow'] = "Fermez cette fenêtre";
		$text['thanks'] = "Merci";
		$text['received'] = "Le changement que vous avez proposé sera inclus après vérification par l'administrateur du site.";
		//added in 6.0.0
		$text['association'] = "Association";
		//added in 7.0.0
		$text['indreport'] = "Rapport individuel";
		$text['indreportfor'] = "Rapport individuel pour";
		$text['general'] = "Généralités";
		$text['labels'] = "Étiquettes";
		$text['bkmkvis'] = "<strong>Note:</strong> Ces signets sont seulement visibles sur cet ordinateur et avec ce navigateur.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Calculateur de liens de parenté";
		$text['findrel'] = "Recherche de liens de parenté";
		$text['person1'] = "Personne 1:";
		$text['person2'] = "Personne 2:";
		$text['calculate'] = "Calcul";
		$text['select2inds'] = "Veuillez sélectionner deux individus.";
		$text['findpersonid'] = "Trouvez l'ID de la personne";
		$text['enternamepart'] = "Introduire le prénom ou le nom de famille ";
		$text['pleasenamepart'] = "Veuillez introduire le prénom ou le nom de famille.";
		$text['clicktoselect'] = "Cliquez pour sélectionner";
		$text['nobirthinfo'] = "Pas de données de naissance";
		$text['relateto'] = "Liens de parenté avec";
		$text['sameperson'] = "Les deux individus sont identiques";
		$text['notrelated'] = "Les deux individus n'ont pas de liens de parenté sur xxx générations.";
		$text['findrelinstr'] = "Pour afficher les liens de parenté entre deux personnes, utilisez le bouton 'Recherche' ci-dessous pour trouver les individus (ou conservez les individus affichés), ensuite cliquez sur 'Calculer'.";
		$text['gencheck'] = "Générations max <br />à vérifier";
		$text['sometimes'] = "(Parfois le fait de vérifier un autre nombre de générations donne un résultat différent)";
		$text['findanother'] = "Trouver un autre lien";
		//added in 6.0.0
		$text['brother'] = "le frère de";
		$text['sister'] = "la soeur de";
		$text['sibling'] = "le frère ou la soeur de";
		$text['uncle'] = "le xxx oncle de";
		$text['aunt'] = "la xxx tante de";
		$text['uncleaunt'] = "le xxx oncle/tante de";
		$text['nephew'] = "le xxx neveu de";
		$text['niece'] = "la xxx nièce de";
		$text['nephnc'] = "le xxx neveu/nièce de";
		$text['mcousin'] = "le xxx cousin de";
		$text['fcousin'] = "la xxx cousine de";
		$text['cousin'] = "le xxx cousin de";
		$text['removed'] = "générations de différence (\"times removed\")";
		$text['rhusband'] = "l'époux de ";
		$text['rwife'] = "l'épouse de ";
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
		$text['notvalid'] = "n'est pas un ID valide ou n'existe pas dans cette base de données.  Veuillez essayer de nouveau.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Page de la";
		$text['ldsords'] = "Ordonnances LDS";
		$text['baptizedlds'] = "Baptisé (LDS)";
		$text['endowedlds'] = "Doté (LDS)";
		$text['sealedplds'] = "Doté parents (LDS)";
		$text['sealedslds'] = "Conjoint(e) doté(e) (LDS)";
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
		$text['scrollnote'] = "Notes: Utilisez les barres de défilement pour voir tout l'arbre.";
		$text['unknownlit'] = "Inconnu";
		$text['popupnote1'] = " = Information supplémentaire";
		$text['popupnote2'] = " = Nouvel arbre";
		$text['pedcompact'] = "Compacte";
		$text['pedstandard'] = "Standard";
		$text['pedtextonly'] = "Texte seul";
		$text['descendfor'] = "Descendance de";
		$text['maxof'] = "Maximum de";
		$text['gensatonce'] = "générations affichées en même temps";
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
		$text['gen1'] = "Soi-même";
		$text['gen2'] = "Parents";
		$text['gen3'] = "Grand-parents (Aïeuls)";
		$text['gen4'] = "Bisaïeuls ";
		$text['gen5'] = "Trisaïeuls";
		$text['gen6'] = "Quatrièmes aïeuls";
		$text['gen7'] = "Cinquièmes aïeuls";
		$text['gen8'] = "Sixièmes aïeuls";
		$text['gen9'] = "Septièmes aïeuls";
		$text['gen10'] = "Huitièmes aïeuls";
		$text['gen11'] = "Neuvièmes aïeuls";
		$text['gen12'] = "Dixièmes aïeuls";
		$text['graphdesc'] = "Tableau de descendance jusqu'à ce point";
		$text['collapse'] = "Réduire";
		$text['expand'] = "Développer";
		$text['pedbox'] = "Boîte";
		//changed in 6.0.0
		$text['regformat'] = "Format registre";
		$text['extrasexpl'] = "Si des photos ou des histoires existent pour les individus suivants, les icônes correspondantes seront affichées à côté des noms.";
		//added in 6.0.0
		$text['popupnote3'] = " = Nouveau tableau";
		$text['mediaavail'] = "Média disponible";
		//changed in 7.0.0
		$text['pedigreefor'] = "Arbre de";
		//added in 7.0.0
		$text['pedigreech'] = "Diagramme d'ancêtres";
		$text['datesloc'] = "Dates et lieux";
		$text['borchr'] = "Naissance/Alt - Mort/Enterrement (deux)";
		$text['nobd'] = "Aucune date de naissance ou de mort";
		$text['bcdb'] = "Naissance/Alt/Mort/Enterrement (quatre)";
		$text['numsys'] = "Système de numération";
		$text['gennums'] = "Nombres de générations";
		$text['henrynums'] = "Numérotation Henry";
		$text['abovnums'] = "Numérotation d'Aboville";
		$text['devnums'] = "Numérotation de Villiers";
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
		$text['reportsyntax'] = "La syntaxe de cette requête";
		$text['wasincorrect'] = "est incorrecte, et le rapport n'a pu être lancé. Merci de contacter votre administrateur système à";
		$text['query'] = "Requète";
		$text['errormessage'] = "Message d'erreur";
		$text['equals'] = "égal";
		$text['contains'] = "contient";
		$text['startswith'] = "commence par";
		$text['endswith'] = "se termine par";
		$text['soundexof'] = "soundex de";
		$text['metaphoneof'] = "métaphone de";
		$text['plusminus10'] = "+/- 10 années de";
		$text['lessthan'] = "inf. à";
		$text['greaterthan'] = "sup. à";
		$text['lessthanequal'] = "inf. ou égale à";
		$text['greaterthanequal'] = "sup. ou égale à";
		$text['equalto'] = "égale à";
		$text['tryagain'] = "Veuillez réessayer";
		$text['text_for'] = "pour";
		$text['searchnames'] = "Recherche";
		$text['joinwith'] = "Lien";
		$text['cap_and'] = "ET";
		$text['cap_or'] = "OU";
		$text['showspouse'] = "Afficher Conjoint(e) (affichera des doublons si une personne a plus d'un(e) conjoint(e))";
		$text['submitquery'] = "Rechercher";
		$text['birthplace'] = "Lieu de naissance";
		$text['deathplace'] = "Lieu de décès";
		$text['birthdatetr'] = "Année de naissance";
		$text['deathdatetr'] = "Année de décès";
		$text['plusminus2'] = "+/- 2 ans de";
		$text['resetall'] = "Réinitialiser toutes les valeurs";

		$text['showdeath'] = "Montrer les informations de décès/sépulture";
		$text['altbirthplace'] = "Lieu de baptême";
		$text['altbirthdatetr'] = "Année de baptême";
		$text['burialplace'] = "Lieu de la sépulture";
		$text['burialdatetr'] = "Année de la sépulture";
		$text['event'] = "Evènement(s)";
		$text['day'] = "Jour";
		$text['month'] = "Mois";
		$text['keyword'] = "Mot clef (par exemple, \"Vers\")";
		$text['explain'] = "Introduire les dates pour voir les évènements correspondants. Laisser un champ vide pour voir toutes les correspondances.";
		$text['enterdate'] = "Veuillez introduire ou sélectionner au moins un des éléments suivants: Jour, Mois, Année, Mot Clé:";
		$text['fullname'] = "Nom entier";
		$text['birthdate'] = "Date de naissance";
		$text['altbirthdate'] = "Date de baptême";
		$text['marrdate'] = "Date de Mariage";
		$text['spouseid'] = "ID de l'épouse";
		$text['spousename'] = "Nom de l'épouse";
		$text['deathdate'] = "Date de décès";
		$text['burialdate'] = "Date de la sépulture";
		$text['changedate'] = "Date de la dernière modification";
		$text['gedcom'] = "Arbre";
		$text['baptdate'] = "Date de baptême (SDJ)";
		$text['baptplace'] = "Lieu de baptême (SDJ)";
		$text['endldate'] = "Date de confirmation (SDJ)";
		$text['endlplace'] = "Lieu de confirmation (SDJ)";
		$text['ssealdate'] = "Date du sceau S (SDJ)";
		$text['ssealplace'] = "Lieu du sceau  S (SDJ)";
		$text['psealdate'] = "Date du sceau  (SDJ)";
		$text['psealplace'] = "Lieu du Sceau P (SDJ)";
		$text['marrplace'] = "Lieu du mariage";
		$text['spousesurname'] = "Nom de famille de l'épouse";
		//changed in 6.0.0
		$text['spousemore'] = "Si vous entrez une valeur pour le nom de famille de l'épouse, vous devez entrer au moins une autre valeur.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 ans de";
		$text['exists'] = "existe";
		$text['dnexist'] = "n'existe pas";
		//added in 6.0.3
		$text['divdate'] = "Date du divorce";
		$text['divplace'] = "Lieu du divorce";
		//changed in 7.0.0
		$text['otherevents'] = "Autres événements";
		//added in 7.0.0
		$text['numresults'] = "Résultats par page";
		$text['mysphoto'] = "Photos mystères";
		$text['mysperson'] = "Qui sont ces personnes ?";
		$text['joinor'] = "L'option 'Lien avec OU' ne peut pas être employée avec le nom de famille du conjoint";
		//added in 7.0.1
		$text['tellus'] = "Dites-nous ce que vous savez";
		$text['moreinfo'] = "Plus d'informations:";
		break;

	//showlog.php
	case "showlog":
		$text['logfilefor'] = "Fichier Registre pour";
		$text['mostrecentactions'] = "Dernières actions";
		$text['autorefresh'] = "Rafraîchissement automatique (30 secondes)";
		$text['refreshoff'] = "Supprimer le rafraîchissement automatique";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Cimetières et Pierres tombales";
		$text['showallhsr'] = "Afficher tous les enregistrements de pierres tombales";
		$text['in'] = "en";
		$text['showmap'] = "Afficher la carte";
		$text['headstonefor'] = "Tombe de";
		$text['photoof'] = "Photo de";
		$text['firstpage'] = "Première page";
		$text['lastpage'] = "Dernière page";
		$text['photoowner'] = "Source du propriétaire";

		$text['nocemetery'] = "Pas de cimetière";
		$text['iptc005'] = "Titre";
		$text['iptc020'] = "Catégories supplémentaires";
		$text['iptc040'] = "Instructions Spéciales";
		$text['iptc055'] = "Date de Création";
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
		$text['cemphotos'] = "Photos de Cimetières";
		//changed in 6.0.0
		$text['photosize'] = "Taille";
		//added in 6.0.0
        	$text['iptc010'] = "Priorité";
		$text['filesize'] = "Taille du fichier";
		$text['seeloc'] = "Voir lieu";
		$text['showall'] = "Afficher tout";
		$text['editmedia'] = "Edite le média";
		$text['viewitem'] = "Voir cet item";
		$text['editcem'] = "Edite le cimetière";
		$text['numitems'] = "# Items";
		$text['allalbums'] = "tous les albums";
		//added in 6.1.0
		$text['slidestart'] = "Démarrer le diaporama";
		$text['slidestop'] = "Arrêter le diaporama";
		$text['slideresume'] = "Reprendre le diaporama";
		$text['slidesecs'] = "Secondes pour chaque diapositive:";
		$text['minussecs'] = "moins 0,5 seconde";
		$text['plussecs'] = "plus 0,5 seconde";
		//added in 7.0.0
		$text['nocountry'] = "Pays inconnu";
		$text['nostate'] = "État inconnu";
		$text['nocounty'] = "Comté inconnu";
		$text['nocity'] = "Ville inconnue";
		$text['nocemname'] = "Nom du cimetière inconnu";
		$text['plot'] = "Lot";
		$text['location'] = "Lieu";
		$text['editalbum'] = "Éditez l'album";
		$text['mediamaptext'] = "<strong>Notez:</strong> Déplacez votre pointeur de souris au-dessus de l'image pour exposer les noms. Cliquez sur pour voir une page pour chaque nom.";
		break;

	//surnames.php, surnames100.php, surnames-all.php, surnames-oneletter.php
	case "surnames":
	case "places";
		$text['surnamesstarting'] = "Afficher les Patronymes commençant par";
		$text['showtop'] = "Afficher le haut";
		$text['showallsurnames'] = "Afficher tous les Patronymes";
		$text['sortedalpha'] = "tri alphabétique";
		$text['byoccurrence'] = "classés par occurrence";
		$text['firstchars'] = "Premiers cararactères";
		$text['top'] = "Haut de page";
		$text['mainsurnamepage'] = "Patronymes";
		$text['allsurnames'] = "Tous les Patronymes";
		$text['showmatchingsurnames'] = "Cliquez sur un patronyme pour afficher les résultats.";
		$text['backtotop'] = "Retour en haut de la page";
		$text['beginswith'] = "Commençant par";
		$text['allbeginningwith'] = "Tous les patronymes commençant par";
		$text['numoccurrences'] = "nombre de résultats entre parenthèses";
		$text['placesstarting'] = "Show largest localities starting with";
		$text['showmatchingplaces'] = "Cliquez sur un nom pour voir les enregistrements liés.";
		$text['totalnames'] = "total des individus";
		$text['showallplaces'] = "Montrer les plus grandes localités";
		$text['totalplaces'] = "total des lieux";
		$text['mainplacepage'] = "Page des lieux principaux";
		$text['allplaces'] = "Toutes les plus grandes Localités";
		$text['placescont'] = "Montrer tous les lieux qui contiennent";
		//added in 7.0.0
		$text['top30'] = "Les 30 principaux noms de famille";
		$text['top30places'] = "Les 30 plus grandes localités";
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
		$text['husbname'] = "Nom de l'époux";
		$text['wifeid'] = "ID Epouse";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Supprimer";
		$text['addperson'] = "Ajouter Individu";
		$text['nobirth'] = "L'individu suivant n'a pas de date de naissance valide et n'a donc pas été ajouté";
		$text['noliving'] = "L'individu suivant est enregistré comme étant en vie et n'est pas affiché parce que vous n'êtes pas connecté avec les autorisations nécessaires";
		$text['event'] = "Evènement(s)";
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
		$text['owner'] = "Propriétaire";
		$text['address'] = "Adresse";
		$text['city'] = "Ville";
		$text['state'] = "Province";
		$text['zip'] = "Code Postal";
		$text['country'] = "Pays";
		$text['email'] = "Adresse électronique";
		$text['phone'] = "Téléphone";
		$text['username'] = "Nom d'utilisateur";
		$text['password'] = "Mot de passe";
		$text['loginfailed'] = "Erreur de connexion.";

		$text['regnewacct'] = "Enregistrement de nouveau compte utilisateur";
		$text['realname'] = "Votre nom réel";
		$text['phone'] = "Téléphone";
		$text['email'] = "Adresse électronique";
		$text['address'] = "Adresse";
		$text['comments'] = "Notes ou Commentaires";
		$text['submit'] = "Soumettre";
		$text['leaveblank'] = "(laisser en blanc si vous désirez un nouvel arbre)";
		$text['required'] = "Champs requis";
		$text['enterpassword'] = "Introduisez un mot de passe.";
		$text['enterusername'] = "Introduisez un nom d'utilisateur.";
		$text['failure'] = "Votre nom d'utilisateur est déjà pris. Veuillez utiliser le bouton retour de votre navigateur pour revenir à la page précédente et sélectionner un autre nom d'utisateur.";
		$text['success'] = "Merci. Nous avons reçu votre enregistrement. Nous vous contacterons quand votre compte sera activé ou si nous avons besoin de plus d'informations.";
		$text['emailsubject'] = "Demande d'enregistrement de nouvel utisateur TNG";
		$text['emailmsg'] = "Vous avez reçu une nouvelle demande de compte utilisateur TNG. Veuillez vous connecter à la section administration  de TNG et accorder les autorisations appropriées à ce nouveau compte. Si vous approuvez cet enregistrement, veuillez en informer le demandeur en répondant à ce message.";
		//changed in 5.0.0
		$text['enteremail'] = "Veuillez introduire une adresse e-mail valable.";
		$text['website'] = "Site Web";
		$text['nologin'] = "Vous n'avez pas de profil de connexion?";
		$text['loginsent'] = "Vos données de connexion ont été envoyées";
		$text['loginnotsent'] = "Vos données de connexion n'ont pas été envoyées";
		$text['enterrealname'] = "Veuillez entrer votre véritable nom.";
		$text['rempass'] = "Restez connecté sur cet ordinateur";
		$text['morestats'] = "Statistiques additionnelles";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTE:</strong> Afin de pouvoir recevoir des courriels de l'administrateur du site concernant votre compte, veuillez vous assurer de ne pas bloquer les courriels provenant de ce domaine.";
		$text['newpassword'] = "Nouveau mot de passe";
		$text['resetpass'] = "Changer de mot de passe";
		//added in 6.1.0
		$text['nousers'] = "Ce formulaire ne peut être utilisé s'il n'existe au moins un enregistrement d'utilisateur. Si vous êtes le propriétaire du site, allez sur Admin/Users pour créer votre compte d'Administrateur.";
		//added in 7.0.0
		$text['noregs'] = "Désolés, mais nous n'acceptons pas de nouveaux enregistrements d'utilisateurs pour le moment. Veuillez  <a href=\"suggest.php\">nous contacter</a> directement si vous avez des commentaires ou des questions concernant n'importe quoi sur ce site Web.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Quantité";
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
		$text['avglifespan'] = "Durée de vie moyenne";
		$text['earliestbirth'] = "Naissance la plus ancienne";
		$text['longestlived'] = "Vie la plus longue";
		$text['years'] = "années";
		$text['days'] = "jours";
		$text['age'] = "âge";
		$text['agedisclaimer'] = "Les calculs liés à l'âge sont basés sur les individus avec une date de naissance connue <EM> et</EM> une date de décès.  A cause de l'existence de données incomplètes(p.e. une date de décès enregistrée comme \"1945\" ou \"AVT 1860\"), ces calculs ne sont pas précis à 100%.";
		$text['treedetail'] = "Plus d'information sur cet arbre";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Montrer toutes les notes";
		break;

	case "help":
		$text['menuhelp'] = "Clé du Menu";
		break;

 	case "install":
		$text['perms'] = "Les permissions ont été définies.";
		$text['noperms'] = "Les permissions n'ont pas été définies pour ces fichiers:";
		$text['manual'] = "Veuillez les définir manuellement.";
		$text['folder'] = "Le dossier";
		$text['created'] = "a été créé";
		$text['nocreate'] = "n'a pas été créé. Please create it manually.";
		$text['infosaved'] = "Information sauvée, connexion vérifiée!";
		$text['tablescr'] = "Les tables ont été créées!";
		$text['notables'] = "Les tables suivantes n'ont pas été créées:";
		$text['nocomm'] = "TNG ne communique pas avec votre base de données. Aucune table n'a été créée.";
		$text['newdb'] = "Information sauvée, connexion vérifiée, la nouvelle base de données a été créée:";
		$text['noattach'] = "Information sauvée. Connexion établie et base de données créée, mais TNG ne peut pas s'y rattacher.";
		$text['nodb'] = "Information sauvée. Connexion établie, mais la base de données n'existe pas et n'a pu être créée ici. Veuillez vérifier que le nom de la base de données est correct, ou employez votre panneau de commande pour la créer.";
		$text['noconn'] = "Information sauvée mais la connexion n'a pas été établie. Un ou plusieurs des paramètres suivants est incorrect:";
		$text['exists'] = "est déjà créé.";
		$text['loginfirst'] = "Vous devez d'abord ouvrir une session.";
		$text['noop'] = "Aucune opération n'a été effectuée.";
		break;
}

//common
$text['matches'] = "Résultats";
$text['description'] = "Description";
$text['notes'] = "Notes";
$text['status'] = "Statut";
$text['newsearch'] = "Nouvelle Recherche";
$text['pedigree'] = "Arbre";
$text['birthabbr'] = "n.";
$text['chrabbr'] = "b.";
$text['seephoto'] = "Voir photo";
$text['andlocation'] = "et lieu";
$text['accessedby'] = "consulté par";
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
$text['lastmodified'] = "Dernière modif.";
$text['married'] = "Mariage";
//$text['photos'] = "Photos";
$text['name'] = "Nom";
$text['lastfirst'] = "Nom, Nom donné(s)";
$text['bornchr'] = "Né/Baptisé";
$text['individuals'] = "Personnes";
$text['families'] = "Familles";
$text['personid'] = "ID personne";
$text['sources'] = "Sources";
$text['unknown'] = "Inconnu";
$text['father'] = "Père";
$text['mother'] = "Mère";
$text['born'] = "Naissance";
$text['christened'] = "Baptême";
$text['died'] = "Décès";
$text['buried'] = "Sépulture";
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
$text['logout'] = "Se déconnecter";
$text['marrabbr'] = "m.";
$text['groupsheet'] = "Feuille familiale";
$text['text_and'] = "et";
$text['generation'] = "Génération";
$text['filename'] = "Nom de fichier";
$text['id'] = "ID";
$text['search'] = "Chercher";
$text['living'] = "En vie";
$text['user'] = "Utilisateur";
$text['firstname'] = "Prénom";
$text['lastname'] = "Nom";
$text['searchresults'] = "Résultats de la recherche";
$text['diedburied'] = "Décédé/Sépulture";
$text['homepage'] = "Page d'accueil";
$text['find'] = "Rechercher...";
$text['relationship'] = "Parenté";
$text['relationship2'] = "Relationship"; //different in some languages, at least in German (Beziehung)
$text['timeline'] = "Ligne du temps";
$text['yesabbr'] = "Y";
$text['divorced'] = "Divorcé";
$text['indlinked'] = "Lié à";
$text['branch'] = "Branche";
$text['moreind'] = "Plus d'individus";
$text['morefam'] = "Plus de familles";
$text['livingdoc'] = "Au moins un individu vivant est lié à ce document - Details cachés.";
$text['source'] = "Source";
$text['surnamelist'] = "Liste des Patronymes";
$text['generations'] = "Générations";
$text['refresh'] = "Rafraîchir";
$text['whatsnew'] = "Quoi de neuf ?";
$text['reports'] = "Rapports";
$text['placelist'] = "Liste de Lieux";
$text['baptizedlds'] = "Baptisé (LDS)";
$text['endowedlds'] = "Doté (LDS)";
$text['sealedplds'] = "Doté parents (LDS)";
$text['sealedslds'] = "Conjoint(e) doté(e) (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "Ancêtres";
$text['descendants'] = "Descendants";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Date de la dernière importation GEDCOM";
$text['type'] = "Type";
$text['savechanges'] = "Enregistrer les modifications";
$text['familyid'] = "ID Famille";
$text['headstone'] = "Pierres Tombales";
$text['historiesdocs'] = "Histoires";
$text['livingnote'] = "Au moins une personne vivante est liée à cette note - Les détails ne sont donc pas publiés.";
$text['anonymous'] = "anonyme";
$text['places'] = "Lieux";
$text['anniversaries'] = "Dates & Anniversaires";
$text['administration'] = "Administration";
$text['help'] = "Aide";
//$text['documents'] = "Documents";
$text['year'] = "Année";
$text['all'] = "Tous";
$text['repository'] = "Dépôt";
$text['address'] = "Adresse";
$text['suggest'] = "Suggestion";
$text['editevent'] = "Suggérez une modification pour cet évènement";
$text['findplaces'] = "Trouvez tous les individus avec un évènement dans ce lieu";
$text['morelinks'] = "Plus de liens";
$text['faminfo'] = "Information sur la Famille";
$text['persinfo'] = "Information Personelle";
$text['srcinfo'] = "Infos sur la source";
$text['fact'] = "Fait";
$text['goto'] = "Selectionnez une page";
$text['tngprint'] = "Imprimer";
//changed in 6.0.0
$text['livingphoto'] = "Au moins un individu vivant est lié à cette photo - Details cachés.";
$text['databasestatistics'] = "Statistiques";
//moved here in 6.0.0
$text['child'] = "Enfant";
$text['repoinfo'] = "Infos lieu de dépôt";
$text['tng_reset'] = "Effacer";
$text['noresults'] = "Aucun résultat";
//added in 6.0.0
$text['allmedia'] = "Tous les médias";
$text['repositories'] = "Dépôts";
$text['albums'] = "Albums";
$text['cemeteries'] = "Cimetières";
$text['surnames'] = "Noms de famille";
$text['dates'] = "Dates";
$text['link'] = "Lien";
$text['media'] = "Médias";
$text['gender'] = "Sexe";
$text['latitude'] = "Latitude";
$text['longitude'] = "Longitude";
$text['bookmarks'] = "Signets";
$text['bookmark'] = "Ajouter un signet";
$text['mngbookmarks'] = "Afficher les signets";
$text['bookmarked'] = "Signet ajouté";
$text['remove'] = "Effacer";
$text['find_menu'] = "Chercher";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Cimetières";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Carte d'événements";
$text['gevents'] = "Événements";
$text['glang'] = "&hl=fr";
$text['googleearthlink'] = "Lien Google Earth";
$text['googlemaplink'] = "Lien Google Map";
$text['gmaplegend'] = "Légende des cartes";
//moved here in 7.0.0
$text['unmarked'] = "non marquée(s)";
$text['located'] = "Située(s)";
//added in 7.0.0
$text['albclicksee'] = "Cliquez pour voir tous les items dans cet album";
$text['notyetlocated'] = "Pas encore trouvé";
$text['cremated'] = "Incinéré";
$text['missing'] = "Manquant";
$text['page'] = "Page";
$text['pdfgen'] = "Générateur de PDF";
$text['blank'] = "Diagramme vide";
$text['none'] = "Aucun";
$text['fonts'] = "Fontes";
$text['header'] = "En-tête";
$text['data'] = "Données";
$text['pgsetup'] = "Mise en page";
$text['pgsize'] = "Dimensions de la page";
$text['letter'] = "Lettre"; //as in page size
$text['legal'] = "Légal"; //as in page size
$text['orient'] = "Orientation"; //for a page
$text['portrait'] = "Portrait";
$text['landscape'] = "Paysage";
$text['tmargin'] = "Marge supérieure";
$text['bmargin'] = "Marge inférieure";
$text['lmargin'] = "Marge de gauche";
$text['rmargin'] = "Marge de droite";
$text['createch'] = "Créez le diagramme";
$text['prefix'] = "Préfixe";
$text['mostwanted'] = "Les plus recherchés";
$text['latupdates'] = "Les dernières mises à jour";
$text['featphoto'] = "Photo sélectionnée";
$text['news'] = "Nouvelles";
$text['ourhist'] = "Histoire de notre famille";
$text['ourhistanc'] = "Histoire et généalogie de notre famille";
$text['ourpages'] = "Page de la généalogie de notre famille";
$text['pwrdby'] = "Ce site est réalisé grâce au logiciel";
$text['writby'] = "écrit par";
$text['searchtngnet'] = "Recherche dans le TNG Network (GENDEX)";
$text['viewphotos'] = "Regardez toutes les photos";
$text['anon'] = "Vous êtes actuellement anonyme";
$text['whichbranch'] = "De quelle branche êtes-vous ?";
$text['featarts'] = "Articles sélectionnées";
$text['maintby'] = "Géré par";
$text['createdon'] = "Créé le";


//for home page, from Nuke Add-on, added here in 5.0.0
$text['mnuheader'] = "Page d'accueil";
$text['mnusearchfornames'] = "Recherche";
$text['mnulastname'] = "Nom de famille";
$text['mnufirstname'] = "Prénom";
$text['mnusearch'] = "Chercher";
$text['mnureset'] = "Recommencer";
$text['mnulogon'] = "Se connecter";
$text['mnulogout'] = "Se déconnecter";
$text['mnufeatures'] = "Autres fonctions";
$text['mnuregister'] = "Demander un compte utilisateur";
$text['mnuadvancedsearch'] = "Recherche avancée";
$text['mnulastnames'] = "Noms de famille";
$text['mnustatistics'] = "Statistiques";
$text['mnuphotos'] = "Photos";
$text['mnuhistories'] = "Histoires";
$text['mnumyancestors'] = "Photos & Histoires Ancêtres de [Personne]";
$text['mnucemeteries'] = "Cimetières";
$text['mnutombstones'] = "Pierre tombales";
$text['mnureports'] = "Rapports";
$text['mnusources'] = "Sources";
$text['mnuwhatsnew'] = "Quoi de neuf?";
$text['mnushowlog'] = "Journal d'accès";
$text['mnulanguage'] = "Changer de langue";
$text['mnuadmin'] = "Administration";
$text['welcome'] = "Bienvenue";
$text['contactus'] = "Contactez-nous";
//added in 7.0.0
$text['mnumostwanted'] = "Les plus recherchés";

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
