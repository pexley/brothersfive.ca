<?php
include("begin.php");
//session_cache_limiter('public');
include($cms['tngpath'] . "genlib.php");
$textpart = "search";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );
include($cms['tngpath'] . "functions.php");

$searchform_url = getURL( "searchform", 1 );
$search_url = getURL( "search", 1 );
$placesearch_url = getURL( "placesearch", 1 );
$getperson_url = getURL( "getperson", 1 );
$showtree_url = getURL( "showtree", 1 );
$pedigree_url = getURL( "pedigree", 1 );

@set_time_limit(0);
$maxsearchresults = $nr ? $nr : ($_SESSION['tng_nr'] ? $_SESSION['tng_nr'] : $maxsearchresults);

$_SESSION['tng_search_tree'] = $tree;
$_SESSION['tng_search_lnqualify'] = $lnqualify;
$_SESSION['tng_search_lastname'] = $mylastname = trim( stripslashes($mylastname) );
$_SESSION['tng_search_fnqualify'] = $fnqualify;
$_SESSION['tng_search_firstname'] = $myfirstname = trim( stripslashes($myfirstname) );
$_SESSION['tng_search_idqualify'] = $idqualify;
$_SESSION['tng_search_personid'] = $mypersonid = trim( stripslashes($mypersonid) );
$_SESSION['tng_search_bpqualify'] = $bpqualify;
$_SESSION['tng_search_birthplace'] = $mybirthplace = trim( stripslashes($mybirthplace) );
$_SESSION['tng_search_byqualify'] = $byqualify;
$_SESSION['tng_search_birthyear'] = $mybirthyear = trim( stripslashes($mybirthyear) );
$_SESSION['tng_search_cpqualify'] = $cpqualify;
$_SESSION['tng_search_altbirthplace'] = $myaltbirthplace = trim( stripslashes($myaltbirthplace) );
$_SESSION['tng_search_cyqualify'] = $cyqualify;
$_SESSION['tng_search_altbirthyear'] = $myaltbirthyear = trim( stripslashes($myaltbirthyear) );
$_SESSION['tng_search_dpqualify'] = $dpqualify;
$_SESSION['tng_search_deathplace'] = $mydeathplace = trim( stripslashes($mydeathplace) );
$_SESSION['tng_search_dyqualify'] = $dyqualify;
$_SESSION['tng_search_deathyear'] = $mydeathyear = trim( stripslashes($mydeathyear) );
$_SESSION['tng_search_brpqualify'] = $brpqualify;
$_SESSION['tng_search_burialplace'] = $myburialplace = trim( stripslashes($myburialplace) );
$_SESSION['tng_search_bryqualify'] = $bryqualify;
$_SESSION['tng_search_burialyear'] = $myburialyear = trim( stripslashes($myburialyear) );
$_SESSION['tng_search_bool'] = $mybool;
$_SESSION['tng_search_showdeath'] = $showdeath;
$_SESSION['tng_search_gender'] = $mygender;
$_SESSION['tng_search_showspouse'] = $showspouse;
$_SESSION['tng_search_mysplname'] = $mysplname = trim( stripslashes($mysplname) );
$_SESSION['tng_search_spqualify'] = $spqualify;
$_SESSION['tng_nr'] = $nr;
if($order)
	$_SESSION['tng_search_order'] = $order;
else {
	$order = isset($_SESSION['tng_search_order']) ? $_SESSION['tng_search_order'] : "name";
	if(!$showdeath && ($order == "death" || $order == "deathup"))
		$order = "name";
}

$birthsort = "birth";
$deathsort = "death";
$namesort = "nameup";
$orderloc = strpos($_SERVER['QUERY_STRING'],"&order=");
$currargs = $orderloc > 0 ? substr($_SERVER['QUERY_STRING'],0,$orderloc) : $_SERVER['QUERY_STRING'];
$birthlabel = $tngconfig['hidechr'] ? $text['born'] : $text['bornchr'];

