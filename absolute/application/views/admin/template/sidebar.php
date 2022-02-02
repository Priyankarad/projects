 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo BASEURL; ?>assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata['userData']['firstname'].' '.$this->session->userdata['userData']['lastname']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
		<li <?php if(isset($title) && $title=='Dashboard'){ ?>class="active" <?php } ?>>
          <a href="<?php echo site_url('administrator'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
		
        <li class="treeview <?php if(isset($title) && $title=='Markets'){ ?> active <?php } ?>">
          <a href="#">
            <i class="fa fa-users"></i> <span>Markets</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('administrator/markets'); ?>"><i class="fa fa-circle-o"></i>View Markets</a></li>
            <li><a href="<?php echo site_url('administrator/addmarket'); ?>"><i class="fa fa-circle-o"></i> Add Market</a></li>
          </ul>
        </li>	
        <li class="treeview <?php if(isset($title) && $title=='Partners'){ ?> active <?php } ?>">
          <a href="#">
            <i class="fa fa-shopping-cart"></i> <span>Partners</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('administrator/allpartners'); ?>"><i class="fa fa-circle-o"></i>All Partners</a></li>
            <li><a href="<?php echo site_url('administrator/addpartner'); ?>"><i class="fa fa-circle-o"></i> Add Partner</a></li>
          </ul>
        </li>
        <li class="treeview <?php if(isset($title) && $title=='Markets'){ ?> active <?php } ?>">
          <a href="#">
            <i class="fa fa-users"></i> <span>Standards</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('administrator/standards'); ?>"><i class="fa fa-circle-o"></i>View Standards</a></li>
            <li><a href="<?php echo site_url('administrator/addstandard'); ?>"><i class="fa fa-circle-o"></i> Add Standards</a></li>
          </ul>
        </li>
       <li class="treeview <?php if(isset($title) && $title=='Articles'){ ?> active <?php } ?>">
          <a href="#">
            <i class="fa fa-newspaper-o"></i> <span>Articles</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('administrator/articles'); ?>"><i class="fa fa-circle-o"></i>View Article</a></li>
            <li><a href="<?php echo site_url('administrator/addarticle'); ?>"><i class="fa fa-circle-o"></i> Add Article</a></li>
          </ul>
        </li>
       <li class="treeview <?php if(isset($title) && $title=='Links'){ ?> active <?php } ?>">
          <a href="#">
            <i class="fa fa-link"></i> <span>Links</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('administrator/links'); ?>"><i class="fa fa-circle-o"></i>View Links</a></li>
            <li><a href="<?php echo site_url('administrator/addlink'); ?>"><i class="fa fa-circle-o"></i> Add Link</a></li>
          </ul>
        </li>
        <li class="treeview <?php if(isset($title) && $title=='Products'){ ?> active <?php } ?>">
          <a href="#">
            <i class="fa fa-shopping-cart"></i> <span>Products</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('administrator/products'); ?>"><i class="fa fa-circle-o"></i>View Products</a></li>
            <li><a href="<?php echo site_url('administrator/addproduct'); ?>"><i class="fa fa-circle-o"></i> Add Products</a></li>
          </ul>
        </li>

        <li class="treeview <?php if(isset($title) && $title=='Category'){ ?> active <?php } ?>">
          <a href="#">
            <i class="fa fa-suitcase"></i> <span>Product Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('administrator/category'); ?>"><i class="fa fa-circle-o"></i>View Category</a></li>
            <li><a href="<?php echo site_url('administrator/addcategory'); ?>"><i class="fa fa-circle-o"></i> Add Category</a></li>
          </ul>
        </li>
		<?php /**** 
        <li class="treeview <?php if(isset($title) && $title=='Product Entity'){ ?> active <?php } ?>">
          <a href="#">
            <i class="fa fa-dollar"></i> <span>Product Taxonomy </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('administrator/colors'); ?>"><i class="fa fa-circle-o"></i>View Colors</a></li>
            <li><a href="<?php echo site_url('administrator/addcolor'); ?>"><i class="fa fa-circle-o"></i> Add color</a></li>
			<li class=""><a href="<?php echo site_url('administrator/size'); ?>"><i class="fa fa-circle-o"></i>View Size</a></li>
            <li><a href="<?php echo site_url('administrator/addsize'); ?>"><i class="fa fa-circle-o"></i> Add Size</a></li>
          </ul>
        </li>
		 ******/ ?>
		<li <?php if(isset($title) && $title=='Orders'){ ?> class="active" <?php } ?>>
          <a href="<?php echo site_url('administrator/allorders'); ?>">
            <i class="fa fa-file-pdf-o"></i> <span>Orders</span>
          </a>
        </li>
        <li <?php if(isset($title) && $title=='Page Settings'){ ?> class="active" <?php } ?>>
          <a href="<?php echo site_url('administrator/page_settings'); ?>">
            <i class="fa fa-file-pdf-o"></i> <span>Page Settings</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>