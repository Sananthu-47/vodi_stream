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
                        <a href="admin-manageuser.php" class="content-nav-badges">User List</a>
                        <a href="admin-add-new-user.php" class="content-nav-badges" style="background-color: #D2DFEA;">Add User</a>
                    </div>
                    <div class="content-nav-right">
                        <input type="search" placeholder="Search" class='content-search-bar'>
                        <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                    </div>
                </div>
                <hr>
                    <div class="main-content">
                        <div class="main-content-left">
                            <form>
                                <h2>Create a User</h2>
                                <input type="text" placeholder="Enter user name" name="#" required class="form-control"><br>
                                <input type="email" placeholder="Enter user email" name="#" required class="form-control"><br>
                                <input type="tel" placeholder="Enter user Mobile Number" name="#" required class="form-control"><br>
                                <input type="password" placeholder="Create default password" name="#" required class="form-control"><br>
                                <button class="btn btn-primary">Create a User</button>
                            </form>
                        </div>
                        <div class="main-content-right">
                            <form>
                                <h2>Create a Admin</h2>
                                <input type="text" placeholder="Enter admin name" name="#" required class="form-control"><br>
                                <input type="email" placeholder="Enter admin email" name="#" required class="form-control"><br>
                                <input type="tel" placeholder="Enter admin Mobile Number" name="#" required class="form-control"><br>
                                <input type="password" placeholder="Create default password" name="#" required class="form-control"><br>
                                <button class="btn btn-primary">Create a Admin</button>
                            </form>
                        </div>
                    </div>
        </div>
    </div>
</div>

<?php include "../includes/admin-footer.php"; ?>