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
$surnames_oneletter_url = getURL( "surnames-oneletter", 1 );
$surnames_all_url = getURL( "surnames-all", 1 );
$surnames_url = getURL( "surnames", 1 );

$treestr = $tree ? " ($text[tree]: $tree)" : "";
$logstring = "<a href=\"$surnames_url" . "tree=$tree\">" . xmlcharacters("$text[surnamelist]$treestr") . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header( $text[surnamelist], $flags );
?>

<p class="header"><img src="<?php echo $cms[tngpath]; ?>tng_names.gif" width="20" height="20" alt="" style="vertical-align:-2px" />&nbsp;<?php echo $text[surnamelist]; ?></p><br clear="left"/>
<?php
echo tng_coreicons();

echo treeDropdown(array('startform' => true, 'endform' => true, 'action' => 'surnames', 'method' => 'get', 'name' => 'form1', 'id' => 'form1'));
$linkstr = "";
$linkstr2col1 = "";
$linkstr2col2 = "";
$linkstr3col1 = "";
$linkstr3col2 = "";
$nosurname = urlencode($text[nosurname]);

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

$query = "SELECT ucase(left(lastname,1)) as firstchar, ucase( $binary left(lastname,1) ) as binfirstchar FROM $people_table $wherestr GROUP BY binfirstchar ORDER by binfirstchar";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$initialchar = 1;
	
	while( $surname = mysql_fetch_assoc( $result ) ) {
		if( $initialchar != 1 ) { 
			$linkstr .= "&nbsp;";
		}
		if( $surname[firstchar] == "" )
			$linkstr .= "<a href=\"$search_url" . "mylastname=$nosurname&amp;lnqualify=equals&amp;mybool=AND$treestr\" class=\"snlink\">$text[nosurname]</a>";
		else {
			//$urlfirstchar = urlencode($surname[firstchar]);
			$urlfirstchar = $surname[firstchar];
			//if($charset == "UTF-8") $surname[firstchar] = utf8_encode($surname[firstchar]);
			$linkstr .= "<a href=\"$surnames_oneletter_url" . "firstchar=$urlfirstchar$treestr\" class=\"snlink\" title=\"$text[surnamesstarting]: $surname[firstchar]\">$surname[firstchar]</a>";
		}
		$initialchar++;
	}
	mysql_free_result($result);
}

$query = "SELECT ucase(left(lastname,1)) as firstchar, ucase( $binary left(lastname,1) ) as binfirstchar, count( ucase( left( lastname,1) ) ) as lncount FROM $people_table $wherestr GROUP BY binfirstchar ORDER by lncount DESC";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$namectr = 1;
	$col = -1;
	while( $surname = mysql_fetch_assoc( $result ) ) {
		if(($namectr -1) % 8 == 0) {
			$col++;
		}
		if( $surname[firstchar] == "" )
			$linkstr2col[$col] .= "<p style=\"padding:2px;margin:8px\"><a href=\"$search_url" . "mylastname=$nosurname&amp;lnqualify=equals&amp;mybool=AND$treestr\" class=\"snlink\" title=\"$text[nosurname]\">[ ]</a> ($surname[lncount])</p>\n";
		else {
			//$urlfirstchar = urlencode($surname[firstchar]);
			$urlfirstchar = $surname[firstchar];
			//if($charset == "UTF-8") $surname[firstchar] = utf8_encode($surname[firstchar]);
			$linkstr2col[$col] .= "<p style=\"padding:2px;margin:8px;\"><a href=\"$surnames_oneletter_url" . "firstchar=$urlfirstchar$treestr\" class=\"snlink\" title=\"$text[surnamesstarting]: $surname[firstchar]\">$surname[firstchar]</a> ($surname[lncount])</p>\n";
		}
		$namectr++;
	}
	mysql_free_result($result);
}

$surnamestr = $lnprefixes ? "TRIM(CONCAT_WS(' ',lnprefix,lastname) )" : "lastname";
$query = "SELECT ucase( $binary $surnamestr ) as lastname, $surnamestr as lowername, count( ucase($binary lastname ) ) as lncount FROM $people_table $wherestr GROUP BY lowername ORDER by lncount DESC LIMIT 30";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");
if( $result ) {
	$count = 1;
	$col = -1;
	while( $surname = mysql_fetch_assoc( $result ) ) {
		$surname2 = urlencode($surname[lastname]);
		if(($count - 1) % 10 == 0)
			$col++;
		if( $surname[lastname] == "" )
			$linkstr3col[$col] .= "<tr><td class=\"fieldnameback fieldname\" align=\"right\">$count.</td><td class=\"databack\"><a href=\"$search_url" . "mylastname=$nosurname&amp;lnqualify=equals&amp;mybool=AND$treestr\">$text[nosurname]</a> ($surname[lncount])</td></tr>\n";
		else
			$linkstr3col[$col] .= "<tr><td class=\"fieldnameback fieldname\" align=\"right\">$count.</td><td class=\"databack\"><a href=\"$search_url" . "mylastname=$surname2&amp;lnqualify=equals&amp;mybool=AND$treestr\">$surname[lowername]</a> ($surname[lncount])</td></tr>";
		$count++;
	}
	mysql_free_result($result);
}
?>

<br />
<ul class="normal"><li><?php echo $text['surnamesstarting']; ?>:<p>
<?php
	echo $linkstr;
?></p></li>
</ul>

<?php
$formstr = getFORM( "surnames100", "get", "", "" );
echo $formstr;
?>

<br />
<ul class="normal">
<li><?php echo $text[showtop]; ?> <input type="text" name="topnum" value="100" size="4" maxlength="4" /> <?php echo $text[byoccurrence]; ?>  <input type="hidden" name="tree" value="<?php echo $tree; ?>" /><input type="submit" value="<?php echo $text[go]; ?>" /></li>
<li><?php echo "<a href=\"$surnames_all_url" . "tree=$tree\">$text[showallsurnames]</a> ($text[sortedalpha])</li>\n"; ?>
</ul>
</form>

<br />
<table>
	<tr>
		<td colspan="4">
			<ul class="normal"><li><span class="normal"><?php echo "$text[firstchars]<br/>$text[byoccurrence] ($text[totalnames]):"; ?>&nbsp;&nbsp;&nbsp;&nbsp;</span></li></ul>
		</td>
		<td>&nbsp;&nbsp;</td>
		<td colspan="2">
			<ul class="normal"><li><span class="normal"><?php echo "$text[top30] ($text[totalnames]):"; ?></span></li></ul>
		</td>
	</tr>
	<tr>
<?php
	for($i=0;$i<4;$i++){
?>
		<td valign="top" style="min-width:65px" class="normal">
<?php
	echo $linkstr2col[$i];
?>
		</td>
<?php
	}
?>
		<td>&nbsp;&nbsp;</td>
<?php
	for($i=0;$i<3;$i++){
?>
		<td valign="top" style="min-width:100px">
			<table class="normal" cellpadding="4" cellspacing="1">
<?php
	echo $linkstr3col[$i];
?>
			</table>
		</td>
<?php
	}
?>
	</tr>
</table>
<br/>
<?php
tng_footer( "" );
?>
