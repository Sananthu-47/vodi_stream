$(document).ready(function() {
    let pathname = window.location.pathname.split('?');
    pathname = pathname[0];
    let search = window.location.search;

    if(checkCurrentTab(pathname,search)){
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

function checkCurrentTab(realpath,search){
    let count = 0;
    for(let i=0;i<$('.side-nav').children().length;i++){
        if($('.side-nav').children()[i].href+search==="http://localhost"+realpath+search)
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
        type : "GET",
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
