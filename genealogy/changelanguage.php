<?php
include("begin.php");
if($cms['events']){include('cmsevents.php'); cms_register();}
include($cms['tngpath'] . "genlib.php");
$textpart = "language";
include($cms['tngpath'] . "getlang.php");
include($cms['tngpath'] . "$mylanguage/text.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;

$query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
$result = mysql_query($query) or die ("$text[cannotexecutequery]: $query");

$numrows = mysql_num_rows( $result );

tng_header( $text['changelanguage'], $flags );
?>

<span class="header"><?php echo $text['changelanguage']; ?></span><br clear="all" />

<?php 
echo tng_coreicons();

if( $numrows ) {
	$str .= getFORM( "savelanguage", "post", "", "" );
	echo "$str";

	echo "$text[language]: \n";
?>
	<select name="newlanguage">
<?php
	while( $row = mysql_fetch_assoc($result)) {
		echo "<option value=\"$row[languageID]\"";
		if( $row[folder] == $mylanguage )
			echo " selected=\"selected\"";
		echo ">$row[display]</option>\n";
	}
	mysql_free_result($result);
?>
	</select>
	<br/><br/>
	<input type="submit" value="<?php echo $text['savechanges']; ?>">
</form>
<?php
}
else
	echo "$text[language]: $mylanguage\n";

tng_footer( "" );
?>
