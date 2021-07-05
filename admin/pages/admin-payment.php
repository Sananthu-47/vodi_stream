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
                    <div class="content-nav-left" id="sub-nav">
                        <a href='admin-payment.php?payment=user-list'><div class="content-nav-badges">Users Payment</div></a>
                        <a href='admin-payment.php?payment=update'><div class="content-nav-badges">Update Payments</div></a>
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
                            if(isset($_GET['payment']))
                            {
                                $page = $_GET['payment'];
                            }
                            
                            switch ($page) {
                                case 'user-list':
                                    include_once "../proccess/admin-list-of-payment.php";
                                    break;
                                case 'update':
                                    include_once "../proccess/admin-update-payments.php";
                                    break;
                                default:
                                    include_once "../proccess/admin-list-of-payment.php";
                                    break;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src='../assets/js/payment.js'></script>  
        <?php include "../includes/admin-footer.php";  ?>
