<?php
switch ( $textpart ) {
	//browsesources.php, showsource.php
	case "sources":
		$text['browseallsources'] = "Φυλλομέτρημα Πηγών";
		$text['shorttitle'] = "Περιληπτικός Τίτλος";
		$text['callnum'] = "Call Number";
		$text['author'] = "Συγγραφέας";
		$text['publisher'] = "Εκδότης";
		$text['other'] = "Άλλες Πληροφορίες";
		$text['sourceid'] = "Κωδικός Πηγής";
		$text['moresrc'] = "Άλλες πηγές";
		$text['repoid'] = "ID Αποθετηρίου";
		$text['browseallrepos'] = "Εποσκόπηση σε όλα τα Αποθετήρια";
		break;

	//changelanguage.php, savelanguage.php
	case "language":
		$text['newlanguage'] = "Νέα Γλώσσα";
		$text['changelanguage'] = "Αλλαγή Γλώσσας";
		$text['languagesaved'] = "Γλώσσα Αποθηκεύτηκε";
		//added in 7.0.0
		$text['sitemaint'] = "Site maintenance in progress";
		$text['standby'] = "The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.";
		break;

	//gedcom.php, gedform.php
	case "gedcom":
		$text['gedstart'] = "Αρχείο GEDCOM που ξεκινά από";
		$text['producegedfrom'] = "Δημιουργία αρχείου GEDCOM από";
		$text['numgens'] = "Αριθμός γενεών";
		$text['includelds'] = "Να συμπεριληφθούν πληροφορίες LDS";
		$text['buildged'] = "Κατασκευή GEDCOM";
		$text['gedstartfrom'] = "Αρχείο GEDCOM που ξεκινά από";
		$text['nomaxgen'] = "Πρέπει να δηλώσετε τον μέγιστο αριθμό γενεών. Παρακαλώ χρησιμοποιήστε το κουμπί Πίσω για να επιστρέψετε στην προηγούμενη σελίδα και να διορθώσετε το λάθος";
		$text['gedcreatedfrom'] = "Το GEDCOM δημιουργήθηκε από";
		$text['gedcreatedfor'] = "δημιουργήθηκε για";

		$text['enteremail'] = "Παρακαλώ εισάγετε έγκυρη διεύθυνση ηλεκτρονικού ταχυδρομείου.";
		$text['creategedfor'] = "Δημιουργία GEDCOM";
		$text['email'] = "Διεύθυνση Ηλεκτρονικού Ταχυδρομείου";
		$text['suggestchange'] = "Προτείνετε κάποια αλλαγή";
		$text['yourname'] = "Το όνομά σας";
		$text['comments'] = "Σημειώσεις ή Σχόλια";
		$text['comments2'] = "Σχόλια";
		$text['submitsugg'] = "Υποβολή Πρότασης";
		$text['proposed'] = "Προτεινόμενη Αλλαγή";
		$text['mailsent'] = "Ευχαριστούμε. Το μήνυμά σας έχει σταλεί.";
		$text['mailnotsent'] = "Μας συγχωρείτε, το μήνυμά σας δεν μπορέσαμε να το παραδώσουμε. Παρακαλώ επικοινωνήστε με τον διαχειριστή απευθείας στο yyy.";
		$text['mailme'] = "Στείλε αντίγραφο στη διεύθυνση αυτή";
		//added in 5.0.5
		$text['entername'] = "Please enter your name";
		$text['entercomments'] = "Please enter your comments";
		$text['sendmsg'] = "Send Message";
		break;

	//getextras.php, getperson.php
	case "getperson":
		$text['photoshistoriesfor'] = "Φωτογραφίες και Ιστορικά για";
		$text['indinfofor'] = "Ατομικές πληροφορίες για";
		$text['reliability'] = "Αξιοπιστία";
		$text['pp'] = "pp.";
		$text['age'] = "Ηλικία";
		$text['agency'] = "Agency";
		$text['cause'] = "Αιτία";
		$text['suggested'] = "Προτίνεται";
		$text['closewindow'] = "Κλείσε το παράθυρο αυτό";
		$text['thanks'] = "Thank you";
		$text['received'] = "Your suggestion was forwarded to the site administrator for review.";
		//added in 6.0.0
		$text['association'] = "Association";
		//added in 7.0.0
		$text['indreport'] = "Individual Report";
		$text['indreportfor'] = "Individual Report for";
		$text['general'] = "General";
		$text['labels'] = "Labels";
		$text['bkmkvis'] = "<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.";
		break;

	//relateform.php, relationship.php, findpersonform.php, findperson.php
	case "relate":
		$text['relcalc'] = "Εργαλείο Υπολογισμού Συγγένειας";
		$text['findrel'] = "Εύρεση Συγγένειας";
		$text['person1'] = "Άτομο 1:";
		$text['person2'] = "Άτομο 2:";
		$text['calculate'] = "Υπολογισμός";
		$text['select2inds'] = "Παρακαλώ επιλέξτε δύο άτομα.";
		$text['findpersonid'] = "Εύρεση Κωδικού Ατόμου";
		$text['enternamepart'] = "πληκτρολογήστε τμήμα του ονόματος ή/και του επωνύμου";
		$text['pleasenamepart'] = "Παρακαλώ πληκτρολογήστε τμήμα του ονόματος ή του επιθέτου.";
		$text['clicktoselect'] = "πατήστε για να επιλέξτε";
		$text['nobirthinfo'] = "Δεν υπάρχουν πληροφορίες γέννησης";
		$text['relateto'] = "Συγγένεια ως προς";
		$text['sameperson'] = "Τα δύο άτομα είναι το ίδιο πρόσωπο.";
		$text['notrelated'] = "Τα δύο άτομα δεν έχουν συγγένεια μέσα σε xxx γενιές.";
		$text['findrelinstr'] = "Πληκτρολογήστε κωδικούς για δύο άτομα, ή κρατήστε τα άτομα που εμφανίζονται, και μετά επιλέξτε το κουμπί 'Υπολογισμός' για την παραγωγή του διαγράμματος συγγένειας (μέχρι xxx γενεές).";
		$text['gencheck'] = "Μέγιστος αριθμός γενεών<br />προς έλεγχο";
		$text['sometimes'] = "(Sometimes checking over a different number of generations yields a different result.)";
		$text['findanother'] = "Εύρεση άλλης συσχέτισης";
		//added in 6.0.0
		$text['brother'] = "the brother of";
		$text['sister'] = "the sister of";
		$text['sibling'] = "the sibling of";
		$text['uncle'] = "the xxx uncle of";
		$text['aunt'] = "the xxx aunt of";
		$text['uncleaunt'] = "the xxx uncle/aunt of";
		$text['nephew'] = "the xxx nephew of";
		$text['niece'] = "the xxx niece of";
		$text['nephnc'] = "the xxx newphew/niece of";
		$text['mcousin'] = "the xxx cousin of";
		$text['fcousin'] = "the xxx cousin of";
		$text['cousin'] = "the xxx cousin of";
		$text['removed'] = "times removed";
		$text['rhusband'] = "the husband of ";
		$text['rwife'] = "the wife of ";
		$text['rspouse'] = "the spouse of ";
		$text['son'] = "the son of";
		$text['daughter'] = "the daughter of";
		$text['rchild'] = "the child of";
		$text['sil'] = "the son-in-law of";
		$text['dil'] = "the daughter-in-law of";
		$text['sdil'] = "the son- or daughter-in-law of";
		$text['gson'] = "the xxx grandson of";
		$text['gdau'] = "the xxx granddaughter of";
		$text['gsondau'] = "the xxx grandson/granddaughter of";
		$text['great'] = "great";
		$text['spouses'] = "are spouses";
		$text['is'] = "is";
		//changed in 6.0.0
		$text['changeto'] = "Αλλαγή σε:";
		//added in 6.0.0
		$text['notvalid'] = "is not a valid Person ID number or does not exist in this database. Please try again.";
		break;

	case "familygroup":
		$text['familygroupfor'] = "Σελίδα Οικογενειακής Μερίδας για ";
		$text['ldsords'] = "LDS Διάταγμα";
		$text['baptizedlds'] = "Βάπτιση (LDS)";
		$text['endowedlds'] = "Προίκιση (LDS)";
		$text['sealedplds'] = "Σφράγιση P (LDS)";
		$text['sealedslds'] = "Σφράγιση S (LDS)";
		$text['otherspouse'] = "Άλλος/η Σύζυγος";
		//changed in 7.0.0
		$text['husband'] = "Σύζυγος-Άνδρας";
		$text['wife'] = "Σύζυγος-Γυναίκα";
		break;

	//pedigree.php
	case "pedigree":
		$text['capbirthabbr'] = "ΓΕΝ";
		$text['capaltbirthabbr'] = "A";
		$text['capdeathabbr'] = "ΘΑΝ";
		$text['capburialabbr'] = "ΤΑΦ";
		$text['capplaceabbr'] = "P";
		$text['capmarrabbr'] = "ΓΑΜ";
		$text['capspouseabbr'] = "SP";
		$text['redraw'] = "Επανασχεδίαση με";
		$text['scrollnote'] = "Σημείωση: Ίσως χρεαιστεί να μετακινηθείτε κάτω ή δεξιά για να δείτε το διάγραμμα.";
		$text['unknownlit'] = "Άγνωστο";
		$text['popupnote1'] = " = Επιπλέον πληροφορίες";
		$text['popupnote2'] = " = Νέο γενεαλόγιο";
		$text['pedcompact'] = "Συμπίεση";
		$text['pedstandard'] = "Πρότυπο";
		$text['pedtextonly'] = "Μόνο Κείμενο";
		$text['descendfor'] = "Απόγονοι για";
		$text['maxof'] = "Μέγιστος αριθμός";
		$text['gensatonce'] = "γενεών που εμφανίζονται ταυτοχρόνως.";
		$text['sonof'] = "υιός του/της/των";
		$text['daughterof'] = "θυγατέρα του/της/των";
		$text['childof'] = "παιδί του/της/των";
		$text['stdformat'] = "Πρότυπη Δομή";

		$text['ahnentafel'] = "Ahnentafel";
		$text['addnewfam'] = "Προσθήκη Νέας Οικογένειας";
		$text['editfam'] = "Διόρθωση Οικογένειας";
		$text['side'] = "Μεριά";
		$text['familyof'] = "Οικογένεια του/της/των";
		$text['paternal'] = "Πατρικά";
		$text['maternal'] = "Μητρικά";
		$text['gen1'] = "Ίδιος";
		$text['gen2'] = "Γονείς";
		$text['gen3'] = "Παπούδες-Γιαγιάδες";
		$text['gen4'] = "Προ Παπούδες-Γιαγιάδες";
		$text['gen5'] = "Προ Προ Παπούδες-Γιαγιάδες";
		$text['gen6'] = "Τρίτου βαθμού Προ Παπούδες-Γιαγιάδες";
		$text['gen7'] = "Τέταρτου βαθμού Προ Παπούδες-Γιαγιάδες";
		$text['gen8'] = "Πέμπτου βαθμού Προ Παπούδες-Γιαγιάδες";
		$text['gen9'] = "Έκτου βαθμού Προ Παπούδες-Γιαγιάδες";
		$text['gen10'] = "Έβδομου βαθμού Προ Παπούδες-Γιαγιάδες";
		$text['gen11'] = "Όγδοου βαθμού Προ Παπούδες-Γιαγιάδες";
		$text['gen12'] = "Ένατου βαθμού Προ Παπούδες-Γιαγιάδες";
		$text['graphdesc'] = "Γραφική απεικόνιση απογόνων έως αυτό το σημείο";
		$text['collapse'] = "Συστολή";
		$text['expand'] = "Διαστολή";
		$text['pedbox'] = "Πλαίσιο";
		//changed in 6.0.0
		$text['regformat'] = "Δομή Ληξιαρχείου";
		$text['extrasexpl'] = "If photos or histories exist for the following individuals, corresponding icons will be displayed next to the names.";
		//added in 6.0.0
		$text['popupnote3'] = " = New chart";
		$text['mediaavail'] = "Media Available";
		//changed in 7.0.0
		$text['pedigreefor'] = "Γενεαλογία για";
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
		$text['noreports'] = "Δεν υπάρχουν αναφορές.";
		$text['reportname'] = "Όνομα Αναφοράς";
		$text['allreports'] = "Όλες οι Αναφορές";
		$text['report'] = "Αναφορά";
		$text['error'] = "Σφάλμα";
		$text['reportsyntax'] = "Η σύνταξη της αναζήτησης που σχετίζεται με την αναφορά αυτή";
		$text['wasincorrect'] = "ήταν λανθασμένη, και σαν αποτέλεσμα η αναφορά δεν μπορούσε να ολοκληρωθεί. Παρακαλώ επικοινωνήστε με τον διαχειριστή του συστήματος στο";
		$text['query'] = "Αίτηση Αναζήτησης";
		$text['errormessage'] = "Μήνυμα Σφάλματος";
		$text['equals'] = "ισούται";
		$text['contains'] = "περιέχει";
		$text['startswith'] = "ξεκινά με";
		$text['endswith'] = "τελειώνει με";
		$text['soundexof'] = "soundex of";
		$text['metaphoneof'] = "metaphone of";
		$text['plusminus10'] = "+/- 10 χρόνια από";
		$text['lessthan'] = "μικρότερο από";
		$text['greaterthan'] = "μεγαλύτερο από";
		$text['lessthanequal'] = "μικρότερο ή ίσο με";
		$text['greaterthanequal'] = "μεγαλύτερο ή ίσο με";
		$text['equalto'] = "ίσο με";
		$text['tryagain'] = "Παρακαλώ δοκιμάστε πάλι";
		$text['text_for'] = "για";
		$text['searchnames'] = "Αναζήτηση Ονομάτων";
		$text['joinwith'] = "Σύνδεση με";
		$text['cap_and'] = "ΚΑΙ";
		$text['cap_or'] = "Η";
		$text['showspouse'] = "Εμφάνιση συζύγου (θα εμφανίσει διπλά στοιχεία εάν το άτομο έχει πολλαπλούς συζύγους)";
		$text['submitquery'] = "Υποβολή Αιτήματος Αναζήτησης";
		$text['birthplace'] = "Τόπος Γέννησης";
		$text['deathplace'] = "Τόπος Θανάτου";
		$text['birthdatetr'] = "Έτος Γέννησης";
		$text['deathdatetr'] = "Έτος Θανάτου";
		$text['plusminus2'] = "+/- 2 χρόνια από";
		$text['resetall'] = "Επαναφορά Όλων των Μεταβλητών";

		$text['showdeath'] = "Εμφάνιση πληροφοριών θανάτου/ταφής";
		$text['altbirthplace'] = "Τόπος Βάπτισης";
		$text['altbirthdatetr'] = "Έτος Βάπτισης";
		$text['burialplace'] = "Τόπος Ταφής";
		$text['burialdatetr'] = "Έτος Ταφής";
		$text['event'] = "Γεγονός(ότα)";
		$text['day'] = "Ημέρα";
		$text['month'] = "Μήνας";
		$text['keyword'] = "Λέξη κλειδί (πχ, \"Abt\")";
		$text['explain'] = "Enter date components to see matching events. Leave a field blank to see matches for all.";
		$text['enterdate'] = "Please enter or select at least one of the following: Day, Month, Year, Keyword";
		$text['fullname'] = "Πλήρες Ονοματεπώνυμο";
		$text['birthdate'] = "Ημερομηνία Γέννησης";
		$text['altbirthdate'] = "Ημερομηνία Βάπτισης";
		$text['marrdate'] = "Ημερομηνία Γάμου";
		$text['spouseid'] = "Κωδικός Συζύγου";
		$text['spousename'] = "Όνομα Συζύγου";
		$text['deathdate'] = "Ημερομηνία Θανάτου";
		$text['burialdate'] = "Ημερομηνία Ταφής";
		$text['changedate'] = "Ημερομηνία Τελευταίας Ενημέρωσης";
		$text['gedcom'] = "Δέντρο";
		$text['baptdate'] = "Ημερομηνία Βάπτισης (LDS)";
		$text['baptplace'] = "Τόπος Βάπτισης (LDS)";
		$text['endldate'] = "Endowment Ημερομηνία (LDS)";
		$text['endlplace'] = "Endowment Τόπος (LDS)";
		$text['ssealdate'] = "Seal Ημερομηνία S (LDS)";
		$text['ssealplace'] = "Seal Τόπος S (LDS)";
		$text['psealdate'] = "Seal Ημερομηνία P (LDS)";
		$text['psealplace'] = "Seal Τόπος P (LDS)";
		$text['marrplace'] = "Marriage Place";
		$text['spousesurname'] = "Spouse's Last Name";
		//changed in 6.0.0
		$text['spousemore'] = "If you enter a value for Spouse's Last Name, you must enter a value for at least one other field.";
		//added in 6.0.0
		$text['plusminus5'] = "+/- 5 years from";
		$text['exists'] = "exists";
		$text['dnexist'] = "does not exist";
		//added in 6.0.3
		$text['divdate'] = "Divorce Date";
		$text['divplace'] = "Divorce Place";
		//changed in 7.0.0
		$text['otherevents'] = "Άλλα Γεγονότα";
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
		$text['logfilefor'] = "Αρχείο Ημερολογίου για";
		$text['mostrecentactions'] = "Πρόσφατες Ενέργειες";
		$text['autorefresh'] = "Αυτόματη Ανανέωση (30 δευτερόλεπτα)";
		$text['refreshoff'] = "Απενεργοποίηση Αυτόματης Ανανέωσης";
		break;

	case "headstones":
	case "showphoto":
		$text['cemeteriesheadstones'] = "Νεκτροταφεία και Ταφόπλακες";
		$text['showallhsr'] = "Εμφάνιση όλων των στοιχείων για ταφόπλακες";
		$text['in'] = "μέσα";
		$text['showmap'] = "Εμφάνιση χάρτη";
		$text['headstonefor'] = "Ταφόπλακα για";
		$text['photoof'] = "Φωτογραφία του/της";
		$text['firstpage'] = "Πρώτη Σελίδα";
		$text['lastpage'] = "Τελευταία Σελίδα";
		$text['photoowner'] = "Ιδιοκτήτης/Πηγή";

		$text['nocemetery'] = "Δεν υπάρχει Νεκτροταφείο";
		$text['iptc005'] = "Τίτλος";
		$text['iptc020'] = "Επιπλέον Κατηγορίες";
		$text['iptc040'] = "Ειδικές Οδηγίες";
		$text['iptc055'] = "Ημερομηνία Δημιουργίας";
		$text['iptc080'] = "Συγγραφέας";
		$text['iptc085'] = "Θέση Συγγραφέα";
		$text['iptc090'] = "Πόλη";
		$text['iptc095'] = "Πολυτεία";
		$text['iptc101'] = "Χώρα";
		$text['iptc103'] = "OTR";
		$text['iptc105'] = "Κύριος Τίτλος";
		$text['iptc110'] = "Πηγή";
		$text['iptc115'] = "Φωτογραφία Πηγής";
		$text['iptc116'] = "Δικαιώματα Δημιουργού";
		$text['iptc120'] = "Λεζάντα";
		$text['iptc122'] = "Συγγραφέας Λεζάντας";
		$text['mapof'] = "Χάρτης του/της";
		$text['regphotos'] = "Περιληπτική Μορφή";
		$text['gallery'] = "Thumbnails Only";
		$text['cemphotos'] = "Φωτογραφίες Νεκροταφείων";
		//changed in 6.0.0
		$text['photosize'] = "Μέγεθος";
		//added in 6.0.0
        	$text['iptc010'] = "Priority";
		$text['filesize'] = "File Size";
		$text['seeloc'] = "See Location";
		$text['showall'] = "Show All";
		$text['editmedia'] = "Edit Media";
		$text['viewitem'] = "View this item";
		$text['editcem'] = "Edit Cemetery";
		$text['numitems'] = "# Items";
		$text['allalbums'] = "All Albums";
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
		$text['surnamesstarting'] = "Εμφάνιση επωνύμων που αρχίζουν με";
		$text['showtop'] = "Εμφάνιση επάνω";
		$text['showallsurnames'] = "Εμφάνιση όλων των επωνύμων";
		$text['sortedalpha'] = "ταξινομημένα αλφαβητικά";
		$text['byoccurrence'] = "ταξινομημένα κατά σειρά εμφάνισης";
		$text['firstchars'] = "Πρώτοι χαρακτήρες";
		$text['top'] = "Κορυφαία";
		$text['mainsurnamepage'] = "Κεντρική σελίδα επωνύμων";
		$text['allsurnames'] = "Όλα τα Επώνυμα";
		$text['showmatchingsurnames'] = "Επιλέξτε ένα επώνυμο για να εμφανιστούν τα αντίστοιχα στοιχεία.";
		$text['backtotop'] = "Επαναφορά στη κορυφή";
		$text['beginswith'] = "Αρχίζει με";
		$text['allbeginningwith'] = "Όλα τα επώνυμα που αρχίζουν με";
		$text['numoccurrences'] = "σύνολο των εμφανίσεων σε παρένθεση";
		$text['placesstarting'] = "Εμφάνιση Τοποθεσιω΄ν ξεκινώντας με";
		$text['showmatchingplaces'] = "Επιλέξτε ένα επώνυμο για να εμφανιστούν τα αντίστοιχα στοιχεία.";
		$text['totalnames'] = "σύνολο ατόμων";
		$text['showallplaces'] = "Εμφάνιση των μεγαλυτέρων localities";
		$text['totalplaces'] = "σύνολο τόπων";
		$text['mainplacepage'] = "Main places page";
		$text['allplaces'] = "All Largest Localities";
		$text['placescont'] = "Show all places containing";
		//added in 7.0.0
		$text['top30'] = "Top 30 surnames";
		$text['top30places'] = "Top 30 largest localities";
		break;

	//whatsnew.php
	case "whatsnew":
		$text['pastxdays'] = "(τελευταίες xx ημέρες)";
		$text['historiesdocs'] = "Ιστορίες";
		//$text['headstones'] = "Headstones";

		$text['photo'] = "Φωτογραφία";
		$text['history'] = "Ιστορικό/Έγγραφο";
		//changed in 7.0.0
		$text['husbid'] = "Κωδικός Συζύγου-Άνδρα";
		$text['husbname'] = "Όνομα Συζύγου-Άνδρα";
		$text['wifeid'] = "Κωδικός Συζύγου-Γυναίκας";
		break;

	//timeline.php, timeline2.php
	case "timeline":
		$text['text_delete'] = "Διαγραφή";
		$text['addperson'] = "Προσθήκη Ατόμου";
		$text['nobirth'] = "Το ακόλουθο άτομο δεν έχει σωστή ημερομηνία γέννησης και δεν μπορούσε να προστεθεί";
		$text['noliving'] = "Το ακόλουθο άτομο έχει επισημανθεί ως εν ζωή και δεν μπορούσε να προστεθεί γιατί δεν έχετε συνδεθεί με τις κατάλληλες αρμοδιότητες";
		$text['event'] = "Γεγονός(ότα)";
		$text['chartwidth'] = "Chart width";
		//changed in 6.0.0
		$text['timelineinstr'] = "Προστέστε μέχρι τέσσερα ακόμη άτομα εισάγωντας τους κωδικούς τους παρακάτω:";
		//added in 6.0.0
		$text['togglelines'] = "Toggle Lines";
		break;
		
	//browsetrees.php
	//login.php, newacctform.php, addnewacct.php
	case "trees":
	case "login":
		$text['browsealltrees'] = "Φυλλομέτρηση Όλων των Δέντρων";
		$text['treename'] = "Όνομα Δέντρου";
		$text['owner'] = "Ιδιοκτήτης";
		$text['address'] = "Διεύθυνση";
		$text['city'] = "Πόλη";
		$text['state'] = "Πολυτεία/Νομός";
		$text['zip'] = "Ταχυδρομικός Κώδικας";
		$text['country'] = "Χώρα";
		$text['email'] = "Διεύθυνση Ηλεκτρονικού Ταχυδρομείου";
		$text['phone'] = "Τηλεφωνο";
		$text['username'] = "Ψευδώνυμο";
		$text['password'] = "Κωδικός";
		$text['loginfailed'] = "Η Σύνδεση απέτυχε.";

		$text['regnewacct'] = "Εγγραφείται για Νέο Λογαριασμό Χρήστη";
		$text['realname'] = "Πραγματικό Ονοματεπώνυμο";
		$text['phone'] = "Τηλεφωνο";
		$text['email'] = "Διεύθυνση Ηλεκτρονικού Ταχυδρομείου";
		$text['address'] = "Διεύθυνση";
		$text['comments'] = "Σημειώσεις ή Σχόλια";
		$text['submit'] = "Υποβολή";
		$text['leaveblank'] = "(αφήστε κενό εάν ζητάτε νέο δέντρο)";
		$text['required'] = "Υποχρεωτικά πεδία";
		$text['enterpassword'] = "Πληκτρολογήστε κωδικό.";
		$text['enterusername'] = "Πληκτρολογήστε ψευδώνυμο.";
		$text['failure'] = "Ζητάμε συγνώμη, αλλά το ψευδώνυμο που επιλέξατε χρησιμοποιείται ήδη. Παρακαλώ χρησιμοποιήστε το κουμπί 'πίσω' στο browser σας για να επιστρέψτε στη προηγούμενη σελίδα και να επιλέξτε νέο ψευδώνυμο.";
		$text['success'] = "Ευχαριστούμε. Έχουμε παραλάβει το αίτημα εγγραφής. Θα επικοινωνήσουμε μαζί σας όταν ενεργοποιηθεί ο λογαριασμός σας ή εάν χρειαστούμε επιπλέον πληροφορίες.";
		$text['emailsubject'] = "Αίτηση για εγγραφή νέου χρήστη της εφαρμογής TNG";
		$text['emailmsg'] = "Έχετε νέο αίτημα για λογαριασμό χρήστη στην εφαρμογή TNG. Παρακαλώ συνδεθείτε στον λογαριασμό διαχειριστή στην εφαρμογή TNG και δώστε τις απαραίτητες πιστοποιήσεις για το νέο αυτό αίτημα. Εάν εγκρίνετε την νέα εγγραφή, παρακαλώ ενημερώστε τον νέο χρήστη απαντώντας στο ήνυμα αυτό.";
		//changed in 5.0.0
		$text['enteremail'] = "Παρακαλώ εισάγετε έγκυρη διεύθυνση ηλεκτρονικού ταχυδρομείου.";
		$text['website'] = "Δικτυακός Τόπος";
		$text['nologin'] = "Δεν έχετε κωδικό σύνδεσης;";
		$text['loginsent'] = "Οι πληροφορίες διασύνδεσης σας έχουν αποσταλεί";
		$text['loginnotsent'] = "Οι πληροφορίες διασύνδεσης δεν έχουν σταλεί";
		$text['enterrealname'] = "Παρακαλώ εισάγετε το αληθινό σας όνομα.";
		$text['rempass'] = "Παραμείνετε συνδεσεμένη στον υπολογιστή αυτό";
		$text['morestats'] = "More statistics";
		//added in 6.0.0
		$text['accmail'] = "<strong>NOTE:</strong> In order to receive mail from the site administrator regarding your account, please make sure that you are not blocking mail from this domain.";
		$text['newpassword'] = "New Password";
		$text['resetpass'] = "Reset your password";
		//added in 6.1.0
		$text['nousers'] = "This form cannot be used until at least one user record exists. If you are the site owner, please go to Admin/Users to create your Administrator account.";
		//added in 7.0.0
		$text['noregs'] = "We're sorry, but we are not accepting new user registrations at this time. Please <a href=\"suggest.php\">contact us</a> directly if you have comments or questions regarding anything on this site.";
		break;

	//statistics.php
	case "stats":
		$text['quantity'] = "Ποσότητα";
		$text['totindividuals'] = "Συνολικός Αριθμός Ατόμων";
		$text['totmales'] = "Συνολικός Αριθμός Ανδρών";
		$text['totfemales'] = "Συνολικός Αριθμός Γυναικών";
		$text['totunknown'] = "Συνολικός αριθμός Ατόμων αγνώστου φύλου";
		$text['totliving'] = "Συνολικός αριθμός εν ζωή Ατόμων";
		$text['totfamilies'] = "Συνολικός Αριθμός Οικογενειών";
		$text['totuniquesn'] = "Συνολικός Αριθμός Μοναδικών Επωνύμων";
		//$text['totphotos'] = "Total Photos";
		//$text['totdocs'] = "Total Histories &amp; Documents";
		//$text['totheadstones'] = "Total Headstones";
		$text['totsources'] = "Συνολικός Αριθμός Πηγών";
		$text['avglifespan'] = "Μέσος χρόνος ζωής";
		$text['earliestbirth'] = "Παλαιότερη Γέννηση";
		$text['longestlived'] = "Άτομο που έζησε περισσότερο";
		$text['years'] = "χρόνια";
		$text['days'] = "μέρες";
		$text['age'] = "Ηλικία";
		$text['agedisclaimer'] = "Υπολογισμοί που σχετίζονται με ηλικίες στηρίζονται σε άτομα που έχουν καταγεγραμμένη ημερομηνία γέννησης <EM>και</EM> ημερομηνία θανάτου.  Λόγω της ύπαρξης ημιτελών ημερομηνιών (π.χ., ημερομηνία θανάτου καταγεγραμμένη ως \"1945\" ή \"ΠΡΙΝ 1860\"), οι υπολογισμοί αυτοί δεν είνι 100% ακριβής.";
		$text['treedetail'] = "More information on this tree";
		//added in 6.0.0
		$text['total'] = "Total";
		break;

	case "notes":
		$text['browseallnotes'] = "Επισκόπιση Όλων των Σημείσεων";
		break;

	case "help":
		$text['menuhelp'] = "Μενού Key";
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
		$text['exists'] = "exists";
		$text['loginfirst'] = "You must log in first.";
		$text['noop'] = "No operation was performed.";
		break;
}

