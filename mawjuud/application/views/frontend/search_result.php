<div class="row">
    <?php 
    if($type == 'grid'){
        if(!empty($propertyData)){ 
            $location = array();
            $count = 0;
            foreach($propertyData as $property){ 
                $favourite = '';
                $location[$count][] = $property['property_address'];
                $location[$count][] = $property['latitude'];
                $location[$count][] = $property['longitude'];
                $location[$count][] = $property['id'];
                if(isset($property['thumbnail_photo_media'])){
                    $imgArray = explode('|',$property['thumbnail_photo_media']); 
                    $location[$count][] = $imgArray[0];
                }else{
                    $location[$count][] = base_url().DEFAULT_PROPERTY_IMAGE;
                }

                if($property['property_type']=='sale'){
                    $location[$count][] = 'SGC1';
                }else{
                    $location[$count][] = 'SGC';
                }

                $location[$count][] = isset($property['property_type'])?ucfirst($property['property_type']):'';
                $location[$count][] = isset($property['bathselect'])?$property['bathselect']:'';

                if(isset($property['bedselect'])){
                    if($property['bedselect']==100)
                        $location[$count][] = 'Studio';
                    else
                        $location[$count][] = $property['bedselect'];
                }

                $location[$count][] = isset($property['square_feet'])?number_format($property['square_feet'])." Sq. ft.":'';
                $location[$count][] =isset($property['name'])?$property['name']:'';

                $location[$count][] =isset($property['property_address'])?ucfirst($property['property_address']):'';

                $location[$count][] = isset($property['property_price'])?number_format($property['property_price']).' AED':'';

                $images = isset($property['thumbnail_photo_media'])?explode("|",$property['thumbnail_photo_media']):0;
                if($images){
                    $location[$count][] = count($images);
                }else{
                    $location[$count][] = 0;
                }
                if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                    $favourite = 'fillHearts';
                    $location[$count][] = 'fillHearts';
                }else{
                    $location[$count][] = '';
                }
                $location[$count][] = encoding($property['id']);
                $location[$count][] = $property['title'];
                $count++;
                ?>
                <div class="col s6 box_div property_hover" data-prop_id="<?php echo $property['id'];?>">
                    <div class="in_box">
                        <div class="box_img1">
                            <div class="compareX"><span class="ti-heart <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);"></span></div>
                            <div class="Mhideproperty" data-property = "<?php echo $property['id'];?>">
                                <img src="<?php echo base_url();?>assets/images/map-icon/hide-icon.png" alt="images"/>
                            </div>
                            <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" class="waves-effect waves-light" target="_blank">
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
                                            <?php if(isset($property['bathselect'])){?>
                                                <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> <?php echo $property['bathselect']?> 
                                            <?php } 

                                            if(isset($property['bedselect'])){ ?>
                                                |
                                                <img src="<?php echo base_url();?>assets/images/bed.png" alt="images"> <?php echo ($property['bedselect']==100)?"Studio":$property['bedselect'];?>
                                            <?php } ?>
                                            <img src="<?php echo base_url();?>assets/images/size.png" alt="images"><?php echo number_format($property['square_feet'])." Sq. ft.";?>
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
            <?php } ?>
        <?php }else{ ?>
            <div class="signin_error card-panel red lighten-3">
                <strong>No properties found</strong>
            </div>
        <?php }
    }else { ?>
        <table class="responsive-table searchshortingTbM">
            <thead>
                <tr>
                    <th></th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Address</th>
                    <th id="Mshortprc">Price(AED) <img src="assets/images/map-icon/shorting-icon.png" alt="images" class="miniconM"/></th>
                    <th id="Mshortbed">Bed(s) <img src="assets/images/map-icon/shorting-icon.png" alt="images" class="miniconM"/></th>
                    <th id="Mshortbath">Bath(s) <img src="assets/images/map-icon/shorting-icon.png" alt="images" class="miniconM"/></th>
                    <th id="Mshortsqft">Size (Sq. ft.) <img src="assets/images/map-icon/shorting-icon.png" alt="images" class="miniconM"/></th>
                    <th>Favorite</th>
                    <th>Add to Compare</th>
                    <th>Hide</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($propertyData)){ 
                    foreach($propertyData as $property){ 
                        $favourite = '';
                        if(!empty($favourite_properties) && in_array($property['id'],$favourite_properties)){
                            $favourite = 'fillHearts';
                        }
                        $compare = '';
                        if(!empty($compareProperties) && in_array($property['id'],$compareProperties)){
                            $compare = 'style="color:#ff8787"';
                        }
                    ?>
                        <tr class="box_div">
                            <td><span><?php echo (isset($property['property_type']) && ($property['property_type']=='sale')) ?'S':'R';?></span></td>
                            <td><?php echo isset($property['name'])?$property['name']:''; ?></td>
                            <td><a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><?php echo isset($property['title'])?$property['title']:''; ?></a></td>
                            <td><p><?php echo isset($property['property_address'])?$property['property_address']:''; ?></p></td>
                            <td><?php echo isset($property['property_price'])?number_format($property['property_price'])."":''; ?></td>
                            <td><?php 
                            if(isset($property['bedselect'])){
                                if($property['bedselect'] == 100){
                                    echo  "Studio";
                                }else{
                                    echo $property['bedselect'];
                                }
                            }
                            ?></td>
                            <td><?php echo isset($property['bathselect'])?$property['bathselect']:''; ?></td>
                            <td><?php echo isset($property['square_feet'])?$property['square_feet']:''; ?></td>
                            <td><div class=""><span class="ti-heart <?php echo $favourite;?>"  onclick="favouriteProperty(<?php echo $property['id'];?>,this);"></span></div></td>

                            <td><div class=""><span class="ti-plus" onclick="compareProperty(<?php echo $property['id'];?>,this);" <?php echo $compare;?>></span></div></td>
                            
                            <td><img src="<?php echo base_url();?>assets/images/map-icon/table-delete.png" class="fixsizeiconM Mhideproperty" alt="images" data-property = "<?php echo $property['id'];?>"/></td>
                        </tr>
                    <?php }
                }?>
            </tbody>
        </table>
    <?php }?>
</div>


<script type="text/javascript" src="<?php echo base_url()?>assets/js/frontend/datatables.min.js?<?php echo $timeStamp;?>"></script>

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
    $('.property_hover').hover(function(){
        var property_id = $(this).data('prop_id');
        google.maps.event.trigger(hoverMarker[property_id],'mouseover');
    });
$(document).ready(function() {
    $('.searchshortingTbM').DataTable({
        "order": []
    });
});
 
</script>

