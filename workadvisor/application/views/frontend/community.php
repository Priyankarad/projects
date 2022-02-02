<?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success'); } ?>
<div class="row">
<div class="col-md-8 full_fillBx">
<div class="main_with over">
<div class="userposts1" >
<div id="responseDiv1"></div>
<?php if(!empty($highlights['result'])){ $md = 0; foreach($highlights['result'] as $post){ $md++; 
$imgsert = '';?> 
<input type="hidden" name="table_name" id="table_name" value="<?php echo POSTS;?>">
<div class="main_blog post-id1" id="<?php echo $post->id; ?>" data-uid="<?php echo get_current_user_id(); ?>">
<div class="user_highlights">
<h5>
<a href="<?php echo base_url()?>viewdetails/profile/<?php echo encoding($post->user_id1);?>" target="_blank">
<?php echo 
($post->user_role == 'Performer')?ucwords($post->firstname." ".$post->lastname):ucfirst($post->business_name); ?> 
</a>
</h5>
<?php if($post->profile!='assets/images/default_image.jpg'){ ?>
<img src="<?php echo $post->profile;?>" alt="Post Image" class="">
<?php } else{ ?>
<img src="<?php echo base_url().$post->profile;?>" alt="Post Image" class="">
<?php } ?>
<?php $userRating = userOverallRatings($post->user_id1);
if(!empty($userRating['starRating'])){

echo preg_replace("/\([^)]+\)/","",$userRating['starRating']);
}
?>
</div>

<?php if($post->post_image!=""){
$imgsert=$post->post_image;
$postimgarr=explode(',',$imgsert);
if(count($postimgarr)>1){ ?>
<div class = "row pdbothS">
<?php foreach($postimgarr as $postim){ ?>
<div class = "col-sm-3 col-md-3 thumb_upx2">
    <div class="fansy-gallry">  
        <a class="thumbnail" data-fancybox="gallery1<?php echo $md; ?>" href="<?php echo $postim; ?>">
            <img src="<?php echo $postim; ?>">
        </a>
    </div>
</div>
<?php } ?>
</div>

<div class="col-tz">    
<div id="myModal00<?php echo $md; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
            <div class="row">
                <?php foreach($postimgarr as $postim){
                    ?>
                    <div class="col-md-3">
                        <div class="fansy-gallry">  
                            <a class="fancybox" data-fancybox="gallery1<?php echo $md; ?>" href="<?php echo $postim; ?>">
                                <img src="<?php echo $postim; ?>">
                            </a>
                        </div>
                    </div>
                <?php  }  ?>
            </div>
        </div>

    </div>
</div>
</div>
</div>
<?php }else{ ?>
<div class = "over_viewimg">
<a class="img-fluid" data-fancybox="gallery111<?php echo $md; ?>" href="<?php echo $imgsert; ?>">
<img src="<?php echo $imgsert; ?>">
</a>
</div>
<div class="col-tz">    
<div id="myModal002<?php echo $md; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
            <div class="row">
                <?php foreach($postimgarr as $postim){
                    ?>
                    <div class="col-md-3">
                        <div class="fansy-gallry">  
                            <a class="fancybox" data-fancybox="gallery111<?php echo $md; ?>" href="<?php echo $postim; ?>">
                                <img src="<?php echo $postim; ?>">
                            </a>
                        </div>
                    </div>
                <?php  }  ?>
            </div>
        </div>

    </div>
</div>
</div>
</div>
<?php  } } ?>
<?php if($post->post_video!=''){ ?>
<div class="row">
<div>
<video width="320" height="240"  controls class="videos">
    <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2, vp8, vorbis"'>
        <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/webm">
            <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/ogg">
                <source src="<?php echo base_url();?>uploads/videos/<?php echo $post->post_video; ?>#t=1" type="video/mts">
                </video>
            </div>
        </div>
    <?php } ?>
    <div class="contant_overviw esdu" onclick="setID(<?php echo $post->id;?>);">
        <h1 class="datess"><?php echo date('d-m-Y H:i A',strtotime($post->post_date)); ?></h1>
        <div class="btnns">
            <a href="#" class="linke" data-toggle="modal" data-target="#sharePostModal1<?php echo $md; ?>"><img src="<?php echo base_url();?>assets/images/share.png">
                <i class="fa fa-thumbs-up"></i>
            </a>
           

            <div class="modal fade" id="sharePostModal1<?php echo $md; ?>">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Boost Visibility</h4>
<button type="button" class="close" data-dismiss="modal">&times;</button>
<?php  $currentURL = current_url(); 
$params = $_SERVER['QUERY_STRING']; 
$fullURL = $currentURL . '?' . $params;
?>
</div>
<div class="modal-body">
<div id="share-buttons" title="Share Profile">
<a href="https://twitter.com/share?url=<?php echo $fullURL;?>" target="_blank">
<i class="fa fa-twitter"></i>
</a>
<?php if($imgsert == '') {
$imgsert = '';
} else {
$imgsert = $imgsert;
} 

if($post->post_video!=''){ 
$video = "'".base_url()."uploads/videos/".$post->post_video."'";
if($user_data->user_role == 'Employer'){
$name = ucwords($user_data->business_name);
}else{
$name = ucwords($user_data->firstname)." ".ucwords($user_data->lastname);
}
$urlP = base_url().'viewdetails/profile/'.encoding(get_current_user_id());
?>

<a href="javascript:void(0)" class="PIXLRIT1" onclick="publish(<?php echo $video ?>,'<?php echo $name. ' status'; ?>','<?php echo $urlP;?>');">
<i class="fa fa-facebook"></i>
</a>
<?php } 
else if($imgsert!=''){ 
$imgsert1 = explode(',',$imgsert);
$imgsert2 = $imgsert1[0];
if($post->user_role == 'Employer'){
$name = ucwords($post->business_name);
                                    }else{
$name = ucwords($post->firstname)." ".ucwords($post->lastname);
                                    }
$urlP = base_url().'viewdetails/profile/'.encoding($user_data->id);
                                    ?>
<a href="javascript:void(0)" class="PIXLRIT1" onclick="submitAndShare('<?php echo $imgsert2; ?>','<?php echo $name. ' status'; ?>','<?php echo $urlP;?>')" target="_blank">
<i class="fa fa-facebook"></i>
                                    </a>
                                <?php } ?>

<a href="https://plus.google.com/share?url=<?php echo $fullURL;?>" target="_blank">
<i class="fa fa-google-plus"></i>
</a>
<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $fullURL;?>" target="_blank">
<i class="fa fa-linkedin"></i>
</a>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
<div class="contant_overviw">
<p><?php

$regex = "((https?|ftp)\:\/\/)?";
$regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";  
$regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; 
$regex .= "(\:[0-9]{2,5})?";  
$regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; 
$regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";  
$regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; 

if(preg_match("/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i", $post->post_content)) 
{ 
$urls = '';
// if(strpos($post->post_content, 'http://') !== 0) {
//     $urls =  'http://' . $post->post_content;
// } else {
//     $urls = $post->post_content;
// }
echo '<a href="'.$post->post_content.'" target="_blank">'.$post->post_content.'</a>'; 
}else{
echo $post->post_content;
}
?>    
</p>
</div>

<div class="commentSection">
<div id="all_comments<?php echo $post->id;?>">
<?php $oldComments = getComments($post->id);
if(!empty($oldComments)){
foreach($oldComments as $comment){
$html = '';
$html.= '<div class="wa_app_comm">';
if(!empty($comment->profile)){
$html.='<img src="'.$comment->profile.'">';
}else{
$html.='<img src="'.DEFAULT_IMAGE.'">';
}
$html.='<h4>'.$comment->firstname.' '.$comment->lastname.'</h4>';
$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
$text = $comment->comments;
if(preg_match($reg_exUrl, $text, $url)) {
    $comments = preg_replace($reg_exUrl, "<a href='".$url[0]."' target='_blank'>{$url[0]}</a>", $text);
} else {
    $comments = $text;
}

$html.='<p>'.$comments.'</p>';
if(get_current_user_id() == $comment->user_id){
$html.='<i class="fa fa fa-trash-o" data-comment_id="'.$comment->id.'" data-toggle="modal" data-target="#modalDeleteComment"></i>';
}
$html.='</div>';
echo $html;
}
}
?>
</div>
<?php if(get_current_user_id()){ ?>
<form method="post" class="commentForm">
<textarea type="text" class="comment form-control" name="comment" placeholder="Enter your comment" data-comment="<?php echo $post->id;?>"></textarea>
<input type="submit" name="post" value="POST" class="post_comment">
</form>
<?php } ?>
</div>
</div>
<?php  } } ?>
</div>

