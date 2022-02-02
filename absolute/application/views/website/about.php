<!--========header=============-->
<style>
    .vs-hide-heading .MsoNormal
    {
        display:none;
    }
   .vs-hide-heading .quality-mmetion-cnts
   {
       padding-top:0px!important;
   }
</style>
<section class="banner-top" style="background-image: url('<?php echo BASEURL; ?>assets/web/images/banner.png')">

    <div class="link_section">
        <h1>About</h1>
    </div>

</section>



<!--=============== Contact Section Start============ -->


<section class="about_emc">
  <div class="container contain_new">

    <div class="row">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="heading">

                    <h2>About Absolute EMC</h2>

                </div>
            </div>
        </div>

    <div class="row pd_all">
      
      <div class="col-md-6 col-sm-6 col-12 aos-init aos-animate" data-aos="fade-right" data-aos-duration="1200">
        <div class="content_emc">
          <?php echo $aboutData[0]->value;?>
        </div>
      </div>

      <div class="col-md-6 col-sm-6 col-12 pz aos-init aos-animate" data-aos="fade-right" data-aos-duration="1200">
        <img src="<?php echo $aboutData[6]->value;?>" class="img-fluid" alt="image">
      </div>
    </div>

  </div>
</section>
<section class="quality-st">
  <div class="container">
      <div class="row">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="heading">

                    <h2>Quality Statement </h2>

                </div>
            </div>
        </div>
      <br><br>
    <div class="row vs-hide-heading">
      <div class="col-md-6">
        <div class="quality-mmetion-cnts aos-init aos-animate" data-aos="fade-right">
          <?php echo $aboutData[5]->value;?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="quality-mmetion aos-init aos-animate" data-aos="fade-left">
          <div class="img-cnslt">
          <img src="<?php echo $aboutData[11]->value;?>" alt="">
        </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=============== Contact Section Start============ -->




<section class="ouer_services about_service pd_all">
    <div class="container contain_new">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-12">
                <div class="heading">

                    <h2>Our Expertise</h2>

                </div>
            </div>
        </div>

        <div class="row services_section mar_top">
           
               

                    <div class="col-md-4 col-sm-12 col-12 set_service aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">

                        <div class="section_connect">

                            <div class="thumb_cir">

                                <img src="<?php echo $aboutData[8]->value;?>" alt="images" class="img-fluid">

                            </div>

                            <div class="box_content">

                                <?php echo $aboutData[2]->value;?>
                            </div>

                        </div>
                    </div>


                        <div class="col-md-4 col-sm-12 col-12 set_service aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">

                        <div class="section_connect">

                            <div class="thumb_cir">

                                <img src="<?php echo $aboutData[9]->value;?>" alt="images" class="img-fluid">

                            </div>

                            <div class="box_content">

                                <?php echo $aboutData[3]->value;?>
                            </div>

                        </div>

                    </div>


                    <div class="col-md-4 col-sm-12 col-12 set_service aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">

                        <div class="section_connect">

                            <div class="thumb_cir">

                                <img src="<?php echo $aboutData[10]->value;?>" alt="images" class="img-fluid">

                            </div>

                            <div class="box_content">

                              <?php echo $aboutData[4]->value;?>
                            </div>

                        </div>

                    </div>
          
        </div>
        </div>
    
</section>


<section class="about pd_all">
  
  <div class="container contain_new">
    <div class="row">
      <div class="col-md-4 col-sm-4 col-12 pz">
        <div class="img_about">
          <img src="<?php echo $aboutData[7]->value;?>" alt="images">
        </div>
      </div>

      <div class="col-md-8 col-sm-8 col-12 pz">
        <div class="about_detail">
          <?php echo $aboutData[1]->value;?>
        </div>
      </div>
    </div>
  </div>
</section>

