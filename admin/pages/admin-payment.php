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
                        <div id='payment-list' class="content-nav-badges active-background">Users Payment</div>
                        <div id='update-payment' class="content-nav-badges">Update Payments</div>
                    </div>
                    <div class="content-nav-right">
                        <input type="search" placeholder="Search" class='content-search-bar'>
                        <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                    </div>
                </div>
                <hr>
                    <div class="admin-main-content">
                        <?php include "../proccess/admin-list-of-payment.php"; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php include "../includes/admin-footer.php";  ?>
