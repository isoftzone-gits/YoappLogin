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
  <div class="banner_bottom_agile_info">
	    <div class="container">
			<?php if(!empty($about[0]->about)){
				echo $about[0]->about;
			}else{ ?>
				<h1>Content Will Be Updated Soon</h1>
			<?php } ?>
		 </div> 
    </div> 
    <div class="clearfix"></div>
    <script type="text/javascript">
    	$(document).ready(function(){
    		console.log('gggg');
    		$('.menu__item').removeClass('active');
    		$('.menu__item').removeClass('menu__item--current');
    		$('.about').addClass('active');
    		$('.about').addClass('menu__item--current');
    	});
    </script>