<?php include "side-nav.php"; ?>

<div class="custom-navbar text-white d-flex flex-row">
    <div class="nav-left-side d-flex col-lg-8">
        <div class="left-side-nav-first d-flex align-items-center  px-1">
            <i class='fa fa-bars pr-3' id='hamburger-menu'></i>
            <div id="logo">vodi</div>
        </div><!---left-side-nav-first-->
            <ul class='nav left-side-nav-second col-lg-8 d-flex justify-content-around align-items-center'>
                <li class='nav-item'>Browse</li>
                <li class='nav-item'>Home</li>
                <li class='nav-item'>Blog</li>
                <li class='nav-item'>Movies</li>
                <li class='nav-item'>Tv</li>
                <li class='nav-item' id='planings'>Plan</li>
            </ul><!--left-side-nav-second- -->
    </div><!---nav-left-side-->
    <div class="nav-right-side d-flex justify-content-end col-lg-4">
    <div class="right-side-nav-first d-flex justify-content-between align-items-center col-9">
    <div class="input-group">
        <input type="text" id="search" class='form-control p-4 search-input' placeholder='Search...'>
        <div class="input-group-append search-inside-input d-flex justify-content-end align-items-center">
        <i id='search-icon-desktop' class='fa fa-search text-secondary'></i>
        </div>
    </div>
        <button class="btn btn-none text-white d-flex align-items-center" id='admin-button'><i class='fa fa-cloud-upload mx-2'></i><span>Upload</span></button>
    </div><!---right-side-nav-first--->
    <div class="right-side-nav-second d-flex justify-content-between align-items-center">
        <i id='search-icon-mobile' class='fa fa-search d-none px-3'></i>
        <div class='d-flex align-items-center dropdown'>
            <div id='profile-img-small' class='d-flex justify-content-center align-items-center'><i class='fa fa-user fa-2x'></i></div>
            <i class='fa fa-angle-down arrow-down'></i>
        </div>
    </div><!---right-side-nav-second--->
    </div><!--nav-right-side-->
</div>

<div class="search-in-mobile-mode" style='display:none;'>
<div class="d-flex">
    <input type="text" id='search-box-mobile' placeholder='Search...'>
    <div class="input-group-append search-inside-input-mobile d-flex justify-content-end align-items-center">
        <i id='search-icon-desktop' class='fa fa-search text-secondary'></i>
    </div>
    </div>
</div>

    <!-- Drop down to get signin and register -->
        <ul class="sub-menu dropdown-menu text-center" style='display:none;'>
            <li class='list-item modal-pop-login'>Sign In</li>
            <li class='list-item modal-pop-login'>Register</li>
        </ul>

        <!---Modal for register and login-->
    <div class="modal-background" id='modal-register' style='display:none'>
        <div id="modal" class='bg-white self-center-modal row'>
        <i class='fa fa-close' id='close-modal'></i>
            <div class="col-12 col-lg-6 col-xl-6 modal-left-side">
                <span class='my-2 h3'>Register</span>
                <form action="#" id='register-form' class='d-flex flex-column justify-content-between my-3 left-form'>
                    <label for="email-register">Email*</label>
                    <input type="email" name='email-register' id='email-register' class='input-modal mb-3'>
                    <label for="mobile-number-register">Mobile number*</label>
                    <input type="number" name='mobile-number-register' id='mobile-number-register' class='input-modal mb-3'>
                    <label for="passowrd-register">Password*</label>
                    <input type="password" name='password-register' id='password-register' class='input-modal mb-3'>
                    <button class="btn btn-info py-2 my-3" id='register'><span class='h5'>Register</span></button>
                </form>
            </div>
            <div class="col-12 col-lg-6 col-xl-6 modal-right-side">
            <span class='my-2 h3'>Login</span>
                <form action="#" class='d-flex flex-column justify-content-between my-3'>
                    <label for="email-register">Email or Mobile number*</label>
                    <input type="email" name='email-number-register' id='email-register' class='input-modal mb-3'>
                    <label for="passowrd-login">Password*</label>
                    <input type="password" name='password-login' id='password-login' class='input-modal mb-3'>
                    <button class="btn btn-info py-2 my-3"><span class='h5'>Login</span></button>
                </form>
            </div>
        </div>
    </div>

<script>
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
    $('.modal-pop-login').on('click',function(){
        $('#modal-register').fadeIn();
    });
    $('#close-modal').on('click',()=>{
        $('.modal-background').fadeOut();
    });
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
        let email = $('#email-register').val();
        let mobile_number = $('#mobile-number-register').val();
        let password = $('#password-register').val();

        $.ajax({
            url : "process/login.php",
            type : "POST",
            data : {email,mobile_number,password},
            success : function(data)
            {
                if(data == 3)
                {
                    alert('User already registered');
                }else if(data == 4)
                {
                    $('#plans').css('display','flex');
                    $('#plans').html(`<?php include "pricing.php"; ?>`);
                }else{
                    register_validation(data);
                }
            }
        });
    });

    function register_validation(data){
        let data_array = JSON.parse(data);
        const element_array = [$('#email-register'),$('#mobile-number-register'),$('#password-register')];

        element_array.forEach(ele=>{
            ele.css('border-bottom-color','#b9b9b9');
        });
        
        data_array.forEach((ele)=>{
            element_array[ele].css('border-bottom-color','red');
        });
    }


$('#planings').on('click',()=>{
    $('#plans').css('display','flex');
    $('#plans').html(`<?php include "pricing.php";  ?>`);
});


$(document).on('click','#close-plans',()=>{
    $('#plans').css('display','none');
});



</script>