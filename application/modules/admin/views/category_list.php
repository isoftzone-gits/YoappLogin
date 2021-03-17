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
            Category List
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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('admin/category')?>"><i class="fa fa-th-list"><span class="text-align">Add Category</span></i></a> </div>
                
                 <!-- Start Select filter status -->

                <div style="padding-left: 15px;padding-top: 17px;">
                     <p id="selectTriggerFilter"><label style="padding-right: 10px;"><b>Search By Status :</b></label></p>
                </div>

                 <!-- End Select filter status -->
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="appointment">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Sr. no</th>
                                    <th>Name</th>
                                    <th>Sequence</th>
                                    <!-- <th>Description</th> -->
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                   </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count=1;
                                if(isset($category)){
                                foreach ($category as  $value) { ?>
                                <tr class="odd gradeX" id="tr_<?php echo $count;?>">
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                    <td>
                                        <?php  echo $value->category_name;?>
                                    </td>
                                    <td>
                                        <?php echo $value->sequence; ?>
                                    </td>
                                    
                                    <!-- <td>
                                        <?php //echo $value->category_description; ?>
                                    </td> -->
                                    <td>
                                        <?php if(!empty($value->category_image)){ ?>
                                        <img src="<?php echo base_url('asset/uploads/').$value->category_image; ?>" width="50px" height="50px">
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($value->status==0){
                                            echo "InActive";
                                        }else{
                                            echo "Active";
                                        } ?>
                                    </td>
                                   
                                    <td class="center">
                                     <a title="Edit" href="<?php echo site_url('admin/category/').$value->id; ?>" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                       <!-- <a title="Delete" href="javascript:void(0)" onclick="delete_category('<?php echo $value->id;?>','<?php echo $count;?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a> -->

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

    $(document).ready(function() {
 var table = $('#appointment').DataTable( {
    responsive: true,
        colReorder: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1], /* 1st one, start by the right */

        }],
         columns: [
      {name: 'Sr. no'},
      {name: 'Name'},
      {name: 'Sequence'},
      {name: 'Image'},
      {name: 'Status'},
      {name: 'Action'},
      
      
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
        ],

        // Start Select filter status

     initComplete: function() {
      var column = this.api().column(4);

      var select = $('<select style="width:200px;display: inline-block;" class="filter form-control"><option value="">all</option></select>')
        .appendTo('#selectTriggerFilter')
        .on('change', function() {
          var val = $(this).val();
          column.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
          //column.search(val).draw()
        });

       //var offices = []; 
       // column.data().toArray().forEach(function(s) {
       //      s = s.split(',');
       //    s.forEach(function(d) {
       //      if (!~offices.indexOf(d)) {
       //          offices.push(d)
       //          //alert(val);
       //        select.append('<option value="' + d + '">' + d + '</option>');                         
       //    }
       //    })
       // })    
              
      column.data().unique().sort().each(function(d) {
        select.append('<option value="' + d + '">' + d + '</option>');
      });
     
    }

     // End Select filter status
     
    } );
  } );

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
                table:'category'
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

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>