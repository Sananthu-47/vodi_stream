<?php include "includes/header.php"; ?>
<link rel="stylesheet" href="assets/css/movie-web.css">

</head>
<body>
    
    <div id="plans"></div>

<div class="full-size">
<?php include "includes/nav.php"; ?>
<?php
if(isset($_GET['webseries_id']))
{
    $webseries_id = $_GET['webseries_id'];
}
if(isset($_GET['episode_id']))
{
    $episode_id = $_GET['episode_id'];
}
?>
<?php
if(isset($_GET['type'])){
    include "includes/single-episode.php"; 
}else{
    include "includes/single-webseries.php"; 
}
?>

<?php include "includes/footer.php"; ?>