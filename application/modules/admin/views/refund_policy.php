<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Refund Policy    
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
                            <form role="form" method="post" action="<?php if(!empty($refund_policy[0])){ echo site_url('admin/refund_policy/'.$refund_policy[0]->id);}else{echo site_url('admin/refund_policy');} ?>" class="registration_form1" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-md-2">Refund Policy * </label>
                                    <div class="col-lg-6">
                                        <textarea type="text" name="refund_policy" id="refund_policy" class="form-control" rows="20"><?php if(!empty($refund_policy[0]->refund_policy)){echo $refund_policy[0]->refund_policy;}else{ echo set_value('refund_policy');}?></textarea>
                                        <script type="text/javascript">
                                                CKEDITOR.replace('refund_policy');
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