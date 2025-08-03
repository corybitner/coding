jQuery(document).ready(function($) {

    "use strict"

    var preloader = $('#hap-loader'),
    _body = $('body'),
    _doc = $(document),
    empty_src = 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D',
    mediaItemList = $('#media-item-list'),
    curr_playlist_id = $('.hap-admin').attr('data-playlist-id'),
    mediaTable = $('#media-table'),
    mediaTableHeader = $('.media-table-header'),
    playlistItemList = $('#playlist-item-list'),
    playlistTableHeader = $('.hap-playlist-table-header')
    




    //sort on start

    var playlist_sortInited
    var playlist_paginationArr = []
    //get all tracks
    var i = 0;
    playlistItemList.find('.hap-playlist-item').each(function(){
        playlist_paginationArr.push($(this).attr('data-id', i))
        i++;
    })

    playlistTableHeader.find('.hap-sort-field').on('click', function(e){

        e.preventDefault()

        var btn = $(this),
        asc = btn.attr('data-asc') == 'true',
        items = playlistItemList.find('.hap-playlist-item'), len = items.length,
        type = btn.attr('data-type')

        if(type == 'title' || type == 'preset')keysrtStr(playlist_paginationArr, '.media-'+type, asc);
        else keysrtNum(playlist_paginationArr, '.media-'+type, asc);

        asc = !asc
        btn.attr('data-asc', asc)

        //save state
        if(localStorage){
            lastPlaylistSortInBackend.type = type
            lastPlaylistSortInBackend.asc = asc

            var key = 'hap_last_playlist_sort_in_backend'
            localStorage.setItem(key, JSON.stringify(lastPlaylistSortInBackend));

        }

        setSortIndicatorPlaylist()

        var i, arr = [];
        for(i = 0;i < len; i++){
            arr.push(parseInt(playlist_paginationArr[i].attr('data-id'),10));
        }

        //reposition data
        playlistItemList.append($.map(arr, function(v) {
            return items[v];
        }));

        //update id
        var i = 0;
        playlistItemList.find('.hap-playlist-item').each(function(){
            $(this).attr('data-id', i)
            i++;

            if(!playlist_sortInited){
                $(this).css('opacity',1)
            }
        })

        playlist_sortInited = true;

    })

    //restore sort
    var lastPlaylistSortInBackend = {type: 'id', asc: true}
    if(localStorage){
        var key = 'hap_last_playlist_sort_in_backend'
        if(localStorage.getItem(key)){
            lastPlaylistSortInBackend = JSON.parse(localStorage.getItem(key))

            var asc = lastPlaylistSortInBackend.asc == true ? false : true;

            playlistTableHeader.find('.hap-sort-field[data-type="'+lastPlaylistSortInBackend.type+'"]').attr('data-asc',asc).click()

        }else{
            setSortIndicatorPlaylist()

            playlist_sortInited = true;

            playlistItemList.find('.hap-playlist-item').each(function(){
                $(this).css('opacity',1)
            })

        }
    }

    function setSortIndicatorPlaylist(){

        playlistTableHeader.find('.hap-triangle-dir-wrap, .hap-triangle-dir').hide()//hide all

        if(lastPlaylistSortInBackend.asc == true){
            playlistTableHeader.find('.hap-sort-field[data-type="'+lastPlaylistSortInBackend.type+'"]').find('.hap-triangle-dir-wrap').show().find('.hap-triangle-dir-down').show()
        }else{
            playlistTableHeader.find('.hap-sort-field[data-type="'+lastPlaylistSortInBackend.type+'"]').find('.hap-triangle-dir-wrap').show().find('.hap-triangle-dir-up').show()
        }

    }














    //pagination

    var paginationPerPageNum = $('#hap-pag-per-page-num')

    if(localStorage && localStorage.getItem('hap_media_paginaton_per_page')){
        paginationPerPageNum.val(localStorage.getItem('hap_media_paginaton_per_page'))
    }

    var paginationArr = [],
    paginationCurrentPage = 0,
    paginationPerPage = parseInt(paginationPerPageNum.val(),10),
    paginationTotalPages,
    paginationInited, 
    lastActivePaginationBtn,
    lastPaginationPage,
    paginationWrap = $('.hap-pagination-wrap')

    function updatePagination(jump_to_last_page){
        //after delete, move, copy, add tracks

        lastPaginationPage = paginationTotalPages - 1;
        if(paginationArr.length % paginationPerPage == 0){
            lastPaginationPage++;//no more space for tracks in last page, go to next page
        }

        paginationArr = []//empty

        //get all tracks again
        var i = 0;
        mediaItemList.find('.media-item').each(function(){
            paginationArr.push($(this).addClass('hap-pagination-hidden').attr('data-id', i))
            i++;
        })

        paginationTotalPages = Math.ceil(paginationArr.length / paginationPerPage)

        if(jump_to_last_page){//when we create new tracks, jumpo to page with those newly created tracks
            paginationCurrentPage = lastPaginationPage;
        }

        if(paginationCurrentPage > paginationTotalPages - 1)paginationCurrentPage = paginationTotalPages - 1;

        if(paginationTotalPages > 1)createPaginationBtn(paginationCurrentPage);
        else paginationWrap.html('');

        if(paginationArr.length)showPaginationTracks()

    }

    var i = 0;
    mediaItemList.find('.media-item').each(function(){
        paginationArr.push($(this).attr('data-id', i))
        i++;
    })

    //adjust per page
    $('#hap-pag-per-page-btn').on('click', function(){

        if(isEmpty(paginationPerPageNum.val())){
            paginationPerPageNum.focus()
            alert("Enter number!")
            return false;
        }

        paginationPerPage = parseInt(paginationPerPageNum.val(),10)

        //save
        if(localStorage)localStorage.setItem('hap_media_paginaton_per_page', paginationPerPage);

        paginationTotalPages = Math.ceil(paginationArr.length / paginationPerPage)

        paginationCurrentPage = 0;

        if(paginationTotalPages > 1)createPaginationBtn(paginationCurrentPage);
        else paginationWrap.html('');

        if(paginationArr.length)showPaginationTracks()

    })

    function showPaginationTracks(){

        //hide visible playlist items
        mediaItemList.find('.media-item').addClass('hap-pagination-hidden')

        var i, z = paginationCurrentPage * paginationPerPage, len = z + paginationPerPage
        if(len > paginationArr.length) len = paginationArr.length;

        for(i = z; i < len; i++){
            paginationArr[i].removeClass('hap-pagination-hidden')
        }

    }

    paginationTotalPages = Math.ceil(paginationArr.length / paginationPerPage)

    if(paginationTotalPages > 1)createPaginationBtn(paginationCurrentPage);

    if(paginationArr.length)showPaginationTracks()//show tracks on start

    function createPaginationBtn(page){

        page += 1;

        var id, c, str = '<div class="hap-pagination-container">';

        if (page > 1){
            str += '<div class="hap-pagination-page hap-pagination-first" data-page-id="first" title="First">First</div>';
            str += '<div class="hap-pagination-page hap-pagination-prev" data-page-id="prev" title="Previous">Prev</div>';
        }

        if (page-2 > 0 && page == paginationTotalPages){
            id = page-2;
            c = id-1;
            str += '<div class="hap-pagination-page" data-page-id="'+c+'">'+id+'</div>';
        }

        if (page-1 > 0){
            id = page-1;
            c = id-1;
            str += '<div class="hap-pagination-page" data-page-id="'+c+'">'+id+'</div>';
        }

        id = page;
        c = id-1;
        str += '<div class="hap-pagination-page hap-pagination-currentpage" data-page-id="'+c+'">'+id+'</div>'

        if (page+1 < paginationTotalPages) {
            id = page+1;
            c = id-1;
            str += '<div class="hap-pagination-page" data-page-id="'+c+'">'+id+'</div>';
        }

        if (page+2 <= paginationTotalPages && page == 1){
            id = page+2;
            c = id-1;
            str += '<div class="hap-pagination-page" data-page-id="'+c+'">'+id+'</div>';
        }

        if (page == paginationTotalPages - 1){
            id = paginationTotalPages;
            c = id-1;
            str += '<div class="hap-pagination-page" data-page-id="'+c+'">'+id+'</div>';
        }

        if (page < paginationTotalPages){
            str += '<div class="hap-pagination-page hap-pagination-next" data-page-id="next" title="Next">Next</div>';
            str += '<div class="hap-pagination-page hap-pagination-last" data-page-id="last" title="Last">Last</div>';
        }

        str += '</div>';

        str += '<div class="hap-pagination-total">Page '+page+' of '+paginationTotalPages+'</div>';

        paginationWrap.html(str);
        
        if(!paginationInited){
            paginationInited = true;

            paginationWrap.on('click', '.hap-pagination-page:not(.hap-pagination-currentpage)', function() {

                if(lastActivePaginationBtn)lastActivePaginationBtn.removeClass('hap-pagination-currentpage');
                lastActivePaginationBtn = $(this).addClass('hap-pagination-currentpage');

                //get new page
                var page = $(this).attr('data-page-id')
                if(page == 'prev')paginationCurrentPage -= 1;
                else if(page == 'next')paginationCurrentPage += 1;
                else if(page == 'first')paginationCurrentPage = 0;
                else if(page == 'last')paginationCurrentPage = paginationTotalPages - 1; 
                else paginationCurrentPage = parseInt(page,10);

                if(paginationTotalPages > 1)createPaginationBtn(paginationCurrentPage);
                else paginationWrap.html('');

                if(paginationArr.length)showPaginationTracks()
                
            });

            lastActivePaginationBtn = paginationWrap.find('.hap-pagination-currentpage')

        }

    }


    //sort order

    function setSortIndicatorMedia(){

        mediaTableHeader.find('.hap-triangle-dir-wrap, .hap-triangle-dir').hide()//hide all

        if(lastMediaSortInBackend.asc == true){
            mediaTableHeader.find('.hap-sort-field[data-type="'+lastMediaSortInBackend.type+'"]').find('.hap-triangle-dir-wrap').show().find('.hap-triangle-dir-down').show()
        }else{
            mediaTableHeader.find('.hap-sort-field[data-type="'+lastMediaSortInBackend.type+'"]').find('.hap-triangle-dir-wrap').show().find('.hap-triangle-dir-up').show()
        }

    }

    mediaTableHeader.find('.hap-sort-field').on('click', function(e){

        e.preventDefault()

        var btn = $(this),
        asc = btn.attr('data-asc') == 'true',
        items = mediaItemList.find('.media-item'), len = items.length,
        type = btn.attr('data-type')

        if(type == 'title' || type == 'artist')keysrtStr(paginationArr, '.media-'+type, asc);
        else keysrtNum(paginationArr, '.media-'+type, asc);

        asc = !asc
        btn.attr('data-asc', asc)

        //save state
        if(localStorage){
            lastMediaSortInBackend.type = type
            lastMediaSortInBackend.asc = asc

            var key = 'hap_last_media_sort_in_backend_pid' + curr_playlist_id
            localStorage.setItem(key, JSON.stringify(lastMediaSortInBackend));

        }

        setSortIndicatorMedia()

        var i, arr = [];
        for(i = 0;i < len; i++){
            arr.push(parseInt(paginationArr[i].attr('data-id'),10));
        }

        //reposition data
        mediaItemList.append($.map(arr, function(v) {
            return items[v];
        }));

        //update id
        var i = 0;
        mediaItemList.find('.media-item').each(function(){
            $(this).attr('data-id', i)
            i++;
        })

        updateSortOrder()

    })

    //restore sort
    var lastMediaSortInBackend = {type: 'id', asc: true}
    if(localStorage){
        var key = 'hap_last_media_sort_in_backend_pid' + curr_playlist_id
        if(localStorage.getItem(key)){
            lastMediaSortInBackend = JSON.parse(localStorage.getItem(key))

            var asc = lastMediaSortInBackend.asc == true ? false : true;

            mediaTableHeader.find('.hap-sort-field[data-type="'+lastMediaSortInBackend.type+'"]').attr('data-asc',asc).click()
        }
    }

    var sortIsBeingSet

    function updateSortOrder(){

        if(sortIsBeingSet)return false;
        sortIsBeingSet = true;

        var media_id_arr = [], order_id_arr = [];
        mediaItemList.find('.media-item').each(function(){
            media_id_arr.push(parseInt($(this).attr('data-media-id'),10));
            order_id_arr.push(parseInt($(this).attr('data-order-id'),10));
        });

        order_id_arr.sort(sortNumber);//sort order id's from lowest on curr page

        var postData = [
            {name: 'action', value: 'hap_update_media_order'},
            {name: 'media_id_arr', value: media_id_arr},
            {name: 'order_id_arr', value: order_id_arr},
            {name: 'playlist_id', value: $('.hap-admin').attr('data-playlist-id')},
            {name: 'security', value: hap_data.security}
        ];

        console.log(postData)

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json', 
        }).done(function(response){

            console.log(response)
            sortIsBeingSet = false;

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
            sortIsBeingSet = false;
        }); 

    }









    //tabs



    //media mutiple playlist select

    if(typeof $.fn.select2 !== 'undefined'){

        var additional_playlist_field = $('#additional_playlist_field'),
        additionalPlaylist =  $('#hap-additional-playlist'),
        addMediaPlaylistList = $('#hap-add-media-playlist-list').select2({
            placeholder: 'Select additional playlists',
            dropdownParent: $('#hap-edit-media-modal')
        }).on('change', function(e) {
            //console.log(addMediaPlaylistList.val())
            additionalPlaylist.val(addMediaPlaylistList.val())//save here because after we hide modal it appears we cannot get select2 value any more?
        });

        //clear selected
        $('#hap-clear-additional-playlist').on('click', function(){
            $('#hap-add-media-playlist-list').val('').trigger('change')
        })

    }








    //playlist options

    var playlist_options_tabs = $('#hap-playlist-options-tabs');

    playlist_options_tabs.find('.hap-tab-header div').click(function(){
        var tab = $(this), id = tab.attr('id');

        if(!tab.hasClass('hap-tab-active')){ 
            playlist_options_tabs.find('.hap-tab-header div').removeClass('hap-tab-active');  
            tab.addClass('hap-tab-active');
            playlist_options_tabs.find('.hap-tab-content').hide();

            playlist_options_tabs.find($('#'+ id + '-content')).show();
        }
    });

    playlist_options_tabs.find('.hap-tab-header div').eq(0).addClass('hap-tab-active');
    playlist_options_tabs.find('.hap-tab-content').eq(0).show();






    
    //playlist thumb

    var pl_thumb_preview = $('#pl_thumb_preview'),
    pl_thumb_remove = $('#pl_thumb_remove').on('click', function(e){
        e.preventDefault();
        pl_thumb_preview.attr('src',empty_src);
        pl_thumb.val('');
    }),
    pl_thumb = $('#pl_thumb').on('keyup',function(){
        if($(this).val() == ''){
            pl_thumb_preview.attr('src',empty_src);
        }
    });
    if(pl_thumb.val() != ''){
        pl_thumb_remove.show();
    }





   

    //############################################//
    /* process in backend */
    //############################################//

    var id3Counter, playlistProcessData;

    function processBackend(dir){

        preloader.show();

        var useId3;
        if(id3.is(':checked'))useId3 = true;

        var sort = folder_sort.val();

        var url = hap_data.plugins_url + '/source/includes/folder_parser.php', ajax_data = {dir: dir};

        playlistProcessData = [];

        $.ajax({
            type: 'GET',
            url: url,
            data: ajax_data,
            dataType: "json"
        }).done(function(media) {

            var i, len = media.length, entry, obj, full_path;

            if(sort == 'filename-asc')keysrt(media, 'filename');
            else if(sort == 'filename-desc')keysrt(media, 'filename', true);
            else if(sort == 'date-asc')keysrt(media, 'filemtime');
            else if(sort == 'date-desc')keysrt(media, 'filemtime', true);

            for(i=0; i < len; i++){

                entry = media[i];

                var obj = {};
                obj.type = 'audio';
                obj.path = entry.fullpath;
                obj.title = entry.filename;

                obj.download = entry.fullpath;
                obj.link = entry.fullpath;
              
                playlistProcessData.push(obj);
            }
            
            if(useId3){
                id3Counter = playlistProcessData.length-1;
                getId3();
            }else{
                if(hap_data.settings.createAudioWaveformOnUpload == '1'){
                    processBackend2()
                }else{
                    saveMultiTracks()
                }
            } 
      
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log('Error processFolder: ' + jqXHR, textStatus, errorThrown);
            preloader.hide();
            editMediaSubmit = false;
            alert("Error process folder!");
        }); 
    }

    function getId3(){

        if(typeof jsmediatags === 'undefined'){

            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.0/jsmediatags.min.js';
            script.onload = script.onreadystatechange = function() {
                if(!this.readyState || this.readyState == 'complete'){
                    getId3();
                }
            };
            script.onerror = function(){
                alert("Error loading " + this.src);
            }
            var tag = document.getElementsByTagName('script')[0];
            tag.parentNode.insertBefore(script, tag);

        }else{

            var item = playlistProcessData[id3Counter],
            url = item.path;

            jsmediatags.read(url, {
                onSuccess: function(tag) {
                    var tags = tag.tags, image = tags.picture;

                    if(tags.artist) item.artist = tags.artist;
                    if(tags.title) item.title = tags.title;
                    if(tags.album) item.album = tags.album;
                    if(image){
                        var base64String = "", i, len = image.data.length;
                        for(i = 0; i < len; i++)base64String += String.fromCharCode(image.data[i]);
                        item.thumb = "data:" + image.format + ";base64," + window.btoa(base64String);
                    }

                    id3Counter--;
                    if(id3Counter > -1){
                        getId3();  
                    }else{
                        if(hap_data.settings.createAudioWaveformOnUpload == '1'){
                            processBackend2()
                        }else{
                            saveMultiTracks()
                        }
                    }

                },
                onError: function(error) {
                    console.log("ID3 error: ", error.type, error.info);
                    id3Counter--;
                    if(id3Counter > -1){
                        getId3();  
                    }else{
                        if(hap_data.settings.createAudioWaveformOnUpload == '1'){
                            processBackend2()
                        }else{
                            saveMultiTracks()
                        }
                    }  
                }
            });
        }
    }

    function processBackend2(){
        console.log('processBackend2')

        wsCounter = multi_uploader_data.length
        getWs();

    }


   

    //global thumb for playlist

    var thumbGlobal_remove = $('#thumbGlobal_remove').on('click', function(e){
    	e.preventDefault();
        thumbGlobal_preview.attr('src',empty_src);
        thumbGlobal.val('');
    });

    var thumbGlobal_preview = $('#thumbGlobal_preview')
   
    var thumbGlobal = $('#thumbGlobal').on('keyup',function(){
        if($(this).val() == ''){
            thumbGlobal_preview.attr('src',empty_src);
        }
    })

    //media thumb

    var thumb_remove = $('#thumb_remove').on('click', function(e){
    	e.preventDefault();
        thumb_preview.attr('src',empty_src);
        thumb.val('');
    });

    var thumb_preview = $('#thumb_preview')
   
    var thumb = $('#thumb').on('keyup',function(){
        if($(this).val() == ''){
            thumb_preview.attr('src',empty_src);
        }
    })

    //thumb default

    var thumb_default_remove = $('#thumb_default_remove').on('click', function(e){
    	e.preventDefault();
        thumb_default_preview.attr('src',empty_src);
        thumb_default.val('');
    });

    var thumb_default_preview = $('#thumb_default_preview')
   
    var thumb_default = $('#thumb_default').on('keyup',function(){
        if($(this).val() == ''){
            thumb_default_preview.attr('src',empty_src);
        }
    })


    //video

    var video_remove = $('#video_remove').on('click', function(e){
        e.preventDefault();
        video.val('');
    });


    //filter playlist

    $('#hap-filter-playlist').on('keyup.apfilter',function(){

        var value = $(this).val(), i, j = 0, item, title, len = playlistItemList.children('.hap-playlist-item').length;

        for(i = 0; i < len; i++){

            item = playlistItemList.children('.hap-playlist-item').eq(i)

            title = item.find('.playlist-title').val();

            if(title.indexOf(value) >- 1){
                item.show();
            }else{
                item.hide();
                j++;
            }
        }

    });

    //select all
    $('.hap-playlist-table').on('click', '.hap-playlist-all', function(){
        if($(this).is(':checked')){
            playlistItemList.find('.hap-playlist-indiv').prop('checked', true);
        }else{
            playlistItemList.find('.hap-playlist-indiv').prop('checked', false);
        }
    });

    //delete selected
    $('#hap-delete-playlists').on('click', function(){
        if(playlistItemList.find('.hap-playlist-indiv').length == 0)return false;//no media

        var selected = playlistItemList.find('.hap-playlist-indiv:checked');

        if(selected.length == 0) {
            alert("No playlists selected!");
            return false;
        }

        var result = confirm("Are you sure to delete selected playlists?");
        if(result){

            var arr = [];

            selected.each(function(){
                arr.push(parseInt($(this).attr('data-playlist-id'),10));
            });

            deletePlaylist(arr)
             
        }
    });

    playlistItemList.on('click', '.hap-delete-playlist', function(){

        var result = confirm("Are you sure to delete this playlist?");
        if(result){

            var playlist_id = parseInt($(this).closest('.hap-playlist-row').attr('data-playlist-id'),10);
console.log(playlist_id)
            deletePlaylist([playlist_id])

        }

        return false;

    })

    function deletePlaylist(arr){

        preloader.show();

        var postData = [
            {name: 'action', value: 'hap_delete_playlist'},
            {name: 'playlist_id', value: arr},
            {name: 'security', value: hap_data.security}
        ];
        console.log(postData)

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){

            preloader.hide();

            if(response){
                var i, len = arr.length;
                for(i = 0;i<len;i++){
                    playlistItemList.find('.hap-playlist-row[data-playlist-id="'+arr[i]+'"]').remove();
                }
                $('.hap-playlist-all').prop('checked', false);
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
        }); 

    }



    //add playlist

    //modal

    var addPlaylistModal = $('#hap-add-playlist-modal'),
    addPlaylistModalBg = addPlaylistModal.find('.hap-modal-bg').on('click',function(e){
        if(e.target == this){ // only if the target itself has been clicked
            removePlaylistModal()
        }
    });

    _doc.on('keyup', function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        
        var key = e.keyCode, target = $(e.target);
        
        if(key == 27) {//esc
            removePlaylistModal()
            removeMediaModal()
        } 
    }); 

    $('#hap-add-playlist-cancel').on('click',function(e){
        removePlaylistModal()
    });


    var addPlaylistSubmit
    $('#hap-add-playlist-submit').on('click',function(e){

        var title_field = $('#playlist-title')

        if(isEmpty(title_field.val())){
            title_field.addClass('aprf'); 
            addPlaylistModalBg.scrollTop(0);
            alert('Title is required!');
            return false;
        }

        if(addPlaylistSubmit)return false;
        addPlaylistSubmit = true;

        var title = title_field.val()

        preloader.show()
        removePlaylistModal()

        var postData = [
            {name: 'action', value: 'hap_create_playlist'},
            {name: 'security', value: hap_data.security},
            {name: 'title', value: title},
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){

            //go to edit playlist page
            window.location = playlistItemList.attr('data-admin-url') + '?page=hap_playlist_manager&action=edit_playlist&hap_msg=playlist_created&playlist_id=' + response

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            addPlaylistSubmit = false;
            removePlaylistModal()
            preloader.hide()
        });

        return false;

    });

    function removePlaylistModal(){
        addPlaylistModal.hide();  

        addPlaylistModal.find('#playlist-title').val('').removeClass('aprf'); 
    }

    $('#hap-add-playlist').on('click',function(e){
        showPlaylistModal()
    });

    function showPlaylistModal(){
        addPlaylistModal.show();
        $('#playlist-title').focus()
        addPlaylistModalBg.scrollTop(0);
    }







    
	//sortable media order
   
    mediaItemList.sortable({ 
        handle: ".media-id",
       // helper: fixWidthHelper,
        placeholder: "ui-placeholder",
        tolerance: 'pointer',

        start: function (event, ui) {
            ui.placeholder.html("<td colspan='10'></td>")
            ui.placeholder.height(ui.item.height());
        },

		update: function(event, ui) {
            updateSortOrder()
		}
	});

	function fixWidthHelper(e, ui) {//fix right shift on drag
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    }



    //filter media

    var mediafilterInited

    $('#hap-filter-media').on('keyup.apfilter',function(){

        var value = $(this).val(), i, j = 0, item, title, len = mediaItemList.children('.media-item').length;

        if(!mediafilterInited){
            mediaItemList.children('.media-item').each(function(){
                var item = $(this)
                if(item.hasClass('hap-pagination-hidden')){
                    item.addClass('hap-was-pagination-hidden').removeClass('hap-pagination-hidden')
                }
            })
            mediafilterInited = true;
        }

        for(i = 0; i < len; i++){

            item = mediaItemList.children('.media-item').eq(i)

            title = item.find('.media-title').html().toLowerCase();
            title += item.find('.media-artist').html().toLowerCase();

            if(value == ''){

                mediaItemList.children('.media-item').each(function(){
                    var item = $(this).removeClass('hap-filter-hidden hap-filter-shown')

                    if(item.hasClass('hap-was-pagination-hidden')){
                        item.removeClass('hap-was-pagination-hidden').addClass('hap-pagination-hidden')
                    }
                });

                mediafilterInited = false;

            }else{

                if(title.indexOf(value) >- 1){
                    item.addClass('hap-filter-shown').removeClass('hap-filter-hidden');
                }else{
                    item.removeClass('hap-filter-shown').addClass('hap-filter-hidden');
                    j++;
                }

            }
        }

    });
    
    //select all
    mediaTable.on('click', '.hap-media-all', function(){
        if($(this).is(':checked')){
            mediaItemList.find('.media-item:not(.hap-pagination-hidden)').find('.hap-media-indiv').prop('checked', true);
        }else{
            mediaItemList.find('.media-item:not(.hap-pagination-hidden)').find('.hap-media-indiv').prop('checked', false);
        }
    });

    //delete selected
    $('#hap-delete-media').on('click', function(){
        if(mediaItemList.find('.hap-media-indiv').length == 0)return false;//no media

        var selected = mediaItemList.find('.hap-media-indiv:checked');

        if(selected.length == 0) {
            alert("No media selected!");
            return false;
        }

        var result = confirm("Are you sure to delete selected media?");
        if(result){

            preloader.show();

            var arr = [];

            selected.each(function(){
                arr.push(parseInt($(this).closest('.media-item').attr('data-media-id'),10));
            });

            deleteMedia(arr)
            
        }

    });

	var action_do,
    playlistSelectorWrap = $('#playlist-selector-wrap'),
    hap_playlist_selector = $('#hap_playlist_selector')

    //copy selected
    $('#hap-copy-media').on('click', function(){
        if(mediaItemList.find('.hap-media-indiv').length == 0)return false;//no media

        var selected = mediaItemList.find('.hap-media-indiv:checked');

        if(selected.length == 0) {
            alert("No media selected!");
            return false;
        }
        action_do = 'copy';

        playlistSelectorWrap.find('option[value='+curr_playlist_id+']').prop('disabled', '');
        playlistSelectorWrap.show(400)
           
    });

    //move selected
    $('#hap-move-media').on('click', function(){
        if(mediaItemList.find('.hap-media-indiv').length == 0)return false;//no media

        var selected = mediaItemList.find('.hap-media-indiv:checked');

        if(selected.length == 0) {
            alert("No media selected!");
            return false;
        }
        action_do = 'move';

        console.log(playlistSelectorWrap.find('option[value='+curr_playlist_id+']').length, curr_playlist_id)

        playlistSelectorWrap.find('option[value='+curr_playlist_id+']').prop('disabled', 'disabled');//cant move to same playlist
        playlistSelectorWrap.show(400)
           
    });

    $('#selected-ok').on('click', function(){

        var result = confirm("Are you sure to "+action_do+" selected media?");
        if(result){

            preloader.show();

            var arr = [];
            var selected = mediaItemList.find('.hap-media-indiv:checked');

            selected.each(function(){
                arr.push(parseInt($(this).closest('.media-item').attr('data-media-id'),10));
            });
            
            var action = action_do == 'copy' ? 'hap_copy_media' : 'hap_move_media';
            var postData = [
                {name: 'action', value: action},
                {name: 'destination_playlist_id', value: hap_playlist_selector.find('option:selected').attr('value')},
                {name: 'media_id', value: arr},
                {name: 'security', value: hap_data.security}
            ];

            $.ajax({
                url: hap_data.ajax_url,
                type: 'post',
                data: postData,
                dataType: 'json',   
            }).done(function(response){

                preloader.hide();

                if(response == 'SUCCESS'){
                    if(action_do == 'move'){
                        selected.closest('.media-item').remove();
                        $('.hap-media-all').prop('checked', false);
                    }

                }

                updatePagination()

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText, textStatus, errorThrown);
                preloader.hide();
            });  
        }

    });

    $('#selected-cancel').on('click', function(){
        playlistSelectorWrap.hide(400);
    });


    //************* peak array data

    var wavesurfer

    if(document.getElementById('hap-ws-waveform')){

        wavesurfer = WaveSurfer.create({
            container: document.getElementById('hap-ws-waveform'),
            backend: 'MediaElement',
            mediaType: 'audio',
        });

        wavesurfer.on('waveform-ready', function() {
            var pcm = wavesurfer.exportPCM(100, 100, true);

            if(multi_uploading_on){

                pcm.then(function(val) { 

                    if(Array.isArray(val)){
                        val = val.toString(); 
                    }else{
                        if(val.charAt(0) == '[')val = val.substr(1); 
                        if(val.charAt(val.length-1) == ']')val = val.substr(0, val.length-1); 
                    }

                    multi_uploader_data[wsCounter].peaks = val;

                    getWs()

                }); 

            }else{
                
                pcm.then(function(val) { 

                    if(Array.isArray(val)){
                       val = val.toString(); 
                    }else{
                        if(val.charAt(0) == '[')val = val.substr(1); 
                        if(val.charAt(val.length-1) == ']')val = val.substr(0, val.length-1); 
                    }
                    
                    peaks.val(val);

                }); 

                preloader.hide();

            }
                   
        });

        wavesurfer.on('error', function(er) {
            console.log(er);

            multi_uploader_data.splice(wsCounter, 1)

            getWs()
            
        });

    }

    function getWs(){

        wsCounter--;
        if(wsCounter >= 0){
            wavesurfer.empty();

            var url = multi_uploader_data[wsCounter].path;

            if(window.location.protocol == 'https:'){
                var wurl = url.replace('http://','https://');
            }else{
                var wurl = url.replace('https://','http://');
            }

            wavesurfer.load(wurl);

        }else{
            multi_uploading_on = false;
            if(create_peaks_process){
                savePeaks()
            }else{
                saveMultiTracks()
            }
        }

    }
    



    //############################################//
    /* uploader */
    //############################################//
	
    var uploadManagerArr = [
        {btn:$("#audio_preview_upload"), manager:null},
    	{btn:$("#file_upload"), manager:null},
    	{btn:$("#thumbGlobal_upload"), manager:null},
		{btn:$("#thumb_upload"), manager:null},
		{btn:$("#thumb_default_upload"), manager:null},
		{btn:$("#download_upload"), manager:null},
        {btn:$("#pl_thumb_upload"), manager:null},
        {btn:$("#lyrics_upload"), manager:null},
        {btn:$("#video_upload"), manager:null},
	];
	setUploadManager(uploadManagerArr);

	function setUploadManager(arr){
		var i, len = arr.length, item;
		for(i=0;i<len;i++){
			item = arr[i].btn.attr('data-id',i);
		
			item.on('click',function(e){
				e.preventDefault();
 			
				var library, source, id = $(this).attr("id"), data_id = parseInt($(this).attr("data-id"),10), custom_uploader;

	            if(uploadManagerArr[data_id].manager){//reuse
	                uploadManagerArr[data_id].manager.open();
	                return;
	            }

                if(id == 'audio_preview_upload'){
                    
                    library = "audio";
                    source = '#audio_preview';
                    
                } 
	            else if(id == 'file_upload'){

                    if(media_type == 'audio')library = "audio";
                    else library = "";
					source = '#path';

				}else if(id == 'thumb_upload'){
				
					library = "image";
					source = '#thumb';
				
				}else if(id == 'thumbGlobal_upload'){
				
					library = "image";
					source = '#thumbGlobal';

				}else if(id == 'thumb_default_upload'){
				
					library = "image";
					source = '#thumb_default';

				}else if(id == 'download_upload'){
					
					library = "";
					source = '#download';
							
				}else if(id == 'pl_thumb_upload'){
                
                    library = "image";
                    source = '#pl_thumb';
                
                }else if(id == 'lyrics_upload'){
                    
                    library = "";
                    source = '#lyrics';  

                }else if(id == 'video_upload'){
                    
                    library = "video/*";
                    source = '#video';  

                }

				custom_uploader = wp.media({
					library:{
						type: library
					}
				})
				.on("select", function(){
					var attachment = custom_uploader.state().get("selection").first().toJSON();
					$(source).val(attachment.url);
                    console.log(attachment)
                    
                    if(media_type == 'audio' && source == '#path'){

                        //meta
                        if(attachment.title)title.val(attachment.title.replace(/"/g, "'"))

                        if(attachment.meta){
                            if(attachment.meta.artist)artist.val(attachment.meta.artist.replace(/"/g, "'"))
                            if(attachment.meta.album)album.val(attachment.meta.album.replace(/"/g, "'"))
                        }

                        if(attachment.image && attachment.image.src){
                            if(attachment.image.src.indexOf("wp-includes/images/media/audio.png") == -1){
                                thumb.val(attachment.image.src)
                                thumb_preview.attr('src', attachment.image.src);
                            } 
                        }

                        if(attachment.thumb && attachment.thumb.src){
                            if(attachment.thumb.src.indexOf("wp-includes/images/media/audio.png") == -1){
                                thumb_small.val(attachment.thumb.src);
                            }
                        }

                        if(attachment.description)description.val(attachment.description.replace(/"/g, "'"))

                        if(attachment.fileLength){
                            var fl = hmsToSecondsOnly(attachment.fileLength)
                            duration.val(fl)
                        }
                        //meta

                        if(hap_data.settings.createAudioWaveformOnUpload == '1'){

                            //get peak array
                       
                            preloader.show();
                            wavesurfer.empty();
                    
                            if(window.location.protocol == 'https:'){
                                var wurl = attachment.url.replace('http://','https://');
                            }else{
                                var wurl = attachment.url.replace('https://','http://');
                            }

                            wavesurfer.load(wurl);

                        }

                    }

					if(source == '#thumbGlobal'){
                        thumbGlobal_preview.attr('src', attachment.url);
                    }else if(source == '#thumb'){
                        thumb_preview.attr('src', attachment.url);
                        thumb_small.val(attachment.url);
                    }else if(source == '#thumb_default'){
                        thumb_default_preview.attr('src', attachment.url);
                    }else if(source == '#pl_thumb'){
                        pl_thumb_preview.attr('src', attachment.url);
                    }

				})
				.open();

				uploadManagerArr[data_id].manager = custom_uploader;//save for reuse

			});
		}	
	}

    //upload multiple

    var multi_uploader,
    multi_uploader_data = [],
    multi_uploading_on,
    create_peaks_process,
    wsCounter

    $('#hap-upload-multiple-media').on('click', function(){

        if(editMediaSubmit)return false;
        editMediaSubmit = true;

        if(multi_uploader){//reuse
            multi_uploader.open();
            return;
        }

        multi_uploader = wp.media({
            library:{
                type: "audio"
            },
            multiple:true
        })
        .on("select", function(){
            var attachment_data = multi_uploader.state().get('selection').map( 
                function( attachment ) {
                    attachment.toJSON();
                    return attachment;
            });

            multi_uploader_data = []
            multi_uploading_on = true

            var i, attachment, len = attachment_data.length, obj;
            for (i = 0; i < len; i++) {

                attachment = attachment_data[i].attributes

                obj = {}

                obj.type = attachment.type
                obj.path = attachment.url
         
                if(attachment.title)obj.title = attachment.title.replace(/"/g, "'")
                if(attachment.meta){
                    if(attachment.meta.artist)obj.artist = attachment.meta.artist.replace(/"/g, "'")
                    if(attachment.meta.album)obj.album = attachment.meta.album.replace(/"/g, "'")
                }

                if(attachment.image && attachment.image.src){
                    if(attachment.image.src.indexOf("wp-includes/images/media/audio.png") == -1){ 
                        obj.thumb = attachment.image.src;
                    }
                }

                if(attachment.thumb && attachment.thumb.src){
                    if(attachment.thumb.src.indexOf("wp-includes/images/media/audio.png") == -1){
                        obj.thumb_small = attachment.thumb.src;
                    }
                }

                if(attachment.description)obj.description = attachment.description.replace(/"/g, "'")

                if(attachment.fileLength){
                    obj.duration = hmsToSecondsOnly(attachment.fileLength)
                }

                multi_uploader_data.push(obj)

            }

            if(hap_data.settings.createAudioWaveformOnUpload == '1'){
                preloader.show();
                processBackend2()
            }else{
                saveMultiTracks()
            }

        }).on('close',function() {
            editMediaSubmit = false;
        })
        .open();

    })

    //create waves from exisiting songs

    $('#hap-create-peaks').on('click', function(){

        var result = confirm($(this).attr('data-title'));

        if(result){

            if(editMediaSubmit)return false;
            editMediaSubmit = true;

            create_peaks_process = true;

            multi_uploader_data = []
            multi_uploading_on = true

            mediaItemList.find('.media-item').each(function(){

                var item = $(this), type = item.find('.media-type').html()
                if(type == 'audio' && item.attr('data-peak-id') == '0'){

                    var obj = {}
                    obj.mediaId = item.attr('data-media-id')
                    obj.path = item.find('.media-path').html()

                    multi_uploader_data.push(obj)

                }

            })

            if(multi_uploader_data.length){

                preloader.show();

                wsCounter = multi_uploader_data.length
                getWs();

            }else{

                editMediaSubmit = false;
                create_peaks_process = false;
                multi_uploading_on = false;

                alert($(this).attr('data-none'))
            }

        }

    })

    function saveMultiTracks(){
        console.log('saveMultiTracks')

        var postData = [
            {name: 'action', value: 'hap_add_media_multiple'},
            {name: 'playlist_id', value: $('.hap-admin').attr('data-playlist-id')},
            {name: 'media', value: JSON.stringify(multi_uploader_data)},
            {name: 'security', value: hap_data.security}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',
        }).done(function(response){

            //console.log(response)

            createTracksFromResponse(response)
            
            preloader.hide();
            last_media_type = media_type
            //removeMediaModal()
            editMediaSubmit = false;

            updatePagination(true)

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
            editMediaSubmit = false;
        }); 

    }

    function savePeaks(){

        var postData = [
            {name: 'action', value: 'hap_save_peaks'},
            {name: 'playlist_id', value: $('.hap-admin').attr('data-playlist-id')},
            {name: 'media', value: JSON.stringify(multi_uploader_data)},
            {name: 'security', value: hap_data.security}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',
        }).done(function(response){

            console.log(response)

            preloader.hide();
            editMediaSubmit = false;
            create_peaks_process = false;

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
            editMediaSubmit = false;
            create_peaks_process = false;
        }); 

    }

     //get other data from form
      /*  var obj = {};
        if(!isEmpty(download.val()))obj.download = download.val();
        if(!isEmpty(link.val())){
            obj.link = link.val();
            obj.target = target.val();
        }

        if(!isEmpty(start.val()))obj.start = start.val();
        if(!isEmpty(end.val()))obj.end = end.val();

        var i, len = playlistProcessData.length;
        for(i = 0; i < len; i++){
            $.extend(playlistProcessData[i], obj);
        }

        console.log(playlistProcessData)

        var postData = [
            {name: 'action', value: 'hap_add_media_from_backend'},
            {name: 'playlist_id', value: $('.hap-admin').attr('data-playlist-id')},
            {name: 'media', value: JSON.stringify(playlistProcessData)},
            {name: 'security', value: hap_data.security}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',
        }).done(function(response){

            createTracksFromResponse(response)

            preloader.hide();
            last_media_type = media_type
            removeMediaModal()
            editMediaSubmit = false;

            updatePagination(true)

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
            editMediaSubmit = false;
        }); 
*/



    function createTracksFromResponse(response){

        var i, response_len = response.length, obj, position_set

        for (i = 0; i < response_len; i++) {

            obj = response[i]

            var order_id = parseInt(obj.order_id,10),
            media_id = obj.insert_id,
            options = obj.options

            var container = $('.hap-media-item-container-orig').clone().removeClass('hap-media-item-container-orig').addClass('media-item hap-pagination-hidden')
            .attr('data-media-id', media_id).attr('data-order-id', order_id)

            container.find('.media-id').html(media_id)
            container.find('.media-type').html(options.type)
            if(options.thumb)container.find('.hap-media-thumb-img').attr('src', options.thumb)
            if(options.artist)container.find('.media-artist').html(options.artist)
            if(options.title)container.find('.media-title').html(options.title)
            if(options.path)container.find('.media-path').html(options.path)
         

            //insert track

            if(!position_set){

                var len = mediaItemList.find('.media-item').length
                if(len == 0){
                    //0 items in list
                    mediaItemList.append(container);
                }else{
                    //find position

                    var toinsert = true;
                    mediaItemList.find('.media-item').each(function(){
                        var oid = parseInt($(this).attr('data-order-id'),10)
                        if(order_id < oid){
                            if(toinsert){
                                $(this).before(container);
                                toinsert = false;
                                return false;
                            }
                        }
                    });
                    
                    if(toinsert){
                        mediaItemList.append(container);
                    }
                }

                position_set = container;

            }else{
                container.insertAfter(position_set);
            }
        }

    }





    //save playlist options submit

    var editPlaylistForm = $('#hap-edit-playlist-form')

    //prevent enter sumbit form
    editPlaylistForm.keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    var editPlaylistSubmit;
    $('#hap-edit-playlist-form-submit').on('click', function (){

        if(editPlaylistSubmit)return false;//prevent double submit
        editPlaylistSubmit = true;

        preloader.show();

        var options = {};
        $.each(editPlaylistForm.serializeArray(), function(i, field) {

            if(field.name != 'playlist-category[]' 
                && field.name != 'playlist-tag[]' 
                )options[field.name] = field.value;
        });

        //https://stackoverflow.com/questions/7335281/how-can-i-serializearray-for-unchecked-checkboxes
        editPlaylistForm.find("input:checkbox:not(:checked)").map(function() {
           
            if(this.name != 'playlist-category[]' 
                && this.name != 'playlist-tag[]' 
                )options[this.name] = "0";
        });

        //category
        var category_arr = []
        playlistCategoryWrap.find('.hap-category-item').each(function() {
            category_arr.push($(this).attr('data-id')); 
        });

        //tag
        var tag_arr = []
        playlistTagWrap.find('.hap-tag-item').each(function() {
            tag_arr.push($(this).attr('data-id')); 
        });


        //console.log(options)

        var postData = [
            {name: 'action', value: 'hap_save_playlist_options'},
            {name: 'playlist_id', value: $('.hap-admin').attr('data-playlist-id')},
            {name: 'playlist_options', value: JSON.stringify(options)},
            {name: 'playlist_category', value: category_arr},
            {name: 'playlist_tag', value: tag_arr},
            {name: 'security', value: hap_data.security}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',
        }).done(function(response){

            preloader.hide();
            editPlaylistSubmit = false;

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
            editPlaylistSubmit = false;
        }); 

        return false;
      
    });





    //taxonomy

    //get all existing categories 

    //playlist

    var playlistCategoryWrap = $('#hap-playlist-category-wrap'),
    playlistCategoryDialogContainer = $('#hap-playlist-category-dialog-container'),
    playlistCategoryDialogList = $('#hap-playlist-category-dialog-list')

    var playlistTagWrap = $('#hap-playlist-tag-wrap'),
    playlistTagDialogContainer = $('#hap-playlist-tag-dialog-container'),
    playlistTagDialogList = $('#hap-playlist-tag-dialog-list')

    if(typeof map_all_playlist_taxonomy !== 'undefined'){
        var i, len = map_all_playlist_taxonomy.length, category_str = '', tag_str = '', tax;
        for(i=0;i<len;i++){
            tax = map_all_playlist_taxonomy[i];

            if(tax.type == 'category'){

                category_str += '<div class="hap-category-dialog-list-item"><label><input class="playlist-category" type="checkbox" value="'+tax.id+'" title="'+tax.title+'" name="playlist-category[]">'+tax.title+'</label></div>'
            }else if(tax.type == 'tag'){

                tag_str += '<div class="hap-tag-dialog-list-item"><label><input class="playlist-tag" type="checkbox" value="'+tax.id+'" title="'+tax.title+'" name="playlist-tag[]">'+tax.title+'</label></div>'

            }
        }
        //playlist
        playlistCategoryDialogList.html(category_str)
        playlistTagDialogList.html(tag_str)

    }

    //select playlist category

    if(typeof map_playlist_taxonomy !== 'undefined'){
        var i, len = map_playlist_taxonomy.length, tax;
        for(i=0;i<len;i++){
            tax = map_playlist_taxonomy[i];

            if(tax.type == 'category'){
                playlistCategoryDialogList.find('.playlist-category[value="'+tax.id+'"]').prop('checked', true).attr('checked', true);

                addCategory(tax, playlistCategoryWrap);

            }else if(tax.type == 'tag'){

                playlistTagDialogList.find('.playlist-tag[value="'+tax.id+'"]').prop('checked', true).attr('checked', true);

                addTag(tax, playlistTagWrap);
            }

        }
    }

    function addCategory(tax, container){

        $('<div class="hap-category-item-wrap">'+
            '<div class="hap-category-item" data-id="'+tax.id+'" title="'+tax.title+'">'+tax.title+'</div>'+
            '</div>').appendTo(container);
    }

    function addTag(tax, container){

        $('<div class="hap-tag-item-wrap">'+
            '<div class="hap-tag-item" data-id="'+tax.id+'" title="'+tax.title+'">'+tax.title+'</div>'+
            '</div>').appendTo(container);
    }

    //hide dialog
    $('#hap-category-dialog-close').on('click',function(){
        $(this).closest('.hap-dialog-container').hide()
    });
    
    //show dialog
    $('#hap-playlist-category').on('click',function(){
        playlistCategoryDialogContainer.show()
    });

    $('#hap-playlist-tag').on('click',function(){
        playlistTagDialogContainer.show()
    });
  

    //media

    var mediaCategoryWrap = $('#hap-media-category-wrap'),
    mediaCategoryDialogContainer = $('#hap-media-category-dialog-container'),
    mediaCategoryDialogList = $('#hap-media-category-dialog-list')

    var mediaTagWrap = $('#hap-media-tag-wrap'),
    mediaTagDialogContainer = $('#hap-media-tag-dialog-container'),
    mediaTagDialogList = $('#hap-media-tag-dialog-list')

    if(typeof map_all_playlist_taxonomy !== 'undefined'){
        var i, len = map_all_playlist_taxonomy.length, category_str = '', tag_str = '', tax;
     
        for(i=0;i<len;i++){

            tax = map_all_playlist_taxonomy[i];

            if(tax.type == 'category'){

                category_str += '<div class="hap-category-dialog-list-item"><label><input class="media-category" type="checkbox" value="'+tax.id+'" title="'+tax.title+'" name="media-category[]">'+tax.title+'</label></div>'

            }else if(tax.type == 'tag'){

                tag_str += '<div class="hap-tag-dialog-list-item"><label><input class="media-tag" type="checkbox" value="'+tax.id+'" title="'+tax.title+'" name="media-tag[]">'+tax.title+'</label></div>'

            }

        }

        mediaCategoryDialogList.html(category_str)
        mediaTagDialogList.html(tag_str)
    }
    
    //show dialog
    $('#hap-media-category').on('click',function(){
        mediaCategoryDialogContainer.show()
    });

    $('#hap-media-tag').on('click',function(){
        mediaTagDialogContainer.show()
    });
  
  
    //close dialog, update tax

    $('.hap-category-dialog-close').on('click',function(){
        var dialog = $(this).closest('.hap-dialog-container')
        dialog.hide()
        var id = dialog.attr('id')

        if(id == 'hap-playlist-category-dialog-container'){

            playlistCategoryWrap.empty()
            playlistCategoryDialogList.find('.playlist-category:checked').each(function(){

                var item = $(this),
                id = item.val(),
                title = item.attr('title')
                addCategory({id: id, title: title}, playlistCategoryWrap);
            })
        }
        else if(id == 'hap-playlist-tag-dialog-container'){

            playlistTagWrap.empty()
            playlistTagDialogList.find('.playlist-tag:checked').each(function(){

                var item = $(this),
                id = item.val(),
                title = item.attr('title')
                addTag({id: id, title: title}, playlistTagWrap);
            })
        }
        else if(id == 'hap-media-category-dialog-container'){

            mediaCategoryWrap.empty()
            mediaCategoryDialogList.find('.media-category:checked').each(function(){

                var item = $(this),
                id = item.val(),
                title = item.attr('title')
                addCategory({id: id, title: title}, mediaCategoryWrap);
            })
        }
        else if(id == 'hap-media-tag-dialog-container'){

            mediaTagWrap.empty()
            mediaTagDialogList.find('.media-tag:checked').each(function(){

                var item = $(this),
                id = item.val(),
                title = item.attr('title')
                addTag({id: id, title: title}, mediaTagWrap);
            })
        }
    });
  
    







    //add/edit media form submit
    var editMediaForm = $('#hap-edit-media-form');
    var editMediaSubmit;
  

    //add, edit media modal





    var mediaSaveType,//add, edit
    mediaSaveId,
    to_update_data = {}

    var mediaModal = $('#hap-edit-media-modal'),
    modalBg = mediaModal.find('.hap-modal-bg').on('click',function(e){
        if(e.target == this){ // only if the target itself has been clicked
            removeMediaModal()
        }
    });

    $('#hap-edit-media-form-cancel').on('click',function(e){
        removeMediaModal()
    });

    $('#hap-edit-media-form-submit, #hap-edit-media-form-submit2').on('click',function(e){

        if(editMediaSubmit)return false;//prevent double submit
        editMediaSubmit = true;
        

        if($(this).hasClass('hap-edit-playlist-mode')){

            if(isEmpty(path.val())){
                path.addClass('aprf'); 
                modalBg.scrollTop(0);
                editMediaSubmit = false;
                alert('Please fill required fields in red!');
                return false;
            }

            //pi icons
            var required;
            hap_pi_table_wrap.find('input[required]').each(function(){

                var input = $(this);
                if(input.val() == ""){
                    input.addClass('aprf');
                    required = true;
                }
            });

            if(required){
                modalBg.animate({scrollTop: $('#playlist_icons_field').offset().top + 150});
                editMediaSubmit = false;
                alert('Please fill required fields in red!');
                return false;
            }




            if(media_type == 'folder_backend'){

                if(folder_custom_url.is(':checked')){
                    var dir = path.val();
                }else{
                    var dir = hap_data.file_url + path.val();
                }

                processBackend(dir);
                return false;
            }

        }else if($(this).hasClass('hap-get-audio-shortcode-mode')){

            //check required
            var parent, first_input;
         
            get_audio_shortcode_submit.find('input[required]').each(function(){
                var input = $(this);
                if(input.val() == ""){

                    parent = true;

                    if(!first_input)first_input = input

                    input.addClass('aprf');

                }else{
                    input.removeClass('aprf');
                }
            });

            if(parent){
                editMediaSubmit = false;

                first_input[0].scrollIntoView({behavior: "smooth",block: 'center'});
                first_input = null;
                alert('Please fill required fields in red!');
                return false;
            }
            
        }



        var s = '[apmap_audio type="'+media_type+'"'//shortcode

        var options = {};

        options.type = media_type

        if(!isEmpty(path.val())){
            options.path = path.val().replace(/"/g, "'");
            if(options.path)s += ' path="'+options.path+'"'
        }

        if(media_type == 'folder'){
            options.folder_custom_url = folder_custom_url.val()
            options.id3 = id3.val()
            options.folder_sort = folder_sort.val()

            s += ' folder_custom_url="'+options.folder_custom_url+'"'
            if(options.id3 && options.id3 == '1')s += ' id3="'+options.id3+'"'
        }

        if(!isEmpty(thumb.val())){
            options.thumb = thumb.val().replace(/"/g, "'");
            if(options.thumb)s += ' thumb="'+options.thumb+'"'
        }
        
        if(active_accordion_field.css('display') != 'none'){
            if(!isEmpty(active_accordion.val())){
                options.active_accordion = active_accordion.val()    
                if(options.active_accordion)s += ' active_accordion="'+options.active_accordion+'"'
            }
        }

        if(audio_preview_field.css('display') != 'none'){
            if(!isEmpty(audio_preview.val())){
                options.audio_preview = audio_preview.val()    
                if(options.audio_preview)s += ' audio_preview="'+options.audio_preview+'"'
            }
        }

        if(peak_field.css('display') != 'none'){
            if(!isEmpty(peaks.val())){
                options.peaks = peaks.val().replace(/"/g, "'");   
                if(options.peaks)s += ' peaks="'+options.peaks+'"'
            }
        }

        if(shoutcast_version_field.css('display') != 'none'){
            if(!isEmpty(shoutcast_version.val())){
                options.shoutcast_version = shoutcast_version.val()    
                if(options.shoutcast_version)s += ' shoutcast_version="'+options.shoutcast_version+'"'
            }
        }

        if(sid_field.css('display') != 'none'){
            if(!isEmpty(sid.val())){
                options.sid = sid.val()    
                if(options.sid)s += ' sid="'+options.sid+'"'
            }
        }

        if(mountpoint_field.css('display') != 'none'){
            if(!isEmpty(mountpoint.val())){
                options.mountpoint = mountpoint.val()    
                if(options.mountpoint)s += ' mountpoint="'+options.mountpoint+'"'
            }
        }

        if(gdrive_sort_field.css('display') != 'none'){
            if(!isEmpty(gdrive_sort.val())){
                options.gdrive_sort = gdrive_sort.val()    
                if(options.gdrive_sort)s += ' gdrive_sort="'+options.gdrive_sort+'"'
            }
        }

        if(limit_field.css('display') != 'none'){
            if(!isEmpty(limit.val())){
                options.limit = limit.val()    
                if(options.limit)s += ' limit="'+options.limit+'"'
            }
        }

        if(load_more_field.css('display') != 'none'){
            if(load_more.val() == '1'){
                options.load_more = load_more.val()  
                s += ' load_more="1"'       
            }
        }
        
        if(!isEmpty(title.val())){
            options.title = title.val().replace(/"/g, "'");
            if(options.title)s += ' title="'+options.title+'"'
        }

        if(!isEmpty(artist.val())){
            options.artist = artist.val().replace(/"/g, "'");
            if(options.artist)s += ' artist="'+options.artist+'"'
        }

        if(!isEmpty(album.val())){
            options.album = album.val().replace(/"/g, "'");
            if(options.album)s += ' album="'+options.album+'"'
        }

        if(!isEmpty(description.val())){
            options.description = description.val().replace(/"/g, "'");
            if(options.description)s += ' description="'+options.description+'"'
        }

        if(!isEmpty(thumb.val())){
            options.thumb = thumb.val().replace(/"/g, "'");
            if(options.thumb)s += ' thumb="'+options.thumb+'"'
        }

        if(!isEmpty(thumb_small.val())){
            options.thumb_small = thumb_small.val().replace(/"/g, "'");
            if(options.thumb_small)s += ' thumb_small="'+options.thumb_small+'"'
        }

        if(!isEmpty(thumb_alt.val())){
            options.thumb_alt = thumb_alt.val().replace(/"/g, "'");
            if(options.thumb_alt)s += ' thumb_alt="'+options.thumb_alt+'"'
        }
        
        if(!isEmpty(lyrics.val())){
            options.lyrics = lyrics.val().replace(/"/g, "'");
            if(options.lyrics)s += ' lyrics="'+options.lyrics+'"'
        }

        if(!isEmpty(duration.val())){
            options.duration = duration.val();
            if(options.duration)s += ' duration="'+options.duration+'"'
        }

        if(!isEmpty(download.val())){
            options.download = download.val().replace(/"/g, "'");
            if(options.download)s += ' download="'+options.download+'"'
        }

        //pi icons
        if(hap_pi_table_wrap.children().length > 0){
            var pi_icons = [], obj

            hap_pi_table_wrap.find('.hap-pi-table').each(function(){
                var item = $(this)

                obj = {}
                obj.title = item.find('.pi-title').val();
                obj.url = item.find('.pi-url').val();
                obj.target = item.find('.pi-target').val();
                obj.icon = item.find('.pi-icon').val();

                pi_icons.push(obj)

            })

            options.pi_icons = pi_icons

        }
          
        if(!isEmpty(link.val())){
            options.link = link.val().replace(/"/g, "'");
            options.target = target.val();

            if(options.link){
                s += ' link="'+options.link +'"' 
                if(options.target)s += ' target="'+options.target+'"'
            }
        }

        if(!isEmpty(start.val())){
            options.start = start.val();
            if(options.start)s += ' start="'+options.start+'"'
        }

        if(!isEmpty(end.val())){
            options.end = end.val();
            if(options.end)s += ' end="'+options.end+'"'
        }

        if(!isEmpty(video.val())){
            options.video = video.val();
            if(options.video)s += ' video="'+options.video+'"'
        }


        console.log(options)
        

        //category
        var category_arr = [], category_title = ''
        mediaCategoryWrap.find('.hap-category-item').each(function() {
            category_arr.push($(this).attr('data-id')); 
            category_title += $(this).attr('title') + ',' 
        });
        category_title = category_title.substr(0,category_title.length-1)//remove last comma

        //tag
        var tag_arr = [], tag_title = ''
        mediaTagWrap.find('.hap-tag-item').each(function() {
            tag_arr.push($(this).attr('data-id')); 
            tag_title += $(this).attr('title') + ','
        });
        tag_title = tag_title.substr(0,tag_title.length-1)




        to_update_data = {}
        to_update_data.title = options.title;
        to_update_data.artist = options.artist; 
        to_update_data.path = options.path;
        to_update_data.thumb = options.thumb;
        to_update_data.category_title = category_title
        to_update_data.tag_title = tag_title
        to_update_data.peaks = options.peaks ? '1' : '0'





        if($(this).hasClass('hap-edit-playlist-mode')){

            var media_id = '';
            if(mediaSaveType == 'edit_media'){
                media_id = mediaSaveId
                to_update_data.media_id = media_id;
            }

            removeMediaModal()
            preloader.show();



            var postData = [
                {name: 'action', value: 'hap_add_media'},
                {name: 'save_type', value: mediaSaveType},
                {name: 'media_id', value: media_id},
                {name: 'playlist_id', value: $('.hap-admin').attr('data-playlist-id')},
                {name: 'options', value: JSON.stringify(options)},
                {name: 'media_category', value: category_arr},
                {name: 'media_tag', value: tag_arr},
                {name: 'security', value: hap_data.security}
            ];

            if(mediaSaveType == 'add_media'){
                postData.push({name: 'additional_playlist', value: additionalPlaylist.val()})
            }


            $.ajax({
                url: hap_data.ajax_url,
                type: 'post',
                data: postData,
                dataType: 'json',
            }).done(function(response){

                console.log(response)

                //create track 

                if(mediaSaveType == 'add_media'){

                    var order_id = parseInt(response.order_id,10),
                    media_id = response.insert_id

                    var container = $('.hap-media-item-container-orig').clone().removeClass('hap-media-item-container-orig').addClass('media-item hap-pagination-hidden')
                    .attr('data-media-id', media_id).attr('data-order-id', order_id)

                    container.find('.media-id').html(media_id)
                    container.find('.media-type').html(options.type)
                    if(options.thumb)container.find('.hap-media-thumb-img').attr('src', options.thumb)
                    if(options.artist)container.find('.media-artist').html(options.artist)
                    if(options.title)container.find('.media-title').html(options.title)
                    if(options.path)container.find('.media-path').html(options.path)
                    if(category_title.length)container.find('.media-category').html(category_title)
                    if(tag_title.length)container.find('.media-tag').html(tag_title)
                   

                    //insert track

                    var len = mediaItemList.find('.media-item').length
                    if(len == 0){
                        //0 items in list
                        mediaItemList.append(container);
                    }else{
                        //find position

                        var toinsert = true;
                        mediaItemList.find('.media-item').each(function(){
                            var oid = parseInt($(this).attr('data-order-id'),10)
                            if(order_id < oid){
                                if(toinsert){
                                    $(this).before(container);
                                    toinsert = false;
                                    return false;
                                }
                            }
                        });
                        
                        if(toinsert){
                            mediaItemList.append(container);
                        }

                    }

                    updatePagination(true)

                }
                else if(mediaSaveType == 'edit_media'){

                    var trx = mediaItemList.find('.media-item[data-media-id="'+to_update_data.media_id+'"]')

                    var isrc = to_update_data.thumb ? to_update_data.thumb : empty_src
                    trx.find('.hap-media-thumb-img').attr('src', isrc)
                    trx.find('.media-title').html(to_update_data.title)
                    trx.find('.media-artist').html(to_update_data.artist)
                    trx.find('.media-path').html(to_update_data.path)
                    trx.find('.media-category').html(to_update_data.category_title)
                    trx.find('.media-tag').html(to_update_data.tag_title)
                    trx.attr('data-peak-id', to_update_data.peaks)

                }

                preloader.hide();
                editMediaSubmit = false;

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText, textStatus, errorThrown);
                preloader.hide();
                editMediaSubmit = false;
            }); 

        }else if($(this).hasClass('hap-get-audio-shortcode-mode')){

            if($(this).attr('id') == 'hap-edit-media-form-submit2'){
                //add new audio shortcode to final shortcode

                var curr_sh = $('#hap-quick-audio-shortcode-ta').val()
                if(curr_sh.length == 0){
                    
                    //if user first clicks on add audio and shortcode field is empty, redirect to get shortcode button

                    editMediaSubmit = false;
                    $('#hap-edit-media-form-submit').click()
                    
                    return false;
                }

                var s1 = curr_sh.substr(0,curr_sh.indexOf('[/apmap]'))

                s += ' encrypt_media_paths="1"'

                s += ']'

                var final_s = s1 + s + '[/apmap]'


            }else if($(this).attr('id') == 'hap-edit-media-form-submit'){
                //join current audio and player shortcode

                s += ' encrypt_media_paths="1"'

                s += ']'

                //player options
                var quickPlayerShortcodeForm = $('#hap-quick-player-shortcode-form')
                var _playlistPosition

                var player_options = {};

                $.each(quickPlayerShortcodeForm.serializeArray(), function(i, field) {
                    player_options[field.name] = field.value;
                    if(field.name == 'playlistPosition')_playlistPosition = field.value
                });

                var player_options_s = ''
                //var query_s = ''//query string

                for (var [key, value] of Object.entries(player_options)) { 
                    //console.log(key, value)
                    var o = key.split(/(?=[A-Z])/).join('_').toLowerCase();//camelcase to underscore
                    player_options_s += ' '+o+'="'+value+'"';


                   // var o2 = key.split(/(?=[A-Z])/).join('-').toLowerCase();
                   // query_s += '&hap-'+o2+'='+value+'';
                }
                //if(_playlistPosition == 'wall')player_options_s += ' active_item="-1"'
               // console.log(query_s)

                var s1 = '[apmap' + player_options_s + ']',
                s3 = '[/apmap]'
                var final_s = s1 + s + s3

            }

            $('#hap-quick-audio-shortcode-ta').val(final_s).select()

            document.execCommand("copy");

            editMediaSubmit = false;

           $('#hap-quick-audio-shortcode-ta')[0].scrollIntoView({behavior: "smooth",block: 'center'});

        }

    });

    function removeMediaModal(){
        mediaModal.hide();  
        _body.removeClass('hap-modal-open');

        editMediaForm[0].reset();
        mediaModal.find('.hap-img-preview').attr('src', empty_src)
        type_selector.change();

        //remove tax
        mediaModal.find('#hap-media-category-wrap').empty()
        mediaModal.find('#hap-media-tag-wrap').empty()

        hap_pi_table_wrap.empty()

        mediaCategoryDialogList.find('input').prop('checked', false).attr('checked', false);
        mediaTagDialogList.find('input').prop('checked', false).attr('checked', false);

        additional_playlist_field.hide()

    }

    $('#hap-add-media').on('click',function(e){
        select_media_type_field.show()
        mediaSaveType = 'add_media'
        type_selector.change();
        showModal()
    });

    function showModal(){
        if(mediaSaveType == 'add_media'){

            additional_playlist_field.show()

            if(last_media_type){//save last used media
                type_selector.val(last_media_type).change()
            }

        }else{
            additional_playlist_field.hide()
        }

        mediaModal.show();
        modalBg.scrollTop(0);
        _body.addClass('hap-modal-open');
    }





    //song pi

    var hap_pi_table_wrap = $('#hap-pi-table-wrap').on('click', '.pi_remove', function(e){
        $(this).closest('.hap-pi-table').remove();

        if(hap_pi_table_wrap.children().length == 0){
            hap_pi_table_wrap.hide()
        }
    });

    hap_pi_table_wrap.on('change', '.pi-icon', function(){
        var v = $(this).val(),
        field = $(this).closest('.hap-pi-table').find('.pi-icon-custom-wrap'),
        unicode = field.find('.pi-icon-custom')
        
        if(v == ''){
            field.css('display','block')
            unicode.prop('required', true)
        }else{
            field.css('display','none')
            $(this).closest('.hap-pi-table').find('.pi-icon-value').val('')
            $(this).closest('.hap-pi').find('input').val('')
            unicode.val('').prop('required', false)
        }
    })

    hap_pi_table_wrap.on('blur', '.pi-icon-custom', function(){
        var v = $(this).val(),
        option = $(this).closest('.hap-pi-table').find('.pi-icon-value')

        if(v == ''){
            option.val('')
        }else{
            option.val(v)
        }
    })

    hap_pi_table_wrap.sortable();

    //add new pi

    $('#pi_add').on('click', function(e){
        addPi();
        hap_pi_table_wrap.show()
    });   

    function addPi(item){

        var bp = $('.hap-pi-table-orig').clone().removeClass('hap-pi-table-orig').addClass('hap-pi-table').show().appendTo(hap_pi_table_wrap);

        if(typeof item !== 'undefined'){

            bp.find('.pi-title').prop('required', true).val(item.title);
            bp.find('.pi-url').prop('required', true).val(item.url);
            bp.find('.pi-target').val(item.target).change();

            var select = bp.find('.pi-icon')
            if(select.find('option[value='+item.icon+']').length){//predefiend icons

                select.val(item.icon).change();

            }else{//user custom icon

                select.find('.pi-icon-value').val(item.icon);
                select.find('option[value="'+item.icon+'"]').attr("selected", "selected");

                bp.find('.pi-icon-custom').val(item.icon)//add icon to input
                bp.find('.pi-icon-custom-wrap').show()
            }

        }else{

            bp.find('.pi-title').prop('required', true)
            bp.find('.pi-url').prop('required', true)

        }

    }



    

    




    var select_media_type_field = mediaModal.find('#select_media_type_field'),
    path_field = mediaModal.find('#path_field'),
	path = mediaModal.find('#path'),
    folder_custom_url_field = mediaModal.find('#folder_custom_url_field'),
    folder_custom_url = mediaModal.find('#folder_custom_url'),
    audio_preview_field = mediaModal.find('#audio_preview_field'),
    audio_preview = mediaModal.find('#audio_preview'),
    peak_field = mediaModal.find('#peak_field'),
    peaks = mediaModal.find('#peaks'),
    file_upload = mediaModal.find('#file_upload'),
    title_field = mediaModal.find('#title_field'),
    title = mediaModal.find('#title'),
    artist_field = mediaModal.find('#artist_field'),
    artist = mediaModal.find('#artist'),
    album_field = mediaModal.find('#album_field'),
    album = mediaModal.find('#album'),
    duration_field = mediaModal.find('#duration_field'),
    duration = mediaModal.find('#duration'),
    description_field = mediaModal.find('#description_field'),
    description = mediaModal.find('#description'),
    description_is_html = mediaModal.find('#description_is_html'),
    thumb_field = mediaModal.find('#thumb_field'),
    thumb = mediaModal.find('#thumb'),
    thumb_small = mediaModal.find('#thumb_small'),
    thumb_alt_field = mediaModal.find('#thumb_alt_field'),
    thumb_alt = mediaModal.find('#thumb_alt'),
    alt = mediaModal.find('#alt'),
    thumb_upload = mediaModal.find('#thumb_upload'),
    thumb_default_field = mediaModal.find('#thumb_default_field'),
    thumb_default = mediaModal.find('#thumb_default'),
    thumb_default_upload = mediaModal.find('#thumb_default_upload'),
    download_field = mediaModal.find('#download_field'),
    download = mediaModal.find('#download'),
    download_upload = mediaModal.find('#download_upload'),
    link_field = mediaModal.find('#link_field'),
    link = mediaModal.find('#link'),
    target_field = mediaModal.find('#target_field'),
    target = mediaModal.find('#target'),
    limit_field = mediaModal.find('#limit_field'),
    limit = mediaModal.find('#limit'),
    id3_field = mediaModal.find('#id3_field'),
    id3 = mediaModal.find('#id3'),
    folder_sort_field = mediaModal.find('#folder_sort_field'),
    folder_sort = mediaModal.find('#folder_sort'),
    gdrive_sort_field = mediaModal.find('#gdrive_sort_field'),
    gdrive_sort = mediaModal.find('#gdrive_sort'),
    start_field = mediaModal.find('#start_field'),
    start = mediaModal.find('#start'),
    end_field = mediaModal.find('#end_field'),
    end = mediaModal.find('#end'),
    load_more_field = mediaModal.find('#load_more_field'),
    load_more = mediaModal.find('#load_more'),
    shoutcast_version_field = mediaModal.find('#shoutcast_version_field'),
    shoutcast_version = mediaModal.find('#shoutcast_version'),
    mountpoint_field = mediaModal.find('#mountpoint_field'),
    mountpoint = mediaModal.find('#mountpoint'),
    sid_field = mediaModal.find('#sid_field'),
    sid = mediaModal.find('#sid'),
    active_accordion_field = mediaModal.find('#active_accordion_field'),
    active_accordion = mediaModal.find('#active_accordion'),
    lyrics = $('#lyrics'),
    lyrics_field = $('#lyrics_field'),
    lyrics_upload = $('#lyrics_upload'),

    video_field = $('#video_field'),
    video = $('#video'),

    hls_info = mediaModal.find('#hls_info'),
    podcast_info = mediaModal.find('#podcast_info'),
    sc_info = mediaModal.find('#sc_info'),
    itunes_podcast_music_info = mediaModal.find('#itunes_podcast_music_info'),
    gdrive_info = mediaModal.find('#gdrive_info'),
    folder_info = mediaModal.find('#folder_info'),
    folder_accordion_info = mediaModal.find('#folder_accordion_info'),
    json_accordion_info = mediaModal.find('#json_accordion_info'),
    folder_backend_info = mediaModal.find('#folder_backend_info'),
    xml_info = mediaModal.find('#xml_info'),
    json_info = mediaModal.find('#json_info'),
    m3u_info = mediaModal.find('#m3u_info'),
    yt_video_info = mediaModal.find('#yt_video_info'),
    yt_playlist_info = mediaModal.find('#yt_playlist_info'),
    shoutcast_info = mediaModal.find('#shoutcast_info'),
    icecast_info = mediaModal.find('#icecast_info'),
    radiojar_info = mediaModal.find('#radiojar_info'),
    radio_info = mediaModal.find('#radio_info'),
    audio_info = mediaModal.find('#audio_info')


	var inited, 
    media_type,
    last_media_type,
    type_selector = $('#type').on('change',function(){

        media_type = $(this).val();

        //hide
        audio_preview_field.hide();
        peak_field.hide();
        path_field.hide();
        path.prop('required', false);
        folder_custom_url_field.hide();
        file_upload.hide();
        title_field.hide();
        artist_field.hide();
        album_field.hide();
        duration_field.hide();
        description_field.hide();
        thumb_field.hide();
        thumb_alt_field.hide();
        thumb_default_field.hide();
        download_field.hide();
        link_field.hide();
        target_field.hide();
        limit_field.hide();
        id3_field.hide();
        folder_sort_field.hide();
        gdrive_sort_field.hide();
        start_field.hide();
	    end_field.hide();
        load_more_field.hide();
        shoutcast_version_field.hide();
        mountpoint_field.hide();
        sid_field.hide();

        //info
        hls_info.hide();
        podcast_info.hide();
        sc_info.hide();
        itunes_podcast_music_info.hide();
        gdrive_info.hide();
        folder_info.hide();
        folder_accordion_info.hide();
        json_accordion_info.hide();
        active_accordion_field.hide();
        folder_backend_info.hide();
        xml_info.hide();
        json_info.hide();
        m3u_info.hide();
        yt_video_info.hide();
        yt_playlist_info.hide();
        shoutcast_info.hide();
        icecast_info.hide();
        radiojar_info.hide();
        audio_info.hide();
        radio_info.hide();



        if(editMediaForm.length)editMediaForm[0].reset();
        $(this).val(media_type);//reset on type change so we dont get not used vars for different media in db table

        if(media_type == 'hls'){

            audio_preview_field.show();
        	path_field.show();
            path.prop('required', true);
            file_upload.show();
            thumb_default_field.show();

	        title_field.show();
	        artist_field.show();
            album_field.show();
            description_field.show();
	        thumb_field.show();
            thumb_alt_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            duration_field.show();

            hls_info.show();

	    }else if(media_type == 'audio'){

            path_field.show();
            path.prop('required', true);
            file_upload.show();

            audio_info.show();

            audio_preview_field.show();
            peak_field.show();
	        title_field.show();
	        artist_field.show();
            album_field.show();
            description_field.show();
	        thumb_field.show();
            thumb_alt_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();
            duration_field.show();

	    }else if(media_type == 'soundcloud'){
	        
            path_field.show();
            path.prop('required', true);
	        limit_field.show();
	        thumb_default_field.show();
            load_more_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();

	        sc_info.show();

	    }else if(media_type == 'podcast'){
	        
            path_field.show();
            path.prop('required', true);
	        limit_field.show();
	        thumb_default_field.show();
            load_more_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();

	        podcast_info.show();

	    }else if(media_type == 'itunes_podcast_music'){
	        
            path_field.show();
            path.prop('required', true);
	        limit_field.show();
	        thumb_default_field.show();

	        itunes_podcast_music_info.show();

	    }else if(media_type == 'folder'){

            path_field.show();
            path.prop('required', true);
            folder_custom_url_field.show();
	        id3_field.show();
	        folder_sort_field.show();
            limit_field.show(); 
            load_more_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();

	        folder_info.show();

        }else if(media_type == 'folder_backend'){

            path_field.show();
            path.prop('required', true);
            folder_custom_url_field.show();
            id3_field.show();
            folder_sort_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();
            
            folder_backend_info.show();

            additional_playlist_field.hide()

        }else if(media_type == 'folder_accordion'){

            path_field.show();
            path.prop('required', true);
            folder_custom_url_field.show();
            id3_field.show();
            folder_sort_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();

            folder_accordion_info.show();
            active_accordion_field.show();

        }else if(media_type == 'json_accordion'){

            path_field.show();
            path.prop('required', true);
            file_upload.show();
            id3_field.show();
            folder_sort_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();

            json_accordion_info.show();
            active_accordion_field.show();

	    }else if(media_type == 'gdrive_folder'){

            path_field.show();
            path.prop('required', true);
	        gdrive_info.show();
            gdrive_sort_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();

	    }else if(media_type == 'xml'){

            path_field.show();
            path.prop('required', true);
	        file_upload.show();

	        xml_info.show();

        }else if(media_type == 'json'){

            path_field.show();
            path.prop('required', true);
            file_upload.show();

            json_info.show();

        }else if(media_type == 'm3u'){

            path_field.show();
            path.prop('required', true);
            file_upload.show();
            thumb_default_field.show();

            m3u_info.show();    

	    }else if(media_type == 'youtube_single'){

            path_field.show();
            path.prop('required', true);
            thumb_default_field.show();
            title_field.show();
            artist_field.show();
            album_field.show();
            description_field.show();
            thumb_field.show();
            thumb_alt_field.show();
            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();

            yt_video_info.show();

        }else if(media_type == 'youtube_playlist'){

            path_field.show();
            path.prop('required', true);
            limit_field.show();
            thumb_default_field.show();
            load_more_field.show();

            link_field.show();
            target_field.show();
            download_field.show();
            start_field.show();
            end_field.show();

            yt_playlist_info.show();
            
        }else if(media_type == 'shoutcast'){

            path_field.show();
            path.prop('required', true);
            shoutcast_version_field.show();
            sid_field.show();

            title_field.show();
            description_field.show();
            thumb_field.show();
            thumb_alt_field.show();
            link_field.show();
            target_field.show();
            download_field.show();

            shoutcast_info.show();
            radio_info.show();
            
        }else if(media_type == 'icecast'){

            path_field.show();
            path.prop('required', true);
            mountpoint_field.show();

            title_field.show();
            description_field.show();
            thumb_field.show();
            thumb_alt_field.show();
            link_field.show();
            target_field.show();
            download_field.show();

            icecast_info.show();
            radio_info.show();
            
        }else if(media_type == 'radiojar'){

            path_field.show();
            path.prop('required', true);
            mountpoint_field.show();

            title_field.show();
            description_field.show();
            thumb_field.show();
            thumb_alt_field.show();
            link_field.show();
            target_field.show();
            download_field.show();

            radiojar_info.show();
            radio_info.show();
            
        }

	    inited = true;

    });

    if(type_selector.attr('data-selected')) type_selector.val(type_selector.attr('data-selected'));


    function inputMediaFields(method, response){

        var data = response.data, tax_data = response.tax;
       //console.log(data)
        type_selector.val(data.type);
        type_selector.change()

        if(method == 'add')select_media_type_field.show();
        else select_media_type_field.hide();

        if(data.active_accordion)active_accordion.val(data.active_accordion)

        if(data.audio_preview)audio_preview.val(data.audio_preview);
        if(data.peaks)peaks.val(data.peaks);
        if(data.path)path.val(data.path);
        if(data.folder_custom_url == '1')folder_custom_url.prop('checked', true)
        if(data.title)title.val(data.title);
        if(data.artist)artist.val(data.artist);
        if(data.album)album.val(data.album);
        if(data.duration)duration.val(data.duration);
        if(data.description)description.val(data.description);
        description_is_html.prop('checked', data.description_is_html == '1' ? true : false)
        if(data.thumb){
            thumb.val(data.thumb);
            thumb_preview.attr('src',data.thumb);
        }
        if(data.thumb_small)thumb_small.val(data.thumb_small);
        if(data.alt)thumb_alt.val(data.alt);
        if(data.thumb_default){
            thumb_default.val(data.thumb_default);
            thumb_default_preview.val(data.thumb_default);
        }
        if(data.download)download.val(data.download);
        if(data.link){
            link.val(data.link);
            target.val(data.target);
        }
        if(data.pi_icons){
            var i, len = data.pi_icons.length;
            for(i=0;i<len;i++){
                addPi(data.pi_icons[i]);
            }
            hap_pi_table_wrap.show()
        }
        if(data.limit)limit.val(data.limit);
        if(data.id3 == '1')id3.prop('checked', true)
        if(data.folder_sort)folder_sort.val(data.folder_sort);
        if(data.gdrive_sort)gdrive_sort.val(data.gdrive_sort);
        if(data.start)start.val(data.start);
        if(data.end)end.val(data.end);
        if(data.load_more == '1')load_more.prop('checked', true)
        if(data.shoutcast_version)shoutcast_version.val(data.shoutcast_version);
        if(data.mountpoint)mountpoint.val(data.mountpoint);
        if(data.sid)sid.val(data.sid);
        if(data.lyrics)lyrics.val(data.lyrics);
        if(data.video)video.val(data.video);


        //tax

        if(tax_data){

            var i, len = tax_data.length, tax;
            for(i=0;i<len;i++){

                tax = tax_data[i];

                if(tax.type == 'category'){
                    mediaCategoryDialogList.find('.media-category[value="'+tax.id+'"]').prop('checked', true).attr('checked', true);

                    addCategory(tax, mediaCategoryWrap);

                }else if(tax.type == 'tag'){

                    mediaTagDialogList.find('.media-tag[value="'+tax.id+'"]').prop('checked', true).attr('checked', true);

                    addTag(tax, mediaTagWrap);
                }

            }
        }

    }



    //shortcode manager get audio shortcode

    var get_audio_shortcode_submit = $('.hap-get-audio-shortcode-submit')
    if(get_audio_shortcode_submit.length){
        type_selector.change();  
    }









    //edit media

    mediaTable.on('click', '.hap-edit-media', function(){
        var media_id = $(this).closest('.media-item').attr('data-media-id'),
        order_id = $(this).closest('.media-item').attr('data-order-id')

        preloader.show();

        var postData = [
            {name: 'action', value: 'hap_edit_media'},
            {name: 'media_id', value: media_id},
            {name: 'security', value: hap_data.security}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){
            console.log(response)

            preloader.hide();
           
            inputMediaFields('edit', response)

            mediaSaveType = 'edit_media'
            mediaSaveId = media_id

            showModal()

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
        });  

        return false;

    })

    mediaTable.on('click', '.hap-delete-media', function(){
        
        var result = confirm("Are you sure to delete?");
        if(result){

            var media_id = $(this).closest('.media-item').attr('data-media-id')

            preloader.show();

            var arr = [media_id]
            deleteMedia(arr)

        }

        return false;

    })

    function deleteMedia(arr){

        var postData = [
            {name: 'action', value: 'hap_delete_media'},
            {name: 'media_id', value: arr},
            {name: 'security', value: hap_data.security}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){

            preloader.hide();

            //console.log(response)
            if(response > 0){
                var i, len = arr.length
                for(i = 0; i< len;i++){
                    mediaItemList.find('.media-item[data-media-id='+arr[i]+']').remove();
                }
                $('.hap-media-all').prop('checked', false);
            }

            updatePagination()

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
        });  

    }











    



    
    //############################################//
    /* export / import */
    //############################################//

    var jquery_csv_js = 'https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/1.0.5/jquery.csv.min.js';

   
	//export playlist

    $('.hap-table').on('click','.hap-export-playlist-btn', function(e){

        preloader.show();

        var playlist_id = $(this).attr('data-playlist-id'),
        playlist_title = $(this).closest('.hap-playlist-row').find('.title-editable').val();

        playlist_title = playlist_title.replace(/\W/g, '');//safe chars

        var postData = [
            {name: 'action', value: 'hap_export_playlist'},
            {name: 'playlist_id', value: playlist_id},
            {name: 'playlist_title', value: playlist_title},
            {name: 'security', value: hap_data.security}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',
        }).done(function(response){

            preloader.hide();

            if(response.zip) {

                location.href = response.zip;

                var postData = [
                    {name: 'action', value: 'hap_clean_export'},
                    {name: 'zipname', value: response.zip},
                    {name: 'security', value: hap_data.security}
                ];

                $.ajax({
                    url: hap_data.ajax_url,
                    type: 'post',
                    data: postData,
                }); 

            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
        }); 

        return false;

    });

    //import playlist

    var playlistfileInput = $('#hap-playlist-file-input').on('change', preparePlaylistUpload);

    var import_playlist_btn = $('#hap-import-playlist').click(function(){
        playlistfileInput.trigger('click'); 
        return false;
    }); 

    var importPlaylistData;

    function preparePlaylistUpload(event) { 

        //check if correct file uploaded
        if(event.target.files.length == 0) return;
        var fileName = event.target.files[0].name;
        if(fileName.indexOf('hap_playlist_id_') == -1){
            alert("Make sure you upload previously exported playlist zip file starting with hap_playlist_id_ !");
            return;
        }

        preloader.show();

        import_playlist_btn.css('display','none');

        var file = event.target.files;
        var data = new FormData();
        var nonce = $('#hap-import-playlist-form').find("#_wpnonce").val();
        $.each(file, function(key, value){
            data.append("hap_file_upload", value);
        });
        data.append("action", "hap_import_playlist");
        data.append("security", hap_data.security );

        playlistfileInput.val('');

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: data,
            dataType: 'json',
            processData: false, 
            contentType: false, 
        }).done(function(response){
            console.log(response)

            if(response.playlist){

                importPlaylistData = {};

                importPlaylistData.playlist = {data:null, url:response.playlist};
                if(response.playlist_taxonomy)importPlaylistData.playlist_taxonomy = {data:null, url:response.playlist_taxonomy};
                if(response.media)importPlaylistData.media = {data:null, url:response.media};
                if(response.media_taxonomy)importPlaylistData.media_taxonomy = {data:null, url:response.media_taxonomy};

                getCSVPlaylist(importPlaylistData.playlist.url);

            }else{
                import_playlist_btn.css('display','inline-block');
                preloader.hide();

                alert("Error importing!");
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            import_playlist_btn.css('display','inline-block');
            preloader.hide();

            alert("Error importing!");
        }); 

    }

    function getCSVPlaylist(url){

        if(typeof $.csv === 'undefined'){

            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = jquery_csv_js;
            script.onload = script.onreadystatechange = function() {
                if(!this.readyState || this.readyState == 'complete'){
                    getCSVPlaylist(url);
                }
            };
            script.onerror = function(){
                alert("Error loading " + this.src);
            }
            var tag = document.getElementsByTagName('script')[0];
            tag.parentNode.insertBefore(script, tag);

        }else{

            $.ajax({
                type: 'GET',
                url: url,
                dataType: "text"
            }).done(function(response) {

                if(importPlaylistData.playlist.data == null){

                    var d = $.csv.toArray(response, {separator:'|', delimiter:'^'}, function(err, data){
                        importPlaylistData.playlist.data = data;
                        if(importPlaylistData.playlist_taxonomy)getCSVPlaylist(importPlaylistData.playlist_taxonomy.url);
                        else if(importPlaylistData.media)getCSVPlaylist(importPlaylistData.media.url);
                        else import_playlist_db();//no media in playlist
                    });

                }else if(importPlaylistData.playlist_taxonomy.data == null){

                    var d = $.csv.toArrays(response, {separator:'|', delimiter:'^'}, function(err, data){
                        importPlaylistData.playlist_taxonomy.data = data;
                        if(importPlaylistData.media)getCSVPlaylist(importPlaylistData.media.url);
                        else import_playlist_db();
                    }); 

                }else if(importPlaylistData.media.data == null){

                    var d = $.csv.toArrays(response, {separator:'|', delimiter:'^'}, function(err, data){
                        importPlaylistData.media.data = data;
                        if(importPlaylistData.media_taxonomy)getCSVPlaylist(importPlaylistData.media_taxonomy.url);
                        else import_playlist_db();
                    });    

                }else if(importPlaylistData.media_taxonomy.data == null){

                    var d = $.csv.toArrays(response, {separator:'|', delimiter:'^'}, function(err, data){
                        importPlaylistData.media_taxonomy.data = data;
                        import_playlist_db();
                    });    

                }
                  
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log('Error process CSV: ' + jqXHR, textStatus, errorThrown);
                preloader.hide();
                import_playlist_btn.css('display','inline-block');
                alert("Error importing!");
                
            });

        }
    }

    function import_playlist_db(){

        var postData = [
            {name: 'action', value: 'hap_import_playlist_db'},
            {name: 'playlist', value: JSON.stringify(importPlaylistData.playlist.data)},
            {name: 'security', value: hap_data.security}
        ];
        if(importPlaylistData.playlist_taxonomy)postData.push({name: 'playlist_taxonomy', value: JSON.stringify(importPlaylistData.playlist_taxonomy.data)});
        if(importPlaylistData.media)postData.push({name: 'media', value: JSON.stringify(importPlaylistData.media.data)});
        if(importPlaylistData.media_taxonomy)postData.push({name: 'media_taxonomy', value: JSON.stringify(importPlaylistData.media_taxonomy.data)});

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',
        }).done(function(response){

            console.log(response)

            if(response){
                if(response == 'SUCCESS')window.location.reload(false); 
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
            import_playlist_btn.css('display','inline-block');
            alert("Error importing!");
        }); 

    } 



    

    //############################################//
    /* duplicate */
    //############################################//

  
    $('.hap-duplicate-playlist').on('click', function(){
        return duplicatePlaylist('Enter title for new playlist:', $(this));
    });

    function duplicatePlaylist(msg, target){
        var title = prompt(msg);

        if(title == null){//cancel
            return false;
        }else if(title.replace(/^\s+|\s+$/g, '').length == 0) {//empty
            duplicatePlaylist(msg, target);
            return false;
        }else{

            preloader.show()
            
            var postData = [
                {name: 'action', value: 'hap_duplicate_playlist'},
                {name: 'security', value: hap_data.security},
                {name: 'title', value: title},
                {name: 'playlist_id', value: target.closest('.hap-playlist-row').attr('data-playlist-id')},
            ];

            $.ajax({
                url: hap_data.ajax_url,
                type: 'post',
                data: postData,
                dataType: 'json',   
            }).done(function(response){

                //go to edit playlist page
                window.location = playlistItemList.attr('data-admin-url') + '?page=hap_playlist_manager&action=edit_playlist&hap_msg=playlist_created&playlist_id=' + response

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText, textStatus, errorThrown);
            });

            return false;

        }
    }



    //############################################//
    /* helpers */
    //############################################//

    function isEmpty(str){
        return str.replace(/^\s+|\s+$/g, '').length == 0;
    }

    function sortNumber(a,b) {
        return a - b;
    }

    function keysrt(arr, key, reverse) {
        var sortOrder = 1;
        if(reverse)sortOrder = -1;
        return arr.sort(function(a, b) {
            var x = a[key]; var y = b[key];
            return sortOrder * ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    function hmsToSecondsOnly(str) {
        var p = str.split(':'),
            s = 0, m = 1;

        while (p.length > 0) {
            s += m * parseInt(p.pop(), 10);
            m *= 60;
        }

        return s;
    }

    function selectText(element){
        if (document.body.createTextRange) {
            var range = document.body.createTextRange();
            range.moveToElementText(element);
            range.select();
        } else if (window.getSelection) {
            var selection = window.getSelection();        
            var range = document.createRange();
            range.selectNodeContents(element);
            selection.removeAllRanges();
            selection.addRange(range);
        }
    }

    function keysrtStr(arr, selector, reverse) {
        var sortOrder = 1;
        if(reverse)sortOrder = -1;
        return arr.sort(function(a, b) {
            var x = a.find(selector).html(); var y = b.find(selector).html();
            return sortOrder * ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    function keysrtNum(arr, selector, reverse) {
        var sortOrder = 1;
        if(reverse)sortOrder = -1;
        return arr.sort(function(a, b) {
            var x = parseInt(a.find(selector).html(),10); var y =  parseInt(b.find(selector).html(),10);
            return sortOrder * ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }















   


});