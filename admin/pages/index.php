<?php include "../includes/admin-header.php";  
include_once "../../Classes/Dashboard.php";
$Dashboard = new Dashboard($connection);
?>

  </head>
  <body>
    <div class='admin-wrapper'>
        <div class="inner-wrapper">
            <!--Dashboard Navbar-->
            <?php include "../includes/admin-nav.php"; ?>


            <div class='part-selection-wrapper' style='display:none'>
                <div class='part-selection'>
                    <div class='text-header'><span>Results based on data not added</span><i class='fa fa-close' id='close-parts'></i></div>
                    <div class='part-select-header'>
                        <div class='d-flex'>
                            <input type='text' class='form-control mx-1' placeholder='Search...' id='search-part-title'>
                            <select class='movie-part' class='form-control w-50 mx-1'>
                                <option value='0'>Select part</option>
                                <?php
                                for($i=1;$i<=50;$i++){
                                   echo "<option value='{$i}'>Part {$i}</option>";
                                }?>
                            </select>
                            <select id='language' class='form-control w-50 mx-1'>
                                <option value='0'>All</option>
                                <?php
                                    $result = mysqli_query($connection,"SELECT language FROM language");
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        echo "<option value='{$row['language']}'>{$row['language']}</option>";
                                    }?>
                            </select>
                        </div>
                        <button class='btn btn-primary mx-auto my-2' id='search-parts' data-type='movie'>Search</button>
                    </div>
                    <div class='searched-parts'>
                        <span>Searched results for part <span id='part-number'></span></span>
                        <div class='all-movies-holder'>
                            
                        </div>
                    </div>
                </div>
            </div>


            <!--Components-->
            <div class = "content">
                <div class="content-nav">
                    <div class="content-nav-left">
                        <div class="content-nav-badges active-background" id=''>Dashboard</div>
                    </div>
                    <div class="content-nav-right">
                        <input type="search" placeholder="Search" class='content-search-bar'>
                        <a href="#"><img src="../../images/star-1.jpg" class='profile-image'></a>
                    </div>
                </div>
                    <hr>
                <div class="index-content">
                    <div class="row w-100 pl-4">	
                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 my-3 p-2">
                              <div class="bg-success d-flex">
                                  <div class="col-4 d-flex justify-content-center align-items-center" style="font-size: 42px;">
                                      <i class="fa fa-film fa-lg text-white" aria-hidden="true"></i>
                                  </div>
                                  <div class="col-8 text-center">
                                      <h2 class="text-white"><?php $result = mysqli_query($connection,"SELECT * FROM movies WHERE watchable != 'deleted'");
                                      echo mysqli_num_rows($result); ?></h2>
                                      <h4 class="text-white">Movies</h4>
                                  </div>
                              </div>
                              <a href="admin-managevideos.php?videos=live-movies">
                                <div class="d-flex justify-content-between align-items-center bg-white py-2 border border-success border-3">
                                <small class="text-success ml-2">View details</small>
                                <i class="fa fa-arrow-right text-success mr-2"></i>
                                </div>
                              </a>
                        </div>
  
                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 my-3 p-2">
                            <div class="bg-danger d-flex">
                                <div class="col-4 d-flex justify-content-center align-items-center" style="font-size: 42px;">
                                    <i class="fa fa-file-video-o fa-lg text-white" aria-hidden="true"></i>
                                </div>
                                <div class="col-8 text-center">
                                    <h2 class="text-white"><?php $result = mysqli_query($connection,"SELECT * FROM webseries WHERE watchable != 'deleted' AND part_1_id = '0'");
                                      echo mysqli_num_rows($result); ?></h2>
                                    <h4 class="text-white">Webseries</h4>
                                </div>
                            </div>
                            <a href="admin-managevideos.php?videos=live-webseries">
                            <div class="d-flex justify-content-between align-items-center bg-white py-2 border border-danger border-3">
                            <small class="ml-2 text-danger">View details</small>
                            <i class="fa fa-arrow-right text-danger  mr-2"></i>
                            </div>
                            </a>
                        </div>
  
                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 my-3 p-2">
                            <div class="bg-info d-flex">
                                <div class="col-4 d-flex justify-content-center align-items-center" style="font-size: 42px;">
                                    <i class="fa fa-list fa-lg text-white" aria-hidden="true"></i>
                                </div>
                                <div class="col-8 text-center">
                                    <h2 class="text-white"><?php $result = mysqli_query($connection,"SELECT * FROM webseries_seasons WHERE watchable != 'deleted'");
                                      echo mysqli_num_rows($result); ?></h2>
                                    <h4 class="text-white">All episodes</h4>
                                </div>
                            </div>
                            <a href="admin-managevideos.php?videos=live-webseries-episodes">
                            <div class="d-flex justify-content-between align-items-center bg-white py-2 border border-info border-3">
                            <small class="text-info ml-2">View details</small>
                            <i class="fa fa-arrow-right text-info mr-2"></i>
                            </div>
                            </a>
                        </div>
  
                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 my-3 p-2">
                            <div class="bg-warning d-flex">
                                <div class="col-4 d-flex justify-content-center align-items-center" style="font-size: 42px;">
                                    <i class="fa fa-users fa-lg text-white" aria-hidden="true"></i>
                                </div>
                                <div class="col-8 text-center">
                                    <h2 class="text-white"><?php $result = mysqli_query($connection,"SELECT * FROM users WHERE role = 'user' AND status != 'deleted'");
                                      echo mysqli_num_rows($result); ?></h2>
                                    <h4 class="text-white">Users</h4>
                                </div>
                            </div>
                            <a href="admin-manageuser.php?users=all-users">
                            <div class="d-flex justify-content-between align-items-center bg-white py-2 border border-warning border-3">
                            <small class="text-warning ml-2">View details</small>
                            <i class="fa fa-arrow-right text-warning mr-2"></i>
                            </div>
                            </a>
                        </div>

                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 my-3 p-2">
                            <div class="bg-primary d-flex">
                                <div class="col-4 d-flex justify-content-center align-items-center" style="font-size: 42px;">
                                    <i class="fa fa-lock fa-lg text-white" aria-hidden="true"></i>
                                </div>
                                <div class="col-8 text-center">
                                    <h2 class="text-white"><?php $result = mysqli_query($connection,"SELECT * FROM users WHERE role = 'admin' AND status != 'deleted'");
                                      echo mysqli_num_rows($result); ?></h2>
                                    <h4 class="text-white">Admins</h4>
                                </div>
                            </div>
                            <a href="admin-manageuser.php?users=all-users">
                            <div class="d-flex justify-content-between align-items-center bg-white py-2 border border-primary border-3">
                            <small class="text-primary ml-2">View details</small>
                            <i class="fa fa-arrow-right text-primary mr-2"></i>
                            </div>
                            </a>
                        </div>

                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-12 my-3 p-2">
                            <div class="bg-dark d-flex">
                                <div class="col-4 d-flex justify-content-center align-items-center" style="font-size: 42px;">
                                    <i class="fa fa-credit-card fa-lg text-white" aria-hidden="true"></i>
                                </div>
                                <div class="col-8 text-center">
                                    <h2 class="text-white"><?php $result = mysqli_query($connection,"SELECT * FROM users WHERE pricing != 'free' AND status != 'deleted'");
                                      echo mysqli_num_rows($result); ?></h2>
                                    <h4 class="text-white">Paid user</h4>
                                </div>
                            </div>
                            <a href="admin-manageuser.php?users=all-users">
                            <div class="d-flex justify-content-between align-items-center bg-white py-2 border border-dark border-3">
                            <small class="text-dark ml-2">View details</small>
                            <i class="fa fa-arrow-right text-dark mr-2"></i>
                            </div>
                            </a>
                        </div>
                    </div><!--row-->

                    <div class='dashboard-sections'>
                        <div class="feature-header">
                            <span>Home page feature <span class='text-danger'>(Max 5)</span></span>
                        </div><!--feature-header-->
                        <div class='features-glider' id='home-featured'>

                            <!--JS data insertion-->

                        </div><!--features-glider-->
                        <div class="add-more-group" style='display:none;' id='home-featured-more'>
                            <div class="selcted-home category-tags d-none" data-id=''></div>
                            <select id="" data-feature='home' class='feature-type mx-2'>
                                <option value="0" slected>Select to add</option>
                                <option value="movie">Movie</option>
                                <option value="webseries">Webseries</option>
                                <option value="episode">Episode</option>
                            </select>
                            <button id='home-feature' data-id='' data-type='' data-feature='home' class="btn btn-success mx-2 feature-add">Add</button>
                        </div><!---add-more-group-->
                    </div><!--dashboard-section-->

                    <div class='dashboard-sections'>
                        <div class="feature-header">
                            <span>Featured Shows <span class='text-danger'>(Max 10)</span></span>
                        </div><!--feature-header-->
                        <div class='features-glider' id='featured-shows'>

                            <!---JS data will be inserted--->
                            
                        </div><!---features-glider-->
                        <div class="add-more-group" style='display:none;' id='featured-show-more'>
                            <div class="selcted-featured category-tags d-none" data-id=''></div>
                            <select id="" data-feature='featured' class='feature-type mx-2'>
                                <option value="0" slected>Select to add</option>
                                <option value="movie">Movie</option>
                                <option value="webseries">Webseries</option>
                                <option value="episode">Episode</option>
                            </select>
                            <button id='show-featured' data-feature='featured' class="btn btn-success mx-2 feature-add">Add</button>
                        </div><!---add-more-group-->
                    </div><!--dashboard-section-->

                </div><!--index-content--->
            </div>
        </div>
    </div>
    <script src="../assets/js/dashboard.js"></script>
        <?php include "../includes/admin-footer.php"; ?>
