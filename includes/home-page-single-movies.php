<?php
include_once "Classes/Movie.php";
include_once "Classes/Webseries.php";
include_once "Classes/Dashboard.php";
$Movie = new Movie($connection);
$Webseries = new Webseries($connection);
$Dashboard = new Dashboard($connection);
?>

<div id="home-glider" class='m-0 row'>
    
</div><!--home-glider--->


<div class="home-wrapper">
    <!-- Free-movies -->
        <div class="inner-home-wrapper">
            <div class="d-flex justify-content-between">
                <span class='home-headers'>Free shows</span>
            </div>
            <div class="home-videos-glider">

            <?php 
            $result = $Dashboard->free_shows();
            $output = '';
            while ($row = mysqli_fetch_assoc($result)) {
                if($row['type'] == 'Movie')
                {
                    $part = "Part ".$row['part'];
                    $path = "movie.php?movie_id={$row['id']}";
                }else if($row['type'] == 'Webseries')
                {
                    $part = "Season ".$row['part'];
                    $path = "webseries.php?webseries_id={$row['id']}";
                }else if($row['type'] == 'Episode')
                {
                    $part = "S0".$row['part_1_id']."E0".$row['part'];
                    $path = "webseries.php?type=episode&webseries_id={$row['category']}&episode_id={$row['id']}";
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
                    <div class='banner-label'>Free</div>
                    </div><!--image-card-->";
            }
            echo $output;
            ?>
            </div><!--home-videos-gilder-->
        </div><!---free-movies-->
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
                    $path = "webseries.php?webseries_id={$row['id']}";
                }else if($row['type'] == 'Episode')
                {
                    $part = "S0".$row['part_1_id']."E0".$row['part'];
                    $path = "webseries.php?type=episode&webseries_id={$row['category']}&episode_id={$row['id']}";
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
            <div class="d-flex justify-content-between">
                <span class='home-headers'>Movies</span>
                <?php 
                    $result = $Movie->get_all_movies_users(10);// Get max 10 records
                    if(mysqli_num_rows($result)>0){
                        echo "<a href='all-movies.php'><span class='view-all-button'>View All <i class='fa fa-arrow-right mx-2'></i></span></a>";
                    }
                ?>
            </div>

            <div class="home-videos-glider">

            <?php 
            $output = '';
            while ($row = mysqli_fetch_assoc($result)) {
                $categories = explode(',',$row['category']);
                $output .= "
                    <div class='image-card'>
                        <a href='movie.php?movie_id={$row['id']}'><div class='image-wrapper'>
                            <img src='{$row['thumbnail']}'>
                        </div></a>
                            <div class='movie-detail'>
                                <span class='movie-span'>{$row['release_year']}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Part {$row['part']}</span>&nbsp;&nbsp;|&nbsp;&nbsp;{$categories[0]}";
                                if(count($categories) > 1){
                                    $output.=",{$categories[1]}";
                                }
                                $output .="</span>
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
            <div class="d-flex justify-content-between">
                <span class='home-headers'>Webseries</span>
                <?php 
                    // $result = $Webseries->get_all_webseries_by_query('','','','','1',1,''); //params -> (search,letters,years,order,categorys,page_number,ratings)
                    $result = $Webseries->get_all_webseries_users(10); // Get max 10 webseries
                    if(mysqli_num_rows($result)>0){
                        echo "<a href='all-webseries.php'><span class='view-all-button'>View All <i class='fa fa-arrow-right mx-2'></i></span></a>";
                    }
                ?>
            </div>
            <div class="home-videos-glider">

            <?php 
            $output = '';
            while ($row = mysqli_fetch_assoc($result)) {
                $categories = explode(',',$row['category']);
                $output .= "
                    <div class='image-card'>
                        <a href='webseries.php?webseries_id={$row['id']}'><div class='image-wrapper'>
                            <img src='{$row['thumbnail']}'>
                        </div></a>
                            <div class='movie-detail'>
                                <span class='movie-span'>{$row['release_year']}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Season {$row['season_number']}</span>&nbsp;&nbsp;|&nbsp;&nbsp;{$categories[0]}";
                                if(count($categories) > 1){
                                    $output.=",{$categories[1]}";
                                }
                                $output .="</span>
                                <span class='movie-title'>{$row['title']}</span>
                            </div>
                    </div><!--image-card-->";
            }
            echo $output;
            ?>
            </div><!--home-videos-gilder-->
        </div><!--all-webseries--->
</div>