<?php include "includes/header.php"; 
include_once "Classes/Movie.php";
include_once "Classes/Category.php";
$Movie = new Movie($connection);
$Category = new Category($connection);
?>
<link rel="stylesheet" href="assets/css/all-movie.css">

</head>
<body>
    
    <div id="plans"></div>

<div class="full-size">
<?php include "includes/nav.php"; ?>

<div class="movies-small-navigation d-flex">
    <span><a href='index.php'>Home</a> <i class='fa fa-angle-right'></i> Movies </span>
</div>

<!-- All wrapper -->
<div class="wrapper-movies">

    <div class="filters">
        <div class='filters-holder'>
            <div class="filters-wrapper">
                <div class="input-group">
                    <input type="text" id="search_filter" class='form-control p-4 search-input-movies' placeholder='Search...'>
                    <div id='search-filter-button' class='search-inside-input-movies' data-type='movie'>
                        <i class='fa fa-search text-secondary'></i>
                    </div>
                </div>
            </div><!--filters-wrapper--->
            <div class="filters-wrapper">
                <span>Filter by letters</span>
                <div class="all-badges">
                    <?php
                    $output = '';
                        $movie_letters = $Movie->get_movie_letter();
                        foreach ($movie_letters as $key => $value) {
                            $output.="<div class='filter-badge letter-badge' data-type='movie' data-letter='{$value}'>{$value}</div>";
                        }
                        echo $output;
                    ?>
                </div>
            </div><!--filters-wrapper--->
            <div class="filters-wrapper">
                <span>Categories</span>
                <div class="all-categories">
                    <ul class='list-of-categories'>
                    <?php
                    $output = '';
                        $movie_categories = $Category->get_all_category_admin();
                        while($row = mysqli_fetch_assoc($movie_categories)){
                            $output.="<li class='category-list' data-type='movie' data-category='{$row['category']}'><i class='fa fa-square-o'></i>{$row['category']}</li>";
                        }
                        echo $output;
                    ?>
                    </ul>
                </div>
            </div><!--filters-catogory--->
            <div class="filters-wrapper">
                <span>Movies by Year</span>
                <div class="all-badges">
                    <?php
                    $output = '';
                        $all_years = $Movie->get_all_years();
                        foreach ($all_years as $key => $value) {
                            $output.="<div class='filter-badge years-badge' data-type='movie' data-year='{$value}'>{$value}</div>";
                        }
                        echo $output;
                    ?>
                </div>
            </div><!---filters-by-year--->
            <div class="filters-wrapper">
                <span>Filter by Rating</span>
                <div class="all-ratings">
                        <div class="ratings-div">
                            <div class="all-star">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div><!--all-star-->
                            <span class="total-movies-with-ratings">
                                (2)
                            </span><!--total-movies-with-ratings-->
                        </div>
                        <div class="ratings-div">
                            <div class="all-star">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div><!--all-star-->
                            <span class="total-movies-with-ratings">
                                (2)
                            </span><!--total-movies-with-ratings-->
                        </div>
                        <div class="ratings-div">
                            <div class="all-star">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div><!--all-star-->
                            <span class="total-movies-with-ratings">
                                (2)
                            </span><!--total-movies-with-ratings-->
                        </div>
                </div>
            </div><!---filters-by-rating--->
        </div>
        <div class='close-side-nav-holder'>
            <i class="fa fa-times"></i>
        </div>
    </div><!--filters--->

    <div class="all-movies">

        <div class="sub-title"><span class='page-name'>Movies</span></div>
        <div class="filters-and-latest-div">
            <span class='filter-icon'><i class="fa fa-sliders"></i>Filters</span>
            <select class='dropdown-movies' data-type='movie'>
                <option value='1' selected>&#xf15d;&nbsp;&nbsp;&nbsp;A to Z</option>
                <option value='2'>&#xf15e;&nbsp;&nbsp;&nbsp;Z to A</option>
                <option value='3'>&#xf0dc;&nbsp;&nbsp;&nbsp;Year</option>
                <option value='4'>&#xf005;&nbsp;&nbsp;&nbsp;Latest</option>
            </select>
        </div><!--filters-and-latest-div-->
        <div class="all-movies-holder">
            <div id="wait"><i class='fa fa-spinner fa-spin'></i><br>Loading..</div>
            <?php
                $all_movies = $Movie->get_all_movies_by_query('','','','','',1);
                $output = '';
                while($row = mysqli_fetch_assoc($all_movies[0]))
                {
                    $categories = explode(',',$row['category']);
                    $output.="<div class='movie-card'>
                    <a href='movie.php?movie_id={$row['id']}'><div class='movie-image'>
                        <img src='{$row['thumbnail']}'>
                    </div></a>
                    <div class='movie-info'>
                        <span>{$row['release_year']}&nbsp;&nbsp;|&nbsp;&nbsp;{$categories[0]},{$categories[1]}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Part {$row['part']}</span></span>
                        <span>{$row['title']}</span>
                    </div>
                </div><!---movie-card-->";
                }
                echo $output;
            ?>
        </div><!--all-movies-holder-->
        <div class="pagination-holder">
            <span class='previous' data-type='movie' data-value='1'><i class='fa fa-angle-double-left filter-badge'></i></span>
            <div class='pagination-div'>
                <?php
                    $total_pages = $Movie->pagination();
                    for($i=1;$i<=$total_pages;$i++) {
                        echo "<span class='pagination-number ";
                        if($i == 1){
                            echo "active-pagination";
                        }
                        echo "' data-type='movie'>{$i}</span>";
                    }
                ?>
            </div>
            <span class='next' data-type='movie' data-value='1'><i class='fa fa-angle-double-right filter-badge'></i></span>
        </div><!--pagination-holder-->
    </div><!--all-movies-->

</div><!---wrapper-movies--->
<?php include "includes/footer.php"; ?>