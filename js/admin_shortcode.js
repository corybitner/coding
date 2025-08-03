jQuery(document).ready(function($) {

    "use strict"

    var preloader = $('#hap-loader')



    var gettingPlaylistSongs,
    lastGettingPlaylistSongsId,
    shortcode_playlist_song = $('#shortcode_playlist_song'),
    shortcode_playlist_song_list = $('#shortcode_playlist_song_list'),
    shortcode_start_time = $('#shortcode_start_time'),
    shortcode_start_time_all = $('#shortcode_start_time_all'),
    shortcode_start_time_field = $('#shortcode_start_time_field')



    var infoSkin = $('#infoSkin').on('change',function(){

        var t = $(this).val()
        var img = hap_data.plugins_url + '/assets/grid/'+t+'.png';
        $('#playlist-grid-style-img').attr('src', img);

    }).change();




    //preset preview 
    $("#preset").on('change', function(){

        var t = $(this).val();
        if(t.indexOf('tiny')>-1){
            t = 'tiny';
        }
        else if(t.indexOf('compact')>-1){
            t = 'compact';
        }

        var img = hap_data.plugins_url + '/assets/presets/'+t+'.jpg';
        $('#preset-preview').attr('src', img);

        //preset info
        $('.hap-player-info').hide();
        $('.player-info-'+t).show();

        if(t.indexOf('grid') == -1){
            $('.playlist-skin').hide() 
            $('.default-skin').show() 
        }else{
            $('.default-skin').hide() 
            $('.playlist-skin').show() 
        }


    }).change();

   









    //############################################//
    /* shortcode */
    //############################################//

    var shortcode_all_atts;

    $('#shortcode_player, #shortcode_playlist, #shortcode_ad').on('change',function(){

        var player_id = $('#shortcode_player').val(), 
        playlist_id = $('#shortcode_playlist').val(),
        ad_id = $('#shortcode_ad').val(),
        active_item = shortcode_playlist_song_list.val(),
        start_time = shortcode_start_time.val(),
        start_time_media_id = shortcode_start_time_all.is(':checked') ? null : active_item

        if(active_item == '-1')start_time_media_id = null

        if(!player_id){
            $('#shortcode_generator').text('Please create a player first!\n');
        }else{
            var shortcode = '[apmap player_id="'+player_id+'"';
            if(playlist_id != '')shortcode += ' playlist_id="'+playlist_id+'"';
            if(typeof ad_id !== 'undefined' && ad_id != '')shortcode += ' ad_id="'+ad_id+'"';
            if(typeof active_item !== 'undefined' && active_item != '' && active_item != '-1')shortcode += ' active_media_id="'+active_item+'"';
            if(typeof start_time !== 'undefined' && start_time != ''){
                shortcode += ' start="'+start_time+'"';
                if(start_time_media_id)shortcode += ' start_time_media_id="'+start_time_media_id+'"';
            }

            shortcode += ']';

            $('#shortcode_generator').text(shortcode);
        }

        var shortcode_for_php = 'echo do_shortcode('+shortcode+');'
        $('#shortcode_for_php').text(shortcode_for_php);



        //get all shortcode atts
        if($(this).attr('id') == 'shortcode_player'){

           /* var postData = [
                {name: 'action', value: 'hap_get_shortcode_atts'},
                {name: 'player_id', value: player_id},
                {name: 'security', value: hap_data.security}
            ];

            $.ajax({
                url: hap_data.ajax_url,
                type: 'post',
                data: postData,
                dataType: 'json',
            }).done(function(response){
                console.log(response)

                var str = '[apmap player_id="'+player_id+'" playlist_id="'+playlist_id+'"';
                if(typeof ad_id !== 'undefined' && ad_id != '')str += ' ad_id="'+ad_id+'"';

                for (var [key, value] of Object.entries(response)) {
                    //console.log(key, value)
                    if(key != 'continousKey' && key != 'playlistItemMarkup' && key != 'playerMarkup' && key != 'playlistContent'){

                        if(Array.isArray(value)){
                            value = value.join(",");
                        }

                        o = key.split(/(?=[A-Z])/).join('_').toLowerCase();//camelcase to underscore
                        str += ' '+o+'="'+value+'"';
                    }
                }

                str += ']';

                shortcode_all_atts = str;

                $('#shortcode_generator_all_atts').text(str);

                //console.log(response)
                //console.log(str)

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText, textStatus, errorThrown);
            }); */

        }
        else if($(this).attr('id') == 'shortcode_ad'){
            //update all atts if we change ad_id
            if(shortcode_all_atts){
                if(typeof ad_id !== 'undefined' && ad_id != ''){

                    var s1 = shortcode_all_atts.substr(0,shortcode_all_atts.lastIndexOf('playlist_id')),
                    s2 = shortcode_all_atts.substr(shortcode_all_atts.lastIndexOf('playlist_id')),
                    s3 = s1 + ' ad_id="'+ad_id+'" ' + s2;

                    $('#shortcode_generator_all_atts').text(s3);

                }
            }
        }

    });

    $('#shortcode_player').change();









    //playlist display

    var playlist_display_field = $('#hap-pd')

    if(typeof $.fn.select2 !== 'undefined'){

        var pgPlaylistList = $('#pd-playlist-list').select2({
            placeholder: 'Select playlists'
        }).on('change', function(e) {
            //additionalPlaylist.val(addMediaPlaylistList.val())//save here because after we hide modal it appears we cannot get select2 value any more?
        });

    }

    //clear selected
    $('#hap-clear-pd').on('click', function(){
        $('#pd-playlist-list').val('').trigger('change')
    })

    // Select All Options
    $('#hap-select-all-pd').on('click', function(){
        $("#pd-playlist-list > option").prop("selected","selected");
        $("#pd-playlist-list").trigger("change");
    })

    $('#hap-pd-get-shortcode').on('click', function(){
       
        var value = pgPlaylistList.val()
        if(isEmpty(value)){
            alert('Please select playlists to include!');
            return false;
        }

        var playlist_id = value.join(','),
        active_playlist = $('#pd-active-playlist').val(),
        header_title = $('#pd-header-title').val(),
        player = $('#pd-player-list').val()

        if(isEmpty(active_playlist)){
            active_playlist = value[0]
        }

        if(active_playlist != '-1' && playlist_id.indexOf(active_playlist) == -1){//check if active playlist is from the one selected
            active_playlist = value[0]  
        }

        var s1 = '[apmap_playlist_display playlist_id="'+playlist_id+'" active_playlist="'+active_playlist+'" connected_player_id="'+player+'" header_title="'+header_title+'"]'

        var s2 = '[apmap playlist_id="'+playlist_id+'" player_id="'+player+'" instance_id="'+player+'"]'

        $('#hap-pd-shortcode-ta').val(s1 + s2)

    })


    

    $('#shortcode-get-playlist-songs').on('click', function(){

        var playlist_id = $('#shortcode_playlist').val()
        if(isEmpty(playlist_id)){
            alert('Select playlist first!')
            return false;
        }

        if(lastGettingPlaylistSongsId){
            if(lastGettingPlaylistSongsId == playlist_id)return false;//playlist songs already loaded
        }

        if(gettingPlaylistSongs)return false;
        gettingPlaylistSongs = true;

        lastGettingPlaylistSongsId = playlist_id

        preloader.show()

        var postData = [
            {name: 'action', value: 'hap_get_media'},
            {name: 'playlist_id', value: playlist_id},
            {name: 'security', value: hap_data.security}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',
        }).done(function(response){
            console.log(response)

            var option = '<option value="-1">No song loaded on start</option>'

            shortcode_playlist_song_list.show()

            shortcode_playlist_song.empty()
            shortcode_playlist_song.append(option)

            var i, len = response.length, obj, title
            for(i = 0; i< len; i++){
                obj = response[i]
                title = getSongTitle(obj.options)

                option = '<option value="'+obj.id+'">'+title+'</option>'
                shortcode_playlist_song.append(option)
            }

            preloader.hide()
            gettingPlaylistSongs = false;

            shortcode_start_time_field.show()

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);

            preloader.hide()
            gettingPlaylistSongs = false;
        }); 


    })

    shortcode_playlist_song_list.on('change', function(){
        $('#shortcode_player').change();  
    });

    function getSongTitle(data){

        var title;

        if(data.artist && !isEmpty(data.artist) && data.title && !isEmpty(data.title)){
            title = data.artist + ' - ' + data.title;
        }
        else if(data.title && !isEmpty(data.title)){
            title = data.title;
        }
        else if(data.artist && !isEmpty(data.artist)){
            title = data.artist;
        }

        return title;
    }


    //start time

    shortcode_start_time.on('change', function(){
        $('#shortcode_player').change();  
    });

    shortcode_start_time_all.on('change', function(){
        $('#shortcode_player').change();  
    });

    





    //############################################//
    /* helpers */
    //############################################//

    function isEmpty(str){
        return str.replace(/^\s+|\s+$/g, '').length == 0;
    }





});