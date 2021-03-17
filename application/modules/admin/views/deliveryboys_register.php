<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Add Delivery Boys
        </h1>
    </section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a class="btn btn-primary" href="<?php echo site_url('admin/deliveryboysList')?>"><i class="fa fa-th-list"><span class="text-align">deliveryboys List</span></i></a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php if(isset($details)){ echo site_url('admin/deliverboys_register/'.$details[0]->id); }else{ echo site_url('admin/deliverboys_register'); }?>" class="registration_form12" enctype="multipart/form-data">

                                <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3">Full Name *</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" placeholder="Full Name" name="user_name" autocomplete="off" value="<?php echo !empty($details[0]->username)?$details[0]->username:'';?>">
                                                <span class="red"><?php echo form_error('user_name'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3">Email Address *</label>
                                            <div class="col-md-9">
                                                <input type="text" name="email" class="form-control" placeholder="Email Address" autocomplete="off" value="<?php echo !empty($details[0]->email)?$details[0]->email:'';?>">
                                                <span class="red"><?php echo form_error('email'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               

                                <div class="box-body">
                                <?php //if(isset($details)){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3">Password *</label>
                                            <div class="col-md-9">
                                                <input type="Password" class="form-control" id="password" name="password" placeholder="Password">
                                                <span class="red"><?php echo form_error('password'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php //} ?>
                                
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3">Date of Birth*</label>
                                            <div class="col-md-9">
                                                <input type="text" id="datepicker" name="dob" class="form-control date" autocomplete="off" value="<?php echo !empty($details[0]->date_of_birth)?$details[0]->date_of_birth:'';?>" placeholder="Date of Birth">
                                                <span class="red"><?php echo form_error('dob'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3">Phone No</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="phone_no" placeholder="Phone Number" autocomplete="off" value="<?php echo !empty($details[0]->phone_no)?$details[0]->phone_no:'';?>">
                                                <span class="red"><?php echo form_error('phone_no'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3">Picture</label>
                                            <div class="col-md-9">
                                                <input type="file" name="image" id="image" class="form-control">
                                                <span class="red"><?php echo form_error('image'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               <!-- <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="formas">
                                            <label class="col-md-3">User Role</label>
                                            <div class="col-md-9">
                                            <input type="text" class="form-control" name="user_role" placeholder="User_role" autocomplete="off" value="<?php echo !empty($details[0]->user_role)?$details[0]->user_role:'';?>">
                                                <span class="red"><?php echo form_error('phone_no'); ?></span>
                                            </div>
                                            <span class="red"><?php echo form_error('user_role'); ?></span>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="clearfix"></div>

                                <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3">Gender *</label>
                                            <div class="col-md-9">
                                                <label class="radio-inline">
                                                    <input type="radio" name="gender" value="male" <?php if(isset($details) && $details[0]->gender=='male'){echo 'checked';} ?>>Male
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="gender" value="female"<?php if(isset($details) && $details[0]->gender=='female'){echo 'checked';} ?>>Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3">Status</label>
                                            <div class="col-md-9">
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" value="1" <?php if(isset($details) && $details[0]->is_verified=='1'){echo 'checked';} ?>>Verified
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" value="0" <?php if(isset($details) && $details[0]->is_verified=='0'){echo 'checked';} ?>>Not Verified
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3">Address</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" rows="5" name="address" placeholder="Address"><?php if(isset($details)){ echo $details[0]->address;} ?></textarea>
                                                <span class="red"><?php echo form_error('address'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12" align="center">
                                    <input type="submit" name="submit" class="btn btn-success" value="Save">
                                    <input type="reset" class="btn btn-default" value="Reset">
                                </div>
                            </form>
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
    $('select').niceSelect();
});
</script>