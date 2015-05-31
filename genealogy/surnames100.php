<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "surnames";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );

$search_url = getURL( "search", 1 );
$surnames_all_url = getURL( "surnames-all", 1 );
$surnames_url = getURL( "surnames", 1 );
$surnames100_url = getURL( "surnames100", 1 );

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$surnames100_url" . "topnum=$topnum&amp;tree=$tree\">" . xmlcharacters("$text[surnamelist]: $text[top] $topnum$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( "$text[surnamelist] &mdash; $text[top] $topnum", $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_names.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo "$text[surnamelist] &mdash; $text[top] $topnum"; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => false, 'action' => 'surnames100', 'method' => 'get', 'name' => 'form1', 'id' => 'form1'));
?>

<ul class="normal">
<li><?php echo $text[showtop]; ?> <input type="text" name="topnum" value="<?php echo $topnum; ?>" size="4" maxlength="4" /> <?php echo $text[byoccurrence]; ?> <input type="submit" value="<?php echo $text[go]; ?>" /></li>
 <li><?php echo "<a href=\"$surnames_all_url" . "tree=$tree\">$text[showallsurnames]</a> ($text[sortedalpha])"; ?></li>
 <li><?php echo "<a href=\"$surnames_url" . "tree=$tree\">$text[mainsurnamepage]</a>"; ?></li>
</ul>
</form>
<br />

<table border="0" cellspacing="0" cellpadding="0">
	<tr><td valign="top"><span class="normal">
<?php
if( $tree ) {
	$wherestr = "WHERE gedcom = \"$tree\"";
	$treestr = "&amp;tree=$tree";
}
else {
	$wherestr = "";
	$treestr = "";
}
	
if( $livedefault < 2 && ( !$allow_living_db || $assignedtree ) && $nonames == 1 ) {
	$allwhere = "";
	if( $allow_living_db ) {
		if( $assignedbranch )
			$allwhere = "($people_table.living != 1 OR ($people_table.gedcom = \"$assignedtree\" AND $people_table.branch LIKE \"%$assignedbranch%\") )";
		else
			$allwhere = "($people_table.living != 1 OR $people_table.gedcom = \"$assignedtree\")";
	}
	else
		$allwhere = "$people_table.living != 1";
	if( $allwhere )
		$wherestr .= $wherestr ? " AND $allwhere" : "WHERE $allwhere";
}

$topnum = $topnum ? $topnum : 100;
$surnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,lastname) )" : "lastname";
$query = "SELECT ucase( $binary $surnamestr ) as lastname, $surnamestr as lowername, count( ucase($binary lastname) ) as lncount FROM $people_table $wherestr GROUP BY lowername ORDER by lncount DESC LIMIT $topnum";

$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
$topnum = mysql_num_rows($result);
if( $result ) {
	$counter = 1;
	$num_in_col = 20;
	$numcols = floor($topnum / $num_in_col);
	if( $numcols > 4 ) {
		$numcols = 4;
		$num_in_col = ceil($topnum / 4 );
	}
	
	$num_in_col_ctr = 0;
	$nosurname = urlencode($text[nosurname]);
	while( $surname = mysql_fetch_assoc( $result ) ) {
		$surname2 = urlencode( $surname[lastname] );
		$name = $surname[lastname] ? "<a href=\"$search_url" . "mylastname=$surname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">$surname[lowername]</a>" : "<a href=\"$search_url" . "mylastname=$nosurname&amp;lnqualify=equals&amp;mybool=AND$treestr\">$text[nosurname]</a>";
		echo "$counter. $name ($surname[lncount])<br/>\n";
		$counter++;
		$num_in_col_ctr++;
		if( $num_in_col_ctr == $num_in_col ) {
			echo "</span></td>\n<td>&nbsp;&nbsp;</td>\n<td valign=\"top\"><span class=\"normal\">";
			$num_in_col_ctr = 0;
		}
	}
	mysql_free_result($result);
}
?>
	</span></td></tr>
</table>
<br/>
<?php
tng_footer( "" );
?>
