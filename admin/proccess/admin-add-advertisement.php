<?php include_once "../includes/db.php"; 
if(isset($_GET['id']) && isset($_GET['type'])){
    $video_id = $_GET['id'];
    $type = $_GET['type'];
    $name = $_GET['name'];
}else{
    $video_id = '';
    $type = '';
    $name = '';
}
?>
<div class='part-selection-wrapper' style='display:none'>
    <div class='part-selection'>
        <div class='text-header'><span>Choose the video to get a advertisement</span><i class='fa fa-close' id='close-parts'></i></div>
        <div class='part-select-header'>
            <div class='d-flex'>
                <input type='text' class='form-control mx-1' placeholder='Search...' id='search-part-title'>
                <select class='movie-part' data-type='' class='form-control w-50 mx-1'>
                    <option value='0'>Any</option>
                    <?php for($i=1;$i<=50;$i++){
                        echo "<option value='{$i}'>Part {$i}</option>";
                    } ?>
                </select>
                <select id='language' class='form-control w-50 mx-1'>
                <option value='0'>All</option>
                    <?php $result = mysqli_query($connection,"SELECT language FROM language");
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo "<option value='{$row['language']}'>{$row['language']}</option>";
                    }?>
                </select>
            </div>
            <button class='btn btn-primary mx-auto my-2' id='search-parts' data-type=''>Search</button>
        </div>
        <div class='searched-parts'>
            <span>Searched results for part <span id='part-number'></span></span>
            <div class='all-movies-holder'>
                
            </div>
        </div>
    </div>
</div>

<form class='form-wrapper'>
    <div class='main-content'>
        <div class='main-content-left form-group'>
            <label for='' class='badge badge-dark <?php if($type != ''){
                echo 'd-none';
            } ?>'>Select type:</label>
            <select name="" id="video-type" class='form-control' <?php if($type != ''){
                echo 'hidden';
            } ?>>
                <option value="0">Select the type</option>
                <option value="movie" <?php if($type == 'movie') echo "selected"; ?>>Movie</option>
                <option value="ad-episode" <?php if($type == 'episode') echo "selected"; ?>>Episode</option>
            </select>
            <br>
            <label for="" class='badge badge-dark'>Selected video</label>
            <input type="text" readonly class='form-control' id='selected-video' data-type='<?php echo $type; ?>' data-id='<?php echo $video_id; ?>' placeholder="Selected video" value='<?php echo $name; ?>'>
            <br>
            <label for="" class='badge badge-dark'>Advertisement link</label>
            <div class="d-flex">
                <input type="text" class='form-control' id='link' placeholder="Add link for advertisement" value=''>
                <div class="btn btn-success mx-2 cursor-pointer" id='add-advertisement'>Add</div>
            </div>
            <div id='added-advertisements' class='input-selected-tags' style='display:none'>
                <span class="badge badge-dark my-2">Added advertisements</span>
                <div id="all-advertisements"></div>
            </div>
        <button class='btn btn-primary' id='submit-advertisement'>Submit</button>
        </div>
    </div>
</form>