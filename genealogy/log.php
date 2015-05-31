<?php
function writelog( $string ) {
	global $text, $currentuser, $currentuserdesc, $cms, $rootpath, $_SERVER, $time_offset, $subroot;
	
	require($subroot . "logconfig.php");

	if(strpos($string,"http") !== false || strpos($string,"www") != false)
		return;

	if($exusers) {
		$users = explode(",", $exusers);
		if(in_array($currentuser,$users))
			return;
	}

	$remhost = getenv( "REMOTE_HOST" );
	if( !$remhost ) {
		$remhost = $_SERVER['REMOTE_HOST'];
		if( !$remhost ) {
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			    $remip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else
			    $remip = $_SERVER['REMOTE_ADDR'];
			$remhost = @gethostbyaddr( $remip );
			if( !$remhost ) $remhost = $remip;
		}
	}

	if( $badhosts && $remhost ) {
		$terms = explode(",", $badhosts);
		foreach( $terms as $term ) {
			if( $term ) {
				if( strstr( $remhost, trim($term) ) )
					return;
			}
		}
	}

	if( $cms[support] && $currentuser )
		$string .= " $text[accessedby] $text[user]: $currentuser";
	else {
		$string .= " $text[accessedby] $remhost";
		if( $currentuser ) $string .= " ($text[user]: $currentuserdesc)";
	}

	$lines = file( $logfile );
	if( $maxloglines && sizeof( $lines ) >= $maxloglines ) {
		array_pop( $lines );
	}
	$updated = date ("D d M Y h:i:s A", time() + ( 3600 * $time_offset ) );
	array_unshift( $lines, "$updated $string.\n" );
	
	$fp = @fopen( $logfile, "w" );
	if( !$fp ) { die ( "Cannot open $logfile" ); }
	
	flock( $fp, LOCK_EX );
	$linecount = 0;
	foreach ( $lines as $line ) {
		trim( $line );
		if( $line )
			fwrite( $fp, $line );
		$linecount++;
		if( $linecount == $maxloglines ) break;
	}
	flock( $fp, LOCK_UN );
	fclose( $fp );
}

function preparebookmark($string) {
	global $gotlastpage;
	$_SESSION['tnglastpage'] = $string;
	$gotlastpage = true;
}
?>
