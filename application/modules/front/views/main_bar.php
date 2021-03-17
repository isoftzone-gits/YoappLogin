
<!-- banner -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
   <!-- Indicators -->
   <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1" class=""></li>
      <li data-target="#myCarousel" data-slide-to="2" class=""></li>
      <li data-target="#myCarousel" data-slide-to="3" class=""></li>
      <li data-target="#myCarousel" data-slide-to="4" class=""></li>
      <li data-target="#myCarousel" data-slide-to="5" class=""></li>
   </ol>
   <div class="carousel-inner" role="listbox">
      <div class="item active">
         <div class="container">
            <div class="carousel-caption">
               <!-- <h3>The Biggest <span>Sale</span></h3> -->
               <!-- <p>Special for today</p> -->
               <a class="hvr-outline-out button2" href="<?php echo site_url('front/catbypro/3');?>">Shop Now </a>
            </div>
         </div>
      </div>
      <div class="item item2">
         <div class="container">
            <div class="carousel-caption">
               <!-- <h3>Summer <span>Collection</span></h3> -->
               <!-- <p>New Arrivals On Sale</p> -->
               <a class="hvr-outline-out button2" href="<?php echo site_url('front/catbypro/3');?>">Shop Now </a>
            </div>
         </div>
      </div>
      <div class="item item3">
         <div class="container">
            <div class="carousel-caption">
               <!-- <h3>The Biggest <span>Sale</span></h3> -->
               <!-- <p>Special for today</p> -->
               <a class="hvr-outline-out button2" href="<?php echo site_url('front/catbypro/3');?>">Shop Now </a>
            </div>
         </div>
      </div>
      <div class="item item4">
         <div class="container">
            <div class="carousel-caption">
              
               <a class="hvr-outline-out button2" href="<?php echo site_url('front/catbypro/3');?>">Shop Now </a>
            </div>
         </div>
      </div>
      <div class="item item5">
         <div class="container">
            <div class="carousel-caption">
             
               <a class="hvr-outline-out button2" href="<?php echo site_url('front/catbypro/3');?>">Shop Now </a>
            </div>
         </div>
      </div>

      <div class="item item">
         <div class="container">
            <div class="carousel-caption">
             
               <a class="hvr-outline-out button2" href="<?php echo site_url('front/catbypro/3');?>">Shop Now </a>
            </div>
         </div>
      </div>
   </div>
   <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
   <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
   <span class="sr-only">Previous</span>
   </a>
   <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
   <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
   <span class="sr-only">Next</span>
   </a>
   <!-- The Modal -->
</div>
<!-- //banner -->

<div class="banner_bottom_agile_info">
   <div class="container">
      <div class="banner_bottom_agile_info_inner_w3ls">
         <?php if(!empty($category)){
            $count=1;
            foreach ($category as $key => $value) { ?>
              
         
         <div class="col-md-6 wthree_banner_bottom_grid_three_left1 grid">
            <a href="<?php echo site_url('front/catbypro/').$value->id;?>">
            <figure class="effect-roxy">
               <img src="<?php echo base_url('asset/uploads/').$value->category_image; ?>" alt=" " class="img-responsive" style="height:350px";/>
               <figcaption>
                  <!-- <h3><?php echo $value->category_name; ?></h3> -->
                  <p>New Arrivals</p>
               </figcaption>
            </figure>
            </a>
         </div>
         
         <?php if($count==2){
            ?>
            <div class="clearfix"></div>
         <?php         } ?>
         <?php $count++;
          $count=1;
          }?>
        
         
         <?php
         } ?>
      </div>
   </div>
</div>
<!-- schedule-bottom -->
<div class="schedule-bottom">
   <div class="col-md-6 agileinfo_schedule_bottom_left">
      <img src="<?php echo base_url('asset/default_images/16.jpg'); ?>" alt=" " class="img-responsive" />
   </div>
   <div class="col-md-6 agileits_schedule_bottom_right">
      <div class="w3ls_schedule_bottom_right_grid">
         <h3>SMAART EATS</h3>
         <p>we seek to bring about a significant
change in the life of our highly held consumers. Our mission is to make our consumer&#39;s life
better and healthier by adapting to natural and ecological changes.
</p>
         <div class="col-md-4 w3l_schedule_bottom_right_grid1">
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <h4>Customers</h4>
            <h5 class="counter">100</h5>
         </div>
         <div class="col-md-4 w3l_schedule_bottom_right_grid1">
            <i class="fa fa-calendar-o" aria-hidden="true"></i>
            <h4>Orders</h4>
            <h5 class="counter">200</h5>
         </div>
         <div class="col-md-4 w3l_schedule_bottom_right_grid1">
            <i class="fa fa-shield" aria-hidden="true"></i>
            <h4>Events</h4>
            <h5 class="counter">45</h5>
         </div>
         <div class="clearfix"> </div>
      </div>
   </div>
   <div class="clearfix"> </div>
