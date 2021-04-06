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
                        <div class="content-nav-left" id='sub-nav'>
                        <a href='admin-manageuser.php?users=all-users'><div class="content-nav-badges" id='user-list'>User List</div></a>
                        <a href='admin-manageuser.php?users=add-users'><div class="content-nav-badges" id='add-user'>Add User</div></a>
                        </div>
                        <div class="content-nav-right">
                            <input type="search" placeholder="Search" class='content-search-bar'>
                            <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                        </div>
                    </div>
                    <hr>
                        <div class="main-content">
                            
<?php
    $page = '';
    if(isset($_GET['users']))
    {
        $page = $_GET['users'];
    }
    
    switch ($page) {
        case 'all-users':
            include_once "../proccess/admin-user-list.php";
            break;
        case 'add-users':
            include_once "../proccess/admin-add-user.php";
            break;
        default:
            include_once "../proccess/admin-user-list.php";
            break;
    }
?>
                        </div>
                </div>
            </div>
        </div>

        <script src='../assets/js/manage-users.js'></script>  
        <?php include "../includes/admin-footer.php";  ?>
