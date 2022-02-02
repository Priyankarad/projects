<section class="form_strat">
    <div class="container">
        <form method="post" id="create_category" action="<?php echo site_url('user/insert_userdata');?>">
            <input type="hidden" id="base_url" value="<?php echo base_url();?>">
            <div class="row">
                <div class="col-md-8 offset-2">
                    <div class="perfgormer">
                        <?php echo $this->session->flashdata('updatemsg'); ?>
                        <div class="main_win">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="as_radio mod1Hv">
                                        <input type="radio" checked="checked" name="optradio" value="Performer" class="optradio" id="optradio" onclick="userRole('Performer')"> Personal/Individual 
                                        <span class="click_Qt"><i class="fa fa-question-circle" aria-hidden="true"></i></span>
                                        <!-- <span class="checkmark but_chn"></span> -->
                                        <p class="fixget">Earn stars and reviews from customers, colleaugues or employers.
                                             Leave ratings for employees and colleagues.
                                        <!-- get instant positive recognition
                                        for your job performance --></p>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <label class="as_radio mod2Hv">
                                        <input type="radio" name="optradio" value="Employer" id="optradio" class="optradio"  onclick="userRole('Employer')">
                                        <input type="hidden" value="<?php if(isset($email)) { echo $email; } ?>" name="user_email"> Business sign in
                                        <span class="click_Qt"><i class="fa fa-question-circle" aria-hidden="true"></i>
                                            
                                        </span>
                                        <p class="fixget">Review your employees based on performance,
connect with potential employees,
track employee ratings.</p>
                                        <!-- <span class="checkmark but_chn"></span> -->
                                    </label>
                                </div>

                            </div>
                            <?php if(empty($category_details->user_id)){ ?>
                                <!-- <div class="sel_mParen3">
                                    <div class="form-group">
                                        <label class="lav_tetx">Select profession or category</label>
                                        <select class="form-control" name="user_category" id="user_category" required>
                                            <option value="">Select category</option>
                                            <?php if(!empty($categories['result'])){ foreach($categories['result'] as $category){ ?>
                                                <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                                            <?php } }?>

                                        </select>
                                    </div>
                                </div> -->
                                <!-- <hr> -->

                                <!-- <button type="button" class="not_btn" data-toggle="modal" data-target="#myModal">Create New Category</button> -->
                            </div>
                        <?php } ?>

                            <div class="main_inpus">
                            <!-- <button class="bt_scd" name="save" onclick="checkQuestionsAvailabitity();" type="button">
                                save
                            </button> -->
                            <button class="bt_scd" name="save" type="submit">
                                save
                            </button>
                            </div>

                        
                    </form>
                </div>
            </section>

            <!-- The Modal -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog chang_popup">
                    <div class="modal-content">
                        <!--       <div class="modal-header"> -->
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <!--   </div> -->
                            <!-- Modal Header -->
                            <form method="post" id="category_add" action="<?php echo site_url('user/categoryAdd');?>">
                                <p class="lav_tetx">Enter Category name & questions here (Total Five)</p>
                                <div class="form-group">
                                    <input type="text" name="categoryName" class="form-control" placeholder="Enter Your Category" required>
                                </div>
                                <input type="hidden" id="userRoles" name="userRoles" value="Performer">
                                <div class="form-group">
                                    <div class="input_texthere chnbx">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control active" placeholder="Type question here" required>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php if(isset($email)) { echo $email; } ?>" name="user_email">
                                <div class="form-group">
                                    <div class="input_texthere ch1dv">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control" placeholder="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input_texthere ch1dv">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control" placeholder="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input_texthere ch1dv">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input_texthere ch1dv">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control" placeholder="" required>
                                    </div>
                                </div>

                                <input type="submit" value="Submit" id="submit_category">

                            </form>

                            <!-- Modal footer -->



                        </div>

                    </div>
                </div>

                   <!-- The Modal -->
            <div class="modal fade" id="myQuesModal">
                <div class="modal-dialog chang_popup">
                    <div class="modal-content">
                        <!--       <div class="modal-header"> -->
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <!--   </div> -->
                            <!-- Modal Header -->
                            <form method="post" id="category_questions" action="<?php echo site_url('user/categoryAddMoreQue');?>">
                                <input type="hidden" name="cate_id" id="cate_id">
                                <input type="hidden" name="user_role" id="user_role">
                                <input type="hidden" id="userRole" name="userRole" value="Performer">
                                <p class="lav_tetx">Enter Category questions here (Total Five)</p>
                                <div class="form-group">
                                    <div class="input_texthere chnbx">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control active" placeholder="Type question here" required>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php if(isset($email)) { echo $email; } ?>" name="user_email">
                                <div class="form-group">
                                    <div class="input_texthere ch1dv">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control" placeholder="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input_texthere ch1dv">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control" placeholder="" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input_texthere ch1dv">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control" placeholder="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input_texthere ch1dv">
                                        <i class="fa fa-check"></i>
                                        <input type="text" name="que_[]" class="form-control" placeholder="" required>
                                    </div>
                                </div>

                                <input type="submit" value="Submit" id="submit_category">

                            </form>

                            <!-- Modal footer -->



                        </div>

                    </div>
                </div>

            </div>
