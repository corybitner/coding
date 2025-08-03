
jQuery(document).ready(function($) {

    "use strict"

    var hapAdmin = $('.hap-admin');


    //colors 
    $(".hap-checkbox").spectrum({
        color: $(this).val(),
        showAlpha: true,
        chooseText: "Update",
        showInitial: true,
        showInput: true,
        preferredFormat: "hex",
        change: function(color) {
            $(this).val(color.toRgbString());
        }
    });





    //accordion
    hapAdmin.on('click', '.option-toggle', function(e){
        var parent = $(this).closest('.option-tab');
        if(parent.hasClass('option-closed')){
            parent.removeClass('option-closed');
        }else{
            parent.addClass('option-closed');
        }
    });


    //show title on fields
    hapAdmin.on('hover','input[type=text]',function(){
        $(this).attr('title',$(this).val())
    });
    hapAdmin.on('hover','textarea',function(){
        $(this).attr('title',$(this).text())
    });
    hapAdmin.on('hover','select',function(){
        $(this).attr('title',$(this).find(':selected').text())
    });




    







    //edit player / playlist title
   $('.hap-table .title-editable').on('blur', function(){

        var input = $(this), title = input.val();
        if(title == ''){
            input.val(input.attr('data-title'));
            alert('Title cannot be empty!');
            return false;
        }

        if(input.attr('data-player-id') !== undefined){
            var postData = [
                {name: 'action', value: 'hap_edit_player_title'},
                {name: 'title', value: title},
                {name: 'id', value: input.attr('data-player-id')},
                {name: 'security', value: hap_data.security}
            ];
        }else if(input.attr('data-playlist-id') !== undefined){
            var postData = [
                {name: 'action', value: 'hap_edit_playlist_title'},
                {name: 'title', value: title},
                {name: 'id', value: input.attr('data-playlist-id')},
                {name: 'security', value: hap_data.security}
            ];
        }else if(input.attr('data-ad-id') !== undefined){
            var postData = [
                {name: 'action', value: 'hap_edit_ad_title'},
                {name: 'title', value: title},
                {name: 'id', value: input.attr('data-ad-id')},
                {name: 'security', value: hap_data.security}
            ];
        }

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        });    

    });





   //############################################//
    /* sticky */
    //############################################//

    function updateSticky() {
        if ((window.innerHeight + window.scrollY) >= (document.body.scrollHeight - 50)) {
            $("#hap-sticky-action").removeClass("hap-sticky")
            $("#hap-save-holder").hide()
        } else {
            $("#hap-sticky-action").addClass("hap-sticky")
            $("#hap-save-holder").show()
        }
    }

    $(window).scroll(function() {
        updateSticky()
    })

    $(window).resize(function() {
        updateSticky()
    })

    updateSticky()



    

});

