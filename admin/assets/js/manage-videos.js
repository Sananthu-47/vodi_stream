//Add category to the UI
let category_array = [];
//Add episode to the UI
let episode_array = [];
let episode_array_db = [];
//Add new episode to the UI
let episode_array_new = [];
let episode_array_new_db = [];

$(document).ready(function() {
    let search = (window.location.search).split('&')[0];
    if(search == '')
    {
        search = '?videos=add-movies';
    }

    if(search == '?videos=add-episodes')
    {
        $('#search-parts').click();
    }

    let video_index = checkCurrentTabVideos(search);
    $('#sub-nav').children().children()[video_index].classList.add('active-background');

});

function checkCurrentTabVideos(search){
    const videos_array = ['add-movies','live-movies','add-webseries','live-webseries','add-episodes','live-webseries-episodes'];
    let data='';
    videos_array.forEach(function(ele,i){
        if(search == '?videos='+ele)
            {
                data =  i;
            }
    });
    return data;
}

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

// Add movie to db
$(document).on('click','#publish-movie',function(e){
    e.preventDefault();
    let title = $('#movie-title').val();
    let age = $('#movie-age').val();
    let thumbnail = $('#movie-thumbnail').val();
    let description = $('#movie-description').val();
    let status = $('#movie-status').val();
    let year = $('#movie-year').val();
    let part = $('.movie-part:eq(1)').val();
    let part_1 = $(this).val();
    let movie_link = $('#movie-link').val();
    let movie_iframe = $('#movie-iframe').val();
    let duration = $('#movie-duration').val();
    let language = $('#movie-language').val();
    let director = $('#movie-director').val();
    let producer = $('#movie-producer').val();
    let action = 'publish';

    $.ajax({
        url : "../proccess/publish-movie.php",
        type : "POST",
        data : {title,age,thumbnail,description,status,year,part,part_1,movie_link,movie_iframe,duration,language,director,producer,category_array,action},
        success : function(data)
        {
            if(data=="success")
            {
                $('#live-movie').click();
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

// SELECT the part of the movie
$(document).on('change','.movie-part:eq(1)',function(){
    let selector = $(this).val();
    let part = selector - 1;
    let language = 0;
    let search = '';
    let type = $(this).data('type');

    if(selector != 1)
    {
        $('.part-selection-wrapper').css('display','flex');
        $.ajax({
            url : "../proccess/add-next-part-movie.php",
            type : "POST",
            data : {part,language,search,type},
            success : function(data)
            {
                getMoviesOnSearch(part,search,language,data,type);
            }
        });
    }else{
        $('.add-to-db').val('0');
    }
});

// SELECT the part of the seasons
$(document).on('change','.webseries-episode-part',function(){
    let part = $(this).val();
    let language = 0;
    let search = '';
    let type = $(this).data('type');

    if(part != 0)
    {
        $('.part-selection-wrapper-episode').css('display','flex');
        $.ajax({
            url : "../proccess/add-next-part-movie.php",
            type : "POST",
            data : {part,language,search,type},
            success : function(data)
            {
                getMoviesOnSearch(part,search,language,data,type);
            }
        });
    }else{
        $('.add-to-db').val('0');
    }
});

// Change the part of the movie
$(document).on('click','#search-parts',function(){
    let part = $('.movie-part:eq(0)').val();
    let search = $('#search-part-title').val();
    let language = $('#language').val();
    let type = $(this).data('type');
        $('.part-selection-wrapper').css('display','flex');
        $.ajax({
            url : "../proccess/add-next-part-movie.php",
            type : "POST",
            data : {part,search,language,type},
            success : function(data)
            {
                getMoviesOnSearch(part,search,language,data,type);
            }
        });
});

// Get all movies while on change or search of button and show in UI 
function getMoviesOnSearch(part,search,language,data,type){
        let output = '';
        let response = JSON.parse(data);
        $('#part-number').text(`'${(part==0)? 'Any':part}' > search '${(search==0)? ' ':search}' > language '${(language==0)? 'All':language}'`);
        $('.movie-part:eq(0)').val(part);
        
        if(response.length > 0)
        {
            if(type == 'movie')
            {
                response.forEach((element) => {
                    let data_id = (element.part_1_id==0)? element.id : element.part_1_id;
                    output += `<div class='movie-card' data-type='movie' data-id='${data_id}'>
                            <div class='movie-image'>
                                <img src='${element.thumbnail}'>
                            </div>
                            <div class='movie-info'>
                                <span>${element.language}</span>
                                <span>${element.title} (part ${element.part})</span>
                            </div>
                        </div><!---movie-card-->`;
                });
            }else if(type == 'webseries')
            {
                response.forEach((element) => {
                    let data_id = (element.part_1_id==0)? element.id : element.part_1_id;
                    output += `<div class='movie-card' data-type='webseries' data-id='${data_id}'>
                            <div class='movie-image'>
                                <img src='${element.thumbnail}'>
                            </div>
                            <div class='movie-info'>
                                <span>${element.language}</span>
                                <span>${element.title} (season ${element.season_number})</span>
                            </div>
                        </div><!---movie-card-->`;
                });
            }else if(type == 'episode')
            {
                response.forEach((element) => {
                    output += `<div class='movie-card' data-type='episode' data-id='${element.id}'>
                            <div class='movie-image'>
                                <img src='${element.thumbnail}'>
                            </div>
                            <div class='movie-info'>
                                <span>${element.language}</span>
                                <span>${element.title} (season ${element.season_number})</span>
                            </div>
                        </div><!---movie-card-->`;
                });
            }
        }else{
            output += `<div class='my-auto'>
            <span class='btn btn-primary'>No search result found</span>
            </div>`;
        }
        $('.all-movies-holder').html(output);
}

// Close the modal opened for parts
$(document).on('click','#close-parts',function(){
    clearFiled();
});

// Close the modal opened for parts
$(document).on('click',function(e){
    if(e.target.classList.contains('part-selection-wrapper'))
    {
        clearFiled();
    }
});

// Clear the field after closing movies modal
function clearFiled() {
        $('.part-selection-wrapper').css('display','none');
        $('.part-selection-wrapper-episode').css('display','none');
        $('.movie-part:eq(0)').val('0');
        $('#search-part-title').val('');
        $('#language').val('0');
}

$(document).on('click',('.movie-card'),function(){
    let movie_id = $(this).data('id');
    let type = $(this).data('type');
    $.ajax({
        url : "../proccess/get-movie-data.php",
        type : "POST",
        data : {movie_id,type},
        success : function(data)
        {
            category_array = [];
            if(type == 'movie')
            {
                getMovieBasedOnClick(data,movie_id);
            }else if(type == 'webseries')
            {
                getWebseriesBasedOnClick(data,movie_id);
            }else if(type == 'episode')
            {
                getWebseriesEpisodeBasedOnClick(data,movie_id);
            }
        }
    });
});

function getMovieBasedOnClick(data,part_1){
    let output = '';
    let response = JSON.parse(data);

    $('#movie-title').val(response[0].title);
    $('#movie-age').val(response[0].age);
    $('#movie-thumbnail').val(response[0].thumbnail);
    $('#movie-description').val(response[0].description);
    $('#movie-status').val(response[0].status);
    $('#movie-year').val(response[0].release_year);
    $('#movie-duration').val(response[0].duration);
    $('#movie-language').val(response[0].language);
    $('#publish-movie').val(part_1);
    response[1].forEach(ele=>{
        category_array.push(ele.category);
    });
    category_array.forEach((ele,i)=>{
        output += "<div class='category-tags'><span>"+ele+"</span><i class='fa fa-times delete-category'></i></div>";
    });
    $('.selected-categories').html(output);
    $('.selected-categories').css('display','flex');
    clearFiled();
}

function getWebseriesBasedOnClick(data,part_1){
    let output = '';
    let response = JSON.parse(data);

    $('#webseries-title').val(response[0].title);
    $('#webseries-age').val(response[0].age);
    $('#webseries-thumbnail').val(response[0].thumbnail);
    $('#webseries-description').val(response[0].description);
    $('#webseries-status').val(response[0].status);
    $('#webseries-year').val(response[0].release_year);
    $('#webseries-duration').val(response[0].duration);
    $('#webseries-language').val(response[0].language);
    $('#publish-webseries').val(part_1);
    response[1].forEach(ele=>{
        category_array.push(ele.category);
    });
    category_array.forEach((ele,i)=>{
        output += "<div class='category-tags'><span>"+ele+"</span><i class='fa fa-times delete-category'></i></div>";
    });
    $('.selected-categories').html(output);
    $('.selected-categories').css('display','flex');
    clearFiled();
}

function getWebseriesEpisodeBasedOnClick(data,part_1){
    let response = JSON.parse(data);
    let output = '';
    $('.webseries-episode-part').val(response[0].season_number);
    $('.added-episodes').css('display','flex');
    episode_array = [];
    episode_array_db = [];
    episode_array_new = [];
    episode_array_new_db = [];

        response[2].forEach(ele=>{
            episode_array.push(ele.episode.episode_number);
            episode_array_db.push({'episode':ele.episode.episode_number,'link':ele.episode.link,'iframe':ele.episode.iframe,'title':ele.episode.title,'description':ele.episode.description,'thumbnail':ele.episode.thumbnail,'year':ele.episode.release_year,'duration':ele.episode.duration,'season':ele.episode.season_number});
        });
        episode_array.forEach((ele,i)=>{
            output += "<div class='category-tags'><span>Episode "+ele+"</span></div>";
        });

    $('.added-episodes').html(output);
    $('#webseries-title').val(response[0].title);
    $('#publish-new-episodes').val(part_1);
    clearFiled();
}

$(document).on('click','#add-episode',function(e){
    let output = '';
    e.preventDefault();
    let link = $('#webseries-link').val();
    let iframe = $('#webseries-iframe').val();
    let title = $('#episode-title').val();
    let episode = $('#webseries-episode').val();
    let description = $('#episode-description').val();
    let thumbnail = $('#episode-thumbnail').val();
    let year = $('#episode-year').val();
    let duration = $('#episode-duration').val();
    let season = $('.movie-part:eq(1)').val();
    
    if(!episode_array.includes(episode))
    {
        if(check_before_episode_add(link,iframe,title,episode,description,thumbnail,year,duration))
        {
            episode_array.push(episode);
            episode_array_db.push({'episode':episode,'link':link,'iframe':iframe,'title':title,'description':description,'thumbnail':thumbnail,'year':year,'duration':duration,'season':season});
            $('.added-episodes').css('display','flex');
            episode_array.forEach((ele,i)=>{
                output += "<div class='category-tags'><span>Episode "+ele+"</span><i class='fa fa-times delete-episode' data-episode-id='";
                output += episode_array_db[i].episode;
                output+="'></i></div>";
            });
            $('.added-episodes').html(output);
            $('#webseries-episode').val(0);
            $('#webseries-link').val('');
            $('#webseries-iframe').val('');
            $('#episode-title').val('');
            $('#episode-description').val('');
            $('#episode-thumbnail').val('');
            $('#episode-year').val('');
            $('#episode-duration').val('');
        }
    }else{
        alert('Episode '+episode+" is already added");
    }
});


// Add new episodes to the episodes array 
$(document).on('click','#add-new-episode',function(e){
    let output = '';
    e.preventDefault();
    let link = $('#webseries-link').val();
    let iframe = $('#webseries-iframe').val();
    let title = $('#episode-title').val();
    let episode = $('#webseries-episode').val();
    let description = $('#episode-description').val();
    let thumbnail = $('#episode-thumbnail').val();
    let year = $('#episode-year').val();
    let duration = $('#episode-duration').val();
    let season = $('.webseries-episode-part').val();
    
    if(!episode_array.includes(episode) && !episode_array_new.includes(episode))
    {
        if(check_before_episode_add(link,iframe,title,episode,description,thumbnail,year,duration))
        {
            episode_array_new.push(episode);
            episode_array_new_db.push({'episode':episode,'link':link,'iframe':iframe,'title':title,'description':description,'thumbnail':thumbnail,'year':year,'duration':duration,'season':season});
            $('.added-episodes').css('display','flex');
                output += `<div class='category-tags'><span>Episode ${episode}</span><i class='fa fa-times delete-new-episode' data-episode-id='${episode}'></i></div>`;
            $('.added-episodes').append(output);
            $('#webseries-episode').val(0);
            $('#webseries-link').val('');
            $('#webseries-iframe').val('');
            $('#episode-title').val('');
            $('#episode-description').val('');
            $('#episode-thumbnail').val('');
            $('#episode-year').val('');
            $('#episode-duration').val('');
        }
    }else{
        alert('Episode '+episode+" is already added");
    }
});

function check_before_episode_add(link,iframe,title,episode,description,thumbnail,year,duration) {
    const element_array = [$('#webseries-link'),$('#webseries-iframe'),$('#episode-title'),$('#webseries-episode'),$('#episode-description'),$('#episode-thumbnail'),$('#episode-year'),$('#episode-duration')];
    let count = 0;

    element_array.forEach(ele=>{
        ele.css('border-color','#b9b9b9');
    });

    if(link=='' && iframe=='')
    {
        element_array[0].css('border-color','red');
        element_array[1].css('border-color','red');
        count++;
    }
    if(title==''){
        element_array[2].css('border-color','red');
        count++;
    }
    if(episode==0){
        element_array[3].css('border-color','red');
        count++;
    }
    if(description==''){
        element_array[4].css('border-color','red');
        count++;
    }
    if(thumbnail==''){
        element_array[5].css('border-color','red');
        count++;
    }
    if(year==''){
        element_array[6].css('border-color','red');
        count++;
    }
    if(duration==''){
        element_array[7].css('border-color','red');
        count++;
    }
    if(count<1)
    {
        return true;
    }
}

// Remove selected episodes from array and UI
$(document).on('click','.delete-episode',function(e){
    $(this).parent().remove();
        let removeItemDb = $(this).data('episode-id');
                episode_array_db = $.grep(episode_array_db, function(value) {                    
                return value.episode != removeItemDb;
                });

        let removeItem = $(this).data('episode-id');
                episode_array = $.grep(episode_array, function(value) {
                return value != removeItem;
                });
            if(episode_array.length<1)
                {
                    $('.input-selected-tags').css('display','none');
                }
});

// Remove selected new episodes from array and UI
$(document).on('click','.delete-new-episode',function(e){
    $(this).parent().remove();
        let removeItemDb = $(this).data('episode-id');
                episode_array_new_db = $.grep(episode_array_new_db, function(value) {                    
                return value.episode != removeItemDb;
                });

        let removeItem = $(this).data('episode-id');
                episode_array_new = $.grep(episode_array_new, function(value) {
                return value != removeItem;
                });
});

// Add webseries to db
$(document).on('click','#publish-webseries',function(e){
    e.preventDefault();
    let title = $('#webseries-title').val();
    let age = $('#webseries-age').val();
    let thumbnail = $('#webseries-thumbnail').val();
    let description = $('#webseries-description').val();
    let status = $('#webseries-status').val();
    let year = $('#webseries-year').val();
    let season = $('.movie-part:eq(1)').val();
    let language = $('#webseries-language').val();
    let part_1 = $(this).val();
    let episodes = JSON.stringify(episode_array_db);
    let action = 'publish';

    $.ajax({
        url : "../proccess/publish-webseries.php",
        type : "POST",
        data : {title,season,part_1,age,thumbnail,description,status,year,language,category_array,episodes,action},
        success : function(data)
        {
            if(data=="episode")
            {
                const element_array = [$('#webseries-link'),$('#webseries-iframe'),$('#episode-title'),$('#webseries-episode'),$('#episode-description'),$('#episode-thumbnail'),$('#episode-year'),$('#episode-duration')];
                element_array.forEach(ele=>{
                    ele.css('border-color','red');
                });
                alert('Add atleast 1 episode before publishing');
            }else
            if(data=="success")
            {
                $('#live-webseries').click();
            }else{
                check_add_webseries(data);
            }
        }
    });
});

// Add publish-new-episodes to db
$(document).on('click','#publish-new-episodes',function(e){
    e.preventDefault();
    let part_1 = $(this).val();
    let episodes = JSON.stringify(episode_array_new_db);
    let action = 'publish';

    $.ajax({
        url : "../proccess/publish-new-episodes.php",
        type : "POST",
        data : {part_1,episodes,action},
        success : function(data)
        {
            if(data=="episode")
            {
                const element_array = [$('#webseries-link'),$('#webseries-iframe'),$('#episode-title'),$('#webseries-episode'),$('#episode-description'),$('#episode-thumbnail'),$('#episode-year'),$('#episode-duration')];
                element_array.forEach(ele=>{
                    ele.css('border-color','red');
                });
                alert('Add atleast 1 new episode before publishing');
            }else
            if(data=="success")
            {
                $('#live-webseries-episodes').click();
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
// Make the movie active
$(document).on('click','.make-movie-active',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'movie-active';
    
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

// Make the movie blocked
$(document).on('click','.make-movie-blocked',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'movie-block';
    
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

// Make the webseries active
$(document).on('click','.make-webseries-active',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'webseries-active';
    
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

// Make the webseries blocked
$(document).on('click','.make-webseries-blocked',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'webseries-block';
    
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

// Make the webseries episode active
$(document).on('click','.make-episode-active',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'episode-active';
    
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

// Make the webseries episode blocked
$(document).on('click','.make-episode-blocked',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'episode-block';
    
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

// Make the movie deleted
$(document).on('click','.make-movie-delete',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'movie-delete';
    if(confirm("Do you want to delete this movie?"))
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

// Make the webseries deleted
$(document).on('click','.make-webseries-delete',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'webseries-delete';
    if(confirm("Do you want to delete this webseries?"))
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

// Make the webseries episode deleted
$(document).on('click','.make-webseries-episode-delete',function(){
    let id = $(this).data('id');
    let current_element = $(this);
    let action = 'webseries-episode-delete';
    if(confirm("Do you want to delete this episode?"))
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