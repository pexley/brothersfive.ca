<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "people";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

session_register('tng_search_people');
session_register('tng_search_people_post');
$tng_search_people = $_SESSION[tng_search_people] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_people_post[search]", $searchstring, $exptime);
	setcookie("tng_search_people_post[tree]", $tree, $exptime);
	setcookie("tng_search_people_post[living]", $living, $exptime);
	setcookie("tng_search_people_post[exactmatch]", $exactmatch, $exptime);
	setcookie("tng_search_people_post[nokids]", $nokids, $exptime);
	setcookie("tng_search_people_post[noparents]", $noparents, $exptime);
	setcookie("tng_search_people_post[nospouse]", $nospouse, $exptime);
	setcookie("tng_search_people_post[page]", 1, $exptime);
	setcookie("tng_search_people_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_people_post][search];
	if( !$tree )
		$tree = $_COOKIE[tng_search_people_post][tree];
	if( !$living )
		$living = $_COOKIE[tng_search_people_post][living];
	if( !$exactmatch )
		$exactmatch = $_COOKIE[tng_search_people_post][exactmatch];
	if( !$nokids )
		$nokids = $_COOKIE[tng_search_people_post][nokids];
	if( !$noparents )
		$noparents = $_COOKIE[tng_search_people_post][noparents];
	if( !$nospouse )
		$nospouse = $_COOKIE[tng_search_people_post][nospouse];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_people_post][page];
		$offset = $_COOKIE[tng_search_people_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_people_post[page]", $page, $exptime);
		setcookie("tng_search_people_post[offset]", $offset, $exptime);
	}
}
if (get_magic_quotes_gpc() == 0) {
	$searchstring_noquotes = ereg_replace("\"", "&#34;",$searchstring);
	$searchstring = addslashes($searchstring);
}
else
	$searchstring_noquotes = ereg_replace("\"", "&#34;",stripslashes($searchstring));

if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

if( $assignedtree ) {
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
	$tree = $assignedtree;
}
else
	$wherestr = "";
$orgtree = $tree;
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

function addCriteria( $field, $value, $operator ) {
	$criteria = "";

	if( $operator == "=" ) {
		$criteria = " OR $field $operator \"$value\"";
	}
	else {
		$innercriteria = "";
		$terms = explode( ' ',  $value );
		foreach( $terms as $term ) {
			if( $innercriteria ) $innercriteria .= " AND ";
			$innercriteria .= "$field $operator \"%$term%\"";
		}
		if( $innercriteria ) $criteria = " OR ($innercriteria)";
	}

	return $criteria;
}

$getperson_url = getURL( "getperson", 1 );
if( $tree )
	$allwhere = "$people_table.gedcom = \"$tree\" AND $people_table.gedcom = $trees_table.gedcom ";
else
	$allwhere = "$people_table.gedcom = $trees_table.gedcom ";
if( $assignedbranch )
	$allwhere .= " AND $people_table.branch LIKE \"%$assignedbranch%\"";

if( $searchstring ) {
	$allwhere .= " AND (1=0";
	if( $exactmatch == "yes" ) {
		$frontmod = "=";
	}
	else {
		$frontmod = "LIKE";
	}

	$allwhere .= addCriteria( "$people_table.personID", $searchstring, $frontmod );
	$allwhere .= addCriteria( "CONCAT_WS(' ',firstname,lnprefix,' ',lastname)", $searchstring, $frontmod );
	$allwhere .= ")";
}
if( $living == "yes" )
	$allwhere .= " AND $people_table.living = \"1\"";

if( $noparents ) {
	$noparentjoin = "LEFT JOIN $children_table as noparents ON $people_table.personID = noparents.personID AND $people_table.gedcom = noparents.gedcom";
	$allwhere .= " AND noparents.familyID is NULL";
}
else
	$noparentjoin = "";

if( $nospouse ) {
	$nospousejoin = "LEFT JOIN $families_table as nospousef ON $people_table.personID = nospousef.husband AND $people_table.gedcom = nospousef.gedcom ";
	$nospousejoin .= "LEFT JOIN $families_table as nospousem ON $people_table.personID = nospousem.wife AND $people_table.gedcom = nospousem.gedcom";
	$allwhere .= " AND nospousef.familyID is NULL AND nospousem.familyID is NULL";
}
else
	$nospousejoin = "";

