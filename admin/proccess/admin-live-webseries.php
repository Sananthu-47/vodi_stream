<?php
include_once "../includes/db.php";
include "../../Classes/Webseries.php";
include "../../Classes/Category.php";
$Webseries = new Webseries($connection);
$Category = new Category($connection);
$output = '';
$count = 1;
$result = $Webseries->get_all_webseries();

$output.="<div class='content-table-wrapper'>
<table class='table'>
    <thead class='thead-dark'>
    <tr class='text-center'>
        <th>Id</th>
        <th>Webseries</th>
        <th>Category</th>
        <th>Season</th>
        <th>Total Episodes</th>
        <th>Status</th>
        <th>Age</th>
        <th>Language</th>
        <th>Released</th>
        <th>Action</th>
    </tr>";


    while($row = mysqli_fetch_assoc($result))
                    {
                        $webseries_data = $Webseries->get_webseries_by_id_admin($row['id']);
                        $webseries_data = mysqli_fetch_assoc($webseries_data);
                        $webseries_episodes = $Webseries->get_all_webseries_seasons_by_seriesid_admin($row['id']);


                        $output.="
                        <tr class='text-center'>
                        <td>{$count}</td>";

                        $output.="<td>{$webseries_data['title']}</td>
                        <td>";
                        $all_categories = explode(',',$webseries_data['category']);
                        foreach ($all_categories as $key => $category) {
                            $output.="<span class='badge badge-info mx-1 py-1 px-2'>{$category}</span>";
                        }
                        $output.="</td>
                        <td><span class='badge badge-danger py-1 px-2'>{$row['season_number']}</span></td>
                        <td><span class='badge badge-warning py-1 px-2'>";
                        $output.=mysqli_num_rows($webseries_episodes);
                        $output.="</span></td>
                        <td>{$row['status']}</td>
                        <td>{$webseries_data['age']}+</td>
                        <td>{$webseries_data['language']}</td>
                        <td>{$row['release_year']}</td>
                        <td class='d-flex justify-content-around'>
                            <button class='btn btn-info ml-2 make-webseries-delete' data-id='{$row['id']}'><i class='fa fa-trash text-white'></i></button>
                            <a href='admin-update.php?webseries-id={$webseries_data['id']}'><button class='btn btn-primary mx-2'><i class='fa fa-pencil-square-o text-white'></i></button></a>
                            <button class='btn btn-success make-webseries-active'";
                            if($row['watchable'] == 'active') $output.='disabled';
                            $output.=" data-id='{$row['id']}'><i class='fa fa-check text-white'></i></button>
                            <button class='btn btn-danger mx-2 make-webseries-blocked'";
                            if($row['watchable'] == 'blocked') $output.='disabled';
                            $output.=" data-id='{$row['id']}'><i class='fa fa-ban text-white'></i></button>
                        </td>
                        </tr>";
                        $count++;
                    }


    $output.="</thead>
</table>
</div>";

echo $output;