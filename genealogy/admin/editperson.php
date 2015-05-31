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

$personID = ucfirst( $personID );
$query = "SELECT *, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") as changedate FROM $people_table WHERE personID = \"$personID\" and gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row['firstname'] = ereg_replace("\"", "&#34;",$row[firstname]);
$row['lastname'] = ereg_replace("\"", "&#34;",$row[lastname]);
$row['nickname'] = ereg_replace("\"", "&#34;",$row[nickname]);
$row['suffix'] = ereg_replace("\"", "&#34;",$row[suffix]);
$row['title'] = ereg_replace("\"", "&#34;",$row[title]);
$row['birthplace'] = ereg_replace("\"", "&#34;",$row[birthplace]);
$row['altbirthplace'] = ereg_replace("\"", "&#34;",$row[altbirthplace]);
$row['deathplace'] = ereg_replace("\"", "&#34;",$row[deathplace]);
$row['burialplace'] = ereg_replace("\"", "&#34;",$row[burialplace]);
$row['baptplace'] = ereg_replace("\"", "&#34;",$row[baptplace]);
$row['endlplace'] = ereg_replace("\"", "&#34;",$row[endlplace]);

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) || !checkbranch( $row[branch] ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

if ( $row['sex'] == "M" ) {
	$spouse = "wife"; $self = "husband"; $spouseorder = "husborder"; $selfdisplay = $admtext['ashusband'];
}
else if ($row['sex'] == "F" ) {
	$spouse = "husband"; $self = "wife"; $spouseorder = "wifeorder"; $selfdisplay = $admtext['aswife'];
}
else {
	$spouse = ""; $self = ""; $spouseorder = ""; $selfdisplay = $admtext['asspouse'];
}

session_register('tng_search_people');
$tng_search_people = $_SESSION[tng_search_people];

$getperson_url = getURL( "getperson", 1 );

$row['allow_living'] = 1;
$namestr = getName($row);

$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc( $result );
mysql_free_result($result);

$query = "SELECT DISTINCT eventID as eventID FROM $notelinks_table WHERE persfamID=\"$personID\" AND gedcom =\"$tree\"";
$notelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$gotnotes = array();
while( $note = mysql_fetch_assoc( $notelinks ) ) {
	if( !$note[eventID] ) $note[eventID] = "general";
	$gotnotes[$note[eventID]] = "*";
}
mysql_free_result($notelinks);

$citquery = "SELECT DISTINCT eventID FROM $citations_table WHERE persfamID = \"$personID\" AND gedcom = \"$tree\"";
$citresult = mysql_query($citquery) or die ("$text[cannotexecutequery]: $citquery");
$gotcites = array();
while( $cite = mysql_fetch_assoc( $citresult ) ) {
	if( !$cite[eventID] ) $cite[eventID] = "general";
	$gotcites[$cite[eventID]] = "*";
}
mysql_free_result($citresult);

$assocquery = "SELECT count(assocID) as acount FROM $assoc_table WHERE personID = \"$personID\" AND gedcom = \"$tree\"";
$assocresult = mysql_query($assocquery) or die ("$text[cannotexecutequery]: $assocquery");
$assocrow = mysql_fetch_assoc( $assocresult );
$gotassoc = $assocrow['acount'] ? "*" : "";
mysql_free_result($assocresult);

$query = "SELECT parenttag FROM $events_table WHERE persfamID=\"$personID\" AND gedcom =\"$tree\"";
$morelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$gotmore = array();
while( $more = mysql_fetch_assoc( $morelinks ) ) {
	$gotmore[$more[parenttag]] = "*";
}

$helplang = findhelp("people_help.php");

$revstar = checkReview("I");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[modifyperson], $flags );
$photo = showSmallPhoto( $personID, $namestr, 1, 0, true );
include_once("eventlib.php");
?>
<script type="text/javascript">
var persfamID = "<?php echo $personID; ?>";
var allow_cites = true;
var allow_notes = true;

function toggleAll(display) {
	toggleSection('names','plus0',display);
	toggleSection('events','plus1',display);
	toggleSection('parents','plus2',display);
	toggleSection('spouses','plus3',display);
	return false;
}

