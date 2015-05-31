<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "families";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

$familyID = ucfirst( $familyID );
$query = "SELECT *, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") as changedate FROM $families_table WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row[marrplace] = ereg_replace("\"", "&#34;",$row[marrplace]);
$row[sealplace] = ereg_replace("\"", "&#34;",$row[sealplace]);
$row[divplace] = ereg_replace("\"", "&#34;",$row[divplace]);
$row[notes] = ereg_replace("\"", "&#34;",$row[notes]);

if( !$allow_edit || ( $assignedtree && $assignedtree != $tree ) || !checkbranch( $row[branch] ) ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

$familygroup_url = getURL( "familygroup", 1 );

$row['allow_living'] = 1;
$namestr = getFamilyName($row);

$query = "SELECT treename FROM $trees_table WHERE gedcom = \"$tree\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$treerow = mysql_fetch_assoc( $result );
mysql_free_result($result);

$query = "SELECT DISTINCT eventID as eventID FROM $notelinks_table WHERE persfamID=\"$familyID\" AND gedcom =\"$tree\"";
$notelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$gotnotes = array();
while( $note = mysql_fetch_assoc( $notelinks ) ) {
	if( !$note[eventID] ) $note[eventID] = "general";
	$gotnotes[$note[eventID]] = "*";
}

$citquery = "SELECT DISTINCT eventID FROM $citations_table WHERE persfamID = \"$familyID\" AND gedcom = \"$tree\"";
$citresult = mysql_query($citquery) or die ("$text[cannotexecutequery]: $citquery");
$gotcites = array();
while( $cite = mysql_fetch_assoc( $citresult ) ) {
	if( !$cite[eventID] ) $cite[eventID] = "general";
	$gotcites[$cite[eventID]] = "*";
}

$query = "SELECT parenttag FROM $events_table WHERE persfamID=\"$familyID\" AND gedcom =\"$tree\"";
$morelinks = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$gotmore = array();
while( $more = mysql_fetch_assoc( $morelinks ) ) {
	$gotmore[$more[parenttag]] = "*";
}

$query = "SELECT $people_table.personID as pID, firstname, lastname, lnprefix, prefix, suffix, nameorder, birthdate, altbirthdate, living, branch FROM $people_table, $children_table WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = \"$familyID\" AND $people_table.gedcom = \"$tree\" AND $children_table.gedcom = \"$tree\" ORDER BY ordernum";
$children= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$kidcount = mysql_num_rows( $children );

$helplang = findhelp("families_help.php");

$revstar = checkReview("F");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader( $admtext['modifyfamily'], $flags );
$photo = showSmallPhoto( $familyID, $namestr, 1, 0, true );
include_once("eventlib.php");
?>
<SCRIPT language="JavaScript" type="text/javascript">
var persfamID = "<?php echo $familyID; ?>";
var childcount = <?php echo $kidcount; ?>;
var allow_cites = true;
var allow_notes = true;

function toggleAll(display) {
	toggleSection('spouses','plus0',display);
	toggleSection('events','plus1',display);
	toggleSection('children','plus2',display);
	return false;
}

function startSort() {
	Sortable.create('childrenlist',{tag:'div',onUpdate:updateChildrenOrder});
}

function updateChildrenOrder(id) {
	var children = Sortable.sequence(id);
	var childlist = new Array();

	for(var i=0; i<children.length; i++)
		childlist[i] = children[i];

	var params = $H({sequence:childlist.join(','),action:'childorder',familyID:persfamID,tree:tree}).toQueryString();
	new Ajax.Request('updateorder.php',{parameters:params});
}

function unlinkChild(personID,action) {
	var confmsg = action == "child_delete" ? "<?php echo $admtext['confdeletepers']; ?>" : "<?php echo $admtext['confremchild']; ?>";
	if(confirm(confmsg)) {
		var params = $H({personID:personID,familyID:persfamID,tree:tree,t:action}).toQueryString();
		new Ajax.Request('deleteajax.php',{parameters:params,
			onSuccess:function(req){
				new Effect.Fade('child_'+personID,{duration:.3,
					afterFinish:function(){
						Element.remove('child_'+personID);
						childcount -= 1;
						$('childcount').innerHTML = childcount;
					}
				});
			}
		});
	}
	return false
}

function EditChild(id) {
	window.open('editperson.php?personID=' + id + '&tree=<?php echo $tree; ?>' + '&cw=1','editchild');
}

function EditSpouse(field) {
	if( field.value.length )
		window.open('editperson.php?personID=' + field.value + '&tree=<?php echo $tree; ?>' + '&cw=1','editspouse');
}

function RemoveSpouse( spouse, spousedisplay ) {
	spouse.value = "";
	spousedisplay.value = "";
}

var nplitbox;
var activeidbox = null;
var activenamebox = null;
function openCreatePersonForm(idfield,namefield,type,gender,father) {
	activeidbox = idfield;
	activenamebox = namefield;
	nplitbox = new LITBox('newperson2.php?tree=' + tree + '&type='+type + '&familyID=' + persfamID + '&father=' + father + '&gender=' + gender,{width:620,height:550});
	generateID('person',document.npform.personID);
	$('firstname').focus();
	return false;
}

function saveNewPerson(form) {
	form.personID.value = TrimString( form.personID.value );
	var personID = form.personID.value;
	if( personID.length == 0 ) {
		alert("<?php echo $admtext[enterpersonid]; ?>");
	}
	else {
		var params = Form.serialize(form) + '&order=' + (childcount+1);
		new Ajax.Request('addperson2.php',{parameters:params,
			onSuccess:function(req){
				nplitbox.remove();
				if(form.type.value == "child") {
					$('childrenlist').innerHTML += req.responseText;
					new Effect.Appear('child_'+personID,{duration:.4});
					childcount += 1;
					$('childcount').innerHTML = childcount;
					startSort();
				}
				else if(form.type.value == "spouse") {
					var vars = eval('('+req.responseText+')');
					$(activenamebox).value = vars.name + ' - ' + vars.id;
					new Effect.Highlight(activenamebox,{duration:.4});
					$(activeidbox).value = vars.id;
				}
			}
		});
	}
	return false
}
</script>
<script language="JavaScript" src="admin.js"></script>
</head>

<body background="../background.gif" onLoad="startSort()">

<?php
	$familytabs[0] = array(1,"families.php",$admtext['search'],"findfamily");
	$familytabs[1] = array($allow_add,"newfamily.php",$admtext[addnew],"addfamily");
	$familytabs[2] = array($allow_edit,"findreview.php?type=F",$admtext['review'] . $revstar,"review");
	$familytabs[3] = array($allow_edit,"editfamily.php?familyID=$familyID&tree=$tree",$admtext['edit'],"edit");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/families_help.php#edit', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">$text[expandall]</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">$text[collapseall]</a>";
	$innermenu .= " &nbsp;|&nbsp; <a href=\"$familygroup_url" . "familyID=$familyID&amp;tree=$tree\" target=\"_blank\" class=\"lightlink\">$admtext[test]</a>";
	if( $allow_add && ( !$assignedtree || $assignedtree == $tree ) )
		$innermenu .= " &nbsp;|&nbsp; <a href=\"newmedia.php?personID=$familyID&amp;tree=$tree&amp;linktype=F\" class=\"lightlink\">$admtext[addmedia]</a>";
	$menu = doMenu($familytabs,"edit",$innermenu);
	echo displayHeadline("$admtext[families] &gt;&gt; $admtext[modifyfamily]","families_icon.gif",$menu,$message);
?>

<form action="updatefamily.php" method="post" name="form1" style="margin:0px">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<table cellpadding="0" cellspacing="0" class="normal">
		<tr>
			<td valign="top"><div id="thumbholder" style="margin-right:5px;<?php if(!$photo) echo "display:none"; ?>"><?php echo $photo; ?></div></td>
			<td>
				<span style="font-size:21px"><?php echo $namestr; ?></span><br/>
				<div style="margin-top:12px;margin-bottom:12px" class="smallest">
<?php
				$notesicon = $gotnotes['general'] ? "tng_note_on.gif" : "tng_note.gif";
				$citesicon = $gotcites['general'] ? "tng_cite_on.gif" : "tng_cite.gif";
				//$associcon = $gotassoc ? "tng_assoc_on.gif" : "tng_assoc.gif";
				echo "<a href=\"#\" onclick=\"document.form1.submit();\"><img src=\"tng_save.gif\" title=\"$admtext[save]\" alt=\"$admtext[save]\" $dims class=\"smallicon\" style=\"vertical-align:middle;\"/></a> <a href=\"#\" onclick=\"document.form1.submit();\">$admtext[save]</a> &nbsp;&nbsp;\n";
				echo "<a href=\"#\" onclick=\"return showNotes('');\"><img src=\"$notesicon\" title=\"$admtext[notes]\" alt=\"$admtext[notes]\" $dims id=\"notesicon\" class=\"smallicon\" style=\"vertical-align:middle;\"/></a> <a href=\"#\" onclick=\"return showNotes('');\">$admtext[notes]</a> &nbsp;&nbsp;\n";
				echo "<a href=\"#\" onclick=\"return showCitations('');\"><img src=\"$citesicon\" title=\"$admtext[sources]\" alt=\"$admtext[sources]\" $dims id=\"citesicon\" class=\"smallicon\" style=\"vertical-align:middle;\"/></a> <a href=\"#\" onclick=\"return showCitations('');\">$admtext[sources]</a> &nbsp;&nbsp;\n";
	 			//echo "<a href=\"#\" onclick=\"return showAssociations('');\"><img src=\"$associcon\" title=\"$admtext[associations]\" alt=\"$admtext[associations]\" $dims class=\"smallicon\"/></a>\n";
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
	<?php echo displayToggle("plus0",1,"spouses",$admtext['spouses'],""); ?>

	<div id="spouses">
	<table class="normal" style="margin-top:8px">
<?php
	if( $row['husband'] ) {
		$query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder FROM $people_table WHERE personID = \"$row[husband]\" AND gedcom = \"$tree\"";
		$spouseresult= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$spouserow =  mysql_fetch_assoc( $spouseresult );
		mysql_free_result($spouseresult);
	}
	if( $row['husband'] )
		$husbstr = getName( $spouserow ) . " - $row[husband]";
	if(!isset($husbstr)) $husbstr = $admtext['clickfind'];
?>
	<tr><td><span class="normal"><?php echo $admtext['husband']; ?>:</span></td><td><input type="text" readonly="readonly" name="husbnameplusid" id="husbnameplusid" size="40" value="<?php echo "$husbstr"; ?>"><input type="hidden" name="husband" id="husband" value="<?php echo $row['husband']; ?>">
		<input type="button" value="<?php echo $admtext['find']; ?>" onclick="return openFindPersonForm('husband','husbnameplusid','text');">
		<input type="button" value="<?php echo $admtext['create']; ?>" onclick="return openCreatePersonForm('husband','husbnameplusid','spouse','M');">
		<input type="button" value="  <?php echo $admtext['edit']; ?>  " onclick="EditSpouse(document.form1.husband);">
		<input type="button" value="<?php echo $admtext['remove']; ?>" onclick="RemoveSpouse(document.form1.husband,document.form1.husbnameplusid);">
	</td></tr>
<?php
	if( $row['wife'] ) {
		$query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder FROM $people_table WHERE personID = \"$row[wife]\" AND gedcom = \"$tree\"";
		$spouseresult= mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		$spouserow =  mysql_fetch_assoc( $spouseresult );
		mysql_free_result($spouseresult);
	}
	else
		$spouserow = "";
	if( $row['wife'] )
		$wifestr = getName( $spouserow ) . " - $row[wife]";
	if(!isset($wifestr)) $wifestr = $admtext['clickfind'];
?>
	<tr><td><span class="normal"><?php echo $admtext['wife']; ?>:</span></td><td><input type="text" readonly readonly="readonly" name="wifenameplusid" id="wifenameplusid" size="40" value="<?php echo "$wifestr"; ?>"><input type="hidden" name="wife" id="wife" value="<?php echo $row['wife']; ?>">
		<input type="button" value="<?php echo $admtext['find']; ?>" onclick="return openFindPersonForm('wife','wifenameplusid','text');">
		<input type="button" value="<?php echo $admtext['create']; ?>" onclick="return openCreatePersonForm('wife','wifenameplusid','spouse','F');">
		<input type="button" value="  <?php echo $admtext['edit']; ?>  " onClick="EditSpouse(document.form1.wife);">
		<input type="button" value="<?php echo $admtext['remove']; ?>" onClick="RemoveSpouse(document.form1.wife,document.form1.wifenameplusid);">
	</td></tr>
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
	</div>
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
	echo showEventRow('marrdate','marrplace','MARR');
?>
		<tr>
			<td><?php echo $admtext['marriagetype']; ?>:</td>
			<td colspan="6"><input type="text" value="<?php echo "$row[marrtype]"; ?>" name="marrtype" style="width:494px" maxlength="50"></td>
		</tr>
<?php
	if( $allow_lds )
		echo showEventRow('sealdate','sealplace','SLGS');
	echo showEventRow('divdate','divplace','DIV');
?>
		<tr><td colspan="7">&nbsp;</td></tr>
		<tr>
			<td valign="top"><?php echo $admtext['otherevents']; ?>:</td>
			<td colspan="6">
<?php
	echo "<input type=\"button\" value=\"  " . $admtext['addnew'] . "  \" onClick=\"newEvent('F','$familyID','$tree');\">&nbsp;\n";
?>
	   		</td>
		</tr>
	</table>
<?php
		showCustEvents($familyID);
?>
	</div>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
<?php
	echo displayToggle("plus2",1,"children",$admtext['children'] . " (<span id=\"childcount\">$kidcount</span>)","");
?>

	<div id="children" style="padding-top:10px">
		<table id="ordertbl" width="500px" cellpadding="3" cellspacing="1" border="0">
			<tr>
				<td class="fieldnameback" style="width:55px"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['text_sort']; ?></b>&nbsp;</nobr></span></td>
				<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['child']; ?></b>&nbsp;</nobr></span></td>
			</tr>
		</table>
		<div id="childrenlist">
<?php
	if( $children && $kidcount ) {
		while ( $child =  mysql_fetch_assoc( $children ) )
		{
			$rightbranch = !$assignedbranch || $child['branch'] ? 1 : 0;
			$child['allow_living'] = !$child['living'] || ( $allow_living && $rightbranch ) ? 1 : 0;
			if( $child['firstname'] || $child['lastname'] ) {
				echo "<div class=\"sortrow\" id=\"child_$child[pID]\" style=\"width:500px;clear:both\"";
				if($allow_delete)
					echo " onmouseover=\"$('unlinkc_$child[pID]').style.visibility='visible';\" onmouseout=\"$('unlinkc_$child[pID]').style.visibility='hidden';\"";
				echo ">\n";
				echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr>\n";
				echo "<td class=\"dragarea normal\">";
		   		echo "<img src=\"ArrowUp.gif\" alt=\"\"><br/>" . $admtext['drag'] . "<br/><img src=\"ArrowDown.gif\" alt=\"\">\n";
				echo "</td>\n";
				echo "<td class=\"lightback normal\" style=\"line-height:1.6em;\">\n";

				if($allow_delete)
					echo "<div id=\"unlinkc_$child[pID]\" class=\"smaller\" style=\"float:right;visibility:hidden\"><a href=\"#\" onclick=\"return unlinkChild('$child[pID]','child_unlink');\">$admtext[remove]</a> &nbsp; | &nbsp; <a href=\"#\" onclick=\"return unlinkChild('$child[pID]','child_delete');\">$admtext[text_delete]</a></div>";
				if( $child['allow_living'] ) {
					if( $child['birthdate'] ) {
						$birthstring = "$admtext[birthabbr] " . displayDate($child[birthdate]);
					}
					else if( $child['altbirthdate'] ) {
						$birthstring = "$admtext[chrabbr] " . displayDate($child[altbirthdate]);
					}
					else
						$birthstring = $admtext['nobirthinfo'];
					echo "<a href=\"#\" onclick=\"EditChild('$child[pID]');\">" . getName( $child ) . "</a> - $child[pID]<br />$birthstring";
				}
				else {
					echo "$admtext[living] - $child[pID]";
				}
				echo "</div>\n</td>\n</tr>\n</table>\n</div>\n";
			}
		}
		mysql_free_result( $children );
	}
?>
		</div>

		<input type="hidden" name="tree" value="<?php echo $tree; ?>">
		<p class="normal"><?php echo $admtext['newchildren']; ?>:
		<input type="button" value="<?php echo $admtext['find']; ?>" onclick="return openFindPersonForm('','','select');">
		<input type="button" value="<?php echo $admtext['create']; ?>" onclick="return openCreatePersonForm('','','child','',document.form1.husband.value);">
		<input type="hidden" name="familyID" value="<?php echo "$familyID"; ?>">
		</p>
	</div>
</td>
</tr>
<tr class="databack">
<td class="tngshadow normal">
<?php 
	echo "$admtext[onsave]:<br/>";
	echo "<input type=\"radio\" name=\"newfamily\" value=\"return\"> $admtext[savereturn]<br/>\n";
	if( $cw )
		echo "<input type=\"radio\" name=\"newfamily\" value=\"close\" checked=\"checked\"> $text[closewindow]\n";
	else
		echo "<input type=\"radio\" name=\"newfamily\" value=\"none\" checked=\"checked\"> $admtext[saveback]\n";
?>
	<br/><br/><input type="submit" name="submit2" accesskey="s" value="<?php echo $admtext[save]; ?>">
<?php if( !$allow_lds ) { ?>
	<input type="hidden" value="<?php echo $row['sealdate']; ?>" name="sealdate">
	<input type="hidden" name="sealsrc" value="<?php echo $row['sealsrc']; ?>">
	<input type="hidden" value="<?php echo $row['sealplace']; ?>" name="sealplace">
<?php } ?>
	<input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
	</span>
</td>
</tr>
</table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