if( $nokids ) {
	$nokidjoin = "LEFT OUTER JOIN $families_table AS familiesH ON $people_table.gedcom=familiesH.gedcom AND $people_table.personID=familiesH.husband ";
	$nokidjoin .= "LEFT OUTER JOIN $families_table AS familiesW ON $people_table.gedcom=familiesW.gedcom AND $people_table.personID=familiesW.wife ";
	$nokidjoin .= "LEFT OUTER JOIN $children_table AS childrenH ON familiesH.gedcom=childrenH.gedcom AND familiesH.familyID=childrenH.familyID ";
	$nokidjoin .= "LEFT OUTER JOIN $children_table AS childrenW ON familiesW.gedcom=childrenW.gedcom AND familiesW.familyID=childrenW.familyID ";
	$nokidhaving = "HAVING ChildrenCount = 0 ";
	$nokidgroup = "GROUP BY $people_table.personID, $people_table.lastname, $people_table.firstname, $people_table.firstname, $people_table.lnprefix, ";
	$nokidgroup .= "$people_table.prefix, $people_table.suffix, $people_table.nameorder, $people_table.birthdate, birthyear, $people_table.birthplace, $people_table.altbirthdate, altbirthyear, ";
	$nokidgroup .= "$people_table.altbirthplace, $people_table.gedcom, $trees_table.treename ";
	$nokidselect = ", SUM((childrenH.familyID is not NULL) + (childrenW.familyID is not NULL)) AS ChildrenCount ";
	$nokidgroup2 = "GROUP BY $people_table.personID, $people_table.lastname, $people_table.firstname, $people_table.firstname, $people_table.lnprefix ";
}
else {
	$nokidjoin = "";
	$nokidhaving = "";
	$nokidgroup = "";
	$nokidselect = "";
}

$query = "SELECT $people_table.ID, $people_table.personID, lastname, firstname, lnprefix, prefix, suffix, nameorder, birthdate, LPAD(SUBSTRING_INDEX(birthdate, ' ', -1),4,'0') as birthyear, birthplace, altbirthdate, LPAD(SUBSTRING_INDEX(altbirthdate, ' ', -1),4,'0') as altbirthyear, altbirthplace, $people_table.gedcom as gedcom, treename $nokidselect
	FROM ($people_table, $trees_table) $nokidjoin $noparentjoin $nospousejoin WHERE $allwhere $nokidgroup $nokidhaving ORDER BY lastname, lnprefix, firstname, birthyear, altbirthyear LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	if($nokids) {
		$query = "SELECT $people_table.ID, $people_table.personID, lastname, firstname, lnprefix $nokidselect
			FROM ($people_table, $trees_table) $nokidjoin $noparentjoin $nospousejoin WHERE $allwhere $nokidgroup2 $nokidhaving";
		$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$totrows = mysql_num_rows($result2);
	}
	else {
		$query = "SELECT count($people_table.personID) as pcount FROM ($people_table, $trees_table) $noparentjoin $nospousejoin WHERE $allwhere";
		$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
		$row = mysql_fetch_assoc( $result2 );
		$totrows = $row[pcount];
	}
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("people_help.php");

