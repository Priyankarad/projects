<div class="photoViews"> 
    <?php if(!empty($propertyData)){
        $sessionData = '';
        if($this->session->userdata('sessionData')){
            $sessionData = $this->session->userdata('sessionData');
        }
        foreach($propertyData as $property){
            $favourite = ''; 
            if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                $favourite = 'fillHearts';
            }
            $compare = '';
            if(!empty($compare_properties) && in_array($property['id'],$compare_properties)){
                $compare = 'style="color:#ff8787"';
            }
        ?>
            <div class="row box_div property_hover" data-prop_id="<?php echo $property['id'];?>">
                <div class="col s6">
                    <div class="in_box">
                        <div class="box_img1">
                            <div class="compareX"><span class="ti-heart ti-heart<?php echo $property['id'];?> <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);"></span></div>
                            <div class="Mhideproperty" data-property = "<?php echo $property['id'];?>">
                                <img src="<?php echo base_url();?>assets/images/map-icon/hide-icon.png" alt="images"/>
                            </div>
                            <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank" class="waves-effect waves-light" target="_blank">
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
                                            |<img src="<?php echo base_url();?>assets/images/size.png" alt="images"> <?php echo number_format($property['square_feet'])." Sq. ft.";?>
                                        </p>
                                    </div>
                                    <h4><?php echo isset($property['name'])?$property['name']:''; ?></h4>
                                    <h6><span class="ti-location-pin"></span> <?php echo isset($property['property_address'])?ucfirst($property['property_address']):'';?></h6>
                                    <h5><span class="PriceSp"><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> AED</span></h5>
                                </div>
                            </a>
                            <?php 
                            $img = 0;
                            $images = isset($property['thumbnail_photo_media'])?explode("|",$property['thumbnail_photo_media']):0;
                            if($images){
                                $img = count($images);
                            }
                            ?>
                            <div class="MtotalPicsList">
                                <i><?php echo $img;?></i> 
                                <span class="ti-camera"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s6">
                    <div class="photoViewsRightcnt">
                        <div class="PviewTitle">
                            <img src="<?php echo base_url();?>assets/images/<?php echo $property['image']?>" alt=""/>
                             <h4>
                                <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><?php echo isset($property['title'])?ucfirst($property['title']):'';?>
                                </a>
                            </h4>
                        </div>
                        <ul class="aminitiesMpview">
                            <li>
                                <span><?php echo isset($property['property_price'])?number_format($property['property_price']):'';?> <i>AED</i></span> 
                                <img src="<?php echo base_url();?>assets/images/photoviewaminities/price.png" alt=""/>    
                            </li>
                            <li>
                                <span><?php echo isset($property['square_feet'])?number_format($property['square_feet']):'';?></span>
                                <img src="<?php echo base_url();?>assets/images/photoviewaminities/squareft.png" alt=""/>
                                <i>Sq. ft</i>    
                            </li>

                            <li>
                            <?php if(isset($property['bedselect'])){ ?>
                                
                                    <span><?php echo ($property['bedselect']==100)?"Studio":$property['bedselect'];?></span> 
                                    <img src="<?php echo base_url();?>assets/images/bed1.png" alt=""/>
                                    <i>Bedrooms</i>   
                            <?php } ?>
                            </li>

                            <li>
                            <?php if(isset($property['bathselect'])){ ?>
                                <span><?php echo $property['bathselect'];?></span> 
                                <img src="<?php echo base_url();?>assets/images/bath1.png" alt=""/>
                                <i>Bathrooms</i>    
                            <?php } ?>
                            </li>

                            <li>
                                <?php 
                                $img = isset($property['profile_thumbnail'])?$property['profile_thumbnail']:base_url().DEFAULT_IMAGE;
                                ?>
                                <img src="<?php echo $img;?>" alt=""/>
                                <div class="refCodes"><b>Ref #:</b> <?php echo isset($property['mawjuud_reference'])?$property['mawjuud_reference']:'-';?></div>    
                            </li>
                        </ul>

                        <ul class="mouseaminitiesover">
                            <a class="tooltipped" data-position="bottom" data-tooltip="Add to favourite">
                                <span class="ti-heart ti-heart<?php echo $property['id'];?> <?php echo $favourite;?>"  onclick="favouriteProperty(<?php echo $property['id'];?>,this);"></span>
                            </a>
                            <a class="tooltipped" data-position="bottom" data-tooltip="Add to compare">
                                <span class="ti-plus" onclick="compareProperty(<?php echo $property['id'];?>,this);" <?php echo $compare;?>></span>
                            </a>
                            <a class="tooltipped callModal" data-position="bottom" data-tooltip="Call agent"  href="#callModal<?php echo $property['id'];?>" data-property_id="<?php echo $property['id'];?>">
                                <img src="<?php echo base_url();?>assets/images/photoviewaminities/collphone.png" alt=""/>
                            </a>

                            <div id="callModal<?php echo $property['id'];?>" class="modal custompopupdesign">
                            <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
                            <div class="my-signup"> 
                                <div>Reference Number - <?php echo isset($property['mawjuud_reference'])?$property['mawjuud_reference']:'';?></div>
                                <p>Phone number 1: <?php if(isset($property['phone']) && (strlen($property['phone'])>5)){
                                    echo $property['phone'];
                                }else{
                                    echo '-';
                                }?></p>
                                <p>Other contact #: <?php if(isset($property['other_contact']) && (strlen($property['other_contact'])>5)){
                                    echo $property['other_contact'];
                                }else{
                                    echo '-';
                                }?></p>
                    
                            </div>
                        </div>
                            <a class="tooltipped share" data-position="bottom" data-tooltip="Share Property" href="#sharelisting<?php echo $property['id'];?>" data-property_id="<?php echo $property['id'];?>"><img src="<?php echo base_url();?>assets/images/photoviewaminities/shares.png" alt=""/></a>

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
                            <a class="tooltipped inquiry" data-position="bottom" data-tooltip="Send Inquiry to Agent" data-property_id="<?php echo $property['id'];?>">
                                <img src="<?php echo base_url();?>assets/images/photoviewaminities/messages.png" alt=""/>
                            </a>
                            <!--===============inquiry================-->
                            <!--===============inquiry================-->
                            <div id="inquiry<?php echo $property['id'];?>" class="modal custompopupdesign inquiry_agent">
                                <a href="#!" class="modal-close waves-effect modal_closeA">×</a>    
                                <form class="contactOwners" method="post">
                                    <h4 class="modal-title">Send Inquiry</h4>
                                    <input type="hidden" name="property_id" value="<?php echo $property['id'];?>">
                                    <div class="input-field">
                                        <input name="name" type="text" placeholder="Your Name" value="<?php echo 
                                        (isset($sessionData['first_name'])&&isset($sessionData['last_name']))?ucwords($sessionData['first_name']." ".$sessionData['last_name']):'';
                                        ?>">
                                    </div>
                                    <div class="input-field">
                                        <input name="email" type="email" placeholder="Email" value="<?php echo isset($sessionData['username'])?$sessionData['username']:'';?>">
                                    </div>
                                    <div class="input-field">
                                        <input class="phone" name="phone_number" type="tel" placeholder="Phone No." value="<?php echo isset($sessionData['user_number'])?$sessionData['code'].$sessionData['user_number']:'';?>">
                                    </div>
                                    <input type="hidden" class="phone_code" name="phone_code">
                                    <div class="input-field">
                                        <p class="onlyredsB">I am interested in this Property <b><span>'<?php echo isset($property['title'])?substr($property['title'],0,100).'...':'';?>'</span> <?php echo isset($property['mawjuud_reference'])?$property['mawjuud_reference']:'';?><?php echo isset($property['property_reference'])?'(Reference numbers Mawjuud-'.$property['property_reference'].')':'';?></b> and would like to schedule a viewing. Please Let me know when this would be possible</p>
                                    </div>
                                    <?php 
                                    $propertyQuestions = propertQuestions($property['id']);
                                    if(!empty($propertyQuestions['result'])){
                                    ?>
                                    <div class="questionModal">
                                        <h6>The agent is asking to answer a few questions to better understand your inquiry!</h6>
                                        <div class="row">
                                            <div class="col s12">
                                                <?php 
                                                $count = 1;
                                                foreach($propertyQuestions['result'] as $row){ ?>
                                                    <div class="input-field">
                                                        Ques <?php echo $count;?>: <?php echo ucfirst($row->question);?>
                                                        <textarea placeholder="Add your answer" name="answer[<?php echo $row->id;?>]" class="materialize-textarea" required></textarea>
                                                    </div>
                                                    <?php 
                                                    $count++;
                                                }
                                                ?>
                                            </div>
                                        </div> 
                                    </div>
                                    <?php } ?>
                                    <button type="submit" class="cntagents contactOwner waves-effect waves-light">Send Message</button>
                                </form>
                            </div>
                            <!--===============inquiry================-->
                            <!--===============inquiry================-->
                        </ul>
                    </div>  
                </div>
            </div>
        <?php } 
    }else{ ?>
        <div class="signin_error card-panel red lighten-3">
            <strong>No properties found</strong>
        </div>
    <?php }?>
