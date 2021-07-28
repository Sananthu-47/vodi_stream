<style>
    .plyr , .plyr__video-embed{
        width: 100% !important;
        height: 100% !important;
    }
    .js-player-ad {
        position: absolute;
        width: 5px;
        height: 5px;
        background-color: white;
        border-radius: 50%;
        top: 7px;
    }
    #ad-skip-wrapper{
        position: absolute;
        display: flex;
        right: 2%;
        bottom: 2%;
        background-color: rgba(255,255,255,0.6);
        border: 2px solid white;
        text-align: center;
        color: black;
        padding: 5px 2px;
        max-width: 100px;
    }
    #ad-text{
        cursor: pointer;
        font-size: 12px;
    }
    #ad-timer{
        font-size: 12px;
    }
</style>
<?php
include_once "Classes/User.php";
$User = new User($connection);
include_once "Classes/Movie.php";
$Movie = new Movie($connection);
include_once "Classes/Advertisement.php";
$Advertisement = new Advertisement($connection);
include_once "Classes/Rating.php";
include_once "Classes/Dashboard.php";
$Dashboard = new Dashboard($connection);
$Rating = new Rating($connection);
if($Rating->checkUserRated($movie_id,$USER_LOGIN_ID,'movie')){
    $rating_row = false;
}else{
    $rating_row = $Rating->getRatedDetails($movie_id,$USER_LOGIN_ID,'movie');
    $rating_row = mysqli_fetch_assoc($rating_row);
}
$ratings = $Rating->calculateTotRating($movie_id,'movie');
$movie_name = $Movie->get_movie_by_id_and_search('title',$movie_id);
$poster = $Movie->get_movie_by_id_and_search('thumbnail',$movie_id);
?>

<div class="web-navigation d-flex">
    <span>
        <a href='index.php'>Home</a> 
        <i class='fa fa-angle-right'></i>
        <a href='all-movies.php'>Movies</a> 
        <i class='fa fa-angle-right'></i> 
        <?php echo $movie_name; ?>
    </span>
</div>

<div id="movie-single-banner" class='m-0 row'>
    <video controls poster='<?php echo $poster; ?>' id='player'>
        <source id='video-source' preload='none' src='' type='video/webm' >
    </video>

    <?php 
    $src = '';
    $video_type = '';
    $user_type = '';
    $ads_array = [];
    if($USER_LOGIN_ID != '')
    {
        $user_type = $User->check_account_is_premium($USER_LOGIN_ID);
        $check_free_or_not = $Dashboard->check_free_or_not('movies',$movie_id);
       if($check_free_or_not == 'free' || $user_type === false)
       {
          if($Movie->get_movie_by_id_and_search('iframe',$movie_id) != '')
             {
                $src = $Movie->get_movie_by_id_and_search('iframe',$movie_id);
                $video_type = 'iframe';
             }else{
                $src =  $Movie->get_movie_by_id_and_search('link',$movie_id);
                $video_type = 'link';
             }
             $advertisement = $Advertisement->get_advertisement_to_video($movie_id,'movie');
             while($row = mysqli_fetch_assoc($advertisement)){
                 array_push($ads_array,$row);
             }
       }else{
          $src = "not-paid";
       }
    }else{
        $src = "not-loggedin";
    }
    ?>
    
</div><!--image-banner--->

<div id='advertisement-wrapper' style='display : none;position: relative;'>
    <span class="badge badge-warning" id="ad-badge" style="
        position: absolute;
        top: 2%;
        right: 5%;
        padding: 5px 10px;
        z-index: 2;
    ">Ad</span>
    <video autoplay src='' id='player-ad'></video>
    <div id="ad-skip-wrapper">
        <div id="ad-timer"></div>
        <div id="ad-text"></div>
    </div>
</div>