if($order == "birth") {
	$orderstr = "IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr), p.lastname, p.firstname";
	$birthsort = "<a href=\"$search_url$currargs&order=birthup\" class=\"lightlink\">$birthlabel <img src=\"$cms[tngpath]tng_sort_desc.gif\" width=\"15\" height=\"8\" border=\"0\" /></a>";
}
else {
	$birthsort = "<a href=\"$search_url$currargs&order=birth\" class=\"lightlink\">$birthlabel <img src=\"$cms[tngpath]tng_sort_asc.gif\" width=\"15\" height=\"8\" border=\"0\" /></a>";
	if($order == "birthup")
		$orderstr = "IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr) DESC, p.lastname, p.firstname";
}

if($order == "death") {
	$orderstr = "IF(p.deathdatetr, p.deathdatetr, p.burialdatetr), p.lastname, p.firstname, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
	$deathsort = "<a href=\"$search_url$currargs&order=deathup\" class=\"lightlink\">$text[diedburied] <img src=\"$cms[tngpath]tng_sort_desc.gif\" width=\"15\" height=\"8\" border=\"0\" /></a>";
}
else {
	$deathsort = "<a href=\"$search_url$currargs&order=death\" class=\"lightlink\">$text[diedburied] <img src=\"$cms[tngpath]tng_sort_asc.gif\" width=\"15\" height=\"8\" border=\"0\" /></a>";
	if($order == "deathup")
		$orderstr = "IF(p.deathdatetr, p.deathdatetr, p.burialdatetr) DESC, p.lastname, p.firstname, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
}

if($order == "name") {
	$orderstr = "p.lastname, p.firstname, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
	$namesort = "<a href=\"$search_url$currargs&order=nameup\" class=\"lightlink\">$text[lastfirst] <img src=\"$cms[tngpath]tng_sort_desc.gif\" width=\"15\" height=\"8\" border=\"0\" /></a>";
}
else {
	$namesort = "<a href=\"$search_url$currargs&order=name\" class=\"lightlink\">$text[lastfirst] <img src=\"$cms[tngpath]tng_sort_asc.gif\" width=\"15\" height=\"8\" border=\"0\" /></a>";
	if($order == "nameup")
		$orderstr = "p.lastname DESC, p.firstname DESC, IF(p.birthdatetr, p.birthdatetr, p.altbirthdatetr)";
}

function buildCriteria( $column, $colvar, $qualifyvar, $qualifier, $value, $textstr ) {
	global $allwhere, $querystring, $lnprefixes;

	if( $qualifier == "exists" || $qualifier == "dnexist" )
		$value = $usevalue = "";
	else {
		$value = urldecode(trim($value));
		$usevalue = addslashes( $value );
	}

	if( $column == "p.lastname" && $lnprefixes )
		$column = "TRIM(CONCAT_WS(' ',p.lnprefix,p.lastname))";
	elseif( $column == "spouse.lastname" )
		$column = "TRIM(CONCAT_WS(' ',spouse.lnprefix,spouse.lastname))";

	$criteria = "";
	$returnarray = buildColumn( $qualifier, $column, $usevalue );
	$criteria .= $returnarray[criteria];
	$qualifystr = $returnarray[qualifystr];

	addtoQuery( $textstr, $colvar, $criteria, $qualifyvar, $qualifier, $qualifystr, $value );
}

function buildColumn( $qualifier, $column, $usevalue ) {
	global $text;

	$criteria = "";
	switch ($qualifier) {
		case "equals":
			$criteria .= "$column = \"$usevalue\"";
			$qualifystr = $text[equals];
			break;
		case "startswith":
			$criteria .= "$column LIKE \"$usevalue%\"";
			$qualifystr = $text[startswith];
			break;
		case "endswith":
			$criteria .= "$column LIKE \"%$usevalue\"";
			$qualifystr = $text[endswith];
			break;
		case "exists":
			$criteria .= "$column != \"\"";
			$qualifystr = $text[exists];
			break;
		case "dnexist":
			$criteria .= "$column = \"\"";
			$qualifystr = $text[dnexist];
			break;
		case "soundexof":
			$criteria .= "SOUNDEX($column) = SOUNDEX(\"$usevalue\")";
			$qualifystr = $text[soundexof];
			break;
		case "metaphoneof":
			$criteria .= "metaphone = \"" . metaphone($usevalue) . "\"";
			$qualifystr = $text[metaphoneof];
			break;
		default:
			$criteria .= "$column LIKE \"%$usevalue%\"";
			$qualifystr = $text[contains];
			break;
	}
	$returnarray[criteria] = $criteria;
	$returnarray[qualifystr] = $qualifystr;
	
	return $returnarray;
}

