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

	$fp = @fopen( $subroot . "pedconfig.php", "w",1 );
	if( !$fp ) { die ( "$admtext[cannotopen] pedconfig.php" ); }

	flock( $fp, LOCK_EX );

	fwrite( $fp, "<?php\n" );
	fwrite( $fp, "\$pedigree[leftindent] = \"$leftindent\";\n" );
	fwrite( $fp, "\$pedigree[boxnamesize] = \"$boxnamesize\";\n" );
	fwrite( $fp, "\$pedigree[boxdatessize] = \"$boxdatessize\";\n" );
	fwrite( $fp, "\$pedigree[boxcolor] = \"$boxcolor\";\n" );
	fwrite( $fp, "\$pedigree[colorshift] = \"$colorshift\";\n" );
	fwrite( $fp, "\$pedigree[emptycolor] = \"$emptycolor\";\n" );
	fwrite( $fp, "\$pedigree[hideempty] = \"$hideempty\";\n" );
	fwrite( $fp, "\$pedigree[bordercolor] = \"$bordercolor\";\n" );
	fwrite( $fp, "\$pedigree[shadowcolor] = \"$shadowcolor\";\n" );
	fwrite( $fp, "\$pedigree[boxwidth] = \"$boxwidth\";\n" );
	fwrite( $fp, "\$pedigree[boxheight] = \"$boxheight\";\n" );
	fwrite( $fp, "\$pedigree[boxalign] = \"$boxalign\";\n" );
	fwrite( $fp, "\$pedigree[boxheightshift] = \"$boxheightshift\";\n" );
	fwrite( $fp, "\$pedigree[boxHsep] = \"$boxHsep\";\n" );
	fwrite( $fp, "\$pedigree[boxVsep] = \"$boxVsep\";\n" );
	fwrite( $fp, "\$pedigree[shadowoffset] = \"$shadowoffset\";\n" );
	fwrite( $fp, "\$pedigree[linewidth] = \"$linewidth\";\n" );
	fwrite( $fp, "\$pedigree[borderwidth] = \"$borderwidth\";\n" );
	fwrite( $fp, "\$pedigree[usepopups] = \"$usepopups\";\n" );
	fwrite( $fp, "\$pedigree[popupcolor] = \"$popupcolor\";\n" );
	fwrite( $fp, "\$pedigree[popupinfosize] = \"$popupinfosize\";\n" );
	fwrite( $fp, "\$pedigree[popupspouses] = \"$popupspouses\";\n" );
	fwrite( $fp, "\$pedigree[popupkids] = \"$popupkids\";\n" );
	fwrite( $fp, "\$pedigree[popupchartlinks] = \"$popupchartlinks\";\n" );
	fwrite( $fp, "\$pedigree[popuptimer] = $popuptimer;\n" );
	fwrite( $fp, "\$pedigree[event] = $pedevent;\n" );
	fwrite( $fp, "\$pedigree[puboxwidth] = \"$puboxwidth\";\n" );
	fwrite( $fp, "\$pedigree[puboxheight] = \"$puboxheight\";\n" );
	fwrite( $fp, "\$pedigree[puboxalign] = \"$puboxalign\";\n" );
	fwrite( $fp, "\$pedigree[puboxheightshift] = \"$puboxheightshift\";\n" );
	fwrite( $fp, "\$pedigree[inclphotos] = \"$inclphotos\";\n" );
	fwrite( $fp, "\$pedigree[maxgen] = \"$maxgen\";\n" );
	fwrite( $fp, "\$pedigree[initpedgens] = \"$initpedgens\";\n" );
	fwrite( $fp, "\$pedigree[maxupgen] = \"$maxupgen\";\n" );

	fwrite( $fp, "\$pedigree[maxdesc] = \"$maxdesc\";\n" );
	fwrite( $fp, "\$pedigree[initdescgens] = \"$initdescgens\";\n" );
	fwrite( $fp, "\$pedigree[defdesc] = \"$defdesc\";\n" );
	fwrite( $fp, "\$pedigree[stdesc] = \"$stdesc\";\n" );
	fwrite( $fp, "\$pedigree[regnotes] = \"$regnotes\";\n" );
	fwrite( $fp, "\$pedigree[regnosp] = \"$regnosp\";\n" );

	fwrite( $fp, "?>\n" );

	flock( $fp, LOCK_UN );
	fclose( $fp );

	adminwritelog( $admtext[modifypedsettings] );

	header( "Location: setup.php" );
?>
