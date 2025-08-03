<?php

function hap_html_brona($preset, $wrapper_id, $options){

    $preset = str_replace("_", "-", $preset);

	$markup = '<div id="'.$wrapper_id.'" class="hap-music-player hap-brona hap-'.$preset.'" >

        <div class="hap-player-outer">

		    <div class="hap-player-holder">
             
                <div class="hap-player-thumb-wrapper">
                    <div class="hap-player-thumb"></div>
                </div>

                <div class="hap-player-right">

                    <div class="hap-center-elements">

                        <div class="hap-info">
                            <div class="hap-player-title"></div>
                            <div class="hap-player-artist"></div>
                        </div>

                        <div class="hap-seekbar-wrap">

                            <div class="hap-media-time"> 
                                <div class="hap-media-time-current">0:00</div>
                                <div class="hap-media-time-total">0:00</div>
                            </div>
                            <div class="hap-media-time-ad">'.esc_html($options["adMessage"]).'&nbsp;<span></span></div>

                            <div class="hap-seekbar">
                                <div class="hap-progress-bg">
                                    <div class="hap-load-level">
                                        <div class="hap-progress-level"></div>
                                    </div>
                                </div>

                            </div> 

                        </div> 

                        <div class="hap-controls">

                            <div class="hap-controls-left">

                                <div class="hap-prev-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipPrevious"]).'">
                                    <i class="material-icons">skip_previous</i>
                                </div>
                                <div class="hap-playback-toggle hap-contr-btn">
                                    <div class="hap-btn hap-btn-play" data-tooltip="'.esc_attr($options["tooltipPlay"]).'">
                                        <i class="material-icons">play_arrow</i>
                                    </div>
                                    <div class="hap-btn hap-btn-pause" data-tooltip="'.esc_attr($options["tooltipPause"]).'">
                                        <i class="material-icons">pause</i>
                                    </div>
                                </div>
                                <div class="hap-next-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipNext"]).'">
                                    <i class="material-icons">skip_next</i>
                                </div>';

                                if($options["useSkipBackward"])$markup .= '<div class="hap-skip-backward hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipSkipBackward"]).'" data-skip-time="'.esc_attr($options["seekTime"]).'">
                                    <i class="material-icons">replay_10</i>
                                </div>';

                                if($options["useSkipForward"])$markup .= '<div class="hap-skip-forward hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipSkipForward"]).'" data-skip-time="'.esc_attr($options["seekTime"]).'">
                                    <i class="material-icons">forward_10</i>
                                </div>';

                                $markup .= '<div class="hap-volume-wrap hap-contr-btn">
                                    <div class="hap-volume-toggle hap-contr-btn hap-volume-toggable" data-tooltip="'.esc_attr($options["tooltipVolume"]).'">
                                        <div class="hap-btn hap-btn-volume-up">
                                            <i class="material-icons">volume_up</i>
                                        </div>
                                        <div class="hap-btn hap-btn-volume-down">
                                            <i class="material-icons">volume_down</i>
                                        </div>
                                        <div class="hap-btn hap-btn-volume-off">
                                            <i class="material-icons">volume_off</i>
                                        </div>
                                    </div>
                                    <div class="hap-volume-seekbar">
                                        <div class="hap-volume-bg">
                                            <div class="hap-volume-level"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>  

                            <div class="hap-controls-right">';

                                if($options["useShuffle"])$markup .= '<div class="hap-random-toggle hap-contr-btn">
                                    <div class="hap-btn hap-btn-random-off" data-tooltip="'.esc_attr($options["tooltipShuffleOff"]).'">
                                        <i class="material-icons">shuffle</i>
                                    </div>
                                    <div class="hap-btn hap-btn-random-on hap-contr-btn-hover" data-tooltip="'.esc_attr($options["tooltipShuffleOn"]).'">
                                        <i class="material-icons">shuffle</i>
                                    </div>
                                </div>';

                                if($options["useLoop"])$markup .= '<div class="hap-loop-toggle hap-contr-btn">
                                    <div class="hap-btn hap-btn-loop-playlist hap-contr-btn-hover" data-tooltip="'.esc_attr($options["tooltipLoopStatePlaylist"]).'">
                                        <i class="material-icons">repeat</i>
                                    </div>
                                    <div class="hap-btn hap-btn-loop-single hap-contr-btn-hover" data-tooltip="'.esc_attr($options["tooltipLoopStateSingle"]).'">
                                        <i class="material-icons">repeat_one</i>
                                    </div> 
                                    <div class="hap-btn hap-btn-loop-off" data-tooltip="'.esc_attr($options["tooltipLoopStateOff"]).'">
                                        <i class="material-icons">repeat</i>
                                    </div>        
                                </div>';

                                if($options["useShare"])$markup .= '<div class="hap-share-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipShare"]).'">
                                    <i class="material-icons">share</i>
                                </div>';

                                if($options["usePlaybackRate"])$markup .= '<div class="hap-playback-rate-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipPlaybackRate"]).'">
                                    <i class="material-icons">speed</i>
                                </div>';

                                if($options["useRange"])$markup .= '<div class="hap-range-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipRange"]).'">
                                    <i class="material-icons">loop</i>
                                </div>';

                                $markup .= '<div class="hap-video-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipVideo"]).'">
                                    <i class="material-icons">ondemand_video</i>
                                </div>

                                <div class="hap-lyrics-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipLyrics"]).'">
                                    <i class="material-icons">description</i>
                                </div>';

                                if($options["usePlaylist"])$markup .= '<div class="hap-playlist-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipPlaylistOpen"]).'">
                                    <i class="material-icons">view_headline</i>
                                </div>';

                                if($options["usePopup"])$markup .= '<div class="hap-popup-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipPopup"]).'">
                                    <i class="material-icons">open_in_new</i>
                                </div>';

                            $markup .= '</div>

                        </div>  

                    </div>  
               
                </div>
                  
            </div>';

            if($options["usePlaylist"]){

                $markup .= '<div class="hap-playlist-holder">';

                    if($options["useSearch"])$markup .= '<div class="hap-playlist-filter-msg"><span>'.esc_html($options["filterNothingFoundMsg"]).'</span></div>';

                    $markup .= '<div class="hap-playlist-inner">
                        <div class="hap-playlist-content"></div>
                    </div>';
                
                    if($options["useSearch"]){                        
                        $markup .= '<div class="hap-bottom-bar">
                            <input class="hap-search-filter" autocapitalize="none" type="text" placeholder="'.esc_html($options["filterText"]).'" title="'.esc_attr($options["filterText"]).'">
                        </div>';
                    }    
                    
                $markup .= '</div>';

            }

            if($options["useShare"]){

                $markup .= '<div class="hap-share-holder">
                  
                    <div class="hap-share-holder-inner">';
                        if($options["useShareTumblr"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="tumblr" data-tooltip="'.esc_attr($options["tooltipTumblr"]).'">
                            
                            <svg viewBox="0 0 510 510"><path d="M459,0H51C22.95,0,0,22.95,0,51v408c0,28.05,22.95,51,51,51h408c28.05,0,51-22.95,51-51V51C510,22.95,487.05,0,459,0z  M357,229.5h-76.5c0,0,0,96.9,0,99.45c0,17.85,2.55,28.05,28.05,28.05c22.95,0,48.45,0,48.45,0v76.5c0,0-25.5,2.55-53.55,2.55  c-66.3,0-99.45-40.8-99.45-86.7c0-30.6,0-119.85, 0-119.85h-51v-71.4c61.2-5.1,66.3-51,71.4-81.6h56.1V153H357V229.5z"/></svg>

                        </div>';
                        if($options["useShareTwitter"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="twitter" data-tooltip="'.esc_attr($options["tooltipTwitter"]).'">
                            
                            <svg viewBox="0 0 510 510"><path d="M459,0H51C22.95,0,0,22.95,0,51v408c0,28.05,22.95,51,51,51h408c28.05,0,51-22.95,51-51V51C510,22.95,487.05,0,459,0z M400.35,186.15c-2.55,117.3-76.5,198.9-188.7,204C165.75,392.7,132.6,377.4,102,359.55c33.15,5.101,76.5-7.649,99.45-28.05 c-33.15-2.55-53.55-20.4-63.75-48.45c10.2,2.55,20.4,0,28.05,0c-30.6-10.2-51-28.05-53.55-68.85c7.65,5.1,17.85,7.65,28.05,7.65 c-22.95-12.75-38.25-61.2-20.4-91.8c33.15,35.7,73.95,66.3,140.25,71.4c-17.85-71.4,79.051-109.65,117.301-61.2 c17.85-2.55,30.6-10.2,43.35-15.3c-5.1,17.85-15.3,28.05-28.05,38.25c12.75-2.55,25.5-5.1,35.7-10.2 C425.85,165.75,413.1,175.95,400.35,186.15z"/></svg>

                        </div>';
                        if($options["useShareFacebook"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="facebook" data-tooltip="'.esc_attr($options["tooltipFacebook"]).'">
                            
                            <svg viewBox="0 0 510 510"><path d="M459,0H51C22.95,0,0,22.95,0,51v408c0,28.05,22.95,51,51,51h408c28.05,0,51-22.95,51-51V51C510,22.95,487.05,0,459,0z M433.5,51v76.5h-51c-15.3,0-25.5,10.2-25.5,25.5v51h76.5v76.5H357V459h-76.5V280.5h-51V204h51v-63.75    C280.5,91.8,321.3,51,369.75,51H433.5z"/></svg>

                        </div>';
                        if($options["useShareWhatsApp"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="whatsapp" data-tooltip="'.esc_attr($options["tooltipWhatsApp"]).'">
                            
                            <svg viewBox="0 0 512 512"><path d="m261.476562 124.46875c-70.246093 0-127.375 57.105469-127.40625 127.300781-.007812 24.054688 6.726563 47.480469 19.472657 67.75l3.027343 4.816407-12.867187 46.980468 48.199219-12.640625 4.652344 2.757813c19.550781 11.601562 41.964843 17.738281 64.816406 17.746094h.050781c70.191406 0 127.320313-57.109376 127.351563-127.308594.011718-34.019532-13.222657-66.003906-37.265626-90.066406-24.042968-24.0625-56.019531-37.324219-90.03125-37.335938zm74.90625 182.035156c-3.191406 8.9375-18.484374 17.097656-25.839843 18.199219-6.597657.984375-14.941407 1.394531-24.113281-1.515625-5.5625-1.765625-12.691407-4.121094-21.828126-8.0625-38.402343-16.578125-63.484374-55.234375-65.398437-57.789062-1.914063-2.554688-15.632813-20.753907-15.632813-39.59375 0-18.835938 9.890626-28.097657 13.398438-31.925782 3.511719-3.832031 7.660156-4.789062 10.210938-4.789062 2.550781 0 5.105468.023437 7.335937.132812 2.351563.117188 5.507813-.894531 8.613281 6.570313 3.191406 7.664062 10.847656 26.5 11.804688 28.414062.957031 1.917969 1.59375 4.152344.320312 6.707031-1.277344 2.554688-7.300781 10.25-9.570312 13.089844-1.691406 2.109375-3.914063 3.980469-1.679688 7.8125 2.230469 3.828125 9.917969 16.363282 21.296875 26.511719 14.625 13.039063 26.960938 17.078125 30.789063 18.996094 3.824218 1.914062 6.058594 1.59375 8.292968-.957031 2.230469-2.554688 9.570313-11.175782 12.121094-15.007813 2.550782-3.832031 5.105469-3.191406 8.613282-1.914063 3.511718 1.273438 22.332031 10.535157 26.160156 12.449219 3.828125 1.917969 6.378906 2.875 7.335937 4.472657.960938 1.597656.960938 9.257812-2.230469 18.199218zm0 0"/><path d="m475.074219 0h-438.148438c-20.394531 0-36.925781 16.53125-36.925781 36.925781v438.148438c0 20.394531 16.53125 36.925781 36.925781 36.925781h438.148438c20.394531 0 36.925781-16.53125 36.925781-36.925781v-438.148438c0-20.394531-16.53125-36.925781-36.925781-36.925781zm-213.648438 405.050781c-.003906 0 .003907 0 0 0h-.0625c-25.644531-.011719-50.84375-6.441406-73.222656-18.644531l-81.222656 21.300781 21.738281-79.375c-13.410156-23.226562-20.464844-49.578125-20.453125-76.574219.035156-84.453124 68.769531-153.160156 153.222656-153.160156 40.984375.015625 79.457031 15.96875 108.382813 44.917969 28.929687 28.953125 44.851562 67.4375 44.835937 108.363281-.035156 84.457032-68.777343 153.171875-153.21875 153.171875zm0 0"/></svg>

                        </div>';
                        if($options["useShareLinkedIn"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="linkedin" data-tooltip="'.esc_attr($options["tooltipLinkedIn"]).'">
                            
                            <svg viewBox="0 0 512 512"><path d="m475.074219 0h-438.148438c-20.394531 0-36.925781 16.53125-36.925781 36.925781v438.148438c0 20.394531 16.53125 36.925781 36.925781 36.925781h438.148438c20.394531 0 36.925781-16.53125 36.925781-36.925781v-438.148438c0-20.394531-16.53125-36.925781-36.925781-36.925781zm-293.464844 387h-62.347656v-187.574219h62.347656zm-31.171875-213.1875h-.40625c-20.921875 0-34.453125-14.402344-34.453125-32.402344 0-18.40625 13.945313-32.410156 35.273437-32.410156 21.328126 0 34.453126 14.003906 34.859376 32.410156 0 18-13.53125 32.402344-35.273438 32.402344zm255.984375 213.1875h-62.339844v-100.347656c0-25.21875-9.027343-42.417969-31.585937-42.417969-17.222656 0-27.480469 11.601563-31.988282 22.800781-1.648437 4.007813-2.050781 9.609375-2.050781 15.214844v104.75h-62.34375s.816407-169.976562 0-187.574219h62.34375v26.558594c8.285157-12.78125 23.109375-30.960937 56.1875-30.960937 41.019531 0 71.777344 26.808593 71.777344 84.421874zm0 0"/></svg>

                        </div>';
                        if($options["useShareReddit"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="reddit" data-tooltip="'.esc_attr($options["tooltipReddit"]).'">
                           
                            <svg viewBox="0 0 512 512"><path d="m224 282.675781c0-14.695312-11.980469-26.675781-26.675781-26.675781-14.691407 0-26.675781 11.980469-26.675781 26.675781 0 14.691407 11.984374 26.675781 26.675781 26.675781 14.695312 0 26.675781-11.980468 26.675781-26.675781zm0 0"/><path d="m309.605469 343.347656c-11.46875 11.46875-36.042969 15.5625-53.554688 15.5625-17.5625 0-42.085937-4.09375-53.554687-15.5625-2.714844-2.714844-7.066406-2.714844-9.777344 0-2.714844 2.714844-2.714844 7.066406 0 9.777344 18.175781 18.175781 53.09375 19.609375 63.332031 19.609375s45.105469-1.433594 63.335938-19.609375c2.660156-2.714844 2.660156-7.066406 0-9.777344-2.714844-2.714844-7.066407-2.714844-9.78125 0zm0 0"/><path d="m314.675781 256c-14.695312 0-26.675781 11.980469-26.675781 26.675781 0 14.691407 11.980469 26.675781 26.675781 26.675781 14.691407 0 26.675781-11.984374 26.675781-26.675781 0-14.695312-11.980468-26.675781-26.675781-26.675781zm0 0"/><path d="m475.074219 0h-438.148438c-20.394531 0-36.925781 16.53125-36.925781 36.925781v438.148438c0 20.394531 16.53125 36.925781 36.925781 36.925781h438.148438c20.394531 0 36.925781-16.53125 36.925781-36.925781v-438.148438c0-20.394531-16.53125-36.925781-36.925781-36.925781zm-70.542969 290.148438c.5625 3.6875.871094 7.425781.871094 11.214843 0 57.445313-66.867188 103.988281-149.351563 103.988281s-149.351562-46.542968-149.351562-103.988281c0-3.839843.308593-7.628906.871093-11.316406-13.003906-5.835937-22.066406-18.890625-22.066406-34.046875 0-20.582031 16.691406-37.324219 37.324219-37.324219 10.035156 0 19.097656 3.941407 25.804687 10.394531 25.90625-18.6875 61.75-30.621093 101.632813-31.644531 0-.511719 18.636719-89.292969 18.636719-89.292969.359375-1.738281 1.382812-3.226562 2.867187-4.195312 1.484375-.972656 3.277344-1.28125 5.019531-.921875l62.054688 13.207031c4.351562-8.804687 13.308594-14.898437 23.804688-14.898437 14.746093 0 26.675781 11.929687 26.675781 26.675781s-11.929688 26.675781-26.675781 26.675781c-14.285157 0-25.855469-11.265625-26.519532-25.394531l-55.554687-11.828125-16.996094 80.027344c39.167969 1.378906 74.34375 13.257812 99.839844 31.691406 6.707031-6.5 15.820312-10.496094 25.90625-10.496094 20.636719 0 37.324219 16.691407 37.324219 37.324219 0 15.257812-9.164063 28.3125-22.117188 34.148438zm0 0"/></svg>

                        </div>';
                        if($options["useShareDigg"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="digg" data-tooltip="'.esc_attr($options["tooltipDigg"]).'">
                            
                            <svg viewBox="0 0 94 94"><rect x="73.514" y="40.761" width="4.68" height="14.038"/><rect x="15.81" y="40.761" width="4.679" height="14.038"/><rect x="50.119" y="40.761" width="4.679" height="14.038"/><path d="M89,0H5C2.238,0,0,2.238,0,5v84c0,2.762,2.238,5,5,5h84c2.762,0,5-2.238,5-5V5C94,2.238,91.762,0,89,0z M28.286,61.035 H8.012V34.522h12.477V23.606h7.798L28.286,61.035L28.286,61.035z M39.202,61.035h-7.797V34.522h7.797V61.035z M39.202,31.405 h-7.797v-7.799h7.797V31.405z M62.596,70.395H42.321v-6.239h12.477v-3.119H42.321V34.522h20.273v35.873H62.596z M85.988,70.395 H65.716v-6.239h12.478v-3.119H65.716V34.522h20.272V70.395z"/>
                            </svg>

                        </div>';
                        if($options["useSharePinterest"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="pinterest" data-tooltip="'.esc_attr($options["tooltipPinterest"]).'">
                           
                            <svg viewBox="0 0 510 510"><path d="M459,0H51C22.95,0,0,22.95,0,51v408c0,28.05,22.95,51,51,51h408c28.05,0,51-22.95,51-51V51C510,22.95,487.05,0,459,0z M280.5,362.1c-20.4,0-40.8-7.649-53.55-22.949l-25.5,81.6l-2.55,5.1l0,0c-5.1,7.65-12.75,12.75-22.95,12.75 c-15.3,0-28.05-12.75-28.05-28.05c0-2.55,0-2.55,0-2.55l0,0l2.55-5.1l45.9-142.801c0,0-5.1-15.3-5.1-38.25 c0-43.35,22.95-56.1,43.35-56.1c17.85,0,35.7,7.65,35.7,33.15c0,33.15-22.95,51-22.95,76.5c0,17.85,15.3,33.149,33.15,33.149 c58.65,0,81.6-45.899,81.6-86.7c0-56.1-48.449-102-107.1-102c-58.65,0-107.1,45.9-107.1,102c0,17.85,5.1,33.15,12.75,48.45 c2.55,5.101,2.55,7.65,2.55,12.75c0,15.3-10.2,25.5-25.5,25.5c-10.2,0-17.85-5.1-22.95-12.75c-12.75-22.95-20.4-48.45-20.4-76.5 c0-84.15,71.4-153,158.1-153s158.1,68.85,158.1,153C413.1,290.7,372.3,362.1,280.5,362.1z"/></svg>

                        </div>

                    </div>      

                    <div class="hap-share-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'">
                        <i class="material-icons">close</i>
                    </div>
                    
                </div>';

            }

            if($options["usePlaybackRate"]){

                $markup .= '<div class="hap-playback-rate-holder">

                    <div class="hap-playback-rate-wrap">
                        <div class="hap-playback-rate-min"></div>
                        <div class="hap-playback-rate-seekbar">
                             <div class="hap-playback-rate-bg">
                                <div class="hap-playback-rate-level"><div class="hap-playback-rate-drag"></div></div>
                             </div>
                        </div>
                        <div class="hap-playback-rate-max"></div>
                    </div>

                    <div class="hap-playback-rate-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'">
                            <i class="material-icons">close</i>
                        </div>
                    
                </div>';

            }

            if($options["useRange"]){

                $markup .= '<div class="hap-range-holder">

                    <div class="hap-range-wrap">
                        <div class="hap-range-min-time"></div>
                        <div class="hap-range-seekbar">
                             <div class="hap-range-bg">
                                <div class="hap-range-level"></div>
                                <div class="hap-range-handle-a" data-width="30">
                                    <div class="hap-range-handle-a-hit"><div class="hap-range-handle-a-hit-bg"></div></div> 
                                </div>
                                <div class="hap-range-handle-b" data-width="30">
                                    <div class="hap-range-handle-b-hit"><div class="hap-range-handle-b-hit-bg"></div></div>
                                </div>
                             </div>
                        </div>
                        <div class="hap-range-max-time"></div>
                    </div>

                    <div class="hap-range-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'">
                            <i class="material-icons">close</i>
                        </div>
                    
                </div>';

            }

            $markup .= '<div class="hap-lyrics-holder hap-dialog">

                <div class="hap-dialog-header">

                    <div class="hap-dialog-header-drag"></div>
                    <label class="hap-lyrics-autoscroll-label" title="'.esc_attr($options["lyricsAutoScrollText"]).'"><input class="hap-lyrics-autoscroll" type="checkbox"> '.esc_html($options["lyricsAutoScrollText"]).'</label>  

                    <div class="hap-lyrics-close hap-dialog-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'">
                        <i class="material-icons">close</i>
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

                    <div class="hap-video-close hap-dialog-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'">
                        <i class="material-icons">close</i>
                    </div>
                </div>

                <div class="hap-dialog-content">
                    <div class="hap-video-wrap"></div>
                </div>

                <div class="hap-dialog-resizable" title="'.esc_attr($options["dialogResizeTitle"]).'"></div>

            </div>';

            $markup .= '<div class="hap-tooltip"></div>

            </div> 

            <div class="hap-preloader"></div>';

	return $markup;

}

?>