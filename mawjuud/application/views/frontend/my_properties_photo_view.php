<?php
$favourite = '';
if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
  $favourite = 'fillHearts';
}
?>
<tr class="myacc_div" data-property_id="<?php echo $property['id'];?>">
  <td>
    <div class="row parentproptM">
      <div class="col s7">
        <div class="row">
          <div class="col s4">
            <div class="in_box">
              <div class="box_img1">
                <div class="compareX"><span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);"></span></span></div>
                <div class="Mhideproperty" data-property = "<?php echo $property['id'];?>">
                  <img src="<?php echo base_url();?>assets/images/map-icon/hide-icon.png" alt="images">
                </div>
                <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank" class="waves-effect waves-light">
                  <?php 
                  $img = base_url().DEFAULT_PROPERTY_IMAGE;
                  if(isset($property['thumbnail_photo_media'])){
                    $imgArray = explode('|',$property['thumbnail_photo_media']); 
                    $img = $imgArray[0];
                  }
                  ?>
                  <img src="<?php echo $img;?>" alt="images">
                  <span class="ForSale <?php echo ($property['property_type']=='sale')?'SGC1':'SGC';?>">For <?php echo isset($property['property_type'])?ucfirst($property['property_type']):'';?></span>
                  <div class="box_cnts">
                    <div class="bed_bath">
                      <p>
                        <?php if(isset($property['bathselect'])){ ?>
                          <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> <?php echo $property['bathselect']?> 
                        <?php } 

                        if(isset($property['bedselect'])){ ?>
                          |
                          <img src="<?php echo base_url();?>assets/images/bed.png" alt="images"> <?php echo ($property['bedselect']==100)?"Studio":$property['bedselect'];?>
                        <?php } ?>
                        |<img src="<?php echo base_url();?>assets/images/size.png" alt="images"> <?php echo number_format($property['square_feet'])." Sq. ft.";?></p>
                      </div>
                      <h4><?php echo isset($property['name'])?$property['name']:''; ?></h4>
                      <h6>
                        <span class="ti-location-pin"></span> <?php echo isset($property['property_address'])?ucfirst($property['property_address']):'';?>
                      </h6>
                      <h5>
                        <span class="PriceSp"><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</span>
                      </h5>
                    </div>
                  </a>
                  <?php 
                  $img = 0;
                  $images = isset($property['thumbnail_photo_media'])?explode("|",$property['thumbnail_photo_media']):0;
                  if($images){
                    $img = count($images);
                  }
                  ?>
                  <div class="band<?php echo $property['id'];?>">
                    <?php
                    if($property['rent_sale'] == 1 && $property['property_type'] == 'sale'){
                      echo '<div class="mw-solds">sold</div>';
                    }
                    else if($property['rent_sale'] == 1 && $property['property_type'] == 'rent'){
                      echo '<div class="mw-rented">rented</div>';
                    }
                    ?>
                  </div>
                  <div class="MtotalPicsList"><i><?php echo $img;?></i> <span class="ti-camera"></span></div>
                </div>
              </div>
            </div>
            <div class="col s8">
              <div class="photoViewsRightcnt">
                <div class="dashbrdptitle">
                  <h4 class="myactitletablates">
                    <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><?php echo isset($property['title'])?ucfirst($property['title']):'';?>
                  </a>
                </h4>
                <div class="refCodes"><b>Ref #:</b> <?php echo isset($property['mawjuud_reference'])?$property['mawjuud_reference']:'-';?></div>
                <div class="publisheds">
                  <p><b>Published</b>
                    <span class="publisheds<?php echo $property['id'];?>"><?php echo (!empty($property['publish_date']) && $property['publish_date']!='0000-00-00')?date("j M Y",strtotime($property['publish_date'])):'-';?></span>
                  </p>
                  <p><b>Date Added</b>
                    <span><?php echo (!empty($property['created_date']) && $property['created_date']!='0000-00-00')?date("j M Y",strtotime($property['created_date'])):'-';?></span>
                  </p>     
                </div>
              </div>

              <ul class="aminitiesMpview">
                <li>
                  <span><?php echo $property['name']?></span> 
                  <img src="<?php echo base_url();?>assets/images/<?php echo $property['image']?>" alt=""/>    
                </li>
                <li>
                  <span><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</span> 
                  <!-- <img src="<?php echo base_url();?>assets/images/photoviewaminities/price.png" alt="">    -->
                  <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36px" height="36px" x="0px" y="0px" viewBox="0 0 56.414 56.414" style="enable-background:new 0 0 56.414 56.414;" xml:space="preserve"> <path d="M56.414,11.089L45.299,0H31.295l-5.519,5.501C12.053,4.356,0.988,12.076,0.833,12.187c-0.449,0.32-0.554,0.945-0.232,1.395 C0.796,13.854,1.103,14,1.415,14c0.201,0,0.404-0.061,0.58-0.187c0.139-0.099,9.712-6.776,21.881-6.419L5.999,25.213l0.008,0.008 L0,31.213l25.146,25.201l10.04-10.013c2.062,1.08,4.461,1.611,6.834,1.61c3.501,0,6.935-1.138,9.101-3.304 c7.367-7.368,4.443-15.45,3.443-17.633l1.849-1.845V11.089z M44.473,2l9.941,9.919v12.48L34.876,43.873 c-4.084-2.928-5.327-8.422-3.493-15.626c0.137-0.535-0.187-1.08-0.722-1.216c-0.537-0.143-1.079,0.187-1.216,0.722 C26.856,37.92,30.335,42.934,33.444,45.3l-2.293,2.286L8.836,25.224L26.516,7.59c4.198,0.48,8.631,1.866,13.046,4.667 c-0.039,0.221-0.068,0.446-0.068,0.678c0,2.17,1.765,3.935,3.935,3.935s3.936-1.765,3.936-3.935S45.599,9,43.429,9 c-1.216,0-2.291,0.566-3.013,1.436c-4.089-2.557-8.187-3.982-12.118-4.622L32.121,2H44.473z M41.814,13.8 c0.442,0.332,1.069,0.243,1.399-0.2c0.332-0.441,0.242-1.068-0.2-1.399c-0.309-0.231-0.619-0.435-0.928-0.652 C42.434,11.21,42.907,11,43.429,11c1.067,0,1.936,0.868,1.936,1.936c0,1.066-0.868,1.935-1.936,1.935 c-0.803,0-1.492-0.492-1.785-1.19C41.701,13.722,41.758,13.757,41.814,13.8z M2.828,31.217l4.592-4.58l22.322,22.37l-4.592,4.58 L2.828,31.217z M49.707,43.293c-2.576,2.574-8.37,3.748-13.03,1.621l16.375-16.332C54.047,31.058,55.657,37.342,49.707,43.293z"></path> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg> 
                </li>
                <li>
                  <span><?php echo isset($property['square_feet'])?number_format($property['square_feet']):'';?></span>
                  <img src="<?php echo base_url();?>assets/images/photoviewaminities/squareft.svg" alt="">
                  <i>Sq. ft</i>    
                </li>
                <li>
                  <?php 
                  if($property['listing'] == 1 || $property['listing'] == 4 || $property['listing'] == 6 || $property['listing'] == 10 || $property['listing'] == 12){ ?>
                    <span>
                      <?php
                      $bed = '';
                      if(isset($property['bedselect'])){
                        if($property['bedselect']==100)
                          $bed = 'Studio';
                        else
                          $bed = $property['bedselect'];
                      }
                      echo $bed;
                      ?>
                    </span> 
                    <img src="<?php echo base_url();?>assets/images/bed1.svg" alt="">
                    <i>Bedrooms</i>   
                  <?php } ?>
                </li>
                <li>
                  <?php 
                  if($property['listing'] == 1 || $property['listing'] == 4 || $property['listing'] == 6 || $property['listing'] == 10 || $property['listing'] == 12 || $property['listing'] == 8){ ?>
                    <span><?php echo isset($property['bathselect'])?$property['bathselect']:'';?></span> 
                    <img src="<?php echo base_url();?>assets/images/bath1.svg" alt="">
                    <i>Bathrooms</i>   
                  <?php } ?> 
                </li>
              </ul>
            </div>
          </div>
        </div>  
      </div>
      <div class="col s5">
        <div class="allbtnsM">
          <p>
            <button class="m-blues refresh" data-property_id="<?php echo $property['id'];?>">Refresh <i class="ti-reload"></i></button>
            <a href="<?php echo base_url().'edit_property?id='.base64_encode($property['id']);?>"><button class="m-grays">Edit <i class="ti-pencil"></i></button></a>
            <div class="act_deact<?php echo $property['id'];?>">
              <?php 
              if($property['save_as_draft'] == 0){ ?>
                <button class="m-red activate" data-activate = "0" data-act="1" data-property_id="<?php echo $property['id'];?>">Deactivate <i class="ti-power-off"></i></button>
              <?php }else{ ?>
                <button class="m-green activate" data-activate = "1" data-act="1"  data-property_id="<?php echo $property['id'];?>">Activate <i class="ti-power-off"></i></button>
              <?php } ?>
            </div>
            <button class="m-red modal-trigger deleteModal" data-property_id="<?php echo $property['id'];?>">Delete <i class="ti-trash"></i></button>
            <div class="modal modalDelete<?php echo $property['id'];?>">
              <div class="modal-content">
                <h5>Delete Modal</h5>
                <p>Do you really want to delete this property?</p>
              </div>
              <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>

                <a href="#!" class="waves-effect waves-green delete_property btn-flat">Delete</a>
              </div>
            </div>
          </p>
          <?php
          $class = '';
          $mark = '';
          $rent_sale = '';
          if($property['property_type']=='sale'){
            $class = 'SGC1';
            $mark = '<em class="mw-sold">Sold</em>';
            $rent_sale = 'sold';
          }else{
            $class = 'SGC';
            $mark = '<em class="mw-rent">Rented</em>';
            $rent_sale = 'rented';
          }
          ?>
          <div class="views-compares">
            <div class="row">
              <div class="col s5">
                <h6><img src="<?php echo base_url();?>assets/images/view.svg" alt=""/> <b><?php echo isset($property['page_view'])?$property['page_view']:'';?></b></h6>
                <h6><span class="ti-heart"></span> <b><?php echo countRecords(FAVOURITE_PROPERTY,array('property_id'=>$property['id'],'status'=>1));?></b></h6>
              </div>
              <div class="col s7">
                <p>
                  <label>
                    <input type="checkbox" class="rent_sale" 
                    data-property_id="<?php echo $property['id'];?>" value="<?php echo $rent_sale; ?>" <?php 
                    echo (isset($property['rent_sale']) && $property['rent_sale'] == 1)?'checked':'';
                    ?>/>
                    <span>Mark as <?php echo $mark;?></span>
                  </label>
                </p>
