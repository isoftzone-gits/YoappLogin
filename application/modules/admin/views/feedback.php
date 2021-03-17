<link href="https://nightly.datatables.net/colreorder/css/colReorder.dataTables.css?_=b5e1f72100ce548dc8ad3fd6e4211bad.css" rel="stylesheet" type="text/css" />
    <script src="https://nightly.datatables.net/colreorder/js/dataTables.colReorder.js?_=b5e1f72100ce548dc8ad3fd6e4211bad"></script>
    <style type="text/css">
        div.dt-button-collection button.dt-button.active:not(.disabled){
             

    background-image: linear-gradient(to bottom, #337ab7 0%, #337ab7 100%) !important;
  
 
    color: #fff !important;
   
        }
        button.dt-button.dt-button.active:not(.disabled):hover:not(.disabled){
            background-image: linear-gradient(to bottom, #eaeaea 0%, #ccc 100%) !important;
            color: #000 !important;
        }
    </style>
<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            deliveryboys feedback
        </h1>
        <div class="loader" style="display: none;"></div>
    </section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div id="show_messgae" class="alert alert-success" style="display: none;"></div>
            <?php if ($info_message = $this->session->flashdata('info_message')): ?>
            <div id="form-messages" class="alert alert-success" role="alert">
                <?php echo $info_message; ?>
            </div>
            <?php endif ?>
            <div class="panel panel-default">
              
                <br/><br/>
                <div class="col-md-12 filter-1">
                    <form action="<?php echo site_url('admin/search_order')?>" method="POST">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 ">From </label>
                                <div class="col-md-8">
                                    <input type="text" id="from_date" name="from_date" class="form-control date" autocomplete="off"  placeholder="From date">
                                    <span class="red"><?php echo form_error('from_date'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 ">To </label>
                                <div class="col-md-8">
                                     <input type="text" id="to_date" name="to_date" class="form-control date" autocomplete="off"  placeholder="To Date">
                                    <span class="red"><?php echo form_error('to_date'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="submit" name="submit" value="GO" class="btn btn-primary">
                        </div>
                    </form>
                </div>
             

               
                <div class="clearfix"></div>
                <hr>
                <!-- /.panel-heading -->
                <div class="panel-body">
              
                    <div class="table-responsive">
                        <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="appointment">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Sr. no</th>
                                    <!-- <th>user_id</th> -->
                                    <th>Username</th>
                                    <th>Images</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                   </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $count=0;
                                if(isset($feedback)){
                                foreach ($feedback as  $value) { $count++;  ?>
                                <tr class="odd gradeX" id="tr_<?php echo $count;?>">
                                    <td>
                                        <?php echo $count; ?>
                                    <!-- <td>
                                        <?php // echo $value->user_id;?>
                                    </td> -->
                                    <td>
                                        <?php echo $value->username; ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($value->image)){ ?>
                                        <img src="<?php echo base_url('asset/uploads/').$value->image; ?>" width="50px" height="50px">
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php echo $value->description; ?>
                                    </td>
                                    <td>
                                        <?php echo $value->created_at; ?>
                                    </td>
                                   </tr>
                                <?php
                                } 
                                
                            }   
                            ?> </tbody>
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
     $(document).ready(function() {


        var table = $('#appointment').DataTable({
        responsive: true,
        colReorder: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1], /* 1st one, start by the right */

        }],
         columns: [
      {name: 'Sr. no'},
      {name: 'User Id'},
      {name: 'Name'},
      {name: 'Images'},
      {name: 'Description'},
      {name: 'Date'}
    ],
   
       dom: 'Bfrtip',
        buttons: [
        {
                extend:    'pageLength',
                titleAttr: 'Registros a mostrar',
                className: 'selectTable'
              },
        {
            extend: 'csvHtml5',
            text: 'Csv',
            exportOptions: {
                 columns: [ 0, ':visible' ],
                modifier: {
                    search: 'none'
                }
            }
        },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ]
    });
        $('#status').on('change', function() {
            console.log('fff');
            table.draw();
        } );

   
     });

    // $('#appointment thead th').each( function () {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    // } );
    

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

function change_status(order_id,el,user_id){
      //  var order_id  = $('#order_id').val();
        var status  = $(el).val();
        $.ajax({
            url: "<?php echo site_url('admin/change_order_status') ?>",
            type: 'POST',
            data: {
                order_id: order_id,
                status:status,
                user_id:user_id
            },
            beforeSend: function() {
                // setting a timeout
               // $(placeholder).addClass('loading');
            },
            success: function(data) {
            $('#show_messgae').show();
            $('#show_messgae').html("Order Status Changes successfully")
            .hide()
            .fadeIn(5000, function() { $('#show_messgae').hide(); });
                //window.location.href='<?php echo site_url('admin/order_delivery') ?>';
            }
        });
    }


    $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var status = $('#status').val();
        if(status=='select' || status==undefined){
            return true;
        }
        if(status==data[13]){
            return true;
        }
        else{
            return false;
        }
        // if ( ( isNaN( min ) && isNaN( max ) ) ||
        //      ( isNaN( min ) && age <= max ) ||
        //      ( min <= age   && isNaN( max ) ) ||
        //      ( min <= age   && age <= max ) )
        // {
        //     return true;
        // }
        // return false;
    }
);  


</script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>
