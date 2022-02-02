<?php if(!empty($postbycompany)){ $md=0;  foreach($postbycompany as$newkey=>$newvalue){ $md++;
$picarr=array();
$vidarray = array();
$latest_image1=base_url()."assets/images/p1.png";
$latest_image2=base_url()."assets/images/ph.png";
$latest_image3=base_url()."assets/images/v.png";
?>
<div class="col-tz">    
<div id="myModal001<?php echo $md; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>

</div>
<h4 class="modal-title"><?php echo $newkey; ?></h4>
<div class="modal-body">
<div class="row">
<?php foreach($newvalue['result'] as $pst){
    if($pst->post_image!=""){
        $multiple=explode(',',$pst->post_image);
        foreach($multiple as $img){

          $picarr[]= $img;
          $latest_image1=$img;
          $latest_image2=$img;
          $latest_image3=$img;

          ?>

          <div class="col-md-3">
            <div class="fansy-gallry">  
              <a data-fancybox="gallery1<?php echo $md; ?>" href="<?php echo $img; ?>">
                <img src="<?php echo $img; ?>">
            </a>
        </div>
    </div>
<?php } } } ?>
</div>
</div>

</div>
</div>
</div>
</div>

<div class="col-tz">    
<div id="myModal00v<?php echo $md; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>

</div>
<h4 class="modal-title"><?php echo $newkey; ?></h4>
<div class="modal-body">
<div class="row">
<?php foreach($newvalue['result'] as $pst){
    if($pst->post_video!=""){
        $multiple=explode(',',$pst->post_video);
        foreach($multiple as $video){
            $vidarray[]= "uploads/videos/".$video;
            $latest_video1="uploads/videos/".$video;
            $latest_video2="uploads/videos/".$video;
            $latest_video3="uploads/videos/".$video;
            ?>
            <div class="col-md-3">
                <div class="fansy-gallry">  
                    <a class="fancybox" data-fancybox="gallery2<?php echo $md; ?>" href="<?php echo base_url().'uploads/videos/'.$video; ?>">
                        s
                        <video width="320" height="240"  controls class="videos">
                            <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
                                <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/webm">
                                  <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/ogg">
                                    <source src="<?php echo base_url().'uploads/videos/'.$video; ?>#t=1" type="video/mts">
                                    </video>

                                </a>
                            </div>
                        </div>
                    <?php } } } ?>
                </div>
            </div>

        </div>
    </div>
</div>
</div>


<div class="col-md-4 col-12">
<a href="#">
    <div class="jerry">
        <h1><?php echo $newkey; ?></h1>

        <div class="cat_img photss">

            <div class="atin_photos">
                <?php if(!empty($picarr) && count($picarr)>0){?>
                    <img src="<?php echo $latest_image1; ?>">
                    <a href="" class="bod_btm"><?php echo count($picarr)?> Photos</a><br>
                <?php } ?>
                <?php if(!empty($vidarray) && count($vidarray)>0){?>
                    s
                    <video width="320" height="240"  controls class="videos">
                        <source src="<?php echo base_url().$latest_video1; ?>#t=1" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
                            <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/webm">
                                <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/ogg">
                                    <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/mts">
                                    </video>
                                    <a href="" class="bod_btm"><?php echo count($vidarray)?> Videos</a>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="jhiga">
                            <span><?php echo $newkey; ?></span>
                            <?php if(!empty($picarr) && count($picarr)>0){?>
                                <div class="pho_cnt">
                                    <div class="photos1">
                                        <img src="<?php echo $latest_image2; ?>">
                                    </div>
                                    <a href="" data-toggle="modal" data-target="#myModal001<?php echo $md; ?>" class="bod_btm"><?php echo count($picarr)?> Photos</a>
                                </div>
                            <?php } ?>
                            <?php if(!empty($vidarray) && count($vidarray)>0){?>
                                <div class="pho_cnt">
                                    <div class="photos1 mar_lft">

                                        s
                                        <video width="320" height="240"  controls class="videos">
                                            <source src="<?php echo base_url().$latest_video1; ?>#t=1" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
                                                <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/webm">
                                                    <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/ogg">
                                                        <source src="<?php echo base_url().$latest_video1; ?>#t=1" type="video/mts">
                                                        </video>

                                                    </div>
                                                    <a href="" data-toggle="modal" data-target="#myModal00v<?php echo $md; ?>" class="bod_btm"><?php echo count($vidarray)?> Videos</a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </a>
                            </div> 
                        <?php } } ?>