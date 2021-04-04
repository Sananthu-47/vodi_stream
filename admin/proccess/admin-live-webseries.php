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
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Category</th>
        <th>Season</th>
        <th>Part / Episode</th>
        <th>Status</th>
        <th>Current Status</th>
        <th>Age</th>
        <th>Language</th>
        <th>Duration</th>
        <th>Released</th>
        <th>Action</th>
    </tr>";


    while($row = mysqli_fetch_assoc($result))
                    {
                        $output.="
                        <tr class='text-center'>
                        <td>{$count}</td>
                        <td>{$row['title']}</td>
                        <td>
                        ";

                        $all_categories = $Category->selected_categories_webseries($row['webseries_id']);
                            while($categories = mysqli_fetch_assoc($all_categories))
                            {
                                $category = mysqli_fetch_assoc($Category->get_category_by_id($categories['category_id']));
                                $output.="<span class='badge badge-info mx-1'>{$category['category']}</span>";
                            }

                        $output.="</td>
                        <td>{$row['season_number']}</td>
                        <td>{$row['episode_number']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['watchable']}</td>";

                        $webseries_data = $Webseries->get_webseries_by_id($row['webseries_id']);
                        $webseries_data = mysqli_fetch_assoc($webseries_data);
                        $output.="<td>{$webseries_data['age']}+</td>
                        <td>{$webseries_data['language']}</td>";

                        $output.="<td>{$row['duration']} minutes</td>
                        <td>{$row['release_year']}</td>
                        <td class='d-flex justify-content-around'>
                            <button class='btn btn-info ml-2' data-id='{$row['id']}'><i class='fa fa-trash text-white'></i></button>
                            <button class='btn btn-primary mx-2' data-id='{$row['id']}'><i class='fa fa-pencil-square-o text-white'></i></button>
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