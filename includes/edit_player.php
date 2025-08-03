<?php 

$soundCloudThumbQuality = array(
    't67x67.jpg' => '67×67px', 
    'large.jpg' => '100×100px', 
    't300x300.jpg' => '300×300px', 
    'crop.jpg' => '400×400px', 
    't500x500.jpg' => '500x500px',
);

$playlistScrollTypeArr = array(
    'mcustomscrollbar' => 'mCustomScrollbar',
    'perfect-scrollbar' => 'PerfectScrollbar',
);

$playlistScrollTheme = array(
    'light' => 'light',
    'dark' => 'dark',
    'minimal' => 'minimal',
    'minimal-dark' => 'minimal-dark',
    'light-2' => 'light-2',
    'dark-2' => 'dark-2',
    'light-3' => 'light-3',
    'dark-3' => 'dark-3',
    'light-thick' => 'light-thick',
    'dark-thick' => 'dark-thick',
    'light-thin' => 'light-thin',
    'dark-thin' => 'dark-thin',
    'inset' => 'inset',
    'inset-dark' => 'inset-dark',
    'inset-2' => 'inset-2',
    'inset-2-dark' => 'inset-2-dark',
    'inset-3' => 'inset-3',
    'inset-3-dark' => 'inset-3-dark',
    'rounded' => 'rounded',
    'rounded-dark' => 'rounded-dark',
    'rounded-dots' => 'rounded-dots',
    'rounded-dots-dark' => 'rounded-dots-dark',
    '3d' => '3d',
    '3d-dark' => '3d-dark',
    '3d-thick' => '3d-thick',
    '3d-thick-dark' => '3d-thick-dark'
);

$loopState = array(
    'playlist' => __('Loop playlist', HAP_TEXTDOMAIN), 
    'single' => __('Loop single song', HAP_TEXTDOMAIN), 
    'off' => __('Loop off (stop on playlist end)', HAP_TEXTDOMAIN)
);

$preload = array(
    'auto' => __('auto', HAP_TEXTDOMAIN), 
    'metadata' => __('metadata', HAP_TEXTDOMAIN), 
    'none' => __('none', HAP_TEXTDOMAIN)
);

$sortOrder = array(
    '' => __('No sort applied', HAP_TEXTDOMAIN), 
    'title-asc' => __('Title ascending', HAP_TEXTDOMAIN), 
    'title-desc' => __('Title descending', HAP_TEXTDOMAIN)
);

$playlistItemContentArr = array(   
    'thumb' => __('thumbnail', HAP_TEXTDOMAIN), 
    'title' => __('title', HAP_TEXTDOMAIN),
    'description' => __('description', HAP_TEXTDOMAIN), 
    'duration' => __('duration', HAP_TEXTDOMAIN),
    'date' => __('date', HAP_TEXTDOMAIN), 
);

$statisticsContentArr = array(   
    'plays' => __('plays', HAP_TEXTDOMAIN), 
    'likes' => __('likes', HAP_TEXTDOMAIN),
    'downloads' => __('downloads', HAP_TEXTDOMAIN), 
);

$playlistTitleOrder = array(
    'title' => __('title', HAP_TEXTDOMAIN), 
    'artist' => __('artist', HAP_TEXTDOMAIN), 
);

$totalScrollAction = array(    
    'loadMore' => __('Load more', HAP_TEXTDOMAIN), 
    'addMore' => __('Add more', HAP_TEXTDOMAIN), 
    'none' => __('None', HAP_TEXTDOMAIN), 
);

$playerLanguageArr = array(   
	'en' => 'English',
	'de' => 'Deutsch',
	'fr' => 'Français',
	'it' => 'Italiano',
	'hu' => 'Magyar',
	'ro' => 'Romanian',
	'ru' => 'Русский',
	'tr' => 'Türkçe',
	'cs' => 'Čeština',
	'es' => 'Español',
	'nl' => 'Nederlands',
	'nn' => 'Norsk',
	'bg' => 'Bulgarian',
	'pl' => 'Polski',
	'pt' => 'Português',
	'sv' => 'Svenska',
	'el' => 'Greek',
	'hi' => 'हिन्दी',
	'zh-HK' => '中文',
	'ko' => '한국어',
	'ja' => '日本語',
);


$custom_css = "";
$custom_js = "";
$title = "";

if(isset($_GET['player_id'])){

    $player_id = $_GET['player_id'];

    $stmt = $wpdb->prepare("SELECT * FROM {$player_table} WHERE id = %d", $player_id);
    $result = $wpdb->get_row($stmt, ARRAY_A);

    if($result){
    	$player_options = unserialize($result['options']);
    	$preset = $result['preset'];
    	$custom_css = stripslashes($result['custom_css']);
    	$custom_js = stripslashes($result['custom_js']);
    	$default_options = hap_player_options();
    	$options = $player_options + $default_options + hap_player_options_preset($preset);
    	$title = $result['title'];
    }

}





if(isset($_GET['hap_msg'])){
	$msg = $_GET['hap_msg'];
	if($msg == 'player_created')$msg = __('Player created!', HAP_TEXTDOMAIN); 
}else{
	$msg = null;
}


?>

<script type="text/javascript">
    var hap_allKeyboardControls_arr = <?php echo(json_encode($options['keyboardControlsArr'], JSON_HEX_TAG)); ?>;
    var hap_keyboardControls_arr = <?php echo(json_encode($options['keyboardControls'], JSON_HEX_TAG)); ?>;
</script>

