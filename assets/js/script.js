$('.filter-icon').on('click',function(){
    $('.filters').show();
    $('.filters').removeClass('d-none');
});

// Closes the side nav in smaller versions
$('.close-side-nav-holder').on('click',function(){
    $('.filters').addClass('d-none');
});

// Shows a loading gif on any ajax request
$(document).ready(function(){
    $(document).ajaxStart(function(){
      $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
      $("#wait").css("display", "none");
    });
  });

// Fix for the side menu bar from showing in smaller size
window.addEventListener("resize", function(){
    if (window.innerWidth > 1200) {
        $('.filters').removeClass('d-none');
    }
}, true);

// Used to add hover effect for categories on side of page 
$('.category-list').hover(function(){
    $(this).children().toggleClass('add-icon').before();
});

// Global variables
let letters_array = [];
let years_array = [];
let categories_array = [];
// On change of the dropdown we get ajax request to filter data
$('.dropdown-movies').on('change',function(){
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let category = JSON.stringify(categories_array);
    let search = $('#search_filter').val();
    let order = $(this).val();
    let type = $(this).data('type');
    let limit = 20;
    
    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,limit},
        success : function(data)
        {
            if(type == 'movie')
            {
                addMovieCards(data);
            }else{
                addWebseriesCards(data);
            }
        }
    });
});
// On click of the search button fetch data
$('#search-filter-button').on('click',function(){
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let category = JSON.stringify(categories_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let limit = 20;

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,limit},
        success : function(data)
        {
            if(type == 'movie')
            {
                addMovieCards(data);
            }else{
                addWebseriesCards(data);
            }
        }
    });
});
// Get the data on click of the letters tab
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
    let category = JSON.stringify(categories_array);
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let limit = 20;

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,limit},
        success : function(data)
        {
            if(type == 'movie')
            {
                addMovieCards(data);
            }else{
                addWebseriesCards(data);
            }
        }
    });
});
// get data on years tab
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
    let category = JSON.stringify(categories_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let limit = 20;

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,limit},
        success : function(data)
        {
            if(type == 'movie')
            {
                addMovieCards(data);
            }else{
                addWebseriesCards(data);
            }
        }
    });
});
// get data on based on categories
$(document).on('click','.category-list',function(){
    if(categories_array.includes($(this).data('category')))
    {
        $(this).children().removeClass('add-icon-click');
        $(this).css('color','#949cb0');
        let removeItem = $(this).data('category');
        categories_array = $.grep(categories_array, function(value) {
            return value != removeItem;
            });
    }else{
        categories_array.push($(this).data('category'));
        $(this).children().addClass('add-icon-click');
        $(this).css('color','#24baef');
    }
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let category = JSON.stringify(categories_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let limit = 20;

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,limit},
        success : function(data)
        {
            if(type == 'movie')
            {
                addMovieCards(data);
            }else{
                addWebseriesCards(data);
            }
        }
    });
});
// Main function to form the movies card
function addMovieCards(data){
    let output = '';
    let response = JSON.parse(data);
            if(response.length<1)
            {
                output = "<div class='mx-auto my-5'><span class='btn btn-primary'>No results found</span></div>";
            }else{
                response.forEach(result=>{
                    let categories = result.category.split(',');
                    output += `<div class='movie-card'>
                    <a href='movie.php?movie_id=${result.id}'><div class='movie-image'>
                        <img src='${result.thumbnail}'>
                    </div></a>
                <div class='movie-info'>
                    <span>${result.release_year}&nbsp;&nbsp;|&nbsp;&nbsp;${categories[0]}}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Part ${result.part}</span></span>
                    <span>${result.title}</span>
                </div>
            </div><!---movie-card-->`;
                });
            }
                $('.all-movies-holder').html(output);
}

// Main function to form the webseries card
function addWebseriesCards(data){
    let output = '';
    let response = JSON.parse(data);
    console.log(response);
    
            if(response.length<1)
            {
                output = "<div class='mx-auto my-5'><span class='btn btn-primary'>No results found</span></div>";
            }else{
                response.forEach(result=>{
                    let webseries = result.webseries;
                    let categories = webseries.category.split(',');
                    output += `<div class='movie-card'>
                    <a href='webseries.php?webseries_id=${webseries.id}&episode_id=${result.episodes.id}'><div class='movie-image'>
                        <img src='${webseries.thumbnail}'>
                    </div></a>
                <div class='movie-info'>
                    <span>${webseries.release_year}&nbsp;&nbsp;|&nbsp;&nbsp;${categories[0]}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Season ${webseries.season_number}</span></span>
                    <span>${webseries.title}</span>
                </div>
            </div><!---movie-card-->`;
                });
            }
                $('.all-movies-holder').html(output);
}

$('#watch-movie').on('click',function(){
    let id = $(this).data('movie-id');
    let episode_id = 0;
    if($(this).data('episode'))
        episode_id = $(this).data('episode');
    let type = $(this).data('type');
    $.ajax({
        url : "process/get-video.php",
        type : "POST",
        data : {id,type,episode_id},
        success : function(data)
        {
            $('#movie-single-banner').html(data);
        },
        error : function(){
            $('#movie-single-banner').html("We are facing some issues resolve it soon");
        }
    });

});