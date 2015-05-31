<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "mapconfig.php");
include("adminlib.php");
$textpart = "cemeteries";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

session_register('tng_search_cemeteries');
session_register('tng_search_cemeteries_post');
$tng_search_cemeteries = $_SESSION[tng_search_cemeteries] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_cemeteries_post[search]", $searchstring, $exptime);
	setcookie("tng_search_cemeteries_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_cemeteries_post][search];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_cemeteries_post][page];
		$offset = $_COOKIE[tng_search_cemeteries_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_cemeteries_post[page]", $page, $exptime);
		setcookie("tng_search_cemeteries_post[offset]", $offset, $exptime);
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

$showmap_url = getURL( "showmap", 1 );
$frontmod = "LIKE";
$allwhere = "WHERE 1=0";

$allwhere .= addCriteria( "$cemeteries_table.cemeteryID", $searchstring, $frontmod );
$allwhere .= addCriteria( "maplink", $searchstring, $frontmod );
$allwhere .= addCriteria( "cemname", $searchstring, $frontmod );
$allwhere .= addCriteria( "city", $searchstring, $frontmod );
$allwhere .= addCriteria( "state", $searchstring, $frontmod );
$allwhere .= addCriteria( "county", $searchstring, $frontmod );
$allwhere .= addCriteria( "country", $searchstring, $frontmod );

$query = "SELECT cemeteryID,cemname,city,county,state,country,latitude,longitude,zoom FROM $cemeteries_table $allwhere ORDER BY cemname, city, county, state, country LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(cemeteryID) as ccount FROM $cemeteries_table $allwhere";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[ccount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("cemeteries_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[cemeteries], $flags );
?>
<script type="text/javascript">
function confirmDelete(ID) {
	if(confirm('<?php echo $admtext['confdeletecem']; ?>' ))
		deleteIt('cemetery',ID);
	return false;
}
</script>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$cemtabs[0] = array(1,"cemeteries.php",$admtext['search'],"findcem");
	$cemtabs[1] = array($allow_add,"newcemetery.php",$admtext[addnew],"addcemetery");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/cemeteries_help.php#modify', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($cemtabs,"findcem",$innermenu);
	echo displayHeadline("$admtext[cemeteries]","cemeteries_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="cemeteries.php" style="margin:0px;" name="form1">
	<table>
		<tr>
			<td><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
			<td><input type="text" name="searchstring" value="<?php echo $searchstring; ?>"></td>
			<td>
				<input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" style="vertical-align:top">
				<input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value='';" style="vertical-align:top">
			</td>
		</tr>
	</table>

	<input type="hidden" name="findcemetery" value="1"><input type="hidden" name="newsearch" value="1">
	</form><br />
<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "cemeteries.php?searchstring=$searchstring&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>
	<form action="deleteselected.php" method="post" name="form2">
<?php
	if( $allow_delete ) {
?>
		<p>
		<input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
		<input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
  		<input type="submit" name="xcemaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
		</p>
<?php
	}
?>

	<table cellpadding="3" cellspacing="1" border="0">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</nobr></td>
<?php
	if($allow_delete) {
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</nobr></td>
<?php
	}
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['cemetery']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['location']; ?></b>&nbsp;</nobr></td>
<?php
	if($map['key']) {
?>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['googleplace']; ?></b>&nbsp;</nobr></td>
<?php
	}
	else {
?>			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['latitude']; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext['longitude']; ?></b>&nbsp;</nobr></td>
<?php
	}
?>
		</tr>

<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editcemetery.php?cemeteryID=xxx\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx');\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
		$actionstr .= "<a href=\"" . $showmap_url . "cemeteryID=xxx&amp\" target=\"_blank\"><img src=\"tng_test.gif\" title=\"$admtext[test]\" alt=\"$admtext[test]\" $dims class=\"smallicon\"/></a>";

		while( $row = mysql_fetch_assoc($result))
		{
			$location = $row[city];
			if( $row[county] ) {
				if( $location ) $location .= ", ";
				$location .= "$row[county]";
			}
			if( $row[state] ) {
				if( $location ) $location .= ", ";
				$location .= "$row[state]";
			}
			if( $row[country] ) {
				if( $location ) $location .= ", ";
				$location .= "$row[country]";
			}

			$newactionstr = ereg_replace( "xxx", $row['cemeteryID'], $actionstr );
			echo "<tr id=\"row_$row[cemeteryID]\"><td class=\"lightback\" valign=\"top\"><span class=\"normal\"><nobr>$newactionstr</nobr></span></td>\n";
			if($allow_delete)
				echo "<td class=\"lightback\" valign=\"top\" align=\"center\"><input type=\"checkbox\" name=\"del$row[cemeteryID]\" value=\"1\"></td>";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[cemname]&nbsp;</span></td>\n";
			echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$location&nbsp;</span></td>\n";
			if($map[key]) {
				echo "<td nowrap class=\"lightback\" valign=\"top\"><span class=\"normal\">";
				$geo = "";
				if($row['latitude']) $geo .= "$admtext[latitude]: " . number_format($row[latitude],3);
				if($row['longitude']) {
					if($geo) $geo .= "<br />";
					$geo .= "$admtext[longitude]: " . number_format($row[longitude],3);
				}
				if($row['zoom']) {
					if($geo) $geo .= "<br />";
					$geo .= "$admtext[zoom]: $row[zoom]";
				}
				echo "$geo&nbsp;</span></td>\n";
			}
			else {
				echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[latitude]&nbsp;</span></td>\n";
				echo "<td class=\"lightback\" valign=\"top\"><span class=\"normal\">$row[longitude]&nbsp;</span></td></tr>\n";
			}
		}
?>
	</table>
<?php
		echo displayListLocation($offsetplus,$numrowsplus,$totrows);
		echo " &nbsp; $pagenav</p>";
	}
	else
		echo $admtext['norecords'];
  	mysql_free_result($result);
?>
	</form>
	
	<p style="vertical-align:middle">
	<img src="tng_edit.gif" alt="<?php echo $admtext['edit']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['edit']; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext['text_delete']; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext['text_delete']; ?> &nbsp;&nbsp;
	<img src="tng_test.gif" alt="<?php echo $admtext[test]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[test]; ?>
	</p>

	</div>
</td>
</tr>
</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>