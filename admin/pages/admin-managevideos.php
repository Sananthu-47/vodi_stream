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
                            <a href='admin-managevideos.php?videos=all-videos'><div class="content-nav-badges" id='video-list'>Video List</div></a>
                            <a href='admin-managevideos.php?videos=add-movies'><div class="content-nav-badges" id='add-movie'>Add Movie</div></a>
                            <a href='admin-managevideos.php?videos=live-movies'><div class="content-nav-badges" id='live-movie'>Live Movies</div></a>
                            <a href='admin-managevideos.php?videos=add-webseries'><div class="content-nav-badges" id='add-webseries'>Add Web-Series</div></a>
                            <a href='admin-managevideos.php?videos=add-episodes'><div class="content-nav-badges" id='add-episodes'>Add Episode</div></a>
                            <a href='admin-managevideos.php?videos=live-webseries'><div class="content-nav-badges" id='live-webseries'>Live Web-Series</div></a>
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
    if(isset($_GET['videos']))
    {
        $page = $_GET['videos'];
    }
    
    switch ($page) {
        case 'all-videos':
            include_once "../proccess/admin-all-videos.php";
            break;
        case 'add-movies':
            include_once "../proccess/admin-add-movie.php";
            break;
        case 'live-movies':
            include_once "../proccess/admin-live-movie.php";
            break;
        case 'add-webseries':
            include_once "../proccess/admin-add-webseries.php";
            break;
        case 'add-episodes':
            include_once "../proccess/admin-add-episode.php";
            break;
        case 'live-webseries':
            include_once "../proccess/admin-live-webseries.php";
            break;
        default:
            include_once "../proccess/admin-all-videos.php";
            break;
    }
?>
                </div>
        </div><!--content-->
    </div><!--inner-wrapper-->
</div><!--admin-wrapper--->

<script src='../assets/js/manage-videos.js'></script>  
<?php include "../includes/admin-footer.php";  ?>
