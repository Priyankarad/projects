
<p class="edit-del-sh"> 

    <a  href="<?php echo base_url().'edit_property?id='.base64_encode($property['id']);?>"><span class="ti-pencil"></span></a>


</p>

<p class="edit-del-sh">

    <!--===============sharelisting================-->
    <!--===============sharelisting================-->
    <div id="sharelisting<?php echo $property['id'];?>" class="modal custompopupdesign sharelisting">
        <a href="#!" class="modal-close waves-effect modal_closeA">×</a>    
        <form  class="shareForm" method="post">   
            <h4 class="modal-title">Share</h4>
            <div class="row">
                <div class="col s12">
                   <textarea class="materialize-textarea" placeholder="Enter Your Note" id="note" name="note" style="height: 45px;"></textarea>
                            <input type="hidden" name="property_ids" value="<?php echo $property['id'];?>">
                            <input type="email" name="email[]" class="form-control" placeholder="Email Address">
                            <input type="email" name="email[]" class="form-control hiddenAdemail" placeholder="Additional Email Address">
                            <div class="addnewEm">Add additional email adddress <span class="ti-plus"></span></div>
                            <div class="btn-group-p">
                                <button type="submit" class="sharesubbtn waves-effect waves-light">Submit</button>
                                <button type="submit" class="cancelbshare">Cancel</button>
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
                    <?php 
                            $img = base_url().DEFAULT_PROPERTY_IMAGE;
                            if(isset($property['thumbnail_photo_media'])){
                                $imgArray = explode('|',$property['thumbnail_photo_media']); 
                                $img = $imgArray[0];
                            }
                            ?>
                            <input type="hidden" name="first_img" value="<?php echo $img;?>">
                </div>
            </div>
        </form>
    </div>
    <!--===============sharelisting================-->
    <!--===============sharelisting================-->
    <a class="modal-trigger share" data-property_id="<?php echo $property['id'];?>"><span class="ti-share"></span></a> 
</p>


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

