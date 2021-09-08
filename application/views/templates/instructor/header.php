<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Instructor <?php echo $title; ?></title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url('/assets/admin/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="<?php echo base_url('/assets/admin/css/mdb.min.css'); ?>" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="<?php echo base_url('/assets/admin/css/style.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/admin/css/addons/datatables.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/admin/css/addons/datatables-select.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/admin/plugins/rowreorder/css/rowReorder.dataTables.min.css'); ?>" rel="stylesheet">
  <link rel="icon" href="<?php echo base_url('/assets/img/logo-1.png'); ?>">
  <!-- JQuery -->
  <script type="text/javascript" src="<?php echo base_url('/assets/admin/js/jquery-3.4.1.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?php echo base_url('/assets/js/jquery-ui-1.12.1/jquery-ui.css'); ?>" type="text/css">
  <script src="<?php echo base_url('/assets/js/jquery-ui-1.12.1/jquery-ui.min.js'); ?>"></script>
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/plugins/toastr/toastr.min.css'); ?>">
  <script src="<?php echo base_url('/assets/plugins/toastr/toastr.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?php echo base_url('/assets/plugins/select2/css/select2.min.css'); ?>">
  <script src="<?php echo base_url();?>assets/admin/plugins/ckeditor/ckeditor.js"></script>
  <script src="<?php echo base_url();?>assets/plugins/table/jquery.tabledit.js"></script>

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<style>
.modal {
  overflow-y:auto;
}

.map-container{
  overflow:hidden;
  padding-bottom:56.25%;
  position:relative;
  height:0;
}

.map-container iframe{
  left:0;
  top:0;
  height:100%;
  width:100%;
  position:absolute;
}
* {
  margin: 0;
  padding: 0;
}
html, body {
  height: 100%;
  width: 100%;
}

main {
  min-height: 100%;
}
.customcolorbg{
  background-color: #4E54C6;
}

@media (max-width:1199.98px){
  .sidebar-fixed{
    display:none
  }
}

p{
  padding: 0 !important;
  margin: 0 !important;
}

.preloader {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100%;
  background: #fff;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 9999;
  opacity: .8;
  transform: opacity 1s linear;
}

.preloader.loaded{
  opacity: 0;
  pointer-events: none;
}
</style>
</head>
<body class="grey lighten-3">