</div>
<!-- //schedule-bottom -->
<!-- banner-bootom-w3-agileits -->
<div class="banner-bootom-w3-agileits" style="display: none;">
   <div class="container">
      <h3 class="wthree_text_info">What's <span>Trending</span></h3>
      <div class="col-md-5 bb-grids bb-left-agileits-w3layouts">
         <a href="womens.html">
            <div class="bb-left-agileits-w3layouts-inner grid">
               <figure class="effect-roxy">
                  <img src="images/bb1.jpg" alt=" " class="img-responsive" />
                  <figcaption>
                     <h3><span>S</span>ale </h3>
                     <p>Upto 55%</p>
                  </figcaption>
               </figure>
            </div>
         </a>
      </div>
      <div class="col-md-7 bb-grids bb-middle-agileits-w3layouts">
         <a href="mens.html">
            <div class="bb-middle-agileits-w3layouts grid">
               <figure class="effect-roxy">
                  <img src="images/bottom3.jpg" alt=" " class="img-responsive" />
                  <figcaption>
                     <h3><span>S</span>ale </h3>
                     <p>Upto 55%</p>
                  </figcaption>
               </figure>
            </div>
         </a>
         <a href="mens.html">
            <div class="bb-middle-agileits-w3layouts forth grid">
               <figure class="effect-roxy">
                  <img src="images/bottom4.jpg" alt=" " class="img-responsive">
                  <figcaption>
                     <h3><span>S</span>ale </h3>
                     <p>Upto 65%</p>
                  </figcaption>
               </figure>
            </div>
         </a>
         <div class="clearfix"></div>
      </div>
   </div>
</div>
<!--/grids-->
<div class="agile_last_double_sectionw3ls" style="display: none;">
   <div class="col-md-6 multi-gd-img multi-gd-text ">
      <a href="womens.html">
         <img src="images/bot_1.jpg" alt=" ">
         <h4>Flat <span>50%</span> offer</h4>
      </a>
   </div>
   <div class="col-md-6 multi-gd-img multi-gd-text ">
      <a href="womens.html">
         <img src="images/bot_2.jpg" alt=" ">
         <h4>Flat <span>50%</span> offer</h4>
      </a>
   </div>
   <div class="clearfix"></div>
</div>
<!--/grids-->
<!-- /new_arrivals --> 
<div class="new_arrivals_agile_w3ls_info" >
   <div class="container">
      <h3 class="wthree_text_info">New <span>Arrivals</span></h3>
      <div id="horizontalTab">
         <ul class="resp-tabs-list">
             <?php if(!empty($category)){
               foreach ($category as $key => $value) { ?>
                  <li>
                     <?php echo $value->category_name; ?>
                  </li>
               <?php } 
                  } ?>
         </ul>
            <div class="resp-tabs-container">
            <?php if(!empty($category)){ 
               $counter = 1;
               foreach ($category as $key => $value) { ?>
                     <div class="tab<?php echo $counter; ?>">
                     <?php 
                     if(!empty($value->products)){
                     foreach ($value->products as $skey => $svalue) { ?>
                           <div class="col-md-3 product-men">
                              <div class="men-pro-item simpleCart_shelfItem">
                                 <div class="men-thumb-item">
                                    <?php if(!empty($svalue->product_image)) {
                                            $images  = @unserialize($svalue->product_image); 
                                            $images  = !empty($images)?$images:[];
                                         }
                                            
                                    ?>
                                    <img src="<?php echo base_url('asset/uploads/').@$images[0]; ?>" alt="" class="pro-image-front" style="height:250px">
                                    <img src="<?php echo base_url('asset/uploads/').@$images[0]; ?>" alt="" class="pro-image-back" style="height:250px"s>
                                    <div class="men-cart-pro">
                                       <div class="inner-men-cart-pro">
                                          <a href="<?php echo site_url('front/product/').$svalue->id; ?>" class="link-product-add-cart">Quick View</a>
                                       </div>
                                    </div>
                                    <span class="product-new-top">New</span>
                                 </div>
                                 <div class="item-info-product ">
                                    <h4><a href="<?php echo site_url('front/product/').$svalue->id; ?>"><?php echo substr($svalue->product_name, 0, 25); ?></a></h4>
                                     <h5><a href="<?php echo site_url('front/product/').$svalue->id; ?>"><?php echo substr($svalue->attributes->product_attributes, 0, 25); ?></a></h5> 
                                    <div class="info-product-price">
                                       <span class="item_price"><?php echo $svalue->attributes->sell_price; ?></span>
                                       <del><?php echo $svalue->attributes->product_price; ?></del>
                                    </div>
                                    <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out button2" onclick="show_modal()">
                                     Inquiry
                                    </div>
                                 </div>
                              </div>
                           </div>      
                     <?php  } } ?>
                     </div>
               <?php $counter++; } } ?>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- //new_arrivals --> 
