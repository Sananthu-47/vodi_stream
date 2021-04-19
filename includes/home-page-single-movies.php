<?php
include_once "Classes/Movie.php";
include_once "Classes/Webseries.php";
include_once "Classes/Dashboard.php";
$Movie = new Movie($connection);
$Webseries = new Webseries($connection);
$Dashboard = new Dashboard($connection);
?>

<div id="home-glider" class='m-0 row'>
    <div class="d-flex justify-content-center align-items-center col-xl-6 col-12 col-lg-6 p-0" id='movie-single-features-details'>
        <div id='movie-details-home'>
            <div id="single-movie-details" class='text-white'><span>2016&nbsp;&nbsp;|&nbsp;&nbsp;Action,mystery&nbsp;&nbsp;|&nbsp;&nbsp;2hr13mins</span></div>
            <div id="movie-name-home"><span class='text-white'>Fantastic Beasts and Where to Find Them</span></div>
            <div id="watch-movies-div"><button id='watch-movie'><i class='fa fa-play'></i>&nbsp;Watch now</button></div>
        </div><!--movie-details-home--->
    </div><!--movie-single-features-details-->
    <div class="d-flex justify-content-center align-items-center col-xl-6 col-12 col-lg-6  p-0" id='image-sliders'>
    <div id='image-slider-div' class='d-flex justify-content-center align-items-start col-12 mt-5'>
        <div class="image-card-movies current-slide"><img src="images/h1-slider.jpg" alt="" srcset=""></div>
        <div class="image-card-movies"><img src="images/h2-slider.jpg" alt="" srcset=""></div>
        <div class="image-card-movies"><img src="images/h3-slider.jpg" alt="" srcset=""></div>
    </div>
    </div><!--image-sliders-->
</div><!--home-glider--->


<div class="home-wrapper">
    <!-- Featured shows -->
        <div class="inner-home-wrapper">
            <span class='home-headers'>Featured Shows</span>
            <div class="home-videos-glider">

            <?php 
            $result = $Dashboard->featured_users('featured');
            $output = '';
            while ($row = mysqli_fetch_assoc($result)) {
                if($row['type'] == 'Movie')
                {
                    $part = "Part ".$row['part'];
                    $path = "movie.php?movie_id={$row['id']}";
                }else if($row['type'] == 'Webseries')
                {
                    $part = "Season ".$row['part'];
                    $first_episode = $Webseries->get_first_episode_of_webseries($row['id']);
                    $first_episode = mysqli_fetch_assoc($first_episode);
                    $path = "webseries.php?webseries_id={$row['id']}&episode_id={$first_episode['id']}";
                }else if($row['type'] == 'Episode')
                {
                    $part = "S0".$row['part_1_id']."E0".$row['part'];
                    $path = "webseries.php?webseries_id={$row['language']}&episode_id={$row['id']}";
                }
                $output .= "
                    <div class='image-card'>
                        <a href='{$path}'><div class='image-wrapper'>
                            <img src='{$row['thumbnail']}'>
                        </div></a>
                            <div class='movie-detail'>
                                <span class='movie-span'>{$row['release_year']}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>{$part}</span>&nbsp;&nbsp;|&nbsp;&nbsp;{$row['type']}</span>
                                <span class='movie-title'>{$row['title']}</span>
                            </div>
                    <div class='banner-label'>Featured</div>
                    </div><!--image-card-->";
            }
            echo $output;
            ?>
            </div><!--home-videos-gilder-->
        </div><!---featured-shows-->
    <!-- All movies -->
        <div class="inner-home-wrapper">
            <span class='home-headers'>All movies</span>
            <div class="home-videos-glider">

            <?php 
            $result = $Movie->get_all_movies_by_query('','','','','1',10);
            $output = '';
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= "
                    <div class='image-card'>
                        <a href='movie.php?movie_id={$row['id']}'><div class='image-wrapper'>
                            <img src='{$row['thumbnail']}'>
                        </div></a>
                            <div class='movie-detail'>
                                <span class='movie-span'>{$row['release_year']}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Part {$row['part']}</span>&nbsp;&nbsp;|&nbsp;&nbsp;{$row['language']}</span>
                                <span class='movie-title'>{$row['title']}</span>
                            </div>
                    </div><!--image-card-->";
            }
            echo $output;
            ?>
            </div><!--home-videos-gilder-->
        </div><!--all-movies--->
    <!-- All webseries -->
        <div class="inner-home-wrapper">
            <span class='home-headers'>All webseries</span>
            <div class="home-videos-glider">

            <?php 
            $result = $Webseries->get_all_webseries_by_query('','','','','1',10);
            $output = '';
            while ($row = mysqli_fetch_assoc($result)) {
                $first_episode = $Webseries->get_first_episode_of_webseries($row['id']);
                $first_episode = mysqli_fetch_assoc($first_episode);
                $output .= "
                    <div class='image-card'>
                        <a href='webseries.php?webseries_id={$row['id']}&episode_id={$first_episode['id']}'><div class='image-wrapper'>
                            <img src='{$row['thumbnail']}'>
                        </div></a>
                            <div class='movie-detail'>
                                <span class='movie-span'>{$row['release_year']}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Season {$row['season_number']}</span>&nbsp;&nbsp;|&nbsp;&nbsp;{$row['language']}</span>
                                <span class='movie-title'>{$row['title']}</span>
                            </div>
                    </div><!--image-card-->";
            }
            echo $output;
            ?>
            </div><!--home-videos-gilder-->
        </div><!--all-webseries--->
</div>