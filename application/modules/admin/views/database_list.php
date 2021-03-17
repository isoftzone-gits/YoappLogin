<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Database List
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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('admin/database')?>"><i class="fa fa-th-list"><span class="text-align">Add DataBase</span></i></a> </div>
                
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="appointment">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Sr. no</th>
                                    <th>Site Name</th>
                                    <th>User Name</th>
                                    <!-- <th>Description</th> -->
                                    <th>Database Name</th>
                                    <th>Password</th>
                                    <th>Action</th>
                                   </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count=1;
                                if(isset($database)){
                                foreach ($database as  $value) { ?>
                                <tr class="odd gradeX" id="tr_<?php echo $count;?>">
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                    <td>
                                        <?php  echo $value->site_name;?>
                                    </td>
                                    <td>
                                        <?php echo $value->db_username; ?>
                                    </td>
                                    
                                    <td>
                                        <?php echo $value->db_name; ?>
                                    </td> 

                                    <td>
                                        <?php echo $value->db_password; ?>
                                    </td> 
                                    
                                   
                                    <td class="center">
                                     <a title="Edit" href="<?php echo site_url('admin/database/').$value->id; ?>" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                       
                                    
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


</script>