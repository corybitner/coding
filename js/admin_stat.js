jQuery(document).ready(function($) {

    "use strict"

    var preloader = $('#hap-loader').show(),
    _body = $('body'),
    _doc = $(document),
    statWrap = $('#hap-stat-wrap'),
    mediaItemList = $('#media-item-list'),
    statTableHeader = $('.stat-table-header')





    

    var windowResizeTimeoutID,
    windowResizeTimeout = 500
    $(window).on('resize',function() {
        if(windowResizeTimeoutID) clearTimeout(windowResizeTimeoutID);
        windowResizeTimeoutID = setTimeout(function(){

            mediaItemList.find('.hap-stat-chart-wrapper').each(function(){
                $(this).width(statWrap.width()-5)
            })

        }, windowResizeTimeout);
    });


    //stat playlist

    var statsPlaylistList = $('#hap-stats-playlist-list'),
    statsSelectorPlaylist = $('#hap-stats-selector-playlist')

    var selectedPlaylistId
    statsPlaylistList.selectize({
        onInitialize: function() {
            this.trigger('change', this.getValue(), true);
        },
        onChange: function(value, isOnInitialize) {
            console.log('Selectize playlist changed: ' + value);
            
            if(value){
                selectedPlaylistId = value;
                loadStats( 'playlist', value)
            }
            
        }
    });
   


    //stat player

    var statsPlayerList = $('#hap-stats-player-list'),
    statsSelectorPlayer = $('#hap-stats-selector-player')

    var selectedPlayerId
    statsPlayerList.selectize({
        onChange: function(value, isOnInitialize) {
            console.log('Selectize player changed: ' + value);
            
            if(value){
                selectedPlayerId = value;
                loadStats( 'player', value)
            }

        }
    }).change();


    //select stat source
    var statSource = 'playlist'

    $('input[type=radio][name=hap-stat-type]').change(function() {
        if (this.value == 'playlist') {
            statsSelectorPlaylist.show()
            statsSelectorPlayer.hide()
            statSource = 'playlist';
        }
        else if (this.value == 'player') {
            statsSelectorPlaylist.hide()
            statsSelectorPlayer.show()
            statSource = 'player';
        }
    });









    //range

    var range_picker = $('#hap-daterange').daterangepicker({
        opens: 'left',
        //alwaysShowCalendars: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    }, function(start, end, label) {
        console.log(start, end, start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    
  



    function loadStats(type, pid){
        console.log('loadStats' + type)

        preloader.show()

        var postData = [
            {name: 'action', value: 'hap_get_stat_data'},
            {name: 'type', value: type},
            {name: 'type_id', value: pid},
            {name: 'security', value: hap_data.security}
        ];
        console.log(postData)

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',
        }).done(function(r){

            console.log(r)

            var response = r.results

            var mi = $('.media-item-container-hidden')

            mediaItemList.find('.hap-stat-row:not(.media-item-container-hidden)').remove()//clear current

            var i, len = response.length, obj, media_item;
            for(i = 0; i <len; i++){

                obj = response[i]

                media_item = mi.clone().removeClass('media-item-container-hidden')
                .attr('data-media-id', obj.media_id)
                media_item.find('.media-title').html(obj.title)
                media_item.find('.media-artist').html(obj.artist)
                media_item.find('.media-album').html(obj.album)
                media_item.find('.media-duration').html(obj.total_time)
                media_item.find('.media-time').html(convertTime(obj.total_time))
                media_item.find('.media-play').html(convertCount(obj.total_play))
                media_item.find('.media-download').html(convertCount(obj.total_download))
                media_item.find('.media-like').html(convertCount(obj.total_like))
                media_item.find('.media-finish').html(convertCount(obj.total_finish))

                media_item.appendTo(mediaItemList)

            }

            statTableHeader.find('.hap-sort-field[data-type="title"]').attr('data-asc', 'true')
            setSortIndicator('title', true)




            //summary 

            $('.hap-stats-total-time').html(convertTime(r.total.c_time))
            $('.hap-stats-total-play').html(convertCount(r.total.c_play))
            $('.hap-stats-total-download').html(convertCount(r.total.c_download))
            $('.hap-stats-total-like').html(convertCount(r.total.c_like))
            $('.hap-stats-total-finish').html(convertCount(r.total.c_finish))

            //top

            getBox(r.top_day, $('.hap-box-top-play-day'))

            getBox(r.top_week, $('.hap-box-top-play-week'))

            getBox(r.top_month, $('.hap-box-top-play-month'))

            getBox(r.top_plays, $('.hap-box-top-play-all-time'))

            getBox(r.top_downloads, $('.hap-box-top-download-all-time'))

            getBox(r.top_likes, $('.hap-box-top-like-all-time'))

            getBox(r.top_finish, $('.hap-box-top-finish-all-time'))

            getBox(r.top_skipped_first_minute, $('.hap-box-top-skip-first-min-all-time'))

            getBox2(r.top_plays_country, $('.hap-box-top-plays-country-all-time'))

            getBox3(r.top_plays_user, $('.hap-box-top-plays-user-all-time'))



            preloader.hide()

            initPagination()

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
            
        });

    }


    function getBox(arr, box){

        box.find('.hap-top-stat-list').remove()//clear current
        
        if(arr.length){

            var ids = []
            var s = '<ol class="hap-top-stat-list">'

            var i, len = arr.length, obj;
            for(i = 0; i <len; i++){

                obj = arr[i]

                if(obj.media_id != undefined && ids.indexOf(obj.media_id) == -1) ids.push(obj.media_id);
       
                s += '<li>'

                if(obj.title && obj.artist){
                    s += '<b>' + obj.artist + '</b>' + ' - ' + obj.title
                }else if(obj.title){
                    s += '<b>' + obj.title + '</b>'
                }else if(obj.artist){
                    s += '<b>' + obj.artist + '</b>'
                }

                s += '<span class="hap-stat-info"> ('+obj.total_count+')</span></li>';

            }
                   
            s += '</ol>';

            box.find('.top-box-content').append(s)//add new

            var top_id = ids.join('_');

            box.find('.hap-stat-no-data').addClass('hap-stat-hidden')   
            box.find('.hap-create-playlist-from-stat').removeClass('hap-stat-hidden').attr('data-media-id', top_id) 

        }else{
            box.find('.hap-stat-no-data').removeClass('hap-stat-hidden')   
            box.find('.hap-create-playlist-from-stat').addClass('hap-stat-hidden').removeAttr('data-media-id')  
        }

    }

    function getBox2(arr, box){

        box.find('.hap-top-stat-list').remove()//clear current
        
        if(arr.length){

            var i, len = arr.length, obj, s = '';
            for(i = 0; i <len; i++){

                obj = arr[i]

                s += '<tr class="hap-top-stat-list">'+

                    '<td>'+obj.country+' ('+obj.country_code+')</td>'+
                    '<td>'+ obj.continent +'</td>'+
                    '<td>'+obj.total_count+'</td>'+
                    '<td>'+convertTime(obj.c_time)+'</td>'+
      
                '</tr>'

            }

            box.find('.hap-stat-no-data').addClass('hap-stat-hidden')   
            box.find('.inline-stat-table').removeClass('inline-stat-table-hidden').find('tbody').html(s)

        }else{
            box.find('.hap-stat-no-data').removeClass('hap-stat-hidden')   
        }

    }

    function getBox3(arr, box){

        box.find('.hap-top-stat-list').remove()//clear current
        
        if(arr.length){
            
            var i, len = arr.length, obj, s = '';
            for(i = 0; i <len; i++){

                obj = arr[i]

                s += '<tr class="hap-top-stat-list">'+

                    '<td>'+obj.user_display_name+'</td>'+
                    '<td>'+ obj.user_role +'</td>'+
                    '<td>'+obj.total_count+'</td>'+
                    '<td>'+convertTime(obj.c_time)+'</td>'+
      
                '</tr>'

            }

            box.find('.hap-stat-no-data').addClass('hap-stat-hidden')   
            box.find('.inline-stat-table').removeClass('inline-stat-table-hidden').find('tbody').html(s)

        }else{
            box.find('.hap-stat-no-data').removeClass('hap-stat-hidden')   
        }
    }














    
    //pagination

    var paginationPerPageNum = $('#hap-pag-per-page-num')

    if(localStorage && localStorage.getItem('hap_stat_media_paginaton_per_page')){
        paginationPerPageNum.val(localStorage.getItem('hap_stat_media_paginaton_per_page'))
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

    function initPagination(){

        paginationArr = []

        var i = 0;
        mediaItemList.find('.media-item').each(function(){
            paginationArr.push($(this).attr('data-id', i))
            i++;
        })

        paginationTotalPages = Math.ceil(paginationArr.length / paginationPerPage)

        if(paginationTotalPages > 1)createPaginationBtn(paginationCurrentPage);

        if(paginationArr.length)showPaginationTracks()//show tracks on start

    }

    

    //adjust per page
    $('#hap-pag-per-page-btn').on('click', function(){

        if(isEmpty(paginationPerPageNum.val())){
            paginationPerPageNum.focus()
            alert("Enter number!")
            return false;
        }

        paginationPerPage = parseInt(paginationPerPageNum.val(),10)

        //save
        if(localStorage)localStorage.setItem('hap_stat_media_paginaton_per_page', paginationPerPage);

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



    //sort media

    statTableHeader.find('.hap-sort-field').on('click', function(e){

        e.preventDefault()

        var btn = $(this),
        asc = btn.attr('data-asc') == 'true',
        items = mediaItemList.find('.media-item'), len = items.length,
        type = btn.attr('data-type')

        if(type == 'title' || type == 'artist')keysrtStr(paginationArr, '.media-'+type, asc);
        else keysrtNum(paginationArr, '.media-'+type, asc);

        asc = !asc
        btn.attr('data-asc', asc)

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

        //place graphs below rows
        mediaItemList.find('.hap-stat-graph-holder-row').each(function(){
            var graph = $(this),
            id = graph.attr('data-parent-id'),
            parent = mediaItemList.find('.hap-stat-row[data-parent-id="'+id+'"]')

            parent.after(graph)   
        })


        setSortIndicator(type, asc)

    })

    function setSortIndicator(type, dir){

        statTableHeader.find('.hap-triangle-dir-wrap, .hap-triangle-dir').hide()//hide all

        if(dir == true){
            statTableHeader.find('.hap-sort-field[data-type="'+type+'"]').find('.hap-triangle-dir-wrap').show().find('.hap-triangle-dir-down').show()
        }else{
            statTableHeader.find('.hap-sort-field[data-type="'+type+'"]').find('.hap-triangle-dir-wrap').show().find('.hap-triangle-dir-up').show()
        }

    }

    
   
   


    //search songs

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

    








    //create graph

    var creatingGraph, graphOptions = $('#hap-stat-graph-options');

    //toggle graph options

    $('#graph-options-btn').on('click', function(){
        graphOptions.toggle();
    });

    //create graph

    $(document).on('click', '.hap-stat-create-graph', function(e){
        e.preventDefault();

        if(creatingGraph)return false;
        creatingGraph = true;

        preloader.show();

        var parent_id = Math.floor(Math.random() * 999999999);  

        var createGraphBtn = $(this),
        row = createGraphBtn.closest('.hap-stat-row');

        row.attr('data-parent-id', parent_id)

        //get graph data

        var graphType = graphOptions.find('.graph-type:checked').val(),
        displayType = graphOptions.find('.display-type:checked').val()

        var dataDisplay = graphOptions.find('.graph-data-display:checked').map(function() {
            return this.value;
        }).get();
        
        if(dataDisplay.length == 0){
            preloader.hide();
            creatingGraph = false;
            return false;
        }

        var title = row.find('.media-title').html(),
        artist = row.find('.media-artist').html(),
        song_info = "Song: "

        if(title && artist){
            song_info += artist + ' - ' + title
        }else if(title){
            song_info += title 
        }else if(artist){
            song_info += artist
        }

        if(song_info.album) song_info += ' , Album: ' + song_info.album

        var start = range_picker.data('daterangepicker').startDate.format('YYYY-MM-DD'); 
        var end = range_picker.data('daterangepicker').endDate.format('YYYY-MM-DD'); 

       // var start = '2020-03-13';
        //var end = '2020-12-21';

        var date1 = new Date(start);
        var date2 = new Date(end);
        var diffTime = Math.abs(date2 - date1);
        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        //console.log(diffDays + " days");
        //if diff > 30 apply custom width

        var postData = [
            {name: 'action', value: 'hap_stat_create_graph'},
            {name: 'playlist_id', value: selectedPlaylistId},
            {name: 'media_id', value: row.attr('data-media-id')},
            {name: 'title', value: title},
            {name: 'artist', value: artist},
            {name: 'data_display', value: JSON.stringify(dataDisplay)},
            {name: 'start', value: start},
            {name: 'end', value: end},
            {name: 'display_type', value: displayType},
            {name: 'security', value: hap_data.security}
        ];

        console.log(postData)

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',
        }).done(function(response){

            //console.log(response)

            //return

            var date_options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            var dates = [], play_data = [], download_data = [], finish_data = [], like_data = [];

            //we need to compare dates because song statistics does not contain dates for days that song doesnt play 


            //monthly

            if(displayType == 'monthly'){
            
                var months = getMonths(start,end);
                //console.log(months)
     
                var i, d1, _d, d2, len = months.length, song

                for (i = 0; i < len; i++) {
                  
                    d1 = months[i]

                    if(response.length){

                        song = response[0];

                        _d = new Date(song.c_date)

                        d2 = monthNameList[_d.getMonth()] + " " + _d.getFullYear();

                        if(d1 == d2){//date match

                            //console.log('date match')

                            if(dataDisplay.indexOf('c_play')>-1)play_data.push(song.c_play);
                            if(dataDisplay.indexOf('c_download')>-1)download_data.push(song.c_download);
                            if(dataDisplay.indexOf('c_finish')>-1)finish_data.push(song.c_finish);
                            if(dataDisplay.indexOf('c_like')>-1)like_data.push(song.c_like);
                            response.shift();
                        }else{
                            if(dataDisplay.indexOf('c_play')>-1)play_data.push(0);
                            if(dataDisplay.indexOf('c_download')>-1)download_data.push(0);
                            if(dataDisplay.indexOf('c_finish')>-1)finish_data.push(0);
                            if(dataDisplay.indexOf('c_like')>-1)like_data.push(0);
                        }
                    }else{
                        if(dataDisplay.indexOf('c_play')>-1)play_data.push(0);
                        if(dataDisplay.indexOf('c_download')>-1)download_data.push(0);
                        if(dataDisplay.indexOf('c_finish')>-1)finish_data.push(0);
                        if(dataDisplay.indexOf('c_like')>-1)like_data.push(0);
                    }

                    dates.push(d1);

                }

            }else{

                var i, d1, d2, song,
                from = new Date(start),
                to = new Date(end)

                for (i = from; i <= to; i.setDate(i.getDate() + 1)) {
                  
                    d1 = new Date(i)

                    //console.log(d1)

                    if(response.length){

                        song = response[0];
                        d2 = song.c_date;

                        //console.log(formatDate(d1),d2)

                        if(formatDate(d1) == d2){//date match

                           // console.log('date match')

                            if(dataDisplay.indexOf('c_play')>-1)play_data.push(song.c_play);
                            if(dataDisplay.indexOf('c_download')>-1)download_data.push(song.c_download);
                            if(dataDisplay.indexOf('c_finish')>-1)finish_data.push(song.c_finish);
                            if(dataDisplay.indexOf('c_like')>-1)like_data.push(song.c_like);
                            response.shift();
                        }else{
                            if(dataDisplay.indexOf('c_play')>-1)play_data.push(0);
                            if(dataDisplay.indexOf('c_download')>-1)download_data.push(0);
                            if(dataDisplay.indexOf('c_finish')>-1)finish_data.push(0);
                            if(dataDisplay.indexOf('c_like')>-1)like_data.push(0);
                        }
                    }else{
                        if(dataDisplay.indexOf('c_play')>-1)play_data.push(0);
                        if(dataDisplay.indexOf('c_download')>-1)download_data.push(0);
                        if(dataDisplay.indexOf('c_finish')>-1)finish_data.push(0);
                        if(dataDisplay.indexOf('c_like')>-1)like_data.push(0);
                    }

                    dates.push(d1.toLocaleDateString("en-US", date_options));

                }

            }

        
            var datasets = [];
            if(dataDisplay.indexOf('c_play')>-1)datasets.push({
                label: 'Plays',
                data: play_data,
                backgroundColor: "#00BFFF"
            });
            if(dataDisplay.indexOf('c_like')>-1)datasets.push({     
                label: 'Likes',
                data: like_data,
                backgroundColor: "#FF6347"
            });
            if(dataDisplay.indexOf('c_download')>-1)datasets.push({     
                label: 'Downloads',
                data: download_data,
                backgroundColor: "#DA70D6"
            });
            if(dataDisplay.indexOf('c_finish')>-1)datasets.push({     
                label: 'Finishes',
                data: finish_data,
                backgroundColor: "#59ab5f"
            });

            var w = statWrap.width()-5

            var dw = dates.length * 50
            //if(dw > w) dw = w;
              
            

            //add graph in next row after song
            /*var graph_holder = $('<tr class="hap-stat-graph-holder-row" data-parent-id="'+parent_id+'">'+
                '<td class="hap-stat-graph-holder" colspan="9">'+
                '<span class="hap-stat-song-info">'+song_info+'</span>'+
                '<canvas class="hap-stat-graph-canvas"></canvas>'+
                '<button class="hap-print-chart-btn">Print Chart</button>'+
                '</td></tr>');
            */

            var graph_holder = $('<tr class="hap-stat-graph-holder-row" data-parent-id="'+parent_id+'">'+
                '<td class="hap-stat-graph-holder" colspan="9">'+
                '<p class="hap-stat-song-info">'+song_info+'</p>'+
                '<div class="hap-stat-chart-wrapper" style="width:'+w+'px">'+
                    '<div style="width: 100%; overflow-x: auto;">'+
                        '<div style="width:'+dw+'px; height: 500px">'+
                            '<canvas class="hap-stat-graph-canvas" width="0" height="500"></canvas>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<button class="hap-print-chart-btn">Print Chart</button>'+
                '</td></tr>');

            row.data('graphHolderRow',graph_holder).after(graph_holder);

            //create chart
            var canvas = graph_holder.find($('.hap-stat-graph-canvas'))[0],
            ctx = canvas.getContext('2d');

            new Chart(ctx, {
                type: graphType,
                data: {
                    labels: dates,
                    datasets: datasets
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                 precision: 0,
                                 padding: 5,
                            }
                        }]
                    },
                   /* hover: {
                        animationDuration: 0
                    },
                    animation: {
                        duration: 1,
                        onComplete: function () {
                            var chartInstance = this.chart,
                                ctx = chartInstance.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function (bar, index) {
                                    var data = dataset.data[index];  
                                    if(data>0)ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    }*/
                },
            });

            graph_holder.on('click', '.hap-print-chart-btn', function(){

                var w = canvas.width, h = canvas.height

                var dataUrl = canvas.toDataURL(); //attempt to save base64 string to server using this var  

                var windowContent = '<!DOCTYPE html>';
                windowContent += '<html>'
                windowContent += '<head><title>Print canvas</title></head>';
                windowContent += '<body>'
                windowContent += '<img src="' + dataUrl + '">';
                windowContent += '</body>';
                windowContent += '</html>';

                var printWin = window.open('', '', 'width=' + screen.availWidth + ',height=' + screen.availHeight);
                printWin.document.open();
                printWin.document.write(windowContent); 

                printWin.document.addEventListener('load', function() {
                    printWin.focus();
                    printWin.print();
                    printWin.document.close();
                    //printWin.close();            
                }, true);

            })

            //toggle create/remove graph buttons
            createGraphBtn.hide();
            row.find('.hap-stat-remove-graph').show().one('click', function(e){
                e.preventDefault();
                var btn = $(this).hide();
                btn.data('createGraphBtn').show();//show create graph btn
                btn.data('createGraphBtn', null);
                btn.data('parentRow').data('graphHolderRow').remove();//get parent row, remove graph
                btn.data('parentRow').data('graphHolderRow', null);
                var row = btn.data('parentRow').removeAttr('data-parent-id')
                btn.data('parentRow', null);
            }).data({'createGraphBtn': createGraphBtn, 'parentRow': row});

            preloader.hide();
            creatingGraph = false;

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
            creatingGraph = false;
            alert("Create graph error occured!"); 
        });

    });







    //add playlist from top tracks

    //modal

    var addPlaylistModal = $('#hap-add-playlist-modal'),
    modalBg = $('.hap-modal-bg').on('click',function(e){
        if(e.target == this){ 
            removePlaylistModal()
        }
    });

    _doc.on('keyup', function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        
        var key = e.keyCode, target = $(e.target);
        
        if(key == 27) {//esc
            removePlaylistModal()
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
            modalBg.scrollTop(0);
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
            {name: 'media_id', value: playlistFromStatMediaId}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){

            //go to edit playlist page
            window.location = statWrap.attr('data-admin-url') + '?page=hap_playlist_manager&action=edit_playlist&hap_msg=playlist_created&playlist_id=' + response

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            addPlaylistSubmit = false;
            removePlaylistModal()
        });

        return false;

    });

    function removePlaylistModal(){
        addPlaylistModal.hide();  

        addPlaylistModal.find('#playlist-title').val('').removeClass('aprf'); 
    }

    function showPlaylistModal(){
        addPlaylistModal.show();
        $('#playlist-title').focus()
        modalBg.scrollTop(0);
    }

    var playlistFromStatMediaId
    _doc.on('click', '.hap-create-playlist-from-stat', function(){
        playlistFromStatMediaId = $(this).attr('data-media-id')
        showPlaylistModal()
    })



    

    $('#hap-clear-statistics').on('click', function(){
        
        var msg = $(this).attr('data-message')
        var result = confirm(msg);
        
        if(result){

            preloader.show();

            if(statSource == 'playlist'){

                var postData = [
                    {name: 'action', value: 'hap_stat_clear'},
                    {name: 'type', value: statSource},
                    {name: 'playlist_id', value: selectedPlaylistId},
                    {name: 'security', value: hap_data.security}
                ];

            }else if(statSource == 'player'){

                var postData = [
                    {name: 'action', value: 'hap_stat_clear'},
                    {name: 'type', value: statSource},
                    {name: 'player_id', value: selectedPlayerId},
                    {name: 'security', value: hap_data.security}
                ];

            }

            $.ajax({
                url: hap_data.ajax_url,
                type: 'post',
                data: postData,
                dataType: 'json',
            }).done(function(response){

                console.log(response)

                if(response){
                    if(response == 'SUCCESS'){

                        mediaItemList.find('.hap-stat-row:not(.media-item-container-hidden)').remove()//clear current

                        $('.hap-stats-total-time').html('')
                        $('.hap-stats-total-play').html('')
                        $('.hap-stats-total-download').html('')
                        $('.hap-stats-total-like').html('')
                        $('.hap-stats-total-finish').html('')
                                    
                        getBox([], $('.hap-box-top-play-day'))

                        getBox([], $('.hap-box-top-play-week'))

                        getBox([], $('.hap-box-top-play-month'))
                 
                        getBox([], $('.hap-box-top-play-all-time'))

                        getBox([], $('.hap-box-top-download-all-time'))

                        getBox([], $('.hap-box-top-like-all-time'))

                        getBox([], $('.hap-box-top-finish-all-time'))

                    }
                }

                preloader.hide();

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText, textStatus, errorThrown);
                preloader.hide();
            }); 

        }

    });

    




    //############################################//
    /* helpers */
    //############################################//

    function isEmpty(str){
        return str.replace(/^\s+|\s+$/g, '').length == 0;
    }

    function getUrlParameter(k) {
        var p={};
        window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){p[k]=v})
        return k?p[k]:p;
    };
