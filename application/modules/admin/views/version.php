<div class="content-wrapper">
    <section class="content-header">
      <h1>
        App Version 
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
                            <form role="form" method="post" action="<?php echo site_url('admin/version'); ?>" class="registration_form1" enctype="multipart/form-data">

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Version Code</label>
                                        <div class="col-md-6">
                                            <input type="text" name="version_code" id="version_code" class="form-control"  maxlength="30" placeholder="Enter Version Code">
                                            <span class="red"><?php echo form_error('version_code'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Version Name</label>
                                        <div class="col-md-6">
                                            <input type="text" name="version_name" id="version_name" class="form-control"  maxlength="30" placeholder="Enter Version Name">
                                            <span class="red"><?php echo form_error('version_name'); ?></span>
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

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="version">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Sr.no</th>
                                    <th>Version Code</th>
                                    <th>Version Name</th>
                                    <th>Created_At</th>
                                    <th>Action</th>
                                   </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count=1;
                                if(isset($version)){
                                foreach ($version as  $value) { ?>
                                <tr class="odd gradeX" id="tr_<?php echo $count;?>">
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                   
                                    <td>
                                        <?php echo $value->versioncode; ?>
                                    </td>  
                                    <td>
                                      <?php echo $value->versionname; ?>
                                    </td>
                                    <td>
                                        <?php echo $value->created_at; ?>
                                    </td>               
                                   
                                    <td class="center" style="width: 10px;">
                                    
                                       <a title="Delete" href="javascript:void(0)" onclick="delete_version('<?php echo $value->id?>','<?php echo $count;?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true" style="margin-right: 5px;"></i>Delete</a>
                                         </td>
                                   </tr>
                                <?php $count++; } }?> </tbody>
                        </table>
                        
                    </div>
                    <!-- /.table-responsive -->
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
  function delete_version(id,tr_id) {
    swal({
        title: "Are you sure?",
        text: "you want to delete?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: "Yes, Delete it!",
        confirmButtonColor: "#ec6c62"
    }, function() {
        $.ajax({
            url: "<?php echo site_url('admin/delete')?>",
            data: {
                id: id,
                table:'version'
            },
            type: "POST"
        }).done(function(data) {
            swal("Deleted!", "Record was successfully deleted!", "success");
            $('#tr_' + tr_id).remove();
        }).error(function(data) {
            swal("Oops", "We couldn't connect to the server!", "error");
        });
    });
}
</script>