<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('vendor/index')?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo base_url('asset/default_images/ISOFTZONE-LOGO_SHORT.png')?>" class="user-image" alt="ISOFT logo"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo base_url('asset/default_images/ISOFTZONE-LOGO.png')?>" class="user-image" alt="ISOFT logo"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if(!empty($this->session->userdata('profile_pic'))){ ?>
                <img src="<?php echo base_url('asset/uploads/'.$this->session->userdata('profile_pic').'')?>" class="user-image" alt="User Image">
                <?php }else{ ?>
                <img src="<?php echo base_url('asset/default_images/user2-160x160.jpg')?>" class="user-image" alt="User Image">
                <?php } ?>
              
              <span class="hidden-xs">Welcome ! <?php echo ucwords($this->session->userdata('username'));?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if(!empty($this->session->userdata('profile_pic'))){ ?>
                <img src="<?php echo base_url('asset/uploads/'.$this->session->userdata('profile_pic').'')?>" class="img-circle" alt="User Image">
                <?php }else{ ?>
                <img src="<?php echo base_url('asset/default_images/user2-160x160.jpg')?>" class="img-circle" alt="User Image">
                <?php } ?>
                <p>
                  <?php echo ucwords($this->session->userdata('username'));?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('vendor/profile');?>" class="btn btn-default rounded" style="font-size: 12px;">Profile</a>
                </div>
                <div class="pull-left" style="margin-left: 5px;">
                  <a href=" <?php echo site_url('vendor/change_password');?>" class="btn btn-default rounded" style="font-size: 12px;">Change Password</a>
                </div>

                <div class="pull-right">
                  <a href="<?php echo site_url('vendor/logout')?>" class="btn btn-default rounded" style="font-size: 12px;">Logout</a>
                </div>
              </li>
            </ul>
         </li>
        </ul>
      </div>
    </nav>
  </header>

<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <!-- <li>
          <a href="<?php// echo site_url('vendor/index')?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li> -->
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text"></i> <span>Masters</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#"><i class="fa fa-list-alt"></i> Category
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
               <ul class="treeview-menu">
                   <!--  <li><a href="<?php //echo site_url('vendor/category/')?>"><i class="fa fa-plus"></i> Add Category</a></li> -->
                    <li><a href="<?php echo site_url('vendor/category_list/')?>"><i class="fa fa-eye"></i> View Category</a></li>
               </ul>
            </li>
          
            <li class="treeview">
              <a href="#"><i class="fa fa-list-ol"></i> Sub Category
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
               <ul class="treeview-menu">
                    <!-- <li><a href="<?php //echo site_url('vendor/sub_category/')?>"><i class="fa fa-plus"></i> Add Sub Category</a></li> -->
                    <li><a href="<?php echo site_url('vendor/sub_cat_list/')?>"><i class="fa fa-eye"></i> View Sub Category</a></li>
               </ul>
            </li>
          
            <li class="treeview">
              <a href="#"><i class="fa fa-product-hunt"></i> Products
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
               <ul class="treeview-menu">
                    <li><a href="<?php echo site_url('vendor/product/')?>"><i class="fa fa-cart-plus"></i> Add Product</a></li>
                    <li><a href="<?php echo site_url('vendor/product_list/')?>"><i class="fa fa-list-ul"></i> View Product</a></li>
               </ul>
            </li>

            

          </ul>
        </li>
       
       

          
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>