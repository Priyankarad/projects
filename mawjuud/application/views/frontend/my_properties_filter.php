<?php if($type == 'photo'){ ?>
<table class="responsive-table propertyTable">
    <thead><tr><th></th></tr></thead>
    <tbody>
        <?php if(!empty($propertyData['result'])){ 
            foreach($propertyData['result'] as $property1){
                $property = (array)$property1;
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
                                                                    <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> <?php echo $property['bathselect'];?> 
                                                                <?php } 

                                                                if(isset($property['bedselect'])){ ?>
                                                                    |
                                                                    <img src="<?php echo base_url();?>assets/images/bed.png" alt="images"> <?php echo ($property['bedselect']==100)?"Studio":$property['bedselect'];?>
                                                                <?php } ?>
                                                                |<img src="<?php echo base_url();?>assets/images/size.png" alt="images"> <?php echo number_format($property['square_feet'])." Sq. ft.";?>
                                                            </p>
                                                            </div>
                                                            <h4><?php echo isset($property['name'])?$property['name']:'';?></h4>
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
                                                        if(($property['rent_sale'] == 1) && ($property['property_type'] == 'sale')){
                                                            echo '<div class="mw-solds">sold</div>';
                                                        }
                                                        else if(($property['rent_sale'] == 1) && ($property['property_type'] == 'rent')){
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
                                                    <h4>
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
                                                    <img src="<?php echo base_url();?>assets/images/photoviewaminities/price.png" alt="">    
                                                </li>
                                                <li>
                                                    <span><?php echo isset($property['square_feet'])?number_format($property['square_feet']):'';?></span>
                                                    <img src="<?php echo base_url();?>assets/images/photoviewaminities/squareft.png" alt="">
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
                                                        <img src="<?php echo base_url();?>assets/images/bed1.png" alt="">
                                                        <i>Bedrooms</i>   
                                                    <?php } ?>
                                                </li>
                                                <li>
                                                    <?php 
                                                    if($property['listing'] == 1 || $property['listing'] == 4 || $property['listing'] == 6 || $property['listing'] == 10 || $property['listing'] == 12 || $property['listing'] == 8){ ?>
                                                        <span><?php echo isset($property['bathselect'])?$property['bathselect']:'';?></span> 
                                                        <img src="<?php echo base_url();?>assets/images/bath1.png" alt="">
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
                                        <button class="m-grays">Edit <i class="ti-pencil"></i></button>
                                        <div class="act_deact<?php echo $property['id'];?>">
                                            <?php 
                                            if($property['save_as_draft'] == 0){ ?>
                                                <button class="m-red activate" data-activate = "0" data-property_id="<?php echo $property['id'];?>">Deactivate <i class="ti-power-off"></i></button>
                                            <?php }else{ ?>
                                                <button class="m-green activate" data-activate = "1" data-property_id="<?php echo $property['id'];?>">Activate <i class="ti-power-off"></i></button>
                                            <?php } ?>
                                        </div>
                                         <button class="m-red modal-trigger deleteModal"  data-property_id="<?php echo $property['id'];?>">Delete <i class="ti-trash"></i></button>
                                            <div class="modal" id="modalDelete<?php echo $property['id'];?>">
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
                                                <h6><img src="<?php echo base_url();?>assets/images/view.png" alt=""/> <b><?php echo isset($property['page_view'])?$property['page_view']:'';?></b></h6>
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
                                             <!--    <p>
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
                                           <!--  <button class="m-dred">Payment Required For Featured</button> -->
                                    </p>
                                    <div class="p-rightsmws">
                                        <a class="modal-trigger share" data-property_id="<?php echo $property['id'];?>"><span class="ti-share"></span></a>
                                        <!--===============sharelisting================-->
                                        <!--===============sharelisting================-->
                                        <div id="sharelisting<?php echo $property['id'];?>" class="modal custompopupdesign sharelisting">
                                            <a href="#!" class="modal-close waves-effect modal_closeA">×</a>    
                                            <form  class="shareForm" method="post">   
                                                <h4 class="modal-title">Share</h4>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <textarea class="materialize-textarea" placeholder="Enter Your Note"  name="note" style="height: 45px;"></textarea>
                                                        <input type="email" name="email[]" class="form-control" placeholder="Email Address">
                                                        <input type="email" name="email[]" class="form-control hiddenAdemail" placeholder="Additional Email Address">
                                                        <div class="addnewEm">Add additional email adddress <span class="ti-plus"></span></div>
                                                        <div class="btn-group-p">
                                                            <button type="submit" class="sharesubbtn waves-effect waves-light">Submit</button>
                                                            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
                                                        </div>
                                                        <?php $photos = isset($property['thumbnail_photo_media'])?$property['thumbnail_photo_media']:'';
                                                        $photoArray = explode("|",$photos);
                                                        ?>
                                                        <div class="footer-share-sc">
                                                            <a href="javascript:void(0)"  onclick="submitAndShare('<?php if(!empty($photoArray[0]) && isset($photoArray[0])){ echo $photoArray[0];}?>','<?php echo $property['title'];?>','<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>')" target="_blank"><span class="ti-facebook"></span></a>
                                                            <a href="http://pinterest.com/pin/create/button/?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>&media=<?php if(!empty($photoArray[0]) && isset($photoArray[0])){ echo $photoArray[0];}?>&description=<?php echo $property['title'];?>" class="pin-it-button" count-layout="horizontal" target="_blank"><span class="ti-pinterest"></span></a>
                                                            <a href="https://twitter.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><span class="ti-twitter"></span></a>
                                                            <a href="https://plus.google.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><span class="ti-google"></span></a>
                                                            <a href="whatsapp://send?text=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" data-action="share/whatsapp/share"><span>w</span></a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!--===============sharelisting================-->
                                        <!--===============sharelisting================-->
                                        <a href="#"><img src="<?php echo base_url();?>assets/images/hide.png" alt=""/></a>
                                        <span class="<?php echo $class;?>">For <?php echo isset($property['property_type'])?ucfirst($property['property_type']):'';?></span>
                                    </div>
                                </div>   
                            </div>
                        </div>
                        
                    </td>
                </tr>
            <?php } 
        }?>
    </tbody>
</table>
<?php }else{ ?>
    <div class="row">
        <div class="col s12">
            <table id="property_table">
                <thead>
                    <tr>
                        <!-- <th>
                            <label>
                                <input type="checkbox" />
                                <span class="spaceblnkM"></span>
                            </label>
                        </th> -->
                        <th><b>R / S</b></th>
                        <th><b>Type</b></th>
                        <th><b>Ref #</b></th>
                        <th><b>Title</b></th>
                        <th><b>Address</b></th>
                        <th><b>Price (AED)</b></th>
                        <th><b>Bed</b></th>
                        <th><b>Bath</b></th>
                        <th><b>Size (Sq.ft.)</b></th>
                        <th><b>Date Added</b></th>
                        <th><b>Date Published</b></th>
                        <th><b>Status</b></th>
                        <!-- <th><b>Featured</b></th> -->
                        <th><b>Activity</b></th>
                        <th><b>Mark</b></th>
                        <th><b>Edit</b></th>
                        <th><b>Share</b></th>
                        <th><b>Delete</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($propertyData['result'])){ 
            foreach($propertyData['result'] as $property1){
                $property = (array)$property1;
                $favourite = '';
                $class = 'sale-prs';
                $rentedSold = 'Sold';
                if($property['property_type'] == 'rent'){
                    $class = 'rent-prs';
                    $rentedSold = 'Rented';
                }
                if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                    $favourite = 'fillHearts';
                }
                ?>
                    <tr>
                        <!-- <td>
                            <label>
                                <input type="checkbox" />
                                <span class="spaceblnkM"></span>
                            </label>
                        </td> -->
                        <td>
                            <span class="<?php echo $class;?>"><?php echo (isset($property['property_type']) && ($property['property_type']=='sale')) ?'S':'R';?></span>
                        </td>
                        <td>
                            <span class="<?php echo $class;?>"><?php echo $property['name'];?></span>
                        </td>
                        <td>
                            <?php echo $property['mawjuud_reference'];?>
                        </td>
                        <td>
                            <a class="title_anchores2" href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><?php echo $property['title'];?></a>
                        </td>
                        <td><?php echo isset($property['property_address'])?ucfirst($property['property_address']):'';?></td>
                        <td><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</td>
                        <td><?php 
                            if(isset($property['bedselect'])){
                                if($property['bedselect'] == 100){
                                    echo  "Studio";
                                }else{
                                    echo $property['bedselect'];
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo isset($property['bathselect'])?$property['bathselect']:''; ?></td>
                        <td><?php echo isset($property['square_feet'])?number_format($property['square_feet']):''; ?></td>
                        <td><?php echo (!empty($property['created_date']) && $property['created_date']!='0000-00-00')?date("j M Y",strtotime($property['created_date'])):'-';?></td>
                        <td class="publisheds<?php echo $property['id'];?>"><?php echo (!empty($property['publish_date']) && $property['publish_date']!='0000-00-00')?date("j M Y",strtotime($property['publish_date'])):'-';?></td>
                        <td>
                            <span class="act-m">Active</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" class="activate" <?php echo (isset($property['save_as_draft']) && $property['save_as_draft'] == 0)?'checked':'';?> data-activate="<?php echo ($property['save_as_draft'] == 0)?0:1;?>" data-property_id="<?php echo $property['id'];?>">
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </td>
                      <!--   <td>
                            <label>
                                <input type="checkbox" />
                                <span class="spaceblnkM"></span>
                            </label>
                        </td> -->
                        <td>
                            <p><img src="<?php echo base_url();?>assets/images/view.png" alt=""> <b><?php echo isset($property['page_view'])?$property['page_view']:'';?></b></p>
                            <p><span class="ti-heart"></span> <b><?php echo countRecords(FAVOURITE_PROPERTY,array('property_id'=>$property['id'],'status'=>1));?></b></p>
                        </td>
                        <td>
                            <span class="<?php echo $class;?>"><?php echo $rentedSold;?></span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" class="rent_sale"  data-property_id="<?php echo $property['id'];?>"  <?php echo (isset($property['rent_sale']) && $property['rent_sale'] == 1)?'checked':'';?>>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </td>
                        <td>
                            <p class="edit-del-sh"> 

                                <a href=""><span class="ti-pencil"></span></a>
                                
                                
                            </p>
                        </td>
                        <td>
                          <p class="edit-del-sh">
                             
                                <!--===============sharelisting================-->
                                        <!--===============sharelisting================-->
                                        <div id="sharelisting<?php echo $property['id'];?>" class="modal custompopupdesign sharelisting">
                                            <a href="#!" class="modal-close waves-effect modal_closeA">×</a>    
                                            <form  class="shareForm" method="post">   
                                                <h4 class="modal-title">Share</h4>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <textarea class="materialize-textarea" placeholder="Enter Your Note"  name="note" style="height: 45px;"></textarea>
                                                        <input type="email" name="email[]" class="form-control" placeholder="Email Address">
                                                        <input type="email" name="email[]" class="form-control hiddenAdemail" placeholder="Additional Email Address">
                                                        <div class="addnewEm">Add additional email adddress <span class="ti-plus"></span></div>
                                                        <div class="btn-group-p">
                                                            <button type="submit" class="sharesubbtn waves-effect waves-light">Submit</button>
                                                            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
                                                        </div>
                                                        <?php $photos = isset($property['thumbnail_photo_media'])?$property['thumbnail_photo_media']:'';
                                                        $photoArray = explode("|",$photos);
                                                        ?>
                                                        <div class="footer-share-sc">
                                                            <a href="javascript:void(0)"  onclick="submitAndShare('<?php if(!empty($photoArray[0]) && isset($photoArray[0])){ echo $photoArray[0];}?>','<?php echo $property['title'];?>','<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>')" target="_blank"><span class="ti-facebook"></span></a>
                                                            <a href="http://pinterest.com/pin/create/button/?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>&media=<?php if(!empty($photoArray[0]) && isset($photoArray[0])){ echo $photoArray[0];}?>&description=<?php echo $property['title'];?>" class="pin-it-button" count-layout="horizontal" target="_blank"><span class="ti-pinterest"></span></a>
                                                            <a href="https://twitter.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><span class="ti-twitter"></span></a>
                                                            <a href="https://plus.google.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><span class="ti-google"></span></a>
                                                            <a href="whatsapp://send?text=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" data-action="share/whatsapp/share"><span>w</span></a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!--===============sharelisting================-->
                                        <!--===============sharelisting================-->
                           <a class="modal-trigger share" data-property_id="<?php echo $property['id'];?>"><span class="ti-share"></span></a> 
                          </p>
                        </td>
                        <td>
                           <p class="edit-del-sh">
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
                           <a href="javascript:void(0);" class="modal-trigger deleteModal"  data-property_id="<?php echo $property['id'];?>"><span class="ti-trash"></span></a>
                           </p>
                        </td>
                    </tr>
                <?php }
                } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
<script type="text/javascript">
    $(".propertyTable").dataTable().fnDestroy();
    var table;
    table = $('.propertyTable').DataTable({
        "lengthMenu": [[3, 5, 10, 25, 50, -1], [3, 5, 10, 25, 50, "All"]]
    });
    var table1;
    table1 = $('#property_table').DataTable();
    $("#property_table").dataTable().fnDestroy();
    $('#property_table').DataTable();

</script>