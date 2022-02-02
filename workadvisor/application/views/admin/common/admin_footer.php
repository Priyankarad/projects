		<footer id="footer">
		    Copyright © <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>
		</footer>
		<!-- loader -->
		<div class="loading" style="display:none">
           <div class="loading_icon" style="display:none"><span class="glyphicon glyphicon-equalizer glyphicon-equalizer-animate"></span>
           </div>
        </div>
        <script type="text/javascript">
        <?php if($this->session->flashdata('error')){ ?>
        	Ply.dialog("alert", "<?php echo $this->session->flashdata('error') ?>");
        <?php } ?>
        <?php if($this->session->flashdata('success')){ ?>
        	Ply.dialog("alert", "<?php echo $this->session->flashdata('success') ?>");
        <?php } ?>
        </script>
   </body>
   <script type="text/javascript">
      function get_url()
      {
          url = "<?php echo base_url(); ?>";
          return url;
      }
    </script>  
</html>

 
