<?php
include_once "Classes/User.php";
$User = new User($connection);
include_once "Classes/Movie.php";
$Movie = new Movie($connection);
include_once "Classes/Rating.php";
$Rating = new Rating($connection);
if($Rating->checkUserRated($movie_id,$USER_LOGIN_ID,'movie')){
    $rating_row = false;
}else{
    $rating_row = $Rating->getRatedDetails($movie_id,$USER_LOGIN_ID,'movie');
    $rating_row = mysqli_fetch_assoc($rating_row);
}
$ratings = $Rating->calculateTotRating($movie_id,'movie');
?>
<div class="web-navigation d-flex"><span><a href='index.php'>Home</a> <i class='fa fa-angle-right'></i><a href='all-movies.php'>Movies</a> <i class='fa fa-angle-right'></i> <?php echo $Movie->get_movie_by_id_and_search('title',$movie_id); ?> </span></div>

<div id="movie-single-banner" class='m-0 row'>
    <img src='<?php echo $Movie->get_movie_by_id_and_search('thumbnail',$movie_id); ?>'>
</div><!--image-banner--->
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