/*
    function convertTime(sec){
        if (sec < 60) {
            return sec+' sec';
        } else if (sec >= 60 && sec < 3600) {
            var hours   = Math.floor(sec / 3600);
            var minutes = Math.floor((sec - (hours * 3600)) / 60);
            var seconds = sec - (hours * 3600) - (minutes * 60);
            return minutes+'.'+seconds+' min';
        } else if (sec >= 3600 && sec < 86400) {
            var hours   = Math.floor(sec / 3600);
            var minutes = Math.floor((sec - (hours * 3600)) / 60);
            return hours+'.'+minutes+' hr';
        } else if (sec >= 86400 && sec) {
            var days = Math.floor(sec / 86400);
            return '~'+days+' days';
        }
    }*/


    function formatDate(date){
        var dd = date.getDate(),
        mm = date.getMonth()+1,
        yyyy = date.getFullYear();
        if(dd<10) {dd='0'+dd}
        if(mm<10) {mm='0'+mm}
        date = yyyy+'-'+mm+'-'+dd;
        return date;
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

    function convertTime(time){
        if(!time)return '0';

        if (time < 60) {
            return time+' sec';

        } else if (time >= 60 && time < 3600) {
            var min = Math.floor(time / 60);
            var sec = time % 60;
        
            if(min < 10){
               // min = min.substr(-1);
            }
            return min+'.'+sec+' min';

        } else if (time >= 3600 && time < 86400) {
            var hour = Math.floor(time / 60 / 60);
            var min = Math.floor(time / 60) - (hour * 60);

            if(hour < 10){
               // hour = hour.substr(-1);
            }
            return hour+'.'+min+' hr';

        } else if (time >= 86400 && time) {
            var day = Math.floor(time / (3600*24));

            if(day < 10){
                //day = day.substr(-1);
            }
            return '~'+day+' days';
        }
    }

    function convertCount(num){
        if(!num)return '0';
        if(num < 1000){
            return num;
        } else {
            return Math.round((num / 1000), 2)+' K';
        }
    } 

    var monthNameList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]

    function getMonths(startDate, endDate){
        var resultList = [],
        date = new Date(startDate),
        endDate = new Date(endDate)

        while (date <= endDate){

            var stringDate = monthNameList[date.getMonth()] + " " + date.getFullYear();

            resultList.push(stringDate);

            date.setMonth(date.getMonth() + 1);
        }
        
        return resultList;
    };


	

});