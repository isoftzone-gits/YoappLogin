<!DOCTYPE html>
<html>
   <head>
      <title>SmartEats</title>
      <!--/tags -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="keywords" content="Elite Shoppy Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
         Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
      <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
         function hideURLbar(){ window.scrollTo(0,1); } 
      </script>
      <!--//tags -->
      <link href="<?php echo base_url('asset/dist/css/bootstrap.css') ?>" rel="stylesheet" type="text/css" media="all" />
      <link href="<?php echo base_url('asset/dist/css/style.css') ?>" rel="stylesheet" type="text/css" media="all" />
      <link href="<?php echo base_url('asset/dist/css/font-awesome.css')?>" rel="stylesheet">
      <link href="<?php echo base_url('asset/dist/css/easy-responsive-tabs.css')?>" rel='stylesheet' type='text/css'/>
      <!-- //for bootstrap working -->
      <link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
      <link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,900,900italic,700italic' rel='stylesheet' type='text/css'>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/dist/css/jquery-ui.css')?>">

<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/dist/css/flexslider.css')?>">

      <script type="text/javascript" src="<?php echo base_url('asset/dist/js/jquery-2.1.4.min.js') ?>"></script>

<!-- //js -->
<!-- //js -->
<script src="<?php echo base_url('asset/dist/js/modernizr.custom.js')?>"></script>
    <!-- Custom-JavaScript-File-Links --> 
    <!-- cart-js -->
    <script src="<?php echo base_url('asset/dist/js/minicart.min.js')?>"></script>
    <script src="<?php echo base_url('asset/dist/js//responsiveslides.min.js')?>"></script>
    <script src="<?php echo base_url('asset/dist/js//jquery.flexslider.js')?>"></script>
    
<script src="<?php echo base_url('asset/dist/js/modernizr.custom.js')?>"></script>