<!-- /we-offer -->
<div class="sale-w3ls">
   <div class="container">
      <!-- <h6>We Offer Flat <span>40%</span> Discount</h6> -->
      <!-- <a class="hvr-outline-out button2" href="#">Shop Now </a> -->
   </div>
</div>
<!-- //we-offer -->
<!--/grids-->
<div class="coupons" style="display: none;">
   <div class="coupons-grids text-center">
      <div class="w3layouts_mail_grid">
         <div class="col-md-3 w3layouts_mail_grid_left">
            <div class="w3layouts_mail_grid_left1 hvr-radial-out">
               <i class="fa fa-truck" aria-hidden="true"></i>
            </div>
            <div class="w3layouts_mail_grid_left2">
               <h3>FREE SHIPPING</h3>
               <p>Lorem ipsum dolor sit amet, consectetur</p>
            </div>
         </div>
         <div class="col-md-3 w3layouts_mail_grid_left">
            <div class="w3layouts_mail_grid_left1 hvr-radial-out">
               <i class="fa fa-headphones" aria-hidden="true"></i>
            </div>
            <div class="w3layouts_mail_grid_left2">
               <h3>24/7 SUPPORT</h3>
               <p>Lorem ipsum dolor sit amet, consectetur</p>
            </div>
         </div>
         <div class="col-md-3 w3layouts_mail_grid_left">
            <div class="w3layouts_mail_grid_left1 hvr-radial-out">
               <i class="fa fa-shopping-bag" aria-hidden="true"></i>
            </div>
            <div class="w3layouts_mail_grid_left2">
               <h3>MONEY BACK GUARANTEE</h3>
               <p>Lorem ipsum dolor sit amet, consectetur</p>
            </div>
         </div>
         <div class="col-md-3 w3layouts_mail_grid_left">
            <div class="w3layouts_mail_grid_left1 hvr-radial-out">
               <i class="fa fa-gift" aria-hidden="true"></i>
            </div>
            <div class="w3layouts_mail_grid_left2">
               <h3>FREE GIFT COUPONS</h3>
               <p>Lorem ipsum dolor sit amet, consectetur</p>
            </div>
         </div>
         <div class="clearfix"> </div>
      </div>
   </div>
</div>
<!-- login -->
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content modal-info">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                        
         </div>
         <div class="modal-body modal-spa">
            <div class="login-grids">
               <div class="login">
                  <div class="login-bottom">
                     <h3>Sign up for free</h3>
                     <form>
                        <div class="sign-up">
                           <h4>Email :</h4>
                           <input type="text" value="Type here" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Type here';}" required=""> 
                        </div>
                        <div class="sign-up">
                           <h4>Password :</h4>
                           <input type="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" required="">
                        </div>
                        <div class="sign-up">
                           <h4>Re-type Password :</h4>
                           <input type="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" required="">
                        </div>
                        <div class="sign-up">
                           <input type="submit" value="REGISTER NOW" >
                        </div>
                     </form>
                  </div>
                  <div class="login-right">
                     <h3>Sign in with your account</h3>
                     <form>
                        <div class="sign-in">
                           <h4>Email :</h4>
                           <input type="text" value="Type here" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Type here';}" required=""> 
                        </div>
                        <div class="sign-in">
                           <h4>Password :</h4>
                           <input type="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" required="">
                           <a href="#">Forgot password?</a>
                        </div>
                        <div class="single-bottom">
                           <input type="checkbox"  id="brand" value="">
                           <label for="brand"><span></span>Remember Me.</label>
                        </div>
                        <div class="sign-in">
                           <input type="submit" value="SIGNIN" >
                        </div>
                     </form>
                  </div>
                  <div class="clearfix"></div>
               </div>
               <p>By logging in you agree to our <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a></p>
            </div>
         </div>
      </div>
   </div>
</div>

