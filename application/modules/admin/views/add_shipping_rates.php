<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Shipping Rates
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

                        <form class="form-inline" method="post" action="<?php echo site_url('admin/shipping_rates'); ?>" enctype="multipart/form-data">
                          <div class="form-group mb-2">
                            <input type="text" required="required"  class="form-control" id="from" name="from" placeholder="Distance From in KM">
                          </div>
                          <span class="red"><?php echo form_error('from'); ?></span>

                          <div class="form-group mb-2">
                            <input type="text" required="required"  class="form-control" id="to" name="to" placeholder="Distance To in KM">
                          </div>
                          <span class="red"><?php echo form_error('to'); ?></span>

                          <div class="form-group mb-2">
                            <input type="text" required="required"  class="form-control" id="rate" name="rate" placeholder="Shipping Rate">
                          </div>
                          <span class="red"><?php echo form_error('rate'); ?></span>
                          <button type="submit" class="btn btn-success mb-2">Save</button>
                        </form>
                    </div>
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="shipping">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Sr.no</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                   </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count=1;
                                if(isset($shipping_rates)){
                                foreach ($shipping_rates as  $value) { ?>
                                <tr class="odd gradeX" id="tr_<?php echo $count;?>">
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                   
                                    <td>
                                        <?php echo $value->from; ?>
                                    </td>

                                    <td>
                                        <?php echo $value->to; ?>
                                    </td>

                                    <td>
                                        <?php echo $value->rate; ?>
                                    </td>

                                   
                                    <td class="center">
                                    
                                       <a title="Delete" href="javascript:void(0)" onclick="delete_shipping('<?php echo $value->id;?>','<?php echo $count;?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
    <!-- /.row -->
    </section>
</div>

<script type="text/javascript">

    $('#shipping').DataTable({
        responsive: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
        }]
    });

function delete_shipping(id,tr_id) {
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
                table:'shipping_master'
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