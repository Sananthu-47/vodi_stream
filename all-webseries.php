<?php include "includes/header.php"; 
include_once "Classes/Category.php";
include_once "Classes/Webseries.php";
$Webseries = new Webseries($connection);
$Category = new Category($connection);
include_once "Classes/Rating.php";
$Rating = new Rating($connection);
?>
<link rel="stylesheet" href="assets/css/all-movie.css">

</head>
<body>
    
    <div id="plans"></div>

<div class="full-size">
<?php include "includes/nav.php"; ?>

<div class="movies-small-navigation d-flex">
    <span><a href='index.php'>Home</a> <i class='fa fa-angle-right'></i> Webseries</span>
</div>

<!-- All wrapper -->
<div class="wrapper-movies">

    <div class="filters">
        <div class='filters-holder'>
            <div class="filters-wrapper">
                <div class="input-group">
                    <input type="text" id="search_filter" class='form-control p-4 search-input-movies' placeholder='Search...'>
                    <div id='search-filter-button' data-type='webseries' class='search-inside-input-movies'>
                        <i class='fa fa-search text-secondary'></i>
                    </div>
                </div>
            </div><!--filters-wrapper--->
            <div class="filters-wrapper">
                <span>Filter by letters</span>
                <div class="all-badges">
                    <?php
                        $output = '';
                        $webseries_letters = $Webseries->get_webseries_letter();
                        foreach ($webseries_letters as $key => $value) {
                            $output.="<div class='filter-badge letter-badge' data-type='webseries' data-letter='{$value}'>{$value}</div>";
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
                            $output.="<li class='category-list' data-type='webseries' data-category='{$row['category']}'><i class='fa fa-square-o'></i>{$row['category']}</li>";
                        }
                        echo $output;
                    ?>
                    </ul>
                </div>
            </div><!--filters-catogory--->
            <div class="filters-wrapper">
                <span>Webseries by Year</span>
                <div class="all-badges">
                <?php
                    $output = '';
                        $all_years = $Webseries->get_all_years();
                        foreach ($all_years as $key => $value) {
                            $output.="<div class='filter-badge years-badge' data-type='webseries' data-year='{$value}'>{$value}</div>";
                        }
                        echo $output;
                    ?>
                </div>
            </div><!---filters-by-year--->
            <div class="filters-wrapper">
                <span>Filter by Rating</span>
                <div class="all-ratings">
                <?php
                    $output = '';
                        $movie_ratings = $Rating->get_all_stars('webseries');
                        asort($movie_ratings);
                        foreach ($movie_ratings as $key => $value) {
                            $output.="<div class='ratings-div rating-badge' data-type='webseries' data-star='$value'>
                                <div class='all-star'>";
                                    for($i=1;$i<=10;$i++){
                                        $output.="<i class='fa fa-star ";
                                        if($i <= $value){
                                            $output.="add-rating";
                                        }else{
                                            $output.="no-rating";
                                        }
                                        $output.="'></i>";
                                    }
                                    $output.="
                                </div>
                                <span class='total-movies-with-ratings'>($value)</span>
                            </div>";
                        }
                    echo $output;
                ?>
                </div>
            </div><!---filters-by-rating--->
        </div>
        <div class='close-side-nav-holder'>
            <i class="fa fa-times"></i>
        </div>
    </div><!--filters--->

    <div class="all-movies">
        <div class="sub-title"><span class='page-name'>Webseries</span></div>
        <div class="filters-and-latest-div">
            <span class='filter-icon'><i class="fa fa-sliders"></i>Filters</span>
            <select class='dropdown-movies' data-type='webseries'>
                <option value='1' selected>&#xf15d;&nbsp;&nbsp;&nbsp;A to Z</option>
                <option value='2'>&#xf15e;&nbsp;&nbsp;&nbsp;Z to A</option>
                <option value='3'>&#xf0dc;&nbsp;&nbsp;&nbsp;Year</option>
                <option value='4'>&#xf005;&nbsp;&nbsp;&nbsp;Latest</option>
            </select>
        </div><!--filters-and-latest-div-->
        <div class="all-movies-holder">
            <div id="wait"><i class='fa fa-spinner fa-spin'></i><br>Loading..</div>
            <?php
                $all_webseries = $Webseries->get_all_webseries_by_query('','','','','',1,''); //params -> (search,letters,years,order,categorys,page_number,ratings)
                $output = '';
                while($row = mysqli_fetch_assoc($all_webseries[0]))
                {
                    $categories = explode(',',$row['category']);
                    $output.= "<div class='movie-card'>
                    <a href='webseries.php?webseries_id={$row['id']}'><div class='movie-image'>
                        <img src='{$row['thumbnail']}'>
                    </div></a>
                    <div class='movie-info'>
                        <span>{$row['release_year']}&nbsp;&nbsp;|&nbsp;&nbsp;{$categories[0]},{$categories[1]}&nbsp;&nbsp;|&nbsp;&nbsp;<span class='season-badge'>Season {$row['season_number']}</span></span>
                        <span>{$row['title']}</span>
                    </div>
                </div><!--movie-card-->";
                }
                echo $output;
            ?>
        </div><!--all-movies-holder-->
        <div class="pagination-holder">
            <span class='previous' data-type='webseries' data-value='1'><i class='fa fa-angle-double-left filter-badge'></i></span>
            <div class='pagination-div'>
                <?php
                    $total_pages = $Webseries->pagination();
                    for($i=1;$i<=$total_pages;$i++) {
                        echo "<span class='pagination-number ";
                        if($i == 1){
                            echo "active-pagination";
                        }
                        echo "' data-type='webseries'>{$i}</span>";
                    }
                ?>
            </div>
            <span class='next' data-type='webseries' data-value='1'><i class='fa fa-angle-double-right filter-badge'></i></span>
        </div><!--pagination-holder-->
    </div><!--all-movies-->

</div><!---wrapper-movies--->

<?php include "includes/footer.php"; ?>
            