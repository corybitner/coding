<?php

$presets = array(
    'tiny_dark_1' => 'Tiny dark 1',
    'tiny_dark_2' => 'Tiny dark 2',
    'tiny_dark_3' => 'Tiny dark 3',
    'tiny_light_1' => 'Tiny light 1',
    'tiny_light_2' => 'Tiny light 2',
    'tiny_light_3' => 'Tiny light 3',
    'widget' => 'Widget',
    'compact_1' => 'Compact 1',
    'compact_2' => 'Compact 2',
);

$presets2 = array(
    'art_wide_light' => 'Wide light', 
    'art_wide_dark' => 'Wide dark', 
    'art_narrow_light' => 'Narrow light', 
    'art_narrow_dark' => 'Narrow dark', 
    'brona_light' => 'Brona light', 
    'brona_dark' => 'Brona dark', 
    'modern' => 'Modern',
    'metalic' => 'Metalic',
    'poster' => 'Poster'
);

$stickyPlayerThemeArr = array(
    'light' => 'light',
    'dark' => 'dark',
);

$g_settings1 = hap_player_global_settings();

//load settings
$result = $wpdb->get_row("SELECT options FROM {$settings_table} WHERE id = '0'", ARRAY_A);
if($result){
	$g_settings2 = unserialize($result['options']);
	$settings = $g_settings2 + $g_settings1;
}else{
	$settings = $g_settings1;
}

?>

