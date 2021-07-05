$('#hamburger-menu').on('click',()=>{
    $('#sidenav').fadeIn();
});
$('#sidenav').on('click',()=>{
    $('#sidenav').fadeOut('fast');
});
$('#search-icon-mobile').on('click',function(){
    $('.search-in-mobile-mode').toggle();
});
$('#register').on('click',function(e){
    e.preventDefault();
    let username = $('#username-register').val();
    let email = $('#email-register').val();
    let mobile_number = $('#mobile-number-register').val();
    let password = $('#password-register').val();
    let role = 'user';

    $.ajax({
        url : "process/register.php",
        type : "POST",
        data : {username,email,mobile_number,password,role},
        success : function(data)
        {
            if(data == 4)
            {
                alert('User already registered');
            }else if(data == 5)
            {
                $('.modal-right-side').append("<div class='alert alert-success'>Login to your account</div>")
                $('#plans').css('display','flex');
                $('#plans').html(get_pricing());
            }else{
                register_validation(data);
            }
        }
    });
});
function get_pricing()
{
    $.ajax({
        url : "includes/pricing.php",
        type : "POST",
        success : function(data)
        {
            get_pricing_data(data);
            return data;
        }
    });
}
function register_validation(data){
    let data_array = JSON.parse(data);
    const element_array = [$('#username-register'),$('#email-register'),$('#mobile-number-register'),$('#password-register')];

    element_array.forEach(ele=>{
        ele.css('border-bottom-color','#b9b9b9');
    });
    
    data_array.forEach((ele)=>{
        element_array[ele].css('border-bottom-color','red');
    });
}
$('#login').on('click',function(e){
    e.preventDefault();
    let email_number = $('#email-number-login').val();
    let password = $('#password-login').val();

    $.ajax({
        url : "process/login.php",
        type : "POST",
        data : {email_number,password},
        success : function(data)
        {
            result = JSON.parse(data);
            $('#password-login').css('border-bottom-color','#b9b9b9');
            $('#email-number-login').css('border-bottom-color','#b9b9b9');
            $.each(result, function(key, value){
                $.each(value, function(key, value){
                    switch(key)
                    {
                        case '1':
                                $('#email-number-login').css('border-bottom-color','red');
                                break;
                        case '2':
                                $('#password-login').css('border-bottom-color','red');
                                break;
                        case '3':
                                $('.modal-background').fadeOut();
                                $('#email-number-login').val('');
                                $('#password-login').val('');
                                $('#password-login').css('border-bottom-color','#b9b9b9');
                                $('#email-number-login').css('border-bottom-color','#b9b9b9');
                                alert(value);
                                window.location.href='index.php';
                                break;
                        case '4':
                                alert(value);
                                $('#password-login').css('border-bottom-color','red');
                                $('#email-number-login').css('border-bottom-color','red');
                                break;
                        case '5':
                                alert(value);
                                $('#password-login').css('border-bottom-color','red');
                                $('#email-number-login').css('border-bottom-color','red');
                                break;
                        case '6':
                                alert(value);
                                $('#password-login').css('border-bottom-color','red');
                                $('#email-number-login').css('border-bottom-color','red');
                                break;
                    }
                });
            });
        }
    });
});
$('.planings').on('click',()=>{
    $('#plans').css('display','flex');
    get_pricing();
});
function get_pricing_data(data){
    $('#plans').html(data);
}
$(document).on('click','#close-plans',()=>{
    $('#plans').css('display','none');
});
$(document).on('click','#skip-plan',()=>{
    $('#plans').css('display','none');
});