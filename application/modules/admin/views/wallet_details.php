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
            Wallet Details
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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('admin/wallet_details_list')?>"><i class="fa fa-th-list"><span class="text-align">Wallet Details LIST</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php if(!empty($wallet_details[0])){ echo site_url('admin/wallet_details/'.$wallet_details[0]->id);}else{echo site_url('admin/wallet_details');} ?>" class="registration_form1" enctype="multipart/form-data" onSubmit="return validate();">

                            <div class="box-body">    
                                <div class="form-group">
                                    <label class="col-md-2">Wallet TYPE * </label>
                                    <div class="col-md-6">
                                        <select class="niceSelect wide" id="wallet_type" name="wallet_type">
                                            
                                                <option value="registration" 
                                                    <?php if(!empty($wallet_details[0]) &&  $wallet_details[0]->wallet_type=='registration'){ echo 'selected';} ?>>REGISTRATION</option> 
                                                <option value="referal" 
                                                    <?php if(!empty($wallet_details[0]) &&  $wallet_details[0]->wallet_type=='referal'){ echo 'selected';} ?>>REFEREAL</option>
                                        </select>
                                        <span class="red" id="wallet_type_error"><?php echo form_error('wallet_type'); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Status * </label>
                                    <div class="col-md-6">
                                        <div class="switch_box box_1">
                                            <input type="checkbox" class="switch_1" name="status" value="1" <?php if(!empty($wallet_details[0]->status) && $wallet_details[0]->status==1){ ?> checked='checked' <?php } ?>>
                                        </div>
                                        <span class="red" id="sender_id_error"><?php echo form_error('sender_id'); ?></span>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Amount * </label>
                                    <div class="col-md-6">
                                        <input type="numberd" name="amount" id="amount" class="form-control" value="<?php if(!empty($wallet_details[0]->amount)){echo $wallet_details[0]->amount;}else{ echo set_value('amount');}?>" maxlength="30">
                                        <span class="red" id="amount_error"><?php echo form_error('amount'); ?></span>
                                    </div>
                                </div>
                            </div>


                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Valid From *</label>
                                    <div class="col-md-6">
                                        <input type="text" name="valid_from" id="valid_from" class="form-control date" value="<?php if(!empty($wallet_details[0]->valid_from)){echo $wallet_details[0]->valid_from;}else{ echo set_value('valid_from');}?>">
                                        <span class="red" id="valid_from_error"><?php echo form_error('valid_from'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Valid To *</label>
                                    <div class="col-md-6">
                                        <input type="text" name="valid_to" id="valid_to" class="form-control date" value="<?php if(!empty($wallet_details[0]->valid_to)){echo $wallet_details[0]->valid_to;}else{ echo set_value('valid_to');}?>">
                                        <span class="red" id="valid_to_error"><?php echo form_error('valid_to'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">REDEEM PER % *</label>
                                    <div class="col-md-6">
                                        <input type="number" name="redeem_per" id="redeem_per" class="form-control " value="<?php if(!empty($wallet_details[0]->redeem_per)){echo $wallet_details[0]->redeem_per;}else{ echo set_value('redeem_per');}?>">
                                        <span class="red" id="redeem_per_error"><?php echo form_error('redeem_per'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Valid Upto(No of Days)*</label>
                                    <div class="col-md-6">
                                        <input type="number" name="valid_upto" id="redeem_per" class="form-control " value="<?php if(!empty($wallet_details[0]->valid_upto)){echo $wallet_details[0]->valid_upto;}else{ echo set_value('valid_upto');}?>">
                                        <span class="red" id="valid_upto_error"><?php echo form_error('valid_upto'); ?></span>
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