<?php

//load players
$players = $wpdb->get_results("SELECT id, title, preset FROM {$player_table} ORDER BY id ASC", ARRAY_A);

?>

<div class="wrap">

	<h2><?php esc_html_e('Manage Players', HAP_TEXTDOMAIN); ?></h2>

	<p><?php esc_html_e('From this section you can create and edit players. Edit title field to change player name.', HAP_TEXTDOMAIN); ?></p>

	<div class="list-actions">
		<div class="list-actions-wrap list-actions-left">
			<button id="hap-delete-players"><?php esc_html_e('Delete selected', HAP_TEXTDOMAIN); ?></button>
	  		<input type="text" id="hap-filter-player" placeholder="<?php esc_attr_e('Search by title..', HAP_TEXTDOMAIN); ?>">
  		</div>
    </div>

	<table class='hap-table wp-list-table widefat hap-player-table'>
		<thead class="hap-player-table-header">
			<tr>
				<th style="width:1%"><input type="checkbox" class="hap-player-all"></th>

				<th class="hap-sort-field" data-type="id" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('ID', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th class="hap-sort-field" data-type="title" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th class="hap-sort-field" data-type="preset" title="<?php esc_attr_e('Sort', HAP_TEXTDOMAIN); ?>"><a href="#"><?php esc_html_e('Preset', HAP_TEXTDOMAIN); ?></a><span class="hap-triangle-dir-wrap"><span class="hap-triangle-dir hap-triangle-dir-up">&#9660;</span><span class="hap-triangle-dir hap-triangle-dir-down">&#9650;</span></span></th>

				<th><?php esc_html_e('Actions', HAP_TEXTDOMAIN); ?></th>
			</tr>
		</thead>
		<tbody id="player-item-list" data-admin-url="<?php echo admin_url("admin.php"); ?>">
			<?php foreach($players as $player) : ?>
				
				<tr class="hap-player-row hap-player-item" data-title="<?php echo(esc_html($player['title'])); ?>" data-player-id="<?php echo($player['id']); ?>">

					<td><input type="checkbox" class="hap-player-indiv"></td>

					<td class="media-id"><?php echo($player['id']); ?></td>	

					<td class="media-title"><input type="text" name="title" class="title-editable player-title" data-title="<?php echo(esc_html($player['title'])); ?>" data-player-id="<?php echo($player['id']); ?>" value="<?php echo(esc_html($player['title'])); ?>"/></td>

					<td class="media-preset"><?php echo($player['preset']); ?></td>

					<td><a href='admin.php?page=hap_player_manager&action=edit_player&player_id=<?php echo($player['id']); ?>' title='<?php esc_attr_e('Edit player', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Edit', HAP_TEXTDOMAIN); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;

					<a class="hap-duplicate-player" href='#' title='<?php esc_attr_e('Duplicate player', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Duplicate', HAP_TEXTDOMAIN); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;

					<?php if(extension_loaded('zip')) : ?>
					  	<a class="hap-export-player-btn" href='#' title='<?php esc_attr_e('Export player', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Export', HAP_TEXTDOMAIN); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;	
					<?php endif; ?>

					<a href="#" class="hap-delete-player" title="<?php esc_attr_e('Delete player', HAP_TEXTDOMAIN); ?>" style="color:#f00;"><?php esc_html_e('Delete', HAP_TEXTDOMAIN); ?></a></td>
				</tr>
			<?php endforeach; ?>	

		</tbody>		 
	</table>

    <div id="hap-sticky-action" class="hap-sticky">
        <div id="hap-sticky-action-inner">
            
        	<button type="button" class='button-primary' id="hap-add-player"><?php esc_html_e('Add New Player', HAP_TEXTDOMAIN); ?></button> 
	  		<form id="hap-import-player-form" action="" method="POST" enctype="multipart/form-data">
	  			<?php wp_nonce_field('hap-import-player-nonce'); ?>
		  		<input type="file" id="hap-player-file-input">
		  		<button type="button" class='button-secondary' id="hap-import-player" title="Upload player previously exported zip file."><?php esc_html_e('Import Player', HAP_TEXTDOMAIN); ?></button> 
		  	</form>

        </div>
    </div>

    <div id="hap-save-holder"></div>
	
</div>

<div id="hap-add-player-modal" class="hap-modal">
    <div class="hap-modal-bg">
        <div class="hap-modal-inner">
        	<div class="hap-modal-content">

        		<form id="hap-add-player-form" method="post">
        		
        		<div class="hap-admin hap-bg">

					<table class="form-table">
						
						<tr valign="top">
							<th><?php esc_html_e('Player title', HAP_TEXTDOMAIN); ?></th>
							<td><input type="text" name="player-title" id="player-title" required placeholder="<?php esc_attr_e('Enter player title', HAP_TEXTDOMAIN); ?>"></td>
						</tr>

						<?php include('add_preset_fields.php'); ?>

					</table>

				</div>

				<div class="hap-modal-actions">	
					<button id="hap-add-player-cancel" type="button"><?php esc_html_e('Cancel', HAP_TEXTDOMAIN); ?></button>
		            <button id="hap-add-player-submit" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Add player', HAP_TEXTDOMAIN); ?></button> 
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