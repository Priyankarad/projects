<?php include APPPATH.'views/includes/header.php'; ?>
<header>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active" style="background-image: url('./assets/images/school.jpg')">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="display-4">Add School Or Course</h2>
                    <p class="lead">
                        <a href="<?php echo site_url('create-school');?>" class="btn main-btn">School</a>
                        <a href="<?php echo site_url('create-course');?>" class="btn main-btn">Course</a>
                    </p>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('./assets/images/school1.jpg')">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="display-4">Add School Or Course</h2>
                    <p class="lead">
                        <a href="<?php echo site_url('create-school');?>" class="btn main-btn">School</a>
                        <a href="<?php echo site_url('create-course');?>" class="btn main-btn">Course</a>
                    </p>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('./assets/images/school2.jpg')">
                <div class="carousel-caption d-none d-md-block">
                    <h2 class="display-4">Add School Or Course</h2>
                    <p class="lead">
                        <a href="<?php echo site_url('create-school');?>" class="btn main-btn">School</a>
                        <a href="<?php echo site_url('create-course');?>" class="btn main-btn">Course</a>
                    </p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>
<?php include APPPATH.'views/includes/footer.php'; ?>

