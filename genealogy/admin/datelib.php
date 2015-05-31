<?php
function convertDate( $olddate ) {
	//additional month names (ie, different languages) may be added with same values in case multiple languages are used in the same database
	$months = array( "JAN"=>1, "FEB"=>2, "MAR"=>3, "APR"=>4, "MAY"=>5, "JUN"=>6, "JUL"=>7, "AUG"=>8, "SEP"=>9, "OCT"=>10, "NOV"=>11, "DEC"=>12 );
	//alternatives for "BEF" and "AFT" should be entered in these lists separated by commas
	$befarray = array( "BEF" );
	$aftarray = array( "AFT" );
	$lastday = array( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$preferred_separator = "/";  //this character separates the components in a numeric date, as in "MM/DD/YYYY"
	$numeric_date_order = 0;  //0 = MM/DD/YYYY; 1 = DD/MM/YYYY
	
	if( $olddate ) {
		$olddate = strtoupper(trim( $olddate ));
		$dateparts = array();
		$dateparts = explode(" ",$olddate);
		
		$found = array_search( "TO", $dateparts );
		if( !$found ) $found = array_search( "AND", $dateparts );
		$ptr = $found ? $found - 1 : count($dateparts) - 1;
		
		$newparts = array();
		$newparts = explode($preferred_separator, $dateparts[$ptr] );
		//if number of parts is 3, insert them into array at $ptr, move $ptr up
		if( count( $newparts ) == 3 ) {
			$dateparts[$ptr++] = $newparts[0];
			$dateparts[$ptr++] = $newparts[1];
			$dateparts[$ptr] = $newparts[2];
			$reversedate = $numeric_date_order;
		}
		else
			$reversedate = 0;

		if( substr($dateparts[$ptr],-3,1) == "/" ) {
			$cenlength = strpos($dateparts[$ptr],"/") - 2;
			$century = substr($dateparts[$ptr],0,$cenlength);
			$year1 = substr($dateparts[$ptr],-5,2);
			$year2 = substr($dateparts[$ptr],-2,2);
			if($year1 > $year2) $century++;
			$tempyear = $century . $year2;
		}
		else {
			$len = -1 * strlen($dateparts[$ptr]);
			if($len < -4) $len = -4;
			$tempyear = trim(substr($dateparts[$ptr],$len));
			$dash = strpos($tempyear,"-");
			if($dash !== false)
				$tempyear = substr($tempyear,$dash+1);
		}
		if( is_numeric( $tempyear ) ) {
			$newyear = $tempyear;
			$ptr--;
			
			$tempmonth = substr(strtoupper($dateparts[$ptr]),0,3);
			//if it's in $months, or it's numeric and we're doing dd-mm-yyyy, proceed. If it's numeric and we're doing mm-dd-yyyy, then flip day and month
			$foundit = 0;
			if( $months[$tempmonth] ) {
				$newmonth = $months[$tempmonth];
				$foundit = 1;
			}
			elseif( is_numeric( $tempmonth ) && strlen($tempmonth) <= 2 ) {
				$newmonth = intval( $tempmonth );
				$foundit = 1;
			}
			if( $foundit ) {
				$ptr--;
				
				$tempday = $dateparts[$ptr];
				//if we're doing mm/dd/yyyy, we need to switch month and day here
				//it could be numeric, or it could be in $months, if we've switched.
				if( $reversedate ) {
					$temppart = $newmonth;
					$newmonth = $tempday;
					$tempday = $temppart;
				}
				if( is_numeric( $tempday ) && strlen($tempday) <= 2 ) {
					$newday = sprintf( "%02d", $tempday );
					$ptr--;
					$str = substr(strtoupper($dateparts[$ptr]),0,3);
					if( in_array( $str, $aftarray ) ) {
						$newday++;
						if( $newday > $lastday[$newmonth] ) {
							$newday = 0;
							if( $newmonth == 12 ) $newyear++;
							$newmonth = $newmonth < 12 ? $newmonth + 1 : 1;
						}
					}
					else if( in_array( $str, $befarray ) ) {
						$newday --;
					}
				}
				else {
					$tempday2 = substr(strtoupper($tempday),0,3);
					$newday = 0;
					if( in_array( $tempday2, $aftarray ) ) {
						if( $newmonth == 12 ) $newyear++;
						$newmonth = $newmonth < 12 ? $newmonth + 1 : 1;
					}
				}
			}
			else {
				$newmonth = 0;
				$newday = 0;
				if( in_array( $tempmonth, $aftarray ) ) {
					$newyear++;
				}
			}
		}
		$newdate = sprintf("%04d-%02d-%02d", $newyear,$newmonth,$newday);
	}
	else
		$newdate = "0000-00-00";
	return( $newdate );
}
?>
