<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "setup";
include("../getlang.php");
include("../$mylanguage/admintext.php");
$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
if( $link ) {
	include("checklogin.php");
	include("../version.php");
	if( $assignedtree ) {
		$message = "$admtext[norights]";
		header( "Location: login.php?message=" . urlencode($message) );
		exit;
	}
}

require("adminlog.php");

if( $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$query = "DROP TABLE IF EXISTS $address_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$query = "CREATE TABLE $branches_table (
	branch VARCHAR(20) NOT NULL,
	gedcom VARCHAR(20) NOT NULL,
	description VARCHAR(128) NOT NULL,
	PRIMARY KEY (branch),
	INDEX description (gedcom, description)
) TYPE = MYISAM";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $branchlinks_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$query = "CREATE TABLE $branchlinks_table (
	ID INT(11) NOT NULL AUTO_INCREMENT,
	branch VARCHAR(20) NOT NULL,
	gedcom VARCHAR(20) NOT NULL,
	persfamID VARCHAR(22) NOT NULL,
	PRIMARY KEY (ID),
	UNIQUE branch (gedcom, branch, persfamID)
) TYPE = MYISAM";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $cemeteries_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $children_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $citations_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $countries_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$query = "CREATE TABLE $countries_table (
    country varchar(64) NOT NULL,
    PRIMARY KEY (country)
) TYPE = MYISAM";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $events_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $eventtypes_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $families_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
	changedate DATETIME NULL,
	living TINYINT(4) NOT NULL,
	branch VARCHAR(100) NOT NULL,
	changedby VARCHAR(20) NOT NULL,
	PRIMARY KEY (ID),
	UNIQUE familyID (gedcom, familyID),
	INDEX husband (gedcom, husband),
	INDEX wife (gedcom, wife),
	INDEX changedate (changedate)
) TYPE = MYISAM";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $languages_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$query = "CREATE TABLE $languages_table (
	languageID SMALLINT(6) NOT NULL AUTO_INCREMENT,
	display VARCHAR(100) NOT NULL,
	folder VARCHAR(50) NOT NULL,
	charset VARCHAR(30) NOT NULL,
	PRIMARY KEY (languageID)
) TYPE = MYISAM";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $notelinks_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $people_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
	changedate DATETIME NULL,
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $places_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $reports_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $repositories_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$query = "CREATE TABLE $repositories_table (
	ID INT(11) NOT NULL AUTO_INCREMENT,
	repoID VARCHAR(22) NOT NULL,
	reponame VARCHAR(90) NOT NULL,
	gedcom VARCHAR(20) NOT NULL,
	addressID INT(11) NOT NULL,
	changedate DATETIME NULL,
	changedby VARCHAR(20) NOT NULL,
	PRIMARY KEY (ID),
	UNIQUE repoID (gedcom, repoID),
	INDEX reponame (reponame)
) TYPE = MYISAM";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $saveimport_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $sources_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
	changedate DATETIME NULL,
	changedby VARCHAR(20) NOT NULL,
	PRIMARY KEY (ID),
	UNIQUE sourceID (gedcom, sourceID),
	INDEX changedate (changedate)
) TYPE = MYISAM";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $states_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$query = "CREATE TABLE $states_table (
   state varchar(64) NOT NULL,
   PRIMARY KEY (state)
) TYPE = MYISAM";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $temp_events_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
	postdate DATETIME NOT NULL,
	PRIMARY KEY (tempID),
	INDEX gedtype (gedcom, type),
	INDEX user (user)
) TYPE = MYISAM";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $tlevents_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $trees_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $users_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$query = "DROP TABLE IF EXISTS $xnotes_table";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
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
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

adminwritelog( $admtext[createtables] );

tng_adminheader( $admtext[tablecreation], "" );
?>
</head>

<body background="../background.gif">

<?php
	$setuptabs[0] = array(1,"setup.php",$admtext[configuration],"configuration");
	$setuptabs[1] = array(1,"setup.php?sub=diagnostics",$admtext[diagnostics],"diagnostics");
	$setuptabs[2] = array(1,"setup.php?sub=tablecreation",$admtext[tablecreation],"tablecreation");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/setup_help.php#tables', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($datatabs,"tablecreation",$innermenu);
	echo displayHeadline("$admtext[setup] &gt;&gt; $admtext[tablecreation]","setup_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
	<tr class="databack">
		<td class="tngshadow"><span class="normal"><p><?php echo $admtext[tablesuccess]; ?></p>
			<p><a href="setup.php"><?php echo $admtext[backtosetup]; ?></a>.</p></span>
		</td>
	</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