<script type="text/javascript" src="<?php echo base_url('asset/dist/js/move-top.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/dist/js/jquery.easing.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/dist/js/bootstrap.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/dist/js/jquery-ui.js')?>   "></script>
   <style type="text/css">
      .modal-header{
         background: aqua !important;
      }
      .modal-footer{
         background: aqua !important;
      }
      .message {
  -webkit-background-size:40px 40px;
  -moz-background-size:40px 40px;
  background-size:40px 40px;
  background-image:-webkit-gradient(linear,left top,right bottom,                   color-stop(.25,rgba(255,255,255,.05)),color-stop(.25,transparent),                     color-stop(.5,transparent),color-stop(.5,rgba(255,255,255,.05)),                    color-stop(.75,rgba(255,255,255,.05)),color-stop(.75,transparent),                     to(transparent));
  background-image:-webkit-linear-gradient(135deg,rgba(255,255,255,.05) 25%,transparent 25%,                transparent 50%,rgba(255,255,255,.05) 50%,rgba(255,255,255,.05) 75%,                transparent 75%,transparent);
  background-image:-moz-linear-gradient(135deg,rgba(255,255,255,.05) 25%,transparent 25%,                transparent 50%,rgba(255,255,255,.05) 50%,rgba(255,255,255,.05) 75%,                transparent 75%,transparent);
  background-image:-ms-linear-gradient(135deg,rgba(255,255,255,.05) 25%,transparent 25%,                 transparent 50%,rgba(255,255,255,.05) 50%,rgba(255,255,255,.05) 75%,                transparent 75%,transparent);
  background-image:-o-linear-gradient(135deg,rgba(255,255,255,.05) 25%,transparent 25%,                  transparent 50%,rgba(255,255,255,.05) 50%,rgba(255,255,255,.05) 75%,                transparent 75%,transparent);
  background-image:linear-gradient(135deg,rgba(255,255,255,.05) 25%,transparent 25%,                  transparent 50%,rgba(255,255,255,.05) 50%,rgba(255,255,255,.05) 75%,                transparent 75%,transparent);
  -moz-box-shadow:inset 0 -1px 0 rgba(255,255,255,.4);
  -webkit-box-shadow:inset 0 -1px 0 rgba(255,255,255,.4);
  box-shadow:inset 0 -1px 0 rgba(255,255,255,.4);
  width:100%;
  border:1px solid;
  color:#fff;
  padding:15px;
  position:fixed;
  _position:absolute;
  text-shadow:0 1px 0 rgba(0,0,0,.5);
  -webkit-animation:animate-bg 5s linear infinite;
  -moz-animation:animate-bg 5s linear infinite;
}
.info {
  background-color:#4ea5cd;
  border-color:#3b8eb5;
}
.error {
  background-color:#de4343;
  border-color:#c43d3d;
}
.warning {
  background-color:#eaaf51;
  border-color:#d99a36;
}
.success {
  background-color:#61b832;
  border-color:#55a12c;
}
.message h3 {
  margin:0 0 5px 0;
}
.message p {
  margin:0;
}
   </style>

   <!-- Custom-JavaScript-File-Links --> 
   <!-- cart-js -->
   </head>
   <body>
      <!-- header -->
      <div class="header" id="home" style="display: none;">
         <div class="container">
            <ul>
               <li> <a href="#" onclick="open_modal('in')"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Sign In </a></li>
               <li> <a href="#" onclick="open_modal('up')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sign Up </a></li>
               <li><i class="fa fa-phone" aria-hidden="true"></i> Call : +91 9833233499</li>
               <li><i class="fa fa-envelope-o" aria-hidden="true"></i> <a href="mailto:info@example.com">care@smaarteats.com</a></li>
            </ul>
         </div>
      </div>
      <!-- //header -->
      <!-- header-bot -->
      <div class="header-bot">
         <div class="header-bot_inner_wthreeinfo_header_mid">
            <div class="col-md-4 header-middle">
               <!-- <form action="#" method="post">
                  <input type="search" name="search" placeholder="Search here..." required="">
                  <input type="submit" value=" ">
                  <div class="clearfix"></div>
               </form> -->
            </div>
            <!-- header-bot -->
            <div class="col-md-4 logo_agile">
               <img src="<?php echo base_url('asset/default_images/logo.png'); ?>">
            </div>
            <!-- header-bot -->
            <!-- <div class="col-md-4 agileits-social top_content">
               <ul class="social-nav model-3d-0 footer-social w3_agile_social">
                  <li class="share">Share On : </li>
                  <li>
                     <a href="#" class="facebook">
                        <div class="front"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="twitter">
                        <div class="front"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="instagram">
                        <div class="front"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="pinterest">
                        <div class="front"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                     </a>
                  </li>
               </ul>
            </div> -->
            <div class="clearfix"></div>
         </div>
      </div>
      <!-- //header-bot -->
      <!-- banner -->
      <div class="ban-top">
         <div class="container">
            <div class="top_nav_left">
               <nav class="navbar navbar-default">
                  <div class="container-fluid">
                     <!-- Brand and toggle get grouped for better mobile display -->
                     <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                     </div>
                     <!-- Collect the nav links, forms, and other content for toggling -->
                     <div class="collapse navbar-collapse menu--shylock" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav menu__list">
                           <li class="active menu__item menu__item--current home"><a class="menu__link" href="<?php echo site_url(); ?>">Home <span class="sr-only">(current)</span></a></li>
                           <li class=" menu__item about"><a class="menu__link" href="<?php echo site_url('front/about'); ?>">About</a></li>
                           
                           <li class="dropdown menu__item">
                              <a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop Now <span class="caret"></span></a>
                              <ul class="dropdown-menu multi-column columns-3">
                                 <div class="agile_inner_drop_nav_info">
                                    <div class="col-sm-6 multi-gd-img1 multi-gd-text ">
                                       <a href="#"><img src="<?php echo base_url('asset/default_images/'); ?>menu.jpg" alt="" /></a>
                                    </div>
                                    <div class="col-sm-6 multi-gd-img">
                                       <ul class="multi-column-dropdown">
                                         <?php if(!empty($category)){
                                          foreach ($category as $key => $value) { ?>
                                            <li><a href="<?php echo site_url('front/catbypro/').$value->id;?>"><b><?php echo $value->category_name; ?></b></a></li>
                                          <?php } 
                                         } ?>
                                       </ul>
                                    </div>
                                   
                                    <div class="clearfix"></div>
                                 </div>
                              </ul>
                           </li>
                           <!--
                           <li class="dropdown menu__item">
                              <a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Women's wear <span class="caret"></span></a>
                              <ul class="dropdown-menu multi-column columns-3">
                                 <div class="agile_inner_drop_nav_info">
                                    <div class="col-sm-3 multi-gd-img">
                                       <ul class="multi-column-dropdown">
                                          <li><a href="womens.html">Clothing</a></li>
                                          <li><a href="womens.html">Wallets</a></li>
                                          <li><a href="womens.html">Footwear</a></li>
                                          <li><a href="womens.html">Watches</a></li>
                                          <li><a href="womens.html">Accessories</a></li>
                                          <li><a href="womens.html">Bags</a></li>
                                          <li><a href="womens.html">Caps & Hats</a></li>
                                       </ul>
                                    </div>
                                    <div class="col-sm-3 multi-gd-img">
                                       <ul class="multi-column-dropdown">
                                          <li><a href="womens.html">Jewellery</a></li>
                                          <li><a href="womens.html">Sunglasses</a></li>
                                          <li><a href="womens.html">Perfumes</a></li>
                                          <li><a href="womens.html">Beauty</a></li>
                                          <li><a href="womens.html">Shirts</a></li>
                                          <li><a href="womens.html">Sunglasses</a></li>
                                          <li><a href="womens.html">Swimwear</a></li>
                                       </ul>
                                    </div>
                                    <div class="col-sm-6 multi-gd-img multi-gd-text ">
                                       <a href="womens.html"><img src="images/top1.jpg" alt=" "/></a>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                              </ul>
                           </li>
                           <li class="menu__item dropdown">
                              <a class="menu__link" href="#" class="dropdown-toggle" data-toggle="dropdown">Short Codes <b class="caret"></b></a>
                              <ul class="dropdown-menu agile_short_dropdown">
                                 <li><a href="icons.html">Web Icons</a></li>
                                 <li><a href="typography.html">Typography</a></li>
                              </ul>
                           </li>-->
                           <li class=" menu__item contact"><a class="menu__link" href="<?php echo site_url('front/contact'); ?>">Contact</a></li>
                        </ul>
                     </div>
                  </div>
               </nav>
            </div>
            <div class="top_nav_right">
               <div class="wthreecartaits wthreecartaits2 cart cart box_1">
                  <form action="#" method="post" class="last"> 
                     <input type="hidden" name="cmd" value="_cart">
                     <input type="hidden" name="display" value="1">
                     <button class="w3view-cart" type="submit" name="submit" value=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
                  </form>
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>

      <!-- Modal1 --> 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body modal-body-sub_agile">
            <div class="col-md-8 modal_body_left modal_body_left1">
               <h3 class="agileinfo_sign">Sign In <span>Now</span></h3>
               <form action="#" method="post">
                  <div class="styled-input agile-styled-input-top">
                     <input type="text" name="Name" required="">
                     <label>Name</label>
                     <span></span>
                  </div>
                  <div class="styled-input">
                     <input type="email" name="Email" required=""> 
                     <label>Email</label>
                     <span></span>
                  </div>
                  <input type="submit" value="Sign In">
               </form>
               <ul class="social-nav model-3d-0 footer-social w3_agile_social top_agile_third">
                  <li>
                     <a href="#" class="facebook">
                        <div class="front"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="twitter">
                        <div class="front"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="instagram">
                        <div class="front"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="pinterest">
                        <div class="front"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                     </a>
                  </li>
               </ul>
               <div class="clearfix"></div>
               <p><a href="#" data-toggle="modal" data-target="#myModal2" > Don't have an account?</a></p>
            </div>
            <div class="col-md-4 modal_body_right modal_body_right1">
               <img src="<?php echo base_url('asset/default_images/'); ?>sign.jpg" alt=" "/>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
      <!-- //Modal content-->
   </div>