<script>
    const player = new Plyr('#player');
    let src = '<?php  echo $src ?>'; // Get the video sorce or playable or non playable
    let user_type = '<?php  echo $user_type ?>'; // User pro or not
    let ads_array = <?php echo json_encode($ads_array); ?>; // Get all the ads from the backend to show it in frontend
    let timeInterval = null; // Interval to check whether to play ad or not
    let total_ads = ads_array.length; // Check how many ads are associated with the video
    let ad_count = 0; // Check which ad was played previously
    let adTimer; // Timer to skip ad
    let adsPlayedEvery = 15 * 60; // Ads are played every 15 mins

    $(document).on('click','#watch-movie',function(){
        $('.full-size').scrollTop(0);
        if(player.duration > 1){
            player.play();
        }
    });
    
    // Check the user is logged in and pro account or not
    player.on('play',function(){
        if(src == 'not-paid')
        {
            $('.planings').click();
        }else if(src == 'not-loggedin')
        {
            $('#modal-register').show();
        }
    });

    // If the user is loogged in and check the video is youtube or video link
    if(src != '' && src != 'not-paid' && src != 'not-loggedin'){
        if('<?php echo $video_type; ?>' == 'link'){
            player.source = {
            type: 'video',
            title: `<?php echo $movie_name; ?>`,
            sources: [
                {
                src: "<?php echo $src; ?>",
                type: 'video/mp4'
                }
            ],
            poster: '<?php echo $poster; ?>'
            };
        }else if('<?php echo $video_type; ?>' == 'iframe'){
            player.source = {
            type: 'video',
            title: `<?php echo $movie_name; ?>`,
            sources: [
                {
                src: src,
                provider: 'youtube',
                }
            ],
            poster: '<?php echo $poster; ?>'
            };
        }
    }

    // Check the ad is ended or not
    $('#player-ad').on('ended',function(){
        player.play();
        $('#movie-single-banner').toggle();
        $("#advertisement-wrapper").toggle();
        if(ad_count == total_ads - 1){
            ad_count = 0;
        }else{
            ad_count++;
        }
        $("#ad-text").removeClass('ad-skip');
        clearInterval(adTimer);
        setTimeout(() => {
            intervalManager(true);
        }, 1000);
    });

    // Play the ad makes sure to check whether to skip is placed or not
    $('#player-ad').on('play',function(){
        let total_ad_timer = Math.floor(document.getElementById("player-ad").duration);
        let count = 15;
        let fast_forward = "<i class='fa fa-fast-forward'></i>";
        if(total_ad_timer >= 15){
            $("#ad-timer").text('');
            $("#ad-text").text('');
            $("#ad-timer").show();
            adTimer = setInterval(() => {
                if(count < 1){
                    clearInterval(adTimer);
                    $("#ad-text").html('Skip '+ fast_forward);
                    $("#ad-text").addClass('ad-skip');
                    $("#ad-timer").hide();
                }
                $("#ad-timer").text('Skip in '+ count-- +' sec');
            }, 1000);
        }else{
            $("#ad-text").text('Video will play after Ad');
        }
    });

    // If skip add is pressed the video is skipped
    $("#ad-text").on('click',function(){
        if($(this).hasClass('ad-skip')){
            document.getElementById("player-ad").currentTime = document.getElementById("player-ad").duration;
        }
    });

    // Get all the make an array to show all the ads in video
    function getPoints(totalAdsCue){
        let temp = [];
        for(let i = 1; i <= totalAdsCue; i++){
            temp.push(i * adsPlayedEvery);
        }
        return temp;
    }

    // Show an indicator for ads in player control
    function adCueForAds(adCuePointsArray,totalAdsCue){
        for (i = 0; i < totalAdsCue; i++) {
            let elem = document.createElement("div");
            elem.className = "js-player-ad";
            elem.style.left = adCuePointsArray[i] / player.duration * 100 + "%";
            document.querySelector('.plyr__progress').appendChild(elem);
        }
    }

    // Check the video whether has ad or not to show
    player.once('play',()=>{
        if(total_ads > 0 && user_type != false){
            let totalAdsCue = Math.floor(player.duration / adsPlayedEvery);
            let adCuePointsArray = getPoints(totalAdsCue);
            adCueForAds(adCuePointsArray,totalAdsCue);
            player.pause();
            $('#movie-single-banner').toggle();
            $("#advertisement-wrapper").toggle();
            $("#player-ad").attr('src',ads_array[ad_count].link);
        }
    });

    // This function shows the ads every 15mins interval
    function intervalManager(flag){
        if(flag){
            timeInterval = setInterval(() => {
                // Convert minute to seconds to add the advertisements 
                // example: If the duration of ad is being played for every 10mins
                // Then 15 min * 60 sec = 900 seconds
                if(Math.round(player.currentTime) % adsPlayedEvery === 0 && Math.round(player.currentTime) != 0)
                {
                    if(total_ads > 0 && user_type != false){
                        player.pause();
                        $('#movie-single-banner').toggle();
                        $("#advertisement-wrapper").toggle();
                        $("#player-ad").attr('src',ads_array[ad_count].link);
                        intervalManager(false);
                    }
                }
            }, 1000);
        }else{
            clearInterval(timeInterval);
        }
    }
            
