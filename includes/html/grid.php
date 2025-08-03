<?php

    function hap_html_grid($preset, $wrapper_id, $options){

        $infoSkin = ' hap-'.$options['infoSkin'];

        $markup = '<div id="'.$wrapper_id.'" class="hap-music-player hap-'.$preset.$infoSkin.'">

        <div class="hap-player-wrap">';

        //search field
        if($options["useSearch"]){

            $markup .= '<div class="hap-playlist-bar">
                <input class="hap-search-filter" type="text" autocapitalize="none" placeholder="'.esc_html($options["filterText"]).'">
            </div>
            <div class="hap-playlist-filter-msg"><span>'.esc_html($options["filterNothingFoundMsg"]).'</span></div>';

        }

        $markup .= '<div class="hap-playlist-content"></div>';

        $markup .= '<div class="hap-lyrics-holder hap-dialog">

                <div class="hap-dialog-header">

                    <div class="hap-dialog-header-drag"></div>
                    <label class="hap-lyrics-autoscroll-label" title="'.esc_attr($options["lyricsAutoScrollText"]).'"><input class="hap-lyrics-autoscroll" type="checkbox"> '.esc_html($options["lyricsAutoScrollText"]).'</label>  

                    <div class="hap-lyrics-close hap-dialog-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'" title="'.esc_attr($options["tooltipClose"]).'">
                        <svg viewBox="0 0 320 512"><path d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z"></path></svg>
                    </div>
                </div>

                <div class="hap-dialog-content">
                    <div class="hap-lyrics-wrap">
                        <div class="hap-lyrics-container"></div>
                    </div>
                </div>

                <div class="hap-dialog-resizable" title="'.esc_attr($options["dialogResizeTitle"]).'"></div>

            </div>

            <div class="hap-video-holder hap-dialog">

                <div class="hap-dialog-header">

                    <div class="hap-dialog-header-drag"></div>

                    <div class="hap-video-close hap-dialog-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'" title="'.esc_attr($options["tooltipClose"]).'">
                        <svg viewBox="0 0 320 512"><path d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z"></path></svg>
                    </div>
                </div>

                <div class="hap-dialog-content">
                    <div class="hap-video-wrap"></div>
                </div>

                <div class="hap-dialog-resizable" title="'.esc_attr($options["dialogResizeTitle"]).'"></div>

            </div>

        <div class="hap-load-more-btn">'.esc_html($options["loadMoreBtnText"]).'</div>

        <div class="hap-preloader"></div>

        </div>';

    	return $markup;

    }

?>