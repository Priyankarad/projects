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
    <script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
         <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="<?php echo base_url();?>assets/js/custom.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery.fancybox.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap.min.js"></script>


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

  </body>
</html>