</div>
<!-- //Modal1 -->
<!-- Modal2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body modal-body-sub_agile">
            <div class="col-md-8 modal_body_left modal_body_left1">
               <h3 class="agileinfo_sign">Sign Up <span>Now</span></h3>
               <form action="#" method="post">
                  <div class="styled-input agile-styled-input-top">
                     <input type="text" name="Name" required="">
                     <label>Name</label>
                     <span></span>
                  </div>
                  <div class="styled-input">
                     <input type="email" name="Email" required=""> 
                     <label>Email</label>
                     <span></span>
                  </div>
                  <div class="styled-input">
                     <input type="password" name="password" required=""> 
                     <label>Password</label>
                     <span></span>
                  </div>
                  <div class="styled-input">
                     <input type="password" name="Confirm Password" required=""> 
                     <label>Confirm Password</label>
                     <span></span>
                  </div>
                  <input type="submit" value="Sign Up">
               </form>
               <ul class="social-nav model-3d-0 footer-social w3_agile_social top_agile_third">
                  <li>
                     <a href="#" class="facebook">
                        <div class="front"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="twitter">
                        <div class="front"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="instagram">
                        <div class="front"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="pinterest">
                        <div class="front"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                        <div class="back"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
                     </a>
                  </li>
               </ul>
               <div class="clearfix"></div>
               <p><a href="#">By clicking register, I agree to your terms</a></p>
            </div>
            <div class="col-md-4 modal_body_right modal_body_right1">
               <img src="<?php echo base_url('asset/default_images/'); ?>signup.jpg" alt=" "/>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
      <!-- //Modal content-->
   </div>
</div>
<!-- //Modal2 -->
