<!--========Footer Section Start=============-->
<footer class="footer_section pd_all aos-init aos-animate" data-aos="zoom-in-up" data-aos-duration="1200">
	<div class="container contain_new">
		<div class="row">
			<div class="col-md-4 col-sm-8 col-12">
				<div class="log-brand">
					<img src="<?php echo BASEURL; ?>assets/web/images/logo.png" class="img-fluid" alt="images">
					<p>Offering full consulting for EMC product testing. Know and understand your test setups. understand your equipment better. Understand what equipment you need, benefits vs. cost. </p>
				</div>

				
			</div>

			<div class="col-md-3 col-sm-4 col-12">

				<div class="my_account">
				<h3>Service portal</h3>
				<ul class="nav_footer">
					<li><a href="<?php echo site_url('rmatickets'); ?>">Create RMA / Ticket</a></li>
					<li><a href="<?php echo site_url('contact'); ?>">Ask for help</a></li>
					<li><a href="<?php echo site_url('services'); ?>">Repair/calibration</a></li>
				</ul>
			</div>
			</div>

		<div class="col-md-5 col-sm-12 col-12">
				<div class="addresses_list">
				<h3>Store Information</h3>

				<ul class="nav_footer">
					<li><i class="fa fa-map-marker" aria-hidden="true"></i>	Washington D.C. Metro Area Centreville, VA</li>

					<li><i class="fa fa-phone" aria-hidden="true"></i> Phone: +1 (703) 774-7505</li>

					<li><i class="fa fa-envelope" aria-hidden="true"></i> Email: info@absolute-emc.com</li>
				</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
<!--========Footer Section End=============-->

<!--========EMC Section End=============-->
<section class="get_footer">
	<div class="container contain_new">
		<div class="row">
			<div class="col-md-9 col-xl-10 col-lg-10 col-sm-7 col-7">
				<p class="copy_r">© absolute EMC</p>
			</div>

			<div class="col-md-3 col-xl-2 col-lg-2 col-sm-6 col-5">
				<ul class="nav social_set">
					<li><a href="https://www.facebook.com/AbsoluteEMCLLc/" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<li><a href="https://www.linkedin.com/company/absolute-emc/" target="_blank""><i class="fa fa-linkedin"></i></a></li>
					<li><a href="https://twitter.com/llc_emc" target="_blank"><i class="fa fa-twitter"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
<!--========EMC Section End=============-->
<!--========EMC GET QUOTE=============-->
<!-- Modal -->
<div id="getQuote" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	    <h4 class="modal-title">GET QUOTE</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body" id="getQuoteForm">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!--========EMC GET QUOTE End=============-->
<style>
#loading {
   width: 100%;
   height: 100%;
   top: 0;
   left: 0;
   position: fixed;
   display: block;
   opacity: 0.7;
   background-color: #fff;
   z-index: 99;
   text-align: center;
   display: none;
}

#loading-image {
position: absolute;
   top: 300px;
   /* left: 440px; */
   margin-left:auto;
   margin-right:auto;
   z-index: 100;
   width: 59px;
}

</style>
<div id="loading">
  <img id="loading-image" src="<?php echo BASEURL ?>/assets/img/loader.gif" alt="Loading..." />
</div>

<!--========EMC GET QUOTE End=============-->

<script src="<?php echo BASEURL; ?>assets/web/js/jquery-3.2.1.slim.min.js"></script>
<script src="<?php echo BASEURL; ?>assets/web/js/popper.min.js"></script>
<script src="<?php echo BASEURL; ?>assets/web/js/bootstrap.min.js"></script>
<script src="<?php echo BASEURL; ?>assets/web/js/aos.js"></script>
<script type='text/javascript' src='<?php echo BASEURL; ?>assets/web/js/smoothscroll.js'></script>
<script type='text/javascript' src='<?php echo BASEURL; ?>assets/web/js/owl.carousel.min.js'></script>
<script src="<?php echo BASEURL; ?>assets/web/js/custom.js"></script>
<script src="<?php echo BASEURL; ?>assets/js/sr.js"></script>
<script type="text/javascript">
	/*============aos==========*/
AOS.init({
    easing: 'ease-in-out-sine'
});

</script>
<!-- <script type='text/javascript' src='<?php echo BASEURL; ?>assets/web/js/parallax.js'></script> -->
<script type="text/javascript">
	$('#ProRelted').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    },  navText: ["<i class='fa fa-chevron-circle-left' aria-hidden='true'></i>","<i class='fa fa-chevron-circle-right' aria-hidden='true'></i>"]
})
</script>
    <script type="text/javascript">
    setInterval(function(){ $('.owl-next').click(); }, 5000);

 
        $('#pslider').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})



 $('#livesearch').on('keyup click', function() {
      $('.search-result').show();
    var serach=$(this).val();
    var div=$(this);
    $('.search-result').remove();
     div.after('<div class="search-result"></div>');
  $.get("<?php echo site_url('product/live_search'); ?>/"+serach, function(data){
       $('.search-result p').remove();
      $('.search-result').append(data);
  });
    
});

$('body').on('click',function(e){
 
 
      if ($(e.target).closest(".search_box").length== 0 && $(e.target).closest(".owl-next").length < 1) { 
               $('.search-result').remove();
            } 
     
})
 
    </script>

</body>

</html>
<?php 
$countcartdata=$this->cart->contents();
$countcartdata=count($countcartdata);
?>
<script>
    $('.add_cart').find('.nav-link').append(' <span data-count="<?php echo $countcartdata; ?>" class="vs-customcount">('+ <?php echo $countcartdata; ?> +')</span>');
    
</script>
<script>
 $('#ticket-form').on('submit',(function(e) {
     $('.alert-success').remove();
        e.preventDefault();
		 $('.error_msg').html('');
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
				$('.alert-success').remove();
				$("html, body").animate({ scrollTop: 0 }, "slow");
		  if(data==1){             
          	$('#ticket-form')[0].reset();
            $('.contain_new').prepend('<div class="alert alert-success"> <strong>Success!</strong> Form submitted successfully</div>');
		      
		  }
                 
            },
            error: function(data){
                
            }
        });
    }));  
    </script>