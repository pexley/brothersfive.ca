<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "sources";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");

$query = "SELECT $citations_table.sourceID as sourceID, description, page, quay, citedate, citetext, note, title, $citations_table.gedcom as gedcom FROM $citations_table LEFT JOIN $sources_table on $citations_table.sourceID = $sources_table.sourceID AND $sources_table.gedcom = $citations_table.gedcom WHERE citationID = \"$citationID\"";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$row = mysql_fetch_assoc( $result );
mysql_free_result($result);
$row['page'] = ereg_replace("\"", "&#34;",$row['page']);
$row['citetext'] = ereg_replace("\"", "&#34;",$row[citetext]);
$row['note'] = ereg_replace("\"", "&#34;",$row[note]);

$helplang = findhelp("citations_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<p class="subhead"><strong><?php echo $admtext['modifycite']; ?></strong> |
	<a href="javascript:newwindow=window.open('../<?php echo $helplang; ?>/citations_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo $admtext['help']; ?></a></p>

<form action="" name="citeform3" onsubmit="return updateCitation(this);">
<table border="0" cellpadding="2">
	<tr><td valign="top"><span class="normal"><?php echo $admtext['source']; ?>:</span></td>
		<td>
			<span class="normal">
<?php
	if( $row['sourceID'] ) {
?>
			<select name="sourceID">
				<option value=""></option>
<?php
		$query = "SELECT sourceID, title, shorttitle FROM $sources_table WHERE gedcom = \"$row[gedcom]\" ORDER BY title, shorttitle, sourceID";
		$srcresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	
		while ( $source = mysql_fetch_assoc( $srcresult ) ) {
			$sourcetitle = $source['title'] ? $source['title'] : $source['shorttitle'];
			echo "<option value=\"$source[sourceID]\"";
			if( $source[sourceID] == $row[sourceID] ) echo " selected";
			echo ">" . substr($sourcetitle,0,54) . " - $source[sourceID]</option>\n";
		}
		mysql_free_result($srcresult);
?>
			</select><input type="hidden" name="description" value="">
<?php
	}
	else {
		echo "<input type=\"text\" name=\"description\" value=\"$row[description]\"><input type=\"hidden\" name=\"sourceID\" value=\"\">";
	}
?>
			</span>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['page']; ?>:</span></td><td><input type="text" name="citepage" value="<?php echo $row[page]; ?>" size="60"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['reliability']; ?>*:</span></td>
		<td>
			<select name="quay">
				<option value=""></option>
				<option value="0"<?php if( $row['quay'] == "0" ) echo " selected"; ?>>0</option>
				<option value="1"<?php if( $row['quay'] == "1" ) echo " selected"; ?>>1</option>
				<option value="2"<?php if( $row['quay'] == "2" ) echo " selected"; ?>>2</option>
				<option value="3"<?php if( $row['quay'] == "3" ) echo " selected"; ?>>3</option>
			</select> <span class="normal">(<?php echo $admtext['relyexplain']; ?>)</span>
		</td>
	</tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['citedate']; ?>:</span></td><td><input type="text" name="citedate" value="<?php echo $row[citedate]; ?>" size="60" onBlur="checkDate(this);"></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['actualtext']; ?>:</span></td><td><textarea cols="50" rows="5" name="citetext"><?php echo $row[citetext]; ?></textarea></td></tr>
	<tr><td valign="top"><span class="normal"><?php echo $admtext['notes']; ?>:</span></td><td><textarea cols="50" rows="5" name="citenote"><?php echo $row[note]; ?></textarea></td></tr>
</tr>
</table>
<input type="hidden" name="citationID" value="<?php echo $citationID; ?>">
<input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
<input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
<input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onClick="gotoSection('editcitation','citations');">
</form>