<?php include 'Classes/Category.php';
            $Category = new Category($connection);
?>

<footer class='site-footer dark' role='contentinfo'>
<div class='footer-holder'>
    <div class='footer-top-bar'>
        <div class='footer-logo'>
            <a href='#' rel='home'> <div id='logo'>vodi</div></a>
        </div>
        <div class='footer-social-icons'>
            <ul class='social-icons d-flex align-items-center'>
                <li class='list-item px-3'>
                    <i class='fa fa-facebook-f fa-social-icon' aria-hidden='true'></i> <span class='social-media-item__title'>Facebook<span>
                </li>
                <li class='list-item px-3'>
                    <i class='fa fa-twitter fa-social-icon' aria-hidden='true'></i> <span class='social-media-item__title'>Twitter<span>
                </li>
                <li class='list-item px-3'>
                    <i class='fa fa-google-plus fa-social-icon' aria-hidden='true'></i> <span class='social-media-item__title'>Google plus<span>
                </li>
                <li class='list-item px-3'>
                    <i class='fa fa-globe fa-social-icon' aria-hidden='true'></i> <span class='social-media-item__title'>Vimeo<span>
                </li>
                <li class='list-item px-3'>
                    <i class='fa fa-rss fa-social-icon' aria-hidden='true'></i> <span class='social-media-item__title'>RSS<span>
                </li>
            </ul>
        </div>
    </div> 
    <div class='footer-widgets'>
    <div class='footer-widgets-inner row'> 
        <div class='col-5 d-flex flex-column justify-content-center'>
            <span class='py-4 footer-headings'>Categories</span>
            <ul class='list-group d-flex flex-row flex-wrap text-start'>
                <?php 
                $Category->get_all_category();
                ?>
            </ul>
        </div>
        <div class='col-5 d-flex flex-column justify-content-center'>
            <span class='py-4 footer-headings'>Web series Categories</span>
            <ul class='list-group d-flex flex-row flex-wrap text-start'>
                <?php 
                $Category->get_all_category();
                ?>
            </ul>
        </div>
        <div class='col-2 d-flex flex-column justify-content-start support-tab-footer'>
            <span class='footer-headings'>Support</span>
            <ul class='list-group d-flex flex-row flex-wrap text-start'>
                <li  class='list-item w-100 py-2'>My account</li>
                <li  class='list-item w-100 py-2'>FAQ</li>
                <li  class='list-item w-100 py-2'>Watch on Tv</li>
                <li  class='list-item w-100 py-2'>Help center</li>
                <li  class='list-item w-100 py-2'>Contact</li>
            </ul>
        </div>
    </div>
</div>
</div> 
<div class='footer-bottom-bar dark'>
    <div class='container-fluid'>
        <div class='d-flex justify-content-between align-items-center px-2'> 
            <div class='site-info'>Copyright © 2019, Vodi. All Rights Reserved </div>
            <div class='site-info px-5'>Privacy Policy </div>
        </div>
    </div>
</div>

</footer>

</div>
<script src="assets/js/script.js"></script>
</body>
</html>