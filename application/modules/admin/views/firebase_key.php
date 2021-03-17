<div class="content-wrapper">
<!-- <div class="content-wrapper"> -->
    <section class="content-header">
      <h1>
        FireBase Key
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
                            <form role="form" method="post" action="<?php echo site_url('admin/firebase_key'); ?>" class="registration_form1" enctype="multipart/form-data">

                                <div class="box-body">                               
                                    <div class="form-group">
                                        <label class="col-md-2">Key * </label>
                                        <div class="col-md-6">
                                            <textarea name="firebase_key" id="firebase_key" class="form-control" rows="5"><?php if(!empty($firebase_key[0])){echo $firebase_key[0]->value;}else{ echo set_value('firebase_key');}?></textarea>
                                            <span class="red"><?php echo form_error('firebase_key'); ?></span>
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
