<div class="custom-navbar text-white d-flex flex-row">
    <div class="nav-left-side d-flex col-lg-8">
        <div class="left-side-nav-first d-flex align-items-center  px-1">
            <i class='fa fa-bars pr-3'></i>
            <div id="logo">vodi</div>
        </div><!---left-side-nav-first-->
            <ul class='nav left-side-nav-second col-lg-8 d-flex justify-content-around align-items-center'>
                <li class='nav-item'>Browse</li>
                <li class='nav-item'>Home</li>
                <li class='nav-item'>Blog</li>
                <li class='nav-item'>Movies</li>
                <li class='nav-item'>Tv</li>
            </ul><!--left-side-nav-second- -->
    </div><!---nav-left-side-->
    <div class="nav-right-side d-flex justify-content-end col-lg-4">
    <div class="right-side-nav-first d-flex justify-content-between align-items-center col-9">
    <div class="input-group">
        <input type="text" id="search" class='form-control p-4 search-input' placeholder='Search...'>
        <div class="input-group-append search-inside-input d-flex justify-content-end align-items-center">
        <i id='search-icon' class='fa fa-search text-secondary'></i>
        </div>
    </div>
        <button class="btn btn-none text-white d-flex align-items-center" id='admin-button'><i class='fa fa-cloud-upload mx-2'></i><span>Upload</span></button>
    </div><!---right-side-nav-first--->
    <div class="right-side-nav-second d-flex justify-content-between align-items-center">
        <i id='search-icon' class='fa fa-search d-none px-3'></i>
        <div class='d-flex align-items-center dropdown'>
            <div id='profile-img-small' class='d-flex justify-content-center align-items-center'><i id='search-icon' class='fa fa-user fa-2x'></i></div>
            <i class='fa fa-angle-down arrow-down'></i>
            
        </div>
    </div><!---right-side-nav-second--->
    </div><!--nav-right-side-->
</div>

        <ul class="sub-menu dropdown-menu text-center">
            <li class='list-item'><a href="#" class='text-dark'>Sign in</a></li>
            <li class='list-item'><a href="#" class='text-dark'>Register</a></li>
        </ul>

<script>
    $('.dropdown').on('click',function(){
        $('.sub-menu').toggle();
    });
    $('.sub-menu').on('mouseenter',function(){
        $('.sub-menu').show();
    });
    $('.sub-menu').on('mouseleave',function(){
        $('.sub-menu').hide();
    });
    $('.dropdown').on('mouseenter',function(){
        $('.sub-menu').show();
    });
    $('.dropdown').on('mouseleave',function(){
        $('.sub-menu').hide();
    });
</script>