<?php
include_once "Classes/User.php";
$User = new User($connection);
include_once "Classes/Webseries.php";
$Webseries = new Webseries($connection);
$all_episodes = $Webseries->get_first_episode_of_webseries($webseries_id);
$all_episodes = mysqli_fetch_assoc($all_episodes);
$episode_id = $all_episodes['id'];

include_once "Classes/Rating.php";
$Rating = new Rating($connection);
if($Rating->checkUserRated($webseries_id,$USER_LOGIN_ID,'webseries')){
    $rating_row = false;
}else{
    $rating_row = $Rating->getRatedDetails($webseries_id,$USER_LOGIN_ID,'webseries');
    $rating_row = mysqli_fetch_assoc($rating_row);
}
$ratings = $Rating->calculateTotRating($webseries_id,'webseries');
?>
    <div class="web-navigation d-flex"><span><a href='index.php'>Home</a> <i class='fa fa-angle-right'></i><a href='all-webseries.php'>Webseries</a> <i class='fa fa-angle-right'></i> <?php echo $Webseries->get_webseries_by_id_and_search('title',$webseries_id); ?> </div>

    <div id="movie-single-banner" class='m-0 row'>
        <img src='<?php echo $Webseries->get_webseries_by_id_and_search('thumbnail',$webseries_id); ?>'>
    </div><!--image-banner--->

    <!-- deatails of web show -->
    <div class="web-details">
        <div class="row px-5">
            <div class="left-part-web">
                <span class='movie-name'><?php echo $Webseries->get_webseries_by_id_and_search('title',$webseries_id); ?></span>
                <div class="short-details d-flex">
                    <span><?php 
                        echo $Webseries->get_webseries_by_id_and_search('release_year',$webseries_id)." - "; 
                        if($Webseries->get_webseries_by_id_and_search('end_year',$webseries_id) != 0){
                            echo $Webseries->get_webseries_by_id_and_search('end_year',$webseries_id);
                        }else{
                            echo "<span class='badge badge-success'>Ongoing</span>";
                        }
                    ?></span>
                        <span>|</span>
                    <span>Season <?php echo $Webseries->get_webseries_by_id_and_search('season_number',$webseries_id); ?></span>
                        <span>|</span>
                    <span><?php echo $Webseries->get_webseries_by_id_and_search('category',$webseries_id); ?></span>
                </div>
                <div class="movie-description text-white py-3">
                    <label class='badge badge-info'>Description:</label>
                    <?php echo $Webseries->get_webseries_by_id_and_search('description',$webseries_id); ?>
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
                        <select class='add-rating' data-video-id='<?php echo $webseries_id; ?>' data-user-id='<?php echo $USER_LOGIN_ID; ?>' data-type='webseries' data-comment='<?php 
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
        <div id="watch-movies-div"><a href='webseries.php?type=episode&<?php echo "webseries_id=$webseries_id&episode_id=$episode_id"; ?>'><button id='watch-movie' data-type='webseries' data-episode='<?php echo $episode_id; ?>' data-movie-id='<?php echo $webseries_id; ?>'><i class='fa fa-play'></i>&nbsp;Watch now</button></a></div>
        </div><!--#watch-movies-div-->
    </div>

    <!-- All seasons -->
    <div class="web-details-more">
        <div class="d-flex seasons-row">
            <?php
            $output='';
                if($Webseries->get_webseries_by_id_and_search('part_1_id',$webseries_id) == '0')
                {
                    $all_episodes = $Webseries->get_first_episode_of_webseries($webseries_id);
                    $all_episodes = mysqli_fetch_assoc($all_episodes);
                    $output.="<a href='webseries.php?webseries_id={$webseries_id}&episode_id={$all_episodes['id']}'><div class='season-badge active-season-badge'>Season 1</div></a>";
                    $part_1_id = $Webseries->get_webseries_by_id_and_search('part_1_id',$webseries_id);
                    $all_seasons = $Webseries->get_webseries_by_part_1_id($webseries_id);
                    $count = 2;
                    while($row = mysqli_fetch_assoc($all_seasons))
                    {
                        $all_episodes = $Webseries->get_first_episode_of_webseries($row['id']);
                        $all_episodes = mysqli_fetch_assoc($all_episodes);
                        $output.="<a href='webseries.php?webseries_id={$row['id']}&episode_id={$all_episodes['id']}'><div class='season-badge'>Season {$count}</div></a>";
                        $count++;
                    }
                }else{
                    $part_1_id = $Webseries->get_webseries_by_id_and_search('part_1_id',$webseries_id);
                    $all_seasons = $Webseries->get_webseries_by_part_1_id($part_1_id);
                    $count = 2;
                    $all_episodes = $Webseries->get_first_episode_of_webseries($part_1_id);
                    $all_episodes = mysqli_fetch_assoc($all_episodes);
                    $output.="<a href='webseries.php?webseries_id={$part_1_id}&episode_id={$all_episodes['id']}'><div class='season-badge'>Season 1</div></a>";
                    while($row = mysqli_fetch_assoc($all_seasons))
                    {
                        $all_episodes = $Webseries->get_first_episode_of_webseries($row['id']);
                        $all_episodes = mysqli_fetch_assoc($all_episodes);
                        $output.="<a href='webseries.php?webseries_id={$row['id']}&episode_id={$all_episodes['id']}'><div class='season-badge ";
                        if($row['id'] === $webseries_id)
                        {
                            $output.="active-season-badge";
                        }
                        $output.="'>Season {$count}</div></a>";
                        $count++;
                    }
                }
                echo $output;
            ?>
        </div><!--seasons-row-->
        <div class="all-movies-holder py-5">
            <?php 
                $all_episodes = $Webseries->get_all_webseries_seasons_by_seriesid($webseries_id);
                $output = '';
                while ($row = mysqli_fetch_assoc($all_episodes)) {
                    $output.="<div class='movie-card'>
                    <a href='webseries.php?type=episode&webseries_id={$webseries_id}&episode_id={$row['id']}'>
                        <div class='movie-image'>
                            <img src='{$row['thumbnail']}' alt='image'>
                        </div>
                    </a>
                    <div class='movie-info'>
                        <span class='episode-badge'>S0{$Webseries->get_webseries_by_id_and_search('season_number',$webseries_id)}E0{$row['episode_number']}</span>
                        <span class='episode-name'>{$Webseries->get_webseries_by_id_and_search('title',$webseries_id)}&nbsp;&nbsp;|&nbsp;&nbsp;{$row['title']}&nbsp;&nbsp;|&nbsp;&nbsp;{$row['duration']}mins</span>
                    </div>
                </div>";
                }
                echo $output;
            ?>
        </div><!--all-movies-holder-->
    </div><!--web-details-more-->

    <!-- Description and reviews page -->
