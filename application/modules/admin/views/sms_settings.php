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
            SMS SETTINGS
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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('admin/sms_settings_list')?>"><i class="fa fa-th-list"><span class="text-align">SMS SETTINGS LIST</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php if(!empty($sms_settings[0])){ echo site_url('admin/sms_settings/'.$sms_settings[0]->id);}else{echo site_url('admin/sms_settings');} ?>" class="registration_form1" enctype="multipart/form-data" onSubmit="return validate();">

                            <div class="box-body">    
                                <div class="form-group">
                                    <label class="col-md-2">SMS TYPE * </label>
                                    <div class="col-md-6">
                                        <select class="niceSelect wide" id="type" name="type">
                                            
                                                <!-- <option value="OTP" 
                                                    <?php //if(!empty($sms_settings[0]) &&  $sms_settings[0]->type=='OTP'){ echo 'selected';} ?>>OTP</option> -->
                                                <option value="ORDER" 
                                                    <?php if(!empty($sms_settings[0]) &&  $sms_settings[0]->type=='ORDER'){ echo 'selected';} ?>>ORDER</option>    
                                               
                                           
                                            
                                        </select>
                                        <span class="red" id="type_error"><?php echo form_error('type'); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Status * </label>
                                    <div class="col-md-6">
                                        <div class="switch_box box_1">
                                            <input type="checkbox" class="switch_1" name="status" value="1" <?php if(!empty($sms_settings[0]->status) && $sms_settings[0]->status==1){ ?> checked='checked' <?php } ?>>
                                        </div>
                                        <span class="red" id="sender_id_error"><?php echo form_error('sender_id'); ?></span>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Sender Id * </label>
                                    <div class="col-md-6">
                                        <input type="text" name="sender_id" id="sender_id" class="form-control" value="<?php if(!empty($sms_settings[0]->sender_id)){echo $sms_settings[0]->sender_id;}else{ echo set_value('sender_id');}?>" maxlength="30">
                                        <span class="red" id="sender_id_error"><?php echo form_error('sender_id'); ?></span>
                                    </div>
                                </div>
                            </div>


                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Auth Key *</label>
                                    <div class="col-md-6">
                                        <input type="text" name="auth_key" id="auth_key" class="form-control" value="<?php if(!empty($sms_settings[0]->auth_key)){echo $sms_settings[0]->auth_key;}else{ echo set_value('auth_key');}?>">
                                        <span class="red" id="auth_key_error"><?php echo form_error('auth_key'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">URL</label>
                                    <div class="col-md-6">
                                         <input type="text" name="url" id="url" class="form-control" value="<?php if(!empty($sms_settings[0]->url)){echo $sms_settings[0]->url;}else{ echo set_value('url');}?>">
                                        <span class="red" id="url_error"><?php echo form_error('url'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Message*</label>
                                    <div class="col-md-6">
                                        <textarea name="message" id="message" class="form-control"><?php if(!empty($sms_settings[0]->message)){echo $sms_settings[0]->message;}else{ echo set_value('message');}?></textarea>
                                        <span class="red" id="message_error"><?php echo form_error('message'); ?></span>
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
       var sender_id  = $('#sender_id').val();
       if(sender_id==''){
         $('#sender_id_error').text('SENDER Id Required');
         return false;
       }

       var auth_key  = $('#auth_key').val();
       if(auth_key==''){
        $('#auth_key_error').text('Auth Key is Required');
        return false;
       }

       var url  = $. trim($('#url').val());
       if(url==''){
        $('#url_error').text('URL is Required');
        return false;
       }

       var message  = $. trim($('#message').val());
       if(message==''){
        $('#message_error').text('Message is Required');
        return false;
       }

    }
</script>