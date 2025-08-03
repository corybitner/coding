jQuery(document).ready(function($) {

    "use strict"

    var preloader = $('#hap-loader'),
     _body = $('body'),
    _doc = $(document),
    empty_src = 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D',
    playerItemList = $('#player-item-list'),
    playerTableHeader = $('.hap-player-table-header')





    $('#playlistTitleOrder_field').sortable({ 
        helper: 'clone',
    });




    //############################################//
    /* player manager */
    //############################################//





    //keyboard

    var keyboard_controls_field = $('#hap-keyboard-controls-field'),
    keyboard_controls_field_inner = $('#hap-keyboard-controls-field-inner')

    if(typeof hap_allKeyboardControls_arr !== 'undefined'){

        var i, len = hap_allKeyboardControls_arr.length, obj;

        if(len > 0){
            for(i=0;i<len;i++){

                obj = hap_allKeyboardControls_arr[i]//all keyboard controls
                var tb = $('.hap-value-table-wrap-orig').clone().removeClass('hap-value-table-wrap-orig').addClass('hap-value-table-wrap').appendTo(keyboard_controls_field_inner)

                tb.find('.hap-keyboard-key').val(obj.key)
                tb.find('.hap-keyboard-action-display').val(obj.action_display)
                tb.find('.hap-keyboard-keycode').val(obj.keycode)
                tb.find('.hap-keyboard-action').val(obj.action)

                if(hap_keyboardControls_arr.length && hap_keyboardControls_arr[0].action == obj.action){//compare from options
                    hap_keyboardControls_arr.shift()
                }else{
                    tb.addClass('hap-value-table-wrap-disabled')
                }

            }
        }

    }


    keyboard_controls_field.find('.hap-keyboard-key-enter').on('keyup', function(e) {

        //check if exist
        var new_key = e.keyCode
        if(new_key == '8' || new_key == '46')return false;//delete, backspace

        var used_keys = getAllUsedKeys()
        if(used_keys.indexOf(new_key) > -1){
            alert('Key already exist!')
            return false;
        }

        $(this).closest('.hap-value-table-wrap').find('.hap-keyboard-keycode').val(e.keyCode)
        $(this).closest('.hap-value-table-wrap').find('.hap-keyboard-key').val(keyCodeArr[e.keyCode])

    })

    keyboard_controls_field.on('click', '.keyboard-controls-toggle', function(){//toogle disabled

        var parent = $(this).closest('.hap-value-table-wrap')

        if(parent.hasClass('hap-value-table-wrap-disabled')){
            parent.removeClass('hap-value-table-wrap-disabled')
        }else{
            parent.addClass('hap-value-table-wrap-disabled')
        }
    })


    


    


    //custom css
    var customCssInited,
    cssCodeEditor;
    function initCustomCss(){
        if(document.getElementById("hap_custom_css_field")){
            jQuery(document).ready(function(){
                cssCodeEditor = CodeMirror.fromTextArea(document.getElementById("hap_custom_css_field"), {
                    lineNumbers: true,
                    mode: 'css',
                    lineWrapping:true                       
                });
            });
        }
        customCssInited = true;
    }

    //custom js
    var customJsInited,
    jsCodeEditor;
    function initCustomJs(){
        if(document.getElementById("hap_custom_js_field")){
            jsCodeEditor = CodeMirror.fromTextArea(document.getElementById("hap_custom_js_field"), {
                lineNumbers: true,
                mode: 'js',
                lineWrapping:true                       
            });
        }
        customJsInited = true;
    }


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

	}).change();

    





    //grid thumb icons

    var gridPauseIcon_preview = $('#gridPauseIcon_preview'),
    gridPauseIcon_remove = $('#gridPauseIcon_remove').on('click', function(e){
        gridPauseIcon_preview.attr('src',empty_src);
        gridPauseIcon.val('');
    }),
    gridPauseIcon = $('#gridPauseIcon').on('keyup',function(){
        if($(this).val() == ''){
            gridPauseIcon_preview.attr('src',empty_src);
        }
    });

    var gridPlayIcon_preview = $('#gridPlayIcon_preview'),
    gridPlayIcon_remove = $('#gridPlayIcon_remove').on('click', function(e){
        gridPlayIcon_preview.attr('src',empty_src);
        gridPlayIcon.val('');
    }),
    gridPlayIcon = $('#gridPlayIcon').on('keyup',function(){
        if($(this).val() == ''){
            gridPlayIcon_preview.attr('src',empty_src);
        }
    });
    

   









    //tabs


    //general sub tabs
    var general_tabs_sub = $('#hap-general-tabs-sub'),
    sub_tabs_inited;

    general_tabs_sub.find('.hap-tab-header-sub div').on('click', function(){
        var tab = $(this), id = tab.attr('id');

        if(!tab.hasClass('hap-tab-active')){ 
            general_tabs_sub.find('.hap-tab-header-sub div').removeClass('hap-tab-active');  
            tab.addClass('hap-tab-active');
            general_tabs_sub.find('.hap-tab-content-sub').hide();

            $('#'+ id + '-content-sub').show();
        }
    });



    var style_tabs = $('#hap-general-tabs');

    style_tabs.find('.hap-tab-header div').click(function(){
        var tab = $(this), id = tab.attr('id');

        if(!tab.hasClass('hap-tab-active')){ 
            style_tabs.find('.hap-tab-header div').removeClass('hap-tab-active');  
            tab.addClass('hap-tab-active');
            style_tabs.find('.hap-tab-content').hide();

            $('#'+ id + '-content').show();
            if(id == 'hap-tab-custom-css' && !customCssInited)initCustomCss();
            else if(id == 'hap-tab-custom-js' && !customJsInited)initCustomJs();

             if(!sub_tabs_inited && tab.index() == 0){
                sub_tabs_inited = true
                general_tabs_sub.find('.hap-tab-header-sub div').eq(0).click()
            }
        }
    });

   style_tabs.find('.hap-tab-header div').eq(0).click()










    //lang

    var fetch_lang_on,
    playerLanguageEdited,
    translationEditContentField = $('#hap-translation-edit-content-field'),
    playerLanguage = $('#playerLanguage').on('change', function(){
        translationEditContentField.hide()
        playerLanguageEdited = false;
    })

    $('#hap-translation-edit').on('click', function(){

        if(fetch_lang_on) return false;
        fetch_lang_on = true;

        preloader.show()

        var postData = [
            {name: 'action', value: 'hap_get_player_lang'},
            {name: 'security', value: hap_data.security},
            {name: 'lang', value: playerLanguage.val()}
        ];

        jQuery.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){

            console.log(response)

            Object.keys(response).forEach(function(key) {
                //console.log(key, response[key]);
                translationEditContentField.find('input[name="'+key+'"]').val(response[key])
            });

            fetch_lang_on = false;
            playerLanguageEdited = true;

            preloader.hide()


            translationEditContentField.show()

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            fetch_lang_on = false;
            preloader.hide()
        });




        
    })

    

    


    //sort on start

    var sortInited
    var paginationArr = []
    //get all tracks
    var i = 0;
    playerItemList.find('.hap-player-item').each(function(){
        paginationArr.push($(this).attr('data-id', i))
        i++;
    })

    playerTableHeader.find('.hap-sort-field').on('click', function(e){

        e.preventDefault()

        var btn = $(this),
        asc = btn.attr('data-asc') == 'true',
        items = playerItemList.find('.hap-player-item'), len = items.length,
        type = btn.attr('data-type')

        if(type == 'title' || type == 'preset')keysrtStr(paginationArr, '.media-'+type, asc);
        else keysrtNum(paginationArr, '.media-'+type, asc);

        asc = !asc
        btn.attr('data-asc', asc)

        //save state
        if(localStorage){
            lastMediaSortInBackend.type = type
            lastMediaSortInBackend.asc = asc

            var key = 'hap_last_player_sort_in_backend'
            localStorage.setItem(key, JSON.stringify(lastMediaSortInBackend));

        }

        setSortIndicator()

        var i, arr = [];
        for(i = 0;i < len; i++){
            arr.push(parseInt(paginationArr[i].attr('data-id'),10));
        }

        //reposition data
        playerItemList.append($.map(arr, function(v) {
            return items[v];
        }));

        //update id
        var i = 0;
        playerItemList.find('.hap-player-item').each(function(){
            $(this).attr('data-id', i)
            i++;

            if(!sortInited){
                $(this).css('opacity',1)
            }
        })

        sortInited = true;

    })

    //restore sort
    var lastMediaSortInBackend = {type: 'id', asc: true}
    if(localStorage){
        var key = 'hap_last_player_sort_in_backend'
        if(localStorage.getItem(key)){
            lastMediaSortInBackend = JSON.parse(localStorage.getItem(key))

            var asc = lastMediaSortInBackend.asc == true ? false : true;

            playerTableHeader.find('.hap-sort-field[data-type="'+lastMediaSortInBackend.type+'"]').attr('data-asc',asc).click()

        }else{
            setSortIndicator()

            sortInited = true

            playerItemList.find('.hap-player-item').each(function(){
                $(this).css('opacity',1)
            })
        }
    }

    function setSortIndicator(){

        playerTableHeader.find('.hap-triangle-dir-wrap, .hap-triangle-dir').hide()//hide all

        if(lastMediaSortInBackend.asc == true){
            playerTableHeader.find('.hap-sort-field[data-type="'+lastMediaSortInBackend.type+'"]').find('.hap-triangle-dir-wrap').show().find('.hap-triangle-dir-down').show()
        }else{
            playerTableHeader.find('.hap-sort-field[data-type="'+lastMediaSortInBackend.type+'"]').find('.hap-triangle-dir-wrap').show().find('.hap-triangle-dir-up').show()
        }

    }






   //player placeholder thumb

   //media thumb

    var placeHolderThumb_remove = $('#placeHolderThumb_remove').on('click', function(e){
        e.preventDefault();
        placeHolderThumb_preview.attr('src',empty_src);
        placeHolderThumb.val('');
        placeHolderThumb_remove.hide();
    }).hide();

    var placeHolderThumb_preview = $('#placeHolderThumb_preview')
   
    var placeHolderThumb = $('#placeHolderThumb').on('keyup',function(){
        if($(this).val() == ''){
            placeHolderThumb_preview.attr('src',empty_src);
            placeHolderThumb_remove.hide();
        }
    })



   var uploadManagerArr = [
        {btn:$("#placeHolderThumb_upload"), manager:null},
        {btn:$("#gridPauseIcon_upload"), manager:null},
        {btn:$("#gridPlayIcon_upload"), manager:null},
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

                if(id == 'placeHolderThumb_upload'){
                    library = "image";
                    source = '#placeHolderThumb';
                }
                else if(id == 'gridPauseIcon_upload'){
                    library = "image";
                    source = '#gridPauseIcon';
                }
                else if(id == 'gridPlayIcon_upload'){
                    library = "image";
                    source = '#gridPlayIcon';
                }

                custom_uploader = wp.media({
                    library:{
                        type: library
                    }
                })
                .on("select", function(){
                    var attachment = custom_uploader.state().get("selection").first().toJSON();
                    $(source).val(attachment.url);
                   
                    if(source == '#placeHolderThumb'){
                        placeHolderThumb_preview.attr('src', attachment.url);
                        placeHolderThumb_remove.show();
                    }
                    else if(source == '#gridPauseIcon'){
                        gridPauseIcon_preview.attr('src', attachment.url);
                    }
                    else if(source == '#gridPlayIcon'){
                        gridPlayIcon_preview.attr('src', attachment.url);
                    }

                })
                .open();

                uploadManagerArr[data_id].manager = custom_uploader;//save for reuse

            });
        }   
    }



    //add player

    //modal

    var addPlayerModal = $('#hap-add-player-modal'),
    modalBg = $('.hap-modal-bg').on('click',function(e){
        if(e.target == this){ // only if the target itself has been clicked
            removePlayerModal()
        }
    });

    _doc.on('keyup', function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        
        var key = e.keyCode, target = $(e.target);
        
        if(key == 27) {//esc
            removePlayerModal()
        } 
    }); 

    $('#hap-add-player-cancel').on('click',function(e){
        removePlayerModal()
    });


    var addPlayerSubmit
    $('#hap-add-player-submit').on('click',function(e){

        var title_field = $('#player-title')

        if(isEmpty(title_field.val())){
            title_field.addClass('aprf'); 
            modalBg.scrollTop(0);
            alert('Title is required!');
            return false;
        }

        if(addPlayerSubmit)return false;
        addPlayerSubmit = true;

        var title = title_field.val(),
        preset = $('#preset').val()

        preloader.show()
        removePlayerModal()

        var postData = [
            {name: 'action', value: 'hap_create_player'},
            {name: 'security', value: hap_data.security},
            {name: 'title', value: title},
            {name: 'preset', value: preset},
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){

            //go to edit player page
            window.location = playerItemList.attr('data-admin-url') + '?page=hap_player_manager&action=edit_player&hap_msg=player_created&player_id=' + response

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            addPlayerSubmit = false;
            removePlayerModal()
        });

        return false;

    });

    function removePlayerModal(){
        addPlayerModal.hide();  

        addPlayerModal.find('#player-title').val('').removeClass('aprf'); 
    }

    $('#hap-add-player').on('click',function(e){
        showPlayerModal()
    });

    function showPlayerModal(){
        addPlayerModal.show();
        $('#player-title').focus()
        modalBg.scrollTop(0);
    }






    
    //******* player form submit

    var editPlayerForm = $('#hap-edit-player-form');

    //prevent enter sumbit form
    editPlayerForm.keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    var editPlayerSubmit;
    $('#hap-edit-player-options-submit').on('click', function (){

        if(editPlayerSubmit)return false;//prevent double submit
        editPlayerSubmit = true;

        //accordions expand

        //editPlayerForm.find('.option-tab').removeClass('option-closed');

        preloader.show();

        //update player

        //icons
        $('#linkIcon').val($('#linkIcon').val().replace(/"/g, "'"))
        $('#downloadIcon').val($('#downloadIcon').val().replace(/"/g, "'"))

        var options = serializeObject(editPlayerForm)

        editPlayerForm.find("input:checkbox:not(:checked)").map(function() {

            if(this.name != 'viewSongWithoutAdsUserRoles[]'){
                if(!options[this.name]){
                    options[this.name] = "0";
                }
            }
        });

        for (var key of Object.keys(options)) {
             if(key.indexOf('[]') > -1){
                var new_key = key.substr(0, key.length-2)
                options[new_key] = options[key];
            }
        }

       


        if(playerLanguageEdited){
            options['playerLanguageEdited'] = '1';
        }else{
            options['playerLanguageEdited'] = '0';
        }

        //keyboard
        var keyboardControls = []
        keyboard_controls_field.find(".hap-value-table-wrap:not(.hap-value-table-wrap-disabled)").each(function() {
            var item = $(this)

            var obj = {
                keycode: item.find('.hap-keyboard-keycode').val(), 
                action: item.find('.hap-keyboard-action').val()
            }
            keyboardControls.push(obj)
           
        });
        options.keyboardControls = keyboardControls;
        console.log(options)


        var custom_css = cssCodeEditor ? cssCodeEditor.getValue() : '',
        custom_js = jsCodeEditor ? jsCodeEditor.getValue() : ''

        var postData = [
            {name: 'action', value: 'hap_save_player_options'},
            {name: 'security', value: hap_data.security},
            {name: 'player_id', value: editPlayerForm.attr('data-player-id')},
            {name: 'player_options', value: JSON.stringify(options)},
            {name: 'custom_css', value: custom_css},
            {name: 'custom_js', value: custom_js},
        ];

        console.log(postData)

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){

            preloader.hide();
            editPlayerSubmit = false;

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
            editPlayerSubmit = false;
        });

        return false;
    });



    $('#playlistScrollType').on('change', function(){
        var v = $(this).val()
        if(v == 'mcustomscrollbar'){
            $('#playlistScrollTheme_field').show()
        }else if(v == 'perfect-scrollbar'){
            $('#playlistScrollTheme_field').hide()
        }
    }).change()





    if(editPlayerForm.length){
        var preset = editPlayerForm.attr('data-preset');
        



        //playlist
        if(preset == 'poster' || preset == 'epic_mini' || preset.indexOf('tiny') > -1 || preset == 'widget' || preset.indexOf('compact') > -1){
            $('.hap-editplayer-playlist-field').remove();
            $('.hap-editplayer-playlist-items-field').remove();
        }

        if(preset.indexOf('art_') == -1 && preset != 'wall' && preset.indexOf('brona') == -1 && preset.indexOf('fixed') == -1){
            $('.playlist-opened-on-start-field').remove();
        }

        //search field
      /*  if(preset == 'poster' || preset.indexOf('tiny') > -1 || preset == 'widget' || preset == 'wall' || preset == 'wall2' || preset == 'artwork' || preset.indexOf('compact') > -1){
            $('.hap-editplayer-search-field').remove();
        }

        //popup window
        if(preset == 'poster' || preset.indexOf('tiny') > -1 || preset == 'widget' || preset == 'wall' || preset == 'wall2' || preset == 'artwork' || preset.indexOf('compact') > -1){
            $('.hap-editplayer-popup-window-field').remove();
        }

        //skip buttons
        if(preset.indexOf('art_') == -1 && preset.indexOf('brona') == -1 && preset.indexOf('fixed') == -1){
            $('.hap-editplayer-use-skip-field').remove();
        }

        //range
        if(preset.indexOf('art_') == -1 && preset.indexOf('brona') == -1 && preset.indexOf('modern') == -1){
            $('.hap-editplayer-use-range-field').remove();
        }

        //playback rate
        if(preset.indexOf('art_') == -1 && preset.indexOf('brona') == -1 && preset != 'modern' && preset != 'metalic'){
            $('.hap-editplayer-use-playback-rate-field').remove();
        }

        //share
        if(preset.indexOf('tiny') > -1 || preset == 'widget' || preset.indexOf('compact') > -1){
            $('.hap-editplayer-share-field').remove();
        }*/

        //grid
      /*  if(preset.indexOf('no_player') > -1){
            $('.hap-tab-header-ga-field').remove();
            $('.hap-tab-header-stats-field').remove();            

            $('.hap-editplayer-share-field').remove();
            $('.hap-editplayer-continous-playback-field').remove();
            $('.hap-editplayer-popup-window-field').remove();
            $('.hap-editplayer-elements-field').remove();
            $('.hap-editplayer-accordion-field').remove();
            $('.hap-editplayer-playlist-field').remove();
            $('.hap-editplayer-playback-field').remove();
        }*/



        if(preset.indexOf('grid') == -1){
            $('.playlist-skin').hide() 
        }else{
            $('.default-skin').hide() 
        }


        if(preset.indexOf('fixed') == -1){
            $('.fixed-skin').hide() 
        }else{
            $('.fixed-skin').show() 
        }
    }
    
    $('#infoSkin').on('change',function(){

        var t = $(this).val()
        var img = hap_data.plugins_url + '/assets/grid/'+t+'.png';
        $('#playlist-grid-style-img').attr('src', img);

    }).change();

    
    //share
    $('#useShare').on('change',function(){

        if($(this).is(':checked')){
            $('.hap_share_btn').show();
        }else{
            $('.hap_share_btn').hide();
        }

    }).change();


    //filter players

    var playerItemList = $('#player-item-list');

    $('#hap-filter-player').on('keyup.apfilter',function(){

        var value = $(this).val(), i, j = 0, title, len = playerItemList.children('.hap-player-item').length;

        for(i = 0; i < len; i++){

            title = playerItemList.children('.hap-player-item').eq(i).find('.player-title').val();

            if(title.indexOf(value) >- 1){
                playerItemList.children('.hap-player-item').eq(i).show();
            }else{
                playerItemList.children('.hap-player-item').eq(i).hide();
                j++;
            }
        }

    });

    //select all
    $('.hap-player-table').on('click', '.hap-player-all', function(){
        if($(this).is(':checked')){
            playerItemList.find('.hap-player-indiv').prop('checked', true);
        }else{
            playerItemList.find('.hap-player-indiv').prop('checked', false);
        }
    });


    //delete selected
    $('#hap-delete-players').on('click', function(){
        if(playerItemList.find('.hap-player-indiv').length == 0)return false;//no media

        var selected = playerItemList.find('.hap-player-indiv:checked');

        if(selected.length == 0) {
            alert("No players selected!");
            return false;
        }

        var result = confirm("Are you sure to delete selected players?");
        if(result){

            var arr = [];

            selected.each(function(){
                arr.push(parseInt($(this).closest('.hap-player-row').attr('data-player-id'),10));
            });

            deletePlayer(arr)
              
        }
    });

    function deletePlayer(arr){

        preloader.show();

        var postData = [
            {name: 'action', value: 'hap_delete_player'},
            {name: 'player_id', value: arr},
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
            if(response){
                var i, len = arr.length;
                for(i = 0;i<len;i++){
                    playerItemList.find('.hap-player-row[data-player-id="'+arr[i]+'"]').remove();
                }
                $('.hap-player-all').prop('checked', false);
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
        });
    }

    playerItemList.on('click', '.hap-delete-player', function(){

        var result = confirm("Are you sure to delete this player?");
        if(result){

            var player_id = parseInt($(this).closest('.hap-player-row').attr('data-player-id'),10);

            preloader.show();

            deletePlayer([player_id])

        }

        return false;

    })


    
    //############################################//
    /* export / import */
    //############################################//

    var jquery_csv_js = 'https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/1.0.5/jquery.csv.min.js';

    //export player

    $('.hap-table').on('click','.hap-export-player-btn', function(){

        preloader.show();

        var player_id = $(this).closest('.hap-player-row').attr('data-player-id'),
        player_title = $(this).closest('.hap-player-row').find('.title-editable').val();

        player_title = player_title.replace(/\W/g, '');//safe chars

        var postData = [
            {name: 'action', value: 'hap_export_player'},
            {name: 'player_id', value: player_id},
            {name: 'player_title', value: player_title},
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

    //import player

    var playerFileInput = $('#hap-player-file-input').on('change', preparePlayerUpload);

    var import_player_btn = $('#hap-import-player').click(function(){
        playerFileInput.trigger('click'); 
        return false;
    }); 

    function preparePlayerUpload(event) { 

        //check if correct file uploaded
        if(event.target.files.length == 0) return;
        var fileName = event.target.files[0].name;
        if(fileName.indexOf('hap_player_id_') == -1){
            alert("Make sure you upload previously exported player zip file starting with hap_player_id_ !");
            return;
        }

        preloader.show();

        import_player_btn.css('display','none');

        var file = event.target.files;
        var data = new FormData();
        var nonce = $('#hap-import-player-form').find("#_wpnonce").val();
        $.each(file, function(key, value){
            data.append("hap_file_upload", value);
        });
        data.append("action", "hap_import_player");
        data.append("security", hap_data.security );

        playerFileInput.val('');

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: data,
            dataType: 'json',
            processData: false, 
            contentType: false, 
        }).done(function(response){

            if(response.player){

                getCSVPlayer(response.player);

            }else{
                import_player_btn.css('display','inline-block');
                preloader.hide();

                alert("Error importing!");
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            import_player_btn.css('display','inline-block');
            preloader.hide();

            alert("Error importing!");
        }); 

    }

    function getCSVPlayer(url){

        if(typeof $.csv === 'undefined'){

            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = jquery_csv_js;
            script.onload = script.onreadystatechange = function() {
                if(!this.readyState || this.readyState == 'complete'){
                    getCSVPlayer(url);
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

                var d = $.csv.toArray(response, {separator:'|', delimiter:'^'}, function(err, data){
                                       
                    //send to db

                    var postData = [
                        {name: 'action', value: 'hap_import_player_db'},
                        {name: 'player', value: JSON.stringify(data)},
                        {name: 'security', value: hap_data.security}
                    ];

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
                        import_player_btn.css('display','inline-block');
                        alert("Error importing!");
                    }); 

                }); 
                  
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log('Error process CSV: ' + jqXHR, textStatus, errorThrown);
                preloader.hide();
                import_player_btn.css('display','inline-block');
                alert("Error importing!");
                
            });

        }
    }

	

    //############################################//
    /* duplicate */
    //############################################//

    $('.hap-duplicate-player').on('click', function(){
        return duplicatePlayer('Enter title for new player:', $(this));
    });

    function duplicatePlayer(msg, target){
        var title = prompt(msg);

        if(title == null){//cancel
            return false;
        }else if(title.replace(/^\s+|\s+$/g, '').length == 0) {//empty
            duplicatePlayer(msg, target);
            return false;
        }else{

            var postData = [
                {name: 'action', value: 'hap_duplicate_player'},
                {name: 'security', value: hap_data.security},
                {name: 'title', value: title},
                {name: 'player_id', value: target.closest('.hap-player-row').attr('data-player-id')},
            ];

            $.ajax({
                url: hap_data.ajax_url,
                type: 'post',
                data: postData,
                dataType: 'json',   
            }).done(function(response){

                //go to edit player page
                window.location = playerItemList.attr('data-admin-url') + '?page=hap_player_manager&action=edit_player&hap_msg=player_created&player_id=' + response

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText, textStatus, errorThrown);
            });

        }
    }



    //############################################//
    /* helpers */
    //############################################//

    function isEmpty(str){
        return str.replace(/^\s+|\s+$/g, '').length == 0;
    }

    function serializeObject(form) {
        var o = {};
        var a = form.serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }      
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };



    var keyCodeArr = {
          0: 'That key has no keycode',
          3: 'break',
          8: 'backspace / delete',
          9: 'tab',
          12: 'clear',
          13: 'enter',
          16: 'shift',
          17: 'ctrl',
          18: 'alt',
          19: 'pause/break',
          20: 'caps lock',
          21: 'hangul',
          25: 'hanja',
          27: 'escape',
          28: 'conversion',
          29: 'non-conversion',
          32: 'spacebar',
          33: 'page up',
          34: 'page down',
          35: 'end',
          36: 'home',
          37: 'left arrow',
          38: 'up arrow',
          39: 'right arrow',
          40: 'down arrow',
          41: 'select',
          42: 'print',
          43: 'execute',
          44: 'Print Screen',
          45: 'insert',
          46: 'delete',
          47: 'help',
          48: '0',
          49: '1',
          50: '2',
          51: '3',
          52: '4',
          53: '5',
          54: '6',
          55: '7',
          56: '8',
          57: '9',
          58: ':',
          59: 'semicolon (firefox), equals',
          60: '<',
          61: 'equals (firefox)',
          63: 'ß',
          64: '@ (firefox)',
          65: 'a',
          66: 'b',
          67: 'c',
          68: 'd',
          69: 'e',
          70: 'f',
          71: 'g',
          72: 'h',
          73: 'i',
          74: 'j',
          75: 'k',
          76: 'l',
          77: 'm',
          78: 'n',
          79: 'o',
          80: 'p',
          81: 'q',
          82: 'r',
          83: 's',
          84: 't',
          85: 'u',
          86: 'v',
          87: 'w',
          88: 'x',
          89: 'y',
          90: 'z',
          91: 'Windows Key / Left ⌘ / Chromebook Search key',
          92: 'right window key',
          93: 'Windows Menu / Right ⌘',
          95: 'sleep',
          96: 'numpad 0',
          97: 'numpad 1',
          98: 'numpad 2',
          99: 'numpad 3',
          100: 'numpad 4',
          101: 'numpad 5',
          102: 'numpad 6',
          103: 'numpad 7',
          104: 'numpad 8',
          105: 'numpad 9',
          106: 'multiply',
          107: 'add',
          108: 'numpad period (firefox)',
          109: 'subtract',
          110: 'decimal point',
          111: 'divide',
          112: 'f1',
          113: 'f2',
          114: 'f3',
          115: 'f4',
          116: 'f5',
          117: 'f6',
          118: 'f7',
          119: 'f8',
          120: 'f9',
          121: 'f10',
          122: 'f11',
          123: 'f12',
          124: 'f13',
          125: 'f14',
          126: 'f15',
          127: 'f16',
          128: 'f17',
          129: 'f18',
          130: 'f19',
          131: 'f20',
          132: 'f21',
          133: 'f22',
          134: 'f23',
          135: 'f24',
          136: 'f25',
          137: 'f26',
          138: 'f27',
          139: 'f28',
          140: 'f29',
          141: 'f30',
          142: 'f31',
          143: 'f32',
          144: 'num lock',
          145: 'scroll lock',
          151: 'airplane mode',
          160: '^',
          161: '!',
          162: '؛ (arabic semicolon)',
          163: '#',
          164: '$',
          165: 'ù',
          166: 'page backward',
          167: 'page forward',
          168: 'refresh',
          169: 'closing paren (AZERTY)',
          170: '*',
          171: '~ + * key',
          172: 'home key',
          173: 'minus (firefox), mute/unmute',
          174: 'decrease volume level',
          175: 'increase volume level',
          176: 'next',
          177: 'previous',
          178: 'stop',
          179: 'play/pause',
          180: 'e-mail',
          181: 'mute/unmute (firefox)',
          182: 'decrease volume level (firefox)',
          183: 'increase volume level (firefox)',
          186: 'semi-colon / ñ',
          187: 'equal sign',
          188: 'comma',
          189: 'dash',
          190: 'period',
          191: 'forward slash / ç',
          192: 'grave accent / ñ / æ / ö',
          193: '?, / or °',
          194: 'numpad period (chrome)',
          219: 'open bracket',
          220: 'back slash',
          221: 'close bracket / å',
          222: 'single quote / ø / ä',
          223: '`',
          224: 'left or right ⌘ key (firefox)',
          225: 'altgr',
          226: '< /git >, left back slash',
          230: 'GNOME Compose Key',
          231: 'ç',
          233: 'XF86Forward',
          234: 'XF86Back',
          235: 'non-conversion',
          240: 'alphanumeric',
          242: 'hiragana/katakana',
          243: 'half-width/full-width',
          244: 'kanji',
          251: 'unlock trackpad (Chrome/Edge)',
          255: 'toggle touchpad',
        };

         function getAllUsedKeys(){
            var arr = []
            keyboard_controls_field.find(".mvp-value-table-wrap:not(.mvp-value-table-wrap-disabled)").each(function() {
                arr.push(parseInt($(this).find('.mvp-keyboard-keycode').val(),10))
            });
            return arr
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