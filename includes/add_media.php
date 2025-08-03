<?php

$folder_sort = array(
    'filename-asc' => 'file name ascending', 
    'filename-desc' => 'file name descending', 
    'date-asc' => 'date ascending', 
    'date-desc' => 'date descending',
);

$gdrive_sort = array(
    'filename-asc' => 'file name ascending', 
    'filename-desc' => 'file name descending', 
);

$target = array(
    '_blank' => '_blank', 
    '_parent' => '_parent', 
    '_self' => '_self',  
    '_top' => '_top',  
);

?>

<div>
	<form id="hap-edit-media-form" method="post" action="">

		<div class="hap-admin hap-bg">

			<?php include('add_media_fields.php'); ?>

		</div>

		<p class="hap-modal-actions">     
			<button id="hap-edit-media-form-cancel" type="button"><?php esc_html_e('Cancel', HAP_TEXTDOMAIN); ?></button>
            <button id="hap-edit-media-form-submit" type="button" class="button-primary hap-edit-playlist-mode" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Save changes', HAP_TEXTDOMAIN); ?></button> 
        </p>

	</form>

</div>
