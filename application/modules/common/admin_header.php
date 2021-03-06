<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <script src="<?php echo base_url('asset/js/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('asset/js/jquery-ui.js');?>"></script>
    <script src="<?php echo base_url('asset/js/cropper.js');?>"></script>
    <script src="<?php echo base_url('asset/dist/js/jquery.nice-select.min.js');?>"></script>
    <script src="<?php echo base_url('asset/vendor/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('asset/js/datatable.js')?>"></script>
    <script src="<?php echo base_url('asset/js/jscolor.js')?>"></script>
    <script src="<?php echo base_url('asset/js/timepicker.js')?>"></script>
    <script src="<?php echo base_url('asset/ckeditor/ckeditor.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/validation.js');?>"></script>
    <script src="<?php echo base_url('asset/dist/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('asset/dist/js/sweetalert.min.js')?>"></script>
    <script src="<?php echo base_url('asset/dist/js/dataTables.rowReorder.min.js')?>"></script>
    <script src=" https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js
"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js
"></script>
   
    <script src="<?php //echo base_url('asset/dist/js/dataTables.responsive.min.js')?>"></script>
    <script src="<?php echo base_url('asset/vendor/metisMenu/metisMenu.min.js');?>"></script>
    <script src="<?php echo base_url('asset/dist/js/sb-admin-2.js');?>"></script>
    <script src="<?php echo base_url('asset/dist/js/bootstrap-datepicker.js')?>"></script>
    <!-- <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url('asset/dist/js/custom.js')?>"></script>


    <!-- <link href="https://fonts.googleapis.com/css?family=Bellefair&amp;subset=hebrew,latin-ext" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
    <link href="<?php echo base_url('asset/jquery-ui.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendor/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- <link href="<?php //echo base_url('asset/vendor/bootstrap/css/bootstrap.min.css 3.4.1');?>" rel="stylesheet"> -->
    <link href="<?php echo base_url('asset/vendor/bootstrap/css/AdminLTE.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendor/bootstrap/css/_all-skins.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendor/metisMenu/metisMenu.min.css');?>" rel="stylesheet">
    <!-- <link href="<?php echo base_url('asset/dist/css/sb-admin-2.css');?>" rel="stylesheet"> -->

    <link href="<?php echo base_url('asset/dist/css/cropper.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/vendor/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/timepicker.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/dataTables.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/dist/css/nice-select.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/dist/css/sweetalert.min.css')?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('asset/dist/css/rowReorder.dataTables.min.css')?>">
    <link href="<?php echo base_url('asset/dist/css/responsive.dataTables.min.css')?>">
    <link href="<?php echo base_url('asset/dist/css/datepicker.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/dist/css/dataTables.bootstrap.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/dist/css/bootstrap-datetimepicker.min.css')?>">
    
    <link href="<?php echo base_url('asset/vendor/bootstrap/css/style.css');?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css
">

<link rel="stylesheet" type="text/css" href="https://foliotek.github.io/Croppie/croppie.css">
<script src="https://foliotek.github.io/Croppie/croppie.js"></script>
<style type="text/css">
    .nice-select.wide .list {
        
        height: 150px !important;
        overflow-y: auto !important;
}
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

