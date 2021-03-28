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
                        <a href="admin-payment.php" class="content-nav-badges">Users Payment</a>
                        <a href="admin-update-payments.php" class="content-nav-badges" style="background-color: #D2DFEA;">Update Payments</a>
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
                                <label for="">Monthly</label>
                                <input type="number" class="form-control" placeholder="Enter payment Category">
                                <br>
                                <label for="">Monthly</label>
                                <input type="number" class="form-control" placeholder="Enter payment Category">
                                <br>
                                <label for="">Monthly</label>
                                <input type="number" class="form-control" placeholder="Enter payment Category">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include "../includes/admin-footer.php";  ?>
