<?php

	date_default_timezone_set('UTC');

	//load playlists
	$playlists = $wpdb->get_results("SELECT id, title FROM {$playlist_table} ORDER BY title ASC", ARRAY_A);

	//load players
	$players = $wpdb->get_results("SELECT id, title FROM {$player_table} ORDER BY title ASC", ARRAY_A);

?>

<div class="wrap" id="hap-stat-wrap" data-admin-url="<?php echo admin_url("admin.php"); ?>">

	<h2><?php esc_html_e('Audio statistics', HAP_TEXTDOMAIN); ?></h2>

	<p class="hap-tinfo"><?php esc_html_e('Statistics can be shown for all playlists, specific playlist or songs without a playlist ( song from direct shortocode [apmap type="audio" title="song-title" artist="song-artist" mp3="song-url"] ), or from a player.', HAP_TEXTDOMAIN); ?></p>

	<?php include("notice.php"); ?>

	<div class="hap-stats-header">

		<div class="hap-stats-selector-wrap">

	        <div class="action-title"><?php esc_html_e('Choose from which source to display statistics:', HAP_TEXTDOMAIN); ?></div>
	        <div class="item">
	            <input type="radio" name="hap-stat-type" value="playlist" id="hap-stat-type-playlist" checked="" /><label for="hap-stat-type-playlist"> Playlist</label>
	        </div>
	        <div class="item">
	            <input type="radio" name="hap-stat-type" value="player" id="hap-stat-type-player" /><label for="hap-stat-type-player"> Player</label>
	        </div>   
	    

	    

			<div class="hap-stats-selector" id="hap-stats-selector-playlist">
				<span style="vertical-align: middle;"><?php esc_html_e('Choose playlist to show statistics:', HAP_TEXTDOMAIN); ?></span>

				<select name="hap-stats-playlist-list" id="hap-stats-playlist-list">
					<option value="-1"><?php esc_html_e('All playlists', HAP_TEXTDOMAIN); ?></option>
					<option value="-2"><?php esc_html_e('Songs without playlist (songs from direct shortcode)', HAP_TEXTDOMAIN); ?></option>
					<?php foreach ($playlists as $playlist) : ?>
			            <option value="<?php echo($playlist['id']); ?>"><?php echo($playlist['title'].' - ID #'.$playlist['id']); ?></option>
			        <?php endforeach; ?>
			    </select>
			</div>

			<div class="hap-stats-selector" id="hap-stats-selector-player">
				<span style="vertical-align: middle;"><?php esc_html_e('Choose player to show statistics:', HAP_TEXTDOMAIN); ?></span>

				<select name="hap-stats-player-list" id="hap-stats-player-list">
			        <?php foreach ($players as $player) : ?>
			            <option value="<?php echo($player['id']); ?>"><?php echo($player['title'].' - ID #'.$player['id']); ?></option>
			        <?php endforeach; ?>
			    </select>
			</div>

		</div>


		<div>
			<button type="button" class='button-primary' id="hap-clear-statistics" title='<?php esc_attr_e('Clear Statistics', HAP_TEXTDOMAIN); ?>' data-message="<?php esc_attr_e('Are you sure to clear statistics for this segment?', HAP_TEXTDOMAIN); ?>"><?php esc_html_e('Clear Statistics', HAP_TEXTDOMAIN); ?></button>
		</div>

	</div>

	<div class="hap-stats-total">
		<div class="hap-stats-total-inner">

	    	<div>
	    	<p class="hap-stats-total-value hap-stats-total-time"></p><p class="hap-stats-total-title"><?php esc_html_e('Total time played', HAP_TEXTDOMAIN); ?></p>
	    	</div>

	    	<div>
	    	<p class="hap-stats-total-value hap-stats-total-play"></p><p class="hap-stats-total-title"><?php esc_html_e('Total plays', HAP_TEXTDOMAIN); ?></p>
	    	</div>

	    	<div>
	    	<p class="hap-stats-total-value hap-stats-total-download"></p><p class="hap-stats-total-title"><?php esc_html_e('Total downloads', HAP_TEXTDOMAIN); ?></p>
	    	</div>

	    	<div>
	    	<p class="hap-stats-total-value hap-stats-total-like"></p><p class="hap-stats-total-title"><?php esc_html_e('Total likes', HAP_TEXTDOMAIN); ?></p>
	    	</div>

	    	<div>
	    	<p class="hap-stats-total-value hap-stats-total-finish"></p><p class="hap-stats-total-title"><?php esc_html_e('Total finished', HAP_TEXTDOMAIN); ?></p>
	    	</div>

		</div>
	</div>

	<div class="top-box-wrap hap-stats-top1">

		<div class="top-box hap-box-top-play-day">
			<div class="top-box-inner">

				<div class="top-box-title">
					<h2><?php esc_html_e('TOP PLAYS OF THE DAY', HAP_TEXTDOMAIN); ?></h2>

					<span class="hap-stat-icon2 hap-create-playlist-from-stat hap-stat-hidden"><img title="<?php esc_attr_e('Create playlist from these songs', HAP_TEXTDOMAIN); ?>" src="<?php echo(plugins_url('apmap/assets/icons/list.png'));?>"></span>

				</div>

				<div class="top-box-content">
					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>

			</div>
		</div>

		<div class="top-box hap-box-top-play-week">
			<div class="top-box-inner">

				<div class="top-box-title">
					<h2><?php esc_html_e('TOP PLAYS THIS WEEK', HAP_TEXTDOMAIN); ?></h2>

					<span class="hap-stat-icon2 hap-create-playlist-from-stat hap-stat-hidden" ><img title="<?php esc_attr_e('Create playlist from these songs', HAP_TEXTDOMAIN); ?>" src="<?php echo(plugins_url('apmap/assets/icons/list.png'));?>"></span>	

				</div>

				<div class="top-box-content">
					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>
					
			</div>
		</div>

		<div class="top-box hap-box-top-play-month">
			<div class="top-box-inner">

				<div class="top-box-title">
					<h2><?php esc_html_e('TOP PLAYS THIS MONTH', HAP_TEXTDOMAIN); ?></h2>
					
					<span class="hap-stat-icon2 hap-create-playlist-from-stat hap-stat-hidden"><img title="<?php esc_attr_e('Create playlist from these songs', HAP_TEXTDOMAIN); ?>" src="<?php echo(plugins_url('apmap/assets/icons/list.png'));?>"></span>	
				
				</div>
				
				<div class="top-box-content">
					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>

			</div>
		</div>

	</div>

	<div class="top-box-wrap hap-stats-top2">

		<div class="top-box hap-box-top-play-all-time">
			<div class="top-box-inner">

				<div class="top-box-title">
					<h2><?php esc_html_e('TOP PLAYS ALL TIME', HAP_TEXTDOMAIN); ?></h2>
					
					<span class="hap-stat-icon2 hap-create-playlist-from-stat hap-stat-hidden"><img title="<?php esc_attr_e('Create playlist from these songs', HAP_TEXTDOMAIN); ?>" src="<?php echo(plugins_url('apmap/assets/icons/list.png'));?>"></span>
					
				</div>
				
				<div class="top-box-content">
					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>

			</div>
		</div>

		<div class="top-box hap-box-top-plays-country-all-time">
			<div class="top-box-inner">
				<div class="top-box-title">

					<h2><?php esc_html_e('TOP PLAYS PER COUNTRY ALL TIME', HAP_TEXTDOMAIN); ?></h2>
				
				</div>
				
				<div class="top-box-content">

					<table class="hap-table wp-list-table widefat inline-stat-table inline-stat-table-hidden">
	                <thead>
	                    <tr>
	                        <th><?php esc_html_e('Country', HAP_TEXTDOMAIN); ?></th>
	                        <th><?php esc_html_e('Continent', HAP_TEXTDOMAIN); ?></th>
	                        <th><?php esc_html_e('Plays', HAP_TEXTDOMAIN); ?></th>
	                        <th><?php esc_html_e('Time played', HAP_TEXTDOMAIN); ?></th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	                </table>

					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>

			</div>
		</div>

		<div class="top-box hap-box-top-plays-user-all-time">
			<div class="top-box-inner">
				<div class="top-box-title">

					<h2><?php esc_html_e('TOP PLAYS PER USER ALL TIME', HAP_TEXTDOMAIN); ?></h2>
				
				</div>
				
				<div class="top-box-content">

					<table class="hap-table wp-list-table widefat inline-stat-table inline-stat-table-hidden">
	                <thead>
	                    <tr>
	                        <th><?php esc_html_e('User name', HAP_TEXTDOMAIN); ?></th>
	                        <th><?php esc_html_e('Role', HAP_TEXTDOMAIN); ?></th>
	                        <th><?php esc_html_e('Plays', HAP_TEXTDOMAIN); ?></th>
	                        <th><?php esc_html_e('Time played', HAP_TEXTDOMAIN); ?></th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	                </table>

					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>

			</div>
		</div>

		<div class="top-box hap-box-top-download-all-time">
			<div class="top-box-inner">

				<div class="top-box-title">
					<h2><?php esc_html_e('TOP DOWNLOADS ALL TIME', HAP_TEXTDOMAIN); ?></h2>

					<span class="hap-stat-icon2 hap-create-playlist-from-stat hap-stat-hidden"><img title="<?php esc_attr_e('Create playlist from these songs', HAP_TEXTDOMAIN); ?>" src="<?php echo(plugins_url('apmap/assets/icons/list.png'));?>"></span>	
				
				</div>
				
				<div class="top-box-content">
					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>

			</div>
		</div>

		<div class="top-box hap-box-top-like-all-time">
			<div class="top-box-inner">

				<div class="top-box-title">
					<h2><?php esc_html_e('TOP LIKES ALL TIME', HAP_TEXTDOMAIN); ?></h2>

					<span class="hap-stat-icon2 hap-create-playlist-from-stat hap-stat-hidden"><img title="<?php esc_attr_e('Create playlist from these songs', HAP_TEXTDOMAIN); ?>" src="<?php echo(plugins_url('apmap/assets/icons/list.png'));?>"></span>	
				
				</div>
				
				<div class="top-box-content">
					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>

			</div>
		</div>

		<div class="top-box hap-box-top-finish-all-time">
			<div class="top-box-inner">
				<div class="top-box-title">

					<h2><?php esc_html_e('TOP FINISHES ALL TIME', HAP_TEXTDOMAIN); ?></h2>

					<span class="hap-stat-icon2 hap-create-playlist-from-stat hap-stat-hidden"><img title="<?php esc_attr_e('Create playlist from these songs', HAP_TEXTDOMAIN); ?>" src="<?php echo(plugins_url('apmap/assets/icons/list.png'));?>"></span>	
				
				</div>
				
				<div class="top-box-content">
					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>

			</div>
		</div>

		<div class="top-box hap-box-top-skip-first-min-all-time">
			<div class="top-box-inner">
				<div class="top-box-title">

					<h2><?php esc_html_e('TOP SKIPPED IN FIRST MINUTE ALL TIME', HAP_TEXTDOMAIN); ?></h2>

					<span class="hap-stat-icon2 hap-create-playlist-from-stat hap-stat-hidden"><img title="<?php esc_attr_e('Create playlist from these songs', HAP_TEXTDOMAIN); ?>" src="<?php echo(plugins_url('apmap/assets/icons/list.png'));?>"></span>	
				
				</div>
				
				<div class="top-box-content">

					<div class="hap-stat-no-data hap-stat-hidden"><p><?php esc_html_e('Data Not Available', HAP_TEXTDOMAIN); ?></p></div>
				</div>

			</div>
		</div>

	</div>

	<div id="hap-stat-graph-options-wrap">

		<button type="button" class='button-primary' id="graph-options-btn" title='<?php esc_attr_e('Graph options', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Graph options', HAP_TEXTDOMAIN); ?></button>

		<div id="hap-stat-graph-options">

			<div class="action">
		        <div class="action-title"><?php esc_html_e('Graph type', HAP_TEXTDOMAIN); ?></div>
		        <div class="item">
		            <input type="radio" class="hsrc graph-type" name="graph-type" value="bar" id="bar" checked="" /><label for="bar"> bar</label>
		        </div>
		        <div class="item">
		            <input type="radio" class="hsrc graph-type" name="graph-type" value="line" id="line" /><label for="line"> line</label>
		        </div>   
		    </div>

		    <div class="action graph-data">
		        <div class="action-title"><?php esc_html_e('Data to display', HAP_TEXTDOMAIN); ?></div>
		        <div class="item">
		            <input type="checkbox" class="hsrc graph-data-display" value="c_play" id="plays" checked="checked" /><label for="plays"> plays</label>
		        </div>
		        <div class="item">
		            <input type="checkbox" class="hsrc graph-data-display" value="c_like" id="likes" checked="checked"/><label for="likes"> likes</label>
		        </div> 
		        <div class="item">
		            <input type="checkbox" class="hsrc graph-data-display" value="c_download" id="downloads" checked="checked"/><label for="downloads"> downloads</label>
		        </div> 
		        <div class="item">
		            <input type="checkbox" class="hsrc graph-data-display" value="c_finish" id="finishes" checked="checked"/><label for="finishes"> finishes</label>
		        </div>   
		    </div>

		    <div class="action">
		        <div class="action-title"><?php esc_html_e('Choose date range', HAP_TEXTDOMAIN); ?></div>
		        <div class="item">
		        	<input type="text" id="hap-daterange" />
		        </div>
		    </div>

		    <div class="action">
		        <div class="action-title"><?php esc_html_e('Display type', HAP_TEXTDOMAIN); ?></div>
		        <div class="item">
		            <input type="radio" class="hsrc display-type" name="display-type" value="daily" id="daily" checked="" /><label for="daily"> daily</label>
		        </div>
		        <div class="item">
		            <input type="radio" class="hsrc display-type" name="display-type" value="monthly" id="monthly" /><label for="monthly"> monthly</label>
		        </div>   
		    </div>

		</div>

	</div>

	<div class="list-actions">

  		<div class="list-actions-wrap list-actions-left hap-playlist-actions">

  			<input type="text" id="hap-filter-media" placeholder="<?php esc_attr_e('Search song..', HAP_TEXTDOMAIN); ?>">

  		</div>

  		<div class="list-actions-wrap list-actions-right hap-media-pagination-container">

			<div class="hap-pagination-per-page">
				<label for="hap-pag-per-page-num" id="hap-pag-per-page-label"><?php esc_html_e('Songs per page', HAP_TEXTDOMAIN); ?></label>
			    <input type="number" min="1" id="hap-pag-per-page-num" value="10">
			    <button type="button" id="hap-pag-per-page-btn"><?php esc_html_e('Set', HAP_TEXTDOMAIN); ?></button>
			</div>

		<div class="hap-pagination-wrap"></div>

		</div>

    </div>

	<table class='hap-table wp-list-table widefat stat-table' id="hap-stat-list">
		<thead class="stat-table-header">
			<tr>

				<th class="hap-sort-field" data-type="artist" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Artist', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th class="hap-sort-field" data-type="title" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th class="hap-sort-field" data-type="album" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Album', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th class="hap-sort-field" data-type="duration" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Time played', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th class="hap-sort-field" data-type="play" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Plays', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th class="hap-sort-field" data-type="download" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Downloads', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th class="hap-sort-field" data-type="like" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Likes', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th class="hap-sort-field" data-type="finish" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Finishes', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th><?php esc_html_e('Actions', HAP_TEXTDOMAIN); ?></th>
			</tr>
		</thead>
		<tbody id="media-item-list">

			<tr class="hap-stat-row media-item media-item-container-hidden hap-pagination-hidden">

				<td class="media-artist"></td>
				<td class="media-title"></td>
				<td class="media-album"></td>
				<td class="media-duration" style="display: none;"></td>
				<td class="media-time"></td>
				<td class="media-play"></td>
				<td class="media-download"></td>
				<td class="media-like"></td>
				<td class="media-finish"></td>

				<td><a href='#' class="hap-stat-create-graph"><?php esc_html_e('Create graph', HAP_TEXTDOMAIN); ?></a><a href='#' class="hap-stat-remove-graph"><?php esc_html_e('Remove graph', HAP_TEXTDOMAIN); ?></a></td>
			</tr>
			
		</tbody>		 
	</table>

</div><!-- end wrap -->


<div id="hap-add-playlist-modal" class="hap-modal">
    <div class="hap-modal-bg">
        <div class="hap-modal-inner">
        	<div class="hap-modal-content">

				<form id="hap-add-playlist-form" method="post">

					<div class="hap-admin hap-bg">

						<p><?php esc_html_e('Create playlist from these songs.', HAP_TEXTDOMAIN); ?></p>

						<table class="form-table">
							
							<tr valign="top">
								<th><?php esc_html_e('Playlist title', HAP_TEXTDOMAIN); ?></th>
								<td><input type="text" name="playlist-title" id="playlist-title" required placeholder="<?php esc_attr_e('Enter playlist title', HAP_TEXTDOMAIN); ?>"></td>
							</tr>

						</table>

					</div>

				</form>

				<div class="hap-modal-actions">	
					<button id="hap-add-playlist-cancel" type="button"><?php esc_html_e('Cancel', HAP_TEXTDOMAIN); ?></button>
		            <button id="hap-add-playlist-submit" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Create playlist', HAP_TEXTDOMAIN); ?></button> 
    			</div>

    			</form>

    		</div>
        </div>
    </div>
</div>


<div id="hap-loader">
    <div class="hap-loader-anim">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>


