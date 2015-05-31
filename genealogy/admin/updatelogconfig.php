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

	$fp = @fopen( $subroot . "logconfig.php", "w",1 );
	if( !$fp ) { die ( "$admtext[cannotopen] logconfig.php" ); }

	if (get_magic_quotes_gpc() == 0) {
		$lineendingdisplay = addslashes($lineendingdisplay);
	}
	
	flock( $fp, LOCK_EX );

	fwrite( $fp, "<?php\n" );
	fwrite( $fp, "\$logname = \"$logname\";\n" );
	fwrite( $fp, "\$logfile = \$rootpath . \$logname;\n" );
	fwrite( $fp, "\$maxloglines = \"$maxloglines\";\n" );
	fwrite( $fp, "\$badhosts = \"$badhosts\";\n" );
	fwrite( $fp, "\$exusers = \"$exusers\";\n" );
	fwrite( $fp, "\$adminlogfile = \"$adminlogfile\";\n" );
	fwrite( $fp, "\$adminmaxloglines = \"$adminmaxloglines\";\n" );
	fwrite( $fp, "\$addr_exclude = \"$addr_exclude\";\n" );
	fwrite( $fp, "\$msg_exclude = \"$msg_exclude\";\n" );
	fwrite( $fp, "?>\n" );

	flock( $fp, LOCK_UN );
	fclose( $fp );

	adminwritelog( $admtext[modifylogsettings] );

	header( "Location: setup.php" );
?>
