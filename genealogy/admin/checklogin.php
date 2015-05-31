<?php
	session_register('logged_in');
	session_register('assignedtree');
	session_register('assignedbranches');
	session_register('postvars');
	session_register('destinationpage');
	session_register('currentuser');
	session_register('currentuserdesc');
	session_register('allow_admin_db');
	session_register('allow_edit_db');
	session_register('allow_add_db');
	session_register('tentative_edit_db');
	session_register('allow_delete_db');
	session_register('allow_living_db');
	session_register('allow_ged_db');
	session_register('allow_lds_db');
	session_register('session_rp');
	$assignedtree = $_SESSION[assignedtree];
	$assignedbranch = $_SESSION[assignedbranch];
	$currentuser = $_SESSION[currentuser];
	$currentuserdesc = $_SESSION[currentuserdesc];
	
	if( $_SESSION[logged_in] && $_SESSION[allow_admin_db] && $currentuser && $_SESSION[session_rp] == $rootpath) {
		if( $_SESSION[postvars] && is_array( $_SESSION[postvars] ) ) {
			foreach( $_SESSION[postvars] as $key=>$value ) {
				${$key} = $value;
			}
			$_SESSION[postvars] = "";
		}
		$allow_admin = $_SESSION[allow_admin_db];
		$allow_edit = $_SESSION[allow_edit_db];
		$allow_add = $_SESSION[allow_add_db];
		$tentative_edit = $_SESSION[tentative_edit_db];
		$allow_delete = $_SESSION[allow_delete_db];
		$allow_living = $_SESSION[allow_living_db];
		$allow_ged = $_SESSION[allow_ged_db];
		$allow_lds = $_SESSION[allow_lds_db];
	}
	else {
		if( mysql_select_db($database_name) ) {
			$query = "SELECT count(userID) as ucount FROM $users_table";
			$result = @mysql_query($query);
			if( $result )
				$row = mysql_fetch_assoc($result);
			else
				$row[ucount] = 0;
		}
		else
			$row[ucount] = 0;

		if( $row[ucount] ) {
			$postvars = $_SESSION[postvars] = $_POST;
			$destinationpage = $_SESSION[destinationpage] = "http://" . $_SERVER['HTTP_HOST'];
			$destinationpage = $_SESSION[destinationpage] .= $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'];
			$newroot = ereg_replace( "/", "", $rootpath );
			$newroot = ereg_replace( " ", "", $newroot );
			$newroot = ereg_replace( "\.", "", $newroot );
			$usercookiename = "tnguser_$newroot";
			$passcookiename = "tngpass_$newroot";
			if( $_COOKIE[$usercookiename] )
				header( "Location: processlogin.php?tngusername=" . $_COOKIE[$usercookiename] . "&tngpassword=" . $_COOKIE[$passcookiename] . "&encrypted=1" );
			else
				header( "Location: login.php" );
			exit;
		}
		else {
			$logged_in = $_SESSION[logged_in] = 1;
			$assignedtree = $_SESSION[assignedtree] = "";
			$assignedbranch = $_SESSION[assignedbranch] = "";
			$currentuser = $_SESSION[currentuser] = "-x-admin-x-";
			$currentuserdesc = $_SESSION[currentuserdesc] = "Administrator";
			$sesssion_rp = $_SESSION[session_rp] = $rootpath;
			$allow_admin = $_SESSION[allow_admin_db] = 1;
			$allow_edit = $_SESSION[allow_edit_db] = 1;
			$allow_add = $_SESSION[allow_add_db] = 1;
			$tentative_edit = $_SESSION[tentative_edit_db] = 0;
			$allow_delete = $_SESSION[allow_delete_db] = 1;
			$allow_living = $_SESSION[allow_living_db] = 1;
			$allow_ged = $_SESSION[allow_ged_db] = 1;
			if( $ldsdefault == 1 ) //never do lds
				$allow_lds = $_SESSION[allow_lds_db] = 0;
			else
				$allow_lds = $_SESSION[allow_lds_db] = 1;
		}
	}
?>
