<?php

if (!defined('ABSPATH')) exit;

// This widget ads a player with a playlist to the page.

if (!class_exists('ModernAudioPlayerWidget')) {
    class ModernAudioPlayerWidget extends WP_Widget {
     
        function __construct() {
            parent::__construct( 'map-player-widget',
             __( 'Modern Audio Player', HAP_TEXTDOMAIN ),
             array( 'description' => __( 'Add player with playlist in your website.', HAP_TEXTDOMAIN )) 
            ); 
        }
     
        function widget( $args, $instance ) {

            extract($instance, EXTR_SKIP);

            echo $args['before_widget'];
            if ( ! empty( $instance['title'] ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
            }

            if (!empty($instance['player_id']) && !empty($instance['playlist_id'])) {
                echo do_shortcode('[apmap player_id="'. $instance['player_id'] .'" playlist_id="'. $instance['playlist_id'] .'"]');
            }

            echo $args['after_widget'];

        }
     
        function form( $instance ) {

            global $wpdb;
            $player_table = $wpdb->prefix . "map_players";
            $playlist_table = $wpdb->prefix . "map_playlists";

            //load players
            $players = $wpdb->get_results("SELECT id, title FROM {$player_table} ORDER BY title ASC", ARRAY_A);

            if ($wpdb->num_rows > 0) {?>

                <p>
                    <label for="<?php echo $this->get_field_id('player_id'); ?>"><?php _e('Select player:', HAP_TEXTDOMAIN); ?></label>
                    <select class='widefat' id="<?php echo $this->get_field_id('player_id'); ?>" name="<?php echo $this->get_field_name('player_id'); ?>">
                        <option value="">— Select —</option>
                        <?php foreach($players as $player) : ?>
                            <option value="<?php echo($player['id']); ?>"<?php echo (!empty($instance['player_id']) && $instance['player_id'] == $player['id']) ? ' selected' : ''; ?>><?php echo($player['title']); ?></option>
                        <?php endforeach; ?>    
                    </select>
                </p>

            <?php } else { ?>
                <p>

                    <?php _e('Please create a player.', HAP_TEXTDOMAIN); ?>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=hap_player_manager&action=add_player')); ?>"><?php _e('Create a player.', HAP_TEXTDOMAIN); ?></a>
                </p>
            <?php }

            //load playlists
            $playlists = $wpdb->get_results("SELECT id, title FROM {$playlist_table} ORDER BY title ASC", ARRAY_A);

            if ($wpdb->num_rows > 0) {?>

                <p>
                    <label for="<?php echo $this->get_field_id('playlist_id'); ?>"><?php _e('Select playlist:', HAP_TEXTDOMAIN); ?></label>
                    <select class='widefat' id="<?php echo $this->get_field_id('playlist_id'); ?>" name="<?php echo $this->get_field_name('playlist_id'); ?>">
                        <option value="">— Select —</option>
                        <?php foreach($playlists as $playlist) : ?>
                            <option value="<?php echo($playlist['id']); ?>"<?php echo (!empty($instance['playlist_id']) && $instance['playlist_id'] == $playlist['id']) ? ' selected' : ''; ?>><?php echo($playlist['title']); ?></option>
                        <?php endforeach; ?>    
                    </select>
                </p>
                
            <?php } else { ?>
                <p>

                    <?php _e('Please create a playlist.', HAP_TEXTDOMAIN); ?>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=hap_playlist_manager&action=add_playlist')); ?>"><?php _e('Create a playlist.', HAP_TEXTDOMAIN); ?></a>
                </p>
            <?php }

        }

        function update( $new_instance, $old_instance ) {

            $instance = $old_instance;
            $instance['player_id'] = !empty($new_instance['player_id']) ? $new_instance['player_id'] : '';
            $instance['playlist_id'] = !empty($new_instance['playlist_id']) ? $new_instance['playlist_id'] : '';

            return $instance;

        }
    }
}
?>