<div class='wrap'>

	<?php include("notice.php"); ?>

	<h2><?php esc_html_e('Edit player', HAP_TEXTDOMAIN); ?> <span style="color:#FF0000; font-weight:bold;"><?php echo($title); echo(' - ID #' . $player_id); ?></span></h2>

	<form id="hap-edit-player-form"  method="post" action="<?php echo admin_url("admin.php?page=hap_player_manager"); ?>" data-preset="<?php echo($preset); ?>" data-player-id="<?php echo $player_id ?>">

		<div class="hap-admin">

			<div class="option-tab">
			    <div class="option-toggle">
			        <span class="option-title"><?php esc_html_e('Settings', HAP_TEXTDOMAIN); ?></span>
			    </div>
			    <div class="option-content">

	        		<div id="hap-general-tabs">

	                <div class="hap-tab-header">
	                    <div id="hap-tab-general"><?php esc_html_e('General', HAP_TEXTDOMAIN); ?></div>
	                    <div id="hap-tab-radio"><?php esc_html_e('Radio', HAP_TEXTDOMAIN); ?></div>
	                    <div id="hap-tab-ads"><?php esc_html_e('Advertising', HAP_TEXTDOMAIN); ?></div>
	                    <div id="hap-tab-ga" class="hap-tab-header-ga-field"><?php esc_html_e('Google Analytics', HAP_TEXTDOMAIN); ?></div>
	                    <div id="hap-tab-stats" class="hap-tab-header-stats-field"><?php esc_html_e('Statistics', HAP_TEXTDOMAIN); ?></div>
	                    <div id="hap-tab-translation"><?php esc_html_e('Language', HAP_TEXTDOMAIN); ?></div>
	                    <div id="hap-tab-custom-css"><?php esc_html_e('Custom CSS', HAP_TEXTDOMAIN); ?></div>
	                    <div id="hap-tab-custom-js"><?php esc_html_e('Custom Javascript', HAP_TEXTDOMAIN); ?></div>
	                </div>

	                <div id="hap-tab-general-content" class="hap-tab-content">

	                <div id="hap-general-tabs-sub" class="hap-tabs-sub">

                    <div class="hap-tab-header-sub">
                        <div id="hap-tab-general-options"><?php esc_html_e('Options', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-pagination" class="playlist-skin"><?php esc_html_e('Pagination', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-elements" class="hap-editplayer-elements-field default-skin"><?php esc_html_e('Buttons', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-share" class="hap-editplayer-share-field"><?php esc_html_e('Social sharing', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-playback" class="hap-editplayer-playback-field"><?php esc_html_e('Playback', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-keyboard" class="hap-editplayer-keyboard-field"><?php esc_html_e('Keyboard', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-playlist" class="hap-editplayer-playlist-field default-skin"><?php esc_html_e('Playlist', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-playlist-items" class="hap-editplayer-playlist-items-field"><?php esc_html_e('Playlist items', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-search-field" class="hap-editplayer-search-field"><?php esc_html_e('Search field', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-continous-playback" class="hap-editplayer-continous-playback-field"><?php esc_html_e('Continous playback', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-lyrics"><?php esc_html_e('Lyrics', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-video"><?php esc_html_e('Video', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-accordion" class="hap-editplayer-accordion-field default-skin"><?php esc_html_e('Accordion', HAP_TEXTDOMAIN); ?></div>
                        <div id="hap-tab-general-popup-window" class="hap-editplayer-popup-window-field default-skin"><?php esc_html_e('Popup window', HAP_TEXTDOMAIN); ?></div>
	                    <div id="hap-tab-general-advanced"><?php esc_html_e('Advanced', HAP_TEXTDOMAIN); ?></div>
                    </div>

                    <div class="hap-tabs-sub-options">

                    <div id="hap-tab-general-options-content-sub" class="hap-tab-content-sub">

						<table class="form-table">

							<input type="hidden" name="addPlaylistEvents" value="<?php echo($options['addPlaylistEvents']); ?>">
				            <input type="hidden" name="addResizeEvent" value="<?php echo($options['addResizeEvent']); ?>">
				            <input type="hidden" name="connectedPlayerAction" value="<?php echo($options['connectedPlayerAction']); ?>">

						    <tr valign="top">
						        <th><?php esc_html_e('Active song to start with', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="number" name="activeItem" min="-1" required value="<?php echo($options['activeItem']); ?>">
						            <p class="info"><?php esc_html_e('Enter number, counting starts from zero (-1 = no song loaded, 0 = first song, 1 = second song etc..)', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Default volume', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="number" min="0" max="1" step="0.1" name="volume" required value="<?php echo($options['volume']); ?>">
						            <p class="info"><?php esc_html_e('Enter number between 0 and 1.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Sort order of songs', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <select name="sortOrder">
						                <?php foreach ($sortOrder as $key => $value) : ?>
						                    <option value="<?php echo($key); ?>" <?php if(isset($options['sortOrder']) && $options['sortOrder'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
						                <?php endforeach; ?>
						            </select>
						            <p class="info"><?php esc_html_e('Sort order of songs in the player on start. No sort order specified means no sort will be applied (tracks will be displayed as listed in backend).', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Get player artwork', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="fetchPlayerArtwork" type="checkbox" value="1" <?php if(isset($options['fetchPlayerArtwork']) && $options['fetchPlayerArtwork'] == "1") echo 'checked' ?>> <?php esc_html_e('This will try to fetch player artwork from Itunes if current song has no artwork.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
								<th><?php esc_html_e('Soundcloud player artwork cover size', HAP_TEXTDOMAIN); ?></th>
								<td>
									<select id="soundCloudThumbQuality" name="soundCloudThumbQuality">
							            <?php foreach ($soundCloudThumbQuality as $key => $value) : ?>
							                <option value="<?php echo($key); ?>" <?php if(isset($options['soundCloudThumbQuality']) && $options['soundCloudThumbQuality'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
							            <?php endforeach; ?>
							        </select>
								</td>
							</tr>

							<tr valign="top">
								<th><?php esc_html_e('Soundcloud thumb quality in playlist', HAP_TEXTDOMAIN); ?></th>
								<td>
									<select id="soundCloudThumbQualityInPlaylist" name="soundCloudThumbQualityInPlaylist">
							            <?php foreach ($soundCloudThumbQuality as $key => $value) : ?>
							                <option value="<?php echo($key); ?>" <?php if(isset($options['soundCloudThumbQualityInPlaylist']) && $options['soundCloudThumbQualityInPlaylist'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
							            <?php endforeach; ?>
							        </select>
							        <p class="info"><?php esc_html_e('Apply Soundcloud thumb quality on playlist thumbs.', HAP_TEXTDOMAIN); ?></p>
								</td>
							</tr>

							<tr valign="top" class="player-opened-on-start-field fixed-skin">
						        <th><?php esc_html_e('Player opened on start', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="playerOpened" type="checkbox" value="1" <?php if(isset($options['playerOpened']) && $options['playerOpened'] == "1") echo 'checked' ?>> <?php esc_html_e('Show fixed player opened on start.', HAP_TEXTDOMAIN); ?></label>

						        </td>
						    </tr>

						    <tr valign="top" class="hide-player-until-music-start-field default-skin">
						        <th><?php esc_html_e('Hide player until music start', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="hidePlayerUntilMusicStart" type="checkbox" value="1" <?php if(isset($options['hidePlayerUntilMusicStart']) && $options['hidePlayerUntilMusicStart'] == "1") echo 'checked' ?>> <?php esc_html_e('This will completely hide player until music first starts. Note that music autoplay is not possible without user interaction, so this can only be used when user clicks an element in page (like a button) to play music. Note: if Youtube is used this feature is not available.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						</table>

					</div>

					<div id="hap-tab-general-elements-content-sub" class="hap-tab-content-sub default-skin">

						<p><?php esc_html_e('Choose which elements to use in player (Note: some skins may not have all elements available).', HAP_TEXTDOMAIN); ?></p>

						<table class="form-table">

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
					            <th><?php esc_html_e('Use AB loop (loop between 2 time points)', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<label><input name="useRange" type="checkbox" value="1" <?php if(isset($options['useRange']) && $options['useRange'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr>

					        <tr valign="top">
					            <th><?php esc_html_e('Use shuffle button (random playback)', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<label><input name="useShuffle" type="checkbox" value="1" <?php if(isset($options['useShuffle']) && $options['useShuffle'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr>

							<tr valign="top">
					            <th><?php esc_html_e('Use loop button (loop playlist on last song)', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<label><input name="useLoop" type="checkbox" value="1" <?php if(isset($options['useLoop']) && $options['useLoop'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr>
						    
						    <tr valign="top">
					            <th><?php esc_html_e('Use playback rate slider', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<label><input name="usePlaybackRate" type="checkbox" value="1" <?php if(isset($options['usePlaybackRate']) && $options['usePlaybackRate'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr>

						</table>

					</div>

					<div id="hap-tab-general-share-content-sub" class="hap-tab-content-sub">

						<table class="form-table">

							<tr valign="top" class="hap-editplayer-use-share-field">
					            <th><?php esc_html_e('Use social sharing buttons', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<label><input name="useShare" id="useShare" type="checkbox" value="1" <?php if(isset($options['useShare']) && $options['useShare'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr>

					        <tr valign="top" class="hap_share_btn">
				                <th><?php esc_html_e('Use Facebook share', HAP_TEXTDOMAIN); ?></th>     
				                <td>
				                	<label><input name="useShareFacebook" type="checkbox" value="1" <?php if(isset($options['useShareFacebook']) && $options['useShareFacebook'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				                </td>
				            </tr>

				            <tr valign="top" class="hap_share_btn">
				                <th><?php esc_html_e('Use Twitter share', HAP_TEXTDOMAIN); ?></th>     
				                <td>
				                	<label><input name="useShareTwitter" type="checkbox" value="1" <?php if(isset($options['useShareTwitter']) && $options['useShareTwitter'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					            </td>
				            </tr>

				            <tr valign="top" class="hap_share_btn">
				                <th><?php esc_html_e('Use Tumblr share', HAP_TEXTDOMAIN); ?></th>     
				                <td>
				                	<label><input name="useShareTumblr" type="checkbox" value="1" <?php if(isset($options['useShareTumblr']) && $options['useShareTumblr'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				                </td>
				            </tr>

				            <tr valign="top" class="hap_share_btn">
				                <th><?php esc_html_e('Use WhatsApp share', HAP_TEXTDOMAIN); ?></th>     
				                <td>
				                	<label><input name="useShareWhatsApp" type="checkbox" value="1" <?php if(isset($options['useShareWhatsApp']) && $options['useShareWhatsApp'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					            </td>
				            </tr>

				            <tr valign="top" class="hap_share_btn">
				                <th><?php esc_html_e('Use Reddit share', HAP_TEXTDOMAIN); ?></th>     
				                <td>
				                	<label><input name="useShareReddit" type="checkbox" value="1" <?php if(isset($options['useShareReddit']) && $options['useShareReddit'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				                </td>
				            </tr>

				            <tr valign="top" class="hap_share_btn">
				                <th><?php esc_html_e('Use Digg share', HAP_TEXTDOMAIN); ?></th>     
				                <td>
				                	<label><input name="useShareDigg" type="checkbox" value="1" <?php if(isset($options['useShareDigg']) && $options['useShareDigg'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				                </td>
				            </tr>

				            <tr valign="top" class="hap_share_btn">
				                <th><?php esc_html_e('Use LinkedIn share', HAP_TEXTDOMAIN); ?></th>     
				                <td>
				                	<label><input name="useShareLinkedIn" type="checkbox" value="1" <?php if(isset($options['useShareLinkedIn']) && $options['useShareLinkedIn'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				                </td>
				            </tr>

				            <tr valign="top" class="hap_share_btn">
				                <th><?php esc_html_e('Use Pinterest share', HAP_TEXTDOMAIN); ?></th>     
				                <td>
				                	<label><input name="useSharePinterest" type="checkbox" value="1" <?php if(isset($options['useSharePinterest']) && $options['useSharePinterest'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				                </td>
				            </tr>

						</table>

					</div>

					<div id="hap-tab-general-keyboard-content-sub" class="hap-tab-content-sub">

						<table class="form-table">

						    <tr valign="top">
						        <th><?php esc_html_e('Use keyboard navigation for controlling playback.', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useKeyboardNavigationForPlayback" type="checkbox" value="1" <?php if(isset($options['useKeyboardNavigationForPlayback']) && $options['useKeyboardNavigationForPlayback'] == "1") echo 'checked' ?>> <?php esc_html_e('Use keyboard navigation for controling playback. By default keyboard controls are only active when mouse is above the player. Supports multiple players per page.', HAP_TEXTDOMAIN); ?></label>
						        	<br><br>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Use global keyboard navigation.', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useGlobalKeyboardControls" type="checkbox" value="1" <?php if(isset($options['useGlobalKeyboardControls']) && $options['useGlobalKeyboardControls'] == "1") echo 'checked' ?>> <?php esc_html_e('If true, keyboard controls are always active. Supports only single player per page. This method may interfere with other keyboard inputs on the page. Use with caution.', HAP_TEXTDOMAIN); ?></label>
						        	<br><br>
						        </td>
						    </tr>

						    <tr valign="top" id="hap-keyboard-controls-field">
						        <th><?php esc_html_e('Keyboard controls', HAP_TEXTDOMAIN); ?></th>
						        <td id="hap-keyboard-controls-field-inner">

				                    <table class="hap-value-table-wrap-orig">
				                      <thead>
				                        <tr>
				                          <th align="left"><?php esc_html_e('Enter key here', HAP_TEXTDOMAIN); ?></th>
				                          <th align="left"><?php esc_html_e('Key', HAP_TEXTDOMAIN); ?></th>
				                          <th align="left"><?php esc_html_e('Action', HAP_TEXTDOMAIN); ?></th>
				                          <th>&nbsp;</th>
				                        </tr>
				                      </thead>
				                      
				                      <tbody>
				                        <tr>
				                          <td><input class="hap-keyboard-key-enter" type="text" maxlength="1"></td>
				                          <td><input class="hap-keyboard-key" type="text" readonly></td>
				                          <td><input class="hap-keyboard-action-display" type="text" readonly></td>
				                          <td><button type="button" class="keyboard-controls-toggle"><?php esc_attr_e('Disable', HAP_TEXTDOMAIN); ?></button></td>


				                          <input class="hap-keyboard-keycode" type="hidden">
				                          <input class="hap-keyboard-action" type="hidden">
				                        </tr>
				                      </tbody>
				                    </table>

							       </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Modifier key', HAP_TEXTDOMAIN); ?></th>
						        <td>

						        	<p><label><?php esc_html_e('Add modifier key (Shift, Alt, or Control) to be used as double keys so you can control with double press.', HAP_TEXTDOMAIN); ?></label></p>

						        	<p><input id="noModifier" type="radio" name="modifierKey" value="" <?php if(isset($options['modifierKey']) && $options['modifierKey'] == "") echo 'checked' ?>><label for="noModifier">None</label></p>

						        	<p><input id="shiftKey" type="radio" name="modifierKey" value="shiftKey" <?php if(isset($options['modifierKey']) && $options['modifierKey'] == "shiftKey") echo 'checked' ?>><label for="shiftKey">Shift</label></p>

									<p><input id="ctrlKey" type="radio" name="modifierKey" value="ctrlKey" <?php if(isset($options['modifierKey']) && $options['modifierKey'] == "ctrlKey") echo 'checked' ?>><label for="ctrlKey">Control</label></p>

									<p><input id="altKey" type="radio" name="modifierKey" value="altKey" <?php if(isset($options['modifierKey']) && $options['modifierKey'] == "altKey") echo 'checked' ?>><label for="altKey">Alt</label></p>

						        </td>
						    </tr>

						</table>

					</div>

					<div id="hap-tab-general-playback-content-sub" class="hap-tab-content-sub">

						<table class="form-table">

						    <tr valign="top">
						        <th><?php esc_html_e('Auto play', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="autoPlay" type="checkbox" value="1" <?php if(isset($options['autoPlay']) && $options['autoPlay'] == "1") echo 'checked' ?>> <?php esc_html_e('Audio autoplay', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Auto play after first', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="autoPlayAfterFirst" type="checkbox" value="1" <?php if(isset($options['autoPlayAfterFirst']) && $options['autoPlayAfterFirst'] == "1") echo 'checked' ?>> <?php esc_html_e('Auto play media after first song has been manually started.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Preload media attribute', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <select name="preload">
						                <?php foreach ($preload as $key => $value) : ?>
						                    <option value="<?php echo($key); ?>" <?php if(isset($options['preload']) && $options['preload'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
						                <?php endforeach; ?>
						            </select>
						        </td>
						    </tr>
						    <tr valign="top">
						        <th><?php esc_html_e('Random play', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="randomPlay" type="checkbox" value="1" <?php if(isset($options['randomPlay']) && $options['randomPlay'] == "1") echo 'checked' ?>> <?php esc_html_e('Randomize playback in playlist.', HAP_TEXTDOMAIN); ?></label>
							    </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Loop state', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <select name="loopState">
						                <?php foreach ($loopState as $key => $value) : ?>
						                    <option value="<?php echo($key); ?>" <?php if(isset($options['loopState']) && $options['loopState'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
						                <?php endforeach; ?>
						            </select>
						            <p><?php esc_html_e('Loop playlist, loop current audio, or off (when last song in playlist ends stop playing)', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Stop on song end', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="stopOnSongEnd" type="checkbox" value="1" <?php if(isset($options['stopOnSongEnd']) && $options['stopOnSongEnd'] == "1") echo 'checked' ?>> <?php esc_html_e('Use this option to stop playback on sound end.', HAP_TEXTDOMAIN); ?></label>
							    </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Toggle playback on clicking playlist item', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="togglePlaybackOnPlaylistItem" type="checkbox" value="1" <?php if(isset($options['togglePlaybackOnPlaylistItem']) && $options['togglePlaybackOnPlaylistItem'] == "1") echo 'checked' ?>> <?php esc_html_e('Clicking on thumbnail will pause play song, instead of always play song from the beginning. Useful for grid layouts where clicking a thumbnail can pause / play a song without the need for sticky player.', HAP_TEXTDOMAIN); ?></label>
							    </td>
						    </tr> 

						    <tr valign="top">
				                <th><?php esc_html_e('Default skip time', HAP_TEXTDOMAIN); ?></th>
				                <td>
				                    <input type="number" min="0" name="seekTime" value="<?php echo($options['seekTime']); ?>">
				                    <p class="info"><?php esc_html_e('Default skip time for skip backward / skip forward buttons (seconds).', HAP_TEXTDOMAIN); ?></p>
				                </td>
				            </tr>

				             <tr valign="top">
						        <th><?php esc_html_e('Playback rate', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="number" min="0.5" max="3" step="0.1" name="playbackRate" value="<?php echo($options['playbackRate']); ?>">
						        </td>
						    </tr>

				            <tr valign="top">
				                <th><?php esc_html_e('Minimum playback rate', HAP_TEXTDOMAIN); ?></th>
				                <td>
				                    <input type="number" min="0.5" step="0.1" name="playbackRateMin" value="<?php echo($options['playbackRateMin']); ?>">
				                </td>
				            </tr>

				            <tr valign="top">
				                <th><?php esc_html_e('Maximum playback rate', HAP_TEXTDOMAIN); ?></th>
				                <td>
				                    <input type="number" min="0.5" step="0.1" name="playbackRateMax" value="<?php echo($options['playbackRateMax']); ?>">
				                </td>
				            </tr>

				            <tr valign="top">
						        <th><?php esc_html_e('Disable seekbar', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="disableSeekbar" type="checkbox" value="1" <?php if(isset($options['disableSeekbar']) && $options['disableSeekbar'] == "1") echo 'checked' ?>> <?php esc_html_e('Disable seekbar so user cannot seek forward (backward can still be seeked).', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Disable song skip', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="disableSongSkip" type="checkbox" value="1" <?php if(isset($options['disableSongSkip']) && $options['disableSongSkip'] == "1") echo 'checked' ?>> <?php esc_html_e('Disable any kind of song change (seek, previous, next, click another song). With this option selected user has to listen full song and cannot change song.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Use audio preview in player', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useAudioPreview" type="checkbox" value="1" <?php if(isset($options['useAudioPreview']) && $options['useAudioPreview'] == "1") echo 'checked' ?>> <?php esc_html_e('Play short song preview snippet in player instead of full song. Requires short audio preview set on song when adding songs to playlist.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Toggle playback between multiple instances in page', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="togglePlaybackOnMultipleInstances" type="checkbox" value="1" <?php if(isset($options['togglePlaybackOnMultipleInstances']) && $options['togglePlaybackOnMultipleInstances'] == "1") echo 'checked' ?>> <?php esc_html_e('For multiple players in page, pause other players when one player is started.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						</table>

					</div> 

					<div id="hap-tab-general-playlist-content-sub" class="hap-tab-content-sub default-skin">  

						<table class="form-table"> 

							<tr valign="top">
					            <th><?php esc_html_e('Use playlist in player', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<label><input name="usePlaylist" type="checkbox" value="1" <?php if(isset($options['usePlaylist']) && $options['usePlaylist'] == "1") echo 'checked' ?>> <?php esc_html_e('Hide visible playlist from the player.', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Use playlist scroll', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="usePlaylistScroll" type="checkbox" value="1" <?php if(isset($options['usePlaylistScroll']) && $options['usePlaylistScroll'] == "1") echo 'checked' ?>> <?php esc_html_e('Use scrollbar in playlist.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Choose scroll in playlist', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <select name="playlistScrollType" id="playlistScrollType">
						                <?php foreach ($playlistScrollTypeArr as $key => $value) : ?>
						                    <option value="<?php echo($key); ?>" <?php if(isset($options['playlistScrollType']) && $options['playlistScrollType'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
						                <?php endforeach; ?>
						            </select>
						            <p><?php esc_html_e('Choose which playlist scroll to use.', HAP_TEXTDOMAIN); ?></p>
						            
						        </td>
						    </tr>

						    <tr valign="top" id="playlistScrollTheme_field">
						        <th><?php esc_html_e('Playlist scroll theme', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <select name="playlistScrollTheme">
						                <?php foreach ($playlistScrollTheme as $key => $value) : ?>
						                    <option value="<?php echo($key); ?>" <?php if(isset($options['playlistScrollTheme']) && $options['playlistScrollTheme'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
						                <?php endforeach; ?>
						            </select>
						            <p><?php esc_html_e('Scroll themes:', HAP_TEXTDOMAIN); ?> <a href="http://manos.malihu.gr/repository/custom-scrollbar/demo/examples/scrollbar_themes_demo.html" target="_blank">http://manos.malihu.gr/repository/custom-scrollbar/demo/examples/scrollbar_themes_demo.html</a></p>
						        </td>
						    </tr>

						    <tr valign="top" class="playlist-opened-on-start-field">
						        <th><?php esc_html_e('Playlist opened on start', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="playlistOpened" type="checkbox" value="1" <?php if(isset($options['playlistOpened']) && $options['playlistOpened'] == "1") echo 'checked' ?>> <?php esc_html_e('Show playlist opened on start instead of player.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						</table>

					</div> 

					<div id="hap-tab-general-playlist-items-content-sub" class="hap-tab-content-sub">  

						<table class="form-table">   

							<tr valign="top" class="playlist-skin">
					            <th><?php esc_html_e('Select playlist items style', HAP_TEXTDOMAIN); ?></th>
					            <td>
					                <select id="infoSkin" name="infoSkin">
					                    <?php foreach ($options['infoSkinArr'] as $key => $value) : ?>
					                        <option value="<?php echo($key); ?>" <?php if(isset($options['infoSkin']) && $options['infoSkin'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
					                    <?php endforeach; ?>
					                </select><br><br>
					                <img id="playlist-grid-style-img" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg=="/>
					            </td>
					        </tr>  

					        <tr valign="top" class="playlist-skin">
				                <th><?php esc_html_e('Play icon shown over thumbnail', HAP_TEXTDOMAIN); ?></th>
				                <td>
				                    <img id="gridPlayIcon_preview" class="hap-img-preview" src="<?php echo (isset($options['gridPlayIcon']) ? esc_html($options['gridPlayIcon']) : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D'); ?>" alt="">
				                    <input type="text" id="gridPlayIcon" name="gridPlayIcon" value="<?php echo($options['gridPlayIcon']); ?>"> 
				                    <button type="button" id="gridPlayIcon_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
				                    <button type="button" id="gridPlayIcon_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button>       
				                    <br><span class="info"><?php esc_html_e('Icon which is shown over thumbnail when song is paused.', HAP_TEXTDOMAIN); ?></span><div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/gridPlayIcon.jpg' ?>"/></p></div>
				                </td>
				            </tr>

					        <tr valign="top" class="playlist-skin">
				                <th><?php esc_html_e('Pause icon shown over thumbnail', HAP_TEXTDOMAIN); ?></th>
				                <td>
				                    <img id="gridPauseIcon_preview" class="hap-img-preview" src="<?php echo (isset($options['gridPauseIcon']) ? esc_html($options['gridPauseIcon']) : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D'); ?>" alt="">
				                    <input type="text" id="gridPauseIcon" name="gridPauseIcon" value="<?php echo($options['gridPauseIcon']); ?>"> 
				                    <button type="button" id="gridPauseIcon_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
				                    <button type="button" id="gridPauseIcon_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button>       
				                    <br><span class="info"><?php esc_html_e('Icon which is shown over thumbnail when song is playing.', HAP_TEXTDOMAIN); ?><div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/gridPauseIcon.jpg' ?>"/></p></div>
				                </td>
				            </tr>
				            
						    <tr valign="top">
						        <th><?php esc_html_e('Use numbers in front of titles in playlist', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useNumbersInPlaylist" type="checkbox" value="1" <?php if(isset($options['useNumbersInPlaylist']) && $options['useNumbersInPlaylist'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>
						  
						    <tr valign="top" class="default-skin">
						        <th><?php esc_html_e('Playlist item multiline width', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input name="playlistItemMultilineWidth" type="number" min="0" value="<?php echo($options['playlistItemMultilineWidth']); ?>">
						            <p class="info"><?php esc_html_e('Player width at which icons in playlist items (link, download, statistics icons) go into second line to make room for playlist titles.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Playlist item content', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <div class="item-content-list">
						                <?php 

						                $playlistItemContent = is_array($options['playlistItemContent']) ? $options['playlistItemContent'] : explode(",", $options['playlistItemContent']);

						                foreach ($playlistItemContentArr as $key => $value) :
						                ?>
						                    <label class="container">
						                        <input type="checkbox" name="playlistItemContent[]" value="<?php echo($key); ?>"<?php if(in_array($key, $playlistItemContent)) echo 'checked' ?>><?php echo($value); ?>
						                    </label>
						                <?php endforeach; ?>
						            </div>
						            <p class="info"><?php esc_html_e('Select content to show in playlist items. Description, date may be available for Podcast, Soundcloud, Youtube.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Order of title and artist', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <div class="item-content-list" id="playlistTitleOrder_field">
						                <?php foreach ($options['playlistTitleOrder'] as $key => $value) : ?>
						                	<div class="afof"><?php echo($value); ?>
						                    	<input type="hidden" name="playlistTitleOrder[]" value="<?php echo($value); ?>">
						                    </div>
						                <?php endforeach; ?>
						            </div>
						            <p class="info"><?php esc_html_e('Drag to change order of title and artist display in playlist items (which comes first).', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Artist title separator', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<input name="artistTitleSeparator" type="text" value="<?php echo($options['artistTitleSeparator']); ?>">
						        	<p class="info"><?php esc_html_e('Separator between artist and title in playlist (artist name - song name).', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Limit description text', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<input type="number" min="0" name="limitDescriptionText" value="<?php echo($options['limitDescriptionText']); ?>">
						          
						            <p class="info"><?php esc_html_e('Limit number of characters in playlist item description text (useful for Podcast, Soundcloud, Youtube where there might be large ammount of description text). 0 means no limit.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Create Read More in description', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="createReadMoreInDescription" type="checkbox" value="1" <?php if(isset($options['createReadMoreInDescription']) && $options['createReadMoreInDescription'] == "1") echo 'checked' ?>> <?php esc_html_e('Create Read more button and shorten description in playlist items. Used in combination with Limit description text', HAP_TEXTDOMAIN); ?></label>

						        	<div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/read-more.jpg' ?>"/></p></div>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Use inline seekbar', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useInlineSeekbar" type="checkbox" value="1" <?php if(isset($options['useInlineSeekbar']) && $options['useInlineSeekbar'] == "1") echo 'checked' ?>> <?php esc_html_e('Use inline seekbar inside active song playlist thumbnail which show song play progress. Useful for grid layout if you dont use sticky player', HAP_TEXTDOMAIN); ?></label>

						        	<div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/inline-seekbar.jpg' ?>"/></p></div>
						        </td>
						    </tr>

							<tr valign="top">
						        <th><?php esc_html_e('Create download icons in playlist (if download is available) for Podcast, Sondcloud, Folder and Google drive', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="createDownloadIconsInPlaylist" type="checkbox" value="1" <?php if(isset($options['createDownloadIconsInPlaylist']) && $options['createDownloadIconsInPlaylist'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>

						        	<div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/dl-icons-in-playlist.jpg' ?>"/></p></div>

						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Create link icons in playlist for Podcast, Sondcloud, Folder and Google drive', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="createLinkIconsInPlaylist" type="checkbox" value="1" <?php if(isset($options['createLinkIconsInPlaylist']) && $options['createLinkIconsInPlaylist'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>

						        	<div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/dl-icons-in-playlist.jpg' ?>"/></p></div>

						        </td>
						    </tr>

						</table>

					</div> 

					<div id="hap-tab-general-pagination-content-sub" class="hap-tab-content-sub playlist-skin">  

						<table class="form-table">   

							<tr valign="top">
				                <th><?php esc_html_e('Use pagination', HAP_TEXTDOMAIN); ?></th>
				                <td>

				                    <label><input name="usePagination" type="checkbox" value="1" <?php if(isset($options['usePagination']) && $options['usePagination'] == "1") echo 'checked' ?>> <?php esc_html_e('Use pagination with Grid layout. Pagination buttons will be created below the grid.', HAP_TEXTDOMAIN); ?></label>

				                    <div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/pag-help.jpg' ?>"/></p></div>

				                </td>
				            </tr>

				            <tr valign="top">
								<th><?php esc_html_e('Pagination items per page', HAP_TEXTDOMAIN); ?></th>
								<td>
									<input type="number" name="paginationPerPage" min="0" value="<?php echo (isset($options['paginationPerPage']) ? $options['paginationPerPage'] : ''); ?>">
									<p class="info"><?php esc_html_e('How many items to display per page.', HAP_TEXTDOMAIN); ?></p>
								</td>
							</tr>

						</table>

					</div> 

					<div id="hap-tab-general-search-field-content-sub" class="hap-tab-content-sub">  

						<table class="form-table">   

							<tr valign="top">
					            <th><?php esc_html_e('Use search song field', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<label><input name="useSearch" type="checkbox" value="1" <?php if(isset($options['useSearch']) && $options['useSearch'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr> 

						    <tr valign="top">
				                <th><?php esc_html_e('Custom Search field', HAP_TEXTDOMAIN); ?></th>
				                <td>
				                    <input type="text" name="searchSelector" value="<?php echo($options['searchSelector']); ?>">
				                    <p class="info"><?php esc_html_e('Use your own input search field for the playlist songs. Specify DOM selector (ID/Classname) for your search field.', HAP_TEXTDOMAIN); ?></p>
				                </td>
				            </tr>

						</table>

					</div> 

					<div id="hap-tab-general-continous-playback-content-sub" class="hap-tab-content-sub default-skin">  

						<table class="form-table">       

						    <tr valign="top">
						        <th><?php esc_html_e('Use continous playback', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useContinousPlayback" type="checkbox" value="1" <?php if(isset($options['useContinousPlayback']) && $options['useContinousPlayback'] == "1") echo 'checked' ?>> <?php esc_html_e('Remember playback position when going to different page (remembers last played song).', HAP_TEXTDOMAIN); ?></label>
							    </td>
						    </tr>

						</table>

	                </div>

					<div id="hap-tab-general-lyrics-content-sub" class="hap-tab-content-sub">

					<p><?php esc_html_e('Song lyrics options.', HAP_TEXTDOMAIN); ?></p>

						<table class="form-table">

							<tr valign="top">
						        <th><?php esc_html_e('Auto open lyrics dialog on song start', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="lyricsAutoOpen" type="checkbox" value="1" <?php if(isset($options['lyricsAutoOpen']) && $options['lyricsAutoOpen'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Auto scroll lyrics container as song plays', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="lyricsAutoScroll" type="checkbox" value="1" <?php if(isset($options['lyricsAutoScroll']) && $options['lyricsAutoScroll'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						</table>

					</div>

					<div id="hap-tab-general-video-content-sub" class="hap-tab-content-sub">

						<p><?php esc_html_e('Settings for syncronize video with playing audio.', HAP_TEXTDOMAIN); ?></p>

						<table class="form-table">

							<tr valign="top">
						        <th><?php esc_html_e('Use video controls', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useVideoControls" type="checkbox" value="1" <?php if(isset($options['useVideoControls']) && $options['useVideoControls'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top" class="video-controls-field">
						        <th><?php esc_html_e('Use fullscreen button in video', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useVideoFullscreen" type="checkbox" value="1" <?php if(isset($options['useVideoFullscreen']) && $options['useVideoFullscreen'] == "1") echo 'checked' ?>> <?php esc_html_e('Use video controls needs to be true for this to work.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top" class="video-controls-field">
						        <th><?php esc_html_e('Use picture in picture button in video', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useVideoPictureInPicture" type="checkbox" value="1" <?php if(isset($options['useVideoPictureInPicture']) && $options['useVideoPictureInPicture'] == "1") echo 'checked' ?>> <?php esc_html_e('Use video controls needs to be true for this to work.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top" class="video-controls-field">
						        <th><?php esc_html_e('Use download button in video', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useVideoDownload" type="checkbox" value="1" <?php if(isset($options['useVideoDownload']) && $options['useVideoDownload'] == "1") echo 'checked' ?>> <?php esc_html_e('Use video controls needs to be true for this to work.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Auto open video dialog on song start', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="videoAutoOpen" type="checkbox" value="1" <?php if(isset($options['videoAutoOpen']) && $options['videoAutoOpen'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						</table>

					</div>

	                <div id="hap-tab-general-accordion-content-sub" class="hap-tab-content-sub default-skin">

	                	<p><?php esc_html_e('Settings when loading audio files with accordion mode.', HAP_TEXTDOMAIN); ?></p>

	                	<table class="form-table">

		                	<tr valign="top">
						        <th><?php esc_html_e('Allow only one opened accordion item at once.', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="allowOnlyOneOpenedAccordion" type="checkbox" value="1" <?php if(isset($options['allowOnlyOneOpenedAccordion']) && $options['allowOnlyOneOpenedAccordion'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						</table>    

	                </div>

	                <div id="hap-tab-general-popup-window-content-sub" class="hap-tab-content-sub default-skin">

	                	<table class="form-table">

	                		<tr valign="top">
					            <th><?php esc_html_e('Use button to open popup window', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<label><input name="usePopup" type="checkbox" value="1" <?php if(isset($options['usePopup']) && $options['usePopup'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr>

		                	<tr valign="top">
						        <th><?php esc_html_e('Document title in popup window', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="text" name="popupWindowTitle" value="<?php echo($options['popupWindowTitle']); ?>">
						        </td>
						    </tr>

						    <tr valign="top">
					            <th><?php esc_html_e('Auto open popup window', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<label><input name="autoOpenPopupWindow" type="checkbox" value="1" <?php if(isset($options['autoOpenPopupWindow']) && $options['autoOpenPopupWindow'] == "1") echo 'checked' ?>> <?php esc_html_e('Auto open popup window on page load', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr>

					    </table>

	                </div>

	                <div id="hap-tab-general-advanced-content-sub" class="hap-tab-content-sub">

	                	<p>Here are some more advanced player options.</p>

	                	<table class="form-table">

	                		<tr valign="top" class="default-skin">
						        <th><?php esc_html_e('Breakpoints', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        <?php $breakPointArr = '';
							    if(isset($options['breakPointArr']))$breakPointArr = is_array($options['breakPointArr']) ? implode(",", $options['breakPointArr']) : $options['breakPointArr']; ?>

						            <input type="text" name="breakPointArr" value="<?php echo($breakPointArr); ?>">
						            <p class="info"><?php esc_html_e('Add responsive breakpoints which will be used with css, separated by comma.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

					        <tr valign="top">
					            <th><?php esc_html_e('Clear dialog cache on player start', HAP_TEXTDOMAIN); ?></th>
					            <td>
					                <label><input name="clearDialogCacheOnStart" type="checkbox" value="1" <?php if(isset($options['clearDialogCacheOnStart']) && $options['clearDialogCacheOnStart'] == "1") echo 'checked' ?>> <?php esc_html_e('Clear dialog position and size in browser (lyrics, video)', HAP_TEXTDOMAIN); ?></label>
					            </td>
					        </tr>

	                		<tr valign="top">
					            <th><?php esc_html_e('DOM selector', HAP_TEXTDOMAIN); ?></th>
					            <td>
					                <input type="text" name="selectorInit" value="<?php echo($options['selectorInit']); ?>">
					                <p class="info"><?php esc_html_e('Specify dom selector (ID/Classname) which will open player on click. In this case player will be initalized when user clicks on selector.', HAP_TEXTDOMAIN); ?></p>
					            </td>
					        </tr>

					        <tr valign="top">
					            <th><?php esc_html_e('Additional classes', HAP_TEXTDOMAIN); ?></th>
					            <td>
					                <input type="text" name="customClass" value="<?php echo($options['customClass']); ?>">
					                <p class="info"><?php esc_html_e('Add additional classes for the player (separated by space). You can target specific element in the player using this format .foo|my-class (this will attach my-class to element .foo). Use comma to target multiple elements: .foo|my-class,.doh|class-a,class-b Without the pipe symbol class will be added to the top player element.', HAP_TEXTDOMAIN); ?></p>
					            </td>
					        </tr>
					        
		                	<tr valign="top">
						        <th><?php _e('Display all playlists in page', 'aptean'); ?></th>
						        <td>
						        	<label><input name="displayAllPlaylistsInPage" type="checkbox" value="1" <?php if(isset($options['displayAllPlaylistsInPage']) && $options['displayAllPlaylistsInPage'] == "1") echo 'checked' ?>> <?php esc_html_e('If true, display all playlists in page (from Playlist manager) when player runs. Useful if you want to use API method to load a playlist on frontend page. If false, display just active playlist from shortcode.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top" class="default-skin">
						        <th><?php esc_html_e('Hide Youtube after start', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="hideYoutubeAfterStart" type="checkbox" value="1" <?php if(isset($options['hideYoutubeAfterStart']) && $options['hideYoutubeAfterStart'] == "1") echo 'checked' ?>> <?php esc_html_e('Hide youtube player after video has started. By default Youtube player is shown above player artwork cover area.', HAP_TEXTDOMAIN); ?></label>
							    </td>
						    </tr>

						    <tr valign="top">
					            <th><?php esc_html_e('Link icon in playlist', HAP_TEXTDOMAIN); ?></th>
					            <td>
					            	<textarea name="linkIcon" id="linkIcon"><?php echo($options['linkIcon']); ?></textarea>
					            	<p class="info"><?php esc_html_e('Note: skin brona uses Material icons by default. Other skins use svg icons. Tip: you can add text instead of icon, for example enter "BUY" and then style it with css and you have a text button.', HAP_TEXTDOMAIN); ?></p>

					            	<div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/dl-icons-in-playlist.jpg' ?>"/></p></div>
					            </td>
					        </tr>

					        <tr valign="top">
					            <th><?php esc_html_e('Download icon in playlist', HAP_TEXTDOMAIN); ?></th>
					            <td>
					                <textarea name="downloadIcon" id="downloadIcon"><?php echo($options['downloadIcon']); ?></textarea>

					                <div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/dl-icons-in-playlist.jpg' ?>"/></p></div>

					            </td>
					        </tr>

					    </table>

	                </div>

	                </div>

	                </div>

	                </div><!-- hap-tabs-sub-options -->

	                <div id="hap-tab-stats-content" class="hap-tab-content">

	                	<p><?php esc_html_e('Song statistics options', HAP_TEXTDOMAIN); ?></p>

	                	<table class="form-table">

		                	<tr valign="top">
						        <th><?php esc_html_e('Use song statistics', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useStatistics" type="checkbox" value="1" <?php if(isset($options['useStatistics']) && $options['useStatistics'] == "1") echo 'checked' ?>> <?php esc_html_e('Count plays, likes, downloads, finishes.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Percent listened to count as played', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="number" min="1" max="100" name="percentToCountAsPlay" value="<?php echo($options['percentToCountAsPlay']); ?>">
						            <p class="info"><?php esc_html_e('Set percentage of song that user needs to listen to be counted as played. 100 means full song. Default is 25. Note that user can skip song which may interfere with results. You can disable song skip in Player options.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

					    	<tr valign="top">
						        <th><?php esc_html_e('Statistic icons to show in player', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <div class="item-content-list">
						                <?php

										$statisticsContent = is_array($options['statisticsContent']) ? $options['statisticsContent'] : explode(",", $options['statisticsContent']);

						                foreach ($statisticsContentArr as $key => $value) : ?>
						                    <label class="container">
						                        <input type="checkbox" name="statisticsContent[]" value="<?php echo($key); ?>" <?php if(in_array($key, $statisticsContent)) echo 'checked' ?>><?php echo($value); ?>
						                    </label>
						                <?php endforeach; ?>
						            </div><br>
						            <span class="info"><?php esc_html_e('Select Statistic icons to display in playlist items. Use song statistics option need to be true.', HAP_TEXTDOMAIN); ?></span>

						            <div class="hap-help-tip"><p><img src="<?php echo plugins_url().'/apmap/assets/help/stat-icons.jpg' ?>"/></p></div>

						        </td>
						    </tr>

					    </table>

                	</div>

	                <div id="hap-tab-radio-content" class="hap-tab-content">

	                	<p><?php esc_html_e('Options for radio can be adjusted here.', HAP_TEXTDOMAIN); ?></p>

	                	<table class="form-table">
				    	
				    		<tr valign="top">
						        <th><?php esc_html_e('Get radio artwork', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="getRadioArtwork" type="checkbox" value="1" <?php if(isset($options['getRadioArtwork']) && $options['getRadioArtwork'] == "1") echo 'checked' ?>> <?php esc_html_e('Get radio artwork for the player. If you want to specify your own artwork set this to false.', HAP_TEXTDOMAIN); ?></label>
							    </td>
						    </tr>
						    <tr valign="top">
						        <th><?php esc_html_e('Default song artist text', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="text" name="defaultSongArtist" value="<?php echo($options['defaultSongArtist']); ?>">
						            <p class="info"><?php esc_html_e('Default song artist when current playing song in not available.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>
						    <tr valign="top">
						        <th><?php esc_html_e('Default song title text', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="text" name="defaultSongTitle" value="<?php echo($options['defaultSongTitle']); ?>">
						            <p class="info"><?php esc_html_e('Default song title when current playing song in not available.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>
						     <tr valign="top">
						        <th><?php esc_html_e('Enable cors', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="enableCors" type="checkbox" value="1" <?php if(isset($options['enableCors']) && $options['enableCors'] == "1") echo 'checked' ?>> <?php esc_html_e('Enable cors for getting radio data. You can try to set this to false if you have Shoutcast SSL stream for example, or some radio stations simply work without cors.', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>
						    <tr valign="top">
						        <th><?php esc_html_e('Cors url', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="text" name="cors" value="<?php echo($options['cors']); ?>">
						            <p class="info"><?php esc_html_e('Proxy url for getting radio data. You can enter multiple cors urls for backup separated by comma.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>
						    <tr valign="top">
						        <th><?php esc_html_e('Use cors for audio', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useCorsForAudio" type="checkbox" value="1" <?php if(isset($options['useCorsForAudio']) && $options['useCorsForAudio'] == "1") echo 'checked' ?>> <?php esc_html_e('This will add cors infront of radio url for radio playback. You can use this option for example if you have SSL website with HTTPS proxy url.', HAP_TEXTDOMAIN); ?></label>
							    </td>
						    </tr>
						    <tr valign="top">
						        <th><?php esc_html_e('Last played interval', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="number" name="lastPlayedInterval" min="0" value="<?php echo($options['lastPlayedInterval']); ?>">
						            <p class="info"><?php esc_html_e('Last played interval at which current playing song and song history is retrieved (miliseconds). It is advised not to set this too low so it doesnt query often.', HAP_TEXTDOMAIN); ?></p>
						        </td>
						    </tr>

						</table>

	                </div>

	                <div id="hap-tab-ads-content" class="hap-tab-content">

	                	<p><?php esc_html_e('Audio advertising options. 3 types of audio ads exist. Ad before main song starts (ad pre), ad during main song play in specified interval (ad mid), ad after main song ends (ad end). Audio ads can be defined in Ads section (create ads for all songs in playlist) or every song can have its own ads defined in Edit Playlist / Edit Media.', HAP_TEXTDOMAIN); ?></p>

	                	<table class="form-table">

		                	<tr valign="top">
						        <th><?php esc_html_e('Pause main audio while audio ad mid plays', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="pauseAudioDuringAds" type="checkbox" value="1" <?php if(isset($options['pauseAudioDuringAds']) && $options['pauseAudioDuringAds'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

				            <tr valign="top">
				                <th><?php esc_html_e('Allow only logged in users to listen songs without ads', HAP_TEXTDOMAIN); ?></th>
				                <td>
				                	<label><input name="viewSongWithoutAdsForLoggedInUser" type="checkbox" value="1" <?php if(isset($options['viewSongWithoutAdsForLoggedInUser']) && $options['viewSongWithoutAdsForLoggedInUser'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
				                </td>
				            </tr>

				            <tr valign="top">
				                <th><?php esc_html_e('Select user role which is able to listen songs without ads', HAP_TEXTDOMAIN); ?></th>
				                <td>
				                    <div class="item-content-list">

				                        <?php 

										$userRoles = hap_get_editable_roles();

										$viewSongWithoutAdsUserRoles = is_array($options['viewSongWithoutAdsUserRoles']) ? $options['viewSongWithoutAdsUserRoles'] : explode(",", $options['viewSongWithoutAdsUserRoles']);

				                        foreach ($userRoles as $key => $value) : ?>

				                            <label class="container">
				                                <input type="checkbox" name="viewSongWithoutAdsUserRoles[]" value="<?php echo($key); ?>" <?php if(in_array($key, $viewSongWithoutAdsUserRoles)) echo 'checked' ?>><?php echo($value["name"]); ?>
				                            </label>
				                        <?php endforeach; ?>

				                        <p class="info"><?php esc_html_e('Only selected user roles can listen songs without ads. If no user roles are selected everybody will have ads playing.', HAP_TEXTDOMAIN); ?></p>

				                    </div>
				                </td>
				            </tr>
				           
				        </table>

	                </div>

	                <div id="hap-tab-ga-content" class="hap-tab-content">

	                	<table class="form-table">

		                	<tr valign="top">
						        <th><?php esc_html_e('Use Google analytics', HAP_TEXTDOMAIN); ?></th>
						        <td>
						        	<label><input name="useGa" type="checkbox" value="1" <?php if(isset($options['useGa']) && $options['useGa'] == "1") echo 'checked' ?>> <?php esc_html_e('Yes', HAP_TEXTDOMAIN); ?></label>
						        </td>
						    </tr>

						    <tr valign="top">
						        <th><?php esc_html_e('Google analytics tracking ID', HAP_TEXTDOMAIN); ?></th>
						        <td>
						            <input type="text" name="gaTrackingId" value="<?php echo(isset($options['gaTrackingId']) ? $options['gaTrackingId'] : ''); ?>">
						            <p class="info"><?php printf(__( 'Get tracking ID <a href="%s" target="_blank">here</a>', HAP_TEXTDOMAIN), esc_url( 'https://support.google.com/analytics/answer/1008080' ));?></p>
						        </td>
						    </tr>

					    </table>

	                </div>

	                <div id="hap-tab-translation-content" class="hap-tab-content">

	                	<table class="form-table">

	                		<tr valign="top">
						        <th><?php esc_html_e('Choose player language', HAP_TEXTDOMAIN); ?></th>
							    <td>

									<select name="playerLanguage" id="playerLanguage">
						                <?php foreach ($playerLanguageArr as $key => $value) : ?>
						                    <option value="<?php echo($key); ?>" <?php if(isset($options['playerLanguage']) && $options['playerLanguage'] == $key) echo 'selected' ?>><?php echo($value); ?></option>
						                <?php endforeach; ?>
						            </select>
						          
						            <button id="hap-translation-edit" type="button"><?php esc_html_e('Edit language', HAP_TEXTDOMAIN); ?></button>
					            </td>
						    </tr>

						</table>    

				        <div id="hap-translation-edit-content-field" style="display: none;">

						<?php 

	                	if(strpos($preset, 'list') !== false || strpos($preset, 'grid') !== false){
					        require_once(dirname(__FILE__)."/translation2.php");
					    }else{
					        require_once(dirname(__FILE__)."/translation.php");
					    }

	                	?>

	                	</div>

	                </div>

	                <div id="hap-tab-colors-content" class="hap-tab-content">

	                	<table class="form-table">

	                	<?php $skin = $preset;

	                	if(strpos($preset, 'art_wide') !== false || strpos($preset, 'art_narrow') !== false){
					        $rem = ["_light", "_dark"];
					        $skin = str_replace($rem, "", $skin);
					    }
					    else if(strpos($preset, 'tiny') !== false){
					        $skin = 'tiny';
					    }
					    else if(strpos($preset, 'compact') !== false){
					        $skin = 'compact';
					    }
					    else if(strpos($preset, 'brona') !== false){
					        $skin = 'brona';
					    }

	                	require_once(dirname(__FILE__)."/preset_config/".$skin.".php"); 

	                	require_once(dirname(__FILE__)."/preset_config/_general.php"); ?>

	                	</table>

	                </div>

	                <div id="hap-tab-custom-css-content" class="hap-tab-content">

	                	<p>Add custom css here.</p>

	                	<textarea id="hap_custom_css_field" style="display:none;"><?php echo($custom_css); ?></textarea>

	                </div>

	                <div id="hap-tab-custom-js-content" class="hap-tab-content">

		                <p>Add custom javascript for the player.</p>

		                <textarea id="hap_custom_js_field" style="display:none;"><?php echo(esc_textarea($custom_js)); ?></textarea>
		               
		            </div>

	      	    </div>

	      	</div>

        </div>

		<?php wp_nonce_field('hap_edit_player_action', 'hap_edit_player_nonce_field'); ?>

        <div id="hap-sticky-action" class="hap-sticky">
            <div id="hap-sticky-action-inner">
                <button id="hap-edit-player-options-submit" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Save Changes', HAP_TEXTDOMAIN); ?></button> 

                <a class="button-secondary" href="<?php echo admin_url("admin.php?page=hap_player_manager"); ?>"><?php esc_html_e('Back to Player list', HAP_TEXTDOMAIN); ?></a>
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