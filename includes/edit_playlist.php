<?php 

if(isset($_GET['hap_msg'])){
	$msg = $_GET['hap_msg'];
	if($msg == 'playlist_created')$msg = __('Playlist created!', HAP_TEXTDOMAIN); 
}else{
	$msg = null;
}

$playlist_taxonomy = array();

if(isset($_GET['playlist_id'])){//load media

	$playlist_id = $_GET['playlist_id'];

	//playlist data
	$stmt = $wpdb->prepare("SELECT title, options FROM {$playlist_table} WHERE id = %d", $playlist_id);
	$playlist_data = $wpdb->get_row($stmt, ARRAY_A);

	$pl_options = unserialize($playlist_data['options']);
	$default_playlist_options = hap_playlist_options();
	if(!$pl_options){
		$playlist_options = $default_playlist_options;
	}else{
		$playlist_options = $pl_options + $default_playlist_options;
	}


	//media
    $stmt = $wpdb->prepare("SELECT mt.id, mt.options, mt.order_id,
	GROUP_CONCAT(CASE WHEN tt.type = 'category' THEN tt.title END ORDER BY tt.title SEPARATOR ', ') as category,
	GROUP_CONCAT(CASE WHEN tt.type = 'tag' THEN tt.title END ORDER BY tt.title SEPARATOR ', ') as tag
	FROM $media_table as mt
	LEFT JOIN $media_taxonomy_table mtt on mt.id = mtt.media_id 
	LEFT JOIN $taxonomy_table tt ON mtt.taxonomy_id = tt.id
	WHERE mt.playlist_id = %d 
	GROUP BY mt.id
	ORDER BY order_id ASC", $playlist_id);

	$medias = $wpdb->get_results($stmt, ARRAY_A);


	//playlist tax
    $stmt = $wpdb->prepare("SELECT tt.id, tt.type, tt.title
    FROM $taxonomy_table as tt
    LEFT JOIN $playlist_taxonomy_table ptt on ptt.taxonomy_id = tt.id 
    WHERE playlist_id = %d ORDER BY tt.title ASC", $playlist_id);

    $playlist_taxonomy = $wpdb->get_results($stmt, ARRAY_A);

}

//all tax
$map_taxonomy = $wpdb->get_results("SELECT id, title, type FROM {$taxonomy_table} ORDER BY title ASC", ARRAY_A);

?>

<script type="text/javascript">
    var map_all_playlist_taxonomy = <?php echo(json_encode($map_taxonomy, JSON_HEX_TAG)); ?>;
    var map_playlist_taxonomy = <?php echo(json_encode($playlist_taxonomy, JSON_HEX_TAG)); ?>;
</script>

<div class="wrap">

	<?php include("notice.php"); ?>

	<h2><?php esc_html_e('Edit playlist', HAP_TEXTDOMAIN); ?> <span style="color:#FF0000; font-weight:bold;"><?php echo($playlist_data['title']); echo(' - ID #' . $playlist_id); ?></span></h2>

	<div class="hap-admin" data-playlist-id="<?php echo($playlist_id); ?>">

		<div class="option-tab">

		    <div class="option-toggle">
		        <span class="option-title"><?php esc_html_e('Playlist options', HAP_TEXTDOMAIN); ?></span>

		        <div class="option-toggle-icon">
	                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" ><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
	            </div>
		    </div>

		    <div class="option-content">

			    <form id="hap-edit-playlist-form" method="post" enctype="multipart/form-data" action="<?php echo admin_url("admin.php?page=hap_playlist_manager&action=edit_playlist&playlist_id=".$playlist_id); ?>">

			    <div id="hap-playlist-options-tabs">

				    <div class="hap-tab-header">
				        <div id="hap-tab-playlist-options-general"><?php esc_html_e('General', HAP_TEXTDOMAIN); ?></div>
				        <div id="hap-tab-playlist-options-global"><?php esc_html_e('Global options', HAP_TEXTDOMAIN); ?></div>
				    </div>

				    <div id="hap-tab-playlist-options-general-content" class="hap-tab-content">
			    		
				    	<table class="form-table" >

				    		<tr valign="top">
								<th><?php esc_html_e('Playlist thumbnail', HAP_TEXTDOMAIN); ?></th>
								<td>
									<img id="pl_thumb_preview" class="hap-img-preview" src="<?php echo (isset($playlist_options['thumb']) ? esc_html($playlist_options['thumb']) : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D'); ?>" alt="">
									<input type="text" id="pl_thumb" name="thumb" value="<?php echo (isset($playlist_options['thumb']) ? $playlist_options['thumb'] : ''); ?>"> 
									<button id="pl_thumb_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
		                			<button id="pl_thumb_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button> 
									<p class="info"><?php esc_html_e('Set playlist thumbnail', HAP_TEXTDOMAIN); ?></p>
								</td>
							</tr>

							<tr valign="top">
								<th><?php esc_html_e('Playlist description', HAP_TEXTDOMAIN); ?></th>
								<td>
									<textarea id="pl_description" name="description" rows="3" ><?php echo (isset($playlist_options['description']) ? $playlist_options['description'] : ''); ?></textarea>
								</td>
							</tr>

							<tr valign="top">
		                        <th><?php esc_html_e('Playlist genre', HAP_TEXTDOMAIN); ?></th>
		                        <td>
		                        	<div id="hap-playlist-category-wrap"></div>
		                            <button type="button" id="hap-playlist-category"><?php esc_html_e('Add genre', HAP_TEXTDOMAIN); ?></button>
		                        </td>
		                    </tr>

		                    <tr valign="top">
		                        <th><?php esc_html_e('Playlist keywords', HAP_TEXTDOMAIN); ?></th>
		                        <td>
		                        	<div id="hap-playlist-tag-wrap"></div>
		                            <button type="button" id="hap-playlist-tag"><?php esc_html_e('Add keywords', HAP_TEXTDOMAIN); ?></button>
		                        </td>
		                    </tr>
				    		
							<tr valign="top">
								<th><?php esc_html_e('Prefix media url', HAP_TEXTDOMAIN); ?></th>
								<td>
									<input type="text" name="mediaPrefixUrl" value="<?php echo ($playlist_options['mediaPrefixUrl']); ?>">
									<p class="info"><?php esc_html_e('Add prefix url to your relative media urls (applies to audio urls and thumbnails).', HAP_TEXTDOMAIN); ?></p>
								</td>
							</tr>

							<tr valign="top">
				                <th><?php esc_html_e('Retrieve more on total scroll', HAP_TEXTDOMAIN); ?></th>
				                <td>
				                    <label><input name="addMoreOnTotalScroll" type="checkbox" value="1" <?php if(isset($playlist_options['addMoreOnTotalScroll']) && $playlist_options['addMoreOnTotalScroll'] == "1") echo 'checked' ?>> <?php esc_html_e('Retrieve more songs from this playlist on total scroll in player (when user scrolls to playlist bottom or with Grid skin load more button is used). Works in conjuntion with Retrieve more limit (for example, set Retrieve more limit 10 which will show 10 songs in playlist on start, then on total scroll, it will load another 10, and so on.', HAP_TEXTDOMAIN); ?></label>
				                </td>
				            </tr>

				            <tr valign="top">
								<th><?php esc_html_e('Retrieve more limit', HAP_TEXTDOMAIN); ?></th>
								<td>
									<input type="number" name="addMoreOnTotalScrollLimit" min="0" value="<?php echo ($playlist_options['addMoreOnTotalScrollLimit']); ?>">
									<p class="info"><?php esc_html_e('Number of songs to retrieve on total scroll', HAP_TEXTDOMAIN); ?></p>
								</td>
							</tr>

						</table>

						<div id="hap-playlist-category-dialog-container" class="hap-dialog-container">
						    <div class="hap-dialog-container-bg"></div>
						    <div class="hap-category-dialog-inner">
						        <div class="hap-category-dialog">
						            <h3><?php esc_html_e('Genre', HAP_TEXTDOMAIN); ?></h3>
						            <div id="hap-playlist-category-dialog-list" class="hap-category-dialog-list"></div>
						            <div class="hap-category-dialog-buttons">
						                <button type="button" id="hap-category-dialog-close" class="hap-category-dialog-close"><?php esc_html_e('Close', HAP_TEXTDOMAIN); ?></button>
						            </div>
						        </div>
						    </div>
						</div>

						<div id="hap-playlist-tag-dialog-container" class="hap-dialog-container">
						    <div class="hap-dialog-container-bg"></div>
						    <div class="hap-category-dialog-inner">
						        <div class="hap-category-dialog">
						            <h3><?php esc_html_e('Keywords', HAP_TEXTDOMAIN); ?></h3>
						            <div id="hap-playlist-tag-dialog-list" class="hap-category-dialog-list"></div>
						            <div class="hap-category-dialog-buttons">
						                <button type="button" id="hap-tag-dialog-close" class="hap-category-dialog-close"><?php esc_html_e('Close', HAP_TEXTDOMAIN); ?></button>
						            </div>
						        </div>
						    </div>
						</div>

					</div>

					<div id="hap-tab-playlist-options-global-content" class="hap-tab-content">

						<p><?php esc_html_e('Global playlist options will be applied to every song in playlist.', HAP_TEXTDOMAIN); ?></p>

						<table class="form-table" >

							<tr>
								<th><?php esc_html_e('Global thumbnail', HAP_TEXTDOMAIN); ?></th>
								<td>
									<img id="thumbGlobal_preview" class="hap-img-preview" src="<?php echo (isset($playlist_options['thumbGlobal']) ? esc_html($playlist_options['thumbGlobal']) : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D'); ?>" alt="">
									<input type="text" id="thumbGlobal" name="thumbGlobal" value="<?php if(isset($playlist_options['thumbGlobal'])) echo (esc_html($playlist_options['thumbGlobal'])); ?>">
						            <button id="thumbGlobal_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
						            <button id="thumbGlobal_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button><br>
						            <p class="info"><?php esc_html_e('Make this thumbnail global for this playlist. This means all tracks in this playlist will use this thumbnail.', HAP_TEXTDOMAIN); ?></p>
								</td>
							</tr>	
							
							<tr valign="top">
								<th><?php esc_html_e('Start time', HAP_TEXTDOMAIN); ?></th>
								<td>
									<input type="number" name="start" min="0" step="1" value="<?php echo ($playlist_options['start']); ?>">
									<p class="info"><?php esc_html_e('Enter media start time in seconds.', HAP_TEXTDOMAIN); ?></p>
								</td>
							</tr>

							<tr valign="top">
								<th><?php esc_html_e('End time', HAP_TEXTDOMAIN); ?></th>
								<td>
									<input type="number" name="end" min="0" step="1" value="<?php echo ($playlist_options['end']); ?>">
									<p class="info"><?php esc_html_e('Enter media end time in seconds.', HAP_TEXTDOMAIN); ?></p>
								</td>
							</tr>

						</table>

					</div>

				</div>

				<div class="hap-actions"> 
		            <button id="hap-edit-playlist-form-submit" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Save playlist options', HAP_TEXTDOMAIN); ?></button> 
		        </div>

				</form>	

	  	    </div>

	  	</div>    

	  	<div class="option-tab-divider"></div>

	  	<p><?php esc_html_e('From this section you can create and edit playlist tracks. Drag the tracks by ID column to change sort order in which they appear in the player. You can also sort by ID, title and artist field.', HAP_TEXTDOMAIN); ?></p>
	  	
	  	<?php $playlists = $wpdb->get_results("SELECT id, title FROM {$playlist_table} ORDER BY title ASC", ARRAY_A); ?>

	  	<div class="list-actions">

	  		<div class="list-actions-wrap list-actions-left hap-playlist-actions">

		  		<div class="list-actions-inner">

			  		<button type="button" id="hap-delete-media"><?php esc_html_e('Delete selected', HAP_TEXTDOMAIN); ?></button>
			  		<button id="hap-copy-media"><?php esc_html_e('Copy selected', HAP_TEXTDOMAIN); ?></button>
			  		<?php if(count($playlists)>1) : ?>
			  			<button id="hap-move-media"><?php esc_html_e('Move selected', HAP_TEXTDOMAIN); ?></button>
			  		<?php endif; ?>	
			  		
			  		<input type="text" id="hap-filter-media" placeholder="<?php esc_attr_e('Search song..', HAP_TEXTDOMAIN); ?>">

			  		<button type="button" id="hap-create-peaks" data-title="<?php esc_attr_e('Waveform peaks are automatically created when you upload audio in Wordpress media library. You can use this method to create waveforms for audio files that still do not have waveforms. Note that this only works for audio files located on the same server!', HAP_TEXTDOMAIN); ?>" data-none="<?php esc_html_e('No audio files to create waveforms!', HAP_TEXTDOMAIN); ?>"><?php esc_html_e('Create audio waveforms', HAP_TEXTDOMAIN); ?></button>

				</div>

		  		<div id="playlist-selector-wrap">

		  			<div id="playlist-selector-wrap-inner">

			        	<span><?php esc_html_e('Select destination playlist:', HAP_TEXTDOMAIN); ?></span>

			        	<input list="hap_playlist_selector_list" id="hap_playlist_selector">
						<datalist id="hap_playlist_selector_list">
						    <?php 
								foreach ($playlists as $pl) {
									echo('<option value="'.$pl['id'].'">'.$pl['title'].'</option>');
								}
							?>
						</datalist>  

						<button id="selected-ok"><?php esc_html_e('Ok', HAP_TEXTDOMAIN); ?></button>
				  		<button id="selected-cancel"><?php esc_html_e('Cancel', HAP_TEXTDOMAIN); ?></button>
					</div>

				</div>

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

	  	<div class="option-tab" style="margin-bottom:0;">

		    <div class="option-toggle">
		        <span class="option-title"><?php esc_html_e('Playlist tracks', HAP_TEXTDOMAIN); ?></span>

		        <div class="option-toggle-icon">
	                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" ><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
	            </div>
		    </div>

		    <div class="option-content hap-content-clear">
            	
		    	<table id="media-table" class='hap-table wp-list-table widefat'>
					<thead class="media-table-header">
						<tr>
							<th style="width:1%"><input type="checkbox" class="hap-media-all"></th>
							<th class="hap-sort-field" data-type="id" title="<?php esc_attr_e('Sort by created date', HAP_TEXTDOMAIN); ?>"><a href="#">ID <span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></a></th>
							<th><?php esc_html_e('Type', HAP_TEXTDOMAIN); ?></th>
							<th><?php esc_html_e('Thumb', HAP_TEXTDOMAIN); ?></th>
							<th class="hap-sort-field" data-type="artist" title="<?php esc_attr_e('Sort by artist', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Artist', HAP_TEXTDOMAIN); ?> <span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></a></th>
							<th class="hap-sort-field" data-type="title" title="<?php esc_attr_e('Sort by title', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?> <span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></a></th>
							<th><?php esc_html_e('Url', HAP_TEXTDOMAIN); ?></th>
							<th><?php esc_html_e('Category', HAP_TEXTDOMAIN); ?></th>
							<th><?php esc_html_e('Tags', HAP_TEXTDOMAIN); ?></th>
							<th><?php esc_html_e('Actions', HAP_TEXTDOMAIN); ?></th>
						</tr>
					</thead>
					<tbody id="media-item-list">

						<?php foreach($medias as $media) : 

							$media_options = unserialize($media['options']);

							$title = isset($media_options['title']) ? $media_options['title'] : '';
							$artist = isset($media_options['artist']) ? $media_options['artist'] : '';

						?>

							<tr class="media-item hap-pagination-hidden" data-media-id="<?php echo($media['id']); ?>" data-order-id="<?php echo($media['order_id']); ?>" data-peak-id="<?php echo (isset($media_options['peaks']) ? '1' : '0'); ?>">

								<td><input type="checkbox" class="hap-media-indiv"></td>

								<td class="media-id" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><?php echo($media['id']); ?></td>

								<td class="media-type"><?php echo($media_options['type']); ?></td>

								<td class="media-thumb">
									<img class="hap-media-thumb-img" src="<?php echo (isset($media_options['thumb']) ? esc_html($media_options['thumb']) : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D'); ?>" alt/>
								</td>

								<td class="media-artist"><?php echo($artist); ?></td>

								<td class="media-title"><?php echo($title); ?></td>

								<td class="media-path"><?php echo($media_options['path']) ?></td>

								<td class="media-category"><?php echo(isset($media['category']) ? $media['category'] : ''); ?></td>

								<td class="media-tag"><?php echo(isset($media['tag']) ? $media['tag'] : ''); ?></td>

								<td>

								<a class="hap-edit-media" href='#' title='<?php esc_attr_e('Edit media', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Edit', HAP_TEXTDOMAIN); ?></a>

								&nbsp;&nbsp;|&nbsp;&nbsp;

								<a class="hap-delete-media" href='#' title='<?php esc_attr_e('Delete media', HAP_TEXTDOMAIN); ?>' style="color:#f00;"><?php esc_html_e('Delete', HAP_TEXTDOMAIN); ?></a>

								</td>
							</tr>

						<?php endforeach; ?>	

						<tr class="hap-media-item-container-orig">

							<td><input type="checkbox" class="hap-media-indiv"></td>

							<td class="media-id" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"></td>

							<td class="media-type"></td>

							<td class="media-thumb">
								<img class="hap-media-thumb-img" src="<?php echo ('data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D'); ?>" alt/>
							</td>

							<td class="media-artist"></td>

							<td class="media-title"></td>

							<td class="media-path"></td>

							<td class="media-category"></td>

							<td class="media-tag"></td>

							<td>

							<a class="hap-edit-media" href='#' title='<?php esc_attr_e('Edit media', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Edit', HAP_TEXTDOMAIN); ?></a>

							&nbsp;&nbsp;|&nbsp;&nbsp;

							<a class="hap-delete-media" href='#' title='<?php esc_attr_e('Delete media', HAP_TEXTDOMAIN); ?>' style="color:#f00;"><?php esc_html_e('Delete', HAP_TEXTDOMAIN); ?></a>

							</td>
						</tr>

					</tbody>		 
				</table>

            </div>

	    </div>

    </div>
	
	<div id="hap-sticky-action" class="hap-sticky">
        <div id="hap-sticky-action-inner">
            <a class="button-secondary" href="<?php echo admin_url("admin.php?page=hap_playlist_manager"); ?>"><?php esc_html_e('Back to Playlist list', HAP_TEXTDOMAIN); ?></a>
            
            <button id="hap-add-media" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Add Song', HAP_TEXTDOMAIN); ?></button> 

            <button id="hap-upload-multiple-media" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Upload multiple Songs', HAP_TEXTDOMAIN); ?></button> 
        </div>
    </div>

    <div id="hap-save-holder"></div>
	
