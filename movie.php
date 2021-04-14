<?php include "includes/header.php"; ?>
<link rel="stylesheet" href="assets/css/movie-web.css">

</head>
<body>
    
    <div id="plans"></div>

<div class="full-size">
<?php include "includes/nav.php"; ?>
<?php
if(isset($_GET['movie_id']))
{
    $movie_id = $_GET['movie_id'];
}
?>
<?php include "includes/single-movie.php"; ?>

<?php include "includes/footer.php"; ?>