function buildYearCriteria( $column, $colvar, $qualifyvar, $altcolumn, $qualifier, $value, $textstr ) {
	global $text;

	if( $qualifier == "exists" || $qualifier == "dnexist" ) {
		$value = "";
	}
	else {
		$value = urldecode(trim($value));
		if (get_magic_quotes_gpc() == 0)
			$value = addslashes( $value );
		$yearstr1 = $altcolumn ? "IF($column!='0000-00-00',YEAR($column),YEAR($altcolumn))" : "YEAR($column)";
		$yearstr2 = $altcolumn ? "IF($column,YEAR($column), YEAR($altcolumn))" : "YEAR($column)";
	}

	$criteria = "";
	switch ($qualifier) {
		case "pm2":
			$criteria = "($yearstr1 < $value + 2 AND $yearstr2 > $value - 2)";
			$qualifystr = $text[plusminus2];
			break;
		case "pm5":
			$criteria = "($yearstr1 < $value + 5 AND $yearstr2 > $value - 5)";
			$qualifystr = $text[plusminus2];
			break;
		case "pm10":
			$criteria = "($yearstr1 < $value + 10 AND $yearstr2 > $value - 10)";
			$qualifystr = $text[plusminus10];
			break;
		case "lt":
			$criteria = "($yearstr1 != \"\" AND $yearstr1 < \"$value\")";
			$qualifystr = $text[lessthan];
			break;
		case "gt":
			$criteria = "$yearstr1 > \"$value\"";
			$qualifystr = $text[greaterthan];
			break;
		case "lte":
			$criteria = "($yearstr1 != \"\" AND $yearstr1 <= \"$value\")";
			$qualifystr = $text[lessthanequal];
			break;
		case "gte":
			$criteria = "$yearstr1 >= \"$value\"";
			$qualifystr = $text[greaterthanequal];
			break;
		case "exists":
			$criteria = "YEAR($column) != \"\"";
			if( $altcolumn ) $criteria = "($criteria OR YEAR($altcolumn) != \"\")";
			$qualifystr = $text[exists];
			break;
		case "dnexist":
			$criteria = "YEAR($column) = \"\"";
			if( $altcolumn ) $criteria .= " AND YEAR($altcolumn) = \"\"";
			$qualifystr = $text[dnexist];
			break;
		default:
			$criteria = "$yearstr1 = \"$value\"";
			$qualifystr = $text[equalto];
			break;
	}
	addtoQuery( $textstr, $colvar, $criteria, $qualifyvar, $qualifier, $qualifystr, $value );
}

function addtoQuery( $textstr, $colvar, $criteria, $qualifyvar, $qualifier, $qualifystr, $value ) {
	global $allwhere, $mybool, $querystring, $urlstring;

	if( $urlstring )
		$urlstring .= "&amp;";
	$urlstring .= "$colvar=" . urlencode($value) . "&amp;$qualifyvar=$qualifier";
	
	if( $querystring )
		$querystring .= "$mybool ";
	$querystring .= "$textstr $qualifystr " . stripslashes($value) . " ";

	if( $criteria ) {
		if( $allwhere )  $allwhere .= " " . $mybool;
		$allwhere .= " " . $criteria;
	}
}

$querystring = "";
$allwhere = "";

