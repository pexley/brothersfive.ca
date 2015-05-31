<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "language";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");

if( $assignedtree ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

session_register('tng_search_langs');
session_register('tng_search_langs_post');
$tng_search_langs = $_SESSION[tng_search_langs] = 1;
if( $newsearch ) {
	$exptime = time()+3600*24*365;
	setcookie("tng_search_langs_post[search]", $searchstring, $exptime);
	setcookie("tng_search_langs_post[page]", 1, $exptime);
	setcookie("tng_search_langs_post[offset]", 0, $exptime);
}
else {
	if( !$searchstring )
		$searchstring = $_COOKIE[tng_search_langs_post][search];
	if( !isset($offset) ) {
		$page = $_COOKIE[tng_search_langs_post][page];
		$offset = $_COOKIE[tng_search_langs_post][offset];
	}
	else {
		$exptime = time()+3600*24*365;
		setcookie("tng_search_langs_post[page]", $page, $exptime);
		setcookie("tng_search_langs_post[offset]", $offset, $exptime);
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

$wherestr = $searchstring ? "WHERE display LIKE \"%$searchstring%\" OR folder LIKE \"%$searchstring%\"" : "";
$query = "SELECT languageID, display, folder, charset FROM $languages_table $wherestr ORDER BY display LIMIT $newoffset" . $maxsearchresults;
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );
if( $numrows == $maxsearchresults || $offsetplus > 1 ) {
	$query = "SELECT count(languageID) as lcount FROM $languages_table $wherestr";
	$result2 = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
	$row = mysql_fetch_assoc( $result2 );
	$totrows = $row[lcount];
	mysql_free_result($result2);
}
else
	$totrows = $numrows;

$helplang = findhelp("languages_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[languages], $flags );
?>
<script type="text/javascript" src="admin.js"></script>
</head>

<body background="../background.gif">

<?php
	$langtabs[0] = array(1,"languages.php",$admtext['search'],"findlang");
	$langtabs[1] = array($allow_add,"newlanguage.php",$admtext[addnew],"addlanguage");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/languages_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($langtabs,"findlang",$innermenu);
	echo displayHeadline("$admtext[languages]","languages_icon.gif",$menu,$message);
?>

<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">

	<form action="languages.php" style="margin:0px;" name="form1">
	<?php echo $admtext[searchfor]; ?>: <input type="text" name="searchstring" value="<?php echo $searchstring; ?>">
	<input type="hidden" name="findlang" value="1"><input type="hidden" name="newsearch" value="1">
	<input type="submit" name="submit" value="<?php echo $admtext[search]; ?>" style="vertical-align:top">
	<input type="submit" name="submit" value="<?php echo $admtext[reset]; ?>" onClick="document.form1.searchstring.value='';" style="vertical-align:top">
	</form><br />

<?php
	$numrowsplus = $numrows + $offset;
	if( !$numrowsplus ) $offsetplus = 0;
	echo displayListLocation($offsetplus,$numrowsplus,$totrows);
	$pagenav = get_browseitems_nav( $totrows, "languages.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5 );
	echo " &nbsp; $pagenav</p>";
?>

	<table cellpadding="3" cellspacing="1" border="0" class="normal">
		<tr>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[action]; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[display]; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[folder]; ?></b>&nbsp;</nobr></td>
			<td class="fieldnameback fieldname"><nobr>&nbsp;<b><?php echo $admtext[charset]; ?></b>&nbsp;</nobr></td>
		</tr>

<?php
	if( $numrows ) {
		$actionstr = "";
		if( $allow_edit )
			$actionstr .= "<a href=\"editlanguage.php?languageID=xxx\"><img src=\"tng_edit.gif\" title=\"$admtext[edit]\" alt=\"$admtext[edit]\" $dims class=\"smallicon\"/></a>";
		if( $allow_delete )
			$actionstr .= "<a href=\"#\" onclick=\"if(confirm('$admtext[conflangdelete]' )){deleteIt('language',xxx);} return false;\"><img src=\"tng_delete.gif\" title=\"$admtext[text_delete]\" alt=\"$admtext[text_delete]\" $dims class=\"smallicon\"/></a>";
		while( $row = mysql_fetch_assoc($result)) {
			$newactionstr = ereg_replace( "xxx", $row[languageID], $actionstr );
			echo "<tr id=\"row_$row[languageID]\"><td class=\"lightback\">$newactionstr</td>\n";
			echo "<td class=\"lightback\">$row[display]&nbsp;</td>\n";
			echo "<td class=\"lightback\">$row[folder]&nbsp;</td>\n";
			echo "<td class=\"lightback\">$row[charset]&nbsp;</td></tr>\n";
		}
?>
	</table>
<?php
		echo displayListLocation($offsetplus,$numrowsplus,$totrows);
		echo " &nbsp; $pagenav</p>";
	}
	else
		echo $admtext[norecords];
  	mysql_free_result($result);
?>
	<p>
	<img src="tng_edit.gif" alt="<?php echo $admtext[edit]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[edit]; ?> &nbsp;&nbsp;
	<img src="tng_delete.gif" alt="<?php echo $admtext[text_delete]; ?>" <?php echo $dims; ?> class="smallicon" style="vertical-align:middle;"/> = <?php echo $admtext[text_delete]; ?> &nbsp;&nbsp;
	</p>

	</div>
</td>
</tr>

</table>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
