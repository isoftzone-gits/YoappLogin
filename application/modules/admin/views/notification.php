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
        Notifications
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

                        <form class="form-group" method="post" action="<?php echo site_url('admin/notification'); ?>" enctype="multipart/form-data" onSubmit="return validate();">

                          <div class="form-group  col-md-6">
                            <select id="type" name="type" class="form-control">
                                <option value="offers">OFFERS</option>
                                <option value="announcment">ANNOUNCMENT</option>
                            </select>
                          </div>    
                           <span class="red"><?php echo form_error('type'); ?></span>
                          <div class="clearfix"></div>
                          <div class="form-group  col-md-6">
                            <input type="text" required="required"  class="form-control" id="Title" name="title" placeholder="notification title">
                          </div>
                           <span class="red"><?php echo form_error('title'); ?></span>
                          <div class="clearfix"></div>
                          <div class="form-group  col-md-6">
                            <input type="text" required="required"  class="form-control" id="message" name="message" placeholder="notification message">
                          </div>
                          <span class="red"><?php echo form_error('message'); ?></span>
                          <div class="clearfix"></div>
                          <div class="form-group col-md-6">
                            <input type="file" name="image" id="image" accept="image/x-png,image/jpeg">
                                
                            </div>
                                <span class="red" id="image_error"><?php echo form_error('image'); ?></span>

                            <div class="clearfix"></div>
                          <div class="form-group col-md-6">
                          <button type="submit" class="btn btn-success mb-2" name="uploadFile" value="UPLOAD">Save</button>
                      </div>
                        </form>
                    </div>
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="banners">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Sr.no</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                   </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count=1;
                                if(isset($notification)){
                                foreach ($notification as  $value) { ?>
                                <tr class="odd gradeX" id="tr_<?php echo $count;?>">
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                    <td>
                                        <?php echo $value->type; ?>
                                    </td> 
                                    <td>
                                        <?php echo $value->title; ?>
                                    </td> 
                                    <td>
                                        <?php echo $value->message; ?>
                                    </td>  
                                    <td>
                                      <?php echo $value->created_at; ?>
                                    </td>               
                                   
                                    <td class="center">
                                    
                                       <a title="Delete" href="javascript:void(0)" onclick="delete_category('<?php echo $value->id;?>','<?php echo $count;?>')" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
        <div id="myModal" class="modal">
                          <span class="close">&times;</span>
                          <img class="modal-content" id="img01">
                          <div id="caption"></div>
                        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</section>
</div>

<script type="text/javascript">
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
                table:'notification'
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

 function validate() {
  $("#image_error").html("");
 // $(".demoInputBox").css("border-color","#F0F0F0");
  var file_size = $('#image')[0].files[0].size;
  if(file_size>300000) {
    $("#image_error").html("File size is greater than 300kb");
  //  $(".demoInputBox").css("border-color","#FF0000");
    return false;
  } 
  return true;
}
</script>

<script type="text/javascript">
     $(document).ready(function() {


        var table = $('#banners').DataTable({
        responsive: true,
        colReorder: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1], /* 1st one, start by the right */

        }],
         columns: [
      {name: 'Sr. no'},
      {name: 'Type'},
      {name: 'Title'},
      {name: 'Message'},
      {name: 'Date'},
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
        ]
    });
        

   
     });

    // $('#appointment thead th').each( function () {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    // } );
    






  


</script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>
