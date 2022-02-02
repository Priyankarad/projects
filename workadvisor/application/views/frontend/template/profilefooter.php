<?php

$timestamp = date('YmdHis');
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<!-- jQuery first, then Popper.<?php echo base_url();?>assets/js, then Bootstrap JS -->

<!-- <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.slim.min.js"></script> -->

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->

<script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>

<script src="<?php echo base_url();?>assets/js/dropzone.js"></script>

<script src="<?php echo base_url();?>assets/js/wow.js"></script>

<script src="<?php echo base_url();?>assets/js/popper.min.js"></script>

<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>  

<script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>



<script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>

<script src="<?php echo base_url();?>assets/js/select2.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.contextMenu.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/js/jquery.ui.position.min.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/stripe.js"></script> -->

<script src="<?php echo base_url();?>assets/js/custom.js?<?php echo $timestamp;?>"></script>

<script src="<?php echo base_url();?>assets/js/cus.js"></script>

<script src="<?php echo base_url();?>assets/js/simple-lightbox.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/1.js" async></script>



<script src="<?php echo base_url();?>assets/js/jquery.fancybox.min.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap.min.js"></script>

<script src="<?php echo base_url();?>assets/js/flatpickr.js"></script>

<script type="text/javascript">

  function uploadModal(){

    $.ajax({

      type: 'POST',

      url: "<?php echo site_url('profile/uploadModal'); ?>",

      data: {},

      dataType: "html",

      success: function(resultData) {

        $('#uploadModal').html(resultData);

        $('#uploadModal').modal('show');

        $('#filePreview').Jcrop({

          boxWidth: 300,   

// boxWidth: 650,  

onChange : updateCoords, 

aspectRatio: 1,

boxHeight: 400,  

onSelect: updateCoords,

});

      }

    });

  }



</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJOMIKWJalIMrYmvfEm-gvEptfSV-ezb8&libraries=places&callback=initAutocomplete"

async defer></script>

