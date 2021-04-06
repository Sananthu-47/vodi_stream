$(document).ready(function() {
    let search = window.location.search;
    if(search == '')
    {
        search = '?users=all-users';
    }

    let video_index = checkCurrentTabVideos(search);
    $('#sub-nav').children().children()[video_index].classList.add('active-background');

});

function checkCurrentTabVideos(search){
    const videos_array = ['all-users','add-users'];
    let data='';
    videos_array.forEach(function(ele,i){
        if(search == '?users='+ele)
            {
                data =  i;
            }
    });
    return data;
}

// Register a user
$(document).on('click','#user-register',function(e){
    e.preventDefault();
    let username = $('#user-name').val();
    let email = $('#user-email').val();
    let mobile_number = $('#user-number').val();
    let password = $('#user-password').val();
    let role = $('#role').val();
    $.ajax({
        url : "../../process/register.php",
        type : "POST",
        data : {username,email,mobile_number,password,role},
        success : function(data)
        {
            if(data == 4)
            {
                alert('User already registered');
            }else if(data == 5)
            {
                alert('Success');
            }else{
                register_validation(data);
            }
        }
    });
});

// Validate the data to check any empty form fields
function register_validation(data){
    let data_array = JSON.parse(data);
    const element_array = [$('#user-name'),$('#user-email'),$('#user-number'),$('#user-password')];

    element_array.forEach(ele=>{
        ele.css('border','1px solid #b9b9b9');
    });
    
    data_array.forEach((ele)=>{
        element_array[ele].css('border','1px solid red');
    });
}


// Make the user active
$(document).on('click','.make-user-active',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'user-active';
    
    $.ajax({
        url : "../proccess/make-action.php",
        type : "POST",
        data : {id,action},
        success : function()
        {
            current_element.prop('disabled',true);
            current_element.next().removeAttr('disabled');
        }
    });
});
// Make the user blocked
$(document).on('click','.make-user-blocked',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'user-block';
    
    $.ajax({
        url : "../proccess/make-action.php",
        type : "POST",
        data : {id,action},
        success : function()
        {
            current_element.prop('disabled',true);
            current_element.prev().removeAttr('disabled');
        }
    });
});

// Make the user deleted
$(document).on('click','.make-user-delete',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'user-delete';
    if(confirm("Do you want to delete this user?"))
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