</div>

<div id="hap-edit-media-modal" class="hap-modal">
    <div class="hap-modal-bg">
        <div class="hap-modal-inner">
        	<div class="hap-modal-content">

        		<?php 

        		//load playlists
				$additional_playlists = $wpdb->get_results("SELECT id, title FROM {$playlist_table} ORDER BY title ASC", ARRAY_A);

        		include("add_media.php"); ?>
    		</div>
        </div>
    </div>
</div>

<div id="hap-media-category-dialog-container" class="hap-dialog-container">
    <div class="hap-dialog-container-bg"></div>
    <div class="hap-category-dialog-inner">
        <div class="hap-category-dialog">
            <h3><?php esc_html_e('Genre', HAP_TEXTDOMAIN); ?></h3>
            <div id="hap-media-category-dialog-list" class="hap-tag-dialog-list"></div>
            <div class="hap-category-dialog-buttons">
                <button type="button" id="hap-category-dialog-close" class="hap-category-dialog-close"><?php esc_html_e('Close', HAP_TEXTDOMAIN); ?></button>
            </div>
        </div>
    </div>
</div>

<div id="hap-media-tag-dialog-container" class="hap-dialog-container">
    <div class="hap-dialog-container-bg"></div>
    <div class="hap-category-dialog-inner">
        <div class="hap-category-dialog">
            <h3><?php esc_html_e('keywords', HAP_TEXTDOMAIN); ?></h3>
            <div id="hap-media-tag-dialog-list" class="hap-tag-dialog-list"></div>
            <div class="hap-category-dialog-buttons">
                <button type="button" id="hap-tag-dialog-close" class="hap-category-dialog-close"><?php esc_html_e('Close', HAP_TEXTDOMAIN); ?></button>
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