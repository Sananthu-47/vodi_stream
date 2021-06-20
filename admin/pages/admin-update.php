<?php include "../includes/admin-header.php";  ?>

  </head>
  <body>
<div class='admin-wrapper'>

    <div class="inner-wrapper">
            <!--Dashboard Navbar-->
            <?php include "../includes/admin-nav.php"; ?>

        <!--Components-->
        <div class = "content">
                <div class="content-nav">
                        <div class="content-nav-left" id='sub-nav'>
                            <div class="content-nav-badges active-background" id='video-list'>Update the details</div>
                        </div>
                        <div class="content-nav-right">
                            <input type="search" placeholder="Search" class='content-search-bar'>
                            <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                        </div>
                </div>
            <hr>
                <div class="admin-main-content">

<?php
    $page = '';
    if(isset($_GET['movie-id']))
    {
        $movie_id = $_GET['movie-id'];
        include_once "../proccess/update/update-movie.php";
    }else if(isset($_GET['webseries-id']))
    {
        $webseries_id = $_GET['webseries-id'];
        include_once "../proccess/update/update-webseries.php";
    }
?>
                </div>
        </div><!--content-->
    </div><!--inner-wrapper-->
</div><!--admin-wrapper--->

<script src='../assets/js/update.js'></script>  
<?php include "../includes/admin-footer.php";  ?>
