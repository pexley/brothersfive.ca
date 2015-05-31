<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "eventtypes";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

session_register('tng_search_eventtypes');
session_register('tng_search_eventtypes_post');
$tng_search_eventtypes = $_SESSION[tng_search_eventtypes] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_eventtypes_post[search]", $searchstring, $exptime);
	setcookie("tng_search_eventtypes_post[etype]", $etype, $exptime);
	setcookie("tng_search_eventtypes_post[onimport]", $onimport, $exptime);
	setcookie("tng_search_eventtypes_post[page]", 1, $exptime);
	setcookie("tng_search_eventtypes_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_eventtypes_post][search];
	if( !$etype )
		$etype = $_COOKIE[tng_search_eventtypes_post][etype];
	if( !$onimport )
		$onimport = $_COOKIE[tng_search_eventtypes_post][onimport];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_eventtypes_post][page];
		$offset = $_COOKIE[tng_search_eventtypes_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_eventtypes_post[page]", $page, $exptime);
		setcookie("tng_search_eventtypes_post[offset]", $offset, $exptime);
	}
}

if( $offset ) {
	$offsetplus = $offset + 1;
	$newoffset = "$offset, ";
}
else {
	$offsetplus = 1;
	$newoffset = "";
	$page = 1;
}

$wherestr = $searchstring ? "(tag LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR display LIKE \"%$searchstring%\")" : "";
if( $etype )
	$wherestr .= $wherestr ? " AND type = \"$etype\"" : "type = \"$etype\"";
if( $onimport || $onimport === "0" )
	$wherestr .= $wherestr ? " AND keep = \"$onimport\"" : "keep = \"$onimport\"";
if( $wherestr ) $wherestr = "WHERE $wherestr";
	
$query = "SELECT eventtypeID, tag, description, display, type, keep, ordernum FROM $eventtypes_table $wherestr ORDER BY tag, description LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(eventtypeID) as ecount FROM $eventtypes_table $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[ecount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("eventtypes_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[eventtypes], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confdeleteevtype']; ?>' ))
		deleteIt('eventtype',ID);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$evtabs[0] = array(1,"eventtypes.php",$admtext['search'],"findevent");
	$evtabs[1] = array($allow_add,"neweventtype.php",$admtext[addnew],"addevent");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/eventtypes_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($evtabs,"findevent",$innermenu);
	echo displayHeadline("$admtext[customeventtypes]","customeventtypes_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">
	
	<form action="eventtypes.php" style="margin:0px;" name="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext[searchfor]; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>"></td>
			<td>
				<input type="submit" name="submit" value="<?php echo $admtext[search]; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext[reset]; ?>" onClick="document.form1.searchstring.value=''; document.form1.etype.selectedIndex=0; document.form1.onimport[2].checked=true;" style="vertical-align:top">
			</td>
		</tr>
		<tr>
			<td><span class="normal"><?php echo $admtext[assocwith]; ?>: </span></td>
			<td>
				<select name="etype">
					<option value=""><?php echo $admtext[all]; ?></option>
					<option value="I"<?php if( $etype == "I" ) echo " selected"; ?>><?php echo $admtext[individual]; ?></option>
					<option value="F"<?php if( $etype == "F" ) echo " selected"; ?>><?php echo $admtext[family]; ?></option>
					<option value="S"<?php if( $etype == "S" ) echo " selected"; ?>><?php echo $admtext[source]; ?></option>
					<option value="R"<?php if( $etype == "R" ) echo " selected"; ?>><?php echo $admtext[repository]; ?></option>
				</select>
			</td>
			<td>
				<span class="normal">
				<input type="radio" name="onimport" value="1"<?php if( $onimport ) echo " checked"; ?>> <?php echo $admtext[accept]; ?>
				<input type="radio" name="onimport" value="0"<?php if( $onimport === "0" ) echo " checked"; ?>> <?php echo $admtext[ignore]; ?>
				<input type="radio" name="onimport" value=""<?php if( $onimport === NULL || $onimport === "" ) echo " checked"; ?>> <?php echo $admtext[all]; ?>
				</span>
			</td>
		</tr>
	</table>

	<input type="hidden" name="findeventtype" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "eventtypes.php?searchstring=$searchstring&amp;etype=$etype&amp;onimport=$onimport&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="updateselectedeventtypes.php" style="margin:0px" method="post" name="form2">
        <p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">&nbsp;&nbsp;
<?php
		if( $allow_delete ) {
?>
		<input type="submit" name="cetaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
<?php
		}
		if( $allow_edit ) {
?>
		<input type="submit" name="cetaction" value="<?php echo $admtext['acceptselected']; ?>">
		<input type="submit" name="cetaction" value="<?php echo $admtext['ignoreselected']; ?>">
		</p>
<?php
		}
?>

	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></span></td>
<?php
	if($allow_delete || $allow_edit) {
?>
			<td class="fieldnameback"><span class="fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></span></td>
<?php
	}
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['tag']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['typedescription']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['display']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['orderpound']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['indfam']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['onimport']; ?></b>&nbsp;</nobr></td>
		</tr>
	
<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editeventtype.php?eventtypeID=xxx\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result)) {
			$keep = $row[keep] ? $admtext[accept] : $admtext[ignore];
			switch( $row[type] ) {
				case "I":
					$type = $admtext[individual];
					break;
				case "F":
					$type = $admtext[family];
					break;
				case "S":
					$type = $admtext[source];
					break;
				case "R":
					$type = $admtext[repository];
					break;
			}
			$dispvalues = explode( "|", $row[display] );
			$numvalues = count( $dispvalues );
			if( $numvalues > 1 ) {
				$displayval = "";
				for( $i = 0; $i < $numvalues; $i += 2 ) {
					$lang = $dispvalues[$i]; 
					if( $mylanguage == $lang ) {
						$displayval = $dispvalues[$i+1];
						break;
					}
				}
			}
			else
				$displayval = $row[display];
			$newactionstr = ereg_replace( "xxx", $row[eventtypeID], $actionstr );
			echo "<tr id=\"row_$row[eventtypeID]\"><td class=\"lightback\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			if($allow_delete || $allow_edit)
				echo "<td class=\"lightback\" align=\"center\"><input type=\"checkbox\" name=\"et$row[eventtypeID]\" value=\"1\"></td>";
			echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$row[tag]&nbsp;</span></td><td class=\"lightback\"><span class=\"normal\">&nbsp;$row[description]&nbsp;</span></td><td class=\"lightback\"><span class=\"normal\">&nbsp;$displayval&nbsp;</span></td><td class=\"lightback\"><span class=\"normal\">$row[ordernum]</span></td><td class=\"lightback\"><span class=\"normal\">&nbsp;$type&nbsp;</span></td><td class=\"lightback\"><span class=\"normal\">&nbsp;$keep&nbsp;</span></td></tr>\n";
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

	<p>
	<img src="tng_edit.gif" alt="<?php echo $admtext['edit']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['edit']; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext['text_delete']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['text_delete']; ?>
	</p>

	</div>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
