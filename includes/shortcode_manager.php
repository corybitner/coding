<?php 

//load players
$players = $wpdb->get_results("SELECT id, title FROM {$player_table} ORDER BY title ASC", ARRAY_A);

//load playlists
$playlists = $wpdb->get_results("SELECT id, title FROM {$playlist_table} ORDER BY title ASC", ARRAY_A);

//load ads
$ads = $wpdb->get_results("SELECT id, title FROM {$ad_table} ORDER BY title ASC", ARRAY_A);

?>

<div class="wrap">

	<h2><?php esc_html_e('Shortcode manager', HAP_TEXTDOMAIN); ?></h2>
	<br>

	<div class="hap-admin">

	<div class="option-tab">
	    <div class="option-toggle">
	        <span class="option-title"><?php esc_html_e('Main Shortcodes', HAP_TEXTDOMAIN); ?></span>

	        <div class="option-toggle-icon">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" ><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
            </div>
	    </div>
	    <div class="option-content">

	    	<p><?php esc_html_e('From this section you can generate shortcodes. Select player and playlist that you have already created, and copy shortcode into page or post.', HAP_TEXTDOMAIN); ?></p>

    		<table class='hap-table wp-list-table widefat'>
				<tbody>

					<tr valign="top">
						<th style="width:15%"><?php esc_html_e('Select player', HAP_TEXTDOMAIN); ?></th>
						<td>
				            <select id="shortcode_player">
								<?php foreach($players as $player) : ?>
					                <option value="<?php echo($player['id']); ?>"><?php echo($player['title']); echo(' - ID #' . $player['id']); ?></option>
								<?php endforeach; ?>	
							</select>
			            </td>
					</tr>

					<tr valign="top">
						<th style="width:15%"><?php esc_html_e('Select playlist', HAP_TEXTDOMAIN); ?></th>
						<td>
				            <select id="shortcode_playlist">
				            	<option value=""><?php esc_html_e('No playlist loaded on start', HAP_TEXTDOMAIN); ?></option>
								<?php foreach($playlists as $playlist) : ?>
					                <option value="<?php echo($playlist['id']); ?>"><?php echo($playlist['title']); echo(' - ID #' . $playlist['id']); ?></option>
								<?php endforeach; ?>	
							</select>
			            </td>
					</tr>

					<tr valign="top">
						<th style="width:15%"><?php esc_html_e('Select song', HAP_TEXTDOMAIN); ?></th>
						<td>

				            <input list="shortcode_playlist_song" id="shortcode_playlist_song_list">
							<datalist id="shortcode_playlist_song"></datalist>  

							<button type="button" id="shortcode-get-playlist-songs"><?php esc_html_e('Get playlist songs', HAP_TEXTDOMAIN); ?></button>
							<p class="info"><?php esc_html_e('Select which song to load on start. By default first song is loaded on player start. You can choose any song from this playlist or no song to be loaded on start.', HAP_TEXTDOMAIN); ?></p>
			            </td>
					</tr>

					<tr valign="top" id="shortcode_start_time_field">
						<th style="width:15%"><?php esc_html_e('Set start time', HAP_TEXTDOMAIN); ?></th>
						<td>
				            <input type="number" min="0" id="shortcode_start_time">
				            
							<p class="info"><?php esc_html_e('Set song start time in seconds.', HAP_TEXTDOMAIN); ?></p>

							<label><input type="checkbox" id="shortcode_start_time_all"><?php esc_html_e('Apply start time to all songs.', HAP_TEXTDOMAIN); ?></label>

			            </td>
					</tr>

					<tr valign="top">
						<th style="width:15%"><?php esc_html_e('Select ads', HAP_TEXTDOMAIN); ?></th>
						<td>
				            <select id="shortcode_ad">
				            	<option value=""><?php esc_html_e('None', HAP_TEXTDOMAIN); ?></option>
								<?php foreach($ads as $ad) : ?>
					                <option value="<?php echo($ad['id']); ?>"><?php echo($ad['title']); echo(' - ID #' . $ad['id']); ?></option>
								<?php endforeach; ?>	
							</select>
			            </td>
					</tr>

					<tr valign="top">
						<th style="width:15%"><?php esc_html_e('Shortcode', HAP_TEXTDOMAIN); ?></th>
						<td>
				            <textarea id="shortcode_generator" rows="3" style="width: 400px;"></textarea>
			            </td>
					</tr>

					<tr valign="top">
						<th style="width:15%"><?php esc_html_e('Shortcode in PHP page:', HAP_TEXTDOMAIN); ?></th>
						<td>
				            <textarea id="shortcode_for_php" rows="" style="width: 70%;"></textarea>
			            </td>
					</tr>
				
				</tbody>		 
			</table>

  	    </div>
    </div>

    <div class="option-tab-divider"></div>

	<div class="option-tab">
		<div class="option-toggle">
	        <span class="option-title"><?php esc_html_e('Quick shortcode generator', HAP_TEXTDOMAIN); ?></span>

	        <div class="option-toggle-icon">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" ><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
            </div>
	    </div>
	    <div class="option-content">	

	    	<p><?php esc_html_e('Generate audio shortcode here for one or multiple songs and use it directly in your page.', HAP_TEXTDOMAIN); ?></p>

				<div id="hap-edit-media-modal">

					<form id="hap-edit-media-form" class="option-content-box hap-get-audio-shortcode-submit">	

					<div class="hap-quick-shortcode-field">

			    	<?php 

			    	$additional_playlists = array();
			    	$playlist_id = -1;

			    	include("add_media_fields.php"); 

			    	?>

			    	<button type="button" id="hap-edit-media-form-submit2" style="float: right; margin: 10px 0;" class="button-primary hap-get-audio-shortcode-mode" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?> title="<?php esc_attr_e('You can add multiple songs to already existing shortcode', HAP_TEXTDOMAIN); ?>"><?php esc_html_e('Add song to existing shortcode', HAP_TEXTDOMAIN); ?></button>

			    	</div>

			    	</form>




			    	<p><?php esc_html_e('Select player features (only basic features are available here. If you want to deeply configure the player, you need to create new player in Player manager section and combine player_id="PLAYER_ID" with your audio shortcode', HAP_TEXTDOMAIN); ?></p>

			    	<form id="hap-quick-player-shortcode-form" class="option-content-box">	

			    	<div class="hap-quick-shortcode-field" id="hap-quick-shortcode-field-player">

			    	<table class="form-table">

			    		<?php include('add_preset_fields.php'); 

			    		$options = hap_player_options();

			    		?>



			    		<tr valign="top" class="playlist-skin">
				            <th><?php esc_html_e('Select playlist items style', HAP_TEXTDOMAIN); ?></th>
				            <td>
				                <select id="infoSkin" name="infoSkin">
				                    <?php foreach ($options['infoSkinArr'] as $key => $value) : ?>
				                        <option value="<?php echo($key); ?>"><?php echo($value); ?></option>
				                    <?php endforeach; ?>
				                </select><br><br>
				                <img id="playlist-grid-style-img" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg=="/>
				            </td>
				        </tr>  

			    		<tr valign="top">
				            <th><?php esc_html_e('Use skip backward button (X seconds)', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<label><input name="useSkipBackward" type="checkbox" value="1" <?php if(isset($options['useSkipBackward']) && $options['useSkipBackward'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				            </td>
				        </tr>

				        <tr valign="top">
				            <th><?php esc_html_e('Use skip forward button (X seconds)', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<label><input name="useSkipForward" type="checkbox" value="1" <?php if(isset($options['useSkipForward']) && $options['useSkipForward'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					        </td>
				        </tr>

				        <tr valign="top">
				            <th><?php esc_html_e('Use AB loop', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<label><input name="useRange" type="checkbox" value="1" <?php if(isset($options['useRange']) && $options['useRange'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				            </td>
				        </tr>

				        <tr valign="top">
				            <th><?php esc_html_e('Use shuffle button', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<label><input name="useShuffle" type="checkbox" value="1" <?php if(isset($options['useShuffle']) && $options['useShuffle'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				            </td>
				        </tr>

						<tr valign="top">
				            <th><?php esc_html_e('Use loop button', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<label><input name="useLoop" type="checkbox" value="1" <?php if(isset($options['useLoop']) && $options['useLoop'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				            </td>
				        </tr>
					    
					    <tr valign="top">
				            <th><?php esc_html_e('Use playback rate', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<label><input name="usePlaybackRate" type="checkbox" value="1" <?php if(isset($options['usePlaybackRate']) && $options['usePlaybackRate'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				            </td>
				        </tr>

				        <tr valign="top" class="hap-editplayer-use-share-field">
				            <th><?php esc_html_e('Use social sharing buttons', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<label><input name="useShare" id="useShare" type="checkbox" value="1" <?php if(isset($options['useShare']) && $options['useShare'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				            </td>
				        </tr>

				        <tr valign="top">
					        <th><?php esc_html_e('Use keyboard navigation for controling playback.', HAP_TEXTDOMAIN); ?></th>
					        <td>
					        	<label><input name="useKeyboardNavigationForPlayback" type="checkbox" value="1" <?php if(isset($options['useKeyboardNavigationForPlayback']) && $options['useKeyboardNavigationForPlayback'] == "1") echo 'checked' ?>> <?php esc_html_e('Use keyboard buttons to toggle player actions.', HAP_TEXTDOMAIN); ?></label>
					        	<br><br>
					        </td>
					    </tr>

					    <tr valign="top">
				            <th><?php esc_html_e('Use search song field', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<label><input name="useSearch" type="checkbox" value="1" <?php if(isset($options['useSearch']) && $options['useSearch'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				            </td>
				        </tr> 

				        <tr valign="top">
				            <th><?php esc_html_e('Use button to open popup window', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<label><input name="usePopup" type="checkbox" value="1" <?php if(isset($options['usePopup']) && $options['usePopup'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				            </td>
				        </tr>

					    <tr valign="top">
					        <th><?php esc_html_e('Random play', HAP_TEXTDOMAIN); ?></th>
					        <td>
					        	<label><input name="randomPlay" type="checkbox" value="1" <?php if(isset($options['randomPlay']) && $options['randomPlay'] == "1") echo 'checked' ?>> <?php esc_html_e('Randomize playback in playlist.', HAP_TEXTDOMAIN); ?></label>
						    </td>
					    </tr>

					</table> 	

			    </div>  

			    </form> 


	    	</div>

			<div>

	            <button type="button" id="hap-edit-media-form-submit" style="float: right; margin: 10px 0;" class="button-primary hap-get-audio-shortcode-mode" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Get shortcode', HAP_TEXTDOMAIN); ?></button> 

	            <textarea id="hap-quick-audio-shortcode-ta" rows="5" style="width:100%; display: block;"></textarea>

	        </div>

		</div>
	</div>

	<div class="option-tab-divider"></div>

	<div class="option-tab">
		<div class="option-toggle">
	        <span class="option-title"><?php esc_html_e('Playlist display frontend', HAP_TEXTDOMAIN); ?></span>

	        <div class="option-toggle-icon">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" ><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
            </div>
	    </div>
	    <div class="option-content">	

	    	<p><?php esc_html_e('Display list of thumbnails (each representing one playlist) and by clicking the thumbnail, new playlist is going to be loaded in the player.', HAP_TEXTDOMAIN); ?></p>

			<table class="form-table" id="hap-pd">

				<tr valign="top">
		            <th><?php esc_html_e('Select header title above thumbnail list', HAP_TEXTDOMAIN); ?></th>
		            <td>
		            	<input type="text" id="pd-header-title" value="<?php esc_attr_e('Our portfolio', HAP_TEXTDOMAIN); ?>">
		            </td>
		        </tr>

				<tr valign="top">
		            <th><?php esc_html_e('Select playlist(s) to include', HAP_TEXTDOMAIN); ?></th>
		            <td>
				    	<select id="pd-playlist-list" multiple>
			                <?php foreach($playlists as $playlist) : ?>
		                    	<option value="<?php echo($playlist['id']); ?>"><?php echo($playlist['title']); echo(' - ID #' . $playlist['id']); ?></option>
			                <?php endforeach; ?>    
			            </select>

			            <button type="button" id="hap-select-all-pd"><?php esc_html_e('Select all', HAP_TEXTDOMAIN); ?></button>
			            <button type="button" id="hap-clear-pd"><?php esc_html_e('Clear selected', HAP_TEXTDOMAIN); ?></button>
	             	</td>
		        </tr>

		        <tr valign="top">
		            <th><?php esc_html_e('Select active playlist', HAP_TEXTDOMAIN); ?></th>
		            <td>
				    	<input type="number" id="pd-active-playlist" step="1" min="-1">
			            <p class="info"><?php esc_html_e('First playlist will automatically be loaded in the player on start. Enter -1 for no playlist loaded on start or enter different playlist ID to load instead.', HAP_TEXTDOMAIN); ?></p>
	             	</td>
		        </tr>

		        <tr valign="top">
		            <th><?php esc_html_e('Select player which will play music', HAP_TEXTDOMAIN); ?></th>
		            <td>
				    	<select id="pd-player-list">
			                <?php foreach($players as $player) : ?>
		                    	<option value="<?php echo($player['id']); ?>"><?php echo($player['title']); echo(' - ID #' . $player['id']); ?></option>
			                <?php endforeach; ?>    
			            </select>
	             	</td>
		        </tr>

			</table> 	

			<div class="hap-pd-action-wrap">

				<button type="button" id="hap-pd-get-shortcode" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Get shortcode', HAP_TEXTDOMAIN); ?></button> 

		        <textarea id="hap-pd-shortcode-ta" rows="3" style="width:100%; display: block;"></textarea>

	        </div>

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