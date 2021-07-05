<?php include "includes/header.php"; 
include 'Classes/User.php';
$User = new User($connection);
include "includes/side-nav.php"; 
?>
<style>
    .login-modal{
        min-width: 50%;
        min-height: 50%;
        padding: 40px;
        border-radius: 10px;
        margin: 20px 0;
    }
    .full-size{
        height: fit-content;
    }
</style>
</head>
<body>
    
<div id="plans"></div>

<div class="full-size">

    <div class="custom-navbar text-white d-flex flex-row">
        <div class="nav-left-side d-flex col-lg-8">
            <div class="left-side-nav-first d-flex align-items-center  px-1">
                <i class='fa fa-bars pr-3' id='hamburger-menu'></i>
                <a href='index.php'><div id="logo">vodi</div></a>
            </div><!---left-side-nav-first-->
                <ul class='nav left-side-nav-second col-lg-8 d-flex justify-content-around align-items-center'>
                    <a href='index.php'><li class='nav-item'>Home</li></a>
                    <a href='all-movies.php'><li class='nav-item'>Movies</li></a>
                    <a href='all-webseries.php'><li class='nav-item'>Web series</li></a>
                    <?php 
                    if($User->check_account_is_premium($USER_LOGIN_ID))
                        {
                        echo "<li class='nav-item planings'>Upgrade</li>";
                        }
                    if($User->check_admin_or_not($USER_LOGIN_ID))
                        {
                        echo "<a href='admin/pages/index.php'><li class='nav-item admin-login'>Admin</li></a>";
                        }
                    ?>
                </ul><!--left-side-nav-second- -->
        </div><!---nav-left-side-->
    </div>

    <div class='d-flex justify-content-center'>
        <div class='bg-white row login-modal'>
            <div class="col-12 col-lg-12 col-xl-6 modal-left-side">
                <span class='my-2 h3'>Register</span>
                <form action="#" id='register-form' class='d-flex flex-column justify-content-between my-3 left-form'>
                    <label for="username-register">Username*</label>
                    <input type="text" name='username-register' id='username-register' class='input-modal mb-3'>
                    <label for="email-register">Email*</label>
                    <input type="email" name='email-register' id='email-register' class='input-modal mb-3'>
                    <label for="mobile-number-register">Mobile number*</label>
                    <input type="number" name='mobile-number-register' id='mobile-number-register' class='input-modal mb-3'>
                    <label for="passowrd-register">Password*</label>
                    <input type="password" name='password-register' id='password-register' class='input-modal mb-3'>
                    <button class="btn btn-info py-2 my-3" id='register'><span class='h5'>Register</span></button>
                </form>
            </div>
            <div class="col-12 col-lg-12 col-xl-6 modal-right-side">
                <span class='my-2 h3'>Login</span>
                    <form action="#" id='login-form' class='d-flex flex-column justify-content-between my-3'>
                        <label for="email-number-login">Email or Mobile number*</label>
                        <input type="email" name='email-number-login' id='email-number-login' class='input-modal mb-3'>
                        <label for="passowrd-login">Password*</label>
                        <input type="password" name='password-login' id='password-login' class='input-modal mb-3'>
                        <button class="btn btn-info py-2 my-3" id='login'><span class='h5'>Login</span></button>
                    </form>
            </div>
        </div>
    </div>

</div>

<script src='assets/js/signin.js'></script>

<?php include "includes/footer.php"; ?>