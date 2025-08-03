
jQuery(document).ready(function($) {

    "use strict"


    var preloader = $('#hap-loader');


    //ad pre

    var ad_pre_field = $('.ad_pre_field');
    ad_pre_field.find('.add_another').on('click', function(){//add another field
        createAdField(ad_pre_field, '');
    });


  

    if(typeof hap_adPre !== 'undefined' && hap_adPre !== null){
        ad_pre_field.find('.hap_ad').eq(0).val(hap_adPre[0]);//zero field

        var i, len = hap_adPre.length;
        for(i = 1;i<len;i++){
            createAdField(ad_pre_field, hap_adPre[i]);
        }  
    }

    checkAdRemoveBtn(ad_pre_field);


    //ad mid

    var ad_mid_field = $('.ad_mid_field');
    ad_mid_field.find('.add_another').on('click', function(){//add another field
        createAdField(ad_mid_field, '');
    });

    if(typeof hap_adMid !== 'undefined' && hap_adMid !== null){
        ad_mid_field.find('.hap_ad').eq(0).val(hap_adMid[0]);//zero field

        var i, len = hap_adMid.length;
        for(i = 1;i<len;i++){
            createAdField(ad_mid_field, hap_adMid[i]);
        }  
    }

    checkAdRemoveBtn(ad_mid_field);


    //ad end

    var ad_end_field = $('.ad_end_field');
    ad_end_field.find('.add_another').on('click', function(){//add another field
        createAdField(ad_end_field, '');
    });

    if(typeof hap_adEnd !== 'undefined' && hap_adEnd !== null){    
        ad_end_field.find('.hap_ad').eq(0).val(hap_adEnd[0]);//zero field

        var i, len = hap_adEnd.length;
        for(i = 1;i<len;i++){
            createAdField(ad_end_field, hap_adEnd[i]);
        }  
    }

    checkAdRemoveBtn(ad_end_field);
  

    function checkAdRemoveBtn(field){//hide remove btn if only one field
        if(field.find('.hap-ad-wrap').length == 1){
            field.find('.hap_ad_remove_wrap').css('display','none');
        }else{
            field.find('.hap_ad_remove_wrap').css('display','inline-block');
        }
    }
    
    function createAdField(field, v){
        var wrap = field.find('.hap-ad-wrap').eq(0).clone();
        wrap.insertBefore(field.find('.add_another'));
        wrap.find('.hap_ad').val(v);//field value
        checkAdRemoveBtn(field);
    }

    //ad upload
    $(document).on('click', '.hap_ad_upload', function(){

        var source = $(this).closest('.hap-ad-inner').find('.hap_ad');

        var custom_uploader = wp.media({
            library:{
                type: "audio/*"
            }
        })
        .on("select", function(){
            var attachment = custom_uploader.state().get("selection").first().toJSON();
            $(source).val(attachment.url);
        })
        .open();

    });

    //ad remove
    $(document).on('click', '.hap_ad_remove', function(){
        var field = $(this).closest('.ad_field');
        $(this).closest('.hap-ad-wrap').remove();
        checkAdRemoveBtn(field);
    });




    $('.hap_ad_sortable').sortable({ 
        items:'.hap-ad-wrap',
        handle:'.hap_ad_sort',
        cancel: '',
        axis:'y',
        revert: false
    });





    var editAdForm = $('#hap-edit-ad-form');

    //prevent enter sumbit form
    editAdForm.keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    var editAdSubmit;
    $('#hap-edit-ad-options-submit').on('click', function (){

        if(editAdSubmit)return false;//prevent double submit
        editAdSubmit = true;

        preloader.show();


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


        
        var options = {};
        $.each(editAdForm.serializeArray(), function(i, field) {

             if(field.name != 'ad_pre[]' 
                && field.name != 'ad_mid[]' 
                && field.name != 'ad_end[]' 
                )options[field.name] = field.value;
        });

        editAdForm.find("input:checkbox:not(:checked)").map(function() {
            options[this.name] = "0";
        });

        var ad_pre = []
        $('input.ad_pre').each(function() {
            if(this.value != '')ad_pre.push(this.value); 
        });
        options['ad_pre'] = ad_pre;

        var ad_mid = []
        $('input.ad_mid').each(function() {
            if(this.value != '')ad_mid.push(this.value); 
        });
        options['ad_mid'] = ad_mid;

        var ad_end = []
        $('input.ad_end').each(function() {
            if(this.value != '')ad_end.push(this.value); 
        });
        options['ad_end'] = ad_end;

        var postData = [
            {name: 'action', value: 'hap_save_ad_options'},
            {name: 'security', value: hap_data.security},
            {name: 'ad_id', value: editAdForm.attr('data-ad-id')},
            {name: 'options', value: JSON.stringify(options)},

        ];

        console.log(postData)

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){

            preloader.hide();
            editAdSubmit = false;

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            preloader.hide();
            editAdSubmit = false;
        });

        return false;
    });

});