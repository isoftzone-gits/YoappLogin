 <div class="clearfix"></div>
 <!-- banner-bootom-w3-agileits -->
<div class="banner-bootom-w3-agileits">
	<div class="container">
	     <div class="col-md-4 single-right-left ">
			<div class="grid images_3_of_2">
				<div class="flexslider">
					
					<ul class="slides">
						<?php
							$p_image  = $product[0]->product_image;
							if(!empty($p_image)){
								$images  = @unserialize($product[0]->product_image); 
	                        	$images  = !empty($images)?$images:[]; 
							}

							foreach ($images as $key => $value) {
						?>
						<li data-thumb="<?php echo base_url('asset/uploads/').@$value; ?>">
							<div class="thumb-image"> <img src="<?php echo base_url('asset/uploads/').@$value; ?>" data-imagezoom="true" class="img-responsive"> </div>
						</li>
						<?php } ?>
						
					</ul>
					<div class="clearfix"></div>
				</div>	
			</div>
		</div>
		<div class="col-md-8 single-right-left simpleCart_shelfItem">
					<h3><?php echo $product[0]->product_name; ?></h3>
					<!-- <p><span class="item_price">Rs. <?php echo $product[0]->sell_price; ?></span> <del>-Rs. <?php echo $product[0]->product_price; ?></del></p> -->
					<!-- <div class="rating1">
						<span class="starRating">
							<input id="rating5" type="radio" name="rating" value="5">
							<label for="rating5">5</label>
							<input id="rating4" type="radio" name="rating" value="4">
							<label for="rating4">4</label>
							<input id="rating3" type="radio" name="rating" value="3" checked="">
							<label for="rating3">3</label>
							<input id="rating2" type="radio" name="rating" value="2">
							<label for="rating2">2</label>
							<input id="rating1" type="radio" name="rating" value="1">
							<label for="rating1">1</label>
						</span>
					</div> -->
					<!-- <div class="description">
						<h5>Check delivery, payment options and charges at your location</h5>
						 <form action="#" method="post">
						<input type="text" value="Enter pincode" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Enter pincode';}" required="">
						<input type="submit" value="Check">
						</form>
					</div> -->
					<br/>
					<div class="color-quality">
						<div class="color-quality-right">
							<!-- <h5><b>Size :</b> <?php echo $product[0]->size; ?></h5> -->
							<h5><b>Size : </b>
							<select id="p_attr" name="p_attr" onchange="get_price(this)">
							<?php if(!empty($attributes)){
								foreach ($attributes as $key => $value) { ?>
								<option value="?php echo $value->id; ?>" data-mrp="<?php echo $value->product_price; ?>" data-sell="<?php echo $value->sell_price; ?>"><?php echo $value->product_attributes; ?></option>	
							<?php	} ?>
							</select>
							</h5>
							
						</div>
					</div>
					<br/>
					<div class="color-quality">
						<div class="color-quality-right">
							<h5><b>Price :</b>
							<span class="item_price" id="sell">Rs<?php echo $attributes[0]->sell_price; ?></span> <del id="mrp">- Rs<?php echo $attributes[0]->product_price; ?></del>
							<?php } ?></h5>
						</div>
					</div>
					<br/>
					<?php if(!empty($product[0]->brand)){ ?>
					<div class="color-quality">
						<div class="color-quality-right">
							<h5><b>Brand :</b> <?php echo $product[0]->brand; ?></h5>
							
						</div>
					</div>
				    <br/>
					<?php } ?>

					<?php if(!empty($product[0]->weight)){ ?>
					<div class="color-quality">
						<div class="color-quality-right">
							<h5><b>Weight :</b> <?php echo $product[0]->weight; ?></h5>
							
						</div>
					</div>
					<br/>
					<?php } ?>
					
					<div class="color-quality">
						<div class="color-quality-right">
							<h5><b>Quality :  </b>  <select id="country1" onchange="change_country(this.value)" class="frm-field required sect">
								<?php for ($i=1; $i <10 ; $i++) { ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?> Qty</option>
								<?php } ?>
							</select></h5>
							
						</div>
					</div>

					
					<!-- <div class="occasional">
						<h5>Types :</h5>
						<div class="colr ert">
							<label class="radio"><input type="radio" name="radio" checked=""><i></i>Casual Shoes</label>
						</div>
						<div class="colr">
							<label class="radio"><input type="radio" name="radio"><i></i>Sneakers </label>
						</div>
						<div class="colr">
							<label class="radio"><input type="radio" name="radio"><i></i>Formal Shoes</label>
						</div>
						<div class="clearfix"> </div>
					</div> -->
					<!-- <div class="occasion-cart">
						<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out button2">
															<form action="#" method="post">
																<fieldset>
																	<input type="hidden" name="cmd" value="_cart">
																	<input type="hidden" name="add" value="1">
																	<input type="hidden" name="business" value=" ">
																	<input type="hidden" name="item_name" value="Wing Sneakers">
																	<input type="hidden" name="amount" value="650.00">
																	<input type="hidden" name="discount_amount" value="1.00">
																	<input type="hidden" name="currency_code" value="USD">
																	<input type="hidden" name="return" value=" ">
																	<input type="hidden" name="cancel_return" value=" ">
																	<input type="submit" name="submit" value="Add to cart" class="button">
																</fieldset>
															</form>
														</div>
																			
					</div> -->
					<div class="occasion-cart">
					<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out button2" onclick="show_modal()">
                                     Inquiry
                                    </div></div>
					<!-- <ul class="social-nav model-3d-0 footer-social w3_agile_social single_page_w3ls">
						                                   <li class="share">Share On : </li>
															<li><a href="#" class="facebook">
																  <div class="front"><i class="fa fa-facebook" aria-hidden="true"></i></div>
																  <div class="back"><i class="fa fa-facebook" aria-hidden="true"></i></div></a></li>
															<li><a href="#" class="twitter"> 
																  <div class="front"><i class="fa fa-twitter" aria-hidden="true"></i></div>
																  <div class="back"><i class="fa fa-twitter" aria-hidden="true"></i></div></a></li>
															<li><a href="#" class="instagram">
																  <div class="front"><i class="fa fa-instagram" aria-hidden="true"></i></div>
																  <div class="back"><i class="fa fa-instagram" aria-hidden="true"></i></div></a></li>
															<li><a href="#" class="pinterest">
																  <div class="front"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
																  <div class="back"><i class="fa fa-linkedin" aria-hidden="true"></i></div></a></li>
														</ul> -->
					
		      </div>
	 			<div class="clearfix"> </div>
				<!-- /new_arrivals --> 
	<div class="responsive_tabs_agileits"> 
				<div id="horizontalTab">
						<ul class="resp-tabs-list">
							<li>Description</li>.
							<?php if(!empty( $product[0]->ingredients)){ ?>
							<li>InGredients	</li><?php } ?>
							<?php if(!empty( $product[0]->usage_Instructions)){ ?>
							<li>Usage Instructions</li><?php } ?>
						</ul>
					<div class="resp-tabs-container">
					<!--/tab_one-->
					   <div class="tab1">

							<div class="single_page_agile_its_w3ls">
							  
							   <p><?php echo $product[0]->product_description; ?></p>
							</div>
						</div>
						<!--//tab_one-->
						<?php if(!empty( $product[0]->ingredients)){ ?>
						<div class="tab2">
							
							<div class="single_page_agile_its_w3ls">
								<p><?php echo $product[0]->ingredients; ?></p>
															 </div>
						 </div>
						<?php } ?>
						<?php if(!empty( $product[0]->usage_Instructions)){ ?>
						   <div class="tab3">

							<div class="single_page_agile_its_w3ls">
								<p><?php echo $product[0]->usage_Instructions; ?></p> 
							</div>
						</div>
					<?php } ?>
					</div>
				</div>	
			</div>
	<!-- //new_arrivals --> 
	  	<!--/slider_owl-->
	
			<div class="w3_agile_latest_arrivals">
			<h3 class="wthree_text_info">Featured <span>Arrivals</span></h3>	
					 <?php 
                     if(!empty($related_product)){
                     foreach ($related_product as $skey => $svalue) { ?>
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
					<div class="clearfix"> </div>
					<!--//slider_owl-->
		         </div>
	        </div>
 </div>

						<script>
						// Can also be used with $(document).ready()
							// Restricts input for each element in the set of matched elements to the given inputFilter.

								$('.flexslider').flexslider({
								animation: "slide",
								controlNav: "thumbnails"
								});

								function get_price(el){
								 var mrp  = $(el).find(':selected').attr('data-mrp');
								 var sell  = $(el).find(':selected').attr('data-sell');

								 $('#mrp').text("Rs"+mrp+"");
								 $('#sell').text("Rs"+sell+"");
								}
							
						</script>
<!--//single_page-->