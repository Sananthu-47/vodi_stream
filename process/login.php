<?php
include_once "../includes/db.php";
include "../Classes/User.php";
$User = new User($connection);

$error = [];
$email_number = $_POST['email_number'];
$password = $_POST['password'];

$vaild = $User->valid_email($email_number);
if($vaild)
{
    $type = 'email';
}else{
    $type = 'number';
}

if($email_number=='')
{
   array_push($error,['1' => 'You have not entered email/number']);
}
if($password=='')
{
    array_push($error,['2' => 'You have not entered password']);
}
if(count($error)==0)
{
    if($data = $User->login_user($email_number,$password,$type))
    {
        session_start();
        $_SESSION['user_id'] = $data['id'];
        array_push($error,['3' => 'Successfully logged in']);
    }else{
        array_push($error,['4'=>"Your email/password doesn't match"]);
    }
}

echo json_encode($error);