<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "families";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

if($session_charset != "UTF-8") {
	$myhusbname = utf8_decode($myhusbname);
	$mywifename = utf8_decode($mywifename);
}

$allwhere = "$families_table.gedcom = \"$tree\"";
$joinon = "";
if( $assignedbranch )
	$allwhere .= " AND $families_table.branch LIKE \"%$assignedbranch%\"";
	
$allwhere2 = "";
	
if( $mywifename ) {
	$terms = explode( ' ',  $mywifename );
	foreach( $terms as $term ) {
		if( $allwhere2 ) $allwhere2 .= " AND ";
		$allwhere2 .= "CONCAT_WS(' ',wifepeople.firstname,TRIM(CONCAT_WS(' ',wifepeople.lnprefix,wifepeople.lastname))) LIKE \"%$term%\"";
	}
}

if( $myhusbname ) {
	$terms = explode( ' ',  $myhusbname );
	foreach( $terms as $term ) {
		if( $allwhere2 ) $allwhere2 .= " AND ";
		$allwhere2 .= "CONCAT_WS(' ',husbpeople.firstname,TRIM(CONCAT_WS(' ',husbpeople.lnprefix,husbpeople.lastname))) LIKE \"%$term%\"";
	}
}
else
	$joinonhusb = "";
	
if( $allwhere2 )
	$allwhere2 = "AND $allwhere2";

$joinonwife = "LEFT JOIN $people_table AS wifepeople ON $families_table.wife = wifepeople.personID AND $families_table.gedcom = wifepeople.gedcom";
$joinonhusb = "LEFT JOIN $people_table AS husbpeople ON $families_table.husband = husbpeople.personID AND $families_table.gedcom = husbpeople.gedcom";
$query = "SELECT familyID, wifepeople.personID as wpersonID, wifepeople.firstname as wfirstname, wifepeople.lnprefix as wlnprefix, wifepeople.lastname as wlastname, wifepeople.suffix as wsuffix, wifepeople.nameorder as wnameorder, husbpeople.personID as hpersonID, husbpeople.firstname as hfirstname, husbpeople.lnprefix as hlnprefix, husbpeople.lastname as hlastname, husbpeople.suffix as hsuffix, husbpeople.nameorder as hnameorder FROM $families_table $joinonwife $joinonhusb WHERE $allwhere $allwhere2 ORDER BY hlastname, hlnprefix, hfirstname LIMIT 250";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

tng_adminheader( $admtext[searchresults], "" );
?>
<SCRIPT language="JavaScript" type="text/javascript">
function returnName(familyID) {
	var returnform = opener.document.form1;
	
<?php 
	echo $formname ? "var returnform = opener.document.$formname;" : "var returnform = opener.document.form1;\n";
	echo "returnform.$field.value=familyID;"; 
?>
	window.close();
	
	return false;
}
</script>
</head>

<body class="databack" style="border-right: 0px; border-bottom: 0px;">
<table border="0" cellpadding="0">
<tr>
	<td valign="top">
		<span class="subhead"><strong><?php echo $admtext[searchresults]; ?></strong></span><br/>
		<span class="normal">(<?php echo $admtext[clicktoselect]; ?>)</span><br/>
	</td>
	<td>&nbsp;&nbsp;&nbsp;</td>
	<td>
		<form action=""><input type="button" value="<?php echo $admtext[find]; ?>" onClick="window.location.href='findfamilyform.php?tree=<?php echo "$tree&amp;field=$field&amp;formname=$formname"; ?>';"></form>
	</td>
</tr>
</table><br/>
<table border="0" cellspacing="0" cellpadding="2">
<?php
while( $row = mysql_fetch_assoc($result)) {
	$thisfamily = "";
	if( $row[hpersonID] ) {
		$person[firstname] = $row[hfirstname];
		$person[lnprefix] = $row[hlnprefix];
		$person[lastname] = $row[hlastname];
		$person[suffix] = $row[hsuffix];
		$person[nameorder] = $row[hnameorder];
		$thisfamily .= getName( $person );
	}
	if( $row[wpersonID] ) {	
		if( $thisfamily ) $thisfamily .= "<br/>";
		$person[firstname] = $row[wfirstname];
		$person[lnprefix] = $row[wlnprefix];
		$person[lastname] = $row[wlastname];
		$person[suffix] = $row[wsuffix];
		$person[nameorder] = $row[wnameorder];
		$thisfamily .= getName( $person );
	}
	echo "<tr><td valign=\"top\"><span class=\"normal\"><a href=\"findfamily2.php\" onClick=\"return returnName('$row[familyID]');\">$row[familyID]</a></span></td><td><span class=\"normal\"><a href=\"findfamily.php\" onClick=\"return returnName('$row[familyID]');\">$thisfamily</a></span></td></tr>\n";
}
mysql_free_result($result);
?>
</table>
</body>
</html>
