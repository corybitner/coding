<table class="form-table">

    <tr valign="top">
        <th><?php esc_html_e('Search playlist songs text', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input type="text" name="filterText" value="<?php echo($options['filterText']); ?>"><br>
        </td>
    </tr>
    <tr valign="top">
        <th><?php esc_html_e('Search nothing found message', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input type="text" name="filterNothingFoundMsg" value="<?php echo($options['filterNothingFoundMsg']); ?>"><br>
        </td>
    </tr>
    <tr valign="top">
        <th><?php esc_html_e('Load more button text', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input type="text" name="loadMoreBtnText" value="<?php echo($options['loadMoreBtnText']); ?>"><br>
        </td>
    </tr>

    <tr valign="top">
        <th><?php esc_html_e('Pagination previous button title', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input type="text" name="paginationPreviousBtnTitle" value="<?php echo($options['paginationPreviousBtnTitle']); ?>"><br>
        </td>
    </tr>

    <tr valign="top">
        <th><?php esc_html_e('Pagination previous button text', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input type="text" name="paginationPreviousBtnText" value="<?php echo($options['paginationPreviousBtnText']); ?>"><br>
        </td>
    </tr>

    <tr valign="top">
        <th><?php esc_html_e('Pagination next button title', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input type="text" name="paginationNextBtnTitle" value="<?php echo($options['paginationNextBtnTitle']); ?>"><br>
        </td>
    </tr>

    <tr valign="top">
        <th><?php esc_html_e('Pagination next button text', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input type="text" name="paginationNextBtnText" value="<?php echo($options['paginationNextBtnText']); ?>"><br>
        </td>
    </tr>

</table>