//common
$text['matches'] = "Ταιριάζει";
$text['description'] = "Περιγραφή";
$text['notes'] = "Σημειώσεις";
$text['status'] = "Κατάσταση";
$text['newsearch'] = "Νέα Αναζήτηση";
$text['pedigree'] = "Γενεαλόγιο";
$text['birthabbr'] = "γ.";
$text['chrabbr'] = "c.";
$text['seephoto'] = "Δες φωτογραφία";
$text['andlocation'] = "& τοποθεσία";
$text['accessedby'] = "έχει χρησιμοποιηθεί από";
$text['go'] = "Πήγαινε";
$text['family'] = "Οικογένεια";
$text['children'] = "Παιδιά";
$text['tree'] = "Δέντρο";
$text['alltrees'] = "Όλα τα Δέντρα";
$text['nosurname'] = "[no surname]";
$text['thumb'] = "Σμίκρυνση";
$text['people'] = "Άνθρωποι";
$text['title'] = "Τίτλος";
$text['suffix'] = "Επίθεμα";
$text['nickname'] = "Παρατσούκλι";
$text['deathabbr'] = "θ.";
$text['lastmodified'] = "Τελευταία Αλλαγή";
$text['married'] = "Παντρεμένος/η";
//$text['photos'] = "Photos";
$text['name'] = "Όνομα";
$text['lastfirst'] = "Επώνυμο, Όνομα";
$text['bornchr'] = "Γεννηση/Βάπτιση";
$text['individuals'] = "Άτομα";
$text['families'] = "Οικογένειες";
$text['personid'] = "Κωδικός Ατόμου";
$text['sources'] = "Πηγές";
$text['unknown'] = "Άγνωστο";
$text['father'] = "Πατέρας";
$text['mother'] = "Μητέρα";
$text['born'] = "Γέννηση";
$text['christened'] = "Βάπτιση";
$text['died'] = "Θάνατος";
$text['buried'] = "Ταφή";
$text['spouse'] = "Σύζυγος";
$text['parents'] = "Γονείς";
$text['text'] = "Κείμενο";
$text['language'] = "Γλώσσα";
$text['burialabbr'] = "ταφ.";
$text['descendchart'] = "Απόγονοι";
$text['extractgedcom'] = "GEDCOM";
$text['indinfo'] = "Άτομο";
$text['edit'] = "Διόρθωση";
$text['date'] = "Ημερομηνία";
$text['place'] = "Τοποθεσία";
$text['login'] = "Σύνδεση";
$text['logout'] = "Αποσύνδεση";
$text['marrabbr'] = "γαμ.";
$text['groupsheet'] = "Σελίδα Ομάδας";
$text['text_and'] = "και";
$text['generation'] = "Γενεάς";
$text['filename'] = "Όνομα αρχείου";
$text['id'] = "Κωδικός";
$text['search'] = "Αναζήτηση";
$text['living'] = "Εν ζωή";
$text['user'] = "Χρήστης";
$text['firstname'] = "Πρώτο Όνομα";
$text['lastname'] = "Επώνυμο";
$text['searchresults'] = "Αποτελέσματα Αναζήτησης";
$text['diedburied'] = "Θάνατος/Ταφή";
$text['homepage'] = "Αρχική";
$text['find'] = "Αναζήτηση...";
$text['relationship'] = "Συγγένεια";
$text['relationship2'] = "Relationship";
$text['timeline'] = "Χρονοδιάγραμμα";
$text['yesabbr'] = "Ν";
$text['divorced'] = "Χωρισμένος/η";
$text['indlinked'] = "Σύνδεση με";
$text['branch'] = "Κλαδί";
$text['moreind'] = "Άλλα Άτομα";
$text['morefam'] = "Άλλες Οικογένειες";
$text['livingdoc'] = "Τουλάχιστον ένα άτομο εν ζωή έχει συνδεθεί με το έγγραφο αυτό - Λεπτομέριες έχουν προστατευτεί.";
$text['source'] = "Πηγή";
$text['surnamelist'] = "Κατάλογος Επωνύμων";
$text['generations'] = "Γενεές";
$text['refresh'] = "Ανανέωση";
$text['whatsnew'] = "Νέα";
$text['reports'] = "Αναφορές";
$text['placelist'] = "Κατάλογος Τοποθεσιών";
$text['baptizedlds'] = "Βάπτιση (LDS)";
$text['endowedlds'] = "Προίκιση (LDS)";
$text['sealedplds'] = "Σφράγιση P (LDS)";
$text['sealedslds'] = "Σφράγιση S (LDS)";
//$text['photoshistories'] = "Photos &amp; Histories";
$text['ancestors'] = "πρόγονοι";
$text['descendants'] = "απόγονοι";
//$text['sex'] = "Sex";
$text['lastimportdate'] = "Ημερομηνία τελευταίας εισαγωγής αρχείου GEDCOM";
$text['type'] = "Τύπος";
$text['savechanges'] = "Αποθήκευση Αλλαγών";
$text['familyid'] = "Κωδικός Οικογένειας";
$text['headstone'] = "Ταφόπλακες";
$text['historiesdocs'] = "Ιστορίες";
$text['livingnote'] = "Άτομο εν ζωή - Λεπτομέρειες έχουν παρακρατηθεί";
$text['anonymous'] = "ανώνυμος";
$text['places'] = "Τόποι";
$text['anniversaries'] = "Ημερομηνίες & Επέτειοι";
$text['administration'] = "Διαχείριση";
$text['help'] = "Βοήθεια";
//$text['documents'] = "Documents";
$text['year'] = "Έτος";
$text['all'] = "Όλα";
$text['repository'] = "Αποθετήριο";
$text['address'] = "Διεύθυνση";
$text['suggest'] = "Προτείνετε";
$text['editevent'] = "Προτείνετε κάποια αλλαγή για το γεγονός αυτό";
$text['findplaces'] = "Βρείτε όλους όσους έχουν γεγονότα στη τοποθεσία αυτή";
$text['morelinks'] = "Και άλλες συνδέσεις";
$text['faminfo'] = "Οικογενειακές Πληροφορίες";
$text['persinfo'] = "Προσωπικές Πληροφορίες";
$text['srcinfo'] = "Πληροφορίες για Πηγή";
$text['fact'] = "Fact";
$text['goto'] = "Select a page";
$text['tngprint'] = "Print";
//changed in 6.0.0
$text['livingphoto'] = "Τουλάχιστον ένα άτομο εν ζωή έχει συνδεθεί με την φωτογραφία αυτή - Λεπτομέριες έχουν προστατευτεί.";
$text['databasestatistics'] = "Στατιστικά Βάσης Δεδομένων";
//moved here in 6.0.0
$text['child'] = "Παιδί";
$text['repoinfo'] = "Αποθετήριο Πληροφοριών";
$text['tng_reset'] = "Επαναφορά Ρυθμίσεων";
$text['noresults'] = "Δεν βρέθηκαν αποτελέσματα";
//added in 6.0.0
$text['allmedia'] = "All Media";
$text['repositories'] = "Repositories";
$text['albums'] = "Albums";
$text['cemeteries'] = "Cemeteries";
$text['surnames'] = "Surnames";
$text['dates'] = "Dates";
$text['link'] = "Link";
$text['media'] = "Media";
$text['gender'] = "Gender";
$text['latitude'] = "Latitude";
$text['longitude'] = "Longitude";
$text['bookmarks'] = "Bookmarks";
$text['bookmark'] = "Add Bookmark";
$text['mngbookmarks'] = "Go to Bookmarks";
$text['bookmarked'] = "Bookmark Added";
$text['remove'] = "Remove";
$text['find_menu'] = "Find";
$text['info'] = "Info";
//moved here in 6.0.3
$text['cemetery'] = "Νεκροταφείο";
//added in 6.1.0
//Google Maps messages
$text['gmapevent'] = "Event Map";
$text['gevents'] = "Event";
$text['glang'] = "&amp;hl=en";
$text['googleearthlink'] = "Link to Google Earth";
$text['googlemaplink'] = "Link to Google Maps";
$text['gmaplegend'] = "Pin Legend";
//moved here in 7.0.0
$text['unmarked'] = "Χωρίς σήμανση";
$text['located'] = "Ευρίσκεται";
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
$text['mnuheader'] = "Αρχική Σελίδα";
$text['mnusearchfornames'] = "Αναζήτηση Ονομάτων";
$text['mnulastname'] = "Επίθετο";
$text['mnufirstname'] = "Όνομα";
$text['mnusearch'] = "Αναζήτηση";
$text['mnureset'] = "Από την αρχή";
$text['mnulogon'] = "Σύνδεση";
$text['mnulogout'] = "Αποσύνδεση";
$text['mnufeatures'] = "Άλλες Λειτουργίες";
$text['mnuregister'] = "Αίτηση για Λογαριασμό Χρήστη";
$text['mnuadvancedsearch'] = "Προχωρημένη Αναζήτηση";
$text['mnulastnames'] = "Επίθετα";
$text['mnustatistics'] = "Στατιστικά";
$text['mnuphotos'] = "Φωτογραφίες";
$text['mnuhistories'] = "Ιστορικά & Κείμενα";
$text['mnumyancestors'] = "Photos &amp; Histories for Ancestors of [Person]";
$text['mnucemeteries'] = "Νεκροταφεία";
$text['mnutombstones'] = "Ταφόπλακες";
$text['mnureports'] = "Αναφορές";
$text['mnusources'] = "Πηγές";
$text['mnuwhatsnew'] = "Τι Νεότερο Υπάρχει;";
$text['mnushowlog'] = "Ημερολόγιο Πρόσβασης";
$text['mnulanguage'] = "Αλλαγή Γλώσσας";
$text['mnuadmin'] = "Διαχείριση";
$text['welcome'] = "Καλωσορίσατε";
$text['contactus'] = "Επικοινωνήσετε μαζί μας";

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
