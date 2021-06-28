// Make the category add
$(document).on('click','#add-category',function(){
    let category_name = $('#category-name').val();
    let action = 'add-category';
    let id = 0;
    if(category_name != '')
    {
        $.ajax({
            url : "../proccess/make-action.php",
            type : "POST",
            data : {category_name,action,id},
            success : function(data)
            {
                if(data == 1){
                    alert(category_name+" already added");
                }else{
                    location.reload();
                }
            }
        });
    }else{
        $('#category-name').focus();
    }
});

// Make the category deleted
$(document).on('click','.make-category-delete',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'delete-category';
    if(confirm("Do you want to delete this category?"))
    {
        $.ajax({
            url : "../proccess/make-action.php",
            type : "POST",
            data : {id,action},
            success : function()
            {
                current_element.parent().parent().remove();
            }
        });
    }
});

$('.edit').on('click',function(){
    let category = $(this).data('category');
    let id = $(this).data('id');
    $('.admin-wrapper').scrollTop(0);
    $('#category-name').focus();
    $('#category-name').val(category);
    $('#add-category').hide();
    $('#update-category-div').show();
    $('#update-category').data('id',id);
    $('#update-category-div').css('display','flex');
});

$('#cancel').on('click',function(){
    $('#category-name').val('');
    $('#add-category').show();
    $('#update-category').data('id','');
    $('#update-category-div').hide();
});


// Make the category editable
$(document).on('click','#update-category',function(){
    let category_name = $('#category-name').val();
    let id = $(this).data('id');
    let action = 'update-category';
    if(category_name != '' && id != '')
    {
        $.ajax({
            url : "../proccess/make-action.php",
            type : "POST",
            data : {category_name,action,id},
            success : function(data)
            {
                if(data == 1){
                    alert(category_name+" already added");
                }else{
                    location.reload();
                }
            }
        });
    }else{
        $('#category-name').focus();
    }
});