    <footer class="main-footer">
        <strong>Copyright &copy; 2020 <a href="http://isoftzone.com/" target="blank">i-SOFTZONE</a></strong>
    </footer>

</div>    

<!-- <script src="<?php //echo base_url('asset/vendor/bootstrap/js/jquery.min.js');?>"></script> -->
<!-- <script src="<?php //echo base_url('asset/vendor/bootstrap/js/bootstrap.min.js 3.4.1');?>"></script> -->
<script src="<?php echo base_url('asset/vendor/bootstrap/js/adminlte.min.js');?>"></script>
<script src="<?php echo base_url('asset/js/Chart.js');?>"></script>


    <script type="text/javascript">
    	$(".date").datepicker(
    		{
    			format: 'yyyy-mm-dd',
    			//startDate: '+0d',
        		autoclose: true
    		}
    	);

    	var url = '<?php echo base_url();?>';
    </script>


    <?php 
     if(isset($new_orders) && $new_orders > 0 && $this->session->userdata('user_role')!=5){
     ?>
     <script type="text/javascript">
        var total  = "<?php echo $new_orders; ?>";
         swal("New Orders!", "You have "+total+" New Orders!", "success");
     </script>
 <?php } ?>
 
</body>
</html>

