<div class="hover_property" data-prop_id="<?php echo $property['id'];?>">
    <div class="col s6 photoView">
        <div class="in_box">
            <div class="box_img1">
                <div class="compareX"><span class="ti-heart ti-heart<?php echo $property['id'];?> <?php echo $favourite;?>" onclick="favouriteProperty(<?php echo $property['id'];?>,this);"></span></div>
                <div class="Mhideproperty" data-property = "<?php echo $property['id'];?>">
                    <!-- <img src="<?php echo base_url();?>assets/images/map-icon/hide-icon.png" alt="images"/> -->
                    <svg height="21px" width="21px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="512px" height="512px">
                        <g>
                            <g>
                                <g>
                                    <polygon points="353.574,176.526 313.496,175.056 304.807,412.34 344.885,413.804    " fill="#FFFFFF"/>
                                    <rect x="235.948" y="175.791" width="40.104" height="237.285" fill="#FFFFFF"/>
                                    <polygon points="207.186,412.334 198.497,175.049 158.419,176.52 167.109,413.804    " fill="#FFFFFF"/>
                                    <path d="M17.379,76.867v40.104h41.789L92.32,493.706C93.229,504.059,101.899,512,112.292,512h286.74     c10.394,0,19.07-7.947,19.972-18.301l33.153-376.728h42.464V76.867H17.379z M380.665,471.896H130.654L99.426,116.971h312.474     L380.665,471.896z" fill="#FFFFFF"/>
                                </g>
                            </g>
                        </g>
                        <g>
                            <g>
                                <path d="M321.504,0H190.496c-18.428,0-33.42,14.992-33.42,33.42v63.499h40.104V40.104h117.64v56.815h40.104V33.42    C354.924,14.992,339.932,0,321.504,0z" fill="#FFFFFF"/>
                            </g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                        <g>
                        </g>
                    </svg>

                </div>
                <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank" class="waves-effect waves-light" target="_blank">
                    <?php 
                    $img = base_url().DEFAULT_PROPERTY_IMAGE;
                    // if(!empty($property['thumbnail_photo_media'])){
                    //     $imgArray = explode('|',$property['thumbnail_photo_media']); 
                    //     $img = $imgArray[0];
                    // }
                    if(!empty($property['photo_media'])){
                        $imgArray = explode('|',$property['photo_media']); 
                        $img = $imgArray[0];
                    }
                    ?>
                    <img src="<?php echo $img;?>" alt="images">
                    <span class="ForSale <?php echo ($property['property_type']=='sale')?'SGC1':'SGC';?>">For <?php echo !empty($property['property_type'])?ucfirst($property['property_type']):'';?></span>
                    <div class="box_cnts">
                        <div class="bed_bath">
                            <p>
                                <?php if(!empty($property['bathselect'])){ ?>
                                    <img src="<?php echo base_url();?>assets/images/bath.png" alt="images"> <?php 
                                    if($property['bathselect'] == 0){
                                        echo '-';
                                    }else{
                                        echo $property['bathselect'];
                                    }
                                    ?> 
                                <?php } 

                                if(!empty($property['bedselect'])){ ?>
                                    |
                                    <img src="<?php echo base_url();?>assets/images/bed.png" alt="images"> 
                                    <?php 
                                    if($property['bedselect']==100){
                                        echo "Studio";
                                    }else if($property['bedselect'] == 0){
                                        echo "-";
                                    }else{
                                        echo $property['bedselect'];
                                    }
                                    ?>
                                <?php } ?>
                                |<img src="<?php echo base_url();?>assets/images/size.png" alt="images"> <?php echo number_format($property['square_feet'])." Sq. ft.";?>
                            </p>
                        </div>
                        <h4><?php echo !empty($property['name'])?$property['name']:''; ?></h4>
                        <h6><span class="ti-location-pin"></span> <?php echo !empty($property['property_address'])?ucfirst($property['property_address']):'';?></h6>
                        <h5><span class="PriceSp"><?php echo !empty($property['property_price'])?number_format($property['property_price']):'';?> AED</span></h5>
                    </div>
                </a>
                <?php 
                $img = 0;
                $images = !empty($property['photo_media'])?explode("|",$property['photo_media']):0;
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
    <div class="col s6 photoView">
        <div class="photoViewsRightcnt">
            <div class="PviewTitle">
                <img src="<?php echo base_url();?>assets/images/<?php echo $property['image']?>" alt=""/>
                <h4>
                    <a href="<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><?php echo !empty($property['title'])?ucfirst($property['title']):'';?>
                </a>
            </h4>
        </div>
        <ul class="aminitiesMpview">
            <li class="price-phtview">
                <span><?php echo !empty($property['property_price'])?number_format($property['property_price']):'';?> <i>AED</i></span> 
                <!-- <img src="<?php echo base_url();?>assets/images/photoviewaminities/price.png" alt=""/>  -->
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="36px" height="36px" x="0px" y="0px" viewBox="0 0 56.414 56.414" style="enable-background:new 0 0 56.414 56.414;" xml:space="preserve"> <path d="M56.414,11.089L45.299,0H31.295l-5.519,5.501C12.053,4.356,0.988,12.076,0.833,12.187c-0.449,0.32-0.554,0.945-0.232,1.395 C0.796,13.854,1.103,14,1.415,14c0.201,0,0.404-0.061,0.58-0.187c0.139-0.099,9.712-6.776,21.881-6.419L5.999,25.213l0.008,0.008 L0,31.213l25.146,25.201l10.04-10.013c2.062,1.08,4.461,1.611,6.834,1.61c3.501,0,6.935-1.138,9.101-3.304 c7.367-7.368,4.443-15.45,3.443-17.633l1.849-1.845V11.089z M44.473,2l9.941,9.919v12.48L34.876,43.873 c-4.084-2.928-5.327-8.422-3.493-15.626c0.137-0.535-0.187-1.08-0.722-1.216c-0.537-0.143-1.079,0.187-1.216,0.722 C26.856,37.92,30.335,42.934,33.444,45.3l-2.293,2.286L8.836,25.224L26.516,7.59c4.198,0.48,8.631,1.866,13.046,4.667 c-0.039,0.221-0.068,0.446-0.068,0.678c0,2.17,1.765,3.935,3.935,3.935s3.936-1.765,3.936-3.935S45.599,9,43.429,9 c-1.216,0-2.291,0.566-3.013,1.436c-4.089-2.557-8.187-3.982-12.118-4.622L32.121,2H44.473z M41.814,13.8 c0.442,0.332,1.069,0.243,1.399-0.2c0.332-0.441,0.242-1.068-0.2-1.399c-0.309-0.231-0.619-0.435-0.928-0.652 C42.434,11.21,42.907,11,43.429,11c1.067,0,1.936,0.868,1.936,1.936c0,1.066-0.868,1.935-1.936,1.935 c-0.803,0-1.492-0.492-1.785-1.19C41.701,13.722,41.758,13.757,41.814,13.8z M2.828,31.217l4.592-4.58l22.322,22.37l-4.592,4.58 L2.828,31.217z M49.707,43.293c-2.576,2.574-8.37,3.748-13.03,1.621l16.375-16.332C54.047,31.058,55.657,37.342,49.707,43.293z"/> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>

            </li>
            <li>
                <span><?php echo !empty($property['square_feet'])?number_format($property['square_feet']):'';?></span>
                <!-- <img src="<?php echo base_url();?>assets/images/photoviewaminities/squareft.png" alt=""/> -->

                <svg height="32px" viewBox="-21 -21 682.66669 682.66669" width="32px" xmlns="http://www.w3.org/2000/svg"><path d="m458.398438 319.914062c0 6.898438-5.601563 12.5-12.5 12.5h-112.796876v112.8125c0 6.898438-5.601562 12.5-12.5 12.5-6.898437 0-12.5-5.601562-12.5-12.5v-112.8125h-112.804687c-6.898437 0-12.5-5.601562-12.5-12.5 0-6.902343 5.601563-12.5 12.5-12.5h112.804687v-112.8125c0-6.914062 5.601563-12.5 12.5-12.5 6.898438 0 12.5 5.585938 12.5 12.5v112.8125h112.796876c6.898437 0 12.5 5.597657 12.5 12.5zm0 0"/><path d="m627.5 100.023438c6.898438 0 12.5-5.601563 12.5-12.5v-75.023438c0-6.898438-5.601562-12.5-12.5-12.5h-75.023438c-6.898437 0-12.5 5.601562-12.5 12.5v25.015625h-40.828124c-6.898438 0-12.5 5.59375-12.5 12.5 0 6.898437 5.601562 12.5 12.5 12.5h40.828124v25.007813c0 6.898437 5.601563 12.5 12.5 12.5h25.007813v170.527343h-25.007813c-6.898437 0-12.5 5.601563-12.5 12.5v75.027344c0 6.898437 5.601563 12.5 12.5 12.5h25.007813v169.40625h-25.007813c-6.898437 0-12.5 5.59375-12.5 12.5v25h-169.367187v-25c0-6.90625-5.59375-12.5-12.5-12.5h-75.023437c-6.898438 0-12.5 5.59375-12.5 12.5v25h-170.570313v-25c0-6.90625-5.59375-12.5-12.5-12.5h-25v-169.40625h25c6.90625 0 12.5-5.601563 12.5-12.5v-75.027344c0-6.898437-5.59375-12.5-12.5-12.5h-25v-170.527343h25c6.90625 0 12.5-5.601563 12.5-12.5v-25.007813h170.570313v25.007813c0 6.898437 5.601562 12.5 12.5 12.5h75.023437c6.90625 0 12.5-5.601563 12.5-12.5v-25.007813h40.828125c6.914062 0 12.5-5.601563 12.5-12.5 0-6.90625-5.585938-12.5-12.5-12.5h-40.828125v-25.015625c0-6.898438-5.59375-12.5-12.5-12.5h-75.023437c-6.898438 0-12.5 5.601562-12.5 12.5v25.015625h-170.570313v-25.015625c0-6.898438-5.59375-12.5-12.5-12.5h-75.015625c-6.898438 0-12.5 5.601562-12.5 12.5v75.023438c0 6.898437 5.601562 12.5 12.5 12.5h25.015625v170.527343h-25.015625c-6.898438 0-12.5 5.601563-12.5 12.5v75.027344c0 6.898437 5.601562 12.5 12.5 12.5h25.015625v169.40625h-25.015625c-6.898438 0-12.5 5.59375-12.5 12.5v75.015625c0 6.898438 5.601562 12.5 12.5 12.5h75.015625c6.90625 0 12.5-5.601562 12.5-12.5v-25.015625h170.570313v25.015625c0 6.898438 5.601562 12.5 12.5 12.5h75.023437c6.90625 0 12.5-5.601562 12.5-12.5v-25.015625h169.367187v25.015625c0 6.898438 5.601563 12.5 12.5 12.5h75.023438c6.898438 0 12.5-5.601562 12.5-12.5v-75.015625c0-6.90625-5.601562-12.5-12.5-12.5h-25.015625v-169.40625h25.015625c6.898438 0 12.5-5.601563 12.5-12.5v-75.027344c0-6.898437-5.601562-12.5-12.5-12.5h-25.015625v-170.527343zm-331.914062-75.023438h50.023437v50.023438h-50.023437zm-270.585938 50.023438v-50.023438h50.015625v50.023438zm0 270.554687v-50.027344h50.015625v50.027344zm50.015625 269.421875h-50.015625v-50.015625h50.015625zm270.59375 0h-50.023437v-50.015625h50.023437zm269.390625-50.015625v50.015625h-50.023438v-50.015625zm0-269.433594v50.027344h-50.023438v-50.027344zm-50.023438-220.527343v-50.023438h50.023438v50.023438zm0 0"/><path d="m455.320312 62.515625c-6.902343 0-12.507812-5.601563-12.507812-12.5 0-6.90625 5.589844-12.5 12.496094-12.5h.011718c6.902344 0 12.5 5.59375 12.5 12.5 0 6.898437-5.597656 12.5-12.5 12.5zm0 0"/></svg>
                <i>Sq. ft</i>    
            </li>

            <li>
                <?php if(!empty($property['bedselect'])){ ?>
                    <span>
                        <?php 
                        if($property['bedselect']==100){
                            echo "Studio";
                        }else if($property['bedselect'] == 0){
                            echo "-";
                        }else{
                            echo $property['bedselect'];
                        }
                        ?>
                    </span> 
                    <!-- <img src="<?php echo base_url();?>assets/images/bed1.png" alt=""/> -->
                    <svg height="32px" width="32px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    viewBox="0 0 374 374" style="enable-background:new 0 0 374 374;" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M337.6,158.6v-0.4V97.8c0-27.2-19.2-37.2-37.2-37.2h-228c-18,0-37.2,9.6-37.2,37.2v60.4v0.4c-18,2-35.2,14-35.2,41.6v47.2
                            c0,8,6.4,14.4,14.4,14.4h4.8V299c0,8,6.4,14.4,14.4,14.4h13.6c8,0,14.4-6.4,14.4-14.4v-37.6h250.8V299c0,8,6.4,14.4,14.4,14.4
                            h13.6c8,0,14.4-6.4,14.4-14.4v-37.6h4.8c8,0,14.4-6.4,14.4-14.4v-46.8C372.8,172.6,355.6,160.6,337.6,158.6z M48.8,97.8h0.8
                            C49.6,79,62,75,72.4,75h228c10.4,0,22.8,4,22.8,22.8v60.4h-10.8v-34.4c0-8-6.4-14.4-14.4-14.4h-88c-8,0-14.4,6.4-14.4,14.4v34.4
                            h-16.8v-34.4c0-8-6.4-14.4-14.4-14.4h-88c-8,0-14.4,6.4-14.4,14.4v34.4H48.8V97.8z M298,123.8v34.4h-88v-34.4H298z M165.2,123.8
                            v34.4h-88v-34.4H165.2z M46.8,299H33.2v-37.6h13.6V299z M339.6,299H326v-37.6h13.6V299z M358.4,247.4h-18.8H326H46.8H33.2H14
                            v-21.2h344.4V247.4z M358.4,211.8H14v-11.6c0-24,17.6-27.6,27.6-27.6h7.6h27.6h88H210h88h25.2h7.6c10.4,0,27.6,3.6,27.6,27.6
                            V211.8z"/>
                        </g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                    <g>
                    </g>
                </svg>

                <i>Bedrooms</i>   
            <?php } ?>
        </li>

        <li>
            <?php if(!empty($property['bathselect'])){ ?>
                <span>
                    <?php 
                    if($property['bathselect'] == 0){
                        echo '-';
                    }else{
                        echo $property['bathselect'];
                    }
                    ?>  
                </span> 
                <!-- <img src="<?php echo base_url();?>assets/images/bath1.png" alt=""/> -->

                <svg height="32px" width="32px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                <g transform="translate(1 1)">
                    <g>
                        <g>
                            <path d="M485.4,272.067h-8.533v-179.2c0-42.667-34.133-76.8-76.8-76.8c-37.77,0-64.935,28.006-67.974,69.041
                            c-19.829,3.748-34.426,20.826-34.426,41.892c0,5.12,3.413,8.533,8.533,8.533h68.267c5.12,0,8.533-3.413,8.533-8.533
                            c0-20.833-14.274-37.769-33.767-41.767c2.55-27.116,18.836-52.1,50.834-52.1c33.28,0,59.733,26.453,59.733,59.733v179.2H202.975
                            c-3.86-19.681-20.878-34.133-41.841-34.133c-8.533-10.24-20.48-17.067-34.133-17.067c-16.213,0-30.72,9.387-37.547,23.04
                            c-6.827-3.413-14.507-5.973-22.187-5.973c-20.963,0-37.981,14.452-41.841,34.133H24.6c-14.507,0-25.6,11.093-25.6,25.6
                            c0,14.507,11.093,25.6,25.6,25.6h10.255l23.025,91.307c6.827,26.453,30.72,45.227,58.027,45.227h6.827l-11.093,22.187
                            c-2.56,4.267-0.853,9.387,3.413,11.093c0.853,0.853,2.56,0.853,3.413,0.853c3.413,0,5.973-1.707,7.68-4.267L141.08,459.8h236.8
                            l14.507,29.013c1.707,3.413,4.267,5.12,7.68,5.12c1.707,0,2.56,0,3.413-1.707c3.413-1.707,5.12-6.827,3.413-11.093
                            l-10.689-21.379c26.419-0.938,49.266-19.39,55.916-44.328l23.24-92.16h10.04c14.507,0,25.6-11.093,25.6-25.6
                            C511,283.16,499.907,272.067,485.4,272.067z M365.08,118.467h-48.64c3.413-10.24,13.653-17.067,24.747-17.067
                            S361.667,108.227,365.08,118.467z M67.267,255c7.68,0,14.507,3.413,20.48,9.387c1.707,2.56,5.12,3.413,8.533,2.56
                            s5.12-3.413,5.973-6.827c2.56-12.8,12.8-22.187,25.6-22.187c9.387,0,17.92,4.267,22.187,12.8c1.707,3.413,5.973,5.12,9.387,4.267
                            c0.853,0,1.707,0,2.56,0c11.093,0,20.48,6.827,23.893,17.067H43.373C46.787,261.827,56.173,255,67.267,255z M436.76,410.307
                            c-5.12,18.773-22.187,32.427-41.813,32.427H116.76c-19.627,0-36.693-13.653-41.813-32.427l-22.187-87.04h404.48L436.76,410.307z
                            M485.4,306.2h-17.067H41.667H24.6c-5.12,0-8.533-3.413-8.533-8.533s3.413-8.533,8.533-8.533h8.533h162.133H485.4
                            c5.12,0,8.533,3.413,8.533,8.533S490.52,306.2,485.4,306.2z"/>
                            <path d="M306.2,173.933c5.12,0,8.533-3.413,8.533-8.533v-4.267c0-5.12-3.413-8.533-8.533-8.533s-8.533,3.413-8.533,8.533v4.267
                            C297.667,170.52,301.08,173.933,306.2,173.933z"/>
                            <path d="M306.2,213.187c5.12,0,8.533-4.267,8.533-8.533v-9.387c0-5.12-3.413-8.533-8.533-8.533s-8.533,3.413-8.533,8.533v9.387
                            C297.667,209.773,301.08,213.187,306.2,213.187z"/>
                            <path d="M306.2,246.467c5.12,0,8.533-3.413,8.533-8.533v-4.267c0-5.12-3.413-8.533-8.533-8.533s-8.533,3.413-8.533,8.533v4.267
                            C297.667,243.053,301.08,246.467,306.2,246.467z"/>
                            <path d="M340.333,173.933c5.12,0,8.533-3.413,8.533-8.533v-4.267c0-5.12-3.413-8.533-8.533-8.533
                            c-5.12,0-8.533,3.413-8.533,8.533v4.267C331.8,170.52,335.213,173.933,340.333,173.933z"/>
                            <path d="M331.8,204.653c0,5.12,3.413,8.533,8.533,8.533c5.12,0,8.533-4.267,8.533-8.533v-9.387c0-5.12-3.413-8.533-8.533-8.533
                            c-5.12,0-8.533,3.413-8.533,8.533V204.653z"/>
                            <path d="M331.8,237.933c0,5.12,3.413,8.533,8.533,8.533c5.12,0,8.533-3.413,8.533-8.533v-4.267c0-5.12-3.413-8.533-8.533-8.533
                            c-5.12,0-8.533,3.413-8.533,8.533V237.933z"/>
                            <path d="M374.467,173.933c5.12,0,8.533-3.413,8.533-8.533v-4.267c0-5.12-3.413-8.533-8.533-8.533s-8.533,3.413-8.533,8.533v4.267
                            C365.933,170.52,369.347,173.933,374.467,173.933z"/>
                            <path d="M365.933,204.653c0,5.12,3.413,8.533,8.533,8.533S383,208.92,383,204.653v-9.387c0-5.12-3.413-8.533-8.533-8.533
                            s-8.533,3.413-8.533,8.533V204.653z"/>
                            <path d="M365.933,237.933c0,5.12,3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533v-4.267c0-5.12-3.413-8.533-8.533-8.533
                            s-8.533,3.413-8.533,8.533V237.933z"/>
                        </g>
                    </g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
            </svg>

            <i>Bathrooms</i>    
        <?php } ?>
    </li>

    <li>
        <?php 
        $img = !empty($property['profile_thumbnail'])?$property['profile_thumbnail']:base_url().DEFAULT_IMAGE;
        ?>
        <img src="<?php echo $img;?>" alt=""/>
        <div class="refCodes"><b>Ref #:</b> <?php echo !empty($property['mawjuud_reference'])?$property['mawjuud_reference']:'-';?></div>    
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
        <!-- <img src="<?php echo base_url();?>assets/images/photoviewaminities/collphone.png" alt=""/> -->
        <svg height="30px" width="30px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        width="512px" height="512px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
        <g>
            <path d="M256,32c123.5,0,224,100.5,224,224S379.5,480,256,480S32,379.5,32,256S132.5,32,256,32 M256,0C114.625,0,0,114.625,0,256
            s114.625,256,256,256s256-114.625,256-256S397.375,0,256,0L256,0z M398.719,341.594l-1.438-4.375
            c-3.375-10.062-14.5-20.562-24.75-23.375L334.688,303.5c-10.25-2.781-24.875,0.969-32.405,8.5l-13.688,13.688
            c-49.75-13.469-88.781-52.5-102.219-102.25l13.688-13.688c7.5-7.5,11.25-22.125,8.469-32.406L198.219,139.5
            c-2.781-10.25-13.344-21.375-23.406-24.75l-4.313-1.438c-10.094-3.375-24.5,0.031-32,7.563l-20.5,20.5
            c-3.656,3.625-6,14.031-6,14.063c-0.688,65.063,24.813,127.719,70.813,173.75c45.875,45.875,108.313,71.345,173.156,70.781
            c0.344,0,11.063-2.281,14.719-5.938l20.5-20.5C398.688,366.062,402.062,351.656,398.719,341.594z"/>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
        <g>
        </g>
    </svg>

