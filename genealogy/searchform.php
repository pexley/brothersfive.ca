<?php
include("begin.php");
if($cms['events']){include('cmsevents.php'); cms_search();}
include($cms['tngpath'] . "genlib.php");
$textpart = "search";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");

$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$numtrees = mysql_num_rows($result);

if( $_SESSION[tng_search_tree] ) $tree = $_SESSION[tng_search_tree];
$lnqualify = $_SESSION[tng_search_lnqualify];
$mylastname = $_SESSION[tng_search_lastname];
$fnqualify = $_SESSION[tng_search_fnqualify];
$myfirstname = $_SESSION[tng_search_firstname];
$idqualify = $_SESSION[tng_search_idqualify];
$mypersonid = $_SESSION[tng_search_personid];
$bpqualify = $_SESSION[tng_search_bpqualify];
$mybirthplace = $_SESSION[tng_search_birthplace];
$byqualify = $_SESSION[tng_search_byqualify];
$mybirthyear = $_SESSION[tng_search_birthyear];
$cpqualify = $_SESSION[tng_search_cpqualify];
$myaltbirthplace = $_SESSION[tng_search_altbirthplace];
$cyqualify = $_SESSION[tng_search_cyqualify];
$myaltbirthyear = $_SESSION[tng_search_altbirthyear];
$dpqualify = $_SESSION[tng_search_dpqualify];
$mydeathplace = $_SESSION[tng_search_deathplace];
$dyqualify = $_SESSION[tng_search_dyqualify];
$mydeathyear = $_SESSION[tng_search_deathyear];
$brpqualify = $_SESSION[tng_search_brpqualify];
$myburialplace = $_SESSION[tng_search_burialplace];
$bryqualify = $_SESSION[tng_search_bryqualify];
$myburialyear = $_SESSION[tng_search_burialyear];
$mybool = $_SESSION[tng_search_bool];
$showdeath = $_SESSION[tng_search_showdeath];
$showspouse = $_SESSION[tng_search_showspouse];
$mygender = $_SESSION[tng_search_gender];
$mysplname = $_SESSION[tng_search_mysplname];
$spqualify = $_SESSION[tng_search_spqualify];
$nr = $_SESSION[tng_nr];

$dontdo = array("ADDR","BIRT","CHR","DEAT","BURI","NAME","NICK","TITL","NSFX","NPFX");
$search_url = getURL( "search", 1 );

tng_header( $text[searchnames], $flags );
?>
<script type="text/javascript">
function resetValues() {
<?php if( (!$requirelogin || !$treerestrict || !$assignedtree) && $numtrees > 1 ) echo "	document.search.tree.selectedIndex = 0;"; ?>
	document.search.lnqualify.selectedIndex = 0;
	document.search.fnqualify.selectedIndex = 0;
	document.search.nnqualify.selectedIndex = 0;
	document.search.tqualify.selectedIndex = 0;
	document.search.sfqualify.selectedIndex = 0;
	document.search.bpqualify.selectedIndex = 0;
	document.search.byqualify.selectedIndex = 0;
	document.search.cpqualify.selectedIndex = 0;
	document.search.cyqualify.selectedIndex = 0;
	document.search.dpqualify.selectedIndex = 0;
	document.search.dyqualify.selectedIndex = 0;
	document.search.brpqualify.selectedIndex = 0;
	document.search.bryqualify.selectedIndex = 0;
	document.search.spqualify.selectedIndex = 0;
	document.search.mybool.selectedIndex = 0;
	document.search.idqualify.selectedIndex = 0;

	document.search.mylastname.value = "";
	document.search.myfirstname.value = "";
	document.search.mynickname.value = "";
	document.search.myprefix.value = "";
	document.search.mysuffix.value = "";
	document.search.mytitle.value = "";
	document.search.mybirthplace.value = "";
	document.search.mybirthyear.value = "";
	document.search.myaltbirthplace.value = "";
	document.search.myaltbirthyear.value = "";
	document.search.mydeathplace.value = "";
	document.search.mydeathyear.value = "";
	document.search.myburialplace.value = "";
	document.search.myburialyear.value = "";
	document.search.mygender.selectedIndex = 0;
	document.search.mysplname.value = "";
	document.search.mypersonid.value = "";

	document.search.showdeath.checked = false;
	document.search.showspouse.checked = false;
}

