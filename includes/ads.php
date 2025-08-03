<tr valign="top" class="ad_field ad_pre_field">
	<th><?php esc_html_e('Ad pre', HAP_TEXTDOMAIN); ?></th>
	<td class="hap_ad_sortable">
		<p class="info"><?php esc_html_e('Add audio ad that plays before main song starts.', HAP_TEXTDOMAIN); ?></p>
		<div class="hap-ad-wrap">
			<div class="hap-ad-inner">
				<input type="text" class="hap_ad ad_pre" name="ad_pre[]">
		        <button type="button" class="hap_ad_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
		        <div class="hap_ad_remove_wrap">
			        <button type="button" class="hap_ad_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button>
			        <button type="button" class="hap_ad_sort"><?php esc_html_e('Sort', HAP_TEXTDOMAIN); ?></button>
		        </div>
	        </div>
        </div>
        <button type="button" class="add_another"><?php esc_html_e('Add another', HAP_TEXTDOMAIN); ?></button>
    </td>
</tr>

<tr valign="top" class="ad_field ad_mid_field">
	<th><?php esc_html_e('Ad mid', HAP_TEXTDOMAIN); ?></th>
	<td class="hap_ad_sortable">
		<p class="info"><?php esc_html_e('Add audio ad that plays in specified interval while main song plays. Drag up and down to sort them.', HAP_TEXTDOMAIN); ?></p>
		<div class="hap-ad-wrap">
			<div class="hap-ad-inner">
				<input type="text" class="hap_ad ad_mid" name="ad_mid[]">
		        <button type="button" class="hap_ad_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
		        <div class="hap_ad_remove_wrap">
			        <button type="button" class="hap_ad_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button>
			        <button type="button" class="hap_ad_sort"><?php esc_html_e('Sort', HAP_TEXTDOMAIN); ?></button>
		        </div>
	        </div>
        </div>
        <button type="button" class="add_another"><?php esc_html_e('Add another', HAP_TEXTDOMAIN); ?></button>
    </td>
</tr>

<tr valign="top" class="ad_field">
	<th><?php esc_html_e('Ad mid interval (miliseconds)', HAP_TEXTDOMAIN); ?></th>
	<td>
		<?php if(isset($data['ad_mid_interval'])) $ad_mid_interval = $data['ad_mid_interval'];
		else $ad_mid_interval = '';
		?>
		<input type="number" name="ad_mid_interval" min="0" value="<?php echo($ad_mid_interval); ?>">
		<p class="info"><?php esc_html_e('Repeat ad every x miliseconds', HAP_TEXTDOMAIN); ?></p>
	</td>
</tr>

<tr valign="top" class="ad_field ad_end_field">
	<th><?php esc_html_e('Ad end', HAP_TEXTDOMAIN); ?></th>
	<td class="hap_ad_sortable">
		<p class="info"><?php esc_html_e('Add audio ad that plays after main song ends.', HAP_TEXTDOMAIN); ?></p>
		<div class="hap-ad-wrap">
			<div class="hap-ad-inner">
				<input type="text" class="hap_ad ad_end" name="ad_end[]">
		        <button type="button" class="hap_ad_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
		        <div class="hap_ad_remove_wrap">
			        <button type="button" class="hap_ad_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button>
			        <button type="button" class="hap_ad_sort"><?php esc_html_e('Sort', HAP_TEXTDOMAIN); ?></button>
		        </div>
	        </div>
        </div>
        <button type="button" class="add_another"><?php esc_html_e('Add another', HAP_TEXTDOMAIN); ?></button>
    </td>
</tr>

<tr valign="top">
    <th><?php esc_html_e('Randomize ads', HAP_TEXTDOMAIN); ?></th>
    <td>
    	<label><input name="shuffle_ads" type="checkbox" value="1" <?php if(isset($data['shuffle_ads']) && $data['shuffle_ads'] == "1") echo 'checked' ?>> <?php esc_html_e('Shuffle ad order for each individual ad type. For example, if you have multiple ad pre, it will shuffle them.', HAP_TEXTDOMAIN); ?></label>
    </td>
</tr>