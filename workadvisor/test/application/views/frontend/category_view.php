<input type="hidden" name="base_url" value="<?php echo base_url()?>" id="base_url">
<section class="Dona_serch" style="margin-top:15px">
         <div class="container">
          <div class="row">
<!--col-3 strat-->
      <div class="col-md-2 col-12">
    <form  method="post" id="searchfilter1" action="<?php echo base_url()?>search/searchFilter">
     <div class="stars_searchRes_top">
        <h1>Stars</h1>
        <input type="hidden" id="searchTags" value="<?php echo isset($tags) ? $tags : ''; ?>" name="searchTags">
        <input type="hidden" id="locality" value="<?php echo isset($locality) ? $locality : ''; ?>" name="locality">

        <div class="stars_searchRes">
          <p>
            <input type="checkbox" name="stars[]" value="5" onclick="searchFilter()" /> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
          </p>
          <p>
            <input type="checkbox" name="stars[]" value="4" onclick="searchFilter()"/> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
          </p>
          <p>
            <input type="checkbox" name="stars[]" value="3" onclick="searchFilter()"/> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
          </p>
          <p>
            <input type="checkbox" name="stars[]" value="2" onclick="searchFilter()"/> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
          </p>
          <p>
            <input type="checkbox" name="stars[]" value="1" onclick="searchFilter()"/> <i class="fa fa-star"></i>
          </p>
        </div>
    	</div> 

      <div class="stars_searchRes_top">
        <h1>Reviews</h1>
        <div class="stars_searchRes">
          <p>
            <input type="radio" name="mostleast" class="radio-btn" value="1" onclick="searchFilter()"/> Most To Least
          </p>
          <p>
            <input type="radio" name="mostleast" class="radio-btn" value="2" onclick="searchFilter()"/> Least To Most
          </p>
        </div>
      </div> 

      <div class="stars_searchRes_top">
        <h1>Profile Type</h1>
        <div class="stars_searchRes">
          <p>
            <input type="radio" name="profile" class="radio-btn" value="1" onclick="searchFilter()"/> Employer
          </p>
          <p>
            <input type="radio" name="profile" class="radio-btn" value="2" onclick="searchFilter()"/> Performer
          </p>
        </div>
      </div> 

      <?php if(!empty($categoryData['result'])){?>
      <div class="stars_searchRes_top">
        <h1>Category</h1>
        <div class="stars_searchRes">
          <?php foreach($categoryData['result'] as $row){ ?>
            <p>
              <input type="checkbox" value="<?php echo $row->id;?>" name="category[]" onclick="searchFilter()"/>&nbsp;&nbsp;<?php echo $row->name;?>
            </p>
          <?php } ?>
        </div>
      </div> 
      <?php } ?>
  </form>
  
<!--col-3 close-->
 </div>
<!--col-3 close-->
      <div class="col-md-7 col-12">
      <div class="Donald">
     <?php
     if(!empty($performer_data['result'])){ foreach($performer_data['result'] as $row){
        $userProfileUrl = base_url('viewdetails/profile/'.encoding($row->id));
     $title=$row->firstname.' '.$row->lastname;
     if($row->user_role=='Employer' && $row->user_role!=""){
       $title=$row->business_name;
     }
     ?>
     
        <div class="Donald_Boyd row">
          <div class="col-md-3">
          <a href="<?php echo $userProfileUrl; ?>">
            <div class="main_kv">
              <img src="<?php echo (!empty($row->profile)) ? $row->profile : base_url().DEFAULT_IMAGE; ?>">
            </div>
          </a>
          </div>

          <div class="col-md-7">
            <div class="Donald_contnt">
              <div class="img_id">
             <a href="<?php echo $userProfileUrl; ?>">
       <h1><?php echo $title; ?></h1>
       </a>
                <p><?php echo $row->city.', '.$row->state.', '.$row->country.' '.$row->zip; ?></p>
               </div>
                <div class="strt">
                   <?php echo isset($row->starRating)?$row->starRating:'';?>
                </div>
            </div>
        </div>
      <div class="col-md-2">
        <div class="main_3btn donald">
    <?php
    if($row->user_role=='Employer'){ ?>
             <div class="Chery3">
              <i class="fa fa-plus"></i>
               <a href="#"> 
             Job request
               </a>
            </div>
    <?php }else{
      if(get_current_user_id()){
            $userOne=get_current_user_id();
      $userTwo=$row->id;
            $isFriend=checkFriend($userOne,$userTwo);
      }else{
      $isFriend="No"; 
      }
      
    ?>  
    
               <?php if($isFriend=='No'){ ?>
         <div class="Chery3">
                   <i class="fa fa-plus"></i>
                    <a onclick="addfriend('<?php echo encoding($row->id); ?>',this)" href="javascript:void(0)">Add friend</a>
        </div>
                <?php }else if($isFriend=='NotConfirm'){ ?>
        <div class="Chery3">
                   <i class="fa fa-plus"></i>
                    <a href="javascript:void(0)" onclick="friendRequest('<?php echo encoding($row->id); ?>','Accept','<?php echo 'FR'.$row->id; ?>')"> Confirm</a>
         </div>
                <?php }else if($isFriend=='Pending'){ ?>
        <div class="Chery3">
                   <i class="fa fa-clock-o"></i>
                <a href="javascript:void(0)"> Pending</a>
        </div>
               <?php }else if($isFriend=='Accepted'){
        
        }else{ echo ''; } ?>
    <?php } ?>
           <div class="Chery3 send_btn donal">
             <a href="<?php echo $userProfileUrl; ?>"> 
             Send Message
             </a>
           </div>
         </div>
       </div>
       </div>
    <?php } }else{ ?>
    <div class="alert alert-danger">
        <strong>Oops!</strong> No Result Found.
        </div>
    <?php } ?>
<!--second stat-->
 </div>
<!--
<div class="row mar_tp">
 <div class="col-md-4 col-12">
  <ul class="pagination">
    <li class="page-item"><a class="page-link b_chn" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">4</a></li>
    <li class="page-item"><a class="page-link" href="#">5</a></li>
    <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a></li>
   </ul> 
 </div> 
</div>
-->
          </div>
		        <div class="col-md-3 col-12">
				  <!-- workadv -->
            <!-- <ins class="adsbygoogle"
            style="display:inline-block;width:160px;height:600px"
            data-ad-client="ca-pub-3979824042791728"
            data-ad-slot="1270897105"></ins>
            <script>
              (adsbygoogle = window.adsbygoogle || []).push({});
            </script>  -->
                 </div>
         </div>

       </section>

      