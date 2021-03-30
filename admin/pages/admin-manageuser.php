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
                            <div class="content-nav-badges active-background" id='user-list'>User List</div>
                            <div class="content-nav-badges" id='add-user'>Add User</div>
                        </div>
                        <div class="content-nav-right">
                            <input type="search" placeholder="Search" class='content-search-bar'>
                            <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                        </div>
                    </div>
                    <hr>
                        <div class="main-content">
                            <?php include "../proccess/admin-user-list.php"; ?>
                        </div>
                </div>
            </div>
        </div>

        <?php include "../includes/admin-footer.php";  ?>