$revstar = checkReview("I");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[people], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confdeletepers']; ?>' ))
		deleteIt('person',ID);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$peopletabs[0] = array(1,"people.php",$admtext['search'],"findperson");
	$peopletabs[1] = array($allow_add,"newperson.php",$admtext['addnew'],"addperson");
	$peopletabs[2] = array($allow_edit,"findreview.php?type=I",$admtext['review'] . $revstar,"review");
	$peopletabs[3] = array($allow_edit && $allow_delete,"merge.php",$admtext['merge'],"merge");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/people_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($peopletabs,"findperson",$innermenu);
	echo displayHeadline("$admtext[people]","people_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="people.php" style="margin:0px;" name="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext[searchfor]; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring_noquotes; ?>"></td>
			<td>
				<input type="submit" name="submit" value="<?php echo $admtext[search]; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext[reset]; ?>" onClick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0; document.form1.living.checked=false; document.form1.exactmatch.checked=false; document.form1.nokids.checked=false; document.form1.noparents.checked=false;" style="vertical-align:top">
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext[tree]; ?>: </span></td>
			<td>
				<select name="tree">
<?php
	if( !$assignedtree )
		echo "	<option value=\"\">$admtext[alltrees]</option>\n";
	$treeresult = mysql_query($treequery) or die ("$admtext[cannotexecutequery]: $treequery");
	while( $treerow = mysql_fetch_assoc($treeresult) ) {
		echo "	<option value=\"$treerow[gedcom]\"";
		if( $treerow[gedcom] == $tree ) echo " selected";
		echo ">$treerow[treename]</option>\n";
	}
	mysql_free_result($treeresult);
?>
				</select>
			</td>
			<td>
				<span class="normal">
				<input type="checkbox" name="living" value="yes"<?php if( $living == "yes" ) echo " checked"; ?>> <?php echo $admtext['livingonly']; ?>
				<input type="checkbox" name="exactmatch" value="yes"<?php if( $exactmatch == "yes" ) echo " checked"; ?>> <?php echo $admtext['exactmatch']; ?>
				<input type="checkbox" name="nokids" value="yes"<?php if( $nokids == "yes" ) echo " checked"; ?>> <?php echo $admtext['nokids']; ?>
				<input type="checkbox" name="noparents" value="yes"<?php if( $noparents == "yes" ) echo " checked"; ?>> <?php echo $admtext['noparents']; ?>
				<input type="checkbox" name="nospouse" value="yes"<?php if( $nospouse == "yes" ) echo " checked"; ?>> <?php echo $admtext['nospouse']; ?>
				</span>
			</td>
		</tr>
	</table>

	<input type="hidden" name="findperson" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "people.php?searchstring=$searchstring&amp;living=$living&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="deleteselected.php" method="post" name="form2">
<?php
	if( $allow_delete ) {
?>
		<p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
  		<input type="submit" name="xperaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
		</p>
<?php
	}
?>

	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></span></td>
<?php
	if($allow_delete) {
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></span></td>
<?php
	}
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['id']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['name']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['birthdate']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['birthplace']; ?></b>&nbsp;</nobr></span></td>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</nobr></span></td>
		</tr>

<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editperson.php?personID=xxx&amp;tree=yyy\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onclick=\"return confirmDelete('zzz');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
		$actionstr .= "<a href=\"" . $getperson_url . "personID=xxx&amp;tree=yyy\" target=\"_blank\"><img src=\"tng_test.gif\" title=\"$admtext[test]\" alt=\"$admtext[test]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result))
		{
			if ( $row[birthdate] ) {
				$birthdate = "$admtext[birthabbr] $row[birthdate]";
				$birthplace = $row[birthplace];
			}
			else if ( $row[altbirthdate] ) {
				$birthdate = "$admtext[chrabbr] $row[altbirthdate]";
				$birthplace = $row[altbirthplace];
			}
			else {
				$birthdate = "";
				$birthplace = "";
			}
			$newactionstr = ereg_replace( "xxx", $row['personID'], $actionstr );
			$newactionstr = ereg_replace( "yyy", $row['gedcom'], $newactionstr );
			$newactionstr = ereg_replace( "zzz", $row['ID'], $newactionstr );
			echo "<tr id=\"row_$row[ID]\"><td class=\"lightback\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			if($allow_delete)
				echo "<td class=\"lightback\" align=\"center\"><input type=\"checkbox\" name=\"del$row[ID]\" value=\"1\"></td>";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$row[personID]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">" . getName( $row ) . "&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$birthdate&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$birthplace&nbsp;</span></td>\n";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$row[treename]&nbsp;</span></td></tr>\n";
		}
?>
	</table>
<?php
		echo displayListLocation($offsetplus,$numrowsplus,$totrows);
		echo " &nbsp; $pagenav</p>";
	}
	else
		echo "</table>\n$admtext[norecords]";
  	mysql_free_result($result);
?>
	</form>

	<p style="vertical-align:middle">
	<img src="tng_edit.gif" alt="<?php echo $admtext[edit]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[edit]; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext[text_delete]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[text_delete]; ?> &nbsp;&nbsp;
	<img src="tng_test.gif" alt="<?php echo $admtext[test]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[test]; ?>
	</p>

	</div>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
