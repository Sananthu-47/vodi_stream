<?php
include_once "Classes/Movie.php";
$Movie = new Movie($connection);
?>
<div class="web-navigation d-flex"><span><a href='index.php'>Home</a> <i class='fa fa-angle-right'></i><a href='all-movies.php'>Movies</a> <i class='fa fa-angle-right'></i> <?php echo $Movie->get_movie_by_id_and_search('title',$movie_id); ?> </span></div>

<div id="movie-single-banner" class='m-0 row'>
    <img src='<?php echo $Movie->get_movie_by_id_and_search('thumbnail',$movie_id); ?>'>
</div><!--image-banner--->
<!-- deatails of movie -->
<div class="movie-details">
    <div class="col-3 side-extra"></div>
    <div class="movie-inside-wrapper">
        <div class="left-side">
            <span class='movie-name'><?php echo $Movie->get_movie_by_id_and_search('title',$movie_id); ?></span>
            <div class="ratings-of-movie d-flex">
                <div class="rating-div d-flex">
                    <i class='fa fa-star'></i>
                    <div class="ratings-wrapper">
                        <span>9.0</span>
                        <span>2 votes</span>
                    </div>
                </div>
                <div class="playlist-div d-flex px-3">
                    <i class='fa fa-heart fa-stroke'></i> 
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
                            <option>9</option>
                            <option>10</option>
                        </select>
                </div>
            </div>
            <div class="short-details d-flex">
                <span><?php echo $Movie->get_movie_by_id_and_search('release_year',$movie_id); ?></span>
                    <span>|</span>
                <span><?php echo $Movie->get_movie_by_id_and_search('duration',$movie_id); ?> mins</span>
                    <span>|</span>
                <span><?php echo $Movie->get_movie_by_id_and_search('category',$movie_id); ?></span>
            </div>
            <div class="movie-description text-white">
                <label class='badge badge-info'>Description:</label>
                <?php echo $Movie->get_movie_by_id_and_search('description',$movie_id); ?>
            </div>
            <div class="movie-production d-flex">
                <span><?php echo $Movie->get_movie_by_id_and_search('director',$movie_id); ?><p>Director</p></span>
                <span><?php echo $Movie->get_movie_by_id_and_search('producer',$movie_id); ?><p>Producer</p></span>
            </div>
        </div>
    
        <div class="right-side">
            <div id="watch-movies-div"><button id='watch-movie' data-type='movie' data-movie-id='<?php echo $movie_id; ?>'><i class='fa fa-play'></i>&nbsp;Watch now</button>
            </div>
        </div>
    </div>
</div>
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