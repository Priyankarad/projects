<!-- Footer -->
<footer id="footer">
	<div class="container">
		<section class="links">
			<div class="row">
				<section class="4u 6u(medium) 12u$(small)">
					<!--<h3>Section 1</h3>-->
					<ul class="unstyled">
						<li><a href="<?=BASE_URL.$getLang?>/p/about-us"><?php echo($transArr['About Us']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/p/how-it-works"><?php echo($transArr['How it Works']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/p/blog"><?php echo($transArr['Blog']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/p/partnership"><?php echo($transArr['Partnership']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/contact"><?php echo($transArr['Contact']); ?></a></li>
					</ul>
				</section>
				<section class="4u 6u(medium) 12u$(small)">
					<!--<h3>Section 2</h3>-->
					<ul class="unstyled">
						<li><a href="<?=BASE_URL.$getLang?>/p/privacy-policy"><?php echo($transArr['Privacy Policy']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/p/principals"><?php echo($transArr['Principals']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/p/cookies"><?php echo($transArr['Cookies']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/p/conflict-policy"><?php echo($transArr['Conflict Policy']); ?></a></li>
					</ul>
				</section>
				<section class="4u 6u(medium) 12u$(small)">
					<!--<h3>Section 3</h3>-->
					<ul class="unstyled">
						<li><a href="<?=BASE_URL.$getLang?>/p/invest"><?php echo($transArr['Invest']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/p/risk-management"><?php echo($transArr['Risk Management']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/p/who-uses"><?php echo($transArr['Who Uses']); ?></a></li>
						<li><a href="<?=BASE_URL.$getLang?>/p/faq-for-investing"><?php echo($transArr['FAQ for investing']); ?></a></li>
					</ul>
				</section>
				<!--<section class="3u 6u(medium) 12u$(small)">
					<h3>Section 4</h3>
					<ul class="unstyled">
						<li><a href="#">Link Text 1</a></li>
						<li><a href="#">Link Text 2</a></li>
						<li><a href="#">Link Text 3</a></li>
						<li><a href="#">Link Text 4</a></li>
						<li><a href="#">Link Text 5</a></li>
					</ul>
				</section>-->
			</div>
		</section>
		<div class="row">
			<div class="8u 12u$(medium)">
				<ul class="copyright">
					<li>&copy; <?php echo($transArr['Copyright']); ?> <?=date('Y')?>. <?=PROJECT_NAME?>. <?php echo($transArr['All rights reserved']); ?>.</li>
				</ul>
			</div>
			<div class="4u$ 12u$(medium)">
				<ul class="icons">
					<li>
						<a class="icon rounded fa-facebook" href="<?php echo($config['facebook_url']); ?>" target="_blank"><span class="label">Facebook</span></a>
					</li>
					<li>
						<a class="icon rounded fa-twitter" href="<?php echo($config['twitter_url']); ?>" target="_blank"><span class="label">Twitter</span></a>
					</li>
					<li>
						<a class="icon rounded fa-google-plus" href="<?php echo($config['googleplus_url']); ?>" target="_blank"><span class="label">Google+</span></a>
					</li>
					<li>
						<a class="icon rounded fa-linkedin" href="<?php echo($config['linkedin_url']); ?>" target="_blank"><span class="label">LinkedIn</span></a>
					</li>
					<li>
						<select name="langchange" id="langchange">
							<?php

							$getLangData = "SELECT * FROM ".TABLE_PREFIX."languages WHERE flag = '1'";
							$getLangData = mysqli_query($con,$getLangData) or die(mysql_error());
							$numdata = mysqli_num_rows($getLangData);
							
							$currentURL = HTTP_HOST.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
							
							if($numdata){
								
								while($rowdata = mysqli_fetch_assoc($getLangData)){
									
									$langCode = stripslashes($rowdata['code']);
									
									$searchURI = stripos($currentURL,"/".$langCode);
									if(!$searchURI){
										$newURL = str_replace_first("/".$getLang,"/".$langCode,$currentURL);
									}
									else{
										$newURL = $currentURL;
									}
									?>
									<option value="<?php echo($newURL); ?>" <?php echo($getLang == stripslashes($rowdata['code']) ? 'selected' : ''); ?>><?php echo(strtoupper(stripslashes($rowdata['code']))); ?></option>
									<?php
								}
							}
							?>
						</select>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<p style="color:#444"><?php echo(strip_tags($allcontents[54]['sectionDesc'])); ?></p>
		</div>
	</div>
</footer>

<style type="text/css">
	#centralModalSm {
		display: none;
	    position: fixed;
	    top: 0;
	    width: 100%;
	    height: 100%;
	    background: rgba(0,0,0,0.45);
	    bottom: 0;
	    left: 0;
	    right: 0;
	    z-index: 9999;
}
#centralModalSm .modal-content {
	background-color: #fff;
    max-width: 50%;
    margin: 0 auto;
    position: relative;
    top: 20%;
    text-align: center;
    border-radius: 5px;
    padding: 40px;
}
#centralModalSm button.close {
	position: absolute;
	cursor: pointer;
    float: right;
    top: -10px;
    right: -10px;
    background: #000;
    border: 0;
    border-radius: 50%;
    height: 32px;
    width: 32px;
    color: #fff;
}
</style>



<script>

$(document).ready(function(){

	$("#centralModalSm").delay(2000).fadeIn(500);

   $('#centralModalSm button.close').click(function(){
       $('#centralModalSm').fadeOut(500);
   });

	$('.iban_format').mask('SS00 0000 0000 0000 0000 00', {
		    placeholder: '____ ____ ____ ____ ____ __'
	});

	$(".dateformat").datepicker({ 
		dateFormat: 'mm/yy',
		changeMonth: true,
	    changeYear: true,
	    showButtonPanel: true,

	    onClose: function(dateText, inst) {  
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val(); 
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val(); 
            $(this).datepicker('setDate', new Date(year, month, 1)); 
        }
	});

	

	$('#langchange').change(function(){
		
		location.href = $(this).val();
		
	});
	/*
	$(document).on('click','input[type="submit"]',function(){
		
		$('.blurback,.globalloader').show();
		
	});*/

	$('#client_logo').owlCarousel({
	    loop:true,
	    margin:0,
	    nav:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:3
	        },
	        1000:{
	            items:6
	        }
	    }
	})
	
	$('.loanlistX').click(function(){
		$('.loanlistX').removeClass('activeloan');
		$(this).addClass('activeloan');
	})

});
	

