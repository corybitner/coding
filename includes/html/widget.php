<?php

function hap_html_widget($preset, $wrapper_id, $options){

    $markup = '<div id="'.$wrapper_id.'" class="hap-music-player hap-'.$preset.'">

        <div class="hap-player-outer">

            <div class="hap-player-thumb"></div>

            <div class="hap-player-holder">

                <div class="hap-info">
                    <div class="hap-player-title"></div>
                    <div class="hap-player-artist"></div>
                </div>

                <div class="hap-player-controls">
                    <div class="hap-prev-toggle hap-contr-btn">
                        <svg viewBox="0 0 448 512"><path d="M64 468V44c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12v176.4l195.5-181C352.1 22.3 384 36.6 384 64v384c0 27.4-31.9 41.7-52.5 24.6L136 292.7V468c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12z"></path></svg>
                    </div>
                    <div class="hap-playback-toggle hap-contr-btn">
                        <div class="hap-btn hap-btn-play">
                            <svg viewBox="0 0 448 512"><path d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path></svg>
                        </div>
                        <div class="hap-btn hap-btn-pause">
                            <svg viewBox="0 0 448 512"><path d="M144 479H48c-26.5 0-48-21.5-48-48V79c0-26.5 21.5-48 48-48h96c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zm304-48V79c0-26.5-21.5-48-48-48h-96c-26.5 0-48 21.5-48 48v352c0 26.5 21.5 48 48 48h96c26.5 0 48-21.5 48-48z"></path></svg>
                        </div>
                    </div>
                    <div class="hap-next-toggle hap-contr-btn">
                        <svg viewBox="0 0 448 512"><path fill="currentColor" d="M384 44v424c0 6.6-5.4 12-12 12h-48c-6.6 0-12-5.4-12-12V291.6l-195.5 181C95.9 489.7 64 475.4 64 448V64c0-27.4 31.9-41.7 52.5-24.6L312 219.3V44c0-6.6 5.4-12 12-12h48c6.6 0 12 5.4 12 12z"></path></svg>
                    </div>
                </div>

                <div class="hap-volume-seekbar">
                     <div class="hap-volume-bg">
                        <div class="hap-volume-level"><div class="hap-volume-drag"></div></div>
                     </div>
                </div>

                <div class="hap-seekbar">
                    <div class="hap-progress-bg">
                        <div class="hap-load-level"></div>
                        <div class="hap-progress-level"></div>
                    </div>
                </div>

            </div>

            <div class="hap-tooltip"></div>  

            </div>

            <div class="hap-preloader"></div>';

	return $markup;

}

?>