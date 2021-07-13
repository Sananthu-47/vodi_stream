<?php 
include_once "../includes/db.php";
include "../../Classes/Payment.php";
$Payment = new Payment($connection);
include_once "../../Classes/User.php";
$User = new User($connection);
$all_payments = $Payment->allPayments($connection);
?>

<div class='content-table-wrapper'>
    <table class='table'>
        <thead class='thead-dark'>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Email Id</th>
                <th>Mobile</th>
                <th>Started from</th>
                <th>Ends at</th>
                <th>Active plan</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <?php
        $output = '';
        $count = 1;
            while($row = mysqli_fetch_assoc($all_payments)){
                $user_details = $User->get_all_users_by_id($row['user_id']);
                $user_details = mysqli_fetch_assoc($user_details);
                $pack = $row['pack'];
                $pack_detail = '';
                if($pack == 1){
                    $pack_detail = 'Starter';
                }else if($pack == 2){
                    $pack_detail = 'Basic';
                }else if($pack == 3){
                    $pack_detail = 'Professional';
                }else if($pack == 4){
                    $pack_detail = 'Ultra pro';
                }
                $output.="
                    <tr>
                        <td>$count</td>
                        <td>{$user_details['username']}</td>
                        <td>{$user_details['email']}</td>
                        <td>{$user_details['mobile_number']}</td>
                        <td>{$row['start_date']}</td>
                        <td>{$row['expiry_date']}</td>
                        <td>$pack_detail</td>
                        <td>{$row['amount']}</td>
                        <td><span class='text-capitalize badge ";
                        if($row['status'] == 'active'){
                            $output.="badge-success'>{$row['status']}";
                         }else{ 
                            $output.="badge-danger'>{$row['status']}";
                         }
                        $output.="</span></td>
                    </tr>
                ";
                $count++;
            }
            echo $output;
        ?>
    </table>
</div>