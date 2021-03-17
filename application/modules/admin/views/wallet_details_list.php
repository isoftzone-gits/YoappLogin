<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Wallet Details List
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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('admin/wallet_details')?>"><i class="fa fa-th-list"><span class="text-align">Add WALLET DETAILS</span></i></a> </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="appointment">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Sr. no</th>
                                    <th>TYPE</th>
                                    <th>AMOUNT</th>
                                    <th>Wallet From</th>
                                    <th>Wallet To</th>
                                    <th>STATUS</th>
                                    <th>Action</th>
                                   </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count=1;
                                if(isset($wallet_details)){
                                foreach ($wallet_details as  $value) { ?>
                                <tr class="odd gradeX" id="tr_<?php echo $count;?>">
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                    <td>
                                        <?php  echo $value->wallet_type;?>
                                    </td>
                                    <td>
                                        <?php echo $value->amount; ?>
                                    </td>
                                    
                                    <td>
                                        <?php echo $value->valid_from; ?>
                                    </td> 

                                    <td>
                                        <?php echo $value->valid_to; ?>
                                    </td> 
                                   
                                    <td>
                                        <?php if($value->status==0){
                                            echo "InActive";
                                        }else{
                                            echo "Active";
                                        } ?>
                                    </td>
                                   
                                    <td class="center">
                                     <a title="Edit" href="<?php echo site_url('admin/wallet_details/').$value->id; ?>" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                     <?php if($value->status==0){ ?>
                                            <a title="Update" href="javascript:void(0)" onclick="update_status('<?php echo $value->id;?>','1','<?php echo $count;?>')" class="btn btn-danger"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>
                                       <?php }else{ ?>
                                            <a title="Update" href="javascript:void(0)" onclick="update_status('<?php echo $value->id;?>','0','<?php echo $count;?>')" class="btn btn-primary"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>

                                        <?php } ?>

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

    $('#appointment').DataTable({
        responsive: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
        }]
    });

function delete_category(id,tr_id) {
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
                table:'category'
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

function update_status(id,status,tr_id) {
    swal({
        title: "Are you sure?",
        text: "you want to change Status?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: "Yes",
        confirmButtonColor: "#ec6c62"
    }, function() {
        $.ajax({
            url: "<?php echo site_url('admin/update_status')?>",
            data: {
                id: id,
                status:status,
                table:'wallet_details'
            },
            type: "POST"
        }).done(function(data) {
            swal("Success", "Status Change Successfully", "success");
            window.location.reload();
            //$('#tr_' + tr_id).remove();
        }).error(function(data) {
            swal("Oops", "We couldn't connect to the server!", "error");
        });
    });
}

</script>