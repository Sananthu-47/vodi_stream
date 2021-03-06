$('.sub-menu').on('mouseenter',function(){
    $('.sub-menu').show();
});
$('.sub-menu').on('mouseleave',function(){
    $('.sub-menu').hide();
});
$('.dropdown').on('mouseenter',function(){
    $('.sub-menu').show();
});
$('.dropdown').on('mouseleave',function(){
    $('.sub-menu').hide();
});
$('.modal-pop').on('click',function(){
    $('#modal-register').fadeIn();
});
$('#close-modal').on('click',()=>{
    $('.modal-background').fadeOut();
    $('#password-login').css('border-bottom-color','#b9b9b9');
    $('#email-number-login').css('border-bottom-color','#b9b9b9');
});
$('#hamburger-menu').on('click',()=>{
    $('#sidenav').fadeIn();
});
$('#sidenav').on('click',()=>{
    $('#sidenav').fadeOut('fast');
});
$('#search-icon').on('click',function(){
    $('.search-mode').toggle();
});

$("#search-box").on('input',function(e){
    if($(this).val().length > 1){
        let search = $(this).val();
        $(".suggestions").show();

        $.ajax({
            url : "process/search.php",
            type : "POST",
            data : {search},
            success : function(data)
            {
                let response = JSON.parse(data);
                let output = '';
                if(response.length > 0){
                    response.forEach((ele,i)=>{
                        let type = ele[0];
                        if(i < 5){
                            output+=`
                            <a class='item' href='`;
                            if(type == 'Movie'){
                                output+=`movie.php?movie_id=${ele[1]}`;
                            }else{
                                output+=`webseries.php?webseries_id=${ele[1]}`;
                            }
                            output+=`'>
                                <div class='poster'>
                                    <img src='${ele[4]}'>
                                </div>
                                <div class='info'>
                                    <div class='title'>${ele[2]}`;
                                    if(type == 'Webseries'){
                                        output+=`<span class='season-badge-light mx-2'>Season ${ele[6]}</span>`;
                                    }
                                    output+=`</div>
                                    <div class='meta'>
                                    ${ele[3]}<i class='dot'></i>${ele[5]}<i class='dot'></i>${ele[0]}
                                    </div>
                                </div>
                            </a>
                            `;
                        }
                    });
                $(".suggestions").html(output);
                }else{
                    $(".suggestions").html('<a class="more">Not found <i class="fa fa-frown-o"></i></a>');
                }
            }
        });
    }else{
        $(".suggestions").hide();
    }
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