function toggleSection( flag ) {
	if( flag ) {
		new Effect.Appear('otherevents',{duration:.2});
		$('contract').style.display='';
		$('expand').style.display='none';
	}
	else {
		new Effect.Fade('otherevents',{duration:.2});
		$('expand').style.display='';
		$('contract').style.display='none';
	}
	return false;
}

function makeURL() {
	var URL;
	var thisform = document.search;
	var thisfield;
	var found = 0;

	if(thisform.mysplname.value != "" && (thisform.mygender.selectedIndex < 1 || thisform.mygender.selectedIndex > 2)) {
		alert("<?php echo $text[spousemore]; ?>");
		return false;
	}

	if(thisform.mysplname.value != "" && thisform.mybool.selectedIndex > 0) {
		alert("<?php echo $text[joinor]; ?>");
		return false;
	}

	URL = "mybool=" + thisform.mybool[thisform.mybool.selectedIndex].value;
	URL = URL + "&nr=" + thisform.nr[thisform.nr.selectedIndex].value;
<?php
	if( (!$requirelogin || !$assignedtree) && $numtrees > 1 ) {
?>
	URL = URL + "&tree=" + thisform.tree[thisform.tree.selectedIndex].value;
<?php
	}
?>

	if( thisform.showdeath.checked )
		URL = URL + "&showdeath=yes";
	if( thisform.showspouse.checked )
		URL = URL + "&showspouse=yes";

<?php
	$qualifiers = array("ln","fn","id","bp","by","cp","cy","dp","dy","brp","bry","nn","t","pf","sf","sp","ge");
	$criteria = array("lastname","firstname","personid","birthplace","birthyear","altbirthplace","altbirthyear","deathplace","deathyear","burialplace","burialyear","nickname","title","prefix","suffix","splname","gender");

	$qcount = 0;
	$found = 0;
	foreach( $criteria as $criterion ) {
?>
		if( thisform.my<?php echo $criterion; ?>.value != "" || thisform.<?php echo $qualifiers[$qcount]; ?>qualify.value == "exists" || thisform.<?php echo $qualifiers[$qcount]; ?>qualify.value == "dnexist" ) {
			URL = URL + "&my<?php echo $criterion; ?>=" + thisform.my<?php echo $criterion; ?>.value;
			URL = URL + "&<?php echo $qualifiers[$qcount]; ?>qualify=" + thisform.<?php echo $qualifiers[$qcount]; ?>qualify[thisform.<?php echo $qualifiers[$qcount]; ?>qualify.selectedIndex].value;
			found++;
		}
<?php
		$qcount++;
	}

	//get eventtypeIDs from $eventtypes_table
	$query = "SELECT eventtypeID, tag FROM $eventtypes_table WHERE keep=\"1\" AND type=\"I\"";
	$etresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $row = mysql_fetch_assoc( $etresult ) ) {
		if( !in_array( $row[tag], $dontdo ) ) {
?>
		if( thisform.cef<?php echo $row[eventtypeID]; ?>.value != "" || thisform.cfq<?php echo $row[eventtypeID]; ?>.value == "exists" || thisform.cfq<?php echo $row[eventtypeID]; ?>.value == "dnexist" ) {
			URL = URL + "&cef<?php echo $row[eventtypeID]; ?>=" + thisform.cef<?php echo $row[eventtypeID]; ?>.value;
			URL = URL + "&cfq<?php echo $row[eventtypeID]; ?>=" + thisform.cfq<?php echo $row[eventtypeID]; ?>[thisform.cfq<?php echo $row[eventtypeID]; ?>.selectedIndex].value;
		}
		if( thisform.cep<?php echo $row[eventtypeID]; ?>.value != "" || thisform.cpq<?php echo $row[eventtypeID]; ?>.value == "exists" || thisform.cpq<?php echo $row[eventtypeID]; ?>.value == "dnexist" ) {
			URL = URL + "&cep<?php echo $row[eventtypeID]; ?>=" + thisform.cep<?php echo $row[eventtypeID]; ?>.value;
			URL = URL + "&cpq<?php echo $row[eventtypeID]; ?>=" + thisform.cpq<?php echo $row[eventtypeID]; ?>[thisform.cpq<?php echo $row[eventtypeID]; ?>.selectedIndex].value;
		}
		if( thisform.cey<?php echo $row[eventtypeID]; ?>.value != "" || thisform.cyq<?php echo $row[eventtypeID]; ?>.value == "exists" || thisform.cyq<?php echo $row[eventtypeID]; ?>.value == "dnexist" ) {
			URL = URL + "&cey<?php echo $row[eventtypeID]; ?>=" + thisform.cey<?php echo $row[eventtypeID]; ?>.value;
			URL = URL + "&cyq<?php echo $row[eventtypeID]; ?>=" + thisform.cyq<?php echo $row[eventtypeID]; ?>[thisform.cyq<?php echo $row[eventtypeID]; ?>.selectedIndex].value;
		}
<?php
		}
	}
	mysql_free_result($etresult);
