<?php 

if(isset($_GET['ad_id'])){

    $ad_id = $_GET['ad_id'];

    $stmt = $wpdb->prepare("SELECT * FROM {$ad_table} WHERE id = %d", $ad_id);
    $result = $wpdb->get_row($stmt, ARRAY_A);

    if($result){
    	$data = unserialize($result['options']);
    	$title = $result['title'];
    }

    if(!isset($data['ad_pre']))$data['ad_pre'] = '';
    if(!isset($data['ad_mid']))$data['ad_mid'] = '';
    if(!isset($data['ad_end']))$data['ad_end'] = '';

}else{

	$ad_id = '';

	$data = array();
	$data['ad_pre'] = '';
    $data['ad_mid'] = '';
    $data['ad_end'] = '';

}


if(isset($_GET['hap_msg'])){
	$msg = $_GET['hap_msg'];
	if($msg == 'ad_created')$msg = __('Ad section created!', HAP_TEXTDOMAIN); 
}else{
	$msg = null;
}

?>

<div class='wrap'>

	<?php include("notice.php"); ?>

	<h2><?php esc_html_e('Edit ad', HAP_TEXTDOMAIN); ?> <span style="color:#FF0000; font-weight:bold;"><?php echo($title); echo(' - ID #' . $ad_id); ?></span></h2>
	<br>	

	<form id="hap-edit-ad-form" method="post" action="<?php echo admin_url("admin.php?page=hap_ad_manager&action=save_options&ad_id=".$ad_id); ?>" data-ad-id="<?php echo $ad_id ?>">

		<div class="hap-admin hap-bg">

			<div class="option-tab">
			    <div class="option-toggle">
			        <span class="option-title"><?php esc_html_e('Ad section', HAP_TEXTDOMAIN); ?></span>
			    </div>
			    <div class="option-content">

					<p><?php esc_html_e('Audio advertizing options. In this section you can upload audio to serve as ads. 3 types of audio ads exist. Ad can play before main song starts (ad pre), ad can play during main song play in specified interval (ad mid), ad can play after main song ends (ad end).', HAP_TEXTDOMAIN); ?></p>

					<script type="text/javascript">
					    var hap_adPre = <?php echo(json_encode($data['ad_pre'], JSON_HEX_TAG)); ?>;
					    var hap_adMid = <?php echo(json_encode($data['ad_mid'], JSON_HEX_TAG)); ?>;
					    var hap_adEnd = <?php echo(json_encode($data['ad_end'], JSON_HEX_TAG)); ?>;
					</script>

					<table class="form-table">
						<?php require(dirname(__FILE__)."/ads.php"); ?>
					</table>

				</div>

			</div>

		</div>	

		<?php wp_nonce_field('hap_edit_ad_action', 'hap_edit_ad_nonce_field'); ?>

        <div id="hap-sticky-action" class="hap-sticky">
            <div id="hap-sticky-action-inner">
                <a class="button-secondary" href="<?php echo admin_url("admin.php?page=hap_ad_manager"); ?>"><?php esc_html_e('Back to Ad list', HAP_TEXTDOMAIN); ?></a>
                
                <button id="hap-edit-ad-options-submit" type="button" class="button-primary" <?php disabled( !current_user_can(HAP_CAPABILITY) ); ?>><?php esc_html_e('Save Changes', HAP_TEXTDOMAIN); ?></button> 
            </div>
        </div>

        <div id="hap-save-holder"></div>

	</form>

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