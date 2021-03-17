<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>YoApp | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.4.1 -->
  <link href="<?php echo base_url('asset/vendor/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url('asset/vendor/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
  <link href="<?php echo base_url('asset/vendor/bootstrap/css/AdminLTE.min.css');?>" rel="stylesheet">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="icon" 
      type="image/png" 
      href="<?php echo base_url('asset/default_images/yoapp.png');?>" />
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <?php if(!empty($logo)){ ?>
      <img src="<?php echo base_url('asset/uploads/'.$logo.'');?>"  style="height:130px;width: 130px;">
    <?php }else{ ?>
    <img src="<?php echo base_url('asset/default_images/yoapp.png');?>"  style="height:130px;width: 130px;">
    <?php } ?>
  </div>

  <?php if(validation_errors()){?>
    <div class="alert alert-danger" style="font-size: 15px;">
        <?php echo validation_errors(); ?>
    </div>
    <?php }if(!empty($msg)){?>
    <div class="alert alert-success" style="font-size: 15px;">
        <?php echo $msg;?>
    </div>
  <?php }?>


  <div class="login-box-body">
    <div class="login-logo">
      <b style="color: #444;"><?php if(!empty($name)){ echo $name; } ?></b>
    </div>
    <!-- /.login-logo -->

    <p class="login-box-msg">Sign in to start your session</p>

    <form action="<?php echo site_url('admin/verifylogin')?>" method="post">
      <label for="name">Username:</label>
      <div class="form-group has-feedback">
        <input type="name" id="username" name="username" autocomplete="off" class="form-control" placeholder="Username" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <label for="password">Password:</label>
      <div class="form-group has-feedback">
        <input type="password" id="password" name="password" atuocomplete="off" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <input type="submit" value="Login" name="submit" class="btn btn-primary btn-flat">
        </div>
        <div class="col-xs-8">
          <a href="<?php echo site_url('admin/forgot_password'); ?>">Forgot Password ?</a>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('asset/js/jquery.min.js')?>"></script>
<!-- Bootstrap 3.4.1 -->
<script src="<?php echo base_url('asset/vendor/bootstrap/js/bootstrap.min.js');?>"></script>

</body>
</html>
