<?php

    function hap_skin_css($preset){

        $plugins_url = plugins_url('/apmap');

        switch ($preset) {

            case 'brona':

            return "@font-face {
              font-family: 'Material Icons';
              font-style: normal;
              font-weight: 400;
              src: local('Material Icons'),
                   local('MaterialIcons-Regular'),
                   url(2fcrYFNaTjcS6g4U3t-Y5ZjZjT5FdEJ140U2DJYC3mY.woff2) format('woff2'),
                   url(".$plugins_url."/source/css/iconfont/MaterialIcons-Regular.ttf) format('truetype');
            }

            .hap-music-player .material-icons {
              font-family: 'Material Icons';
              font-weight: normal;
              font-style: normal;
              font-size: 24px;
              line-height: 1;
              letter-spacing: normal;
              text-transform: none;
              display: inline-block;
              white-space: nowrap;
              word-wrap: normal;
              direction: ltr;
              -webkit-font-feature-settings: 'liga';
              -webkit-font-smoothing: antialiased;
            }";

        }

    }

    function hap_playlist_options(){

        return array(

            "thumbGlobal" => "",
            "description" => "",
            "start" => "",
            "end" => "",
            "playbackRate" => "",
            "mediaPrefixUrl" => "",

            //add more
            "addMoreOnTotalScroll" => false,
            "addMoreOnTotalScrollLimit" => 15,
            "sortOrder" => 'order_id',
            "sortDirection" => 'ASC',

            //pagination
            "usePagination" => false,
            "paginationPerPage" => 12,

            //ads
            "ad_pre" => "",
            "ad_mid" => "",
            "ad_mid_interval" => "",
            "ad_end" => "",

        );

    }

    function hap_player_global_settings(){

        return array(

            "youtube_id" => "",
            "facebook_id" => "",
            "soundcloud_app_id" => "",
            "gdrive_app_id" => "",

            "loadGoogleFontsLocally" => "0",
            "encryptMediaPaths" => "0",
            "js_to_footer" => "0",
            "no_conflict" => "0",
            "overide_wp_audio" => "0",
            "overide_wp_audio_skin" => "",
            "overide_wp_audio_playlist" => "0",
            "overide_wp_audio_playlist_skin" => "",

            "delete_plugin_data_on_uninstall" => false,
            "add_font_awesome_css" => true,   

            //fixed
            "useFixedPlayer" => false,
            "fixedPlayerOpened" => true,   
            "fixedPlayerTheme" => "light",

            //wave
            "useWaveSeekbarInFixed" => true,
            "waveBgColor" => "#9e9e9e",
            "waveProgressColor" => "#e4c000",
            "waveBarWidth" => 1,
            "waveBarRadius" => 0,
            "waveBarGap" => 5,
            "createAudioWaveformOnUpload" => true,

        );

    }

    function hap_player_options(){

        return array(

             //common

            "customClass" => "",
            "selectorInit" => "",
            "connectedPlayerAction" => "add",
            "useMasonry" => false,
            "placeHolderThumb" => "",
            "sortableTracks" => false,
            "encryptMediaPaths" => false,
            "addPlaylistEvents" => true,
            "addResizeEvent" => true,
            "usePlaylistScroll" => false,
            "playlistScrollType" => "mcustomscrollbar",
            "playlistScrollTheme" => "",
            "useNumbersInPlaylist" =>  false,

            "togglePlaybackOnPlaylistItem" => true,
            "gridPauseIcon" => "",
            "gridPlayIcon" => "",

            "useInlineSeekbar" =>  false,
            "numberTitleSeparator" =>  "",
            "artistTitleSeparator" =>  "",
            "playlistItemContent" => array(),
            "playlistClickElement" => '.hap-playlist-item-content',
            "playlistTitleOrder" => array("title","artist"),
            "playlistOpened" => false,
            "playerOpened" => true,//fixed
            "useTitleScroll" => false,
            "titleScrollSpeed" => 1,
            "titleScrollSeparator" => "",
            "popupWidth" => "",
            "popupHeight" => "",
            "copyCurrentPlaylistToPopup" => true,
            "hidePlayerUntilMusicStart" => false,
            "playbackRateMin" => 0.5, 
            "playbackRateMax" => 2,
            "getId3Image" => true,
            "useAudioPreview" => false,
            "togglePlaybackOnMultipleInstances" => true,
            "clearDialogCacheOnStart" => true,

            "lyricsAutoOpen" => false,
            "lyricsAutoScroll" => true,
  
            "videoAutoOpen" => false,
            "useVideoControls" => false,
            "useVideoFullscreen" => true,
            "useVideoPictureInPicture" => false,
            "useVideoDownload" => false,

            //restrict ads
            "viewSongWithoutAdsForLoggedInUser" => false,
            "viewSongWithoutAdsUserRoles" => array(),

            "popupWindowTitle" => "HTML5 Audio Player with Playlist",
            "displayAllPlaylistsInPage" => false,
            "activeItem" => 0,
            "volume" => 0.5,
            "autoPlay" => true,
            "autoPlayAfterFirst" => false,
            "preload" => "auto",
            "randomPlay" => false,
            "seekTime" => 10,
            "playbackRate" => 1,
            "loopState" => "playlist",
            "stopOnSongEnd" => false,
            "playlistScrollOrientation" => "vertical",

            "useKeyboardNavigationForPlayback" => false,
            "useGlobalKeyboardControls" => false,
            "modifierKey" => "",

            "keyboardControlsArr" => array(   
                array('keycode' => 37, 'key' => 'left arrow', 'action' => 'seekBackward', 'action_display' => __('Seek backward', HAP_TEXTDOMAIN)),
                array('keycode' => 39, 'key' => 'right arrow', 'action' => 'seekForward', 'action_display' => __('Seek forward', HAP_TEXTDOMAIN)),
                array('keycode' => 32, 'key' => 'spacebar', 'action' => 'togglePlayback', 'action_display' => __('Toggle playback', HAP_TEXTDOMAIN)),
                array('keycode' => 187, 'key' => 'equal sign', 'action' => 'volumeUp', 'action_display' => __('Volume up', HAP_TEXTDOMAIN)),
                array('keycode' => 189, 'key' => 'dash', 'action' => 'volumeDown', 'action_display' => __('Volume down', HAP_TEXTDOMAIN)),
                array('keycode' => 77, 'key' => 'm', 'action' => 'toggleMute', 'action_display' => __('Toggle mute', HAP_TEXTDOMAIN)),
                array('keycode' => 40, 'key' => 'down arrow', 'action' => 'nextMedia', 'action_display' => __('Next media', HAP_TEXTDOMAIN)),
                array('keycode' => 38, 'key' => 'up arrow', 'action' => 'previousMedia', 'action_display' => __('Previous media', HAP_TEXTDOMAIN)),
                array('keycode' => 82, 'key' => 'r', 'action' => 'rewind', 'action_display' => __('Rewind', HAP_TEXTDOMAIN)),
            ),

            "keyboardControls" => array(
                array("keycode" => 37, "action" => "seekBackward", "disabled" => "0"),
                array("keycode" => 39, "action" => "seekForward", "disabled" => "0"),
                array("keycode" => 32, "action" => "togglePlayback", "disabled" => "0"),
                array("keycode" => 187, "action" => "volumeUp", "disabled" => "0"),
                array("keycode" => 189, "action" => "volumeDown", "disabled" => "0"),
                array("keycode" => 77, "action" => "toggleMute", "disabled" => "0"),
                array("keycode" => 40, "action" => "nextMedia", "disabled" => "0"),
                array("keycode" => 38, "action" => "previousMedia", "disabled" => "0"),
                array("keycode" => 82, "action" => "rewind", "disabled" => "0")
            ),

            "useContinousPlayback" => false,
            "continousKey" => "hap-continous-playback-key-",
            "continousPlaybackTrackAllSongs" => false,
            "useStatistics" => false,
            "percentToCountAsPlay" => "25",
            "disableSongSkip" => false,
            "disableSeekbar" => false,
            "useGa" => false,
            "gaTrackingId" => "",
            "limitDescriptionText" => 300,
            "sortOrder" => "",
            "searchDescriptionInPlaylist" => true,
            "searchSelector" => "",
            "hideYoutubeAfterStart" => false,
            "forceYoutubeChromeless" => false,
            "createDownloadIconsInPlaylist" => true,
            "createLinkIconsInPlaylist" => true,
            "pauseAudioDuringAds" => false,
            "playlistItemMultilineWidth" => 600,
            "fetchPlayerArtwork" => false,
            "soundCloudThumbQuality" => "large.jpg",
            "soundCloudThumbQualityInPlaylist" => "large.jpg",
            "statisticsContent" => array("plays","likes","downloads"),
            "allowOnlyOneOpenedAccordion" => true,
            "autoOpenPopupWindow" => false,

            "infoSkin" => "info-dbt",
            "infoSkinArr" => array(    
                'info-dot' => "Description over thumbnail", 
                'info-dbt' => "Description below thumbnail",
                'info-drot' => "Description right of thumbnail", 
            ),


            //radio
            "getRadioArtwork" => true,
            "lastPlayedInterval" => 10000,
            "enableCors" => true,
            "cors" => "https://kastproxy-us.herokuapp.com/,https://kastproxy-eu.herokuapp.com/,https://cors-anywhere.herokuapp.com/,https://cors.io/?",
            "useCorsForAudio" => false,
            "defaultSongArtist" => "DATA NOT AVAILABLE",
            "defaultSongTitle" => "DATA NOT AVAILABLE",

            //translation

            "playerLanguage" => "en",

            "createReadMoreInDescription" => false,
            "limitDescriptionReadMoreText" => "Read more",
            "limitDescriptionReadLessText" => "Read less",
            "filterText" => "Search..",
            "filterNothingFoundMsg" => "NOTHING FOUND!",
            "tooltipClose" => "Close",
            "tooltipNext" => "Next",
            "tooltipPlay" => "Play",
            "tooltipPause" => "Pause",
            "tooltipPrevious" => "Previous",
            "tooltipSkipBackward" => "Skip backward",
            "tooltipSkipForward" => "Skip forward",
            "tooltipShare" => "Share",
            "tooltipTumblr" => "Share on Tumblr",
            "tooltipTwitter" => "Share on Twitter",
            "tooltipFacebook" => "Share on Facebook",
            "tooltipWhatsApp" => "Share on Whatsapp",
            "tooltipReddit" => "Share on Reddit",
            "tooltipDigg" => "Share on Digg",
            "tooltipLinkedIn" => "Share on LinkedIn",
            "tooltipPinterest" => "Share On Pinterest",
            "tooltipVolume" => "Volume",
            "tooltipShuffleOff" => "Shuffle off",
            "tooltipShuffleOn" => "Shuffle on",
            "tooltipLoopStatePlaylist" => "Loop playlist",
            "tooltipLoopStateSingle" => "Loop single",
            "tooltipLoopStateOff" => "Loop off",
            "tooltipPlaybackRate" => "Speed",
            "tooltipRange" => "AB loop",
            "tooltipPopup" => "Expand",
            "tooltipVideo" => "Video",
            "tooltipLyrics" => "Lyrics",

            "dialogResizeTitle" => "Resize",
            "lyricsAutoScrollText" => "Auto scroll",

            "tooltipSortAlphaDown" => "Title sort ascending",
            "tooltipSortAlphaUp" => "Title sort descending",
            "tooltipPlaylistOpen" => "Playlist",
            "tooltipPlaylistClose" => "Close",
            "tooltipStatPlays" => "Plays",
            "tooltipStatLikes" => "Likes",
            "tooltipStatDownloads" => "Downloads",
            "downloadIconTitle" => "Download",
            "linkIconTitle" => "Purchase",
            "whatsAppWarning" => "Please share this content on mobile device!",
            "loadMoreBtnText" => "LOAD MORE",
            "adMessage" => "Advertising will end in",

            //pagination
            "paginationPreviousBtnTitle" => "Previous",
            "paginationPreviousBtnText" => "Prev",
            "paginationNextBtnTitle" => "Next",
            "paginationNextBtnText" => "Next",


            //elements
            "usePlaylist" => true,
            "useNext" => true,
            "usePrevious" => true,
            "useSkipBackward" => false,
            "useSkipForward" => false,
            "useShuffle" => true,
            "useLoop" => true,
            "useShare" => true,
            "useShareFacebook" => true,
            "useShareTwitter" => true,
            "useShareTumblr" => true,
            "useShareWhatsApp" => true,
            "useShareReddit" => true,
            "useShareDigg" => true,
            "useShareLinkedIn" => true,
            "useSharePinterest" => true,
            "usePopup" => false,
            "usePlaybackRate" => true,
            "useSearch" => true,
            "useRange" => false,


            //some icons
            "downloadIcon" => "<svg viewBox='0 0 512 512'><path d='M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z'></path></svg>",

            "linkIcon" => "<svg viewBox='0 0 576 512'><path d='M504.717 320H211.572l6.545 32h268.418c15.401 0 26.816 14.301 23.403 29.319l-5.517 24.276C523.112 414.668 536 433.828 536 456c0 31.202-25.519 56.444-56.824 55.994-29.823-.429-54.35-24.631-55.155-54.447-.44-16.287 6.085-31.049 16.803-41.548H231.176C241.553 426.165 248 440.326 248 456c0 31.813-26.528 57.431-58.67 55.938-28.54-1.325-51.751-24.385-53.251-52.917-1.158-22.034 10.436-41.455 28.051-51.586L93.883 64H24C10.745 64 0 53.255 0 40V24C0 10.745 10.745 0 24 0h102.529c11.401 0 21.228 8.021 23.513 19.19L159.208 64H551.99c15.401 0 26.816 14.301 23.403 29.319l-47.273 208C525.637 312.246 515.923 320 504.717 320zM408 168h-48v-40c0-8.837-7.163-16-16-16h-16c-8.837 0-16 7.163-16 16v40h-48c-8.837 0-16 7.163-16 16v16c0 8.837 7.163 16 16 16h48v40c0 8.837 7.163 16 16 16h16c8.837 0 16-7.163 16-16v-40h48c8.837 0 16-7.163 16-16v-16c0-8.837-7.163-16-16-16z'></path></svg>",
            

        );

    }

    function hap_player_options_preset($preset){

        switch ($preset) {

        case 'epic':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollType" => "perfect-scrollbar",
                "useNumbersInPlaylist" =>  false,
                "artistTitleSeparator" =>  "&nbsp;-&nbsp;",
                "playlistItemContent" => array("title"),
                "popupWidth" => "900",
                "popupHeight" => "500",
                "breakPointArr" => "800,600,400",

                "playlistMainTitleTextColor" => "rgb(17,17,17)",
                "playerMainDescriptionTextColor" => "rgb(201,0,50)",

                "playerBgColor" => "rgb(255,255,255)",
                "iconColor" => "rgb(119,119,119)",
                "iconHoverColor" => "rgb(201,0,50)",
                "volumeBgColor" => "rgb(221,221,221)",
                "volumeLevelColor" => "rgb(201,0,50)",
                "seekbarBgColor" => "rgb(158,158,158)",
                "seekbarProgressColor" => "rgb(201,0,50)",
                "adSeekbarProgressColor" => "rgb(255,235,59)",
                "timeTextColor" => "rgb(51,51,51)",
                "rangeHandleColor" => "rgb(102,102,102)",
                "rangeHandleHoverColor" => "rgb(201,0,50)",

                "playlistItemTextColor" => "rgb(34,34,34)",
                "playlistItemSelectedTextColor" => "rgb(201,0,50)",
                "playlistDescriptionTextColor" => "rgb(34,34,34)",
                "playlistDurationTextColor" => "rgb(34,34,34)",
                "playlistDateTextColor" => "rgb(102,102,102)",
                "playlistIconColor" => "rgb(102,102,102)",
                "playlistIconHoverColor" => "rgb(201,0,50)",

                "filterBgColor" => "rgb(221,221,221)",
                "filterTextColor" => "rgb(0,0,0)",
                "nothingFoundTextColor" => "rgb(201,0,50)",
                "tooltipBgColor" => "rgb(201,0,50)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "tooltipBorderColor" => "rgb(204,204,204)",
                "preloaderColor" => "rgb(201,0,50)",

                "statsIconColor" => "rgb(102,102,102)",
                "statsIconHoverColor" => "rgb(201,0,50)",

                "loadMoreBtnTextColor" => "rgb(51,51,51)",
                "loadMoreBtnBgColor" => "rgb(221,221,221)",
                "loadMoreBtnTextHoverColor" => "rgb(255,255,255)",
                "loadMoreBtnBgHoverColor" => "rgb(119,119,119)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

            );

            break;

        case 'epic_mini':

            return array(
            
                "usePlaylistScroll" => false,

                "playerBgColor" => "rgb(255,255,255)",
                "iconColor" => "rgb(119,119,119)",
                "iconHoverColor" => "rgb(201,0,50)",
                "seekbarBgColor" => "rgb(158,158,158)",
                "seekbarProgressColor" => "rgb(201,0,50)",

                "tooltipBgColor" => "rgb(201,0,50)",
                "tooltipTextColor" => "rgb(255,255,255)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

            );

            break;     

        case 'art_wide_light':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "dark-2",
                "useNumbersInPlaylist" =>  true,
                "numberTitleSeparator" =>  ".&nbsp;",
                "artistTitleSeparator" =>  "&nbsp;-&nbsp;",
                "playlistItemContent" => array("title"),
                "playlistOpened" => true,
                "popupWidth" => "800",
                "popupHeight" => "560",
                "breakPointArr" => "650,500",

                "playerBgColor" => "rgb(255,255,255)",
                "iconColor" => "rgb(102,102,102)",
                "iconHoverColor" => "rgb(33,150,243)",
                "playerTitleTextColor" => "rgb(34,34,34)",
                "playerArtistTextColor" => "rgb(34,34,34)",
                "volumeBgColor" => "rgb(221,221,221)",
                "volumeLevelColor" => "rgb(33,150,243)",
                "seekbarBgColor" => "rgb(204,204,204)",
                "seekbarLoadColor" => "rgb(221,221,221)",
                "seekbarProgressColor" => "rgb(33,150,243)",
                "adSeekbarProgressColor" => "rgb(255,235,59)",
                "timeTextColor" => "rgb(51,51,51)",
                "rangeHandleColor" => "rgb(102,102,102)",
                "rangeHandleHoverColor" => "rgb(33,150,243)",
                
                "playlistItemTextColor" => "rgb(34,34,34)",
                "playlistItemSelectedTextColor" => "rgb(33,150,243)",
                "playlistDescriptionTextColor" => "rgb(34,34,34)",
                "playlistDurationTextColor" => "rgb(34,34,34)",
                "playlistDateTextColor" => "rgb(102,102,102)",
                "playlistIconColor" => "rgb(102,102,102)",
                "playlistIconHoverColor" => "rgb(33,150,243)",

                "filterBgColor" => "rgb(221,221,221)",
                "filterTextColor" => "rgb(0,0,0)",
                "nothingFoundTextColor" => "rgb(33,150,243)",
                "tooltipBgColor" => "rgb(33,150,243)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "tooltipBorderColor" => "rgb(204,204,204)",
                "preloaderColor" => "rgb(33,150,243)",

                "statsIconColor" => "rgb(102,102,102)",
                "statsIconHoverColor" => "rgb(33,150,243)",

                "loadMoreBtnTextColor" => "rgb(51,51,51)",
                "loadMoreBtnBgColor" => "rgb(221,221,221)",
                "loadMoreBtnTextHoverColor" => "rgb(255,255,255)",
                "loadMoreBtnBgHoverColor" => "rgb(119,119,119)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

            );

            break;

        case 'art_wide_dark':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "light-2",
                "useNumbersInPlaylist" =>  true,
                "numberTitleSeparator" =>  ".&nbsp;",
                "artistTitleSeparator" =>  "&nbsp;-&nbsp;",
                "playlistItemContent" => array("title"),
                "playlistOpened" => true,
                "popupWidth" => "800",
                "popupHeight" => "560",
                "breakPointArr" => "650,500",

                "playerBgColor" => "rgb(27,27,27)",
                "iconColor" => "rgb(102,102,102)",
                "iconHoverColor" => "rgb(33,150,243)",
                "playerTitleTextColor" => "rgb(213,213,213)",
                "playerArtistTextColor" => "rgb(187,187,187)",
                "volumeBgColor" => "rgb(221,221,221)",
                "volumeLevelColor" => "rgb(33,150,243)",
                "seekbarBgColor" => "rgb(204,204,204)",
                "seekbarLoadColor" => "rgb(221,221,221)",
                "seekbarProgressColor" => "rgb(33,150,243)",
                "adSeekbarProgressColor" => "rgb(255,235,59)",
                "timeTextColor" => "rgb(102,102,102)",
                "rangeHandleColor" => "rgb(102,102,102)",
                "rangeHandleHoverColor" => "rgb(33,150,243)",
                
                "playlistItemTextColor" => "rgb(204,204,204)",
                "playlistItemSelectedTextColor" => "rgb(33,150,243)",
                "playlistDescriptionTextColor" => "rgb(85,85,85)",
                "playlistDurationTextColor" => "rgb(204,204,204)",
                "playlistDateTextColor" => "rgb(120,120,120)",
                "playlistIconColor" => "rgb(102,102,102)",
                "playlistIconHoverColor" => "rgb(33,150,243)",

                "filterBgColor" => "rgb(180,180,180)",
                "filterTextColor" => "rgb(0,0,0)",
                "nothingFoundTextColor" => "rgb(33,150,243)",
                "tooltipBgColor" => "rgb(33,150,243)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "tooltipBorderColor" => "rgba(0,0,0,0)",
                "preloaderColor" => "rgb(33,150,243)",

                "statsIconColor" => "rgb(102,102,102)",
                "statsIconHoverColor" => "rgb(33,150,243)",

                "loadMoreBtnTextColor" => "rgb(204,204,204)",
                "loadMoreBtnBgColor" => "rgb(85,85,85)",
                "loadMoreBtnTextHoverColor" => "rgb(255,255,255)",
                "loadMoreBtnBgHoverColor" => "rgb(184,184,184)",

                "dialogHeaderBgColor" => "rgb(51,51,51)",
                "dialogContentBgColor" => "rgb(34,34,34)",

                "lyricsTextColor" => "rgb(153,153,153)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

            );

            break;  

        case 'art_narrow_light':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "dark-2",
                "playlistItemContent" => array("title","thumb"),
                "popupWidth" => "400",
                "popupHeight" => "640",

                "playerBgColor" => "rgb(255,255,255)",
                "iconColor" => "rgb(102,102,102)",
                "iconHoverColor" => "rgb(63,186,243)",
                "playerTitleTextColor" => "rgb(34,34,34)",
                "playerArtistTextColor" => "rgb(34,34,34)",
                "volumeBgColor" => "rgb(221,221,221)",
                "volumeLevelColor" => "rgb(63,186,243)",
                "volumeSeekbarBgColor" => "rgb(255,255,255)",
                "volumeIconColor" => "rgb(255,255,255)",
                "seekbarBgColor" => "rgb(204,204,204)",
                "seekbarLoadColor" => "rgb(221,221,221)",
                "seekbarProgressColor" => "rgb(63,186,243)",
                "adSeekbarProgressColor" => "rgb(255,235,59)",
                "timeTextColor" => "rgb(51,51,51)",
                "rangeHandleColor" => "rgb(102,102,102)",
                "rangeHandleHoverColor" => "rgb(63,186,243)",
                
                "playlistItemTextColor" => "rgb(123,118,118)",
                "playlistItemSelectedTextColor" => "rgb(255,255,255)",
                "playlistItemSelectedBgColor" => "rgb(63,186,243)",
                "playlistDescriptionTextColor" => "rgb(34,34,34)",
                "playlistDurationTextColor" => "rgb(34,34,34)",
                "playlistDateTextColor" => "rgb(102,102,102)",
                "playlistIconColor" => "rgb(123,118,118)",
                "playlistIconHoverColor" => "rgb(221,221,221)",

                "filterBgColor" => "rgb(221,221,221)",
                "filterTextColor" => "rgb(0,0,0)",
                "nothingFoundTextColor" => "rgb(63,186,243)",
                "tooltipBgColor" => "rgb(63,186,243)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(63,186,243)",

                "statsIconColor" => "rgb(102,102,102)",
                "statsIconHoverColor" => "rgb(221,221,221)",

                "loadMoreBtnTextColor" => "rgb(51,51,51)",
                "loadMoreBtnBgColor" => "rgb(221,221,221)",
                "loadMoreBtnTextHoverColor" => "rgb(119,119,119)",
                "loadMoreBtnBgHoverColor" => "rgb(255,255,255)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

            );

            break;  

        case 'art_narrow_dark':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "light-2",
                "playlistItemContent" => array("title","thumb"),
                "popupWidth" => "400",
                "popupHeight" => "640",

                "playerBgColor" => "rgb(27,27,27)",
                "iconColor" => "rgb(119,119,119)",
                "iconHoverColor" => "rgb(219,50,107)",
                "playerTitleTextColor" => "rgb(213,213,213)",
                "playerArtistTextColor" => "rgb(119,119,119)",
                "volumeBgColor" => "rgb(221,221,221)",
                "volumeLevelColor" => "rgb(219,50,107)",
                "volumeSeekbarBgColor" => "rgb(27,27,27)",
                "volumeIconColor" => "rgb(221,221,221)",
                "seekbarBgColor" => "rgb(204,204,204)",
                "seekbarLoadColor" => "rgb(221,221,221)",
                "seekbarProgressColor" => "rgb(219,50,107)",
                "adSeekbarProgressColor" => "rgb(255,235,59)",
                "timeTextColor" => "rgb(102,102,102)",
                "rangeHandleColor" => "rgb(102,102,102)",
                "rangeHandleHoverColor" => "rgb(219,50,107)",
                
                "playlistItemTextColor" => "rgb(153,153,153)",
                "playlistItemSelectedTextColor" => "rgb(255,255,255)",
                "playlistItemSelectedBgColor" => "rgb(63,186,243)",
                "playlistDescriptionTextColor" => "rgb(85,85,85)",
                "playlistDurationTextColor" => "rgb(204,204,204)",
                "playlistDateTextColor" => "rgb(102,102,102)",
                "playlistIconColor" => "rgb(153,153,153)",
                "playlistIconHoverColor" => "rgb(221,221,221)",

                "filterBgColor" => "rgb(221,221,221)",
                "filterTextColor" => "rgb(0,0,0)",
                "nothingFoundTextColor" => "rgb(219,50,107)",
                "tooltipBgColor" => "rgb(219,50,107)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(219,50,107)",

                "statsIconColor" => "rgb(102,102,102)",
                "statsIconHoverColor" => "rgb(63,186,243)",

                "loadMoreBtnTextColor" => "rgb(204,204,204)",
                "loadMoreBtnBgColor" => "rgb(85,85,85)",
                "loadMoreBtnTextHoverColor" => "rgb(184,184,184)",
                "loadMoreBtnBgHoverColor" => "rgb(255,255,255)",

                "dialogHeaderBgColor" => "rgb(51,51,51)",
                "dialogContentBgColor" => "rgb(34,34,34)",

                "lyricsTextColor" => "rgb(153,153,153)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

            );

            break;  

        case 'brona_light':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "dark-thin",
                "useNumbersInPlaylist" =>  false,
                "numberTitleSeparator" =>  ".&nbsp;",
                "artistTitleSeparator" =>  "&nbsp;-&nbsp;",
                "playlistItemContent" => array("title","thumb"),
                "playlistOpened" => true,
                "popupWidth" => "900",
                "popupHeight" => "650",
                "breakPointArr" => "650,550",

                "downloadIcon" => "<i class='material-icons'>save_alt</i>",
                "linkIcon" => "<i class='material-icons'>link</i>",
                "statDownloadIcon" => "<i class='material-icons'>save_alt</i>",
                "statLikeIcon" => "<i class='material-icons'>favorite_border</i>",
                "statPlayIcon" => "<i class='material-icons'>play_circle_outline</i>",

                "playerBgColor" => "rgb(255,255,255)",
                "iconColor" => "rgb(102,102,102)",
                "iconHoverColor" => "rgb(210,77,233)",
                "playerTitleTextColor" => "rgb(34,34,34)",
                "playerArtistTextColor" => "rgb(34,34,34)",
                "volumeBgColor" => "rgb(221,221,221)",
                "volumeLevelColor" => "rgb(210,77,233)",
                "seekbarBgColor" => "rgb(204,204,204)",
                "seekbarLoadColor" => "rgb(221,221,221)",
                "seekbarProgressColor" => "rgb(210,77,233)",
                "adSeekbarProgressColor" => "rgb(255,235,59)",
                "timeTextColor" => "rgb(51,51,51)",
                "rangeHandleColor" => "rgb(102,102,102)",
                "rangeHandleHoverColor" => "rgb(210,77,233)",
                
                "playlistItemTextColor" => "rgb(34,34,34)",
                "playlistItemSelectedTextColor" => "rgb(210,77,233)",
                "playlistDescriptionTextColor" => "rgb(34,34,34)",
                "playlistDurationTextColor" => "rgb(34,34,34)",
                "playlistDateTextColor" => "rgb(102,102,102)",
                "playlistIconColor" => "rgb(102,102,102)",
                "playlistIconHoverColor" => "rgb(210,77,233)",

                "filterBgColor" => "rgb(255,255,255)",
                "filterTextColor" => "rgb(130,130,130)",
                "nothingFoundTextColor" => "rgb(210,77,233)",
                "tooltipBgColor" => "rgb(210,77,233)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(210,77,233)",

                "statsIconColor" => "rgb(102,102,102)",
                "statsIconHoverColor" => "rgb(210,77,233)",

                "loadMoreBtnTextColor" => "rgb(51,51,51)",
                "loadMoreBtnBgColor" => "rgb(221,221,221)",
                "loadMoreBtnTextHoverColor" => "rgb(255,255,255)",
                "loadMoreBtnBgHoverColor" => "rgb(119,119,119)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

            );

            break;  

        case 'brona_dark':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "light-thin",
                "useNumbersInPlaylist" =>  false,
                "numberTitleSeparator" =>  ".&nbsp;",
                "artistTitleSeparator" =>  "&nbsp;-&nbsp;",
                "playlistItemContent" => array("title","thumb"),
                "playlistOpened" => true,
                "popupWidth" => "800",
                "popupHeight" => "584",
                "breakPointArr" => "650,550",

                "downloadIcon" => "<i class='material-icons'>save_alt</i>",
                "linkIcon" => "<i class='material-icons'>shopping_cart</i>",
                "statDownloadIcon" => "<i class='material-icons'>save_alt</i>",
                "statLikeIcon" => "<i class='material-icons'>favorite_border</i>",
                "statPlayIcon" => "<i class='material-icons'>play_circle_outline</i>",

                "playerBgColor" => "rgb(27,27,27)",
                "iconColor" => "rgb(102,102,102)",
                "iconHoverColor" => "rgb(233,30,99)",
                "playerTitleTextColor" => "rgb(213,213,213)",
                "playerArtistTextColor" => "rgb(187,187,187)",
                "volumeBgColor" => "rgb(221,221,221)",
                "volumeLevelColor" => "rgb(233,30,99)",
                "seekbarBgColor" => "rgb(204,204,204)",
                "seekbarLoadColor" => "rgb(221,221,221)",
                "seekbarProgressColor" => "rgb(233,30,99)",
                "adSeekbarProgressColor" => "rgb(255,235,59)",
                "timeTextColor" => "rgb(102,102,102)",
                "rangeHandleColor" => "rgb(102,102,102)",
                "rangeHandleHoverColor" => "rgb(233,30,99)",
                
                "playlistItemTextColor" => "rgb(204,204,204)",
                "playlistItemSelectedTextColor" => "rgb(233,30,99)",
                "playlistDescriptionTextColor" => "rgb(120,120,120)",
                "playlistDurationTextColor" => "rgb(204,204,204)",
                "playlistDateTextColor" => "rgb(120,120,120)",
                "playlistIconColor" => "rgb(102,102,102)",
                "playlistIconHoverColor" => "rgb(233,30,99)",

                "filterBgColor" => "rgb(42,42,42)",
                "filterTextColor" => "rgb(130,130,130)",
                "nothingFoundTextColor" => "rgb(233,30,99)",
                "tooltipBgColor" => "rgb(233,30,99)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(233,30,99)",

                "statsIconColor" => "rgb(102,102,102)",
                "statsIconHoverColor" => "rgb(233,30,99)",

                "loadMoreBtnTextColor" => "rgb(204,204,204)",
                "loadMoreBtnBgColor" => "rgb(233,30,99)",
                "loadMoreBtnTextHoverColor" => "rgb(255,255,255)",
                "loadMoreBtnBgHoverColor" => "rgb(184,184,184)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(204,204,204)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

            );

            break;      

        case 'metalic':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "light-thin",
                "useNumbersInPlaylist" =>  true,
                "numberTitleSeparator" =>  ".&nbsp;",
                "artistTitleSeparator" =>  "&nbsp;-&nbsp;",
                "playlistItemContent" => array("title"),
                "playlistOpened" => true,
                "popupWidth" => "800",
                "popupHeight" => "350",
                "breakPointArr" => "800",


                "playerBgColor" => "rgba(30,30,30,0.9)",
                "iconColor" => "rgb(255,255,255)",
                "iconHoverColor" => "rgb(63,186,243)",
                "volumeBgColor" => "rgb(221,221,221)",
                "volumeLevelColor" => "rgb(63,186,243)",
                "volumeSeekbarBgColor" => "rgb(27,27,27)",
                "seekbarBgColor" => "rgb(136,136,136)",
                "seekbarLoadColor" => "rgb(136,136,136)",
                "seekbarProgressColor" => "rgb(63,186,243)",
                
                "playlistItemTextColor" => "rgb(153,153,153)",
                "playlistItemSelectedTextColor" => "rgb(255,255,255)",
                "playlistIconColor" => "rgb(153,153,153)",
                "playlistIconHoverColor" => "rgb(63,186,243)",

                "statsIconColor" => "rgb(153,153,153)",
                "statsIconHoverColor" => "rgb(63,186,243)",

                "tooltipBgColor" => "rgb(51,51,51)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(219,50,107)",

                "dialogHeaderBgColor" => "rgb(51,51,51)",
                "dialogContentBgColor" => "rgb(34,34,34)",

                "lyricsTextColor" => "rgb(153,153,153)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",
                
            );

            break;  

        case 'modern':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "dark-2",
                "useNumbersInPlaylist" =>  true,
                "numberTitleSeparator" =>  ".&nbsp;",
                "artistTitleSeparator" =>  "&nbsp;-&nbsp;",
                "playlistItemContent" => array("title"),
                "playlistOpened" => true,
                "popupWidth" => "900",
                "popupHeight" => "300",
                "breakPointArr" => "800,400",


                "playerBgColor" => "rgb(255,255,255)",
                "iconColor" => "rgb(119,119,119)",
                "iconHoverColor" => "rgb(63,186,243)",
                "volumeBgColor" => "rgb(119,119,119)",
                "volumeLevelColor" => "rgb(63,186,243)",

                "seekbarBgColor" => "rgb(153,153,153)",
                "seekbarProgressColor" => "rgb(63,186,243)",
                
                "playlistItemTextColor" => "rgb(34,34,34)",
                "playlistItemSelectedTextColor" => "rgb(255,255,255)",
                "playlistItemSelectedBgColor" => "rgb(63,186,243)",
                "playlistIconColor" => "rgb(119,119,119)",
                "playlistIconHoverColor" => "rgb(202,202,202)",

                "filterBgColor" => "rgb(221,221,221)",
                "filterTextColor" => "rgb(0,0,0)",
                "nothingFoundTextColor" => "rgb(63,186,243)",

                "statsIconColor" => "rgb(119,119,119)",
                "statsIconHoverColor" => "rgb(202,202,202)",

                "tooltipBgColor" => "rgb(63,186,243)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(63,186,243)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",
                
            );
            
            break;  

        case 'artwork':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "3d",
                "useNumbersInPlaylist" =>  true,
                "numberTitleSeparator" =>  ".&nbsp;",
                "artistTitleSeparator" =>  "&nbsp;-&nbsp;",
                "playlistItemContent" => array("title"),
                "playlistOpened" => true,
                "popupWidth" => "800",
                "popupHeight" => "380",
                "breakPointArr" => "800",


                "playerBgColor" => "rgb(51,51,51)",
                "iconColor" => "rgb(255,255,255)",
                "iconHoverColor" => "rgb(255,255,204)",
                "volumeBgColor" => "rgb(51,51,51)",
                "volumeLevelColor" => "rgb(255,255,255)",
                "seekbarBgColor" => "rgb(51,51,51)",
                "seekbarLoadColor" => "rgb(34,34,34)",
                "seekbarProgressColor" => "rgb(255,255,255)",
                
                "playlistItemTextColor" => "rgb(255,255,255)",
                "playlistItemSelectedTextColor" => "rgb(255,255,204)",
                "playlistItemAlternateBgColor" => "rgb(34,34,34)",
                "playlistIconColor" => "rgb(204,204,204)",
                "playlistIconHoverColor" => "rgb(255,255,204)",

                "statsIconColor" => "rgb(204,204,204)",
                "statsIconHoverColor" => "rgb(255,255,204)",

                "tooltipBgColor" => "rgb(102,102,102)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(255,255,204)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",
                
            );

            break;  

        case 'poster':

            return array(
            
                "popupWidth" => "600",
                "popupHeight" => "600",

                "iconColor" => "rgb(221,221,221)",
                "iconHoverColor" => "rgb(255,255,255)",
                "playerTitleTextColor" => "rgb(255,255,255)",
                "playerArtistTextColor" => "rgb(204,204,204)",
                "volumeBgColor" => "rgb(204,204,204)",
                "volumeLevelColor" => "rgb(209,193,250)",
                "seekbarBgColor" => "rgb(204,204,204)",
                "seekbarLoadColor" => "rgb(204,204,204)",
                "seekbarProgressColor" => "rgb(209,193,250)",

                "shareHolderBgColor" => "rgb(51,51,51)",
                
                "tooltipBgColor" => "rgb(209,193,250)",
                "tooltipTextColor" => "rgb(255,255,255)",

                "preloaderColor" => "rgb(255,255,255)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",
                
            );

            break;

        case 'widget':

            return array(
            
                "popupWidth" => "200",
                "popupHeight" => "200",

                "iconColor" => "rgb(255,255,255)",
                "iconHoverColor" => "rgb(207,232,210)",
                "playerTitleTextColor" => "rgb(255,255,255)",
                "playerArtistTextColor" => "rgb(255,255,255)",
                "volumeBgColor" => "rgb(153,153,153)",
                "volumeLevelColor" => "rgb(255,255,255)",
                "seekbarBgColor" => "rgb(153,153,153)",
                "seekbarLoadColor" => "rgb(187,187,187)",
                "seekbarProgressColor" => "rgb(255,255,255)",
                
                "tooltipBgColor" => "rgb(177,194,190)",
                "tooltipTextColor" => "rgb(255,255,255)",

                "preloaderColor" => "rgb(255,255,255)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",
                
            );

            break;    

        case 'fixed':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "light-2",
                "useNumbersInPlaylist" =>  false,
                "numberTitleSeparator" =>  ".&nbsp;",
                "artistTitleSeparator" =>  "&nbsp;-&nbsp;",
                "playlistItemContent" => array("title","thumb"),
                "playlistOpened" => false,
                "popupWidth" => "1100",
                "popupHeight" => "400",
                "breakPointArr" => "650,400",

                "playerBgColor" => "rgb(39,54,59)",
                "iconColor" => "rgb(238,238,238)",
                "iconHoverColor" => "rgb(255,164,143)",
                "playerTitleTextColor" => "rgb(255,255,255)",
                "playerArtistTextColor" => "rgb(255,164,143)",
                "volumeBgColor" => "rgb(204,204,204)",
                "volumeLevelColor" => "rgb(255,164,143)",
                "seekbarBgColor" => "rgb(204,204,204)",
                "seekbarLoadColor" => "rgb(204,204,204)",
                "seekbarProgressColor" => "rgb(255,164,143)",
                "adSeekbarProgressColor" => "rgb(255,235,59)",
                
                "playlistItemTextColor" => "rgb(170,170,170)",
                "playlistItemSelectedTextColor" => "rgb(255,255,255)",
                "playlistItemSelectedBgColor" => "rgb(221,221,221)",
                "playlistDescriptionTextColor" => "rgb(85,85,85)",
                "playlistDurationTextColor" => "rgb(204,204,204)",
                "playlistDateTextColor" => "rgb(120,120,120)",
                "playlistIconColor" => "rgb(255,255,255)",
                "playlistIconHoverColor" => "rgb(255,164,143)",

                "filterBgColor" => "rgb(221,221,221)",
                "filterTextColor" => "rgb(51,51,51)",
                "nothingFoundTextColor" => "rgb(255,255,255)",
                "tooltipBgColor" => "rgb(255,164,143)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(255,164,143)",

                "statsIconColor" => "rgb(255,255,255)",
                "statsIconHoverColor" => "rgb(255,164,143)",

                "dialogHeaderBgColor" => "rgb(39,54,59)",
                "dialogContentBgColor" => "rgb(221,221,221)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,164,143)",

            );

            break;    

        case 'wall':

            return array(
            
                "usePlaylistScroll" => true,
                "playlistScrollTheme" => "minimal",
                "playlistItemContent" => array("title","thumb"),
                "playlistOpened" => true,
                "artistTitleSeparator" => "&nbsp;-&nbsp;",

                "playlistBgColor" => "rgb(255,255,255)",
                "playlistItemOverlayBgColor" => "rgba(0,0,0,0.7)",
                "playerBgColor" => "rgb(237,237,237)",
                "iconColor" => "rgb(85,85,85)",
                "iconHoverColor" => "rgb(255,255,255)",
                "volumeBgColor" => "rgb(119,119,119)",
                "volumeLevelColor" => "rgb(255,255,255)",
                "seekbarBgColor" => "rgb(51,51,51)",
                "seekbarLoadColor" => "rgb(115,115,115)",
                "seekbarProgressColor" => "rgb(233,30,99)",
                "timeTextColor" => "rgb(102,102,102)",

                "playerTitleTextColor" => "rgb(17,17,17)",
                "playerDescTextColor" => "rgb(17,17,17)",
                "playlistItemTextColor" => "rgb(255,255,255)",
                "playlistIconColor" => "rgb(170,170,170)",
                "playlistIconHoverColor" => "rgb(255,255,255)",

                "statsIconColor" => "rgb(170,170,170)",
                "statsIconHoverColor" => "rgb(255,255,255)",

                "tooltipBgColor" => "rgb(233,30,99)",
                "tooltipTextColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(233,30,99)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

                
            );

        break;  

        case 'tiny_dark_1':
        case 'tiny_dark_2':
        case 'tiny_dark_3':

            return array(

                "addPlaylistEvents" => false,
                "addResizeEvent" => false,
                "usePlaylistScroll" => false,
            
                "iconColor" => "rgb(204,204,204)",
                "iconHoverColor" => "rgb(255,255,255)",

                "volumeBgColor" => "rgb(136,136,136)",
                "volumeLevelColor" => "rgb(255,255,255)",
                "seekbarLoadColor" => "rgb(136,136,136)",
                "seekbarProgressColor" => "rgb(255,255,255)",
                
                "tooltipBgColor" => "rgb(51,51,51)",
                "tooltipTextColor" => "rgb(255,255,255)",

            );

            break;

        case 'tiny_light_1':
        case 'tiny_light_2':
        case 'tiny_light_3':

            return array(

                "addPlaylistEvents" => false,
                "addResizeEvent" => false,
                "usePlaylistScroll" => false,
            
                "iconColor" => "rgb(102,102,102)",
                "iconHoverColor" => "rgb(255,255,255)",

                "volumeBgColor" => "rgb(136,136,136)",
                "volumeLevelColor" => "rgb(255,255,255)",
                "seekbarLoadColor" => "rgb(136,136,136)",
                "seekbarProgressColor" => "rgb(255,255,255)",
                
                "tooltipBgColor" => "rgb(255,255,255)",
                "tooltipTextColor" => "rgb(102,102,102)",

            );

            break; 

        case 'compact_1':
        case 'compact_2':

            return array(

                "addPlaylistEvents" => false,
                "addResizeEvent" => false,
                "usePlaylistScroll" => false,

                "playerBgColor" => "rgb(121,85,72)",
            
                "iconColor" => "rgb(221,221,221)",
                "iconHoverColor" => "rgb(255,255,255)",

                "volumeBgColor" => "rgb(204,204,204)",
                "volumeLevelColor" => "rgb(255,87,34)",

            );

            break;  

        case 'grid':

            return array(
            
                "activeItem" => -1,
                "addResizeEvent" => false,
                "usePlaylistScroll" => false,
                "playlistItemContent" => array("title,thumb"),
              
                "playlistTitleTextColor" => "rgb(51,51,51)",
                "playlistArtistTextColor" => "rgb(51,51,51)",
                "playlistDescriptionTextColor" => "rgb(153,153,153)",
                "playlistDurationTextColor" => "rgb(240,240,240)",
                "playlistDateTextColor" => "rgb(120,120,120)",
                "playlistInfoBgColor" => "rgb(255,255,255)",
                "preloaderColor" => "rgb(33,93,153)",    

                "filterBgColor" => "rgba(1255,255,255,0)", 
                "filterTextColor" => "rgb(153,153,153)", 
                "nothingFoundTextColor" => "rgb(130,130,130)",  

                "preloaderColor" => "rgb(33,150,243)",   

                //load more
                "loadMoreBtnTextColor" => "rgb(51,51,51)",
                "loadMoreBtnBgColor" => "rgb(221,221,221)",
                "loadMoreBtnTextHoverColor" => "rgb(255,255,255)",
                "loadMoreBtnBgHoverColor" => "rgb(33,93,153)",  
                
                //pagination
                "paginationBtnBgColor" => "rgb(226,230,230)",
                "paginationBtnTextColor" => "rgb(97,104,114)",
                "paginationBtnActiveBgColor" => "rgb(81,138,203)",
                "paginationBtnActiveTextColor" => "rgb(255,255,255)",

                "playlistIconColor" => "rgb(102,102,102)",
                "playlistIconHoverColor" => "rgb(63,81,181)",
                "statsIconColor" => "rgb(102,102,102)",
                "statsIconHoverColor" => "rgb(63,81,181)",

                "dialogHeaderBgColor" => "rgb(119,119,119)",
                "dialogContentBgColor" => "rgb(255,255,255)",

                "lyricsTextColor" => "rgb(0,0,0)",
                "lyricsActiveBgColor" => "rgb(255,255,0)",

            );

            break; 

        default:

            return 'No such preset!';

            break;


        }
    }

?>