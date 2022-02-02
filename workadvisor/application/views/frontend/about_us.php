<?php 
if(!empty($aboutData['result'][0])){
    $aboutData = $aboutData['result'][0];
}
?>
<div class="work_abouts">
    <div class="container">
        <div class="row">
        <div class="col-md-6">
                <div class="about_images">
                    <img src="<?php echo isset($aboutData->image)?$aboutData->image:'';?>" class="mw-100" alt="images"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="about_cnts">
                    <img src="<?php echo base_url() ?>/assets/images/arrow_shape.png" class="mw-100" alt="images"/>
                    <h1><?php echo isset($aboutData->heading_1)?$aboutData->heading_1:'';?></h1>
                    <title>Company Review | Employee Review| Employment agency - WorkAvisor</title>
                    
                        <p><?php echo isset($aboutData->content_1)?$aboutData->content_1:'';?>
                        <link rel="canonical" href="https://www.workadvisor.co/settings/about_us.html">

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="work_abouts5">
    <div class="container">
        <h1 class="cont"><?php echo isset($aboutData->heading_2)?$aboutData->heading_2:'';?></h1>
        <div class="row bg_shortF">
            <div class="col-md-4">
                <div class="abt_innerD">
                    <img src="<?php echo base_url() ?>/assets/images/pixel1.png" class="mw-100" alt="images"/>
                    <?php echo isset($aboutData->content_2)?$aboutData->content_2:'';?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="abt_innerD">
                    <img src="<?php echo base_url() ?>/assets/images/pixel3.png" class="mw-100" alt="images"/>
                    <?php echo isset($aboutData->content_3)?$aboutData->content_3:'';?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="abt_innerD">
                    <img src="<?php echo base_url() ?>/assets/images/pixel2.png" class="mw-100" alt="images"/>
                    <?php echo isset($aboutData->content_4)?$aboutData->content_4:'';?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="Work_employessF">
    <div class="container">
        <h1 class="cont"><?php echo isset($aboutData->heading_3)?$aboutData->heading_3:'';?></h1>
        <div class="row">
            <div class="col-md-6">
                <div class="Work_employessF_L">  
                    <?php echo isset($aboutData->content_5)?$aboutData->content_5:'';?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="Work_employessF_L">  
                    <?php echo isset($aboutData->content_6)?$aboutData->content_6:'';?>
                </div>
            </div>
        </div>
    </div>
</div>