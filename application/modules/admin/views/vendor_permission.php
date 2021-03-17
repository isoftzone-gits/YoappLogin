<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Vendor Permission
        </h1>
    </section>

<section class="content">
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">

                <div class="panel-heading">


                    <!-- <a class="btn btn-primary" href="<?php echo site_url('admin/customer_register/')?>"><i class="fa fa-th-list"><span class="text-align">Add Customer</span></i></a> -->

                    </div>

                <div class="panel-body">

                    <div class="row">

                        <div class="col-lg-12">
                        <div class="row">
                        <div class="col-md-6">
                        <?php if(!empty($users)) ?>
                        <h3><i class="fa fa-user">Persional Detail</i></h3><br>
                          <?php $i = 0;
                           foreach($users as $val){ 
                                $i++ ?>
                             <label>Vendor Name:</label>
                             <?php echo $val->username; ?>
                            <br> <label>Email:</label>
                             <?php echo $val->email; ?>
                             <br> <label>Phone No.:</label>
                             <?php echo $val->phone_no; ?>
                        </div>
                        <div class="col-md-6">
                        <h3><i class="fa fa-building">Company Detail</i></h3><br>
                        <label>Company Name:</label>
                        <?php echo $val->company_name; ?>
                       <br> <label>Contact No.:</label>
                        <?php echo $val->phone_no; ?>
                        </div>
                        </div>

                            <div class="table-responsive">

                                <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="users">

                                    <thead>

                                        <tr class="bg-primary">

                                            <th>Sr no.</th>
                                            <th>Permission</th>
                                            <th>Enable</th>
                                            <th>Disable</th>

                                            

                                        </tr>

                                    </thead>
                                      
                                    <tbody>

                                        <tr>
                                            <td>

                                               1
                                            </td>
                                            <td>
                                                User Login account
                                            </td>
                                            
                                            <td>
                                                <input type="radio" name="r1"><br>
                                                
                                            </td>
                                            <td>
                                                <input type="radio" name="r1">
                                            </td>
                                            </tr>
                                            <td>
                                             2
                                        
                                             </td>
                                            <td>
                                            Subscription Plan
                                            </td>
                                            <td>
                                                <input type="radio" name="r2"><br>
                                                <a type="button" id="res" class="btn btn-success" ><i class="fa fa-edit"></i></a> 
                                                <a href="<?php echo site_url('admin/vendorList/')?>"  class="btn btn-success" >back</a> 
                                                
                                            </td>
                                            <td>
                                                <input type="radio" name="r2">
                                            </td>
                                            </tr>
                                    </tbody>
                                   <?php } ?>
                                  
                                </table>
                                  <!-- Modal -->
                 <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Subcription detail</h4>
      </div>
      <div class="modal-body">
      <div class="row">
     <div class="col-md-12">
     <!-- <div style="display: inline-flex;">
     Order No.- <p class="order_no"></p>
     </div> -->
     <div class="table-responsive">
    <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="appointment">
    <thead>
    <th>Sr No.</th>
    <th>Subcription Date</th>
    <th>Remaining Days</th>
    <th>Expiry Date</th>
    </thead>
    <tbody>
    <tr>
    <td>
    <?php echo $i; ?>
    </td>
    <td>
    <?php 
     $createDate = new DateTime($val->created_at);
     $strip = $createDate->format('Y-m-d');
     $date1 = strtotime($strip);
     $date2 = date_create($strip);
    
     echo $strip; ?>
    </td>
    <td>
    <?php
     $res = $val->expire_days;
  $adate = strtotime("+".$res." days", strtotime($strip));
   $newdate = date("Y-m-d", $adate)."\n";
    
  
  $date3 = strtotime($newdate);
   $diff = abs($date3 - $date1);
  $years = floor($diff / (365*60*60*24)); 
 $months = floor(($diff - $years * 365*60*60*24) 
                              / (30*60*60*24));  
                               

 $days = floor(($diff - $years * 365*60*60*24 -  $months*30*60*60*24)/ (60*60*24)); 
  echo $days;
  ?> 
    </td>
    <td>
   <?php echo date("Y-m-d", $adate)."\n"; ?>
    </td>
    </tbody>
    </table>
    <div class="col-md-6">
    <label>Subcription Date</label><br><br>
    <label>Subcription Days</label>
    
    </div>
    <div class="col-md-6">
    <input type="date" id="date" name="date" value="<?php echo $strip; ?>" class="form-control" style="width:155px"><br>
    <input type="text" id="days" name="days" value="<?php echo $days; ?>" class="form-control" style="width:155px">
    </div>
    </div>
     </div>
      </div>
  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="submit"  class="btn btn-default"  onclick="fun(`<?php echo $val->id;?>`)">Submit</button>
        
      </div>
    </div>
  </div>
</div>

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

// $('#users').DataTable({

//     responsive: true,



// });
$(document).ready(function(){
  $("#res").click(function(){
    $("#myModal").modal();
  });
});






function fun(id){
       // getElementById("recieved").disabled=true;
         var days  = $('#days').val();
         var Data  = {
                       id: id,days:days
                     };
        $.ajax({
            url:"<?php echo base_url('index.php/admin/update_vendor');?>",
            type:"POST",
            data: Data,
            //dataType:'text',
            success:function(res){
              location.reload();
           alert("update successfully");
           

            }
        });
      }




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