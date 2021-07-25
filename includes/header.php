<?php include "db.php";  
global $connection;
$USER_LOGIN_ID = '';
date_default_timezone_set('Asia/Kolkata');
ob_start();
session_start();
if(isset($_SESSION['user_id']))
{
    $USER_LOGIN_ID = $_SESSION['user_id'];
//if(strtotime(date("Y/m/d")) < strtotime($date2)) echo "Active"; else echo "Expired";
}else{
    $USER_LOGIN_ID = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vodi</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"></link>
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css"></link>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
    <script src="assets/jQuery/jquery.min.js"></script>
    <script src="https://cdn.plyr.io/3.6.8/plyr.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/pricing.css">