<div class="modal fade" id="basic_information" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title">Basic Information</h4>

        <h5>Step 1 of 2</h5>

      </div>

      <div class="modal-body">

        <div class="card-body">

          <form method="post" action="<?php echo site_url(); ?>Profile/saveProfileDataInfo" class="userprofile-form" id="profile_form_modal" enctype="multipart/form-data">

            <!--row start-->

            <div class="row">

              <div class="col-md-6 col-12">

                <div class="slesh"></div>

                <div class="form-group">

                  <label class="ener-name">Name</label>

                  <input name="firstname" class="form-control chinput dulinput ag1" placeholder="first name" type="text" value="<?php if(!empty($user_data->firstname)) { echo ucfirst($user_data->firstname); } ?>" required>

                  <input name="lastname" class="form-control chinput dulinput ag2" placeholder="last name" type="text" value="<?php if(!empty($user_data->lastname)) { echo ucfirst($user_data->lastname); } ?>" required>

                </div>

              </div>



              <div class="col-md-6 col-12">

                <div class="form-group">

                  <label class="ener-name">Email </label>

                  <input type="text" class="form-control chinput" name="Cheryl" value="<?php if(!empty($user_data->email)) { echo $user_data->email; } ?>" disabled required>

                </div>

              </div>

            </div>

            <!--row close-->

            <!--row start-->

            <div class="row">

              <div class="col-md-6 col-12">

                <div class="form-group">

                  <label class="ener-name">Zip</label>

                  <input type="text" name="zip" class="form-control chinput zip" placeholder="Your zipcode" value="<?php if(!empty($user_data->zip)) { echo $user_data->zip; } ?>" required>

                </div>

              </div>

              <div class="col-md-6 col-12">

                <div class="form-group">

                  <label class="ener-name">City</label>

                  <input type="text" name="city" class="form-control chinput city" placeholder="Your City" value="<?php if(!empty($user_data->city)) { echo $user_data->city; } ?>" required>

                </div>

              </div>



            </div>

            <!--row close-->

            <div class="row">



              <div class="col-md-6 col-12">

                <div class="form-group">

                  <label class="ener-name">State</label>

                  <input type="text" name="state"  class="form-control chinput state" placeholder="Your State" value="<?php if(!empty($user_data->state)) { echo $user_data->state; } ?>" required>

                </div>

              </div>

              <div class="col-md-6 col-12">

                <div class="form-group">

                  <label class="ener-name">Country</label>

                  <input type="text" name="country"  class="form-control chinput country" placeholder="Your Country" value="<?php if(!empty($user_data->country)) { echo $user_data->country; } ?>" required>

                </div>

              </div>



            </div>

            <!--row close-->



            <div class="row">

              <div class="col-md-6 col-12">

                <div class="form-group">

                  <label class="ener-name">Phone 

                    <?php 

                    $checked = '';

                    if(!empty($user_data->display_phone)) {

                      $checked ='checked=checked';

                    }

                    ?>

                    <input type="checkbox" id="mycheckbox12" name="display_phone" <?php echo $checked;?> >

                    <small> click to display </small>

                  </label>

                  <input type="text" name="phone" id="mycontact" class="form-control chinput" placeholder="Contact" value="<?php if(!empty($user_data->phone)) { echo $user_data->phone; } ?>" required>

                </div>

              </div>

              <div class="col-md-6 col-12">

                <div class="form-group">

                  <label class="ener-name">Website

                    <?php 

                    $checked = '';

                    if(!empty($user_data->display_website)) {

                      $checked ='checked=checked';

                    }

                    ?>

                    <input type="checkbox" id="mycheckbox12" name="display_website" <?php echo $checked;?>>

                    <small> click to display </small></label>

                    <input type="text" name="website_link" class="form-control chinput" placeholder="Website link" value="<?php if(!empty($user_data->website_link)) { echo $user_data->website_link; } ?>">

                  </div>

                </div>

              </div>

              <div class="row">

                <div class="col-md-6 col-12">

                  <div class="form-group">

                    <label class="ener-name">Current Position</label>

                    <input type="text" name="current_position" id="current_position" class="form-control chinput" placeholder="Current Position" value="<?php if(!empty($user_data->current_position)) { echo $user_data->current_position; } ?>" required>

                  </div>

                </div>

                <div class="col-md-6 col-12">

                  <div class="form-group">

                    <label class="ener-name">Select category</label>

                    <select class="form-control chinput" name="user_category" required>

                      <!--  <option value="<?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?>" style="color: #fff;"><?php if(!empty($user_data->user_category)) { echo $user_data->user_category; } ?></option> -->

                      <option value="">Select Category</option>

                      <?php if(!empty($category_details['result'])){

                        foreach($category_details['result'] as $categories){ ?>

                          <?php

                          $cateStatus = ($categories->id == $user_data->user_category) ? "selected": ""; 

                          ?>

                          <option value="<?php echo $categories->id; ?>" <?php echo $cateStatus; ?> ><?php echo $categories->name; ?></option>



                        <?php } } ?>



                      </select>

                    </div>

                  </div>  

                </div>

                <?php if($user_data->profile == '' || $user_data->profile=='assets/images/default_image.jpg' ) { ?>

                  <div class="row">

                    <div class="col-md-6 col-12">

                      <div class="form-group">

                        <label class="ener-name">Profile Image</label>

                        <input type="file" name="profileimg" id="profileimg" class="form-control chinput" required>

                      </div>

                    </div> 

                    <div class="col-md-6 col-12 hide" id="img_div">

                      <img src="" id="profile_img_" height="100%" width="50%">

                    </div> 

                  </div>

                <?php } ?>

                <!--row close-->

                <div class="enter_name">

                  <button type="submit" class="find extra">

                    Next

                  </button>

                </div>

              </form>

            </div>

          </div>

        </div>

      </div>

    </div>



    <div class="modal fade" id="skills" data-backdrop="static" data-keyboard="false" >

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <h4 class="modal-title">Skills</h4>

            <h5>Step 2 of 2</h5>

          </div>



          <div class="modal-body">

            <div class="card-body">

              <form  class="userprofile-form" method="post" action="<?php echo base_url()?>profile/saveProfileData">       

                <!--second card start-->

                <div class="card">

                  <div class="card-header">

                    <h5 class="mb-0">

                      <div>

                        <h1 class="Basic-grn"><i class="fa fa-asterisk" aria-hidden="true"></i> Professional Skills (Enter all tags that apply to your profession for better search results)<span class="professional_qmark"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>

                      </div>

                    </h5>

                  </div>       

                  <div class="row">

                    <div class="col-md-12 col-12">

                      <!--new contant aad-->

                      <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">

                        <div class="form-group">

                          <!-- <label class="ener-name">Professional skills</label> -->

                          <input type="text" name="newprofessional_skills" class="form-control chinput"

                          value="" data-role="tagsinput" placeholder="eg - Cook , Artist , ....">

                          <div class="ddaa extrsposin"><i class="fa fa-plus"></i></div>

                          <div class="bootstrap-tagsinput1">

                            <?php if(!empty($user_data->professional_skill)) {  

                              $skills = explode(",",$user_data->professional_skill); 

                              foreach ($skills as $skill) {

                                ?>               

                                <span class="tag label label-info"><?php echo $skill; ?>

                                <input type="hidden" name="oldprofessional_skill[]" value="<?php echo $skill; ?>">

                                <span data-role="remove" class="removetag"></span></span>               

                              <?php  } } ?>

                            </div>

                          </div>

                        </div>

                        <!--new contant close-->

                      </div>

                    </div>

                  </div>

                  <!--second card start-->



                  <!--third card start-->

                  <div class="card">

                    <div class="card-header">

                      <h5 class="mb-0">

                        <div>

                          <h1 class="Basic-grn"><i class="fa fa-asterisk" aria-hidden="true"></i> Additional Services <span class="additional_qmark"><i class="fa fa-question-circle" aria-hidden="true"></i></span></h1>

                        </div>

                      </h5>

                    </div>



                    <div class="row">

                      <div class="col-md-12 col-12">

                        <div id="bootstrapTagsInputForm" method="post" class="form-horizontal">

                          <div class="form-group">

                            <!-- <label class="ener-name">Additional Services</label> -->

                            <input type="text" name="newadditional_servicess" class="form-control"

                            value="" data-role="tagsinput" placeholder="eg - Delivery , Pickup , ....">

                            <div class="ddaa extrsposin"><i class="fa fa-plus"></i></div>

                            <div class="bootstrap-tagsinput1">

                              <?php if(!empty($user_data->additional_services)) {  

                                $services = explode(",",$user_data->additional_services); 

                                foreach ($services as $service) {

                                  ?>

                                  <span class="tag label label-info"><?php echo $service; ?>

                                  <input type="hidden" name="oldadditional_services[]" value="<?php echo $service; ?>">

                                  <span data-role="remove" class="removetag"></span></span>

                                <?php  } } ?>

                              </div>

                            </div>

                          </div>

                        </div>

                      </div>

                    </div>         

                    <!--third card close-->

                    <!--second close-->

                    <div class="enter_name">

                      <button type="submit" class="find extra">

                        Submit

                      </button>

                    </div>

                  </form>

                </div>

              </div>

            </div>

          </div>

        </div>





        <!--==========loader------------===========-->

        <div class="folder_loader">

          <img src="https://www.workadvisor.co/assets/images/giphy.gif">

        </div>

        <!--==========loader------------===========-->









        <div class="modal fade" id="ranking_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">Ranking</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="emp_popups">

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>See where you rank amongst others in your category.</p>



                </div>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>

        <div class="modal fade" id="albums_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">Albums</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="emp_popups">

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>Photos posted in highlights will go to album associated with job or industry.</p>



                </div>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>





        <div class="modal fade" id="businessalbums_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">Albums</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="emp_popups">

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>Photos posted in highlights will appear in album.</p>



                </div>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>







        <div class="modal fade" id="doc_mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">Documents-Files</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="emp_popups">

                  <p>Upload and store work documents.</p>

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>Option for public to view and download from your profile.</p>

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>Keep private and store work related documents for personal view only.</p>



                </div>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>





        <div class="modal fade" id="doc_mdls" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">Documents-Files</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="emp_popups">

                  <p>Upload and store work documents.</p>

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>Option for public to view and download from your profile.</p>

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>Keep private and store work related documents for personal view only.</p>

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>Upload example (work schedules, excel sheets etc.) for employee view only.</p>

                </div>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>



        <div class="modal fade" id="history_" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">Work History</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="emp_popups">

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>Performers reviews from category/industry or recent job.</p>



                </div>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>





        <div class="modal fade" id="professionalSpop" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">Professional Skills</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="emp_popups">

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i> Enter tags or key words that apply to you separated with comma for better search results of your profile.</p>



                </div>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>

        <!-- Modal -->



        <div class="modal fade" id="additionalSpop" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">Additional Services</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="emp_popups">

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i> Enter any additional key words or tags separated with a comma for better search results of your profile.</p>



                </div>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>

        <!-- Modal -->





        <div class="modal fade" id="qrCodeQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">QR Code</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <div class="emp_popups">

                  <p><i class="fa fa-asterisk" aria-hidden="true"></i>Print QR Code for promotional goods, flyers and business cards to direct traffic to your profile and boost your reviews.</p>



                </div>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

              </div>

            </div>

          </div>

        </div>







        <!--================ ADD TASK ==============-->

        <div class="modal fade" id="addtasks" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title taskEdit" id="exampleModalCenterTitle">Task Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="<?php echo site_url('user/addTasks');?>" method="post" id="taskForm">
                  <input type="hidden" name="task_id" id="task_id">
                  <div class="form-group">
                    <input type="text" name="title" id="title" placeholder="Title" class="form-control" required=""/>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" rows="3" placeholder="Description" name="description" id="description"></textarea>
                  </div>
                  <div class="form-group">
                    <label><b>Assign Task</b></label>
                    <select class="form-control contacts" name="task_members[]" id="task_members" multiple="multiple" required="">
                      <?php 
                      if(!empty($performersList)){
                        foreach($performersList as $performer){ ?>
                          <option value="<?php echo $performer['id'];?>"><?php echo ucwords($performer['firstname'].' '.$performer['lastname']); ?></option>
                        <?php }
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="form-control" id="start_dates" data-input placeholder="Start Date" name="start_date" required="" readonly="" />
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form-control" id="end_dates" name="end_date" data-input placeholder="End Date" required="" readonly="" />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-info taskAddBtn">Add Task</button>
                    <button type="button" class="btn btn-danger delete_task" class="editss" data-toggle="modal" data-target="#modalDelete">Delete</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!--================ ADD TASK ==============-->





        <!--================ ADD TASK FILL POPUP ==============-->

        <div class="modal fade" id="addtasksfill" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

          <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

              <div class="modal-header">
                <h4>Task Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                  <span aria-hidden="true">&times;</span>

                </button>

              </div>

              <div class="modal-body">

                <form action="<?php echo site_url('user/updateTaskStatus');?>" method="post">
                  <input type="hidden" name="taskId" id="taskId">
                  <div class="form-group">
                    <label>Task Name</label>
                    <input type="text" id="task_title" class="form-control" readonly="" />

                  </div>

                  <div class="form-group">
                    <label>Task Description</label>
                    <textarea class="form-control" rows="3" placeholder="Description" readonly="" id="task_description"></textarea>

                  </div>

                  <div class="form-group">
                    <label>Note</label>
                    <textarea class="form-control" rows="3" placeholder="Enter Note" name="note" id="note"></textarea>
                  </div>
                  
                  <div class="form-group">

                    <div class="row">

                      <div class="col-md-6">
                        <label>Start Date</label>
                        <input type="text" class=" form-control" id="task_start"  data-input placeholder="Start Date" readonly="" />

                      </div>

                      <div class="col-md-6">
                        <label>End Date</label>
                        <input type="text" class=" form-control" id="task_end" data-input placeholder="End Date" readonly="" />

                      </div>

                    </div>

                  </div>
                  
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="status">
                      <option value="0">Pending</option>
                      <option value="1">Process</option>
                      <option value="2">Completed</option>
                      <option value="3">Incomplete</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-success saveStatus">Save</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!--================ ADD TASK FILL POPUP ==============-->









        <footer class="main_footer">

          <div class="container wow fadeInleft animate">

            <div class="main_category">

              <div class="row">

                <div class="col-md-5">

                  <div id="newsletter_status"></div>

                  <h2 class="ftSbsI">Subscribe For The Latest Info</h2>

                  <div class="newsletter_im">

                    <form class="form-inline" id="newsletter" action="<?php echo base_url();?>user/newsletter" method="post">

                      <input type="email" name="semail" id="semail" placeholder="Stay updated with WorkAdvisor.co">

                      <button type="submit" class="send_wnewsL"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>

                    </form>

                  </div>

                  <img src="<?php echo base_url()?>assets/images/workadvisorfooterlogo.png" alt="images_logo" class="footerupdatelogo"/>

                </div>  

                <div class="col-md-4 col-xs-12">

                  <div class="social_links">

                    <!--<h1>Grow Awareness <br/> Increase Profits<h1>-->

                      <h1>Hard Work  Pays Off</h1>

                    </div>

                  </div>

                  <div class="col-md-3 col-xs-12">

                    <div class="social_links">

                      <h2>Links</h2>

                      <ul class="inline-listWa">

                        <li><a href="<?php echo site_url('settings/about_us');?>">About Us</a></li>

                        <li><a href="<?php echo site_url('settings/how_it_works');?>">How It Works</a></li>

                        <li><a href="<?php echo site_url('settings/faq');?>">FAQ</a></li>



                      </ul>

                      <ul class="inline-listWa">

                        <li><a href="<?php echo site_url('settings/privacy_policy');?>">Privacy Policy </a></li>

                        <li><a href="<?php echo site_url('settings/terms_of_service');?>">Terms & Conditions </a></li>

                        <li><a href="<?php echo site_url('settings/contact_us');?>">Contact </a></li>

                      </ul>

                    </div>

                  </div>

                  <p class="copy">© 2018 All rights reserved</a></p>

                </div>

              </div>

            </div>

          </footer>



          <?php if($this->session->userdata('loggedIn')){ ?>

            <script>

// setInterval(function(){ checkNotification(); }, 15000);

</script>

<?php } ?>



<script type="text/javascript">

  $(document).ready(function(){

    $("#newsletter").submit(function(event) {

      event.preventDefault();

      $.ajax({

        type:'POST',

        url:'<?php echo base_url(); ?>user/newsletter',

        data: $(this).serialize(),

        dataType: 'json',

        success:function(res){

          $('#semail').val('');

          $('#newsletter_status').html(res.message);

        }

      });

    });

  });

  jQuery(document).ready(function ($) {

    $.fn.progress = function() {

      var percent = this.data("percent");

      this.css("width", percent+"%");

    };

  }( jQuery ));

</script>

<script>

  $(document).ready(function(){

    $('#img_div').hide();

    $('#profileimg').change(function(){

      $('#img_div').show();

      if (this.files && this.files[0]) {

        var reader = new FileReader();

        reader.onload = imageIsLoaded;

        reader.readAsDataURL(this.files[0]);

      }

    });



    $('.mycheckbox1').change(function(){

      if($('.mycheckbox1').checked)

        $('#mycontact').fadeIn('slow');

      else

        $('#mycontact').fadeOut('slow');

    });

  });



  $('.video_upload_label').click(function(){

    $('.video_upload').show();

    $('.my_upload_pics_t').hide();

  });

  $('.img_upload_label').click(function(){

    $('.video_upload').hide();

    $('.my_upload_pics_t').show();

  });





  /************/

  var vids = $("video"); 

  $.each(vids, function(){

    this.controls = false; 

  }); 



  $("video").click(function() {

//console.log(this); 

if (this.paused) {

  this.play();

} else {

  this.pause();

}

});

  /***************/

  $('#submit-all').click(function(){

    var contents=$('#post_content3').val();

    var myKeyVals = {post_content : contents}

    $.ajax({

      type: 'POST',

      url: "<?php echo site_url('user/wallpost3'); ?>",

      data: myKeyVals,

      dataType: "json",

      success: function(resultData) {

        if(resultData.results==1){

//  alert(resultData.msg);

window.location.href = window.location.href;

}else{

  window.location.href = window.location.href;

//alert(resultData.msg);  

}



}

});

  });

  function imageIsLoaded(e) {

    $('#profile_img_').attr('src', e.target.result);

  };

</script>



<script>

  $(document).ready(function(){

// $('.click_Dts7').click(function(){

//   alert('d');

//   $(this).parents('.poromote_fx').find('.click_Dts7Shows').toggle('slow');

//   $('.threeShows').toggle();

// })



$('#headingOne').click(function(){



})



})



  $('.ranking').hover(function(){

    $('#ranking_mdl').modal({

      show: true,

      backdrop: false

    });

  });



  $('.albums_profile').hover(function(){

    $('#albums_mdl').modal({

      show: true,

      backdrop: false

    });

  });



  $('.doc_file').hover(function(){

    $('#doc_mdl').modal({

      show: true,

      backdrop: false

    });

  });



  $('.qrCodeQuestion').hover(function(){

    $('#qrCodeQuestion').modal({

      show: true,

      backdrop: false

    });

  });



  $('.albums_businessprofile').hover(function(){

    $('#businessalbums_mdl').modal({

      show: true,

      backdrop: false

    });

  });

  $('.doc_files').hover(function(){

    $('#doc_mdls').modal({

      show: true,

      backdrop: false

    });

  });



  $('.history_').hover(function(){

    $('#history_').modal({

      show: true,

      backdrop: false

    });

  });

</script>



<script>

  $(function(){

    var $galleryF = $('.fansy-gallry a').simpleLightbox();



    $galleryF.on('show.simplelightbox', function(){

      console.log('Requested for showing');

    })

    .on('shown.simplelightbox', function(){

      console.log('Shown');

    })

    .on('close.simplelightbox', function(){

      console.log('Requested for closing');

    })

    .on('closed.simplelightbox', function(){

      console.log('Closed');

    })

    .on('change.simplelightbox', function(){

      console.log('Requested for change');

    })

    .on('next.simplelightbox', function(){

      console.log('Requested for next');

    })

    .on('prev.simplelightbox', function(){

      console.log('Requested for prev');

    })

    .on('nextImageLoaded.simplelightbox', function(){

      console.log('Next image loaded');

    })

    .on('prevImageLoaded.simplelightbox', function(){

      console.log('Prev image loaded');

    })

    .on('changed.simplelightbox', function(){

      console.log('Image changed');

    })

    .on('nextDone.simplelightbox', function(){

      console.log('Image changed to next');

    })

    .on('prevDone.simplelightbox', function(){

      console.log('Image changed to prev');

    })

    .on('error.simplelightbox', function(e){

      console.log('No image found, go to the next/prev');

      console.log(e);

    });

  });

  $('.zip').keyup(function() {

    var len = $.trim(this.value).match(/\d/g).length;

    if (len >= 5 && len <= 7) {

      getGeo(this.value);

    }

  });

  function getGeo(zip) {

    $('.city').val('');

    $('.state').val('');

    $('.country').val('');

    var base_url = $('#base_url').val();

    $.ajax({

      type: "POST",

      dataType: "json",

      url: base_url+'user/getZipLocation',

      data: {zip:zip},

      success: function (data) {

        if(data.city)

          $('.city').val(data.city);

        else

          $('.city').val('');

        if(data.state)

          $('.state').val(data.state);

        else

          $('.state').val('');

        if(data.country){

          $('.country').val(data.country);

        }

        else

          $('.country').val('');

      }

    });

  } 

</script>







<script type="text/javascript">

  $('.mypbusinessopen').click(function(){

    $(this).toggleClass('tringle_shaX');

    $('.proileLeftopens').toggleClass('XopenMents');

  })



  $('body').on('click', '.proileLeftopens ul a', function(){

    $('.proileLeftopens').removeClass('XopenMents');

    $('.mypbusinessopen').removeClass('tringle_shaX');

    $('html, body').animate({

      scrollTop: $("#MclickInsX").offset().top

    }, 2000);

  })





// $(window).scroll(function() {    

//     var scroll = $(window).scrollTop();

//     if (scroll >= 500) {

//         $(".mypbusinessopen").addClass("noneIconX");

//     }

// });



/********************************************/

/********************************************/

/*************AUTO-SCROLL*****************/

/********************************************/

/********************************************/

$(document).ready(function(){

  autoscrollnow('conversation');

});

function autoscrollnow(classofdiv){

  if($('.'+classofdiv).get(0)!==undefined){

    $('.'+classofdiv).animate({

      scrollTop: $('.'+classofdiv).get(0).scrollHeight}, 2000);

  }

}

function callpreviouse(){

  if($(".conversation").scrollTop()==0){

    var topid=$('#topId').val();

    var userId=$("#conversation").attr("data-id");

    getoldermessage(topid,userId);

    $("#conversation").scrollTop(1);

  } 

}



$(".conversation").scroll(function(){

  if($(".conversation").scrollTop()==0){

    console.log($(".conversation").scrollTop());

    var topid=$('#topId').val();

    var userId=$("#conversation").attr("data-id");

    getoldermessage(topid,userId)
    $("#conversation").scrollTop(1); 

  }  

});



function getoldermessage(topid,userId){

  $('.serch_profile').find(".chatuser").removeClass('activechat');  

  $.ajax({

    type:'POST',

    url:site_url+'/user/indivisualMessageOld',

    data: {userid:userId,top_id:topid},

    dataType: 'json',

    success:function(res){

      $('#topId').remove();

      $('.conversation').prepend(res.msg);

      $('#friendlistmenu'+res.userid).addClass('activechat');

      $("#latestMessageCount_"+res.userid).html('');

      $("#latestMessageCount_"+res.userid).removeClass('cuircl2');

      if(res.msg!=""){

        $('#chatBox').scrollTop(30);

      }

    },

    error:function(){

      $(".loader").css("transform", 'scale(0)'); 

      alert('An error has occurred');

    }

  });  

}



/********************************************/

/********************************************/

/*************END-AUTO-SCROLL****************/

/********************************************/

/********************************************/







$(".professional_qmark").on("mouseover",function() {

  $('#professionalSpop').modal({

    show: true,

    backdrop: false

  });

}); 

$(".additional_qmark").on("mouseover",function() {

  $('#additionalSpop').modal({

    show: true,

    backdrop: false

  });

});



// $(".professional_qmark").on("mouseover",function() {

//   alert('dfg');

// });

</script>



<script type="text/javascript">

  $('textarea#post_contentNew').on('click', function(){

$("html, body").animate({ // catch the `html, body`

scrollTop: 0 // button's offset - 10 

}, 1000); // in 1000 ms (1 second)

});

</script>





<script type="text/javascript">

  function googleTranslateElementInit() {

    new google.translate.TranslateElement({pageLanguage: 'en',includedLanguages: 'el,en,zh-TW,zh-CN,es,it,de'}, 'google_translate_element');

  }

</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/59f63dc9af87e51c961fcde29/8129a2f62a46c20df34b0c1ed.js");</script>  
<?php
$startDateArr = array();
if(!empty($startDates['result'])){
  foreach($startDates['result'] as $date){
    $startDateArr[] = $date->start_date;
  }
}

?>


<script>
  var dates = <?php echo json_encode($startDateArr);?>;
  $(function() {
    $(document).on('click','.taskopens a',function(){
      $(this).siblings('ul').toggleClass('open_task');
    });
    $('.tableData').DataTable();
    $(".simpleflatepicker").flatpickr({
      enableTime: false,
      inline:true,
      mode: "multiple",
      dateFormat: "Y-m-d",
      defaultDate: dates
    });
    $("#start_dates").datepicker({
      minDate: 0,
      dateFormat: 'yy-mm-dd',
      onSelect: function(selected) {
        $("#end_dates").datepicker("option","minDate", selected)
      },
    });
    $("#end_dates").datepicker({ 
      minDate: 0,
      dateFormat: 'yy-mm-dd',
      onSelect: function(selected) {
        $("#start_dates").datepicker("option","maxDate", selected)
      },
    }); 
    
  });

</script>
</body>
</html>