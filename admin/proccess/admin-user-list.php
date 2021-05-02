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
                        <th>Role</th>
                        <th>Active plan</th>
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
                        <td>";
                        if($row['role'] == 'admin')
                        {
                            $output.="<span class='badge badge-warning mx-1 py-1 px-2'>{$row['role']}</span>";
                        }else{
                            $output.="{$row['role']}";
                        }
                        $output.="</td>
                        <td>{$row['pricing']}</td>
                        <td class='d-flex justify-content-around'>
                            <button class='btn btn-info ml-2 make-user-delete' data-id='{$row['id']}'><i class='fa fa-trash text-white'></i></button>
                            <button class='btn btn-success make-user-active'";
                            if($row['status'] == 'active') $output.='disabled';
                            $output.=" data-id='{$row['id']}'><i class='fa fa-check text-white'></i></button>
                            <button class='btn btn-danger mx-2 make-user-blocked'";
                            if($row['status'] == 'blocked') $output.='disabled';
                            $output.=" data-id='{$row['id']}'><i class='fa fa-ban text-white'></i></button>
                        </td>
                        </tr>";
                        $count++;
                    }

            $output.="</thead>
                        </table>
                            </div>";


echo $output;