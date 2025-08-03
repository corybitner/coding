<?php
/*
Plugin Name: Simple Audio Player
Plugin URI: https://github.com/corybitner/simple-audio-player
Description: A lightweight audio player with M3U playlist support, keyboard controls, and modern design
Version: 1.0.0
Author: Cory Bitner
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

define('SAP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SAP_PLUGIN_PATH', plugin_dir_path(__FILE__));

class SimpleAudioPlayer {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('simple_audio_playlist', array($this, 'render_playlist'));
        add_action('wp_ajax_sap_upload_m3u', array($this, 'handle_m3u_upload'));
        add_action('wp_ajax_nopriv_sap_upload_m3u', array($this, 'handle_m3u_upload'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        // Enable M3U file uploads
        add_filter('upload_mimes', array($this, 'allow_m3u_uploads'));
    }
    
    public function allow_m3u_uploads($mimes) {
        $mimes['m3u'] = 'audio/x-mpegurl';
        $mimes['m3u8'] = 'application/x-mpegURL';
        return $mimes;
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('sap-player', SAP_PLUGIN_URL . 'js/simple-player.js', array('jquery'), '1.0.0', true);
                   wp_enqueue_style('sap-player-styles', SAP_PLUGIN_URL . 'css/player-styles.css', array(), '1.0.0');
        
        wp_localize_script('sap-player', 'sap_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('sap_nonce')
        ));
    }
    
    public function render_playlist($atts) {
        $atts = shortcode_atts(array(
            'file' => '',
            'width' => '100%',
            'height' => 'auto',
            'autoplay' => false,
            'theme' => 'light' // light or dark
        ), $atts);
        
        if (empty($atts['file'])) {
            return '<p>Error: Please specify an M3U file.</p>';
        }
        
        $playlist_data = $this->parse_m3u_file($atts['file']);
        if (empty($playlist_data)) {
            return '<p>Error: Could not load playlist file.</p>';
        }
        
        $player_id = 'sap-player-' . uniqid();
        $theme_class = $atts['theme'] === 'dark' ? 'sap-dark' : 'sap-light';
        
        ob_start();
        ?>
        <div id="<?php echo esc_attr($player_id); ?>" class="sap-player-wrapper <?php echo esc_attr($theme_class); ?>" 
             style="width: <?php echo esc_attr($atts['width']); ?>; height: <?php echo esc_attr($atts['height']); ?>;">
            
            <!-- Main Player -->
            <div class="sap-player-main">
                <div class="sap-artwork">
                    <img src="" alt="Album Art" class="sap-album-art" />
                    <div class="sap-artwork-overlay">
                        <div class="sap-play-pause-btn">
                            <i class="sap-icon sap-icon-play"></i>
                        </div>
                    </div>
                </div>
                
                <div class="sap-player-controls">
                    <div class="sap-track-info">
                        <div class="sap-track-title">Select a track</div>
                        <div class="sap-track-artist"></div>
                    </div>
                    
                    <div class="sap-controls-bar">
                        <button class="sap-btn sap-prev-btn" title="Previous (P)">
                            <i class="sap-icon sap-icon-prev"></i>
                        </button>
                        <button class="sap-btn sap-play-pause-main" title="Play/Pause (Space)">
                            <i class="sap-icon sap-icon-play"></i>
                        </button>
                        <button class="sap-btn sap-next-btn" title="Next (N)">
                            <i class="sap-icon sap-icon-next"></i>
                        </button>
                        
                        <div class="sap-progress-container">
                            <div class="sap-time-current">0:00</div>
                            <div class="sap-seekbar">
                                <div class="sap-seekbar-bg"></div>
                                <div class="sap-seekbar-buffer"></div>
                                <div class="sap-seekbar-progress"></div>
                                <div class="sap-seekbar-handle"></div>
                            </div>
                            <div class="sap-time-total">0:00</div>
                        </div>
                        
                        <div class="sap-volume-container">
                            <button class="sap-btn sap-volume-btn" title="Mute (M)">
                                <i class="sap-icon sap-icon-volume"></i>
                            </button>
                            <div class="sap-volume-slider">
                                <div class="sap-volume-bg"></div>
                                <div class="sap-volume-level"></div>
                                <div class="sap-volume-handle"></div>
                            </div>
                        </div>
                        
                                                       <button class="sap-btn sap-speed-btn" title="Playback Speed (S)">1x</button>
                    </div>
                </div>
            </div>
            
            <!-- Playlist -->
            <div class="sap-playlist">
                <div class="sap-playlist-header">
                    <h3>Playlist</h3>
                    <div class="sap-playlist-count">
                        <span class="sap-track-count"><?php echo count($playlist_data); ?></span> tracks
                    </div>
                </div>
                <div class="sap-playlist-items">
                    <?php foreach ($playlist_data as $index => $track): ?>
                        <div class="sap-playlist-item" data-index="<?php echo $index; ?>" 
                             data-src="<?php echo esc_attr($track['url']); ?>"
                             data-title="<?php echo esc_attr($track['title']); ?>"
                             data-artist="<?php echo esc_attr($track['artist']); ?>"
                             data-duration="<?php echo esc_attr($track['duration']); ?>">
                            
                            <div class="sap-item-number"><?php echo $index + 1; ?></div>
                            <div class="sap-item-info">
                                <div class="sap-item-title"><?php echo esc_html($track['title']); ?></div>
                                <div class="sap-item-artist"><?php echo esc_html($track['artist']); ?></div>
                            </div>
                            <div class="sap-item-duration"><?php echo esc_html($track['duration']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Hidden Audio Element -->
            <audio class="sap-audio-element" preload="metadata"></audio>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            new SimpleAudioPlayer('<?php echo $player_id; ?>', {
                autoplay: <?php echo $atts['autoplay'] ? 'true' : 'false'; ?>,
                theme: '<?php echo esc_js($atts['theme']); ?>',
                keyboardControls: true
            });
        });
        </script>
        <?php
        return ob_get_clean();
    }
    
    private function parse_m3u_file($file_path) {
        // Handle both URL and file path
        if (filter_var($file_path, FILTER_VALIDATE_URL)) {
            $content = wp_remote_get($file_path);
            if (is_wp_error($content)) {
                return array();
            }
            $content = wp_remote_retrieve_body($content);
        } else {
            // Try to find file in uploads directory
            $upload_dir = wp_upload_dir();
            $full_path = $upload_dir['basedir'] . '/' . ltrim($file_path, '/');
            
            if (!file_exists($full_path)) {
                return array();
            }
            
            $content = file_get_contents($full_path);
        }
        
        if (empty($content)) {
            return array();
        }
        
        return $this->parse_m3u_content($content);
    }
    
    private function parse_m3u_content($content) {
        $lines = explode("\n", $content);
        $playlist = array();
        $current_track = array();
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            if (empty($line) || $line[0] === '#') {
                // Handle #EXTINF lines
                if (strpos($line, '#EXTINF:') === 0) {
                    preg_match('/#EXTINF:([^,]*),(.*)/', $line, $matches);
                    if (count($matches) >= 3) {
                        $duration = trim($matches[1]);
                        $title_artist = trim($matches[2]);
                        
                        // Parse title and artist
                        if (strpos($title_artist, ' - ') !== false) {
                            $parts = explode(' - ', $title_artist, 2);
                            $current_track['artist'] = $parts[0];
                            $current_track['title'] = $parts[1];
                        } else {
                            $current_track['artist'] = '';
                            $current_track['title'] = $title_artist;
                        }
                        
                        $current_track['duration'] = $this->format_duration($duration);
                    }
                }
                continue;
            }
            
            // This is a URL/file path
            if (!empty($line)) {
                $current_track['url'] = $line;
                
                // If no title was set from EXTINF, use filename
                if (empty($current_track['title'])) {
                    $filename = basename($line);
                    $current_track['title'] = pathinfo($filename, PATHINFO_FILENAME);
                    $current_track['artist'] = '';
                    $current_track['duration'] = '';
                }
                
                $playlist[] = $current_track;
                $current_track = array();
            }
        }
        
        return $playlist;
    }
    
    private function format_duration($seconds) {
        if (empty($seconds) || !is_numeric($seconds)) {
            return '';
        }
        
        $seconds = (int)$seconds;
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }
    
    public function handle_m3u_upload() {
        check_ajax_referer('sap_nonce', 'nonce');
        
        if (!isset($_FILES['m3u_file'])) {
            wp_die('No file uploaded');
        }
        
        $upload = wp_handle_upload($_FILES['m3u_file'], array('test_form' => false));
        
        if (isset($upload['error'])) {
            wp_die('Upload error: ' . $upload['error']);
        }
        
        wp_send_json_success(array(
            'file_url' => $upload['url'],
            'file_path' => $upload['file']
        ));
    }
    
    public function activate() {
        // Create upload directory for M3U files
        $upload_dir = wp_upload_dir();
        $sap_dir = $upload_dir['basedir'] . '/simple-audio-playlists';
        
        if (!file_exists($sap_dir)) {
            wp_mkdir_p($sap_dir);
        }
    }
    
    public function deactivate() {
        // Clean up if needed
    }
}

// Initialize the plugin
new SimpleAudioPlayer();