function handleFileSelect(event) {
    var input = this;
    //jQuery('.alrdy_pic > img').hide();
   // console.log(input.files.length)
    if (input.files && input.files.length) {
        var reader = new FileReader();
        this.enabled = false
        reader.onload = (function (e) {
       // console.log(e)
        htmlele = "<div class='s'><img class='imageThumb' src='"+e.target.result+"' title='"+escape(e.name)+ "'></img><span onclick=remove(this)><i class='fa fa-close'></i></span></div>"; 
			//input.closest(".mnDiv").find(".img_div").before(htmlele);
            $(".img_div").html(htmlele);
        });
        reader.readAsDataURL(input.files[0]);
    }
}
$('#imagefile,#investor_identity').change(handleFileSelect);

/*
if(window.File && window.FileList && window.FileReader) {
	jQuery(".files").on("change",function(e) {
		
			var input = this;
			jQuery('.alrdy_pic > img').hide();
			
			//var files = e.target.files ,
			//filesLength = files.length ;

		    //console.log(input.files)
		    var f =input.files[0];
		    if (input.files && input.files.length) {
		        var reader = new FileReader();
		        this.enabled = false
		        reader.onload = (function (e) {
		        //console.log(e)
		           var file = e.target;
		           console.log(file.name);
		           htmlele = "<div class='s'><img class='imageThumb' src='"+e.target.result+"' title='"+file.name+ "'></img><span onclick=remove(this)><i class='fa fa-close'></i></span></div>"; 
								input.closest(".mnDiv").find(".img_div").before(htmlele);
		        });
		        reader.readAsDataURL(f);
		    }
/*
			
				for (var i = 0; i <= filesLength ; i++) {
					var f = files[i]
					var fileReader = new FileReader();
					fileReader.onload = (function(e) {
						var file = e.target;
						htmlele = "<div class='s'><img class='imageThumb' src='"+e.target.result+"' title='"+file.name+ "'></img><span onclick=remove(this)><i class='fa fa-close'></i></span></div>"; 
						_this.closest(".mnDiv").find(".img_div").before(htmlele);

						
					});
					fileReader.readAsDataURL(f);
				}
				});
}
				*/
	

function remove(r) {
	_this = jQuery(r);
	_this.closest(".s").remove();
}
</script>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
});
</script>
</body>
</html>