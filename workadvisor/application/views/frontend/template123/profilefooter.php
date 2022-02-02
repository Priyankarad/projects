<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- jQuery first, then Popper.<?php echo base_url();?>assets/js, then Bootstrap JS -->
<script src="<?php echo base_url();?>assets/js/jquery-3.2.1.slim.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>assets/js/dropzone.js"></script>
<script src="<?php echo base_url();?>assets/js/wow.js"></script>
<script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>  
<script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo base_url();?>assets/js/simple-lightbox.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="<?php echo base_url();?>assets/js/custom.js"></script>

<script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>

<!-- <script src="<?php echo base_url();?>assets/js/jquery.fancybox.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJOMIKWJalIMrYmvfEm-gvEptfSV-ezb8&libraries=places&callback=initAutocomplete&sensor=false"
        async defer></script>
<div class="modal fade" id="basic_information" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Basic Information</h4>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <form method="post" action="<?php echo site_url(); ?>Profile/saveProfileData" class="userprofile-form">
          <!--row start-->
          <div class="row">
            <div class="col-md-6 col-12">
              <div class="slesh"></div>
              <div class="form-group">
                <label class="ener-name">Name</label>
                <input name="firstname" class="form-control chinput dulinput ag1" placeholder="first name" type="text" value="<?php if(!empty($user_data->firstname)) { echo $user_data->firstname; } ?>" required>
                <input name="lastname" class="form-control chinput dulinput ag2" placeholder="last name" type="text" value="<?php if(!empty($user_data->lastname)) { echo $user_data->lastname; } ?>" required>
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
                <label class="ener-name">City</label>
                <input type="text" name="city" class="form-control chinput" placeholder="Your City" value="<?php if(!empty($user_data->city)) { echo $user_data->city; } ?>" required>
              </div>
            </div>

            <div class="col-md-6 col-12">
              <div class="form-group">
                <label class="ener-name">State</label>
                <input type="text" name="state"  class="form-control chinput" placeholder="Your State" value="<?php if(!empty($user_data->state)) { echo $user_data->state; } ?>" required>
              </div>
            </div>
          </div>
          <!--row close-->
          <div class="row">
            <div class="col-md-6 col-12">
              <div class="form-group">
                <label class="ener-name">Zip</label>
                <input type="text" name="zip" class="form-control chinput" placeholder="Your zipcode" value="<?php if(!empty($user_data->  zip)) { echo $user_data-> zip; } ?>" required>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="form-group">
                <label class="ener-name">Phone 
                  <?php 
                  $checked = '';
                  if(!empty($user_data->display_phone)) {
                    $checked ='checked=checked';
                  }
                  ?>
                  <input type="checkbox" id="mycheckbox12" name="display_phone" <?php echo $checked;?>>
                  <small> click to display </small>
                </label>
                <input type="text" name="phone" id="mycontact" class="form-control chinput" placeholder="Contact" value="<?php if(!empty($user_data->phone)) { echo $user_data->phone; } ?>" required>
              </div>
            </div>
          </div>
          <!--row close-->

          <div class="row">
            <div class="col-md-6 col-12">
              <div class="form-group">
                <label class="ener-name">Country</label>
                <input type="text" name="country"  class="form-control chinput" placeholder="Your Country" value="<?php if(!empty($user_data->country)) { echo $user_data->country; } ?>" required>
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
                  <input type="text" name="current_position" id="current_position" class="form-control chinput" placeholder="Current Position" value="<?php if(!empty($user_data->current_position)) { echo $user_data->current_position; } ?>">
                </div>
              </div>
            </div>

            <!--row close-->
            <div class="enter_name">
                <button type="submit" class="find extra">
                  Save
                </button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
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
  <?php if($this->session->userdata('loggedIn')){ ?>
    <script>
      setInterval(function(){ checkNotification(); }, 15000);
    </script>
  <?php } ?>

  <script type="text/javascript">
    jQuery(document).ready(function ($) {
      $.fn.progress = function() {
        var percent = this.data("percent");
        this.css("width", percent+"%");
      };
    }( jQuery ));
  </script>
  <script>
    $(document).ready(function(){
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

  </script>

<script>
  jQuery(document).ready(function(){
    jQuery('.click_Dts7').click(function(){
      jQuery(this).parents('.poromote_fx').find('.click_Dts7Shows').toggle('slow');
      jQuery('.threeShows').toggle();
    })
    
    jQuery('#headingOne').click(function(){
      
    })
    
  })

  $('.ranking').hover(function(){
    $('#ranking_mdl').modal({
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
      getGeo();
    }
  });
  function getGeo(e) {
  var zipnew = document.getElementByClassName('zip').value;
  var base_url = $('#base_url').val();
  $.ajax({
      type: "POST",
      dataType: "json",
      url: base_url+'user/getZipLocation',
      data: {zip:zipnew},
      success: function (data) {
        if(data.city)
          $('.city').val(data.city);
        if(data.state)
          $('.state').val(data.state);
        if(data.country){
          $('.country').val(data.country);
        }
      }
   });
} 
</script>
</body>
</html>