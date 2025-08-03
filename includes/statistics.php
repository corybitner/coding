<?php

	function hap_getTopPlayToday($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($playlist_id == '-1'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, c_play AS total_count FROM {$statistics_table} WHERE c_date= CURDATE() GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);
			
		}else if($playlist_id == '-2'){	
			$results = $wpdb->get_results($wpdb->prepare("SELECT artist, title, thumb, audio_url, c_play AS total_count FROM {$statistics_table} WHERE c_date= CURDATE() AND media_id IS null GROUP BY artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, c_play AS total_count FROM {$statistics_table} WHERE c_date= CURDATE() AND playlist_id = %d GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, c_play AS total_count FROM {$statistics_table} WHERE c_date= CURDATE() AND player_id = %d GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;

	}

	function hap_getTopPlayTodayForPlayback($playlist_id, $limit = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $media_table = $wpdb->prefix . "map_media";

	    $stmt = $wpdb->prepare("SELECT mt.id, mt.options, SUM(st.c_play) AS total_count
		FROM $media_table as mt
		LEFT JOIN $statistics_table st on mt.id = st.media_id 
		WHERE st.media_id IS NOT NULL AND st.playlist_id = %d AND st.c_date = CURDATE()  
		GROUP BY st.media_id
		HAVING SUM(st.c_play) > 0
		ORDER BY total_count DESC
		LIMIT 0, %d", $playlist_id, $limit);

		$results = $wpdb->get_results($stmt, ARRAY_A);

		return $results;

	}

	function hap_getTopPlayLastXDays($playlist_id, $x, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($playlist_id == '-1'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date > NOW() - INTERVAL %d DAY GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $x, $limit), ARRAY_A);

		}else if($playlist_id == '-2'){	
			$results = $wpdb->get_results($wpdb->prepare("SELECT artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date > NOW() - INTERVAL %d DAY AND media_id IS null GROUP BY artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $x, $limit), ARRAY_A);

		}else{
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date > NOW() - INTERVAL %d DAY AND playlist_id = %d GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $x, $playlist_id, $limit), ARRAY_A);
		}

		return $results;

	}

	function hap_getTopPlayLastXDaysForPlayback($playlist_id, $days, $limit = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $media_table = $wpdb->prefix . "map_media";

	    $stmt = $wpdb->prepare("SELECT mt.id, mt.options, SUM(st.c_play) AS total_count
		FROM $media_table as mt
		LEFT JOIN $statistics_table st on mt.id = st.media_id 
		WHERE st.media_id IS NOT NULL AND st.playlist_id = %d AND st.c_date > NOW() - INTERVAL %d DAY  
		GROUP BY st.media_id
		HAVING SUM(st.c_play) > 0
		ORDER BY total_count DESC
		LIMIT 0, %d", $playlist_id, $days, $limit);

		$results = $wpdb->get_results($stmt, ARRAY_A);

		return $results;

	}

	function hap_getTopPlayThisWeek($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';
		
		if($playlist_id == '-1'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date > DATE_SUB(DATE_FORMAT(NOW(),'%Y-%m-01'), INTERVAL DAYOFWEEK(DATE_FORMAT(NOW(),'%Y-%m-01')) - 1 DAY) GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id == '-2'){	
			$results = $wpdb->get_results($wpdb->prepare("SELECT artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date > DATE_SUB(DATE_FORMAT(NOW(),'%Y-%m-01'), INTERVAL DAYOFWEEK(DATE_FORMAT(NOW(),'%Y-%m-01')) - 1 DAY) AND media_id IS null GROUP BY artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date > DATE_SUB(DATE_FORMAT(NOW(),'%Y-%m-01'), INTERVAL DAYOFWEEK(DATE_FORMAT(NOW(),'%Y-%m-01')) - 1 DAY) AND playlist_id = %d GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date > DATE_SUB(DATE_FORMAT(NOW(),'%Y-%m-01'), INTERVAL DAYOFWEEK(DATE_FORMAT(NOW(),'%Y-%m-01')) - 1 DAY) AND player_id = %d GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;
	}

	function hap_getTopPlayThisWeekForPlayback($playlist_id, $limit = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $media_table = $wpdb->prefix . "map_media";

	    $stmt = $wpdb->prepare("SELECT mt.id, mt.options, SUM(st.c_play) AS total_count
		FROM $media_table as mt
		LEFT JOIN $statistics_table st on mt.id = st.media_id 
		WHERE st.media_id IS NOT NULL AND st.playlist_id = %d AND st.c_date > DATE_SUB(DATE_FORMAT(NOW(),'%Y-%m-01'), INTERVAL DAYOFWEEK(DATE_FORMAT(NOW(),'%Y-%m-01')) - 1 DAY)
		GROUP BY st.media_id
		HAVING SUM(st.c_play) > 0
		ORDER BY total_count DESC
		LIMIT 0, %d", $playlist_id, $limit);

		$results = $wpdb->get_results($stmt, ARRAY_A);

		return $results;

	}

	function hap_getTopPlayThisMonth($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';
		
		if($playlist_id == '-1'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date >= DATE_FORMAT(NOW(),'%Y-%m-01') GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id == '-2'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date >= DATE_FORMAT(NOW(),'%Y-%m-01') AND media_id IS null GROUP BY artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date >= DATE_FORMAT(NOW(),'%Y-%m-01') AND playlist_id = %d GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE c_date >= DATE_FORMAT(NOW(),'%Y-%m-01') AND player_id = %d GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;
	}

	function hap_getTopPlayThisMonthForPlayback($playlist_id, $limit = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $media_table = $wpdb->prefix . "map_media";

	    $stmt = $wpdb->prepare("SELECT mt.id, mt.options, SUM(st.c_play) AS total_count
		FROM $media_table as mt
		LEFT JOIN $statistics_table st on mt.id = st.media_id 
		WHERE st.media_id IS NOT NULL AND st.playlist_id = %d AND st.c_date > DATE_FORMAT(NOW(),'%Y-%m-01')
		GROUP BY st.media_id
		HAVING SUM(st.c_play) > 0
		ORDER BY total_count DESC
		LIMIT 0, %d", $playlist_id, $limit);

		$results = $wpdb->get_results($stmt, ARRAY_A);

		return $results;
	
	}

	function hap_getTopPlayAllTime($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($playlist_id == '-1'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id == '-2'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE media_id IS null GROUP BY artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE playlist_id = %d GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_play) AS total_count FROM {$statistics_table} WHERE player_id = %d GROUP BY media_id, artist, title HAVING SUM(c_play) > 0 ORDER BY total_count $dir LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;

	}

	function hap_getTopPlayAllTimeForPlayback($playlist_id, $limit = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $media_table = $wpdb->prefix . "map_media";

	    $stmt = $wpdb->prepare("SELECT mt.id, mt.options, SUM(st.c_play) AS total_count
		FROM $media_table as mt
		LEFT JOIN $statistics_table st on mt.id = st.media_id 
		WHERE st.media_id IS NOT NULL AND st.playlist_id = %d 
		GROUP BY st.media_id
		HAVING SUM(st.c_play) > 0
		ORDER BY total_count DESC
		LIMIT 0, %d", $playlist_id, $limit);

		$results = $wpdb->get_results($stmt, ARRAY_A);

		return $results;
	
	}

	function hap_getTopDownloadAllTime($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($playlist_id == '-1'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_download) AS total_count FROM {$statistics_table} GROUP BY media_id, artist, title HAVING SUM(c_download) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);
		

		}else if($playlist_id == '-2'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT artist, title, thumb, audio_url, SUM(c_download) AS total_count FROM {$statistics_table} WHERE media_id IS null GROUP BY artist, title HAVING SUM(c_download) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_download) AS total_count FROM {$statistics_table} WHERE playlist_id = %d GROUP BY media_id, artist, title HAVING SUM(c_download) > 0 ORDER BY total_count $dir LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_download) AS total_count FROM {$statistics_table} WHERE player_id = %d GROUP BY media_id, artist, title HAVING SUM(c_download) > 0 ORDER BY total_count $dir LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;

	}

	function hap_getTopDownloadAllTimeForPlayback($playlist_id, $limit = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $media_table = $wpdb->prefix . "map_media";

	    $stmt = $wpdb->prepare("SELECT mt.id, mt.options, SUM(st.c_download) AS total_count
		FROM $media_table as mt
		LEFT JOIN $statistics_table st on mt.id = st.media_id 
		WHERE st.media_id IS NOT NULL AND st.playlist_id = %d 
		GROUP BY st.media_id
		HAVING SUM(st.c_download) > 0
		ORDER BY total_count DESC
		LIMIT 0, %d", $playlist_id, $limit);

		$results = $wpdb->get_results($stmt, ARRAY_A);

		return $results;
	
	}

	function hap_getTopLikeAllTime($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($playlist_id == '-1'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_like) AS total_count FROM {$statistics_table} GROUP BY media_id, artist, title HAVING SUM(c_like) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id == '-2'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT artist, title, thumb, audio_url, SUM(c_like) AS total_count FROM {$statistics_table} WHERE media_id IS null GROUP BY artist, title HAVING SUM(c_like) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_like) AS total_count FROM {$statistics_table} WHERE playlist_id = %d GROUP BY media_id, artist, title HAVING SUM(c_like) > 0 ORDER BY total_count $dir LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_like) AS total_count FROM {$statistics_table} WHERE player_id = %d GROUP BY media_id, artist, title HAVING SUM(c_like) > 0 ORDER BY total_count $dir LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;

	}

	function hap_getTopLikeAllTimeForPlayback($playlist_id, $limit = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $media_table = $wpdb->prefix . "map_media";

	    $stmt = $wpdb->prepare("SELECT mt.id, mt.options, SUM(st.c_like) AS total_count
		FROM $media_table as mt
		LEFT JOIN $statistics_table st on mt.id = st.media_id 
		WHERE st.media_id IS NOT NULL AND st.playlist_id = %d 
		GROUP BY st.media_id
		HAVING SUM(st.c_like) > 0
		ORDER BY total_count DESC
		LIMIT 0, %d", $playlist_id, $limit);

		$results = $wpdb->get_results($stmt, ARRAY_A);

		return $results;

	}

	function hap_getTopFinishAllTime($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($playlist_id == '-1'){

			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_finish) AS total_count FROM {$statistics_table} GROUP BY media_id, artist, title HAVING SUM(c_finish) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id == '-2'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT artist, title, thumb, audio_url, SUM(c_finish) AS total_count FROM {$statistics_table} WHERE media_id IS null GROUP BY artist, title HAVING SUM(c_finish) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_finish) AS total_count FROM {$statistics_table} WHERE playlist_id = %d GROUP BY media_id, artist, title HAVING SUM(c_finish) > 0 ORDER BY total_count $dir LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(c_finish) AS total_count FROM {$statistics_table} WHERE player_id = %d GROUP BY media_id, artist, title HAVING SUM(c_finish) > 0 ORDER BY total_count $dir LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;

	}

	function hap_getTopFinishAllTimeForPlayback($playlist_id, $limit = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $media_table = $wpdb->prefix . "map_media";

	    $stmt = $wpdb->prepare("SELECT mt.id, mt.options, SUM(st.c_finish) AS total_count
		FROM $media_table as mt
		LEFT JOIN $statistics_table st on mt.id = st.media_id 
		WHERE st.media_id IS NOT NULL AND st.playlist_id = %d 
		GROUP BY st.media_id
		HAVING SUM(st.c_finish) > 0
		ORDER BY total_count DESC
		LIMIT 0, %d", $playlist_id, $limit);

		$results = $wpdb->get_results($stmt, ARRAY_A);

		return $results;

	}

	function hap_getTopSkipFirstMinAllTime($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($playlist_id == '-1'){

			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(skipped_first_minute) AS total_count FROM {$statistics_table} GROUP BY media_id, artist, title HAVING SUM(skipped_first_minute) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id == '-2'){
			$results = $wpdb->get_results($wpdb->prepare("SELECT artist, title, thumb, audio_url, SUM(skipped_first_minute) AS total_count FROM {$statistics_table} WHERE media_id IS null GROUP BY artist, title HAVING SUM(skipped_first_minute) > 0 ORDER BY total_count $dir LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(skipped_first_minute) AS total_count FROM {$statistics_table} WHERE playlist_id = %d GROUP BY media_id, artist, title HAVING SUM(skipped_first_minute) > 0 ORDER BY total_count $dir LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, thumb, audio_url, SUM(skipped_first_minute) AS total_count FROM {$statistics_table} WHERE player_id = %d GROUP BY media_id, artist, title HAVING SUM(skipped_first_minute) > 0 ORDER BY total_count $dir LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;

	}

	function hap_getTopPlaysPerCountryAllTime($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $statistics_country_table = $wpdb->prefix . "map_statistics_country";
	    $statistics_country_play_table = $wpdb->prefix . "map_statistics_country_play";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($playlist_id == '-1'){

			$results = $wpdb->get_results($wpdb->prepare("
				SELECT scpt.media_id, scpt.artist, scpt.title, scpt.thumb, SUM(scpt.c_play) AS total_count, SUM(scpt.c_time) AS c_time, sct.country, sct.country_code, sct.continent     
				FROM $statistics_country_play_table as scpt 
				LEFT JOIN $statistics_country_table sct on scpt.country_id = sct.id 
				GROUP BY sct.country 
				HAVING SUM(scpt.c_play) > 0 
				ORDER BY total_count $dir 
				LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id == '-2'){
			
			$results = array();

		}else if($playlist_id != null){
	
			$results = $wpdb->get_results($wpdb->prepare("
				SELECT scpt.media_id, scpt.artist, scpt.title, scpt.thumb, SUM(scpt.c_play) AS total_count, SUM(scpt.c_time) AS c_time, sct.country, sct.country_code, sct.continent    
				FROM $statistics_country_play_table as scpt 
				LEFT JOIN $statistics_country_table sct on scpt.country_id = sct.id 
				WHERE playlist_id = %d
				GROUP BY sct.country 
				HAVING SUM(scpt.c_play) > 0 
				ORDER BY total_count $dir 
				LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){

			$results = $wpdb->get_results($wpdb->prepare("
				SELECT scpt.media_id, scpt.artist, scpt.title, scpt.thumb, SUM(scpt.c_play) AS total_count, SUM(scpt.c_time) AS c_time, sct.country, sct.country_code, sct.continent     
				FROM $statistics_country_play_table as scpt 
				LEFT JOIN $statistics_country_table sct on scpt.country_id = sct.id 
				WHERE player_id = %d
				GROUP BY sct.country 
				HAVING SUM(scpt.c_play) > 0 
				ORDER BY total_count $dir 
				LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;

	}

	function hap_getTopPlaysPerUserAllTime($playlist_id = null, $player_id = null, $limit = null, $dir = null){

		global $wpdb;
	    $statistics_user_table = $wpdb->prefix . "map_statistics_user";
	    $statistics_user_play_table = $wpdb->prefix . "map_statistics_user_play";

		$results;
		$limit = isset($limit) ? $limit : 10;
		$dir = isset($dir) ? strtoupper($dir) : 'DESC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($playlist_id == '-1'){

			$results = $wpdb->get_results($wpdb->prepare("
				SELECT supt.media_id, supt.artist, supt.title, supt.thumb, SUM(supt.c_play) AS total_count, SUM(supt.c_time) AS c_time, sut.user_id, sut.user_display_name, sut.user_role
				FROM $statistics_user_play_table as supt 
				LEFT JOIN $statistics_user_table sut on supt.user_id = sut.id 
				GROUP BY sut.user_id 
				HAVING SUM(supt.c_play) > 0 
				ORDER BY total_count $dir 
				LIMIT 0,%d", $limit), ARRAY_A);

		}else if($playlist_id == '-2'){
			
			$results = array();

		}else if($playlist_id != null){

				$results = $wpdb->get_results($wpdb->prepare("
				SELECT supt.media_id, supt.artist, supt.title, supt.thumb, SUM(supt.c_play) AS total_count, SUM(supt.c_time) AS c_time, sut.user_id, sut.user_display_name, sut.user_role
				FROM $statistics_user_play_table as supt 
				LEFT JOIN $statistics_user_table sut on supt.user_id = sut.id 
				WHERE playlist_id = %d
				GROUP BY sut.user_id 
				HAVING SUM(supt.c_play) > 0 
				ORDER BY total_count $dir 
				LIMIT 0,%d", $playlist_id, $limit), ARRAY_A);
		
		}else if($player_id != null){

			$results = $wpdb->get_results($wpdb->prepare("
				SELECT supt.media_id, supt.artist, supt.title, supt.thumb, SUM(supt.c_play) AS total_count, SUM(supt.c_time) AS c_time, sut.user_id, sut.user_display_name, sut.user_role
				FROM $statistics_user_play_table as supt 
				LEFT JOIN $statistics_user_table sut on supt.user_id = sut.id 
				WHERE player_id = %d
				GROUP BY sut.user_id 
				HAVING SUM(supt.c_play) > 0 
				ORDER BY total_count $dir 
				LIMIT 0,%d", $player_id, $limit), ARRAY_A);
		}

		return $results;

	}

	function hap_getTopPlaysPerUserForSongAllTime($playlist_id, $media_id, $limit = null){

		global $wpdb;
	    $statistics_user_table = $wpdb->prefix . "map_statistics_user";
	    $statistics_user_play_table = $wpdb->prefix . "map_statistics_user_play";

		$results;
		$limit = isset($limit) ? $limit : 10;

		$results = $wpdb->get_results($wpdb->prepare("
		SELECT supt.media_id, supt.artist, supt.title, supt.thumb, SUM(supt.c_play) AS total_count, SUM(supt.c_time) AS c_time, sut.user_id, sut.user_display_name, sut.user_role
		FROM $statistics_user_play_table as supt 
		LEFT JOIN $statistics_user_table sut on supt.user_id = sut.id 
		WHERE playlist_id = %d AND media_id = %d
		GROUP BY sut.user_id 
		HAVING SUM(supt.c_play) > 0 
		ORDER BY total_count DESC
		LIMIT 0,%d", $playlist_id, $media_id, $limit), ARRAY_A);
	

		return $results;

	}

	function hap_getTotalForSongLastXDays($media_id, $title, $artist, $x, $data_display){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

	    $str = implode(", ",$data_display);

		$results = $wpdb->get_results($wpdb->prepare("SELECT {$str}, c_date FROM {$statistics_table} WHERE media_id = %d AND title = %s AND artist = %s AND c_date > NOW() - INTERVAL %d DAY ORDER BY c_date", $media_id, $title, $artist, $x), ARRAY_A);

		return $results;

	}

	function hap_getTotalForSongRange($playlist_id = null, $player_id = null, $media_id = null, $title = null, $artist = null, $start = null, $end = null, $data_display = null, $display_type = null){

		$start = '2020-03-13';
		$end = '2020-12-21';
		$media_id = 34;
		$title = 'Orinoco Flow';
		$artist = 'Enya';

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

	    $str = implode(", ",$data_display);

	    if($display_type == 'daily'){

		    if($playlist_id == '-1'){

				$results = $wpdb->get_results($wpdb->prepare("SELECT {$str}, c_date FROM {$statistics_table} WHERE media_id = %d AND title = %s AND artist = %s AND c_date BETWEEN %s AND %s ORDER BY c_date", $media_id, $title, $artist, $start, $end), ARRAY_A);

			}else if($playlist_id != null){

				$results = $wpdb->get_results($wpdb->prepare("SELECT {$str}, c_date FROM {$statistics_table} WHERE media_id = %d AND title = %s AND artist = %s AND playlist_id = %d AND c_date BETWEEN %s AND %s ORDER BY c_date", $media_id, $title, $artist, $playlist_id, $start, $end), ARRAY_A);

			}else if($player_id != null){	

				$results = $wpdb->get_results($wpdb->prepare("SELECT {$str}, c_date FROM {$statistics_table} WHERE media_id = %d AND title = %s AND artist = %s AND player_id = %d AND c_date BETWEEN %s AND %s ORDER BY c_date", $media_id, $title, $artist, $player_id, $start, $end), ARRAY_A);

			}

		}else{

			//monthly
			if($playlist_id == '-1'){
				
				$results = $wpdb->get_results($wpdb->prepare("SELECT {$str}, c_date FROM {$statistics_table} WHERE media_id = %d AND title = %s AND artist = %s AND c_date BETWEEN %s AND %s GROUP BY YEAR(c_date), MONTH(c_date) ORDER BY c_date ", $media_id, $title, $artist, $start, $end), ARRAY_A);

			}else if($playlist_id != null){

				$results = $wpdb->get_results($wpdb->prepare("SELECT {$str}, c_date FROM {$statistics_table} WHERE media_id = %d AND title = %s AND artist = %s AND playlist_id = %d AND c_date BETWEEN %s AND %s GROUP BY YEAR(c_date), MONTH(c_date) ORDER BY c_date ", $media_id, $title, $artist, $playlist_id, $start, $end), ARRAY_A);

			}else if($player_id != null){

				$results = $wpdb->get_results($wpdb->prepare("SELECT {$str}, c_date FROM {$statistics_table} WHERE media_id = %d AND title = %s AND artist = %s AND player_id = %d AND c_date BETWEEN %s AND %s GROUP BY YEAR(c_date), MONTH(c_date) ORDER BY c_date ", $media_id, $title, $artist, $player_id, $start, $end), ARRAY_A);
			}

		}

		return $results;

	}

	function hap_getTotal($playlist_id = null, $player_id = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;

		if($playlist_id == '-1'){
			$results = $wpdb->get_row("SELECT SUM(c_play) AS c_play, SUM(c_time) AS c_time, SUM(c_download) AS c_download, SUM(c_finish) AS c_finish, SUM(c_like) AS c_like FROM {$statistics_table}", ARRAY_A);
			

		}else if($playlist_id == '-2'){
			$results = $wpdb->get_row("SELECT SUM(c_play) AS c_play, SUM(c_time) AS c_time, SUM(c_download) AS c_download, SUM(c_finish) AS c_finish, SUM(c_like) AS c_like FROM {$statistics_table} WHERE media_id IS null", ARRAY_A);
		
		}else if($playlist_id != null){
			$results = $wpdb->get_row($wpdb->prepare("SELECT SUM(c_play) AS c_play, SUM(c_time) AS c_time, SUM(c_download) AS c_download, SUM(c_finish) AS c_finish, SUM(c_like) AS c_like FROM {$statistics_table} WHERE playlist_id = %d", $playlist_id), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_row($wpdb->prepare("SELECT SUM(c_play) AS c_play, SUM(c_time) AS c_time, SUM(c_download) AS c_download, SUM(c_finish) AS c_finish, SUM(c_like) AS c_like FROM {$statistics_table} WHERE player_id = %d", $player_id), ARRAY_A);
		}

		return $results;

	}

	function hap_getAll($playlist_id = null, $player_id = null, $order = null, $dir = null){

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

		$results;
		$dir = isset($dir) ? strtoupper($dir) : 'ASC';
		if(!($dir == 'DESC' || $dir == 'ASC'))$dir = 'DESC';

		if($order == 'play')$order = 'total_play';
		else if($order == 'time')$order = 'total_time';
		else if($order == 'like')$order = 'total_like';
		else if($order == 'finish')$order = 'total_finish';
		else if($order == 'download')$order = 'total_download';

		if($playlist_id == '-1'){
			$results = $wpdb->get_results("SELECT media_id, artist, title, SUM(c_play) AS total_play, SUM(c_time) AS total_time, SUM(c_download) AS total_download, SUM(c_finish) AS total_finish, SUM(c_like) AS total_like FROM {$statistics_table} GROUP BY media_id, artist, title ORDER BY $order $dir", ARRAY_A);

		}else if($playlist_id == '-2'){
			$results = $wpdb->get_results("SELECT artist, title, SUM(c_play) AS total_play, SUM(c_time) AS total_time, SUM(c_download) AS total_download, SUM(c_finish) AS total_finish, SUM(c_like) AS total_like FROM {$statistics_table} WHERE media_id IS null GROUP BY artist, title ORDER BY $order $dir", ARRAY_A);

		}else if($playlist_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, SUM(c_play) AS total_play, SUM(c_time) AS total_time, SUM(c_download) AS total_download, SUM(c_finish) AS total_finish, SUM(c_like) AS total_like FROM {$statistics_table} WHERE playlist_id = %d GROUP BY media_id, artist, title ORDER BY $order $dir", $playlist_id), ARRAY_A);
		
		}else if($player_id != null){
			$results = $wpdb->get_results($wpdb->prepare("SELECT media_id, artist, title, SUM(c_play) AS total_play, SUM(c_time) AS total_time, SUM(c_download) AS total_download, SUM(c_finish) AS total_finish, SUM(c_like) AS total_like FROM {$statistics_table} WHERE player_id = %d GROUP BY media_id, artist, title ORDER BY $order $dir", $player_id), ARRAY_A);
		}

		return $results;

	}


	function hap_getIdsForPlaylistCreation($results){

		$ids = array();
		foreach($results as $key){
			if(isset($key['media_id']) && !in_array($key['media_id'], $ids)) $ids[] = $key['media_id'];
		}
		$ids = implode("_", $ids);

		return $ids;

	}

?>