<?php
if( $session_language )
	$mylanguage = $session_language;
else {
	$newroot = ereg_replace( "/", "", $rootpath );
	$newroot = ereg_replace( " ", "", $newroot );
	$newroot = ereg_replace( "\.", "", $newroot );
	$langcookiename = "tnglang_$newroot";
	$charcookiename = "tngchar_$newroot";

	if( $_COOKIE[$langcookiename] ) {
		$mylanguage = $_COOKIE[$langcookiename];
		$session_language = $_SESSION['session_language'] = $mylanguage;
		$session_charset = $_SESSION['session_charset'] = $_COOKIE[$charcookiename];
	}
	else {
		$mylanguage = $lang ? $lang : $language;
		$session_language = $_SESSION['session_language'] = $language;
	}
}
if( !$session_charset )
	$session_charset = $_SESSION['session_charset'] = ($charset ? $charset : "ISO-8859-1");
?>
