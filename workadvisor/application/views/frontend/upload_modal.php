

          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                  <h3>Upload a photo of yourself</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body imageProperSelect">
                  
                  <p>People like to know who is messaging them. Please upload a real photo of yourself (including your face) so your customers know who you are.</p>  
                  <ul>
                    <li><p>Right</p>
                      <?php if($user_role == 'Performer'){ ?>
                        <img alt="" src="<?php echo base_url();?>uploads/images/thumb/1539602086.jpg"/> 
                      <?php }else{ ?>
                          <img alt="" src="<?php echo base_url();?>assets/images/butterfly_logo.png"/> 
                      <?php }?>
                      <i class="fa fa-check" aria-hidden="true"></i> </li> 
                    <li><p>Wrong</p><img alt="" src="<?php echo base_url();?>assets/uploadimages/AD7092FE-8D8E-4C76-BC7E-B64D55842B37.jpeg"/> <i class="fa fa-times" aria-hidden="true"></i></li> 
                  </ul>
                  
               <!--  <form method="post" action="<?php echo site_url(); ?>Profile/Update_profileimg" enctype="multipart/form-data" onsubmit="return checkCoords();">
                  <p>Image: <input name="profileimg" id="cropbox" type="file" onchange="cropboxChange();" /></p>
                  <div id="filePreviewDiv">
                    <p><img id="filePreview" style="display:none;"/></p>
                  </div>
                  <input type="hidden" id="x" name="x" />
                  <input type="hidden" id="y" name="y" />
                  <input type="hidden" id="w" name="w" />
                  <input type="hidden" id="h" name="h" />
                  <input name="upload" type="submit" value="Upload" />
                </form> -->


                <form enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>Profile/Update_profileimg" onsubmit="return checkForm()">
                  <input type="hidden" id="x" name="x" />
                  <input type="hidden" id="y" name="y" />
                  <input type="hidden" id="w" name="w" />
                  <input type="hidden" id="h" name="h" />
                    <div><p>Select Image:<input type="file" name="profileimg" id="image_file" onchange="fileSelectHandler()" /></p></div>

                    <div class="error"></div>

                    <div class="step2">
                      <div id="filePreviewDiv">
                        <img id="preview" />
                      </div>
                        <input type="submit" value="Upload" id="upload"/>
                    </div>
                </form>

                <!-- Preview-->
               <!--  <div id='preview'>
                </div> -->
              </div>
            </div>
          </div>


          
<script type="text/javascript">


 $(document).ready(function () {
    $('#filePreview').Jcrop({
      aspectRatio: 1,
      boxWidth: 300,  
      boxHeight: 400,  
      onSelect: updateCoords
    });
 });
</script>