?>
	window.location.href = "<?php echo $search_url; ?>" + URL;
	
	return false;
}
</script>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_search2.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text[searchnames];?><br clear="all" /></p>
<?php
echo tng_coreicons();

if($msg)
	echo "<b>" . stripslashes(urldecode($msg)) . "</b>";

$formstr = getFORM( "search", "", "search\" onsubmit=\"return makeURL();", "" );
echo $formstr;
?>
<table>
<?php
if( (!$requirelogin || !$treerestrict || !$assignedtree) && $numtrees > 1 ) {
?>
<tr>
	<td><span class="normal"><?php echo $text[tree];?>:</span></td>
	<td colspan="2">
		<?php echo treeSelect($result); ?>
	</td>
</tr>
<?php
}
?>
<tr>
	<td><span class="normal"><?php echo $text[lastname];?>:</span></td>
	<td>
		<select name="lnqualify" style="width: 180px;">
<?php
	$item_array = array( array( $text[contains], "contains" ), array( $text[equals], "equals" ), array( $text[startswith], "startswith" ), array( $text[endswith], "endswith" ), array( $text[exists], "exists" ), array( $text[dnexist], "dnexist" ), array( $text[soundexof], "soundexof" ), array( $text[metaphoneof], "metaphoneof" ) );
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $lnqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="mylastname" value="<?php echo $mylastname; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[firstname];?>:</span></td>
	<td>
		<select name="fnqualify" style="width: 180px;">
<?php
	$item_array = array( array( $text[contains], "contains" ), array( $text[equals], "equals" ), array( $text[startswith], "startswith" ), array( $text[endswith], "endswith" ), array( $text[exists], "exists" ), array( $text[dnexist], "dnexist" ), array( $text[soundexof], "soundexof" ) );
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $fnqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="myfirstname" value="<?php echo $myfirstname; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[personid];?>:</span></td>
	<td>
		<select name="idqualify" style="width: 180px;">
<?php
	$item_array = array( array( $text[equals], "equals" ), array( $text[contains], "contains" ), array( $text[startswith], "startswith" ), array( $text[endswith], "endswith" ) );
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $idqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="mypersonid" value="<?php echo $mypersonid; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[birthplace];?>:</span></td>
	<td>
		<select name="bpqualify" style="width: 180px;">
<?php
	$item_array = array( array( $text[contains], "contains" ), array( $text[equals], "equals" ), array( $text[startswith], "startswith" ), array( $text[endswith], "endswith" ), array( $text[exists], "exists" ), array( $text[dnexist], "dnexist" ) );
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $bpqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="mybirthplace" value="<?php echo $mybirthplace; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[birthdatetr];?>:</span></td>
	<td>
		<select name="byqualify" style="width: 180px;">
<?php
	$item2_array = array( array( $text[equals], "" ), array( $text[plusminus2], "pm2" ), array( $text[plusminus5], "pm5" ), array( $text[plusminus10], "pm10" ), array( $text[lessthan], "lt" ), array( $text[greaterthan], "gt" ), array( $text[lessthanequal], "lte" ), array( $text[greaterthanequal], "gte" ), array( $text[exists], "exists" ), array( $text[dnexist], "dnexist" ) );
	foreach( $item2_array as $item ) {
		echo "<option value=\"$item[1]\"";
		if( $byqualify == $item[1] ) echo " selected=\"selected\"";
		echo ">$item[0]</option>\n";
	}
?>
		</select> 
	</td>
	<td><input type="text" name="mybirthyear" value="<?php echo $mybirthyear; ?>" /></td>
