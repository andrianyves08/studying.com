<?php 
  function changetimefromUTC($time, $timezone) {
    $changetime = new DateTime($time, new DateTimeZone('UTC'));
    $changetime->setTimezone(new DateTimeZone($timezone));
    return $changetime->format('M j, Y h:i A');
  }

  function time_elapsed_string($time, $timezone, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($time, new DateTimeZone('UTC'));
    $now->setTimezone(new DateTimeZone($timezone));
    $ago->setTimezone(new DateTimeZone($timezone));
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
      'y' => 'year',
      'm' => 'month',
      'w' => 'week',
      'd' => 'day',
      'h' => 'hour',
      'i' => 'minute',
      's' => 'second',
    );

    foreach ($string as $k => &$v) {
      if ($diff->$k) {
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
      } else {
        unset($string[$k]);
      }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
  }

  function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Studying.com Admin</title>
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
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" type="text/css">
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url('/assets/plugins/toastr/toastr.min.css'); ?>">
  <script src="<?php echo base_url('/assets/plugins/toastr/toastr.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?php echo base_url('/assets/plugins/select2/css/select2.min.css'); ?>">
  <script src="<?php echo base_url();?>assets/admin/plugins/ckeditor/ckeditor.js"></script>


  <script src="<?php echo base_url('assets/plugins/nanogallery2/dist/jquery.nanogallery2.j');?>s"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/nanogallery2/dist/css/nanogallery2.min.cs');?>s">
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
</style>
</head>
<body class="grey lighten-3">
<script type="text/javascript">
$(document).ready(function() {
  var offset = new Date().getTimezoneOffset(), o = Math.abs(offset);
  var timezone = (offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2);
  $.ajax({
    type: "post",
    url:"<?=base_url()?>admin/timezone",
    data:{timezone:timezone},
    success: function(){
    }
  });
});
</script>