<div id="lastresponse1"></div>


<button class="scrol_loding">
<img src="<?php echo base_url();?>assets/images/giphy.gif">
</button>
</div>
</div>

<div class="col-md-4 col-12 sidebar-expanded" id="sidebar-container">
<div class="sticky-top sticky-offset">
<?php if(isset($user_data->user_role) && $user_data->user_role == 'Performer') { 
$record_num = encoding(get_current_user_id());
?>
<div class="progrs">
<h1>Performance</h1>
<?php if(isset($percentarray[5])) {?>
<a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/5">
<?php }else{ ?>
    <a href="#">
    <?php }?>
    <div class="bar-one">
        <span class="quntit"><?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?></span>
        <div data-percent="<?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?>" style="width:<?php echo isset($percentarray[5])?number_format($percentarray[5],1).'%':'0%';?>"></div>
        <span class="star_rigth">5&nbsp;&nbsp;stars</span>
    </div>
</a>

<?php if(isset($percentarray[4])) {?>
    <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/4">
    <?php }else{ ?>
        <a href="#">
        <?php }?>
        <div class="bar-one">
            <span class="quntit"><?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?></span>
            <div style="width:<?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[4])?number_format($percentarray[4],1).'%':'0%';?>"></div>
            <span class="star_rigth">4&nbsp;&nbsp;stars</span>
        </div>
    </a>

    <?php if(isset($percentarray[3])) {?>
        <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/3">
        <?php }else{ ?>
            <a href="#">
            <?php }?>
            <div class="bar-one">
                <span class="quntit"><?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?></span>
                <div style="width:<?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[3])?number_format($percentarray[3],1).'%':'0%';?>"></div>
                <span class="star_rigth">3&nbsp;&nbsp;stars</span>
            </div>
        </a>

        <?php if(isset($percentarray[2])) {?>
            <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/2">
            <?php }else{ ?>
                <a href="#">
                <?php }?>
                <div class="bar-one">
                    <span class="quntit"><?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?></span>
                    <div style="width:<?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[2])?number_format($percentarray[2],1).'%':'0%';?>"></div>
                    <span class="star_rigth">2&nbsp;&nbsp;stars</span>
                </div>
            </a>

            <?php if(isset($percentarray[1])) {?>
                <a href="<?php echo base_url()?>user/viewhistory/<?php echo $record_num;?>/1">
                <?php }else{ ?>
                    <a href="#">
                    <?php }?>
                    <div class="bar-one">
                        <span class="quntit"><?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?></span>
                        <div style="width:<?php echo isset($percentarray[1])?number_format($percentarray[1],1).'%':'0%';?>" data-percent="<?php echo isset($percentarray[1])?number_format($percentarray[1],1):'0%';?>"></div>
                        <span class="star_rigth">1&nbsp;&nbsp;stars</span>
                    </div>
                </a>
            </div>
        <?php } ?>
        <!--Qr-code start-->
        <div class="Qr-code">
            <p> QR Code</p>
            <p>Scan My Code</p>
            <a href="#" id="qrCodeImg">                                    <img class="qr_code1" src="<?php echo isset($qr_image)?$qr_image:'';?>">
            </a>
            <input type="button" class="btn btn-info" id="btnPrint" value="Click To Print"><span class="qrCodeQuestion"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
        </div>
    </div>
</div>
<!--progresh bar close-->
</div>