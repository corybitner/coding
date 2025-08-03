<?php

function hap_html_epic_mini($preset, $wrapper_id, $options){

	$markup = '<div id="'.$wrapper_id.'" class="hap-music-player hap-epic-mini">

        <div class="hap-player-outer">

            <div class="hap-player-holder">

                <div class="hap-player-left">

                    <div class="hap-player-thumb-wrapper">
                        <div class="hap-player-thumb"></div>
                    </div> 

                </div> 

                <div class="hap-player-right">

                    <div class="hap-info">
                        <div class="hap-player-title"></div>
                        <div class="hap-player-title-separator">&nbsp;-&nbsp;</div>
                        <div class="hap-player-artist"></div>
                    </div>

                    <div class="hap-seekbar">  
                        <div class="hap-seekbar-wave">
                            <div class="hap-seekbar-wave-progress"></div>  
                        </div>  
                    </div> 

                    <div class="hap-player-controls">  
                     
                        <div class="hap-prev-toggle hap-contr-btn">
                            <svg viewBox="0 0 10.2 11.7"><polygon points="10.2,0 1.4,5.3 1.4,0 0,0 0,11.7 1.4,11.7 1.4,6.2 10.2,11.7"></polygon></svg>
                        </div>
                        <div class="hap-playback-toggle hap-contr-btn">
                            <div class="hap-btn hap-btn-play" data-tooltip="'.esc_attr($options["tooltipPlay"]).'">
                                <svg viewBox="0 0 17.5 21.2"><path d="M0,0l17.5,10.9L0,21.2V0z"></path></svg>
                            </div>
                            <div class="hap-btn hap-btn-pause" data-tooltip="'.esc_attr($options["tooltipPause"]).'">
                                <svg viewBox="0 0 17.5 21.2"><rect width="6" height="21.2"></rect><rect x="11.5" width="6" height="21.2"></rect></svg>
                            </div>
                        </div>
                        <div class="hap-next-toggle hap-contr-btn">
                            <svg viewBox="0 0 10.2 11.7"><polygon points="0,11.7 8.8,6.4 8.8,11.7 10.2,11.7 10.2,0 8.8,0 8.8,5.6 0,0"></polygon></svg>
                        </div>

                    </div>

                </div>

            </div>    
            
            <div class="hap-tooltip"></div>  

        </div>'; 

        return $markup;

    }

?>