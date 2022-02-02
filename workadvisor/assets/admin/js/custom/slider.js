
var cnt1 = $('#scount').val();
if(cnt1!=0){
  var fle_cnt = cnt1;
}else{
  var fle_cnt = 2;
}
$('#addNew').click(function() {
    fle_cnt++;
    //event.preventDefault ? event.preventDefault() : event.returnValue = false;  
    $('#bkup_doc_rw').append('<li><div>&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" accept=".png, .jpg, .jpeg, .gif" name="files[]" id="bkup_doc_proof_'+fle_cnt+'" onchange="readURL(this,'+fle_cnt+');" required/><img width="20%"  id="img'+fle_cnt+'">&nbsp;&nbsp;&nbsp;&nbsp;<a class="letter_font remNew" style="text-decoration: none;cursor: pointer;" href="#">x</a></div></li>');
    //return false;
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
    //event.preventDefault ? event.preventDefault() : event.returnValue = false;
    $(this).closest('li').remove(); 
    return false; 
});

function removeSlider(id) {
  $('#record_id').val(id);
}
function deleteData() {
  var record_id = $('#record_id').val();
  var delete_url = $('#delete_url').val();
  var table_name = $('#table_name').val();
  $.ajax({
    type:'POST',
    url:delete_url,
    data: {record:record_id,table_name:table_name},
    dataType: 'json',
    success:function(res){
      if(res.status == 1)
        $('#success').html('<div class="alert alert-success">Slider deleted successfully</div>');
      location.reload();
    },
    error:function(){
      $(".loader").css("transform", 'scale(0)'); 
      alert('An error has occurred');
    }
  }); 
}

