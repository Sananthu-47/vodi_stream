<?php
// session_start();
include "db.php";
include "header.php";
$status = $_POST['status'];
$productinfo=$_POST["productinfo"];
$product_info_details =explode('*',$productinfo); // [user_id,productinfo]
$user = $product_info_details[0];
$package = $product_info_details[1];
$_SESSION['user_id'] = $user;
$name=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$email=$_POST["email"];
$salt="--Check salt--";
$start_date = date("Y-m-d");
$expiry_date = 0;
if($package == 1){
  $expiry_date = date('Y-m-d', strtotime('+1 months'));
}else if($package == 2){
  $expiry_date = date('Y-m-d', strtotime('+3 months'));
}else if($package == 3){
  $expiry_date = date('Y-m-d', strtotime('+6 months'));
}else if($package == 4){
  $expiry_date = date('Y-m-d', strtotime('+1 years'));
}

?>
</head>
  <body>

<?php

    if(isset($_POST["additionalCharges"])) {
        $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$name.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
      } else {
        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$name.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
      }

    
    $hash = strtolower(hash("sha512", $retHashSeq));
    if ($hash != $posted_hash) {
    echo "<div class='alert alert-danger'>Invalid Transaction. Please try again</div>
    <script> window.setTimeout(function(){
      window.location.href='../index.php';
      }, 5000);</script>
    ";
    } else {

        echo '<div class="alert alert-success m-auto">
        <h4 class="alert-heading">Your subscription is successfully bought!</h4>
        <h4>Your Transaction Id: '.$txnid.'</h4>
        <h4>You spent Rs. '.$amount.' on the pack</h4>
        <p>You will be redirected to Home page in 5 seconds</p>
        
        <script> window.setTimeout(function(){
            window.location.href="../index.php";
            }, 5000);</script>
        </div>'; 

        $query = "INSERT INTO `payments` (`transaction_id`, `user_id`, `amount`, `start_date`, `expiry_date`, `status` , `pack`) VALUES ('$txnid', '$user', '$amount', '$start_date', '$expiry_date', 'active','$package')";
        $ordered = mysqli_query($connection,$query);
        $last_id = mysqli_insert_id($connection);
        $query = "UPDATE `users` SET `pricing` = 'paid' , `payment_id` = '$last_id' WHERE `id` = '$user'";
        $result = mysqli_query($connection,$query);

        $subject  = "Order successfully placed";
        $email =$email;
        $body  = "Hello $name, <br>
                <h2>Your subscription is successfully bought!</h2> <br>
                Your transaction number: $txnid <br>
                Pack price: $amount <br>
                Thank You For Purchasing the subscription for<br> Vodi";
                $sender_email  = 'From: funtocode123@gmail.com' . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8';
        mail($email, $subject, $body, $sender_email);
        if(mail($email, $subject, $body, $sender_email)) { 

        } 

    }

?>

  </body>
</html>