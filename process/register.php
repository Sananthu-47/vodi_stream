<?php
include_once "../includes/db.php";
include "../Classes/User.php";
$User = new User($connection);

$username = $_POST['username'];
$email = $_POST['email'];
$mobile_number = $_POST['mobile_number'];
$password = $_POST['password'];
$role = $_POST['role'];
$erorr_array = [];

if($username=='') 
{
    array_push($erorr_array,0);
}
if($email=='' || !$User->valid_email($email))
{
    array_push($erorr_array,1);
}
if($mobile_number=='') 
{
    array_push($erorr_array,2);
}
if($password=='')
{
    array_push($erorr_array,3);
}

if(count($erorr_array)>0)
{
    echo json_encode($erorr_array);
}else{
if($User->check_user_exists($email,$mobile_number))
{
    echo 4;
}else{
    $User->add_user($username,$email,$mobile_number,$password,$role);
    echo 5;
}
}