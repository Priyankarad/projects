<div class="modal fade" id="myModal2">

        <div class="modal-dialog">
            <div class="modal-content">
               <div id="success_post"></div>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!--div share_your start-->
                <!--div share_your start-->
                <div class="share_your">
                    <form id="dataEditPost" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                        
                        <?php if(isset($postData->post_image) && $postData->post_image!=''){ ?>
                        <div class="tabsupphoto">
                            <ul>
                                <li class="rightform">
                                    <div class="form-group">
                                        <div class="mnDiv">
                                            <label class="upld_lbl">
                                                <i class="fa fa-image"></i> 
                                                <label>Photo Upload</label>
                                                <?php if(isset($postData->post_image)){
                                                    $images = explode(',',$postData->post_image);
                                                    echo '<div class="my_upload_pics_t">';
                                                    foreach($images as $row){
                                                        echo 
                                                        "<div class='s'><img class='imageThumb' src='".$row."'></img><span onclick=remove(this)><i class='fa fa-close'></i></span><input type='hidden' name='post_images_[]' value='".$row."' class='check_empty' ></div>";
                                                    }
                                                    echo '<div class="img_div"></div>
                                                    <div class="my_plus_i89" style="display: block;">
                                                    <a href="javascript:void(0)" class="plusicon">
                                                    <i class="fa fa-plus"></i>
                                                    <input class="files add_more check_empty" name="post_images[]" multiple="" accept=".png, .jpg, .jpeg, .gif" type="file">
                                                    </a>
                                                    </div>';
                                                }?>
                                                <!-- <input class="files" name="userpic" accept=".png, .jpg, .jpeg, .gif" type="file"> -->
                                            </label>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>

                        <div class="form-group pdno">
                            <textarea name="post_content" placeholder="Share your thoughts here." class="form-control" 
                            id="epost_content" value="<?php echo $postData->post_content?>"><?php echo $postData->post_content?></textarea>
                        </div>
                        <input type="hidden" name="post_id" value="<?php echo $postData->id;?>">
                        <div class="post_bx">
                            <div class="form-group">
                                <input class="btn btn-success btn-sm post_add" onclick="saveData('dataEditPost','<?php echo site_url('user/editwallpost'); ?>',<?php echo $postData->id; ?>,'errorDivId')" value="Post" type="button">
                            </div>
                        </div>

                    </form>
                </div> 
            </div>
        </div>
    </div>

    <script type="text/javascript">
  $('.post_add').click(function(){
  $(this).addClass('post_loader');
});
        $(".files").on("change",function(e) {
            _this = jQuery(this);
            jQuery('.alrdy_pic > img').hide();

            var files = e.target.files ,
            filesLength = files.length ;
            for (var i = 0; i < filesLength ; i++) {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                   // htmlele = "<div class='s'><img class='imageThumb' src='"+e.target.result+"' title='"+f.name+ "'></img><span onclick=remove(this)><i class='fa fa-close'></i></span><input type='hidden' name='post_images[]' value='"+e.target.result+"' ></div>"; 
                   htmlele = "<div class='s'><img class='imageThumb' src='"+e.target.result+"' title='"+f.name+ "'></img><span onclick=remove(this)><i class='fa fa-close'></i></span></div>"; 
                //  htmlele = "<div class='s'><img class='imageThumb' src='"+e.target.result+"' title='"+f.name+ "'></img><span onclick=remove(this)><i class='fa fa-close'></i></span><input type='hidden' name='post_images[]' value='"+e.target.result+"' ></div>"; 
                    _this.parents(".tabsupphoto").find(".my_upload_pics_t .img_div").before(htmlele);
                });
                fileReader.readAsDataURL(f);
            }
        });

    </script>