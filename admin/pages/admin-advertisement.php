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
                        <div id='advertisement-list' class="content-nav-badges active-background">List of Ad's</div> 
                        <div id='add-advertisement' class="content-nav-badges">Add advertisement</div> 
                    </div>
                    <div class="content-nav-right">
                        <input type="search" placeholder="Search" class='content-search-bar'>
                        <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                    </div>
                </div>
                <hr>

                <div class="admin-main-content">
                    <?php include "../proccess/admin-list-of-advertisement.php"; ?>
                </div>

        </div>

    </div>
</div>
        <?php include "../includes/admin-footer.php"; ?>