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
                        <a href="admin-payment.php" class="content-nav-badges" style="background-color: #D2DFEA;">Users Payment</a>
                        <a href="admin-update-payments.php" class="content-nav-badges">Update Payments</a>
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
                                    <th>Username</th>
                                    <th>Email Id</th>
                                    <th>Mobile</th>
                                    <th>Active plan</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php include "../includes/admin-footer.php";  ?>
