let added_ads_array = [];
let new_ads_array = [];

$(document).ready(function() {
    let search = window.location.search.split('&')[0];
    if(search == '')
    {
        search = '?advertisement=ads-list';
    }

    let advertisement_index = checkCurrentTabAds(search);
    $('#sub-nav').children().children()[advertisement_index].classList.add('active-background');

    let selected_video = $('#selected-video').val();
    if(selected_video != '' && selected_video != undefined){
        let type = $('#selected-video').data('type');
        let video_id = $('#selected-video').data('id');
        get_advertisements(video_id,type);
    }

});

function checkCurrentTabAds(search){
    const ads_array = ['ads-list','add-ads'];
    let data='';
    ads_array.forEach(function(ele,i){
        if(search == '?advertisement='+ele)
            {
                data =  i;
            }
    });
    return data;
}

// Edit toogle button
$(".edit").click(function() {
    let id = $(this).data('id');
    if($("#"+id).hasClass("hide")) {
        $("#"+id).addClass("show");
        $("#"+id).removeClass("hide");
    } else {
        $("#"+id).addClass("hide");
        $("#"+id).removeClass("show");
    }
});

// SELECT the part of the movie
$(document).on('change','#video-type',function(){
    let part = 1;
    let language = 0;
    let search = '';
    let type = $(this).val();
    $('.movie-part').data('type',type);
    $('#search-parts').data('type',type);

    if(type != 0)
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
    }
});

// Change the part of the movie
$(document).on('click','#search-parts',function(){
    let part = $('.movie-part').val();
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
    $('.movie-part').val(part);
    
    if(response.length > 0)
    {
        if(type == 'movie')
        {
            response.forEach((element) => {
                let data_id = (element.part_1_id==0)? element.id : element.part_1_id;
                output += `<div class='movie-card' data-name='${element.title}' data-type='movie' data-id='${data_id}'>
                        <div class='movie-image'>
                            <img src='${element.thumbnail}'>
                        </div>
                        <div class='movie-info'>
                            <span>${element.language}</span>
                            <span>${element.title} (part ${element.part})</span>
                        </div>
                    </div><!---movie-card-->`;
            });
        }else if(type == 'ad-episode')
        {
            response.forEach((element) => {
                output += `<div class='movie-card webseries' data-name='${element.title}' data-type='episode' data-id='${element.id}'>
                        <div class='movie-image'>
                            <img src='${element.thumbnail}'>
                        </div>
                        <div class='movie-info'>
                            <span>${element.language}</span>
                            <span>${element.title} (S0${element.season_number}E0${element.episode_number})</span>
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

// SELECT the part of the movie
$(document).on('change','.movie-part',function(){
    let part = $(this).val();
    let language = $('#language').val();
    let search = $('#search-part-title').val();
    let type = $(this).data('type');

    if(part != 0)
    {
        $.ajax({
            url : "../proccess/add-next-part-movie.php",
            type : "POST",
            data : {part,language,search,type},
            success : function(data)
            {
                getMoviesOnSearch(part,search,language,data,type);
            }
        });
    }
});

// Select the desired video to add advertisement
$(document).on('click','.movie-card',function(){
    let video_id = $(this).data('id');
    let type = $(this).data('type');
    let name = $(this).data('name');
    $('#selected-video').val(name);
    $('#selected-video').data('id',video_id);
    $('#selected-video').data('type',type);
    get_advertisements(video_id,type);
});

// Get all the previous added advertisements
function get_advertisements(video_id,type){
    $.ajax({
        url : "../proccess/admin-get-advertisements.php",
        type : "POST",
        data : {video_id,type},
        success : function(data)
        {
            added_ads_array = [];
            new_ads_array = [];
            let response = JSON.parse(data);
            response.forEach(ele=>{
                added_ads_array.push(ele);
                new_ads_array.push(ele);
            });
            clearFiled();
            show_all_added_ads(new_ads_array);
        }
    });
}

// Show all the previous added ads
function show_all_added_ads(new_ads_array){
    $("#all-advertisements").html('');
    if(new_ads_array.length > 0){
        $("#added-advertisements").show();
        new_ads_array.forEach((ele,index)=>{
            $("#all-advertisements").append(`<div class='category-tags justify-content-between'><span style='word-break:break-all;'> <span class='badge badge-light badge-pill'>${index+1}</span> ${ele.link}</span><i class='fa fa-times delete-advertisement btn btn-info cursor-pointer' data-id='${ele.id}'></i></div>`);
        });
    }else{
        $("#added-advertisements").hide();
    }
}

// Add new advertisements to array
$('#add-advertisement').on('click',function(){
    let type = $('#selected-video').data('type');
    let video_id = $('#selected-video').data('id');
    let link = $('#link').val();
    if(type != ''){
        if(link != ''){
            if(new_ads_array.length < 20){
                new_ads_array.push({"id":"new"+new_ads_array.length,"video_id":video_id,"video_type":type,"link":link});
                show_all_added_ads(new_ads_array);
            }else{
                alert("Only 20 ads can be added to a video!!!");
            }
        }else{
            alert("Please enter a proper link to add it");
            $('#link').focus();
        }
    }else{
        alert("Please choose a video to which you want to add an ad");
        $("#video-type").focus();
    }
    $("#link").val('');
});

// Delete adevertisement from array
$(document).on('click','.delete-advertisement',function(){
    let id = $(this).data('id');

                new_ads_array = $.grep(new_ads_array, function(value) {
                return value.id != id;
                });
                show_all_added_ads(new_ads_array);
            if(new_ads_array.length<1)
                {
                    $('.input-selected-tags').css('display','none');
                }
});

// Add the advertisement to backend
$("#submit-advertisement").on('click',function(e){
    e.preventDefault();
    $.ajax({
        url : "../proccess/publish-advertisement.php",
        type : "POST",
        data : {added_ads_array,new_ads_array},
        success : function(data)
        {
            if(data == 1){
                alert("Advertisement added successfully");
                location.reload();
            }else if(data == 2){
                alert("Advertisement list updated successfully");
                location.reload();
            }else{
                alert("No data changed");
            }
        }
    });
});

// Close the modal opened for parts
$(document).on('click','#close-parts',clearFiled);

// Clear the field after closing movies modal
function clearFiled() {
        $('.part-selection-wrapper').css('display','none');
        $('.part-selection-wrapper-episode').css('display','none');
        $('.movie-part').val('0');
        $('#search-part-title').val('');
        $('#language').val('0');
}

// Delete the advertisement from backend
$(".admin-delete-advertisement").on('click',function(e){
    let action = "delete-advertisement";
    let id = $(this).data('id');
    let count = $(this).data('count');
    let curr_ele = $(this);
    $.ajax({
        url : "../proccess/make-action.php",
        type : "POST",
        data : {id,action},
        success : function(data)
        {
            if(curr_ele.parent().parent().children().length <= 1){
                $(".tr-"+count).remove();
                $("#collapse-"+count).remove();
                alert("This video is now Ad free");
            }
            curr_ele.parent().remove();
            let tot_add = Number($("#tot-ad-"+count).text()) - 1;
            $("#tot-ad-"+count).text(tot_add);
        }
    });
            
});