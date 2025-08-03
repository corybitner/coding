<?php 

	function hap_intToBool($value) {
	    return empty($value) ? 'false' : 'true';
	}

	function hap_nullOrEmpty($v){
	    return (!isset($v) || trim($v)==='');
	}

	function hap_compressCss($buffer){
		/* remove comments */
		$buffer = preg_replace("!/\*[^*]*\*+([^/][^*]*\*+)*/!", "", $buffer) ;
		/* remove tabs, spaces, newlines, etc. */
		$arr = array("\r\n", "\r", "\n", "\t", "  ", "    ", "    ");
		$rep = array("", "", "", "", " ", " ", " ");
		$buffer = str_replace($arr, $rep, $buffer);
		/* remove whitespaces around {}:, */
		$buffer = preg_replace("/\s*([\{\}:,])\s*/", "$1", $buffer);
		/* remove last ; */
		$buffer = str_replace(';}', "}", $buffer);
		
		return $buffer;
	}

	function hap_underscoreToCamelCase($string, $capitalizeFirstCharacter = false){
	    $str = str_replace('_', '', ucwords($string, '_'));
	    if (!$capitalizeFirstCharacter) {
	        $str = lcfirst($str);
	    }
	    return $str;
	}

	function hap_removeSlashes($string){
	    $string = implode("",explode("\\",$string));
	    return stripslashes(trim($string));
	}

	function hap_convertTime($time){
	    if ($time < 60) {
	        return $time.' sec';
	    } else if ($time >= 60 && $time < 3600) {
			$min = date("i", mktime(0, 0, $time));
	    	$sec = date("s", mktime(0, 0, $time));
			if($min < 10){
				$min = substr($min, -1);
			}
	        return $min.'.'.$sec.' min';
	    } else if ($time >= 3600 && $time < 86400) {
			$hour = date("H", mktime(0, 0, $time));
			$min = date("i", mktime(0, 0, $time));
			if($hour < 10){
				$hour = substr($hour, -1);
			}
	        return $hour.'.'.$min.' hr';
	    } else if ($time >= 86400 && $time) {
			$day = date("j", mktime(0, 0, $time, 0, 0));
			if($day < 10){
				$day = substr($day, -1);
			}
	        return '~'.$day.' days';
	    }
	}

	function hap_convertCount($num){
		if($num == NULL)return '0';
	    if($num < 1000){
	        return $num;
	    } else {
	        return round(($num / 1000), 2).' K';
	    }
	} 

	function hap_getMasornyWidth($gutter, $number_of_cols){

		$column_width = 100 / $number_of_cols; //a float value, e.g. 33.33333333 in this example
		$item_width_diff = $gutter * ($number_of_cols - 1) / $number_of_cols; //in this example: 10*2/3 = 6.6666666
		if($item_width_diff < 0) $item_width_diff = 0;
		return $item_width_diff;
	}

	function hap_strpos($haystack, $needle, $offset=0) {
	    if(!is_array($needle)) $needle = array($needle);
	    foreach($needle as $query) {
	        if(strpos($haystack, $query, $offset) !== false) return true; 
	    }
	    return false;
	}

	function hap_get_editable_roles() {
	    global $wp_roles;

	    $all_roles = $wp_roles->roles;
	    $editable_roles = apply_filters('editable_roles', $all_roles);

	    return $editable_roles;
	}

	function hap_get_current_user_roles() {
		if( is_user_logged_in() ) {
		    $user = wp_get_current_user();
		    $roles = ( array ) $user->roles;
		    return $roles; 
		} else {
		    return "";
		}
	}

?>