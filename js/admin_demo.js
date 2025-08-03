jQuery(document).ready(function($) {

    "use strict"

    //demo preview 
    $("#style-imports").change(function(){
        var t = $(this).val(), img = hap_data.plugins_url + '/assets/presets/'+t+'.jpg';
        $('#hap-sample-import').attr('src', img);
        //show shortcode
        $('.hap-demo-sc').hide();
        $('#'+t).show();
    }).change();


});

