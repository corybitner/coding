jQuery(document).ready(function($) {

    "use strict"

    var preloader = $('#hap-loader'),
     _body = $('body'),
    _doc = $(document)



    var ad_pre_field = $('.ad_pre_field'),
    ad_mid_field = $('.ad_mid_field'),
    ad_end_field = $('.ad_end_field')


    
    //******* ad form submit

   /* var editAdForm = $('#hap-edit-ad-form');
    var editAdSubmit;
    $('#hap-edit-ad-form-pre-submit').on('click', function (){

        if(editAdSubmit)return false;//prevent double submit
        editAdSubmit = true;

        //remove empty ad fields
        ad_pre_field.find('.hap_ad').each(function(){
            if(this.value == "") $(this).closest('.hap-ad-wrap').remove();
        });
        ad_mid_field.find('.hap_ad').each(function(){
            if(this.value == "") $(this).closest('.hap-ad-wrap').remove();
        });
        ad_end_field.find('.hap_ad').each(function(){
            if(this.value == "") $(this).closest('.hap-ad-wrap').remove();
        });



        setTimeout(function(){
            clearTimeout(this);
            $('#hap-edit-ad-form-submit').click();
            editAdSubmit = false;
        },50);

        return false;
    });*/

   

    //filter ads

    var adItemList = $('#hap-ad-item-list');

    $('#hap-filter-ad').on('keyup.apfilter',function(){

        var value = $(this).val(), i, j = 0, title, len = adItemList.children('.hap-ad-item').length;

        for(i = 0; i < len; i++){

            title = adItemList.children('.hap-ad-item').eq(i).find('.hap-ad-title').val();

            if(title.indexOf(value) >- 1){
                adItemList.children('.hap-ad-item').eq(i).show();
            }else{
                adItemList.children('.hap-ad-item').eq(i).hide();
                j++;
            }
        }

    });

    //select all
    $('.hap-ad-table').on('click', '.hap-ad-all', function(){
        if($(this).is(':checked')){
            adItemList.find('.hap-ad-indiv').prop('checked', true);
        }else{
            adItemList.find('.hap-ad-indiv').prop('checked', false);
        }
    });


    //delete selected
    $('#hap-delete-ads').on('click', function(){
        if(adItemList.find('.hap-ad-indiv').length == 0)return false;//no media

        var selected = adItemList.find('.hap-ad-indiv:checked');

        if(selected.length == 0) {
            alert("No ads selected!");
            return false;
        }

        var result = confirm("Are you sure to delete selected ads?");
        if(result){

            preloader.show();

            var arr = [];

            selected.each(function(){
                arr.push(parseInt($(this).closest('.hap-ad-row').attr('data-ad-id'),10));
            });

            deleteAd(arr)
            
        }
    });

    function deleteAd(arr){

        var postData = [
            {name: 'action', value: 'hap_delete_ad'},
            {name: 'ad_id', value: arr},
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
                var i, len = arr.length;
                for(i = 0;i<len;i++){
                    adItemList.find('.hap-ad-row[data-ad-id="'+arr[i]+'"]').remove();
                }
                $('.hap-ad-all').prop('checked', false);
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
        });  

    }


    adItemList.on('click', '.hap-delete-ad', function(){

        var result = confirm("Are you sure to delete this ad?");
        if(result){

            var ad_id = parseInt($(this).closest('.hap-ad-row').attr('data-ad-id'),10);

            preloader.show()

            deleteAd([ad_id])

        }

        return false;

    })




    //add ad

    //modal

    var addAdModal = $('#hap-add-ad-modal'),
    modalBg = $('.hap-modal-bg').on('click',function(e){
        if(e.target == this){ // only if the target itself has been clicked
            removeAdModal()
        }
    });

    _doc.on('keyup', function(e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        
        var key = e.keyCode, target = $(e.target);
        
        if(key == 27) {//esc
            removeAdModal()
        } 
    }); 

    $('#hap-add-ad-cancel').on('click',function(e){
        removeAdModal()
    });


    var addAdSubmit
    $('#hap-add-ad-submit').on('click',function(e){

        var title_field = $('#ad-title')

        if(isEmpty(title_field.val())){
            title_field.addClass('aprf'); 
            modalBg.scrollTop(0);
            alert('Title is required!');
            return false;
        }

        if(addAdSubmit)return false;
        addAdSubmit = true;

        var title = title_field.val()

        preloader.show()
        removeAdModal()

        var postData = [
            {name: 'action', value: 'hap_create_ad'},
            {name: 'security', value: hap_data.security},
            {name: 'title', value: title}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){

            //go to edit ad page
            window.location = adItemList.attr('data-admin-url') + '?page=hap_ad_manager&action=edit_ad&hap_msg=ad_created&ad_id=' + response

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            addAdSubmit = false;
            removeAdModal()
        });

        return false;

    });

    function removeAdModal(){
        addAdModal.hide();  

        addAdModal.find('#ad-title').val('').removeClass('aprf'); 
    }

    $('#hap-add-ad').on('click',function(e){
        showAdModal()
    });

    function showAdModal(){
        addAdModal.show();
        $('#ad-title').focus()
        modalBg.scrollTop(0);
    }











    //############################################//
    /* export / import */
    //############################################//

    var jquery_csv_js = 'https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/1.0.5/jquery.csv.min.js';
    

    //export ads

    $('.hap-table').on('click','.hap-export-ad-btn', function(){

        preloader.show();

        var ad_id = $(this).closest('.hap-ad-row').attr('data-ad-id'),
        ad_title = $(this).closest('.hap-ad-row').find('.title-editable').val();

        ad_title = ad_title.replace(/\W/g, '');//safe chars

        var postData = [
            {name: 'action', value: 'hap_export_ad'},
            {name: 'ad_id', value: ad_id},
            {name: 'ad_title', value: ad_title},
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

    //import ad

    var adFileInput = $('#hap-ad-file-input').on('change', prepareAdUpload);

    var import_ad_btn = $('#hap-import-ad').click(function(){
        adFileInput.trigger('click'); 
        return false;
    }); 

    function prepareAdUpload(event) { 

        //check if correct file uploaded
        if(event.target.files.length == 0) return;
        var fileName = event.target.files[0].name;
        if(fileName.indexOf('hap_ad_id_') == -1){
            alert("Make sure you upload previously exported ad zip file starting with hap_ad_id_ !");
            return;
        }

        preloader.show();

        import_ad_btn.css('display','none');

        var file = event.target.files;
        var data = new FormData();
        var nonce = $('#hap-import-ad-form').find("#_wpnonce").val();
        $.each(file, function(key, value){
            data.append("hap_file_upload", value);
        });
        data.append("action", "hap_import_ad");
        data.append("security", hap_data.security );

        adFileInput.val('');

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: data,
            dataType: 'json',
            processData: false, 
            contentType: false, 
        }).done(function(response){

            if(response.ad){

                getCSVPlayer(response.ad);

            }else{
                import_ad_btn.css('display','inline-block');
                preloader.hide();

                alert("Error importing!");
            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            import_ad_btn.css('display','inline-block');
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
                        {name: 'action', value: 'hap_import_ad_db'},
                        {name: 'ad', value: JSON.stringify(data)},
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
                        import_ad_btn.css('display','inline-block');
                        alert("Error importing!");
                    }); 

                }); 
                  
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log('Error process CSV: ' + jqXHR, textStatus, errorThrown);
                preloader.hide();
                import_ad_btn.css('display','inline-block');
                alert("Error importing!");
                
            });

        }
    }
  

    //############################################//
    /* duplicate */
    //############################################//

    $('.hap-duplicate-ad').on('click', function(){
        return duplicateAd('Enter title for new ad:', $(this));
    });

    function duplicateAd(msg, target){
        var title = prompt(msg);

        if(title == null){//cancel
            return false;
        }else if(title.replace(/^\s+|\s+$/g, '').length == 0) {//empty
            duplicateAd(msg, target);
            return false;
        }else{

            preloader.show()
           
            var postData = [
                {name: 'action', value: 'hap_duplicate_ad'},
                {name: 'security', value: hap_data.security},
                {name: 'title', value: title},
                {name: 'ad_id', value: target.closest('.hap-ad-row').attr('data-ad-id')},
            ];

            $.ajax({
                url: hap_data.ajax_url,
                type: 'post',
                data: postData,
                dataType: 'json',   
            }).done(function(response){

                //go to edit ad page
                window.location = adItemList.attr('data-admin-url') + '?page=hap_ad_manager&action=edit_ad&hap_msg=ad_created&ad_id=' + response

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



});