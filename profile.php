<?php include "includes/header.php"; ?>
<link rel="stylesheet" href="assets/css/profile.css">
<style>
    .full-size{
        height: fit-content;
    }
</style>
</head>
<body>
    
    <div id="plans"></div>

<div class="full-size">
<?php include "includes/nav.php";
include_once "Classes/Payment.php";
$Payment = new Payment($connection);
?>

<?php
    if($USER_LOGIN_ID == ''){
        header("Location: index.php");
    }
?>

    <div class="profile-wrapper">
        <div class="left-profile col-3 p-0">
            <ul class='list-group'>
                <a href='profile.php'><li class='list-group-item active'><i class='fa fa-user px-2'></i>Dashboard</li></a>
            </ul>
        </div>
        <div class="right-profile col-9 p-0">
            <div id='profile-img-big' class='d-flex justify-content-center align-items-center' style="background-color:<?php echo $User->get_user_detail_by_id('color',$USER_LOGIN_ID); ?>;">
                <i class='fa fa-user fa-2x'></i>
            </div>
            <div class="deatils-row">
                <span>Name:</span>
                <input type="text" readonly value='<?php echo $User->get_user_detail_by_id('username',$USER_LOGIN_ID); ?>'>
            </div>
            <div class="deatils-row">
                <span>Email:</span>
                <input type="text" readonly value='<?php echo $User->get_user_detail_by_id('email',$USER_LOGIN_ID); ?>'>
            </div>
            <div class="deatils-row">
                <span>Phone number:</span>
                <input type="text" readonly value='<?php echo $User->get_user_detail_by_id('mobile_number',$USER_LOGIN_ID); ?>'>
            </div>
            <div class="deatils-row">
                <span>Current pack:</span>
                <input type="text" readonly value='<?php 
                $payment_id = $User->get_user_detail_by_id('payment_id',$USER_LOGIN_ID); 
                if($payment_id == 0){
                    echo "Free Tier";
                }else{
                    $pack_deatil = $Payment->getAllPaymentById($payment_id); 
                    $pack_deatil = mysqli_fetch_assoc($pack_deatil);
                    if($pack_deatil['pack'] == 1){
                        echo "Starter Pack";
                    }else if($pack_deatil['pack'] == 2){
                        echo "Basic Pack";
                    }else if($pack_deatil['pack'] == 3){
                        echo "Proffesional Pack";
                    }else if($pack_deatil['pack'] == 4){
                        echo "Ultra Pack";
                    }
                }
                ?>'>
            </div>
            <?php if($payment_id != 0){ ?>
            <div class="deatils-row">
                <span>Pack Ends On:</span>
                <input type="text" readonly value='<?php echo date("d-m-Y", strtotime($pack_deatil['expiry_date'])); ?>'>
            </div>
            <?php } ?>
        </div>
    </div>

</div>

<?php include "includes/footer.php"; ?>