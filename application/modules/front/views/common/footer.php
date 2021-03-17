<div class="footer">
   <div class="footer_agile_inner_info_w3l">
      <div class="col-md-3 footer-left">
          <img src="<?php echo base_url('asset/default_images/logo.png'); ?>">
         <p>
         </p>
         <ul class="social-nav model-3d-0 footer-social w3_agile_social two">
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
      </div>
      <div class="col-md-9 footer-right">
         <div class="sign-grds">
            <div class="col-md-4 sign-gd">
               <h4>Our <span>Information</span> </h4>
               <ul>
                  <li><a href="<?php echo site_url(); ?>">Home</a></li>
                  <li><a href="<?php echo site_url('front/about'); ?>">About</a></li>
                  <li><a href="<?php echo site_url('front/contact'); ?>">Contact</a></li>
               </ul>
            </div>
            <div class="col-md-8 sign-gd-two">
               <h4>Store <span>Information</span></h4>
               <div class="w3-address">
                  <div class="w3-address-grid">
                     <div class="w3-address-left">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                     </div>
                     <div class="w3-address-right">
                        <h6>Phone Number</h6>
                        <p>+91 9833233499</p>
                     </div>
                     <div class="clearfix"> </div>
                  </div>
                  <div class="w3-address-grid">
                     <div class="w3-address-left">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                     </div>
                     <div class="w3-address-right">
                        <h6>Email Address</h6>
                        <p>Email :<a href="mailto:example@email.com"> care@smaarteats.com</a></p>
                     </div>
                     <div class="clearfix"> </div>
                  </div>
                  <!-- <div class="w3-address-grid">
                     <div class="w3-address-left">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                     </div>
                     <div class="w3-address-right">
                        <h6>Location</h6>
                        <p>Broome St, NY 10002,California, USA. 
                        </p>
                     </div>
                     <div class="clearfix"> </div>
                  </div> -->
               </div>
            </div>
          <!--   <div class="col-md-3 sign-gd flickr-post">
               <h4>Flickr <span>Posts</span></h4>
               <ul>
                  <li><a href="single.html"><img src="images/t1.jpg" alt=" " class="img-responsive" /></a></li>
                  <li><a href="single.html"><img src="images/t2.jpg" alt=" " class="img-responsive" /></a></li>
                  <li><a href="single.html"><img src="images/t3.jpg" alt=" " class="img-responsive" /></a></li>
                  <li><a href="single.html"><img src="images/t4.jpg" alt=" " class="img-responsive" /></a></li>
                  <li><a href="single.html"><img src="images/t1.jpg" alt=" " class="img-responsive" /></a></li>
                  <li><a href="single.html"><img src="images/t2.jpg" alt=" " class="img-responsive" /></a></li>
                  <li><a href="single.html"><img src="images/t3.jpg" alt=" " class="img-responsive" /></a></li>
                  <li><a href="single.html"><img src="images/t2.jpg" alt=" " class="img-responsive" /></a></li>
                  <li><a href="single.html"><img src="images/t4.jpg" alt=" " class="img-responsive" /></a></li>
               </ul>
            </div> -->
            <div class="clearfix"></div>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="agile_newsletter_footer" style="display: none;">
         <div class="col-sm-6 newsleft">
            <h3>SIGN UP FOR NEWSLETTER !</h3>
         </div>
         <div class="col-sm-6 newsright">
            <form action="#" method="post">
               <input type="email" placeholder="Enter your email..." name="email" required="">
               <input type="submit" value="Submit">
            </form>
         </div>
         <div class="clearfix"></div>
      </div>
      <!-- <p class="copy-right"></p> -->
   </div>
</div>
<!-- modal inquiry -->
     <div class="modal fade" id="inquiry_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" >
        <h4 class="modal-title w-100 font-weight-bold">Write to us</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fa fa-user prefix grey-text"></i>
          <input type="text" id="name" name="name"  class="form-control validate" placeholder="Name" required="required">
          <label data-error="wrong" data-success="right" for="name">Your name</label>
        </div>

        <div class="md-form mb-5">
          <i class="fa fa-envelope prefix grey-text"></i>
          <input type="email" id="email" class="form-control validate" placeholder="E-mail" required="required">
          <label data-error="wrong" data-success="right" for="email">Your email</label>
        </div>

        <div class="md-form mb-5">
          <i class="fa fa-tag prefix grey-text"></i>
          <input type="text" id="phone" class="form-control validate" placeholder="Mobile Number" required="required">
          <label data-error="wrong" data-success="right" for="phone">Mobile Number</label>
        </div>

        <div class="md-form">
          <i class="fa fa-pencil prefix grey-text"></i>
          <textarea type="text" id="message" class="md-textarea form-control" rows="4"></textarea>
          <label data-error="wrong" data-success="right" for="message">Your message</label>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-unique" onclick="send_inquiry()" id="inq_btn">Send <i class="fa fa-paper-plane-o ml-1"></i></button>
      </div>
    </div>
  </div>
