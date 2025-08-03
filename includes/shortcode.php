<?php

$GLOBALS['hap_inline_js'] = '';
$GLOBALS['hap_sticky_player_added'] = '0';

function hap_add_player($atts, $content = null){


	static $hap_unique_player_id = 0;

    if(isset($atts['instance_id'])){
        $instance_id = $atts['instance_id'];
        $wrapper_id = 'hap-wrapper'.$instance_id;
        $instance = 'hap_player'.$instance_id;
    }else{
        $instance_id = $hap_unique_player_id;
        $wrapper_id = 'hap-wrapper'.$hap_unique_player_id;
        $instance = 'hap_player'.$hap_unique_player_id;
        $atts['instance_id'] = $instance_id;
    }

    $loadGoogleFontsLocally = false;

    $g_settings1 = hap_player_global_settings();

    //general settings
    global $wpdb;
    $wpdb->show_errors(); 
    $settings_table = $wpdb->prefix . "map_settings";
    $result = $wpdb->get_row("SELECT options FROM {$settings_table} WHERE id = '0'", ARRAY_A);
    if($result){
        
        $g_settings2 = unserialize($result['options']);
        $settings = $g_settings2 + $g_settings1;

        $js_to_footer = hap_intToBool($settings["js_to_footer"]);

         if(isset($settings["loadGoogleFontsLocally"]) && $settings["loadGoogleFontsLocally"] == '1') $loadGoogleFontsLocally = true;
    }else{
        $settings = $g_settings1;
        $js_to_footer = false;
    }

    //get player options
    include_once('player_options.php');
    $default_options = hap_player_options();
    $custom_css = null;

    

	if(isset($atts['player_id'])){
        $player_id = $atts['player_id'];

		//get player options
		global $wpdb;
		$wpdb->show_errors(); 
		$player_table = $wpdb->prefix . "map_players";
		$stmt = $wpdb->prepare("SELECT preset, options, custom_css, custom_js FROM {$player_table} WHERE id = %d", $player_id);
		$result = $wpdb->get_row($stmt, ARRAY_A);
        if($result == NULL){
            return "Player ID does not exist!";
            wp_die();
        }
        $custom_css = stripslashes($result['custom_css']);
        $custom_js = stripslashes($result['custom_js']);

        $player_options = unserialize($result['options']);
        $preset = $result["preset"];
        $options1 = array_merge($default_options, hap_player_options_preset($preset));
        $options = array_merge($options1, $player_options);

	}else{//create preset and playlist on the fly 

        $player_id = $hap_unique_player_id;

        if(empty($atts['preset'])){
            if(isset($atts['hap_overwrite']) && $atts['hap_overwrite'] === 'single' && isset($settings['overide_wp_audio_skin']))$preset = $settings['overide_wp_audio_skin'];
            else if(isset($atts['hap_overwrite']) && $atts['hap_overwrite'] === 'playlist' && isset($settings['overide_wp_audio_playlist_skin']))$preset = $settings['overide_wp_audio_playlist_skin'];
            else $preset = 'art_wide_light';
        }else{
            $preset = $atts['preset'];
        }

        $options = array_replace($default_options, hap_player_options_preset($preset));
        $custom_css = NULL;
        $custom_js = NULL;

    }

    $options['preset'] = $preset;



    //merge settings
    $options = $settings + $options;


    //override some options
    if(is_array($atts) && count($atts) > 0){
        foreach($atts as $att => $item){
            if($att != 'player_id' && $att != 'playlist_id'){
                $options[hap_underscoreToCamelCase($att)] = $item;
            }
        }
    }



/*
    echo '<pre>';
    var_dump($options);
    echo '</pre>';
    exit;*/

    $skin = $preset;

    //correct skin names
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
    else if($skin == 'artwork' || $skin == 'classic'){//deprecated
        $skin = 'brona';
    }



    if($skin == 'grid'){
        $options['usePlaylistScroll'] = '0';
        $options['addResizeEvent'] = '0';
    }

    

    //css
    $css = '';

    //grid icons
    if($skin == 'grid'){
        if($options['gridPlayIcon']) $css .= '.hap-grid .hap-playlist-thumb-style{
            background-image: url('.$options['gridPlayIcon'].');
        }';
        if($options['gridPauseIcon']) $css .= '.hap-playlist-thumb-style-pause{
            background-image: url('.$options['gridPauseIcon'].')!important;
        }';
    }
    
    //playlist opened   
    if($skin == 'art_narrow'){

        if($options['playlistOpened'] == '1'){
            $playerOpened = '100%';
            $playlistOpened = '0';
        }else{
            $playerOpened = '0';
            $playlistOpened = '-100%';
        }

        $css .= $playlistOpened_markup = "#".$wrapper_id." .hap-player-holder{
            left:".$playerOpened.";
        }'
        #".$wrapper_id." .hap-playlist-holder{
            left:".$playlistOpened.";
        }";

    }
    else if($skin == 'art_wide' || $skin == 'brona'){
        if($options['playlistOpened'] == '1'){
            $playlistOpened = 'auto';
        }else{
            $playlistOpened = '0';
        }    

        $css .= $playlistOpened_markup = "#".$wrapper_id." .hap-playlist-holder{
            height:".$playlistOpened.";
        }";

    }
 

    //use playlist scroll
    if($skin == 'brona'){
        $usePlaylistScroll = $options['usePlaylistScroll'] == '1' ? '340px' : 'none;';

        $css .= "#".$wrapper_id." .hap-playlist-inner{
            max-height: ".$usePlaylistScroll.";
        }";

        if($loadGoogleFontsLocally)$css .= hap_skin_css($skin);
    }
    else if($skin == 'art_wide'){
        $usePlaylistScroll = $options['usePlaylistScroll'] == '1' ? '300px' : 'none;';

        $css .= "#".$wrapper_id." .hap-playlist-inner{
            max-height: ".$usePlaylistScroll.";
        }";
    }


    if(!hap_nullOrEmpty($custom_css))$css .= $custom_css;

    //scrollbar
    if($options['playlistScrollType'] == 'mcustomscrollbar'){
        wp_enqueue_style('mCustomScrollbar', plugins_url('apmap/source/css/jquery.mCustomScrollbar.min.css'));
    }else if($options['playlistScrollType'] == 'perfect-scrollbar'){
        wp_enqueue_style('perfect-scrollbar', plugins_url('apmap/source/css/perfect-scrollbar.css'));
    }


    




    //ads
    $ad_options = null;
    if(isset($atts['ad_id'])){

        $ad_id = $atts['ad_id'];

        $ad_table = $wpdb->prefix . "map_ad";
        $results = $wpdb->get_var($wpdb->prepare("SELECT options FROM {$ad_table} WHERE id = %d", $ad_id));
        $ad_options = unserialize($results);

    }

    $playlist = '';
    $playlist_id = '';
    $activePlaylist = '';


    if(isset($atts['playlist_id'])){//get playlist by id

        $pids = explode(',',$atts['playlist_id']);
        $activePlaylist = $pids[0];//active playlist

        if(isset($atts['action'])){

            $action = $atts['action'];

            $days = isset($atts['days']) ? $atts['days'] : 7;
            $limit = isset($atts['limit']) ? $atts['limit'] : 10;

            if($action == 'top_play_today')$results = hap_getTopPlayTodayForPlayback($activePlaylist, $limit);
            else if($action == 'top_play_last_x_days')$results = hap_getTopPlayLastXDaysForPlayback($activePlaylist, $days, $limit);
            else if($action == 'top_play_this_week')$results = hap_getTopPlayThisWeekForPlayback($activePlaylist, $limit);
            else if($action == 'top_play_this_month')$results = hap_getTopPlayThisMonthForPlayback($activePlaylist, $limit);
            else if($action == 'top_play_all_time')$results = hap_getTopPlayAllTimeForPlayback($activePlaylist, $limit);
            else if($action == 'top_download_all_time')$results = hap_getTopDownloadAllTimeForPlayback($activePlaylist, $limit);
            else if($action == 'top_like_all_time')$results = hap_getTopLikeAllTimeForPlayback($activePlaylist, $limit);
            else if($action == 'top_finish_all_time')$results = hap_getTopFinishAllTimeForPlayback($activePlaylist, $limit);
            else return "MAP get stats for playback action parameter incorrect!";

            $playlist = hap_get_playlist($pids, $instance_id, $ad_options, $options, $atts, $results);

        }else{

            $playlist = hap_get_playlist($pids, $instance_id, $ad_options, $options, $atts);

        }

    }else{//direct shortcode
 
        $activePlaylist = '0';

        $playlist = '<div class="hap-playlist-list'.$instance_id.'" style="display:none;">'.PHP_EOL;
        $playlist .= '<div class="hap-playlist-'.$activePlaylist.'">'.PHP_EOL;

            if(!empty($content)){
                $playlist .= do_shortcode($content);
            }else{
                if(isset($options["encryptMediaPaths"]))$encryptMediaPaths = true;
                $playlist .= hap_get_media_fields($atts, $encryptMediaPaths, $ad_options);
                $playlist .= PHP_EOL;
            } 

        $playlist .= '</div>'.PHP_EOL;//end hap-playlist
        $playlist .= '</div>';//end playlist list

    } 


    //lang
    $playerLanguage = $options["playerLanguage"];
    $playerLanguageEdited = isset($options["playerLanguageEdited"]) ? $options["playerLanguageEdited"] : '';

    $locale = hap_locale_data($playerLanguage);
    if($playerLanguageEdited != '1'){
        $options = array_replace($options, $locale);
    }
   
    



    //player markup
    require_once(dirname(__FILE__)."/html/".$skin.".php");
    $html_call = 'hap_html_'.$skin;
    $html = $html_call($preset, $wrapper_id, $options);
  
            
    if($options['useFixedPlayer'] && $GLOBALS['hap_sticky_player_added'] == '0'){
        $GLOBALS['hap_sticky_player_added'] = '1';

        require_once(dirname(__FILE__)."/html/sticky.php");
        $html_call = 'hap_html_sticky';
        $html .= $html_call($preset, $wrapper_id, $options);
  
    }
  




    //js

    $js = '';
    if($js_to_footer == "true"){
        add_action('wp_print_footer_scripts', 'hap_add_inline_js', 100);
        ob_start();
        $GLOBALS['hap_inline_js'] .= hap_get_constructor($options, $activePlaylist, $instance, $wrapper_id, $preset, $instance_id, $player_id, $css, $custom_js, $atts);
        ob_get_contents();
        ob_clean();
        ob_end_clean();
    }else{
        $js = hap_get_constructor($options, $activePlaylist, $instance, $wrapper_id, $preset, $instance_id, $player_id, $css, $custom_js, $atts);
    }



    //taxonomy buttons 
    $tax_output = '';
    if(isset($atts['taxonomy'])){
        $tax_output = hap_getPlaylistTaxonomy($atts);
    }







    //output
    
    $output = $tax_output . $html . $playlist . '</div>' . $js;//end player div, place playlists in player

    $hap_unique_player_id++;

	return $output;

}

