<div class="row">
<div class="col-md-12 col-sm-12 col-12">
<div class="rankPshadows boxCenterTall">
<div class="row">
<h1 class="you-sm">Your Ranking <span class="ranking"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
</h1>
<?php if(!empty($userRankRatings)){
foreach($userRankRatings as $row){
if($row['id'] == get_current_user_id()){?>
<div class="col-md-3 col-sm-3 col-6">
<a href="<?php echo base_url() ?>profile">
<div class="nam-tz">

<div class="us-tz rank_imgs">
<?php if($row['profile']!='assets/images/default_image.jpg'){?>
    <img src="<?php echo $row['profile'];?>" alt="Post Image" class="img-fluid rmvobj">
<?php } else{ ?>
    <img src="<?php echo base_url().$row['profile'];?>" alt="Post Image" class="img-fluid rmvobj">
<?php } ?>
</div>
<p class="pro_name8"><?php echo $row['firstname']." ".$row['lastname'];?></p>
<div class="combaine-sstx-z comrank">
<?php echo $row['star_rating'];?>
</div>
<p>Rank - <span><?php echo $row['rank'];?></span> </p>
</div>
</a>
</div>

<?php       }
}
} ?>
</div>

<div class="top-usr">
<div class="row">
<h1 class="you-sm text-center">Top 5 Rankings</h1>
<?php if(!empty($userRankRatings)){
$count = 1;
foreach($userRankRatings as $row){
if($row['id'] == get_current_user_id()){
$url = base_url().'profile';
}else{
$url = base_url().'viewdetails/profile/'.encoding($row['id']);
}
if($count <= 5){
?>
<div class="col-md-3 col-sm-3 col-6">
<a href="<?php echo $url;?>">
<div class="nam-tz">

<div class="us-tz rank_imgs">
    <?php if($row['profile']!='assets/images/default_image.jpg'){?>
        <img src="<?php echo $row['profile'];?>" alt="Post Image" class="img-fluid rmvobj">
    <?php } else{ ?>
        <img src="<?php echo base_url().$row['profile'];?>" alt="Post Image" class="img-fluid rmvobj">
    <?php } ?>
</div>
<p class="pro_name8"><?php echo $row['firstname']." ".$row['lastname'];?></p>
<div class="combaine-sstx-z comrank">
    <?php echo $row['star_rating'];?>
</div>
<p>Rank - <span><?php echo $row['rank'];?></span> </p>
</div>
</a>
</div>

<?php     }else{
break;
}
$count++;
}
} ?>
</div>
</div>
<!--         <div>

<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-3979824042791728"
data-ad-slot="2846184025"
data-ad-format="auto"
data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div> -->
</div>
</div>
</div>