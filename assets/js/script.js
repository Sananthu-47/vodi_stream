// Global variables
let letters_array = [];
let years_array = [];
let ratings_array = [];
let categories_array = [];
let current_page = 1;
let current_home = 0;
let current_page_number = 1;

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
    getHomeData();
});

function getHomeData() {
    $.ajax({
        url : "process/get-home-data.php",
        type : "GET",
        data : {feature : 'home'},
        success : function(data)
        {
            let output = '';            
            let category = '';
            let path = '';
            let part = '';
            let response = JSON.parse(data);
            
            if(response[current_home].type == 'Movie')
            {
                category = response[current_home].category;
                path = `movie.php?movie_id=${response[current_home].id}`;
                part = "Part "+ response[current_home].part;
            }else if(response[current_home].type == 'Webseries')
            {
                category = response[current_home].category;
                path = `webseries.php?webseries_id=${response[current_home].id}`;
                part = "Season "+ response[current_home].part;
            }else if(response[current_home].type == 'Episode')
            {
                category =  getFirstEpisode(response[current_home].part_1_id,'webseries_name');
                part = "S0"+response[current_home].part_1_id+"E0"+response[current_home].part;
                path = `webseries.php?type=episode&webseries_id=${response[current_home].category}&episode_id=${response[current_home].id}`;
            }
            output += `<div class='d-flex justify-content-center align-items-center col-xl-6 col-12 col-lg-6 p-0' id='movie-single-features-details'>
                <div id='movie-details-home'>
                    <div id='single-movie-details' class='text-white'><span>${response[current_home].release_year}&nbsp;&nbsp;|&nbsp;&nbsp;${category}&nbsp;&nbsp;|&nbsp;&nbsp;${part}</span></div>
                    <div id='movie-name-home'><span class='text-white'>${response[current_home].title}</span></div>
                    <div id='watch-movies-div'><a href='${path}'><button id='watch-movie'><i class='fa fa-play'></i>&nbsp;Watch now</button></a></div>
                </div><!--movie-details-home--->
                </div><!--movie-single-features-details-->
                <div class='d-flex justify-content-center align-items-center col-xl-6 col-12 col-lg-6  p-0' id='image-sliders'>
                <div id='image-slider-div' class='d-flex col-12 mt-5'>`;
                for(let i=0;i<response.length;i++){
                    output+=`<div data-index='${i}' class='image-card-movies `;
                    if(current_home == i) output+='current-slide';
                    output +=`'><img src='${response[i].thumbnail}' alt=''></div>`;
                }
                output += `</div>
                </div><!--image-sliders-->`;
                $('#home-glider').css('background-image','url("' + response[current_home].thumbnail + '")');
            $('#home-glider').html(output);
        }
    });
}

function getFirstEpisode(id,type){
    let response = $.ajax({
        url : "process/get-video.php",
        type : "POST",
        async : false,
        data : {id,type},
        success : function(data)
        {
            /* */
        }
    });
    return response.responseText;
}

