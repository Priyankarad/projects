<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- jQuery first, then Popper.<?php echo base_url();?>assets/js, then Bootstrap JS -->
    <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/wow.js"></script>
    <script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>  
    <script src="<?php echo base_url();?>assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/custom.js"></script>
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 <?php if($this->session->userdata('loggedIn')){ ?>
 <script>
setInterval(function(){ checkNotification(); }, 3000);
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
  $("#mycheckbox1").click(function(){
    $("#mycontact").toggle();
});
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

</script>
  </body>
</html>