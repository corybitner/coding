<?php

	/*
	Plugin Name: Modern Audio Player
	Plugin URI: http://codecanyon.net/user/Tean/portfolio
	Description: Powerful Audio Player for your website
	Version: 5.81
	Author: Tean
	Author URI: http://codecanyon.net/user/Tean
	*/



	if(!defined('ABSPATH'))exit;// Exit if accessed directly

	define('HAP_FILE_DIR', WP_CONTENT_DIR . '/uploads/map-file-dir/');
	define('HAP_FILE_DIR_URL', WP_CONTENT_URL . '/uploads/map-file-dir/');
	define('HAP_CAPABILITY', 'manage_options');
	define('HAP_BSF_MATCH', 'ebsfm:');//encrypt media 
	define('HAP_TEXTDOMAIN', 'modern-audio-player');

	include(dirname(__FILE__) . '/includes/utils.php');
	include(dirname(__FILE__) . '/includes/widgets.php');
	include(dirname(__FILE__) . '/includes/statistics.php');
	include(dirname(__FILE__) . '/includes/locale.php');
	include(dirname(__FILE__) . '/includes/player_options.php');
	
	if(is_admin()){
		
		include(dirname(__FILE__) . '/source/includes/ipaddress.php');

		register_activation_hook(__FILE__, "hap_player_activate"); 
		register_uninstall_hook(__FILE__, "hap_player_uninstall"); 

		add_action('admin_menu', 'hap_admin_menu');
		add_action('admin_enqueue_scripts', 'hap_admin_enqueue_scripts');
		add_action('plugins_loaded', 'hap_plugins_loaded');

		//global
		add_action('wp_ajax_hap_save_global_options', 'hap_save_global_options');

		//player
		add_action('wp_ajax_hap_create_player', 'hap_create_player');
		add_action('wp_ajax_hap_duplicate_player', 'hap_duplicate_player');
		add_action('wp_ajax_hap_edit_player_title', 'hap_edit_player_title');
		add_action('wp_ajax_hap_delete_player', 'hap_delete_player');
		add_action('wp_ajax_hap_save_player_options', 'hap_save_player_options');
		add_action('wp_ajax_hap_get_player_lang', 'hap_get_player_lang');

		//playlist
		add_action('wp_ajax_hap_create_playlist', 'hap_create_playlist');
		add_action('wp_ajax_hap_edit_playlist_title', 'hap_edit_playlist_title');
		add_action('wp_ajax_hap_duplicate_playlist', 'hap_duplicate_playlist');
		add_action('wp_ajax_hap_delete_playlist', 'hap_delete_playlist');
		add_action('wp_ajax_hap_save_playlist_options', 'hap_save_playlist_options');

		//media
		add_action('wp_ajax_hap_update_media_order', 'hap_update_media_order');
		add_action('wp_ajax_hap_delete_media', 'hap_delete_media');
		add_action('wp_ajax_hap_copy_media', 'hap_copy_media');
		add_action('wp_ajax_hap_move_media', 'hap_move_media');
		add_action('wp_ajax_hap_add_media', 'hap_add_media');
		add_action('wp_ajax_hap_add_media_multiple', 'hap_add_media_multiple');
		add_action('wp_ajax_hap_edit_media', 'hap_edit_media');
		add_action('wp_ajax_hap_get_media', 'hap_get_media');
		add_action('wp_ajax_hap_save_peaks', 'hap_save_peaks');

		//ad
		add_action('wp_ajax_hap_save_ad_options', 'hap_save_ad_options');
		add_action('wp_ajax_hap_edit_ad_title', 'hap_edit_ad_title');
		add_action('wp_ajax_hap_delete_ad', 'hap_delete_ad');
		add_action('wp_ajax_hap_duplicate_ad', 'hap_duplicate_ad');
		add_action('wp_ajax_hap_create_ad', 'hap_create_ad');

		add_action('wp_ajax_hap_get_shortcode_atts', 'hap_get_shortcode_atts');

		//taxonomy
		add_action('wp_ajax_hap_add_taxonomy', 'hap_add_taxonomy');
		add_action('wp_ajax_hap_edit_taxonomy', 'hap_edit_taxonomy');
		add_action('wp_ajax_hap_delete_taxonomy', 'hap_delete_taxonomy');
	

		//statistics backend
		add_action('wp_ajax_hap_stat_clear', 'hap_stat_clear');
		add_action('wp_ajax_hap_stat_create_graph', 'hap_stat_create_graph');
		add_action('wp_ajax_hap_get_stat_data', 'hap_get_stat_data');

		//statistics player
		add_action('wp_ajax_hap_play_count', 'hap_play_count');
		add_action('wp_ajax_hap_time_played', 'hap_time_played');
		add_action('wp_ajax_hap_like_count', 'hap_like_count');
		add_action('wp_ajax_hap_download_count', 'hap_download_count');
		add_action('wp_ajax_hap_finish_count', 'hap_finish_count');
		add_action('wp_ajax_hap_skipped_first_minute', 'hap_skipped_first_minute');
		add_action('wp_ajax_hap_all_count', 'hap_all_count');

		add_action('wp_ajax_nopriv_hap_play_count', 'hap_play_count');
		add_action('wp_ajax_nopriv_hap_time_played', 'hap_time_played');
		add_action('wp_ajax_nopriv_hap_like_count', 'hap_like_count');
		add_action('wp_ajax_nopriv_hap_download_count', 'hap_download_count');
		add_action('wp_ajax_nopriv_hap_finish_count', 'hap_finish_count');
		add_action('wp_ajax_nopriv_hap_skipped_first_minute', 'hap_skipped_first_minute');
		add_action('wp_ajax_nopriv_hap_all_count', 'hap_all_count');

		//taxonomy
		add_action('wp_ajax_hap_get_media_with_taxonomy', 'hap_get_media_with_taxonomy');
		add_action('wp_ajax_nopriv_hap_get_media_with_taxonomy', 'hap_get_media_with_taxonomy');

		//load more on runtime
		add_action('wp_ajax_hap_add_more', 'hap_add_more');
		add_action('wp_ajax_nopriv_hap_add_more', 'hap_add_more');

		add_action('wp_ajax_hap_paginate', 'hap_paginate');
		add_action('wp_ajax_nopriv_hap_paginate', 'hap_paginate');

		add_filter('upload_mimes', 'hap_enable_custom_mime');

		//playlist create
		add_action('wp_ajax_hap_make_playlist', 'hap_make_playlist');
		add_action('wp_ajax_nopriv_hap_make_playlist', 'hap_make_playlist');

		//export, import
		add_action('wp_ajax_hap_export_playlist', 'hap_export_playlist');
		add_action('wp_ajax_hap_clean_export', 'hap_clean_export');
		add_action('wp_ajax_hap_import_playlist', 'hap_import_playlist');
		add_action('wp_ajax_hap_import_playlist_db', 'hap_import_playlist_db');

		add_action('wp_ajax_hap_export_player', 'hap_export_player');
		add_action('wp_ajax_hap_import_player', 'hap_import_player');
		add_action('wp_ajax_hap_import_player_db', 'hap_import_player_db');

		add_action('wp_ajax_hap_export_ad', 'hap_export_ad');
		add_action('wp_ajax_hap_import_ad', 'hap_import_ad');
		add_action('wp_ajax_hap_import_ad_db', 'hap_import_ad_db');

		add_action('init', 'hap_init_setup');
    	add_action('enqueue_block_editor_assets', 'hap_enqueue_block_assets');

	}else{

		include(dirname(__FILE__) . '/includes/shortcode.php');

		add_shortcode('apmap', 'hap_add_player');
		add_shortcode('apmap_audio', 'hap_get_media_fields');
		add_shortcode('apmap_get_stats', 'hap_get_stats');
		add_shortcode('apmap_playlist_display', 'hap_playlist_display');
		add_shortcode('apmap_playlist_create', 'hap_playlist_create');

		add_action('wp_enqueue_scripts', 'hap_enqueue_scripts');
		add_action('init', 'hap_init_frontend');
	
	}



	/* widgets */

	add_action('widgets_init', 'hap_register_widgets');
	function hap_register_widgets(){
		register_widget('ModernAudioPlayerWidget');
	}

	function hap_init_frontend() {

		global $wpdb;
	    $settings_table = $wpdb->prefix . "map_settings";
	    $result = $wpdb->get_row("SELECT options FROM {$settings_table} WHERE id = '0'", ARRAY_A);

	    if($result){
		    $settings = unserialize($result['options']);
		    $overide_wp_audio = isset($settings["overide_wp_audio"]) ? (bool)($settings["overide_wp_audio"]) : false;
		    $overide_wp_audio_playlist = isset($settings["overide_wp_audio_playlist"]) ? (bool)($settings["overide_wp_audio_playlist"]) : false;

		    if($overide_wp_audio){
		    	add_filter('wp_audio_shortcode_override', 'hap_audio_shortcode_override', 10, 2);
		    	add_filter('the_content', 'hap_disable_wp_auto_p', 0 );
		    }
		    if($overide_wp_audio_playlist){
		    	add_filter('post_playlist', 'hap_playlist_shortcode_override', 10, 3); 
		    }

		}

	}

	/* gutenberg */

	function hap_init_setup() {

        if (function_exists('register_block_type')) {
            register_block_type('modern-audio-player/block', array(
                'attributes' => array(
                    'player_id' => array(
                        'type' => 'string'
                    ),
                    'playlist_id' => array(
                        'type' => 'string'
                    ),
                    'ad_id' => array(
                        'type' => 'string'
                    )
                ))
            );
        }

    }

    function hap_enqueue_block_assets() {
        if (function_exists('register_block_type')) {
			wp_enqueue_script('apmap-block', plugins_url('js/block.js', __FILE__), array('wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element'));

			wp_enqueue_style('hap-block-editor-css', plugins_url('/css/block.css', __FILE__), array('wp-edit-blocks'));

			global $wpdb;
            $player_table = $wpdb->prefix . "map_players";
            $playlist_table = $wpdb->prefix . "map_playlists";
            $ad_table = $wpdb->prefix . "map_ad";

            //load players
            $players = $wpdb->get_results("SELECT id, title FROM {$player_table} ORDER BY title ASC", ARRAY_A);
            //load playlists
            $playlists = $wpdb->get_results("SELECT id, title FROM {$playlist_table} ORDER BY title ASC", ARRAY_A);
            //load ads
            $ads = $wpdb->get_results("SELECT id, title FROM {$ad_table} ORDER BY title ASC", ARRAY_A);

			wp_localize_script( 'apmap-block', 'map_block_data', array('players' => json_encode($players, JSON_HEX_TAG),
																       'playlists' => json_encode($playlists, JSON_HEX_TAG),
																       'ads' => json_encode($ads, JSON_HEX_TAG)));

        }

    }

    /* mime */
	
	function hap_enable_custom_mime ( $mime_types = array() ) {

	   $mime_types['m3u8'] = 'application/x-mpegURL,application/vnd.apple.mpegurl';
	   $mime_types['ts'] = 'video/MP2T';
	   $mime_types['xml'] = 'application/xml';
	   $mime_types['json'] = 'application/json';
	   $mime_types['m3u'] = 'audio/x-mpegurl,audio/mpeg-url,application/x-winamp-playlist,audio/scpls,audio/x-scpls';

	   return $mime_types;
	}

	/* audio override */

	function hap_disable_wp_auto_p( $content ) {
	    remove_filter( 'the_content', 'wpautop' );
	    remove_filter( 'the_excerpt', 'wpautop' );
	    return $content;
	}

	function hap_audio_shortcode_override( $html, $attr ) {

		if(!function_exists('hap_add_player'))return "";

		if (isset( $attr['wav']) || isset( $attr['mp3']) || isset( $attr['m4a']) || isset( $attr['ogg']) || isset( $attr['src'])){

			$attr['type'] = 'audio';
			$attr['use_playlist'] = '0';
			$attr['hap_overwrite'] = 'single';
			if(isset($attr['loop']) && $attr['loop'] == "on")$attr['loop_state'] = 'single';
			else $attr['loop_state'] = 'off';

			/*$attr['use_next'] = '0';
			$attr['use_previous'] = '0';
			$attr['use_shuffle'] = '0';
			$attr['use_loop'] = '0';*/

			return hap_add_player($attr);
		}else{
			return "";
		}

	};

	function hap_playlist_shortcode_override( $var, $attr, $instance ) { 

		if(!function_exists('hap_add_player'))return "";

		if (( ! empty( $attr['type'] ) && $attr['type'] !== 'audio' ) || ( empty( $attr['ids'] ) ) )return '';
		if(isset($attr['hap_overwrite']) && $attr['hap_overwrite'] === 'single')return '';

	    $atts = shortcode_atts(
			array(
				'type'         => 'audio',
				'order'        => 'ASC',
				'orderby'      => 'menu_order ID',
				'id'           => 0,
				'include'      => '',
				'exclude'      => '',
				'style'        => 'light',
				'tracklist'    => true,
				'tracknumbers' => true,
				'images'       => true,
				'artists'      => true,
			),
			$attr,
			'playlist'
		);

	    $args = array(
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => $atts['type'],
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby'],
		);

	    if ( ! empty( $atts['include'] ) ) {
			$args['include'] = $atts['include'];
			$_attachments    = get_posts( $args );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[ $val->ID ] = $_attachments[ $key ];
			}
		} elseif ( ! empty( $atts['exclude'] ) ) {
			$args['post_parent'] = $id;
			$args['exclude']     = $atts['exclude'];
			$attachments         = get_children( $args );
		} else {
			$args['post_parent'] = $id;
			$attachments         = get_children( $args );
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id ) . "\n";
			}
			return $output;
		}

		$hap_content = '';
		$tracks = array();
		foreach ( $attachments as $attachment ) {

			$url   = wp_get_attachment_url( $attachment->ID );
			$ftype = wp_check_filetype( $url, wp_get_mime_types() );
			$track = array(
				'src'         => $url,
				'type'        => $ftype['type'],
				'title'       => $attachment->post_title,
				'caption'     => $attachment->post_excerpt,
				'description' => $attachment->post_content,
			);

			$track['meta'] = array();
			$meta          = wp_get_attachment_metadata( $attachment->ID );
			if ( ! empty( $meta ) ) {
				foreach ( wp_get_attachment_id3_keys( $attachment ) as $key => $label ) {
					if ( ! empty( $meta[ $key ] ) ) {
						$track['meta'][ $key ] = $meta[ $key ];
					}
				}
			}

			if ( $atts['images'] ) {
				$thumb_id = get_post_thumbnail_id( $attachment->ID );
				if ( ! empty( $thumb_id ) ) {
					list( $src, $width, $height ) = wp_get_attachment_image_src( $thumb_id, 'full' );
					$track['image']               = compact( 'src', 'width', 'height' );
					list( $src, $width, $height ) = wp_get_attachment_image_src( $thumb_id, 'thumbnail' );
					$track['thumb']               = compact( 'src', 'width', 'height' );
				} else {
					$src            = wp_mime_type_icon( $attachment->ID );
					$width          = 48;
					$height         = 64;
					$track['image'] = compact( 'src', 'width', 'height' );
					$track['thumb'] = compact( 'src', 'width', 'height' );
				}
			}

			//duration
			$time = $track['meta']['length_formatted'];
			$timeArr = array_reverse(explode(":", $time));
			$seconds = 0;
			foreach ($timeArr as $key => $value){
			    if ($key > 2) break;
			    $seconds += pow(60, $key) * $value;
			}

			$hap_content .= '[apmap_audio type="audio" title="'.$attachment->post_title.'" path="'.$url.'" thumb="'.$track['image']['src'].'" duration="'.$seconds.'"';
			if(isset($track['meta']['artist']))$hap_content .= ' artist="'.$track['meta']['artist'].'"';
			$hap_content .= ']';

			//$tracks[] = $track;
		}

		$use_playlist = isset($atts['tracklist']) && $atts['tracklist'] === 'false' ? false : true;
		$hap_atts = array("hap_overwrite" => 'playlist',
						  "playlist_item_content" => 'title,thumb,duration',
				  		  "use_playlist" => $use_playlist);

 		return hap_add_player($hap_atts, $hap_content);

	}; 

	


	/* scripts */

	function hap_admin_enqueue_scripts( $hook_suffix ) {

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_media();

		wp_enqueue_style("spectrum", plugins_url('/css/spectrum.css', __FILE__));
		wp_enqueue_script("spectrum", plugins_url('/js/spectrum.js', __FILE__), array('jquery'));	

		wp_enqueue_style('hap-admin', plugins_url('/css/admin.css', __FILE__));	

		wp_enqueue_script("hap-general", plugins_url('/js/admin_general.js', __FILE__), array('jquery'));

		switch ( $hook_suffix ) {

			case get_plugin_page_hookname( 'hap_settings', 'hap_settings' ):

				wp_enqueue_script("hap-admin", plugins_url('/js/admin_global.js', __FILE__), array('jquery'));	

	        break;

	        case get_plugin_page_hookname( 'hap_player_manager', 'hap_settings' ):

		        wp_enqueue_style("codemirror", "//cdnjs.cloudflare.com/ajax/libs/codemirror/5.45.0/codemirror.min.css");
				wp_enqueue_script("codemirror", "//cdnjs.cloudflare.com/ajax/libs/codemirror/5.45.0/codemirror.min.js");

				wp_enqueue_script("hap-admin", plugins_url('/js/admin_player_manager.js', __FILE__), array('jquery'));	

	        break;

	        case get_plugin_page_hookname( 'hap_playlist_manager', 'hap_settings' ):
	        
	        	wp_enqueue_style("fa", "https://use.fontawesome.com/releases/v5.7.2/css/all.css");//pi icons

	        	wp_enqueue_script('wavesurfer', "https://unpkg.com/wavesurfer.js", array('jquery'));

				wp_enqueue_script("hap-admin", plugins_url('/js/admin_playlist_manager.js', __FILE__), array('jquery'));	

				//multi select
				wp_enqueue_style("select2", "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css");	
				wp_enqueue_script("select2", "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js", array('jquery'));

	        break;

	        case get_plugin_page_hookname( 'hap_ad_manager', 'hap_settings' ):

				wp_enqueue_script("hap-admin", plugins_url('/js/admin_admanager.js', __FILE__), array('jquery'));	
				wp_enqueue_script("hap-ads", plugins_url('/js/admin_adcontent.js', __FILE__), array('jquery'));	

	        break;

	        case get_plugin_page_hookname( 'hap_statistics', 'hap_settings' ):

	        	wp_enqueue_script("chart", "//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js");

	        	wp_enqueue_script("selectize", "//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js");

	        	wp_enqueue_style("selectize", "//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css");

	        	wp_enqueue_script("momentjs", "//cdn.jsdelivr.net/momentjs/latest/moment.min.js");
	        	wp_enqueue_script("daterangepicker", "//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js");
				wp_enqueue_style("daterangepicker", "//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css");

	        	wp_enqueue_script("hap-admin", plugins_url('/js/admin_stat.js', __FILE__), array('jquery'));

	        break;

	        case get_plugin_page_hookname( 'hap_shortcodes', 'hap_settings' ):

	        	wp_enqueue_script('wavesurfer', "https://unpkg.com/wavesurfer.js", array('jquery'));

	        	wp_enqueue_script("hap-admin", plugins_url('/js/admin_playlist_manager.js', __FILE__), array('jquery'));	

	        	wp_enqueue_script("hap-admin-shortcode", plugins_url('/js/admin_shortcode.js', __FILE__), array('jquery'));

	        	//multi select
				wp_enqueue_style("select2", "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css");	
				wp_enqueue_script("select2", "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js", array('jquery'));

	        break;

	        case get_plugin_page_hookname( 'hap_taxonomy', 'hap_settings' ):

	        	wp_enqueue_script("hap-admin", plugins_url('/js/admin_taxonomy.js', __FILE__), array('jquery'));

	        case get_plugin_page_hookname( 'hap_demo', 'hap_settings' ):

	        	wp_enqueue_script("hap-admin", plugins_url('/js/admin_demo.js', __FILE__), array('jquery'));	

	        break;
	    }

	    $l_data = array('plugins_url' => plugins_url('', __FILE__),
						 'file_url' => HAP_FILE_DIR, 
						 'WP_CONTENT_URL' => WP_CONTENT_URL,
				         'ajax_url' => admin_url( 'admin-ajax.php'),
			         	 'security'  => wp_create_nonce( 'hap-security-nonce' ));

	    global $wpdb;
	    $settings_table = $wpdb->prefix . "map_settings";
	    $result = $wpdb->get_row("SELECT options FROM {$settings_table} WHERE id = '0'", ARRAY_A);

	    if($result){
	    	$g_settings1 = hap_player_global_settings();
			$g_settings2 = unserialize($result['options']);
		    $settings = $g_settings2 + $g_settings1;
		    $l_data['settings'] = $settings;
		}

	    wp_localize_script('hap-admin', 'hap_data', $l_data); 
	}

	function hap_enqueue_scripts() {

		global $wpdb;
	    $settings_table = $wpdb->prefix . "map_settings";
	    $result = $wpdb->get_row("SELECT options FROM {$settings_table} WHERE id = '0'", ARRAY_A);

	    $loadGoogleFontsLocally = false;

	    if($result){
	    	$settings = unserialize($result['options']);
	    	$js_to_footer = isset($settings["js_to_footer"]) ? (bool)($settings["js_to_footer"]) : false;

	    	if(isset($settings["loadGoogleFontsLocally"]) && $settings["loadGoogleFontsLocally"] == '1') $loadGoogleFontsLocally = true;
	    }else{
	    	$js_to_footer = false;
	    }

	    wp_enqueue_script('jquery');


		if(!$loadGoogleFontsLocally)wp_enqueue_style('hap-mi', "//fonts.googleapis.com/icon?family=Material+Icons");//material icons

		//playlist icons
    	if($settings['add_font_awesome_css'] == '1')wp_enqueue_style('fontawesome', "https://use.fontawesome.com/releases/v5.7.2/css/all.css");

		wp_enqueue_style('hap-global', plugins_url('/source/css/_global.css', __FILE__));
		wp_enqueue_style('hap', plugins_url('/source/css/hap.css', __FILE__));
		
		wp_enqueue_script('hap-id3', plugins_url('/source/js/jsmediatags.min.js', __FILE__), array('jquery'), false, $js_to_footer);//id3 tags

		wp_enqueue_script('hap', plugins_url('/source/js/new.js', __FILE__), array('jquery'), false, $js_to_footer);//main js

	}

	/* menu */

	function hap_admin_menu(){

		add_menu_page('Modern Audio Player Player manager', 'Modern Audio Player', HAP_CAPABILITY, 'hap_settings', 'hap_settings_page', 'dashicons-playlist-audio');

		add_submenu_page('hap_settings', __('Modern Audio Player', HAP_TEXTDOMAIN), __('Global settings', HAP_TEXTDOMAIN), HAP_CAPABILITY, 'hap_settings');	
		add_submenu_page('hap_settings', __('Modern Audio Player', HAP_TEXTDOMAIN), __('Player manager', HAP_TEXTDOMAIN), HAP_CAPABILITY, 'hap_player_manager', 'hap_player_manager_page');	
		add_submenu_page('hap_settings', __('Modern Audio Player', HAP_TEXTDOMAIN), __('Playlist manager', HAP_TEXTDOMAIN), HAP_CAPABILITY, 'hap_playlist_manager', 'hap_playlist_manager_page');
		add_submenu_page('hap_settings', __('Modern Audio Player', HAP_TEXTDOMAIN), __('Ad manager', HAP_TEXTDOMAIN), HAP_CAPABILITY, 'hap_ad_manager', 'hap_ad_manager_page');
		add_submenu_page('hap_settings', __('Modern Audio Player', HAP_TEXTDOMAIN), __('Shortcodes', HAP_TEXTDOMAIN), HAP_CAPABILITY, 'hap_shortcodes', 'hap_shortcodes_page');
		add_submenu_page('hap_settings', __('Modern Audio Player', HAP_TEXTDOMAIN), __('Statistics', HAP_TEXTDOMAIN), HAP_CAPABILITY, 'hap_statistics', 'hap_statistics_page');
		add_submenu_page('hap_settings', __('Modern Audio Player', HAP_TEXTDOMAIN), __('Genres', HAP_TEXTDOMAIN), HAP_CAPABILITY, 'hap_taxonomy', 'hap_taxonomy_page');
		add_submenu_page('hap_settings', __('Modern Audio Player', HAP_TEXTDOMAIN), __('Demos', HAP_TEXTDOMAIN), HAP_CAPABILITY, 'hap_demo', 'hap_demo_page');

	}

	function hap_settings_page(){

		global $wpdb;
		$wpdb->show_errors(); 
		$settings_table = $wpdb->prefix . "map_settings";

		include("includes/settings.php");
	}

	function hap_player_manager_page(){

		global $wpdb;
		$wpdb->show_errors(); 
		$player_table = $wpdb->prefix . "map_players";

		$action = "";
		if(isset($_GET['action'])){
			$action = $_GET['action'];
		}

		switch($action) {
	
			case 'edit_player':
				include("includes/edit_player.php");
				break;

			default:
				include("includes/player_manager.php");
				break;
				
		}
		
	}

	function hap_playlist_manager_page(){
		
		global $wpdb;
		$wpdb->show_errors(); 
		$playlist_table = $wpdb->prefix . "map_playlists";
		$media_table = $wpdb->prefix . "map_media";
		$taxonomy_table = $wpdb->prefix . "map_taxonomy";
		$playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";
		$media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
		$statistics_table = $wpdb->prefix . "map_statistics";

		$action = "";
		if(isset($_GET['action'])){
			$action = $_GET['action'];
		}

		switch($action) {
		
			case 'edit_playlist':
				include("includes/edit_playlist.php");
				break;

			default:
				include("includes/playlist_manager.php");
				break;
				
		}

	}

	function hap_ad_manager_page(){

		global $wpdb;
		$wpdb->show_errors(); 
		$ad_table = $wpdb->prefix . "map_ad";

		$action = "";
		if(isset($_GET['action'])){
			$action = $_GET['action'];
		}

		switch($action) {
		
			case 'edit_ad':
				include("includes/edit_ad.php");
				break;

			default:
				include("includes/ad_manager.php");
				break;
				
		}
		
	}

	function hap_shortcodes_page(){

		global $wpdb;
		$wpdb->show_errors(); 
		$player_table = $wpdb->prefix . "map_players";
		$playlist_table = $wpdb->prefix . "map_playlists";
		$ad_table = $wpdb->prefix . "map_ad";

		include("includes/shortcode_manager.php");
	}

	function hap_statistics_page(){

		global $wpdb;
		$wpdb->show_errors(); 
		$statistics_table = $wpdb->prefix . "map_statistics";
		$player_table = $wpdb->prefix . "map_players";
		$playlist_table = $wpdb->prefix . "map_playlists";

		include("includes/statistics_display.php");

	}

	function hap_taxonomy_page(){

		global $wpdb;
		$wpdb->show_errors(); 
		$taxonomy_table = $wpdb->prefix . "map_taxonomy";

		include("includes/map_taxonomy.php");
	}

	function hap_demo_page(){

		global $wpdb;
		$wpdb->show_errors(); 

		include("includes/demo.php");
	}

	//############################################//
	/* global */
	//############################################//

	function hap_save_global_options(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['options'])){

			$settings = json_decode(stripcslashes($_POST['options']), true);

			global $wpdb;
			$wpdb->show_errors(); 
		    $settings_table = $wpdb->prefix . "map_settings";

			$id = $wpdb->get_row("SELECT id FROM {$settings_table}");
		    if($wpdb->num_rows > 0){

		    	$stmt = $wpdb->update(
			    	$settings_table,
					array('options' => serialize($settings)), 
					array('id' => 0),
					array('%s'),
					array('%d')
			    );

		    }else{

		    	$stmt = $wpdb->insert(
			    	$settings_table,
					array('options' => serialize($settings)), 
					array('%s')
			    );

		    }

			if($stmt !== false){
	    		echo json_encode($stmt);
	    	}

	    	wp_die();

	    }else{
			wp_die();
		}

	}

	//############################################//
	/* player */
	//############################################//

	function hap_create_player(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title']) && isset($_POST['preset'])){

			$title = stripslashes($_POST['title']);
		    $preset = $_POST['preset'];

			$default_options = hap_player_options();
		    $preset_options = hap_player_options_preset($preset);
			$options = array_replace($default_options, $preset_options);//on add player we want to overwite options from individual preset. 

			global $wpdb;
			$wpdb->show_errors(); 
			$player_table = $wpdb->prefix . "map_players";

			$stmt = $wpdb->insert(
		    	$player_table,
				array( 
					'title' => $title,
					'preset' => $preset,
					'options' => serialize($options)
				), 
				array( 
					'%s',
					'%s',
					'%s'				
				) 
		    );

		    echo json_encode($wpdb->insert_id);

		    wp_die();

		}else{
			wp_die();
		}
	}

	function hap_duplicate_player(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title']) && isset($_POST['player_id'])){

			$player_id = $_POST['player_id'];
			$title = stripslashes($_POST['title']);

			global $wpdb;
			$player_table = $wpdb->prefix . "map_players";
		   
			$stmt = $wpdb->prepare("SELECT * FROM {$player_table} WHERE id = %d", $player_id);//get player options
			
			if($stmt !== false){

				$result = $wpdb->get_row($stmt, ARRAY_A);

			    $stmt = $wpdb->insert(//copy player
			    	$player_table,
					array( 
						'title' => $title,
						'preset' => $result['preset'],
						'options' => $result['options'],
						'custom_css' => $result['custom_css'],
						'custom_js' => $result['custom_js']
					), 
					array( 
						'%s',
						'%s',
						'%s',
						'%s',
						'%s'
					) 
			    );

			    if($stmt !== false){
		    		echo json_encode($wpdb->insert_id);
		    	}

			}

		    wp_die();

		}else{
			wp_die();
		}

	}

	function hap_edit_player_title(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title']) && isset($_POST['id'])){

			$title = stripcslashes($_POST["title"]);
			$id = $_POST["id"];

			global $wpdb;
		    $player_table = $wpdb->prefix . "map_players";

		    $wpdb->update(
		    	$player_table,
				array( 
					'title' => $title
				), 
				array('id' => $id),
				array( 
					'%s'
				),
				array( 
					'%d'
				) 
		    );

		    echo json_encode('');

		    wp_die();

		}else{
			wp_die();
		}
	}

	function hap_delete_player(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['player_id'])){

			$player_id = $_POST['player_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $player_table = $wpdb->prefix . "map_players";

			$ids = explode(',',$player_id);
			$in = implode(',', array_fill(0, count($ids), '%d'));

		    $stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$player_table} WHERE id IN ($in)", $ids));

			if($stmt !== false){
	    		echo json_encode($stmt);
	    	}

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_save_player_options(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['player_id'])){

			$player_id = $_POST['player_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $player_table = $wpdb->prefix . "map_players";

			$custom_css = !hap_nullOrEmpty($_POST['custom_css']) ? $_POST['custom_css'] : NULL;
			$custom_js = !hap_nullOrEmpty($_POST['custom_js']) ? ($_POST['custom_js']) : NULL;
			$player_options = json_decode(stripcslashes($_POST['player_options']), true);

			$stmt = $wpdb->update(
		    	$player_table,
				array('options' => serialize($player_options), 'custom_css' => $custom_css, 'custom_js' => $custom_js), 
				array('id' => $player_id),
				array('%s','%s','%s'),
				array('%d')
		    );

	    	echo json_encode('');

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_get_player_lang(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['lang'])){

	        $lang = stripslashes($_POST['lang']);

	        $locale = hap_locale_data($lang);
	   
	        echo json_encode($locale);

	        wp_die();

	    }else{
	        wp_die();
	    }
	}

	
	

	


	//############################################//
	/* playlist */
	//############################################//
	
	function hap_edit_playlist_title(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title']) && isset($_POST['id'])){

			$title = stripcslashes($_POST["title"]);
			$id = $_POST["id"];

			global $wpdb;
		    $playlist_table = $wpdb->prefix . "map_playlists";

		    $wpdb->update(
		    	$playlist_table,
				array( 
					'title' => $title
				), 
				array('id' => $id),
				array( 
					'%s'
				),
				array( 
					'%d'
				) 
		    );

		    echo json_encode("");

		    wp_die();

		}else{
			wp_die();
		}
	}

	function hap_create_playlist(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title'])){

			$title = stripslashes($_POST['title']);

			global $wpdb;
			$playlist_table = $wpdb->prefix . "map_playlists";

		    $stmt = $wpdb->insert(
		    	$playlist_table,
				array( 
					'title' => $title
				), 
				array( 
					'%s'				
				) 
		    );

		    $lastid = $wpdb->insert_id;

		    if(isset($_POST['media_id'])){//from stats

		    	$media_id = $_POST['media_id'];
				$_ids = explode('_', $media_id);

				$ids = array();
				foreach($_ids as $id){
		            $ids[] = array("id" => $id);
		        }  

				hap_duplicatePlaylist(null, $lastid, $ids, "playlist_id");

		    }else{

		    	if($stmt !== false){
		    		echo json_encode($lastid);
		    	}

		    }

		    wp_die();

		}else{
			wp_die();
		}
	}

	function hap_duplicate_playlist(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title']) && isset($_POST['playlist_id'])){

			$playlist_id = $_POST['playlist_id'];
			$title = stripslashes($_POST['title']);

			global $wpdb;
			$playlist_table = $wpdb->prefix . "map_playlists";

			$options = $wpdb->get_var($wpdb->prepare("SELECT options FROM {$playlist_table} WHERE id = %d", $playlist_id));

		    $stmt = $wpdb->insert(
		    	$playlist_table,
				array( 
					'title' => $title,
					'options' => $options
				), 
				array( 
					'%s','%s'
				) 
		    );

		    if($stmt !== false){//copy tracks
		    	//https://stackoverflow.com/questions/4039748/in-mysql-can-i-copy-one-row-to-insert-into-the-same-table

			    $lastid = $wpdb->insert_id;//playlist_id

		    	hap_duplicatePlaylist($playlist_id, $lastid, null, "playlist_id");

			}

		    wp_die();

		}else{
			wp_die();
		}

	}

	function hap_delete_playlist(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['playlist_id'])){

			$playlist_id = $_POST['playlist_id'];
			$ids = explode(',',$playlist_id);
			$in = implode(',', array_fill(0, count($ids), '%d'));

			global $wpdb;
			$wpdb->show_errors(); 
		    $playlist_table = $wpdb->prefix . "map_playlists";
		    $media_table = $wpdb->prefix . "map_media";
		    $statistics_table = $wpdb->prefix . "map_statistics";
			$playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";
			$media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";

			

		    $stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$playlist_table} WHERE id IN ($in)", $ids));

	    	//delete media
	    	$stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$media_table} WHERE playlist_id IN ($in)", $ids));

	    	//delete stat
	    	$stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$statistics_table} WHERE playlist_id IN ($in)", $ids));

	    	//delete playlist tax
	    	$stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$playlist_taxonomy_table} WHERE playlist_id IN ($in)", $ids));
	    	
	    	//delete media tax
	    	$stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$media_taxonomy_table} WHERE playlist_id IN ($in)", $ids));

			if($stmt !== false){
	    		echo json_encode($playlist_id);
	    	}

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	//############################################//
	/* media */
	//############################################//

	function hap_update_media_order(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['media_id_arr']) && isset($_POST['order_id_arr']) && isset($_POST['playlist_id'])){

			$media_id_arr = explode(",",$_POST["media_id_arr"]);
			$order_id_arr = explode(",",$_POST["order_id_arr"]);
			$playlist_id = $_POST["playlist_id"];

			global $wpdb;
		    $media_table = $wpdb->prefix . "map_media";

		    for($i=0;$i<count($media_id_arr);$i++) {

		        $stmt = $wpdb->update(
			    	$media_table,
					array( 
						'order_id' => $order_id_arr[$i]
					), 
					array('playlist_id' => $playlist_id, 'id' => $media_id_arr[$i]),
					array( 
						'%d'
					),
					array( 
						'%d','%d'
					) 
			    );

		    }

	    	echo json_encode($stmt);

		    wp_die();

		}else{
			wp_die();
		}
	}

	function hap_delete_media(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['media_id'])){

			$media_id = $_POST['media_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $media_table = $wpdb->prefix . "map_media";

			$ids = explode(',',$media_id);
			$in = implode(',', array_fill(0, count($ids), '%d'));

		    $stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$media_table} WHERE id IN ($in)", $ids));

			if($stmt !== false){

				$statistics_table = $wpdb->prefix . "map_statistics";
				$wpdb->query($wpdb->prepare("DELETE FROM {$statistics_table} WHERE media_id IN ($in)", $ids));

	    		echo json_encode($stmt);
	    	}

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_duplicatePlaylist($playlist_id = null, $lastid = null, $ids = null, $msg = null){

		global $wpdb;
		$wpdb->show_errors(); 
		$taxonomy_table = $wpdb->prefix . "map_taxonomy";
		$media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
		$playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";
		$media_table = $wpdb->prefix . "map_media";
		$ad_table = $wpdb->prefix . "map_ad";

		$tn = 'map_temp_table'.time();
		$order_id = 0;

		//copy taxonomy

		if($playlist_id != null){

			$wpdb->query($wpdb->prepare("CREATE TEMPORARY TABLE {$tn} SELECT * FROM $playlist_taxonomy_table WHERE playlist_id=%d", $playlist_id));
			$wpdb->query("UPDATE {$tn} SET id=NULL, playlist_id='$lastid'");//update id
			$wpdb->query("INSERT INTO $playlist_taxonomy_table SELECT * FROM {$tn}");
			$wpdb->query("DROP TABLE {$tn}");

			//get order
		    $stmt = $wpdb->get_row($wpdb->prepare("SELECT IFNULL(MAX(order_id)+1,0) AS order_id FROM {$media_table} WHERE playlist_id = %d", $lastid), ARRAY_A);
	        $order_id = $stmt['order_id'];
		}

		//copy tracks
		if($ids == null){
			$stmt = $wpdb->prepare("SELECT id FROM {$media_table} WHERE playlist_id = %d ORDER BY order_id", $playlist_id);
			$ids = $wpdb->get_results($stmt, ARRAY_A);
		}

		foreach ($ids as $id) {

			//duplicate tracks

			$stmt = $wpdb->query($wpdb->prepare("CREATE TEMPORARY TABLE {$tn} SELECT * FROM $media_table WHERE id=%d", $id['id']));

			//copy track by track
			if($stmt !== false){

				//media

				$wpdb->query("UPDATE {$tn} SET id=NULL, order_id=$order_id, playlist_id='$lastid'");//update playlist id
				$wpdb->query("INSERT INTO $media_table SELECT * FROM {$tn}");
				$last_media_insert_id = $wpdb->insert_id;//media_id
				$wpdb->query("DROP TABLE {$tn}");

				//copy taxonomy

				$wpdb->query($wpdb->prepare("CREATE TEMPORARY TABLE {$tn} SELECT * FROM $media_taxonomy_table WHERE media_id=%d", $id['id']));
				$wpdb->query("UPDATE {$tn} SET id=NULL, media_id='$last_media_insert_id', playlist_id='$playlist_id'");//update media id
				$wpdb->query("INSERT INTO $media_taxonomy_table SELECT * FROM {$tn}");
				$wpdb->query("DROP TABLE {$tn}");

				$order_id++;

			}
		}

		if($msg != null){//for copy, move tracks
			if($stmt !== false){

				if($msg == "playlist_id"){//redirect to newly created playlist
					echo json_encode($lastid);
				}else if($msg == "copy_media" || $msg == "make_playlist"){
					echo json_encode("SUCCESS");
				}
	    		
	    	}
	    	wp_die();
		}
	}

	function hap_copy_media(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['media_id']) && isset($_POST['destination_playlist_id'])){

			$media_id = $_POST['media_id'];
			$lastid = $_POST['destination_playlist_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $media_table = $wpdb->prefix . "map_media";

			$ids = explode(',',$media_id);

			$id_arr = array();
			foreach ($ids as $id) {
				$id_arr[] = array('id' => $id);
			}

	        hap_duplicatePlaylist(null, $lastid, $id_arr, "copy_media");

		}
	}

	function hap_move_media(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['media_id']) && isset($_POST['destination_playlist_id'])){

			$media_id = $_POST['media_id'];
			$destination_playlist_id = $_POST['destination_playlist_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $media_table = $wpdb->prefix . "map_media";

			$ids = explode(',',$media_id);
			$in = implode(',', array_fill(0, count($ids), '%d'));

			//only update playlist_id

			$stmt = $wpdb->query($wpdb->prepare("UPDATE {$media_table} SET playlist_id = $destination_playlist_id WHERE id IN ($in)", $ids));

			if($stmt !== false){
	    		echo json_encode($stmt);
	    	}

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_save_playlist_options(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['playlist_id'])){

			$playlist_id = $_POST['playlist_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $playlist_table = $wpdb->prefix . "map_playlists";
		    $playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";

		    $playlist_options = json_decode(stripcslashes($_POST['playlist_options']), true);

		    $stmt = $wpdb->update(
		    	$playlist_table,
				array('options' => serialize($playlist_options)), 
				array('id' => $playlist_id),
				array('%s'),
				array('%d')
		    );

		    //taxonomy

		    //delete current values
			$wpdb->query($wpdb->prepare("DELETE FROM {$playlist_taxonomy_table} WHERE playlist_id = %d", $playlist_id));

			if(!empty($_POST['playlist_category']) || !empty($_POST['playlist_tag'])){

				//category
				$values = array();
				$place_holders = array();

				if(isset($_POST['playlist_category'])){
					$category = explode(",",$_POST["playlist_category"]);
					$count = count($category);

					for($i = 0; $i < $count; $i++){ 
						array_push( $values, $category[$i], $playlist_id);
						$place_holders[] = "('%d', '%d')"; 
				    }
				}

			    //tag
				if(isset($_POST['playlist_tag'])){
					$tag = explode(",",$_POST["playlist_tag"]);
					$count = count($tag);

					for($i = 0; $i < $count; $i++){ 
						array_push( $values, $tag[$i], $playlist_id);
						$place_holders[] = "('%d', '%d')"; 
				    }
				}

				if(count($values)){
				    $query = "INSERT INTO $playlist_taxonomy_table (taxonomy_id, playlist_id) VALUES ";
					$query .= implode( ', ', $place_holders );

					$wpdb->query( $wpdb->prepare( "$query ", $values ) );
				}

			}

	    	echo json_encode('SUCCESS');

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_add_media(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['options']) && isset($_POST['playlist_id'])){

			$options = json_decode(stripcslashes($_POST['options']), true);
			$playlist_id = $_POST['playlist_id'];
			$save_type = $_POST['save_type'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $media_table = $wpdb->prefix . "map_media";
		    $media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";

		    $first_insert_happend = null;

		    if($save_type == 'add_media'){

		    	if(!empty($_POST['additional_playlist'])){
					$additional_playlist = explode(",", $_POST['additional_playlist']);
					$additional_playlist[] = $playlist_id;
				}else{
					$additional_playlist = array($playlist_id);
				}

				foreach ($additional_playlist as $playlist_to_insert) {

					$playlist_id = $playlist_to_insert;

					//get order
				    $stmt = $wpdb->get_row($wpdb->prepare("SELECT IFNULL(MAX(order_id)+1,0) AS order_id FROM {$media_table} WHERE playlist_id = %d", $playlist_id), ARRAY_A);
			        $order_id = $stmt['order_id'];

					$stmt = $wpdb->insert(
				    	$media_table,
						array( 
							'options' => serialize($options), 
							'playlist_id' => $playlist_id,
							'order_id' => $order_id
						), 
						array( 
							'%s','%d','%d'
						) 
				    );

				    if($stmt !== false){

				    	$insert_id = $wpdb->insert_id;

					    //taxonomy
						if(!empty($_POST['media_category']) || !empty($_POST['media_tag'])){

							//category
							$values = array();
							$place_holders = array();

							if(!empty($_POST['media_category'])){
								$category = explode(",",$_POST["media_category"]);
								$count = count($category);

								for($i = 0; $i < $count; $i++){ 
									array_push( $values, $category[$i], $insert_id, $playlist_id);
									$place_holders[] = "('%d', '%d', '%d')"; 
							    }
							}

						    //tag
							if(!empty($_POST['media_tag'])){
								$tag = explode(",",$_POST["media_tag"]);
								$count = count($tag);

								for($i = 0; $i < $count; $i++){ 
									array_push( $values, $tag[$i], $insert_id, $playlist_id);
									$place_holders[] = "('%d', '%d', '%d')"; 
							    }
							}

							if(count($values)){
							    $query = "INSERT INTO $media_taxonomy_table (taxonomy_id, media_id, playlist_id) VALUES ";
								$query .= implode( ', ', $place_holders );

								$wpdb->query( $wpdb->prepare( "$query ", $values ) );
							}

						}

				    }//if($stmt !== false){

				    if(!$first_insert_happend){
				    	 $first_insert_happend = true;

				    	 if($stmt !== false){
							$data = array('insert_id' => $insert_id,
							 			  'order_id' => $order_id);
				    		echo json_encode($data);
				    	}
				    }

				}//foreach ($additional_playlist as $playlist_to_insert) {

			}else{//edit media

				$media_id = $_POST['media_id'];

				$stmt = $wpdb->update(
			    	$media_table,
					array( 
						'options' => serialize($options), 
					), 
					array('id' => $media_id, 'playlist_id' => $playlist_id),
					array( 
						'%s'
					),
					array( 
						'%d','%d'
					) 
			    );

			    //taxonomy
				if(!empty($_POST['media_category']) || !empty($_POST['media_tag'])){

					//delete current values
					$wpdb->query($wpdb->prepare("DELETE FROM {$media_taxonomy_table} WHERE media_id = %d", $media_id));

					//category
					$values = array();
					$place_holders = array();

					if(!empty($_POST['media_category'])){
						$category = explode(",",$_POST["media_category"]);
						$count = count($category);

						for($i = 0; $i < $count; $i++){ 
							array_push( $values, $category[$i], $media_id, $playlist_id);
							$place_holders[] = "('%d', '%d', '%d')"; 
					    }
					}

				    //tag
					if(!empty($_POST['media_tag'])){
						$tag = explode(",",$_POST["media_tag"]);
						$count = count($tag);

						for($i = 0; $i < $count; $i++){ 
							array_push( $values, $tag[$i], $media_id, $playlist_id);
							$place_holders[] = "('%d', '%d', '%d')"; 
					    }
					}

					if(count($values)){
					    $query = "INSERT INTO $media_taxonomy_table (taxonomy_id, media_id, playlist_id) VALUES ";
						$query .= implode( ', ', $place_holders );

						$wpdb->query( $wpdb->prepare( "$query ", $values ) );
					}

				}

				if($stmt !== false){
		    		echo json_encode('SUCCESS');
		    	}

			}
			
	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_add_media_multiple(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['media']) && isset($_POST['playlist_id'])){

			$media = json_decode(stripcslashes($_POST['media']), true);
			$playlist_id = $_POST['playlist_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $media_table = $wpdb->prefix . "map_media";

		    $data = array();

		    $stmt = $wpdb->get_row($wpdb->prepare("SELECT IFNULL(MAX(order_id)+1,0) AS order_id FROM {$media_table} WHERE playlist_id = %d", $playlist_id), ARRAY_A);
			$order_id = intval($stmt['order_id']);

		    $len = count($media);
			for($i=0; $i < $len; $i++){ 

			    $options = $media[$i];

				$stmt = $wpdb->insert(
			    	$media_table,
					array( 
						'options' => serialize($options), 
						'playlist_id' => $playlist_id,
						'order_id' => $order_id
					), 
					array( 
						'%s','%d','%d'
					) 
			    );

			    $order_id++;

				$data[] = array('insert_id' => $wpdb->insert_id,
					 			'order_id' => $order_id,
					 			'options' => $options);

			}

			if($stmt !== false){
				echo json_encode($data);
			}
			
	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_save_peaks(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['media']) && isset($_POST['playlist_id'])){

			$media = json_decode(stripcslashes($_POST['media']), true);
			$playlist_id = $_POST['playlist_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $media_table = $wpdb->prefix . "map_media";

		    $len = count($media);
			for($i=0; $i < $len; $i++){ 

			    $media_id = $media[$i]['mediaId'];
			    $peaks = $media[$i]['peaks'];

			    $stmt = $wpdb->prepare("SELECT options FROM {$media_table} WHERE id = %d", $media_id);
			    $result = $wpdb->get_row($stmt, ARRAY_A);
			    $options = unserialize($result['options']);

			    $options['peaks'] = $peaks;

				$stmt = $wpdb->update(
			    	$media_table,
					array( 
						'options' => serialize($options), 
					), 
					array('id' => $media_id, 'playlist_id' => $playlist_id),
					array( 
						'%s'
					),
					array( 
						'%d','%d'
					) 
			    );

			}

			echo json_encode('');
			
	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_edit_media(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['media_id'])){

			$media_id = $_POST['media_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $media_table = $wpdb->prefix . "map_media";
		    $taxonomy_table = $wpdb->prefix . "map_taxonomy";
		    $media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";

		    $stmt = $wpdb->prepare("SELECT options FROM {$media_table} WHERE id = %d", $media_id);
		    $result = $wpdb->get_row($stmt, ARRAY_A);
		    $data = unserialize($result['options']);

		    //tax
		    $stmt = $wpdb->prepare("SELECT tt.id, tt.type, tt.title
		    FROM $taxonomy_table as tt
		    LEFT JOIN $media_taxonomy_table mtt on mtt.taxonomy_id = tt.id 
		    WHERE media_id = %d ORDER BY tt.title ASC", $media_id);

		    $media_taxonomy = $wpdb->get_results($stmt, ARRAY_A);

			if($stmt !== false){
	    		$arr = array(
					"data" => $data,
					"tax" => $media_taxonomy
	    		);
	    		echo json_encode($arr);
	    	}

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_get_media(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['playlist_id'])){

			$playlist_id = $_POST['playlist_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $media_table = $wpdb->prefix . "map_media";

		    //media
		    $stmt = $wpdb->prepare("SELECT id, options FROM $media_table WHERE playlist_id = %d", $playlist_id);
			
			if($stmt !== false){
				$medias = $wpdb->get_results($stmt, ARRAY_A);

				$arr = array();

				foreach($medias as $media){
					$media_options = unserialize($media['options']);
					$arr[] = array(
						"id" => $media['id'],
						"options" => $media_options
		    		);
				}

	    		echo json_encode($arr);
	    	}

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}





	//############################################//
	/* ads */
	//############################################//

	function hap_save_ad_options(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['ad_id'])){

			$ad_id = $_POST['ad_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $ad_table = $wpdb->prefix . "map_ad";

		    $options = json_decode(stripcslashes($_POST['options']), true);

		    $stmt = $wpdb->update(
		    	$ad_table,
				array('options' => serialize($options)), 
				array('id' => $ad_id),
				array('%s'),
				array('%d')
		    );

	    	echo json_encode('SUCCESS');

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_edit_ad_title(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title']) && isset($_POST['id'])){

			$title = stripcslashes($_POST["title"]);
			$id = $_POST["id"];

			global $wpdb;
		    $ad_table = $wpdb->prefix . "map_ad";

		    $wpdb->update(
		    	$ad_table,
				array( 
					'title' => $title
				), 
				array('id' => $id),
				array( 
					'%s'
				),
				array( 
					'%d'
				) 
		    );

		    echo json_encode('');

		    wp_die();

		}else{
			wp_die();
		}
	}

	function hap_delete_ad(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['ad_id'])){

			$ad_id = $_POST['ad_id'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $ad_table = $wpdb->prefix . "map_ad";

			$ids = explode(',',$ad_id);
			$in = implode(',', array_fill(0, count($ids), '%d'));

		    $stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$ad_table} WHERE id IN ($in)", $ids));

			if($stmt !== false){
	    		echo json_encode($stmt);
	    	}

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_duplicate_ad(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['ad_id'])){

			$ad_id = $_POST['ad_id'];
			$title = $_POST['title'];

			global $wpdb;
			$wpdb->show_errors(); 
		    $ad_table = $wpdb->prefix . "map_ad";

			$stmt = $wpdb->prepare("SELECT options FROM {$ad_table} WHERE id = %d", $ad_id);

			if($stmt !== false){

				$result = $wpdb->get_row($stmt, ARRAY_A);

			    $stmt = $wpdb->insert(//copy ad
			    	$ad_table,
					array( 
						'title' => $title,
						'options' => $result['options']
					), 
					array( 
						'%s',
						'%s'
					) 
			    );

			    if($stmt !== false){
		    		echo json_encode($wpdb->insert_id);
		    	}

			}

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_create_ad(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title'])){

			$title = stripslashes($_POST['title']);

			global $wpdb;
			$wpdb->show_errors(); 
		    $ad_table = $wpdb->prefix . "map_ad";

			$stmt = $wpdb->insert(
		    	$ad_table,
				array( 
					'title' => $title
				), 
				array( 
					'%s'					
				) 
		    );
		 
		    if($stmt !== false){
	    		echo json_encode($wpdb->insert_id);
			}

	    	wp_die();
	    	
		}else{
			wp_die();
		}

	}


	//############################################//
	/* create playlist from frontend */
	//############################################//

	function hap_make_playlist(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(!isset($_POST['playlist_create_format']) || !isset($_POST['media']) || !isset($_POST['title'])){
			wp_die("hap_make_playlist data missing!");
		}

		if($_POST['playlist_create_format'] == 'single'){

			$title = $_POST['title'];

			global $wpdb;
		    $playlist_table = $wpdb->prefix . "map_playlists";

		    $stmt = $wpdb->insert(
		    	$playlist_table,
				array( 
					'title' => $title
				), 
				array( 
					'%s'				
				) 
		    );

		    $media = json_decode(stripcslashes($_POST['media']), true);
		    $ids = array();
			foreach($media as $id){
	            $ids[] = array("id" => $id);
	        }  

			$lastid = $wpdb->insert_id;//playlist_id
			
			hap_duplicatePlaylist(null, $lastid, $ids, "make_playlist");

		}else{//if we have media from grouped sources

			$title = $_POST['title'];

			global $wpdb;
		    $playlist_table = $wpdb->prefix . "map_playlists";

		    $stmt = $wpdb->insert(
		    	$playlist_table,
				array( 
					'title' => $title
				), 
				array( 
					'%s'				
				) 
		    );

		    $lastid = $wpdb->insert_id;//playlist_id

		    $media = json_decode(stripcslashes($_POST['media']), true);

		    $media_table = $wpdb->prefix . "map_media";
		    $taxonomy_table = $wpdb->prefix . "map_taxonomy";
		    $media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";

		    //media options

			foreach($media as $options){

				$media_id = $options['mediaId'];//for taxonomy

				foreach($options as $key => $value){//uppercase to underscore for some options
					if(preg_match('/[A-Z]/', $key)){
						$newkey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key));
						$options[$newkey] = $options[$key];
						unset($options[$key]);
					}
				}

			    $stmt = $wpdb->insert(
			    	$media_table,
					array( 
						'options' => serialize($options), 
						'playlist_id' => $lastid
					), 
					array( 
						'%s','%d'
					) 
			    );

  				//get taxonomy

			    $insert_id = $wpdb->insert_id;

			    $results = $wpdb->get_results($wpdb->prepare("SELECT DISTINCT title, type
							FROM $media_taxonomy_table
							WHERE media_id =%d
							ORDER BY type", $media_id), ARRAY_A);

			    if($wpdb->num_rows > 0){
			    	foreach ($results as $r) { 
		
					    $stmt = $wpdb->insert(
					    	$media_taxonomy_table,
							array( 
								'type' => $r['type'],
								'title' => $r['title'],
								'media_id' => $insert_id,
							), 
							array( 
								'%s','%s','%d'						
							) 
					    );
				    }
		        }  

		    }

		    wp_die();

		}
	}
	
	function hap_playlist_create($atts){

		if(!isset($atts['player_id']))return "Player ID missing in hap_playlist_create!";

		$player_id = $atts['player_id'];

		$playlist_create_format = isset($atts['playlist_create_format']) ? $atts['playlist_create_format'] : 'single';
		$header = isset($atts['header']) ? $atts['header'] : 'Create playlist from set of tracks';
		$btn_text = isset($atts['btn_text']) ? $atts['btn_text'] : 'Go';
		$input_placeholder = isset($atts['input_placeholder']) ? $atts['input_placeholder'] : 'Enter playlist title..';
		$playlist_required_msg = isset($atts['playlist_required_msg']) ? $atts['playlist_required_msg'] : 'Playlist title is required!';
		$loader_text = isset($atts['loader_text']) ? $atts['loader_text'] : 'Working! Please wait..';

		$btn_id = 'hap-playlist-create-btn-'.mt_rand();

		$markup = '<div class="hap-playlist-create-wrap">
			<p class="hap-playlist-create-header">'.esc_html($header).'</p>
			<input type="text" class="hap-playlist-create-title" placeholder="'.esc_attr($input_placeholder).'">
	  		<button type="button" class="hap-playlist-create-btn" id="'.$btn_id.'">'.esc_html($btn_text).'</button>
  		</div>';

  		$markup .= '<script type="text/javascript">
  			var playlist_create_working;
			var elem = document.getElementById("'.$btn_id.'").addEventListener("click", function(e){ 
		    	e.preventDefault();

		    	if(!window.jQuery){
		    		console.log("No jQuery!");
		    		return false;
		    	}

		    	if(playlist_create_working)return false;
		    	playlist_create_working = true;

		    	//playlist title
		    	var parent = this.parentNode,
		    	input = parent.querySelector(".hap-playlist-create-title"),
		    	title = input.value;
		    	if (title == "") {
		    		input.focus();
    				alert("'.$playlist_required_msg.'");
				    return false;
				}

				input.value = "";//clear input

				//create loader
				var loader = jQuery("<div class=\'hap-fontend-loader\'>'.esc_html($loader_text).'</div>");
				jQuery("body").append(loader);

				//get player data
		    	var pd = window.hap_player'.$player_id.'.getPlaylistData(); 

		    	var i, len = pd.length, arr = [];
		    	for(i=0;i<len;i++){
		    		if("'.$playlist_create_format.'" == "single")arr.push(pd[i].data.mediaId);
		    		else arr.push(pd[i].data);
		    	}
		    	console.log(arr)

	    		var postData = [
			        {name: "action", value: "hap_make_playlist"},
			        {name: "playlist_create_format", value: "'.$playlist_create_format.'"},
			        {name: "media", value: JSON.stringify(arr)},
			        {name: "title", value: title},
			        {name: "security", value: "'.wp_create_nonce( "hap-security-nonce" ).'"}
			    ];

			    jQuery.ajax({
			        url: "'.admin_url( 'admin-ajax.php').'",
			        type: "post",
			        data: postData,
			        dataType: "json"
			    }).done(function(response){
		            console.log(response)
		            if(response == "SUCCESS"){
		            	
		            }
		            loader.remove();
		            playlist_create_working = false;
		            
		        }).fail(function(jqXHR, textStatus, errorThrown) {
			        console.log("Error hap_playlist_create: " + jqXHR.responseText, textStatus, errorThrown);
			        loader.remove();
			        playlist_create_working = false;
			    }); 

			}, false);
		</script>';

  		return $markup;

	}


	//############################################//
	/* playlist display */
	//############################################//

	function hap_playlist_display($atts){

		global $wpdb;
        $playlist_table = $wpdb->prefix . "map_playlists";
        $data = array();

		if(isset($atts['playlist_category'])){

			$playlist_id = hap_getPlaylistFromCategory($atts);
			if(count($playlist_id) == 0)return "No playlists found!";

		}else if(isset($atts['playlist_id'])){

			$playlist_id = explode(',', $atts['playlist_id']);

		}else{
			return '';
		}

		$in = implode(',', array_fill(0, count($playlist_id), '%d'));

		$playlist_id = array_merge($playlist_id,$playlist_id);

		$results = $wpdb->get_results($wpdb->prepare("SELECT id, title, options FROM {$playlist_table} WHERE id IN ($in) ORDER BY FIELD(id, $in)", $playlist_id), ARRAY_A);

		foreach($results as $result){

			$pl_options = unserialize($result['options']);

			$data[] = array('id' => $result['id'], 
							'title' => $result['title'],
							'description' => $pl_options['description'],
							'thumb' => $pl_options['thumb']);

		}

		$id = 'hap-playlist-display-wrap-'.mt_rand();//to limit selector for click

	  	$markup = '<div class="hap-playlist-display-wrap" id="'.$id.'">';

			if(!empty($atts['header_title'])){
				$markup .= '<div class="hap-playlist-display-header">
					<span>'.esc_html($atts['header_title']).'</span>
				</div>';
			}

			$markup .= '<div class="hap-playlist-display-wrap-inner">';

			foreach($data as $d){

				if(isset($atts['active_playlist']) && $atts['active_playlist'] == $d['id'])$active_class = ' hap-playlist-display-item-active';
				else $active_class = '';

				$markup .= '<div class="hap-playlist-display-item'.$active_class.'" data-playlist-id="'.esc_attr($d['id']).'" title="'.esc_attr($d['title']).'">';

				if(isset($d['thumb'])){

					$markup .= '<div class="hap-playlist-display-item-inner">';
				
					$markup .= '<img class="hap-playlist-display-item-thumb" src="'.esc_attr($d['thumb']).'" alt="'.esc_attr($d['title']).'"/>';

					$markup .= '<div class="hap-playlist-display-item-playing">Playing</div>';

					$markup .= '</div>';//hap-playlist-display-item-inner
				}

				$markup .= '<div class="hap-playlist-display-item-title">'.esc_html($d['title']).'</div>';

				if(isset($d['description'])){
					$markup .= '<div class="hap-playlist-display-item-description">'.$d['description'].'</div>';
				}

				$markup .= '</div>';//hap-playlist-display-item
			
			}
			$markup .= '</div>

		</div>';//hap-playlist-display-wrap

		if(isset($atts['connected_player_id'])){

			$player_id = $atts['connected_player_id'];

    		//click to load playlist in player 
    		$markup .= '<script type="text/javascript">
				var elem = document.getElementById("'.$id.'"),
				items = elem.querySelectorAll(".hap-playlist-display-item"), i, len = items.length;
				for (i = 0; i < len; i++) {
				    items[i].addEventListener("click", function(e){ 
				    	e.preventDefault();

				    	if(this.classList.contains("hap-playlist-display-item-active"))return false;//active item
				    	var last_active = elem.getElementsByClassName("hap-playlist-display-item-active");
				    	if(last_active.length)last_active[0].classList.remove("hap-playlist-display-item-active");
				    	this.classList.add("hap-playlist-display-item-active");

				    	var pid = ".hap-playlist-"+this.getAttribute("data-playlist-id");
				    	hap_player'.$player_id.'.loadPlaylist(pid); return false;  
					}, false);
				}
			</script>';   

		}

		return $markup;
		
	}

	function hap_getPlaylistFromCategory($atts){

		global $wpdb;
		$taxonomy_table = $wpdb->prefix . "map_taxonomy";
        $playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";

		//match
        $match = 'any';
        if(isset($atts['match']))$match = $atts['match'];
        $allowed_match = array("any", "all");
        if(!in_array($match, $allowed_match))$match = 'any';//escape

        //category
        $sanitize = preg_replace( '/\s*,\s*/', ',', filter_var( $atts['playlist_category'], FILTER_SANITIZE_STRING ) ); 
        $atts_category = explode( ',', $sanitize );
        $count_category = count($atts_category);
        $args_category = implode(',', array_fill(0, $count_category, '%s'));//placeholders

		if($match == 'all'){//all

            $query = "SELECT ptt.playlist_id 
            FROM $playlist_taxonomy_table as ptt
            LEFT JOIN $taxonomy_table tt on tt.id = ptt.taxonomy_id 
            WHERE tt.type='category' AND tt.title IN ($args_category)
            GROUP BY ptt.playlist_id
            HAVING count(DISTINCT tt.title) = $count_category";

        }else{//any

            $query = "SELECT DISTINCT ptt.playlist_id 
            FROM $playlist_taxonomy_table as ptt
            LEFT JOIN $taxonomy_table tt on tt.id = ptt.taxonomy_id 
            WHERE tt.type='category' AND tt.title IN ($args_category)";

        }

        $results = $wpdb->get_results($wpdb->prepare($query, $atts_category), ARRAY_A);

        $playlist_id = array();
        if($wpdb->num_rows > 0){
	    	foreach ($results as $r) { 
	    		$playlist_id[] = $r['playlist_id'];
	    	}
	    }

        return $playlist_id;

    }

	function hap_getPlaylistTaxonomy($atts){

		if(isset($atts['playlist_id'])){
			$playlist_id = explode(',', $atts['playlist_id']);
		}else{
			return '';
		}

		$in = implode(',', array_fill(0, count($playlist_id), '%d'));

		global $wpdb;
		$taxonomy_table = $wpdb->prefix . "map_taxonomy";
	    $playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";

	    $playlist_tag = array();
		$playlist_category = array();

		//choose what to display
		if(isset($atts['taxonomy']))$taxonomy = $atts['taxonomy'];
		else $taxonomy = 'category,tag';


		if(strpos($taxonomy, 'category') !== false && strpos($taxonomy, 'tag') !== false){

		    $stmt = $wpdb->prepare("SELECT DISTINCT tt.type, tt.title
		    FROM $taxonomy_table as tt
		    LEFT JOIN $playlist_taxonomy_table ptt on ptt.taxonomy_id = tt.id 
		    WHERE playlist_id IN ($in) 
		    ORDER BY tt.title ASC", $playlist_id);

			$results = $wpdb->get_results($stmt, ARRAY_A);

		    if($wpdb->num_rows > 0){
		        foreach($results as $tax){//divide
		            if($tax['type'] == 'tag')$playlist_tag[] = $tax['title'];
		            else $playlist_category[] = $tax['title'];
		        }
		    }

	    }else if(strpos($taxonomy, 'category') !== false){

	    	$stmt = $wpdb->prepare("SELECT DISTINCT tt.type, tt.title
		    FROM $taxonomy_table as tt
		    LEFT JOIN $playlist_taxonomy_table ptt on ptt.taxonomy_id = tt.id 
		    WHERE tt.type='category' AND playlist_id IN ($in) 
		    ORDER BY tt.title ASC", $playlist_id);

	    	$results = $wpdb->get_results($stmt, ARRAY_A);

		    if($wpdb->num_rows > 0){
		        foreach($results as $tax){
		            $playlist_category[] = $tax['title'];
		        }
		    }

	    }else if(strpos($taxonomy, 'tag') !== false){

	    	$stmt = $wpdb->prepare("SELECT DISTINCT tt.type, tt.title
		    FROM $taxonomy_table as tt
		    LEFT JOIN $playlist_taxonomy_table ptt on ptt.taxonomy_id = tt.id 
		    WHERE tt.type='tag' AND playlist_id IN ($in) 
		    ORDER BY tt.title ASC", $playlist_id);

	    	$results = $wpdb->get_results($stmt, ARRAY_A);

		    if($wpdb->num_rows > 0){
		        foreach($results as $tax){
		            $playlist_tag[] = $tax['title'];
		        }
		    }

	    }

	    $category_title = isset($atts['category_title']) ? $atts['category_title'] : "";
	    $tag_title = isset($atts['tag_title']) ? $atts['tag_title'] : "";

	    $markup = '<div class="hap-tax-display-wrap"';

	    	if(isset($atts['instance_id'])){
		    	$markup .= ' data-player-id="'.$atts['instance_id'].'"';
		    }else if(isset($atts['player_id'])){
		    	$markup .= ' data-player-id="'.$atts['player_id'].'"';
		    }else{
		    	$markup .= ' data-player-id="0"';
		    }

		    if(isset($atts['allow_category_multi_select'])){
		    	$markup .= ' data-allow-category-multi-select="'.$atts['allow_category_multi_select'].'"';
		    }
		    if(isset($atts['category_show_multi_only'])){
		    	$markup .= ' data-category-show-multi-only="'.$atts['category_show_multi_only'].'"';
		    }

			$markup .= '>';

			if(count($playlist_category)){

				$markup .= '<div class="hap-tax-display-category-wrap">';
				if(!empty($category_title))$markup .= '<div class="hap-tax-display-title">'.esc_html($category_title).'</div>';

				//show all
				if(isset($atts['category_show_all'])){
					$all = $atts['category_show_all'];
			    	$markup .= '<div class="hap-category-item hap-category-item-selected" title="'.esc_attr($all).'" data-value="all">'.esc_html(strtoupper($all)).'</div>';
			    }

				foreach($playlist_category as $c){
					$markup .= '<div class="hap-category-item" title="'.esc_attr($c).'" data-value="'.esc_attr($c).'">'.esc_html(strtoupper($c)).'</div>';
				}

				$markup .= '</div>';

			}

			if(count($playlist_tag)){

				$markup .= '<div class="hap-tax-display-tag-wrap">';
				if(!empty($tag_title))$markup .= '<div class="hap-tax-display-title">'.esc_html($tag_title).'</div>';

				//show all
				if(isset($atts['tag_show_all'])){
					$all = $atts['tag_show_all'];
			    	$markup .= '<div class="hap-tag-item hap-tag-item-selected" title="'.esc_attr($all).'" data-value="all">'.esc_html(strtoupper($all)).'</div>';
			    }

				foreach($playlist_tag as $c){
					$markup .= '<div class="hap-tag-item" title="'.esc_attr($c).'" data-value="'.esc_attr($c).'">'.esc_html(strtoupper($c)).'</div>';
				}

				$markup .= '</div>';

			}

		$markup .= '</div>';//hap-tax-display-wrap

		wp_enqueue_script('hap-taxonomy', plugins_url('/source/js/taxonomy.js', __FILE__), array('jquery'));
		
		return $markup;
		
	}

	
	//############################################//
	/* add / edit taxonomy */
	//############################################//

	function hap_add_taxonomy(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title']) && isset($_POST['type'])){

			$type = $_POST["type"];
			$title = wp_kses_stripslashes($_POST["title"]);
			$description = isset($_POST["description"]) ? wp_kses_stripslashes($_POST["description"]) : null;

			global $wpdb;
		    $taxonomy_table = $wpdb->prefix . "map_taxonomy";

		    $stmt = $wpdb->insert(
		    	$taxonomy_table,
				array( 
					'type' => $type,
					'title' => $title,
					'description' => $description
				), 
				array( 
					'%s','%s','%s'						
				) 
		    );

		    if($stmt !== false){
		    	$lastid = $wpdb->insert_id;
	    		echo json_encode($lastid);
	    	}

		    wp_die();

		}else{
			wp_die();
		}
	}

	function hap_edit_taxonomy(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['title']) && isset($_POST['taxonomy_id'])){

			$taxonomy_id = $_POST["taxonomy_id"];
			$title = wp_kses_stripslashes($_POST["title"]);
			$description = isset($_POST["description"]) ? wp_kses_stripslashes($_POST["description"]) : null;

			global $wpdb;
		    $taxonomy_table = $wpdb->prefix . "map_taxonomy";

		    $stmt = $wpdb->update(
		    	$taxonomy_table,
				array( 
					'title' => $title,
					'description' => $description
				), 
				array('id' => $taxonomy_id),
				array( 
					'%s','%s'
				),
				array( 
					'%d'
				) 
		    );

		    if($stmt !== false){
	    		echo json_encode('');
	    	}

		    wp_die();

		}else{
			wp_die();
		}
	}

	function hap_delete_taxonomy(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['taxonomy_id'])){

			$taxonomy_id = $_POST["taxonomy_id"];

			global $wpdb;
		    $taxonomy_table = $wpdb->prefix . "map_taxonomy";

		    $stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$taxonomy_table} WHERE id=%d", $taxonomy_id));

		    if($stmt !== false){
	    		echo json_encode('');
	    	}

		    wp_die();

		}else{
			wp_die();
		}
	}

	

	//############################################//
	/* get all shortocde atts */
	//############################################//

	function hap_get_shortcode_atts(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['player_id'])){

			$player_id = $_POST['player_id'];
		    
			global $wpdb;
			$wpdb->show_errors(); 
		    $player_table = $wpdb->prefix . "map_players";
			$stmt = $wpdb->prepare("SELECT preset, options FROM {$player_table} WHERE id = %d", $player_id);
			$result = $wpdb->get_row($stmt, ARRAY_A);

			$default_options = hap_player_options();
			$player_options = unserialize($result['options']);
	        $preset = $result["preset"];

	        $options = $player_options + $default_options + hap_player_options_preset($preset);

			if($stmt !== false){
	    		echo json_encode($options);
	    	}

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	//############################################//
	/* load more */
	//############################################//

	function hap_add_more(){

		if(isset($_POST['playlist_id'])){

			$playlist_id = (int)$_POST['playlist_id'];
			$offset = (int)$_POST['addMoreOffset'];
			$limit = (int)$_POST['addMoreLimit'];
			$sortOrder = $_POST['addMoreSortOrder'];
			$sortDirection = $_POST['addMoreSortDirection'];
			$encryptMediaPaths = $_POST['encryptMediaPaths'];
			$taxonomy = $_POST['taxonomy'];
			$category = $_POST['category'];
			$tag = $_POST['tag'];
			$match = $_POST['match'];
	    

			if($taxonomy){
                $medias = hap_getMediaWithTaxonomy($taxonomy, $sortOrder, $sortDirection, $playlist_id, $offset, $limit);
            }
            else if($category || $tag){
                $medias = hap_filterMediaWithTaxonomy($category, $tag, $match, $sortOrder, $sortDirection, $playlist_id, $offset, $limit);
            }
            else{

            	global $wpdb;
			    $wpdb->show_errors(); 
				$media_table = $wpdb->prefix . "map_media";

				$stmt = $wpdb->prepare("SELECT id, options FROM {$media_table} WHERE playlist_id = %d ORDER BY $sortOrder $sortDirection LIMIT $offset, $limit", $playlist_id);
				$medias = $wpdb->get_results($stmt, ARRAY_A);

			}

	    	$markup = array();

	    	foreach($medias as $m) {
	    		$media = unserialize($m['options']);
	    		$media['mediaId'] = $m["id"]; 
                $markup[] = hap_get_media_fields2($media, $encryptMediaPaths);
            }

			echo json_encode($markup);

			wp_die();

		}else{
			wp_die();
		}
	}

	function hap_paginate(){

		if(isset($_POST['playlist_id'])){

			$playlist_id = $_POST['playlist_id'];
			$offset = $_POST['addMoreOffset'];
			$limit = $_POST['addMoreLimit'];
			$sortOrder = $_POST['addMoreSortOrder'];
			$sortDirection = $_POST['addMoreSortDirection'];
			$encryptMediaPaths = $_POST['encryptMediaPaths'];
			$taxonomy = $_POST['taxonomy'];
			$category = $_POST['category'];
			$tag = $_POST['tag'];
			$match = $_POST['match'];


			if($taxonomy){
                $medias = hap_getMediaWithTaxonomy($taxonomy, $sortOrder, $sortDirection, $playlist_id, $offset, $limit);
            }
            else if($category || $tag){
                $medias = hap_filterMediaWithTaxonomy($category, $tag, $match, $sortOrder, $sortDirection, $playlist_id, $offset, $limit);
            }
            else{

            	global $wpdb;
			    $wpdb->show_errors(); 
				$media_table = $wpdb->prefix . "map_media";

				$stmt = $wpdb->prepare("SELECT id, options FROM {$media_table} WHERE playlist_id = %d ORDER BY $sortOrder $sortDirection LIMIT $offset, $limit", $playlist_id);
				$medias = $wpdb->get_results($stmt, ARRAY_A);
			
			}

	    	$markup = array();

	    	foreach($medias as $m) {
	    		$media = unserialize($m['options']);
            	$media['mediaId'] = $m["id"]; 
                $markup[] = hap_get_media_fields2($media, $encryptMediaPaths);
            }

			echo json_encode($markup);

			wp_die();

		}else{
			wp_die();
		}
	}

	//get all media with taxonomy
	function hap_getMediaWithTaxonomy($taxonomy, $sortOrder, $sortDirection, $playlist_id, $offset = null, $limit = null){

	    global $wpdb;
	    $media_table = $wpdb->prefix . "map_media";
	    $taxonomy_table = $wpdb->prefix . "map_taxonomy";
	    $media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";

	    if(strpos($taxonomy, 'category') !== false && strpos($taxonomy, 'tag') !== false){
	  
	        $sql = "SELECT mt.id, mt.options, 
	        GROUP_CONCAT(CASE WHEN tt.type = 'category' THEN tt.title END ORDER BY tt.title SEPARATOR ',') as category,
	        GROUP_CONCAT(CASE WHEN tt.type = 'tag'      THEN tt.title END ORDER BY tt.title SEPARATOR ',') as tag
	        FROM $media_table as mt
	        LEFT JOIN $media_taxonomy_table mtt on mt.id = mtt.media_id 
			LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
			WHERE mt.playlist_id = %d 
	        GROUP BY mt.id
	        ORDER BY $sortOrder $sortDirection";

	    }else if(strpos($taxonomy, 'category') !== false){

	        $sql = "SELECT mt.id, mt.options, 
	        GROUP_CONCAT(CASE WHEN tt.type = 'category' THEN tt.title END ORDER BY tt.title SEPARATOR ',') as category
	        FROM $media_table as mt
	        LEFT JOIN $media_taxonomy_table mtt on mt.id = mtt.media_id 
			LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
			WHERE mt.playlist_id = %d 
	        GROUP BY mt.id
	        ORDER BY $sortOrder $sortDirection";

	    }else if(strpos($taxonomy, 'tag') !== false){

	        $sql = "SELECT mt.id, mt.options, 
	        GROUP_CONCAT(CASE WHEN tt.type = 'tag'      THEN tt.title END ORDER BY tt.title SEPARATOR ',') as tag
	        FROM $media_table as mt
	        LEFT JOIN $media_taxonomy_table mtt on mt.id = mtt.media_id 
			LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
			WHERE mt.playlist_id = %d 
	        GROUP BY mt.id
	        ORDER BY $sortOrder $sortDirection";

	    }

	    if(isset($offset) && isset($limit)) $sql .= " LIMIT $offset, $limit";
	    else if(isset($limit)) $sql .= " LIMIT $limit";

	    $stmt = $wpdb->get_results($wpdb->prepare($sql, $playlist_id), ARRAY_A);

	    return $stmt;

	}


	function hap_filterMediaWithTaxonomy_numResults($category = null, $tag = null, $match = null, $playlist_id = null){

		global $wpdb;
		$taxonomy_table = $wpdb->prefix . "map_taxonomy";
	    $media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
	    $media_table = $wpdb->prefix . "map_media";

	    if(isset($category) && isset($tag)){
	        	
	        $category = explode(',',$category);
	        $countTitles = count($category);
	        $arg = implode(',', array_fill(0, count($category), '%s'));   

	        $tag = explode(',',$tag);
	        $countTitles2 = count($tag);
	        $arg2 = implode(',', array_fill(0, count($tag), '%s'));

	        $tax = array_merge($category, $tag);

	        //match any or all 
	        if($match == 'all'){

	        	$tax[] = $playlist_id;

	        	$total = intval($countTitles+$countTitles2);

		        $sql = "SELECT COUNT(mt.id)
		        FROM $media_table as mt
		        WHERE id IN (
		            SELECT mtt.media_id
		            FROM $media_taxonomy_tableas mtt
		            LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
		            WHERE (( tt.type='category' AND tt.title IN ($arg) OR 
		                ( tt.type='tag' AND tt.title IN ($arg2)))
		            )
		            GROUP BY mtt.media_id
		            HAVING count(DISTINCT tt.title) = $countTitles
		        )
		        AND mt.playlist_id = %d";

	          	$stmt = $wpdb->get_var($wpdb->prepare($sql, $tax));

	        }
	        else{//any

	            $tax[] = $playlist_id;

		        $sql = "SELECT COUNT(mt.id)
		        FROM $media_table as mt
		        WHERE id IN (
		            SELECT mtt.media_id FROM $media_taxonomy_table as mtt
	                LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	                WHERE tt.type='category' AND tt.title IN ($arg) OR 
	                tt.type='tag' AND tt.title IN ($arg2) 
		        )
		        AND mt.playlist_id = %d";

		        $stmt = $wpdb->get_var($wpdb->prepare($sql, $tax));

	        }

	    }else if(isset($category)){

	        $category = explode(',',$category);
	        $countTitles = count($category);
	        $arg = implode(',', array_fill(0, count($category), '%s'));

	        //match any or all 
	        if($match == 'all'){

	            $category[] = $playlist_id;

		        $sql = "SELECT COUNT(mt.id)
		        FROM $media_table as mt
		        WHERE id IN (
		            SELECT mtt.media_id
		            FROM $media_taxonomy_tableas mtt
		            LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
		            WHERE tt.type='category' AND tt.title IN ($arg)
		            GROUP BY mtt.media_id
		            HAVING count(DISTINCT tt.title) = $countTitles
		        )
		        AND mt.playlist_id = %d";

	          	$stmt = $wpdb->get_var($wpdb->prepare($sql, $category));

	        }
	        else{//any

		        $category[] = $playlist_id;

		        $sql = "SELECT COUNT(mt.id)
		        FROM $media_table as mt
		        WHERE id IN (
		            SELECT mtt.media_id FROM $media_taxonomy_table as mtt
	                LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	                WHERE tt.type='category' AND tt.title IN ($arg)
		        )
		        AND mt.playlist_id = %d";

		        $stmt = $wpdb->get_var($wpdb->prepare($sql, $category));

	    	}

	    }else if(isset($tag)){

	        $tag = explode(',',$tag);
	        $countTitles = count($tag);
	        $arg = implode(',', array_fill(0, count($tag), '%s'));

	        //match any or all 
	        if($match == 'all'){

	        	$tag[] = $playlist_id;

	            $sql = "SELECT COUNT(mt.id)
		        FROM $media_table as mt
		        WHERE id IN (
		            SELECT mtt.media_id
		            FROM $media_taxonomy_tableas mtt
		            LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
		            WHERE tt.type='tag' AND tt.title IN ($arg)
		            GROUP BY mtt.media_id
		            HAVING count(DISTINCT tt.title) = $countTitles
		        )
		        AND mt.playlist_id = %d";

	          	$stmt = $wpdb->get_var($wpdb->prepare($sql, $tag));

	        }
	        else{//any

	            $tag[] = $playlist_id;

		        $sql = "SELECT COUNT(mt.id)
		        FROM $media_table as mt
		        WHERE id IN (
		            SELECT mtt.media_id FROM $media_taxonomy_table as mtt
	                LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	                WHERE tt.type='tag' AND tt.title IN ($arg)
		        )
		        AND mt.playlist_id = %d";

		        $stmt = $wpdb->get_var($wpdb->prepare($sql, $tag));

	        }

	    }

	    return $stmt;

	}

	//get media with specific taxonomy
	function hap_filterMediaWithTaxonomy($category = null, $tag = null, $match = null, $sortOrder = null, $sortDirection = null, $playlist_id = null, $offset = null, $limit = null){

	    global $wpdb;
	    $taxonomy_table = $wpdb->prefix . "map_taxonomy";
	    $media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
	    $media_table = $wpdb->prefix . "map_media";

	    if(isset($category) && isset($tag)){
	        
	        $category = explode(',',$category);
	        $countTitles = count($category);
	        $arg = implode(',', array_fill(0, count($category), '%s'));   

	        $tag = explode(',',$tag);
	        $countTitles2 = count($tag);
	        $arg2 = implode(',', array_fill(0, count($tag), '%s'));

	        $tax = array_merge($category, $tag);

	        //match any or all 
	        if($match == 'all'){

	            //get media ids 

	            $total = intval($countTitles+$countTitles2);

	            $sql = "SELECT mtt.media_id
	            FROM $media_taxonomy_table as mtt
	            LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	            WHERE (( tt.type='category' AND tt.title IN ($arg) OR 
	                ( tt.type='tag' AND tt.title IN ($arg2)))
	            )
	            GROUP BY mtt.media_id
	            HAVING count(DISTINCT tt.title) = $total";


	            if(isset($offset) && isset($limit)) $sql .= " LIMIT $offset, $limit";
	            else if(isset($limit)) $sql .= " LIMIT $limit";

	            $stmt = $wpdb->get_results($wpdb->prepare($sql, $tax), ARRAY_A);

	            if($wpdb->num_rows > 0){

	                foreach ($stmt as $key) {
	                    $ids[] = $key['media_id'];
	                }
	                $ids[] = $playlist_id;

	                //get media

	                $in = implode(',', array_fill(0, count($stmt), '%d'));

	                $query = "SELECT id, options FROM $media_table WHERE id IN ($in) AND playlist_id=%d ORDER BY $sortOrder $sortDirection";

	                $stmt = $wpdb->get_results($wpdb->prepare($query, $ids), ARRAY_A);

	            }

	        }
	        else{//any

	            $tax[] = $playlist_id;
	            
	            $sql = "SELECT mt.id, mt.options
	            FROM $media_table as mt
	            WHERE id IN (
	                SELECT mtt.media_id FROM $media_taxonomy_table as mtt
	                LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	                WHERE tt.type='category' AND tt.title IN ($arg) OR 
	                tt.type='tag' AND tt.title IN ($arg2)
	            )
	            AND mt.playlist_id = %d 
	            ORDER BY $sortOrder $sortDirection";

	            if(isset($offset) && isset($limit)) $sql .= " LIMIT $offset, $limit";
	            else if(isset($limit)) $sql .= " LIMIT $limit";

	            $stmt = $wpdb->get_results($wpdb->prepare($sql, $tax), ARRAY_A);

	        }

	    }else if(isset($category)){

	        $category = explode(',',$category);
	        $countTitles = count($category);
	        $arg = implode(',', array_fill(0, count($category), '%s'));

	        //match any or all 
	        if($match == 'all'){

	            //get media ids

	            $sql = "SELECT mtt.media_id
	            FROM $media_taxonomy_table as mtt
	            LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	            WHERE tt.type='category' AND tt.title IN ($arg)
	            GROUP BY mtt.media_id
	            HAVING count(DISTINCT tt.title) = $countTitles";

	            if(isset($offset) && isset($limit)) $sql .= " LIMIT $offset, $limit";
	            else if(isset($limit)) $sql .= " LIMIT $limit";
	            
	            $stmt = $wpdb->get_results($wpdb->prepare($sql, $category), ARRAY_A);

	            if($wpdb->num_rows > 0){

	                foreach ($stmt as $key) {
	                    $ids[] = $key['media_id'];
	                }

	                $ids[] = $playlist_id;

	                //get media

	                $in = implode(',', array_fill(0, count($stmt), '%d'));

	                $query = "SELECT id, options FROM {$media_table} WHERE id IN ($in) AND playlist_id=%d ORDER BY $sortOrder $sortDirection";
	                $stmt = $wpdb->get_results($wpdb->prepare($query, $ids), ARRAY_A);

	            }

	        }
	        else{//any

	            $category[] = $playlist_id;

	            $sql = "SELECT mt.id, mt.options
	            FROM $media_table as mt
	            WHERE id IN (
	                SELECT mtt.media_id FROM $media_taxonomy_table as mtt
	                LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	                WHERE tt.type='category' AND tt.title IN ($arg)
	            )
	            AND mt.playlist_id = %d 
	            GROUP BY mt.id
	            ORDER BY $sortOrder $sortDirection";

	            if(isset($offset) && isset($limit)) $sql .= " LIMIT $offset, $limit";
	            else if(isset($limit)) $sql .= " LIMIT $limit";

	            $stmt = $wpdb->get_results($wpdb->prepare($sql, $category), ARRAY_A);

	        }

	    }else if(isset($tag)){

	        $tag = explode(',',$tag);
	        $countTitles = count($tag);
	        $arg = implode(',', array_fill(0, count($tag), '%s'));

	        //match any or all 
	        if($match == 'all'){

	            //get media ids

	            $sql = "SELECT mtt.media_id
	            FROM $media_taxonomy_table as mtt
	            LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	            WHERE tt.type='tag' AND tt.title IN ($arg)
	            GROUP BY mtt.media_id
	            HAVING count(DISTINCT tt.title) = $countTitles";

	            if(isset($offset) && isset($limit)) $sql .= " LIMIT $offset, $limit";
	            else if(isset($limit)) $sql .= " LIMIT $limit";
	            
	            $stmt = $wpdb->get_results($wpdb->prepare($sql, $tag), ARRAY_A);

	            if($wpdb->num_rows > 0){

	                foreach ($stmt as $key) {
	                    $ids[] = $key['media_id'];
	                }

	                $ids[] = $playlist_id;

	                //get media

	                $in = implode(',', array_fill(0, count($stmt), '%d'));

	                $query = "SELECT id, options FROM {$media_table} WHERE id IN ($in) AND playlist_id=% ORDER BY $sortOrder $sortDirection";
	                $stmt = $wpdb->get_results($wpdb->prepare($query, $ids), ARRAY_A);

	            }

	        }
	        else{//any

	            $tag[] = $playlist_id;

	            $sql = "SELECT mt.id, mt.options
	            FROM $media_table as mt
	            WHERE id IN (
	                SELECT mtt.media_id FROM $media_taxonomy_table as mtt
	                LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	                WHERE tt.type='tag' AND tt.title IN ($arg)
	            )
	            AND mt.playlist_id = %d 
	            GROUP BY mt.id
	            ORDER BY $sortOrder $sortDirection";

	            if(isset($offset) && isset($limit)) $sql .= " LIMIT $offset, $limit";
	            else if(isset($limit)) $sql .= " LIMIT $limit";

	            $stmt = $wpdb->get_results($wpdb->prepare($sql, $tag), ARRAY_A);

	        }

	    }

	    return $stmt;

	}

	function hap_get_media_fields2($media, $encryptMediaPaths = false){//for load more from db in data format

		//taxonomy
	   /* if(isset($m['category'])){
	    	$media['category'] = $m['category'];
	    }
	    if(isset($m['tag'])){
	    	$media['tag'] = $m['tag'];
	    }*/

		$type = $media["type"];

	    if($type == 'audio'){

	    	if($encryptMediaPaths){

			    if(!empty($media["path"])){
			        $media['path'] = HAP_BSF_MATCH.base64_encode($media['path']);
			    }

			}

	    }else{

			if(!empty($media["path"])){

		    	$prefix = '';
			    if($type == "folder" || $type == "folder_accordion"){
			        if(!isset($media["folder_custom_url"]) || $media["folder_custom_url"] == '0')$prefix = HAP_FILE_DIR;
			    }

		        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($prefix.$media['path']);
		        else $p = $prefix.$media['path'];

		        $media['path'] = $p;
		    }
	    }

	    if($encryptMediaPaths){

		    if(!empty($media["video"])){
		        $media['video'] = HAP_BSF_MATCH.base64_encode($media['video']);
		    }

		}

	    return $media;

	}


	function hap_get_media_fields($media, $encryptMediaPaths = false, $ad_options = null){//media from db or direct shortcode

        if(!empty($media["encrypt_media_paths"]))$encryptMediaPaths = true;

		$type = $media["type"];
	
        $track = '<div class="hap-playlist-item" data-type="'.$type.'"';
        if(isset($media["id"]))$track .= ' data-media-id="'.$media["id"].'"';

        //taxonomy
	  /*  if(isset($m['category'])){
	    	$track .= ' data-category="'.$m["category"].'"';
	    }
	    if(isset($m['tag'])){
	    	$track .= ' data-tag="'.$m["tag"].'"';
	    }*/




	    if($type == 'audio'){

	    	if(!empty($media["path"])){
		        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($media['path']);
		        else $p = $media['path'];
		    }
		    else if(!empty($media["mp3"])){//backwards compatiblity
		        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($media['mp3']);
		        else $p = $media['mp3'];
		    }
		    else if(!empty($media["wav"])){
		        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($media['wav']);
		        else $p = $media['wav'];
		    }
		    else if(!empty($media["aac"])){
		        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($media['aac']);
		        else $p = $media['aac'];
			}
			else if(!empty($media["flac"])){//end backwards compatiblity
		        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($media['flac']);
		        else $p = $media['flac'];
			}

			$track .= ' data-path="'.$p.'"';
		  
	    }else{

		    if(!empty($media["path"])){

		    	$prefix = '';
			    if($type == "folder" || $type == "folder_accordion"){
			        if(!isset($media["folder_custom_url"]) || $media["folder_custom_url"] == '0')$prefix = HAP_FILE_DIR;
			    }

		        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($prefix.$media['path']);
		        else $p = $prefix.$media['path'];

		        $track .= ' data-path="'.$p.'"';
		    }

		}

		if(!empty($media["audio_preview"])){
	        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($media['audio_preview']);
	        else $p = $media['audio_preview'];

	        $track .= ' data-audio-preview="'.$p.'"';
		}

		if(!empty($media["peaks"])){
	        $track .= ' data-peaks="'.$media['peaks'].'"';
		}

		if(!empty($media["video"])){
	        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($media['video']);
	        else $p = $media['video'];

	        $track .= ' data-video="'.$p.'"';
		}

		if(!empty($media["lyrics"])){
	        if($encryptMediaPaths)$p = HAP_BSF_MATCH.base64_encode($media['lyrics']);
	        else $p = $media['lyrics'];

	        $track .= ' data-lyrics="'.$p.'"';
		}


	    if(!empty($media["noapi"])){
	        $track .= ' data-noapi="1"';
	    }

	    if($type == "shoutcast"){
		    if(!empty($media["shoutcast_version"])){
		        $track .= ' data-version="'.$media["shoutcast_version"].'"';
		    }
		    if(!empty($media["sid"])){
		        $track .= ' data-sid="'.$media["sid"].'"';
		    }
		}
	    else if($type == "icecast" || $type == "radiojar"){	
		    if(!empty($media["mountpoint"])){
		        $track .= ' data-mountpoint="'.$media["mountpoint"].'"';
		    }
		}
	    if(!empty($media["title"])){
	        $track .= ' data-title="'.$media["title"].'"';
	    }
	    if(!empty($media["artist"])){
	        $track .= ' data-artist="'.$media["artist"].'"';
	    }
	    if(!empty($media["duration"])){
	        $track .= ' data-duration="'.$media["duration"].'"';
	    }
	    if(empty($media["description_is_html"])){
	    	if(!empty($media["description"])){
		        $track .= ' data-description="'.$media["description"].'"';
		    }
	    }
	    if(!empty($media["thumb"])){
	        $track .= ' data-thumb="'.$media["thumb"].'"';
	    }
	    if(!empty($media["thumb_small"])){
	        $track .= ' data-thumb-small="'.$media["thumb_small"].'"';
	    }
	    if(!empty($media["thumb_default"])){
	        $track .= ' data-thumb-default="'.$media["thumb_default"].'"';
	    }
	    if(!empty($media["thumb_alt"])){
	        $track .= ' data-thumb-alt="'.$media["thumb_alt"].'"';
	    }
	    if(!empty($media["download"])){
	        $track .= ' data-download="'.$media["download"].'"';
	    }
	    if(!empty($media["link"])){
	        $track .= ' data-link="'.$media["link"].'"';
	        if(!empty($media["target"])){
	            $track .= ' data-target="'.$media["target"].'"';
	        }
	    }

	    if(isset($media["pi_icons"])){
	        //var_dump($media["pi_icons"]);

	        $track .= ' data-playlist-icons=\'[';
	        $pi_icons = '';

	        foreach ($media["pi_icons"] as $icon) {
	        	$pi_icons .= '{"title": "'.$icon['title'].'", "url": "'.$icon['url'].'", "target": "'.$icon['target'].'", "icon": "'.$icon['icon'].'"},';
	        }
	        $pi_icons = substr($pi_icons, 0, -1);//remove last comma

	        $track .= $pi_icons;
	        $track .= ']\''; 
	    }


	    if(!empty($media["limit"])){
	        $track .= ' data-limit="'.$media["limit"].'"';
	    }
	    if(!empty($media["start"])){
	        $track .= ' data-start="'.$media["start"].'"';
	    }
	    if(!empty($media["end"])){
	        $track .= ' data-end="'.$media["end"].'"';
	    }
	    if($type == "folder" || $type == "folder_accordion"){
		    if(!empty($media["folder_sort"])){
		        $track .= ' data-sort="'.$media["folder_sort"].'"';
		    }
		    if(isset($media["id3"]) && $media["id3"] == '1'){
		        $track .= ' data-id3="1"';
		    }
		    if(!empty($media["active_accordion"])){
		        $track .= ' data-active-accordion="'.$media["active_accordion"].'"';
		    }
		}
		else if($type == "json_accordion"){
		    if(isset($media["id3"]) && $media["id3"] == '1'){
		        $track .= ' data-id3="1"';
		    }
		    if(!empty($media["active_accordion"])){
		        $track .= ' data-active-accordion="'.$media["active_accordion"].'"';
		    }
		}
		else if($type == "gdrive_folder"){	    
		    if(!empty($media["gdrive_sort"])){
		        $track .= ' data-sort="'.$media["gdrive_sort"].'"';
		    }
		}
		else if($type == "folder" || $type == "youtube_playlist" || $type == "soundcloud" || $type == "podcast"){
		    if(isset($media["load_more"]) && $media["load_more"] == '1'){
		        $track .= ' data-load-more="1"';
		    }
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

        }else{

        	if(isset($media["ad_pre"])){
				$adPre = is_array($media["ad_pre"]) ? implode(",", $media["ad_pre"]) : $media["ad_pre"];
	            if(!empty($adPre))$track .= ' data-ad-pre="'.$adPre.'"';
	        }
			if(isset($media["ad_mid"])){
				$adMid = is_array($media["ad_mid"]) ? implode(",", $media["ad_mid"]) : $media["ad_mid"];
				if(!empty($adMid)){
		            $track .= ' data-ad-mid="'.$adMid.'"';
		            if(!empty($media["ad_mid_interval"]))$track .= ' data-ad-mid-interval="'.$media["ad_mid_interval"].'"';
		        }
	        }
	        if(isset($media["ad_end"])){
	        	$adEnd = is_array($media["ad_end"]) ? implode(",", $media["ad_end"]) : $media["ad_end"];
	            if(!empty($adEnd))$track .= ' data-ad-end="'.$adEnd.'"';
	        }
	        if(!empty($media["shuffle_ads"])){
	            $track .= ' data-shuffle-ads="1"';
	        }
        }


	    $track .= '>';

	    if(!empty($media["description_is_html"])){
		    if(!empty($media["description"])){
		    	$track .= '<div class="hap-playlist-description">'. $media['description'] .'</div>';
		    }
		}

	    $track .= '</div>'.PHP_EOL;//end playlist item
    
	    return $track.PHP_EOL;

	}


	//############################################//
	/* STATISTICS */
	//############################################//

	function hap_get_stat_data(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['type'])){

			$type = $_POST["type"];

			if($type == 'player'){

				$player_id = $_POST["type_id"];

				$data = array(
					'results' => hap_getAll(null, $player_id, 'title'),
				    'total' => hap_getTotal(null, $player_id),
					'top_day' => hap_getTopPlayToday(null, $player_id),
					'top_week' => hap_getTopPlayThisWeek(null, $player_id),
					'top_month' => hap_getTopPlayThisMonth(null, $player_id),
					'top_plays' => hap_getTopPlayAllTime(null, $player_id),
					'top_downloads' => hap_getTopDownloadAllTime(null, $player_id),
					'top_likes' => hap_getTopLikeAllTime(null, $player_id),
					'top_finish' => hap_getTopFinishAllTime(null, $player_id),
					'top_skipped_first_minute' => hap_getTopSkipFirstMinAllTime(null, $player_id),
					'top_plays_country' => hap_getTopPlaysPerCountryAllTime(null, $player_id),
					'top_plays_user' => hap_getTopPlaysPerUserAllTime(null, $player_id),
				);


			}else if($type == 'playlist'){

				$playlist_id = $_POST["type_id"];

				$data = array(
					'results' => hap_getAll($playlist_id, null, 'title'),
				    'total' => hap_getTotal($playlist_id),
					'top_day' => hap_getTopPlayToday($playlist_id),
					'top_week' => hap_getTopPlayThisWeek($playlist_id),
					'top_month' => hap_getTopPlayThisMonth($playlist_id),
					'top_plays' => hap_getTopPlayAllTime($playlist_id),
					'top_downloads' => hap_getTopDownloadAllTime($playlist_id),
					'top_likes' => hap_getTopLikeAllTime($playlist_id),
					'top_finish' => hap_getTopFinishAllTime($playlist_id),
					'top_skipped_first_minute' => hap_getTopSkipFirstMinAllTime($playlist_id),
					'top_plays_country' => hap_getTopPlaysPerCountryAllTime($playlist_id),
					'top_plays_user' => hap_getTopPlaysPerUserAllTime($playlist_id),
				);

			}

		    echo json_encode($data);
	    	
			wp_die('');
		
		}else {
			wp_die('');
		}

	}


	function hap_stat_create_graph(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['media_id'])){

			$playlist_id = $_POST["playlist_id"];
			$media_id = $_POST["media_id"];
			$title = stripslashes($_POST['title']);
			$artist = stripslashes($_POST['artist']);
			$start = $_POST["start"];
			$end = $_POST["end"];
			$data_display = json_decode(stripcslashes($_POST['data_display']), true); 
			$display_type = $_POST["display_type"];

			global $wpdb;
			$wpdb->show_errors(); 
		    $statistics_table = $wpdb->prefix . "map_statistics";

		    $results = hap_getTotalForSongRange($playlist_id, null, $media_id, $title, $artist, $start, $end, $data_display, $display_type);

		    echo json_encode($results);
	    	
			wp_die('');
		
		}else {
			wp_die('');
		}

	}

	function hap_get_stats($atts){

		if(!isset($atts['action']))return "Action parameter missing!";

		$action = $atts['action'];
		$playlist_id = isset($atts['playlist_id']) ? $atts["playlist_id"] : -1;
        $days = isset($atts['days']) ? $atts['days'] : 7;
        $limit = isset($atts['limit']) ? $atts['limit'] : 10;
        $dir = isset($atts['dir']) ? strtoupper($atts['dir']) : 'DESC';
        $title = isset($atts['title']) ? $atts['title'] : '';

        if($action == 'top_play_today')$results = hap_getTopPlayToday($playlist_id, null, $limit, $dir);
        else if($action == 'top_play_last_x_days')$results = hap_getTopPlayLastXDays($playlist_id, null, $days, $limit, $dir);
        else if($action == 'top_play_this_week')$results = hap_getTopPlayThisWeek($playlist_id, null, $limit, $dir);
        else if($action == 'top_play_this_month')$results = hap_getTopPlayThisMonth($playlist_id, null, $limit, $dir);
        else if($action == 'top_play_all_time')$results = hap_getTopPlayAllTime($playlist_id, null, $limit, $dir);
        else if($action == 'top_download_all_time')$results = hap_getTopDownloadAllTime($playlist_id, null, $limit, $dir);
        else if($action == 'top_like_all_time')$results = hap_getTopLikeAllTime($playlist_id, null, $limit, $dir);
        else if($action == 'top_finish_all_time')$results = hap_getTopFinishAllTime($playlist_id, null, $limit, $dir);
		else return "Action parameter incorrect!";


		if(count($results) > 0){

			$id = 'hap-stat-wrap'.mt_rand();//to limit selector for click

		  	$markup = '<div class="hap-stat-wrap" id="'.$id.'">
					<div class="hap-stat-wrap-header">
						<span>'.esc_html($title).'</span>
					</div>';

					foreach($results as $key) : 

						if($key['title'] !== '' && $key['artist'] !== '') : 
							$full_title = esc_html($key['artist']).' - '.esc_html($key['title']);
						elseif($key['title'] !== '') : 
							$full_title = esc_html($key['title']);
						else : 
							$full_title = esc_html($key['artist']);
						endif;


						$markup .= '<div class="hap-stat-item" data-media-id="'.esc_attr($key['media_id']).'" title="'.esc_attr($full_title).'"';//we need title and artist and special song selection if songs come from grouped source (and media-id is the same)

						if($key['audio_url'])$markup .= ' data-url="'.esc_attr(HAP_BSF_MATCH.base64_encode($key['audio_url'])).'"';

						$markup .= '>';

						if($key['thumb'] !== ''){

							$markup .= '<div class="hap-stat-item-thumb-wrap">';

							$markup .= '<div class="hap-stat-item-thumb"><img src="'.$key['thumb'].'" alt="image"/></div>';

							$markup .= '<div class="hap-equaliser-container">
							  <div class="hap-equaliser-column">
							      <div class="hap-equaliser-colour-bar"></div>
							  </div>
							  <div class="hap-equaliser-column">
							      <div class="hap-equaliser-colour-bar"></div>
							  </div>
							  <div class="hap-equaliser-column">
							      <div class="hap-equaliser-colour-bar"></div>
							  </div>
							  <div class="hap-equaliser-column">
							      <div class="hap-equaliser-colour-bar"></div>
							  </div>
							  <div class="hap-equaliser-column">
							      <div class="hap-equaliser-colour-bar"></div>
							  </div>
							</div>';

							$markup .= '</div>';//hap-stat-item-thumb-wrap

						}

						$markup .= '<div class="hap-stat-item-title">';

						$markup .= '<a href="#">'.$full_title.'</a>';

						$markup .= '<span class="hap-stat-item-play-count">('.$key['total_count'].')</span>';

						$markup .= '</div>';//hap-stat-item-title

						$markup .= '</div>';//hap-stat-item

					endforeach;

				$markup .= '</div>';//hap-stat-wrap

			if(isset($atts['player_id'])){
        		$player_id = $atts['player_id'];
        		//click to play in player (note: we must use the same playlist_id that is loaded in the player)
        		$markup .= '<script type="text/javascript">
					var elem = document.getElementById("'.$id.'"),
					items = elem.querySelectorAll(".hap-stat-item"), i, len = items.length;
					for (i = 0; i < len; i++) {
					    items[i].addEventListener("click", function(e) { 
					    	e.preventDefault();
					    	hap_player'.$player_id.'.loadMedia("id-title", this.getAttribute("data-media-id"), this.getAttribute("title"), this.getAttribute("data-artist")); return false;  
						}, false);
					}
				</script>';   
			}
			else if(isset($atts['inline_play'])){

				wp_enqueue_script('apmap-inline-stat-playback', plugins_url('source/js/inline_stat_playback.js', __FILE__), array('jquery'));

				wp_enqueue_style('apmap-inline-stat-playback', plugins_url('/source/css/inline_stat_playback.css', __FILE__));
        		 
			}

			return $markup;

		}else{
			return 'No songs available for this requested statistic data: ' . $action;
		}
		
	}

	function hap_stat_clear(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['type'])){

			$type = $_POST["type"];

			global $wpdb;
		    $statistics_table = $wpdb->prefix . "map_statistics";
		    $statistics_country_play_table = $wpdb->prefix . "map_statistics_country_play";
		    $statistics_user_play_table = $wpdb->prefix . "map_statistics_user_play";

			if($type == 'playlist'){

				$playlist_id = $_POST["playlist_id"];

				if($playlist_id == -1){

		    		$stmt = $wpdb->query("DELETE FROM {$statistics_table}");
		    		$stmt = $wpdb->query("DELETE FROM {$statistics_country_play_table}");
		    		$stmt = $wpdb->query("DELETE FROM {$statistics_user_play_table}");

				}else if($playlist_id == -2){

					$stmt = $wpdb->query("DELETE FROM {$statistics_table} WHERE media_id IS null");
					$stmt = $wpdb->query("DELETE FROM {$statistics_country_play_table} WHERE media_id IS null");
					$stmt = $wpdb->query("DELETE FROM {$statistics_user_play_table} WHERE media_id IS null");

		    	}else{
		    		$stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$statistics_table} WHERE playlist_id=%d", $playlist_id));

		    		$stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$statistics_country_play_table} WHERE playlist_id=%d", $playlist_id));

		    		$stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$statistics_user_play_table} WHERE playlist_id=%d", $playlist_id));

		    	}

			}else if($type == 'player'){

				$player_id = $_POST["player_id"];

				$stmt = $wpdb->query($wpdb->prepare("DELETE FROM {$statistics_table} WHERE player_id=%d", $player_id));

			}

	    	if($stmt !== false){
	    		echo json_encode("SUCCESS");
	    	}
	
		    wp_die();

		}else{
			wp_die();
		}
	}

	function hap_play_count(){

		$media_id = !hap_nullOrEmpty($_POST["media_id"]) ? $_POST["media_id"] : null;
		$playlist_id = !hap_nullOrEmpty($_POST["playlist_id"]) ? $_POST["playlist_id"] : null;
		$player_id = !hap_nullOrEmpty($_POST["player_id"]) ? $_POST["player_id"] : null;
		$date = date("Y-m-d");
		$user_ip = hap_get_ip_address();
		$title = stripslashes($_POST['title']);
		$artist = stripslashes($_POST['artist']);
		$album = stripslashes($_POST['album']);
		$thumb = stripslashes($_POST['thumb']);
		$audio_url = stripslashes($_POST['audio_url']);
		$countryData = json_decode(stripcslashes($_POST['countryData']), true); 
		$currentTime = (int)$_POST['currentTime'];
		$duration = (int)$_POST['duration'];
		$percentToCountAsPlay = $_POST['percentToCountAsPlay'];

		$percent = $duration / (100 / $percentToCountAsPlay);
		if($currentTime > $percent){
		    $play_add = 1;
		} else {
		    $play_add = 0;
		}



		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $statistics_country_table = $wpdb->prefix . "map_statistics_country";
	    $statistics_country_play_table = $wpdb->prefix . "map_statistics_country_play";
	    $statistics_user_table = $wpdb->prefix . "map_statistics_user";
	    $statistics_user_play_table = $wpdb->prefix . "map_statistics_user_play";

	    if($media_id){

		    //check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s", $media_id, $title, $artist, $date));

		    if($wpdb->num_rows == 0){

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip, media_id, playlist_id, player_id) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 1, '$currentTime', 0, 0, 0, 0, '$date', '$user_ip', '$media_id', '$playlist_id', '$player_id')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_play=c_play+$play_add, c_time=c_time+%d WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s LIMIT 1", $currentTime, $media_id, $title, $artist, $date));
		   
		    }

		    //country
		    if(isset($countryData) && !empty($countryData)){

			    $stmt = $wpdb->get_var($wpdb->prepare("SELECT id FROM $statistics_country_table WHERE country_code=%s", $countryData['countryCode']));

			  	if($wpdb->num_rows == 0){

			  		$country = $countryData['country'];
			  		$country_code = $countryData['countryCode'];
			  		$continent = $countryData['continent'];

					$wpdb->query("INSERT INTO $statistics_country_table (country, country_code, continent) VALUES ('$country', '$country_code', '$continent')");
					$country_id = $wpdb->insert_id;
			    }else{
			    	$country_id = $stmt;
			    }

			    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_country_play_table WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s AND country_id=%d", $media_id, $title, $artist, $date, $country_id));

			    if($wpdb->num_rows == 0){

					$wpdb->query("INSERT INTO $statistics_country_play_table (title, artist, album, thumb, audio_url, c_play, c_time, c_date, media_id, playlist_id, player_id, country_id) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 1, '$currentTime', '$date', '$media_id', '$playlist_id', '$player_id', '$country_id')");

			    }else{//update 

			    	$wpdb->query($wpdb->prepare("UPDATE $statistics_country_play_table SET c_play=c_play+$play_add, c_time=c_time+%d WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s AND country_id=%d LIMIT 1", $currentTime, $media_id, $title, $artist, $date, $country_id));
			   
			    }


		    }


		    //user

			if(is_user_logged_in()){ 
			    $current_user = wp_get_current_user();

			    $stmt = $wpdb->get_var($wpdb->prepare("SELECT id FROM $statistics_user_table WHERE user_id=%s", $current_user->ID));

			  	if($wpdb->num_rows == 0){

			  		$uid = $current_user->ID;
			  		$user_display_name = $current_user->display_name;
			  		$user_role = implode(",", $current_user->roles);

					$wpdb->query("INSERT INTO $statistics_user_table (user_id, user_display_name, user_role) VALUES ('$uid', '$user_display_name', '$user_role')");
					$user_id = $wpdb->insert_id;
			    }else{
			    	$user_id = $stmt;
			    }

			    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_user_play_table WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s AND user_id=%d", $media_id, $title, $artist, $date, $user_id));

			    if($wpdb->num_rows == 0){

					$wpdb->query("INSERT INTO $statistics_user_play_table (title, artist, album, thumb, audio_url, c_play, c_time, c_date, media_id, playlist_id, player_id, user_id) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 1, '$currentTime', '$date', '$media_id', '$playlist_id', '$player_id', '$user_id')");

			    }else{//update 

			    	$wpdb->query($wpdb->prepare("UPDATE $statistics_user_play_table SET c_play=c_play+$play_add, c_time=c_time+%d WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s AND user_id=%d LIMIT 1", $currentTime, $media_id, $title, $artist, $date, $user_id));
			   
			    }

			}

			    
			


			//get count
	    	$stmt = $wpdb->get_row($wpdb->prepare("SELECT SUM(c_play) AS c_play FROM $statistics_table WHERE media_id=%d AND title=%s AND artist=%s", $media_id, $title, $artist), ARRAY_A);

	    }else{

	    	//check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s", $title, $artist, $date));

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 1, '$currentTime', 0, 0, 0, 0, '$date', '$user_ip')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_play=c_play+$play_add, c_time=c_time+%d WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s LIMIT 1", $currentTime, $title, $artist, $date));
		   
		    }
		    
		    //get count
	    	$stmt = $wpdb->get_row($wpdb->prepare("SELECT SUM(c_play) AS c_play FROM $statistics_table WHERE media_id IS null AND title=%s AND artist=%s", $title, $artist), ARRAY_A);

	    }

    	if($stmt !== false){
    		echo json_encode($stmt);
    	}
		wp_die();

	}

	function hap_time_played(){

		$media_id = !hap_nullOrEmpty($_POST["media_id"]) ? $_POST["media_id"] : null;
		$playlist_id = !hap_nullOrEmpty($_POST["playlist_id"]) ? $_POST["playlist_id"] : null;
		$player_id = !hap_nullOrEmpty($_POST["player_id"]) ? $_POST["player_id"] : null;
		$date = date("Y-m-d");
		$user_ip = hap_get_ip_address();
		$title = stripslashes($_POST['title']);
		$artist = stripslashes($_POST['artist']);
		$album = stripslashes($_POST['album']);
		$thumb = stripslashes($_POST['thumb']);
		$audio_url = stripslashes($_POST['audio_url']);
		$seconds_played = $_POST["seconds_played"];

		global $wpdb;
	    $statistics_table = $wpdb->prefix . "map_statistics";

	    if($media_id){

		    //check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id=%d AND title=%s AND c_date=%s", $media_id, $title, $date));

		    if($wpdb->num_rows == 0){

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip, media_id, playlist_id, player_id) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, $seconds_played, 0, 0, 0, 0, '$date', '$user_ip', '$media_id', '$playlist_id', '$player_id')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_time=c_time+%d WHERE media_id=%d AND title=%s AND c_date=%s LIMIT 1", $seconds_played, $media_id, $title, $date));
		   
		    }

	    }else{

	    	//check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id IS null AND title=%s AND c_date=%s", $title, $date));

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, '$seconds_played', 0, 0, 0, 0, '$date', '$user_ip')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_time=c_time+%d WHERE media_id IS null AND title=%s AND c_date=%s LIMIT 1", $seconds_played, $title, $date));
		   
		    }

	    }

    	echo json_encode('-1');

		wp_die();

	}

	function hap_like_count(){

		$media_id = !hap_nullOrEmpty($_POST["media_id"]) ? $_POST["media_id"] : null;
		$playlist_id = !hap_nullOrEmpty($_POST["playlist_id"]) ? $_POST["playlist_id"] : null;
		$player_id = !hap_nullOrEmpty($_POST["player_id"]) ? $_POST["player_id"] : null;
		$date = date("Y-m-d");
		$user_ip = hap_get_ip_address();
		$title = stripslashes($_POST['title']);
		$artist = stripslashes($_POST['artist']);
		$album = stripslashes($_POST['album']);
		$thumb = stripslashes($_POST['thumb']);
		$audio_url = stripslashes($_POST['audio_url']);

		global $wpdb;
		$wpdb->show_errors(); 
	    $statistics_table = $wpdb->prefix . "map_statistics";

	    if($media_id){

		    //check if exist
		    $stmt = $wpdb->get_row($wpdb->prepare("SELECT id, c_like FROM $statistics_table WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s AND c_user_ip=%s", $media_id, $title, $artist, $date, $user_ip), ARRAY_A);

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip, media_id, playlist_id, player_id) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, 0, 1, 0, 0, 0, '$date', '$user_ip', '$media_id', '$playlist_id', '$player_id')");

		    }else{//update 

		    	if($stmt["c_like"] == 0){
		    		$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_like=1 WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s AND c_user_ip=%s", $media_id, $title, $artist, $date, $user_ip));
		    	}

		    }

		    //get count
	    	$stmt = $wpdb->get_row($wpdb->prepare("SELECT SUM(c_like) AS c_like FROM $statistics_table WHERE media_id=%d AND title=%s AND artist=%s", $media_id, $title, $artist), ARRAY_A);

	    }else{

	    	//check if exist
		    $stmt = $wpdb->get_row($wpdb->prepare("SELECT id, c_like FROM $statistics_table WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s AND c_user_ip=%s", $title, $artist, $date, $user_ip), ARRAY_A);

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, 0, 1, 0, 0, 0, '$date', '$user_ip')");

		    }else{//update 

		    	if($stmt["c_like"] == 0){
		    		$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_like=1 WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s AND c_user_ip=%s", $title, $artist, $date, $user_ip));
		    	}

		    }

		    //get count
	    	$stmt = $wpdb->get_row($wpdb->prepare("SELECT SUM(c_like) AS c_like FROM $statistics_table WHERE media_id IS null AND title=%s AND artist=%s", $title, $artist), ARRAY_A);

	    }

    	if($stmt !== false){
    		echo json_encode($stmt);
    	}
		wp_die();

	}

	function hap_download_count(){

		$media_id = !hap_nullOrEmpty($_POST["media_id"]) ? $_POST["media_id"] : null;
		$playlist_id = !hap_nullOrEmpty($_POST["playlist_id"]) ? $_POST["playlist_id"] : null;
		$player_id = !hap_nullOrEmpty($_POST["player_id"]) ? $_POST["player_id"] : null;
		$date = date("Y-m-d");
		$user_ip = hap_get_ip_address();
		$title = stripslashes($_POST['title']);
		$artist = stripslashes($_POST['artist']);
		$album = stripslashes($_POST['album']);
		$thumb = stripslashes($_POST['thumb']);
		$audio_url = stripslashes($_POST['audio_url']);

		global $wpdb;
		$wpdb->show_errors(); 
	    $statistics_table = $wpdb->prefix . "map_statistics";

	    if($media_id){

		    //check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s", $media_id, $title, $artist, $date));

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip, media_id, playlist_id, player_id) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, 0, 0, 1, 0, 0, '$date', '$user_ip', '$media_id', '$playlist_id', '$player_id')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_download=c_download+1 WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s LIMIT 1", $media_id, $title, $artist, $date));
		    	
		    }

		    //get count
		    $stmt = $wpdb->get_row($wpdb->prepare("SELECT SUM(c_download) AS c_download FROM $statistics_table WHERE media_id=%d AND title=%s AND artist=%s", $media_id, $title, $artist), ARRAY_A);

		}else{

			//check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s",  $title, $artist, $date));

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, 0, 0, 1, 0, 0, '$date', '$user_ip'')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_download=c_download+1 WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s LIMIT 1", $title, $artist, $date));
		    	
		    }

		    //get count
		    $stmt = $wpdb->get_row($wpdb->prepare("SELECT SUM(c_download) AS c_download FROM $statistics_table WHERE media_id IS null AND title=%s AND artist=%s", $title, $artist), ARRAY_A);

		}
	    	
    	if($stmt !== false){
    		echo json_encode($stmt);
    	}
		wp_die();

	}

	function hap_finish_count(){

		$media_id = !hap_nullOrEmpty($_POST["media_id"]) ? $_POST["media_id"] : null;
		$playlist_id = !hap_nullOrEmpty($_POST["playlist_id"]) ? $_POST["playlist_id"] : null;
		$player_id = !hap_nullOrEmpty($_POST["player_id"]) ? $_POST["player_id"] : null;
		$date = date("Y-m-d");
		$user_ip = hap_get_ip_address();
		$title = stripslashes($_POST['title']);
		$artist = stripslashes($_POST['artist']);
		$album = stripslashes($_POST['album']);
		$thumb = stripslashes($_POST['thumb']);
		$audio_url = stripslashes($_POST['audio_url']);

		global $wpdb;
		$wpdb->show_errors(); 

	    $statistics_table = $wpdb->prefix . "map_statistics";

	    if($media_id){

		    //check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s", $media_id, $title, $artist, $date));

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip, media_id, playlist_id, player_id) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, 0, 0, 0, 1, 0, '$date', '$user_ip', '$media_id', '$playlist_id', '$player_id')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_finish=c_finish+1 WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s LIMIT 1", $media_id, $title, $artist, $date));
		    	
		    }
	    	
		}else{

			//check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s", $title, $artist, $date));

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, 0, 0, 0, 1, 0, '$date', '$user_ip')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET c_finish=c_finish+1 WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s LIMIT 1", $title, $artist, $date));
		    	
		    }

		}

		echo json_encode('');

		wp_die();
		
	}

	function hap_skipped_first_minute(){

		$media_id = !hap_nullOrEmpty($_POST["media_id"]) ? $_POST["media_id"] : null;
		$playlist_id = !hap_nullOrEmpty($_POST["playlist_id"]) ? $_POST["playlist_id"] : null;
		$player_id = !hap_nullOrEmpty($_POST["player_id"]) ? $_POST["player_id"] : null;
		$date = date("Y-m-d");
		$user_ip = hap_get_ip_address();
		$title = stripslashes($_POST['title']);
		$artist = stripslashes($_POST['artist']);
		$album = stripslashes($_POST['album']);
		$thumb = stripslashes($_POST['thumb']);
		$audio_url = stripslashes($_POST['audio_url']);

		global $wpdb;
		$wpdb->show_errors(); 

	    $statistics_table = $wpdb->prefix . "map_statistics";

	    if($media_id){

		    //check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s", $media_id, $title, $artist, $date));

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip, media_id, playlist_id, player_id) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, 0, 0, 0, 0, 1, '$date', '$user_ip', '$media_id', '$playlist_id', '$player_id')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET skipped_first_minute=skipped_first_minute+1 WHERE media_id=%d AND title=%s AND artist=%s AND c_date=%s LIMIT 1", $media_id, $title, $artist, $date));
		    	
		    }
	    	
		}else{

			//check if exist
		    $wpdb->get_row($wpdb->prepare("SELECT id FROM $statistics_table WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s", $title, $artist, $date));

		    if($wpdb->num_rows == 0){//create entry

				$wpdb->query("INSERT INTO $statistics_table (title, artist, album, thumb, audio_url, c_play, c_time, c_like, c_download, c_finish, skipped_first_minute, c_date, c_user_ip) VALUES ('$title', '$artist', '$album', '$thumb', '$audio_url', 0, 0, 0, 0, 0, 1, '$date', '$user_ip')");

		    }else{//update 

		    	$wpdb->query($wpdb->prepare("UPDATE $statistics_table SET skipped_first_minute=skipped_first_minute+1 WHERE media_id IS null AND title=%s AND artist=%s AND c_date=%s LIMIT 1", $title, $artist, $date));
		    	
		    }

		}

		echo json_encode('');

		wp_die();

	}

	function hap_all_count(){

		if(isset($_POST['data'])){

			$data = json_decode(stripcslashes($_POST['data']), true); 
			$len = count($data);
			$i = 0;
			$str = '(';
				foreach ($data as $d) {
					$title = $d['title'];
					$artist = $d['artist'];

					if($d['media_id']){
						$str .= '( media_id = \''.$d['media_id'].'\' AND title = \''.$title.'\' AND artist = \''.$artist.'\')';
					}else{
						$str .= '( media_id IS null AND title = \''.$title.'\' AND artist = \''.$artist.'\')';
					}
					
					if($i < $len-1)$str .= ' OR ';
					$i++;
				}
			$str .= ')';

			global $wpdb;
			$wpdb->show_errors(); 
		    $statistics_table = $wpdb->prefix . "map_statistics";

	    	$stmt = $wpdb->get_results("SELECT media_id, title, artist, SUM(c_play) AS c_play, SUM(c_like) AS c_like, SUM(c_download) AS c_download FROM $statistics_table WHERE {$str} GROUP BY media_id, title, artist", ARRAY_A);

	    	if($stmt !== false){
	    		echo json_encode($stmt);
	    	}
			wp_die();

		}else {
			wp_die();
		}
	}

	//############################################//
	/* export player */
	//############################################//

	function hap_export_player(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(!extension_loaded('zip'))wp_die('PHP zip extension not installed or enabled!');

		if(isset($_POST['player_id']) && isset($_POST['player_title'])){

			$player_id = $_POST['player_id'];
			$player_title = $_POST['player_title'];

			global $wpdb;
			$wpdb->show_errors(); 

		    $player_table = $wpdb->prefix . "map_players";

			// create zip file
			$zipname = 'hap_player_id_'.$player_id.'_'.$player_title.'_'.date('m-d-Y_hia').'.zip';
			$zip = new ZipArchive;
			$zip->open($zipname, ZipArchive::CREATE);

			//player
			$stmt = $wpdb->prepare("SELECT id, title, preset, options, custom_css, custom_js FROM {$player_table} WHERE id = %d", $player_id);//we need to select in specific order for bulk import!
			$result = $wpdb->get_results($stmt, ARRAY_N);
			hap_getOutput($player_table, $result, $zip);

			// close the archive
			$zip->close();

			echo json_encode(array('zip' => $zipname));

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_import_player(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		$posted_data =  isset( $_POST ) ? $_POST : array();
		$file_data = isset( $_FILES ) ? $_FILES : array();

		$data = array_merge( $posted_data, $file_data );

		$fileName = $data["hap_file_upload"]["name"];
		$temp_name = $data["hap_file_upload"]["tmp_name"];
		$fileError = $data["hap_file_upload"]["error"];
		$upload_path = HAP_FILE_DIR."/plzip/";

		if(!file_exists($upload_path))wp_mkdir_p($upload_path);

		$response = array();

		if($fileError > 0){

			$error = array(
				0 => "There is no error, the file uploaded with success",
				1 => "The uploaded file exceeds the upload_max_files in server settings",
				2 => "The uploaded file exceeds the MAX_FILE_SIZE from html form",
				3 => "The uploaded file uploaded only partially",
				4 => "No file was uploaded",
				6 => "Missing a temporary folder",
				7 => "Failed to write file to disk",
				8 => "A PHP extension stoped file to upload" );

			$response["response"] = "ERROR";
            $response["error"] = $error[ $fileError ];

		} else {

			if( move_uploaded_file( $temp_name, $upload_path.$fileName ) ){
	            		
				//unzip

	            WP_Filesystem();

	            $unzipfile = unzip_file( $upload_path.$fileName, $upload_path);
				   
			    if ( is_wp_error( $unzipfile ) ) {
			    	$response["response"] = "ERROR";
			        $response["error"] = 'There was an error unzipping the file.'; 
			    } else {
			    	$response["response"] = "SUCCESS";

			        //process csv

			        global $wpdb;
					$wpdb->show_errors(); 
					$player_table = $wpdb->prefix . "map_players";

			        //players
				    $csv = str_replace('\\', '/', $upload_path.$player_table.'.csv');
				    if(!file_exists($csv)){//in case wrong zip is uploaded (check only one file)
				    	$response["response"] = "ERROR";
            			$response["error"] = "No player file inside archive!";
            			echo json_encode( $response );
						wp_die();
				    } 

				    $arr = array('player' => HAP_FILE_DIR_URL . '/plzip/' . $player_table.'.csv');

		    		echo json_encode($arr);

					wp_die();

			    }
        		
        	} else {

        		$response["response"] = "ERROR";
        		$response["error"]= "Upload Failed!";
        	}

        }

        echo json_encode( $response );
		wp_die();

	}

	function hap_import_player_db(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['player'])){

			$player = json_decode(stripcslashes($_POST['player']), true);

			global $wpdb;
			$wpdb->show_errors(); 

		    $player_table = $wpdb->prefix . "map_players";

		    $stmt = $wpdb->insert(
		    	$player_table,
				array( 
					'title' => $player[1], 
					'preset' => $player[2], 
					'options' => $player[3], 
					'custom_css' => $player[4],
					'custom_js' => $player[5]
				), 
				array( 
					'%s','%s','%s','%s','%s'
				) 
		    );
		  
	    	//delete files
	    	$upload_path = HAP_FILE_DIR."/plzip/";
	        $files = glob($upload_path.'/*'); 
			foreach($files as $file){ 
				if(is_file($file))unlink($file); 
			}

			if($stmt !== false){
	    		echo json_encode('SUCCESS');
	    	}

			wp_die();

		}else {
			wp_die();
		}	

	}

	//############################################//
	/* export ads */
	//############################################//

	function hap_export_ad(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(!extension_loaded('zip'))wp_die('PHP zip extension not installed or enabled!');

		if(isset($_POST['ad_id']) && isset($_POST['ad_title'])){

			$ad_id = $_POST['ad_id'];
			$ad_title = $_POST['ad_title'];

			global $wpdb;
			$wpdb->show_errors(); 

		    $ad_table = $wpdb->prefix . "map_ad";

			// create zip file
			$zipname = 'hap_ad_id_'.$ad_id.'_'.$ad_title.'_'.date('m-d-Y_hia').'.zip';
			$zip = new ZipArchive;
			$zip->open($zipname, ZipArchive::CREATE);

			//ad
			$stmt = $wpdb->prepare("SELECT id, title, options FROM {$ad_table} WHERE id = %d", $ad_id);//we need to select in specific order for bulk import!
			$result = $wpdb->get_results($stmt, ARRAY_N);
			hap_getOutput($ad_table, $result, $zip);

			// close the archive
			$zip->close();

			echo json_encode(array('zip' => $zipname));

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_import_ad(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		$posted_data =  isset( $_POST ) ? $_POST : array();
		$file_data = isset( $_FILES ) ? $_FILES : array();

		$data = array_merge( $posted_data, $file_data );

		$fileName = $data["hap_file_upload"]["name"];
		$temp_name = $data["hap_file_upload"]["tmp_name"];
		$fileError = $data["hap_file_upload"]["error"];
		$upload_path = HAP_FILE_DIR."/plzip/";

		if(!file_exists($upload_path))wp_mkdir_p($upload_path);

		$response = array();

		if($fileError > 0){

			$error = array(
				0 => "There is no error, the file uploaded with success",
				1 => "The uploaded file exceeds the upload_max_files in server settings",
				2 => "The uploaded file exceeds the MAX_FILE_SIZE from html form",
				3 => "The uploaded file uploaded only partially",
				4 => "No file was uploaded",
				6 => "Missing a temporary folder",
				7 => "Failed to write file to disk",
				8 => "A PHP extension stoped file to upload" );

			$response["response"] = "ERROR";
            $response["error"] = $error[ $fileError ];

		} else {

			if( move_uploaded_file( $temp_name, $upload_path.$fileName ) ){
	            		
				//unzip

	            WP_Filesystem();

	            $unzipfile = unzip_file( $upload_path.$fileName, $upload_path);
				   
			    if ( is_wp_error( $unzipfile ) ) {
			    	$response["response"] = "ERROR";
			        $response["error"] = 'There was an error unzipping the file.'; 
			    } else {
			    	$response["response"] = "SUCCESS";

			        //process csv

			        global $wpdb;
					$wpdb->show_errors(); 
					$ad_table = $wpdb->prefix . "map_ad";

			        //ads
				    $csv = str_replace('\\', '/', $upload_path.$ad_table.'.csv');
				    if(!file_exists($csv)){//in case wrong zip is uploaded (check only one file)
				    	$response["response"] = "ERROR";
            			$response["error"] = "No ad file inside archive!";
            			echo json_encode( $response );
						wp_die();
				    } 

				    $arr = array('ad' => HAP_FILE_DIR_URL . '/plzip/' . $ad_table.'.csv');

		    		echo json_encode($arr);

					wp_die();

			    }
        		
        	} else {

        		$response["response"] = "ERROR";
        		$response["error"]= "Upload Failed!";
        	}

        }

        echo json_encode( $response );
		wp_die();

	}

	function hap_import_ad_db(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['ad'])){

			$ad = json_decode(stripcslashes($_POST['ad']), true);

			global $wpdb;
			$wpdb->show_errors(); 

		    $ad_table = $wpdb->prefix . "map_ad";

			$stmt = $wpdb->insert(
		    	$ad_table,
				array( 
					'title' => $ad[1], 
					'options' => $ad[2]
				), 
				array( 
					'%s','%s'
				) 
		    );
		  
	    	//delete files
	    	$upload_path = HAP_FILE_DIR."/plzip/";
	        $files = glob($upload_path.'/*'); 
			foreach($files as $file){ 
				if(is_file($file))unlink($file); 
			}

			if($stmt !== false){
	    		echo json_encode('SUCCESS');
	    	}

			wp_die();

		}else {
			wp_die();
		}	

	}

	//############################################//
	/* export playlist */
	//############################################//

	function hap_export_playlist(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['playlist_id']) && isset($_POST['playlist_title'])){

			$playlist_id = $_POST['playlist_id'];
			$playlist_title = $_POST['playlist_title'];

			global $wpdb;
			$wpdb->show_errors(); 

		    $playlist_table = $wpdb->prefix . "map_playlists";
			$media_table = $wpdb->prefix . "map_media";
			$taxonomy_table = $wpdb->prefix . "map_taxonomy";
			$media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
			$playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";

			// create zip file
			$zipname = 'hap_playlist_id_'.$playlist_id.'_'.$playlist_title.'_'.date('m-d-Y_hia').'.zip';
			$zip = new ZipArchive;
			$zip->open($zipname, ZipArchive::CREATE);

			//playlist
			$stmt = $wpdb->prepare("SELECT id, title, options FROM {$playlist_table} WHERE id = %d", $playlist_id);//we need to select in specific order for bulk import!
			$result = $wpdb->get_results($stmt, ARRAY_N);
			hap_getOutput($playlist_table, $result, $zip);

			//playlist tax
			$stmt = $wpdb->prepare("SELECT id, playlist_id, taxonomy_id FROM {$playlist_taxonomy_table} WHERE playlist_id = %d", $playlist_id);
			$result = $wpdb->get_results($stmt, ARRAY_A);

			if($wpdb->num_rows > 0)hap_getOutput($playlist_taxonomy_table, $result, $zip);

			//media 
			$stmt = $wpdb->prepare("SELECT id, options, order_id, playlist_id FROM {$media_table} WHERE playlist_id = %d", $playlist_id);
			$result = $wpdb->get_results($stmt, ARRAY_A);

			if($wpdb->num_rows > 0){

				hap_getOutput($media_table, $result, $zip);

				$stmt = $wpdb->prepare("SELECT id, media_id, playlist_id, taxonomy_id FROM {$media_taxonomy_table} WHERE playlist_id = %d", $playlist_id);
				$result = $wpdb->get_results($stmt, ARRAY_A);

				if($wpdb->num_rows > 0)hap_getOutput($media_taxonomy_table, $result, $zip);
				
			}

			// close the archive
			$zip->close();

			echo json_encode(array('zip' => $zipname));

	    	wp_die();
	    	
		}else{
			wp_die();
		}
	}

	function hap_clean_export(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['zipname'])){
			@unlink($_POST['zipname']);
		}

		wp_die();
		
	}

	function hap_getOutput($table, $result, $zip){

	    // create a temporary file
	    $size = 1 * 1024 * 1024;
	    $fp = fopen('php://temp/maxmemory:$size', 'w');
	    if (false === $fp) {
	        die('Failed to create temporary file');
	    }
	    fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));//utf-8

	    foreach($result as $row){
	        $trimmed_array = array_map('trim',array_values($row));
	        $line = str_replace('^', '', $trimmed_array);
	        fputcsv($fp, $line, '|','^');
	    }

	    // return to the start of the stream
	    rewind($fp);

	    // add the in-memory file to the archive, giving a name
	    $zip->addFromString($table.'.csv', stream_get_contents($fp) );
	    //close the file
	    fclose($fp);

	}

	function hap_import_playlist(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		$posted_data =  isset( $_POST ) ? $_POST : array();
		$file_data = isset( $_FILES ) ? $_FILES : array();

		$data = array_merge( $posted_data, $file_data );

		$fileName = $data["hap_file_upload"]["name"];
		$temp_name = $data["hap_file_upload"]["tmp_name"];
		$fileError = $data["hap_file_upload"]["error"];
		$upload_path = HAP_FILE_DIR."/plzip/";

		if(!file_exists($upload_path))wp_mkdir_p($upload_path);

		$response = array();

		if($fileError > 0){

			$error = array(
				0 => "There is no error, the file uploaded with success",
				1 => "The uploaded file exceeds the upload_max_files in server settings",
				2 => "The uploaded file exceeds the MAX_FILE_SIZE from html form",
				3 => "The uploaded file uploaded only partially",
				4 => "No file was uploaded",
				6 => "Missing a temporary folder",
				7 => "Failed to write file to disk",
				8 => "A PHP extension stoped file to upload" );

			$response["response"] = "ERROR";
            $response["error"] = $error[ $fileError ];

		} else {

			if( move_uploaded_file( $temp_name, $upload_path.$fileName ) ){
	            		
				//unzip

	            WP_Filesystem();

	            $unzipfile = unzip_file( $upload_path.$fileName, $upload_path);
				   
			    if ( is_wp_error( $unzipfile ) ) {
			    	$response["response"] = "ERROR";
			        $response["error"] = 'There was an error unzipping the file.'; 
			    } else {
			    	$response["response"] = "SUCCESS";

			        //process csv

			        global $wpdb;
					$wpdb->show_errors(); 
					$playlist_table = $wpdb->prefix . "map_playlists";
					$media_table = $wpdb->prefix . "map_media";
					$taxonomy_table = $wpdb->prefix . "map_taxonomy";
					$media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
					$playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";

			        //playlists
				    $csv = str_replace('\\', '/', $upload_path.$playlist_table.'.csv');
				    if(!file_exists($csv)){//in case wrong zip is uploaded (check only one file)
				    	$response["response"] = "ERROR";
            			$response["error"] = "No playlist file inside archive!";
            			echo json_encode( $response );
						wp_die();
				    }

				    $arr = array('playlist' => HAP_FILE_DIR_URL . '/plzip/' . $playlist_table.'.csv');

				    //playlist tax
				    $csv = str_replace('\\', '/', $upload_path.$playlist_taxonomy_table.'.csv');
				    if(file_exists($csv)){
				    	$arr['playlist_taxonomy'] = HAP_FILE_DIR_URL . '/plzip/' . $playlist_taxonomy_table.'.csv';
				    }

				    //media
				    $csv = str_replace('\\', '/', $upload_path.$media_table.'.csv');
				    if(file_exists($csv)){
				    	$arr['media'] = HAP_FILE_DIR_URL . '/plzip/' . $media_table.'.csv';
				    }

				    //media tax
				    $csv = str_replace('\\', '/', $upload_path.$media_taxonomy_table.'.csv');
				    if(file_exists($csv)){
				    	$arr['media_taxonomy'] = HAP_FILE_DIR_URL . '/plzip/' . $media_taxonomy_table.'.csv';
				    }

		    		echo json_encode($arr);

	    			wp_die();
	    	
	    		}
        		
        	} else {

        		$response["response"] = "ERROR";
        		$response["error"]= "Upload Failed!";
        	}

        }

        echo json_encode( $response );
		wp_die();

	}

	function hap_import_playlist_db(){

		if ( ! check_ajax_referer( 'hap-security-nonce', 'security' ) ) {
		    wp_send_json_error( 'Invalid security token sent.' );
		    wp_die();
		}

		if(isset($_POST['playlist'])){

			$playlist = json_decode(stripcslashes($_POST['playlist']), true);

			global $wpdb;
			$wpdb->show_errors(); 
			$charset_collate = $wpdb->get_charset_collate();

		    $playlist_table = $wpdb->prefix . "map_playlists";
			$media_table = $wpdb->prefix . "map_media";
			$taxonomy_table = $wpdb->prefix . "map_taxonomy";
			$media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
			$playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";

			//playlist

			$stmt = $wpdb->insert(
		    	$playlist_table,
				array( 
					'title' => $playlist[1], 
					'options' => $playlist[2]
				), 
				array( 
					'%s','%s'
				) 
		    );

		    $last_playlist_id = $wpdb->insert_id;

		    //playlist tax

		    if(isset($_POST['playlist_taxonomy'])){

		    	$tax = json_decode(stripcslashes($_POST['playlist_taxonomy']), true);

				$len = count($tax);
				for($i=0; $i < $len; $i++){ 
					
					$stmt = $wpdb->insert(
				    	$playlist_taxonomy_table,
						array( 
							'playlist_id' => $last_playlist_id,
							'taxonomy_id' => $tax[$i][2]
						), 
						array( 
							'%d','%d'
						) 
				    );

				}

			}

		    //media

		    if(isset($_POST['media'])){

		    	//media tax

		    	if(isset($_POST['media_taxonomy'])){

			    	$tax = json_decode(stripcslashes($_POST['media_taxonomy']), true);

				    $tax_temp = 'tax_temp'.time();

				    $sql = "CREATE TEMPORARY TABLE {$tax_temp} (
				        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					    `media_id` int(11) unsigned NOT NULL,
					    `playlist_id` int(11) unsigned DEFAULT NULL,
					    `taxonomy_id` int(11) unsigned DEFAULT NULL,
				      PRIMARY KEY (`id`),
				      INDEX `taxonomy_id` (`taxonomy_id`)
				    ) $charset_collate;";
				    $wpdb->query($sql); 

					$len = count($tax);
					for($i=0; $i < $len; $i++){ 
						
						$stmt = $wpdb->insert(
					    	$tax_temp,
							array( 
								'media_id' => $tax[$i][1], 
								'playlist_id' => $last_playlist_id,
								'taxonomy_id' => $tax[$i][3]
							), 
							array( 
								'%d','%d','%d'
							) 
					    );

					}

				}

				//media

		    	$media = json_decode(stripcslashes($_POST['media']), true);

				$len = count($media);
				for($i=0; $i < $len; $i++){ 
					
					$stmt = $wpdb->insert(
				    	$media_table,
						array( 
							'options' => $media[$i][1], 
							'order_id' => $media[$i][2], 
							'playlist_id' => $last_playlist_id
						), 
						array( 
							'%s','%d','%d'
						) 
				    );

				    $old_media_id = $media[$i][0];
				    $last_media_id = $wpdb->insert_id;

				    //media tax

				    if(isset($_POST['media_taxonomy'])){

				        $sql = "INSERT INTO $media_taxonomy_table (id, media_id, playlist_id, taxonomy_id)
				                  SELECT NULL, $last_media_id, playlist_id, taxonomy_id
				                  FROM {$tax_temp} WHERE media_id='$old_media_id'";
				        $wpdb->query($sql); 

				    }	
					

				}

			}

			//drop temp tables
		    if(isset($tax_temp))$wpdb->query("DROP TABLE {$tax_temp}");

	    	//delete files
    		$upload_path = HAP_FILE_DIR."/plzip/";
	        $files = glob($upload_path.'/*'); 
			foreach($files as $file){ 
				if(is_file($file))unlink($file); 
			}

			if($stmt !== false){
	    		echo json_encode('SUCCESS');
	    	}

			wp_die();

		}else {
			wp_die();
		}	

	}

	//############################################//
	/* install */
	//############################################//

	function hap_player_uninstall() {

		global $wpdb;
	    $settings_table = $wpdb->prefix . "map_settings";
	    $result = $wpdb->get_row("SELECT options FROM {$settings_table} WHERE id = '0'", ARRAY_A);

	    if($result){

		    $settings = unserialize($result['options']);
		    $delete_plugin_data_on_uninstall = isset($settings["delete_plugin_data_on_uninstall"]) ? (bool)($settings["delete_plugin_data_on_uninstall"]) : false;

		    if($delete_plugin_data_on_uninstall){

			    if ( is_multisite() ) {

					$site_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE site_id = $wpdb->siteid;" );
					foreach ( $site_ids as $site_id ) {
				        switch_to_blog( $site_id );
				        hap_deinstall();
				        restore_current_blog();
				    }

		    	}else{
		    		hap_deinstall();
		    	}

		    }

    	}
	    
	}

	function hap_deinstall() {
		
		global $wpdb;
		$wpdb->show_errors(); 

		$wpdb->query('SET foreign_key_checks=0');

	    $settings_table = $wpdb->prefix . "map_settings";
	    $sql = "DROP TABLE IF EXISTS $settings_table;";
	    $wpdb->query($sql);

	    $player_table = $wpdb->prefix . "map_players";
	    $sql = "DROP TABLE IF EXISTS $player_table;";
	    $wpdb->query($sql);

	    $statistics_table = $wpdb->prefix . "map_statistics";
	    $sql = "DROP TABLE IF EXISTS $statistics_table;";
	    $wpdb->query($sql);

	    $media_table = $wpdb->prefix . "map_media";
	    $sql = "DROP TABLE IF EXISTS $media_table;";
	    $wpdb->query($sql);

	    $playlist_table = $wpdb->prefix . "map_playlists";
	    $sql = "DROP TABLE IF EXISTS $playlist_table;";
	    $wpdb->query($sql);

	    $ad_table = $wpdb->prefix . "map_ad";
	    $sql = "DROP TABLE IF EXISTS $ad_table;";
	    $wpdb->query($sql);

	    $taxonomy_table = $wpdb->prefix . "map_taxonomy";
		$sql = "DROP TABLE IF EXISTS $taxonomy_table;";
	    $wpdb->query($sql);
		
		$playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";
		$sql = "DROP TABLE IF EXISTS $playlist_taxonomy_table;";
	    $wpdb->query($sql);

		$media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
		$sql = "DROP TABLE IF EXISTS $media_taxonomy_table;";
	    $wpdb->query($sql);

	    $wpdb->query('SET foreign_key_checks=1');

		delete_option('map_audio_player_version');
	}

	function hap_player_activate($network_wide){

		global $wpdb;

		if ( is_multisite() ) {

    		if ($network_wide) {
    			$site_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs WHERE site_id = $wpdb->siteid;" );
    			foreach ( $site_ids as $site_id ) {
			        switch_to_blog( $site_id );
			        hap_install();
			        restore_current_blog();
			    }
    		}else{
    			hap_install();
    		}

    	}else{
    		hap_install();
    	}

	}

	function hap_install(){

		//file dir for reading audio files from directory
		if(!file_exists(HAP_FILE_DIR))wp_mkdir_p(HAP_FILE_DIR);

		//database
		global $wpdb;
		$wpdb->show_errors(); 
		$charset_collate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$settings_table = $wpdb->prefix . "map_settings";
		if($wpdb->get_var( "show tables like '$settings_table'" ) != $settings_table){

			$sql = "CREATE TABLE $settings_table ( 
				`id` tinyint NOT NULL,
			    `options` text DEFAULT NULL,
			    PRIMARY KEY (`id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$player_table = $wpdb->prefix . "map_players";
		if($wpdb->get_var( "show tables like '$player_table'" ) != $player_table){

			$sql = "CREATE TABLE $player_table ( 
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			    `title` varchar(100) NOT NULL,
			    `preset` varchar(25) NOT NULL,
			    `options` longtext DEFAULT NULL,
			    `custom_css` longtext DEFAULT NULL,
			    `custom_js` longtext DEFAULT NULL,
			    PRIMARY KEY (`id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$playlist_table = $wpdb->prefix . "map_playlists";
		if($wpdb->get_var( "show tables like '$playlist_table'" ) != $playlist_table){

			$sql = "CREATE TABLE $playlist_table (
			    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`title` varchar(100) NOT NULL,
				`options` text DEFAULT NULL,
			    PRIMARY KEY (`id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$media_table = $wpdb->prefix . "map_media";
		if($wpdb->get_var( "show tables like '$media_table'" ) != $media_table){

			$sql = "CREATE TABLE $media_table (
			    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			    `options` longtext DEFAULT NULL,
			    `order_id` int(11) unsigned DEFAULT NULL,
			    `playlist_id` int(11) unsigned NOT NULL,
			    PRIMARY KEY (`id`),
			    INDEX `playlist_id` (`playlist_id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$ad_table = $wpdb->prefix . "map_ad";
		if($wpdb->get_var( "show tables like '$ad_table'" ) != $ad_table){

			$sql = "CREATE TABLE $ad_table (
			    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			    `title` varchar(100) NOT NULL,
			    `options` longtext DEFAULT NULL,
			    PRIMARY KEY (`id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$statistics_table = $wpdb->prefix . "map_statistics";
		if($wpdb->get_var( "show tables like '$statistics_table'" ) != $statistics_table){

			$sql = "CREATE TABLE $statistics_table ( 
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`origtype` varchar(15),
				`title` varchar(300),
		    	`artist` varchar(100),
		    	`album` varchar(100),
		    	`thumb` varchar(300),
		    	`audio_url` varchar(300),
			    `c_play` int(11) unsigned,
			    `c_time` int(11) unsigned,
			    `c_like` int(11) unsigned,
			    `c_download` int(11),
			    `c_finish` int(11) unsigned,
			    `skipped_first_minute` int(11) unsigned DEFAULT '0',
			    `c_date` date,
			    `c_user_ip` varchar(50),
			    `media_id` int(11) unsigned,
			    `playlist_id` int(11) unsigned,
			    `player_id` int(11) unsigned,
			    PRIMARY KEY (`id`),
			    INDEX `media_id` (`media_id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$taxonomy_table = $wpdb->prefix . "map_taxonomy";
		if($wpdb->get_var( "show tables like '$taxonomy_table'" ) != $taxonomy_table){

			$sql = "CREATE TABLE $taxonomy_table ( 
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`type` varchar(15) DEFAULT NULL,
		    	`title` varchar(100) DEFAULT NULL,
		    	`description` varchar(500) DEFAULT NULL,
			    PRIMARY KEY (`id`)
			) $charset_collate;";
			dbDelta( $sql );

		}
		
		$playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";
		if($wpdb->get_var( "show tables like '$playlist_taxonomy_table'" ) != $playlist_taxonomy_table){

			$sql = "CREATE TABLE $playlist_taxonomy_table ( 
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			    `playlist_id` int(11) unsigned DEFAULT NULL,
			    `taxonomy_id` int(11) unsigned DEFAULT NULL,
			    PRIMARY KEY (`id`),
			    INDEX `taxonomy_id` (`taxonomy_id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
		if($wpdb->get_var( "show tables like '$media_taxonomy_table'" ) != $media_taxonomy_table){

			$sql = "CREATE TABLE $media_taxonomy_table ( 
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			    `media_id` int(11) unsigned NULL NULL,
			    `playlist_id` int(11) unsigned DEFAULT NULL,
			    `taxonomy_id` int(11) unsigned DEFAULT NULL,
			    PRIMARY KEY (`id`),
			    INDEX `taxonomy_id` (`taxonomy_id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

	}

	function hap_plugins_loaded() {

		load_plugin_textdomain(HAP_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');



	    $current_version = get_option('map_audio_player_version');

	    if($current_version == FALSE){
	    	update_option('map_audio_player_version', '3.0');
	    }
	    
	    $current_version = get_option('map_audio_player_version');

		global $wpdb;
		$wpdb->show_errors(); 
		$charset_collate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$settings_table = $wpdb->prefix . "map_settings";
		$media_table = $wpdb->prefix . "map_media";
		$player_table = $wpdb->prefix . "map_players";
		$playlist_table = $wpdb->prefix . "map_playlists";
		$statistics_table = $wpdb->prefix . "map_statistics";
		$ad_table = $wpdb->prefix . "map_ad";

		$taxonomy_table = $wpdb->prefix . "map_taxonomy";
		$media_taxonomy_table = $wpdb->prefix . "map_media_taxonomy";
		$playlist_taxonomy_table = $wpdb->prefix . "map_playlist_taxonomy";

		

	    if($current_version == '3.0'){

	    	update_option('map_audio_player_version', 3.01);
			$current_version = get_option('map_audio_player_version');

	    }
	    if($current_version == '3.01'){

	    	update_option('map_audio_player_version', 3.1);
			$current_version = get_option('map_audio_player_version');

	    }
	    if($current_version == '3.1'){

	    	update_option('map_audio_player_version', 3.2);
			$current_version = get_option('map_audio_player_version');

	    }
	    if($current_version == '3.2'){

	    	update_option('map_audio_player_version', 3.3);
			$current_version = get_option('map_audio_player_version');

	    }
	    if($current_version == '3.3'){

	    	update_option('map_audio_player_version', 3.35);
			$current_version = get_option('map_audio_player_version');

	    }
	    if($current_version == '3.35'){

	    	//safe column names

	    	$sql = "SHOW COLUMNS FROM {$statistics_table} LIKE 'origtype'";
	    	$result = $wpdb->query($sql);

		    if($wpdb->num_rows == 0){

		    	$sql = "ALTER TABLE {$statistics_table} 
		    	ADD COLUMN `origtype` varchar(15) DEFAULT NULL,
		    	CHANGE COLUMN `play` c_play int(11) unsigned,
		    	CHANGE COLUMN `time` c_time int(11) unsigned,
		    	CHANGE COLUMN `like` c_like int(11) unsigned,
		    	CHANGE COLUMN `download` c_download int(11) unsigned,
		    	CHANGE COLUMN `finish` c_finish int(11) unsigned,
		    	CHANGE COLUMN `date` c_date date,
		    	CHANGE COLUMN `user_ip` c_user_ip varchar(50)";

			    $result = $wpdb->query($sql);

			}

	    	update_option('map_audio_player_version', 3.7);
			$current_version = get_option('map_audio_player_version');

	    }
	    if($current_version == '3.7'){


			//ad table

			$ad_table = $wpdb->prefix . "map_ad";
			if($wpdb->get_var( "show tables like '$ad_table'" ) != $ad_table){

				$sql = "CREATE TABLE $ad_table (
				    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				    `title` varchar(100) NOT NULL,
				    `options` longtext NOT NULL,
				    PRIMARY KEY (`id`)
				) $charset_collate;";
				dbDelta( $sql );

			}

			update_option('map_audio_player_version', 3.7);
			$current_version = get_option('map_audio_player_version');

		}
		if($current_version == '3.7'){

			update_option('map_audio_player_version', 3.71);
			$current_version = get_option('map_audio_player_version');

		}
		if($current_version == '3.71'){

			update_option('map_audio_player_version', 4.0);
			$current_version = get_option('map_audio_player_version');

		}
		if($current_version == '4.0'){
			update_option('map_audio_player_version', 4.05);
			$current_version = get_option('map_audio_player_version');
		}
		if($current_version == '4.05'){

			//custom javascript

			$sql = "SHOW COLUMNS FROM {$player_table} LIKE 'custom_js'";
	    	$result = $wpdb->query($sql);

	    	if($wpdb->num_rows == 0){
	    		$sql = "ALTER TABLE {$player_table} ADD COLUMN `custom_js` longtext DEFAULT NULL";
	    		$result = $wpdb->query($sql);
	    	}

			if($wpdb->get_var( "show tables like '$taxonomy_table'" ) != $taxonomy_table){

				$sql = "CREATE TABLE $taxonomy_table ( 
					`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					`type` varchar(15) DEFAULT NULL,
			    	`title` varchar(100) DEFAULT NULL,
			    	`description` varchar(500) DEFAULT NULL,
				    PRIMARY KEY (`id`)
				) $charset_collate;";
				dbDelta( $sql );

			}
			
			if($wpdb->get_var( "show tables like '$playlist_taxonomy_table'" ) != $playlist_taxonomy_table){

				$sql = "CREATE TABLE $playlist_taxonomy_table ( 
					`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				    `playlist_id` int(11) unsigned DEFAULT NULL,
				    `taxonomy_id` int(11) unsigned DEFAULT NULL,
				    PRIMARY KEY (`id`),
				    INDEX `taxonomy_id` (`taxonomy_id`)
				) $charset_collate;";
				dbDelta( $sql );

			}

			if($wpdb->get_var( "show tables like '$media_taxonomy_table'" ) != $media_taxonomy_table){

				$sql = "CREATE TABLE $media_taxonomy_table ( 
					`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				    `media_id` int(11) unsigned NULL NULL,
				    `playlist_id` int(11) unsigned DEFAULT NULL,
				    `taxonomy_id` int(11) unsigned DEFAULT NULL,
				    PRIMARY KEY (`id`),
				    INDEX `taxonomy_id` (`taxonomy_id`)
				) $charset_collate;";
				dbDelta( $sql );

			}

			update_option('map_audio_player_version', 4.4);
			$current_version = get_option('map_audio_player_version');

		}
		if($current_version == '4.4'){
			update_option('map_audio_player_version', 4.5);
			$current_version = get_option('map_audio_player_version');
		}
		if($current_version == '4.5'){
			update_option('map_audio_player_version', 4.51);
			$current_version = get_option('map_audio_player_version');
		}
		if($current_version == '4.51'){

			//stat

			$sql = "ALTER TABLE {$statistics_table} MODIFY COLUMN `media_id` int(11) unsigned DEFAULT NULL;";
			$result = $wpdb->query($sql);



			//merge media path

			$media_data = $wpdb->get_results("SELECT id, options FROM {$media_table}", ARRAY_A);

	    	foreach ($media_data as $d) { 

				$options = unserialize($d['options']);

				if($options['type'] == 'audio'){
					if(!hap_nullOrEmpty($options['mp3']))$options['path'] = $options['mp3'];
					else if(!hap_nullOrEmpty($options['wav']))$options['path'] = $options['wav'];
					else if(!hap_nullOrEmpty($options['aac']))$options['path'] = $options['aac'];
					else if(!hap_nullOrEmpty($options['flac']))$options['path'] = $options['flac'];
				}
		    	
			    $stmt = $wpdb->update(
			    	$media_table,
					array('options' => serialize($options)), 
					array('id' => $d['id']),
					array('%s'),
					array('%d')
		    	);

			}

			update_option('map_audio_player_version', 5.0);
			$current_version = get_option('map_audio_player_version');

		}
		if($current_version == '5.0'){
			update_option('map_audio_player_version', 5.1);
			$current_version = get_option('map_audio_player_version');
		}
		if($current_version == '5.1'){
			update_option('map_audio_player_version', 5.11);
			$current_version = get_option('map_audio_player_version');
		}
		
		//change version number tracking


    	$sql = "SHOW COLUMNS FROM {$statistics_table} LIKE 'player_id'";
    	$result = $wpdb->query($sql);

	    if($wpdb->num_rows == 0){
	    	$sql = "ALTER TABLE {$statistics_table} ADD COLUMN `player_id` int(11) unsigned";
		    $result = $wpdb->query($sql);
		}

		$sql = "SHOW COLUMNS FROM {$statistics_table} LIKE 'thumb'";
    	$result = $wpdb->query($sql);

	    if($wpdb->num_rows == 0){
	    	$sql = "ALTER TABLE {$statistics_table} ADD COLUMN `thumb` varchar(300)";
		    $result = $wpdb->query($sql);
		}

		$sql = "SHOW COLUMNS FROM {$statistics_table} LIKE 'album'";
    	$result = $wpdb->query($sql);

	    if($wpdb->num_rows == 0){
	    	$sql = "ALTER TABLE {$statistics_table} ADD COLUMN `album` varchar(100)";
		    $result = $wpdb->query($sql);
		}

		$sql = "SHOW COLUMNS FROM {$statistics_table} LIKE 'skipped_first_minute'";
    	$result = $wpdb->query($sql);

	    if($wpdb->num_rows == 0){
	    	$sql = "ALTER TABLE {$statistics_table} ADD COLUMN `skipped_first_minute` int(11) unsigned DEFAULT '0'";
		    $result = $wpdb->query($sql);
		}

		$sql = "SHOW COLUMNS FROM {$statistics_table} LIKE 'audio_url'";
    	$result = $wpdb->query($sql);

	    if($wpdb->num_rows == 0){
	    	$sql = "ALTER TABLE {$statistics_table} ADD COLUMN `audio_url` varchar(300)";
		    $result = $wpdb->query($sql);
		}

		$statistics_country_table = $wpdb->prefix . "map_statistics_country";
		if($wpdb->get_var( "show tables like '$statistics_country_table'" ) != $statistics_country_table){

			$sql = "CREATE TABLE $statistics_country_table ( 
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`country` varchar(100),
				`country_code` varchar(10),
				`continent` varchar(15),
			    PRIMARY KEY (`id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$statistics_country_play_table = $wpdb->prefix . "map_statistics_country_play";
		if($wpdb->get_var( "show tables like '$statistics_country_play_table'" ) != $statistics_country_play_table){

			$sql = "CREATE TABLE $statistics_country_play_table ( 
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`title` varchar(300),
		    	`artist` varchar(100),
		    	`album` varchar(100),
		    	`thumb` varchar(300),
		    	`audio_url` varchar(300),
			    `c_play` int(11) unsigned,
			    `c_time` int(11) unsigned,
			    `c_date` date,
			    `media_id` int(11) unsigned,
			    `playlist_id` int(11) unsigned,
			    `player_id` int(11) unsigned,
			    `country_id` int(11) unsigned,
			    PRIMARY KEY (`id`),
			    INDEX `media_id` (`media_id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$statistics_user_table = $wpdb->prefix . "map_statistics_user";
		if($wpdb->get_var( "show tables like '$statistics_user_table'" ) != $statistics_user_table){

			$sql = "CREATE TABLE $statistics_user_table ( 
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`user_id` smallint(11) unsigned,
				`user_display_name` varchar(100),
				`user_role` varchar(50),
			    PRIMARY KEY (`id`),
			    INDEX `user_id` (`user_id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

		$statistics_user_play_table = $wpdb->prefix . "map_statistics_user_play";
		if($wpdb->get_var( "show tables like '$statistics_user_play_table'" ) != $statistics_user_play_table){

			$sql = "CREATE TABLE $statistics_user_play_table ( 
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`title` varchar(300),
		    	`artist` varchar(100),
		    	`album` varchar(100),
		    	`thumb` varchar(300),
		    	`audio_url` varchar(300),
			    `c_play` int(11) unsigned,
			    `c_time` int(11) unsigned,
			    `c_date` date,
			    `media_id` int(11) unsigned,
			    `playlist_id` int(11) unsigned,
			    `player_id` int(11) unsigned,
			    `user_id` int(11) unsigned,
			    PRIMARY KEY (`id`),
			    INDEX `media_id` (`media_id`)
			) $charset_collate;";
			dbDelta( $sql );

		}

	


			

		update_option('map_audio_player_version', 5.81);
		$current_version = get_option('map_audio_player_version');


	}

?>