$(document).on('click','.image-card-movies',function(){
    current_home = $(this).data('index');
    getHomeData();
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

// On change of the dropdown we get ajax request to filter data
$('.dropdown-movies').on('change',function(){
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let ratings = JSON.stringify(ratings_array);
    let category = JSON.stringify(categories_array);
    let search = $('#search_filter').val();
    let order = $(this).val();
    let type = $(this).data('type');
    let page_number = JSON.stringify(current_page);
    
    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,page_number,ratings},
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
    let ratings = JSON.stringify(ratings_array);
    let category = JSON.stringify(categories_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let page_number = JSON.stringify(current_page);

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,page_number,ratings},
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
    let ratings = JSON.stringify(ratings_array);
    let search = $('#search_filter').val();
    let category = JSON.stringify(categories_array);
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let page_number = JSON.stringify(current_page);

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,page_number,ratings},
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
    let ratings = JSON.stringify(ratings_array);
    let category = JSON.stringify(categories_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let page_number = JSON.stringify(current_page);

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,page_number,ratings},
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
    let ratings = JSON.stringify(ratings_array);
    let category = JSON.stringify(categories_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let page_number = JSON.stringify(current_page);

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,page_number,ratings},
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
// get data on rating tab
$(document).on('click','.rating-badge',function(){
    if(ratings_array.includes($(this).data('star')))
    {
        $(this).removeClass('active-rating');
        let removeItem = $(this).data('star');
        ratings_array = $.grep(ratings_array, function(value) {
            return value != removeItem;
            });
    }else{
        ratings_array.push($(this).data('star'));
        $(this).addClass('active-rating');
    }
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let ratings = JSON.stringify(ratings_array);
    let category = JSON.stringify(categories_array);
    let search = $('#search_filter').val();
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let page_number = JSON.stringify(current_page);

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,page_number,ratings},
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
$(document).on('click','.pagination-number',function(){
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let ratings = JSON.stringify(ratings_array);
    let search = $('#search_filter').val();
    let category = JSON.stringify(categories_array);
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let page_number = $(this).text();
    let curr_ele = $(this);
    current_page_number = page_number;

    $.ajax({
        url : "process/movie-filter.php",
        type : "GET",
        data : {search,letter,year,order,category,type,page_number,ratings},
        success : function(data)
        {
            curr_ele.parent().children().each(function(){
                $(this).removeClass('active-pagination');
            });
            curr_ele.addClass('active-pagination')
            if(type == 'movie')
            {
                addMovieCards(data,'pagination');
            }else{
                addWebseriesCards(data,'pagination');
            }
        }
    });
});
// Get the data on next button is clicked in pagination
$(document).on('click','.next',function(){
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let ratings = JSON.stringify(ratings_array);
    let search = $('#search_filter').val();
    let category = JSON.stringify(categories_array);
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let page_number = $(this).data('value');
    page_number = Number(page_number)+1;
    current_page_number = page_number;
    if(Number($(this).data('value')) < Number($('.pagination-number').length)){
        $.ajax({
            url : "process/movie-filter.php",
            type : "GET",
            data : {search,letter,year,order,category,type,page_number,ratings},
            success : function(data)
            {
                $('.pagination-number').parent().children().each(function(){
                    $(this).removeClass('active-pagination');
                });
                document.querySelectorAll('.pagination-number')[page_number-1].classList.add('active-pagination')
                if(type == 'movie')
                {
                    addMovieCards(data,'pagination');
                }else{
                    addWebseriesCards(data,'pagination');
                }
            }
        });
    }
});
// Get the data on previous button is clicked in pagination
$(document).on('click','.previous',function(){
    let letter = JSON.stringify(letters_array);
    let year = JSON.stringify(years_array);
    let ratings = JSON.stringify(ratings_array);
    let search = $('#search_filter').val();
    let category = JSON.stringify(categories_array);
    let order = $('.dropdown-movies').val();
    let type = $(this).data('type');
    let page_number = $(this).data('value');
    page_number = Number(page_number)-1;
    current_page_number = page_number;
    if(page_number >= 1){
        $.ajax({
            url : "process/movie-filter.php",
            type : "GET",
            data : {search,letter,year,order,category,type,page_number,ratings},
            success : function(data)
            {
                $('.pagination-number').parent().children().each(function(){
                    $(this).removeClass('active-pagination');
                });
                document.querySelectorAll('.pagination-number')[page_number-1].classList.add('active-pagination')
                if(type == 'movie')
                {
                    addMovieCards(data,'pagination');
                }else{
                    addWebseriesCards(data,'pagination');
                }
            }
        });
    }
});
// Main function to form the movies card
function addMovieCards(data,type=''){
    let output = '';
    let response = JSON.parse(data);
        if(response.length<1)
        {
            output += "<div class='mx-auto my-5'><span class='btn btn-primary'>No results found</span></div>";
            $('.pagination-holder').hide();
        }else{
            response.forEach((result,count)=>{
            if(count<response.length-1){
                let categories = result.category.split(',');
                let category2 = '';
                if(categories.length>1)
                    category2 = ','+categories[1];
                    output += `<div class='movie-card'>
                        <a href='movie.php?movie_id=${result.id}'><div class='movie-image'>
                            <img src='${result.thumbnail}'>
                        </div></a>
                        <div class='movie-info'>
                            <span>${result.release_year}&nbsp;&nbsp;|&nbsp;&nbsp;${categories[0]}${category2}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Part ${result.part}</span></span>
                            <span>${result.title}</span>
                        </div>
                    </div><!---movie-card-->`;
                }
            });
        $('.pagination-holder').show();
        }
        $('.all-movies-holder').html(output);
        $('.next').data('value',current_page_number);
        $('.previous').data('value',current_page_number);
        if(type == '' && type != 'pagination'){
            let pagination = '';
            $(".pagination-div").html('');
            if(response.length>1){
                current_page_number = 1;
                $('.next').data('value',current_page_number);
                $('.previous').data('value',current_page_number);
                for(let i=1;i<=response[response.length-1];i++) {
                    pagination+=`<span class='pagination-number ${(i==1)?"active-pagination":""}' data-type='movie'>${i}</span>`;
                }
                $(".pagination-div").html(pagination);
            }
        }

}
// Main function to form the webseries card
function addWebseriesCards(data,type=''){
    let output = '';
    let response = JSON.parse(data);
        if(response.length<1)
        {
            output += "<div class='mx-auto my-5'><span class='btn btn-primary'>No results found</span></div>";
            $('.pagination-holder').hide();
        }else{
            response.forEach((result,count)=>{
            if(count<response.length-1){
                let webseries = result.webseries;
                let categories = webseries.category.split(',');
                let category2 = '';
                if(categories.length>1)
                    category2 = ','+categories[1];
                output += `<div class='movie-card'>
                <a href='webseries.php?webseries_id=${webseries.id}'><div class='movie-image'>
                    <img src='${webseries.thumbnail}'>
                </div></a>
                    <div class='movie-info'>
                        <span>${webseries.release_year}&nbsp;&nbsp;|&nbsp;&nbsp;${categories[0]}${category2}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Season ${webseries.season_number}</span></span>
                        <span>${webseries.title}</span>
                    </div>
                </div><!---movie-card-->`;
            }
                    });
            $('.pagination-holder').show();
        }
        $('.all-movies-holder').html(output);
        $('.next').data('value',current_page_number);
        $('.previous').data('value',current_page_number);
        if(type == '' && type != 'pagination'){
            let pagination = '';
            $(".pagination-div").html('');
            if(response.length>1){
                current_page_number = 1;
                $('.next').data('value',current_page_number);
                $('.previous').data('value',current_page_number);
                for(let i=1;i<=response[response.length-1];i++) {
                    pagination+=`<span class='pagination-number ${(i==1)?"active-pagination":""}' data-type='webseries'>${i}</span>`;
                }
                $(".pagination-div").html(pagination);
            }
        }
}
// Add rating
$('#add-rating').on('change',function(){
    let video_id = $(this).data('video-id');
    let user_id = $(this).data('user-id');
    let type = $(this).data('type');
    let star = $(this).val();
    let comment = $(this).data('comment');
    addReview(user_id,video_id,type,star,comment,'change');
});

// Add rating
$('#add-rating-review').on('click',function(){
    let video_id = $(this).data('video-id');
    let user_id = $(this).data('user-id');
    let type = $(this).data('type');
    let star = $('#review-star').val();
    let comment = $("#review-comment").val();
    if(comment != '' && star != ''){
        addReview(user_id,video_id,type,star,comment,'click');
    }else{
        alert("Please provide a review and rating to continue!!!");
    }
});

function addReview(user_id,video_id,type,star,comment,action){
    $.ajax({
        url : "process/rating.php",
        type : "POST",
        data : {user_id,video_id,type,star,comment},
        success : function(data)
        {
            let result = JSON.parse(data);
            if(result == 'not-paid')
            {
                $('#plans').css('display','flex');
                get_pricing();
            }else if(result === 'not-loggedin')
            {
                $('#modal-register').fadeIn();
            }else{
                $('#total-stars').html(result[0]);
                $('#total-votes').html(result[1]+" vote");
                if($('#my-rating').hasClass('text-secondary'))
                    $('#my-rating').removeClass('text-secondary');
                $('#my-rating').addClass('add-rating');
                if(action == 'click'){
                    location.reload();
                }
            }
        },
        error : function(){
            $('#movie-single-banner').html("We are facing some issues resolve it soon");
        }
    });
}

// Add collapse
$('.collapsible').on("click", function() {
    let content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
});    

// Add toggle for menu
$(".review-menu-user-icon").on('click',()=>{
    $(".review-menu-dropdown").toggle();
});

// Make toggle the review section for edit
$(".edit-review").on('click',()=>{
    $(".review-menu-dropdown").hide();
    $(".content").show();
});

// delete the review
$(".delete-review").on('click',function(){
    let review_id = $(this).data('id');
    $.ajax({
        url : "process/rating.php",
        type : "POST",
        data : {review_id},
        success : function(data)
        {
            if(data == 1)
                location.reload();
        },
        error : function(){
            $('#movie-single-banner').html("We are facing some issues resolve it soon");
        }
    });
});