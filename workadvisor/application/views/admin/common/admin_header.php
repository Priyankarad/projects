<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="icon" href="<?php echo base_url();?>assets/images/fav.png" type="image/gif" sizes="18x12">
    <meta name="format-detection" content="telephone=no">
    <meta charset="UTF-8">
    <meta name="description" content="<?php echo SITE_NAME; ?>">
    <meta name="keywords" content="<?php echo SITE_NAME; ?>">
    <title><?php echo SITE_NAME; ?> Admin</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/dataTables.bootstrap.min.css" rel="stylesheet">
   
    <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap-switch.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/jquery-ui.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/app.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/chosen.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/admin/css/ply.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/tagsinput.css" rel="stylesheet">
    <!-- Javascript Libraries -->
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
  
    <script src="<?php echo base_url(); ?>assets/admin/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/functions.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-switch.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/html5lightbox.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/Ply.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/chosen.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/tagsinput.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/RowSorter.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/nic.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/custom.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
            bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
        });
        function get_url()
        {
            url = "<?php echo base_url(); ?>";
            return url;
        }
      
    </script>    
</head>

<body>
    <header id="header" class="clearfix" data-spy="affix" data-offset-top="65">
        <ul class="header-inner">
            <li class="logo">
                <a href="<?php echo base_url(); ?>admin/dashboard" class="admin-heading"><?php echo SITE_NAME; ?> Admin</a>
                <div id="menu-trigger"><i class="zmdi zmdi-menu"></i></div>
            </li>
            <li class="time pull-right">
                <a href="<?php echo base_url(); ?>admin/logout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>

            </li>
        </ul>
    </header>