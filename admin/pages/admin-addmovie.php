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
                        <a href="admin-addmovie.php" class="content-nav-badges" style="background-color: #D2DFEA;">Add Movie</a>
                        <a href="admin-livemovie.php" class="content-nav-badges">Live Movies</a>
                        <a href="admin-addwebseries.php" class="content-nav-badges">Add Web-Series</a>
                        <a href="admin-livewebseries.php" class="content-nav-badges">Live Web-Series</a>  
                    </div>
                    <div class="content-nav-right">
                        <input type="search" placeholder="Search" class='content-search-bar'>
                        <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                    </div>
                </div>
                <hr>
                    <form action="" class='form-wrapper'>
                        <div class="main-content">
                            <div class="main-content-left form-group">
                                <input type="text" class="form-control" placeholder="Enter Movie Title">
                                <br>
                                <textarea type="text" class="form-control" placeholder="Add description"></textarea>
                                <br>
                                <input type="text" class="form-control" placeholder="Select a Category">
                                <br>
                                <input type="text" class="form-control" placeholder="Enter Movie Title">
                                <br>
                                    <select id="inputState" class="form-control" placeholder="Select part number">
                                        <option selected>Select video status</option>
                                        <option>Paid</option>
                                        <option>Free</option>
                                    </select>
                            </div>
                            <div class="main-content-right form-group">
                                <input type="text" class="form-control" placeholder="Add Thumbnail">
                                <br>
                                <input type="text" class="form-control" placeholder="Add Casting">
                                <br>
                                <input type="text" class="form-control" placeholder="Enter link or Embeded Code">
                            </div>
                        </div>
                        <button class="btn btn-primary">Publish</button>
                    </form>

        </div>

    </div>
</div>
        <?php include "../includes/admin-footer.php"; ?>