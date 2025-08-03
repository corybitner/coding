<?php

function hap_html_epic($preset, $wrapper_id, $options){

	$markup = '<div id="'.$wrapper_id.'" class="hap-music-player hap-epic">

        <div class="hap-player-outer">

            <div class="hap-player-wrap">

                <div class="hap-player-holder">

                    <div class="hap-player-thumb-wrapper">
                        <div class="hap-player-thumb"></div>
                    </div> 
                      
                </div>

                <div class="hap-playlist-holder">

                    <div class="hap-playlist-main-title"></div>
                    <div class="hap-playlist-main-description"></div>

                    <div class="hap-playlist-inner">
                        <div class="hap-playlist-content">

                        </div>
                    </div>
                </div>  

            </div>

            <div class="hap-seekbar">  
                <div class="hap-seekbar-wave">
                    <div class="hap-seekbar-wave-progress"></div>  
                </div>  
                <div class="hap-media-time-ad">'.esc_html($options["adMessage"]).'&nbsp;<span></span></div>
            </div> 

            <div class="hap-player-controls">  

                <div class="hap-player-controls-left">';  
                    
                    if($options["useSkipBackward"])$markup .= '<div class="hap-skip-backward hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipSkipBackward"]).'">
                        <svg viewBox="0 0 16 16"><polygon points="1,8 8,14 8,8 8,2 "/><polygon points="15,2 8,8 15,14 "/></svg>
                    </div>';

                    $markup .= '<div class="hap-prev-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipPrevious"]).'">
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
                    <div class="hap-next-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipPrevious"]).'">
                        <svg viewBox="0 0 10.2 11.7"><polygon points="0,11.7 8.8,6.4 8.8,11.7 10.2,11.7 10.2,0 8.8,0 8.8,5.6 0,0"></polygon></svg>
                    </div>';
                    
                    if($options["useSkipForward"])$markup .= '<div class="hap-skip-forward hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipSkipForward"]).'">
                        <svg viewBox="0 0 16 16"><polygon points="15,8 8,2 8,8 8,14 "/><polygon points="1,2 1,14 8,8 "/></svg>
                    </div>';

                    $markup .= '<div class="hap-volume-wrap">

                        <div class="hap-volume-toggle hap-contr-btn hap-volume-toggable" data-tooltip="'.esc_attr($options["tooltipVolume"]).'">
                            <div class="hap-btn hap-btn-volume-up">
                                <svg viewBox="0 0 48 48" ><path d="M6 18v12h8l10 10V8L14 18H6zm27 6c0-3.53-2.04-6.58-5-8.05v16.11c2.96-1.48 5-4.53 5-8.06zM28 6.46v4.13c5.78 1.72 10 7.07 10 13.41s-4.22 11.69-10 13.41v4.13c8.01-1.82 14-8.97 14-17.54S36.01 8.28 28 6.46z"/><path d="M0 0h48v48H0z" fill="none"/></svg>
                            </div>
                            <div class="hap-btn hap-btn-volume-down">
                                <svg viewBox="0 0 48 48" ><path d="M37 24c0-3.53-2.04-6.58-5-8.05v16.11c2.96-1.48 5-4.53 5-8.06zm-27-6v12h8l10 10V8L18 18h-8z"/><path d="M0 0h48v48H0z" fill="none"/></svg>
                            </div>
                            <div class="hap-btn hap-btn-volume-off">
                                <svg viewBox="0 0 48 48"><path d="M33 24c0-3.53-2.04-6.58-5-8.05v4.42l4.91 4.91c.06-.42.09-.85.09-1.28zm5 0c0 1.88-.41 3.65-1.08 5.28l3.03 3.03C41.25 29.82 42 27 42 24c0-8.56-5.99-15.72-14-17.54v4.13c5.78 1.72 10 7.07 10 13.41zM8.55 6L6 8.55 15.45 18H6v12h8l10 10V26.55l8.51 8.51c-1.34 1.03-2.85 1.86-4.51 2.36v4.13c2.75-.63 5.26-1.89 7.37-3.62L39.45 42 42 39.45l-18-18L8.55 6zM24 8l-4.18 4.18L24 16.36V8z"/><path d="M0 0h48v48H0z" fill="none"/></svg>
                            </div>
                        </div>

                        <div class="hap-volume-seekbar">
                             <div class="hap-volume-bg">
                                <div class="hap-volume-level"></div>
                             </div>
                        </div>

                    </div>

                </div>

                <div class="hap-player-controls-right">';

                    if($options["useShuffle"])$markup .= '<div class="hap-random-toggle hap-contr-btn">
                        <div class="hap-btn hap-btn-random-off" data-tooltip="'.esc_attr($options["tooltipShuffleOff"]).'">
                            <svg viewBox="0 0 512 512"><path d="M504.971 359.029c9.373 9.373 9.373 24.569 0 33.941l-80 79.984c-15.01 15.01-40.971 4.49-40.971-16.971V416h-58.785a12.004 12.004 0 0 1-8.773-3.812l-70.556-75.596 53.333-57.143L352 336h32v-39.981c0-21.438 25.943-31.998 40.971-16.971l80 79.981zM12 176h84l52.781 56.551 53.333-57.143-70.556-75.596A11.999 11.999 0 0 0 122.785 96H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12zm372 0v39.984c0 21.46 25.961 31.98 40.971 16.971l80-79.984c9.373-9.373 9.373-24.569 0-33.941l-80-79.981C409.943 24.021 384 34.582 384 56.019V96h-58.785a12.004 12.004 0 0 0-8.773 3.812L96 336H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12h110.785c3.326 0 6.503-1.381 8.773-3.812L352 176h32z"></path></svg>
                        </div>
                        <div class="hap-btn hap-btn-random-on hap-contr-btn-hover" data-tooltip="'.esc_attr($options["tooltipShuffleOn"]).'">
                            <svg viewBox="0 0 512 512"><path d="M504.971 359.029c9.373 9.373 9.373 24.569 0 33.941l-80 79.984c-15.01 15.01-40.971 4.49-40.971-16.971V416h-58.785a12.004 12.004 0 0 1-8.773-3.812l-70.556-75.596 53.333-57.143L352 336h32v-39.981c0-21.438 25.943-31.998 40.971-16.971l80 79.981zM12 176h84l52.781 56.551 53.333-57.143-70.556-75.596A11.999 11.999 0 0 0 122.785 96H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12zm372 0v39.984c0 21.46 25.961 31.98 40.971 16.971l80-79.984c9.373-9.373 9.373-24.569 0-33.941l-80-79.981C409.943 24.021 384 34.582 384 56.019V96h-58.785a12.004 12.004 0 0 0-8.773 3.812L96 336H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12h110.785c3.326 0 6.503-1.381 8.773-3.812L352 176h32z"></path></svg>
                        </div>
                    </div>';
                    
                    if($options["useLoop"])$markup .= '<div class="hap-loop-toggle hap-contr-btn">
                        <div class="hap-btn hap-btn-loop-playlist hap-contr-btn-hover" data-tooltip="'.esc_attr($options["tooltipLoopStatePlaylist"]).'">
                            <svg viewBox="0 0 512 512"><path d="M493.544 181.463c11.956 22.605 18.655 48.4 18.452 75.75C511.339 345.365 438.56 416 350.404 416H192v47.495c0 22.475-26.177 32.268-40.971 17.475l-80-80c-9.372-9.373-9.372-24.569 0-33.941l80-80C166.138 271.92 192 282.686 192 304v48h158.875c52.812 0 96.575-42.182 97.12-94.992.155-15.045-3.17-29.312-9.218-42.046-4.362-9.185-2.421-20.124 4.8-27.284 4.745-4.706 8.641-8.555 11.876-11.786 11.368-11.352 30.579-8.631 38.091 5.571zM64.005 254.992c.545-52.81 44.308-94.992 97.12-94.992H320v47.505c0 22.374 26.121 32.312 40.971 17.465l80-80c9.372-9.373 9.372-24.569 0-33.941l-80-80C346.014 16.077 320 26.256 320 48.545V96H161.596C73.44 96 .661 166.635.005 254.788c-.204 27.35 6.495 53.145 18.452 75.75 7.512 14.202 26.723 16.923 38.091 5.57 3.235-3.231 7.13-7.08 11.876-11.786 7.22-7.16 9.162-18.098 4.8-27.284-6.049-12.735-9.374-27.001-9.219-42.046z"></path></svg>
                        </div>
                        <div class="hap-btn hap-btn-loop-single hap-contr-btn-hover" data-tooltip="'.esc_attr($options["tooltipLoopStateSingle"]).'">
                            <svg viewBox="0 0 512 512"><path d="M493.544 181.463c11.956 22.605 18.655 48.4 18.452 75.75C511.339 345.365 438.56 416 350.404 416H192v47.495c0 22.475-26.177 32.268-40.971 17.475l-80-80c-9.372-9.373-9.372-24.569 0-33.941l80-80C166.138 271.92 192 282.686 192 304v48h158.875c52.812 0 96.575-42.182 97.12-94.992.155-15.045-3.17-29.312-9.218-42.046-4.362-9.185-2.421-20.124 4.8-27.284 4.745-4.706 8.641-8.555 11.876-11.786 11.368-11.352 30.579-8.631 38.091 5.571zM64.005 254.992c.545-52.81 44.308-94.992 97.12-94.992H320v47.505c0 22.374 26.121 32.312 40.971 17.465l80-80c9.372-9.373 9.372-24.569 0-33.941l-80-80C346.014 16.077 320 26.256 320 48.545V96H161.596C73.44 96 .661 166.635.005 254.788c-.204 27.35 6.495 53.145 18.452 75.75 7.512 14.202 26.723 16.923 38.091 5.57 3.235-3.231 7.13-7.08 11.876-11.786 7.22-7.16 9.162-18.098 4.8-27.284-6.049-12.735-9.374-27.001-9.219-42.046zm163.258 44.535c0-7.477 3.917-11.572 11.573-11.572h15.131v-39.878c0-5.163.534-10.503.534-10.503h-.356s-1.779 2.67-2.848 3.738c-4.451 4.273-10.504 4.451-15.666-1.068l-5.518-6.231c-5.342-5.341-4.984-11.216.534-16.379l21.72-19.939c4.449-4.095 8.366-5.697 14.42-5.697h12.105c7.656 0 11.749 3.916 11.749 11.572v84.384h15.488c7.655 0 11.572 4.094 11.572 11.572v8.901c0 7.477-3.917 11.572-11.572 11.572h-67.293c-7.656 0-11.573-4.095-11.573-11.572v-8.9z"></path></svg>
                        </div> 
                        <div class="hap-btn hap-btn-loop-off" data-tooltip="'.esc_attr($options["tooltipLoopStateOff"]).'">
                            <svg viewBox="0 0 512 512"><path d="M493.544 181.463c11.956 22.605 18.655 48.4 18.452 75.75C511.339 345.365 438.56 416 350.404 416H192v47.495c0 22.475-26.177 32.268-40.971 17.475l-80-80c-9.372-9.373-9.372-24.569 0-33.941l80-80C166.138 271.92 192 282.686 192 304v48h158.875c52.812 0 96.575-42.182 97.12-94.992.155-15.045-3.17-29.312-9.218-42.046-4.362-9.185-2.421-20.124 4.8-27.284 4.745-4.706 8.641-8.555 11.876-11.786 11.368-11.352 30.579-8.631 38.091 5.571zM64.005 254.992c.545-52.81 44.308-94.992 97.12-94.992H320v47.505c0 22.374 26.121 32.312 40.971 17.465l80-80c9.372-9.373 9.372-24.569 0-33.941l-80-80C346.014 16.077 320 26.256 320 48.545V96H161.596C73.44 96 .661 166.635.005 254.788c-.204 27.35 6.495 53.145 18.452 75.75 7.512 14.202 26.723 16.923 38.091 5.57 3.235-3.231 7.13-7.08 11.876-11.786 7.22-7.16 9.162-18.098 4.8-27.284-6.049-12.735-9.374-27.001-9.219-42.046z"></path></svg>
                        </div>       

                    </div>';

                    if($options["useShare"])$markup .= '<div class="hap-share-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipShare"]).'">
                        <svg viewBox="0 0 24 24"><path d="M21.7,10.2l-6.6-6C14.6,3.7,14,4.2,14,5v3c-4.7,0-8.7,2.9-10.6,6.8c-0.7,1.3-1.1,2.7-1.4,4.1   c-0.2,1,1.3,1.5,1.9,0.6C6.1,16,9.8,13.7,14,13.7V17c0,0.8,0.6,1.3,1.1,0.8l6.6-6C22.1,11.4,22.1,10.6,21.7,10.2z"/></svg>
                    </div>';
                    
                    $markup .= '<div class="hap-video-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipVideo"]).'">
                       <svg viewBox="0 0 576 512"><path fill="currentColor" d="M336.2 64H47.8C21.4 64 0 85.4 0 111.8v288.4C0 426.6 21.4 448 47.8 448h288.4c26.4 0 47.8-21.4 47.8-47.8V111.8c0-26.4-21.4-47.8-47.8-47.8zm189.4 37.7L416 177.3v157.4l109.6 75.5c21.2 14.6 50.4-.3 50.4-25.8V127.5c0-25.4-29.1-40.4-50.4-25.8z""></path></svg>
                    </div>

                    <div class="hap-lyrics-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipLyrics"]).'">
                        <svg viewBox="0 0 512 512"><path d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm-6 400H54a6 6 0 0 1-6-6V86a6 6 0 0 1 6-6h404a6 6 0 0 1 6 6v340a6 6 0 0 1-6 6zm-42-92v24c0 6.627-5.373 12-12 12H204c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h200c6.627 0 12 5.373 12 12zm0-96v24c0 6.627-5.373 12-12 12H204c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h200c6.627 0 12 5.373 12 12zm0-96v24c0 6.627-5.373 12-12 12H204c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h200c6.627 0 12 5.373 12 12zm-252 12c0 19.882-16.118 36-36 36s-36-16.118-36-36 16.118-36 36-36 36 16.118 36 36zm0 96c0 19.882-16.118 36-36 36s-36-16.118-36-36 16.118-36 36-36 36 16.118 36 36zm0 96c0 19.882-16.118 36-36 36s-36-16.118-36-36 16.118-36 36-36 36 16.118 36 36z"></path></svg>
                    </div>';

                    if($options["useRange"])$markup .= '<div class="hap-range-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipRange"]).'">
                        <svg style="height:26px;" viewBox="0 0 24 24"><path d="M12.516 8.016v4.219l3.469 2.109-0.703 1.219-4.266-2.578v-4.969h1.5zM21 10.125h-6.797l2.766-2.813q-2.063-2.063-4.945-2.086t-4.945 1.992q-0.844 0.844-1.453 2.273t-0.609 2.602 0.609 2.602 1.453 2.273 2.297 1.453 2.625 0.609 2.648-0.609 2.32-1.453q2.016-2.016 2.016-4.875h2.016q0 3.703-2.625 6.281-2.625 2.625-6.375 2.625t-6.375-2.625q-2.625-2.578-2.625-6.258t2.625-6.305q1.078-1.078 2.93-1.852t3.398-0.773 3.398 0.773 2.93 1.852l2.719-2.813v7.125z"></path></svg>
                    </div>';

                    if($options["usePlaybackRate"])$markup .= '<div class="hap-playback-rate-toggle hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipPlaybackRate"]).'">
                        <svg viewBox="0 0 496 512"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zM88 256H56c0-105.9 86.1-192 192-192v32c-88.2 0-160 71.8-160 160zm160 96c-53 0-96-43-96-96s43-96 96-96 96 43 96 96-43 96-96 96zm0-128c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32z"></path></svg>
                    </div>';

                $markup .= '</div>

            </div>';

            if($options["useShare"]){

            $markup .= '<div class="hap-share-holder">

                <div class="hap-share-holder-inner">';

                   if($options["useShareTumblr"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="tumblr" data-tooltip="'.esc_attr($options["tooltipTumblr"]).'">
                            <svg role="img" viewBox="0 0 320 512"><path d="M309.8 480.3c-13.6 14.5-50 31.7-97.4 31.7-120.8 0-147-88.8-147-140.6v-144H17.9c-5.5 0-10-4.5-10-10v-68c0-7.2 4.5-13.6 11.3-16 62-21.8 81.5-76 84.3-117.1.8-11 6.5-16.3 16.1-16.3h70.9c5.5 0 10 4.5 10 10v115.2h83c5.5 0 10 4.4 10 9.9v81.7c0 5.5-4.5 10-10 10h-83.4V360c0 34.2 23.7 53.6 68 35.8 4.8-1.9 9-3.2 12.7-2.2 3.5.9 5.8 3.4 7.4 7.9l22 64.3c1.8 5 3.3 10.6-.4 14.5z"></path></svg>
                        </div>';
                    if($options["useShareTwitter"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="twitter" data-tooltip="'.esc_attr($options["tooltipTwitter"]).'">
                            <svg role="img" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
                        </div>';
                    if($options["useShareFacebook"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="facebook" data-tooltip="'.esc_attr($options["tooltipFacebook"]).'">
                            <svg role="img" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
                        </div>';
                    if($options["useShareWhatsApp"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="whatsapp" data-tooltip="'.esc_attr($options["tooltipWhatsApp"]).'">
                        <svg role="img" viewBox="0 0 448 512"><path d="M224 122.8c-72.7 0-131.8 59.1-131.9 131.8 0 24.9 7 49.2 20.2 70.1l3.1 5-13.3 48.6 49.9-13.1 4.8 2.9c20.2 12 43.4 18.4 67.1 18.4h.1c72.6 0 133.3-59.1 133.3-131.8 0-35.2-15.2-68.3-40.1-93.2-25-25-58-38.7-93.2-38.7zm77.5 188.4c-3.3 9.3-19.1 17.7-26.7 18.8-12.6 1.9-22.4.9-47.5-9.9-39.7-17.2-65.7-57.2-67.7-59.8-2-2.6-16.2-21.5-16.2-41s10.2-29.1 13.9-33.1c3.6-4 7.9-5 10.6-5 2.6 0 5.3 0 7.6.1 2.4.1 5.7-.9 8.9 6.8 3.3 7.9 11.2 27.4 12.2 29.4s1.7 4.3.3 6.9c-7.6 15.2-15.7 14.6-11.6 2v1.6 15.3 26.3 30.6 35.4 53.9 47.1 4 2 6.3 1.7 8.6-1 2.3-2.6 9.9-11.6 12.5-15.5 2.6-4 5.3-3.3 8.9-2 3.6 1.3 23.1 10.9 27.1 12.9s6.6 3 7.6 4.6c.9 1.9.9 9.9-2.4 19.1zM400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM223.9 413.2c-26.6 0-52.7-6.7-75.8-19.3L64 416l22.5-82.2c-13.9-24-21.2-51.3-21.2-79.3C65.4 167.1 136.5 96 223.9 96c42.4 0 82.2 16.5 112.2 46.5 29.9 30 47.9 69.8 47.9 112.2 0 87.4-72.7 158.5-160.1 158.5z"></path></svg>
                    </div>';
                    if($options["useShareLinkedIn"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="linkedin" data-tooltip="'.esc_attr($options["tooltipLinkedIn"]).'">
                        <svg role="img" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
                    </div>';
                    if($options["useShareReddit"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="reddit" data-tooltip="'.esc_attr($options["tooltipReddit"]).'">
                        <svg role="img" viewBox="0 0 512 512"><path d="M201.5 305.5c-13.8 0-24.9-11.1-24.9-24.6 0-13.8 11.1-24.9 24.9-24.9 13.6 0 24.6 11.1 24.6 24.9 0 13.6-11.1 24.6-24.6 24.6zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-132.3-41.2c-9.4 0-17.7 3.9-23.8 10-22.4-15.5-52.6-25.5-86.1-26.6l17.4-78.3 55.4 12.5c0 13.6 11.1 24.6 24.6 24.6 13.8 0 24.9-11.3 24.9-24.9s-11.1-24.9-24.9-24.9c-9.7 0-18 5.8-22.1 13.8l-61.2-13.6c-3-.8-6.1 1.4-6.9 4.4l-19.1 86.4c-33.2 1.4-63.1 11.3-85.5 26.8-6.1-6.4-14.7-10.2-24.1-10.2-34.9 0-46.3 46.9-14.4 62.8-1.1 5-1.7 10.2-1.7 15.5 0 52.6 59.2 95.2 132 95.2 73.1 0 132.3-42.6 132.3-95.2 0-5.3-.6-10.8-1.9-15.8 31.3-16 19.8-62.5-14.9-62.5zM302.8 331c-18.2 18.2-76.1 17.9-93.6 0-2.2-2.2-6.1-2.2-8.3 0-2.5 2.5-2.5 6.4 0 8.6 22.8 22.8 87.3 22.8 110.2 0 2.5-2.2 2.5-6.1 0-8.6-2.2-2.2-6.1-2.2-8.3 0zm7.7-75c-13.6 0-24.6 11.1-24.6 24.9 0 13.6 11.1 24.6 24.6 24.6 13.8 0 24.9-11.1 24.9-24.6 0-13.8-11-24.9-24.9-24.9z"></path></svg>
                    </div>';
                    if($options["useShareDigg"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="digg" data-tooltip="'.esc_attr($options["tooltipDigg"]).'">
                        <svg role="img" viewBox="0 0 512 512"><path d="M81.7 172.3H0v174.4h132.7V96h-51v76.3zm0 133.4H50.9v-92.3h30.8v92.3zm297.2-133.4v174.4h81.8v28.5h-81.8V416H512V172.3H378.9zm81.8 133.4h-30.8v-92.3h30.8v92.3zm-235.6 41h82.1v28.5h-82.1V416h133.3V172.3H225.1v174.4zm51.2-133.3h30.8v92.3h-30.8v-92.3zM153.3 96h51.3v51h-51.3V96zm0 76.3h51.3v174.4h-51.3V172.3z"></path></svg>
                    </div>';
                    if($options["useSharePinterest"])$markup .= '<div class="hap-share-item hap-contr-btn" data-type="pinterest" data-tooltip="'.esc_attr($options["tooltipPinterest"]).'">
                        <svg role="img" viewBox="0 0 496 512"><path d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3.8-3.4 5-20.3 6.9-28.1.6-2.5.3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"></path></svg>
                    </div>

                </div>
                
                <div class="hap-share-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'">
                    <svg viewBox="0 0 14 14" ><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="currentColor" id="Core" transform="translate(-341.000000, -89.000000)"><g id="close" transform="translate(341.000000, 89.000000)"><path d="M14,1.4 L12.6,0 L7,5.6 L1.4,0 L0,1.4 L5.6,7 L0,12.6 L1.4,14 L7,8.4 L12.6,14 L14,12.6 L8.4,7 L14,1.4 Z" id="Shape"/></g></g></g></svg>
                </div>
                
            </div>';

            }

            if($options["usePlaybackRate"]){

                $markup .= '<div class="hap-playback-rate-holder">

                    <div class="hap-playback-rate-wrap">
                        <div class="hap-playback-rate-min"></div>
                        <div class="hap-playback-rate-seekbar">
                             <div class="hap-playback-rate-bg">
                                <div class="hap-playback-rate-level"></div>
                             </div>
                        </div>
                        <div class="hap-playback-rate-max"></div>
                    </div>

                    <div class="hap-playback-rate-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'">
                        <svg viewBox="0 0 14 14" ><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="currentColor" id="Core" transform="translate(-341.000000, -89.000000)"><g id="close" transform="translate(341.000000, 89.000000)"><path d="M14,1.4 L12.6,0 L7,5.6 L1.4,0 L0,1.4 L5.6,7 L0,12.6 L1.4,14 L7,8.4 L12.6,14 L14,12.6 L8.4,7 L14,1.4 Z" id="Shape"/></g></g></g></svg>
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
                        <svg viewBox="0 0 14 14" ><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="currentColor" id="Core" transform="translate(-341.000000, -89.000000)"><g id="close" transform="translate(341.000000, 89.000000)"><path d="M14,1.4 L12.6,0 L7,5.6 L1.4,0 L0,1.4 L5.6,7 L0,12.6 L1.4,14 L7,8.4 L12.6,14 L14,12.6 L8.4,7 L14,1.4 Z" id="Shape"/></g></g></g></svg>
                    </div>
                
                </div>';

            }

            $markup .= '<div class="hap-lyrics-holder hap-dialog">

                <div class="hap-dialog-header">

                    <div class="hap-dialog-header-drag"></div>
                    <label class="hap-lyrics-autoscroll-label" title="'.esc_attr($options["lyricsAutoScrollText"]).'"><input class="hap-lyrics-autoscroll" type="checkbox"> '.esc_html($options["lyricsAutoScrollText"]).'</label>  

                    <div class="hap-lyrics-close hap-dialog-close hap-contr-btn" data-tooltip="'.esc_attr($options["tooltipClose"]).'">
                        <svg viewBox="0 0 14 14" ><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="currentColor" id="Core" transform="translate(-341.000000, -89.000000)"><g id="close" transform="translate(341.000000, 89.000000)"><path d="M14,1.4 L12.6,0 L7,5.6 L1.4,0 L0,1.4 L5.6,7 L0,12.6 L1.4,14 L7,8.4 L12.6,14 L14,12.6 L8.4,7 L14,1.4 Z" id="Shape"/></g></g></g></svg>
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
                        <svg viewBox="0 0 14 14" ><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="currentColor" id="Core" transform="translate(-341.000000, -89.000000)"><g id="close" transform="translate(341.000000, 89.000000)"><path d="M14,1.4 L12.6,0 L7,5.6 L1.4,0 L0,1.4 L5.6,7 L0,12.6 L1.4,14 L7,8.4 L12.6,14 L14,12.6 L8.4,7 L14,1.4 Z" id="Shape"/></g></g></g></svg>
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