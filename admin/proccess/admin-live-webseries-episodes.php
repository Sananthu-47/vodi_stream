<?php
include_once "../includes/db.php";
include "../../Classes/Webseries.php";
include "../../Classes/Category.php";
$Webseries = new Webseries($connection);
$Category = new Category($connection);
$output = '';
$count = 1;
$result = $Webseries->get_all_webseries_seasons();

$output.="<div class='content-table-wrapper'>
<table class='table'>
    <thead class='thead-dark'>
    <tr class='text-center'>
        <th>Id</th>
        <th>Webseries</th>
        <th>Title</th>
        <th>Category</th>
        <th>Season</th>
        <th>Episode</th>
        <th>Status</th>
        <th>Language</th>
        <th>Duration</th>
        <th>Released</th>
        <th>Action</th>
    </tr>";


    while($row = mysqli_fetch_assoc($result))
                    {
                        $webseries_data = $Webseries->get_webseries_by_id($row['webseries_id']);
                        $webseries_data = mysqli_fetch_assoc($webseries_data);

                        $output.="
                        <tr class='text-center'>
                        <td>{$count}</td>";

                        $output.="<td>{$webseries_data['title']}</td>
                        <td>{$row['title']}</td>
                        <td>";
                        $all_categories = explode(',',$webseries_data['category']);
                        foreach ($all_categories as $key => $category) {
                            $output.="<span class='badge badge-info mx-1 py-1 px-2'>{$category}</span>";
                        }
                        $output.="</td>
                        <td><span class='badge badge-danger py-1 px-2'>{$row['season_number']}</span></td>
                        <td><span class='badge badge-warning py-1 px-2'>{$row['episode_number']}</span></td>
                        <td>{$row['status']}</td>
                        <td>{$webseries_data['language']}</td>
                        <td>{$row['duration']} minutes</td>
                        <td>{$row['release_year']}</td>
                        <td class='d-flex justify-content-around'>
                            <button class='btn btn-info ml-2 make-webseries-episode-delete' data-id='{$row['id']}'><i class='fa fa-trash text-white'></i></button>
                            <button class='btn btn-primary mx-2' data-id='{$row['id']}'><i class='fa fa-pencil-square-o text-white'></i></button>
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