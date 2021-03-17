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
            Orders 
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
                <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2">Search By Status </label>
                                <div class="col-md-4">
                                    <select name="status" id="status" class="form-control">
                                        <option value="select">All</option>
                                        <option value="placed">Placed</option>
                                        <option value="progress">Progress</option>
                                        <option value="dispatched">Dispatched</option>
                                        <option value="cancel">Cancel</option>
                                    </select>
                                </div>
                            </div>
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
                                    <th>Action</th>
                                    <th>Bill No</th>
                                    <th>Date</th>
                                    <th>Payment Status</th>
                                    <th>Change Status</th>
                                    <th>User Name</th>
                                    <th>Mobile No.</th>
                                    <th>Orders</th>
                                    <th>Total Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Area</th>
                                    <th>Address</th> 
                                    <th>Status</th>
                                   </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count=1;
                                $total_quantity = 0;
                                $total_amount= 0;
                                if(isset($order_list)){
                                foreach ($order_list as  $value) { ?>
                                <tr class="odd gradeX" id="tr_<?php echo $count;?>">
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                    <td class="center">
                                      <a title="Edit" href="<?php echo site_url('admin/order_details/').$value->id; ?>" class="btn btn-primary">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                      </a>
                                       
                                    </td>
                                    <td><?php echo "Order No - $value->id"; ?></td>
                                    <td>
                                        <?php echo $value->created_at; ?>
                                    </td>
                                    <td><?php  if($value->txStatus=='SUCCESS'){
                                        echo 'SUCCESS';
                                    }else{
                                       echo  'COD';
                                    } ?></td>
                                    <td>
                                        <input type="hidden" id="order_id" value="<?php echo $value->id; ?>">
                                        
                                        
                                        <select class="form-control" onchange="change_status(<?php echo $value->id; ?>,this,<?php echo $value->user_id; ?>)" id="order_status">
                                            <option value="placed" <?php if($value->status=='placed'){ echo 'selected';} ?>>placed</option>
                                           
                                            <option value="progress" <?php if($value->status=='progress'){ echo 'selected';} ?>>Progress</option>
                                            <option value="dispatched" <?php if($value->status=='dispatched'){ echo 'selected';} ?>>Dispatched</option>
                                            <option value="delivered" <?php if($value->status=='delivered'){ echo 'selected';} ?>>delivered</option>
                                            <option value="cancel" <?php if($value->status=='cancel'){ echo 'selected';} ?>>Cancel</option>
                                        </select>
                                        <!-- <?php echo $value->status; ?> -->
                                    </td>
                                    <td>
                                        <?php  echo $value->username;?>
                                    </td>
                                    <td>
                                        <?php echo $value->phone_no; ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($value->order_items)){
                                            $total_quantity = 0;
                                            $total_amount= 0;
                                            foreach ($value->order_items as $skey => $svalue) {
                                                echo $svalue->product_name.'-'.$svalue->product_attribute." "."-"." "."Qty"."-".$svalue->qtyTotal."<br>";
                                                $total_quantity = $total_quantity + $svalue->qtyTotal;
                                                $total_amount   = $total_amount + $svalue->totalAmt;
                                            }
                                        } ?>
                                    </td>
                                    <td><?php echo $total_quantity; ?></td>
                                    <td><?php echo round(($total_amount+$value->shipping_rate)-$value->discount_amount,2); ?></td>
                                    <td><?php 
                                    if($value->delivery_type=='Self Pickup'){
                                        echo "Self Pickup";
                                    }else{

                                    echo $value->place_name; }?>
                                    
                                    </td>
                                     <td style="word-break: break-all;">
                                       
                                        <?php  
                                        if($value->delivery_type=='Self Pickup'){
                                        echo "Self Pickup";
                                    }else{

                                        echo $value->address;} ?>
                                    
                                    </td> 
                                    
                                    
                                    

                                    <td><?php echo $value->status; ?></td>
                                   </tr>
                                <?php
                                } 
                                 $count++; 
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
      {name: 'Action'},
      {name: 'Bill No'},
      {name: 'Date'},
      {name: 'Payment Status'},
      {name: 'Change Status'},
      {name: 'User Name'},
      {name: 'Mobile No.'},
      {name: 'Orders'},
      {name: 'Total Quantity'},
      {name: 'Total Amount'},
      {name: 'Area'},
      {name: 'Address'},
      {name: 'Status'}
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
                //window.location.href='<?php echo site_url('admin/orders') ?>';
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
