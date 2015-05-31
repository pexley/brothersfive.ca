<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "install";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
include($subroot . "importconfig.php");
$saveconfig = 0;
$saveimportconfig = 0;
$class = "red";
$link = @mysql_connect($database_host, $database_username, $database_password);
if( $link && mysql_select_db($database_name)) {
	include($cms['tngpath'] . "checklogin.php");
	if( $assignedtree || !$allow_edit ) {
		$_POST['subroutine'] = "login";
	}
}

function createtables() {
	global $branches_table,$branchlinks_table,$address_table,$cemeteries_table,$children_table,$citations_table,$countries_table;
	global $events_table,$eventtypes_table,$families_table,$languages_table,$notelinks_table,$media_table,$medialinks_table;
	global $people_table,$places_table,$reports_table,$repositories_table,$saveimport_table,$sources_table,$states_table,$mostwanted_table;
	global $temp_events_table,$tlevents_table,$trees_table,$users_table,$xnotes_table,$albums_table,$album2entities_table,$albumlinks_table,$assoc_table,$mediatypes_table;
	global $text;

	$badtables = "";

	$query = "DROP TABLE IF EXISTS $address_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $address_table (
		addressID INT(11) NOT NULL AUTO_INCREMENT,
		address1 VARCHAR(64) NOT NULL,
		address2 VARCHAR(64) NOT NULL,
		city VARCHAR(64) NOT NULL,
		state VARCHAR(64) NOT NULL,
		zip VARCHAR(10) NOT NULL,
		country VARCHAR(64) NOT NULL,
		www VARCHAR(100) NOT NULL,
		email VARCHAR(100) NOT NULL,
		phone VARCHAR(30) NOT NULL,
		gedcom VARCHAR(20) NOT NULL,
		PRIMARY KEY (addressID),
		INDEX address (gedcom, country, state, city, address1)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$address_table" : $address_table;

	$query = "DROP TABLE IF EXISTS $albums_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $albums_table (
		albumID INT(11) NOT NULL AUTO_INCREMENT,
		albumname VARCHAR(50) NOT NULL,
		description TEXT NULL,
		keywords TEXT NULL,
		PRIMARY KEY (albumID),
		INDEX albumname (albumname)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$albums_table" : $albums_table;

	$query = "DROP TABLE IF EXISTS $albumlinks_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $albumlinks_table (
		albumlinkID INT(11) NOT NULL AUTO_INCREMENT,
		albumID INT(11) NOT NULL,
		mediaID INT(11) NOT NULL,
		ordernum INT(11) NULL,
		defphoto VARCHAR(1) NOT NULL,
		PRIMARY KEY (albumlinkID),
		INDEX albumID (albumID,ordernum)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$albumlinks_table" : $albumlinks_table;

	$query = "DROP TABLE IF EXISTS $album2entities_table";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "CREATE TABLE $album2entities_table (
		alinkID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		linktype CHAR(1) NOT NULL,
		entityID VARCHAR(100) NOT NULL,
		eventID VARCHAR(10) NOT NULL,
		albumID INT(11) NOT NULL,
		ordernum FLOAT NOT NULL,
		PRIMARY KEY (alinkID),
		UNIQUE alinkID (gedcom, entityID, albumID),
		INDEX entityID (gedcom, entityID, ordernum),
		FOREIGN KEY alinks_fk1 (gedcom, entityID) REFERENCES $people_table (gedcom, personID),
		FOREIGN KEY alinks_fk2 (gedcom, entityID) REFERENCES $families_table (gedcom, familyID),
		FOREIGN KEY alinks_fk3 (gedcom, entityID) REFERENCES $sources_table (gedcom, sourceID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$album2entities_table" : $album2entities_table;

	$query = "DROP TABLE IF EXISTS $assoc_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $assoc_table (
		assocID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		personID VARCHAR(22) NOT NULL,
		passocID VARCHAR(22) NOT NULL,
		relationship VARCHAR(25) NOT NULL,
		PRIMARY KEY (assocID),
		INDEX assoc (gedcom, personID)
	) TYPE = MYISAM";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

	$query = "DROP TABLE IF EXISTS $branches_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $branches_table (
		branch VARCHAR(20) NOT NULL,
		gedcom VARCHAR(20) NOT NULL,
		description VARCHAR(128) NOT NULL,
		PRIMARY KEY (branch),
		INDEX description (gedcom, description)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$branches_table" : $branches_table;

	$query = "DROP TABLE IF EXISTS $branchlinks_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $branchlinks_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		branch VARCHAR(20) NOT NULL,
		gedcom VARCHAR(20) NOT NULL,
		persfamID VARCHAR(22) NOT NULL,
		PRIMARY KEY (ID),
		UNIQUE branch (gedcom, branch, persfamID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$branchlinks_table" : $branchlinks_table;

	$query = "DROP TABLE IF EXISTS $cemeteries_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $cemeteries_table (
		cemeteryID INT(11) NOT NULL AUTO_INCREMENT,
		cemname VARCHAR(64) NOT NULL,
		maplink VARCHAR(64) NULL,
		city VARCHAR(64) NULL,
		county VARCHAR(64) NULL,
		state VARCHAR(64) NULL,
		country VARCHAR(64) NULL,
		longitude VARCHAR(20) NULL,
		latitude VARCHAR(20) NULL,
		zoom TINYINT(4) NULL,
		notes TEXT NULL,
		PRIMARY KEY (cemeteryID),
		INDEX cemname (cemname)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$cemeteries_table" : $cemeteries_table;

	$query = "DROP TABLE IF EXISTS $children_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $children_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		familyID VARCHAR(22) NOT NULL,
		personID VARCHAR(22) NOT NULL,
		relationship VARCHAR(20) NOT NULL,
		sealdate VARCHAR(50) NOT NULL,
		sealdatetr DATE NOT NULL,
		sealplace TEXT NOT NULL,
		haskids TINYINT(4) NOT NULL,
		ordernum SMALLINT(6) NOT NULL,
		parentorder TINYINT(4) NOT NULL,
		PRIMARY KEY (ID),
		UNIQUE familyID (gedcom, familyID, personID),
		INDEX personID (gedcom, personID),
		FOREIGN KEY children_fk1 (gedcom, familyID) REFERENCES $families_table (gedcom, familyID),
		FOREIGN KEY children_fk2 (gedcom, personID) REFERENCES $people_table (gedcom, personID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$children_table" : $children_table;

	$query = "DROP TABLE IF EXISTS $citations_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $citations_table (
		citationID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		persfamID VARCHAR(22) NOT NULL,
		eventID VARCHAR(10) NOT NULL,
		sourceID VARCHAR(22) NOT NULL,
		description TEXT NOT NULL,
		citedate VARCHAR(50) NOT NULL,
		citedatetr DATE NOT NULL,
		citetext TEXT NOT NULL,
		page TEXT NOT NULL,
		quay VARCHAR(2) NOT NULL,
		note TEXT NOT NULL,
		PRIMARY KEY (citationID),
		INDEX citation (gedcom, persfamID, eventID, sourceID, description(20)),
		FOREIGN KEY citations_fk1 (gedcom, persfamID) REFERENCES $people_table (gedcom, personID),
		FOREIGN KEY citations_fk2 (gedcom, persfamID) REFERENCES $families_table (gedcom, familyID),
		FOREIGN KEY citations_fk3 (gedcom, sourceID) REFERENCES $sources_table (gedcom, sourceID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$citations_table" : $citations_table;

	$query = "DROP TABLE IF EXISTS $countries_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $countries_table (
	    country varchar(64) NOT NULL,
	    PRIMARY KEY (country)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$countries_table" : $countries_table;

	$query = "DROP TABLE IF EXISTS $events_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $events_table (
		eventID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		persfamID VARCHAR(22) NOT NULL,
		eventtypeID INT(11) NOT NULL,
		eventdate VARCHAR(50) NOT NULL,
		eventdatetr DATE NOT NULL,
		eventplace TEXT NOT NULL,
		age VARCHAR(12) NOT NULL,
		agency VARCHAR(120) NOT NULL,
		cause VARCHAR(90) NOT NULL,
		addressID VARCHAR(10) NOT NULL,
		parenttag VARCHAR(10) NOT NULL,
		info TEXT NOT NULL,
		PRIMARY KEY (eventID),
		INDEX persfamID (gedcom, persfamID),
		FOREIGN KEY events_fk1 (gedcom, persfamID) REFERENCES $people_table (gedcom, personID),
		FOREIGN KEY events_fk2 (gedcom, persfamID) REFERENCES $families_table (gedcom, familyID),
		FOREIGN KEY events_fk3 (gedcom, persfamID) REFERENCES $sources_table (gedcom, sourceID),
		FOREIGN KEY events_fk4 (eventtypeID) REFERENCES $eventtypes_table (eventtypeID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$events_table" : $events_table;

	$query = "DROP TABLE IF EXISTS $eventtypes_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $eventtypes_table (
		eventtypeID INT(11) NOT NULL AUTO_INCREMENT,
		tag VARCHAR(10) NOT NULL,
		description VARCHAR(90) NOT NULL,
		display TEXT NOT NULL,
		keep TINYINT(4) NOT NULL,
		ordernum SMALLINT(6) NOT NULL,
		type CHAR(1) NOT NULL,
		PRIMARY KEY (eventtypeID),
		UNIQUE typetagdesc (type, tag, description),
		INDEX ordernum (ordernum)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$eventtypes_table" : $eventtypes_table;

	$query = "DROP TABLE IF EXISTS $families_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $families_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		familyID VARCHAR(22) NOT NULL,
		husband VARCHAR(22) NOT NULL,
		wife VARCHAR(22) NOT NULL,
		marrdate VARCHAR(50) NOT NULL,
		marrdatetr DATE NOT NULL,
		marrplace TEXT NOT NULL,
		marrtype VARCHAR(50) NOT NULL,
		divdate VARCHAR(50) NOT NULL,
		divdatetr DATE NOT NULL,
		divplace TEXT NOT NULL,
		status VARCHAR(20) NOT NULL,
		sealdate VARCHAR(50) NOT NULL,
		sealdatetr DATE NOT NULL,
		sealplace TEXT NOT NULL,
		husborder TINYINT(4) NOT NULL,
		wifeorder TINYINT(4) NOT NULL,
		changedate DATETIME NOT NULL,
		living TINYINT(4) NOT NULL,
		branch VARCHAR(100) NOT NULL,
		changedby VARCHAR(20) NOT NULL,
		PRIMARY KEY (ID),
		UNIQUE familyID (gedcom, familyID),
		INDEX husband (gedcom, husband),
		INDEX wife (gedcom, wife),
		INDEX changedate (changedate)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$families_table" : $families_table;

	$query = "DROP TABLE IF EXISTS $languages_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $languages_table (
		languageID SMALLINT(6) NOT NULL AUTO_INCREMENT,
		display VARCHAR(100) NOT NULL,
		folder VARCHAR(50) NOT NULL,
		charset VARCHAR(30) NOT NULL,
		PRIMARY KEY (languageID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$languages_table" : $languages_table;

	$query = "DROP TABLE IF EXISTS $medialinks_table";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "CREATE TABLE $medialinks_table (
		medialinkID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		linktype CHAR(1) NOT NULL,
		personID VARCHAR(100) NOT NULL,
		eventID VARCHAR(10) NOT NULL,
		mediaID INT(11) NOT NULL,
		altdescription TEXT NOT NULL,
		altnotes TEXT NOT NULL,
		ordernum FLOAT NOT NULL,
		defphoto VARCHAR(1) NOT NULL,
		PRIMARY KEY (medialinkID),
		UNIQUE mediaID (gedcom, personID, mediaID, eventID),
		INDEX personID (gedcom, personID, ordernum),
		FOREIGN KEY medialinks_fk1 (gedcom, personID) REFERENCES $people_table (gedcom, personID),
		FOREIGN KEY medialinks_fk2 (gedcom, personID) REFERENCES $families_table (gedcom, familyID),
		FOREIGN KEY medialinks_fk3 (gedcom, personID) REFERENCES $sources_table (gedcom, sourceID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$medialinks_table" : $medialinks_table;

	$query = "DROP TABLE IF EXISTS $media_table";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "CREATE TABLE $media_table (
		mediaID INT(11) NOT NULL AUTO_INCREMENT,
		mediatypeID VARCHAR(20) NOT NULL,
		mediakey VARCHAR(127) NOT NULL,
		gedcom VARCHAR(20) NULL,
		form VARCHAR(10) NOT NULL,
		path VARCHAR(127) NULL,
		description TEXT NULL,
		datetaken VARCHAR(50) NULL,
		placetaken TEXT NULL,
		notes TEXT NULL,
		owner TEXT NULL,
		thumbpath VARCHAR(127) NULL,
		alwayson TINYINT(4) NULL,
		map TEXT NULL,
		abspath TINYINT(4) NULL,
		status VARCHAR(40) NULL,
		showmap SMALLINT(6) NULL,
		cemeteryID INT(11) NULL,
		plot VARCHAR(40) NULL,
		linktocem TINYINT(4) NULL,
		longitude VARCHAR(20) NULL,
		latitude VARCHAR(20) NULL,
		zoom TINYINT(4) NULL,
		width SMALLINT(6) NULL,
		height SMALLINT(6) NULL,
		bodytext TEXT NULL,
		usenl TINYINT(4) NULL,
		newwindow TINYINT(4) NULL,
		usecollfolder TINYINT(4) NULL,
		changedate DATETIME NULL,
		changedby VARCHAR(20) NOT NULL,
		PRIMARY KEY (mediaID),
		UNIQUE mediakey (gedcom, mediakey),
		INDEX mediatypeID (mediatypeID),
		INDEX changedate (changedate),
		INDEX description (description(20)),
		INDEX headstones (cemeteryID, description(20)),
		FOREIGN KEY media_fk1 (mediaID) REFERENCES $medialinks_table (mediaID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$media_table" : $media_table;

	$query = "DROP TABLE IF EXISTS $mediatypes_table";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "CREATE TABLE $mediatypes_table (
		mediatypeID VARCHAR(20) NOT NULL,
		display VARCHAR(40) NOT NULL,
		path VARCHAR(127) NOT NULL,
		liketype VARCHAR(20) NOT NULL,
		icon VARCHAR(50) NOT NULL,
		ordernum TINYINT(4) NOT NULL,
		PRIMARY KEY (mediatypeID),
		INDEX ordernum (ordernum, display)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$mediatypes_table" : $mediatypes_table;

	$query = "DROP TABLE IF EXISTS $mostwanted_table";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$query = "CREATE TABLE $mostwanted_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		ordernum FLOAT NOT NULL,
		gedcom VARCHAR(20) NOT NULL,
		mwtype VARCHAR(10) NOT NULL,
		title VARCHAR(128) NOT NULL,
		description TEXT NOT NULL,
		personID VARCHAR(22) NOT NULL,
		mediaID INT(11) NOT NULL,
		PRIMARY KEY (ID),
		INDEX mwtype (mwtype,ordernum,title)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$mostwanted_table" : $mostwanted_table;

	$query = "DROP TABLE IF EXISTS $notelinks_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $notelinks_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		persfamID VARCHAR(22) NOT NULL,
		gedcom VARCHAR(20) NOT NULL,
		xnoteID INT(11) NOT NULL,
		eventID VARCHAR(10) NOT NULL,
		secret TINYINT(4) NOT NULL,
		PRIMARY KEY (ID),
		INDEX notelinks (gedcom, persfamID, eventID),
		FOREIGN KEY notelinks_fk1 (gedcom, persfamID) REFERENCES $people_table (gedcom, personID),
		FOREIGN KEY notelinks_fk2 (gedcom, persfamID) REFERENCES $families_table (gedcom, familyID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$notelinks_table" : $notelinks_table;

	$query = "DROP TABLE IF EXISTS $people_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $people_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		personID VARCHAR(22) NOT NULL,
		lnprefix VARCHAR(25) NOT NULL,
		lastname VARCHAR(127) NOT NULL,
		firstname VARCHAR(127) NOT NULL,
		birthdate VARCHAR(50) NOT NULL,
		birthdatetr DATE NOT NULL,
		sex TINYTEXT NOT NULL,
		birthplace TEXT NOT NULL,
		deathdate VARCHAR(50) NOT NULL,
		deathdatetr DATE NOT NULL,
		deathplace TEXT NOT NULL,
		altbirthdate VARCHAR(50) NOT NULL,
		altbirthdatetr DATE NOT NULL,
		altbirthplace TEXT NOT NULL,
		burialdate VARCHAR(50) NOT NULL,
		burialdatetr DATE NOT NULL,
		burialplace TEXT NOT NULL,
		baptdate VARCHAR(50) NOT NULL,
		baptdatetr DATE NOT NULL,
		baptplace TEXT NOT NULL,
		endldate VARCHAR(50) NOT NULL,
		endldatetr DATE NOT NULL,
		endlplace TEXT NOT NULL,
		changedate DATETIME NOT NULL,
		nickname TEXT NOT NULL,
		title TINYTEXT NOT NULL,
		prefix TINYTEXT NOT NULL,
		suffix TINYTEXT NOT NULL,
		nameorder TINYINT(4) NOT NULL,
		famc VARCHAR(22) NOT NULL,
		metaphone VARCHAR(15) NOT NULL,
		living TINYINT(4) NOT NULL,
		branch VARCHAR(100) NOT NULL,
		changedby VARCHAR(20) NOT NULL,
		PRIMARY KEY (ID),
		UNIQUE gedpers (gedcom, personID),
		INDEX lastname (lastname, firstname),
		INDEX firstname (firstname),
		INDEX gedlast (gedcom, lastname, firstname),
		INDEX gedfirst (gedcom, firstname),
		INDEX birthplace (birthplace(20)),
		INDEX altbirthplace (altbirthplace(20)),
		INDEX deathplace (deathplace(20)),
		INDEX burialplace (burialplace(20)),
		INDEX changedate (changedate)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$people_table" : $people_table;

	$query = "DROP TABLE IF EXISTS $places_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $places_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		place VARCHAR(248) NOT NULL,
		longitude VARCHAR(20) NULL,
		latitude VARCHAR(20) NULL,
		zoom TINYINT(4) NULL,
		placelevel TINYINT(4) NULL,
		notes TEXT NULL,
		PRIMARY KEY (ID),
		UNIQUE place (gedcom, place)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$places_table" : $places_table;

	$query = "DROP TABLE IF EXISTS $reports_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $reports_table (
		reportID INT(11) NOT NULL AUTO_INCREMENT,
		reportname VARCHAR(80) NOT NULL,
		reportdesc TEXT NOT NULL,
		rank INT(11) NOT NULL,
		display TEXT NOT NULL,
		criteria TEXT NOT NULL,
		orderby TEXT NOT NULL,
		sqlselect TEXT NOT NULL,
		active TINYINT(4) NOT NULL,
		PRIMARY KEY (reportID),
		INDEX reportname (reportname),
		INDEX rank (rank)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$reports_table" : $reports_table;

	$query = "DROP TABLE IF EXISTS $repositories_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $repositories_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		repoID VARCHAR(22) NOT NULL,
		reponame VARCHAR(90) NOT NULL,
		gedcom VARCHAR(20) NOT NULL,
		addressID INT(11) NOT NULL,
		changedate DATETIME NOT NULL,
		changedby VARCHAR(20) NOT NULL,
		PRIMARY KEY (ID),
		UNIQUE repoID (gedcom, repoID),
		INDEX reponame (reponame)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$repositories_table" : $repositories_table;

	$query = "DROP TABLE IF EXISTS $saveimport_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $saveimport_table (
		ID TINYINT(4) NOT NULL AUTO_INCREMENT,
		filename VARCHAR(100) NULL,
		icount INT(11) NULL,
		ioffset INT(11) NULL,
		fcount INT(11) NULL,
		foffset INT(11) NULL,
		scount INT(11) NULL,
		soffset INT(11) NULL,
		offset INT(11) NULL,
		delvar VARCHAR(10) NULL,
		gedcom VARCHAR(20) NULL,
		branch VARCHAR(20) NULL,
		ncount INT(11) NULL,
		noffset INT(11) NULL,
		rcount INT(11) NULL,
		roffset INT(11) NULL,
		mcount INT(11) NULL,
		ucaselast TINYINT(4) NULL,
		norecalc TINYINT(4) NULL,
		media TINYINT(4) NULL,
		neweronly TINYINT(4) NULL,
		lasttype TINYINT(4) NULL,
		lastid VARCHAR(22) NULL,
		PRIMARY KEY (ID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$saveimport_table" : $saveimport_table;

	$query = "DROP TABLE IF EXISTS $sources_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $sources_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		gedcom VARCHAR(20) NOT NULL,
		sourceID VARCHAR(22) NOT NULL,
		callnum VARCHAR(50) NOT NULL,
		type VARCHAR(20) NULL,
		title TEXT NOT NULL,
		author TEXT NOT NULL,
		publisher TEXT NOT NULL,
		other TEXT NOT NULL,
		shorttitle TEXT NOT NULL,
		comments TEXT NULL,
		actualtext TEXT NOT NULL,
		repoID VARCHAR(22) NOT NULL,
		changedate DATETIME NOT NULL,
		changedby VARCHAR(20) NOT NULL,
		PRIMARY KEY (ID),
		UNIQUE sourceID (gedcom, sourceID),
		INDEX changedate (changedate)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$sources_table" : $sources_table;

	$query = "DROP TABLE IF EXISTS $states_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $states_table (
	   state varchar(64) NOT NULL,
	   PRIMARY KEY (state)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$states_table" : $states_table;

	$query = "DROP TABLE IF EXISTS $temp_events_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $temp_events_table (
		tempID INT(11) NOT NULL AUTO_INCREMENT,
		type CHAR(1) NOT NULL,
		gedcom VARCHAR(20) NOT NULL,
		personID VARCHAR(22) NOT NULL,
		familyID VARCHAR(22) NOT NULL,
		eventID VARCHAR(10) NOT NULL,
		eventdate VARCHAR(50) NOT NULL,
		eventplace TEXT NOT NULL,
		info TEXT NOT NULL,
		note TEXT NOT NULL,
		user VARCHAR(20) NOT NULL,
		postdate DATETIME NULL,
		PRIMARY KEY (tempID),
		INDEX gedtype (gedcom, type),
		INDEX user (user)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$temp_events_table" : $temp_events_table;

	$query = "DROP TABLE IF EXISTS $tlevents_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $tlevents_table (
	   tleventID INT(11) NOT NULL AUTO_INCREMENT,
	   evday TINYINT(4) NULL,
	   evmonth TINYINT(4) NULL,
	   evyear VARCHAR(10) NOT NULL,
	   evdetail TEXT NOT NULL,
	   PRIMARY KEY (tleventID),
	   INDEX evyear (evyear, evmonth, evday, evdetail(100)),
	   INDEX evdetail (evdetail(100))
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$tlevents_table" : $tlevents_table;

	$query = "DROP TABLE IF EXISTS $trees_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $trees_table (
		gedcom VARCHAR(20) NOT NULL,
		treename VARCHAR(100) NOT NULL,
		description TEXT NOT NULL,
		owner VARCHAR(100) NOT NULL,
		email VARCHAR(100) NOT NULL,
		address VARCHAR(100) NOT NULL,
		city VARCHAR(40) NOT NULL,
		state VARCHAR(30) NOT NULL,
		country VARCHAR(30) NOT NULL,
		zip VARCHAR(20) NOT NULL,
		phone VARCHAR(30) NOT NULL,
		secret TINYINT(4) NOT NULL,
		disallowgedcreate TINYINT(4) NOT NULL,
		lastimportdate DATETIME NULL,
		PRIMARY KEY (gedcom)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$trees_table" : $trees_table;

	$query = "DROP TABLE IF EXISTS $users_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $users_table (
		userID INT(11) NOT NULL AUTO_INCREMENT,
		description VARCHAR(50) NOT NULL,
		username VARCHAR(100) NOT NULL,
		password VARCHAR(100) NOT NULL,
		gedcom VARCHAR(20) NULL,
		allow_edit TINYINT(4) NOT NULL,
		allow_add TINYINT(4) NOT NULL,
		tentative_edit TINYINT(4) NOT NULL,
		allow_delete TINYINT(4) NOT NULL,
		allow_lds TINYINT(4) NOT NULL,
		allow_ged TINYINT(4) NOT NULL,
		allow_living TINYINT(4) NOT NULL,
		branch VARCHAR(20) NULL,
		realname VARCHAR(50) NULL,
		phone VARCHAR(30) NULL,
		email VARCHAR(50) NULL,
		address VARCHAR(100) NULL,
		city VARCHAR(64) NULL,
		state VARCHAR(64) NULL,
		zip VARCHAR(10) NULL,
		country VARCHAR(64) NULL,
		website VARCHAR(128) NULL,
		lastlogin DATETIME NULL,
		dt_registered DATETIME NULL,
		dt_activated DATETIME NULL,
		no_email TINYINT(4) NULL,
		notes TEXT NULL,
		PRIMARY KEY (userID),
		UNIQUE username (username)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$users_table" : $users_table;

	$query = "DROP TABLE IF EXISTS $xnotes_table";
	$result = @mysql_query($query);
	$query = "CREATE TABLE $xnotes_table (
		ID INT(11) NOT NULL AUTO_INCREMENT,
		noteID VARCHAR(22) NOT NULL,
		gedcom VARCHAR(20) NOT NULL,
		note TEXT NOT NULL,
		PRIMARY KEY (ID),
		FULLTEXT note (note),
		INDEX noteID (gedcom, noteID),
		FOREIGN KEY xnotes_fk1 (gedcom, ID) REFERENCES $notelinks_table (gedcom, xnoteID)
	) TYPE = MYISAM";
	if( !@mysql_query($query) ) $badtables .= $badtables ? ",$xnotes_table" : $xnotes_table;

	return $badtables;
}

switch( $_POST['subroutine'] ) {
	case 'perms':
		//set permissions
		$failed = "";
		$success = 0;
		
		$files = array("genlog.txt","whatsnew.txt","admin/genlog.txt",$subroot."config.php",$subroot."importconfig.php",$subroot."logconfig.php",$subroot."pedconfig.php",$subroot."mapconfig.php","subroot.php");
		foreach( $files as $file ) {
			if( @chmod( $file, 0666 ) )
				$success++;
			else
				$failed .= $failed ? ",$file" : $file;
		}
		
		if( $success == count($files) ) {
			$msg = $text['perms'];
			$class = "green";
		}
		else
			$msg = $text['noperms'] . " $failed. " . $text['manual'];

		break;

	case 'folder':
		//create folder
		$foldername = $_POST['foldername'];
		$foldertype = $_POST['foldertype'];
		if( file_exists( $foldername ) )
			$msg = $text['folder'] . " $foldername " . $text['exists'];
		elseif( @mkdir( $foldername, 0777 ) ) {
			$msg = $text['folder'] . " $foldername " . $text['created'];
			$class = "green";
			if( $foldertype == "gedpath" )
				$saveimportconfig = 1;
			else
				$saveconfig = 1;
			eval("\$$foldertype = \"$foldername\";");
		}
		else
			$msg = $text['folder'] . " $foldername " . $text['nocreate'];
		break;

	case 'langfolder':
		//create folder
		$foldername = $_POST['foldername'];
		if( file_exists( $foldername ) )
			$msg = $text['folder'] . " $foldername " . $text['exists'];
		elseif( @mkdir( $foldername, 0644 ) ) {
			$msg = $text['folder'] . " $foldername " . $text['created'];
			$class = "green";
		}
		else
			$msg = $text['folder'] . " $foldername " . $text['nocreate'];
		break;
		
	case 'settings':
		if( !$rootpath ) {
			$rootpath = dirname(__FILE__) . "/";
			if (eregi("WIN",PHP_OS)) {
			    $rootpath = str_replace("\\","/",$rootpath);
			}
		}
		//verify settings
		$database_host = $_POST['database_host'];
		$database_name = $_POST['database_name'];
		$database_username = $_POST['database_username'];
		$database_password = $_POST['database_password'];
		if( @mysql_connect($database_host, $database_username, $database_password) ) {
			if( mysql_select_db($database_name) ) {
				$msg = $text['infosaved'];
				$class = "green";
			}
			else {
				$query  = "CREATE DATABASE $database_name";
				$result = @mysql_query($query);
				if( $result ) {
					if( mysql_select_db($database_name) ) {
						$msg = $text['newdb'] . " $database_name";
						$class = "green";
					}
					else
						$msg = $text['noattach'];
				}
				else
					$msg = $text['nodb'];
			}
		}
		else
			$msg = $text['noconn'];

		$saveconfig = 1;
		break;
		
	case 'tables':
		//try to create tables
		foreach( $_POST as $key => $value )
			eval("\$$key = \"$value\";");

		if( @mysql_connect($database_host, $database_username, $database_password) && mysql_select_db($database_name)) {
			$badtables = createtables();
			if( !$badtables ) {
				$msg = $text['tablescr'];
				$class = "green";
			}
			else
				$msg = $text['notables'] . " $badtables";
		}
		else
			$msg = $text['nocomm'];
		$saveconfig = 1;
		break;
		
	case 'user':
		//set up admin user
		break;
		
	case 'tree':
		//set up first tree
		break;

	case 'login';
   		$msg = $text['loginfirst'];
		break;
		
	default:
		//set default message
		$msg = $text['noop'];
		break;
}

if( $saveconfig ) {
	//save config.php values;
	$fp = @fopen( $subroot . "config.php", "w",1 );
	if( !$fp ) { die ( "$text[cannotopen] config.php" ); }

	flock( $fp, LOCK_EX );

	fwrite( $fp, "<?php\n" );
	fwrite( $fp, "@error_reporting( 2039 );\n" );
	fwrite( $fp, "\n" );
	fwrite( $fp, "\$database_host = \"$database_host\";\n" );
	fwrite( $fp, "\$database_name = \"$database_name\";\n" );
	fwrite( $fp, "\$database_username = \"$database_username\";\n" );
	fwrite( $fp, "\$database_password = \"$database_password\";\n" );
	fwrite( $fp, "\n" );
	fwrite( $fp, "\$people_table = \"$people_table\";\n" );
	fwrite( $fp, "\$families_table = \"$families_table\";\n" );
	fwrite( $fp, "\$children_table = \"$children_table\";\n" );
	fwrite( $fp, "\$albums_table = \"$albums_table\";\n" );
	fwrite( $fp, "\$album2entities_table = \"$album2entities_table\";\n" );
	fwrite( $fp, "\$albumlinks_table = \"$albumlinks_table\";\n" );
	fwrite( $fp, "\$media_table = \"$media_table\";\n" );
	fwrite( $fp, "\$medialinks_table = \"$medialinks_table\";\n" );
	fwrite( $fp, "\$mediatypes_table = \"$mediatypes_table\";\n" );
	fwrite( $fp, "\$address_table = \"$address_table\";\n" );
	fwrite( $fp, "\$languages_table = \"$languages_table\";\n" );
	fwrite( $fp, "\$cemeteries_table = \"$cemeteries_table\";\n" );
	fwrite( $fp, "\$states_table = \"$states_table\";\n" );
	fwrite( $fp, "\$countries_table = \"$countries_table\";\n" );
	fwrite( $fp, "\$places_table = \"$places_table\";\n" );
	fwrite( $fp, "\$sources_table = \"$sources_table\";\n" );
	fwrite( $fp, "\$repositories_table = \"$repositories_table\";\n" );
	fwrite( $fp, "\$citations_table = \"$citations_table\";\n" );
	fwrite( $fp, "\$events_table = \"$events_table\";\n" );
	fwrite( $fp, "\$eventtypes_table = \"$eventtypes_table\";\n" );
	fwrite( $fp, "\$reports_table = \"$reports_table\";\n" );
	fwrite( $fp, "\$trees_table = \"$trees_table\";\n" );
	fwrite( $fp, "\$notelinks_table = \"$notelinks_table\";\n" );
	fwrite( $fp, "\$xnotes_table = \"$xnotes_table\";\n" );
	fwrite( $fp, "\$saveimport_table = \"$saveimport_table\";\n" );
	fwrite( $fp, "\$users_table = \"$users_table\";\n" );
	fwrite( $fp, "\$temp_events_table = \"$temp_events_table\";\n" );
	fwrite( $fp, "\$tlevents_table = \"$tlevents_table\";\n" );
	fwrite( $fp, "\$branches_table = \"$branches_table\";\n" );
	fwrite( $fp, "\$branchlinks_table = \"$branchlinks_table\";\n" );
	fwrite( $fp, "\$assoc_table = \"$assoc_table\";\n" );
	fwrite( $fp, "\$mostwanted_table = \"$mostwanted_table\";\n" );
	fwrite( $fp, "\n" );
	fwrite( $fp, "\$rootpath = \"$rootpath\";\n" );
	fwrite( $fp, "\$homepage = \"$homepage\";\n" );
	fwrite( $fp, "\$tngdomain = \"$tngdomain\";\n" );
	if( !$target ) $target = "_self";
	fwrite( $fp, "\$target = \"$target\";\n" );
	fwrite( $fp, "\$language = \"$language\";\n" );
	fwrite( $fp, "\$charset = \"$charset\";\n" );
	fwrite( $fp, "\$maxsearchresults = \"$maxsearchresults\";\n" );
	fwrite( $fp, "\$lineending = \"\\r\\n\";\n" );
	fwrite( $fp, "\$mediapath = \"$mediapath\";\n" );
	fwrite( $fp, "\$gendexfile = \"$gendexfile\";\n" );
	fwrite( $fp, "\$headstonepath = \"$headstonepath\";\n" );
	fwrite( $fp, "\$historypath = \"$historypath\";\n" );
	fwrite( $fp, "\$backuppath = \"$backuppath\";\n" );
	fwrite( $fp, "\$documentpath = \"$documentpath\";\n" );
	fwrite( $fp, "\$photopath = \"$photopath\";\n" );
	fwrite( $fp, "\$photosext = \"$photosext\";\n" );
	fwrite( $fp, "\$showextended = \"$showextended\";\n" );
	fwrite( $fp, "\$thumbprefix = \"$thumbprefix\";\n" );
	fwrite( $fp, "\$thumbsuffix = \"$thumbsuffix\";\n" );
	fwrite( $fp, "\$thumbmaxh = \"$thumbmaxh\";\n" );
	fwrite( $fp, "\$thumbmaxw = \"$thumbmaxw\";\n" );
	fwrite( $fp, "\$tngconfig[thumbcols] = \"$tngconfig[thumbcols]\";\n" );
	fwrite( $fp, "\$newmedialinks = \"$newmedialinks\";\n" );
	fwrite( $fp, "\$customheader = \"$customheader\";\n" );
	fwrite( $fp, "\$customfooter = \"$customfooter\";\n" );
	fwrite( $fp, "\$custommeta = \"$custommeta\";\n" );
	fwrite( $fp, "\$tngconfig[tabs] = \"$tngconfig[tabs]\";\n" );
	fwrite( $fp, "\$tngconfig[menu] = \"$tngconfig[menu]\";\n" );
	fwrite( $fp, "\$tngconfig[icons] = \"$tngconfig[icons]\";\n" );
	fwrite( $fp, "\$tngconfig[istart] = \"$tngconfig[istart]\";\n" );
	
	fwrite( $fp, "\$emailaddr = \"$emailaddr\";\n" );
	fwrite( $fp, "\$dbowner = \"$dbowner\";\n" );
	fwrite( $fp, "\$time_offset = \"$time_offset\";\n" );
	fwrite( $fp, "\$requirelogin = \"$requirelogin\";\n" );
	fwrite( $fp, "\$livedefault = \"$livedefault\";\n" );
	fwrite( $fp, "\$ldsdefault = \"$ldsdefault\";\n" );
	fwrite( $fp, "\$chooselang = \"$chooselang\";\n" );
	fwrite( $fp, "\$nonames = \"$nonames\";\n" );
	fwrite( $fp, "\$notestogether = \"$notestogether\";\n" );
	fwrite( $fp, "\$nameorder = \"$nameorder\";\n" );
	fwrite( $fp, "\$lnprefixes = \"$lnprefixes\";\n" );
	fwrite( $fp, "\$lnpfxnum = \"$lnpfxnum\";\n" );
	fwrite( $fp, "\$specpfx = \"$specpfx\";\n" );
	fwrite( $fp, "\$photosext = \"$photosext\";\n" );
	
	fwrite( $fp, "\$tngconfig[maxdesc] = \"$tngconfig[maxdesc]\";\n" );
	fwrite( $fp, "\$defdesc = \"$defdesc\";\n" );
	fwrite( $fp, "\$tngconfig[stdesc] = \"$tngconfig[stdesc]\";\n" );
	fwrite( $fp, "\$tngconfig[regnotes] = \"$tngconfig[regnotes]\";\n" );
	fwrite( $fp, "\$tngconfig[regnosp] = \"$tngconfig[regnosp]\";\n" );
	
	fwrite( $fp, "\$maxgedcom = \"$maxgedcom\";\n" );
	fwrite( $fp, "\$change_cutoff = \"$change_cutoff\";\n" );
	fwrite( $fp, "\$change_limit = \"$change_limit\";\n" );
	fwrite( $fp, "\$defaulttree = \"$defaulttree\";\n" );
	fwrite( $fp, "\n" );
	fwrite( $fp, "if(!isset(\$cms[auto])) {\n" );
	fwrite( $fp, "\$cms[support] = \"$cms[support]\";\n" );
	fwrite( $fp, "\$cms[url] = \"$cms[url]\";\n" );
	fwrite( $fp, "\$cms[tngpath] = \"$cms[tngpath]\";\n" );
	fwrite( $fp, "\$cms[module] = \"$cms[module]\";\n" );
	fwrite( $fp, "\$cms[cloaklogin] = \"$cms[cloaklogin]\";\n" );
	fwrite( $fp, "\$cms[credits] = \"$cms[credits]\";\n" );
	fwrite( $fp, "}\n" );
	fwrite( $fp, "\n" );
	fwrite( $fp, "if(file_exists(\$cms[tngpath] . \"customconfig.php\")) { include(\$cms[tngpath] . \"customconfig.php\"); }\n" );
	fwrite( $fp, "?>\n" );

	flock( $fp, LOCK_UN );
	fclose( $fp );
}

if( $saveimportconfig ) {
	$fp = @fopen( $subroot . "importconfig.php", "w",1 );
	if( !$fp ) { die ( "$text[cannotopen] importconfig.php" ); }

	flock( $fp, LOCK_EX );

	fwrite( $fp, "<?php\n" );
	fwrite( $fp, "\$gedpath = \"$gedpath\";\n" );
	fwrite( $fp, "\$saveimport = \"$saveimport\";\n" );
	fwrite( $fp, "\$assignnames = \"$assignnames\";\n" );
	fwrite( $fp, "\$tngimpcfg[chdate] = \"$tngimpcfg[chdate]\";\n" );
	fwrite( $fp, "\$tngimpcfg[livingreqbirth] = \"$tngimpcfg[livingreqbirth]\";\n" );
	fwrite( $fp, "\$tngimpcfg[maxlivingage] = \"$tngimpcfg[maxlivingage]\";\n" );
	fwrite( $fp, "\$locimppath[photos] = \"$localphotopathdisplay\";\n" );
	fwrite( $fp, "\$locimppath[histories] = \"$localhistorypathdisplay\";\n" );
	fwrite( $fp, "\$locimppath[documents] = \"$localdocumentpathdisplay\";\n" );
	fwrite( $fp, "\$locimppath[other] = \"$localotherpathdisplay\";\n" );
	fwrite( $fp, "\$wholepath = \"$wholepath\";\n" );
	fwrite( $fp, "?>\n" );

	flock( $fp, LOCK_UN );
	fclose( $fp );
}

header('Content-Type: application/xml');
echo "<?xml version=\"1.0\"";
if($session_charset)
	echo " encoding=\"$session_charset\"";
echo "?>\n";
echo "<install>\n";
echo "<installElement>\n";
echo "<divName>" . $_POST['targetdiv'] . "</divName>\n";
echo "<colorClass>$class</colorClass>\n";
echo "</installElement>\n";
echo "<message>\n";
echo "<messageText>$msg</messageText>\n";
echo "</message>\n";
echo "</install>\n";
?>
