<div class="content-wrapper">
    <section class="content-header">
        <h1>
            DataBase
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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('admin/database_list')?>"><i class="fa fa-th-list"><span class="text-align">Database List</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php if(!empty($database[0])){ echo site_url('admin/database/'.$database[0]->id);}else{echo site_url('admin/database');} ?>" class="registration_form1" id="category_form" enctype="multipart/form-data" >

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Site Name * </label>
                                        <div class="col-md-6">
                                            <input type="text" name="site_name" id="site_name" class="form-control" value="<?php if(!empty($database[0]->site_name)){echo $database[0]->site_name;}else{ echo set_value('site_name');}?>" maxlength="30">
                                            <span class="red" id="site_name_error"><?php echo form_error('site_name'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Database Name*</label>
                                        <div class="col-md-6">
                                           
                                            <input type="text" name="db_name" id="db_username" class="form-control" value="<?php if(!empty($database[0]->db_name)){echo $database[0]->db_username;}else{ echo   set_value('db_name'); }?>">
                                            
                                            <span class="red" id="db_name_error"><?php echo form_error('db_name'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">DB UserName</label>
                                        <div class="col-md-6">
                                            <input type="text" name="db_username" id="db_username" class="form-control" value="<?php if(!empty($database[0]->db_username)){echo $database[0]->db_username;}else{ echo   set_value('db_username'); }?>">
                                            
                                            <span class="red" id="db_username_error"><?php echo form_error('db_username'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">DB Password *</label>
                                        <div class="col-md-6">
                                            <input type="text" name="db_password" id="db_password" class="form-control" value="<?php if(!empty($database[0]->db_password)){echo $database[0]->db_password;}else{ echo   set_value('db_password'); }?>">
                                            
                                            <span class="red" id="db_password_error"><?php echo form_error('db_password'); ?></span>
                                        </div>
                                    </div>
                                </div>

                               

                                <div class="col-md-12" align="center">
                                    <button type="submit" value="Save" id="submit" class="btn btn-success save">Save</button>
                                    <input type="reset" class="btn btn-default" value="Reset"> </div>
                            </form>
                            
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