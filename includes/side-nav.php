<div class="modal-background" id='sidenav' style='display:none'>
    <div class="side-nav d-flex flex-column" id='sidenav-div'>
        <ul class='list-group'>
            <li class='list-item'><span>Hello</span><i class='fa fa-plus'></i></li>
            <li class='list-item'><span>HHHUUUHkkkkk</span><i class='fa fa-plus'></i></li>
            <li class='list-item'><span>MNMM</span><i class='fa fa-plus'></i></li>
            <li class='list-item'><span>Jkkhg</span><i class='fa fa-plus'></i></li>
            <li class='list-item'><span>Hello</span><i class='fa fa-plus'></i></li>
            <?php 
                if($User->check_account_is_premium($USER_LOGIN_ID))
                    {
                    echo "<li class='nav-item h3 planings'>Upgrade</li>";
                    }
                    if($User->check_admin_or_not($USER_LOGIN_ID))
                    {
                    echo "<li class='nav-item h3 admin-login'>Admin</li>";
                    }
                ?>
        </ul>
    </div>
</div>