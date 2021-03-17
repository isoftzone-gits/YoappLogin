<div class="content-wrapper">
<!-- <div class="content-wrapper"> -->
    <section class="content-header">
      <h1>
        Delivery Range
      </h1>
    </section>
    <!-- /.row -->

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <?php if(!empty($msg)){?>
            <div class="alert alert-success">
                <?php echo $msg;?> </div>
            <?php }?>
            <?php if ($info_message = $this->session->flashdata('info_message')): ?>
            <div id="form-messages" class="alert alert-success" role="alert">
                <?php echo $info_message; ?> </div>
            <?php endif ?>
            <div class="panel panel-default">
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php echo site_url('admin/delivery_range'); ?>" class="registration_form1" enctype="multipart/form-data" onSubmit="return validate();">

                                <div class="box-body">                               
                                    <div class="form-group">
                                        <label class="col-md-3">Delivery Range(In Km) * </label>
                                        <div class="col-md-6" id="delivery_div">
                                            <input type="checkbox" name="delivery_range_checkbox" value="unlimited" id="delivery_checkbox" <?php if(!empty($delivery_range)) { 
                                            	if($delivery_range[0]->value=='unlimited'){ ?> checked="checked" 
                                            	<?php }
                                            	}else{ ?> checked='checked'  <?php } ?>>&nbsp;<b>UnLimited</b>
                                            <input type="hidden" name="test" value="1">

                                        </div>
                                        <div class="col-md-6" id="delivery_day_div"  <?php if(!empty($delivery_range)) { 
                                            	if($delivery_range[0]->value=='unlimited'){ ?> style="display: none"
                                            	<?php }
                                            	}else{ ?> style="display: none"  <?php } ?>>
                                            <input type="text" name="delivery_range_text"  id="delivery_text" placeholder="kms" value="<?php if(!empty($delivery_range)){ echo $delivery_range[0]->value;} ?>">
                                             <span class="red"><?php echo form_error('delivery_range'); ?></span>
                                        </div>
                                       
                                    </div>
                                </div>

                                
                                <div class="col-md-12" align="center" style="margin-bottom: 20px;">
                                    <button type="submit" value="Save" id="submit" class="btn btn-success">Save</button>
                                    <input type="reset" class="btn btn-default" value="Reset"> 
                                </div>
                            </form>
                        </div>
                        
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- row -->
</section>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("input[type='checkbox']").change(function(){
			if($(this).is(":checked")){
				$('#delivery_day_div').hide();
			}else{
				$('#delivery_text').val('');
				$('#delivery_day_div').show();
			}
		});
	});

	function validate() {
   		if($('#delivery_checkbox').is(":checked")){
			return true;
		}else{
			var text_value = $('#delivery_text').val();
			if(text_value==''){
				$('.red').text('Please Enter delivery Km');
				return false;
			}
		}
	}
</script>
