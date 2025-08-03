jQuery(document).ready(function($) {

    "use strict"

    const { __ } = wp.i18n;
    const { registerBlockType } = wp.blocks;
    const el = wp.element.createElement;
  


    var IconBlock = function(e) {
        return wp.element.createElement("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            "xmlns:xlink": "http://www.w3.org/1999/xlink",
            width: "20",
            height: "20",
            viewBox: "0 0 512 512",
            class: "dashicon aptean-block-icon"
        }, [wp.element.createElement("path", {
            id: "a",
            d: "M256 32C114.52 32 0 146.496 0 288v48a32 32 0 0 0 17.689 28.622l14.383 7.191C34.083 431.903 83.421 480 144 480h24c13.255 0 24-10.745 24-24V280c0-13.255-10.745-24-24-24h-24c-31.342 0-59.671 12.879-80 33.627V288c0-105.869 86.131-192 192-192s192 86.131 192 192v1.627C427.671 268.879 399.342 256 368 256h-24c-13.255 0-24 10.745-24 24v176c0 13.255 10.745 24 24 24h24c60.579 0 109.917-48.098 111.928-108.187l14.382-7.191A32 32 0 0 0 512 336v-48c0-141.479-114.496-256-256-256z"
        })])
    };

    //console.log(map_block_data)

    var i,
    players = JSON.parse(map_block_data.players),
    playlists = JSON.parse(map_block_data.playlists),
    ads = JSON.parse(map_block_data.ads),
    playerArr = [{label:'Select player..', value:''}], 
    playlistArr = [{label:'Select playlist..', value:''}],
    adArr = [{label:'Select ad..', value:''}]

    for (i = 0; i < players.length; i++){
        playerArr.push({label:players[i].title +' - ID #'+players[i].id, value:players[i].id})
    }
    for (i = 0; i < playlists.length; i++){
        playlistArr.push({label:playlists[i].title +' - ID #'+playlists[i].id, value:playlists[i].id})
    }
    for (i = 0; i < ads.length; i++){
        adArr.push({label:ads[i].title +' - ID #'+ads[i].id, value:ads[i].id})
    }
  
    class Button extends React.Component {
        render() {
            var e = document.location.origin + document.location.pathname.replace("post.php", "admin.php") + "?page=";
            return el("a", {
                href: e + this.props.href,
                target: "_blank",
                className: this.props.className
            }, this.props.text)
        }
    }

    registerBlockType( 'modern-audio-player/block', {
        title: "Modern Audio Player",
        description: "Powerful audio player for your website",
        icon: {
            src: IconBlock
        },
        category: 'common',
        keywords: [
            __( 'Audio player' ),
            __( 'Sound' ),
            __( 'Song' ),
        ],
        attributes: {
            player_id : {
                type: 'string',
            },
            playlist_id : {
                type: 'string',
            },
            ad_id : {
                type: 'string',
            }
        },
        edit({attributes, setAttributes, className, focus, id}) {
            //console.log(attributes)

            function onChangePlayerId(v) {
                setAttributes( {player_id: v} );
            }

            function onChangePlaylistId(v) {
                setAttributes( {playlist_id: v} );
            }

            function onChangeAdId(v) {
                setAttributes( {ad_id: v} );
            }

            return [

                    el(
                        'div',
                        { className: 'aptean-block-container'},
                        el(IconBlock, {}), 
                        el("span", {}, "Modern Audio Player")
                    ),

                    el( wp.element.Fragment, {},
                        el( wp.blockEditor.InspectorControls, {},
                            el( wp.components.PanelBody, { title: 'Select source', initialOpen: true },
             
                                playerArr.length == 1 ? 

                                    el(Button, {
                                        href: "hap_player_manager&action=add_player",
                                        className: "components-button is-button is-default is-large aptean-block-panel-button",
                                        text: __("Create new player")
                                    })

                                : el(
                                    wp.components.SelectControl,
                                    {
                                        label: 'Select player',
                                        value: attributes.player_id,
                                        options: playerArr,
                                        onChange: onChangePlayerId,
                                    }
                                ),

                                playlistArr.length == 1 ? 

                                    el(Button, {
                                        href: "hap_playlist_manager&action=add_playlist",
                                        className: "components-button is-button is-default is-large aptean-block-panel-button",
                                        text: __("Create new playlist")
                                    })

                                : el(
                                    wp.components.SelectControl,
                                    {
                                        label: 'Select playlist',
                                        value: attributes.playlist_id,
                                        options: playlistArr,
                                        onChange: onChangePlaylistId
                                    }
                                ),    

                     
                                adArr.length > 1 && el(
                                    wp.components.SelectControl,
                                    {
                                        label: 'Select ad',
                                        value: attributes.ad_id,
                                        options: adArr,
                                        onChange: onChangeAdId
                                    }
                                ),
                            ),
             
                        ),

                    ), 
               
                ]


        },
        save(props) {

            var attributes = props.attributes, shortcode = '';

            if(attributes.player_id !== 'undefined' && attributes.playlist_id !== 'undefined'){
                shortcode += '[apmap player_id="' + attributes.player_id + '" playlist_id="' + attributes.playlist_id + '"';
            }
            if(attributes.ad_id != undefined)shortcode += ' ad_id="' + attributes.ad_id + '"';

            shortcode += ']';

            return shortcode;

        },
    } );


});