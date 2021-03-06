<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="t-header">
              <div class="th-title">
              <div class="row">
                <div class="col-md-5"></span> Sliders
                </div>
               
              </div>
              </div>
          </div>
          <div class="t-body tb-padding">
            <div class="row">
              <input type="hidden" id="scount" value="<?php echo (isset($sliderData['result']) && $sliderData['total_count']!=0 && !empty($sliderData['result']))?$sliderData['total_count']:0;?>">
              <form class="form-horizontal"  id="editCategoryForm" method="post" enctype="multipart/form-data" action="<?php echo base_url('settings/updateSlider'); ?>">
                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                      <label>Slider</label>
                  </div>
                  <div class="col-sm-9">

                    <div class="title">
                      <input type="button" id="addNew" value="+ Add more"><br/><br/>
                      <ul id="bkup_doc_rw">
                        <?php if(!empty($sliderData['result'])){
                          $sscount = 0;
                          foreach($sliderData['result'] as $row){ 
                            $sscount++; ?>
                            <li>
                              <!-- <?php if($sscount == 1){?>
                                <td align="right"><label class="letter_font" for="bkup_doc_proof">Document &nbsp;&nbsp;&nbsp;&nbsp;:</label></td>
                              <?php } ?> -->
                              <div><img id="img<?php echo $sscount;?>" src="<?php echo base_url().$row->path;?>" width="20%" >
                                 <a onclick="removeSlider(<?php echo $row->id;?>);" data-target="#modalDelete" data-toggle="modal" class="letter_font remNew" style="text-decoration: none;cursor: pointer;" href="#"> x </a>
                              </div>
                            </li>
                          <?php }
                        }else{ ?>
                          <li id="">
                            <!-- <td align="right"><label class="letter_font" for="bkup_doc_proof">Document &nbsp;&nbsp;&nbsp;&nbsp;:</label></td> -->
                            <div><input type="file" onchange="readURL(this,1);" accept=".png, .jpg, .jpeg, .gif" name="files[]" id="bkup_doc_proof" required/><img id="img1" width="20%" >
                            </div>
                          </li> 
                        <?php } ?>
                      </ul>
                      <input type="submit" name="Save">   
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
      <div id="modalDelete" class="modal fade">
        <div class="modal-dialog modal-confirm">
          <div class="modal-content">
            <div id="success"></div>
            <div class="modal-header">        
              <h4 class="modal-title">Are you sure?</h4>  
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
              <p>Do you really want to delete this record ?</p>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="record_id">
              <input type="hidden" id="table_name" value="<?php echo SLIDERS;?>">
              <input type="hidden" id="delete_url" value="<?php echo base_url()?>profile/deleteData">
              <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger" onclick="deleteData()">Delete</button>
            </div>
          </div>
        </div>
      </div>  
</section>
<script type="text/javascript" src="<?php echo base_url()?>assets/admin/js/custom/slider.js"></script>
<!-- <script type="text/javascript">
var cnt1 = $('#scount').val();
if(cnt1!=0){
  var fle_cnt = cnt1;
}else{
  var fle_cnt = 2;
}
$('#addNew').click(function() {
    fle_cnt++;
    event.preventDefault ? event.preventDefault() : event.returnValue = false;  
    $('#bkup_doc_rw').append('<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" accept=".png, .jpg, .jpeg, .gif" name="files[]" id="bkup_doc_proof_'+fle_cnt+'" onchange="readURL(this,'+fle_cnt+');"/><img width="20%"  id="img'+fle_cnt+'">&nbsp;&nbsp;&nbsp;&nbsp;<a class="letter_font remNew" style="text-decoration: none;cursor: pointer;" href="#">Remove</a></td></tr>');
    return false;
});
function readURL(input,cnt) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#img'+cnt)
      .attr('src', e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}
$(document).on('click', '.remNew', function() {
    event.preventDefault ? event.preventDefault() : event.returnValue = false;
    $(this).closest('tr').remove(); 
    return false; 
});

function removeSlider(id) {
  $('#record_id').val(id);
}
function deleteData() {
  var record_id = $('#record_id').val();
  var delete_url = $('#delete_url').val();
  var table_name = '<?php echo base_url()?>';
  $.ajax({
    type:'POST',
    url:delete_url,
    data: {record:record,table_name:table_name},
    dataType: 'json',
    success:function(res){
      if(res.status == 1)
        $('#success').html('<div class="alert alert-success">Record deleted successfully</div>');
      location.reload();
    },
    error:function(){
      $(".loader").css("transform", 'scale(0)'); 
      alert('An error has occurred');
    }
  }); 
}

</script> -->