if( $mylastname || $lnqualify == "exists" || $lnqualify == "dnexist" )  {
	if( $mylastname == $text[nosurname] )
		addtoQuery( "lastname", "mylastname", "lastname = \"\"", "lnqualify", $text[equals], $text[equals], $mylastname );
	else {
		buildCriteria( "p.lastname", "mylastname", "lnqualify", $lnqualify, $mylastname, $text[lastname] );
	}
}
if( $myfirstname || $fnqualify == "exists" || $fnqualify == "dnexist" ) {
	buildCriteria( "p.firstname", "myfirstname", "fnqualify", $fnqualify, $myfirstname, $text[firstname] );
}
if( $mysplname || $spqualify == "exists" || $spqualify == "dnexist" ) {
	buildCriteria( "spouse.lastname", "mysplname", "spqualify", $spqualify, $mysplname, $text[spousesurname] );
}
if( $mypersonid ) {
	$mypersonid = strtoupper($mypersonid);
	if($idqualify == "equals" && substr($mypersonid,0,1) != "I") $mypersonid = "I" . $mypersonid;
	buildCriteria( "p.personID", "mypersonid", "idqualify", $idqualify, $mypersonid, $text[personid] );
}
if( $mytitle || $tqualify == "exists" || $tqualify == "dnexist" ) {
	buildCriteria( "p.title", "mytitle", "tqualify", $tqualify, $mytitle, $text[title] );
}
if( $myprefix || $pfqualify == "exists" || $pfqualify == "dnexist" ) {
	buildCriteria( "p.prefix", "myprefix", "pfqualify", $pfqualify, $myprefix, $text[prefix] );
}
if( $mysuffix || $sfqualify == "exists" || $sfqualify == "dnexist" ) {
	buildCriteria( "p.suffix", "mysuffix", "sfqualify", $sfqualify, $mysuffix, $text[suffix] );
}
if( $mynickname || $nnqualify == "exists" || $nnqualify == "dnexist" ) {
	buildCriteria( "p.nickname", "mynickname", "nnqualify", $nnqualify, $mynickname, $text[nickname] );
}
if( $mybirthplace || $bpqualify == "exists" || $bpqualify == "dnexist" ) {
	buildCriteria( "p.birthplace", "mybirthplace", "bpqualify", $bpqualify, $mybirthplace, $text[birthplace] );
}
if( $mybirthyear || $byqualify == "exists" || $byqualify == "dnexist" ) {
	buildYearCriteria( "p.birthdatetr", "mybirthyear", "byqualify", "p.altbirthdatetr", $byqualify, $mybirthyear, $text[birthdatetr] );
}
if( $myaltbirthplace || $cpqualify == "exists" || $cpqualify == "dnexist" ) {
	buildCriteria( "p.altbirthplace", "myaltbirthplace", "cpqualify", $cpqualify, $myaltbirthplace, $text[altbirthplace] );
}
if( $myaltbirthyear || $cyqualify == "exists" || $cyqualify == "dnexist" ) {
	buildYearCriteria( "p.altbirthdatetr", "myaltbirthyear", "cyqualify", "", $cyqualify, $myaltbirthyear, $text[altbirthdatetr] );
}
if( $mydeathplace || $dpqualify == "exists" || $dpqualify == "dnexist" ) {
	buildCriteria( "p.deathplace", "mydeathplace", "dpqualify", $dpqualify, $mydeathplace, $text[deathplace] );
}
if( $mydeathyear || $dyqualify == "exists" || $dyqualify == "dnexist" ) {
	buildYearCriteria( "p.deathdatetr", "mydeathyear", "dyqualify", "p.burialdatetr", $dyqualify, $mydeathyear, $text[deathdatetr] );
}
if( $myburialplace || $brpqualify == "exists" || $brpqualify == "dnexist" ) {
	buildCriteria( "p.burialplace", "myburialplace", "brpqualify", $brpqualify, $myburialplace, $text[burialplace] );
}
if( $myburialyear || $bryqualify == "exists" || $bryqualify == "dnexist" ) {
	buildYearCriteria( "p.burialdatetr", "myburialyear", "bryqualify", "", $bryqualify, $myburialyear, $text[burialdatetr] );
}
if( $mygender ) {
	if($mygender == "N") $mygender = "";
	buildCriteria( "p.sex", "mygender", "gequalify", $gequalify, $mygender, $text[gender] );
}

