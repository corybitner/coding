
jQuery(document).ready(function($) {

    "use strict"

    var preloader = $('#hap-loader');


    var globalSettingsForm = $('#hap-form-global-settings');

    //prevent enter sumbit form
    globalSettingsForm.keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    var isSubmit;
    $('#hap-edit-global-options-submit').on('click', function (){

        if(isSubmit)return false;//prevent double submit
        isSubmit = true;

        preloader.show()
        
        var options = {};
        $.each(globalSettingsForm.serializeArray(), function(i, field) {
             options[field.name] = field.value;
        });

        globalSettingsForm.find("input:checkbox:not(:checked)").map(function() {
            options[this.name] = "0";
        });

       
        var postData = [
            {name: 'action', value: 'hap_save_global_options'},
            {name: 'security', value: hap_data.security},
            {name: 'options', value: JSON.stringify(options)},

        ];

        console.log(postData)

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){
            console.log(response)

            isSubmit = false;
            preloader.hide()

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText, textStatus, errorThrown);
            isSubmit = false;
            preloader.hide()
        });

        return false;
    });

});