<div class="page-head_agile_info_w3l">
   <div class="container">
      <!-- <h3  style="color: black">Women's <span>Wear  </span></h3> -->
      <!--/w3_short-->
      <div class="services-breadcrumb">
         <div class="agile_inner_breadcrumb">
            <ul class="w3_short">
               <!-- <li style="color: black"><a href="<?php echo site_url(); ?>">Home</a><i></i></li> -->
               
            </ul>
         </div>
      </div>
      <!--//w3_short-->
   </div>
</div>
<!-- banner-bootom-w3-agileits -->
<div class="banner-bootom-w3-agileits">
   <div class="container">
      <!-- mens -->
      <div class="col-md-4 products-left">
         <div class="filter-price">
            <h3>Filter By <span>Price</span></h3>
            <ul class="dropdown-menu6">
               <li>
                  <div id="slider-range"></div>
                  <input type="text" id="amount" style="border: 0; color: #ffffff; font-weight: normal;" />
                  <input type="hidden" name="from_amount" id="from_amount">
                  <input type="hidden" name="to_amount" id="to_amount">
                  <input type="hidden" id="default_category_id" value="<?php echo $category_id; ?>">
               </li>
            </ul>
         </div>
         <div class="css-treeview">
            <h4>Categories</h4>
            <ul class="tree-list-pad">
               <?php if(!empty($category)){ 
                  foreach ($category as $key => $value) { ?>
               
               <li><input type="radio"  id="item-<?php echo $key;?>" name="categrory_id" id="category_id" value="<?php  echo $value->id;?>" onchange="get_products()" />
                  <label for="item-<?php echo $key;?>"><i class="fa fa-long-arrow-right" aria-hidden="true"></i><?php  echo $value->category_name;?></label>
               </li>
               <?php
                  } }
                  ?>
            </ul>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="col-md-8 products-right">
         <h5>Product <span>Compare(0)</span></h5>
         <div class="sort-grid">
            <div class="sorting">
               <h6>Sort By</h6>
               <select id="filter_data" name="filter_data" class="frm-field required sect" onchange="get_products()">
                  <option value="1">Default</option>
                  <option value="2">Name(A - Z)</option>
                  <option value="3">Name(Z - A)</option>
                  <option value="4">Price(High - Low)</option>
                  <option value="5">Price(Low - High)</option>
                  
               </select>
               <div class="clearfix"></div>
            </div>
            <!-- <div class="sorting">
               <h6>Showing</h6>
               <select id="country2" onchange="change_country(this.value)" class="frm-field required sect">
                  <option value="null">7</option>
                  <option value="null">14</option>
                  <option value="null">28</option>
                  <option value="null">35</option>
               </select>
               <div class="clearfix"></div>
            </div> -->
            <div class="clearfix"></div>
         </div>
         <div class="men-wear-top">
            <div  id="top" class="callbacks_container">
               <ul class="rslides" id="slider3">
                  <li>
                     <img class="img-responsive" src="<?php echo base_url('asset/default_images/banner4.jpg');?>" alt=" "/>
                  </li>
                  <li>
                     <img class="img-responsive" src="<?php echo base_url('asset/') ?>default_images/banner3.jpg" alt=" "/>
                  </li>
                  <li>
                     <img class="img-responsive" src="<?php echo base_url('asset/') ?>default_images/banner1.jpg" alt=" "/>
                  </li>
               </ul>
            </div>
            <div class="clearfix"></div>
         </div>
         
      </div>
      <div class="clearfix"></div>
      <div class="single-pro" id="product_div">
         <!-- <div class="col-md-3 product-men">
            <div class="men-pro-item simpleCart_shelfItem">
               <div class="men-thumb-item">
                  <img src="images/w1.jpg" alt="" class="pro-image-front">
                  <img src="images/w1.jpg" alt="" class="pro-image-back">
                  <div class="men-cart-pro">
                     <div class="inner-men-cart-pro">
                        <a href="single.html" class="link-product-add-cart">Quick View</a>
                     </div>
                  </div>
                  <span class="product-new-top">New</span>
               </div>
               <div class="item-info-product ">
                  <h4><a href="single.html">A-line Black Skirt</a></h4>
                  <div class="info-product-price">
                     <span class="item_price">$130.99</span>
                     <del>$189.71</del>
                  </div>
               </div>
            </div>
         </div> -->
      </div>
      <div class="clearfix"></div>
      </div>
   </div>

<script type="text/javascript">
   $(function () {
   				 // Slideshow 4
   				$("#slider3").responsiveSlides({
   					auto: true,
   					pager: true,
   					nav: false,
   					speed: 500,
   					namespace: "callbacks",
   					before: function () {
   				$('.events').append("<li>before event fired.</li>");
   				},
   				after: function () {
   					$('.events').append("<li>after event fired.</li>");
   					}
   					});
   				});
   $(document).ready(function() {
   	$().UItoTop({ easingType: 'easeOutQuart' });
      get_products();
   						
   });
   jQuery(document).ready(function($) {
     
      $(".scroll").click(function(event){		
      	event.preventDefault();
      	$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
      });

      $( "#slider-range" ).slider({
                           range: true,
                           min: 0,
                           max: 9000,
                           values: [ 100, 5000 ],
                           slide: function( event, ui ) {  $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                           },
                           change: function(e,ui){
        //Do something with ui.value
        get_products();
    } 
                   });
                  
      $( "#amount" ).val( "Rs" + $( "#slider-range" ).slider( "values", 0 ) + " - Rs" + $( "#slider-range" ).slider( "values", 1 ) );

      $('#from_amount').val($( "#slider-range" ).slider( "values", 0 ));
      $('#to_amount').val($( "#slider-range" ).slider( "values", 1 ));

   });
   $(window).load(function(){

   
   					});//]]>  
   
   paypal.minicart.render({
   action: '#'
   });
   
   if (~window.location.search.indexOf('reset=true')) {
   paypal.minicart.reset();
   }

   function get_products(){
      var category_id  =$("input[type='radio']:checked").val();
      console.log('ca',category_id);
      if(category_id == undefined){
         category_id  = $('#default_category_id').val();
      }
      var filter_data  = $('#filter_data').val();
      var from_amount = $('#from_amount').val();
      var to_amount = $('#to_amount').val();
      console.log("1",category_id);
      console.log("2",filter_data);
      console.log("3",from_amount);
      console.log("4",to_amount);

      //return false;
      $.ajax({
            url: "<?php echo site_url('front/get_product')?>",
            data: {
                filter_data : filter_data,
                category_id:category_id,
                from_amount:from_amount,
                to_amount : to_amount
            },
            type: "POST",
            beforeSend: function() {
        // setting a timeout
        $('#product_div').html('');
                 $('#product_div').html('<i class="fa fa-spinner" aria-hidden="true"></i>');
             },
            success:function(result){
               $('#product_div').html('');
               $('#product_div').html(result);
               // $('#sequence').val(result);
            }
    });
   } 
</script>