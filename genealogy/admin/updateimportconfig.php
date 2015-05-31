<?php
	include("../subroot.php");
	include($subroot . "config.php");
	include("adminlib.php");
	$textpart = "setup";
	include("../getlang.php");
	include("../$mylanguage/admintext.php");
	$link = tng_db_connect($database_host,$database_name,$database_username,$database_password);
	if( $link ) {
		include("checklogin.php");

		if( $assignedtree || !$allow_edit ) {
			$message = "$admtext[norights]";
			header( "Location: login.php?message=" . urlencode($message) );
			exit;
		}
	}

	require("adminlog.php");

	$fp = @fopen( $subroot . "importconfig.php", "w",1 );
	if( !$fp ) { die ( "$admtext[cannotopen] importconfig.php" ); }

	if (get_magic_quotes_gpc() == 0) {
		$localphotopathdisplay = addslashes( $localphotopathdisplay );
		$localhistorypathdisplay = addslashes( $localhistorypathdisplay );
		$localdocumentpathdisplay = addslashes( $localdocumentpathdisplay );
		$localotherpathdisplay = addslashes( $localotherpathdisplay );
	}

	flock( $fp, LOCK_EX );

	fwrite( $fp, "<?php\n" );
	fwrite( $fp, "\$gedpath = \"$gedpath\";\n" );
	fwrite( $fp, "\$saveimport = \"$saveimport\";\n" );
	fwrite( $fp, "\$assignnames = \"$assignnames\";\n" );
	fwrite( $fp, "\$tngimpcfg[defimpopt] = \"$defimpopt\";\n" );
	fwrite( $fp, "\$tngimpcfg[chdate] = \"$blankchangedt\";\n" );
	fwrite( $fp, "\$tngimpcfg[livingreqbirth] = \"$livingreqbirth\";\n" );
	fwrite( $fp, "\$tngimpcfg[maxlivingage] = \"$maxlivingage\";\n" );
	fwrite( $fp, "\$locimppath[photos] = \"$localphotopathdisplay\";\n" );
	fwrite( $fp, "\$locimppath[histories] = \"$localhistorypathdisplay\";\n" );
	fwrite( $fp, "\$locimppath[documents] = \"$localdocumentpathdisplay\";\n" );
	fwrite( $fp, "\$locimppath[headstones] = \"$localhspathdisplay\";\n" );
	fwrite( $fp, "\$locimppath[other] = \"$localotherpathdisplay\";\n" );
	fwrite( $fp, "\$wholepath = \"$wholepath\";\n" );
	fwrite( $fp, "\$tngimpcfg[privnote] = \"$privnote\";\n" );
	fwrite( $fp, "?>\n" );

	flock( $fp, LOCK_UN );
	fclose( $fp );

	adminwritelog( $admtext[modifyimportsettings] );

	header( "Location: setup.php" );
?>