function hap_add_inline_js(){
    echo $GLOBALS['hap_inline_js'];
}

function hap_get_constructor($options, $activePlaylist, $instance, $wrapper_id, $preset, $instance_id, $player_id, $css, $custom_js = null, $atts) {

    if(isset($atts['active_playlist'])){
        if($atts['active_playlist'] == '')$activePlaylist = '';
        else $activePlaylist = ".hap-playlist-".$atts['active_playlist'];
    }else if($activePlaylist != ''){
        $activePlaylist = ".hap-playlist-".$activePlaylist;
    }

    $no_conflict = isset($options["no_conflict"]) ? hap_intToBool($options["no_conflict"]) : "false";

    $breakPointArr = '';
    if(isset($options['breakPointArr']))$breakPointArr = is_array($options['breakPointArr']) ? implode(",", $options['breakPointArr']) : $options['breakPointArr'];


    $current_user_roles = hap_get_current_user_roles();

	$markup = '<script>';

        if($css){

            $markup .= 'var htmlDivCss = "'.hap_compressCss($css).'";
            var htmlDiv = document.getElementById("hap-inline-css");
            if(htmlDiv){
                htmlDiv.innerHTML = htmlDiv.innerHTML + htmlDivCss;
            }else{
                var htmlDiv = document.createElement("div");
                htmlDiv.innerHTML = "<style id=\'hap-inline-css\'>" + htmlDivCss + "</style>";
                document.getElementsByTagName("head")[0].appendChild(htmlDiv.childNodes[0]);
            }';

        }

        $markup .= 'if (!/loaded|interactive|complete/.test(document.readyState)) document.addEventListener("DOMContentLoaded",onLoad); else onLoad();  
            function onLoad() {    
                var hapjq=jQuery;
                if('.$no_conflict.' == true){hapjq.noConflict();}

            	var settings = {
                    viewSongWithoutAdsUserRoles: "'.(is_array($options['viewSongWithoutAdsUserRoles']) ? implode(",", $options['viewSongWithoutAdsUserRoles']) : $options['viewSongWithoutAdsUserRoles']).'",
                    isUserLoggedIn: '.hap_intToBool(is_user_logged_in()).',
                    viewSongWithoutAdsForLoggedInUser: '.hap_intToBool($options["viewSongWithoutAdsForLoggedInUser"]).',
                    currentUserRoles: "'.(is_array($current_user_roles) ? implode(",", $current_user_roles) : $current_user_roles).'",
            		instanceName: "'.$instance.'",
                    playerId: "'.$player_id.'",
                    ajax_url: "'.admin_url( 'admin-ajax.php').'",
                    hidePlayerUntilMusicStart: '.hap_intToBool($options["hidePlayerUntilMusicStart"]).',
                    sourcePath: "'.plugins_url('/apmap/source/').'",
                    customClass: "'.$options["customClass"].'",
                    playlistList: ".hap-playlist-list'.$instance_id.'",
                    activePlaylist: "'.$activePlaylist.'",
                    activeItem: '.$options["activeItem"].',
                    volume: '.$options["volume"].',
                    autoPlay: '.hap_intToBool($options["autoPlay"]).',
                    autoPlayAfterFirst: '.hap_intToBool($options["autoPlayAfterFirst"]).',
                    preload: "'.$options["preload"].'",
                    randomPlay: '.hap_intToBool($options["randomPlay"]).',
                    loopState: "'.$options["loopState"].'",
                    stopOnSongEnd: '.hap_intToBool($options["stopOnSongEnd"]).',
                    playbackRate: "'.$options["playbackRate"].'",
                    playbackRateMin: "'.$options["playbackRateMin"].'",
                    playbackRateMax: "'.$options["playbackRateMax"].'",
                    soundCloudAppId: "'.$options["soundcloud_app_id"].'",
                    gDriveAppId: "'.$options["gdrive_app_id"].'",
                    useShare: '.hap_intToBool($options["useShare"]).',
                    soundCloudThumbQuality: "'.$options["soundCloudThumbQuality"].'",
                    soundCloudThumbQualityInPlaylist: "'.$options["soundCloudThumbQualityInPlaylist"].'",
                    facebookAppId: "'.$options["facebook_id"].'",
                    whatsAppWarning: "'.$options["whatsAppWarning"].'",
                    youtubeAppId: "'.(isset($options["youtube_id"]) ? $options["youtube_id"] : '').'",
                    usePlaylistScroll: '.hap_intToBool($options["usePlaylistScroll"]).',
                    useFixedPlayer: '.hap_intToBool($options["useFixedPlayer"]).',
                    fixedPlayerOpened: '.hap_intToBool($options["fixedPlayerOpened"]).',
                    useWaveSeekbarInFixed: '.hap_intToBool($options["useWaveSeekbarInFixed"]).',
                    waveBgColor: "'.$options["waveBgColor"].'",
                    waveProgressColor: "'.$options["waveProgressColor"].'",
                    waveBarWidth: "'.$options["waveBarWidth"].'",
                    waveBarRadius: "'.$options["waveBarRadius"].'",
                    waveBarGap: "'.$options["waveBarGap"].'",
                    playlistScrollType: "'.$options['playlistScrollType'].'",
                    playlistScrollOrientation: "'.$options['playlistScrollOrientation'].'",
                    playlistScrollTheme: "'.$options["playlistScrollTheme"].'",
                    keyboardControls: '.json_encode($options["keyboardControls"], JSON_HEX_TAG).',
                    useKeyboardNavigationForPlayback: '.hap_intToBool($options["useKeyboardNavigationForPlayback"]).',
                    useGlobalKeyboardControls: '.hap_intToBool($options["useGlobalKeyboardControls"]).',
                    modifierKey: "'.$options["modifierKey"].'",
                    useNumbersInPlaylist: '. hap_intToBool($options["useNumbersInPlaylist"]).',
                    useAudioPreview: '. hap_intToBool($options["useAudioPreview"]).',
                    numberTitleSeparator: "'.$options["numberTitleSeparator"].'",
                    togglePlaybackOnPlaylistItem: '.hap_intToBool($options["togglePlaybackOnPlaylistItem"]).',
                    artistTitleSeparator: "'.$options["artistTitleSeparator"].'",
                    playlistItemMultilineWidth: '.$options["playlistItemMultilineWidth"].',
                    playlistClickElement: "'.$options["playlistClickElement"].'",
                    playlistTitleOrder: "'. implode(",", $options['playlistTitleOrder']).'",
                    playlistItemContent: "'.(is_array($options['playlistItemContent']) ? implode(",", $options['playlistItemContent']) : $options['playlistItemContent']).'",
                    statisticsContent: "'.(is_array($options['statisticsContent']) ? implode(",", $options['statisticsContent']) : $options['statisticsContent']).'",
                    clearDialogCacheOnStart: '.hap_intToBool($options["clearDialogCacheOnStart"]).',
                    videoAutoOpen: '.hap_intToBool($options["videoAutoOpen"]).',
                    useVideoControls: '.hap_intToBool($options["useVideoControls"]).',
                    useVideoFullscreen: '.hap_intToBool($options["useVideoFullscreen"]).',
                    useVideoPictureInPicture: '.hap_intToBool($options["useVideoPictureInPicture"]).',
                    useVideoDownload: '.hap_intToBool($options["useVideoDownload"]).', 
                    useInlineSeekbar: '.hap_intToBool($options["useInlineSeekbar"]).', 
                    lyricsAutoScroll: '.hap_intToBool($options["lyricsAutoScroll"]).',
                    lyricsAutoOpen: '.hap_intToBool($options["lyricsAutoOpen"]).',
                    useTitleScroll: '.hap_intToBool($options["useTitleScroll"]).',
                    titleScrollSpeed: "'.$options["titleScrollSpeed"].'",
                    encryptMediaPaths: '.hap_intToBool($options["encryptMediaPaths"]).',
                    titleScrollSeparator: "'.$options["titleScrollSeparator"].'",
                    togglePlaybackOnMultipleInstances: '.hap_intToBool($options["togglePlaybackOnMultipleInstances"]).',
                    useContinousPlayback: '.hap_intToBool($options["useContinousPlayback"]).',
                    continousKey: "'.$options["continousKey"].'",
                    continousPlaybackTrackAllSongs: '.hap_intToBool($options["continousPlaybackTrackAllSongs"]).',
                    useStatistics: '.hap_intToBool($options["useStatistics"]).',
                    percentToCountAsPlay: "'.$options["percentToCountAsPlay"].'",
                    tooltipStatPlays: "'.$options["tooltipStatPlays"].'",
                    tooltipStatLikes: "'.$options["tooltipStatLikes"].'",
                    tooltipStatDownloads: "'.$options["tooltipStatDownloads"].'",
                    downloadIconTitle: "'.$options["downloadIconTitle"].'",
                    linkIconTitle: "'.$options["linkIconTitle"].'",
                    useGa: '.hap_intToBool($options["useGa"]).',
                    gaTrackingId: "'.$options["gaTrackingId"].'",
                    enableCors:'.hap_intToBool($options["enableCors"]).',
                    cors: "'.$options["cors"].'",
                    useCorsForAudio: '.hap_intToBool($options["useCorsForAudio"]).',
                    sortableTracks: '.hap_intToBool($options["sortableTracks"]).',
                    defaultSongArtist: "'.$options["defaultSongArtist"].'",
                    defaultSongTitle: "'.$options["defaultSongTitle"].'",
                    lastPlayedInterval: '.$options['lastPlayedInterval'].',
                    getRadioArtwork: '.hap_intToBool($options["getRadioArtwork"]).',
                    playlistOpened: '.hap_intToBool($options["playlistOpened"]).',
                    playerOpened: '.hap_intToBool($options["playerOpened"]).',
                    limitDescriptionText: "'.$options["limitDescriptionText"].'",
                    createReadMoreInDescription: '.hap_intToBool($options["createReadMoreInDescription"]).',
                    limitDescriptionReadMoreText: "'.$options["limitDescriptionReadMoreText"].'",
                    limitDescriptionReadLessText: "'.$options["limitDescriptionReadLessText"].'",
                    sortOrder: "'.$options["sortOrder"].'",
                    searchDescriptionInPlaylist: '.hap_intToBool($options["searchDescriptionInPlaylist"]).',
                    searchSelector: "'.$options["searchSelector"].'",
                    breakPointArr: "'.$breakPointArr.'",
                    getId3Image: '.hap_intToBool($options["getId3Image"]).',
                    hideYoutubeAfterStart: '.hap_intToBool($options["hideYoutubeAfterStart"]).',
                    forceYoutubeChromeless: '.hap_intToBool($options["forceYoutubeChromeless"]).',
                    popupWindowTitle:"'.$options["popupWindowTitle"].'",
                    createDownloadIconsInPlaylist: '.hap_intToBool($options["createDownloadIconsInPlaylist"]).',
                    createLinkIconsInPlaylist: '.hap_intToBool($options["createLinkIconsInPlaylist"]).',
                    disableSongSkip: '.hap_intToBool($options["disableSongSkip"]).',
                    disableSeekbar: '.hap_intToBool($options["disableSeekbar"]).',
                    pauseAudioDuringAds: '.hap_intToBool($options["pauseAudioDuringAds"]).',
                    fetchPlayerArtwork: '.hap_intToBool($options["fetchPlayerArtwork"]).',
                    allowOnlyOneOpenedAccordion: '.hap_intToBool($options["allowOnlyOneOpenedAccordion"]).',
                    copyCurrentPlaylistToPopup: '.hap_intToBool($options["copyCurrentPlaylistToPopup"]).',
                    paginationPreviousBtnTitle: "'.$options["paginationPreviousBtnTitle"].'",
                    paginationPreviousBtnText: "'.$options["paginationPreviousBtnText"].'",
                    paginationNextBtnTitle: "'.$options["paginationNextBtnTitle"].'",
                    paginationNextBtnText: "'.$options["paginationNextBtnText"].'",
                    popupWidth: "'.$options["popupWidth"].'",
                    popupHeight: "'.$options["popupHeight"].'",'.PHP_EOL;

                    if(isset($options["downloadIcon"])){
                        $downloadIcon = str_replace('"', "'", $options["downloadIcon"]);
                        $markup .= 'downloadIcon: "'.$downloadIcon.'",'.PHP_EOL;
                    } 
                    if(isset($options["linkIcon"])){
                        $linkIcon = str_replace('"', "'", $options["linkIcon"]);
                        $markup .= 'linkIcon: "'.$linkIcon.'",'.PHP_EOL;
                    } 
                    if(isset($options["statDownloadIcon"])){
                        $statDownloadIcon = str_replace('"', "'", $options["statDownloadIcon"]);
                        $markup .= 'statDownloadIcon: "'.$statDownloadIcon.'",'.PHP_EOL;
                    } 
                    if(isset($options["statLikeIcon"])){
                        $statLikeIcon = str_replace('"', "'", $options["statLikeIcon"]);
                        $markup .= 'statLikeIcon: "'.$statLikeIcon.'",'.PHP_EOL;
                    } 
                    if(isset($options["statPlayIcon"])){
                        $statPlayIcon = str_replace('"', "'", $options["statPlayIcon"]);
                        $markup .= 'statPlayIcon: "'.$statPlayIcon.'",'.PHP_EOL;
                    } 


            	$markup .= '}'.PHP_EOL;

            if($options["selectorInit"]){//open player on dom selector click

                if($options["autoOpenPopupWindow"]){//open popup

                    $markup .= 'hapjq("'.$options["selectorInit"].'").one("click", function(){

                        hap_player_auto_instance = {};
                        hap_player_auto_instance.settings = settings;
                        hap_player_auto_instance.wrapper = hapjq("#'.$wrapper_id.'");

                        if(typeof hapOpenPopup === "function")hapOpenPopup(settings);
                    })';

                }else{//normal player

                    $markup .= 'hapjq("'.$options["selectorInit"].'").one("click", function(){
                        var id = hapjq(this).attr("data-media-id");
                        settings.mediaId = id;//if we want to load specific audio on start
                        window.'.$instance.'=hapjq("#'.$wrapper_id.'").hap(settings);
                        return false;
                    })';

                }

            }else if($options["autoOpenPopupWindow"]){ //auto open popup on start    

                $markup .= '

                hap_player_auto_instance = {};
                hap_player_auto_instance.settings = settings;
                hap_player_auto_instance.wrapper = hapjq("#'.$wrapper_id.'");

                if(typeof hapOpenPopup === "function")hapOpenPopup(settings);';

            }else{ 
                $markup .= 'window.'.$instance.'=hapjq("#'.$wrapper_id.'").hap(settings);';
            }

            //custom js
            if(!hap_nullOrEmpty($custom_js))$markup .= $custom_js; 

        

        $markup .= '};</script>'."\n";

	return $markup;

}

