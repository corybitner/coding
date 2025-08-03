<?php

//load playlists
$playlist_data = $wpdb->get_results("SELECT id, title, options FROM $playlist_table ORDER BY id ASC", ARRAY_A);

?>

<div class="wrap">

	<h2><?php esc_html_e('Manage Playlists', HAP_TEXTDOMAIN); ?></h2>

	<p><?php esc_html_e('From this section you can create and edit playlists. Edit title field to change playlist name.', HAP_TEXTDOMAIN); ?></p>

	<div class="list-actions">
		<div class="list-actions-wrap list-actions-left">
			<button type="button" id="hap-delete-playlists"><?php esc_html_e('Delete selected', HAP_TEXTDOMAIN); ?></button>
	  		<input type="text" id="hap-filter-playlist" placeholder="<?php esc_attr_e('Search by title..', HAP_TEXTDOMAIN); ?>">
  		</div>
    </div>

	<table class='hap-table wp-list-table widefat hap-playlist-table'>
		<thead class="hap-playlist-table-header">
			<tr>
				<th style="width:1%"><input type="checkbox" class="hap-playlist-all"></th>

				<th class="hap-sort-field" data-type="id" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('ID', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th><?php esc_html_e('Thumb', HAP_TEXTDOMAIN); ?></th>

				<th class="hap-sort-field" data-type="title" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>
				
				<th><?php esc_html_e('Actions', HAP_TEXTDOMAIN); ?></th>
			</tr>
		</thead>
		<tbody id="playlist-item-list" data-admin-url="<?php echo admin_url("admin.php"); ?>">
			<?php foreach($playlist_data as $playlist) : ?>
				<tr class="hap-playlist-row hap-playlist-item" data-playlist-id="<?php echo($playlist['id']); ?>">
					<td><input type="checkbox" class="hap-playlist-indiv" data-playlist-id="<?php echo($playlist['id']); ?>"></td>

					<td class="media-id"><?php echo($playlist['id']); ?></td>	

					<td><img class="pmimg" src="<?php

					$playlist_options = unserialize($playlist['options']);

					echo (isset($playlist_options['thumb']) ? esc_html($playlist_options['thumb']) : 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D'); ?>"/></td>

					<td class="media-title"><input type="text" name="title" class="title-editable playlist-title" data-title="<?php echo(esc_html($playlist['title'])); ?>" value="<?php echo(esc_html($playlist['title'])); ?>" data-playlist-id="<?php echo($playlist['id']); ?>"/></td>

					<td><a href='<?php echo admin_url("admin.php?page=hap_playlist_manager&action=edit_playlist&playlist_id=".$playlist['id']); ?>' title='<?php esc_attr_e('Edit playlist', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Edit', HAP_TEXTDOMAIN); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;

					<a class="hap-duplicate-playlist" href="#" title='<?php esc_attr_e('Duplicate playlist', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Duplicate', HAP_TEXTDOMAIN); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;

					<?php if(extension_loaded('zip')) : ?>
						<a class="hap-export-playlist-btn" href='#' title='<?php esc_attr_e('Export playlist', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Export', HAP_TEXTDOMAIN); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php endif; ?>

					<a href="#" class="hap-delete-playlist" title='<?php esc_attr_e('Delete playlist', HAP_TEXTDOMAIN); ?>' style="color:#f00;"><?php esc_html_e('Delete', HAP_TEXTDOMAIN); ?></a></td>
				</tr>
			<?php endforeach; ?>	

		</tbody>		 
	</table>

	<div id="hap-sticky-action" class="hap-sticky">
        <div id="hap-sticky-action-inner">
            
        	<button type="button" class='button-primary' id="hap-add-playlist"><?php esc_html_e('Add New Playlist', HAP_TEXTDOMAIN); ?></button> 
	  		<form id="hap-import-playlist-form" action="" method="POST" enctype="multipart/form-data">
	  			<?php wp_nonce_field('hap-import-playlist-nonce'); ?>
		  		<input type="file" id="hap-playlist-file-input">
		  		<button type="button" class='button-secondary' id="hap-import-playlist" title="Upload playlist previously exported zip file."><?php esc_html_e('Import Playlist', HAP_TEXTDOMAIN); ?></button> 
		  	</form>

        </div>
    </div>

    <div id="hap-save-holder"></div>

</div>

<div id="hap-add-playlist-modal" class="hap-modal">
    <div class="hap-modal-bg">
        <div class="hap-modal-inner">
        	<div class="hap-modal-content">

				<form id="hap-add-playlist-form" method="post">

					<div class="hap-admin hap-bg">

						<table class="form-table">
							
							<tr valign="top">
								<th><?php esc_html_e('Playlist title', HAP_TEXTDOMAIN); ?></th>
								<td><input type="text" name="playlist-title" id="playlist-title" required placeholder="<?php esc_attr_e('Enter playlist title', HAP_TEXTDOMAIN); ?>"></td>
							</tr>

						</table>

					</div>

				</form>

				<div class="hap-modal-actions">	
					<button id="hap-add-playlist-cancel" type="button"><?php esc_html_e('Cancel', HAP_TEXTDOMAIN); ?></button>
		            <button id="hap-add-playlist-submit" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Add playlist', HAP_TEXTDOMAIN); ?></button> 
    			</div>

    			</form>

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