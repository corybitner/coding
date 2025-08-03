jQuery(document).ready(function($) {

    "use strict"


    var categoryTable = $('#category-table'),
    tagTable = $('#tag-table')


    //add tax
    $('#hap-add-category').on('click', function(){

        var input = $('#category-title-add'), title = input.val();
        if(title == ''){
            input.focus()
            alert('Title cannot be empty!');
            return false;
        }

        //check if exist
        var valid = true; 
        categoryTable.find('.hap-taxonomy-title').each(function(){
            if($(this).val() == title){
                valid = false;
                alert('Already exist!');
                return false;
            }
        })

        if(!valid)return false;

        var description_field = $('#category-description-add'),
        description = description_field.val();
        if(isEmpty(description))description = '';

        addTax(categoryTable, 'category', title, description)

        input.val('')
        description_field.val('')

    });

    $('#hap-add-tag').on('click', function(){

        var input = $('#tag-title-add'), title = input.val();
        if(title == ''){
            input.focus()
            alert('Title cannot be empty!');
            return false;
        }

        //check if exist
        var valid = true;   
        tagTable.find('.hap-taxonomy-title').each(function(){
            if($(this).val() == title){
                valid = false;
                alert('Already exist!');
                return false;
            }
        })

        if(!valid)return false;

        var description_field = $('#tag-description-add'),
        description = description_field.val();
        if(isEmpty(description))description = '';

        addTax(tagTable, 'tag', title, description)

        input.val('')
        description_field.val('')

    });

    function addTax(taxTable, type, title, description){

        var postData = [
            {name: 'action', value: 'hap_add_taxonomy'},
            {name: 'type', value: type},
            {name: 'title', value: title},
            {name: 'description', value: description},
            {name: 'security', value: hap_data.security}
        ];

        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){
            console.log(response)

            //create field
            
            var s = '<tr data-title="'+title+'" data-id="'+response+'">'+

                '<td class="taxonomy-item-field">'+
                    '<input type="text" class="hap-field-editable hap-taxonomy-title" value="'+title+'">'+
                '</td>'+

                '<td class="taxonomy-item-field">'+
                    '<input type="text" class="hap-field-editable hap-taxonomy-description" value="'+description+'">'+
                '</td>'+

                '<td><a href="#" class="taxonomy-item-delete" title="Delete" style="color:#f00;">Delete</a></td>'+
            '</tr>'

            var len = taxTable.find('.taxonomy-item-list').length
            if(len == 0){
                //0 items in list
                $(s).appendTo(taxTable.find('tbody'))
            }else{
                //find position

                var toinsert = true;
                taxTable.find('.taxonomy-item-list').each(function(){
                    var item = $(this).attr('data-title')
                    if(title.toUpperCase() < item.toUpperCase()){
                        if(toinsert){
                            $(this).before(s);
                            toinsert = false;
                            return false;
                        }
                    }
                });
                if(toinsert){
                    taxTable.find('tbody').append(s);
                }

            }

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        });  

    }

    //edit tax title
    $('.hap-field-editable.hap-taxonomy-title').on('blur', function(){

        var id = $(this).closest('.hap-table').attr('id'), tax
        if(id == 'category-table')tax = categoryTable
        else if(id == 'tag-table')tax = tagTable

        editTaxTitle(tax, $(this))

    });

    function editTaxTitle(taxTable, item){

        var parent = item.closest('.taxonomy-item-list')
        var backup = parent.attr('data-title')

        var input = item, title = $.trim(input.val());
        if(title == ''){
            
            input.val(backup);//restore value

            alert('Title cannot be empty!');
            return false;
        }

        if(title == backup)return false;//hasnt changed

        //check if exist
        var valid = true;
        taxTable.find('.taxonomy-item-list').not(parent).each(function(){
           
            if($(this).find('.hap-taxonomy-title').val() == title){

                input.val(backup);//restore value

                valid = false;
                alert('Already exist!');
                return false;
            }
           
        })

        if(!valid)return false;

        var taxonomy_id = parent.attr('data-id')

        var description = parent.find('.hap-taxonomy-description').val();
        if(isEmpty(description))description = '';


        var postData = [
            {name: 'action', value: 'hap_edit_taxonomy'},
            {name: 'taxonomy_id', value: taxonomy_id},
            {name: 'title', value: title},
            {name: 'description', value: description},
            {name: 'security', value: hap_data.security}
        ];
   
        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).done(function(response){
            
            //update title backup
            parent.attr('data-title', title)

        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        });    

    }

    //edit tax description
    $('.hap-field-editable.hap-taxonomy-description').on('blur', function(){

        var parent = $(this).closest('.taxonomy-item-list')
        var description = $(this).val();
        var title = parent.find('.hap-taxonomy-title').val();
        var taxonomy_id = parent.attr('data-id')

        editTaxDesc(taxonomy_id, title, description)

    });

    function editTaxDesc(taxonomy_id, title, description){

        var postData = [
            {name: 'action', value: 'hap_edit_taxonomy'},
            {name: 'taxonomy_id', value: taxonomy_id},
            {name: 'title', value: title},
            {name: 'description', value: description},
            {name: 'security', value: hap_data.security}
        ];
   
        $.ajax({
            url: hap_data.ajax_url,
            type: 'post',
            data: postData,
            dataType: 'json',   
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        });    

    }

    //delete tax
    categoryTable.on('click', '.taxonomy-item-delete', function(){
        var title = $(this).closest('.taxonomy-item-list').find('.hap-taxonomy-title').val()
        deleteTax($(this), title)
    })

    tagTable.on('click', '.taxonomy-item-delete', function(){
        var title = $(this).closest('.taxonomy-item-list').find('.hap-taxonomy-title').val()
        deleteTax($(this), title)
    })

    function deleteTax(item, title){

        var result = confirm("Are you sure to delete '" + title+ "' ?");
        if(result){

            var parent = item.closest('.taxonomy-item-list')
            var taxonomy_id = parent.attr('data-id')

            var postData = [
                {name: 'action', value: 'hap_delete_taxonomy'},
                {name: 'taxonomy_id', value: taxonomy_id},
                {name: 'security', value: hap_data.security}
            ];
       
            $.ajax({
                url: hap_data.ajax_url,
                type: 'post',
                data: postData,
                dataType: 'json',   
            }).done(function(response){

                //remove from list
                parent.remove()

            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }); 

        }

        return false;

    }

   

    //filter 

    $('#hap-filter-tax-genre').on('keyup.apfilter',function(){

        var value = $(this).val(), i, j = 0, item, title, len = categoryTable.find('.taxonomy-item-list').length;

        for(i = 0; i < len; i++){

            item = categoryTable.find('.taxonomy-item-list').eq(i)

            title = item.find('.hap-taxonomy-title').val();
            title += item.find('.hap-taxonomy-description').val();

            if(title.indexOf(value) >- 1){
                item.show();
            }else{
                item.hide();
                j++;
            }
        }

    });

    $('#hap-filter-tax-keyword').on('keyup.apfilter',function(){

        var value = $(this).val(), i, j = 0, item, title, len = tagTable.find('.taxonomy-item-list').length;

        for(i = 0; i < len; i++){

            item = tagTable.find('.taxonomy-item-list').eq(i)

            title = item.find('.hap-taxonomy-title').val();
            title += item.find('.hap-taxonomy-description').val();

            if(title.indexOf(value) >- 1){
                item.show();
            }else{
                item.hide();
                j++;
            }
        }

    });





    


    

    //restrict input
    categoryTable.on('keypress', '.hap-taxonomy-title', function(e){  
    
        var regex = new RegExp("^[a-zA-Z0-9 ]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }

        e.preventDefault();
        return false;
    }); 

    

   


   

   

  

    //############################################//
    /* helpers */
    //############################################//

    function isEmpty(str){
        return str.replace(/^\s+|\s+$/g, '').length == 0;
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



   



});