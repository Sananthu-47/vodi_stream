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
                        <a href="admin-managevideos.php" class="content-nav-badges">Video List</a>
                        <a href="admin-addmovie.php" class="content-nav-badges">Add Movie</a>
                        <a href="admin-livemovie.php" class="content-nav-badges" style="background-color: #D2DFEA;">Live Movies</a>
                        <a href="admin-addwebseries.php" class="content-nav-badges">Add Web-Series</a>
                        <a href="admin-livewebseries.php" class="content-nav-badges">Live Web-Series</a>  
                    </div>
                    <div class="content-nav-right">
                        <input type="search" placeholder="Search" class='content-search-bar'>
                        <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                    </div>
                </div>
                <hr>
                <div class="content-table-wrapper">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Part / Episode</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                </div>
            </div>
        </div>
    </div>
    
        <?php include "../includes/admin-footer.php";  ?>