<div class="description-reviews">
    <div class="header-desp-review">
        <span class='active-tab'>Review</span>
    </div>
    <div class="inner-content">
        <div type="button" class="collapsible">Add review<i class='fa fa-plus mx-2'></i></div>
        <div class="content">
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
                <button class='btn btn-primary mx-3' data-video-id='<?php echo $webseries_id; ?>' data-user-id='<?php echo $USER_LOGIN_ID; ?>' data-type='webseries' id='add-rating-review'>Submit</button>
            </div>
        </div>
        <span style='border-bottom:3px solid #24BAEF;font-size:28px;'>Reviews</span>

        <div class="reviews-wrapper">
            <?php 
                $all_rating_review = $Rating->getAllReviews($webseries_id,'webseries');
                $output = '';
                if(mysqli_num_rows($all_rating_review)<1){
                    $output = "<div class='alert alert-danger my-2'>No reviews</div>";
                }
                while($row = mysqli_fetch_assoc($all_rating_review)){
                    $output.="
                    <div class='reviews d-flex'>
                        <div class='d-flex'>
                            <div class='image-wrapper' style='background-color: {$User->get_user_detail_by_id('color',$row['user_id'])}'><i class='fa fa-user fa-2x'></i></div>
                            <div class='d-flex flex-column mx-4' style='min-width:100px;'>
                                <span class='add-rating'>{$User->get_user_detail_by_id('username',$row['user_id'])}</span>
                                <span><i class='fa fa-star add-rating'></i>{$row['star']}/10</span>
                            </div>
                        </div>
                        <div class='d-flex'>
                            <div class='comment-review mr-3'>{$row['comment']}</div>";
                            if($row['user_id'] == $USER_LOGIN_ID){
                                $output.="<div class='text-white h3 review-menu'>
                                    <i class='fa fa-ellipsis-v review-menu-user-icon'></i>
                                    <div class='review-menu-dropdown' style='display:none;'>
                                        <ul class='list-group'>
                                            <li class='list-group-item delete-review' data-id='{$row['id']}'>Delete</li>
                                            <li class='list-group-item edit-review'>Edit</li>
                                        </ul>
                                    </div>
                                </div>";
                            }
                    $output.="</div>
                    </div>
                    ";
                }
                echo $output;
            ?>
        </div>

    </div>
</div><!---description-reviews-->





