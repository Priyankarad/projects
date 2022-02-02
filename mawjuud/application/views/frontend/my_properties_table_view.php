<?php
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
