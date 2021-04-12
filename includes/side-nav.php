<div class="modal-background" id='sidenav' style='display:none'>
    <div class="side-nav d-flex flex-column" id='sidenav-div'>
        <ul class='list-group'>
            <li class='list-item'><span>Home</span><i class='fa fa-plus'></i></li>
            <a href='all-movies.php'><li class='nav-item'>Movies <i class='fa fa-plus'></i></li></a>
            <a href='all-webseries.php'><li class='nav-item'>Web series <i class='fa fa-plus'></i></li></a>
            <?php 
                if($User->check_account_is_premium($USER_LOGIN_ID))
                    {
                    echo "<li class='nav-item h3 planings'>Upgrade</li>";
                    }
                    if($User->check_admin_or_not($USER_LOGIN_ID))
                    {
                    echo "<a href='admin/pages/index.php'><li class='nav-item admin-login'>Admin</li></a>";
                    }
                ?>
        </ul>
    </div>
</div>