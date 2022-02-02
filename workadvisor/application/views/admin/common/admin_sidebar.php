<aside id="sidebar">
    <!--| MAIN MENU |-->
    <ul class="side-menu">
        <li class="<?php if(isset($parent) && $parent == 'dashboard') echo 'active' ;?>">
            <a href="<?php echo base_url(); ?>admin/dashboard">
                <i class="zmdi glyphicon glyphicon-align-justify"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li title="Performers" class="<?php if(isset($parent) && $parent == 'users') echo 'active' ;?>">
            <a href="<?php echo base_url(); ?>Performers">
                <i class="zmdi glyphicon glyphicon-user"></i>
                <span>Users Management</span>
            </a>
        </li>


          <li title="Employers" class="<?php if(isset($parent) && $parent == 'Employers') echo 'active' ;?>">
            <a href="<?php echo base_url(); ?>Employer">
                <i class="zmdi glyphicon glyphicon-user"></i>
                <span>Employer Management</span>
            </a>
        </li>

       <!--  <li title="Categories" class="<?php if(isset($parent) && $parent == 'Categories') echo 'active' ;?>">
            <a href="<?php echo base_url(); ?>Categories">
                <i class="zmdi glyphicon glyphicon-list"></i>
                <span>Category Management</span>
            </a>
        </li> -->

         <li class="sm-sub <?php if(isset($parent) && in_array($parent,array('Aproved_Categories','Unaproved_Categories'))) echo 'active' ;?>">
            <a href="">
                <i class="zmdi glyphicon glyphicon-list"></i>
                <span>Category Management</span>
            </a>
            <ul>
                <li title="Categories" class="<?php if(isset($parent) && $parent == 'Aproved_Categories') echo 'active' ;?>">
                    <a href="<?php echo base_url(); ?>admin/aproved_categories">
                        <span>Aproved Categories</span>
                    </a>
                </li>
                <li title="Categories" class="<?php if(isset($parent) && $parent == 'Unaproved_Categories') echo 'active' ;?>">
                    <a href="<?php echo base_url(); ?>admin/unAprovedCategories">
                        <span>Unaproved Categories</span>
                    </a>
                </li>
            </ul>
        </li>
        <li title="Payment History" class="<?php if(isset($parent) && $parent == 'Payment History') echo 'active' ;?>">
            <a href="<?php echo base_url(); ?>admin/payment_history">
                <i class="zmdi glyphicon glyphicon-record"></i>
                <span>Payment History</span>
            </a>
        </li>

        <li title="Slider Section" class="<?php if(isset($parent) && $parent == 'Slider Section') echo 'active' ;?>">
            <a href="<?php echo base_url(); ?>settings">
                <i class="zmdi glyphicon glyphicon-upload"></i>
                <span>Slider Section</span>
            </a>
        </li>

        <li title="Page Settings" class="<?php if(isset($parent) && $parent == 'Page Settings') echo 'active' ;?>">
            <a href="<?php echo base_url(); ?>settings/page_settings">
                <i class="zmdi glyphicon glyphicon-file"></i>
                <span>Page Settings</span>
            </a>
        </li>

        </ul>
       
</aside>

<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('click','.take-backup',function(){
            var password = prompt("Please enter password", "");
            if (password != null && password != "") {
                var password = btoa(password);
                window.location.href = "<?php echo base_url(); ?>admin/database_backup?password="+password;
            }
        });
    });
</script>