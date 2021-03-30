$(document).ready(function() {
    let pathname = window.location.pathname;

    if(checkCurrentTab(pathname)){
        for(let i=0;i<$('.side-nav').children().length;i++)
        {
            if($('.side-nav').children()[i].href==="http://localhost"+pathname)
            {
                $('.side-nav').children().children()[i].classList.add('active-nav');
            }else if($('.side-nav').children().children()[i].classList.contains('active-nav')){
            $('.side-nav').children().children()[i].classList.remove('active-nav');
            }
        }
    }

});

function checkCurrentTab(pathname){
    let count = 0;
    for(let i=0;i<$('.side-nav').children().length;i++){
        if($('.side-nav').children()[i].href==="http://localhost"+pathname)
        {
            count++;
        }
    }
    if(count>0)
    {
        return true;
    }else{
        return false;
    }
}

$('#menubar').on('click',function(){
    $('.navbar').toggle();
});

// Get add users content page by ajax call
$('#add-user').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-add-user.php",
        type : "POST",
        success : function(data){
            $('.main-content').html(data);
        }
    });
});

// Get all users with a ajax call
$('#user-list').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-user-list.php",
        type : "POST",
        success : function(data){
            $('.main-content').html(data);
        }
    });
});

// Get all videos with a ajax call
$('#video-list').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-all-videos.php",
        type : "POST",
        success : function(data){
            $('.admin-main-content').html(data);
        }
    });
});

// Get add movie page with a ajax call
$('#add-movie').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-add-movie.php",
        type : "POST",
        success : function(data){
            $('.admin-main-content').html(data);
        }
    });
});

// Get all live movies with a ajax call
$('#live-movie').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-live-movie.php",
        type : "POST",
        success : function(data){
            $('.admin-main-content').html(data);
        }
    });
});

// Get Add webseries page with a ajax call
$('#add-webseries').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-add-webseries.php",
        type : "POST",
        success : function(data){
            $('.admin-main-content').html(data);
        }
    });
});

// Get all live webseries page with a ajax call
$('#live-webseries').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-live-webseries.php",
        type : "POST",
        success : function(data){
            $('.admin-main-content').html(data);
        }
    });
});

// Get all advertisement videos with a ajax call
$('#advertisement-list').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-list-of-advertisement.php",
        type : "POST",
        success : function(data){
            $('.admin-main-content').html(data);
        }
    });
});

// Get add advertisement page with a ajax call
$('#add-advertisement').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-add-advertisement.php",
        type : "POST",
        success : function(data){
            $('.admin-main-content').html(data);
        }
    });
});

// Get all payments page with a ajax call
$('#payment-list').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-list-of-payment.php",
        type : "POST",
        success : function(data){
            $('.admin-main-content').html(data);
        }
    });
});

// Get update payment page with a ajax call
$('#update-payment').on('click',function(e){
    clearActiveNav();
    $(this).addClass('active-background');

    $.ajax({
        url : "../proccess/admin-update-payments.php",
        type : "POST",
        success : function(data){
            $('.admin-main-content').html(data);
        }
    });
});

// Clear the active subnavs
function clearActiveNav(){
    $('.content-nav-badges').each(function(i,ele){
        $(ele).removeClass('active-background');
    });
}