<!--  <p>
<label>
<input type="checkbox" />
<span>Set Featured</span>
</label>
</p> -->
</div>
</div>
</div>
<p>
  <button class="pub_save publish<?php echo $property['id'];?> <?php echo ($property['save_as_draft'] == 0)?'m-ylow':'';?>" style="<?php echo ($property['save_as_draft'] == 1)?'background-color:#00b050':'';?>"><?php echo ($property['save_as_draft'] == 0)?'Published':'Saved In Draft';?></button>
  <!-- <button class="m-dred">Payment Required For Featured</button> -->
</p>
<div class="p-rightsmws">
  <a class="modal-trigger share" href="#sharelisting<?php echo $property['id'];?>" data-property_id="<?php echo $property['id'];?>"><span class="ti-share"></span></a>
  <a href="#" class="hideSvg"><img src="<?php echo base_url();?>assets/images/hide.svg" alt=""/></a>
  <span class="<?php echo $class;?>">For <?php echo isset($property['property_type'])?ucfirst($property['property_type']):'';?></span>
</div>
</div>   
</div>
</div>
<!--===============sharelisting================-->
<!--===============sharelisting================-->
<div id="sharelisting<?php echo $property['id'];?>" class="modal custompopupdesign sharelisting">
  <a href="#!" class="modal-close waves-effect modal_closeA">×</a>    
  <form  class="shareForm" method="post">   
    <h4 class="modal-title">Share</h4>
    <div class="row">
      <div class="col s12">
        <textarea class="materialize-textarea" placeholder="Enter Your Note"  name="note" style="height: 45px;" required=""></textarea>
        <input type="email" name="email[]" class="form-control" placeholder="Email Address" required="">
        <input type="hidden" name="property_ids" value="<?php echo $property['id'];?>">
        <input type="email" name="email[]" class="form-control hiddenAdemail" placeholder="Additional Email Address">
        <div class="addnewEm">Add additional email adddress <span class="ti-plus"></span></div>
        <div class="btn-group-p">
          <button type="submit" class="sharesubbtn waves-effect waves-light">Submit</button>
          <a href="#!" class="cancelbshare modal-close waves-effect waves-green btn-flat">Cancel</a>
        </div>
        <?php $photos = isset($property['thumbnail_photo_media'])?$property['thumbnail_photo_media']:'';
        $photoArray = explode("|",$photos);
        ?>
        <div class="footer-share-sc">
          <a href="javascript:void(0)"  onclick="submitAndShare('<?php if(!empty($photoArray[0]) && isset($photoArray[0])){ echo $photoArray[0];}?>','<?php echo $property['title'];?>','<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>')" target="_blank"><span class="ti-facebook"></span></a>
          <a href="http://pinterest.com/pin/create/button/?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>&media=<?php if(!empty($photoArray[0]) && isset($photoArray[0])){ echo $photoArray[0];}?>&description=<?php echo $property['title'];?>" class="pin-it-button" count-layout="horizontal" target="_blank"><span class="ti-pinterest"></span></a>
          <a href="https://twitter.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><span class="ti-twitter"></span></a>
          <a href="https://plus.google.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><span class="ti-google"></span></a>
          <a href="whatsapp://send?text=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" data-action="share/whatsapp/share"><span><img src="<?php echo base_url();?>assets/images/whatsappicon.png"></span></a>

        </div>
      </div>
    </div>
  </form>
</div>
<!--===============sharelisting================-->
<!--===============sharelisting================-->

</td>
</tr>
