<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
   <section class="content-header">
       <h1>
           Terms & Conditions
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
                            <form role="form" method="post" action="<?php if(!empty($terms_conditions[0])){ echo site_url('admin/terms_conditions/'.$terms_conditions[0]->id);}else{echo site_url('admin/terms_conditions');} ?>" class="registration_form1" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-2">Terms & Conditions* </label>
                                    <div class="col-lg-6">
                                        <textarea type="text" name="terms_conditions" id="terms_conditions" class="form-control" rows="20"><?php if(!empty($terms_conditions[0]->terms_conditions)){echo $terms_conditions[0]->terms_conditions;}else{ echo set_value('terms_conditions');}?></textarea>
                                        <script type="text/javascript">
                                                CKEDITOR.replace('terms_conditions');
                                            </script>
                                        <span class="red"><?php echo form_error('about'); ?></span>
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