$query = "SELECT eventtypeID, tag, display FROM $eventtypes_table WHERE keep=\"1\" AND type=\"I\" ORDER BY display";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$dontdo = array("ADDR","BIRT","CHR","DEAT","BURI","NAME","NICK","TITL","NSFX");
$needce = 0;
$ecount = 0;
$cejoin = "";
while( $row = mysql_fetch_assoc( $result ) ) {
	if( !in_array( $row[tag], $dontdo ) ) {
		$needecount = 1;
		$display = getEventDisplay( $row[display] );

		$cefstr = "cef$row[eventtypeID]";
		eval( "\$cef = \$$cefstr;" );
		//$_SESSION["tng_search_$cefstr"] = $cef = trim( stripslashes($cef) );
		$cfqstr = "cfq$row[eventtypeID]";
		eval( "\$cfq = \$$cfqstr;" );
		//$_SESSION["tng_search_$cfqstr"] = $cfq;
		if( $cef  || $cfq == "exists" || $cfq == "dnexist") {
			if( $needecount ) {
				$needecount = 0;
				$ecount++;
			}
			$tablepfx = $mybool == "OR" ? "" : "e$ecount.";
			buildCriteria( $tablepfx . "info", $cefstr, $cfqstr, $cfq, $cef, "$display ($text[fact])" );
			$needce = 1;
		}
		
		$cepstr = "cep$row[eventtypeID]";
		eval( "\$cep = \$$cepstr;" );
		//$_SESSION["tng_search_$cepstr"] = $cep = trim( stripslashes($cep) );
		$cpqstr = "cpq$row[eventtypeID]";
		eval( "\$cpq = \$$cpqstr;" );
		//$_SESSION["tng_search_$cpqstr"] = $cpq;
		if( $cep || $cpq == "exists" || $cpq == "dnexist" ) {
			if( $needecount ) {
				$needecount = 0;
				$ecount++;
			}
			$tablepfx = $mybool == "OR" ? "" : "e$ecount.";
			buildCriteria( $tablepfx . "eventplace", $cepstr, $cpqstr, $cpq, $cep, "$display ($text[place])" );
			$needce = 1;
		}
		
		$ceystr = "cey$row[eventtypeID]";
		eval( "\$cey = \$$ceystr;" );
		//$_SESSION["tng_search_$ceystr"] = $cey = trim( stripslashes($cey) );
		$cyqstr = "cyq$row[eventtypeID]";
		eval( "\$cyq = \$$cyqstr;" );
		//$_SESSION["tng_search_$cyqstr"] = $cyq;
		if( $cey || $cyq == "exists" || $cyq == "dnexist" ) {
			if( $needecount ) {
				$needecount = 0;
				$ecount++;
			}
			$tablepfx = $mybool == "OR" ? "" : "e$ecount.";
			buildYearCriteria( $tablepfx . "eventdatetr", $ceystr, $cyqstr, "", $cyq, $cey, "$display ($text[year])" );
			$needce = 1;
		}
		if( $needce && $mybool == "AND" ) {
			$cejoin .= "INNER JOIN $events_table as e$ecount ON p.gedcom = $tablepfx" . "gedcom AND p.personID = $tablepfx" . "persfamID ";
			if( $allwhere ) $allwhere .= " $mybool ";
			$allwhere .= $tablepfx . "eventtypeID = \"$row[eventtypeID]\" ";
			$needce = 0;
		}
	}
} 
mysql_free_result($result);
if( !$cejoin && $ecount ) 
	$cejoin = "LEFT JOIN $events_table ON p.gedcom = $events_table.gedcom AND p.personID = $events_table.persfamID " ;

if( $tree ) {
	if( $urlstring )
		$urlstring .= "&amp;";
	$urlstring .= "tree=$tree";
	
	if( $querystring )
		$querystring .= "AND ";

	$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
	$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$treerow = mysql_fetch_assoc($treeresult);
	mysql_free_result($treeresult);

	$querystring .= "tree $text[equals] $treerow[treename]";

	if( $allwhere ) $allwhere = "($allwhere) AND";
	$allwhere .= " p.gedcom=\"$tree\"";
}