function startSort() {
	if($$('div#parents div').length > 1)
		Sortable.create('parents',{tag:'div',onUpdate:updateParentsOrder});
	if($$('div#spouses div').length > 1)
		Sortable.create('spouses',{tag:'div',onUpdate:updateSpousesOrder});
}

function updateParentsOrder(id) {
	var parents = Sortable.sequence(id);
	var parentlist = new Array();

	for(var i=0; i<parents.length; i++)
		parentlist[i] = parents[i];

	var params = $H({sequence:parentlist.join(','),action:'parentorder',personID:persfamID,tree:tree}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params});
}

function updateSpousesOrder(id) {
	var spouses = Sortable.sequence(id);
	var spouselist = new Array();

	for(var i=0; i<spouses.length; i++)
		spouselist[i] = spouses[i];

	var params = $H({sequence:spouselist.join(','),action:'spouseorder',tree:tree,spouseorder:'<?php echo $spouseorder; ?>'}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params});
}

function unlinkSpouse(familyID) {
	if(confirm('<?php echo $admtext['confunlink']; ?>')) {
		var params = $H({action:'spouseunlink',familyID:familyID,personID:persfamID,tree:tree}).toQueryString();
		new Ajax.Request('updateorder.php',{parameters:params,
			onSuccess:function(req){
				new Effect.Fade('spouses_'+familyID,{duration:.3,
					afterFinish:function(){
						$('spouses_'+familyID).remove();
						$('marrcount').innerHTML = parseInt($('marrcount').innerHTML) - 1;
					}
				});
			}
		});
	}
	return false;
}

function unlinkChild(familyID) {
	if(confirm('<?php echo $admtext['confunlink']; ?>')) {
		var params = $H({action:'parentunlink',familyID:familyID,personID:persfamID,tree:tree}).toQueryString();
		new Ajax.Request('updateorder.php',{parameters:params,
			onSuccess:function(req){
				new Effect.Fade('parents_'+familyID,{duration:.3,
					afterFinish:function(){
						$('parents_'+familyID).remove();
						$('parentcount').innerHTML = parseInt($('parentcount').innerHTML) - 1;
					}
				});
			}
		});
	}
	return false;
}
</script>
<script language="JavaScript" src="admin.js"></script>
</head>

<body background="../background.gif" onLoad="startSort()">

