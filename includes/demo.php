<?php 

$examples = array(

	'brona_light' => 'Brona light skin, playlist opened on start',

	'art_narrow_dark' => 'Art narrow dark skin, suitable for narrow layouts, player opened on start',

	'metalic' => 'Metalic skin',

	'poster' => 'Poster skin (only player artwork, no visible playlist), single audio playing',

	'tiny' => 'Tiny skin (small players for limited space)',

	'grid' => 'Grid skin, description below thumbnail, load more button, with skicky player at page bottom',
    
);

?>

<div class="wrap">
<th><?php esc_html_e('Actions', HAP_TEXTDOMAIN); ?></th>
	<h2><?php esc_html_e('Quick Import examples', HAP_TEXTDOMAIN); ?></h2>

	<p><?php esc_html_e('Here are some demo examples on different player styles. For more details on shortcodes, check section and plugin documentation.', HAP_TEXTDOMAIN); ?> <a href='<?php echo admin_url("admin.php?page=hap_shortcodes"); ?>'><?php esc_html_e('Shortcode section', HAP_TEXTDOMAIN); ?></a> </p>

	<p><strong><a href='<?php echo admin_url("admin.php?page=hap_settings"); ?>'><?php esc_html_e('Note: if you are using Soundcloud, Google Drive or Youtube set API keys in Credentials', HAP_TEXTDOMAIN); ?></a></strong></p>

	<select id="style-imports" style="min-width: 900px;">
		<?php foreach ($examples as $key => $value) : ?>
            <option value="<?php echo($key); ?>"><?php echo($value);?></option>
		<?php endforeach; ?>	
	</select>

	<img id="hap-sample-import" src="" alt=""/>

	<p><strong><?php esc_html_e('Shortcode:', HAP_TEXTDOMAIN); ?></strong></p>

	<textarea class="hap-demo-sc" id="brona_light" style="width: 70%;" rows="3">
[apmap preset="brona_light" playlist_opened="1" playlist_item_content="thumb,title,description,duration,date"][apmap_audio type="podcast" path="http://robertkelly.libsyn.com/rss" limit="20" load_more="1" encrypt_media_paths="1"][/apmap]
</textarea>

	<textarea class="hap-demo-sc" id="art_narrow_dark" style="width: 70%;" rows="3">[apmap preset="art_narrow_dark" playlist_opened="0" playlist_item_content="thumb,title,description,duration,date"][apmap_audio type="podcast" path="http://robertkelly.libsyn.com/rss" limit="20" load_more="1" encrypt_media_paths="1"][/apmap]</textarea>

	<textarea class="hap-demo-sc" id="metalic" style="width: 70%;" rows="3">[apmap preset="metalic" playlist_opened="0" playlist_item_content="thumb,title,description,duration,date"][apmap_audio type="podcast" path="http://robertkelly.libsyn.com/rss" limit="20" load_more="1" encrypt_media_paths="1"][/apmap]</textarea>

	<textarea class="hap-demo-sc" id="poster" style="width: 70%;" rows="3">[apmap preset="poster"][apmap_audio type="audio" path="AUDIO_URL_HERE" thumb="POSTER_URL" encrypt_media_paths="1"][/apmap]</textarea>

	<textarea class="hap-demo-sc" id="tiny" style="width: 70%;" rows="3">[apmap preset="tiny_dark_1"][apmap_audio type="audio" path="AUDIO_URL_HERE" encrypt_media_paths="1"][/apmap]</textarea>

	<textarea class="hap-demo-sc" id="grid" style="width: 70%;" rows="3">[apmap preset="grid" info_skin="info-dbt" playlist_item_content="thumb,title,description" use_fixed_player="1" fixed_player_opened="1" fixed_player_theme="light"][apmap_audio type="podcast" path="http://robertkelly.libsyn.com/rss" limit="8" load_more="1" encrypt_media_paths="1"][/apmap]</textarea>



	


</div>