</a>

<div id="callModal<?php echo $property['id'];?>" class="modal custompopupdesign">
    <a href="#!" class="modal-close waves-effect modal_closeA">&times;</a>
    <div class="my-signup"> 
        <div>Reference Number - <?php echo !empty($property['mawjuud_reference'])?$property['mawjuud_reference']:'';?></div>
        <p>Phone number 1: <?php if(!empty($property['phone']) && (strlen($property['phone'])>5)){
            echo $property['phone'];
        }else{
            echo '-';
        }?></p>
        <p>Other contact #: <?php if(!empty($property['other_contact']) && (strlen($property['other_contact'])>5)){
            echo $property['other_contact'];
        }else{
            echo '-';
        }?></p>

    </div>
</div>
<a class="tooltipped share" data-position="bottom" data-tooltip="Share Property" href="#sharelisting<?php echo $property['id'];?>" data-property_id="<?php echo $property['id'];?>">
    <!-- <img src="<?php echo base_url();?>assets/images/photoviewaminities/shares.png" alt=""/> -->
    <svg height="30px" width="30px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    width="475.082px" height="475.081px" viewBox="0 0 475.082 475.081" style="enable-background:new 0 0 475.082 475.081;"
    xml:space="preserve">
    <g>
        <g>
            <path d="M469.658,133.333L360.029,23.697c-3.621-3.617-7.909-5.424-12.854-5.424c-2.275,0-4.661,0.476-7.132,1.425
            c-7.426,3.237-11.139,8.852-11.139,16.846v54.821h-45.683c-20.174,0-38.879,1.047-56.101,3.14
            c-17.224,2.092-32.404,4.993-45.537,8.708c-13.134,3.708-24.983,8.326-35.547,13.846c-10.562,5.518-19.555,11.372-26.98,17.559
            c-7.426,6.186-13.943,13.23-19.558,21.129c-5.618,7.898-10.088,15.653-13.422,23.267c-3.328,7.616-5.992,15.99-7.992,25.125
            c-2.002,9.137-3.333,17.701-3.999,25.693c-0.666,7.994-0.999,16.657-0.999,25.979c0,10.663,1.668,22.271,4.998,34.838
            c3.331,12.559,6.995,23.407,10.992,32.545c3.996,9.13,8.709,18.603,14.134,28.403c5.424,9.802,9.182,16.317,11.276,19.555
            c2.093,3.23,4.095,6.187,5.997,8.85c1.903,2.474,4.377,3.71,7.421,3.71c0.765,0,1.902-0.186,3.427-0.568
            c4.377-2.095,6.279-5.325,5.708-9.705c-8.564-63.954-1.52-108.973,21.128-135.047c21.892-24.934,63.575-37.403,125.051-37.403
            h45.686v54.816c0,8.001,3.71,13.613,11.136,16.851c2.471,0.951,4.853,1.424,7.132,1.424c5.14,0,9.425-1.807,12.854-5.421
            l109.633-109.637c3.613-3.619,5.424-7.898,5.424-12.847C475.082,141.23,473.271,136.944,469.658,133.333z"/>
            <path d="M395.996,292.356c-3.625-1.529-6.951-0.763-9.993,2.283c-4.948,4.568-10.092,8.093-15.42,10.564
            c-3.433,1.902-5.141,4.66-5.141,8.277v61.104c0,12.562-4.466,23.308-13.415,32.26c-8.945,8.946-19.704,13.419-32.264,13.419
            H82.222c-12.564,0-23.318-4.473-32.264-13.419c-8.947-8.952-13.418-19.697-13.418-32.26V137.039
            c0-12.563,4.471-23.313,13.418-32.259c8.945-8.947,19.699-13.418,32.264-13.418h31.977c1.141,0,2.666-0.383,4.568-1.143
            c10.66-6.473,23.313-12.185,37.972-17.133c4.949-0.95,7.423-3.994,7.423-9.136c0-2.474-0.903-4.611-2.712-6.423
            c-1.809-1.804-3.946-2.708-6.423-2.708H82.226c-22.65,0-42.018,8.042-58.102,24.125C8.042,95.026,0,114.394,0,137.044v237.537
            c0,22.651,8.042,42.018,24.125,58.102c16.084,16.084,35.452,24.126,58.102,24.126h237.541c22.647,0,42.017-8.042,58.101-24.126
            c16.085-16.084,24.127-35.45,24.127-58.102v-73.946C401.995,296.829,399.996,294.071,395.996,292.356z"/>
        </g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