</div>
<script type="text/javascript">
    $('.Mhideproperty').click(function(){
        var id = $(this).data("property");
        $.ajax({
            url: baseUrl+ 'property/hideProperty',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function (data) {

            },
        });
        $(this).closest('.box_div').hide();
    });
    $(".ti-slice").click(function(e) {
        e.preventDefault();
        disable();
        google.maps.event.addDomListener(map.getDiv(),'mousedown',function(e){
            drawFreeHand();
        });
    });
    $('.property_hover').hover(function(){
        var property_id = $(this).data('prop_id');
        google.maps.event.trigger(hoverMarker[property_id],'mouseover');
    });
    
    $('.tooltipped').tooltip();

    /*To contact agent*/
    $(".contactOwners").on('submit',function(e){
        alert(6565);
        e.preventDefault();
        $('.contactOwners').each( function(){
            var form = $(this);
            form.validate({
                errorPlacement: function (error, element) {
                    error.css('color', 'red');
                    error.insertAfter(element);
                },
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                },
                success: function(label) {
                    label.addClass("valid").text("")
                },
                submitHandler: function() { 
                    $('body').append(loader_ajax);
                    $('.loader_outer').show();
                    $.ajax({
                        url: baseUrl+ 'property/contactAgent',
                        type: 'post',
                        dataType: 'json',
                        data: form.serialize(),
                        success: function (data) {
                            $('.loader_outer').hide();
                            form[0].reset();
                            $('.inquiry_agent').modal('close');
                            if(data.status == 1){
                                Ply.dialog("alert",'Contact request sent successfully to an agent');
                            }
                            $('.modal-close').trigger('click');
                        },
                    });
                }
            })
        });
    });

jQuery(document).ready(function() {
    jQuery(document).on('click','.inquiry',function(){
        propertyID = $(this).data('property_id');
        jQuery(this).siblings('#inquiry'+propertyID).addClass('open1').after('<div class="modal-overlay" style="z-index: 1002; display: block; opacity: 0.5;"></div>');
        jQuery('.modal').modal();
    });

    jQuery(document).on('click','.modal-close',function(){
        jQuery(this).parents('.modal').removeClass('open1').hide();
        jQuery('.modal-overlay').hide();
    });
});
 $(".phone").intlTelInput();
</script>