</div>


      <!-- modal inquiry -->

      <div class="success message">
  <h3>Thank You for showing interest in our product</h3>
  <p>We wil get in touch with you soon .</p>

</div>
<a href="#home" class="scroll" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!-- js -->
<script>
   // Mini Cart
   // paypal.minicart.render({
   //     action: '#'
   // });
   
   // if (~window.location.search.indexOf('reset=true')) {
   //     //paypal.minicart.reset();
   // }
</script>
<!-- //cart-js --> 
<!-- script for responsive tabs -->                     
<script src="<?php echo base_url('asset/dist/js/easy-responsive-tabs.js')?>"></script>
<script>
   $(document).ready(function () {
   $('#horizontalTab').easyResponsiveTabs({
   type: 'default', //Types: default, vertical, accordion           
   width: 'auto', //auto or any width like 600px
   fit: true,   // 100% fit in a container
   closed: 'accordion', // Start closed if in accordion view
   activate: function(event) { // Callback function if tab is switched
   var $tab = $(this);
   var $info = $('#tabInfo');
   var $name = $('span', $info);
   $name.text($tab.text());
   $info.show();
   }
   });
   $('#verticalTab').easyResponsiveTabs({
   type: 'vertical',
   width: 'auto',
   fit: true
   });
   });
</script>
<!-- //script for responsive tabs -->       
<!-- stats -->
<script src="<?php echo base_url('asset/dist/js/jquery.waypoints.min.js')?>"></script>
<script src="<?php echo base_url('asset/dist/js/jquery.countup.js')?>"></script>
<script>
   $('.counter').countUp();
</script>
<!-- //stats -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="<?php echo base_url('asset/dist/js/move-top.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('asset/dist/js/jquery.easing.min.js')?>"></script>
<script type="text/javascript">
   jQuery(document).ready(function($) {
       $(".scroll").click(function(event){     
           event.preventDefault();
           $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
       });
   });
</script>
<!-- here stars scrolling icon -->
<script type="text/javascript">
   $(document).ready(function() {
       /*
           var defaults = {
           containerID: 'toTop', // fading element id
           containerHoverID: 'toTopHover', // fading element hover id
           scrollSpeed: 1200,
           easingType: 'linear' 
           };
       */
                           
       $().UItoTop({ easingType: 'easeOutQuart' });
             
      $('.message').click(function(){           
    $(this).animate({top: -$(this).outerHeight()}, 500);
  });                         
       });

   function send_inquiry(){
      var name     = $('#name').val();
      var email    = $('#email').val();
      var phone    = $('#phone').val();
      var message  = $('#message').val();
      if(name=='' || name == undefined){
        $('#name').css('border-color','red');
        return false;
      }
      if(email=='' || email == undefined){
        $('#email').css('border-color','red');
         return false;
      }
      if(phone=='' || phone == undefined){
        $('#phone').css('border-color','red');
         return false;
      }
      $.ajax({
            url: "<?php echo site_url('front/insert_inquiry')?>",
            data: {
                'name'       : name,
                'email'      : email,
                'phone'      : phone,
                'message'    : message
            },
            type: "POST",
            beforeSend: function() {
               $('#inq_btn').prop('disabled', true);
            },
            success:function(result){
              $('#inquiry_modal').modal('hide');
              showMessage('success');
              setTimeout(function(){  hideAllMessages(); }, 1000);
            }
    });
   }
   var myMessages = ['info','warning','error','success']; // define the messages types     
function hideAllMessages()
{
  var messagesHeights = new Array(); // this array will store height for each

  for (i=0; i<myMessages.length; i++)
  {
    messagesHeights[i] = $('.' + myMessages[i]).outerHeight();
    $('.' + myMessages[i]).css('top', -messagesHeights[i]); //move element outside viewport    
  }
}

function showMessage(type)
{
    
    hideAllMessages(); 
    $('.'+type).animate({top:"0"}, 500);
  
              
   
}


      function show_modal(){
         $('#inquiry_modal').modal('show');  
       }

       function open_modal(id){
        if(id=='in'){

         $('#myModal').modal('show');  
        }else{
          $('#myModal2').modal('show');  
        }
       }

</script>
<!-- //here ends scrolling icon -->
<!-- for bootstrap working -->
</body>
</html>