</svg>

</a>

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
                <?php $photos = !empty($property['thumbnail_photo_media'])?$property['thumbnail_photo_media']:'';
                $photoArray = explode("|",$photos);
                ?>
                <div class="footer-share-sc">
                    <a href="javascript:void(0)"  onclick="submitAndShare('<?php if(!empty($photoArray[0]) && !empty($photoArray[0])){ echo $photoArray[0];}?>','<?php echo $property['title'];?>','<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>')" target="_blank"><span class="ti-facebook"></span></a>
                    <a href="http://pinterest.com/pin/create/button/?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>&media=<?php if(!empty($photoArray[0]) && !empty($photoArray[0])){ echo $photoArray[0];}?>&description=<?php echo $property['title'];?>" class="pin-it-button" count-layout="horizontal" target="_blank"><span class="ti-pinterest"></span></a>
                    <a href="https://twitter.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><span class="ti-twitter"></span></a>
                    <a href="https://plus.google.com/share?url=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" target="_blank"><span class="ti-google"></span></a>
                    <a href="whatsapp://send?text=<?php echo base_url();?>single_property?id=<?php echo encoding($property['id']);?>" data-action="share/whatsapp/share"><span><img src="<?php echo base_url();?>assets/images/whatsappicon.png"></span></a>

                </div>
            </div>
        </div>
        <?php 
        $img = base_url().DEFAULT_PROPERTY_IMAGE;
        if(!empty($property['thumbnail_photo_media'])){
            $imgArray = explode('|',$property['thumbnail_photo_media']); 
            $img = $imgArray[0];
        }
        ?>
        <input type="hidden" name="first_img" value="<?php echo $img;?>">
    </form>
