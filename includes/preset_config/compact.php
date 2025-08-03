<table class="form-table hap-preset-config-<?php echo($preset); ?>">

    <tr valign="top">
        <th><?php _e('Player background color', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input name="playerBgColor" class="hap-checkbox" value="<?php echo($options['playerBgColor']); ?>">
        </td>
    </tr> 
    <tr valign="top">
        <th><?php _e('Icon color', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input name="iconColor" class="hap-checkbox" value="<?php echo($options['iconColor']); ?>">
        </td>
    </tr>
    <tr valign="top">
        <th><?php _e('Icon hover color', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input name="iconHoverColor" class="hap-checkbox" value="<?php echo($options['iconHoverColor']); ?>">
        </td>
    </tr>
    
    <tr valign="top" class="hap-preset-config-field hap-preset-compact_2">
        <th><?php _e('Volume seekbar background color', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input name="volumeBgColor" class="hap-checkbox" value="<?php echo($options['volumeBgColor']); ?>">
        </td>
    </tr>
    <tr valign="top" class="hap-preset-config-field hap-preset-compact_2">
        <th><?php _e('Volume seekbar level color', HAP_TEXTDOMAIN); ?></th>
        <td>
            <input name="volumeLevelColor" class="hap-checkbox" value="<?php echo($options['volumeLevelColor']); ?>">
        </td>
    </tr>

</table>