</script>

<!-- deatails of movie -->
<div class="web-details">
    <div class="row px-5">
        <div class="left-part-web">
            <span class='movie-name'><?php echo $Movie->get_movie_by_id_and_search('title',$movie_id); ?></span>
            <div class="short-details d-flex">
                <span><?php echo $Movie->get_movie_by_id_and_search('release_year',$movie_id); ?></span>
                    <span>|</span>
                    <span><?php echo $Movie->get_movie_by_id_and_search('duration',$movie_id); ?> mins</span>
                <span>|</span>
                <span><?php echo $Movie->get_movie_by_id_and_search('category',$movie_id); ?></span>
            </div>
            <div class="movie-description text-white py-3">
                <label class='badge badge-info'>Description:</label>
                <?php echo $Movie->get_movie_by_id_and_search('description',$movie_id); ?>
            </div>
            <div class="movie-production d-flex">
                <span><?php echo $Movie->get_movie_by_id_and_search('director',$movie_id); ?><p>Director</p></span>
                <span><?php echo $Movie->get_movie_by_id_and_search('producer',$movie_id); ?><p>Producer</p></span>
            </div>
        </div><!---left-part-web-->
        <div class="right-part-web">
            <div class="ratings-of-movie d-flex">
                <div class="rating-div d-flex">
                    <i class='fa fa-star'></i>
                    <div class="ratings-wrapper">
                        <span id='total-stars'><?php if($ratings[0]>0){
                             echo $ratings[0];
                            }else{
                                echo "0.0";
                            } ?></span>
                        <span id='total-votes'><?php if($ratings[1]>0){
                            echo $ratings[1];
                        }else{
                            echo 0;
                        } ?> vote</span>
                    </div>
                </div>
                <div class="playlist-div d-flex px-3">
                    <i id='my-rating' class='fa fa-star <?php 
                    if($rating_row == false){
                        echo "text-secondary"; 
                    }else{
                        echo "add-rating";
                    }
                    ?>'></i> 
                    <span>My ratings</span>
                    <select class='add-rating' data-video-id='<?php echo $movie_id; ?>' data-user-id='<?php echo $USER_LOGIN_ID; ?>' data-type='movie' data-comment='<?php 
                        if($rating_row != false)
                            echo $rating_row['comment'];
                    ?>' id='add-rating'>
                        <option></option>
                        <?php for($i=1;$i<=10;$i++){
                            echo "<option value='$i'";
                            if($rating_row != false && $i == $rating_row['star'])
                                echo "selected";
                            echo">$i</option>";
                        } ?>
                    </select>
                </div>
            </div>
        </div><!--right-part-web-->
    </div>
    <!-- <div class="tags-div py-3">
    <span class='text-white pr-3'>Tags:</span><span class='tags text-primary'>Brother , Relation , King</span>
    </div> -->
    <div class='mx-auto'>
        <div id="watch-movies-div"><button id='watch-movie' data-type='movie' data-movie-id='<?php echo $movie_id; ?>'><i class='fa fa-play'></i>&nbsp;Watch now</button>
        </div>
    </div><!--#watch-movies-div-->