</tr>
<tr<?php if($tngconfig['hidechr']) echo " style=\"display:none\""; ?>>
	<td><span class="normal"><?php echo $text[altbirthplace];?>:</span></td>
	<td>
		<select name="cpqualify" style="width: 180px;">
<?php
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $cpqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="myaltbirthplace" value="<?php echo $myaltbirthplace; ?>" /></td>
</tr>
<tr<?php if($tngconfig['hidechr']) echo " style=\"display:none\""; ?>>
	<td><span class="normal"><?php echo $text[altbirthdatetr];?>:</span></td>
	<td>
		<select name="cyqualify" style="width: 180px;">
<?php
	$item2_array = array( array( $text[equals], "" ), array( $text[plusminus2], "pm2" ), array( $text[plusminus5], "pm5" ), array( $text[plusminus10], "pm10" ), array( $text[lessthan], "lt" ), array( $text[greaterthan], "gt" ), array( $text[lessthanequal], "lte" ), array( $text[greaterthanequal], "gte" ), array( $text[exists], "exists" ), array( $text[dnexist], "dnexist" ) );
	foreach( $item2_array as $item ) {
		echo "<option value=\"$item[1]\"";
		if( $cyqualify == $item[1] ) echo " selected=\"selected\"";
		echo ">$item[0]</option>\n";
	}
?>
		</select> 
	</td>
	<td><input type="text" name="myaltbirthyear" value="<?php echo $myaltbirthyear; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[deathplace];?>:</span></td>
	<td>
		<select name="dpqualify" style="width: 180px;">
<?php
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $dpqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="mydeathplace" value="<?php echo $mydeathplace; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[deathdatetr];?>:</span></td>
	<td>
		<select name="dyqualify" style="width: 180px;">
<?php
	$item2_array = array( array( $text[equals], "" ), array( $text[plusminus2], "pm2" ), array( $text[plusminus5], "pm5" ), array( $text[plusminus10], "pm10" ), array( $text[lessthan], "lt" ), array( $text[greaterthan], "gt" ), array( $text[lessthanequal], "lte" ), array( $text[greaterthanequal], "gte" ), array( $text[exists], "exists" ), array( $text[dnexist], "dnexist" ) );
	foreach( $item2_array as $item ) {
		echo "<option value=\"$item[1]\"";
		if( $dyqualify == $item[1] ) echo " selected=\"selected\"";
		echo ">$item[0]</option>\n";
	}
?>
		</select> 
	</td>
	<td><input type="text" name="mydeathyear" value="<?php echo $mydeathyear; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text['burialplace'];?>:</span></td>
	<td>
		<select name="brpqualify" style="width: 180px;">
<?php
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $brpqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="myburialplace" value="<?php echo $myburialplace; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text['burialdatetr'];?>:</span></td>
	<td>
		<select name="bryqualify" style="width: 180px;">
<?php
	$item2_array = array( array( $text['equals'], "" ), array( $text['plusminus2'], "pm2" ), array( $text['plusminus5'], "pm5" ), array( $text['plusminus10'], "pm10" ), array( $text['lessthan'], "lt" ), array( $text['greaterthan'], "gt" ), array( $text['lessthanequal'], "lte" ), array( $text['greaterthanequal'], "gte" ), array( $text['exists'], "exists" ), array( $text['dnexist'], "dnexist" ) );
	foreach( $item2_array as $item ) {
		echo "<option value=\"$item[1]\"";
		if( $bryqualify == $item[1] ) echo " selected=\"selected\"";
		echo ">$item[0]</option>\n";
	}
?>
		</select> 
	</td>
	<td><input type="text" name="myburialyear" value="<?php echo $myburialyear; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text['gender'];?>:</span></td>
	<td>
		<select name="gequalify" style="width: 180px;">
			<option value="equals"><?php echo $text['equals']; ?></option>
		</select>
	</td>
	<td>
		<select name="mygender">
			<option value="">&nbsp;</option>
			<option value="M"<?php if($mygender == "M") echo " selected=\"selected\""; ?>><?php echo $text['male']; ?></option>
			<option value="F"<?php if($mygender == "F") echo " selected=\"selected\""; ?>><?php echo $text['female']; ?></option>
			<option value="U"<?php if($mygender == "U") echo " selected=\"selected\""; ?>><?php echo $text['unknown']; ?></option>
			<option value="N"<?php if($mygender == "N") echo " selected=\"selected\""; ?>><?php echo $text['none']; ?></option>
		</select>
	</td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[spousesurname];?>*:</span></td>
	<td>
		<select name="spqualify" style="width: 180px;">
