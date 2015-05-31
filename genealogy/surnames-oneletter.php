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
$surnames_url = getURL( "surnames", 1 );
$surnames_oneletter_url = getURL( "surnames-oneletter", 1 );

$decodedfirstchar = stripslashes(urldecode($firstchar));
//if($charset == "UTF-8") $decodedfirstchar = utf8_encode($decodedfirstchar);

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$surnames_oneletter_url" . "firstchar=$firstchar&amp;tree=$tree\">" . xmlcharacters("$text[surnamelist]: $text[beginswith] $decodedfirstchar$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( "$text[surnamelist]: $text[beginswith] $decodedfirstchar", $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_names.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo "$text[surnamelist]: $text[beginswith] $decodedfirstchar"; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

$hiddenfields[] = array('name' => 'firstchar', 'value' => $firstchar);
echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'surnames-oneletter', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields));

echo getFORM( "surnames100", "get", "", "" );
?>

<br />
<ul class="normal">
<li><?php echo $text[showtop]; ?> <input type="text" name="topnum" value="100" size="4" maxlength="4" /> <?php echo $text[byoccurrence]; ?> <input type="hidden" name="tree" value="<?php echo $tree; ?>" /><input type="submit" value="<?php echo $text[go]; ?>" /><br/></li>
<li><?php echo "<a href=\"$surnames_url" . "tree=$tree\">$text[mainsurnamepage]</a>"; ?></li></ul>
</form>
<p><?php echo "$text[allbeginningwith] $decodedfirstchar, $text[sortedalpha] ($text[totalnames]):"; ?><br/>
</p>
<p><b><?php echo $text[showmatchingsurnames]; ?></b></p>

<table border="0" cellspacing="0" cellpadding="0">
	<tr><td valign="top"><span class="normal">
<?php
if( $tree ) {
	$wherestr = "AND gedcom = \"$tree\"";
	$treestr = "&amp;tree=$tree";
}
else {
	$wherestr = "";
	$treestr = "";
}
	
if( $livedefault < 2 && ( !$allow_living_db || $assignedtree ) && $nonames == 1 ) {
	if( $allow_living_db ) {
		if( $assignedbranch )
			$wherestr .= " AND ($people_table.living != 1 OR ($people_table.gedcom = \"$assignedtree\" AND $people_table.branch LIKE \"%$assignedbranch%\") )";
		else
			$wherestr .= " AND ($people_table.living != 1 OR $people_table.gedcom = \"$assignedtree\")";
	}
	else
		$wherestr .= " AND $people_table.living != 1";
}

$surnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,lastname) )" : "lastname";
$firstchar = $firstchar == "\"" ? "\\\"" : $firstchar;
$query = "SELECT ucase( $binary $surnamestr ) as lastname, $surnamestr as lowername, ucase($binary lastname) as binlast, count( ucase($binary lastname) ) as lncount FROM $people_table WHERE ucase($binary TRIM(lastname)) LIKE \"$firstchar%\" $wherestr GROUP BY lowername ORDER by binlast";
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
		$name = $surname[lastname] ? "<a href=\"$search_url" . "mylastname=$surname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">$surname[lowername]</a>" : "$text[nosurname]";
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
</table>
<br/>
<?php
tng_footer( "" );
?>
