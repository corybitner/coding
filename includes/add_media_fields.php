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
<table class="form-table" id="hap-edit-media-table">

	<tbody id="add_media_body">

		<tr valign="top" id="select_media_type_field">
			<th><?php esc_html_e('Select media type', HAP_TEXTDOMAIN); ?></th>
			<td>
				<select id="type" name="type" required>
					<optgroup label="Audio">
			            <option value="audio">audio</option>
			            <option value="folder">folder with audio files</option>
			            <option value="folder_backend">folder with audio files in backend</option>
			        </optgroup>
			        <optgroup label="Audio accordion">
			            <option value="folder_accordion">folder with audio files in accordion mode</option>
			            <option value="json_accordion">json with audio files in accordion mode</option>
			        </optgroup>
			        <optgroup label="Google drive">
			            <option value="gdrive_folder">Google Drive folder</option>
			        </optgroup>
			        <optgroup label="Soundcloud">
			            <option value="soundcloud">soundcloud</option>
			        </optgroup>
			        <optgroup label="Podcast RSS">
			            <option value="podcast">podcast</option>
			            <option value="itunes_podcast_music">itunes podcast</option>
			        </optgroup>
			        <optgroup label="Youtube">
			            <option value="youtube_single">youtube single videos</option>
			            <option value="youtube_playlist">youtube playlist</option>
			        </optgroup>
			        <optgroup label="Radio">
			            <option value="shoutcast">shoutcast</option>
			            <option value="icecast">icecast</option>
			            <option value="radiojar">radiojar</option>
			        </optgroup>
			        <optgroup label="HLS">
			            <option value="hls">HLS m3u8 link</option>
			        </optgroup>
			        <optgroup label="XML">
			            <option value="xml">xml file</option>
			        </optgroup>
			        <optgroup label="JSON">
			            <option value="json">json file</option>
			        </optgroup>
			        <optgroup label="M3U">
			            <option value="m3u">m3u playlist</option>
			        </optgroup>
			    </select>

		    </td>
		</tr>
		<tr valign="top" id="path_field">
			<th><?php esc_html_e('Url', HAP_TEXTDOMAIN); ?></th>
			<td>
		        <input type="text" id="path" name="path">
		        <button id="file_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
		        <br>

		        <p id="radio_info" class="info">
	            	Player can play radio and retrieve current playing song title and artwork. Note that if you want to display thumbnail and radio title in playlist use Thumbnail and Title fields below.
	            </p>

	            <p id="audio_info" class="info">
	            	Upload audio (mp3, wav, acc, flac...)
	            </p>

		        <p id="itunes_podcast_music_info" class="info"><?php esc_html_e('Enter iTunes Music Podcast url, for example:', HAP_TEXTDOMAIN); ?><a href="https://itunes.apple.com/us/podcast/rodkast/id374535595" target="_blank"> https://itunes.apple.com/us/podcast/rodkast/id374535595</a></p>

		        <p id="podcast_info" class="info"><?php esc_html_e('Enter Podcast url.', HAP_TEXTDOMAIN); ?></p>

		        <p id="sc_info" class="info"><?php esc_html_e('Enter Soundcloud url.', HAP_TEXTDOMAIN); ?></p>

		        <p id="gdrive_info" class="info"><?php esc_html_e('Enter folder ID which needs to be public, for example:', HAP_TEXTDOMAIN); ?> 0ByzcNpNrQNpWbjJGY19NSFF0R3M</p>

		        <p id="folder_info" class="info"><?php esc_html_e('Place your folder with audio files in \'wp-content/uploads/map-file-dir\' directory and enter folder name here. Or provide custom folder url on your server. Songs will be loaded from folder when player runs in page.', HAP_TEXTDOMAIN); ?></p>

		        <p id="folder_accordion_info" class="info"><?php esc_html_e('Accordion mode is a special mode that creates an accordion playlist from each folder of audio files. Place your folder with audio files in \'wp-content/uploads/map-file-dir\' directory and enter folder name here. Or provide custom folder url on your server. Songs will be loaded from folder when player runs in page.', HAP_TEXTDOMAIN); ?></p>

		        <p id="json_accordion_info" class="info"><?php esc_html_e('Accordion mode is a special mode that creates an accordion playlist from each folder of audio files. Upload json file which contains data for accordion mode.', HAP_TEXTDOMAIN); ?></p> 

		        <p id="folder_backend_info" class="info"><?php esc_html_e('Place your folder with audio files in \'wp-content/uploads/map-file-dir\' directory and enter folder name here. Or provide custom folder url on your server. Songs will be loaded from folder now.', HAP_TEXTDOMAIN); ?></p>

		        <p id="xml_info" class="info"><?php esc_html_e('Enter XML url. File needs to be located on the same domain. Example of XML file is located in plugin package.', HAP_TEXTDOMAIN); ?></p>

		        <p id="json_info" class="info"><?php esc_html_e('Enter json or txt url. File needs to be located on the same domain. Example of json file is located in plugin package.', HAP_TEXTDOMAIN); ?></p>

		        <p id="hls_info" class="info"><?php esc_html_e('Add link to m3u8.', HAP_TEXTDOMAIN); ?></p>

		        <p id="m3u_info" class="info"><?php esc_html_e('Enter m3u url. Example of m3u playlist file is located in plugin package.', HAP_TEXTDOMAIN); ?></p>

		        <p id="yt_video_info" class="info"><?php esc_html_e('Enter one or more video IDs separated by comma and no spacing. For example:', HAP_TEXTDOMAIN); ?> tb935IxGBt4</p>

	            <p id="yt_playlist_info" class="info"><?php esc_html_e('Enter playlist ID part. For example:', HAP_TEXTDOMAIN); ?> PLFgquLnL59alCl_2TQvOiD5Vgm1hCaGSI</p>

	            <p id="shoutcast_info" class="info">
	            	SHOUTCAST URL:<br/>
					http://[domain]:[port]/;<br/>
					OR<br/>
					http://[ip]:[port]/;<br/><br/>
	            </p>

	            <p id="icecast_info" class="info">
	            	ICECAST URL<br/>
					http://[domain]:[port]/<br/><br/>
	            </p>

	            <p id="radiojar_info" class="info">
	            	RADIOJAR URL<br/>
					http://[domain]:[port]
	            </p>

		    </td>
		</tr>

		<tr valign="top" id="folder_custom_url_field">
			<th><?php esc_html_e('Is custom folder url', HAP_TEXTDOMAIN); ?></th>
			<td>
				<label><input id="folder_custom_url" name="folder_custom_url" type="checkbox" value="1"> <?php esc_html_e('Select this if you are reading custom folder url on your server.', HAP_TEXTDOMAIN); ?></label>
		    </td>
		</tr>

		<tr valign="top" id="active_accordion_field">
			<th><?php esc_html_e('Active accordion on start', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" name="active_accordion" id="active_accordion">
				<p class="info"><?php esc_html_e('Active accordion on start (default is first). We use folder name if we want to specify which accordion to load on start.', HAP_TEXTDOMAIN); ?></p>
		    </td>
		</tr>

		<tr valign="top" id="audio_preview_field">
			<th><?php esc_html_e('Audio preview url', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="audio_preview" name="audio_preview">
		        <button id="audio_preview_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
		        <p class="info"><?php esc_html_e('Set short song preview to play instead of a full song. This can be used so users can preview the song before purchase.', HAP_TEXTDOMAIN); ?></p>
		    </td>
		</tr>

		<tr valign="top" id="peak_field" style="display:none;">
			<th><?php esc_html_e('Waveform peaks', HAP_TEXTDOMAIN); ?></th>
			<td>
				<textarea id="peaks" name="peaks" rows="2"></textarea>
				<p class="info"><?php esc_html_e('Waveform peaks are automatically created when you upload audio.', HAP_TEXTDOMAIN); ?></p>
		    </td>
		</tr>

		<tr valign="top" id="shoutcast_version_field">
			<th><?php esc_html_e('Shoutcast version', HAP_TEXTDOMAIN); ?></th>
			<td> 
				<select id="shoutcast_version" name="shoutcast_version">
					<option value="2"><?php esc_html_e('version 2', HAP_TEXTDOMAIN); ?></option>
	                <option value="1"><?php esc_html_e('version 1', HAP_TEXTDOMAIN); ?></option>
	            </select>
			</td>
		</tr>

		<tr valign="top" id="sid_field">
			<th><?php esc_html_e('Shoutcast stream SID', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="sid" name="sid">
				<p class="info"><?php esc_html_e('Shoutcast stream SID (default 1).', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

		<tr valign="top" id="mountpoint_field">
			<th><?php esc_html_e('Mountpoint', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="mountpoint" name="mountpoint">
			</td>
		</tr>

		<tr valign="top" id="id3_field">
			<th><?php esc_html_e('Read ID3 tags', HAP_TEXTDOMAIN); ?></th>
			<td>
				<label><input id="id3" name="id3" type="checkbox" value="1"> <?php esc_html_e('Get song information using ID3 tags.', HAP_TEXTDOMAIN); ?></label>
		    </td>
		</tr>

		<tr valign="top" id="folder_sort_field">
			<th><?php esc_html_e('Sort method', HAP_TEXTDOMAIN); ?></th>
			<td>
				<select id="folder_sort" name="folder_sort">
		            <?php foreach ($folder_sort as $key => $value) : ?>
		                <option value="<?php echo($key); ?>"><?php echo($value); ?></option>
		            <?php endforeach; ?>
		        </select><br>
	            <p class="info"><?php esc_html_e('Sort method when reading files from directory.', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

		<tr valign="top" id="gdrive_sort_field">
			<th><?php esc_html_e('Sort method', HAP_TEXTDOMAIN); ?></th>
			<td>
				<select id="gdrive_sort" name="gdrive_sort">
		            <?php foreach ($gdrive_sort as $key => $value) : ?>
		                <option value="<?php echo($key); ?>"><?php echo($value); ?></option>
		            <?php endforeach; ?>
		        </select><br>
	            <p class="info"><?php esc_html_e('Sort method when reading files from directory.', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

		<tr valign="top" id="limit_field">
			<th><?php esc_html_e('Results limit', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="number" id="limit" name="limit" min="1" step="1"><br>
				<p class="info"><?php esc_html_e('Number of results to retrieve (default:all).', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

		<tr valign="top" id="load_more_field">
			<th><?php esc_html_e('Enable Load more', HAP_TEXTDOMAIN); ?></th>
			<td>
				<label><input id="load_more" name="load_more" type="checkbox" value="1" > <?php esc_html_e('Load more songs on total scroll in player. Works with Youtube playlist, Soundcloud, Folder of audio files, Podcast. Works in conjuntion with Results limit option (for example, set Results limit 10 which will show 10 songs in playlist on start, then on total scroll, it will load another 10, and so on..) You can only use load more when you have one media in playlist, for example one Podcast or one Youtube playlist!', HAP_TEXTDOMAIN); ?></label>
			</td>
		</tr>

		<tr valign="top" id="title_field">
			<th><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="title" name="title">
			</td>
		</tr>

		<tr valign="top" id="artist_field">
			<th><?php esc_html_e('Artist', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="artist" name="artist">
			</td>
		</tr>

		<tr valign="top" id="album_field">
			<th><?php esc_html_e('Album', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="album" name="album">
			</td>
		</tr>

		<tr valign="top" id="description_field">
			<th><?php esc_html_e('Description', HAP_TEXTDOMAIN); ?></th>
			<td>
				<textarea id="description" name="description" rows="2" placeholder="<?php esc_attr_e('HTML allowed', HAP_TEXTDOMAIN); ?>"></textarea><br>
				<label><input id="description_is_html" name="description_is_html" type="checkbox" value="1"> <?php esc_html_e('Check this if you use HTML in description.', HAP_TEXTDOMAIN); ?></label>
			</td>
		</tr>

		<tr valign="top" id="thumb_field">
			<th><?php esc_html_e('Thumbnail', HAP_TEXTDOMAIN); ?></th>
			<td>
				<img id="thumb_preview" class="hap-img-preview" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="">
				<input type="text" id="thumb" name="thumb">
		        <button id="thumb_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
		        <button id="thumb_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button>
			</td>
		</tr>

		<input type="hidden" id="thumb_small" name="thumb_small">

		<tr valign="top" id="thumb_default_field">
			<th><?php esc_html_e('Default thumbnail', HAP_TEXTDOMAIN); ?></th>
			<td>
				<img id="thumb_default_preview" class="hap-img-preview" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt="">
				<input type="text" id="thumb_default" name="thumb_default">
		        <button id="thumb_default_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
		        <button id="thumb_default_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button><br>
		        <p class="info"><?php esc_html_e('Default thumbnail path for songs that do not have thumbnail available with api.', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

		<tr valign="top" id="thumb_alt_field">
            <th><?php esc_html_e('Thumbnail alt text', HAP_TEXTDOMAIN); ?></th>
            <td>
                <input type="text" id="thumb_alt" name="thumb_alt" placeholder="">
            </td>
        </tr>

		<tr valign="top" id="lyrics_field">
			<th><?php esc_html_e('Lyrics file', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="lyrics" name="lyrics">
		        <button id="lyrics_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
				<p class="info"><?php esc_html_e('Add lyrics file (same domain restriction applies). Use txt extension if you cannot upload custom extension (lrc, vtt, srt).', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

        <tr valign="top" id="duration_field">
			<th><?php esc_html_e('Duration', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="number" id="duration" name="duration">
				<p class="info"><?php esc_html_e('Duration in seconds.', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

		<tr valign="top" id="download_field">
			<th><?php esc_html_e('Download url', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="download" name="download">
		        <button id="download_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
		        <br>
				<p class="info"><?php esc_html_e('Playlist item download link.', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

		<tr valign="top" id="link_field">
			<th><?php esc_html_e('Url link', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="link" name="link">
				<select id="target" name="target" style="width: 100px; vertical-align: bottom;">
		            <?php foreach ($target as $key => $value) : ?>
		                <option value="<?php echo($key); ?>"><?php echo($value); ?></option>
		            <?php endforeach; ?>
		        </select>
				<p class="info"><?php esc_html_e('Playlist item url link.', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

		<tr valign="top" id="playlist_icons_field">
			<th><?php esc_html_e('Additional playlist icons', HAP_TEXTDOMAIN); ?></th>
			<td>

				<div class="hap-pi-table-section">

                <div id="hap-pi-table-wrap" class="hap-value-table-wrap"></div>

                <p class="info"><?php esc_html_e('Create additional icons in playlist and attach url to them.', HAP_TEXTDOMAIN); ?></p>

                <button type="button" id="pi_add"><?php esc_html_e('Add icon', HAP_TEXTDOMAIN); ?></button><br><br>

                <table class="hap-pi-table-orig" style="display:none;">
                  <thead>
                    <tr>
                      <th align="left"><?php esc_html_e('Title', HAP_TEXTDOMAIN); ?></th>
                      <th align="left"><?php esc_html_e('Url', HAP_TEXTDOMAIN); ?></th>
                      <th align="left"><?php esc_html_e('Target', HAP_TEXTDOMAIN); ?></th>
                      <th align="left"><?php esc_html_e('Select icon', HAP_TEXTDOMAIN); ?></th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <tr class="hap-pi">
                      <td><input type="text" class="pi-title" placeholder="<?php esc_attr_e('Title shown on hover', HAP_TEXTDOMAIN); ?>"></td>
                      <td><input type="text" class="pi-url"></td>
                      <td><select class="pi-target">
			            <?php foreach ($target as $key => $value) : ?>
			                <option value="<?php echo($key); ?>"><?php echo($value); ?></option>
			            <?php endforeach; ?>
			          </select>
			          </td>
                      <td><select class="pi-icon">
			              <option value="f1bc">Spotify &#xf1bc;</option>
						  <option value="f167">Youtube &#xf167;</option>
						  <option value="f1be">Soundcloud &#xf1be;</option>
						  <option value="f270">Amazon &#xf270;</option>
						  <option value="f3d9">Patreon &#xf3d9;</option>
						  <option value="f179">Apple &#xf179;</option>
						  <option value="" class="pi-icon-value"><?php esc_html_e('Other', HAP_TEXTDOMAIN); ?></option>
			         </select><br>

			         <p class="pi-icon-custom-wrap">
			         <input type="text" placeholder="<?php esc_attr_e('Font Awesome unicode', HAP_TEXTDOMAIN); ?>" title="<?php esc_attr_e('Add Font Awesome unicode (example f187)', HAP_TEXTDOMAIN); ?>" class="pi-icon-custom"><br>
			         <span class="info"><a href="https://fontawesome.com/cheatsheet" target="_blank"><?php esc_html_e('Font Awesome unicode cheatsheet', HAP_TEXTDOMAIN); ?></a></span>
			         </p>

					  </td>
                      <td><button type="button" class="pi_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button></td>
                    </tr>
                  </tbody>
                </table>

			</td>
		</tr>

		<tr valign="top" id="start_field">
			<th><?php esc_html_e('Start time in seconds', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="number" id="start" name="start" min="0" step="1">
			</td>
		</tr>

		<tr valign="top" id="end_field">
			<th><?php esc_html_e('End time in seconds', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="number" id="end" name="end" min="0" step="1">
			</td>
		</tr>

		<tr valign="top" id="video_field">
			<th><?php esc_html_e('Video', HAP_TEXTDOMAIN); ?></th>
			<td>
				<input type="text" id="video" name="video">
				<button id="video_upload"><?php esc_html_e('Upload', HAP_TEXTDOMAIN); ?></button>
				<button id="video_remove"><?php esc_html_e('Remove', HAP_TEXTDOMAIN); ?></button>
		        <br>
				<p class="info"><?php esc_html_e('Add video which will be syncronized with audio.', HAP_TEXTDOMAIN); ?></p>
			</td>
		</tr>

		<tr valign="top" id="genres_field">
            <th><?php esc_html_e('Genres', HAP_TEXTDOMAIN); ?></th>
            <td>
            	<div id="hap-media-category-wrap"></div>
                <button type="button" id="hap-media-category"><?php esc_html_e('Add genre', HAP_TEXTDOMAIN); ?></button>
            </td>
        </tr>

        <tr valign="top" id="keywords_field">
            <th><?php esc_html_e('Keywords', HAP_TEXTDOMAIN); ?></th>
            <td>
            	<div id="hap-media-tag-wrap"></div>
                <button type="button" id="hap-media-tag"><?php esc_html_e('Add keywords', HAP_TEXTDOMAIN); ?></button>
            </td>
        </tr>

        <tr valign="top" id="additional_playlist_field">
	        <th><strong><?php esc_html_e('Add song to additional playlists', HAP_TEXTDOMAIN); ?></strong></th>
	        <td>
	            <select id="hap-add-media-playlist-list" multiple>
	                <?php foreach($additional_playlists as $playlist) : ?>

	                    <?php if($playlist['id'] != $playlist_id) : ?>
	                    <option value="<?php echo($playlist['id']); ?>"><?php echo($playlist['title']); echo(' - ID #' . $playlist['id']); ?></option>
	                    <?php endif; ?>    

	                <?php endforeach; ?>    
	            </select>

	            <button type="button" id="hap-clear-additional-playlist"><?php esc_html_e('Clear selected', HAP_TEXTDOMAIN); ?></button>

	            <input type="hidden" id="hap-additional-playlist">

	            <p class="info"><?php esc_html_e('By default, song is added to current working playlist. You can select additional playlists to add this song to.', HAP_TEXTDOMAIN); ?></p>
	        </td>
	    </tr>

	</tbody>
			
</table>

<div id="hap-ws-waveform"></div>
