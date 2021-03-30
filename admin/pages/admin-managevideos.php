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
                        <div class="content-nav-left">
                            <div class="content-nav-badges active-background" id='video-list'>Video List</div>
                            <div class="content-nav-badges" id='add-movie'>Add Movie</div>
                            <div class="content-nav-badges" id='live-movie'>Live Movies</div>
                            <div class="content-nav-badges" id='add-webseries'>Add Web-Series</div>
                            <div class="content-nav-badges" id='live-webseries'>Live Web-Series</div>  
                        </div>
                        <div class="content-nav-right">
                            <input type="search" placeholder="Search" class='content-search-bar'>
                            <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                        </div>
                </div>
            <hr>
                <div class="admin-main-content">
                    <?php include "../proccess/admin-all-videos.php"; ?>
                </div>
        </div><!--content-->
    </div><!--inner-wrapper-->
</div><!--admin-wrapper--->

    
<?php include "../includes/admin-footer.php";  ?>