<?php
	$item_array = array( array( $text[contains], "contains" ), array( $text[equals], "equals" ), array( $text[startswith], "startswith" ), array( $text[endswith], "endswith" ), array( $text[exists], "exists" ), array( $text[dnexist], "dnexist" ), array( $text[soundexof], "soundexof" ), array( $text[metaphoneof], "metaphoneof" ) );
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $spqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="mysplname" value="<?php echo $mysplname; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text['joinwith'];?>:</span></td>
	<td>
		<select name="mybool">
<?php
	$item3_array = array( array( $text['cap_and'], "AND" ), array( $text['cap_or'], "OR" ) );
	foreach( $item3_array as $item ) {
		echo "<option value=\"$item[1]\"";
		if( $mybool == $item[1] ) echo " selected=\"selected\"";
		echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text['numresults'];?>:</span></td>
	<td>
		<select name="nr">
<?php
	$item3_array = array( array(50,50), array(100,100), array(150,150), array(200,200) );
	foreach( $item3_array as $item ) {
		echo "<option value=\"$item[1]\"";
		if( $nr == $item[1] ) echo " selected=\"selected\"";
		echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td></td>
</tr>
</table>
<p class="smaller"><em>*<?php echo $text['spousemore']; ?></em></p>
<hr align="left" width="400" size="1">
<span class="subhead"><strong><?php echo $text['otherevents']; ?></strong></span><br/>
<ul style="list-style-type: none;" class="normal">
	<li id="expand" style="margin:0 0 0 -15px"><a href="#" onclick="return toggleSection(1);" style="text-decoration:none"><img src="<?php echo $cms[tngpath]; ?>tng_expand.gif" alt="" width="15" height="15" border="0" style="padding-right:5px;vertical-align:middle"><?php echo $text[clickdisplay]; ?></a></li>
	<li id="contract" style="display:none; margin:0 0 0 -15px;"><a href="#" onclick="return toggleSection(0);" style="text-decoration:none"><img src="<?php echo $cms[tngpath]; ?>tng_collapse.gif" alt="" width="15" height="15" border="0" style="padding-right:5px;vertical-align:middle"><?php echo $text[clickhide]; ?></a></li>
</ul>
<table style="display:none" id="otherevents">
<tr><td colspan="3">&nbsp;</td></tr>
<tr>
	<td><span class="normal"><?php echo $text[nickname];?>:</span></td>
	<td>
		<select name="nnqualify" style="width: 180px;">
<?php
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $nnqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="mynickname" value="<?php echo $mynickname; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[title];?>:</span></td>
	<td>
		<select name="tqualify" style="width: 180px;">
<?php
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $tqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="mytitle" value="<?php echo $mytitle; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[prefix];?>:</span></td>
	<td>
		<select name="pfqualify" style="width: 180px;">
<?php
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $pfqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="myprefix" value="<?php echo $myprefix; ?>" /></td>
</tr>
<tr>
	<td><span class="normal"><?php echo $text[suffix];?>:</span></td>
	<td>
		<select name="sfqualify" style="width: 180px;">
<?php
	foreach( $item_array as $item ) {
	    echo "<option value=\"$item[1]\"";
	    if( $sfqualify == $item[1] ) echo " selected=\"selected\"";
	    echo ">$item[0]</option>\n";
	}
?>
		</select>
	</td>
	<td><input type="text" name="mysuffix" value="<?php echo $mysuffix; ?>" /></td>
</tr>
<tr><td colspan="3">&nbsp;</td></tr>
<?php
	$query = "SELECT eventtypeID, tag, display FROM $eventtypes_table WHERE keep=\"1\" AND type=\"I\" ORDER BY display";
	$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $row = mysql_fetch_assoc( $result ) ) {
		if( !in_array( $row[tag], $dontdo ) ) {
			$displaymsg = getEventDisplay( $row[display] );
			echo "<tr><td colspan=\"3\"><span class=\"normal\">$displaymsg</span></td></tr>\n";

			echo "<tr>\n";
			echo "<td><span class=\"normal\">&nbsp;&nbsp;&nbsp;$text[fact]:</span></td>\n";
			echo "<td>\n";
			//eval( "\$cfq = \$cfq$row[eventtypeID] = \$_SESSION[tng_search_cfq$row[eventtypeID]];" );
			echo "<select name=\"cfq$row[eventtypeID]\" style=\"width: 180px;\">\n";
			foreach( $item_array as $item ) {
			    echo "<option value=\"$item[1]\"";
			    //if( $cfq == $item[1] ) echo " SELECTED";
			    echo ">$item[0]</option>\n";
			}
			echo "</select>\n";
			echo "</td>\n";
			//eval( "\$cef = \$cef$row[eventtypeID] = \$_SESSION[tng_search_cef$row[eventtypeID]];" );
			echo "<td><input type=\"text\" name=\"cef$row[eventtypeID]\" value=\"\" /></td>\n";
			echo "</tr>\n";
			
			echo "<tr>\n";
			echo "<td><span class=\"normal\">&nbsp;&nbsp;&nbsp;$text[place]:</span></td>\n";
			echo "<td>\n";
			//eval( "\$cpq = \$cpq$row[eventtypeID] = \$_SESSION[tng_search_cpq$row[eventtypeID]];" );
			echo "<select name=\"cpq$row[eventtypeID]\" style=\"width: 180px;\">\n";
			foreach( $item_array as $item ) {
			    echo "<option value=\"$item[1]\"";
			    //if( $cpq == $item[1] ) echo " SELECTED";
			    echo ">$item[0]</option>\n";
			}
			echo "</select>\n";
			echo "</td>\n";
			//eval( "\$cep = \$cep$row[eventtypeID] = \$_SESSION[tng_search_cep$row[eventtypeID]];" );
			echo "<td><input type=\"text\" name=\"cep$row[eventtypeID]\" value=\"\" /></td>\n";
			echo "</tr>\n";

			echo "<tr>\n";
			echo "<td><span class=\"normal\">&nbsp;&nbsp;&nbsp;$text[year]:</span></td>\n";
			//eval( "\$cyq = \$cyq$row[eventtypeID] = \$_SESSION[tng_search_cyq$row[eventtypeID]];" );
			echo "<td>\n";
			echo "<select name=\"cyq$row[eventtypeID]\" style=\"width: 180px;\">\n";
		
			$item2_array = array( array( $text[equals], "" ), array( $text[plusminus2], "pm2" ), array( $text[plusminus5], "pm5" ), array( $text[plusminus10], "pm10" ), array( $text[lessthan], "lt" ), array( $text[greaterthan], "gt" ), array( $text[lessthanequal], "lte" ), array( $text[greaterthanequal], "gte" ), array( $text[exists], "exists" ), array( $text[dnexist], "dnexist" ) );
			foreach( $item2_array as $item ) {
				echo "<option value=\"$item[1]\"";
				//if( $cyq == $item[1] ) echo " SELECTED";
				echo ">$item[0]</option>\n";
			}
		
			echo "</select>\n";
			echo "</td>\n";
			//eval( "\$cey = \$cey$row[eventtypeID] = \$_SESSION[tng_search_cey$row[eventtypeID]];" );
			echo "<td><input type=\"text\" name=\"cey$row[eventtypeID]\" value=\"\" /></td>\n";
			echo "</tr>\n";
		}
	} 
	mysql_free_result($result);
?>
</table>
<hr align="left" width="400" size="1"><br/>
<span class="normal">
<input type="checkbox" name="showdeath" value="yes"<?php if( $showdeath == "yes" ) echo " checked=\"checked\""; ?> /> <?php echo $text[showdeath];?><br/>
<input type="checkbox" name="showspouse" value="yes"<?php if( $showspouse == "yes" ) echo " checked=\"checked\""; ?> /> <?php echo $text[showspouse];?><br/><br/>
</span>
<input type="hidden" name="offset" value="0" />
<input type="submit" value="<?php echo $text[search];?>"> <input type="button" value="<?php echo $text[resetall];?>" onclick="resetValues();" />
</form>
<br /><br />
<?php
tng_footer( "" );
?>