</div>

<!-- Description and reviews page -->
<div class="description-reviews">
    <div class="header-desp-review">
        <span class='active-tab'>Review</span>
    </div>
    <div class="inner-content">
        <div type="button" class="collapsible">Add review<i class='fa fa-plus mx-2'></i></div>
        <div class="content">
            <?php if($USER_LOGIN_ID != ''){ ?>
            <div class="d-flex align-items-start">
                <span>My ratings
                    <select class='add-rating' id='review-star'>
                        <option></option>
                        <?php for($i=1;$i<=10;$i++){
                            echo "<option value='$i'";
                            if($rating_row != false && $i == $rating_row['star'])
                                echo "selected";
                            echo">$i</option>";
                        } ?>
                    </select>
                </span>
                <textarea id="review-comment" cols="70" rows="2" placeholder="Enter your reviews here.."><?php if($rating_row != false) echo $rating_row['comment'];?></textarea>
                <button class='btn btn-primary mx-3' data-video-id='<?php echo $movie_id; ?>' data-user-id='<?php echo $USER_LOGIN_ID; ?>' data-type='movie' id='add-rating-review'>Submit</button>
            </div>
            <?php }else{ ?>
            <span class='text-secondary'>Please login to leave a review</span>
            <?php } ?>
        </div>
        <span style='border-bottom:3px solid #24BAEF;font-size:28px;'>Reviews</span>

        <div class="reviews-wrapper">
            <?php 
                $all_rating_review = $Rating->getAllReviews($movie_id,'movie');
                $output = '';
                if(mysqli_num_rows($all_rating_review)<1){
                    $output = "<div class='alert alert-danger my-2'>No reviews</div>";
                }
                while($row = mysqli_fetch_assoc($all_rating_review)){
                    $output.="
                    <div class='reviews d-flex'>
                        <div class='image-wrapper' style='background-color: {$User->get_user_detail_by_id('color',$row['user_id'])}'><i class='fa fa-user fa-2x'></i></div>
                        <div class='d-flex flex-column mx-4' style='min-width:100px;'>
                            <span class='add-rating'>{$User->get_user_detail_by_id('username',$row['user_id'])}</span>
                            <span><i class='fa fa-star add-rating'></i>{$row['star']}/10</span>
                        </div>
                        <div class='comment-review'>{$row['comment']}</div>";
                        if($row['user_id'] == $USER_LOGIN_ID){
                            $output.="<div class='text-white h3 review-menu'><i class='fa fa-ellipsis-v'></i></div>";
                        }
                    $output.="</div>
                    ";
                }
                echo $output;
            ?>
        </div>

    </div>
</div><!---description-reviews-->



<!-- Trailers -->
<!-- <div class="stars-wrapper">
    <div class="col-3 side-extra"></div>
        <div class="stars">
            <span>Trailers</span>
            <div class="stars-glider">
                    <div class='stars-image-card'>
                        <img src="images/star-1.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>13 views</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/star-2.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>1 views</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/h1-slider.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>55 views</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/h2-slider.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>22 views</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/star-2.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>1222 views</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/h1-slider.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>1222 views</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/h2-slider.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>12 views</span>
                            </div>
                    </div>
            </div>
        </div>
</div> -->
<!-- The stars representing -->
<!-- <div class="stars-wrapper">
    <div class="col-3 side-extra"></div>
        <div class="stars">
            <span>Stars</span>
            <div class="stars-glider">
                    <div class='stars-image-card'>
                        <img src="images/star-1.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>Hero</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/star-2.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>Hero</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/h1-slider.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>Hero</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/h2-slider.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>Hero</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/star-2.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>Hero</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/h1-slider.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>Hero</span>
                            </div>
                    </div>
                    <div class='stars-image-card'>
                        <img src="images/h2-slider.jpg" alt="">
                            <div class="star-detail">
                                <span class='star-name'>Amannn</span>
                                <span class='star-role'>Hero</span>
                            </div>
                    </div>
            </div>
        </div>
</div> -->
