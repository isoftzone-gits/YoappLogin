<div class="content-wrapper">
  <section class="content-header">
      <h1>
        Excel Upload
      </h1>
    </section>

<section class="content"> 
    <div class="row">
        <div class="col-lg-12">
            <?php if ($info_message = $this->session->flashdata('info_message')): ?>
            <div id="form-messages" class="alert alert-success" role="alert">
                <?php echo $info_message; ?>
            </div>
            <?php endif ?>
            <div class="panel panel-default">
               
                <div class="panel panel-default">
                    
                    <div class="panel-body" style="align-content: center;">
                        <a href="<?php echo base_url('asset/excel/format.xlsx') ?>" download="download"><button class="btn btn-success"> Download Excel Format</button></a>
                        <form class="form-inline" method="post" action="<?php echo site_url('admin/excel_upload'); ?>" enctype="multipart/form-data" onSubmit="return validate();">
                          <div class="form-group mb-2">
                            <input type="file" required="required"  class="form-control-plaintext" id="excel" name="excel">
                          </div>
                          <span class="red"><?php echo form_error('image'); ?></span>
                          <button type="submit" class="btn btn-success mb-2 save" name="uploadFile" value="UPLOAD">Save</button>
                        </form>
                    </div>
                </div>

                
            </div>
            <!-- /.panel -->
        </div>
      
    </div>
    <!-- /.row -->
</section>
</div>
