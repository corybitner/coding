<?php

$tag_arr = array();
$category_arr = array();

//tag and category
$taxonomy = $wpdb->get_results("SELECT id, title, type, description FROM {$taxonomy_table} ORDER BY title ASC", ARRAY_A);

if($wpdb->num_rows > 0){
    foreach($taxonomy as $tax){//divide
        if($tax['type'] == 'tag')$tag_arr[] = $tax;
        else $category_arr[] = $tax;
    }
}

?>

<div class='wrap'>

	<h2><?php esc_html_e('Genre and keywords', HAP_TEXTDOMAIN); ?></h2>

    <p class="info"><?php esc_html_e('In this section you can create any number of genres and keywords. These can later be attached to songs. Click fields to edit them.', HAP_TEXTDOMAIN); ?></p>

    <div class="list-actions">
        <div class="list-actions-wrap list-actions-left">
            <input type="text" id="hap-filter-tax-genre" placeholder="<?php esc_attr_e('Search..', HAP_TEXTDOMAIN); ?>">
        </div>
    </div>

    <form id="hap-edit-taxonomy-form" method="post" enctype="multipart/form-data" action="<?php echo admin_url("admin.php?page=hap_taxonomy"); ?>">

		<div class="hap-admin">

            <div class="option-tab">
                <div class="option-toggle">
                    <span class="option-title"><?php esc_html_e('Keywords', HAP_TEXTDOMAIN); ?></span>
                </div>
                <div class="option-content">   

        			<table id="category-table" class='hap-table wp-list-table widefat'>

                        <thead>
                            <tr>
                                <th class="ap-table-w20"><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></th>
                                <th><?php esc_html_e('Description', HAP_TEXTDOMAIN); ?></th>
                                <th><?php esc_html_e('Actions', HAP_TEXTDOMAIN); ?></th>
                            </tr>
                        </thead>
        				
        				<tbody>
                            <?php foreach($category_arr as $c) : ?>

                                <tr class="taxonomy-item-list" data-title="<?php echo(esc_html($c['title'])); ?>" data-id="<?php echo($c['id']); ?>">

                                    <td class="taxonomy-item-field">
                                        <input type="text" class="hap-field-editable hap-taxonomy-title" value="<?php echo(esc_html($c['title'])); ?>"/>
                                    </td>

                                    <td class="taxonomy-item-field">
                                        <input type="text" class="hap-field-editable hap-taxonomy-description" value="<?php echo(esc_html($c['description'])); ?>"/>
                                    </td>

                                    <td><span class="taxonomy-item-delete ap-item-delete" title='<?php esc_attr_e('Delete', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Delete', HAP_TEXTDOMAIN); ?></span></td>
                                </tr>

                            <?php endforeach; ?>  

                        </tbody>

        			</table>

                    <div class='hap-taxonomy-input'>   

                        <p class="info"><?php esc_html_e('Add genre. Only letters and numbers allowed.', HAP_TEXTDOMAIN); ?></p>

                        <table>

                            <tr valign="top">
                                <th><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></th>
                                <td>
                                    <input type="text" id="category-title-add">
                                </td>
                            </tr>

                            <tr valign="top">
                                <th><?php esc_html_e('Description', HAP_TEXTDOMAIN); ?></th>
                                <td>
                                    <textarea id="category-description-add" rows="2" ></textarea>
                                </td>
                            </tr>

                        </table>

                        <button type="button" id="hap-add-category" class="hap-add-tax-btn"><?php esc_html_e('Add', HAP_TEXTDOMAIN); ?></button>

                    </div>

                </div>

            </div>

        </div>    

        <br>

        <div class="list-actions">
            <div class="list-actions-wrap list-actions-left">
                <input type="text" id="hap-filter-tax-keyword" placeholder="<?php esc_attr_e('Search..', HAP_TEXTDOMAIN); ?>">
            </div>
        </div>

        <div class="hap-admin"> 

            <div class="option-tab">
                <div class="option-toggle">
                    <span class="option-title"><?php esc_html_e('Keywords', HAP_TEXTDOMAIN); ?></span>
                </div>
                <div class="option-content">   

                    <table id="tag-table" class='hap-table wp-list-table widefat'>

                        <thead>
                            <tr>
                                <th><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></th>
                                <th><?php esc_html_e('Description', HAP_TEXTDOMAIN); ?></th>
                                <th><?php esc_html_e('Actions', HAP_TEXTDOMAIN); ?></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php foreach($tag_arr as $c) : ?>

                                <tr class="taxonomy-item-list" data-title="<?php echo(esc_html($c['title'])); ?>" data-id="<?php echo($c['id']); ?>">

                                    <td class="taxonomy-item-field">
                                        <input type="text" class="hap-field-editable hap-taxonomy-title" value="<?php echo(esc_html($c['title'])); ?>"/>
                                    </td>

                                    <td class="taxonomy-item-field">
                                        <input type="text" class="hap-field-editable hap-taxonomy-description" value="<?php echo(esc_html($c['description'])); ?>"/>
                                    </td>

                                    <td><span class="taxonomy-item-delete ap-item-delete" title='<?php esc_attr_e('Delete', HAP_TEXTDOMAIN); ?>'><?php esc_html_e('Delete', HAP_TEXTDOMAIN); ?></span></td>
                                </tr>

                            <?php endforeach; ?>  

                        </tbody>

                    </table>

                    <div class='hap-taxonomy-input'>   

                        <p class="info"><?php esc_html_e('Add keyword. Only letters and numbers allowed.', HAP_TEXTDOMAIN); ?></p>

                        <table>

                            <tr valign="top">
                                <th><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></th>
                                <td>
                                    <input type="text" id="tag-title-add">
                                </td>
                            </tr>

                            <tr valign="top">
                                <th><?php esc_html_e('Description', HAP_TEXTDOMAIN); ?></th>
                                <td>
                                    <textarea id="tag-description-add" rows="2" ></textarea>
                                </td>
                            </tr>

                        </table>

                        <button type="button" id="hap-add-tag" class="hap-add-tax-btn"><?php esc_html_e('Add', HAP_TEXTDOMAIN); ?></button>

                    </div> 

                </div>     

            </div>     

		</div>

	</form>

</div>

