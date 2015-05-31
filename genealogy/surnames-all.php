<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
$textpart = "surnames";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
@set_time_limit(0);
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "log.php" );

$search_url = getURL( "search", 1 );
$surnames_noargs_url = getURL( "surnames", 0 );
$surnames_all_url = getURL( "surnames-all", 1 );

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$surnames_all_url" . "tree=$tree\">$text[surnamelist]: $text[allsurnames]$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( "$text[surnamelist] &#8212; $text[allsurnames]", $flags );
?>
<a name="top"></a>
<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_names.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text[surnamelist]; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'surnames-all', 'method' => 'get', 'name' => 'form1', 'id' => 'form1'));

echo getFORM( "surnames100", "get", "", "" );
?>

<br />
<ul class="normal">
<li><?php echo $text[showtop]; ?> <input type="text" name="topnum" value="100" size="4" maxlength="4" /> <?php echo $text[byoccurrence]; ?>  <input type="hidden" name="tree" value="<?php echo $tree; ?>" /><input type="submit" value="<?php echo $text[go]; ?>" /><br/></li>
<li><?php echo "<a href=\"$surnames_noargs_url\">$text[mainsurnamepage]</a>"; ?></li></ul>
</form>
<?php
if( $tree ) {
	$wherestr = "WHERE gedcom = \"$tree\"";
	$wherestr2 = "AND gedcom = \"$tree\"";
	$treestr = "&amp;tree=$tree";
}
else {
	$wherestr = "";
	$wherestr2 = "";
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
	if( $allwhere ) {
		$wherestr .= $wherestr ? " AND $allwhere" : "WHERE $allwhere";
		$wherestr2 .= " AND $allwhere";
	}
}

$linkstr = "";
$nosurname = urlencode($text[nosurname]);
$query = "SELECT ucase(left(lastname,1)) as firstchar, ucase( $binary left(lastname,1) ) as binfirstchar FROM $people_table $wherestr GROUP BY binfirstchar ORDER by binfirstchar";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$initialchar = 1;
	
	while( $surname = mysql_fetch_assoc( $result ) ) {
		if( $initialchar != 1 ) {
			$linkstr .= "&nbsp;";
		}
		if( $surname[firstchar] == "" ) {
			$surname[firstchar] = $text[nosurname];
			$linkstr .= "<a href=\"$search_url" . "mylastname=$nosurname&amp;lnqualify=equals&amp;mybool=AND$treestr\" class=\"snlink\">$text[nosurname]</a>&nbsp;";
		}
		else {
			$linkstr .= "<a href=\"#char$initialchar\" class=\"snlink\">$surname[firstchar]</a>";
			$firstchars[$initialchar] = $surname[firstchar];
			$initialchar++;
		}
	}
	mysql_free_result($result);
}
?>
<br />
<ul class="normal"><li><?php echo $text[surnamesstarting]; ?>:<br/>
<?php
	echo "<p>$linkstr</p>";
?>
</li></ul>
<p><b><?php echo $text[showmatchingsurnames]; ?></b></p>

<?php
for( $scount = 1; $scount < $initialchar; $scount++ ) {
	echo "<a name=\"char$scount\"></a>\n";
	$urlfirstchar = addslashes($firstchars[$scount]);
?>
<span class="header"><?php echo $firstchars[$scount]; ?></span>
<table border="0" cellspacing="0" cellpadding="0">
	<tr><td valign="top"><span class="normal">
<?php
$surnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,lastname) )" : "lastname";
$query = "SELECT ucase( $binary $surnamestr ) as lastname, $surnamestr as lowername, ucase($binary lastname) as binlast, count( ucase($binary lastname) ) as lncount FROM $people_table WHERE ucase($binary TRIM(lastname)) LIKE \"$urlfirstchar%\" $wherestr2 GROUP BY lowername ORDER by binlast";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$snnum = 1;
	$num_in_col = 20;
	$numrows = mysql_num_rows($result);
	$numcols = floor($numrows / $num_in_col);
	if( $numcols > 4 ) {
		$numcols = 4;
		$num_in_col = ceil($numrows / 4 );
	}
	
	$num_in_col_ctr = 0;
	while( $surname = mysql_fetch_assoc( $result ) ) {
		$surname2 = urlencode( $surname[lastname] );
		$name = $surname[lastname] ? "<a href=\"$search_url" . "mylastname=$surname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">$surname[lowername]</a>" : "<a href=\"search.php?mylastname=$nosurname&amp;lnqualify=equals&amp;mybool=AND$treestr\">$text[nosurname]</a>";
		echo "$snnum. $name ($surname[lncount])<br/>\n";
		$snnum++;
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
</table><br/><p class="normal"><a href="#top"><?php echo $text[backtotop]; ?></a></p><br/>
<?php
}
tng_footer( "" );
?>
