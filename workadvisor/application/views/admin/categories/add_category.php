<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="t-header">
              <div class="th-title"><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> Add Category Form</div>
          </div>
          <div class="t-body tb-padding">
            <div class="row">
              <form class="form-horizontal"  id="cat_form" method="post" action="<?php echo base_url('admin/categoryAdd'); ?>" enctype="multipart/form-data">
                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Name</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Name" type="text" id="categoryName" class="form-control" name="categoryName">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>

                 <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Image</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Name" type="file" id="category_image" class="form-control" name="category_image">
                    </div>
                  </div>
                </div>

                <h3>Questions form Employee</h3>
                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 1</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 1" type="text" id="que_1" class="form-control" name="que_1">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 2</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 2" type="text" id="que_2" class="form-control" name="que_2">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 3</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 3" type="text" id="que_3" class="form-control" name="que_3">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 4</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 4" type="text" id="que_4" class="form-control" name="que_4">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 5</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 5" type="text" id="que_5" class="form-control" name="que_5">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <h3>Questions form Employer</h3>
                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 1</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 1" type="text" id="que_11" class="form-control" name="que_11">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 2</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 2" type="text" id="que_21" class="form-control" name="que_21">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 3</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 3" type="text" id="que_31" class="form-control" name="que_31">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 4</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 4" type="text" id="que_41" class="form-control" name="que_41">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Category Question 5</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 5" type="text" id="que_51" class="form-control" name="que_51">
                      <span class="text-danger"><?php echo form_error('categoryName'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="form-group col-sm-12 text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>










