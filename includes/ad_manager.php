<?php

//load ads
$ads = $wpdb->get_results("SELECT id, title FROM {$ad_table} ORDER BY title ASC", ARRAY_A);

?>

<div class="wrap">

	<?php include("notice.php"); ?>

	<h2><?php esc_html_e('Manage ads', HAP_TEXTDOMAIN); ?></h2>

	<p><?php esc_html_e('In this section you can upload audio to serve as ads. Edit title field to change ad name.', HAP_TEXTDOMAIN); ?></p>

	<div class="list-actions">
		<div class="list-actions-wrap">
			<button id="hap-delete-ads"><?php esc_html_e('Delete selected', HAP_TEXTDOMAIN); ?></button>
	  		<input type="text" id="hap-filter-ad" placeholder="<?php esc_attr_e('Search by title..', HAP_TEXTDOMAIN); ?>">
  		</div>
    </div>

	<table class='hap-table wp-list-table widefat hap-ad-table'>
		<thead>
			<tr>
				<th style="width:1%"><input type="checkbox" class="hap-ad-all"></th>
				<th>ID</th>
				<th><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></th>
				<th><?php esc_html_e('Actions', HAP_TEXTDOMAIN); ?></th>
			</tr>
		</thead>
		<tbody id="hap-ad-item-list" data-admin-url="<?php echo admin_url("admin.php"); ?>">
		
			<?php foreach($ads as $ad) : ?>
				<tr class="hap-ad-row hap-ad-item" data-title="<?php echo(esc_html($ad['title'])); ?>" data-ad-id="<?php echo($ad['id']); ?>">

					<td><input type="checkbox" class="hap-ad-indiv"></td>

					<td><?php echo($ad['id']); ?></td>	

					<td><input type="text" name="title" class="title-editable hap-ad-title" data-title="<?php echo(esc_html($ad['title'])); ?>" value="<?php echo(esc_html($ad['title'])); ?>" data-ad-id="<?php echo($ad['id']); ?>"/></td>

					<td><a href='admin.php?page=hap_ad_manager&action=edit_ad&ad_id=<?php echo($ad['id']); ?>' title='<?php esc_attr_e('Edit ad', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Edit', HAP_TEXTDOMAIN); ?></a>

					&nbsp;&nbsp;|&nbsp;&nbsp;

					<a class="hap-duplicate-ad" href='#' title='<?php esc_attr_e('Duplicate ad', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Duplicate', HAP_TEXTDOMAIN); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;

					<?php if(extension_loaded('zip')) : ?>
					  	<a class="hap-export-ad-btn" data-ad-id="<?php echo($ad['id']); ?>" href='#' title='<?php esc_attr_e('Export ad', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Export', HAP_TEXTDOMAIN); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;	
					<?php endif; ?>

					<a href='#' class="hap-delete-ad" style="color:#f00;"><?php esc_html_e('Delete', HAP_TEXTDOMAIN); ?></a></td>
				</tr>
			<?php endforeach; ?>	

		</tbody>		 
	</table>

    <div id="hap-sticky-action" class="hap-sticky">
        <div id="hap-sticky-action-inner">
            
        	<button type="button" class='button-primary' id="hap-add-ad"><?php esc_html_e('Add New ad section', HAP_TEXTDOMAIN); ?></button> 
	  		<form id="hap-import-ad-form" action="" method="POST" enctype="multipart/form-data">
	  			<?php wp_nonce_field('hap-import-ad-nonce'); ?>
		  		<input type="file" id="hap-ad-file-input">
		  		<button type="button" class='button-secondary' id="hap-import-ad" title="Upload ad previously exported zip file."><?php esc_html_e('Import Ad', HAP_TEXTDOMAIN); ?></button> 
		  	</form>

        </div>
    </div>

    <div id="hap-save-holder"></div>  
	
</div>

<div id="hap-add-ad-modal" class="hap-modal">
    <div class="hap-modal-bg">
        <div class="hap-modal-inner">
        	<div class="hap-modal-content">

        		<form id="hap-add-ad-form" method="post">

				<div class="hap-admin hap-bg">

					<table class="form-table">
						
						<tr valign="top">
							<th><?php esc_html_e('Ad section title', HAP_TEXTDOMAIN); ?></th>
							<td><input type="text" id="ad-title" required placeholder="<?php esc_attr_e('Enter ad title', HAP_TEXTDOMAIN); ?>"></td>
						</tr>

					</table>

				</div>

        		<div class="hap-modal-actions">	
					<button id="hap-add-ad-cancel" type="button"><?php esc_html_e('Cancel', HAP_TEXTDOMAIN); ?></button>
		            <button id="hap-add-ad-submit" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Add ad', HAP_TEXTDOMAIN); ?></button> 
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