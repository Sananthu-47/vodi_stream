<?php
include_once "../includes/db.php";
include "../../Classes/User.php";
$User = new User($connection);
$output = '';
$count = 1;
$result = $User->get_all_users();

$output.="<div class='content-table-wrapper'>
            <table class='table'>
                <thead class='thead-dark'>
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>Email Id</th>
                        <th>Mobile</th>
                        <th>Active plan</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>";

                    while($row = mysqli_fetch_assoc($result))
                    {
                        $output.="
                        <tr>
                        <td>{$count}</td>
                        <td>User{$row['id']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['mobile_number']}</td>
                        <td>{$row['pricing']}</td>
                        <td>{$row['status']}</td>
                        <td class='d-flex justify-content-around'>
                            <button class='btn btn-info mx-2' data-id='{$row['id']}'><i class='fa fa-trash text-white'></i></button>
                            <button class='btn btn-success' data-id='{$row['id']}'><i class='fa fa-check text-white'></i></button>
                            <button class='btn btn-danger mx-2' data-id='{$row['id']}'><i class='fa fa-ban text-white'></i></button>
                        </td>
                        </tr>";
                        $count++;
                    }

            $output.="</thead>
                        </table>
                            </div>";


echo $output;