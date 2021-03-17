<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Contact Us
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
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php if(!empty($contact_us[0])){ echo site_url('admin/contact_us/'.$contact_us[0]->id);}else{echo site_url('admin/contact_us');} ?>" class="registration_form1" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-2">Contact Us * </label>
                                    <div class="col-lg-6">
                                        <textarea type="text" name="contact_us" id="contact_us" class="form-control" rows="20"><?php if(!empty($contact_us[0]->contact_us)){echo $contact_us[0]->contact_us;}else{ echo set_value('contact_us');}?></textarea>
                                        <script type="text/javascript">
                                                CKEDITOR.replace('contact_us');
                                            </script>
                                        <span class="red"><?php echo form_error('contact_us'); ?></span>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="col-md-12" align="center" style="margin-top: 10px;">
                                    <button type="submit" value="Save" id="submit" class="btn btn-success">Save</button>
                                    <input type="reset" class="btn btn-default" value="Reset"> </div>
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
</script>