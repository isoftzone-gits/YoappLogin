<div class="content-wrapper">
    <section class="content-header">
      <h1>
        App Theme
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
                            <form role="form" method="post" action="<?php echo site_url('admin/app_theme'); ?>" class="registration_form1" enctype="multipart/form-data">

                                <!-- <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Tag Line</label>
                                        <div class="col-md-6">
                                            <input type="text" name="punch_line" id="punch_line" class="form-control" value="<?php if(!empty($app_theme[0]->punch_line)){echo $app_theme[0]->punch_line;}else{ echo set_value('punch_line');}?>" maxlength="30" placeholder="Enter Tag Line">
                                            <span class="red"><?php echo form_error('punch_line'); ?></span>
                                        </div>
                                    </div>
                                </div> -->
                                
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">App Theme</label>
                                        <div class="col-md-6">
                                            <input type="text" name="theme_color" id="theme_color" class="jscolor {value:'<?php if(!empty($app_theme[0]->theme_color)){echo $app_theme[0]->theme_color;}else{ echo '66CCFF';}?>'} form-control" value="<?php if(!empty($app_theme[0]->theme_color)){echo $app_theme[0]->theme_color;}else{ echo set_value('theme_color');}?>">
                                            
                                            <span class="red"><?php echo form_error('theme_color'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Company Logo</label>
                                        <div class="col-md-6">
                                            <input type="file" name="logo" id="logo">
                                            
                                            <span class="red"><?php echo form_error('logo'); ?></span>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2"></label>
                                        <div class="col-md-6">
                                            <?php if(!empty($app_theme[0]->logo)){ ?>
                                            <img src="<?php echo base_url('asset/uploads/').$app_theme[0]->logo; ?>" width="50px" height="50" class="rounded">
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Note: </label>
                                        <div class="col-md-6">
                                            <span class="text-success" style="font-weight: bold;">
                                                Standard logo size must be <span class="text-danger">512 x 512</span> pixels.
                                            </span>
                                        </div>
                                    </div>
                                </div> -->

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