function hap_get_playlist($pids, $instance_id, $ad_options, $options, $atts, $medias = null) {

	global $wpdb;
	$media_table = $wpdb->prefix . "map_media";
    $playlist_table = $wpdb->prefix . "map_playlists";

    if(isset($options) && $options['displayAllPlaylistsInPage']){//get all playlists
        $playlists_to_display = $wpdb->get_results("SELECT id FROM {$playlist_table}", ARRAY_A);
    }else{
        $playlists_to_display = array();

        foreach($pids as $pid){//get selected playlists
            $playlists_to_display[] = array("id" => $pid);
        }  
    }

    $encryptMediaPaths = $options['encryptMediaPaths'];

    $markup = '<div class="hap-playlist-list'.$instance_id.'" style="display:none;">'.PHP_EOL;

	foreach($playlists_to_display as $playlist) {

        $playlist_id = $playlist['id'];

        //global playlist options
        $result = $wpdb->get_row($wpdb->prepare("SELECT title, options FROM {$playlist_table} WHERE id = %d", $playlist_id), ARRAY_A);

        $default_playlist_options = hap_playlist_options();

        if(isset($result['options'])){
            $po = unserialize($result['options']);
            $playlist_options = $po + $default_playlist_options;
        }else{
            $playlist_options = $default_playlist_options;
        }

        //taxonomy
        $category = isset($atts['category']) ? $atts['category'] : NULL;
        $tag = isset($atts['tag']) ? $atts['tag'] : NULL;

        $match = 'any';
        if(isset($atts['match']))$match = $atts['match'];
        $allowed = array("any", "all");
        if(!in_array($match, $allowed))$match = 'any';//escape

        //add more
        $addMoreOnTotalScroll = $playlist_options['addMoreOnTotalScroll'];
        $limit = $playlist_options['addMoreOnTotalScrollLimit'];
        $sortOrder = 'order_id';
        $sortDirection = 'ASC';

        if(isset($options["addMore"]))$addMoreOnTotalScroll = true;
        if(isset($options["addMoreLimit"]))$limit = $options["addMoreLimit"];

        //pagination (only with grid)
        $usePagination = NULL;
        if(hap_strpos($options['preset'], 'grid')){
            if(isset($options["usePagination"]) && $options["usePagination"]){
                $usePagination = $options["usePagination"];
                if($options["paginationPerPage"])$limit = $options["paginationPerPage"];
            }
        }

        $markup .= '<div class="hap-playlist-'.$playlist_id.'" data-playlist-id="'.$playlist_id.'">'.PHP_EOL;


        if($medias){
            //from stat

            $track = '<div class="hap-playlist-options"';

        }else{

            if($addMoreOnTotalScroll){//scroll end

                if(isset($atts['taxonomy'])){

                    $num_results = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM {$media_table} WHERE playlist_id = %d", $playlist_id));

                    $medias = hap_getMediaWithTaxonomy($atts['taxonomy'], $sortOrder, $sortDirection, $playlist_id, null, $limit);
                }
                else if($category || $tag){

                    $num_results = hap_filterMediaWithTaxonomy_numResults($category, $tag, $match, $playlist_id);

                    $medias = hap_filterMediaWithTaxonomy($category, $tag, $match, $sortOrder, $sortDirection, $playlist_id, null, $limit);
                }
                else{

                    $num_results = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM {$media_table} WHERE playlist_id = %d", $playlist_id));

                    $stmt = $wpdb->prepare("SELECT id, options FROM {$media_table} WHERE playlist_id = %d ORDER BY order_id $sortDirection LIMIT $limit", $playlist_id);
                    $medias = $wpdb->get_results($stmt, ARRAY_A);

                }

                if($num_results <= $limit)$addMoreOnTotalScroll = false;

                //global playlist options

                $track = '<div class="hap-playlist-options" data-add-more-on-total-scroll="'.$addMoreOnTotalScroll.'" data-add-more-num-results="'.$num_results.'" data-add-more-offset="'.$limit.'" data-add-more-limit="'.$limit.'" data-add-more-sort-order="'.$sortOrder.'" data-add-more-sort-direction="'.$sortDirection.'"';

            }else if($usePagination){//pagination

                if(isset($atts['taxonomy'])){

                    $num_results = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM {$media_table} WHERE playlist_id = %d", $playlist_id));

                    $medias = hap_getMediaWithTaxonomy($atts['taxonomy'], $sortOrder, $sortDirection, $playlist_id, null, $limit);
                }
                else if($category || $tag){
                    
                    $num_results = hap_filterMediaWithTaxonomy_numResults($category, $tag, $match, $playlist_id);

                    $medias = hap_filterMediaWithTaxonomy($category, $tag, $match, $sortOrder, $sortDirection, $playlist_id, null, $limit);

                }
                else{

                    $num_results = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM {$media_table} WHERE playlist_id = %d", $playlist_id));

                    $stmt = $wpdb->prepare("SELECT id, options FROM {$media_table} WHERE playlist_id = %d ORDER BY $sortOrder $sortDirection LIMIT $limit", $playlist_id);
                    $medias = $wpdb->get_results($stmt, ARRAY_A);

                }

                //global playlist options

                $track = '<div class="hap-playlist-options" data-use-pagination="1" data-pagination-current-page="0" data-add-more-num-results="'.$num_results.'" data-add-more-offset="'.$limit.'" data-add-more-limit="'.$limit.'" data-add-more-sort-order="'.$sortOrder.'" data-add-more-sort-direction="'.$sortDirection.'"';    

            }else{

                if(isset($atts['taxonomy'])){
                    $medias = hap_getMediaWithTaxonomy($atts['taxonomy'], $sortOrder, $sortDirection, $playlist_id);
                }
                else if($category || $tag){
                    $medias = hap_filterMediaWithTaxonomy($category, $tag, $match, $sortOrder, $sortDirection, $playlist_id);
                }
                else{
                    $stmt = $wpdb->prepare("SELECT id, options FROM {$media_table} WHERE playlist_id = %d ORDER BY $sortOrder $sortDirection", $playlist_id);
                    $medias = $wpdb->get_results($stmt, ARRAY_A);
                }

                $track = '<div class="hap-playlist-options"';
            }

        }

        if(isset($atts['taxonomy']))$track .= ' data-taxonomy="'.$atts['taxonomy'].'"';
        if($category)$track .= ' data-category="'.$category.'"';
        if($tag)$track .= ' data-tag="'.$tag.'"';
        if($match)$track .= ' data-match="'.$match.'"';

        if(!empty($result['title'])){
            $track .= ' data-playlist-title="'.$result['title'].'"';
        }
        if(!empty($playlist_options['thumbGlobal'])){
            $track .= ' data-thumb-global="'.$playlist_options['thumbGlobal'].'"';
        }
        if(!empty($playlist_options["start"])){
            $track .= ' data-start="'.$playlist_options["start"].'"';
        }
        else if(isset($atts["start"])){
            $track .= ' data-start="'.$atts["start"].'"';
            if(isset($atts["start_time_media_id"]))$track .= ' data-start-media-id="'.$atts["start_time_media_id"].'"';
        }
        if(!empty($playlist_options["end"])){
            $track .= ' data-end="'.$playlist_options["end"].'"';
        }
        else if(isset($atts["end"])){
            $track .= ' data-end="'.$atts["end"].'"';
        }
        if(!empty($playlist_options["mediaPrefixUrl"])){
            $track .= ' data-media-prefix-url="'.$playlist_options["mediaPrefixUrl"].'"';
        }
        if(!empty($atts['active_media_id'])){
            $track .= ' data-active-media-id="'.$atts['active_media_id'].'"';
        }


        //ads
        if(isset($ad_options)){

            if(isset($ad_options["ad_pre"])){
                $adPre = implode(",", $ad_options["ad_pre"]);
                if(!empty($adPre))$track .= ' data-ad-pre="'.$adPre.'"';
            }
            if(isset($ad_options["ad_mid"])){
                $adMid = implode(",", $ad_options["ad_mid"]);
                if(!empty($adMid)){
                    $track .= ' data-ad-mid="'.$adMid.'"';
                    if(!empty($ad_options["ad_mid_interval"]))$track .= ' data-ad-mid-interval="'.$ad_options["ad_mid_interval"].'"';
                }
            }
            if(isset($ad_options["ad_end"])){
                $adEnd = implode(",", $ad_options["ad_end"]);
                if(!empty($adEnd))$track .= ' data-ad-end="'.$adEnd.'"';
            }
            if(!empty($ad_options["shuffle_ads"])){
                $track .= ' data-shuffle-ads="1"';
            }

        }

        $track .= '>';

        if(!empty($playlist_options['description'])){//might contain html
            $track .= '<div class="hap-global-playlist-description">'.$playlist_options['description'].'</div>';
        }

        $track .= '</div>';//end hap-playlist-options

        $markup .= $track.PHP_EOL;

    	//tracks
        foreach($medias as $m) {
            $media = unserialize($m['options']);
            $media['id'] = $m['id'];
            $markup .= hap_get_media_fields($media, $encryptMediaPaths);
        }

        $markup .= PHP_EOL;
                
        $markup .= '</div>'.PHP_EOL;//end hap-playlist 
                
    }

	$markup .= '</div>';//end playlist list
	
	return $markup;

}

?>