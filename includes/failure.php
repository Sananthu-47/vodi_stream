<?php
include "db.php";
include "header.php";
$status=$_POST["status"];
$name=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt="--Check salt--";
$_SESSION['user_id'] = $USER_LOGIN_ID;

// Salt should be same Post Request 

if(isset($_POST["additionalCharges"])) {
      $additionalCharges=$_POST["additionalCharges"];
      $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$name.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
    } else {
      $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$name.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
    }
    $hash = strtolower(hash("sha512", $retHashSeq));
  
       if ($hash != $posted_hash) {
	       echo "Invalid Transaction. Please try again";
		   } else {
         echo "<div class='alert alert-danger text-center'>";
         echo "<h3>Your payment is failed while processing</h3>";
         echo "<h4>Please try again!!!</h4>";
         echo "<h4>Page redirects in 5 seconds</h4>";
         echo "</div>";
         echo "<script> window.setTimeout(function(){
          window.location.href='../checkout.php';
          }, 5000);</script>";
		 } 
?>
