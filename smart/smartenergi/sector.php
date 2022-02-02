<?php require_once('header.php');

$identifier = isset($_REQUEST['identifier']) ? $_REQUEST['identifier'] : '';

if(!empty($identifier) && is_numeric($identifier)){

  $getdetailsQry = selectQueryWithJoin("SELECT * FROM ".TABLE_PREFIX."dropdown_values WHERE id = ".$identifier." and type='merchant_prod_type'",$con);
  $getdetailsRow = mysqli_fetch_assoc($getdetailsQry);
  if(!empty($getdetailsRow)){
      $getdetailsQry = selectQueryWithJoin("SELECT * FROM ".TABLE_PREFIX."backoffice_merchants WHERE sector =".$identifier,$con);
  }
}
?>

<section id="main" class="wrapper">
  <div class="container">
<div class="two-performance">
  <div class="container">
    <?php
    if(isset($getdetailsRow) && !empty($getdetailsRow)){
      echo "<h1>".$getdetailsRow['value']."</h1>";
    }
      if(isset($getdetailsQry) && !empty($getdetailsQry)){
          $i=0;
          while($checkMerchantsectorVal = mysqli_fetch_array($getdetailsQry)){

            if($i%2==0)
              echo '<div class="row uniform 100% ">';
            
   ?>
<div class="6u 12u$(6)">
        <div class="main_id">
       <div class="id_sectionimg">
        <?php 
          
         if(!empty($checkMerchantsectorVal['profile_image'])) {
            $urlStr="#"; 
            if($checkMerchantsectorVal['url']!=""){
                  $urlStr=$checkMerchantsectorVal['url'];
                  $parsed = parse_url($checkMerchantsectorVal['url']);
                  if (empty($parsed['scheme'])) {
                      $urlStr = 'http://' . ltrim($checkMerchantsectorVal['url'], '/');
                  }
            }
          ?>

          <a target="_blank" href="<?=$urlStr;?>">
                 <img src="<?=BASE_URL.'images/merchants_pictures/'.$checkMerchantsectorVal['profile_image']?>">
             </a> 
              <?php }else{ echo 'Profile Image not available.';} ?>
              </div>
      <div class="id_section">
         <h1><?=$checkMerchantsectorVal['merchant_name']?></h1>
            <p class="fl_lft"><?=$checkMerchantsectorVal['mobile_no']?></p>
            <p><?=$checkMerchantsectorVal['address']?></p>
        
 
       </div>
       </div>
      </div>

<?php
          
            $i++;
           if($i%2==0)
              echo '</div>';
            
          }
        }else{
          echo "Data not available.";
        }
      
    ?>
    <!----<div class="row uniform 50% "></div>-->
  </div>
  
</div>
</div></section>
<?php require_once('footer.php');?>