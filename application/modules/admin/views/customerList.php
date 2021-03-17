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
            Customer List
        </h1>
    </section>

<section class="content">
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">

                <div class="panel-heading">


                    <a class="btn btn-primary" href="<?php echo site_url('admin/customer_register/')?>"><i class="fa fa-th-list"><span class="text-align">Add Customer</span></i></a>

                    </div>
                <!-- Start Select filter status -->

                <div style="padding-left: 15px;padding-top: 17px;">
                     <p id="selectTriggerFilter"><label style="padding-right: 10px;"><b>Search By Status :</b></label></p>
                </div>

                 <!-- End Select filter status -->
                <div class="panel-body">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="table-responsive">

                                <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="users">

                                    <thead>

                                        <tr class="bg-primary">

                                            <th>Sr no.</th>

                                           
                                            <th>Full Name</th>
                                            <th>Email</th>

                                            <th>Mobile</th>

                                            <th>Gender</th>

                                            <th>Status</th>

                                           
                                            <th>Action</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php $i=1; 
                                         if(!empty($users)){ 
                                            foreach($users as $users_list){?>

                                        <tr id="tr_<?php echo $i;?>">

                                            <td>

                                                <?php echo $i; ?> 
                                            </td>
                                            <td>
                                                <?php echo $users_list->username; ?>
                                            </td>
                                            <!-- <td>

                                                <?php //echo ucfirst($users_list->first_name);?></td>

                                            <td>

                                                <?php //echo ucfirst($users_list->last_name);?> </td>

                                            --><td> 

                                                <?php echo $users_list->email;?> </td>

                                            <td>

                                                <?php echo $users_list->phone_no;?> </td>

                                            <td>

                                                <?php echo $users_list->gender;?> </td>

                                            <td>

                                                <?php if($users_list->is_verified==1){ 
                                                    echo 'Verified';
                                                }else{ 
                                                  echo 'Not Verified';} ?> 
                                            </td>

                                           
                                            <td>

                                                 <a href="<?php echo site_url('admin/customer_register/'.$users_list->id)?>" class="btn btn-success"><i class="fa fa-edit"></i></a> 

                                                <a href="javascript:void(0)" onclick="delete_user('<?php echo $users_list->id?>','<?php echo $i;?>')" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                                <?php if($users_list->is_verified==0){ ?>
                                                    <a title="Update" href="javascript:void(0)" onclick="update_status('<?php echo $users_list->id;?>','1','<?php echo $i;?>')" class="btn btn-danger"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>
                                               <?php }else{ ?>
                                                    <a title="Update" href="javascript:void(0)" onclick="update_status('<?php echo $users_list->id;?>','0','<?php echo $i;?>')" class="btn btn-primary"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>

                                                <?php } ?>
                                             </td>
                                            
                                          

                                        </tr>

                                       <?php $i++; } } ?> </tbody>

                                </table>

                            </div>

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
 var table = $('#users').DataTable( {
    responsive: true,
        colReorder: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1], /* 1st one, start by the right */

        }],
         columns: [
      {name: 'Sr no.'},
      {name: 'Full Name'},
      {name: 'Email'},
      {name: 'Mobile'},
      {name: 'Gender'},
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
      var column = this.api().column(5);

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



function delete_user(id, tr_id) {

    swal({

        title:"Are you sure?",

        text: "want to delete?",

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

                table: 'users'

            },

            type: "POST"

        }).done(function(data) {

            swal("Deleted!", "Record was successfully deleted!", "success");

            $('#tr_' + tr_id).remove();

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
            url: "<?php echo site_url('admin/verify_user')?>",
            data: {
                id: id,
                status:status,
                table:'users'
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