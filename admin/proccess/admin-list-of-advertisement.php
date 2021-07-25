<?php 
include_once "../includes/db.php";
include "../../Classes/Advertisement.php";
include_once "../../Classes/Movie.php";
include_once "../../Classes/Webseries.php";
$Advertisement = new Advertisement($connection);
$Movies = new Movie($connection);
$Webseries = new Webseries($connection);
?>
<div class='content-table-wrapper'>
    <table class='table'>
        <thead class='thead-dark'>
        <tr class='text-center'>
            <th>SI no.</th>
            <th>Video</th>
            <th>Category</th>
            <th>Total Ads added</th>
            <th>Action</th>
        </tr>
        </thead>
        <?php 

                $result = $Advertisement->get_videos_with_ads();
                $count = 1;
                while($row = mysqli_fetch_assoc($result)){
                    $name = '';
                    if($row['video_type'] == 'movie'){
                        $movie_details = $Movies->get_all_movies_by_id($row['video_id']);
                        $response = mysqli_fetch_assoc($movie_details);
                        $name = $response['title'].' (Part '.$response['part'].')';
                    }else{
                        $title = $Webseries->get_webseries_episode_by_id_and_search('title' ,$row['video_id']);
                        $season_number = $Webseries->get_webseries_episode_by_id_and_search("season_number",$row['video_id']);
                        $episode_number = $Webseries->get_webseries_episode_by_id_and_search("episode_number",$row['video_id']);
                        $name = $title.' (S0'.$season_number.'E0'.$episode_number.')';
                    }
                    echo "<tr class='text-center tr-$count'>
                            <td>$count</td>
                            <td>$name</td>
                            <td>{$row['video_type']}</td>
                            <td><span id='tot-ad-$count'>{$row['COUNT(video_id)']}</span>/20</td>
                            <td>
                                <button class='btn btn-primary edit' data-tooltip='tooltip' data-placement='auto' title='Edit'data-toggle='collapse' data-id='collapse-$count' data-target='#collapse-{$count}' aria-expanded='false' aria-controls='collapse-{$count}'><i class='fa fa-pencil'></i></button>
                                <a href='admin-advertisement.php?advertisement=add-ads&type={$row['video_type']}&id={$row['video_id']}&name=$name'><button class='btn btn-warning'>Manage<i class='fa fa-plus mx-1'></i></button></a>
                            </td>
                        </tr>
                        <tr class='collapse hide' id='collapse-{$count}'>
                            <td colspan='5'><ul class='list-group'>";
                                $all_ads = $Advertisement->get_advertisement_to_video($row['video_id'],$row['video_type']);
                                $ad_count = 1;
                                while($ad_row = mysqli_fetch_assoc($all_ads)){
                                    echo "<li class='list-group-item list-group-item-warning d-flex justify-content-between'>
                                    <div><span class='badge badge-primary badge-pill'>$ad_count</span> {$ad_row['link']}</div>
                                    <button class='btn btn-danger admin-delete-advertisement' data-id='{$ad_row['id']}' data-count='$count'><i class='fa fa-trash'></i></button></li>";
                                    $ad_count++;
                                }
                            echo "</ul></td>
                        </tr>
                        ";
                    $count++;
                }

        ?>
    </table>
</div>