<div class="wrap">

	<h2><?php esc_html_e('Global settings', HAP_TEXTDOMAIN); ?></h2>

	<p></p>

	<?php if(!extension_loaded('zip')) : ?>
	  	<div class="notice notice-warning is-dismissible"> 
			<p><strong><?php esc_html_e('PHP zip extension not installed or enabled! Export player and playlist feature cannot be used.', HAP_TEXTDOMAIN); ?></strong></p>
		</div>
	<?php endif; ?>

	<form id="hap-form-global-settings" method="post">

		<div class="hap-admin">

            <div class="option-tab">
                <div class="option-toggle">
                    <span class="option-title"><?php esc_html_e('Credentials', HAP_TEXTDOMAIN); ?></span>

                    <div class="option-toggle-icon">
		                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" ><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
		            </div>
                </div>
                <div class="option-content">

                	<table class="form-table">
                		<tr valign="top">
					        <th><?php esc_html_e('Youtube application ID', HAP_TEXTDOMAIN); ?></th>
					        <td>
					            <input type="text" name="youtube_id" value="<?php echo($settings['youtube_id']); ?>"><br>
					            <p class="info"><?php printf(__( 'Required if Youtube is used. Register <a href="%s" target="_blank">here</a> and create new project, enable YouTube Data API, go to Credentials, create API key.', HAP_TEXTDOMAIN), esc_url( 'https://console.developers.google.com' ));?></p>
					        </td>
					    </tr>
					    <tr valign="top">
					        <th><?php esc_html_e('Facebook application ID', HAP_TEXTDOMAIN); ?></th>
					        <td>
					            <input type="text" name="facebook_id" value="<?php echo($settings['facebook_id']); ?>"><br>
					            <p class="info"><?php printf(__( 'Required for Facebook social sharing. Register <a href="%s" target="_blank">here</a> and enter App ID.', HAP_TEXTDOMAIN), esc_url( 'https://developers.facebook.com/apps' ));?></p>
					        </td>
					    </tr>
					    <tr valign="top">
					        <th><?php esc_html_e('SoundCloud API key', HAP_TEXTDOMAIN); ?></th>
					        <td>
					            <input type="text" name="soundcloud_app_id" value="<?php echo($settings['soundcloud_app_id']); ?>"><br>
					            <p class="info"><?php printf(__( 'Required for SoundCloud music. Register <a href="%s" target="_blank">here</a> and enter Client ID.', HAP_TEXTDOMAIN), esc_url( 'http://soundcloud.com/you/apps/new' ));?></p>
					        </td>
					    </tr>
					    <tr valign="top">
					        <th><?php esc_html_e('Google Drive API key', HAP_TEXTDOMAIN); ?></th>
					        <td>
					            <input type="text" name="gdrive_app_id" value="<?php echo($settings['gdrive_app_id']); ?>"><br>
					            <p class="info"><?php printf(__( 'Required for Google drive music. Register <a href="%s" target="_blank">here</a>, create new project, enable Google Drive API, create Credentials, API key.', HAP_TEXTDOMAIN), esc_url( 'https://console.developers.google.com' ));?></p>
					        </td>
					    </tr>
					</table>

                </div>
            </div>

            <div class="option-tab-divider"></div>

            <div class="option-tab">
                <div class="option-toggle">
                    <span class="option-title"><?php esc_html_e('Miscellaneous', HAP_TEXTDOMAIN); ?></span>

                    <div class="option-toggle-icon">
		                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" ><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
		            </div>
                </div>
                <div class="option-content">
                    
                    <table class="form-table">

                    	<tr>
							<th><?php esc_html_e('Load Google fonts locally', HAP_TEXTDOMAIN); ?></th>
							<td>
			                    <label><input name="loadGoogleFontsLocally" type="checkbox" value="1" <?php if(isset($settings['loadGoogleFontsLocally']) && $settings['loadGoogleFontsLocally'] == "1") echo 'checked' ?>> <?php esc_html_e('Google fonts are used for brona skin.', HAP_TEXTDOMAIN); ?></label>
							</td>
						
						</tr>

                    	<tr>
							<th><?php esc_html_e('Encrypt song url', HAP_TEXTDOMAIN); ?></th>
							<td>
			                    <label><input name="encryptMediaPaths" type="checkbox" value="1" <?php if(isset($settings['encryptMediaPaths']) && $settings['encryptMediaPaths'] == "1") echo 'checked' ?>> <?php esc_html_e('Hide song urls from page source with encryption.', HAP_TEXTDOMAIN); ?></label>
							</td>
						
						</tr>

					    <tr valign="top">
					        <th><?php esc_html_e('Insert javascript into footer', HAP_TEXTDOMAIN); ?></th>
					        <td>

					        	<label><input name="js_to_footer" type="checkbox" value="1" <?php if(isset($settings['js_to_footer']) && $settings['js_to_footer'] == "1") echo 'checked' ?>> <?php esc_html_e('Putting the js to footer (instead of the head) can fix some javascript conflicts.', HAP_TEXTDOMAIN); ?></label>

						    </td>
					    </tr>

					    <tr valign="top">
					        <th><?php esc_html_e('jQuery No Conflict mode', HAP_TEXTDOMAIN); ?></th>
					        <td>

					        	<label><input name="no_conflict" type="checkbox" value="1" <?php if(isset($settings['no_conflict']) && $settings['no_conflict'] == "1") echo 'checked' ?>> <?php esc_html_e('Can fix some javascript conflicts on the page.', HAP_TEXTDOMAIN); ?></label>

					        </td>
					    </tr>

					    <tr valign="top">
			                <th><?php esc_html_e('Override wordpress single audio', HAP_TEXTDOMAIN); ?></th>
			                <td>

			                	<label><input name="overide_wp_audio" type="checkbox" value="1" <?php if(isset($settings['overide_wp_audio']) && $settings['overide_wp_audio'] == "1") echo 'checked' ?>> <?php esc_html_e('Replace wordpress single audio with Modern audio player.', HAP_TEXTDOMAIN); ?></label>

			                </td>
			            </tr>

			            <tr valign="top">
			                <th><?php esc_html_e('Override wordpress default audio skin', HAP_TEXTDOMAIN); ?></th>
							<td>
								<select name="overide_wp_audio_skin">
									<?php foreach ($presets as $key => $value) : ?>
						                <option value="<?php echo($key); ?>" <?php if(isset($settings['overide_wp_audio_skin']) && $settings['overide_wp_audio_skin'] == $key) echo 'selected' ?>><?php echo(esc_html_e($value)); ?></option>
						            <?php endforeach; ?>
					            </select><br>
					            <p class="info"><?php esc_html_e('Select skin for override wordpress audio.', HAP_TEXTDOMAIN); ?></p>
				            </td>
			            </tr>

			            <tr valign="top">
			                <th><?php esc_html_e('Override wordpress audio playlist', HAP_TEXTDOMAIN); ?></th>
			                <td>

			                	<label><input name="overide_wp_audio_playlist" type="checkbox" value="1" <?php if(isset($settings['overide_wp_audio_playlist']) && $settings['overide_wp_audio_playlist'] == "1") echo 'checked' ?>> <?php esc_html_e('Replace wordpress audio playlist with Modern audio player.', HAP_TEXTDOMAIN); ?></label>

			                </td>
			            </tr>

			            <tr valign="top">
			                <th><?php esc_html_e('Override wordpress default audio playlist skin', HAP_TEXTDOMAIN); ?></th>
							<td>
								<select name="overide_wp_audio_playlist_skin">
									<?php foreach ($presets2 as $key => $value) : ?>
						                <option value="<?php echo($key); ?>" <?php if(isset($settings['overide_wp_audio_playlist_skin']) && $settings['overide_wp_audio_playlist_skin'] == $key) echo 'selected' ?>><?php echo(esc_html_e($value)); ?></option>
						            <?php endforeach; ?>
					            </select><br>
					            <p class="info"><?php esc_html_e('Select skin for override wordpress audio playlist.', HAP_TEXTDOMAIN); ?></p>
				            </td>
			            </tr>

			            <tr valign="top">
			                <th><?php esc_html_e('Add Font Awesome css for playlist icons.', HAP_TEXTDOMAIN); ?></th>
			                <td>

			                	<label><input name="add_font_awesome_css" type="checkbox" value="1" <?php if(isset($settings['add_font_awesome_css']) && $settings['add_font_awesome_css'] == "1") echo 'checked' ?>> <?php esc_html_e('Enqueue Font Awesome css that will be used for custom playlist icons.', HAP_TEXTDOMAIN); ?></label>

			                </td>
			            </tr>

			            <tr valign="top">
			                <th><?php esc_html_e('Delete plugin data on uninstall', HAP_TEXTDOMAIN); ?></th>
			                <td>

			                	<label><input name="delete_plugin_data_on_uninstall" type="checkbox" value="1" <?php if(isset($settings['delete_plugin_data_on_uninstall']) && $settings['delete_plugin_data_on_uninstall'] == "1") echo 'checked' ?>> <?php esc_html_e('This will delete all plugin data (players, playlists, songs...) when plugin is uninstalled.', HAP_TEXTDOMAIN); ?></label>

			                </td>
			            </tr>

					</table>

                </div>
            </div>

            <div class="option-tab-divider"></div>

            <div class="option-tab">
                <div class="option-toggle">
                    <span class="option-title"><?php esc_html_e('Backend', HAP_TEXTDOMAIN); ?></span>

                    <div class="option-toggle-icon">
		                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" ><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
		            </div>
                </div>
                <div class="option-content">
                    
                    <table class="form-table">

						<tr>
							<th><?php esc_html_e('Create audio waveform on song upload', HAP_TEXTDOMAIN); ?></th>
							<td>
			                    <label><input name="createAudioWaveformOnUpload" type="checkbox" value="1" <?php if(isset($settings['createAudioWaveformOnUpload']) && $settings['createAudioWaveformOnUpload'] == "1") echo 'checked' ?>> <?php esc_html_e('Create audio waveform in Playlist manager when you upload songs.', HAP_TEXTDOMAIN); ?></label>
							</td>
						
						</tr>

					</table>

				</div>

			</div>

            <div class="option-tab-divider"></div>

            <div class="option-tab">
                <div class="option-toggle">
                    <span class="option-title"><?php esc_html_e('Sticky player', HAP_TEXTDOMAIN); ?></span>

                    <div class="option-toggle-icon">
		                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" ><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
		            </div>
                </div>
                <div class="option-content">

                	<table class="form-table">

                		<tr valign="top">
					        <th><?php esc_html_e('Use sticky player at bottom', HAP_TEXTDOMAIN); ?></th>
					        <td>
					        	<label><input name="useFixedPlayer" type="checkbox" value="1" <?php if(isset($settings['useFixedPlayer']) && $settings['useFixedPlayer'] == "1") echo 'checked' ?>> <?php esc_html_e('Sticky player will be used alongside normal player(s) in page and display current active song.', HAP_TEXTDOMAIN); ?></label>
					        </td>
					    </tr>

					    <tr valign="top">
					        <th><?php esc_html_e('Sticky player opened on start', HAP_TEXTDOMAIN); ?></th>
					        <td>
					        	<label><input name="fixedPlayerOpened" type="checkbox" value="1" <?php if(isset($settings['fixedPlayerOpened']) && $settings['fixedPlayerOpened'] == "1") echo 'checked' ?>> <?php esc_html_e('Show sticky player in opened position when song starts.', HAP_TEXTDOMAIN); ?></label>
					        </td>
					    </tr>

					    <tr valign="top">
					        <th><?php esc_html_e('Sticky player theme', HAP_TEXTDOMAIN); ?></th>
					        <td>
					            <select name="fixedPlayerTheme" id="fixedPlayerTheme">
					                <?php foreach ($stickyPlayerThemeArr as $key => $value) : ?>
					                    <option value="<?php echo($key); ?>" <?php if(isset($settings['fixedPlayerTheme']) && $settings['fixedPlayerTheme'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
					                <?php endforeach; ?>
					            </select>
					        </td>
					    </tr>	

                	</table>

                    <h4><?php esc_html_e('Waveform', HAP_TEXTDOMAIN); ?></h4>

					<table class="form-table">
						
						<tr valign="top">
					        <th><?php esc_html_e('Use waveform seekbar in sticky player instead of normal seekbar', HAP_TEXTDOMAIN); ?></th>
					        <td>
					        	<label><input name="useWaveSeekbarInFixed" type="checkbox" value="1" <?php if(isset($settings['useWaveSeekbarInFixed']) && $settings['useWaveSeekbarInFixed'] == "1") echo 'checked' ?>> <?php esc_html_e('Note that waveform is only available for audio files uploaded in Wordpress media library or if you provide waveform data manually.', HAP_TEXTDOMAIN); ?></label>
					        </td>
					    </tr>

						<tr valign="top">
				            <th><?php esc_html_e('Waveform background color', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<input class="hap-checkbox" name="waveBgColor" value="<?php if(isset($settings['waveBgColor']))echo($settings['waveBgColor']); ?>">
				            </td>
				        </tr>

				        <tr valign="top">
				            <th><?php esc_html_e('Waveform foreground color (song progress)', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<input class="hap-checkbox" name="waveProgressColor" value="<?php echo($settings['waveProgressColor']); ?>">
				            </td>
				        </tr>

				        <tr valign="top">
				            <th><?php esc_html_e('Width of the bars in waveform', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<input type="number" min="0" step="1" name="waveBarWidth" value="<?php echo($settings['waveBarWidth']); ?>">
				            	<p class="info"><?php esc_html_e('If width of the bars is zero, waveform will look more like a smooth wave.', HAP_TEXTDOMAIN); ?></p>
				            </td>
				        </tr>

				        <tr valign="top">
				            <th><?php esc_html_e('The radius that makes bars rounded', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<input type="number" min="0" step="1" name="waveBarRadius" value="<?php echo($settings['waveBarRadius']); ?>">
				            </td>
				        </tr>

				        <tr valign="top">
				            <th><?php esc_html_e('The optional spacing between bars of the wave, if not provided will be calculated in legacy format.', HAP_TEXTDOMAIN); ?></th>
				            <td>
				            	<input type="number" min="0" step="1" name="waveBarGap" value="<?php echo($settings['waveBarGap']); ?>">
				            </td>
				        </tr>

				    </table>

		        </div>

		    </div>    

        </div>

		<div id="hap-sticky-action" class="hap-sticky">
            <div id="hap-sticky-action-inner">
               
                <button id="hap-edit-global-options-submit" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Save Changes', HAP_TEXTDOMAIN); ?></button> 
            </div>
        </div>

        <div id="hap-save-holder"></div>

	</form>
	
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