<?php
	$peopletabs[0] = array(1,"people.php",$admtext['search'],"findperson");
	$peopletabs[1] = array($allow_add,"newperson.php",$admtext['addnew'],"addperson");
	$peopletabs[2] = array($allow_edit,"findreview.php?type=I",$admtext['review'] . $revstar,"review");
	$peopletabs[3] = array($allow_edit && $allow_delete,"merge.php",$admtext['merge'],"merge");
	$peopletabs[4] = array($allow_edit,"editperson.php?personID=$personID&tree=$tree",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/people_help.php#edit', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"$getperson_url" . "personID=$personID&amp;tree=$tree\" target=\"_blank\" class=\"lightlink\">$admtext[test]</a>";
	if( $allow_add && ( !$assignedtree || $assignedtree == $tree ) )
		$innermenu .= " &nbsp;|&nbsp; <a href=\"newmedia.php?personID=$personID&amp;tree=$tree&amp;linktype=I&amp;cw=$cw\" class=\"lightlink\">$admtext[addmedia]</a>";
	$menu = doMenu($peopletabs,"edit",$innermenu);
	echo displayHeadline("$admtext[people] &gt;&gt; $admtext[modifyperson]","people_icon.gif",$menu,$message);
?>

<form action="updateperson.php" method="post" name="form1" style="margin:0px">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table cellpadding="0" cellspacing="0" class="normal">
		<tr>
			<td valign="top"><div id="thumbholder" style="margin-right:5px;<?php if(!$photo) echo "display:none"; ?>"><?php echo $photo; ?></div></td>
			<td>
				<span style="font-size:21px"><?php echo "$namestr ($personID)</span><br/>" . getYears($row); ?>
				<div style="margin-top:12px;margin-bottom:12px" class="smallest">
<?php
				$notesicon = $gotnotes['general'] ? "tng_note_on.gif" : "tng_note.gif";
				$citesicon = $gotcites['general'] ? "tng_cite_on.gif" : "tng_cite.gif";
				$associcon = $gotassoc ? "tng_assoc_on.gif" : "tng_assoc.gif";
				echo "<a href=\"#\" onclick=\"document.form1.submit();\"><img src=\"tng_save.gif\" title=\"$admtext[save]\" alt=\"$admtext[save]\" $dims class=\"smallicon\" style=\"vertical-align:middle;\"/></a> <a href=\"#\" onclick=\"document.form1.submit();\">$admtext[save]</a> &nbsp;&nbsp;\n";
				echo "<a href=\"#\" onclick=\"return showNotes('');\"><img src=\"$notesicon\" title=\"$admtext[notes]\" alt=\"$admtext[notes]\" $dims id=\"notesicon\" class=\"smallicon\" style=\"vertical-align:middle;\"/></a> <a href=\"#\" onclick=\"return showNotes('');\">$admtext[notes]</a> &nbsp;&nbsp;\n";
				echo "<a href=\"#\" onclick=\"return showCitations('');\"><img src=\"$citesicon\" title=\"$admtext[sources]\" alt=\"$admtext[sources]\" $dims id=\"citesicon\" class=\"smallicon\" style=\"vertical-align:middle;\"/></a> <a href=\"#\" onclick=\"return showCitations('');\">$admtext[sources]</a> &nbsp;&nbsp;\n";
	 			echo "<a href=\"#\" onclick=\"return showAssociations('');\"><img src=\"$associcon\" title=\"$admtext[associations]\" alt=\"$admtext[associations]\" $dims id=\"associcon\" class=\"smallicon\" style=\"vertical-align:middle;\"/></a> <a href=\"#\" onclick=\"return showAssociations('');\">$admtext[associations]</a>\n";
?>
				</div>
				<span class="smallest"><?php echo $admtext['lastmodified'] . ": $row[changedate] ($row[changedby])"; ?></span>
			</td>
		</tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus0",1,"names",$admtext['name'],""); ?>

	<div id="names">
	<table class="normal" style="margin-top:8px">
		<tr>
			<td><?php echo $admtext['firstgivennames']; ?></td>
<?php
	if( $lnprefixes )
		echo "<td>$admtext[lnprefix]</td>\n";
?>
			<td><?php echo $admtext['lastsurname']; ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><input type="text" value="<?php echo $row['firstname']; ?>" name="firstname" size="35"></td>
<?php
	if( $lnprefixes )
		echo "<td><input type=\"text\" value=\"$row[lnprefix]\" name=\"lnprefix\" style=\"width:80px\"></td>\n";
?>
			<td><input type="text" value="<?php echo $row['lastname']; ?>" name="lastname" size="35"></td>
			<td>
<?php
				$notesicon = $gotnotes['NAME'] ? "tng_note_on.gif" : "tng_note.gif";
				$citesicon = $gotcites['NAME'] ? "tng_cite_on.gif" : "tng_cite.gif";
				echo "<a href=\"#\" onclick=\"return showNotes('NAME');\"><img src=\"$notesicon\" title=\"$admtext[notes]\" alt=\"$admtext[notes]\" $dims id=\"notesiconNAME\" class=\"smallicon\"/></a>\n";
				echo "<a href=\"#\" onclick=\"return showCitations('NAME');\"><img src=\"$citesicon\" title=\"$admtext[sources]\" alt=\"$admtext[sources]\" $dims id=\"citesiconNAME\" class=\"smallicon\"/></a>\n";
?>
			</td>
		</tr>
	</table>
	<table class="normal" style="margin-top:8px">
		<tr>
			<td><?php echo $admtext['sex']; ?></td>
			<td><?php echo $admtext['nickname']; ?></td>
			<td><?php echo $admtext['title']; ?></td>
			<td><?php echo $admtext['prefix']; ?></td>
			<td><?php echo $admtext['suffix']; ?></td>
			<td><?php echo $admtext['nameorder']; ?></td>
		</tr>
		<tr>
			<td>
				<select name="sex">
					<option value="U" <?php if( $row['sex'] == "U" ) echo "selected"; ?>><?php echo $admtext['unknown']; ?></option>
					<option value="M" <?php if( $row['sex'] == "M" ) echo "selected"; ?>><?php echo $admtext['male']; ?></option>
					<option value="F" <?php if( $row['sex'] == "F" ) echo "selected"; ?>><?php echo $admtext['female']; ?></option>
				</select>
			</td>
			<td><input type="text" value="<?php echo $row['nickname']; ?>" name="nickname" class="veryshortfield"></td>
			<td><input type="text" value="<?php echo $row['title']; ?>" name="title" class="veryshortfield"></td>
			<td><input type="text" value="<?php echo $row['prefix']; ?>" name="prefix" class="veryshortfield"></td>
			<td><input type="text" value="<?php echo $row['suffix']; ?>" name="suffix" class="veryshortfield"></td>
			<td>
				<select name="pnameorder">
					<option value="0"><?php echo $admtext['default']; ?></option>
					<option value="1" <?php if( $row['nameorder'] == "1") echo "selected"; ?>><?php echo $admtext['western']; ?></option>
					<option value="2" <?php if( $row['nameorder'] == "2" ) echo "selected"; ?>><?php echo $admtext['oriental']; ?></option>
				</select>
			</td>
		</tr>
	</table>

	<table class="normal" style="margin-top:12px">
		<tr>
			<td><input type="checkbox" name="living" value="1"<?php if( $row['living'] ) echo " checked"; ?>> <?php echo $admtext['living']; ?></td>
			<td style="padding-left:20px;padding-top:5px"><?php echo $admtext['tree'] . ": " . $treerow['treename']; ?></td>
			<td style="padding-left:20px;padding-top:5px"><?php echo $admtext['branch'] . ": "; ?>

<?php
	$query = "SELECT branch, description FROM $branches_table WHERE gedcom = \"$tree\" ORDER BY description";
	$branchresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$branchlist = explode(",", $row[branch] );

	$descriptions = array();
	$options = "";
	while( $branchrow = mysql_fetch_assoc($branchresult) ) {
		$options .= "	<option value=\"$branchrow[branch]\"";
		if( in_array( $branchrow[branch], $branchlist ) ) {
			$options .= " selected";
			$descriptions[] = $branchrow['description'];
		}
		$options .= ">$branchrow[description]</option>\n";
	}
	$desclist = count($descriptions) ? implode(', ',$descriptions) : $admtext['nobranch'];
	echo "<span id=\"branchlist\">$desclist</span>";
	if( !$assignedbranch ) {
		$totbranches = mysql_num_rows( $branchresult ) + 1;
		if( $totbranches < 2 ) $totbranches = 2;
		$selectnum = $totbranches < 8 ? $totbranches : 8;
		$select = $totbranches >=8 ? "$admtext[scrollbranch]<br/>" : "";
		$select .= "<select name=\"branch[]\" id=\"branch\" multiple size=\"$selectnum\" style=\"overflow:auto\">\n";
		$select .= "	<option value=\"\"";
		if( $row[branch] == "" ) $select .= " selected";
		$select .= ">$admtext[nobranch]</option>\n";

		$select .= "$options</select>\n";
		echo " &nbsp;<span style=\"white-space:nowrap\">(<a href=\"#\" onclick=\"showBranchEdit('branchedit'); quitBranchEdit('branchedit'); return false;\"><img src=\"../ArrowDown.gif\" border=\"0\" style=\"margin-left:-4px;margin-right:-2px\">" . $admtext['edit'] . "</a> )</span><br />";
?>
		<div id="branchedit" class="lightback" style="position:absolute;display:none;padding:5px;" onmouseover="clearTimeout(branchtimer);" onmouseout="closeBranchEdit('branch','branchedit','branchlist');">
<?php
		echo $select;
		echo "</div>\n";
	}
	else
		echo "<input type=\"hidden\" name=\"branch\" value=\"$row[branch]\">";
	echo "<input type=\"hidden\" name=\"orgbranch\" value=\"$row[branch]\">";
?>
			</td>
		</tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<?php echo displayToggle("plus1",1,"events",$admtext['events'],""); ?>

	<div id="events">
	<p class="normal" style="margin-top:8px"><?php echo $admtext['datenote']; ?></p>
	<table class="normal">
		<tr><td>&nbsp;</td><td><?php echo $admtext['date']; ?></td><td><?php echo $admtext['place']; ?></td><td colspan="4">&nbsp;</td></tr>
<?php
	echo showEventRow('birthdate','birthplace','BIRT');
	if(!$tngconfig['hidechr'])
		echo showEventRow('altbirthdate','altbirthplace','CHR');
	echo showEventRow('deathdate','deathplace','DEAT');
	echo showEventRow('burialdate','burialplace','BURI');
	if( $allow_lds ) {
		echo showEventRow('baptdate','baptplace','BAPL');
		echo showEventRow('endldate','endlplace','ENDL');
	}
?>
		<tr><td colspan="7">&nbsp;</td></tr>
		<tr>
			<td valign="top"><?php echo $admtext['otherevents']; ?>:</td>
			<td colspan="6">
<?php
	echo "<input type=\"button\" value=\"  " . $admtext['addnew'] . "  \" onClick=\"newEvent('I','$personID','$tree');\">&nbsp;\n";
?>
	   		</td>
		</tr>
	</table>
<?php
		showCustEvents($personID);
?>
	</div>
</td>
</tr>
<?php
$query = "SELECT personID, familyID, sealdate, sealplace, relationship FROM $children_table WHERE personID = \"$personID\" AND gedcom = \"$tree\" ORDER BY parentorder";
$parents = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$parentcount = mysql_num_rows( $parents );

if( $parentcount ) {
?>
<tr class="databack">
<td class="tngshadow">
<?php echo displayToggle("plus2",0,"parents",$admtext['parents'] . " (<span id=\"parentcount\">$parentcount</span>)",""); ?>

	<div id="parents" style="display:none"><br />
<?php
	while ( $parent = mysql_fetch_assoc( $parents ) )
	{
		$query = "SELECT personID, lastname, lnprefix, firstname, birthdate, birthplace, altbirthdate, altbirthplace, prefix, suffix, nameorder FROM $people_table, $families_table WHERE $people_table.personID = $families_table.husband AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
		$gotfather = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		echo "<div class=\"sortrow\" id=\"parents_$parent[familyID]\" style=\"clear:both\" onmouseover=\"$('unlinkp_$parent[familyID]').style.display='';\" onmouseout=\"$('unlinkp_$parent[familyID]').style.display='none';\">\n";
		echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr>\n";
		if($parentcount > 1) {
			echo "<td class=\"dragarea normal\">";
	   		echo "<img src=\"ArrowUp.gif\" alt=\"\"><br/>" . $admtext['drag'] . "<br/><img src=\"ArrowDown.gif\" alt=\"\">\n";
			echo "</td>\n";
		}
		echo "<td class=\"lightback normal\">\n";
		echo "<div id=\"unlinkp_$parent[familyID]\" style=\"float:right;display:none\"><a href=\"#\" onclick=\"return unlinkChild('$parent[familyID]');\">$admtext[unlinkindividual] ($personID) $admtext[aschild]</a></div>\n";
		echo "<table class=\"normal\"><tr><td valign=\"top\"><strong>$admtext[family]:</strong></td>\n";
		echo "<td valign=\"top\" colspan=\"4\">\n";
		echo "<a href=\"editfamily.php?familyID=$parent[familyID]&amp;tree=$tree&amp;cw=$cw\">$parent[familyID]</a>\n</td></tr>";
	    if( $gotfather ) {
			$fathrow =  mysql_fetch_assoc( $gotfather );
?>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext['father']; ?>:</span></td>
			<td valign="top" colspan="4"><span class="normal"><?php if( $fathrow['personID'] ) { echo "<a href=\"editperson.php?personID=$fathrow[personID]&amp;tree=$tree&amp;cw=$cw\">" . getName( $fathrow ) . " - $fathrow[personID]</a>"; } ?></span></td>
		</tr>
<?php
			mysql_free_result( $gotfather );
		}

		$query = "SELECT personID, lastname, lnprefix, firstname, birthdate, birthplace, altbirthdate, altbirthplace, prefix, suffix, nameorder FROM $people_table, $families_table WHERE $people_table.personID = $families_table.wife AND $families_table.familyID = \"$parent[familyID]\" AND $people_table.gedcom = \"$tree\" AND $families_table.gedcom = \"$tree\"";
		$gotmother = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

		if( $gotmother ) {
			$mothrow =  mysql_fetch_assoc( $gotmother );
?>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext['mother']; ?>:</span></td>
			<td valign="top" colspan="4"><span class="normal"><?php if( $mothrow['personID'] ) { echo "<a href=\"editperson.php?personID=$mothrow[personID]&amp;tree=$tree&amp;cw=$cw\">" . getName( $mothrow ) . " - $mothrow[personID]</a>"; } ?></span></td>
		</tr>
<?php
			mysql_free_result( $gotmother );
		} 
?>
		<tr>
			<td valign="top"><span class="normal"><?php echo $admtext['relationship']; ?>:</span></td>
			<td valign="top" colspan="4">
				<span class="normal">
				<select name="relationship<?php echo $parent[familyID]; ?>">
					<option value=""></option>
			<?php  	
				$reltypes = array("adopted","birth","foster","sealing");
				foreach( $reltypes as $reltype ) {
					echo "<option value=\"$admtext[$reltype]\"";
					if( $parent[relationship] == $admtext[$reltype] ) echo " selected";
					echo ">$admtext[$reltype]</option>\n";
				}
			?>
				</select>
				</span>
			</td>
		</tr>
<?php
		$parent['sealplace'] = ereg_replace("\"", "&#34;",$parent['sealplace']);
		if( $allow_lds ) {
			$citquery = "SELECT citationID FROM $citations_table WHERE persfamID = \"$personID" . "::" . "$parent[familyID]\" AND gedcom = \"$tree\"";
			$citresult = mysql_query($citquery) or die ("$text[cannotexecutequery]: $citquery");
			$citesicon = mysql_num_rows($citresult) ? "tng_cite_on.gif" : "tng_cite.gif";
			mysql_free_result($citresult);

			echo "<tr><td>&nbsp;</td><td>" . $admtext['date'] . "</td><td>" . $admtext['place'] . "</td><td colspan=\"2\">&nbsp;</td></tr>\n";
			echo "<tr>\n";
			echo "<td valign=\"top\" style=\"white-space:nowrap;width:110px\">" . $admtext['SLGC'] . ":</td>\n";
			echo "<td><input type=\"text\" value=\"" . $parent['sealdate'] . "\" name=\"sealpdate" . $parent['familyID'] . "\" onblur=\"checkDate(this);\" maxlength=\"50\" class=\"shortfield\"></td>\n";
			echo "<td><input type=\"text\" value=\"" . $parent['sealplace'] . "\" name=\"sealpplace" . $parent['familyID'] . "\" id=\"sealpplace" . $parent['familyID'] . "\" class=\"longfield\"></td>\n";
			echo "<td><a href=\"#\" onclick=\"return openFindPlaceForm('sealpdate" . $parent['familyID'] . "');\"><img src=\"tng_find.gif\" title=\"$admtext[find]\" alt=\"$admtext[find]\" $dims class=\"smallicon\"/></a></td>\n";
			echo "<td><a href=\"#\" onclick=\"return showCitations('SLGC','$personID::" . $parent['familyID']. "');\"><img src=\"$citesicon\" title=\"$admtext[sources]\" alt=\"$admtext[sources]\" $dims id=\"citesiconSLGC$personID::" . $parent['familyID'] . "\" class=\"smallicon\"/></a></td>\n";
			echo "</tr>\n</table>\n";
		}
		else {
?>
		</table>
		<input type="hidden" name="sealpdate<?php echo $parent['familyID']; ?>" value="<?php echo $parent['sealdate']; ?>">
		<input type="hidden" name="sealpplace<?php echo $parent[familyID]; ?>" value="<?php echo $parent['sealplace']; ?>">
<?php
		}
?>
	</td>
	</table>
	</div>
<?php
	}
	mysql_free_result($parents);
?>
	</div>
</td>
</tr>
<?php
}

if( $row['sex'] ) {
	if( $self )
		 $query = "SELECT $spouse, familyID, marrdate FROM $families_table WHERE $families_table.$self = \"$personID\" AND gedcom = \"$tree\" ORDER BY $spouseorder";
	else
		$query = "SELECT husband, wife, familyID, marrdate FROM $families_table WHERE ($families_table.husband = \"$personID\" OR $families_table.wife = \"$personID\") AND gedcom = \"$tree\"";
	$marriages= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	$marrcount = mysql_num_rows( $marriages );

	if( $marrcount ) {
?>
<tr class="databack">
<td class="tngshadow">
<?php echo displayToggle("plus3",0,"spouses",$admtext['spouses'] . " (<span id=\"marrcount\">$marrcount</span>)",""); ?>

	<div id="spouses" style="display:none"><br />
<?php
	if ( $marriages && mysql_num_rows( $marriages ) ) {
		while ( $marriagerow =  mysql_fetch_assoc( $marriages ) )
		{
			if( !$spouse ) {
				if( $personID == $marriagerow[husband] ) {
					$self = "husband"; $spouse = "wife";
				}
				else if( $personID == $marriagerow[wife] )
					$self = "wife"; $spouse = "husband";
			}
			echo "<div class=\"sortrow\" id=\"spouses_$marriagerow[familyID]\" style=\"clear:both\" onmouseover=\"$('unlinks_$marriagerow[familyID]').style.display='';\" onmouseout=\"$('unlinks_$marriagerow[familyID]').style.display='none';\">\n";
			echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr>\n";
			if($marrcount >1) {
				echo "<td class=\"dragarea normal\">";
		   		echo "<img src=\"ArrowUp.gif\" alt=\"\"><br/>" . $admtext['drag'] . "<br/><img src=\"ArrowDown.gif\" alt=\"\">\n";
				echo "</td>\n";
			}
			echo "<td class=\"lightback normal\">\n";
			echo "<table class=\"normal\" width=\"100%\"><tr><td valign=\"top\"><strong>$admtext[family]:</strong></td>\n";
			echo "<td valign=\"top\" width=\"94%\">\n";
			echo "<div id=\"unlinks_$marriagerow[familyID]\" style=\"float:right;display:none\"><a href=\"#\" onclick=\"return unlinkSpouse('$marriagerow[familyID]');\">$admtext[unlinkindividual] ($personID) $admtext[asspouse]</a></div>\n";
			echo "<a href=\"editfamily.php?familyID=$marriagerow[familyID]&amp;tree=$tree&amp;cw=$cw\">$marriagerow[familyID]</a>\n</td></tr>";
			if( $marriagerow[$spouse] ) {
				$query = "SELECT personID, lastname, lnprefix, firstname, prefix, suffix, nameorder FROM $people_table WHERE personID = \"$marriagerow[$spouse]\" AND gedcom = \"$tree\"";
				$spouseresult= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
				$spouserow =  mysql_fetch_assoc( $spouseresult );
			}
			else {
				$spouserow = "";
			}
?>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['spouse']; ?>:</span></td>
		<td valign="top"><span class="normal"><?php if( $spouserow['personID'] ) {echo "<a href=\"editperson.php?personID=$spouserow[personID]&amp;tree=$tree&amp;cw=$cw\">" . getName( $spouserow ) . " - $spouserow[personID]</a>"; } ?></span></td>
	</tr>
<?php			if( $marriagerow[marrdate] || $marriagerow[marrplace] ) { ?>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['married']; ?>:</span></td>
		<td valign="top"><span class="normal"><?php echo $marriagerow['marrdate']; ?></span></td>
	</tr>
<?php
			}

			$query = "SELECT $people_table.personID as pID, firstname, lnprefix, lastname, haskids, living, branch, prefix, suffix, nameorder FROM ($people_table, $children_table) WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = \"$marriagerow[familyID]\" AND $people_table.gedcom = \"$tree\" AND $children_table.gedcom = \"$tree\" ORDER BY ordernum";
			$children= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

			if( $children && mysql_num_rows( $children ) ) {
?>
	<tr>
		<td valign="top"><span class="normal"><?php echo $admtext['children']; ?>:</span></td>
		<td valign="top"><span class="normal">
<?php
				$kidcount = 1;
				echo "<table cellpadding = \"0\" cellspacing = \"0\">\n";
				while ( $child =  mysql_fetch_assoc( $children ) )
				{
					$ifkids = $child[haskids] ? "&gt" : "&nbsp;";
					$rightbranch = !$assignedbranch || $child[branch] ? 1 : 0;
					$child[allow_living] = !$child[living] || ( $allow_living && $rightbranch ) ? 1 : 0;
					if( $child[firstname] || $child[lastname] ) {
						echo "<tr><td>$ifkids</td><td><span class=\"normal\">$kidcount. ";
						if( $child[allow_living] ) {
							if( $rightbranch )
								echo "<a href=\"editperson.php?personID=$child[pID]&amp;tree=$tree&amp;cw=$cw\">" . getName( $child ) . " - $child[pID]</a>";
							else
								echo getName( $child ) . " - $child[pID]";
						}
						else
							echo "$admtext[living] - $child[pID]";
						echo "</span></td></tr>\n";
					}
					$kidcount++;
				}
				echo "</table>\n";
?>		
		</td>
	</tr>
<?php
				mysql_free_result( $children );
			}
?>
	</table>
	</td>
	</table>
	</div>
<?php
		}
		mysql_free_result($marriages);
	}
?>
	</div>
</td>
</tr>
<?php
	}
}
?>
<tr class="databack">
<td class="tngshadow">
	<p class="normal">
<?php
	echo "$admtext[onsave]:<br/>";
	if( $allow_add && ( !$assignedtree || $assignedtree == $tree ) ) {
		echo "<input type=\"radio\" name=\"newfamily\" value=\"child\">$admtext[gotonewfamily] ($personID) $admtext[aschild]<br/>\n";
		if( $row[sex] )
			echo "<input type=\"radio\" name=\"newfamily\" value=\"$self\">$admtext[gotonewfamily] ($personID) $selfdisplay<br/>\n";
	}
	echo "<input type=\"radio\" name=\"newfamily\" value=\"return\"> $admtext[savereturn]<br/>\n";
	if( $cw )
		echo "<input type=\"radio\" name=\"newfamily\" value=\"close\" checked> $text[closewindow]\n";
	else
		echo "<input type=\"radio\" name=\"newfamily\" value=\"none\" checked> $admtext[saveback]\n";
?>
	</p>
	<input type="hidden" name="tree" value="<?php echo $tree; ?>">
	<input type="hidden" name="personID" value="<?php echo "$personID"; ?>">
	<input type="submit" name="submit2" accesskey="s" value="<?php echo $admtext[save]; ?>">
<?php
	if( !$lnprefixes )
		echo "<input type=\"hidden\" name=\"lnprefix\" value=\"$row[lnprefix]\">";
	if( !$allow_lds ) { ?>
	<input type="hidden" value="<?php echo $row['baptdate']; ?>" name="baptdate">
	<input type="hidden" value="<?php echo $row['baptplace']; ?>" name="baptplace">
	<input type="hidden" value="<?php echo $row['endldate']; ?>" name="endldate">
	<input type="hidden" value="<?php echo $row['endlplace']; ?>" name="endlplace">
<?php } ?>
	<input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
</td>
</tr>

</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