</div>
<!--===============sharelisting================-->
<!--===============sharelisting================-->
<a class="tooltipped inquiry" data-position="bottom" data-tooltip="Send Inquiry to Agent" data-property_id="<?php echo $property['id'];?>">   
    <!-- <img src="<?php echo base_url();?>assets/images/photoviewaminities/messages.png" alt=""/> -->
    <svg height="30px" width="30px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
    <g>
        <g>
            <path d="M467,61H45C20.218,61,0,81.196,0,106v300c0,24.72,20.128,45,45,45h422c24.72,0,45-20.128,45-45V106
            C512,81.28,491.872,61,467,61z M460.786,91L256.954,294.833L51.359,91H460.786z M30,399.788V112.069l144.479,143.24L30,399.788z
            M51.213,421l144.57-144.57l50.657,50.222c5.864,5.814,15.327,5.795,21.167-0.046L317,277.213L460.787,421H51.213z M482,399.787
            L338.213,256L482,112.212V399.787z"/>
        </g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
    <g>
    </g>
</svg>

</a>
<!--===============inquiry================-->
<!--===============inquiry================-->
<?php
$sessionData = '';
if($this->session->userdata('sessionData')){
    $sessionData = $this->session->userdata('sessionData');
} 
?>

<!--===============inquiry================-->
<!--===============inquiry================-->
</ul>
</div>  
</div>
</div>