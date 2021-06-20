let category_array_old = [];
let category_array= [];

$(document).on('click','#video-link',function(){
    $('#video-iframe').removeClass('current-link');
    $(this).addClass('current-link');
    $('.vedio-link-tab').removeClass('d-none');
    $('.vedio-iframe-tab').addClass('d-none');
});

$(document).on('click','#video-iframe',function(){
    $('#video-link').removeClass('current-link');
    $(this).addClass('current-link');
    $('.vedio-link-tab').addClass('d-none');
    $('.vedio-iframe-tab').removeClass('d-none');
});

$(document).ready(function(){
    let output = '';
    $('.selected-categories').css('display','flex');
    // Get all categories name
    let category_name = $('.all-categories-name').text().split(',');
    category_name.forEach(ele => {
        if(ele != '')
        {
            category_array_old.push(ele);
        }
    });

    category_array = category_array_old.slice();

        category_array.forEach((ele,i)=>{
        output += "<div class='category-tags'><span>"+ele+"</span><i class='fa fa-times delete-category'></i></div>";
    });

    $('.selected-categories').html(output);
});

$(document).on('click','#add-category',function(e){
    let output = '';
    e.preventDefault();
    let category = String($('#category-select option:selected').text());
    
    if(!category_array.includes(category))
    {
        if($('#category-select').val() != 0)
        {
            category_array.push(category);
            $('.selected-categories').css('display','flex');
        }else{
            alert('Select a category before adding');
        }
    }else{
        alert('Category '+category+" is already added");
    }
    category_array.forEach((ele,i)=>{
        output += "<div class='category-tags'><span>"+ele+"</span><i class='fa fa-times delete-category'></i></div>";
    });
    $('.selected-categories').html(output);
    $('#category-select').val(0);
});

// Remove selected categories from array and UI
$(document).on('click','.delete-category',function(e){
    $(this).parent().remove();
        let removeItem = $(this).parent().children()[0].innerText;
                category_array = $.grep(category_array, function(value) {
                return value != removeItem;
                });
            if(category_array.length<1)
                {
                    $('.input-selected-tags').css('display','none');
                }
});

// Update movie to db
$(document).on('click','#update-movie',function(e){
    e.preventDefault();
    let title = $('#movie-title').val();
    let id = $(this).data('id');
    let age = $('#movie-age').val();
    let thumbnail = $('#movie-thumbnail').val();
    let description = $('#movie-description').val();
    let status = $('#movie-status').val();
    let year = $('#movie-year').val();
    let part = $('.movie-part').val();
    let part_1 = $(this).val();
    let movie_link = $('#movie-link').val();
    let movie_iframe = $('#movie-iframe').val();
    let duration = $('#movie-duration').val();
    let language = $('#movie-language').val();
    let director = $('#movie-director').val();
    let producer = $('#movie-producer').val();
    let action = 'update';

    $.ajax({
        url : "../proccess/publish-movie.php",
        type : "POST",
        data : {id,title,age,thumbnail,description,status,year,part,part_1,movie_link,movie_iframe,duration,language,director,producer,category_array,action},
        success : function(data)
        {
            if(data=="success")
            {
                window.location.href='./../pages/admin-managevideos.php?videos=live-movies';
            }else{
                check_add_movies(data);
            }
        }
    });
});

// Validate the data to check any empty form fields
function check_add_movies(data){
    let data_array = JSON.parse(data);
    const element_array = [$('#movie-title'),$('#movie-age'),$('#movie-thumbnail'),$('#movie-description'),$('#movie-status'),$('#movie-year'),$('.movie-part'),$('#movie-link'),$('#movie-iframe'),$('#movie-duration'),$('#movie-language'),$('#category-select')];

    element_array.forEach(ele=>{
        ele.css('border','1px solid #b9b9b9');
    });
    
    data_array.forEach((ele)=>{
        element_array[ele].css('border','1px solid red');
    });
}


// Add webseries to db
$(document).on('click','#update-webseries',function(e){
    e.preventDefault();
    let title = $('#webseries-title').val();
    let age = $('#webseries-age').val();
    let id = $(this).data('id');
    let thumbnail = $('#webseries-thumbnail').val();
    let description = $('#webseries-description').val();
    let status = $('#webseries-status').val();
    let year = $('#webseries-year').val();
    let end_year = $('#webseries-end').val();
    let season = $('.movie-part').val();
    let language = $('#webseries-language').val();
    let part_1 = $(this).val();
    let episodes = 'done';
    let action = 'update';

    $.ajax({
        url : "../proccess/publish-webseries.php",
        type : "POST",
        data : {id,title,season,part_1,age,thumbnail,description,status,year,language,category_array,episodes,action,end_year},
        success : function(data)
        {
            if(data=="success")
            {
                window.location.href='./../pages/admin-managevideos.php?videos=live-webseries';
            }else{
                check_add_webseries(data);
            }
        }
    });
});

// Validate the data to check any empty form fields
function check_add_webseries(data){
    let data_array = JSON.parse(data);
    const element_array = [$('#webseries-title'),$('#webseries-age'),$('#webseries-thumbnail'),$('#webseries-description'),$('#webseries-status'),$('#webseries-year'),$('#webseries-language'),$('#category-select')];

    element_array.forEach(ele=>{
        ele.css('border','1px solid #b9b9b9');
    });
    
    data_array.forEach((ele)=>{
        element_array[ele].css('border','1px solid red');
    });
}