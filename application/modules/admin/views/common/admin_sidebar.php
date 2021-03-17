<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('admin/index')?>" class="logo">
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
                  <a href="<?php echo site_url('admin/profile');?>" class="btn btn-default rounded" style="font-size: 12px;">Profile</a>
                </div>
                <div class="pull-left" style="margin-left: 5px;">
                  <a href=" <?php echo site_url('admin/change_password');?>" class="btn btn-default rounded" style="font-size: 12px;">Change Password</a>
                </div>

                <div class="pull-right">
                  <a href="<?php echo site_url('admin/logout')?>" class="btn btn-default rounded" style="font-size: 12px;">Logout</a>
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
        <li>
          <a href="<?php echo site_url('admin/index')?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gavel"></i> <span>Profile and Legal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('admin/details/')?>"><i class="fa fa-info-circle"></i> Company Profile</a></li>
            <li><a href="<?php echo site_url('admin/about_us/')?>"><i class="fa fa-newspaper-o"></i> About Us</a></li>
            <li><a href="<?php echo site_url('admin/privacy_policy/')?>"><i class="fa fa-file-powerpoint-o"></i> Privacy Policy</a></li>
            <li><a href="<?php echo site_url('admin/terms_conditions/')?>"><i class="fa fa-file-text"></i> Terms and Conditions</a></li>
            <li><a href="<?php echo site_url('admin/refund_policy/')?>"><i class="fa fa-file-text-o"></i> Refund Policy</a></li>
            <li><a href="<?php echo site_url('admin/payment_options')?>">
            <i class="fa fa-money"></i> Payments Options</a></li>
            <li><a href="<?php echo site_url('admin/contact_us/')?>"><i class="fa fa-phone-square"></i> Contact Us</a></li>
          </ul>
        <li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gears"></i> <span>App Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('')?>"><i class="fa fa-map-marker"></i> Pickup Location</a></li>
            <li><a href="<?php echo site_url('admin/app_theme')?>"><i class="fa fa-file-o"></i> App Theme</a></li>
            <li><a href="<?php echo site_url('admin/shipping_rates/')?>"><i class="fa fa-inr"></i> Delivery Charges</a></li>
            <li><a href="<?php echo site_url('admin/banners/')?>"><i class="fa fa-image"></i> App Banners</a></li>
            <li><a href="<?php echo site_url('admin/login_settings/')?>"><i class="fa fa-image"></i> Login Settings</a></li>

            <li><a href="<?php echo site_url('admin/wallet_details_list/')?>"><i class="fa fa-user-plus"></i>Wallet Details</a></li>

            <li><a href="<?php echo site_url('admin/settings_masters/')?>"><i class="fa fa-user-plus"></i>Enable/Disable Settings</a></li>
            
            <li><a href="<?php echo site_url('admin/delivery_range/')?>"><i class="fa fa-user-plus"></i>Delievery Range</a></li>
            <li><a href="<?php echo site_url('admin/discount_coupon_list/')?>"><i class="fa fa-user-plus"></i>Discount Coupon</a></li>
          </ul>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text"></i> <span>Masters</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="<?php echo site_url('admin/category_list/')?>"><i class="fa fa-list-alt"></i> Category</a>
                <!-- <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
               <ul class="treeview-menu">
                    <li><a href="<?php// echo site_url('admin/category/')?>"><i class="fa fa-plus"></i> Add Category</a></li>
                    <li><a href="<?php //echo site_url('admin/category_list/')?>"><i class="fa fa-eye"></i> View Category</a></li>
               </ul> -->
            </li>
          
            <li >
              <a href="<?php echo site_url('admin/sub_cat_list/')?>"><i class="fa fa-list-ol"></i> Sub Category
                <!-- <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span> -->
              </a>
             
            </li>
           
            <li>
              <a href="<?php echo site_url('admin/product_list/')?>"><i class="fa fa-product-hunt"></i> Products
                
              </a>
              
            </li>

            <li>
              <a href="<?php echo site_url('admin/userList/')?>"><i class="fa fa-user"></i> Users
                
              </a>
               
            </li>

            <li>
              <a href="<?php echo site_url('admin/customerList/')?>"><i class="fa fa-users"></i> Customers
               
              </a>

              <li>
              <a href="<?php echo site_url('admin/deliveryboysList/')?>"><i class="fa fa-users"></i> Delivery boys
               
              </a>
               
            </li>

            <li>
              <a href="<?php echo site_url('admin/vendorList/')?>"><i class="fa fa-users"></i> Vendors
               
              </a>
               
            </li>

            <li class="treeview">
              <a href="#"><i class="fa fa-users"></i> Bulk Import
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
               <ul class="treeview-menu">
                    <li><a href="<?php echo site_url('admin/uploads')?>"><i class="fa fa-user-plus"></i> Image Upload</a></li>
                    <li><a href="<?php echo site_url('admin/excel_import/')?>"><i class="fa fa-list"></i> Excel Import</a></li>
               </ul>
            </li>

          </ul>
        </li>
       
        <li><a href="<?php echo site_url('admin/orders')?>"><i class="fa fa-book"></i> <span>Orders</span></a></li>
  
        <li><a href="<?php echo site_url('admin/notification')?>"><i class="fa fa-bell"></i> <span>Notification </span></a></li>
        
        <li>
              <a href="<?php echo site_url('admin/feedback/')?>"><i class="fa fa-comments"></i> Feedback
               
              </a>
               
            </li>


            <li class="treeview">
              <a href="#"><i class="fa fa-book"></i> Report
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
               <ul class="treeview-menu">
                    <li><a href="<?php echo site_url('admin/reports/')?>"><i class="fa fa-user-plus"></i>Report</a></li>
                    <li><a href="<?php echo site_url('admin/report_by_item/')?>"><i class="fa fa-list"></i> Product Wise Report</a></li>
               </ul>
            </li>
            <?php if($this->session->userdata('user_role')==4){ ?>
                <li class="treeview">
                  <a href="#"><i class="fa fa-book"></i> Management
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                   <ul class="treeview-menu">
                        <li><a href="<?php echo site_url('admin/version/')?>"><i class="fa fa-user-plus"></i>App Version </a></li>

                        <li><a href="<?php echo site_url('admin/sms_settings_list/')?>"><i class="fa fa-user-plus"></i>Sms Settings</a></li>

                         <li><a href="<?php echo site_url('admin/payment_settings/')?>"><i class="fa fa-user-plus"></i>Payment Settings</a></li>

                         
                         <li>
                           <a href="<?php echo site_url('admin/firebase_key/')?>"><i class="fa fa-user-plus"></i>Notification Key</a>
                         </li>
                   </ul>
                   
               </li>
            <?php } ?>

          
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>