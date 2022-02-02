

<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="t-header">
                        <div class="th-title">
                            <div class="row">
                                <div class="col-md-5"></span> Edit User
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="t-body tb-padding">
                        <div class="row">
                            <form class="form-horizontal"  id="editUsery" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/update_userdetails'); ?>">
                                <input type="hidden" name="user_id" value="<?php echo isset($userData->id)?$userData->id:'';?>">
                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>First Name</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="First Name" type="text" id="fname" class="form-control" name="fname" value="<?php echo isset($userData->firstname)?$userData->firstname:'';?>" required>
                                            <span class="form-error text-danger fname"><?php echo form_error('fname') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>Last Name</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="Last Name" type="text" id="lname" class="form-control" name="lname" value="<?php echo isset($userData->lastname)?$userData->lastname:'';?>" required>
                                            <span class="form-error text-danger fname"><?php echo form_error('lname') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>Email ID</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="Email" type="text" id="email" class="form-control" name="email" value="<?php echo isset($userData->email)?$userData->email:'';?>" required disabled="">
                                            <span class="form-error text-danger fname"><?php echo form_error('email') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>Contact No.</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="Contact No." type="text" id="contact" class="form-control" name="contact" value="<?php echo isset($userData->phone)?$userData->phone:'';?>">
                                            <span class="form-error text-danger fname"><?php echo form_error('contact') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>User Category</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <select class="form-control" id="category" name="category" required="">
                                                <option value="">Select Category</option>
                                                <?php if(!empty($categoryData['result'])){ 
                                                    foreach($categoryData['result'] as $row){
                                                        $selected='';
                                                        if($row->id == $userData->user_category){
                                                            $selected = 'selected = selected';
                                                        }
                                                     ?>
                                                        <option value="<?php echo $row->id;?>" <?php echo $selected;?>><?php echo $row->name;?></option>
                                                <?php } 
                                            }?>
                                            </select>
                                            <span class="form-error text-danger fname"><?php echo form_error('category') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>City</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="City" type="text" id="city" class="form-control" name="city" value="<?php echo isset($userData->city)?$userData->city:'';?>" required>
                                            <span class="form-error text-danger fname"><?php echo form_error('city') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>State</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="State" type="text" id="state" class="form-control" name="state" value="<?php echo isset($userData->state)?$userData->state:'';?>" required>
                                            <span class="form-error text-danger fname"><?php echo form_error('state') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>Country</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="Country" type="text" id="country" class="form-control" name="country" value="<?php echo isset($userData->country)?$userData->country:'';?>" required>
                                            <span class="form-error text-danger fname"><?php echo form_error('country') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>Website Link</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="Website Link" type="text" id="link" class="form-control" name="link" value="<?php echo isset($userData->website_link)?$userData->website_link:'';?>">
                                            <span class="form-error text-danger fname"><?php echo form_error('link') ?></span>
                                        </div>
                                    </div>
                                </div>


                                <div id="bootstrapTagsInputForm" class="form-horizontal form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>Professional Skills</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="Professional Skills" type="text" id="prof_skills" class="form-control " data-role="tagsinput" name="prof_skills" value="<?php echo isset($userData->professional_skill)?$userData->professional_skill:'';?>">
                                            <div class="ddaa">
                               <i class="fa fa-plus"></i>
                             </div>

                             <div class="bootstrap-tagsinput1">
                                                             </div>
                                            <span class="form-error text-danger fname"><?php echo form_error('prof_skills') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-3">
                                        <label>Additional Services</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="title">
                                            <input placeholder="Additional Services" type="text" data-role="tagsinput" id="add_services" class="form-control" name="add_services" value="<?php echo isset($userData->additional_services)?$userData->additional_services:'';?>">
                                            <span class="form-error text-danger fname"><?php echo form_error('add_services') ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
