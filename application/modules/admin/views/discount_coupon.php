<style type="text/css">
    .switch_box{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    max-width: 200px;
    min-width: 200px;
    /*height: 200px;*/
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            /*justify-content: center;*/
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
    -webkit-box-flex: 1;
        -ms-flex: 1;
            flex: 1;
}

/* Switch 1 Specific Styles Start */


input[type="checkbox"].switch_1{
    font-size: 30px;
    -webkit-appearance: none;
       -moz-appearance: none;
            appearance: none;
    width: 3.5em;
    height: 1.5em;
    background: #ddd;
    border-radius: 3em;
    position: relative;
    cursor: pointer;
    outline: none;
    -webkit-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
  }
  
  input[type="checkbox"].switch_1:checked{
    background: #0ebeff;
  }
  
  input[type="checkbox"].switch_1:after{
    position: absolute;
    content: "";
    width: 1.5em;
    height: 1.5em;
    border-radius: 50%;
    background: #fff;
    -webkit-box-shadow: 0 0 .25em rgba(0,0,0,.3);
            box-shadow: 0 0 .25em rgba(0,0,0,.3);
    -webkit-transform: scale(.7);
            transform: scale(.7);
    left: 0;
    -webkit-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
  }
  
  input[type="checkbox"].switch_1:checked:after{
    left: calc(100% - 1.5em);
  }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Discount Coupon
        </h1>
    </section>

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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('admin/discount_coupon_list')?>"><i class="fa fa-th-list"><span class="text-align">Discount Coupon LIST</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php if(!empty($discount_coupon[0])){ echo site_url('admin/discount_coupon/'.$discount_coupon[0]->id);}else{echo site_url('admin/discount_coupon');} ?>" class="registration_form1" enctype="multipart/form-data" onSubmit="return validate();">

                            <div class="box-body">    
                                <div class="form-group">
                                    <label class="col-md-2">Coupon Code * </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="coupon_code" placeholder="Enter unique Coupon Code" value="<?php  if(!empty($discount_coupon[0])){
                                        echo $discount_coupon[0]->coupon_code; }else{ echo set_value('coupon_code'); } ?>" <?php if(!empty($discount_coupon[0]->coupon_code)){ ?> readonly="readonly" <?php } ?>>
                                        <span class="red" id="coupon_code_error"><?php echo form_error('coupon_code'); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Status * </label>
                                    <div class="col-md-6">
                                        <div class="switch_box box_1">
                                            <input type="checkbox" class="switch_1" name="status" value="1" <?php if(!empty($discount_coupon[0]->status) && $discount_coupon[0]->status==1){ ?> checked='checked' <?php } ?>>
                                        </div>
                                        <span class="red" id="sender_id_error"><?php echo form_error('sender_id'); ?></span>
                                    </div>
                                </div>
                            </div>


                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Valid From *</label>
                                    <div class="col-md-6">
                                        <input type="text" name="start_date" id="start_date" class="form-control date" value="<?php if(!empty($discount_coupon[0]->start_date)){echo $discount_coupon[0]->start_date;}else{ echo set_value('start_date');}?>" readonly="readonly">
                                        <span class="red" id="valid_from_error"><?php echo form_error('start_date'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Valid To *</label>
                                    <div class="col-md-6">
                                        <input type="text" name="end_date" id="end_date" class="form-control date" value="<?php if(!empty($discount_coupon[0]->end_date)){echo $discount_coupon[0]->end_date;}else{ echo set_value('end_date');}?>" readonly="readonly">
                                        <span class="red" id="valid_to_error"><?php echo form_error('end_date'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body" >
                                <div class="form-group">
                                    <label class="col-md-2">Minimum Bill Amount </label>
                                    <div class="col-md-6">
                                        <input type="number" name="min_amount" id="min_amount" class="form-control " value="<?php if(!empty($discount_coupon[0]->min_amount)){echo $discount_coupon[0]->min_amount;}else{ echo set_value('min_amount');}?>" placeholder="Enter Minimum Bill Amount">
                                        <span class="red" id="min_amount_error"><?php echo form_error('min_amount'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Percentage</label>
                                    <div class="col-md-6">
                                        <input type="checkbox" name="per_check" <?php if(!empty($discount_coupon[0])){
                                        if($discount_coupon[0]->per_check==1){ ?> checked="checked" <?php }}else{ ?>checked="checked" <?php } ?> id="percentage">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-body" id="discount_per_div" <?php if(!empty($discount_coupon[0]) && $discount_coupon[0]->per_check==0){ ?> style="display: none;" <?php } ?>>
                                <div class="form-group">
                                    <label class="col-md-2">Discount PER % </label>
                                    <div class="col-md-6">
                                        <input type="number" name="discount_per" id="discount_per" class="form-control " value="<?php if(!empty($discount_coupon[0]->discount_per)){echo $discount_coupon[0]->discount_per;}else{ echo set_value('discount_per');}?>" placeholder="Enter Percent">
                                        <span class="red" id="redeem_per_error"><?php echo form_error('discount_per'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body" id="per_min_div" <?php if(!empty($discount_coupon[0]) && $discount_coupon[0]->per_check==0){ ?> style="display: none;" <?php } ?>>
                                <div class="form-group">
                                    <label class="col-md-2">Max Amount To Redeem% </label>
                                    <div class="col-md-6">
                                        <input type="number" name="per_min_amount" id="per_min_amount" class="form-control " value="<?php if(!empty($discount_coupon[0]->per_min_amount)){echo $discount_coupon[0]->per_min_amount;}else{ echo set_value('per_min_amount');}?>" placeholder="Enter Max Amount To Redeem">
                                        <span class="red" id="per_min_amount_error"><?php echo form_error('per_min_amount'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body" id="discount_amt_div" <?php if(!empty($discount_coupon[0])){
                                        if($discount_coupon[0]->per_check==1){ ?> style="display: none;" <?php }}else{ ?>style="display: none;" <?php } ?>>
                                <div class="form-group">
                                    <label class="col-md-2">Discount Amount </label>
                                    <div class="col-md-6">
                                        <input type="number" name="discount_amt" id="discount_amt" class="form-control " value="<?php if(!empty($discount_coupon[0]->discount_amt)){echo $discount_coupon[0]->discount_amt;}else{ echo set_value('discount_amt');}?>" placeholder="Enter Amount">
                                        <span class="red" id="discount_amt_error"><?php echo form_error('discount_amt'); ?></span>
                                    </div>
                                </div>
                            </div>

                           
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">No Coupon Redeemed </label>
                                    <div class="col-md-6">
                                        <input type="text" name="coupon_redeemed_no" id="coupon_redeemed_no" class="form-control" value="<?php if(!empty($discount_coupon[0]->coupon_redeemed_no)){echo $discount_coupon[0]->coupon_redeemed_no;}else{ echo set_value('coupon_redeemed_no');}?>" placeholder="No of times coupon redeemed">
                                        <span class="red" id="ccoupon_redeemed_no_error"><?php echo form_error('coupon_redeemed_no'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" align="center">
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
    $(document).ready(function() {
        $('select').niceSelect();
    });

    $('#percentage').on('change',function(){
        if(this.checked) {
            $('#discount_per_div').show();
            $('#per_min_div').show();
            $('#discount_amt_div').hide();
        }else{
            $('#discount_per_div').hide();
            $('#discount_amt_div').show();
            $('#per_min_div').hide();
        }
    });

     function validate() {
       $('.red').text('');
       var amount  = $('#amount').val();
       if(sender_id==''){
         $('#amount_error').text('AMOUNT Required');
         return false;
       }

       var valid_from  = $('#valid_from').val();
       if(valid_from==''){
        $('#valid_from_error').text('VALID FROM is Required');
        return false;
       }

       var valid_to  = $. trim($('#valid_to').val());
       if(valid_to==''){
        $('#valid_to_error').text('VALID TO is Required');
        return false;
       }
       var redeem_per  = $. trim($('#redeem_per').val());
       if(redeem_per==''){
        $('#redeem_per_error').text('REDEEM PER is Required');
        return false;
       }

       var valid_upto  = $. trim($('#valid_upto').val());
       if(valid_upto==''){
        $('#valid_upto_error').text('Valid upto is Required');
        return false;
       }

       

       
    }
</script>