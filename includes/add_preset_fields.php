<tr valign="top">
	<th><?php esc_html_e('Select preset', HAP_TEXTDOMAIN); ?></th>
	<td>
		<select id="preset" name="preset">
			<optgroup label="standard">
				<option value="epic">Epic</option>
                <option value="art_wide_light">Art wide light</option>
                <option value="art_wide_dark">Art wide dark</option>
                <option value="art_narrow_light">Art narrow light</option>
                <option value="art_narrow_dark">Art narrow dark</option>
                <option value="brona_light">Brona light</option>
                <option value="brona_dark">Brona dark</option>
                <option value="modern">Modern</option>
                <option value="metalic">Metalic</option>
            </optgroup> 
            <optgroup label="minimal">
            	<option value="epic_mini">Epic mini</option>
            	<option value="poster">Poster</option>
            	<option value="widget">Widget</option>
                <option value="tiny_dark_1">Tiny dark 1</option>
                <option value="tiny_dark_2">Tiny dark 2</option>
                <option value="tiny_dark_3">Tiny dark 3</option>
                <option value="tiny_light_1">Tiny light 1</option>
                <option value="tiny_light_2">Tiny light 2</option>
                <option value="tiny_light_3">Tiny light 3</option>
                <option value="compact_1">Compact 1</option>
                <option value="compact_2">Compact 2</option>
            </optgroup> 
            <optgroup label="grid">
            	<option value="grid">Thumbnail grid</option>
            </optgroup> 
			<optgroup label="fixed to page bottom">
                <option value="fixed">Fixed</option>
            </optgroup> 
        </select>
    </td>
</tr>

<tr valign="top">
	<th></th>
	<td>

		<p class="info hap-player-info player-info-epic"><?php esc_html_e('Player with playlist on the right. On narrow screen playlist goes below player. This skin uses waveform seekbar.', HAP_TEXTDOMAIN); ?></p>

		<p class="info hap-player-info player-info-art_narrow_dark player-info-art_narrow_light"><?php esc_html_e('Vertical player with playlist that opens from the left. Useful for narrow spaces.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-art_wide_dark player-info-art_wide_light"><?php esc_html_e('Player with playlist beneath that can close on demand. On narrow screens player controls goes beneath the artwork.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-brona_dark player-info-brona_light"><?php esc_html_e('Player with playlist beneath that can close on demand. On narrow screens player controls goes beneath the artwork. Player uses Material design icons.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-metalic"><?php esc_html_e('Player with playlist on the right. On narrow screen playlist goes below player. Player artwork is copied into player background for unique look.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-modern"><?php esc_html_e('Player with playlist on the right. On narrow screen playlist goes below player. Player has circular seekbar over artwork area.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-artwork"><?php esc_html_e('Player with playlist on the right. On narrow screen playlist goes below player.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-classic"><?php esc_html_e('Player with playlist beneath that can be closed. Player does not have large artwork cover.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-poster"><?php esc_html_e('Player without visible playlist. All player controls are located above player artwork.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-fixed"><?php esc_html_e('Player fixed to page bottom.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-fixed_split"><?php esc_html_e('Playlist grid with thumbnails is located in the page and player is fixed to page bottom. When thumbnail is clicked, it playes in bottom player.', HAP_TEXTDOMAIN); ?></p>

        <p class="info hap-player-info player-info-wall"><?php esc_html_e('Player with square thumbnails and masonry layout. Player is fixed to page bottom. Playlist opens above the player in 100% size.', HAP_TEXTDOMAIN); ?></p>

         <p class="info hap-player-info player-info-tiny"><?php esc_html_e('Players without visible playlist. Small players fit any purpose from playing single audio to full playlist.', HAP_TEXTDOMAIN); ?></p>

         <p class="info hap-player-info player-info-widget"><?php esc_html_e('Player without visible playlist. All player controls are located above player artwork. Suitable for limited space.', HAP_TEXTDOMAIN); ?></p>

         <p class="info hap-player-info player-info-compact"><?php esc_html_e('Players without visible playlist. Small players fit any purpose from playing single audio to full playlist.', HAP_TEXTDOMAIN); ?></p>

         <p class="info hap-player-info player-info-grid"><?php esc_html_e('Thumbnail grid in page. Audio can play on its own in grid alone or it can be used in combination with sticky player at the page bottom.', HAP_TEXTDOMAIN); ?></p>

         <p class="info hap-player-info player-info-epic_mini"><?php esc_html_e('Mini player with basic controls. This skin uses waveform seekbar.', HAP_TEXTDOMAIN); ?></p>

        <br>

		<img id="preset-preview" src="" alt=""/>

	</td>
</tr>