if( $livedefault < 2 && ( !$allow_living_db || $assignedtree ) && ( $nonames == 1 || $mytitle || $myprefix || $mysuffix || $mynickname || $mybirthplace || $mydeathplace || $mybirthyear || $mydeathyear || $ecount || ( $nonames == 2 && $myfirstname ) ) ) {
	if( $allwhere ) $allwhere = $tree ? "$allwhere AND " : "($allwhere) AND ";
	if( $allow_living_db ) {
		if( $assignedbranch )
			$allwhere .= "(p.living != 1 OR (p.gedcom = \"$assignedtree\" AND p.branch LIKE \"%$assignedbranch%\") )";
		else
			$allwhere .= "(p.living != 1 OR p.gedcom = \"$assignedtree\")";
	}
	else
		$allwhere .= "p.living != 1";
}

if( $allwhere ) {
	$allwhere = "WHERE " . $allwhere;
	$querystring = "$text[text_for] $querystring";
}

$max_browsesearch_pages = 5;
if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

if(($mysplname && $mygender ) || $spqualify == "exists" || $spqualify == "dnexist") {
	$gstring = $mygender == "F" ? "p.personID = wife AND spouse.personID = husband" : "p.personID = husband AND spouse.personID = wife";
	$query = "SELECT p.ID, spouse.personID as spersonID, p.personID, p.lastname, p.lnprefix, p.firstname, p.living,
		p.branch, p.nickname, p.suffix, p.prefix, p.nameorder, p.title, p.birthplace, p.birthdate, p.deathplace, p.deathdate, LPAD(SUBSTRING_INDEX(p.birthdate, ' ', -1),4,'0') as birthyear,
		p.altbirthdate, LPAD(SUBSTRING_INDEX(p.altbirthdate, ' ', -1),4,'0') as altbirthyear, p.altbirthplace, p.gedcom, treename
		FROM ($people_table as p, $families_table, $people_table as spouse, $trees_table) $cejoin
		$allwhere AND (p.gedcom = $trees_table.gedcom AND p.gedcom=$families_table.gedcom AND spouse.gedcom=$families_table.gedcom AND $gstring)
		ORDER BY $orderstr LIMIT $newoffset" . $maxsearchresults;
	$showspouse = "yess";
	$query2 ="SELECT count(p.ID) as pcount
        FROM ($people_table as p, $families_table, $people_table as spouse, $trees_table) $cejoin
		$allwhere AND (p.gedcom = $trees_table.gedcom AND p.gedcom=$families_table.gedcom AND spouse.gedcom=$families_table.gedcom AND $gstring)";
}
else {
	if( $showspouse == "yes" ) {
		$families_join = "LEFT JOIN $families_table AS families1 ON (p.gedcom = families1.gedcom AND p.personID = families1.husband ) LEFT JOIN $families_table AS families2 ON (p.gedcom = families2.gedcom AND p.personID = families2.wife ) ";  // added IDF Apr 03
		$huswife = ", families1.wife as wife, families2.husband as husband";																													   // added IDF Apr 03
	}
	else {
		$families_join = "";
		$huswife = "";
	}

	$query = "SELECT p.ID, p.personID, lastname, lnprefix, firstname, p.living, p.branch, nickname, prefix, suffix, nameorder, title, birthplace, birthdate, deathplace, deathdate, LPAD(SUBSTRING_INDEX(birthdate, ' ', -1),4,'0') as birthyear, altbirthdate, LPAD(SUBSTRING_INDEX(altbirthdate, ' ', -1),4,'0') as altbirthyear, altbirthplace, p.gedcom, treename $huswife
		FROM $people_table AS p $families_join LEFT JOIN $trees_table on p.gedcom = $trees_table.gedcom $cejoin $allwhere ORDER BY $orderstr LIMIT $newoffset" . $maxsearchresults;
	$query2 = "SELECT count(p.ID) as pcount FROM $people_table AS p $families_join LEFT JOIN $trees_table on p.gedcom = $trees_table.gedcom $cejoin $allwhere";
}
//echo $query;
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$numrows = mysql_num_rows( $result );

