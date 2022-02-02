<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="t-header">
              <div class="th-title">
              <div class="row">
                <div class="col-md-5"></span> Add Category
                </div>
               
              </div>
              </div>
          </div>
          <div class="t-body tb-padding">
            <div class="row">
              <form class="form-horizontal"  id="addCategoryForm" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/categoryAdd'); ?>">
                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Name</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Name" type="text" id="categoryName" class="form-control" name="categoryName">
                      <span class="form-error text-danger categoryName"><?php echo form_error('categoryName') ?></span>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Image</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Image" type="file" id="category_image" value="<?php echo (!empty($categoryData->category_image)) ? $categoryData->category_image : ''; ?>" class="form-control" name="category_image">
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
                      <input placeholder="Category Question 1" type="text" id="que_1" class="form-control" name="que_[]">
                      <span class="form-error text-danger que_1"><?php echo form_error('que_[]') ?></span>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Question 2</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 2" type="text" id="que_2" class="form-control" name="que_[]">
                      <span class="form-error text-danger que_2"><?php echo form_error('que_[]') ?></span>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Question 3</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 3" type="text" id="que_3" class="form-control" name="que_[]">
                      <span class="form-error text-danger que_3"><?php echo form_error('que_[]') ?></span>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Question 4</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 4" type="text" id="que_4" class="form-control" name="que_[]">
                      <span class="form-error text-danger que_4"><?php echo form_error('que_[]') ?></span>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Question 5</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 5" type="text" id="que_5" class="form-control" name="que_[]">
                      <span class="form-error text-danger que_5"><?php echo form_error('que_[]') ?></span>
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
                      <input placeholder="Category Question 1" type="text" id="que_11" class="form-control" name="que_1[]">
                      <span class="form-error text-danger que_1"><?php echo form_error('que_1[]') ?></span>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Question 2</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 2" type="text" id="que_21" class="form-control" name="que_1[]">
                      <span class="form-error text-danger que_2"><?php echo form_error('que_1[]') ?></span>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Question 3</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 3" type="text" id="que_31" class="form-control" name="que_1[]">
                      <span class="form-error text-danger que_3"><?php echo form_error('que_1[]') ?></span>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Question 4</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 4" type="text" id="que_41" class="form-control" name="que_1[]">
                      <span class="form-error text-danger que_4"><?php echo form_error('que_1[]') ?></span>
                    </div>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Question 5</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 5" type="text" id="que_51" class="form-control" name="que_1[]">
                      <span class="form-error text-danger que_5"><?php echo form_error('que_1[]') ?></span>
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

