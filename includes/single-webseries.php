<?php
include_once "Classes/Webseries.php";
$Webseries = new Webseries($connection);
?>
    <div class="web-navigation d-flex"><span><a href='index.php'>Home</a> <i class='fa fa-angle-right'></i> Webseries </span></div>

    <div id="movie-single-banner" class='m-0 row'>
        <img src='<?php echo $Webseries->get_webseries_by_id_and_search('thumbnail',$webseries_id); ?>'>
    </div><!--image-banner--->

    <!-- deatails of web show -->
    <div class="web-details">
        <div class="row px-5">
            <div class="left-part-web">
                <span class='movie-name'><?php echo $Webseries->get_webseries_by_id_and_search('title',$webseries_id); ?></span>
                <div class="short-details d-flex">
                    <span><?php echo $Webseries->get_webseries_by_id_and_search('release_year',$webseries_id); ?></span>
                        <span>|</span>
                    <span>Season <?php echo $Webseries->get_webseries_by_id_and_search('season_number',$webseries_id); ?></span>
                        <span>|</span>
                    <span><?php echo $Webseries->get_webseries_by_id_and_search('category',$webseries_id); ?></span>
                </div>
                <!-- <div class="web-views d-flex">
                    <span><i class='fa fa-eye'></i>2.4k views</span>
                    <span><i class='fa fa-thumbs-up'></i>24+</span>
                </div> -->
            </div><!---left-part-web-->
            <div class="right-part-web">
                <div class="ratings-of-movie d-flex">
                    <div class="rating-div d-flex">
                        <i class='fa fa-star'></i>
                        <div class="ratings-wrapper">
                            <span>9.0</span>
                            <span>2 votes</span>
                        </div>
                    </div>
                    <div class="playlist-div d-flex px-3">
                        <i class='fa fa-star text-secondary'></i> 
                        <span>My ratings</span>
                        <select class='add-rating'>
                            <option></option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                        </select>
                    </div>
                </div>
            </div><!--right-part-web-->
        </div>
        <!-- <div class="tags-div py-3">
        <span class='text-white pr-3'>Tags:</span><span class='tags text-primary'>Brother , Relation , King</span>
        </div> -->
        <div id="watch-movies-div" class='mx-auto'>
            <button id='watch-movie' data-type='webseries' data-episode='<?php echo $episode_id; ?>' data-movie-id='<?php echo $webseries_id; ?>'><i class='fa fa-play'></i>&nbsp;Watch now</button>
        </div><!--#watch-movies-div-->
    </div>

    <!-- All seasons -->
    <div class="web-details-more">
        <div class="d-flex seasons-row">
            <?php
            $output='';
                if($Webseries->get_webseries_by_id_and_search('part_1_id',$webseries_id) == '0')
                {
                    $output.="<a href='webseries.php?webseries_id={$webseries_id}'><div class='season-badge active-season-badge' data-id='{$webseries_id}'>Season 1</div></a>";
                    $part_1_id = $Webseries->get_webseries_by_id_and_search('part_1_id',$webseries_id);
                    $all_seasons = $Webseries->get_webseries_by_part_1_id($webseries_id);
                    $count = 2;
                    while($row = mysqli_fetch_assoc($all_seasons))
                    {
                        $output.="<a href='webseries.php?webseries_id={$row['id']}'><div class='season-badge' data-id='{$row['id']}'>Season {$count}</div></a>";
                        $count++;
                    }
                }else{
                    $part_1_id = $Webseries->get_webseries_by_id_and_search('part_1_id',$webseries_id);
                    $all_seasons = $Webseries->get_webseries_by_part_1_id($part_1_id);
                    $count = 2;
                    $output.="<a href='webseries.php?webseries_id={$part_1_id}'><div class='season-badge' data-id='{$part_1_id}'>Season 1</div></a>";
                    while($row = mysqli_fetch_assoc($all_seasons))
                    {
                        $output.="<a href='webseries.php?webseries_id={$row['id']}'><div class='season-badge ";
                        if($row['id'] === $webseries_id)
                        {
                            $output.="active-season-badge";
                        }
                        $output.="' data-id='{$row['id']}'>Season {$count}</div></a>";
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
                    <div class='movie-image'>
                        <img src='{$row['thumbnail']}' alt='image'>
                    </div>
                    <div class='movie-info'>
                        <span class='episode-badge'>S0{$Webseries->get_webseries_by_id_and_search('season_number',$webseries_id)}E0{$row['episode_number']}</span>
                        <span class='episode-name'>{$row['title']}</span>
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
            <span class='active-tab'>Description</span>
            <!-- <span>/</span>
            <span>Reviews</span> -->
        </div>
        <div class="inner-content">
            <span>
            <?php echo $Webseries->get_webseries_by_id_and_search('description',$webseries_id); ?>
            </span>
        </div>
    </div><!---description-reviews-->









