<?php
	session_register('logged_in');
	session_register('assignedtree');
	session_register('assignedbranch');
	session_register('postvars');
	session_register('destinationpage');
	session_register('currentuser');
	session_register('currentuserdesc');
	session_register('session_rp');
	session_register('allow_admin_db');
	session_register('allow_edit_db');
	session_register('allow_add_db');
	session_register('tentative_edit_db');
	session_register('allow_delete_db');
	session_register('allow_living_db');
	session_register('allow_lds_db');
	$assignedtree = $_SESSION[assignedtree];
	$assignedbranch = $_SESSION[assignedbranch];
	$currentuser = $_SESSION[currentuser];
	$currentuserdesc = $_SESSION[currentuserdesc];
	$thispage = getScriptName();

	if( !$orgtree && $defaulttree && $assignedtree && $assignedtree != "-x-guest-x-")
		$tree = $assignedtree;

	if( $_SESSION[logged_in] && $_SESSION[session_rp] == $rootpath ) {
		if( $_SESSION[postvars] && is_array( $_SESSION[postvars] ) ) {
			foreach( $_SESSION[postvars] as $key=>$value ) {
				${$key} = $value;
			}
			$postvars = $_SESSION[postvars] = "";
		}
		else {
			$postvars = $_SESSION[postvars] = $_POST;
			if( !$tngprint && !strpos($thispage,"xml") && !$maintenance_mode ) {
				$destinationpage = $_SESSION[destinationpage] = "http://" . $_SERVER['HTTP_HOST'];
				$destinationpage = $_SESSION[destinationpage] .= $thispage;
			}
		}
		$allow_admin_db = $_SESSION[allow_admin_db];
		$allow_edit_db = $_SESSION[allow_edit_db];
		$allow_add_db = $_SESSION[allow_add_db];
		$tentative_edit_db = $_SESSION[tentative_edit_db];
		$allow_delete_db = $_SESSION[allow_delete_db];
		$allow_living_db = $_SESSION[allow_living_db];
		$allow_ged_db = $_SESSION[allow_ged_db];
		$allow_lds_db = $_SESSION[allow_lds_db];

		if( $assignedtree && $assignedtree != $tree )
			$notrighttree = 1;
		else {
			$allow_admin = $_SESSION[allow_admin_db];
			$allow_edit = $_SESSION[allow_edit_db];
			$allow_add = $_SESSION[allow_add_db];
			$tentative_edit = $_SESSION[tentative_edit_db];
			$allow_delete = $_SESSION[allow_delete_db];
			$allow_living = $_SESSION[allow_living_db];
			$allow_ged = $_SESSION[allow_ged_db];
			$allow_lds = $_SESSION[allow_lds_db];
			$notrighttree = 0;
		}
	}
	else {
		$postvars = $_SESSION[postvars] = $_POST;

		if( !strpos($thispage,"xml") && !$maintenance_mode ) {
			$destinationpage = $_SESSION[destinationpage] = "http://" . $_SERVER['HTTP_HOST'];
			$destinationpage = $_SESSION[destinationpage] .= $thispage;
		}
		$newroot = ereg_replace( "/", "", $rootpath );
		$newroot = ereg_replace( " ", "", $newroot );
		$newroot = ereg_replace( "\.", "", $newroot );
		$usercookiename = "tnguser_$newroot";
		$passcookiename = "tngpass_$newroot";
		if( $_COOKIE[$usercookiename] ) {
			header( "Location: processlogin.php?tngusername=" . $_COOKIE[$usercookiename] . "&tngpassword=" . $_COOKIE[$passcookiename] . "&encrypted=1" );
			exit;
		}
		if( $requirelogin ) {
			if( !substr_count( $_SERVER['SCRIPT_NAME'], "/index." ) ) {
				$login_noargs_url = getURL( "login", 0 );
				header( "Location: $login_noargs_url" );
				exit;
			}
		}
		else {
			$query = "SELECT userID FROM $users_table";
			$result = @mysql_query($query);
			if( $result && mysql_num_rows( $result ) ) {
				$notrighttree = 1;
				$flagval = 0;
				$_SESSION[currentuser] = "";
				$_SESSION[currentuserdesc] = "";
				$_SESSION[assignedtree] = "-x-guest-x-";
			}
			else {
				$notrighttree = 0;
				$flagval = 1;
				$allow_admin = 1;
				$allow_edit = 1;
				$allow_add = 1;
				$tentative_edit = 0;
				$allow_delete = 1;
				$allow_living = 1;
				$allow_ged = 1;
				$allow_lds = 1;
				$_SESSION[currentuser] = "Administrator";
				$_SESSION[currentuserdesc] = "Administrator";
				$_SESSION[assignedtree] = "";
			}
			$_SESSION[allow_admin_db] = $allow_admin_db = $flagval;
			$_SESSION[allow_edit_db] = $allow_edit_db = $flagval;
			$_SESSION[allow_add_db] = $allow_add_db = $flagval;
			$_SESSION[tentative_edit_db] = $tentative_edit_db = 0;
			$_SESSION[allow_delete_db] = $allow_delete_db = $flagval;
			$_SESSION[allow_living_db] = $allow_living_db = $livedefault != 2 ? $flagval : 1;
			$_SESSION[allow_ged_db] = $allow_ged_db = $flagval;
			$_SESSION[allow_lds_db] = $allow_lds_db = $ldsdefault ? $flagval : 1;

			$logged_in = $_SESSION[logged_in] = 1;
			$assignedtree = $_SESSION[assignedtree];
			$currentuser = $_SESSION[currentuser];
			$currentuserdesc = $_SESSION[currentuserdesc];
			$_SESSION[session_rp] = $rootpath;

			if( !$orgtree && $defaulttree && $assignedtree && $assignedtree != "-x-guest-x-")
				$tree = $assignedtree;
		}
	}
	if( $notrighttree ) {
		$allow_admin = 0;
		$allow_edit = 0;
		$allow_add = 0;
		$tentative_edit = 0;
		$allow_delete = 0;
		$allow_living = $livedefault == 2 ? 1 : 0;
		$allow_ged = 0;
		$allow_lds = $ldsdefault ? 0 : 1;
	}

	$postvars = $_SESSION[postvars] = "";
	unset( $_SESSION[postvars] );
?>