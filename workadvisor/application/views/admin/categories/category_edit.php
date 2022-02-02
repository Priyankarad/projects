<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="t-header">
              <div class="th-title">
              <div class="row">
                <div class="col-md-5"></span> Edit Category
                </div>
               
              </div>
              </div>
          </div>
          <div class="t-body tb-padding">
            <div class="row">
              <form class="form-horizontal"  id="editCategoryForm" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/categoryEdit'); ?>">
                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Name</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Name" type="text" id="categoryName" value="<?php echo (!empty($categoryData[0]['name'])) ? $categoryData[0]['name'] : ''; ?>" class="form-control" name="categoryName">
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
                      <input placeholder="Category Image" type="file" id="categoryImage" value="<?php echo (!empty($categoryData[0]['category_image'])) ? $categoryData[0]['category_image'] : ''; ?>" class="form-control" name="category_image">
                      <img src="<?php echo isset($categoryData[0]['category_image_thumb'])?base_url().$categoryData[0]['category_image_thumb']:'';?>" height="20%" width="20%">
                    </div>
                  </div>
                </div>

                <input type="hidden" id="id" class="form-control" name="ids" value="<?php echo (!empty($cate_id)) ? $cate_id : ''; ?>" >

                <h3>Questions form Employee</h3>
                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Category Question 1</label>
                  </div>
                  <div class="col-sm-6">
                    <div class="title">
                      <input placeholder="Category Question 1" type="text" id="que_1" class="form-control" name="que_[]" value="<?php echo (!empty($categoryData[0]['question']) && ($categoryData[0]['user_type'] == 'Employee')) ? $categoryData[0]['question'] : ''; ?>" >
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[0]['id']) && ($categoryData[0]['user_type'] == 'Employee')) ? $categoryData[0]['id'] : ''; ?>">
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
                      <input placeholder="Category Question 2" type="text" id="que_2" class="form-control" name="que_[]" value="<?php echo (!empty($categoryData[1]['question']) && ($categoryData[1]['user_type'] == 'Employee')) ? $categoryData[1]['question'] : ''; ?>">
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[1]['id']) && ($categoryData[1]['user_type'] == 'Employee')) ? $categoryData[1]['id'] : ''; ?>">
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
                      <input placeholder="Category Question 3" type="text" id="que_3" class="form-control" name="que_[]" value="<?php echo (!empty($categoryData[2]['question']) && ($categoryData[2]['user_type'] == 'Employee')) ? $categoryData[2]['question'] : ''; ?>" >
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[2]['id']) && ($categoryData[2]['user_type'] == 'Employee')) ? $categoryData[2]['id'] : ''; ?>">
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
                      <input placeholder="Category Question 4" type="text" id="que_4" class="form-control" name="que_[]" value="<?php echo (!empty($categoryData[3]['question']) && ($categoryData[3]['user_type'] == 'Employee')) ? $categoryData[3]['question'] : ''; ?>" >
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[3]['id']) && ($categoryData[3]['user_type'] == 'Employee')) ? $categoryData[3]['id'] : ''; ?>">
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
                      <input placeholder="Category Question 5" type="text" id="que_5" class="form-control" name="que_[]" value="<?php echo (!empty($categoryData[4]['question']) && ($categoryData[4]['user_type'] == 'Employee')) ? $categoryData[4]['question'] : ''; ?>" >
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[4]['id']) && ($categoryData[4]['user_type'] == 'Employee')) ? $categoryData[4]['id'] : ''; ?>">
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
                      <input placeholder="Category Question 1" type="text" id="que_11" class="form-control" name="que_1[]" value="<?php echo (!empty($categoryData[5]['question']) && ($categoryData[5]['user_type'] == 'Employer')) ? $categoryData[5]['question'] : ''; ?>" >
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[5]['id']) && ($categoryData[5]['user_type'] == 'Employer')) ? $categoryData[5]['id'] : ''; ?>">
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
                      <input placeholder="Category Question 2" type="text" id="que_21" class="form-control" name="que_1[]" value="<?php echo (!empty($categoryData[6]['question']) && ($categoryData[6]['user_type'] == 'Employer')) ? $categoryData[6]['question'] : ''; ?>" >
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[6]['id']) && ($categoryData[6]['user_type'] == 'Employer')) ? $categoryData[6]['id'] : ''; ?>">
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
                      <input placeholder="Category Question 3" type="text" id="que_31" class="form-control" name="que_1[]" value="<?php echo (!empty($categoryData[7]['question']) && ($categoryData[7]['user_type'] == 'Employer')) ? $categoryData[7]['question'] : ''; ?>" >
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[7]['id']) && ($categoryData[7]['user_type'] == 'Employer')) ? $categoryData[7]['id'] : ''; ?>">
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
                      <input placeholder="Category Question 4" type="text" id="que_41" class="form-control" name="que_1[]" value="<?php echo (!empty($categoryData[8]['question']) && ($categoryData[8]['user_type'] == 'Employer')) ? $categoryData[8]['question'] : ''; ?>" >
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[8]['id']) && ($categoryData[8]['user_type'] == 'Employer')) ? $categoryData[8]['id'] : ''; ?>">
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
                      <input placeholder="Category Question 5" type="text" id="que_51" class="form-control" name="que_1[]" value="<?php echo (!empty($categoryData[9]['question']) && ($categoryData[9]['user_type'] == 'Employer')) ? $categoryData[9]['question'] : ''; ?>" >
                      <input type="hidden" name="id[]" value = "<?php echo (!empty($categoryData[9]['id']) && ($categoryData[9]['user_type'] == 'Employer')) ? $categoryData[9]['id'] : ''; ?>">
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
<script>
  

$(document).ready(function(){
var form_object = jQuery("#editCategoryForm");
form_object.validate({
  rules:{
        categoryName:{
            : true,
        },
        que_1:{
            : true,
        },
        que_2:{
            : true,
        },
        que_3:{
            : true,
        },
        que_4:{
            : true,
        },
        que_5:{
            : true,
        },
        
  },
    highlight: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-error');
      jQuery(element[0]).remove();
    },
    submitHandler: function() {
        $.ajax({
        type:'POST',
        url:url+"admin/categoryEdit",
        dataType:'json',
        data:$("#editCategoryForm").serialize(),
        success:function(resp){
          $('.form-error').html("");
          if(resp.type == "validation_err"){
            var errObj = resp.msg;
            var keys   = Object.keys(errObj);
            var count  = keys.length;
            for (var i = 0; i < count; i++) {
              $('.'+keys[i]).html(errObj[keys[i]]);
            };
          }else if(resp.type == "success"){
            $('#editCategoryForm')[0].reset();
            Ply.dialog("alert", resp.msg);

            setTimeout(function(){window.location.href = resp.url}, 1500);

          }else{
            Ply.dialog('alert',resp.msg);  
          }
        },
      });
    }
});
</script>
