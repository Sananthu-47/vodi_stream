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
                        <a href="admin-advertisement.php?advertisement=ads-list"><div class="content-nav-badges">List of Ad's</div></a>
                        <a href="admin-advertisement.php?advertisement=add-ads"><div class="content-nav-badges">Add advertisement</div> </a>
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
                        if(isset($_GET['advertisement']))
                        {
                            $page = $_GET['advertisement'];
                        }
                        
                        switch($page){
                            case 'ads-list':
                                include_once "../proccess/admin-list-of-advertisement.php";
                                break;
                            case 'add-ads':
                                include_once "../proccess/admin-add-advertisement.php";
                                break;
                            default:
                                include_once "../proccess/admin-list-of-advertisement.php";
                                break;
                        }
                    ?>
                </div>

        </div>

    </div>
</div>
<script src='../assets/js/advertisements.js'></script>  
<?php include "../includes/admin-footer.php"; ?>