if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$result2 = mysql_query($query2) or die ("$text[cannotexecutequery]: $query2");
	$countrow = mysql_fetch_assoc($result2);
	$totrows = $countrow[pcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

if ( !$numrows ) {
	$msg = "$text[noresults] $querystring. $text[tryagain].";
	header( "Location: " . "$searchform_url" . "msg=" . urlencode( $msg ) );
	exit;
}

tng_header( $text[searchresults], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_search2.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text['searchresults']; ?></p><br clear="left"/>
<?php
$logstring = "<a href=\"$search_url" . $_SERVER['QUERY_STRING'] . "\">" . xmlcharacters("$text[searchresults] $querystring") . "</a>";
writelog($logstring);
preparebookmark($logstring);

echo tng_coreicons();

$numrowsplus = $numrows + $offset;

echo "<p class=\"normal\">$text[matches] $offsetplus $text[to] $numrowsplus $text[of] $totrows $querystring</p>";

$pagenav = get_browseitems_nav( $totrows, "$search_url" . "$urlstring&amp;mybool=$mybool&amp;nr=$maxsearchresults&amp;showspouse=$showspouse&amp;showdeath=$showdeath&amp;offset", $maxsearchresults, $max_browsesearch_pages );
echo "<p class=\"normal\">$pagenav</p>";
?>

<table cellpadding="3" cellspacing="1" border="0">
	<tr>
		<td class="fieldnameback"><span class="fieldname">&nbsp;</span></td>
		<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $namesort; ?></b>&nbsp;</nobr></td>
		<?php if( $myprefix ) { ?><td class="fieldnameback fieldname">&nbsp;<b><?php echo $text[prefix]; ?></b>&nbsp;</td><?php } ?>
		<?php if( $mysuffix ) { ?><td class="fieldnameback fieldname">&nbsp;<b><?php echo $text[suffix]; ?></b>&nbsp;</td><?php } ?>
		<?php if( $mytitle ) { ?><td class="fieldnameback fieldname">&nbsp;<b><?php echo $text[title]; ?></b>&nbsp;</td><?php } ?>
		<?php if( $mynickname ) { ?><td class="fieldnameback fieldname">&nbsp;<b><?php echo $text[nickname]; ?></b>&nbsp;</td><?php } ?>
		<td colspan="2" class="fieldnameback fieldname">&nbsp;<b><?php echo $birthsort; ?></b>&nbsp;</td>
		<?php if( $mydeathyear || $mydeathplace || $myburialyear || $myburialplace || $showdeath ) { ?><td colspan="2" class="fieldnameback fieldname">&nbsp;<b><?php echo $deathsort; ?></b>&nbsp;</td><?php } ?>
		<?php if( $showspouse) { ?><td class="fieldnameback fieldname">&nbsp;<b><?php echo $text[spouse]; ?></b>&nbsp;</td><?php } ?>
		<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $text[personid]; ?></b>&nbsp;</nobr></td>
		<td class="fieldnameback fieldname">&nbsp;<b><?php echo $text[tree]; ?></b>&nbsp;</td>
	</tr>
	
<?php
$i = $offsetplus;
$chartlinkimg = @GetImageSize($cms[tngpath] . "Chart.gif");
$chartlink = "<img src=\"$cms[tngpath]" . "Chart.gif\" border=\"0\" $chartlinkimg[3]>";
while( $row = mysql_fetch_assoc($result))
{
	if( !$row[living] || $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $row[gedcom]) && checkbranch( $row[branch] ) ) ) {
		if ( $row[birthdate] || ( $row[birthplace] && !$row[altbirthdate] ) ) {
			$birthdate = "$text[birthabbr] " . displayDate( $row[birthdate] );
			$birthplace = $row[birthplace] ? "$row[birthplace] <a href=\"$placesearch_url" . "psearch=" . urlencode($row[birthplace]) . "\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\"></a>" : "";
		}
		else if ( $row[altbirthdate] || $row[altbirthplace] ) {
			$birthdate = "$text[chrabbr] " . displayDate( $row[altbirthdate] );
			$birthplace = $row[altbirthplace] ? "$row[altbirthplace] <a href=\"$placesearch_url" . "psearch=" . urlencode($row[altbirthplace]) . "\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\"></a>" : "";
		}
		else {
			$birthdate = "";
			$birthplace = "";
		}
		if ( $row[deathdate] || ( $row[deathplace] && !$row[burialdate] ) ) {
			$deathdate = "$text[deathabbr] " . displayDate( $row[deathdate] );
			$deathplace = $row[deathplace] ? "$row[deathplace] <a href=\"$placesearch_url" . "psearch=" . urlencode($row[deathplace]) . "\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\"></a>" : "";
		}
		else if ( $row[burialdate] || $row[burialplace] ) {
			$deathdate = "$text[burialabbr] " . displayDate( $row[burialdate] );
			$deathplace = $row[burialplace] ? "$row[burialplace] <a href=\"$placesearch_url" . "psearch=" . urlencode($row[burialplace]) . "\" title=\"$text[findplaces]\"><img src=\"$cms[tngpath]" . "tng_search_small.gif\" border=\"0\" alt=\"$text[findplaces]\" width=\"9\" height=\"9\"></a>" : "";
		}
		else {
			$deathdate = "";
			$deathplace = "";
		}
		$prefix = $row[prefix];
		$suffix = $row[suffix];
		$title = $row[title];
		$nickname = $row[nickname];
		$livingOK = 1;
	}
	else
		$prefix = $suffix = $title = $nickname = $birthdate = $birthplace = $deathdate = $deathplace = $livingOK = "";
	echo "<tr>";
	$row[allow_living] = $livingOK;
	$name = getNameRev( $row );
	echo "<td class=\"databack\"><span class=\"normal\">$i</span></td>\n";
	$i++;
	echo "<td class=\"databack\"><span class=\"normal\"><a href=\"$pedigree_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$chartlink</a> <a href=\"$getperson_url" . "personID=$row[personID]&amp;tree=$row[gedcom]\">$name</a>&nbsp;</span></td>";
	if( $myprefix ) echo "<td class=\"databack\"><span class=\"normal\">$prefix &nbsp;</span></td>";
	if( $mysuffix ) echo "<td class=\"databack\"><span class=\"normal\">$suffix &nbsp;</span></td>";
	if( $mytitle ) echo "<td class=\"databack\"><span class=\"normal\">$title &nbsp;</span></td>";
	if( $mynickname ) echo "<td class=\"databack\"><span class=\"normal\">$nickname &nbsp;</span></td>";
	echo "<td class=\"databack\"><span class=\"normal\">&nbsp;$birthdate </span></td><td class=\"databack\"><span class=\"normal\">$birthplace &nbsp;</span></td>";
	if( $mydeathyear || $mydeathplace || $myburialyear || $myburialplace || $showdeath ) echo "<td class=\"databack\"><span class=\"normal\">$deathdate &nbsp;</span></td><td class=\"databack\"><span class=\"normal\">$deathplace &nbsp;</span></td>";
	
	if( $showspouse ) {
   		$spouse = "";
		if( $showspouse == "yess" )
			$spouseID = $row[spersonID];
		else
			$spouseID = $row[husband] ? $row[husband] : $row[wife];
		if( $spouseID ) {
			$query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, living, branch FROM $people_table WHERE personID = \"$spouseID\" AND gedcom = \"$row[gedcom]\"";
			$spresult = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
			if( $spresult ) {
				$sprow = mysql_fetch_assoc($spresult);
				$sprow[allow_living] = !$sprow[living] || $livedefault == 2 || ( $allow_living_db && (!$assignedtree || $assignedtree == $row[gedcom]) && checkbranch( $row[branch] ) ) ? 1 : 0;
				$spouse = getName( $sprow );
				mysql_free_result($spresult);
			}
		}
		echo "<td class=\"databack\"><span class=\"normal\"><a href=\"$getperson_url" . "personID=$spouseID&amp;tree=$row[gedcom]\">$spouse</a>&nbsp;</span></td>";
	}
	echo "<td class=\"databack\"><span class=\"normal\">$row[personID] </span></td>";
	echo "<td class=\"databack\"><span class=\"normal\"><a href=\"$showtree_url" . "tree=$row[gedcom]\">$row[treename]</a>&nbsp;</span></td>";
	echo "</tr>\n";
}
mysql_free_result($result);

?>

</table>

<?php
echo "<p>$pagenav</p><br />";
tng_footer( "" );
?>