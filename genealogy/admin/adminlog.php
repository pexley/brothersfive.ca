<?php
function adminwritelog( $string ) {
	global $admtext, $currentuserdesc, $rootpath, $time_offset, $subroot;
	
	require($subroot . "logconfig.php");

	$string .= " ($admtext[user]: $currentuserdesc)";
		
	$lines = file( $adminlogfile );
	if( $adminmaxloglines && sizeof( $lines ) >= $adminmaxloglines ) {
		array_pop( $lines );
	}
	$updated = date ("D d M Y h:i:s A", time() + ( 3600 * $time_offset ) );
	array_unshift( $lines, "$updated $string.\n" );
	
	$fp = @fopen( $adminlogfile, "w" );
	if( !$fp ) { die ( "Cannot open $adminlogfile" ); }
	
	flock( $fp, LOCK_EX );
	$linecount = 0;
	foreach ( $lines as $line ) {
		trim( $line );
		if( $line )
			fwrite( $fp, $line );
		$linecount++;
		if( $linecount == $adminmaxloglines ) break;
	}
	flock( $fp, LOCK_UN );
	fclose( $fp );
}
?>
