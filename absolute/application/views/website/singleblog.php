<!--========header=============-->
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1><?php echo $article->title; ?></h1>
    </div>

</section>



<!--=============== Contact Section Start============ -->
<section class="main_contact pd_all">
	<div class="container contain_new">
		<div class="main_form">
			
			
		<div class="col-md-12 col-sm-12 col-12">
        <div class="main-blog">
          <div class="main-blog-img">
            <a href="#"><img src="<?php echo base_url().'uploads/article/'. $article->image; ?>" alt="image" class="img-fluid w-100"></a>
          </div>
          <div class="blog-black">
            <h4><?php echo date('d',strtotime($article->postdate)); ?> <span class="sty_ch"><?php echo date('M,Y',strtotime($article->postdate)); ?> </span></h4>
          </div>
          <div class="main-blog-content">
            <div class="blog-heading">
              <h2><?php echo $article->title; ?></h2>

              <div class="calander">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                <?php echo date('d,M,Y',strtotime($article->postdate)); ?>
              </div>

              <div><?php echo $article->description; ?></div>
			  <!----------
              <a href="#" class="rdmores"><i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
              <a href="#" class="rdmores"><i class="fa fa-google" aria-hidden="true"></i>
              </a>
              <a href="#" class="rdmores"><i class="fa fa-linkedin" aria-hidden="true"></i>
			  ------------>
              </a>
            </div>
          </div>
        </div>
      </div>
			
			
		</div>
	</div>
</section>
<!--=============== Contact Section Start============ -->