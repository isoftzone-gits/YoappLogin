<style>
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
</style>

<div class="content-wrapper">
<!-- <div class="content-wrapper"> -->
    <section class="content-header">
      <h1>
        Payment Options
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
                <div class="panel-heading"> <a class="btn btn-primary" href="#"><i class="fa fa-th-list"><span class="text-align">Payment Settings</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php echo site_url('admin/payment_settings'); ?>" class="registration_form1" enctype="multipart/form-data">

                                <div class="box-body">                               
                                    <div class="form-group">
                                        <label class="col-md-2">Client Id * </label>
                                        <div class="col-md-6">
                                            <input type="text" name="client_id" id="client_id" class="form-control" value="<?php if(!empty($payment_settings[0]->client_id)){echo $payment_settings[0]->client_id;}else{ echo set_value('client_id');}?>" placeholder="Enter Client Secret" >
                                            <span class="red"><?php echo form_error('client_id'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Client Secret * </label>
                                        <div class="col-md-6">
                                            <input type="text" name="client_secret" id="client_secret" class="form-control" value="<?php if(!empty($payment_settings[0]->client_secret)){echo $payment_settings[0]->client_secret;}else{ echo set_value('client_secret');}?>"  placeholder="Enter Client Secret">
                                            <span class="red"><?php echo form_error('client_secret'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Status * </label>
                                        <div class="col-md-6">
                                            <div class="switch_box box_1">
                                                <input type="checkbox" class="switch_1" name="status" value="1" <?php if(!empty($payment_settings[0]->status) && $payment_settings[0]->status==1){ ?> checked='checked' <?php } ?>>
                                            </div>
                                            <span class="red" id="status_error"><?php echo form_error('status'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">User Defined Name  </label>
                                        <div class="col-md-6">
                                            <input type="text" name="user_defined_name" id="user_defined_name" class="form-control" value="<?php if(!empty($payment_settings[0]->user_defined_name)){echo $payment_settings[0]->user_defined_name;}else{ echo set_value('user_defined_name');}?>"  placeholder="Enter Name to Display in App">
                                            <span class="red"><?php echo form_error('client_secret'); ?></span>
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
