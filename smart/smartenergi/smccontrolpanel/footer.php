<script src="//cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
<script>
  if($("html").find("#borrower_email_content").length > 0)   
      CKEDITOR.replace('borrower_email_content');
  if($("html").find("#merchant_email_content").length > 0)    
            CKEDITOR.replace('merchant_email_content');
  if($("html").find("#investor_email_content").length > 0)    
            CKEDITOR.replace('investor_email_content');
                 
window.onload = function(){
  
  var errstr = JSON.parse('<?php echo($errstr); ?>');

  if(errstr.length > 0){
    errstr.forEach(function(err){
      $('#' + err.type).addClass('errbrdr');
      $('#' + err.type).after('<div class="errtxt">' + err.msg + '</div>');
    });
  }
  
  $('html,body').animate({scrollTop : $('.errbrdr:first').offset().top-50},600);
  $('.errbrdr:first').focus();
}

jQuery(document).ready(function($){
  
  $('select,input[type=text],input[type=password],input[type=file]').on('keyup change keypress blur',function(){
    
    var val = $(this).val();
    
    if(val != ''){
      
      $(this).removeClass('errbrdr');
      $(this).next('.errtxt').remove();
    }
    
  });
  
  
});
</script>
</body>
</html>