<?php include "db.php";  
global $connection;
$USER_LOGIN_ID = '';
session_start();
if(isset($_SESSION['user_id']))
{
    $USER_LOGIN_ID = $_SESSION['user_id'];
}else{
  header('Location: ../../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!--Title-->
    <title>Admin Login Page</title>

    <!--Favicon-->
    <link rel="shortcut icon" href="../../images/star-1.jpg" type="image/x-icon">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css"></link>
    <link rel="stylesheet" href="../../assets/font-awesome/css/font-awesome.min.css"></link>
    <script src="../../assets/jQuery/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Titan+One&family=Archivo+Black&family=Montserrat&display=swap" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">

