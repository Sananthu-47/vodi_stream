$('.filter-icon').on('click',function(){
    $('.filters').show();
    $('.filters').removeClass('d-none');
});

$('.close-side-nav-holder').on('click',function(){
    $('.filters').addClass('d-none');
});

$(document).ready(function(){
    $(document).ajaxStart(function(){
      $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
      $("#wait").css("display", "none");
    });
  });

window.addEventListener("resize", function(){
    if (window.innerWidth > 1200) {
        $('.filters').removeClass('d-none');
    }
}, true);

let letters_array = [];
let years_array = [];
let categories_array = [];

$('.dropdown-movies').on('change',function(){
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let search = $('#search_filter').val();
    let order = $(this).val();
    let output = '';
    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order},
        success : function(data)
        {
            let response = JSON.parse(data);
            if(response.length<1)
            {
                output = "<div class='m-auto'><span class='badge badge-primary'>No results found</span></div>";
            }else{
                response.forEach(result=>{
                    output += `<div class='movie-card'>
                <div class='movie-image'>
                    <img src='${result.thumbnail}'>
                </div>
                <div class='movie-info'>
                    <span>${result.release_year}&nbsp;&nbsp;|&nbsp;&nbsp;${result.category}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Part ${result.part}</span></span>
                    <span>${result.title}</span>
                </div>
            </div><!---movie-card-->`;
                });
            }
                $('.all-movies-holder').html(output);
        }
    });
});

$('#search-filter-button').on('click',function(){
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let output = '';

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order},
        success : function(data)
        {
            let response = JSON.parse(data);
            if(response.length<1)
            {
                output = "<div class='m-auto'><span class='badge badge-primary'>No results found</span></div>";
            }else{
                response.forEach(result=>{
                    output += `<div class='movie-card'>
                <div class='movie-image'>
                    <img src='${result.thumbnail}'>
                </div>
                <div class='movie-info'>
                    <span>${result.release_year}&nbsp;&nbsp;|&nbsp;&nbsp;${result.category}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Part ${result.part}</span></span>
                    <span>${result.title}</span>
                </div>
            </div><!---movie-card-->`;
                });
            }
                $('.all-movies-holder').html(output);
        }
    });
});

$(document).on('click','.letter-badge',function(){
    if(letters_array.includes($(this).data('letter')))
    {
        $(this).removeClass('active-badge');
        let removeItem = $(this).data('letter');
        letters_array = $.grep(letters_array, function(value) {
            return value != removeItem;
            });
    }else{
        letters_array.push($(this).data('letter'));
        $(this).addClass('active-badge');
    }
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let output = '';
    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order},
        success : function(data)
        {
            let response = JSON.parse(data);
            if(response.length<1)
            {
                output = "<div class='m-auto'><span class='badge badge-primary'>No results found</span></div>";
            }else{
            response.forEach(result=>{
                output += `<div class='movie-card'>
            <div class='movie-image'>
                <img src='${result.thumbnail}'>
            </div>
            <div class='movie-info'>
                <span>${result.release_year}&nbsp;&nbsp;|&nbsp;&nbsp;${result.category}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Part ${result.part}</span></span>
                <span>${result.title}</span>
            </div>
        </div><!---movie-card-->`;
            });
        }
            $('.all-movies-holder').html(output);
        }
    });
});

$(document).on('click','.years-badge',function(){
    if(years_array.includes($(this).data('year')))
    {
        $(this).removeClass('active-badge');
        let removeItem = $(this).data('year');
        years_array = $.grep(years_array, function(value) {
            return value != removeItem;
            });
    }else{
        years_array.push($(this).data('year'));
        $(this).addClass('active-badge');
    }
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let output = '';
    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order},
        success : function(data)
        {
            let response = JSON.parse(data);
            if(response.length<1)
            {
                output = "<div class='m-auto'><span class='badge badge-primary'>No results found</span></div>";
            }else{
                response.forEach(result=>{
                    output += `<div class='movie-card'>
                <div class='movie-image'>
                    <img src='${result.thumbnail}'>
                </div>
                <div class='movie-info'>
                    <span>${result.release_year}&nbsp;&nbsp;|&nbsp;&nbsp;${result.category}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Part ${result.part}</span></span>
                    <span>${result.title}</span>
                </div>
            </div><!---movie-card-->`;
                });
            }
                $('.all-movies-holder').html(output);
        }
    });
});
